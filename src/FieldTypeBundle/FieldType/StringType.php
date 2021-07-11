<?php

namespace Rabble\FieldTypeBundle\FieldType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class StringType extends AbstractFieldType
{
    public function buildForm(FormBuilderInterface $builder): void
    {
        $builder->add($this->options['name'], TextType::class, $this->options['form_options']);
    }
}
