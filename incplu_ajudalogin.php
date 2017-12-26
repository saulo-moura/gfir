<?php
$nome     =$_SESSION[CS]['g_nome_completo'];
$email    =$_SESSION[CS]['g_email'];
$telefone ='';


$btretorna  = "<input type='button' value='Retornar' name='btretornar' id='btretornar' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'  onclick='desiste_duvida();'  />";
echo '<div id="barra"><div id="tela"><div class="tit_home">';
echo 'Ajuda para efetuar Login';
echo '&nbsp;&nbsp;</div></div></div>';

//echo '&nbsp;&nbsp;</div></div>'.$btretorna.'</div>';



//echo "<div id='home_ajudalogin'>";
//echo "<div id='home_ajudalogin_titulo'>";

//echo " <span> ";
//echo "   Nessa função você pode encontrar <b> respostas<b> para como efetuar Login no sistema.";
//echo " </span> ";

//echo "</div>";



$sql  = "select 	idt, pergunta, resposta from plu_ajudalogin ";
$sql .= "	order by ordem";
$rs = execsql($sql);
ForEach($rs->data as $row) {
    echo " <div id='home_ajudalogin_pergunta'> ";
    echo " <span> ";
    echo $row['pergunta'].'<br />';
    echo " </span> ";
    echo " </div> ";
    echo " <div id='home_ajudalogin_resposta'> ";
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

