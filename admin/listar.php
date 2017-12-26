<style>
    .barra_colunas{
        background:#FFFFFF;
        color:#000000;
        font-size:12px;
        border-top:1px solid #000000;
        border-bottom:1px solid #000000;
        text-align:left;
        padding-top:5px;
        padding-bottom:5px;
    }
    .barra_colunas_f{
        background:#FFFFFF;
        color:#000000;
        font-size:12px;

        border-bottom:1px solid #000000;
        text-align:left;
        margin-left:10px;
    }
</style>

<?php
/*
 * Atenção...
 * Quando fizer uma alteração aqui verificar se tem que alterar no arquivo conteudo_xls.php
 */

$vetCampo = Array();
$vetFiltro = Array();
$ordFiltro = true;
$vetOrderby = NULL;
$vetBtOrdem = Array();
$novo = true;
$edit = true;
$novoprefixo = 'cadastro';
$novomenu = '';
$Msg = '';
$Campo = '';
$num_col_tab = 1;
$listar_sql_limit = 500;
$paginacao_top = true;
$paginacao_bottom = true;
$extra_pagina = true;
$conSQL = $con;
$strPara = '';

$func_trata_rs = null;

$bt_print = true;
$bt_print_descricao = '';
$bt_print_img = 'imagens/bt_download_32.png';
$bt_print_title = 'Exportar Informação';
$bt_print_class = '';
$bt_print_tit_rel = $vetMenu[$menu];

$goCad = Array();
$upCad = '';
$vetBtBarra = Array();
$vetBtBarra_extra = Array();
$idCampo = 'idt';
$idCampoPar = 'idt';

$vetBtBarraListarRel = Array(
    'print' => true,
    'pdf' => true,
    'xls' => true,
    'fechar' => true,
);

$ListarBtSelecionar = 'Selecionar Registro';
$vetListarCmbRegValido = Array();
$filhoTotListarCmbMulti = Array();
$filhoCodListarCmbMulti = '';
$filhoSeparadorListarCmbMulti = '';
$btListarBtMarcarTodosMulti = true;
$btListarBtVoltarMulti = false;

$func_trata_row = '';

$parListarCmbDescricao = 'Instrução';
$parListarCmbCodigo = 'INSTRUCAO_LISTARCMB';
$comListarCmb = 'A';
$comListarCmbMulti = 'F';
$comListarCmb_SoVoltar = false;

$vetTabelas = Array();


$corimp = '#FFFFFF';
$corpar = '#F2F2F2';

$corcur = '#c4c9cd';

//$corover  = '#006B9F';
$corover = '#FF8080';

$_GET['pri'] = 'S';

$cormarca = '#D2D2D2';
$marcador = 'true';

$inc_chamada_barra = true;
$lista_td_acao_click = 'lista_td_acao_click';
$lista_td_cab_acao_click = 'lista_td_cab_acao_click';

$barra_inc = 'Incluir';
$barra_inc_h = 'Incluir um Novo Registro';
$barra_alt = 'Alterar';
$barra_alt_h = 'Alterar o Registro';
$barra_con = 'Consultar';
$barra_con_h = 'Consultar o Registro';
$barra_exc = 'Excluir';
$barra_exc_h = 'Excluir o Registro';
$barra_fec = 'Fechar';
$barra_fec_h = 'Fechar a lista';

$reg_pagina_esp = 0;

$barra_inc_ap = true;
$barra_alt_ap = true;
$barra_con_ap = true;
$barra_exc_ap = true;
$barra_fec_ap = true;

//Quando informado a largura completa a barra de icone com o espaço vazio se não tiver o direito
$barra_icone = false;

$outramsgvazio = true;


$barra_inc_img = "imagens/incluir" . img_dispositivo . ".png";
$barra_alt_img = "imagens/alterar" . img_dispositivo . ".png";
$barra_con_img = "imagens/consultar" . img_dispositivo . ".png";
$barra_exc_img = "imagens/excluir" . img_dispositivo . ".png";
$barra_fec_img = "imagens/fechar" . img_dispositivo . ".png";

