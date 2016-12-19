<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 9/12/2016
 * Time: 8:46 PM
 */
class imageUpload extends model
{
    protected $tableName = 'upload';
    protected $primaryKey = 'id';
    protected $columnName = '*';
    public $location = ASSET . '/img/gallery/';
    private $_validate; //hold validation Instance

    private $rule = array(
        'upload_category_name' => array(
            'required' => true,
            'unique' => 'upload_categories|name',
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
     * method to to upload the image by checking its configurations
     * and passing the multiple data of images to the doUpload method
     */
    public function uploadImage()
    {
        $config['valid_ext'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 5000000;
        $config['location'] = ROOT . "public_html/img/gallery/";

        $i = 0;
        $success = false;
        foreach ($_FILES['upload']['name'] as $key => $file) {

            $uploadInfo['name'] = $file;
            $uploadInfo['error'] = $_FILES['upload']['error'][$key];
            $uploadInfo['tmp_name'] = $_FILES['upload']['tmp_name'][$key];
            $uploadInfo['size'] = $_FILES['upload']['size'][$key];


            upload::initialize($config);
            $imageName = upload::doUpload($uploadInfo);
            if ($imageName) {
                $data = [
                    'name' => $imageName,
                    'category_id' => Input::post('category')
                ];
                if ($this->save($data)) {
                    $i++;
                    session::set('success', $i . 'image upload');
                    $success = true;
                }
            } else {
                session::set('uploadErrors', upload::getUploadErrors());
            }
        }

        if ($success == true) {
            redirect_to('gallery-cat');
        }

    }

    /**To select and show multiple images
     * @param null $catID
     * @return bool
     */
    public function selectImages($catID = null)
    {
        if (!isset($catID)) return false;

        /**
         * SELECT upload.*, upload_categories.name
         * FROM upload
         * JOIN upload_categories
         * ON upload.category_id=upload_categories.id AND category_id=2
         */
        $this->columnName = 'upload.*, upload_categories.name cat_name';
        $this->tableName = 'upload JOIN upload_categories';

        return $this->selectBy('upload.category_id=upload_categories.id AND category_id=?', [$catID]);

    }

    /**
     *To delete the multiple files from the server's location and database
     */
    public function deleteMultipleImages()
    {
        if (empty($_POST['upId'])) return false;

        $ids = $_POST['upId'];
        $i = 0;

        foreach ($ids as $id) {
            $this->columnName = 'name';
            $imageName = $this->get((int)$id)[0]->name;
            if (upload::deleteFiles(ROOT . 'public_html/img/gallery/' . $imageName)) {
                $idCol[] = (int)$id;
                $i++;
            }
        }
        $idCol = implode(',', $idCol);
        if ($this->delete($idCol)) {
            session::set('success', $i . 'Images Deleted');
            redirect_to('gallery-cat');
        }
    }

}