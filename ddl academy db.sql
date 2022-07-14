-- Exported from QuickDBD: https://www.quickdatabasediagrams.com/
-- Link to schema: https://app.quickdatabasediagrams.com/#/d/RKXGYh
-- NOTE! If you have used non-SQL datatypes in your design, you will have to change these here.


CREATE TABLE `role` (
 `role_id` int AUTO_INCREMENT  ,
 `role_name` varchar(20)  ,
 `created_at` timestamp  default current_timestamp ,
 `updated_at` timestamp  default current_timestamp ,
 PRIMARY KEY (
  `role_id`
 )
);

CREATE TABLE `users` (
 `user_id` int AUTO_INCREMENT  ,
 `email` varchar(50) ,
 `password` varchar(50) ,
 `role_id` int  ,
 `created_at` timestamp default current_timestamp,
 `updated_at` timestamp default current_timestamp,
 PRIMARY KEY (
  `user_id`
 )
);

CREATE TABLE `student` (
 `student_id` int AUTO_INCREMENT  ,
 `year` varchar(10),
 `nis` varchar(50),
 `email` varchar(50),
 `name` varchar(255),
 `gender` varchar(20),
 `phone` varchar(25),
 `address` text,
 `date_of_birth` date,
 `status` varchar(20),
 `class_id` int,
 `unit_id` int,
 `description` text,
 `created_at` timestamp default current_timestamp,
 `updated_at` timestamp default current_timestamp,
 PRIMARY KEY (
  `student_id`
 )
);

CREATE TABLE `employee` (
 `employee_id` int AUTO_INCREMENT  ,
 `nik` varchar(50),
 `email` varchar(50),
 `name` varchar(255),
 `gender` varchar(20),
 `phone` varchar(25),
 `status` varchar(25),
 `address` text,
 `date_of_join` date,
 `created_at` timestamp default current_timestamp,
 `updated_at` timestamp default current_timestamp,
 PRIMARY KEY (
  `employee_id`
 )
);

CREATE TABLE `category_payment` (
 `category_payment_id` int AUTO_INCREMENT  ,
 `category_payment` varchar(50),
 `amount` decimal(16,2),
 `type` varchar(25),
 `created_at` timestamp default current_timestamp,
 `updated_at` timestamp default current_timestamp,
 PRIMARY KEY (
  `category_payment_id`
 )
);

CREATE TABLE `payment` (
 `payment_id` int AUTO_INCREMENT  ,
 `student_id` int,
 `date_of_paid` date,
 `category_payment_id` int,
 `amount` decimal(16,2),
 `adjusment_amount` decimal(16,2),
 `payment_method` varchar(25),
 `created_at` timestamp default current_timestamp,
 `updated_at` timestamp default current_timestamp,
 PRIMARY KEY (
  `payment_id`
 )
);

CREATE TABLE `unit` (
 `unit_id` int AUTO_INCREMENT  ,
 `unit` varchar(25),
 `created_at` timestamp default current_timestamp,
 `updated_at` timestamp default current_timestamp,
 PRIMARY KEY (
  `unit_id`
 )
);

CREATE TABLE `class` (
 `class_id` int AUTO_INCREMENT  ,
 `class_name` varchar(25),
 `majors` varchar(25),
 `created_at` timestamp default current_timestamp,
 `updated_at` timestamp default current_timestamp,
 PRIMARY KEY (
  `class_id`
 )
);

-- ALTER TABLE `users` ADD CONSTRAINT `fk_users_role_id` FOREIGN KEY(`role_id`)
-- REFERENCES `role` (`role_id`);

-- ALTER TABLE `student` ADD CONSTRAINT `fk_student_email` FOREIGN KEY(`email`)
-- REFERENCES `users` (`email`);

-- ALTER TABLE `student` ADD CONSTRAINT `fk_student_class_id` FOREIGN KEY(`class_id`)
-- REFERENCES `class` (`class_id`);

-- ALTER TABLE `student` ADD CONSTRAINT `fk_student_unit_id` FOREIGN KEY(`unit_id`)
-- REFERENCES `unit` (`unit_id`);

-- ALTER TABLE `employee` ADD CONSTRAINT `fk_employee_email` FOREIGN KEY(`email`)
-- REFERENCES `users` (`email`);

-- ALTER TABLE `payment` ADD CONSTRAINT `fk_payment_student_id` FOREIGN KEY(`student_id`)
-- REFERENCES `student` (`student_id`);

-- ALTER TABLE `payment` ADD CONSTRAINT `fk_payment_category_payment_id` FOREIGN KEY(`category_payment_id`)
-- REFERENCES `category_payment` (`category_payment_id`);

