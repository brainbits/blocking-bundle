<?php

declare(strict_types=1);

/*
 * This file is part of the brainbits blocking bundle.
 *
 * (c) brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\BlockingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Blocking configuration.
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('brainbits_blocking');

        $rootNode
            ->children()
                ->integerNode('expiration_time')->defaultValue(300)->end()
                ->integerNode('block_interval')->defaultValue(30)->end()
            ->end();

        return $treeBuilder;
    }
}
