drop database if exists zf2auth;
create database if not exists zf2auth;
use zf2auth;
drop table if exists controllerguard_role_relation;
drop table if exists users_roles;
drop table if exists users;
drop table if exists acl_controllerguard;
drop table if exists role;
drop table if exists acl_resource;
drop table if exists acl_rule;

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
    ON UPDATE CASCADE
) ENGINE InnoDB;

create table if not exists acl_controllerguard(
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identifier',
    controller varchar(255) NOT NULL COMMENT 'NameSpace of the controller',
    action varchar(255) NOT NULL COMMENT 'NameSpace of the controller'
) ENGINE InnoDB;

create table if not exists controllerguard_role_relation (
    controllerguardId int,
    roleId INT NOT NULL,
    INDEX `controllerguardIdFK_idx` (`controllerguardId` ASC),
    INDEX `roleIdCRRFK_idx` (`roleId` ASC),
    CONSTRAINT `controllerguardIdFK`
        FOREIGN KEY (`controllerguardId`)
        REFERENCES `acl_controllerguard` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT `roleIdCRRFK`
        FOREIGN KEY (`roleId`)
        REFERENCES `role` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE InnoDB;

create table if not exists acl_resource (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identifier',
    name varchar(255) NOT NULL COMMENT '',
    description varchar(255) NOT NULL COMMENT ''
) ENGINE InnoDB;

create table if not exists acl_rule (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Identifier',
    resourceId INT NOT NULL,
    roleId INT NOT NULL,
    privilege varchar(255) NOT NULL COMMENT '',
    CONSTRAINT `RoleIdACLRulFK`
        FOREIGN KEY (`roleId`)
        REFERENCES `role` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT `resourceIdACLRulFK`
        FOREIGN KEY (`resourceId`)
        REFERENCES `acl_resource` (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE InnoDB;
