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
use Magento\Framework\App\RequestInterface;
use Mavenbird\BookingSystem\Model\ResourceModel\Quote\CollectionFactory as QuoteCollection;

class CartProductAddAfter implements ObserverInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    private $bookingHelper;

    /**
     * @var \Mavenbird\BookingSystem\Model\QuoteFactory
     */
    private $quote;

    /**
     * @var QuoteCollection
     */
    private $quoteCollection;

    /**
     * Function __construct
     *
     * @param RequestInterface                            $request
     * @param \Mavenbird\BookingSystem\Helper\Data           $bookingHelper
     * @param \Mavenbird\BookingSystem\Model\QuoteFactory    $quote
     * @param QuoteCollection                             $quoteCollection
     */
    public function __construct(
        RequestInterface $request,
        \Mavenbird\BookingSystem\Helper\Data $bookingHelper,
        \Mavenbird\BookingSystem\Model\QuoteFactory $quote,
        QuoteCollection $quoteCollection
    ) {
        $this->request = $request;
        $this->bookingHelper = $bookingHelper;
        $this->quote = $quote;
        $this->quoteCollection = $quoteCollection;
    }

    /**
     * Function execute
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @throws Exception|Magento\Framework\Exception\LocalizedException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $this->request->getParams();
        $helper = $this->bookingHelper;
        $item = $observer->getEvent()->getData('quote_item');
        $product = $observer->getEvent()->getData('product');
        $productId = $product->getId();
        $itemId = (int) $item->getId();
        if ($helper->isBookingProduct($productId)) {
            $parentId = $helper->getParentSlotId($productId);
            if (empty($data['slot_id'])) {
                $itemData = $item->getBuyRequest()->getData();
                $slotId = (int) $itemData['slot_id'];
            } else {
                $slotId = (int) $data['slot_id'];
            }
            $result = $this->processSlotData($data, $productId, $item);
            if ($result['error']) {
                throw new \Magento\Framework\Exception\LocalizedException($result['msg']);
            }
            $cartItemId = $observer->getEvent()->getQuoteItem()->getItemId();
            if ($cartItemId > 0) {
                $avlSlot = $helper->getAvailableSlotQty($productId, $cartItemId);
                $isBookingBeforePreventionDays = $helper->isBookingBeforePreventDays($productId, $avlSlot['date']);
                if ($isBookingBeforePreventionDays['status']) {
                    $helper->getCart()->removeItem($cartItemId)->save();
                    throw new \Magento\Framework\Exception\LocalizedException(
                        $isBookingBeforePreventionDays['msg']
                    );
                }
            }
            try {
                if ($itemId > 0) {
                    $collection = $this->quoteCollection->create();
                    $item = $helper->getDataByField($itemId, 'item_id', $collection);
                    if ($item) {
                        $id = $item->getId();
                        $data =  [
                            'item_id' => $itemId,
                            'slot_id' => $slotId,
                            'parent_slot_id' => $parentId,
                            'quote_id' => $item->getQuoteId()
                        ];
                        $this->quote->create()->addData($data)->setId($id)->save();
                    }
                }
            } catch (\Exception $e) {
                $this->bookingHelper->logDataInLogger(
                    "Observer_CartProductAddAfter_execute Exception : ".$e->getMessage()
                );
            }
        }
    }

    /**
     * Process Slot Data
     *
     * @param array         $data
     * @param int           $productId
     * @param collection    $item
     *
     * @return array
     */
    private function processSlotData($data, $productId, $item)
    {
        $result = ['error' => false];
        try {
            $helper = $this->bookingHelper;
            $parentId = $helper->getParentSlotId($productId);
            if ($parentId != $data['parent_id']) {
                $msg = __('There was some error while processing your request');
                $result = ['error' => true, 'msg' => $msg];
            }

            $slotId = (int) $data['slot_id'];
            if ($slotId == 0) {
                $msg = __('There was some error while processing your request');
                $result = ['error' => true, 'msg' => $msg];
            }

            $slotData = $helper->getSlotData($slotId, $parentId, $productId);
            $availableQty = $slotData['qty'];
            $requestedQty = $item->getQty();
            if ($requestedQty > $availableQty) {
                $msg = __('Slot quantity not available');
                $result = ['error' => true, 'msg' => $msg];
            }
        } catch (\Exception $e) {
            $this->bookingHelper->logDataInLogger(
                "Observer_CartProductAddAfter_processSlotData Exception : ".$e->getMessage()
            );
        }
        return $result;
    }
}
