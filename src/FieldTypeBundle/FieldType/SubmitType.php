<?php

namespace Rabble\FieldTypeBundle\FieldType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType as SubmitFormType;
use Symfony\Component\Form\FormBuilderInterface;

class SubmitType extends AbstractFieldType
{
    public function buildForm(FormBuilderInterface $builder): void
    {
        $builder->add($this->options['name'], SubmitFormType::class, array_merge([
        ], $this->options['form_options']));
    }
}
