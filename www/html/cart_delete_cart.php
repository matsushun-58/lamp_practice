<?php
//エラーが発生した場合処理を中断、非表示
require_once '../conf/const.php';  //設定ファイル読み込み
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

$cart_id = get_post('cart_id'); //カートid取得

if(delete_cart($db, $cart_id)){  //カート情報が削除された場合
  set_message('カートを削除しました。'); //メッセージ表示
} else {
  set_error('カートの削除に失敗しました。'); //エラーメッセージ表示
}

redirect_to(CART_URL); //管理ページへリダイレクト