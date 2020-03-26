<?php

function dd($var){ //指定された変数の内容を表示し、スクリプトの実行を表示
  var_dump($var);
  exit();
}

function redirect_to($url){ //リダイレクト処理
  header('Location: ' . $url);
  exit;
}

function get_get($name){ //
  if(isset($_GET[$name]) === true){
    return $_GET[$name];
  };
  return '';
}

function get_post($name){ //名前をポスト
  if(isset($_POST[$name]) === true){
    return $_POST[$name];
  };
  return '';
}

function get_file($name){ //ファイル名をポスト
  if(isset($_FILES[$name]) === true){
    return $_FILES[$name];
  };
  return array();
}

function get_session($name){ //セッション獲得の取得
  if(isset($_SESSION[$name]) === true){ //名前がポストされた時に
    return $_SESSION[$name];
  };
  return '';
}

function set_session($name, $value){ //
  $_SESSION[$name] = $value;
}

function set_error($error){ //エラー表示
  $_SESSION['__errors'][] = $error;
}

function get_errors(){ //エラー取得
  $errors = get_session('__errors');
  if($errors === ''){
    return array();
  }
  set_session('__errors',  array());
  return $errors;
}

function has_error(){ //エラー数が0でなかった場合issetされる
  return isset($_SESSION['__errors']) && count($_SESSION['__errors']) !== 0;
}

function set_message($message){ //メッセージをセット
  $_SESSION['__messages'][] = $message;
}

function get_messages(){ //メッセージを取得
  $messages = get_session('__messages');
  if($messages === ''){
    return array();
  }
  set_session('__messages',  array());
  return $messages;
}

function is_logined(){ //ログインが成功した場合、ユーザーidを取得する
  return get_session('user_id') !== '';
}

function get_upload_filename($file){ //アップロードファイルを取得
  if(is_valid_upload_image($file) === false){ //アップロード画像
    return '';
  }
  $mimetype = exif_imagetype($file['tmp_name']); //exif_imagetype:イメージの型を定義する
  $ext = PERMITTED_IMAGE_TYPES[$mimetype];
  return get_random_string() . '.' . $ext;
}

function get_random_string($length = 20){
  return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}

function save_image($image, $filename){ //画像の保存
  return move_uploaded_file($image['tmp_name'], IMAGE_DIR . $filename);
}

function delete_image($filename){ //画像の削除
  if(file_exists(IMAGE_DIR . $filename) === true){ //画像が確認された場合
    unlink(IMAGE_DIR . $filename); //unlink:ファイルを削除
    return true;
  }
  return false;
  
}



function is_valid_length($string, $minimum_length, $maximum_length = PHP_INT_MAX){
  $length = mb_strlen($string);
  return ($minimum_length <= $length) && ($length <= $maximum_length);
}

function is_alphanumeric($string){ //alpanumeric=a~z、A~Z、0~9の範囲にある文字が含まれていることを確認
  return is_valid_format($string, REGEXP_ALPHANUMERIC);
}

function is_positive_integer($string){ //整数の型
  return is_valid_format($string, REGEXP_POSITIVE_INTEGER);
}

function is_valid_format($string, $format){ //形式の確認
  return preg_match($format, $string) === 1;
}


function is_valid_upload_image($image){
  if(is_uploaded_file($image['tmp_name']) === false){
    set_error('ファイル形式が不正です。');
    return false;
  }
  $mimetype = exif_imagetype($image['tmp_name']);
  if( isset(PERMITTED_IMAGE_TYPES[$mimetype]) === false ){
    set_error('ファイル形式は' . implode('、', PERMITTED_IMAGE_TYPES) . 'のみ利用可能です。');
    return false;
  }
  return true;
}

function h($escape) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
