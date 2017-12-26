<style>
    div#pendencia {
        background:#FFFFFF;
        color:#000000;
        width:100%;
        display:block;
        xheight:200px;
        display:none;
        xborder:1px solid #2F2FFF;
        float:left;
        border-bottom:2px solid #2F2FFF;
    }

    div#pendencia_cab {
        background:#004080;
        color:#FFFFFF;
        width:100%;
        xdisplay:block;
        height:25px;
        text-align:center;
        padding-top:5px;
    }
    div#pendencia_det {
        background:#FFFFFF;
        color:#FFFFFF;
        width:100%;
        text-align:center;
        padding-top:5px;
        border-bottom:2px solid #004080;

    }
    div#pendencia_com {
        background:#F1F1F1;
        color:#FFFFFF;
        width:100%;
        text-align:center;
        padding-top:5px;

    }


    .table_pendencia_linha {

    }
    .table_pendencia_celula_label {
        color:#000000;
        text-align:right;

    }
    .table_pendencia_celula_value {
        color:#000000;
        text-align:left;
    }

    div#instrumento {
        background:#FFFFFF;
        color:#000000;
        width:100%;
        display:block;
        xheight:200px;
        display:none;
        border-bottom:2px solid #2F2FFF;
        float:left;
    }

    div#instrumento_cab {
        background:#004080;
        color:#FFFFFF;
        width:100%;
        xdisplay:block;
        height:25px;
        text-align:center;
        padding-top:5px;
    }
    div#instrumento_det {
        background:#FFFFFF;
        color:#FFFFFF;
        width:100%;
        text-align:center;
        padding-top:5px;
        border-bottom:2px solid #004080;

    }
    div#instrumento_com {
        background:#F1F1F1;
        color:#FFFFFF;
        width:100%;
        text-align:center;
        padding-top:5px;

    }


    .table_instrumento_linha {

    }
    .table_instrumento_celula_label {
        color:#000000;
        text-align:right;

    }
    .table_instrumento_celula_value {
        color:#000000;
        text-align:left;
    }


</style>
<?php

$tamdiv  = 50;
$largura = 25;
$altura  = 25;

$tamdiv  = 80;
$largura = 40;
$altura  = 40;



$fsize = '10px';

$tampadimg = $tamdiv - $largura;
$tamdiv    = $tamdiv.'px';
$tamlabel  = $tamdiv + $tampadimg;
$label     = $tamlabel.'px';
$pad       = $tampadimg.'px';
$padimg    = $tampadimg.'px';



$tit_1 = "Possibilita atender o Cliente no Instrumento INFORMAÇÃO";
$tit_2 = "Possibilita atender o Cliente no Instrumento ORIENTAÇÃO TÉCNICA";
$tit_3 = "Possibilita atender o Cliente no Instrumento CONSULTORIA DE CURTA DURAÇÃO";

$tit_4 = "Possibilita enviar SMS para o Cliente solicitando Confirmar Agendamento.";
$tit_5 = "Possibilita enviar E-mail para o Cliente.";



echo " <div  style='margin-top:10px; margin-bottom:10px;  width:35%; color:#000000; float:left; xborder:1px solid #ABBBBF;  '>";


// ações antes de atender

echo " <div onclick='return EnviarEmail({$idt_atendimento_agenda});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_5}' src='imagens/enviar_email_distancia.png' border='0'>";
echo "</div>";

echo "<div title='{$tit_5}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
echo "Enviar Email";
echo "</div>";

echo " </div>";


echo " <div onclick='return ConfirmaPresenca({$idt_atendimento_agenda});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_5}' src='imagens/confirmar_presenca.png' border='0'>";
echo "</div>";

echo "<div title='{$tit_4}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
echo "Solicitar<br /> Confirmar Presença";
echo "</div>";

echo " </div>";


echo " </div>";

echo " <div  style='margin-top:10px;  margin-bottom:10px;  width:64%; color:#000000; float:left; xborder:1px solid #ABBBBF;  '>";


// Atender o cliente

echo " <div onclick='return ConfirmaInformacao({$idt_atendimento_agenda});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px; xborder-left:1px solid #000000;   '>";
echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px; '   >";
echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_1}' src='imagens/informacao.jpg' border='0'>";
echo "</div>";


echo "<div title='{$tit_1}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
echo " Informação";
echo "</div>";
echo " </div>";


echo " <div onclick='return ConfirmaOrientacao({$idt_atendimento_agenda});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px; '   >";
echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_2}' src='imagens/orientacaotecnica.jpg' border='0'>";
echo "</div>";

echo "<div  title='{$tit_2}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
echo " Orientação Técnica";
echo "</div>";

echo " </div>";

echo " <div onclick='return ConfirmaConsultoria({$idt_atendimento_agenda});' style='width:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px;   '   >";
echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_5}' src='imagens/consultoriacurtaduracao.jpg' border='0'>";
echo "</div>";

echo "<div title='{$tit_3}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
echo "Consultoria de<br />Curta Duração";
echo "</div>";

echo " </div>";





echo " </div> ";


