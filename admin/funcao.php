<?php
if (file_exists(lib_funcao)) {
    Require_Once(lib_funcao);
}

if (file_exists(lib_funcao_basicas)) {
    Require_Once(lib_funcao_basicas);
}

$sql = '';
$sql .= ' select tabela';
$sql .= ' from plu_log_sistema_tab';
$sql .= ' order by idt desc limit 1';
$rs = execsql($sql);
$row = $rs->data[0];

define('log_sistema', $row['tabela']);
define('log_sistema_detalhe', $row['tabela'] . '_detalhe');

if (file_exists('funcao_integracao.php')) {
    Require_Once('funcao_integracao.php');
}

function criar_tabela($rs, $vetCampo, $idCampo, $novo = true, $edit = true, $novoprefixo = 'cadastro', $novomenu = '', $vetFiltro = '', $sqlOrderby = '', $menu_acesso = '') {
    global $menu, $prefixo, $vetConf, $ordFiltro, $idCampoPar, $goCad, $cont_arq, $num_col_tab, $dir_file, $corimp, $corpar, $corcur, $corover, $cormarca, $marcador,
    $barra_inc, $barra_alt, $barra_con, $barra_exc, $barra_fec,
    $barra_inc_h, $barra_alt_h, $barra_con_h, $barra_exc_h, $barra_fec_h,
    $barra_inc_ap, $barra_alt_ap, $barra_con_ap, $barra_exc_ap, $barra_fec_ap,
    $barra_inc_img, $barra_alt_img, $barra_con_img, $barra_exc_img, $barra_fec_img,
    $ctlinha, $uppertxtcab, $cliquenalinha, $clique_hint_linha, $contlinfim, $comcontrole, $Tela,
    $paginacao_top, $paginacao_bottom, $extra_pagina, $reg_pagina_esp,
    $vetBtOrdem, $inc_chamada_barra, $lista_td_acao_click, $lista_td_cab_acao_click, $vetBtBarra,
    $bt_print, $bt_print_descricao, $bt_print_img, $bt_print_title, $bt_print_class, $bt_print_tit_rel,
    $trHtml, $func_trata_row,
    $campoDescListarCmb, $vetListarCmbRegValido,
    $outramsgvazio, $barra_icone;

    $vetBtOrdemPadrao = Array('exc', 'con', 'alt', 'go');
    $vetTmp = array_diff($vetBtOrdemPadrao, $vetBtOrdem);
    $vetBtOrdem = array_merge($vetBtOrdem, $vetTmp);

    if ($novomenu == '') {
        $menulocal = $menu;
    } else {
        $menulocal = $novomenu;
    }

    if ($menu_acesso == '') {
        $menu_acesso = $menulocal;
    }

    $extra_url = '';
    $sqlOrderby_upcad = '';

    if ($sqlOrderby != '') {
        $extra_url .= '&sqlOrderby=' . $sqlOrderby;
        $sqlOrderby_upcad .= '&sqlOrderby_upcad=' . $sqlOrderby;
    } else if ($_REQUEST['sqlOrderby'] != '') {
        $extra_url .= '&sqlOrderby=' . $_REQUEST['sqlOrderby'];
        $sqlOrderby_upcad .= '&sqlOrderby_upcad=' . $_REQUEST['sqlOrderby'];
    }

    $extra_goCad = Array();

    if (is_array($vetFiltro)) {
        $idx = -1;
        ForEach ($vetFiltro as $Filtro) {
            if ($ordFiltro) {
                $idx++;
                $vl = $Filtro['id'] . $idx;
            } else {
                $vl = $Filtro['id'];
            }

            $extra_url .= '&' . $vl . '=' . $Filtro['valor'];
            $extra_goCad[$vl] = $Filtro['valor'];
        }
    }

    if ($_REQUEST['p'] != '') {
        $extra_url .= '&p=' . $_REQUEST['p'];
    }

    if ($prefixo == 'listar_cmb') {
        $extra_url .= '&prefixo_volta=listar_cmb';
    }

    if ($prefixo == 'listar_cmbmulti') {
        $extra_url .= '&prefixo_volta=listar_cmbmulti';
    }

    $extra_url .= getParametro('prefixo,menu,origem_tela,cod_volta,sqlOrderby,acao,pri,id,idt_pendencia', false);

    if (!is_array($goCad)) {
        $goCad = Array();
    }

    if (count($goCad) > 0 || $edit) {
        $tab_edit = true;
    } else {
        $tab_edit = false;
    }

    $pagina = 'conteudo' . $cont_arq . '.php';

    if ($cont_arq != '_pdf') {
        echo "
        <script type='text/javascript'>
            var goCad = new Array();
            var marcador_full = $marcador;

            function btClick(acao, id) {
                    var prefixo_func = '{$prefixo}';
                    
                    if (prefixo_func == 'listar_cmb' || prefixo_func == 'listar_cmbmulti' || prefixo_func == 'listar_cmbmulti_acao') {
                        var url = 'conteudo_cadastro.php?acao=' + acao + '$extra_url&prefixo=$novoprefixo&menu=$menulocal&id=' + id;
                        showPopWin(url, '{$Tela}', $('div.showPopWin_width').width() - 10, $(window).height() - 100);
                    } else {
                var url = '$pagina?acao=' + acao + '$extra_url&prefixo=$novoprefixo&menu=$menulocal&id=';
                self.location = url + id;
                    }
                    
                return false;
            }
        </script>\n
    ";
    }

    if ($cliquenalinha == 1) {
        echo '
            <style type="text/css">
                Tr.Registro1 {
                    background-color: ' . $corpar . ';
                    cursor:pointer;
                }

                Tr.Registro {
                  background-color: ' . $corimp . ';
                  cursor:pointer;
                }
            </style>
        ';
    } else {
        echo '
            <style type="text/css">
                Tr.Registro1 {
                    background-color: ' . $corpar . ';
                    cursor:default;
                }

                Tr.Registro {
                  background-color: ' . $corimp . ';
                  cursor:default;
                }
            </style>
        ';
    }

    $table_border = '0';

    if ($cont_arq != '_pdf') {
        echo '<iframe src="goCad.php" name="MenuGeral" id="MenuGeral" frameborder="0" scrolling="no" onmouseout="MenuAbre(-1, event)"></iframe>';
        echo "<table id='table_barra_full' width='100%' border='" . $table_border . "' cellspacing='0' cellpadding='0' vspace='0' hspace='0' class='Generica'>\n";
        echo "<tr id='barra_full'>\n";
        echo "<td class='Titulo_b' colspan='" . ($num_col_tab * (count($vetCampo) + 2)) . "'>" . nl();

        $inc_html = '';

        if ($novo) {
            if ($barra_inc_ap == true) {
                if (acesso($menu_acesso, "'INC'", false, false)) {
                    $inc_html .= "<a id='afirstmf' href='#' data-acao='inc' onclick='return btClick(\"inc\", 0)' title='{$barra_inc_h}' alt='{$barra_inc_h}' class='Titulo'>";
                    $inc_html .= LinkGrid("<img src='{$barra_inc_img}' title='{$barra_inc_h}' border='0'>", "{$barra_inc}", true);
                    $inc_html .= "</a>" . nl();
                } elseif (tem_direito($menu_acesso, "'INC'")) {
                    $inc_html .= "<a>" . nl();
                    $inc_html .= LinkGrid("<img src='{$barra_inc_img}' title='{$barra_inc_h}' alt='{$barra_inc_h}' border='0'>", "{$barra_inc}", true);
                    $inc_html .= "</a>" . nl();
                }
            }
        }

        if ($inc_chamada_barra) {
            echo $inc_html;
            $inc_html = '';
        }

        if ($bt_print) {
            $vetBtBarra[] = vetBtBarra($menu, $bt_print_descricao, $bt_print_img, "listar_rel_exportar('" . trata_aspa($bt_print_tit_rel) . "')", '', $bt_print_title, $bt_print_class);
        }

        foreach ($vetBtBarra as $BtBarra) {
            if (acesso($BtBarra['menu'])) {
                if ($BtBarra['prefixo'] == '') {
                    $href = '#';
                } else {
                    if ($BtBarra['arq_conteudo'] == '') {
                        $href = $pagina;
                    } else {
                        $href = $BtBarra['arq_conteudo'];
                    }

                    $href .= "?prefixo=" . $BtBarra['prefixo'] . "&menu=" . $BtBarra['menu'] . "&origem_tela=btbarra" . trata_html($BtBarra['parametro']);
                }

                echo '<a class="Titulo ' . $BtBarra['class'] . '" target="' . $BtBarra['target'] . '"';

                if ($BtBarra['onclick'] != '') {
                    echo ' onclick="return ' . $BtBarra['onclick'] . ';"';
                }

                echo ' href="' . $href . '">';

                echo '<div>';

                if ($BtBarra['img_src'] != '') {
                    echo '<img border="0" title="' . $BtBarra['img_title'] . '" src="' . $BtBarra['img_src'] . '" />';
                }

                echo $BtBarra['descricao'];
                echo '</div>';
                echo '</a>';
            }
        }

        if ($cont_arq == '') {
            if ($barra_fec_ap == true) {
                echo "<a href='$pagina' onclick='return confirm(\"Você deseja realmente fechar?\");' title='{$barra_fec_h}' alt='{$barra_fec_h}' class='Titulo'>";
                LinkGrid("<img src='{$barra_fec_img}' title='{$barra_fec_h}' alt='{$barra_fec_h}' border='0'>", "{$barra_fec}");
                echo "</a>" . nl();
            }
        }

        echo "</td>\n";
        echo "</tr>\n" . nl();
        echo "</table>";
    }

//Paginação
    $p = $_REQUEST['p'];
    $pag_tot = $rs->rows;

    if ($reg_pagina_esp === 'tudo') {
        $reg_pagina = $rs->rows * $num_col_tab;
    } else if ($reg_pagina_esp > 0) {
        $reg_pagina = $reg_pagina_esp * $num_col_tab;
    } else {
        $reg_pagina = $vetConf['reg_pagina'] * $num_col_tab;
    }

    if ($pag_tot <= $reg_pagina) {
        $pag_tot = 1;
    } elseif (($pag_tot % $reg_pagina) == 0) {
        $pag_tot = ($pag_tot / $reg_pagina);
    } else {
        $pag_tot = (int) ($pag_tot / $reg_pagina) + 1;
    }

    $pag_tot--;

    if (!is_numeric($p) || $p <= 0) {
        $p = 0;
    } elseif ($p > $pag_tot) {
        $p = $pag_tot;
    } else {
        $p--;
    }

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
    if ($fim > $rs->rows) {
        $fim = $rs->rows;
    }

    $ajustacolspan = 2;

    echo "<table width='100%' border='" . $table_border . "' cellspacing='0' cellpadding='0' vspace='0' hspace='0' class='Generica'>\n";

    if ($paginacao_top) {
        criar_tabela_paginacao(true, $p, $pag_tot, $ajustacolspan, $vetConf, $vetCampo, $pagina);
    }

    echo "<tr class='Generica'>\n";

    for ($c = 0; $c < $num_col_tab; $c++) {
        if ($tab_edit || $inc_html != '') {
            echo "<td id='Titulo_radio' class='Titulo_radio' style='$ctlinha' >\n";

            if (!$inc_chamada_barra) {
                $tab_edit = true;
                echo str_replace("id='afirstmf'", '', $inc_html);
            }

            echo "</td>\n";

            echo "<td class='acao_fecha'></td>\n";
        }

        ForEach ($vetCampo as $Campo => $Valor) {
            if ($cont_arq == '_pdf') {
                echo "<td class='Titulo " . $Valor['classet'] . "'><b>\n";
            } else {
                $data_campo = 'data-campo="' . $Campo . '"';
                echo "<td class='td_cab_acao Titulo " . $Valor['classet'] . "' {$data_campo}><b>\n";
            }

            if ($uppertxtcab == 0) {
                echo mb_strtoupper($Valor['nome']);
            } else {
                echo $Valor['nome'];
            }

            echo "</b></td>\n";
        }
    }

    echo "</tr>\n";

    if ($rs->rows == 0) {
        if ($outramsgvazio == true) {
            echo "<tr class='Registro' align=center>\n";
            echo "<td class='Registro' style='background:#600000; color:#FFFFFF; font-size:18px;'  colspan='" . ($num_col_tab * (count($vetCampo) + 2)) . "'>ATENÇÃO!<br />Não tem informação cadastrada!</td>\n";
            echo "</tr>\n";
        } else {
            /*
              $html .= "<tr class='Registro' align=center>\n";
              $html .= "<td class='Registro' style='background:#ECF0F1; color:#000000; font-size:11px;'  colspan='".($num_col_tab * (count($vetCampo) + $ajustacolspan))."'>ATENÇÃO! Sem Informação.</td>\n";
              $html .= "</tr>\n";
             */
            echo "<tr class='Registro' align=center>\n";
            echo "<td class='Registro' style='background:#ECF0F1; color:#000000; font-size:11px;'  colspan='" . ($num_col_tab * (count($vetCampo) + $ajustacolspan)) . "'>ATENÇÃO! Sem Informação.</td>\n";
            echo "</tr>\n";
        }
    } else {
        $indMenu = -1;
        $numfoto = 0;
        $fotolinha = 0;
        $trid = 0;
        $trHtml = '';

        if ($cont_arq == '_pdf') {
            $trHtml = "<tr class='Registro' align='left'>" . nl();
        } else {
            $trHtml = "<tr id=tr_l_" . $trid . " class='Registro' title='{$clique_hint_linha}' align=left" . ' onmouseover="marca_linha_over(' . "this,{$trid},'{$corimp}','{$corpar}','{$corcur}','{$corover}'" . ');"' . ' onmouseout="marca_linha_out(' . "this,{$trid},'{$corimp}','{$corpar}','{$corcur}'" . ');">' . nl();
        }

        for ($i = ($p * $reg_pagina); $i < $fim; $i++) {
            $row = $rs->data[$i];

            if ($rs->info['type'][$idCampo] == 'numeric') {
                $row[$idCampo] = (int) $row[$idCampo];
            }

            if (function_exists($func_trata_row)) {
                $func_trata_row($row);
            }

            if (function_exists('trataRowListarCmbMulti')) {
                trataRowListarCmbMulti($row);
            }

            echo $trHtml;
            $trHtml = '';

            if ($cont_arq == '_pdf') {
                $data_id = '';
                $ancora = '';
                $html_radio = '';
            } else {
                $data_id = 'data-id="' . $row[$idCampo] . '"';
                $ancora = '<a data-radioid="id_r_' . $trid . '" name="lin' . $row[$idCampo] . '"></a>';

                if ($prefixo == 'listar_cmbmulti' || $prefixo == 'listar_cmbmulti_acao') {
                    $input_type = 'checkbox';
                } else {
                    $input_type = 'radio';
                }

                $html_radio = '<input type="' . $input_type . '" class="Titulo_ctl ' . $prefixo . '" id="id_r_' . $trid . '" name="id" value="' . $row[$idCampo] . '" onclick="marca_linha(' . "this,{$trid},'{$corimp}','{$corpar}','{$corcur}'" . ');">' . nl();
            }

            $Colspan = "";

            if ($tab_edit) {
                echo "<td id='Titulo_ctl_" . $trid . "' class='Titulo_ctl' style='$ctlinha' >";

                if ($prefixo == 'listar_cmb') {
                    $mostraRegValido = true;

                    foreach ($vetListarCmbRegValido as $campoRegValido => $valoresRegValido) {
                        if (!in_array($row[$campoRegValido], $valoresRegValido)) {
                            $mostraRegValido = false;
                        }
                    }

                    if ($row[$idCampo] == '' || !$mostraRegValido) {
                        echo '<input type="radio" class="Titulo_ctl" id="id_r_' . $trid . '" onclick="marca_linha(' . "this,{$trid},'{$corimp}','{$corpar}','{$corcur}'" . ');">' . nl();
                        echo "<img src='imagens/trans.gif' width='36' height='0' border='0'>";
                    } else {
                        echo $html_radio;

                        switch ($rs->info['type'][$campoDescListarCmb]) {
                            case 'date':
                            case 'datetime':
                            case 'timestamp':
                                $vlTD = trata_data($row[$campoDescListarCmb]);
                                break;

                            case 'numeric':
                            case 'decimal':
                            case 'newdecimal':
                            case 'double':
                                $vlTD = format_decimal($row[$campoDescListarCmb]);
                                break;

                            default:
                                $vlTD = $row[$campoDescListarCmb];
                                break;
                        }

                        echo '<span class="display_none">' . $vlTD . '</span>';

                        echo "<a href='#' class='Titulo'>";
                        echo "<img src='imagens/bt_ok_32.png' onclick='return ListarBtSelecionar({$trid});' title='Selecionar Registro' alt='Selecionar Registro' border='0'>";
                        echo "</a>";
                    }

                    $html_radio = '';
                }

                if ($prefixo == 'listar_cmbmulti' || $prefixo == 'listar_cmbmulti_acao') {
                    $mostraRegValido = true;

                    foreach ($vetListarCmbRegValido as $campoRegValido => $valoresRegValido) {
                        if (!in_array($row[$campoRegValido], $valoresRegValido)) {
                            $mostraRegValido = false;
                        }
                    }

                    if ($row[$idCampo] == '' || !$mostraRegValido) {
                        echo '<input type="radio" class="Titulo_ctl" id="id_r_' . $trid . '" onclick="marca_linha(' . "this,{$trid},'{$corimp}','{$corpar}','{$corcur}'" . ');">' . nl();
                        echo "<img src='imagens/trans.gif' width='16' height='0' border='0'>";
                    } else {
                        $dados = Array();

                        foreach ($_SESSION[CS]['objListarCmbMulti'][$_GET['session_cod']]['vet_retorno'] as $vetTmpCampo) {
                            switch ($rs->info['type'][$vetTmpCampo['campo']]) {
                                case 'date':
                                case 'datetime':
                                case 'timestamp':
                                    $vlTD = trata_data($row[$vetTmpCampo['campo']]);
                                    break;

                                case 'numeric':
                                case 'decimal':
                                case 'newdecimal':
                                case 'double':
                                    $vlTD = format_decimal($row[$vetTmpCampo['campo']]);
                                    break;

                                default:
                                    $vlTD = $row[$vetTmpCampo['campo']];
                                    break;
                            }

                            $dados[$vetTmpCampo['campo']] = $vlTD;

                            echo '<input type="hidden" name="' . $vetTmpCampo['campo'] . '" value="' . trata_html($vlTD) . '">';
                        }

                        $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_GET['session_cod']]['sel_trab'];
                        $cod = md5(implode(', ', $dados));

                        if (array_key_exists($cod, $vetSel)) {
                            echo str_replace('<input ', '<input checked data-cod="' . $cod . '" ', $html_radio);
                        } else {
                            echo str_replace('<input ', '<input data-cod="' . $cod . '" ', $html_radio);
                        }
                    }

                    $html_radio = '';
                }

                foreach ($vetBtOrdem as $bt) {
                    switch ($bt) {
                        case 'alt':
                            if ($barra_alt_ap == true && $edit) {
                                if (acesso($menu_acesso, "'ALT'", false, false)) {
                                    echo "<a href='#' data-acao='alt' onclick='return btClick(\"alt\", \"{$row[$idCampo]}\")'  title='{$barra_alt_h}' alt='{$barra_alt_h}' class='Titulo'>";
                                    echo "<img src='{$barra_alt_img}' title='{$barra_alt_h}' alt='{$barra_alt_h}' border='0'>";
                                    echo "</a>";
                                } elseif (tem_direito($menu_acesso, "'ALT'")) {
                                    echo "<img src='{$barra_alt_img}' title='{$barra_alt_h}' alt='{$barra_alt_h}' border='0'>";
                                }
                            } else if ($barra_icone !== false) {
                                echo"<img src='imagens/trans.gif' width='{$barra_icone}' border='0'>";
                            }
                            break;

                        case 'con':
                            if ($barra_con_ap == true && $edit) {
                                if (acesso($menu_acesso, "'CON'", false, false)) {
                                    echo "<a href='#' data-acao='con' onclick='return btClick(\"con\", \"{$row[$idCampo]}\")'  title='{$barra_con_h}' alt='{$barra_con_h}' class='Titulo'>";
                                    echo "<img src='{$barra_con_img}' title='{$barra_con_h}' alt='{$barra_con_h}' border='0'>";
                                    echo "</a>";
                                } elseif (tem_direito($menu_acesso, "'CON'")) {
                                    echo "<img src='{$barra_con_img}' title='{$barra_con_h}' alt='{$barra_con_h}' border='0'>";
                                }
                            } else if ($barra_icone !== false) {
                                echo"<img src='imagens/trans.gif' width='{$barra_icone}' border='0'>";
                            }
                            break;

                        case 'exc':
                            if ($barra_exc_ap == true && $edit) {
                                if (acesso($menu_acesso, "'EXC'", false, false)) {
                                    echo "<a href='#' data-acao='exc' onclick='return btClick(\"exc\", \"{$row[$idCampo]}\")'  title='{$barra_exc_h}' alt='{$barra_exc_h}' class='Titulo'>";
                                    echo "<img src='{$barra_exc_img}' title='{$barra_exc_h}' alt='{$barra_exc_h}' border='0'>";
                                    echo "</a>";
                                } elseif (tem_direito($menu_acesso, "'EXC'")) {
                                    echo "<img src='{$barra_exc_img}' title='{$barra_exc_h}' alt='{$barra_exc_h}' border='0'>";
                                }
                            } else if ($barra_icone !== false) {
                                echo"<img src='imagens/trans.gif' width='{$barra_icone}' border='0'>";
                            }
                            break;

                        case 'go':
                            $gojs = '';
                            $tem_esconde = false;

                            ForEach ($goCad as $Cad) {
                                if ($Cad['mostrar']) {
                                    $esconde = '';
                                } else {
                                    $esconde = 'esconde';
                                    $tem_esconde = true;
                                }

                                if (is_array($Cad['grupo'])) {
                                    $gojs .= "var goTemp = new Array();\n";

                                    $i_link = 0;
                                    ForEach ($Cad['grupo'] as $CadGrd) {
                                        if ($CadGrd['cond_campo'] == '') {
                                            $mostra = true;
                                        } else if (is_array($CadGrd['cond_valor'])) {
                                            if (in_array($row[$CadGrd['cond_campo']], $CadGrd['cond_valor'])) {
                                                $mostra = true;
                                            } else {
                                                $mostra = false;
                                            }
                                        } else if ($row[$CadGrd['cond_campo']] == $CadGrd['cond_valor']) {
                                            $mostra = true;
                                        } else {
                                            $mostra = false;
                                        }

                                        if ($mostra) {
                                            $url = $sqlOrderby_upcad;

                                            if ($CadGrd['campo'] == '') {
                                                if (is_array($vetFiltro)) {
                                                    $idx = -1;
                                                    ForEach ($vetFiltro as $Filtro) {
                                                        if ($ordFiltro) {
                                                            $idx++;
                                                            $vl = $Filtro['id'] . $idx;
                                                        } else {
                                                            $vl = $Filtro['id'];
                                                        }

                                                        if ($extra_goCad[$vl] == '') {
                                                            $url .= "&{$vl}=" . $row[$Filtro['id']];
                                                        } else {
                                                            $url .= "&{$vl}=" . $extra_goCad[$vl];
                                                        }
                                                    }

                                                    $url .= "&{$idCampoPar}=" . $row[$idCampo] . '&id=' . $row[$idCampo];
                                                }
                                            } else {
                                                ForEach (explode(',', $CadGrd['campo']) as $idx => $dbCampo) {
                                                    if ($extra_goCad[$dbCampo . $idx] == '') {
                                                        $url .= "&$dbCampo$idx=" . $row[$dbCampo];
                                                    } else {
                                                        $url .= "&$dbCampo$idx=" . $extra_goCad[$dbCampo . $idx];
                                                    }
                                                    //  guy
                                                    $url .= "&{$idCampoPar}=" . $row[$idCampo] . '&id=' . $row[$idCampo];
                                                }
                                            }

                                            if (acesso($CadGrd['menu'])) {
                                                $gojs .= "goTemp[goTemp.length] = \"<a class='MenuLink' id='link" . ($i_link++) . "' target='_parent' href='$pagina?prefixo=" . $CadGrd['prefixo'] . "&menu=" . $CadGrd['menu'] . "&origem_tela=gocad{$url}'>" . $CadGrd['nome'] . "</a>\";\n";
                                            }
                                        }
                                    }

                                    if ($i_link > 0) {
                                        $indMenu++;
                                        $gojs .= "goCad[$indMenu] = goTemp;\n";

                                        echo "<a class='Titulo $esconde' href='#' onmousemove=\"MenuAbre($indMenu, event)\">";
                                        echo "<img src='" . $Cad['imagem'] . "' border='0'>";
                                        echo "</a>";
                                    }
                                } else {
                                    if ($Cad['cond_campo'] == '') {
                                        $mostra = true;
                                    } else if (is_array($Cad['cond_valor'])) {
                                        if (in_array($row[$Cad['cond_campo']], $Cad['cond_valor'])) {
                                            $mostra = true;
                                        } else {
                                            $mostra = false;
                                        }
                                    } else if ($row[$Cad['cond_campo']] == $Cad['cond_valor']) {
                                        $mostra = true;
                                    } else {
                                        $mostra = false;
                                    }

                                    if ($mostra) {
                                        $url = $sqlOrderby_upcad;

                                        if ($Cad['campo'] == '') {
                                            if (is_array($vetFiltro)) {
                                                $idx = -1;
                                                ForEach ($vetFiltro as $Filtro) {
                                                    if ($ordFiltro) {
                                                        $idx++;
                                                        $vl = $Filtro['id'] . $idx;
                                                    } else {
                                                        $vl = $Filtro['id'];
                                                    }

                                                    if ($extra_goCad[$vl] == '') {
                                                        $url .= "&{$vl}=" . $row[$Filtro['id']];
                                                    } else {
                                                        $url .= "&{$vl}=" . $extra_goCad[$vl];
                                                    }
                                                }

                                                $url .= "&{$idCampoPar}=" . $row[$idCampo] . '&id=' . $row[$idCampo];
                                            }
                                        } else {
                                            ForEach (explode(',', $Cad['campo']) as $idx => $dbCampo) {
                                                if ($extra_goCad[$dbCampo . $idx] == '') {
                                                    $url .= "&$dbCampo$idx=" . $row[$dbCampo];
                                                } else {
                                                    $url .= "&$dbCampo$idx=" . $extra_goCad[$dbCampo . $idx];
                                                }
                                            }
                                            //  guy
                                            $url .= "&{$idCampoPar}=" . $row[$idCampo] . '&id=' . $row[$idCampo];
                                        }

                                        if (acesso($Cad['menu'])) {
                                            echo "<a class='Titulo $esconde' target='_self' href='$pagina?prefixo=" . $Cad['prefixo'] . "&menu=" . $Cad['menu'] . "&origem_tela=gocad{$url}'>";
                                            echo "<img src='" . $Cad['imagem'] . "' title='" . $Cad['nome'] . "' border='0'>";
                                            echo "</a>";
                                        } else {
                                            echo "<a class='Titulo $esconde' target='_self' href='#' style='cursor:default;'>";
                                            echo "<img src='" . $Cad['imagem'] . "' title='" . $Cad['nome'] . "' border='0'>";
                                            echo "</a>";
                                        }
                                    }
                                }
                            }

                            if ($tem_esconde) {
                                echo '<span class="esconde">+</span>';
                            }

                            if ($gojs != '') {
                                echo nl() . '<script type="text/javascript">' . nl();
                                echo $gojs;
                                echo '</script>' . nl();
                            }
                            break;
                    }
                }

                echo $html_radio;

                echo "</td>\n";

                echo "<td class='acao_fecha'></td>\n";
            } else {
                echo $html_radio;

                if ($inc_html != '') {
                    $Colspan = "colspan='2'";
                }
            }

            ForEach ($vetCampo as $strCampo => $Valor) {
                $tipo = explode(", ", $Valor['tipo']);
                $data_campo = 'data-campo="' . $strCampo . '"';
                $strCampo = explode(", ", $strCampo);

                if ($cont_arq == '_pdf') {
                    echo "<td $Colspan class='Registro " . $Valor['classer'] . "'>\n";
                } else {
                    echo "<td $Colspan {$data_campo} {$data_id} class='td_acao Registro " . $Valor['classer'] . "'  >\n";
                }

                $Colspan = '';

                echo $ancora;
                $ancora = '';

                $leftw = 0;
                $vlTD = '';
                ForEach ($strCampo as $idx => $Campo) {
                    if (count($strCampo) > 1 && $idx > 0)
                        $vlTD .= ' ';

                    switch ($tipo[$idx]) {
                        case 'descDominio':
                            if (count($strCampo) == 1) {
                                if ($Valor['vetDominio'][$row[$Campo]] == '')
                                    $vlTD .= $row[$Campo];
                                else
                                    $vlTD .= $Valor['vetDominio'][$row[$Campo]];
                            } else {
                                if ($Valor['vetDominio'][$idx][$row[$Campo]] == '')
                                    $vlTD .= $row[$Campo];
                                else
                                    $vlTD .= $Valor['vetDominio'][$idx][$row[$Campo]];
                            }
                            break;

                        case 'data':
                            $vlTD .= trata_data($row[$Campo]);
                            break;

                        case 'datahora':
                            $vlTD .= trata_data($row[$Campo], true);
                            break;

                        case 'decimal':
                            $leftw = 1;
                            $vlTD .= format_decimal($row[$Campo], $Valor['ndecimal']);
                            break;

                        case 'inteiro':
                            $leftw = 1;
                            $vlTD .= format_decimal($row[$Campo], 0);
                            break;

                        case 'arquivo':
                            $vlTD .= '';
                            $path = $dir_file . '/' . $Valor['tabela'] . '/';

                            $vetImagemProdPrefixo = explode('_', $row[$Campo]);
                            $ImagemProdPrefixo = '';
                            $ImagemProdPrefixo .= $vetImagemProdPrefixo[0] . '_';
                            $ImagemProdPrefixo .= $vetImagemProdPrefixo[1] . '_';
                            $ImagemProdPrefixo .= $vetImagemProdPrefixo[2] . '_';

                            ImagemProd($Valor['vetDominio'], null, $path, $row[$Campo], $ImagemProdPrefixo);
                            break;

                        case 'arquivo_link':
                            $vlTD .= '';
                            $path = $dir_file . '/' . $Valor['tabela'] . '/';

                            ArquivoLink($path, $row[$Campo], $row[$idCampo] . '_' . $Campo . '_');
                            break;

                        case 'link':
                            $stx = "<span style='color:#0080C0; text-decoration:none;'>";
                            $stx .= "<a href='$row[$Campo]' target='_blank' style='font-size:13px; font-weight: bold; cursor:pointer; color:#0080C0; text-decoration:none;'>" . $row[$Campo] . "</a>";
                            $stx .= "</span>";
                            $vlTD .= $stx;
                            break;


                        case 'func_trata_dado':
                            $vlTD .= $Valor['vetDominio']($row[$Campo], $row, $Campo);
                            break;

                        default:
                            $vlTD .= $row[$Campo];
                            break;
                    }
                }

                echo "$vlTD</td>\n";
            }

            $fotolinha++;

            if (++$numfoto == $num_col_tab) {
                if ($i != $fim - 1) {
                    echo"</tr>\n";
                }

                if ($i < $fim - 1) {
                    $trid = $trid + 1;

                    $linhapar = ($i % 2) == 0 ? 'P' : 'I';

                    if ($cont_arq == '_pdf') {
                        if ($linhapar == 'P') {
                            $trHtml = "<tr class='Registro1' align=left" . '>' . nl();
                        } else {
                            $trHtml = "<tr class='Registro' align=left" . '>' . nl();
                        }
                    } else {
                        if ($linhapar == 'P') {
                            $trHtml = "<tr id=tr_l_" . $trid . " class='Registro1' title='{$clique_hint_linha}' align=left" . ' onmouseover="marca_linha_over(' . "this,{$trid},'{$corimp}','{$corpar}','{$corcur}','{$corover}'" . ');"' . ' onmouseout="marca_linha_out(' . "this,{$trid},'{$corimp}','{$corpar}','{$corcur}'" . ');">' . nl();
                        } else {
                            $trHtml = "<tr id=tr_l_" . $trid . " class='Registro' title='{$clique_hint_linha}' align=left" . ' onmouseover="marca_linha_over(' . "this,{$trid},'{$corimp}','{$corpar}','{$corcur}','{$corover}'" . ');"' . ' onmouseout="marca_linha_out(' . "this,{$trid},'{$corimp}','{$corpar}','{$corcur}'" . ');">' . nl();
                        }
                    }
                }

                $fotolinha = 0;
                $numfoto = 0;
            }
        }

        echo $trHtml;

        for ($i = $fotolinha; ($i < $num_col_tab && $i > 0); $i++) {
            $Colspan = "";
            if ($tab_edit) {
                echo "<td class='Titulo'>&nbsp;</td>\n";
            } else
                $Colspan = "colspan='2'";

            ForEach ($vetCampo as $strCampo => $Valor) {
                echo "<td $Colspan class='Registro'>&nbsp;</td>\n";
            }
        }

        echo"</tr>\n";

        if ($paginacao_bottom) {
            criar_tabela_paginacao(false, $p, $pag_tot, $ajustacolspan, $vetConf, $vetCampo, $pagina);
        }

        if ($extra_pagina) {
            echo "<tr class='Generica ExtraPagina'><td align='center' class='Titulo_r' colspan='" . (count($vetCampo) + $ajustacolspan) . "'> ";
            echo str_replace("#qt", $rs->rows, $contlinfim);
            echo "</td></tr>\n";
        }
    }

    echo "</table>\n";

    if ($cont_arq != '_pdf') {
        ?>
        <script type="text/javascript">
            $(document).ready(function () {
                if (self.location.hash != '') {
                    //window.setTimeout(function () {
                    self.location = self.location.hash;
                    //}, 100);

                    var radioid = '#' + $('a[name=' + self.location.hash.substr(1) + ']').data('radioid');
                    $(radioid).prop('checked', true).click();
                }

                $('td.td_acao').click(function () {
                    if ($.isFunction(self.<?php echo $lista_td_acao_click; ?>)) {
                        var id = $(this).data('id');
                        var campo = $(this).data('campo');

        <?php echo $lista_td_acao_click; ?>(id, campo, $(this));
                    }
                });

                $('td.td_cab_acao').click(function () {
                    if ($.isFunction(self.<?php echo $lista_td_cab_acao_click; ?>)) {
                        var campo = $(this).data('campo');

        <?php echo $lista_td_cab_acao_click; ?>(campo, $(this));
                    }
                });

                $('td.Titulo_ctl > span.esconde').click(function () {
                    if ($(this).text() == '+') {
                        $(this).text('-');
                        $(this).parent().find('a.esconde').show();
                    } else {
                        $(this).text('+');
                        $(this).parent().find('a.esconde').hide();
                    }
                });
            });
        </script>
        <?php
    }
    return 0;
}

