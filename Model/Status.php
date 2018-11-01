<?php
namespace WeProvide\NginxRedirect\Model;



use Magento\Framework\Option\ArrayInterface;

class Status implements ArrayInterface
{

    /**
     * Permanent redirect code
     */
    const PERMANENT = 301;

    /**
     * Redirect code
     */
    const TEMPORARY = 302;

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {

        $options = [
            [
                'label' => 'Temporary (302)',
                'value' => self::TEMPORARY
            ],
            [
                'label' => 'Permanent (301)',
                'value' =>  self::PERMANENT
            ]
        ];

        return $options;

    }
}

