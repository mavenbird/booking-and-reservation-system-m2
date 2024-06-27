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

use Mavenbird\BookingSystem\Api\Data\QuoteInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Quote extends \Magento\Framework\Model\AbstractModel implements QuoteInterface, IdentityInterface
{
    /**
     * No route page id.
     */
    public const NOROUTE_ENTITY_ID = 'no-route';

    /**
     * BookingSystem Quote cache tag.
     */
    public const CACHE_TAG = 'bookingsystem_quote';

    /**
     * @var string
     */
    protected $_cacheTag = 'bookingsystem_quote';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'bookingsystem_quote';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(\Mavenbird\BookingSystem\Model\ResourceModel\Quote::class);
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
            return $this->noRouteBookingSystem();
        }

        return parent::load($id, $field);
    }

    /**
     * Load No-Route Items.
     *
     * @return \Mavenbird\BookingSystem\Model\Quote
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
     * @return \Mavenbird\BookingSystem\Api\Data\QuoteInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * Set ItemId
     *
     * @param int $itemId
     * @return \Mavenbird\BookingSystem\Api\Data\QuoteInterface
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
     * Set SlotId
     *
     * @param int $slotId
     * @return \Mavenbird\BookingSystem\Api\Data\QuoteInterface
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
     * @return \Mavenbird\BookingSystem\Api\Data\QuoteInterface
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
     * Set QuoteId
     *
     * @param int $quoteId
     * @return \Mavenbird\BookingSystem\Api\Data\QuoteInterface
     */
    public function setQuoteId($quoteId)
    {
        return $this->setData(self::QUOTE_ID, $quoteId);
    }

    /**
     * Get QuoteId
     *
     * @return int
     */
    public function getQuoteId()
    {
        return parent::getData(self::QUOTE_ID);
    }
}
