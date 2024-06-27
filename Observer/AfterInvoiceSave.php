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

class AfterInvoiceSave implements ObserverInterface
{
    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    private $helper;

    /**
     * Function __construct
     *
     * @param \Mavenbird\BookingSystem\Helper\Data $helper
     */
    public function __construct(
        \Mavenbird\BookingSystem\Helper\Data $helper
    ) {
        $this->helper = $helper;
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
            $order = $observer->getInvoice()->getOrder();
            foreach ($order->getItems() as $item) {
                $this->helper->checkBookingProduct($item->getProductId());
            }
        } catch (\Exception $e) {
            $this->helper->logDataInLogger(
                "Observer_AfterInvoiceSave execute : ".$e->getMessage()
            );
        }
    }
}
