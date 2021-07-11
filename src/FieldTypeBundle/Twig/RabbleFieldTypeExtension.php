<?php

namespace Rabble\FieldTypeBundle\Twig;

use Rabble\FieldTypeBundle\Model\FileValue;
use Symfony\Component\HttpFoundation\File\File;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Vich\UploaderBundle\Mapping\PropertyMapping;

class RabbleFieldTypeExtension extends AbstractExtension
{
    /**
     * @return array|\Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('rabble_image', [$this, 'rabbleImage']),
        ];
    }

    public function rabbleImage($data)
    {
        if (!is_array($data) && !is_string($data)) {
            throw new \RuntimeException('Twig function rabble_image expects an array or a json string.');
        }
        if (is_string($data)) {
            $data = json_decode($data, true);

            return $this->rabbleImage($data);
        }
        if (!isset($data['file']) || !isset($data['mapping'])) {
            throw new \RuntimeException('Twig function rabble_image expects a file and a mapping key.');
        }
        if (!$data['file'] instanceof File || !$data['mapping'] instanceof PropertyMapping) {
            $data = $this->completeImageMapping($data);
        }
        $file = new FileValue($data['file']->getFilename(), $data['file']);
        $mapping = $data['mapping'];

        return $mapping->getUriPrefix().rtrim('/'.str_replace('\\', '/', $mapping->getUploadDir($file)), '/').'/'.$file->getFileName();
    }

    private function completeImageMapping(array $data)
    {
        $mapping = $data['mapping'];
        $file = $data['file'];
        if (!$mapping instanceof PropertyMapping) {
            $mapping = new PropertyMapping('file', 'fileName');
            $mapping->setMapping($data['mapping']);
            $data['mapping'] = $mapping;
        }
        if (!$file instanceof File) {
            $dir = $mapping->getUploadDestination().DIRECTORY_SEPARATOR.$mapping->getUploadDir(new FileValue($data['file']));
            $dir = \rtrim($dir, '/\\');
            $file = new File($dir.DIRECTORY_SEPARATOR.$data['file']);
            $data['file'] = $file;
        }

        return $data;
    }
}
