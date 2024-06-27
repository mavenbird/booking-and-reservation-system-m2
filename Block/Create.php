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

namespace Mavenbird\BookingSystem\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Create extends Template
{
    /**
     * @var \Magento\Framework\UrlInterface $urlInterface
     */
    protected $_urlInterface;

    /**
     * Constructor
     *
     * @param Context $context
     * @param \Magento\Framework\UrlInterface $urlInterface
     */
    public function __construct(
        Context $context,
        \Magento\Framework\UrlInterface $urlInterface
    ) {
        $this->_urlInterface = $urlInterface;
        parent::__construct($context);
    }

    /**
     * Get Custorm Url
     *
     * @return \Magento\Framework\UrlInterface
     */
    public function getUrlCustom()
    {
        return $this->_urlInterface->getUrl(
            'bookingsystem/bookings/getallcalender'
        );
    }
}
