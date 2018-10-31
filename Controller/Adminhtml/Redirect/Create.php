<?php


namespace WeProvide\NginxRedirect\Controller\Adminhtml\Redirect;

use Magento\Framework\Controller\ResultFactory;

class Create extends \WeProvide\NginxRedirect\Controller\Adminhtml\Redirect\Index
{
    public function execute()
    {
        $forward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        return $forward->forward('edit');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return parent::_isAllowed();
    }
}
