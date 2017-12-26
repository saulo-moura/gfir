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



if ($_REQUEST['prefixo'] == '')
    $prefixo = 'inc';
else
    $prefixo = $_REQUEST['prefixo'];
    
if ($prefixo=='mod')
{  // chama modulo
   //Require_Once('conteudo_identidade_corporativa.php');

   /*
   $titulo = 'ESCOLHE SERVIÇOS PARA ANEXAR À OBRA ';
    echo ' <script type="text/javascript">';
    echo "   alert('teste');  ";
    

    echo "    var  left   = 0;  ";
    echo "    var  top    = 0;   ";
   // echo "    var  height = $(window).height(); ";
   // echo "    var  width  = $(window).width(); ";
    echo "    var  height = 800; ";
    echo "    var  width  = 800; ";
    echo "    var  link_so='conteudo_identidade_corporativa.php";
    echo '    excluir_so  =  window.open(link_so,"AnexarSo","left="+left+",top="+top+",width="+width+",height="+height+",resizable=yes,menubar=no,scrollbars=yes,toolbar=no"); ';
    echo "    excluir_so.focus(); ";

    //echo ' </script> ';
    */
//    exit();
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


        if ($_SESSION[CS]['g_idt_obra']!="")
        {
            $img  = $_SESSION[CS]['g_imagem_logo_obra'];
            $desc = $_SESSION[CS]['g_nm_obra'];
            $idt  = $_SESSION[CS]['g_idt_obra'];
            $path=$_SESSION[CS]['g_path_logo_obra'];
            $url_organizacao=$_SESSION[CS]['g_url_organizacao'];
        }
        else
        {
            $sql  = "select em.idt, em.imagem , em.url_organizacao, descricao from sgr_organizacao em  ";
            $sql .= " where raiz_organizacao=".aspa('S');
            $sql .= "   and idt= 20";
            $sql .= " order by descricao";
            
//            $result = execsql($sql);
//            $row = $result->data[0];
            $_SESSION[CS]['g_idt_obra']         = $row['idt'];
            $_SESSION[CS]['g_imagem_logo_obra'] = $row['imagem'];
            $_SESSION[CS]['g_url_organizacao']  = $row['url_organizacao'];
            $_SESSION[CS]['g_nm_obra']          = $row['descricao'];
            $path                               = $dir_file.'/sgr_organizacao/';
            $_SESSION[CS]['g_path_logo_obra']   = $path;
            $_SESSION[CS]['g_imagem_logo_obra'] = $row['imagem'];
        }
        //echo " bbbbbbbbbbbbbbbb ".$path.' - '.$img.' ---- '.$_SESSION[CS]['g_idt_obra']."<br />";
        //echo " bbbbbbbbbbbbbbbb ".$url_organizacao;
        if ($img!="")
        {
            /*
            echo "<div id='logo_organizacao'>";
            $pathw=$path.$img;
            if ($url_organizacao!="")
            {
                echo "<a href='{$url_organizacao}' title='Clique aqui para ter acesso ao site da Organização' style='cursor:pointer;'><img src='{$pathw}'  alt='' /></a> ";
            }
            else
            {
                echo "<img src='{$pathw}'  alt='' /> ";
            }
            echo "</div>";
            */
        }





?>

                <div id="topo_barra" >
                    <a href="conteudo.php" title="Vai para Home do Gerenciador de Conteúdo (GC)">Home</a>
                    &nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;
                    <a href="<?php echo $vetConf['url_pentagon'] ?>" target="_blank" title="Acessa Site Pentagon"><span class="oas">Site Pentagon</span></a>
                    &nbsp;&nbsp;&nbsp;
                </div>

            <div id="geral">

                
                
                <div id="topo" class="topo" style="padding-top:4px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        
                        
                        
                        
                     <td width="300px;" xcolspan="2" xalign="left">

                                    <?php





            if ($_SESSION[CS]['g_idt_obra']==0)
            {
                // é a própria empresa
                $sql  = "select em.idt_raiz from sgr_organizacao em  ";
                $sql .= " where ";
                $sql .= "   cliente_lupe = ".aspa("S");
                //$result = execsql($sql);
                $row = $result->data[0];
                $_SESSION[CS]['g_idt_obra']=$row['idt_raiz'];

            }
            $sql  = "select em.idt_raiz from sgr_organizacao em  ";
            $sql .= " where ";
            $sql .= "   idt = ". null($_SESSION[CS]['g_idt_obra']);
           // $result = execsql($sql);
            $row = $result->data[0];
            $_SESSION[CS]['r_idt_raiz'] = $row['idt_raiz'];
            //
            $sql  = "select em.idt, em.imagem , em.url_organizacao, descricao from sgr_organizacao em  ";
            $sql .= " where raiz_organizacao=".aspa('S');
            $sql .= "   and idt = ". null($_SESSION[CS]['r_idt_raiz']);
         //   $result = execsql($sql);
            $row = $result->data[0];

            
            
            
            $_SESSION[CS]['r_idt_obra']         = $row['idt'];
            $_SESSION[CS]['r_imagem_logo_obra'] = $row['imagem'];
            $_SESSION[CS]['r_url_organizacao']  = $row['url_organizacao'];
            $_SESSION[CS]['r_nm_obra']          = $row['descricao'];
            $pathr                               = $dir_file.'/sgr_organizacao/';
            $_SESSION[CS]['r_path_logo_obra']   = $path;
            $_SESSION[CS]['r_imagem_logo_obra'] = $row['imagem'];
            
        $imgr  = $_SESSION[CS]['r_imagem_logo_obra'];
        $descr = $_SESSION[CS]['r_nm_obra'];
        $idtr  = $_SESSION[CS]['r_idt_obra'];
        $pathr = $_SESSION[CS]['r_path_logo_obra'];

        $url_organizacaor=$_SESSION[CS]['r_url_organizacao'];
        //echo " bbbbbbbbbbbbbbbb ".$path.' - '.$img.' ---- '.$_SESSION[CS]['g_idt_obra'];
        //echo " bbbbbbbbbbbbbbbb ".$url_organizacao;
        if ($imgr!="")
        {
            //echo "<div id='logo_organizacao'>";
            $pathw=$pathr.$imgr;
            $nomeorgr = "<span class='titulocabs'>$descr</span>";
            if ($url_organizacaor!="")
            {
                echo "<a href='{$url_organizacaor}' title='Clique aqui para ter acesso ao site da Organização' style='cursor:pointer;'><img width='32' height='32' src='{$pathw}'  alt='' />$nomeorgr</a> ";
            }
            else
            {
                echo "<img style='padding-left:10px;' width='32' height='32' src='{$pathw}'  alt='' />$nomeorgr ";
            }
            // echo "</div>";
        }
        else
        {
            $nomeorgr = "<span class='titulocabs'>$descr</span>";
            echo "<a>$nomeorgr</a> ";
        }


                                    ?>

                               </td>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                            <td>
                                <img src="imagens/trans.gif" height="40" alt="" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">
                            <div id="barra_topo" style="display:block; padding:0;  margin:0; float:left; padding:0; xborder:1px solid red; width:100%;">
                                    <?php
                                       // echo "<div id='logo_site_txt' >Gestão para Resultados</div> ";



echo "<div style='padding-left:5px; float:left;'>";
echo "<a href='sair.php' title='Sair do GC - Gerenciador de Conteúdo'><img alt='' src='imagens/logoff.png' width='32' height='32' /></a>";
echo "</div>";



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
    $vetnada[0] = '-- Selecione uma Organizacao --';
    //  $g_vet_obras_tt= array_merge($vetnada,$_SESSION[CS]['g_vet_obras']);
    //$_SESSION[CS]['g_vet_obras']=$g_vet_obras_tt;
    //   p($g_vet_obras_tt);
    $g_vet_obras_tt = $_SESSION[CS]['g_vet_obras'];
} else {
    //    echo "<span style='float:right;'>Obra:&nbsp;</span>";
    $g_vet_obras_tt = $_SESSION[CS]['g_vet_obras'];
}


