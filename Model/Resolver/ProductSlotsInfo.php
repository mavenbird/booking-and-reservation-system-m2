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

namespace Mavenbird\BookingSystem\Model\Resolver;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * Get Slot info resolver
 */
class ProductSlotsInfo implements ResolverInterface
{
    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    protected $helper;
    
    /**
     * Construct function
     *
     * @param \Mavenbird\BookingSystem\Helper\Data $helper
     */
    public function __construct(
        \Mavenbird\BookingSystem\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }
    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!isset($value['model'])) {
            throw new LocalizedException(__('"model" value should be specified'));
        }

        /** @var Product $product */
        $product = $value['model'];
        $productId = $product->getId();
        $slots = $this->helper->getFormattedSlots($productId);
        
        $bookingInfo = $this->helper->getBookingInfo($productId);
        $bookingType = $bookingInfo['type'];
        $preventBookingBefore = $bookingInfo['prevent_booking_before']??'';
        $parentId = $this->helper->getParentSlotId($productId);
        $options = $this->helper->getProductOptions($productId);
        $data =  [
            "slots" => $slots,
            "parentId" => $parentId,
            "productId" => $productId,
            "options" => $options,
            "booking_type" => $bookingType,
            "prevent_booking_before" => $preventBookingBefore
        ];
        
        return $data;
    }
}
