#mahdi
CREATE TABLE `campaign_leads` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `campaign_leads`
  ADD PRIMARY KEY (`id`);
COMMIT;

CREATE TABLE `hiresource` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `hire_source` varchar(110) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4

CREATE TABLE `staffstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1

CREATE TABLE `stafftype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4

#vikash
ALTER TABLE `user_details` ADD `staff_share` INT(1) NOT NULL DEFAULT '0' AFTER `gender`, ADD `work_email` VARCHAR(150) NULL DEFAULT NULL AFTER `staff_share`, ADD `dob` DATE NULL DEFAULT NULL AFTER `work_email`, ADD `father_name` VARCHAR(150) NULL DEFAULT NULL AFTER `dob`, ADD `portal_access` INT(1) NOT NULL DEFAULT '0' AFTER `father_name`, ADD `provident_fund` INT(1) NOT NULL DEFAULT '0' AFTER `portal_access`, ADD `pf_ac_no` VARCHAR(150) NULL DEFAULT NULL AFTER `provident_fund`; 

ALTER TABLE `user_details` ADD `uan` VARCHAR(150) NULL DEFAULT NULL AFTER `pf_ac_no`, ADD `pension_scheme` INT(1) NOT NULL DEFAULT '0' AFTER `uan`, ADD `professional_tax` INT(1) NOT NULL DEFAULT '0' AFTER `pension_scheme`; 

ALTER TABLE `user_details` ADD `manual_diposit` INT(1) NOT NULL DEFAULT '0' AFTER `updated_at`, ADD `cheque_diposit` INT(1) NOT NULL DEFAULT '0' AFTER `manual_diposit`, ADD `ac_holder_name` VARCHAR(150) NULL DEFAULT NULL AFTER `cheque_diposit`, ADD `ac_no` VARCHAR(50) NULL DEFAULT NULL AFTER `ac_holder_name`, ADD `ifsc` VARCHAR(50) NULL DEFAULT NULL AFTER `ac_no`, ADD `ac_type` VARCHAR(50) NULL DEFAULT NULL AFTER `ifsc`; 

ALTER TABLE `hiresource` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT NULL; 
CREATE TABLE `work_location` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `client_id` INT(11) NOT NULL , `work_location` VARCHAR(225) NULL DEFAULT NULL , `created_at` DATETIME NULL DEFAULT NULL , `updated_at` DATETIME NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `staffstatus` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `client_id` INT(11) NOT NULL , `status` VARCHAR(100) NULL DEFAULT NULL , `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` DATETIME NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TABLE `designation` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `client_id` INT(11) NOT NULL , `designation` VARCHAR(100) NULL DEFAULT NULL , `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` DATETIME NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
#03/04/2021
#donation_decision
ALTER TABLE `donations` ADD `donation_decision` VARCHAR(50) NULL DEFAULT NULL AFTER `donation_date`; 

CREATE TABLE `preferred_languages` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `client_id` INT(11) NOT NULL , `preferred_language` VARCHAR(100) NULL DEFAULT NULL , `created_at` DATETIME NULL DEFAULT NULL , `updated_at` DATETIME NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; 


CREATE TABLE `lead_responses` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `client_id` INT(11) NOT NULL , `lead_response` VARCHAR(225) NULL DEFAULT NULL , `created_at` DATETIME NULL DEFAULT NULL , `updated_at` DATETIME NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; 
ALTER TABLE `leads` ADD `lead_response` VARCHAR(225) NULL DEFAULT NULL AFTER `agent_id`; 
#05.04.2021---------------------------------------------------------
CREATE TABLE `lead_statuses` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `client_id` INT(11) NOT NULL , `lead_status` INT(11) NOT NULL , `description` VARCHAR(150) NULL DEFAULT NULL , `created_at` DATETIME NULL DEFAULT NULL , `updated_at` DATETIME NULL DEFAULT NULL , PRIMARY KEY (`id`), UNIQUE (`lead_status`)) ENGINE = InnoDB; 

