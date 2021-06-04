<?php
require_once('../../Models/MindMap2.php');
require_once('../../Models/MindMap3.php');
require_once('../../Models/MindMap4.php');

class MindMap2Controller {
  private $request; //リクエストパラメーター(GET,POST)
  private $MindMap2; 
  private $MindMap3; 
  private $MindMap4; 
  
  

  public function __construct(){
    //リクエストパラメーターの取得
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;

    //モデルオブジェクトの作成
    $this->MindMap2  = new MindMap2();
    $this->MindMap3  = new MindMap3();
    $this->MindMap4  = new MindMap4();
  }

  public function getMatch($user_id,$mind1_id){
    $params = $this->MindMap2->getMatch($user_id,$mind1_id);
    return $params;
  }
  public function Create($user_id,$connect){
    $this->MindMap2->CreateMindMap2($user_id,$connect);
  }
  public function Update($update){
    $this->MindMap2->UpdateMindMap2($update);
  }
  public function Delete($id){
    $this->MindMap2->DeleteMindMap2($id);
    $this->MindMap3->deleteChain2($id);
    $this->MindMap4->deleteChain2($id);
  }
  public function findById($id){
    $params = $this->MindMap2->findById($id);
    return $params;
  }
}