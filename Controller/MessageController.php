<?php
require_once('../../Models/Message.php');

class MessageController {
  private $request; //リクエストパラメーター(GET,POST)
  private $Message; 
  

  public function __construct(){
    //リクエストパラメーターの取得
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;

    //モデルオブジェクトの作成
    $this->Message = new Message();
  }

  public function contact($message_relation_id,$user_id,$text){
    $this->Message->contactMessage($message_relation_id,$user_id,$text);
  }

  public function MessageAll($message_relation_id){
    $params = $this->Message->MessageAll($message_relation_id);
    return $params;
  }

  public function Create($message_relation_id,$user_id,$text){
    $this->Message->CreateMessage($message_relation_id,$user_id,$text);
  }
  
  public function getLatestMessage($mr_id){
    $result = $this->Message->getLatestMessage($mr_id);
    return $result;
  }
}