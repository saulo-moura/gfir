<?php
$idCampo = 'idt';
$Tela = "o Pa�s";

$goCad[] = vetCad('idt', 'Estado', 'plu_estado');

$TabelaPrinc      = "plu_pais";
$AliasPric        = "plu_pa";
$Entidade         = "Pa�s";
$Entidade_p       = "Pa�ses";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";


$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;


//Monta o vetor de Campo
$vetCampo['codigo'] = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
$vetCampo['imagem'] = CriaVetTabela('Unidade Federa��o', 'arquivo', '200', 'plu_pais');

$sql = 'select * from '.$pre_table.'plu_pais where ';
$sql .= ' lower(codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by descricao';
?>