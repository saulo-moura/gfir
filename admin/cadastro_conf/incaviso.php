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
.aviso_div {
    width:100%;
    display:block;
    xborder:1px solid red;
    xheight:25px;
}
</style>
<?php

$smreg     = 1;
$qtdavisos = 0;

$data_hoje  = trata_data(date('d/m/Y'));

$data_hojew = aspa($data_hoje);

$sql    = ' select grc_av.* from grc_aviso grc_av';
$sql   .= " where ";
$sql   .= " data_inicio is null  ";
$sql   .= "  or ( data_inicio >= $data_hojew and data_termino is null ) ";
$sql   .= "  or ( data_inicio >= $data_hojew and data_termino <= $data_hojew ) ";
$sql   .= "  oreder by prioridade desc, data_inicio desc ";
$rs    = execsql($sql);
if ($rs->rows == 0)
{
    $smreg = 0;
}
else
{
    $qtdavisos = $rs->rows;
}
$numexibir=3;
if ($smreg==1)
{
    echo "<div class='ocorrencias_1' >";
    echo "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    echo "<tr  style='' >  ";
    echo " <td  style='width:64px;'>";
    $pathw = 'imagens/aviso.png';
    echo "    <img style='' src='".$pathw."' width='64' height='64'   border='0' />";
    echo " </td>";
    echo " <td class='atende_sc' style='' >";
    echo " <div id='item_{$nume}' class='aviso_div' style='display:none;' </div>";
    echo " <b>AVISOS IMPORTANTES:</b> ";
    echo " </div> ";
    $nume=0;
    ForEach ($rs->data as $row)
    {
        $observacao = $row['observacao'];
        $nume = $nume+1;
        if ($nume>$numexibir)
        {
            echo " <div id='item_{$nume}'  class='aviso_div'  style='display:none;' >";
            echo " $observacao ";
            echo " </div> ";
        }
        else
        {
            echo " <div id='item_{$nume}'   class='aviso_div' >  ";
            echo " $observacao ";
            echo " </div> ";
        }
    }
    echo " </td> ";
    echo " <td  style='width:64px;'>";
    if ($nume > $numexibir)
    {
        $pathw  = 'imagens/mais_aviso.png';
        $hint   = "Clique aqui para Listar outros Avisos";
        $clickb = " onclick='return ChamaAvisos();' ";
        echo "  <img {$clickb} title='{$hint}' style='cursor:pointer;' src='".$pathw."' width='32' height='32'   border='0' />";
    }
    echo " </td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}
else
{
   //echo "ddddddddddddddddddddddddddd";
}
?>
<script>
function ChamaAvisos()
{
   alert('chamar avisos');
   return false;
}
</script>
