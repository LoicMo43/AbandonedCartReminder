<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE      */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

/**
 * Created by Franck Allimant, CQFDev <franck@cqfdev.fr>
 * Date: 14/05/2017 11:31
 */
namespace AbandonedCartReminder\Controller;

use AbandonedCartReminder\Events\AbandonedCartEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Core\Event\DefaultActionEvent;
use Thelia\Core\HttpFoundation\Response;
use Thelia\Log\Tlog;

class ExamineCartController extends BaseFrontController {

    /**
     * @throws \Exception
     */
    #[Route('/admin/AbandonedCartReminder/cron', name: 'abandoned_cart_reminder_cron')]
    public function examine(EventDispatcherInterface $dispatcher): Response
    {
        try {
            $dispatcher->dispatch(
                new DefaultActionEvent(),
                AbandonedCartEvent::EXAMINE_CARTS_EVENT
            );

        } catch (\Exception $ex) {
            Tlog::getInstance()->error("Error, can't examine abandoned carts :" . $ex->getMessage());
            Tlog::getInstance()->error($ex);

            throw $ex;
        }

        return new Response("Abandoned carts check finished.");
    }
}
