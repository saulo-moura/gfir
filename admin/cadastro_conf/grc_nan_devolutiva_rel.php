<style>
    fieldset.class_frame_t {
        background:#FFBF40;
        border:1px solid #FFFFFF;
    }
    div.class_titulo_t {
        background: #FFBF40;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        padding-top:10px;
    }
    div.class_titulo_t span {
        padding-left:20px;
        text-align: left;
    }
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
    .formulario .detalhe {
        margin-bottom: 10px;
        padding: 5px;
        background-color: #ffffd7;
        border: 0px solid #508098;
        color: #000000;
		width:100%;
		display:block;
    }
    .formulario .detalhe_secao {
        margin-bottom: 10px;
        padding: 5px;
        background-color: #14ADCC;
        border: 1px solid #FFFFFF;
        color: #000000;
		width:100%;
		display:block;
    }

    .formulario .pergunta_cont {
        border: 0px solid #000000;
        margin-bottom: 10px;
        padding: 3px;
    }
	.formulario .pergunta_cont ul {
	    
        padding-bottom: 5px;
    }

    .formulario .pergunta {
        margin-bottom: 10px;
        padding: 5px;
        background-color: #ecf0f1;
        border: 0px solid #508098;
		color:#000000;
    }
    	
    .formulario ul {
        overflow: hidden;
        list-style-type: none;
        padding: 0px;
        margin: 0px;
    }

    .formulario ul > li {
        padding: 0px;
        margin: 0px;
        color: #00297b;
		color: #000000;
    }

    .formulario ul > li .detalhe {
        margin-bottom: 10px;
    }

    .formulario ul > li > label {
        cursor: pointer;
        display: block;
        margin: 3px 0px;
    }

    .formulario ul > li > label > input {
        cursor: pointer;
        vertical-align: top;
        padding: 0px;
        margin: 0px;
        margin-right: 5px;
		
    }

    .formulario ul > li > div > textarea {
        background: #F6F6F6;
        color: #000000;
        margin: 0px;
        margin-top: 3px;
        padding: 0px;
        border: 0px solid #508098;

        xwidth: 846px;
        height: 45px;
		
        width: 100%;
        xdisplay: none;
    }
	#evidencia {
	    display:block;
	    width: 70%;
		xborder:1px solid red;
		padding-top:10px;
		display: none;
	}
	.frame {
        border: 0px solid #508098;
    }
</style>

<?php
$tabela = '';
$onSubmitDep = 'grc_nan_devolutiva_rel_dep()';

$idt_avaliacao = $_GET['id'];
if ($idt_avaliacao=="")
{
    $idt_avaliacao = $_GET['idt_avaliacao'];
}

$class_frame_t   = "class_frame_t";
$class_titulo_t  = "class_titulo_t";

$class_frame_f   = "class_frame_f";
$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;
//echo " 11111111 vvvvvvvvvvvvvvvvvvvvvvvvvv ";

if ($idt_avaliacao>0)
{
    $vetCampo[$include] = objInclude($include, 'cadastro_conf/grc_nan_devolutiva_rel_inc.php', $vetVariavel);
}
else
{
    $vetCampo[$include] = objInclude($include, 'cadastro_conf/grc_nan_devolutiva_rel_inc.php', $vetVariavel);
}


//echo " vvvvvvvvvvvvvvvvvvvvvvvvvv ";


?>