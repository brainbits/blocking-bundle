<?php

/*
 * This file is part of the brainbits blocking bundle package.
 *
 * (c) brainbits GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\BlockingBundle\Tests;

use Brainbits\BlockingBundle\BrainbitsBlockingBundle;
use PHPUnit\Framework\TestCase;

/**
 * Blocking bundle test.
 */
class BrainbitsBlockingBundleTest extends TestCase
{
    public function testConstructor()
    {
        $bundle = new BrainbitsBlockingBundle();

        $this->assertInstanceOf(BrainbitsBlockingBundle::class, $bundle);
    }
}
