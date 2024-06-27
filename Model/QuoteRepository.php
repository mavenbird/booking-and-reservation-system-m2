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

namespace Mavenbird\BookingSystem\Model;

/**
 * QuoteRepository Repo Class
 */
class QuoteRepository implements \Mavenbird\BookingSystem\Api\QuoteRepositoryInterface
{
    /**
     * @var \Mavenbird\BookingSystem\Model\QuoteFactory
     */
    protected $modelFactory = null;

    /**
     * @var \Mavenbird\BookingSystem\Model\ResourceModel\Quote\CollectionFactory
     */
    protected $collectionFactory = null;

    /**
     * Initialize
     *
     * @param \Mavenbird\BookingSystem\Model\QuoteFactory $modelFactory
     * @param \Mavenbird\BookingSystem\Model\ResourceModel\Quote\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Mavenbird\BookingSystem\Model\QuoteFactory $modelFactory,
        \Mavenbird\BookingSystem\Model\ResourceModel\Quote\CollectionFactory $collectionFactory
    ) {
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get by id
     *
     * @param int $id
     * @return \Mavenbird\BookingSystem\Model\Quote
     */
    public function getById($id)
    {
        $model = $this->modelFactory->create()->load($id);
        if (!$model->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('The data with the "%1" ID doesn\'t exist.', $id)
            );
        }
        return $model;
    }

    /**
     * Save
     *
     * @param \Mavenbird\BookingSystem\Model\Quote $subject
     * @return \Mavenbird\BookingSystem\Model\Quote
     */
    public function save(\Mavenbird\BookingSystem\Model\Quote $subject)
    {
        try {
            $subject->save();
        } catch (\Exception $exception) {
             throw new \Magento\Framework\Exception\CouldNotSaveException(__($exception->getMessage()));
        }
        return $subject;
    }

    /**
     * Get list
     *
     * @param Magento\Framework\Api\SearchCriteriaInterface $creteria
     * @return Magento\Framework\Api\SearchResults
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $creteria)
    {
        $collection = $this->collectionFactory->create();
        return $collection;
    }

    /**
     * Delete
     *
     * @param \Mavenbird\BookingSystem\Model\Quote $subject
     * @return boolean
     */
    public function delete(\Mavenbird\BookingSystem\Model\Quote $subject)
    {
        try {
            $subject->delete();
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete by id
     *
     * @param int $id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }
}
