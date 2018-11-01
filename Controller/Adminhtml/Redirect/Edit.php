<?php

namespace WeProvide\NginxRedirect\Controller\Adminhtml\Redirect;

use WeProvide\NginxRedirect\Model\Redirect;
use WeProvide\NginxRedirect\Model\ResourceModel\Redirect\CollectionFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action\Context;

class Edit extends \WeProvide\NginxRedirect\Controller\Adminhtml\Redirect\Index
{
    protected $resultPageFactory;
    protected $redirect;
    protected $collection;

    /**
     * Edit constructor.
     * @param Context           $context
     * @param PageFactory       $resultPageFactory
     * @param CollectionFactory $collectionFactory
     * @param Redirect          $redirect
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        CollectionFactory $collectionFactory,
        Redirect $redirect
    ) {
        parent::__construct($context, $resultPageFactory, $collectionFactory);
        $this->redirect = $redirect;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if (!is_null($id)) {
            $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Edit Nginx Redirect'));
            $model = $this->redirect->load($id);
            if (is_null($model->getId())) {
                $this->messageManager->addError(__('This redirect no longer exists.'));
                $this->_redirect('nginxredirect/redirect/index');
                return;
            }
            $this->messageManager->addSuccessMessage(__('Redirect %s successfully edited.'), $id);
        }

        $this->messageManager->addSuccessMessage(__('Redirect successfully added.'));
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
