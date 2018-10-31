<?php

namespace WeProvide\NginxRedirect\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Helper
{
    const PATH = 'weprovide_nginxredirect/path/path';

    protected $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    protected function getPath()
    {
        return $this->scopeConfig->getValue(self::PATH);
    }

    public function getFile()
    {
//        $content = file_get_contents('/' . $this->getPath());
//
//        var_dump($content);
//        $a = 'b';
//
//        return $content;
    }
}