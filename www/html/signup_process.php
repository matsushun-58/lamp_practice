<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start(); //セッション開始

if(is_logined() === true){ //ログインが成功した場合
  redirect_to(HOME_URL); //ホームページへリダイレクト
}

$name = get_post('name'); //ログインネームポスト
$password = get_post('password'); //パスワードポスト
$password_confirmation = get_post('password_confirmation'); //パスワード確認

$db = get_db_connect(); //データベース接続

try{
  $result = regist_user($db, $name, $password, $password_confirmation); //管理ユーザー照合
  if( $result === false){ //処理に失敗した場合
    set_error('ユーザー登録に失敗しました。'); //エラーメッセージ表示
    redirect_to(SIGNUP_URL);
  }
}catch(PDOException $e){ //エラーキャッチ情報
  set_error('ユーザー登録に失敗しました。'); //エラーメッセージ表示
  redirect_to(SIGNUP_URL);
}

set_message('ユーザー登録が完了しました。'); //ユーザー登録完了メッセージ表示
login_as($db, $name, $password); //ログイン方法
redirect_to(HOME_URL); //ホームページへリダイレクト