<?php
require_once('../../Models/LikeJob.php');

class LikeJobController {
  private $request; //リクエストパラメーター(GET,POST)
  private $LikeJob; //Playerモデル
  

  public function __construct(){
    //リクエストパラメーターの取得
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;

    //モデルオブジェクトの作成
    $this->LikeJob = new LikeJob();
  }
  public function getAll($user_id){
    $result = $this->LikeJob->getAll($user_id);
    return $result;
  }
  public function getLike($j_id){
    $result = $this->LikeJob->getLike($j_id);
    return $result;
  }
  public function isLike($u_id,$j_id){
    $result = $this->LikeJob->isLike($u_id,$j_id);
    return $result;
  }
  public function DbConnect(){
    $result = $this->LikeJob->DbConnect();
    return $result;
  }
}