$tam = count($_SESSION[CS]['g_vet_obras']);
$p = $_SESSION[CS]['g_idt_obra'];
if ($tam>1)
{
    echo "<div id='escolhe_obra' style='xborder:1px solid #ff0000;  xoverflow:hidden; width:220px; padding:3px; padding-left:0px;   margin:0px; float:left; xdisplay:{$esconde_o};'>";
    echo "<span style='float:left;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dep:&nbsp;</span>";
    criar_combo_vet($g_vet_obras_tt, 'organizacao', $p, '', "onchange = 'funcObra_gc(this)'", ' xfloat:right; height:25px; padding:0px; padding-left:0px; margin:0px; font-size:11px; width: 160px; border:1px solid #808080; ');
    echo '</div>';
}
else
{
    echo "<div id='escolhe_obra' style='xborder:1px solid #ff0000; xoverflow:hidden; xwidth:100px; padding:0px; padding-right:15px;  margin:0px; float:right; xdisplay:{$esconde_o};'>";
    echo $_SESSION[CS]['g_nm_obra'];
    echo '</div>';
}

                                
                                    ?>

                                
                                
                                    <div id="usuario" style="height:30px; width:300px;  xborder:1px solid #00FF40; ">
<?php
echo "<script type='text/javascript'>";
echo "var ajax_alt={$_SESSION[CS]['ajax_alt']};";
echo "</script>";
//cho '<div id="obra">';
// echo "<div id='usuario_t' style='width:100%'>";

