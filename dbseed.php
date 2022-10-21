<?php
require 'bootstrap.php';

$statement = <<<EOS
    CREATE TABLE `articles` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(256) NOT NULL,
    `content` text NOT NULL,
    `author_id` int(11) NOT NULL,
    `category_id` int(11) NOT NULL,
    `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    CREATE TABLE `comments` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(256) NOT NULL,
    `comment` text NOT NULL,
    `email` varchar(256) NOT NULL,
    `www` varchar(256) NOT NULL,
    `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOS;

try {
    $createTable = $dbConnection->query($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}
