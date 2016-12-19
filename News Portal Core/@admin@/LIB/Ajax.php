<?php

class Ajax extends Model
{
    protected $tableName = "ajax_crud";
    protected $primaryKey = "id";
    protected $columnName = "*";

    public function saveData(){
        $data=[
            'name'=>Input::post('name'),
            'age'=>Input::post('age'),
            'gender'=>Input::post('gender'),
            'lang'=>implode(',',Input::post('language'))
        ];

        if($this->save($data)){
            echo json_encode(['result'=>'success','message'=>'Data was saved Successfully']);
        }else{
            echo json_encode(['result'=>'failed','message'=>'There was a problem']);
        }
    }

    public function getAjaxData(){
        $data=$this->get();

        if(count($data)){
            echo json_encode(['status'=>'success','result'=>$data]);
        }else{
            echo json_encode(['status'=>'fail','result'=>'No data Found']);
        }
    }


    public function deleteAjaxRow(){
        $id=$_POST['id'];
        if(!isset($id)) return false;

        if($this->delete($id)){
            echo json_encode(['status'=>'success','result'=>'Data was deleted successfully']);
        }else{
            echo json_encode(['status'=>'fail']);
        }
    }



    public function editAjax(){
        $id=$_GET['id'];
        if(!empty($id)){
            $data=$this->get($id);
            if($data){
                echo json_encode(['status'=>'success','data'=>$data[0]]);
                exit;
            }
        }
    }



    public function updateAjaxAction(){
        $id=$_POST['id'];
        if(!empty($id)){
            $data=[
                'name'=>Input::post('name'),
                'age'=>Input::post('age'),
                'gender'=>Input::post('gender'),
                'lang'=>implode(',',Input::post('lang'))
            ];

            if($this->save($data,$id)){
                echo json_encode(['result'=>'success','message'=>'Data was updated Successfully']);
            }
        }
    }

}