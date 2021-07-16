<?php

namespace Rabble\FieldTypeBundle\ValueResolver;

use Rabble\FieldTypeBundle\FieldType\FieldTypeInterface;
use Rabble\FieldTypeBundle\FieldType\ImageType;
use Rabble\FieldTypeBundle\Model\FileValue;
use Rabble\FieldTypeBundle\VichUploader\PropertyMappingFactory;

class ImageValueResolver implements ValueResolverInterface
{
    protected $propertyMappingFactory;

    public function __construct(PropertyMappingFactory $propertyMappingFactory)
    {
        $this->propertyMappingFactory = $propertyMappingFactory;
    }

    /**
     * @param mixed                        $value
     * @param FieldTypeInterface|ImageType $fieldType
     *
     * @return mixed
     */
    public function resolve($value, FieldTypeInterface $fieldType, ?string $target = null)
    {
        $mappingName = $fieldType->getOption('mapping');
        $mapping = $this->propertyMappingFactory->fromMappingName($mappingName);
        $fileValue = new FileValue($value);

        return rtrim($mapping->getUriPrefix().DIRECTORY_SEPARATOR.$mapping->getUploadDir($fileValue), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$value;
    }

    public function supports(FieldTypeInterface $fieldType): bool
    {
        return $fieldType instanceof ImageType;
    }
}
