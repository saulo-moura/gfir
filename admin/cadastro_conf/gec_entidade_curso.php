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
$TabelaPrinc      = "gec_entidade_curso";
$AliasPric        = "gec_ec";
$Entidade         = "Curso da Pessoa";
$Entidade_p       = "Cursos da Pessoa";
$CampoPricPai     = "idt_entidade";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai]   = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);
$vetCampo['titulo_curso']  = objTexto('titulo_curso', 'Título', True, 45, 120);
$vetCampo['nome_entidade'] = objTexto('nome_entidade', 'Entidade Executora', True, 45, 120);
$sql = "select idt, descricao from plu_pais order by codigo";
$vetCampo['idt_pais'] = objCmbBanco('idt_pais', 'País', true, $sql,' ','width:380px;');
$vetCampo['cidade_estado'] = objTexto('cidade_estado', 'Cidade/Estado', True, 45, 120);
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observação', false, $maxlength, $style, $js);
//
$vetCampo['ano_conclusao'] = objCmbVetor('ano_conclusao', 'Ano Conclusão', True, $vetAno, '');


$vetCampo['carga_horaria'] = objDecimal('carga_horaria', 'Carga Horária', true, 10 );



$veio = $_SESSION[CS][$TabelaPai]['veio'];
//
    $vetFrm = Array();
    $vetFrm[] = Frame('<span>Entidade</span>', Array(
        Array($vetCampo[$CampoPricPai]),
    ),$class_frame,$class_titulo,$titulo_na_linha);

    //  MesclarCol($vetCampo['logradouro_pais'], 5);

    $vetFrm[] = Frame('<span>Curso</span>', Array(
        Array($vetCampo['titulo_curso'],'',$vetCampo['ano_conclusao']),
    ),$class_frame,$class_titulo,$titulo_na_linha);

    $vetFrm[] = Frame('<span>Execução</span>', Array(
        Array($vetCampo['nome_entidade'],'',$vetCampo['carga_horaria']),
        Array($vetCampo['idt_pais'],'',$vetCampo['cidade_estado']),
    ),$class_frame,$class_titulo,$titulo_na_linha);

    $vetFrm[] = Frame('<span>Observação</span>', Array(
        Array($vetCampo['detalhe']),
    ),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>