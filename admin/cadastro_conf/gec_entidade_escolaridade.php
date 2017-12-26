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
$TabelaPrinc      = "gec_entidade_escolaridade";
$AliasPric        = "gec_ee";
$Entidade         = "Escolaridade da Pessoa";
$Entidade_p       = "Escolaridade da Pessoa";
$CampoPricPai     = "idt_entidade";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai]   = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


$vetCampo['nome_entidade'] = objTexto('nome_entidade', 'Entidade Executora', True, 45, 120);
$sql = "select idt, descricao from plu_pais order by codigo";
$vetCampo['idt_pais'] = objCmbBanco('idt_pais', 'País', true, $sql,' ','width:380px;');
$sql = "select idt, descricao from gec_entidade_grau_formacao order by codigo";
$vetCampo['idt_grau_formacao'] = objCmbBanco('idt_grau_formacao', 'Grau de formação', true, $sql,' ','width:380px;');
$sql = "select idt, descricao from gec_entidade_curso_formacao order by codigo";
$vetCampo['idt_curso_formacao'] = objCmbBanco('idt_curso_formacao', 'Grau de formação', true, $sql,' ','width:380px;');


$vetCampo['cidade_estado'] = objTexto('cidade_estado', 'Cidade/Estado', True, 45, 120);
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observação', false, $maxlength, $style, $js);
//
$vetCampo['ano_conclusao'] = objCmbVetor('ano_conclusao', 'Ano Conclusão', True, $vetAno, '');



$veio = $_SESSION[CS][$TabelaPai]['veio'];
//
    $vetFrm = Array();
    $vetFrm[] = Frame('<span>Entidade</span>', Array(
        Array($vetCampo[$CampoPricPai]),
    ),$class_frame,$class_titulo,$titulo_na_linha);

    //  MesclarCol($vetCampo['logradouro_pais'], 5);

    $vetFrm[] = Frame('<span>Escolaridade</span>', Array(
        Array($vetCampo['idt_grau_formacao']),
        Array($vetCampo['idt_curso_formacao']),
    ),$class_frame,$class_titulo,$titulo_na_linha);


    MesclarCol($vetCampo['nome_entidade'], 3);

    $vetFrm[] = Frame('<span>Execução</span>', Array(
        Array($vetCampo['nome_entidade']),
        Array($vetCampo['idt_pais'],'',$vetCampo['cidade_estado']),
    ),$class_frame,$class_titulo,$titulo_na_linha);

    $vetFrm[] = Frame('<span>Observação</span>', Array(
        Array($vetCampo['detalhe']),
    ),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>