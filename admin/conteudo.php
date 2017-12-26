<?php
Require_Once('configuracao.php');

/*
 * Parametros GET de Controle
 * mostra_menu = N: não mostra | Outro valor: Mostra
 * mostra_barra = N: não mostra | Outro valor: Mostra
 * mostra_topo = N: não mostra | Outro valor: Mostra
 * painel_btvoltar_top = N: não mostra | Outro valor: Mostra
 * painel_btvoltar_rod = N: não mostra | Outro valor: Mostra
 */

if ($_GET['painel_btvoltar_rod'] == '') {
    $_GET['painel_btvoltar_rod'] = 'N';
}

/*
  if ($_SESSION[CS]['g_id_usuario'] == '') {

  echo 'Entrada indevida... ';
  // header("Location: ../");
  echo ' <script type="text/javascript" language="JavaScript1.2">';
  echo "    self.location = 'incentrada_indevida.php';";
  echo ' </script> ';
  exit();
  }
 * 
 */

// echo " 20 xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx<br /> ";


if ($_REQUEST['menu'] == '') {
    $_GET['mostra_menu'] = 'N';
    $menu = 'vazio';
} else {
    $menu = $_REQUEST['menu'];
}

// fixar para não mostrar nunca
$_GET['mostra_menu'] = 'N';


if ($_REQUEST['prefixo'] == '') {
    $prefixo = 'inc';
} else {
    $prefixo = $_REQUEST['prefixo'];
}

$acao = mb_strtolower($_REQUEST['acao']);
$_SESSION[CS]['g_nom_tela'] = $vetMenu[$menu];
$cont_arq = '';

$mostra_barra = '';
if ($_GET['mostra_barra'] == 'N') {
    $mostra_barra = 'style="display: none;"';
}

