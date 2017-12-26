<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
if ($_REQUEST['cas'] == '') {
    $_REQUEST['cas'] = 'conteudo_abrir_sistema';
}
define('conteudo_abrir_sistema', $_REQUEST['cas']);

Require_Once('configuracao.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php Require_Once('head.php'); ?>
        <style type="text/css">
            body {
                padding: 10px;
            }
        </style>
    </head>
    <body>
        <div id="geral_cadastro" class="showPopWin_width">
            <div id="dtBanco" style="display: none;"><?php echo date("d/n/Y") ?></div>
            <input type="hidden" id="dtBancoObj" value="<?php echo date("d/m/Y"); ?>" />
            <div id="conteudo_cadastro">
                <?php
                require_once 'configuracao.php';

                $exportPath = dirname($_SERVER['SCRIPT_FILENAME']);
                $exportPath .= DIRECTORY_SEPARATOR.$dir_file;
                $exportPath .= DIRECTORY_SEPARATOR.'grc_nan_grupo_atendimento';
                $exportPath .= DIRECTORY_SEPARATOR;
                $exportPath = str_replace('\\', '/', $exportPath);

                $sql = "select grc_a.idt as idt_avaliacao, grc_at.idt_grupo_atendimento, grc_nga.pdf_devolutiva, grc_nga.pdf_plano_facil, grc_nga.pdf_protocolo";
                $sql .= " from  grc_avaliacao grc_a ";
                $sql .= " inner join grc_atendimento grc_at on grc_at.idt = grc_a.idt_atendimento ";
                $sql .= " inner join grc_nan_grupo_atendimento grc_nga on grc_nga.idt = grc_at.idt_grupo_atendimento ";
                $sql .= ' where grc_nga.num_visita_atu = 2';
                $sql .= " and grc_nga.geradook = 'N'";
                $rsREG = execsql($sql);

                $jsTmp = '';

                foreach ($rsREG->data as $rowREG) {
                    $idt_avaliacao = $rowREG['idt_avaliacao'];

                    if ($rowREG['pdf_devolutiva'] != '') {
                        $arq = $exportPath.$rowREG['pdf_devolutiva'];
                        if (file_exists($arq)) {
                            unlink($arq);
                        }
                    }

                    $sql = 'update grc_nan_grupo_atendimento SET pdf_devolutiva=NULL WHERE idt = '.null($rowREG['idt_grupo_atendimento']);
                    execsql($sql);

                    $jsTmp .= "
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: 'ajax_grc.php?tipo=DevolutivaPDF',
                                data: {
                                    cas: conteudo_abrir_sistema,
                                    idt_avaliacao: $idt_avaliacao
                                },
                                success: function (response) {
                                    if (response.erro != '') {
                                        alert(url_decode(response.erro));
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                                },
                                async: false
                            });
                    ";
                }

                echo 'FIM...';
                ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        processando();
                        
                        <?php echo $jsTmp; ?>
                        
                        $('#dialog-processando').remove();
                    });
                </script>
            </div>
        </div>
    </body>
</html>
