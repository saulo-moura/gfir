<?php
Require_Once('configuracao.php');

if ($_SESSION[CS]['g_id_usuario'] == '') {

    echo 'Entrada indevida... ';
    // header("Location: ../");
    echo ' <script type="text/javascript" language="JavaScript1.2">';
    echo "    self.location = 'incentrada_indevida.php';";
    echo ' </script> ';
    exit();
}

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
$cont_arq = '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
<?php Require_Once('head.php'); ?>
    </head>
    <body id="body" onload="MenuPodeUsar = true;
            ativaObj();
            if ($.isFunction(self.onLoadPag))
                onLoadPag();" onunload="if ($.isFunction(top.muda_frame))
                top.muda_frame(false);">
        <iframe src="" id="ifrm" name="ifrm" style="display: none;" width="100%" height="100" scrolling="auto" frameborder="1"></iframe>
        <iframe src="" id="ifrm1" name="ifrm1" style="display: none;" width="100%" height="100" scrolling="auto" frameborder="1"></iframe>
        <center>
<?php
echo "<div id='msg_geral'>";
echo "    <div id='msg_geral_cab'>";
echo "         <img onclick='desativa_msg_geral();' src='imagens/fechar.gif' border='0'>";
echo "         Atenção...<br> Problema com a autenticação.";
echo "    </div>";
echo "    <div id='msg_geral_det'>";
echo "    </div>";
echo "</div>";
?>

            <div id="geral">
                <div id="topo_barra">
                    <a href="conteudo.php">Home</a>
                    &nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;
                    <a href="<?php echo $vetConf['url_sebrae_na'] ?>" target="_blank"><span class="oas">SEBRAE-NACIONAL</span></a>
                    &nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;
                    <a href="<?php echo $vetConf['url_sebrae_ba'] ?>" target="_blank"><span class="oas">SEBRAE-BA</span></a>
                    &nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;
                    <a href="<?php echo $vetConf['url_webmail'] ?>" target="_blank">Webmail</a>
                </div>
                <div id="topo" class="topo">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <img src="imagens/trans.gif" height="112" alt="" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">
                                    <?php
                                        echo "<div id='logo_site' >sebrae.PIR</div> ";
                                    ?>

                                <div id="barra_topo">
                                

                                
                                
                                    <div id="usuario">
<?php
echo "<script type='text/javascript'>";
echo "var ajax_alt={$_SESSION[CS]['ajax_alt']};";
echo "</script>";
//cho '<div id="obra">';
// echo "<div id='usuario_t' style='width:100%'>";

echo "<div id='usuario_t' style='width:200px; sborder:1px solid black; float:left;'>";


echo "<span>Usuário:&nbsp;</span>".$_SESSION[CS]['g_nome_completo']."[".$_SESSION[CS]['g_nome_setor']."]";
// Usuário: <?php echo $_SESSION[CS]['g_nome_completo'];
// echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//  echo "<span>Obra:&nbsp;</span>";
$p = $_SESSION[CS]['g_idt_obra'];
//$p=20;


echo "</div>";


echo "<div id='escolhe_obraooo' style='color:#FFFF00; cursor:pointer; float:left;'>";

if ($_SESSION[CS]['g_pri_vez_log'] == 1 or $_SESSION[CS]['g_tipo_usuario'] == 'A') {
    if ($_SESSION[CS]['ajax_alt'] == 0) {
        //   echo "<span id='adm_volta' onclick='return acessa_obras();' title='Clique para poder selecionar Obra' style='cursor:pointer;'>Obras&nbsp;</span>";
    } else {
        //   echo "<span id='adm_volta' onclick='return acessa_obras();' title='Clique para acessar funções do Administrador' style='cursor:pointer;'>Adm.&nbsp;</span>";
    }
    $tam = count($_SESSION[CS]['g_vet_obras']);
    if ($tam == 1) {
        $_SESSION[CS]['g_pri_vez_log'] = 0;
    }
    $vetnada = Array();
    $vetnada[0] = '-- Selecione uma Obra --';
    //  $g_vet_obras_tt= array_merge($vetnada,$_SESSION[CS]['g_vet_obras']);
    //$_SESSION[CS]['g_vet_obras']=$g_vet_obras_tt;
    //   p($g_vet_obras_tt);
    $g_vet_obras_tt = $_SESSION[CS]['g_vet_obras'];
} else {
    //    echo "<span style='float:right;'>Obra:&nbsp;</span>";
    $g_vet_obras_tt = $_SESSION[CS]['g_vet_obras'];
}

