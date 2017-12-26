<?php
if (file_exists('funcao_atendimento.php')) {
    Require_Once('funcao_atendimento.php');
}

//
// funções para CBO
//
function ExecutaImportacao_CBO($idt_importacao) {
    // Carregar txt para memória
    $sql = 'select ';
    $sql .= '  cbo_i.*   ';
    $sql .= '  from cbo_importacao cbo_i ';
    $sql .= '  where cbo_i.idt=' . null($idt_importacao);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        return 2;
    }
    $arquivo = '';
    ForEach ($rs->data as $row) {

        $grande_grupo = $row['grande_grupo'];
        $familia = $row['familia'];
        $sub_grupo_principal = $row['sub_grupo_principal'];
        $sub_grupo = $row['sub_grupo'];
        $ocupacao = $row['ocupacao'];
        $sinonimo = $row['sinonimo'];
    }

    if ($grande_grupo != "") {
        $sql_d = 'delete from cbo_grande_grupo ';
        $result = execsql($sql_d);
    }
    if ($familia != "") {
        $sql_d = 'delete from cbo_familia ';
        $result = execsql($sql_d);
    }
    if ($sub_grupo_principal != "") {
        $sql_d = 'delete from cbo_sub_grupo_principal ';
        $result = execsql($sql_d);
    }
    if ($sub_grupo != "") {
        $sql_d = 'delete from cbo_sub_grupo ';
        $result = execsql($sql_d);
    }
    if ($ocupacao != "") {
        $sql_d = 'delete from cbo_ocupacao ';
        $result = execsql($sql_d);
    }
    if ($sinonimo != "") {
        $sql_d = 'delete from cbo_sinonimo ';
        $result = execsql($sql_d);
    }
    if ($grande_grupo != "") {
        $arquivow = basename($grande_grupo);
        $path = 'obj_file/cbo_importacao/' . $arquivow;
        if (!file_exists($path)) {
            echo ' erro de arquivo inexistente ' . $path;
            return $kokw;
        }
        $arquivo = file("$path");
        $vetlinha = Array();
        foreach ($arquivo as $texto) {
            $cpos = Array();
            $texto = $texto . ';';
            //$cpos = explode(';', $texto);
            $cpos = str_getcsv($texto, ';');
            $vetlinha[] = $cpos;
        }
        $klinn = 0;
        //
        set_time_limit(6000);
        //
        $total_geral = 0;
        $total_valor = 0;
        $quantidade_lancamento = 0;
        foreach ($vetlinha as $cpos) {
            $klinn = $klinn + 1;
            if ($klinn <= 2) {  // Linha de cabeçalho
                continue;
            }
            $linha = $cpos[0];
            $codigow = substr($linha, 0, 1);
            $descricaow = substr($linha, 7);

            $codigo = aspa($codigow);
            $descricao = aspa($descricaow);

            $sql_i = ' insert into cbo_grande_grupo ';
            $sql_i .= ' (  ';
            $sql_i .= ' codigo, ';
            $sql_i .= ' descricao ';
            $sql_i .= '  ) values ( ';
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }
    }

    if ($familia != "") {
        $arquivow = basename($familia);
        $path = 'obj_file/cbo_importacao/' . $arquivow;

        if (!file_exists($path)) {
            echo ' erro de arquivo inexistente ' . $path;
            return $kokw;
        }

        $arquivo = file("$path");
        $vetlinha = Array();
        foreach ($arquivo as $texto) {
            $cpos = Array();
            $texto = $texto . ';';
            //$cpos = explode(';', $texto);
            $cpos = str_getcsv($texto, ';');
            $vetlinha[] = $cpos;
        }
        $klinn = 0;
        set_time_limit(6000);
        $total_geral = 0;
        $total_valor = 0;
        $quantidade_lancamento = 0;
        foreach ($vetlinha as $cpos) {
            $klinn = $klinn + 1;
            if ($klinn <= 2) {  // Linha de cabeçalho
                continue;
            }
            $linha = $cpos[0];
            $codigow = substr($linha, 0, 4);
            $descricaow = substr($linha, 7);

            $codigo = aspa($codigow);
            $descricao = aspa($descricaow);

            $sql_i = ' insert into cbo_familia ';
            $sql_i .= ' (  ';
            $sql_i .= ' codigo, ';
            $sql_i .= ' descricao ';
            $sql_i .= '  ) values ( ';
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }
    }


    if ($sub_grupo_principal != "") {
        $arquivow = basename($sub_grupo_principal);
        $path = 'obj_file/cbo_importacao/' . $arquivow;
        if (!file_exists($path)) {
            echo ' erro de arquivo inexistente ' . $path;
            return $kokw;
        }
        $arquivo = file("$path");
        $vetlinha = Array();
        foreach ($arquivo as $texto) {
            $cpos = Array();
            $texto = $texto . ';';
            //$cpos = explode(';', $texto);
            $cpos = str_getcsv($texto, ';');
            $vetlinha[] = $cpos;
        }
        $klinn = 0;
        set_time_limit(6000);
        $total_geral = 0;
        $total_valor = 0;
        $quantidade_lancamento = 0;
        foreach ($vetlinha as $cpos) {
            $klinn = $klinn + 1;
            if ($klinn <= 2) {  // Linha de cabeçalho
                continue;
            }
            $linha = $cpos[0];
            $codigow = substr($linha, 0, 2);
            $descricaow = substr($linha, 7);
            $codigo = aspa($codigow);
            $descricao = aspa($descricaow);

            $sql_i = ' insert into cbo_sub_grupo_principal ';
            $sql_i .= ' (  ';
            $sql_i .= ' codigo, ';
            $sql_i .= ' descricao ';
            $sql_i .= '  ) values ( ';
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }
    }


    if ($sub_grupo != "") {
        $arquivow = basename($sub_grupo);
        $path = 'obj_file/cbo_importacao/' . $arquivow;

        if (!file_exists($path)) {
            echo ' erro de arquivo inexistente ' . $path;
            return $kokw;
        }

        $arquivo = file("$path");
        $vetlinha = Array();

        foreach ($arquivo as $texto) {
            $cpos = Array();
            $texto = $texto . ';';
            //$cpos = explode(';', $texto);
            $cpos = str_getcsv($texto, ';');
            $vetlinha[] = $cpos;
        }

        $klinn = 0;
        set_time_limit(6000);
        $total_geral = 0;
        $total_valor = 0;
        $quantidade_lancamento = 0;
        foreach ($vetlinha as $cpos) {
            $klinn = $klinn + 1;
            if ($klinn <= 2) {  // Linha de cabeçalho
                continue;
            }
            $linha = $cpos[0];
            $codigow = substr($linha, 0, 3);
            $descricaow = substr($linha, 7);

            $codigo = aspa($codigow);
            $descricao = aspa($descricaow);

            $sql_i = ' insert into cbo_sub_grupo ';
            $sql_i .= ' (  ';
            $sql_i .= ' codigo, ';
            $sql_i .= ' descricao ';
            $sql_i .= '  ) values ( ';
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }
    }

    if ($ocupacao != "") {
        $arquivow = basename($ocupacao);
        $path = 'obj_file/cbo_importacao/' . $arquivow;
        if (!file_exists($path)) {
            echo ' erro de arquivo inexistente ' . $path;
            return $kokw;
        }
        $arquivo = file("$path");
        $vetlinha = Array();
        foreach ($arquivo as $texto) {
            $cpos = Array();
            $texto = $texto . ';';
            //$cpos = explode(';', $texto);
            $cpos = str_getcsv($texto, ';');
            $vetlinha[] = $cpos;
        }
        $klinn = 0;
        set_time_limit(6000);
        $total_geral = 0;
        $total_valor = 0;
        $quantidade_lancamento = 0;
        foreach ($vetlinha as $cpos) {
            $klinn = $klinn + 1;
            if ($klinn <= 2) {  // Linha de cabeçalho
                continue;
            }
            $linha = $cpos[0];
            $codigow = substr($linha, 0, 6);
            $descricaow = substr($linha, 7);

            $codigo = aspa($codigow);
            $descricao = aspa($descricaow);

            $sql_i = ' insert into cbo_ocupacao ';
            $sql_i .= ' (  ';
            $sql_i .= ' codigo, ';
            $sql_i .= ' descricao ';
            $sql_i .= '  ) values ( ';
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }
    }

    if ($sinonimo != "") {
        $arquivow = basename($sinonimo);
        $path = 'obj_file/cbo_importacao/' . $arquivow;
        if (!file_exists($path)) {
            echo ' erro de arquivo inexistente ' . $path;
            return $kokw;
        }
        $arquivo = file("$path");
        $vetlinha = Array();
        foreach ($arquivo as $texto) {
            $cpos = Array();
            $texto = $texto . ';';
            //$cpos = explode(';', $texto);
            $cpos = str_getcsv($texto, ';');
            $vetlinha[] = $cpos;
        }
        $klinn = 0;
        set_time_limit(6000);
        $total_geral = 0;
        $total_valor = 0;
        $quantidade_lancamento = 0;
        foreach ($vetlinha as $cpos) {
            $klinn = $klinn + 1;
            if ($klinn <= 2) {  // Linha de cabeçalho
                continue;
            }
            $linha = $cpos[0];
            $codigow = substr($linha, 0, 6);
            $descricaow = substr($linha, 7);

            $codigo = aspa($codigow);
            $descricao = aspa($descricaow);

            $sql_i = ' insert into cbo_sinonimo ';
            $sql_i .= ' (  ';
            $sql_i .= ' codigo, ';
            $sql_i .= ' descricao ';
            $sql_i .= '  ) values ( ';
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }
    }
}

//
// funções para CNAE
//
function ExecutaImportacao_CNAE($idt_importacao) {
    // Carregar txt para memória
    $sql = 'select ';
    $sql .= '  cnae_i.*   ';
    $sql .= '  from cnae_importacao cnae_i ';
    $sql .= '  where cnae_i.idt=' . null($idt_importacao);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        return 2;
    }
    $arquivo = '';
    ForEach ($rs->data as $row) {
        $cnae = $row['cnae'];
    }
    if ($cnae != "") {
        $sql_d = 'delete from cnae ';
        $result = execsql($sql_d);
    }
    if ($cnae != "") {
        $arquivow = basename($cnae);
        $path = 'obj_file/cnae_importacao/' . $arquivow;
        if (!file_exists($path)) {
            echo ' erro de arquivo inexistente ' . $path;
            return $kokw;
        }
        $arquivo = file("$path");
        $vetlinha = Array();
        foreach ($arquivo as $texto) {
            $cpos = Array();
            $texto = $texto . ';';
            //$cpos = explode(';', $texto);
            $cpos = str_getcsv($texto, ';');
            $vetlinha[] = $cpos;
        }
        $klinn = 0;
        //
        set_time_limit(6000);
        //
        $total_geral = 0;
        $total_valor = 0;
        $quantidade_lancamento = 0;
        foreach ($vetlinha as $cpos) {
            $klinn = $klinn + 1;
            if ($klinn <= 3) {  // Linha de cabeçalho
                continue;
            }

            $secaow = $cpos[0];
            $divisaow = $cpos[1];
            $grupow = $cpos[2];
            $classew = $cpos[3];
            $subclassew = $cpos[4];
            $descricaow = $cpos[5];

            $tam = strlen($divisaow);
            if ($tam < 2) {
                if ($divisaow != "") {
                    $divisaow = '0' . $divisaow;
                }
            }

            if ($secaow != "") {
                if ($secao_antw != $secaow) {
                    $divisao_antw = "";
                    $grupo_antw = "";
                    $classe_antw = "";
                    $subclasse_antw = "";
                }
            }

            if ($divisaow != "") {
                if ($divisao_antw != $divisaow) {
                    $grupo_antw = "";
                    $classe_antw = "";
                    $subclasse_antw = "";
                }
            }

            if ($grupow != "") {
                if ($grupo_antw != $grupow) {
                    $classe_antw = "";
                    $subclasse_antw = "";
                }
            }

            if ($classew != "") {
                if ($classe_antw != $classew) {
                    $subclasse_antw = "";
                }
            }

            $codigow = "";
            if ($secaow != "") {
                $secao_antw = $secaow;
            }

            if ($divisaow != "") {
                $divisao_antw = $divisaow;
            }

            if ($grupow != "") {
                $grupo_antw = $grupow;
            }

            if ($classew != "") {
                $classe_antw = $classew;
            }

            if ($subclassew != "") {
                $subclasse_antw = $subclassew;
            }

            $separa = '#';
            if ($secao_antw != "") {
                $codigow = $secao_antw;
            }

            if ($divisao_antw != "") {
                $codigow .= $separa . $divisao_antw;
            }

            if ($grupo_antw != "") {
                $codigow .= $separa . $grupo_antw;
            }

            if ($classe_antw != "") {
                $codigow .= $separa . $classe_antw;
            }

            if ($subclasse_antw != "") {
                $codigow .= $separa . $subclasse_antw;
            }

            $codigo = aspa($codigow);
            $descricao = aspa($descricaow);
            $secao = aspa($secao_antw);
            $divisao = aspa($divisao_antw);
            $grupo = aspa($grupo_antw);
            $classe = aspa($classe_antw);
            $subclasse = aspa($subclasse_antw);
            $ativo = aspa('S');

            $sql_i = " insert into cnae ";
            $sql_i .= " (  ";
            $sql_i .= " codigo, ";
            $sql_i .= " descricao, ";
            $sql_i .= " ativo, ";
            $sql_i .= " secao, ";
            $sql_i .= " divisao, ";
            $sql_i .= " grupo, ";
            $sql_i .= " classe, ";
            $sql_i .= " subclasse ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao, ";
            $sql_i .= " $ativo, ";
            $sql_i .= " $secao, ";
            $sql_i .= " $divisao, ";
            $sql_i .= " $grupo, ";
            $sql_i .= " $classe, ";
            $sql_i .= " $subclasse ";
            $sql_i .= ") ";
            $result = execsql($sql_i);
        }
    }
}

//
// funções para CNAE
//
function ExecutaImportacao_NaturezaJuridica($idt_importacao) {
    // Carregar txt para memória
    $sql = 'select ';
    $sql .= '  gec_onji.*   ';
    $sql .= '  from gec_organizacao_natureza_juridica_importacao gec_onji ';
    $sql .= '  where gec_onji.idt=' . null($idt_importacao);
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        return 2;
    }

    $arquivo = '';
    ForEach ($rs->data as $row) {
        $arquivo = $row['arquivo'];
    }

    if ($arquivo != "") {
        $sql_d = 'delete from gec_organizacao_natureza_juridica ';
        $result = execsql($sql_d);
    }

    if ($arquivo != "") {
        $arquivow = basename($arquivo);
        $path = 'obj_file/gec_organizacao_natureza_juridica_importacao/' . $arquivow;
        if (!file_exists($path)) {
            echo ' erro de arquivo inexistente ' . $path;
            return $kokw;
        }
        $arquivo = file("$path");
        $vetlinha = Array();
        foreach ($arquivo as $texto) {
            $cpos = Array();
            $texto = $texto . ';';
            //$cpos = explode(';', $texto);
            $cpos = str_getcsv($texto, ';');
            $vetlinha[] = $cpos;
        }
        $klinn = 0;
        //
        set_time_limit(6000);
        //
        $total_geral = 0;
        $total_valor = 0;
        $quantidade_lancamento = 0;
        foreach ($vetlinha as $cpos) {
            $klinn = $klinn + 1;
            if ($klinn <= 1) {  // Linha de cabeçalho
                continue;
            }
            $codigow = $cpos[0];
            $descricaow = $cpos[1];
            $representantew = $cpos[2];

            $tam = strlen($codigow);
            if ($tam > 10) {
                // item maior
                $vetw = explode(".", $codigow);
                $codigow = $vetw[0];
                $descricaow = $vetw[1];
            } else {
                
            }

            $codigo = aspa($codigow);
            $descricao = aspa($descricaow);
            $representante = aspa($representantew);
            $ativo = aspa('S');

            $sql_i = " insert into gec_organizacao_natureza_juridica ";
            $sql_i .= " (  ";
            $sql_i .= " codigo, ";
            $sql_i .= " descricao, ";
            $sql_i .= " ativo, ";
            $sql_i .= " representante ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao, ";
            $sql_i .= " $ativo, ";
            $sql_i .= " $representante ";
            $sql_i .= ") ";
            $result = execsql($sql_i);
        }
    }
}

function CarregaEditaisAbertos() {
    $vetEdital = Array();
    $sql = 'select ';
    $sql .= '  gec_e.*,   ';
    $sql .= '  gec_e.idt       as gec_e_idt,   ';
    $sql .= '  gec_e.codigo    as gec_e_codigo,   ';
    $sql .= '  gec_e.descricao as gec_e_descricao,   ';
    $sql .= '  gec_e.objeto as gec_e_objeto,   ';
    $sql .= '  gec_et.codigo    as gec_et_codigo,   ';
    $sql .= '  gec_et.descricao as gec_et_descricao,   ';
    $sql .= '  gec_ep.idt       as gec_ep_idt,   ';
    $sql .= '  gec_ep.numero    as gec_ep_numero,   ';
    $sql .= '  gec_ep.titulo    as gec_ep_titulo,   ';
    $sql .= '  gec_epe.idt          as gec_epe_idt,   ';
    $sql .= '  gec_epe.data_inicio  as gec_epe_data_inicio,   ';
    $sql .= '  gec_epe.data_termino as gec_epe_data_termino   ';
    $sql .= '  from  gec_edital gec_e ';
    $sql .= '  inner join gec_edital_processo gec_ep        on gec_ep.idt_edital    = gec_e.idt';
    $sql .= '  inner join gec_edital_etapas gec_epe on gec_epe.idt_processo = gec_ep.idt';
    $sql .= '  inner join gec_edital_tipo gec_et on gec_et.idt = gec_e.idt_tipo';
    $sql .= '  inner join gec_edital_etapa gec_ee              on gec_ee.idt  = gec_epe.idt_etapa';
    $sql .= '  inner join gec_edital_situacao gec_es           on gec_es.idt  = gec_e.idt_situacao';
    $sql .= '  inner join gec_edital_processo_situacao gec_eps on gec_eps.idt = gec_ep.idt_situacao';
    $sql .= '  inner join gec_edital_etapas_situacao gec_ees   on gec_ees.idt = gec_epe.idt_situacao';
    $sql .= '  where ';  // tem que estar publicado para inscrição
    // $sql .= '      gec_e.publica  ='.aspa('S');
    $sql .= '       gec_es.codigo  =' . aspa('PB');
    $sql .= '  and gec_eps.codigo =' . aspa('PB');
    $sql .= '  and gec_ees.codigo =' . aspa('PB');
    $sql .= '  and gec_ee.codigo  =' . aspa('01'); // etapa é de inscrição
    $rs = execsql($sql);
    // p($sql);
    if ($rs->rows == 0) {
        
    } else {
        ForEach ($rs->data as $row) {
            $gec_e_idt = $row['gec_e_idt'];
            $gec_e_codigo = $row['gec_e_codigo'];
            $gec_e_descricao = $row['gec_e_descricao'];
            $gec_e_objeto = $row['gec_e_objeto'];
            $gec_et_codigo = $row['gec_et_codigo'];
            $gec_et_descricao = $row['gec_et_descricao'];
            $gec_ep_idt = $row['gec_ep_idt'];
            $gec_ep_numero = $row['gec_ep_numero'];
            $gec_ep_titulo = $row['gec_ep_titulo'];
            $gec_epe_idt = $row['gec_epe_idt'];
            $gec_epe_data_inicio = trata_data($row['gec_epe_data_inicio']);
            $gec_epe_data_termino = trata_data($row['gec_epe_data_termino']);
            $vetEdital[$gec_e_idt][$gec_ep_idt][$gec_epe_idt]['edital']['cod'] = $gec_e_codigo;
            $vetEdital[$gec_e_idt][$gec_ep_idt][$gec_epe_idt]['edital']['des'] = $gec_e_descricao;
            $vetEdital[$gec_e_idt][$gec_ep_idt][$gec_epe_idt]['edital']['tip'] = $gec_et_descricao;
            $vetEdital[$gec_e_idt][$gec_ep_idt][$gec_epe_idt]['edital']['pjf'] = $gec_et_codigo;
            $vetEdital[$gec_e_idt][$gec_ep_idt][$gec_epe_idt]['edital']['obj'] = $gec_e_objeto;
            $vetEdital[$gec_e_idt][$gec_ep_idt][$gec_epe_idt]['processo']['num'] = $gec_ep_numero;
            $vetEdital[$gec_e_idt][$gec_ep_idt][$gec_epe_idt]['processo']['des'] = $gec_ep_titulo;
            $vetEdital[$gec_e_idt][$gec_ep_idt][$gec_epe_idt]['etapa']['din'] = $gec_epe_data_inicio;
            $vetEdital[$gec_e_idt][$gec_ep_idt][$gec_epe_idt]['etapa']['dte'] = $gec_epe_data_termino;
        }
    }
    $_SESSION[CS]['g_editais_abertos'] = $vetEdital;
    return $vetEdital;
}

function GEC_parametros() {
    $vetGEC_parametros = Array();
    $sql = 'select ';
    $sql .= '  gec_pa.*   ';
    $sql .= '  from  ' . db_pir_gec . 'gec_parametros gec_pa ';
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        
    } else {
        ForEach ($rs->data as $row) {
            $codigo = $row['codigo'];
            $detalhe = $row['detalhe'];
            $vetGEC_parametros[$codigo] = $detalhe;
        }
    }
    return $vetGEC_parametros;
}

function email_aceite($vetEmail) {
    global $vetConf;

    $origem_nome = $vetEmail['origem_nome'];
    $origem_email = $vetEmail['origem_email'];
    $destino_nome = $vetEmail['destino_nome'];
    $destino_email = $vetEmail['destino_email'];
    $destino_mensagem = $vetEmail['destino_mensagem'];

    $msg = $destino_mensagem;

    Require_Once('PHPMailer/class.phpmailer.php');
    Require_Once('PHPMailer/class.smtp.php');

    $mail = new PHPMailer();

    $mail->IsSMTP();
    $mail->Host = $vetConf['host_smtp'];
    $mail->Port = $vetConf['port_smtp'];
    $mail->Username = $vetConf['login_smtp'];
    $mail->Password = $vetConf['senha_smtp'];
    $mail->SMTPAuth = !($vetConf['login_smtp'] == '' && $vetConf['senha_smtp'] == '');
    $mail->SMTPSecure = $vetConf['smtp_secure'];

    $mail->From = $origem_email;
    $mail->FromName = $origem_nome;

    $mail->Subject = "[$sigla_site] SEBRAE-BA :: COMUNICAÇÃO DE ACEITE " . " Edital: " . $numero_edital . '/' . $numero_processo;
    $mail->Body = $msg;
    $mail->AltBody = $msg;

    $mail->IsHTML(true);

    $mail->AddAddress($destino_email, $destino_nome);

    try {

        if ($mail->Send()) {
            echo "E-mail Enviado com sucesso!";
            $erro = '0';
        } else {
            $erro = '1';
            echo "Erro na transmissão.\\nTente outra vez!\\n\\n" . trata_aspa($mail->ErrorInfo);
        }
    } catch (Exception $e) {
        echo 'O Sistema encontrou problemas para enviar seu e-mail. ' . $e->getMessage();
    }
}

function SincronizaMetodologia() {
    //
    // Sincroniza Metodologia com o sistema Nacional SGC
    //
    beginTransaction();
    set_time_limit(90);
    $sql_a = ' update gec_metodologia set ';
    $sql_a .= ' publica  = ' . aspa('N') . '  ';
    $result = execsql($sql_a);
    //
    try {

        //
        $NA_SGC = new NA_SGC();
        $parametro = Array(
        );
        $info = $NA_SGC->SGC_Metodologia($parametro);

        $VetMetodologia = Array();
        $vetIDTMetodologia = Array();
        $numcodigo = 0;
        ForEach ($info->data as $row) {
            $nome = $row['NOME'];
            $foco = $row['FOCO'];
            $ativa = $row['ATIVA'];
            $idt_metodologia = $row['IDMETODOLOGIA'];

            $VetMetodologia[$idt_metodologia] = $row;

            $idt_natureza_servico = $foco + 1;

            $numcodigo = $numcodigo + 1;
            $codigo = ZeroEsq($numcodigo, 5);
            $codigow = aspa($codigo);

            $sql = 'select ';
            $sql .= '  gec_me.*   ';
            $sql .= '  from gec_metodologia gec_me ';
            $sql .= '  where gec_me.idt_metodologia = ' . null($idt_metodologia);
            $rs = execsql($sql);

            if ($rs->rows == 0) {    // Metodologia
                $nome = aspa($nome);
                $detalhe = aspa('');
                $foco = aspa($foco);
                $ativaw = 'N';
                if ($ativa == 1) {
                    $ativaw = 'S';
                }
                $ativo = aspa($ativaw);
                $idt_metodologia = null($idt_metodologia);
                $idt_natureza_servico = null($idt_natureza_servico);
                $publica = aspa("S");

                //
                $sql_i = " insert into gec_metodologia ";
                $sql_i .= " (  ";
                $sql_i .= " codigo, ";
                $sql_i .= " descricao, ";
                $sql_i .= " detalhe, ";
                $sql_i .= " ativo, ";
                $sql_i .= " idt_natureza_servico, ";
                $sql_i .= " idt_metodologia, ";
                $sql_i .= " publica ";
                $sql_i .= "  ) values ( ";
                $sql_i .= " $codigow, ";
                $sql_i .= " $nome, ";
                $sql_i .= " $detalhe, ";
                $sql_i .= " $ativo, ";
                $sql_i .= " $idt_natureza_servico, ";
                $sql_i .= " $idt_metodologia, ";
                $sql_i .= " $publica ";
                $sql_i .= ") ";
                $result = execsql($sql_i);
                $vetIDTMetodologia[$idt_metodologia] = lastInsertId();
            } else {
                $nome = aspa($nome);
                $foco = aspa($foco);
                $ativaw = 'N';
                if ($ativa == 1) {
                    $ativaw = 'S';
                }
                $ativo = aspa($ativaw);
                $idt_natureza_servico = null($idt_natureza_servico);
                $idt_metodologia = null($idt_metodologia);
                $publica = aspa("S");

                $idt_natureza_servico = $foco + 1;


                ForEach ($rs->data as $row) {
                    $idt = $row['idt'];
                }
                $sql_a = ' update gec_metodologia set ';
                $sql_a .= " codigo          = {$codigow} " . ", ";
                $sql_a .= " descricao       = {$nome} " . ", ";
                $sql_a .= " detalhe         = {$foco} " . ", ";
                $sql_a .= " ativo           = {$ativo} " . ", ";
                $sql_a .= " idt_natureza_servico = {$idt_natureza_servico} " . ", ";
                $sql_a .= " idt_metodologia = {$idt_metodologia} " . ", ";
                $sql_a .= " publica         = {$publica} " . " ";
                $sql_a .= ' where idt  = ' . null($idt) . '  ';
                $result = execsql($sql_a);
                $vetIDTMetodologia[$idt_metodologia] = $idt;
            }
        }
        commit();

//        p($VetEspecialidade);
    } catch (SoapFault $fault) {
        echo "Request :<br>", htmlentities($NA_SGC->__getLastRequest()), "<br>";
        echo "Response :<br>", htmlentities($NA_SGC->__getLastResponse()), "<br>";
        echo "RequestHeaders :<br>", htmlentities($NA_SGC->__getLastRequestHeaders()), "<br><br>";
        echo "ResponseHeaders :<br>", htmlentities($NA_SGC->__getLastResponseHeaders()), "<br>";
        p($fault);
        p($NA_SGC);
    }
    unset($NA_SGC);
}

