<style type="text/css">
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
    }

    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        padding-top:10px;
    }

    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame_p {
        background:#FFFFFF;
        border:0px solid #FFFFFF;
    }

    div.class_titulo_p {
        background: #2F66B8;
        text-align: left;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        color     : #FFFFFF;
        text-align: left;
        height    : 20px;
        font-size : 12px;
        padding-top:5px;
    }

    div.class_titulo_p span {
        padding:10px;
        text-align: left;
    }

    div.class_titulo_p_barra {
        text-align: left;
        background: #c4c9cd;
        border    : none;
        color     : #FFFFFF;
        font-weight: bold;
        line-height: 12px;
        margin: 0;
        padding: 3px;
        padding-left: 20px;
    }

    fieldset.class_frame {
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }

    div.class_titulo {
        text-align: left;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo span {
        padding-left:10px;
    }

    div.class_titulo_c {
        text-align: center;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo_c span {
        padding-left:10px;
    }

    Select {
        border:0px;
        height:28px;
    }

    .TextoFixo {
        font-size:12px;
        text-align:left;
        border:0px;
        background:#ECF0F1;
        font-weight:normal;
        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;
    }

    td#idt_competencia_obj div {
        color:#FF0000;
    }

    .Tit_Campo {
        font-size:12px;
    }

    td.Titulo {
        color:#666666;
    }
    #idt_secao_obj {
        width:100%;
    }
    #idt_secao_tf {
        width:100%;
    }
	#idt_secao_dsc {
        width:100%;
    }
    #frm1 {
        width:100%;
    }

</style>
<?php
$tabela = 'grc_nan_devolutiva_item';
$id = 'idt';
$onSubmitDep = 'grc_nan_devolutiva_item_dep()';
$html = '';

if ($_GET['idCad'] != '') {
    $_GET['devolutiva_idt'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
    $idt_formulario = $_SESSION[CS]['objListarConf_vetID'][$_GET['session_cod']]['grc_formulario'];
    $html = '&nbsp;&nbsp;&nbsp;<a href="conteudo.php?prefixo=cadastro&menu=grc_avaliacao_resposta_ver&id='.$idt_formulario.'" target="ver_formulario"><img src="imagens/bt_print_16.png" />Ver Formulário</a>';
}
$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;

$vetCampo['idt_devolutiva'] = objFixoBanco('idt_devolutiva', '', 'grc_nan_devolutiva', 'idt', 'descricao', 'devolutiva_idt');
$vetCampo['codigo']    = objTexto('codigo', 'Ordem', True, 5);
$maxlength = 1000;
$style = "width:500px;";
$js = "";
$vetCampo['descricao'] = objTextArea('descricao', 'Descrição', false, $maxlength, $style, $js);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');

$vetTipoItem=Array();
$vetTipoItem['1']='Título e Texto Fixo';
$vetTipoItem['2']='Título e Include';
$vetTipoItem['3']='Título e Texto Fixo e Include';
$vetCampo['tipo']     = objCmbVetor('tipo', 'Tipo', True, $vetTipoItem,'');
$vetCampo['include'] = objTexto('include', 'Include', false, 45,120);

$vetCampo['width']    = objInteiro('width', 'Largura', false, 5);
$vetCampo['height']   = objInteiro('height', 'Altura', false, 5);

$vetCampo['background']    = objTexto('background', 'Cor do Fundo', false, 15,45);
$vetCampo['color']         = objTexto('color', 'Cor do Texto', false, 15,45);

$maxlength = 2000;
$style     = "width:700px;";
$js        = "";
//$vetCampo['detalhe'] = objTextArea('detalhe', 'Texto Fixo', false, $maxlength, $style, $js);

$vetCampo['detalhe'] = objHTML('detalhe', 'Texto Fixo', false,200);


$vetParametros = Array(
     'width' => '100%',
);

$vetFrm[] = Frame('<span>DEVOLUTIVA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_devolutiva']),
        ), $class_frame, $class_titulo, $titulo_na_linha,$vetParametros);

$vetFrm[] = Frame('<span>ITEM</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
//MesclarCol($vetCampo['detalhe'], 9);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['tipo'], '', $vetCampo['ativo']),
	Array($vetCampo['width'], '', $vetCampo['height'], '', $vetCampo['background'], '', $vetCampo['color']),
        ), $class_frame, $class_titulo, $titulo_na_linha);


$vetFrm[] = Frame('<span>PARÂMETROS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['include']),
	Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
/*
    function grc_formulario_pergunta_dep() {
	
        var qtd_pontos = parseFloat($('#qtd_pontos').val().replace(/\./gi, '').replace(',', '.'));
        var qtd_pontos_resto = parseFloat($('#qtd_pontos_resto').val().replace(/\./gi, '').replace(',', '.'));

        if (qtd_pontos > qtd_pontos_resto) {
            alert('A Qtd. Pontos não pode ser maior que a Qtd. Pontos Restante!');
            $('#qtd_pontos').focus();
            return false;
        }
  
        return true;
    }
	  */
</script>