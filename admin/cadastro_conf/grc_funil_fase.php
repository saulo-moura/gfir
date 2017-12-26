
<script language="JavaScript" src="js/jscolor/jscolor.js" type="text/javascript"></script>

<?php
$tabela = 'grc_funil_fase';
$id = 'idt';

$funil_idt_cliente_classificacao=0;
$sqlt  = " select grc_ff.idt ";
$sqlt .= " from ".db_pir_grc."grc_funil_fase grc_ff ";
$sqlt .= " where grc_ff.idt = ".null($_GET['id']);
$rst   = execsql($sqlt);
if ($rst->rows==0)
{
	
}
else
{
	foreach ($rst->data as $rowt) {
		$funil_idt_cliente_classificacao = $rowt['idt'];
	}
}
// echo "<input class='jscolor' value='ab2567'>";
$corbloq = "#FFFFD2";


$js         = " readonly='true' style='background:{$corbloq};';";
$vetCampo['codigo']    = objTexto('codigo', 'Ordem', True, 5, 45, $js);
//$vetCampo['codigo']    = objTexto('codigo', 'Ordem', True, 5, 45);
$vetCampo['nome']    = objTexto('nome', 'Nome da Fase', True, 20, 120, $js);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição da Fase', True, 60, 120, $js);
//$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');
//
$maxlength  = 1000;
$style      = "width:100%;";
$js         = "";
$vetCampo['detalhe']      = objTextArea('detalhe', 'Orientação de Atendimento', false, $maxlength, $style, $js);


$js         = " onblur='return Refazer();'";
$vetCampo['cordafase']    = objTexto('cordafase', 'Cor Background', True, 7, 45,$js,'','jscolor');
$vetCampo['cortextfase']  = objTexto('cortextfase', 'Cor Texto', True, 7, 45,$js,'','jscolor');


//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');

if ($acao!="inc")
{
	$_GET['funil_idt_cliente_classificacao']=$funil_idt_cliente_classificacao;
	$_GET['width_fase']='';
	$vetCampo['funil_fase'] = objInclude('funil_fase', 'cadastro_conf/obj_html_funil_fase.php');
	$vetCampo['funil_fases'] = objInclude('funil_fases', 'cadastro_conf/obj_html_funil_fases.php');
}

MesclarCol($vetCampo['detalhe'], 5);
MesclarCol($vetCampo['nome'], 3);
MesclarCol($vetCampo['ativo'], 3);

MesclarCol($vetCampo['funil_fases'], 5);


$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'],'',$vetCampo['nome']),
	Array($vetCampo['descricao'],'',$vetCampo['ativo']),
	Array($vetCampo['cordafase'],'',$vetCampo['cortextfase'],'',$vetCampo['funil_fase']),
	Array($vetCampo['funil_fases']),
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>

<script>
function Refazer()
{
    //alert('gravar e voltar');
    var cordafase="";
    objd = document.getElementById('cordafase');
	if (objd != null)
	{
		cordafase = '#'+$(objd).val(); 
	}
    var cortextfase="";
    objd = document.getElementById('cortextfase');
	if (objd != null)
	{
		cortextfase = '#'+$(objd).val(); 
	}
    objd = document.getElementById('mostraclassificacao');
	if (objd != null)
	{
		$(objd).css('background', cordafase);
		$(objd).css('color', cortextfase);
	}
    objd = document.getElementById('mostraclassificacaoatual');
	if (objd != null)
	{
		$(objd).css('background', cordafase);
		$(objd).css('color', cortextfase);
	}
	objd = document.getElementById('mostraclassificacaoatual2');
	if (objd != null)
	{
		$(objd).css('background', cordafase);
		$(objd).css('color', cortextfase);
	}

    return false;
}
</script>