function SincronizaAreasConhecimento() {

    beginTransaction();
    set_time_limit(90);
    $sql_a = ' update gec_area_conhecimento set ';
    $sql_a .= " codigo   = concat('1',codigo) , ";
    $sql_a .= ' publica  = ' . aspa('N') . '  ';
    $result = execsql($sql_a);
    //
    try {

        $vetIDTArea = Array();
        $vetCodigoArea = Array();
        $vetIDTSubArea = Array();
        $vetSubCodigoArea = Array();
        $vetIDTEspSubArea = Array();
        $vetEspSubCodigoArea = Array();
        $numCodArea = 0;
        $numCodSubArea = 0;
        $numCodEspSubArea = 0;
        $NA_SGC = new NA_SGC();
        $parametro = Array(
        );
        $info = $NA_SGC->SGC_Area($parametro);

        $VetArea = Array();
        ForEach ($info->data as $row) {
            $nome = $row['NOME'];
            $ativa = $row['ATIVA'];
            $idt_area = $row['ID'];
            $idt_ele = $row['ID'];
            $VetArea[$idt_area] = $row;

            $sql = 'select ';
            $sql .= '  gec_ac.*   ';
            $sql .= '  from gec_area_conhecimento gec_ac ';
            $sql .= '  where gec_ac.idt_area = ' . null($idt_area);
            $sql .= '    and nivel           = 1 ';
            $rs = execsql($sql);

            $numCodArea = $numCodArea + 1;
            $codigow = ZeroEsq($numCodArea, 2);
            $codigo = aspa($codigow);
            if ($rs->rows == 0) {   // Nova Área - Incluir
                //

                $descricao = aspa($nome);
                $ativaw = 'N';
                if ($ativa == 1) {
                    $ativaw = 'S';
                }
                $ativo = aspa($ativaw);
                $idt_area = null($idt_area);
                $idt_ele = null($idt_ele);
                $publica = aspa("S");
                $tipo = aspa("S");
                $nivel = 1;
                //
                $sql_i = " insert into gec_area_conhecimento ";
                $sql_i .= " (  ";
                $sql_i .= " codigo, ";
                $sql_i .= " descricao, ";
                $sql_i .= " ativo, ";
                $sql_i .= " idt_area, ";
                $sql_i .= " idt_ele, ";
                $sql_i .= " tipo, ";
                $sql_i .= " nivel, ";
                $sql_i .= " publica ";
                $sql_i .= "  ) values ( ";
                $sql_i .= " $codigo, ";
                $sql_i .= " $descricao, ";
                $sql_i .= " $ativo, ";
                $sql_i .= " $idt_area, ";
                $sql_i .= " $idt_ele, ";
                $sql_i .= " $tipo, ";
                $sql_i .= " $nivel, ";
                $sql_i .= " $publica ";
                $sql_i .= ") ";
                $result = execsql($sql_i);
                $vetIDTArea[$idt_area] = lastInsertId();
                $vetCodigoArea[$idt_area] = $codigow;
            } else {
                $descricao = aspa($nome);
                $ativaw = 'N';
                if ($ativa == 1) {
                    $ativaw = 'S';
                }
                $ativo = aspa($ativaw);
                $idt_area = null($idt_area);
                $idt_ele = null($idt_ele);
                $publica = aspa("S");
                $tipo = aspa("S");
                $nivel = 1;


                ForEach ($rs->data as $row) {
                    $idt = $row['idt'];
                }
                $sql_a = ' update gec_area_conhecimento set ';
                $sql_a .= " codigo     = {$codigo} " . ", ";
                $sql_a .= " descricao  = {$descricao} " . ", ";
                $sql_a .= " ativo      = {$ativo} " . ", ";
                $sql_a .= " tipo       = {$tipo} " . ", ";
                $sql_a .= " nivel      = {$nivel} " . ", ";
                $sql_a .= " publica    = {$publica} " . " ";
                $sql_a .= ' where idt  = ' . null($idt) . '  ';
                $result = execsql($sql_a);

                $vetIDTArea[$idt_area] = $idt;
                $vetCodigoArea[$idt_area] = $codigow;
            }
        }
        //
        // Subáreas
        //
        $parametro = Array(
        );
        $info = $NA_SGC->SGC_SubArea($parametro);
        $VetSubArea = Array();

        ForEach ($info->data as $row) {

            $nome = $row['NOME'];
            $ativa = $row['ATIVA'];
            $idt_area = $row['IDAREA'];
            $idt_subarea = $row['ID'];
            $idt_ele = $row['ID'];
            $VetSubArea[$idt_area][$idt_subarea] = $row;

            $codigo_ant = $vetCodigoArea[$idt_area] . '.';
            if ($idt_area == "") {
                echo "erro sub area sem area = $idt_ele, $nome, $ativa <br />";
            }

            $sql = 'select ';
            $sql .= '  gec_ac.*   ';
            $sql .= '  from gec_area_conhecimento gec_ac ';
            $sql .= '  where gec_ac.idt_subarea  = ' . null($idt_ele);
            $sql .= '    and gec_ac.idt_area     = ' . null($idt_area);
            $sql .= '    and nivel               = 2 ';
            $rs = execsql($sql);

            $numCodSubArea = $numCodSubArea + 1;
            $codigow = ZeroEsq($numCodSubArea, 3);
            $codigow = $codigo_ant . $codigow;

            $codigo = aspa($codigow);

            if ($rs->rows == 0) {   // Nova Área - Incluir
                //

                $descricao = aspa($nome);
                $ativaw = 'N';
                if ($ativa == 1) {
                    $ativaw = 'S';
                }
                $ativo = aspa($ativaw);
                $idt_area = null($idt_area);
                $idt_subarea = null($idt_subarea);
                $idt_ele = null($idt_ele);
                $publica = aspa("S");
                $nivel = 2;
                $tipo = aspa("S");

                //
                $sql_i = " insert into gec_area_conhecimento ";
                $sql_i .= " (  ";
                $sql_i .= " codigo, ";
                $sql_i .= " descricao, ";
                $sql_i .= " ativo, ";
                $sql_i .= " idt_area, ";
                $sql_i .= " idt_subarea, ";
                $sql_i .= " idt_ele, ";
                $sql_i .= " nivel, ";
                $sql_i .= " tipo, ";
                $sql_i .= " publica ";
                $sql_i .= "  ) values ( ";
                $sql_i .= " $codigo, ";
                $sql_i .= " $descricao, ";
                $sql_i .= " $ativo, ";
                $sql_i .= " $idt_area, ";
                $sql_i .= " $idt_subarea, ";
                $sql_i .= " $idt_ele, ";
                $sql_i .= " $nivel, ";
                $sql_i .= " $tipo, ";
                $sql_i .= " $publica ";
                $sql_i .= ") ";
                $result = execsql($sql_i);
                $vetIDTSubArea[$idt_area][$idt_subarea] = lastInsertId();
                $vetCodigoSubArea[$idt_area][$idt_subarea] = $codigow;
            } else {
                $descricao = aspa($nome);
                $ativaw = 'N';
                if ($ativa == 1) {
                    $ativaw = 'S';
                }
                $ativo = aspa($ativaw);
                $idt_area = null($idt_area);
                $idt_subarea = null($idt_subarea);
                $idt_ele = null($idt_ele);
                $publica = aspa("S");
                $nivel = 2;
                $tipo = aspa("S");


                ForEach ($rs->data as $row) {
                    $idt = $row['idt'];
                }
                $sql_a = ' update gec_area_conhecimento set ';
                $sql_a .= " codigo     = {$codigo} " . ", ";
                $sql_a .= " descricao  = {$descricao} " . ", ";
                $sql_a .= " ativo      = {$ativo} " . ", ";
                $sql_a .= " idt_area   = {$idt_area} " . ", ";
                $sql_a .= " nivel      = {$nivel} " . ", ";
                $sql_a .= " tipo       = {$tipo} " . ", ";
                $sql_a .= " publica    = {$publica} " . " ";
                $sql_a .= ' where idt  = ' . null($idt) . '  ';
                $result = execsql($sql_a);

                $vetIDTSubArea[$idt_area][$idt_subarea] = $idt;
                $vetCodigoSubArea[$idt_area][$idt_subarea] = $codigow;
            }
        }
        // passar parâmetros
        $parametro = Array(
        );
        $info = $NA_SGC->SGC_Especialidade($parametro);
        // receber resultado
        ForEach ($info->data as $row) {
            $nome = $row['NOME'];
            $ativa = $row['ATIVA'];
            $idt_area = $row['IDAREA'];
            $idt_subarea = $row['IDSUBAREA'];
            $idt_especialidade = $row['ID'];
            $idt_ele = $row['ID'];

            $VetEspecialidade[$idt_area][$idt_subarea][$idt_especialidade] = $row;

            $codigo_ant = $vetCodigoSubArea[$idt_area][$idt_subarea] . '.';

            $sql = 'select ';
            $sql .= '  gec_ac.*   ';
            $sql .= '  from gec_area_conhecimento gec_ac ';
            $sql .= '  where gec_ac.idt_especialidade  = ' . null($idt_ele);
            $sql .= '    and gec_ac.idt_area           = ' . null($idt_area);
            $sql .= '    and gec_ac.idt_subarea        = ' . null($idt_subarea);
            $sql .= '    and nivel                     = 3 ';
            $rs = execsql($sql);

            $numCodEspSubArea = $numCodEspSubArea + 1;
            $codigow = ZeroEsq($numCodEspSubArea, 3);
            $codigow = $codigo_ant . $codigow;
            $codigo = aspa($codigow);

            if ($rs->rows == 0) {    // Nova Especialidade - Incluir
                //

                $descricao = aspa($nome);
                $ativaw = 'N';
                if ($ativa == 1) {
                    $ativaw = 'S';
                }
                $ativo = aspa($ativaw);
                $idt_area = null($idt_area);
                $idt_subarea = null($idt_subarea);
                $idt_especialidade = null($idt_especialidade);
                $idt_ele = null($idt_ele);
                $nivel = 3;
                $publica = aspa("S");
                $tipo = aspa("A");
                //
                $sql_i = " insert into gec_area_conhecimento ";
                $sql_i .= " (  ";
                $sql_i .= " codigo, ";
                $sql_i .= " descricao, ";
                $sql_i .= " ativo, ";
                $sql_i .= " idt_area, ";
                $sql_i .= " idt_subarea, ";
                $sql_i .= " idt_especialidade, ";
                $sql_i .= " idt_ele, ";
                $sql_i .= " nivel, ";
                $sql_i .= " tipo, ";
                $sql_i .= " publica ";
                $sql_i .= "  ) values ( ";
                $sql_i .= " $codigo, ";
                $sql_i .= " $descricao, ";
                $sql_i .= " $ativo, ";
                $sql_i .= " $idt_area, ";
                $sql_i .= " $idt_subarea, ";
                $sql_i .= " $idt_especialidade, ";
                $sql_i .= " $idt_ele, ";
                $sql_i .= " $nivel, ";
                $sql_i .= " $tipo, ";
                $sql_i .= " $publica ";
                $sql_i .= ") ";
                $result = execsql($sql_i);
                $vetIDTEspSubArea[$idt_area][$idt_subarea][$idt_especialidade] = lastInsertId();
                $vetCodigoEspSubArea[$idt_area][$idt_subarea][$idt_especialidade] = $codigow;
            } else {
                $descricao = aspa($nome);
                $ativaw = 'N';
                if ($ativa == 1) {
                    $ativaw = 'S';
                }
                $ativo = aspa($ativaw);
                $idt_area = null($idt_area);
                $idt_subarea = null($idt_subarea);
                $idt_especialidade = null($idt_especialidade);
                $idt_ele = null($idt_ele);
                $publica = aspa("S");
                $nivel = 3;
                $tipo = aspa("A");


                ForEach ($rs->data as $row) {
                    $idt = $row['idt'];
                }
                $sql_a = ' update gec_area_conhecimento set ';
                $sql_a .= " codigo     = {$codigo} " . ", ";
                $sql_a .= " descricao  = {$descricao} " . ", ";
                $sql_a .= " ativo      = {$ativo} " . ", ";
                $sql_a .= " idt_area   = {$idt_area} " . ", ";
                $sql_a .= " idt_subarea= {$idt_subarea} " . ", ";
                $sql_a .= " nivel      = {$nivel} " . ", ";
                $sql_a .= " tipo       = {$tipo} " . ", ";
                $sql_a .= " publica    = {$publica} " . " ";

                $sql_a .= ' where idt  = ' . null($idt) . '  ';
                $result = execsql($sql_a);

                $vetIDTEspSubArea[$idt_area][$idt_subarea][$idt_especialidade] = $idt;
                $vetCodigoEspSubArea[$idt_area][$idt_subarea][$idt_especialidade] = $codigow;
            }
        }
        //
        // ajustar questão de analítica e sintética
        // pode ter sub-area sem especialidade
        //
       $sql = 'select ';
        $sql .= '  gec_ac.*   ';
        $sql .= '  from gec_area_conhecimento gec_ac ';
        $sql .= '  where  ';
        $sql .= '     nivel = 2 ';
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $idt = $row['idt'];
            $idt_area = $row['idt_area'];
            $idt_subarea = $row['idt_subarea'];

            $idt_especialidade = $vetIDTEspSubArea[$idt_area][$idt_subarea];
            //p($idt_especialidade);
            if (!is_array($idt_especialidade)) {
                $sql_a = ' update gec_area_conhecimento set ';
                $sql_a .= " tipo       = 'A' " . " ";
                $sql_a .= ' where idt  = ' . null($idt) . '  ';
                $result = execsql($sql_a);
            }
        }

        commit();


        //p($VetArea);
        //p($vetIDTArea);
        //p($vetCodigoArea);
//        p($VetSubArea);
//        p($VetEspecialidade);
    } catch (SoapFault $fault) {
        echo "Request :<br>", htmlentities($NA_SGC->__getLastRequest()), "<br>";
        echo "Response :<br>", htmlentities($NA_SGC->__getLastResponse()), "<br>";
        echo "RequestHeaders :<br>", htmlentities($NA_SGC->__getLastRequestHeaders()), "<br><br>";
        echo "ResponseHeaders :<br>", htmlentities($NA_SGC->__getLastResponseHeaders()), "<br>";
        p($fault);
        p($NA_SGC);
    }
    unset($NA_SGC);
}

//---TOM-- ----------------------------------------------------------------------

function GRC_CopiaProduto($idt_produto, $idt_produto_programar) {
    // Função para copiar o produtos e todos os registros de arquivos relacionados
    // quando da inclusão de uma programação de produto
    // Parametros:
    // idt_produto - Idt do produto que estamos incluindo para programação
    // idt_produto_programar - Idt da programação do produto que sera gravada em cada registro
    // copiado para termos a associação da programação com o produto.
    // 01 - Acessa o Produto (para acessar o registro de produto que será copiado...
    p('To Dentro.....................');

    $sql = ' select * from ' . db_pir_grc . 'grc_produto where idt = ' . $idt_produto;

    $rs = execsql($sql);

// Obtem os campos que serão clonados:

    ForEach ($rs->data as $row) {
        $codigo = aspa($row['codigo']);
        $descricao = aspa($row['descricao']);
        $ativo = aspa($row['ativo']);
        $conceito_interno = aspa($row['conceito_interno']);
        $recomendacao_interna = aspa($row['recomendacao_interna']);
        $idt_produto_familia = null($row['idt_produto_familia']);
        $idt_produto_canal_midia = null($row['idt_produto_canal_midia']);
        $idt_produto_abrangencia = null($row['idt_produto_abrangencia']);
        $idt_produto_dimensao_complexidade = null($row['idt_produto_dimensao_complexidade']);
        $idt_produto_area_competencia = null($row['idt_produto_area_competencia']);
        $idt_produto_area_conhecimento = null($row['idt_produto_area_conhecimento']);
        $idt_produto_tag_pesquisa = null($row['idt_produto_tag_pesquisa']);
        $idt_produto_modelo_certificado = null($row['idt_produto_modelo_certificado']);
        $idt_produto_tipo = null($row['idt_produto_tipo']);
        $idt_produto_situacao = null($row['idt_produto_situacao']);
        $idt_produto_tipo_autor = null($row['idt_produto_tipo_autor']);
        $idt_produto_maturidade = null($row['idt_produto_maturidade']);
        $idt_foco_tematico = null($row['idt_foco_tematico']);
        $idt_tema_subtema = null($row['idt_tema_subtema']);
        $idt_publico_alvo = null($row['idt_publico_alvo']);
        $idt_produto_programar = null($idt_produto_programar);
        $idt_produto_copiado = null($idt_produto);

        $sql_i = " insert into grc_produto (
  codigo,
  descricao,
  ativo,
  conceito_interno,
  recomendacao_interna,
  idt_produto_familia,
  idt_produto_canal_midia,
  idt_produto_abrangencia,
  idt_produto_dimensao_complexidade,
  idt_produto_area_competencia,
  idt_produto_area_conhecimento,
  idt_produto_tag_pesquisa,
  idt_produto_modelo_certificado,
  idt_produto_tipo,
  idt_produto_situacao,
  idt_produto_tipo_autor,
  idt_produto_maturidade,
  idt_foco_tematico,
  idt_tema_subtema,
  idt_publico_alvo,
  idt_produto_programar,
  idt_produto_copiado) VALUES ( ";
        $sql_i .= " $codigo,";
        $sql_i .= " $descricao,";
        $sql_i .= " $ativo,";
        $sql_i .= " $conceito_interno,";
        $sql_i .= " $recomendacao_interna,";
        $sql_i .= " $idt_produto_familia,";
        $sql_i .= " $idt_produto_canal_midia, ";
        $sql_i .= " $idt_produto_abrangencia, ";
        $sql_i .= " $idt_produto_dimensao_complexidade, ";
        $sql_i .= " $idt_produto_area_competencia, ";
        $sql_i .= " $idt_produto_area_conhecimento, ";
        $sql_i .= " $idt_produto_tag_pesquisa, ";
        $sql_i .= " $idt_produto_modelo_certificado, ";
        $sql_i .= " $idt_produto_tipo, ";
        $sql_i .= " $idt_produto_situacao, ";
        $sql_i .= " $idt_produto_tipo_autor, ";
        $sql_i .= " $idt_produto_maturidade, ";
        $sql_i .= " $idt_foco_tematico, ";
        $sql_i .= " $idt_tema_subtema, ";
        $sql_i .= " $idt_publico_alvo, ";
        $sql_i .= " $idt_produto_programar, ";
        $sql_i .= " $idt_produto_copiado ";
        $sql_i .= ") ";

//  beginTransaction();
//  set_time_limit(90);

        $result = execsql($sql_i);

//  commit;
    }
}

function AtivaSituacaoProduto($idt_produto, $idt_situacao) {
    $kokw = 0;

    // echo " idt_produto = $idt_produto";

    $sql = "select * from grc_produto_situacao ";
    $sql .= " where idt = " . $idt_situacao;
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $idt_destino = $row['idt'];
        $codigo_destino = $row['codigo'];
        $descricao_destino = $row['descricao'];
    }

    $sql = "select grc_ps.* from grc_produto grc_p ";
    $sql .= " inner join grc_produto_situacao grc_ps on grc_ps.idt = grc_p.idt_produto_situacao";
    $sql .= " where grc_p.idt = " . null($idt_produto);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $idt_origem = $row['idt'];
        $codigo_origem = $row['codigo'];
        $descricao_origem = $row['descricao'];
    }


    beginTransaction();
    set_time_limit(90);

    $sql_a = ' update grc_produto set ';
    $sql_a .= ' idt_produto_situacao  = ' . null($idt_situacao) . '  ';
    $sql_a .= ' where idt  = ' . null($idt_produto) . '  ';
    $result = execsql($sql_a);
    //
    // registrara Ocorrência 
    //

    $detalhew = "";
    $detalhew .= " Situação Atual  : " . $codigo_origem . " - " . $descricao_origem . "<br />";
    $detalhew .= " Modificada para : " . $codigo_destino . " - " . $descricao_destino . "<br />";
    $detalhew .= " Responsável pela Modificação : <br /> ";
    $detalhew .= " USUÁRIO: " . $_SESSION[CS]['g_login'] . "<br /> ";
    $detalhew .= " NOME COMPLETO: " . $_SESSION[CS]['g_nome_completo'] . "<br /> ";
    $detalhew .= " EMAIL: " . $_SESSION[CS]['g_email'] . "<br /> ";

    $codigo = aspa("");
    $descricao = " Modificada Situação para: " . $codigo_destino . " - " . $descricao_destino;

    $descricao = aspa($descricao);
    $ativo = aspa('S');
    $flag = aspa('S');
    $detalhe = aspa($detalhew);
    $dataw = date('d/m/Y H:i:s');
    $data = aspa(trata_data($dataw));
    $idt_responsavel = $_SESSION[CS]['g_id_usuario'];

    $sql_i = ' insert into grc_produto_ocorrencia ';
    $sql_i .= ' (  ';
    $sql_i .= " idt_produto, ";
    $sql_i .= " codigo, ";
    $sql_i .= " descricao, ";
    $sql_i .= " ativo, ";
    $sql_i .= " flag, ";
    $sql_i .= " detalhe, ";
    $sql_i .= " data, ";
    $sql_i .= " idt_responsavel ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $idt_produto, ";
    $sql_i .= " $codigo, ";
    $sql_i .= " $descricao, ";
    $sql_i .= " $ativo, ";
    $sql_i .= " $flag, ";
    $sql_i .= " $detalhe, ";
    $sql_i .= " $data, ";
    $sql_i .= " $idt_responsavel ";
    $sql_i .= ') ';
    $result = execsql($sql_i);

    commit();

    $kokw = 1;
    return $kokw;
}

function ExcluiProduto($idt_produto) {
    $idt_produto_evento = 0;
    $sql = "select grc_p.idt_produto_evento, grc_ps.codigo, grc_ps.situacao_etapa from grc_produto grc_p ";
    $sql .= " inner join grc_produto_situacao grc_ps on grc_ps.idt = grc_p.idt_produto_situacao ";
    $sql .= " where grc_p.idt = " . null($idt_produto);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $etapa = $row['situacao_etapa'];
        $idt_produto_evento = $row['idt_produto_evento'];
    }

    if ($etapa == 'D' or $idt_produto_evento > 0) {
        $sql_d = 'delete from grc_produto_produto ';
        $sql_d .= ' where idt_produto = ' . null($idt_produto);
        $result = execsql($sql_d);

        $sql_d = 'delete from grc_produto_arquivo_associado ';
        $sql_d .= ' where idt_produto = ' . null($idt_produto);
        $result = execsql($sql_d);

        $sql_d = 'delete from grc_produto_realizador ';
        $sql_d .= ' where idt_produto = ' . null($idt_produto);
        $result = execsql($sql_d);

        $sql_d = 'delete from grc_produto_area_conhecimento ';
        $sql_d .= ' where idt_produto = ' . null($idt_produto);
        $result = execsql($sql_d);

        $sql_d = 'delete from grc_produto_ocorrencia ';
        $sql_d .= ' where idt_produto = ' . null($idt_produto);
        $result = execsql($sql_d);

        $sql_d = 'delete from grc_produto_versao ';
        $sql_d .= ' where idt_produto = ' . null($idt_produto);
        $result = execsql($sql_d);

        $sql_d = 'delete from grc_produto_insumo ';
        $sql_d .= ' where idt_produto = ' . null($idt_produto);
        $result = execsql($sql_d);

        $sql_d = 'delete from grc_produto_conteudo_programatico ';
        $sql_d .= ' where idt_produto = ' . null($idt_produto);
        $result = execsql($sql_d);

        $sql_d = 'delete from grc_produto_unidade_regional ';
        $sql_d .= ' where idt_produto = ' . null($idt_produto);
        $result = execsql($sql_d);

        $sql_d = 'delete from grc_produto ';
        $sql_d .= ' where idt = ' . null($idt_produto);
        $result = execsql($sql_d);
    }
}

function AtivaCopiaProduto($idt_produto, $idt_evento, &$idt_produto_novo) {
    $kokw = 0;
    if ($idt_evento == 0) {
        beginTransaction();
    }
    set_time_limit(90);

    // Copia o Produto
    $idt_produto_novo = copiar_produto($idt_produto);

//    $idt_produto_novo = CopiaProduto($idt_produto, $idt_evento);
//    CopiaProdutoInsumo($idt_produto, $idt_produto_novo);
//    CopiaProdutoRealizador($idt_produto, $idt_produto_novo);
//    CopiaProdutoConteudoProgramatico($idt_produto, $idt_produto_novo);
//    CopiaProdutoProduto($idt_produto, $idt_produto_novo);
//    CopiaProdutoArquivoAssociado($idt_produto, $idt_produto_novo);
//    CopiaProdutoAreaConhecimento($idt_produto, $idt_produto_novo);
//    CopiaProdutoEntrega($idt_produto, $idt_produto_novo);
//    CopiaProdutoUnidadeRegional($idt_produto, $idt_produto_novo);
//    CopiaProdutoVersao($idt_produto, $idt_produto_novo);
    // Item Profissionais
    //
    // Registrara Ocorrência 
    //
    $sql = "";
    $sql .= " select grc_p.codigo,grc_p.copia, grc_p.descricao";
    $sql .= " from grc_produto grc_p";
    $sql .= " where grc_p.idt = " . null($idt_produto);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo_origem = aspa($row['codigo']);
        $descricao_origem = aspa($row['descricao']);
        $copia_origem = aspa($row['copia']);
    }

    $sql = "";
    $sql .= " select grc_p.codigo,grc_p.copia, grc_p.descricao";
    $sql .= " from grc_produto grc_p ";
    $sql .= " where grc_p.idt = " . null($idt_produto_novo);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo_destino = aspa($row['codigo']);
        $descricao_destino = aspa($row['descricao']);
        $copia_destino = aspa($row['copia']);
    }

    $detalhew = "";
    if ($idt_evento > 0) {
        $sql = "";
        $sql .= " select grc_e.codigo, grc_e.copia, grc_e.descricao";
        $sql .= " from grc_evento grc_e ";
        $sql .= " where grc_e.idt = " . null($idt_evento);
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $codigo_evento = $row['codigo'];
            $descricao_evento = $row['descricao'];
            $copia_evento = $row['copia'];
        }

        $detalhew .= "Produto Vinculado ao evento : " . $codigo_evento . '/' . $copia_evento . " - " . $descricao_evento . "<br />";
    }

    $detalhew .= " Cópia do produto : " . $codigo_origem . '/' . $copia_origem . " - " . $descricao_origem . "<br />";
    $detalhew .= " para : " . $codigo_destino . '/' . $copia_destino . " - " . $descricao_destino . "<br />";

    $detalhew .= " Responsável pela Modificação : <br /> ";
    $detalhew .= " USUÁRIO: " . $_SESSION[CS]['g_login'] . "<br /> ";
    $detalhew .= " NOME COMPLETO: " . $_SESSION[CS]['g_nome_completo'] . "<br /> ";
    $detalhew .= " EMAIL: " . $_SESSION[CS]['g_email'] . "<br /> ";

    $codigo = aspa("");
    $descricao = " Produto Copiado para: " . $codigo_destino . '/' . $copia_destino . " - " . $descricao_destino . "<br />";

    $descricao = aspa($descricao);
    $ativo = aspa('S');
    $flag = aspa('S');
    $detalhe = aspa($detalhew);
    $dataw = date('d/m/Y H:i:s');
    $data = aspa(trata_data($dataw));
    $idt_responsavel = $_SESSION[CS]['g_id_usuario'];

    $sql_i = ' insert into grc_produto_ocorrencia ';
    $sql_i .= ' (  ';
    $sql_i .= " idt_produto, ";
    $sql_i .= " codigo, ";
    $sql_i .= " descricao, ";
    $sql_i .= " ativo, ";
    $sql_i .= " flag, ";
    $sql_i .= " detalhe, ";
    $sql_i .= " data, ";
    $sql_i .= " idt_responsavel ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $idt_produto_novo, ";
    $sql_i .= " $codigo, ";
    $sql_i .= " $descricao, ";
    $sql_i .= " $ativo, ";
    $sql_i .= " $flag, ";
    $sql_i .= " $detalhe, ";
    $sql_i .= " $data, ";
    $sql_i .= " $idt_responsavel ";
    $sql_i .= ') ';
    $result = execsql($sql_i);

    if ($idt_evento == 0) {
        commit();
    }
    $kokw = 1;
    return $kokw;
}

// Copiar Produto 
function CopiaProduto($idt_produto, $idt_evento) {
    $idt_produto_novo = 0;
    //
    $sql = "select grc_p.* from grc_produto grc_p ";
    $sql .= " where grc_p.idt = " . null($idt_produto);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = aspa($row['codigo']);
        $descricao = aspa($row['descricao']);
        $ativo = aspa($row['ativo']);
        $conceito_interno = aspa($row['conceito_interno']);
        $recomendacao_interna = aspa($row['recomendacao_interna']);
        $idt_produto_familia = null($row['idt_produto_familia']);
        $idt_produto_canal_midia = null($row['idt_produto_canal_midia']);
        $idt_produto_abrangencia = null($row['idt_produto_abrangencia']);
        $idt_produto_dimensao_complexidade = null($row['idt_produto_dimensao_complexidade']);
        $idt_produto_area_competencia = null($row['idt_produto_area_competencia']);
        $idt_produto_area_conhecimento = null($row['idt_produto_area_conhecimento']);
        $idt_produto_tag_pesquisa = null($row['idt_produto_tag_pesquisa']);
        $idt_produto_modelo_certificado = null($row['idt_produto_modelo_certificado']);
        $idt_produto_tipo = null($row['idt_produto_tipo']);
        $idt_produto_situacao = null($row['idt_produto_situacao']);
        $idt_produto_tipo_autor = null($row['idt_produto_tipo_autor']);
        $idt_produto_maturidade = null($row['idt_produto_maturidade']);
        $idt_foco_tematico = null($row['idt_foco_tematico']);
        $idt_tema_subtema = null($row['idt_tema_subtema']);
        $idt_publico_alvo = null($row['idt_publico_alvo']);
        $idt_produto_programar = null($idt_produto_programar);
        $idt_produto_copiado = null($idt_produto);

        $copia = null($row['copia']);
        $objetivo = aspa($row['objetivo']);
        $beneficio = aspa($row['beneficio']);
        $complemento = aspa($row['complemento']);
        $proprio = aspa($row['proprio']);
        $carga_horaria = aspa($row['carga_horaria']);
        $carga_horaria_ini = null($row['carga_horaria_ini']);
        $carga_horaria_fim = null($row['carga_horaria_fim']);
        $carga_horaria_2 = aspa($row['carga_horaria_2']);
        $carga_horaria_2_ini = null($row['carga_horaria_2_ini']);
        $carga_horaria_2_fim = null($row['carga_horaria_2_fim']);
        $titulo_comercial = aspa($row['titulo_comercial']);
        $idt_programa_grc = null($row['idt_programa_grc']);
        $necessita_credenciado = aspa($row['necessita_credenciado']);
        $participante_minimo = null($row['participante_minimo']);
        $participante_maximo = null($row['participante_maximo']);
        $palavra_chave = aspa($row['palavra_chave']);
        $detalhe = aspa($row['detalhe']);
        $idt_secao_responsavel = null($row['idt_secao_responsavel']);
        $idt_secao_autora = null($row['idt_secao_autora']);
        $idt_instrumento = null($row['idt_instrumento']);
        $idt_grau_escolaridade = null($row['idt_grau_escolaridade']);
        $idt_modalidade = null($row['idt_modalidade']);

        $ctotal_minimo = null($row['ctotal_minimo']);
        $ctotal_maximo = null($row['ctotal_maximo']);
        $rtotal_minimo = null($row['rtotal_minimo']);
        $rtotal_maximo = null($row['rtotal_maximo']);
        $rmedia = null($row['rmedia']);
        $cmedio = null($row['cmedio']);
        $dif_minimo = null($row['dif_minimo']);
        $dif_maximo = null($row['dif_maximo']);
        $dif_medio = null($row['dif_medio']);
        $copiaw = $row['copia'];
        $codigow = $row['codigo'];
        $idt_produto_especie = null($row['idt_produto_especie']);

        $sqlt = "select grc_p.copia from grc_produto grc_p ";
        $sqlt .= " where grc_p.codigo = " . $codigo;
        $sqlt .= " order by copia desc ";
        $rst = execsql($sqlt);
        ForEach ($rst->data as $rowt) {
            $copiaw = $rowt['copia'] + 1;
            break;
        }

        if ($idt_evento > 0) {
            $idt_produto_evento = $idt_evento;
        } else {
            $idt_produto_evento = 'null';
            $idt_produto_situacao = 4; // estudos preliminares;
        }

        $sql_i = " insert into grc_produto ( ";
        $sql_i .= " idt_produto_especie,";
        $sql_i .= " codigo,";
        $sql_i .= " descricao,";
        $sql_i .= " ativo,";
        $sql_i .= " conceito_interno,";
        $sql_i .= " recomendacao_interna,";
        $sql_i .= " idt_produto_familia,";
        $sql_i .= " idt_produto_canal_midia, ";
        $sql_i .= " idt_produto_abrangencia, ";
        $sql_i .= " idt_produto_dimensao_complexidade, ";
        $sql_i .= " idt_produto_area_competencia, ";
        $sql_i .= " idt_produto_area_conhecimento, ";
        $sql_i .= " idt_produto_tag_pesquisa, ";
        $sql_i .= " idt_produto_modelo_certificado, ";
        $sql_i .= " idt_produto_tipo, ";
        $sql_i .= " idt_produto_situacao, ";
        $sql_i .= " idt_produto_tipo_autor, ";
        $sql_i .= " idt_produto_maturidade, ";
        $sql_i .= " idt_foco_tematico, ";
        $sql_i .= " idt_tema_subtema, ";
        $sql_i .= " idt_publico_alvo, ";
        $sql_i .= " idt_produto_programar, ";
        $sql_i .= " idt_produto_evento, ";
        $sql_i .= " idt_produto_copiado, ";
        $sql_i .= " copia       ,";
        $sql_i .= " objetivo    ,";
        $sql_i .= " beneficio   ,";
        $sql_i .= " complemento ,";
        $sql_i .= " proprio     ,";
        $sql_i .= " carga_horaria       ,";
        $sql_i .= " carga_horaria_ini       ,";
        $sql_i .= " carga_horaria_fim       ,";
        $sql_i .= " carga_horaria_2       ,";
        $sql_i .= " carga_horaria_2_ini       ,";
        $sql_i .= " carga_horaria_2_fim       ,";
        $sql_i .= " titulo_comercial       ,";
        $sql_i .= " idt_programa_grc       ,";
        $sql_i .= " necessita_credenciado       ,";
        $sql_i .= " participante_minimo ,";
        $sql_i .= " participante_maximo ,";
        $sql_i .= " palavra_chave       ,";
        $sql_i .= " detalhe             ,";
        $sql_i .= " idt_secao_responsavel ,";
        $sql_i .= " idt_secao_autora      ,";
        $sql_i .= " idt_instrumento       ,";
        $sql_i .= " idt_grau_escolaridade ,";
        $sql_i .= " idt_modalidade,        ";
        $sql_i .= " ctotal_minimo,        ";
        $sql_i .= " ctotal_maximo,        ";
        $sql_i .= " rtotal_minimo,        ";
        $sql_i .= " rtotal_maximo,        ";
        $sql_i .= " rmedia,        ";
        $sql_i .= " cmedio,        ";
        $sql_i .= " dif_minimo,        ";
        $sql_i .= " dif_maximo,        ";
        $sql_i .= " dif_medio        ";
        $sql_i .= " ) VALUES ( ";
        $sql_i .= " $idt_produto_especie,";
        $sql_i .= " $codigo,";
        $sql_i .= " $descricao,";
        $sql_i .= " $ativo,";
        $sql_i .= " $conceito_interno,";
        $sql_i .= " $recomendacao_interna,";
        $sql_i .= " $idt_produto_familia,";
        $sql_i .= " $idt_produto_canal_midia, ";
        $sql_i .= " $idt_produto_abrangencia, ";
        $sql_i .= " $idt_produto_dimensao_complexidade, ";
        $sql_i .= " $idt_produto_area_competencia, ";
        $sql_i .= " $idt_produto_area_conhecimento, ";
        $sql_i .= " $idt_produto_tag_pesquisa, ";
        $sql_i .= " $idt_produto_modelo_certificado, ";
        $sql_i .= " $idt_produto_tipo, ";
        $sql_i .= " $idt_produto_situacao, ";
        $sql_i .= " $idt_produto_tipo_autor, ";
        $sql_i .= " $idt_produto_maturidade, ";
        $sql_i .= " $idt_foco_tematico, ";
        $sql_i .= " $idt_tema_subtema, ";
        $sql_i .= " $idt_publico_alvo, ";
        $sql_i .= " $idt_produto_programar, ";
        $sql_i .= " $idt_produto_evento, ";
        $sql_i .= " $idt_produto_copiado, ";
        $sql_i .= " $copiaw   ,";
        $sql_i .= " $objetivo    ,";
        $sql_i .= " $beneficio   ,";
        $sql_i .= " $complemento ,";
        $sql_i .= " $proprio     ,";
        $sql_i .= " $carga_horaria       ,";
        $sql_i .= " $carga_horaria_ini       ,";
        $sql_i .= " $carga_horaria_fim       ,";
        $sql_i .= " $carga_horaria_2       ,";
        $sql_i .= " $carga_horaria_2_ini       ,";
        $sql_i .= " $carga_horaria_2_fim       ,";
        $sql_i .= " $titulo_comercial       ,";
        $sql_i .= " $idt_programa_grc       ,";
        $sql_i .= " $necessita_credenciado       ,";
        $sql_i .= " $participante_minimo ,";
        $sql_i .= " $participante_maximo ,";
        $sql_i .= " $palavra_chave       ,";
        $sql_i .= " $detalhe             ,";
        $sql_i .= " $idt_secao_responsavel ,";
        $sql_i .= " $idt_secao_autora      ,";
        $sql_i .= " $idt_instrumento       ,";
        $sql_i .= " $idt_grau_escolaridade ,";
        $sql_i .= " $idt_modalidade,        ";
        $sql_i .= " $ctotal_minimo,        ";
        $sql_i .= " $ctotal_maximo,        ";
        $sql_i .= " $rtotal_minimo,        ";
        $sql_i .= " $rtotal_maximo,        ";
        $sql_i .= " $rmedia,        ";
        $sql_i .= " $cmedio,        ";
        $sql_i .= " $dif_minimo,        ";
        $sql_i .= " $dif_maximo,        ";
        $sql_i .= " $dif_medio        ";
        $sql_i .= ") ";
        $result = execsql($sql_i);
        $idt_produto_novo = lastInsertId();
    }

    return $idt_produto_novo;
}

