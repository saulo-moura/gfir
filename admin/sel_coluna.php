<?php
Require_Once('configuracao.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title><?php echo $nome_site ?></title>
        <link href="<?php echo $style ?>padrao.css" rel="stylesheet" type="text/css" />
        <script language="JavaScript" src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
        <style type="text/css">
            body {
                margin: 15px;
                background: #ffffff;
            }

            div.Titulo {
                padding: 10px;
                padding-bottom: 0px;
            }

            label, input {
                cursor: pointer;
            }

        </style>
        <script type="text/javascript">
            var ajax_plu = '<?php echo ajax_plu ?>';
            var conteudo_abrir_sistema = '<?php echo conteudo_abrir_sistema ?>';

            $(document).ready(function () {

                ajusta_altura_PopWin('');

                $('input:button').click(function () {

                    var pendencia = $(':checked').map(function () {
                        return this.value;
                    }).get();

                    if (pendencia == '') {
                        alert('Favor selecionar pelo menos uma coluna!');
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: ajax_plu + '&tipo=SelColuna',
                            data: {
                                cas: conteudo_abrir_sistema,
                                session_cod: '<?php echo $_GET['id']; ?>',
                                dados: pendencia
                            },
                            success: function (response) {
                                if (response.erro == '') {
                                    parent.document.frm.submit();
                                } else {
                                    alert(url_decode(response.erro));
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                            },
                            async: false
                        });
                    }
                });
            });

            function ajusta_altura_PopWin(height) {
                if (height == '') {
                    height = $("body").outerHeight() + 60;
                }

                var height_pai = recAlturaPopWin(self.parent, height + 60);

                if (height > height_pai) {
                    height = height_pai;
                }

                parent.heightPopWin(height);
            }

            function recAlturaPopWin(tela, height) {
                if ($.isFunction(tela.ajusta_altura_PopWin)) {
                    var height_atu = tela.gMaxHeight - 60;
                    var height_max = recAlturaPopWin(tela.parent, height + 60);

                    if (height > height_atu) {
                        if (height > height_max) {
                            height = height_max;
                            tela.parent.heightPopWin(height);
                            return height - 60;
                        } else {
                            height += 30;

                            if (height > height_max) {
                                height = height_max;
                            }

                            tela.parent.heightPopWin(height);
                            return height - 60;
                        }
                    } else {
                        return height_atu;
                    }
                } else {
                    return tela.gMaxHeight;
                }
            }
        </script>
    </head>
    <body>
        <div>
            <div class="Tit_Campo_Obr">Selecione os Campos que deseja exportar:</div>
            <?php
            if (!is_array($_SESSION[CS]['tmp']['sel_coluna'][$_GET['id']])) {
                $rs = Array();
            } else {
                $rs = $_SESSION[CS]['tmp']['sel_coluna'][$_GET['id']];
            }

            $checked = $_SESSION[CS]['tmp']['chk_coluna'][$_GET['id']];
            
            if ($checked == '') {
                $checked = Array();
            } 
            
            foreach ($rs as $campo => $row) {
                if (!in_array($campo, $checked) && count($checked) > 0) {
                    $chk = '';
                } else {
                    $chk = 'checked';
                }

                echo '<input type="checkbox" ' . $chk . ' value="' . $campo . '" id="' . $campo . '">&nbsp;&nbsp;';
                echo '<label for=' . $campo . '>' . $row['nome'] . '</label><br />';
            }
            ?>
            <center>
                <br/>
                <input type="button" class="BtPesquisa" value="Selecionar Coluna">
            </center>
        </div>
    </body>
</html>