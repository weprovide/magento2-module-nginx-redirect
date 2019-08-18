<?php

namespace WeProvide\NginxRedirect\Controller\Adminhtml\Redirect;

use WeProvide\NginxRedirect\Model\ResourceModel\Redirect\CollectionFactory;

class Index extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Index constructor.
     * @param \Magento\Backend\App\Action\Context        $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param CollectionFactory                          $collectionFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Nginx Redirects'));
        return $resultPage;
    }
}