$cliquenalinha = 0;  // 0 não tem clique na linha  1 - tem funcionalidade na linha
$clique_hint_linha = ""; // HINT para linha do FULL

$contlinfim = "Linhas: #qt";
$comfiltro = 'F';
$comidentificacao = 'F';

$TabelaPrinc = "";
$AliasPric = "";
$Entidade = "";
$Entidade_p = "";

$tipofiltro = 'S';
$tipoidentificacao = 'S';
$comcontrole = 1;

$sqlOrderby = '';

//Colocar o order by no sql mesmo tendo outro order by no sql
$colocaOrderBy = false;

$ctlinha = " background:#DFDFFF; ";
$uppertxtcab = 0; // texto do cabeçalho em maiúsculas

$forcarPesquisa = false; //Tem que fazer uma pesquisa primeiro

if (file_exists('incpadrao_full_sebrae.php')) {
    Require_Once('incpadrao_full_sebrae.php');
}

$menu_acesso = $menu;
$menu_acesso_tab = ''; //Menu do Acesso para os BT do Grid

switch ($prefixo) {
    case 'listar_cmb':
        $diretorio = 'listar_cmb';
        break;

    case 'listar_cmbmulti':
        $diretorio = 'listar_cmbmulti';
        $path = $diretorio . '/' . $menu . '.php';

        if (!file_exists($path)) {
            $diretorio = 'listar_cmb';
        }

        $path = $diretorio . '/' . $menu . '.php';

        if (!file_exists($path)) {
            $diretorio = 'listar_conf';
        }
        break;

    case 'listar_rel':
        $diretorio = 'listar_rel';
        $path = $diretorio . '/' . $menu . '.php';

        if (!file_exists($path)) {
            $diretorio = 'listar_conf';
        }
        break;

    default:
        $diretorio = 'listar_conf';
        break;
}

$path = $diretorio . '/' . $menu . '.php';

if (file_exists($path)) {
    Require_Once($path);
} else {
    echo "<br><br><div align='center' class='Msg'>Função em desenvolvimento...</div>";
    onLoadPag();
    FimTela();
    exit();
}

if ($forcarPesquisa && count($_POST) > 0) {
    $forcarPesquisa = false;
}

if ($sqlOrderby != '') {
    $_REQUEST['sqlOrderby'] = $sqlOrderby;
    $_GET['sqlOrderby'] = $sqlOrderby;
    $_POST['sqlOrderby'] = $sqlOrderby;
}

