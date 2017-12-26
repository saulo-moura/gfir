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

div#totpen{
    background:#fa0c01;
    color:#fff;
    width:20px;
    height:20px;
    line-height:20px;
    vertical-align:middle;
    text-align:center;
    font-size:11px;
    float:left;
    border-radius:50%;
    -moz-border-radius:50%;
    -webkit-border-radius:50%;
    margin-top:5px;
}



</style>
<?php





$smreg     = 1;
$qtdavisos = 0;

$data_hoje  = trata_data(date('d/m/Y'));

$data_hojew = aspa($data_hoje);

$sql    = ' select grc_av.* from grc_aviso grc_av';
$sql   .= " where ";
$sql   .= "     ( data_inicio >= $data_hojew and data_termino is null ) ";
$sql   .= "  or ( data_inicio <= $data_hojew and data_termino >= $data_hojew ) ";
$sql   .= "  order by prioridade asc, data_inicio desc ";
$rs    = execsql($sql);

if ($rs->rows == 0)
{
    $smreg = 0;
}
else
{
    $qtdavisos = $rs->rows;
}
$totalavisos = $rs->rows;
$numexibir          = 3;
$numexibirescondido = 10;
if ($smreg==1)
{
    echo "<div class='ocorrencias_1' >";
    echo "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    echo "<tr  style='' >  ";
    echo " <td  style='width:68px;'>";
    $pathw = 'imagens/aviso.png';
    echo "<div style='float:left;'>";
    echo "    <img style='padding:5px; ' src='".$pathw."' width='48' height='48'   border='0' />";
    echo "</div>";
    echo "<div id='totpen'> $totalavisos </div>";

    echo " </td>";
    if  ($totalavisos>$numexibir)
    {
        echo " <td  style='width:32px;'>";
        if ($totalavisos > $numexibir)
        {
            if ($totalavisos > $numexibirescondido)
            {
                $pathw  = 'imagens/mais_aviso.png';
                $hint   = "Clique aqui para Listar outros Avisos";
                $clickb = " onclick='return ChamaAvisos();' ";
                echo "  <img {$clickb} title='{$hint}' style='padding:5px; cursor:pointer;' src='".$pathw."' width='16' height='16'   border='0' />";
            }
            else
            {
                $pathw  = 'imagens/mais_aviso.png';
                $hint   = "Clique aqui para Listar outros Avisos";
                $clickb = " onclick='return AbreAvisos();' ";
                echo "  <img {$clickb} title='{$hint}' style='padding:5px; cursor:pointer;' src='".$pathw."' width='16' height='16'   border='0' />";
            }
        }
        echo " </td>";
    }
    echo " <td class='atende_sc' style='width:85%;' >";
    echo " <div id='item_{$nume}' class='aviso_div' style='display:none;' </div>";
    echo " <b>AVISOS IMPORTANTES:</b> ";
    echo " </div> ";
    $nume        = 0;
    $numeesconde = 0;
    ForEach ($rs->data as $row)
    {
        $observacao = $row['observacao'];
        $nume = $nume+1;
        $numeesconde=$numeesconde+1;
        if ($nume>$numexibir)
        {
            if ($nume>$numexibirescondido)
            {

            }
            else
            {
                echo " <div id='item_{$nume}'  class='aviso_div escondido'  style='display:none;' >";
                echo " $observacao ";
                echo " </div> ";
            }
        }
        else
        {
            echo " <div id='item_{$nume}'   class='aviso_div' >  ";
            echo " $observacao ";
            echo " </div> ";
        }
    }
    echo " </td> ";

    
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
function AbreAvisos()
{
    // alert('Abre Avisos');
    //
    $('.escondido').each(function() {
        $(this).toggle();
    });
    return false;
}
function ChamaAvisos()
{
   //alert('Chama Avisos');
   return false;
}
</script>
