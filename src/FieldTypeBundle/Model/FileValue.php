<?php

namespace Rabble\FieldTypeBundle\Model;

use Symfony\Component\HttpFoundation\File\File;

/**
 * Simple model class for Vich Uploader to work with.
 */
class FileValue
{
    private $file;
    private $fileName;

    public function __construct(?string $fileName = null, ?File $file = null)
    {
        $this->fileName = $fileName;
        $this->file = $file;
    }

    public function setFile(?File $file): void
    {
        $this->file = $file;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName): void
    {
        $this->fileName = $fileName;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }
}
