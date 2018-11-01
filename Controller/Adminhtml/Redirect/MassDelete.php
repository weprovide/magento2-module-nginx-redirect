<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace WeProvide\NginxRedirect\Controller\Adminhtml\Redirect;

class MassDelete extends Index
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
        $ids = $this->getRequest()->getParam('selected');

        if ($ids) {
            $idsString = implode(',', $ids);
            $collection = $this->collectionFactory->create()->addFieldToFilter('id', ['in' => $ids]);

            foreach ($collection as $redirect) {
                $redirect->delete();
            }
            $this->messageManager->addSuccessMessage(__('Redirect(s) %s successfully deleted.'), $idsString);
        }
        $this->_redirect('nginxredirect/redirect/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return parent::_isAllowed();

    }
}
