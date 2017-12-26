<style type="text/css">
    .pec_cont {
        overflow: auto;
        border: 1px solid black;
        background-color: white;
    }
    
    .pec_key {
        float: left;
        margin-left: 5px;
        margin-right: 5px;
        color: black;
        width: 124px;
        font-size: 11px
    }

    .pec_value {
        float: left;
        margin-left: 5px;
        margin-right: 5px;
        width: 188px;
        font-size: 11px
    }
</style>
<?php
echo 'Parametros para o Certificado:<br />';

echo '<div class="pec_cont">';

foreach ($vetParametroEventoCertificado as $key => $value) {
    echo '<div class="pec_key">' . $key . '</div>';
    echo '<div class="pec_value">' . $value . '</div>';
}

echo '</div>';
