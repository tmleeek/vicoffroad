<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Shopby
 */


/**
 * Copyright © 2016 Amasty. All rights reserved.
 */

namespace Amasty\Shopby\Block\Adminhtml\Option;

use Amasty\Shopby\Helper\FilterSetting as FilterSettingHelper;
use Amasty\Shopby\Helper\OptionSetting;

class Settings extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected $objectManager;

    protected $renderer;

    /** @var  OptionSetting */
    protected $settingHelper;

    /** @var FilterSettingHelper  */
    protected $filterSettingHelper;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Amasty\Shopby\Block\Adminhtml\Form\Renderer\Fieldset\Element $renderer,
        OptionSetting $settingHelper,
        FilterSettingHelper $filterSettingHelper,
        array $data = []
    ) {
        $this->objectManager = $objectManager;
        $this->renderer = $renderer;
        $this->settingHelper = $settingHelper;
        $this->filterSettingHelper = $filterSettingHelper;
        parent::__construct($context, $registry, $formFactory, $data);
    }


    protected function _prepareForm()
    {
        $filterCode = $this->getRequest()->getParam('filter_code');
        $optionId = $this->getRequest()->getParam('option_id');
        $storeId = $this->getRequest()->getParam('store', 0);
        $model = $this->settingHelper->getSettingByValue($optionId, $filterCode, $storeId);
        $model->setCurrentStoreId($storeId);

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_options_form',
                    'class' => 'admin__scope-old',
                    'action' => $this->getUrl('*/*/save', ['option_id'=>(int)$optionId, 'filter_code'=>$filterCode, 'store'=>(int)$storeId]),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                ],
            ]
        );
        $form->setUseContainer(true);
        $form->setFieldsetElementRenderer($this->renderer);
        $form->setDataObject($model);

        /**
         * Features not yet implemented
         */
        //$this->addGeneralFieldset($form);

        $this->_eventManager->dispatch('amshopby_option_form_build_after', ['form' => $form, 'setting' => $model]);

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    protected function addGeneralFieldset(\Magento\Framework\Data\Form $form)
    {
        $generalFieldset = $form->addFieldset('base_fieldset', ['legend' => __('General'), 'class'=>'form-inline']);
        $listYesNo = $this->objectManager->create('Magento\Config\Model\Config\Source\Yesno')->toOptionArray();

        $generalFieldset->addField(
            'is_featured',
            'select',
            ['name' => 'is_featured', 'label' => __('Featured'), 'title' => __('Featured'), 'values'=>$listYesNo]
        );
    }
}
