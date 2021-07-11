<?php

namespace Rabble\FieldTypeBundle\FieldType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType as FormChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class ChoiceType extends AbstractFieldType
{
    public function buildForm(FormBuilderInterface $builder): void
    {
        $builder->add($this->options['name'], FormChoiceType::class, $this->options['form_options']);
    }
}
