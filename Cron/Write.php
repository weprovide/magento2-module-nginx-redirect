<?php

namespace WeProvide\NginxRedirect\Cron;

use Psr\Log\LoggerInterface;
use WeProvide\NginxRedirect\Model\ResourceModel\Redirect\CollectionFactory as RedirectCollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Write
{
    const MODULE = 'WeProvide_NginxRedirects';
    const PATH = 'weprovide_nginxredirect/path/path';

    protected $redirectCollectionFactory;
    protected $scopeConfig;
    protected $logger;

    /**
     * Write constructor.
     * @param RedirectCollectionFactory $redirectCollectionFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param LoggerInterface $logger
     */
    public function __construct(
        RedirectCollectionFactory $redirectCollectionFactory,
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $logger
    ) {
        $this->redirectCollectionFactory = $redirectCollectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
    }

    public function execute()
    {
        $redirects = $this->redirectCollectionFactory->create()->toArray()['items'];

        // concatenate all redirects so that the file only has to be written to once
        $redirects = array_reduce($redirects, function($accumulator, $redirect) {
            $accumulator .= $this->parse($redirect) . PHP_EOL;
            return $accumulator;
        }, '');

        if(($path = $this->getPath()) !== null) {
            // TODO: pass the LOCK_EX flag?
            $result = file_put_contents($path, $redirects);

            if($result === false) {
                $this->logger->warning(self::MODULE . ' failed to write to "' . $path . '"');
            }
        } else {
            $this->logger->warning(self::MODULE . ' is not properly configured, there is no path to write the redirects to.');
        }
    }

    /**
     * @return string|null
     */
    protected function getPath() {
        return $this->scopeConfig->getValue(self::PATH) ?: null;
    }


    /**
     * @param \WeProvide\NginxRedirect\Model\Redirect $redirect
     * @return string
     */
    protected function parse($redirect) {
        return 'location /' . $redirect['source'] . ' { return ' . $redirect['status'] . ' ' . $redirect['target'] . '; }';
    }
}