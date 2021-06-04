<?php
require_once('../../Models/MindMap4.php');

class MindMap4Controller {
  private $request; //リクエストパラメーター(GET,POST)
  private $MindMap4 ; 
  

  public function __construct(){
    //リクエストパラメーターの取得
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;

    //モデルオブジェクトの作成
    $this->MindMap4  = new MindMap4();
  }


  public function getMatch($user_id,$mind3_id){
    $params = $this->MindMap4->getMatch($user_id,$mind3_id);
    return $params;
  }
  public function Create($user_id,$connect){
    $this->MindMap4->CreateMindMap4($user_id,$connect);
  }
  public function Update($update){
    $this->MindMap4->UpdateMindMap4($update);
  }
  public function delete($id){
    $this->MindMap4->DeleteMindMap4($id);
  }
  public function findById($id){
    $params = $this->MindMap4->findById($id);
    return $params;
  }
}