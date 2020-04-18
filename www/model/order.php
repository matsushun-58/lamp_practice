<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// DB利用

function insert_order_detail($db, $user_id, $created){
    $sql ="
    INSERT INTO
        orders(
            user_id,
            created
        )
    VALUES(:user_id, :created)
    ";
    $params = array(
        ':user_id' => $user_id,
        ':created' => $created
      );
    
    return execute_query($db, $sql, $params);
}