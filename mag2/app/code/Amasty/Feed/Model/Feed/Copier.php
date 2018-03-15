<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Feed
 */

namespace Amasty\Feed\Model\Feed;

class Copier
{
    protected $feedFactory;

    public function __construct(
        \Amasty\Feed\Model\FeedFactory $feedFactory
    ) {
        $this->feedFactory = $feedFactory;
    }

    protected function _duplicate(\Amasty\Feed\Model\Feed $feed)
    {
        $duplicate = $this->feedFactory->create();
        $duplicate->setData($feed->getData());
        $duplicate->setIsDuplicate(true);
        $duplicate->setOriginalId($feed->getId());


        $duplicate->setExecuteMode('manual');
        $duplicate->setGeneratedAt(null);
        $duplicate->setId(null);
        return $duplicate;
    }

    public function copy(\Amasty\Feed\Model\Feed $feed)
    {
        $duplicate = $this->_duplicate($feed);

        $duplicate->setName($duplicate->getName().'-duplicate');
        $duplicate->setFilename($duplicate->getFilename().'-duplicate');

        $duplicate->save();

        return $duplicate;
    }

    public function template(\Amasty\Feed\Model\Feed $feed)
    {
        $duplicate = $this->_duplicate($feed);

        $duplicate->setIsTemplate(true);
        $duplicate->setStoreId(null);

        $duplicate->save();

        return $duplicate;
    }

    public function fromTemplate(\Amasty\Feed\Model\Feed $template, $storeId)
    {
        $duplicate = $this->_duplicate($template);

        $duplicate->setIsTemplate(false);
        $duplicate->setStoreId($storeId);

        $duplicate->save();

        return $duplicate;
    }
}