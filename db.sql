CREATE DATABASE blog39_blog;
USE blog39_blog;
SET NAMES utf8;
create table b39_blog
(
	id mediumint unsigned not null auto_increment comment 'Id',
	title varchar(150) not null comment '日志名称',
	content longtext comment '内容',
	is_show enum('是','否') not null default '是' comment '是否显示',
	addtime datetime not null comment '添加时间',
	logo varchar(150) not null default '' comment '原图',
	sm_logo varchar(150) not null default '' comment '小图',
	mid_logo varchar(150) not null default '' comment '中图',
	big_logo varchar(150) not null default '' comment '大图',
	mbig_logo varchar(150) not null default '' comment '更大图',
	primary key (id)
)engine=InnoDB default charset=utf8 comment '日志';