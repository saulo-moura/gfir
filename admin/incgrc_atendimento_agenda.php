<?php
$_SESSION[CS]['grc_atendimento_totem'] = $_SERVER['REQUEST_URI'];

if ($_GET['veio'] == 10) {
    $_GET['tipo'] = 'incgrc_atendimento_agenda';
    $parGET = http_build_query($_GET);

    $_POST['cas'] = conteudo_abrir_sistema;
    $parPOST = http_build_query($_POST);

    $refresh_painel = $vetConf['refresh_painel'] * 2000;
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            ajax_aa();

            window.setInterval(ajax_aa, '<?php echo $refresh_painel; ?>');
        });

        function ajax_aa() {
            $.ajax({
                type: 'POST',
                url: ajax_sistema + '?<?php echo $parGET; ?>',
                data: '<?php echo $parPOST; ?>',
                success: function (html) {
                    $('#cont_aa').html(html);
                },
                async: false
            });
        }
    </script>
    <div id="cont_aa"></div>
    <?php
} else {
    require_once 'listar.php';
}