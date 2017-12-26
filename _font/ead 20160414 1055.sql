-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.6.25-log


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
-- Definition of table `grc_formulario_ferramenta_gestao`
--

DROP TABLE IF EXISTS `grc_formulario_ferramenta_gestao`;
CREATE TABLE `grc_formulario_ferramenta_gestao` (
  `idt` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` int(10) unsigned NOT NULL,
  `descricao` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL,
  `detalhe` text,
  `nivel` int(10) unsigned NOT NULL DEFAULT '1',
  `numero_pagina` int(10) unsigned DEFAULT NULL,
  `idt_area` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `iu_grc_formulario_ferramenta_gestao` (`codigo`),
  KEY `FK_grc_formulario_ferramenta_gestao_1` (`idt_area`),
  CONSTRAINT `FK_grc_formulario_ferramenta_gestao_1` FOREIGN KEY (`idt_area`) REFERENCES `grc_formulario_area` (`idt`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grc_formulario_ferramenta_gestao`
--

/*!40000 ALTER TABLE `grc_formulario_ferramenta_gestao` DISABLE KEYS */;
INSERT INTO `grc_formulario_ferramenta_gestao` (`idt`,`codigo`,`descricao`,`ativo`,`detalhe`,`nivel`,`numero_pagina`,`idt_area`) VALUES 
 (2,1,'DIÁRIO DE CAIXA','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;:</span></strong></p>\r\n<p><span style=\"font-family: Tahoma;\">Essa ferramenta permitir&aacute; que voc&ecirc; acompanhe diariamente as entradas e sa&iacute;das de dinheiro em sua empresa. Assim voc&ecirc; poder&aacute; saber o quanto est&aacute; recebendo e para onde est&aacute; indo o dinheiro de seu caixa.&nbsp;</span></p>',1,19,2),
 (7,2,'CONTROLE DO PAGAMENTO DE TRIBUTOS','S','<p><span style=\"font-family: Tahoma;\"><strong>O que &eacute;:<br />\r\n</strong><br />\r\nEsta ferramenta apresenta duas finalidades. A primeira &eacute; possibilitar que voc&ecirc; registre quais os tributos (impostos, taxas, contribui&ccedil;&otilde;es, etc.) que devem ser pagos periodicamente por sua empresa. A segunda &eacute; fornecer um espa&ccedil;o para voc&ecirc; registrar o per&iacute;odo em que estes tributos devem ser pagos, bem como os valores pagos ao longo do tempo.</span></p>',1,26,2),
 (8,3,'CONTROLE DO FLUXO DE CAIXA','S','<p><span style=\"font-family: Tahoma;\"><strong>O que &eacute;: </strong><br />\r\n<br />\r\nEsta ferramenta apresenta as receitas e gastos futuros distribu&iacute;dos semanalmente, permitindo a visualiza&ccedil;&atilde;o dos descompassos que podem ocorrer entre receitas e gastos, ou seja, per&iacute;odos com gastos superiores &agrave;s receitas e vice-versa.</span></p>',1,31,2),
 (9,4,'CÁLCULO DO GANHO UNITÁRIO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEssa ferramenta auxilia no c&aacute;lculo do ganho em dinheiro que o empres&aacute;rio obt&eacute;m com a venda de seus produtos e/ou servi&ccedil;os. Ou seja, a partir do pre&ccedil;o praticado, diminuindo os custos vari&aacute;veis diretos necess&aacute;rios para fazer o produto ou prestar o servi&ccedil;o, identificar quanto sobra para o empres&aacute;rio.</span></p>',2,36,2),
 (10,5,'DEMONSTRATIVO DE RESULTADO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEssa ferramenta apresenta objetivamente o resultado mensal de seu neg&oacute;cio. Com ela voc&ecirc; poder&aacute; registrar os valores de suas despesas e receitas. Al&eacute;m disso, pode acompanhar m&ecirc;s a m&ecirc;s quanto seu neg&oacute;cio est&aacute; gerando de dinheiro.</span></p>',2,42,2),
 (11,6,'GESTÃO DE ESTOQUES','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta tem como objetivo auxili&aacute;-lo no controle dos seus estoques (produtos, mat&eacute;riasprimas e materiais). Voc&ecirc; poder&aacute; definir qual a quantidade m&iacute;nima ou m&aacute;xima necess&aacute;ria de um determinado produto e tamb&eacute;m qual o momento ideal para fazer um novo pedido, evitando, principalmente, a falta de produtos para seus clientes.</span></p>',2,47,2),
 (12,7,'CONTROLE DO CAPITAL DE GIRO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEssa ferramenta permite acompanhar a quantidade de dinheiro necess&aacute;rio para atender os compromissos do dia a dia da empresa, o seu Capital de Giro.</span></p>',2,42,2),
 (13,8,'CADASTRO DE CLIENTES','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta ir&aacute; manter importantes informa&ccedil;&otilde;es sobre seus clientes &agrave; disposi&ccedil;&atilde;o, tais como a regi&atilde;o em que residem, seu perfil pessoal, os melhores meios para voc&ecirc; contat&aacute;-lo, seu perfil de compras, etc. Al&eacute;m de tudo, ir&aacute; ajudar voc&ecirc; a conhecer melhor os seus clientes para atend&ecirc;-los de maneira mais adequada</span></p>',1,61,3),
 (14,9,'PESQUISA DE SATISFAÇÃO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nO fato de seus clientes n&atilde;o reclamarem n&atilde;o significa que eles estejam totalmente satisfeitos com seu neg&oacute;cio. Assim, esta ferramenta ir&aacute; auxili&aacute;-lo a identificar o n&iacute;vel de satisfa&ccedil;&atilde;o de seus clientes em rela&ccedil;&atilde;o aos produtos e servi&ccedil;os ofertados em sua empresa. Um cliente satisfeito amplia a propaganda boca a boca</span></p>',1,69,3),
 (15,10,'ANÁLISE DAS NECESSIDADES DOS CLIENTES','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta ir&aacute; auxili&aacute;-lo na identifica&ccedil;&atilde;o e an&aacute;lise das principais necessidades e desejos de seus clientes, permitindo, assim, ampliar e melhorar suas possibilidades de atendimento o que poder&aacute; gerar diferencia&ccedil;&atilde;o e novas formas de ganhar mais dinheiro.</span></p>',2,74,3),
 (16,11,'SEGMENTAÇÃO DE CLIENTES','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta ir&aacute; classificar seus clientes de acordo com alguns crit&eacute;rios de segmenta&ccedil;&atilde;o (prefer&ecirc;ncia e volume de compra, regi&atilde;o, idade, estilos de vida, etc.). Assim, poder&aacute; formar grupos de clientes que possuem caracter&iacute;sticas comuns. Agrupando seus clientes desta maneira, sua empresa estar&aacute; apta a praticar o Marketing de Segmento, permitindo que voc&ecirc; tenha a&ccedil;&otilde;es mais direcionadas a cada grupo de clientes.</span></p>',2,80,3),
 (17,12,'OFERTANDO NOVOS PRODUTOS/SERVIÇOS','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta est&aacute; direcionada a captar do mercado informa&ccedil;&otilde;es que contribuam para voc&ecirc; visualizar oportunidades de ofertar novos produtos e servi&ccedil;os. Vai mostrar a voc&ecirc; oportunidades que hoje n&atilde;o s&atilde;o ofertadas e que podem contribuir com a melhoria da sua empresa.</span></p>',2,84,3),
 (18,13,'ENTENDIMENTO DO MERCADO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta ir&aacute; propiciar que voc&ecirc; conhe&ccedil;a mais claramente o mercado em que atua e a partir destas informa&ccedil;&otilde;es direcionar a&ccedil;&otilde;es para tornar seu neg&oacute;cio mais competitivo, ou seja, mais atraente ao seu cliente do que seus concorrentes.</span></p>',3,89,3),
 (19,14,'PLANO DE PROMOÇÃO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta auxilia voc&ecirc; a planejar as a&ccedil;&otilde;es de promo&ccedil;&atilde;o que pretende realizar no seu neg&oacute;- cio (propaganda de produtos e servi&ccedil;os, descontos, etc.). As promo&ccedil;&otilde;es servem para mobilizar e fidelizar os clientes, aumentado suas vendas e o lucro.</span></p>',3,93,3),
 (20,15,'PLANEJAMENTO: O PRIMEIRO PASSO PARA O SUCESSO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta ir&aacute; ajud&aacute;-lo a entender o porqu&ecirc; de fazer o planejamento e a import&acirc;ncia de definir um conjunto de a&ccedil;&otilde;es para realizar este plano. Quanto melhor for o seu planejamento e a realiza&ccedil;&atilde;o, maiores ser&atilde;o as suas chances de sucesso. O planejamento &eacute; um processo din&acirc;mico e cont&iacute;nuo. Planejar de maneira din&acirc;mica ajuda a reduzir atritos, confus&otilde;es e perdas. &Eacute; considerado cont&iacute;nuo porque voc&ecirc; deve planejar sempre e fazer corre&ccedil;&otilde;es a qualquer momento para alterar os rumos previamente definidos.</span></p>',1,101,3),
 (21,16,'PLANEJANDO O NEGÓCIO: OBJETIVOS E METAS','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nAo utilizar essa ferramenta, voc&ecirc; refletir&aacute; sobre a situa&ccedil;&atilde;o atual do seu neg&oacute;cio e a situa&ccedil;&atilde;o desejada, definindo a orienta&ccedil;&atilde;o de &ldquo;como causar a mudan&ccedil;a?&rdquo;, com foco no crescimento e sucesso do neg&oacute;cio. Voc&ecirc; partir&aacute; da situa&ccedil;&atilde;o atual (&ldquo;o que mudar?&rdquo;) e ter&aacute; como vis&atilde;o de futuro onde quer chegar (&ldquo;para o qu&ecirc; mudar?&rdquo;).</span></p>',2,106,3),
 (22,17,'PLANO DE AÇÃO DE CURTO E MÉDIO PRAZO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nObjetivos e Metas s&atilde;o materializados por planos de a&ccedil;&atilde;o bem definidos. Sendo assim, ao utilizar esta ferramenta, voc&ecirc; definir&aacute; o caminho para conduzir sua empresa ao sucesso. Um plano de a&ccedil;&atilde;o a gerenciar o planejamento.</span></p>',2,111,3),
 (23,18,'APRENDIZAGEM ESTRATÉGICA','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nAo utilizar essa ferramenta voc&ecirc; poder&aacute; resgatar situa&ccedil;&otilde;es que tiveram resultados satisfat&oacute;rios e/ ou ruins, por parte da empresa. Sendo assim, por meio destas situa&ccedil;&otilde;es, voc&ecirc; poder&aacute; manter e/ ou melhorar boas pr&aacute;ticas e n&atilde;o repetir os erros realizados no passado.</span></p>',3,115,3),
 (24,19,'ORGANIZAÇÃO E DISCIPLINA','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nA ferramenta apresentar&aacute; a voc&ecirc; um conjunto de conceitos e orienta&ccedil;&otilde;es que ir&atilde;o o auxiliar a compreender a import&acirc;ncia da organiza&ccedil;&atilde;o e disciplina para sua empresa. Ajudar&aacute;, ainda, a verificar em que n&iacute;vel de organiza&ccedil;&atilde;o sua empresa se encontra. Um ambiente de trabalho limpo e organizado pode garantir sua produtividade. Al&eacute;m de deixar as coisas &ldquo;mais &agrave; m&atilde;o&rdquo;, os desperd&iacute;cios e movimentos desnecess&aacute;rios come&ccedil;am a desaparecer, melhorando seu rendimento na atividade.</span></p>',1,123,5),
 (25,20,'ORGANIZAÇÃO DE DOCUMENTOS','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nCom esta ferramenta voc&ecirc; manter&aacute; organizado e sempre &agrave; m&atilde;o os documentos b&aacute;sicos da sua empresa. Al&eacute;m disso, contas a pagar e comprovantes de pagamentos, por exemplo, estar&atilde;o facilmente dispon&iacute;veis, reduzindo o risco de pagar duas vezes a mesma conta ou, ainda pior, n&atilde;o realizar o pagamento e ter que pagar juros ou at&eacute; mesmo ter o servi&ccedil;o interrompido por esquecimento e falta de organiza&ccedil;&atilde;o.</span></p>',1,129,5),
 (26,21,'CADASTRO DE FORNECEDORES','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta se apresenta como um fich&aacute;rio b&aacute;sico de fornecedores por produto ou fam&iacute;lia de produtos. Este cadastro &eacute; o m&iacute;nimo que voc&ecirc; precisa para saber de quem comprar quando precisar.</span></p>',2,131,5),
 (27,22,'INSTRUÇÃO DE TRABALHO','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nA Instru&ccedil;&atilde;o de Trabalho &eacute; uma ferramenta para documentar ou padronizar tarefas espec&iacute;ficas e operacionais. Com ela voc&ecirc; faz a descri&ccedil;&atilde;o e tamb&eacute;m a ilustra&ccedil;&atilde;o de como fazer determinado processo. Com isso, voc&ecirc; pode delegar e cobrar a realiza&ccedil;&atilde;o do trabalho de seus funcion&aacute;rios.</span></p>',3,135,5),
 (28,23,'COMPETÊNCIAS NECESSÁRIAS','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEssa ferramenta visa orientar voc&ecirc; sobre como definir o que as pessoas precisam para trabalhar bem, assim como, havendo a necessidade de contrata&ccedil;&atilde;o, identificar quais as compet&ecirc;ncias essenciais para o neg&oacute;cio s&atilde;o desejadas dos candidatos.<span class=\"Apple-tab-span\" style=\"white-space: pre;\">			</span>&nbsp;</span></p>',1,143,6),
 (29,24,'ORIENTAÇÕES PARA OBRIGAÇÕES TRABALHISTAS','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEssa ferramenta visa orientar voc&ecirc;, que inicia o processo de recrutamento, sobre como agir com os funcion&aacute;rios desde a contrata&ccedil;&atilde;o at&eacute; sua eventual demiss&atilde;o, al&eacute;m de orient&aacute;-lo para todas as obriga&ccedil;&otilde;es trabalhistas relacionadas com voc&ecirc; e com seus funcion&aacute;rios. Isso pode evitar um conjunto de preju&iacute;zos de rela&ccedil;&atilde;o trabalhista que podem impactar no resultado da empresa e na insatisfa&ccedil;&atilde;o dos funcion&aacute;rios.</span></p>',1,147,6),
 (30,25,'MATRIZ DE RESPONSABILIDADES','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nAo utilizar esta ferramenta voc&ecirc; ir&aacute; identificar as responsabilidades esperadas dos seus funcion&aacute;rios e que eles est&atilde;o aptos a realizar. Poder&aacute; tamb&eacute;m definir quem &eacute; a pessoa substituta em caso de aus&ecirc;ncia do respons&aacute;vel.</span></p>',2,150,4),
 (31,26,'PENSANDO EM EXPANDIR? PREPARE-SE PARA DELEGAR','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta far&aacute; voc&ecirc; refletir sobre a import&acirc;ncia da delega&ccedil;&atilde;o de tarefas para que possa expandir seu neg&oacute;cio. Este processo de delega&ccedil;&atilde;o deve ser conduzido de maneira organizada e sistem&aacute;tica para seus funcion&aacute;rios. Somente delegando ser&aacute; poss&iacute;vel que voc&ecirc; invista mais tempo em atividades estrat&eacute;gicas para seu neg&oacute;cio</span></p>',3,154,6),
 (32,27,'TREINAMENTO BASEADO EM PROBLEMAS','S','<p><strong><span style=\"font-family: Tahoma;\">O que &eacute;: </span></strong><span style=\"font-family: Tahoma;\"><br />\r\n<br />\r\nEsta ferramenta ir&aacute; orientar voc&ecirc; a realizar treinamentos com base na an&aacute;lise de problemas. Estes problemas podem ter ocorrido, ou a partir da sua experi&ecirc;ncia, podem vir a ocorrer no futuro.</span></p>',3,158,6),
 (33,28,'CONHECIMENTOS E CARACTERÍSTICAS','S',NULL,1,159,6),
 (36,29,'LAYOUT E ORGANIZAÇÃO DO EMPREENDIMENTO','S',NULL,1,160,7),
 (37,30,'TRENA DAS VENDAS','S',NULL,1,161,7),
 (38,31,'MATERIAL DE SINALIZAÇÃO','S',NULL,1,162,7),
 (39,32,'RELACIONAMENTO COM O CLIENTE','S',NULL,1,163,7),
 (40,33,'ANÁLISE DOS PROCEDIMENTOS NA EMPRESA','S',NULL,1,164,7);
/*!40000 ALTER TABLE `grc_formulario_ferramenta_gestao` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
