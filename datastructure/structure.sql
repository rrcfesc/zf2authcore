drop database if exists zf2auth;
create database if not exists zf2auth;
use zf2auth;
drop table if exists users_roles;
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

create table if not exists role (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Role Id',
    roleId varchar(255) NOT NULL COMMENT '',
    parent int null,
    state tinyint,
    FOREIGN KEY (parent)
        REFERENCES role(id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE InnoDB;

CREATE TABLE if not exists `users_roles` (
  `userId` INT NOT NULL,
  `roleId` INT NOT NULL,
  INDEX `userIdFK_idx` (`userId` ASC),
  INDEX `roleIdFK_idx` (`roleId` ASC),
  CONSTRAINT `userIdFK`
    FOREIGN KEY (`userId`)
    REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `roleIdFK`
    FOREIGN KEY (`roleId`)
    REFERENCES `role` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);