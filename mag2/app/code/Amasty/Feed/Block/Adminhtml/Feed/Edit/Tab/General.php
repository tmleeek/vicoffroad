<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Feed
 */

namespace Amasty\Feed\Block\Adminhtml\Feed\Edit\Tab;

use Magento\Backend\Block\Widget\Form;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class General extends Generic implements TabInterface{
    protected $_systemStore;
    protected $_executeModeList;
    protected $_compressSource;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Amasty\Feed\Model\Resource\Feed\Grid\ExecuteModeList $executeModeList,
        \Amasty\Feed\Model\Config\Source\Compress $compressSource,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_executeModeList = $executeModeList;
        $this->_compressSource = $compressSource;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    public function getTabLabel()
    {
        return __('General');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     * @codeCoverageIgnore
     */
    public function getTabTitle()
    {
        return __('General');
    }

    /**
     * Returns status flag about this tab can be showed or not
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return bool
     * @codeCoverageIgnore
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @return Form
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('current_amfeed_feed');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('feed_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('General Information')]);

        if ($model->getId()) {
            $fieldset->addField('entity_id', 'hidden', ['name' => 'feed_entity_id']);
        } else {
            $model->setData('is_active', 1);

            $model->setData('csv_column_name', 1);

            $model->setData('format_price_currency_show', 1);
            $model->setData('format_price_decimals', 'two');
            $model->setData('format_price_decimal_point', 'dot');
            $model->setData('format_price_thousands_separator', 'comma');

            $model->setData('format_date', 'Y-m-d');
        }

        $fieldset->addField(
            'name',
            'text',
            ['name' => 'name', 'label' => __('Name'), 'title' => __('Name'), 'required' => true]
        );

        $fieldset->addField(
            'filename',
            'text',
            ['name' => 'filename', 'label' => __('File Name'), 'title' => __('File Name'), 'required' => true]
        );

        $typeOptions = [
            'label' => __('Type'),
            'title' => __('Type'),
            'name' => 'feed_type',
            'required' => true,

            'options' => ['csv' => __('CSV'), 'xml' => __('XML'), 'txt' => 'TXT']
        ];

        if ($model->getId()) {
            $typeOptions['readonly'] = true;
        }

        $fieldset->addField(
            'feed_type',
            'select',
            $typeOptions
        );

        $fieldset->addField(
            'store_id',
            'select',
            [
                'name' => 'store_id',
                'label' => __('Store'),
                'title' => __('Store'),
                'required' => true,
                'options' => $this->_systemStore->getStoreOptionHash()
            ]
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'is_active',
                'required' => true,
                'options' => ['1' => __('Active'), '0' => __('Inactive')]
            ]
        );

        $fieldset->addField(
            'execute_mode',
            'select',
            [
                'label' => __('Execution mode'),
                'name' => 'execute_mode',
                'options' => $this->_executeModeList->toOptionArray()
            ]
        );

        $fieldset->addField('cron_time', 'multiselect', array(
            'label'    => __('Cron Execution Time'),
            'name'     => 'cron_time[]',
            'values'   => $this->_getCronTime(),
            'value' => !empty($model->getCronTime()) ? explode(",", $model->getCronTime()) : null
        ));

        $fieldset->addField(
            'compress',
            'select',
            [
                'label' => __('Compress'),
                'name' => 'compress',
                'options' => $this->_compressSource->toArray()
            ]
        );

        $form->setValues($model->getData());

        $this->setForm($form);

        return parent::_prepareForm();
    }


    protected function _getCronTime($vl = true)
    {
        $stTime = strtotime('2010-10-10');
        $times = array();

        for($time = 0; $time < 24 * 60; $time += 30){
            if ($vl) {
                $times[] = array(
                    'value' => $time,
                    'label' => date('g:i A', $stTime + ($time * 60))
                );
            } else {
                $times[$time] = date('g:i A', $stTime + ($time * 60));
            }

        }

        return $times;
    }
}