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



namespace Mirasvit\Seo\Test\Unit\Model\System\Config\Frontend;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManager;

/**
 * @covers \Mirasvit\Seo\Model\Config\Frontend\Category
 */
class CategoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Mirasvit\Seo\Model\Config\Frontend\Category|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $categoryModel;

    /**
     * setup tests.
     */
    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);
        $this->categoryModel = $this->objectManager->getObject(
            '\Mirasvit\Seo\Model\Config\Frontend\Category',
            [
            ]
        );
    }

    /**
     * dummy test.
     */
    public function testDummy()
    {
        $this->assertEquals($this->categoryModel, $this->categoryModel);
    }
}
