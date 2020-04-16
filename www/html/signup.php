<?php
require_once '../conf/const.php'; //管理ページ読み込み
require_once MODEL_PATH . 'functions.php'; //関数ファイル読み込み

session_start(); //セッション開始

if(is_logined() === true){ //ログイン成功した場合
  redirect_to(HOME_URL); //ホームページへリダイレクト
}

// トークンの生成を行う
$csrf_token = get_csrf_token();

//iframeでの読み込みを禁止する
header('X-FRAME-OPTIONS: DENY');

include_once VIEW_PATH . 'signup_view.php'; //signup.php読み込み



