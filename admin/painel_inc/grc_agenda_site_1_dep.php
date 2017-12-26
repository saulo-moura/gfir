<style>
.ocorrencias_1 {
    text-align:left;
    xbackground:#2C3E50;
    background:#FFFFFF;
    color:#000000;
    border-top:1px solid #000000;
    border-bottom:1px solid #000000;
    width:100%;
    xheight:30px;
    font-size:12px;
    xfont-weight: bold;
    float:left;
}
.atende_sc {
    width:80%;

}
</style>
<?php

// solicitado retirar da tela de agendamento
//echo " --------------------------------------------------------";
$quero = 0;
if ($quero == 1)
{
//require_once 'painel.php';
echo "<div class='ocorrencias_1' >";
    echo "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    echo "<tr  style='' >  ";
    echo " <td  style='width:64px;'>";
    $pathw = 'imagens/aviso.png';
    echo "    <img style='' src='".$pathw."' width='64' height='64'   border='0' />";
    echo " </td>";
    echo " <td class='atende_sc' style='' >";
    $avisos_3 = " <b>AVISOS IMPORTANTES:</b><br/>";
    
    $datadiaw      = trata_data(date('d/m/Y H:i:s'));

    $sql  = "select  ";
    $sql .= " grc_av.*  ";
    $sql .= " from grc_aviso grc_av ";
    $sql .= " where (data_termino is null or data_termino >  ".aspa($datadiaw)." )";
    $sql .= " order by data_inicio desc, prioridade ";

    $rs = execsql($sql);
    $wcodigo = '';
    $conta3 = 0;
    ForEach($rs->data as $row)
    {
        $observacao  = $row['observacao'];
        $conta3 = $conta3 + 1;
        if ($conta3 > 3)
        {
            break;
        }
        $avisos_3    .= "# {$observacao} <br/>";
    }
    echo $avisos_3;
    
    echo " </td> ";

    echo " <td  style='width:64px;'>";
    $pathw = 'imagens/mais_aviso.png';
    $clickb=" onclick='return ChamaAvisos();' ";
    echo "    <img {$clickb} style='' src='".$pathw."' width='32' height='32'   border='0' />";
    echo " </td>";

    
    echo "</tr>";
    echo "</table>";
echo "</div>";
//echo "<br />";
}
?>

<script>
function ChamaAvisos()
{
  //  alert('chamar avisos');
    var  left   = 100;
    var  top    = 100;
    var  height = $(window).height()-100;
    var  width  = $(window).width() * 0.8 ;
    // prefixo=listar&menu=grc_aviso&origem_tela=painel&cod_volta=tabela_apoio_atendimento
    var link ="conteudo_avisos.php?prefixo=listar&menu=grc_aviso&veio=10&origem_tela=painel&cod_volta=tabela_apoio_atendimento";
    aviso_link =  window.open(link,"aviso_link","left="+left+",top="+top+",width="+width+",height="+height+",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
    aviso_link.focus();
   return false;
}
</script>