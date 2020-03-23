<?php

// MODEL_PATH:'DOCUMENT_ROOT'※ここではhtml、「.」は連結、wwwディレクトリへ移動した後、modelへ移動
define('MODEL_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../model/');
// VIEW_PATH:上記と同様、viewへ移動
define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../view/');

// imagesに移動
define('IMAGE_PATH', '/assets/images/');
// cssに移動
define('STYLESHEET_PATH', '/assets/css/');
// $_SERVER . imagesに移動 画像ファイル保存
define('IMAGE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/assets/images/' );

define('DB_HOST', 'mysql'); //データベースの接続情報
define('DB_NAME', 'sample'); //データベース名
define('DB_USER', 'testuser'); //ユーザーネーム情報
define('DB_PASS', 'password'); //パスワード情報
define('DB_CHARSET', 'utf8'); //DB文字エンコーディング

define('SIGNUP_URL', '/signup.php'); //値:サインアップに移動
define('LOGIN_URL', '/login.php'); //ログインに移動
define('LOGOUT_URL', '/logout.php'); //ログアウトに移動
define('HOME_URL', '/index.php'); //index.phpへ移動
define('CART_URL', '/cart.php'); //カート情報へ移動
define('FINISH_URL', '/finish.php'); //finish.phpへ移動
define('ADMIN_URL', '/admin.php'); //管理ページへ移動

define('REGEXP_ALPHANUMERIC', '/\A[0-9a-zA-Z]+\z/'); //正規表現：検索パターンを記載/半角英数字
define('REGEXP_POSITIVE_INTEGER', '/\A([1-9][0-9]*|0)\z/'); //最初の数字は1-9or0


define('USER_NAME_LENGTH_MIN', 6); //ユーザー名の最小文字数指定
define('USER_NAME_LENGTH_MAX', 100); //ユーザー名の最大文字数指定
define('USER_PASSWORD_LENGTH_MIN', 6); //パスワードの最小文字数指定
define('USER_PASSWORD_LENGTH_MAX', 100); //パスワードの最大文字数指定

define('USER_TYPE_ADMIN', 1); //1の場合管理ページへ移行
define('USER_TYPE_NORMAL', 2); //2の場合、通常ページへ移行

define('ITEM_NAME_LENGTH_MIN', 1);  //アイテム名の最小文字数指定
define('ITEM_NAME_LENGTH_MAX', 100); //アイテム名の最大文字数指定

define('ITEM_STATUS_OPEN', 1); //アイテム表示
define('ITEM_STATUS_CLOSE', 0); //アイテム非表示

//アイテムステータスの公開可否設定
define('PERMITTED_ITEM_STATUSES', array(
  'open' => 1,
  'close' => 0,
));

//画像データの拡張子チェック
define('PERMITTED_IMAGE_TYPES', array(
  IMAGETYPE_JPEG => 'jpg',
  IMAGETYPE_PNG => 'png',
));