function criar_tabela_paginacao($topo, $p, $pag_tot, $ajustacolspan, $vetConf, $vetCampo, $pagina) {
    //Linha de Paginação
    $strPara = 'p,sql_orderby,sql_orderby_extra';
    $url_extra = getParametro($strPara);

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
        if ($ini < 1) {
            $ini = 1;
        }

        $fim = $pag_tot;
    }

    if ($ini != $fim) {
        echo "<tr class='Generica NavegaPagina'  align='center'>
                  <td class='Titulo_r' colspan='" . (count($vetCampo) + $ajustacolspan) . "'>
                  <a href='$pagina?p=1" . $url_extra . "' class='Titulo'>";
        echo "<img src='imagens/bt_home" . img_dispositivo . ".png' title='Vai para o Inicio da Tabela' border='0'>";
        echo "</a>&nbsp;&nbsp;";

        echo "<a href='$pagina?p=" . ($p - 1) . $url_extra . "' class='Titulo'>";
        echo "<img src='imagens/bt_paginaacima" . img_dispositivo . ".png' title='Recua uma Página na Tabela' border='0'>";
        echo "</a>&nbsp;&nbsp;";

        for ($i = $ini; $i <= $fim; $i++) {
            if ($i == $p)
                echo "<span class='titulo' style='color: Red;'>$i&nbsp;</span>";
            else
                echo "<a href='$pagina?p=$i" . $url_extra . "' class='Titulo'>$i</a>&nbsp;";
        }

        echo "<a href='$pagina?p=" . ($p + 1) . $url_extra . "' class='Titulo'>";
        echo "<img src='imagens/bt_paginaabaixo" . img_dispositivo . ".png' title='Avança uma Página na Tabela' border='0'>";
        echo "</a>&nbsp;&nbsp;";

        echo "<a href='$pagina?p=$pag_tot" . $url_extra . "' class='Titulo'>";
        echo "<img src='imagens/bt_end" . img_dispositivo . ".png' title='Vai para o Fim da Tabela' border='0'>";
        echo "</a>&nbsp;&nbsp;";

        if ($pag_tot > (2 * $vetConf['num_pagina'])) {
            echo '&nbsp;&nbsp;&nbsp;';

            $tam = strlen($pag_tot);
            for ($i = 1; $i <= $pag_tot; $i++) {
                $vetPag[$i] = str_repeat("0", $tam - strlen($i)) . $i;
            }

            criar_combo_vet($vetPag, 'goPag' . $topo, $p, '', "onchange = 'funcPag(this)'", 'font-size : 11px; line-height : 11px;');

            if ($topo) {
                echo "
                    <script type='text/javascript'>
                        function funcPag(obj) {
                            self.location = '$pagina?p=' + obj.value + '" . $url_extra . "';
                        }
                    </script>
                ";
            }
        }

        echo "</td></tr>\n";
    }
}

function codigoListarConf(&$Coluna, $vetID) {
    global $vetConf, $dir_file, $barra_ap_row, $barra_alt_ap_row, $barra_con_ap_row, $barra_exc_ap_row, $acao, $acao_alt_con, $menu, $idInput;

    if ($vetID[$Coluna['tabela']] == 0 && !$Coluna['vetParametros']['mostra_tabela']) {
        echo 'Continue o cadastro para poder habilitar esta informação!';
    } else {
        $Coluna['vetParametros']['iframe_name'] = $Coluna['campo'] . '_frm';

        switch ($acao) {
            case 'con':
            case 'exc':
            case 'per':
                if ($Coluna['vetParametros']['barra_inc_ap_muda_vl']) {
                    $Coluna['vetParametros']['barra_inc_ap'] = false;
                }

                if ($Coluna['vetParametros']['barra_alt_ap_muda_vl']) {
                    $Coluna['vetParametros']['barra_alt_ap'] = false;
                }

                if ($Coluna['vetParametros']['barra_exc_ap_muda_vl']) {
                    $Coluna['vetParametros']['barra_exc_ap'] = false;
                }
                break;
        }

        $acao_alt_con_p = $Coluna['vetParametros']['acao_alt_con_p'];

        if ($acao_alt_con == 'S' and $acao_alt_con_p == '') {
            $Coluna['vetParametros']['barra_inc_ap'] = false;
            $Coluna['vetParametros']['barra_alt_ap'] = false;
            $Coluna['vetParametros']['barra_exc_ap'] = false;
        }

        if (is_string($Coluna['sql'])) {
            $Coluna['sql'] = str_replace('$vlID', $vetID[$Coluna['tabela']], $Coluna['sql']);
            $rs_x = execsql($Coluna['sql']);
        } else {
            $rs_x = $Coluna['sql'];
        }

        $session_cod = md5($menu . '_' . $Coluna['campo'] . '_' . $vetID[$Coluna['tabela']]);

        $strData = '';
        $strData .= ' data-tipo="' . $Coluna['tipo'] . '"';
        $strData .= ' data-session_cod="' . $session_cod . '"';

        $input_data = $Coluna['vetParametros']['input_data'];

        if (is_array($input_data)) {
            foreach ($input_data as $key => $value) {
                $strData .= ' data-' . $key . '="' . trata_html($value) . '"';
            }
        }

        echo '<input id="' . $idInput . '"' . $strData . ' type="hidden">';

        $_SESSION[CS]['objListarConf'][$session_cod] = $Coluna;

        $tmp = $_SESSION[CS]['objListarConf_vetID'][$_GET['session_cod']];

        if (!is_array($tmp)) {
            $tmp = Array();
        }

        $_SESSION[CS]['objListarConf_vetID'][$session_cod] = array_merge($tmp, $vetID);

        if (function_exists($Coluna['vetParametros']['func_trata_rs'])) {
            $rs_x = $Coluna['vetParametros']['func_trata_rs']($rs_x);
        }

        $idCad = $Coluna['vetParametros']['idCadPer'];

        if ($idCad == '') {
            $idCad = $vetID[$Coluna['tabela']];
        }

        //Se mudar alguma coisa na chamada da função também tem que mudar em ajax_plu.php case listarconf
        echo criar_tabela_cadastro($idCad, false, $rs_x, $Coluna['vetCampo'], $Coluna['idCampo'], true, true, 'cadastro', $Coluna['menu'], $Coluna['vetParametros'], $session_cod, $Coluna['titulo'], $Coluna['campo']);

        if ($Coluna['vetParametros']['iframe'] === true) {
            echo '<span id="' . $idInput . '_frm_aviso" class="aviso_iframe"><img src="imagens/ajax-loader.gif" />Aguarde, processando...</span>';
            echo '<iframe src="" id="' . $idInput . '_frm" name="' . $Coluna['campo'] . '_frm" width="100%" height="0" scrolling="auto" frameborder="0" onload="$(\'#' . $Coluna['campo'] . '_frm_aviso\').hide();"></iframe>';
        }
    }
}

function criar_tabela_cadastro($idCad, $ajax, $rs, $vetCampo, $idCampo, $novo, $edit, $prefixo, $novomenu, $vetParametros, $session_cod, $titulo, $campo_frm) {
    global $vetConf, $dir_file, $barra_ap_row, $barra_alt_ap_row, $barra_con_ap_row, $barra_exc_ap_row;

    $barra_ap_row = false;

    extract($vetParametros);

    $vetBtOrdemPadrao = Array('exc', 'con', 'alt', 'per');
    $vetTmp = array_diff($vetBtOrdemPadrao, $vetBtOrdem);
    $vetBtOrdem = array_merge($vetBtOrdem, $vetTmp);

    $html = '';
    $html_final = '';
    $menulocal = $novomenu;

    if ($iframe === true) {
        $iframe = 'S';
    } else {
        $iframe = 'N';
    }

    if ($menu_acesso == '') {
        $menu_acesso = $menulocal;
    }

    if ($edit) {
        $tab_edit = true;
    } else {
        $tab_edit = false;
    }

    $html_final .= '
        <style type="text/css">
            Tr.Registro:nth-child(even) {
                background-color: ' . $corpar . ';
                cursor:default;
            }

            Tr.Registro:nth-child(odd) {
              background-color: ' . $corimp . ';
              cursor:default;
            }
            
            Tr.Registro:hover {
              background-color: ' . $corover . ';
              cursor:default;
            }
        </style>
    ';

    $ajustacolspan = 2;

    $table_border = '0';

    $inc_html = '';

    if ($novo) {
        if ($barra_inc_ap == true) {
            if (acesso($menu_acesso, "'INC'", false, false)) {
                if ($bt_inc_menu == '') {
                    $bt_inc_menu = $menulocal;
                }

                $inc_html .= "<a id='afirstmf' data-acao='inc' href='#' onclick='return btClickCTC($(\"#{$campo_frm}\"), \"{$idCad}\", \"inc\", 0, \"{$prefixo}\", \"{$bt_inc_menu}\", \"{$session_cod}\", \"{$titulo}\", \"{$iframe}\", \"{$iframe_name}\")' title='{$barra_inc_h}' alt='{$barra_inc_h}' class='Titulo'>";
                $inc_html .= "<img src='{$barra_inc_img}' title='{$barra_inc_h}' border='0'>";
                $inc_html .= "</a>" . nl();
            } elseif (tem_direito($menu_acesso, "'INC'")) {
                $inc_html .= "<a>" . nl();
                $inc_html .= "<img src='{$barra_inc_img}' title='{$barra_inc_h}' alt='{$barra_inc_h}' border='0'>";
                $inc_html .= "</a>" . nl();
            }
        }
    }

    foreach ($campo_hidden_form as $key => $value) {
        $html .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />' . nl();
    }

    $html .= '<input id="' . $campo_frm . '_tot" value="' . ($rs->rows == 0 ? '' : $rs->rows) . '" type="hidden">' . nl();

    $html .= "<table width='100%' border='" . $table_border . "' cellspacing='0' cellpadding='0' vspace='0' hspace='0' class='Generica tablesorter-default'>\n";
    $html .= "<thead>\n";
    $html .= "<tr class='Generica'>\n";

    $vetTot = Array();
    $temTot = false;

    for ($c = 0; $c < $num_col_tab; $c++) {
        if ($tab_edit || $inc_html != '') {
            $html .= "<td id='Titulo_radio' class='Titulo_radio sorter-false' style='$ctlinha' >\n";

            $tab_edit = true;
            $html .= str_replace("id='afirstmf'", '', $inc_html);

            $html .= "</td>\n";

            $html .= "<td class='acao_fecha sorter-false'></td>\n";
        }

        ForEach ($vetCampo as $Campo => $Valor) {
            $vetTot[$Campo] = 0;

            $data_campo = 'data-campo="' . $Campo . '"';
            $html .= "<td class='td_cab_acao Titulo " . $Valor['classet'] . "' {$data_campo}><b>\n";

            if ($uppertxtcab == 0) {
                $html .= mb_strtoupper($Valor['nome']);
            } else {
                $html .= $Valor['nome'];
            }

            $html .= "</b></td>\n";
        }
    }

    $html .= "</tr>\n";

    $html .= "</thead>\n";
    $html .= "<tbody>\n";

    if ($rs->rows == 0) {
        $extra_pagina = false;

        if ($outramsgvazio == true) {
            $html .= "<tr class='Registro' align=center>\n";
            $html .= "<td class='Registro' style='background:#600000; color:#FFFFFF; font-size:18px;'  colspan='" . ($num_col_tab * (count($vetCampo) + $ajustacolspan)) . "'>ATENÇÃO!<br />Não tem informação cadastrada!</td>\n";
            $html .= "</tr>\n";
        } else {
            /*
              $html .= "<tr class='Registro' align=center>\n";
              $html .= "<td class='Registro' style='background:#ECF0F1; color:#000000; font-size:11px;'  colspan='".($num_col_tab * (count($vetCampo) + $ajustacolspan))."'>ATENÇÃO! Sem Informação.</td>\n";
              $html .= "</tr>\n";
             */
            $html .= "<tr class='Registro' align=center>\n";
            $html .= "<td class='Registro' style='background:#ECF0F1; color:#000000; font-size:11px;'  colspan='" . ($num_col_tab * (count($vetCampo) + $ajustacolspan)) . "'>ATENÇÃO! Sem Informação.</td>\n";
            $html .= "</tr>\n";
        }
    } else {
        $numfoto = 0;
        $fotolinha = 0;
        $trid = 0;
        $fim = $rs->rows;

        if ($campo_hidden_row == '') {
            $campo_hidden_row = array();
        } else {
            $campo_hidden_row = explode(',', $campo_hidden_row);
        }

        $html .= "<tr id=tr_l_" . $trid . " class='Registro' title='{$clique_hint_linha}' align=left" . '>' . nl();

        foreach ($rs->data as $i => $row) {
            if ($rs->info['type'][$idCampo] == 'numeric') {
                $row[$idCampo] = (int) $row[$idCampo];
            }

            $data_id = 'data-id="' . $row[$idCampo] . '"';
            $ancora = '<a data-radioid="id_r_' . $trid . '" name="lin' . $row[$idCampo] . '"></a>';
            $html_radio = '<input type="radio" class="Titulo_ctl" id="id_r_' . $trid . '" name="id" value="' . $row[$idCampo] . '" onclick="marca_linha(' . "this,{$trid},'{$corimp}','{$corpar}','{$corcur}'" . ');">' . nl();
            $Colspan = "";
            $td_style = '';

            $barra_alt_ap_row = $barra_alt_ap;
            $barra_con_ap_row = $barra_con_ap;
            $barra_exc_ap_row = $barra_exc_ap;

            if (function_exists($func_trata_row)) {
                $func_trata_row($row);
            }

            if ($row[$campo_linha_cor] != '') {
                $td_style = 'style="color: #ffffff; background-color: #' . $row[$campo_linha_cor] . '"';
            }

            if ($tab_edit) {
                $html .= "<td id='Titulo_ctl_" . $trid . "' class='Titulo_ctl' style='$ctlinha' >";

                foreach ($vetBtOrdem as $bt) {
                    switch ($bt) {
                        case 'alt':
                            if ($barra_alt_ap_row == true && $edit) {
                                if (acesso($menu_acesso, "'ALT'", false, false)) {
                                    $html .= "<a href='#' data-acao='alt' {$data_id} onclick='return btClickCTC($(\"#{$campo_frm}\"), \"{$idCad}\", \"alt\", \"{$row[$idCampo]}\", \"{$prefixo}\", \"{$menulocal}\", \"{$session_cod}\", \"{$titulo}\", \"{$iframe}\", \"{$iframe_name}\")'  title='{$barra_alt_h}' alt='{$barra_alt_h}' class='Titulo'>";
                                    $html .= "<img src='{$barra_alt_img}' title='{$barra_alt_h}' alt='{$barra_alt_h}' border='0'>";
                                    $html .= "</a>";
                                } elseif (tem_direito($menu_acesso, "'ALT'")) {
                                    $html .= "<img src='{$barra_alt_img}' title='{$barra_alt_h}' alt='{$barra_alt_h}' border='0'>";
                                }
                            } else if ($barra_ap_row) {
                                $html .= "<a class='Titulo'>";
                                $html .= "<img src='{$barra_alt_img}' style='visibility: hidden;' border='0'>";
                                $html .= "</a>";
                            } else if ($barra_icone !== false) {
                                $html .= "<img src='imagens/trans.gif' width='{$barra_icone}' border='0'>";
                            }
                            break;

                        case 'con':
                            if ($barra_con_ap_row == true && $edit) {
                                if (acesso($menu_acesso, "'CON'", false, false)) {
                                    $html .= "<a href='#' data-acao='con' {$data_id} onclick='return btClickCTC($(\"#{$campo_frm}\"), \"{$idCad}\", \"con\", \"{$row[$idCampo]}\", \"{$prefixo}\", \"{$menulocal}\", \"{$session_cod}\", \"{$titulo}\", \"{$iframe}\", \"{$iframe_name}\")'  title='{$barra_con_h}' alt='{$barra_con_h}' class='Titulo'>";
                                    $html .= "<img src='{$barra_con_img}' title='{$barra_con_h}' alt='{$barra_con_h}' border='0'>";
                                    $html .= "</a>";
                                } elseif (tem_direito($menu_acesso, "'CON'")) {
                                    $html .= "<img src='{$barra_con_img}' title='{$barra_con_h}' alt='{$barra_con_h}' border='0'>";
                                }
                            } else if ($barra_ap_row) {
                                $html .= "<a class='Titulo'>";
                                $html .= "<img src='{$barra_con_img}' style='visibility: hidden;' border='0'>";
                                $html .= "</a>";
                            } else if ($barra_icone !== false) {
                                $html .= "<img src='imagens/trans.gif' width='{$barra_icone}' border='0'>";
                            }
                            break;

                        case 'exc':
                            if ($barra_exc_ap_row == true && $edit) {
                                if (acesso($menu_acesso, "'EXC'", false, false)) {
                                    $html .= "<a href='#' data-acao='exc' {$data_id} onclick='return btClickCTC($(\"#{$campo_frm}\"), \"{$idCad}\", \"exc\", \"{$row[$idCampo]}\", \"{$prefixo}\", \"{$menulocal}\", \"{$session_cod}\", \"{$titulo}\", \"{$iframe}\", \"{$iframe_name}\")'  title='{$barra_exc_h}' alt='{$barra_exc_h}' class='Titulo'>";
                                    $html .= "<img src='{$barra_exc_img}' title='{$barra_exc_h}' alt='{$barra_exc_h}' border='0'>";
                                    $html .= "</a>";
                                } elseif (tem_direito($menu_acesso, "'EXC'")) {
                                    $html .= "<img src='{$barra_exc_img}' title='{$barra_exc_h}' alt='{$barra_exc_h}' border='0'>";
                                }
                            } else if ($barra_ap_row) {
                                $html .= "<a class='Titulo'>";
                                $html .= "<img src='{$barra_exc_img}' style='visibility: hidden;' border='0'>";
                                $html .= "</a>";
                            } else if ($barra_icone !== false) {
                                $html .= "<img src='imagens/trans.gif' width='{$barra_icone}' border='0'>";
                            }
                            break;

                        case 'per':
                            if (is_callable($func_botao_per)) {
                                $html .= $func_botao_per($row, $session_cod);
                            }
                            break;
                    }
                }

                $html .= $html_radio;

                foreach ($campo_hidden_row as $value) {
                    $value = trim($value);
                    $html .= '<input type="hidden" name="' . $value . '[]" value="' . $row[$value] . '" />' . nl();
                }

                $html .= "</td>\n";

                $html .= "<td class='acao_fecha'></td>\n";
            } else {
                $html .= $html_radio;

                if ($inc_html != '') {
                    $Colspan = "colspan='2'";
                }
            }

            ForEach ($vetCampo as $strCampo => $Valor) {
                $tipo = explode(", ", $Valor['tipo']);
                $data_campo = 'data-campo="' . $strCampo . '"';
                $strCampo = explode(", ", $strCampo);

                $leftw = 0;
                $vlTD = '';
                $extra_attr = '';

                ForEach ($strCampo as $idx => $Campo) {
                    if (count($strCampo) > 1 && $idx > 0)
                        $vlTD .= ' ';

                    switch ($tipo[$idx]) {
                        case 'descDominio':
                            if (count($strCampo) == 1) {
                                if ($Valor['vetDominio'][$row[$Campo]] == '')
                                    $vlTD .= $row[$Campo];
                                else
                                    $vlTD .= $Valor['vetDominio'][$row[$Campo]];
                            } else {
                                if ($Valor['vetDominio'][$idx][$row[$Campo]] == '')
                                    $vlTD .= $row[$Campo];
                                else
                                    $vlTD .= $Valor['vetDominio'][$idx][$row[$Campo]];
                            }
                            break;

                        case 'data':
                            $vlTD .= trata_data($row[$Campo]);
                            break;

                        case 'datahora':
                            $vlTD .= trata_data($row[$Campo], true);
                            break;

                        case 'limite_txt':
                            $extra_attr .= 'title="' . $row[$Campo] . '"';
                            $vlTD .= abreviaString($row[$Campo], $Valor['vetDominio']);
                            break;

                        case 'decimal':
                            $leftw = 1;
                            $vlTD .= format_decimal($row[$Campo], $Valor['ndecimal']);
                            break;

                        case 'inteiro':
                            $leftw = 1;
                            $vlTD .= format_decimal($row[$Campo], 0);
                            break;

                        case 'arquivo':
                            $vlTD .= '';
                            $path = $dir_file . '/' . $Valor['tabela'] . '/';

                            $vetImagemProdPrefixo = explode('_', $row[$Campo]);
                            $ImagemProdPrefixo = '';
                            $ImagemProdPrefixo .= $vetImagemProdPrefixo[0] . '_';
                            $ImagemProdPrefixo .= $vetImagemProdPrefixo[1] . '_';
                            $ImagemProdPrefixo .= $vetImagemProdPrefixo[2] . '_';

                            $vlTD .= ImagemProdListarConf($Valor['vetDominio'], $path, $row[$Campo], $ImagemProdPrefixo, false, true);
                            break;

                        case 'arquivo_sem_nome':
                            $vlTD .= '';
                            $path = $dir_file . '/' . $Valor['tabela'] . '/';

                            $vetImagemProdPrefixo = explode('_', $row[$Campo]);
                            $ImagemProdPrefixo = '';
                            $ImagemProdPrefixo .= $vetImagemProdPrefixo[0] . '_';
                            $ImagemProdPrefixo .= $vetImagemProdPrefixo[1] . '_';
                            $ImagemProdPrefixo .= $vetImagemProdPrefixo[2] . '_';

                            $vlTD .= ImagemProdListarConf($Valor['vetDominio'], $path, $row[$Campo], $ImagemProdPrefixo, false, true, null, true);
                            break;

                        case 'arquivo_link':
                            $vlTD .= '';
                            $path = $dir_file . '/' . $Valor['tabela'] . '/';

                            $vetImagemProdPrefixo = explode('_', $row[$Campo]);
                            $ImagemProdPrefixo = '';
                            $ImagemProdPrefixo .= $vetImagemProdPrefixo[0] . '_';
                            $ImagemProdPrefixo .= $vetImagemProdPrefixo[1] . '_';
                            $ImagemProdPrefixo .= $vetImagemProdPrefixo[2] . '_';

                            $vlTD .= ArquivoLink($path, $row[$Campo], $ImagemProdPrefixo, '', '', true);
                            break;

                        case 'link':
                            $stx = "<span style='color:#0080C0; text-decoration:none;'>";
                            $stx .= "<a href='$row[$Campo]' target='_blank' style='font-size:13px; font-weight: bold; cursor:pointer; color:#0080C0; text-decoration:none;'>" . $row[$Campo] . "</a>";
                            $stx .= "</span>";
                            $vlTD .= $stx;
                            break;


                        case 'func_trata_dado':
                            $vlTD .= $Valor['vetDominio']($row[$Campo], $row, $Campo);
                            break;

                        default:
                            $vlTD .= $row[$Campo];
                            break;
                    }

                    if ($Valor['lintot']) {
                        $temTot = true;
                        $vetTot[$Campo] += $row[$Campo];
                    }
                }

                $html .= "<td {$td_style} {$extra_attr} {$Colspan} {$data_campo} {$data_id} class='td_acao Registro " . $Valor['classer'] . "'  >\n";
                $Colspan = '';

                $html .= $ancora;
                $ancora = '';

                $html .= "$vlTD</td>\n";
            }

            $fotolinha++;

            if (++$numfoto == $num_col_tab) {
                if ($i != $fim - 1) {
                    $html .= "</tr>\n";
                }

                if ($i < $fim - 1) {
                    $trid = $trid + 1;
                    $html .= "<tr id=tr_l_" . $trid . " class='Registro' title='{$clique_hint_linha}' align=left" . '>' . nl();
                }

                $fotolinha = 0;
                $numfoto = 0;
            }
        }

        for ($i = $fotolinha; ($i < $num_col_tab && $i > 0); $i++) {
            $Colspan = "";
            if ($tab_edit) {
                $html .= "<td class='Titulo'>&nbsp;</td>\n";
            } else
                $Colspan = "colspan='2'";

            ForEach ($vetCampo as $strCampo => $Valor) {
                $html .= "<td $Colspan class='Registro'>&nbsp;</td>\n";
            }
        }

        $html .= "</tr>\n";
    }

    $html .= "</tbody>\n";

    if ($extra_pagina || $temTot) {
        $html .= "<tfoot>\n";

        if ($temTot) {
            $html .= "<tr class='Generica'>";

            $totColspan = 0;

            ForEach ($vetCampo as $strCampo => $Valor) {
                if ($Valor['lintot']) {
                    break;
                } else {
                    $totColspan++;
                }
            }

            $restaTDtot = $totColspan;

            if ($tab_edit) {
                $totColspan += 2;
                $html .= "<td class='Titulo_r' style='text-align: right;' colspan='{$totColspan}'>Total:&nbsp;</td>\n";
            } else {
                if ($inc_html != '') {
                    $totColspan += 2;
                    $Colspan = "colspan='{$totColspan}'";
                }
            }

            ForEach ($vetCampo as $strCampo => $Valor) {
                if ($Valor['lintot']) {
                    $strCampo = explode(", ", $strCampo);
                    $vlTD = '';

                    ForEach ($strCampo as $idx => $Campo) {
                        $vlTD = format_decimal($vetTot[$Campo], $Valor['ndecimal']);
                    }

                    $Colspan = '';
                    $restaTDtot++;
                    $html .= "<td {$Colspan} class='Titulo_r'>$vlTD&nbsp;</td>\n";
                }
            }

            $restaTD = count($vetCampo) - $restaTDtot;

            if ($restaTD > 0) {
                for ($index = 0; $index < $restaTD; $index++) {
                    $html .= "<td class='Titulo_r'></td>\n";
                }
            }

            $html .= "</tr>\n";
        }

        if ($extra_pagina) {
            $html .= "<tr class='Generica ExtraPagina' align='center'><td class='Titulo_r'   colspan='" . (count($vetCampo) + $ajustacolspan) . "'> ";
            $html .= str_replace("#qt", $rs->rows, $contlinfim);
            $html .= "</td></tr>\n";
        }

        $html .= "</tfoot>\n";
    }

    $html .= "</table>\n";

    $html_final .= '<div>';
    $html_final .= $html;
    $html_final .= '</div>';

    $html_final .= "
    <script type=\"text/javascript\">
        $(document).ready(function () {
            tablesorterCTC('{$campo_frm}', []);
            
            var campo_obj = '#{$campo_frm}_desc ';
            var comcontrole = '{$comcontrole}';

            $(campo_obj).on('click', 'td.td_acao', function () {
                if ($.isFunction(self.{$lista_td_acao_click})) {
                    var id = $(this).data('id');
                    var campo = $(this).data('campo');

                    {$lista_td_acao_click}(id, campo, $(this));
                }
            });

            $(campo_obj).on('click', 'td.td_cab_acao', function () {
                if ($.isFunction(self.{$lista_td_cab_acao_click})) {
                    var campo = $(this).data('campo');

                    {$lista_td_cab_acao_click}(campo, $(this));
                }
            });

            $(campo_obj).on('click', 'td.Titulo_ctl > span.esconde', function () {
                if ($(this).text() == '+') {
                    $(this).text('-');
                    $(this).parent().find('a.esconde').show();
                } else {
                    $(this).text('+');
                    $(this).parent().find('a.esconde').hide();
                }
            });
            
            $(campo_obj).on('click', 'td.acao_fecha', function () {
                $(campo_obj + '.Titulo_ctl').each(function () {
                    $(this).toggle();
                });

                $(campo_obj + '.Titulo_radio').each(function () {
                    $(this).toggle();
                });

                return false;
            });
            
            if (comcontrole == '0') {
                $(campo_obj + 'td.acao_fecha:first').click();
            }
        });
    </script>
    ";

    if ($ajax) {
        return $html;
    } else {
        return $html_final;
    }
}

function LinkGrid($ico, $txt, $return = false) {
    global $vetConf;

    switch ($vetConf['ico_texto']) {
        case 'IT':
            $r = $ico . $txt;
            break;

        case 'ST':
            $r = $txt;
            break;

        default: //SI
            $r = $ico;
            break;
    }

    if ($return) {
        return "<div>$r</div>";
    } else {
        echo "<div>$r</div>";
    }
}

function CriaVetTabela($nome, $tipo = '', $vetDominio = '', $tabela = '', $classet_par = '', $ndecimal = '2', $classer_par = '', $lintot = false) {
    global $classet, $classer;

    $vet = Array();

    $vet['nome'] = $nome;
    $vet['tipo'] = $tipo;
    $vet['vetDominio'] = $vetDominio;
    $vet['tabela'] = $tabela;
    $vet['classet'] = $classet . ' ' . $classet_par;
    $vet['classer'] = $classer . ' ' . $classer_par;

    $vet['ndecimal'] = $ndecimal;
    $vet['lintot'] = $lintot;

    return $vet;
}

function vetCad($campo, $nome, $menu, $prefixo = 'listar', $mostrar = true, $imagem = 'imagens/desce.gif', $cond_campo = '', $cond_valor = '') {
    $vet = Array();

    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['menu'] = $menu;
    $vet['prefixo'] = $prefixo;
    $vet['mostrar'] = $mostrar;
    $vet['imagem'] = $imagem;
    $vet['cond_campo'] = $cond_campo;
    $vet['cond_valor'] = $cond_valor;

    return $vet;
}

function vetCadUp($campo, $nome, $menu, $descricao = '', $prefixo = 'listar', $imagem = 'imagens/sobe.gif') {
    $vet = Array();

    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['menu'] = $menu;
    $vet['descricao'] = $descricao;
    $vet['prefixo'] = $prefixo;
    $vet['imagem'] = $imagem;

    return $vet;
}

function vetCadGrupo($grupo, $mostrar = true, $imagem = 'imagens/desce.gif') {
    $vet = Array();

    $vet['grupo'] = $grupo;
    $vet['mostrar'] = $mostrar;
    $vet['imagem'] = $imagem;

    return $vet;
}

function vetBtBarra($menu, $descricao, $img_src, $onclick, $prefixo = '', $img_title = '', $class = '', $parametro = '', $target = '', $arq_conteudo = '') {
    $vet = Array();

    if ($img_title == '') {
        $img_title = $descricao;
    }

    $vet['menu'] = $menu;
    $vet['descricao'] = $descricao;
    $vet['onclick'] = $onclick;
    $vet['prefixo'] = $prefixo;
    $vet['img_src'] = $img_src;
    $vet['img_title'] = $img_title;
    $vet['class'] = $class;
    $vet['parametro'] = $parametro;
    $vet['target'] = $target;
    $vet['arq_conteudo'] = $arq_conteudo;

    return $vet;
}

