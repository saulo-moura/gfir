<?php
$idCampo = 'idt';
$Tela = "a Relaчуo da pessoa na Comissуo";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "gec_edital_relacao";
$AliasPric        = "gec_er";
$Entidade         = "Relaчуo da pessoa na Comissуo";
$Entidade_p       = "Relaчѕes da pessoa na Comissуo";

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
$vetCampo['codigo']    = CriaVetTabela('Cѓdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriчуo');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql  = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= ' lower(codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by codigo';
?>