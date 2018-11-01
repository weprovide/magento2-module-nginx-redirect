<?php

namespace WeProvide\NginxRedirect\Model;

class Redirect extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'nginxredirect';

    protected $_cacheTag = 'nginxredirect';

    protected $_eventPrefix = 'nginxredirect';


    protected function _construct()
    {
        $this->_init(\WeProvide\NginxRedirect\Model\ResourceModel\Redirect::class);
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG ];
    }
}
