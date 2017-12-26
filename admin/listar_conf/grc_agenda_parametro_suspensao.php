<?php
$idCampo = 'idt';
$Tela = "a Suspensão do Agendamento";
//
$TabelaPai   = "grc_agenda_parametro";
$AliasPai    = "grc_ap";
$EntidadePai = "Parâmetros do Agendamento";
$idPai       = "idt";
//
$TabelaPrinc      = "grc_agenda_parametro_suspensao";
$AliasPric        = "grc_aps";
$Entidade         = "Suspensão do Agendamento";
$Entidade_p       = "Suspensões do Agendamento";
$CampoPricPai     = "idt_parametro";


$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';


$orderby = "";

//$sql_orderby=Array();




$sql = 'select ';
$sql .= '   idt, descricao  ';
$sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
$sql .= ' order by classificacao ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']        = $rs;
$Filtro['id']        = 'filtro_ponto_atendimento';
$Filtro['id_select'] = 'idt';
$Filtro['js_tam']    = '0';
$Filtro['LinhaUm']   = '-- Todos os PAs --';
$Filtro['nome'] = 'Pontos de Atendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_ponto_atendimento'] = $Filtro;



$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_ini';
$Filtro['vlPadrao'] = Date('d/m/Y');
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data Inicial';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_ini'] = $Filtro;
//p($Filtro);

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_fim';
$Filtro['vlPadrao']  = Date('d/m/Y', strtotime('+45 day'));
//$Filtro['vlPadrao'] = Date('d/m/Y');
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data Final';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_fim'] = $Filtro;




//
$Filtro = Array();
//$Filtro['campo']        = 'descricao';
//$Filtro['tabela']       = $TabelaPai;
$Filtro['id']             = 'idt';
$Filtro['nome']           = $EntidadePai;
//$Filtro['valor']        = trata_id($Filtro);
$Filtro['valor']          = 1;
$vetFiltro[$CampoPricPai] = $Filtro;
//
$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//
$dt_iniw  = trata_data($vetFiltro['dt_ini']['valor']);
$dt_fimw  = trata_data($vetFiltro['dt_fim']['valor']);
//
$vetCampo = Array();
$vetCampo['ponto_atendimento'] = CriaVetTabela('Ponto Atendimento');
$vetCampo['data']              = CriaVetTabela('Data','data');
$vetCampo['observacao']        = CriaVetTabela('Observação');
$titulo = 'Suspensão';
$TabelaPrinc      = "grc_agenda_parametro_suspensao";
$AliasPric        = "grc_aps";
$Entidade         = "Suspensão  do Parâmetro ";
$Entidade_p       = "Suspensões do Parâmetro ";
// Select para obter campos da tabela que serão utilizados no full
$orderby = "sca_os.descricao, {$AliasPric}.data  ";
$sql  = "select {$AliasPric}.*, ";
$sql .= "       sca_os.descricao as ponto_atendimento ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join ".db_pir."sca_organizacao_secao sca_os on  sca_os.idt = {$AliasPric}.idt_ponto_atendimento";
$sql .= " where {$AliasPric}".'.idt_parametro = 1 ';
if ($vetFiltro['idt_ponto_atendimento']['valor']!='' and $vetFiltro['idt_ponto_atendimento']['valor']!='-1')
{
	$sql .= "   and {$AliasPric}".'.idt_ponto_atendimento = '.null($vetFiltro['idt_ponto_atendimento']['valor']);
}
$sql .= "   and {$AliasPric}.data >= ".aspa($dt_iniw)." and {$AliasPric}.data <=  ".aspa($dt_fimw)." ";
if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.observacao)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    //$sql .= ' or lower('.$AliasPric.'.observacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}




?>