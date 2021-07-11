<?php

namespace Rabble\FieldTypeBundle\Form;

use Rabble\FieldTypeBundle\Event\UploadEvent;
use Rabble\FieldTypeBundle\Model\FileValue;
use Rabble\FieldTypeBundle\VichUploader\PropertyMappingFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File as FileConstraint;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RabbleImageType extends AbstractType
{
    private PropertyMappingFactory $propertyMappingFactory;

    private EventDispatcherInterface $eventDispatcher;
    private ValidatorInterface $validator;

    public function __construct(
        PropertyMappingFactory $propertyMappingFactory,
        EventDispatcherInterface $eventDispatcher,
        ValidatorInterface $validator
    ) {
        $this->propertyMappingFactory = $propertyMappingFactory;
        $this->eventDispatcher = $eventDispatcher;
        $this->validator = $validator;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefault('mimeTypes', []);
        $resolver->setDefault('mimeTypesMessage', null);
        $resolver->setRequired('mapping');
        $resolver->setAllowedTypes('mapping', ['string']);
        $resolver->setAllowedTypes('mimeTypes', ['array']);
        $resolver->setAllowedTypes('mimeTypesMessage', ['null', 'string']);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $fileOptions = [
            'label' => false,
            'required' => false,
        ];
        if ([] !== $options['mimeTypes']) {
            $constraintOptions = ['mimeTypes' => $options['mimeTypes']];
            if (null !== $options['mimeTypesMessage']) {
                $constraintOptions['mimeTypesMessage'] = $options['mimeTypesMessage'];
            }
            $fileOptions['constraints'] = [
                new FileConstraint($constraintOptions),
            ];
        }
        $builder->add('file', FileType::class, $fileOptions);
        $this->setEventListener($builder);
        $this->setTransformer($builder);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $file = $form->getData();
        if (0 < count($form->get('file')->getErrors())) {
            $file = null;
        }
        if (null === $file) {
            $view->vars['image_uri'] = null;
        } else {
            $mappingName = $options['mapping'];
            $mapping = $this->propertyMappingFactory->fromMappingName($mappingName);
            $fileValue = new FileValue($file);
            $view->vars['image_uri'] = rtrim($mapping->getUriPrefix().DIRECTORY_SEPARATOR.$mapping->getUploadDir($fileValue), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$file;
        }
    }

    private function setEventListener(FormBuilderInterface $builder)
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $data = $data['file'] ?? null;
            $form = $event->getForm();
            if ($data instanceof UploadedFile) {
                $violations = $this->validator->validate($data, $form->get('file')->getConfig()->getOption('constraints'));
                if (0 < count($violations)) {
                    return;
                }

                $mappingName = $form->getConfig()->getOption('mapping');
                $mapping = $this->propertyMappingFactory->fromMappingName($mappingName);
                $this->eventDispatcher->dispatch($uploadEvent = new UploadEvent($data, $mapping));
                $file = $uploadEvent->getFile();
                $event->setData(['file' => $file]);
            } else {
                $file = $form->getData();
                if (is_string($file)) {
                    $mappingName = $form->getConfig()->getOption('mapping');
                    $mapping = $this->propertyMappingFactory->fromMappingName($mappingName);
                    $fileValue = new FileValue($file);
                    $dir = rtrim(
                        $mapping->getUploadDestination().DIRECTORY_SEPARATOR.$mapping->getUploadDir($fileValue),
                        DIRECTORY_SEPARATOR
                    );
                    $filePath = $dir.DIRECTORY_SEPARATOR.$file;
                    if (file_exists($filePath)) {
                        $file = new File($filePath);
                    } else {
                        $event->setData(null);
                    }
                }
                if ($file instanceof File) {
                    $event->setData(['file' => $file]);
                }
            }
        });
    }

    private function setTransformer(FormBuilderInterface $builder)
    {
        $builder->addModelTransformer(new CallbackTransformer(
            function ($data) use ($builder) {
                if (is_string($data)) {
                    $mappingName = $builder->getOption('mapping');
                    $mapping = $this->propertyMappingFactory->fromMappingName($mappingName);
                    $fileValue = new FileValue($data);
                    $dir = rtrim($mapping->getUploadDestination().DIRECTORY_SEPARATOR.$mapping->getUploadDir($fileValue), DIRECTORY_SEPARATOR);
                    if (file_exists($dir.DIRECTORY_SEPARATOR.$data)) {
                        $data = [
                            'file' => new File($dir.DIRECTORY_SEPARATOR.$data),
                        ];
                    } else {
                        $data = ['file' => null];
                    }
                }

                return $data;
            },
            function ($data) {
                if (is_array($data) && array_key_exists('file', $data)) {
                    if ($data['file'] instanceof File) {
                        $data['file'] = $data['file']->getFilename();
                    }

                    return $data['file'];
                }

                return $data;
            }
        ));
    }
}
