<?php
//エラーが発生した場合処理を中断、非表示
require_once '../conf/const.php'; //設定ファイル読み込み
require_once MODEL_PATH . 'functions.php'; //関数ファイル読み込み
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start(); //セッション開始

if(is_logined() === false){ //ログイン失敗した場合リダイレクト
  redirect_to(LOGIN_URL);
}

$csrf_token = get_post('csrf_token');

// formから飛んできたトークンの照合を行う
if (is_valid_csrf_token($csrf_token) === false){
  set_error('不正なアクセスです。'); //エラーメッセージ表示
  redirect_to(HOME_URL);
}
get_csrf_token(); //トークンの書き換えを行う

//iframeでの読み込みを禁止する
header('X-FRAME-OPTIONS: DENY');

$db = get_db_connect(); //データベース接続
$user = get_login_user($db); //ユーザーログイン

$carts = get_user_carts($db, $user['user_id']); //カートの中身習得

if(purchase_carts($db, $carts) === false){ //カートの購入に失敗した場合
  set_error('商品が購入できませんでした。'); //エラーメッセージ表示
  redirect_to(CART_URL); //カートページへ移行
}

$total_price = sum_carts($carts); //カートの合計金額表示

include_once '../view/finish_view.php'; //結果ページ表示