function vetDesativa($campo, $valor = ',N', $igual_valor = true, $onLoadChange = true, $vlPadraoDesativa = '') {
    $vet = Array();

    $vet['campo'] = '#' . str_replace(',', ',#', $campo);
    $vet['valor'] = mb_strtolower($valor);
    $vet['igual_valor'] = $igual_valor;
    $vet['onLoadChange'] = $onLoadChange;
    $vet['vlPadraoDesativa'] = $vlPadraoDesativa;

    return $vet;
}

function vetAtivadoObr($campo, $valor = 'S', $igual_valor = true, $comp = '_desc') {
    $vet = Array();

    $vet['campo'] = $campo;
    $vet['obr'] = '#' . str_replace(',', $comp . ',#', $campo) . $comp;
    $vet['valor'] = mb_strtolower($valor);
    $vet['igual_valor'] = $igual_valor;

    return $vet;
}

function FimTela() {
    global $versao_site;

    echo '
                    </div>
                </div>
                <div id="rodape">&nbsp;<div>' . $versao_site . ' - ' . getdata(true, true, true) . '</div></div>
            </div>
        </center>
        </body>
        </html>
    ';
}

function onLoadPag($campo = '', $frm = 'frm', $voltar = 'bt_voltar', $tabGrd = 0) {
    echo "<script language=\"JavaScript\">\n";
    echo "function onLoadPag() {\n";

    if ($campo != '') {
        if ($frm == false) {
            echo "mudaTab({$tabGrd});\n";
            echo "abreFRM('" . $campo . "___Frame');\n";
            echo "fieldobj = document.getElementById('" . $campo . "___Frame');
                  if (!fieldobj.disabled)
				    setTimeout('fieldobj.contentWindow.focus()',200);";
        } else if ($frm == 'id') {
            echo "if ($('#$voltar').attr('id') == undefined) $('#$voltar').focus();";
        } else {
            echo "mudaTab({$tabGrd});\n";
            echo "abreFRM('" . $campo . "');\n";
            echo "if (document.forms.length > 0) {\n";
            echo "  if (document.$frm.$campo != undefined) {\n";
            echo "    if (!document.$frm.$campo.disabled) {\n";
            echo "	    document.$frm.$campo.focus();\n";
            echo "	} else {\n";
            echo "	    if ($('#$voltar').attr('id') == undefined) $('#$voltar').focus();\n";
            echo "	}\n";
            echo "}\n";
            echo "}\n";
        }
    }

    echo "}\n";
    echo "</script>\n";
}

function getParametro($NaoPegar = '', $post = true, $get = true) {
    $NaoPegar = explode(",", $NaoPegar);

    if ($post) {
        $cgi = $_POST;
        reset($cgi);

        while (list($key, $value) = each($cgi)) {
            if (!in_array($key, $NaoPegar)) {
                $query_string .= "&" . $key . "=" . $value;
                $NaoPegar[] = $key;
            }
        }
    }

    if ($get) {
        $cgi = $_GET;
        reset($cgi);

        while (list($key, $value) = each($cgi)) {
            if (!in_array($key, $NaoPegar))
                $query_string .= "&" . $key . "=" . $value;
            $NaoPegar[] = $key;
        }
    }

    return addslashes($query_string);
}

function vetBindParam($variable, $data_type = '', $length = null) {
    if ($data_type === '') {
        $data_type = PDO::PARAM_STR;
    }

    if ($variable === '') {
        switch ($data_type) {
            case PDO::PARAM_INT:
                $variable = 0;
                break;

            default:
                $variable = '';
                break;
        }
    }

    $vet = Array();
    $vet['variable'] = $variable;
    $vet['data_type'] = $data_type;
    $vet['length'] = $length;

    return $vet;
}

function fetchAll($rs, $fetch_style) {
    try {
        return $rs->fetchAll($fetch_style);
    } catch (Exception $e) {
        if ($e->errorInfo[0] == 'IMSSP' && $e->errorInfo[1] == -15 && $e->errorInfo[2] == 'The active result for the query contains no fields.') {
            $rs->nextRowset();
            return fetchAll($rs, $fetch_style);
        } else {
            throw new Exception($e->getMessage());
        }
    }
}

function execsqlNomeCol($sql, $trata_erro = true, $outra_con = null, $vetBindParam = Array()) {
    return execsql($sql, $trata_erro, $outra_con, $vetBindParam, PDO::FETCH_ASSOC);
}

function execsql($sql, $trata_erro = true, $outra_con = null, $vetBindParam = Array(), $fetch_style = PDO::FETCH_BOTH) {
    global $con, $vetMsgErro, $vetMsgErroPersonalizado, $debug, $pre_table;

    if (is_null($outra_con)) {
        $tcon = $con;
    } else {
        $tcon = $outra_con;
    }

    $tipodb = $tcon->getAttribute(PDO::ATTR_DRIVER_NAME);

    $sql = trim($sql);

    if ($tipodb == 'mssql' || $tipodb == 'sqlsrv') {
        $sql = str_replace('now()', 'dbo.now()', $sql);
        $sql = str_replace(' for update', '', $sql);
        $sql = str_replace(' FOR UPDATE', '', $sql);
    }

    $sql_top = false;
    if (mb_strtolower(substr($sql, 0, 6)) == 'select') {
        if ($tipodb == 'mssql' || $tipodb == 'sqlsrv') {
            $i = strpos($sql, ' limit ');
            if ($i !== FALSE) {
                $limit = substr($sql, $i + 7);
                $sql = substr($sql, 0, $i);
                $sql = substr($sql, 7);
                $sql = trim($sql);

                if (substr($sql, 0, 8) == 'distinct') {
                    $sql = substr($sql, 9);
                    $sql = 'select distinct top ' . $limit . ' ' . $sql;
                } else {
                    $sql = 'select top ' . $limit . ' ' . $sql;
                }

                $sql_top = true;
            }
        }
    }

    unset($rs);

    if ($trata_erro) {
        try {
            if (count($vetBindParam) > 0 || $vetBindParam === true) {
                $vetTmpParam = Array();
                $sql_exec = 'execute ';

                if ($vetBindParam === true) {
                    $sql_exec .= $sql;
                    $rs = $tcon->prepare($sql_exec);
                } else {
                    foreach ($vetBindParam as $key => $vetParam) {
                        $vetTmpParam[] = ':' . $key;
                    }

                    $sql_exec .= $sql . ' ';
                    $sql_exec .= implode(', ', $vetTmpParam);

                    $rs = $tcon->prepare($sql_exec);

                    $vetValue = Array();
                    foreach ($vetBindParam as $key => $vetParam) {
                        $rs->bindParam(':' . $key, $vetBindParam[$key]['variable'], $vetParam['data_type'], $vetParam['length']);
                    }
                }

                $rs->execute();

                $dbx = new dbx;

                if ($tipodb == 'mssql') {
                    $tcon->exec('BEGIN TRANSACTION TIPO');

                    if (!$sql_top) {
                        if (strpos($sql, ' distinct ') !== FALSE) {
                            $sql = str_replace("select distinct", "select distinct top 100 percent", $sql);
                        } else {
                            $sql = str_replace("select", "select top 100 percent", $sql);
                        }
                    }

                    $tcon->exec('create view tmp_' . md5($sql) . ' as ' . $sql);

                    $sql_meta = "select column_name as name, data_type as native_type from information_schema.columns
                  where table_name = 'tmp_" . md5($sql) . "' order by ordinal_position";
                    unset($rs_meta);
                    $rs_meta = $tcon->query($sql_meta);

                    $vet_meta = $rs_meta->fetchAll($fetch_style);
                    $totColuna = count($vet_meta);

                    $tcon->query('drop view tmp_' . md5($sql));

                    $tcon->exec('COMMIT TRANSACTION TIPO');
                } else {
                    $totColuna = $rs->columnCount();
                }

                for ($i = 0; $i < $totColuna; $i++) {
                    if ($tipodb == 'mssql') {
                        $meta = $vet_meta[$i];
                    } else if ($tipodb == 'oci') {
                        $meta = Array();
                    } else {
                        $meta = $rs->getColumnMeta($i);
                    }

                    if ($tipodb == 'sqlsrv') {
                        $native_type = $meta['sqlsrv:decl_type'];

                        switch ($native_type) {
                            case 'int identity':
                                $native_type = 'int';
                                break;

                            case 'nvarchar':
                                $native_type = 'varchar';
                                break;

                            case 'datetime2':
                                $native_type = 'datetime';
                                break;
                        }
                    } else {
                        $native_type = $meta['native_type'];
                    }

                    $dbx->info['name'][$i] = mb_strtolower($meta['name']);
                    $dbx->info['type'][mb_strtolower($meta['name'])] = mb_strtolower($native_type);
                    $dbx->info['type'][$i] = mb_strtolower($native_type);
                }

                $dbx->data = fetchAll($rs, $fetch_style);

                $dbx->cols = count($dbx->info['name']);
                $dbx->rows = count($dbx->data);

                return $dbx;
            } else if (mb_strtolower(substr($sql, 0, 6)) == 'select') {
                unset($rs);
                $rs = $tcon->query($sql);

                $dbx = new dbx;

                if ($tipodb == 'mssql') {
                    $tcon->exec('BEGIN TRANSACTION TIPO');

                    if (!$sql_top) {
                        if (strpos($sql, ' distinct ') !== FALSE) {
                            $sql = str_replace("select distinct", "select distinct top 100 percent", $sql);
                        } else {
                            $sql = str_replace("select", "select top 100 percent", $sql);
                        }
                    }

                    $tcon->exec('create view tmp_' . md5($sql) . ' as ' . $sql);

                    $sql_meta = "select column_name as name, data_type as native_type from information_schema.columns
                                 where table_name = 'tmp_" . md5($sql) . "' order by ordinal_position";
                    unset($rs_meta);
                    $rs_meta = $tcon->query($sql_meta);

                    $vet_meta = $rs_meta->fetchAll($fetch_style);
                    $totColuna = count($vet_meta);

                    $tcon->query('drop view tmp_' . md5($sql));

                    $tcon->exec('COMMIT TRANSACTION TIPO');
                } else {
                    $totColuna = $rs->columnCount();
                }

                for ($i = 0; $i < $totColuna; $i++) {
                    if ($tipodb == 'mssql') {
                        $meta = $vet_meta[$i];
                    } else if ($tipodb == 'oci') {
                        $meta = Array();
                    } else {
                        $meta = $rs->getColumnMeta($i);
                    }

                    if ($tipodb == 'sqlsrv') {
                        $native_type = $meta['sqlsrv:decl_type'];

                        switch ($native_type) {
                            case 'int identity':
                                $native_type = 'int';
                                break;

                            case 'nvarchar':
                                $native_type = 'varchar';
                                break;

                            case 'datetime2':
                                $native_type = 'datetime';
                                break;
                        }
                    } else {
                        $native_type = $meta['native_type'];
                    }

                    $dbx->info['name'][$i] = mb_strtolower($meta['name']);
                    $dbx->info['type'][mb_strtolower($meta['name'])] = mb_strtolower($native_type);
                    $dbx->info['type'][$i] = mb_strtolower($native_type);
                }

                $dbx->data = $rs->fetchAll($fetch_style);

                $dbx->cols = count($dbx->info['name']);
                $dbx->rows = count($dbx->data);

                return $dbx;
            } else {
                return $tcon->exec($sql);
            }
        } catch (PDOException $e) {

            $nom_tela = '';
            $inf_extra = '';
            $vetParametros = Array();

            $msg = grava_erro_log($tipodb, $e, $sql, $nom_tela, $inf_extra, $vetParametros);


            $img_alerta = "imagens/bola_amarela.png";
            $img_grave = "imagens/bola_vermelha.png";
            $img_informa = "imagens/bola_verde.png";
            $msgbackground = "#F1F1F1";
            $msgcolor = "#000000";
            $msgborder = "#C0C0C0";
            $img = $img_alerta;
            $gravidade = "";


            $gravidade = $vetParametros['gavidade'];
            if ($gravidade == "") {
                $gravidade = "Grave";
            }
            $detalhe = $vetParametros['detalhe'];


            if ($gravidade == "Informa") {
                $img = $img_informa;
                $msgimg = "ATENÇÃO!";
                $msgbackground = "#FFFFFF";
                $msgcolor = "#666666";
                $msgborder = "#C0C0C0";
            }

            if ($gravidade == "Alerta") {
                $img = $img_alerta;
                $msgimg = "ATENÇÃO!";
                $msgbackground = "#FFFFFF";
                $msgcolor = "#666666";
                $msgborder = "#C0C0C0";
            }

            if ($gravidade == "Grave") {
                $img = $img_grave;
                $msgimg = "ERRO GRAVE!<br />INFORMAR IMEDIATAMENTE AO ADMINISTRADOR DO SISTEMA.";
                $msgbackground = "#FFFFFF";
                $msgcolor = "#666666";
                $msgborder = "#C0C0C0";
            }

            //echo "<div align='center' class='Msg' style='font-size:18px; background:#FFFFFF color:#FF0000; '>".$msg."\n";
            echo "<div 	id='parte_usuariot' class='Msg' style='font-weight:normal; padding-top:10px; text-align:center;   border-radius: 0.4em; font-size:15px; border:1px solid {$msgborder}; background:{$msgbackground}; color:{$msgcolor}; '>";
            $explicamsg = "";
            //$explicamsg  .= "<div style='float:left;'>";
            $explicamsg .= "<img width='32' height='32' src='{$img}' style='padding-top:5px; padding-right:5px;' title=''/>";
            //$explicamsg  .= "</div>";
            //$explicamsg  .= "<div style='float:left;  padding-left:10px;'>";
            $explicamsg .= "{$msgimg}<BR />";
            $explicamsg .= getdata(true, true, true) . "<BR />";

            //$explicamsg  .= "</div>";
            echo "<div 	id='parte_usuario' class='' style='text-align:center;   font-size:15px;  background:{$msgbackground}; color:{$msgcolor}; '>";

            echo "<div style='display:block; width:100%; text-align:center; padding-bottom:10px;'>";

            echo $explicamsg;
            echo "</div>";

            echo "<div  style='display:block; width:100%;'>";
            echo $msg;
            echo "</div>";

            echo "</div>";


            echo '<br><br>';
            echo '<script>';
            echo 'function ImprimeDiv(iddiv) ';
            echo ' { ';

            //echo " var idb = document.getElementById('msg_botao');  ";
            //echo " $(idb).hide();  ";
            echo " var cab = ''; ";
            echo " cab = cab+'<title>CRM|Sebrae-Ba [Mensagem]</title>'; ";


            echo " cab = cab+'<div>'; ";
            echo " cab = cab+'CRM|Sebrae-Ba'; ";
            echo " cab = cab+'</div>'; ";

            echo " var conteudo = document.getElementById(iddiv).innerHTML;  ";
            echo " var conteudo2 = document.getElementById('msg_detalhe').innerHTML;  ";
            echo " conteudo = cab + conteudo + conteudo2; ";
            //echo " tela_impressao = window.open('about:blank');  ";
            echo " tela_impressao = window.open('');  ";

            echo " tela_impressao.document.write(conteudo); ";
            echo " tela_impressao.window.print(); ";
            //	echo " var idb = document.getElementById('msg_botao');  ";
            // echo " $(idb).show();  ";
            echo " tela_impressao.window.close(); ";
            echo " return false; ";
            echo ' } ';
            echo '</script>';

            echo '<input type="button" style="border-radius: 0.4em; width:10em; " name="btnAcao" class="Botao" value=" Voltar " onClick="history.go(-1)">';
            echo '<input type="button" style="border-radius: 0.4em; width:10em; margin-left:1em; " name="btnAcao" class="Botao" value=" Detalhar mensagem " onClick=" $(' . "'" . '#msg_detalhe' . "'" . ').toggle(); TelaHeight();">';

            if ($gravidade == "Grave") {
                echo '<input type="button" style="border-radius: 0.4em; width:10em; margin-left:1em; " name="btnAcao" class="Botao" value=" Comunicar Problema " onClick=" ">';
            }

            if ($debug) {
                echo '<input type="button" style="border-radius: 0.4em; width:10em; margin-left:1em; " name="btnAcao" class="Botao" value=" Mostrar Debug " onClick=" $(' . "'" . '#msg_debug' . "'" . ').toggle(); TelaHeight();">';
            }

            echo '<input type="button" style="border-radius: 0.4em; width:10em; margin-left:1em; " name="btnAcao" class="Botao" value=" Imprime " onClick=" return ImprimeDiv(' . "'" . 'parte_usuario' . "'" . '); ">';
            echo '<br><br>';
            echo '</div>';
            echo "<div id='msg_detalhe' style='display:none; width:100%;'>";
            echo "<div style='font-size:18px; border-radius: 0.4em; border:1px solid {$msgborder}; text-align:center; background:#0000FF; color:#FFFFFF; width:100%; display:block'>";
            echo " Explicação detalhada da mensagem";
            echo "</div>";
            echo "<div style='border-radius: 0.4em; border:1px solid {$msgborder}; text-align:left; padding:1em; background:#FFFFFF; color:#333333; width:100%; display:block'>";
            echo $detalhe;
            echo '</div>';
            echo '</div>';


            if ($debug) {
                echo "<div id='msg_debug' class='' style='display:none; text-align:center; border-radius: 0.4em; border:1px solid #C0C0C0; background:#F1F1F1; color:#FF0000; '>";
                echo "<div style='text-align:center; width:100%; display:block; border-radius: 0.4em; border:1px solid #C0C0C0;'>";
                $explicamsg = "";
                $explicamsg .= "ATENÇÃO!<BR />";
                $explicamsg .= "O Sistema esta em MODO de depuração e por isso, ";
                $explicamsg .= "apresenta a mensagem abaixo em tela ";
                $explicamsg .= "que serve exclusivamente para que o pessoal Técnico possa entender o problema.<br />";
                $explicamsg .= "NO AMBIENTE DE PRODUÇÃO O SISTEMA NÃO FICA EM MODO DE DEPURAÇÃO E ESSA MENSAGEM NÃO APARECE.<br />";
                echo $explicamsg;
                echo '</div>';
                echo "<div style='text-align:left; background:#FFFFFF; color:#000000; '>";
                p($vetParametros);
                p($e);
                echo '</div>';
                echo '</div>';
            }

            onLoadPag();
            FimTela();
            exit();
        }
    } else {
        if (count($vetBindParam) > 0 || $vetBindParam === true) {
            $vetTmpParam = Array();
            $sql_exec = 'execute ';

            if ($vetBindParam === true) {
                $sql_exec .= $sql;
                $rs = $tcon->prepare($sql_exec);
            } else {
                foreach ($vetBindParam as $key => $vetParam) {
                    $vetTmpParam[] = ':' . $key;
                }

                $sql_exec .= $sql . ' ';
                $sql_exec .= implode(', ', $vetTmpParam);

                $rs = $tcon->prepare($sql_exec);

                $vetValue = Array();
                foreach ($vetBindParam as $key => $vetParam) {
                    $rs->bindParam(':' . $key, $vetBindParam[$key]['variable'], $vetParam['data_type'], $vetParam['length']);
                }
            }

            $rs->execute();

            $dbx = new dbx;

            if ($tipodb == 'mssql') {
                $tcon->exec('BEGIN TRANSACTION TIPO');

                if (!$sql_top) {
                    if (strpos($sql, ' distinct ') !== FALSE) {
                        $sql = str_replace("select distinct", "select distinct top 100 percent", $sql);
                    } else {
                        $sql = str_replace("select", "select top 100 percent", $sql);
                    }
                }

                $tcon->exec('create view tmp_' . md5($sql) . ' as ' . $sql);

                $sql_meta = "select column_name as name, data_type as native_type from information_schema.columns
                  where table_name = 'tmp_" . md5($sql) . "' order by ordinal_position";
                unset($rs_meta);
                $rs_meta = $tcon->query($sql_meta);

                $vet_meta = $rs_meta->fetchAll($fetch_style);
                $totColuna = count($vet_meta);

                $tcon->query('drop view tmp_' . md5($sql));

                $tcon->exec('COMMIT TRANSACTION TIPO');
            } else {
                $totColuna = $rs->columnCount();
            }

            for ($i = 0; $i < $totColuna; $i++) {
                if ($tipodb == 'mssql') {
                    $meta = $vet_meta[$i];
                } else if ($tipodb == 'oci') {
                    $meta = Array();
                } else {
                    $meta = $rs->getColumnMeta($i);
                }

                if ($tipodb == 'sqlsrv') {
                    $native_type = $meta['sqlsrv:decl_type'];

                    switch ($native_type) {
                        case 'int identity':
                            $native_type = 'int';
                            break;

                        case 'nvarchar':
                            $native_type = 'varchar';
                            break;

                        case 'datetime2':
                            $native_type = 'datetime';
                            break;
                    }
                } else {
                    $native_type = $meta['native_type'];
                }

                $dbx->info['name'][$i] = mb_strtolower($meta['name']);
                $dbx->info['type'][mb_strtolower($meta['name'])] = mb_strtolower($native_type);
                $dbx->info['type'][$i] = mb_strtolower($native_type);
            }

            $dbx->data = fetchAll($rs, $fetch_style);

            $dbx->cols = count($dbx->info['name']);
            $dbx->rows = count($dbx->data);

            return $dbx;
        } else if (mb_strtolower(substr($sql, 0, 6)) == 'select') {
            unset($rs);
            $rs = $tcon->query($sql);

            $dbx = new dbx;

            if ($tipodb == 'mssql') {
                $tcon->exec('BEGIN TRANSACTION TIPO');

                if (!$sql_top) {
                    if (strpos($sql, ' distinct ') !== FALSE) {
                        $sql = str_replace("select distinct", "select distinct top 100 percent", $sql);
                    } else {
                        $sql = str_replace("select", "select top 100 percent", $sql);
                    }
                }

                $tcon->exec('create view tmp_' . md5($sql) . ' as ' . $sql);

                $sql_meta = "select column_name as name, data_type as native_type from information_schema.columns
                                 where table_name = 'tmp_" . md5($sql) . "' order by ordinal_position";
                unset($rs_meta);
                $rs_meta = $tcon->query($sql_meta);

                $vet_meta = $rs_meta->fetchAll($fetch_style);
                $totColuna = count($vet_meta);

                $tcon->query('drop view tmp_' . md5($sql));

                $tcon->exec('COMMIT TRANSACTION TIPO');
            } else {
                $totColuna = $rs->columnCount();
            }

            for ($i = 0; $i < $totColuna; $i++) {
                if ($tipodb == 'mssql') {
                    $meta = $vet_meta[$i];
                } else if ($tipodb == 'oci') {
                    $meta = Array();
                } else {
                    $meta = $rs->getColumnMeta($i);
                }

                if ($tipodb == 'sqlsrv') {
                    $native_type = $meta['sqlsrv:decl_type'];

                    switch ($native_type) {
                        case 'int identity':
                            $native_type = 'int';
                            break;

                        case 'nvarchar':
                            $native_type = 'varchar';
                            break;

                        case 'datetime2':
                            $native_type = 'datetime';
                            break;
                    }
                } else {
                    $native_type = $meta['native_type'];
                }

                $dbx->info['name'][$i] = mb_strtolower($meta['name']);
                $dbx->info['type'][mb_strtolower($meta['name'])] = mb_strtolower($native_type);
                $dbx->info['type'][$i] = mb_strtolower($native_type);
            }

            $dbx->data = $rs->fetchAll($fetch_style);

            $dbx->cols = count($dbx->info['name']);
            $dbx->rows = count($dbx->data);

            return $dbx;
        } else {
            return $tcon->exec($sql);
        }
    }
}

function trataGravaPOST() {
    $localPOST = $_POST;

    if ($localPOST['senha'] != '') {
        $localPOST['senha'] = '*****';
    }

    if (count($localPOST) == 0) {
        $localPOST = '';
    }

    return $localPOST;
}

function trataGravaSESSION() {
    $localSESSION = $_SESSION[CS];

    if ($localSESSION['g_s_slv'] != '') {
        $localSESSION['g_s_slv'] = '*****';
    }

    if ($localSESSION['g_senha_antiga'] != '') {
        $localSESSION['g_senha_antiga'] = '*****';
    }

    unset($localSESSION['g_vetConf']);
    unset($localSESSION['g_vetConfJS']);
    unset($localSESSION['g_vetMenu']);
    unset($localSESSION['g_vetMigalha']);
    unset($localSESSION['g_vetDireito']);
    unset($localSESSION['g_vetMime']);
    unset($localSESSION['g_vetMimeJS']);
    unset($localSESSION['g_strMenuJS']);
    unset($localSESSION['objListarConf']);
    unset($localSESSION['objListarConf_vetID']);
    unset($localSESSION['tmp']);
    unset($localSESSION['g_menu_bia']);
    unset($localSESSION['objListarCmbMulti']);
    unset($localSESSION['g_vetEventoSituacao']);

    return $localSESSION;
}

function grava_erro_log($origem_msg, $obj, $sql_execute, $nom_tela = '', $inf_extra = '', &$idt_erro_log = '') {
    global $host, $bd_user, $password, $tipodb, $pre_table, $vetMsgErro, $vetMsgErroPersonalizado, $plu_sigla_interna, $vetConf, $menu;

    $con = new_pdo($host, $bd_user, $password, $tipodb);

    if ($nom_tela == '') {
        $nom_tela = $VetMenu[$menu];

        if ($nom_tela == '') {
            $nom_tela = $_SESSION[CS]['g_nom_tela'];
        }
    }

    $dt = getdata(true, false, true);

    if (!is_array($vetMsgErro)) {
        $vetMsgErro = Array();
    }

    if (!is_array($vetMsgErroPersonalizado)) {
        $vetMsgErroPersonalizado = Array();
    }

    $cod = $obj->getCode() . '.' . substr(trim($sql_execute), 0, 1);

    $localPOST = trataGravaPOST();
    $localSESSION = trataGravaSESSION();

    $sql = 'insert into ' . $pre_table . 'plu_erro_log (data, login, nom_usuario,
            ip_usuario, nom_tela, origem_msg,
            num_erro, mensagem, objeto,
            vget, vpost,
            vserver, vsession,
            inf_extra, vfiles
            ) values (' .
            aspa($dt) . ', ' . aspa($_SESSION[CS]['g_login']) . ', ' . aspa($_SESSION[CS]['g_nome_completo']) . ', ' .
            aspa($_SERVER['REMOTE_ADDR']) . ', ' . aspa($nom_tela) . ', ' . aspa($origem_msg) . ', ' .
            aspa($cod) . ', ' . aspa($obj->getMessage()) . ', ' . aspa(base64_encode(serialize(print_r($obj, true)))) . ', ' .
            aspa(base64_encode(serialize(print_r($_GET, true)))) . ', ' . aspa(base64_encode(serialize(print_r($localPOST, true)))) . ', ' .
            aspa(base64_encode(serialize(print_r($_SERVER, true)))) . ', ' . aspa(base64_encode(serialize(print_r($localSESSION, true)))) . ',' .
            aspa(base64_encode(serialize(print_r($inf_extra, true)))) . ', ' . aspa(base64_encode(serialize(print_r($_FILES, true)))) . ')';
    $con->exec($sql);

    $idt_erro_log = lastInsertId('', $con);
    $vetParametros['idt_log'] = $idt_erro_log;

    $sql = 'select * from ' . $pre_table . 'plu_erro_msg where origem_msg = ' . aspa($origem_msg);

    if ($cod == '') {
        $sql .= ' and num_erro is null';
    } else {
        $sql .= ' and num_erro = ' . aspa($cod);
    }

    unset($rs);
    $rs = $con->query($sql);
    $row = $rs->fetchAll(PDO::FETCH_BOTH);
    $row = $row[0];

    if ($row['idt'] == '') {
        $sql = 'insert into ' . $pre_table . 'plu_erro_msg (data, origem_msg, num_erro,
                msg_erro, msg_usuario
                ) values (' .
                aspa($dt) . ', ' . aspa($origem_msg) . ', ' . aspa($cod) . ', ' .
                aspa($obj->getMessage()) . ', ' . aspa($obj->getMessage()) . ')';
        $con->exec($sql);

        $msg = $obj->getMessage();
    } else {
        $sql = 'update ' . $pre_table . 'plu_erro_msg set data = ' . aspa($dt) . ',
                msg_erro = ' . aspa($obj->getMessage()) . '
                where idt = ' . $row['idt'];
        $con->exec($sql);

        $msg = $row['msg_usuario'];


        $vetParametros['gavidade'] = $row['gravidade'];
        $vetParametros['detalhe'] = $row['detalhe'];
        $vetParametros['numero_erro'] = $cod;



        if ($vetMsgErro[$cod] == '') {
            switch ($cod) {
                case '23000.d':
                    $vetMsgErro[$cod] = 'registros';
                    break;

                case '23000.i':
                    $vetMsgErro[$cod] = 'o registro';
                    break;

                case '23000.u':
                    $vetMsgErro[$cod] = 'registro';
                    break;
            }
        }

        if ($vetMsgErro[$cod] != '') {
            $msg = str_replace("%{$cod}%", $vetMsgErro[$cod], $msg);
        }
    }

    if ($vetMsgErroPersonalizado[$cod] != '') {
        $msg = $vetMsgErroPersonalizado[$cod];
    }

    if ($vetConf['email_logerro'] != '' && $origem_msg != 'ldap' && $origem_msg != 'timeout') {
        $assunto = '[' . $plu_sigla_interna . '] ERRO: ' . $obj->getMessage();

        $mensagem = '';
        $mensagem .= 'Data: ' . $dt . '<br />';
        $mensagem .= 'Login: ' . $_SESSION[CS]['g_login'] . '<br />';
        $mensagem .= 'Usuario: ' . $_SESSION[CS]['g_nome_completo'] . '<br />';
        $mensagem .= 'IP Usuario: ' . $_SERVER['REMOTE_ADDR'] . '<br />';
        $mensagem .= 'Nome da Tela: ' . $nom_tela . '<br />';
        $mensagem .= 'Origem do Erro: ' . $origem_msg . '<br />';
        $mensagem .= 'Numero do Erro: ' . $cod . '<br /><br />';
        $mensagem .= 'Erro: <pre>' . print_r($obj, true) . '</pre><br /><br />';
        //$mensagem .= '$_GET: <pre>'.print_r($_GET, true).'</pre><br /><br />';
        //$mensagem .= '$_POST: <pre>'.print_r($localPOST, true).'</pre><br /><br />';
        //$mensagem .= '$_SERVER: <pre>'.print_r($_SERVER, true).'</pre><br /><br />';
        //$mensagem .= '$_SESSION: <pre>'.print_r($localSESSION, true).'</pre><br /><br />';
        //$mensagem .= '$inf_extra: <pre>'.print_r($inf_extra, true).'</pre><br /><br />';

        enviarEmail(db_pir_grc, $assunto, $mensagem, $vetConf['email_logerro'], '');
    }

    return $msg;
}

function msg_erro($msg) {
    echo "<div align='center' class='Msg'>Data do Erro: " . getdata(true, true, true) . '<br><br>' . conHTML10($msg) . "\n";
    echo '<br><br><input type="button" name="btnAcao" class="Botao" value=" Voltar " onClick="history.go(-1)"></div>';
    onLoadPag();
    FimTela();
    die();
}



function msg_CriticaConsiste(&$vetmsg) {
    $msg     = $vetmsg['msg'];
	$titulo  = $vetmsg['titulo'];
	$datadia = getdata(true, true, true);
	$htmlw= "";
	$htmlw .= "<style>";
	$htmlw .= " .CriticaConsiste {";
	$htmlw .= "     background:#F1F1F1; ";
	$htmlw .= "     color:#000000; ";
	$htmlw .= "     border: 1px solid #C0C0C0; ";
	//$htmlw .= "     padding: 10px; ";
	$htmlw .= "     width:100%; ";
	$htmlw .= " } ";
	$htmlw .= " .TituloCriticaConsiste {";
	$htmlw .= "     background:#2F66B8; ";
	$htmlw .= "     background:#CC3559; ";
	
	$htmlw .= "     color:#FFFFFF; ";
	$htmlw .= "     border-bottom: 1px solid #FFFFFF; ";
	$htmlw .= "     padding: 0px; ";
	$htmlw .= "     padding-top: 10px; ";
	$htmlw .= "     padding-bottom: 10px; ";
	$htmlw .= "     width:100%; ";
	$htmlw .= "     font-size:1.5em; ";
	$htmlw .= " } ";
	
	$htmlw .= " .RodapeCriticaConsiste {";
	$htmlw .= "     background:#C4C9CD; ";
	$htmlw .= "     color:#FFFFFF; ";
	$htmlw .= "     border-bottom: 1px solid #000000; ";
	$htmlw .= "     padding: 0px; ";
	$htmlw .= "     padding-top: 5px; ";
	$htmlw .= "     padding-bottom: 5px; ";
	$htmlw .= "     width:100%; ";
	$htmlw .= "     font-size:1.5em; ";
	$htmlw .= " } ";
	
	
	
	$htmlw .= "</style>";
	
    $htmlw .= "<div align='center' class='CriticaConsiste'>";
	
	
    $htmlw .= "<div align='center' class='TituloCriticaConsiste'>";
	$htmlw .= $titulo;
	$htmlw .= "</div>";
	
	//Data do Erro: " . getdata(true, true, true) . '<br><br>' . conHTML10($msg) . "\n";
	$htmlw .=  $msg; 
	
	
	// Botão de Voltar
    $htmlw .= "<div align='center' class='RodapeCriticaConsiste'>";
	$hint   = "Clique para retornar a tela de Cadastro";
	$htmlw .= "<input title= '{$hint}' type='button' name='btnAcao' class='Botao' value=' Voltar ' onClick='history.go(-1)'>";
	$htmlw .= "</div>";
	
	$htmlw .= '</div>';
	
	echo $htmlw;
	
	//alert($htmlw,'S');
	
	// Fecha Pagina
    onLoadPag();
    FimTela();
    die();
}






