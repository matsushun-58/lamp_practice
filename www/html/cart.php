<?php
//エラーが発生した場合処理を中断、非表示
require_once '../conf/const.php'; //設定ファイル読み込み
require_once MODEL_PATH . 'functions.php'; //関数ファイル読み込み
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start(); //セッション開始

if(is_logined() === false){ //ログイン失敗した場合、リダイレクト
  redirect_to(LOGIN_URL);
}

$db = get_db_connect(); //データベース接続
$user = get_login_user($db); //ユーザーログイン設定

$carts = get_user_carts($db, $user['user_id']); //カートの中身取得

$total_price = sum_carts($carts); //カートの合計金額表示
// view.phpを読み込む直前にトークンの生成を行う※再生成も行う
$csrf_token = get_csrf_token();
include_once VIEW_PATH . 'cart_view.php'; //エラーの場合、警告文を出すが処理を続行(何も表示されなくなる為)