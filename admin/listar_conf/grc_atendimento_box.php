<?php
$idCampo = 'idt';
$Tela = "o Box";

$TabelaPrinc      = "grc_atendimento_box";
$AliasPric        = "grc_ab";
$Entidade         = "Box";
$Entidade_p       = "Boxes";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$sql   = 'select ';
$sql  .= '   idt, descricao  ';
$sql  .= ' from '.db_pir.'sca_organizacao_secao sca_os ';
//$sql  .= ' where substring(descricao,1,2) = "PA"  ';
$sql  .= ' where posto_atendimento = "S"  ';    // PA
$sql  .= '    or posto_atendimento = "UR"  ';   // Unidade Regional
$sql  .= ' order by classificacao ';

$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Ponto Atendimento';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;





$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;


    $comfiltro = 'A';
    $comidentificacao = 'A';

$orderby = "{$AliasPric}.codigo";

$vetCampo['codigo']    = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['gtb_descricao'] = CriaVetTabela('Tipo de Guichк');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );


$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "   gtb.descricao as gtb_descricao  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join grc_atendimento_tipo_box as gtb on gtb.idt = .{$AliasPric}.idt_tipo_box ";

$sql .= ' where ';
$sql .= " {$AliasPric}.idt_organizacao_secao =  ".null($vetFiltro['ponto_atendimento']['valor']);


if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>