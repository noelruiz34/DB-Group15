-- MySQL Script generated by MySQL Workbench
-- Thu Apr  1 10:05:47 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Point_of_Sale
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Point_of_Sale
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Point_of_Sale` DEFAULT CHARACTER SET utf8 ;
USE `Point_of_Sale` ;

-- -----------------------------------------------------
-- Table `Point_of_Sale`.`employee`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Point_of_Sale`.`employee` (
  `employee_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `password` VARCHAR(50) NOT NULL,
  `ssn` INT(10) UNSIGNED NOT NULL,
  `f_name` VARCHAR(32) NOT NULL,
  `l_name` VARCHAR(32) NOT NULL,
  `salary` INT(10) UNSIGNED NOT NULL,
  `gender` VARCHAR(1) NOT NULL,
  `dob` DATE NOT NULL,
  PRIMARY KEY (`employee_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Point_of_Sale`.`customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Point_of_Sale`.`customer` (
  `customer_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(50) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `f_name` VARCHAR(32) NULL,
  `l_name` VARCHAR(32) NULL,
  `phone_number` INT(10) NULL,
  PRIMARY KEY (`customer_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Point_of_Sale`.`order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Point_of_Sale`.`order` (
  `o_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` INT(12) UNSIGNED NOT NULL,
  `o_time` DATETIME NOT NULL,
  `o_status` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`o_id`),
  INDEX `customer_id_idx` (`customer_id` ASC),
  CONSTRAINT `customer_id`
    FOREIGN KEY (`customer_id`)
    REFERENCES `Point_of_Sale`.`customer` (`customer_id`)
    ON DELETE NO ACTION
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Point_of_Sale`.`product_category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Point_of_Sale`.`product_category` (
  `category_id` INT NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`category_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Point_of_Sale`.`product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Point_of_Sale`.`product` (
  `upc` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `p_name` VARCHAR(64) NOT NULL,
  `p_quantity` INT(8) NOT NULL,
  `p_price` FLOAT(8) NOT NULL,
  `p_category` INT NOT NULL,
  `p_discount` INT(3) ZEROFILL NOT NULL,
  `p_status` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`upc`),
  INDEX `product_category_idx` (`p_category` ASC),
  CONSTRAINT `product_category`
    FOREIGN KEY (`p_category`)
    REFERENCES `Point_of_Sale`.`product_category` (`category_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Point_of_Sale`.`shopping_cart`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Point_of_Sale`.`shopping_cart` (
  `customer_id` INT(12) UNSIGNED NOT NULL,
  `upc` INT(12) UNSIGNED NOT NULL,
  `cart_quantity` VARCHAR(45) NULL,
  PRIMARY KEY (`customer_id`, `upc`),
  INDEX `upc_idx` (`upc` ASC),
  CONSTRAINT `cart_customer_id`
    FOREIGN KEY (`customer_id`)
    REFERENCES `Point_of_Sale`.`customer` (`customer_id`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
  CONSTRAINT `cart_upc`
    FOREIGN KEY (`upc`)
    REFERENCES `Point_of_Sale`.`product` (`upc`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Point_of_Sale`.`shipping_address`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Point_of_Sale`.`shipping_address` (
  `customer_id` INT(12) UNSIGNED NOT NULL,
  `street` VARCHAR(25) NOT NULL,
  `city` VARCHAR(25) NOT NULL,
  `zip` INT(8) UNSIGNED NOT NULL,
  `state` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`customer_id`),
  CONSTRAINT `address_customer_id`
    FOREIGN KEY (`customer_id`)
    REFERENCES `Point_of_Sale`.`customer` (`customer_id`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Point_of_Sale`.`billing_info`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Point_of_Sale`.`billing_info` (
  `customer_id` INT(12) UNSIGNED NOT NULL,
  `cc_num` INT(16) UNSIGNED NOT NULL,
  `cvv` INT(3) UNSIGNED NOT NULL,
  `exp_date` DATE NOT NULL,
  PRIMARY KEY (`customer_id`),
  CONSTRAINT `billing_customer_id`
    FOREIGN KEY (`customer_id`)
    REFERENCES `Point_of_Sale`.`customer` (`customer_id`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Point_of_Sale`.`product_purchase`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Point_of_Sale`.`product_purchase` (
  `upc` INT(12) UNSIGNED NOT NULL,
  `o_id` INT(12) UNSIGNED NOT NULL,
  `quantity_ordered` INT(8) NOT NULL,
  `p_price` FLOAT(8) NOT NULL,
  PRIMARY KEY (`upc`, `o_id`),
  INDEX `o_id_idx` (`o_id` ASC),
  CONSTRAINT `upc`
    FOREIGN KEY (`upc`)
    REFERENCES `Point_of_Sale`.`product` (`upc`)
    ON DELETE NO ACTION
    ON UPDATE RESTRICT,
  CONSTRAINT `o_id`
    FOREIGN KEY (`o_id`)
    REFERENCES `Point_of_Sale`.`order` (`o_id`)
    ON DELETE NO ACTION
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Point_of_Sale`.`billing_address`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Point_of_Sale`.`billing_address` (
  `customer_id` INT(12) UNSIGNED NOT NULL,
  `street` VARCHAR(25) NOT NULL,
  `city` VARCHAR(25) NOT NULL,
  `zip` INT(8) UNSIGNED NOT NULL,
  `state` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`customer_id`),
  CONSTRAINT `billing_address_customer_id`
    FOREIGN KEY (`customer_id`)
    REFERENCES `Point_of_Sale`.`customer` (`customer_id`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Point_of_Sale`.`product_update`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Point_of_Sale`.`product_update` (
  `update_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` INT(12) UNSIGNED NOT NULL,
  `upc` INT(12) UNSIGNED NOT NULL,
  `update_time` DATETIME NOT NULL,
  `update_desc` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`update_id`),
  INDEX `employee_id_idx` (`employee_id` ASC),
  INDEX `upc_idx` (`upc` ASC),
  CONSTRAINT `product_update_employee_id`
    FOREIGN KEY (`employee_id`)
    REFERENCES `Point_of_Sale`.`employee` (`employee_id`)
    ON DELETE NO ACTION
    ON UPDATE RESTRICT,
  CONSTRAINT `product_update_upc`
    FOREIGN KEY (`upc`)
    REFERENCES `Point_of_Sale`.`product` (`upc`)
    ON DELETE NO ACTION
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Point_of_Sale`.`support_ticket`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Point_of_Sale`.`support_ticket` (
  `t_id` INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `o_id` INT(12) UNSIGNED NOT NULL,
  `c_id` INT(12) UNSIGNED NOT NULL,
  `t_time` DATETIME NOT NULL,
  `t_category` VARCHAR(32) NOT NULL,
  `t_status` VARCHAR(16) NOT NULL,
  `t_desc` VARCHAR(750) NOT NULL,
  PRIMARY KEY (`t_id`),
  INDEX `o_id_idx` (`o_id` ASC),
  INDEX `customer_id_idx` (`c_id` ASC),
  CONSTRAINT `support_o_id`
    FOREIGN KEY (`o_id`)
    REFERENCES `Point_of_Sale`.`order` (`o_id`)
    ON DELETE NO ACTION
    ON UPDATE RESTRICT,
  CONSTRAINT `support_c_id`
    FOREIGN KEY (`c_id`)
    REFERENCES `Point_of_Sale`.`customer` (`customer_id`)
    ON DELETE NO ACTION
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


