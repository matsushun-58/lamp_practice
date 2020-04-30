<?php
//エラーが発生した場合処理を中断、非表示
require_once '../conf/const.php'; //設定ファイル読み込み
require_once MODEL_PATH . 'functions.php'; //関数ファイル読み込み
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'order.php';
require_once MODEL_PATH . 'order_detail.php';

session_start(); //セッション開始

if(is_logined() === false){ //ログイン失敗した場合、リダイレクト
  redirect_to(LOGIN_URL);
}

$db = get_db_connect(); //データベース接続
$user = get_login_user($db); //ユーザーログイン設定

$orders = get_orders($db, $user);

$csrf_token = get_csrf_token();

//iframeでの読み込みを禁止する
header('X-FRAME-OPTIONS: DENY');

include_once VIEW_PATH . 'order_view.php'; //エラーの場合、警告文を出すが処理を続行(何も表示されなくなる為)