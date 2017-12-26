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
$AliasPai    = "grc_ea";
$TabelaPai   = "grc_atendimento_especialidade_acao ";

$EntidadePai = "Ação do Serviço";
$idPai       = "idt";
//
$AliasPric    = "grc_aeaa";
$TabelaPrinc  = "grc_atendimento_especialidade_acao_anexo";
$Entidade     = "Anexo da Ação para o Serviços";
$Entidade_p   = "Anexos da Ação para o Serviços";
$CampoPricPai = "idt_especialidade_acao";
// p($_GET);
// Dados do pai
$sql2 = 'select ';
$sql2 .= "  {$AliasPai}.* ";
$sql2 .= "  from {$TabelaPai} {$AliasPai} ";
$sql2 .= "  where {$AliasPai}.idt = ".null($_GET['idt0']);
$rs_pai  = execsql($sql2);
$row_pai = $rs_pai->data[0];
$nome_servico = $row_pai['plu_usu_nome_completo'];
$tabela = $TabelaPrinc;
$id     = 'idt';
$vetCampo[$CampoPricPai]    = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);
//
$vetCampo['codigo']    = objTexto('codigo', 'Código da Ação', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');


//$vetCampo['tipo_acao']     = objCmbVetor('tipo_acao', 'Tipo da Ação?', True, $vetTPAC,'');



$altura ="150";
$largura="700";
$js="";
//$vetCampo['introducao_texto'] = objHTML('introducao_texto', 'Introdução', false, $altura, $largura, $js);
//$vetCampo['observacao_texto'] = objHTML('observacao_texto', 'Observação', false, $altura, $largura, $js);

//$vetCampo['arquivo_cab']    = objFile('arquivo_cab', 'Arquivo para Cabeçalho', false, 120, 'todos');
//$vetCampo['arquivo_rod']    = objFile('arquivo_rod', 'Arquivo para Rodapé', false, 120, 'todos');
$vetCampo['arquivo']    = objFile('arquivo', 'Arquivo', true, 120, 'todos');

//
$maxlength  = 750;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observação Detalhada do Arquivo', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
MesclarCol($vetCampo[$CampoPricPai], 5);
MesclarCol($vetCampo['detalhe'], 5);

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo[$CampoPricPai]),
    //Array($vetCampo['tipo_acao'],'',$vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
	Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
	Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);



$vetFrm[] = Frame('', Array(
    Array($vetCampo['arquivo']),
),$class_frame,$class_titulo,$titulo_na_linha);



$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
</script>