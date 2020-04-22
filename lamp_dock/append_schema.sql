--
-- テーブルの構造 非正規化テーブルを一旦作成→第３正規化まで順を追って作成していく
-- 
-- 購入履歴画面：'purchase_history'⇨'orders'に変更
-- 「注文番号」「購入日時」「該当の注文番号の購入金額」
-- 上3つに必要な情報も取得「ユーザー名」「アイテム名」「単価」「在庫数」
-- 

-- 第1正規化

-- CREATE TABLE `orders` (
--   `order_id` int(11) NOT NULL AUTO_INCREMENT,
--   `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
--   `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
--   `user_id` int(11) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sample`.`orders` (
  `order_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `updated` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `user_id` INT(11) NOT NULL , 
  PRIMARY KEY (`order_id`)
) ENGINE = InnoDB;

-- CREATE TABLE `order_details` (
--   `order_detail_id` int(11) NOT NULL AUTO_INCREMENT,
--   `order_id` int(11) NOT NULL,
--   `item_id` int(11) NOT NULL,
--   `order_price` int(11) NOT NULL,
--   `item_amount` int(11) NOT NULL,
--   `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
--   `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sample`.`order_details` (
  `order_detail_id` INT NOT NULL AUTO_INCREMENT ,
  `order_id` INT NOT NULL ,
  `item_id` INT NOT NULL ,
  `order_price` INT NOT NULL ,
  `item_amount` INT NOT NULL ,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `updated` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`order_detail_id`)
) ENGINE = InnoDB;

-- 第2正規化(itemsとして既に存在する)

-- CREATE TABLE `products` (
--   `item_id` int(11) NOT NULL,
--   `item_price` int(11) NOT NULL
-- )
-- 第3正規化は今回は必要なし

-- 
-- 購入明細画面は既存のテーブルで表示可能
-- 「商品名」「購入時の商品価格」「購入数」「小計」
-- 