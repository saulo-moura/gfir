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
        width:300px;
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
if ($acao == 'inc' || $acao == 'alt' ) {
    echo " <div class='botao_ag_bl' onclick='return GerarElementos()' >";
    echo " <div style='margin:8px; '>Gerar Elementos</div>";
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


function GerarElementos()
{
	var str="";
    var TabelaTexto = "";
	objd=document.getElementById('texto');
	if (objd != null)
	{
	   TabelaTexto = objd.value;
	   //alert(' resposta será vvvv'+TabelaTexto);
	}
	//alert(' resposta será '+TabelaTexto);
	$.ajax({
	dataType: 'json',
	type: 'POST',
	url: 'ajax_gsw.php?tipo=gerarelementos',
	data: {
		cas: conteudo_abrir_sistema,
		async: false,
	    TabelaTexto: TabelaTexto
	},
	success: function (response) {
		if (response.erro == '') {
		     alert('voltou sem erro '+response.sql_t);
		} else {
		    alert('voltou com erro'+response.sql_t);
			alert(url_decode(response.erro));
		}
	},
	error: function (jqXHR, textStatus, errorThrown) {
		alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
	},
	async: false
});

	
	
	

}

</script>


