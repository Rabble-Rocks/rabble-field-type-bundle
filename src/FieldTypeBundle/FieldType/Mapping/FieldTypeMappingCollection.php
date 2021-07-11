<?php

namespace Rabble\FieldTypeBundle\FieldType\Mapping;

use Doctrine\Common\Collections\ArrayCollection;
use Webmozart\Assert\Assert;

class FieldTypeMappingCollection extends ArrayCollection
{
    public function __construct(array $elements = [])
    {
        $array = [];
        foreach ($elements as $element) {
            Assert::isInstanceOf($element, FieldTypeMapping::class);
            $array[$element->getName()] = $element;
        }
        parent::__construct($array);
    }

    /**
     * @param FieldTypeMapping $element
     *
     * @return bool|true
     */
    public function add($element)
    {
        Assert::isInstanceOf($element, FieldTypeMapping::class);
        parent::set($element->getName(), $element);

        return true;
    }

    /**
     * @param int|string       $key
     * @param FieldTypeMapping $value
     */
    public function set($key, $value)
    {
        Assert::isInstanceOf($value, FieldTypeMapping::class);
        Assert::eq($key, $value->getName(), 'The key has to be equal to %2$s.');
        parent::set($key, $value);
    }
}
