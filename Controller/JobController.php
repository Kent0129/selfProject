<?php
require_once('../../Models/Job.php');

class JobController {
  private $request; //リクエストパラメーター(GET,POST)
  private $Job; //Playerモデル
  

  public function __construct(){
    //リクエストパラメーターの取得
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;

    //モデルオブジェクトの作成
    $this->Job = new Job();
  }
  public function index() {
    $page = 0;
    if(isset($this->request['get']['page'])){
        $page = $this->request['get']['page'];
    }
    $job = $this->Job->findAll($page);
    $job_count = $this->Job->countAll();
    $params = [
      'job' => $job,
      'pages' => $job_count / 12
    ];
    return $params;
  }
  public function getOffer($user_id) {
    $page = 0;
    if(isset($this->request['get']['page'])){
        $page = $this->request['get']['page'];
    }
    $job = $this->Job->getOffer($user_id,$page);
    $job_count = $this->Job->countAll();
    $params = [
      'job' => $job,
      'pages' => $job_count / 12
    ];
    return $params;
  }

  public function showOffer($company_id) {
    $page = 0;
    if(isset($this->request['get']['page'])){
        $page = $this->request['get']['page'];
    }
    $job = $this->Job->showOffer($company_id,$page);
    $job_count = $this->Job->countAll();
    $params = [
      'job' => $job,
      'pages' => $job_count / 12
    ];
    return $params;
  }

  public function search($words,$search){
    $page = 0;
    if(isset($this->request['get']['page'])){
        $page = $this->request['get']['page'];
    }
    $job = $this->Job->searchAll($words,$search,$page);
    $job_count = $this->Job->countAll();
    $params = [
      'job' => $job,
      'pages' => $job_count / 12
    ];
    return $params;
  }

  public function findById($id){
    $result = $this->Job->findById($id);
    return $result;
  }

  public function Update($params){
    $this->Job->UpdateJob($params);
  }
  
  public function Create($user_id,$params){
    $result = $this->Job->CreateJob($user_id,$params);
    return $result;
  }
  public function Delete($id){
    $this->Job->Delete($id);
  }
}