echo "<div id='usuario_t' style='height:30px; font-size:12px; xwidth:250px; xborder:1px solid black; float:left;'>";


//echo "<span>Usuário:&nbsp;</span>".$_SESSION[CS]['g_nome_completo']."[".$_SESSION[CS]['g_nome_setor']."]";
/*
echo "<div style='float:left;'>";
echo "<a href='sair.php' title='Sair do GC - Gerenciador de Conteúdo'><img alt='' src='imagens/sair.png' width='32' height='32' /></a>";
echo "</div>";
*/
echo "<div style='float:left; padding-left:15px; padding-top:5px; xwidth:200px;';>";
echo "<span style='font-size:12px;  color:#FFFFFF;'>Usuário:&nbsp;</span>".$_SESSION[CS]['g_nome_completo'];
echo "</div>";
// Usuário: <?php echo $_SESSION[CS]['g_nome_completo'];
// echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//  echo "<span>Obra:&nbsp;</span>";
$p = $_SESSION[CS]['g_idt_obra'];
//$p=20;


echo "</div>";

//echo "vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv";
//p($_SESSION[CS]['g_vet_obras']);

//echo "<div id='escolhe_obra' style='color:#FFFF00; cursor:pointer; float:left;'>";
/*
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
*/
//echo "</div>";


//$p=0;
if ($_SESSION[CS]['g_pri_vez_log'] == 1) {
    $esconde_o = 'block';
} else {
    $esconde_o = 'block';
}
//p($_SESSION[CS]['g_vet_obras']);

/*
$tam = count($_SESSION[CS]['g_vet_obras']);
if ($tam>1)
{
    echo "<div id='escolhe_obra' style='border:1px solid #ff0000;  xoverflow:hidden; width:200px; padding:3px; padding-right:0px;   margin:0px; float:right; xdisplay:{$esconde_o};'>";
    //echo "<span style='float:left;'>Org:&nbsp;</span>";
    criar_combo_vet($g_vet_obras_tt, 'organizacao', $p, '', "onchange = 'funcObra_gc(this)'", ' xfloat:right; height:25px; padding:0px; padding-left:5px; margin:0px; font-size:11px; width: 200px; border:1px solid #808080; ');
    echo '</div>';
}
else
{
    echo "<div id='escolhe_obra' style='xborder:1px solid #ff0000; xoverflow:hidden; xwidth:100px; padding:0px; padding-right:15px;  margin:0px; float:right; xdisplay:{$esconde_o};'>";
    echo $_SESSION[CS]['g_nm_obra'];
    echo '</div>';
}
*/
//  echo '</div>';
//echo '</div>';
//echo ' vvvvvvvvvvvvv '.$p;


// |&nbsp;&nbsp;&nbsp;&nbsp; <a href="sair.php" title="Sair do GC - Gerenciador de Conteúdo">Sair</a>

