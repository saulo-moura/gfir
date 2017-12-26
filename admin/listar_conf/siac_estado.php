<?php
$idCampo = 'idt';
$Tela = "o Estado";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.estado";
$AliasPric        = "siac_es";
$Entidade         = "Estado";
$Entidade_p       = "Estados";

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

$vetCampo['CodEst']    = CriaVetTabela('Código');
$vetCampo['DescEst']   = CriaVetTabela('Descrição');
$vetCampo['Desc_Pais'] = CriaVetTabela('Pais');
$vetCampo['SITUACAO']  = CriaVetTabela('Situação');

$sql  = "select {$TabelaPrinc}.*,DescPais as Desc_Pais  from {$TabelaPrinc} ";
$sql .= " left join  db_pir_siac.pais as pa on pa.CodPais = db_pir_siac.estado.CodPais";
$sql .= " where ";
$sql .= '    lower(CodEst) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(DescEst) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by CodEst';
?>
