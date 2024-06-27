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

namespace Mavenbird\BookingSystem\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mavenbird\BookingSystem\Model\ResourceModel\Quote\CollectionFactory as QuoteCollection;
use Magento\QuoteGraphQl\Model\Cart\GetCartForUser;
use Magento\QuoteGraphQl\Model\Cart\AddProductsToCart;
use Magento\Quote\Model\QuoteMutexInterface;

/**
 * Add booking product resolver
 */
class AddBookingProduct implements ResolverInterface
{
    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    protected $helper;
    
    /**
     * @var QuoteCollection
     */
    protected $_quoteCollection;
    /**
     * @var \Mavenbird\BookingSystem\Model\QuoteFactory
     */
    protected $bookingQuote;
    /**
     * @var GetCartForUser
     */
    protected $getCartForUser;
    /**
     * @var AddProductsToCart
     */
    protected $addProductsToCart;
    /**
     * @var AddProductsToCart
     */
    protected $quoteMutex;
    
    /**
     * Construct function
     *
     * @param \Mavenbird\BookingSystem\Helper\Data $helper
     * @param QuoteCollection $quoteCollection
     * @param \Mavenbird\BookingSystem\Model\QuoteFactory $bookingQuote
     * @param GetCartForUser $getCartForUser
     * @param AddProductsToCart $addProductsToCart
     * @param AddProductsToCart $quoteMutex
     */
    public function __construct(
        \Mavenbird\BookingSystem\Helper\Data $helper,
        QuoteCollection $quoteCollection,
        \Mavenbird\BookingSystem\Model\QuoteFactory $bookingQuote,
        GetCartForUser $getCartForUser,
        AddProductsToCart $addProductsToCart,
        QuoteMutexInterface $quoteMutex
    ) {
        $this->helper = $helper;
        $this->_quoteCollection = $quoteCollection;
        $this->bookingQuote = $bookingQuote;
        $this->getCartForUser = $getCartForUser;
        $this->addProductsToCart = $addProductsToCart;
        $this->quoteMutex = $quoteMutex;
    }
   
    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args['input']['parent_id'])) {
            throw new GraphQlInputException(__('Required parameter "parent_id" is missing'));
        }
        if (empty($args['input']['cart_items'])
            || !is_array($args['input']['cart_items'])
        ) {
            throw new GraphQlInputException(__('Required parameter "cart_items" is missing'));
        }
        
        if (empty($args['input']['cart_id'])) {
            throw new GraphQlInputException(__('Required parameter "cart_id" is missing'));
        }
        
        return $this->quoteMutex->execute(
            [$args['input']['cart_id']],
            \Closure::fromCallable([$this, 'run']),
            [$context, $args]
        );
    }

    /**
     * Run the resolver.
     *
     * @param ContextInterface $context
     * @param array|null $args
     * @return array
     * @throws GraphQlInputException
     */
    private function run($context, ?array $args): array
    {
        $maskedCartId = $args['input']['cart_id'];
        $cartItems = $args['input']['cart_items'];
        $storeId = (int)$context->getExtensionAttributes()->getStore()->getId();
        
        $cart = $this->getCartForUser->execute($maskedCartId, $context->getUserId(), $storeId);
        
        $this->addProductsToCart->execute($cart, $cartItems);
        
        $this->afterAddToCart($cart);
        return [
            'cart' => [
                'model' => $cart,
            ],
        ];
    }
    
    /**
     * Process Slot Data
     *
     * @param int $slotId
     * @param int $productId
     * @param int $parentId
     * @return array
     */
    private function processSlotData($slotId, $productId, $parentId)
    {
        $result = ['error' => false];
        try {
            $helper = $this->helper;
            $parentId = $helper->getParentSlotId($productId);
            if ($parentId != $parentId) {
                $msg = __('There was some error while processing your request');
                $result = ['error' => true, 'msg' => $msg];
            }

            $slotId = (int) $slotId;
            if ($slotId == 0) {
                $msg = __('There was some error while processing your request');
                $result = ['error' => true, 'msg' => $msg];
            }
        } catch (\Exception $e) {
            $this->helper
                ->logDataInLogger("Observer_CartProductAddComplete processSlotData : ".$e->getMessage());
        }
        return $result;
    }

    /**
     * After Add to Cart
     *
     * @param Magento\Quote\Api\CartRepositoryInterface $cart
     * @return void
     * @throws GraphQlInputException
     */
    public function afterAddToCart($cart)
    {
        foreach ($cart->getAllItems() as $item) {
            $data = $item->getBuyRequest()->getData();
            $productId = $item->getProduct()->getId();
            $itemId = (int) $item->getId();
            if ($this->helper->isBookingProduct($productId) && isset($data['slot_id'])) {
                $parentId = $this->helper->getParentSlotId($productId);
                $slotId = (int) $data['slot_id'];
                $result = $this->processSlotData($slotId, $productId, $parentId);
                if ($result['error']) {
                    throw new GraphQlInputException(__($result['msg']));
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
                            $this->bookingQuote->create()->setData($data)->save();
                        }
                    }
                }
            }
        }
    }
}
