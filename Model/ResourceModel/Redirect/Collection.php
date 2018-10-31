<?php

namespace WeProvide\NginxRedirect\Model\ResourceModel\Redirect;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'redirect_id';
    protected $_eventPrefix = 'weprovide_nginxredirect_redirect_collection';
    protected $_eventObject = 'redirect_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('WeProvide\NginxRedirect\Model\Redirect', 'WeProvide\NginxRedirect\Model\ResourceModel\Redirect');
    }
}