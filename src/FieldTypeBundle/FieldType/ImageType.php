<?php

namespace Rabble\FieldTypeBundle\FieldType;

use Rabble\FieldTypeBundle\Form\RabbleImageType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractFieldType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('mapping', 'rabble_image');
        $resolver->setAllowedTypes('mapping', ['string']);
    }

    public function buildForm(FormBuilderInterface $builder): void
    {
        $field = $builder->create($this->options['name'], RabbleImageType::class, array_merge([
            'mapping' => $this->options['mapping'],
        ], $this->options['form_options']));
        $builder->add($field);
    }
}
