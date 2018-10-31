<?php

namespace WeProvide\NginxRedirect\Controller\Adminhtml\Redirect;

use WeProvide\NginxRedirect\Model\Redirect;
use WeProvide\NginxRedirect\Model\ResourceModel\Redirect\CollectionFactory;

class Edit extends \WeProvide\NginxRedirect\Controller\Adminhtml\Redirect\Index
{
    protected $resultPageFactory;
    protected $coreRegistry;
    protected $redirect;
    protected $collection;


   public function __construct(
       \Magento\Framework\Registry $coreRegistry,
       Redirect $redirect,
       CollectionFactory $collection,
       \Magento\Backend\App\Action\Context $context,
       \Magento\Framework\View\Result\PageFactory $resultPageFactory
   )
   {
       $this->coreRegistry = $coreRegistry;
       $this->redirect = $redirect;
       $this->collection = $collection;
       parent::__construct($context, $resultPageFactory);
   }

    public function execute()
    {
//        var_dump($this->getRequest()); die('');
        $id = $this->getRequest()->getParam('id');


        if (!is_null($id)) {
            $model = $this->redirect->load($id);
            if (is_null($model->getRedirectId())) {
                $this->messageManager->addError(__('This rule no longer exists.'));
                $this->_redirect('nginxredirect/index');
                return;
            }
        }

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