function camposObrigatorios($variaveis, $msg = true) {
    echo "<script language=\"JavaScript\">\n";
    echo "function $variaveis[0]Fcn() {\n";
    echo "if (valida_cust != '') {\n";
    echo "  valida = valida_cust;";
    echo "}\n";

    echo "if (valida == 'S') {\n";
    for ($contador = 1; $contador < count($variaveis); $contador = $contador + 2) {
        $contadorMaisUm = $contador + 1;
        echo "  if (document.$variaveis[0].$variaveis[$contador].type == 'checkbox') {\n";
        echo "     if (!document.$variaveis[0].$variaveis[$contador].checked) {\n";
        echo "        alert('Favor preencher o campo: $variaveis[$contadorMaisUm]');\n";
        echo "        if (document.$variaveis[0].$variaveis[$contador].type != 'hidden')\n";
        echo "           document.$variaveis[0].$variaveis[$contador].focus();\n";
        echo "        return false;\n";
        echo "     }\n";
        echo "  } else {\n";
        echo "  if (document.$variaveis[0].$variaveis[$contador].value=='') {\n";
        echo "          alert('Favor preencher o campo: $variaveis[$contadorMaisUm]');\n";
        echo "          if (document.$variaveis[0].$variaveis[$contador].type != 'hidden')\n";
        echo "              document.$variaveis[0].$variaveis[$contador].focus();\n";
        echo "          return false;\n";
        echo "          }\n";
        echo "  }\n";
    } // next do for
    echo "}\n";

    if ($msg) {
        echo "      if (confirm('Deseja realmente confirmar essa operação?')) {\n";
        echo "          return true;\n";
        echo "      } else {\n";
        echo "          return false;\n";
        echo "      }\n";
    } else {
        echo "return true;\n";
    }

    echo "  }\n";
    echo "</script>\n";
}

function camposObrigatorios_login($variaveis, $msg = true) {
    echo "<script language=\"JavaScript\">\n";
    echo "function $variaveis[0]Fcn() {\n";
    echo "if (valida_cust != '') {\n";
    echo "  valida = valida_cust;";
    echo "}\n";

    echo "if (valida == 'S') {\n";
    for ($contador = 1; $contador < count($variaveis); $contador = $contador + 2) {
        $contadorMaisUm = $contador + 1;
        echo "  if (document.$variaveis[0].$variaveis[$contador].value=='') {\n";
//echo "          alert('Favor preencher o campo: $variaveis[$contadorMaisUm]');\n";
        echo "          ativa_msg_login('Favor preencher o campo: $variaveis[$contadorMaisUm]');\n";
        echo "          if (document.$variaveis[0].$variaveis[$contador].type != 'hidden')\n";
        echo "              document.$variaveis[0].$variaveis[$contador].focus();\n";
        echo "          return false;\n";
        echo "          }\n";
    } // next do for
    echo "}\n";

    if ($msg) {
        echo "      if (confirm('Deseja realmente confirmar essa operação?')) {\n";
        echo "          return true;\n";
        echo "      } else {\n";
        echo "          return false;\n";
        echo "      }\n";
    } else {
        echo "return true;\n";
    }

    echo "  }\n";
    echo "</script>\n";
}

function camposObrigatoriosID($variaveis, $msg = true) {
    echo "<script language=\"JavaScript\">\n";
    echo "function $variaveis[0]Fcn() {\n";
    echo "if (valida_cust != '') {\n";
    echo "  valida = valida_cust;";
    echo "}\n";

    echo "if (valida == 'S') {\n";
    for ($contador = 1; $contador < count($variaveis); $contador = $contador + 2) {
        $contadorMaisUm = $contador + 1;
        echo "  var campo = document.getElementById('$variaveis[$contador]');\n";
        echo "  if (campo.value=='') {\n";
        echo "     alert('Favor preencher o campo: $variaveis[$contadorMaisUm]');\n";
        echo "     if (campo.type != 'hidden')\n";
        echo "        campo.focus();\n";
        echo "     return false;\n";
        echo "  }\n";
    } // next do for
    echo "}\n";

    if ($msg) {
        echo "      if (confirm('Deseja realmente confirmar essa operação?')) {\n";
        echo "          return true;\n";
        echo "      } else {\n";
        echo "          return false;\n";
        echo "      }\n";
    } else {
        echo "return true;\n";
    }

    echo "  }\n";
    echo "</script>\n";
}

function camposObrigatoriosTab($frm = 'frm') {
    global $vetCampoJS, $vetNomeJS, $vetGrdJS, $vetObrJS, $vetFocusJS;
    ?>
    <script type="text/javascript">
        function <?php echo $frm ?>Fcn() {
            if (valida_cust != '') {
                valida = valida_cust;
            }

            if (valida == 'S') {
                var campo;
                var jsCampo = "<?php echo implode("§@§", $vetCampoJS) ?>".split('§@§');
                var jsNome = "<?php echo implode("§@§", $vetNomeJS) ?>".split('§@§');
                var jsGrd = "<?php echo implode("§@§", $vetGrdJS) ?>".split('§@§');
                var jsObr = "<?php echo implode("§@§", $vetObrJS) ?>".split('§@§');
                var jsFocus = "<?php echo implode("§@§", $vetFocusJS) ?>".split('§@§');
                var DescNome = '';

                for (var i in jsCampo) {
                    var checa_visivel = true;

                    if (valida_nao_visivel == 'N') {
                        checa_visivel = $('#' + jsObr[i]).is(":visible");
                    }

                    if ($('#' + jsObr[i]).attr('class') == 'Tit_Campo_Obr' && checa_visivel) {
                        if ($('#' + jsCampo[i]).val() == '') {
                            mudaTab(jsGrd[i]);
                            abreFRM(jsCampo[i]);

                            DescNome = $('#' + jsCampo[i]).data('desc_per');

                            if (DescNome == '' || DescNome == undefined) {
                                DescNome = jsNome[i];
                            }

                            alert('Favor preencher o campo: ' + DescNome);
                            campo = $('#' + jsFocus[i]);

                            if (campo.attr('type') != 'hidden' && !campo.attr('disabled')) {
                                campo.focus();
                            }

                            return false;
                        }
                    }
                }
            }

            return true;
        }
    </script>
    <?php
}

function beginTransaction($outra_con = null) {
    global $con;

    if (is_null($outra_con))
        $tcon = $con;
    else
        $tcon = $outra_con;

    if ($tcon->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mssql') {
        execsql('BEGIN TRANSACTION', true, $tcon);
    } else {
        $tcon->beginTransaction();
    }
}

function commit($outra_con = null) {
    global $con;

    if (is_null($outra_con))
        $tcon = $con;
    else
        $tcon = $outra_con;

    if ($tcon->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mssql') {
        execsql('COMMIT TRANSACTION', true, $tcon);
    } else {
        $tcon->commit();
    }
}

function rollBack($outra_con = null) {
    global $con;

    if (is_null($outra_con))
        $tcon = $con;
    else
        $tcon = $outra_con;

    if ($tcon->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mssql') {
        execsql('ROLLBACK TRANSACTION', true, $tcon);
    } else {
        $tcon->rollBack();
    }
}

function lastInsertId($str = '', $outra_con = null) {
    global $con;

    if (is_null($outra_con)) {
        $tcon = $con;
    } else {
        $tcon = $outra_con;
    }

    $tipodb = $tcon->getAttribute(PDO::ATTR_DRIVER_NAME);

    switch ($tipodb) {
        case 'pgsql':
            $vlID = $tcon->lastInsertId($str);
            break;

        case 'mssql':
        case 'sqlsrv':
            $sql = "select cast(IDENT_CURRENT('{$str}') as int) as id";
            unset($rs);
            $rs = $tcon->query($sql);
            $row = $rs->fetchAll(PDO::FETCH_BOTH);
            $vlID = $row[0][0];
            break;

        default:
            $vlID = $tcon->lastInsertId();
            break;
    }

    return $vlID;
}

function monta_des($tabela) {
    global $vetLogSis, $pre_table;

    $Vet = explode(', ', $vetLogSis[$tabela]);
    ForEach ($Vet as $Index => $Campo)
        $Vet[$Index] = $_POST[$Campo];

    return join(', ', $Vet);
}

function grava_log_sis($nom_tabela, $sts_acao, $des_pk, $des_registro, $nom_tela = '', $obj_extra = '', $vetLogDetalhe = Array(), $todoLogDetalhe = false) {
    global $tipodb, $VetMenu, $menu;

    if ($nom_tela == '') {
        $nom_tela = $VetMenu[$menu];

        if ($nom_tela == '') {
            $nom_tela = $_SESSION[CS]['g_nom_tela'];
        }
    }

    if ($obj_extra != '')
        $obj_extra = serialize($obj_extra);

    if ($tipodb == 'mssql' || $tipodb == 'sqlsrv') {
        $dt = getdata(true, false, true);
    } else {
        $dt = getdata(true, false, true);
    }
    $vetParametros = Array();
    DadosEstacao($vetParametros);
    $latitude = $_SESSION[CS]['latitude'];
    $longitude = $_SESSION[CS]['longitude'];
    if ($latitude == '') {
        $latitude = 0;
    }
    if ($longitude == '') {
        $longitude = 0;
    }
    $id_session = aspa(session_id());
    $_SESSION[CS]['id_session'] = $id_session;

    $navegador = aspa($vetParametros['navegador']);
    $tipo_dispositivo = aspa($vetParametros['mobile']);
    $modelo = aspa($vetParametros['modelo']);
    //
    // $ip_usuario        = aspa($_SERVER['REMOTE_ADDR']);
    //
	$ip_usuario = $_SESSION[CS]['ip_usuario'];
    if ($sts_acao == 'L' or $sts_acao == 'V' or $sts_acao == 'S') { // no login e na interação de estar vivo
        $ip_usuario = get_client_ip();
        $_SESSION[CS]['ip_usuario'] = $ip_usuario;
    }
    $pg_usuario = get_pagina_us();
    //$des_registro .="<br />".$pg_usuario;
    $pg_usuario = aspa($pg_usuario);

    $localGET = $_GET;
    $localPOST = trataGravaPOST();
    $localSESSION = trataGravaSESSION();
    $localFILES = $_FILES;

    if (count($localGET) == 0) {
        $localGET = '';
    }

    if (count($localFILES) == 0) {
        $localFILES = '';
    }

    $sql = "insert into " . log_sistema . " (login, nom_usuario,
            nom_tela, nom_tabela, dtc_registro, sts_acao, des_pk,
            vget, vpost,
            vserver, vsession,
            vfiles,
            des_registro, ip_usuario, obj_extra,latitude,longitude,navegador,tipo_dispositivo,modelo,id_session, pg_usuario) values (" .
            aspa($_SESSION[CS]['g_login']) . ", " . aspa($_SESSION[CS]['g_nome_completo']) . ", " .
            aspa($nom_tela) . ", " . aspa($nom_tabela) . ", " . aspa($dt) . ", " . aspa($sts_acao) . ", " . aspa($des_pk) . ", " .
            aspa(base64_encode(serialize(print_r($localGET, true)))) . ', ' . aspa(base64_encode(serialize(print_r($localPOST, true)))) . ', ' .
            aspa(base64_encode(serialize(print_r($_SERVER, true)))) . ', ' . aspa(base64_encode(serialize(print_r($localSESSION, true)))) . ',' .
            aspa(base64_encode(serialize(print_r($localFILES, true)))) . ', ' .
            aspa($des_registro) . ", " . aspa($ip_usuario) . ", " . aspa($obj_extra) . ", {$latitude}, {$longitude}, {$navegador}, {$tipo_dispositivo}, {$modelo}, {$id_session}, {$pg_usuario}     )";


    execsql($sql);

    if ($tipodb == 'pgsql') {
        $id_log_sistema = lastInsertId(log_sistema . '_id_log_sistema_seq');
    } else {
        $id_log_sistema = lastInsertId();
    }

    foreach ($vetLogDetalhe as $campo_tabela => $row) {
        if ($row['vl_ant'] != $row['vl_atu'] || $row['desc_ant'] != $row['desc_atu'] || $todoLogDetalhe) {
            $sql = 'insert into ' . log_sistema_detalhe . ' (id_log_sistema, campo_tabela, campo_desc, vl_ant, vl_atu, desc_ant, desc_atu) values (';
            $sql .= null($id_log_sistema) . ', ' . aspa($campo_tabela) . ', ' . aspa($row['campo_desc']) . ', ' . aspa($row['vl_ant']) . ', ';
            $sql .= aspa($row['vl_atu']) . ', ' . aspa($row['desc_ant']) . ', ' . aspa($row['desc_atu']) . ')';
            execsql($sql);
        }
    }
}

function get_pagina_us() {

    $pg_usuario = $_SERVER['SCRIPT_NAME'];

    $pg_usuario = $_SERVER['SCRIPT_FILENAME'];

    $pg_usuario = $_SERVER['HTTP_REFERER'];
    return $pg_usuario;
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'DESCONHECIDO';

    return $ipaddress;
}

function tem_direito($cod_funcao, $cod_direito = '') {
    global $target_js, $pre_table;

    $sql = 'select df.id_difu from ' . $pre_table . 'plu_direito_funcao df inner join ' . $pre_table . 'plu_funcao f on f.id_funcao = df.id_funcao
            inner join ' . $pre_table . 'plu_direito d on d.id_direito = df.id_direito where f.cod_funcao = ' . aspa(mb_strtolower($cod_funcao));

    if ($cod_direito != '')
        $sql .= ' and d.cod_direito in (' . mb_strtolower($cod_direito) . ')';

    $result = execsql($sql);

    return !($result->rows == 0);
}

function acesso($cod_funcao, $cod_direito = '', $Msg = false, $Top = false) {
    global $target_js, $pre_table, $origem_carga;

    if ($cod_funcao == 'email_adm')
        return true;

    if ($origem_carga == "SCA") {
        return true;
    }
    $sql = 'select dp.id_difu from ' . $pre_table . 'plu_direito_perfil dp inner join ' . $pre_table . 'plu_direito_funcao df on
            dp.id_difu = df.id_difu inner join ' . $pre_table . 'plu_funcao f on f.id_funcao = df.id_funcao
            inner join ' . $pre_table . 'plu_direito d on d.id_direito = df.id_direito
            where dp.id_perfil = ' . ($_SESSION[CS]['g_id_perfil'] == '' ? 0 : $_SESSION[CS]['g_id_perfil']) . '
            and f.cod_funcao = ' . aspa(mb_strtolower($cod_funcao));

    if ($cod_direito != '') {
        $sql .= ' and d.cod_direito in (' . mb_strtolower($cod_direito) . ')';
    }

    $result = execsql($sql);

    if ($Msg && $result->rows == 0) {
        if (debug === true) {
            p($_GET);
            echo "'" . $sql . "'<br />";
        }

        echo "<script type='text/javascript'>alert('O usuário não tem acesso a este cadastro!');</script>";

        if ($_SESSION[CS]['g_abrir_sistema'] != '') {
            if ($_SESSION[CS]['g_abrir_sistema'] == 'S') {
                echo "<script type='text/javascript'>top.location = '../index.php';</script>";
            } else {
                echo "<script type='text/javascript'>top.location = '" . $_SESSION[CS]['g_abrir_sistema_url'] . "';</script>";
            }
        } else {
            if (!is_bool($Top))
                echo "<script type='text/javascript'>$Top</script>";
            else if ($Top)
                echo "<script type='text/javascript'>top.location = 'index.php';</script>";
            else
                echo "<script type='text/javascript'>$target_js.location = 'conteudo.php';</script>";
        }

        exit();
    }

    return !($result->rows == 0);
}

function criar_lista_rs($rs, $Nome, $Multiselect, $Linhas, $JS) {
    /*
      RS = Recordset
      Nome = Nome do Objeto
      Multiselect = booleano indicando seleção múltipla
      Linhas = Número de linhas da lista
      JS = Texto em JS para o Combo
     */

    if ($Multiselect)
        $intMultiselect = "multiple";
    else
        $intMultiselect = "";

    echo "<select style='width: 200px;' name='$Nome' size='$Linhas' $intMultiselect $JS>\n";

    if ($rs->rows != 0) {
        ForEach ($rs->data as $row) {
            echo "<option value='" . trata_html($row[0], ENT_QUOTES) . "'>";

            for ($x = 1; $x < $rs->cols; $x++) {
                if ($rs->info['type'][$x] == 'date' || $rs->info['type'][$x] == 'datetime')
                    echo trata_data($row[$x]);
                else
                    echo $row[$x];

                if ($x < $rs->cols - 1)
                    echo ' - ';
            }
            echo"</option>\n";
        }
    }

    echo '</select>';

    return true;
}

function criar_combo_rs($rs, $NomeCombo, $PreSelect, $LinhaFixa, $JS, $style = '', $lang = '', $return = False, $id = '', $msg_sem_registro = 'Não existe informação no sistema', $vetOptionData = Array()) {
    /*
      RS = Recordset
      NomeCombo = Nome do Objeto
      PreSelect = Value Selecionado
      LinhaFixa = Linha fixa no combo (id = "")
      JS = Texto em JS para o Combo
      style = Style
      param = Valor opcional para trabalhar com JS
     */


    if ($id == '')
        $id = $NomeCombo;
    $html = "<select id='$id' name='$NomeCombo' $JS style='$style' lang='$lang'>\n";

    if ($LinhaFixa != '')
        $html .= "<option value=''>$LinhaFixa</option>\n";

    if ($rs->rows == 0) {
        $html .= "<option value=''>{$msg_sem_registro}</option>\n";
    } else {
        ForEach ($rs->data as $row) {
            $html .= "<option value='" . trata_html($row[0], ENT_QUOTES) . "'";

            foreach ($vetOptionData as $attrData) {
                $html .= ' data-' . $attrData . '="' . trata_html($row[$attrData], ENT_QUOTES) . '"';
            }

            if ($PreSelect == $row[0]) {
                $html .= ' selected >';
            } else {
                $html .= '>';
            }

            $xINI = count($vetOptionData) + 1;

            for ($x = $xINI; $x < $rs->cols; $x++) {
                switch ($rs->info['type'][$x]) {
                    case 'date':
                    case 'datetime':
                        $vl = trata_data($row[$x]);
                        break;

                    case 'numeric':
                    case 'decimal':
                    case 'newdecimal':
                    case 'double';
                        $vl = format_decimal($row[$x]);
                        break;

                    default:
                        $vl = $row[$x];
                        break;
                }

                $html .= $vl;

                if ($x < $rs->cols - 1)
                    $html .= ' - ';
            }
            $html .= "</option>\n";
        }
    }

    $html .= '</select>';

    if ($return)
        return $html;
    else
        echo $html;
}

function grupo_combo_rs($rs, $NomeCombo, $PreSelect, $LinhaFixa, $JS, $style = '', $lang = '', $return = False, $id = '', $msg_sem_registro = 'Não existe informação no sistema', $txtID = false) {
    /*
      RS = Recordset
      NomeCombo = Nome do Objeto
      PreSelect = Value Selecionado
      LinhaFixa = Linha fixa no combo (id = "")
      JS = Texto em JS para o Combo
      lang = Valor opcional para trabalhar com JS
      txtID = Texto que vai ser colocado junto com o ID
     */

    $txtGrd = '';

    if ($txtID) {
        $colTxt = 0;
        $colGrd = 1;
        $colID = 2;
    } else {
        $colGrd = 0;
        $colID = 1;
    }

    if ($id == '') {
        $id = $NomeCombo;
    }

    $html = "<select id='$id' name='$NomeCombo' $JS lang='$lang'>\n";

    if ($LinhaFixa != '') {
        $html .= "<option value=''>$LinhaFixa</option>\n";
    }

    if ($rs->rows == 0) {
        $html .= "<option value=''>{$msg_sem_registro}</option>\n";
    } else {
        ForEach ($rs->data as $row) {
            if ($txtGrd != $row[$colGrd]) {
                if ($txtGrd != '') {
                    $html .= "</optgroup>\n";
                }

                $txtGrd = $row[$colGrd];

                $html .= "<optgroup label='" . trata_html($row[$colGrd], ENT_QUOTES) . "'>\n";
            }

            if ($txtID) {
                $valID = $row[$colTxt] . $row[$colID];
            } else {
                $valID = $row[$colID];
            }

            $html .= "<option value='" . trata_html($valID, ENT_QUOTES) . "'";

            if ($PreSelect == $row[$colID]) {
                $html .= ' selected >';
            } else {
                $html .= '>';
            }

            for ($x = $colID + 1; $x < $rs->cols; $x++) {
                switch ($rs->info['type'][$x]) {
                    case 'date':
                    case 'datetime':
                        $html .= trata_data($row[$x]);
                        break;

                    case 'numeric':
                    case 'decimal':
                    case 'newdecimal':
                    case 'double';
                        $html .= format_decimal($row[$x]);
                        break;

                    default:
                        $html .= $row[$x];
                        break;
                }

                if ($x < $rs->cols - 1) {
                    $html .= ' - ';
                }
            }

            $html .= "</option>\n";
        }

        $html .= "</optgroup>\n";
    }

    $html .= '</select>';

    if ($return) {
        return $html;
    } else {
        echo $html;
    }
}

function option_combo_rs($rs, $NomeCombo, $PreSelect, $LinhaFixa, $JS, $lang = '', $msg_sem_registro = 'Não existe informação no sistema') {
    /*
      RS = Recordset
      NomeCombo = Nome do Objeto
      PreSelect = Value Selecionado
      LinhaFixa = Linha fixa no combo (id = "")
      JS = Texto em JS para o Combo
      param = Valor opcional para trabalhar com JS
     */

    $html = '<select id="' . $NomeCombo . '" name="' . $NomeCombo . '" ' . $JS . '  lang="' . $lang . '">';

    if ($LinhaFixa != '')
        $html .= '<option value="">' . $LinhaFixa . '</option>';

    if ($rs->rows == 0) {
        $html .= '<option value="">' . $msg_sem_registro . '</option>';
    } else {
        ForEach ($rs->data as $row) {
            $html .= '<option value="' . trata_html($row[0], ENT_QUOTES) . '"';

            if ($PreSelect == $row[0])
                $html .= ' selected >';
            else
                $html .= '>';

            for ($x = 1; $x < $rs->cols; $x++) {
                switch ($rs->info['type'][$x]) {
                    case 'date':
                    case 'datetime':
                        $vl = trata_data($row[$x]);
                        break;

                    case 'numeric':
                    case 'decimal':
                    case 'newdecimal':
                    case 'double';
                        $vl = format_decimal($row[$x]);
                        break;

                    default:
                        $vl = $row[$x];
                        break;
                }

                $html .= str_replace("'", "\'", $vl);

                if ($x < $rs->cols - 1)
                    $html .= ' - ';
            }
            $html .= '</option>';
        }
    }

    $html .= '</select>';

    return $html;
}

function option_rs($rs, $PreSelect = '', $LinhaFixa = ' ', $msg_sem_registro = 'Não existe informação no sistema', $vetOptionData = Array()) {
    /*
      RS = Recordset
      PreSelect = Value Selecionado
      LinhaFixa = Linha fixa no combo (id = "")
     */

    $html = '';

    if ($LinhaFixa != '')
        $html .= '<option value="">' . $LinhaFixa . '</option>';

    if ($rs->rows == 0) {
        $html .= '<option value="">' . $msg_sem_registro . '</option>';
    } else {
        ForEach ($rs->data as $row) {
            $html .= '<option value="' . trata_html($row[0], ENT_QUOTES) . '"';

            foreach ($vetOptionData as $attrData) {
                $html .= ' data-' . $attrData . '="' . trata_html($row[$attrData], ENT_QUOTES) . '"';
            }

            if ($PreSelect == $row[0]) {
                $html .= ' selected >';
            } else {
                $html .= '>';
            }

            $xINI = count($vetOptionData) + 1;

            for ($x = $xINI; $x < $rs->cols; $x++) {
                switch ($rs->info['type'][$x]) {
                    case 'date':
                    case 'datetime':
                        $vl = trata_data($row[$x]);
                        break;

                    case 'numeric':
                    case 'decimal':
                    case 'newdecimal':
                    case 'double';
                        $vl = format_decimal($row[$x]);
                        break;

                    default:
                        $vl = $row[$x];
                        break;
                }

                $html .= str_replace("'", "\'", $vl);
                if ($x < $rs->cols - 1)
                    $html .= ' - ';
            }
            $html .= '</option>';
        }
    }

    return $html;
}

function option_rs_json($rs, $val, $LinhaFixa = '', $msg_sem_registro = '', $vetData = Array()) {
    /*
      RS = Recordset
      val = valor do select pai
      LinhaFixa = Linha fixa no combo
     */

    if ($msg_sem_registro == '') {
        $msg_sem_registro = 'Não existe informação no sistema';
    }

    $vetJSON = Array();

    if ($LinhaFixa != '') {
        $vetTmp = Array();
        $vetTmp['when'] = $val;
        $vetTmp['optgroup'] = '';
        $vetTmp['value'] = '';
        $vetTmp['text'] = rawurlencode($LinhaFixa);

        foreach ($vetData as $value) {
            $vetTmp[$value] = '';
        }

        $vetJSON[] = $vetTmp;
    }

    if ($rs->rows == 0) {
        $vetTmp = Array();
        $vetTmp['when'] = $val;
        $vetTmp['optgroup'] = '';
        $vetTmp['value'] = '';
        $vetTmp['text'] = rawurlencode($msg_sem_registro);

        foreach ($vetData as $value) {
            $vetTmp[$value] = '';
        }

        $vetJSON[] = $vetTmp;
    } else {
        $totData = count($vetData);

        ForEach ($rs->data as $row) {
            $vetTmp = Array();
            $vetTmp['when'] = $val;
            $vetTmp['optgroup'] = '';
            $vetTmp['value'] = trata_html($row[0], ENT_QUOTES, 'ISO-8859-1');

            $text = '';

            for ($x = $totData + 1; $x < $rs->cols; $x++) {
                switch ($rs->info['type'][$x]) {
                    case 'date':
                    case 'datetime':
                        $vl = trata_data($row[$x]);
                        break;

                    case 'numeric':
                    case 'decimal':
                    case 'newdecimal':
                    case 'double';
                        $vl = format_decimal($row[$x]);
                        break;

                    default:
                        $vl = $row[$x];
                        break;
                }

                $text .= $vl;

                if ($x < $rs->cols - 1) {
                    $text .= ' - ';
                }
            }

            $vetTmp['text'] = rawurlencode($text);

            foreach ($vetData as $x => $value) {
                $x++;

                switch ($rs->info['type'][$x]) {
                    case 'date':
                    case 'datetime':
                        $vl = trata_data($row[$x]);
                        break;

                    case 'numeric':
                    case 'decimal':
                    case 'newdecimal':
                    case 'double';
                        $vl = format_decimal($row[$x]);
                        break;

                    default:
                        $vl = $row[$x];
                        break;
                }

                $vetTmp[$value] = rawurlencode($vl);
            }

            $vetJSON[] = $vetTmp;
        }
    }

    return json_encode($vetJSON);
}

function grupo_option_rs_json($rs, $val, $LinhaFixa = '', $msg_sem_registro = 'Não existe informação no sistema', $txtID = false) {
    /*
      RS = Recordset
      val = valor do select pai
      LinhaFixa = Linha fixa no combo
      txtID = Texto que vai ser colocado junto com o ID
     */

    if ($txtID) {
        $colTxt = 0;
        $colGrd = 1;
        $colID = 2;
    } else {
        $colGrd = 0;
        $colID = 1;
    }

    $html = '[';

    if ($LinhaFixa != '') {
        $html .= '{"when":"' . $val . '","optgroup":"","value":"","text":"' . rawurlencode($LinhaFixa) . '"},';
    }

    if ($rs->rows == 0) {
        $html .= '{"when":"' . $val . '","optgroup":"","value":"","text":"' . rawurlencode($msg_sem_registro) . '"},';
    } else {
        ForEach ($rs->data as $row) {
            if ($txtID) {
                $valID = $row[$colTxt] . $row[$colID];
            } else {
                $valID = $row[$colID];
            }

            $html .= '{';
            $html .= '"when":"' . $val . '",';
            $html .= '"optgroup":"' . trata_html($row[$colGrd], ENT_QUOTES, 'ISO-8859-1') . '",';
            $html .= '"value":"' . trata_html($valID, ENT_QUOTES, 'ISO-8859-1') . '",';
            $html .= '"text":"';

            for ($x = $colID + 1; $x < $rs->cols; $x++) {
                switch ($rs->info['type'][$x]) {
                    case 'date':
                    case 'datetime':
                        $vl = trata_data($row[$x]);
                        break;

                    case 'numeric':
                    case 'decimal':
                    case 'newdecimal':
                    case 'double';
                        $vl = format_decimal($row[$x]);
                        break;

                    default:
                        $vl = $row[$x];
                        break;
                }

                $html .= rawurlencode(str_replace('"', '\"', $vl));
                if ($x < $rs->cols - 1)
                    $html .= ' - ';
            }
            $html .= '"},';
        }
    }

    $html .= "]";

    return str_replace('},]', '}]', $html);
}

function option_combo_vet($Vet, $NomeCombo, $PreSelect, $LinhaFixa = ' ', $JS = '', $Style = '') {
    /*
      Vet = Vetor
      NomeCombo = Nome do Objeto
      PreSelect = Value Selecionado
      LinhaFixa = Linha fixa no combo (id = "")
      JS = Texto em JS para o Combo
     */

    $numrows = count($Vet);

    $html = "<select id='$NomeCombo' name='$NomeCombo' $JS style='$Style'>\n";

    if ($LinhaFixa != '')
        $html .= "<option value=''>$LinhaFixa</option>\n";

    if ($numrows == 0) {
        $html .= "<option value=''>Não há informação no sistema</option>\n";
    } else {
        ForEach ($Vet as $Chave => $Valor) {
            $html .= "<option value='$Chave'";

            if ($PreSelect == $Chave)
                $html .= ' selected >';
            else
                $html .= '>';

            $html .= "$Valor</option>\n";
        }
    }

    $html .= '</select>';

    return $html;
}

function criar_combo_vet($Vet, $NomeCombo, $PreSelect, $LinhaFixa = ' ', $JS = '', $Style = '', $return = false, $id = '', $msg_sem_registro = 'Não existe informação no sistema') {
    /*
      Vet = Vetor
      NomeCombo = Nome do Objeto
      PreSelect = Value Selecionado
      LinhaFixa = Linha fixa no combo (id = "")
      JS = Texto em JS para o Combo
     */

    $numrows = count($Vet);
    if ($id == '')
        $id = $NomeCombo;

    $html = "<select id='$id' name='$NomeCombo' $JS style='$Style'>\n";

    if ($LinhaFixa != '')
        $html .= "<option value=''>$LinhaFixa</option>\n";

    if ($numrows == 0) {
        $html .= "<option value=''>{$msg_sem_registro}</option>\n";
    } else {
        ForEach ($Vet as $Chave => $Valor) {
            $html .= "<option value='$Chave'";

            if ($PreSelect == $Chave)
                $html .= ' selected >';
            else
                $html .= '>';

            $html .= "$Valor</option>\n";
        }
    }

    $html .= '</select>';

    if ($return)
        return $html;
    else
        echo $html;
}

function extensao_arq($arquivo) {
    $ext = substr($arquivo, -4);
    if ($ext[0] == '.') {
        $ext = substr($ext, -3);
    }
    return $ext;
}

