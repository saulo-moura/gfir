<?php
$idCampo = 'idt';
$Tela = "a pol�tica de Vendas";


$TabelaPrinc      = "grc_politica_vendas";
$AliasPric        = "grc_pv";
$Entidade         = "Pol�tica de Vendas";
$Entidade_p       = "Pol�ticas de Vendas";
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
$vetCampo['codigo']    = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
$vetCampo['data_inicio'] = CriaVetTabela('Data Inicio Validade','data');
$vetCampo['data_fim'] = CriaVetTabela('Data Fim Validade','data');

$vetStatusPV=Array();
$vetStatusPV['CA']='Em Cadastramento';
$vetStatusPV['DI']='Dispon�vel';
$vetStatusPV['EX']='Cancelada';
$vetCampo['status']     = CriaVetTabela('Status', 'descDominio', $vetStatusPV );
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );




$sql  = "select * from {$TabelaPrinc} ";
$sql .= ' where ';
$sql .= ' lower(codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by codigo';
?>