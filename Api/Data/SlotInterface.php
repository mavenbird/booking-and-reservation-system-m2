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

interface SlotInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    public const ENTITY_ID = 'id';

    public const PRODUCT_ID = 'product_id';

    public const TYPE = 'type';

    public const INFO = 'info';

    public const STATUS = 'status';

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
     * @return \Mavenbird\BookingSystem\Api\Data\SlotInterface
     */
    public function setId($id);

    /**
     * Set ProductId
     *
     * @param int $productId
     * @return \Mavenbird\BookingSystem\Api\Data\SlotInterface
     */
    public function setProductId($productId);
    /**
     * Get ProductId
     *
     * @return int
     */
    public function getProductId();
    /**
     * Set Type
     *
     * @param int $type
     * @return \Mavenbird\BookingSystem\Api\Data\SlotInterface
     */
    public function setType($type);
    /**
     * Get Type
     *
     * @return int
     */
    public function getType();
    /**
     * Set Info
     *
     * @param string $info
     * @return \Mavenbird\BookingSystem\Api\Data\SlotInterface
     */
    public function setInfo($info);
    /**
     * Get Info
     *
     * @return string
     */
    public function getInfo();
    /**
     * Set Status
     *
     * @param int $status
     * @return \Mavenbird\BookingSystem\Api\Data\SlotInterface
     */
    public function setStatus($status);
    /**
     * Get Status
     *
     * @return int
     */
    public function getStatus();
}
