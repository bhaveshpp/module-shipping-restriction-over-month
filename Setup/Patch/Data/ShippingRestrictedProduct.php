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
namespace Tecksky\ShippingRestrictionOverMonth\Setup\Patch\Data;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDatasetupInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Catalog\Model\Product\Attribute\Source\Boolean as SourceBoolean;
use Magento\Catalog\Model\Product\Attribute\Backend\Boolean as BackendBoolean;

/**
 * Class ShippingRestrictedProduct
 */
class ShippingRestrictedProduct implements DataPatchInterface 
{
    /**
     * @var EavSetupFactory $eavSetupFactory
     */
    protected $eavSetupFactory;
    
    /**
     * @var ModuleDataSetupInterface $moduleDataSetup
     */
    protected $moduleDataSetup;
    
    /**
     * Initialize
     *
     * @param EavSetupFactory $eavSetupFactory
     * @param ModuleDataSetupInterface $moduleDataSetup
     */ 
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * Add product attirbute 
     * Run patch
     *
     * @return void
     */
    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute('catalog_product','is_shipping_restricted',[
            'type' => 'int',
            'label' => 'Is Shipping Restricted',
            'input' => 'boolean',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'backend' => BackendBoolean::class,
            'source' => SourceBoolean::class,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'default' => 0,
            'visible' => true,
            'used_in_product_listing' => true,
            'user_defined' => true,
            'required' => false,
            'group' => 'General',
            'sort_order' => 80
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getDependencies() {
        return [];
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAliases() {
        return [];
    }

}