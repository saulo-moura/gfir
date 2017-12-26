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

$tabela = 'grc_evento_entrega_documento';
$id = 'idt';

$vetCampo['idt_evento_entrega'] = objFixoBanco('idt_evento_entrega', 'Entrega do Produto', 'grc_evento_entrega', 'idt', 'descricao', 0);
$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 15, 45);

$width = '700px';
$vetCampo['idt_documento'] = objListarCmb('idt_documento', 'gec_documento', 'Documento', true, $width);


$vetFrm = Array();
$vetFrm[] = Frame('<span>Documento do Tipo de Serviço</span>', Array(
    Array($vetCampo['idt_evento_entrega']),
    Array($vetCampo['codigo']),
    Array($vetCampo['idt_documento']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function parListarCmb_idt_documento() {
        var par = '';

        par += '&veio=EV';

        return par;
    }
</script>