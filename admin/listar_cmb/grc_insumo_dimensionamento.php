<?php
$idCampo = 'idt';
$Tela = "o Insumo";

$TabelaPrinc = "grc_insumo_dimensionamento";
$AliasPric = "grc_ins";
$Entidade = "Insumo do Dimensionamento";
$Entidade_p = "Insumos do Dimensionamento";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['codigo'] = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['grc_iu_descricao'] = CriaVetTabela('Unidade');
$vetCampo['vl_unitario'] = CriaVetTabela('Custo Unitбrio', 'decimal');

$sql = "select ";
$sql .= "   {$AliasPric}.*,  ";
$sql .= "   concat_ws(' - ', {$AliasPric}.descricao, grc_iu.descricao) as {$campoDescListarCmb},";
$sql .= "   grc_iu.descricao as grc_iu_descricao";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " left join grc_insumo_unidade grc_iu on grc_iu.idt = {$AliasPric}.idt_insumo_unidade ";
$sql .= " where {$AliasPric}.ativo = 'S'";

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)           like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.detalhe)        like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}