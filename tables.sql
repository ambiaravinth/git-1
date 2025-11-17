CREATE TABLE `cb_magento_logs` (
    `reg_id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `testgroupcode` TEXT NULL,
    `lab_id` VARCHAR(100) NULL,
    `attachment` LONGTEXT NULL,
    `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    `response` LONGTEXT NULL,
    `status` VARCHAR(50) NULL,
    `lims_testgroupcode` LONGTEXT NULL,
    `system_type` VARCHAR(25) NULL DEFAULT 'magento',
    `report_type` VARCHAR(25) NULL,
    PRIMARY KEY (`reg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `cb_stemcell_logs` (
    `reg_id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `testgroupcode` TEXT NULL,
    `lab_id` VARCHAR(100) NULL,
    `attachment` LONGTEXT,
    `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    `response` LONGTEXT NULL,
    `status` VARCHAR(50) NULL,
    `lims_testgroupcode` LONGTEXT NULL,
    `system_type` VARCHAR(25) NULL DEFAULT 'stemcell',
    `report_type` VARCHAR(25) NULL,
    PRIMARY KEY (`reg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `wellness_lims_logs` (
    `reg_id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `testgroupcode` TEXT NULL,
    `lab_id` VARCHAR(100) NULL,
    `attachment` LONGTEXT NULL,
    `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    `response` LONGTEXT NULL,
    `status` VARCHAR(50) NULL,
    `lims_testgroupcode` LONGTEXT NULL,
    `system_type` VARCHAR(25) NULL DEFAULT 'lims',
    `report_type` VARCHAR(25) NULL,
    PRIMARY KEY (`reg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `wellness_magento_logs` (
    `reg_id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `testgroupcode` TEXT NULL,
    `lab_id` VARCHAR(100) NULL,
    `attachment` LONGTEXT NULL,
    `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    `response` LONGTEXT NULL,
    `status` VARCHAR(50) NULL,
    `lims_testgroupcode` LONGTEXT NULL,
    `system_type` VARCHAR(25) NULL DEFAULT 'magento',
    `report_type` VARCHAR(25) NULL,
    PRIMARY KEY (`reg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