function trata_id(&$Filtro, $extra = '') {
    global $Campo, $vetFiltro, $ordFiltro;
    $idx = count($vetFiltro);

    if ($Filtro['id_select'] == '') {
        $Filtro['id_select'] = $Filtro['id'];
    }

    if ($ordFiltro) {
        $vlCampo = $Filtro['id'] . $idx . $extra;
    } else {
        $vlCampo = $Filtro['id'] . $extra;
    }

    if ($_REQUEST[$vlCampo] == '') {
        $vl = $_GET[$vlCampo];
    } else {
        $vl = $_REQUEST[$vlCampo];
    }

    if ($_REQUEST['vlPesquisaPadrao'] == 'S') {
        $valor = $Filtro['vlPadrao'];
    } else {
        if ($Filtro['rs'] == '') {
            if (is_numeric($Filtro['vlPadrao']))
                $valor = $Filtro['vlPadrao'];
            else if (is_numeric($_SESSION[$Filtro['id']]))
                $valor = $_SESSION[$Filtro['id']];
            else
                $valor = $vl;

            if ($valor == '')
                $valor = 0;
        } else if ($Filtro['rs'] == 'Hidden') {
            $valor = $vl;
        } else if ($Filtro['rs'] == 'Texto') {
            $valor = $vl;

            if ($valor == '') {
                $valor = $Filtro['vlPadrao'];
            }
        } else if ($Filtro['rs'] == 'Intervalo') {
            $valor = $vl;

            if ($valor == '') {
                $valor = $Filtro['vlPadrao' . $extra];
            }
        } else if ($Filtro['rs'] == 'ListarCmb') {
            $valor = $vl;
        } else if ($Filtro['rs'] == 'Data') {
            $valor = $vl;
        } else if (is_array($Filtro['rs'])) {
            $id = $vl;
            $achei = false;

            ForEach ($Filtro['rs'] as $Chave => $Valor) {
                if ($Chave == $id) {
                    $achei = true;
                    break;
                }
            }

            if (!$achei) {
                if ($Filtro['vlPadrao'] != '')
                    $id = $Filtro['vlPadrao'];
                else if ($_SESSION[$Filtro['id']] != '')
                    $id = $_SESSION[$Filtro['id']];
                else if ($Filtro['LinhaUm'] != '') {
                    $id = '0';
                } else {
                    reset($Filtro['rs']);
                    $vet = each($Filtro['rs']);
                    $id = $vet['key'];
                }
            }

            $valor = $id;

            if ($valor == '')
                $Campo .= $Filtro['nome'] . ', ';
        } else {
            switch ($Filtro['rs']->rows) {
                case 0:
                    if ($Filtro['vlPadrao'] != '')
                        $valor = $Filtro['vlPadrao'];
                    else if ($Filtro['LinhaUm'] != '')
                        $valor = -1;
                    else if ($_SESSION[$Filtro['id']] != '')
                        $valor = $_SESSION[$Filtro['id']];
                    else
                        $valor = 0;
                    break;

                case 1:
                    if ($Filtro['LinhaUm'] != '' && $vl == '')
                        $valor = -1;
                    else
                        $valor = $Filtro['rs']->data[0][$Filtro['id_select']];
                    break;

                default:
                    $id = $vl;
                    $achei = false;

                    ForEach ($Filtro['rs']->data as $Linha) {
                        if ($Linha[$Filtro['id_select']] == $id) {
                            $achei = true;
                            break;
                        }
                    }

                    if (!$achei) {
                        if ($Filtro['vlPadrao'] != '')
                            $id = $Filtro['vlPadrao'];
                        else if ($Filtro['LinhaUm'] != '')
                            $id = -1;
                        else if ($_SESSION[$Filtro['id']] != '')
                            $id = $_SESSION[$Filtro['id']];
                        else
                            $id = $Filtro['rs']->data[0][$Filtro['id_select']];
                    }

                    $valor = $id;
                    break;
            }

            if (is_numeric($valor)) {
                if ($valor == 0) {
                    $Campo .= $Filtro['nome'] . ', ';
                }
            } else {
                if ($valor == '') {
                    $Campo .= $Filtro['nome'] . ', ';
                }
            }
        }
    }

    return $valor;
}

function includeListarCmb($arq, $includeListarCmbWhere) {
    global $campoDescListarCmb;

    require 'definicao_vetor.php';

    if (file_exists(lib_path . 'funcao/definicao_vetor_lib.php')) {
        require(lib_path . 'funcao/definicao_vetor_lib.php');
    }

    $includeListarCmb = true;

    require($arq);

    return Array(
        'sql' => $sql,
        'idCampo' => $idCampo,
    );
}

function conVetCad($arq) {
    ob_start();
    require_once 'fncCampo.php';
    require($arq);
    ob_end_clean();

    return $vetCad;
}

