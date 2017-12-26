<?php
$idCampo = 'idt';
$Tela = "o Profissional Associado do Produto";
//

$TabelaPai   = "grc_profissional";
$AliasPai    = "grc_atd";
$EntidadePai = "Produto";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_produto_profissional";
$AliasPric        = "grc_atdp";
$Entidade         = "Profissional Associado ao Produto";
$Entidade_p       = "Profissionais Associados ao Produto";
$CampoPricPai     = "idt_produto";


$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";



$orderby = "";

//$sql_orderby=Array();





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


// Monta o vetor de Campo
$vetCampo['gec_p_descricao'] = CriaVetTabela('Profissional');
$vetCampo['observacao'] = CriaVetTabela('Observaчуo');

//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       gec_p.descricao as gec_p_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
$sql .= " inner join db_pir_gec gec_profissional gec_p on gec_p = grc_atdp.idt_profissional ";
//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "gec_p.codigo";

$sql .= " order by {$orderby}";
?>