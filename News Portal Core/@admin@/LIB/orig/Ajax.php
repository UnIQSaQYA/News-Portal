<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 10/20/2016
 * Time: 2:32 PM
 */
class Ajax extends Model
{
    protected $tableName= 'ajax_crud';
    protected $primaryKey= 'id';
    protected $columnName='*';

    public function saveData(){
        $data=[
            'name'=>Input::post('name'),
            'age'=>Input::post('age'),
            'gender'=>Input::post('gender'),
            'lang'=>implode(',',Input::post('language'))
        ];

        if($this->save($data)){
            echo json_encode(['result'=>'success','message'=>'Data was added successfully']);
        }else{
            echo json_encode(['result'=>'failed','message'=>'Data could not be added']);
        }

    }

    public function getAjaxData(){

        $data=$this->get();

        if(count($data)){
            echo json_encode(['status'=>'success','result'=>$data]);
        }else{
            echo json_encode(['status'=>'fail','result'=>'no data found']);
        }

    }

    public function deleteAjaxRow(){
        $id= $_POST['id'];
       if(!isset($id)) return false;
        if($this->delete($id)){
            echo json_encode(['status'=>'success','result'=>'Data was deleted successfully']);
        }
    }

    public function editAjaxAction(){
        $id=$_GET['id'];
        if(!empty($id)){
            $data =$this->get($id);
            echo json_encode(['status'=>'success','data'=>$data[0]]);
        }

    }

    public function updateAjax(){

        $id=$_POST['id'];

        if(!empty($id)){
            $data=[
                'name'=>Input::post('name'),
                'age'=>Input::post('age'),
                'gender'=>Input::post('gender'),
                'lang'=>implode(',',Input::post('language'))
            ];


            if($this->save($data,$id)){
                echo json_encode(['result'=>'success','message'=>'Data was updated successfully']);
            }else{
                echo json_encode(['result'=>'failed','message'=>'Data could not be updated']);
            }
        }
    }

}