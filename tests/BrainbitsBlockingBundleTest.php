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
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Blocking bundle test.
 */
class BrainbitsBlockingBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $bundle = new BrainbitsBlockingBundle();

        $container = $this->prophesize(ContainerBuilder::class);

        $bundle->build($container->reveal());
    }
}
