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
namespace Mavenbird\BookingSystem\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\LayoutFactory;

class BookingOptions extends AbstractModifier
{
    /**
     * @var LocatorInterface
     */
    protected $locator;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var LayoutFactory
     */
    private $layoutFactory;

    /**
     * Function __construct
     *
     * @param LocatorInterface  $locator
     * @param RequestInterface  $request
     * @param LayoutFactory     $layoutFactory
     */
    public function __construct(
        LocatorInterface $locator,
        RequestInterface $request,
        LayoutFactory $layoutFactory
    ) {
        $this->locator = $locator;
        $this->request = $request;
        $this->layoutFactory = $layoutFactory;
    }

    /**
     * Function modifyMeta
     *
     * @param array  $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        if ($this->getProductType() == "booking") {
            $meta["booking_tab"] = [
                "children" => [
                    "booking_tab_container" => [
                        "arguments" => [
                            "data" => [
                                "config" => [
                                    "formElement" => "container",
                                    "componentType" => "container",
                                    'component' => 'Magento_Ui/js/form/components/html',
                                    "label" => __("Booking Information"),
                                    "required" => 0,
                                    "sortOrder" => 1,
                                    "content" => $this->layoutFactory->create()->createBlock(
                                        \Mavenbird\BookingSystem\Block\Adminhtml\Catalog\Product\Edit\Tab\Booking::class
                                    )->toHtml(),
                                ]
                            ]
                        ]
                    ]
                ],
                "arguments" => [
                    "data" => [
                        "config" => [
                            "componentType" => "fieldset",
                            "label" => __("Booking Information"),
                            "collapsible" => true,
                            "sortOrder" => 1,
                            'opened' => true,
                            'canShow' => true
                        ]
                    ]
                ]
            ];
        }
        return $meta;
    }

    /**
     * Get modifyData
     *
     * @param array $data
     * @return array
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * Get product type
     *
     * @return null|string
     */
    private function getProductType()
    {
        return (string)$this->request->getParam('type', $this->locator->getProduct()->getTypeId());
    }
}
