<?php

namespace WeProvide\NginxRedirect\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use WeProvide\NginxRedirect\Model\ResourceModel\Redirect\CollectionFactory;

class RedirectDataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $redirectCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $redirectCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $redirect) {
            $this->loadedData[$redirect->getId()] = $redirect->getData();
        }

        return $this->loadedData;
    }
}