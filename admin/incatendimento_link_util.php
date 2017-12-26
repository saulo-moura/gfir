
<style type="text/css">


div#link_util {
    background: #FFFFFF;
    width:100%;
}


td.link_util_cab_td {
    background: #2F66B8;
    color:#000000;
}
td.class_link {
    background: #ECF0F1;
    color:#000000;
    padding:5px;
    padding-left:36px;
    border-bottom:1px solid #C0C0C0;

}
td.class_link a {
    text-decoration:none;
    cursor:pointer;
    font-sizs:14px;
    
}
td.class_link_n {
    background: #C4C9CD;
    color:#FFFFFF;
    padding:5px;
    font-sizs:16px;
    border-bottom:1px solid #FFFFFF;
}

#filtro_classificacao {
    display: block;
}

#classificacao {
    display: none;
}
</style>


<?php


$idt_atendimento=$_GET['idt_atendimento'];


echo "<table class='table_contato' width='100%' border='0' cellspacing='4' cellpadding='4' vspace='0' hspace='0'> ";

 $link  = " onclick='return PesquisaLink();' ";
 $bt_pesquisar = " <img {$link} width='32'  height='32'  title='Iniciar a pesquisa de Links com o texto digitado.' src='imagens/botao_lupa.png' border='0' style='cursor:pointer; '>";

echo "<tr class='table_contato_linha'> ";
$nomelabelw="<label for='texto' >Texto para pesquisar:&nbsp;</label>";
echo "   <td class='table_contato_celula_label'>{$nomelabelw}</td> ";
$texto = $_GET['texto'];
$nomew="<input title='Digitar o texto para pesquisar LINK.'  id='id_texto' class='Texto' type='text' name='texto' value='{$texto}' size='25' maxlength='80' style='height:32px;'><br>";

 $div1  = "<div style='float:left;'>";
 $div1 .= "{$nomew}";
 $div1 .= "</div>";
 
 $div2  = "<div style='float:left; padding-left:10px;'>";
 $div2 .= "{$bt_pesquisar}";
 $div2 .= "</div>";

 
echo "   <td class='table_contato_celula_value' style='xborder:1px solid red;'>{$div1} {$div2}</td> ";
echo "</tr>";
echo "</table> ";



//echo '<form name="frm" target="_self" action="conteudo_atendimento_link_util.php?'.substr(getParametro($strPara),1).'" method="post">';
//if ($_GET['print'] != 's') {
//    $Focus = '';
//    codigo_filtro(true,true);
//    onLoadPag($Focus);
//}
$sql  = 'select ';
$sql .= '  plu_lu.* ';
$sql .= 'from plu_link_util plu_lu ';
if ($texto!='')
{
    $sql .= ' where ( ';
    $sql .= ' lower(classificacao) like lower('.aspa($texto, '%', '%').')';
    $sql .= ' or lower(descricao) like lower('.aspa($texto, '%', '%').')';
    $sql .= ' or lower(detalhe) like lower('.aspa($texto, '%', '%').')';
    $sql .= ' or lower(link) like lower('.aspa($texto, '%', '%').')';
    $sql .= ' ) ';
}
$sql .= ' order by classificacao ';
$rs = execsql($sql);
if ($rs->rows == 0)
{


}


if ($texto!='')
{
    $wherew = " where ( ";
    $orw    = " ";
    $vetsintetico = Array();
    ForEach($rs->data as $row) {
       $idt             = $row['idt'];
       $classificacao   = $row['classificacao'];
       $descricao       = $row['descricao'];
       $detalhe         = $row['detalhe'];
       $ativo           = $row['ativo'];
       $analitico       = $row['analitico'];
       $link            = $row['link'];
       $grupo = substr($classificacao,0,2);
       $vetsintetico[$grupo]=$grupo;
       $wherew .= $orw." idt = {$idt} ";
       $orw     = " or ";
    }
    ForEach ($vetsintetico as $Campo => $Valor) {
       $wherew .= " or classificacao = ".aspa($Valor);
    }
    $wherew .= " ) ";
    
    
    $sql  = 'select ';
    $sql .= '  plu_lu.* ';
    $sql .= 'from plu_link_util plu_lu ';
    $sql .= ' '.$wherew;
    $sql .= ' order by classificacao ';
    $rs = execsql($sql);
}

