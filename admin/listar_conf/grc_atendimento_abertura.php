<?php
$idCampo = 'idt';
$Tela = "as Aberturas";

$TabelaPrinc      = "grc_atendimento_abertura";
$AliasPric        = "grc_aa";
$Entidade         = "Abertura do Usuário";
$Entidade_p       = "Aberturas do Usuário";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";


$barra_exc_ap = false;


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
$Filtro['nome']     = 'Usuário';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['usuario'] = $Filtro;


$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;


    $comfiltro = 'A';
    $comidentificacao = 'A';

$orderby = "dt_abertura, hr_abertura";

$vetCampo['pu_nome_completo']    = CriaVetTabela('Atendente');
$vetCampo['protocolo']    = CriaVetTabela('Protocolo');
//$vetCampo['gae_descricao'] = CriaVetTabela('Especialidade');
$vetCampo['dt_abertura']   = CriaVetTabela('Data Abertura', 'data');
//$vetCampo['hr_abertura']   = CriaVetTabela('Hora Abertura');
$vetCampo['dt_fechamento'] = CriaVetTabela('Data Fechamento', 'data');
//$vetCampo['hr_fechamento'] = CriaVetTabela('Hora Fechamento');
$vetCampo['situacao']     = CriaVetTabela('Situação', 'descDominio', $vetAbertoFechado );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*, pu.nome_completo as pu_nome_completo  ";
//$sql  .= "   gae.descricao as gae_descricao  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join plu_usuario as pu on pu.id_usuario = .{$AliasPric}.idt_usuario ";
//$sql  .= " inner join grc_atendimento_especialidade as gae on gae.idt = .{$AliasPric}.idt_atendimento_especialidade ";


$sql .= ' where ';
$sql .= " {$AliasPric}.idt_usuario =  ".null($vetFiltro['usuario']['valor']);


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
        $sqlOrderby = 'dt_abertura desc ';
}

?>