<?php
namespace Kna\PurifierBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class PurifierPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('kna.purifier.purifier')){
            return;
        }
        $cacheDir = $container->getParameter('kernel.cache_dir') . '/' . $container->getParameter('kna.purifier.cache_dir');

        $purifierDefinition = $container->findDefinition('kna.purifier.purifier');

        $taggedServices = $container->findTaggedServiceIds('kna.purifier.config_provider');
        foreach ($taggedServices as $id => $tags) {
            $providerDefinition = $container->getDefinition($id);
            $providerDefinition->addArgument($cacheDir);
//            $providerDefinition->addMethodCall('setCacheDir', [$cacheDir]);
//            $providerDefinition->addMethodCall('configure'); // TODO: Удалить строку после проверки
            $purifierDefinition->addMethodCall('registerProvider', [new Reference($id)]);
        }
    }
}