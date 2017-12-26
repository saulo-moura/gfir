<style type="text/css">
    fieldset.grc_indicador_frm {
        border: none;
    }
    
    div.grc_indicador_obs {
        color: black;
        padding: 10px;
    }
</style>
<?php
$sql = '';
$sql .= ' select detalhe';
$sql .= ' from grc_parametros';
$sql .= ' where codigo = ' . aspa('grc_indicador_obs_' . $_GET['veio_at']);
$rs = execsql($sql);

echo '<div class="grc_indicador_obs">';
echo $rs->data[0][0];
echo '</div>';
