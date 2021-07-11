<?php

namespace Rabble\FieldTypeBundle\ValueResolver;

use Rabble\FieldTypeBundle\FieldType\CollectionType;
use Rabble\FieldTypeBundle\FieldType\FieldTypeInterface;
use Webmozart\Assert\Assert;

class CollectionValueResolver implements ValueResolverInterface
{
    private ValueResolverCollection $resolvers;

    public function __construct(ValueResolverCollection $resolvers)
    {
        $this->resolvers = $resolvers;
    }

    /**
     * @param mixed                             $value
     * @param CollectionType|FieldTypeInterface $fieldType
     */
    public function resolve($value, FieldTypeInterface $fieldType): array
    {
        Assert::isArray($value);
        $data = [];
        foreach ($value as $item) {
            $valueData = [];
            foreach ($fieldType->getOption(CollectionType::getFieldsOption()) as $field) {
                $value = $item[$field->getName()] ?? null;
                foreach ($this->resolvers as $resolver) {
                    if ($resolver->supports($field)) {
                        $value = $resolver->resolve($value, $field);

                        break;
                    }
                }
                $valueData[$field->getName()] = $value;
            }
            $data[] = $valueData;
        }

        return $data;
    }

    public function supports(FieldTypeInterface $fieldType): bool
    {
        return $fieldType instanceof CollectionType;
    }
}
