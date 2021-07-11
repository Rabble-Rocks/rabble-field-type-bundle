<?php

namespace Rabble\FieldTypeBundle\ValueResolver;

use Rabble\FieldTypeBundle\FieldType\FieldTypeInterface;

interface ValueResolverInterface
{
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function resolve($value, FieldTypeInterface $fieldType);

    public function supports(FieldTypeInterface $fieldType): bool;
}