function codigo_filtro($esconde = true, $pesquisar = true, $botao = '', $botao_texto = '', $sel_coluna = false, $sel_agrupamento = false) {
    global $menu, $vetTabelas, $vetTabelasREL, $vetFiltro, $ordFiltro, $Focus, $cont_arq, $dir_style, $vetOrderby, $vetOrderbyExtra, $sqlOrderby, $campoDescListarCmb, $vetGroupby;

    $Focus = '';
    $html = '';

    if (!is_array($vetOrderbyExtra)) {
        $vetOrderbyExtra = Array(
            'asc' => 'Ascendente',
            'desc' => 'Descendente',
        );
    }

//echo "entrei<br />";
//p($vetFiltro);
    echo '<input type="hidden" name="sqlOrderby" id="sqlOrderby" value="' . $sqlOrderby . '">';
    echo '<input type="hidden" name="sqlOrderby_upcad" value="' . $_REQUEST['sqlOrderby_upcad'] . '">';
    echo '<input type="hidden" name="vlPesquisaPadrao" id="vlPesquisaPadrao" value="">';

    echo "
        <script type='text/javascript'>
        function trata_filtro(obj, tam, enter) {
            if (tam <= 0) {
                if (enter) document.frm.submit();
                return false;
            }

            if (obj.value.length > 0 && obj.value.length <= tam) {
                alert('Favor informar o texto com mais de ' + tam + ' caracteres!');
                obj.value = '';
                obj.focus();
            } else {
                if (enter) document.frm.submit();
            }

            return false;
        }
        </script>
    ";

    $idx = -1;
    ForEach ($vetFiltro as $Filtro) {
        if ($ordFiltro) {
            $idx++;
            $vl = $Filtro['id'] . $idx;
        } else {
            $vl = $Filtro['id'];
        }

        if ($Filtro['rs'] == '' || $Filtro['rs'] == 'Hidden' || $Filtro['rs'] == 'ListarCmb') {
//Não faz nada...
        } else if (is_array($Filtro['rs']) || $Filtro['rs'] == 'Texto') {
            if ($Focus == '') {
                $Focus = $vl;
            }
        } else if (is_array($Filtro['rs'])) {
            if ($Focus == '') {
                $Focus = $vl;
            }
        } else if ($Filtro['rs'] == 'Intervalo') {
            if ($Focus == '') {
                $Focus = $vl . '_ini';
            }
        } else {
            if (!($Filtro['rs']->rows == 1 && $Filtro['LinhaUm'] == '') && $Focus == '')
                $Focus = $vl;
        }
    }

    $idx = -1;
    ForEach ($vetFiltro as $Filtro) {
        if (is_numeric($Filtro['size'])) {
            $size = $Filtro['size'];

            if ($size > 50) {
                $size = 50;
            }
        } else {
            $size = 30;
        }

        if (is_numeric($Filtro['maxlength'])) {
            $maxlength = $Filtro['maxlength'];
        }

        if ($ordFiltro) {
            $idx++;
            $vl = $Filtro['id'] . $idx;
        } else {
            $vl = $Filtro['id'];
        }

        if ($Filtro['rs'] == '' || $Filtro['rs'] == 'Hidden') {
            if ($Focus == $vl)
                $Focus = '';

            echo '<input id="' . $vl . '" type="hidden" name="' . $vl . '" value="' . $Filtro['valor'] . '">';

            if ($Filtro['tabela'] != '' && $Filtro['campo'] != '') {
                if ($Filtro['id_select'] == '') {
                    $Filtro['id_select'] = $Filtro['id'];
                }

                $html .= '<tr><td class="Tit_Campo_Obr_f" align="right">' . $Filtro['nome'] . ':&nbsp;</td><td class="Texto">';
                $asTabela = ($Filtro['id_tabela'] == '' ? '' : $Filtro['id_tabela'] . '.');
                $sql = 'select ' . $Filtro['campo'] . ' from ' . $Filtro['tabela'] . ' where ' . $asTabela . $Filtro['id_select'] . ' = ' . $Filtro['valor'];
                $rs = execsql($sql);
                $row = $rs->data[0];

                for ($x = 0; $x < $rs->cols; $x++) {
                    if ($rs->info['type'][$x] == 'date' || $rs->info['type'][$x] == 'datetime')
                        $html .= trata_data($row[$x]);
                    else
                        $html .= $row[$x];

                    if ($x < $rs->cols - 1)
                        $html .= ' - ';
                }

                $html .= '</td>';
                $html .= '</tr>';
            }
        } else if ($Filtro['rs'] == 'Texto') {

            $html .= '<tr><td class="Tit_Campo_Obr_f" align="right">' . $Filtro['nome'] . ':&nbsp;</td><td>';

            if ($Filtro['js'] == '') {
                $tam = $Filtro['js_tam'] == '' ? 3 : $Filtro['js_tam'];
                $js = "onkeydown = 'return (event.keyCode == 13 ? trata_filtro(this, $tam) : true);' onBlur = 'trata_filtro(this, $tam)'";
            } else if ($Filtro['js'] == 'data') {
                $js = 'onblur="return checkdate(this)" onkeyup="return Formata_Data(this,event)"';
                echo '
                    <script type="text/javascript">
                        $(function() {
                            $("#' . $vl . '").datepicker({
                                showOn: \'button\',
                                changeMonth: true,
                                changeYear: true,
                                buttonText: \'Selecionar a data\',
                                buttonImage: \'imagens/calendar.gif\',
                                buttonImageOnly: true,
                                dateFormat: \'dd/mm/yy\'
                            });
                        });
                    </script>
                ';
            } else if ($Filtro['js'] != false) {
                $js = $Filtro['js'];
            } else {
                $js = '';
            }

            if ($Filtro['js'] == 'data') {
                $html .= '<input id="' . $vl . '" name="' . $vl . '" type="text" class="Texto" value="' . $Filtro['valor'] . '" size="10" maxlength="10" ' . $js . '>';
            } else {
                $html .= '<input id="' . $vl . '" name="' . $vl . '" type="text" class="Texto" value="' . $Filtro['valor'] . '" size="' . $size . '" maxlength="' . $maxlength . '" ' . $js . ' />';
            }

            $html .= '</td></tr>';
        } else if ($Filtro['rs'] == 'Intervalo') {
            $html .= '<tr><td class="Tit_Campo_Obr_f" align="right">' . $Filtro['nome'] . ':&nbsp;</td><td style="padding-bottom: 5px; vertical-align: middle;">';

            $js = $Filtro['js'];

            if ($Filtro['js'] == 'data') {
                $js .= ' onblur="return checkdate(this)" onkeyup="return Formata_Data(this,event)"';
            }

            if ($Filtro['js'] == 'data') {
                $html .= '<input id="' . $vl . '_ini" name="' . $vl . '_ini" type="text" class="Texto" value="' . $Filtro['valor_ini'] . '" size="10" maxlength="10" ' . $js . ' />';
                $html .= '&nbsp;&nbsp;a&nbsp;&nbsp;';
                $html .= '<input id="' . $vl . '_fim" name="' . $vl . '_fim" type="text" class="Texto" value="' . $Filtro['valor_fim'] . '" size="10" maxlength="10" ' . $js . ' />';

                echo '
                    <script type="text/javascript">
                        $(function() {
                            $("#' . $vl . '_ini").datepicker({
                                showOn: \'button\',
                                changeMonth: true,
                                changeYear: true,
                                buttonText: \'Selecionar a data\',
                                buttonImage: \'imagens/calendar.gif\',
                                buttonImageOnly: true,
                                dateFormat: \'dd/mm/yy\'
                            });
                            
                            $("#' . $vl . '_fim").datepicker({
                                showOn: \'button\',
                                changeMonth: true,
                                changeYear: true,
                                buttonText: \'Selecionar a data\',
                                buttonImage: \'imagens/calendar.gif\',
                                buttonImageOnly: true,
                                dateFormat: \'dd/mm/yy\'
                            });
                        });
                    </script>
                ';
            } else {
                $html .= '<input id="' . $Filtro['id'] . '_ini" name="' . $Filtro['id'] . '_ini" type="text" class="Texto" value="' . $Filtro['valor_ini'] . '" size="' . $size . '" maxlength="' . $maxlength . '" ' . $js . ' />';
                $html .= '&nbsp;&nbsp;a&nbsp;&nbsp;';
                $html .= '<input id="' . $Filtro['id'] . '_fim" name="' . $Filtro['id'] . '_fim" type="text" class="Texto" value="' . $Filtro['valor_fim'] . '" size="' . $size . '" maxlength="' . $maxlength . '" ' . $js . ' />';
            }

            $html .= '</td></tr>';
        } else if ($Filtro['rs'] == 'ListarCmb') {
            if ($Filtro['titulo_tela'] == '') {
                $Filtro['titulo_tela'] = $Filtro['nome'];
            }

            $html .= '<tr><td class="Tit_Campo_Obr_f" align="right">' . $Filtro['nome'] . ':&nbsp;</td><td id="' . $vl . '_obj">';

            $html .= '<input type="hidden" id="' . $vl . '" name="' . $vl . '" value="' . trata_html($Filtro['valor'], ENT_QUOTES, 'ISO-8859-1') . '">';
            $html .= '<div class="Texto listar_cmb_div">';

            $vetFRO = includeListarCmb('listar_cmb/' . $Filtro['arq'] . '.php');

            $sql = '';
            $sql .= ' select t.' . $campoDescListarCmb;
            $sql .= ' from (' . $vetFRO['sql'] . ') t';
            $sql .= ' where t.' . $Filtro['id_select'] . ' = ' . aspa($Filtro['valor']);
            $rs = execsql($sql);
            $desc = $rs->data[0][0];

            switch ($rs->info['type'][$campoDescListarCmb]) {
                case 'numeric':
                case 'decimal':
                case 'newdecimal':
                case 'double':
                    $html .= format_decimal($desc);
                    break;

                case 'date':
                case 'datetime':
                case 'timestamp':
                    $html .= trata_data($desc);
                    break;

                default:
                    $html .= $desc;
                    break;
            }

            $html .= '</div>';

            $html .= '<img id="' . $vl . '_bt_pesquisa" class="bt_acao" src="imagens/bt_pesquisa.png" title="Buscar Registro" onclick="ListarCmbClick(\'' . $vl . '\', \'' . $Filtro['arq'] . '\', \'' . $Filtro['titulo_tela'] . '\');" />';
            $html .= '<img id="' . $vl . '_bt_limpar" class="bt_acao" src="imagens/bt_limpar.png" title="Limpar" onclick="ListarCmbLimpa(\'' . $vl . '\');" />';

            $html .= '</td></tr>';
        } else if (is_array($Filtro['rs'])) {
            if ($Filtro['tipo'] != 'C') {
                $stcl = '';
            } else {
                $stcl = 'style="height:50px; color:#004080;"';
            }

            $html .= '<tr><td class="Tit_Campo_Obr_f" align="right" ' . $stcl . '>' . $Filtro['nome'] . ':&nbsp;</td><td>';

            if ($Filtro['js'] != false)
                $js = $Filtro['js'];
            else
                $js = '';

            $html .= option_combo_vet($Filtro['rs'], $vl, $Filtro['valor'], $Filtro['LinhaUm'], $js);
            $html .= '</td></tr>';
        } else {
            if ($Filtro['rs']->rows == 1 && $esconde) {
                echo '<input type="hidden" name="' . $vl . '" value="' . $Filtro['valor'] . '">';
            } else {
                if ($Filtro['tipo'] != 'C') {
                    $stcl = '';
                } else {
                    $stcl = 'style="color:#004080;"';
                }
                $html .= '<tr><td class="Tit_Campo_Obr_f" align="right" $stcl >' . $Filtro['nome'] . ':&nbsp;</td><td>';
                if ($Filtro['js'] == 'vazio')
                    $js = '';
                else
                    $js = $Filtro['js'];

                $html .= option_combo_rs($Filtro['rs'], $vl, $Filtro['valor'], $Filtro['LinhaUm'], $js);
                $html .= '</td></tr>';
            }
        }
    }

    $style = '';
    if ($cont_arq != '') {
        $style = 'style=" background:#FFFFFF; margin-top: 10px;"';
    }

    echo "<div id='filtro_classificacao'>";

    echo '<table id="Tabela_Filtro" width="100%" border="0" cellspacing="0" cellpadding="2" ' . $style . '>';
    echo '<tr> ';
    echo '<td colspan="2" style="text-align:center; font-size:14px; background:#808080; color:#FFFFFF; " >';
    echo 'Escolha as opções desejadas e depois clique no botão de Pesquisar...';
    echo '</td>';
    echo '</tr>';

    echo '<tr class="tit"> ';
    echo '<td><span style="color:#FFFFFF;">Filtros</span></td>';
    echo '<td><span style="color:#FFFFFF;">Agrupamento e Classificação</span></td>';
    echo '</tr>';

    echo '<tr><td id="filtro">';

    echo '<table width="100%" border="0" cellspacing="0" cellpadding="2">';
    echo $html;
    echo '</table>';

    echo '</td>';
    echo '<td id="agrupamento_classificacao">';

    if ($sel_agrupamento) {
        echo '<div id="agrupamento">';

        echo '<div>';
        echo '<span>+ Agrupamento</span>';
        echo '</div>';

        echo '<ul>';
        if (is_array($_POST['sql_groupby'])) {
            foreach ($_POST['sql_groupby'] as $idx => $value) {
                if (!empty($value)) {
                    echo '<li>';
                    criar_combo_vet($vetGroupby, 'sql_groupby[]', $value);
                    echo '<span>-</span>';
                    echo '</li>';
                }
            }
        }
        echo '</ul>';
        echo '</div>';
    }

    echo '<div id="classificacao">';

    if ($pesquisar) {
        echo '<div>';
        echo '<span>+ Classificação</span>';
        echo '</div>';

        echo '<ul>';
        if (is_array($_POST['sql_orderby'])) {
            foreach ($_POST['sql_orderby'] as $idx => $value) {
                if (!empty($value)) {
                    echo '<li>';
                    criar_combo_vet($vetOrderby, 'sql_orderby[]', $value);

                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

                    criar_combo_vet($vetOrderbyExtra, 'sql_orderby_extra[]', $_POST['sql_orderby_extra'][$idx]);

                    echo '<span>-</span>';
                    echo '</li>';
                }
            }
        }
        echo '</ul>';
    }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('div#classificacao > div > span').click(function () {
                var html = '<li>' + $('#classificacao_modelo').html() + '</li>';
                $('div#classificacao > ul').append(html);

                $('#contListar').height($('#contListar').innerHeight()).html('<div align="center" class="Msg">Favor clicar no botão de Pesquisar!</div>');
                //TelaHeight();
            });

            $('div#agrupamento > div > span').click(function () {
                var html = '<li>' + $('#agrupamento_modelo').html() + '</li>';
                $('div#agrupamento > ul').append(html);

                $('#contListar').height($('#contListar').innerHeight()).html('<div align="center" class="Msg">Favor clicar no botão de Pesquisar!</div>');
                //TelaHeight();
            });

            $('td#ordenacao > div > span').click(function () {
                var html_ordenacao = '<li>' + $('#ordenacao_modelo').html() + '</li>';
                $('td#ordenacao > ul').append(html_ordenacao);

                $('#contListar').height($('#contListar').innerHeight()).html('<div align="center" class="Msg">Favor clicar no botão de Pesquisar!</div>');
                //TelaHeight();
            });

            $('div#classificacao > ul').on("click", 'li > span', function () {
                $(this).parent().remove();
                $('#sqlOrderby').val('');

                $('#contListar').height($('#contListar').innerHeight()).html('<div align="center" class="Msg">Favor clicar no botão de Pesquisar!</div>');
                //TelaHeight();
            });

            $('div#agrupamento > ul').on("click", 'li > span', function () {
                $(this).parent().remove();
                $('#sqlGroupby').val('');

                $('#contListar').height($('#contListar').innerHeight()).html('<div align="center" class="Msg">Favor clicar no botão de Pesquisar!</div>');
                //TelaHeight();
            });

            $("div#classificacao > ul").sortable({
                placeholder: "ui-state-highlight"
            });

            $("div#agrupamento > ul").sortable({
                placeholder: "ui-state-highlight"
            });

            $('input#BtPesquisaLimpar').click(function () {
                $('#Tabela_Filtro select').val('');
                $('#Tabela_Filtro input:not(".BtPesquisa")').val('');
                $('div#classificacao > ul > li > span').click();
                $('div#agrupamento > ul > li > span').click();

                document.frm.submit();
            });

            $('input#BtPesquisaPadrao').click(function () {
                $('#vlPesquisaPadrao').val('S');
                $('div#classificacao > ul > li > span').click();
                $('div#agrupamento > ul > li > span').click();

                document.frm.submit();
            });

            $('input#BtSelecionarColuna').click(function () {
                showPopWin('sel_coluna.php?id=<?php echo $sel_coluna; ?>', 'Selecione as Colunas', 700, $(window).height() - 100, close_sel_coluna);

                $('#codigo_filtro').toggle();

                if ($('#val_codigo_filtro').val() == 'S') {
                    $('#val_codigo_filtro').val('N');
                } else {
                    $('#val_codigo_filtro').val('S');
                }
            });
        });

        function close_sel_coluna(returnVal) {
            $('#sel_campo').val(returnVal[0]);
            document.$frm.submit();
        }

        function GuardaFavoritos(post_pesquisa, get_pesquisa, codigo_pesquisa, descricao_pesquisa, menu_pesquisa)
        {
            // alert('Guardar Favorito'+menu_pesquisa);
            post_pesquisaw = post_pesquisa;
            get_pesquisaw = get_pesquisa;
            codigo_pesquisaw = codigo_pesquisa;
            descricao_pesquisaw = descricao_pesquisa;
            menu_pesquisaw = menu_pesquisa;
            //alert('1 '+post_pesquisaw);
            //alert('2 '+get_pesquisaw);
            //alert('3 '+codigo_pesquisaw);
            //alert('4 '+descricao_pesquisaw);
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'ajax_pesquisa.php?tipo=PESQ_GF',
                data: {
                    cas: conteudo_abrir_sistema,
                    post_pesquisa: post_pesquisaw,
                    get_pesquisa: get_pesquisaw,
                    codigo_pesquisa: codigo_pesquisaw,
                    descricao_pesquisa: descricao_pesquisaw,
                    menu_pesquisa: menu_pesquisaw
                },
                success: function (response) {
                    if (response.erro != '')
                    {
                        alert("Atenção..." + "\n" + response.erro);
                    } else
                    {
                        alert("Atenção..." + "\n" + 'Registrado com Sucesso');
                        document.frm.submit();
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert('Erro [AC_SERV] no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

        }
        function ExcluiFavoritos(idt_pesquisa)
        {

            var id = "fa_" + idt_pesquisa;
            var objt = document.getElementById(id);
            if (objt != null) {

                objt.style.background = '#FF0000';
            }
            //alert('Excluir Favorito '+idt_pesquisa);
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'ajax_pesquisa.php?tipo=PESQ_EF',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_pesquisa: idt_pesquisa
                },
                success: function (response) {
                    if (response.erro != '')
                    {
                        alert("Atenção..." + "\n" + response.erro);
                    } else
                    {
                        var id = "fa_" + idt_pesquisa;
                        var objt = document.getElementById(id);
                        if (objt != null) {
                            $(objt).hide();
                        }
                        alert("Atenção..." + "\n" + 'Excluído com Sucesso');


                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert('Erro [AC_SERV] no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });


        }
        function SelecionaFavoritos(idt_pesquisa)
        {
            //alert('Seleciona Favorito '+idt_pesquisa);
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'ajax_pesquisa.php?tipo=PESQ_SF',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_pesquisa: idt_pesquisa
                },
                success: function (response) {
                    if (response.erro != '')
                    {
                        alert("Atenção..." + "\n" + response.erro);
                    } else
                    {
                        // alert("Atenção..."+"\n"+'Excluído com Sucesso');	

                        $('#idt_pesquisa_sel').val(idt_pesquisa);
                        document.frm.submit();
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // alert('Erro [AC_SERV] no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

        }

        function AbreTexto(id)
        {
            //alert('Abre texto'+id);    
            var idw = id + '_t';
            var obj = document.getElementById(id);
            if (obj != null)
            {
                var objt = document.getElementById(idw);
                if (objt != null) {

                    if (obj.checked)
                    {
                        $(objt).show();


                    } else
                    {
                        $(objt).hide();

                    }
                }
            }
        }
    </script>
    <?php
    echo '</div>';
    echo '</td>';
    echo '</tr>';

    $colg = count($vetTabelas);

    if ($colg > 0) {
        $vetGrupoPG = $vetTabelas['PG']; // Parâmetros Gerais
        $tipodefull = $vetGrupoPG['tipodefull'];
        $titulo = $vetGrupoPG['titulo'];
        $colgrupo = $vetGrupoPG['colgrupo'];
        if ($titulo == '') {
            $titulo = "Dimensões";
        }
        if ($tipodefull == '') {
            $tipodefull = "Analitico";
        }
        if ($colgrupo == "") {
            $colgrupo = 2;
        }
        $vetGrupoD = $vetTabelas['GR'];
        $colg = count($vetGrupoD);
        echo '<tr > ';
        $colgw = $colg - 1;

        $colgw = 2;

        echo "<td colspan='{$colgw}' class='barra_colunas' style='width:100%;'>";
        echo " {$titulo} ";
        echo '</td>';
        echo "<td  class='barra_colunas' style='width:5%;' >";
        //$onclick = ' onclick=" return GuardaFavoritos(); "';
        //echo '<img '.$onclick.'  title="Adiciona Parãmetros em Favoritos" style="cursor:pointer;  padding:5px;" src="imagens/add-favoritos.png" width="32" height="32"  border="0" />';

        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo "<td colspan='{$colgw}' class='barra_colunas_f' >";
        echo '<table width="100%" border="0" cellspacing="0" cellpadding="2">';
        echo '<tr>';
        ForEach ($vetGrupoD as $GrupoD => $descGrupo) {
            echo "<td  style='border-right:1px solid #000000; '>";
            echo $descGrupo;
            echo '</td>';
        }
        echo '</tr>';
        echo '<tr>';
        $virgula = "";
        ForEach ($vetGrupoD as $GrupoD => $descGrupo) {
            echo "<td style='border-right:1px solid #000000; ' >";
            $vetCpoP = $vetTabelas['CTP'][$GrupoD];
            $tam = count($vetCpoP);
            echo '<table width="100%"  border="0" cellspacing="0" cellpadding="2">';

            $cont = 0;

            ForEach ($vetCpoP as $CampoPesq => $vetQualificadores) {
                $campo_caption = str_replace("<br />", " ", $vetQualificadores['dsc']);

                $campo_tipo = $vetQualificadores['tip'];
                $valorant = ""; // checked

                if ($tipodefull == "Sintetico") {
                    $colativa = "{$GrupoD}";
                    $aparece = 'display:none';
                    if ($_POST[$colativa] == $campo_caption) {
                        $valorant = "checked"; // 
                        $aparece = '';
                        $campo_caption_sel .= $virgula . $campo_caption;
                        $virgula = ", ";
                    }
                } else {
                    $colativa = "{$GrupoD}_{$CampoPesq}";
                    $aparece = 'display:none';
                    if ($_POST[$colativa] != "") {
                        $valorant = "checked"; // 
                        $aparece = '';
                        $campo_caption_sel .= $virgula . $campo_caption;
                        $virgula = ", ";
                    }
                }
                // echo '<table width="100%"  border="0" cellspacing="0" cellpadding="2">';
                if ($cont == 0) {
                    echo '<tr>';
                }
                $cont = $cont + 1;


                echo "<td  style='font-size:11px; '>";

                $idw = "{$GrupoD}_{$CampoPesq}";
                echo " <div style='float:left;'>  ";
                $tipobox = "checkbox";
                $onclick = " onclick='return AbreTexto(" . '"' . $idw . '"' . ");' ";
                if ($tipodefull == "Sintetico") {
                    $tipobox = "radio";
                    $onclick = "";
                    $aparece = 'display:none';
                    echo "<input type='{$tipobox}' class='m_coluna_c' {$onclick}  id='{$GrupoD}_{$CampoPesq}'  name='{$GrupoD}' value='{$campo_caption}' {$valorant} >$campo_caption ";
                } else {
                    echo "<input type='{$tipobox}' class='m_coluna_c' {$onclick}  id='{$GrupoD}_{$CampoPesq}'  name='{$GrupoD}_{$CampoPesq}' value='{$GrupoD}_{$CampoPesq}' {$valorant} >$campo_caption ";
                }
                echo " </div>  ";
                echo " <div style='float:left;'>  ";
                //echo "&nbsp;&nbsp;&nbsp;$campo_caption";
                $idw = "{$GrupoD}_{$CampoPesq}_t";
                $vlo = $_POST[$idw];
                echo "<input type='text' value='{$vlo}' id='{$GrupoD}_{$CampoPesq}_t' name='{$GrupoD}_{$CampoPesq}_t' class='m_coluna_t'  size='1' title='Informe a ordem da coluna para exibição' style='font-size:10px; margin-left:5px; margin-left:3px; width:10px; height:10px;  {$aparece}' >";
                echo " </div>  ";




                //echo " <div style='float:left;'>  ";
                //echo "<input type='text' id='{$GrupoD}_{$CampoPesq}_t' value='' size='1'  style='width:16px; height:16px;  {$aparece}' >";
                //echo " </div>  ";
                echo " </td>  ";
                if ($cont == $colgrupo) {
                    echo " </tr>  ";
                    $cont = 0;
                }

                //echo "</table>";
            }
            echo "</table>";
            echo '</td>';
        }
        echo '</tr>';

        echo '</table>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo "<td colspan='{$colg}' class='barra_colunas_f' >";

        echo '<table width="100%" border="0" cellspacing="0" cellpadding="2">';
        echo '<tr>';
        echo "<td colspan='3' style='font-size:11px; '>";
        echo " <div style='float:left;'>  ";
        $post_pesquisa = base64_encode(serialize($_POST));
        //$post_pesquisa = str_replace('"','#',$post_pesquisa);

        $get_pesquisa = base64_encode(serialize($_GET));
        //$get_pesquisa  = str_replace('"','#',$get_pesquisa);
        //
		$codigo_pesquisa = "";
        $descricao_pesquisa = $campo_caption_sel;
        //  $menu
        $onclick = ' onclick=" return GuardaFavoritos(' . "'" . $post_pesquisa . "', '" . $get_pesquisa . "', '" . $codigo_pesquisa . "', '" . $descricao_pesquisa . "', '" . $menu . "'" . '); " ';
        echo '<img ' . $onclick . '  title="Adiciona Parãmetros em Favoritos" style="cursor:pointer;  padding:5px;" src="imagens/add-favoritos.png" width="24" height="24"  border="0" />';
        echo '</div>';

        echo "<div style='float:left; padding-top:15px;'>";
        echo "Relatórios Favoritos:";
        echo '</div>';

        echo "</td>";
        echo "</tr>";

        $vetPesq = Array();
        $vetPesq = BuscaFavoritos($menu);
        //echo 'Mostrar Seleção';
        foreach ($vetPesq as $ordem => $vetvalue) {
            $idt_pesquisa = $vetvalue['idt'];
            $codigo = $vetvalue['codi'];
            $descricao = $vetvalue['desc'];
            $texto = $vetvalue['texto'];


            echo "<tr id='fa_{$idt_pesquisa}' >";
            echo "<td style=' width:4%' >";

            echo " <div style='float:left; cursor:pointer;   '>  ";
            $onclick = " onclick=' return ExcluiFavoritos({$idt_pesquisa}); '";
            echo '<img ' . $onclick . '  title="Exclui Favorito" style="cursor:pointer;  padding:5px;" src="imagens/bt_limpar.png"  width="16" height="16"  border="0" />';
            echo " </div>  ";
            echo "</td>";

            echo "<td style=' width:2%' >";
            echo " <div style='float:left;  cursor:pointer; padding-top:5px;   xborder:1px solid red; '>  ";

            $onclick = " onclick=' return SelecionaFavoritos({$idt_pesquisa}); '";
            //echo '<img '.$onclick.'  title="Seleciona Favorito" style="cursor:pointer;  padding:5px;" src="imagens/selecionarfavorito.png" width="24" height="24"  border="0" />';

            echo "<input {$onclick} title='Seleciona Favorito' style='cursor:pointer; ' type='checkbox' class='m_coluna_c' id='pesq_{$idt_pesquisa}'  name='{pesq_{$idt_pesquisa}}' value=''  > ";


            echo " </div>  ";
            echo "</td>";
            echo "<td style=' width:96%;' >";
            echo " <div style='float:left; padding-top:8px; xborder:1px solid red;  '>  ";

            echo $codigo . " - " . $descricao;

            echo " </div>  ";
            echo "</td>";
            echo '</tr>';
        }

        echo '</table>';

        echo '</td>';
        echo '</tr>';
    }

    $colg_r = count($vetTabelasREL);
    if ($colg_r > 0) {
        $vetAGrupar = $vetTabelasREL['GR']; // Parâmetros Gerais
        $vetG = $vetTabelasREL['GR'];
        $vetC = $vetTabelasREL['CL'];
        $vetT = $vetTabelasREL['TO'];

        $titulo = "Agrupamento";
        $colgw = 2;
        echo '<tr>';

        echo "<td colspan='{$colgw}' class='barra_agrupamento' style='width:100%; background:#F1f1F1; color:000000;'>";

        echo "<div id='agrupamento' style='float:left; width:25%; border-right:1px solid#C0C0C0;'>";
        echo " Agrupamento ";
        echo "</div>";

        echo "<div id='totalizar' style='float:left; width:25%; border-right:1px solid#C0C0C0;'>";
        echo " Totalizar ";
        echo "</div>";

        echo "<div id='calcular' style='float:left; width:25%; '>";
        echo " Calcular ";
        echo "</div>";

        echo '</td>';
        echo '</tr>';

        echo '<tr>';
        // Agrupar
        echo "<td colspan='{$colgw}' class='barra_agrupamento_det' style='width:100%;'>";

        echo "<div id='agrupamento' style='float:left; width:25%;  border-right:1px solid#C0C0C0;'>";
        //~ /p($vetG);
        ForEach ($vetG as $num => $vet) {

            $campo = $vet['campo'];
            $Titulo = $vet['Titulo'];
            $checked = "";

            $idw = "agrupar{$num}";
            $vlo = $_POST[$idw];
            if ($vlo != '') {
                $checked = "checked";
            }
            echo "<input type='checkbox' name='agrupar{$num}' value='{$num}' {$checked}> {$Titulo}<br>";
        }
        echo "</div>";

        // Totalizar
        echo "<div id='totalizar' style='float:left; width:25%;'>";
        ForEach ($vetT as $num => $vet) {

            $campo = $vet['campo'];
            $Titulo = $vet['Titulo'];
            $checked = "";
            $idw = "totalizar{$num}";
            $vlo = $_POST[$idw];
            if ($vlo != '') {
                $checked = "checked";
            }
            echo "<input type='checkbox' name='totalizar{$num}' value='{$num}' {$checked}> {$Titulo}<br>";
        }
        echo "</div>";

        // Calcular
        echo "<div id='calcular' style='float:left; width:25%;  border-right:1px solid#C0C0C0;'>";
        ForEach ($vetC as $num => $vet) {

            $campo = $vet['campo'];
            $Titulo = $vet['Titulo'];
            $checked = "";
//			if ($vet['Selecionado']== 'S')
//			{
//				$checked = "checked";
//			}
            $idw = "calcular{$num}";
            $vlo = $_POST[$idw];
            if ($vlo != '') {
                $checked = "checked";
            }
            echo "<input type='checkbox' name='calcular{$num}' value='{$num}' {$checked}> {$Titulo}<br>";
        }
        echo "</div>";


        echo '</td>';
        echo '</tr>';
    }

    echo '<tr class="barra"> ';
    echo '<td colspan="2">';

    if ($pesquisar) {
        echo "<a href='#' onclick='document.frm.submit()' class='Titulo'>";

        if ($botao == '') {
            echo "<img src='imagens/botao_pesquisar_n.png' title='Executar Pesquisa para os Filtros' alt='Executar Pesquisa para os Filtros' border='0'>";
        } else {
            echo "<img src='{$botao}' title='{$botao_texto}' alt='{$botao_texto}' border='0'>";
        }

        echo "</a>";

        echo '<input id="BtPesquisaLimpar" type="Button" onclick="" value="Limpar Tudo" class="BtPesquisa" />';
        echo '<input id="BtPesquisaPadrao" type="Button" onclick="" value="Voltar ao Padrão" class="BtPesquisa" />';
    }

    if ($sel_coluna !== false) {
        echo '<input id="BtSelecionarColuna" type="Button" onclick="" value="Selecionar Colunas" class="BtPesquisa" />';
    }

    echo '</td>';
    echo '</tr>';

    echo '</table>';

    echo '<span id="agrupamento_modelo">';
    criar_combo_vet($vetGroupby, 'sql_groupby[]', '');
    echo '<span>-</span>';
    echo '</span>';

    echo '<span id="classificacao_modelo">';
    criar_combo_vet($vetOrderby, 'sql_orderby[]', '');

    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

    criar_combo_vet($vetOrderbyExtra, 'sql_orderby_extra[]', '');

    echo '<span>-</span>';
    echo '</span>';

    echo "</div>";
}

function BuscaFavoritos($menu) {
    $vetPesq = Array();
    $sql = '';
    $sql .= ' select *';
    $sql .= ' from plu_pesquisa plu_p';
    $sql .= ' where idt_proprietario = ' . null($_SESSION[CS]['g_id_usuario']);
    $sql .= '   and funcao           = ' . aspa($menu);
    $sql .= ' order by codigo ';
    $rs = execsql($sql);
    $ordem = 0;
    foreach ($rs->data as $row) {
        $idt = $row['idt'];
        $codigo = $row['codigo'];
        $descricao = $row['descricao'];
        $post_slv = $row['post_slv'];
        $get_slv = $row['get_slv'];
        $data_criacao = $row['data_criacao'];
        $funcao = $row['funcao'];
        $ordem = $ordem + 1;
        $vetPesq[$ordem]['idt'] = $idt;
        $vetPesq[$ordem]['codi'] = $codigo;
        $vetPesq[$ordem]['desc'] = $descricao;
        $vetPesq[$ordem]['post_slv'] = $post_slv;
        $vetPesq[$ordem]['get_slv'] = $get_slv;
        $vetPesq[$ordem]['data_criacao'] = $data_criacao;
        $vetPesq[$ordem]['funcao'] = $funcao;
    }
    return $vetPesq;
}

function codigo_filtro_fixo($so_utilizado = false) {
    global $vetFiltro, $ordFiltro, $cont_arq, $campoDescListarCmb;

    $html = '';
    $tabela = false;

    if (count($vetFiltro) <= 0)
        return;

    $idx = -1;
    ForEach ($vetFiltro as $Filtro) {
        if ($ordFiltro) {
            $idx++;
            $vl = $Filtro['id'] . $idx;
        } else {
            $vl = $Filtro['id'];
        }

        echo '<input type="hidden" name="' . $vl . '" value="' . $Filtro['valor'] . '">';

        if ($Filtro['rs'] == '' || $Filtro['rs'] == 'Hidden') {
            if ($Filtro['tabela'] != '' && $Filtro['campo'] != '') {
                if ($Filtro['id_select'] == '') {
                    $Filtro['id_select'] = $Filtro['id'];
                }

                $asTabela = ($Filtro['id_tabela'] == '' ? '' : $Filtro['id_tabela'] . '.');
                $sql = 'select ' . $Filtro['campo'] . ' from ' . $Filtro['tabela'] . ' where ' . $asTabela . $Filtro['id_select'] . ' = ' . $Filtro['valor'];
                $rs = execsql($sql);

                if ($so_utilizado) {
                    $mostra = $rs->rows > 0;
                } else {
                    $mostra = true;
                }

                if ($mostra) {
                    $row = $rs->data[0];
                    $tabela = true;
                    $html .= '<tr><td class="Tit_Campo_Obr" align="right">' . $Filtro['nome'] . ':&nbsp;</td><td class="Texto">';

                    for ($x = 0; $x < $rs->cols; $x++) {
                        if ($rs->info['type'][$x] == 'date' || $rs->info['type'][$x] == 'datetime')
                            $html .= trata_data($row[$x]);
                        else
                            $html .= $row[$x];

                        if ($x < $rs->cols - 1)
                            $html .= ' - ';
                    }

                    $html .= '</td></tr>';
                }
            }
        } else if ($Filtro['rs'] == 'Texto') {
            if ($so_utilizado) {
                $mostra = $Filtro['valor'] != '';
            } else {
                $mostra = true;
            }

            if ($mostra) {
                $tabela = true;
                $html .= '<tr><td class="Tit_Campo_Obr" align="right">' . $Filtro['nome'] . ':&nbsp;</td><td class="Texto">';
                $html .= $Filtro['valor'];
                $html .= '</td></tr>';
            }
        } else if ($Filtro['rs'] == 'ListarCmb') {
            if ($so_utilizado) {
                $mostra = $Filtro['valor'] != '';
            } else {
                $mostra = true;
            }

            if ($mostra) {
                $tabela = true;
                $html .= '<tr><td class="Tit_Campo_Obr" align="right">' . $Filtro['nome'] . ':&nbsp;</td><td class="Texto">';

                $vetFRO = includeListarCmb('listar_cmb/' . $Filtro['arq'] . '.php');

                $sql = '';
                $sql .= ' select t.' . $campoDescListarCmb;
                $sql .= ' from (' . $vetFRO['sql'] . ') t';
                $sql .= ' where t.' . $Filtro['id_select'] . ' = ' . aspa($Filtro['valor']);
                $rs = execsql($sql);
                $desc = $rs->data[0][0];

                switch ($rs->info['type'][$campoDescListarCmb]) {
                    case 'numeric':
                    case 'decimal':
                    case 'newdecimal':
                    case 'double':
                        $html .= format_decimal($desc);
                        break;

                    case 'date':
                    case 'datetime':
                    case 'timestamp':
                        $html .= trata_data($desc);
                        break;

                    default:
                        $html .= $desc;
                        break;
                }

                $html .= '</td></tr>';
            }
        } else if (is_array($Filtro['rs'])) {
            $tabela = true;

            $html .= '<tr><td class="Tit_Campo_Obr" align="right">' . $Filtro['nome'] . ':&nbsp;</td><td class="Texto">';
            $html .= $Filtro['rs'][$Filtro['valor']];
            $html .= '</td></tr>';
        } else {
            if ($Filtro['rs']->rows == 1 && $esconde) {
                
            } else {
                $html_valor = '';

                ForEach ($Filtro['rs']->data as $row) {
                    if ($Filtro['valor'] == $row[0]) {
                        for ($x = 1; $x < $Filtro['rs']->cols; $x++) {
                            $html_valor .= str_replace("'", "\'", $row[$x]);
                            if ($x < $Filtro['rs']->cols - 1)
                                $html_valor .= ' - ';
                        }
                        break;
                    }
                }

                if ($so_utilizado) {
                    $mostra = $html_valor != '';
                } else {
                    $mostra = true;
                }

                if ($mostra) {
                    $tabela = true;
                    $html .= '<tr><td class="Tit_Campo_Obr" align="right">' . $Filtro['nome'] . ':&nbsp;</td><td class="Texto">';
                    $html .= $html_valor;
                    $html .= '</td></tr>';
                }
            }
        }
    }

    if ($tabela) {
        $style = '';
        if ($cont_arq != '')
            $style = 'style="margin-top: 0px;"';
        echo '<table id="Tabela_Filtro" border="0" cellspacing="0" cellpadding="0" ' . $style . '>';
        echo $html;
        echo '</table><br>';
    }
}

function ErroArq($Campo) {
    switch ($_FILES[$Campo]['error']) {
        case UPLOAD_ERR_OK:
            return "OK";
//break;
        case UPLOAD_ERR_INI_SIZE:
            return "O arquivo ultrapassou o limite de tamanho de (Ini) " . ini_get('upload_max_filesize') . ".";
//break;
        case UPLOAD_ERR_FORM_SIZE:
            return "O arquivo ultrapassou o limite de tamanho de (post) " . $_POST['MAX_FILE_SIZE'] . " bytes.";
//break;
        case UPLOAD_ERR_PARTIAL:
            return "O upload do arquivo foi feito parcialmente.";
//break;
        case UPLOAD_ERR_NO_FILE:
            return "Não foi feito o upload do arquivo.";
//break;
    }
}

function ImagemProd($nlargura, $naltura, $Dir, $Foto, $Prefixo = '', $Link = False, $desc = '', $js = '') {
    global $dir_style;

//echo ' mmmmmmmmmm  d '.$Dir;
//echo ' mmmmmmmmmm  f '.$Foto;

    if ((file_exists($Dir . $Foto) || substr(trim($Dir), 0, 7) == 'http://') && $Foto != '') {
        $ImageSize = GetImageSize($Dir . $Foto);

        if ($desc === '') {
            if (is_numeric($Prefixo)) {
                $tam = $Prefixo;
            } else {
                $tam = strlen($Prefixo);
            }

            $nome = substr($Foto, $tam);
        } else if ($desc !== false) {
            $nome = $desc;
        }

        $vet = explode('.', $Foto);
        $extensao = mb_strtolower($vet[count($vet) - 1]);

        if (is_array($ImageSize)) {
            imgNewSize($ImageSize, $nlargura, $naltura);

            if ($extensao == 'swf')
                echo "
                    <object width='$nlargura' height='$naltura' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0'>
                        <param name=movie value='$Dir$Foto'>
                        <param name=loop value=true>
                        <param name=menu value=false>
                        <param name=quality value=best>
                        <embed
                            src='$Dir$Foto'
                            width='$nlargura' height='$naltura' loop=true menu=false quality=best type='application/x-shockwave-flash'
                            pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash'>
                        </embed>
                    </object>
                ";
            else
                echo "<img border='0' src='$Dir$Foto' width='$nlargura' height='$naltura' {$js} title='$nome'  alt='$nome' style='vertical-align: middle; margin-bottom: 3px;'>";

            if ($Link)
                echo '<br>';
        } else {
            if (!$Link)
                $Link = 'img';
        }

        if ($Link || $Link == 'img') {
            switch ($extensao) {
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
                    $Extensao = $extensao;
                    break;
                default:
                    $Extensao = "default.icon";
                    break;
            }

            if ($Link === 'img')
                echo '
                    <img border="0" style="vertical-align: middle; margin-bottom: 3px; margin-right:4px;" {$js} src="' . $dir_style . 'imagens/arquivo/' . $Extensao . '.gif">' . $nome . '
                ';
            else
                echo '
                    <a class="FileLink" target="_blank" href="' . $Dir . $Foto . '">
                    <img border="0" style="vertical-align: middle; margin-bottom: 3px; margin-right:4px;" {$js} src="' . $dir_style . 'imagens/arquivo/' . $Extensao . '.gif">' . $nome . '
                    </a>
                ';
        }
    } else if ($Foto != '') {
        echo "<img border='0' {$js} src='" . $dir_style . "imagens/sem_img.jpg' alt='$nome' style='vertical-align: middle; margin-bottom: 3px;'>";
    }
}

function ArquivoLink($Dir, $Foto, $Prefixo = '', $desc = '', $js = '', $return = false) {
    global $dir_style;

    $html = '';

    if (file_exists($Dir . $Foto) && $Foto != '') {
        if ($desc === '') {
            if (is_numeric($Prefixo)) {
                $tam = $Prefixo;
            } else {
                $tam = strlen($Prefixo);
            }

            $nome = substr($Foto, $tam);
        } else if ($desc !== false) {
            $nome = $desc;
        }

        $vet = explode('.', $Foto);
        $extensao = mb_strtolower($vet[count($vet) - 1]);

        switch ($extensao) {
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
                $Extensao = $extensao;
                break;
            default:
                $Extensao = "default.icon";
                break;
        }

        $html .= '
            <a class="FileLink" target="_blank" href="' . $Dir . $Foto . '">
            <img border="0" style="vertical-align: middle; margin-bottom: 3px; margin-right:4px;" {$js} src="' . $dir_style . 'imagens/arquivo/' . $Extensao . '.gif">' . $nome . '
            </a>
        ';
    }

    if ($return) {
        return $html;
    } else {
        echo $html;
    }
}

function ImagemProdListarConf($max, $Dir, $Foto, $Prefixo = False, $Link = False, $Return = False, $url = null, $so_icone = false) {
    $html = '';

    if (file_exists($Dir . $Foto) && $Foto != '') {
        $ImageSize = GetImageSize($Dir . $Foto);

        if (is_null($url))
            $url = $Dir . $Foto;
        else
            $url = url . $url;

        if ($Prefixo === False)
            $nome = '';
        else
            $nome = substr($Foto, strlen($Prefixo));

        if (is_array($ImageSize)) {
            $largura = $ImageSize[0];
            $altura = $ImageSize[1];

            if (($largura > $max || $altura > $max) && $max > 0) {
                if ($largura >= $altura) {
                    $naltura = ( $max / $largura ) * $altura;
                    $nlargura = ( $max / $largura ) * $largura;
                } else {
                    $nlargura = ( $max / $altura ) * $largura;
                    $naltura = ( $max / $altura ) * $altura;
                }
            } else {
                $nlargura = $largura;
                $naltura = $altura;
            }

            if (!$so_icone && false) { // não colocar a imgagem
                $html .= "<img border='0' src='$url' width='$nlargura' height='$naltura' alt='$nome'>";

                if ($Link) {
                    $html .= '<br>';
                }
            } else {
                $Link = True;
            }
        } else {
            $Link = True;
        }

        if ($Link) {
            switch (mb_strtolower(substr($Foto, -3))) {
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
                    $Extensao = mb_strtolower(substr($Foto, -3));
                    break;
                default:
                    $Extensao = "default.icon";
                    break;
            }

            if ($so_icone) {
                $html .= '
                    <a class="FileLink" target="_blank" href="' . $Dir . $Foto . '" title="' . $nome . '">
                    <img border="0" style="vertical-align: middle; margin-bottom: 3px; margin-right:4px;" src="imagens/arquivo/' . $Extensao . '.gif">
                    </a>
                ';
            } else {
                $html .= '
                    <a class="FileLink" target="_blank" href="' . $Dir . $Foto . '">
                    <img border="0" style="vertical-align: middle; margin-bottom: 3px; margin-right:4px;" src="imagens/arquivo/' . $Extensao . '.gif">' . $nome . '
                    </a>
                ';
            }
        }
    } else if ($Foto != '') {
        if (is_null($url))
            $url = 'imagens/sem_img.jpg';
        else
            $url = url . '/imagens/sem_img.jpg';

        $ImageSize = GetImageSize($url);

        $largura = $ImageSize[0];
        $altura = $ImageSize[1];

        if (($largura > $max || $altura > $max) && $max > 0) {
            if ($largura >= $altura) {
                $naltura = ( $max / $largura ) * $altura;
                $nlargura = ( $max / $largura ) * $largura;
            } else {
                $nlargura = ( $max / $altura ) * $largura;
                $naltura = ( $max / $altura ) * $altura;
            }
        } else {
            $nlargura = $largura;
            $naltura = $altura;
        }

        $html .= "<img border='0' src='$url' width='$nlargura' height='$naltura' alt='$nome'>";
    }

    if ($Return)
        return $html;
    else
        echo $html;
}

function ImagemProd_b64($nlargura, $naltura, $Dir, $Foto, $Prefixo = '', $Link = False, $desc = '', $js = '') {
    global $dir_style;

//echo ' mmmmmmmmmm  d '.$Dir;
//echo ' mmmmmmmmmm  f '.$Foto;

    if ((file_exists($Dir . $Foto) || substr(trim($Dir), 0, 7) == 'http://') && $Foto != '') {
        $ImageSize = GetImageSize($Dir . $Foto);

        if ($desc === '') {
            $nome = substr($Foto, strlen($Prefixo));
        } else if ($desc !== false) {
            $nome = $desc;
        }

        $vet = explode('.', $Foto);
        $extensao = mb_strtolower($vet[count($vet) - 1]);

        if (is_array($ImageSize)) {
            imgNewSize($ImageSize, $nlargura, $naltura);

            if ($extensao == 'swf') {
                echo "
                    <object width='$nlargura' height='$naltura' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0'>
                        <param name=movie value='$Dir$Foto'>
                        <param name=loop value=true>
                        <param name=menu value=false>
                        <param name=quality value=best>
                        <embed
                            src='$Dir$Foto'
                            width='$nlargura' height='$naltura' loop=true menu=false quality=best type='application/x-shockwave-flash'
                            pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash'>
                        </embed>
                    </object>
                ";
            } else {
// $imagedata = file_get_contents("/path/to/image.jpg");
// alternatively specify an URL, if PHP settings allow
// $base64 = base64_encode($imagedata);
// <img src="data:image/gif;base64,' . base64_decode($imagedata) . '" />
                $dirimg = $Dir . $Foto;
// echo "vvvvvvvvvvvvvvvvvvvvvvvvvvvv ".$dirimg;
                $imagedata = file_get_contents($dirimg);
//  echo "ffffffffff ".$imagedata;
//             //  echo "<img border='0' src='$Dir$Foto' width='$nlargura' height='$naltura' {$js} title='$nome'  alt='$nome' style='vertical-align: middle; margin-bottom: 3px;'>";
// $extensao

                echo "<img border='0' src='data:image/{$extensao};base64," . base64_encode($imagedata) . "' width='$nlargura' height='$naltura' {$js} title='$nome'  alt='$nome' style='vertical-align: middle; margin-bottom: 3px;'>";
            }
            if ($Link)
                echo '<br>';
        } else {
            if (!$Link)
                $Link = 'img';
        }

        if ($Link || $Link == 'img') {
            switch ($extensao) {
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
                    $Extensao = $extensao;
                    break;
                default:
                    $Extensao = "default.icon";
                    break;
            }

            if ($Link === 'img')
                echo '
                    <img border="0" style="vertical-align: middle; margin-bottom: 3px; margin-right:4px;" {$js} src="' . $dir_style . 'imagens/arquivo/' . $Extensao . '.gif">' . $nome . '
                ';
            else
                echo '
                    <a class="FileLink" target="_blank" href="' . $Dir . $Foto . '">
                    <img border="0" style="vertical-align: middle; margin-bottom: 3px; margin-right:4px;" {$js} src="' . $dir_style . 'imagens/arquivo/' . $Extensao . '.gif">' . $nome . '
                    </a>
                ';
        }
    } else if ($Foto != '') {
        echo "<img border='0' {$js} src='" . $dir_style . "imagens/sem_img.jpg' alt='$nome' style='vertical-align: middle; margin-bottom: 3px;'>";
    }
}

function ImagemLink($nlargura, $naltura, $Dir, $Foto, $Desc, $menu, $id, $Link = '', $prefixo = 'detalhe') {
    global $dir_style;
    $img = "<img border='0' src='" . $dir_style . "imagens/sem_img.jpg' alt='$Desc' style='vertical-align: middle; margin-bottom: 3px;'>";

    if (file_exists($Dir . $Foto) && $Foto != '') {
        $ImageSize = GetImageSize($Dir . $Foto);
        $nome = substr($Foto, strlen($Prefixo));

        $vet = explode('.', $Foto);
        $extensao = mb_strtolower($vet[count($vet) - 1]);

        if (is_array($ImageSize)) {
            imgNewSize($ImageSize, $nlargura, $naltura);

            if ($extensao == 'swf')
                $img = "
                    <object width='$nlargura' height='$naltura' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0'>
                        <param name=movie value='$Dir$Foto'>
                        <param name=loop value=true>
                        <param name=menu value=false>
                        <param name=quality value=best>
                        <embed
                            src='$Dir$Foto'
                            width='$nlargura' height='$naltura' loop=true menu=false quality=best type='application/x-shockwave-flash'
                            pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash'>
                        </embed>
                    </object>
                ";
            else
                $img = "<img border='0' src='$Dir$Foto' width='$nlargura' height='$naltura' alt='$Desc' style='vertical-align: middle; margin-bottom: 3px;'>";
        }
    }

    if ($Link == '')
        echo '<a href="conteudo.php?prefixo=' . $prefixo . '&menu=' . $menu . '&id=' . $id . '">' . $img . '</a>';
    else
        echo '<a target="_blank" href="http://' . $Link . '">' . $img . '</a>';
}

function ImagemMostrar_erro_ie($nlargura, $naltura, $Dir, $Foto, $Desc = '', $return = false, $idt = '') {
    global $dir_style;
//$img = "<img border='0' src='".$dir_style."imagens/sem_img.jpg' title='$Desc' alt='$Desc' style='vertical-align: middle; margin-bottom: 3px;' {$idt}>";

    $img = "<img border='0' src='" . $dir_style . "imagens/sem_img.jpg' title='$Desc' alt='$Desc' {$idt}>";

    if (file_exists($Dir . $Foto) && $Foto != '') {
        $ImageSize = GetImageSize($Dir . $Foto);
        $nome = substr($Foto, strlen($Prefixo));

        $vet = explode('.', $Foto);
        $extensao = mb_strtolower($vet[count($vet) - 1]);

        $nlarguraw = $nlargura;
        $nalturaw = $naltura;


        if (is_array($ImageSize)) {
            imgNewSize($ImageSize, $nlargura, $naltura);

            if ($extensao == 'swf') {
                $img = "
                    <object width='$nlargura' height='$naltura' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0'>
                        <param name=movie value='$Dir$Foto'>
                        <param name=loop value=true>
                        <param name=menu value=false>
                        <param name=quality value=best>
                        <embed
                            src='$Dir$Foto'
                            width='$nlargura' height='$naltura' loop=true menu=false quality=best type='application/x-shockwave-flash'
                            pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash'>
                        </embed>
                    </object>
                ";
            } else {
                $img = "<img border='0' src='$Dir$Foto' width='$nlargura' height='$naltura' title='$Desc' alt='$Desc' style='vertical-align: middle; margin-bottom: 3px;' {$idt}>";
            }
        } else {
            switch ($extensao) {
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
                    $Extensao = $extensao;
                    break;
                default:
                    $Extensao = "default.icon";
                    break;
            }

            $img = '<a class="FileLink" target="_blank" href="' . $Dir . $Foto . '">';
//    $img .= '<img border="0" style="vertical-align: middle; margin-bottom: 3px; margin-right:4px;" src="'.$dir_style.'imagens/arquivo/'.$Extensao.'.gif">'.$nome;
            $img .= '<img border="0"  src="' . $dir_style . 'imagens/arquivo/' . $Extensao . '.gif">' . $nome;
            $img .= '</a>';
        }
    }

    if ($return)
        return $img;
    else
        echo $img;
}

function ImagemMostrar($nlargura, $naltura, $Dir, $Foto, $Desc = '', $return = false, $idt = '') {
    global $dir_style;
//$img = "<img border='0' src='".$dir_style."imagens/sem_img.jpg' title='$Desc' alt='$Desc' style='vertical-align: middle; margin-bottom: 3px;' {$idt}>";

    $img = "<img border='0' src='" . $dir_style . "imagens/sem_img.jpg' title='$Desc' alt='$Desc' {$idt}>";

    if (file_exists($Dir . $Foto) && $Foto != '') {
        $ImageSize = GetImageSize($Dir . $Foto);
        $nome = substr($Foto, strlen($Prefixo));

        $vet = explode('.', $Foto);
        $extensao = mb_strtolower($vet[count($vet) - 1]);

        $nlarguraw = $nlargura;
        $nalturaw = $naltura;


        if (is_array($ImageSize)) {
            imgNewSize($ImageSize, $nlargura, $naltura);

            if ($extensao == 'swf') {
                $img = "
                    <object width='$nlargura' height='$naltura' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0'>
                        <param name=movie value='$Dir$Foto'>
                        <param name=loop value=true>
                        <param name=menu value=false>
                        <param name=quality value=best>
                        <param name='wmode' value='transparent'></param>
                        <embed
                            wmode='transparent'
                            src='$Dir$Foto'
                            width='$nlargura' height='$naltura' loop=true menu=false quality=best type='application/x-shockwave-flash'
                            pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash'>
                        </embed>
                    </object>
                ";
            } else {
                $img = "<img border='0' src='$Dir$Foto' width='$nlargura' height='$naltura' title='$Desc' alt='$Desc' style='vertical-align: middle; margin-bottom: 3px;' {$idt}>";
            }
        } else {
            switch ($extensao) {
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
                    $Extensao = $extensao;
                    break;
                default:
                    $Extensao = "default.icon";
                    break;
            }

            $img = '<a class="FileLink" target="_blank" href="' . $Dir . $Foto . '">';
//    $img .= '<img border="0" style="vertical-align: middle; margin-bottom: 3px; margin-right:4px;" src="'.$dir_style.'imagens/arquivo/'.$Extensao.'.gif">'.$nome;
            $img .= '<img border="0"  src="' . $dir_style . 'imagens/arquivo/' . $Extensao . '.gif">' . $nome;
            $img .= '</a>';
        }
    }

    if ($return)
        return $img;
    else
        echo $img;
}

function ImagemMostrarPainel($nlargura, $naltura, $Dir, $Foto, $Desc = '', $attr = '', $return = false) {
    global $dir_style;

    if (!file_exists($Dir . $Foto) || $Foto == '') {
        $Dir = $dir_style . 'imagens/';
        $Foto = 'sem_img.png';
    }

    $ImageSize = GetImageSize($Dir . $Foto);

    if (is_array($ImageSize)) {
        imgNewSize($ImageSize, $nlargura, $naltura);

        $img = "<img border='0' src='$Dir$Foto' width='$nlargura' height='$naltura' title='$Desc' alt='$Desc' {$attr} />";
    }

    if ($return)
        return $img;
    else
        echo $img;
}

function imgNewSize($getimagesize, &$w, &$h = null, $percent = 0, $constrain = true) {
// get image size of img
    $x = $getimagesize;

// image width
    $sw = $x[0];
    if ($sw < $w)
        $w = $sw;
    if ($w == 0)
        $w = $sw;

// image height
    $sh = $x[1];
    if ($sh < $h)
        $h = $sh;
    if ($h == 0)
        $h = $sh;

    if (!isset($w) AND ! isset($h)) {
        $w = $sw;
        $h = $sh;
    }

    if ($percent > 0) {
// calculate resized height and width if percent is defined
        $percent = $percent * 0.01;
        $w = $sw * $percent;
        $h = $sh * $percent;
    } else {
        if (isset($w) AND ! isset($h)) {
// autocompute height if only width is set
            $h = (100 / ($sw / $w)) * .01;
            $h = round($sh * $h);
        } elseif (isset($h) AND ! isset($w)) {
// autocompute width if only height is set
            $w = (100 / ($sh / $h)) * .01;
            $w = round($sw * $w);
        } elseif (isset($h) AND isset($w) AND isset($constrain)) {
// get the smaller resulting image dimension if both height
// and width are set and $constrain is also set
            $hx = (100 / ($sw / $w)) * .01;
            $hx = round($sh * $hx);

            $wx = (100 / ($sh / $h)) * .01;
            $wx = round($sw * $wx);

            if ($hx < $h) {
                $h = (100 / ($sw / $w)) * .01;
                $h = round($sh * $h);
            } else {
                $w = (100 / ($sh / $h)) * .01;
                $w = round($sw * $w);
            }
        }
    }
}

function imgsize($img, $save, $w, $h = null, $constrain = true, $percent = 0) {
    /*
      JPEG / PNG Image Resizer
      Parameters (passed via URL):

      img = path / url of jpeg or png image file

      percent = if this is defined, image is resized by it's
      value in percent (i.e. 50 to divide by 50 percent)

      w = image width

      h = image height

      constrain = if this is parameter is passed and w and h are set
      to a size value then the size of the resulting image
      is constrained by whichever dimension is smaller

      Requires the PHP GD Extension

      Outputs the resulting image in JPEG Format

      By: Michael John G. Lopez - www.sydel.net
      Filename : imgsize.php
     */

// get image size of img
    $x = getimagesize($img);


    if ($x[0] == $w and $x[1] == $h) {  // não transforma
        copy($img, $save);

        return 1;
    }


// image width
    $sw = $x[0];
    if ($sw < $w)
        $w = $sw;

// image height
    $sh = $x[1];
    if ($sh < $h)
        $h = $sh;

    if (!isset($w) AND ! isset($h)) {
        $w = $sw;
        $h = $sh;
    }

    if ($percent > 0) {
// calculate resized height and width if percent is defined
        $percent = $percent * 0.01;
        $w = $sw * $percent;
        $h = $sh * $percent;
    } else {
        if (isset($w) AND ! isset($h)) {
// autocompute height if only width is set
            $h = (100 / ($sw / $w)) * .01;
            $h = round($sh * $h);
        } elseif (isset($h) AND ! isset($w)) {
// autocompute width if only height is set
            $w = (100 / ($sh / $h)) * .01;
            $w = round($sw * $w);
        } elseif (isset($h) AND isset($w) AND isset($constrain)) {
// get the smaller resulting image dimension if both height
// and width are set and $constrain is also set
            $hx = (100 / ($sw / $w)) * .01;
            $hx = round($sh * $hx);

            $wx = (100 / ($sh / $h)) * .01;
            $wx = round($sw * $wx);

            if ($hx < $h) {
                $h = (100 / ($sw / $w)) * .01;
                $h = round($sh * $h);
            } else {
                $w = (100 / ($sh / $h)) * .01;
                $w = round($sw * $w);
            }
        }
    }

    $im = ImageCreateFromJPEG($img) or // Read JPEG Image
            $im = ImageCreateFromPNG($img) or // or PNG Image
            $im = ImageCreateFromGIF($img) or // or GIF Image
            $im = false; // If image is not JPEG, PNG, or GIF

    if (!$im) {
// We get errors from PHP's ImageCreate functions...
// So let's echo back the contents of the actual image.
        copy($img, $save);
    } else {
// Create the resized image destination
        $thumb = ImageCreateTrueColor($w, $h);

        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);

// Copy from image source, resize it, and paste to image destination
        ImageCopyResampled($thumb, $im, 0, 0, 0, 0, $w, $h, $sw, $sh);
// Output resized image
        imagepng($thumb, $save);
    }
}

function verificar_existencia($cpfw, $senhaw, $msgw) {
    global $vetConf;
    $kokw = 0;
// entender se é CPF ou cnpj ou outro
    $tipo_usuario = 'A';
    if (validaCPF($cpfw) == true) {
// é cpf
        $tipo_usuario = 'F';
    } else {
// outro
    }
    $_SESSION[CS]['g_fornecedor'] = $tipo_usuario;
    if ($_SESSION[CS]['g_fornecedor'] == 'A') {   // tem que validar na base do portal
        $kokw = 1;
    } else {
// tem que validar o cpf
        $resp = Array();
        $cpfw = formatcpf($cpfw);
        $_POST['login'] = $cpfw;
        $sql = "select * from {$pre_table}plu_usuario where login = " . aspa($cpfw);
        $result = execsql($sql);
        $row = $result->data[0];
        if ($result->rows == 0) {
// não existe no cadastro de usuário
            $senha_padraow = $_SESSION[CS]['g_fornecedor_prisenha'];
            $login = $cpfw;
            $nome_completo = $cpfw;
            $email = '';
            $id_perfil = 4;
            $fornecedor = $_SESSION[CS]['g_fornecedor'];
            $senha = md5($senhaw);
            $dt_validade = null;
            $situacao_login = '00';
            $ativo = 'S';
            $confirma_login = 'S';
            if ($senhaw == $senha_padraow) {  // inclui
                $sql_i = ' insert into plu_usuario ';
                $sql_i .= ' (nome_completo, login, senha, ativo, id_perfil,dt_validade,email,fornecedor,confirma_login, situacao_login) values ( ';
                $sql_i .= aspa($nome_completo) . ' , ';
                $sql_i .= aspa($login) . ' , ';
                $sql_i .= aspa($senha) . ' , ';
                $sql_i .= aspa($ativo) . ' , ';
                $sql_i .= null($id_perfil) . ' , ';
                $sql_i .= aspa($dt_validade) . ' , ';
                $sql_i .= aspa($email) . ' , ';
                $sql_i .= aspa($fornecedor) . ' , ';
                $sql_i .= aspa($confirma_login) . ',  ';
                $sql_i .= aspa($situacao_login) . '  ';
                $sql_i .= ') ';
                $result = execsql($sql_i);
// buscar após inclusão
                $result = execsql($sql);
                if ($result->rows == 0) {
// erro não incluido
                    $kokw = 0;
                } else {  // incluido agora no usuário
                    $kokw = 2;
                }
            } else {
                $kokw = 1;
            }
        } else {   // existe
            $kokw = 1;
            $cpfw = formatcpf($cpfw);
// verificar se já tem curriculo
            $sql = "select idt from {$pre_table}curriculo_pessoa where cpf = " . aspa($cpfw);
            $result = execsql($sql);
            $row = $result->data[0];
            if ($result->rows == 0) {
// ainda não tem currículo
                $_SESSION[CS]['IDT_CURRICULO_PESSOA'] = '';
            } else {
// já possui currículo
                $_SESSION[CS]['IDT_CURRICULO_PESSOA'] = $row['idt'];
//p(' vvvvvvvvvvvvvvvvvv '.$_SESSION[CS]['IDT_CURRICULO_PESSOA']);
            }
        }
        if ($kokw != 0) {
            $_SESSION[CS]['CPF'] = $cpfw;
        }
    }
    return $kokw;
}

function calculaperiodos_anomes($mes_antw, $ano_antw, $mes_atuw, $ano_atuw) {
    $vetper = Array();

    $ano_antsw = '';
    $mes_antsw = '';
    if ($ano_antw . $mes_antw > $ano_atuw . $mes_atuw) {
        $ano_antsw = $ano_antw;
        $mes_antsw = $mes_antw;

        $ano_antw = $ano_atuw;
        $mes_antw = $mes_atuw;

        $ano_atuw = $ano_antsw;
        $mes_atuw = $mes_antsw;
    }

    $vmesnum = Array();
    $vmesnum['01'] = 'jan';
    $vmesnum['02'] = 'fev';
    $vmesnum['03'] = 'mar';
    $vmesnum['04'] = 'abr';
    $vmesnum['05'] = 'mai';
    $vmesnum['06'] = 'jun';
    $vmesnum['07'] = 'jul';
    $vmesnum['08'] = 'ago';
    $vmesnum['09'] = 'set';
    $vmesnum['10'] = 'out';
    $vmesnum['11'] = 'nov';
    $vmesnum['12'] = 'dez';

    $mes_i = $mes_antw;
    $ano_i = $ano_antw;
    $mes_idmi = $vmesnum[$mes_i];
    $mes_idma = mb_strtoupper($mes_idmi);

    $mes_c = $mes_atuw;
    $ano_c = $ano_atuw;
    $mes_cdmi = $vmesnum[$ano_atuw];
    $mes_cdma = mb_strtoupper($mes_cdmi);

    $mes_p = $mes_atuw;
    $ano_p = $ano_atuw;
    $mes_pdmi = $vmesnum[$mes_atuw];
    $mes_pdma = mb_strtoupper($mes_pdmi);

    $mes_f = $mes_p;
    $ano_f = $ano_p;
    $mes_fdmi = $mes_pdmi;
    $mes_fdma = $mes_pdma;

    $numeromeses = 0;

    $difano = $ano_f - $ano_i;
    if ($difano == 0) {
        $numeromeses = $mes_f - $mes_i;
    } else {
        $numeromeses = (13 - $mes_i);
        $numeromeses = $numeromeses + ($mes_f);
        if ($difano > 1) {
            $numeromeses = $numeromeses + ($difano - 1) * 12;
        }
    }
// gerar vetor
    $mes_t = $mes_i;
    $ano_t = $ano_i;
    $mes_tdmi = $mes_idmi;
    $mes_tdma = $mes_idma;
    $mes_n = $mes_i;
    $ano_n = $ano_t;

// inclusive os dois lados
    if ($ano_antw == $ano_atuw) {
        $numeromeses = $numeromeses + 1;
    }

    if ($numeromeses > 0) {
        for ($i = 1; $i <= $numeromeses; $i++) {
            $vetele = Array();
            $vetele['mes'] = $mes_t;
            $vetele['ano'] = $ano_t;
            $vetele['mes_mi'] = $mes_tdmi;
            $vetele['mes_ma'] = $mes_tdma;
            $vetper[$i] = $vetele;
            $mes_n = $mes_n + 1;
            if ($mes_n > 12) {
                $mes_n = 1;
                $ano_n = $ano_n + 1;
            }
            $mes_t = ZeroEsq($mes_n, 2);
            $ano_t = $ano_n;
            $mes_tdmi = $vmesnum[$mes_t];
            $mes_tdma = mb_strtoupper($mes_tdmi);
        }
    }
    echo 'numero de meses ' . $numeromeses;
    return $vetper;
}

function tem_direito_site($cod_funcao, $cod_direito = '') {
    global $target_js, $pre_table;

    $sql = 'select df.id_difu from ' . $pre_table . 'plu_site_direito_funcao df ';
    $sql .= ' inner join ' . $pre_table . 'plu_site_funcao f on f.id_funcao = df.id_funcao ';
    $sql .= ' inner join ' . $pre_table . 'plu_site_direito d on d.id_direito = df.id_direito ';
    $sql .= '  where f.cod_funcao = ' . aspa(mb_strtolower($cod_funcao));

    if ($cod_direito != '')
        $sql .= ' and d.cod_direito in (' . mb_strtolower($cod_direito) . ')';

    $result = execsql($sql);
    return !($result->rows == 0);
}

function DownloadGSD($pathw, $arquivow, $idtw, $texto, $style) {
    $href = "";
    $file = $pathw . $arquivow;
    $link = "incexecutaup.php?idt=" . $idtw . '&file=' . $file;
// $vett=explode('_',$arquivo);
// $arquivo = $vett[2];
    if (!file_exists($file) or $arquivow == '') {
//$href = $texto;
        $href = "<a style='{$style}'>" . $texto . '</a>';
    } else {
        $href = "<a href='$link' target='_blank' style='{$style}'>" . $texto . '</a>';
    }
    return $href;
}

function alinha_nm_funcao($nm_funcao, $cod_classificacao) {
    $str = '';
    $vetcla = Array();
    $vetcla = explode('.', $cod_classificacao);
    $tam = count($vetcla) - 1;
    $espaco = '&nbsp;&nbsp;&nbsp;';
    $brancos = str_repeat($espaco, $tam);
    $str = $brancos . $nm_funcao;
    return $str;
}

function menu_obra($idt_obra) {
    global $vetMenu, $vetMenuSub, $vetBarraMenu, $vetMenuAss, $vetEstado;
    $vetMenu = Array();
    $vetMenuSub = Array();
    $vetMenu1 = Array();
    $vetMenuSub1 = Array();
    $vetMenuAss1 = Array();
    $_SESSION[CS]['g_site_setor'] = '';
// ajustar a Obra
    $sql = 'select ';
    $sql .= '     sp.*, ';
    $sql .= '     sf.*, ';
    $sql .= '     sf.cod_funcao as sf_cod_funcao, ';
    $sql .= '     sf.nm_funcao as sf_nm_funcao ';
//  $sql .= '     seto.descricao as seto_descricao ';
    $sql .= ' from plu_site_perfil sp ';
    $sql .= ' inner join plu_site_direito_perfil sdp on sdp.id_perfil =  sp.id_perfil';
    $sql .= ' inner join plu_site_direito_funcao sdf on sdf.id_difu   =  sdp.id_difu';
    $sql .= ' inner join plu_site_funcao          sf on sf.id_funcao  =  sdf.id_funcao';
    $sql .= " where sts_menu='S' ";
    $sql .= ' and sp.id_perfil = ' . null($_SESSION[CS]['g_id_site_perfil']);


// $sql .= ' left  join sca_estrutura seto on seto.idt =  sf.idt_setor';
//    if ($idt_obra != 999 and $idt_obra != 888) {
// $sql .= ' where sp.idt_empreendimento = '.null($idt_obra);
// $sql .= " and   sts_menu='S' ";
// $sql .= " where sts_menu='S' ";
//    } else {
//if ($idt_obra == 999) {
//    $sql .= ' where sf.gestao='.aspa('S');
//} else {
//    $sql .= ' where sf.procedimento='.aspa('S');
//}
//    }

    $sql .= ' order by cod_classificacao ';
//p($sql);





    $rs = execsql($sql);


// exit();
    $en = 0;
    $duasw = '';
    $Vet_site_setor = Array();
    ForEach ($rs->data as $row) {
        $en = 1;
        $cod_classificacao = $row['cod_classificacao'];
        $cod_assinatura = $row['cod_assinatura'];
        $nm_funcao = $row['nm_funcao'];
        $cod_funcao = $row['cod_funcao'];
        $seto_descricao = $row['seto_descricao'];

        $Vet_site_setor[$cod_funcao] = $seto_descricao;

        $nivel = strlen($cod_classificacao);
        if ($nivel == 2) {
            $vetMenu1[$cod_funcao] = $nm_funcao;
            $cod_funcaow = $cod_funcao;
            $duasw = substr($cod_classificacao, 0, 2);
        } else {
            $duas = substr($cod_classificacao, 0, 2);
            if ($duas == $duasw) {
                $vetMenu1[$cod_funcao] = $nm_funcao;
                $vetMenuSub1[$cod_funcao] = $cod_funcaow;
            }
        }
        $vetMenuAss1[$cod_funcao] = $cod_assinatura;
    }



//p($vetMenuSub1);

    $_SESSION[CS]['g_site_setor'] = $Vet_site_setor;
    if ($en == 0) {
        $sql = 'select ';
        $sql .= '     * ';
        $sql .= ' from plu_site_funcao ';
        $sql .= " where sts_menu='S' ";

        /*
          if ($idt_obra != 999) {  // gestão Obra
          if ($idt_obra != 888) { // procedimento
          //  $sql .= " where sts_menu='S' ";
          } else {
          //  $sql .= ' where procedimento='.aspa('P');
          }
          } else {
          //  $sql .= ' where gestao='.aspa('S');
          }
         * 
         */

        $sql .= ' order by cod_classificacao ';
        $rs = execsql($sql);
        $cod_funcaow = '';
        ForEach ($rs->data as $row) {
            $cod_classificacao = $row['cod_classificacao'];
            $nm_funcao = $row['nm_funcao'];
            $cod_funcao = $row['cod_funcao'];
            $nivel = strlen($cod_classificacao);
            if ($nivel == 2) {
                $vetMenu1[$cod_funcao] = $nm_funcao;
                $cod_funcaow = $cod_funcao;
            } else {
                $vetMenu1[$cod_funcao] = $nm_funcao;
                $vetMenuSub1[$cod_funcao] = $cod_funcaow;
            }
        }
    }
// ajustar com o do usuário
    $g_id_site_perfil = $_SESSION[CS]['g_id_site_perfil'];
//
// Acessar perfil do site
//
    $todos = 'N';
    $sql = 'select ';
    $sql .= '     * ';
    $sql .= ' from plu_site_perfil ';
    $sql .= ' where id_perfil = ' . null($g_id_site_perfil);
//  echo 'nnnnn '.$sql;
    $rs = execsql($sql);
    $en = 0;
    ForEach ($rs->data as $row) {
        $en = 1;
        $todos = $row['todos'];
        $idt_empreendimento = $row['idt_empreendimento'];
    }
    if ($en == 1) {
        if ($todos != 'S') {
            $where = ' ( ';
            $or = '';
            ForEach ($vetMenu1 as $idx => $nome) {
                $where .= $or . ' cod_funcao = ' . aspa($idx);
                $or = ' or ';
            }
            $where .= ' ) ';
            $vetMenu1 = Array();
            $vetMenuSub1 = Array();
// ajustar a Obra
            $sql = 'select ';
            $sql .= '     sp.*, ';
            $sql .= '     sf.*, ';
            $sql .= '     sf.cod_funcao as sf_cod_funcao, ';
            $sql .= '     sf.nm_funcao as sf_nm_funcao ';
            $sql .= ' from plu_site_perfil sp ';
            $sql .= ' inner join plu_site_direito_perfil sdp on sdp.id_perfil =  sp.id_perfil';
            $sql .= ' inner join plu_site_direito_funcao sdf on sdf.id_difu   =  sdp.id_difu';
            $sql .= ' inner join plu_site_funcao          sf on sf.id_funcao  =  sdf.id_funcao';
            $sql .= ' where ';
            $sql .= '      sp.id_perfil = ' . null($g_id_site_perfil);
            $sql .= "   and sts_menu='S' ";
            $sql .= '   and ' . $where;
            $sql .= ' order by cod_classificacao ';
//p($sql);
// exit();

            $rs = execsql($sql);
            $en = 0;
            $duasw = '';
            ForEach ($rs->data as $row) {
                $en = 1;
                $cod_classificacao = $row['cod_classificacao'];
                $nm_funcao = $row['nm_funcao'];
                $cod_funcao = $row['cod_funcao'];
                $nivel = strlen($cod_classificacao);
                if ($nivel == 2) {
                    $vetMenu1[$cod_funcao] = $nm_funcao;
                    $cod_funcaow = $cod_funcao;
                    $duasw = substr($cod_classificacao, 0, 2);
                } else {
                    $duas = substr($cod_classificacao, 0, 2);
                    if ($duas == $duasw) {
                        $vetMenu1[$cod_funcao] = $nm_funcao;
                        $vetMenuSub1[$cod_funcao] = $cod_funcaow;
                    }
                }
            }
        }
    } else {
        $vetMenu1 = Array();
        $vetMenuSub1 = Array();
        $vetMenuAss1 = Array();
        if ($_SESSION[CS]['g_nome_completo'] != '') {
            $vetMenu1['sem_perfil'] = 'Usuário sem Perfil Definido';
        }
        $vetMenuSub1 = Array();
    }


//p($vetMenu1);

    $vetMenu = $vetMenu1;
    $vetMenuSub = $vetMenuSub1;
    $vetMenuAss = $vetMenuAss1;
    $_SESSION[CS]['g_vetMenu'] = $vetMenu;
    $_SESSION[CS]['g_vetMenuSub'] = $vetMenuSub;
    $_SESSION[CS]['g_vetMenuAss'] = $vetMenuAss;

    $vetMenuAss_nome = Array();
    $vetMenuAss_data = Array();

    $vetMenuAss_nome2 = Array();
    $vetMenuAss_data2 = Array();


    ForEach ($_SESSION[CS]['g_vetMenuAss'] as $mm_site => $cod_assinatura) {

        $cod_assinatura = '';
        if ($cod_assinatura != '') {
// última assinatura
            $sql = 'select ';
            $sql .= '     at.*, ';
            $sql .= '     us.nome_completo as us_nome ';
            $sql .= ' from assina_tela at ';
            $sql .= ' inner join usuario us on us.id_usuario =  at.idt_usuario';
            $sql .= ' where ';
            $sql .= '      at.idt_empreendimento = ' . null($idt_obra);
            $sql .= "   and at.status='F' ";
            $sql .= "   and at.assinatura = " . aspa($cod_assinatura);
            $sql .= ' order by idt_assina_controle desc , versao desc ';
//  $sql .= ' LIMIT 2  ';
//  p($sql);
            $rs = execsql($sql);

            $nome_assinante2 = '';
            $data_assinante2 = '';

            $nome_assinante = '';
            $data_assinante = '';
            $idt_assina_controle = 0;
            $qt = 0;
            ForEach ($rs->data as $row) {
                $qt = $qt + 1;
                if ($qt > 1) {
                    if ($idt_assina_controle == $row['idt_assina_controle'] and
                            $row['us_nome'] != $nome_assinante) {
                        $nome_assinante2 = $row['us_nome'];
                        $data_assinante2 = trata_data($row['data']);
                        break;
                    } else {
                        if ($idt_assina_controle != $row['idt_assina_controle']) {
                            break;
                        }
                    }
                } else {
// $data_assinante    =  substr(trata_data($row['data']),0,10);
                    $data_assinante = trata_data($row['data']);
                    $versao = $row['versao'];
                    $nome_assinante = $row['us_nome'];
                    $idt_assina_controle = $row['idt_assina_controle'];
                    $reabre = $row['reabre'];
                }
//break;
            }
            $vetReabreAss[$mm_site] = $reabre;
            $vetMenuAss_nome[$mm_site] = $nome_assinante;
            $vetMenuAss_data[$mm_site] = $data_assinante;

            $vetMenuAss_nome2[$mm_site] = $nome_assinante2;
            $vetMenuAss_data2[$mm_site] = $data_assinante2;
        }
    }


    $_SESSION[CS]['g_reabertura_ass'] = $vetReabreAss;

    $_SESSION[CS]['g_vetMenuAss_nome_ass'] = $vetMenuAss_nome;
    $_SESSION[CS]['g_vetMenuAss_data_ass'] = $vetMenuAss_data;

    $_SESSION[CS]['g_vetMenuAss_nome_ass2'] = $vetMenuAss_nome2;
    $_SESSION[CS]['g_vetMenuAss_data_ass2'] = $vetMenuAss_data2;



//  if ($debug || $_SESSION[CS]['g_vetBarraMenu'] == '') {
    $vetBarraMenu = $vetMenu;

    ForEach ($vetMenuSub as $idx => $col) {
        $vetBarraMenu[$idx] = $vetMenu[$col] . ' :: ' . $vetBarraMenu[$idx];
    }

    ForEach ($vetEstado as $idx => $col) {
        $vetBarraMenu['empreendimento_' . $idx] = 'Empreendimento :: ' . $col;
    }
    $_SESSION[CS]['g_vetBarraMenu'] = $vetBarraMenu;
// } else {
//      $vetBarraMenu = $_SESSION[CS]['g_vetBarraMenu'];
//  }
}

function help_campo($tabelaw, $campow, &$resumow, &$textow, &$descricaow) {
    global $sigla_site;
    $resumow = '';
    $textow = '';
    $kokw = 1;
    if ($tabelaw == '') {
        echo ' Informe a Tabela ';
        return 0;
    }
    if ($campow == '') {
        echo ' Informe o Campo ';
        return 0;
    }
    $sql = 'select ';
    $sql .= '  hc.*  ';
    $sql .= '  from plu_help_campo hc ';
    $sql .= '  where tabela=' . aspa($tabelaw);
    $sql .= '  and campo = ' . aspa($campow);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $sistema = aspa($sigla_site);
        $tabela = aspa($tabelaw);
        $campo = aspa($campow);
        $resumo = aspa(' Informar Resumo Help do Campo ');
        $texto = aspa(' ');
        $descricao = aspa($descricaow);

        $sql_i = ' insert into plu_help_campo ';
        $sql_i .= ' ( sistema, tabela, campo, resumo, texto, descricao)  values  ';
        $sql_i .= " ( $sistema, $tabela, $campo, $resumo, $texto, $descricao )";
        $result = execsql($sql_i);
        $sql = 'select ';
        $sql .= '  hc.*  ';
        $sql .= '  from plu_help_campo hc ';
        $sql .= '  where tabela=' . aspa($tabelaw);
        $sql .= '  and campo = ' . aspa($campow);
        $rs = execsql($sql);
        if ($rs->rows == 0) {
// erro
            $kokw = 0;
        } else {
            
        }
//p($rs);
    }
    $row = $rs->data[0];
    $descricaow = $row['descricao'];
    $resumow = $row['resumo'];
    $textow = $row['texto'];
    return $kokw;
}

function bt_volta_painel($pos) {
    global $menu, $prefixo;

    if ($prefixo != 'cadastro' && $prefixo != 'relatorio' && $_GET['painel_btvoltar_' . $pos] != 'N') { // && $_SESSION[CS]['g_abrir_sistema'] == ''
        switch ($_GET['origem_tela']) {
            case 'painel':
                $mostra_volta = true;
                $_SESSION[CS]['painel_volta'][$menu] = $_SESSION[CS]['painel_url_volta'][$_GET['cod_volta']];
                break;

            case 'painel_passo':
                $mostra_volta = true;
                break;

            case 'menu':
                $mostra_volta = false;
                $_SESSION[CS]['painel_volta'][$menu] = '';
                break;

            case 'upcad':
                $mostra_volta = true;
                break;

            case 'gocad':
                $mostra_volta = false;
                break;

            case 'cadastro':
                $mostra_volta = false;
                break;

            default:
                $mostra_volta = true;
                break;
        }

        if ($_SESSION[CS]['painel_volta'][$menu] != '' && $mostra_volta) {
            echo '<div class="bt_volta_painel bt_volta_painel_' . $pos . '">';

            if ($pos == 'top') {
                echo '<img src="imagens/bt_voltar.png" title="Voltar do Painel" onclick="self.location = \'' . $_SESSION[CS]['painel_volta'][$menu] . '\'" value="Voltar" class="Botao" />';
            } else {
                echo '<input type="Button" onclick="self.location = \'' . $_SESSION[CS]['painel_volta'][$menu] . '\'" value="Voltar" class="Botao" />';
            }

            echo '</div>';
        }
    }
}

function AutoNum($codigo, $tamanho_txt = 0, $so_consulta = false, $transacao = false, $banco_acao = '') {
    if ($transacao) {
        beginTransaction();
    }

    $sql = "select idt from {$banco_acao}plu_autonum where codigo = " . aspa($codigo) . ' FOR UPDATE';
    $rs = execsql($sql);
    $valor = $rs->data[0][0];

    if ($so_consulta) {
        if ($rs->rows == 0) {
            $valor = 1;
        } else {
            $valor = $valor + 1;
        }
    } else {
        if ($rs->rows == 0) {
            $valor = 1;
            $sql = "insert into {$banco_acao}plu_autonum (codigo, idt) values (" . aspa($codigo) . ", 1)";
        } else {
            $valor = $valor + 1;
            $sql = "update {$banco_acao}plu_autonum set idt = " . $valor . " where codigo = " . aspa($codigo);
        }

        execsql($sql);
    }

    if ($transacao) {
        commit();
    }

    if ($tamanho_txt > 0) {
        $valor = ZeroEsq($valor, $tamanho_txt);
    }

    return $valor;
}

function erro_try($msg, $tipo = 'php', $inf_extra = '') {
    $idt_erro_log = '';

    try {
        throw new Exception($msg);
    } catch (Exception $e) {
        grava_erro_log($tipo, $e, '', '', $inf_extra, $idt_erro_log);
    }

    return $idt_erro_log;
}

function CriaVetClassificacao($sqlOrderbyAuto) {
    $vetTmp = explode(',', $sqlOrderbyAuto);

    foreach ($vetTmp as $value) {
        $value = trim($value);
        $value = explode(' ', $value);

        if (count($value) == 1) {
            $_POST['sql_orderby'][] = $value[0];
            $_POST['sql_orderby_extra'][] = 'asc';
        } else {
            $extra = array_pop($value);
            $value = implode(' ', $value);

            $_POST['sql_orderby'][] = $value;
            $_POST['sql_orderby_extra'][] = $extra;
        }
    }
}

function alert($msg, $tipo = "A") {
    if ($tipo == 'A') {
        echo '<div class="alert ui-state-highlight ui-corner-all"><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>' . $msg . '</div>';
    } else {
        echo '<div class="alert ui-state-error ui-corner-all"><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>' . $msg . '</div>';
    }
}

/**
 * Salva o PDF gerado pela exportação do sistema e salva no path informado
 * @access public
 * @return array Vetor de Parametros da geração do PDF
 * @param string $pathPDF <p>
 * Path com nome do arquivo para salvar o PDF
 * </p>
 * @param array $vetParametro [opcional] <p>
 * Vetor de Parametros para a geração do PDF
 * </p>
 * */
function salvaPDF($pathPDF, $vetParametro = Array()) {
    global $vetConf;

    $return = '';

    require 'conteudo_pdf.php';

    return $return;
}

/**
 * Retorna o último dia útil do mes e ano informado
 * @access public
 * @return string Data no formato dd/mm/yyyy
 * @param int $mes <p>
 * Mês
 * </p>
 * @param int $ano <p>
 * Ano
 * </p>
 * */
function ultimoDiaUtil($mes, $ano) {
    $dias = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
    $ultimo = mktime(0, 0, 0, $mes, $dias, $ano);
    $dia = date("j", $ultimo);
    $dia_semana = date("w", $ultimo);

    // verifica sábado e domingo
    switch ($dia_semana) {
        case 0: //domingo
            $dia--;
            $dia--;
            break;

        case 6: //sábado
            $dia--;
            break;
    }

    $ultimo = mktime(0, 0, 0, $mes, $dia, $ano);
    return date("d/m/Y", $ultimo);
}

function GravaHelpDesk(&$vetParametros) {
    DadosEstacao($vetParametros);
    //
    DadosUsuario($vetParametros);

    $tabela = 'plu_helpdesk';
    $Campo = 'protocolo';
    $tam = 7;
    $codigow = geraAutoNum(db_pir_grc, $tabela . '_' . $Campo, $tam);
    $codigo = 'HD' . $codigow;
    $descricao = aspa($vetParametros['descricao']);
    $datadia = trata_data(date('d/m/Y H:i:s'));
    $protocolo = aspa($codigo);
    $login = aspa($_SESSION[CS]['g_login']);
    $nome = aspa($_SESSION[CS]['g_nome_completo']);
    $email = aspa($_SESSION[CS]['g_email']);
    $datahora = aspa(($datadia));
    $ip = aspa($_SERVER['REMOTE_ADDR']);
    $macroprocesso = 'null';
    $anonimo_nome = 'null';
    $anomimo_email = 'null';
    $titulo = aspa($vetParametros['titulo']);

    $navegador = aspa($vetParametros['navegador']);
    $tipo_dispositivo = aspa($vetParametros['mobile']);
    $modelo = aspa($vetParametros['modelo']);
    $status = aspa('A');
    $tipo_informacao = aspa('NA');
    $tipo_solicitacao = aspa('NA');
    $latitude = $_SESSION[CS]['latitude'];
    $longitude = $_SESSION[CS]['longitude'];
    if ($latitude == "") {
        $latitude = 0;
    }
    if ($longitude == "") {
        $longitude = 0;
    }
    if ($latitude == 0 and $longitude == 0) {
        $lalo = "Coordnada geográficas Não identificada";
    }

    $descricao = aspa($vetParametros['descricao']);
    $cpf = $vetParametros['cpf'];
    $emailT = $vetParametros['email'];
    $telefone = $vetParametros['telefone'];

    $complemento = "";
    $nome_completo = $_SESSION[CS]['g_nome_completo'];
    $complemento .= "NOME: {$nome_completo}<br />";
    $complemento .= "CPF: {$cpf} TELEFONE: {$telefone} EMAIL: {$emailT}";

    // Credenciado nan AOE

    $gec_en_credenciado_nan = $vetParametros['credenciado_nan'];

    if ($gec_en_credenciado_nan == 'S') {


        $tutor = $vetParametros['tutor'];
        $empresa_executora = $vetParametros['empresa_executora'];
        $ponto_atendimento = $vetParametros['ponto_atendimento'];
        $contrato = $vetParametros['contrato'];





        $complemento .= "<br /><br />";
        $complemento .= "-> AGENTE DE ORIENTAÇÃO EMPRESARIAL - AOE<br /><br />";
        $complemento .= "EMPRESA EXEECUTORA: {$empresa_executora}<br />";
        $complemento .= "TUTOR: {$tutor}<br />";
        $complemento .= "PONTO ATENDIMENTO: {$ponto_atendimento}<br />";
        $complemento .= "CONTRATO: {$contrato}<br />";
    }


    $matricula = $vetParametros['matricula'];
    if ($matricula != '') {
        $secao = $vetParametros['secao'];
        $cargo = $vetParametros['cargo'];
        $complemento .= "<br /><br />";
        $complemento .= "-> COLABORADOR DO SEBRAE<br /><br />";
        $complemento .= "SEÇÃO: {$secao}<br />";
        $complemento .= "CARGO: {$cargo}<br />";
        $complemento .= "MATRÍCULA: {$matricula}<br />";
    }
    $complemento = aspa($complemento);
    $status_helpdesk_usuario = aspa('Cadastrada no CRM');

    $sql_i = ' insert into plu_helpdesk ';
    $sql_i .= ' (  ';
    $sql_i .= " protocolo, ";
    $sql_i .= " login, ";
    $sql_i .= " nome, ";
    $sql_i .= " email, ";
    $sql_i .= " datahora, ";
    $sql_i .= " ip, ";
    $sql_i .= " latitude, ";
    $sql_i .= " longitude, ";
    $sql_i .= " macroprocesso, ";
    $sql_i .= " anonimo_nome, ";
    $sql_i .= " anomimo_email, ";
    $sql_i .= " navegador, ";
    $sql_i .= " tipo_dispositivo, ";
    $sql_i .= " modelo, ";
    $sql_i .= " status, ";
    $sql_i .= " tipo_solicitacao, ";
    $sql_i .= " status_helpdesk_usuario, ";
    //
    $sql_i .= " titulo, ";
    $sql_i .= " descricao, ";
    $sql_i .= " complemento ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $protocolo, ";
    $sql_i .= " $login, ";
    $sql_i .= " $nome, ";
    $sql_i .= " $email, ";
    $sql_i .= " $datahora, ";
    $sql_i .= " $ip, ";
    $sql_i .= " $latitude, ";
    $sql_i .= " $longitude, ";
    $sql_i .= " $macroprocesso, ";
    $sql_i .= " $anonimo_nome, ";
    $sql_i .= " $anomimo_email, ";
    $sql_i .= " $navegador, ";
    $sql_i .= " $tipo_dispositivo, ";
    $sql_i .= " $modelo, ";
    $sql_i .= " $status, ";
    $sql_i .= " $tipo_solicitacao, ";
    $sql_i .= " $status_helpdesk_usuario, ";

    $sql_i .= " $titulo, ";
    $sql_i .= " $descricao, ";
    $sql_i .= " $complemento ";
    $sql_i .= ') ';
    $result = execsql($sql_i);
    $idt_helpdesk = lastInsertId();
    //
    // Aberto o protocolo para registrar Chamado
    // Gerar Dados capturados da CS
    return $idt_helpdesk;
}

function GravaHelpDeskInteracao(&$vetParametros) {
    DadosEstacao($vetParametros);
    //
    DadosUsuario($vetParametros);

    // Acessar helpdesk
    $idt_helpdesk = $vetParametros['idt_helpdesk'];
    $sql = "select  ";
    $sql .= " plu_h.*  ";
    $sql .= " from plu_helpdesk plu_h ";
    $sql .= " where plu_h.idt = " . null($idt_helpdesk);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $numero_id_helpdesk_usuariow = "";
    } else {
        ForEach ($rs->data as $row) {
            $numero_id_helpdesk_usuariow = $row['numero_id_helpdesk_usuario'];
        }
    }
    $tabela = 'plu_helpdesk_interacao';
    $Campo = 'protocolo';
    $tam = 7;
    $codigow = geraAutoNum(db_pir_grc, $tabela . '_' . $Campo, $tam);
    $codigo = 'HI' . $codigow;
    $numero_id_helpdesk_usuario = aspa($numero_id_helpdesk_usuariow);
    $descricao = aspa($vetParametros['descricao']);
    $datadia = trata_data(date('d/m/Y H:i:s'));
    $protocolo = aspa($codigo);
    $login = aspa($_SESSION[CS]['g_login']);
    $nome = aspa($_SESSION[CS]['g_nome_completo']);
    $email = aspa($_SESSION[CS]['g_email']);
    $datahora = aspa(($datadia));
    $ip = aspa($_SERVER['REMOTE_ADDR']);
    $macroprocesso = 'null';
    $anonimo_nome = 'null';
    $anomimo_email = 'null';
    $titulo = aspa($vetParametros['titulo']);

    $navegador = aspa($vetParametros['navegador']);
    $tipo_dispositivo = aspa($vetParametros['mobile']);
    $modelo = aspa($vetParametros['modelo']);
    $status = aspa('A');
    $tipo_informacao = aspa('NA');
    $tipo_solicitacao = aspa('NA');
    $latitude = $_SESSION[CS]['latitude'];
    $longitude = $_SESSION[CS]['longitude'];
    if ($latitude == "") {
        $latitude = 0;
    }
    if ($longitude == "") {
        $longitude = 0;
    }
    if ($latitude == 0 and $longitude == 0) {
        $lalo = "Coordnada geográficas Não identificada";
    }

    $descricao = aspa($vetParametros['descricao']);
    $cpf = $vetParametros['cpf'];
    $emailT = $vetParametros['email'];
    $telefone = $vetParametros['telefone'];

    $complemento = "";
    $nome_completo = $_SESSION[CS]['g_nome_completo'];
    $complemento .= "NOME: {$nome_completo}<br />";
    $complemento .= "CPF: {$cpf} TELEFONE: {$telefone} EMAIL: {$emailT}";

    // Credenciado nan AOE

    $gec_en_credenciado_nan = $vetParametros['credenciado_nan'];

    if ($gec_en_credenciado_nan == 'S') {


        $tutor = $vetParametros['tutor'];
        $empresa_executora = $vetParametros['empresa_executora'];
        $ponto_atendimento = $vetParametros['ponto_atendimento'];
        $contrato = $vetParametros['contrato'];





        $complemento .= "<br /><br />";
        $complemento .= "-> AGENTE DE ORIENTAÇÃO EMPRESARIAL - AOE<br /><br />";
        $complemento .= "EMPRESA EXEECUTORA: {$empresa_executora}<br />";
        $complemento .= "TUTOR: {$tutor}<br />";
        $complemento .= "PONTO ATENDIMENTO: {$ponto_atendimento}<br />";
        $complemento .= "CONTRATO: {$contrato}<br />";
    }


    $matricula = $vetParametros['matricula'];
    if ($matricula != '') {
        $secao = $vetParametros['secao'];
        $cargo = $vetParametros['cargo'];
        $complemento .= "<br /><br />";
        $complemento .= "-> COLABORADOR DO SEBRAE<br /><br />";
        $complemento .= "SEÇÃO: {$secao}<br />";
        $complemento .= "CARGO: {$cargo}<br />";
        $complemento .= "MATRÍCULA: {$matricula}<br />";
    }
    $complemento = aspa($complemento);
    $idt_helpdesk = $vetParametros['idt_helpdesk'];
    $sql_i = ' insert into plu_helpdesk_interacao ';
    $sql_i .= ' (  ';
    $sql_i .= " idt_helpdesk, ";
    $sql_i .= " protocolo, ";
    $sql_i .= " login, ";
    $sql_i .= " nome, ";
    $sql_i .= " email, ";
    $sql_i .= " datahora, ";
    $sql_i .= " ip, ";
    $sql_i .= " latitude, ";
    $sql_i .= " longitude, ";
    $sql_i .= " macroprocesso, ";
    $sql_i .= " anonimo_nome, ";
    $sql_i .= " anomimo_email, ";
    $sql_i .= " navegador, ";
    $sql_i .= " tipo_dispositivo, ";
    $sql_i .= " modelo, ";
    $sql_i .= " status, ";
    $sql_i .= " tipo_solicitacao, ";
    //
    $sql_i .= " numero_id_helpdesk_usuario, ";
    $sql_i .= " titulo, ";
    $sql_i .= " descricao, ";
    $sql_i .= " complemento ";

    $sql_i .= '  ) values ( ';
    $sql_i .= " $idt_helpdesk, ";
    $sql_i .= " $protocolo, ";
    $sql_i .= " $login, ";
    $sql_i .= " $nome, ";
    $sql_i .= " $email, ";
    $sql_i .= " $datahora, ";
    $sql_i .= " $ip, ";
    $sql_i .= " $latitude, ";
    $sql_i .= " $longitude, ";
    $sql_i .= " $macroprocesso, ";
    $sql_i .= " $anonimo_nome, ";
    $sql_i .= " $anomimo_email, ";
    $sql_i .= " $navegador, ";
    $sql_i .= " $tipo_dispositivo, ";
    $sql_i .= " $modelo, ";
    $sql_i .= " $status, ";
    $sql_i .= " $tipo_solicitacao, ";
    $sql_i .= " $numero_id_helpdesk_usuario, ";
    $sql_i .= " $titulo, ";
    $sql_i .= " $descricao, ";
    $sql_i .= " $complemento ";
    $sql_i .= ') ';
    $result = execsql($sql_i);
    $idt_helpdesk_interacao = lastInsertId();
    //
    // Aberto o protocolo para registrar Chamado
    // Gerar Dados capturados da CS
    return $idt_helpdesk_interacao;
}

function DadosEstacao(&$vetParametros) {
    $mobile = "";
    $modelo = "DESKTOP";
    $user_agents = array("iPhone", "iPad", "Android", "webOS", "BlackBerry", "iPod", "Symbian", "IsGeneric");
    $navegador = $_SERVER['HTTP_USER_AGENT'];
    foreach ($user_agents as $user_agent) {
        if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE) {
            $mobile = "MOBILE";
            $modelo = $user_agent;
            break;
        }
    }
    if ($mobile == "") {
        $mobile = "NÃO É MOBILE";
    }
    $vetParametros['navegador'] = $navegador;
    $vetParametros['mobile'] = $mobile;
    $vetParametros['modelo'] = $modelo;
}

function DadosUsuario(&$vetParametros) {

    $vetParametros['cpf'] = $_SESSION[CS]['g_cpf'];
    $vetParametros['email'] = $_SESSION[CS]['g_email'];
    $vetParametros['telefone'] = $_SESSION[CS]['g_telefone'];

    $cpf = $_SESSION[CS]['g_cpf'];
    $sql = " select  ";
    $sql .= " gec_en.idt             as gec_en_idt,  ";
    $sql .= " gec_en.credenciado     as gec_en_credenciado, ";
    $sql .= " gec_en.credenciado_nan as gec_en_credenciado_nan ";
    $sql .= " from " . db_pir_gec . "gec_entidade gec_en ";
    $sql .= " where gec_en.codigo = " . aspa($cpf);
    $sql .= "   and reg_situacao  = " . aspa('A');
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $gec_en_idt = $row['gec_en_idt'];
        $gec_en_credenciado = $row['gec_en_credenciado'];
        $gec_en_credenciado_nan = $row['gec_en_credenciado_nan'];

        $vetParametros['credenciado_nan'] = $gec_en_credenciado_nan;


        if ($gec_en_credenciado_nan == 'S') {   // credenciado NAN 
            $sql = " select  ";
            $sql .= " grc_es.*,  ";

            $sql .= " grc_es.idt_tutor as grc_es_idt_tutor,  ";
            $sql .= " grc_es.idt_empresa_executora as grc_es_idt_empresa_executora,  ";
            $sql .= " grc_es.idt_contrato as grc_es_idt_contrato,  ";
            $sql .= " grc_es.idt_ponto_atendimento as grc_es_idt_ponto_atendimento,  ";
            //	

            $sql .= " plu_ut.nome_completo as plu_ut_nome_completo,  ";
            $sql .= " gec_en.descricao     as gec_en_descricao,  ";
            $sql .= " grc_co.descricao     as grc_co_descricao,  ";
            $sql .= " sca_or.descricao     as sca_or_descricao  ";
            //
            $sql .= " from grc_nan_estrutura grc_es ";

            $sql .= " left join plu_usuario plu_ut on plu_ut.id_usuario = grc_es.idt_tutor ";
            $sql .= " left join " . db_pir_gec . "gec_entidade gec_en on gec_en.idt = grc_es.idt_empresa_executora ";
            $sql .= " left join " . db_pir_gec . "gec_contratar_credenciado grc_co on grc_co.idt = grc_es.idt_contrato ";
            $sql .= " left join " . db_pir . "sca_organizacao_secao sca_or on sca_or.idt = grc_es.idt_ponto_atendimento ";
            $sql .= " where idt_usuario = " . null($_SESSION[CS]['g_id_usuario']);
            $rs = execsql($sql);
            ForEach ($rs->data as $row) {
                $vetParametros['idt_tutor'] = $row['grc_es_idt_tutor'];
                $vetParametros['tutor'] = $row['plu_ut_nome_completo'];
                $vetParametros['idt_empresa_executora'] = $row['grc_es_idt_empresa_executora'];
                $vetParametros['empresa_executora'] = $row['gec_en_descricao'];
                $vetParametros['idt_ponto_atendimento'] = $row['grc_es_idt_ponto_atendimento'];
                $vetParametros['ponto_atendimento'] = $row['sca_or_descricao'];
                $vetParametros['idt_contrato'] = $row['grc_es.idt_contrato'];
                $vetParametros['contrato'] = $row['grc_co_descricao'];
            }
        }
    }

    //////////// Interno - funcionário
    if ($_SESSION[CS]['g_cpf'] != '') {
        $cpfw = str_replace('-', '', $_SESSION[CS]['g_cpf']);
        $cpfw = str_replace('.', '', $cpfw);
        $cpfw = str_replace('/', '', $cpfw);
        $sql = " select  ";
        $sql .= " sca_op.*,  ";
        $sql .= " sca_op.codigo    as sca_op_codigo,  ";
        $sql .= " sca_or.descricao as sca_or_descricao,  ";
        $sql .= " sca_oc.descricao as sca_oc_descricao  ";

        //
        $sql .= " from " . db_pir . "sca_organizacao_pessoa sca_op ";
        $sql .= " left join " . db_pir . "sca_organizacao_secao sca_or on sca_or.idt = sca_op.idt_secao ";
        $sql .= " left join " . db_pir . "sca_organizacao_cargo sca_oc on sca_oc.idt = sca_op.idt_cargo ";
        $sql .= " where cpf = " . aspa($cpfw);
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $vetParametros['matricula'] = $row['sca_op_codigo'];
            $vetParametros['secao'] = $row['sca_or_descricao'];
            $vetParametros['cargo'] = $row['sca_oc_descricao'];
        }
    }
}

