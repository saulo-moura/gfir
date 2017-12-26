<?php
$idCampo = 'idt';
$Tela = "a Cidade";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.cidade";
$AliasPric        = "siac_ci";
$Entidade         = "Cidade";
$Entidade_p       = "Cidades";

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

$vetCampo['CodCid']    = CriaVetTabela('Código');
$vetCampo['DescCid']   = CriaVetTabela('Descrição');
$vetCampo['Desc_Est'] = CriaVetTabela('Estado');
$vetCampo['SITUACAO']  = CriaVetTabela('Situação');

$sql  = "select {$TabelaPrinc}.*,DescEst as Desc_Est  from {$TabelaPrinc} ";
$sql .= " left join  db_pir_siac.estado as est on est.CodEst = db_pir_siac.cidade.CodEst";
$sql .= " where ";
$sql .= '    lower(CodCid) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(DescCid) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by CodCid';
?>
