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

use Magento\Catalog\Model\Product\Configuration\Item\ItemInterface;
use Magento\Catalog\Helper\Product\Configuration as ProductConfiguration;

class Configuration
{

    /**
     * Update translation of the customoption title
     *
     * @param ProductConfiguration $subject
     * @param \Closure $proceed
     * @param ItemInterface $item
     * @return array
     */
    public function aroundGetCustomOptions(
        ProductConfiguration $subject,
        \Closure $proceed,
        ItemInterface $item
    ) {
        $result = $proceed($item);
        if (is_array($result)) {
            $bookingLables = [
                "Booking From",
                "Booking Till"
            ];
            foreach ($result as $key => $item) {
                if (isset($item['label'])) {
                    if (in_array($item['label'], $bookingLables)) {
                        $result[$key]['label'] = __($item['label']);
                    }
                }
            }
        }
        return $result;
    }
}
