<?php


namespace WeProvide\NginxRedirect\Controller\Adminhtml\Redirect;

class Create extends Index
{
    public function execute()
    {
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Create new Nginx Redirect'));
        return $this->resultPageFactory->create();
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return parent::_isAllowed();
    }
}
