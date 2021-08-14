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

/**
 * @api
 * @since 100.0.2
 */
class Month implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('January')], 
            ['value' => 2, 'label' => __('February')], 
            ['value' => 3, 'label' => __('March')], 
            ['value' => 4, 'label' => __('April')], 
            ['value' => 5, 'label' => __('May')], 
            ['value' => 6, 'label' => __('June')], 
            ['value' => 7, 'label' => __('July')], 
            ['value' => 8, 'label' => __('August')], 
            ['value' => 9, 'label' => __('September')], 
            ['value' => 10, 'label' => __('October')], 
            ['value' => 11, 'label' => __('November')], 
            ['value' => 12, 'label' => __('December')]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            1 => __('January'), 
            2 => __('February'), 
            3 => __('March'), 
            4 => __('April'), 
            5 => __('May'), 
            6 => __('June'), 
            7 => __('July'), 
            8 => __('August'), 
            9 => __('September'), 
            10 => __('October'), 
            11 => __('November'), 
            12 => __('December')
        ];
    }
}
