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


    .Tit_Campo {
        font-size:12px;
    }

    td.Titulo {
        color:#666666;
    }

    .situacao {
        font-size:20px;
    }
</style>



<?php
$tabela = 'grc_avaliacao';
$id = 'idt';
$onSubmitDep = 'grc_avaliacao_dep()';

$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;


$sistema_origem = DecideSistema();
$mede = $_GET['mede'];
$deondeveio = $_GET['deondeveio'];

if ($deondeveio == 'Portal' ) // veio da Url do PA
{

}

$idt_avaliacao = $_GET['id'];
$sql = " select ";
$sql .= '   grc_a.idt_atendimento,';
$sql .= "   grc_a.idt_situacao  as grc_a_idt_situacao,  ";
$sql .= "   grc_as.descricao    as grc_as_descricao  ";
$sql .= " from grc_avaliacao grc_a ";
$sql .= " inner join grc_avaliacao_situacao grc_as on grc_as.idt = grc_a.idt_situacao ";
$sql .= " where ";
$sql .= " grc_a.idt = ".null($idt_avaliacao);
$rs = execsql($sql);
ForEach ($rs->data as $row) {
    $grc_a_idt_situacao = $row['grc_a_idt_situacao'];
    $grc_as_descricao   = $row['grc_as_descricao'];
    $idt_atendimento    = $row['idt_atendimento'];
}

$tmp = $grc_as_descricao;

if ($idt_atendimento != '') {
	if ($_SESSION[CS]['g_id_usuario'] != '1') {
		$acao = 'con';
	}
	
    $_GET['acao'] = $acao;
	if ($sistema_origem=='GEC')
	{
	   $tmp .= '<br><br>Avaliação GC';
	}
	else
	{
	   if ($mede!='S')
	   {
		         $tmp .= "<br><br>Diagnóstico de Visita (NAN)";
		}
		else
		{
		    $tmp .= "<br><br>Diagnóstico MEDE";
		}
	}

}


if ($sistema_origem=='GEC' or $mede=='S')
{
   alert('<span class="situacao">'.''.$tmp.'</span>');
}
else
{
   alert('<span class="situacao">'.' Diagnóstico Situacional - '.$tmp.'</span>');
}


if ($grc_a_idt_situacao > 3) {
    $acao = 'con';
    $_GET['acao'] = $acao;
}

$vetFrm = Array();
$manual = $_GET['manual'];
$manual = "S";
$vetCampo['codigo']    = objTextoFixo('codigo', 'Código', '', true);
if ($manual == 'S')
{
    $vetCampo['descricao'] = objTexto('descricao', 'Título', True,50,120);
	
}
else
{
   $vetCampo['descricao'] = objTextoFixo('descricao', 'Título', '', True);
}
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');

