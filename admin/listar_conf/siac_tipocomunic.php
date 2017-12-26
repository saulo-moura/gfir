<?php
$idCampo = 'idt';
$Tela = "o Tipo de Comunicação";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.tipocomunic";
$AliasPric        = "siac_tc";
$Entidade         = "Tipo de Comunicação";
$Entidade_p       = "Tipos de Comunicação";

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
$vetCampo['codcomunic']    = CriaVetTabela('Código');
$vetCampo['desccomunic'  ] = CriaVetTabela('Descrição');
$vetCampo['Situacao']      = CriaVetTabela('Situação', 'descDominio', $vetSimNao );

$sql  = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= '    lower(codcomunic) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(desccomunic) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by codcomunic';
?>
