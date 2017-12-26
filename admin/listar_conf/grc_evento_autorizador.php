<?php
$idCampo = 'idt';
$Tela = "os Autorizadores do PA";

$TabelaPrinc      = "grc_evento_autorizador";
$AliasPric        = "grc_app";
$Entidade         = "PA do Autorizador";
$Entidade_p       = "PA´s do Autorizador";


$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';



$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$sql   = 'select ';
$sql  .= '   idt, descricao  ';
$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql  .= " where posto_atendimento <> 'S'  ";
$sql  .= ' order by classificacao ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Unidades Regionais';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;


$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;


$vetCampo['grc_ta_descricao'] = CriaVetTabela('Tipo Autorizador');
$vetCampo['pu_nome_completo'] = CriaVetTabela('Autorizador');

//$vetCampo['valor'] = CriaVetTabela('Valor da Alçada','decimal');

$vetRel = Array();
$vetRel['1'] = 'Primeiro';
$vetRel['2'] = 'Segundo';
$vetRel['3'] = 'Terceiro';
$vetRel['4'] = 'Quarto';
//$vetCampo['prioridade'] = CriaVetTabela('Prioridade','descDominio',$vetRel);
$vetCampo['observacao'] = CriaVetTabela('Observação');

$sql   = "select ";
$sql  .= "   {$AliasPric}.*, ";
$sql  .= "   grc_ta.descricao as grc_ta_descricao,  ";
$sql  .= "   pu.nome_completo as pu_nome_completo   ";

$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join plu_usuario as pu on pu.id_usuario = .{$AliasPric}.idt_autorizador ";
$sql  .= " inner join grc_evento_tipo_autorizador as grc_ta on grc_ta.idt = .{$AliasPric}.idt_tipo_autorizador ";


$sql  .= ' where ';
$sql  .= ' idt_ponto_atendimento = '.null($vetFiltro['ponto_atendimento']['valor']);

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower(pu.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
