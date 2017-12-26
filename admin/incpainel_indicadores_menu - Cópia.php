
<style type="text/css">
    .menu_left_v {
	    width:19%;
		float:left;
        background:#2A5696;
        color:#FFFFFF;
        font-size:20px;
        text-align:center;
		border-bottom:1px solid #FFFFFF;
		border-top:1px solid #FFFFFF;
    }
	.menu_right_v {
	    width:79%;
		float:left;
        background:#FFFFFF;
        color:#000000;
        font-size:20px;
        text-align:left;
		padding-left:5px;
		padding-right:5px;
		xborder:1px solid #C0C0C0;
		display:none;
		
    }
	
	.menu_left {
	    width:100%;
		float:left;
        background:#2A5696;
        color:#FFFFFF;
        font-size:20px;
        text-align:center;
		border-bottom:1px solid #FFFFFF;
		border-top:1px solid #FFFFFF;
    }
	.menu_right {
	    width:100%;
		xfloat:left;
        background:#FFFFFF;
        color:#000000;
        xfont-size:20px;
        text-align:left;
		xpadding-left:5px;
		xpadding-right:5px;
		xborder:1px solid #C0C0C0;
		display:none;
		
    }
	
	
	
	.op_v {
	    width:14%;
		float:left;
        color:#FFFFFF;
		cursor:pointer;
        font-size:12px;
        text-align:left;
        padding:5px;
		border-bottom:1px solid #FFFFFF;
		border-top:1px solid #FFFFFF;
    }
	
	.op {
	    width:10%;
		float:left;
        color:#FFFFFF;
		cursor:pointer;
        font-size:12px;
        text-align:center;
        padding:5px;
		xborder-bottom:1px solid #FFFFFF;
		xborder-top:1px solid #FFFFFF;
    }
	.op a {
		text-decoration:none;
    }
	.op:hover {
        background:#2A56DD;
    }
    
	