// Copiar Produto Insumos
function CopiaProdutoInsumo($idt_produto, $idt_produto_novo) {
    $kokw = 0;

    $sql = "select grc_pi.* from grc_produto_insumo grc_pi ";
    $sql .= " where grc_pi.idt_produto = " . null($idt_produto);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = aspa($row['codigo']);
        $descricao = aspa($row['descricao']);
        $ativo = aspa($row['ativo']);
        $detalhe = aspa($row['detalhe']);
        $por_participante = aspa($row['por_participante']);
        $idt_insumo = null($row['idt_insumo']);
        $idt_area_suporte = null($row['idt_area_suporte']);
        $quantidade = null($row['quantidade']);
        $custo_unitario_real = null($row['custo_unitario_real']);
        $idt_insumo_unidade = null($row['idt_insumo_unidade']);

        $sql_i = " insert into grc_produto_insumo ( ";
        $sql_i .= " idt_produto,";
        $sql_i .= " codigo,";
        $sql_i .= " descricao,";
        $sql_i .= " ativo,";
        $sql_i .= " detalhe,    ";
        $sql_i .= " por_participante,";
        $sql_i .= " idt_insumo,";
        $sql_i .= " idt_area_suporte,";
        $sql_i .= " quantidade,";
        $sql_i .= " custo_unitario_real,";
        $sql_i .= " idt_insumo_unidade ";
        $sql_i .= " ) VALUES ( ";
        $sql_i .= " $idt_produto_novo,";
        $sql_i .= " $codigo,";
        $sql_i .= " $descricao,";
        $sql_i .= " $ativo,";
        $sql_i .= " $detalhe, ";
        $sql_i .= " $por_participante,";
        $sql_i .= " $idt_insumo,";
        $sql_i .= " $idt_area_suporte,";
        $sql_i .= " $quantidade,";
        $sql_i .= " $custo_unitario_real,";
        $sql_i .= " $idt_insumo_unidade ";
        $sql_i .= ") ";
        $result = execsql($sql_i);
    }
    $kokw = 1;
    return $kokw;
}

// Copiar Produto Entrega
function CopiaProdutoEntrega($idt_produto, $idt_produto_novo) {
    $kokw = 0;

    $sql = "";
    $sql .= "select grc_pe.* from grc_produto_entrega grc_pe ";
    $sql .= " where grc_pe.idt_produto = " . null($idt_produto);
    $rs = execsql($sql);

    ForEach ($rs->data as $row) {
        $idt_entrega = null($row['idt']);
        $codigo = aspa($row['codigo']);
        $descricao = aspa($row['descricao']);
        $detalhe = aspa($row['detalhe']);
        $percentual = null($row['percentual']);
        $ordem = null($row['ordem']);

        // Inserindo Documento Entrega
        $sql = "";
        $sql .= " insert into grc_produto_entrega ( ";
        $sql .= " idt_produto,";
        $sql .= " codigo,";
        $sql .= " descricao,";
        $sql .= " detalhe,    ";
        $sql .= " percentual,";
        $sql .= " ordem,";
        $sql .= " idt_area_suporte";
        $sql .= " ) VALUES ( ";
        $sql .= " $idt_produto_novo,";
        $sql .= " $codigo,";
        $sql .= " $descricao,";
        $sql .= " $detalhe, ";
        $sql .= " $percentual,";
        $sql .= " $ordem";
        $sql .= ") ";
        $result = execsql($sql);
        $idt_produto_entrega_novo = lastInsertId();

        $sql = "";
        $sql .= " select grc_ped.* from grc_produto_entrega_documento grc_ped ";
        $sql .= " where grc_ped.idt_produto_entrega = " . null($idt_entrega);
        $rs_documento = execsql($sql);

        ForEach ($rs_documento->data as $row_documento) {
            $idt_documento = null($row_documento['idt_documento']);
            $codigo = aspa($row_documento['codigo']);

            // Inserindo Documento Entrega Documento
            $sql = "";
            $sql .= " insert into grc_produto_entrega_documento ( ";
            $sql .= " idt_produto_entrega,";
            $sql .= " idt_documento,";
            $sql .= " codigo";
            $sql .= " ) VALUES ( ";
            $sql .= " $idt_produto_novo,";
            $sql .= " $codigo,";
            $sql .= " $descricao";
            $sql .= ") ";
            $result = execsql($sql);
            $idt_produto_entrega_novo = lastInsertId();
        }
    }
    $kokw = 1;
    return $kokw;
}

// Copiar Produto Realizadores
function CopiaProdutoRealizador($idt_produto, $idt_produto_novo) {
    $kokw = 0;

    $sql = "select grc_pr.* from grc_produto_realizador grc_pr ";
    $sql .= " where grc_pr.idt_produto = " . null($idt_produto);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = aspa($row['codigo']);
        $descricao = aspa($row['descricao']);
        $ativo = aspa($row['ativo']);
        $detalhe = aspa($row['detalhe']);
        $idt_relacao = null($row['idt_relacao']);
        $idt_usuario = null($row['idt_usuario']);

        $sql_i = " insert into grc_produto_realizador ( ";
        $sql_i .= " idt_produto,";
        $sql_i .= " codigo,";
        $sql_i .= " descricao,";
        $sql_i .= " ativo,";
        $sql_i .= " detalhe,    ";
        $sql_i .= " idt_relacao,";
        $sql_i .= " idt_usuario ";
        $sql_i .= " ) VALUES ( ";
        $sql_i .= " $idt_produto_novo,";
        $sql_i .= " $codigo,";
        $sql_i .= " $descricao,";
        $sql_i .= " $ativo,";
        $sql_i .= " $detalhe, ";
        $sql_i .= " $idt_relacao,";
        $sql_i .= " $idt_usuario ";
        $sql_i .= ") ";
        $result = execsql($sql_i);
    }
    $kokw = 1;
    return $kokw;
}

// Copiar Conteudo programático
function CopiaProdutoConteudoProgramatico($idt_produto, $idt_produto_novo) {
    $kokw = 0;

    $sql = "select grc_pcp.* from grc_produto_conteudo_programatico grc_pcp ";
    $sql .= " where grc_pcp.idt_produto = " . null($idt_produto);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = aspa($row['codigo']);
        $descricao = aspa($row['descricao']);
        $ativo = aspa($row['ativo']);
        $detalhe = aspa($row['detalhe']);
        $idt_produto_conteudo_programatico = null($row['idt_produto_conteudo_programatico']);

        $sql_i = " insert into grc_produto_conteudo_programatico ( ";
        $sql_i .= " idt_produto,";
        $sql_i .= " codigo,";
        $sql_i .= " descricao,";
        $sql_i .= " ativo,";
        $sql_i .= " detalhe,    ";
        $sql_i .= " idt_produto_conteudo_programatico ";
        $sql_i .= " ) VALUES ( ";
        $sql_i .= " $idt_produto_novo,";
        $sql_i .= " $codigo,";
        $sql_i .= " $descricao,";
        $sql_i .= " $ativo,";
        $sql_i .= " $detalhe, ";
        $sql_i .= " $idt_produto_conteudo_programatico ";
        $sql_i .= ") ";
        $result = execsql($sql_i);
    }
    $kokw = 1;
    return $kokw;
}

// Copiar Produtos Associados
function CopiaProdutoProduto($idt_produto, $idt_produto_novo) {
    $kokw = 0;

    $sql = "select grc_pp.* from grc_produto_produto grc_pp ";
    $sql .= " where grc_pp.idt_produto = " . null($idt_produto);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = aspa($row['codigo']);
        $descricao = aspa($row['descricao']);
        $ativo = aspa($row['ativo']);
        $detalhe = aspa($row['detalhe']);
        $idt_produto_associado = null($row['idt_produto_associado']);

        $sql_i = " insert into grc_produto_produto ( ";
        $sql_i .= " idt_produto,";
        $sql_i .= " codigo,";
        $sql_i .= " descricao,";
        $sql_i .= " ativo,";
        $sql_i .= " detalhe,    ";
        $sql_i .= " idt_produto_associado ";
        $sql_i .= " ) VALUES ( ";
        $sql_i .= " $idt_produto_novo,";
        $sql_i .= " $codigo,";
        $sql_i .= " $descricao,";
        $sql_i .= " $ativo,";
        $sql_i .= " $detalhe, ";
        $sql_i .= " $idt_produto_associado ";
        $sql_i .= ") ";
        $result = execsql($sql_i);
    }
    $kokw = 1;
    return $kokw;
}

// Copiar Produtos Arquivos Associados
function CopiaProdutoArquivoAssociado($idt_produto, $idt_produto_novo) {
    $kokw = 0;

    $sql = "select grc_paa.* from grc_produto_arquivo_associado grc_paa ";
    $sql .= " where grc_paa.idt_produto = " . null($idt_produto);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = aspa($row['codigo']);
        $titulo = aspa($row['titulo']);
        $ativo = aspa($row['ativo']);
        $detalhe = aspa($row['detalhe']);
        $arquivo = aspa($row['arquivo']);
        $versao = aspa($row['versao']);

        $sql_i = " insert into grc_produto_arquivo_associado ( ";
        $sql_i .= " idt_produto,";
        $sql_i .= " codigo,";
        $sql_i .= " titulo,";
        $sql_i .= " ativo,";
        $sql_i .= " detalhe,    ";
        $sql_i .= " arquivo,    ";
        $sql_i .= " versao ";
        $sql_i .= " ) VALUES ( ";
        $sql_i .= " $idt_produto_novo,";
        $sql_i .= " $codigo,";
        $sql_i .= " $titulo,";
        $sql_i .= " $ativo,";
        $sql_i .= " $detalhe, ";
        $sql_i .= " $arquivo,    ";
        $sql_i .= " $versao ";
        $sql_i .= ") ";
        $result = execsql($sql_i);
    }
    $kokw = 1;
    return $kokw;
}

// Copiar Produtos Area Conhecimento
function CopiaProdutoAreaConhecimento($idt_produto, $idt_produto_novo) {
    $kokw = 0;

    $sql = "select grc_pac.* from grc_produto_area_conhecimento grc_pac ";
    $sql .= " where grc_pac.idt_produto = " . null($idt_produto);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = aspa($row['codigo']);
        $descricao = aspa($row['descricao']);
        $ativo = aspa($row['ativo']);
        $detalhe = aspa($row['detalhe']);
        $idt_area = null($row['idt_area']);

        $sql_i = " insert into grc_produto_area_conhecimento ( ";
        $sql_i .= " idt_produto,";
        $sql_i .= " codigo,";
        $sql_i .= " descricao,";
        $sql_i .= " ativo,";
        $sql_i .= " detalhe,    ";
        $sql_i .= " idt_area ";
        $sql_i .= " ) VALUES ( ";
        $sql_i .= " $idt_produto_novo,";
        $sql_i .= " $codigo,";
        $sql_i .= " $descricao,";
        $sql_i .= " $ativo,";
        $sql_i .= " $detalhe, ";
        $sql_i .= " $idt_area ";
        $sql_i .= ") ";
        $result = execsql($sql_i);
    }
    $kokw = 1;
    return $kokw;
}

// Copiar Produto para Evento
function CopiarEventoProduto($idt_evento, $idt_produto, $texto) {
    //
    // Isso copia os dados do produto e vincula ao evento
    //
    $kokw = 0;
    beginTransaction();
    set_time_limit(90);
    //
    //   o grc_evento esta associado a um produto
    $sql = "select grc_p.idt from grc_produto grc_p ";
    $sql .= " where grc_p.idt_produto_evento  = " . null($idt_evento);
    // $sql .= "   and grc_p.idt_produto_copiado = ".null($idt_produto);
    $rs = execsql($sql);

    // p($sql);

    if ($rs->rows != 0) {   // já ta associado e copiado
        ForEach ($rs->data as $row) {
            $idt = $row['idt'];
            // Exclui o copiado anteriormente
            // $sql = ' delete from ';
            // $sql .= ' grc_produto ';
            // $sql .= ' where idt = '.null($idt);
            // $rs = execsql($sql);
            ExcluiProduto($idt);
        }
    }
    //
    $sql = "select grc_p.* from grc_produto grc_p ";
    $sql .= " where grc_p.idt_produto_evento  = " . null($idt_evento);
    $sql .= "   and grc_p.idt                 = " . null($idt_produto);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $idt_produto_novo = 0;
        $kokw = AtivaCopiaProduto($idt_produto, $idt_evento, $idt_produto_novo);
        //
        if ($kokw == 1) {
            //
            // fazer vinculo com o evento em evento_produto
            //
            // VincularEventoProduto($idt_produto_novo, $idt_evento, $texto);
        //
        }
    } else {  //o produto ja tem cópia para esse evento
        ForEach ($rs->data as $row) {
            $idt_produto_novo = $row['idt'];
        }
    }

    //
    // Gerar Ocorrência do Evento
    //
    commit();

    return $idt_produto_novo;
}

// Copiar Produto Unidade Regional
function CopiaProdutoUnidadeRegional($idt_produto, $idt_produto_novo) {
    $kokw = 0;

    $sql = "";
    $sql .= " SELECT grc_pur.* ";
    $sql .= " FROM grc_produto_unidade_regional grc_pur ";
    $sql .= " WHERE grc_pur.idt_produto = " . null($idt_produto);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = aspa($row['codigo']);
        $descricao = aspa($row['descricao']);
        $ativo = aspa($row['ativo']);
        $detalhe = aspa($row['detalhe']);
        $idt_unidade_regional = null($row['idt_unidade_regional']);

        $sql_i = " insert into grc_produto_unidade_regional ( ";
        $sql_i .= " codigo,";
        $sql_i .= " descricao,";
        $sql_i .= " ativo,";
        $sql_i .= " detalhe,";
        $sql_i .= " idt_produto,";
        $sql_i .= " idt_unidade_regional";
        $sql_i .= " ) VALUES ( ";
        $sql_i .= " $codigo,";
        $sql_i .= " $descricao,";
        $sql_i .= " $ativo,";
        $sql_i .= " $detalhe, ";
        $sql_i .= " $idt_produto_novo,";
        $sql_i .= " $idt_unidade_regional ";
        $sql_i .= ") ";
        $result = execsql($sql_i);
    }
    $kokw = 1;
    return $kokw;
}

// Copiar Produto Versão
function CopiaProdutoVersao($idt_produto, $idt_produto_novo) {
    $kokw = 0;

    $sql = "";
    $sql .= " SELECT grc_pv.* ";
    $sql .= " FROM grc_produto_versao grc_pv ";
    $sql .= " WHERE grc_pv.idt_produto = " . null($idt_produto);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = aspa($row['codigo']);
        $descricao = aspa($row['descricao']);
        $ativo = aspa($row['ativo']);
        $detalhe = aspa($row['detalhe']);

        $sql_i = " insert into grc_produto_versao ( ";
        $sql_i .= " idt_produto,";
        $sql_i .= " codigo,";
        $sql_i .= " descricao,";
        $sql_i .= " ativo,";
        $sql_i .= " detalhe";
        $sql_i .= " ) VALUES ( ";
        $sql_i .= " $idt_produto_novo,";
        $sql_i .= " $codigo,";
        $sql_i .= " $descricao,";
        $sql_i .= " $ativo,";
        $sql_i .= " $detalhe ";
        $sql_i .= ") ";
        $result = execsql($sql_i);
    }
    $kokw = 1;
    return $kokw;
}

function VincularEventoProduto($idt_produto, $idt_evento, $texto) {
    $kokw = 0;
    //
    $sql = "select grc_ep.* from grc_evento_produto grc_ep ";
    $sql .= " where grc_ep.idt_evento  = " . null($idt_evento);
    $sql .= "   and grc_ep.idt_produto = " . null($idt_produto);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        //
        $vinculo_texto = aspa($texto);
        $sql_i = " insert into grc_evento_produto ( ";
        $sql_i .= " idt_evento, ";
        $sql_i .= " idt_produto, ";
        $sql_i .= " detalhe ";
        $sql_i .= " ) VALUES ( ";
        $sql_i .= " $idt_evento, ";
        $sql_i .= " $idt_produto, ";
        $sql_i .= " $vinculo_texto ";
        $sql_i .= ") ";
        $result = execsql($sql_i);
        $idt_evento_produto = lastInsertId();
        //
        $sql_a = ' update grc_produto set ';
        $sql_a .= ' idt_evento_produto  = ' . null($idt_evento_produto) . '  ';
        $sql_a .= ' where idt = ' . null($idt_produto) . '  ';
        $result = execsql($sql_a);
        //
    }
    $kokw = 1;
    return $kokw;
}

function AtivaSituacaoEvento($idt_evento, $idt_situacao) {
    $kokw = 0;

    // echo " idt_evento = $idt_produto";

    $sql = "select * from grc_evento_situacao ";
    $sql .= " where idt = " . $idt_situacao;
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $idt_destino = $row['idt'];
        $codigo_destino = $row['codigo'];
        $descricao_destino = $row['descricao'];
    }

    $sql = "select grc_es.* from grc_evento grc_e ";
    $sql .= " inner join grc_evento_situacao grc_es on grc_es.idt = grc_e.idt_evento_situacao";
    $sql .= " where grc_e.idt = " . null($idt_evento);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $idt_origem = $row['idt'];
        $codigo_origem = $row['codigo'];
        $descricao_origem = $row['descricao'];
    }

    beginTransaction();
    set_time_limit(90);

    $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($idt_evento);
    execsql($sql_a);

    $sql_a = ' update grc_evento set ';
    $sql_a .= ' idt_evento_situacao  = ' . null($idt_situacao) . '  ';
    $sql_a .= ' where idt  = ' . null($idt_evento) . '  ';
    $result = execsql($sql_a);
    //
    // registrar a Ocorrência 
    //
    $detalhew = "";
    if ($codigo_destino == '45') { // DISPARAR PROCESSO DE SOLICITAÇÃO DOS INSUMOS PARA COMPRAS
        $detalhew .= " ATENÇÃO...<br />";
        $detalhew .= " DISPARADO PROCESSO DE SOLICITAÇÃO DOS INSUMOS PARA COMPRAS.<br /><br />";
    }

    $detalhew .= " Situação Atual  : " . $codigo_origem . " - " . $descricao_origem . "<br />";
    $detalhew .= " Modificada para : " . $codigo_destino . " - " . $descricao_destino . "<br />";

    $detalhew .= " Responsável pela Modificação : <br /> ";
    $detalhew .= " USUÁRIO: " . $_SESSION[CS]['g_login'] . "<br /> ";
    $detalhew .= " NOME COMPLETO: " . $_SESSION[CS]['g_nome_completo'] . "<br /> ";
    $detalhew .= " EMAIL: " . $_SESSION[CS]['g_email'] . "<br /> ";

    $codigo = aspa("");
    $descricao = " Modificada Situação para: " . $codigo_destino . " - " . $descricao_destino;

    $descricao = aspa($descricao);
    $ativo = aspa('S');
    $flag = aspa('S');
    $detalhe = aspa($detalhew);
    $dataw = date('d/m/Y H:i:s');
    $data = aspa(trata_data($dataw));
    $idt_responsavel = $_SESSION[CS]['g_id_usuario'];

    $sql_i = ' insert into grc_evento_ocorrencia ';
    $sql_i .= ' (  ';
    $sql_i .= " idt_evento, ";
    $sql_i .= " codigo, ";
    $sql_i .= " descricao, ";
    $sql_i .= " ativo, ";
    $sql_i .= " flag, ";
    $sql_i .= " detalhe, ";
    $sql_i .= " data, ";
    $sql_i .= " idt_responsavel ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $idt_evento, ";
    $sql_i .= " $codigo, ";
    $sql_i .= " $descricao, ";
    $sql_i .= " $ativo, ";
    $sql_i .= " $flag, ";
    $sql_i .= " $detalhe, ";
    $sql_i .= " $data, ";
    $sql_i .= " $idt_responsavel ";


    $sql_i .= ') ';
    $result = execsql($sql_i);

    if ($codigo_destino == '45') { // DISPARAR PROCESSO DE SOLICITAÇÃO DOS INSUMOS PARA COMPRAS
    }

    commit();


    $kokw = 1;
    return $kokw;
}

function CalcularInsumoEvento_old($idt_evento) {
    //
    $participante_minimo = 0;
    $participante_maximo = 0;

    $sql = "select grc_e.* from grc_evento grc_e ";
    $sql .= " where grc_e.idt = " . null($idt_evento);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $participante_minimo = $row['participante_minimo'];
        $participante_maximo = $row['participante_maximo'];
    }
    $ctotal_minimo_p = 0;
    $ctotal_maximo_p = 0;

    $sql = "select grc_ei.* from grc_evento_insumo grc_ei ";
    $sql .= " where grc_ei.idt_evento = " . null($idt_evento);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $idt_evento_insumo = $row['idt'];
        $por_participante = $row['por_participante'];
        $quantidade = $row['quantidade'];
        $custo_unitario_real = $row['custo_unitario_real'];
        $idt_insumo_unidade = $row['idt_insumo_unidade'];
        //
        $ctotal = $quantidade * $custo_unitario_real;
        if ($por_participante == 'S') {
            $ctotal_minimo = $participante_minimo * $ctotal;
            $ctotal_maximo = $participante_maximo * $ctotal;
        } else {
            $ctotal_minimo = $ctotal;
            $ctotal_maximo = $ctotal;
        }
        $ctotal_minimo_p = $ctotal_minimo_p + $ctotal_minimo;
        $ctotal_maximo_p = $ctotal_maximo_p + $ctotal_maximo;

        $sql_a = ' update grc_evento_insumo set ';
        $sql_a .= ' custo_total      = ' . null($ctotal) . ',  ';
        $sql_a .= ' previsao_despesa = ' . null($ctotal_maximo) . ',  ';
        $sql_a .= ' ctotal_minimo    = ' . null($ctotal_minimo) . ',  ';
        $sql_a .= ' ctotal_maximo    = ' . null($ctotal_maximo) . '  ';
        $sql_a .= ' where idt = ' . null($idt_evento_insumo) . '  ';
        $result = execsql($sql_a);
    }

    $total_despesa_p = ( ($ctotal_minimo_p + $ctotal_maximo_p) / 1.90 );

    $sql_a = ' update grc_evento set ';
    $sql_a .= ' previsao_despesa  = ' . null($ctotal_maximo_p) . ',  ';
    $sql_a .= ' despesa_minima  = ' . null($ctotal_minimo_p) . ',  ';
    $sql_a .= ' despesa_maxima  = ' . null($ctotal_maximo_p) . ',  ';
    $sql_a .= ' total_despesa   = ' . null($total_despesa_p) . '  ';
    $sql_a .= ' where idt = ' . null($idt_evento) . '  ';
    $result = execsql($sql_a);
}

function DadoInsumo($idt_insumo) {
    $vetInsumo = Array();
    $sql = "select grc_i.* from grc_insumo grc_i ";
    $sql .= " where grc_i.idt = " . null($idt_insumo);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = $row['codigo'];
        $descricao = $row['descricao'];
        $ativo = $row['ativo'];
        $detalhe = $row['detalhe'];
        $classificacao = $row['classificacao'];
        $idt_insumo_elemento_custo = $row['idt_insumo_elemento_custo'];
        $idt_insumo_unidade = $row['idt_insumo_unidade'];
        $custo_unitario_real = $row['custo_unitario_real'];
        $por_participante = $row['por_participante'];
        $nivel = $row['nivel'];
        $vetInsumo = $row;
    }
    return $vetInsumo;
}

function DifHora($data_final, $data_inicial, $unidade = 'MI') {
    $dif = 0;

    $dif = diffDate($data_inicial, $data_final, $unidade);

    return $dif;
}

//
// funções para Municipios
//
function ExecutaImportacao_Municipio($idt_importacao) {
    // Carregar txt para memória
    $sql = 'select ';
    $sql .= '  plu_ct.*   ';
    $sql .= '  from plu_converte_texto plu_ct ';
    $sql .= '  where plu_ct.idt=' . null($idt_importacao);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        return 2;
    }
    $arquivo = '';
    ForEach ($rs->data as $row) {
        $tipo = $row['tipo'];
        $arquivo_municipio = $row['arquivo_municipio'];
    }
    $sql_d = 'delete from db_pir_gec.plu_cidade ';
    $result = execsql($sql_d);

    $arquivow = basename($arquivo_municipio);
    $path = 'obj_file/plu_converte_texto/' . $arquivow;
    if (!file_exists($path)) {
        echo ' erro de arquivo inexistente ' . $path;
        return $kokw;
    }
    $arquivo = file("$path");
    $vetlinha = Array();
    foreach ($arquivo as $texto) {
        $cpos = Array();
        $texto = $texto . ';';
        //$cpos = explode(';', $texto);
        $cpos = str_getcsv($texto, ';');
        $vetlinha[] = $cpos;
    }

    foreach ($vetlinha as $cpos) {
        $klinn = $klinn + 1;
        if ($klinn <= 1) {  // Linha de cabeçalho
            continue;
        }
        $idt_estado = 5;
        $codigo_ibge = aspa($cpos[1]);
        $sigla = aspa($cpos[1]);
        $descricao = aspa($cpos[0]);


        $sql_i = " insert into db_pir_gec.plu_cidade ";
        $sql_i .= " (  ";
        $sql_i .= " idt_estado, ";
        $sql_i .= " sigla, ";
        $sql_i .= " descricao, ";
        $sql_i .= " codigo_ibge ";
        $sql_i .= "  ) values ( ";
        $sql_i .= " $idt_estado, ";
        $sql_i .= " $sigla, ";
        $sql_i .= " $descricao, ";
        $sql_i .= " $codigo_ibge ";
        $sql_i .= ") ";
        $result = execsql($sql_i);
    }
}

function ExecutaImportacao_Regional($idt_importacao) {
    // Carregar txt para memória
    $sql = 'select ';
    $sql .= '  plu_ct.*   ';
    $sql .= '  from plu_converte_texto plu_ct ';
    $sql .= '  where plu_ct.idt=' . null($idt_importacao);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        return 2;
    }
    $arquivo = '';
    ForEach ($rs->data as $row) {
        $tipo = $row['tipo'];
        $arquivo_regional = $row['arquivo_regional'];
    }

    $arquivow = basename($arquivo_regional);
    $path = 'obj_file/plu_converte_texto/' . $arquivow;
    if (!file_exists($path)) {
        echo ' erro de arquivo inexistente ' . $path;
        return $kokw;
    }
    $arquivo = file("$path");
    $vetlinha = Array();
    foreach ($arquivo as $texto) {
        $cpos = Array();
        $texto = $texto . ';';
        //$cpos = explode(';', $texto);
        $cpos = str_getcsv($texto, ';');
        $vetlinha[] = $cpos;
    }


    $vetRegional = Array();
    $vetRegional['BARREIRAS'] = 12;
    $vetRegional['FEIRA DE SANTANA'] = 19;
    $vetRegional['ILHÉUS'] = 15;
    $vetRegional['IRECÊ'] = 26;
    $vetRegional['JACOBINA'] = 44;
    $vetRegional['JUAZEIRO'] = 17;
    $vetRegional['SALVADOR'] = 4;
    $vetRegional['SANTO ANTÔNIO DE JESUS'] = 27;
    $vetRegional['TEIXEIRA DE FREITAS'] = 10;
    $vetRegional['VITÓRIA DA CONQUISTA'] = 21;



    foreach ($vetlinha as $cpos) {
        $klinn = $klinn + 1;
        if ($klinn <= 1) {  // Linha de cabeçalho
            continue;
        }
        $municipio = $cpos[0];
        $regional = $cpos[1];
        $idt_regional = $vetRegional[$regional];
        echo " $idt_regional ==== $regional <br />  ";
        if ($idt_regional > 0) {

            $sql = 'select ';
            $sql .= '  plu_ci.*   ';
            $sql .= '  from db_pir_gec.plu_cidade plu_ci ';
            $sql .= '  where UPPER(plu_ci.descricao) =' . aspa($municipio);
            $rs = execsql($sql);
            ForEach ($rs->data as $row) {
                $idt_organizacao_secao = $row['idt'];
                $sql_a = ' update db_pir_gec.plu_cidade set ';
                $sql_a .= ' idt_unidade_regional  = ' . null($idt_regional) . '  ';
                $sql_a .= ' where idt  = ' . null($idt_organizacao_secao) . '  ';
                $result = execsql($sql_a);
            }
        }
    }

    /*
      12 - BARREIRAS
      19 - FEIRA DE SANTANA
      15 - ILHÉUS

      26 - IRECÊ
      44 - JACOBINA
      17 - JUAZEIRO
      4  - SALVADOR
      27 - SANTO ANTÔNIO DE JESUS
      10 - TEIXEIRA DE FREITAS
      21 - VITÓRIA DA CONQUISTA
     */
}

