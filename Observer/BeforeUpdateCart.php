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

class BeforeUpdateCart implements ObserverInterface
{
    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    protected $_bookingHelper;

    /**
     * Function __construct
     *
     * @param \Mavenbird\BookingSystem\Helper\Data $helper
     */
    public function __construct(\Mavenbird\BookingSystem\Helper\Data $helper)
    {
        $this->_bookingHelper = $helper;
    }

    /**
     * Function execute
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $info = $observer->getEvent()->getInfo()->getData();
        $cart = $observer->getEvent()->getCart();
        $quote = $cart->getQuote();
        if ($info) {
            foreach ($quote->getAllVisibleItems() as $item) {
                if (array_key_exists($item->getId(), $info)) {
                    $itemId = (int) $item->getId();
                    $productId = $item->getProductId();
                    if ($this->_bookingHelper->isBookingProduct($productId)) {
                        try {
                            $requestedQty = (int) $info[$itemId]['qty'];
                            $parentId = $this->_bookingHelper->getParentSlotId($productId);
                            $itemData = $item->getBuyRequest()->getData();
                            $slotId = (int) $itemData['slot_id'];
                        } catch (\Exception $e) {
                            $this->_bookingHelper
                                ->logDataInLogger("Observer_BeforeViewCart execute : ".$e->getMessage());
                        }
                        if (!$this->processSlotData($slotId, $parentId, $productId, $requestedQty)) {
                            throw new \Magento\Framework\Exception\LocalizedException(
                                __('Slot quantity not available')
                            );
                        }
                        $data = $this->_bookingHelper->getAvailableSlotQty($productId, $itemId);
                        if ($this->_bookingHelper->isBookingBeforePreventDays($productId, $data['date'])['status']) {
                            $this->_bookingHelper->getCart()->removeItem($itemId)->save();
                            throw new \Magento\Framework\Exception\LocalizedException(
                                $this->_bookingHelper->isBookingBeforePreventDays($productId, $data['date'])['msg']
                            );
                        }
                    }
                }
            }
        }
    }

    /**
     * Process Slot Data
     *
     * @param int $slotId
     * @param int $parentId
     * @param int $productId
     * @param int $requestedQty
     * @return bolean
     */
    private function processSlotData($slotId, $parentId, $productId, $requestedQty)
    {
        $slotData = $this->_bookingHelper->getSlotData($slotId, $parentId, $productId);
        $availableQty = isset($slotData['qty'])?$slotData['qty']:0;
        if ($requestedQty > $availableQty) {
            return false;
        } else {
            return true;
        }
    }
}
