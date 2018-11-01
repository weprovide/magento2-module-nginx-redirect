<?php

namespace WeProvide\NginxRedirect\Controller\Adminhtml\Redirect;

use Magento\Backend\App\Action\Context;
use WeProvide\NginxRedirect\Model\RedirectFactory;
use Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\Controller\ResultFactory;
use WeProvide\NginxRedirect\Model\ResourceModel\Redirect\CollectionFactory;

class Delete extends Index
{
    protected $redirectFactory;

    /**
     * Delete constructor.
     * @param Context           $context
     * @param PageFactory       $resultPageFactory
     * @param CollectionFactory $collectionFactory
     * @param RedirectFactory   $redirectFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        CollectionFactory $collectionFactory,
        RedirectFactory $redirectFactory
    ) {
        parent::__construct($context, $resultPageFactory, $collectionFactory);
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * Delete Step
     *
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $redirect = $this->redirectFactory->create()->load($id);
                $redirect->delete();
                $this->messageManager->addSuccessMessage(__('Redirect %s successfully deleted.'), $id);
                return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('nginxredirect/redirect/index');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
                $id = (int)$this->getRequest()->getParam('id');
                if (!empty($id)) {
                    $this->_redirect('nginxredirect/redirect/edit', ['id' => $id]);
                } else {
                    $this->_redirect('nginxredirect/redirect/create');
                }
                return;
            } catch (\Exception $e) {
                $this->messageManager->addError(
                    __('Something went wrong while deleting the redirect data')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_redirect('nginxredirect/redirect/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
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