//
// funções para Produtos
//
function ExecutaImportacao_Produto($idt_importacao) {
    // Carregar txt para memória
    $sql = 'select ';
    $sql .= '  plu_ct.*   ';
    $sql .= '  from plu_converte_texto plu_ct ';
    $sql .= '  where plu_ct.idt=' . null($idt_importacao);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        return 2;
    }
    $arquivo = '';
    ForEach ($rs->data as $row) {
        $tipo = $row['tipo'];
        $arquivo_produto = $row['arquivo_produto'];
    }
    $sql_d = 'delete from grc_produto ';
    $sql_d .= " where origem = 'SEBRAETEC' ";
    $result = execsql($sql_d);

    $arquivow = basename($arquivo_produto);
    $path = 'obj_file/plu_converte_texto/' . $arquivow;
    if (!file_exists($path)) {
        echo ' erro de arquivo inexistente ' . $path;
        return $kokw;
    }
    $arquivo = file("$path");
    $vetlinha = Array();
    foreach ($arquivo as $texto) {
        $cpos = Array();
        $texto = $texto . ';';
        //$cpos = explode(';', $texto);
        $cpos = str_getcsv($texto, ';');
        $vetlinha[] = $cpos;
    }
    $vetFamilia = Array();
    foreach ($vetlinha as $cpos) {
        $klinn = $klinn + 1;
        if ($klinn <= 1) {  // Linha de cabeçalho
            continue;
        }

        $codigo_siac = aspa('606');
        $codigo_classificacao_siac = aspa('40000000606');
        $descricao_siac = aspa("Área de Inovação");



        $descricao = aspa($cpos[1]);

        $ativo = ($cpos[2]);
        $detalhe = aspa($cpos[3]);
        $pai = ($cpos[4]);
        $limite_hora = aspa($cpos[5]);
        $codigo_linha_apoio = aspa($cpos[6]);

        $origem = aspa(SEBRAETEC);

        $ativow = aspa('S');

        $proprio = aspa('S');
        $gratuito = aspa('S');

        $copia = 0;

        if ($ativo == 0) {
            $ativow = aspa('N');
        }
        $tabela = 'grc_produto';
        $Campo = 'codigo';
        $tam = 11;
        $codigow = numerador_arquivo($tabela, $Campo, $tam);
        $codigo = aspa('BA' . $codigow);


        $idt_produto_situacao = 1;
        $idt_produto_tipo = 2;
        $idt_programa = 4;

        $idt_instrumento = 39;
        $idt_produto_maturidade = 2;
        $idt_modalidade = 1;
        $idt_produto_abrangencia = 2;
        $idt_foco_tematico = 3;
        $idt_produto_familia = 4;

        $idt_produto_modelo_certificado = 1;

        $idt_secao_autora = 64;
        $idt_secao_responsavel = 64;
        // formar o grupo
        $codigo_g = ZeroEsq($pai, 3);
        $sqlt = 'select ';
        $sqlt .= '  grc_pg.idt   ';
        $sqlt .= '  from grc_produto_grupo grc_pg ';
        $sqlt .= '  where grc_pg.codigo = ' . aspa($codigo_g);
        $rst = execsql($sqlt);
        $idt_grupo = 'null';
        ForEach ($rst->data as $rowt) {
            $idt_grupo = $rowt['idt'];
        }

        //////////// 


        $datadia = trata_data(date('d/m/Y H:i:s'));
        $idt_cadastrador = $_SESSION[CS]['g_id_usuario'];
        $data_cadastro = aspa($datadia);


        $sql_i = " insert into grc_produto ";
        $sql_i .= " (  ";
        $sql_i .= " idt_produto_situacao, ";
        $sql_i .= " idt_cadastrador, ";
        $sql_i .= " data_cadastro, ";

        $sql_i .= " idt_secao_autora, ";
        $sql_i .= " idt_secao_responsavel, ";
        $sql_i .= " idt_grupo, ";
        $sql_i .= " idt_produto_tipo, ";
        $sql_i .= " idt_programa, ";
        $sql_i .= " idt_instrumento, ";
        $sql_i .= " idt_produto_maturidade, ";
        $sql_i .= " idt_modalidade, ";
        $sql_i .= " idt_produto_abrangencia, ";
        $sql_i .= " idt_foco_tematico, ";
        $sql_i .= " idt_produto_familia, ";
        $sql_i .= " idt_produto_modelo_certificado, ";

        $sql_i .= " codigo, ";
        $sql_i .= " ativo, ";
        $sql_i .= " descricao, ";
        $sql_i .= " codigo_siac, ";
        $sql_i .= " descricao_siac, ";

        $sql_i .= " codigo_classificacao_siac, ";



        $sql_i .= " proprio, ";
        $sql_i .= " copia, ";
        $sql_i .= " gratuito, ";
        $sql_i .= " detalhe, ";
        $sql_i .= " origem ";
        $sql_i .= "  ) values ( ";
        $sql_i .= " $idt_produto_situacao, ";
        $sql_i .= " $idt_cadastrador, ";
        $sql_i .= " $data_cadastro, ";




        $sql_i .= " $idt_secao_autora, ";
        $sql_i .= " $idt_secao_responsavel, ";
        $sql_i .= " $idt_grupo, ";
        $sql_i .= " $idt_produto_tipo, ";
        $sql_i .= " $idt_programa, ";
        $sql_i .= " $idt_instrumento, ";
        $sql_i .= " $idt_produto_maturidade, ";
        $sql_i .= " $idt_modalidade, ";
        $sql_i .= " $idt_produto_abrangencia, ";
        $sql_i .= " $idt_foco_tematico, ";
        $sql_i .= " $idt_produto_familia, ";
        $sql_i .= " $idt_produto_modelo_certificado, ";


        $sql_i .= " $codigo, ";
        $sql_i .= " $ativow, ";
        $sql_i .= " $descricao, ";
        $sql_i .= " $codigo_siac, ";
        $sql_i .= " $descricao_siac, ";

        $sql_i .= " $codigo_classificacao_siac, ";



        $sql_i .= " $proprio, ";
        $sql_i .= " $copia, ";
        $sql_i .= " $gratuito, ";
        $sql_i .= " $detalhe, ";
        $sql_i .= " $origem ";


        $sql_i .= ") ";

        if ($cpos[4] > 0) {
            $result = execsql($sql_i);
        } else {
            $vetFamilia[$codigo_siac] = $descricao;
        }
    }


    //p($vetFamilia);
    //exit();     
}

//
// funções para Produtos siac
//
function ExecutaImportacao_Produto_siac($idt_importacao) {
    // Carregar txt para memória
    $sql = 'select ';
    $sql .= '  plu_ct.*   ';
    $sql .= '  from plu_converte_texto plu_ct ';
    $sql .= '  where plu_ct.idt=' . null($idt_importacao);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        return 2;
    }
    $arquivo = '';
    ForEach ($rs->data as $row) {
        $tipo = $row['tipo'];
        $arquivo_produto_siac = $row['arquivo_produto_siac'];
    }

    $sql_d = 'delete from grc_produto ';
    $sql_d .= " where origem = 'SIAC' ";
    $result = execsql($sql_d);

    $arquivow = basename($arquivo_produto_siac);
    $path = 'obj_file/plu_converte_texto/' . $arquivow;
    if (!file_exists($path)) {
        echo ' erro de arquivo inexistente ' . $path;
        return $kokw;
    }
    $arquivo = file("$path");
    $vetlinha = Array();
    foreach ($arquivo as $texto) {
        $cpos = Array();
        $texto = $texto . ';';
        //$cpos = explode(';', $texto);
        $cpos = str_getcsv($texto, ';');
        $vetlinha[] = $cpos;
    }
    $vetFamilia = Array();
    $vetFoco = Array();
    $vetCanalMidia = Array();
    $vetAbrangencia = Array();
    $vetSebraeResp = Array();

    foreach ($vetlinha as $cpos) {
        $klinn = $klinn + 1;
        if ($klinn <= 1) {  // Linha de cabeçalho
            continue;
        }

        $codigo_siac = aspa($cpos[0]);
        $codigo_classificacao_siac = aspa($cpos[1]);

        $codigo_familia = $cpos[2];
        $nome_familia = $cpos[3];

        $vetFamilia[$codigo_familia] = $nome_familia;

        $descricao = aspa($cpos[4]);
        $descricao_siac = aspa($cpos[4]);

        $vinculado = $cpos[5];

        $nome_foco = $cpos[6];


        $vetFoco[$nome_foco] = $nome_foco;

        $publicado = $cpos[7];
        $situacao = $cpos[8];

        $desc_situacao = $cpos[9];

        $objetivo = aspa($cpos[10]);

        $detalhe = aspa('');

        $ativow = aspa($situacao);

        $conteudo = aspa($cpos[11]);


        $publico_alvo = aspa($cpos[12]);


        $carga_horaria_previsao = $cpos[13];

        $percentual_freq_minima = $cpos[14];

        $qtd_inscricao_max = $cpos[15];

        $qtd_minima_pagantes = $cpos[16];

        $valor_evento = $cpos[17];

        $qtd_limite_dias_reserva = $cpos[18];

        $codigo_canal_midia = $cpos[19];
        $desc_canal_midia = $cpos[20];


        $vetCanalMidia[$codigo_canal_midia] = $desc_canal_midia;


        $codigo_abrangencia = $cpos[21];
        $desc_abrangencia = $cpos[22];


        $vetAbrangencia[$codigo_abrangencia] = $desc_abrangencia;


        $codigo_sebrae_responsavel = $cpos[23];
        $desc_sebrae_responsavel = $cpos[24];

        $vetSebraeResp[$codigo_sebrae_responsavel] = $desc_sebrae_responsavel;



        $conteudo_programatico = str_replace(chr(10), '<br />', $conteudo);



        $origem = aspa('SIAC');
        //
        $proprio = aspa('N');
        if ($vinculado != "") {
            $proprio = aspa('S');
        }
        $gratuito = aspa('S');
        //
        $copia = 0;

        $tabela = 'grc_produto';
        $Campo = 'codigo';
        $tam = 11;
        $codigow = numerador_arquivo($tabela, $Campo, $tam);
        $codigo = aspa('BA' . $codigow);


        $idt_produto_situacao = 1;
        $idt_produto_tipo = 1;
        $idt_programa = 1;
        $idt_modalidade = 1;
        $idt_produto_maturidade = 2;
        $idt_produto_modelo_certificado = 1;



        $idt_grupo = 'null';

        $idt_produto_familia = 'null';
        $idt_produto_canal_midia = 'null';
        $idt_produto_abrangencia = 'null';
        $idt_foco_tematico = 'null';

        $idt_secao_autora = 53;
        $idt_secao_responsavel = 53;

        // formar o grupo

        $codigo_g = ZeroEsq($pai, 3);
        $sqlt = 'select ';
        $sqlt .= '  grc_pg.idt   ';
        $sqlt .= '  from grc_produto_grupo grc_pg ';
        $sqlt .= '  where grc_pg.codigo = ' . aspa($codigo_g);
        $rst = execsql($sqlt);
        ForEach ($rst->data as $rowt) {
            $idt_grupo = $rowt['idt'];
        }






        $codigo_fa = ZeroEsq($codigo_familia, 2);

        $idt_instrumento = 'null';
        if ($codigo_fa == '04') {
            $idt_instrumento = 39;
        }

        if ($codigo_fa == '10002') {
            $idt_instrumento = 39;
        }
        if ($codigo_fa == '01') {
            $idt_instrumento = 40;
        }

        if ($codigo_fa == '03') {
            $idt_instrumento = 46;
        }

        if ($codigo_fa == '02') {
            $idt_instrumento = 47;
        }

        if ($codigo_fa == '05') {
            $idt_instrumento = 49;
        }


        $sqlt = 'select ';
        $sqlt .= '  grc_fa.idt   ';
        $sqlt .= '  from grc_produto_familia grc_fa ';
        $sqlt .= '  where grc_fa.codigo = ' . aspa($codigo_fa);
        $rst = execsql($sqlt);
        ForEach ($rst->data as $rowt) {
            $idt_produto_familia = $rowt['idt'];
        }



        $codigo_ig = ZeroEsq($grupo_despesa, 2);


        $sqlt = 'select ';
        $sqlt .= '  grc_ft.idt   ';
        $sqlt .= '  from grc_foco_tematico grc_ft ';
        $sqlt .= '  where grc_ft.descricao = ' . aspa($nome_foco);
        $rst = execsql($sqlt);
        ForEach ($rst->data as $rowt) {
            $idt_foco_tematico = $rowt['idt'];
        }


        $sqlt = 'select ';
        $sqlt .= '  grc_pa.idt   ';
        $sqlt .= '  from grc_produto_abrangencia grc_pa ';
        //$sqlt .= '  where grc_pa.codigo = '.aspa($codigo_abrangencia);
        $sqlt .= '  where grc_pa.codigo = ' . aspa($codigo_sebrae_responsavel);

        $rst = execsql($sqlt);
        ForEach ($rst->data as $rowt) {
            $idt_produto_abrangencia = $rowt['idt'];
        }





        $carga_horaria = aspa($carga_horaria_previsao);
        $datadia = trata_data(date('d/m/Y H:i:s'));
        $idt_cadastrador = $_SESSION[CS]['g_id_usuario'];
        $data_cadastro = aspa($datadia);


        //////////// 

        $sql_i = " insert into grc_produto ";
        $sql_i .= " (  ";
        $sql_i .= " idt_produto_situacao, ";
        $sql_i .= " idt_cadastrador, ";
        $sql_i .= " data_cadastro, ";
        $sql_i .= " carga_horaria, ";




        $sql_i .= " idt_secao_autora, ";
        $sql_i .= " idt_secao_responsavel, ";
        $sql_i .= " idt_grupo, ";
        $sql_i .= " idt_produto_tipo, ";
        $sql_i .= " idt_programa, ";
        $sql_i .= " idt_modalidade, ";
        $sql_i .= " idt_produto_maturidade, ";
        $sql_i .= " idt_produto_modelo_certificado, ";



        $sql_i .= " idt_instrumento, ";


        $sql_i .= " idt_produto_familia , ";
        $sql_i .= " idt_produto_canal_midia, ";
        $sql_i .= " idt_produto_abrangencia, ";
        $sql_i .= " idt_foco_tematico, ";
        $sql_i .= " objetivo, ";
        $sql_i .= " conteudo_programatico, ";

        $sql_i .= " codigo_classificacao_siac, ";




        $sql_i .= " codigo, ";
        $sql_i .= " ativo, ";
        $sql_i .= " descricao, ";

        $sql_i .= " codigo_siac, ";
        $sql_i .= " descricao_siac, ";

        $sql_i .= " proprio, ";
        $sql_i .= " copia, ";
        $sql_i .= " gratuito, ";
        $sql_i .= " detalhe, ";
        $sql_i .= " origem ";
        $sql_i .= "  ) values ( ";
        $sql_i .= " $idt_produto_situacao, ";
        $sql_i .= " $idt_cadastrador, ";
        $sql_i .= " $data_cadastro, ";
        $sql_i .= " $carga_horaria, ";




        $sql_i .= " $idt_secao_autora, ";
        $sql_i .= " $idt_secao_responsavel, ";
        $sql_i .= " $idt_grupo, ";
        $sql_i .= " $idt_produto_tipo, ";
        $sql_i .= " $idt_programa, ";
        $sql_i .= " $idt_modalidade, ";
        $sql_i .= " $idt_produto_maturidade, ";
        $sql_i .= " $idt_produto_modelo_certificado, ";

        $sql_i .= " $idt_instrumento, ";


        $sql_i .= " $idt_produto_familia , ";
        $sql_i .= " $idt_produto_canal_midia, ";
        $sql_i .= " $idt_produto_abrangencia, ";
        $sql_i .= " $idt_foco_tematico, ";
        $sql_i .= " $objetivo, ";
        $sql_i .= " $conteudo_programatico, ";

        $sql_i .= " $codigo_classificacao_siac, ";





        $sql_i .= " $codigo, ";
        $sql_i .= " $ativow, ";
        $sql_i .= " $descricao, ";
        $sql_i .= " $codigo_siac, ";
        $sql_i .= " $descricao_siac, ";
        $sql_i .= " $proprio, ";
        $sql_i .= " $copia, ";
        $sql_i .= " $gratuito, ";
        $sql_i .= " $detalhe, ";
        $sql_i .= " $origem ";


        $sql_i .= ") ";
        $grava = 1;
        if ($grava > 0) {
            $result = execsql($sql_i);
        } else {
            
        }
    }

    /*
      p($vetFamilia);
      p($vetFoco);
      p($vetCanalMidia);
      p($vetAbrangencia);
      p($vetSebraeResp);



      exit();
     */
}

//
// funções para Produtos siac - INSUMO
//
function ExecutaImportacao_Produto_siac_insumo($idt_importacao) {
    // Carregar txt para memória
    $sql = 'select ';
    $sql .= '  plu_ct.*   ';
    $sql .= '  from plu_converte_texto plu_ct ';
    $sql .= '  where plu_ct.idt=' . null($idt_importacao);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        return 2;
    }
    $arquivo = '';
    ForEach ($rs->data as $row) {
        $tipo = $row['tipo'];
        $arquivo_produto_siac_insumo = $row['arquivo_produto_siac_insumo'];
    }

    $sql_d = 'delete from grc_insumo ';
    $result = execsql($sql_d);

    $arquivow = basename($arquivo_produto_siac_insumo);
    $path = 'obj_file/plu_converte_texto/' . $arquivow;
    if (!file_exists($path)) {
        echo ' erro de arquivo inexistente ' . $path;
        return $kokw;
    }
    $arquivo = file("$path");
    $vetlinha = Array();
    foreach ($arquivo as $texto) {
        $cpos = Array();
        $texto = $texto . ';';
        //$cpos = explode(';', $texto);
        $cpos = str_getcsv($texto, ';');
        $vetlinha[] = $cpos;
    }
    $vetItemCusto = Array();

    $vetGrupoDespesa = Array();

    foreach ($vetlinha as $cpos) {
        $klinn = $klinn + 1;
        if ($klinn <= 1) {  // Linha de cabeçalho
            continue;
        }

        $familia_siac = $cpos[0];
        $codigo_siac = $cpos[1];

        $nome_produto = $cpos[2];
        $grupo_despesa = $cpos[3];
        $desc_grupo_despesa = $cpos[4];
        $codigo_item = $cpos[5];
        $descricao_item = $cpos[6];
        $ind_qtd_despesa = $cpos[7];
        $qtd_despesa = $cpos[8];
        $custo_despesa = $cpos[9];
        if ($custo_despesa == "") {
            $custo_despesa = 0;
        }

        $vetItemCusto [$codigo_item] = $descricao_item;
        $vetGrupoDespesa [$grupo_despesa] = $desc_grupo_despesa;


        $codigo = aspa(ZeroEsq($codigo_item, 4));
        $descricao = aspa($descricao_item);
        $ativo = aspa('S');
        $detalhe = aspa('');
        $classificacao = $codigo;


        $codigo_ig = ZeroEsq($grupo_despesa, 2);
        $sqlt = 'select ';
        $sqlt .= '  grc_iec.idt   ';
        $sqlt .= '  from grc_insumo_elemento_custo grc_iec ';
        $sqlt .= '  where grc_iec.codigo = ' . aspa($codigo_ig);
        $rst = execsql($sqlt);

        $idt_insumo_elemento_custo = 'null';
        ForEach ($rst->data as $rowt) {
            $idt_insumo_elemento_custo = $rowt['idt'];
        }

        $idt_insumo_unidade = 3;
        $custo_unitario_real = $custo_despesa;
        $por_participante = aspa('S');
        $nivel = aspa('S');
        $sinal = aspa('S');
        $codigo_rm = aspa('');
        //


        $sqlt = 'select ';
        $sqlt .= '  grc_i.idt, custo_unitario_real   ';
        $sqlt .= '  from grc_insumo grc_i ';
        $sqlt .= '  where grc_i.codigo = ' . ($codigo);
        $rst = execsql($sqlt);
        if ($rst->rows == 0) {
            $sql_i = " insert into grc_insumo ";
            $sql_i .= " (  ";
            $sql_i .= " idt_insumo_elemento_custo, ";
            $sql_i .= " codigo, ";
            $sql_i .= " descricao, ";
            $sql_i .= " ativo, ";
            $sql_i .= " classificacao, ";
            $sql_i .= " idt_insumo_unidade, ";
            $sql_i .= " custo_unitario_real, ";
            $sql_i .= " por_participante, ";
            $sql_i .= " nivel, ";
            $sql_i .= " sinal, ";
            $sql_i .= " codigo_rm, ";
            $sql_i .= " detalhe ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $idt_insumo_elemento_custo, ";
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao, ";
            $sql_i .= " $ativo, ";
            $sql_i .= " $classificacao, ";
            $sql_i .= " $idt_insumo_unidade, ";
            $sql_i .= " $custo_unitario_real, ";
            $sql_i .= " $por_participante, ";
            $sql_i .= " $nivel, ";
            $sql_i .= " $sinal, ";
            $sql_i .= " $codigo_rm, ";
            $sql_i .= " $detalhe ";
            $sql_i .= ") ";
            $result = execsql($sql_i);
        } else {
            $idt_insumo = 'null';
            ForEach ($rst->data as $rowt) {
                $idt_insumo = $rowt['idt'];
                $custo_unitario_realw = $rowt['custo_unitario_real'];
                if ($custo_unitario_realw < $custo_unitario_real) {
                    $sql_a = ' update grc_insumo set ';
                    $sql_a .= ' custo_unitario_real  = ' . $custo_unitario_real . '  ';
                    $sql_a .= ' where idt = ' . null($idt_insumo) . '  ';
                    $result = execsql($sql_a);
                }
            }
        }
    }

    p($vetGrupoDespesa);

    p($vetItemCusto);


    //exit();     
}

//
// Conversão dos arquivos do SGE
//
function ExecutaImportacao_Projeto($idt_importacao, $path_csv) {
    // Carregar txt para memória
    $sql = 'select ';
    $sql .= '  plu_ct.*   ';
    $sql .= '  from plu_converte_texto plu_ct ';
    $sql .= '  where plu_ct.idt=' . null($idt_importacao);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        return 2;
    }
    $arquivo = '';
    ForEach ($rs->data as $row) {
        $tipo = $row['tipo'];
        $arquivo = $row['arquivo_projeto'];
    }

    $arquivow = basename($arquivo);
    $path = $path_csv . $arquivow;
    if (!file_exists($path)) {
        echo ' erro de arquivo inexistente ' . $path;
        return $kokw;
    }
    $arquivo = file("$path");
    $vetlinha = Array();

    $sql = '';
    $sql .= ' select login, id_usuario, cpf, codparceiro_siacweb';
    $sql .= ' from plu_usuario';
    $sql .= ' where cpf is not null';
    $rs = execsql($sql);

    $vetUsuario = Array();

    foreach ($rs->data as $row) {
        $vetUsuario[$row['login']] = $row;
    }

    foreach ($arquivo as $texto) {
        $cpos = Array();
        $texto = $texto . ';';
        //$cpos = explode(';', $texto);
        $cpos = str_getcsv($texto, ';');
        $vetlinha[] = $cpos;
    }
    foreach ($vetlinha as $cpos) {
        $klinn = $klinn + 1;
        if ($klinn <= 1) {  // Linha de cabeçalho
            continue;
        }
        $CodProjeto = $cpos[0];
        $NomeProjeto = $cpos[1];
        $Gestor = $cpos[2];
        $Login = $cpos[3];
        //
        $codigo = aspa($CodProjeto);
        $codigo_sge = aspa($CodProjeto);
        $descricao = aspa($NomeProjeto);
        $gestor = aspa($Gestor);
        $ativo = aspa('S');

        $cpf_responsavel = aspa($vetUsuario[$Login]['cpf']);
        $codparceiro_siacweb = null($vetUsuario[$Login]['codparceiro_siacweb']);
        $idt_responsavel = null($vetUsuario[$Login]['id_usuario']);

        //
        $sqlt = 'select ';
        $sqlt .= '  grc_p.idt   ';
        $sqlt .= '  from grc_projeto grc_p ';
        $sqlt .= "  where grc_p.codigo_sge =  $codigo_sge ";
        $rst = execsql($sqlt);
        if ($rst->rows == 0) {
            $sql_i = " insert into grc_projeto ";
            $sql_i .= " (  ";
            $sql_i .= " codigo, ";
            $sql_i .= " codigo_sge, ";
            $sql_i .= " descricao, ";
            $sql_i .= " ativo, ";
            $sql_i .= " cpf_responsavel, ";
            $sql_i .= " codparceiro_siacweb, ";
            $sql_i .= " idt_responsavel, ";
            $sql_i .= " gestor ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $codigo, ";
            $sql_i .= " $codigo_sge, ";
            $sql_i .= " $descricao, ";
            $sql_i .= " $ativo, ";
            $sql_i .= " $cpf_responsavel, ";
            $sql_i .= " $codparceiro_siacweb, ";
            $sql_i .= " $idt_responsavel, ";
            $sql_i .= " $gestor ";
            $sql_i .= ") ";
            $result = execsql($sql_i);
        } else {
            ForEach ($rst->data as $rowt) {
                $idt = $rowt['idt'];
            }
            $sql_a = ' update grc_projeto set ';
            $sql_a .= ' codigo     = ' . $codigo . ',  ';
            $sql_a .= ' descricao  = ' . $descricao . ',  ';
            $sql_a .= ' cpf_responsavel  = ' . $cpf_responsavel . ',  ';
            $sql_a .= ' codparceiro_siacweb  = ' . $codparceiro_siacweb . ',  ';
            $sql_a .= ' idt_responsavel  = ' . $idt_responsavel . ',  ';
            $sql_a .= ' gestor     = ' . $gestor . '  ';
            $sql_a .= ' where idt  = ' . null($idt) . '  ';
            $result = execsql($sql_a);
        }
    }

    //exit();
}

function ExecutaImportacao_Projeto_acao($idt_importacao, $vetContrapartidaSgtec, $path_csv) {
    // Carregar txt para memória
    $sql = 'select ';
    $sql .= '  plu_ct.*   ';
    $sql .= '  from plu_converte_texto plu_ct ';
    $sql .= '  where plu_ct.idt=' . null($idt_importacao);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        return 2;
    }
    $arquivo = '';
    ForEach ($rs->data as $row) {
        $tipo = $row['tipo'];
        $arquivo = $row['arquivo_projeto_acao'];
    }

    //$sql_d = 'delete from grc_projeto ';
    //$result = execsql($sql_d);

    $arquivow = basename($arquivo);
    $path = $path_csv . $arquivow;
    if (!file_exists($path)) {
        echo ' erro de arquivo inexistente ' . $path;
        return $kokw;
    }

    $sql = '';
    $sql .= ' select login, id_usuario, cpf, codparceiro_siacweb';
    $sql .= ' from plu_usuario';
    $sql .= ' where cpf is not null';
    $rs = execsql($sql);

    $vetUsuario = Array();

    foreach ($rs->data as $row) {
        $vetUsuario[$row['login']] = $row;
    }

    $sql = '';
    $sql .= ' select idt, unidadeoperacional_sge';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
    $sql .= ' where unidadeoperacional_sge is not null';
    $sql .= " and unidadeoperacional_sge <> ''";
    $rs = execsql($sql);

    $vetUnidade = Array();

    foreach ($rs->data as $row) {
        $vetUnidade[$row['unidadeoperacional_sge']] = $row['idt'];
    }

    $sql = '';
    $sql .= ' select idt, codigo_sge';
    $sql .= ' from grc_projeto';
    $rs = execsql($sql);

    $vetProjeto = Array();

    foreach ($rs->data as $row) {
        $vetProjeto[$row['codigo_sge']] = $row['idt'];
    }

    $arquivo = file("$path");
    $vetlinha = Array();
    foreach ($arquivo as $texto) {
        $cpos = Array();
        $texto = $texto . ';';
        //$cpos = explode(';', $texto);
        $cpos = str_getcsv($texto, ';');
        $vetlinha[] = $cpos;
    }
    foreach ($vetlinha as $cpos) {
        $klinn = $klinn + 1;
        if ($klinn <= 1) {  // Linha de cabeçalho
            continue;
        }
        $CodProjeto = $cpos[0];
        $CodProjetoAcao = $cpos[1];
        $NomeProjetoAcao = $cpos[2];
        $detalhe = $cpos[3];
        $codgestor = $cpos[4];
        $nomegestor = $cpos[5];
        $usuario = $cpos[6];
        $codunidade = $cpos[7];
        $nomeunidade = $cpos[8];

        $cpf_responsavel = aspa($vetUsuario[$usuario]['cpf']);
        $codparceiro_siacweb = null($vetUsuario[$usuario]['codparceiro_siacweb']);
        $idt_responsavel = null($vetUsuario[$usuario]['id_usuario']);
        $idt_unidade = null($vetUnidade[$codunidade]);
        $idt_projeto = null($vetProjeto[$CodProjeto]);

        $codigo_proj = aspa($CodProjeto);
        $codigo = aspa($CodProjetoAcao);
        $codigo_sge = aspa($CodProjetoAcao);
        $descricao = aspa($NomeProjetoAcao);
        $detalhe = aspa($detalhe);
        $ativo = aspa('S');

        $codgestor = aspa($codgestor);
        $nomegestor = aspa($nomegestor);
        $usuario = aspa($usuario);
        $codunidade = aspa($codunidade);
        $nomeunidade = aspa($nomeunidade);

		$contrapartida_sgtec = null($vetContrapartidaSgtec[$CodProjetoAcao]);

        $sqlt = 'select ';
        $sqlt .= '  grc_pa.idt   ';
        $sqlt .= '  from grc_projeto_acao grc_pa ';
        //$sqlt .= "  where grc_pa.codigo_proj =  $codigo_proj ";
        $sqlt .= "    where grc_pa.codigo_sge  =  $codigo_sge ";
        $rst = execsql($sqlt);
        if ($rst->rows == 0) {
            $sql_i = " insert into grc_projeto_acao ";
            $sql_i .= " (  ";
            $sql_i .= " codigo_proj, ";
            $sql_i .= " codigo, ";
            $sql_i .= " codigo_sge, ";
            $sql_i .= " descricao, ";
            $sql_i .= " ativo, ";
            $sql_i .= " cpf_responsavel, ";
            $sql_i .= " codparceiro_siacweb, ";
            $sql_i .= " idt_responsavel, ";
            $sql_i .= " codgestor, ";
            $sql_i .= " nomegestor, ";
            $sql_i .= " usuario, ";
            $sql_i .= " codunidade, ";
            $sql_i .= " nomeunidade, ";
            $sql_i .= " idt_unidade, ";
            $sql_i .= " contrapartida_sgtec, ";
            $sql_i .= " idt_projeto, ";
            $sql_i .= " detalhe ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $codigo_proj, ";
            $sql_i .= " $codigo, ";
            $sql_i .= " $codigo_sge, ";
            $sql_i .= " $descricao, ";
            $sql_i .= " $ativo, ";
            $sql_i .= " $cpf_responsavel, ";
            $sql_i .= " $codparceiro_siacweb, ";
            $sql_i .= " $idt_responsavel, ";
            $sql_i .= " $codgestor, ";
            $sql_i .= " $nomegestor, ";
            $sql_i .= " $usuario, ";
            $sql_i .= " $codunidade, ";
            $sql_i .= " $nomeunidade, ";
            $sql_i .= " $idt_unidade, ";
            $sql_i .= " $contrapartida_sgtec, ";
            $sql_i .= " $idt_projeto, ";
            $sql_i .= " $detalhe ";
            $sql_i .= ") ";
            $result = execsql($sql_i);
        } else {
            ForEach ($rst->data as $rowt) {
                $idt = $rowt['idt'];
            }
            $sql_a = ' update grc_projeto_acao set ';
            $sql_a .= ' codigo_proj = ' . $codigo_proj . ',  ';
            $sql_a .= ' codigo      = ' . $codigo . ',  ';
            $sql_a .= ' descricao   = ' . $descricao . ',  ';
            $sql_a .= ' cpf_responsavel   = ' . $cpf_responsavel . ',  ';
            $sql_a .= ' codparceiro_siacweb   = ' . $codparceiro_siacweb . ',  ';
            $sql_a .= ' idt_responsavel   = ' . $idt_responsavel . ',  ';
            $sql_a .= ' codgestor   = ' . $codgestor . ',  ';
            $sql_a .= ' nomegestor   = ' . $nomegestor . ',  ';
            $sql_a .= ' usuario   = ' . $usuario . ',  ';
            $sql_a .= ' codunidade   = ' . $codunidade . ',  ';
            $sql_a .= ' nomeunidade   = ' . $nomeunidade . ',  ';
            $sql_a .= ' idt_unidade   = ' . $idt_unidade . ',  ';
            $sql_a .= ' contrapartida_sgtec   = ' . $contrapartida_sgtec . ',  ';
            $sql_a .= ' idt_projeto   = ' . $idt_projeto . ',  ';
            $sql_a .= ' detalhe     = ' . $detalhe . '  ';
            $sql_a .= ' where idt   = ' . null($idt) . '  ';
            $result = execsql($sql_a);
        }
    }
}

