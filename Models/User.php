<?php

require_once('Db.php');

class User extends Db {

  /**
  * ユーザーを登録する
  * @param string $email 
  * @param string $password
  * @return bool $result
  */ 
  public function createUser($email, $password,$role) {
    $sql = 'INSERT INTO users (email, password,role) VALUES(:email, :password,:role)';
    $sth = $this->dbh->prepare($sql);
    $sth->bindValue(':email', $email, PDO::PARAM_STR);
    $sth->bindValue(':password', password_hash($password,PASSWORD_DEFAULT));
    $sth->bindValue(':role', $role, PDO::PARAM_INT);
    $result = $sth->execute();
    return $result;
  }

  /**
  * ログイン処理
  * @param string $email 
  * @param string $password
  * @return bool $result
  */ 
public function login($email,$password){
    //結果
    $result = false;
    //ユーザーをemailから検索して取得
    $user = $this->getUserByEmail($email);

    
    //メールアドレスが一致しない場合
     if(!$user){
       $_SESSION['msg'] = 'メールアドレスが一致しません。';
      return $result;
     }

     /* パスワードが入っているか確認
     if(!$user['password'] == null){
      $_SESSION['msg'] = '空じゃない';
      return $result;
     }*/
     
    //パスワードの照会
    if(password_verify($password, $user['password'])) {
      session_regenerate_id(true);
      $_SESSION['login_user'] = $user;
      $result = true;
      return $result;
    }
    //パスワードが一致しない場合
    $_SESSION['msg'] = 'パスワードが一致しません。';
    return $result;
  }

 /**
  * emailからユーザーを取得
  * @param string $email 
  * @return bool $user|false
  */ 
  public function getUserByEmail($email){
    //SQLの準備
    $sql = 'SELECT * FROM users WHERE email = :email';
    //SQLの実行
    try{
      $sth = $this->dbh->prepare($sql);
      $sth->bindValue(':email', $email, PDO::PARAM_STR);
      $sth->execute();
      //SQLの結果を返す
      $user = $sth->fetch(PDO::FETCH_ASSOC);
      return $user;
    } catch(\Exception $e) {
      return false;
    }
  }
  /**
   * ログインチェック
   * @param void
   * @return bool $result
   */
  public function checkLogin(){
    $result = false;
    //セッションにログインユーザーが入っていなかったらfalse
    if(isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0){
      return $result = true;
    }
    return $result;
  }

  /**
   * ログアウト処理
   */
  public function logout(){
    $_SESSION = array();
    session_destroy();
  }
}