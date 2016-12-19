<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 8/28/2016
 * Time: 9:03 PM
 */
class category extends model
{
    protected $tableName = 'categories';
    protected $primaryKey = 'id';
    protected $columnName = '*';
    private $_validate; //hold validation Instance

    private $rule = array(
        'category_name' => array(
            'required' => true,
            'min' => 3,
            'label' => 'Category Name'
        )
    );


    public function __construct()
    {
        parent::__construct();
        $this->_validate = new validation();

    }

    /**
     * Validates the input field
     * Saves the data
     * Sets success and error to session
     */
    public function addCategory()
    {
        $this->_validate->validate($this->rule);
        if ($this->_validate->isValid()) {
            $data = [
                'name'=>Input::post('category_name')
            ];
            if($this->save($data)){
                session::set('success','Category was Added');
            }else{
                session::set('error','Couldn\'t create category');
            }

        } else {
            session::set('validationErrors', $this->_validate->getErrors());
        }
        redirect_to('add-category');
    }


    public function getCategory($id=NULL)
    {
        if(isset($id)){

        }
        return $this->get();

    }

}

