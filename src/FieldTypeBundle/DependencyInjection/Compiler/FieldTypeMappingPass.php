<?php

namespace Rabble\FieldTypeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FieldTypeMappingPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $fieldTypeMappingDef = $container->findDefinition('rabble_field_type.field_type_mapping_collection');
        $mappingIds = $container->findTaggedServiceIds('rabble_field_type_mapping');
        foreach ($mappingIds as $id => $tags) {
            $fieldTypeMappingDef->addMethodCall('add', [new Reference($id)]);
        }
    }
}
