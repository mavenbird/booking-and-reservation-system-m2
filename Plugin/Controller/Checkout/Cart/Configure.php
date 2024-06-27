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
namespace Mavenbird\BookingSystem\Plugin\Controller\Checkout\Cart;

use Magento\Framework\Controller\ResultFactory;

class Configure
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultFactory;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $_messageManager;

    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    protected $_bookingHelper;

    /**
     * Function __construct
     *
     * @param ResultFactory                               $resultFactory
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Mavenbird\BookingSystem\Helper\Data           $bookingHelper
     */
    public function __construct(
        ResultFactory $resultFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Mavenbird\BookingSystem\Helper\Data $bookingHelper
    ) {
        $this->_resultFactory = $resultFactory;
        $this->_messageManager = $messageManager;
        $this->_bookingHelper = $bookingHelper;
    }

    /**
     * Function afterExecute
     *
     * @param \Magento\Checkout\Controller\Cart\Configure $subject
     * @param \Closure $result
     * @return ResultFactory|\Closure $result
     */
    public function afterExecute(\Magento\Checkout\Controller\Cart\Configure $subject, $result)
    {
        try {
            if ($this->_bookingHelper->canConfigureCart()) {
                $this->_messageManager->addError(__("Can not configure booking."));
                return $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('checkout/cart');
            }
        } catch (\Exception $e) {
            $this->_bookingHelper
                ->logDataInLogger("Plugin_Controller_Checkout_Cart_Configure afterExecute : ".$e->getMessage());
        }
        return $result;
    }
}