function SincronizaDeskSebrae(&$vetParametros) {
    global $vetConf;



    $vetTipoSolicitacaoHD = Array();
    $vetTipoSolicitacaoHD['PS'] = 'Problema no Sistema';
    $vetTipoSolicitacaoHD['RE'] = 'Dúvida do Sistema';


    $idt_helpdesk = $vetParametros['idt_helpdesk'];
    $sql = "select  ";
    $sql .= " plu_hd.*  ";
    $sql .= " from plu_helpdesk plu_hd ";
    $sql .= " where plu_hd.idt = {$idt_helpdesk} ";
    $rs = execsql($sql);
    $wcodigo = '';
    ForEach ($rs->data as $row) {
        $protocolo = $row['protocolo'];
        $descricao = $row['descricao'];
        $complemento = $row['complemento'];
        $datahora = $row['datahora'];
        $titulo = $row['titulo'];
        $login = $row['login'];
        $nome = $row['nome'];
        $ip = $row['ip'];
        $navegador = $row['navegador'];
        $tipo_dispositivo = $row['tipo_dispositivo'];
        $modelo = $row['modelo'];
        $descricao_tipo = $vetTipoSolicitacaoHD[$row['tipo_solicitacao']];
    }
    //
    // Arquivos anexos
    //
	$sql = "select  ";
    $sql .= " plu_hda.*  ";
    $sql .= " from plu_helpdesk_anexo plu_hda ";
    $sql .= " where plu_hda.idt_helpdesk = {$idt_helpdesk} ";
    $rs = execsql($sql);
    $wcodigo = '';
    $vetArquivos = Array();
    ForEach ($rs->data as $row) {
        $arquivo = $row['arquivo'];
        $descricao = $row['descricao'];
        $observacao = $row['observacao'];
        $dirorigem = 'obj_file/plu_helpdesk_anexo/';
        $vetA = Array();
        $vetA['dirorigem'] = $dirorigem;
        $vetA['arquivo'] = $arquivo;
        $vetA['descricao'] = $descricao;
        $vetA['observacao'] = $observacao;
        $vetArquivos[] = $vetA;
    }
    //p($vetArquivos);
    //
    // Enviar email para helpdesk Sebrae
    // guybete

    $loginad = "Não";
    if ($_SESSION[CS]['g_ldap'] == "S") {
        $loginad = "Sim";
    }
    $perfillogado = "";
    $sql = "select * from plu_perfil where id_perfil = " . null($_SESSION[CS]['g_id_perfil']);
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        $perfillogado = "ERRO. PERFIL NÃO PODE SER ENCONTRADO";
    } else {
        $row = $rs->data[0];
        $perfillogado = $row['nm_perfil'];
    }
    $vetSistemas = Array();
    $perfillogado = "";
    $sql = "select * from " . db_pir . "plu_usuario ";
    $sql .= " where login = " . aspa($login);
    $rs = execsql($sql);
    $erropir = "";
    if ($rs->rows == 0) {
        $erropir = "ERRO. SEM LOGIN NO PIR";
    } else {
        $row = $rs->data[0];
        $pir_id_usuario = $row['id_usuario'];
    }



    $assuntow = '[' . $protocolo . '] - ' . $descricao_tipo . ' - ' . $titulo;
    $datahoraw = trata_data($datahora);
    $mensagemw = 'SOLICITAÇÃO DE ATENDIMENTO<br />';
    $mensagemw .= 'Protocolo: ' . $protocolo . '<br />';
    $mensagemw .= 'Tipo de Solicitação: ' . $descricao_tipo . '<br />';
    $mensagemw .= 'Data: ' . $datahoraw . '<br />';
    $mensagemw .= 'Login: ' . $login . '<br />';
    $mensagemw .= 'Perfil do Usuário: ' . $perfillogado . '<br />';
    $mensagemw .= 'Login no AD?: ' . $loginad . '<br />';
    $mensagemw .= 'Sistemas e Ambientes de Acesso:<br />';
    ForEach ($vetSistemas as $codsist => $VetAtributos) {
        $NomeSistema = $VetAtributos['nome'];
        $Ambiente = $VetAtributos['ambiente'];
        $mensagemw .= "{$NomeSistema} - {$Ambiente}<br />";
    }
    $mensagemw .= 'Usuario: ' . $nome . '<br />';
    $mensagemw .= 'IP Usuario: ' . $ip . '<br />';
    $mensagemw .= 'Navegador: ' . $navegador . '<br />';
    $mensagemw .= 'Tipo do Dispositivo: ' . $tipo_dispositivo . '<br />';
    $mensagemw .= 'Modelo: ' . $modelo . '<br />';
    // $mensagemw .= 'Descrição: <pre>'.$descricao.'</pre><br /><br />';
    $mensagemw .= 'Descrição: ' . $descricao . '<br /><br />';
    //
    $mensagemw .= 'Informações do Usuário: <br />' . $descricao . '<br /><br />';
    //
    // p($vetConf);
    //
	$enviou_email = 0;
    $vetParametros = Array();
    //
    $banco_grava = db_pir_grc;
    $assunto = $assuntow;
    $mensagem = $mensagemw;
    //$para_email      = $vetConf['email_logerro'];

    $para_email = $vetConf['helpdesk_solicitacao'];


    $para_nome = "";
    $usa_protocolo = false;

    $vetRegProtocolo = Array();
    $de_email = '';
    $de_nome = '';
    $trata_erro = true;
    $enviou_email = enviarEmailHelpDesk($banco_grava, $assunto, $mensagem, $para_email, $para_nome, $usa_protocolo, $vetRegProtocolo, $de_email, $de_nome, $trata_erro, $vetArquivos, $vetParametros);
    //
    // Update da data de envio
    //
	// Data_envio_email_helpdesk
    //
	if ($enviou_email == 1) {
        $mandou_email_helpdesk = "Email Gerado com Sucesso ...";
    } else {
        $mandou_email_helpdesk = "Email Não Pode ser Gerado ...";
    }

    $msg_erro = $vetParametros['msg_erro'];
    $datadia = trata_data(date('d/m/Y H:i:s'));
    $sql = 'update plu_helpdesk set ';
    $sql .= ' msg_erro  = ' . aspa($msg_erro) . ", ";
    $sql .= ' status    = ' . aspa('R') . ", ";
    $sql .= ' mandou_email_helpdesk     = ' . aspa($mandou_email_helpdesk) . ", ";
    $sql .= ' data_envio_email_helpdesk = ' . aspa($datadia);
    $sql .= ' where idt                 = ' . null($idt_helpdesk);
    execsql($sql);

    //
}

