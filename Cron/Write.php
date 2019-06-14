<?php

namespace WeProvide\NginxRedirect\Cron;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Psr\Log\LoggerInterface;
use WeProvide\NginxRedirect\Exception\Source\Config\MatchOperator\UnknownMatchOperator;
use WeProvide\NginxRedirect\Model\ResourceModel\Redirect\CollectionFactory as RedirectCollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use WeProvide\NginxRedirect\Model\Source\Config\MatchOperator as MatchOperatorSource;
use WeProvide\NginxRedirect\Model\Source\Config\MatchOperator;

class Write
{
    const MODULE = 'WeProvide_NginxRedirects';
    const PATH = 'weprovide_nginxredirect/path/path';

    protected $redirectCollectionFactory;
    protected $scopeConfig;
    protected $filesystem;
    protected $logger;
    protected $matchOperatorSource;

    /**
     * Write constructor.
     * @param RedirectCollectionFactory $redirectCollectionFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param Filesystem $filesystem
     * @param LoggerInterface $logger
     * @param MatchOperatorSource $matchOperatorSource
     */
    public function __construct(
        RedirectCollectionFactory $redirectCollectionFactory,
        ScopeConfigInterface $scopeConfig,
        Filesystem $filesystem,
        LoggerInterface $logger,
        MatchOperatorSource $matchOperatorSource
    ) {
        $this->redirectCollectionFactory = $redirectCollectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->filesystem = $filesystem;
        $this->logger = $logger;
        $this->matchOperatorSource = $matchOperatorSource;
    }

    public function execute()
    {
        $redirects = $this->redirectCollectionFactory->create()->toArray()['items'];

        // concatenate all redirects so that the file only has to be written to once
        $redirects = array_reduce($redirects, function($accumulator, $redirect) {
            $accumulator .= $this->parse($redirect) . PHP_EOL;
            return $accumulator;
        }) ?: '';

        if(($path = $this->getPath()) !== null) {
            try {
                $root = $this->filesystem->getDirectoryWrite(DirectoryList::ROOT);
                $root->writeFile($path, $redirects);
            } catch(FileSystemException $exception) {
                $this->logger->warning(self::MODULE . ' failed to write to "' . $path . '" (' . $exception->getLogMessage() . ')');
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
        $matchOperator = $this->getMatchOperator($redirect);
        return 'location' . $matchOperator . ($matchOperator ? ' ' : '') . '/' . $redirect['source'] . ' { return ' . $redirect['status'] . ' ' . $redirect['target'] . '; }';
    }

    protected function getMatchOperator($redirect)
    {
        $matchOperatorCode = $redirect->getMatchOperator();

        try {
            $matchOperator = $this->matchOperatorSource->getMatchOperatorByCodeOrDefault($matchOperatorCode);
            return $matchOperator['operator'];
        } catch (UnknownMatchOperator $exception) {
            $this->logger->warning($exception->getMessage());
            return '';
        }
    }
}
