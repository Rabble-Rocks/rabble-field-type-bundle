<?php

namespace Rabble\FieldTypeBundle\FieldType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType as TextareaFormType;
use Symfony\Component\Form\FormBuilderInterface;

class TextareaType extends AbstractFieldType
{
    public function buildForm(FormBuilderInterface $builder): void
    {
        $builder->add($this->options['name'], TextareaFormType::class, array_merge([
        ], $this->options['form_options']));
    }
}
