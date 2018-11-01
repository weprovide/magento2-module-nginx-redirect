<?php

namespace WeProvide\NginxRedirect\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use WeProvide\NginxRedirect\Model\ResourceModel\Redirect\CollectionFactory;

class RedirectDataProvider extends AbstractDataProvider
{
    protected $collection;

    public function __construct(
        CollectionFactory $collection,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collection->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $collection = $this->getCollection();

        $arrItems = [];
        foreach ($collection as $item) {
            $arrItems[$item->getId()] = $item->toArray([]);
        }

        return $arrItems;
    }
}