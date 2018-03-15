<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/module-seo
 * @version   1.0.38
 * @copyright Copyright (C) 2016 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\SeoSitemap\Api\Config;

interface LinkSitemapConfigInterface
{
    /**
     * @param null|string $store
     * @return array
     */
    public function getAdditionalLinks($store);

    /**
     * @param null|string $store
     * @return array
     */
    public function getExcludeLinks($store);

}