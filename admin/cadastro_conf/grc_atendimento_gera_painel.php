<?php
$tabela = 'grc_atendimento_gera_painel';
$id = 'idt';

$idt_atendimento_gera_painel = $_GET['id'];

//$TabelaPai   = "db_pir_grc.plu_usuario";
//$AliasPai    = "grc_pu";
//$EntidadePai = "Atendente";
//$idPai       = "id_usuario";

//$CampoPricPai     = "idt_usuario";

//$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'id_usuario', 'nome_completo', 0);

echo "<div style='background:#0000FF; color:#FFFFFF; font-size:14px;'>";
echo "   {$_SESSION[CS]['gatdesc_idt_unidade_regional']}            <br /> ";
echo "   {$_SESSION[CS]['gatdesc_idt_natureza']}            <br /> ";
echo "   {$_SESSION[CS]['g_gestor_produto']}            <br /> ";
echo "   {$_SESSION[CS]['gatdesc_idt_projeto']}            <br /> ";
echo "   {$_SESSION[CS]['gatdesc_idt_acao']}            <br /> ";
echo "</div'>";


$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
//$style = " background:#FFFF80; ";

$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['dt_geracao'] = objDataHora('dt_geracao', 'Data Geração', True,$js);
$vetCampo['dt_base'] = objData('dt_base', 'Data Base', True);

$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Usuário', true, $sql,' ','width:400px;');


if ($acao=='inc')
{
    $js    = " readonly='true' style='color:#0000FF; background:#FFFF80; font-size:14px;' ";
}
else
{
    $js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
}

$vetCampo['botao_atendimento_gera_painel'] = objInclude('botao_atendimento_gera_painel', 'cadastro_conf/botao_atendimento_gera_painel.php');


$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);

$vetCampo['executa']     = objCmbVetor('executa', 'Executa ?', True, $vetPainel);

$vetFrm = Array();

$vetFrm[] = Frame('<span>Consultor</span>', Array(
    Array($vetCampo['idt_usuario']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Dados Básicos</span>', Array(
//  Array($vetCampo['dt_geracao'],'',$vetCampo['dt_base'],'',$vetCampo['botao_atendimento_gera_painel']),
    Array($vetCampo['dt_geracao'],'',$vetCampo['dt_base'],'',$vetCampo['executa']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observação</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>
