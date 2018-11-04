<?php

namespace WeProvide\NginxRedirect\Controller\Adminhtml\Redirect;

use Magento\Backend\Model\Session;
use Psr\Log\LoggerInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\File\Csv;
use WeProvide\NginxRedirect\Model\RedirectFactory;
use WeProvide\NginxRedirect\Model\ResourceModel\Redirect\CollectionFactory;
use WeProvide\NginxRedirect\Model\ResourceModel\RedirectFactory as RedirectResourceFactory;
use Magento\Framework\View\Result\PageFactory;

class Save extends Index
{
    protected $session;
    protected $logger;
    protected $redirectFactory;
    protected $redirectResourceFactory;

    /**
     * Save constructor.
     * @param Session                 $session
     * @param LoggerInterface         $logger
     * @param RedirectFactory         $redirectFactory
     * @param RedirectResourceFactory $redirectResourceFactory
     * @param Context                 $context
     * @param PageFactory             $resultPageFactory
     * @param CollectionFactory       $collectionFactory
     */
    public function __construct(
        Session $session,
        LoggerInterface $logger,
        RedirectFactory $redirectFactory,
        RedirectResourceFactory $redirectResourceFactory,
        Context $context,
        PageFactory $resultPageFactory,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context, $resultPageFactory, $collectionFactory);
        $this->session                 = $session;
        $this->logger                  = $logger;
        $this->redirectFactory         = $redirectFactory;
        $this->redirectResourceFactory = $redirectResourceFactory;
    }

    /**
     * Promo quote save action
     *
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            try {
                $model = $this->redirectFactory->create();

                $resourceModel = $this->redirectResourceFactory->create();
                $id            = $this->getRequest()->getParam('id');


                $data = $this->getRequest()->getPostValue();
                $data = $this->filterPostData($data);

                if ($id) {
                    $model = $model->load($id);
                } else {
                    unset($data['id']);
                }

                $model->addData($data);

                $resourceModel->save($model);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('nginxredirect/redirect/edit', ['id' => $model->getId()]);
                }

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
                    __('Something went wrong while saving the step data. Please review the error log.')
                );
                $this->logger->critical($e);
                $this->session->setPageData($data);
                $this->_redirect('nginxredirect/redirect/edit', ['id' => $this->getRequest()->getParam('id')]);
                return;
            }
        }
        $this->_redirect('nginxredirect/redirect/index');
    }

    /**
     * Filter category data
     *
     * @param array $rawData
     * @return array
     */
    protected function filterPostData(array $rawData)
    {
        $data = $rawData;
        if (isset($data['icon']) && is_array($data['icon'])) {
            if (!empty($data['icon']['delete'])) {
                $data['icon'] = null;
            } else {
                if (isset($data['icon'][0]['name']) && isset($data['icon'][0]['tmp_name'])) {
                    $this->imageUploader->moveFileFromTmp($data['icon'][0]['name']);
                    $data['icon'] = $data['icon'][0]['name'];
                } else {
                    unset($data['icon']);
                }
            }
        }

        return $data;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return parent::_isAllowed();
    }
}
