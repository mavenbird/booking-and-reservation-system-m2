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
namespace Mavenbird\BookingSystem\Plugin\Model;

use Magento\InventorySales\Model\IsProductSalableForRequestedQtyCondition\IsSalableWithReservationsCondition as Avail;
use Magento\InventorySalesApi\Api\Data\ProductSalableResultInterfaceFactory;

class IsSalableWithReservationsCondition
{
    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    protected $_bookingHelper;

    /**
     * @var ProductSalableResultInterfaceFactory
     */
    private $productSalableResultFactory;

     /**
      * @var \Magento\Catalog\Api\ProductRepositoryInterface
      */
    private $productRepository;
    
    /**
     * @param \Mavenbird\BookingSystem\Helper\Data                     $bookingHelper
     * @param ProductSalableResultInterfaceFactory                  $productSalableResultFactory
     * @param \Magento\Catalog\Api\ProductRepositoryInterface       $productRepository
     */
    public function __construct(
        \Mavenbird\BookingSystem\Helper\Data $bookingHelper,
        ProductSalableResultInterfaceFactory $productSalableResultFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->_bookingHelper = $bookingHelper;
        $this->productSalableResultFactory = $productSalableResultFactory;
        $this->productRepository = $productRepository;
    }

    /**
     * Check Salable With Reservations Condition or not
     *
     * @param Avail $subject
     * @param array $result
     * @param string $sku
     * @param int $stockId
     * @param float|int $requestedQuantity
     * @return ProductSalableResultInterfaceFactory|array
     */
    public function afterExecute(
        Avail $subject,
        $result,
        $sku,
        $stockId,
        $requestedQuantity
    ) {
        try {
            if ($sku) {
                $product = $this->productRepository->get($sku);
                if (!empty($product) &&
                    $product->getTypeId() == "booking" &&
                    $this->_bookingHelper->isBookingProduct($product->getId(), true)
                ) {
                    $request = $this->_bookingHelper->getRequestObject();

                    if ($request->getRequestString() === '/rest/default/V1/carts/mine/payment-information'
                        || $request->getRequestString() === '/checkout/cart/'
                    ) {
                        $qty = $this->_bookingHelper->getTotalBookingQty($product->getId());
                        if ($requestedQuantity < $qty) {
                            return $this->productSalableResultFactory->create(['errors' => []]);
                        }
                    } elseif (($request->getModuleName() == 'checkout' && $request->getControllerName() == 'cart'
                            && $request->getActionName() == 'add')
                        || ($request->getModuleName() == 'checkout'
                            && $request->getControllerName() == 'index'
                            && $request->getActionName() == 'index'
                        )
                        || ($request->getModuleName() == 'customer'
                            && $request->getControllerName() == 'section'
                            && $request->getActionName() == 'load'
                        )
                    ) {
                        $qty = $this->_bookingHelper->getTotalBookingQty($product->getId());
                        if ($requestedQuantity < $qty) {
                            return $this->productSalableResultFactory->create(['errors' => []]);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->_bookingHelper
                ->logDataInLogger("Plugin_Model_InventorySalesApi afterExecute : ".$e->getMessage());
        }

        return $result;
    }
}
