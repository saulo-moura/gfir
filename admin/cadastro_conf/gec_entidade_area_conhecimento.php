<?php
if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$TabelaPai   = "gec_entidade";
$AliasPai    = "gec_en";
$EntidadePai = "Entidade";
$idPai       = "idt";

//
$TabelaPrinc      = "gec_entidade_area_conhecimento";
$AliasPric        = "gec_eac";
$Entidade         = "�rea de Conhecimento da Entidade";
$Entidade_p       = "�rea de Conhecimentos  da Entidade";
$CampoPricPai     = "idt_entidade";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


$sql = "select idt, descricao from gec_area_conhecimento order by codigo";
$vetCampo['idt_area_conhecimento'] = objCmbBanco('idt_area_conhecimento', '�rea de Conhecimento', true, $sql,' ','width:380px;');


$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observa��o', false, $maxlength, $style, $js);




$veio = $_SESSION[CS][$TabelaPai]['veio'];
//
if ($veio=="O")
{
    $vetFrm = Array();
    $vetFrm[] = Frame('<span>Entidade</span>', Array(
        Array($vetCampo[$CampoPricPai]),
    ),$class_frame,$class_titulo,$titulo_na_linha);

  //  MesclarCol($vetCampo['logradouro_pais'], 5);

    $vetFrm[] = Frame('<span>�rea de Conhecimento</span>', Array(
        Array($vetCampo['idt_area_conhecimento']),
    ),$class_frame,$class_titulo,$titulo_na_linha);


    $vetFrm[] = Frame('<span>Observa��o</span>', Array(
        Array($vetCampo['observacao']),
    ),$class_frame,$class_titulo,$titulo_na_linha);
}
else
{
    if ($veio=="P")
    {
            $vetFrm = Array();
    $vetFrm[] = Frame('<span>Pessoa</span>', Array(
        Array($vetCampo[$CampoPricPai]),
    ),$class_frame,$class_titulo,$titulo_na_linha);

  //  MesclarCol($vetCampo['logradouro_pais'], 5);

    $vetFrm[] = Frame('<span>�rea de Conhecimento</span>', Array(
        Array($vetCampo['idt_area_conhecimento']),
    ),$class_frame,$class_titulo,$titulo_na_linha);


    $vetFrm[] = Frame('<span>Observa��o</span>', Array(
        Array($vetCampo['observacao']),
    ),$class_frame,$class_titulo,$titulo_na_linha);

    }
    else
    {

    }
}


$vetCad[] = $vetFrm;
?>