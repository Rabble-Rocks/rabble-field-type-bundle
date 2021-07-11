<?php

namespace Rabble\FieldTypeBundle\VichUploader;

use Rabble\FieldTypeBundle\Model\FileValue;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory as BasePropertyMappingFactory;

class PropertyMappingFactory extends BasePropertyMappingFactory
{
    public function fromMappingName(string $mappingName)
    {
        return $this->createMapping(new FileValue(), 'file', [
            'mapping' => $mappingName,
            'propertyName' => 'file',
            'fileNameProperty' => 'fileName',
        ]);
    }
}
