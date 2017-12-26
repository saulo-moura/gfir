<?php
$idCampo = 'idt';
$Tela = "as Gerações das Agendas";

$TabelaPrinc      = "grc_atendimento_gera_agenda";
$AliasPric        = "grc_aga";
$Entidade         = "Geração da Agenda";
$Entidade_p       = "Gerações da Agenda";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$prefixow    = 'listar';
$mostrar    = false;
$cond_campo = '';
$cond_valor = '';


$sql   = 'select ';
$sql  .= '   idt, descricao  ';
$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql  .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
$sql  .= ' order by classificacao ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Pontos de Atendimento';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;




$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;


//    $comfiltro = 'A';
//    $comidentificacao = 'A';

$orderby = "dt_geracao";

$vetCampo['pu_nome_usuario']   = CriaVetTabela('Usuário');
$vetCampo['dt_geracao']        = CriaVetTabela('Data Geração', 'data');
$vetCampo['dt_inicial']        = CriaVetTabela('Data Inicial', 'data');
$vetCampo['dt_final']          = CriaVetTabela('Data Final', 'data');
$vetCampo['sca_nome_completo'] = CriaVetTabela('PA');
$vetCampo['pnu_nome_completo'] = CriaVetTabela('Consultor');
$vetCampo['executa']           = CriaVetTabela('Executa?');

//$sql   = "select ";
//$sql  .= "   {$AliasPric}.*  ";
//$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";



$sql   = "select ";
$sql  .= "   {$AliasPric}.*, pnu.nome_completo as pnu_nome_completo,  ";
$sql  .= "                   pu.nome_completo as pu_nome_usuario    ";

$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join plu_usuario as pu  on pu.id_usuario = .{$AliasPric}.idt_usuario ";
$sql  .= " left  join plu_usuario as pnu on pnu.id_usuario = .{$AliasPric}.idt_consultor ";

//$sql   = "select ";
//$sql  .= "   {$AliasPric}.*, pu.nome_completo as pu_nome_completo  ";
//$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
//$sql  .= " left  join plu_usuario as pu  on pu.id_usuario = .{$AliasPric}.idt_usuario ";

//$sql   = "select ";
//$sql  .= "   {$AliasPric}.*, pu.nome_completo as pnu_nome_completo  ";
//$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
//$sql  .= " left  join plu_usuario as pnu  on pnu.id_usuario = .{$AliasPric}.idt_consultor ";





//$sql .= ' where ';
//$sql .= " {$AliasPric}.idt_usuario =  ".null($vetFiltro['usuario']['valor']);



if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '    lower(gae.descricao)    like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(pu.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
// $sql  .= " order by {$orderby}";

if ($sqlOrderby == '') {
        $sqlOrderby = 'dt_geracao desc ';
}

?>
