<?php
require_once('../../Models/MindMap1.php');
require_once('../../Models/MindMap2.php');
require_once('../../Models/MindMap3.php');
require_once('../../Models/MindMap4.php');

class MindMap1Controller {
  private $request; //リクエストパラメーター(GET,POST)
  private $MindMap1;
  private $MindMap2; 
  private $MindMap3; 
  private $MindMap4;  
  

  public function __construct(){
    //リクエストパラメーターの取得
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;

    //モデルオブジェクトの作成
    $this->MindMap1  = new MindMap1();
    $this->MindMap2  = new MindMap2();
    $this->MindMap3  = new MindMap3();
    $this->MindMap4  = new MindMap4();
  }
  public function getAll(){
    $params = $this->MindMap1->getAll();
    return $params;
  }
  public function getMatch($user_id){
    $params = $this->MindMap1->getMatch($user_id);
    return $params;
  }

  public function Create($user_id,$content){
    $this->MindMap1->CreateMindMap($user_id,$content);
  }
  public function Update($update){
    $this->MindMap1->UpdateMindMap1($update);
  }
  public function Delete($id){
    $this->MindMap1->DeleteMindMap1($id);
    $this->MindMap2->deleteChain1($id);
    $this->MindMap3->deleteChain1($id);
    $this->MindMap4->deleteChain1($id);
  }
  public function findById($id){
    $params = $this->MindMap1->findById($id);
    return $params;
  }
}