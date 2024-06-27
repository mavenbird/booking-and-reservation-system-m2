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
 * OptionMapRepository Repo Class
 */
class OptionMapRepository implements \Mavenbird\BookingSystem\Api\OptionMapRepositoryInterface
{
    /**
     * @var \Mavenbird\BookingSystem\Model\OptionMapFactory
     */
    protected $modelFactory = null;

    /**
     * @var \Mavenbird\BookingSystem\Model\ResourceModel\OptionMap\CollectionFactory
     */
    protected $collectionFactory = null;

    /**
     * Initialize
     *
     * @param \Mavenbird\BookingSystem\Model\OptionMapFactory $modelFactory
     * @param \Mavenbird\BookingSystem\Model\ResourceModel\OptionMap\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Mavenbird\BookingSystem\Model\OptionMapFactory $modelFactory,
        \Mavenbird\BookingSystem\Model\ResourceModel\OptionMap\CollectionFactory $collectionFactory
    ) {
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get by id
     *
     * @param int $id
     * @return \Mavenbird\BookingSystem\Model\OptionMap
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
     * @param \Mavenbird\BookingSystem\Model\OptionMap $subject
     * @return \Mavenbird\BookingSystem\Model\OptionMap
     */
    public function save(\Mavenbird\BookingSystem\Model\OptionMap $subject)
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
     * @param \Mavenbird\BookingSystem\Model\OptionMap $subject
     * @return boolean
     */
    public function delete(\Mavenbird\BookingSystem\Model\OptionMap $subject)
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
