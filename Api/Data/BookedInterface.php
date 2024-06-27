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
namespace Mavenbird\BookingSystem\Api\Data;

interface BookedInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    public const ENTITY_ID = 'id';
    
    public const ORDER_ID = 'order_id';

    public const ORDER_ITEM_ID = 'order_item_id';

    public const ITEM_ID = 'item_id';

    public const QTY = 'qty';

    public const PRODUCT_ID = 'product_id';

    public const SLOT_ID = 'slot_id';

    public const PARENT_SLOT_ID = 'parent_slot_id';

    public const CUSTOMER_ID = 'customer_id';

    public const CUSTOMER_EMAIL = 'customer_email';

    public const BOOKING_FROM = 'booking_from';

    public const BOOKING_TOO = 'booking_too';

    public const TIME = 'time';

    /**
     * Get ID.
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID.
     *
     * @param int $id
     *
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setId($id);
    /**
     * Set OrderId
     *
     * @param int $orderId
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setOrderId($orderId);
    /**
     * Get OrderId
     *
     * @return int
     */
    public function getOrderId();
    /**
     * Set OrderItemId
     *
     * @param int $orderItemId
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setOrderItemId($orderItemId);
    /**
     * Get OrderItemId
     *
     * @return int
     */
    public function getOrderItemId();
    /**
     * Set ItemId
     *
     * @param int $itemId
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setItemId($itemId);
    /**
     * Get ItemId
     *
     * @return int
     */
    public function getItemId();
    /**
     * Set Qty
     *
     * @param int $qty
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setQty($qty);
    /**
     * Get Qty
     *
     * @return int
     */
    public function getQty();
    /**
     * Set ProductId
     *
     * @param int $productId
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setProductId($productId);
    /**
     * Get ProductId
     *
     * @return int
     */
    public function getProductId();
    /**
     * Set SlotId
     *
     * @param int $slotId
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setSlotId($slotId);
    /**
     * Get SlotId
     *
     * @return int
     */
    public function getSlotId();
    /**
     * Set ParentSlotId
     *
     * @param int $parentSlotId
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setParentSlotId($parentSlotId);
    /**
     * Get ParentSlotId
     *
     * @return int
     */
    public function getParentSlotId();
    /**
     * Set CustomerId
     *
     * @param int $customerId
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setCustomerId($customerId);
    /**
     * Get CustomerId
     *
     * @return int
     */
    public function getCustomerId();
    /**
     * Set CustomerEmail
     *
     * @param string $customerEmail
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setCustomerEmail($customerEmail);
    /**
     * Get CustomerEmail
     *
     * @return string
     */
    public function getCustomerEmail();
    /**
     * Set BookingFrom
     *
     * @param string $bookingFrom
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setBookingFrom($bookingFrom);
    /**
     * Get BookingFrom
     *
     * @return string
     */
    public function getBookingFrom();
    /**
     * Set BookingToo
     *
     * @param string $bookingToo
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setBookingToo($bookingToo);
    /**
     * Get BookingToo
     *
     * @return string
     */
    public function getBookingToo();
    /**
     * Set Time
     *
     * @param string $time
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setTime($time);
    /**
     * Get Time
     *
     * @return string
     */
    public function getTime();
}
