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
use Brainbits\Blocking\Identifier\Identifier;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Index controller
 */
class BlockingController
{
    /**
     * @var Blocker
     */
    private $blocker;

    /**
     * BlockingController constructor.
     *
     * @param Blocker $blocker
     */
    public function __construct(Blocker $blocker)
    {
        $this->blocker = $blocker;
    }

    /**
     * @param string $type
     * @param string $id
     *
     * @return JsonResponse
     */
    public function blockAction($type, $id)
    {
        $identifier = new Identifier($type, $id);

        try {
            $this->blocker->block($identifier);

            $result = array('success' => true, 'type' => $type, 'id' => $id);
        } catch (\Exception $e) {
            $result = array('success' => false, 'message' => $e->getMessage(), 'type' => $type, 'id' => $id);
        }

        return new JsonResponse($result);
    }

    /**
     * @param string $type
     * @param string $id
     *
     * @return JsonResponse
     */
    public function unblockAction($type, $id)
    {
        $identifier = new Identifier($type, $id);

        try {
            $this->blocker->unblock($identifier);

            $result = array('success' => true, 'type' => $type, 'id' => $id);
        } catch (\Exception $e) {
            $result = array('success' => false, 'message' => $e->getMessage(), 'type' => $type, 'id' => $id);
        }

        return new JsonResponse($result);
    }
}
