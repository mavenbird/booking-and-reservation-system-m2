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

/**
 * Get Slot resolver
 */
class Slots implements ResolverInterface
{
    /**
     * @var \Mavenbird\BookingSystem\Helper\Data
     */
    protected $helper;

    /**
     * Construct function
     *
     * @param \Mavenbird\BookingSystem\Helper\Data $helper
     */
    public function __construct(
        \Mavenbird\BookingSystem\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }
    /**
     * @inheritdoc
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $this->validateInput($args);
        $pid = $args['pid'];
        $date = $args['date'];
        return $this->helper->getSlotByProductId($pid, $date);
    }

    /**
     * Validate input arguments
     *
     * @param array $args
     * @throws GraphQlAuthorizationException
     * @throws GraphQlInputException
     */
    private function validateInput(array $args)
    {
        if (!isset($args['pid']) && !isset($args['date'])) {
            throw new GraphQlInputException(
                __("'productId' or 'date' input argument is required.")
            );
        }
    }
}
