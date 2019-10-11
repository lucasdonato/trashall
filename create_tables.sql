-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_trashall
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_trashall
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_trashall` DEFAULT CHARACTER SET utf8 ;
USE `db_trashall` ;

-- -----------------------------------------------------
-- Table `db_trashall`.`login`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_trashall`.`login` (
  `usuario` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(45),
  `tipo_entidade` VARCHAR(45),
  `ativo` VARCHAR(45) NOT NULL DEFAULT '1',
  PRIMARY KEY (`usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_trashall`.`condominio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_trashall`.`condominio` (
  `id_condominio` INT(100) NULL AUTO_INCREMENT,
  `nome_condominio` VARCHAR(200) NULL DEFAULT NULL,
  `data_cadastro` DATETIME NULL DEFAULT NULL,
  `login_usuario` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_condominio`),
  CONSTRAINT `fk_condominio_login1`
    FOREIGN KEY (`login_usuario`)
    REFERENCES `db_trashall`.`login` (`usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_trashall`.`coletor_empresa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_trashall`.`coletor_empresa` (
  `id_coletor` INT(100) NULL AUTO_INCREMENT,
  `nome_empresa` VARCHAR(100) NULL DEFAULT NULL,
  `data_cadastro` DATETIME NULL DEFAULT NULL,
  `login_usuario` VARCHAR(100) NULL DEFAULT NULL,
  `materiais_coletados` VARCHAR(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_coletor`),
  CONSTRAINT `fk_coletor_empresa_login1`
    FOREIGN KEY (`login_usuario`)
    REFERENCES `db_trashall`.`login` (`usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_trashall`.`endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_trashall`.`endereco` (
  `id_endereco` INT(100) NOT NULL AUTO_INCREMENT,
  `logradouro` VARCHAR(100) NULL DEFAULT NULL,
  `bairro` VARCHAR(45) NULL DEFAULT NULL,
  `cidade` VARCHAR(45) NULL DEFAULT NULL,
  `estado` VARCHAR(45) NULL DEFAULT NULL,
  `numero` INT NULL DEFAULT NULL,
  `cep` VARCHAR(45) NULL DEFAULT NULL,
  `id_condominio` INT(100) NULL DEFAULT NULL,
  `id_coletor` INT(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_endereco`),
  CONSTRAINT `fk_endereco_condominio1`
    FOREIGN KEY (`id_condominio`)
    REFERENCES `db_trashall`.`condominio` (`id_condominio`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_endereco_coletor_empresa1`
    FOREIGN KEY (`id_coletor`)
    REFERENCES `db_trashall`.`coletor_empresa` (`id_coletor`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_trashall`.`contato`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_trashall`.`contato` (
  `id_contato` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NULL DEFAULT NULL,
  `descricao` VARCHAR(45) NULL DEFAULT NULL,
  `id_condominio` INT(100) NULL DEFAULT NULL,
  `id_coletor` INT(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_contato`),
  CONSTRAINT `fk_contato_condominio`
    FOREIGN KEY (`id_condominio`)
    REFERENCES `db_trashall`.`condominio` (`id_condominio`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_contato_coletor_empresa1`
    FOREIGN KEY (`id_coletor`)
    REFERENCES `db_trashall`.`coletor_empresa` (`id_coletor`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_trashall`.`coleta_andamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_trashall`.`coleta_andamento` (
  `id_coleta` INT NOT NULL AUTO_INCREMENT,
  `status` VARCHAR(45) NULL DEFAULT NULL,
  `data_coleta` DATETIME NULL DEFAULT NULL,
  `endereco_destino` INT NULL DEFAULT NULL,
  `id_coletor` INT(100) NULL DEFAULT NULL,
  `id_condominio` INT(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id_coleta`),
  CONSTRAINT `fk_coleta_andamento_coletor_empresa1`
    FOREIGN KEY (`id_coletor`)
    REFERENCES `db_trashall`.`coletor_empresa` (`id_coletor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_coleta_andamento_condominio1`
    FOREIGN KEY (`id_condominio`)
    REFERENCES `db_trashall`.`condominio` (`id_condominio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_trashall`.`feedback`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_trashall`.`feedback` (
  `id` INT(100) NOT NULL,
  `email_entidade` VARCHAR(45) NULL DEFAULT NULL,
  `conteudo` VARCHAR(500) NULL DEFAULT NULL,
  `id_coletor` INT(100) NULL DEFAULT NULL,
  `id_condominio` INT(100) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_feedback_coletor_empresa1`
    FOREIGN KEY (`id_coletor`)
    REFERENCES `db_trashall`.`coletor_empresa` (`id_coletor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_feedback_condominio1`
    FOREIGN KEY (`id_condominio`)
    REFERENCES `db_trashall`.`condominio` (`id_condominio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
