
<?php
require_once('../../Models/Company.php');

  class CompanyController {
    private $request; //リクエストパラメーター(GET,POST)
    private $Company; 
    
  
    public function __construct(){
      //リクエストパラメーターの取得
      $this->request['get'] = $_GET;
      $this->request['post'] = $_POST;
  
      //モデルオブジェクトの作成
      $this->Company = new Company();
    }
    
    public function Create($user_id,$connect){
      $this->Company->CreateCompany($user_id,$connect);
    }
    public function Update($user_id,$connect){
      $this->Company->UpdateCompany($user_id,$connect);
    }
    public function getId($user_id){
      $result = $this->Company->findById($user_id);
      foreach($result as $val){
        $id = $val['id'];
      }
      return $id;
    }
    public function findById($user_id){
    $result = $this->Company->findById($user_id);
    return $result;
  }
  public function getUser($id){
    $result = $this->Company->getUser($id);
    return $result;
  }
}