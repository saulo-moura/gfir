<?php
$idCampo = 'idt';
$Tela = "o CNAE Fiscal";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.cnaefiscal";
$AliasPric        = "siac_tc";
$Entidade         = "CNAE Fiscal";
$Entidade_p       = "CNAEs Fiscal";

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
$vetCampo['CodAtivEcon']    = CriaVetTabela('Atividade Econ.');
$vetCampo['CodCnaeFiscal']    = CriaVetTabela('CNAE Fiscal');
$vetCampo['DescCnaeFiscal'  ] = CriaVetTabela('Descrição');

$sql  = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= '    lower(CodAtivEcon) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(CodCnaeFiscal) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(DescCnaeFiscal) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by CodAtivEcon,CodCnaeFiscal';
?>
