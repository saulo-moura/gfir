<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
if ($_REQUEST['cas'] == '') {
    $_REQUEST['cas'] = 'conteudo_abrir_sistema';
}
define('conteudo_abrir_sistema', $_REQUEST['cas']);

Require_Once('configuracao.php');

if ($_REQUEST['menu'] == '')
    $menu = 'vazio';
else
    $menu = $_REQUEST['menu'];

if ($_REQUEST['prefixo'] == '')
    $prefixo = 'inc';
else
    $prefixo = $_REQUEST['prefixo'];

$acao = mb_strtolower($_REQUEST['acao']);
$_SESSION[CS]['g_nom_tela'] = $vetMenu[$menu];
$cont_arq = '_cadastro';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php Require_Once('head.php'); ?>
        <script type="text/javascript">
            var returnVal = '';

            $(document).ready(function () {
                MenuPodeUsar = true;
                ativaObj();

                ajusta_altura_PopWin('');
            });

            function ajusta_altura_PopWin(height) {
                if (height == '') {
                    height = $("body").outerHeight() + 30;
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
                if ($_SESSION[CS]['g_id_usuario'] == '') {
                    $msg = 'timeout do sistema';
                    $tipo = 'timeout';
                    $inf_extra = Array(
                    );
                    erro_try($msg, $tipo, $inf_extra);

                    echo "<div align='center' class='Msg'>Favor entrar no sistema outra vez!</div>";
                } else {

					$funil_idt_cliente_classificacao = $_GET['funil_idt_cliente_classificacao'];
					
					$sqlt  = " select grc_ff.idt, ";
					$sqlt .= "        grc_ff.codigo, ";
					$sqlt .= "        grc_ff.descricao, ";
					$sqlt .= "        grc_ff.nome, ";
					$sqlt .= "        grc_ff.cordafase, ";
					$sqlt .= "        grc_ff.cortextfase, ";
					$sqlt .= "        grc_ff.detalhe ";
					$sqlt .= " from ".db_pir_grc."grc_funil_fase grc_ff ";
					$sqlt .= " where  idt = ".null($funil_idt_cliente_classificacao) ;
					$rst   = execsql($sqlt);
					foreach ($rst->data as $rowt) {
						$idt           = $rowt['idt'];
						$codigo        = $rowt['codigo'];
						$descricao     = $rowt['descricao'];
						$nome          = $rowt['nome'];
						$cordafase     = '#'.$rowt['cordafase'];
						$cortextfase   = '#'.$rowt['cortextfase'];
						$detalhe       = $rowt['detalhe'];
						if ($rowt['cordafase']=="")
						{
						    $cordafase="#E0E0E0";
						}
						if ($rowt['cortextfase']=="")
						{
						    $cordafase="#666666";
						}
						$funil_bgc_cor = $cordafase;
						$funil_txt_cor = $cortextfase;
					}
					echo "<br />";
					echo "<table border='1' cellspacing='0' cellpadding='1' width='100%' style='width:100%; ' >";
					/*
					echo "<tr>";
					echo "<td style='font-size:18px; background:#2F65BB; color:#FFFFFF; text-align:center; font-weight: bold;  ' >";
					echo "FUNIL DE ATENDIMENTO - Orientação Técnica";
					echo "</td>"; 
					echo "</tr>";
					*/
					echo "<tr>";
					echo "<td style='font-size:18px; background:{$funil_bgc_cor}; color:{$cortextfase}; text-align:center; font-weight: bold;  ' >";
					echo $descricao;
					echo "</td>"; 
					echo "</tr>";
					
					 echo "<tr>";
					echo "<td style='font-size:18px; background:#F1F1F1; color:#666666; text-align:left; font-weight: bold;  ' >";
					echo $detalhe;
					echo "</td>"; 
					echo "</tr>";
					echo "</table>";
				}
				
				
				
				
				
                ?>
            </div>
        </div>
    </body>
</html>
