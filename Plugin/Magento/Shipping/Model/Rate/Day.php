<?php
/**
 * Bhaveshpp 
 *
 * This code is developed by Bhavesh Prajapati
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @authors https://github.com/bhaveshpp
 */

namespace Bhaveshpp\ShippingRestrictionOverMonth\Model\Config\Source;

class Day implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $return = [];
        for ($i=1; $i <= 31 ; $i++) { 
            $return[] = ['value' => $i, 'label' => $i];
        }
        return $return;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $return = [];
        for ($i=1; $i <= 31 ; $i++) { 
            $return[$i] = $i;
        }
        return $return;
    }
}