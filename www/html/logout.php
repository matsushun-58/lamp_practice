<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

session_start();
$_SESSION = array(); //配列をセッションに入れて取り出す
$params = session_get_cookie_params(); //セッションクッキーのパラメーターを得る
setcookie(session_name(), '', time() - 42000, //セッション時間指定
  $params["path"], 
  $params["domain"],
  $params["secure"], 
  $params["httponly"] //httpクッキーを有効にするための設定
);
session_destroy(); //セッション破壊

redirect_to(LOGIN_URL);

