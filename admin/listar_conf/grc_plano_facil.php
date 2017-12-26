<?php
$idCampo = 'idt';
$Tela = "o Plano Fácil";
//
$TabelaPai   = "grc_atendimento";
$AliasPai    = "grc_at";
$EntidadePai = "Atendimento";
$idPai       = "idt";
//
$TabelaPrinc      = "grc_plano_facil";
$AliasPric        = "grc_pf";
$Entidade         = "Plano Fácil";
$Entidade_p       = "Planos Fácil";
$CampoPricPai     = "idt_atendimento";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

$prefixow    = 'listar';
$mostrar    = true;
$cond_campo = '';
$cond_valor = '';
//
$Filtro = Array();
//$Filtro['campo']  = 'descricao';
//$Filtro['tabela'] = $TabelaPai;
$Filtro['id']     = 'idt';
$Filtro['nome']   = $EntidadePai;
$Filtro['valor']  = trata_id($Filtro);
$vetFiltro[$CampoPricPai] = $Filtro;
//
$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//
// Monta o vetor de Campo
// $vetCampo['grc_at_protocolo']     = CriaVetTabela('Protocolo Atendimento');
$vetCampo['protocolo']            = CriaVetTabela('Protocolo Plano Fácil');
$vetCampo['banco_ideia']          = CriaVetTabela('Banco de Idéias');
$vetCampo['quemquandoprocurar']   = CriaVetTabela('Quando e Quem procurar');
$vetCampo['plu_us_nome_completo'] = CriaVetTabela('Responsável');
//
$sql  = "select {$AliasPric}.*, ";
//$sql  .= "       grc_fa.descricao as grc_fa_descricao, ";
$sql  .= "       plu_us.nome_completo as plu_us_nome_completo ";
//$sql  .= "       {$TabelaPai}.protocolo as {$TabelaPai}_protocolo ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
// $sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
//$sql .= " inner join grc_formulario_area grc_fa on grc_fa.idt = {$AliasPric}.idt_area ";
$sql .= " inner join plu_usuario plu_us on plu_us.id_usuario = {$AliasPric}.idt_responsavel ";
//
//$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);

$sql .= " where 1 = 1 ";


if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.protocolo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
//	$sql .= ' or lower('.$TabelaPai.'.protocolo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(grc_fa.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower(plu_us.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower(banco_ideia) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower(quemquandoprocurar) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

?>