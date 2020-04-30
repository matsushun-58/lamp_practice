<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// DB利用

function insert_order($db, $user_id){
    $sql ="
    INSERT INTO
        orders(
            user_id
        )
    VALUES(:user_id)
    ";
    $params = array(
        ':user_id' => $user_id
      );
    return execute_query($db, $sql, $params);
}

function get_order($db, $order_id){
    $sql = "
      SELECT
        orders.order_id, 
        orders.created,
        orders.user_id,
        SUM(order_details.order_price * order_details.item_amount) AS sum
      FROM
        orders
      JOIN
        order_details
      ON
        orders.order_id = order_details.order_id
      WHERE
        orders.order_id = :order_id
      GROUP BY
        orders.order_id
    ";
    // バインドする配列をあらかじめ用意
    $params = array(
      ':order_id' => $order_id
    );
  
    return fetch_query($db, $sql, $params);
  }

  function get_orders($db, $user){ //ASを利用することで置き換え可能
    $sql = '
      SELECT
        orders.order_id, 
        orders.created,
        orders.user_id,
        SUM(order_details.order_price * order_details.item_amount) AS sum
      FROM
        orders
      JOIN
        order_details
      ON
        orders.order_id = order_details.order_id';

    $params = array(); //管理ユーザーの場合、全ユーザー表示で良い為、空配列

    if(is_admin($user) === false){
        $sql .= '
          WHERE
            orders.user_id = :user_id
        ';
        $params = array(
            ':user_id' => $user['user_id']
        ); //一般ユーザーの場合、そのユーザーが購入した分の情報表示
    }

    $sql .= '
      GROUP BY
        orders.order_id
    '; //同じorder_idをまとめる、.=は結合代入演算子
  
    return fetch_all_query($db, $sql, $params);
  }