<?php

namespace Rabble\FieldTypeBundle\Form\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SortOrderSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::SUBMIT => 'onSubmit',
        ];
    }

    public function onSubmit(FormEvent $event): void
    {
        $data = $event->getData();
        if (!is_array($data)) {
            return;
        }
        usort($data, static function ($a, $b) {
            if (!isset($a['rabble:sort_order'], $b['rabble:sort_order']) || $a['rabble:sort_order'] === $b['rabble:sort_order']) {
                return 0;
            }

            return $a['rabble:sort_order'] > $b['rabble:sort_order'] ? 1 : -1;
        });
        $event->setData($data);
    }
}
