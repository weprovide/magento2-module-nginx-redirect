<?php

namespace WeProvide\NginxRedirect\Model\Source\Config;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Exception\LocalizedException;
use WeProvide\NginxRedirect\Exception\Source\Config\MatchOperator\UnknownMatchOperator;

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

    /**
     * @param string|null $matchOperatorCode
     * @return array
     * @throws UnknownMatchOperator
     */
    public function getMatchOperatorByCodeOrDefault(string $matchOperatorCode = null): array
    {
        return $this->matchOperators[$matchOperatorCode] ?? $this->getDefaultMatchOperator();
    }

    /**
     * @return array
     * @throws UnknownMatchOperator
     */
    public function getDefaultMatchOperator(): array
    {
        if (!isset($this->matchOperators[$this->defaultMatchOperator])) {
            throw new UnknownMatchOperator(__('Default match operator ("' . $this->defaultMatchOperator . '") does not exist."'));
        }

        return $this->matchOperators[$this->defaultMatchOperator];
    }
}
