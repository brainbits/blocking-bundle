<?php
/**
 * This file is part of the brainbits blocking bundle.
 *
 * (c) 2012-2013 brainbits GmbH (http://www.brainbits.net)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brainbits\BlockingBundle\Controller;

use Brainbits\Blocking\Identifier\Identifier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Index controller
 *
 * @Route("/blocking")
 */
class BlockingController extends Controller
{
    /**
     * @Route("/block/{type}/{id}", name="brainbits_blocking_block")
     */
    public function blockAction($type, $id)
    {
        $identifier = new Identifier($type, $id);
        $blocker = $this->get('brainbits.blocking.blocker');

        try {
            $blocker->block($identifier);

            $response = new JsonResponse(array(
                'success' => true,
                'type'    => $type,
                'id'      => $id,
            ));
        } catch (\Exception $e) {
            $response = new JsonResponse(array(
                'success' => false,
                'message' => $e->getMessage(),
                'type'    => $type,
                'id'      => $id,
            ));
        }

        return $response;
    }

    /**
     * @Route("/unblock/{type}/{id}", name="brainbits_blocking_unblock")
     */
    public function unblockAction($type, $id)
    {
        $identifier = new Identifier($type, $id);
        $blocker = $this->get('brainbits.blocking.blocker');

        try {
            $blocker->unblock($identifier);

            $response = new JsonResponse(array(
                'success' => true,
                'type'    => $type,
                'id'      => $id,
            ));
        } catch (\Exception $e) {
            $response = new JsonResponse(array(
                'success' => false,
                'message' => $e->getMessage(),
                'type'    => $type,
                'id'      => $id,
            ));
        }

        return $response;
    }
}
