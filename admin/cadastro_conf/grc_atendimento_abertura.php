<?php
$tabela = 'grc_atendimento_abertura';
$id = 'idt';

$idt_atendimento_abertura = $_GET['id'];

$TabelaPai   = "db_pir_grc.plu_usuario";
$AliasPai    = "grc_pu";
$EntidadePai = "Atendente";
$idPai       = "id_usuario";

$CampoPricPai     = "idt_usuario";

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'id_usuario', 'nome_completo', 0);
$vetCampo['protocolo']    = objAutonum('protocolo', 'Protocolo', 15, true);




echo "<div style='background:#0000FF; color:#FFFFFF; font-size:14px;'>";
echo "   {$_SESSION[CS]['gatdesc_idt_unidade_regional']}            <br /> ";
echo "   {$_SESSION[CS]['gatdesc_idt_natureza']}            <br /> ";
echo "   {$_SESSION[CS]['g_gestor_produto']}            <br /> ";
echo "   {$_SESSION[CS]['gatdesc_idt_projeto']}            <br /> ";
echo "   {$_SESSION[CS]['gatdesc_idt_acao']}            <br /> ";
echo "</div'>";

if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " grc_aa.*  ";
     $sql .= " from grc_atendimento_abertura grc_aa ";
     $sql .= " where idt = {$idt_atendimento_abertura} ";
     $rs = execsql($sql);
     $wcodigo = '';
     ForEach($rs->data as $row)
     {
         $situacao  = $row['situacao'];
     }
     if ($situacao=='Fechado')
     {
         $acao='con';
     }
}
else
{

     


}
// PA / box
$js    = " disabled='disabled' style='background:#FFFF80; font-size:14px;' ";
$sql  = "select idt, descricao from ".db_pir."sca_organizacao_secao ";
$sql .= " order by descricao";
$vetCampo['idt_unidade_regional'] = objCmbBanco('idt_unidade_regional', 'Ponto de Atendimento', true, $sql,' ','width:400px;',$js);

$sql  = "select idt, descricao from grc_atendimento_box ";
$sql .= " order by descricao";
$vetCampo['idt_atendimento_box'] = objCmbBanco('idt_atendimento_box', 'Guichê para Atendimento', true, $sql, ' ','width:400px;');

// projeto / açao

$sql  = "select idt, descricao from grc_projeto ";
$sql .= " order by descricao";
$vetCampo['idt_projeto'] = objCmbBanco('idt_projeto', 'Projeto', true, $sql,' ','width:400px;',$js);

$sql  = "select idt, descricao from grc_projeto_acao ";
$sql .= " order by descricao";
$vetCampo['idt_projeto_acao'] = objCmbBanco('idt_projeto_acao', 'Ação', true, $sql,' ','width:400px;',$js);


$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
//$style = " background:#FFFF80; ";

$vetCampo['dt_abertura'] = objDataHora('dt_abertura', 'Data Abertura', True,$js);

//$vetCampo['hr_abertura'] = objTexto('hr_abertura', 'Hora Abertura', True, 5, 5);
$vetCampo['dt_fechamento'] = objDataHora('dt_fechamento', 'Data Fechamento', False);
//$vetCampo['hr_fechamento'] = objTexto('hr_fechamento', 'Hora Fechamento', False, 5, 5);
// $vetCampo['situacao']     = objCmbVetor('situacao', 'Situação?', True, $vetAbertoFechado);
if ($acao=='inc')
{
    $js    = " readonly='true' style='color:#0000FF; background:#FFFF80; font-size:14px;' ";
}
else
{
    $js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
}
$vetCampo['situacao'] = objTexto('situacao', 'Situação', false, 15, 15, $js );


//$vetCampo['confirmacao_abertura'] = objInclude('confirmacao_abertura', 'cadastro_conf/confirmacao_abertura.php');

$vetCampo['confirmacao_fechamento'] = objInclude('confirmacao_fechamento', 'cadastro_conf/confirmacao_fechamento.php');


$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);

$vetFrm = Array();
$vetFrm[] = Frame('<span>Usuário</span>', Array(
    Array($vetCampo[$CampoPricPai],'',$vetCampo['protocolo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Dados Básicos</span>', Array(
//    Array($vetCampo['confirmacao_abertura'],'',$vetCampo['dt_abertura'],'',$vetCampo['dt_fechamento'],'',$vetCampo['confirmacao_fechamento'],'',$vetCampo['situacao']),
    Array($vetCampo['dt_abertura'],'',$vetCampo['confirmacao_fechamento'],'',$vetCampo['dt_fechamento'],'',$vetCampo['situacao']),

),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Unidade Regional</span>', Array(
    Array($vetCampo['idt_unidade_regional'],'',$vetCampo['idt_atendimento_box']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Projeto/Ação</span>', Array(
    Array($vetCampo['idt_projeto'],'',$vetCampo['idt_projeto_acao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observação</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>