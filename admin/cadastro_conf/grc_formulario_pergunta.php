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
$tabela = 'grc_formulario_pergunta';
$id = 'idt';
$html = '';

if ($_GET['idCad'] != '') {
    $_GET['secao_idt'] = $_GET['idCad'];
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


$vetCampo['idt_secao'] = objFixoBanco('idt_secao', '', 'grc_formulario_secao', 'idt', 'descricao', 'secao_idt');
$vetCampo['codigo']    = objInteiro('codigo', 'Ordem', True, 5);

// $vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);

$vetCampo['qtd_pontos'] = objInteiro('qtd_pontos', 'Qtd. Pontos', True, 9);

$maxlength = 1000;
$style = "width:500px;";
$js = "";
$vetCampo['descricao'] = objTextArea('descricao', 'Descrição', false, $maxlength, $style, $js);

	$sql = '';
	$sql .= ' select * ';
	$sql .= ' from grc_formulario_secao';
	$sql .= ' where idt = '.null($_GET['secao_idt']);
	$rs = execsql($sql);
	ForEach ($rs->data as $row) {
	        $idt_area  = $row['idt_formulario_area'];
	}	

	
	

$sql = '';
$sql .= ' select qtd_pontos';
$sql .= ' from grc_formulario_secao';
$sql .= ' where idt = '.null($_GET['secao_idt']);
$rs = execsql($sql);
$qtd = $rs->data[0][0];




$sql = '';
$sql .= ' select sum(qtd_pontos) as tot';
$sql .= ' from grc_formulario_pergunta';
$sql .= ' where idt_secao = '.null($_GET['secao_idt']);
$sql .= ' and idt <> '.null($_GET['id']);
$sql .= " and valido = 'S'";
$rs = execsql($sql); 
$qtd -= Troca($rs->data[0][0], '', 0);

$vetCampo['qtd_pontos_resto'] = objTextoFixoVL('qtd_pontos_resto', 'Qtd. Pontos Restante', $qtd, 9, false);


$maxlength = 700;
$style     = "width:700px;";
$js        = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Introdução', false, $maxlength, $style, $js);

$maxlength = 700;
$style     = "width:700px;";
$js        = "";
$vetCampo['ajuda'] = objTextArea('ajuda', 'Ajuda para Responder a Pergunta', false, $maxlength, $style, $js);

$maxlength = 700;
$style     = "width:700px;";
$js        = "";
$vetCampo['evidencias'] = objTextArea('evidencias', 'Evidências', false, $maxlength, $style, $js);

$vetCampo['obrigatoria']     = objCmbVetor('obrigatoria', 'Obrigatória?', True, $vetNaoSim,'');




$sql = "select idt, descricao from grc_formulario_classe_pergunta order by codigo";
$vetCampo['idt_classe'] = objCmbBanco('idt_classe', 'Classe', false, $sql, ' ', 'width:100%;');

$sql = "select idt, descricao from grc_formulario_ferramenta_gestao order by codigo";
$vetCampo['idt_ferramenta'] = objCmbBanco('idt_ferramenta', 'Ferramenta de Gestão', false, $sql, ' ', 'width:100%;');

$vetParametros = Array(
     'width' => '100%',
);

$vetFrm[] = Frame('<span>ÁREA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_secao']),
        ), $class_frame, $class_titulo, $titulo_na_linha,$vetParametros);

$vetFrm[] = Frame('<span>PERGUNTA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


//MesclarCol($vetCampo['idt_secao'], 5);
MesclarCol($vetCampo['detalhe'], 5);
MesclarCol($vetCampo['ajuda'], 5);
MesclarCol($vetCampo['idt_ferramenta'], 5);
MesclarCol($vetCampo['qtd_pontos_resto'], 3);

if ($sistema_origem=='NAN')
{
    $vetFrm[] = Frame('', Array(
	Array($vetCampo['detalhe']),
    //Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['idt_classe'], '', $vetCampo['obrigatoria']),
	
	Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['obrigatoria']),
	
	
	Array($vetCampo['idt_ferramenta']),
   // Array($vetCampo['qtd_pontos'], '', $vetCampo['qtd_pontos_resto']),
	Array($vetCampo['ajuda']),
        ), $class_frame, $class_titulo, $titulo_na_linha);
}
else
{
    $vetFrm[] = Frame('', Array(
	Array($vetCampo['detalhe']),
    //Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['idt_classe'], '', $vetCampo['obrigatoria']),
	
	Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['obrigatoria']),
	
	
	Array($vetCampo['idt_ferramenta']),
    Array($vetCampo['qtd_pontos'], '', $vetCampo['qtd_pontos_resto']),
	Array($vetCampo['ajuda']),
        ), $class_frame, $class_titulo, $titulo_na_linha);
}
///////////////////////////////////////// pergunta X pergunta

