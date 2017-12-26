<style type="text/css">
    #tab_tela_compra {
        margin-bottom: 9px;
    }

    #tab_tela_compra tr td {
        border: 4px solid #2c3e50;
        background-color: #2c3e50;
        color: #ffffff;
        font-family: Lato Regular,Calibri,Arial,Helvetica,sans-serif;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        padding: 0px;
        margin: 0px;
        text-transform: uppercase;
    }

    #tab_tela_compra tr td.tc_borda {
        border-left: 2px solid white;
        border-right: 2px solid white;
    }

    #tab_tela_compra tr.linha td {
        border: none;
        background-color: white;
        font-size: 10px;
    }    

    #tab_tela_compra tr.azul td {
        color: #00297b;
        border: 1px solid #00297b;
        background-color: white;
        font-size: 16px;
        font-weight: normal;
        text-transform: none; 
        padding: 10px;
    }

    #tab_tela_compra tr.azul td div.nome {
        color: red;
        font-size: 20px;
    }

    #tab_tela_compra tr.azul td div.dt span {
        color: red;
    }
</style>
<?php
$sql = '';
$sql .= ' select u_cd.nome_completo as nome_usuario_cad, u_up.nome_completo as nome_usuario_update, ap.dt_update, ap.data';
$sql .= ' from grc_atendimento_pendencia ap';
$sql .= ' left outer join plu_usuario u_cd  on u_cd.id_usuario = ap.idt_usuario';
$sql .= ' left outer join plu_usuario u_up  on u_up.id_usuario = ap.idt_usuario_update';
$sql .= ' where ap.idt_evento = '.null($idt_evento);
$sql .= ' and ap.idt_evento_situacao_para = 21';
$sql .= ' order by ap.dt_update desc limit 1';
$rsAP = execsql($sql);

if ($rsAP->rows > 0) {
    $rowAP = $rsAP->data[0];

    echo '<table id="tab_tela_compra" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
    echo '<tr class="azul">';

    //Col 01
    echo '<td>';

    if ($rowAP['nome_usuario_cad'] != '') {
        echo 'Cancelamento solicitado por:<br />';
        echo '<div class="nome">'.$rowAP['nome_usuario_cad'].'</div>';

        $dt = trata_data($rowAP['data']);
        $dt = explode(' ', $dt);
        echo '<div class="dt">realizado em <span>'.$dt[0].'</span> às <span>'.$dt[1].'</span></div>';
    }
    
    echo '</td>';

    //Col 02
    echo '<td>';

    if ($rowAP['nome_usuario_update'] != '') {
        echo 'Cancelamento aprovado por:<br />';
        echo '<div class="nome">'.$rowAP['nome_usuario_update'].'</div>';

        $dt = trata_data($rowAP['dt_update']);
        $dt = explode(' ', $dt);
        echo '<div class="dt">realizado em <span>'.$dt[0].'</span> às <span>'.$dt[1].'</span></div>';
    }

    echo '</td>';

    echo '</tr>';
    echo '</table>';
}

