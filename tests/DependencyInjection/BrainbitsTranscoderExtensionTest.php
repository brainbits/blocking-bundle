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

use Brainbits\BlockingBundle\DependencyInjection\BrainbitsBlockingExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

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

        $this->assertContainerBuilderHasParameter('brainbits.blocking.validator.expiration_time', 300);
        $this->assertContainerBuilderHasParameter('brainbits.blocking.interval', 30);
    }

    public function testContainerHasCustomParameters()
    {
        $this->load(['expiration_time' => 8, 'block_interval' => 9]);

        $this->assertContainerBuilderHasParameter('brainbits.blocking.validator.expiration_time', 8);
        $this->assertContainerBuilderHasParameter('brainbits.blocking.interval', 9);
    }
}