echo "</div>";


//$p=0;
if ($_SESSION[CS]['g_pri_vez_log'] == 1) {
    if ($_SESSION[CS]['ajax_alt'] == 0) {
        $esconde_o = 'none';
    } else {
        $esconde_o = 'block';
    }
} else {
    //   criar_combo_vet($_SESSION[CS]['g_vet_obras'], 'obras', $p, '', "onchange = 'funcObra_gc(this)'", 'padding-left:5px; margin-top:0px; font-size : 11px; line-height : 11px; width: 160px;');
    $esconde_o = 'block';
}
echo "<div id='escolhe_obra' style='sborder:1px solid #00FF00; overflow:hidden; width:200px; padding:0px; margin:0px; float:right; display:{$esconde_o};'>";
//if ($_SESSION[CS]['g_pri_vez_log']!=1)
//{
echo "<span style='float:left;'>Obra:&nbsp;</span>";
//}  //line-height : 11px;
criar_combo_vet($g_vet_obras_tt, 'obras', $p, '-- Selecione uma Obra --', "onchange = 'funcObra_gc(this)'", ' float:right; height:19px; padding:0px; padding-left:5px; margin:0px; font-size:11px; width: 160px;');

//criar_combo_vet($g_vet_obras_tt, 'obras', $p, '', "", ' padding:0px; padding-left:5px; margin:0px; font-size:11px; height:21px;  width: 160px;');


echo '</div>';

