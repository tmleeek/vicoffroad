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
 * @package   mirasvit/module-search-autocomplete
 * @version   1.0.44
 * @copyright Copyright (C) 2016 Mirasvit (https://mirasvit.com/)
 */


namespace Mirasvit\SearchAutocomplete\Console\Command;

use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Mirasvit\SearchAutocomplete\Model\Warmer;

class CacheCommand extends Command
{
    /**
     * @var \Magento\Framework\App\State
     */
    protected $appState;

    /**
     * @var Warmer
     */
    protected $warmer;

    /**
     * @param State  $appState
     * @param Warmer $warmer
     */
    public function __construct(
        State $appState,
        Warmer $warmer
    ) {
        $this->appState = $appState;
        $this->warmer = $warmer;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('mirasvit:autocomplete:cache')
            ->setDescription('Generate cache for most popular search queries')
            ->setDefinition([]);

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->appState->setAreaCode('frontend');

        $this->warmer->warm();
    }
}
