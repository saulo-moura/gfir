<?php
$idCampo = 'idt';
$Tela = "o Banco do Evento";

$TabelaPrinc      = "grc_evento_forma_parcelamento";
$AliasPric        = "grc_efp";
$Entidade         = "Forma de Parcelamento do Pagamento do Evento";
$Entidade_p       = "Formas de Parcelamento do Pagamento do Evento";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "grc_enp.descricao, {$AliasPric}.numero_de_parcelas";

$vetCampo['grc_enp_descricao']     = CriaVetTabela('Forma de Pagamento');
$vetCampo['numero_de_parcelas']    = CriaVetTabela('Nъmero de Parcelas');
$vetCampo['valor_ini']  = CriaVetTabela('Valor de', 'decimal');
$vetCampo['valor_ate']  = CriaVetTabela('Valor atй', 'decimal');
$vetCampo['codigo']    = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');

$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*, grc_enp.descricao as grc_enp_descricao   ";

$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= "   inner join grc_evento_natureza_pagamento grc_enp on grc_enp.idt = grc_efp.idt_natureza ";
if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>