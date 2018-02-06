create database if not exists zf2auth;
use zf2auth;
drop table if exists users;
create table if not exists users (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'User Id',
    username varchar(75) COMMENT 'UserName of the customer',
    email varchar(255) COMMENT '',
    displayName varchar(75)COMMENT '',
    password varchar(128) COMMENT '',
    created DATETIME NOT NULL COMMENT '',
    updated DATETIME NULL COMMENT '',
    state tinyint
) ENGINE InnoDB;