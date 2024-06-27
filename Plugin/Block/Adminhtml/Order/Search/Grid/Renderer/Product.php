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
namespace Mavenbird\BookingSystem\Plugin\Block\Adminhtml\Order\Search\Grid\Renderer;

use Magento\Sales\Block\Adminhtml\Order\Create\Search\Grid\Renderer\Product as CoreProductSearchRenderer;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Mavenbird\BookingSystem\Model\Product\Type\Booking;

class Product extends CoreProductSearchRenderer
{
    /**
     * @var SecureHtmlRenderer
     */
    protected $secureRenderer;
  
    /**
     * Constructor
     *
     * @param SecureHtmlRenderer $secureRenderer
     */
    public function __construct(
        SecureHtmlRenderer $secureRenderer
    ) {
        $this->secureRenderer = $secureRenderer;
    }
    /**
     * After Render
     *
     * @param CoreProductSearchRenderer $subject
     * @param array $row
     * @param \Magento\Framework\DataObject $result
     * @return string
     */
    public function afterRender(CoreProductSearchRenderer $subject, $row, \Magento\Framework\DataObject $result)
    {
        $rendered = $result->getName();
        $isConfigurable = $result->canConfigure();
        $style = $isConfigurable ? '' : 'disabled';
        $isBookingProduct = $result->getTypeId() == Booking::TYPE_CODE?true:false;
        if ($isBookingProduct) {
            $prodAttributes = $isConfigurable ? sprintf(
                'list_type = "product_to_add" product_id = %s',
                $result->getId()
            ) : 'disabled="disabled"';
            return sprintf(
                '<a href="#" id="search-grid-product-' . $result
                ->getId() . '" class="wk-book-now action-configure %s" %s>%s</a>',
                $style,
                $prodAttributes,
                __('Configure')
            )
            . $this->secureRenderer->renderEventListenerAsTag(
                'onclick',
                'event.preventDefault()',
                'a#search-grid-product-' . $result->getId()
            ) . $rendered;
            ;
        }
        $prodAttributes = $isConfigurable ? sprintf(
            'list_type = "product_to_add" product_id = %s',
            $result->getId()
        ) : 'disabled="disabled"';
        return sprintf(
            '<a href="#" id="search-grid-product-' . $result->getId() . '" class="action-configure %s" %s>%s</a>',
            $style,
            $prodAttributes,
            __('Configure')
        ) . $this->secureRenderer->renderEventListenerAsTag(
            'onclick',
            'event.preventDefault()',
            'a#search-grid-product-' . $result->getId()
        ) . $rendered;
        ;
    }
}
