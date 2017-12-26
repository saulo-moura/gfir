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


$enail     = "";
$idt_email = $_GET['idt0'];
$sql  = "select  ";
$sql .= " plu_e.*  ";
$sql .= " from plu_email plu_e ";
$sql .= " where plu_e.idt = ".null($idt_email);
$rs = execsql($sql);
ForEach ($rs->data as $row) {
	$email = $row['plu_e_email'];
}	




$TabelaPai    = "plu_email";
$AliasPai     = "plu_e";
$EntidadePai  = "Email";
$idPai        = "idt";


$CampoPricPai     = "idt_email";



echo "<div class='barratitulo_conf'>";
echo "EMAIL - CONTEÚDO de ".$email;
echo "</div>";


$tabela = 'plu_email_conteudo';
$id = 'idt';



$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;
$sistema_origem  = DecideSistema();
$idt_helpdesk    = $_GET['id'];
$vetFrm = Array();

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'email', 0);
$vetCampo['numero'] = objInteiro('numero', 'Número', false, 15);
$vetCampo['datahora']        = objDataHora('datahora', 'Data Registro', false);
$vetCampo['titulo']          = objTexto('titulo', 'Título', false, 45, 255);

$vetCampo['corpo']           = objHtml('corpo', 'Corpo do Email', true,'300px','','',True);
$vetCampo['origem']          = objTexto('origem', 'Origem', false, 45, 255);
$vetCampo['nossonumero']     = objTexto('nossonumero', 'Nosso Número', false, 45, 255);
$vetCampo['seunumero']       = objTexto('seunumero', 'Seu Número', false, 45, 255);

/*
$vetTipoSolicitacaoHD = Array();
$vetTipoSolicitacaoHD['PS'] ='Problema no Sistema'; 
$vetTipoSolicitacaoHD['RE'] ='Dúvida do Sistema'; 

$vetCampo['tipo_solicitacao'] = objCmbVetor('tipo_solicitacao', 'Tipo de Solicitação', true, $vetTipoSolicitacaoHD,'');
*/
 MesclarCol($vetCampo['idt_email'], 3);
 MesclarCol($vetCampo['titulo'], 3);
 MesclarCol($vetCampo['origem'], 3);
 $vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_email']),
	Array($vetCampo['nossonumero'],'',$vetCampo['seunumero']),
    Array($vetCampo['numero'],'',$vetCampo['datahora']),
	Array($vetCampo['origem']),
	Array($vetCampo['titulo']),
	
        ), $class_frame_p, $class_titulo_p, $titulo_na_linha);
MesclarCol($vetCampo['descricao'], 3);		
$vetFrm[] = Frame('', Array(
	Array($vetCampo['corpo']),
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
