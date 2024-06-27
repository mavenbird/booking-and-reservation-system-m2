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

namespace Mavenbird\BookingSystem\Model;

use Magento\Framework\GraphQl\Query\Resolver\TypeResolverInterface;
use Mavenbird\BookingSystem\Model\Product\Type\Booking;

class BookingProductTypeResolver implements TypeResolverInterface
{
    public const BOOKING_PRODUCT = 'BookingProduct';
    
    /**
     * Rresolve Type
     *
     * @param array $data
     * @return string
     */
    public function resolveType(array $data) : string
    {
        if (isset($data['type_id']) && $data['type_id'] == Booking::TYPE_CODE) {
            return self::BOOKING_PRODUCT;
        }
        return '';
    }
}
