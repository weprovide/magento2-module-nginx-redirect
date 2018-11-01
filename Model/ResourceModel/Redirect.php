<?php

namespace WeProvide\NginxRedirect\Model\ResourceModel;

class Redirect extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('nginxredirects', 'id');
    }
}