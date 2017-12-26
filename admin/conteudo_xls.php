<?php
Require_Once('configuracao.php');

if ($_REQUEST['menu'] == '') {
    $menu = 'vazio';
} else {
    $menu = $_REQUEST['menu'];
}

if ($_REQUEST['prefixo'] == '') {
    $prefixo = 'inc';
} else {
    $prefixo = $_REQUEST['prefixo'];
}

if ($_REQUEST['titulo_rel'] == '') {
    $nome_titulo = 'exporta';
} else {
    $nome_titulo = $_REQUEST['titulo_rel'];
}

$menu_acesso = $menu;
$so_utilizado = true;

$vetCampo = Array();
$vetFiltro = Array();
$ordFiltro = true;
$vetOrderby = NULL;
$sqlOrderby = '';

$diretorio = 'listar_rel';
$path = $diretorio . '/' . $menu . '.php';

if (!file_exists($path)) {
    $diretorio = 'listar_conf';
}

$path = $diretorio . '/' . $menu . '.php';

if (file_exists($path)) {
    ob_start();
    Require_Once($path);
    ob_end_clean();
} else {
    echo "<br><br><div align='center' class='Msg'>Função em desenvolvimento...</div>";
    onLoadPag();
    FimTela();
    exit();
}

if (is_array($_POST['sql_orderby'])) {
    $sqlOrderby = Array();

    foreach ($_POST['sql_orderby'] as $idx => $value) {
        if ($value != '') {
            $t = trim($value . ' ' . $_POST['sql_orderby_extra'][$idx]);

            if ($t != '') {
                $sqlOrderby[] = $t;
            }
        }
    }

    $sqlOrderby = implode(', ', $sqlOrderby);
} else if ($_REQUEST['sqlOrderby'] != '') {
    $sqlOrderby = $_REQUEST['sqlOrderby'];
    CriaVetClassificacao($sqlOrderby);
}

if ($menu_acesso != '') {
    acesso($menu_acesso, '', true);
}

$handle = tmpfile();

$idx = -1;
ForEach ($vetFiltro as $Filtro) {
    $str = '';

    if ($ordFiltro) {
        $idx++;
        $vl = $Filtro['id'] . $idx;
    } else {
        $vl = $Filtro['id'];
    }

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

                $str .= $Filtro['nome'] . chr(9);

                for ($x = 0; $x < $rs->cols; $x++) {
                    if ($rs->info['type'][$x] == 'date' || $rs->info['type'][$x] == 'datetime')
                        $str .= trata_data($row[$x]);
                    else
                        $str .= $row[$x];

                    if ($x < $rs->cols - 1)
                        $str .= ' - ';
                }

                $str .= chr(9);
            }
        }
    } else if ($Filtro['rs'] == 'Texto') {
        if ($so_utilizado) {
            $mostra = $Filtro['valor'] != '';
        } else {
            $mostra = true;
        }

        if ($mostra) {
            $str .= $Filtro['nome'] . chr(9);
            $str .= $Filtro['valor'];
            $str .= chr(9);
        }
    } else if ($Filtro['rs'] == 'ListarCmb') {
        if ($so_utilizado) {
            $mostra = $Filtro['valor'] != '';
        } else {
            $mostra = true;
        }

        if ($mostra) {
            $str .= $Filtro['nome'] . chr(9);

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
                    $str .= format_decimal($desc);
                    break;

                case 'date':
                case 'datetime':
                case 'timestamp':
                    $str .= trata_data($desc);
                    break;

                default:
                    $str .= $desc;
                    break;
            }

            $str .= chr(9);
        }
    } else if (is_array($Filtro['rs'])) {
        $str .= $Filtro['nome'] . chr(9);
        $str .= $Filtro['rs'][$Filtro['valor']];
        $str .= chr(9);
    } else {
        if ($Filtro['rs']->rows > 1) {
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
                $str .= $Filtro['nome'] . chr(9);
                $str .= $html_valor;
                $str .= chr(9);
            }
        }
    }

    if ($str != '') {
        $str = strip_tags($str);
        fwrite($handle, $str . chr(13));
    }
}

fwrite($handle, chr(13));

$str = '';
ForEach ($vetCampo as $Campo => $Valor) {
    if ($uppertxtcab == 0) {
        $str .= mb_strtoupper($Valor['nome']) . chr(9);
    } else {
        $str .= $Valor['nome'] . chr(9);
    }
}

$str = strip_tags($str);
fwrite($handle, $str . chr(13));

if ($sqlOrderby != '') {
    $pos = strripos($sql, 'order by');

    if ($pos === false) {
        $sql .= ' order by ' . $sqlOrderby;
    }
}

$rs_tab_lst = execsql($sql);

foreach ($rs_tab_lst->data as $row) {
    $str = '';

    if ($rs->info['type'][$idCampo] == 'numeric') {
        $row[$idCampo] = (int) $row[$idCampo];
    }

    ForEach ($vetCampo as $strCampo => $Valor) {
        $tipo = explode(", ", $Valor['tipo']);
        $strCampo = explode(", ", $strCampo);

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

                case 'decimal':
                    $vlTD .= format_decimal($row[$Campo], $Valor['ndecimal']);
                    break;

                case 'inteiro':
                    $vlTD .= format_decimal($row[$Campo], 0);
                    break;

                case 'arquivo':
                    $vlTD .= $Valor['tabela'] . '/' . $row[$Campo];
                    break;

                case 'link':
                    $vlTD .= $row[$Campo];
                    break;


                case 'func_trata_dado':
                    $vlTD .= $Valor['vetDominio']($row[$Campo], $row, $Campo);
                    break;

                default:
                    $vlTD .= $row[$Campo];
                    break;
            }
        }

        $str .= $vlTD . chr(9);
    }

    $str = str_replace('<br>', ' / ', $str);
    $str = str_replace('<br />', ' / ', $str);
    $str = str_replace('<br/>', ' / ', $str);
    $str = str_replace(chr(10), ' / ', $str);
    $str = strip_tags($str);

    fwrite($handle, $str . chr(13));
}

header("Content-Type: application/vnd.ms-excel");
$fstat = fstat($handle);
header("Content-Length: " . $fstat['size']);
header("Content-Disposition: attachment; filename=" . troca_caracter($nome_titulo) . ".xls");
header("Content-Transfer-Encoding: binary");

fseek($handle, 0);
fpassthru($handle);

fclose($handle);
