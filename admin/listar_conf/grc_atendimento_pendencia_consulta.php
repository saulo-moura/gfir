<?php
$idCampo = 'idt';
$Tela = "as Pendências do Atendimento";

$contlinfim = "Existem #qt Pendências.";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$barra_inc_ap = false;
$barra_alt_ap = true;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;

//If ($_SESSION[CS]['grc_atendimento_pendencia_consulta']!="")
//{
   //$_POST=$_SESSION[CS]['grc_atendimento_pendencia_consulta'];
 //  $_REQUEST=$_SESSION[CS]['grc_atendimento_pendencia_consulta'];
 //  $_SESSION[CS]['grc_atendimento_pendencia_consulta']="";
   //p($_POST);
//}
if ($_GET['RETNI'] == 'S')
{
    $_GET['RETNI']="";
    $_REQUEST=$_SESSION[CS]['grc_atendimento_pendencia_consulta'];
}
else
{
    $_SESSION[CS]['grc_atendimento_pendencia_consulta']=$_REQUEST;
}




$vetstatusP=Array();
$vetstatusP['A'] ='Abertos';
$vetstatusP['F'] ='Fechados';
$vetstatusP['T'] ='Todos';
$Filtro = Array();
$Filtro['rs'] = $vetstatusP;
$Filtro['id'] = 'filtro_statusP';
//$Filtro['LinhaUm'] = ' -- Todos --  ';;
$Filtro['nome'] = 'Status da Pendência';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_statusP'] = $Filtro;









$vetTipoPendencia=Array();
$vetTipoPendencia['AT0'] ='Atendimento - Balcão';
$vetTipoPendencia['NAN'] ='Atendimento - NAN';
$vetTipoPendencia['ATD']='Atendimento - Distância (Central)';
$vetTipoPendencia['MAT'] ='Atendimento - Inscrição em Evento';
$vetTipoPendencia['EV'] ='Evento';
$Filtro = Array();
$Filtro['rs'] = $vetTipoPendencia;
$Filtro['id'] = 'filtro_tipo';
$Filtro['LinhaUm'] = ' -- Todos --  ';;
$Filtro['nome'] = 'Tipo de Pendência';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_tipo'] = $Filtro;


$Filtro = Array();
$sql = "select distinct plu_u.id_usuario, plu_u.nome_completo ";
$sql .= " from grc_atendimento_pendencia grc_ap  ";
$sql .= " inner join plu_usuario plu_u on plu_u.id_usuario = grc_ap.idt_usuario ";
$sql .= " where grc_ap.ativo = 'S'";
$sql .= ' order by plu_u.nome_completo';
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_solicitante';
$Filtro['id_select'] = 'id_usuario';
$Filtro['LinhaUm'] = ' -- Todos --  ';;
$Filtro['nome'] = 'Solicitante';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_solicitante'] = $Filtro;

$Filtro = Array();
$sql = "select distinct plu_u.id_usuario, plu_u.nome_completo ";
$sql .= " from grc_atendimento_pendencia grc_ap  ";
$sql .= " inner join plu_usuario plu_u on plu_u.id_usuario = grc_ap.idt_responsavel_solucao ";
$sql .= " where grc_ap.ativo = 'S'";
$sql .= ' order by plu_u.nome_completo';
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_tutor';
$Filtro['id_select'] = 'id_usuario';
$Filtro['LinhaUm'] = ' -- Todos --  ';
$Filtro['nome'] = 'Responsável pela Pendência';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_tutor'] = $Filtro;




$Filtro = Array();
$sql = "select idt, descricao from grc_atendimento_instrumento";
$sql .= " where idt_atendimento_instrumento is not null ";
$sql .= " order by idt_atendimento_instrumento";
$rs = execsql($sql);
$Filtro['rs'] = $rs;
$Filtro['id'] = 'filtro_idt_instrumento';
$Filtro['id_select'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Instrumentos';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_instrumento'] = $Filtro;



/*

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from '.db_pir.'sca_organizacao_secao';
// $sql .= " where posto_atendimento <> 'S' ";
$sql .= " where tipo_estrutura = 'UR' ";
$sql .= ' order by classificacao';

$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'filtro_unidade';
$Filtro['id_select'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm']   = '-- Todas --';
$Filtro['nome'] = 'Unidades do Sebrae';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['unidade_sebrae'] = $Filtro;



$sql = 'select ';
$sql .= '   idt, descricao  ';
$sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
$sql .= ' order by classificacao ';
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'filtro_ponto_atendimento';
$Filtro['id_select'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm']  = '-- Todos --';
$Filtro['nome']  = 'Pontos de Atendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;
*/
$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from '.db_pir.'sca_organizacao_secao';
//$sql .= " where posto_atendimento <> 'S' ";
$sql .= " where tipo_estrutura = 'UR' ";
$sql .= ' order by classificacao';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Unidade';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_unidade'] = $Filtro;
if ($vetFiltro['idt_unidade']['valor']>0)
{
	$sql = "select idt,  descricao from ".db_pir."sca_organizacao_secao ";
	//$sql .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S')";
	$sql .= ' where SUBSTRING(classificacao, 1, 5) = ('; //and
	$sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
	$sql .= ' from '.db_pir.'sca_organizacao_secao';
	$sql .= ' where idt = '.null($vetFiltro['idt_unidade']['valor']);
	$sql .= ' )';
	$sql .= ' and idt <> '.null($vetFiltro['idt_unidade']['valor']);
	$sql .= ' order by classificacao ';
}
else
{
	$sql = 'select ';
	$sql .= '   idt, descricao  ';
	$sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
	$sql .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
	$sql .= ' order by classificacao ';
}
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Ponto de Atendimento';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_ponto_atendimento_tela'] = $Filtro;

