<?php

namespace Rabble\FieldTypeBundle;

use Rabble\FieldTypeBundle\DependencyInjection\Compiler\FieldTypeMappingPass;
use Rabble\FieldTypeBundle\DependencyInjection\Compiler\ValueResolverPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RabbleFieldTypeBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FieldTypeMappingPass());
        $container->addCompilerPass(new ValueResolverPass());
    }
}
