<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace WeProvide\NginxRedirect\Block\Adminhtml\Redirect\Edit;

use Magento\Cms\Block\Adminhtml\Block\Edit\GenericButton;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Cms\Api\BlockRepositoryInterface;

/**
 * Class DeleteButton
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    private $registry;

    private $urlBuilder;

    public function __construct(
        Registry $registry,
        Context $context,
        BlockRepositoryInterface $blockRepository
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
        parent::__construct($context, $blockRepository);
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
//        $step = $this->registry->registry(\WeProvide\ProAVMountAdvisor\Model\RegistryConstants::CURRENT_PROAVMOUNTADVISOR_RULE);
//        $stepId = $step->getId();
//        if ($stepId) {
//            $data = [
//                'label' => __('Delete'),
//                'class' => 'delete',
//                'on_click' => 'deleteConfirm(\'' . __(
//                        'Are you sure you want to delete this?'
//                    ) . '\', \'' . $this->urlBuilder->getUrl('*/*/delete', ['id' => $stepId]) . '\')',
//                'sort_order' => 20,
//            ];
//        }
        return $data;
    }
}
