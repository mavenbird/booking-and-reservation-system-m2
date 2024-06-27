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
namespace Mavenbird\BookingSystem\Plugin\Model\Indexer\Product\Price\Action;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Ddl\Table;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Row
{
    public const CATALOG_PRODUCT_TABLE = 'catalog_product_index_price';

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * Constructor Initialize
     *
     * @param ResourceConnection $resourceConnection
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        ProductRepositoryInterface $productRepository
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->productRepository = $productRepository;
    }
    /**
     * Before Execute
     *
     * @param \Magento\Catalog\Model\Indexer\Product\Price\Action\Row $subject
     * @param int $id
     * @return int
     */
    public function beforeExecute(
        \Magento\Catalog\Model\Indexer\Product\Price\Action\Row $subject,
        $id
    ) {
        $connection  = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName(self::CATALOG_PRODUCT_TABLE);
        $columnName = 'id';
        $productType = $this->productRepository->getById($id)->getTypeId();
        if ($productType == \Mavenbird\BookingSystem\Model\Product\Type\Booking::TYPE_CODE) {
            if ($connection->tableColumnExists($tableName, $columnName) === false) {
                $connection->addColumn($tableName, $columnName, [
                    'identity'  => false,
                    'type' => Table::TYPE_SMALLINT,
                    'nullable'  => false,
                    'comment'   => 'Product Id',
                    'unsigned'  => true,
                ]);
            }
        }
        return $id;
    }
}
