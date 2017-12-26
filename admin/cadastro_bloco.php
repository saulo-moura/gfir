
<style type="text/css">

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

    div#bloco {
        background-color: #EFEFEF;
        border:2px solid #C0C0C0;
        padding:3px;
    }
    div#titulo_bloco {
        background-color: #EFEFEF;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 16px;
        font-style: normal;
        font-weight: bold;
        color: #900000;
        text-align:center;
        padding:10px;
    }
</style>



<?php
echo "<div id='help_campo'>";
echo "    <div id='help_campo_cab'>";
echo "         <img onclick='desativa_help_campo();' title='Fechar ajuda de campo' src='imagens/fechar.gif' border='0'>";

echo '<a  >'."&nbsp;<img onclick='return abre_ajuda_campo();' title='Atualiza Ajuda do Campo' src='imagens/alterar.gif' border='0'>".'&nbsp;</a>';

echo "        <span id='help_campo_cab_texto'>Help de Campo</span>";
echo "    </div>";
echo "    <div id='help_campo_det'>";
echo "    </div>";
echo "</div>";



$vetCampo = Array();
$vetCad = Array();
$vetTab = Array();
$vetFile = Array();
$vetLista = Array();
$vetLstDel = Array();
$vetLstExtra = Array();
$vetTabExtra = Array();
$vetDesativa = Array();
$vetAtivadoObr = Array();
$TamFonte = 8;
$vlID = '';
$par_url = '';
$botao_acao = '';
$botao_volta = '';
$pagina = 'conteudo'.$cont_arq.'.php';
$tabHtml = '';
$jsData = 'onblur="return Valida_Data_Hoje(this)" onkeyup="return Formata_Data(this,event)"';
$jsMinCaract = 'onblur="return minCaracteres(this)"';

Require_Once('fncCampo.php');

$onSubmitAnt = ''; //Colocar nome da funcao do js para ser chamada no onSubmit do formulario antes da validação padrão
$onSubmitDep = ''; //Colocar nome da funcao do js para ser chamada no onSubmit do formulario depois da validação padrão
$onSubmitCon = ''; //Colocar nome da funcao do js para ser chamada no onSubmit do formulario depois da confirmação
$id = 'idt';

$sql_bloco = '';
$idt_pai = 0;
$idt_filho = 0;
$nome_pai = '';
$qtd_campos = 0;
$vetnao_grava = Array();
$innerw = '';
$orderbyw = '';
$wherew = '';
$alitabelaw = '';

$MesclarCadastro = false;
$path = 'cadastro_conf/'.$menu.'.php';

if (file_exists($path)) {
    Require_Once($path);
} else {
    echo "<br><br><div align='center' class='Msg'>Função em desenvolvimento...</div>";
    onLoadPag();
    FimTela();
    exit();
}

$vetTemp = array_keys($vetTab);
$posTabIni = $vetTemp[0];
$posTabFim = $vetTemp[count($vetTemp) - 1];
////echo 'acao ggggg '.$acao;
acesso($menu, aspa($acao), true, false);

//Tipo dos dados no banco
if ($tabela != '') {
    $sql = "select * from $tabela where $id = 0";
    $rs = execsql($sql);
    $type = $rs->info['type'];

    $campos_tabela = $rs->info['name'];
}

function tipo($campo) {
    global $type;
    return $type[$campo];
}

ForEach ($vetCad as $idxGrd => $vetGrd) {
    ForEach ($vetGrd as $idxFrm => $vetFrm) {
        ForEach ($vetFrm['dados'] as $nLinha => $Linha) {
            ForEach ($Linha as $nColuna => $Coluna) {
                if (is_array($Coluna)) {
                    //if ($Coluna['tipo'] == 'Html' || $Coluna['tipo'] == 'TextArea' || $Coluna['tipo'] == 'File' || $Coluna['tipo'] == 'Senha' || $Coluna['tipo'] == 'Lista' || $Coluna['tipo'] == 'Checkbox')
                    $par_url .= $Coluna['campo'].',';

                    switch ($Coluna['tipo']) {
                        case 'Lista':
                            $vetLista[] = Array(
                                'campo' => $Coluna['campo'],
                                'idt_cadastro' => $Coluna['idt_cadastro'],
                                'tabela' => $Coluna['tabela_relacionamento']
                            );
                            break;

                        case 'Senha':
                            if ($_GET['id'] != 0)
                                $vetCad[$idxGrd][$idxFrm]['dados'][$nLinha][$nColuna]['valida'] = false;
                            break;

                        case 'File':
                            $vetFile[$Coluna['campo']] = Array(
                                'nome' => $Coluna['nome'],
                                'grupo' => $Coluna['grupo'],
                                'largura' => $Coluna['largura'] == '' ? null : $Coluna['largura'],
                                'altura' => $Coluna['altura'] == '' ? null : $Coluna['altura'],
                                'max_tamanho' => $Coluna['max_tamanho'] * 1024,
                                'sql' => false
                            );

                            if ($_GET['id'] != 0)
                                $vetCad[$idxGrd][$idxFrm]['dados'][$nLinha][$nColuna]['valida'] = false;
                            break;
                    }
                }
            }
        }
    }
}

$par_url .= 'prefixo,id,acao,MAX_FILE_SIZE';


//echo ' botao '.$_POST['btnAcao'];

