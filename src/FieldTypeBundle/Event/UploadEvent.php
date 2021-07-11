<?php

namespace Rabble\FieldTypeBundle\Event;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Contracts\EventDispatcher\Event;
use Vich\UploaderBundle\Mapping\PropertyMapping;

class UploadEvent extends Event
{
    private UploadedFile $file;

    private PropertyMapping $mapping;

    public function __construct(UploadedFile $file, PropertyMapping $mapping)
    {
        $this->file = $file;
        $this->mapping = $mapping;
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file): void
    {
        $this->file = $file;
    }

    public function setMapping(PropertyMapping $mapping): void
    {
        $this->mapping = $mapping;
    }

    public function getMapping(): PropertyMapping
    {
        return $this->mapping;
    }
}
