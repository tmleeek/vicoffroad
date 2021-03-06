<?php

namespace Ess\M2ePro\Setup\UpgradeDevelopment\v1_0_0__v1_1_0;

use Ess\M2ePro\Model\Setup\Upgrade\Entity\AbstractFeature;

class SupportURLsImprovements extends AbstractFeature
{
    //########################################

    public function execute()
    {
        $this->getConfigModifier('module')->getEntity('/support/', 'knowledge_base_url')->delete();
        $this->getConfigModifier('module')->getEntity('/support/', 'knowledge_ebay_url')->delete();
        $this->getConfigModifier('module')->getEntity('/support/', 'knowledge_amazon_url')->delete();
        $this->getConfigModifier('module')->getEntity('/support/', 'community_ebay_url')->delete();
        $this->getConfigModifier('module')->getEntity('/support/', 'community_amazon_url')->delete();
        $this->getConfigModifier('module')->getEntity('/support/', 'ideas_base_url')->delete();
        $this->getConfigModifier('module')->getEntity('/support/', 'ideas_ebay_url')->delete();
        $this->getConfigModifier('module')->getEntity('/support/', 'ideas_amazon_url')->delete();
        $this->getConfigModifier('module')->getEntity('/support/', 'community_base_url')->updateKey('forum_url');
        $this->getConfigModifier('module')->getEntity('/support/', 'main_website_url')->updateKey('website_url');
        $this->getConfigModifier('module')->getEntity('/support/', 'main_support_url')->updateKey('support_url');
        $this->getConfigModifier('module')->getEntity('/support/', 'documentation_url')->updateValue(
            'https://docs.m2epro.com/'
        );
    }

    //########################################
}