<?php
$idCampo = 'idt';
$Tela = "o Produto";

$TabelaPrinc      = "db_pir_siac.produto";
$AliasPric        = "siac_p";
$Entidade         = "Produto";
$Entidade_p       = "Produtos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.codigo";
//
$vetCampo['codigo']    = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['idt_siac']  = CriaVetTabela('Idt do SIAC');
$vetCampo['idt_pir']   = CriaVetTabela('Idt do PIR');
//
$vetCampo['siac_pi_descricao']   = CriaVetTabela('Instrumento');
$vetCampo['siac_pft_descricao']   = CriaVetTabela('Foco Temбtico');
$vetCampo['siac_pa_descricao']   = CriaVetTabela('Autor');
$vetCampo['siac_pr_descricao']   = CriaVetTabela('Responsбvel');
//
$vetCampo['data_ultima_movimentacao'] = CriaVetTabela('Data ъltima Movimentaзгo');

$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "   siac_pi.descricao  as siac_pi_descricao,  ";
$sql  .= "   siac_pft.descricao as siac_pft_descricao,  ";
$sql  .= "   siac_pa.descricao  as siac_pa_descricao,  ";
$sql  .= "   siac_pr.descricao  as siac_pr_descricao  ";


$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

$sql  .= " inner join db_pir_siac.produto_instrumento siac_pi on siac_pi.idt = {$AliasPric}.idt_instrumento ";
$sql  .= " inner join db_pir_siac.produto_foco_tematico siac_pft on siac_pft.idt = {$AliasPric}.idt_foco_tematico ";
$sql  .= " inner join db_pir_siac.produto_autor siac_pa on siac_pa.idt = {$AliasPric}.idt_autor ";
$sql  .= " inner join db_pir_siac.produto_responsavel siac_pr on siac_pr.idt = {$AliasPric}.idt_responsavel ";


if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.data_ultima_movimentacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>