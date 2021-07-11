<?php

namespace Rabble\FieldTypeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class RabbleCollectionType extends AbstractType
{
    public function getParent()
    {
        return CollectionType::class;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr'] = ['class' => 'sortable'];
        $view->vars['type'] = 'collection';
        $view->vars['allow_delete'] = $options['allow_delete'];
        $view->vars['prototype_name'] = $options['prototype_name'];
    }
}
