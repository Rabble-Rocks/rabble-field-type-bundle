<?php

namespace Rabble\FieldTypeBundle\DependencyInjection;

use Rabble\FieldTypeBundle\VichUploader\RabbleNumberedNamer;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class RabbleFieldTypeExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));
        $loader->load('services.xml');
        $this->registerFormTheme($container);
    }

    public function prepend(ContainerBuilder $container)
    {
        $this->prependVichUploader($container);
    }

    private function registerFormTheme(ContainerBuilder $container): void
    {
        $resources = $container->hasParameter('twig.form.resources') ?
            $container->getParameter('twig.form.resources') : [];

        $resources[] = '@RabbleFieldType/Form/fields.html.twig';
        $container->setParameter('twig.form.resources', $resources);
    }

    private function prependVichUploader(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('vich_uploader', [
            'mappings' => [
                'rabble_image' => [
                    'db_driver' => 'orm',
                    'uri_prefix' => '/uploads/rabble_image',
                    'upload_destination' => '%kernel.project_dir%/public/uploads/rabble_image',
                    'namer' => RabbleNumberedNamer::class,
                ],
            ],
        ]);
    }
}
