SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `ci_sessions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baka_ci_sessions` ;

CREATE  TABLE IF NOT EXISTS `baka_ci_sessions` (
  `session_id` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL DEFAULT 0 ,
  `ip_address` VARCHAR(16) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL DEFAULT 0 ,
  `user_agent` VARCHAR(150) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `last_activity` INT UNSIGNED NOT NULL DEFAULT 0 ,
  `user_data` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  PRIMARY KEY (`session_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `login_attempts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baka_auth_login_attempts` ;

CREATE  TABLE IF NOT EXISTS `baka_auth_login_attempts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `ip_address` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `login` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `time` TIMESTAMP NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `user_autologin`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baka_auth_user_autologin` ;

CREATE  TABLE IF NOT EXISTS `baka_auth_user_autologin` (
  `key_id` CHAR(32) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `user_id` INT UNSIGNED NOT NULL DEFAULT 0 ,
  `user_agent` VARCHAR(150) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `last_ip` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `last_login` TIMESTAMP NOT NULL ,
  PRIMARY KEY (`key_id`, `user_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `user_profiles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baka_auth_user_profiles` ;

CREATE  TABLE IF NOT EXISTS `baka_auth_user_profiles` (
  `id` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(255) NULL DEFAULT '' ,
  `gender` CHAR(1) NULL DEFAULT '' ,
  `dob` DATE NULL DEFAULT '' ,
  `country` CHAR(2) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NULL DEFAULT '' ,
  `timezone` VARCHAR(50) NULL DEFAULT '' ,
  `website` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NULL DEFAULT '' ,
  `modified` TIMESTAMP NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baka_auth_users` ;

CREATE  TABLE IF NOT EXISTS `baka_auth_users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `password` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `email` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `activated` TINYINT(1) NOT NULL DEFAULT 1 ,
  `banned` TINYINT(1) NOT NULL DEFAULT 0 ,
  `ban_reason` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NULL ,
  `new_password_key` CHAR(32) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NULL ,
  `new_password_requested` DATETIME NULL ,
  `new_email` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NULL ,
  `new_email_key` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NULL ,
  `approved` TINYINT(1) NULL COMMENT 'For acct approval.' ,
  `meta` VARCHAR(2000) NULL DEFAULT '' ,
  `last_ip` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
  `last_login` DATETIME NOT NULL ,
  `created` DATETIME NOT NULL ,
  `modified` TIMESTAMP NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `permissions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baka_auth_permissions` ;

CREATE  TABLE IF NOT EXISTS `baka_auth_permissions` (
  `permission_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `permission` VARCHAR(100) NOT NULL ,
  `description` VARCHAR(160) NULL ,
  `parent` VARCHAR(100) NULL ,
  `sort` TINYINT UNSIGNED NULL ,
  PRIMARY KEY (`permission_id`) ,
  UNIQUE INDEX `permission_UNIQUE` (`permission` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baka_auth_roles` ;

CREATE  TABLE IF NOT EXISTS `baka_auth_roles` (
  `role_id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `role` VARCHAR(50) NOT NULL ,
  `full` VARCHAR(50) NOT NULL ,
  `default` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`role_id`) ,
  UNIQUE INDEX `role_UNIQUE` (`role` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `role_permissions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baka_auth_role_permissions` ;

CREATE  TABLE IF NOT EXISTS `baka_auth_role_permissions` (
  `role_id` TINYINT UNSIGNED NOT NULL ,
  `permission_id` SMALLINT UNSIGNED NOT NULL ,
  PRIMARY KEY (`role_id`, `permission_id`) ,
  INDEX `role_id2_idx` (`role_id` ASC) ,
  INDEX `permission_id2_idx` (`permission_id` ASC) ,
  CONSTRAINT `role_id2`
    FOREIGN KEY (`role_id` )
    REFERENCES `baka_auth_roles` (`role_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `permission_id2`
    FOREIGN KEY (`permission_id` )
    REFERENCES `baka_auth_permissions` (`permission_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `user_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baka_auth_user_roles` ;

CREATE  TABLE IF NOT EXISTS `baka_auth_user_roles` (
  `user_id` INT UNSIGNED NOT NULL ,
  `role_id` TINYINT UNSIGNED NOT NULL ,
  PRIMARY KEY (`user_id`, `role_id`) ,
  INDEX `user_id2_idx` (`user_id` ASC) ,
  INDEX `role_id1_idx` (`role_id` ASC) ,
  CONSTRAINT `user_id2`
    FOREIGN KEY (`user_id` )
    REFERENCES `baka_auth_users` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `role_id1`
    FOREIGN KEY (`role_id` )
    REFERENCES `baka_auth_roles` (`role_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `overrides`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `baka_auth_overrides` ;

CREATE  TABLE IF NOT EXISTS `baka_auth_overrides` (
  `user_id` INT UNSIGNED NOT NULL ,
  `permission_id` SMALLINT UNSIGNED NOT NULL ,
  `allow` TINYINT(1) UNSIGNED NOT NULL ,
  PRIMARY KEY (`user_id`, `permission_id`) ,
  INDEX `user_id1_idx` (`user_id` ASC) ,
  INDEX `permissions_id1_idx` (`permission_id` ASC) ,
  CONSTRAINT `user_id1`
    FOREIGN KEY (`user_id` )
    REFERENCES `baka_auth_users` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `permission_id1`
    FOREIGN KEY (`permission_id` )
    REFERENCES `baka_auth_permissions` (`permission_id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `roles`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `baka_auth_roles` (`role_id`, `role`, `full`, `default`) VALUES (1, 'admin', 'Administrator', 0);
INSERT INTO `baka_auth_roles` (`role_id`, `role`, `full`, `default`) VALUES (2, 'user', 'User', 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `permissions`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `baka_auth_permissions` (`permission_id`, `permission`, `description`, `parent`, `sort`) VALUES (1, 'open page', 'Open this page', 'Pages you can open', NULL);
INSERT INTO `baka_auth_permissions` (`permission_id`, `permission`, `description`, `parent`, `sort`) VALUES (2, 'open user page', 'Only users can open this', 'User domain', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `role_permissions`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `baka_auth_role_permissions` (`role_id`, `permission_id`) VALUES (1, 1);
INSERT INTO `baka_auth_role_permissions` (`role_id`, `permission_id`) VALUES (2, 2);

COMMIT;