//  echo '</div>';
//echo '</div>';
//echo ' vvvvvvvvvvvvv '.$p;
?>

                                    </div>

                                    <div id="resto">
                                        <?php echo date("d/m/Y ").(date("H") - date("I")).date(":i"); ?>
                                        - <a href="#" onclick="showPopWin('conteudo_popup.php?menu=email_adm&prefixo=cadastro', 'Comunicação com o Administrador do Sistema', 704, 351)"><img src="imagens/email.gif" width="14" height="14" alt="Comunicação com o Administrador do Sistema" title="Comunicação com o Administrador do Sistema" border="0" /></a>
                                        | <a href="#" onclick="return abre_ajuda('sistema', '')"  title="Ajuda de Utilização do Site" >Ajuda</a>
                                        | <a href="#" onclick="showPopWin('conteudo_popup.php?menu=noticia_sistema&prefixo=inc', 'Notícias do Sistema PCO', 704, 470)"><img src="imagens/noticia.gif" width="14" height="14" title="Notícia do Sistema PCO" border="0" /></a>
                                        | <a href="sair.php" title="Sair do GC - Gerenciador de Conteúdo">Sair</a>
                                    </div>
                                    <div id="dtBanco" style="display: none;"><?php echo date("d/m/Y"); ?></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div id="meio_util">

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
                    <div id="meio">
                        <div id="conteudo">
                            <?php
                            
                             if ($menu != 'vazio') {

                                 $retp="conteudo.php";
                                 $subp=0;
                                 if ($menu== "idc_menu")
                                 {
                                     $vetMenu[$menu]="MÓDULO - IDENTIDADE CORPORATIVA";
                                     $retp="conteudo.php";
                                     $subp=9;
                                 }
                                 if ($menu== "pla_menu")
                                 {
                                     $vetMenu[$menu]="MÓDULO - ESTRATÉGIAS, PROJETOS E PLANO DE AÇÃO";
                                     $retp="conteudo.php";
                                     $subp=1;
                                 }
                                 if ($menu== "cvr_menu")
                                 {
                                     $vetMenu[$menu]="MÓDULO - CADEIA DE VALOR DE RESULTADO";
                                     $retp="conteudo.php";
                                     $subp=1;
                                 }

                                  if ($menu== "rre_menu")
                                 {
                                     $vetMenu[$menu]="MÓDULO - REDE DE RESULTADOS";
                                     $retp="conteudo.php";
                                     $subp=1;
                                 }
                                 if ($menu== "avd_menu")
                                 {
                                     $vetMenu[$menu]="MÓDULO - AVALIAÇÃO E DESVIOS";
                                     $retp="conteudo.php";
                                     $subp=1;
                                 }







                                if ($subp!=9) // substitudo para HOME.... abre a Home...
                                {

                            
                            
                            
                            
                            
//                            if ($menu != 'vazio') {

                                ?>
                                <div id="barra_a">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>


                                            <td nowrap="nowrap" style=' background:#808080; color:#FFFFFF; padding:5px; font-size:14px; ' title='Clique aqui para voltar a Home'><a href="conteudo.php" style='font-weight: bold; color:#FFFFFF;'><?php echo 'Home' ?></a> </td>
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
                                    ImagemMostrar(80, 35, $path, $img, $nm_empreendimento, false, 'idt="'.$idt.'"');
                                } else {
                                    $tam = count($_SESSION[CS]['g_vet_obras']);
                                    if ($tam == 1) {
                                        $path = $_SESSION[CS]['g_path_logo_obra'];
                                        $img = $_SESSION[CS]['g_imagem_logo_obra'];
                                        //$link = 'conteudo.php?prefixo=inc&menu=home&menusite=2';
                                        //echo "<a href='{$link}' >";
                                        ImagemMostrar(80, 35, $path, $img, $nm_empreendimento, false, 'idt="'.$idt.'"');
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
                                        else if ($prefixo == 'listar')
                                            $Require_Once = "listar.php";
                                        else if ($prefixo == 'cadastro')
                                            $Require_Once = "cadastro.php";
                                        else if ($prefixo == 'relatorio')
                                            $Require_Once = "relatorio/$menu.php";
                                        else
                                            $Require_Once = "$prefixo$menu.php";

                                        if ($Require_Once == 'incvazio.php') {
                                            $prefixo = 'inc';
                                            $menu = 'homeobra';
                                            $Require_Once = "$prefixo$menu.php";
                                        }
                                        if (file_exists($Require_Once)) {
                                            Require_Once($Require_Once);
                                        } else {
                                            // echo "<script type='text/javascript'>top.location = 'index.php';</script>";
                                            //echo "Problema em ".$Require_Once;


                                            echo "<script type='text/javascript'>self.location = 'conteudo.php';</script>";
                                            exit();
                                        }

                                        //Se mudar alguma coisa de html depois deste ponto mudar também na função "FimTela"
                                        ?>
                        </div>
                    </div>
                </div>


                <!--<div id="rodape">&nbsp;<div><a href="#" onclick="return abre_ajuda('versao', '<?php echo $versao_site ?>')">Versão: <?php echo $versao_site ?></a></div></div>-->
                
                
        <div id="div_rodape">
            <center>
                <div class="meio crodape">
                    <span>© 2015 SEBRAE-BAHIA</span>
                    <a href="<?php echo $vetConf['url_webmail']; ?>" target="_blank">Webmail</a>
                    <a href="<?php echo $vetConf['url_sebrae_na']; ?>" target="_blank">SEBRAE-NACIONAL</a>
                    <a href="<?php echo $vetConf['url_sebrae_ba']; ?>" target="_blank">SEBRAE-BAHIA</a>
                </div>
            </center>
        </div>

                
                
            </div>

        </center>
    </body>
</html>
