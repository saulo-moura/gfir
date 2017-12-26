<style>
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
$tabela = 'grc_formulario';
$id = 'idt';


if ($_SESSION[CS]['g_id_usuario']!=1)
{
    $acao = 'con';
}



if ($acao != 'con') {
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_avaliacao_resposta';
    $sql .= ' where idt_formulario = '.null($_GET['id']);
    $rs = execsql($sql);

    if ($rs->rows > 0) {
        $acao = 'con';
        //echo '<script type="text/javascript">alert("Já tem avaliação com este formulário respondido! Agora só pode consultar o formulário.")</script>';
		alert("Já tem avaliação com este formulário respondido! Agora só pode consultar o formulário.");
    }
}

$class_frame_f   = "class_frame_f";
$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame"; 
$class_titulo    = "class_titulo";
$titulo_na_linha = false;




$vetFrm = Array();

$titulo_cadastro = "DIAGNÓSTICO SITUACIONAL";

/*
$vetParametros = Array(
    'situacao_padrao' => true,
);
$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);
*/

$mede = $_GET['mede'];

if ($mede!='S')
{
    $vetFrm[] = Frame('<span>DIAGNÓSTICO SITUACIONAL</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
}
else
{
    $vetFrm[] = Frame('<span>FORMULÁRIO DO MEDE</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
}
$vetParametros = Array(
    'codigo_pai' => 'parte01',
);



$sistema_origem = DecideSistema();
$vetGrupo=Array();
if ($sistema_origem=='GEC')
{
	$vetGrupo['GC'] ='Gestão de Credenciados';
}
else
{
	
	if ($mede!='S')
	{
	    $vetGrupo['NAN']='Negócio a Negócio';
	}
    else
    {
	    $vetGrupo['MEDE']='MEDE';
	    // $vetGrupo['GC'] ='Gestão de Credenciados';
	    // $vetGrupo['NAN']='Negócio a Negócio';
    }
}


$vetCampo['grupo']     = objCmbVetor('grupo', 'Grupo', True, $vetGrupo,'');

$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Título', True, 40, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
/*
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['ativo']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
*/
$sql = "select idt, descricao from grc_formulario_aplicacao order by codigo";
$vetCampo['idt_aplicacao'] = objCmbBanco('idt_aplicacao', 'Onde Aplicar o Formulário', true, $sql, ' ', 'width:100%;');

$sql = "select idt, descricao from grc_formulario_dimensao_resposta order by codigo";
$vetCampo['idt_dimensao'] = objCmbBanco('idt_dimensao', 'Dimensão', true, $sql, ' ', 'width:100%;');


$sql  = "select idt, descricao from grc_atendimento_instrumento ";
$sql .= " where nivel = 1 ";
$sql .= " order by codigo ";
$vetCampo['idt_instrumento'] = objCmbBanco('idt_instrumento', 'Instrumento', false, $sql, ' ', 'width:100%;');


$vetCampo['qtd_pontos'] = objTextoFixoVL('qtd_pontos', 'Total de Pontos', 100, 5);

/*
$vetFrm[] = Frame('<span>Aplicação</span>', Array(
    Array($vetCampo['idt_aplicacao'], '', $vetCampo['qtd_pontos']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
*/
$sql = "select idt, descricao from ".db_pir."sca_organizacao_secao order by codigo";
$vetCampo['idt_area_responsavel'] = objCmbBanco('idt_area_responsavel', 'Unidade/Escritório', true, $sql, ' ', 'width:280px;');

$sql = "select id_usuario, nome_completo from plu_usuario order by nome_completo";
$vetCampo['idt_responsavel'] = objCmbBanco('idt_responsavel', 'Responsável', true, $sql, ' ', 'width:280px;');


$vetCampo['versao_numero']          = objDecimal('versao_numero', 'Versão - Número', false, 5);
$vetCampo['versao_texto']           = objTexto('versao_texto', 'Versão - Descrição', false, 15, 45);
$vetCampo['data_inicio_aplicacao']  = objDatahora('data_inicio_aplicacao', 'Data Inicio Aplicação', false);
$vetCampo['data_termino_aplicacao'] = objDatahora('data_termino_aplicacao', 'Data Término Aplicação', false);

if ($sistema_origem=='NAN')
{
    $vetNao=Array();
	$vetNao['N']='Não';
    $vetCampo['controle_pontos'] = objCmbVetor('controle_pontos', 'Controla Pontos?', True, $vetNao,'');
}
else
{
    $vetCampo['controle_pontos'] = objCmbVetor('controle_pontos', 'Controla Pontos?', True, $vetSimNao,'');
	$vetCampo['qtd_pontos_resto'] = objTextoFixoVL('qtd_pontos_resto', 'Qtd. Pontos Restante', $qtd, 9, false);

}

/*
$vetFrm[] = Frame('<span>Versão</span>', Array(
    Array($vetCampo['versao_numero'], '', $vetCampo['versao_texto']),
  //  Array($vetCampo['data_inicio_aplicacao'], '', $vetCampo['data_termino_aplicacao']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
*/

$maxlength = 700;
$style = "width:100%;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Descrição/Objetivo', false, $maxlength, $style, $js);

MesclarCol($vetCampo['grupo'], 5);
MesclarCol($vetCampo['detalhe'], 5);
MesclarCol($vetCampo['idt_aplicacao'], 3);
if ($sistema_origem=='NAN')
{
    MesclarCol($vetCampo['controle_pontos'], 5);
    $vetFrm[] = Frame('', Array(
    Array($vetCampo['grupo']),
    Array($vetCampo['descricao'], '', $vetCampo['idt_area_responsavel'], '', $vetCampo['idt_responsavel']),
	Array($vetCampo['detalhe']),
	//Array($vetCampo['idt_dimensao'], '', $vetCampo['idt_aplicacao'], '', $vetCampo['qtd_pontos']),
	Array($vetCampo['idt_instrumento'], '', $vetCampo['idt_dimensao'], '', $vetCampo['idt_aplicacao']),
	Array($vetCampo['codigo'], '', $vetCampo['versao_numero'], '', $vetCampo['versao_texto']),
	Array($vetCampo['controle_pontos'], '', $vetCampo['qtd_pontos_resto']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}
else
{
    MesclarCol($vetCampo['qtd_pontos'], 3);
	
	$vetFrm[] = Frame('', Array(
    Array($vetCampo['grupo']),
    Array($vetCampo['descricao'], '', $vetCampo['idt_area_responsavel'], '', $vetCampo['idt_responsavel']),
	Array($vetCampo['detalhe']),
	//Array($vetCampo['idt_dimensao'], '', $vetCampo['idt_aplicacao'], '', $vetCampo['qtd_pontos']),
	Array($vetCampo['idt_instrumento'], '', $vetCampo['idt_dimensao'], '', $vetCampo['idt_aplicacao']),
	Array($vetCampo['codigo'], '', $vetCampo['versao_numero'], '', $vetCampo['versao_texto']),
	Array($vetCampo['controle_pontos'], '', $vetCampo['qtd_pontos']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}
		
/*
$vetFrm[] = Frame('<span>Descrição/Objetivo</span>', Array(
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
*/
/*
$maxlength = 4000;
$style = "width:700px;";
$js = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);

$vetFrm[] = Frame('<span>Observação</span>', Array(
    Array($vetCampo['observacao']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
*/
$vetCad[] = $vetFrm;


$vetFrm = Array();

// ----------------------- SEÇÃO
$vetParametros = Array(
    'codigo_frm' => 'secao',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>ÁREAS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();

// $vetCampo['codigo']     = CriaVetTabela('Código');

$vetCampo['grc_fa_descricao']  = CriaVetTabela('Área');
$vetCampo['grc_fr_descricao']  = CriaVetTabela('Relevância');

$vetCampo['detalhe']  = CriaVetTabela('Observação');
if ($sistema_origem=='GEC' or $mede=='S')
{
    $vetCampo['qtd_pontos'] = CriaVetTabela('Qtd. Pontos');
}

$titulo = 'Áreas do Formulário';

$TabelaPrinc  = "grc_formulario_secao";
$AliasPric    = "grc_afp";
$Entidade     = "Seção do Formulário";
$Entidade_p   = "Seções do Formulário";
$CampoPricPai = "idt_formulario";

$orderby = " {$AliasPric}.valido, grc_fa.codigo ";

$sql  = "select {$AliasPric}.*, ";
$sql .= " grc_fa.descricao as grc_fa_descricao, ";
$sql .= " grc_fr.descricao as grc_fr_descricao  ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left join grc_formulario_area grc_fa on grc_fa.idt       = grc_afp.idt_formulario_area ";
$sql .= " left join grc_formulario_relevancia grc_fr on grc_fr.idt = grc_afp.idt_formulario_relevancia ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".'$vlID';
$sql .= " order by {$orderby}";

$vetParametros = Array(
    'func_trata_row' => bloqueia_row_formulario,
);
$vetCampo['grc_formulario_secao'] = objListarConf('grc_formulario_secao', 'idt', $vetCampo, $sql, $titulo, false, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'secao',
    'width' => '100%',
	'controle_fecha' => 'A',

);

if ($_GET['id'] == 0) {
    $html = '';
} else {
    $html = '<a href="conteudo.php?prefixo=cadastro&menu=grc_avaliacao_resposta_ver&id='.$_GET['id'].'" target="ver_formulario"><img src="imagens/bt_print_16.png" />Ver Formulário</a>';
}

$vetFrm[] = Frame('<span>'.$html.'</span>', Array(
    Array($vetCampo['grc_formulario_secao']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
