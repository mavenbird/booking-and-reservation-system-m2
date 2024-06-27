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

class GetAllCalender extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJson;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlInterface;

    /**
     * Constructor
     *
     * @param Context $context
     * @param \Mavenbird\BookingSystem\Helper\Data $bookingHelper
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJson
     * @param \Magento\Framework\UrlInterface $urlInterface
     */
    public function __construct(
        Context $context,
        \Mavenbird\BookingSystem\Helper\Data $bookingHelper,
        \Magento\Framework\Controller\Result\JsonFactory $resultJson,
        \Magento\Framework\UrlInterface $urlInterface
    ) {
        $this->helper = $bookingHelper;
        $this->_resultJson = $resultJson;
        $this->_urlInterface = $urlInterface;
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
            $this->helper->getCurrentTimeZone();
            $options = $this->helper->getProductOptions($productId);
            $bookingInfo = $this->helper->getBookingInfo($productId);
            $bookingType = $bookingInfo['type'];
            $preventBookingBefore = $bookingInfo['prevent_booking_before']??'';
            $formKey = $this->helper->getFormKey();
            $formatedSlots = $this->helper->getFormattedSlots($productId);
            $parentId = $this->helper->getParentSlotId($productId);
            $data =  $this->helper->getSerializedString([
                "slots" => $formatedSlots,
                "parentId" => $parentId,
                "formKey" => $formKey,
                "productId" => $productId,
                "options" => $options,
                "slotsUrl" => $this->_urlInterface->getUrl('bookingsystem/bookings/slots'),
                "booking_type" => $bookingType,
                "prevent_booking_before" => $preventBookingBefore
            ]);
            $result = ["data"=>$data,"getCalender" => $this->helper->getAllCalendars($productId)];
            return $this->_resultJson->create()->setData($result);
        } catch (\Exception $e) {
            $result = ["error"=>1];
            return $this->_resultJson->create()->setData($result);
        }
    }
}
