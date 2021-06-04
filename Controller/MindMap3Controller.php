<?php
require_once('../../Models/MindMap3.php');
require_once('../../Models/MindMap4.php');

class MindMap3Controller {
  private $request; //リクエストパラメーター(GET,POST)
  private $MindMap3; 
  private $MindMap4; 
  

  public function __construct(){
    //リクエストパラメーターの取得
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;

    //モデルオブジェクトの作成
    $this->MindMap3  = new MindMap3();
    $this->MindMap4  = new MindMap4();
  }

  public function getMatch($user_id,$mind2_id){
    $params = $this->MindMap3->getMatch($user_id,$mind2_id);
    return $params;
  }
  public function Create($user_id,$connect){
    $this->MindMap3->CreateMindMap3($user_id,$connect);
  }
  public function Update($update){
    $this->MindMap3->UpdateMindMap3($update);
  }
  public function Delete($id){
    $this->MindMap3->DeleteMindMap3($id);
    $this->MindMap4->deleteChain3($id);
  }
  public function findById($id){
    $params = $this->MindMap3->findById($id);
    return $params;
  }
}