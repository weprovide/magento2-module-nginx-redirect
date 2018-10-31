<?php

namespace WeProvide\NginxRedirect\Cron;

use WeProvide\NginxRedirect\Model\ResourceModel\Redirect\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Write
{
    const PATH = 'weprovide_nginxredirect/path/path';

    protected $collection;
    protected $scopeConfig;

    public function __construct(
        CollectionFactory $collection,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->collection = $collection;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute()
    {
        $redirects = $this->collection->create();
        $file = $this->scopeConfig->getValue(self::PATH);

        if ($data = fopen($_SERVER['DOCUMENT_ROOT'] . $file, "wb")) {

            foreach ($redirects as $redirect) {
                $line = 'location /' . $redirect->getSource() . ' { return ' . $redirect->getStatus() . ' ' . $redirect->getTarget() . '; }' . PHP_EOL;
                fwrite($data, $line);
            }
            fclose($data);
        }
    }
}