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

class AfterRefundOrder implements ObserverInterface
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
     * @var \Magento\Sales\Api\OrderItemRepositoryInterface
     */
    protected $itemRepository;

    /**
     * Function __construct
     *
     * @param \Mavenbird\BookingSystem\Helper\Data                                     $bookingHelper
     * @param \Mavenbird\BookingSystem\Model\ResourceModel\Booked\CollectionFactory    $bookedCollection
     * @param \Magento\Sales\Api\OrderItemRepositoryInterface                       $itemRepository
     */
    public function __construct(
        \Mavenbird\BookingSystem\Helper\Data $bookingHelper,
        \Mavenbird\BookingSystem\Model\ResourceModel\Booked\CollectionFactory $bookedCollection,
        \Magento\Sales\Api\OrderItemRepositoryInterface $itemRepository
    ) {
        $this->_bookingHelper = $bookingHelper;
        $this->bookedCollection = $bookedCollection;
        $this->itemRepository = $itemRepository;
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
            $creditmemo = $observer->getEvent()->getCreditmemo();
            foreach ($creditmemo->getItems() as $item) {
                if ($item->getBackToStock()) {
                    $this->updateBookedSlotsInfo($item, $creditmemo);
                }
            }
        } catch (\Exception $e) {
            $this->_bookingHelper->logDataInLogger("Observer_AfterRefundOrder execute : ".$e->getMessage());
        }
    }

    /**
     * Set Booking Slots Info
     *
     * @param collection $item
     * @param Magento\Sales\Model\Order\Creditmemo $creditmemo
     * @return void
     */
    private function updateBookedSlotsInfo($item, $creditmemo)
    {
        try {
            $helper = $this->_bookingHelper;
            $itemId = $item->getOrderItemId();
            $orderItem = $this->itemRepository->get($itemId);
            $orderId = $creditmemo->getOrderId();
            $customerId = (int) $creditmemo->getCustomerId();
            $quoteItemId = $orderItem->getQuoteItemId();
            $bookingData = $helper->getDetailsByQuoteItemId($quoteItemId);

            $productId = $item->getProductId();
            $returnQty = $item->getQty();

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
                        if ($returnQty==$data->getQty()) {
                            $data->delete();
                        } else {
                            $data->setQty($data->getQty()-$returnQty)->save();
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->_bookingHelper
                ->logDataInLogger("Observer_AfterRefundOrder updateBookedSlotsInfo : ".$e->getMessage());
        }
    }
}