#------------------------------07.04.2021-----------------------------------------------------------------------------------------
ALTER TABLE `campaign_leads` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
#------------------------------08.04.2021-----------------------------------------------------------------------------------------
CREATE TABLE `campaigns_selecteds` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `client_id` INT(11) NOT NULL , `campaign_id` INT(11) NOT NULL , `campaign_check` INT(1) NOT NULL DEFAULT '0' , `created_at` DATETIME NULL DEFAULT NULL , `updated_at` DATETIME NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; 
ALTER TABLE `campaigns_selecteds` ADD `agent_id` INT(11) NULL DEFAULT NULL AFTER `updated_at`; 
ALTER TABLE `campaign_leads` ADD `agent_id` INT(11) NOT NULL AFTER `campaign_id`; 
ALTER TABLE `donations` CHANGE `donation_decision` `donation_decision` INT(1) NOT NULL DEFAULT '0' COMMENT '0 - Now, 1 - Will Donate';

#===================== Satyajit 12-04-2021 =================================
ALTER TABLE `manual_logged_call` ADD COLUMN `lead_number` VARCHAR(100) NULL AFTER `member_id`, ADD COLUMN `agent_number` VARCHAR(100) NULL AFTER `lead_number`; 
ALTER TABLE `manual_logged_call` ADD COLUMN `status` TINYINT DEFAULT 0 NULL AFTER `description`; 
ALTER TABLE `manual_logged_call` ADD COLUMN `call_initiation` VARCHAR(20) NULL AFTER `call_status`; 
#=============================vikash 15.04.2021================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('meilcomRb9RsVKP1e2QMjt3F4gpBSRCc8rHzXcSe', 141, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY3QxTXNDRE00OEFER3pRdGdBSm10Snl0WnhlbjlLMldydEhGS0RlciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly93d3cuY2xldmVyc3RhY2sudGxkL2NybS9hZG1pbi9sZWFkcy9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNDE7fQ==', 1618492075);

ALTER TABLE `sessions`
  ADD UNIQUE KEY `sessions_id_unique` (`id`);
COMMIT;

#19.04.2021
ALTER TABLE `manual_logged_call` ADD `call_type` INT(1) NULL DEFAULT NULL COMMENT '0- incomming, 1- outgoing' AFTER `status`; 
ALTER TABLE `manual_logged_call` ADD COLUMN `call_initiation` VARCHAR(20) NULL AFTER `call_status`; 
ALTER TABLE `manual_logged_call` CHANGE `call_type` `call_type` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Incoming,Outgoing'; 

#21-04-21
ALTER TABLE `donations` ADD INDEX `donation_purpose_INDX` (`donation_purpose`);
ALTER TABLE `donations` ADD INDEX `donation_client_id_INDX` (`client_id`); 

ALTER TABLE `leads` ADD INDEX `lead_status_INDX` (`lead_status`) , ADD INDEX `client_id_INDX` (`client_id`) , ADD INDEX `account_type_INDX` (`account_type`) , ADD FULLTEXT INDEX `member_type_INDX` (`member_type`); 

ALTER TABLE `campaign_leads` ADD INDEX `agent_id_INDX` (`agent_id`) , ADD INDEX `campaign_id_INDX` (`campaign_id`); 
ALTER TABLE `donations` ADD INDEX `donation_date_INDX` (`donation_date`); 
ALTER TABLE `donations` ADD INDEX `donated_by_INDX` (`donated_by`); 
ALTER TABLE `donation_purpose` ADD INDEX `user_id_INDX` (`user_id`) , ADD INDEX `purpose_INDX` (`purpose`); 
ALTER TABLE `campaign_leads` ADD INDEX `lead_id_INDX` (`lead_id`);

#ALTER TABLE `donations` ADD INDEX `location_INDX` (`location`); 
#ALTER TABLE `branch` ADD INDEX `branch_INDX` (`branch`) , ADD INDEX `client_id_INDX` (`client_id`); 

