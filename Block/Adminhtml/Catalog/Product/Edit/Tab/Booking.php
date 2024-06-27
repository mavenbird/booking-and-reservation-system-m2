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
namespace Mavenbird\BookingSystem\Block\Adminhtml\Catalog\Product\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget;
use Magento\Framework\Registry;
use Mavenbird\BookingSystem\Helper\Data;

class Booking extends Widget
{
    /**
     * @var string
     */
    protected $_template = 'Mavenbird_BookingSystem::product/edit/booking.phtml';

    /**
     * @var string
     */
    protected $_blockId = 'bookingInfo';

    /**
     * @var Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var Mavenbird\BookingSystem\Helper\Data $helper
     */
    protected $helper;
    /**
     * @param Context   $context
     * @param Registry  $registry
     * @param Data      $helper
     * @param array     $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Data $helper,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve product
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        return $this->_coreRegistry->registry('current_product');
    }
    
    /**
     * Function getHelper
     *
     * @return Mavenbird\BookingSystem\Helper\Data
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * Function _prepareLayout
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->setData('opened', true);
        return parent::_prepareLayout();
    }
}
