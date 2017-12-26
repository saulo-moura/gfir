<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if ($_GET['o'] == 's') {
    Require_Once('../configuracao.php');
} else {
    if ($_REQUEST['cas'] == '') {
        $_REQUEST['cas'] = 'conteudo_abrir_sistema';
    }
    define('conteudo_abrir_sistema', $_REQUEST['cas']);
    Require_Once('configuracao.php');
}

switch ($_GET['tipo']) {
    case 'busca_cep':
        $cep = $_POST['val'];
        $cep = str_replace('.', '', $cep);
        $cep = str_replace('-', '', $cep);

        $sql = '';
        $sql .= ' select *';
        $sql .= ' from ' . db_pir_gec . 'base_cep';
        $sql .= ' where cep = ' . aspa($cep);
        $sql .= ' and cep_situacao = 1';
        $rs = execsql($sql);
        $row = $rs->data[0];

        $vet = Array();
        $vet['qtd'] = $rs->rows;
        $vet['ceptipo'] = $row['ceptipo'];

        switch ($row['ceptipo']) {
            case 'LOC':
                $row['logradouro'] = '';
                break;
        }

        $vet['codpais'] = rawurlencode($row['codpais']);
        $vet['pais_sigla'] = rawurlencode($row['pais_sigla']);
        $vet['pais_nome'] = rawurlencode($row['pais_nome']);

        $vet['codest'] = rawurlencode($row['codest']);
        $vet['uf_sigla'] = rawurlencode($row['uf_sigla']);
        $vet['uf_nome'] = rawurlencode($row['uf_nome']);

        $vet['codcid'] = rawurlencode($row['codcid']);
        $vet['cidade'] = rawurlencode($row['cidade']);

        $vet['codbairro'] = rawurlencode($row['codbairro']);
        $vet['bairro'] = rawurlencode($row['bairro']);

        $vet['logradouro'] = rawurlencode($row['logradouro']);
        $vet['complemento'] = rawurlencode($row['complemento']);

        echo json_encode($vet);
        break;

    case 'busca_cep_cidade':
        $sql = '';
        $sql .= " select distinct codcid, cidade";
        $sql .= ' from ' . db_pir_gec . 'base_cep';
        $sql .= ' where uf_sigla = ' . aspa($_GET['val']);
        $sql .= ' and cep_situacao = 1';
        $sql .= ' order by cidade';

        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'busca_cep_cidade_cod':
        $sql = '';
        $sql .= " select distinct codcid, cidade";
        $sql .= ' from ' . db_pir_gec . 'base_cep';
        $sql .= ' where codest = ' . aspa($_GET['val']);
        $sql .= ' and cep_situacao = 1';
        $sql .= ' order by cidade';

        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'busca_cep_estado':
        $sql = '';
        $sql .= " select distinct codest as cod, uf_nome";
        $sql .= ' from ' . db_pir_gec . 'base_cep';
        $sql .= ' where codpais = ' . aspa($_GET['val']);
        $sql .= ' and cep_situacao = 1';
        $sql .= ' order by uf_nome';

        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'busca_cep_bairro':
        $sql = '';
        $sql .= " select distinct codbairro, bairro";
        $sql .= ' from ' . db_pir_gec . 'base_cep';
        $sql .= ' where codcid = ' . aspa($_GET['val']);
        $sql .= ' and cep_situacao = 1';
        $sql .= ' order by bairro';

        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'busca_cep_logradouro':
        $sql = '';
        $sql .= " select distinct logradouro as cod, logradouro";
        $sql .= ' from ' . db_pir_gec . 'base_cep';
        $sql .= ' where codbairro = ' . aspa($_GET['val']);
        $sql .= ' and cep_situacao = 1';
        $sql .= ' order by logradouro';

        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'ListarCmbMulti':
        $vet = Array(
            'erro' => '',
            'html' => '',
        );

        try {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_trab'];

            parse_str($_POST['dados'], $dados);
            $dados = array_map('utf8_decode', $dados);
            $cod = md5(implode(', ', $dados));

            if ($_POST['chk'] == 'S') {
                $vetSel[$cod] = $dados;

                foreach ($_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['vet_retorno'] as $vetTmpCampo) {
                    if (!$vetTmpCampo['mostra']) {
                        unset($dados[$vetTmpCampo['campo']]);
                    }
                }

                $vet['html'] = rawurlencode('<li data-id="' . $cod . '"><img src="imagens/excluir_16.png" title="Remover da Seleção" />' . implode(' - ', $dados) . '</li>');
            } else {
                unset($vetSel[$cod]);
            }

            $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_trab'] = $vetSel;
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'ListarCmbMultiAtualiza':
        $vet = Array(
            'erro' => '',
            'html' => '',
            'tot' => '',
        );

        try {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_trab'];
            $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_final'] = $vetSel;

            foreach ($vetSel as $idx => $dados) {
                foreach ($_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['vet_retorno'] as $vetTmpCampo) {
                    if (!$vetTmpCampo['mostra']) {
                        unset($dados[$vetTmpCampo['campo']]);
                    }
                }

                $vet['html'] .= rawurlencode('<li data-id="' . $idx . '"><img src="imagens/excluir_16.png" title="Remover da Seleção" />' . implode(' - ', $dados) . '</li>');
            }

            if (count($vetSel) > 0) {
                $vet['tot'] = count($vetSel);
            }

            $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_trab'] = Array();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'ListarCmbMultiRemove':
        $vet = Array(
            'erro' => '',
            'tot' => '',
        );

        try {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_final'];

            unset($vetSel[$_POST['cod']]);

            if (count($vetSel) > 0) {
                $vet['tot'] = count($vetSel);
            }

            $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_final'] = $vetSel;
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'ListarCmbMultiRemoveAll':
        $vet = Array(
            'erro' => '',
        );

        try {
            $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_final'] = Array();
            $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_trab'] = Array();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'ListarCmbMultiCopia':
        $vet = Array(
            'erro' => '',
        );

        try {
            $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_trab'] = $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_final'];
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'noticia_sistema':
        $vet = Array(
            'erro' => '',
            'html' => '',
            'rows' => 0,
            'titulo' => '',
        );
		
		if ($_POST['local_apresentacao'] == '') {
			$_POST['local_apresentacao'] = "'T'";
		}

        try {
            $sql = "select  ";
            $sql .= "    idt,  ";
            $sql .= "    data,  ";
            $sql .= "    hora,  ";
            $sql .= "    descricao,  ";
            $sql .= "    detalhe,  ";
            $sql .= "    contato  ";
            $sql .= " from plu_noticia_sistema ";
            $sql .= " where ativa = 'S' and principal = 'S'";
            $sql .= ' and now() between dt_mostra_ini and dt_mostra_fim';
            $sql .= ' and local_apresentacao in (' . $_POST['local_apresentacao'] . ')';
            $sql .= ' order by principal desc, ativa desc, data desc, hora desc';
            $rs = execsql($sql, false);

            switch ($rs->rows) {
                case 0:
                    break;

                case 1:
                    $row = $rs->data[0];

                    $html = '';
                    $html .= '<div>';
                    $html .= 'Publicada em&nbsp;' . trata_data($row['data']) . '&nbsp;às&nbsp;' . $row['hora'] . '<br />';
                    $html .= 'Contato&nbsp;' . $row['contato'] . '<br /><br />';
                    $html .= trim($row['detalhe']);
                    $html .= '</div>';

                    $vet['html'] = rawurlencode($html);
                    $vet['titulo'] = rawurlencode($row['descricao']);
                    break;

                default:
                    $html = '';
                    $html .= '<div id="accordion">';

                    foreach ($rs->data as $row) {
                        $html .= '<h3>' . $row['descricao'] . '</h3>';
                        $html .= '<div>';
                        $html .= 'Publicada em&nbsp;' . trata_data($row['data']) . '&nbsp;às&nbsp;' . $row['hora'] . '<br />';
                        $html .= 'Contato&nbsp;' . $row['contato'] . '<br /><br />';
                        $html .= trim($row['detalhe']);
                        $html .= '</div>';
                    }

                    $html .= '</div>';

                    $vet['html'] = rawurlencode($html);
                    $vet['titulo'] = rawurlencode('Notificações');
                    break;
            }

            $vet['rows'] = $rs->rows;

            $_SESSION[CS]['g_popup'] = 'S';
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'listarconf':
        $Coluna = $_SESSION[CS]['objListarConf'][$_POST['session_cod']];
        $vetID = $_SESSION[CS]['objListarConf_vetID'][$_POST['session_cod']];
        
        extract($Coluna['vetParametros']['global']);

        if (is_string($Coluna['sql'])) {
            $rs_x = execsql($Coluna['sql']);
        } else {
            $rs_x = $Coluna['sql'];
        }

        if (function_exists($Coluna['vetParametros']['func_trata_rs'])) {
            $rs_x = $Coluna['vetParametros']['func_trata_rs']($rs_x);
        }

        $idCad = $Coluna['vetParametros']['idCadPer'];

        if ($idCad == '') {
            $idCad = $vetID[$Coluna['tabela']];
        }

        $retorno = criar_tabela_cadastro($idCad, true, $rs_x, $Coluna['vetCampo'], $Coluna['idCampo'], true, true, 'cadastro', $Coluna['menu'], $Coluna['vetParametros'], $_POST['session_cod'], $Coluna['titulo'], $Coluna['campo']);

        $vet = Array();
        $vet['html'] = rawurlencode($retorno);
        $vet['campo'] = $Coluna['campo'];
        $vet['menulocal'] = $Coluna['menu'];
        $vet['js_comcontrole'] = $Coluna['vetParametros']['comcontrole'];
        echo json_encode($vet);
        break;

    case 'filhoListarCmbMulti':
        $vet = Array(
            'erro' => '',
        );

        try {
            $session = $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']];
            $vetSel = $session['sel_trab'];
            $vet_retorno = $session['vet_retorno'];
            $sql_lst = $session['sql'];
            $vetListarCmbRegValido = $session['vetListarCmbRegValido'];
            $filhoCodListarCmbMulti = $session['filhoCodListarCmbMulti'];

            $sql = '';
            $sql .= ' select *';
            $sql .= ' from (' . $sql_lst . ') t';
            $sql .= ' where lower(' . $filhoCodListarCmbMulti . ') like lower(' . aspa($_POST['cod'], '', '%') . ')';

            foreach ($vetListarCmbRegValido as $campo => $value) {
                $sql .= ' and ' . $campo;

                if (is_array($value)) {
                    $value = array_map("aspa", $value);
                    $sql .= ' in (' . implode(', ', $value) . ')';
                } else {
                    $sql .= ' = ' . aspa($value);
                }
            }

            $rs = execsql($sql, false);

            foreach ($rs->data as $row) {
                $dados = Array();

                foreach ($vet_retorno as $vetTmpCampo) {
                    switch ($rs->info['type'][$vetTmpCampo['sql_campo']]) {
                        case 'date':
                        case 'datetime':
                        case 'timestamp':
                            $vlTD = trata_data($row[$vetTmpCampo['sql_campo']]);
                            break;

                        case 'numeric':
                        case 'decimal':
                        case 'newdecimal':
                        case 'double':
                            $vlTD = format_decimal($row[$vetTmpCampo['sql_campo']]);
                            break;

                        default:
                            $vlTD = $row[$vetTmpCampo['sql_campo']];
                            break;
                    }

                    $dados[$vetTmpCampo['campo']] = $vlTD;
                }

                $cod = md5(implode(', ', $dados));

                if ($_POST['chk'] == 'S') {
                    $vetSel[$cod] = $dados;

                    foreach ($vet_retorno as $vetTmpCampo) {
                        if (!$vetTmpCampo['mostra']) {
                            unset($dados[$vetTmpCampo['campo']]);
                        }
                    }
                } else {
                    unset($vetSel[$cod]);
                }
            }

            $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_trab'] = $vetSel;
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'filhoTotListarCmbMulti':
        $vet = Array(
            'erro' => '',
        );

        try {
            $session = $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']];
            $vetSel = $session['sel_trab'];
            $vet_retorno = $session['vet_retorno'];
            $sql_lst = $session['sql'];
            $vetListarCmbRegValido = $session['vetListarCmbRegValido'];

            $sql = '';
            $sql .= ' select *';
            $sql .= ' from (' . $sql_lst . ') t';
            $sql .= ' where 1 = 1';

            foreach ($vetListarCmbRegValido as $campo => $value) {
                $sql .= ' and ' . $campo;

                if (is_array($value)) {
                    $value = array_map("aspa", $value);
                    $sql .= ' in (' . implode(', ', $value) . ')';
                } else {
                    $sql .= ' = ' . aspa($value);
                }
            }

            $rs = execsql($sql, false);

            foreach ($rs->data as $row) {
                $dados = Array();

                foreach ($vet_retorno as $vetTmpCampo) {
                    switch ($rs->info['type'][$vetTmpCampo['sql_campo']]) {
                        case 'date':
                        case 'datetime':
                        case 'timestamp':
                            $vlTD = trata_data($row[$vetTmpCampo['sql_campo']]);
                            break;

                        case 'numeric':
                        case 'decimal':
                        case 'newdecimal':
                        case 'double':
                            $vlTD = format_decimal($row[$vetTmpCampo['sql_campo']]);
                            break;

                        default:
                            $vlTD = $row[$vetTmpCampo['sql_campo']];
                            break;
                    }

                    $dados[$vetTmpCampo['campo']] = $vlTD;
                }

                $cod = md5(implode(', ', $dados));

                $vetSel[$cod] = $dados;

                foreach ($vet_retorno as $vetTmpCampo) {
                    if (!$vetTmpCampo['mostra']) {
                        unset($dados[$vetTmpCampo['campo']]);
                    }
                }
            }

            $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_trab'] = $vetSel;
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'perfil_copia':
        $vet = Array(
            'erro' => '',
            'val' => '',
        );

        try {
            $vetDifu = Array();
            $vetDipe = Array();

            $sql = 'select id_funcao, id_direito, id_difu from plu_direito_funcao';
            $trs = execsql($sql, false);

            ForEach ($trs->data as $lin) {
                $vetDifu[$lin['id_funcao']][$lin['id_direito']] = $lin['id_difu'];
            }


            $sql = 'select id_difu from plu_direito_perfil where id_perfil = ' . $_POST['id_copia'];
            $trs = execsql($sql, false);

            ForEach ($trs->data as $lin) {
                $vetDipe[$lin['id_difu']] = 'ok';
            }

            $sql = 'select id_direito, nm_direito from plu_direito order by nm_direito';
            $rs_direito = execsql($sql, false);
            $tot_direito = $rs_direito->rows;

            $sql = 'select id_funcao, nm_funcao, cod_classificacao from plu_funcao order by cod_classificacao';
            $trs = execsql($sql, false);
            $tot_funcao = $trs->rows;

            $val = Array();
            $val[0] = 'N';
            $l = 0;

            ForEach ($trs->data as $func) {
                $nm_funcao = trata_aspa(alinha_nm_funcao($func['nm_funcao'], $func['cod_classificacao']));

                $l++;
                $c = 0;
                $val[l] = Array();

                ForEach ($rs_direito->data as $dir) {
                    $c++;
                    $id_difu = $vetDifu[$func['id_funcao']][$dir['id_direito']];

                    if ($id_difu != '') {
                        if ($vetDipe[$id_difu]) {
                            $t = "S";
                        } else {
                            $t = "N";
                        }

                        $val[$l][$c] = Array($id_difu, $t);
                    } else {
                        $val[$l][$c] = Array('', '');
                    }
                }
            }

            $vet['val'] = $val;
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'SelColuna':
        $vet = Array(
            'erro' => '',
        );

        try {
            $_SESSION[CS]['tmp']['chk_coluna'][$_POST['session_cod']] = $_POST['dados'];
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;
}