<style>
.painel_bordo_c1 {
    text-align:left;
    background:#FFFFFF;
    color:#000000;
    width:100%;
    display:block;
    text-align:center;
    font-size:14px;
    float:left;
    cursor:pointer;
    xheight:25px;
}

.painel_bordo_t1 {
    background:#000000;
    color:#FFFFFF;
    width:100%;
    display:block;
    text-align:center;
    font-size:14px;
    float:left;
    cursor:pointer;
    height:25px;
}

</style>
<?php
$data_hoje  = trata_data(date('d/m/Y'));
$data_hojew = aspa($data_hoje);
$bordo_presencial='P';
$refresh=" onclick = 'onclick = RefreshPainelBordo({$bordo_presencial});' ";
//echo "<div $refresh class='painel_bordo_c1' >";
//PainelBordoTela();
//echo "<div class='painel_bordo_t1' >";
//echo " Ponto de Atendimento Mecês";
//echo "</div>";
//echo "</div>";

echo "<div id='PainelBordo' class='painel_bordo_c1' >";
echo "</div>";


?>
<script>
var bordo_presencial='P'; 
$(document).ready(function () {
    RefreshPainelBordo(bordo_presencial);
});



function AbrePendencias()
{
//    alert('Abre Pendencias');
    //
    $('.escondido').each(function() {
        $(this).toggle();
    });
    return false;
}
function ChamaPendencias()
{
//   alert('Chama Avisos');
   return false;
}
</script>
