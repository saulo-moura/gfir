<style>
div#painel_cont {
    xborder: 1px solid;
    margin-left: 30px;
}

div#painel_cont > div.cell > span > div {
    xpadding-top:15px;
}

div#painel_cab {
    border: 1px solid;
    background:#0000ff;
    xmargin-left: 30px;
    color:#FFFFFF;
    text-align:center;
}
div#painel_rod {
    border: 1px solid;
    xmargin-left: 38px;
    background:#0000ff;
    color:#FFFFFF;
    text-align:center;
}



div.bt_volta_painel {
    Xborder: 1px solid;
    xmargin-left: 38px;
    background:#ECF0F1;
    color:#000000;
    text-align:left;
}

.bt_volta_painel {
    Xborder: 1px solid;
    xmargin-left: 38px;
    background:#ECF0F1;
    color:#000000;
    text-align:left;

}


Input.Botao {

    border: 1px solid transparent;
    padding-left:10px;
    background:#C4C9CD;
    color:#FFFFFF;


}

</style>

<?php
$_SESSION[CS]['grc_nan_visita_1_avulso'] = $_SERVER['REQUEST_URI'];

$veio_atendimento=1;
$codigo_painel = 'grc_atendimento_distancia';
require_once 'painel.php';
?>