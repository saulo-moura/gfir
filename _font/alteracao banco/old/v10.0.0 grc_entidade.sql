-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.33


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema db_pir_grc
--

CREATE DATABASE IF NOT EXISTS db_pir_grc;
USE db_pir_grc;

--
-- Definition of table `grc_entidade_organizacao`
--

DROP TABLE IF EXISTS `grc_entidade_organizacao`;
CREATE TABLE `grc_entidade_organizacao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_entidade` int(10) unsigned DEFAULT NULL,
  `cnpj` varchar(45) NOT NULL,
  `razao_social` varchar(120) NOT NULL,
  `nome_fantasia` varchar(120) DEFAULT NULL,
  `logradouro_cep_e` varchar(15) DEFAULT NULL,
  `logradouro_endereco_e` varchar(120) DEFAULT NULL,
  `logradouro_numero_e` varchar(45) DEFAULT NULL,
  `logradouro_complemento_e` varchar(120) DEFAULT NULL,
  `logradouro_referencia_e` varchar(120) DEFAULT NULL,
  `logradouro_codbairro_e` int(11) DEFAULT NULL,
  `logradouro_bairro_e` varchar(45) DEFAULT NULL,
  `logradouro_codcid_e` int(11) DEFAULT NULL,
  `logradouro_cidade_e` varchar(45) DEFAULT NULL,
  `logradouro_codest_e` int(11) DEFAULT NULL,
  `logradouro_estado_e` varchar(2) DEFAULT NULL,
  `logradouro_codpais_e` int(11) DEFAULT NULL,
  `logradouro_pais_e` varchar(45) DEFAULT NULL,
  `idt_pais_e` int(10) unsigned DEFAULT NULL,
  `idt_estado_e` int(10) unsigned DEFAULT NULL,
  `idt_cidade_e` int(10) unsigned DEFAULT NULL,
  `telefone_comercial_e` varchar(45) DEFAULT NULL,
  `telefone_celular_e` varchar(45) DEFAULT NULL,
  `email_e` varchar(120) DEFAULT NULL,
  `sms_e` varchar(120) DEFAULT NULL,
  `receber_informacao_e` varchar(1) DEFAULT NULL,
  `codigo_siacweb_e` varchar(45) DEFAULT NULL,
  `idt_organizacao` int(10) unsigned DEFAULT NULL,
  `site_url` varchar(120) DEFAULT NULL,
  `idt_porte` int(10) unsigned DEFAULT NULL,
  `idt_tipo_empreendimento` int(10) unsigned DEFAULT NULL,
  `data_abertura` date DEFAULT NULL,
  `pessoas_ocupadas` int(10) unsigned DEFAULT NULL,
  `idt_setor` int(10) unsigned DEFAULT NULL,
  `idt_cnae_principal` varchar(45) DEFAULT NULL,
  `simples_nacional` varchar(1) DEFAULT NULL,
  `tamanho_propriedade` decimal(15,2) DEFAULT NULL,
  `dap` varchar(45) DEFAULT NULL,
  `nirf` varchar(45) DEFAULT NULL,
  `rmp` varchar(45) DEFAULT NULL,
  `ie_prod_rural` varchar(45) DEFAULT NULL,
  `representa` varchar(1) DEFAULT 'N',
  `desvincular` varchar(1) DEFAULT 'N',
  `codigo_prod_rural` varchar(45) DEFAULT NULL,
  `novo_registro` char(1) NOT NULL DEFAULT 'N',
  `modificado` char(1) NOT NULL DEFAULT 'N',
  `representa_codcargcli` int(10) DEFAULT NULL,
  `idt_representa` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `FK_grc_entidade_organizacao_1` (`idt_entidade`) USING BTREE,
  KEY `FK_grc_entidade_organizacao_2` (`representa_codcargcli`),
  KEY `FK_grc_entidade_organizacao_3` (`idt_representa`),
  CONSTRAINT `FK_grc_entidade_organizacao_3` FOREIGN KEY (`idt_representa`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`),
  CONSTRAINT `FK_grc_entidade_organizacao_1` FOREIGN KEY (`idt_entidade`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`),
  CONSTRAINT `FK_grc_entidade_organizacao_2` FOREIGN KEY (`representa_codcargcli`) REFERENCES `db_pir_siac_ba`.`cargcli` (`codcargcli`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_entidade_organizacao`
--

/*!40000 ALTER TABLE `grc_entidade_organizacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `grc_entidade_organizacao` ENABLE KEYS */;


--
-- Definition of table `grc_entidade_organizacao_cnae`
--

DROP TABLE IF EXISTS `grc_entidade_organizacao_cnae`;
CREATE TABLE `grc_entidade_organizacao_cnae` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_entidade_organizacao` int(10) unsigned NOT NULL,
  `cnae` varchar(45) NOT NULL,
  `principal` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`idt`),
  UNIQUE KEY `un_grc_entidade_organizacao_cnae_2` (`idt_entidade_organizacao`,`cnae`),
  CONSTRAINT `fk_grc_entidade_organizacao_cnae_1` FOREIGN KEY (`idt_entidade_organizacao`) REFERENCES `grc_entidade_organizacao` (`idt`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_entidade_organizacao_cnae`
--

/*!40000 ALTER TABLE `grc_entidade_organizacao_cnae` DISABLE KEYS */;
/*!40000 ALTER TABLE `grc_entidade_organizacao_cnae` ENABLE KEYS */;


--
-- Definition of table `grc_entidade_organizacao_tipo_informacao`
--

DROP TABLE IF EXISTS `grc_entidade_organizacao_tipo_informacao`;
CREATE TABLE `grc_entidade_organizacao_tipo_informacao` (
  `idt` int(10) unsigned NOT NULL,
  `idt_tipo_informacao_e` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`,`idt_tipo_informacao_e`),
  KEY `fk_grc_entidade_organizacao_tipo_informacao_2` (`idt_tipo_informacao_e`),
  CONSTRAINT `fk_grc_entidade_organizacao_tipo_informacao_1` FOREIGN KEY (`idt`) REFERENCES `grc_entidade_organizacao` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `fk_grc_entidade_organizacao_tipo_informacao_2` FOREIGN KEY (`idt_tipo_informacao_e`) REFERENCES `db_pir_gec`.`gec_entidade_tipo_informacao` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_entidade_organizacao_tipo_informacao`
--

/*!40000 ALTER TABLE `grc_entidade_organizacao_tipo_informacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `grc_entidade_organizacao_tipo_informacao` ENABLE KEYS */;


--
-- Definition of table `grc_entidade_pessoa`
--

DROP TABLE IF EXISTS `grc_entidade_pessoa`;
CREATE TABLE `grc_entidade_pessoa` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_entidade` int(10) unsigned DEFAULT NULL,
  `cpf` varchar(14) NOT NULL,
  `nome` varchar(120) DEFAULT NULL,
  `nome_mae` varchar(120) DEFAULT NULL,
  `logradouro_cep` varchar(15) DEFAULT NULL,
  `logradouro_endereco` varchar(120) DEFAULT NULL,
  `logradouro_numero` varchar(45) DEFAULT NULL,
  `logradouro_complemento` varchar(120) DEFAULT NULL,
  `logradouro_referencia` varchar(120) DEFAULT NULL,
  `logradouro_codbairro` int(11) DEFAULT NULL,
  `logradouro_bairro` varchar(45) DEFAULT NULL,
  `logradouro_codcid` int(11) DEFAULT NULL,
  `logradouro_cidade` varchar(45) DEFAULT NULL,
  `logradouro_codest` int(11) DEFAULT NULL,
  `logradouro_estado` varchar(2) DEFAULT NULL,
  `logradouro_codpais` int(11) DEFAULT NULL,
  `logradouro_pais` varchar(45) DEFAULT NULL,
  `idt_pais` int(10) unsigned DEFAULT NULL,
  `idt_estado` int(10) unsigned DEFAULT NULL,
  `idt_cidade` int(10) unsigned DEFAULT NULL,
  `telefone_residencial` varchar(45) DEFAULT NULL,
  `telefone_celular` varchar(45) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `sms` varchar(120) DEFAULT NULL,
  `nome_tratamento` varchar(120) DEFAULT NULL,
  `idt_escolaridade` int(10) unsigned DEFAULT NULL,
  `idt_sexo` int(10) unsigned DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `receber_informacao` varchar(1) DEFAULT NULL,
  `tipo_relacao` varchar(1) NOT NULL DEFAULT 'P',
  `nome_pai` varchar(120) DEFAULT NULL,
  `necessidade_especial` varchar(1) DEFAULT NULL,
  `idt_profissao` int(10) unsigned DEFAULT NULL,
  `idt_estado_civil` int(10) unsigned DEFAULT NULL,
  `idt_cor_pele` int(10) unsigned DEFAULT NULL,
  `idt_religiao` int(10) unsigned DEFAULT NULL,
  `idt_destreza` int(10) unsigned DEFAULT NULL,
  `potencial_personagem` varchar(1) DEFAULT 'N',
  `representa_empresa` varchar(1) DEFAULT 'N',
  `codigo_siacweb` varchar(45) DEFAULT NULL,
  `siacweb_codparticipantecosultoria` int(10) DEFAULT NULL,
  `idt_segmentacao` int(10) unsigned DEFAULT NULL,
  `idt_subsegmentacao` int(10) unsigned DEFAULT NULL,
  `idt_programa_fidelidade` int(10) unsigned DEFAULT NULL,
  `telefone_recado` varchar(45) DEFAULT NULL,
  `idt_pessoa` int(10) unsigned DEFAULT NULL,
  `evento_cortesia` char(1) DEFAULT NULL,
  `evento_alt_siacweb` char(1) DEFAULT NULL,
  `evento_inscrito` char(1) DEFAULT NULL,
  `evento_exc_siacweb` char(1) DEFAULT NULL,
  `evento_concluio` char(1) DEFAULT NULL,
  `falta_sincronizar_siacweb` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`idt`),
  KEY `FK_grc_entidade_pessoa_2` (`idt_segmentacao`),
  KEY `FK_grc_entidade_pessoa_3` (`idt_subsegmentacao`),
  KEY `FK_grc_entidade_pessoa_4` (`idt_programa_fidelidade`),
  KEY `FK_grc_entidade_pessoa_1` (`idt_entidade`),
  CONSTRAINT `FK_grc_entidade_pessoa_1` FOREIGN KEY (`idt_entidade`) REFERENCES `db_pir_gec`.`gec_entidade` (`idt`),
  CONSTRAINT `FK_grc_entidade_pessoa_2` FOREIGN KEY (`idt_segmentacao`) REFERENCES `grc_atendimento_segmentacao` (`idt`),
  CONSTRAINT `FK_grc_entidade_pessoa_3` FOREIGN KEY (`idt_subsegmentacao`) REFERENCES `grc_atendimento_subsegmentacao` (`idt`),
  CONSTRAINT `FK_grc_entidade_pessoa_4` FOREIGN KEY (`idt_programa_fidelidade`) REFERENCES `grc_atendimento_programa_fidelidade` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_entidade_pessoa`
--

/*!40000 ALTER TABLE `grc_entidade_pessoa` DISABLE KEYS */;
/*!40000 ALTER TABLE `grc_entidade_pessoa` ENABLE KEYS */;


--
-- Definition of table `grc_entidade_pessoa_arquivo_interesse`
--

DROP TABLE IF EXISTS `grc_entidade_pessoa_arquivo_interesse`;
CREATE TABLE `grc_entidade_pessoa_arquivo_interesse` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_entidade_pessoa` int(10) unsigned NOT NULL,
  `idt_responsavel` int(11) NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `titulo` varchar(255) NOT NULL,
  `arquivo` varchar(255) NOT NULL,
  PRIMARY KEY (`idt`),
  KEY `FK_grc_entidade_pessoa_arquivo_interesse_2` (`idt_responsavel`) USING BTREE,
  KEY `iu_grc_entidade_pessoa_arquivo_interesse` (`idt_entidade_pessoa`,`data_registro`) USING BTREE,
  CONSTRAINT `FK_grc_entidade_pessoa_arquivo_interesse_1` FOREIGN KEY (`idt_entidade_pessoa`) REFERENCES `grc_entidade_pessoa` (`idt`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_entidade_pessoa_arquivo_interesse_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 482304 kB; (`idt_entidade`) REFER `db_pir_gr';

--
-- Dumping data for table `grc_entidade_pessoa_arquivo_interesse`
--

/*!40000 ALTER TABLE `grc_entidade_pessoa_arquivo_interesse` DISABLE KEYS */;
/*!40000 ALTER TABLE `grc_entidade_pessoa_arquivo_interesse` ENABLE KEYS */;


--
-- Definition of table `grc_entidade_pessoa_produto_interesse`
--

DROP TABLE IF EXISTS `grc_entidade_pessoa_produto_interesse`;
CREATE TABLE `grc_entidade_pessoa_produto_interesse` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_entidade_pessoa` int(10) unsigned NOT NULL,
  `idt_produto` int(10) unsigned NOT NULL,
  `observacao` varchar(255) DEFAULT NULL,
  `data_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idt_responsavel` int(11) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_entidade_pessoa_produto_interesse` (`idt_entidade_pessoa`,`idt_produto`) USING BTREE,
  KEY `FK_grc_entidade_pessoa_produto_interesse_2` (`idt_responsavel`) USING BTREE,
  KEY `FK_grc_entidade_pessoa_produto_interesse_3` (`idt_produto`) USING BTREE,
  CONSTRAINT `FK_grc_entidade_pessoa_produto_interesse_1` FOREIGN KEY (`idt_entidade_pessoa`) REFERENCES `grc_entidade_pessoa` (`idt`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_entidade_pessoa_produto_interesse_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_entidade_pessoa_produto_interesse_3` FOREIGN KEY (`idt_produto`) REFERENCES `grc_produto` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_entidade_pessoa_produto_interesse`
--

/*!40000 ALTER TABLE `grc_entidade_pessoa_produto_interesse` DISABLE KEYS */;
/*!40000 ALTER TABLE `grc_entidade_pessoa_produto_interesse` ENABLE KEYS */;


--
-- Definition of table `grc_entidade_pessoa_tema_interesse`
--

DROP TABLE IF EXISTS `grc_entidade_pessoa_tema_interesse`;
CREATE TABLE `grc_entidade_pessoa_tema_interesse` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idt_entidade_pessoa` int(10) unsigned NOT NULL,
  `idt_tema` int(10) unsigned NOT NULL,
  `idt_subtema` int(10) unsigned DEFAULT NULL,
  `observacao` varchar(255) DEFAULT NULL,
  `idt_responsavel` int(11) NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_entidade_tema_interesse` (`idt_entidade_pessoa`,`idt_tema`) USING BTREE,
  KEY `FK_grc_entidade_tema_interesse_2` (`idt_responsavel`),
  KEY `FK_grc_entidade_pessoa_tema_interesse_3` (`idt_tema`),
  CONSTRAINT `FK_grc_entidade_pessoa_tema_interesse_1` FOREIGN KEY (`idt_entidade_pessoa`) REFERENCES `grc_entidade_pessoa` (`idt`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_entidade_pessoa_tema_interesse_2` FOREIGN KEY (`idt_responsavel`) REFERENCES `plu_usuario` (`id_usuario`) ON UPDATE CASCADE,
  CONSTRAINT `FK_grc_entidade_pessoa_tema_interesse_3` FOREIGN KEY (`idt_tema`) REFERENCES `grc_tema_subtema` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_entidade_pessoa_tema_interesse`
--

/*!40000 ALTER TABLE `grc_entidade_pessoa_tema_interesse` DISABLE KEYS */;
/*!40000 ALTER TABLE `grc_entidade_pessoa_tema_interesse` ENABLE KEYS */;


--
-- Definition of table `grc_entidade_pessoa_tipo_deficiencia`
--

DROP TABLE IF EXISTS `grc_entidade_pessoa_tipo_deficiencia`;
CREATE TABLE `grc_entidade_pessoa_tipo_deficiencia` (
  `idt` int(10) unsigned NOT NULL,
  `idt_tipo_deficiencia` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`,`idt_tipo_deficiencia`),
  KEY `fk_grc_entidade_pessoa_tipo_deficiencia_2` (`idt_tipo_deficiencia`),
  CONSTRAINT `fk_grc_entidade_pessoa_tipo_deficiencia_1` FOREIGN KEY (`idt`) REFERENCES `grc_entidade_pessoa` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `fk_grc_entidade_pessoa_tipo_deficiencia_2` FOREIGN KEY (`idt_tipo_deficiencia`) REFERENCES `db_pir_gec`.`gec_entidade_tipo_deficiencia` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_entidade_pessoa_tipo_deficiencia`
--

/*!40000 ALTER TABLE `grc_entidade_pessoa_tipo_deficiencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `grc_entidade_pessoa_tipo_deficiencia` ENABLE KEYS */;


--
-- Definition of table `grc_entidade_pessoa_tipo_informacao`
--

DROP TABLE IF EXISTS `grc_entidade_pessoa_tipo_informacao`;
CREATE TABLE `grc_entidade_pessoa_tipo_informacao` (
  `idt` int(10) unsigned NOT NULL,
  `idt_tipo_informacao` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`,`idt_tipo_informacao`),
  KEY `fk_grc_entidade_pessoa_tipo_informacao_2` (`idt_tipo_informacao`),
  CONSTRAINT `fk_grc_entidade_pessoa_tipo_informacao_1` FOREIGN KEY (`idt`) REFERENCES `grc_entidade_pessoa` (`idt`) ON DELETE CASCADE,
  CONSTRAINT `fk_grc_entidade_pessoa_tipo_informacao_2` FOREIGN KEY (`idt_tipo_informacao`) REFERENCES `db_pir_gec`.`gec_entidade_tipo_informacao` (`idt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_entidade_pessoa_tipo_informacao`
--

/*!40000 ALTER TABLE `grc_entidade_pessoa_tipo_informacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `grc_entidade_pessoa_tipo_informacao` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
