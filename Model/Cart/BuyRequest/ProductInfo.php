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
declare(strict_types=1);

namespace Mavenbird\BookingSystem\Model\Cart\BuyRequest;

use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\QuoteGraphQl\Model\Cart\BuyRequest\BuyRequestDataProviderInterface;

/**
 * Provides QTY buy request data for adding products to cart
 */
class ProductInfo implements BuyRequestDataProviderInterface
{
    /**
     * @var ArrayManager
     */
    private $arrayManager;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $productRepository;

    /**
     * @param ArrayManager $arrayManager
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     */
    public function __construct(
        ArrayManager $arrayManager,
        \Magento\Catalog\Model\ProductRepository $productRepository
    ) {
        $this->arrayManager = $arrayManager;
        $this->productRepository = $productRepository;
    }

    /**
     * Parent Info
     *
     * @param array $cartItemData
     * @return array
     */
    public function execute(array $cartItemData): array
    {
        $sku = $this->arrayManager->get('data/sku', $cartItemData);
        
        if (!isset($sku)) {
            throw new GraphQlInputException(__('Missing key "sku" in cart item data'));
        }

        $product = $this->productRepository->get($sku);

        $productId = (int) $product->getId();

        if ($productId <= 0) {
            throw new GraphQlInputException(
                __('Please enter a valid sku in this field.')
            );
        }

        return ['product' => $productId];
    }
}
