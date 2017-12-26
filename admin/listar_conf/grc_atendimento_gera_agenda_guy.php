<?php
$idCampo = 'idt';
$Tela = "as Geraчѕes das Agendas";

$TabelaPrinc      = "grc_atendimento_gera_agenda";
$AliasPric        = "grc_aga";
$Entidade         = "Geraчуo da Agenda";
$Entidade_p       = "Geraчѕes da Agenda";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$prefixow    = 'listar';
$mostrar    = false;
$cond_campo = '';
$cond_valor = '';



//$barra_exc_ap = false;

/*

$sql   = 'select ';
$sql  .= '   id_usuario, nome_completo  ';
$sql  .= ' from db_pir_grc.plu_usuario grc_pu ';
$sql  .= ' where id_usuario = '.$_SESSION[CS]['g_id_usuario'];
//$sql  .= ' order by codigo ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'id_usuario';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Usuсrio';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['usuario'] = $Filtro;

*/

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

$vetCampo['pu_nome_usuario']   = CriaVetTabela('Usuсrio');
$vetCampo['dt_geracao']   = CriaVetTabela('Data Geraчуo', 'data');
$vetCampo['dt_inicial']   = CriaVetTabela('Data Inicial', 'data');
$vetCampo['dt_final']   = CriaVetTabela('Data Final', 'data');
$vetCampo['pnu_nome_completo']    = CriaVetTabela('Consultor');

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