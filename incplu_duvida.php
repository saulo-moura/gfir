<?
$nome     =$_SESSION[CS]['g_nome_completo'];
$email    =$_SESSION[CS]['g_email'];
$telefone ='';


$btretorna  = "<input type='button' value='Retornar' name='btretornar' id='btretornar' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'  onclick='desiste_duvida();'  />";
echo '<div id="barra"><div id="tela"><div class="tit_home">';
echo 'Dúvidas sobre o sistema sebrae.PIR';
echo '&nbsp;&nbsp;</div></div></div>';


//echo "<div id='home_duvida'>";
//echo "<div id='home_duvida_titulo'>";

//echo " <span> ";
//echo "   Nessa função você pode encontrar <b> respostas<b> para suas perguntas.";
//echo " </span> ";

//echo "</div>";



$sql  = "select 	idt, pergunta, resposta from ".$pre_table."plu_duvida ";
$sql .= "	order by pergunta";
$rs = execsql($sql);
ForEach($rs->data as $row) {
    echo " <div id='home_duvida_pergunta'> ";
    echo " <span> ";
    echo $row['pergunta'].'<br />';
    echo " </span> ";
    echo " </div> ";
    echo " <div id='home_duvida_resposta'> ";
    echo " <span> ";
    echo $row['resposta'].'<br />';
    echo " </span> ";
    echo " </div> ";
}

/*
echo "<table class='table_contato' width='100%' border='0' cellspacing='4' cellpadding='4' vspace='0' hspace='0'> ";
$btconfirma = "<input type='submit' name='btnAcao' value='Enviar' onClick='valida = ".'"'."S".'"'."' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'/>";
$btretorna  = "<input type='button' value='Retornar' name='btretornar' id='btretornar' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'  onclick='desiste_duvida();'  />";
echo "<tr class='table_contato_linha'> ";
echo "   <td class='table_contato_celula_btconfirmar' >{$btretorna}</td> ";
echo "</tr>";
echo "</table >";
*/
//echo "</div>";
?>

