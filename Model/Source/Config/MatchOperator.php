<?php

namespace WeProvide\NginxRedirect\Model\Source\Config;

use Magento\Framework\Data\OptionSourceInterface;

class MatchOperator implements OptionSourceInterface
{
    private $defaultMatchOperator;
    private $matchOperators;

    public function __construct(string $defaultMatchOperator, array $matchOperators)
    {
        $this->defaultMatchOperator = $matchOperators[$defaultMatchOperator];
        $this->matchOperators       = $matchOperators;
    }

    public function toOptionArray()
    {
        $matchOperatorCodes = array_keys($this->matchOperators);

        return array_map(function($matchOperatorCode) {
            $matchOperator = $this->matchOperators[$matchOperatorCode];

            return [
                'label' => $matchOperator['label'],
                'value' => $matchOperatorCode
            ];
        }, $matchOperatorCodes);
    }
}
