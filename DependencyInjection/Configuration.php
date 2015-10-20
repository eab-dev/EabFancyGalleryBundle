<?php

namespace Eab\FancyGalleryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root( 'eab_fancy_gallery' );
        $rootNode
            ->children()
            ->scalarNode( 'pagelayout' )->defaultValue( 'eZDemoBundle::pagelayout.html.twig' )->end()
            ->integerNode( 'page_limit' )->defaultValue( 12 )->end()
            ->scalarNode( 'image_types' )->defaultValue( array( 'image' ) )->end()
            ->booleanNode( 'summary_in_full_view' )->defaultValue( true )->end()
            ->scalarNode( 'image_variation' )->defaultValue( 'gallerythumbnail' )->end()
            ->end();
        return $treeBuilder;
    }
}
