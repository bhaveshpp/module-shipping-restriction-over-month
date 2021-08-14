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

namespace Bhaveshpp\ShippingRestrictionOverMonth\Plugin\Magento\Shipping\Model\Rate;
use Magento\Shipping\Model\Rate\Result as Subject;
use Bhaveshpp\ShippingRestrictionOverMonth\Model\Check;

/**
 * Class Result 
 */
class Result  
{
    /**
     * @var Check $checkModel
     */
    protected $checkModel;
    
    /**
     * initialize 
     *
     * @param Check $checkModel
     */
    public function __construct(Check $checkModel)
    {
        $this->checkModel = $checkModel;
    }

    /**
     * After Plugin
     *
     * @param Subject $subject
     * @param array $result
     * @return array
     */
    public function afterGetAllRates(Subject $subject, $result)
    {
        return $this->checkModel->checkAndReturn($result);
    }
}