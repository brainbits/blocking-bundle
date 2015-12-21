<?php

/*
 * This file is part of the brainbits blocking bundle.
 *
 * (c) brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\BlockingBundle\Controller;

use Brainbits\Blocking\Blocker;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Index controller
 */
class BlockingControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BlockingController
     */
    private $controller;

    public function setUp()
    {
        $blocker = $this->prophesize(Blocker::class);

        $this->controller = new BlockingController($blocker->reveal());
    }

    public function testBlockAction()
    {
        $response = $this->controller->blockAction('a', 'b');

        $this->assertInstanceOf(JsonResponse::class, $response);

        $result = json_decode($response->getContent(), true);

        $this->assertTrue($result['success']);
    }

    public function testUnblockAction()
    {
        $response = $this->controller->unblockAction('a', 'b');

        $this->assertInstanceOf(JsonResponse::class, $response);
        
        $result = json_decode($response->getContent(), true);

        $this->assertTrue($result['success']);
    }
}
