<!DOCTYPE html>
<html lang="ja">
<head>
  <!-- head.php読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>商品管理</title>
  <!-- admin.cssを適用 -->
  <link rel="stylesheet" href="<?php print(h(STYLESHEET_PATH . 'admin.css')); ?>">
</head>
<body>
  <?php
  // header_loginedのビューを読み込み
  include VIEW_PATH . 'templates/header_logined.php'; 
  ?>

  <div class="container">
    <h1>商品管理</h1>

<!-- messages.phpを読み込み -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

<!-- enctype:フォーム送信時のデータ形式を指定するための属性 -->
    <form 
      method="post" 
      action="admin_insert_item.php"
      enctype="multipart/form-data"
      class="add_item_form col-md-6"> <!-- admin.cssに記載 col-md-6:col-画面幅-グリッド数 -->
      <div class="form-group">
        <label for="name">名前: </label>
        <input class="form-control" type="text" name="name" id="name">
      </div>
      <div class="form-group">
        <label for="price">価格: </label>
        <input class="form-control" type="number" name="price" id="price">
      </div>
      <div class="form-group">
        <label for="stock">在庫数: </label>
        <input class="form-control" type="number" name="stock" id="stock">
      </div>
      <div class="form-group">
        <label for="image">商品画像: </label>
        <input type="file" name="image" id="image">
      </div>
      <div class="form-group">
        <label for="status">ステータス: </label>
        <select class="form-control" name="status" id="status">
          <option value="open">公開</option>
          <option value="close">非公開</option>
        </select>
      </div>
      
      <input type="submit" value="商品追加" class="btn btn-primary">
    </form>

<!-- アイテムの数が0個以上の場合、if文の中身適用 -->
    <?php if(count($items) > 0){ ?>
      <table class="table table-bordered text-center">
        <thead class="thead-light">
<!-- <tr>:table rowの略、表の横方向を指定する -->
          <tr>
<!-- <th>:table headerの略、表の見出しやタイトルとなるヘッダーセルを指定する -->
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($items as $item){ ?>
          <tr class="<?php print(h(is_open($item) ? '' : 'close_item')); ?>">
            <!-- <td>:table dataの略、テーブルセルの内容を指定 -->
            <!-- 商品画像を表示 -->
            <td><img src="<?php print(h(IMAGE_PATH . $item['image']));?>" class="item_image"></td>
            <!-- 商品名を表示、関数hでエスケープ処理実装 -->
            <td><?php print(h($item['name'])); ?></td>
            <td><?php print(h(number_format($item['price']))); ?>円</td>
            <td>
              <form method="post" action="admin_change_stock.php">
                <div class="form-group">
                  <!-- sqlインジェクション確認のためあえてtext -->
                  <input  type="text" name="stock" value="<?php print(h($item['stock'])); ?>">
                  個
                </div>
                <input type="submit" value="変更" class="btn btn-secondary">
                <input type="hidden" name="item_id" value="<?php print(h($item['item_id'])); ?>">
              </form>
            </td>
            <td>

              <form method="post" action="admin_change_status.php" class="operation">
                <?php if(is_open($item) === true){ ?>
                  <input type="submit" value="公開 → 非公開" class="btn btn-secondary">
                  <input type="hidden" name="changes_to" value="close">
                <?php } else { ?>
                  <input type="submit" value="非公開 → 公開" class="btn btn-secondary">
                  <input type="hidden" name="changes_to" value="open">
                <?php } ?>
                <input type="hidden" name="item_id" value="<?php print(h($item['item_id'])); ?>">
              </form>

              <form method="post" action="admin_delete_item.php">
                <input type="submit" value="削除" class="btn btn-danger delete">
                <input type="hidden" name="item_id" value="<?php print(h($item['item_id'])); ?>">
              </form>

            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      <p>商品はありません。</p>
    <?php } ?> 
  </div>
  <script>
    $('.delete').on('click', () => confirm('本当に削除しますか？'))
  </script>
</body>
</html>