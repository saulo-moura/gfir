<?php
//  echo ' <script type="text/javascript" language="JavaScript1.2">';
//  echo "    self.location = 'admin/conteudo.php';";
//  echo ' </script> ';
//  exit();

Require_Once('configuracao.php');

if ($_REQUEST['menu'] == 'empreendimento') {
    // echo ' <script type="text/javascript" language="JavaScript1.2">';
    // echo "    self.location = 'admin/conteudo.php';";
    // echo ' </script> ';
    // exit();
}


//p($_SESSION[CS]);
if ($_REQUEST['menu'] == '')
    $menu = 'home';
else
    $menu = $_REQUEST['menu'];

if ($_REQUEST['prefixo'] == '')
    $prefixo = 'inc';
else
    $prefixo = $_REQUEST['prefixo'];


$gestao_obras = $_GET['gestao_obras'];
if ($gestao_obras == 'GGOO') {
    $_REQUEST['obra_escolhida'] = 999;
    $idt_obra_escolhida = 999;
    $_REQUEST['idt'] = 999;
    $_SESSION[CS]['g_vetBarraMenu'] = '';
}

$procedimento_obras = $_GET['procedimento_obras'];
if ($procedimento_obras == 'PROO') {
    $_REQUEST['obra_escolhida'] = 888;
    $idt_obra_escolhida = 888;
    $_REQUEST['idt'] = 888;
    $_SESSION[CS]['g_vetBarraMenu'] = '';
}



$acessa_obras_ge = $_REQUEST['acessa_obras_ge'];
if ($acessa_obras_ge == 'S') {
    $_REQUEST['obra_escolhida'] = '';
    $idt_obra_escolhida = 0;
    $_REQUEST['idt'] = 0;
    $_SESSION[CS]['g_idt_obra'] = '';
    $_SESSION[CS]['g_vetBarraMenu'] = '';
}


$_REQUEST['obra_escolhida'] = "";
if ($_REQUEST['obra_escolhida'] == '') {
    $idt_obra_escolhida = 0;
} else {
    $idt_obra_escolhida = $_REQUEST['idt'];

    ////////////////// erro de não posicionar corretamente na obra

    $_SESSION[CS]['g_idt_obra'] = $idt_obra_escolhida;
    //$_SESSION[CS]['g_nm_obra']  = $nm_obra;
    $sql = "select 	      ";
    $sql .= "     em.*       ";
    $sql .= " from empreendimento em ";
    $sql .= " where idt = ".$_SESSION[CS]['g_idt_obra'];



    // $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $path = $dir_file.'/empreendimento/';
        $_SESSION[CS]['g_path_logo_obra'] = $path;
        $_SESSION[CS]['g_imagem_logo_obra'] = $row['imagem'];
        $_SESSION[CS]['g_nm_obra'] = $row['descricao'];
        $_SESSION[CS]['g_obra_orc_real'] = $row['orcamento_real'];
        $_SESSION[CS]['g_obra_orc_incc'] = $row['orcamento_incc'];
        $vetper = Array();
        //$vetper[]=' guy 1';

        $_SESSION[CS]['g_indicador_fluxo_financeiro'] = $row['indicador_fluxo_financeiro'];
        $_SESSION[CS]['g_ativo'] = $row['ativo'];

        $_SESSION[CS]['data_incc_obra_dia'] = $row['data_incc_obra_dia'];
        $_SESSION[CS]['data_incc_obra_mes'] = $row['data_incc_obra_mes'];
        $_SESSION[CS]['data_incc_obra_ano'] = $row['data_incc_obra_ano'];


        $_SESSION[CS]['g_periodo_obra'] = '';
        // $vetper = calculaperiodoobra($row,1);
        $_SESSION[CS]['g_periodo_obra'] = $vetper;
        // $vetper = calculaperiodoobra($row,2);
        $_SESSION[CS]['g_periodo_obra_fl'] = $vetper;

        //menu_obra($_SESSION[CS]['g_idt_obra']);
    }
    if ($idt_obra_escolhida == 999 or $idt_obra_escolhida == 888) {
        //menu_obra($_SESSION[CS]['g_idt_obra']);
    }






    //////////////////////////////////////////////////////////////









    if ($_SESSION[CS]['g_acesso_obra_ant'] == '') {
        $_SESSION[CS]['g_acesso_obra_ant'] = $_SESSION[CS]['g_acesso_obra'];
    }
    $_SESSION[CS]['idt_obra_escolhida'] = $idt_obra_escolhida;
    $_SESSION[CS]['g_acesso_obra'] = $idt_obra_escolhida;
}
if ($_SESSION[CS]['idt_obra_escolhida'] != '') {
    $idt_obra_escolhida = $_SESSION[CS]['idt_obra_escolhida'];
    //$_SESSION[CS]['idt_obra_escolhida'] ='';
} else {
    
}

