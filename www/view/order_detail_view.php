<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入明細</title>
  <link rel="stylesheet" href="<?php print(h(STYLESHEET_PATH . 'cart.css')); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入明細</h1>
  <div class="container">

    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <table class="table table-bordered">
    <thead class="thead-light">
            <tr>
                <th>注文番号</th>
                <th>購入日時</th>
                <th>購入金額</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php print(h ($order['order_id']) ); ?></td>
                <td><?php print(h ($order['created']) ); ?></td>
                <td><?php print(h (number_format($order['sum'])) )?>円</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>商品名</th>
                <th>商品価格</th>
                <th>購入数</th>
                <th>小計</th>
            </tr>
          </div>
        </thead>
        <tbody>
            <?php foreach($details as $detail){ ?>
            <tr>
                    <td><?php print(h ($detail['name']) ); ?></td>
                    <td><?php print(h (number_format($detail['order_price'])) ); ?>円</td>
                    <td><?php print(h ($detail['item_amount']) );?>個</td>
                    <td><?php print(h (number_format($detail['order_price'] * $detail['item_amount'])) );?>円</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
  </div>
  <form action="order_detail.php" method="get">
      <input type="hidden" name="user_id" value="<?php print(h ($order['user_id']) ) ?>">
    </form>
</body>
</html>