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

use Mavenbird\BookingSystem\Api\Data\BookedInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Booked extends \Magento\Framework\Model\AbstractModel implements BookedInterface, IdentityInterface
{
    /**
     * No route page id.
     */
    public const NOROUTE_ENTITY_ID = 'no-route';

    /**
     * BookingSystem booked cache tag.
     */
    public const CACHE_TAG = 'bookingsystem_booked';

    /**
     * @var string
     */
    protected $_cacheTag = 'bookingsystem_booked';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'bookingsystem_booked';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(\Mavenbird\BookingSystem\Model\ResourceModel\Booked::class);
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
     * @return \Mavenbird\BookingSystem\Model\Booked
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
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }
    
    /**
     * Set OrderId
     *
     * @param int $orderId
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Get OrderId
     *
     * @return int
     */
    public function getOrderId()
    {
        return parent::getData(self::ORDER_ID);
    }

    /**
     * Set OrderItemId
     *
     * @param int $orderItemId
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setOrderItemId($orderItemId)
    {
        return $this->setData(self::ORDER_ITEM_ID, $orderItemId);
    }

    /**
     * Get OrderItemId
     *
     * @return int
     */
    public function getOrderItemId()
    {
        return parent::getData(self::ORDER_ITEM_ID);
    }

    /**
     * Set ItemId
     *
     * @param int $itemId
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setItemId($itemId)
    {
        return $this->setData(self::ITEM_ID, $itemId);
    }

    /**
     * Get ItemId
     *
     * @return int
     */
    public function getItemId()
    {
        return parent::getData(self::ITEM_ID);
    }

    /**
     * Set Qty
     *
     * @param int $qty
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
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
     * Set ProductId
     *
     * @param int $productId
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
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
     * Set SlotId
     *
     * @param int $slotId
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setSlotId($slotId)
    {
        return $this->setData(self::SLOT_ID, $slotId);
    }

    /**
     * Get SlotId
     *
     * @return int
     */
    public function getSlotId()
    {
        return parent::getData(self::SLOT_ID);
    }

    /**
     * Set ParentSlotId
     *
     * @param int $parentSlotId
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setParentSlotId($parentSlotId)
    {
        return $this->setData(self::PARENT_SLOT_ID, $parentSlotId);
    }

    /**
     * Get ParentSlotId
     *
     * @return int
     */
    public function getParentSlotId()
    {
        return parent::getData(self::PARENT_SLOT_ID);
    }

    /**
     * Set CustomerId
     *
     * @param int $customerId
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get CustomerId
     *
     * @return int
     */
    public function getCustomerId()
    {
        return parent::getData(self::CUSTOMER_ID);
    }

    /**
     * Set CustomerEmail
     *
     * @param string $customerEmail
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setCustomerEmail($customerEmail)
    {
        return $this->setData(self::CUSTOMER_EMAIL, $customerEmail);
    }

    /**
     * Get CustomerEmail
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return parent::getData(self::CUSTOMER_EMAIL);
    }

    /**
     * Set BookingFrom
     *
     * @param string $bookingFrom
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setBookingFrom($bookingFrom)
    {
        return $this->setData(self::BOOKING_FROM, $bookingFrom);
    }

    /**
     * Get BookingFrom
     *
     * @return string
     */
    public function getBookingFrom()
    {
        return parent::getData(self::BOOKING_FROM);
    }

    /**
     * Set BookingToo
     *
     * @param string $bookingToo
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setBookingToo($bookingToo)
    {
        return $this->setData(self::BOOKING_TOO, $bookingToo);
    }

    /**
     * Get BookingToo
     *
     * @return string
     */
    public function getBookingToo()
    {
        return parent::getData(self::BOOKING_TOO);
    }

    /**
     * Set Time
     *
     * @param string $time
     * @return \Mavenbird\BookingSystem\Api\Data\BookedInterface
     */
    public function setTime($time)
    {
        return $this->setData(self::TIME, $time);
    }

    /**
     * Get Time
     *
     * @return string
     */
    public function getTime()
    {
        return parent::getData(self::TIME);
    }
}
