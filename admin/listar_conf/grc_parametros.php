<?php
$idCampo = 'idt';
$Tela = "o Par�metro";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "grc_parametros";
$AliasPric        = "pfo_pa";
$Entidade         = "Par�metro";
$Entidade_p       = "Par�metros";

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
$vetCampo['classificacao']    = CriaVetTabela('Classifica��o');
$vetCampo['codigo']    = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql  = 'select * from grc_parametros ';
$sql .= ' where ';
$sql .= ' lower(codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by classificacao';
?>