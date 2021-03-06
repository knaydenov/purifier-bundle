<?php
namespace Kna\PurifierBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use \Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('kna_purifier');

        $this->addCommonSection($root);

        return $treeBuilder;
    }

    protected function addCommonSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('cache_dir')->defaultValue('purifier')->end()
            ->end()
        ;
    }
}