?>

                                    </div>

                                    <div id="resto" style="height:30px; font-size:12px; float:right; width:280px; xborder:1px solid red;">
                                        <?php echo date("d/m/Y ").(date("H") - date("I")).date(":i"); ?>
                                        -&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="showPopWin('conteudo_popup.php?menu=email_adm&prefixo=cadastro', 'Comunicação com o Administrador do Sistema', 704, 351)"><img src="imagens/email.gif" width="32" height="32"  title="Comunicação com o Administrador do Sistema" border="0" /></a>
                                        |&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="return abre_ajuda('sistema', '')"  title="Ajuda de Utilização do Site" >Ajuda</a>
                                        |&nbsp;&nbsp;&nbsp;&nbsp; <a href="#" onclick="showPopWin('conteudo_popup.php?menu=noticia_sistema&prefixo=inc', 'Notícias do Sistema Pentagon', 704, 470)"><img src="imagens/noticia.png" width="32" height="32" title="Notícia do Sistema CXX" border="0" /></a>

                                    </div>
                                    <div id="dtBanco" style="display: none;"><?php echo date("d/m/Y"); ?></div>
                                    <input type="hidden" id="dtBancoObj" value="<?php echo date("d/m/Y"); ?>" />
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
} else if ($_SESSION[CS]['g_mostra_menu'] == 'S') {
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
                                ?>
                                <div id="barra_a">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <?php
                                              if ($subp==1)
                                              {
                                                  echo "<td nowrap='nowrap' style=' xbackground:#808080; color:#FFFFFF; padding:5px; font-size:14px; ' title='Clique aqui para Retornar'><a href='{$retp}' xonclick= ' history.go(-1); ' style='font-weight: bold; color:#FFFFFF;'><img alt='' src='imagens/home.png' width='32' height='32' /></a> </td>";
                                              }
                                            ?>
                                            <td><img alt="" src="imagens/trans.gif" width="20" height="1" /></td>
                                            <td nowrap="nowrap" style="font-size:16px;"><?php echo $vetMenu[$menu].($vetDireito[$acao] == '' ? '' : ' :: '.$vetDireito[$acao]) ?></td>
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
                                  //  ImagemMostrar(80, 35, $path, $img, $nm_empreendimento, false, 'idt="'.$idt.'"');
                                } else {
                                    $tam = count($_SESSION[CS]['g_vet_obras']);
                                    if ($tam == 1) {
                                        $path = $_SESSION[CS]['g_path_logo_obra'];
                                        $img = $_SESSION[CS]['g_imagem_logo_obra'];
                                        //$link = 'conteudo.php?prefixo=inc&menu=home&menusite=2';
                                        //echo "<a href='{$link}' >";
                                     //   ImagemMostrar(80, 35, $path, $img, $nm_empreendimento, false, 'idt="'.$idt.'"');
                                    }
                                }
                                echo "</div>";
                                echo '</td>';
                                ?>
                                            <td nowrap="nowrap" style="font-size:18px; font-weight: bold;"><a href="#" onclick="return abre_ajuda()" title="Ajuda da Função"><img alt="" src="imagens/interrogacao.png" width="32" height="32" /></a></td>

                                        </tr>
                                    </table>
                                </div>
                                            <?php
                                            
                                }
                                            
                                            
                                            
                                            
                                        }

                                        if ($_SESSION[CS]['g_id_usuario'] == '')
                                            $Require_Once = "inclogin.php";
                                        else if ($prefixo == 'listar' || $prefixo == 'listar_rel')
                                            $Require_Once = "listar.php";
                                        else if ($prefixo == 'cadastro')
                                            $Require_Once = "cadastro.php";
                                        else if ($prefixo == 'relatorio')
                                            $Require_Once = "relatorio/$menu.php";
                                        else
                                            $Require_Once = "$prefixo$menu.php";

                                        if ($prefixo=='mod')
                                        {  // chama modulo
                                           //$menu = "idc_menu";
                                           $Require_Once = "$prefixo$menu.php";
                                        }
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
                
                

        
        
        
            </div>



        <div id="div_rodape">
            <center>
                <div class="meio crodape">
                    <span>© 2015 CONTDIST - Controle de Distribuição</span>
                    <a href="<?php echo $vetConf['url_pentagon']; ?>" target="_blank"  title="Acessa Site Pentagon">Site Pentagon</a>
                </div>
            </center>
        </div>





        </center>
    </body>
</html>
