<?php

namespace WeProvide\NginxRedirect\Model;

class Redirect extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'nginxredirect';

    protected $_cacheTag = 'nginxredirect';

    protected $_eventPrefix = 'nginxredirect';

//    public function __construct()
//    {
//        $this->_init('WeProvide\NginxRedirect\Model\ResourceModel\Redirect');
//    }

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = [])
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->_init('WeProvide\NginxRedirect\Model\ResourceModel\Redirect');
    }


    public function getIdentities()
    {

    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}