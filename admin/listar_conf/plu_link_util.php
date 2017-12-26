<?php
$idCampo = 'idt';
$Tela = "LINK's Ъteis";


$TabelaPrinc      = "plu_link_util";
$AliasPric        = "plu_lu";
$Entidade         = "LINK Ъtil";
$Entidade_p       = "LINK's Ъtil";
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
$vetCampo['classificacao']    = CriaVetTabela('Ordem');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
$vetCampo['analitico']     = CriaVetTabela('Analнtico?', 'descDominio', $vetSimNao );
$vetCampo['link']         = CriaVetTabela('LINK','link');

$sql  = "select * from {$TabelaPrinc} ";
$sql .= ' where ';
$sql .= ' lower(codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by classificacao, descricao';
?>