if ($_REQUEST['menusite'] == '') {
    
} else {
    $menu_site = $_REQUEST['menusite'];
    if ($menu_site == 2) {
        $_SESSION[CS]['idt_obra_escolhida'] = '';
        $_SESSION[CS]['g_acesso_obra'] = $_SESSION[CS]['g_acesso_obra_ant'];
        $idt_obra_escolhida = 0;
    }
}



$acao = mb_strtolower($_REQUEST['acao']);
$cont_arq = '';

$mes = Array(
    1 => 'Janeiro',
    2 => 'Fevereiro',
    3 => 'Março',
    4 => 'Abril',
    5 => 'Maio',
    6 => 'Junho',
    7 => 'Julho',
    8 => 'Agosto',
    9 => 'Setembro',
    10 => 'Outubro',
    11 => 'Novembro',
    12 => 'Dezembro'
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php Require_Once('head.php'); ?>
    </head>
    <body id="body">
        <iframe src="" id="ifrm" name="ifrm" style="display: none;" width="100%" height="100" scrolling="auto" frameborder="1"></iframe>
        <div id="div_topo">
            <center>
                <div class="meio ctopo">
                    <a href="<?php echo $vetConf['url_helpdesk']; ?>" target="_blank">HelpDesk Sebrae</a>
                    <a href="<?php echo $vetConf['url_sebrae_na']; ?>" target="_blank">Sebrae-Nacional</a>
                    <a href="<?php echo $vetConf['url_sebrae_ba']; ?>" target="_blank">Sebrae-Bahia</a>
                    <!-- <a href="<?php echo $vetConf['url_webmail']; ?>" target="_blank">Webmail</a> -->
                </div>
            </center>
        </div>
        <div id="div_geral">
            <center>
                <div id="geral">
                    <div id="topo" class="topo">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
                                    <img src="imagens/trans.gif" height="62" alt="" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right">
                                    <?php
                                        echo "<div id='logo_site' >sebrae.GRC</div> ";
                                    ?>

                                    <div id="barra_topo">
                                        <?php
                                        if ($_SESSION[CS]['g_nome_completo'] != '') {
                                            //  echo "<div id='usuario'>Usuário: {$_SESSION[CS]['g_nome_completo']}[{$_SESSION[CS]['g_tipo_usuario']}]</div> ";
                                            echo "<div id='usuario'>Usuário: {$_SESSION[CS]['g_nome_completo']} </div> ";
                                        } else {
                                            echo "<div id='usuario'>Seja bem-vindo</div> ";
                                        }
                                        ?>
                                        <div id="resto"><?php echo 'Salvador, '.date("d").' de '.$mes[date("n")].' de '.date("Y"); ?>
                                        </div>
                                        <div id="dtBanco" style="display: none;"><?php echo date("d/m/Y") ?></div>
                                        <input type="hidden" id="dtBancoObj" value="<?php echo date("d/m/Y"); ?>" />
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="subbarra">
                        <?php
                        if ($menu != 'home') {
                            echo '<div id="menu_float_bt"><img src="imagens/seta_cima_32.png" title="Menu do Sistema" />Menu</div>';
                            $conteudo_width = 'style="width: 1000px;"';
                            $menu_float = 'class="menu_float"';
                        } else {
                            $conteudo_width = '';
                            $menu_float = '';
                        }

                        if ($_SESSION[CS]['g_nome_completo'] != '') {
                            ?>
                            <div id="administrar_site">
                                <a href="sair.php"  title="Clique aqui para efetuar logoff no site" ><img src="imagens/bt_fechar_red_32.png" title="Clique aqui para efetuar Logoff do Site" alt="Sair"/></a>
                            </div>
                            <?php
                        }

                        if ($_SESSION[CS]['g_gerador_conteudo'] == 'S') {
                            ?>

                            <div id="administrar">

                                <span onclick="desativa_gc();" title="Recolhe usuario e senha"  style="float: left;">||<img src="imagens/bt_ok_azul_32.png" title="Clique aqui para ter acesso ao Gerenciador de Conteúdo" alt="Clique aqui para ter acesso ao Sistema" /></span>
                            </div>

                            <div id="administrar_gc">
                                <img src="imagens/bt_lock_32.png" onclick="ativa_gc();" title="Clique aqui para ter acesso ao Gerenciador de Conteúdo" alt="Clique aqui para ter acesso ao Sistema"/>
                            </div>

                            <?php
                        }

                        if ($_SESSION[CS]['g_gerador_conteudo'] == 'S') {
                            ?>
                            <div id="login_gc">
                                Usuário: <input class="Texto" type="text" value="" name="login"  title="Digite o Usuário de acesso ao Sistema" alt="Digite o Usuário de acesso ao Sistema" />
                                &nbsp;
                                Senha: <input class="Texto" type="password" value="" name="senha" title="Digite a senha de acesso ao Sistema" alt="Digite a senha de acesso ao Sistema"/>
                                &nbsp;

                            </div>

                            <?php
                        }
                        ?>

                        <ul>
                            <li><a href="conteudo.php?menusite=1"  title="Clique aqui para voltar a tela principal desse site" >Home</a></li>
                            <li><a href="conteudo.php?prefixo=inc&menu=plu_contato" title="Clique aqui para ter acesso ao Fale Conosco" >|&nbsp;&nbsp;Fale Conosco</a></li>
                            <li><a href="conteudo.php?prefixo=inc&menu=plu_duvida"  title="Clique aqui para ter acesso a visualizar as Dúvidas mais frequentes sobre a utilização do Sistema">|&nbsp;&nbsp;Dúvidas</a></li>
                            <?php
                            if ($_SESSION[CS]['g_gerador_conteudo'] == 'S') {
                                echo '  <li><a href="conteudo.php?prefixo=inc&menu=plu_ajudalogin_adm"  title="Clique aqui para ter acesso a Ajuda para efetuar Login no Gerenciador de Conteúdo">|&nbsp;&nbsp;Ajuda Login</a></li> ';
                            } else {
                                echo '  <li><a href="conteudo.php?prefixo=inc&menu=plu_ajudalogin"  title="Clique aqui para ter acesso a Ajuda para efetuar Login no Site">|&nbsp;&nbsp;Ajuda Login</a></li> ';
                            }

                            //echo '  <li><a href="incsair_sistema.php"  title="Clique aqui para sair do Site" >|&nbsp;&nbsp;Sair</a></li>';
                            ?>
                        </ul>
                    </div>
                    <div id="meio">
                        <?php
                        $idt_obra_escolhida = 0;

//              if ($_SESSION[CS]['g_acesso_obra']!='0')
                        $temmenu = 0;
                        if ($_SESSION[CS]['g_nome_completo'] != '' and $_SESSION[CS]['g_acesso_obra'] != '0') {
                            echo '<div id="menu" '.$menu_float.'>';
                            $temmenu = 1;
                        } else if ($idt_obra_escolhida == 0) {
                            echo '<div id="menu" '.$menu_float.'>';
                            $temmenu = 1;
                        }
                        ?>

                        <?php
                        // echo " 222222222 <br />";
                        menu_obra($idt_obra_escolhida);
                        // echo "------<br />";
                        // p($vetMenu);
                        //  if (($_SESSION[CS]['g_nome_completo'] != '' and $_SESSION[CS]['g_acesso_obra'] != '0') or ($idt_obra_escolhida != 0)) {


                        if (($_SESSION[CS]['g_nome_completo'] != '' and $_SESSION[CS]['g_acesso_obra'] != '0') or ( $idt_obra_escolhida == 0)) {

                            echo '<ul>';
                            ForEach ($vetMenu as $idx => $nome) {
                                $pre = $vetMenuDados[$idx]['des_prefixo'];

                                $cor_ativo = '';
                                $url_ativo = '';
                                if ($idx == $menu) {
                                    $cor_ativo = ' background-color: #DDDBDB';
                                    $url_ativo = ' font-weight: bold; color: rgb(162,162,162);';
                                }

                                if ($vetMenuSub[$idx] == '')
                                    $sel = ' sem_filho="S" class="seta" style="'.$cor_ativo.'" ';
                                else
                                    $sel = 'class="seta_sub" lang="'.$vetMenuSub[$idx].'" style="display: none;'.$cor_ativo.'"';

                                if (in_array($idx, $vetMenuSub))
                                    echo '<li id="'.$idx.'" class="mais"><a href="#" style="'.$url_ativo.'" xonclick="return MenuSub(\''.$idx.'\')">'.$nome.'</a></li>';
                                else {
                                    echo '<li '.$sel.'>';

                                    echo '<a style="'.$url_ativo.'" href="conteudo.php?prefixo='.$pre.'&menu='.$idx.'">';

                                    echo $nome.'</a></li>';
                                }
                            }

                            echo '</ul>';
                        } else {

                            //   echo "<div id='lado_esquerdo_home'>";
                            //   echo '</div>';
                        }

                        if ($_SESSION[CS]['g_nome_completo'] != '' and $_SESSION[CS]['g_acesso_obra'] != '0') {
                            echo '</div>';
                        } else if ($idt_obra_escolhida == 0) {
                            echo '</div>';
                        }
                        ?>


                        <?php
                        if ($_SESSION[CS]['g_nome_completo'] != '') {
                            echo '<div id="conteudo" '.$conteudo_width.'>';
                        }
                        ?>


                        <?php
                        $lg = 0;
                        if ($_SESSION[CS]['g_nome_completo'] != '' or $menu == 'plu_contato' or $menu == 'plu_ajudalogin' or $menu == 'plu_duvida') {

                            switch ($menu) {
                                case 'empreendimento':
                                    $idxBarra = $menu.'_'.$_GET['estado'];
                                    break;

                                default:
                                    $idxBarra = $menu;
                                    break;
                            }
                            //p($idxBarra);
                            //p($vetBarraMenu);
                            //exit();




                            if ($vetBarraMenu[$idxBarra] != '') {
                                //  echo '<div id="barra"><div id="tela"><div class="tit_home">';


                                $url_volta = 'conteudo'.$cont_arq.'.php';
                                // echo      'mnmnmnm mnmn '.$url_volta;
                            // guy     echo '<div id="barra"><div id="tela"><div class="tit_home" title="Clique aqui para voltar" onclick="self.location = '."'".$url_volta."'".'">';


                                if ($menu == 'empreendimento') {
                                    //echo 'Selecione o '.$vetBarraMenu[$idxBarra];
                           // guy          echo 'Selecione o Sistema e Ambiente para Acesso';
                                } else {
                           // guy          echo $vetBarraMenu[$idxBarra];
                                }
                                //       echo '&nbsp;&nbsp;</div></div>';
                           // guy     echo '&nbsp;&nbsp;</div>';



                                echo '<div id="tela_assina_obra">';
                                if ($_SESSION[CS]['g_vetMenuAss'][$menu] != '') {

                                    $texto_assina = '';
                                    $reabertura_assina = $_SESSION[CS]['g_reabertura_ass'][$menu];

                                    $nome_assina = $_SESSION[CS]['g_vetMenuAss_nome_ass'][$menu];
                                    $data_assina = $_SESSION[CS]['g_vetMenuAss_data_ass'][$menu];

                                    $nome_assina2 = $_SESSION[CS]['g_vetMenuAss_nome_ass2'][$menu];
                                    $data_assina2 = $_SESSION[CS]['g_vetMenuAss_data_ass2'][$menu];

                                    if ($nome_assina == '') {
                                        $texto_assina = 'Sem registro de Assinatura ';
                                    } else {
                                        if ($reabertura_assina != 'S') {
                                            $texto_assina = 'Assinado por '.$nome_assina.' em '.$data_assina;
                                        } else {
                                            $texto_assina = '<span style="color:#004080;">Reaberto por '.$nome_assina.' em '.$data_assina."</pan>";
                                        }
                                        if ($nome_assina2 != '') {
                                            $texto_assina.=' e '.$nome_assina2.' em '.$data_assina2;
                                        }
                                    }


                                    $chave = $_SESSION[CS]['g_vetMenuAss'][$menu];
                                    // p($chave);

                                    $parametrow = '';

                                    $permite_assinar = Verifica_Pode_Assinar($menu, $chave, $parametrow);

                                    //                                  p($parametrow);
                                    // if ($_SESSION[CS]['g_vet_assina_obras_site'][$_SESSION[CS]['g_idt_obra']]==$_SESSION[CS]['g_idt_obra'])
                                    if ($permite_assinar == 'S') {
                                        // mostrar cadeado
                                        $idt_obra = $_SESSION[CS]['g_idt_obra'];
                                        $idt_usu = $_SESSION[CS]['g_id_usuario'];
                                        echo '<a  title="Clique aqui para Autenticar Informação Site" ><img src="imagens/cadeado.gif" width="16" height="16" title="Clique aqui para Autenticar Informação Site" onclick="return assina_tela('."".$idt_obra.", "."".$idt_usu.", "."'".$chave."'".');" alt="Autenticar Informação Site" /><span id="id_ass_t" >'.$texto_assina.'</span></a>';
                                    } else {
                                        if ($parametrow[2] == 'S') {
                                            echo "<a><div title='Status PARADO de Assinatura.' style='text-align:center; float:left; color:#FFFFFF; background:#C00000;   width:16px; height:16px; margin-right:4px; ' >P</div>{$texto_assina}</a>";
                                        } else {

                                            if ($parametrow[3] == 'S') {   // sem perfil para assinar esse item
                                                echo "<a>{$texto_assina}</a>";
                                            } else {
                                                echo "<a>{$texto_assina}</a>";
                                            }
                                        }
                                    }
                                } else {
                                    echo "<a>{$texto_assina}</a>";
                                }
                                echo '</div>';
                                echo '</div>';

                                if ($_SESSION[CS]['g_imagem_logo_obra'] != '' or $idt_obra_escolhida == 999 or $idt_obra_escolhida == 888) {
                                    if ($menu != 'empreendimento') {
                                        echo '<div id="tela_logo_obra">';
                                        //p(' vvvvv '.$_SESSION[CS]['g_vetMenuAss']);
                                        /*
                                          if ( $_SESSION[CS]['g_vetMenuAss'][$menu]!='')
                                          {
                                          $chave=$_SESSION[CS]['g_vetMenuAss'][$menu];
                                          if ($_SESSION[CS]['g_vet_assina_obras_site'][$_SESSION[CS]['g_idt_obra']]==$_SESSION[CS]['g_idt_obra'])
                                          {
                                          // mostrar cadeado
                                          $idt_obra = $_SESSION[CS]['g_idt_obra'] ;
                                          $idt_usu  = $_SESSION[CS]['g_id_usuario'];
                                          echo '<a  title="Clique aqui para Autenticar Informação Site" ><img src="imagens/cadeado.gif" title="Clique aqui para Autenticar Informação Site" onclick="return assina_tela('."".$idt_obra.", "."".$idt_usu.", "."'".$chave."'".');" alt="Autenticar Informação Site" /></a>';
                                          }
                                          }
                                         */

//                                                    if ($_SESSION[CS]['g_idt_obra_ge']=='')
                                        $sem_desc = 'Situação de evolução da Obra';
                                        if ($idt_obra_escolhida != 999 and $idt_obra_escolhida != 888) {
                                            $path = $_SESSION[CS]['g_path_logo_obra'];
                                            $img = $_SESSION[CS]['g_imagem_logo_obra'];
                                            $desc = $_SESSION[CS]['g_nm_obra'];
                                            $sem_path = $dir_file.'/situacao_empreendimento/';
                                            $sem_codigo_obra = $_SESSION[CS]['g_sem_codigo_obra'];
                                            $sem_imagem_obra = $_SESSION[CS]['g_sem_imagem_obra'];
                                        } else {
                                            $path = $_SESSION[CS]['g_path_logo_obra_ge'];
                                            $img = $_SESSION[CS]['g_imagem_logo_obra_ge'];
                                            $desc = $_SESSION[CS]['g_nm_obra_ge'];
                                            $sem_path = $dir_file.'/situacao_empreendimento/';
                                            $sem_codigo_obra = $_SESSION[CS]['g_sem_codigo_obra_ge'];
                                            $sem_imagem_obra = $_SESSION[CS]['g_sem_imagem_obra_ge'];
                                        }
                                        echo "<div style='margin-left:0px; float:left; background:#FFFFFF; width:32px; height:32px; '>";
                                        if ($img != '') {
                                            //if ($idt_obra_escolhida!=999 and $idt_obra_escolhida!=888)
                                            //{
                                            // ImagemMostrar(150, 35, $path, $img, $desc , false, 'idt="'.$idt.'"');
                                            ImagemMostrar(35, 35, $path, $img, $desc, false, 'idt="'.$idt.'"');
                                            //}
                                        }

                                        if ($sem_imagem_obra != '') {
                                            ImagemMostrar(32, 32, $sem_path, $sem_imagem_obra, $sem_desc, false, 'idt="'.$idt.'"');
                                        }
                                        echo "</div>";



                                        echo "<div style='margin-left:15px; float:right;  sborder:1px solid blue; text-align:right; float:right; background:#FFFFFF; font-weight: bold; font-size:16px; color:#808080; '>";

                                        $setor_funcao = 'Setor Financeiro';
                                        $setor_funcao = $_SESSION[CS]['g_site_setor'][$menu];
                                        if ($setor_funcao != '') {
                                            $constsol = "<span style=''>"."Responsável pela Informação:"."</span><br />";
                                            echo $constsol.$setor_funcao;
                                        }
                                        echo "</div>";



                                        //echo "</a>";
                                        echo '</div>';
                                    }
                                }
                                echo '</div>';
                            }



                            if ($prefixo == 'listar' || $prefixo == 'listar_rel') {
                                $Require_Once = "listar.php";
                            } else if ($prefixo == 'detalhe' or $prefixo == 'det') {
                                $Require_Once = "detalhe.php";
                            } else if ($prefixo == 'cadastro') {
                                $Require_Once = "cadastro.php";
                            } else if ($prefixo == 'relatorio') {
                                $Require_Once = "relatorio/$menu.php";
                            } else if ($prefixo == 'html') {
                                $Require_Once = "plu_html.php";
                            } else {
                                $Require_Once = "$prefixo$menu.php";
                            }

                            if ($menu == 'acao_empreiteiro') {
                                $_GET['pri'] = 'S';
                                if ($_SESSION['guy_marreta'] == '1') {
                                    $_SESSION['guy_marreta'] = 'N';
                                }
                            }

                            //gestao_obras=GGOO"
                            if ($menu == 'despesa_direta' || $menu == 'despesa_indireta' || $menu == 'orcamento_sintetico' || $menu == 'abc_servico' || $menu == 'abc_insumo' || $menu == 'contrato_ger' || $menu == 'contrato_avaliacao' || $menu == 'contrato_lista_precos' || $menu == 'contrato_qualificacao' || $menu == 'contrato_servico_inc' || $menu == 'contrato_fornecedor_inc' || $menu == 'comparativo_abc') {
                                $veiosite = 'S';
                                $Require_Once = 'admin/'.$Require_Once;
                            }

                            //  echo " 2222 ----------------- $menu <br />";
				/*
                            if ($_SESSION[CS]['g_nome_completo'] != '' and $_SESSION[CS]['g_acesso_obra'] != '0') {
                                if ($menu == 'home') {
                                    $menu = 'homeobra';
                                    $Require_Once = "$prefixo$menu.php";
                                }
                            } else {
                                
                            }
				*/

                            // echo " 333333 2222 ----------------- $Require_Once <br />";

                            if ($_SESSION[CS]['g_senha_antiga'] == md5($vetConf['senha_padrao'])) {
                                if ($_SESSION[CS]['alerta_alterar_senha'] == '') {
                                    $_SESSION[CS]['alerta_alterar_senha'] = 'S';
                                    $_SESSION[CS]['alterar_senha'] = 'S';
                                }
                            }

                            if ($_GET['retsenha'] == 'S') {
                                $_SESSION[CS]['alterar_senha'] = 'N';
                            }

                            if ($_SESSION[CS]['alterar_senha'] == 'S') {
                                //$_SESSION[CS]['alterar_senha']='N';
                                $veiosite = 'S';
                                $prefixo = 'inc';
                                $menu = 'alterar_senha';
                                $Require_Once = "$prefixo$menu.php";
                            }


                            if ($vetMenuDados[$menu]['arq_admin'] == 'S') {
                                $Require_Once = "abrir_admin_chama.php";
                            }



                            if (file_exists($Require_Once)) {
                                echo "<div id='tela_include'>";
                                Require_Once($Require_Once);
                                echo "</div>";
                            } else {
                                echo "<script type='text/javascript'>top.location = 'index.php';</script>";
                                exit();
                            }
                        } else {
                            $lg = 1;

                            //echo " ----------------- <br />";

                            $Require_Once = "inchomesite.php";



                            if (file_exists($Require_Once)) {
                                Require_Once($Require_Once);
                            } else {
                                echo "<script type='text/javascript'>top.location = 'index.php';</script>";
                                exit();
                            }
                        }
                        ?>

                        <?php
                        if ($_SESSION[CS]['g_nome_completo'] != '') {
                            echo '</div>';
                        }
                        ?>





                    </div>


                </div>

            </center>


            <?php
            echo "<div id='assina_tela'>";
            echo "    <div id='assina_tela_cab'>";
            echo "         <img onclick='return assina_tela();' title='Fechar Tela de Assinatura' src='imagens/fechar.gif' border='0'>";

//echo '<a  >' . "&nbsp;<img onclick='return abre_ajuda_campo();' title='Atualiza Ajuda do Campo' src='imagens/alterar.gif' border='0'>" . '&nbsp;</a>' ;

            echo "        <span id='assina_tela_cab_texto' > Assinatura de Segurança </span>";
            echo "    </div>";
            echo "    <div id='assina_tela_det'>";
            echo "    </div>";
            echo "</div>";
            ?>


        </div>
        <div id="div_end">
            <center>
                <div class="meio cend">
                    <?php
                    $sql = "select des_html from plu_html where menu = 'endereco'";
                    $rs = execsql($sql);
                    echo $rs->data[0][0];
                    ?>
                </div>
            </center>
        </div>
        <div id="div_rodape">
            <center>
                <div class="meio crodape">
                    <span>© 2015 Sebrae-Bahia</span>
                    <!-- <a href="<?php echo $vetConf['url_webmail']; ?>" target="_blank">Webmail</a> -->
                    <a href="<?php echo $vetConf['url_helpdesk']; ?>" target="_blank">HelpDesk Sebrae</a>
                    <a href="<?php echo $vetConf['url_sebrae_na']; ?>" target="_blank">Sebrae-Naciolal</a>
                    <a href="<?php echo $vetConf['url_sebrae_ba']; ?>" target="_blank">Sebrae-Bahia</a>
                </div>
            </center>
        </div>
    </body>









</html>
