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


    #descricao_obj {
        border:1px solid #C0C0C0;
    }

</style>



<?php
echo "<div class='barratitulo_conf'>";
echo "PAR�METROS DE EMAIL";
echo "</div>";
$tabela          = 'plu_email';
$id = 'idt';
$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;
$sistema_origem  = DecideSistema();
$idt_email       = $_GET['id'];
$vetFrm = Array();
if ($acao=='inc')
{
   $js = "";
}
else
{
   $js = " readonly='true' style='background:#FFFFE1;' ";
}
$vetCampo['email']           = objEmail('email', 'Email', true,60,'',$js); 
$js = "";
$vetCampo['senha']           = objTexto('senha', 'Senha', true, 60, 255,$js);
$vetCampo['host']            = objTexto('host', 'Servidor (Host)', true, 60, 255,$js);
$vetCampo['porta']           = objInteiro('porta', 'Porta', false, 10);
$vetCampo['opcao']           = objTexto('opcao', 'Op��o', false, 60, 255,$js);
$vetCampo['box']             = objTexto('box', 'Box', false, 60, 255,$js);
// MesclarCol($vetCampo['email'], 3);
$vetFrm[] = Frame('', Array(
	Array($vetCampo['email']),
	Array($vetCampo['senha']),
	Array($vetCampo['host']),
	Array($vetCampo['porta']),
	Array($vetCampo['opcao']),
	Array($vetCampo['box']),
), $class_frame_p, $class_titulo_p, $titulo_na_linha);
$vetCad[] = $vetFrm;
?>
<script type="text/javascript">

	var acao = '<?php echo $acao;  ?>';
	
	$(document).ready(function () {
        $('#bt_voltar').click(function () {
            //alert('to vivo');
		});
	
	
	});
	


</script>