function ExecutaImportacao_Projeto_etapa($idt_importacao, $path_csv) {
    // Carregar txt para memória
    $sql = 'select ';
    $sql .= '  plu_ct.*   ';
    $sql .= '  from plu_converte_texto plu_ct ';
    $sql .= '  where plu_ct.idt=' . null($idt_importacao);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        return 2;
    }
    $arquivo = '';
    ForEach ($rs->data as $row) {
        $tipo = $row['tipo'];
        $arquivo = $row['arquivo_projeto_etapa'];
    }
    //$sql_d = 'delete from grc_projeto ';
    //$result = execsql($sql_d);
    $arquivow = basename($arquivo);
    $path = $path_csv . $arquivow;
    if (!file_exists($path)) {
        echo ' erro de arquivo inexistente ' . $path;
        return $kokw;
    }
    $arquivo = file("$path");
    $vetlinha = Array();
    foreach ($arquivo as $texto) {
        $cpos = Array();
        $texto = $texto . ';';
        //$cpos = explode(';', $texto);
        $cpos = str_getcsv($texto, ';');
        $vetlinha[] = $cpos;
    }
    $vetEtapa = Array();
    foreach ($vetlinha as $cpos) {
        $klinn = $klinn + 1;
        if ($klinn <= 1) {  // Linha de cabeçalho
            continue;
        }
        $CodProjeto = $cpos[0];
        $CodEtapa = $cpos[1];
        $NomeEtapa = $cpos[2];
        //
        $codigo = aspa($CodEtapa);
        $descricao = aspa($NomeEtapa);
        $ativo = aspa('S');
        //
        $sqlt = 'select ';
        $sqlt .= '  grc_ps.idt   ';
        $sqlt .= '  from grc_projeto_situacao grc_ps ';
        $sqlt .= "  where grc_ps.codigo =  $codigo ";
        $rst = execsql($sqlt);
        if ($rst->rows == 0) {
            $sql_i = " insert into grc_projeto_situacao ";
            $sql_i .= " (  ";
            $sql_i .= " codigo, ";
            $sql_i .= " descricao, ";
            $sql_i .= " ativo ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao, ";
            $sql_i .= " $ativo ";
            $sql_i .= ") ";
            $result = execsql($sql_i);
            $idt = lastInsertId();
            $vetEtapa[$CodProjeto] = $idt;
        } else {
            ForEach ($rst->data as $rowt) {
                $idt = $rowt['idt'];
            }
            $sql_a = ' update grc_projeto_situacao set ';
            $sql_a .= ' codigo      = ' . $codigo . ',  ';
            $sql_a .= ' descricao   = ' . $descricao . '  ';
            $sql_a .= ' where idt   = ' . null($idt) . '  ';
            $result = execsql($sql_a);
            $vetEtapa[$CodProjeto] = $idt;
        }
    }

    $sqlt = 'select ';
    $sqlt .= '  grc_p.idt, grc_p.codigo_sge   ';
    $sqlt .= '  from grc_projeto grc_p ';
    $rst = execsql($sqlt);
    if ($rst->rows == 0) {
        
    } else {
        ForEach ($rst->data as $rowt) {
            $idt = $rowt['idt'];
            $CodProjeto = $rowt['codigo_sge'];

            $idt_situacao = $vetEtapa[$CodProjeto];



            $sql_a = ' update grc_projeto set ';
            $sql_a .= ' idt_projeto_situacao = ' . null($idt_situacao) . '  ';
            $sql_a .= ' where idt   = ' . null($idt) . '  ';
            $result = execsql($sql_a);
        }
    }
}

function ExecutaImportacao_Projeto_acao_metrica_fisica_ano($idt_importacao, $path_csv) {
    // Carregar txt para memória

    $sql = 'select ';
    $sql .= '  plu_ct.*   ';
    $sql .= '  from plu_converte_texto plu_ct ';
    $sql .= '  where plu_ct.idt=' . null($idt_importacao);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        return 2;
    }

    $arquivo = '';
    ForEach ($rs->data as $row) {
        $tipo = $row['tipo'];
        $arquivo = $row['arquivo_projeto_acao_metrica_fisica_ano'];
    }

    $arquivow = basename($arquivo);
    $path = $path_csv . $arquivow;
    if (!file_exists($path)) {
        echo ' erro de arquivo inexistente ' . $path;
        return $kokw;
    }
    $arquivo = file("$path");
    $vetlinha = Array();

    foreach ($arquivo as $texto) {
        $cpos = Array();
        $texto = $texto . ';';
        //$cpos = explode(';', $texto);
        $cpos = str_getcsv($texto, ';');
        $vetlinha[] = $cpos;
    }

    $sqlt = 'select ';
    $sqlt .= '  idt, codigo_sge   ';
    $sqlt .= '  from grc_projeto_acao ';
    $rst = execsql($sqlt);

    $vetAcao = Array();
    ForEach ($rst->data as $rowt) {
        $vetAcao[$rowt['codigo_sge']] = $rowt['idt'];
    }

    $vetInstrumento = Array();
    $vetMetrica = Array();

    $klinn = 0;
    foreach ($vetlinha as $cpos) {
        $klinn = $klinn + 1;
        if ($klinn <= 1) {  // Linha de cabeçalho
            continue;
        }

        $CodProjeto = $cpos[0];
        $CodAcao = $cpos[1];
        $CodInstrumento = $cpos[2];
        $Instrumento = $cpos[3];
        $CodMetrica = $cpos[4];
        $Metrica = $cpos[5];
        $Ano = $cpos[6];
        $Quantidade = $cpos[7];

        // Instrumentos
        $CodInstrumento = ZeroEsq($CodInstrumento, 2);
        $CodMetrica = ZeroEsq($CodMetrica, 2);
        $codigo = aspa($CodInstrumento);
        $descricao = aspa($Instrumento);
        $ativo = aspa('S');
        $ano = aspa($Ano);
        $mes = aspa('12');

        $quantitativo = $Quantidade;

        $codigo_projeto = aspa($cpos[0]);
        $codigo_acao = aspa($cpos[1]);
        $codigo_instrumento = aspa($cpos[2]);
        $instrumento = aspa($cpos[3]);
        $codigo_metrica = aspa($cpos[4]);
        $metrica = aspa($cpos[5]);

        $idt_projeto_acao = $vetAcao[$CodAcao];

        if ($idt_projeto_acao != '') {
            if ($vetInstrumento[$CodInstrumento] == '') {
                $sqlt = 'select ';
                $sqlt .= '  grc_ai.idt   ';
                $sqlt .= '  from grc_atendimento_instrumento grc_ai ';
                $sqlt .= "  where grc_ai.codigo_sge =  $codigo ";
                $rst = execsql($sqlt);

                if ($rst->rows == 0) {
                    $sql_i = " insert into grc_atendimento_instrumento ";
                    $sql_i .= " (  ";
                    $sql_i .= " codigo, ";
                    $sql_i .= " codigo_sge, ";
                    $sql_i .= " descricao, ";
                    $sql_i .= " ativo ";
                    $sql_i .= "  ) values ( ";
                    $sql_i .= " $codigo, ";
                    $sql_i .= " $codigo, ";
                    $sql_i .= " $descricao, ";
                    $sql_i .= " $ativo ";
                    $sql_i .= ") ";
                    $result = execsql($sql_i);
                    $vetInstrumento[$CodInstrumento] = lastInsertId();
                } else {
                    $vetInstrumento[$CodInstrumento] = $rst->data[0][0];
                }
            }

            if ($vetMetrica[$CodMetrica] == '') {
                $sqlt = 'select ';
                $sqlt .= '  grc_am.idt   ';
                $sqlt .= '  from grc_atendimento_metrica grc_am ';
                $sqlt .= "  where grc_am.codigo =  $codigo_metrica ";
                $rst = execsql($sqlt);
                if ($rst->rows == 0) {
                    $sql_i = " insert into grc_atendimento_metrica ";
                    $sql_i .= " (  ";
                    $sql_i .= " codigo, ";
                    $sql_i .= " descricao, ";
                    $sql_i .= " ativo ";
                    $sql_i .= "  ) values ( ";
                    $sql_i .= " $codigo_metrica, ";
                    $sql_i .= " $metrica, ";
                    $sql_i .= " $ativo ";
                    $sql_i .= ") ";
                    $result = execsql($sql_i);
                    $vetMetrica[$CodMetrica] = lastInsertId();
                } else {
                    $sql_a = ' update grc_atendimento_metrica set ';
                    $sql_a .= ' descricao   = ' . $metrica . '  ';
                    $sql_a .= ' where idt   = ' . null($rst->data[0][0]) . '  ';
                    $result = execsql($sql_a);
                    $vetMetrica[$CodMetrica] = $rst->data[0][0];
                }
            }

            $idt_instrumento = $vetInstrumento[$CodInstrumento];
            $idt_metrica = $vetMetrica[$CodMetrica];

            $sqlt = 'select ';
            $sqlt .= '  grc_pm.idt   ';
            $sqlt .= '  from grc_projeto_acao_meta grc_pm ';
            $sqlt .= "  where grc_pm.idt_projeto_acao =  $idt_projeto_acao ";
            $sqlt .= "    and grc_pm.codigo_instrumento  =  " . aspa($cpos[2]);
            $sqlt .= "    and grc_pm.codigo_metrica      =  " . aspa($cpos[4]);
            $sqlt .= "    and grc_pm.ano              =  $ano ";
            $sqlt .= "    and grc_pm.mes              =  $mes ";
            $rst = execsql($sqlt);

            if ($rst->rows == 0) {
                $sql_i = " insert into grc_projeto_acao_meta ";
                $sql_i .= " (  ";
                $sql_i .= " idt_projeto_acao, ";
                $sql_i .= " ano, ";
                $sql_i .= " mes, ";
                $sql_i .= " idt_instrumento, ";
                $sql_i .= " idt_metrica, ";
                $sql_i .= " quantitativo, ";
                $sql_i .= " codigo_projeto, ";
                $sql_i .= " codigo_acao,   ";
                $sql_i .= " codigo_instrumento, ";
                $sql_i .= " instrumento, ";
                $sql_i .= " codigo_metrica, ";
                $sql_i .= " metrica ";
                $sql_i .= "  ) values ( ";
                $sql_i .= " $idt_projeto_acao, ";
                $sql_i .= " $ano, ";
                $sql_i .= " $mes, ";
                $sql_i .= " $idt_instrumento, ";
                $sql_i .= " $idt_metrica, ";
                $sql_i .= " $quantitativo, ";
                $sql_i .= " $codigo_projeto, ";
                $sql_i .= " $codigo_acao,   ";
                $sql_i .= " $codigo_instrumento, ";
                $sql_i .= " $instrumento, ";
                $sql_i .= " $codigo_metrica, ";
                $sql_i .= " $metrica ";
                $sql_i .= ") ";
                $result = execsql($sql_i);
            } else {
                $sql_a = ' update grc_projeto_acao_meta set ';
                $sql_a .= ' codigo_instrumento = ' . $codigo_instrumento . ',  ';
                $sql_a .= ' instrumento = ' . $instrumento . ',  ';
                $sql_a .= ' codigo_metrica = ' . $codigo_metrica . ',  ';
                $sql_a .= ' metrica = ' . $metrica . ',  ';
                $sql_a .= ' quantitativo = ' . $quantitativo . ',  ';
                $sql_a .= ' idt_instrumento = ' . $idt_instrumento . ',  ';
                $sql_a .= ' idt_metrica = ' . $idt_metrica . '  ';
                $sql_a .= ' where idt   = ' . null($rst->data[0][0]) . '  ';
                $result = execsql($sql_a);
            }
        }
    }
}

function ExecutaImportacao_Projeto_acao_metrica_orcamento_ano($idt_importacao, $path_csv) {
    // Carregar txt para memória



    $sql = 'select ';
    $sql .= '  plu_ct.*   ';
    $sql .= '  from plu_converte_texto plu_ct ';
    $sql .= '  where plu_ct.idt=' . null($idt_importacao);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        return 2;
    }
    $arquivo = '';
    ForEach ($rs->data as $row) {
        $tipo = $row['tipo'];
        $arquivo = $row['arquivo_projeto_acao_metrica_orcamento_ano'];
    }

    $arquivow = basename($arquivo);
    $path = $path_csv . $arquivow;
    if (!file_exists($path)) {
        echo ' erro de arquivo inexistente ' . $path;
        return $kokw;
    }
    $arquivo = file("$path");
    $vetlinha = Array();

    $n = 0;
    foreach ($arquivo as $texto) {
        $n = $n + 1;
        $cpos = Array();
        $texto = $texto . ';';
        //$cpos = explode(';', $texto);
        $cpos = str_getcsv($texto, ';');
        $vetlinha[] = $cpos;
    }

    $sqlt = 'select ';
    $sqlt .= '  idt, codigo_sge   ';
    $sqlt .= '  from grc_projeto_acao ';
    $rst = execsql($sqlt);

    $vetAcao = Array();
    ForEach ($rst->data as $rowt) {
        $vetAcao[$rowt['codigo_sge']] = $rowt['idt'];
    }

    $klinn = 0;
    foreach ($vetlinha as $cpos) {

        $klinn = $klinn + 1;
        if ($klinn <= 1) {  // Linha de cabeçalho
            continue;
        }

        if ($vetAcao[$cpos[1]] != '') {
            $codpratif = aspa($cpos[0]);
            $idt_projeto_acao = null($vetAcao[$cpos[1]]);
            $codacao = aspa($cpos[1]);
            $anoprevisao = null($cpos[2]);
            $dtoperacao_ultima = aspa(substr($cpos[3], 0, 19));
            $codentidade_fin = aspa($cpos[4]);
            $entidade_financeira = aspa($cpos[5]);
            $codetapapratif = aspa($cpos[6]);
            $operacao = aspa($cpos[7]);
            $codtipoprevisao = null($cpos[8]);
            $descprevisao = aspa($cpos[9]);
            $ativo = aspa($cpos[10]);
            $vlprevisto = null($cpos[11]);
            $codprocesso = aspa($cpos[12]);
            $codfase = aspa($cpos[13]);
            $descfase = aspa($cpos[14]);
            $codentidade_inicio = aspa($cpos[15]);
            $codentidade_fim = aspa($cpos[16]);

            $sqlt = 'select ';
            $sqlt .= '  grc_pm.idt   ';
            $sqlt .= '  from grc_projeto_acao_orcamentaria grc_pm ';
            $sqlt .= "  where grc_pm.codacao         = " . $codacao;
            $sqlt .= "    and grc_pm.anoprevisao     = " . $anoprevisao;
            $rst = execsql($sqlt);

            if ($rst->rows == 0) {
                $sql_i = " insert into grc_projeto_acao_orcamentaria ";
                $sql_i .= " (  ";
                $sql_i .= " idt_projeto_acao, ";
                $sql_i .= " codpratif, ";
                $sql_i .= " codacao, ";
                $sql_i .= " anoprevisao, ";
                $sql_i .= " dtoperacao_ultima, ";
                $sql_i .= " codentidade_fin, ";
                $sql_i .= " entidade_financeira, ";
                $sql_i .= " codetapapratif,   ";
                $sql_i .= " operacao, ";
                $sql_i .= " codtipoprevisao, ";
                $sql_i .= " descprevisao, ";
                $sql_i .= " ativo, ";
                $sql_i .= " vlprevisto, ";
                $sql_i .= " codprocesso, ";
                $sql_i .= " codfase, ";
                $sql_i .= " descfase, ";
                $sql_i .= " codentidade_inicio, ";
                $sql_i .= " codentidade_fim ";
                $sql_i .= "  ) values ( ";
                $sql_i .= " $idt_projeto_acao, ";
                $sql_i .= " $codpratif, ";
                $sql_i .= " $codacao, ";
                $sql_i .= " $anoprevisao, ";
                $sql_i .= " $dtoperacao_ultima, ";
                $sql_i .= " $codentidade_fin, ";
                $sql_i .= " $entidade_financeira, ";
                $sql_i .= " $codetapapratif,   ";
                $sql_i .= " $operacao, ";
                $sql_i .= " $codtipoprevisao, ";
                $sql_i .= " $descprevisao, ";
                $sql_i .= " $ativo, ";
                $sql_i .= " $vlprevisto, ";
                $sql_i .= " $codprocesso, ";
                $sql_i .= " $codfase, ";
                $sql_i .= " $descfase, ";
                $sql_i .= " $codentidade_inicio, ";
                $sql_i .= " $codentidade_fim ";
                $sql_i .= ") ";
                $result = execsql($sql_i);
            } else {
                ForEach ($rst->data as $rowt) {
                    $idt = $rowt['idt'];
                }
                $sql_a = ' update grc_projeto_acao_orcamentaria set ';
                $sql_a .= ' idt_projeto_acao = ' . $idt_projeto_acao . ',';
                $sql_a .= ' codpratif = ' . $codpratif . ',';
                $sql_a .= ' codacao = ' . $codacao . ',';
                $sql_a .= ' anoprevisao = ' . $anoprevisao . ',';
                $sql_a .= ' dtoperacao_ultima = ' . $dtoperacao_ultima . ',';
                $sql_a .= ' codentidade_fin = ' . $codentidade_fin . ',';
                $sql_a .= ' entidade_financeira = ' . $entidade_financeira . ',';
                $sql_a .= ' codetapapratif = ' . $codetapapratif . ',';
                $sql_a .= ' operacao = ' . $operacao . ',';
                $sql_a .= ' codtipoprevisao = ' . $codtipoprevisao . ',';
                $sql_a .= ' descprevisao = ' . $descprevisao . ',';
                $sql_a .= ' ativo = ' . $ativo . ',';
                $sql_a .= ' vlprevisto = ' . $vlprevisto . ',';
                $sql_a .= ' codprocesso = ' . $codprocesso . ',';
                $sql_a .= ' codfase = ' . $codfase . ',';
                $sql_a .= ' descfase = ' . $descfase . ',';
                $sql_a .= ' codentidade_inicio = ' . $codentidade_inicio . ',';
                $sql_a .= ' codentidade_fim = ' . $codentidade_fim;
                $sql_a .= ' where idt   = ' . null($idt) . '  ';
                $result = execsql($sql_a);
            }
        }
    }
}

function ExecutaAjuste_projetos_SiacWeb($idt_importacao) {
    $sqlt = 'select ';
    $sqlt .= '  grc_p.*,   ';
    $sqlt .= '  grc_pa.*,   ';
    $sqlt .= '  grc_p.idt          as grc_p_idt,    ';
    $sqlt .= '  grc_pa.idt         as grc_pa_idt,   ';
    $sqlt .= '  grc_p.codigo       as grc_p_codigo,  ';
    $sqlt .= '  grc_pa.codigo_proj as grc_pa_codigo_proj,  ';
    $sqlt .= '  grc_pa.codigo      as grc_pa_codigo  ';
    $sqlt .= '  from grc_projeto grc_p ';
    $sqlt .= '  inner join grc_projeto_acao grc_pa on grc_pa.idt_projeto = grc_p.idt ';
    $sqlt .= "  order by grc_p.codigo ";
    $rst = execsql($sqlt);
    if ($rst->rows == 0) {
        // Nada
    } else {

        ForEach ($rst->data as $rowt) {
            $grc_p_idt = $rowt['grc_p_idt'];
            $grc_pa_idt = $rowt['grc_pa_idt'];
            //
            $grc_p_codigo = $rowt['grc_p_codigo'];
            $grc_pa_codigo = $rowt['grc_pa_codigo'];
            //
            $grc_pa_codigo_proj = $rowt['grc_pa_codigo_proj'];
            //
            // Acessa a tabela de projetos - acao do Siac Cache
            //

            $sqltw = 'select ';
            $sqltw .= '  siac_ba_pa.*   ';
            $sqltw .= '  from  ' . db_pir_siac . 'tbpaiacao siac_ba_pa ';
            $sqltw .= "  where ativo = 'S'  ";
            $sqltw .= "    and codpratif = " . aspa($grc_p_codigo);
            $sqltw .= "    and codacao   = " . aspa($grc_pa_codigo);
            $rstw = execsql($sqltw);
            if ($rstw->rows == 0) {
                // Nada
            } else {
                ForEach ($rstw->data as $rowtw) {
                    $codpratif = $rowtw['codpratif'];
                    $codacao = $rowtw['codacao_seq'];
                    $sql_a = ' update grc_projeto_acao set ';

                    $sql_a .= ' ativo_siacweb = ' . aspa('S') . ',  ';
                    $sql_a .= ' existe_siacweb = ' . aspa('S') . ',  ';
                    $sql_a .= ' codigo_siacweb = ' . null($codacao) . '  ';

                    $sql_a .= ' where idt = ' . null($grc_pa_idt) . '  ';

                    $result = execsql($sql_a);

                    $sql_a = ' update grc_projeto set ';
                    $sql_a .= ' ativo_siacweb = ' . aspa('S') . ',  ';
                    $sql_a .= ' existe_siacweb = ' . aspa('S') . '  ';
                    $sql_a .= ' where idt = ' . null($grc_p_idt) . '  ';

                    $result = execsql($sql_a);
                }
            }
        }
    }
}

function numerador_arquivo($tabela, $Campo, $tam) {
    global $host, $bd_user, $password, $tipodb;
    $valorw = ZeroEsq('0', $tam);
    $tcon = new_pdo($host, $bd_user, $password, $tipodb);

    if ($tipodb == 'mssql') {
        $tcon->exec('BEGIN TRANSACTION TIPO');
    } else {
        $tcon->beginTransaction();
    }

    if ($tipodb == 'mssql' || $tipodb == 'sqlsrv') {
        $sql_auto = "select idt from plu_autonum where codigo = " . aspa($tabela . "_" . $Campo);
    } else {
        $sql_auto = "select idt from plu_autonum where codigo = " . aspa($tabela . "_" . $Campo) . ' FOR UPDATE';
    }

    $rs_auto = $tcon->query($sql_auto);
    $data_auto = $rs_auto->fetchAll(PDO::FETCH_BOTH);

    if (count($data_auto) == 0) {
        $sql_auto = "insert into plu_autonum (codigo, idt) values (" .
                aspa($tabela . "_" . $Campo) . ", 1)";
        $tcon->exec($sql_auto);
        $sql_valor .= aspa(ZeroEsq(1, $tam));
        $valorw = ZeroEsq(1, $tam);
    } else {
        $data_auto[0][0] = $data_auto[0][0] + 1;
        $sql_auto = "update plu_autonum set idt = " . $data_auto[0][0] . "
                    where codigo = " . aspa($tabela . "_" . $Campo);
        $tcon->exec($sql_auto);
        $valorw = ZeroEsq($data_auto[0][0], $tam);
        $sql_valor .= aspa(ZeroEsq($data_auto[0][0], $tam));
    }

    if ($tipodb == 'mssql')
        $tcon->exec('COMMIT TRANSACTION TIPO');
    else
        $tcon->commit();
    $tcon = NULL;
    return $valorw;
}

function ChamaAtendimentox($idt_atendimento_agenda, $idt_cliente, &$variavel) {
    $kokw = 0;

    $sql_aa = ' select idt_atendimento_agenda, status_painel from grc_atendimento_agenda_painel ';
    $sql_aa .= ' where  idt_atendimento_agenda = ' . null($idt_atendimento_agenda);
    $result = execsql($sql_aa);

    if ($result->rows == 0) {
        return 2;
    }

    $sql_a = " update grc_atendimento_agenda_painel set ";
    $sql_a .= " status_painel = '20'";
    $sql_a .= " where idt  = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);

    $kokw = 1;
    return $kokw;
}

function BloqueiaHorariox($idt_atendimento_agenda, &$variavel) {
    $kokw = 0;

    $sql_a = ' update grc_atendimento_agenda set ';
    $sql_a .= " situacao          = 'Bloqueado'";
    $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
    $result = execsql($sql_a);



    $kokw = 1;
    return $kokw;
}

function DesbloqueiaHorariox($idt_atendimento_agenda, &$variavel) {
    $kokw = 0;

    $sql_a = ' update grc_atendimento_agenda set ';
    $sql_a .= " situacao          = 'Agendado'";
    $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
    $result = execsql($sql_a);



    $kokw = 1;
    return $kokw;
}

function CancelaAgendamentox($idt_atendimento_agenda, &$variavel) {
    $kokw = 0;

    $sql_a = ' update grc_atendimento_agenda set ';
    $sql_a .= " situacao          = 'Cancelado'";
    $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
    $result = execsql($sql_a);



    $kokw = 1;
    return $kokw;
}

function ConfirmaChegadax($idt_atendimento_agenda, &$variavel) {

    $kokw = 0;

    $sql_a = " update grc_atendimento_agenda_painel set ";
    $sql_a .= " status_painel = '01'";
    $sql_a .= " where idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);

    $kokw = 1;
    return $kokw;
}

function ConfirmaLiberacaox($idt_atendimento_agenda, &$variavel) {
    $kokw = 0;

    $sql_a = " update grc_atendimento_agenda_painel set ";
    $sql_a .= " status_painel = '02'";
    $sql_a .= " where idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);


    $kokw = 1;
    return $kokw;
}

function ConfirmaAtendimentox($idt_atendimento_agenda, &$variavel) {
    $kokw = 0;

    $sql_a = " update grc_atendimento_agenda_painel set ";
    $sql_a .= " status_painel = '99'";
    $sql_a .= " where idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);

    $kokw = 1;
    return $kokw;
}

function DecideSistema() {
    $sistema_origem = "GRC";
    if ($_SESSION[CS]['g_abrir_sistema_origem'] == 'PFO') {
        // FORNRCRDOR
        $sistema_origem = "PFO";
    }
    if ($_SESSION[CS]['g_abrir_sistema_origem'] == 'GRC') {
        // clientes
        $sistema_origem = "GRC";
    }
    if ($_SESSION[CS]['g_abrir_sistema_origem'] == 'PIR') {
        // clientes
        $sistema_origem = "PIR";
    }
    if ($_SESSION[CS]['g_abrir_sistema_origem'] == 'GEC') {
        // clientes
        $sistema_origem = "GEC";
    }
    return $sistema_origem;
}

function DadoAbrangencia($idt_produto_abrangencia) {
    $vet_trab = Array();
    $sql = "select grc_pa.* from grc_produto_abrangencia grc_pa ";
    $sql .= " where grc_pa.idt = " . null($idt_produto_abrangencia);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = $row['codigo'];
        $descricao = $row['proprio'];
        $ativo = $row['ativo'];
        $vet_trab = $row;
    }
    return $vet_trab;
}

function ExcluiEventoTemporario($idt_evento) {
    $sql = "select grc_e.idt from grc_evento grc_e ";
    $sql .= " where grc_e.idt         = " . null($idt_evento);
    $sql .= "   and grc_e.temporario  = " . aspa('S');
    $rs = execsql($sql);
    if ($rs->rows == 1) {
        // pode excluir é temporário

        beginTransaction();

        ExcluiEventoAcao($idt_evento);

        commit();
    }
}

function ExcluiEventoAcao($idt_evento, $trata_erro = true) {
    //Evento Participante
    $sql_d = ' delete from ';
    $sql_d .= ' grc_evento_participante ';
    $sql_d .= ' where idt_atendimento in (';
    $sql_d .= ' select idt from grc_atendimento where idt_evento = ' . null($idt_evento);
    $sql_d .= ' )';
    execsql($sql_d, $trata_erro);

    //Organização
    $sql_d = ' delete from ';
    $sql_d .= ' grc_atendimento_organizacao ';
    $sql_d .= ' where idt_atendimento in (';
    $sql_d .= ' select idt from grc_atendimento where idt_evento = ' . null($idt_evento);
    $sql_d .= ' )';
    execsql($sql_d, $trata_erro);

    // Pessoas
    $sql_d = ' delete from ';
    $sql_d .= ' grc_atendimento_pessoa ';
    $sql_d .= ' where idt_atendimento in (';
    $sql_d .= ' select idt from grc_atendimento where idt_evento = ' . null($idt_evento);
    $sql_d .= ' )';
    execsql($sql_d, $trata_erro);

    // Atendimento
    $sql_d = 'delete from grc_atendimento ';
    $sql_d .= ' where idt_evento = ' . null($idt_evento);
    execsql($sql_d, $trata_erro);

    // Insumos do evento
    $sql_d = 'delete from grc_evento_insumo ';
    $sql_d .= ' where idt_evento = ' . null($idt_evento);
    execsql($sql_d, $trata_erro);

    //Libera o Bloqueio de Vagas
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_evento_combo';
    $sql .= ' where idt_evento_origem = ' . null($idt_evento);
    $rs = execsql($sql, $trata_erro);

    foreach ($rs->data as $row) {
        operacaoEventoComboVaga($row['idt'], FALSE, $trata_erro);
    }

    $sql_d = 'delete from grc_evento_combo ';
    $sql_d .= ' where idt_evento_origem = ' . null($idt_evento);
    execsql($sql_d, $trata_erro);

    // exclui o evento
    $sql_d = 'delete from grc_evento ';
    $sql_d .= ' where idt = ' . null($idt_evento);
    execsql($sql_d, $trata_erro);
}

