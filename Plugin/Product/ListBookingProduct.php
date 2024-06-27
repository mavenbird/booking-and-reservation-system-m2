<?php
/**
 * Mavenbird Technologies Private Limited
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://mavenbird.com/Mavenbird-Module-License.txt
 *
 * =================================================================
 *
 * @category   Mavenbird
 * @package    Mavenbird_OrderInformation
 * @author     Mavenbird Team
 * @copyright  Copyright (c) 2018-2024 Mavenbird Technologies Private Limited ( http://mavenbird.com )
 * @license    http://mavenbird.com/Mavenbird-Module-License.txt
 */
namespace Mavenbird\BookingSystem\Plugin\Product;

use Magento\Catalog\Model\ProductFactory as CoreProductFactory;

class ListBookingProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    protected $_bookingHelper;
    /**
     * @var CoreProductFactory
     */
    private $product;
    /**
     * @var \Magento\Framework\Registry $registry
     */
    private $_registry;

    /**
     * @param \Mavenbird\BookingSystem\Helper\Data $bookingHelper
     * @param CoreProductFactory $product
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Mavenbird\BookingSystem\Helper\Data $bookingHelper,
        CoreProductFactory $product,
        \Magento\Framework\Registry $registry
    ) {
        $this->_bookingHelper = $bookingHelper;
        $this->product = $product;
        $this->_registry = $registry;
    }

    /**
     * Get loaded product collection
     *
     * @param \Magento\Catalog\Block\Product\ListProduct $subject
     * @param array $result
     * @return array
     */
    public function afterGetLoadedProductCollection(
        \Magento\Catalog\Block\Product\ListProduct $subject,
        $result
    ) {
        try {
            $bookingProductIds = [];
            $product = $this->product->create()->getCollection()
            ->addFieldToFilter(
                'type_id',
                \Mavenbird\BookingSystem\Model\Product\Type\Booking::TYPE_CODE
            );
            $productCollection = $this->product->create();
            $currentCategory = $this->_registry->registry('current_category');
            $currentCategoryId = ($currentCategory)? $currentCategory->getId() :'';
            foreach ($product->getData() as $val) {
                $proStatus = $this->product->create()->load($val['entity_id'])->getStatus();
                if ($proStatus == 1) {
                    $bookingProductIds[] = $val['entity_id'];
                }
            }
            $existingEntityIds = [];
            foreach ($result as $value) {
                $existingEntityIds[] = $value->getEntityId();
            }
            foreach ($bookingProductIds as $v) {
                if (!in_array($v, $existingEntityIds)) {
                    if (in_array($currentCategoryId, $productCollection->load($v)->getCategoryIds())) {
                        $result->addItem($productCollection->load($v));
                    }
                }
            }
        } catch (\Exception $e) {
            $this->_bookingHelper
                ->logDataInLogger("Plugin_Product_ListProduct : ".$e->getMessage());
        }
        return $result;
    }
}
