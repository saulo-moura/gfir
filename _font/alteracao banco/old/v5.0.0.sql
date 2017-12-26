-- linux

-- 12/02/2016

ALTER TABLE grc_atendimento_pessoa
ADD COLUMN evento_concluio  char(1) NULL AFTER evento_exc_siacweb;

-- 15/02/2016

ALTER TABLE db_pir.plu_log_sistema
MODIFY COLUMN login  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Login do Usuário ativo' AFTER id_log_sistema,
MODIFY COLUMN nom_usuario  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Nome do usuário ativo' AFTER login;

ALTER TABLE db_pir_bia.plu_log_sistema
MODIFY COLUMN login  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Login do Usuário ativo' AFTER id_log_sistema,
MODIFY COLUMN nom_usuario  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Nome do usuário ativo' AFTER login;

ALTER TABLE db_pir_gec.plu_log_sistema
MODIFY COLUMN login  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Login do Usuário ativo' AFTER id_log_sistema,
MODIFY COLUMN nom_usuario  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Nome do usuário ativo' AFTER login;

ALTER TABLE plu_log_sistema
MODIFY COLUMN login  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Login do Usuário ativo' AFTER id_log_sistema,
MODIFY COLUMN nom_usuario  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Nome do usuário ativo' AFTER login;

ALTER TABLE db_sebrae_pfo.plu_log_sistema
MODIFY COLUMN login  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Login do Usuário ativo' AFTER id_log_sistema,
MODIFY COLUMN nom_usuario  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Nome do usuário ativo' AFTER login;

ALTER TABLE db_pir_pa.plu_log_sistema
MODIFY COLUMN login  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Login do Usuário ativo' AFTER id_log_sistema,
MODIFY COLUMN nom_usuario  varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'Nome do usuário ativo' AFTER login;

-- 16/02/2015

ALTER TABLE grc_evento_natureza_pagamento
ADD COLUMN rm_idformapagto  int(10) NOT NULL AFTER ativo;

UPDATE grc_evento_natureza_pagamento SET rm_idformapagto='1' WHERE (idt='1');
UPDATE grc_evento_natureza_pagamento SET rm_idformapagto='3' WHERE (idt='2');
UPDATE grc_evento_natureza_pagamento SET rm_idformapagto='11' WHERE (idt='3');
UPDATE grc_evento_natureza_pagamento SET rm_idformapagto='4' WHERE (idt='5');
UPDATE grc_evento_natureza_pagamento SET rm_idformapagto='12' WHERE (idt='6');
UPDATE grc_evento_natureza_pagamento SET rm_idformapagto='7' WHERE (idt='7');

ALTER TABLE grc_evento_forma_parcelamento
ADD COLUMN rm_codcfg  int(10) NOT NULL AFTER valor_ini;

UPDATE grc_evento_forma_parcelamento SET rm_codcfg='27' WHERE (idt='6');
UPDATE grc_evento_forma_parcelamento SET rm_codcfg='27' WHERE (idt='4');
UPDATE grc_evento_forma_parcelamento SET rm_codcfg='27' WHERE (idt='5');
UPDATE grc_evento_forma_parcelamento SET rm_codcfg='27' WHERE (idt='7');
UPDATE grc_evento_forma_parcelamento SET rm_codcfg='28' WHERE (idt='1');
UPDATE grc_evento_forma_parcelamento SET rm_codcfg='29' WHERE (idt='2');
UPDATE grc_evento_forma_parcelamento SET rm_codcfg='30' WHERE (idt='10');
UPDATE grc_evento_forma_parcelamento SET rm_codcfg='31' WHERE (idt='11');
UPDATE grc_evento_forma_parcelamento SET rm_codcfg='32' WHERE (idt='12');
UPDATE grc_evento_forma_parcelamento SET rm_codcfg='33' WHERE (idt='13');
UPDATE grc_evento_forma_parcelamento SET rm_codcfg='34' WHERE (idt='14');
UPDATE grc_evento_forma_parcelamento SET rm_codcfg='35' WHERE (idt='15');
UPDATE grc_evento_forma_parcelamento SET rm_codcfg='36' WHERE (idt='16');
UPDATE grc_evento_forma_parcelamento SET rm_codcfg='37' WHERE (idt='17');
UPDATE grc_evento_forma_parcelamento SET rm_codcfg='27' WHERE (idt='8');

