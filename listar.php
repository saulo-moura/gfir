<link href="listar.css" rel="stylesheet" type="text/css" />
<?php
$vetCampo = Array();
$vetFiltro = Array();
$Msg = '';
$Campo = '';
$idCampo = 'idt';
$tabela = $menu;
$reg_pagina = 5;
$bt_mais = false;
$ver_tabela = false;
$sen_linha  = false;
$bt_prefixo = 'detalhe';
$url_volta = 'conteudo'.$cont_arq.'.php';
$totaltabela=false;
$valor_total=0;
$texto_total='';
$campo_total='';
$path = 'listar_conf/'.$menu.'.php';
 //echo 'gf gfg g fg fgf g g
 //exit();
 
$bot_pesq = true;
 
//p($url_volta);
//exit();

if (file_exists($path)) {
    Require_Once($path);
} else {
    echo "<br><br><div align='center' class='Msg'>Fun��o em desenvolvimento...</div>";
    onLoadPag();
    FimTela();
    exit();
}

if ($totaltabela==true)
{
    $path_total = 'listar_conf/'.$menu.'_total.php';
}


$Focus = '';

$tot_vet = count($vetCampo);
if ($bt_mais)
    $tot_vet++;

$idx = -1;
ForEach ($vetFiltro as $Filtro) {
    $idx++;
    $strPara .= $Filtro['id'].$idx.',';
}
?>

<?php
    $rs = execsql($sql);
    if ($rs->rows == 0)
    {
        if  ($msg_sem_registro=='')
        {
            $msg_sem_registro=' Sem informa��es cadastradas.';
        }
        echo "<div id='msg_sem_registro' >";
        echo  $msg_sem_registro;
        echo "</div>";

        onLoadPag();
        FimTela();
        exit();
    }
    
    
?>

<form id="frm" name="frm" target="_self" action="conteudo.php?<?php echo substr(getParametro($strPara), 1) ?>" method="post">
    <?php codigo_filtro(false,$bot_pesq); ?>
</form>
<?php
    echo $vetConf['lst_'.$menu];

    onLoadPag($Focus);

  //  $rs = execsql($sql);

//Pagina��o
    $p = $_REQUEST['p'];
    $pag_tot = $rs->rows;

    if ($pag_tot <= $reg_pagina)
        $pag_tot = 1;
    elseif (($pag_tot % $reg_pagina) == 0)
        $pag_tot = ($pag_tot / $reg_pagina);
    else
        $pag_tot = (int)($pag_tot / $reg_pagina) + 1;

    $pag_tot--;

    if (!is_numeric($p) || $p <= 0)
        $p = 0;
    elseif ($p > $pag_tot)
        $p = $pag_tot;
    else
        $p--;

