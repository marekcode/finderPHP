<?php
require 'bootstrap.php';

$statement = <<<EOS
    DROP TABLE comments;
    DROP TABLE articles;
    DROP TABLE authors;
    DROP TABLE categories;

    CREATE TABLE authors (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        firstname varchar(256) NOT NULL,
        lastname varchar(256) NOT NULL,
        created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE categories (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name varchar(256) NOT NULL,
        created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE articles (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        author_id int(11) NOT NULL,
        category_id int(11) NOT NULL,
        title varchar(256) NOT NULL,
        content text NOT NULL,
        created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE RESTRICT,
        CONSTRAINT FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    CREATE TABLE comments (
        id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        article_id int(11) NOT NULL,
        name varchar(256) NOT NULL,
        comment text NOT NULL,
        email varchar(256) NOT NULL,
        www varchar(256) NOT NULL,
        created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        modified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    INSERT INTO authors (firstname, lastname) VALUES ('Jacek', 'Placek');
    INSERT INTO authors (firstname, lastname) VALUES ('Szymon', 'Drzazga');

    INSERT INTO categories (name) VALUES ('Drewutnia');
    INSERT INTO categories (name) VALUES ('Gotowanie');

    INSERT INTO articles (author_id, category_id, title, content) VALUES ('2', '1', 'Drzewo', 'Dobre drzewa są dobre');
    INSERT INTO articles (author_id, category_id, title, content) VALUES ('1', '2', 'Pyzy', 'Smaczne i zdrowe');
    INSERT INTO articles (author_id, category_id, title, content) VALUES ('1', '2', 'Ziemniaki', 'Soczyste');
    INSERT INTO articles (author_id, category_id, title, content) VALUES ('2', '1', 'Wióry', 'Jakie wióry');
    
    INSERT INTO comment (article_id, name, comment, email, www) VALUES ('1', 'aaa', 'aaaa', 'aaaaa');
    INSERT INTO comment (article_id, name, comment, email, www) VALUES ('2', 'aaa', 'aaaa', 'aaaaa');
    INSERT INTO comment (article_id, name, comment, email, www) VALUES ('3', 'aaa', 'aaaa', 'aaaaa');
    INSERT INTO comment (article_id, name, comment, email, www) VALUES ('4', 'aaa', 'aaaa', 'aaaaa');


    articles (* - 1) authors
    categories (1 - *) articles
    articles (1 - *) comments
EOS;

try {
    $createTable = $dbConnection->query($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}
