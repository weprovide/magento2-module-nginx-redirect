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
        $counter = $collection->getSize();

        $arrItems = [
            'totalRecords' => $counter,
            'items' => [],
        ];

        foreach ($collection as $item) {
            $arrItems['items'][] = $item->toArray([]);
        }

        return $arrItems;
    }
}