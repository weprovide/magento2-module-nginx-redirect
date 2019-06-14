<?php

namespace WeProvide\NginxRedirect\Model\Source\Config;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\Exception\LocalizedException;

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
     * @throws LocalizedException
     */
    public function getMatchOperatorByCodeOrDefault(string $matchOperatorCode = null): array
    {
        return $this->matchOperators[$matchOperatorCode] ?? $this->getDefaultMatchOperator();
    }

    /**
     * @return array
     * @throws LocalizedException
     */
    public function getDefaultMatchOperator(): array
    {
        if (!isset($this->matchOperators[$this->defaultMatchOperator])) {
            throw new LocalizedException(__('Default match operator ("' . $this->defaultMatchOperator . '") does not exist."'));
        }

        return $this->matchOperators[$this->defaultMatchOperator];
    }
}
