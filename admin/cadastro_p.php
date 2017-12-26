<?php
if ($menu == 'fluxo_financeiro_b') {
    $path = 'cadastro_bloco.php';
    if (file_exists($path)) {

        Require_Once($path);

        exit();
    } else {
        echo "<br><br><div align='center' class='Msg'>Função em desenvolvimento...</div>";
        onLoadPag();
        FimTela();
        exit();
    }
}
?>
<style type="text/css">
    div#mostra_pk {
        text-align: right;
        font-size: 10px;
        padding-top: 5px;
    }

    div#mostra_pk a {
        color: black;
    }

    div#help_campo {
        position:absolute;
        left:300px;
        top:230px;
        width :300px;
        height:150px;
        background-color: white;
        border:2px solid #808040;
        display:none;

        z-index:2000000;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 14px;
        font-style: normal;
        font-weight: bold;
        color: #022B7B;
        text-align:center;

    }
    div#help_campo img{
        float:right;
        padding-top:10px;
        padding-right:10px;
        cursor:pointer;
    }

    div#help_campo_cab {
        width :296px;
        height:25px;
        border:2px solid #C0C0C0;
        color:white;
        background: #A8A8A8;
        text-align:left;

    }

    div#help_campo_det {
        padding-top:10px;
        padding-left:10px;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 14px;
        font-style: normal;
        font-weight: bold;
        color: #313131;
        text-align:center;

    }


</style>



<?php
echo "<div id='help_campo'>";
echo "    <div id='help_campo_cab'>";
echo "         <img onclick='desativa_help_campo();' title='Fechar ajuda de campo' src='imagens/fechar.gif' border='0'>";

echo '<a  >' . "&nbsp;<img onclick='return abre_ajuda_campo();' title='Atualiza Ajuda do Campo' src='imagens/alterar.gif' border='0'>" . '&nbsp;</a>';

echo "        <span id='help_campo_cab_texto'>Help de Campo</span>";
echo "    </div>";
echo "    <div id='help_campo_det'>";
echo "    </div>";
echo "</div>";



$vetCampo = Array();
$vetFrm = Array();
$vetCad = Array();
$vetTab = Array();
$vetFile = Array();
$vetLista = Array();
$vetLstDel = Array();
$vetLstExtra = Array();
$vetTabExtra = Array();
$vetListarCmbMulti = Array();
$vetDesativa = Array();
$vetAtivadoObr = Array();
$vetMesclarCadastro = Array();
$prefixo_volta = 'listar';
$mostra_bt_volta = true;
$excluirCascade = true;
$TamFonte = 8;
$vlID = '';
$vetID = Array();
$vlIDAnt = '';
$vetIDAnt = Array();
$par_url = '';
$botao_acao = '';
$botao_volta = '';
$pagina = 'conteudo' . $cont_arq . '.php';
$tabHtml = '';
$jsData = 'onblur="return Valida_Data_Hoje(this)" onkeyup="return Formata_Data(this,event)"';
$jsMinCaract = 'onblur="return minCaracteres(this)"';
$exit = true;
$proxima_tela = false;
$um_registro = '';
$menu_acesso = $menu;
$bt_salvar_lbl = 'Salvar';
$bt_alterar_lbl = 'Alterar';
$bt_alterar_aviso = '';
$bt_excluir_lbl = 'Excluir';
$bt_voltar_lbl = 'Voltar';
$bt_personalizado = 'Executar';
$acesso_top = false;
$barra_bt_top = true;
$barra_bt_top_fixo = false;
$bt_submit_mostra = true; //Mostra o botão do tipo Submit
$bt_barra_html_dep = ''; //Html colocado depois dos BT na barra
$bt_exportar = false;
$bt_exportar_desc = 'Exportar';
$bt_exportar_tit = '';
$formUpload = '';

$pathObjFile = dirname($_SERVER['SCRIPT_FILENAME']);
$pathObjFile .= DIRECTORY_SEPARATOR . $dir_file;

$tabela = '';
$tabela_banco = '';

$vetGravaLog = Array();
$vetLogDetalheExtra = Array();

$vetConfMsg = Array(
    'inc' => 'Deseja realmente confirmar essa operação?',
    'alt' => 'Deseja realmente confirmar essa operação?',
    'exc' => 'Deseja realmente confirmar essa operação?',
    'per' => 'Deseja realmente confirmar essa operação?',
);

$vetMsgErro = Array(
    '23000.d' => 'registros',
    '23000.i' => 'o registro',
    '23000.u' => 'registro',
);

$vetMsgErroPersonalizado = Array(
    '23000.d' => '',
    '23000.i' => '',
    '23000.u' => '',
);

if ($_GET['prefixo_volta'] != '') {
    $prefixo_volta = $_GET['prefixo_volta'];
}

Require_Once('fncCampo.php');

$onSubmitAnt = ''; //Colocar nome da funcao do js para ser chamada no onSubmit do formulario antes da validação padrão
$onSubmitDep = ''; //Colocar nome da funcao do js para ser chamada no onSubmit do formulario depois da validação padrão
$onSubmitCon = ''; //Colocar nome da funcao do js para ser chamada no onSubmit do formulario depois da confirmação
$id = 'idt';

$acao_alt_con = 'N';
$desabilita_html = false;

if (file_exists('incpadrao_ficha_sebrae.php')) {
    Require_Once('incpadrao_ficha_sebrae.php');
}

$tmp = $_SESSION[CS]['objListarConf'][$_GET['session_cod']]['vetParametros'];

if (is_array($tmp)) {
    extract($tmp);
}

$MesclarCadastro = false;
$path = 'cadastro_conf/' . $menu . '.php';

//echo " $path <br />";
//exit();

if (file_exists($path)) {
    Require_Once($path);
} else {
    echo "<br><br><div align='center' class='Msg'>Função em desenvolvimento...</div>";
    onLoadPag();
    FimTela();
    exit();
}

if ($bt_alterar_aviso === '') {
    $bt_alterar_aviso = 'Não esqueça de clicar no botão ' . mb_strtoupper($bt_alterar_lbl) . ' para salvar a sua alteração!';
}

if ($um_registro != '') {
    $sql = "select $id from {$tabela_banco}$tabela where " . $um_registro['where'];
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        $acao = 'inc';
        $_GET['id'] = 0;
    } else {
        $acao = 'alt';
        $_GET['id'] = $rs->data[0][$id];
    }


    if ($botao_volta == "") { // colocado por luiz para depois ver com esmeraldo.....
        $url_tmp = $pagina . "?prefixo={$prefixo_volta}&menu=" . $um_registro['volta_menu'] . getParametro('prefixo,menu,' . $um_registro['get_pai']) . "#lin" . $_GET[$um_registro['get_pai']];
        $botao_volta = "self.location = '{$url_tmp}'";
        $botao_acao = "<script type='text/javascript'>self.location = '{$url_tmp}';</script>";
    }
}

if ($tabela != '') {
    $vetTmp = Array(
        'soConsulta' => false,
        'tabela' => $tabela,
        'id' => $id,
    );
    $vetMesclarCadastro = array_reverse($vetMesclarCadastro, true);
    $vetMesclarCadastro[$tabela] = $vetTmp;
    $vetMesclarCadastro = array_reverse($vetMesclarCadastro, true);
}

$vetTemp = array_keys($vetTab);
$posTabIni = $vetTemp[0];
$posTabFim = $vetTemp[count($vetTemp) - 1];

acesso($menu_acesso, aspa($acao), true, $acesso_top);

//Tipo dos dados no banco
$type = Array();

foreach ($vetMesclarCadastro as $cadastro_conf) {
    $tabela_cad = $cadastro_conf['tabela'];
    $id_cad = $cadastro_conf['id'];

    if ($tabela_cad != '') {
        $sql = "select * from {$tabela_banco}{$tabela_cad} where {$id_cad} = 0";
        $rs = execsql($sql);
        $type[$tabela_cad] = $rs->info['type'];
    }
}

function tipo($campo, $tabela) {
    global $type;
    return $type[$tabela][$campo];
}

if ($_POST['id'] != '') {
    $vlID = $_POST['id'];
} else {
    $vlID = $_GET['id'];
}
$vetID[$tabela] = $vlID;

foreach ($vetMesclarCadastro as $cadastro_conf) {
    if ($cadastro_conf['tabela'] != '') {
        if (is_array($cadastro_conf['idtVinculo'])) {
            $sql = "select {$cadastro_conf['id']} from {$tabela_banco}{$cadastro_conf['tabela']} where 1 = 1";

            foreach ($cadastro_conf['idtVinculo'] as $key => $value) {
                if ($value === false) {
                    $sql .= $key;
                } else {
                    $sql .= ' and ' . $key . ' = ' . null($vetID[$value]);
                }
            }

            $rs = execsql($sql);
            $vetID[$cadastro_conf['tabela']] = $rs->data[0][0];
        } else if ($cadastro_conf['idtVinculo'] != '') {
            $sql = "select {$cadastro_conf['id']} from {$tabela_banco}{$cadastro_conf['tabela']} where {$cadastro_conf['idtVinculo']} = " . $vlID;
            $rs = execsql($sql);
            $vetID[$cadastro_conf['tabela']] = $rs->data[0][0];
        }
    }
}

if ($vlIDAnt != '') {
    $vetIDAnt[$tabela] = $vlIDAnt;

    foreach ($vetMesclarCadastro as $cadastro_conf) {
        if (is_array($cadastro_conf['idtVinculo'])) {
            $sql = "select {$cadastro_conf['id']} from {$tabela_banco}{$cadastro_conf['tabela']} where 1 = 1";

            foreach ($cadastro_conf['idtVinculo'] as $key => $value) {
                if ($value === false) {
                    $sql .= $key;
                } else {
                    $sql .= ' and ' . $key . ' = ' . null($vetIDAnt[$value]);
                }
            }

            $rs = execsql($sql);
            $vetIDAnt[$cadastro_conf['tabela']] = $rs->data[0][0];
        } else if ($cadastro_conf['idtVinculo'] != '') {
            $sql = "select {$cadastro_conf['id']} from {$tabela_banco}{$cadastro_conf['tabela']} where {$cadastro_conf['idtVinculo']} = " . $vlIDAnt;
            $rs = execsql($sql);
            $vetIDAnt[$cadastro_conf['tabela']] = $rs->data[0][0];
        }
    }
}

$vetCampoJS = Array();
$vetNomeJS = Array();
$vetGrdJS = Array();
$vetObrJS = Array();
$vetFocusJS = Array();
$onLoadPag = '';
$onLoadPagGrd = '';
$priListarConf = true;
$vetSql = Array();
$vetRow = Array();
$vetRowAnt = null;

ForEach ($vetCad as $idxGrd => $vetGrd) {
    ForEach ($vetGrd as $idxFrm => $vetFrm) {
        if (is_array($vetFrm['dados'])) {
            ForEach ($vetFrm['dados'] as $nLinha => $Linha) {
                ForEach ($Linha as $Coluna) {
                    if (is_array($Coluna)) {
                        switch ($Coluna['tipo']) {
                            case 'ListarConf':
                                if ($_GET['cont'] == 's' && $priListarConf) {
                                    $priListarConf = false;
                                    $onLoadPag = $Coluna['campo'];
                                    $onLoadPagGrd = $idxGrd;
                                }

                                $vetGrdJS[] = $idxGrd;
                                $vetNomeJS[] = $Coluna['titulo'];
                                $vetCampoJS[] = $Coluna['campo'] . '_tot';
                                $vetFocusJS[] = $Coluna['campo'] . '_tot';
                                $vetObrJS[] = $Coluna['campo'] . '_desc';
                                break;

                            case 'ListarCmbMulti':
                                $vetGrdJS[] = $idxGrd;
                                $vetNomeJS[] = $Coluna['nome'];
                                $vetCampoJS[] = $Coluna['campo'] . '_tot';
                                $vetFocusJS[] = $Coluna['campo'] . '_tot';
                                $vetObrJS[] = $Coluna['campo'] . '_desc';
                                break;

                            case 'Lista':
                                $vetGrdJS[] = $idxGrd;
                                $vetNomeJS[] = $Coluna['nome'];
                                $vetCampoJS[] = $Coluna['campo'];
                                $vetFocusJS[] = $Coluna['campo'] . '_lista';
                                $vetObrJS[] = $Coluna['campo'] . '_lst_2';
                                break;

                            default:
                                $vetGrdJS[] = $idxGrd;
                                $vetNomeJS[] = $Coluna['nome'];
                                $vetCampoJS[] = $Coluna['campo'];
                                $vetFocusJS[] = $Coluna['campo'];
                                $vetObrJS[] = $Coluna['campo'] . '_desc';
                                break;
                        }

                        if ($Coluna['campo_tabela']) {
                            $vetSql[$Coluna['tabela']] .= $Coluna['campo'] . ', ';
                        }

                        if ($onLoadPag == '' && $Coluna['focus']) {
                            $onLoadPag = $Coluna['campo'];
                            $onLoadPagGrd = $idxGrd;
                        }
                    }
                }
            }
        }
    }
}

foreach ($vetSql as $sql_tabela => $lst_campo) {
    if ($sql_tabela == '') {
        $vetRow[$sql_tabela] = Array();

        if ($vlIDAnt != '') {
            $vetRowAnt[$sql_tabela] = Array();
        }
    } else {
        $sql = 'select ' . $lst_campo;

        if ($sql_tabela == $tabela) {
            $sql_id = $id;
        } else {
            $sql_id = $vetMesclarCadastro[$sql_tabela]['id'];
        }

        $sql .= "$sql_id from {$tabela_banco}$sql_tabela where $sql_id = ";

        $rs = execsql($sql . null($vetID[$sql_tabela]));

        if ($rs->rows == 0) {
            $vetRow[$sql_tabela] = Array();
        } else {
            $vetRow[$sql_tabela] = $rs->data[0];
        }

        if ($vlIDAnt != '') {
            $rs = execsql($sql . null($vetIDAnt[$sql_tabela]));

            if ($rs->rows == 0) {
                $vetRowAnt[$sql_tabela] = Array();
            } else {
                $vetRowAnt[$sql_tabela] = $rs->data[0];
            }
        }
    }
}

$vetLogDetalheAnt = Array();
LogDetalhe($vetLogDetalheAnt, $vetRow, 'ant', '');

ForEach ($vetCad as $idxGrd => $vetGrd) {
    ForEach ($vetGrd as $idxFrm => $vetFrm) {
        if (is_array($vetFrm['dados'])) {
            ForEach ($vetFrm['dados'] as $nLinha => $Linha) {
                ForEach ($Linha as $nColuna => $Coluna) {
                    if (is_array($Coluna)) {
                        $par_url .= $Coluna['campo'] . ',';

                        switch ($Coluna['tipo']) {
                            case 'ListarConf':
                                $proxima_tela = true;
                                break;

                            case 'Lista':
                                $vetLista[] = Array(
                                    'campo' => $Coluna['campo'],
                                    'tabela_pai' => $Coluna['tabela'],
                                    'idt_cadastro' => $Coluna['idt_cadastro'],
                                    'tabela' => $Coluna['tabela_relacionamento']
                                );
                                break;

                            case 'ListarCmbMulti':
                                $vetListarCmbMulti[] = Array(
                                    'campo' => $Coluna['campo'],
                                    'tabela_pai' => $Coluna['tabela'],
                                    'tabela_relacionamento' => $Coluna['tabela_relacionamento'],
                                    'idt_relacionamento' => $Coluna['idt_relacionamento'],
                                    'session_cod' => $Coluna['session_cod'],
                                );
                                break;

                            case 'Senha':
                                if ($_GET['id'] != 0)
                                    $vetCad[$idxGrd][$idxFrm]['dados'][$nLinha][$nColuna]['valida'] = false;
                                break;

                            case 'File':
                                $vetFile[$Coluna['campo']] = Array(
                                    'tabela' => $Coluna['tabela'],
                                    'id' => $vetMesclarCadastro[$Coluna['tabela']]['id'],
                                    'nome' => $Coluna['nome'],
                                    'grupo' => $Coluna['grupo'],
                                    'validaMime' => $Coluna['validaMime'],
                                    'largura' => $Coluna['largura'] == '' ? null : $Coluna['largura'],
                                    'altura' => $Coluna['altura'] == '' ? null : $Coluna['altura'],
                                    'max_tamanho' => $Coluna['max_tamanho'] * 1024,
                                    'sql' => false
                                );

                                $arq_file = $pathObjFile . '/' . $tabela . '/' . $vetRow[$Coluna['tabela']][$Coluna['campo']];
                                if ($_GET['id'] != 0 && file_exists($arq_file) && $vetRow[$Coluna['tabela']][$Coluna['campo']] != '') {
                                    $vetCad[$idxGrd][$idxFrm]['dados'][$nLinha][$nColuna]['valida'] = false;
                                }
                                break;
                        }
                    }
                }
            }
        }
    }
}

$par_url .= 'prefixo,id,acao,MAX_FILE_SIZE,btnAcao,origem_tela';
$microtime = substr(time(), -3);

