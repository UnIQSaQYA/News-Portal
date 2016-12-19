<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 8/28/2016
 * Time: 9:03 PM
 */
class news extends model
{
    protected $tableName = 'news';
    protected $primaryKey = 'id';
    protected $columnName = '*';
    private $_validate; //hold validation Instance
    public $upload_location=HTTP.'public_html/img/news/';
    public $pagination="";
    private $rule = array(
        'title' => array(
            'required' => true,
            'min' => 5,
            'label' => 'Title'
        ),
        'date'=>array(
            'required'=>true,
            'valid_date_mysql'=>true,
            'label'=>'Date'
        ),
        'categoryId'=>array(
          'mustSet'=>true,
            'label'=>'Category'
        ),
        'priority'=>array(
            'required'=>true,
            'label'=>'Priority'
        ),
        'sDesc'=>array(
            'required'=>true,
            'label'=>'Short Description'
        ),
        'desc'=>array(
            'required'=>true,
            'label'=>'Description'
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
    public function addNews()
    {
        //$handle=false;
        $categoryId=Input::post('categoryId');
        if(empty($categoryId)){
            session::set('validationErrors',['categoryId'=>'Must select a category']);
           redirect_to('add-news');
            // $handle=true;
        }
        $this->_validate->validate($this->rule);
        if ($this->_validate->isValid()) {
            $config['valid_ext']='jpg|jpeg|png|gif';
            $config['location']=ROOT.'public_html/img/news/';
            $config['max_size']=10000000;
            upload::initialize($config);
            $fileName=upload::doUpload($_FILES['upload']);

            if($fileName){

                $data = [
                    'title'=>Input::post('title'),
                    'user_id'=>session::get('logged_user_id'),
                    'news_date'=>Input::post('date'),
                    'image'=>$fileName,
                    'priority'=>Input::post('priority'),
                    'description'=>Input::post('desc'),
                    'short_desc'=>Input::post('sDesc')
                ];
                $lastInsertedId=$this->save($data);
                if($lastInsertedId){
                    $categoryIds=Input::post('categoryId');
                    $cIS=false;

                    foreach ($categoryIds as $categoryId){
                        $data=[
                            'news_id'=>$lastInsertedId,
                            'category_id'=>$categoryId
                        ];
                        $this->tableName='news_categories';
                        if($this->save($data)){
                            session::set('success','News was Added');
                            $cIS=true;
                        }else{
                            $cIS=false;
                            session::set('error','Couldn\'t add categories');
                        }
                    }
                    if($cIS==true){
                        redirect_to('news-list');
                    }else{
                        redirect_to('add-news');
                    }
                }
                else{
                    session::set('error','Couldn\'t create news');
                    redirect_to('add-news');
                }
            }else{
                session::set('uploadErrors',upload::getUploadErrors());
                redirect_to('add-news');
            }
        } else {
            session::set('validationErrors', $this->_validate->getErrors());
        }

    }

    /**To fetch the data from news table and for pagination
     * @return bool|mixed
     */
    public function getNews()
    {
        $limit=3;
        $config['limit']=$limit;
        $config['total_rows']= $this->rowCount();
        $offset=pagination::initialize($config);
        $this->pagination=pagination::createLinks();


        $sql="SELECT news.id,news.title,news.image,news.priority,users.uname,GROUP_CONCAT(categories.name SEPARATOR ',') cat
              FROM news 
              JOIN news_categories 
              ON news.id=news_categories.news_id
              JOIN categories
              ON news_categories.category_id=categories.id
              JOIN users
              ON news.user_id=users.id
              GROUP BY news.id LIMIT {$limit} OFFSET {$offset}";
        return $this->dbRaw($sql,[]);

    }


    /**To Delete the news from Db
     * @param null $id
     * @return bool
     */
    public function delNews($id = NULL){
            $this->columnName = 'image';
            $img = $this->getNews($id);

            if (!empty($img)) {
                upload::deleteFiles(ROOT . 'public_html/img/news/' . $img->upload);

            }
            return $this->delete($id);



    }

    /**Changes the priority of the news
     * If one is set high all others are set to low
     * @return bool
     */
    public function setPriority(){
        $id = Input::post('id');
        if (empty($id)) return false;

        $priority = Input::post('priority');

        if ($priority == 'High') {
            $data = array(
                'priority' => 'high'
            );
            session::set('success', 'Priority set High');

        } else {
            $data = array(
                'priority' => 'low'
            );
            session::set('success', 'Priority set low');
        }
        $_db=new Database();
        if ($_db->update($this->tableName,$data,$this->primaryKey.'!=?',[$id])) {
            redirect_to('news-list');
        } else {
            return false;
        }
    }


    /** Checks whether the news is set to high or low
     * @return bool
     */
    public function isHighExist(){
        $this->columnName="id";
        $newsHigh=$this->selectBy("priority='high'",[]);

        if(count($newsHigh)){
            return true;
        }else{
            return false;
        }
    }

}

