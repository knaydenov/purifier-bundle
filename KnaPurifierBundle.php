<?php
namespace Kna\PurifierBundle;


use Kna\PurifierBundle\DependencyInjection\Compiler\PurifierPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KnaPurifierBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new PurifierPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION);
    }
}