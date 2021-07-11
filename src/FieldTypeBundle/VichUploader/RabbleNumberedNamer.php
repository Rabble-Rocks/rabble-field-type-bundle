<?php

namespace Rabble\FieldTypeBundle\VichUploader;

use Symfony\Component\String\Slugger\SluggerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

class RabbleNumberedNamer implements NamerInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function name($object, PropertyMapping $mapping): string
    {
        $file = $mapping->getFile($object);
        $name = $file->getClientOriginalName();
        $extension = substr($name, strrpos($name, '.'));
        $name = substr($name, 0, strlen($extension) * -1);
        $suffix = '';
        $i = 1;
        while (file_exists($mapping->getUploadDestination().DIRECTORY_SEPARATOR.$name.$suffix.$extension)) {
            $suffix = "-{$i}";
            ++$i;
        }

        return $this->slugger->slug($name, '-').$suffix.$extension;
    }
}
