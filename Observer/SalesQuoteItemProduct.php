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
use Mavenbird\BookingSystem\Model\ResourceModel\Quote\CollectionFactory as QuoteCollection;

class SalesQuoteItemProduct implements ObserverInterface
{
     /**
      * @var \Magento\Framework\Message\ManagerInterface
      */
    protected $_messageManager;

     /**
      * @var \Mavenbird\BookingSystem\Helper\Data
      */
    protected $helper;

     /**
      * @var \Mavenbird\BookingSystem\Model\QuoteFactory
      */
    protected $_quote;

     /**
      * @var QuoteCollection
      */
    protected $_quoteCollection;

    /**
     * Function __construct
     *
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Mavenbird\BookingSystem\Helper\Data $helper
     * @param \Mavenbird\BookingSystem\Model\QuoteFactory $quote
     * @param QuoteCollection $quoteCollection
     */
    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Mavenbird\BookingSystem\Helper\Data $helper,
        \Mavenbird\BookingSystem\Model\QuoteFactory $quote,
        QuoteCollection $quoteCollection
    ) {
        $this->_messageManager = $messageManager;
        $this->helper = $helper;
        $this->_quote = $quote;
        $this->_quoteCollection = $quoteCollection;
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
            $item = $observer->getEvent()->getQuoteItem();
            $data = $item->getBuyRequest()->getData();
            $productId = $item->getProduct()->getId();
            $itemId = (int) $item->getId();
            
            if ($this->helper->isBookingProduct($productId) && isset($data['slot_id'])) {
                $parentId = $this->helper->getParentSlotId($productId);
                $slotId = (int) $data['slot_id'];
                $result = $this->processSlotData($data, $productId);
                if ($result['error']) {
                    $this->_messageManager->addNotice(__($result['msg']));
                } else {
                    if ($itemId > 0) {
                        $collection = $this->_quoteCollection->create();
                        $tempitem = $this->helper->getDataByField($itemId, 'item_id', $collection);

                        if (!$tempitem) {
                            $data =  [
                                'item_id' => $itemId,
                                'slot_id' => $slotId,
                                'parent_slot_id' => $parentId,
                                'quote_id' => $item->getQuoteId()
                            ];
                            $this->_quote->create()->setData($data)->save();
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->helper->logDataInLogger("Observer_SalesQuoteItemProduct execute : ".$e->getMessage());
        }
    }

    /**
     * Process Slot Data
     *
     * @param array  $data
     * @param int    $productId
     *
     * @return array
     */
    private function processSlotData($data, $productId)
    {
        $result = ['error' => false];
        try {
            $parentId = $this->helper->getParentSlotId($productId);
            if ($parentId != $data['parent_id']) {
                $msg = __('There was some error while processing your request');
                $result = ['error' => true, 'msg' => $msg];
            }

            $slotId = (int) $data['slot_id'];
            if ($slotId == 0) {
                $msg = __('There was some error while processing your request');
                $result = ['error' => true, 'msg' => $msg];
            }
        } catch (\Exception $e) {
            $this->helper->logDataInLogger("Observer_SalesQuoteItemProduct processSlotData : ".$e->getMessage());
        }
        return $result;
    }
}
