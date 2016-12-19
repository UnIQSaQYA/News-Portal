<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 8/28/2016
 * Time: 9:03 PM
 */
class galleryCategory extends model
{
    protected $tableName = 'upload_Categories';
    protected $primaryKey = 'id';
    protected $columnName = '*';
    private $_validate; //hold validation Instance

    private $rule = array(
        'upload_category_name' => array(
            'required' => true,
            'unique'=>'upload_categories|name',
            'min' => 3,
            'label' => 'Upload Category Name'
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
                'name'=>Input::post('upload_category_name')
            ];
            if($this->save($data)){
                session::set('success','Upload Category Was Added');
            }else{
                session::set('error','Couldn\'t create category');
            }

        } else {
            session::set('validationErrors', $this->_validate->getErrors());
        }
        redirect_to('upload-category');
    }

    /** Method to retrieve categories from db through model
     * @param null $id
     * @return mixed
     */
    public function getCategory($id=NULL)
    {
        if(isset($id)){

        }
        return $this->get();

    }

    /**To get the values of upload_categories.
     *                                     ->id
     *                                     ->name and
     *upload.category_id
     * @return bool|mixed
     */
    public function getCategoryImageNo(){
        /**
         * SELECT upload_categories.id,upload_categories.name,COUNT(upload.category_id)
         * FROM upload_categories LEFT
         * JOIN upload
         * ON upload_categories.id=upload.category_id
         * GROUP BY upload_categories.id
         */
        $query="SELECT upload_categories.id,upload_categories.name,COUNT(upload.category_id) img_count 
                FROM upload_categories 
                LEFT JOIN upload
                ON upload_categories.id=upload.category_id 
                GROUP BY upload_categories.id";
        return $this->dbRaw($query,[]);


    }
}

