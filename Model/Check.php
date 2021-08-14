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

namespace Bhaveshpp\ShippingRestrictionOverMonth\Model;
use Magento\Checkout\Model\Cart;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Check and return allowed methods
 */
class Check  
{

    /**
     * system config is enable index
     */
    const CONFIG_ENABLE = "shipping_rescriction/general/enable";

    /**
     * system config from day index
     */

    const CONFIG_FROM_DAY = "shipping_rescriction/from/from_day";
    
    /**
     * system config from month index
     */
    const CONFIG_FROM_MONTH = "shipping_rescriction/from/from_month";
    
    /**
     * system config to day index
     */
    const CONFIG_TO_DAY = "shipping_rescriction/to/to_day";
    
    /**
     * system config from month index
     */
    const CONFIG_TO_MONTH = "shipping_rescriction/to/to_month";
    
    /**
     * system config allowed method index
     */
    const CONFIG_ALLOWED_METHOD = "shipping_rescriction/shipping_method/allowed_method";

    /**
     * @var Cart $cart
     */
    protected $cart;
    
    /**
     * @var ProductRepository $productRepository
     */
    protected $productRepository;
    
    /**
     * @var DateTime $dateTime
     */
    protected $dateTime;
    
    /**
     * @var ScopeConfigInterface $scopConfig
     */
    protected $scopConfig;

    /**
     * Initialize
     *
     * @param Cart $cart
     * @param ProductRepository $productRepository
     * @param DateTime $dateTime
     * @param ScopeConfigInterface $scopConfig
     */
    public function __construct(
        Cart $cart,
        ProductRepository $productRepository,
        DateTime $dateTime,
        ScopeConfigInterface $scopConfig
    )
    {
        $this->cart = $cart;
        $this->productRepository = $productRepository;
        $this->dateTime = $dateTime;
        $this->scopConfig = $scopConfig;
    }

    /**
     * Check and return all allowd methods
     *
     * @param array $rates
     * @return array
     */
    public function checkAndReturn($rates)
    {
        if ($this->scopConfig->getValue(self::CONFIG_ENABLE)) {
            return $this->getAllowedMethods($rates);
        }
        return $rates;

    }
    
    /**
     * Return all allowd methods
     *
     * @param array $rates
     * @return array
     */
    public function getAllowedMethods($rates)
    {
        if ($this->getDateCondition() && $this->checkCartItems()) {   
            foreach ($rates as $key => $rate) {
                if ($rate->getData('method') != $this->scopConfig->getValue(self::CONFIG_ALLOWED_METHOD)) {
                    unset($rates[$key]);
                }
            }
        }
        return $rates;
    }

    /**
     * Check cart items has restricted item
     *
     * @return bool
     */
    public function checkCartItems()
    {
        $items = $this->cart->getQuote()->getAllItems();
        foreach ($items as $key => $item) {
            $product = $this->productRepository->getById($item->getProductId());
            if ($product->getData('is_shipping_restricted')) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check current date meet condition
     *
     * @return void
     */
    public function getDateCondition()
    {
        $date['day'] = (int)$this->dateTime->date('d'); 
        $date['month'] = (int)$this->dateTime->date('m'); 

        // get config value
        $from['day'] = (int)$this->scopConfig->getValue(self::CONFIG_FROM_DAY);
        $from['month'] = (int)$this->scopConfig->getValue(self::CONFIG_FROM_MONTH);

        $to['day'] = (int)$this->scopConfig->getValue(self::CONFIG_TO_DAY);
        $to['month'] = (int)$this->scopConfig->getValue(self::CONFIG_TO_MONTH);

        if (($from['month'] <= $date['month']) && ($date['month'] <= $to['month'])) {
            if ($from['month'] == $date['month']) {
                if($from['day'] <= $date['day']){
                    return true;
                }
            }
            elseif ($to['month'] == $date['month']) {
                if($to['day'] >= $date['day']){
                    return true;
                }
            }else{
                return true;
            }
        }
        return false;
    }

}
