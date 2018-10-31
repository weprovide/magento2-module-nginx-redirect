<?php

namespace WeProvide\NginxRedirect\Block\Adminhtml\Redirect;

use WeProvide\NginxRedirect\Helper\Helper;

class Index extends \Magento\Backend\Block\Template
{
    protected $helper;

    /**
     * Index constructor.
     * @param Helper                                  $helper
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array                                   $data
     */
    public function __construct(
        Helper $helper,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    public function getContent()
    {
//        return $this->helper->getFile();
    }
}
