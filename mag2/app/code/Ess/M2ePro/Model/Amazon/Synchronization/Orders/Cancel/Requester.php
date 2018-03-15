<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2016 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

namespace Ess\M2ePro\Model\Amazon\Synchronization\Orders\Cancel;

class Requester extends \Ess\M2ePro\Model\Amazon\Connector\Orders\Cancel\ItemsRequester
{
    //########################################

    protected function getResponserParams()
    {
        $params = array();

        foreach ($this->params['items'] as $item) {
            if (!is_array($item)) {
                continue;
            }

            $params[$item['change_id']] = $item;
        }

        return $params;
    }

    //########################################

    public function eventBeforeExecuting()
    {
        parent::eventBeforeExecuting();

        $changeIds = array();

        foreach ($this->params['items'] as $orderCancel) {
            if (!is_array($orderCancel)) {
                continue;
            }

            $changeIds[] = $orderCancel['change_id'];
        }

        $this->activeRecordFactory->getObject('Order\Change')->getResource()
            ->deleteByIds($changeIds);
    }

    //########################################
}