function PreparaProdutoEvento(&$vet) {
    global $vetSimNao;

    $idt_instrumento = $_POST['idt_instrumento'];
    $idt_evento = $_POST['idt_evento'];
    $idt_produto = $_POST['idt_produto'];

    $sql = '';
    $sql .= ' select tipo_sincroniza_siacweb';
    $sql .= ' from ' . db_pir_grc . 'grc_evento';
    $sql .= " where idt = " . null($idt_evento);
    $rs = execsql($sql);
    $tipo_sincroniza_siacweb = $rs->data[0][0];

    //
    // Copiar produto para fazer parte do evento
    //
    //$texto='Cópia';
    //$idt_produto_clonado = CopiarEventoProduto($idt_evento, $idt_produto, $texto);
    //$vet['idt_produto_clonado']  = $idt_produto_clonado;

    $carga_horaria = "";
    $descricao = "";
    //
    $sql = "select grc_p.*, grc_ft.descricao as grc_ft_descricao, grc_pm.descricao as grc_pm_descricao, gec_prog.tipo_ordem";
    $sql .= ' from grc_produto grc_p';
    $sql .= " left outer join grc_foco_tematico grc_ft on grc_ft.idt = grc_p.idt_foco_tematico  ";
    $sql .= " left outer join grc_produto_maturidade grc_pm on grc_pm.idt = grc_p.idt_produto_maturidade  ";
    $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = grc_p.idt_programa';
    $sql .= " where grc_p.idt  = " . null($idt_produto);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $vet['idt_foco_tematico'] = $row['idt_foco_tematico'];
        $vet['idt_foco_tematico_tf'] = $row['grc_ft_descricao'];
        $vet['maturidade'] = $row['grc_pm_descricao'];

        $vet['entrega_prazo_max'] = $row['entrega_prazo_max'];
        $vet['conteudo_programatico'] = $row['conteudo_programatico'];
        $vet['descricao_comercial'] = $row['descricao_comercial'];
        $vet['vl_determinado'] = $row['vl_determinado'];
        $vet['vl_determinado_tf'] = $vetSimNao[$row['vl_determinado']];

        if ($row['titulo_comercial'] == '' || $row['tipo_ordem'] == 'SG') {
            $vet['descricao'] = $row['descricao'];
        } else {
            $vet['descricao'] = $row['titulo_comercial'];
        }

        if ($row['generico'] == 'S') {
            $vet['bloquear_descricao'] = 'N';
        } else {
            $vet['bloquear_descricao'] = 'S';
        }
        
        $tot_ini = 0;

        if ($row['carga_horaria_ini'] != '') {
            $tot_ini += $row['carga_horaria_ini'];
        }

        if ($row['carga_horaria_2_ini'] != '') {
            $tot_ini += $row['carga_horaria_2_ini'];
        }

        $tot_fim = 0;

        if ($row['carga_horaria_fim'] != '') {
            $tot_fim += $row['carga_horaria_fim'];
        }

        if ($row['carga_horaria_2_fim'] != '') {
            $tot_fim += $row['carga_horaria_2_fim'];
        }

        if ($tot_ini == $tot_fim) {
            $carga_horaria_total_lbl = 'Carga Horária (' . format_decimal($tot_ini) . '): <span class="asterisco">*</span>';
        } else {
            $carga_horaria_total_lbl = 'Carga Horária (' . format_decimal($tot_ini) . ' - ' . format_decimal($tot_fim) . '): <span class="asterisco">*</span>';
        }

        if ($row['frequencia_siac'] == '') {
            $row['frequencia_siac'] = 0;
        }

        $vet['carga_horaria_total_ini'] = $tot_ini;
        $vet['carga_horaria_total_fim'] = $tot_fim;
        $vet['carga_horaria_total_lbl'] = $carga_horaria_total_lbl;
        $vet['quantidade_participante'] = $row['participante_maximo'];
        $vet['quantidade_participante_lbl'] = 'Qtde. Participantes (' . $row['participante_minimo'] . ' - ' . $row['participante_maximo'] . '): <span class="asterisco">*</span>';
        $vet['frequencia_min'] = $row['frequencia_siac'];
        $vet['qtd_minima_pagantes'] = $row['participante_minimo'];
        $vet['qtd_dias_reservados'] = $row['encontro_quantidade'];
        $vet['idt_publico_alvo'] = $row['idt_publico_alvo'];
        $vet['cred_necessita_credenciado'] = $row['necessita_credenciado'];
        $vet['idt_programa'] = $row['idt_programa'];
    }

    //Copia o Público Alvo
    $sql = 'delete from grc_evento_publico_alvo where idt = ' . null($idt_evento);
    execsql($sql);

    $sql = '';
    $sql .= ' insert into grc_evento_publico_alvo (idt, idt_publico_alvo_outro)';
    $sql .= ' select ' . $idt_evento . ' as idt, idt_publico_alvo_outro';
    $sql .= ' from grc_produto_publico_alvo';
    $sql .= ' where idt = ' . null($idt_produto);
    execsql($sql);

    //  Pegar elementos de despesas
    $sql = "delete grc_pi.* from grc_evento_insumo grc_pi";
    $sql .= " inner join grc_insumo grc_pp on grc_pp.idt = grc_pi.idt_insumo ";
    $sql .= " where grc_pp.sinal = " . aspa('S'); // despesa
    $sql .= " and grc_pi.idt_evento = " . null($idt_evento);
    execsql($sql);

    $sql = "select grc_pi.*, pr.idt_profissional from grc_produto_insumo grc_pi ";
    $sql .= " inner join grc_insumo grc_pp on grc_pp.idt = grc_pi.idt_insumo ";
    $sql .= ' left outer join grc_produto_profissional pr on pr.idt = grc_pi.idt_produto_profissional';
    $sql .= " where grc_pi.idt_produto  = " . null($idt_produto);
    $sql .= " and grc_pp.sinal = " . aspa('S'); // despesa
    $sql .= " and grc_pi.ativo = " . aspa('S'); // ativo
    $rs = execsql($sql);

    $valor_hora = 0;

    ForEach ($rs->data as $row) {
        $idt_insumo = null($row['idt_insumo']);
        $idt_area_suporte = null($row['idt_area_suporte']);
        $idt_profissional = null($row['idt_profissional']);
        $codigo = aspa($row['codigo']);
        $descricao = aspa($row['descricao']);
        $ativo = aspa($row['ativo']);
        $detalhe = aspa($row['detalhe']);
        $quantidade = null($row['quantidade']);
        $qtd_automatico = aspa('S');
        $custo_unitario_real = null($row['custo_unitario_real']);
        $idt_insumo_unidade = null($row['idt_insumo_unidade']);
        $por_participante = aspa($row['por_participante']);
        $custo_total = null($row['custo_total']);
        $ctotal_minimo = null($row['ctotal_minimo']);
        $ctotal_maximo = null($row['ctotal_maximo']);
        $rtotal_minimo = null($row['rtotal_minimo']);
        $rtotal_maximo = null($row['rtotal_maximo']);
        $receita_total = null($row['receita_total']);

        if ($row['codigo'] == '70001') {
            $valor_hora += $row['custo_unitario_real'];

            if ($tipo_sincroniza_siacweb == 'VF' && ($idt_instrumento == 46 || $idt_instrumento == 47)) {
                $qtd_automatico = aspa('N');
                $quantidade = 1;
            }
        }

        if ($row['codigo'] == '70004') {
            $qtd_automatico = aspa('N');
        }

        $sql_i = " insert into grc_evento_insumo ";
        $sql_i .= " (  ";
        $sql_i .= " qtd_automatico, ";
        $sql_i .= " idt_evento, ";
        $sql_i .= " idt_area_suporte, ";
        $sql_i .= " idt_profissional, ";
        $sql_i .= " idt_insumo, ";
        $sql_i .= " codigo, ";
        $sql_i .= " descricao, ";
        $sql_i .= " detalhe, ";
        $sql_i .= " ativo, ";
        $sql_i .= " quantidade, ";
        $sql_i .= " quantidade_evento, ";
        $sql_i .= " custo_unitario_real, ";
        $sql_i .= " idt_insumo_unidade, ";
        $sql_i .= " por_participante ";
        $sql_i .= "  ) values ( ";
        $sql_i .= " $qtd_automatico, ";
        $sql_i .= " $idt_evento, ";
        $sql_i .= " $idt_area_suporte, ";
        $sql_i .= " $idt_profissional, ";
        $sql_i .= " $idt_insumo, ";
        $sql_i .= " $codigo, ";
        $sql_i .= " $descricao, ";
        $sql_i .= " $detalhe, ";
        $sql_i .= " $ativo, ";
        $sql_i .= " $quantidade, ";
        $sql_i .= " $quantidade, ";
        $sql_i .= " $custo_unitario_real, ";
        $sql_i .= " $idt_insumo_unidade, ";
        $sql_i .= " $por_participante ";
        $sql_i .= ") ";
        execsql($sql_i);
    }

    $vet['valor_hora'] = format_decimal($valor_hora);

    $sql = '';
    $sql .= ' select sum(ea.carga_horaria) as carga_horaria';
    $sql .= ' from grc_evento_agenda ea';
    $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
    $sql .= ' where ea.idt_evento = ' . null($idt_evento);
    $sql .= whereEventoParticipante();
    $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
    $rsa = execsql($sql);
    $row_sum = $rsa->data[0];
    $vet['carga_horaria_total'] = format_decimal($row_sum['carga_horaria']);

    $vet['idt_produto'] = $idt_produto;

    $sql = '';
    $sql .= ' select e.idt_produto, e.idt_foco_tematico, e.maturidade, e.descricao, e.carga_horaria_total, e.quantidade_participante, e.frequencia_min,';
    $sql .= ' e.qtd_minima_pagantes, e.qtd_dias_reservados, e.idt_publico_alvo, e.cred_necessita_credenciado, e.idt_programa, e.valor_hora, e.codigo,';
    $sql .= ' grc_p.descricao as idt_produto_vl, grc_ft.descricao as idt_foco_tematico_vl, grc_pa.descricao as idt_publico_alvo_vl,';
    $sql .= ' gec_prog.descricao as idt_programa_vl, e.entrega_prazo_max, e.vl_determinado, e.conteudo_programatico, e.descricao_comercial';
    $sql .= ' from grc_evento e';
    $sql .= ' left outer join grc_produto grc_p on grc_p.idt = e.idt_produto';
    $sql .= ' left outer join grc_foco_tematico grc_ft on grc_ft.idt = e.idt_foco_tematico';
    $sql .= ' left outer join grc_publico_alvo grc_pa on grc_pa.idt = e.idt_publico_alvo';
    $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = e.idt_programa';
    $sql .= ' where e.idt = ' . null($idt_evento);
    $rsAnt = execsql($sql);
    $rowAnt = $rsAnt->data[0];

    $sql_a = ' update grc_evento set ';
    $sql_a .= ' idt_produto  = ' . null($idt_produto) . ',  ';
    $sql_a .= ' idt_foco_tematico  = ' . null($vet['idt_foco_tematico']) . ',  ';
    $sql_a .= ' maturidade  = ' . aspa($vet['maturidade']) . ',  ';
    $sql_a .= ' descricao  = ' . aspa($vet['descricao']) . ',  ';
    $sql_a .= ' carga_horaria_total  = ' . null(desformat_decimal($vet['carga_horaria_total'])) . ',  ';
    $sql_a .= ' quantidade_participante  = ' . null($vet['quantidade_participante']) . ',  ';
    $sql_a .= ' frequencia_min  = ' . null($vet['frequencia_min']) . ',  ';
    $sql_a .= ' qtd_minima_pagantes  = ' . null($vet['qtd_minima_pagantes']) . ',  ';
    $sql_a .= ' qtd_dias_reservados  = ' . null($vet['qtd_dias_reservados']) . ',  ';
    $sql_a .= ' idt_publico_alvo  = ' . null($vet['idt_publico_alvo']) . ',  ';
    $sql_a .= ' cred_necessita_credenciado  = ' . aspa($vet['cred_necessita_credenciado']) . ',  ';
    $sql_a .= ' idt_programa  = ' . null($vet['idt_programa']) . ',  ';
    $sql_a .= ' entrega_prazo_max  = ' . null($vet['entrega_prazo_max']) . ',  ';
    $sql_a .= ' vl_determinado  = ' . aspa($vet['vl_determinado']) . ',  ';
    $sql_a .= ' conteudo_programatico  = ' . aspa($vet['conteudo_programatico']) . ',  ';
    $sql_a .= ' descricao_comercial  = ' . aspa($vet['descricao_comercial']) . ',  ';
    $sql_a .= ' valor_hora  = ' . null(desformat_decimal($vet['valor_hora']));
    $sql_a .= ' where idt = ' . null($idt_evento) . '  ';
    execsql($sql_a);

    //Grava Log
    $sql = '';
    $sql .= ' select e.idt_produto, e.idt_foco_tematico, e.maturidade, e.descricao, e.carga_horaria_total, e.quantidade_participante, e.frequencia_min,';
    $sql .= ' e.qtd_minima_pagantes, e.qtd_dias_reservados, e.idt_publico_alvo, e.idt_programa, e.valor_hora, e.codigo,';
    $sql .= ' grc_p.descricao as idt_produto_vl, grc_ft.descricao as idt_foco_tematico_vl, grc_pa.descricao as idt_publico_alvo_vl,';
    $sql .= " e.cred_necessita_credenciado as cred_necessita_credenciado_vl, if (e.cred_necessita_credenciado = 'S', 'Sim', 'Não') as cred_necessita_credenciado,";
    $sql .= " e.vl_determinado as vl_determinado_vl, if (e.vl_determinado = 'S', 'Sim', 'Não') as vl_determinado,";
    $sql .= ' gec_prog.descricao as idt_programa_vl, e.entrega_prazo_max, e.conteudo_programatico, e.descricao_comercial';
    $sql .= ' from grc_evento e';
    $sql .= ' left outer join grc_produto grc_p on grc_p.idt = e.idt_produto';
    $sql .= ' left outer join grc_foco_tematico grc_ft on grc_ft.idt = e.idt_foco_tematico';
    $sql .= ' left outer join grc_publico_alvo grc_pa on grc_pa.idt = e.idt_publico_alvo';
    $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = e.idt_programa';
    $sql .= ' where e.idt = ' . null($idt_evento);
    $rsAtu = execsql($sql);
    $rowAtu = $rsAtu->data[0];

    $vetLogDetalheCampo = Array(
        'idt_produto' => 'Produto',
        'idt_foco_tematico' => 'Foco Temático do Produto',
        'maturidade' => 'Maturidade Empresarial',
        'descricao' => 'Título Comercial do Evento',
        'carga_horaria_total' => 'Carga Horária',
        'quantidade_participante' => 'Qtde. Participantes',
        'frequencia_min' => 'Frequência Mínima (%)',
        'qtd_minima_pagantes' => 'Qtde. Min. Pagantes',
        'qtd_dias_reservados' => 'Qtde. Encontros',
        'idt_publico_alvo' => 'Público Prioritário',
        'cred_necessita_credenciado' => 'Necessita Credenciado(s)?',
        'idt_programa' => 'Programa do Produto',
        'entrega_prazo_max' => 'Prazo Máximo para execução do Serviço (dias)',
        'vl_determinado' => 'Produto de Venda Imediata?',
        'conteudo_programatico' => 'Conteúdo programático',
        'descricao_comercial' => 'Descrição Comercial',
        'valor_hora' => 'Valor da Hora',
    );

    $des_registro = '[' . $rowAtu['codigo'] . '] ' . $rowAtu['descricao'] . ' aletração do Produto';
    $vetLogDetalhe = Array();

    foreach ($vetLogDetalheCampo as $campo => $campo_desc) {
        $vetLogDetalhe[$campo]['campo_desc'] = $campo_desc;
        $vetLogDetalhe[$campo]['vl_ant'] = $rowAnt[$campo . '_vl'];
        $vetLogDetalhe[$campo]['desc_ant'] = $rowAnt[$campo];
        $vetLogDetalhe[$campo]['vl_atu'] = $rowAtu[$campo . '_vl'];
        $vetLogDetalhe[$campo]['desc_atu'] = $rowAtu[$campo];
    }

    grava_log_sis('grc_evento', 'A', $idt_evento, $des_registro, 'Programação de Eventos', '', $vetLogDetalhe, true);

    CalcularInsumoEvento($idt_evento);
}

function SolicitarAprovarEvento(&$vet) {
    $idt_instrumento = $vet['idt_instrumento'];

    $instrumento_texto = "";

    $sql = "select grc_ai.* from grc_atendimento_instrumento grc_ai ";
    $sql .= " where grc_ai.idt  = " . null($idt_instrumento);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $instrumento_texto = $row['descricao'];
    }


    $idt_evento = $vet['idt_evento'];
    //
    $sql = "select grc_e.* from grc_evento grc_e ";
    $sql .= " where grc_e.idt  = " . null($idt_evento);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = $row['codigo'];
        $descricao = $row['descricao'];
        $idt_evento_situacao = $row['idt_evento_situacao'];
        $idt_unidade = $row['idt_unidade'];
        $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
        $idt_gestor_evento = $row['idt_gestor_evento'];
        $idt_responsavel = $row['idt_responsavel'];
        $idt_gestor_projeto = $row['idt_gestor_projeto'];
        $data_criacao = $row['data_criacao'];
    }
    if (!($idt_evento_situacao == 1 || $idt_evento_situacao == 5 || $idt_evento_situacao == 24)) {
        $vet['erro']['01'] = 'Situação Não permite enviar para aprovação';
        return false;
    }
    // beginTransaction();
    // set_time_limit(90);
    //    
    $sql_a = ' update grc_atendimento_pendencia set ';
    $sql_a .= " idt_evento_situacao_para = 6,";
    $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
    $sql_a .= " dt_update = now(),";
    $sql_a .= " ativo  =  'N'";
    $sql_a .= ' where idt_evento  = ' . null($idt_evento);
    $sql_a .= " and ativo  =  'S'";
    $sql_a .= " and tipo   =  'Evento'";
    execsql($sql_a);

    $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($idt_evento);
    execsql($sql_a);

    $sql_a = ' update grc_evento set ';
    $sql_a .= ' idt_evento_situacao  = 6 ';
    $sql_a .= ' where idt  = ' . null($idt_evento);
    $result = execsql($sql_a);
    //
    $data_solucaow = date('d/m/Y');
    $assuntow = $descricao;


    $observacaow = "[{$instrumento_texto}] " . $descricao;


    if ($assuntow == '') {
        $assuntow = $observacaow;
    }

    $sql = '';
    $sql .= ' select distinct ea.idt_autorizador';
    $sql .= ' from (';
    $sql .= ' select idt_autorizador';
    $sql .= ' from grc_evento_autorizador';
    $sql .= ' where idt_ponto_atendimento = ' . null($idt_unidade);

    if ($idt_gestor_projeto != '') {
        $sql .= ' union all';
        $sql .= ' select ' . $idt_gestor_projeto . ' as idt_autorizador';
    }

    $sql .= ' ) as ea';
    $sql .= ' where ea.idt_autorizador <> ' . null($idt_gestor_evento);
    $sql .= ' and ea.idt_autorizador <> ' . null($idt_responsavel);
    $rs = execsql($sql);

    foreach ($rs->data as $row) {
        PendenciaAprovacao($idt_evento, 6, $idt_ponto_atendimento, $row['idt_autorizador'], $data_solucaow, $assuntow, $observacaow, $codigo);
    }
    //
    // commit();    
}

function SolicitarCancelamentoEvento(&$vet) {
    $idt_instrumento = $vet['idt_instrumento'];

    $instrumento_texto = "";

    $sql = "select grc_ai.* from grc_atendimento_instrumento grc_ai ";
    $sql .= " where grc_ai.idt  = " . null($idt_instrumento);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $instrumento_texto = $row['descricao'];
    }


    $idt_evento = $vet['idt_evento'];

    $sql = "select grc_e.* from grc_evento grc_e ";
    $sql .= " where grc_e.idt  = " . null($idt_evento);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = $row['codigo'];
        $descricao = $row['descricao'];
        $idt_evento_situacao = $row['idt_evento_situacao'];
        $idt_unidade = $row['idt_unidade'];
        $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
        $idt_gestor_evento = $row['idt_gestor_evento'];
        $idt_responsavel = $row['idt_responsavel'];
        $idt_gestor_projeto = $row['idt_gestor_projeto'];
        $data_criacao = $row['data_criacao'];
    }

    $sql_a = 'update grc_evento set idt_evento_situacao_can = idt_evento_situacao where idt = ' . null($idt_evento);
    execsql($sql_a);

    $sql_a = ' update grc_evento set ';
    $sql_a .= ' idt_evento_situacao  = 23 ';
    $sql_a .= ' where idt  = ' . null($idt_evento);
    $result = execsql($sql_a);

    $data_solucaow = date('d/m/Y');
    $assuntow = $descricao;

    $observacaow = "[{$instrumento_texto}] " . $descricao;

    if ($assuntow == '') {
        $assuntow = $observacaow;
    }

    $sql = '';
    $sql .= ' select distinct ea.idt_autorizador';
    $sql .= ' from (';
    $sql .= ' select idt_autorizador';
    $sql .= ' from grc_evento_autorizador';
    $sql .= ' where idt_ponto_atendimento = ' . null($idt_unidade);

    if ($idt_gestor_projeto != '') {
        $sql .= ' union all';
        $sql .= ' select ' . $idt_gestor_projeto . ' as idt_autorizador';
    }

    $sql .= ' ) as ea';
    $sql .= ' where ea.idt_autorizador <> ' . null($idt_gestor_evento);
    $sql .= ' and ea.idt_autorizador <> ' . null($idt_responsavel);
    $rs = execsql($sql);

    foreach ($rs->data as $row) {
        PendenciaAprovacao($idt_evento, 23, $idt_ponto_atendimento, $row['idt_autorizador'], $data_solucaow, $assuntow, $observacaow, $codigo, 'Para Aprovação do Cancelamento');
    }
}

function PendenciaAprovacao($idt_evento, $idt_evento_situacao, $idt_ponto_atendimento, $idt_gestor_evento, $data_solucaow, $assuntow, $observacaow, $codigow, $status = 'Para Aprovação') {
    $kokw = 0;
    $idt_usuario = $_SESSION[CS]['g_id_usuario'];
    $datadia = date('d/m/Y H:i:s');
    $data = aspa(trata_data($datadia));
    $idt_atendimento = 'null';
    $data_solucao = aspa(trata_data($data_solucaow));
    $assunto = aspa($assuntow);
    $observacao = aspa($observacaow);
    $protocolo = aspa($codigow);
    $status = aspa($status);
    $tipo = aspa('Evento');
    $recorrencia = aspa('1');

    //
    // Determinar quem aprova essa questão
    //
    
    // o gestor não pode ser o aprovador

    $idt_responsavel_solucao = $idt_gestor_evento;
    $idt_atendimento_pendencia = 'null';

    //
    // enviar para todos que podem aprovar...
    //
    
    //
    $sql_i = ' insert into grc_atendimento_pendencia ';
    $sql_i .= ' (  ';
    $sql_i .= " protocolo, ";
    $sql_i .= " idt_ponto_atendimento, ";
    $sql_i .= " idt_gestor_local, ";
    $sql_i .= " recorrencia, ";
    $sql_i .= " idt_responsavel_solucao, ";
    $sql_i .= " idt_atendimento_pendencia, ";
    $sql_i .= " status, ";
    $sql_i .= " tipo, ";
    $sql_i .= " idt_atendimento, ";
    $sql_i .= " idt_evento, ";
    $sql_i .= " idt_evento_situacao_de, ";
    $sql_i .= " idt_usuario, ";
    $sql_i .= " data, ";
    $sql_i .= " data_solucao, ";
    $sql_i .= " assunto, ";
    $sql_i .= " observacao ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $protocolo, ";
    $sql_i .= " $idt_ponto_atendimento, ";
    $sql_i .= " $idt_gestor_evento, ";
    $sql_i .= " $recorrencia, ";
    $sql_i .= " $idt_responsavel_solucao, ";
    $sql_i .= " $idt_atendimento_pendencia, ";

    $sql_i .= " $status, ";
    $sql_i .= " $tipo, ";
    $sql_i .= " $idt_atendimento, ";
    $sql_i .= " $idt_evento, ";
    $sql_i .= " $idt_evento_situacao, ";
    $sql_i .= " $idt_usuario, ";
    $sql_i .= " $data, ";
    $sql_i .= " $data_solucao, ";
    $sql_i .= " $assunto, ";
    $sql_i .= " $observacao ";
    $sql_i .= ') ';
    $result = execsql($sql_i);

    $idt_atendimento_pendencia = lastInsertId();
    copiaAtendimentoPendenciaTransResp($idt_atendimento_pendencia);

    $kokw = 1;
    return $kokw;
}

function PendenciaEventoPublicacao($idt_evento_publicacao, $idt_evento, $idt_ponto_atendimento, $idt_gestor_evento, $data_solucaow, $assuntow, $observacaow, $codigow, $status = 'Para Aprovação') {
    $kokw = 0;
    $idt_usuario = $_SESSION[CS]['g_id_usuario'];
    $datadia = date('d/m/Y H:i:s');
    $data = aspa(trata_data($datadia));
    $data_solucao = aspa(trata_data($data_solucaow));
    $assunto = aspa($assuntow);
    $observacao = aspa($observacaow);
    $protocolo = aspa($codigow);
    $status = aspa($status);
    $tipo = aspa('Política de Desconto do Evento');
    $recorrencia = aspa('1');
    $idt_evento_publicacao = null($idt_evento_publicacao);
    $idt_evento = null($idt_evento);

    $idt_responsavel_solucao = $idt_gestor_evento;

    $sql_i = ' insert into grc_atendimento_pendencia ';
    $sql_i .= ' (  ';
    $sql_i .= " protocolo, ";
    $sql_i .= " idt_ponto_atendimento, ";
    $sql_i .= " idt_gestor_local, ";
    $sql_i .= " recorrencia, ";
    $sql_i .= " idt_responsavel_solucao, ";
    $sql_i .= " status, ";
    $sql_i .= " tipo, ";
    $sql_i .= " idt_evento, ";
    $sql_i .= " idt_evento_publicacao, ";
    $sql_i .= " idt_usuario, ";
    $sql_i .= " data, ";
    $sql_i .= " data_solucao, ";
    $sql_i .= " assunto, ";
    $sql_i .= " observacao ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $protocolo, ";
    $sql_i .= " $idt_ponto_atendimento, ";
    $sql_i .= " $idt_gestor_evento, ";
    $sql_i .= " $recorrencia, ";
    $sql_i .= " $idt_responsavel_solucao, ";
    $sql_i .= " $status, ";
    $sql_i .= " $tipo, ";
    $sql_i .= " $idt_evento, ";
    $sql_i .= " $idt_evento_publicacao, ";
    $sql_i .= " $idt_usuario, ";
    $sql_i .= " $data, ";
    $sql_i .= " $data_solucao, ";
    $sql_i .= " $assunto, ";
    $sql_i .= " $observacao ";
    $sql_i .= ') ';
    $result = execsql($sql_i);

    $idt_atendimento_pendencia = lastInsertId();
    copiaAtendimentoPendenciaTransResp($idt_atendimento_pendencia);

    $kokw = 1;
    return $kokw;
}

function CancelarEvento(&$vet) {
    $idt_instrumento = $vet['idt_instrumento'];
    $idt_evento = $vet['idt_evento'];
    $idt_produto = $vet['idt_produto'];
    beginTransaction();
    set_time_limit(90);

    $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($idt_evento);
    execsql($sql_a);

    $sql_a = ' update grc_evento set ';
    $sql_a .= ' idt_evento_situacao  = 4 ';
    $sql_a .= ' where idt  = ' . null($idt_evento);
    $result = execsql($sql_a);
    commit();
}

function SolicitarCancelarEvento($idt_evento) {
    $sql_a = ' update grc_atendimento_pendencia set ';
    $sql_a .= " idt_evento_situacao_para = " . null($_POST['situacao']) . ",";
    $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
    $sql_a .= " dt_update = now(),";
    $sql_a .= " ativo  =  'N'";
    $sql_a .= ' where idt_evento  = ' . null($idt_evento);
    $sql_a .= " and ativo  =  'S'";
    $sql_a .= " and tipo   =  'Evento'";
    execsql($sql_a);

    $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($idt_evento);
    execsql($sql_a);

    $sql_a = ' update grc_evento set ';
    $sql_a .= " ativo = 'N', ";
    $sql_a .= ' idt_evento_situacao  = ' . null($_POST['situacao']);
    $sql_a .= ' where idt  = ' . null($idt_evento);
    $result = execsql($sql_a);
}

function SolicitarAjustesEvento(&$vet) {
    $idt_instrumento = $vet['idt_instrumento'];

    $instrumento_texto = "";

    $sql = "select grc_ai.* from grc_atendimento_instrumento grc_ai ";
    $sql .= " where grc_ai.idt  = " . null($idt_instrumento);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $instrumento_texto = $row['descricao'];
    }

    $idt_evento = $vet['idt_evento'];
    //
    $sql = "select grc_e.* from grc_evento grc_e ";
    $sql .= " where grc_e.idt  = " . null($idt_evento);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = $row['codigo'];
        $descricao = $row['descricao'];
        $idt_evento_situacao = $row['idt_evento_situacao'];
        $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
        $idt_gestor_evento = $row['idt_gestor_evento'];
        $idt_responsavel = $row['idt_responsavel'];
        $data_criacao = $row['data_criacao'];
    }

    // beginTransaction();
    // set_time_limit(90);
    //    
    $sql_a = ' update grc_atendimento_pendencia set ';
    $sql_a .= " idt_evento_situacao_para = " . null($_POST['situacao']) . ",";
    $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
    $sql_a .= " dt_update = now(),";
    $sql_a .= " ativo  =  'N'";
    $sql_a .= ' where idt_evento  = ' . null($idt_evento);
    $sql_a .= " and ativo  =  'S'";
    $sql_a .= " and tipo   =  'Evento'";
    execsql($sql_a);

    $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($idt_evento);
    execsql($sql_a);

    $sql_a = ' update grc_evento set ';
    $sql_a .= ' idt_evento_situacao  =  ' . null($_POST['situacao']);
    $sql_a .= ' where idt  = ' . null($idt_evento);
    $result = execsql($sql_a);
    //
    $data_solucaow = date('d/m/Y');
    $assuntow = $descricao;
    $observacaow = "[{$instrumento_texto}] " . $descricao;
    if ($assuntow == '') {
        $assuntow = $observacaow;
    }
    PendenciaAjustesEvento($idt_evento, null($_POST['situacao']), $idt_ponto_atendimento, $idt_gestor_evento, $data_solucaow, $assuntow, $observacaow, $codigo);
    //
    // commit();    
}

function AprovarEvento(&$vet) {
    $idt_instrumento = $vet['idt_instrumento'];
    $idt_evento = $vet['idt_evento'];
    //
    $sql = "select grc_e.* from grc_evento grc_e ";
    $sql .= " where grc_e.idt  = " . null($idt_evento);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo = $row['codigo'];
        $descricao = $row['descricao'];
        $idt_evento_situacao = $row['idt_evento_situacao'];
        $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
        $idt_gestor_evento = $row['idt_gestor_evento'];
        $idt_responsavel = $row['idt_responsavel'];
        $data_criacao = $row['data_criacao'];
    }

    $sql_a = ' update grc_atendimento_pendencia set ';
    $sql_a .= " idt_evento_situacao_para = " . null($_POST['situacao']) . ",";
    $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
    $sql_a .= " dt_update = now(),";
    $sql_a .= " ativo  =  'N'";
    $sql_a .= ' where idt_evento  = ' . null($idt_evento);
    $sql_a .= " and ativo  =  'S'";
    $sql_a .= " and tipo   =  'Evento'";
    execsql($sql_a);

    $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($idt_evento);
    execsql($sql_a);

    $sql_a = ' update grc_evento set ';
    $sql_a .= ' idt_evento_situacao  =  ' . null($_POST['situacao']);
    $sql_a .= ' where idt  = ' . null($idt_evento);
    execsql($sql_a);
}

function PendenciaAjustesEvento($idt_evento, $idt_evento_situacao, $idt_ponto_atendimento, $idt_gestor_evento, $data_solucaow, $assuntow, $observacaow, $codigow) {
    $kokw = 0;
    $idt_usuario = $_SESSION[CS]['g_id_usuario'];
    $datadia = date('d/m/Y H:i:s');
    $data = aspa(trata_data($datadia));
    $idt_atendimento = 'null';
    $data_solucao = aspa(trata_data($data_solucaow));
    $assunto = aspa($assuntow);
    $observacao = aspa($observacaow);
    $protocolo = aspa($codigow);
    $status = aspa('Para Ajustes');
    $tipo = aspa('Evento');
    $recorrencia = aspa('2');
    $idt_responsavel_solucao = $idt_gestor_evento;
    //
    $sql_i = ' insert into grc_atendimento_pendencia ';
    $sql_i .= ' (  ';
    $sql_i .= " protocolo, ";
    $sql_i .= " idt_ponto_atendimento, ";
    $sql_i .= " idt_gestor_local, ";
    $sql_i .= " recorrencia, ";
    $sql_i .= " idt_responsavel_solucao, ";

    $sql_i .= " status, ";
    $sql_i .= " tipo, ";
    $sql_i .= " idt_atendimento, ";
    $sql_i .= " idt_evento, ";
    $sql_i .= " idt_evento_situacao_de, ";
    $sql_i .= " idt_usuario, ";
    $sql_i .= " data, ";
    $sql_i .= " data_solucao, ";
    $sql_i .= " assunto, ";
    $sql_i .= " observacao ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $protocolo, ";
    $sql_i .= " $idt_ponto_atendimento, ";
    $sql_i .= " $idt_gestor_evento, ";
    $sql_i .= " $recorrencia, ";
    $sql_i .= " $idt_responsavel_solucao, ";


    $sql_i .= " $status, ";
    $sql_i .= " $tipo, ";
    $sql_i .= " $idt_atendimento, ";
    $sql_i .= " $idt_evento, ";
    $sql_i .= " $idt_evento_situacao, ";
    $sql_i .= " $idt_usuario, ";
    $sql_i .= " $data, ";
    $sql_i .= " $data_solucao, ";
    $sql_i .= " $assunto, ";
    $sql_i .= " $observacao ";
    $sql_i .= ') ';
    $result = execsql($sql_i);
    copiaAtendimentoPendenciaTransResp(lastInsertId());
    //$idt_atendimento = lastInsertId();

    $kokw = 1;
    return $kokw;
}

