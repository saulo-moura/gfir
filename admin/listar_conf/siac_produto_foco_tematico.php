<?php
$idCampo = 'idt';
$Tela = "o Foco Tem�tico";

$TabelaPrinc      = "db_pir_siac.produto_foco_tematico";
$AliasPric        = "siac_pft";
$Entidade         = "Foco Tem�tico";
$Entidade_p       = "Foco Tem�ticos";

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

$vetCampo['codigo']    = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
$vetCampo['idt_siac']  = CriaVetTabela('Idt do SIAC');
$vetCampo['idt_pir']   = CriaVetTabela('Idt do PIR');
$vetCampo['data_ultima_movimentacao'] = CriaVetTabela('Data �ltima Movimenta��o');

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

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