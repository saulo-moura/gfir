<?php
$idCampo = 'idt';
$Tela = "o Setor";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.setor";
$AliasPric        = "siac_s";
$Entidade         = "Setor";
$Entidade_p       = "Setores";

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
$vetCampo['codsetor']    = CriaVetTabela('Código');
$vetCampo['descsetor'  ] = CriaVetTabela('Descrição');
$vetCampo['Situacao']    = CriaVetTabela('Situação', 'descDominio', $vetSimNao );

$sql  = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= '    lower(codsetor) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(descsetor) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by codsetor';
?>
