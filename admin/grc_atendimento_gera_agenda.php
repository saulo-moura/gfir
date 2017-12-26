<?php
$tabela = 'grc_atendimento_gera_agenda';
$id = 'idt';

$disponibilidade = $_GET['disponibilidade'];
if ($disponibilidade==S)
{
    $_GET['idt0']=$_SESSION[CS]['g_idt_unidade_regional'];
}
$idt_atendimento_gera_agenda = $_GET['id'];

//$TabelaPai   = "db_pir_grc.plu_usuario";
//$AliasPai    = "grc_pu";
//$EntidadePai = "Atendente";
//$idPai       = "id_usuario";

//$CampoPricPai     = "idt_usuario";

//$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'id_usuario', 'nome_completo', 0);



/*
echo "<div style='background:#0000FF; color:#FFFFFF; font-size:14px;'>";
//echo "   {$_SESSION[CS]['gatdesc_idt_unidade_regional']}            <br /> ";
//echo "   {$_SESSION[CS]['gatdesc_idt_natureza']}            <br /> ";
echo "   {$_SESSION[CS]['gatdesc_idt_projeto']}            <br /> ";
echo "   {$_SESSION[CS]['gatdesc_idt_acao']}            <br /> ";
//echo "   {$_SESSION[CS]['g_gestor_produto']}            <br /> ";
echo "</div'>";
*/


$TabelaPai   = "".db_pir."sca_organizacao_secao";
$AliasPai    = "grc_os";
$EntidadePai = "Ponto de Atendimento";
$idPai       = "idt";

$CampoPricPai     = "idt_ponto_atendimento";

$idt_ponto_atendimento = $_GET['idt0'];
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, $idPai, 'descricao', 0);


$js    = " disabled  style='xvisibility:hidden; background:#FFFF80; font-size:14px;' ";
$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= ' where id_usuario = '.null($_SESSION[CS]['g_id_usuario']);
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Usuario', true, $sql,'','width:400px;',$js);

$js    = " readonly='true' style='xvisibility:hidden; background:#FFFF80; font-size:14px;' ";
$vetCampo['dt_geracao'] = objDataHora('dt_geracao', 'Data Geração', True,$js);

$js    = '';
$vetCampo['dt_inicial'] = objData('dt_inicial', 'Data Inicial', True,$js,'','S');
$vetCampo['dt_final'] = objData('dt_final', 'Data Final', True,$js,'','S');


if ($disponibilidade==S)
{
    $sql  = "select plu_us.id_usuario, plu_us.nome_completo from grc_atendimento_pa_pessoa grc_app ";
    $sql .= ' inner join plu_usuario plu_us on plu_us.id_usuario = grc_app.idt_usuario ';
    $sql .= ' where grc_app.idt_ponto_atendimento = '.null($idt_ponto_atendimento);
    $sql .= '   and plu_us.id_usuario             = '.null($_SESSION[CS]['g_id_usuario']);
    $sql .= " order by plu_us.nome_completo";
    $jsm = " disabled='disabled' style='background:#FFFF80; font-size:14px; width:400px;' ";

    $vetCampo['idt_consultor'] = objCmbBanco('idt_consultor', 'Consultor/Atendente', false, $sql,'','' ,$jsm);
}
else
{
    $sql  = "select plu_us.id_usuario, plu_us.nome_completo from grc_atendimento_pa_pessoa grc_app ";
    $sql .= ' inner join plu_usuario plu_us on plu_us.id_usuario = grc_app.idt_usuario ';
    $sql .= ' where grc_app.idt_ponto_atendimento = '.null($idt_ponto_atendimento);
    $sql .= " order by plu_us.nome_completo";
    $vetCampo['idt_consultor'] = objCmbBanco('idt_consultor', 'Consultor', false, $sql,'Gera agenda de todos os consultores','width:400px;');
}

if ($acao=='inc')
{
    $js    = " readonly='true' style='color:#0000FF; background:#FFFF80; font-size:14px;' ";
}
else
{
    $js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
}

$vetCampo['botao_atendimento_gera_agenda'] = objInclude('botao_atendimento_gera_agenda', 'cadastro_conf/botao_atendimento_gera_agenda.php');


$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);

$vetCampo['executa']    = objCmbVetor('executa', 'O que deseja executar para o <b>Intervalo de datas informado</b>?', True, $vetAgenda, 'Nada');


$vetFrm = Array();


MesclarCol($vetCampo[$CampoPricPai], 5);
MesclarCol($vetCampo['idt_consultor'], 5);
MesclarCol($vetCampo['observacao'], 5);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['idt_consultor']),
    Array($vetCampo['dt_inicial'],'',$vetCampo['dt_final'],'',$vetCampo['executa']),
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Controle</span>', Array(
    Array($vetCampo['idt_usuario'],'',$vetCampo['dt_geracao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