switch ($_POST['btnAcao']) {
    case $bt_salvar_lbl:
    case 'Continua':
        ForEach ($vetFile as $Campo => $Dados) {
            if ($_FILES[$Campo]['name'] != '') {
                $vetFile[$Campo]['sql'] = true;

                $Erro = ErroArq($Campo);
                if ($Erro != "OK") {
                    echo "
                        <script type='text/javascript'>
                            alert('$Erro')
                            history.go(-1);
                        </script>
                    ";
                    exit();
                }

                if ($vetFile[$Campo]['validaMime']) {
                    $extensao = explode('.', $_FILES[$Campo]['name']);
                    $extensao = array_pop($extensao);
                    $extensao = mb_strtolower($extensao);

                    if (!in_array(mb_strtolower($_FILES[$Campo]['type']), $vetMime[$Dados['grupo']][$extensao]) && $_FILES[$Campo]['type'] != '') {
                        echo '
                            <script type="text/javascript">
                            alert("O arquivo \"' . $_FILES[$Campo]['name'] . '\" do tipo \"' . $_FILES[$Campo]['type'] . '\" não é de um tipo valido para o campo ' . $Dados['nome'] . '.");
                            history.go(-1);
                            </script>
                        ';
                        exit();
                    }
                }
            }
        }

        beginTransaction();

        Require_Once('cadastro_acao_ant.php');

        $sql_campo = Array();
        $sql_valor = Array();

        ForEach ($vetCad as $idxGrd => $vetGrd) {
            ForEach ($vetGrd as $idxFrm => $vetFrm) {
                if (is_array($vetFrm['dados'])) {
                    ForEach ($vetFrm['dados'] as $nLinha => $Linha) {
                        ForEach ($Linha as $Coluna) {
                            if (is_array($Coluna)) {
                                if ($Coluna['campo_tabela']) {
                                    campoInsert($sql_campo[$Coluna['tabela']], $sql_valor[$Coluna['tabela']]);
                                }
                            }
                        }
                    }
                }
            }
        }

        foreach ($vetMesclarCadastro as $cadastro_conf) {
            if (!$cadastro_conf['soConsulta']) {
                $vetGravaLog[] = sqlInsert();
            }
        }

        if (count($vetFile) > 0) {
            ForEach ($vetFile as $Campo => $Dados) {
                if ($Dados['sql']) {
                    if (!$vetMesclarCadastro[$Dados['tabela']]['soConsulta']) {
                        $nomearq = aspa(mb_strtolower($vetID[$Dados['tabela']] . '_' . $Campo . '_' . $microtime . '_' . troca_caracter($_FILES[$Campo]['name'])));
                        execsql("update {$tabela_banco}{$Dados['tabela']} set {$Campo} = {$nomearq} where {$Dados['id']} = " . null($vetID[$tabela_cad]));
                    }
                }
            }
        }

        cadastra_lista();
        cadastraListarCmbMulti();

        $deucommit = 0;

        if (count($vetFile) > 0) {
            ForEach ($vetFile as $Campo => $Dados) {
                if ($Dados['tabela'] != '') {
                    if (!$vetMesclarCadastro[$Dados['tabela']]['soConsulta']) {
                        $path = $pathObjFile;

                        $path .= DIRECTORY_SEPARATOR . $Dados['tabela'];
                        if (!file_exists($path)) {
                            mkdir($path);
                        }

                        $path .= DIRECTORY_SEPARATOR;

                        if ($Dados['sql']) {
                            set_time_limit(600);

                            imgsize($_FILES[$Campo]['tmp_name'], $_FILES[$Campo]['tmp_name'], $Dados['largura'], $Dados['altura']);

                            $Dados['max_tamanho'] = 0;

                            if (file_exists($_FILES[$Campo]['tmp_name']) && $Dados['max_tamanho'] > 0) {
                                if (filesize($_FILES[$Campo]['tmp_name']) > $Dados['max_tamanho']) {
                                    echo "
                                    <br>
                                    <div align='center' class='Msg'>O arquivo de " . $Dados['nome'] . " ultrapassou o tamanho maximo permitido de " . ($Dados['max_tamanho'] / 1024) . "kb!
                                    <br><br><input type='button' name='btnAcao' class='Botao' value=' Voltar ' onClick='history.go(-1)'>
                                    </div>
                                ";
                                    onLoadPag();
                                    FimTela();
                                    exit();
                                }
                            }

                            $nomearq = mb_strtolower($vetID[$Dados['tabela']] . '_' . $Campo . '_' . $microtime . '_' . troca_caracter($_FILES[$Campo]['name']));
                            move_uploaded_file($_FILES[$Campo]['tmp_name'], $path . $nomearq);
                        }
                    }
                }
            }
        }

        Require_Once('cadastro_acao_dep.php');

        foreach ($vetGravaLog as $log) {
            if (is_array($log)) {
                grava_log_sis($log['nom_tabela'], $log['sts_acao'], $log['des_pk'], $log['des_registro'], '', '', vetLogDetalhe($log['nom_tabela']));
            }
        }

        if ($deucommit == 0) {
            commit();
        }

        if ($_POST['btnAcao'] == 'Continua') {
            echo "<script type='text/javascript'>self.location = '" . $pagina . "?prefixo={$prefixo}&acao=alt&id=" . $vlID . getParametro($par_url) . "&origem_tela=cadastro&cont=s';</script>";
            onLoadPag();
            exit();
        } else {
            if ($botao_acao == '') {
                echo "<script type='text/javascript'>self.location = '" . $pagina . "?prefixo={$prefixo_volta}" . getParametro($par_url) . "#lin{$vlID}';</script>";
            } else {
                echo $botao_acao;
            }

            if ($exit) {
                onLoadPag();
                exit();
            }
        }
        break;

    case $bt_alterar_lbl:
        ForEach ($vetFile as $Campo => $Dados) {
            if ($_FILES[$Campo]['name'] != '') {
                $vetFile[$Campo]['sql'] = true;

                $Erro = ErroArq($Campo);
                if ($Erro != "OK") {
                    echo "
                        <script type='text/javascript'>
                            alert('$Erro')
                            history.go(-1);
                        </script>
                    ";
                    exit();
                }

                if ($vetFile[$Campo]['validaMime']) {
                    $extensao = explode('.', $_FILES[$Campo]['name']);
                    $extensao = array_pop($extensao);
                    $extensao = mb_strtolower($extensao);

                    if (!in_array(mb_strtolower($_FILES[$Campo]['type']), $vetMime[$Dados['grupo']][$extensao]) && $_FILES[$Campo]['type'] != '') {
                        echo '
                            <script type="text/javascript">
                            alert("O arquivo \"' . $_FILES[$Campo]['name'] . '\" do tipo \"' . $_FILES[$Campo]['type'] . '\" não é de um tipo valido para o campo ' . $Dados['nome'] . '.");
                            history.go(-1);
                            </script>
                            ';
                        exit();
                    }
                }
            }
        }

        beginTransaction();

        Require_Once('cadastro_acao_ant.php');

        $sql_campo = Array();
        $sql_valor = Array();
        $vetUpdate = Array();

        ForEach ($vetCad as $idxGrd => $vetGrd) {
            ForEach ($vetGrd as $idxFrm => $vetFrm) {
                if (is_array($vetFrm['dados'])) {
                    ForEach ($vetFrm['dados'] as $nLinha => $Linha) {
                        ForEach ($Linha as $Coluna) {
                            if (is_array($Coluna)) {
                                if ($Coluna['campo_tabela']) {
                                    campoInsert($sql_campo[$Coluna['tabela']], $sql_valor[$Coluna['tabela']]);

                                    $altera = true;
                                    $vlCampo = $_POST[$Coluna['campo']];

                                    switch ($Coluna['tipo']) {
                                        case 'Senha':
                                            if ($_POST[$Coluna['campo']] == '') {
                                                $altera = false;
                                            }
                                            break;

                                        case 'Checkbox':
                                            if ($vlCampo == '') {
                                                $vlCampo = $Coluna['valor_desmarcado'];
                                            }

                                            if ($vlCampo == '') {
                                                $altera = false;
                                            }
                                            break;

                                        case 'File':
                                            if ($vetFile[$Coluna['campo']]['sql']) {
                                                $vlCampo = mb_strtolower($vetID[$Coluna['tabela']] . '_' . $Coluna['campo'] . '_' . $microtime . '_' . troca_caracter($_FILES[$Coluna['campo']]['name']));
                                            } else if ($_POST['remover_' . $Coluna['campo']] == 'S') {
                                                $vlCampo = '';
                                            } else {
                                                $altera = false;
                                            }
                                            break;
                                    }

                                    if ($altera) {
                                        $vetUpdate[$Coluna['tabela']] .= $Coluna['campo'] . ' = ';

                                        switch (tipo($Coluna['campo'], $Coluna['tabela'])) {
                                            case 'int':
                                            case 'int4':
                                            case 'long':
                                                $vetUpdate[$Coluna['tabela']] .= null($vlCampo);
                                                break;

                                            case 'numeric':
                                            case 'decimal':
                                            case 'newdecimal':
                                            case 'double':
                                                $vetUpdate[$Coluna['tabela']] .= null(desformat_decimal($vlCampo));
                                                break;

                                            case 'date':
                                            case 'datetime':
                                            case 'timestamp':
                                                $vetUpdate[$Coluna['tabela']] .= aspa(trata_data($vlCampo));
                                                break;

                                            default:
                                                if ($Coluna['tipo'] == 'Senha') {
                                                    $vetUpdate[$Coluna['tabela']] .= aspa(md5($vlCampo));
                                                } else {
                                                    $vetUpdate[$Coluna['tabela']] .= aspa($vlCampo);
                                                }
                                                break;
                                        }

                                        $vetUpdate[$Coluna['tabela']] .= ', ';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        foreach ($vetMesclarCadastro as $cadastro_conf) {
            if (!$cadastro_conf['soConsulta']) {
                $tabela_cad = $cadastro_conf['tabela'];
                $id_cad = $cadastro_conf['id'];

                if ($tabela_cad != '' && $vetUpdate[$tabela_cad] != '') {
                    if ($vetID[$tabela_cad] == '') {
                        $vetGravaLog[] = sqlInsert();
                    } else {
                        $sql = "update {$tabela_banco}{$tabela_cad} set ";
                        $sql .= substr($vetUpdate[$tabela_cad], 0, strrpos($vetUpdate[$tabela_cad], ', '));
                        $sql .= " where {$id_cad} = " . null($vetID[$tabela_cad]);
                        execsql($sql);

                        $vetGravaLog[] = Array(
                            'nom_tabela' => $tabela_cad,
                            'sts_acao' => 'A',
                            'des_pk' => $vetID[$tabela_cad],
                            'des_registro' => monta_des($tabela_cad),
                        );
                    }
                }
            }
        }

        cadastra_lista();
        cadastraListarCmbMulti();

        $deucommit = 0;

        if (count($vetFile) > 0) {
            ForEach ($vetFile as $Campo => $Dados) {
                if ($Dados['tabela'] != '') {
                    if (!$vetMesclarCadastro[$Dados['tabela']]['soConsulta']) {
                        $path = $pathObjFile;

                        $path .= DIRECTORY_SEPARATOR . $Dados['tabela'];
                        if (!file_exists($path)) {
                            mkdir($path);
                        }

                        $path .= DIRECTORY_SEPARATOR;

                        if ($Dados['sql']) {
                            set_time_limit(600);

                            imgsize($_FILES[$Campo]['tmp_name'], $_FILES[$Campo]['tmp_name'], $Dados['largura'], $Dados['altura']);

                            $Dados['max_tamanho'] = 0;

                            if (file_exists($_FILES[$Campo]['tmp_name']) && $Dados['max_tamanho'] > 0) {
                                if (filesize($_FILES[$Campo]['tmp_name']) > $Dados['max_tamanho']) {
                                    echo "
                                    <br>
                                    <div align='center' class='Msg'>O arquivo de " . $Dados['nome'] . " ultrapassou o tamanho maximo permitido de " . ($Dados['max_tamanho'] / 1024) . "kb!
                                    <br><br><input type='button' name='btnAcao' class='Botao' value=' Voltar ' onClick='history.go(-1)'>
                                    </div>
                                ";
                                    onLoadPag();
                                    FimTela();
                                    exit();
                                }
                            }

                            if (file_exists($path . $_POST[$Campo . '_ant']) && $_POST[$Campo . '_ant'] != '') {
                                unlink($path . $_POST[$Campo . '_ant']);
                            }

                            $nomearq = mb_strtolower($vetID[$Dados['tabela']] . '_' . $Campo . '_' . $microtime . '_' . troca_caracter($_FILES[$Campo]['name']));
                            move_uploaded_file($_FILES[$Campo]['tmp_name'], $path . $nomearq);
                        } else if ($_POST['remover_' . $Campo] == 'S') {
                            if (file_exists($path . $_POST[$Campo . '_ant']) && $_POST[$Campo . '_ant'] != '') {
                                unlink($path . $_POST[$Campo . '_ant']);
                            }
                        }
                    }
                }
            }
        }

        Require_Once('cadastro_acao_dep.php');

        foreach ($vetGravaLog as $log) {
            grava_log_sis($log['nom_tabela'], $log['sts_acao'], $log['des_pk'], $log['des_registro'], '', '', vetLogDetalhe($log['nom_tabela']));
        }

        if ($deucommit == 0) {
            commit();
        }

        if ($botao_acao == '')
            echo "<script type='text/javascript'>self.location = '" . $pagina . "?prefixo={$prefixo_volta}" . getParametro($par_url) . "#lin{$vlID}';</script>";
        else
            echo $botao_acao;

        onLoadPag();
        exit();
        break;

    case $bt_excluir_lbl:
        beginTransaction();

        Require_Once('cadastro_acao_ant.php');

        if ($excluirCascade === true) {
            $vetMesclarCadastro = array_reverse($vetMesclarCadastro, true);

            foreach ($vetMesclarCadastro as $cadastro_conf) {
                if (!$cadastro_conf['soConsulta']) {
                    $tabela_cad = $cadastro_conf['tabela'];
                    $id_cad = $cadastro_conf['id'];

                    if ($tabela_cad != '') {
                        $sql = "delete from {$tabela_banco}$tabela_cad where $id_cad = " . null($vetID[$tabela_cad]);
                        execsql($sql);

                        $vetGravaLog[] = Array(
                            'nom_tabela' => $tabela_cad,
                            'sts_acao' => 'E',
                            'des_pk' => $vetID[$tabela_cad],
                            'des_registro' => monta_des($tabela_cad),
                        );
                    }
                }
            }
        } else {
            if ($tabela != '') {
                $sql = "delete from {$tabela_banco}$tabela where $id = " . $vlID;
                execsql($sql);

                $vetGravaLog[] = Array(
                    'nom_tabela' => $tabela,
                    'sts_acao' => 'E',
                    'des_pk' => $vlID,
                    'des_registro' => monta_des($tabela),
                );
            }
        }

        Require_Once('cadastro_acao_dep.php');

        foreach ($vetGravaLog as $log) {
            grava_log_sis($log['nom_tabela'], $log['sts_acao'], $log['des_pk'], $log['des_registro'], '', '', vetLogDetalhe($log['nom_tabela']));
        }

        commit();

        if (count($vetFile) > 0) {
            ForEach ($vetFile as $Campo => $Dados) {
                if (!$vetMesclarCadastro[$Dados['tabela']]['soConsulta']) {
                    $path = $pathObjFile;
                    $path .= DIRECTORY_SEPARATOR . $Dados['tabela'];
                    $path .= DIRECTORY_SEPARATOR;

                    if (file_exists($path . $_POST[$Campo . '_ant']) && $_POST[$Campo . '_ant'] != '') {
                        unlink($path . $_POST[$Campo . '_ant']);
                    }
                }
            }
        }

        if ($botao_acao == '')
            echo "<script type='text/javascript'>self.location = '" . $pagina . "?prefixo={$prefixo_volta}" . getParametro($par_url) . "#lin{$vlID}';</script>";
        else
            echo $botao_acao;

        onLoadPag();
        exit();
        break;

    case $bt_personalizado:
        beginTransaction();

        Require_Once('cadastro_acao_dep.php');

        grava_log_sis($tabela, 'P', $vlID, $bt_personalizado);

        commit();

        if ($botao_acao == '')
            echo "<script type='text/javascript'>$target_js.location = '" . $pagina . "?prefixo={$prefixo_volta}" . getParametro($par_url) . "#lin{$vlID}';</script>";
        else
            echo $botao_acao;

        onLoadPag();
        exit();
        break;
}

$path_i = 'cadastro_conf/' . $menu . '_padrao.php';
if (file_exists($path_i)) {
    Require_Once($path_i);
}

if ($acao == 'inc') {
    $path_i = 'cadastro_conf/' . $menu . '_definc.php';
    if (file_exists($path_i)) {
        Require_Once($path_i);
    }
}
if ($acao == 'alt') {
    $path_i = 'cadastro_conf/' . $menu . '_defalt.php';
    if (file_exists($path_i)) {
        Require_Once($path_i);
    }
}

if ($onLoadPag == '') {
    onLoadPag('', 'id');
} else {
    onLoadPag($onLoadPag, 'frm', 'bt_voltar', $onLoadPagGrd);
}

camposObrigatoriosTab();

ForEach ($vetTab as $idxTab => $Tab) {
    if ($Tab != '') {
        $tabHtml .= '<li><a href="#grd' . $idxTab . '"><span>' . $Tab . '</span></a></li>';
    }
}

if ($acao == 'con' || $acao == 'exc' || $acao_alt_con == 'S') {
    $desabilita_html = true;
}

if ($formUpload === '') {
    $formUpload = count($vetFile) > 0;
}
?>
<script type="text/javascript">
    var objLista = new Array();
    var objHtml = new Array();
    var objFile = new Array();
    var objFileMime = new Array();
    var objFileNome = new Array();
    var acao_alt_con = '<?php echo $acao_alt_con; ?>';
    var onSubmitCancelado = null;
    var onSubmitMsgTxt = '';

    var onSubmitMsgOrg = function () {
        var txt = '<?php echo $vetConfMsg[$acao]; ?>';

        if (onSubmitMsgTxt === false) {
            txt = '';
        } else if (onSubmitMsgTxt != '') {
            txt = onSubmitMsgTxt;
        }

        if (txt == '') {
            return true;
        } else {
            return confirm(txt);
        }
    };

    var onSubmitMsg = onSubmitMsgOrg;

    function inclui(lst1, lst2, name_func) {
        var i;

        if (name_func == undefined) {
            name_func = '';
        }

        if (name_func != '') {
            var objFunc = window['objLista_' + name_func + '_ant'];

            if ($.isFunction(objFunc)) {
                objFunc('I', lst1, lst2);
            }
        }

        //Cadastra na lista de usuario
        for (i = 0; i < lst1.length; i++) {
            if (lst1.options[i].selected)
                lst2.options[lst2.length] = new Option(lst1.options[i].text, lst1.options[i].value);
        }

        //Remove da lista de funcao
        for (i = lst1.length - 1; i >= 0; i--) {
            if (lst1.options[i].selected)
                lst1.options[i] = null;
        }

        if (name_func != '') {
            var objFunc = window['objLista_' + name_func + '_dep'];

            if ($.isFunction(objFunc)) {
                objFunc('I', lst1, lst2);
            }
        }
    }

    function exclui(lst1, lst2, name_func) {
        var i;
        var msg = '';

        if (name_func == undefined) {
            name_func = '';
        }

        if (name_func != '') {
            var objFunc = window['objLista_' + name_func + '_ant'];

            if ($.isFunction(objFunc)) {
                objFunc('E', lst1, lst2);
            }
        }

        //Verifica se pode excluir
        for (i = 0; i < lst2.length; i++) {
            if (lst2.options[i].selected && lst2.options[i].value.substr(0, 1) == 'N') {
                msg += lst2.options[i].text + '\n';
                lst2.options[i].selected = false;
            }
        }

        //Cadastra na lista de funcao
        for (i = 0; i < lst2.length; i++) {
            if (lst2.options[i].selected)
                lst1.options[lst1.length] = new Option(lst2.options[i].text, lst2.options[i].value);
        }

        //Remove da lista de usuario
        for (i = lst2.length - 1; i >= 0; i--) {
            if (lst2.options[i].selected)
                lst2.options[i] = null;
        }

        if (name_func != '') {
            var objFunc = window['objLista_' + name_func + '_dep'];

            if ($.isFunction(objFunc)) {
                objFunc('E', lst1, lst2);
            }
        }

        if (msg != '') {
            alert('Não pode excluir da lista os registros:\n\n' + msg);
        }
    }

    function envia() {
        var i;
        var v;
        var id;
        var lista;
        var oEditor;

        if (typeof (FCKeditorAPI) !== "undefined") {
            for (v = 0; v < objHtml.length; v++) {
                oEditor = FCKeditorAPI.GetInstance(objHtml[v]);

                if (oEditor != undefined) {
                    $('#' + objHtml[v]).val(oEditor.GetHTML());
                }
            }
        }

        for (v = 0; v < objLista.length; v++) {
            id = document.frm.elements[objLista[v][0]];
            lista = document.frm.elements[objLista[v][1]];

            id.value = "";
            for (i = 0; i < lista.length; i++)
                id.value = id.value + lista.options[i].value + ',';
        }

        for (v = 0; v < objFile.length; v++) {
            txt = document.frm.elements[objFile[v]].value.split('.');
            txt = txt[txt.length - 1].toLowerCase();

            if (objFileMime[v].indexOf(txt) == -1) {
                alert('O arquivo "' + document.frm.elements[objFile[v]].value + '" não é de um tipo valido para o campo ' + objFileNome[v] + '.');
                return false;
            }
        }

<?php
echo '
        if (' . ($onSubmitAnt == '' ? 'true' : $onSubmitAnt) . ') {
            if (frmFcn()) {
                if (' . ($onSubmitDep == '' ? 'true' : $onSubmitDep) . ') {
                    if (onSubmitMsg()) {
                        if (' . ($onSubmitCon == '' ? 'true' : $onSubmitCon) . ') {
                            $(":disabled").removeProp("disabled");
                            $("#barra_bt_top, #barra_bt_bottom").hide();
                            return true;
                        }
                    }
                }
            }
        }

        onSubmitMsg = onSubmitMsgOrg;
        
        if ($.isFunction(onSubmitCancelado)) {
            onSubmitCancelado();
        }

        return false;
    ';
?>
    }

    var btCloseShowPopWin = false;

    function btClickCTC(objCampo, idCad, acao, id, prefixolocal, menulocal, session_cod, titulo, iframe, iframe_name) {
        var par = '';
        var par_tmp = '';
        var parListarConf = window['parIniListarConf_' + menulocal];

        btCloseShowPopWin = false;

        if ($.isFunction(parListarConf)) {
            par_tmp = parListarConf(idCad, acao, id, objCampo);

            if (par_tmp === false) {
                return false;
            }

            par += par_tmp;
        } else {
            par += '?acao=' + acao;
            par += '&prefixo=' + prefixolocal;
            par += '&menu=' + menulocal;
            par += '&session_cod=' + session_cod;
            par += '&idCad=' + idCad;
            par += '&id=' + id;
            par += '&cas=' + conteudo_abrir_sistema;
        }

        parListarConf = window['parListarConf_' + menulocal];

        if ($.isFunction(parListarConf)) {
            par_tmp = parListarConf(idCad, id, objCampo, acao);

            if (par_tmp === false) {
                return false;
            }

            par += par_tmp;
        }

        if (iframe == 'S') {
            par += '&iframe_name=' + iframe_name;

            var url = 'conteudo_listarcmb.php' + par;
            $('#' + iframe_name + '_aviso').show();
            $('#' + iframe_name).attr('src', url).show();

            $('div.Barra input.Botao').prop("disabled", true).addClass("BotaoDisabled").attr('title', 'Botão Destivado!');

            parListarConf = window['parListarConfIframeOpen_' + menulocal];

            if ($.isFunction(parListarConf)) {
                parListarConf();
            }
        } else {
            var url = 'conteudo_cadastro.php' + par;
            showPopWin(url, titulo, $('div.showPopWin_width').width() - 10, $(window).height() - 100, null, btCloseShowPopWin);
        }

        return false;
    }

    function tablesorterCTC(campo_frm, sortList) {
        $('#' + campo_frm + '_desc table.tablesorter-default').tablesorter({
            sortList: sortList,
            widgetOptions: {
                columns_thead: true,
                columns_tfoot: true
            }
        });
    }

    function btFechaCTC(session_cod, funcaoFechaCTC, funcaoFechaCTCAnt, returnVal) {
        btFechaCTCAcao(true, session_cod, funcaoFechaCTC, funcaoFechaCTCAnt, returnVal);
    }

    function refreshCTC(session_cod, funcaoFechaCTC, funcaoFechaCTCAnt, returnVal) {
        btFechaCTCAcao(false, session_cod, funcaoFechaCTC, funcaoFechaCTCAnt, returnVal);
    }

    function btFechaCTCAcao(fechaTela, session_cod, funcaoFechaCTC, funcaoFechaCTCAnt, returnVal) {
        if ($.isFunction(funcaoFechaCTCAnt)) {
            var ok = funcaoFechaCTCAnt(returnVal);

            if (ok === false) {
                return false;
            }
        }

        var menulocal = '';

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_plu + '&tipo=listarconf',
            data: {
                cas: conteudo_abrir_sistema,
                session_cod: session_cod
            },
            success: function (response) {
                menulocal = response.menulocal;

                var sortTab = $('#' + response.campo + '_desc table.tablesorter-default');
                var sortList = [];

                if (sortTab.length == 1) {
                    if (sortTab[0].config != undefined) {
                        sortList = sortTab[0].config.sortList;
                    }
                }

                $('#' + response.campo + '_desc > div').html(url_decode(response.html));
                $('#' + response.campo + '_frm').hide().attr('src', 'vazio.php');

                if (response.js_comcontrole == 0 && $('#' + response.campo + '_desc td.Titulo_ctl').css('display') != 'none') {
                    $('#' + response.campo + '_desc td.acao_fecha:first').click();
                }

                tablesorterCTC(response.campo, sortList);

                if (fechaTela) {
                    hidePopWin(false);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        if ($.isFunction(funcaoFechaCTC)) {
            funcaoFechaCTC(returnVal);
        }

        var funcaoFechaCTCAjaxDep = window['funcaoFechaCTCAjaxDep_' + menulocal];

        if ($.isFunction(funcaoFechaCTCAjaxDep)) {
            funcaoFechaCTCAjaxDep();
        }

        if (fechaTela) {
            $('div.Barra input.Botao').removeProp("disabled").removeClass("BotaoDisabled").removeAttr('title');
            TelaHeight();
        }
    }

	function func_AtivaDesativa(vl_campo, vl_padrao, campo, obr, obr_valor, igual_valor, obr_igual_valor, vlPadraoDesativa, vlLimpaDesativa) {
        if (vlLimpaDesativa == undefined) {
            vlLimpaDesativa = true;
        }

        var vl = $.inArray(vl_campo, vl_padrao) > -1;

        if (igual_valor == 'N') {
            vl = !vl;
        }

        var ListarConf = campo.filter("[data-tipo='ListarConf']").parent().find('a');
        var ListarCmb = campo.filter("[data-tipo='ListarCmb']").parent().find('.bt_acao');

        if (vl) {
            ListarConf.hide();
            ListarCmb.hide();

            obr.addClass("Tit_Campo");
            obr.removeClass("Tit_Campo_Obr");

            campo.each(function () {
                var disabled = campo.prop("disabled");

                if (vlLimpaDesativa) {
                    if ($(this).prop('checked')) {
                        $(this).removeProp('checked');
                    } else {
                        $(this).val("");
                    }
                }

                switch ($(this).data('tipo')) {
                    case 'Lista':
                        if (vlLimpaDesativa) {
                            var lst1 = document.getElementById($(this).attr('id') + '_org');
                            var lst2 = document.getElementById($(this).attr('id') + '_lista');

                            //Verifica se pode excluir
                            for (i = 0; i < lst2.length; i++) {
                                if (lst2.options[i].value.substr(0, 1) == 'N') {
                                    lst2.options[i].selected = false;
                                } else {
                                    lst2.options[i].selected = true;
                                }
                            }

                            //Cadastra na lista de funcao
                            for (i = 0; i < lst2.length; i++) {
                                if (lst2.options[i].selected)
                                    lst1.options[lst1.length] = new Option(lst2.options[i].text, lst2.options[i].value);
                            }

                            //Remove da lista de usuario
                            for (i = lst2.length - 1; i >= 0; i--) {
                                if (lst2.options[i].selected)
                                    lst2.options[i] = null;
                            }
                        }

                        $('#' + $(this).attr('id') + '_desc select').prop("disabled", true).addClass("campo_disabled");
                        break;

                    case 'ListarCmb':
                        if (vlLimpaDesativa) {
                            ListarCmbLimpa($(this).attr('id'));
                        }
                        break;

                    case 'ListarCmbMulti':
                        $('#' + $(this).attr('id') + '_desc .bt_acao').hide();

                        if (vlLimpaDesativa) {
                            ListarCmbMultiLimpa($(this).attr('id'), $('#' + $(this).attr('id') + '_obj ul').data('session_cod'));
                        }
                        break;

                    case 'CEP':
                        $('#' + $(this).attr('id') + '_obj .bt_acao').hide();
                        break;

                    case 'Data':
                    case 'DataHora':
                        $('#' + $(this).attr('id') + '_obj .ui-datepicker-trigger').hide();
                        break;

                    default:
                        if (vlPadraoDesativa != '' && !disabled) {
                            $(this).val(vlPadraoDesativa);
                        }
                        break;
                }
            });

            //Este IF esta errado tem que melhorar para pode fazer as replicações para os outros campos.
            //O IF foi colocado para não apagar os dados do CEP quando não é para limpar os valores na desativação
            if (vlLimpaDesativa) {
                campo.change();
            }

            campo.prop("disabled", true);
            campo.addClass("campo_disabled");
        } else {
            campo.removeProp("disabled");
            campo.removeClass("campo_disabled");

            ListarConf.show();
            ListarCmb.show();

            campo.each(function () {
                var disabled = campo.prop("disabled");

                switch ($(this).data('tipo')) {
                    case 'Lista':
                        $('#' + $(this).attr('id') + '_desc select').removeProp("disabled").removeClass("campo_disabled");
                        break;

                    case 'ListarCmbMulti':
                        $('#' + $(this).attr('id') + '_desc .bt_acao').show();
                        break;

                    case 'CEP':
                        $('#' + $(this).attr('id') + '_obj .bt_acao').show();
                        break;

                    case 'Data':
                    case 'DataHora':
                        $('#' + $(this).attr('id') + '_obj .ui-datepicker-trigger').show();
                        break;

                    case 'cmbBanco':
                    case 'cmbVetor':
                        if (disabled) {
                            $('#' + $(this).attr('id') + ' option:first').prop('selected', true).change();
                        }
                        break;
                }
            });

            vl = $.inArray(vl_campo, obr_valor) > -1;

            if (obr_igual_valor == 'N') {
                vl = !vl;
            }

            if (vl) {
                obr.addClass("Tit_Campo_Obr");
                obr.removeClass("Tit_Campo");
            } else {
                obr.addClass("Tit_Campo");
                obr.removeClass("Tit_Campo_Obr");
            }
        }
    }

    function CEPClose(returnVal) {
        var vr = returnVal.valor;
        var campo = returnVal.campo;

        $('#' + campo).val(vr.substr(0, 2) + '.' + vr.substr(2, 3) + '-' + vr.substr(5, 3));
        $('#bt_cep_' + campo).click();
    }

    function CEPAjaxSuccess(mudavalor, campo, tipo, travado, valor, nome) {
        if (campo != '') {
            var $campo = $("#" + campo);

            $campo.removeProp("disabled");
            $campo.removeClass("campo_disabled");

            if (mudavalor) {
                switch (tipo) {
                    case 'cmb_val':
                        $campo.data('cascade_val', url_decode(valor));
                        $campo.data('cascade_disabled', travado);

                        var opt = $campo.find('option').filter(function () {
                            return $.trim($(this).val()) == url_decode(valor);
                        });

                        opt.prop('selected', true);
                        $campo.change();
                        break;

                    case 'cmb_txt':
                        $campo.data('cascade_txt', url_decode(valor));
                        $campo.data('cascade_disabled', travado);

                        var opt = $campo.find('option').filter(function () {
                            return $.trim($(this).text()) == url_decode(valor);
                        });

                        opt.prop('selected', true);
                        $campo.change();
                        break;

                    case 'cmb_fixo':
                        $campo.val(url_decode(valor));
                        $("#" + campo + '_tf').text(url_decode(nome));
                        break;

                    default:
                        $campo.val(url_decode(valor));
                        break;
                }

                CEPTrava(campo, tipo, travado);
            }
        }
    }

    function CEPTrava(campo, tipo, travado) {
        if (campo != '') {
            var $campo = $("#" + campo);

            $campo.removeProp("disabled");
            $campo.removeClass("campo_disabled");

            switch (tipo) {
                case 'cmb_val':
                case 'cmb_txt':
                    var opt = $campo.find('option:selected');

                    if (travado == 'S' && opt.length > 0) {
                        $campo.prop("disabled", true);
                        $campo.addClass("campo_disabled");
                    }
                    break;

                case 'cmb_fixo':
                    //já é travado...
                    break;

                default:
                    if (travado == 'S' && $campo.val() != '') {
                        $campo.prop("disabled", true);
                        $campo.addClass("campo_disabled");
                    }
                    break;
            }
        }
    }

    function CEPLimpa(campo, so_limpa) {
        if (campo != '') {
            var $campo = $("#" + campo);

            if (so_limpa === true) {
                $campo.val('');
            } else {
                $campo.removeProp("disabled");
                $campo.removeClass("campo_disabled");
                $campo.data('cascade_disabled', 'N');
                $campo.val('');
                $campo.change();
            }

            $("#" + campo + '_tf').text('');
        }
    }

    function DescPer(campo, txt) {
        $('#' + campo).data('desc_per', txt);
        $('#' + campo + '_desc span.desc_per').html(txt);
    }

    // Create IE + others compatible event handler
    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];
    var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

    // Listen to message from child window
    eventer(messageEvent, function (e) {
        var obj = JSON.parse(e.data);
        var height = parseInt(obj.height) + 20;
        $('#' + obj.iframe_name).height(height);
        TelaHeight();
    }, false);

</script>
<form id="frm" name="frm" <?php echo ($formUpload ? 'enctype="multipart/form-data"' : '') ?> target="_self" action="<?php echo $pagina ?>?<?php echo substr(getParametro(), 1) ?>" method="post" onSubmit="return envia()" style="margin:0px;">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $vetConf['max_upload_size']; ?>">
    <input type="hidden" name="id" id="id" value="<?php echo $_GET['id'] ?>">
    <?php
    $path = 'cadastro_conf/' . $menu . '_ant.php';
    if (file_exists($path)) {
        Require_Once($path);
    }

    bt_codigo(True);

    ForEach ($vetCad as $idxGrd => $vetGrd) {
        if ($tabHtml != '' && $idxGrd == $posTabIni) {
            echo '<div id="tabHtml"><ul>' . $tabHtml . '</ul>' . nl();
        }

        echo '<div id="grd' . $idxGrd . '" class="grupo">' . nl();

        ForEach ($vetGrd as $idxFrm => $vetFrm) {
            $html_controle = '';
            $vetFrmParametro = $vetFrm['vetParametros'];

            if ($vetFrmParametro['align'] == '') {
                $vetFrmParametro['align'] = 'center';
            }

            echo '<fieldset id="frm' . $idxFrm . '" class="frame ' . $vetFrm['class_frame'] . ' ' . $vetFrmParametro['codigo_pai'] . '" data-codigo_pai="' . $vetFrmParametro['codigo_pai'] . '">' . nl();

            if ($vetFrmParametro['situacao_padrao'] == true) {
                $html_controle .= '<img class="situacao_padrao"';
                $html_controle .= ' src="' . $vetFrmParametro['situacao_padrao_img'] . '"';
                $html_controle .= ' title="' . $vetFrmParametro['situacao_padrao_titulo'] . '"';
                $html_controle .= ' />';
            }

            if ($vetFrmParametro['situacao_padrao_abre'] == true) {
                $html_controle .= '<img class="situacao_padrao_abre"';
                $html_controle .= ' src="' . $vetFrmParametro['situacao_padrao_abre_img'] . '"';
                $html_controle .= ' title="' . $vetFrmParametro['situacao_padrao_abre_titulo'] . '"';
                $html_controle .= ' />';
            }

            if ($vetFrmParametro['situacao_padrao_fecha'] == true) {
                $html_controle .= '<img class="situacao_padrao_fecha"';
                $html_controle .= ' src="' . $vetFrmParametro['situacao_padrao_fecha_img'] . '"';
                $html_controle .= ' title="' . $vetFrmParametro['situacao_padrao_fecha_titulo'] . '"';
                $html_controle .= ' />';
            }

            if ($vetFrmParametro['controle_fecha'] !== false) {
                $html_controle .= '<img class="bt_controle_fecha"';
                $html_controle .= ' id="' . $vetFrmParametro['codigo_frm'] . '"';
                $html_controle .= ' data-inicio="' . $vetFrmParametro['controle_fecha'] . '"';
                $html_controle .= ' src="' . $vetFrmParametro['bt_img_abre'] . '"';
                $html_controle .= ' title="' . $vetFrmParametro['bt_titulo'] . '"';
                $html_controle .= ' />';
            }

            if ($vetFrm['nome'] == '') {
                if ($html_controle != '') {
                    echo '<div class="' . $vetFrm['class_titulo'] . '">' . $html_controle . '</div>' . nl();
                }
            } else {
                if ($vetFrm['titulo_na_linha']) {
                    echo '<legend class="' . $vetFrm['class_titulo'] . '">' . $html_controle . $vetFrm['nome'] . '</legend>' . nl();
                } else {
                    echo '<div class="' . $vetFrm['class_titulo'] . '">' . $html_controle . $vetFrm['nome'] . '</div>' . nl();
                }
            }

            if (is_array($vetFrm['dados'])) {
                echo '<table border="0" width="' . $vetFrmParametro['width'] . '" cellspacing="0" cellpadding="0" align="' . $vetFrmParametro['align'] . '">' . nl();

                ForEach ($vetFrm['dados'] as $Linha) {
                    echo "<tr>\n";

                    ForEach ($Linha as $Coluna) {
                        if (is_array($Coluna)) {
                            $row = $vetRow[$Coluna['tabela']];

                            if (is_array($vetRowAnt)) {
                                $rowAnt = $vetRowAnt[$Coluna['tabela']];
                            }

                            $idInput = $Coluna['campo'];

                            if ($Coluna['tipo'] == 'Checkbox') {
                                $idInput = str_replace('[', '', $idInput);
                                $idInput = str_replace(']', '', $idInput);
                            }

                            echo '<td id="' . $idInput . '_desc" colspan="' . $Coluna['coluna'] . '" rowspan="' . $Coluna['linha'] . '" class="Tit_Campo' . ($Coluna['valida'] ? '_Obr' : '') . '">';

                            switch ($Coluna['tipo']) {
                                case 'Lista':
                                    codigo_lista();
                                    break;

                                case 'Include':
                                    if (file_exists($Coluna['arquivo_html'])) {
                                        extract($Coluna['vetVariavel']);
                                        Require($Coluna['arquivo_html']);
                                    } else {
                                        echo $Coluna['arquivo_html'];
                                    }
                                    break;

                                case 'ListarConf':
                                    codigoListarConf($Coluna, $vetID);
                                    break;

                                case 'HiddenSql':
                                    if ($_GET[$Coluna['id'] . $Coluna['num_id']] > 0) {
                                        $sql = 'select ' . $Coluna['desc'] . ' from ' . $Coluna['tabela_obj'] . ' where ' . $Coluna['id'] . ' = ' . aspa($_GET[$Coluna['id'] . $Coluna['num_id']]);
                                        $rs_fixo = execsql($sql);

                                        echo '<input id="' . $idInput . '" name="' . $Coluna['campo'] . '" type="hidden" value="' . trata_html($rs_fixo->data[0][$Coluna['desc']], ENT_QUOTES, 'ISO-8859-1') . '">';
                                    } else {
                                        echo '<input id="' . $idInput . '" name="' . $Coluna['campo'] . '" type="hidden">';
                                    }
                                    echo '<img src="imagens/trans.gif" width="0" height="0" border="0">';
                                    break;

                                case 'AutoNum':
                                    if ($Coluna['nome'] != '' && $Coluna['mostra'])
                                        echo '<label for="' . $idInput . '">' . $Coluna['nome'] . ':<span class="asterisco">*</span></label>';
                                    break;

                                case 'ListarCmb':
                                    echo '<label for="' . $idInput . '" onclick="return help_campo(' . "event, ' " . $Coluna['campo'] . "', '" . $tabela . "', '" . $Coluna['nome'] . "'" . ');">' . $Coluna['nome'] . ':<span class="asterisco">*</span></label>';
                                    break;

                                case 'ListarCmbMulti':
                                    echo '<label for="' . $idInput . '" onclick="return help_campo(' . "event, ' " . $Coluna['campo'] . "', '" . $tabela . "', '" . $Coluna['nome'] . "'" . ');">' . $Coluna['nome'] . ':<span class="asterisco">*</span></label>';

                                    echo '<img class="bt_acao" src="imagens/bt_pesquisa.png" title="Buscar Registro" onclick="ListarCmbMultiClick(\'' . $Coluna['campo'] . '\', \'' . $Coluna['arq_cmb'] . '\', \'' . $Coluna['session_cod'] . '\', \'' . $Coluna['titulo_tela'] . '\');" />';
                                    echo '<img class="bt_acao" src="imagens/bt_limpar.png" title="Limpar" onclick="ListarCmbMultiLimpa(\'' . $Coluna['campo'] . '\', \'' . $Coluna['session_cod'] . '\');" />';
                                    break;

                                case 'BarraTitulo':
                                    echo '<div ' . $Coluna['class'] . '>' . $Coluna['nome'] . '</div>';
                                    break;

                                default:
                                    if ($Coluna['nome'] != '') {
                                        echo '<label for="' . $idInput . '" onclick="return help_campo(' . "event, ' " . $Coluna['campo'] . "', '" . $tabela . "', '" . $Coluna['nome'] . "'" . ');"><span class="desc_per">' . $Coluna['nome'] . '</span>:<span class="asterisco">*</span></label>';
                                    }
                                    break;
                            }

                            if (is_array($vetRowAnt)) {
                                if ($row[$Coluna['campo']] != $rowAnt[$Coluna['campo']]) {
                                    echo '<img class="aviso_ant" src="imagens/valor_alterado.png" title="Valor Original: ' . $rowAnt[$Coluna['campo']] . '" border="0">';
                                }
                            }

                            echo "</td>\n";
                        } else {
                            if ($Coluna == '') {
                                $ColunaID = '';
                            } else {
                                $ColunaID = ' id="' . $Coluna . '_desc"';
                            }

                            echo '<td' . $ColunaID . '><img src="imagens/trans.gif" width="' . $vetFrmParametro['espaco_img_size'] . '" height="0" border="0"></td>' . "\n";
                        }
                    }

                    echo "</tr><tr>\n";

                    ForEach ($Linha as $Coluna) {
                        if (is_array($Coluna)) {
                            $row = $vetRow[$Coluna['tabela']];

                            $idInput = $Coluna['campo'];

                            if ($Coluna['tipo'] == 'Checkbox') {
                                $idInput = str_replace('[', '', $idInput);
                                $idInput = str_replace(']', '', $idInput);
                            }

                            if ($Coluna['tipo'] != 'Include' && $Coluna['tipo'] != 'ListarConf' && $Coluna['tipo'] != 'BarraTitulo') {
                                echo '<td id="' . $idInput . '_obj" class="Obj_Campo' . ($Coluna['valida'] ? '_Obr' : '') . '" colspan="' . $Coluna['coluna'] . '">';

                                switch ($Coluna['tipo']) {
                                    case 'Geral':
                                        if (tipo($Coluna['campo'], $Coluna['tabela']) == 'date' || tipo($Coluna['campo'], $Coluna['tabela']) == 'datetime' || tipo($Coluna['campo'], $Coluna['tabela']) == 'timestamp')
                                            $valor = trata_data($row[$Coluna['campo']]);
                                        else
                                            $valor = $row[$Coluna['campo']];

                                        if ($valor == '') {
                                            $valor = $Coluna['valor'];
                                        }

                                        $valor = trata_html($valor, ENT_QUOTES, 'ISO-8859-1');

                                        echo '<input id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" type="text" class="Texto" value="' . $valor . '" size="' . $Coluna['size'] . '" maxlength="' . $Coluna['maxlength'] . '" ' . $Coluna['js'] . ' />';
                                        break;

                                    case 'CEP':
                                        $valor = $row[$Coluna['campo']];

                                        if ($valor == '') {
                                            $valor = $Coluna['valor'];
                                        }

                                        $valor = trata_html($valor, ENT_QUOTES, 'ISO-8859-1');

                                        echo '<input id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" type="text" class="Texto" value="' . $valor . '" size="10" maxlength="10" onkeyup="return Formata_Cep(this,event)" onblur="return IsCEP(this)" />';

                                        $vetParametros = $Coluna['vetParametros'];

                                        if ($vetParametros['consulta_cep']) {
                                            echo '<img id="bt_cep_' . $Coluna['campo'] . '" class="bt_acao" border="0" style="margin-left: 3px; cursor: pointer; vertical-align: middle;" src="' . $vetParametros['bt_img'] . '" title="' . $vetParametros['bt_title'] . '" alt="' . $vetParametros['bt_title'] . '">';
                                            echo '<img id="bt_ceplimpa_' . $Coluna['campo'] . '" class="bt_acao"  border="0" style="margin-left: 3px; cursor: pointer; vertical-align: middle;" src="imagens/bt_limpar.png" title="Limpar" />';
                                            ?>
                                            <script type="text/javascript">
                                                $(document).ready(function () {
                                                    $('#bt_cep_<?php echo $Coluna['campo']; ?>').click(function () {
                                                        if (IsCEP($('#<?php echo $Coluna['campo']; ?>')[0]) === false) {
                                                            return false;
                                                        }

                                                        if ($('#<?php echo $Coluna['campo']; ?>').val() == '') {
                                                            var par = '';
                                                            par += '?prefixo=listar_cmb';
                                                            par += '&menu=busca_cep';
                                                            par += '&campo=<?php echo $Coluna['campo']; ?>';
                                                            par += '&cas=' + conteudo_abrir_sistema;
                                                            var url = 'conteudo_cadastro.php' + par;
                                                            showPopWin(url, 'Consulta do CEP', $('div.showPopWin_width').width() - 30, $(window).height() - 100, CEPClose, false);
                                                        } else {
                                                            $.ajax({
                                                                dataType: 'json',
                                                                type: 'POST',
                                                                url: ajax_plu + '&tipo=busca_cep',
                                                                data: {
                                                                    cas: conteudo_abrir_sistema,
                                                                    val: $('#<?php echo $Coluna['campo']; ?>').val()
                                                                },
                                                                success: function (response) {
                                                                    if (response.qtd == 1) {
                                                                        var val_pais = '';

                                                                        if ('<?php echo $vetParametros['retorno_pais']; ?>' == 'S') {
                                                                            val_pais = response.pais_sigla;
                                                                        } else {
                                                                            val_pais = response.pais_nome;
                                                                        }

                                                                        var val_uf = '';

                                                                        if ('<?php echo $vetParametros['retorno_uf']; ?>' == 'S') {
                                                                            val_uf = response.uf_sigla;
                                                                        } else {
                                                                            val_uf = response.uf_nome;
                                                                        }

                                                                        var mudavalor = true;

                                                                        if (response.ceptipo == 'LOC') {
                                                                            mudavalor = false;
                                                                        }

                                                                        CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_codpais']; ?>', '<?php echo $vetParametros['tipo_codpais']; ?>', '<?php echo $vetParametros['travado_codpais']; ?>', response.codpais, val_pais);
                                                                        CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_pais']; ?>', '<?php echo $vetParametros['tipo_pais']; ?>', '<?php echo $vetParametros['travado_pais']; ?>', val_pais, '');
                                                                        CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_codest']; ?>', '<?php echo $vetParametros['tipo_codest']; ?>', '<?php echo $vetParametros['travado_codest']; ?>', response.codest, val_uf);
                                                                        CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_uf']; ?>', '<?php echo $vetParametros['tipo_uf']; ?>', '<?php echo $vetParametros['travado_uf']; ?>', val_uf, '');
                                                                        CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_codcid']; ?>', '<?php echo $vetParametros['tipo_codcid']; ?>', '<?php echo $vetParametros['travado_codcid']; ?>', response.codcid, response.cidade);
                                                                        CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_cidade']; ?>', '<?php echo $vetParametros['tipo_cidade']; ?>', '<?php echo $vetParametros['travado_cidade']; ?>', response.cidade, '');
                                                                        CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_codbairro']; ?>', '<?php echo $vetParametros['tipo_codbairro']; ?>', '<?php echo $vetParametros['travado_codbairro']; ?>', response.codbairro, response.bairro);
                                                                        CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_bairro']; ?>', '<?php echo $vetParametros['tipo_bairro']; ?>', '<?php echo $vetParametros['travado_bairro']; ?>', response.bairro, '');
                                                                        CEPAjaxSuccess(mudavalor, '<?php echo $vetParametros['campo_logradouro']; ?>', '<?php echo $vetParametros['tipo_logradouro']; ?>', '<?php echo $vetParametros['travado_logradouro']; ?>', response.logradouro, '');

                                                                        $('#<?php echo $Coluna['campo']; ?>').prop("disabled", true).addClass("campo_disabled");
                                                                    } else {
                                                                        $('#<?php echo $Coluna['campo']; ?>').val('');

                                                                        var par = '';
                                                                        par += '?prefixo=listar_cmb';
                                                                        par += '&menu=busca_cep';
                                                                        par += '&campo=<?php echo $Coluna['campo']; ?>';
                                                                        par += '&cas=' + conteudo_abrir_sistema;
                                                                        var url = 'conteudo_cadastro.php' + par;
                                                                        showPopWin(url, 'Consulta do CEP', $('div.showPopWin_width').width() - 30, $(window).height() - 100, CEPClose, false);
                                                                    }
                                                                },
                                                                error: function (jqXHR, textStatus, errorThrown) {
                                                                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                                                                },
                                                                async: false
                                                            });
                                                        }
                                                    });

                                                    $('#bt_ceplimpa_<?php echo $Coluna['campo']; ?>').click(function () {
                                                        $('#<?php echo $Coluna['campo']; ?>').removeProp("disabled").removeClass("campo_disabled").val('');

                                                        CEPLimpa('<?php echo $vetParametros['campo_codpais']; ?>');
                                                        CEPLimpa('<?php echo $vetParametros['campo_pais']; ?>');
                                                        CEPLimpa('<?php echo $vetParametros['campo_codest']; ?>');
                                                        CEPLimpa('<?php echo $vetParametros['campo_uf']; ?>');
                                                        CEPLimpa('<?php echo $vetParametros['campo_codcid']; ?>');
                                                        CEPLimpa('<?php echo $vetParametros['campo_cidade']; ?>');
                                                        CEPLimpa('<?php echo $vetParametros['campo_codbairro']; ?>');
                                                        CEPLimpa('<?php echo $vetParametros['campo_bairro']; ?>');
                                                        CEPLimpa('<?php echo $vetParametros['campo_logradouro']; ?>');
                                                    });

                                                    var objCEP = $('#<?php echo $Coluna['campo']; ?>');

                                                    objCEP.change(function () {
                                                        if ($(this).val() == '') {
                                                            CEPLimpa('<?php echo $vetParametros['campo_codpais']; ?>', true);
                                                            CEPLimpa('<?php echo $vetParametros['campo_pais']; ?>', true);
                                                            CEPLimpa('<?php echo $vetParametros['campo_codest']; ?>', true);
                                                            CEPLimpa('<?php echo $vetParametros['campo_uf']; ?>', true);
                                                            CEPLimpa('<?php echo $vetParametros['campo_codcid']; ?>', true);
                                                            CEPLimpa('<?php echo $vetParametros['campo_cidade']; ?>', true);
                                                            CEPLimpa('<?php echo $vetParametros['campo_codbairro']; ?>', true);
                                                            CEPLimpa('<?php echo $vetParametros['campo_bairro']; ?>', true);
                                                            CEPLimpa('<?php echo $vetParametros['campo_logradouro']; ?>', true);
                                                        } else {
                                                            $('#bt_cep_<?php echo $Coluna['campo']; ?>').click();
                                                        }
                                                    });

                                                    if (objCEP.val() != '') {
                                                        objCEP.prop("disabled", true).addClass("campo_disabled");

                                                        $.ajax({
                                                            dataType: 'json',
                                                            type: 'POST',
                                                            url: ajax_plu + '&tipo=busca_cep',
                                                            data: {
                                                                cas: conteudo_abrir_sistema,
                                                                val: $('#<?php echo $Coluna['campo']; ?>').val()
                                                            },
                                                            success: function (response) {
                                                                if (response.qtd == 1) {
                                                                    var val_pais = '';

                                                                    if ('<?php echo $vetParametros['retorno_pais']; ?>' == 'S') {
                                                                        val_pais = response.pais_sigla;
                                                                    } else {
                                                                        val_pais = response.pais_nome;
                                                                    }

                                                                    var val_uf = '';

                                                                    if ('<?php echo $vetParametros['retorno_uf']; ?>' == 'S') {
                                                                        val_uf = response.uf_sigla;
                                                                    } else {
                                                                        val_uf = response.uf_nome;
                                                                    }

                                                                    var mudavalor = true;

                                                                    if (response.ceptipo == 'LOC') {
                                                                        mudavalor = false;
                                                                    }

                                                                    CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_codpais']; ?>', '<?php echo $vetParametros['tipo_codpais']; ?>', '<?php echo $vetParametros['travado_codpais']; ?>', response.codpais, val_pais);
                                                                    CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_pais']; ?>', '<?php echo $vetParametros['tipo_pais']; ?>', '<?php echo $vetParametros['travado_pais']; ?>', val_pais, '');
                                                                    CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_codest']; ?>', '<?php echo $vetParametros['tipo_codest']; ?>', '<?php echo $vetParametros['travado_codest']; ?>', response.codest, val_uf);
                                                                    CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_uf']; ?>', '<?php echo $vetParametros['tipo_uf']; ?>', '<?php echo $vetParametros['travado_uf']; ?>', val_uf, '');
                                                                    CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_codcid']; ?>', '<?php echo $vetParametros['tipo_codcid']; ?>', '<?php echo $vetParametros['travado_codcid']; ?>', response.codcid, response.cidade);
                                                                    CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_cidade']; ?>', '<?php echo $vetParametros['tipo_cidade']; ?>', '<?php echo $vetParametros['travado_cidade']; ?>', response.cidade, '');
                                                                    CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_codbairro']; ?>', '<?php echo $vetParametros['tipo_codbairro']; ?>', '<?php echo $vetParametros['travado_codbairro']; ?>', response.codbairro, response.bairro);
                                                                    CEPAjaxSuccess(true, '<?php echo $vetParametros['campo_bairro']; ?>', '<?php echo $vetParametros['tipo_bairro']; ?>', '<?php echo $vetParametros['travado_bairro']; ?>', response.bairro, '');
                                                                    CEPAjaxSuccess(mudavalor, '<?php echo $vetParametros['campo_logradouro']; ?>', '<?php echo $vetParametros['tipo_logradouro']; ?>', '<?php echo $vetParametros['travado_logradouro']; ?>', response.logradouro, '');

                                                                    $('#<?php echo $Coluna['campo']; ?>').prop("disabled", true).addClass("campo_disabled");
                                                                }
                                                            },
                                                            error: function (jqXHR, textStatus, errorThrown) {
                                                                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                                                            },
                                                            async: false
                                                        });
                                                    }

                                                    /*
                                                     CEPTrava('<?php echo $vetParametros['campo_codpais']; ?>', '<?php echo $vetParametros['travado_codpais']; ?>', '<?php echo $vetParametros['travado_codpais']; ?>');
                                                     CEPTrava('<?php echo $vetParametros['campo_pais']; ?>', '<?php echo $vetParametros['travado_pais']; ?>', '<?php echo $vetParametros['travado_pais']; ?>');
                                                     CEPTrava('<?php echo $vetParametros['campo_codest']; ?>', '<?php echo $vetParametros['travado_codest']; ?>', '<?php echo $vetParametros['travado_codest']; ?>');
                                                     CEPTrava('<?php echo $vetParametros['campo_uf']; ?>', '<?php echo $vetParametros['travado_uf']; ?>', '<?php echo $vetParametros['travado_uf']; ?>');
                                                     CEPTrava('<?php echo $vetParametros['campo_codcid']; ?>', '<?php echo $vetParametros['travado_codcid']; ?>', '<?php echo $vetParametros['travado_codcid']; ?>');
                                                     CEPTrava('<?php echo $vetParametros['campo_cidade']; ?>', '<?php echo $vetParametros['travado_cidade']; ?>', '<?php echo $vetParametros['travado_cidade']; ?>');
                                                     CEPTrava('<?php echo $vetParametros['campo_codbairro']; ?>', '<?php echo $vetParametros['travado_codbairro']; ?>', '<?php echo $vetParametros['travado_codbairro']; ?>');
                                                     CEPTrava('<?php echo $vetParametros['campo_bairro']; ?>', '<?php echo $vetParametros['travado_bairro']; ?>', '<?php echo $vetParametros['travado_bairro']; ?>');
                                                     CEPTrava('<?php echo $vetParametros['campo_logradouro']; ?>', '<?php echo $vetParametros['travado_logradouro']; ?>', '<?php echo $vetParametros['travado_logradouro']; ?>');
                                                     */
                                                });
                                            </script>
                                            <?php
                                        }
                                        break;

                                    case 'Decimal':
                                        if ($row[$Coluna['campo']] == '') {
                                            $valor = $Coluna['vl_padrao'];
                                        } else {
                                            $valor = $row[$Coluna['campo']];
                                        }

                                        echo '<input id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo_name'] . '" type="text" class="Texto" value="' . trata_html(format_decimal($valor, $Coluna['num_decimais'])) . '" size="' . $Coluna['size'] . '" maxlength="' . $Coluna['maxlength'] . '" ' . $Coluna['js'] . ' />';
                                        break;

                                    case 'Senha':
                                        echo '<input id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" type="password" class="Texto" size="' . $Coluna['size'] . '" maxlength="' . $Coluna['maxlength'] . '" ' . $Coluna['js'] . ' />';
                                        break;

                                    case 'Data':
                                        if ($Coluna['js'] == '') {
                                            $js = 'onblur="return checkdate(this)" onkeyup="return Formata_Data(this,event)"';
                                        } else {
                                            $js = $Coluna['js'];
                                        }

                                        if ($row[$Coluna['campo']] == '') {
                                            $valor = $Coluna['vl_padrao'];
                                        } else {
                                            $valor = trata_data($row[$Coluna['campo']]);
                                        }

                                        echo '<input id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" type="text" class="Texto" value="' . $valor . '" size="10" maxlength="10" ' . $js . '>';

                                        if ($Coluna['datepicker'] != '' && !$desabilita_html) {
                                            $vetpicker = $Coluna['vetpicker'];
                                            $direcao = $vetpicker['direcao'];
                                            $qtd = $vetpicker['qtd'];

                                            if ($qtd == '') {
                                                $qtd = 1;
                                            }

                                            echo '
                                                <script type="text/javascript">
                                                    $(function() {
                                                        $("#' . $Coluna['campo'] . '").datepicker({
                                                            showOn: \'button\',
                                                            changeMonth: true,
                                                            changeYear: true,
                                                            numberOfMonths: ' . $qtd . ',
                                                            buttonText: \'Selecionar a data\',
                                                            buttonImage: \'imagens/calendar.gif\',
                                                            buttonImageOnly: true,
                                                            dateFormat: \'dd/mm/yy\'
                                                        });
                                                    });
                                                </script>
                                            ';
                                        }
                                        break;

                                    case 'DataHora':
                                        $valor = trata_data($row[$Coluna['campo']]);

                                        if ($valor == '')
                                            $valor = $Coluna['vl_padrao'];

                                        if ($Coluna['js'] == '')
                                            $js = 'onblur="return Valida_DataHora(this)" onkeyup="return Formata_DataHora(this,event)"';
                                        else
                                            $js = $Coluna['js'];

                                        echo '<input id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" type="text" class="Texto" value="' . $valor . '" size="16" maxlength="16" ' . $js . '>';

                                        if ($Coluna['datepicker'] != '' && !$desabilita_html) {
                                            $vetpicker = $Coluna['vetpicker'];
                                            $direcao = $vetpicker['direcao'];
                                            $qtd = $vetpicker['qtd'];

                                            if ($qtd == '') {
                                                $qtd = 1;
                                            }

                                            echo '
                                                <script type="text/javascript">
                                                    $(function() {
                                                        $("#' . $Coluna['campo'] . '").datepicker({
                                                            showOn: \'button\',
                                                            changeMonth: true,
                                                            changeYear: true,
                                                            numberOfMonths: ' . $qtd . ',
                                                            buttonText: \'Selecionar a data\',
                                                            buttonImage: \'imagens/calendar.gif\',
                                                            buttonImageOnly: true,
                                                            dateFormat: \'dd/mm/yy\',
                                                            onSelect: function(datetext){
                                                                var d = new Date(); // for now
                                                                var h = d.getHours();
                                                                var m = d.getMinutes();
                                                                var s = d.getSeconds();
                                                                
                                                                h = (h < 10) ? ("0" + h) : h ;
                                                                m = (m < 10) ? ("0" + m) : m ;
                                                                s = (s < 10) ? ("0" + s) : s ;
                                                                
                                                                datetext = datetext + " " + h + ":" + m; // + ":" + s
                                                                
                                                                $("#' . $Coluna['campo'] . '").val(datetext);
                                                            }
                                                        });
                                                    });
                                                </script>
                                            ';
                                        }
                                        break;

                                    case 'Hidden':
                                        $valor = formata_valor($row[$Coluna['campo']], tipo($Coluna['campo'], $Coluna['tabela']));

                                        if ($valor == '' || $Coluna['mudar_vl_padrao'] === true) {
                                            $valor = $Coluna['vl_padrao'];
                                        }

                                        if ($Coluna['desc'] === true) {
                                            $Coluna['desc'] = $valor;
                                        }

                                        echo '<input type="hidden" id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" value="' . trata_html($valor, ENT_QUOTES, 'ISO-8859-1') . '">';

                                        if ($Coluna['nome'] == '')
                                            echo '<img src="imagens/trans.gif" width="0" height="0" border="0">';
                                        else
                                            echo '<div id="' . $idInput . '_fix" class="TextoFixo campo_disabled">' . $Coluna['desc'] . ' </div>';
                                        break;

                                    case 'cmbVetor':
                                        if ($row[$Coluna['campo']] == '') {
                                            $valor = $Coluna['vl_padrao'];
                                        } else {
                                            $valor = $row[$Coluna['campo']];
                                        }

                                        $Coluna['js'] .= ' data-tipo="' . $Coluna['tipo'] . '"';

                                        criar_combo_vet($Coluna['vetor'], $Coluna['campo'], $valor, $Coluna['linhafixa'], $Coluna['js'], $Coluna['style']);
                                        break;

                                    case 'Radio':
                                        $valor_banco = $row[$Coluna['campo']];

                                        if ($valor_banco == '') {
                                            $valor_banco = $Coluna['vl_padrao'];
                                        }

                                        $js = $Coluna['js'];

                                        foreach ($Coluna['vetor'] as $valor => $descricao) {
                                            if ($valor_banco == '') {
                                                $valor_banco = $valor;
                                            }

                                            if ($valor_banco == $valor) {
                                                $checked = 'checked';
                                            } else {
                                                $checked = '';
                                            }

                                            if ($Coluna['fixo'] == 'S') {
                                                $disabled = 'disabled="true"';
                                            } else {
                                                $disabled = '';
                                            }

                                            echo '<input type="radio" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" id="' . $idInput . '_' . $valor . '" ' . $disabled . ' value="' . trata_html($valor, ENT_QUOTES, 'ISO-8859-1') . '" ' . $checked . ' ' . $js . ' />';
                                            echo '<label for="' . $idInput . '_' . $valor . '">' . $descricao . '</label>';
                                            echo $Coluna['separacao'];
                                        }
                                        break;

                                    case 'FixoVetor':
                                        $valor = $row[$Coluna['campo']];

                                        if ($valor == '') {
                                            $valor = $Coluna['vl_padrao'];
                                        }

                                        if ($valor != '') {
                                            echo '<input id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" type="hidden" value="' . trata_html($valor) . '">';
                                            echo '<div id="' . $idInput . '_tf' . '" class="TextoFixo campo_disabled">' . $Coluna['vetor'][$valor] . '</div>';
                                        } else if ($_GET[$Coluna['campo'] . $Coluna['num_id']] != '') {
                                            echo '<input id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" type="hidden" value="' . trata_html($_GET[$Coluna['campo'] . $Coluna['num_id']]) . '">';
                                            echo '<div id="' . $idInput . '_tf' . '" class="TextoFixo campo_disabled">' . $Coluna['vetor'][$_GET[$Coluna['campo'] . $Coluna['num_id']]] . '</div>';
                                        } else {
                                            echo '<input id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" type="hidden">';
                                            echo '<div id="' . $idInput . '_tf' . '" class="TextoFixo campo_disabled">' . $Coluna['linhafixa'] . ' </div>';
                                        }
                                        break;

                                    case 'cmbBanco':
                                        if ($row[$Coluna['campo']] == '') {
                                            $valor = $Coluna['vl_padrao'];
                                        } else {
                                            $valor = $row[$Coluna['campo']];
                                        }

                                        $strData = '';
                                        $strData .= ' data-tipo="' . $Coluna['tipo'] . '"';

                                        $input_data = $Coluna['vetParametros']['input_data'];

                                        if (is_array($input_data)) {
                                            foreach ($input_data as $key => $value) {
                                                $strData .= ' data-' . $key . '="' . trata_html($value) . '"';
                                            }
                                        }

                                        $Coluna['js'] .= $strData;

                                        if ($Coluna['optgroup'] === false) {
                                            criar_combo_rs(execsql($Coluna['sql']), $Coluna['campo'], $valor, $Coluna['linhafixa'], $Coluna['js'], $Coluna['style'], '', false, '', $Coluna['msg_sem_registro']);
                                        } else {
                                            grupo_combo_rs(execsql($Coluna['sql']), $Coluna['campo'], $valor, $Coluna['linhafixa'], $Coluna['js'], $Coluna['style'], '', false, '', $Coluna['msg_sem_registro']);
                                        }
                                        break;

                                    case 'FixoBanco':
                                        $id_fb = explode('.', $Coluna['id']);
                                        if (count($id_fb) > 1) {
                                            $id_fb = $id_fb[1];
                                        } else {
                                            $id_fb = $id_fb[0];
                                        }

                                        if ($Coluna['num_id'] !== '') {
                                            if (is_int($Coluna['num_id'])) {
                                                $id_fb = $id_fb . $Coluna['num_id'];
                                            } else {
                                                $id_fb = $Coluna['num_id'];
                                            }
                                        }

                                        if ($_GET[$id_fb] == '') {
                                            $valor = $row[$Coluna['campo']];
                                        } else {
                                            $valor = $_GET[$id_fb];
                                        }

                                        if ($valor > 0) {
                                            $sql = 'select ' . $Coluna['id'] . ', ' . $Coluna['desc'] . ' from ' . $Coluna['tabela_obj'] . ' where ' . $Coluna['id'] . ' = ' . aspa($valor);

                                            $rs_fixo = execsql($sql);
                                            $row_fixo = $rs_fixo->data[0];

                                            echo '<input id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" type="hidden" value="' . trata_html($valor, ENT_QUOTES, 'ISO-8859-1') . '">';
                                            echo '<div id="' . $idInput . '_tf' . '" class="TextoFixo campo_disabled">';

                                            for ($x = 1; $x < $rs_fixo->cols; $x++) {
                                                if ($rs_fixo->info['type'][$x] == 'date' || $rs_fixo->info['type'][$x] == 'datetime')
                                                    echo trata_data($row_fixo[$x]);
                                                else
                                                    echo $row_fixo[$x];

                                                if ($x < $rs_fixo->cols - 1)
                                                    echo ' :: ';
                                            }

                                            echo '</div>';
                                        } else {
                                            echo '<input id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" type="hidden">';
                                            echo '<div id="' . $idInput . '_tf' . '" class="TextoFixo campo_disabled">' . $Coluna['linhafixa'] . ' </div>';
                                        }
                                        break;

                                    case 'TextArea':
                                        $valor = $row[$Coluna['campo']];

                                        if ($valor == '') {
                                            $valor = $Coluna['vl_padrao'];
                                        }

                                        echo '<textarea id="' . $idInput . '" ' . $Coluna['js'] . ' data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" class="TextArea" style="' . $Coluna['style'] . '" onkeypress = "return Limita_Tamanho(this, ' . $Coluna['maxlength'] . ')" onblur = "Trunca_Campo(this, ' . $Coluna['maxlength'] . ')">' . $valor . '</textarea>';
                                        break;

                                    case 'TextoFixo':
                                        switch (tipo($Coluna['campo'], $Coluna['tabela'])) {
                                            case 'numeric':
                                            case 'decimal':
                                            case 'newdecimal':
                                            case 'double':
                                                $valor = format_decimal($row[$Coluna['campo']]);
                                                break;

                                            case 'date':
                                            case 'datetime':
                                            case 'timestamp':
                                                $valor = trata_data($row[$Coluna['campo']]);
                                                break;

                                            default:
                                                $valor = trata_html($row[$Coluna['campo']], ENT_QUOTES, 'ISO-8859-1');
                                                break;
                                        }

                                        if ($valor == '') {
                                            $valor = $Coluna['vl_padrao'];
                                        }

                                        echo '<input type="hidden" id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" value="' . $valor . '">';

                                        if ($Coluna['size'] == '')
                                            $style = '';
                                        else
                                            $style = 'width: ' . ($Coluna['size'] * $TamFonte) . 'px;';

                                        echo '<div id="' . $idInput . '_fix" class="TextoFixo campo_disabled"  style="' . $style . '">' . $valor . '&nbsp;</div>';
                                        break;

                                    case 'TextoFixoVL':
                                        switch (tipo($Coluna['campo'], $Coluna['tabela'])) {
                                            case 'numeric':
                                            case 'decimal':
                                            case 'newdecimal':
                                            case 'double':
                                                $valor = format_decimal($row[$Coluna['campo']]);
                                                break;

                                            case 'date':
                                            case 'datetime':
                                            case 'timestamp':
                                                $valor = trata_data($row[$Coluna['campo']]);
                                                break;

                                            default:
                                                $valor = $row[$Coluna['campo']];
                                                break;
                                        }

                                        if ($valor == '') {
                                            $valor = $Coluna['valor'];
                                        }

                                        if ($Coluna['color'] != '') {
                                            echo '<input type="hidden" id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" value="' . trata_html($valor, ENT_QUOTES, 'ISO-8859-1') . '" cor_gsd="' . $Coluna['color'] . '">';
                                        } else {
                                            echo '<input type="hidden" id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" value="' . trata_html($valor, ENT_QUOTES, 'ISO-8859-1') . '" >';
                                        }

                                        if ($Coluna['nome'] != '') {
                                            if ($Coluna['size'] == '')
                                                $style = '';
                                            else
                                                $style = 'width: ' . ($Coluna['size'] * $TamFonte) . 'px;';

                                            if ($Coluna['color'] != '') {
                                                echo '<div id="' . $idInput . '_fix" class="TextoFixo_gsd campo_disabled" style="' . $style . '">' . $valor . '&nbsp;</div>';
                                            } else {
                                                echo '<div id="' . $idInput . '_fix" class="TextoFixo campo_disabled" style="' . $style . '">' . $valor . '&nbsp;</div>';
                                            }
                                        }
                                        break;

                                    case 'AutoNum':
                                        $valor = trata_html($row[$Coluna['campo']]);

                                        echo '<input type="hidden" id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" value="' . $valor . '">';

                                        if ($Coluna['mostra']) {
                                            if ($Coluna['size'] == '')
                                                $style = '';
                                            else
                                                $style = 'width: ' . ($Coluna['size'] * $TamFonte) . 'px;';

                                            if ($valor == '') {
                                                $valor = $Coluna['prefixo'] . str_repeat('X', $Coluna['zeroesq']);
                                            }

                                            echo '<div id="' . $idInput . '_fix" class="TextoFixo campo_disabled" style="' . $style . '">' . $valor . '</div>';
                                        }
                                        break;

                                    case 'Checkbox':
                                        $chk = '';

                                        if ($row[$Coluna['campo']] == '') {
                                            $valor = $Coluna['valor_registro'];
                                        } else {
                                            $valor = $row[$Coluna['campo']];
                                        }

                                        if ($valor == $Coluna['valor_marcado']) {
                                            $chk = 'checked';
                                        }

                                        echo '<input ' . $chk . ' type="checkbox" id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" value="' . $Coluna['valor_marcado'] . '" ' . $Coluna['complemento_tag'] . ' ><label for="' . $idInput . '" class="Tit_Campo_Obr">&nbsp;' . $Coluna['descricao'] . '</label>';
                                        break;

                                    case 'Html':
                                        $valor = $row[$Coluna['campo']];

                                        if ($valor == '') {
                                            $valor = $Coluna['vl_padrao'];
                                        }

                                        if ($Coluna['largura'] == '') {
                                            $HtmlWidth = '680px';
                                        } else {
                                            $HtmlWidth = $Coluna['largura'];

                                            if (is_numeric($HtmlWidth)) {
                                                $HtmlWidth .= 'px';
                                            }
                                        }

                                        echo '<div class="conteudo_max" style="width: ' . $HtmlWidth . '">';

                                        $desabilita = $desabilita_html;

                                        if ($Coluna['campo_fixo'] === true) {
                                            $desabilita = true;
                                        }

                                        if (mb_strtoupper($Coluna['campo_fixo']) === 'ABERTO') {
                                            $desabilita = false;
                                        }

                                        if ($desabilita) {
                                            $HtmlValue = trata_html($valor);

                                            echo "<input type=\"hidden\" id=\"{$Coluna['campo']}\" name=\"{$Coluna['campo']}\" value=\"{$HtmlValue}\" style=\"display:none\" />";
                                            echo "<iframe id=\"{$Coluna['campo']}___Frame\" src=\"fck_disable.php?id={$Coluna['campo']}\" width=\"{$HtmlWidth}\" height=\"{$Coluna['altura']}\" frameborder=\"0\" scrolling=\"auto\"></iframe>";
                                        } else {
                                            Require_Once("fckeditor/fckeditor.php");
                                            $oFCKeditor = new FCKeditor($Coluna['campo']);
                                            $oFCKeditor->Value = $valor;
                                            $oFCKeditor->Height = $Coluna['altura'];

                                            if ($Coluna['largura'] != '') {
                                                $oFCKeditor->Width = $Coluna['largura'];
                                            }

                                            if (!is_bool($Coluna['barra_simples'])) {
                                                $oFCKeditor->ToolbarSet = $Coluna['barra_simples'];
                                            } else if ($Coluna['barra_simples']) {
                                                $oFCKeditor->ToolbarSet = 'Simples';
                                            } else {
                                                $oFCKeditor->ToolbarSet = 'Padrao';
                                            }

                                            $oFCKeditor->Config['ToolbarStartExpanded'] = $Coluna['barra_aberto'];

                                            $oFCKeditor->Create();

                                            echo "
                                                <script type='text/javascript'>
                                                    objHtml[objHtml.length] = '" . $Coluna['campo'] . "';
                                                </script>
                                            ";
                                        }
                                        echo '</div>';
                                        break;

                                    case 'File':
                                        echo '<input id="' . $idInput . '"' . $Coluna['js'] . ' data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" type="file" class="Texto" size="' . $Coluna['size'] . '" onkeydown = "return !(event.keyCode == 13)" />';
                                        echo '<br>';
                                        echo '<input type="hidden" name="' . $Coluna['campo'] . '_ant"' . $Coluna['js'] . ' value="' . $row[$Coluna['campo']] . '">';

                                        if (isset($row[$Coluna['campo']])) {
                                            $path = $pathObjFile . '/' . $tabela . '/';
											$pathURL = $dir_file . '/' . $tabela . '/';

                                            $vetImagemProdPrefixo = explode('_', $row[$Coluna['campo']]);

                                            $qtd_ = explode('_', $Coluna['campo']);
                                            $qtd_ = count($qtd_) - 1 + 3;

                                            $ImagemProdPrefixo = '';

                                            for ($index = 0; $index < $qtd_; $index++) {
                                                $ImagemProdPrefixo .= $vetImagemProdPrefixo[$index] . '_';
                                            }

                                            if (file_exists($path . $row[$Coluna['campo']]) && $row[$Coluna['campo']] != '') {
                                                ImagemProd(100, null, $pathURL, $row[$Coluna['campo']], $ImagemProdPrefixo, true);
                                                $mostra_descricao = true;
                                            } else {
                                                echo 'Arquivo não foi encontrado. Pode ter sido removido ou esta indisponível para acesso.';
                                                $mostra_descricao = false;
                                            }

                                            if (!$Coluna['remove']) {
                                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                echo "<input type='checkbox' style='vertical-align: middle;' id='remover_" . $Coluna['campo'] . "' name='remover_" . $Coluna['campo'] . "' value='S'>";
                                                echo '<label for="remover_' . $Coluna['campo'] . '" class="Tit_Campo">Remover </label>';
                                                echo "<br>";
                                            }

                                            if ($Coluna['descricao'] != '' && $mostra_descricao) {
                                                echo '<div class="file_descricao ' . $Coluna['class_descricao'] . '">';
                                                echo '<a href="' . $pathURL . $row[$Coluna['campo']] . '" target="_blank" class="FileLink">';
                                                echo $Coluna['descricao'];
                                                echo '</a>';
                                                echo '</div>';
                                            }
                                        }

                                        echo "
                                        <script type='text/javascript'>
                                            objFile[objFile.length] = '" . $Coluna['campo'] . "';
                                            objFileMime[objFileMime.length] = vetMime." . $Coluna['grupo'] . ";
                                            objFileNome[objFileNome.length] = '" . $Coluna['nome'] . "';
                                        </script>";
                                        break;

                                    case 'FileFixo':
                                        $valor = $row[$Coluna['campo']];

                                        echo '<input type="hidden" id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" value="' . $valor . '">';

                                        if (isset($row[$Coluna['campo']])) {
                                            $path = $pathObjFile . '/' . $tabela . '/';
											$pathURL = $dir_file . '/' . $tabela . '/';

                                            if (file_exists($path . $row[$Coluna['campo']]) && $row[$Coluna['campo']] != '') {
                                                $vetImagemProdPrefixo = explode('_', $row[$Coluna['campo']]);

                                                $qtd_ = explode('_', $Coluna['campo']);
                                                $qtd_ = count($qtd_) - 1 + 3;

                                                $ImagemProdPrefixo = '';

                                                for ($index = 0; $index < $qtd_; $index++) {
                                                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[$index] . '_';
                                                }

                                                ImagemProd(100, null, $pathURL, $row[$Coluna['campo']], $ImagemProdPrefixo, true);
                                            } else {
                                                echo 'Arquivo não foi encontrado. Pode ter sido removido ou esta indisponível para acesso.';
                                            }
                                        }
                                        break;

                                    case 'ListarCmb':
                                        echo '<input type="hidden" id="' . $idInput . '" data-tipo="' . $Coluna['tipo'] . '" name="' . $Coluna['campo'] . '" value="' . trata_html($row[$Coluna['campo']], ENT_QUOTES, 'ISO-8859-1') . '">';
                                        echo '<div id="' . $idInput . '_txt" class="TextoFixo ListarCmb campo_disabled" style="width: ' . $Coluna['width'] . '">';

                                        switch (tipo($Coluna['campo'], $Coluna['tabela'])) {
                                            case 'int':
                                            case 'int4':
                                            case 'long':
                                                $sql_where = null($row[$Coluna['campo']]);
                                                break;

                                            case 'numeric':
                                            case 'decimal':
                                            case 'newdecimal':
                                            case 'double':
                                                $sql_where = null($row[$Coluna['campo']]);
                                                break;

                                            case 'date':
                                            case 'datetime':
                                            case 'timestamp':
                                                $sql_where = aspa($row[$Coluna['campo']]);
                                                break;

                                            default:
                                                $sql_where = aspa($row[$Coluna['campo']]);
                                                break;
                                        }

                                        $vetFRO = includeListarCmb('listar_cmb/' . $Coluna['arq_cmb'] . '.php', $sql_where);

                                        $sql = '';
                                        $sql .= ' select t.' . $campoDescListarCmb;
                                        $sql .= ' from (' . $vetFRO['sql'] . ') t';
                                        $sql .= ' where t.' . $vetFRO['idCampo'] . ' = ' . $sql_where;
                                        $rs = execsql($sql);
                                        $desc = $rs->data[0][0];

                                        switch ($rs->info['type'][$campoDescListarCmb]) {
                                            case 'numeric':
                                            case 'decimal':
                                            case 'newdecimal':
                                            case 'double':
                                                echo format_decimal($desc);
                                                break;

                                            case 'date':
                                            case 'datetime':
                                            case 'timestamp':
                                                echo trata_data($desc);
                                                break;

                                            default:
                                                echo $desc;
                                                break;
                                        }

                                        echo '&nbsp;</div>';

                                        if ($Coluna['mostra_bt']) {
                                            echo '<img id="' . $idInput . '_bt_pesquisa" class="bt_acao" src="imagens/bt_pesquisa.png" title="Buscar Registro" onclick="ListarCmbClick(\'' . $Coluna['campo'] . '\', \'' . $Coluna['arq_cmb'] . '\', \'' . $Coluna['titulo_tela'] . '\');" />';
                                            echo '<img id="' . $idInput . '_bt_limpar" class="bt_acao" src="imagens/bt_limpar.png" title="Limpar" onclick="ListarCmbLimpa(\'' . $Coluna['campo'] . '\');" />';
                                        }
                                        break;

                                    case 'ListarCmbMulti':
                                        $vetParametros = $Coluna['vetParametros'];

                                        echo '<input type="hidden" name="' . $Coluna['campo'] . '" data-tipo="' . $Coluna['tipo'] . '" value="' . $Coluna['session_cod'] . '">';

                                        echo '<ul class="ListarCmbMulti" data-campo="' . $Coluna['campo'] . '" data-session_cod="' . $Coluna['session_cod'] . '">';

                                        $vetSel = Array();

                                        if ($Coluna['tabela_relacionamento'] != '') {
                                            $diretorio = 'listar_cmbmulti';
                                            $path = $diretorio . '/' . $Coluna['arq_cmb'] . '.php';

                                            if (!file_exists($path)) {
                                                $diretorio = 'listar_cmb';
                                            }

                                            $path = $diretorio . '/' . $Coluna['arq_cmb'] . '.php';

                                            if (!file_exists($path)) {
                                                $diretorio = 'listar_conf';
                                            }


                                            $vetFRO = includeListarCmb($diretorio . '/' . $Coluna['arq_cmb'] . '.php');

                                            $sql = '';
                                            $sql .= ' select t.*';
                                            $sql .= ' from (' . $vetFRO['sql'] . ') t';
                                            $sql .= ' inner join (';
                                            $sql .= ' select *';
                                            $sql .= ' from ' . $Coluna['tabela_relacionamento'];
                                            $sql .= ' where ' . $Coluna['idt_relacionamento'] . ' = ' . null($vetID[$Coluna['tabela']]);
                                            $sql .= $vetParametros['where'];
                                            $sql .= ' ) x on 1 = 1';

                                            foreach ($Coluna['vet_retorno'] as $vr) {
                                                if ($vr['campo_pk'] === true) {
                                                    $sql .= ' and x.' . $vr['sql_campo'] . ' = t.' . $vr['campo'];
                                                }
                                            }

                                            $rs_sel = execsql($sql);

                                            foreach ($rs_sel->data as $row_sel) {
                                                $vetTmp = Array();

                                                foreach ($Coluna['vet_retorno'] as $vetTmpCampo) {
                                                    switch ($rs_sel->info['type'][$vetTmpCampo['campo']]) {
                                                        case 'date':
                                                        case 'datetime':
                                                        case 'timestamp':
                                                            $vl = trata_data($row_sel[$vetTmpCampo['campo']]);
                                                            break;

                                                        case 'numeric':
                                                        case 'decimal':
                                                        case 'newdecimal':
                                                        case 'double':
                                                            $vl = format_decimal($row_sel[$vetTmpCampo['campo']]);
                                                            break;

                                                        default:
                                                            $vl = $row_sel[$vetTmpCampo['campo']];
                                                            break;
                                                    }

                                                    $vetTmp[$vetTmpCampo['campo']] = $vl;
                                                }

                                                $cod = md5(implode(', ', $vetTmp));
                                                $vetSel[$cod] = $vetTmp;

                                                foreach ($Coluna['vet_retorno'] as $vetTmpCampo) {
                                                    if (!$vetTmpCampo['mostra']) {
                                                        unset($vetTmp[$vetTmpCampo['campo']]);
                                                    }
                                                }

                                                echo '<li data-id="' . $cod . '" data-idt="' . $row_sel[$Coluna['idt_tabela_relacionamento']] . '"><img class="bt_acao" src="imagens/excluir_16.png" title="Remover da Seleção" />' . implode(' - ', $vetTmp) . '</li>';
                                            }
                                        }

                                        $_SESSION[CS]['objListarCmbMulti'][$Coluna['session_cod']]['sel_final'] = $vetSel;

                                        echo '</ul>';

                                        if (count($vetSel) > 0) {
                                            $tot = count($vetSel);
                                        } else {
                                            $tot = '';
                                        }

                                        echo '<input type="hidden" id="' . $idInput . '_tot" value="' . $tot . '">';
                                        break;

                                    default:
                                        echo '<img src="imagens/trans.gif" width="0" height="0" border="0">';
                                        break;
                                }

                                echo "</td>\n";
                            }
                        } else {
                            if ($Coluna == '') {
                                $ColunaID = '';
                            } else {
                                $ColunaID = ' id="' . $Coluna . '_obj"';
                            }

                            echo '<td' . $ColunaID . '><img src="imagens/trans.gif" width="' . $vetFrmParametro['espaco_img_size'] . '" height="0" border="0"></td>' . "\n";
                        }
                    }

                    echo "</tr>\n";
                }

                echo '</table>';
            }

            echo '</fieldset>' . nl();
        }

        echo '</div>' . nl();

        if ($tabHtml != '' && $idxGrd == $posTabFim) {
            echo '</div>' . nl();
        }
    }

    bt_codigo(False);

    $path = 'cadastro_conf/' . $menu . '_dep.php';
    if (file_exists($path)) {
        Require_Once($path);
    }

    if ($vlID > 0 && $_SESSION[CS]['g_mostra_pk'] == 'S') {
        ?>
        <div id="mostra_pk">
            <a href="conteudo.php?prefixo=inc&menu=plu_log_sis&origem_tela=menu&des_pk=<?php echo $vlID; ?>" target="_blank">
                LOG PK: <?php echo $vlID; ?>
            </a>
            <br />
            <a href="conteudo.php?prefixo=inc&menu=plu_funcao_seg&ondeestou=<?php echo $menu; ?>&origem_tela=menu&des_pk=<?php echo $vlID; ?>">
                FUNÇÃO: <?php echo $vlID; ?>
            </a>
        </div>


        <?php
    }
    ?>
