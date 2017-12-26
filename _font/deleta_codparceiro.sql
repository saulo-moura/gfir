-- deleta 261585716
-- fica   261491152

SELECT * FROM db_pir_siac_ba.parceiro
where codparceiro = 261491152 or codparceiro = 261585716;

SELECT * FROM db_pir_siac_ba.historicorealizacoescliente
where codcliente = 261491152 or codcliente = 261585716
or codempreedimento = 261491152 or codempreedimento = 261585716;

SELECT * FROM db_pir_siac_ba.historicorealizacoescliente_anosanteriores
where codcliente = 261491152 or codcliente = 261585716
or codempreedimento = 261491152 or codempreedimento = 261585716
order by datahorainiciorealizacao;

SELECT * FROM db_pir_siac_ba.pessoaj
where codparceiro = 261491152 or codparceiro = 261585716;

SELECT * FROM db_pir_siac_ba.pessoaf
where codparceiro = 261491152 or codparceiro = 261585716;

SELECT * FROM db_pir_grc.grc_atendimento_organizacao
where codigo_siacweb_e = 261491152 or codigo_siacweb_e = 261585716;

SELECT * FROM db_pir_grc.grc_atendimento_pessoa
where codigo_siacweb = 261491152 or codigo_siacweb = 261585716;

SELECT * FROM db_pir_gec.gec_entidade
where codigo_siacweb = 261491152 or codigo_siacweb = 261585716;

SELECT e.idt, e.codigo, e.descricao, eo.dap, eo.nirf, eo.rmp, eo.ie_prod_rural
FROM db_pir_gec.gec_entidade e
inner join db_pir_gec.gec_entidade_organizacao eo on eo.idt_entidade = e.idt
where e.codigo_siacweb = 261491152 or e.codigo_siacweb = 261585716;

--------------------------------

update db_pir_siac_ba.historicorealizacoescliente_anosanteriores set codempreedimento = 261491152 where codempreedimento = 261585716

--------------------------------

delete from db_pir_siac_ba.comunicacao where codparceiro = 261585716;
delete from db_pir_siac_ba.endereco where codparceiro = 261585716;
delete from db_pir_siac_ba.ativeconpj where codparceiro = 261585716;

delete from db_pir_siac_ba.contato where codcontatopf = 261585716;
delete from db_pir_siac_ba.contato where codcontatopj = 261585716;

delete from db_pir_siac_ba.historicorealizacoescliente where codcliente = 261585716;
delete from db_pir_siac_ba.historicorealizacoescliente where codempreedimento = 261585716;

delete from db_pir_siac_ba.historicorealizacoescliente_anosanteriores where codcliente = 261585716;
delete from db_pir_siac_ba.historicorealizacoescliente_anosanteriores where codempreedimento = 261585716;

delete from db_pir_siac_ba.pessoaf where codparceiro = 261585716;
delete from db_pir_siac_ba.pessoaj where codparceiro = 261585716;

delete from db_pir_siac_ba.parceiro where codparceiro = 261585716;
