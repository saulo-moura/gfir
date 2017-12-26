<style>
    #nm_funcao_desc label{
    }
    #nm_funcao_obj {
    }
    .Tit_Campo {
    }
    .Tit_Campo_Obr {
    }
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
        height:30px;
    }
    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        height:30px;
        padding-top:10px;
    }
    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }
    fieldset.class_frame_p {
        background:#ABBBBF;
        border:1px solid #FFFFFF;
    }
    div.class_titulo_p {
        background: #ABBBBF;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }
    fieldset.class_frame {
        background:#ECF0F1;
        border:1px solid #2C3E50;
    }
    div.class_titulo {
        background: #C4C9CD;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo span {
        padding-left:10px;
    }
</style>
<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
else
{
   $_GET['idt0'] = 1;
}
$TabelaPai   = "grc_agenda_parametro";
$AliasPai    = "grc_ap";
$EntidadePai = "Parâmetro Agenda";
$idPai       = "idt";
//
$TabelaPrinc  = "grc_agenda_parametro_suspensao";
$AliasPric    = "grc_aps";
$Entidade     = "Suspensão Agenda";
$Entidade_p   = "Suspensões Agenda";
$CampoPricPai = "idt_parametro";
//p($_GET);
$tabela = $TabelaPrinc;
$id     = 'idt';
$vetCampo[$CampoPricPai]    = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);
$sql  = 'select ';
$sql .= '   idt, descricao  ';
$sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
$sql .= ' order by classificacao ';
$js = " ";
$vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto de Atendimento', true, $sql, ' ', ' width:99%; font-size:12px;', $js);
$vetCampo['data'] = objData('data', 'Data', true, '', '', 'S');

$vetCampo['geral']        = objCmbVetor('geral', 'Todos PA?', True, $vetNaoSim,'');
    $vetCampo['excluir']      = objCmbVetor('excluir', 'EXLUIR de Todos PA?', True, $vetNaoSim,'');
$vetCampo['nacional']     = objCmbVetor('nacional', 'Nacional?', True, $vetNaoSim,'');


$maxlength = 2000;
$style = "width:700px;";
$js = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);



$vetFrm = Array();

if ($acao=='alt')
{
	MesclarCol($vetCampo[$CampoPricPai], 5);
	MesclarCol($vetCampo['idt_ponto_atendimento'], 5);
	MesclarCol($vetCampo['observacao'], 5);
	MesclarCol($vetCampo['nacional'], 5);

	$vetFrm[] = Frame('<span></span>', Array(
		Array($vetCampo[$CampoPricPai]),
		Array($vetCampo['idt_ponto_atendimento']),
		Array($vetCampo['data'],'',$vetCampo['geral'],'',$vetCampo['excluir']),
		
		Array($vetCampo['nacional']),
		
		Array($vetCampo['observacao']),

	),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
}
else
{
	MesclarCol($vetCampo[$CampoPricPai], 3);
	MesclarCol($vetCampo['idt_ponto_atendimento'], 3);
	MesclarCol($vetCampo['observacao'], 3);
	MesclarCol($vetCampo['nacional'], 3);

	$vetFrm[] = Frame('<span></span>', Array(
		Array($vetCampo[$CampoPricPai]),
		Array($vetCampo['idt_ponto_atendimento']),
		Array($vetCampo['data'],'',$vetCampo['geral']),
		
		Array($vetCampo['nacional']),
		
		Array($vetCampo['observacao']),

	),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
}



$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
	$(document).ready(function () {
		setTimeout(function () {
			$('select#geral').removeProp("disabled").removeClass("campo_disabled");
		}, 500);

		setTimeout(function () {
			$('select#geral').removeProp("disabled").removeClass("campo_disabled");
		}, 10000);
	});
</script>