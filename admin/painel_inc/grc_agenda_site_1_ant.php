<style>
.cab_1 {
    text-align:center;
    background:#2C3E50;
    color:#FFFFFF;
    xborder-bottom:2px solid #FFFFFF;
    width:100%;
    xheight:30px;
    font-size:20px;
    font-weight: bold;
    float:left;
}
.cab_1_2 {
    Xbackground:#2F66B8;
    background:#FFFFFF;
    height:30px;
    width:100%;
    display:block;
    border-bottom:1px solid #000000;
    margin-top:4px;

}

.cab_1_2_pa {
    padding-top:5px;
    text-align:left;
    Xbackground:#2F66B8;
    background:#ffffff;

    color:#2F66B8;

    font-size:14px;
    float:left;

}
.cab_1_2_co {
    padding-top:5px;
    text-align:left;
    background:#ffffff;
    color:#2F66B8;

    font-size:14px;
    float:left;
    padding-left:30px;

}
</style>
<?php
//require_once 'painel.php';
$idt_ponto_atendimento_login = "";
$idt_consultor_login         = "";
$nome_ponto_atendimento_login = $_SESSION[CS]['gdesc_idt_unidade_regional'];
$nome_consultor_login         = $_SESSION[CS]['g_nome_completo'];

echo "<div class='cab_1_2' >";
echo "<div class='cab_1_2_pa' >";
    echo "  Ponto de Atendimento: "."<span style='color:#000000;'>$nome_ponto_atendimento_login</span>";
echo "</div>";

echo "<div class='cab_1_2_co' >";
    echo "  Consultor: "."<span style='color:#000000;'>$nome_consultor_login</span>";;
echo "</div>";
echo "</div>";
