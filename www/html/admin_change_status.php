<?php
require_once '../conf/const.php'; //エラーが出た場合処理を中断、設定ファイル読み込み
require_once MODEL_PATH . 'functions.php'; //function読み込み、model:関数をまとめて定義
require_once MODEL_PATH . 'user.php'; //user読み込み
require_once MODEL_PATH . 'item.php'; //item読み込み

session_start(); //セッション開始

if(is_logined() === false){ //ログインに失敗した場合、ログインページへリダイレクト
  redirect_to(LOGIN_URL);
}

$db = get_db_connect(); //データベースに接続

$user = get_login_user($db); //データベースにユーザーログイン

if(is_admin($user) === false){ //ユーザー登録がなかった場合、リダイレクト
  redirect_to(LOGIN_URL);
}

$item_id = get_post('item_id'); //アイテムidを取得
$changes_to = get_post('changes_to'); //変更を取得

if($changes_to === 'open'){ //変更情報が表示される場合
  update_item_status($db, $item_id, ITEM_STATUS_OPEN); //アイテムステータスをアップデート
  set_message('ステータスを変更しました。'); //メッセージが表示される
}else if($changes_to === 'close'){ //非表示となる場合
  update_item_status($db, $item_id, ITEM_STATUS_CLOSE); //アイテムステータスをアップデート
  set_message('ステータスを変更しました。'); //メッセージが表示される
}else {
  set_error('不正なリクエストです。'); //エラーメッセージ表示
}


redirect_to(ADMIN_URL); //管理ページへリダイレクト