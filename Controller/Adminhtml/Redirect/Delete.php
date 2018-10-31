<?php

namespace WeProvide\NginxRedirect\Controller\Adminhtml\Redirect;

use Magento\Backend\App\Action\Context;
use WeProvide\NginxRedirect\Model\RedirectFactory;
use Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\Controller\ResultFactory;

class Delete extends \WeProvide\NginxRedirect\Controller\Adminhtml\Redirect\Index
{
    protected $redirectFactory;

    /**
     * Delete constructor.
     * @param RedirectFactory $redirectFactory
     * @param Context         $context
     * @param PageFactory     $resultPageFactory
     */
    public function __construct(
        RedirectFactory $redirectFactory,
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->redirectFactory = $redirectFactory;
        parent::__construct($context, $resultPageFactory);
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
                $this->_redirect('nginxredirect/redirect/edit', ['id' => $this->getRequest()->getParam('redirect_id')]);
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
