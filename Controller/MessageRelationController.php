<?php
require_once('../../Models/MessageRelation.php');

class MessageRelationController {
  private $request; //リクエストパラメーター(GET,POST)
  private $MessageRelation; 
  

  public function __construct(){
    //リクエストパラメーターの取得
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;

    //モデルオブジェクトの作成
    $this->MessageRelation = new MessageRelation();
  }
  public function Entry($user_id,$general_id,$company_id,$job_id){
    $result = $this->MessageRelation->Entry($user_id,$general_id,$company_id,$job_id);
    return $result;
  }

  public function ScoutCheck($user_id,$general_id){
    $check = $this->MessageRelation->ScoutCheck($user_id,$general_id);
      return $check;
  }
  public function Scout($user_id,$general_id,$company_id){
    $result = $this->MessageRelation->Scout($user_id,$general_id,$company_id);
    return $result;
  }
  public function getName($user_id){
    $params = $this->MessageRelation->getMessageRelationGeneral($user_id);
    return $params;
  }
  public function getMessageRelationCompany($user_id){
    $params = $this->MessageRelation->getMessageRelationCompany($user_id);
    return $params;
  }
}