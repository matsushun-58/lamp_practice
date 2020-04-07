<?php
//ファイル読み込み:失敗した場合エラー、別のファイルに保存されているphpスクリプトを取り込むことが可能、エラーの場合処理を中断
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php'; //modelディレクトリのfunction.php読み込み
require_once MODEL_PATH . 'user.php'; //modelディレクトリのuser.php読み込み
require_once MODEL_PATH . 'item.php'; //modelディレクトリのitem.php読み込み

session_start(); //セッション開始

if(is_logined() === false){ //ログインできなかった場合
  redirect_to(LOGIN_URL); //ログインページへリダイレクトする
}

$db = get_db_connect(); //データベースに接続

$user = get_login_user($db); //データベースにログイン

if(is_admin($user) === false){ //ユーザー名が異なっていた場合
  redirect_to(LOGIN_URL); //ログインページへリダイレクトする
}
// admin_view.php読み込む前のトークン生成を行う
$csrf_token = get_csrf_token();
$items = get_all_items($db); //全てのアイテムを確認
include_once VIEW_PATH . '/admin_view.php'; //エラーの場合、警告文を出すが処理を続行(何も表示されなくなる為)