function AgregarFormularios($idt_formulario_agregador) {
    $kokw = 0;
    // Busca Formulário
    $vetAgregador = Array();
    $sql = "select ";
    $sql .= "   grc_f.*  ";
    $sql .= " from grc_formulario grc_f ";
    $sql .= " where ";
    $sql .= " grc_f.idt = " . null($idt_formulario_agregador);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        // Não Encontrado - erro
        return $kokw;
    } else {
        ForEach ($rs->data as $row) {
            $codigo = $row['codigo'];
            $descricao = $row['descricao'];
            $idt_dimensao = $row['idt_dimensao'];
        }
        $idt_formulario = 8;
        $vetAgregador[$idt_formulario] = $idt_dimensao;

        $idt_formulario = 1;
        $vetAgregador[$idt_formulario] = $idt_dimensao;

        $idt_formulario = 2;
        $vetAgregador[$idt_formulario] = $idt_dimensao;

        $idt_formulario = 3;
        $vetAgregador[$idt_formulario] = $idt_dimensao;
    }
    // 
    $sql = "select ";
    $sql .= "   grc_fs.idt  ";
    $sql .= " from grc_formulario_secao grc_fs ";
    $sql .= " inner join grc_formulario grc_f on grc_f.idt = grc_fs.idt_formulario ";
    $sql .= " where ";
    $sql .= " grc_f.idt = " . null($idt_formulario_agregador);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        
    } else {
        ForEach ($rs->data as $row) {
            $idt_secao = $row['idt'];
            //
            // Leitura das perguntas da secão
            //
			$sqlp = "select ";
            $sqlp .= "   grc_fp.idt  ";
            $sqlp .= " from grc_formulario_pergunta grc_fp ";
            $sqlp .= " where ";
            $sqlp .= " grc_fp.idt_secao = " . null($idt_secao);
            $rsp = execsql($sqlp);
            if ($rsp->rows == 0) {
                
            } else {
                ForEach ($rsp->data as $rowp) {
                    $idt_pergunta = $rowp['idt'];
                    //
                    // Acessa Respostas
                    //
					$sqlr = "select ";
                    $sqlr .= "   grc_fr.idt  ";
                    $sqlr .= " from grc_formulario_resposta grc_fr ";
                    $sqlr .= " where ";
                    $sqlr .= " grc_fr.idt_pergunta = " . null($idt_pergunta);
                    $rsr = execsql($sqlr);
                    if ($rsr->rows == 0) {
                        
                    } else {
                        ForEach ($rsr->data as $rowr) {
                            $idt_resposta = $rowr['idt'];
                            // 			
                            // Exclui Pergunta
                            //
							$sql_d = 'delete from grc_formulario_resposta ';
                            $sql_d .= ' where idt = ' . null($idt_resposta);
                            $result = execsql($sql_d);
                        }
                    }
                    // 			
                    // Exclui Pergunta
                    //
					$sql_d = 'delete from grc_formulario_pergunta ';
                    $sql_d .= ' where idt = ' . null($idt_pergunta);
                    $result = execsql($sql_d);
                }
            }
            // 			
            // Exclui Secao
            //
			$sql_d = 'delete from grc_formulario_secao ';
            $sql_d .= ' where idt = ' . null($idt_secao);
            $result = execsql($sql_d);
        }
    }
    //
    ForEach ($vetAgregador as $idt_formulario => $idt_dimensao) {
        // 
        // Acessar Secao do Formulário
        //	  
        $sql = "select ";
        $sql .= "   grc_fs.*, grc_f.idt_dimensao as grc_f_idt_dimensao ";
        $sql .= " from grc_formulario_secao grc_fs ";
        $sql .= " inner join grc_formulario grc_f on grc_f.idt = grc_fs.idt_formulario ";
        $sql .= " where ";
        $sql .= " grc_fs.idt_formulario = " . null($idt_formulario);
        $rs = execsql($sql);
        if ($rs->rows == 0) {
            // Não Encontrado - erro
            //   return $kokw;
        } else {
            ForEach ($rs->data as $row) {
                $codigo = $row['codigo'];
                $descricao = $row['descricao'];
                $idt_dimensao = $row['grc_f_idt_dimensao'];
                // grvar secao do formulario
                $idt_secao = $row['idt'];
                $codigo = aspa($row['codigo']);
                $descricao = aspa($row['descricao']);
                $detalhe = aspa($row['detalhe']);
                $ativo = aspa($row['ativo']);

                $idt_formulario = null($idt_formulario);
                $qtd_pontos = null($row['qtd_pontos']);
                $valido = aspa($row['valido']);
                $idt_formulario_area = null($row['idt_formulario_area']);
                $idt_formulario_relevancia = null($row['idt_formulario_relevancia']);


                $sqlt = "select ";
                $sqlt .= "   grc_fdr.*  ";
                $sqlt .= " from grc_formulario_dimensao_resposta grc_fdr ";
                $sqlt .= " where ";
                $sqlt .= "     grc_fdr.idt = " . null($idt_dimensao);
                $rst = execsql($sqlt);
                $sigla = "#";
                ForEach ($rst->data as $rowt) {
                    $sigla = $rowt['sigla'];
                }




                $sqlt = "select ";
                $sqlt .= "   grc_fs.*  ";
                $sqlt .= " from grc_formulario_secao grc_fs ";
                $sqlt .= " where ";
                $sqlt .= "     grc_fs.idt_formulario      = " . null($idt_formulario_agregador);
                $sqlt .= " and grc_fs.idt_formulario_area = " . null($idt_formulario_area);

                $rst = execsql($sqlt);
                if ($rst->rows == 0) {
                    $sql_i = " insert into grc_formulario_secao ";
                    $sql_i .= " (  ";
                    $sql_i .= " idt_formulario, ";
                    $sql_i .= " codigo, ";
                    $sql_i .= " descricao, ";
                    $sql_i .= " detalhe, ";

                    $sql_i .= " qtd_pontos, ";
                    $sql_i .= " valido, ";
                    $sql_i .= " idt_formulario_area, ";
                    $sql_i .= " idt_formulario_relevancia ";
                    $sql_i .= "  ) values ( ";
                    $sql_i .= " $idt_formulario_agregador, ";
                    $sql_i .= " $codigo, ";
                    $sql_i .= " $descricao, ";
                    $sql_i .= " $detalhe, ";

                    $sql_i .= " $qtd_pontos, ";
                    $sql_i .= " $valido, ";
                    $sql_i .= " $idt_formulario_area, ";
                    $sql_i .= " $idt_formulario_relevancia ";
                    $sql_i .= ") ";
                    $result = execsql($sql_i);
                    $idt_secao_agregador = lastInsertId();
                } else {
                    ForEach ($rst->data as $rowt) {
                        $idt_secao_agregador = $rowt['idt'];
                    }
                }
                CopiarPerguntas($idt_secao_agregador, $idt_secao, $idt_dimensao, $sigla);
            }
        }
    }
    $kokw = 1;
    return $kokw;
}

function CopiarPerguntas($idt_secao_agregador, $idt_secao, $idt_dimensao, $sigla) {
    $kokw = 0;
    $sql = "select ";
    $sql .= "   grc_fp.*  ";
    $sql .= " from grc_formulario_pergunta grc_fp ";
    $sql .= " where ";
    $sql .= " grc_fp.idt_secao = " . null($idt_secao);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        // Não Encontrado
        return $kokw;
    } else {
        ForEach ($rs->data as $row) {
            $idt_pergunta = $row['idt'];
            $codigo = aspa($row['codigo']);
            $descricao = aspa($row['descricao']);
            $detalhe = aspa($row['detalhe']);
            $ativo = aspa($row['ativo']);
            $idt_secao = $row['idt_secao'];
            $qtd_pontos = null($row['qtd_pontos']);
            $valido = aspa($row['valido']);
            $idt_classe = null($row['idt_classe']);
            $ajuda = aspa($row['ajuda']);
            $idt_ferramenta = null($row['idt_ferramenta']);
            $obrigatoria = aspa($row['obrigatoria']);
            $evidencias = aspa($row['evidencias']);
            // buscar Questio
            $codigo_quesito = "";
            $sqlq = "select ";
            $sqlq .= "   grc_fp.*  ";
            $sqlq .= " from grc_formulario_pergunta_pergunta grc_pp ";
            $sqlq .= " inner join grc_formulario_pergunta grc_fp on grc_fp.idt = grc_pp.idt_pergunta_n1 ";
            $sqlq .= " where ";
            $sqlq .= " grc_pp.idt_pergunta_n2 = " . null($idt_pergunta);
            $rsq = execsql($sqlq);
            $codigo_quesito = 0;
            ForEach ($rsq->data as $rowq) {
                $codigo_quesito = $rowq['codigo'];
            }
            if ($codigo_quesito == "") {
                if ($idt_dimensao == 4) {
                    $codigo_quesito = $codigo;
                }
            }
            if ($idt_dimensao == 5) {
                $codigo_quesito = '99';
            }
            $siglaw = aspa($sigla);
            $sql_i = " insert into grc_formulario_pergunta ";
            $sql_i .= " (  ";
            $sql_i .= " idt_secao, ";
            $sql_i .= " idt_dimensao, ";
            $sql_i .= " codigo_quesito, ";
            $sql_i .= " codigo, ";
            $sql_i .= " descricao, ";
            $sql_i .= " detalhe, ";
            // $sql_i .= " ativo, ";
            $sql_i .= " qtd_pontos, ";
            $sql_i .= " valido, ";
            $sql_i .= " idt_classe, ";
            $sql_i .= " ajuda, ";
            $sql_i .= " idt_ferramenta, ";
            $sql_i .= " obrigatoria, ";
            $sql_i .= " evidencias, ";
            $sql_i .= " sigla_dimensao ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $idt_secao_agregador, ";
            $sql_i .= " $idt_dimensao, ";
            $sql_i .= " $codigo_quesito, ";
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao, ";
            $sql_i .= " $detalhe, ";
            // $sql_i .= " $ativo, ";
            $sql_i .= " $qtd_pontos, ";
            $sql_i .= " $valido, ";
            $sql_i .= " $idt_classe, ";
            $sql_i .= " $ajuda, ";
            $sql_i .= " $idt_ferramenta, ";
            $sql_i .= " $obrigatoria, ";
            $sql_i .= " $evidencias, ";
            $sql_i .= " $siglaw ";
            $sql_i .= ") ";
            $result = execsql($sql_i);
            $idt_pergunta_agregador = lastInsertId();
            CopiarRespostas($idt_pergunta_agregador, $idt_pergunta);
        }
    }
    $kokw = 1;
    return $kokw;
}

function CopiarRespostas($idt_pergunta_agregador, $idt_pergunta) {
    $kokw = 0;
    $sql = "select ";
    $sql .= "   grc_fr.*  ";
    $sql .= " from grc_formulario_resposta grc_fr ";
    $sql .= " where ";
    $sql .= " grc_fr.idt_pergunta = " . null($idt_pergunta);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        // Não Encontrado
        return $kokw;
    } else {
        ForEach ($rs->data as $row) {
            $idt_resposta = $row['idt'];
            $codigo = aspa($row['codigo']);
            $descricao = aspa($row['descricao']);
            $detalhe = aspa($row['detalhe']);
            $campo_txt = aspa($row['campo_txt']);
            $idt_secao = $row['idt_secao'];
            $qtd_pontos = null($row['qtd_pontos']);
            $valido = aspa($row['valido']);
            $idt_classe = null($row['idt_classe']);
            $sql_i = " insert into grc_formulario_resposta ";
            $sql_i .= " (  ";
            $sql_i .= " idt_pergunta, ";
            $sql_i .= " codigo, ";
            $sql_i .= " descricao, ";
            $sql_i .= " detalhe, ";
            $sql_i .= " campo_txt, ";
            $sql_i .= " qtd_pontos, ";
            $sql_i .= " valido, ";
            $sql_i .= " idt_classe ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $idt_pergunta_agregador, ";
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao, ";
            $sql_i .= " $detalhe, ";
            $sql_i .= " $campo_txt, ";
            $sql_i .= " $qtd_pontos, ";
            $sql_i .= " $valido, ";
            $sql_i .= " $idt_classe ";
            $sql_i .= ") ";
            $result = execsql($sql_i);
            $idt_resposta_agregador = lastInsertId();
        }
    }
    $kokw = 1;
    return $kokw;
}

function VerificaAvaliacaoRespostas($idt_avaliacao) {

    $sql = " select ";
    $sql .= "   grc_a.idt_situacao  as grc_a_idt_situacao  ";
    $sql .= " from grc_avaliacao grc_a ";
    $sql .= " where ";
    $sql .= " grc_a.idt = " . null($idt_avaliacao);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $grc_a_idt_situacao = $row['grc_a_idt_situacao'];
    }


    $vetVerifica = Array();
    $sqlt = ' select grc_ar.* ';
    $sqlt .= ' from grc_avaliacao_resposta grc_ar';
    $sqlt .= ' where grc_ar.idt_avaliacao  = ' . null($idt_avaliacao);
    $rst = execsql($sqlt);
    if ($rst->rows == 0) {
        
    } else {
        foreach ($rst->data as $rowt) {
            $idt_pergunta = $rowt['idt_pergunta'];
            $idt_resposta = $rowt['idt_resposta'];
            if ($vetVerifica[$idt_pergunta] == '') {
                $vetVerifica[$idt_pergunta] = 'NR';
            }
            if ($idt_resposta != '') {
                $vetVerifica[$idt_pergunta] = $idt_resposta;
            }
        }
    }
    $qtdG = 0;
    $qtdE = 0;
    $qtdR = 0;
    ForEach ($vetVerifica as $idt_pergunta => $status) {
        $qtdG = $qtdG + 1;
        if ($status == 'NR') {
            $qtdE = $qtdE + 1;
        } else {
            $qtdR = $qtdR + 1;
        }
    }
    $sql_a = ' update grc_avaliacao set ';
    $sql_a .= " qtd_g       = {$qtdG} " . ", ";
    $sql_a .= " qtd_e       = {$qtdE} " . ", ";
    $sql_a .= " qtd_r       = {$qtdR} " . "  ";
    $sql_a .= ' where idt  = ' . null($idt_avaliacao) . '  ';
    $result = execsql($sql_a);

    if ($qtdG > 0) {
        if ($qtdE > 0) {
            $idt_situacao = 2;
        } else {
            if ($grc_a_idt_situacao < 4) {
                $idt_situacao = 3;
            }
        }
    } else {
        $idt_situacao = 1;
    }
    if ($grc_a_idt_situacao < 4) {
        TrocaAvaliacaoSituacao($idt_avaliacao, $idt_situacao);
    }
    return $qtdE;
}

function TrocaAvaliacaoSituacao($idt_avaliacao, $idt_situacao) {

    if ($idt_situacao > 0 and $idt_situacao < 8) {
        $sql_a = ' update grc_avaliacao set ';
        $sql_a .= " idt_situacao = " . null($idt_situacao) . "  ";
        $sql_a .= ' where idt  = ' . null($idt_avaliacao) . '  ';
        $result = execsql($sql_a);
        //p($sql_a);
    }
}

function AbreAvaliacao($idt_avaliacao, $idt_formulario) {
    $sql = '';
    $sql .= ' select p.idt_secao, r.idt_pergunta, r.idt as idt_resposta, r.qtd_pontos, s.evidencia ';
    $sql .= ' from grc_formulario_secao s';
    $sql .= ' inner join grc_formulario_pergunta p on p.idt_secao = s.idt';
    $sql .= ' inner join grc_formulario_resposta r on r.idt_pergunta = p.idt';
    $sql .= ' where s.idt_formulario = ' . null($idt_formulario);
    $rs = execsql($sql);
    $vetDados = Array();
    $vetDadosS = Array();
    $vetsecao = Array();

    foreach ($rs->data as $row) {
        $vetsecao[idt_secao] = evidencia;

        $vetDados[$row['idt_pergunta']][$row['idt_resposta']] = Array(
            'idt_secao' => $row['idt_secao'],
            'qtd_pontos' => $row['qtd_pontos'],
        );
        $vetDadosS[$row['idt_pergunta']] = $row['idt_secao'];
        $vetDadosSE[$row['idt_pergunta']] = $row['evidencia'];
    }
    foreach ($vetDados as $idt_pergunta => $vetP) {
        $idt_secao = $vetDadosS[$row['idt_pergunta']];
        $qtd_pontos = $vetP[$idt_resposta]['qtd_pontos'];
        $resposta_txt = "";
        $idt_resposta = "";
        $sqlt = ' select grc_ar.idt';
        $sqlt .= ' from grc_avaliacao_resposta grc_ar';
        $sqlt .= ' where grc_ar.idt_formulario = ' . null($idt_formulario);
        $sqlt .= '   and grc_ar.idt_secao      = ' . null($idt_secao);
        $sqlt .= '   and grc_ar.idt_pergunta   = ' . null($idt_pergunta);
        $rst = execsql($sqlt);
        if ($rst->rows == 0) {
            $sql = 'insert into grc_avaliacao_resposta (idt_avaliacao, idt_formulario, idt_secao, idt_pergunta, idt_resposta, qtd_pontos, resposta_txt) values (';
            $sql .= null($idt_avaliacao) . ', ' . null($idt_formulario) . ', ' . null($idt_secao) . ', ' . null($idt_pergunta) . ', ' . null($idt_resposta) . ', ';
            $sql .= null($qtd_pontos) . ', ' . aspa($resposta_txt) . ')';
            execsql($sql);
        }

        $evidencia = $vetDadosSE[$row['idt_pergunta']];
        if ($evidencia == 'S') {
            $sqlt = ' select grc_se.idt';
            $sqlt .= ' from grc_avaliacao_secao grc_se';
            $sqlt .= ' where ';
            $sqlt .= ' grc_se.idt_avaliacao   = ' . null($idt_avaliacao);
            $sqlt .= ' grc_se.idt_formulario  = ' . null($idt_formulario);
            $sqlt .= '   and grc_se.idt_secao = ' . null($idt_secao);

            $rst = execsql($sqlt);
            if ($rst->rows == 0) {
                $sql = 'insert into grc_avaliacao_secao (idt_avaliacao, idt_formulario, idt_secao ) values (';
                $sql .= null($idt_avaliacao) . ', ' . null($idt_formulario) . ', ' . null($idt_secao);
                execsql($sql);
            }
        }
    }
    VerificaAvaliacaoRespostas($idt_avaliacao);
}

function ApurarResultado($idt_avaliacao) {
    $kokw = 0;
    //
    $sql = " select ";
    $sql .= "   grc_a.idt_situacao  as grc_a_idt_situacao  ";
    $sql .= " from grc_avaliacao grc_a ";
    $sql .= " where ";
    $sql .= " grc_a.idt = " . null($idt_avaliacao);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $grc_a_idt_situacao = $row['grc_a_idt_situacao'];
    }
    // Apurar Resultado
    $vetAvaliacao = Array();
    ApuracaoDiagnostico($idt_avaliacao, $vetAvaliacao);
    //	
    $kokw = 1;
    return $kokw;
}

function ApuracaoDiagnostico($idt_avaliacao, &$vetAvaliacao) {
    $kokw = 0;
    $vetAvaliacao = Array();
    $vetAvaliacaoA = Array();
    $vetAvaliacaoL = Array();
    $vetAvaliacaoQ = Array();
    //
    $vetAvaliacaoRank = Array();
    $vetAvaliacaoRankCla = Array();
    //
    $vetAvaliacaoRankClaIE = Array();
    $vetAvaliacaoRankClaIQ = Array();
    $vetAvaliacaoRankClaIA = Array();
    //
    $sql = "select ";
    $sql .= "   grc_a.idt_situacao  as grc_a_idt_situacao,  ";
    $sql .= "   grc_fa.idt          as grc_fa_idt,  ";
    $sql .= "   grc_fa.codigo       as grc_fa_codigo,  ";
    $sql .= "   grc_fa.descricao    as grc_fa_descricao,  ";
    $sql .= "   grc_fp.idt          as grc_fp_idt,  ";
    $sql .= "   grc_fp.codigo       as grc_fp_codigo,  ";
    $sql .= "   grc_fp.descricao    as grc_fp_descricao,  ";
    $sql .= "   grc_fp.codigo_quesito       as grc_fp_codigo_quesito,  ";
    $sql .= "   grc_fp.sigla_dimensao       as grc_fp_sigla_dimensao,   ";

    $sql .= "   grc_fr.idt          as grc_fr_idt,  ";
    $sql .= "   grc_fr.codigo       as grc_fr_codigo,  ";
    $sql .= "   grc_fr.descricao    as grc_fr_descricao,  ";
    $sql .= "   grc_ffg.codigo      as grc_ffg_codigo,  ";
    $sql .= "   grc_ffg.descricao   as grc_ffg_descricao,  ";
    $sql .= "   grc_ffg.nivel       as grc_ffg_nivel  ";

    $sql .= " from grc_avaliacao grc_a ";
    $sql .= " inner join grc_avaliacao_resposta grc_ar on grc_ar.idt_avaliacao = grc_a.idt ";
    $sql .= " inner join grc_formulario grc_f on grc_f.idt            = grc_ar.idt_formulario ";
    $sql .= " inner join grc_formulario_secao grc_fs on grc_fs.idt    = grc_ar.idt_secao ";
    $sql .= " inner join grc_formulario_area  grc_fa on grc_fa.idt    = grc_fs.idt_formulario_area ";
    $sql .= " inner join grc_formulario_pergunta grc_fp on grc_fp.idt = grc_ar.idt_pergunta ";
    $sql .= " left  join grc_formulario_ferramenta_gestao grc_ffg on grc_ffg.idt = grc_fp.idt_ferramenta ";
    $sql .= " inner join grc_formulario_resposta grc_fr on grc_fr.idt = grc_ar.idt_resposta ";
    $sql .= " where ";
    $sql .= " grc_a.idt = " . null($idt_avaliacao);
    $sql .= " and grc_fp.sigla_dimensao = " . aspa('E');
    $sql .= " and grc_f.codigo = " . aspa('50');
    $rs = execsql($sql);

    // p($sql);

    if ($rs->rows == 0) {
        // Não Encontrado
        return $kokw;
    } else {

        ForEach ($rs->data as $row) {
            $grc_a_idt_situacao = $row['grc_a_idt_situacao'];

            $grc_fa_idt = $row['grc_fa_idt'];
            $grc_fa_codigo = $row['grc_fa_codigo'];
            $grc_fa_descricao = $row['grc_fa_descricao'];


            $grc_fp_idt = $row['grc_fp_idt'];
            $grc_fp_codigo = $row['grc_fp_codigo'];
            $grc_fp_descricao = $row['grc_fp_descricao'];


            $grc_fp_codigo_quesito = $row['grc_fp_codigo_quesito'];
            $grc_fp_sigla_dimensao = $row['grc_fp_sigla_dimensao'];



            $grc_fr_idt = $row['grc_fr_idt'];
            $grc_fr_codigo = $row['grc_fr_codigo'];
            $grc_fr_descricao = $row['grc_fr_descricao'];

            $grc_ffg_codigo = $row['grc_ffg_codigo'];
            $grc_ffg_descricao = $row['grc_ffg_descricao'];
            $grc_ffg_nivel = $row['grc_ffg_nivel'];



            $vetAvaliacaoA[$grc_fa_codigo][$grc_fp_codigo] = $grc_fr_codigo;
            $vetAvaliacaoL[$grc_fa_codigo . "_" . $grc_fp_codigo] = $grc_fr_codigo;

            $vetAvaliacaoQ['99'] = $vetAvaliacaoQ['99'] + 1;
            $vetAvaliacaoQ[$grc_fa_codigo] = $vetAvaliacaoQ[$grc_fa_codigo] + 1;


            $vetAvaliacaoRank[$grc_fa_codigo][$grc_fp_codigo]['ferr'] = $grc_ffg_descricao;
            $vetAvaliacaoRank[$grc_fa_codigo][$grc_fp_codigo]['nive'] = $grc_ffg_nivel;
            $vetAvaliacaoRank[$grc_fa_codigo][$grc_fp_codigo]['resp'] = $grc_fr_codigo;

            if ($grc_ffg_nivel == '') {

                $grc_ffg_nivel = 9;
                $grc_ffg_descricao = "SEM FERRAMENTA";
            }
            if ($grc_fr_codigo == 3) {
                $grc_ffg_nivel = 8;
            }
            if ($grc_ffg_nivel != 8 and $grc_ffg_nivel != 9) {
                $linha = $grc_ffg_nivel . '-' . $grc_fr_codigo . '-' . $grc_fa_codigo . '-' . $grc_fp_codigo;
                $vetAvaliacaoRankCla[$linha] = $grc_ffg_descricao;
                $vetAvaliacaoRankClaIE[$linha] = $grc_fa_codigo . '-' . $grc_fp_codigo_quesito;
                $vetAvaliacaoRankClaIE[$linha] = $grc_fa_codigo . '-' . $grc_fp_codigo_quesito;
            }
        }
    }

    ksort($vetAvaliacaoRankCla);

    $vetAvaliacao['Q'] = $vetAvaliacaoQ;
    $vetAvaliacao['L'] = $vetAvaliacaoL;
    $vetAvaliacao['A'] = $vetAvaliacaoA;


    /////////////////////// àrea

    $vetAvaliacaoArA = Array();
    $vetAvaliacaoArL = Array();
    $vetAvaliacaoArQ = Array();
    //
    $sql = "select ";
    $sql .= "   grc_a.idt_situacao  as grc_a_idt_situacao,  ";
    $sql .= "   grc_fa.idt          as grc_fa_idt,  ";
    $sql .= "   grc_fa.codigo       as grc_fa_codigo,  ";
    $sql .= "   grc_fa.descricao    as grc_fa_descricao,  ";
    $sql .= "   grc_fp.idt          as grc_fp_idt,  ";
    $sql .= "   grc_fp.codigo       as grc_fp_codigo,  ";
    $sql .= "   grc_fp.descricao    as grc_fp_descricao,  ";
    $sql .= "   grc_fr.idt          as grc_fr_idt,  ";
    $sql .= "   grc_fr.codigo       as grc_fr_codigo,  ";
    $sql .= "   grc_fr.descricao    as grc_fr_descricao  ";
    $sql .= " from grc_avaliacao grc_a ";
    $sql .= " inner join grc_avaliacao_resposta grc_ar on grc_ar.idt_avaliacao = grc_a.idt ";
    $sql .= " inner join grc_formulario grc_f on grc_f.idt            = grc_ar.idt_formulario ";
    $sql .= " inner join grc_formulario_secao grc_fs on grc_fs.idt    = grc_ar.idt_secao ";
    $sql .= " inner join grc_formulario_area  grc_fa on grc_fa.idt    = grc_fs.idt_formulario_area ";
    $sql .= " inner join grc_formulario_pergunta grc_fp on grc_fp.idt = grc_ar.idt_pergunta ";
    $sql .= " inner join grc_formulario_resposta grc_fr on grc_fr.idt = grc_ar.idt_resposta ";
    $sql .= " where ";
    $sql .= " grc_a.idt = " . null($idt_avaliacao);
    $sql .= " and grc_fp.sigla_dimensao = " . aspa('A');
    $sql .= " and grc_f.codigo = " . aspa('50');
    $rs = execsql($sql);

    // p($sql);

    if ($rs->rows == 0) {
        // Não Encontrado
        return $kokw;
    } else {

        ForEach ($rs->data as $row) {
            $grc_a_idt_situacao = $row['grc_a_idt_situacao'];

            $grc_fa_idt = $row['grc_fa_idt'];
            $grc_fa_codigo = $row['grc_fa_codigo'];
            $grc_fa_descricao = $row['grc_fa_descricao'];


            $grc_fp_idt = $row['grc_fp_idt'];
            $grc_fp_codigo = $row['grc_fp_codigo'];
            $grc_fp_descricao = $row['grc_fp_descricao'];

            $grc_fr_idt = $row['grc_fr_idt'];
            $grc_fr_codigo = $row['grc_fr_codigo'];
            $grc_fr_descricao = $row['grc_fr_descricao'];

            $vetAvaliacaoArA[$grc_fa_codigo][$grc_fp_codigo] = $grc_fr_codigo;
            $vetAvaliacaoArL[$grc_fa_codigo . "_" . $grc_fp_codigo] = $grc_fr_codigo;

            $vetAvaliacaoArQ['99'] = $vetAvaliacaoArQ['99'] + 1;
            $vetAvaliacaoArQ[$grc_fa_codigo] = $vetAvaliacaoArQ[$grc_fa_codigo] + 1;

            $vetAvaliacaoRankClaIA[$grc_fp_idt] = $linha;
        }
    }

    $vetAvaliacao['Rank'] = $vetAvaliacaoRank;
    $vetAvaliacao['RankCla'] = $vetAvaliacaoRankCla;

    $vetAvaliacao['RankClaIE'] = $vetAvaliacaoRankClaIE;
    $vetAvaliacao['RankClaIQ'] = $vetAvaliacaoRankClaIQ;
    $vetAvaliacao['RankClaIA'] = $vetAvaliacaoRankClaIA;

    $vetAvaliacaoRankClaIQ = Array();
    $vetAvaliacaoRankClaIA = Array();


    $vetAvaliacao['QAr'] = $vetAvaliacaoArQ;
    $vetAvaliacao['LAr'] = $vetAvaliacaoArL;
    $vetAvaliacao['AAr'] = $vetAvaliacaoArA;

    /////////////////////////  Quesitos


    $vetAvaliacaoQeA = Array();
    $vetAvaliacaoQeL = Array();
    $vetAvaliacaoQeQ = Array();
    //
    $sql = "select ";
    $sql .= "   grc_a.idt_situacao  as grc_a_idt_situacao,  ";
    $sql .= "   grc_fa.idt          as grc_fa_idt,  ";
    $sql .= "   grc_fa.codigo       as grc_fa_codigo,  ";
    $sql .= "   grc_fa.descricao    as grc_fa_descricao,  ";
    $sql .= "   grc_fp.idt          as grc_fp_idt,  ";
    $sql .= "   grc_fp.codigo       as grc_fp_codigo,  ";
    $sql .= "   grc_fp.descricao    as grc_fp_descricao,  ";

    $sql .= "   grc_fp.codigo_quesito       as grc_fp_codigo_quesito,  ";
    $sql .= "   grc_fp.sigla_dimensao       as grc_fp_sigla_dimensao,   ";


    $sql .= "   grc_fr.idt          as grc_fr_idt,  ";
    $sql .= "   grc_fr.codigo       as grc_fr_codigo,  ";
    $sql .= "   grc_fr.descricao    as grc_fr_descricao  ";
    $sql .= " from grc_avaliacao grc_a ";
    $sql .= " inner join grc_avaliacao_resposta grc_ar on grc_ar.idt_avaliacao = grc_a.idt ";
    $sql .= " inner join grc_formulario grc_f on grc_f.idt            = grc_ar.idt_formulario ";
    $sql .= " inner join grc_formulario_secao grc_fs on grc_fs.idt    = grc_ar.idt_secao ";
    $sql .= " inner join grc_formulario_area  grc_fa on grc_fa.idt    = grc_fs.idt_formulario_area ";
    $sql .= " inner join grc_formulario_pergunta grc_fp on grc_fp.idt = grc_ar.idt_pergunta ";
    $sql .= " inner join grc_formulario_resposta grc_fr on grc_fr.idt = grc_ar.idt_resposta ";
    $sql .= " where ";
    $sql .= " grc_a.idt = " . null($idt_avaliacao);
    $sql .= " and grc_fp.sigla_dimensao = " . aspa('Q');
    $sql .= " and grc_f.codigo = " . aspa('50');
    $rs = execsql($sql);

    // p($sql);

    if ($rs->rows == 0) {
        // Não Encontrado
        return $kokw;
    } else {

        ForEach ($rs->data as $row) {
            $grc_a_idt_situacao = $row['grc_a_idt_situacao'];

            $idt_pergunta_q = $row['grc_fp_idt'];

            $grc_fa_idt = $row['grc_fa_idt'];
            $grc_fa_codigo = $row['grc_fa_codigo'];
            $grc_fa_descricao = $row['grc_fa_descricao'];

            $grc_fp_idt = $row['grc_fp_idt'];
            $grc_fp_codigo = $row['grc_fp_codigo'];
            $grc_fp_descricao = $row['grc_fp_descricao'];

            $grc_fr_idt = $row['grc_fr_idt'];
            $grc_fr_codigo = $row['grc_fr_codigo'];
            $grc_fr_descricao = $row['grc_fr_descricao'];

            $vetAvaliacaoQeA[$grc_fa_codigo][$grc_fp_codigo] = $grc_fr_codigo;
            $vetAvaliacaoQeL[$grc_fa_codigo . "_" . $grc_fp_codigo] = $grc_fr_codigo;

            $vetAvaliacaoQeQ['99'] = $vetAvaliacaoQeQ['99'] + 1;
            $vetAvaliacaoQeQ[$grc_fa_codigo] = $vetAvaliacaoQeQ[$grc_fa_codigo] + 1;
            //
            // Adicionar esse quesito nas perguntas adequadas....
            //
			/*
              $sqlp  = "select ";
              $sqlp .= "   grc_fpp.*  ";
              $sqlp .= " from grc_formulario_pergunta_pergunta grc_fpp ";
              $sqlp .= " inner join grc_formulario_pergunta grc_fp on grc_fp.idt = grc_fpp.idt_pergunta_n2 ";
              $sqlp .= " left  join grc_formulario_ferramenta_gestao grc_ffg on grc_ffg.idt = grc_fp.idt_ferramenta ";
              $sqlp .= " where ";
              $sqlp .= " grc_fpp.idt_pergunta_n1 = ".null($idt_pergunta_q);
              $rsp = execsql($sqlp);
              ForEach ($rsp->data as $rowp) {
              $grc_a_idt_situacaop = $rowp['grc_a_idt_situacao'];
              $grc_fa_idtp         = $rowp['grc_fa_idt'];
              $grc_fa_codigop      = $rowp['grc_fa_codigo'];
              $grc_fa_descricaop   = $rowp['grc_fa_descricao'];
              $grc_fp_idtp         = $rowp['grc_fp_idt'];
              $grc_fp_codigop      = $rowp['grc_fp_codigo'];
              $grc_fp_descricaop   = $rowp['grc_fp_descricao'];
              $grc_fr_idtp         = $rowp['grc_fr_idt'];
              $grc_fr_codigop      = $rowp['grc_fr_codigo'];
              $grc_fr_descricaop   = $rowp['grc_fr_descricao'];
              //
              $linha = $vetAvaliacaoRankClaIE[$grc_fp_idtp];
              $vetL  = $vetAvaliacaoRankCla[$linha];
              p($linha.' --- '.$vetL);
              //
              }
             */
        }
    }


    $vetAvaliacao['QQe'] = $vetAvaliacaoQeQ;
    $vetAvaliacao['LQe'] = $vetAvaliacaoQeL;
    $vetAvaliacao['AQe'] = $vetAvaliacaoQeA;

    // Ferramentas

    $vetAvaliacaoFeA = Array();
    $vetAvaliacaoFeL = Array();
    $vetAvaliacaoFeQ = Array();
    $vetAvaliacaoFeF = Array();
    //
    $sql = "select ";
    $sql .= "   grc_a.idt_situacao  as grc_a_idt_situacao,  ";
    $sql .= "   grc_fa.idt          as grc_fa_idt,  ";
    $sql .= "   grc_fa.codigo       as grc_fa_codigo,  ";
    $sql .= "   grc_fa.descricao    as grc_fa_descricao,  ";
    $sql .= "   grc_fp.idt          as grc_fp_idt,  ";
    $sql .= "   grc_fp.codigo       as grc_fp_codigo,  ";
    $sql .= "   grc_fp.descricao    as grc_fp_descricao,  ";
    $sql .= "   grc_fr.idt          as grc_fr_idt,  ";
    $sql .= "   grc_fr.codigo       as grc_fr_codigo,  ";
    $sql .= "   grc_fr.descricao    as grc_fr_descricao,  ";

    $sql .= "   grc_ffg.idt         as grc_ffg_idt,  ";
    $sql .= "   grc_ffg.descricao   as grc_ffg_descricao  ";



    $sql .= " from grc_avaliacao grc_a ";
    $sql .= " inner join grc_avaliacao_resposta grc_ar on grc_ar.idt_avaliacao = grc_a.idt ";
    $sql .= " inner join grc_formulario grc_f on grc_f.idt            = grc_ar.idt_formulario ";
    $sql .= " inner join grc_formulario_secao grc_fs on grc_fs.idt    = grc_ar.idt_secao ";
    $sql .= " inner join grc_formulario_area  grc_fa on grc_fa.idt    = grc_fs.idt_formulario_area ";
    $sql .= " inner join grc_formulario_pergunta grc_fp on grc_fp.idt = grc_ar.idt_pergunta ";

    $sql .= " inner join grc_formulario_ferramenta_gestao grc_ffg on grc_ffg.idt = grc_fp.idt_ferramenta ";

    $sql .= " inner join grc_formulario_resposta grc_fr on grc_fr.idt = grc_ar.idt_resposta ";
    $sql .= " where ";
    $sql .= " grc_a.idt = " . null($idt_avaliacao);
    $sql .= " and grc_fp.sigla_dimensao = " . aspa('E');
    $sql .= " and grc_f.codigo = " . aspa('50');
    $rs = execsql($sql);

    // p($sql);

    if ($rs->rows == 0) {
        // Não Encontrado
        return $kokw;
    } else {

        ForEach ($rs->data as $row) {
            $grc_a_idt_situacao = $row['grc_a_idt_situacao'];

            $grc_fa_idt = $row['grc_fa_idt'];
            $grc_fa_codigo = $row['grc_fa_codigo'];
            $grc_fa_descricao = $row['grc_fa_descricao'];


            $grc_fp_idt = $row['grc_fp_idt'];
            $grc_fp_codigo = $row['grc_fp_codigo'];
            $grc_fp_descricao = $row['grc_fp_descricao'];

            $grc_fr_idt = $row['grc_fr_idt'];
            $grc_fr_codigo = $row['grc_fr_codigo'];
            $grc_fr_descricao = $row['grc_fr_descricao'];

            $grc_ffg_idt = $row['grc_ffg_idt'];
            $grc_ffg_descricao = $row['grc_ffg_descricao'];

            $vetAvaliacaoFeF[$grc_fa_codigo][$grc_fp_codigo] = $grc_ffg_descricao;

            $vetAvaliacaoFeA[$grc_fa_codigo][$grc_fp_codigo] = $grc_fr_codigo;
            $vetAvaliacaoFeL[$grc_fa_codigo . "_" . $grc_fp_codigo] = $grc_fr_codigo;

            $vetAvaliacaoFeQ['99'] = $vetAvaliacaoFeQ['99'] + 1;
            $vetAvaliacaoFeQ[$grc_fa_codigo] = $vetAvaliacaoFeQ[$grc_fa_codigo] + 1;
        }
    }


    $vetAvaliacao['QFe'] = $vetAvaliacaoFeQ;
    $vetAvaliacao['LFe'] = $vetAvaliacaoFeL;
    $vetAvaliacao['AFe'] = $vetAvaliacaoFeA;

    $vetAvaliacao['FFe'] = $vetAvaliacaoFeF;
    //
    // Matriz de ferramentas 
    //
    //p($vetAvaliacao['AAr']); // área
    //p($vetAvaliacao['AQe']); // do quesito
    //p($vetAvaliacaoRankCla);
    //p($vetAvaliacaoRankClaIE); // base
    // P($vetAvaliacao);
    $vetRank = Array();
    ForEach ($vetAvaliacaoRankCla as $linha => $Ferramenta) {
        $vetatrib = explode('-', $linha);
        // $linha = $grc_ffg_nivel.'-'.$grc_fr_codigo.'-'.$grc_fa_codigo.'-'.$grc_fp_codigo;
        $grc_ffg_nivel = $vetatrib[0]; // Nível
        $grc_fr_codigo = $vetatrib[1]; // resposta Dimensão 1
        $grc_fa_codigo = $vetatrib[2]; // Área
        $grc_fp_codigo = $vetatrib[3]; // Pergunta
        $pergunta1 = $grc_fp_codigo;
        $resposta1 = $grc_fr_codigo;
        // Dimensão 2
        $quesito = $vetAvaliacaoRankClaIE[$linha];
        $vetatrib = explode('-', $quesito);
        $area = $vetatrib[0]; // Nível
        $quesito = $vetatrib[1]; // quesito Dimensão 2
        $resposta2 = $vetAvaliacao['AQe'][$area][$quesito]; // resposta 2

        $resposta3 = $vetAvaliacao['AAr'][$area][1]; // resposta 3

        $pesos = " {$grc_ffg_nivel}-{$resposta1}-{$resposta2}-{$resposta3}-{$area}-{$pergunta1} ";
        // 
        $vetRank[$pesos] = $Ferramenta;
        // 
    }
    ksort($vetRank);
    //p($vetRank);

    $vetAvaliacao['RankO'] = $vetRank;
    //p($vetAvaliacao['RankO']);

    $kokw = 1;
    return $kokw;
}

