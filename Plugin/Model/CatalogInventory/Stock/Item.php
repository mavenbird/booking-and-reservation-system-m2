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
namespace Mavenbird\BookingSystem\Plugin\Model\CatalogInventory\Stock;

class Item
{
    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    protected $_bookingHelper;

    /**
     * @param \Mavenbird\BookingSystem\Helper\Data $bookingHelper
     */
    public function __construct(\Mavenbird\BookingSystem\Helper\Data $bookingHelper)
    {
        $this->_bookingHelper = $bookingHelper;
    }

    /**
     * Function afterGetQty
     *
     * @param \Magento\CatalogInventory\Model\Stock\Item $subject
     * @param array $result
     * @return array|int
     */
    public function afterGetQty(\Magento\CatalogInventory\Model\Stock\Item $subject, $result)
    {
        try {
            $productId = $subject->getProductId();
            $helper = $this->_bookingHelper;
            if ($helper->isBookingProduct($productId, true)) {
                return $helper->getTotalBookingQty($productId);
            }
        } catch (\Exception $e) {
            $this->_bookingHelper
                ->logDataInLogger("Plugin_Model_CatalogInventory_Stock_Item afterGetQty : ".$e->getMessage());
        }
        return $result;
    }
}
