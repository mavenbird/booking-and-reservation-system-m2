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
namespace Mavenbird\BookingSystem\Plugin\Block\Order;

use Magento\Sales\Block\Order\Item\Renderer\DefaultRenderer as ItemRenderer;

class Create
{

    /**
     * Update translation of the customoption title
     *
     * @param ItemRenderer $subject
     * @param \Closure $proceed
     * @return array
     */
    public function afterExecute(
        ItemRenderer $subject,
        \Closure $proceed
    ) {
        $result = $proceed();
        if (isset($result)) {
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
