<?php
$idCampo = 'idt';
$Tela = "o Documento";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "gec_documento";
$AliasPric        = "gec_do";
$Entidade         = "Documento";
$Entidade_p       = "Documentos";

$barra_inc_h = 'Incluir um Novo Registro de Documento';
$contlinfim  = "Existem #qt Documentos.";


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

$sql  = 'select * from gec_documento ';
$sql .= ' where ';
$sql .= ' lower(codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by codigo';
?>