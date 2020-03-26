<?php
require_once '../conf/const.php';
require_once '../model/functions.php';
require_once '../model/user.php';
require_once '../model/item.php';

session_start();

if(is_logined() === false){ //ログインに失敗した場合
  redirect_to(LOGIN_URL); //ログインURLへリダイレクト
}

$db = get_db_connect(); //データベースへ接続
$user = get_login_user($db); //ユーザーログイン

$items = get_open_items($db); //データベースのアイテム情報取得

include_once VIEW_PATH . 'index_view.php'; //html読み込み