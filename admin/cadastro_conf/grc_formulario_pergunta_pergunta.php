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
$tabela      = 'grc_formulario_pergunta_pergunta'; 
$id          = 'idt';
//$onSubmitDep = 'grc_formulario_resposta_dep()';
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

$vetParametros = Array(
    'codigo_pai' => 'parte01',
);

    $idt_area = 0;
    $sql = '';
	$sql .= ' select grc_fs.idt_formulario_area as grc_fs_idt_area';
	$sql .= ' from grc_formulario_pergunta grc_fp';
	$sql .= ' inner join grc_formulario_secao grc_fs on grc_fs.idt = grc_fp.idt_secao';
	$sql .= ' where grc_fp.idt = '.null($_GET['pergunta_idt']);
	$rs = execsql($sql);
	ForEach ($rs->data as $row) {
	        $idt_area  = $row['grc_fs_idt_area'];
	}	



$vetCampo['idt_pergunta_n1'] = objFixoBanco('idt_pergunta_n1', '', 'grc_formulario_pergunta', 'idt', 'descricao', 'pergunta_idt');
$idt_dimensao_2 = 2;
$sql  = "select grc_fp.idt, grc_fp.idt_dimensao,grc_fp.codigo, grc_fp.descricao from grc_formulario_pergunta grc_fp";
$sql .= ' inner join grc_formulario_secao grc_fs on grc_fs.idt = grc_fp.idt_secao';
$sql .= ' inner join grc_formulario grc_f on grc_f.idt = grc_fs.idt_formulario';
$sql .= " where grc_fs.idt_formulario_area = {$idt_area} ";
$sql .= " and   grc_f.idt_dimensao = {$idt_dimensao_2} ";
$sql .= " order by grc_fp.idt_dimensao, grc_fp.codigo";
$vetCampo['idt_pergunta_n2'] = objCmbBanco('idt_pergunta_n2', 'Perguntas Relacionadas', false, $sql, ' ', 'width:100%;');







$vetParametros = Array(
     'width' => '100%',
);
$vetFrm[] = Frame('<span>PERGUNTA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

//MesclarCol($vetCampo['idt_pergunta'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_pergunta_n1']),
        ), $class_frame, $class_titulo, $titulo_na_linha,$vetParametros);


$vetFrm[] = Frame('<span>PERGUNTA RELACIONADA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_pergunta_n2']),
	
	
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
?>
