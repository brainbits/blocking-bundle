<?php

/*
 * This file is part of the brainbits blocking bundle package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\BlockingBundle\Tests\DependencyInjection;

use Brainbits\Blocking\Owner\SymfonySessionOwner;
use Brainbits\Blocking\Owner\ValueOwner;
use Brainbits\Blocking\Storage\FilesystemStorage;
use Brainbits\Blocking\Storage\InMemoryStorage;
use Brainbits\Blocking\Validator\ExpiredValidator;
use Brainbits\BlockingBundle\DependencyInjection\BrainbitsBlockingExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * Extension test.
 */
class BrainbitsTranscoderExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return array(
            new BrainbitsBlockingExtension()
        );
    }

    public function testContainerHasDefaultParameters()
    {
        $this->load();

        $this->assertContainerBuilderHasService('brainbits_blocking.storage', FilesystemStorage::class);
        $this->assertContainerBuilderHasService('brainbits_blocking.owner', SymfonySessionOwner::class);
        $this->assertContainerBuilderHasService('brainbits_blocking.validator', ExpiredValidator::class);
        $this->assertContainerBuilderHasParameter('brainbits_blocking.validator.expiration_time', 300);
        $this->assertContainerBuilderHasParameter('brainbits_blocking.interval', 30);
    }

    public function testContainerHasCustomParameters()
    {
        $this->load([
            'storage' => [
                'driver' => 'in_memory',
            ],
            'owner' => [
                'driver' => 'value',
                'value' => 'xx',
            ],
            'validator' => [
                'expiration_time' => 8,
            ],
            'block_interval' => 9,
        ]);

        $this->assertContainerBuilderHasService('brainbits_blocking.storage', InMemoryStorage::class);
        $this->assertContainerBuilderHasService('brainbits_blocking.owner', ValueOwner::class);
        $this->assertContainerBuilderHasService('brainbits_blocking.validator', ExpiredValidator::class);
        $this->assertContainerBuilderHasParameter('brainbits_blocking.validator.expiration_time', 8);
        $this->assertContainerBuilderHasParameter('brainbits_blocking.interval', 9);
    }

    public function testCustomerStorageService()
    {
        $this->load([
            'storage' => [
                'driver' => 'custom',
                'service' => 'foo',
            ],
        ]);

        $this->assertContainerBuilderHasAlias('brainbits_blocking.storage', 'foo');
    }

    public function testCustomOwnerService()
    {
        $this->load([
            'owner' => [
                'driver' => 'custom',
                'service' => 'bar',
            ],
        ]);

        $this->assertContainerBuilderHasAlias('brainbits_blocking.owner', 'bar');
    }

    public function testCustomValidatorService()
    {
        $this->load([
            'validator' => [
                'driver' => 'custom',
                'service' => 'baz',
            ],
        ]);

        $this->assertContainerBuilderHasAlias('brainbits_blocking.validator', 'baz');
    }
}
