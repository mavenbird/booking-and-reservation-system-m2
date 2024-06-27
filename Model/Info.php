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
namespace Mavenbird\BookingSystem\Model;

use Mavenbird\BookingSystem\Api\Data\InfoInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Info extends \Magento\Framework\Model\AbstractModel implements InfoInterface, IdentityInterface
{
    /**
     * No route page id.
     */
    public const NOROUTE_ENTITY_ID = 'no-route';

    /**
     * BookingSystem Info cache tag.
     */
    public const CACHE_TAG = 'bookingsystem_info';

    /**
     * @var string
     */
    protected $_cacheTag = 'bookingsystem_info';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'bookingsystem_info';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(\Mavenbird\BookingSystem\Model\ResourceModel\Info::class);
    }

    /**
     * Load object data.
     *
     * @param int|null $id
     * @param string   $field
     *
     * @return $this
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRoutePreorder();
        }

        return parent::load($id, $field);
    }

    /**
     * Load No-Route Items.
     *
     * @return \Mavenbird\BookingSystem\Model\Info
     */
    public function noRouteItems()
    {
        return $this->load(self::NOROUTE_ENTITY_ID, $this->getIdFieldName());
    }

    /**
     * Get identities.
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

    /**
     * Get ID.
     *
     * @return int
     */
    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    /**
     * Set ID.
     *
     * @param int $id
     *
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * Set ProductId
     *
     * @param int $productId
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * Get ProductId
     *
     * @return int
     */
    public function getProductId()
    {
        return parent::getData(self::PRODUCT_ID);
    }

    /**
     * Set StartDate
     *
     * @param string $startDate
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setStartDate($startDate)
    {
        return $this->setData(self::START_DATE, $startDate);
    }

    /**
     * Get StartDate
     *
     * @return string
     */
    public function getStartDate()
    {
        return parent::getData(self::START_DATE);
    }

    /**
     * Set EndDate
     *
     * @param string $endDate
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setEndDate($endDate)
    {
        return $this->setData(self::END_DATE, $endDate);
    }

    /**
     * Get EndDate
     *
     * @return string
     */
    public function getEndDate()
    {
        return parent::getData(self::END_DATE);
    }

    /**
     * Set PreventBookingBefore
     *
     * @param string $preventBookingBefore
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setPreventBookingBefore($preventBookingBefore)
    {
        return $this->setData(self::PREVENT_BOOKING_BEFORE, $preventBookingBefore);
    }

    /**
     * Get PreventBookingBefore
     *
     * @return string
     */
    public function getPreventBookingBefore()
    {
        return parent::getData(self::PREVENT_BOOKING_BEFORE);
    }

    /**
     * Set SlotHasQuantity
     *
     * @param int $slotHasQuantity
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setSlotHasQuantity($slotHasQuantity)
    {
        return $this->setData(self::SLOT_HAS_QUANTITY, $slotHasQuantity);
    }

    /**
     * Get SlotHasQuantity
     *
     * @return int
     */
    public function getSlotHasQuantity()
    {
        return parent::getData(self::SLOT_HAS_QUANTITY);
    }

    /**
     * Set Info
     *
     * @param string $info
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setInfo($info)
    {
        return $this->setData(self::INFO, $info);
    }

    /**
     * Get Info
     *
     * @return string
     */
    public function getInfo()
    {
        return parent::getData(self::INFO);
    }

    /**
     * Set Qty
     *
     * @param int $qty
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setQty($qty)
    {
        return $this->setData(self::QTY, $qty);
    }

    /**
     * Get Qty
     *
     * @return int
     */
    public function getQty()
    {
        return parent::getData(self::QTY);
    }

    /**
     * Set Type
     *
     * @param int $type
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * Get Type
     *
     * @return int
     */
    public function getType()
    {
        return parent::getData(self::TYPE);
    }

    /**
     * Set TotalSlots
     *
     * @param int $totalSlots
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setTotalSlots($totalSlots)
    {
        return $this->setData(self::TOTAL_SLOTS, $totalSlots);
    }

    /**
     * Get TotalSlots
     *
     * @return int
     */
    public function getTotalSlots()
    {
        return parent::getData(self::TOTAL_SLOTS);
    }
}
