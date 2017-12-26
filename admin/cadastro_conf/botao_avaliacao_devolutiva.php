<style>
    .botao_ag {
        text-align:center;
        width:180px;
        height:35px;
        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        float:left;
        margin-top:20px;
        margin-right:10px;
        font-weight:bold;
    }
    .botao_ag:hover {
        background:#0000FF;


    }
    .botao_ag_bl {
        text-align:center;
        width:350px;
        height:35px;
        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        display: inline-block;
        margin-top:10px;
        margin-right:10px;
        font-weight:bold;

    }
    .botao_ag_bl:hover {
        background:#0000FF;
    }


    td.botao_concluir_atendimento_desc {
        background:#C0C0C0;
    }

</style>
<?php

//if ($acao == 'inc' || $acao == 'alt') {
if ($acao == 'con' || $acao == 'alt' ) {
    echo " <div class='botao_ag_bl' onclick='return ConfirmaFechamento({$idt_avaliacao})' >";
    echo " <div style='margin:8px; '>Fechar Diagnóstico e efetuar Apuração</div>";
    echo " </div>";

    
} else {
    //echo " <div class='botao_ag_bl' onclick='{$botao_volta_include};'>";
    //echo " <div style='margin:8px; '>Voltar</div>";
    //echo " </div>";
}


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


function ConfirmaFechamento(idt_avaliacao)
{
   // alert(' teste fecha '+idt_avaliacao);  
	var str="";
	//var titulo = "Processando. Aguarde...";
	//processando_grc(titulo,'#2F66B8');

	$.post('ajax2.php?tipo=ConfirmaFechamentoAvaliacao', {
	  async: false,
	  idt_avaliacao : idt_avaliacao
	}
	, function (str) {
	   if (str == '') {
		   alert('Fechamento da Avaliação realizado com sucesso!');
		   window.location.reload();
	   } else {
	       //alert(str);
		   alert('Fechamento da Avaliação 2 realizado com sucesso!');
		   window.location.reload();

		 //  processando_acabou_grc();
		 //  var id='bia_menu_det';
		 //  objbiadet = document.getElementById(id);
		 //  if (objbiadet != null) {
		//	   objbiadet.innerHTML = str;
		//   }
		//   MolduraDaBia(1);
	   }
	});

}

</script>


