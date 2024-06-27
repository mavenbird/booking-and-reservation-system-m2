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

class AfterCancelOrder implements ObserverInterface
{
    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    protected $_bookingHelper;

    /**
     * @var \Mavenbird\BookingSystem\Model\Booked\CollectionFactory
     */
    protected $bookedCollection;

    /**
     * Function __construct
     *
     * @param \Mavenbird\BookingSystem\Helper\Data                                     $bookingHelper
     * @param \Mavenbird\BookingSystem\Model\ResourceModel\Booked\CollectionFactory    $bookedCollection
     */
    public function __construct(
        \Mavenbird\BookingSystem\Helper\Data $bookingHelper,
        \Mavenbird\BookingSystem\Model\ResourceModel\Booked\CollectionFactory $bookedCollection
    ) {
        $this->_bookingHelper = $bookingHelper;
        $this->bookedCollection = $bookedCollection;
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
            $order = $observer->getEvent()->getOrder();
            foreach ($order->getAllItems() as $item) {
                $this->updateBookedSlotsInfo($item, $order);
            }
        } catch (\Exception $e) {
            $this->_bookingHelper->logDataInLogger("Observer_AfterCancelOrder execute : ".$e->getMessage());
        }
    }

    /**
     * Set Booking Slots Info
     *
     * @param collection $item
     * @param Magento\Sales\Model\OrderFactory $order
     * @return void
     */
    private function updateBookedSlotsInfo($item, $order)
    {
        try {
            $helper = $this->_bookingHelper;
            $orderId = $order->getId();
            $customerId = (int) $order->getCustomerId();
            $quoteItemId = $item->getQuoteItemId();
            $bookingData = $helper->getDetailsByQuoteItemId($quoteItemId);
            $itemId = $item->getId();
            $productId = $item->getProductId();
            $cancelQty = $item->getQtyCanceled();
            if (!$bookingData['error']) {
                $slotId = $bookingData['slot_id'];
                $parentId = $bookingData['parent_slot_id'];
                $collection = $this->bookedCollection->create()
                    ->addFieldToFilter('order_id', $orderId)
                    ->addFieldToFilter('order_item_id', $itemId)
                    ->addFieldToFilter('item_id', $bookingData['item_id'])
                    ->addFieldToFilter('product_id', $productId)
                    ->addFieldToFilter('slot_id', $slotId)
                    ->addFieldToFilter('parent_slot_id', $parentId)
                    ->addFieldToFilter('customer_id', $customerId);
                if ($collection->getSize()) {
                    foreach ($collection as $data) {
                        if ($cancelQty==$data->getQty()) {
                            $data->delete();
                        } else {
                            $data->setQty($data->getQty()-$cancelQty)->save();
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->_bookingHelper
                ->logDataInLogger("Observer_AfterCancelOrder updateBookedSlotsInfo : ".$e->getMessage());
        }
    }
}
