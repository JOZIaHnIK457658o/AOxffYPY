<?php
// 代码生成时间: 2025-09-30 02:35:24
// Use Zend Framework components
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;

class LearningEffectAssessment extends AbstractTableGateway
{
    /**
     * Constructor
     *
     * @param Adapter $adapter Database adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->table = 'assessments';
        $this->resultSetPrototype = new ResultSet();
        $this->initialize();
    }

    /**
     * Add a new assessment
     *
     * @param array $data Assessment data
     * @return int The ID of the new assessment
     */
    public function addAssessment(array $data)
    {
        try {
            $this->insert($data);
            // Return the ID of the newly inserted assessment
            return $this->getLastInsertValue();
        } catch (Exception $e) {
            // Handle error
            error_log($e->getMessage());
            throw $e;
        }
    }

    /**
     * Fetch all assessments
     *
     * @return ResultSet
     */
    public function fetchAll()
    {
        try {
            return $this->select();
        } catch (Exception $e) {
            // Handle error
            error_log($e->getMessage());
            throw $e;
        }
    }

    /**
     * Fetch a single assessment
     *
     * @param int $id Assessment ID
     * @return array|\ArrayObject|null
     */
    public function fetchOne($id)
    {
        try {
            $resultSet = $this->select(['id = ?' => $id]);
            return $resultSet->current();
        } catch (Exception $e) {
            // Handle error
            error_log($e->getMessage());
            throw $e;
        }
    }

    /**
     * Update an assessment
     *
     * @param array $data Assessment data
     * @param int $id Assessment ID
     * @return int The number of affected rows
     */
    public function updateAssessment(array $data, $id)
    {
        try {
            return $this->update($data, ['id = ?' => $id]);
        } catch (Exception $e) {
            // Handle error
            error_log($e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete an assessment
     *
     * @param int $id Assessment ID
     * @return int The number of affected rows
     */
    public function deleteAssessment($id)
    {
        try {
            return $this->delete(['id = ?' => $id]);
        } catch (Exception $e) {
            // Handle error
            error_log($e->getMessage());
            throw $e;
        }
    }
}
