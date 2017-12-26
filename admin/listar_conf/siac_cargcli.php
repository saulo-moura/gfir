<?php
$idCampo = 'idt';
$Tela = "o Cargo";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.cargcli";
$AliasPric        = "siac_ca";
$Entidade         = "Cargo";
$Entidade_p       = "Cargos";

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
$vetCampo['codcargcli']    = CriaVetTabela('Código');
$vetCampo['desccargcli'  ] = CriaVetTabela('Descrição');
$vetCampo['Situacao']      = CriaVetTabela('Situação', 'descDominio', $vetSimNao );

$sql  = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= '    lower(codcargcli) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(desccargcli) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by codcargcli';
?>
