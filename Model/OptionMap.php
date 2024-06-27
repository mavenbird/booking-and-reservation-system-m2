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

use Mavenbird\BookingSystem\Api\Data\OptionMapInterface;
use Magento\Framework\DataObject\IdentityInterface;

class OptionMap extends \Magento\Framework\Model\AbstractModel implements OptionMapInterface, IdentityInterface
{
    /**
     * No route page id.
     */
    public const NOROUTE_ENTITY_ID = 'no-route';

    /**
     * BookingSystem Info cache tag.
     */
    public const CACHE_TAG = 'bookingsystem_option_map';

    /**
     * @var string
     */
    protected $_cacheTag = 'bookingsystem_option_map';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'bookingsystem_option_map';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(\Mavenbird\BookingSystem\Model\ResourceModel\OptionMap::class);
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
     * Set From
     *
     * @param int $from
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setFrom($from)
    {
        return $this->setData(self::FROM, $from);
    }

    /**
     * Get From
     *
     * @return int
     */
    public function getFrom()
    {
        return parent::getData(self::FROM);
    }

    /**
     * Set Till
     *
     * @param int $till
     * @return \Mavenbird\BookingSystem\Api\Data\InfoInterface
     */
    public function setTill($till)
    {
        return $this->setData(self::TILL, $till);
    }

    /**
     * Get Till
     *
     * @return int
     */
    public function getTill()
    {
        return parent::getData(self::TILL);
    }
}
