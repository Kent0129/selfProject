<?php
require_once('../../Models/Prefectures.php');
require_once('../../Models/Sector.php');

class ReadController {
  private $request; //リクエストパラメーター(GET,POST)
  private $Prefectures; 
  private $Sector; 
  
  public function __construct(){
    //リクエストパラメーターの取得
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;

    //モデルオブジェクトの作成
    $this->Prefectures = new Prefectures();
    $this->Sector = new Sector();
  }


  public function getPrefectures(){
    $params = $this->Prefectures->getAll();
    return $params;
  }

  public function getSector(){
    $params = $this->Sector->getAll();
    return $params;
  }

}