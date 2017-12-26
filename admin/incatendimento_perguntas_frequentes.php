
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
    padding-left:20px;
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




div#home_duvida_pergunta {
    background-color:#F1F1F1;
    padding-left:10px;
    margin-top:10px;
    padding-top:2px;
    padding-bottom:5px;
}

div#home_duvida_pergunta span {
    font-family : Calibri, Arial, Helvetica, sans-serif;
    font-size   : 13px;
    font-style  : normal;
    font-weight : normal;
    color       : #C40000;
    color       : #AFAFAF;

    color       : #282828;

    padding-top:2px;
    padding-bottom:5px;

}

div#home_duvida_resposta {
    background:#ECF0F1;
    padding-top:2px;
    padding-bottom:5px;
}

div#home_duvida_resposta span {
    font-family : Arial, Calibri, Helvetica, sans-serif;
    font-size   : 12px;
    font-style  : normal;
    font-weight : normal;
    color       : #000000;
    padding-top:2px;
    padding-bottom:5px;
}






</style>


<?php


echo "<table class='table_contato' width='100%' border='0' cellspacing='4' cellpadding='4' vspace='0' hspace='0'> ";

 $link  = " onclick='return PesquisaPerguntas();' ";
 $bt_pesquisar = " <img {$link} width='32'  height='32'  title='Iniciar a pesquisa de Links com o texto digitado.' src='imagens/botao_lupa.png' border='0' style='cursor:pointer; '>";

echo "<tr class='table_contato_linha'> ";
$nomelabelw="<label for='texto' >Texto para psquisar:&nbsp;</label>";
echo "   <td class='table_contato_celula_label'>{$nomelabelw}</td> ";
$texto = $_GET['texto'];
$nomew="<input title='Digitar o texto para pesquisar Perguntas Frequentes.'  id='id_texto' class='Texto' type='text' name='texto' value='{$texto}' size='25' maxlength='80' style='height:32px;'><br>";

 $div1  = "<div style='float:left;'>";
 $div1 .= "{$nomew}";
 $div1 .= "</div>";
 
 $div2  = "<div style='float:left; padding-left:10px;'>";
 $div2 .= "{$bt_pesquisar}";
 $div2 .= "</div>";

 
echo "   <td class='table_contato_celula_value' style='xborder:1px solid red;'>{$div1} {$div2}</td> ";
echo "</tr>";
echo "</table> ";
$sql  = 'select ';
$sql .= '  plu_du.* ';
$sql .= 'from plu_duvida plu_du ';
if ($texto!='')
{
    $sql .= ' where ( ';
    $sql .= ' lower(pergunta) like lower('.aspa($texto, '%', '%').')';
    $sql .= ' or lower(resposta) like lower('.aspa($texto, '%', '%').')';
    $sql .= ' ) ';
}
$sql .= ' order by pergunta ';
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
       $pergunta        = $row['pergunta'];
       $resposta        = $row['resposta'];
       //  $grupo = substr($classificacao,0,2);
       //  $vetsintetico[$grupo]=$grupo;
       $wherew .= $orw." idt = {$idt} ";
       $orw     = " or ";
    }
    ForEach ($vetsintetico as $Campo => $Valor) {
       $wherew .= " or classificacao = ".aspa($Valor);
    }
    $wherew .= " ) ";
    
    
    $sql  = 'select ';
    $sql .= '  plu_du.* ';
    $sql .= 'from plu_duvida plu_du ';
    $sql .= ' '.$wherew;
    $sql .= ' order by pergunta ';
    $rs = execsql($sql);
}

echo " <div id='link_util'> ";
echo "<table class='link_util_table' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
//echo "<tr class='link_util_cab_tr'>  ";
//echo "   <td class='link_util_cab_td' >"."Link Útil"."</td> ";
//echo "</tr>";
ForEach($rs->data as $row) {
   $idt             = $row['idt'];
   $pergunta        = $row['pergunta'];
   $resposta        = $row['resposta'];
   $analitico       = $row['analitico'];
   $analitico='N';
   if ($analitico=='N')
   {
       $classificacao = $idt;
       $id      = "img_grupo_".$classificacao;
       $idgrupo = $classificacao;
       $classe ='class_link_n';
       $onclick = "onclick='fecha_grupo(".'"'.$classificacao.'"'.");' ";
       $imagemf = "<img {$onclick} id='img_grupo_{$classificacao}' width='21' height='21' src='imagens/seta_baixo.png' style='cursor:pointer; ' title='Clique aqui para esconder essa seção de LINKs' />";
        $div1  = "<div style='float:left;'>";
        $div1 .= "{$imagemf}";
        $div1 .= "</div>";
        $div2  = "<div style='float:left; padding-left:10px; padding-top:3px;'>";
        $div2 .= "{$pergunta}";
        $div2 .= "</div>";
       echo "<tr  class='' >  ";
       echo "   <td  class='{$classe}' >{$div1} {$div2}</td> ";
       echo "</tr>";
       $classe ='class_link';
       echo "<tr  class='' >  ";
       echo "   <td  class='{$classe} classe_grupo_{$idgrupo}' >";
            //echo " <div id='home_duvida_pergunta'> ";
            //echo " <span> ";
            //echo $pergunta.'<br />';
            //echo " </span> ";
            //echo " </div> ";
            
            
            echo " <div id='home_duvida_resposta'> ";
            echo " <span> ";
            echo $resposta.'<br />';
            echo " </span> ";
            echo " </div> ";
       echo "</td> ";
       echo "</tr>";

       
       
   }
   else
   {
       $classe ='class_link';
       echo "<tr  class='' >  ";
       echo "   <td  class='{$classe} classe_grupo_{$idgrupo}' >";
            echo " <div id='home_duvida_pergunta'> ";
            echo " <span> ";
            echo $pergunta.'<br />';
            echo " </span> ";
            echo " </div> ";
            echo " <div id='home_duvida_resposta'> ";
            echo " <span> ";
            echo $resposta.'<br />';
            echo " </span> ";
            echo " </div> ";
       echo "</td> ";
       echo "</tr>";
   }
}
echo "</table>";
echo " </div> ";


echo " </div> ";

?>


<script>



$(document).ready(function () {
    // foco no campo texto
    objd=document.getElementById('id_texto');
    if (objd != null)
    {
       $(objd).focus();
    }
});

function PesquisaPerguntas()
{
    var texto = "";
    objd=document.getElementById('id_texto');
    if (objd != null)
    {
       texto = objd.value;
    }
   // alert('pesquisar o texto '+texto);
    var volta = "conteudo_atendimento_perguntas_frequentes.php?texto="+texto;
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

</script>