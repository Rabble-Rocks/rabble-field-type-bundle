<?php

namespace Rabble\FieldTypeBundle\FieldType;

use Symfony\Component\Form\FormBuilderInterface;

interface FieldTypeInterface
{
    public function buildForm(FormBuilderInterface $builder): void;

    public function getName(): string;

    public function getComponent(): string;
}