//Seleciona a pagina do idt passado
    $sai = false;

    if ($_GET[$idCampo] != '' && $_GET['p'] == '') {
        for ($tp = 0; $tp <= $pag_tot; $tp++) {
            $fim = (($tp + 1) * $reg_pagina);
            if ($fim > $rs->rows)
                $fim = $rs->rows;

            for ($i = ($tp * $reg_pagina); $i < $fim; $i++) {
                $row = $rs->data[$i];
                if ($_GET[$idCampo] == $row[$idCampo]) {
                    $p = $tp;
                    $sai = true;
                    break;
                }
            }

            if ($sai)
                break;
        }
    }

    $fim = (($p + 1) * $reg_pagina);
    if ($fim > $rs->rows)
        $fim = $rs->rows;

    if ($ver_tabela) {
        echo '<div id="espaco"></div>';
        echo '<table class="listar_tabela" border="0" cellspacing="0" cellpadding="0" hspace="0" vspace="0">'.nl();
        echo '<tr class="titulo">'.nl();
        ForEach ($vetCampo as $campo => $dados) {
            if  ($dados['classcab']=='')
            {
                echo '<td>'.$dados['nome'].'</td>'.nl();
            }
            else
            {
                echo "<td class='".$dados['classcab']."'>".$dados['nome'].'</td>'.nl();

            }
        }

        if ($bt_mais)
            echo '<td>&nbsp;</td>'.nl();
        echo '</tr>'.nl();
    }

    $l = -1;
    for ($i = ($p * $reg_pagina); $i < $fim; $i++) {
        $row = $rs->data[$i];

        if ($ver_tabela)
            if (!$sen_linha)
            {
                echo '<tr class="'.((++$l % 2) == 0 ? 'impar' : 'par').'">'.nl();
            }
            else
            {

                echo '<tr style="cursor:pointer;" onclick="chama_nivel2('."'".$bt_prefixo."','".$menu."',".$row[$idCampo].');" class="'.((++$l % 2) == 0 ? 'impar' : 'par').'">'.nl();
            }
        else
            echo '<div><div class="lst_row"><div class="lst_row_erro">'.nl();

        ForEach ($vetCampo as $campo => $dados) {
            if ($dados['style'] == '')
                $style = '';
            else
                $style = 'class="listar_'.$dados['style'].'"';

            if ($ver_tabela)
                echo '<td '.$style.'>'.nl();
            else {
                echo '<div '.$style.'>'.nl();
                if (!is_bool($bt_mais)) {
                    if ($bt_mais == 'prettyPhoto') {
                        if ($row['tipo_video'] == 'S') {
                            $vet = explode('.', $row['nm_arquivo']);
                            $extensao = mb_strtolower($vet[count($vet) - 1]);
                            $path = $dir_file.'/'.$tabela.'/';

                            if ($extensao == 'swf') {
                                $href = $path.$row['nm_arquivo'].'?width=600&amp;height=400';
                            } else {
                                $href = 'monta_video.php?tipo=video&arquivo='.$path.$row['nm_arquivo'].'&iframe=true&amp;width=600&amp;height=400';
                            }
                        } else {
                            $href = 'monta_video.php?tipo=video&arquivo='.$row['ds_youtube'].'&iframe=true&amp;width=600&amp;height=400';
                        }

                        echo '<a rel="prettyPhoto" idt="'.$row[$idCampo].'" title="'.$row['ds_video'].'" href="'.$href.'">'.nl();
                    } else {
                        echo '<a href="conteudo.php?prefixo='.$bt_prefixo.'&menu='.$menu.'&id='.$row[$idCampo].$bt_mais.'">'.nl();
                    }
                }
            }

            echo $dados['antes'];
            if ($dados['mostra_nome'])
                echo $dados['nome'].':&nbsp;';
            echo '<span title="'.$dados['nome'].'">';

            switch ($dados['tipo']) {
                case 'descdominio':
                    if ($dados['par'][$row[$campo]] == '') {
                        echo $row[$campo];
                    } else {
                        echo $dados['par'][$row[$campo]];
                    }
                    break;

                case 'data':
                    echo trata_data($row[$campo]);
                    break;

                case 'decimal':
                
                //echo ' mmmmmm '.$dados['ndecimal'];
                
                    if ($dados['ndecimal']==='')
                    {
                  //      echo ' nao,,,,,,,eeeeeeeeemmmmmm '.$dados['ndecimal'];
                        echo format_decimal($row[$campo]);
                    }
                    else
                    {
                    //    echo ' eeeeeeeeemmmmmm '.$dados['ndecimal'];
                        echo format_decimal($row[$campo],$dados['ndecimal']);
                    }
                    break;

                case 'email':
                    echo '<a href="mailto:'.$row[$campo].'">'.$row[$campo].'</a>';
                    break;

                case 'url':
                    echo '<a href="http://'.$row[$campo].'" target="_blank">'.$row[$campo].'</a>';
                    break;

                case 'url_nome':
                    echo '<a href="'.$row[$campo].'" target="_blank">'.$dados['nome'].'</a>';
                    break;

                case 'link':
                    if ($row[$campo] != '')
                        echo '<a href="'.$dados['link'].$row[$campo].'">'.$dados['nome'].'</a>';
                    break;

                case 'busca':
                    $extra = $row['extraA'];
                    switch ($row['menu']) {
                        case 'aniversario':
                            $dt = explode('/', trata_data($row['extraA']));
                            $extra .= '&mes0='.(int)$dt[1];
                            $extra .= '&dia1='.(int)$dt[0];
                            break;
                    }

                    $texto_menu = '&nbsp;&nbsp;('.$vetMenu[$row['menu']]['nome'].')';

                    if ($row['menu'] == 'servico' || $row['prefixo'] == 'html')
                        $texto_menu = '';

                    echo '<a href="conteudo.php?prefixo='.$row['prefixo'].'&menu='.$row['menu'].'&'.$row['idcampo'].'='.$row['id'].'&id='.$row['id'].$extra.'">'.$row[$campo].$texto_menu.'</a>';
                    break;

                case 'arquivo':
                    $path = $dir_file.'/'.$dados['tabela'].'/';
                    
                    //ImagemProd($nlargura, $naltura, $Dir, $Foto, $Prefixo='', $Link = False) {
                    //$dados['style']
                    $nlargura=$dados['vetDominio'];
                    $naltura = 0;
                   //  p($dados);
                   // echo 'nnnnn '.$path;
                    ImagemProd($nlargura, $naltura, $path, $row[$campo], $row[$idCampo].'_'.$campo.'_');
                    break;

                case 'arquivo_link':
                    $path = $dir_file.'/'.$tabela.'/';
                    ImagemProd(550, $path, $row[$campo], $row[$idCampo].'_'.$campo.'_', True);
                    break;

                case 'arquivo_nome':
                    $path = $dir_file.'/'.$tabela.'/';
                    $nome = substr($row[$campo], strlen($row[$idCampo].'_'.$campo.'_'));

                    switch (mb_strtolower(substr($row[$campo], -3))) {
                        case "ai":
                        case "avi":
                        case "bmp":
                        case "cs":
                        case "dll":
                        case "doc":
                        case "exe":
                        case "fla":
                        case "gif":
                        case "htm":
                        case "html":
                        case "jpg":
                        case "js":
                        case "mdb":
                        case "mp3":
                        case "pdf":
                        case "ppt":
                        case "pps":
                        case "rdp":
                        case "swf":
                        case "swt":
                        case "txt":
                        case "vsd":
                        case "xls":
                        case "xml":
                        case "zip":
                            $Extensao = mb_strtolower(substr($row[$campo], -3));
                            break;
                        default:
                            $Extensao = "default.icon";
                            break;
                    }

                    echo '
                    <a target="_blank" href="'.$path.$row[$campo].'">
                    <img border="0" style="vertical-align: middle; margin-bottom: 3px; margin-right:4px;" src="imagens/arquivo/'.$Extensao.'.gif">'.$nome.'
                    </a>
                ';
                    break;

                case 'tabela1x2':
                    $par = $dados['par'];

                    if ($par['style1'] == '')
                        $style = '';
                    else
                        $style = 'class="listar_'.$par['style1'].'"';

                    echo '<table cellspacing="0" cellpadding="0" border="0"><tr><td '.$style.'>';

                    $path = $dir_file.'/'.$tabela.'/';
                    ImagemProd(0, $path, $row[$par['td1']], $row[$idCampo].'_'.$par['td1'].'_');

                    if ($par['style2'] == '')
                        $style = '';
                    else
                        $style = 'class="listar_'.$par['style2'].'"';

                    echo '</td><td '.$style.'>';

                    echo conHTML($row[$par['td2']]);

                    echo '</td></tr></table>';
                    break;

                case 'imgtxt':
                    $par = $dados['par'];

                    echo '<div class="listar_imgtxt">';

                    $path = $dir_file.'/'.$tabela.'/';
                    ImagemProd(0, $path, $row[$par['img']], $row[$idCampo].'_'.$par['img'].'_');
                    echo conHTML($row[$par['txt']]);

                    echo '</div>';
                    break;

                case 'descricao':
                    echo conHTML($row[$campo]);
                    break;

                default:
                    echo $row[$campo];
                    break;
            }

            echo '</span>';
            echo $dados['depois'];

            if ($ver_tabela)
                echo '</td>'.nl();
            else {
                if (!is_bool($bt_mais))
                    echo '</a>';
                echo '</div>'.nl();
            }
        }

        if ($bt_mais === True) {
            if ($ver_tabela) {
                echo '<td>'.nl();
                echo '<a href="conteudo.php?prefixo='.$bt_prefixo.'&menu='.$menu.'&id='.$row[$idCampo].'">
                  <img src="imagens/mais.gif" title="Saiba mais" alt="Saiba mais" border="0"></a>'.nl();
                echo '</td>'.nl();
            } else {
                echo '<div class="mais"><a href="conteudo.php?prefixo='.$bt_prefixo.'&menu='.$menu.'&id='.$row[$idCampo].'">
                  <img src="imagens/mais.gif" title="Saiba mais" alt="Saiba mais" border="0"></a></div>'.nl();
            }
        }

        if ($ver_tabela)
            echo '</tr>'.nl();
        else
            echo '</div></div></div>'.nl();
    }
    
    
    if ($totaltabela==true)
    {

        if (file_exists($path_total))
        {
            Require_Once($path_total);
        }
    }
    
    

