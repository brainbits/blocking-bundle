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

use Brainbits\BlockingBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;

/**
 * Configuration test
 */
class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration()
    {
        return new Configuration();
    }

    public function testValuesAreValidIfNoValuesAreProvided()
    {
        $this->assertConfigurationIsValid(
            [
                [] // no values at all
            ]
        );
    }

    public function testDefaultValues()
    {
        $this->assertProcessedConfigurationEquals(
            [
                [], // no values at all
            ],
            [
                'expiration_time' => 300,
                'block_interval' => 30,
            ]
        );
    }

    public function testProvidedValues()
    {
        $this->assertProcessedConfigurationEquals(
            [
                [
                    'expiration_time' => 99,
                    'block_interval' => 88,
                ],
            ],
            [
                'expiration_time' => 99,
                'block_interval' => 88,
            ]
        );
    }
}
