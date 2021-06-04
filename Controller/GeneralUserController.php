<?php
require_once('../../Models/GeneralUser.php');

class GeneralUserController  {
  private $request; //リクエストパラメーター(GET,POST)
  private $GeneralUser; 
  

  public function __construct(){
    //リクエストパラメーターの取得
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;

    //モデルオブジェクトの作成
    $this->GeneralUser = new GeneralUser();
  }
  public function Create($user_id,$connect){
    $this->GeneralUser->CreateGeneralUser($user_id,$connect);
  }
  public function Update($user_id,$params){
    $this->GeneralUser->UpdateGeneralUser($user_id,$params);
  }
  public function getAll(){
    $page = 0;
    if(isset($this->request['get']['page'])){
        $page = $this->request['get']['page'];
    }
    $g_user = $this->GeneralUser->getAll();
    $count = $this->GeneralUser->countAll();
    $result = [
      'g_user' => $g_user,
      'pages' => $count / 15
    ];
    return $result;
  }
  public function getUser($id){
    $result = $this->GeneralUser->getUser($id);
    return $result;
  }

  public function findById($user_id){
    $result = $this->GeneralUser->findById($user_id);
    return $result;
  }
  public function Check($user_id){
    $result = $this->GeneralUser->Check($user_id);
    return $result;
  }

  public function search($words,$prefectures_id){
    $page = 0;
    if(isset($this->request['get']['page'])){
        $page = $this->request['get']['page'];
    }
    $g_user = $this->GeneralUser->search($words,$prefectures_id,$page);
    if($g_user){
      $count = $this->GeneralUser->countAll();
      $result = [
        'g_user' => $g_user,
        'pages' => $count / 15
      ];
      return $result;
    }
    return false;
  }

}