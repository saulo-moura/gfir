<?php
$idCampo = 'idt';
$Tela = "o Insumo";

$TabelaPrinc      = "grc_insumo";
$AliasPric        = "grc_ins";
$Entidade         = "Insumo";
$Entidade_p       = "Insumos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$tipoidentificacao = 'N';
$tipofiltro = 'S';

$comfiltro = 'A';
$comidentificacao = 'F';



$Filtro = Array();
$Filtro['rs'] = $vetSimNao;
$Filtro['id'] = 'sinal';
$Filtro['nome'] = 'Despesa?';
$Filtro['LinhaUm'] = '';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['sinal'] = $Filtro;



$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "grc_iec.codigo, {$AliasPric}.classificacao";

$orderby = "{$AliasPric}.classificacao";

$vetCampo['classificacao']     = CriaVetTabela('Classificação');
$vetCampo['grc_iec_descricao'] = CriaVetTabela('Elemento<br />de Custo/<br />Receita');
$vetCampo['codigo']            = CriaVetTabela('Código');
$vetCampo['codigo_rm']         = CriaVetTabela('Código RM');
$vetCampo['descricao']         = CriaVetTabela('Descrição');


$vetCampo['grc_iu_descricao']  = CriaVetTabela('Unidade');
$vetCampo['por_participante']  = CriaVetTabela('Por<br /> parti.?', 'descDominio', $vetSimNao );

$vetCampo['custo_unitario_real'] = CriaVetTabela('Custo Unitário?', 'decimal' );

$vetCampo['nivel']     = CriaVetTabela('Analítico?', 'descDominio', $vetSimNao );
$vetCampo['sinal']     = CriaVetTabela('Despesa?', 'descDominio', $vetSimNao );
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
//
$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";

$sql  .= "   grc_iu.descricao as grc_iu_descricao,   ";
$sql  .= "   grc_iec.descricao as grc_iec_descricao   ";

$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
//
$sql  .= " left join grc_insumo_unidade grc_iu on grc_iu.idt = {$AliasPric}.idt_insumo_unidade ";
//
$sql  .= " left join grc_insumo_elemento_custo grc_iec on grc_iec.idt = {$AliasPric}.idt_insumo_elemento_custo ";

$sql .= ' where 1 = 1 ';


if ($vetFiltro['sinal']['valor']!="" or $vetFiltro['sinal']['valor']!=0)
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '      sinal = '.aspa( $vetFiltro['sinal']['valor'] );
    $sql .= ' ) ';

}    



if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)           like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.classificacao)  like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.detalhe)        like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.codigo_rm)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
  
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>