ALTER TABLE `manual_logged_call` ADD INDEX `member_id_INX` (`member_id`); 
#29.04.2021
ALTER TABLE `donations` ADD `donation_decision_type` VARCHAR(150) NULL DEFAULT NULL AFTER `donation_decision`; 
#03.05.2021
ALTER TABLE `donations` ADD `gift_issued` ENUM('Yes','No') NULL DEFAULT NULL AFTER `donation_decision_type`; 
#04.052021
CREATE TABLE `call_purposes` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `client_id` INT(11) NOT NULL , `purpose` VARCHAR(225) NOT NULL , `created_at` DATETIME NULL DEFAULT NULL , `updated_at` DATETIME NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; 
ALTER TABLE `manual_logged_call` ADD `call_outcome` VARCHAR(225) NULL DEFAULT NULL AFTER `call_purpose`; 
#07.052021
ALTER TABLE `manual_logged_call` ADD COLUMN `campaign_id` INT NULL AFTER `call_outcome`; 

ALTER TABLE `manual_logged_call` CHANGE `call_type` `call_type` TINYINT DEFAULT 0 NULL COMMENT '0=Manual,1=Auto', ADD COLUMN `call_source` TINYINT DEFAULT 0 NULL COMMENT '1=Incoming,0=Outgoing' AFTER `call_type`;

CREATE TABLE `agent_auto_dial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) DEFAULT NULL,
  `dial_status` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4

ALTER TABLE `pause_breaks` CHANGE `pause_time` `pause_time` VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '59:60' NULL;
ALTER TABLE `pause_breaks` CHANGE `pause_limit` `pause_limit` TINYINT(4) DEFAULT 3 NULL; 
ALTER TABLE `pause_breaks` CHANGE `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`id`); 
ALTER TABLE `agent_auto_dial` CHANGE `dial_status` `dial_status` TINYINT(1) DEFAULT 0 NULL;
ALTER TABLE `auto_call_logs` ADD COLUMN `linker_id` INT NULL AFTER `id`; 

CREATE TABLE `auto_call_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linker_id` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `ivrId` varchar(100) DEFAULT NULL,
  `did` varchar(100) DEFAULT NULL,
  `cNumber` varchar(100) DEFAULT NULL,
  `cSTime` varchar(100) DEFAULT NULL,
  `answerThisCallAt` varchar(100) DEFAULT NULL,
  `cETime` varchar(100) DEFAULT NULL,
  `cDuration` varchar(100) DEFAULT NULL,
  `inboundDuration` varchar(100) DEFAULT NULL,
  `operator` varchar(100) DEFAULT NULL,
  `circle` varchar(100) DEFAULT NULL,
  `bunch_id` varchar(100) DEFAULT NULL,
  `HANGUP_TIME` varchar(100) DEFAULT NULL,
  `ivrExecuteFlow` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4


