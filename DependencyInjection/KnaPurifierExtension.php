<?php
namespace Kna\PurifierBundle\DependencyInjection;

use Kna\PurifierBundle\Purifier\PurifierConfigProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class KnaPurifierExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('kna.purifier.cache_dir', $config['cache_dir']);

        $container
            ->registerForAutoconfiguration(PurifierConfigProviderInterface::class)
            ->addTag('kna.purifier.config_provider')
        ;

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}