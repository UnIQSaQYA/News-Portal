<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 8/28/2016
 * Time: 9:03 PM
 */
class user extends model
{
    protected $tableName = 'users';
    protected $primaryKey = 'id';
    protected $columnName = '*';
    private $_validate;
    public $location = HTTP . "public_html/img/user/";
    private $rule = array(
        'uname' => array(
            'required' => true,
            'min' => 3,
            'label' => 'User Name'
        ),
        'email' => array(
            'required' => true,
            'unique' => 'users|email',
            'valid_email' => true,
            'label' => 'Email'
        ),
        'password' => array(
            'required' => true,
            'min' => 4,
            'label' => 'Password'
        ),
        'cpassword' => array(
            'required' => true,
            'matches' => 'password',
            'label' => 'Confirm Password'
        ),

        'auth_type' => array(
            'required' => true,
            'label' => 'Authentication'
        )

    );
    public $pagination="";

    public function __construct()
    {
        parent::__construct();
        $this->_validate = new validation();

    }


    /**
     * This functions inserts the users into Database
     */
    public function addUser()
    {


        $this->_validate->validate($this->rule);

        if ($this->_validate->isValid()) {

            $upload = [
                'max_size' => '5242880',
                'location' => ROOT . 'public_html/img/user/',
                'valid_ext' => 'jpg|jpeg|png|gif'
            ];

            upload::initialize($upload);
            $fileName = upload::doUpload($_FILES['upload']);

            if ($fileName) {

                $data = [
                    'uname' => Input::post('uname'),
                    'email' => Input::post('email'),
                    'upload' => $fileName,
                    'password' => hash::passwordEndcrypt(Input::post('password')),
                    'auth_type' => Input::post('auth_type')
                ];

                if ($this->save($data)) {
                    session::set('success', "User added successfully");
                    redirect_to('user-list');
                } else {
                    redirect_to('add-user');
                }
            } else {
                foreach ($_POST as $fieldKey => $fieldValue) {
                    session::set($fieldKey, $fieldValue);
                }
                session::set('uploadErrors', upload::getUploadErrors());
            }


        } else {

            $errorMsg = $this->_validate->getErrors();
            foreach ($_POST as $fieldKey => $fieldValue) {
                session::set($fieldKey, $fieldValue);
            }
            session::set('validationErrors', $errorMsg);
            redirect_to('add-user');

        }


    }


    public function getUser($id = NULL)
    {
        if (isset($id)) {

            $user = $this->get($id);
            if (count($user)) {
                return $user[0];
            } else {
                return [];
            }
        }


        $this->limit=2;
        $config['limit']=$this->limit;
        $config['total_rows']= $this->rowCount();
        $offset=pagination::initialize($config);
        $this->offset=$offset;
        $this->pagination=pagination::createLinks();

        return $this->get();
    }


    public function changeUserStatus()
    {
        $id = Input::post('id');
        if (empty($id)) return false;

        $action = Input::post('action');

        if ($action == 'Enable') {
            $data = array(
                'user_status' => 'enable'
            );
            session::set('success', 'User was Enabled');

        } else {
            $data = array(
                'user_status' => 'disable'
            );
            session::set('success', 'User was Disabled');
        }
        if ($this->save($data, $id)) {
            redirect_to('user-list');
        } else {
            return false;
        }

    }


    /** Gets id from delete.php and sends id to delete function of model.php
     * @param null $id
     * @return value from delete method of model.php
     */
    public function deleteUser($id = NULL)
    {
        $this->columnName = 'upload';
        $img = $this->getUser($id);

        if (!empty($img)) {
            upload::deleteFiles(ROOT . 'public_html/img/user/' . $img->upload);

        }
        return $this->delete($id);


    }


    /** Updates the user
     * validates the updated info, checks the old password and updates the data
     * @return bool
     */
    public function updateUser()
    {
        $id = (int)Input::post('id');
        if (empty($id)) return false;

        $this->rule['oldpassword'] = [
            'required' => true,
            'oldpassword' => 'users|password|' . $id,
            'label' => 'Old Password'
        ];

        $this->rule['email']['unique'] = 'users|email|id|' . $id;
        $this->_validate->validate($this->rule);


        if ($this->_validate->isValid()) {

            if (empty($_FILES['upload']['name'])) {
                $data = [
                    'uname' => Input::post('uname'),
                    'email' => Input::post('email'),
                    'password' => hash::passwordEndcrypt(Input::post('password')),
                    'auth_type' => Input::post('auth_type')
                ];
            } else {
                $upload = [
                    'max_size' => '5242880',
                    'location' => ROOT . 'public_html/img/user/',
                    'valid_ext' => 'jpg|jpeg|png|gif'
                ];
                upload::initialize($upload);
                $fileName = upload::doUpload($_FILES['upload']);

                if ($fileName) {
                    $this->columnName = 'upload';
                    $img = $this->getUser($id);

                    if (!empty($img)) {
                        upload::deleteFiles(ROOT . 'public_html/img/user/' . $img->upload);

                    }
                    $data = [
                        'uname' => Input::post('uname'),
                        'email' => Input::post('email'),
                        'upload' => $fileName,
                        'password' => hash::passwordEndcrypt(Input::post('password')),
                        'auth_type' => Input::post('auth_type')
                    ];
                } else {
                    session::set('uploadErrors', upload::getUploadErrors());

                }

            }


            if ($this->save($data, $id)) {
                session::set('success', "User updated successfully");
                redirect_to('user-list');
            } else {
                session::set('error', "User could not be updated");
                redirect_to('user-list');
            }
        } else {
            $errorMsg = $this->_validate->getErrors();
            session::set('validationErrors', $errorMsg);
            redirect_to('update-user&uid=' . $id);
        }

    }


    /**
     * Validates the login credentials
     * Checks the credentials with value from DB and redirects to dashboard
     */
public function login(){

    unset($this->rule['email']['unique']);

    $this->_validate->validate($this->rule);
    if($this->_validate->isValid()){
       $user= $this->selectBy('email=?',[Input::post('email')],true);
        if (count($user)){
            if(hash::passwordVerify(Input::post('password'),$user->password) &&
                Input::post('auth_type')===$user->auth_type &&
                $user->user_status=='enable'){
                $userData['logged_user_name']=$user->uname;
                $userData['logged_user_email']=$user->email;
                $userData['auth_type']=$user->auth_type;
                $userData['logged_user_image']=$user->upload;
                $userData['logged_user_id']=$user->id;

                $userData['is_logged_in']=true;
                session::userData($userData);
                redirect_to('dashboard');
            }else{
                session::set('error','Invalid Credentials');
            }

        }else{
            session::set('error','Invalid Credentials');
        }

    }else{
        session::set('validationErrors',$this->_validate->getErrors());
    }

}

}