function SincronizaDeskInteracaoSebrae(&$vetParametros) {
    global $vetConf;

    $vetTipoSolicitacaoHD = Array();
    $vetTipoSolicitacaoHD['PS'] = 'Problema no Sistema';
    $vetTipoSolicitacaoHD['RE'] = 'Dúvida do Sistema';


    $idt_helpdesk_interacao = $vetParametros['idt_helpdesk_interacao'];
    $sql = "select  ";
    $sql .= " plu_hdi.*  ";
    $sql .= " from plu_helpdesk_interacao plu_hdi ";
    $sql .= " where plu_hdi.idt = {$idt_helpdesk_interacao} ";
    $rs = execsql($sql);
    $wcodigo = '';
    ForEach ($rs->data as $row) {
        $protocolo = $row['protocolo'];
        $numero_id_helpdesk_usuario = $row['numero_id_helpdesk_usuario'];
        $descricao = $row['descricao'];
        $complemento = $row['complemento'];
        $datahora = $row['datahora'];
        $titulo = $row['titulo'];
        $login = $row['login'];
        $nome = $row['nome'];
        $ip = $row['ip'];
        $navegador = $row['navegador'];
        $tipo_dispositivo = $row['tipo_dispositivo'];
        $modelo = $row['modelo'];
        $descricao_tipo = $vetTipoSolicitacaoHD[$row['tipo_solicitacao']];
    }
    //
    // Arquivos anexos
    //
	$sql = "select  ";
    $sql .= " plu_hdia.*  ";
    $sql .= " from plu_helpdesk_interacao_anexo plu_hdia ";
    $sql .= " where plu_hdia.idt_helpdesk_interacao = {$idt_helpdesk_interacao} ";
    $rs = execsql($sql);
    $wcodigo = '';
    $vetArquivos = Array();
    ForEach ($rs->data as $row) {
        $arquivo = $row['arquivo'];
        $descricao = $row['descricao'];
        $observacao = $row['observacao'];
        $dirorigem = 'obj_file/plu_helpdesk_interacao_anexo/';
        $vetA = Array();
        $vetA['dirorigem'] = $dirorigem;
        $vetA['arquivo'] = $arquivo;
        $vetA['descricao'] = $descricao;
        $vetA['observacao'] = $observacao;
        $vetArquivos[] = $vetA;
    }
    //p($vetArquivos);
    //
    // Enviar email para helpdesk Sebrae
    // guybete

    $loginad = "Não";
    if ($_SESSION[CS]['g_ldap'] == "S") {
        $loginad = "Sim";
    }
    $perfillogado = "";
    $sql = "select * from plu_perfil where id_perfil = " . null($_SESSION[CS]['g_id_perfil']);
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        $perfillogado = "ERRO. PERFIL NÃO PODE SER ENCONTRADO";
    } else {
        $row = $rs->data[0];
        $perfillogado = $row['nm_perfil'];
    }
    $vetSistemas = Array();
    $perfillogado = "";
    $sql = "select * from " . db_pir . "plu_usuario ";
    $sql .= " where login = " . aspa($login);
    $rs = execsql($sql);
    $erropir = "";
    if ($rs->rows == 0) {
        $erropir = "ERRO. SEM LOGIN NO PIR";
    } else {
        $row = $rs->data[0];
        $pir_id_usuario = $row['id_usuario'];
    }



    $assuntow = '[' . $numero_id_helpdesk_usuario . ']' . '[' . $protocolo . ']' . ' - ' . $descricao_tipo . ' - ' . $titulo;
    $datahoraw = trata_data($datahora);
    $mensagemw = 'INTERAÇÃO DA SOLICITAÇÃO DE ATENDIMENTO<br />';
    $mensagemw .= 'Protocolo: ' . $protocolo . '<br />';
    $mensagemw .= 'Tipo de Solicitação: ' . $descricao_tipo . '<br />';
    $mensagemw .= 'Data: ' . $datahoraw . '<br />';
    $mensagemw .= 'Login: ' . $login . '<br />';
    $mensagemw .= 'Perfil do Usuário: ' . $perfillogado . '<br />';
    $mensagemw .= 'Login no AD?: ' . $loginad . '<br />';
    $mensagemw .= 'Sistemas e Ambientes de Acesso:<br />';
    ForEach ($vetSistemas as $codsist => $VetAtributos) {
        $NomeSistema = $VetAtributos['nome'];
        $Ambiente = $VetAtributos['ambiente'];
        $mensagemw .= "{$NomeSistema} - {$Ambiente}<br />";
    }
    $mensagemw .= 'Usuario: ' . $nome . '<br />';
    $mensagemw .= 'IP Usuario: ' . $ip . '<br />';
    $mensagemw .= 'Navegador: ' . $navegador . '<br />';
    $mensagemw .= 'Tipo do Dispositivo: ' . $tipo_dispositivo . '<br />';
    $mensagemw .= 'Modelo: ' . $modelo . '<br />';
    // $mensagemw .= 'Descrição: <pre>'.$descricao.'</pre><br /><br />';
    $mensagemw .= 'Descrição: ' . $descricao . '<br /><br />';
    //
    $mensagemw .= 'Informações do Usuário: <br />' . $descricao . '<br /><br />';
    //
    // p($vetConf);
    //
	$enviou_email = 0;
    $vetParametros = Array();
    //
    $banco_grava = db_pir_grc;
    $assunto = $assuntow;
    $mensagem = $mensagemw;
    //$para_email      = $vetConf['email_logerro'];

    $para_email = $vetConf['helpdesk_solicitacao'];


    $para_nome = "";
    $usa_protocolo = false;
    $vetRegProtocolo = Array();
    $de_email = '';
    $de_nome = '';
    $trata_erro = true;
    $enviou_email = enviarEmailHelpDesk($banco_grava, $assunto, $mensagem, $para_email, $para_nome, $usa_protocolo, $vetRegProtocolo, $de_email, $de_nome, $trata_erro, $vetArquivos, $vetParametros);
    //
    // Update da data de envio
    //
	// Data_envio_email_helpdesk
    //
	if ($enviou_email == 1) {
        $mandou_email_helpdesk = "Email Gerado com Sucesso ...";
    } else {
        $mandou_email_helpdesk = "Email Não Pode ser Gerado ...";
    }

    $msg_erro = $vetParametros['msg_erro'];
    $datadia = trata_data(date('d/m/Y H:i:s'));
    $sql = 'update plu_helpdesk_interacao set ';
    $sql .= ' status    = ' . aspa('R') . ", ";
    $sql .= ' msg_erro = ' . aspa($msg_erro) . ", ";
    $sql .= ' mandou_email_helpdesk     = ' . aspa($mandou_email_helpdesk) . ", ";
    $sql .= ' data_envio_email_helpdesk = ' . aspa($datadia);
    $sql .= ' where idt                 = ' . null($idt_helpdesk_interacao);
    execsql($sql);

    //
}

/**
 * Enviar email pelo PIR com protocolo
 * @access public
 * @return boolean|string Retorna TRUE se enviado com sucesso e em caso de erro retorna a mensagem do erro
 * @param string $banco_grava <p>
 * Nome do banco utilizado para enviar o email. Usar as costantes db_????
 * </p>
 * @param string $assunto <p>
 * Assunto do email
 * </p>
 * @param string $mensagem <p>
 * Mensagem do email
 * </p>
 * @param string $para_email <p>
 * Email do destinatário
 * </p>
 * @param string $para_nome <p>
 * Nome do destinatário
 * </p>
 * @param boolean $usa_protocolo [opcional] <p>
 * Informa de este email vai ter protocolo
 * </p>
 * @param array $vetRegProtocolo [opcional] <p>
 * Vetor de campos da tabela plu_email_log para dar o insert<br />
 * Vai voltar nesta variaval os dados inseridos na tabela
 * </p>
 * @param string $de_email [opcional] <p>
 * Email do remetente
 * </p>
 * @param string $de_nome [opcional] <p>
 * Nome do remetente
 * </p>
 * @param boolean $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * @param array $vetArquivos [opcional] <p>
 * Vetor com os arquivos para serem anexados ao email<br />
 * </p>
 * */
function enviarEmailHelpDesk($banco_grava, $assunto, $mensagem, $para_email, $para_nome, $usa_protocolo = false, &$vetRegProtocolo = Array(), $de_email = '', $de_nome = '', $trata_erro = true, $vetArquivos = Array(), &$vetParametros = Array()) {
    $sql = 'select * from ' . $banco_grava . 'plu_config';
    $rs = execsql($sql, $trata_erro);

    $vetConf = Array();

    ForEach ($rs->data as $row) {
        $vetConf[$row['variavel']] = trim($row['valor'] . ($row['extra'] == '' ? '' : ' ' . $row['extra']));
    }

    $vetPadrao = Array();

    if ($de_email == '') {
        $de_replay = $vetConf['helpdesk_email_site'];
        $de_email = $vetConf['helpdesk_email_envio'];
        $de_nome = $vetConf['helpdesk_email_nome'];

        if ($de_email == '') {
            $de_email = $de_replay;
        }
    }

    if ($usa_protocolo) {
        if ($vetRegProtocolo['protocolo'] == '') {
            $protocolo = date('dmYHis');
            $mensagem .= '<br/><br/>Protocolo de controle: ' . $protocolo;
        } else {
            $protocolo = $vetRegProtocolo['protocolo'];
        }

        $vetPadrao = Array(
            'protocolo' => $protocolo,
            'data_registro' => getdata(true, false, true),
            'email_origem' => $de_email,
            'nome_origem' => $de_nome,
            'email_destino' => $para_email,
            'nome_destino' => $para_nome,
            'msg_principal' => $mensagem,
            'confirmacao' => 'N',
            'enviado' => 'N',
        );

        if (is_array($vetRegProtocolo)) {
            foreach ($vetRegProtocolo as $key => $value) {
                $vetPadrao[$key] = $value;
            }
        }

        $sql_campo = Array();
        $sql_valor = Array();

        foreach ($vetPadrao as $key => $value) {
            $sql_campo[$key] = $key;
            $sql_valor[$key] = aspa($value);
        }

        if (count($sql_campo) > 0) {
            $sql = 'insert into ' . $banco_grava . 'plu_email_log (' . implode(', ', $sql_campo) . ') values (' . implode(', ', $sql_valor) . ')';
            execsql($sql, $trata_erro);
            $vetPadrao['idt'] = lastInsertId();
        }
    }

    require_once(lib_phpmailer . 'PHPMailerAutoload.php');

    //Create a new PHPMailer instance
    $mail = new PHPMailer;

    $mail->SetLanguage('br', lib_phpmailer);

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    /*
      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->CharSet = 'UTF-8';
      $mail->Host = "smtp.live.com";
      $mail->SMTPAuth= true;
      $mail->Port = 587;
      $mail->Username= $account;
      $mail->Password= $password;
      $mail->SMTPSecure = 'tls';
      $mail->From = $from;
      $mail->FromName= $from_name;
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body = $msg;
      $mail->addAddress($to);
     */

    $mail->IsSMTP();
    $mail->Host = $vetConf['helpdesk_host_smtp'];
    $mail->Port = $vetConf['helpdesk_port_smtp'];
    $mail->Username = $vetConf['helpdesk_login_smtp'];
    $mail->Password = $vetConf['helpdesk_senha_smtp'];
    $mail->SMTPAuth = !($vetConf['helpdesk_login_smtp'] == '' && $vetConf['helpdesk_senha_smtp'] == '');
    $mail->SMTPSecure = $vetConf['helpdesk_smtp_secure'];
    $mail->setFrom($de_email, $de_nome);
    $mail->AddReplyTo($de_replay, $de_nome);

    $mail->Subject = $assunto;
    $mail->msgHTML($mensagem);

    $vetTmp = explode(';', $para_email);

    foreach ($vetTmp as $value) {
        $mail->addAddress($value, $para_nome);
    }

    if (count($vetArquivos) > 0) {
        // Anexar arquivos ao email
        ForEach ($vetArquivos as $indice => $VetArq) {
            $dirorigem = $VetArq['dirorigem'];
            $arquivo = $VetArq['arquivo'];

            // anexar ao email
            $pathfile = $dirorigem . $arquivo;
            $mail->AddAttachment($pathfile);
        }
    }
    $vetParametros['msg_erro'] = "";
    $vetParametros['erro'] = 0;
    if ($mail->send()) {
        if ($usa_protocolo) {
            $vetPadrao['enviado'] = 'S';

            $sql = 'update ' . $banco_grava . 'plu_email_log set enviado  = ' . aspa($vetPadrao['enviado']);
            $sql .= ' where idt = ' . null($vetPadrao['idt']);
            execsql($sql, $trata_erro);
        }
        $vetParametros['erro'] = 1;
        $return = true;
    } else {
        $return = $mail->ErrorInfo;
        $vetPadrao['msg_erro'] = $return;
        $vetParametros['msg_erro'] = $return;
        //p($vetParametros);
        //exit();
        if ($usa_protocolo) {
            $sql = 'update ' . $banco_grava . 'plu_email_log set msg_erro  = ' . aspa($vetPadrao['msg_erro']);
            $sql .= ' where idt = ' . null($vetPadrao['idt']);
            execsql($sql, $trata_erro);
        }
    }
    //p($vetConf);
    //p($mail);
    //exit();

    $vetRegProtocolo = $vetPadrao;
    return $return;
}

/**
 * Separa o padrão do Excel os valores da Coluna e Linha
 * @access public
 * @return array Com a separação da Coluna e Linha
 * @param string $txt <p>
 * Texto no padrão Excel
 * </p>
 * */
function separaPadraoExcelColuna($txt) {
    $retorno = Array(
        'linha' => '',
        'coluna' => '',
    );

    $len = strlen($txt);

    for ($i = 0; $i < $len; $i++) {
        $tmp = $txt[$i];

        if (is_numeric($tmp)) {
            $retorno['coluna'] .= $tmp;
        } else {
            $retorno['linha'] .= $tmp;
        }
    }

    return $retorno;
}

function mkRange($start, $end) {
    $count = strToInt($end) - strToInt($start);
    $r = array();
    $idx = 1;

    do {
        $r[$idx++] = $start++;
    } while ($count--);

    return $r;
}

function strToInt($str) {
    $str = strrev($str);
    $dec = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        $dec += (base_convert($str[$i], 36, 10) - 9) * pow(26, $i);
    }
    return $dec;
}

// fim do programa

if (file_exists('funcao_ger.php')) {
    Require_Once('funcao_ger.php');
}

$t = mb_strtolower('funcao_' . $plu_sigla_interna . '.php');
if (file_exists($t)) {
    Require_Once($t);
}
    