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

class BeforeViewProduct implements ObserverInterface
{
    /**
     * @var RequestInterface
     */
    protected $_request;

    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    protected $_bookingHelper;

    /**
     * Function __construct
     *
     * @param RequestInterface                  $request
     * @param \Mavenbird\BookingSystem\Helper\Data $bookingHelper
     */
    public function __construct(
        RequestInterface $request,
        \Mavenbird\BookingSystem\Helper\Data $bookingHelper
    ) {
        $this->_request = $request;
        $this->_bookingHelper = $bookingHelper;
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
            $data = $this->_request->getParams();
            $productId = $data['id'];
            $this->_bookingHelper->enableOptions($productId);
            $this->_bookingHelper->checkBookingProduct($productId);
        } catch (\Exception $e) {
            $this->_bookingHelper->logDataInLogger("Observer_BeforeViewProduct execute : ".$e->getMessage());
        }
    }
}
