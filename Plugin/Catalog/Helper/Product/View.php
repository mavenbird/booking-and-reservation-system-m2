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

namespace Mavenbird\BookingSystem\Plugin\Catalog\Helper\Product;

use Magento\Catalog\Block\Product\View as ProductView;

class View
{
    /**
     * You can add layout reference as per you need to display like: product.info.price, product.info.review, etc.
     *
     * @param ProductView $subject
     * @param string $html
     * @return string
     */
    public function afterToHtml(ProductView $subject, $html)
    {
        if ($subject->getProduct()) {
            $subject->getProduct()->setSalable(1)->save();
        }
        return $html;
    }
}
