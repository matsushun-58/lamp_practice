<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();

if(is_logined() === true){ //ログインに失敗した場合、リダイレクト
  redirect_to(HOME_URL);
}

$name = get_post('name'); //ログインネームポスト
$password = get_post('password'); //パスワードポスト

$db = get_db_connect(); //データベース接続


$user = login_as($db, $name, $password); //ログインに必要な情報
if( $user === false){ //ユーザー認証に失敗した場合
  set_error('ログインに失敗しました。'); //エラーメッセージ
  redirect_to(LOGIN_URL); //ログインページへリダイレクト
}

set_message('ログインしました。'); //ログイン完了メッセージ表示
if ($user['type'] === USER_TYPE_ADMIN){ //$user['type']が1だった場合移行する
  redirect_to(ADMIN_URL); //管理ページへ移行する
}
redirect_to(HOME_URL); //ホームページへ移行する