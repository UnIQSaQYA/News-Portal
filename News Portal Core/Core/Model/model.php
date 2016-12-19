<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 8/30/2016
 * Time: 1:59 PM
 */
class model
{

    private $_db;

    protected $tableName;
    protected $columnName;
    protected $primaryKey;
    protected $limit;
    protected $offset;


    public function __construct()
    {
        $this->_db = Database::instantiate();
    }


    /**
     * @param array $data
     * @param null $id
     * @return bool|Last
     */
    public function save($data = array(), $id = NULL)
    {
        if (!isset($this->tableName) && empty($data)) return false;

        if (!isset($id)) {
            return $this->_db->insert($this->tableName, $data);
        }
        $id = (int)$id;
        return $this->_db->update($this->tableName, $data, $this->primaryKey . '=?', array($id));
    }


    /**
     * @param null $key
     * @return mixed
     */
    protected function get($key = NULL, $clause = "")
    {
        if (isset($key)) {
            return $this->_db->select($this->tableName, $this->columnName, $this->primaryKey . "=?", array($key));
        } elseif (isset($this->limit) && is_numeric($this->limit)) {
            $limit = (int)$this->limit;
            $offset = (int)$this->offset;
            return $this->_db->select($this->tableName, $this->columnName, "", [], "LIMIT " . $limit . " OFFSET " . $offset);
        }
        return $this->_db->select($this->tableName, $this->columnName);
    }

    /** This Function is to select the values from db are selected by other columns rather than id
     * @param string $criteria
     * @param array $bindValue
     * @param bool $unique
     * @return bool|mixed
     */
    protected function selectBy($criteria = "", $bindValue = [], $unique = false)
    {
        if (empty($criteria)) return false;
        $data = $this->_db->select($this->tableName, $this->columnName, $criteria, $bindValue);

        if ($unique === true) {
            if (count($data)) {
                return $data[0];
            }
        }


        return $data;

    }

    /** To handel the raw method of Database.php
     * @param string $query
     * @param array $bindValue
     * @return bool|mixed
     */
    protected function dbRaw($query = '', $bindValue = [])
    {
        if (empty($query)) return false;
        return $this->_db->raw($query, $bindValue);
    }


    /**Takes id from user.php and calls method delete of database.php to delete the user
     * @param null $id
     * @return bool
     */
    protected function delete($id = NULL)
    {
        if (!isset($id)) return false;
        if ((is_numeric($id))) {
            return $this->_db->delete($this->tableName, $this->primaryKey . "=?", array($id));
        }else{
            return $this->_db->delete($this->tableName,$this->primaryKey." IN ({$id})",[]);
        }
    }


    protected function rowCount($criteria = "")
    {
        if (empty($criteria)) {

        }
        return $this->_db->countRow($this->tableName, "", []);
    }
}


