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
    .botao_ag_b2 {
        text-align:center;
        width:250px;
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

if ( $acao == 'con'  || $acao == 'alt') {
    echo " <div class='botao_ag_b2' onclick='return ConfirmaReabrirAvaliacao({$idt_avaliacao});' >";
    echo " <div style='margin:8px; '>Reabrir Diagnóstico</div>";
    echo " </div>";

    echo " <div class='botao_ag_b2' onclick='return MostraDevolutiva({$idt_avaliacao});' >";
    echo " <div style='margin:8px; '>Devolutiva</div>";
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


function ConfirmaReabrirAvaliacao(idt_avaliacao)
{
    //alert(' Apuração '+idt_avaliacao);  
	var str="";
	//var titulo = "Processando a solicitação da BIA. Aguarde...";
	//processando_grc(titulo,'#2F66B8');

	$.post('ajax2.php?tipo=ConfirmaReabrirAvaliacao', {
	  async: false,
	  idt_avaliacao : idt_avaliacao
	}
	, function (str) {
	   if (str == '') {
          alert('Reabertura da Avaliação realizada com sucesso!');
		  window.location.reload();

	   } else {
	      alert(str);
	      alert('Reabertura sss da Avaliação realizada com sucesso!');
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
function  MostraDevolutiva(idt_avaliacao)
{
    var  left   = 100;
    var  top    = 100;
    //var  height = $(window).height()-100;
    //var  width  = $(window).width() * 0.8 ;
	var  height = $(window).height();
    var  width  = $(window).width();
 
    var  link   = 'conteudo_devolutiva.php?prefixo=inc&menu=grc_nan_devolutiva_rel_inc&idt_avaliacao='+idt_avaliacao;
    devolutiva  = window.open(link,"Devolutiva","left="+left+",top="+top+",width="+width+",height="+height+",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
    devolutiva.focus();
}

</script>