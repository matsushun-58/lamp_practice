<?php
//エラーが発生した場合処理を中断、非表示
require_once '../conf/const.php'; //設定ファイル読み込み
require_once MODEL_PATH . 'functions.php'; //MODEL_PATH:関数ファイル読み込み
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start(); //セッション開始

if(is_logined() === false){ //ログイン失敗した場合、リダイレクト
  redirect_to(LOGIN_URL);
}

$db = get_db_connect(); //データベース接続

$user = get_login_user($db); //データベースにユーザーログイン

if(is_admin($user) === false){ //ユーザー登録がなかった場合、リダイレクト
  redirect_to(LOGIN_URL);
}

$item_id = get_post('item_id'); //アイテムid取得
$stock = get_post('stock'); //ストック数取得

if(update_item_stock($db, $item_id, $stock)){ //ストック数がアップデートされた場合
  set_message('在庫数を変更しました。'); //変更メッセージ表示
} else {
  set_error('在庫数の変更に失敗しました。'); //エラーメッセージ表示
}

redirect_to(ADMIN_URL); //管理ページへリダイレクト