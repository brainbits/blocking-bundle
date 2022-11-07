<?php

declare(strict_types=1);

/*
 * This file is part of the brainbits blocking bundle.
 *
 * (c) brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\BlockingBundle\Tests\Controller;

use Brainbits\Blocking\Block;
use Brainbits\Blocking\Blocker;
use Brainbits\Blocking\Identity\Identity;
use Brainbits\Blocking\Owner\Owner;
use Brainbits\Blocking\Owner\ValueOwnerFactory;
use Brainbits\Blocking\Storage\InMemoryStorage;
use Brainbits\Blocking\Validator\ExpiredValidator;
use Brainbits\BlockingBundle\Controller\BlockingController;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

use function json_decode;

/**
 * Index controller
 */
class BlockingControllerTest extends TestCase
{
    private BlockingController $controller;

    protected function setUp(): void
    {
        $block = new Block(
            new Identity('foo'),
            new Owner('baz'),
            new DateTimeImmutable()
        );

        $blocker = new Blocker(
            new InMemoryStorage($block),
            new ValueOwnerFactory('bar'),
            new ExpiredValidator(10)
        );

        $this->controller = new BlockingController($blocker);
    }

    public function testBlockSuccessAction(): void
    {
        $response = $this->controller->blockAction('new');

        $this->assertInstanceOf(JsonResponse::class, $response);

        $result = (array) json_decode((string) $response->getContent(), true);

        $this->assertTrue($result['success'] ?? null);
    }

    public function testBlockFailureAction(): void
    {
        $response = $this->controller->blockAction('foo');

        $this->assertInstanceOf(JsonResponse::class, $response);

        $result = (array) json_decode((string) $response->getContent(), true);

        $this->assertFalse($result['success'] ?? null);
    }

    public function testUnblockSuccessAction(): void
    {
        $response = $this->controller->unblockAction('foo');

        $this->assertInstanceOf(JsonResponse::class, $response);

        $result = (array) json_decode((string) $response->getContent(), true);

        $this->assertTrue($result['success'] ?? null);
    }

    public function testUnblockFailureAction(): void
    {
        $response = $this->controller->unblockAction('new');

        $this->assertInstanceOf(JsonResponse::class, $response);

        $result = (array) json_decode((string) $response->getContent(), true);

        $this->assertFalse($result['success'] ?? null);
    }
}
