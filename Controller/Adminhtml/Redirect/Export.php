<?php

namespace WeProvide\NginxRedirect\Controller\Adminhtml\Redirect;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\File\Csv;
use WeProvide\NginxRedirect\Model\ResourceModel\Redirect\CollectionFactory;

class Export extends Index
{
    protected $csvProcessor;
    protected $fileFactory;
    protected $directoryList;

    /**
     * Export constructor.
     * @param \Magento\Backend\App\Action\Context        $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param CollectionFactory                          $collectionFactory
     * @param FileFactory                                $fileFactory
     * @param Csv                                        $csvProcessor
     * @param DirectoryList                              $directoryList
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        CollectionFactory $collectionFactory,
        FileFactory $fileFactory,
        Csv $csvProcessor,
        DirectoryList $directoryList
    )
    {
        parent::__construct($context, $resultPageFactory, $collectionFactory);
        $this->fileFactory       = $fileFactory;
        $this->csvProcessor      = $csvProcessor;
        $this->directoryList     = $directoryList;
    }

    public function execute()
    {
        $collection = $this->collectionFactory->create();
        $data       = $collection->getData();
        array_unshift($data, ['id', 'source', 'target', 'status']);
        $fileName = 'export.csv';
        $filePath = $this->directoryList->getPath(DirectoryList::VAR_DIR) . DIRECTORY_SEPARATOR . $fileName;
        $this->csvProcessor
            ->setEnclosure('"')
            ->setDelimiter(',')
            ->saveData($filePath, $data);

        $this->fileFactory->create(
            $fileName,
            [
                'type'  => "filename",
                'value' => $fileName,
                'rm'    => true,
            ],
            DirectoryList::VAR_DIR,
            'text/csv'
        );
    }
}
