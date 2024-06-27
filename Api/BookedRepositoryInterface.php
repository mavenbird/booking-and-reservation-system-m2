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
namespace Mavenbird\BookingSystem\Api;

/**
 * BookedRepository Repository Interface
 */
interface BookedRepositoryInterface
{
    /**
     * Get by id
     *
     * @param int $id
     * @return \Mavenbird\BookingSystem\Model\Booked
     */
    public function getById($id);
    /**
     * Save
     *
     * @param \Mavenbird\BookingSystem\Model\Booked $subject
     * @return \Mavenbird\BookingSystem\Model\Booked
     */
    public function save(\Mavenbird\BookingSystem\Model\Booked $subject);
    /**
     * Get list
     *
     * @param Magento\Framework\Api\SearchCriteriaInterface $creteria
     * @return Magento\Framework\Api\SearchResults
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $creteria);
    /**
     * Delete
     *
     * @param \Mavenbird\BookingSystem\Model\Booked $subject
     * @return boolean
     */
    public function delete(\Mavenbird\BookingSystem\Model\Booked $subject);
    /**
     * Delete by id
     *
     * @param int $id
     * @return boolean
     */
    public function deleteById($id);
}