/*
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_ini';
//$Filtro['vlPadrao'] = Date('d/m/Y');
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data Inicial para Solução ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_ini'] = $Filtro;
//p($Filtro);
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_fim';
//$Filtro['vlPadrao']  = Date('d/m/Y', strtotime('+45 day'));
//$Filtro['vlPadrao'] = Date('d/m/Y');
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data Final para Solução';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_fim'] = $Filtro;
*/

$Filtro = Array();
$Filtro['rs'] = 'Intervalo';
$Filtro['id'] = 'pendencia';
$Filtro['nome'] = 'Período da Solução';
$Filtro['js'] = 'data';
//$Filtro['vlPadrao_ini'] = Date('d/m/Y');
//$Filtro['vlPadrao_fim'] = Date('d/m/Y');
$Filtro['valor_ini'] = trata_id($Filtro, '_ini');
$Filtro['valor_fim'] = trata_id($Filtro, '_fim');
$vetFiltro['pendencia'] = $Filtro;









$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto Geral';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//p($_GET);
//p($_POST);
//$_SESSION[CS]['grc_atendimento_pendencia_consulta']=$_REQUEST;
$vetCampo['plu_us_nome_completo'] = CriaVetTabela('Responsável pela Pendência');
$vetCampo['protocolo'] = CriaVetTabela('Código');
$vetCampo['data'] = CriaVetTabela('Data de Abertura', 'data');
$vetCampo['plu_u_nome_completo'] = CriaVetTabela('Solicitante');
$vetCampo['tipo'] = CriaVetTabela('Tipo');
$vetCampo['status'] = CriaVetTabela('Status');
$vetCampo['observacao'] = CriaVetTabela('Assunto');
$vetCampo['data_solucao'] = CriaVetTabela('Data para Solução', 'data');
$sql = "select grc_ap.*, ";
$sql .= "       grc_a.protocolo as grc_a_protocolo, ";
$sql .= "       plu_u.nome_completo as plu_u_nome_completo, ";
$sql .= "       plu_us.nome_completo as plu_us_nome_completo ";
$sql .= " from grc_atendimento_pendencia grc_ap  ";
$sql .= " left outer join plu_usuario plu_u  on plu_u.id_usuario = grc_ap.idt_usuario ";
$sql .= " left outer join grc_atendimento grc_a  on grc_a.idt = grc_ap.idt_atendimento ";
$sql .= " left outer join plu_usuario plu_us on plu_us.id_usuario = grc_ap.idt_responsavel_solucao ";

if ($vetFiltro['filtro_statusP']['valor'] != "T")
{
	if ($vetFiltro['filtro_statusP']['valor'] == "A")
	{
		$sql .= " where grc_ap.ativo = 'S'";
	}
	else
	{
		$sql .= " where grc_ap.ativo = 'N'";
	}
}
else
{
    $sql .= " where 1 = 1 ";

}
//if ($vetFiltro['dt_ini']['valor'] != "" and $vetFiltro['dt_fim']['valor'] !="" ) {

if ($vetFiltro['pendencia']['valor_ini'] != "" and $vetFiltro['pendencia']['valor_fim'] !="" ) {
	//$dt_iniw = trata_data($vetFiltro['dt_ini']['valor']);
	//$dt_fimw = trata_data($vetFiltro['dt_fim']['valor']);
	
	$dt_iniw = trata_data($vetFiltro['pendencia']['valor_ini']);
    $dt_fimw = trata_data($vetFiltro['pendencia']['valor_fim']);

	
    $sql .= " and (grc_ap.data_solucao >= ".aspa($dt_iniw)." and grc_ap.data_solucao <=  ".aspa($dt_fimw)." ) ";
}


if ($vetFiltro['idt_instrumento']['valor'] > 0) {
    $sql .= " and grc_a.idt_instrumento = ".null($vetFiltro['idt_instrumento']['valor']);
}


if ($vetFiltro['f_tutor']['valor'] > 0) {
    $sql .= " and grc_ap.idt_responsavel_solucao = ".null($vetFiltro['f_tutor']['valor']);
}
if ($vetFiltro['f_solicitante']['valor'] > 0) {
    $sql .= " and grc_ap.idt_usuario = ".null($vetFiltro['f_solicitante']['valor']);
}
if ($vetFiltro['filtro_tipo']['valor'] != "" and $vetFiltro['filtro_tipo']['valor'] != '0' ) {
    $string_t =  $vetFiltro['filtro_tipo']['valor'];
	
	$tam      =  strlen($string_t);
    $sql .= " and substring(grc_ap.protocolo,1,{$tam}) = ".aspa($string_t);
}
if ($vetFiltro['idt_unidade']['valor'] > 0) {
    //$sql .= " and grc_ap.idt_responsavel_solucao = ".null($vetFiltro['idt_unidade']['valor']);
}
if ($vetFiltro['idt_ponto_atendimento_tela']['valor'] > 0) {
    $sql .= " and grc_ap.idt_ponto_atendimento = ".null($vetFiltro['idt_ponto_atendimento_tela']['valor']);
}
if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower(grc_ap.observacao)   like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= '  or lower(grc_ap.assunto)   like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= '  or lower(grc_ap.protocolo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
?>
<script type="text/javascript">
$(document).ready(function () {
        $("#idt5").cascade("#idt4", {
            ajax: {
                url: ajax_sistema + '?tipo=pa_unidade_consulta&cas=' + conteudo_abrir_sistema
            }
        });
    });
</script>