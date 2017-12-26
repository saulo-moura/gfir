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

</style>
<?php
$tabela      = 'grc_formulario_resposta'; 
$id          = 'idt';
$html = '';

if ($_GET['idCad'] != '') {
    $_GET['pergunta_idt'] = $_GET['idCad'];
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


$sistema_origem = DecideSistema();
$mede  = $_GET['mede'];
$grupo = "";

$vetGrupo=Array();
if ($sistema_origem=='GEC')
{
	$vetGrupo['GC'] ='Gestão de Credenciados';
	$onSubmitDep = 'grc_formulario_secao_dep()';
	$grupo = "GC";

}
else
{
	if ($mede!='S')
	{
	    $vetGrupo['NAN']='Negócio a Negócio';
		$grupo = "NAN";
	}
    else
    {
	    $vetGrupo['MEDE']='MEDE';
		$grupo = "MEDE";
		
    }
}


$vetParametros = Array(
    'codigo_pai' => 'parte01',
);




$vetCampo['idt_pergunta'] = objFixoBanco('idt_pergunta', '', 'grc_formulario_pergunta', 'idt', 'descricao', 'pergunta_idt');
$vetCampo['codigo']       = objInteiro('codigo', 'Ordem', True, 5);
//$vetCampo['descricao']    = objTexto('descricao', 'Descrição', True, 40, 1000);
$vetCampo['qtd_pontos']   = objInteiro('qtd_pontos', 'Qtd. Pontos', True, 9);


$maxlength = 1000;
$style = "width:500px;";
$js = "";
$vetCampo['descricao'] = objTextArea('descricao', 'Descrição', false, $maxlength, $style, $js);




$sql = '';
$sql .= ' select qtd_pontos';
$sql .= ' from grc_formulario_pergunta';
$sql .= ' where idt = '.null($_GET['pergunta_idt']);
$rs = execsql($sql);
$qtd = $rs->data[0][0];

$sql = '';
$sql .= ' select sum(qtd_pontos) as tot';
$sql .= ' from grc_formulario_resposta';
$sql .= ' where idt_pergunta = '.null($_GET['pergunta_idt']);
$sql .= ' and idt <> '.null($_GET['id']);
$sql .= " and valido = 'S'";
$rs = execsql($sql);
$qtd -= Troca($rs->data[0][0], '', 0);

$vetCampo['qtd_pontos_resto'] = objTextoFixoVL('qtd_pontos_resto', 'Qtd. Pontos Restante', $qtd, 9, false);
$vetCampo['campo_txt']        = objCmbVetor('campo_txt', 'Colocar na resposta um campo de texto', True, $vetNaoSim, '');

$maxlength = 700;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Ajuda para a Resposta', false, $maxlength, $style, $js);

//$sql = "select idt, descricao from grc_formulario_classe_resposta order by codigo";

$sql = "select idt, descricao from grc_formulario_classe_pergunta order by codigo";
$vetCampo['idt_classe'] = objCmbBanco('idt_classe', 'Classe', true, $sql, ' ', 'width:100%;');


$vetParametros = Array(
     'width' => '100%',
);
$vetFrm[] = Frame('<span>PERGUNTA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

MesclarCol($vetCampo['detalhe'], 5);
MesclarCol($vetCampo['idt_pergunta'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_pergunta']),
        ), $class_frame, $class_titulo, $titulo_na_linha,$vetParametros);


$vetFrm[] = Frame('<span>RESPOSTA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

if ($sistema_origem=='NAN')
{


    $vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['idt_classe'], '', $vetCampo['campo_txt']),
	
	
    //Array($vetCampo['qtd_pontos'], '', $vetCampo['qtd_pontos_resto']),
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);
}
else
{
    $vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['idt_classe'], '', $vetCampo['campo_txt']),
    Array($vetCampo['qtd_pontos'], '', $vetCampo['qtd_pontos_resto']),
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);
}

$vetFrm[] = Frame('<span>Resumo</span>', Array(
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function grc_formulario_resposta_dep() {
	
        var qtd_pontos = parseFloat($('#qtd_pontos').val().replace(/\./gi, '').replace(',', '.'));
        var qtd_pontos_resto = parseFloat($('#qtd_pontos_resto').val().replace(/\./gi, '').replace(',', '.'));

        if (qtd_pontos > qtd_pontos_resto) {
            alert('A Qtd. Pontos não pode ser maior que a Qtd. Pontos Restante!');
            $('#qtd_pontos').focus();
            return false;
        }
    
        return true;
    }
</script>