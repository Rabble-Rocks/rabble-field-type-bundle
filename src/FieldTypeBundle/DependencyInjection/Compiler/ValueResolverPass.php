<?php

namespace Rabble\FieldTypeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ValueResolverPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $valueResolverCollectionDef = $container->findDefinition('rabble_field_type.value_resolver_collection');
        $valueResolvers = $container->findTaggedServiceIds('rabble_field_type.value_resolver');
        foreach ($valueResolvers as $id => $tags) {
            $valueResolverCollectionDef->addMethodCall('add', [new Reference($id)]);
        }
    }
}
