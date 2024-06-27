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
namespace Mavenbird\BookingSystem\Controller\Adminhtml\Bookings;

use Magento\Framework\App\Action\Context;

class Slots extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    protected $_bookingHelper;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJson;
    
    /**
     * @param Context                                          $context
     * @param \Mavenbird\BookingSystem\Helper\Data                $bookingHelper
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJson
     */
    public function __construct(
        Context $context,
        \Mavenbird\BookingSystem\Helper\Data $bookingHelper,
        \Magento\Framework\Controller\Result\JsonFactory $resultJson
    ) {
        $this->_bookingHelper = $bookingHelper;
        $this->_resultJson = $resultJson;
        parent::__construct($context);
    }

    /**
     * Function execute
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        try {
            $data = $this->getRequest()->getParams();
            $productId = $data['product_id'];
            $date = $data['date'];
            $result = $this->_bookingHelper->getSlotByProductId($productId, $date);
            return $this->_resultJson->create()->setData($result);
        } catch (\Exception $e) {
            $this->_bookingHelper->logDataInLogger("Controller_Booking_Slots execute : ".$e->getMessage());
        }
    }
}
