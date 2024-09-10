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
 * @package    Mavenbird_Whatsapp
 * @author     Mavenbird Team
 * @copyright  Copyright (c) 2018-2024 Mavenbird Technologies Private Limited ( http://mavenbird.com )
 * @license    http://mavenbird.com/Mavenbird-Module-License.txt
 */
namespace Mavenbird\BookingSystem\Model;

/**
 * BookedRepository Repo Class
 */
class BookedRepository implements \Mavenbird\BookingSystem\Api\BookedRepositoryInterface
{
    /**
     * @var \Mavenbird\BookingSystem\Model\BookedFactory
     */
    protected $modelFactory = null;

    /**
     * @var \Mavenbird\BookingSystem\Model\ResourceModel\Booked\CollectionFactory
     */
    protected $collectionFactory = null;

    /**
     * Initialize
     *
     * @param \Mavenbird\BookingSystem\Model\BookedFactory $modelFactory
     * @param \Mavenbird\BookingSystem\Model\ResourceModel\Booked\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Mavenbird\BookingSystem\Model\BookedFactory $modelFactory,
        \Mavenbird\BookingSystem\Model\ResourceModel\Booked\CollectionFactory $collectionFactory
    ) {
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get by id
     *
     * @param int $id
     * @return \Mavenbird\BookingSystem\Model\Booked
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
     * @param \Mavenbird\BookingSystem\Model\Booked $subject
     * @return \Mavenbird\BookingSystem\Model\Booked
     */
    public function save(\Mavenbird\BookingSystem\Model\Booked $subject)
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
     * @param \Mavenbird\BookingSystem\Model\Booked $subject
     * @return boolean
     */
    public function delete(\Mavenbird\BookingSystem\Model\Booked $subject)
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