//Linha de Pagina��o
    $p++;
    $pag_tot++;

    $ini = $p - $vetConf['num_pagina'];
    $fim = $p + $vetConf['num_pagina'];

    if ($ini < 1) {
        $fim = $fim - $ini + 1;
        $ini = 1;
    }

    if ($fim >= $pag_tot) {
        $ini = $ini - ($fim - $pag_tot);
        if ($ini < 1)
            $ini = 1;

        $fim = $pag_tot;
    }

    if ($ini != $fim) {
        if ($ver_tabela)
            echo '<tr class="lst_paginacao"><td colspan="'.$tot_vet.'">'.nl();
        else
            echo "<div class='lst_paginacao'>";

        echo "<a href='conteudo.php?p=1".getParametro('p')."'>&lt;&lt;</a>&nbsp;
          <a href='conteudo.php?p=".($p - 1).getParametro('p')."'>&lt;</a>&nbsp;";

        for ($i = $ini; $i <= $fim; $i++) {
            if ($i == $p)
                echo "<span>$i&nbsp;</span>";
            else
                echo "<a href='conteudo.php?p=$i".getParametro('p')."'>$i</a>&nbsp;";
        }

        echo "<a href='conteudo.php?p=".($p + 1).getParametro('p')."'>&gt;</a>&nbsp;
          <a href='conteudo.php?p=$pag_tot".getParametro('p')."'>&gt;&gt;</a>";

        if ($pag_tot > (2 * $vetConf['num_pagina'])) {
            echo '&nbsp;&nbsp;&nbsp;';

            $tam = strlen($pag_tot);
            for ($i = 1; $i <= $pag_tot; $i++) {
                $vetPag[$i] = str_repeat("0", $tam - strlen($i)).$i;
            }

            criar_combo_vet($vetPag, 'goPag', $p, '', "onchange = 'funcPag(this)'", 'font-size : 11px; line-height : 11px;');

            echo "
            <script type='text/javascript'>
                function funcPag(obj) {
                    self.location = 'conteudo.php?p=' + obj.value + '".getParametro('p')."';
                }
            </script>
        ";
        }

        if ($ver_tabela)
            echo '</td></tr>'.nl();
        else
            echo "</div>\n";
    }

    if ($ver_tabela)
        echo '</table>'.nl();
?>

<?php if ($_GET['print'] != 's') {   ?>

  <div id="voltar_full">
  <div class="voltar">
        <img src="imagens/menos_full_pco.jpg" title="Voltar"  alt="Voltar" border="0" onclick="self.location = '<?php echo $url_volta; ?>';" style="cursor: pointer;">
  </div>
  </div>

<?php }


else
{
    echo "</div>";
}



   ?>
