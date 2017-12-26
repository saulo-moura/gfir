<?php
$idCampo = 'id_funcao';
$Tela = "a fun��o Site";

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'cod_classificacao';
$Filtro['nome'] = 'Classifica��o';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cod_classificacao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'nm_funcao';
$Filtro['nome'] = 'Nome';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['nm_funcao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'cod_funcao';
$Filtro['nome'] = 'Transa��o';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cod_funcao'] = $Filtro;

$TabelaPrinc      = "plu_site_funcao";
$AliasPric        = "plu_sf";
$Entidade         = "Fun��o do Site";
$Entidade_p       = "Fun��es do Site";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";


//Monta o vetor de Campo
$vetCampo['cod_classificacao'] = CriaVetTabela('Classifica��o');
$vetCampo['nm_funcao'] = CriaVetTabela('Nome');
$vetCampo['cod_funcao'] = CriaVetTabela('Transa��o');
$vetCampo['sts_menu'] = CriaVetTabela('Mostra Menu', 'descDominio', $vetSimNao);
$vetCampo['arq_admin'] = CriaVetTabela('Chama do Admin?', 'descDominio', $vetSimNao);
$vetCampo['cod_assinatura'] = CriaVetTabela('C�digo<br>Assinatura');
//$vetCampo['seto_descricao'] = CriaVetTabela('Setor');
//$sql  = 'select fun.*, seto.descricao as seto_descricao ';

$sql  = 'select fun.* ';

$sql .= ' from plu_site_funcao fun ';
//$sql .= '  left join setor seto on seto.idt = fun.idt_setor ';
$sql .= ' where ';
$sql .= ' lower(cod_classificacao) like lower('.aspa($vetFiltro['cod_classificacao']['valor'], '', '%').')';   
$sql .= ' and lower(nm_funcao) like lower('.aspa($vetFiltro['nm_funcao']['valor'], '%', '%').')';   
$sql .= ' and lower(cod_funcao) like lower('.aspa($vetFiltro['cod_funcao']['valor'], '%', '%').')';   
$sql .= ' order by cod_classificacao';



?>