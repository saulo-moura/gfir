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

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;


$TabelaPai   = "grc_projeto_acao";
$AliasPai    = "grc_pa";
$EntidadePai = "A��o do Projeto";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_projeto_acao_meta";
$AliasPric        = "grc_pam";
$Entidade         = "Meta da A��o do Projeto";
$Entidade_p       = "Metas das A��es do Projeto";
$CampoPricPai     = "idt_projeto_acao";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$js         = "";

$vetCampo['mes']     = objCmbVetor('mes', 'M�s', True, $vetMes);
$vetCampo['ano']     = objCmbVetor('ano', 'Ano', True, $vetAno);
$vetCampo['quantitativo']    = objDecimal('quantitativo','Quantitativo',true,10,'',0,$js);

$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observa��o', false, $maxlength, $style, $js);


$sql = "select idt, descricao from grc_atendimento_instrumento order by codigo";
$vetCampo['idt_instrumento'] = objCmbBanco('idt_instrumento', 'Instrumento', true, $sql,'','width:280px;');
$sql = "select idt, descricao from grc_atendimento_instrumento order by codigo";
$vetCampo['idt_metrica'] = objCmbBanco('idt_metrica', 'M�trica', true, $sql,'','width:280px;');



$vetFrm = Array();

$vetFrm[] = Frame('<span>A��o</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);


MesclarCol($vetCampo['idt_instrumento'], 7);
$vetFrm[] = Frame('<span>Meta F�sica</span>', Array(
    Array($vetCampo['mes'],'',$vetCampo['ano']),
    Array($vetCampo['idt_instrumento']),
    Array($vetCampo['quantitativo'],'',$vetCampo['idt_metrica']),

),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observa��o</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);




$vetCad[] = $vetFrm;
?>
