<?php

namespace Rabble\FieldTypeBundle\FieldType;

interface FieldContainerInterface extends FieldTypeInterface
{
    public static function getFieldsOption(): string;
}
