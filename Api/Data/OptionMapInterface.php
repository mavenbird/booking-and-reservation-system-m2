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

interface OptionMapInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    public const ENTITY_ID = 'entity_id';
    
    public const PRODUCT_ID = 'product_id';

    public const FROM = 'from';

    public const TILL = 'till';

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
     * Set From
     *
     * @param int $from
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setFrom($from);
    /**
     * Get From
     *
     * @return int
     */
    public function getFrom();
    /**
     * Set Till
     *
     * @param int $till
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setTill($till);
    /**
     * Get Till
     *
     * @return int
     */
    public function getTill();
}
