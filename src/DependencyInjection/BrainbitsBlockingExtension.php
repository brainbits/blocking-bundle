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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

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

        if (isset($config['storage']['storage_dir'])) {
            $container->setParameter(
                'brainbits_blocking.storage.storage_dir',
                $config['storage']['storage_dir']
            );
        }

        if (isset($config['owner_factory']['value'])) {
            $container->setParameter(
                'brainbits_blocking.owner_factory.value',
                $config['owner_factory']['value']
            );
        }

        if (isset($config['validator']['expiration_time'])) {
            $container->setParameter(
                'brainbits_blocking.validator.expiration_time',
                $config['validator']['expiration_time']
            );
            $container->setParameter('brainbits_blocking.interval', $config['block_interval']);
        }

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

        if ('custom' !== $config['owner_factory']['driver']) {
            $loader->load(sprintf('owner_factory/%s.xml', $config['owner_factory']['driver']));
        } else {
            $container->setAlias('brainbits_blocking.owner_factory', $config['owner_factory']['service']);
        }
    }
}
