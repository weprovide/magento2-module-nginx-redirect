<?php

namespace WeProvide\NginxRedirect\Model\ResourceModel\Redirect;

use WeProvide\NginxRedirect\Model\Redirect;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'weprovide_nginxredirect_redirect_collection';
    protected $_eventObject = 'redirect_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Redirect::class, \WeProvide\NginxRedirect\Model\ResourceModel\Redirect::class);
    }
}
