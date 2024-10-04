CREATE DATABASE labact2;
USE labact2;

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,  
  `department_name` varchar(100) NOT NULL, 
  PRIMARY KEY (`department_id`)
);

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL, 
  `last_name` varchar(50) NOT NULL, 
  `email` varchar(100) NOT NULL, 
  `department_id` int(11) DEFAULT NULL, 
  PRIMARY KEY (`employee_id`), 
  UNIQUE KEY `email` (`email`), 
  KEY `department_id` (`department_id`), 
  CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`)
);

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(100) NOT NULL, 
  PRIMARY KEY (`project_id`)
);

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT, 
  `task_name` varchar(100) NOT NULL, 
  `project_id` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL, 
  PRIMARY KEY (`task_id`), 
  KEY `project_id` (`project_id`), 
  KEY `assigned_to` (`assigned_to`), 
  CONSTRAINT `task_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`), 
  CONSTRAINT `task_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE
);
