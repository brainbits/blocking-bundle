<?php

declare(strict_types=1);

/*
 * This file is part of the brainbits blocking bundle package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\BlockingBundle\Tests\DependencyInjection;

use Brainbits\BlockingBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * Configuration test
 */
class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration(): Configuration
    {
        return new Configuration();
    }

    public function testValuesAreValidIfNoValuesAreProvided(): void
    {
        $this->assertConfigurationIsValid(
            [
                [], // no values at all
            ]
        );
    }

    public function testDefaultValues(): void
    {
        $this->assertProcessedConfigurationEquals(
            [
                [], // no values at all
            ],
            [
                'storage' => [
                    'driver' => 'filesystem',
                    'storage_dir' => '%kernel.cache_dir%/blocking/',
                ],
                'owner_factory' => ['driver' => 'symfony_session'],
                'validator' => [
                    'driver' => 'expired',
                    'expiration_time' => 300,
                ],
                'block_interval' => 30,
            ]
        );
    }

    public function testProvidedValues(): void
    {
        $this->assertProcessedConfigurationEquals(
            [
                [
                    'storage' => [
                        'driver' => 'in_memory',
                        'storage_dir' => 'foo',
                    ],
                    'owner_factory' => [
                        'driver' => 'value',
                        'value' => 'bar',
                    ],
                    'validator' => [
                        'driver' => 'always_invalidate',
                        'expiration_time' => 99,
                    ],
                    'block_interval' => 88,
                ],
            ],
            [
                'storage' => [
                    'driver' => 'in_memory',
                    'storage_dir' => 'foo',
                ],
                'owner_factory' => [
                    'driver' => 'value',
                    'value' => 'bar',
                ],
                'validator' => [
                    'driver' => 'always_invalidate',
                    'expiration_time' => 99,
                ],
                'block_interval' => 88,
            ]
        );
    }

    public function testInvalidStorageDriver(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $this->assertProcessedConfigurationEquals(
            [
                [
                    'storage' => ['driver' => 'test'],
                ],
            ],
            []
        );
    }

    public function testMissingCustomStorageService(): void
    {
        $this->expectException(InvalidConfigurationException::class);
        // phpcs:ignore Generic.Files.LineLength.TooLong
        $this->expectExceptionMessage('Invalid configuration for path "brainbits_blocking": You need to specify your own storage service when using the "custom" storage driver.');

        $this->assertProcessedConfigurationEquals(
            [
                [
                    'storage' => ['driver' => 'custom'],
                ],
            ],
            []
        );
    }

    public function testCustomStorageService(): void
    {
        $this->assertProcessedConfigurationEquals(
            [
                [
                    'storage' => [
                        'driver' => 'custom',
                        'service' => 'foo',
                    ],
                ],
            ],
            [
                'storage' => [
                    'driver' => 'custom',
                    'storage_dir' => '%kernel.cache_dir%/blocking/',
                    'service' => 'foo',
                ],
                'owner_factory' => ['driver' => 'symfony_session'],
                'validator' => [
                    'driver' => 'expired',
                    'expiration_time' => 300,
                ],
                'block_interval' => 30,
            ]
        );
    }

    public function testInvalidOwnerDriver(): void
    {
        $this->expectException(InvalidConfigurationException::class);

        $this->assertProcessedConfigurationEquals(
            [
                [
                    'owner_factory' => ['driver' => 'test'],
                ],
            ],
            []
        );
    }

    public function testMissingCustomOwnerService(): void
    {
        $this->expectException(InvalidConfigurationException::class);
        // phpcs:ignore Generic.Files.LineLength.TooLong
        $this->expectExceptionMessage('Invalid configuration for path "brainbits_blocking": You need to specify your own owner_factory service when using the "custom" owner_factory driver.');

        $this->assertProcessedConfigurationEquals(
            [
                [
                    'owner_factory' => ['driver' => 'custom'],
                ],
            ],
            []
        );
    }

    public function testCustomOwnerService(): void
    {
        $this->assertProcessedConfigurationEquals(
            [
                [
                    'owner_factory' => [
                        'driver' => 'custom',
                        'service' => 'foo',
                    ],
                ],
            ],
            [
                'storage' => [
                    'driver' => 'filesystem',
                    'storage_dir' => '%kernel.cache_dir%/blocking/',
                ],
                'owner_factory' => [
                    'driver' => 'custom',
                    'service' => 'foo',
                ],
                'validator' => [
                    'driver' => 'expired',
                    'expiration_time' => 300,
                ],
                'block_interval' => 30,
            ]
        );
    }

    public function testInvalidValidatorDriver(): void
    {
        $this->expectException(InvalidConfigurationException::class);
        // phpcs:ignore Generic.Files.LineLength.TooLong
        $this->expectExceptionMessage('Invalid configuration for path "brainbits_blocking.validator.driver": The validator driver "test" is not supported. Please choose one of ["expired","always_invalidate","custom"]');

        $this->assertProcessedConfigurationEquals(
            [
                [
                    'validator' => ['driver' => 'test'],
                ],
            ],
            []
        );
    }

    public function testMissingCustomValidatorService(): void
    {
        $this->expectException(InvalidConfigurationException::class);
        // phpcs:ignore Generic.Files.LineLength.TooLong
        $this->expectExceptionMessage('Invalid configuration for path "brainbits_blocking": You need to specify your own validator service when using the "custom" validator driver.');

        $this->assertProcessedConfigurationEquals(
            [
                [
                    'validator' => ['driver' => 'custom'],
                ],
            ],
            []
        );
    }

    public function testCustomValidatorService(): void
    {
        $this->assertProcessedConfigurationEquals(
            [
                [
                    'validator' => [
                        'driver' => 'custom',
                        'service' => 'foo',
                    ],
                ],
            ],
            [
                'storage' => [
                    'driver' => 'filesystem',
                    'storage_dir' => '%kernel.cache_dir%/blocking/',
                ],
                'owner_factory' => ['driver' => 'symfony_session'],
                'validator' => [
                    'driver' => 'custom',
                    'service' => 'foo',
                    'expiration_time' => 300,
                ],
                'block_interval' => 30,
            ]
        );
    }
}
