<?php
require 'bootstrap.php';

$statement = <<<EOS
    CREATE TABLE `articles` (
    `id` int(11) NOT NULL,
    `title` varchar(256) NOT NULL,
    `content` text NOT NULL,
    `author_id` int(11) NOT NULL,
    `category_id` int(11) NOT NULL,
    `created` datetime NOT NULL,
    `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    INSERT INTO `articles` (`id`, `title`, `content`, `author_id`, `category_id`, `created`, `modified`) VALUES
    (1, 'LG P880 4X HD', 'My first awesome phone!', 1, 3, '2014-06-01 01:12:26', '2014-05-31 17:42:26'),
    (2, 'Google Nexus 4', 'The most awesome phone of 2013!', 1, 2, '2014-06-01 01:12:26', '2014-05-31 17:42:26'),
    (3, 'Samsung Galaxy S4', 'How about no?', 2, 3, '2014-06-01 01:12:26', '2014-05-31 17:42:26'),
    (6, 'Bench Shirt', 'The best shirt!', 2, 1, '2014-06-01 01:12:26', '2014-05-31 02:42:21'),
    (7, 'Lenovo Laptop', 'My business partner.', 2, 2, '2014-06-01 01:13:45', '2014-05-31 02:43:39'),
    (8, 'Samsung Galaxy Tab 10.1', 'Good tablet.', 3, 2, '2014-06-01 01:14:13', '2014-05-31 02:44:08'),
    (9, 'Spalding Watch', 'My sports watch.', 4, 1, '2014-06-01 01:18:36', '2014-05-31 02:48:31'),
    (10, 'Sony Smart Watch', 'The coolest smart watch!', 3, 2, '2014-06-06 17:10:01', '2014-06-05 18:39:51'),
    (11, 'Huawei Y300', 'For testing purposes.', 3, 2, '2014-06-06 17:11:04', '2014-06-05 18:40:54'),
    (12, 'Abercrombie Lake Arnold Shirt', 'Perfect as gift!', 4, 1, '2014-06-06 17:12:21', '2014-06-05 18:42:11'),
    (13, 'Abercrombie Allen Brook Shirt', 'Cool red shirt!', 4, 1, '2014-06-06 17:12:59', '2014-06-05 18:42:49'),
    (26, 'Another product', 'Awesome product!', 6, 2, '2014-11-22 19:07:34', '2014-11-21 21:37:34'),
    (28, 'Wallet', 'You can absolutely use this one!', 6, 6, '2014-12-04 21:12:03', '2014-12-03 23:42:03'),
    (31, 'Amanda Waller Shirt', 'New awesome shirt!', 5, 1, '2014-12-13 00:52:54', '2014-12-12 03:22:54'),
    (42, 'Nike Shoes for Men', 'Nike Shoes', 6, 3, '2015-12-12 06:47:08', '2015-12-12 07:17:08'),
    (48, 'Bristol Shoes', 'Awesome shoes.', 5, 5, '2016-01-08 06:36:37', '2016-01-08 07:06:37'),
    (60, 'Rolex Watch', 'Luxury watch.', 5, 1, '2016-01-11 15:46:02', '2016-01-11 16:16:02');
EOS;

try {
    $createTable = $dbConnection->query($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}
