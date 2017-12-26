<?php
$idCampo = 'idt';
$Tela = "o Porte";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.porte";
$AliasPric        = "siac_po";
$Entidade         = "Porte";
$Entidade_p       = "Portes";

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
$vetCampo['codPorte']   = CriaVetTabela('Código');
$vetCampo['porte'  ]    = CriaVetTabela('Descrição');
$vetCampo['Situacao']   = CriaVetTabela('Situação', 'descDominio', $vetSimNao );

$sql  = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= '    lower(codporte) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(porte) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by codPorte';
?>
