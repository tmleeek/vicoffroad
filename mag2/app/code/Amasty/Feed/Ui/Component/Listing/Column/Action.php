<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2016 Amasty (https://www.amasty.com)
 * @package Amasty_Feed
 */


namespace Amasty\Feed\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Action extends Column
{
    protected $urlBuilder;
    protected $urlFactory;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        \Magento\Framework\UrlFactory $urlFactory,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->urlFactory = $urlFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    protected function getUrlInstance()
    {
        return $this->urlFactory->create();
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['entity_id'])) {
                    $viewUrlPath = $this->getData('config/viewUrlPath') ?: '#';
                    $urlEntityParamName = $this->getData('config/urlEntityParamName') ?: 'entity_id';

                    $item[$this->getData('name')] = [
                        'view' => [
                            'href' => $this->urlBuilder->getUrl(
                                $viewUrlPath,
                                [
                                    $urlEntityParamName => $item['entity_id']
                                ]
                            ),
                            'label' => __('View')
                        ],
                        'download' => [
                            'href' => $item['generated_at'] ? $this->_getDownloadHref($item['filename'], $item['orig_store_id']) : '#',
                            'label' => __('Download')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }

    protected function _getDownloadHref($filename, $storeId)
    {
        $urlInstance = $this->getUrlInstance();

        $routeParams = [
            '_direct' => 'amfeed/feed/download',
            '_query' => array(
                'filename' => $filename
            )
        ];

        $href = $urlInstance
            ->setScope($storeId)
            ->getUrl(
            '',
            $routeParams
        );

        return $href;
    }
}