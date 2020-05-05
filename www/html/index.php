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

$lineup = get_get('lineup');

$items = get_open_items($db, $lineup); //データベースのアイテム情報取得

// トークンの生成を行う
$csrf_token = get_csrf_token();

//iframeでの読み込みを禁止する
header('X-FRAME-OPTIONS: DENY');

include_once VIEW_PATH . 'index_view.php'; //html読み込み