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

interface InfoInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    public const ENTITY_ID = 'id';
   
    public const PRODUCT_ID = 'product_id';

    public const START_DATE = 'start_date';

    public const END_DATE = 'end_date';

    public const PREVENT_BOOKING_BEFORE = 'prevent_booking_before';

    public const SLOT_HAS_QUANTITY = 'slot_has_quantity';

    public const INFO = 'info';

    public const QTY = 'qty';

    public const TYPE = 'type';

    public const TOTAL_SLOTS = 'total_slots';

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
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setId($id);

    /**
     * Set ProductId
     *
     * @param int $productId
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setProductId($productId);
    /**
     * Get ProductId
     *
     * @return int
     */
    public function getProductId();
    /**
     * Set StartDate
     *
     * @param string $startDate
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setStartDate($startDate);
    /**
     * Get StartDate
     *
     * @return string
     */
    public function getStartDate();
    /**
     * Set EndDate
     *
     * @param string $endDate
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setEndDate($endDate);
    /**
     * Get EndDate
     *
     * @return string
     */
    public function getEndDate();
    /**
     * Set PreventBookingBefore
     *
     * @param string $preventBookingBefore
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setPreventBookingBefore($preventBookingBefore);
    /**
     * Get PreventBookingBefore
     *
     * @return string
     */
    public function getPreventBookingBefore();
    /**
     * Set SlotHasQuantity
     *
     * @param int $slotHasQuantity
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setSlotHasQuantity($slotHasQuantity);
    /**
     * Get SlotHasQuantity
     *
     * @return int
     */
    public function getSlotHasQuantity();
    /**
     * Set Info
     *
     * @param string $info
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setInfo($info);
    /**
     * Get Info
     *
     * @return string
     */
    public function getInfo();
    /**
     * Set Qty
     *
     * @param int $qty
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setQty($qty);
    /**
     * Get Qty
     *
     * @return int
     */
    public function getQty();
    /**
     * Set Type
     *
     * @param int $type
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setType($type);
    /**
     * Get Type
     *
     * @return int
     */
    public function getType();
    /**
     * Set TotalSlots
     *
     * @param int $totalSlots
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setTotalSlots($totalSlots);
    /**
     * Get TotalSlots
     *
     * @return int
     */
    public function getTotalSlots();
}
