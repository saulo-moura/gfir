<?php
$idCampo = 'idt';
$Tela = "o Tipo de Realização";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.tiporealizacao";
$AliasPric        = "siac_tc";
$Entidade         = "Tipo de Realização";
$Entidade_p       = "Tipos de Realização";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";


$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//Monta o vetor de Campo
$vetCampo['CodTipoRealizacao']    = CriaVetTabela('Código');
$vetCampo['DescTipoRealizacao'  ] = CriaVetTabela('Descrição');
$vetCampo['Situacao']      = CriaVetTabela('Situação', 'descDominio', $vetSimNao );

$sql  = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= '    lower(CodTipoRealizacao) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(DescTipoRealizacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by CodTipoRealizacao';
?>
