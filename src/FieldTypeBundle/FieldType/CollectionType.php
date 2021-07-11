<?php

namespace Rabble\FieldTypeBundle\FieldType;

use Rabble\FieldTypeBundle\Form\EventSubscriber\SortOrderSubscriber;
use Rabble\FieldTypeBundle\Form\FieldContainerType;
use Rabble\FieldTypeBundle\Form\RabbleCollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionType extends AbstractFieldType implements FieldContainerInterface
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('fields');
        $resolver->setAllowedTypes('fields', ['array']);
    }

    public function buildForm(FormBuilderInterface $builder): void
    {
        $field = $builder->create($this->options['name'], RabbleCollectionType::class, array_merge([
            'allow_add' => true,
            'allow_delete' => true,
            'prototype_name' => '__name__'.spl_object_hash($builder),
            'entry_type' => FieldContainerType::class,
            'entry_options' => ['fields' => $this->options['fields'], 'label' => false],
        ], $this->options['form_options']));
        $builder->add($field);
        $field->addEventSubscriber(new SortOrderSubscriber());
    }

    public static function getFieldsOption(): string
    {
        return 'fields';
    }
}
