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
$TabelaPrinc      = "gec_entidade_entidade";
$AliasPric        = "gec_ene";
$Entidade         = "Relacionamento da Entidade";
$Entidade_p       = "Relacionamentos da Entidade";
$CampoPricPai     = "idt_entidade";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$sql = "select idt, descricao from gec_entidade_relacao order by codigo";
$vetCampo['idt_entidade_relacao'] = objCmbBanco('idt_entidade_relacao', 'Tipo Relação', true, $sql,' ','width:380px;');


$sql = "select idt, descricao from gec_entidade order by codigo";
$vetCampo['idt_entidade_relacionada'] = objCmbBanco('idt_entidade_relacionada', 'Entidade Relacionada', true, $sql,' ','width:380px;');



$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');

$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);



$vetCampo['data_inicio'] = objData('data_inicio', 'Data Inicio Relação', true);
$vetCampo['data_termino'] = objData('data_termino', 'Data Término Relação', False);



$veio = $_SESSION[CS][$TabelaPai]['veio'];
//
if ($veio=="O")
{
    $vetFrm = Array();
    $vetFrm[] = Frame('<span>Entidade</span>', Array(
        Array($vetCampo[$CampoPricPai]),
    ),$class_frame,$class_titulo,$titulo_na_linha);

  //  MesclarCol($vetCampo['logradouro_pais'], 5);

    $vetFrm[] = Frame('<span>Organização Relacionada com:</span>', Array(
        Array($vetCampo['idt_entidade_relacionada'],'',$vetCampo['idt_entidade_relacao']),
    ),$class_frame,$class_titulo,$titulo_na_linha);


    $vetFrm[] = Frame('<span>Período</span>', Array(
        Array($vetCampo['ativo'],'',$vetCampo['data_inicio'],'',$vetCampo['data_termino']),
    ),$class_frame,$class_titulo,$titulo_na_linha);



    $vetFrm[] = Frame('<span>Observação</span>', Array(
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

        $vetFrm[] = Frame('<span>Pessoa Relacionada com:</span>', Array(
            Array($vetCampo['idt_entidade_relacionada'],'',$vetCampo['idt_entidade_relacao']),
        ),$class_frame,$class_titulo,$titulo_na_linha);

    $vetFrm[] = Frame('<span>Período</span>', Array(
        Array($vetCampo['ativo'],'',$vetCampo['data_inicio'],'',$vetCampo['data_termino']),
    ),$class_frame,$class_titulo,$titulo_na_linha);


        $vetFrm[] = Frame('<span>Observação</span>', Array(
            Array($vetCampo['observacao']),
        ),$class_frame,$class_titulo,$titulo_na_linha);
    }
    else
    {

    }
}


$vetCad[] = $vetFrm;
?>