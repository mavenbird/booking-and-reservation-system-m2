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
namespace Mavenbird\BookingSystem\Observer;

use Magento\Framework\Event\ObserverInterface;

class AfterPlaceOrder implements ObserverInterface
{
    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    protected $_bookingHelper;

    /**
     * @var \Mavenbird\BookingSystem\Model\BookedFactory
     */
    protected $_booked;

    /**
     * Function __construct
     *
     * @param \Mavenbird\BookingSystem\Helper\Data         $bookingHelper
     * @param \Mavenbird\BookingSystem\Model\BookedFactory $booked
     */
    public function __construct(
        \Mavenbird\BookingSystem\Helper\Data $bookingHelper,
        \Mavenbird\BookingSystem\Model\BookedFactory $booked
    ) {
        $this->_bookingHelper = $bookingHelper;
        $this->_booked = $booked;
    }

    /**
     * Function execute
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            $orderIds = $observer->getEvent()->getData('order_ids');
            $orderId = $orderIds[0];
            $order = $this->_bookingHelper->getOrder($orderId);
            $orderedItems = $order->getAllItems();
            foreach ($orderedItems as $item) {
                if ($item->getProductType() == \Mavenbird\BookingSystem\Model\Product\Type\Booking::TYPE_CODE) {
                    $this->setBookedSlotsInfo($item, $order);
                }
            }
        } catch (\Exception $e) {
            $this->_bookingHelper->logDataInLogger("Observer_AfterPlaceOrder execute : ".$e->getMessage());
        }
    }

    /**
     * Set Booking Slots Info
     *
     * @param collection $item
     * @param Magento\Sales\Model\OrderFactory $order
     * @return void
     */
    private function setBookedSlotsInfo($item, $order)
    {
        try {
            $time = time();
            $helper = $this->_bookingHelper;
            $orderId = $order->getId();
            $customerId = (int) $order->getCustomerId();
            $customerEmail = $order->getCustomerEmail();
            $quoteItemId = $item->getQuoteItemId();
            $bookingData = $helper->getDetailsByQuoteItemId($quoteItemId);
            $itemId = $item->getId();
            $qty = $item->getQtyOrdered();
            $productId = $item->getProductId();
            if (!$bookingData['error']) {
                $slotId = $bookingData['slot_id'];
                $parentId = $bookingData['parent_slot_id'];
                $slotData = $helper->getSlotData($slotId, $parentId, $productId);
                $info = [
                    'order_id'          =>      $orderId,
                    'order_item_id'     =>      $itemId,
                    'item_id'           =>      $bookingData['item_id'],
                    'product_id'        =>      $productId,
                    'slot_id'           =>      $slotId,
                    'parent_slot_id'    =>      $parentId,
                    'customer_id'       =>      $customerId,
                    'customer_email'    =>      $customerEmail,
                    'qty'               =>      $qty,
                    'booking_from'      =>      $slotData['booking_from'],
                    'booking_to'        =>      $slotData['booking_to'],
                    'booking_too'        =>      $slotData['booking_to'],
                    'time'              =>      $time,
                ];
                $this->_booked->create()->setData($info)->save();
                $helper->checkBookingProduct($productId);
            }
        } catch (\Exception $e) {
            $this->_bookingHelper
                ->logDataInLogger("Observer_AfterPlaceOrder setBookedSlotsInfo : ".$e->getMessage());
        }
    }
}
