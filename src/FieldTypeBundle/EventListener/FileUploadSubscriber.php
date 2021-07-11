<?php

namespace Rabble\FieldTypeBundle\EventListener;

use Rabble\FieldTypeBundle\Event\UploadEvent;
use Rabble\FieldTypeBundle\Model\FileValue;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Storage\StorageInterface;

class FileUploadSubscriber implements EventSubscriberInterface
{
    private StorageInterface $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            UploadEvent::class => 'onUpload',
        ];
    }

    public function onUpload(UploadEvent $event)
    {
        $file = $event->getFile();
        $model = new FileValue($file->getFilename(), $file);
        $mapping = $event->getMapping();
        $this->storage->upload($model, $mapping);
        $path = $mapping->getUploadDestination().DIRECTORY_SEPARATOR.$mapping->getFileName($model);
        $file = new UploadedFile($path, $file->getClientOriginalName(), $file->getClientMimeType(), null, true);
        $event->setFile($file);
    }
}
