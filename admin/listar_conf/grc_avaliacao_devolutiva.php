<?php
$idCampo = 'idt';
$Tela = "a Devolutiva";



$TabelaPrinc      = "grc_avaliacao_devolutiva";
$AliasPric        = "grc_ad";
$Entidade         = "Devolutiva";
$Entidade_p       = "Devolutivas";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$tipoidentificacao = 'N';
$tipofiltro = 'S';

$comfiltro = 'A';
$comidentificacao = 'F';

$barra_inc_ap = false;
$barra_alt_ap = true;
$barra_exc_ap = false;
$barra_con_ap = false;

$sistema_origem = DecideSistema();
$vetGrupo=Array();
if ($sistema_origem=='GEC')
{
	$vetGrupo['GC'] ='Gestão de Credenciados';
}
else
{
	$vetGrupo['NAN']='Negócio a Negócio';
}

$Filtro = Array();
$Filtro['rs'] = $vetGrupo;
$Filtro['id'] = 'f_grupo';
$Filtro['nome'] = 'Grupo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['grupo'] = $Filtro;




$sql   = 'select ';
$sql  .= '   grc_av.idt,  ';
$sql  .= '   grc_a.protocolo,  ';
$sql  .= '   grc_a.data_inicio_atendimento  ';


$sql  .= ' from grc_atendimento grc_a ';
$sql  .= ' inner join grc_avaliacao grc_av on grc_av.idt_atendimento = grc_a.idt ';
$sql  .= " where grc_a.idt_grupo_atendimento is not null ";
$sql  .= ' order by grc_a.protocolo ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Protocolo da Visita';
//$Filtro['LinhaUm']  = '-- Todas --';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['idt_avaliacao'] = $Filtro;




$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//$orderby = "{$AliasPric}.codigo";

$vetCampo['grc_a_protocolo'] = CriaVetTabela('Protocolo<br />Visita');
$vetCampo['grc_a_nan_num_visita']    = CriaVetTabela('Número<br />Visita');
$vetCampo['grc_a_data_inicio_atendimento'] = CriaVetTabela('Data<br />Visita','data');
$vetCampo['data_versao']     = CriaVetTabela('Data Versão<br />Devolutiva','data');
$vetCampo['atual']           = CriaVetTabela('Atual<br />Devolutiva','descDominio',$vetSimNao);
$vetCampo['versao']          = CriaVetTabela('Versão<br />Devolutiva');
$vetCampo['observacao']      = CriaVetTabela('Observação<br />Devolutiva');
$vetCampo['codigo']          = CriaVetTabela('Código<br />Devolutiva');

$vetStatusDev=Array();
$vetStatusDev['CA']='Cadastrada';
$vetStatusDev['AV']='Em Avaliação';
$vetStatusDev['SB']='Substituida';
$vetStatusDev['AP']='Aprovada';
$vetCampo['status']         = CriaVetTabela('Status', 'descDominio', $vetStatusDev );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "   grc_a.nan_num_visita as  grc_a_nan_num_visita, ";
$sql  .= "   grc_a.protocolo as  grc_a_protocolo, ";
$sql  .= "   grc_a.data_inicio_atendimento as  grc_a_data_inicio_atendimento ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " left join grc_avaliacao grc_av on grc_av.idt = {$AliasPric}.idt_avaliacao ";
$sql  .= " left join grc_atendimento grc_a on grc_a.idt = grc_av.idt_atendimento ";


$sql  .= " where {$AliasPric}.grupo = ".aspa($vetFiltro['grupo']['valor']);

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower(grc_a.protocolo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
//$sql  .= " order by {$orderby}";

?>