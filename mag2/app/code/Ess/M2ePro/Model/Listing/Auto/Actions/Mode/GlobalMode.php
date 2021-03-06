<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  2011-2015 ESS-UA [M2E Pro]
 * @license    Commercial use is forbidden
 */

namespace Ess\M2ePro\Model\Listing\Auto\Actions\Mode;

class GlobalMode extends AbstractMode
{
    //########################################

    public function synch()
    {
        $collection = $this->activeRecordFactory->getObject('Listing')->getCollection();

        $collection->addFieldToFilter('auto_mode',\Ess\M2ePro\Model\Listing::AUTO_MODE_GLOBAL);
        $collection->addFieldToFilter(
            'auto_global_adding_mode',
            array('neq'=>\Ess\M2ePro\Model\Listing::ADDING_MODE_NONE)
        );

        foreach ($collection->getItems() as $listing) {

            /** @var \Ess\M2ePro\Model\Listing $listing */

            if (!$listing->isAutoGlobalAddingAddNotVisibleYes()) {
                if ($this->getProduct()->getVisibility()
                    == \Magento\Catalog\Model\Product\Visibility::VISIBILITY_NOT_VISIBLE) {
                    continue;
                }
            }

            $this->getListingObject($listing)->addProductByGlobalListing($this->getProduct(), $listing);
        }
    }

    //########################################
}