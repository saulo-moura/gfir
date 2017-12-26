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
$tabela = 'grc_formulario_secao';
$id = 'idt';

$html = '';

if ($_GET['idCad'] != '') {
    $_GET['formulario_idt'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
    $idt_formulario = $_SESSION[CS]['objListarConf_vetID'][$_GET['session_cod']]['grc_formulario'];
    $html = '&nbsp;&nbsp;&nbsp;<a href="conteudo.php?prefixo=cadastro&menu=grc_avaliacao_resposta_ver&id='.$idt_formulario.'" target="ver_formulario"><img src="imagens/bt_print_16.png" />Ver Formulário</a>';
}


if ($_SESSION[CS]['g_id_usuario']!=1)
{
    $acao='con';
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



$vetCampo['idt_formulario'] = objFixoBanco('idt_formulario', '', 'grc_formulario', 'idt', 'descricao', 'formulario_idt');
/*
$vetFrm[] = Frame('<span>Formulário</span>', Array(
    Array($vetCampo['idt_formulario']),
        ), $class_frame, $class_titulo, $titulo_na_linha);
*/
$vetCampo['codigo'] = objTexto('codigo', 'Código', false, 15, 45);


$vetCampo['descricao'] = objTexto('descricao', 'Área - Descritiva', false, 60, 120);

$vetCampo['codigo'] = objHidden('codigo', 'Código');
$vetCampo['descricao'] = objHidden('descricao', 'Área - Descritiva');

$vetCampo['evidencia']     = objCmbVetor('evidencia', 'Evidência Obrigatória?', True, $vetSimNao);


$vetCampo['qtd_pontos'] = objInteiro('qtd_pontos', 'Qtd. Pontos', True, 9);

$sql = '';
$sql .= ' select qtd_pontos';
$sql .= ' from grc_formulario';
$sql .= ' where idt = '.null($_GET['formulario_idt']);
$rs = execsql($sql);
$qtd = $rs->data[0][0];

$sql = '';
$sql .= ' select sum(qtd_pontos) as tot';
$sql .= ' from grc_formulario_secao';
$sql .= ' where idt_formulario = '.null($_GET['formulario_idt']);
$sql .= ' and idt <> '.null($_GET['id']);
$sql .= " and valido = 'S'";
$rs = execsql($sql);
$qtd -= Troca($rs->data[0][0], '', 0);

$vetCampo['qtd_pontos_resto'] = objTextoFixoVL('qtd_pontos_resto', 'Qtd. Pontos Restante', $qtd, 9, false);

$sql = "select idt, descricao from grc_formulario_area order by codigo";
$vetCampo['idt_formulario_area'] = objCmbBanco('idt_formulario_area', 'Área', true, $sql, ' ', 'width:100%;');

$sql = "select idt, descricao from grc_formulario_relevancia order by codigo";
$vetCampo['idt_formulario_relevancia'] = objCmbBanco('idt_formulario_relevancia', 'Grau de Relevância', true, $sql, ' ', 'width:100%;');



$maxlength = 700;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Introdução', false, $maxlength, $style, $js);

$vetParametros = Array(
     'width' => '100%',
);
$vetFrm[] = Frame('<span>DIAGNÓSTICO SITUACIONAL</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_formulario']),
        ), $class_frame, $class_titulo, $titulo_na_linha,$vetParametros);
		
$vetFrm[] = Frame('<span>ÁREA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
MesclarCol($vetCampo['qtd_pontos_resto'], 3);
//MesclarCol($vetCampo['iidt_formulario_relevancia'], 3);
MesclarCol($vetCampo['detalhe'], 7);


if ($sistema_origem=='NAN')
{
    $vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['evidencia']),
    Array($vetCampo['idt_formulario_area'], '', $vetCampo['idt_formulario_relevancia']),
//    Array($vetCampo['qtd_pontos'], '', $vetCampo['qtd_pontos_resto']),
	Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);
}		
else
{
    $vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['evidencia']),
    Array($vetCampo['idt_formulario_area'], '', $vetCampo['idt_formulario_relevancia']),
    Array($vetCampo['qtd_pontos'], '', $vetCampo['qtd_pontos_resto']),
	Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);
}
//
// ----------------------- PERGUNTAS
//
$vetParametros = Array(
    'codigo_frm' => 'pergunta',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>PERGUNTAS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['grc_fdr_sigla']  = CriaVetTabela('Dimensão');

$vetCampo['codigo']             = CriaVetTabela('Ordem');
$vetCampo['descricao']          = CriaVetTabela('Pergunta');
$vetCampo['grc_fcp_descricao']  = CriaVetTabela('Classe');


if ($sistema_origem=='GEC' or $mede='S')
{
  $vetCampo['qtd_pontos'] = CriaVetTabela('Qtd. Pontos');
}
$titulo = 'Perguntas associadas à Área';

$TabelaPrinc  = "grc_formulario_pergunta";
$AliasPric    = "grc_afs";
$Entidade     = "Pergunta da Seção";
$Entidade_p   = "Perguntas da Seção";
$CampoPricPai = "idt_secao";

//$orderby = " {$AliasPric}.valido, {$AliasPric}.codigo ";
$orderby = " {$AliasPric}.codigo_quesito , {$AliasPric}.sigla_dimensao, {$AliasPric}.codigo ";

$sql  = "select {$AliasPric}.*, ";
$sql .= " grc_fdr.sigla as grc_fdr_sigla, ";
$sql .= " grc_fdr.descricao as grc_fdr_descricao, ";
$sql .= " grc_fcp.descricao as grc_fcp_descricao ";

$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left join grc_formulario_dimensao_resposta grc_fdr on grc_fdr.idt = grc_afs.idt_dimensao ";
$sql .= " left join grc_formulario_classe_pergunta grc_fcp on grc_fcp.idt = grc_afs.idt_classe ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".'$vlID';
$sql .= " order by {$orderby}";

$vetParametros = Array(
    'func_trata_row' => bloqueia_row_formulario,
);
$vetCampo[$TabelaPrinc] = objListarConf($TabelaPrinc, 'idt', $vetCampo, $sql, $titulo, true, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'pergunta',
    'width' => '100%',
);


$vetFrm[] = Frame('<span>'.$Entidade_p.$html.'</span>', Array(
    Array($vetCampo[$TabelaPrinc]),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function grc_formulario_secao_dep() {
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