CREATE TABLE `manual_logged_call` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `lead_number` varchar(100) DEFAULT NULL,
  `agent_number` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `outcome` int(11) DEFAULT NULL COMMENT '1 => ''in Process'';\n2 => ''Running'';\n3 => ''Both Answered'';\n4 => ''To (Customer) Answered - From (Agent) Unanswered'';\n5 => ''To (Customer) Answered'';\n6 => ''To (Customer) Unanswered - From (Agent) Answered.'';\n7 => ''From (Agent) Unanswered'';\n8 => ''To (Customer) Unanswered.'';\n9 => ''Both Unanswered'';\n10 => ''From (Agent) Answered.'';\n11 => ''Rejected Call'';\n12 => ''Skipped'';\n13 => ''From (Agent) Failed.'';\n14 => ''To (Customer) Failed - From (Agent) Answered'';\n15 => ''To (Customer) Failed'';\n16 => ''To (Customer) Answered - From (Agent) Failed'';',
  `call_status` tinyint(1) DEFAULT NULL COMMENT '1- available,2- completed,3- follow',
  `call_initiation` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `call_type` tinyint(4) DEFAULT 0 COMMENT '0=Manual,1=Auto',
  `call_source` tinyint(4) DEFAULT 0 COMMENT '1=Incoming,0=Outgoing',
  `call_purpose` varchar(225) DEFAULT NULL,
  `call_outcome` varchar(225) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `recordings_file1` varchar(250) DEFAULT NULL,
  `recordings_file` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id_INX` (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1

#25.05.2021 vikash

ALTER TABLE `campaigns` ADD `start_date` DATE NULL DEFAULT NULL AFTER `status`, ADD `end_date` DATE NULL DEFAULT NULL AFTER `start_date`, ADD `call_to_call_gap` INT(11) NOT NULL DEFAULT '0' AFTER `end_date`, ADD `break_time` INT(11) NOT NULL DEFAULT '0' AFTER `call_to_call_gap`; 

UPDATE `call_purposes` SET `purpose` = 'Add Prayer Request' WHERE `call_purposes`.`id` = 2; 
UPDATE `call_purposes` SET `purpose` = 'Add Donation' WHERE `call_purposes`.`id` = 1; 
#26.05.2021 vikash
INSERT INTO `permissions` (`id`, `slug`, `module`, `permission`, `created_at`, `updated_at`) VALUES (NULL, 'laralum.donation.filters', 'Donation', 'Filters View', '2021-05-26 11:44:35', '2021-05-26 11:44:35'), (NULL, 'laralum.member.filters', 'Member', 'Filters View', '2021-05-26 11:44:35', '2021-05-26 11:44:35'), (NULL, 'laralum.lead.filters', 'Lead', 'Filters View', '2021-05-26 11:44:35', '2021-05-26 11:44:35'), (NULL, 'laralum.activity.filters', 'Activity', 'Filters View', '2021-05-26 11:44:35', '2021-05-26 11:44:35');

INSERT INTO `permissions` (`id`, `slug`, `module`, `permission`, `created_at`, `updated_at`) VALUES (NULL, 'laralum.campaign.filters', 'Campaign', 'Filters View', '2021-05-27 12:33:21', '2021-05-27 12:33:21'); 


ALTER TABLE `manual_logged_call` ADD INDEX `created_by_INDX` (`created_by`); 
ALTER TABLE `sessions` ADD INDEX `user_id_INDX` (`user_id`); 

ALTER TABLE `leads` CHANGE `name` `name` VARCHAR(225) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL; 

ALTER TABLE `campaign_leads` ADD COLUMN `status` TINYINT(1) DEFAULT 0 NOT NULL AFTER `lead_id`;

CREATE TABLE `incomming_leads` ( `id` INT NOT NULL AUTO_INCREMENT, `lead_id` INT, `created_at` DATETIME, `updated_at` DATETIME, PRIMARY KEY (`id`) ); 
ALTER TABLE `user_details` ADD `anual_ctc` BIGINT(15) NULL DEFAULT NULL AFTER `ac_type`, ADD `basic_perc` INT(5) NULL DEFAULT NULL AFTER `anual_ctc`, ADD `hra_perc` INT(5) NULL DEFAULT NULL AFTER `basic_perc`, ADD `special_allowance_per` INT(5) NULL DEFAULT NULL AFTER `hra_perc`; 

ALTER TABLE `user_details` ADD `anual_ctc` BIGINT(15) NULL DEFAULT NULL AFTER `ac_type`, ADD `basic_perc` INT(5) NULL DEFAULT NULL AFTER `anual_ctc`, ADD `hra_perc` INT(5) NULL DEFAULT NULL AFTER `basic_perc`, ADD `special_allowance_per` INT(5) NULL DEFAULT NULL AFTER `hra_perc`; 

ALTER TABLE `user_details` ADD `bank_name` VARCHAR(100) NULL DEFAULT NULL AFTER `ac_holder_name`; 

ALTER TABLE `user_details` ADD `pf_percentage` FLOAT(5,2) NULL DEFAULT NULL AFTER `special_allowance_per`, ADD `esi_percentage` FLOAT(5,2) NULL DEFAULT NULL AFTER `pf_percentage`, ADD `advance_percentage` FLOAT(5,2) NULL DEFAULT NULL AFTER `esi_percentage`, ADD `pt` INT(11) NULL DEFAULT NULL AFTER `advance_percentage`;
#27.07.2021
ALTER TABLE `user_details` CHANGE `basic_perc` `basic_perc` FLOAT(5,2) NULL DEFAULT '0', CHANGE `hra_perc` `hra_perc` FLOAT(5,2) NULL DEFAULT '0', CHANGE `special_allowance_per` `special_allowance_per` FLOAT(5,2) NULL DEFAULT '0';  

ALTER TABLE `user_details` CHANGE `pt` `pt_percentage` FLOAT(5,2) NULL DEFAULT '0'; 

ALTER TABLE `member_issues` ADD INDEX `member_id_INDX` (`member_id`); 
ALTER TABLE `manual_logged_call` ADD INDEX `campaign_id_INDX` (`campaign_id`);
ALTER TABLE `campaign_leads` CHANGE `lead_id` `lead_id` INT(11) NOT NULL; 
ALTER TABLE `manual_logged_call` ADD INDEX `status_INDX` (`status`); 
ALTER TABLE `campaign_agents` ADD INDEX `campaign_id_INDX` (`campaign_id`) , ADD INDEX `agent_id_INDX` (`agent_id`); 

ALTER TABLE `manual_logged_call` ADD `did` VARCHAR(100) NULL DEFAULT NULL AFTER `recordings_file`; 

ALTER TABLE `manual_logged_call` ADD FULLTEXT INDEX `call_purpose_INDX` (`call_purpose`); 
ALTER TABLE `manual_logged_call` ADD INDEX `outcome_INDX` (`outcome`);
ALTER TABLE `manual_logged_call` ADD INDEX `updated_at_INDX` (`updated_at`); 
ALTER TABLE `manual_logged_call` ADD INDEX `call_source_INDX` (`call_source`); 

CREATE TABLE `ivr_settings` ( `id` INT NOT NULL AUTO_INCREMENT, `user_id` INT, `ivr_user_id` VARCHAR(50), `ivr_token` VARCHAR(50), `operator` VARCHAR(50), `created_at` DATETIME, `updated_at` DATETIME, PRIMARY KEY (`id`) ) ENGINE=MYISAM;


ALTER TABLE `attendances` ADD `client_id` INT(11) NULL DEFAULT NULL AFTER `id`; 
ALTER TABLE `leads` ADD `priority` VARCHAR(50) NULL DEFAULT NULL AFTER `lead_status`; 

CREATE TABLE `projects` ( `id` INT NOT NULL AUTO_INCREMENT, `client_id` INT NOT NULL, `name` VARCHAR(191), `location` VARCHAR(191), `created_at` DATETIME, `updated_at` DATETIME, PRIMARY KEY (`id`) ); 




ALTER TABLE `attendance_settings` ADD `client_id` BIGINT(15) NULL DEFAULT NULL AFTER `id`; 
ALTER TABLE `leaves` ADD `client_id` BIGINT(15) NULL DEFAULT NULL AFTER `id`; 
ALTER TABLE `holidays` ADD `client_id` BIGINT(15) NULL DEFAULT NULL AFTER `id`; 
ALTER TABLE `leave_types` ADD `client_id` BIGINT(15) NULL DEFAULT NULL AFTER `id`; 

ALTER TABLE `employee_leave_quotas` ADD `client_id` BIGINT(20) NULL DEFAULT NULL AFTER `id`; 


INSERT INTO `permissions` (`id`, `slug`, `module`, `permission`, `created_at`, `updated_at`) VALUES (NULL, 'laralum.leave.access', 'Staff', 'Access Leave Module', '2021-08-28 18:43:42', '2021-08-28 18:43:42'), (NULL, 'laralum.leave.create', 'Staff', 'Leave Create', '2021-08-28 18:43:42', '2021-08-28 18:43:42'), (NULL, 'laralum.leave.view', 'Staff', 'Leave View', '2021-08-28 18:43:42', '2021-08-28 18:43:42'), (NULL, 'laralum.leave.edit', 'Staff', 'Leave Edit', '2021-08-28 18:43:42', '2021-08-28 18:43:42'), (NULL, 'laralum.leave.delete', 'Staff', 'Leave Delete', '2021-08-28 18:43:42', '2021-08-28 18:43:42');
INSERT INTO `permissions` (`id`, `slug`, `module`, `permission`, `created_at`, `updated_at`) VALUES (NULL, 'laralum.leave.list', 'Staff', 'Leave List', '2021-08-28 19:37:17', '2021-08-28 19:37:17');
INSERT INTO `permissions` (`id`, `slug`, `module`, `permission`, `created_at`, `updated_at`) VALUES (NULL, 'laralum.holiday.access', 'Staff', 'Access Holiday Module', '2021-08-28 20:08:57', '2021-08-28 20:08:57'), (NULL, 'laralum.holiday.list', 'Staff', 'Holiday List', '2021-08-28 20:08:57', '2021-08-28 20:08:57'), (NULL, 'laralum.holiday.create', 'Staff', 'Holiday Create', '2021-08-28 20:08:57', '2021-08-28 20:08:57'), (NULL, 'laralum.holiday.edit', 'Staff', 'Holiday Edit', '2021-08-28 20:08:57', '2021-08-28 20:08:57'), (NULL, 'laralum.holiday.delete', 'Staff', 'Holiday Delete', '2021-08-28 20:08:57', '2021-08-28 20:08:57'), (NULL, 'laralum.holiday.view', 'Staff', 'Holiday View', '2021-08-28 20:08:57', '2021-08-28 20:08:57');

INSERT INTO `permissions` (`id`, `slug`, `module`, `permission`, `created_at`, `updated_at`) VALUES (NULL, 'laralum.attendance.access', 'Staff', 'Access Attendance Module', '2021-08-28 15:07:25', '2021-08-28 15:07:25'), (NULL, 'laralum.attendance.list', 'Staff', 'Attendance List', '2021-08-28 15:07:25', '2021-08-28 15:07:25'), (NULL, 'laralum.attendance.create', 'Staff', 'Attendance Create', '2021-08-28 15:07:25', '2021-08-28 15:07:25'), (NULL, 'laralum.attendance.edit', 'Staff', 'Attendance Edit', '2021-08-28 15:07:25', '2021-08-28 15:07:25'), (NULL, 'laralum.attendance.view', 'Staff', 'Attendance View', '2021-08-28 15:07:25', '2021-08-28 15:07:25'), (NULL, 'laralum.attendance.delete', 'Staff', 'Attendance Delete', '2021-08-28 15:07:25', '2021-08-28 15:07:25');

INSERT INTO `permissions` (`id`, `slug`, `module`, `permission`, `created_at`, `updated_at`) VALUES (NULL, 'laralum.staff.profile', 'Staff', 'View Profile', '2021-09-14 10:37:59', '2021-09-14 10:37:59');
INSERT INTO `permissions` (`id`, `slug`, `module`, `permission`, `created_at`, `updated_at`) VALUES (NULL, 'laralum.leave.staffleave', 'Leave', 'Staff Leave', '2021-09-17 11:40:28', '2021-09-14 11:40:28');
UPDATE `permissions` SET `module` = 'Leave' WHERE `permissions`.`id` = 96; 
UPDATE `permissions` SET `module` = 'Leave' WHERE `permissions`.`id` = 97; 
UPDATE `permissions` SET `module` = 'Leave' WHERE `permissions`.`id` = 98;
UPDATE `permissions` SET `module` = 'Leave' WHERE `permissions`.`id` = 99;  
UPDATE `permissions` SET `module` = 'Leave' WHERE `permissions`.`id` = 100; 
UPDATE `permissions` SET `module` = 'Leave' WHERE `permissions`.`id` = 101; 
UPDATE `permissions` SET `module` = 'Holiday' WHERE `permissions`.`id` = 102; 
UPDATE `permissions` SET `module` = 'Holiday' WHERE `permissions`.`id` = 103; 
UPDATE `permissions` SET `module` = 'Holiday' WHERE `permissions`.`id` = 104; 

UPDATE `permissions` SET `module` = 'Holiday' WHERE `permissions`.`id` = 105; 

UPDATE `permissions` SET `module` = 'Holiday' WHERE `permissions`.`id` = 106; 
UPDATE `permissions` SET `module` = 'Holiday' WHERE `permissions`.`id` = 107; 
UPDATE `permissions` SET `module` = 'Attendance' WHERE `permissions`.`id` = 108; 
UPDATE `permissions` SET `module` = 'Attendance' WHERE `permissions`.`id` = 109; 
UPDATE `permissions` SET `module` = 'Attendance' WHERE `permissions`.`id` = 110; 
UPDATE `permissions` SET `module` = 'Attendance' WHERE `permissions`.`id` = 111; 
UPDATE `permissions` SET `module` = 'Attendance' WHERE `permissions`.`id` = 112; 
UPDATE `permissions` SET `module` = 'Attendance' WHERE `permissions`.`id` = 113; 
INSERT INTO `permissions` (`id`, `slug`, `module`, `permission`, `created_at`, `updated_at`) VALUES (NULL, 'laralum.attendance.staffattendance', 'Attendance', 'Staff Attendance', '2021-09-14 12:27:35', '2021-09-14 12:27:35');
INSERT INTO `permissions` (`id`, `slug`, `module`, `permission`, `created_at`, `updated_at`) VALUES (NULL, 'laralum.department.list', 'Department', 'List', '2021-09-14 18:57:27', '2021-09-14 18:57:27'), (NULL, 'laralum.department.view', 'Department', 'View', '2021-09-14 18:57:27', '2021-09-14 18:57:27'), (NULL, 'laralum.department.create', 'Department', 'Create', '2021-09-14 18:57:27', '2021-09-14 18:57:27'), (NULL, 'laralum.department.edit', 'Department', 'Edit', '2021-09-14 18:57:27', '2021-09-14 18:57:27'), (NULL, 'laralum.department.delete', 'Department', 'Delete', '2021-09-14 18:57:27', '2021-09-14 18:57:27');
INSERT INTO `permissions` (`id`, `slug`, `module`, `permission`, `created_at`, `updated_at`) VALUES (NULL, 'laralum.designation.list', 'Designation', 'List', '2021-09-14 19:04:40', '2021-09-14 19:04:40'), (NULL, 'laralum.designation.view', 'Designation', 'View', '2021-09-14 19:04:40', '2021-09-14 19:04:40'), (NULL, 'laralum.designation.create', 'Designation', 'Create', '2021-09-14 19:04:40', '2021-09-14 19:04:40'), (NULL, 'laralum.designation.edit', 'Designation', 'Edit', '2021-09-14 19:04:40', '2021-09-14 19:04:40'), (NULL, 'laralum.designation.delete', 'Designation', 'Delete', '2021-09-14 19:04:40', '2021-09-14 19:04:40');

ALTER TABLE `user_details` CHANGE `basic_perc` `basic_perc` FLOAT(5,2) NULL DEFAULT '40.00'; 
ALTER TABLE `user_details` CHANGE `hra_perc` `hra_perc` FLOAT(5,2) NULL DEFAULT '40.00'; 
ALTER TABLE `user_details` CHANGE `special_allowance_per` `special_allowance_per` FLOAT(5,2) NULL DEFAULT '20.00'; 

ALTER TABLE `user_details` CHANGE `pf_percentage` `pf_percentage` FLOAT(5,2) NULL DEFAULT '12.00'; 
ALTER TABLE `user_details` CHANGE `esi_percentage` `esi_percentage` FLOAT(5,2) NULL DEFAULT '0.75'; 
ALTER TABLE `user_details` CHANGE `advance_percentage` `advance_percentage` FLOAT(5,2) NULL DEFAULT '0.00'; 
ALTER TABLE `user_details` CHANGE `anual_ctc` `anual_ctc` BIGINT(15) NULL DEFAULT '0'; 


ALTER TABLE `dashboard_widgets` ADD `client_id` INT(11) NULL DEFAULT NULL AFTER `id`; 
ALTER TABLE `payslips` ADD `client_id` INT(11) NULL DEFAULT NULL AFTER `id`; 