if (is_array($_POST['sql_orderby']) || is_array($_POST['sql_groupby'])) {
    $sqlOrderby = Array();

//    foreach ($_POST['sql_groupby'] as $idx => $value) {
//        if ($value != '') {
//            $t = trim($value);
//
//            if ($t != '') {
//                $sqlOrderby[] = $t;
//            }
//        }
//    }

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

$sqlOrderby = trim($sqlOrderby);

$acesso_top = false;

switch ($prefixo) {
    case 'listar_cmb':
    case 'listar_cmbmulti':
        $novo = false;
        $barra_alt_ap = false;
        $barra_exc_ap = false;
        $goCad = Array();
        $upCad = '';
        $vetBtBarra = Array();
        $bt_print = false;
        $acesso_top = 'parent.hidePopWin(false);';
        $menu_acesso = '';
        break;

    case 'listar_cmbmulti_acao':
        $novo = false;
        $barra_alt_ap = false;
        $barra_exc_ap = false;
        $goCad = Array();
        $upCad = '';
        $vetBtBarra = Array();
        $bt_print = false;
        $menu_acesso = '';
        break;

    case 'listar_rel':
        $novo = false;
        $edit = false;
        $goCad = Array();
        $upCad = '';
        $vetBtBarra = Array();
        $bt_print = false;
        $listar_sql_limit = false;
        $reg_pagina_esp = 'tudo';

        if ($vetBtBarraListarRel['print']) {
            $vetBtBarra[] = vetBtBarra($menu, '', 'imagens/bt_print_32.png', 'listar_rel_print()', '', 'Imprimir Dados', $bt_print_class);
        }

        if ($vetBtBarraListarRel['pdf']) {
            $vetBtBarra[] = vetBtBarra($menu, '', 'imagens/bt_pdf_32.png', 'listar_rel_pdf()', '', 'Exportar para PDF', $bt_print_class);
        }

        if ($vetBtBarraListarRel['xls']) {
            $vetBtBarra[] = vetBtBarra($menu, '', 'imagens/bt_xls_32.png', 'listar_rel_xls()', '', 'Exportar para XLS', $bt_print_class);
        }

        if ($vetBtBarraListarRel['fechar']) {
            $vetBtBarra[] = vetBtBarra($menu, '', 'imagens/bt_fechar_32.png', 'listar_rel_voltar()', '', 'Voltar', $bt_print_class);
        }
        break;
}

$vetBtBarra = array_merge($vetBtBarra, $vetBtBarra_extra);

if ($origem_carga != "SCA" && $menu_acesso != '') {
    acesso($menu_acesso, '', true, $acesso_top);
}

$Focus = '';

$idx = -1;

if ($ordFiltro) {
    ForEach ($vetFiltro as $Filtro) {
        $idx++;
        $strPara .= $Filtro['id'] . $idx . ',';
    }
} else {
    ForEach ($vetFiltro as $Filtro) {
        $strPara .= $Filtro['id'] . ',';
    }
}

$strPara .= 'sql_orderby,sql_orderby_extra,sqlOrderby,origem_tela';

$vetOrderbyExtra = Array(
    'asc' => 'Ascendente',
    'desc' => 'Descendente',
);

if ($vetOrderby === NULL) {
    foreach ($vetCampo as $key => $value) {
        if ($uppertxtcab == 0) {
            $vetOrderby[$key] = mb_strtoupper($value['nome']);
        } else {
            $vetOrderby[$key] = $value['nome'];
        }
    }
}

if ($sqlOrderby == '') {
    $sqlOrderbyAuto = implode(', ', array_keys($vetOrderby));
    CriaVetClassificacao($sqlOrderbyAuto);
} else {
    $sqlOrderbyAuto = $sqlOrderby;
}

$_REQUEST['sqlOrderby'] = $sqlOrderbyAuto;
$_GET['sqlOrderby'] = $sqlOrderbyAuto;
$_POST['sqlOrderby'] = $sqlOrderbyAuto;
$sel_coluna = md5($prefixo . menu);
$_SESSION[CS]['tmp']['sel_coluna'][$sel_coluna] = $vetCampo;

if ($print_tela == 'S') {
    codigo_filtro_fixo(true);
} else {
    echo '<form id="frm" name="frm" target="_self" action="conteudo' . $cont_arq . '.php?' . substr(getParametro($strPara), 1) . '" method="post">';

    //Aviso ListarCmb
    if ($prefixo == 'listar_cmb' || $prefixo == 'listar_cmbmulti' || $prefixo == 'listar_cmbmulti_acao') {
        $vetGEC_parametros = GEC_parametros();

        if ($vetGEC_parametros[$parListarCmbCodigo] != '') {
            echo "<div class='topo_full_aciona'>";
            echo "<div class='div_descricao' style='background:{$corpar};'>";
            echo '<img src="imagens/seta_baixo.png" onclick="return aciana_full_ListarCmb();" title="Clique aqui para visualizar a conteudo"/>';
            echo '<div>' . $parListarCmbDescricao . '</div>';
            echo '</div>';

            echo "<div id='avisoListarCmb'>";

            echo $vetGEC_parametros[$parListarCmbCodigo];

            echo "</div>";
            echo "</div>";
        }
    }

    //Itens Selecionados ListarCmbMulti
    if ($prefixo == 'listar_cmbmulti' || $prefixo == 'listar_cmbmulti_acao') {
        echo "<div class='topo_full_aciona'>";
        echo "<div class='div_descricao' style='background:{$corpar};'>";
        echo '<img src="imagens/seta_baixo.png" onclick="return aciana_full_ListarCmbMulti();" title="Clique aqui para visualizar a conteudo"/>';
        echo '<div>Registros Selecionados</div>';
        echo '</div>';

        echo "<ul class='ListarCmbMulti'>";

        $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_GET['session_cod']]['sel_trab'];
        $vetRetorno = $_SESSION[CS]['objListarCmbMulti'][$_GET['session_cod']]['vet_retorno'];

        foreach ($vetSel as $idx => $dados) {
            foreach ($vetRetorno as $vetTmpCampo) {
                if (!$vetTmpCampo['mostra']) {
                    unset($dados[$vetTmpCampo['campo']]);
                }
            }

            echo '<li data-id="' . $idx . '"><img src="imagens/excluir_16.png" title="Remover da Seleção" />' . implode(' - ', $dados) . '</li>';
        }

        echo "</ul>";
        echo "</div>";
    }

    //Indentificação

    if (!is_array($upCad)) {
        $tipoidentificacao = 'N';
    } else if (count($upCad) == 0) {
        $tipoidentificacao = 'N';
    } else if ($tipoidentificacao == 'N') {
        $tipoidentificacao = 'S';
        $comidentificacao = 'F';
    }

    $tipo = '';
    if ($tipoidentificacao != 'S') {
        $tipo = "style='display:none;'";
    }

    echo "<div class='topo_full_aciona' {$tipo}>";

    echo "<div class='div_descricao' style='background:{$corpar};'>";
    echo '<img src="imagens/seta_cima.png" onclick="return aciana_full_identificacao();" title="Clique aqui para visualizar Filtros e Classificações"/>';
    echo '<div>Indentificação</div>';
    echo '</div>';

    echo "<div id='indentificacao'>";

    $extra_goCad = Array();

    if (is_array($vetFiltro)) {
        if ($ordFiltro) {
            $idx = -1;
            ForEach ($vetFiltro as $Filtro) {
                $idx++;
                $extra_url .= '&' . $Filtro['id'] . $idx . '=' . $Filtro['valor'];
                $extra_goCad[$Filtro['id'] . $idx] = $Filtro['valor'];
            }
        } else {
            ForEach ($vetFiltro as $Filtro) {
                $extra_url .= '&' . $Filtro['id'] . '=' . $Filtro['valor'];
                $extra_goCad[$Filtro['id']] = $Filtro['valor'];
            }
        }
    }

    if (is_array($upCad)) {
        $vetUpCad = Array();
        if (is_array($upCad[0])) {
            $vetUpCad = $upCad;
        } else {
            $vetUpCad[] = $upCad;
        }

        $url = '&sqlOrderby=' . $_REQUEST['sqlOrderby_upcad'];

        foreach ($vetUpCad as $upCad) {
            if ($upCad['campo'] == '') {
                if (is_array($vetFiltro)) {
                    if ($ordFiltro) {
                        $idx = -1;
                        ForEach ($vetFiltro as $Filtro) {
                            if ($Filtro['upCad'] === true) {
                                $idx++;
                                $url .= "&{$Filtro['id']}$idx=" . $extra_goCad[$Filtro['id'] . $idx];
                            }
                        }
                    } else {
                        ForEach ($vetFiltro as $Filtro) {
                            if ($Filtro['upCad'] === true) {
                                $url .= "&{$Filtro['id']}=" . $extra_goCad[$Filtro['id']];
                            }
                        }
                    }
                }
            } else {
                ForEach (explode(',', $upCad['campo']) as $idx => $dbCampo) {
                    $url .= "&$dbCampo$idx=" . $extra_goCad[$dbCampo . $idx];
                }
            }

            if (acesso($upCad['menu'], '', false, false)) {
                echo "<a target='_self' href='conteudo" . $cont_arq . ".php?prefixo=" . $upCad['prefixo'] . "&menu=" . $upCad['menu'] . "&origem_tela=upcad$url'>";
                LinkGrid("<img src='imagens/sobe.gif' title='" . $upCad['nome'] . "' border='0'>", $upCad['nome']);
                echo "</a>" . nl();

                if ($upCad['descricao'] != '') {
                    echo '<div class="Texto">' . $upCad['descricao'] . '</div>';
                }

                echo '<br />';
            }
        }
    }

    echo "</div>";
    echo "</div>";

    //Filtro
    $tipo = '';
    if ($tipofiltro != 'S') {
        $tipo = "style='display:none;'";
    }

    echo "<div class='topo_full_aciona' {$tipo}>";

    echo "<div class='div_descricao' style='background:{$corpar};'>";
    echo '<img src="imagens/seta_cima.png" onclick="return aciana_full_filtro();" title="Clique aqui para visualizar Filtros e Classificações"/>';
    echo '<div>Filtros e Classificações</div>';
    echo '</div>';

    codigo_filtro(false, true, '', '', $sel_coluna);

    echo "</div>";

    echo '</form>';
}

