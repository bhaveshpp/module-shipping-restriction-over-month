namespace Bhaveshpp\ShippingRestrictionOverMonth\Model\Config\Source;
use Magento\Shipping\Model\Config as ShippingConfig;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Option\ArrayInterface;

/**
 * Class ShippingMethod
 */
class ShippingMethod implements ArrayInterface
{
    /**
     * Core store config
     *
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    
    /**
     * Get shipping methods
     *
     * @var ShippingConfig $shippingConfig
     */
    protected $shippingConfig;

    /**
     * Initialize
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ShippingConfig $shippingConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ShippingConfig $shippingConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->shippingConfig = $shippingConfig;
    }

    /**
     * Return Shipping carriers grouped array
     *
     * @return array
     */
    public function getAllMethods()
    {
        $methods = [];
        $carriers = $this->shippingConfig->getAllCarriers();

        /** @var \Magento\Shipping\Model\Carrier\CarrierInterface $carrierModel */
        foreach ($carriers as $carrierCode => $carrierModel) {

            if (!$carrierModel->isActive()) {
                continue;
            }

            $carrierMethods = $carrierModel->getAllowedMethods();

            if (!$carrierMethods) {
                continue;
            }

            $carrierTitle = $this->scopeConfig->getValue(
                'carriers/' . $carrierCode . '/title',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );

            if (empty($carrierTitle) || ctype_space($carrierTitle)) {
                $carrierTitle = $carrierCode;
            }
            // $methods[$carrierCode] = $carrierTitle;
            $methods[$carrierCode] = [
                'label' => $carrierTitle,
                'value' => $this->getRates($carrierMethods)
            ];
        }
        
        return $methods;
    }

    /**
     * Get shipping carrier allowd rates
     *
     * @param array $carrierMethods
     * @return array
     */
    public function getRates($carrierMethods = [])
    {
        foreach ($carrierMethods as $key => $value) {
            $rate[] = [
                'label' => $value,
                'value' => $key
            ];
        }
        return $rate;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->getAllMethods();
    }

}