switch ($_POST['btnAcao']) {
    case 'Salvar':
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

                $extensao = mb_strtolower(array_pop(explode('.', $_FILES[$Campo]['name'])));
                if (!in_array(mb_strtolower($_FILES[$Campo]['type']), $vetMime[$Dados['grupo']][$extensao]) && $_FILES[$Campo]['type'] != '') {
                    echo '
                        <script type="text/javascript">
                            alert("O arquivo \"'.$_FILES[$Campo]['name'].'\" do tipo \"'.$_FILES[$Campo]['type'].'\" não é de um tipo valido para o campo '.$Dados['nome'].'.");
                            history.go(-1);
                        </script>
                    ';
                    exit();
                }
            }
        }

        beginTransaction();

        Require_Once('cadastro_acao_ant.php');

        if ($tabela != '') {
            $sql_campo = '';
            $sql_valor = '';

            ForEach ($vetCad as $idxGrd => $vetGrd) {
                ForEach ($vetGrd as $idxFrm => $vetFrm) {
                    ForEach ($vetFrm['dados'] as $nLinha => $Linha) {
                        ForEach ($Linha as $Coluna) {
                            if (is_array($Coluna)) {
                                if ($Coluna['campo_tabela']) {
                                    switch ($Coluna['tipo']) {
                                        case 'AutoNum':
                                            $sql_campo .= $Coluna['campo'].', ';

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
                                                        $sql_auto = "select idt from plu_autonum where codigo = ".aspa($tabela."_".$Coluna['campo']);
                                                    } else {
                                                        $sql_auto = "select idt from plu_autonum where codigo = ".aspa($tabela."_".$Coluna['campo']).' FOR UPDATE';
                                                    }

                                                    $rs_auto = $tcon->query($sql_auto);
                                                    $data_auto = $rs_auto->fetchAll(PDO::FETCH_BOTH);

                                                    if (count($data_auto) == 0) {
                                                        $sql_auto = "insert into plu_autonum (codigo, idt) values (".
                                                                aspa($tabela."_".$Coluna['campo']).", 1)";
                                                        $tcon->exec($sql_auto);
                                                        $sql_valor .= aspa(ZeroEsq(1, $Coluna['size']));
                                                    } else {
                                                        $data_auto[0][0] = $data_auto[0][0] + 1;

                                                        $sql_auto = "update plu_autonum set idt = ".$data_auto[0][0]."
                                                                     where codigo = ".aspa($tabela."_".$Coluna['campo']);
                                                        $tcon->exec($sql_auto);
                                                        $sql_valor .= aspa(ZeroEsq($data_auto[0][0], $Coluna['size']));
                                                    }

                                                    if ($tipodb == 'mssql')
                                                        $tcon->exec('COMMIT TRANSACTION TIPO');
                                                    else
                                                        $tcon->commit();

                                                    $tcon = NULL;
                                                    break;

                                                case 'pgsql':
                                                    $rs_auto = execsql("select nextval('autonum_".$tabela."_".$Coluna['campo']."')");
                                                    $sql_valor .= aspa(ZeroEsq($rs_auto->data[0][0], $Coluna['size']));
                                                    break;

                                                default:
                                                    msg_erro("Código de AutoNum não implementado para o banco $tipodb!");
                                                    break;
                                            }

                                            $sql_valor .= ', ';
                                            break;

                                        case 'File':
                                            if ($vetFile[$Coluna['campo']]['sql']) {
                                                $sql_campo .= $Coluna['campo'].', ';

                                                $sql_valor .= aspa(mb_strtolower($_FILES[$Coluna['campo']]['tmp_name']));
                                                $sql_valor .= ', ';
                                            }
                                            break;

                                        default:
                                            $sql_campo .= $Coluna['campo'].', ';

                                            switch (tipo($Coluna['campo'])) {
                                                case 'int':
                                                case 'int4':
                                                case 'long':
                                                    $sql_valor .= null($_POST[$Coluna['campo']]);
                                                    break;

                                                case 'numeric':
                                                case 'decimal':
                                                case 'newdecimal':
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
                            }
                        }
                    }
                }
            }

            $sql_campo = substr($sql_campo, 0, strrpos($sql_campo, ', '));
            $sql_valor = substr($sql_valor, 0, strrpos($sql_valor, ', '));

            $sql = "insert into $tabela ($sql_campo) values ($sql_valor)";
            $result = execsql($sql);

            switch ($tipodb) {
                case 'pgsql':
                    $vlID = lastInsertId("{$tabela}_{$id}_seq");
                    break;

                case 'mssql':
                case 'sqlsrv':
                    $vlID = lastInsertId($tabela);
                    break;

                default:
                    $vlID = lastInsertId();
                    break;
            }

            grava_log_sis($tabela, 'I', $vlID, monta_des($tabela));

            if (count($vetFile) > 0 && $tabela != '') {
                $sql_update = '';

                ForEach ($vetFile as $Campo => $Dados) {
                    if ($Dados['sql']) {
                        $nomearq = mb_strtolower($vlID.'_'.$Campo.'_'.troca_caracter($_FILES[$Campo]['name']));
                        $sql_update .= $Campo.' = '.aspa($nomearq).', ';
                    }
                }

                if (strlen($sql_update) > 0) {
                    $sql_update = substr($sql_update, 0, strrpos($sql_update, ', '));
                    $result = execsql("update $tabela set $sql_update where $id = ".$vlID);
                }
            }

            cadastra_lista();
        }
        $deucommit = 0;
        Require_Once('cadastro_acao_dep.php');

        if (count($vetFile) > 0 && $tabela != '') {
            $path = dirname($_SERVER['SCRIPT_FILENAME']);
            if ($path == '')
                msg_erro('Não foi possível obter o path real do sistema!');

            $path .= DIRECTORY_SEPARATOR.$dir_file;
            if (!file_exists($path))
                mkdir($path);

            $path .= DIRECTORY_SEPARATOR.$tabela;
            if (!file_exists($path))
                mkdir($path);

            $path .= DIRECTORY_SEPARATOR;

            ForEach ($vetFile as $Campo => $Dados) {
                if ($Dados['sql']) {
                    set_time_limit(600);

                    imgsize($_FILES[$Campo]['tmp_name'], $_FILES[$Campo]['tmp_name'], $Dados['largura'], $Dados['altura']);

                    $Dados['max_tamanho'] = 0;

                    if (file_exists($_FILES[$Campo]['tmp_name']) && $Dados['max_tamanho'] > 0) {
                        if (filesize($_FILES[$Campo]['tmp_name']) > $Dados['max_tamanho']) {
                            echo "
                                <br>
                                <div align='center' class='Msg'>O arquivo de ".$Dados['nome']." ultrapassou o tamanho maximo permitido de ".($Dados['max_tamanho'] / 1024)."kb!
                                <br><br><input type='button' name='btnAcao' class='Botao' value=' Voltar ' onClick='history.go(-1)'>
                                </div>
                            ";
                            onLoadPag();
                            FimTela();
                            exit();
                        }
                    }

                    $nomearq = mb_strtolower($vlID.'_'.$Campo.'_'.troca_caracter($_FILES[$Campo]['name']));
                    move_uploaded_file($_FILES[$Campo]['tmp_name'], $path.$nomearq);
                }
            }
        }

        if ($deucommit == 0) {
            commit();
        }
        if ($botao_acao == '')
            echo "<script type='text/javascript'>$target_js.location = 'conteudo".$cont_arq.".php?prefixo=listar".getParametro($par_url)."';</script>";
        else
            echo $botao_acao;

        onLoadPag();
        exit();
        break;

    case 'Alterar':
        $vlID = $_POST['id'];

        $tam = count($_POST);
        $vetor_registro = Array();
        $qtd_linhas = ($tam - 3) / $qtd_campos;
        $i = 0;
        $idt_ant = 0;
        $vetor_cpo = Array();
        ForEach ($_POST as $campo => $conteudo) {
            if ($i == 0 or $i == 1 or $i == $tam) {
                $i = $i + 1;
                continue;
            }
            $t = strpos($campo, '#');
            $Campow = substr($campo, 0, $t);
            $idtw = substr($campo, $t + 1);
            $conteudow = $conteudo;
            // p(' ttttt '.$t.' cccc '.$Campow. ' mmmmm '.$idtw);
            if ($idt_ant != $idtw) {
                if ($idt_ant == 0) {
                    $idt_ant = $idtw;
                } else {
                    $vetor_registro[$idt_ant] = $vetor_cpo;
                    $vetor_cpo = Array();
                    $idt_ant = $idtw;
                }
            }
            $vetor_cpo[$Campow] = $conteudow;
            $i = $i + 1;
        }
        if ($idt_ant != 0) {
            $vetor_registro[$idt_ant] = $vetor_cpo;
        }

        //  p($vetor_registro);

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

                $extensao = mb_strtolower(array_pop(explode('.', $_FILES[$Campo]['name'])));
                if (!in_array(mb_strtolower($_FILES[$Campo]['type']), $vetMime[$Dados['grupo']][$extensao]) && $_FILES[$Campo]['type'] != '') {
                    echo '
                        <script type="text/javascript">
                            alert("O arquivo \"'.$_FILES[$Campo]['name'].'\" do tipo \"'.$_FILES[$Campo]['type'].'\" não é de um tipo valido para o campo '.$Dados['nome'].'.");
                            history.go(-1);
                        </script>
                    ';
                    exit();
                }
            }
        }

        beginTransaction();

        Require_Once('cadastro_acao_ant.php');


        ForEach ($vetor_registro as $idt_y => $vetcposw) {
            $vlID = $idt_y;

            if ($tabela != '') {
                $sql = "update $tabela set ";

                ForEach ($vetCad as $idxGrd => $vetGrd) {
                    ForEach ($vetGrd as $idxFrm => $vetFrm) {
                        ForEach ($vetFrm['dados'] as $nLinha => $Linha) {
                            ForEach ($Linha as $Coluna) {
                                if (is_array($Coluna)) {

                                    if ($Coluna['campo_tabela']) {
                                        $altera = true;
                                        $vlCampo = $vetcposw[$Coluna['campo']];

                                        switch ($Coluna['tipo']) {
                                            case 'Senha':
                                            case 'Checkbox':
                                                if ($vetcposw[$Coluna['campo']] == '')
                                                    $altera = false;
                                                break;

                                            case 'File':
                                                if ($vetFile[$Coluna['campo']]['sql'])
                                                    $vlCampo = mb_strtolower($vlID.'_'.$Coluna['campo'].'_'.$_FILES[$Coluna['campo']]['name']);
                                                else if ($vetcposw['remover_'.$Coluna['campo']] == 'S')
                                                    $vlCampo = '';
                                                else
                                                    $altera = false;
                                                break;
                                        }

                                        if ($vetnao_grava[$Coluna['campo']] == 'N') {
                                            $altera = false;
                                        }
                                        if ($altera) {
                                            $sql .= $Coluna['campo'].' = ';

                                            switch (tipo($Coluna['campo'])) {
                                                case 'int':
                                                case 'int4':
                                                case 'long':
                                                    $sql .= null($vlCampo);
                                                    break;

                                                case 'numeric':
                                                case 'decimal':
                                                case 'newdecimal':
                                                    $sql .= null(desformat_decimal($vlCampo));
                                                    break;

                                                case 'date':
                                                case 'datetime':
                                                case 'timestamp':
                                                    $sql .= aspa(trata_data($vlCampo));
                                                    break;

                                                default:
                                                    if ($Coluna['tipo'] == 'Senha')
                                                        $sql .= aspa(md5($vlCampo));
                                                    else
                                                        $sql .= aspa($vlCampo);
                                                    break;
                                            }
                                            $sql .= ', ';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $sql = substr($sql, 0, strrpos($sql, ', '));
                $sql .= " where $id = ".$vlID;

                $result = execsql($sql);

                // p($_POST);
                //    p($sql);
                // exit();
                grava_log_sis($tabela, 'A', $vlID, monta_des($tabela));

                cadastra_lista();
            }
        }
        $deucommit = 0;

        Require_Once('cadastro_acao_dep.php');

        if (count($vetFile) > 0 && $tabela != '') {
            $path = dirname($_SERVER['SCRIPT_FILENAME']);
            if ($path == '')
                msg_erro('Não foi possível obter o path real do sistema!');

            $path .= DIRECTORY_SEPARATOR.$dir_file;
            if (!file_exists($path))
                mkdir($path);

            $path .= DIRECTORY_SEPARATOR.$tabela;
            if (!file_exists($path))
                mkdir($path);

            $path .= DIRECTORY_SEPARATOR;

            ForEach ($vetFile as $Campo => $Dados) {
                if ($Dados['sql']) {
                    set_time_limit(600);

                    imgsize($_FILES[$Campo]['tmp_name'], $_FILES[$Campo]['tmp_name'], $Dados['largura'], $Dados['altura']);


                    $Dados['max_tamanho'] = 0;

                    if (file_exists($_FILES[$Campo]['tmp_name']) && $Dados['max_tamanho'] > 0) {
                        if (filesize($_FILES[$Campo]['tmp_name']) > $Dados['max_tamanho']) {
                            echo "
                                <br>
                                <div align='center' class='Msg'>O arquivo de ".$Dados['nome']." ultrapassou o tamanho maximo permitido de ".($Dados['max_tamanho'] / 1024)."kb!
                                <br><br><input type='button' name='btnAcao' class='Botao' value=' Voltar ' onClick='history.go(-1)'>
                                </div>
                            ";
                            onLoadPag();
                            FimTela();
                            exit();
                        }
                    }

                    if (file_exists($path.$_POST[$Campo.'_ant']) && $_POST[$Campo.'_ant'] != '')
                        unlink($path.$_POST[$Campo.'_ant']);

                    $nomearq = mb_strtolower($vlID.'_'.$Campo.'_'.troca_caracter($_FILES[$Campo]['name']));
                    move_uploaded_file($_FILES[$Campo]['tmp_name'], $path.$nomearq);
                } else if ($_POST['remover_'.$Campo] == 'S') {
                    if (file_exists($path.$_POST[$Campo.'_ant']) && $_POST[$Campo.'_ant'] != '')
                        unlink($path.$_POST[$Campo.'_ant']);
                }
            }
        }

        if ($deucommit == 0) {
            commit();
        }


        //Require_Once('cadastro_acao_dep.php');
        //  p(' ts '.$target_js.' aaa '.$cont_arq. ' url '.getParametro($par_url));
        //  exit();

        if ($botao_acao == '') {
            $par_urlw = getParametro($par_url);
            $par_urlw = str_replace('#', '__', $par_urlw);
            echo "<script type='text/javascript'>$target_js.location = 'conteudo".$cont_arq.".php?prefixo=listar".$par_urlw."';</script>";
        } else {
            echo $botao_acao;
        }
        onLoadPag();
        exit();
        break;

    case 'Excluir':
        beginTransaction();

        $vlID = $_POST['id'];
        //  p($_POST);
        //  exit();
        Require_Once('cadastro_acao_ant.php');

        if ($tabela != '') {
            $sql = "delete from $tabela where $id = ".$_POST['id'];
            $result = execsql($sql);

            grava_log_sis($tabela, 'E', $vlID, monta_des($tabela));
        }

        Require_Once('cadastro_acao_dep.php');

        commit();

        if (count($vetFile) > 0 && $tabela != '') {
            $path = dirname($_SERVER['SCRIPT_FILENAME']);
            $path .= DIRECTORY_SEPARATOR.$dir_file;
            $path .= DIRECTORY_SEPARATOR.$tabela;
            $path .= DIRECTORY_SEPARATOR;

            ForEach ($vetFile as $Campo => $Dados) {
                if (file_exists($path.$_POST[$Campo.'_ant']) && $_POST[$Campo.'_ant'] != '')
                    unlink($path.$_POST[$Campo.'_ant']);
            }
        }

        if ($botao_acao == '')
            echo "<script type='text/javascript'>$target_js.location = 'conteudo".$cont_arq.".php?prefixo=listar".getParametro($par_url)."';</script>";
        else
            echo $botao_acao;

        onLoadPag();
        exit();
        break;

    case 'Enviar':
        Require_Once('cadastro_acao_dep.php');

        echo $botao_acao;

        onLoadPag();
        exit();
        break;
}

$vetCampoJS = Array();
$vetNomeJS = Array();
$vetGrdJS = Array();
$vetObrJS = Array();
$vetFocusJS = Array();
$sql = 'select ';

ForEach ($vetCad as $idxGrd => $vetGrd) {
    ForEach ($vetGrd as $idxFrm => $vetFrm) {
        ForEach ($vetFrm['dados'] as $nLinha => $Linha) {
            ForEach ($Linha as $Coluna) {
                if (is_array($Coluna)) {
                    $vetCampoJS[] = $Coluna['campo'];

                    if ($Coluna['tipo'] == 'Lista') {
                        $vetFocusJS[] = $Coluna['campo'].'_lista';
                        $vetObrJS[] = '_lst_2';
                    } else {
                        $vetFocusJS[] = $Coluna['campo'];
                        $vetObrJS[] = '_desc';
                    }

                    $vetGrdJS[] = $idxGrd;
                    $vetNomeJS[] = $Coluna['nome'];

                    if ($Coluna['campo_tabela'])
                        $sql .= $Coluna['campo'].', ';

                    if ($onLoadPag == '' && $Coluna['focus'])
                        $onLoadPag = $Coluna['campo'];
                }
            }
        }
    }
}

//$sql .= "$id from $tabela where $id = ".$_GET['id'];

$sql .= " $alitabelaw.$id from $tabela $alitabelaw ";
$sql .= ' '.$innerw;
//$sql .= " where idt_empreendimento = ".$_GET['idt0'];
$sql .= ' '.$wherew;
$sql .= ' '.$orderbyw;




if ($tabela == '') {
    $row = Array();
} else {
    $rs = execsql($sql);
    $row = $rs->data[0];
}

if ($acao == 'inc') {
    $path_i = 'cadastro_conf/'.$menu.'_definc.php';
    if (file_exists($path_i)) {
        Require_Once($path_i);
    }
}
//p($row);
//exit();



if ($onLoadPag == '')
    onLoadPag('', 'id');
else
    onLoadPag($onLoadPag);

camposObrigatoriosTab();

ForEach ($vetTab as $idxTab => $Tab) {
    if ($Tab != '')
        $tabHtml .= '<li><a href="#grd'.$idxTab.'"><span>'.$Tab.'</span></a></li>';
}
?>
<script type="text/javascript">
    var objLista = new Array();
    var objFile = new Array();
    var objFileMime = new Array();
    var objFileNome = new Array();

    function inclui(lst1, lst2) {
        var i;

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
    }

    function exclui(lst1, lst2) {
        var i;
        var msg = '';

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

        if (msg != '')
            alert('Não pode excluir da lista os registros:\n\n' + msg);
    }
    function   envia_bloco()
    {
        var valida = 'S';
        alert('enviar');
        envia();
        return false;
    }

    function envia() {

        var i;
        var v;
        var id;
        var lista;

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
        if ('.($onSubmitAnt == '' ? 'true' : $onSubmitAnt).') {
            if (frmFcn()) {
                if ('.($onSubmitDep == '' ? 'true' : $onSubmitDep).') {
                    if (confirm("Deseja realmente confirmar essa operação?")) {
                        return '.($onSubmitCon == '' ? 'true' : $onSubmitCon).';
                    }
                }
            }
        }

        return false;
    ';
?>
    }

    $(document).ready(function () {
        if (($('div#geral' + popup).height() - $('div#rodape' + popup).height()) > $(window).height())
            $('div#barra_bt_top').show();

<?php
ForEach ($vetDesativa as $idx => $vetDesCampo) {
    ForEach ($vetDesCampo as $i => $vet) {
        echo '
                $("#'.$idx.'").change(function() {
                    var campo = $("'.$vet['campo'].'");
                    var obr = $("'.$vetAtivadoObr[$idx][$i]['obr'].'");

                    func_AtivaDesativa($(this).val().toLowerCase(), "'.$vet['valor'].'".split(","), campo, obr);
                });

                var campo = $("'.$vet['campo'].'");
                if ($.inArray($("#'.$idx.'").val().toLowerCase(), "'.$vet['valor'].'".split(",")) > -1)
                    campo.attr("disabled", "true");
                else
                    campo.removeAttr("disabled");

                $("#'.$idx.'").change();
            ';
    }
}

if ($acao == 'con' || $acao == 'exc')
    echo '$("input:visible:not([name=\'btnAcao\']), select:visible, textarea:visible").attr("disabled", "true");';
?>

        $(':disabled').addClass('campo_disabled');


//        $("input:'cor_gsd')



    });

    function func_AtivaDesativa(vl_campo, vl_padrao, campo, obr) {
        if ($.inArray(vl_campo, vl_padrao) > -1) {
            campo.attr("disabled", "true");
            campo.addClass("campo_disabled");
            obr.addClass("Tit_Campo");
            obr.removeClass("Tit_Campo_Obr");

            campo.val("");
            campo.change();
        } else {
            campo.removeAttr("disabled");
            campo.removeClass("campo_disabled");
            obr.addClass("Tit_Campo_Obr");
            obr.removeClass("Tit_Campo");
        }
    }

</script>

<?php
// loop para listar linhas

echo '<div id="bloco" >'.nl();

$primeiro = 0;
?>



<form id="frm" name="frm" <?php echo (count($vetFile) == 0 ? '' : 'enctype="multipart/form-data"') ?> target="_self" action="<?php echo $pagina ?>?<?php echo substr(getParametro(), 1) ?>" method="post" onSubmit="return envia()" style="margin:0px;">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $vetConf['max_upload_size']; ?>">
    <input type="hidden" name="id" id="id" value="<?php echo $idt_pai ?>">


    <?php
    echo '<table border="1" width="100%" cellspacing="0" cellpadding="0" align="center">'.nl();
    echo "<tr  >\n";
    echo "<td  >\n";
    echo "<div id='titulo_bloco'> ".$nome_pai."</div>";
    echo "</td  >\n";
    echo "</tr  >\n";
    echo '</table>';

    bt_codigo(False);


    echo '<table border="0" cellspacing="0" cellpadding="0" align="center">'.nl();


/////// cabeçalho
    ForEach ($vetCad as $idxGrd => $vetGrd) {
        ForEach ($vetGrd as $idxFrm => $vetFrm) {
            ForEach ($vetFrm['dados'] as $Linha) {

                echo "<tr  >\n";

                ForEach ($Linha as $Coluna) {
                    if (is_array($Coluna)) {
                        echo '<td id="'.$Coluna['campo'].'_desc" colspan="'.$Coluna['coluna'].'" rowspan="'.$Coluna['linha'].'" class="Tit_Campo'.($Coluna['valida'] ? '_Obr' : '').'"   style="text-align:center; border-bottom:5px solid #FFFFFF;"   >';

                        switch ($Coluna['tipo']) {
                            case 'Lista':
                                codigo_lista();
                                break;

                            case 'Include':
                                Require_Once($Coluna['arquivo']);
                                break;

                            case 'HiddenSql':
                                if ($_GET[$Coluna['id'].$Coluna['num_id']] > 0) {
                                    $sql = 'select '.$Coluna['desc'].' from '.$Coluna['tabela_obj'].' where '.$Coluna['id'].' = '.aspa($_GET[$Coluna['id'].$Coluna['num_id']]);
                                    $rs_fixo = execsql($sql);

                                    echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'" type="hidden" value="'.trata_html($rs_fixo->data[0][$Coluna['desc']]).'">';
                                } else {
                                    echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'" type="hidden">';
                                }
                                echo '<img src="imagens/trans.gif" width="0" height="0" border="0">';
                                break;

                            case 'AutoNum':

                                if ($Coluna['nome'] != '' && $Coluna['mostra'])
                                    echo '<label for="'.$Coluna['campo'].'">'.$Coluna['nome'].':<span class="asterisco">*</span></label>';
                                break;

                            default:

                                if ($primeiro == 0) {
                                    if ($Coluna['nome'] != '')
                                        echo '<label for="'.$Coluna['campo'].'"   onclick="return help_campo('."event, ' ".$Coluna['campo']."', '".$tabela."', '".$Coluna['nome']."'".');" style="cursor: pointer;">'.$Coluna['nome'].':<span class="asterisco">*</span></label>';
                                }
                                else {
                                    if ($Coluna['nome'] != '')
                                        echo '<label for="'.$Coluna['campo'].'"   onclick="return help_campo('."event, ' ".$Coluna['campo']."', '".$tabela."', '".$Coluna['nome']."'".');" style="">'.'&nbsp;'.':<span class="asterisco">&nbsp;</span></label>';
                                }
                                break;
                        }

                        echo "</td>\n";
                    } else
                        echo '<td  style="text-align:center; border-bottom:5px solid #FFFFFF;" ><img src="imagens/trans.gif" width="15" height="0" border="0"  ></td>'."\n";
                }

                echo "</tr>"."\n";
            }
        }
        $primeiro == 1;
    }





///////////////////////




    ForEach ($rs->data as $row) {

        $idt_bloco = $row['idt'];
        ?>


        <?php
//  bt_codigo(True);

        ForEach ($vetCad as $idxGrd => $vetGrd) {
//        if ($tabHtml != '' && $idxGrd == $posTabIni) {
//            echo '<div id="tabHtml"><ul>'.$tabHtml.'</ul>'.nl();
//        }
            echo '<div id="grd'.$idxGrd.'" class="grupo">'.nl();

            ForEach ($vetGrd as $idxFrm => $vetFrm) {
                // echo '<fieldset id="frm'.$idxFrm.'" class="frame">'.nl();
                if ($primeiro == 0) {
                    if ($vetFrm['nome'])
                        echo '<legend align="left">'.$vetFrm['nome'].'</legend>'.nl();
                }
                echo '<div style="background-color: '.$vetFrm['cor_fundo'].';">';
//          echo '<table border="0" cellspacing="0" cellpadding="0" align="center">'.nl();

                ForEach ($vetFrm['dados'] as $Linha) {

                    /*
                      echo "<tr>\n";

                      ForEach ($Linha as $Coluna) {
                      if (is_array($Coluna)) {
                      echo '<td id="'.$Coluna['campo'].'_desc" colspan="'.$Coluna['coluna'].'" rowspan="'.$Coluna['linha'].'" class="Tit_Campo'.($Coluna['valida'] ? '_Obr' : '').'">';

                      switch ($Coluna['tipo']) {
                      case 'Lista':
                      codigo_lista();
                      break;

                      case 'Include':
                      Require_Once($Coluna['arquivo']);
                      break;

                      case 'HiddenSql':
                      if ($_GET[$Coluna['id'].$Coluna['num_id']] > 0) {
                      $sql = 'select '.$Coluna['desc'].' from '.$Coluna['tabela_obj'].' where '.$Coluna['id'].' = '.aspa($_GET[$Coluna['id'].$Coluna['num_id']]);
                      $rs_fixo = execsql($sql);

                      echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'" type="hidden" value="'.trata_html($rs_fixo->data[0][$Coluna['desc']]).'">';
                      } else {
                      echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'" type="hidden">';
                      }
                      echo '<img src="imagens/trans.gif" width="0" height="0" border="0">';
                      break;

                      case 'AutoNum':

                      if ($Coluna['nome'] != '' && $Coluna['mostra'])
                      echo '<label for="'.$Coluna['campo'].'">'.$Coluna['nome'].':<span class="asterisco">*</span></label>';
                      break;

                      default:

                      if ($primeiro==0)
                      {
                      if ($Coluna['nome'] != '')
                      echo '<label for="'.$Coluna['campo'].'"   onclick="return help_campo('."event, ' ".$Coluna['campo']."', '".$tabela."', '".$Coluna['nome']."'" .');" style="cursor: pointer;">'.$Coluna['nome'].':<span class="asterisco">*</span></label>';
                      }
                      else
                      {
                      if ($Coluna['nome'] != '')
                      echo '<label for="'.$Coluna['campo'].'"   onclick="return help_campo('."event, ' ".$Coluna['campo']."', '".$tabela."', '".$Coluna['nome']."'" .');" style="">'.'&nbsp;'.':<span class="asterisco">&nbsp;</span></label>';

                      }
                      break;
                      }

                      echo "</td>\n";
                      } else
                      echo '<td><img src="imagens/trans.gif" width="15" height="0" border="0"></td>'."\n";
                      }

                      echo "</tr>"."\n";
                     */
                    echo "<tr>\n";

                    ForEach ($Linha as $Coluna) {
                        if (is_array($Coluna)) {
                            if ($Coluna['tipo'] != 'Include') {
                                echo '<td id="'.$Coluna['campo'].'_obj" colspan="'.$Coluna['coluna'].'"  style="border-bottom:5px solid #FFFFFF;" >';

                                switch ($Coluna['tipo']) {
                                    case 'Geral':
                                        if (tipo($Coluna['campo']) == 'date' || tipo($Coluna['campo']) == 'datetime' || tipo($Coluna['campo']) == 'timestamp')
                                            $valor = trata_data($row[$Coluna['campo']]);
                                        else
                                            $valor = trata_html($row[$Coluna['campo']]);

                                        if ($valor == '')
                                            $valor = $Coluna['valor'];

                                        echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'#'.$idt_bloco.'" type="text" class="Texto" value="'.$valor.'" size="'.$Coluna['size'].'" maxlength="'.$Coluna['maxlength'].'" '.$Coluna['js'].' />';
                                        break;

                                    case 'Decimal':

                                        //echo 's ssssssssssssssp '.$Coluna['num_decimais'];

                                        echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'#'.$idt_bloco.'" type="text" class="Texto" style="text-align:right;" value="'.trata_html(format_decimal($row[$Coluna['campo']], $Coluna['num_decimais'])).'" size="'.$Coluna['size'].'" maxlength="'.$Coluna['maxlength'].'" '.$Coluna['js'].' />';
                                        break;

                                    case 'Senha':
                                        echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'#'.$idt_bloco.'" type="password" class="Texto" size="'.$Coluna['size'].'" maxlength="'.$Coluna['maxlength'].'" '.$Coluna['js'].' />';
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

                                        echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'#'.$idt_bloco.'" type="text" class="Texto" value="'.$valor.'" size="10" maxlength="10" '.$js.'>';

                                        if ($Coluna['datepicker'] != '') {
                                            echo '
                                             <script type="text/javascript">
                                             $(function() {
                                             $("#'.$Coluna['campo'].'").datepicker({
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

                                        echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'#'.$idt_bloco.'" type="text" class="Texto" value="'.$valor.'" size="16" maxlength="16" '.$js.'>';
                                        break;

                                    case 'Hidden':
                                        echo '<input type="hidden" id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'#'.$idt_bloco.'" value="'.trata_html($Coluna['valor']).'">';

                                        if ($Coluna['desc'] == '')
                                            echo '<img src="imagens/trans.gif" width="0" height="0" border="0">';
                                        else
                                            echo '<div class="TextoFixo" disabled="true">'.$Coluna['desc'].'</div>';
                                        break;

                                    case 'cmbVetor':
                                        criar_combo_vet($Coluna['vetor'], $Coluna['campo'].'#'.$idt_bloco, $row[$Coluna['campo']], $Coluna['linhafixa'], $Coluna['js']);
                                        break;

                                    case 'FixoVetor':
                                        if ($row[$Coluna['campo']] != '') {
                                            echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'" type="hidden" value="'.trata_html($row[$Coluna['campo']]).'">';
                                            echo '<div class="TextoFixo" disabled="true">'.$Coluna['vetor'][$row[$Coluna['campo']]].'</div>';
                                        } else if ($_GET[$Coluna['campo'].$Coluna['num_id']] != '') {
                                            echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'" type="hidden" value="'.trata_html($_GET[$Coluna['campo'].$Coluna['num_id']]).'">';
                                            echo '<div class="TextoFixo" disabled="true">'.$Coluna['vetor'][$_GET[$Coluna['campo'].$Coluna['num_id']]].'</div>';
                                        } else {
                                            echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'" type="hidden">';
                                            echo '<div class="TextoFixo" disabled="true">'.$Coluna['linhafixa'].'</div>';
                                        }
                                        break;

                                    case 'cmbBanco':
                                        if ($row[$Coluna['campo']] == '')
                                            $valor = $Coluna['vl_padrao'];
                                        else
                                            $valor = $row[$Coluna['campo']];

                                        criar_combo_rs(execsql($Coluna['sql']), $Coluna['campo'].'#'.$idt_bloco, $valor, $Coluna['linhafixa'], $Coluna['js'], $Coluna['style']);
                                        break;

                                    case 'FixoBanco':
                                        $id_fb = explode('.', $Coluna['id']);
                                        if (count($id_fb) > 1)
                                            $id_fb = $id_fb[1];
                                        else
                                            $id_fb = $id_fb[0];

                                        if ($_GET[$id_fb.$Coluna['num_id']] > 0) {
                                            $sql = 'select '.$Coluna['id'].', '.$Coluna['desc'].' from '.$Coluna['tabela_obj'].' where '.$Coluna['id'].' = '.aspa($_GET[$id_fb.$Coluna['num_id']]);

                                            $rs_fixo = execsql($sql);
                                            $row_fixo = $rs_fixo->data[0];

                                            echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'#'.$idt_bloco.'" type="hidden" value="'.trata_html($_GET[$id_fb.$Coluna['num_id']]).'">';
                                            echo '<div class="TextoFixo" disabled="true">';

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
                                            echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'" type="hidden">';
                                            echo '<div class="TextoFixo" disabled="true">'.$Coluna['linhafixa'].'</div>';
                                        }
                                        break;

                                    case 'TextArea':
                                        echo '<textarea id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'" class="TextArea" style="'.$Coluna['style'].'" onkeypress = "return Limita_Tamanho(this, '.$Coluna['maxlength'].')" onblur = "Trunca_Campo(this, '.$Coluna['maxlength'].')">'.$row[$Coluna['campo']].'</textarea>';
                                        break;

                                    case 'TextoFixo':
                                        if (tipo($Coluna['campo']) == 'date' || tipo($Coluna['campo']) == 'datetime' || tipo($Coluna['campo']) == 'timestamp')
                                            $valor = trata_data($row[$Coluna['campo']]);
                                        else
                                            $valor = trata_html($row[$Coluna['campo']]);

                                        echo '<input type="hidden" id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'#'.$idt_bloco.'" value="'.$valor.'">';

                                        if ($Coluna['size'] == '')
                                            $style = '';
                                        else
                                            $style = 'width: '.($Coluna['size'] * $TamFonte).'px;';

                                        echo '<div id="'.$Coluna['campo'].'_fix" class="TextoFixo" disabled="true"  style="'.$style.'">'.$valor.'</div>';
                                        break;

                                    case 'TextoFixoVL':
                                        if (tipo($Coluna['campo']) == 'date' || tipo($Coluna['campo']) == 'datetime' || tipo($Coluna['campo']) == 'timestamp')
                                            $valor = trata_data($row[$Coluna['campo']]);
                                        else
                                            $valor = trata_html($row[$Coluna['campo']]);

                                        if ($valor == '')
                                            $valor = $Coluna['valor'];

                                        if ($Coluna['color'] != '') {
                                            echo '<input type="hidden" id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'#'.$idt_bloco.'" value="'.$valor.'" cor_gsd="'.$Coluna['color'].'">';
                                        } else {
                                            echo '<input type="hidden" id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'" value="'.$valor.'" >';
                                        }
                                        if ($Coluna['size'] == '')
                                            $style = '';
                                        else
                                            $style = 'width: '.($Coluna['size'] * $TamFonte).'px;';

                                        if ($Coluna['color'] != '') {
                                            echo '<div id="'.$Coluna['campo'].'_fix" class="TextoFixo_gsd" disabled="true" disabled="true" style="'.$style.'">'.$valor.'</div>';
                                        } else {
                                            echo '<div id="'.$Coluna['campo'].'_fix" class="TextoFixo" disabled="true" disabled="true" style="'.$style.'">'.$valor.'</div>';
                                        }
                                        break;

                                    case 'AutoNum':
                                        $valor = trata_html($row[$Coluna['campo']]);

                                        echo '<input type="hidden" id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'#'.$idt_bloco.'" value="'.$valor.'">';

                                        if ($Coluna['mostra']) {
                                            if ($Coluna['size'] == '')
                                                $style = '';
                                            else
                                                $style = 'width: '.($Coluna['size'] * $TamFonte).'px;';

                                            echo '<div id="'.$Coluna['campo'].'_fix" class="TextoFixo" disabled="true" style="'.$style.'">'.$valor.'</div>';
                                        }
                                        break;

                                    case 'Checkbox':
                                        echo '<input type="checkbox" id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'#'.$idt_bloco.'" value="'.$Coluna['valor'].'"><label for="'.$Coluna['campo'].'" class="Tit_Campo_Obr">&nbsp;'.$Coluna['descricao'].'</label>';
                                        break;

                                    case 'Html':
                                        echo '<div class="conteudo_max">';
                                        Require_Once("fckeditor/fckeditor.php");
                                        $oFCKeditor = new FCKeditor($Coluna['campo']);
                                        $oFCKeditor->Value = $row[$Coluna['campo']];
                                        $oFCKeditor->Height = $Coluna['altura'];
                                        $oFCKeditor->Create();
                                        echo '</div>';
                                        break;

                                    case 'File':
                                        echo '<input id="'.$Coluna['campo'].'" name="'.$Coluna['campo'].'" type="file" class="Texto" size="'.$Coluna['size'].'" onkeydown = "return !(event.keyCode == 13)" />';
                                        echo '<br>';
                                        echo '<input type="hidden" name="'.$Coluna['campo'].'_ant" value="'.$row[$Coluna['campo']].'">';

                                        if (isset($row[$Coluna['campo']])) {
                                            $path = $dir_file.'/'.$tabela.'/';

                                            //echo ' nnnnnnn '.$path.$row[$Coluna['campo']];
                                            //exit();

                                            $arqpath = $dir_file.'/'.$tabela.'/'.$row[$Coluna['campo']];
                                            echo "
                                        <script type='text/javascript'>
                                            var arq_cat = '$arqpath';
                                            function mostra_arquivo()
                                            {
                                                //alert(arq_cat);
                                                var url = 'conteudo_popup.php?prefixo=inc&menu=cat&acao=inc&id=&arqrcat='+arq_cat;
                                                OpenWin('' + url, 'oas_imprimir_curriculo_interno', 800, $(window).height(), 50, ($(window).width() - 800) / 2);
                                                return false;
                                            }
                                        </script>";


                                            if ($Coluna['campo'] == 'arquivo_cat') {
                                                echo "<a href='#' style='text-decoration:none' onclick='return mostra_arquivo();'>";
                                                ImagemProd(100, null, $path, $row[$Coluna['campo']], $_GET['id'].'_'.$Coluna['campo'].'_');
                                                echo "</a>";
                                            } else {
                                                ImagemProd(100, null, $path, $row[$Coluna['campo']], $_GET['id'].'_'.$Coluna['campo'].'_');
                                            }
                                            if (!$Coluna['remove']) {
                                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                echo "<input type='checkbox' id='remover_".$Coluna['campo']."' name='remover_".$Coluna['campo']."' value='S'>";
                                                echo '<label for="remover_'.$Coluna['campo'].'" class="Tit_Campo">Remover </label>';
                                                echo "<br>";
                                            }
                                        }

                                        echo "
                                        <script type='text/javascript'>
                                            objFile[objFile.length] = '".$Coluna['campo']."';
                                            objFileMime[objFileMime.length] = vetMime.".$Coluna['grupo'].";
                                            objFileNome[objFileNome.length] = '".$Coluna['nome']."';
                                        </script>";
                                        break;

                                    default:
                                        echo '<img src="imagens/trans.gif" width="0" height="0" border="0">';
                                        break;
                                }

                                echo "</td>\n";
                            }
                        } else {
                            echo '<td style="border-bottom:5px solid #FFFFFF;" ><img src="imagens/trans.gif" width="15" height="0" border="0"></td>'."\n";
                        }
                    }

                    echo "</tr>\n";
                }

//            echo '</table>';
                echo '</div>';

                //  echo '</fieldset>'.nl();
            }

            echo '</div>'.nl();

            //  if ($tabHtml != '' && $idxGrd == $posTabFim) {
            //      echo '</div>'.nl();
            //  }
        }

//    bt_codigo(False);
//    echo '</form>';

        $primeiro = 1;
    }

    echo '</table>';

    bt_codigo(False);

    echo '</form>';
    echo '</div>'.nl();

    function bt_codigo($top) {
        global $menu, $acao, $botao_volta, $cont_arq, $target_js, $par_url;

        if ($top) {
            $id_bt = "";
            $div = 'margin-bottom: 5px; display: none;';
            $id_div = 'top';
        } else {
            $id_bt = "id='bt_voltar'";
            $div = '';
            $id_div = 'bottom';
        }

        echo '<div id="barra_bt_'.$id_div.'" class="Barra" style="'.$div.'">'.nl();
        echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"  >'.nl();
        echo '<tr><td>'.nl();

        if (acesso($menu, aspa($acao), false, false)) {
            switch ($acao) {
                case 'inc':
                    echo '
                    <input type="submit" name="btnAcao" class="Botao" value="Salvar" onClick="valida = \'S\'">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        		';
                    break;

                case 'alt':
                    echo '
                    <input type="submit" name="btnAcao" class="Botao" title="Clique aqui para alterar valores modificados" value="Alterar" onClick="valida = \'S\'">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                ';


//                echo '
//                    <input type="submit" name="btnAcao" class="Botao" value="Alterar" onClick="return envia_bloco();">
//                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
//                ';



                    break;

                case 'exc':
                    echo '
                    <input type="submit" name="btnAcao" class="Botao" value="Excluir" onClick="valida = \'N\'">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                ';
                    break;

                case 'enviar':
                    echo '
                    <input type="submit" name="btnAcao" class="Botao" value="Enviar" onClick="valida = \'S\'">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                ';
                    break;
            }
        }

        if ($botao_volta == '')
            echo "<input type='Button' name='btnAcao' $id_bt class='Botao' value='Voltar' onClick=\"$target_js.location = 'conteudo".$cont_arq.".php?prefixo=listar".getParametro($par_url)."'\">";
        else
            echo "<input type='Button' name='btnAcao' $id_bt class='Botao' title='Clique aqui para RETORNAR SEM ALTERAR valores modificados' value='Voltar' onClick=\"$botao_volta\">";

        echo '</td><td align="right" nowrap>'.nl();
        echo '( * ) campo obrigatório';
        echo '</td></tr>'.nl();
        echo '</table>'.nl();

        echo '</div>';
    }

    function codigo_lista() {
        global $Coluna, $row, $id;

        if ($Coluna['idt_cadastro'] == '')
            $tid = $id;
        else
            $tid = $Coluna['idt_cadastro'];
        ?>
        <script type="text/javascript">
            objLista[objLista.length] = new Array('<?php echo $Coluna['campo'] ?>', '<?php echo $Coluna['nm_lst_2'] ?>');
        </script>
        <input type="hidden" name="<?php echo $Coluna['campo'] ?>"  id="<?php echo $Coluna['campo'] ?>">
        <table align="center" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <font id="<?php echo $Coluna['campo'] ?>_lst_1" class="Tit_Campo"><?php echo $Coluna['des_lst_1'] ?></font><br>
                    <?php
                    $rs = execsql($Coluna['sql_lst_1']);
                    $tam_lst = $Coluna['num_linhas'] == '' ? $rs->rows : $Coluna['num_linhas'];
                    $tam_lst = $tam_lst < 6 ? 6 : $tam_lst;
                    $tam_lst = $tam_lst > 15 ? 15 : $tam_lst;

                    echo "<select style='width: ".$Coluna['larg_lst_1']."px;' name='".$Coluna['nm_lst_1']."' size='".$tam_lst."' multiple>\n";

                    ForEach ($rs->data as $linha) {
                        $sql = 'select * from '.$Coluna['tabela_relacionamento'].'
                            where '.$tid.' = '.$_GET['id'].'
                            and '.$rs->info['name'][0].' = ';

                        switch ($rs->info['type'][0]) {
                            case 'int':
                            case 'int4':
                            case 'long':
                                $sql .= null($linha[0]);
                                break;

                            case 'numeric':
                            case 'decimal':
                            case 'newdecimal':
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
                            echo "<option value='S".$linha[0]."'>";

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
                    <input type="Button" name="btnAcao" class="Botao" value="&nbsp;&gt;&gt;&gt;&nbsp;" onClick="inclui(document.frm.<?php echo$Coluna['nm_lst_1'] ?>, document.frm.<?php echo$Coluna['nm_lst_2'] ?>)">
                    <br>
                    <br>
                    <input type="Button" name="btnAcao" class="Botao" value="&nbsp;&lt;&lt;&lt;&nbsp;" onClick="exclui(document.frm.<?php echo$Coluna['nm_lst_1'] ?>, document.frm.<?php echo$Coluna['nm_lst_2'] ?>)">
                </td>
                <td align="center">
                    <font id="<?php echo $Coluna['campo'] ?>_lst_2" class="Tit_Campo<?php echo ($Coluna['valida'] ? '_Obr' : '') ?>"><?php echo $Coluna['des_lst_2'] ?><span class="asterisco">*</span></font><br>
                    <?php
                    $rs = execsql($Coluna['sql_lst_2']);

                    echo "<select id='".$Coluna['campo']."_lista' style='width: ".$Coluna['larg_lst_2']."px;' name='".$Coluna['nm_lst_2']."' size='".$tam_lst."' multiple>\n";

                    ForEach ($rs->data as $linha) {
                        if ($Coluna['exc_campo'] == '' || $Coluna['exc_tabela'] == '') {
                            $col = 1;
                            $exclui = 'S';
                        } else {
                            $col = 2;
                            $sql = 'select '.$Coluna['exc_campo'].' from '.$Coluna['exc_tabela'].'
                                where '.$Coluna['exc_campo'].' = '.$linha[1];
                            $rs_temp = execsql($sql);

                            if ($rs_temp->rows == 0)
                                $exclui = 'S';
                            else
                                $exclui = 'N';
                        }

                        echo "<option value='".$exclui.$linha[0]."'>";

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
        global $vlID, $id, $vetLista, $vetLstExtra, $vetTabExtra, $vetLstDel, $tabela;

        ForEach ($vetLista as $Lista) {
            $S = Array();
            $N = '';

            $sql = "select * from ".$Lista['tabela']." where 1 = 0";
            $rs = execsql($sql);
            $type = $rs->info['type'];

            if ($Lista['idt_cadastro'] == '')
                $tid = $id;
            else
                $tid = $Lista['idt_cadastro'];

            ForEach (explode(',', $_POST[$Lista['campo']]) as $chave) {
                switch (substr($chave, 0, 1)) {
                    case 'S':
                        $S[] .= substr($chave, 1);
                        break;
                    case 'N':
                        $N .= substr($chave, 1).',';
                        break;
                }
            }

            $N = substr($N, 0, strrpos($N, ','));

            //Delete
            $sql = 'delete from '.$Lista['tabela'].' where '.$tid.' = '.$vlID;

            if (is_array($vetLstDel[$Lista['campo']])) {
                ForEach ($vetLstDel[$Lista['campo']] as $tipoLst => $rowLst) {
                    $sql_del = '';
                    switch ($tipoLst) {
                        case 'C':
                            $sql_del = "select * from $tabela where $id = $vlID";
                            break;
                        case 'V':
                            break;
                    }

                    if ($sql_del != '') {
                        $rs = execsql($sql_del);
                        $row = $rs->data[0];
                    }

                    ForEach ($rowLst as $campoLst) {
                        $sql .= ' and '.$campoLst['destino'].' = ';

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
                $sql .= ' and '.$Lista['campo'].' not in ('.$N.')';

            $result = execsql($sql);

            ForEach ($S as $chave) {
                $sql_campo = '';
                $sql_valor = '';

                if (is_array($vetLstExtra[$Lista['campo']])) {
                    ForEach ($vetLstExtra[$Lista['campo']] as $tipoLst => $rowLst) {
                        $sql = '';
                        switch ($tipoLst) {
                            case 'C':
                                $sql = "select * from $tabela where $id = $vlID";
                                break;
                            case 'L':
                                $sql = "select * from ".$vetTabExtra[$Lista['campo']][0]." where ".$vetTabExtra[$Lista['campo']][1]." = $chave";
                                break;
                            case 'V':
                                break;
                        }

                        if ($sql != '') {
                            $rs = execsql($sql);
                            $row = $rs->data[0];
                        }

                        ForEach ($rowLst as $campoLst) {
                            $sql_campo .= $campoLst['destino'].', ';

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

                $sql = 'insert into '.$Lista['tabela'].' (
						'.$sql_campo.'
						'.$tid.',
						'.$Lista['campo'].'
				    ) values (
						'.$sql_valor.'
						'.$vlID.',
						'.$chave.'
				    )';
                $result = execsql($sql);
            }
        }
    }
    ?>