$mostra_topo = '';
if ($_GET['mostra_topo'] == 'N') {
    $mostra_topo = 'esconde_topo';
}
//$mostra_topo = 'esconde_topo';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php Require_Once('head.php'); ?>
    </head>
    <body id="body" onload="MenuPodeUsar = true;
            ativaObj();
          " onunload="if ($.isFunction(top.muda_frame))
                      top.muda_frame(false);">
        <iframe src="" id="ifrm" name="ifrm" style="display: none;" width="100%" height="100" scrolling="auto" frameborder="1"></iframe>
        <iframe src="" id="ifrm1" name="ifrm1" style="display: none;" width="100%" height="100" scrolling="auto" frameborder="1"></iframe>
        <div id="div_topo" <?php echo $mostra_barra; ?>>
            
                <div class="meio ctopo">
				<center>
				   <table> 
				   <tr>
				   <td>
				   <!-- <a href="<?php echo 'conteudo.php?acao=inc&prefixo=cadastro&direto=S&menu=plu_helpdesk&id=0'; ?>" ><img width='25' height='25' src="imagens/helpdesk.png" title="HelpDesk Sebrae"/></a> -->
				   
				   <a href="<?php echo 'conteudo.php?acao=&prefixo=listar&direto=S&menu=plu_helpdesk&id=0'; ?>" ><img width='25' height='25' src="imagens/helpdesk.png" title="HelpDesk Sebrae"/></a>
				   <!--</div>-->
				   </td>
				   <td>
                   <!-- <a href="<?php echo $vetConf['url_helpdesk']; ?>" target="_blank">HelpDesk Sebrae</a> -->
                    <a style='font-weight:bold; ' href="<?php echo $vetConf['url_sebrae_na']; ?>" target="_blank">Sebrae-Nacional</a>
                    <a style='font-weight:bold; ' href="<?php echo $vetConf['url_sebrae_ba']; ?>" target="_blank">Sebrae-Bahia</a>
                   <!-- <a href="<?php echo $vetConf['url_webmail']; ?>" target="_blank">Webmail</a> -->
				    </td>
					</tr>
				    </table>
                </center>

                </div>
            
        </div>
        <div id="msg_geral">
            <div id="msg_geral_cab">
                <img onclick="desativa_msg_geral();" src="imagens/fechar.gif" border="0" />
                Atenção...<br />Problema com a autenticação.
            </div>
            <div id="msg_geral_det"></div>
        </div>
        <div id="div_geral">
            <center>
                <div id="geral" class="showPopWin_width">
                    <div id="topo" class="topo <?php echo $mostra_topo; ?>">
                        <table border="0" cellspacing="0" width="100%" cellpadding="0">
                            <tr>
                                <td>
                                    <img class="espacamento" src="imagens/trans.gif" height="62" alt="" />
                                    <img id="p_sistema" src="imagens/p_sistema.png" height="62" alt="" />
                                    <img id="p_sebrae" src="imagens/p_sebrae.png" height="50" alt="" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right">
                                    <?php
                                    echo "<div id='logo_site' >crm|Sebrae</div> ";
                                    ?>
                                    <div id="barra_topo">
                                        <div id="usuario">
                                            <?php
                                            echo "<script type='text/javascript'>";
                                            echo "var ajax_alt='{$_SESSION[CS]['ajax_alt']}';";
                                            echo "</script>";
                                            echo "<div id='usuario_t' style='sborder:1px solid black; float:left;'>";

                                            if ($_SESSION[CS]['g_id_usuario'] != '') {
                                                if ($_SESSION[CS]['g_nome_setor'] != "") {
                                                    echo "<span>Usuário:&nbsp;</span>".$_SESSION[CS]['g_nome_completo']."[".$_SESSION[CS]['g_nome_setor']."]";
                                                } else {
                                                    echo "<span>Usuário:&nbsp;</span>".$_SESSION[CS]['g_nome_completo'];
                                                }
                                            }
                                            $p = $_SESSION[CS]['g_idt_obra'];
                                            echo "</div>";
                                            echo "<div id='escolhe_obraooo' style='color:#FFFF00; cursor:pointer; float:left;'>";

                                            if ($_SESSION[CS]['g_pri_vez_log'] == 1 or $_SESSION[CS]['g_tipo_usuario'] == 'A') {
                                                $tam = count($_SESSION[CS]['g_vet_obras']);
                                                if ($tam == 1) {
                                                    $_SESSION[CS]['g_pri_vez_log'] = 0;
                                                }
                                                $vetnada = Array();
                                                $vetnada[0] = '-- Selecione uma Obra --';
                                                $g_vet_obras_tt = $_SESSION[CS]['g_vet_obras'];
                                            } else {
                                                $g_vet_obras_tt = $_SESSION[CS]['g_vet_obras'];
                                            }

                                            echo "</div>";

                                            if ($_SESSION[CS]['g_pri_vez_log'] == 1) {
                                                if ($_SESSION[CS]['ajax_alt'] == 0) {
                                                    $esconde_o = 'none';
                                                } else {
                                                    $esconde_o = 'block';
                                                }
                                            } else {
                                                $esconde_o = 'block';
                                            }

                                            if (count($g_vet_obras_tt) > 1) {
                                                echo "<div id='escolhe_obra' style='sborder:1px solid #00FF00; overflow:hidden; width:200px; padding:0px; margin:0px; float:right; display:{$esconde_o};'>";
                                                echo "<span style='float:left;'>Obra:&nbsp;</span>";
                                                criar_combo_vet($g_vet_obras_tt, 'obras', $p, '-- Selecione uma Obra --', "onchange = 'funcObra_gc(this)'", ' float:right; height:19px; padding:0px; padding-left:5px; margin:0px; font-size:11px; width: 160px;');
                                                echo '</div>';
                                            }
                                            ?>

                                        </div>

                                        <div id="resto">
                                            <?php
                                            echo date("d/m/Y ").(date("H") - date("I")).date(":i");

                                            if ($_SESSION[CS]['g_id_usuario'] == '') {
                                                echo '| <a href="#" onclick="return abre_ajuda(\'sistema\', \'\')"  title="Ajuda de Utilização do Site" >Ajuda</a>';
                                            } else {
                                                echo '| <a href="#" onclick="showPopWin(\'conteudo_popup.php?menu=plu_email_adm&prefixo=cadastro\', \'Comunicação com o Administrador do Sistema\', 704, 351)"><img src="imagens/email.gif" width="14" height="14" alt="Comunicação com o Administrador do Sistema" title="Comunicação com o Administrador do Sistema" border="0" /></a>';
                                                echo '| <a href="#" onclick="return abre_ajuda(\'sistema\', \'\')"  title="Ajuda de Utilização do Site" >Ajuda</a>';
                                                //echo '| <a href="#" onclick="showPopWin(\'conteudo_popup.php?menu=plu_noticia_sistema&prefixo=inc\', \'Notícias do Sistema\', 704, 470)"><img src="imagens/noticia.gif" width="14" height="14" title="Notícia do Sistema" border="0" /></a>';
												echo '| <a href="#" onclick="showPopWin(\'conteudo_popup.php?menu=noticia_sistema&prefixo=inc\', \'Notícias do Sistema\', 704, 470)"><img src="imagens/noticia.gif" width="14" height="14" title="Notícia do Sistema" border="0" /></a>';
                                                echo '| <a href="sair.php" title="Sair do GC - Gerenciador de Conteúdo">Sair</a>';
                                            }
                                            ?>
                                        </div>
                                        <div id="dtBanco" style="display: none;"><?php echo date("d/m/Y"); ?></div>
                                        <input type="hidden" id="dtBancoObj" value="<?php echo date("d/m/Y"); ?>" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="meio_util">
                        <?php if ($_GET['mostra_menu'] != 'N' && $_SESSION[CS]['g_mostra_menu'] == 'S') { ?>
                            <div id="barra_menu">
                                <div id="menu">
                                    <?php
                                    if ($_SESSION[CS]['g_pri_vez_log'] == 1 and $_SESSION[CS]['g_tipo_usuario'] != 'A' and $_SESSION[CS]['g_idt_obra'] == '') {
                                        // $_SESSION[CS]['g_pri_vez_log']=0;
                                        //echo '<div id="menu_escolha">';
                                        echo '<span onclick="return acessa_obras();" style=" cursor:pointer; margin-left:10px; font-size: 14px; font-weight: bold; color:#FFFF00; ">';
                                        echo 'Favor escolher uma Obra ';
                                        //echo '<div>';
                                    } else {
                                        // p($_SESSION[CS]['g_strMenuJS']);
                                        ?>

                                        <script type="text/javascript" language="JavaScript1.2">
                                            function alert() {
                                            }
                                        </script>
                                        <link href="menu/style.css" rel="stylesheet" type="text/css" />
                                        <script type='text/javascript' src='menu/quickmenu.php'></script>
                                        <script type="text/javascript" language="JavaScript1.2">
                                            function alert(Msg) {
                                                ifrm.window.alert(Msg);
                                                //alert_sistema(Msg);
                                            }
                                        </script>

                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div id="meio">
                            <div id="conteudo">
                                <?php
                                //echo "$menu --------------------- <br>";
                                if ($menu != 'vazio') {
                                    ?>
                                    <div id="barra_a">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td nowrap="nowrap" style=' background:#808080; color:#FFFFFF; padding:5px; font-size:14px; ' title='Clique aqui para voltar a Home'><a href="conteudo.php" style='font-weight: bold; color:#FFFFFF;'><?php echo 'Home' ?></a> </td>
                                                <td><img alt="" src="imagens/trans.gif" width="20" height="1" /></td>
                                                <td><?php bt_volta_painel('top'); ?></td>
                                                <td><img alt="" src="imagens/trans.gif" width="20" height="1" /></td>
                                                <td nowrap="nowrap"><?php echo $vetMenu[$menu].($vetDireito[$acao] == '' ? '' : ' :: '.$vetDireito[$acao]) ?></td>
                                                <td><img alt="" src="imagens/trans.gif" width="20" height="1" /></td>
                                                <td width="100%" align="center"><?php echo $vetMigalha[$menu] == '' ? '' : '| '.$vetMigalha[$menu].' |' ?></td>
                                                <td><img alt="" src="imagens/trans.gif" width="20" height="1" /></td>
                                                <?php
                                                echo '<td>';
                                                echo "<div style='float:right; margin-right:20px;'>";
                                                if ($_SESSION[CS]['g_pri_vez_log'] != 1) {

                                                    $path = $_SESSION[CS]['g_path_logo_obra'];
                                                    $img = $_SESSION[CS]['g_imagem_logo_obra'];
                                                    //$link = 'conteudo.php?prefixo=inc&menu=home&menusite=2';
                                                    //echo "<a href='{$link}' >";
                                                    // ImagemMostrar(80, 35, $path, $img, $nm_empreendimento, false, 'idt="'.$idt.'"');
                                                } else {
                                                    $tam = count($_SESSION[CS]['g_vet_obras']);
                                                    if ($tam == 1) {
                                                        $path = $_SESSION[CS]['g_path_logo_obra'];
                                                        $img = $_SESSION[CS]['g_imagem_logo_obra'];
                                                        //$link = 'conteudo.php?prefixo=inc&menu=home&menusite=2';
                                                        //echo "<a href='{$link}' >";
                                                        // ImagemMostrar(80, 35, $path, $img, $nm_empreendimento, false, 'idt="'.$idt.'"');
                                                    }
                                                }
                                                echo "</div>";
                                                echo '</td>';
                                                ?>
                                                <td nowrap="nowrap" style="font-size:18px; font-weight: bold;"><a href="#" onclick="return abre_ajuda()" title="Ajuda da Função">&nbsp;?&nbsp;</a></td>

                                            </tr>
                                        </table>
                                    </div>
                                    <?php
                                }

                                if ($_SESSION[CS]['g_id_usuario'] == '')
                                    $Require_Once = "inclogin.php";
                                else if ($prefixo == 'listar' || $prefixo == 'listar_rel' || $prefixo == 'listar_cmb' || $prefixo == 'listar_cmbmulti')
                                    $Require_Once = "listar.php";
                                else if ($prefixo == 'cadastro')
                                    $Require_Once = "cadastro.php";
                                else if ($prefixo == 'relatorio')
                                    $Require_Once = "relatorio/$menu.php";
                                else
                                    $Require_Once = "$prefixo$menu.php";


                                if ($prefixo == 'mod') {  // chama modulo
                                    //$menu = "idc_menu";
                                    $Require_Once = "$prefixo$menu.php";
                                }
//echo " $Require_Once ";
                                if ($Require_Once == 'incvazio.php') {
                                    $prefixo = 'inc';
									
                                    $menu = 'homeobra';
									
                                    $Require_Once = "$prefixo$menu.php";

                                    // $Require_Once = "modidc_menu.php";
                                }

                                if ($vetFuncaoSistema[$menu] != '') {
                                    $Require_Once = "abrir_sistema_chama.php";
                                }

                                if ($_SESSION[CS]['g_senha_antiga'] == md5($vetConf['senha_padrao']) || $_SESSION[CS]['alterar_senha'] != 'N') {
                                    $_SESSION[CS]['alterar_senha'] = 'N';

                                    if ($_SESSION[CS]['g_ldap'] != 'S') {
                                        $menu = 'plu_senha';
                                        $prefixo = 'cadastro';
                                        $_GET['menu'] = $menu;
                                        $_GET['prefixo'] = $prefixo;
                                        $Require_Once = "cadastro.php";

                                        if ($_SESSION[CS]['g_senha_antiga'] == md5($vetConf['senha_padrao'])) {
                                            echo "<script>alert('Sr(a) ".$_SESSION[CS]['g_nome_completo'].",\\n\\nVocê esta utilizando a senha inicial do seu cadastro.\\nFavor alterar a senha por uma questão de segurança.');</script>";
                                        }
                                    }
                                }

                                if (file_exists($Require_Once)) {
                                    if ($_SESSION[CS]['painel_passo'][$menu] != '') {
                                        if ($_GET['origem_tela'] == 'menu') {
                                            unset($_SESSION[CS]['painel_passo'][$menu]);
                                        } else {
                                            $codigo_painel_passo = 'S';
                                            require_once $_SESSION[CS]['painel_passo'][$menu];
                                        }
                                    }

                                    Require_Once($Require_Once);

                                    bt_volta_painel('rod');
                                } else {
                                    // echo "<script type='text/javascript'>top.location = 'index.php';</script>";
                                    //echo "Problema em ".$Require_Once;


                                    if ($prefixo == 'xjanela') {
                                        //echo " $Require_Once ";
                                        echo "<script>  ";
                                        echo "  var  left   = 0; ";
                                        echo "  var  top    = 0; ";
                                        echo "  var  height = $(window).height(); ";
                                        echo "  var  width  = $(window).width();  ";
                                        echo "  var link_pg='$menu'; ";
                                        echo '  window.open(link_pg,"PgPo","left="+left+",top="+top+",width="+width+",height="+height+",resizable=yes,menubar=no,scrollbars=yes,toolbar=no"); ';



                                        //echo '  window.history.back(); ';
                                        //exit();




                                        echo " </script>  ";
                                    } else {

                                        echo "<script type='text/javascript'>self.location = 'conteudo.php';</script>";
                                        exit();
                                    }
                                }

//Se mudar alguma coisa de html depois deste ponto mudar também na função "FimTela"
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </center>
        </div>
        <div id="div_rodape">
            <center>
                <div class="meio crodape">
                    <span>© 2017 Sebrae-Bahia</span>
                    <!-- <a href="<?php echo $vetConf['url_webmail']; ?>" target="_blank">Webmail</a> -->
                    <a href="<?php echo $vetConf['url_sebrae_ba']; ?>" target="_blank">Sebrae-Bahia</a>
                    <a href="<?php echo $vetConf['url_sebrae_na']; ?>" target="_blank">Sebrae-Nacional</a>
                    <!-- <a href="<?php echo $vetConf['url_helpdesk']; ?>" target="_blank">HelpDesk Sebrae</a> -->
                    <div id="rodape"><a href="#" onclick="return abre_ajuda('versao', '<?php echo $versao_site ?>')">Versão: <?php echo $versao_site ?></a></div>
                </div>
            </center>
        </div>
    </body>
</html>