$vetGrupo=Array();
$grupo = "";
if ($sistema_origem=='GEC')
{
	$vetGrupo['GC'] ='Gestão de Credenciados';
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


$vetCampo['grupo']     = objCmbVetor('grupo', 'Grupo', True, $vetGrupo,'');

$vetCampo['data_avaliacao'] = objData('data_avaliacao', 'Data Avaliação', true, '', '', 'S');

$sql = "select idt, descricao from ".db_pir_grc."grc_formulario";
//echo "  ----- {$sistema_origem} ";
if ($sistema_origem=='GEC')
{
    $js_hm  = "";
	$sql   .= " where codigo = 70 or codigo = 71 or codigo = 72 or codigo = 90  ";
}
else
{
    if ($mede!='S')
	{  //é o NAN
		$js_hm  = " disabled  ";
		$sql   .= " where codigo = 50 ";
	}
	else
	{
		$js_hm  = "";
		$sql   .= " where codigo >= 600 and codigo <= 799  ";

	}
}
$sql .= " order by codigo";

//p($sql);

$style = " width:380px; background:#FFFFE1;  ";
$vetCampo['idt_formulario'] = objCmbBanco('idt_formulario', 'Formulário', true, $sql, '', $style, $js_hm);


if ($sistema_origem=='GEC')
{
	$vetCampo['idt_avaliador']             = objListarCmb('idt_avaliador', 'gec_entidade_grc_avaliacao_pessoa', 'Gestor/Credenciado/Cliente', true);
	$vetCampo['idt_organizacao_avaliador'] = objListarCmb('idt_organizacao_avaliador', 'gec_entidade_grc_avaliacao_organizacao', 'Empresa - Avaliadora', true);
	$vetCampo['idt_avaliado']              = objListarCmb('idt_avaliado', 'gec_entidade_grc_avaliacao_pessoa', 'Credenciado/Evento/Evento', true);
	$vetCampo['idt_organizacao_avaliado']  = objListarCmb('idt_organizacao_avaliado', 'gec_entidade_grc_avaliacao_organizacao', 'Cliente - Avaliado (PJ)', true);
}
else
{
    if ($mede=='S')
	{
		$vetCampo['idt_avaliado'] = objListarCmb('idt_avaliado', 'gec_entidade_grc_avaliacao_pessoa', 'Cliente - Avaliado (PF) Representante', true);
		$vetCampo['idt_organizacao_avaliado'] = objListarCmb('idt_organizacao_avaliado', 'gec_entidade_grc_avaliacao_organizacao', 'Cliente - Avaliado (PJ)', true);
	}
	else
	{
		$vetCampo['idt_avaliado'] = objListarCmb('idt_avaliado', 'gec_entidade_grc_avaliacao_pessoa', 'Cliente - Avaliado (PF) Representante', true);
		$vetCampo['idt_organizacao_avaliado'] = objListarCmb('idt_organizacao_avaliado', 'gec_entidade_grc_avaliacao_organizacao', 'Cliente - Avaliado (PJ)', true);
		$vetCampo['idt_avaliador'] = objListarCmb('idt_avaliador', 'gec_entidade_grc_avaliacao_pessoa', 'Empresa AOE - Agente', true);
		$vetCampo['idt_organizacao_avaliador'] = objListarCmb('idt_organizacao_avaliador', 'gec_entidade_grc_avaliacao_organizacao', 'Empresa AOE - Avaliadora', true);
	}
}

$sql = "select id_usuario, nome_completo from plu_usuario order by nome_completo";
$js_hm = " disabled  ";
$style = " width:380px; background:#FFFFE1;  ";
$vetCampo['idt_responsavel_registro'] = objCmbBanco('idt_responsavel_registro', 'Responsável pelo Registro', true, $sql, '', $style, $js_hm);

$js = " readonly='true' style='background:#FFFFE1;' ";
$vetCampo['data_registro'] = objDataHora('data_registro', 'Data Registro', true, $js);


$maxlength = 4000;
$style = "width:700px;";
$js = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);


$js = " readonly='true' style='background:#FFFFE1;' ";
$vetCampo['qtd_g'] = objTexto('qtd_g', 'Total', false, 15, 45, $js);
$vetCampo['qtd_e'] = objTexto('qtd_e', 'Sem resposta', false, 15, 45, $js);
$vetCampo['qtd_r'] = objTexto('qtd_r', 'Com resposta', false, 15, 45, $js);

$sql = "select idt, descricao from grc_avaliacao_situacao order by codigo";
$js_hm = " disabled  ";
$style = " width:380px; background:#FFFFE1;  ";
$vetCampo['idt_situacao'] = objCmbBanco('idt_situacao', 'Situacao', true, $sql, '', $style, $js_hm);



$vetCampo['devolutiva'] = objInclude('devolutiva', 'cadastro_conf/botao_avaliacao_devolutiva.php');

$vetCampo['apuracao'] = objInclude('apuracao', 'cadastro_conf/botao_avaliacao_devolutiva_apuracao.php');