// ----------------------- PERGUNTAS x PERGUNTAS

$vetParametros = Array(
    'codigo_frm' => 'pergunta_pergunta',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>PERGUNTAS ASSOCIADAS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
$vetCampo = Array();
$vetCampo['grc_fp_codigo']     = CriaVetTabela('Ordem');
$vetCampo['grc_fp_descricao']  = CriaVetTabela('Descrição');

$titulo = 'Respostas da Pergunta';

$TabelaPrinc  = "grc_formulario_pergunta_pergunta";
$AliasPric    = "grc_fpp";
$Entidade     = "Pergunta da Pergunta";
$Entidade_p   = "Perguntas da Pergunta";
$CampoPricPai = "idt_pergunta_n1";

$orderby = " {$AliasPric}.idt_pergunta_n1,  {$AliasPric}.idt_pergunta_n2 ";

$sql  = "select {$AliasPric}.*,";
$sql .= " grc_fp.codigo as grc_fp_codigo, ";
$sql .= " grc_fp.descricao as grc_fp_descricao ";

$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left join grc_formulario_pergunta grc_fp on grc_fp.idt = grc_fpp.idt_pergunta_n2 ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".'$vlID';
$sql .= " order by {$orderby}";

$vetParametros = Array(
    'func_trata_row' => bloqueia_row_formulario,
);
$vetCampo[$TabelaPrinc] = objListarConf($TabelaPrinc, 'idt', $vetCampo, $sql, $titulo, false, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'pergunta_pergunta',
    'width' => '100%',
);

$vetFrm[] = Frame('<span>'.$Entidade_p.$html.'</span>', Array(
    Array($vetCampo[$TabelaPrinc]),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);





// fim pergunta x pergunta

// ----------------------- RESPOSTAS
$vetParametros = Array(
    'codigo_frm' => 'resposta',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>RESPOSTAS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
$vetCampo = Array();
$vetCampo['codigo']     = CriaVetTabela('Ordem');
$vetCampo['descricao']  = CriaVetTabela('Descrição');
$vetCampo['grc_fcr_descricao']  = CriaVetTabela('Classe');
if ($sistema_origem=='GEC')
{
  $vetCampo['qtd_pontos'] = CriaVetTabela('Qtd. Pontos');
}

$vetCampo['campo_txt']  = CriaVetTabela('Colocar na resposta<br /> um campo de texto', 'descDominio', $vetSimNao);

$titulo = 'Respostas da Pergunta';

$TabelaPrinc  = "grc_formulario_resposta";
$AliasPric    = "grc_afr";
$Entidade     = "Resposta da Pergunta";
$Entidade_p   = "Respostas da Pergunta";
$CampoPricPai = "idt_pergunta";

$orderby = " {$AliasPric}.valido, {$AliasPric}.codigo ";

$sql  = "select {$AliasPric}.*,";
$sql .= " grc_fcr.descricao as grc_fcr_descricao ";

$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left join grc_formulario_classe_resposta grc_fcr on grc_fcr.idt = grc_afr.idt_classe ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".'$vlID';
$sql .= " order by {$orderby}";

$vetParametros = Array(
    'func_trata_row' => bloqueia_row_formulario,
);
$vetCampo[$TabelaPrinc] = objListarConf($TabelaPrinc, 'idt', $vetCampo, $sql, $titulo, true, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'resposta',
    'width' => '100%',
);

$vetFrm[] = Frame('<span>'.$Entidade_p.$html.'</span>', Array(
    Array($vetCampo[$TabelaPrinc]),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
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
</script>