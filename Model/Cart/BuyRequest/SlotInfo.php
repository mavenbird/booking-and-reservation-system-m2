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
class SlotInfo implements BuyRequestDataProviderInterface
{
    /**
     * @var ArrayManager
     */
    private $arrayManager;

    /**
     * @param ArrayManager $arrayManager
     */
    public function __construct(
        ArrayManager $arrayManager
    ) {
        $this->arrayManager = $arrayManager;
    }

    /**
     * Slot Info
     *
     * @param array $cartItemData
     * @return array
     */
    public function execute(array $cartItemData): array
    {
        $slotId = $this->arrayManager->get('data/slot_id', $cartItemData);
        if (!isset($slotId)) {
            throw new GraphQlInputException(__('Missing key "slot_id" in cart item data'));
        }

        $slotId = (int) $slotId;

        if ($slotId <= 0) {
            throw new GraphQlInputException(
                __('Please enter a slot Id than 0 in this field.')
            );
        }

        return ['slot_id' => $slotId];
    }
}
