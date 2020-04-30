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
$order_id = get_get('order_id');

$details = get_order_details($db, $order_id);
$order = get_order($db, $order_id);

// 購入明細ページ表示の際
// ・購入履歴に記録されているユーザーIDと、ログインユーザーのユーザーIDが一致
// ・管理者ユーザーは全ての注文を閲覧できる

if($user['user_id'] !== $order['user_id'] && is_admin($user) !== true){ //ドモルガンの法則利用し、elseを使わずにまとめることが可能
  set_error('明細の読み込みに失敗しました');
  redirect_to(ORDER_URL);
}


$csrf_token = get_csrf_token();

//iframeでの読み込みを禁止する
header('X-FRAME-OPTIONS: DENY');

include_once VIEW_PATH . 'order_detail_view.php'; //エラーの場合、警告文を出すが処理を続行(何も表示されなくなる為)