<?php
//エラーが発生した場合処理を中断、非表示
require_once '../conf/const.php'; //設定ファイル読み込み
require_once MODEL_PATH . 'functions.php'; //関数ファイル読み込み
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start(); //セッション開始

if(is_logined() === false){ //ログイン失敗した場合リダイレクト
  redirect_to(LOGIN_URL);
}

$db = get_db_connect(); //データベース接続

$user = get_login_user($db); //ユーザーログイン

if(is_admin($user) === false){ //ユーザー登録がなかった場合、リダイレクト
  redirect_to(LOGIN_URL);
}

$name = get_post('name'); //名前取得
$price = get_post('price'); //値段取得
$status = get_post('status'); //ステータス取得
$stock = get_post('stock'); //在庫数取得

$image = get_file('image'); //画像取得

if(regist_item($db, $name, $price, $stock, $status, $image)){ //商品情報が登録された場合
  set_message('商品を登録しました。'); //メッセージ表示
}else {
  set_error('商品の登録に失敗しました。'); //エラーメッセージ表示
}


redirect_to(ADMIN_URL); //管理ページリダイレクト