$Focus = '';
onLoadPag($Focus);

echo '<div id="contListar">';

if ($forcarPesquisa) {
    echo "<div align='center' class='Msg'>Favor clicar no botão de Pesquisar!</div>";

    if ($prefixo == 'listar_cmb' || $prefixo == 'listar_cmbmulti') {
        echo '<div class="bt_volta_listar_cmb">';
        echo '<input type="Button" onclick="parent.hidePopWin(false);" value="Voltar" class="Botao" />';
        echo '</div>';
    }
} else if ($Campo == '') {
    if ($menu_acesso == '') {
        $acesso = true;
    } else {
        $acesso = acesso($menu_acesso, '', false, false);
    }

    if ($acesso) {
        $pos = strripos($sql, 'order by');

        if ($pos === false) {
            $sql .= ' order by ' . $sqlOrderbyAuto;
        }

        if ($prefixo == 'listar_cmbmulti' || $prefixo == 'listar_cmbmulti_acao') {
            $_SESSION[CS]['objListarCmbMulti'][$_GET['session_cod']]['sql'] = $sql;

            if ($filhoCodListarCmbMulti != '') {
                $rst = execsql($sql);

                foreach ($rst->data as $rowt) {
                    if (function_exists($func_trata_row)) {
                        $func_trata_row($rowt);
                    }

                    $codFinal = '';
                    $vetCod = explode($filhoSeparadorListarCmbMulti, $rowt[$filhoCodListarCmbMulti]);

                    foreach ($vetCod as $value) {
                        $codFinal .= $value . $filhoSeparadorListarCmbMulti;
                        $filhoTotListarCmbMulti[$codFinal] ++;
                    }
                }

                foreach ($filhoTotListarCmbMulti as $idx => $tot) {
                    $tot--;

                    if ($tot === 0) {
                        unset($filhoTotListarCmbMulti[$idx]);
                    } else {
                        $filhoTotListarCmbMulti[$idx] = $tot;
                    }
                }

                $_SESSION[CS]['objListarCmbMulti'][$_GET['session_cod']]['filhoCodListarCmbMulti'] = $filhoCodListarCmbMulti;

                function trataRowListarCmbMulti(&$row) {
                    global $trHtml, $filhoCodListarCmbMulti, $filhoSeparadorListarCmbMulti, $filhoTotListarCmbMulti;

                    $cod = $row[$filhoCodListarCmbMulti] . $filhoSeparadorListarCmbMulti;

                    if ($filhoTotListarCmbMulti[$cod] > 0) {
                        $data = ' data-cod_lcm="' . $cod . '"';
                        $trHtml = str_replace("class='", $data . " class='", $trHtml);
                    }
                }

            }

            $_SESSION[CS]['objListarCmbMulti'][$_GET['session_cod']]['vetListarCmbRegValido'] = $vetListarCmbRegValido;
        }

        if ($listar_sql_limit !== false) {
            $sql .= ' limit ' . $listar_sql_limit;
        }

        $rs_tab_lst = execsql($sql, true, $conSQL);

        $path = $diretorio . '/' . $menu . '_ant.php';
        if (file_exists($path)) {
            Require_Once($path);
        }

        bt_volta_listar_cmb();

        if ($listar_sql_limit !== false) {
            if ($rs_tab_lst->rows == $listar_sql_limit) {
                echo '<div class="Msg" style="text-align: center;"><br/>Só esta mostrando os ' . $listar_sql_limit . ' primeiros registros, se desejar ver mais usar mais opção de filtro!</div><br/>';
            }
        }

        if (function_exists($func_trata_rs)) {
            $rs_tab_lst = $func_trata_rs($rs_tab_lst);
        }

        criar_tabela($rs_tab_lst, $vetCampo, $idCampo, $novo, $edit, $novoprefixo, $novomenu, $vetFiltro, $sqlOrderby, $menu_acesso_tab);

        bt_volta_listar_cmb();

        $path = $diretorio . '/' . $menu . '_dep.php';
        if (file_exists($path)) {
            Require_Once($path);
        }
    } else {
        echo "<div align='center' class='Msg'>O usuário não tem acesso a está informação!</div>";
    }
} else {
    $Campo = substr($Campo, 0, strrpos($Campo, ', '));
    $pos = strrpos($Campo, ', ');

    if ($pos != '')
        $Campo = substr($Campo, 0, $pos) . ' e ' . substr($Campo, $pos + 1);

    echo "<div align='center' class='Msg'>Favor cadastrar um $Campo antes de cadastrar $Tela!</div>";

    if ($prefixo == 'listar_cmb' || $prefixo == 'listar_cmbmulti') {
        echo '<div class="bt_volta_listar_cmb">';
        echo '<input type="Button" onclick="parent.hidePopWin(false);" value="Voltar" class="Botao" />';
        echo '</div>';
    }
}

