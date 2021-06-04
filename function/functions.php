<?php
/**
 * XSS対策：エスケープ処理
 * 
 * @param string $$ 対象の文字列
 * @return string 処理された文字列
 */
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

/**
 * CSRF対策
 * @param void
 * @return string $csrf_token
 */
function setToken(){
  //トークンを生成
  //フォームからそのトークンを送信
  //送信後の画面でそのトークンを照会
  //トークンを削除
  $csrf_token = bin2hex(random_bytes(32));
  $_SESSION['csrf_token'] = $csrf_token;

  return $csrf_token;
}

/**
 * 空白を分割する昨日
 * 
 * @param string $$ 空白を含んだ対象の文字列
 * @return string 処理された文字列
 */
function extractKeywords(string $input, int $limit = -1): array{
  return preg_split('/[\p{Z}\p{Cc}]++/u', $input, $limit, PREG_SPLIT_NO_EMPTY);
}
//改行を読み込む
function n($t){
  return nl2br($t);
}

// 文字数が100文字より多いならば三点リーダーを付ける 
function str100($text){
  return mb_strimwidth( $text, 0, 100, '…', 'UTF-8' );
}

function str($text){
  return mb_strimwidth( $text, 0, 250, '…', 'UTF-8' );
}

function jstr($text){
  return mb_strimwidth( $text, 0, 500, '…', 'UTF-8' );
}


