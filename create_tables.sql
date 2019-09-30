-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`login`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`login` (
  `usuario` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(45),
  `tipo_entidade` VARCHAR(45) NULL,
  `observacoes` VARCHAR(45) NULL,
  PRIMARY KEY (`usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`condominio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`condominio` (
  `id_condominio` INT(100) NULL AUTO_INCREMENT,
  `nome_condominio` VARCHAR(200) NULL,
  `data_cadastro` DATETIME NULL,
  `login_usuario` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_condominio`),
  CONSTRAINT `fk_condominio_login1`
    FOREIGN KEY (`login_usuario`)
    REFERENCES `mydb`.`login` (`usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`coletor_empresa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`coletor_empresa` (
  `id_coletor` INT(100) NULL AUTO_INCREMENT,
  `nome_empresa` VARCHAR(100) NULL,
  `data_cadastro` DATETIME NULL,
  `login_usuario` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_coletor`),
  CONSTRAINT `fk_coletor_empresa_login1`
    FOREIGN KEY (`login_usuario`)
    REFERENCES `mydb`.`login` (`usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`endereco` (
  `id_endereco` INT(100) NOT NULL AUTO_INCREMENT,
  `logradouro` VARCHAR(100) NULL,
  `bairro` VARCHAR(45) NULL,
  `cidade` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NULL,
  `numero` INT NULL,
  `cep` VARCHAR(45) NULL,
  `id_condominio` INT(100) NULL,
  `id_coletor` INT(100) NULL,
  PRIMARY KEY (`id_endereco`),
  CONSTRAINT `fk_endereco_condominio1`
    FOREIGN KEY (`id_condominio`)
    REFERENCES `mydb`.`condominio` (`id_condominio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_endereco_coletor_empresa1`
    FOREIGN KEY (`id_coletor`)
    REFERENCES `mydb`.`coletor_empresa` (`id_coletor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`contato`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`contato` (
  `id_contato` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NULL,
  `descricao` VARCHAR(45) NULL,
  `id_condominio` INT(100) NULL,
  `id_coletor` INT(100) NULL,
  PRIMARY KEY (`id_contato`),
  CONSTRAINT `fk_contato_condominio`
    FOREIGN KEY (`id_condominio`)
    REFERENCES `mydb`.`condominio` (`id_condominio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contato_coletor_empresa1`
    FOREIGN KEY (`id_coletor`)
    REFERENCES `mydb`.`coletor_empresa` (`id_coletor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`coleta_andamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`coleta_andamento` (
  `id_coleta` INT NOT NULL AUTO_INCREMENT,
  `status` VARCHAR(45) NULL,
  `data_coleta` DATETIME NULL,
  `endereco_destino` INT NULL,
  `id_coletor` INT(100) NOT NULL,
  `id_condominio` INT(100) NOT NULL,
  PRIMARY KEY (`id_coleta`),
  CONSTRAINT `fk_coleta_andamento_coletor_empresa1`
    FOREIGN KEY (`id_coletor`)
    REFERENCES `mydb`.`coletor_empresa` (`id_coletor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_coleta_andamento_condominio1`
    FOREIGN KEY (`id_condominio`)
    REFERENCES `mydb`.`condominio` (`id_condominio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`materiais`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`materiais` (
  `id_materiais` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(100) NULL,
  `id_empresa` INT NULL,
  `id_coletor` INT(100) NOT NULL,
  `imagem` VARCHAR(200) NULL,
  PRIMARY KEY (`id_materiais`),
  CONSTRAINT `fk_materiais_coletor_empresa1`
    FOREIGN KEY (`id_coletor`)
    REFERENCES `mydb`.`coletor_empresa` (`id_coletor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`feedback`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`feedback` (
  `id` INT(100) NOT NULL,
  `email_entidade` VARCHAR(45) NULL,
  `conteudo` VARCHAR(500) NULL,
  `id_coletor` INT(100) NULL,
  `id_condominio` INT(100) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_feedback_coletor_empresa1`
    FOREIGN KEY (`id_coletor`)
    REFERENCES `mydb`.`coletor_empresa` (`id_coletor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_feedback_condominio1`
    FOREIGN KEY (`id_condominio`)
    REFERENCES `mydb`.`condominio` (`id_condominio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