echo "</div>";

function bt_volta_listar_cmb() {
    global $prefixo, $ListarBtSelecionar, $comListarCmb_SoVoltar, $btListarBtMarcarTodosMulti, $btListarBtVoltarMulti;

    if ($comListarCmb_SoVoltar) {
        echo '<div class="bt_volta_listar_cmb">';
        echo '<input type="Button" onclick="parent.hidePopWin(false);" value="Voltar" class="Botao" />';
        echo '</div>';
    } else {
        if ($prefixo == 'listar_cmb') {
            echo '<div class="bt_volta_listar_cmb">';
            echo '<input type="Button" onclick="ListarBtSelecionar(\'\');" value="' . $ListarBtSelecionar . '" class="Botao" />';
            echo '<input type="Button" onclick="parent.hidePopWin(false);" value="Voltar" class="Botao" />';
            echo '</div>';
        }

        if ($prefixo == 'listar_cmbmulti') {
            echo '<div class="bt_volta_listar_cmb">';
            echo '<input type="Button" onclick="ListarCmbMultiLimpa(\'\', \'' . $_GET['session_cod'] . '\');" value="Desmarcar todos os registros" class="Botao" />';

            if ($btListarBtMarcarTodosMulti) {
                echo '<input type="Button" onclick="ListarBtMarcarTodosMulti();" value="Marcar todos os registros" class="Botao" />';
            }

            echo '<input type="Button" onclick="ListarBtSelecionarMulti();" value="' . $ListarBtSelecionar . '" class="Botao" />';
            echo '<input type="Button" onclick="parent.hidePopWin(false);" value="Voltar" class="Botao" />';
            echo '</div>';
        }

        if ($prefixo == 'listar_cmbmulti_acao') {
            echo '<div class="bt_volta_listar_cmb">';
            echo '<input type="Button" onclick="ListarCmbMultiLimpa(\'\', \'' . $_GET['session_cod'] . '\');" value="Desmarcar todos os registros" class="Botao" />';

            if ($btListarBtMarcarTodosMulti) {
                echo '<input type="Button" onclick="ListarBtMarcarTodosMulti();" value="Marcar todos os registros" class="Botao" />';
            }

            echo '<input type="Button" onclick="ListarBtSelecionarMultiAcao();" value="' . $ListarBtSelecionar . '" class="Botao" />';

            if ($btListarBtVoltarMulti) {
                echo '<input type="Button" onclick="parent.hidePopWin(false);" value="Voltar" class="Botao" />';
            }

            echo '</div>';
        }
    }
}

