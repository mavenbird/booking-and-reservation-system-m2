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
namespace Mavenbird\BookingSystem\Setup\Patch\Data;

use Magento\Catalog\Setup\CategorySetup;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class UpdateAttributes implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CategorySetupFactory
     */
    private $categorySetupFactory;

    /**
     * ChangePriceAttributeDefaultScope constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategorySetupFactory $categorySetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * Function apply
     *
     * @return void
     */
    public function apply()
    {
        /** @var CategorySetup $categorySetup */
        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);
        $this->setPriceAttribute($categorySetup);
    }

    /**
     * Function setPriceAttribute
     *
     * @param CategorySetup $categorySetup
     * @return void
     */
    private function setPriceAttribute($categorySetup)
    {
        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);

        try {
            $fieldList = ['price', 'tax_class_id'];
            foreach ($fieldList as $field) {
                $applyTo = explode(
                    ',',
                    $categorySetup->getAttribute($entityTypeId, $field, 'apply_to')
                );
                if (!in_array(\Mavenbird\BookingSystem\Model\Product\Type\Booking::TYPE_CODE, $applyTo)) {
                    $applyTo[] = \Mavenbird\BookingSystem\Model\Product\Type\Booking::TYPE_CODE;
                    $categorySetup->updateAttribute(
                        $entityTypeId,
                        $field,
                        'apply_to',
                        implode(',', $applyTo)
                    );
                }
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * Function getDependencies
     *
     * @return array
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Function getAliases
     *
     * @return array
     */
    public function getAliases()
    {
        return [];
    }
}