ALTER TABLE grc_evento_cartao_bandeira
ADD COLUMN lojasiac_codbandeira  int(10) NULL AFTER ativo;

UPDATE grc_evento_cartao_bandeira SET lojasiac_codbandeira='0' WHERE (idt='1');
UPDATE grc_evento_cartao_bandeira SET lojasiac_codbandeira='1' WHERE (idt='2');
UPDATE grc_evento_cartao_bandeira SET lojasiac_codbandeira='2' WHERE (idt='3');
UPDATE grc_evento_cartao_bandeira SET lojasiac_codbandeira='4' WHERE (idt='4');
UPDATE grc_evento_cartao_bandeira SET lojasiac_codbandeira='3' WHERE (idt='5');
UPDATE grc_evento_cartao_bandeira SET lojasiac_codbandeira='5' WHERE (idt='6');
UPDATE grc_evento_cartao_bandeira SET lojasiac_codbandeira='6' WHERE (idt='7');
UPDATE grc_evento_cartao_bandeira SET lojasiac_codbandeira='7' WHERE (idt='8');

ALTER TABLE grc_evento_natureza_pagamento
ADD COLUMN lojasiac_modalidade  int(10) NULL AFTER rm_idformapagto;

UPDATE grc_evento_natureza_pagamento SET lojasiac_modalidade='0' WHERE (idt='2');
UPDATE grc_evento_natureza_pagamento SET lojasiac_modalidade='3' WHERE (idt='6');

CREATE TABLE grc_evento_situacao_pagamento (
  idt int(10) unsigned NOT NULL AUTO_INCREMENT,
  codigo varchar(45) NOT NULL,
  descricao varchar(120) NOT NULL,
  ativo varchar(1) NOT NULL DEFAULT 'S',
  lojasiac_status int(10) NOT NULL,
  PRIMARY KEY (idt),
  UNIQUE KEY iu_grc_evento_situacao_pagamento (codigo) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO grc_evento_situacao_pagamento (codigo, descricao, ativo, lojasiac_status) VALUES ('CR', 'Criada', 'S', '0');
INSERT INTO grc_evento_situacao_pagamento (codigo, descricao, ativo, lojasiac_status) VALUES ('EA', 'Em Andamento', 'S', '1');
INSERT INTO grc_evento_situacao_pagamento (codigo, descricao, ativo, lojasiac_status) VALUES ('AT', 'Autorizada', 'S', '4');
INSERT INTO grc_evento_situacao_pagamento (codigo, descricao, ativo, lojasiac_status) VALUES ('NA', 'N�o Autorizada', 'S', '5');
INSERT INTO grc_evento_situacao_pagamento (codigo, descricao, ativo, lojasiac_status) VALUES ('CO', 'Conclu�do', 'S', '6');
INSERT INTO grc_evento_situacao_pagamento (codigo, descricao, ativo, lojasiac_status) VALUES ('CA', 'Cancelado', 'S', '9');

ALTER TABLE `grc_evento_participante_pagamento`
DROP COLUMN `statuspgto`,
ADD COLUMN `idt_evento_situacao_pagamento`  int(10) UNSIGNED NOT NULL DEFAULT 1 AFTER `idt_atendimento`;

ALTER TABLE `grc_evento_participante_pagamento` ADD CONSTRAINT `grc_evento_participante_pagamento_ibfk_6` FOREIGN KEY (`idt_evento_situacao_pagamento`) REFERENCES `grc_evento_situacao_pagamento` (`idt`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `grc_evento_participante_pagamento`
MODIFY COLUMN `idt_evento_situacao_pagamento`  int(10) UNSIGNED NOT NULL AFTER `idt_atendimento`;

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `origem_reg`  varchar(50) NOT NULL AFTER `estornado`;

update grc_evento_participante_pagamento set origem_reg = 'PIR';

ALTER TABLE `grc_evento_participante_pagamento`
ADD COLUMN `lojasiac_id`  int(10) NULL AFTER `origem_reg`;

-- homologa
-- producao

