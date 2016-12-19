<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 8/23/2016
 * Time: 8:22 PM
 */


/**
 * This class is used for CRUDE operation of Database
 */
class Database
{
    private $_connect = NULL;

    private static $_instance = NULL;

    public function __construct()
    {
        $this->connectDB();
    }

    /**
     * This function connects the Database and throws exception in case of failure
     */
    private function connectDB()
    {
        try {
            $this->_connect = new PDO('mysql:host=' . Config::getConfig('database/host') . '; dbname=' . Config::getConfig('database/dbname'), Config::getConfig('database/user'), Config::getConfig('database/password'));

            /**
             * This is used to ask PDO to give an error.
             * In this case Attribute is set to Error Mode and Error Mode is set to Exception Type
             */
            $this->_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $pex) {
            die($pex->getMessage());
        }
    }


    /** Instance function
     *This function saves the "Database connection time"  if it's already connected "
     * */
    public static function instantiate()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Database();
        }

        return self::$_instance;

    }

    /** Inserts the data according to input
     * @param $tableName
     * @param array $data
     * @return Last Inserted Value
     */
    public function insert($tableName, $data = array())
    {
        $sql = 'INSERT INTO ' . $tableName . ' (';
        $sql .= implode(',', array_keys($data)) . ') VALUES (?';

        for ($i = 1; $i < count($data); $i++) {
            $sql .= ',?';
        }
        $sql .= ')';
        $stmt = $this->_connect->prepare($sql);

        try {
            $stmt->execute(array_values($data));
            return $this->_connect->lastInsertId();
        } catch (PDOException $e) {
            die($e->getMessage());
        }


    }


    /** This function is used to access the table from db
     * @param string $tableName
     * @param string $columnName
     * @param $criteria
     * @param array $bindValue
     * @param string $clause
     * @return mixed
     */
    public function select($tableName = "", $columnName = "*", $criteria = "", $bindValue = array(), $clause = "")
    {
        $sql = "SELECT " . $columnName . " FROM " . $tableName;
        if (!empty($criteria)) {
            $sql .= " WHERE " . $criteria;
        }
        if (!empty($clause)) {
            $sql .= " " . $clause;
        }

        $stmt = $this->_connect->prepare($sql);


        try {

            $stmt->execute($bindValue);
            return $stmt->fetchall(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    /** For directly accessing the database through hardcode sql
     * @param string $query
     * @param array $bindValue
     * @return mixed
     */
    public function raw($query = '', $bindValue = array())
    {

        $stmt = $this->_connect->prepare($query);

        try {
            $stmt->execute($bindValue);
            return $stmt->fetchall(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    /** Updates the table with criteria
     * @param $tableName
     * @param array $data
     * @param $criteria
     * @param array $bindValue
     * @return bool
     */
    public function update($tableName, $data = array(), $criteria, $bindValue = array())
    {
        $sql = 'UPDATE ' . $tableName . ' SET ';
        $sql .= implode('=?,', array_keys($data));
        $sql .= '=? WHERE ' . $criteria;
        $exe = array_merge(array_values($data), $bindValue);

        $stmt = $this->_connect->prepare($sql);
        try {
            $stmt->execute($exe);
            return true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    /** Deletes the column as per condition
     * @param $tableName
     * @param $criteria
     * @param array $bindValue
     * @return bool
     */
    public function delete($tableName, $criteria, $bindValue = array())
    {
        $sql = 'DELETE FROM ' . $tableName . ' WHERE ' . $criteria;
        $stmt = $this->_connect->prepare($sql);

        try {
            $stmt->execute($bindValue);
            return true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    /** Function to count number of column
     * @param $tableName
     * @param $criteria
     * @param array $bindValue
     * @return mixed (The number of columns in the table
     */
    public function countRow($tableName, $criteria, $bindValue = array())
    {
        $sql = 'SELECT count(*) FROM ' . $tableName;
        if (!empty($criteria)) {
            $sql .= ' WHERE ' . $criteria;
        }

        $stmt = $this->_connect->prepare($sql);

        try {
            $stmt->execute($bindValue);
            $count = $stmt->fetchall(PDO::FETCH_COLUMN);
            return $count[0];
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

}

$db = Database::instantiate();
