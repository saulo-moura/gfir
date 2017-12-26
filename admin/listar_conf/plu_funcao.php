<?php
$idCampo = 'id_funcao';
$Tela = "a funчуo";
//$tipofiltro='S';

$goCad[] = vetCad('p_cod_classificacao,p_nm_funcao,p_cod_funcao,p_classifica,id_funcao', 'Objetos', 'plu_objetos_funcao');

/*
  $goCad[] = vetCad('id_funcao', 'GO 01', 'plu_direito', 'listar', true);
  $goCad[] = vetCad('id_funcao', 'GO 02', 'plu_direito', 'listar', false);
  $goCad[] = vetCadGrupo(Array(
  vetCad('id_funcao', 'GO 03', 'plu_direito', 'listar'),
  vetCad('id_funcao', 'GO 04', 'plu_direito', 'listar'),
  vetCad('id_funcao', 'GO 05', 'plu_direito', 'listar'),
  ));
  $goCad[] = vetCad('id_funcao', 'GO 06', 'plu_direito', 'listar', false);
  $goCad[] = vetCad('id_funcao', 'GO 07', 'plu_direito', 'listar', true);
  $goCad[] = vetCadGrupo(Array(
  vetCad('id_funcao', 'GO 08', 'plu_direito', 'listar'),
  vetCad('id_funcao', 'GO 09', 'plu_direito', 'listar'),
  ), false);
  $goCad[] = vetCad('id_funcao', 'GO 10', 'plu_direito', 'listar', true);
 */
$TabelaPrinc = "plu_funcao";
$AliasPric = "plu_fu";
$Entidade = "Funчуo";
$Entidade_p = "Funчѕes";

$barra_inc_h = "Incluir um Novo Registro de Funчуo";
$contlinfim = "Existem #qt Funчѕes.";

//$comcontrole=0;



$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'p_cod_classificacao';
$Filtro['nome'] = 'Classificaчуo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cod_classificacao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'p_nm_funcao';
$Filtro['nome'] = 'Nome';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['nm_funcao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'p_cod_funcao';
$Filtro['nome'] = 'Transaчуo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cod_funcao'] = $Filtro;

$vetCampo['cod_classificacao'] = CriaVetTabela('Classificaчуo');
$vetCampo['nm_funcao'] = CriaVetTabela('Nome', 'classificacao');
$vetCampo['cod_funcao'] = CriaVetTabela('Transaчуo');
$vetCampo['sts_menu'] = CriaVetTabela('Mostra Menu', 'descDominio', $vetSimNao);

$sql = 'select   plu_funcao.id_funcao as idt, plu_funcao.*  from plu_funcao  ';
$sql .= ' where ';
$sql .= ' ( ';
$sql .= ' lower(cod_classificacao) like lower('.aspa($vetFiltro['cod_classificacao']['valor'], '', '%').')';
$sql .= ' and lower(nm_funcao) like lower('.aspa($vetFiltro['nm_funcao']['valor'], '%', '%').')';
$sql .= ' and lower(cod_funcao) like lower('.aspa($vetFiltro['cod_funcao']['valor'], '%', '%').')';
$sql .= ' ) ';

$sql .= ' order by cod_classificacao';