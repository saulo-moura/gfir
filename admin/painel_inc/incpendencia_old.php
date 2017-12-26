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
echo "<div class='ocorrencias_1' >";
    echo "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    echo "<tr  style='' >  ";
    echo " <td  style='width:64px;'>";
    $pathw = 'imagens/pendencia.png';
    $hint  ="Visualização das três últimas pendências."."\n"."Utilize o icone + (mais) para visualizar todas.";
    echo "    <img style='' title='{$hint}' src='".$pathw."' width='64' height='64'   border='0' />";
    echo " </td>";
    echo " <td class='atende_sc' style='' >";
    echo " <b>PENDÊNCIA:</b><br/>";
    echo " #BA0125632 - 111111111111111111111111111 <br/>";
    echo " #BA0125633 - 222222222222222222222222222 <br/>";
    echo " #BA0125637 - 333333333333333333333333333 <br/>";
    echo " </td> ";
    echo " <td  style='width:64px;'>";
    $pathw = 'imagens/mais_aviso.png';
    $clickb=" onclick='return ChamaPendencias();' ";
    $hint  ="Clique aqui para Listar outras Pendências";
    echo "    <img {$clickb} title='{$hint}' style='cursor:pointer;' src='".$pathw."' width='32' height='32'   border='0' />";
    echo " </td>";
    echo "</tr>";
    echo "</table>";
echo "</div>";
?>
<script>
function ChamaPendencias()
{
   alert('chamar Pendencias');
   
   return false;
}
</script>