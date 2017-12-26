<?php
$idCampo = 'idt';
$Tela = "o Produdo de Mercado";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "gec_mercado_produto";
$AliasPric        = "gec_mep";
$Entidade         = "Produdo de Mercado";
$Entidade_p       = "Produdos de Mercado";
//
$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";
//
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql  = "select * from {$TabelaPrinc} ";
$sql .= ' where ';
$sql .= ' lower(codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by codigo';
?>