if ($print_tela != 'S') {
    ?>
    <style type="text/css">
        #contListar {
            overflow: visible;
        }

        input.listar_cmb {
            border: none;
            margin: 0px;
            vertical-align: middle;
        }

        input.listar_cmbmulti,
        input.listar_cmbmulti_acao {
            border: none;
            margin: 0px;
            vertical-align: middle;
            display: inline-block;
            visibility: visible; 
        }
    </style>
    <script type="text/javascript">
        var comcontrole = '<?php echo $comcontrole; ?>';
        var comfiltro = '<?php echo $comfiltro; ?>';
        var comidentificacao = '<?php echo $comidentificacao; ?>';
        var comListarCmb = '<?php echo $comListarCmb; ?>';
        var comListarCmbMulti = '<?php echo $comListarCmbMulti; ?>';

        $(document).ready(function () {
            $('#Tabela_Filtro select, #Tabela_Filtro input').on("change", function () {
                var btVolta = '<div class="bt_volta_listar_cmb">';
                btVolta += '<input type="Button" onclick="parent.hidePopWin(false);" value="Voltar" class="Botao" />';
                btVolta += '</div>';

                $('#contListar').html('<div align="center" class="Msg">Favor clicar no botão de Pesquisar!</div>' + btVolta);
                //TelaHeight();
            });

            $('td.acao_fecha').click(function () {
                ControleLinha();
            });

            $("input:checkbox[name='id']").click(function () {
                var obj = $(this);
                var chk = '';

                if (obj.prop('checked')) {
                    chk = 'S';
                } else {
                    chk = 'N';
                }

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: ajax_plu + '&tipo=ListarCmbMulti',
                    data: {
                        cas: conteudo_abrir_sistema,
                        chk: chk,
                        session_cod: '<?php echo $_GET['session_cod']; ?>',
                        dados: obj.parent().find('input:hidden').serialize()
                    },
                    success: function (response) {
                        if (response.erro == '') {
                            if (chk == 'S') {
                                $('.ListarCmbMulti').append(url_decode(response.html));
                            } else {
                                $(".ListarCmbMulti > li[data-id='" + obj.data('cod') + "']").remove();
                            }
                        } else {
                            alert(url_decode(response.erro));
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                    },
                    async: false
                });
            });

            $('.ListarCmbMulti').on('click', 'li > img', function () {
                var id = $(this).parent().data('id');
                $("input:checkbox[data-cod='" + id + "']").click();
            });

            var tem_bt = false;

            $('tr[data-cod_lcm]').each(function () {
                tem_bt = true;

                var bt = $('<img border="0" title="Selecionar os registros vinculados" src="imagens/bt_mais.png" style="cursor: pointer;" >');

                bt.click(function () {
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: ajax_plu + '&tipo=filhoListarCmbMulti',
                        data: {
                            cas: conteudo_abrir_sistema,
                            chk: 'S',
                            session_cod: '<?php echo $_GET['session_cod']; ?>',
                            cod: $(this).parent().parent().data('cod_lcm')
                        },
                        success: function (response) {
                            if (response.erro == '') {
                                document.frm.submit();
                            } else {
                                alert(url_decode(response.erro));
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                        },
                        async: false
                    });
                });

                var td = $(this).find('td:first');
                td.find('> img').remove();
                td.prepend(bt);
            });

            if (tem_bt) {
                $('.Titulo_ctl input[type="checkbox"]').css('margin', '0px 4px');
                $('.Titulo_ctl > img').width(24);
            }
        });

        function ListarBtMarcarTodosMulti() {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_plu + '&tipo=filhoTotListarCmbMulti',
                data: {
                    cas: conteudo_abrir_sistema,
                    session_cod: '<?php echo $_GET['session_cod']; ?>'
                },
                success: function (response) {
                    if (response.erro == '') {
                        document.frm.submit();
                    } else {
                        $("#dialog-processando").remove();
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#dialog-processando").remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $("#dialog-processando").remove();
        }

        function aciana_full_ListarCmb() {
            $('#avisoListarCmb').toggle();
            var img = $('#avisoListarCmb').parent().find('.div_descricao > img');

            if (img.attr('src') == 'imagens/seta_baixo.png') {
                img.attr('src', 'imagens/seta_cima.png');
            } else {
                img.attr('src', 'imagens/seta_baixo.png');
            }

            TelaHeight();
            return false;
        }

        function aciana_full_ListarCmbMulti() {
            $('.ListarCmbMulti').toggle();
            var img = $('.ListarCmbMulti').parent().find('.div_descricao > img');

            if (img.attr('src') == 'imagens/seta_baixo.png') {
                img.attr('src', 'imagens/seta_cima.png');
            } else {
                img.attr('src', 'imagens/seta_baixo.png');
            }

            TelaHeight();
            return false;
        }

        function aciana_full_filtro() {
            $('#filtro_classificacao').toggle();
            var img = $('#filtro_classificacao').parent().find('.div_descricao > img');

            if (img.attr('src') == 'imagens/seta_baixo.png') {
                img.attr('src', 'imagens/seta_cima.png');
            } else {
                img.attr('src', 'imagens/seta_baixo.png');
            }

            TelaHeight();
            return false;
        }

        function aciana_full_identificacao() {
            $('#indentificacao').toggle();
            var img = $('#indentificacao').parent().find('.div_descricao > img');

            if (img.attr('src') == 'imagens/seta_baixo.png') {
                img.attr('src', 'imagens/seta_cima.png');
            } else {
                img.attr('src', 'imagens/seta_baixo.png');
            }

            TelaHeight();
            return false;
        }

        // coloca área de aviso ListarCmb escondida ou aparente
        if (comListarCmb == 'F') {
            aciana_full_ListarCmb();
        }

        // coloca área de aviso ListarCmbMulti escondida ou aparente
        if (comListarCmbMulti == 'F') {
            aciana_full_ListarCmbMulti();
        }

        // coloca área de filtros escondida ou aparente
        if (comfiltro == 'A') {
            aciana_full_filtro();
        }

        // coloca área de identificação escondida ou aparente
        if (comidentificacao == 'A') {
            aciana_full_identificacao();
        }

        //
        // Controle da área de Linha
        //
        function ControleLinha() {
            $(".Titulo_ctl").each(function () {
                $(this).toggle();
            });

            $(".Titulo_radio").each(function () {
                $(this).toggle();
            });

            return false;
        }

        if (comcontrole == 0) {
            ControleLinha();
        }

        function ListarBtSelecionar(id_reg) {
            if (id_reg === '') {
                var obj = $('table.Generica input:radio:checked');
            } else {
                var obj = $('table.Generica input#id_r_' + id_reg);
            }

            var id = obj.val();

            if (id == undefined || id == '') {
                alert('Favor selecionar um registro!');
                return false;
            }

            returnVal = {
                'campo': '<?php echo $_GET['campo']; ?>',
                'valor': id,
                'desc': obj.parent().find('span').text()
            };

            parent.hidePopWin(true);
        }

        function ListarBtSelecionarMulti() {
            if ($('.ListarCmbMulti > li').length == 0) {
                alert('Favor selecionar um registro!');
                return false;
            }

            returnVal = {
                'campo': '<?php echo $_GET['campo']; ?>',
                'session_cod': '<?php echo $_GET['session_cod']; ?>'
            };

            parent.hidePopWin(true);
        }
    </script>
    <?php
}
