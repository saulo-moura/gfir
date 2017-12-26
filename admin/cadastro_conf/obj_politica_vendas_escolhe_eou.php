<style>
 .escolha_tabela {
    cursor:pointer;
 }
</style>

<?php

echo " <div style='width:50px; '>";

echo " <div onclick='return Escolheu_eou(1);' style='color:#004080; font-size:11px; cursor:pointer; float:left; padding-top:20px; xpadding-left:30px; xpadding-right:5px;'>";
       echo " <img width='24' height='24'  title='Operador - e' src='imagens/imagem_operador_e.png' border='0'>";
echo " </div>";



echo " <div onclick='return Escolheu_eou(2);' style='color:#004080; font-size:11px; cursor:pointer; float:left; padding-top:20px; padding-left:2px; xpadding-right:5px;'>";
       echo " <img  width='24' height='24'    title='Operador - ou' src='imagens/imagem_operador_ou.png' border='0'>";
echo " </div>";

echo " <div onclick='return Escolheu_eou(3);' style='color:#004080; font-size:11px; cursor:pointer; float:left; padding-top:5px; padding-left:15px; xpadding-right:5px;'>";
       echo " <img  width='32' height='32'    title='Apagar Operador' src='imagens/imagem_operador_borracha.png' border='0'>";
echo " </div>";


echo " </div>";





?>
<script>
    $(document).ready(function () {
        
    });
	
	function Escolheu_eou(opcao)
	{
	    var operador = ""; 
	    if (opcao==1)
		{
		    operador = "e";
		}
		if (opcao==2)
		{
		    operador = "ou";
		}
		var id='operador';
		obj = document.getElementById(id);
		if (obj != null) {
			obj.value = operador;
		}
		return false;
	}
	
</script>