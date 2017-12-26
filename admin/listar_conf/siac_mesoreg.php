<?php
$idCampo = 'idt';
$Tela = "a Mesoregião";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.mesoreg";
$AliasPric        = "siac_me";
$Entidade         = " Mesoregião";
$Entidade_p       = " Mesoregiões";

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
$vetCampo['codmeso']    = CriaVetTabela('Código');
$vetCampo['descmeso'  ] = CriaVetTabela('Descrição');
$vetCampo['codest'  ] = CriaVetTabela('Estado');

$sql  = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= '    lower(codmeso) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(descmeso) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(codest) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by codmeso';
?>
