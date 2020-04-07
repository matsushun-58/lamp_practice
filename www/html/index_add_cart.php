<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

// formから飛んできたトークンの照合を行う
if (is_valid_csrf_token($_POST['csrf_token']) === false){
  set_error('不正なアクセスです。'); //エラーメッセージ表示
  redirect_to(HOME_URL);
}

$db = get_db_connect();
$user = get_login_user($db);


$item_id = get_post('item_id'); //アイテムid取得

if(add_cart($db,$user['user_id'], $item_id)){ //カートを追加した場合
  set_message('カートに商品を追加しました。'); //追加成功メッセージ
} else {
  set_error('カートの更新に失敗しました。'); //失敗メッセージ
}

redirect_to(HOME_URL); //ホーム画面へリダイレクト