function NAN_CalcularOP($idt_nan_ordem_pagamento, &$vetResultado) {
    $kokw = 0;
    $vetResultado = Array();
    $vetResultado['QTDV1'] = 0;
    $vetResultado['VLV1'] = 0;
    $vetResultado['QTDV2'] = 0;
    $vetResultado['VLV2'] = 0;
    $vetResultado['QTTO'] = 0;
    $vetResultado['VLTO'] = 0;
    //
    //
   //
   $qtd_visita1 = 0;
    $qtd_visita2 = 0;
    $sql = 'select count(idt) as qtd_visita1 from grc_atendimento ';
    $sql .= ' where idt_nan_ordem_pagamento = ' . null($idt_nan_ordem_pagamento);
    $sql .= '   and nan_num_visita = 1';
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $qtd_visita1 = $row['qtd_visita1'];
    }
    $sql = 'select count(idt) as qtd_visita2 from grc_atendimento ';
    $sql .= ' where idt_nan_ordem_pagamento = ' . null($idt_nan_ordem_pagamento);
    $sql .= '   and nan_num_visita = 2';
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $qtd_visita2 = $row['qtd_visita2'];
    }
    $valor_visita1 = 0;
    $valor_visita2 = 0;
    NAN_ValorCadaVisita($valor_visita1, $valor_visita2);
    $valor_v1 = ($qtd_visita1 * $valor_visita1);
    $valor_v2 = ($qtd_visita2 * $valor_visita2);
    $valor_total = $valor_v1 + $valor_v2;

    $qtd_total_visitas = $qtd_visita1 + $qtd_visita2;
    $vetResultado['QTDV1'] = $qtd_visita1;
    $vetResultado['VLV1'] = $valor_v1;
    $vetResultado['QTDV2'] = $qtd_visita2;
    $vetResultado['VLV2'] = $valor_v2;
    $vetResultado['QTTO'] = $qtd_total_visitas;
    $vetResultado['VLTO'] = $valor_total;

    $sql = 'update grc_nan_ordem_pagamento set ';
    $sql .= " qtd_visitas1 = {$qtd_visita1} , ";
    $sql .= " qtd_visitas2 = {$qtd_visita2} , ";
    $sql .= " qtd_total_visitas = {$qtd_total_visitas} , ";
    $sql .= " valor_total  = {$valor_total} ";
    $sql .= ' where idt = ' . null($idt_nan_ordem_pagamento);
    execsql($sql);



    $kokw = 1;
    return $kokw;
}

function NAN_ValorCadaVisita(&$valor_visita1, &$valor_visita2) {
    $sql = '';
    $sql .= ' select valor_visita1, valor_visita2';
    $sql .= ' from grc_nan_parametros_projetos';
    $sql .= ' where idt = 1 ';
    $rs = execsql($sql);
    $valor_visita1 = $rs->data[0][0];
    $valor_visita2 = $rs->data[0][1];
}

function PLU_EstatisticaUtilizacao(&$vetParametros, &$vetEstatisticaUtilizacao, &$vetEstatisticaUtilizacaoGeral) {
    $vetEstatisticaUtilizacao = Array();
    $vetEstatisticaUtilizacaoGeral = Array();
    $vetSistemas = $vetParametros['sistemas'];
    $vetsistemasB = $vetParametros['bases'];
    $TotalUsuariosT = 0;
    ForEach ($vetSistemas as $sistema => $nome_sistema) {

        $base_B = $vetsistemasB[$sistema];
        $sql = "select ";
        $sql .= " distinct plu_ls.login , plu_ls.nom_usuario , plu_usu.id_usuario ";
        $sql .= " from {$base_B}.plu_log_sistema plu_ls ";
        $sql .= " left join {$base_B}.plu_usuario plu_usu on plu_usu.login = plu_ls.login";
        $sql .= " order by login";
        $rs = execsql($sql);
        $TotalUsuarios = 0;
        ForEach ($rs->data as $row) {
            if ($row['login'] == '') {
                continue;
            }
            $TotalUsuarios = $TotalUsuarios + 1;
            $id_log_sistema = $row['idt'];
            $login = $row['login'];
            $nom_usuario = $row['nom_usuario'];
            $id_usuario = $row['id_usuario'];
            $vetEstatisticaUtilizacao[$sistema][$login] = $row;
            $vetEstatisticaUtilizacaoGeral[$login][$sistema] = $id_usuario;
        }
        $vetEstatisticaUtilizacao['geral'][$sistema]['qtd_usuarios'] = $TotalUsuarios;
        $TotalUsuariosT = $TotalUsuariosT + $TotalUsuarios;
    }
    $vetEstatisticaUtilizacao['geral']['geral']['qtd_usuarios'] = $TotalUsuariosT;
    $kokw = 1;
    return $kokw;
}

function PLU_VerificaUsuario($idt_usuario, $baseB, &$vetTipoUsuario) {
    $kokw = 0;
    //
    // Acessar Usuário
    //
	$sql = "select ";
    $sql .= " plu_usu.*, plu_p.nm_perfil";
    $sql .= " from $baseB.plu_usuario plu_usu ";
    $sql .= " inner join {$baseB}.plu_perfil plu_p on plu_p.id_perfil = plu_usu.id_perfil ";
    $sql .= " where id_usuario = " . null($idt_usuario);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $id_usuario = $row['id_usuario'];
        $nome_completo = $row['nome_completo'];
        $login = $row['login'];
        $nm_perfil = $row['nm_perfil'];
        $matricula_intranet = $row['matricula_intranet'];
        $vetTipoUsuario['rowu'] = $row;
    }
    $kokw = 1;
    return $kokw;
}

/**
 * Gera condições para o where da tabela grc_atendimento_pendencia
 * @idt_avaliacao public IDT da Avaliacao ATUAL
 * @return Array  Vetor com Ciclo X Area X % OBTIDA 1 - anterior  2 - Atual
 * */
function CiclosAtualAnteriorNAN($idt_avaliacao, &$vetResultadoArea, &$vetResultadoAreaInv, &$vetResultadoAreaNum) {
    $kokw = 0;
    // Busca  a avaliação ATUAL
    $sql = "select  ";
    $sql .= "   grc_a.*,  ";
    $sql .= "   grc_at.protocolo as grc_at_protocolo,  ";
    $sql .= "   grc_as.descricao as grc_as_descricao,  ";
    $sql .= "   grc_atg.nan_ciclo as grc_atg_nan_ciclo,  ";
    $sql .= "   gec_eclio.codigo as gec_eclio_codigo, ";
    $sql .= "   gec_eclio.descricao as gec_eclio_descricao, ";
    $sql .= "   gec_eclip.descricao as gec_eclip_descricao, ";
    $sql .= "   gec_ecreo.descricao as gec_ecreo_descricao, ";
    $sql .= "   gec_ecrep.descricao as gec_ecrep_descricao ";
    $sql .= " from grc_avaliacao grc_a ";
    $sql .= " inner join grc_avaliacao_situacao grc_as on grc_as.idt = grc_a.idt_situacao ";
    $sql .= " inner join grc_atendimento        grc_at on grc_at.idt = grc_a.idt_atendimento ";
    $sql .= " inner join grc_nan_grupo_atendimento grc_atg on grc_atg.idt = grc_at.idt_grupo_atendimento ";
    $sql .= " left join " . db_pir_gec . "gec_entidade gec_eclio on gec_eclio.idt = grc_a.idt_organizacao_avaliado ";
    $sql .= " left join " . db_pir_gec . "gec_entidade gec_eclip on gec_eclip.idt = grc_a.idt_avaliado ";
    $sql .= " left join " . db_pir_gec . "gec_entidade gec_ecreo on gec_ecreo.idt = grc_a.idt_organizacao_avaliador ";
    $sql .= " left join " . db_pir_gec . "gec_entidade gec_ecrep on gec_ecrep.idt = grc_a.idt_avaliador ";
    $sql .= " where grc_a.idt = " . null($idt_avaliacao);
    $rs = execsql($sql);
    foreach ($rs->data as $row) {
        $grc_at_protocolo = $row['grc_at_protocolo'];
        $codigo = $row['codigo'];
        $descricao = $row['descricao'];
        $data_avaliacao = trata_data($row['data_avaliacao']);
        $gec_eclio_descricao = $row['gec_eclio_descricao'];
        $gec_eclip_descricao = $row['gec_eclip_descricao'];
        $gec_ecreo_descricao = $row['gec_ecreo_descricao'];
        $gec_ecrep_descricao = $row['gec_ecrep_descricao'];
        $grc_atg_nan_ciclo = $row['grc_atg_nan_ciclo'];
        $gec_eclio_codigo = $row['gec_eclio_codigo'];
    }
    $vetResultadoArea = Array();
    $vetResultadoAreaInv = Array();
    $vetResultadoAreaNum = Array();
    if ($grc_atg_nan_ciclo > 1) {
        // Se tem mais de um ciclo - Pega o anterior
        $sql = '';
        $sql .= ' select av.idt, g.nan_ciclo';
        $sql .= ' from grc_nan_grupo_atendimento g';
        $sql .= ' inner join ' . db_pir_gec . 'gec_entidade e on e.idt = g.idt_organizacao';
        $sql .= " inner join grc_atendimento a on a.idt_grupo_atendimento = g.idt ";
        $sql .= " inner join grc_avaliacao av on av.idt_atendimento = a.idt ";
        $sql .= ' where g.nan_ciclo < ' . null($grc_atg_nan_ciclo);
        $sql .= ' and e.codigo = ' . aspa($gec_eclio_codigo);
        $sql .= " and g.status_2 = 'AP'";
        $sql .= ' and a.nan_num_visita = 1';
        $sql .= ' order by g.idt desc, av.idt desc limit 1';
        $rs = execsql($sql);
        $rowx = $rs->data[0];
        // Atual e Anterior
        $vetResultadoArea[1] = CicloNAN($rowx['idt']);   // Anterior
        $vetResultadoArea[2] = CicloNAN($idt_avaliacao); // Atual
        $vetResultadoAreaNum[1] = $rowx['nan_ciclo'];    // Número do ciclo anterior
        $vetResultadoAreaNum[2] = $grc_atg_nan_ciclo;    // Número do Coclo Atual
    } else {
        // Só do atual
        $vetResultadoArea[1] = Array();                  // Número do ciclo anterior 
        $vetResultadoArea[2] = CicloNAN($idt_avaliacao); // Número do Coclo Atual
        $vetResultadoAreaNum[1] = 1;
        $vetResultadoAreaNum[2] = 2;
    }

    ForEach ($vetResultadoArea as $ciclo => $vetCiclo) {
        if (count($vetCiclo) == 0) {
            $vetResultadoAreaInv[$ciclo] = $vetCiclo;
        } else {
            ForEach ($vetCiclo as $area => $valor) {
                $valorInv = (100 - $valor);
                $vetResultadoAreaInv[$ciclo][$area] = $valorInv;
            }
        }
    }



    return $kokw;
}

/**
 * Gera condições para o where da tabela grc_atendimento_pendencia
 * @idt_avaliacao public IDT da Avaliacao
 * @return Array Vetor com Ciclo X Area X % OBTIDA
 * */
function CicloNAN($idt_avaliacao, &$vetRetorno) {
    $vetCiclo = Array();
    $sql = "select  ";
    $sql .= "   grc_fa.*,  ";
    $sql .= "   grc_fa.codigo     as grc_fa_codigo,  ";
    $sql .= "   grc_fa.descricao  as grc_fa_descricao,  ";
    $sql .= "   grc_adra.percentual as grc_adra_percentual  ";
    $sql .= " from grc_avaliacao grc_a ";
    $sql .= " inner join grc_avaliacao_devolutiva            grc_ad  on grc_ad.idt_avaliacao             = grc_a.idt ";
    $sql .= " inner join grc_avaliacao_devolutiva_resultado_area grc_adra on grc_adra.idt_avaliacao_devolutiva = grc_ad.idt ";
    $sql .= " inner join grc_formulario_area                 grc_fa  on grc_fa.idt                       = grc_adra.idt_area ";
    $sql .= " where grc_a.idt = " . null($idt_avaliacao);
    $sql .= " order by grc_fa.codigo ";
    $rs = execsqlNomeCol($sql);
    foreach ($rs->data as $row) {

        $grc_fa_codigo = $row['grc_fa_codigo'];
        $grc_fa_descricao = $row['grc_fa_descricao'];
        $grc_adra_percentual = $row['grc_adra_percentual'];
        $vetCiclo[$grc_fa_codigo] = $grc_adra_percentual;
        $vetRetorno[$grc_fa_codigo] = $row;
    }

    return $vetCiclo;
}

/**
 * Gera condições para o where da tabela grc_atendimento_pendencia
 * @idt_avaliacao public IDT da Avaliacao ATUAL
 * @return Array  Vetor com Ciclo X Area X % OBTIDA 1 - anterior  2 - Atual
 * */
function CiclosAtualAnteriorSetorNAN($idt_avaliacao, &$vetResultadoArea, &$vetResultadoAreaInv, &$vetCliente) {
    $kokw = 0;
    $vetCliente = Array();
    // Busca  a avaliação ATUAL
    set_time_limit(90);

    $sql = "select  ";
    $sql .= "   grc_a.*,  ";
    $sql .= "   grc_at.protocolo    as grc_at_protocolo,  ";
    $sql .= "   grc_as.descricao    as grc_as_descricao,  ";
    $sql .= "   grc_atg.nan_ciclo   as grc_atg_nan_ciclo,  ";
    $sql .= "   gec_eclio.codigo    as gec_eclio_codigo, ";
    $sql .= "   gec_eclio.descricao as gec_eclio_descricao, ";
    $sql .= "   gec_eclip.descricao as gec_eclip_descricao, ";
    $sql .= "   gec_ecreo.descricao as gec_ecreo_descricao, ";
    $sql .= "   gec_ecrep.descricao as gec_ecrep_descricao, ";
    $sql .= "   gec_eo.idt_entidade_setor as gec_eo_idt_entidade_setor, ";
    $sql .= "   gec_es.descricao          as gec_es_descricao ";
    $sql .= " from grc_avaliacao grc_a ";
    $sql .= " inner join grc_avaliacao_situacao grc_as on grc_as.idt = grc_a.idt_situacao ";
    $sql .= " inner join grc_atendimento        grc_at on grc_at.idt = grc_a.idt_atendimento ";
    $sql .= " inner join grc_nan_grupo_atendimento grc_atg on grc_atg.idt = grc_at.idt_grupo_atendimento ";
    $sql .= " left join " . db_pir_gec . "gec_entidade gec_eclio on gec_eclio.idt = grc_a.idt_organizacao_avaliado ";
    $sql .= " left join " . db_pir_gec . "gec_entidade_organizacao gec_eo on gec_eo.idt_entidade = gec_eclio.idt ";
    $sql .= " left join " . db_pir_gec . "gec_entidade_setor gec_es on gec_es.idt = gec_eo.idt_entidade_setor ";
    $sql .= " left join " . db_pir_gec . "gec_entidade gec_eclip on gec_eclip.idt = grc_a.idt_avaliado ";
    $sql .= " left join " . db_pir_gec . "gec_entidade gec_ecreo on gec_ecreo.idt = grc_a.idt_organizacao_avaliador ";
    $sql .= " left join " . db_pir_gec . "gec_entidade gec_ecrep on gec_ecrep.idt = grc_a.idt_avaliador ";
    $sql .= " where grc_a.idt = " . null($idt_avaliacao);

    $rs = execsql($sql);

    foreach ($rs->data as $row) {
        // dados da Empresa
        $gec_eclio_codigo = $row['gec_eclio_codigo'];
        $gec_eo_idt_entidade_setor = $row['gec_eo_idt_entidade_setor'];
        $gec_es_descricao = $row['gec_es_descricao'];
        $gec_eclio_descricao = $row['gec_eclio_descricao'];

        $vetCliente['cnpj'] = $gec_eclio_codigo;
        $vetCliente['razao_social'] = $gec_eclio_descricao;
        $vetCliente['idt_setor'] = $gec_eo_idt_entidade_setor;
        $vetCliente['descricao_setor'] = $gec_es_descricao;
        $grc_at_protocolo = $row['grc_at_protocolo'];
        $codigo = $row['codigo'];
        $descricao = $row['descricao'];
        $data_avaliacao = trata_data($row['data_avaliacao']);
        $gec_eclio_descricao = $row['gec_eclio_descricao'];
        $gec_eclip_descricao = $row['gec_eclip_descricao'];
        $gec_ecreo_descricao = $row['gec_ecreo_descricao'];
        $gec_ecrep_descricao = $row['gec_ecrep_descricao'];
        $grc_atg_nan_ciclo = $row['grc_atg_nan_ciclo'];
        $gec_eclio_codigo = $row['gec_eclio_codigo'];
    }

    $vetResultadoArea = Array();
    $vetResultadoAreaInv = Array();
    $ciclo_setor = $grc_atg_nan_ciclo - 1;

    $sql = '';
    $sql .= ' select grc_ncs.* ';
    $sql .= ' from grc_nan_ciclo_setor grc_ncs ';
    $sql .= ' where grc_ncs.tipo    = ' . aspa('G');
    $sql .= ' and grc_ncs.ciclo     = ' . null($ciclo_setor);
    $sql .= ' and grc_ncs.idt_setor = ' . null($gec_eo_idt_entidade_setor);
    $sql .= ' order by grc_ncs.area ';
    $rs = execsql($sql);

    if ($rs->rows == 0 && $ciclo_setor > 0) {
        $ret = GerarBaseCicloNAN($ciclo_setor);
        $rs = execsql($sql);
    }

    foreach ($rs->data as $row) {
        $ciclo = $row['ciclo'];
        $idt_avaliacao = $row['idt_avaliacao'];
        $idt_setor = $row['idt_setor'];
        $descricao_setor = $row['descricao_setor'];
        $cnpj = $row['cnpj'];
        $razao_social = $row['razao_social'];
        $idt_area = $row['idt_area'];
        $area = $row['area'];
        $descricao_area = $row['descricao_area'];
        $valor = $row['valor'];
        $valor_inv = $row['valor_inv'];

        $valor_medio = $row['valor_medio'];
        $valor_medio_inv = $row['valor_medio_inv'];


        $vetResultadoArea[$area] = $valor_medio;
        $vetResultadoAreaInv[$area] = $valor_medio_inv;
    }
    return $kokw;
}

function GerarBaseCicloNAN($cicloBase) {
    set_time_limit(300);

    $kokw = 0;
    $sql = '';
    $sql .= ' select av.idt as av_idt, g.nan_ciclo, ';
    $sql .= "   gec_eclio.codigo          as gec_eclio_codigo, ";
    $sql .= "   gec_eclio.descricao       as gec_eclio_descricao, ";
    $sql .= "   gec_eo.idt_entidade_setor as gec_eo_idt_entidade_setor, ";
    $sql .= "   gec_es.descricao          as gec_es_descricao ";
    $sql .= ' from grc_nan_grupo_atendimento g';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade e on e.idt = g.idt_organizacao';
    $sql .= " inner join grc_atendimento a on a.idt_grupo_atendimento = g.idt ";
    $sql .= " inner join grc_avaliacao av on av.idt_atendimento = a.idt ";
    $sql .= " inner join " . db_pir_gec . "gec_entidade gec_eclio on gec_eclio.idt = av.idt_organizacao_avaliado ";
    $sql .= " inner join " . db_pir_gec . "gec_entidade_organizacao gec_eo on gec_eo.idt_entidade = gec_eclio.idt ";
    $sql .= " inner join " . db_pir_gec . "gec_entidade_setor gec_es on gec_es.idt = gec_eo.idt_entidade_setor ";
    $sql .= ' where g.nan_ciclo =  ' . null($cicloBase);
    // $sql .= ' and e.codigo = ' . aspa($gec_eclio_codigo);
    $sql .= " and g.status_2 = 'AP'";
    $sql .= ' and a.nan_num_visita = 1';
    //$sql .= ' order by g.idt desc, av.idt desc limit 1';
    $rs = execsqlNomeCol($sql);

    // p($rs);

    beginTransaction();
    set_time_limit(90);

    $sql_d = 'delete from grc_nan_ciclo_setor ';
    $sql_d .= ' where ciclo = ' . null($cicloBase);
    $result = execsql($sql_d);


    $vetSetorGeralQtd = Array();
    $vetSetorGeralValor = Array();
    $vetSetorGeralValorInv = Array();

    foreach ($rs->data as $row) {
        set_time_limit(90);

        $idt_avaliacao = $row['av_idt'];
        $gec_eclio_codigo = $row['gec_eclio_codigo'];
        $gec_eo_idt_entidade_setor = $row['gec_eo_idt_entidade_setor'];
        $gec_es_descricao = $row['gec_es_descricao'];
        $gec_eclio_descricao = $row['gec_eclio_descricao'];
        $vetCiclo = CicloNAN($idt_avaliacao, $vetRetorno);

        $ciclo = $cicloBase;
        $idt_setor = $gec_eo_idt_entidade_setor;
        $descricao_setor = aspa($gec_es_descricao);
        $cnpj = aspa($gec_eclio_codigo);
        $razao_social = aspa($gec_eclio_descricao);



        ForEach ($vetCiclo as $areaw => $valor) {
            $area = aspa($areaw);
            $rowarea = $vetRetorno[$areaw];
            $idt_area = null($rowarea['idt']);
            $descricao_area = aspa($rowarea['descricao']);
            $valor_inv = 100 - $valor;
            $vetSetorDescricao[$idt_setor] = $gec_es_descricao;
            $vetAreaDescricao[$areaw] = $rowarea['descricao'];
            $vetAreaIdt[$areaw] = $idt_area;

            $vetSetorGeralQtd[$idt_setor][$areaw] = $vetSetorGeralQtd[$idt_setor][$areaw] + 1;
            $vetSetorGeralValor[$idt_setor][$areaw] = $vetSetorGeralValor[$idt_setor][$areaw] + $valor;
            $vetSetorGeralValorInv[$idt_setor][$areaw] = $vetSetorGeralValorInv[$idt_setor][$areaw] + $valor_inv;

            $tipo = aspa("A");

            $sql_i = ' insert into grc_nan_ciclo_setor ';
            $sql_i .= ' (  ';
            $sql_i .= " ciclo, ";
            $sql_i .= " tipo, ";
            $sql_i .= " idt_avaliacao, ";
            $sql_i .= " idt_setor, ";
            $sql_i .= " descricao_setor, ";
            $sql_i .= " cnpj, ";
            $sql_i .= " razao_social, ";
            $sql_i .= " idt_area, ";
            $sql_i .= " area, ";
            $sql_i .= " descricao_area, ";
            $sql_i .= " valor, ";
            $sql_i .= " valor_inv ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $ciclo, ";
            $sql_i .= " $tipo, ";
            $sql_i .= " $idt_avaliacao, ";
            $sql_i .= " $idt_setor, ";
            $sql_i .= " $descricao_setor, ";
            $sql_i .= " $cnpj, ";
            $sql_i .= " $razao_social, ";
            $sql_i .= " $idt_area, ";
            $sql_i .= " $area, ";
            $sql_i .= " $descricao_area, ";
            $sql_i .= " $valor, ";
            $sql_i .= " $valor_inv ";
            $sql_i .= ") ";
            $result = execsql($sql_i);
        }
    }
    // Gerar total
    //p($vetSetorGeralQtd);
    //p($vetSetorGeralValor);
    //p($vetSetorGeralValorInv);

    ForEach ($vetSetorGeralQtd as $idt_setor => $vetArea) {
        set_time_limit(90);

        ForEach ($vetArea as $area => $Qtd) {
            $valor = $vetSetorGeralValor[$idt_setor][$area];
            $valor_inv = $vetSetorGeralValorInv[$idt_setor][$area];
            $valor_medio = ($valor / $Qtd);
            $valor_medio_inv = 100 - $valor_medio;

            $descricao_setor = aspa($vetSetorDescricao[$idt_setor]);
            $descricao_area = aspa($vetAreaDescricao[$area]);
            $idt_area = null($vetAreaIdt[$area]);

            $ciclo = $cicloBase;
            $idt_avaliacao = "null";
            $cnpj = "null";
            $razao_social = "null";
            $area = aspa($area);

            $tipo = aspa("G");

            $quantidade = null($Qtd);



            $valor = null($valor);
            $valor_inv = null($valor_inv);
            $valor_medio = null($valor_medio);
            $valor_medio_inv = null($valor_medio_inv);


            $sql_i = ' insert into grc_nan_ciclo_setor ';
            $sql_i .= ' (  ';
            $sql_i .= " ciclo, ";
            $sql_i .= " tipo, ";
            $sql_i .= " idt_avaliacao, ";
            $sql_i .= " idt_setor, ";
            $sql_i .= " descricao_setor, ";
            $sql_i .= " cnpj, ";
            $sql_i .= " razao_social, ";
            $sql_i .= " idt_area, ";
            $sql_i .= " area, ";
            $sql_i .= " descricao_area, ";
            $sql_i .= " valor, ";
            $sql_i .= " valor_inv, ";
            $sql_i .= " quantidade, ";
            $sql_i .= " valor_medio, ";
            $sql_i .= " valor_medio_inv ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $ciclo, ";
            $sql_i .= " $tipo, ";
            $sql_i .= " $idt_avaliacao, ";
            $sql_i .= " $idt_setor, ";
            $sql_i .= " $descricao_setor, ";
            $sql_i .= " $cnpj, ";
            $sql_i .= " $razao_social, ";
            $sql_i .= " $idt_area, ";
            $sql_i .= " $area, ";
            $sql_i .= " $descricao_area, ";
            $sql_i .= " $valor, ";
            $sql_i .= " $valor_inv, ";
            $sql_i .= " $quantidade, ";
            $sql_i .= " $valor_medio, ";
            $sql_i .= " $valor_medio_inv ";
            $sql_i .= ") ";
            $result = execsql($sql_i);
        }
    }

    commit();
    return $kokw;
}

// fim do programa