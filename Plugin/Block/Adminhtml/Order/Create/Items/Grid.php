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
namespace Mavenbird\BookingSystem\Plugin\Block\Adminhtml\Order\Create\Items;

use Magento\Sales\Block\Adminhtml\Order\Create\Items\Grid as coreGrid;
use Magento\Quote\Model\Quote\Item;
use Mavenbird\BookingSystem\Model\Product\Type\Booking;

/**
 * Adminhtml sales order create items grid block
 * @api
 * @since 100.0.2
 */
class Grid
{
    /**
     * Return html button which calls configure window
     *
     * @param coreGrid $subject
     * @param \Closure $proceed
     * @param Item $item
     * @return String
     */
    public function aroundGetConfigureButtonHtml(
        coreGrid $subject,
        \Closure $proceed,
        Item $item
    ) {
        $product = $item->getProduct();
        $isBookingProduct = $product->getTypeId() == Booking::TYPE_CODE?true:false;
        $options = ['label' => $subject->escapeHtmlAttr(__('Configure'))];
        if ($product->canConfigure()) {
            $options['onclick'] = sprintf('order.showQuoteItemConfiguration(%s)', $item->getId());
            if ($isBookingProduct) {
                $options['class'] = $subject->escapeHtmlAttr('wk-book-now product_id-'.$product->getId());
            }
        } else {
            $options['class'] = ' disabled';
            $options['title'] = $subject->escapeHtmlAttr(__('This product does not have any configurable options'));
        }

        return $subject->getLayout()->createBlock(
            \Magento\Backend\Block\Widget\Button::class
        )->setData($options)->toHtml();
    }
}
