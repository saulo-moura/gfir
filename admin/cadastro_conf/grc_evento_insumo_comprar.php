<style type="text/css">
    #tab_tela_compra {
        border: 4px solid #2c3e50;
        margin-bottom: 9px;
    }

    #tab_tela_compra td {
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

    #tab_tela_compra td.tc_borda {
        border-left: 2px solid white;
        border-right: 2px solid white;
    }
</style>
<?php
$origem_evento_tela = 'compra';

$sql = '';
$sql .= ' select e.codigo, ai.descricao, e.dt_previsao_inicial';
$sql .= ' from grc_evento e';
$sql .= ' inner join grc_atendimento_instrumento ai on ai.idt = e.idt_instrumento';
$sql .= ' where e.idt = '.null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

echo '<table id="tab_tela_compra" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
echo '<tr>';
echo '<td>EVENTO Nº '.$row['codigo'].'</td>';
echo '<td class="tc_borda">TIPO: '.$row['descricao'].'</td>';
echo '<td>DATA DE INÍCIO: '.trata_data($row['dt_previsao_inicial']).'</td>';
echo '</tr>';
echo '</table>';

require_once 'grc_evento.php';
