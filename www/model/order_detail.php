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