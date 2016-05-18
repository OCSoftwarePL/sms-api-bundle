<?php

namespace OCSoftwarePL\SmsApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('ocs_pl_smsapi');

        $rootNode->children()
            ->scalarNode('default_sender_name')->end()
            ->scalarNode('login')->isRequired()->end()
            ->scalarNode('password')->isRequired()->end()
            ->scalarNode('proxy')->defaultNull()->end()
            ->end();

        return $treeBuilder;
    }
}