div#corpo_painel_menu {
        background:#2F2FFF;
        color:#FFFFFF;
        xfont-size:20px;
        width:100%;
		height:660px;
        background: -moz-linear-gradient(top, #2F2FFF 0%, #6FB7FF 50%, #DFDFFF 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff0000), color-stop(35%,#6FB7FF), color-stop(100%,#DFDFFF)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* IE10+ */
        background: linear-gradient(to bottom, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2F2FFF', endColorstr='#6FB7FF',GradientType=0 ); /* IE6-9 */
        xborder: 1px solid thick #c00000;
        xborder-radius: 1em;
        xborder:1px solid  #0000A0;
    }  
	
	
div#aguardar_carregar {
        background:#2F2FFF;
        color:#FFFFFF;
        width:100%;
		background: -moz-linear-gradient(top, #2F2FFF 0%, #6FB7FF 50%, #DFDFFF 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff0000), color-stop(35%,#6FB7FF), color-stop(100%,#DFDFFF)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* IE10+ */
        background: linear-gradient(to bottom, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2F2FFF', endColorstr='#6FB7FF',GradientType=0 ); /* IE6-9 */
        
    }  
	
	
	
</style>

	
	
	
</style>


<?php

echo "<div id='menu_left' class='menu_left'>";

$hinth    = " title = 'Clique aqui para Visualizar a Home' ";
$onclickA = " onclick = 'return oph();' ";
echo "<div id='oph' class='op' {$onclickA} {$hint0} >";
echo "   <a  class='op_a' style=''>Home</a> ";
echo "</div>";


$hint0    = " title = 'Clique aqui para Visualizar os Indicadores de Qualidade' ";
$onclickA = " onclick = 'return op0();' ";
echo "<div id='op0' class='op' {$onclickA} {$hint0} >";
echo "   <a  class='op_a' style=''>Indicadores de Qualidade</a> ";
echo "</div>";


/*
$hint1    = " title = 'Clique aqui para Visualizar Indicador 1 - COMPLETUDE DO CADASTRO' ";
$onclickA = " onclick = 'return op1();' ";
echo "<div id='op1' class='op' {$onclickA} {$hint1} >";
echo "   <a  class='op_a' style=''>1 - CC</a> ";
echo "</div>";

$onclickA = " onclick = 'return op2();' ";
$hint2    = "title = 'Clique aqui para Visualizar Indicador 2 - CONFIABILIDADE DAS INFORMAÇÕES DO CADASTRO DE PESSOA
JURÍDICA'";
echo "<div id='op2' class='op' {$onclickA} {$hint2} >";
echo "   <a  class='op_a' style=''>2 - CICPJ</a> ";
echo "</div>";

$onclickA = " onclick = 'return op3();' ";
$hint3    = "title = 'Clique aqui para Visualizar Indicador 3 - DUPLICIDADE DE DADOS EM CADASTROS DISTINTOS'";
echo "<div id='op3' class='op' {$onclickA} {$hint3} >";
echo "   <a  class='op_a' style=''>3 - DDCD</a> ";
echo "</div>";

$onclickA = " onclick = 'return op4();' ";
$hint4    = "title = 'Clique aqui para Visualizar Indicador 4 - VALIDAÇÃO DE E-MAIL'";
echo "<div id='op4' class='op' {$onclickA} {$hint4} >";
echo "   <a  class='op_a' style=''>4 - VEM</a> ";
echo "</div>";

$onclickA = " onclick = 'return op5();' ";
$hint5    = "title = 'Clique aqui para Visualizar Indicador 5 - QUALIDADE DO ATENDIMENTO'";
echo "<div id='op5' class='op' {$onclickA} {$hint5} >";
echo "   <a  class='op_a' style=''>5 - QA</a> ";
echo "</div>";
*/
$onclickA = " onclick = 'return opGeraDW();' ";
$hint6    = "title = 'Clique aqui para Gerar Base DW. Pode demorar...'";
echo "<div id='op6' class='op' {$onclickA} {$hint6} >";
echo "   <a  class='op_a' style=''>Gera DW</a> ";
echo "</div>";


$onclickA = " onclick = 'return opGeraDWIQ();' ";
$hint7    = "title = 'Clique aqui para Gerar Indicadores de Qualidade. Pode demorar...'";
echo "<div id='op7' class='op' {$onclickA} {$hint7} >";
echo "   <a  class='op_a' style=''>Gera Indicadores</a> ";
echo "</div>";

/*
$onclickA = " onclick = 'return op7();' ";
$hint7    = "title = 'Clique aqui para Visualizar Atendimento - Fidelização'";
echo "<div id='op7' class='op' {$onclickA} {$hint7} >";
echo "   <a  class='op_a' style=''>7 - Fidelização</a> ";
echo "</div>";
*/
/*
$onclickA = " onclick = 'return op99();' ";
$hint99    = "title = 'Clique aqui para Gerar Dados Estatísticos'";
echo "<div id='op99' class='op' {$onclickA} {$hint99} >";
echo "   <a  class='op_a' style=''>Gerar Dados</a> ";
echo "</div>";
*/

echo "</div>";


/*
// cubos

echo "<div id='menu_left' class='menu_left'>";

echo "<div id='cub0h' class='op'  >";
echo "   <a  class='op_a' style=''></a> ";
echo "</div>";


$hintcub0    = " title = 'Clique aqui para Visualizar Cubo Geral' ";
$onclickA = " onclick = 'return opcub0();' ";
echo "<div id='cub0' class='op' {$onclickA} {$hintcub0} >";
echo "   <a  class='op_a' style=''>Cubo Geral</a> ";
echo "</div>";


$hintcub1    = " title = 'Clique aqui para Visualizar Cubo Meta 1' ";
$onclickA = " onclick = 'return opcub1();' ";
echo "<div id='cub1' class='op' {$onclickA} {$hintcub1} >";
echo "   <a  class='op_a' style=''>Cubo Meta 1</a> ";
echo "</div>";

$hintcub2    = " title = 'Clique aqui para Visualizar Cubo Meta 2' ";
$onclickA = " onclick = 'return opcub2();' ";
echo "<div id='cub2' class='op' {$onclickA} {$hintcub1} >";
echo "   <a  class='op_a' style=''>Cubo Meta 2</a> ";
echo "</div>";


$hintcub3    = " title = 'Clique aqui para Visualizar Cubo Meta 3' ";
$onclickA = " onclick = 'return opcub3();' ";
echo "<div id='cub3' class='op' {$onclickA} {$hintcub3} >";
echo "   <a  class='op_a' style=''>Cubo Meta 3</a> ";
echo "</div>";

$hintcub4    = " title = 'Clique aqui para Visualizar Cubo Meta 4' ";
$onclickA = " onclick = 'return opcub4();' ";
echo "<div id='cub4' class='op' {$onclickA} {$hintcub4} >";
echo "   <a  class='op_a' style=''>Cubo Meta 4</a> ";
echo "</div>";

$hintcub5    = " title = 'Clique aqui para Visualizar Cubo Meta 5' ";
$onclickA = " onclick = 'return opcub5();' ";
echo "<div id='cub5' class='op' {$onclickA} {$hintcub5} >";
echo "   <a  class='op_a' style=''>Cubo Meta 5</a> ";
echo "</div>";

$hintcub7    = " title = 'Clique aqui para Visualizar Cubo Meta 7' ";
$onclickA = " onclick = 'return opcub7();' ";
echo "<div id='cub7' class='op' {$onclickA} {$hintcub7} >";
echo "   <a  class='op_a' style=''>Cubo Meta 7</a> ";
echo "</div>";




echo "</div>";
*/


$vetMetasValorAnual=Array();
$vetMetasValorAnual['GE']=80; // Meta 80%

echo "<div id='corpo_painel_menu' class=''>";

echo "<div id='aguardar_carregar' class='menu_right' style=' xborder:2px solid #FF0000; display:block; font-size:18px; text-align:center; xpadding:20px;'>";

echo "<div style='float:left;'>";
echo '<img style="margin:5px;" src="imagens/ajax-loader.gif"   border="0" />';
echo "</div>";
echo "<div style='float:left; padding-top:10px; '>";
echo "Carregando...";
echo "</div>";

echo "</div>";

//
echo "<div id='meta0' class='menu_right'>";
$chamar       = "incmatriz_indicadores_qualidade";
$Require_Once = "{$chamar}.php";
if (file_exists($Require_Once)) {
    Require_Once($Require_Once);
} else {
	echo "Erro de include. Avisar Administrador do Sistema<br />";
}


echo "</div>";
echo "<div id='meta1' class='menu_right'>";
$chamar       = "incmatriz_indicadores_qualidade";
$Require_Once = "{$chamar}.php";
if (file_exists($Require_Once)) {
   // Require_Once($Require_Once);
} else {
	echo "Erro de include. Avisar Administrador do Sistema<br />";
}
echo "</div>";



echo "<div id='meta2' class='menu_right'>";
$chamar       = "incmatriz_lista_meta2";
$Require_Once = "{$chamar}.php";
if (file_exists($Require_Once)) {
    //	Require_Once($Require_Once);
} else {
	echo "Erro de include. Avisar Administrador do Sistema<br />";
}
echo "</div>";

echo "<div id='meta3' class='menu_right'>";
$chamar       = "incmatriz_lista_meta3";
$Require_Once = "{$chamar}.php";
if (file_exists($Require_Once)) {
    //	Require_Once($Require_Once);
} else {
	echo "Erro de include. Avisar Administrador do Sistema<br />";
}
echo "</div>";




echo "<div id='meta4' class='menu_right'>";
$chamar       = "incmatriz_lista_meta4";
$Require_Once = "{$chamar}.php";
if (file_exists($Require_Once)) {
    //	Require_Once($Require_Once);
} else {
	echo "Erro de include. Avisar Administrador do Sistema<br />";
}
echo "</div>";


echo "<div id='meta5' class='menu_right'>";
$chamar       = "incmatriz_lista_meta5";
$Require_Once = "{$chamar}.php";
if (file_exists($Require_Once)) {
    //	Require_Once($Require_Once);
} else {
	echo "Erro de include. Avisar Administrador do Sistema<br />";
}
echo "</div>";

echo "<div id='meta7' class='menu_right'>";
$chamar       = "incmatriz_lista_meta7";
$Require_Once = "{$chamar}.php";
if (file_exists($Require_Once)) {
    //	Require_Once($Require_Once);
} else {
	echo "Erro de include. Avisar Administrador do Sistema<br />";
}
echo "</div>";






echo "<div id='homep' class='menu_right'>";
$chamar       = "incmatriz_lista_balcao_evento_home";
$Require_Once = "{$chamar}.php";
if (file_exists($Require_Once)) {
    //	Require_Once($Require_Once);
} else {
	echo "Erro de include. Avisar Administrador do Sistema<br />";
}
echo "</div>";






echo "<div id='cubo1' class='menu_right'>";
$chamar       = "inccubo_geral";
$Require_Once = "{$chamar}.php";
if (file_exists($Require_Once)) {
    //	Require_Once($Require_Once);
} else {
	echo "Erro de include. Avisar Administrador do Sistema<br />";
}
echo "</div>";


//
echo "<div id='cubo2' class='menu_right'>";
$chamar       = "inccubo_meta1";
$Require_Once = "{$chamar}.php";
if (file_exists($Require_Once)) {
    //	Require_Once($Require_Once);
} else {
	echo "Erro de include. Avisar Administrador do Sistema<br />";
}
echo "</div>";

//
echo "<div id='cubo7' class='menu_right'>";
$chamar       = "inccubo_meta7";
$Require_Once = "{$chamar}.php";
if (file_exists($Require_Once)) {
    //	Require_Once($Require_Once);
} else {
	echo "Erro de include. Avisar Administrador do Sistema<br />";
}
echo "</div>";

//

echo "</div>";



?>



<script type="text/javascript" >

// var idt_organizacao = <?php echo $idt_organizacao; ?>;
$(document).ready(function () {
     oph();
});
function oph()
{
  // alert('opcao Home');
   DesativaRight();
   $('#homep').show(); 
   
}

function op0()
{
  // alert('opcao 0');
   DesativaRight();
   $('#meta0').show(); 
   
}
function opcub0()
{
  // alert('opcao 0');
   DesativaRight();
   $('#cubo1').show(); 
   
}

function op1()
{
  // alert('opcao 1');
   DesativaRight();
   $('#meta1').show(); 
   /*
   objd=document.getElementById('menu_right');
   if (objd != null) {
	  objd.innerHTML = 'meta 1';
   }
   */
}

function opcub1()
{
  // alert('opcao 0');
   DesativaRight();
   $('#cubo2').show(); 
   
}



function op2()
{
  // alert('opcao 2');
   DesativaRight();
   $('#meta2').show(); 
   
}
function opcub2()
{
  // alert('opcao 0');
   DesativaRight();
   $('#cubo3').show(); 
   
}




function op3()
{
  // alert('opcao 3');
   DesativaRight();
   $('#meta3').show(); 
   
}
function op4()
{
  // alert('opcao 4');
   DesativaRight();
   $('#meta4').show(); 
   
}
function op5()
{
  // alert('opcao 5');
   DesativaRight();
   $('#meta5').show(); 
   
}
function op7()
{
  // alert('opcao 7');
   DesativaRight();
   $('#meta7').show(); 
   
}
function opcub7()
{
  // alert('opcao 0');
   DesativaRight();
   $('#cubo7').show(); 
   
}


function DesativaRight()
{
	 var classew = 'menu_right';
	 $('.'+classew).each(function () {
        $(this).hide(); 
     });
 	 return false;
}

function op99()
{
  // alert('opcao 99');
  return false;
  
if(confirm("Deseja realmente Gerar Dados Estatísticos?\n Essa operação pode demorar um pouco.")) {
  
} else {
  return false;
}
  
  
	processando();
	
	    //alert('opcao 99-2');

	
	$.ajax({
		dataType: 'json',
		type: 'POST',
		url: 'ajax_atendimento.php?tipo=GerarDadosEstatisticos',
		data: {
			cas: conteudo_abrir_sistema
		},
		success: function (response) {
			if (response.erro == '') {
			    alert('Geração executada. Sucesso.');
			} else {
				$("#dialog-processando").remove();
				alert(url_decode(response.erro));
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			$("#dialog-processando").remove();
			alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
		},
		async: false
	});

	$("#dialog-processando").remove();
   
}

function opGeraDW()
{
  // alert('opcao 99');
  //return false;
  
if(confirm("Deseja realmente Gerar DW?\n Essa operação pode demorar um pouco.")) {
  
} else {
  return false;
}
  
  
	processando();
	
	    //alert('opcao 99-2');

	
	$.ajax({
		dataType: 'json',
		type: 'POST',
		url: 'ajax_atendimento.php?tipo=GerarDW',
		data: {
			cas: conteudo_abrir_sistema
		},
		success: function (response) {
			if (response.erro == '') {
			    alert('Geração executada. Sucesso.');
			} else {
				$("#dialog-processando").remove();
				alert(url_decode(response.erro));
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			$("#dialog-processando").remove();
			alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
		},
		async: false
	});

	$("#dialog-processando").remove();
   
}

	



function opGeraDWIQ()
{
  // alert('opcao 99');
  //return false;
  
if(confirm("Deseja realmente Gerar Indicadores de Qualidade?\nEssa operação pode demorar um pouco.")) {
  
} else {
  return false;
}
  
  
	processando();
	
	    //alert('opcao 99-2');

	
	$.ajax({
		dataType: 'json',
		type: 'POST',
		url: 'ajax_atendimento.php?tipo=GeraDWIQ',
		data: {
			cas: conteudo_abrir_sistema
		},
		success: function (response) {
			if (response.erro == '') {
			    alert('Geração executada. Sucesso.');
			} else {
				$("#dialog-processando").remove();
				alert(url_decode(response.erro));
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			$("#dialog-processando").remove();
			alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
		},
		async: false
	});

	$("#dialog-processando").remove();
   
}



</script>
