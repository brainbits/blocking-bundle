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
 * Extension test
 *
 * @author Stephan Wentz <swentz@brainbits.net>
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
    }
}
