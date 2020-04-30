<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// DB利用

function insert_order_detail($db, $order_id, $item_id, $order_price, $item_amount){
    $sql ="
    INSERT INTO
        order_details(
            order_id,
            item_id,
            order_price,
            item_amount
        )
    VALUES(:order_id, :item_id, :order_price, :item_amount)
    ";
    $params = array(
        ':order_id' => $order_id,
        ':item_id' => $item_id,
        ':order_price' => $order_price,
        ':item_amount' => $item_amount
      );
    
    return execute_query($db, $sql, $params);
}

  function get_order_details($db, $order_id){
    $sql = '
      SELECT
        order_details.order_detail_id,
        order_details.order_id,
        order_details.item_id,
        order_details.order_price,
        order_details.item_amount,
        items.name
      FROM
        order_details
      JOIN
        items
      ON
        order_details.item_id = items.item_id
      WHERE
        order_details.order_id = :order_id
    ';
    $params = array(
      ':order_id' => $order_id
    );
  
    return fetch_all_query($db, $sql, $params);
  }