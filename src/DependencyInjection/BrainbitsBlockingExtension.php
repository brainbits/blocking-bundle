<?php

declare(strict_types = 1);

/*
 * This file is part of the brainbits blocking bundle.
 *
 * (c) brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\BlockingBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * brainbits blocking extension.
 */
class BrainbitsBlockingExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(
            'brainbits_blocking.validator.expiration_time',
            $config['validator']['expiration_time']
        );
        $container->setParameter('brainbits_blocking.interval', $config['block_interval']);

        if ('custom' !== $config['validator']['driver']) {
            $loader->load(sprintf('validator/%s.xml', $config['validator']['driver']));
        } else {
            $container->setAlias('brainbits_blocking.validator', $config['validator']['service']);
        }

        if ('custom' !== $config['storage']['driver']) {
            $loader->load(sprintf('storage/%s.xml', $config['storage']['driver']));
        } else {
            $container->setAlias('brainbits_blocking.storage', $config['storage']['service']);
        }

        if ('custom' !== $config['owner']['driver']) {
            $loader->load(sprintf('owner/%s.xml', $config['owner']['driver']));
        } else {
            $container->setAlias('brainbits_blocking.owner', $config['owner']['service']);
        }
    }
}