?>
<script>
    $(document).ready(function () {

        /*
         objd=document.getElementById('tipo_pessoa_desc');
         if (objd != null)
         {
         $(objd).css('visibility','hidden');
         }
         objd=document.getElementById('tipo_pessoa');
         if (objd != null)
         {
         objd.value = "";
         $(objd).css('visibility','hidden');
         }
         */
    });




    function ConfirmaInformacao(idt_atendimento_agenda)
    {
	
        //alert('teste '+idt_atendimento_agenda);

        var parww   = '&idt_atendimento_agenda='+idt_atendimento_agenda+'&deondeveio=Agenda'; 
		var href    = 'conteudo.php?prefixo=inc&balcao=1&instrumento=1&opcao=inc&distancia=D&menu=grc_atender_cliente_1&origem_tela=painel&cod_volta=grc_atendimento_distancia'+parww; 
		var  height = $(window).height(); 
		var  width  = $(window).width(); 
		var  height = 600; 
		var  width  = 900; 
		var titulo  = "<div style='xwidth:700px; display:block; text-align:center; '>Veio de Agendamento</div>";
		var  left   = 0; 
		var  top    = 0; 
		var  height = $(window).height(); 
		var  width  = $(window).width();  
		var  AgendaInformacao = window.open(href,'AgendaInformacao','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); 

    }
	function ConfirmaOrientacao(idt_atendimento_agenda)
    {
	
       //alert('teste '+idt_atendimento_agenda);

	    var parww   = '&idt_atendimento_agenda='+idt_atendimento_agenda+'&deondeveio=Agenda'; 
		var href    = 'conteudo.php?prefixo=inc&balcao=2&instrumento=2&opcao=inc&distancia=D&menu=grc_atender_cliente_2&origem_tela=painel&cod_volta=grc_atendimento_distancia'+parww; 
		var  height = $(window).height(); 
		var  width  = $(window).width(); 
		var  height = 600; 
		var  width  = 900; 
		var titulo  = "<div style='xwidth:700px; display:block; text-align:center; '>Veio de Agendamento</div>";
		var  left   = 0; 
		var  top    = 0; 
		var  height = $(window).height(); 
		var  width  = $(window).width();  
		var  AgendaOrientacao = window.open(href,'AgendaOrientacao','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); 

    }
    function ConfirmaConsultoria(idt_atendimento_agenda)
    {
	
       // alert('teste '+idt_atendimento_agenda);
	   
	   
	    var parww   = '&idt_atendimento_agenda='+idt_atendimento_agenda+'&deondeveioag=Agenda'; 
		//var href    = 'conteudo_atendimento_distancia.php?prefixo=inc&balcao=3&instrumento=3&opcao=inc&distancia=D&menu=grc_atender_cliente_3&origem_tela=painel&cod_volta=grc_atendimento_distancia'+parww; 
		var href    = 'conteudo.php?prefixo=inc&balcao=3&instrumento=3&opcao=inc&distancia=D&menu=grc_atender_cliente_3&origem_tela=painel&cod_volta=grc_atendimento_distancia'+parww; 
		var  height = $(window).height(); 
		var  width  = $(window).width(); 
		var  height = 600; 
		var  width  = 900; 
		var titulo  = "<div style='xwidth:700px; display:block; text-align:center; '>Veio de Agendamento</div>";
		var  left   = 0; 
		var  top    = 0; 
		var  height = $(window).height(); 
		var  width  = $(window).width();  
		var  AgendaConsultoria = window.open(href,'AgendaConsultoria','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); 
	

    }


    function ConfirmaPresenca(idt_atendimento_agenda)
    {
	/*
		var decisao = confirm("Deseja enviar SMS de Confirmação?\n");
		if (decisao){
			alert ("SMS enviado OK\n");
		} else {
			alert ("SMS não enviado"+" por opção do Usuário");
		}
	*/	
		
	    var parww   ='&idt_atendimento_agenda='+idt_atendimento_agenda+'&deondeveio=AgendaSMSPresenca'; 
		var href    ='conteudo_agenda_enviaemailsms.php?prefixo=cadastro&menu=grc_comunicacao&acao=inc'+parww; 
		var  height = $(window).height(); 
		var  width  = $(window).width(); 
		var  height = 600; 
		var  width  = 900; 
		var titulo  = "<div style='xwidth:700px; display:block; text-align:center; '>Marcar Atendimento</div>";
		var  left   = 0; 
		var  top    = 0; 
		var  height = $(window).height(); 
		var  width  = $(window).width();  
		var  AgendaSMSAvulso = window.open(href,'AgendaSMSAvulso','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); 
	
    }
	
	function EnviarEmail(idt_atendimento_agenda)
    {
		//var decisao = confirm("Deseja enviar EMAIL para o Cliente?\n");
		//if (decisao){
			//alert ("Email enviado OK\n");
			var parww   ='&idt_atendimento_agenda='+idt_atendimento_agenda+'&deondeveio=AgendaEmailAvulso'; 
			var href    ='conteudo_agenda_enviaemailsms.php?prefixo=cadastro&menu=grc_comunicacao&acao=inc'+parww; 
			
			var  height = $(window).height(); 
			var  width  = $(window).width(); 
			
			var  height = 600; 
			var  width  = 900; 
			
			
			var titulo = "<div style='xwidth:700px; display:block; text-align:center; '>Marcar Atendimento</div>";
			
			
			var  left   = 0; 
			var  top    = 0; 
			var  height = $(window).height(); 
			var  width  = $(window).width();  
			var  AgendaEmailAvulso = window.open(href,'AgendaEmailAvulso','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); 

			
		//} else {
		//	alert ("Email não enviado"+" por opção do Usuário");
		//}
    }



</script>
