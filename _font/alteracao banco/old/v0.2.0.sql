-- 07/05/2015

ALTER TABLE `plu_painel_funcao`
ADD COLUMN `imagem` varchar(120) DEFAULT NULL AFTER `pos_left`,
ADD COLUMN `texto_cab` varchar(50) DEFAULT NULL AFTER `imagem`,
ADD COLUMN `detalhe` text AFTER `texto_cab`,
ADD COLUMN `visivel` char(1) DEFAULT NULL AFTER `detalhe`,
ADD COLUMN `hint` text AFTER `visivel`;

ALTER TABLE `plu_painel_funcao`
MODIFY COLUMN `imagem`  varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `pos_left`,
MODIFY COLUMN `visivel`  char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `detalhe`;

update plu_painel_funcao set imagem = (select imagem from plu_funcao where plu_funcao.id_funcao = plu_painel_funcao.id_funcao);
update plu_painel_funcao set texto_cab = (select texto_cab from plu_funcao where plu_funcao.id_funcao = plu_painel_funcao.id_funcao);
update plu_painel_funcao set detalhe = (select detalhe from plu_funcao where plu_funcao.id_funcao = plu_painel_funcao.id_funcao);
update plu_painel_funcao set visivel = (select visivel from plu_funcao where plu_funcao.id_funcao = plu_painel_funcao.id_funcao);
update plu_painel_funcao set hint = (select hint from plu_funcao where plu_funcao.id_funcao = plu_painel_funcao.id_funcao);

insert into plu_funcao (cod_funcao,nm_funcao,cod_classificacao,sts_menu,sts_linha,des_prefixo)
values ('plu_painel_funcao','Cadastro de Painel Função','90.80.05.10.01','N','N','listar');

insert into plu_direito_funcao (id_direito, id_funcao)
select id_direito, (select id_funcao from plu_funcao where cod_funcao = 'plu_painel_funcao') as id_funcao
from plu_direito where cod_direito in ('con', 'alt', 'exc', 'inc');

insert into plu_direito_perfil (id_perfil, id_difu)
select 1 as id_perfil, id_difu from plu_direito_funcao df inner join plu_funcao f on df.id_funcao = f.id_funcao
where f.cod_funcao in ('plu_painel_funcao');

update plu_painel_funcao set visivel = 'S' where visivel is null or visivel = '';

ALTER TABLE `plu_painel`
ADD COLUMN `move_item`  char(1) NOT NULL AFTER `descricao`;

update plu_painel set move_item = 'S';

-- prod

ALTER TABLE `plu_painel` ADD COLUMN `mostra_item` VARCHAR(2) NOT NULL AFTER `descricao`,
 ADD COLUMN `texto_altura` INT(11) NOT NULL AFTER `mostra_item`,
 ADD COLUMN `layout_grid` CHAR(1) NOT NULL AFTER `move_item`;

update plu_painel set mostra_item = 'IT', texto_altura = 15, layout_grid = 'S';

-- 08/05/2015

ALTER TABLE `plu_painel` ADD COLUMN `img_margem_dir` INT(11) NOT NULL AFTER `img_largura`,
ADD COLUMN `img_margem_esq` INT(11) NOT NULL AFTER `img_margem_dir`,
ADD COLUMN `espaco_linha` INT(11) NOT NULL AFTER `img_margem_esq`;

update plu_painel set img_margem_dir = 10, img_margem_esq = 10, espaco_linha = 15;

ALTER TABLE `plu_painel`
ADD COLUMN `classificacao`  varchar(200) NOT NULL AFTER `codigo`;

update plu_painel set classificacao = idt;

ALTER TABLE `plu_funcao`
ADD COLUMN `parametros`  varchar(200) NULL AFTER `des_prefixo`;

ALTER TABLE `plu_painel_funcao`
ADD COLUMN `parametros`  varchar(200) NULL AFTER `hint`;

ALTER TABLE `plu_funcao`
ADD COLUMN `prefixo_menu` text NULL AFTER `des_prefixo`;

update plu_funcao set prefixo_menu = des_prefixo;
