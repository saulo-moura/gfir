<style>
Input.Botao {
     xbackground: -moz-linear-gradient(top, #2F2FFF 0%, #6FB7FF 50%, #DFDFFF 100%); /* FF3.6+ */
        xbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff0000), color-stop(35%,#6FB7FF), color-stop(100%,#DFDFFF)); /* Chrome,Safari4+ */
        xbackground: -webkit-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Chrome10+,Safari5.1+ */
        xbackground: -o-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Opera 11.10+ */
        xbackground: -ms-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* IE10+ */
        xbackground: linear-gradient(to bottom, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* W3C */
        xfilter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2F2FFF', endColorstr='#6FB7FF',GradientType=0 ); /* IE6-9 */
        xborder: 1px solid thick #c00000;
        border-radius: 5px;
        xborder:1px solid  #0000A0;
}
fieldset.class_frame {
    background:#FFFFFF;
	border:0;
}
#barra_bt_bottom {
    background:#FFFFFF;
	border:0;
	text-align:right;
	border-top:1px solid #F1F1F1;
}
div.class_titulo {
    background:#FFFFFF;
	border:0;
	color:#0000FF;
	font-size:2em;
}
input {
    background-color: white;
    cursor: auto;
    padding: 0px;
    border: 0px inset;
}

input:hover {
    border: 0;
    border-bottom: 1px solid:#0000FF;
}


.Texto {
   background: white;
   border:0px solid #FFFFFF;
   border-bottom:1px solid #C0C0C0;
}
.Texto:hover {
    border: 0;
    border-bottom: 1px solid:#0000FF;
}

select {
    border-radius: 0px;
    border-color: rgb(255, 255, 255);
	box-sizing:content-box;
	background:#FFFFFF;
}

.TextArea {
    font-family: monospace;
    border: 1px solid #FFFFFF;
	background:#FAFAFA;
}
textarea {
    font-family: monospace;
    border-color: rgb(255, 255, 255);
}

.Tit_Campo_Obr {
    font-size:12px;
	padding-top:5px;
	padding-bottom:5px;
}
.Tit_Campo {
    font-size:12px;
	padding-top:5px;
	padding-bottom:5px;
}

</style>
<?php
$tabela = 'grc_formulario_classe_pergunta';
$id = 'idt';

$sistema_origem = DecideSistema();
$mede  = $_GET['mede'];
$grupo = "";
$vetGrupo=Array();
if ($sistema_origem=='GEC')
{
	$vetGrupo['GC'] ='Gestão de Credenciados';
	$onSubmitDep = 'grc_formulario_secao_dep()';
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





$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
//
$maxlength  = 700;
$style      = "width:100%;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');

    $arquivo_html="";
	$arquivo_html.="<div style='font-size:1,5em; margin-top:5px; background:#FFFFFF; color:#0000FF; height:20px; display:block; width:100%;'>";
	$arquivo_html.="CLASSE DA PERGUNTA";
	$arquivo_html.="</div'>";
	
	
	$vetCampo['linha_separa'] = objInclude('linha_separa', $arquivo_html);
	

MesclarCol($vetCampo['detalhe'], 7);
MesclarCol($vetCampo['linha_separa'], 7);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(

    Array($vetCampo['linha_separa']),
    Array($vetCampo['grupo'],'',$vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
//),$class_frame,$class_titulo,$titulo_na_linha);
//$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>