<?php
$idCampo = 'idt';
$Tela = "as Gerações dos Painéis";

$TabelaPrinc      = "grc_atendimento_gera_painel";
$AliasPric        = "grc_aga";
$Entidade         = "Geração Painel";
$Entidade_p       = "Gerações Painel";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";


$barra_exc_ap = false;


/*$sql   = 'select ';
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
$vetFiltro['usuario'] = $Filtro;  */


$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;


    $comfiltro = 'A';
    $comidentificacao = 'A';

$orderby = "dt_geracao";

$vetCampo['pu_nome_completo'] = CriaVetTabela('Consultor');
$vetCampo['dt_geracao']       = CriaVetTabela('Data Geração', 'data');
$vetCampo['dt_base']          = CriaVetTabela('Data Base', 'data');
$vetCampo['executa']          = CriaVetTabela('Executa?');


$sql   = "select ";
$sql  .= "   {$AliasPric}.*, pu.nome_completo as pu_nome_completo  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join plu_usuario as pu on pu.id_usuario = .{$AliasPric}.idt_usuario ";


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
