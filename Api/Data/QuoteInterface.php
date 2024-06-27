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

interface QuoteInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    public const ENTITY_ID = 'id';
    
    public const ITEM_ID = 'item_id';

    public const SLOT_ID = 'slot_id';

    public const PARENT_SLOT_ID = 'parent_slot_id';

    public const QUOTE_ID = 'quote_id';

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
     * @return \Mavenbird\BookingSystem\Api\Data\QuoteInterface
     */
    public function setId($id);
    /**
     * Set ItemId
     *
     * @param int $itemId
     * @return \Mavenbird\BookingSystem\Api\Data\QuoteInterface
     */
    public function setItemId($itemId);
    /**
     * Get ItemId
     *
     * @return int
     */
    public function getItemId();
    /**
     * Set SlotId
     *
     * @param int $slotId
     * @return \Mavenbird\BookingSystem\Api\Data\QuoteInterface
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
     * @return \Mavenbird\BookingSystem\Api\Data\QuoteInterface
     */
    public function setParentSlotId($parentSlotId);
    /**
     * Get ParentSlotId
     *
     * @return int
     */
    public function getParentSlotId();
    /**
     * Set QuoteId
     *
     * @param int $quoteId
     * @return \Mavenbird\BookingSystem\Api\Data\QuoteInterface
     */
    public function setQuoteId($quoteId);
    /**
     * Get QuoteId
     *
     * @return int
     */
    public function getQuoteId();
}
