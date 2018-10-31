<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace WeProvide\NginxRedirect\Controller\Adminhtml\Step;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class MassDelete
{

    /**
     * Delete Step
     *
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
//        $ids        = $this->getRequest()->getParam('selected');
//        $collection = $this->stepFactory->create()->getCollection()->addFieldToFilter('step_id', ['in' => $ids]);
//        $this->deleteSteps($ids);
//
//        foreach ($collection as $step) {
//            $step->delete();
//        }
//
//        $this->_redirect('proavmountadvisor/step/');
    }

    /**
     * Delete steps and childs
     *
     * @param $ids
     */
    public function deleteSteps($ids)
    {
//        if (count($ids) === 0) {
//            return;
//        }
//
//        $collection = $this->stepFactory->create()->getCollection()->addFieldToFilter('parent_id', ['in' => $ids]);
//        $childIds   = [];
//        foreach ($collection as $step) {
//            $childIds[] = $step->getId();
//            $step->delete();
//        }
//
//        $this->deleteSteps($childIds);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
//
    }
}