echo " <div id='link_util'> ";
echo "<table class='link_util_table' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
//echo "<tr class='link_util_cab_tr'>  ";
//echo "   <td class='link_util_cab_td' >"."Link Útil"."</td> ";
//echo "</tr>";
ForEach($rs->data as $row) {
   $classificacao   = $row['classificacao'];
   $descricao       = $row['descricao'];
   $detalhe         = $row['detalhe'];
   $ativo           = $row['ativo'];
   $analitico       = $row['analitico'];
   $link            = $row['link'];
   if ($analitico=='N')
   {
       $id      = "img_grupo_".$classificacao;
       $idgrupo = $classificacao;
       $classe ='class_link_n';
       $onclick = "onclick='fecha_grupo(".'"'.$classificacao.'"'.");' ";
       $imagemf = "<img {$onclick} id='img_grupo_{$classificacao}' width='21' height='21' src='imagens/seta_baixo.png' style='cursor:pointer; ' title='Clique aqui para esconder essa seção de LINKs' />";


        $div1  = "<div style='float:left;'>";
        $div1 .= "{$imagemf}";
        $div1 .= "</div>";

        $div2  = "<div style='float:left; padding-left:10px; padding-top:3px;'>";
        $div2 .= "{$descricao}";
        $div2 .= "</div>";



       echo "<tr  class='' >  ";
       echo "   <td  class='{$classe}' >{$div1} {$div2}</td> ";
       echo "</tr>";
   }
   else
   {
       $classe ='class_link';
       echo "<tr  class='' >  ";
       

       
       //echo "   <td  class='{$classe} classe_grupo_{$idgrupo}' ><a  xhref='{$link}' target='_blank' xonclick='return ResumoAtendimento('".$link."'); javascript:top.close();' >{$descricao}</a></td> ";
	   
	   // $link=str_replace('"',"##",$link);
	   // $link=str_replace("'","@##",$link);
	   
	  // $link="http://google.com";
	   echo "   <td  class='{$classe} classe_grupo_{$idgrupo}' ><a  href='{$link}'  target='_blank' onclick='return ResumoAtendimento(".'"'.$link.'","'.$descricao.'"'.");' >{$descricao}</a></td> ";
	   
       echo "</tr>";
   }
}
echo "</table>";
echo " </div> ";


//echo '</form>';

echo " </div> ";

?>


<script>

var idt_atendimento =  '<?php echo $idt_atendimento; ?>';

$(document).ready(function () {
    // foco no campo texto
    objd=document.getElementById('id_texto');
    if (objd != null)
    {
       $(objd).focus();
    }
});

function PesquisaLink()
{
    var texto = "";
    objd=document.getElementById('id_texto');
    if (objd != null)
    {
       texto = objd.value;
    }
   // alert('pesquisar o texto '+texto);
    var volta = "conteudo_atendimento_link_util.php?texto="+texto;
    self.location=volta
    return false;
}


function fecha_grupo(grupo)
{
    var id = '#img_grupo_'+grupo;
    var img = $(id);
    if (img.attr('src') == 'imagens/seta_cima.png')
    {
        img.attr('src', 'imagens/seta_baixo.png');
    }
    else
    {
        img.attr('src', 'imagens/seta_cima.png');
    }
    //alert (' ======= '+id);
    var classe_grupo='.classe_grupo_'+grupo;

    //alert (' ccccc======= '+classe_grupo);
    $(classe_grupo).each(function () {
        $(this).toggle();
    });

    return false;
}
function ResumoAtendimento(texto,titulo)
{
    alert('resumo '+texto);
	alert('titulo '+titulo);
    // LINK Util.
	var idt_acao        = 2;
	var idt_pendencia   = "";
	var protocolo       = "";
	var assunto         = texto;
	var link_util       = texto;
	var veio            = 'LINKU';
//	alert('link util '+link_util);
   
	$.ajax({
		dataType: 'json',
		type: 'POST',
		url: 'ajax_grc.php' + '?tipo=GravaResumoAtendimento',
		data: {
			cas: conteudo_abrir_sistema,
			veio           : veio, 
			idt_acao       : idt_acao, 
			idt_pendencia  : idt_pendencia, 
			idt_atendimento: idt_atendimento,
			protocolo      : protocolo,
			link_util      : link_util,
			assunto        : assunto,
			titulo         : titulo
		},
		success: function (response) {
		   // processando_acabou_grc();
			if (response.erro != '') {
				processando_acabou_grc();
				alert(url_decode(response.erro));
			}
			else
			{
				processando_acabou_grc();
				//alert("Registrou resumo  com sucesso.\n");
				//self.location = 'conteudo.php';
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			processando_acabou_grc(); 
			alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
		},
		async: false
	});   

}
</script>