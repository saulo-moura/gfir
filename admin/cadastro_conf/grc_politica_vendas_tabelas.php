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
        background: #FFFFFF;
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

    .Texto {
        border:0;
        background:#ECF0F1;
    }
    
    Select {
        border:0;
        background:#ECF0F1;
    }

    TextArea {
        border:0;
        background:#ECF0F1;
    }
    
    .TextArea {
        border:0;
        background:#ECF0F1;
    }

    div#xEditingArea {
        border:0;
        background:#ECF0F1;
    }

    .TextoFixo {
        background:#ECF0F1;
    }


    fieldset.class_frame {
        border:0;
    }

    .campo_disabled {
        background-color: #ffffd7;
    }    

    #parterepasse_tit {
        padding-left:0px;
    }

</style>
<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}





$AliasPai     = "grc_pv";
$TabelaPai    = "grc_politica_vendas ";
$TabelaPaij   = "grc_politica_vendas ";
$TabelaPaij  .= " {$AliasPai} ";
$EntidadePai  = "Política de Vendas";
$idPai        = "idt";
//
$AliasPric    = "grc_pvt";
$TabelaPrinc  = "grc_politica_vendas_tabelas";
$Entidade     = "Tabela de Política de Vendas";
$Entidade_p   = "Tabelas de Política de Vendas";
$CampoPricPai = "idt_politica_vendas";
// Dados do pai
$sql2  = 'select ';
$sql2 .= "  {$AliasPai}.* ";
$sql2 .= "  from {$TabelaPai} {$AliasPai} ";
$sql2 .= "  where {$AliasPai}.idt = ".null($_GET['idt0']);
$rs_pai  = execsql($sql2);
$row_pai = $rs_pai->data[0];
// $desc_ponto_atendimento = $row_pai['sca_os_descricao'];
// $duracao="";
if ($acao!="inc")
{
	$sql2  = 'select ';
	$sql2 .= "  {$AliasPric}.* ";
	$sql2 .= "  from {$TabelaPrinc} {$AliasPric} ";
	$sql2 .= "  where {$AliasPric}.idt = ".null($_GET['id']);
	$rs_princ  = execsql($sql2);
	$row_princ = $rs_princ->data[0];
	// $duracao   = $row_princ['periodo'];
}
//p($sql2);
//echo " -------------- $duracao ";
//p($_GET);
$tabela = $TabelaPrinc;
$id     = 'idt';
$vetCampo[$CampoPricPai]    = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPaij, 'idt', 'descricao', 0);
$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 40, 120);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 40, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');
$vetCampo['alias']     = objTexto('alias', 'Alias', True, 15, 45);

//
$maxlength  = 4000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
MesclarCol($vetCampo[$CampoPricPai], 5);
MesclarCol($vetCampo['detalhe'], 5);
$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['alias']),
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetCad[] = $vetFrm;
?>