</form>
<script type="text/javascript">
    $(document).ready(function () {
<?php
if ($barra_bt_top) {
    ?>
            if (($('div#geral' + popup).height() - $('div#rodape' + popup).height()) > $(window).height()) {
                $('div#barra_bt_top').show();
            }
    <?php
}

if ($barra_bt_top_fixo) {
    ?>
            $('div#barra_bt_top').show();
    <?php
}

ForEach ($vetDesativa as $idx => $vetDesCampo) {
    ForEach ($vetDesCampo as $i => $vet) {
        $dValor = $vet['igual_valor'] ? 'S' : 'N';
        $aValor = $vetAtivadoObr[$idx][$i]['igual_valor'] ? 'S' : 'N';

        echo '
            $("#' . $idx . '").change(function() {
                var campo = $("' . $vet['campo'] . '");
                var obr = $("' . $vetAtivadoObr[$idx][$i]['obr'] . '");
                var vlTmp = $(this).val();
    
                switch ($(this).data("tipo")) {
                    case "Radio":
                        if (!$(this).prop("checked")) {
                            vlTmp = "";
                        }
                        break;
                }

                if (vlTmp == null) {
                    vlTmp = "";
                }

                func_AtivaDesativa(vlTmp.toLowerCase(), "' . $vet['valor'] . '".split(","), campo, obr, "' . $vetAtivadoObr[$idx][$i]['valor'] . '".split(","), "' . $dValor . '", "' . $aValor . '", "' . $vet['vlPadraoDesativa'] . '");

                if (typeof (func_AtivaDesativa_' . $idx . ') === "function") {
                    func_AtivaDesativa_' . $idx . '("' . $i . '");
                }
            });
        ';

        if ($vet['onLoadChange']) {
            echo '
                $("#' . $idx . '").change();
            ';
        }
    }
}

if ($acao == 'con' || $acao == 'exc' || $acao_alt_con == 'S') {
    echo '$("input:not([name=\'btnAcao\']), select, textarea").prop("disabled", true);' . nl();
    echo '$("img.bt_acao").hide();' . nl();
}
?>

        $(':disabled').addClass('campo_disabled');

        $('img.bt_controle_fecha').click(function () {
            var img = $(this);

            if (!img.is('disabled')) {
                var filho = 'fieldset.' + this.id;

                if (img.attr('src') == 'imagens/seta_baixo.png') {
                    img.attr('src', 'imagens/seta_cima.png');
                    $(filho).hide();
                } else {
                    img.attr('src', 'imagens/seta_baixo.png');
                    $(filho).show();
                }

                var BCFestado = window['bt_controle_fecha_estado'];

                if ($.isFunction(BCFestado)) {
                    BCFestado();
                }

                TelaHeight();
            }

            return false;
        });

        $('img.situacao_padrao').click(function () {
            $('img.bt_controle_fecha').each(function () {
                var img = $(this);

                if (!img.is('disabled')) {
                    var filho = 'fieldset.' + this.id;
                    var ini = img.data('inicio');

                    if (ini == 'F' && img.attr('src') == 'imagens/seta_baixo.png') {
                        img.attr('src', 'imagens/seta_cima.png');
                        $(filho).hide();
                    }

                    if (ini == 'A' && img.attr('src') == 'imagens/seta_cima.png') {
                        img.attr('src', 'imagens/seta_baixo.png');
                        $(filho).show();
                    }
                }
            });

            var BCFestado = window['bt_controle_fecha_estado'];

            if ($.isFunction(BCFestado)) {
                BCFestado();
            }

            TelaHeight();
            return false;
        });

        $('img.situacao_padrao_abre').click(function () {
            $('img.bt_controle_fecha').each(function () {
                var img = $(this);

                if (!img.is('disabled')) {
                    var filho = 'fieldset.' + this.id;

                    if (img.attr('src') == 'imagens/seta_cima.png') {
                        img.attr('src', 'imagens/seta_baixo.png');
                        $(filho).show();
                    }
                }
            });

            var BCFestado = window['bt_controle_fecha_estado'];

            if ($.isFunction(BCFestado)) {
                BCFestado();
            }

            TelaHeight();
            return false;
        });

        $('img.situacao_padrao_fecha').click(function () {
            $('img.bt_controle_fecha').each(function () {
                var img = $(this);

                if (!img.is('disabled')) {
                    var filho = 'fieldset.' + this.id;

                    if (img.attr('src') == 'imagens/seta_baixo.png') {
                        img.attr('src', 'imagens/seta_cima.png');
                        $(filho).hide();
                    }
                }
            });

            var BCFestado = window['bt_controle_fecha_estado'];

            if ($.isFunction(BCFestado)) {
                BCFestado();
            }

            TelaHeight();
            return false;
        });

        $("img.bt_controle_fecha[data-inicio='F']").click();

        $('.ListarCmbMulti').on('click', 'li > img', function () {
            var li = $(this).parent();
            var ul = li.parent();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_plu + '&tipo=ListarCmbMultiRemove',
                data: {
                    cas: conteudo_abrir_sistema,
                    cod: li.data('id'),
                    session_cod: ul.data('session_cod')
                },
                success: function (response) {
                    if (response.erro == '') {
                        li.remove();
                        $('#' + ul.data('campo') + '_tot').val(response.tot);
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
    });
</script>
<?php

function bt_codigo($top) {
    global $menu_acesso, $bt_exportar, $bt_exportar_desc, $bt_exportar_tit, $acao, $botao_volta, $pagina, $par_url, $proxima_tela, $prefixo_volta, $mostra_bt_volta,
    $bt_salvar_lbl, $bt_alterar_lbl, $bt_excluir_lbl, $bt_voltar_lbl, $bt_personalizado, $bt_alterar_aviso, $cont_arq, $bt_submit_mostra, $bt_barra_html_dep;

    if ($top) {
        $id_bt = "";
        $div = 'margin-bottom: 5px; display: none;';
        $id_div = 'top';
    } else {
        $id_bt = "id='bt_voltar'";
        $div = '';
        $id_div = 'bottom';
    }

    echo '<div id="barra_bt_' . $id_div . '" class="Barra" style="' . $div . '">' . nl();
    echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  >' . nl();
    echo '<tr><td nowrap>' . nl();

    if (acesso($menu_acesso, aspa($acao), false, false) && $bt_submit_mostra) {
        switch ($acao) {
            case 'inc':
                if ($proxima_tela) {
                    $lbl = 'Continua';
                } else {
                    $lbl = $bt_salvar_lbl;
                }

                echo '
                    <input type="submit" name="btnAcao" class="Botao" value="' . $lbl . '" onClick="valida = \'S\'">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        		';
                break;

            case 'alt':
                echo '
                    <input type="submit" name="btnAcao" class="Botao" value="' . $bt_alterar_lbl . '" onClick="valida = \'S\'">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                ';
                break;

            case 'exc':
                echo '
                    <input type="submit" name="btnAcao" class="Botao" value="' . $bt_excluir_lbl . '" onClick="valida = \'N\'">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                ';
                break;

            case 'per':
                echo '
                    <input type="submit" name="btnAcao" class="Botao" value="' . $bt_personalizado . '" onClick="valida = \'S\'">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                ';
                break;
        }
    }

    if ($top === false) {
        echo '<input type="hidden" id="bt_volta_href" value="' . $pagina . '?prefixo=' . $prefixo_volta . getParametro($par_url) . '#lin' . $_GET['id'] . '">';
    }

    if ($mostra_bt_volta) {
        if ($botao_volta == '' && $cont_arq == '_cadastro') {
            $botao_volta = 'parent.hidePopWin(false);';
        }

        if ($botao_volta == '') {
            echo "<input type='Button' name='btnAcao' $id_bt class='Botao' value='" . $bt_voltar_lbl . "' onClick=\"self.location = '" . $pagina . "?prefixo={$prefixo_volta}" . getParametro($par_url) . "#lin{$_GET['id']}'\">";
        } else {
            echo "<input type='Button' name='btnAcao' $id_bt class='Botao' value='" . $bt_voltar_lbl . "' onClick=\"$botao_volta\">";
        }
    }

    if ($bt_exportar) {
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo "<input type='Button' name='btnAcao' class='Botao' id='bt_exportar' value='{$bt_exportar_desc}' onClick=\"listar_rel_pdf('{$bt_exportar_tit}')\">";
    }

    if ($bt_barra_html_dep != '') {
        echo $bt_barra_html_dep;
    }
    
    echo '</td>';

    if ($acao == 'alt') {
        echo '<td align="center" style="color: red">' . nl();
        if ($bt_alterar_aviso !== false) {
            echo $bt_alterar_aviso;
        }
        echo '</td>' . nl();
    }

    echo '<td align="right" nowrap>' . nl();
    echo '( * ) campo obrigatório';
    echo '</td></tr>' . nl();
    echo '</table>' . nl();

    echo '</div>';
}

function codigo_lista() {
    global $Coluna, $id, $tabela, $vetMesclarCadastro, $vetID;

    if ($Coluna['idt_cadastro'] == '') {
        if ($Coluna['tabela'] == $tabela) {
            $tid = $id;
        } else {
            $tid = $vetMesclarCadastro[$Coluna['tabela']]['id'];
        }
    } else {
        $tid = $Coluna['idt_cadastro'];
    }
    ?>
    <script type="text/javascript">
        objLista[objLista.length] = new Array('<?php echo $Coluna['campo'] ?>', '<?php echo $Coluna['nm_lst_2'] ?>');
    </script>
    <input type="hidden" name="<?php echo $Coluna['campo'] ?>" data-tipo="<?php echo $Coluna['tipo'] ?>"  id="<?php echo $Coluna['campo'] ?>">
    <table align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <font id="<?php echo $Coluna['campo'] ?>_lst_1" class="Tit_Campo"><?php echo $Coluna['des_lst_1'] ?></font><br>
                <?php
                $rs = execsql($Coluna['sql_lst_1']);
                $tam_lst = $Coluna['num_linhas'] == '' ? $rs->rows : $Coluna['num_linhas'];
                $tam_lst = $tam_lst < 6 ? 6 : $tam_lst;
                $tam_lst = $tam_lst > 15 ? 15 : $tam_lst;

                echo "<select id='" . $Coluna['campo'] . "_org' style='width: " . $Coluna['larg_lst_1'] . "px;' name='" . $Coluna['nm_lst_1'] . "' size='" . $tam_lst . "' multiple>\n";

                ForEach ($rs->data as $linha) {
                    $sql = 'select * from ' . $Coluna['tabela_relacionamento'] . '
                            where ' . $tid . ' = ' . null($vetID[$Coluna['tabela']]) . '
                            and ' . $rs->info['name'][0] . ' = ';

                    switch ($rs->info['type'][0]) {
                        case 'int':
                        case 'int4':
                        case 'long':
                            $sql .= null($linha[0]);
                            break;

                        case 'numeric':
                        case 'decimal':
                        case 'newdecimal':
                        case 'double':
                            $sql .= null(desformat_decimal($linha[0]));
                            break;

                        case 'date':
                        case 'datetime':
                        case 'timestamp':
                            $sql .= aspa(trata_data($linha[0]));
                            break;

                        default:
                            $sql .= aspa($linha[0]);
                            break;
                    }

                    $rs_lst = execsql($sql);

                    if ($rs_lst->rows == 0) {
                        echo "<option value='S" . $linha[0] . "'>";

                        for ($x = 1; $x < $rs->cols; $x++) {
                            echo $linha[$x];
                            if ($x < $rs->cols - 1)
                                echo ' - ';
                        }

                        echo"</option>\n";
                    }
                }

                echo '</select>';
                ?>
            </td>
            <td width="80" align="center">
                <input type="Button" name="btnAcao" class="Botao" value="&nbsp;&gt;&gt;&gt;&nbsp;" onClick="inclui(document.frm.<?php echo $Coluna['nm_lst_1'] ?>, document.frm.<?php echo $Coluna['nm_lst_2'] ?>, '<?php echo $Coluna['campo'] ?>')">
                <br>
                <br>
                <input type="Button" name="btnAcao" class="Botao" value="&nbsp;&lt;&lt;&lt;&nbsp;" onClick="exclui(document.frm.<?php echo $Coluna['nm_lst_1'] ?>, document.frm.<?php echo $Coluna['nm_lst_2'] ?>, '<?php echo $Coluna['campo'] ?>')">
            </td>
            <td align="center">
                <font id="<?php echo $Coluna['campo'] ?>_lst_2" class="Tit_Campo<?php echo ($Coluna['valida'] ? '_Obr' : '') ?>"><?php echo $Coluna['des_lst_2'] ?><span class="asterisco">*</span></font><br>
                <?php
                $rs = execsql(str_replace('$vlID', null($vetID[$Coluna['tabela']]), $Coluna['sql_lst_2']));

                echo "<select id='" . $Coluna['campo'] . "_lista' style='width: " . $Coluna['larg_lst_2'] . "px;' name='" . $Coluna['nm_lst_2'] . "' size='" . $tam_lst . "' multiple>\n";

                ForEach ($rs->data as $linha) {
                    if ($Coluna['exc_campo'] == '' || $Coluna['exc_tabela'] == '') {
                        $col = 1;
                        $exclui = 'S';
                    } else {
                        $col = 2;
                        $sql = 'select ' . $Coluna['exc_campo'] . ' from ' . $Coluna['exc_tabela'] . '
                                where ' . $Coluna['exc_campo'] . ' = ' . $linha[1];
                        $rs_temp = execsql($sql);

                        if ($rs_temp->rows == 0)
                            $exclui = 'S';
                        else
                            $exclui = 'N';
                    }

                    echo "<option value='" . $exclui . $linha[0] . "'>";

                    for ($x = $col; $x < $rs->cols; $x++) {
                        echo $linha[$x];
                        if ($x < $rs->cols - 1)
                            echo ' - ';
                    }

                    echo"</option>\n";
                }

                echo '</select>';
                ?>
            </td>
        </tr>
    </table>
    <?php
}

function cadastra_lista() {
    global $vetID, $id, $vetLista, $vetLstExtra, $vetTabExtra, $vetLstDel, $tabela, $vetMesclarCadastro;

    ForEach ($vetLista as $Lista) {
        if (!$vetMesclarCadastro[$Lista['tabela_pai']]['soConsulta']) {
            $S = Array();
            $N = '';

            $sql = "select * from " . $Lista['tabela'] . " where 1 = 0";
            $rs = execsql($sql);
            $type = $rs->info['type'];

            if ($Lista['idt_cadastro'] == '') {
                if ($Lista['tabela_pai'] == $tabela) {
                    $tid = $id;
                } else {
                    $tid = $vetMesclarCadastro[$Lista['tabela_pai']]['id'];
                }
            } else {
                $tid = $Lista['idt_cadastro'];
            }

            ForEach (explode(',', $_POST[$Lista['campo']]) as $chave) {
                switch (substr($chave, 0, 1)) {
                    case 'S':
                        $S[] .= substr($chave, 1);
                        break;
                    case 'N':
                        $N .= substr($chave, 1) . ',';
                        break;
                }
            }

            $N = substr($N, 0, strrpos($N, ','));

            //Delete
            $sql = 'delete from ' . $Lista['tabela'] . ' where ' . $tid . ' = ' . null($vetID[$Lista['tabela_pai']]);

            if (is_array($vetLstDel[$Lista['campo']])) {
                ForEach ($vetLstDel[$Lista['campo']] as $tipoLst => $rowLst) {
                    $sql_del = '';
                    switch ($tipoLst) {
                        case 'C':
                            $sql_del = "select * from " . $Lista['tabela_pai'] . " where $id = " . null($vetID[$Lista['tabela_pai']]);
                            break;
                        case 'V':
                            break;
                    }

                    if ($sql_del != '') {
                        $rs = execsql($sql_del);
                        $row = $rs->data[0];
                    }

                    ForEach ($rowLst as $campoLst) {
                        $sql .= ' and ' . $campoLst['destino'] . ' = ';

                        if ($tipoLst == 'V') {
                            $valor = $campoLst['origem'];
                        } else {
                            $valor = $row[$campoLst['origem']];
                        }

                        switch ($type['destino']) {
                            case 'int':
                            case 'int4':
                            case 'long':
                                $sql .= null($valor);
                                break;

                            case 'numeric':
                            case 'decimal':
                            case 'newdecimal':
                            case 'double':
                                $sql .= null(desformat_decimal($valor));
                                break;

                            case 'date':
                            case 'datetime':
                            case 'timestamp':
                                $sql .= aspa(trata_data($valor));
                                break;

                            default:
                                $sql .= aspa($valor);
                                break;
                        }
                    }
                }
            }

            if ($N != '')
                $sql .= ' and ' . $Lista['campo'] . ' not in (' . $N . ')';

            execsql($sql);

            ForEach ($S as $chave) {
                $sql_campo = '';
                $sql_valor = '';

                if (is_array($vetLstExtra[$Lista['campo']])) {
                    ForEach ($vetLstExtra[$Lista['campo']] as $tipoLst => $rowLst) {
                        $sql = '';
                        switch ($tipoLst) {
                            case 'C':
                                $sql = "select * from " . $Lista['tabela_pai'] . " where $id = " . null($vetID[$Lista['tabela_pai']]);
                                break;
                            case 'L':
                                $sql = "select * from " . $vetTabExtra[$Lista['campo']][0] . " where " . $vetTabExtra[$Lista['campo']][1] . " = $chave";
                                break;
                            case 'V':
                                break;
                        }

                        if ($sql != '') {
                            $rs = execsql($sql);
                            $row = $rs->data[0];
                        }

                        ForEach ($rowLst as $campoLst) {
                            $sql_campo .= $campoLst['destino'] . ', ';

                            if ($tipoLst == 'V') {
                                $valor = $campoLst['origem'];
                            } else {
                                $valor = $row[$campoLst['origem']];
                            }

                            switch ($type['destino']) {
                                case 'int':
                                case 'int4':
                                case 'long':
                                    $sql_valor .= null($valor);
                                    break;

                                case 'numeric':
                                case 'decimal':
                                case 'newdecimal':
                                case 'double':
                                    $sql_valor .= null(desformat_decimal($valor));
                                    break;

                                case 'date':
                                case 'datetime':
                                case 'timestamp':
                                    $sql_valor .= aspa(trata_data($valor));
                                    break;

                                default:
                                    $sql_valor .= aspa($valor);
                                    break;
                            }

                            $sql_valor .= ', ';
                        }
                    }
                }

                $sql = 'insert into ' . $Lista['tabela'] . ' (
                                ' . $sql_campo . '
                                ' . $tid . ',
                                ' . $Lista['campo'] . '
                    ) values (
                                ' . $sql_valor . '
                                ' . $vetID[$Lista['tabela_pai']] . ',
                                ' . $chave . '
                    )';
                execsql($sql);
            }
        }
    }
}

function cadastraListarCmbMulti() {
    global $vetID, $id, $vetListarCmbMulti, $vetMesclarCadastro;

    ForEach ($vetListarCmbMulti as $Lista) {
        if (!$vetMesclarCadastro[$Lista['tabela_pai']]['soConsulta']) {
            if ($Lista['tabela_relacionamento'] != '') {
                $sql = "select * from " . $Lista['tabela_relacionamento'] . " where 1 = 0";
                $rs = execsql($sql);
                $type = $rs->info['type'];

                $sql = 'delete from ' . $Lista['tabela_relacionamento'] . ' where ' . $Lista['idt_relacionamento'] . ' = ' . null($vetID[$Lista['tabela_pai']]);
                execsql($sql);

                $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST[$Lista['campo']]]['sel_final'];
                $vetRetorno = $_SESSION[CS]['objListarCmbMulti'][$_POST[$Lista['campo']]]['vet_retorno'];
                $vetRetornoSQL = Array();

                foreach ($vetRetorno as $dados) {
                    $vetRetornoSQL[$dados['campo']] = $dados;
                }

                foreach ($vetSel as $dados) {
                    $vetV = Array();
                    $vetSC = Array();
                    $vetC = array_keys($dados);

                    foreach ($vetC as $campo) {
                        $vr = $vetRetornoSQL[$campo];
                        if ($vr['campo_tabela'] === true) {
                            $vetSC[] = $vr['sql_campo'];
                            $valor = $dados[$campo];

                            switch ($type[$campo]) {
                                case 'int':
                                case 'int4':
                                case 'long':
                                    $vetV[] = null($valor);
                                    break;

                                case 'numeric':
                                case 'decimal':
                                case 'newdecimal':
                                case 'double':
                                    $vetV[] = null(desformat_decimal($valor));
                                    break;

                                case 'date':
                                case 'datetime':
                                case 'timestamp':
                                    $vetV[] = aspa(trata_data($valor));
                                    break;

                                default:
                                    $vetV[] = aspa($valor);
                                    break;
                            }
                        }
                    }

                    $vetSC[] = $Lista['idt_relacionamento'];
                    $vetV[] = null($vetID[$Lista['tabela_pai']]);

                    $sql = 'insert into ' . $Lista['tabela_relacionamento'] . ' (' . implode(', ', $vetSC) . ') values (' . implode(', ', $vetV) . ')';
                    execsql($sql);
                }
            }
        }
    }
}

function campoInsert(&$sql_campo, &$sql_valor) {
    global $Coluna, $host, $bd_user, $password, $tipodb, $tabela, $vetFile;

    switch ($Coluna['tipo']) {
        case 'AutoNum':
            $sql_campo .= $Coluna['campo'] . ', ';
            $autonum = $_POST[$Coluna['campo']];

            if ($autonum == '') {
                $auto_prefixo = $Coluna['prefixo'];

                if ($auto_prefixo != '') {
                    $auto_prefixo = '_' . $auto_prefixo;
                }

                switch ($tipodb) {
                    case 'mssql':
                    case 'sqlsrv':
                    case 'mysql':
                        $tcon = new_pdo($host, $bd_user, $password, $tipodb);

                        if ($tipodb == 'mssql')
                            $tcon->exec('BEGIN TRANSACTION TIPO');
                        else
                            $tcon->beginTransaction();

                        if ($tipodb == 'mssql' || $tipodb == 'sqlsrv') {
                            $sql_auto = "select idt from plu_autonum where codigo = " . aspa($tabela . "_" . $Coluna['campo'] . $auto_prefixo);
                        } else {
                            $sql_auto = "select idt from plu_autonum where codigo = " . aspa($tabela . "_" . $Coluna['campo'] . $auto_prefixo) . ' FOR UPDATE';
                        }

                        $rs_auto = $tcon->query($sql_auto);
                        $data_auto = $rs_auto->fetchAll(PDO::FETCH_BOTH);

                        if (count($data_auto) == 0) {
                            $sql_auto = "insert into plu_autonum (codigo, idt) values (" . aspa($tabela . "_" . $Coluna['campo'] . $auto_prefixo) . ", 1)";
                            $tcon->exec($sql_auto);
                            $autonum = $Coluna['prefixo'] . ZeroEsq(1, $Coluna['zeroesq']);
                        } else {
                            $data_auto[0][0] = $data_auto[0][0] + 1;

                            $sql_auto = "update plu_autonum set idt = " . $data_auto[0][0] . " where codigo = " . aspa($tabela . "_" . $Coluna['campo'] . $auto_prefixo);
                            $tcon->exec($sql_auto);
                            $autonum = $Coluna['prefixo'] . ZeroEsq($data_auto[0][0], $Coluna['zeroesq']);
                        }

                        if ($tipodb == 'mssql')
                            $tcon->exec('COMMIT TRANSACTION TIPO');
                        else
                            $tcon->commit();

                        $tcon = NULL;
                        break;

                    case 'pgsql':
                        $rs_auto = execsql("select nextval('autonum_" . $tabela . "_" . $Coluna['campo'] . $auto_prefixo . "')");
                        $autonum = $Coluna['prefixo'] . ZeroEsq($rs_auto->data[0][0], $Coluna['zeroesq']);
                        break;

                    default:
                        msg_erro("Código de AutoNum não implementado para o banco $tipodb!");
                        break;
                }

                $_POST[$Coluna['campo']] = $autonum;
            }

            $sql_valor .= aspa($autonum) . ', ';
            break;

        case 'File':
            if ($vetFile[$Coluna['campo']]['sql']) {
                $sql_campo .= $Coluna['campo'] . ', ';

                $sql_valor .= aspa(mb_strtolower($_FILES[$Coluna['campo']]['name']));
                $sql_valor .= ', ';
            }
            break;

        default:
            $sql_campo .= $Coluna['campo'] . ', ';

            switch (tipo($Coluna['campo'], $Coluna['tabela'])) {
                case 'int':
                case 'int4':
                case 'long':
                    $sql_valor .= null($_POST[$Coluna['campo']]);
                    break;

                case 'numeric':
                case 'decimal':
                case 'newdecimal':
                case 'double':
                    $sql_valor .= null(desformat_decimal($_POST[$Coluna['campo']]));
                    break;

                case 'date':
                case 'datetime':
                case 'timestamp':
                    $sql_valor .= aspa(trata_data($_POST[$Coluna['campo']]));
                    break;

                default:
                    if ($Coluna['tipo'] == 'Senha')
                        $sql_valor .= aspa(md5($_POST[$Coluna['campo']]));
                    else
                        $sql_valor .= aspa($_POST[$Coluna['campo']]);
                    break;
            }

            $sql_valor .= ', ';
            break;
    }
}

function sqlInsert() {
    global $cadastro_conf, $sql_campo, $sql_valor, $tipodb, $vlID, $vetID, $vetLogSis, $pre_table, $tabela_banco;

    $idtVinculo = $cadastro_conf['idtVinculo'];
    $tabela_cad = $cadastro_conf['tabela'];
    $id_cad = $cadastro_conf['id'];

    if ($tabela_cad != '') {
        if ($idtVinculo == '') {
            $sql_campo_tmp = substr($sql_campo[$tabela_cad], 0, strrpos($sql_campo[$tabela_cad], ', '));
            $sql_valor_tmp = substr($sql_valor[$tabela_cad], 0, strrpos($sql_valor[$tabela_cad], ', '));
        } else if (is_array($cadastro_conf['idtVinculo'])) {
            $sql_campo_tmp = $sql_campo[$tabela_cad];
            $sql_valor_tmp = $sql_valor[$tabela_cad];

            foreach ($cadastro_conf['idtVinculo'] as $key => $value) {
                if ($value !== false) {
                    $sql_campo_tmp .= $key . ', ';
                    $sql_valor_tmp .= null($vetID[$value]) . ', ';
                }
            }

            $sql_campo_tmp = substr($sql_campo_tmp, 0, strrpos($sql_campo_tmp, ', '));
            $sql_valor_tmp = substr($sql_valor_tmp, 0, strrpos($sql_valor_tmp, ', '));
        } else {
            $sql_campo_tmp = $sql_campo[$tabela_cad] . $idtVinculo;
            $sql_valor_tmp = $sql_valor[$tabela_cad] . $vlID;
        }

        if ($sql_campo_tmp != '') {
            $sql = "insert into {$tabela_banco}{$tabela_cad} ($sql_campo_tmp) values ($sql_valor_tmp)";
            execsql($sql);

            switch ($tipodb) {
                case 'pgsql':
                    $vetID[$tabela_cad] = lastInsertId("{$tabela_cad}_{$id_cad}_seq");
                    break;

                case 'mssql':
                case 'sqlsrv':
                    $vetID[$tabela_cad] = lastInsertId($tabela_cad);
                    break;

                default:
                    $vetID[$tabela_cad] = lastInsertId();
                    break;
            }

            if ($vlID == '' || $vlID == 0) {
                $vlID = $vetID[$tabela_cad];
            }

            return Array(
                'nom_tabela' => $tabela_cad,
                'sts_acao' => 'I',
                'des_pk' => $vetID[$tabela_cad],
                'des_registro' => monta_des($tabela_cad),
            );
        }
    }
}

function LogDetalhe(&$vetLogDetalhe, $vetRow, $tipo_campo, $tabela) {
    global $vetCad, $campoDescListarCmb, $vetID;

    $vl_campo = 'vl_' . $tipo_campo;
    $desc_campo = 'desc_' . $tipo_campo;

    ForEach ($vetCad as $idxGrd => $vetGrd) {
        ForEach ($vetGrd as $idxFrm => $vetFrm) {
            if (is_array($vetFrm['dados'])) {
                ForEach ($vetFrm['dados'] as $nLinha => $Linha) {
                    ForEach ($Linha as $nColuna => $Coluna) {
                        if (is_array($Coluna)) {
                            if ($tabela == '') {
                                $gera_vet = true;
                            } else {
                                $gera_vet = $tabela == $Coluna['tabela'];
                            }

                            if ($Coluna['tipo'] != 'ListarConf' && $gera_vet) {
                                $vetLogDetalhe[$Coluna['tabela']][$Coluna['campo']]['campo_desc'] = $Coluna['nome'];
                                $vl = $vetRow[$Coluna['tabela']][$Coluna['campo']];

                                switch ($Coluna['tipo']) {
                                    case 'Lista':
                                        if ($Coluna['exc_campo'] == '' || $Coluna['exc_tabela'] == '') {
                                            $col = 1;
                                        } else {
                                            $col = 2;
                                        }

                                        $rsTmp = execsql(str_replace('$vlID', null($vetID[$Coluna['tabela']]), $Coluna['sql_lst_2']));
                                        $vetTmpVL = Array();
                                        $vetTmpDesc = Array();

                                        ForEach ($rsTmp->data as $linha) {
                                            $vlTmpDesc = '';

                                            for ($x = $col; $x < $rsTmp->cols; $x++) {
                                                $vlTmpDesc .= formata_valor($linha[$x], $rsTmp->info['type'][$x]);

                                                if ($x < $rsTmp->cols - 1) {
                                                    $vlTmpDesc .= ' - ';
                                                }
                                            }

                                            $vetTmpVL[] = $linha[0];
                                            $vetTmpDesc[] = $vlTmpDesc;
                                        }

                                        $vetLogDetalhe[$Coluna['tabela']][$Coluna['campo']][$vl_campo] = implode(', ', $vetTmpVL);
                                        $vetLogDetalhe[$Coluna['tabela']][$Coluna['campo']][$desc_campo] = implode(', ', $vetTmpDesc);
                                        break;

                                    case 'Radio':
                                    case 'cmbVetor':
                                    case 'FixoVetor':
                                        $vlTmpDesc = $Coluna['vetor'][$vl];

                                        if ($vlTmpDesc == '') {
                                            $vlTmpDesc = $vl;
                                        }

                                        $vetLogDetalhe[$Coluna['tabela']][$Coluna['campo']][$vl_campo] = $vl;
                                        $vetLogDetalhe[$Coluna['tabela']][$Coluna['campo']][$desc_campo] = $vlTmpDesc;
                                        break;

                                    case 'cmbBanco':
                                        $vetTmpVL = Array();
                                        $vetTmpDesc = Array();

                                        if ($vl != '') {
                                            $rsTmp = execsql($Coluna['sql']);

                                            ForEach ($rsTmp->data as $linha) {
                                                if ($linha[0] == $vl) {
                                                    $vlTmp = '';

                                                    for ($x = 1; $x < $rsTmp->cols; $x++) {
                                                        $vlTmp .= formata_valor($linha[$x], $rsTmp->info['type'][$x]);

                                                        if ($x < $rsTmp->cols - 1) {
                                                            $vlTmp .= ' - ';
                                                        }
                                                    }

                                                    $vetTmpVL[] = $linha[0];
                                                    $vetTmpDesc[] = $vlTmp;
                                                    break;
                                                }
                                            }
                                        }

                                        $vetLogDetalhe[$Coluna['tabela']][$Coluna['campo']][$vl_campo] = implode(', ', $vetTmpVL);
                                        $vetLogDetalhe[$Coluna['tabela']][$Coluna['campo']][$desc_campo] = implode(', ', $vetTmpDesc);
                                        break;

                                    case 'FixoBanco':
                                        $vetTmpVL = Array();
                                        $vetTmpDesc = Array();

                                        if ($vl != '') {
                                            $sql = 'select ' . $Coluna['id'] . ', ' . $Coluna['desc'] . ' from ' . $Coluna['tabela_obj'] . ' where ' . $Coluna['id'] . ' = ' . aspa($vl);
                                            $rsTmp = execsql($sql);

                                            if ($rsTmp->rows > 0) {
                                                $linha = $rsTmp->data[0];

                                                $vlTmp = '';

                                                for ($x = 1; $x < $rsTmp->cols; $x++) {
                                                    $vlTmp .= formata_valor($linha[$x], $rsTmp->info['type'][$x]);

                                                    if ($x < $rsTmp->cols - 1) {
                                                        $vlTmp .= ' - ';
                                                    }
                                                }

                                                $vetTmpVL[] = $linha[0];
                                                $vetTmpDesc[] = $vlTmp;
                                            }
                                        }

                                        $vetLogDetalhe[$Coluna['tabela']][$Coluna['campo']][$vl_campo] = implode(', ', $vetTmpVL);
                                        $vetLogDetalhe[$Coluna['tabela']][$Coluna['campo']][$desc_campo] = implode(', ', $vetTmpDesc);
                                        break;

                                    case 'ListarCmb':
                                        $vetTmpVL = Array();
                                        $vetTmpDesc = Array();

                                        if ($vl != '') {
                                            switch (tipo($Coluna['campo'], $Coluna['tabela'])) {
                                                case 'int':
                                                case 'int4':
                                                case 'long':
                                                    $sql_where = null($vl);
                                                    break;

                                                case 'numeric':
                                                case 'decimal':
                                                case 'newdecimal':
                                                case 'double':
                                                    $sql_where = null($vl);
                                                    break;

                                                case 'date':
                                                case 'datetime':
                                                case 'timestamp':
                                                    $sql_where = aspa($vl);
                                                    break;

                                                default:
                                                    $sql_where = aspa($vl);
                                                    break;
                                            }

                                            $vetFRO = includeListarCmb('listar_cmb/' . $Coluna['arq_cmb'] . '.php', $sql_where);

                                            $sql = '';
                                            $sql .= ' select t.' . $campoDescListarCmb;
                                            $sql .= ' from (' . $vetFRO['sql'] . ') t';
                                            $sql .= ' where t.' . $vetFRO['idCampo'] . ' = ' . $sql_where;

                                            $rsTmp = execsql($sql);
                                            $vetTmpVL[] = $vl;
                                            $vetTmpDesc[] = formata_valor($rsTmp->data[0][0], $rsTmp->info['type'][0]);
                                        }

                                        $vetLogDetalhe[$Coluna['tabela']][$Coluna['campo']][$vl_campo] = implode(', ', $vetTmpVL);
                                        $vetLogDetalhe[$Coluna['tabela']][$Coluna['campo']][$desc_campo] = implode(', ', $vetTmpDesc);
                                        break;

                                    case 'Senha':
                                        $vetLogDetalhe[$Coluna['tabela']][$Coluna['campo']][$desc_campo] = $vl;
                                        $vetLogDetalhe[$Coluna['tabela']][$Coluna['campo']]['cript'] = 'S';
                                        break;

                                    default:
                                        $vlTmp = formata_valor($vl, tipo($Coluna['campo'], $Coluna['tabela']));
                                        $vetLogDetalhe[$Coluna['tabela']][$Coluna['campo']][$desc_campo] = $vlTmp;
                                        break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

function vetLogDetalhe($sql_tabela) {
    global $vetLogDetalheAnt, $vetSql, $tabela, $vetMesclarCadastro, $vetID, $vetLogDetalheExtra, $id, $tabela_banco;

    $vetRowAtu = Array();

    if ($sql_tabela == '') {
        $vetRowAtu[$sql_tabela] = Array();
    } else {
        $lst_campo = $vetSql[$sql_tabela];

        $sql = 'select ' . $lst_campo;

        if ($sql_tabela == $tabela) {
            $sql_id = $id;
        } else {
            $sql_id = $vetMesclarCadastro[$sql_tabela]['id'];
        }

        $sql .= "$sql_id from {$tabela_banco}$sql_tabela where $sql_id = ";

        $rs = execsql($sql . null($vetID[$sql_tabela]));

        if ($rs->rows == 0) {
            $vetRowAtu[$sql_tabela] = Array();
        } else {
            $vetRowAtu[$sql_tabela] = $rs->data[0];
        }
    }

    $vetLogDetalhe = Array();
    $vetLogDetalhe[$sql_tabela] = $vetLogDetalheAnt[$sql_tabela];
    LogDetalhe($vetLogDetalhe, $vetRowAtu, 'atu', $sql_tabela);

    $vetLogDetalhe = array_merge_recursive($vetLogDetalhe, $vetLogDetalheExtra);

    return $vetLogDetalhe[$sql_tabela];
}
