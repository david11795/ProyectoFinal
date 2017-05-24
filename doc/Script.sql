drop database if exists dffproyecto;

create database if not exists dffproyecto;
use dffproyecto;

create table if not exists usuario (
	user varchar(30) primary key,
    email varchar(60),
    password varchar(64)
);


create table if not exists t_url (
	shorturl varchar(20) primary key,
    url text,
    fechaCreacion datetime,
    visitas int,
    propietario varchar(30),
    constraint foreign key (`propietario`) references usuario (`user`) ON DELETE CASCADE ON UPDATE CASCADE
);


ALTER TABLE  `t_url` CHANGE  `fechaCreacion`  `fechaCreacion` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;




