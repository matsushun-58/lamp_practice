<?php 
require_once MODEL_PATH . 'functions.php'; //関数ページ読み込み
require_once MODEL_PATH . 'db.php';

function get_user_carts($db, $user_id){ //引数あり関数の定義(データベース、ユーザーid)
  //sql文を作成
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = {$user_id}
  ";
  return fetch_all_query($db, $sql); //戻り値あり
}

function get_user_cart($db, $user_id, $item_id){ //引数あり関数の定義(データベース、ユーザーid、アイテムid)
  //sql文の作成
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = {$user_id}
    AND
      items.item_id = {$item_id}
  ";

  return fetch_query($db, $sql); //戻り値の作成

}

function add_cart($db, $user_id, $item_id ) { //引数あり関数の定義(データベース、ユーザーid、アイテムid)
  $cart = get_user_cart($db, $user_id, $item_id); //カート変数
  if($cart === false){ //カートの中身が異なっていた場合
    return insert_cart($db, $user_id, $item_id); //戻り値(insert_cart)
  }
  return update_cart_amount($db, $cart['cart_id'], $cart['amount'] + 1); //戻り値、アップデート(データベース、カートid、cart['amount'])
}

function insert_cart($db, $user_id, $item_id, $amount = 1){ //引数あり関数の定義(データベース、ユーザーid、アイテムid、数量(1指定))
  //sql文作成
  $sql = "
    INSERT INTO
      carts(
        item_id,
        user_id,
        amount
      )
    VALUES({$item_id}, {$user_id}, {$amount}) //処理内容
  ";

  return execute_query($db, $sql); //戻り値、データベース、sql
}

function update_cart_amount($db, $cart_id, $amount){ //引数あり関数の定義(アップデートしたカートの中身)
  //sql文作成
  $sql = "
    UPDATE
      carts
    SET
      amount = {$amount}
    WHERE
      cart_id = {$cart_id}
    LIMIT 1
  ";
  
  return execute_query($db, $sql); //戻り値の作成
}

function delete_cart($db, $cart_id){ //引数あり関数の定義(カートの中身を削除)
  $sql = "
    DELETE FROM
      carts
    WHERE
      cart_id = {$cart_id}
    LIMIT 1
  ";
// LIMIT:問合せ結果の行数を制限する

  return execute_query($db, $sql); //戻り値の作成
}

function purchase_carts($db, $carts){ //カート購入の定義
  if(validate_cart_purchase($carts) === false){ //カートの中身の検証に失敗した場合
    return false; //戻り値でfalse指定
  }
  foreach($carts as $cart){ //$cartsの中身を$cart内に配列表示
    if(update_item_stock(
        $db, 
        $cart['item_id'], 
        $cart['stock'] - $cart['amount']
      ) === false){ //カートの中身のアップデートに失敗した場合
      set_error($cart['name'] . 'の購入に失敗しました。'); //エラーメッセージ表示
    }
  }
  
  delete_user_carts($db, $carts[0]['user_id']); //カートidの中身を削除
}

function delete_user_carts($db, $user_id){ //カートの中身を削除
  //sql文を作成
  $sql = "
    DELETE FROM
      carts
    WHERE
      user_id = {$user_id}
  ";

  execute_query($db, $sql); //sql文の実行
}


function sum_carts($carts){ //カートの合計金額
  $total_price = 0; //合計金額0
  foreach($carts as $cart){
    $total_price += $cart['price'] * $cart['amount']; //合計金額 = 価格*数量
  }
  return $total_price;  //戻り値:合計金額
}

function validate_cart_purchase($carts){ //カートの購入を検証
  if(count($carts) === 0){ //カートの中身が0の場合
    set_error('カートに商品が入っていません。'); //エラーメッセージ表示
    return false;
  }
  foreach($carts as $cart){ //カートの中身を配列
    if(is_open($cart) === false){ //処理が失敗した場合
      set_error($cart['name'] . 'は現在購入できません。'); //エラーメッセージ表示
    }
    if($cart['stock'] - $cart['amount'] < 0){ //在庫数-購入数が0以下だった場合
      set_error($cart['name'] . 'は在庫が足りません。購入可能数:' . $cart['stock']); //メッセージ表示
    }
  }
  if(has_error() === true){ //Bootstrapで定義されているcssのクラス
    return false;
  }
  return true;
}

