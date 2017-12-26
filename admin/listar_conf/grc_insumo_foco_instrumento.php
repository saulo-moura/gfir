<?php
$idCampo = 'idt';
$Tela = "a Relaчуo Foco Instrumento Insumo";
$TabelaPrinc      = "grc_insumo_foco_instrumento";
$AliasPric        = "grc_ifi";
$Entidade         = "Relaчуo Insumo x Foco X Instrumento";
$Entidade_p       = "Relaчуo Insumo x Foco X Instrumento";
$CampoPricPai     = "";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";

$orderby = "";

//
$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
// Monta o vetor de Campo
$vetCampo['grc_ai_descricao'] = CriaVetTabela('Instrumento');
$vetCampo['grc_ft_descricao'] = CriaVetTabela('Foco Temсtico');
$vetCampo['insumorm'] = CriaVetTabela('Insumo RM');
$vetCampo['observacao'] = CriaVetTabela('Observaчуo');

//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       grc_ft.descricao as grc_ft_descricao, ";
$sql  .= "       grc_ai.descricao as grc_ai_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_foco_tematico grc_ft on grc_ft.idt = {$AliasPric}.idt_foco ";
$sql .= " inner join grc_atendimento_instrumento grc_ai on grc_ai.idt = {$AliasPric}.idt_instrumento ";
//
$sql .= " where ";
$sql .= ' ( ';
$sql .= ' lower(grc_ft.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(grc_ai.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.observacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.insumorm) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "grc_ai.descricao, grc_ft.descricao, {$AliasPric}.insumorm";

$sql .= " order by {$orderby}";
?>