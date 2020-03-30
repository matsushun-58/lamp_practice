<?php

// データベースに接続する関数
function get_db_connect(){
  // MySQL用のDSN文字列
  $dsn = 'mysql:dbname='. DB_NAME .';host='. DB_HOST .';charset='.DB_CHARSET;
 
  try {
    // データベースに接続
    $dbh = new PDO($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    // 例外を投げる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // ネイティブのプリペアドステートメントを使おうとする
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 結果セットに返された際のカラム名と添字をつけた配列を返す
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    exit('接続できませんでした。理由：'.$e->getMessage() );
  }
  return $dbh;
}

// $params:指定がない場合、デフォルトで空欄
function fetch_query($db, $sql, $params = array()){
  try{
    //sql実行の準備
    $statement = $db->prepare($sql);
    //sql文の実行
    $statement->execute($params);
    //レコードの取得
    return $statement->fetch();
  }catch(PDOException $e){
    set_error('データ取得に失敗しました。'); //エラーメッセージ表示
  }
  return false;
}

function fetch_all_query($db, $sql, $params = array()){ //該当する全てのデータを配列して返す
  try{
    $statement = $db->prepare($sql);
    $statement->execute($params);
    return $statement->fetchAll();
  }catch(PDOException $e){
    set_error('データ取得に失敗しました。');
  }
  return false;
}

function execute_query($db, $sql, $params = array()){
  try{
    $statement = $db->prepare($sql);
    return $statement->execute($params);
  }catch(PDOException $e){
    set_error('更新に失敗しました。');
  }
  return false;
}