if ($mede=='S')
{
	// Guia para escolha do formulário a aplicar
	$sql = '';
	$sql .= ' select idt, descricao ';
	$sql .= ' from grc_formulario_guia ';
	$sql .= " where grupo = ".aspa($grupo);
	$sql .= ' order by codigo ';
	$js_hm = " ";
	$style = " width:350px;  ";
	$vetCampo['idt_guia'] = objCmbBanco('idt_guia', 'Guia para Diagnóstico', false, $sql, '', $style, $js_hm);

}	





MesclarCol($vetCampo['observacao'], 3);


if ($mede=='S')
{
    $vetFrm[] = Frame('<span>Dados da Avaliação</span>', Array(
	Array($vetCampo['grupo'],'',$vetCampo['idt_guia']),
	Array($vetCampo['codigo'], '', $vetCampo['descricao']),
    Array($vetCampo['data_avaliacao'], '', $vetCampo['idt_formulario']),
	
	Array($vetCampo['idt_avaliado'], '', $vetCampo['idt_avaliador']),
    Array($vetCampo['idt_organizacao_avaliado'], '', $vetCampo['idt_organizacao_avaliador']),
    
    Array($vetCampo['idt_responsavel_registro'], '', $vetCampo['data_registro']),
    Array($vetCampo['observacao']),
        ), $class_frame_p, $class_titulo_p, $titulo_na_linha);
}
else
{
	MesclarCol($vetCampo['grupo'], 3);
	$vetFrm[] = Frame('<span>Dados da Avaliação</span>', Array(
		Array($vetCampo['grupo']),
		Array($vetCampo['codigo'], '', $vetCampo['descricao']),
		Array($vetCampo['data_avaliacao'], '', $vetCampo['idt_formulario']),
		
		Array($vetCampo['idt_organizacao_avaliado'], '', $vetCampo['idt_organizacao_avaliador']),
		Array($vetCampo['idt_avaliado'], '', $vetCampo['idt_avaliador']),
		Array($vetCampo['idt_responsavel_registro'], '', $vetCampo['data_registro']),
		Array($vetCampo['observacao']),
			), $class_frame_p, $class_titulo_p, $titulo_na_linha);
}



$vetFrm[] = Frame('<span>Completude</span>', Array(
    Array($vetCampo['qtd_r'], '', $vetCampo['qtd_e'], '', $vetCampo['qtd_g'], '', $vetCampo['idt_situacao']),
        ), $class_frame_p, $class_titulo_p, $titulo_na_linha);





if ($grc_a_idt_situacao == 3) {
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['devolutiva']),
            ), $class_frame_p, $class_titulo_p, $titulo_na_linha);
}
if ($grc_a_idt_situacao == 4) {
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['apuracao']),
            ), $class_frame_p, $class_titulo_p, $titulo_na_linha);
}
/////////////////////////// Chama o Diagnóstico Situacional		
//$vetParametros = Array(
//    'codigo_frm' => 'grc_representantes_w',
//    'controle_fecha' => 'A',
//);
//$vetFrm[] = Frame('<span> DIAGNÓSTICO SITUACIONAL</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCad[] = $vetFrm;
$vetFrm = Array();

$vetParametros = Array(
//    'codigo_pai' => 'grc_representantes_w',
    'width' => '100%',
);


MesclarCadastro('grc_avaliacao_resposta', 'idt_avaliacao', $vetCad, $vetParametros);









$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function grc_avaliacao_dep() {
        var retorno = true;

        $.ajax({
            type: 'POST',
            url: ajax_sistema + '?tipo=checa_formulario',
            data: {
                idt_formulario: $('#idt_formulario').val()
            },
            success: function (response) {
                if (response == 'N') {
                    alert('Formulário não esta com os pontos todos distribuidos nas seções / perguntas / respostas!\n\nPor isso não pode usar para fazer uma avaliação.');
                    $('#idt_formulario').val('');
                    $('#idt_formulario').focus();
                    retorno = false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        return retorno;
    }
</script>
