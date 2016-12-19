<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 8/30/2016
 * Time: 3:00 PM
 */
class validation
{
    private $_errors = array();

    private $_db;

    public function __construct()
    {
        $this->_db = Database::instantiate();
    }


    /**
     * @param $validation_Rules
     */
    public function validate($validation_Rules)
    {

        $set=false;
        foreach ($validation_Rules as $field => $rules) {


            foreach ($rules as $rule => $rule_value) {


                if (isset($_POST[$field])) {

                     
                    if ($rule === "required" && (Input::post($field) === "")||count(Input::post($field))===0) {
                        $this->setErrors($field, $rules['label'] . ' is empty');
                    } else if (Input::post($field) !== "") {

                        switch ($rule) {
                            case "min":
                                if (strlen(Input::post($field)) < $rule_value) {
                                    $this->setErrors($field, $rules['label'] . ' must be atleast ' . $rule_value . ' characters');
                                }
                                break;


                            case "max":
                                break;


                            case "exact":
                                break;

                            case 'mustSet':
                                if(!isset($_POST[$field])) {
                                    $this->setErrors($field, $rules['label'] . ' is empty');
                                }
                                break;


                            case "oldpassword":
                                $dbValues = explode('|', $rule_value);
                                if (count($dbValues) > 2) {
                                    $tableName = $dbValues[0];
                                    $columnName = $dbValues[1];
                                    $id = $dbValues[2];

                                    $password = $this->_db->select($tableName, $columnName, 'id=?', [$id])[0];
                                    if (!(hash::passwordVerify(Input::post('oldpassword'), $password->password))) {
                                        $this->setErrors($field, $rules['label'] . " doesn't match");
                                    }
                                }

                                break;

                            case "unique":
                                $dbArgs = (explode('|', $rule_value));

                                if (count($dbArgs) == 2) {
                                    $tbleName = $dbArgs[0];
                                    $colName = $dbArgs[1];
                                    $data = $this->_db->select($tbleName, 'id', $colName . '=?', array(Input::post($field)));

                                } elseif (count($dbArgs) == 4) {
                                    $tbleName = $dbArgs[0];
                                    $colName = $dbArgs[1];
                                    $id = $dbArgs[3];
                                    $data = $this->_db->select($tbleName, 'id', $colName . '=? AND ' . $dbArgs[2] . '!=?', [Input::post('email'), $id]);
                                }
                                if (count($data)) {

                                    $this->setErrors($field, $rules['label'] . 'must be unique');
                                }
                                break;

                            case "valid_email":
                                if (!filter_var(Input::post($field), FILTER_VALIDATE_EMAIL)) {
                                    $this->setErrors($field, $rules['label'] . ' is not a valid email');
                                }
                                break;

                            case "matches":
                                if (Input::post($field) !== Input::post($rule_value)) {
                                    $this->setErrors($field, $rules['label'] . ' mismatch');
                                }
                                break;
                            case "valid_date_mysql":
                                if(!preg_match('/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2})/',Input::post($field))){
                                    $this->setErrors($field,$rules['label'].' Invalid');
                                }




                        }


                    }
                }
            }
        }
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function setErrors($field, $errorMsg)
    {
        $this->_errors[$field] = $errorMsg;
    }

    public function isValid()
    {
        if (empty($this->_errors)) {
            return true;
        } else {
            return false;
        }
    }

}