<?php
//エラーが発生した場合処理を中断、非表示
require_once '../conf/const.php'; //設定ファイル読み込み
require_once MODEL_PATH . 'functions.php'; //関数ファイル読み込み
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start(); //セッション開始

if(is_logined() === false){ //ログイン失敗した場合、リダイレクト
  redirect_to(LOGIN_URL);
}

$db = get_db_connect(); //データベース接続

$user = get_login_user($db); //管理ページにユーザーログイン

if(is_admin($user) === false){ //ユーザー登録がなかった場合、リダイレクト
  redirect_to(LOGIN_URL);
}

$item_id = get_post('item_id'); //アイテムid取得


if(destroy_item($db, $item_id) === true){ //商品削除が成功した場合
  set_message('商品を削除しました。'); //メッセージ表示
} else {
  set_error('商品削除に失敗しました。'); //エラーメッセージ表示
}



redirect_to(ADMIN_URL);