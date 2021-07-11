<?php

namespace Rabble\FieldTypeBundle\Form;

use Rabble\FieldTypeBundle\FieldType\FieldTypeInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FieldContainerType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('fields');
        $resolver->setAllowedTypes('fields', ['array']);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var FieldTypeInterface[] $fields */
        $fields = $options['fields'];
        foreach ($fields as $field) {
            $field->buildForm($builder);
        }
        $builder->add('rabble:sort_order', HiddenType::class, [
            'data' => $builder->getName(),
            'attr' => ['class' => 'sort_order'],
        ]);
    }
}
