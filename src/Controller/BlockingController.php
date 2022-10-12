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

namespace Brainbits\BlockingBundle\Controller;

use Brainbits\Blocking\Blocker;
use Brainbits\Blocking\Identity\Identity;
use Symfony\Component\HttpFoundation\JsonResponse;

final class BlockingController
{
    private Blocker $blocker;

    public function __construct(Blocker $blocker)
    {
        $this->blocker = $blocker;
    }

    public function blockAction(string $identifier): JsonResponse
    {
        $identifier = new Identity($identifier);

        $block = $this->blocker->tryBlock($identifier);

        return new JsonResponse([
            'success' => !!$block,
        ]);
    }

    public function unblockAction(string $identifier): JsonResponse
    {
        $identifier = new Identity($identifier);

        $block = $this->blocker->unblock($identifier);

        return new JsonResponse([
            'success' => !!$block,
        ]);
    }
}
