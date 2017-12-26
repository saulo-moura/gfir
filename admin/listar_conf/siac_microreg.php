<?php
$idCampo = 'idt';
$Tela = "a Mesoregião";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.microreg";
$AliasPric        = "siac_mi";
$Entidade         = " Microregião";
$Entidade_p       = " Microregiões";

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
$vetCampo['codmicro']    = CriaVetTabela('Código');
$vetCampo['descmicro'  ] = CriaVetTabela('Descrição');
$vetCampo['codest'  ] = CriaVetTabela('Estado');

$sql  = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= '    lower(codmicro) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(descmicro) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(codest) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by codmicro';
?>
