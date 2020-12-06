CREATE TABLE `task` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL,
	`description` varchar(10000) NOT NULL,
	`price` INT(11) NOT NULL,
	`category_id` INT(11) NOT NULL,
	`create_time` DATETIME NOT NULL,
	`status` varchar(50) NOT NULL,
	`city_id` INT(11) NOT NULL,
	`lat` varchar(10) NOT NULL,
	`long` varchar(10) NOT NULL,
	`deadline` DATETIME NOT NULL,
	`rating` INT(1) NOT NULL,
	`file` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `category` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(50) NOT NULL,
	`icon` varchar(50) NOT NULL,
	`price_color` varchar(10) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `user` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`email` varchar(255) NOT NULL,
	`password_hash` varchar(50) NOT NULL,
	`register_date` DATETIME NOT NULL,
	`city_id` INT(11) NOT NULL,
	`avatar` varchar(50) NOT NULL,
	`role` varchar(30) NOT NULL,
	`birthday` DATETIME NOT NULL,
	`portfolio_photo` varchar(1000) NOT NULL,
	`phone` varchar(11) NOT NULL,
	`skype` varchar(50) NOT NULL,
	`telegram` varchar(50) NOT NULL,
	`show_profile` BOOLEAN NOT NULL,
	`show_contacts` BOOLEAN NOT NULL,
	`notification` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `task_response` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`task_id` INT(11) NOT NULL,
	`worker_id` INT(11) NOT NULL,
	`text` varchar(1000) NOT NULL,
	`price` INT(11) NOT NULL,
	`date` DATETIME NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `city` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`lat` varchar(10) NOT NULL,
	`long` varchar(10) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `message` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`text` varchar(5000) NOT NULL,
	`task_id` INT(11) NOT NULL,
	`user_id` INT(11) NOT NULL,
	`date` DATETIME NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `review` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`task_id` INT(11) NOT NULL,
	`customer_id` INT(11) NOT NULL,
	`worker_id` INT(11) NOT NULL,
	`text` varchar(1000) NOT NULL,
	`rating` INT(1) NOT NULL,
	`date` DATETIME NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `user_category` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`category_id` INT(11) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `favorive` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`customer_id` INT(11) NOT NULL,
	`worker_id` INT(11) NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `task` ADD CONSTRAINT `task_fk0` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`);

ALTER TABLE `task` ADD CONSTRAINT `task_fk1` FOREIGN KEY (`city_id`) REFERENCES `city`(`id`);

ALTER TABLE `user` ADD CONSTRAINT `user_fk0` FOREIGN KEY (`city_id`) REFERENCES `city`(`id`);

ALTER TABLE `task_response` ADD CONSTRAINT `task_response_fk0` FOREIGN KEY (`task_id`) REFERENCES `task`(`id`);

ALTER TABLE `task_response` ADD CONSTRAINT `task_response_fk1` FOREIGN KEY (`worker_id`) REFERENCES `user`(`id`);

ALTER TABLE `message` ADD CONSTRAINT `message_fk0` FOREIGN KEY (`task_id`) REFERENCES `task`(`id`);

ALTER TABLE `message` ADD CONSTRAINT `message_fk1` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `review` ADD CONSTRAINT `review_fk0` FOREIGN KEY (`task_id`) REFERENCES `task`(`id`);

ALTER TABLE `review` ADD CONSTRAINT `review_fk1` FOREIGN KEY (`customer_id`) REFERENCES `user`(`id`);

ALTER TABLE `review` ADD CONSTRAINT `review_fk2` FOREIGN KEY (`worker_id`) REFERENCES `user`(`id`);

ALTER TABLE `user_category` ADD CONSTRAINT `user_category_fk0` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`);

ALTER TABLE `user_category` ADD CONSTRAINT `user_category_fk1` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`);

ALTER TABLE `favorive` ADD CONSTRAINT `favorive_fk0` FOREIGN KEY (`customer_id`) REFERENCES `user`(`id`);

ALTER TABLE `favorive` ADD CONSTRAINT `favorive_fk1` FOREIGN KEY (`worker_id`) REFERENCES `user`(`id`);

