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
$TabelaPai   = "grc_agenda_parametro";
$AliasPai    = "grc_ap";
$EntidadePai = "Parâmetro Agenda";
$idPai       = "idt";
//
$TabelaPrinc  = "grc_agenda_parametro_servico";
$AliasPric    = "grc_aps";
$Entidade     = "Parâmetro Agenda";
$Entidade_p   = "Parâmetros Agenda";
$CampoPricPai = "idt_parametro";
//p($_GET);


$tabela = $TabelaPrinc;

$id     = 'idt';
$vetCampo[$CampoPricPai]    = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$sql = 'select ';
$sql .= '   idt, descricao  ';
$sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
$sql .= ' order by classificacao ';
$js = " ";
$vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto de Atendimento', true, $sql, ' ', ' width:99%; font-size:12px;', $js);
//
$sql = 'select ';
$sql .= '   idt, descricao  ';
$sql .= ' from grc_atendimento_especialidade grc_ae ';
$sql .= " where ativo = 'S' ";
$sql .= ' order by codigo ';
$js = " ";
$vetCampo['idt_servico'] = objCmbBanco('idt_servico', 'serviço', true, $sql, ' ', ' width:99%; font-size:12px;', $js);


$vetCampo['periodo'] = objInteiro('periodo', 'Duração do Atendimento (Minutos)', false, 10);
$vetCampo['quantidade_periodo'] = objInteiro('quantidade_periodo', 'Quantidade de Períodos (Minutos)', false, 10);


$vetFrm = Array();
$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo[$CampoPricPai]),
	Array($vetCampo['idt_ponto_atendimento']),
	Array($vetCampo['idt_servico']),

),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

$vetFrm[] = Frame('<span>Definição do Padrão do Período de Atendimento</span>', Array(
    Array($vetCampo['periodo'],'',$vetCampo['quantidade_periodo']),
),$class_frame,$class_titulo,$titulo_na_linha);




$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
</script>