<?php
if ($plu_sigla_interna != 'GWS') {
    Require_Once('funcao_integracao.php');
    Require_Once('funcao_gerencial.php');
    Require_Once('funcao_acao.php');
}

function ChamaAtendimento($idt_atendimento_agenda, $idt_cliente, &$variavel) {
    if ($_SESSION[CS]['g_idt_projeto'] == '' || $_SESSION[CS]['g_idt_acao'] == '') {
        die('O Projeto e Ação devem estar informado no usuário para poder fazer um atendimento!');
    }

    $kokw = 0;
    $sql_aa = ' select idt, idt_consultor from grc_atendimento_agenda ';
    $sql_aa .= ' where  idt = ' . null($idt_atendimento_agenda);
    $result = execsql($sql_aa);
    if ($result->rows != 1) {
        return 2;
    } else {

        $idt_consultor = '';
        $idt_atendimento_agenda = '';
        ForEach ($result->data as $row) {
            $idt_atendimento_agenda = $row['idt'];
            $idt_consultor = $row['idt_consultor'];
        }
    }

    beginTransaction();
    set_time_limit(30);


    if ($idt_consultor == '') {
        $idt_consultor = $_SESSION[CS]['g_id_usuario'];
    }
    $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
    $idt_projeto = $_SESSION[CS]['g_idt_projeto'];
    $idt_projeto_acao = $_SESSION[CS]['g_idt_acao'];
    $gestor_sge = aspa($_SESSION[CS]['g_projeto_gestor']);
    $fase_acao_projeto = aspa($_SESSION[CS]['g_projeto_etapa']);

    $sql = '';
    $sql .= ' select data';
    $sql .= ' from grc_atendimento';
    $sql .= " where idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
    $rs = execsql($sql);
    $idt_competencia = idtCompetencia(trata_data($rs->data[0][0]));




    $sql_a = " update grc_atendimento set ";
    $sql_a .= " idt_competencia       = $idt_competencia, ";
    $sql_a .= " idt_consultor         = $idt_consultor, ";
    $sql_a .= " idt_ponto_atendimento = $idt_ponto_atendimento, ";
    $sql_a .= " idt_projeto           = $idt_projeto, ";
    $sql_a .= " idt_projeto_acao      = $idt_projeto_acao, ";
    $sql_a .= " gestor_sge            = $gestor_sge, ";
    $sql_a .= " fase_acao_projeto     = $fase_acao_projeto ";
    $sql_a .= " where idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);


    $datadiaw = (date('d/m/Y H:i:s'));
    $segundo = true;
    $datadia = aspa(trata_data($datadiaw, $segundo));


    //$idt_atendimento_box = 1;
    $idt_atendimento_box = $_SESSION[CS]['g_idt_atendimento_box'];


    $vet = explode(' ', $datadiaw);
    $hora = aspa(substr($vet[1], 0, 5));
    /*
      $sql_a  = " update grc_atendimento_agenda set ";
      $sql_a .= " hora_atendimento = ".$hora ;
      $sql_a .= " where idt = ".null($idt_atendimento_agenda);
      $result = execsql($sql_a);
     */

    $sql_a = " update grc_atendimento_agenda_painel set ";
    $sql_a .= " status_painel = '20', ";
    $sql_a .= " idt_atendimento_box = " . null($idt_atendimento_box) . ", ";
    $sql_a .= " idt_consultor       = $idt_consultor, ";
    $sql_a .= " data_hora_chamada   = " . $datadia;
    $sql_a .= " where idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);
    commit();
    $kokw = 1;
    return $kokw;
}

function BloqueiaHorario($idt_atendimento_agenda, &$variavel) {
    $kokw = 0;
    $sql_aa = ' select idt, idt_cliente, situacao from grc_atendimento_agenda ';
    $sql_aa .= ' where  idt = ' . null($idt_atendimento_agenda);
    $result = execsql($sql_aa);
    if ($result->rows != 1) {
        return 2;
    } else {

        ForEach ($result->data as $row) {
            $situacao = $row['situacao'];
            $idt_cliente = $row['idt_cliente'];
        }
    }
    if ($idt_cliente > 0) {
        // Não pode Bloqueiar
        return 3;
    }
    // 
    if ($situacao == 'Agendado' or $situacao == 'Cancelado') {
        $sql_a = ' update grc_atendimento_agenda set ';
        $sql_a .= " situacao          = 'Bloqueado'";
        $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
        $result = execsql($sql_a);
        $kokw = 1;
        return $kokw;
    } else {
        return 4;
    }
}

function DesbloqueiaHorario($idt_atendimento_agenda, &$variavel) {
    $kokw = 0;
    $sql_aa = ' select idt, idt_cliente, situacao from grc_atendimento_agenda ';
    $sql_aa .= ' where  idt = ' . null($idt_atendimento_agenda);
    $result = execsql($sql_aa);
    if ($result->rows != 1) {
        return 2;
    } else {
        ForEach ($result->data as $row) {
            $situacao = $row['situacao'];
            $idt_cliente = $row['idt_cliente'];
        }
    }
    // 
    if ($situacao == 'Bloqueado') {
        $sql_a = ' update grc_atendimento_agenda set ';
        $sql_a .= " situacao          = 'Agendado'";
        $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
        $result = execsql($sql_a);
    } else {
        return 4;
    }

    $kokw = 1;
    return $kokw;
}

function CancelaHorario($idt_atendimento_agenda, &$variavel) {
    $kokw = 0;
    $sql_aa = ' select idt, idt_cliente, situacao from grc_atendimento_agenda ';
    $sql_aa .= ' where  idt = ' . null($idt_atendimento_agenda);
    $result = execsql($sql_aa);
    if ($result->rows != 1) {
        return 2;
    } else {

        ForEach ($result->data as $row) {
            $situacao = $row['situacao'];
            $idt_cliente = $row['idt_cliente'];
        }
    }
    if ($idt_cliente > 0) {
        // Não pode Bloquear
        return 3;
    }
    // 
    if ($situacao == 'Agendado' or $situacao == 'Bloqueado') {
        $sql_a = ' update grc_atendimento_agenda set ';
        $sql_a .= " situacao          = 'Cancelado'";
        $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
        $result = execsql($sql_a);
        $kokw = 1;
        return $kokw;
    } else {
        return 4;
    }
}

function DescancelaHorario($idt_atendimento_agenda, &$variavel) {
    $kokw = 0;
    $sql_aa = ' select idt, idt_cliente, situacao from grc_atendimento_agenda ';
    $sql_aa .= ' where  idt = ' . null($idt_atendimento_agenda);
    $result = execsql($sql_aa);
    if ($result->rows != 1) {
        return 2;
    } else {
        ForEach ($result->data as $row) {
            $situacao = $row['situacao'];
            $idt_cliente = $row['idt_cliente'];
        }
    }
    // 
    if ($situacao == 'Cancelado') {
        $sql_a = ' update grc_atendimento_agenda set ';
        $sql_a .= " situacao          = 'Agendado'";
        $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
        $result = execsql($sql_a);
    } else {
        return 4;
    }

    $kokw = 1;
    return $kokw;
}

function CancelaAgendamento($idt_atendimento_agenda, &$variavel) {
    $kokw = 0;

    $sql_a = ' update grc_atendimento_agenda set ';
    $sql_a .= " situacao          = 'Cancelado'";
    $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
    $result = execsql($sql_a);



    $kokw = 1;
    return $kokw;
}

function ConfirmaChegada($idt_atendimento_agenda, &$variavel) {

    $kokw = 0;
    $datadiaw = (date('d/m/Y H:i:s'));
    $segundo = true;
    $datadia = aspa(trata_data($datadiaw, $segundo));


    $sql_a = " update grc_atendimento_agenda_painel set ";
    $sql_a .= " status_painel     = '01', ";
    $sql_a .= " data_hora_chegada = " . $datadia;
    $sql_a .= " where idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);

    $kokw = 1;
    return $kokw;
}

function ConfirmaAusencia($idt_atendimento_agenda, &$variavel) {

    $kokw = 0;
    $datadiaw = aspa(trata_data($variavel['data']));
    $sql_a = " update grc_atendimento_agenda set ";
    $sql_a .= " data_hora_ausencia = " . $datadiaw;
    $sql_a .= " where idt  = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);

    $kokw = 1;
    return $kokw;
}

function ConfirmaLiberacao($idt_atendimento_agenda, &$variavel) {
    $kokw = 0;
    $datadiaw = (date('d/m/Y H:i:s'));
    $segundo = true;
    $datadia = aspa(trata_data($datadiaw, $segundo));


    $sql_a = " update grc_atendimento_agenda_painel set ";
    $sql_a .= " status_painel = '02', ";
    $sql_a .= " data_hora_liberacao = " . $datadia;
    $sql_a .= " where idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);


    $kokw = 1;
    return $kokw;
}

function ConfirmaAtendimento($idt_atendimento_agenda, &$variavel) {
    $kokw = 0;
    $datadiaw = (date('d/m/Y H:i:s'));
    $segundo = true;
    $datadia = aspa(trata_data($datadiaw, $segundo));

    $vet = explode(' ', $datadiaw);
    $hora = aspa(substr($vet[1], 0, 5));

    beginTransaction();
    set_time_limit(30);
    //
    $sql_a = " update grc_atendimento_agenda set ";
    $sql_a .= " hora_atendimento = " . $hora;
    $sql_a .= " where idt = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);
    // Iniciar atendimento
    $sql_a = " update grc_atendimento_agenda_painel set ";
    $sql_a .= " status_painel = '80', ";
    $sql_a .= " data_hora_atendimento = " . $datadia;
    $sql_a .= " where idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);
    //
    commit();
    //p($sql_a);

    $kokw = 1;
    return $kokw;
}

function TerminarAtendimento($idt_atendimento_agenda, &$variavel) {
    $kokw = 0;
    $datadiaw = (date('d/m/Y H:i:s'));
    $segundo = true;
    $datadia = aspa(trata_data($datadiaw, $segundo));

    $vet = explode(' ', $datadiaw);
    $hora = aspa(substr($vet[1], 0, 5));

    beginTransaction();
    set_time_limit(30);
    //
    $sql_a = " update grc_atendimento_agenda set ";
    $sql_a .= " hora_final_atendimento = " . $hora;
    $sql_a .= " where idt = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);
    // Terminar atendimento
    $sql_a = " update grc_atendimento_agenda_painel set ";
    $sql_a .= " status_painel = '99', ";
    $sql_a .= " data_hora_atendimento = " . $datadia;
    $sql_a .= " where idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);
    commit();
    $kokw = 1;
    return $kokw;
}

//
// Função para Gerar Agenda
//
function geracao_agenda($idt_atendimento_gera_agenda, $vetret) {
    $kokw = 0;
    $sql = 'select ';
    $sql .= '  grc_aga.*   ';
    $sql .= '  from grc_atendimento_gera_agenda grc_aga ';
    $sql .= '  where grc_aga.idt = ' . null($idt_atendimento_gera_agenda);
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        return 2;
    }
    $arquivo = '';


    ForEach ($rs->data as $row) {
        //  $idt_usuario   = $row['idt_usuario'];
//        p('aqui 1');


        $data_geracao = $row['dt_geracao'];
        $data_inicial = $row['dt_inicial'];
        $data_final = $row['dt_final'];
        $idt_consultor = $row['idt_consultor'];
        $idt_ponto_atendimento = $row['idt_ponto_atendimento'];

        $sql1 = 'select ';
        $sql1 .= '  grc_aud.*   ';
        $sql1 .= '  from grc_atendimento_usuario_disponibilidade grc_aud ';
        $sql1 .= '  where grc_aud.ativo = ' . aspa('S');

        if ($idt_consultor != 0) {
            $sql1 .= ' and grc_aud.idt_usuario = ' . null($idt_consultor);
        }

        $sql1 .= '  order by grc_aud.idt ';


//        p('aqui 1.1');


        $rs_aud = execsql($sql1);

        if ($rs_aud->rows == 0) {

            //          p('aqui 1.2');

            return 2;
        }
        $arquivo = '';



        ForEach ($rs_aud->data as $row_aud) {


            $data_inicial = $row['dt_inicial'];


//            p('aqui 2');

            $idt_usuario = $row_aud['idt_usuario'];
            $dia = $row_aud['dia'];
            $hora_inicial = $row_aud['hora_inicial'];
            $hora_final = $row_aud['hora_final'];
            $duracao = $row_aud['duracao'];
            $detalhe = $row_aud['detalhe'];


            while ($data_inicial <= $data_final) {

                //             p('aqui 3');


                $data_inicial_aux = substr($data_inicial, 8, 2) . '/' . substr($data_inicial, 5, 2) . '/' . substr($data_inicial, 0, 4);
                //           p('data_inicial aux     '.$data_inicial_aux);


                $dia_semana = GRC_DiaSemana($data_inicial_aux, 'resumo1');   // formato dd/mm/aaaa
//               p('data_inicial  '.$data_inicial);
                //             p('dia  '.$dia);
                //           p('dia_semana  '.$dia_semana);

                if ($dia == $dia_semana) {
                    while ($hora_inicial < $hora_final) {
                        // verifica se registro existe
//                      p('aqui 4.1');
//                      p('HORA_INICIAL - '.$hora_inicial);
                        //                    p('HORA_final   - '.$hora_final);


                        $kokw = 0;
                        $sql2 = 'select ';
                        $sql2 .= '  grc_aa.*   ';
                        $sql2 .= '  from grc_atendimento_agenda grc_aa ';
                        $sql2 .= '  where grc_aa.idt_consultor = ' . null($idt_usuario);
                        $sql2 .= '  and grc_aa.data = ' . aspa($data_inicial);
                        $sql2 .= '  and grc_aa.hora = ' . aspa($hora_inicial);

//                      p('sql =   '.$sql2);


                        $rs_aa = execsql($sql2);


                        //                    p('aqui 4.2');



                        if ($rs_aa->rows == 0) {


                            //                          p('aqui 5');
                            // grava registro

                            $idt_consultor_agenda = $idt_usuario;
                            $idt_cliente_agenda = 0;
                            $idt_especialidade_agenda = 0;
                            $data_agenda = aspa($data_inicial);
                            $hora_agenda = aspa($hora_inicial);
                            $origem_agenda = aspa('Hora Marcada');
                            $detalhe_agenda = aspa($detalhe);
                            $situacao_agenda = aspa('Agendado');
                            $data_confirmacao_agenda = aspa('');
                            $hora_confirmacao_agenda = aspa('');
                            $telefone_agenda = aspa('');
                            $hora_chegada_agenda = aspa('');
                            $hora_atendimento_agenda = aspa('');
                            $idt_ponto_atendimento_agenda = null($idt_ponto_atendimento);
                            $dia_semana_agenda = aspa($dia_semana);
                            $hora_liberacao_agenda = aspa('');
                            $celular_agenda = aspa('');
                            $observacao_chegada_agenda = aspa('');
                            $observacao_atendimento_agenda = aspa('');
                            $cliente_texto_agenda = aspa('');
                            $tipo_pessoa_agenda = aspa('S');

                            $sql_i = ' insert into grc_atendimento_agenda ';
                            $sql_i .= ' (  ';
                            $sql_i .= ' idt_consultor, ';
                            $sql_i .= ' idt_cliente, ';
                            $sql_i .= ' idt_especialidade, ';
                            $sql_i .= ' data, ';
                            $sql_i .= ' hora, ';
                            $sql_i .= ' origem, ';
                            $sql_i .= ' detalhe, ';
                            $sql_i .= ' situacao, ';
                            $sql_i .= ' data_confirmacao, ';
                            $sql_i .= ' hora_confirmacao, ';
                            $sql_i .= ' telefone, ';
                            $sql_i .= ' hora_chegada, ';
                            $sql_i .= ' hora_atendimento, ';
                            $sql_i .= ' idt_ponto_atendimento, ';
                            $sql_i .= ' dia_semana, ';
                            $sql_i .= ' hora_liberacao, ';
                            $sql_i .= ' celular, ';
                            $sql_i .= ' observacao_chegada, ';
                            $sql_i .= ' observacao_atendimento, ';
                            $sql_i .= ' cliente_texto, ';
                            $sql_i .= ' tipo_pessoa,  ';
                            $sql_i .= ' idt_atendimento_gera_agenda ';
                            $sql_i .= '  ) values ( ';
                            $sql_i .= " $idt_consultor_agenda, ";
                            $sql_i .= " $idt_cliente_agenda, ";
                            $sql_i .= " $idt_especialidade_agenda, ";
                            $sql_i .= " $data_agenda, ";
                            $sql_i .= " $hora_agenda, ";
                            $sql_i .= " $origem_agenda, ";
                            $sql_i .= " $detalhe_agenda, ";
                            $sql_i .= " $situacao_agenda, ";
                            $sql_i .= " $data_confirmacao_agenda, ";
                            $sql_i .= " $hora_confirmacao_agenda, ";
                            $sql_i .= " $telefone_agenda, ";
                            $sql_i .= " $hora_chegada_agenda, ";
                            $sql_i .= " $hora_atendimento_agenda, ";
                            $sql_i .= " $idt_ponto_atendimento_agenda, ";
                            $sql_i .= " $dia_semana_agenda, ";
                            $sql_i .= " $hora_liberacao_agenda, ";
                            $sql_i .= " $celular_agenda, ";
                            $sql_i .= " $observacao_chegada_agenda, ";
                            $sql_i .= " $observacao_atendimento_agenda, ";
                            $sql_i .= " $cliente_texto_agenda, ";
                            $sql_i .= " $tipo_pessoa_agenda, ";
                            $sql_i .= " $idt_atendimento_gera_agenda ";
                            $sql_i .= ') ';
                            $result = execsql($sql_i);
                        }
                        //$hora_inicial = $hora_inicial + $duracao

                        $HH = substr($hora_inicial, 0, 2);
                        $MM = substr($hora_inicial, 3, 2);

                        $MM_aux = $MM + $duracao;
                        $HH_aux = $HH + 0;

                        if ($MM_aux >= 60) {
                            $MM_aux = $MM_aux - 60;
                            $HH_aux = $HH_aux + 1;
                        }

                        if ($HH_aux < 10) {
                            $HH_aux = '0' . (string) $HH_aux;
                        }
                        if ($MM_aux < 10) {
                            $MM_aux = '0' . (string) $MM_aux;
                        }

//                      p('HH -   '.$HH_aux);
//                      p('MM -   '.$MM_aux);


                        $hora_inicial = $HH_aux . ':' . $MM_aux;


//                      p('hora -   '.$hora_inicial);
                        // exit();
                    }
                }

                // somar 1 na data
                //   p('data - '.$data_inicial);


                $data_inicial = strtotime($data_inicial . '+1 days');

                //  $data_inicial1 = date('d/m/Y',$data_inicial);
                $data_inicial = date('Y-m-d', $data_inicial);


                // p('nova data - '.$data_inicial);
            }
        }
    }
    $kokw = 1;
    return $kokw;
}

function CalculaMediaAtendimento($idt_grc_atendimento_pa_pessoa) {
    $sql = 'select ';
    $sql .= '   grc_apps.periodo as periodo_minimo   ';
    $sql .= '  from  grc_atendimento_pa_pessoa grc_app ';
    $sql .= '  inner join grc_atendimento_pa_pessoa_servico grc_apps on grc_apps.idt_pa_pessoa = grc_app.idt ';
    //$sql .= '  inner join grc_atendimento_especialidade grc_agae on grc_agae.idt = grc_apps.idt_servico  ';
    $sql .= '  where grc_app.idt = ' . null($idt_grc_atendimento_pa_pessoa);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        return 2;
    }
    $menor_duracao = 99999;
    ForEach ($rs->data as $row) {
        $periodo_minimo = $row['periodo_minimo'];
        if ($periodo_minimo < $menor_duracao) {
            $menor_duracao = $periodo_minimo;
        }
    }


    $duracao = $menor_duracao;

    $sql_a = " update grc_atendimento_pa_pessoa set ";
    $sql_a .= " duracao  = $duracao ";
    $sql_a .= " where idt = " . null($idt_grc_atendimento_pa_pessoa);
    $result = execsql($sql_a);
    return $duracao;
}

//
// Função para Gerar Agenda formato do sebrae sem Disponibilidadade
//
function geracao_agenda_sebrae($idt_atendimento_gera_agenda, $vetret) {



    $kokw = 0;

    $datadiaw = trata_data(date('d/m/Y'));


    $sql = 'select ';
    $sql .= '  grc_aga.*   ';
    $sql .= '  from grc_atendimento_gera_agenda grc_aga ';
    $sql .= '  where grc_aga.idt = ' . null($idt_atendimento_gera_agenda);
    $rsP = execsql($sql);
    if ($rsP->rows == 0) {
        return 2;
    }
    ForEach ($rsP->data as $row) {
        $idt_consultor = $row['idt_consultor'];
        $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
        break;
    }
    $duracao_media = 30;
    // Acessa grc_atendimento_pa_pessoa
    $sql = 'select ';
    $sql .= '  grc_app.*, grc_apps.periodo as grc_apps_periodo, grc_apps.idt_servico as grc_apps_idt_servico    ';
    $sql .= '  from grc_atendimento_pa_pessoa grc_app ';
    $sql .= '  inner join grc_atendimento_pa_pessoa_servico grc_apps on grc_apps.idt_pa_pessoa = grc_app.idt';
    $sql .= '  where grc_app.idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
    $sql .= '    and grc_app.idt_usuario           = ' . null($idt_consultor);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        return 2;
    }
    $vetServicosPessoa = Array();
    ForEach ($rs->data as $row) {
        $duracao = $row['duracao'];
        $grc_apps_idt_servico = $row['grc_apps_idt_servico'];
        $grc_apps_periodo = $row['grc_apps_periodo'];
        $vetServicosPessoa[$grc_apps_idt_servico] = $grc_apps_periodo;
        //break;
    }
    if ($duracao > 0) {
        $duracao_media = $duracao;
    }
    $sql = 'select ';
    $sql .= '  grc_agae.*, grc_agas.idt_servico as grc_agas_idt_servico    ';
    $sql .= '  from grc_atendimento_gera_agenda grc_aga ';
    $sql .= '  inner join grc_atendimento_gera_agenda_servico grc_agas on grc_agas.idt = grc_aga.idt ';
    $sql .= '  inner join grc_atendimento_especialidade grc_agae on grc_agae.idt = grc_agas.idt_servico  ';



    // considerar o da pessoa que já tem o valor aí pega o menor

    $sql .= '  where grc_aga.idt = ' . null($idt_atendimento_gera_agenda);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        //return 2;
    }
    $menor_periodo = 999999;
    ForEach ($rs->data as $row) {
        $grc_agas_idt_servico = $row['grc_agas_idt_servico'];
        $grc_apps_periodo = $vetServicosPessoa[$grc_agas_idt_servico];
        if ($grc_apps_periodo == '') {
            continue;
        }
        if ($grc_apps_periodo < $menor_periodo) {
            $menor_periodo = $grc_apps_periodo;
        }
    }

    if ($menor_periodo == 999999) {
        $menor_periodo = 15;
    }

    $duracao = $menor_periodo;

    //echo " -------------------- $duracao <br />"

    $arquivo = '';
    ForEach ($rsP->data as $row) {

        set_time_limit(30);
        $data_geracao = $row['dt_geracao'];
        $data_inicial = $row['dt_inicial'];
        $data_final = $row['dt_final'];
        $idt_consultor = $row['idt_consultor'];
        $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
        $hora_inicio = $row['hora_inicio'];
        $hora_fim = $row['hora_fim'];
        $hora_intervalo_inicio = $row['hora_intervalo_inicio'];
        $hora_intervalo_fim = $row['hora_intervalo_fim'];
        $horario_semanal = $row['horario_semanal'];
        $data_aleatoria = $row['data_aleatoria'];
        $comentario_data_variavel = $row['comentario_data_variavel'];


        //$duracao                  = 30;  


        $vetDisponibilidade = Array();
        $vetServicos = Array();
        // Acessa Serviços		
        $sql_s = 'select ';
        $sql_s .= '  grc_agas.*   ';
        $sql_s .= '  from grc_atendimento_gera_agenda_servico grc_agas ';
        $sql_s .= '  where grc_agas.idt = ' . null($idt_atendimento_gera_agenda);
        $rs_s = execsql($sql_s);
        if ($rs_s->rows > 0) {
            ForEach ($rs_s->data as $row_s) {
                $idt_servico = $row_s['idt_servico'];
                $vetServicos[] = $idt_servico;
            }
        }

        //
        // Gerar a disponibilidade
        //
		$vetd[0] = 'Dom';
        $vetd[1] = 'Seg';
        $vetd[2] = 'Ter';
        $vetd[3] = 'Qua';
        $vetd[4] = 'Qui';
        $vetd[5] = 'Sex';
        $vetd[6] = 'Sáb';
        $testaferiado = "S";
        $geranosferiados = 0; // não gera agenda aleatoria para feriados
        $verificaditeito = VerificaDireitoAgenda();
        if ($verificaditeito == 1) {
            $geranosferiados = 1;
        }
        $deuerro = 1;
        if ($data_aleatoria != "") {
            // tem datas aleatórias
            // se tem direito a gerar nos feriados então é N
            if ($geranosferiados == 1) {
                $testaferiado = "N";
            } else {
                // Não gera nos feriados
            }
            $vetDatas = Array();
            $ret = GeraVetorData($data_inicial, $data_final, $data_aleatoria, $vetDatas);
            if ($ret == 0) {
                $deuerro = 0;
                //  $deuerro	
            }
        } else {
            if ($geranosferiados == 1) {
                $testaferiado = "N";
            } else {
                // Não gera nos feriados
            }
        }

        //p(" datas = $data_inicial, $data_final, $data_aleatoria");
        //else
        //{ // Não tem datas aleatórias $horario_semanal=S
        // Gera para seg ---> sex 
        //for ($d = 0; $d <= 6; $d++) {
        //for ($d = 1; $d <= 5; $d++) {

        if ($testaferiado == "N") {
            $de = 0;
            $ate = 6;
        } else {
            $de = 1;
            $ate = 5;
        }
        for ($d = $de; $d <= $ate; $d++) {

            $row_aud = Array();
            if ($hora_intervalo_inicio == "") {
                $row_aud['data_inicial'] = $data_inicial;
                $row_aud['idt_usuario'] = $idt_consultor;
                $row_aud['dia'] = $vetd[$d];
                $row_aud['hora_inicial'] = $hora_inicio;
                $row_aud['hora_final'] = $hora_fim;
                $row_aud['duracao'] = $duracao;
                $row_aud['detalhe'] = $comentario_data_variavel;
                $vetDisponibilidade[] = $row_aud;
            } else {
                $row_aud['data_inicial'] = $data_inicial;
                $row_aud['idt_usuario'] = $idt_consultor;
                $row_aud['dia'] = $vetd[$d];
                $row_aud['hora_inicial'] = $hora_inicio;
                $row_aud['hora_final'] = $hora_intervalo_inicio; // Hora fim 1 periodo
                $row_aud['duracao'] = $duracao;
                $row_aud['detalhe'] = $comentario_data_variavel;
                $vetDisponibilidade[] = $row_aud;
                $row_aud['data_inicial'] = $data_inicial;
                $row_aud['idt_usuario'] = $idt_consultor;
                $row_aud['dia'] = $vetd[$d];
                $row_aud['hora_inicial'] = $hora_intervalo_fim;
                $row_aud['hora_final'] = $hora_fim; // Hora fim 1 periodo
                $row_aud['duracao'] = $duracao;
                $row_aud['detalhe'] = $comentario_data_variavel;
                $vetDisponibilidade[] = $row_aud;
            }
        }
        //}
        /*
          $sql1 = 'select ';
          $sql1 .= '  grc_aud.*   ';
          $sql1 .= '  from grc_atendimento_usuario_disponibilidade grc_aud ';
          $sql1 .= '  where grc_aud.ativo = '.aspa('S');
          if ($idt_consultor != 0) {
          $sql1 .= ' and grc_aud.idt_usuario = '.null($idt_consultor);
          }
          $sql1 .= '  order by grc_aud.idt ';
          $rs_aud = execsql($sql1);
          if ($rs_aud->rows == 0) {
          return 2;
          }
          $arquivo = '';
          ForEach ($rs_aud->data as $row_aud) {
         */
        //p($vetDisponibilidade);
        $dt_inicial_salva = $row['dt_inicial'];
        foreach ($vetDisponibilidade as $linha => $row_aud) {
            $data_inicial = $dt_inicial_salva;
            $idt_usuario = $row_aud['idt_usuario'];
            $dia = $row_aud['dia'];
            $hora_inicial = $row_aud['hora_inicial'];
            $hora_final = $row_aud['hora_final'];
            $duracao = $row_aud['duracao'];
            $detalhe = $row_aud['detalhe'];

            //  echo "entrar com nova data - $data_inicial final $data_final<br >";
            if ($data_aleatoria != "") {
                $ateale = (count($vetDatas) - 1);
                $indiceale = 0;
                $data_inicial = trata_data($vetDatas[$indiceale]);
                $data_final = trata_data($vetDatas[$ateale]);
            }
            //  echo " 22222222222222 ------- $data_inicial --- $data_final <br />";
            //p($vetDatas);

            $nvez = 0;
            while ($data_inicial <= $data_final) {

                set_time_limit(30);

                $hora_inicial = $row_aud['hora_inicial'];
                $hora_final = $row_aud['hora_final'];
                $duracao = $row_aud['duracao'];

                $nvez = $nvez + 1;
                if ($data_aleatoria != "") {
                    if (trata_data($vetDatas[$indiceale]) != $data_inicial) {

                        $data_inicial = strtotime($data_inicial . ' +1 days');
                        //  $data_inicial1 = date('d/m/Y',$data_inicial);
                        $data_inicial = date('Y-m-d', $data_inicial);

                        if ($nvez > 50) {
                            break;
                        }

                        continue;
                    }
                }
                // testar se a data existe em outro PA
                $sql3 = 'select ';
                $sql3 .= '  grc_aa.idt   ';
                $sql3 .= '  from grc_atendimento_agenda grc_aa ';
                $sql3 .= '  where grc_aa.idt_consultor = ' . null($idt_usuario);
                $sql3 .= '  and grc_aa.origem = ' . aspa('Hora Marcada');
                $sql3 .= '  and grc_aa.data   = ' . aspa($data_inicial);
                //$sql3 .= '  and grc_aa.hora = ' . aspa($hora_inicial);
                $sql3 .= '  and idt_ponto_atendimento <> ' . null($idt_ponto_atendimento);
                $rs_aa3 = execsqlNomeCol($sql3);
                if ($rs_aa3->rows == 0) {
                    
                } else {
                    continue;

                    // Ver se existe para outro pa
                    //foreach ($rs_aa3->data as $rowt3) {
                    //	if ($rowt3['idt_ponto_atendimento']!=$idt_ponto_atendimento)
                    //	{
                    //		continue;
                    //	}
                    //}		
                }




                ////////////////////////////////////////////////
                //	echo "variando nova data - $data_inicial final $data_final<br >";
                $data_inicial_aux = substr($data_inicial, 8, 2) . '/' . substr($data_inicial, 5, 2) . '/' . substr($data_inicial, 0, 4);
                $dia_semana = GRC_DiaSemana($data_inicial_aux, 'resumo1');   // formato dd/mm/aaaa
                // testar se é feriado para o pronto de atendimento	
                $feriado = "N";
                if ($testaferiado == "S") {
                    $data_feriado = aspa($data_inicial);
                    $sql = 'select ';
                    $sql .= '   grc_aps.idt  ';
                    $sql .= ' from grc_agenda_parametro_suspensao grc_aps ';
                    $sql .= " where idt_parametro = 1 ";
                    $sql .= '   and idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
                    $sql .= '   and data                  = ' . $data_feriado;
                    $rst = execsqlNomeCol($sql);
                    if ($rst->rows > 0) {
                        foreach ($rst->data as $rowt) {
                            $feriado = "S";
                        }
                    }
                }


                //	p($vetDatas);

                if ($feriado != "S") {

                    //      echo "dia - $dia == $dia_semana $hora_inicial < $hora_final <br >";


                    if ($dia == $dia_semana) {
                        while ($hora_inicial < $hora_final) {
                            // verifica se registro existe

                            $kokw = 0;
                            $sql2 = 'select ';
                            //$sql2 .= '  grc_aa.*   ';
                            $sql2 .= '  grc_aa.idt   ';
                            $sql2 .= '  from grc_atendimento_agenda grc_aa ';
                            $sql2 .= '  where grc_aa.idt_consultor = ' . null($idt_usuario);
                            $sql2 .= '  and grc_aa.origem = ' . aspa('Hora Marcada');
                            $sql2 .= '  and grc_aa.data = ' . aspa($data_inicial);
                            $sql2 .= '  and grc_aa.hora = ' . aspa($hora_inicial);
                            $sql2 .= '  and idt_ponto_atendimento = ' . null($idt_ponto_atendimento);

                            //      p('sql =   '.$sql2);


                            $rs_aa = execsqlNomeCol($sql2);


                            //                    p('aqui 4.2');
                            //echo "Vai Grava - $data_inicial Hora $hora_inicial<br >";

                            if ($rs_aa->rows == 0) {

                                //              echo "Grava - $data_inicial Hora $hora_inicial<br >";
                                //                          p('aqui 5');
                                // grava registro

                                $idt_consultor_agenda = $idt_usuario;
                                $idt_cliente_agenda = 0;
                                $idt_especialidade_agenda = 0;
                                $data_agenda = aspa($data_inicial);
                                $hora_agenda = aspa($hora_inicial);
                                $origem_agenda = aspa('Hora Marcada');
                                $detalhe_agenda = aspa($detalhe);
                                $situacao_agenda = aspa('Agendado');
                                $data_confirmacao_agenda = aspa('');
                                $hora_confirmacao_agenda = aspa('');
                                $telefone_agenda = aspa('');
                                $hora_chegada_agenda = aspa('');
                                $hora_atendimento_agenda = aspa('');
                                $idt_ponto_atendimento_agenda = null($idt_ponto_atendimento);
                                $dia_semana_agenda = aspa($dia_semana);
                                $hora_liberacao_agenda = aspa('');
                                $celular_agenda = aspa('');
                                $observacao_chegada_agenda = aspa('');
                                $observacao_atendimento_agenda = aspa('');
                                $cliente_texto_agenda = aspa('');
                                $tipo_pessoa_agenda = aspa('S');

                                $sql_i = ' insert into grc_atendimento_agenda ';
                                $sql_i .= ' (  ';
                                $sql_i .= ' idt_consultor, ';
                                $sql_i .= ' idt_cliente, ';
                                $sql_i .= ' idt_especialidade, ';
                                $sql_i .= ' data, ';
                                $sql_i .= ' hora, ';
                                $sql_i .= ' origem, ';
                                $sql_i .= ' detalhe, ';
                                $sql_i .= ' situacao, ';
                                $sql_i .= ' data_confirmacao, ';
                                $sql_i .= ' hora_confirmacao, ';
                                $sql_i .= ' telefone, ';
                                $sql_i .= ' hora_chegada, ';
                                $sql_i .= ' hora_atendimento, ';
                                $sql_i .= ' idt_ponto_atendimento, ';
                                $sql_i .= ' dia_semana, ';
                                $sql_i .= ' hora_liberacao, ';
                                $sql_i .= ' celular, ';
                                $sql_i .= ' observacao_chegada, ';
                                $sql_i .= ' observacao_atendimento, ';
                                $sql_i .= ' cliente_texto, ';
                                $sql_i .= ' tipo_pessoa,  ';
                                $sql_i .= ' idt_atendimento_gera_agenda ';
                                $sql_i .= '  ) values ( ';
                                $sql_i .= " $idt_consultor_agenda, ";
                                $sql_i .= " $idt_cliente_agenda, ";
                                $sql_i .= " $idt_especialidade_agenda, ";
                                $sql_i .= " $data_agenda, ";
                                $sql_i .= " $hora_agenda, ";
                                $sql_i .= " $origem_agenda, ";
                                $sql_i .= " $detalhe_agenda, ";
                                $sql_i .= " $situacao_agenda, ";
                                $sql_i .= " $data_confirmacao_agenda, ";
                                $sql_i .= " $hora_confirmacao_agenda, ";
                                $sql_i .= " $telefone_agenda, ";
                                $sql_i .= " $hora_chegada_agenda, ";
                                $sql_i .= " $hora_atendimento_agenda, ";
                                $sql_i .= " $idt_ponto_atendimento_agenda, ";
                                $sql_i .= " $dia_semana_agenda, ";
                                $sql_i .= " $hora_liberacao_agenda, ";
                                $sql_i .= " $celular_agenda, ";
                                $sql_i .= " $observacao_chegada_agenda, ";
                                $sql_i .= " $observacao_atendimento_agenda, ";
                                $sql_i .= " $cliente_texto_agenda, ";
                                $sql_i .= " $tipo_pessoa_agenda, ";
                                $sql_i .= " $idt_atendimento_gera_agenda ";
                                $sql_i .= ') ';
                                $result = execsql($sql_i);
                                $idt_grc_atendimento_agenda = lastInsertId();
                                $servicos = "";
                                $servicos_idt = "";
                                foreach ($vetServicos as $indice => $idt_servico) {
                                    $sql_i = ' insert into grc_atendimento_agenda_servico ';
                                    $sql_i .= ' ( idt, idt_servico)  values  ';
                                    $sql_i .= " ( $idt_grc_atendimento_agenda, $idt_servico )";
                                    $result = execsql($sql_i);
                                    $idt_grc_atendimento_agenda_servico = lastInsertId();
                                    $servicos_idt .= $idt_servico . "#";
                                    // Acessa Serviços
                                    $servico = "N/E";
                                    $sql_s = 'select ';
                                    $sql_s .= '  grc_ae.descricao   ';
                                    $sql_s .= '  from grc_atendimento_especialidade grc_ae ';
                                    $sql_s .= '  where grc_ae.idt = ' . null($idt_servico);
                                    $rs_s = execsql($sql_s);
                                    if ($rs_s->rows > 0) {
                                        ForEach ($rs_s->data as $row_s) {
                                            $servico = $row_s['descricao'];
                                        }
                                    }
                                    $servicos .= $servico . "<br />";
                                    //$servicos     .= $servico.chr(13);
                                }
                                $servicosw = aspa($servicos);
                                $servicos_idtw = aspa($servicos_idt);
                                $sql_a = ' update grc_atendimento_agenda set ';
                                $sql_a .= " servicos          = " . $servicosw . ',  ';
                                $sql_a .= ' servicos_idt      = ' . $servicos_idtw . '  ';
                                $sql_a .= ' where idt = ' . null($idt_grc_atendimento_agenda);
                                $result = execsql($sql_a);
                            }
                            //$hora_inicial = $hora_inicial + $duracao

                            $HH = substr($hora_inicial, 0, 2);
                            $MM = substr($hora_inicial, 3, 2);

                            $MM_aux = $MM + $duracao;
                            $HH_aux = $HH + 0;

                            if ($MM_aux >= 60) {
                                $resto_mm = $MM_aux % 60;
                                $numero_aa = (integer) ($MM_aux / 60);

                                //$MM_aux = $MM_aux - 60;
                                //$HH_aux = $HH_aux + 1;
                                $MM_aux = $resto_mm;
                                $HH_aux = $HH_aux + $numero_aa;
                            }

                            if ($HH_aux < 10) {
                                $HH_aux = '0' . (string) $HH_aux;
                            }
                            if ($MM_aux < 10) {
                                $MM_aux = '0' . (string) $MM_aux;
                            }

//                      p('HH -   '.$HH_aux);
//                      p('MM -   '.$MM_aux);


                            $hora_inicial = $HH_aux . ':' . $MM_aux;


//                      p('hora -   '.$hora_inicial);
                            // exit();
                        }
                    }
                }
                // somar 1 na data
                //   p('data - '.$data_inicial);

                if ($data_aleatoria != "") {
                    $indiceale = $indiceale + 1;
                    $data_inicial = trata_data($vetDatas[$indiceale]);
                    if ($indiceale > $ateale) {
                        break;
                    }
                } else {
                    $data_inicial = strtotime($data_inicial . '+1 days');

                    //  $data_inicial1 = date('d/m/Y',$data_inicial);
                    $data_inicial = date('Y-m-d', $data_inicial);
                }
            }
        }
    }


    //echo " $feriado == $feriado ";
    //die();

    $kokw = 1;
    //exit();
    return $kokw;
}

function VerificaConsultorData($idt_consultor, $idt_ponto_atendimento, $data) {
    $sql3 = 'select ';
    $sql3 .= '  grc_aa.idt   ';
    $sql3 .= '  from grc_atendimento_agenda grc_aa ';
    $sql3 .= '  where grc_aa.idt_consultor = ' . null($idt_consultor);
    $sql3 .= '  and grc_aa.origem = ' . aspa('Hora Marcada');
    $sql3 .= '  and grc_aa.data   = ' . aspa($data);
    $sql3 .= '  and idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
    $sql3 .= '  limit 1 ';
    $rs_aa3 = execsqlNomeCol($sql3);
    if ($rs_aa3->rows == 0) {
        $kokw = 0;
    } else {
        $kokw = 1;
    }
    return $kokw;
}

function VerificaDireitoAgenda() {
    $direito = 0;
    $idt_usuario = $_SESSION[CS]['g_id_usuario'];
    $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];


    $sql = 'select ';
    $sql .= '   grc_app.*  ';
    $sql .= ' from grc_atendimento_pa_pessoa grc_app ';
    $sql .= " where idt_usuario = " . null($idt_usuario);
    $sql .= '   and idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
    $rst = execsqlNomeCol($sql);
    if ($rst->rows > 0) {
        foreach ($rst->data as $rowt) {
            if ($rowt['pode_feriado'] == 'S') {
                $direito = 1;
            }
        }
    }
    //echo " direito  == $direito ";
    //p($rowt);
    //die();
    //
    // Buscar direito para gerar agenda aleatória nos feriados
    //
    return $direito;
}

function VerificaDataAleatoria(&$vet) {
    $kokw = 1;
    $erro = "";
    $data_aleatoria = $vet['data_aleatoria'];
    $data_inicial = trata_data($vet['dt_ini']);
    $data_final = trata_data($vet['dt_fim']);
    //
    $vetDatas = Array();
    GeraVetorData($data_inicial, $data_final, $data_aleatoria, $vetDatas);
    // p($vetDatas);
    $erro = "";
    $tam = count();
    $datasgeradas = " Verifique as Datas que serão Geradas\n";
    $datasgeradas .= " após Confirmação:\n";
    $datasgeradas = rawurlencode($datasgeradas);
    $virgula = "";
    ForEach ($vetDatas as $Ordem => $DataGerada) {
        $datasgeradas .= $virgula . $DataGerada;
        $virgula = "\n";
    }

    $vet['erro'] = $erro;
    $vet['datasgeradas'] = $datasgeradas;
    //
    return $kokw;
}

//
function GeraVetorData($data_inicial, $data_final, $data_aleatoria, &$vetDatas) {
    $kokw = 1;
    $vetDT = Array();
    $vetDia = Array();
    $vet = explode(';', $data_aleatoria);
    $tam = count($vet);
    for ($tp = 0; $tp < $tam; $tp++) {
        $ele = $vet[$tp];

        if ($ele != '') {
            $vetdis = explode('-', $ele);
            $tamdis = count($vetdis);
            if ($tamdis == 1) {
                $diaw = trim($vetdis[0]);
                $dia = zeroEsq($diaw, 2);
                $vetDia[$dia] = $dia;
            } else { // è intervalo
                $int1 = trim($vetdis[0]);
                $int2 = trim($vetdis[1]);

                $qtd = ($int2 - $int1) + 1;

                if ($qtd > 0) {
                    for ($d = 0; $d < $qtd; $d++) {
                        $dia = $int1 + $d;
                        $dia = zeroEsq($dia, 2);
                        $vetDia[$dia] = $dia;
                    }
                }
            }
        }
    }
    ksort($vetDia);

    //p($vet);
    //p($vetDia);

    $veti = explode('-', $data_inicial);
    $vetf = explode('-', $data_final);
    $dia_i = $veti[2];
    $mes_i = $veti[1];
    $ano_i = $veti[0];

    $dia_f = $vetf[2];
    $mes_f = $vetf[1];
    $ano_f = $vetf[0];
    //p($veti);
    //p($vetf);
    //echo "  $mes_i == $mes_f and $ano_i == $ano_f <br />";
    if ($mes_i == $mes_f and $ano_i == $ano_f) {
        $diapri = "";
        $diault = "";
        foreach ($vetDia as $ind => $dia) {
            if ($diapri == "") {
                $diapri = $dia;
            }
            $diault = $dia;
            $dataaleatoria = $dia . "/" . $mes_i . "/" . $ano_i;
            if ($dia != '00') {
                $vetDT[] = $dataaleatoria;
            }
        }
        if ($diapri >= $dia_i and $diault <= $dia_f) {
            
        } else {
            $kokw = 0;
        }
    } else { // não pode ser alaeatótio
        $kokw = 0;
    }


    $vetDatas = $vetDT;

    // p($vetDatas);

    return $kokw;
}

///////////////////// carregar Agenda existente
//
// Função para Excluir Agenda
//
function CarregarAgendaExistente($idt_atendimento_gera_agenda, &$vetret) {
    $kokw = 0;
    $vetMarcados = Array();
    $vetLivres = Array();
    $vetAgenda = Array();
    //p('00000 '.$idt_atendimento_gera_agenda);
    //p($vetret);
    if ($idt_atendimento_gera_agenda > 0) {
        $sql = 'select ';
        $sql .= '  grc_aga.*   ';
        $sql .= '  from grc_atendimento_gera_agenda grc_aga ';
        $sql .= '  where grc_aga.idt = ' . null($idt_atendimento_gera_agenda);
        $rs = execsqlNomeCol($sql);
        //p($sql);
        //p($vetret);
        if ($rs->rows == 0) {
            return 2;
        }
        ForEach ($rs->data as $row) {
            //p($row);
            $data_inicial = $row['dt_inicial'];
            $data_geracao = $row['dt_geracao'];
            $data_inicial = $row['dt_inicial'];
            $data_final = $row['dt_final'];

            $data_aleatoria = $row['data_aleatoria'];

            $hora_inicio = $row['hora_inicio'];
            $hora_fim = $row['hora_fim'];
            $idt_consultor = $row['idt_consultor'];
            $idt_ponto_atendimento = $row['idt_ponto_atendimento'];

            if ($vetret['memoria'] == 'S') {
                /*
                  $vetret['idt_consultor']         = $_POST['idt_consultor'];
                  $vetret['idt_ponto_atendimento'] = $_POST['idt_ponto_atendimento'];
                  $vetret['hora_inicio']           = $_POST['hora_inicio'];
                  $vetret['hora_intervalo_inicio'] = $_POST['hora_intervalo_inicio'];
                  $vetret['hora_intervalo_fim']    = $_POST['hora_intervalo_fim'];
                  $vetret['hora_fim']              = $_POST['hora_fim'];
                  $vetret['dt_inicial']            = $_POST['dt_inicial'];
                  $vetret['dt_final']              = $_POST['dt_final'];
                  $vetret['data_aleatoria']        = $_POST['data_aleatoria'];
                  $vetret['idt_servico']           = $_POST['idt_servico'];
                  $vetret['observacao']            = $_POST['observacao'];
                 */
                $idt_consultor = $vetret['idt_consultor'];
                $idt_ponto_atendimento = $vetret['idt_ponto_atendimento'];

                $data_inicial = trata_data($vetret['dt_inicial']);
                $data_final = trata_data($vetret['dt_final']);

                $data_aleatoria = $vetret['data_aleatoria'];

                $hora_inicio = $vetret['hora_inicio'];
                $hora_fim = $vetret['hora_fim'];
            }




            if ($hora_inicio == '') {
                $hora_inicio = '00:00';
            }
            if ($hora_fim == '') {
                $hora_fim = '24:00';
            }
            // Datas aleatórias
            $vetDatas = Array();
            if ($data_aleatoria != "") {
                $deuerro = 1;
                $vetDatas = Array();
                $ret = GeraVetorData($data_inicial, $data_final, $data_aleatoria, $vetDatas);
                if ($ret == 0) {
                    $deuerro = 0;
                }
            }
            $temdatasaleatorias = count($vetDatas);
            if ($temdatasaleatorias > 0) {
                ForEach ($vetDatas as $Indice => $DataI) {
                    $dataInv = trata_data($DataI);
                    $vetDatasD[$dataInv] = 'S';
                }
            }
            $sqla = 'select ';
            //$sqla .= '  grc_ag.*   ';
            $sqla .= '  grc_ag.idt, grc_ag.situacao, grc_ag.origem , grc_ag.data, grc_ag.hora    ';
            $sqla .= '  from grc_atendimento_agenda grc_ag ';
            $sqla .= '  where idt_consultor = ' . null($idt_consultor);
            $sqla .= '   and origem        = ' . aspa('Hora Marcada');
            $sqla .= '   and data >= ' . aspa($data_inicial);
            $sqla .= '   and data <= ' . aspa($data_final);
            $sqla .= '   and hora >= ' . aspa($hora_inicio);
            $sqla .= '   and hora <= ' . aspa($hora_fim);
            $sqla .= '   and idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
            $rsa = execsqlNomeCol($sqla);
            //p($sqla);
            if ($rsa->rows == 0) {
                // Não existe agenda alguma para a solicitação   
                $vetret['existeagenda'] = 'N';
            } else {
                $kokw = 1;
                $vetret['existeagenda'] = 'S';
                ForEach ($rsa->data as $rowa) {

                    $data = $rowa['data'];
                    if ($temdatasaleatorias > 0) {
                        if ($vetDatasD[$data] != "S") {
                            continue;
                        }
                    }
                    $idt_agenda = $rowa['idt'];
                    $situacao = $rowa['situacao'];
                    $origem = $rowa['origem'];
                    if ($situacao == 'Agendado' and $origem == 'Hora Marcada') {
                        $vetLivres[$idt_agenda] = $rowa;
                    } else {
                        $vetMarcados[$idt_agenda] = $rowa;
                    }
                    $vetAgenda[$idt_agenda] = $rowa;
                }
            }
        }
    }
    $vetret['naolivre'] = $vetMarcados;
    $vetret['livres'] = $vetLivres;
    $vetret['agenda'] = $vetAgenda;
    return $kokw;
}

//
// Função para Excluir Agenda
//
function exclusao_agenda($idt_atendimento_gera_agenda, &$vetret) {
    $kokw = 0;
    $datadiaw = trata_data(date('d/m/Y'));
    $vetMarcados = Array();
    if ($idt_atendimento_gera_agenda > 0) {
        $sql = 'select ';
        $sql .= '  grc_aga.*   ';
        $sql .= '  from grc_atendimento_gera_agenda grc_aga ';
        $sql .= '  where grc_aga.idt = ' . null($idt_atendimento_gera_agenda);
        $rs = execsqlNomeCol($sql);
        if ($rs->rows == 0) {
            return 2;
        }
        ForEach ($rs->data as $row) {
            $data_inicial = $row['dt_inicial'];
            $data_geracao = $row['dt_geracao'];



            $data_inicial = $row['dt_inicial'];
            $data_final = $row['dt_final'];

            if ($data_inicial < $datadiaw) {
                $data_inicial = $datadiaw;
            }
            if ($data_final < $datadiaw) {
                return 2;
            }
            // guy


            $data_aleatoria = $row['data_aleatoria'];

            $hora_inicio = $row['hora_inicio'];
            $hora_fim = $row['hora_fim'];
            if ($hora_inicio == '') {
                $hora_inicio = '00:00';
            }
            if ($hora_fim == '') {
                $hora_fim = '24:00';
            }
            // Datas aleatórias
            $vetDatas = Array();
            if ($data_aleatoria != "") {
                $deuerro = 1;
                $vetDatas = Array();
                $ret = GeraVetorData($data_inicial, $data_final, $data_aleatoria, $vetDatas);
                if ($ret == 0) {
                    $deuerro = 0;
                }
            }
            $temdatasaleatorias = count($vetDatas);
            if ($temdatasaleatorias > 0) {
                ForEach ($vetDatas as $Indice => $DataI) {
                    $dataInv = trata_data($DataI);
                    $vetDatasD[$dataInv] = 'S';
                }
            }
            $idt_consultor = $row['idt_consultor'];
            $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
            $sqla = 'select ';
            //$sqla .= '  grc_ag.*   ';
            $sqla .= '  grc_ag.idt, grc_ag.situacao, grc_ag.origem , grc_ag.data, grc_ag.hora    ';
            $sqla .= '  from grc_atendimento_agenda grc_ag ';
            $sqla .= ' where idt_consultor = ' . null($idt_consultor);
            $sqla .= '   and origem        = ' . aspa('Hora Marcada');
            $sqla .= '   and data >= ' . aspa($data_inicial);
            $sqla .= '   and data <= ' . aspa($data_final);
            $sqla .= '   and hora >= ' . aspa($hora_inicio);
            $sqla .= '   and hora <= ' . aspa($hora_fim);
            $sqla .= '   and idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
            $rsa = execsqlNomeCol($sqla);
            if ($rsa->rows == 0) {
                // Nada a Fazer    
            } else {

                ForEach ($rsa->data as $rowa) {

                    $data = $rowa['data'];
                    if ($temdatasaleatorias > 0) {
                        if ($vetDatasD[$data] != "S") {
                            continue;
                        }
                    }
                    $idt_agenda = $rowa['idt'];
                    $situacao = $rowa['situacao'];
                    $origem = $rowa['origem'];
                    if ($situacao == 'Agendado' and $origem == 'Hora Marcada') {
                        $sql = ' delete from ';
                        $sql .= ' grc_atendimento_agenda ';
                        $sql .= ' where idt = ' . null($idt_agenda);
                        $rs = execsql($sql);
                    } else {
                        $vetMarcados[$idt_agenda] = $situacao;
                    }
                }
            }
        }
    }
    $vetret['naoexcluidos'] = $vetMarcados;
    $kokw = 1;
    return $kokw;
}

// fim do programa
//
// Função para Cancelar Agenda
//
function cancela_agenda($idt_atendimento_gera_agenda, $vetret) {
    $kokw = 0;
    $datadiaw = trata_data(date('d/m/Y'));

    if ($idt_atendimento_gera_agenda > 0) {
        $sql = 'select ';
        $sql .= '  grc_aga.*   ';
        $sql .= '  from grc_atendimento_gera_agenda grc_aga ';
        $sql .= '  where grc_aga.idt = ' . null($idt_atendimento_gera_agenda);
        $rs = execsqlNomeCol($sql);
        if ($rs->rows == 0) {
            return 2;
        }
        ForEach ($rs->data as $row) {
            $data_inicial = $row['dt_inicial'];
            $data_geracao = $row['dt_geracao'];

            $data_aleatoria = $row['data_aleatoria'];

            $data_inicial = $row['dt_inicial'];
            $data_final = $row['dt_final'];
            $hora_inicio = $row['hora_inicio'];
            $hora_fim = $row['hora_fim'];
            if ($hora_inicio == '') {
                $hora_inicio = '00:00';
            }
            if ($hora_fim == '') {
                $hora_fim = '24:00';
            }

            if ($data_inicial < $datadiaw) {
                $data_inicial = $datadiaw;
            }
            if ($data_final < $datadiaw) {
                return 2;
            }



            // Datas aleatórias
            $vetDatas = Array();
            if ($data_aleatoria != "") {
                $deuerro = 1;
                $vetDatas = Array();
                $ret = GeraVetorData($data_inicial, $data_final, $data_aleatoria, $vetDatas);
                if ($ret == 0) {
                    $deuerro = 0;
                }
            }
            $temdatasaleatorias = count($vetDatas);
            if ($temdatasaleatorias > 0) {
                ForEach ($vetDatas as $Indice => $DataI) {
                    $dataInv = trata_data($DataI);
                    $vetDatasD[$dataInv] = 'S';
                }
            }
            $idt_consultor = $row['idt_consultor'];
            $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
            $sqla = 'select ';
            //$sqla .= '  grc_ag.*   ';
            $sqla .= '  grc_ag.idt, grc_ag.situacao, grc_ag.origem,grc_ag.data , grc_ag.hora     ';
            $sqla .= '  from grc_atendimento_agenda grc_ag ';
            $sqla .= ' where idt_consultor = ' . null($idt_consultor);
            $sqla .= '   and origem        = ' . aspa('Hora Marcada');
            $sqla .= '   and data >= ' . aspa($data_inicial);
            $sqla .= '   and data <= ' . aspa($data_final);
            $sqla .= '   and idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
            $rsa = execsqlNomeCol($sqla);
            if ($rsa->rows == 0) {
                
            } else {
                ForEach ($rsa->data as $rowa) {
                    $data = $rowa['data'];
                    if ($temdatasaleatorias > 0) {
                        if ($vetDatasD[$data] != "S") {
                            continue;
                        }
                    }

                    $idt_agenda = $rowa['idt'];
                    $situacao = $rowa['situacao'];
                    $origem = $rowa['origem'];
                    $hora = $rowa['hora'];
                    if ($situacao == 'Agendado' and $origem == 'Hora Marcada') {
                        if ($hora >= $hora_inicio and $hora <= $hora_fim) {
                            $sql = ' update ';
                            $sql .= ' grc_atendimento_agenda set ';
                            $sql .= ' situacao  = ' . aspa('Cancelado');
                            $sql .= ' where idt = ' . null($idt_agenda);
                            $rs = execsql($sql);
                        }
                    }
                }
            }
        }
    }
    $kokw = 1;
    return $kokw;
}

//
// Função para Bloquear Agenda
//
function bloqueio_agenda($idt_atendimento_gera_agenda, $vetret) {

    $kokw = 0;
    $datadiaw = trata_data(date('d/m/Y'));

    if ($idt_atendimento_gera_agenda > 0) {
        $sql = 'select ';
        $sql .= '  grc_aga.*   ';
        $sql .= '  from grc_atendimento_gera_agenda grc_aga ';
        $sql .= '  where grc_aga.idt = ' . null($idt_atendimento_gera_agenda);
        $rs = execsql($sql);
        if ($rs->rows == 0) {
            return 2;
        }
        ForEach ($rs->data as $row) {
            $data_inicial = $row['dt_inicial'];
            $data_geracao = $row['dt_geracao'];

            $data_aleatoria = $row['data_aleatoria'];

            $data_inicial = $row['dt_inicial'];
            $data_final = $row['dt_final'];


            $hora_inicio = $row['hora_inicio'];
            $hora_fim = $row['hora_fim'];
            if ($hora_inicio == '') {
                $hora_inicio = '00:00';
            }
            if ($hora_fim == '') {
                $hora_fim = '24:00';
            }
            if ($data_inicial < $datadiaw) {
                $data_inicial = $datadiaw;
            }
            if ($data_final < $datadiaw) {
                return 2;
            }

            // Datas aleatórias
            $vetDatas = Array();
            if ($data_aleatoria != "") {
                $deuerro = 1;
                $vetDatas = Array();
                $ret = GeraVetorData($data_inicial, $data_final, $data_aleatoria, $vetDatas);
                if ($ret == 0) {
                    $deuerro = 0;
                }
            }
            $temdatasaleatorias = count($vetDatas);
            if ($temdatasaleatorias > 0) {
                ForEach ($vetDatas as $Indice => $DataI) {
                    $dataInv = trata_data($DataI);
                    $vetDatasD[$dataInv] = 'S';
                }
            }
            //p($vetDatasD);
            //die();
            //
            $idt_consultor = $row['idt_consultor'];
            $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
            $sqla = 'select ';
            //$sqla .= '  grc_ag.*   ';
            $sqla .= '  grc_ag.idt, grc_ag.situacao, grc_ag.origem, grc_ag.data , grc_ag.hora    ';
            $sqla .= '  from grc_atendimento_agenda grc_ag ';
            $sqla .= ' where idt_consultor = ' . null($idt_consultor);
            $sqla .= '   and origem        = ' . aspa('Hora Marcada');
            $sqla .= '   and data >= ' . aspa($data_inicial);
            $sqla .= '   and data <= ' . aspa($data_final);
            $sqla .= '   and idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
            $rsa = execsqlNomeCol($sqla);
            if ($rsa->rows == 0) {
                
            } else {
                ForEach ($rsa->data as $rowa) {
                    $data = $rowa['data'];
                    //echo " Data = $data <br />";
                    //$ff = $vetDatasD[$data];
                    //echo " Dataff = $ff <br />";
                    if ($temdatasaleatorias > 0) {
                        if ($vetDatasD[$data] != "S") {
                            // $ff = $vetDatasD[$data];
                            // echo " Dataff = $ff <br />";
                            // só faz as datas solicitadas
                            continue;
                        }
                    }
                    $idt_agenda = $rowa['idt'];
                    $situacao = $rowa['situacao'];
                    $origem = $rowa['origem'];
                    $hora = $rowa['hora'];
                    //echo " $hora>=$hora_inicio and $hora<=$hora_fim <br />";
                    if ($situacao == 'Agendado' and $origem == 'Hora Marcada') {
                        if ($hora >= $hora_inicio and $hora <= $hora_fim) {
                            $sql = ' update ';
                            $sql .= ' grc_atendimento_agenda set ';
                            $sql .= ' situacao  = ' . aspa('Bloqueado');
                            $sql .= ' where idt = ' . null($idt_agenda);
                            $rs = execsql($sql);
                        }
                    }
                }
            }
        }
    }
    $kokw = 1;
    // die();
    return $kokw;
}

//
// Função para Voltar de Cancelada ou Bloqueaada
//
function VoltaAgenda($idt_atendimento_gera_agenda, $vetret) {

    $kokw = 0;
    $datadiaw = trata_data(date('d/m/Y'));

    if ($idt_atendimento_gera_agenda > 0) {
        $sql = 'select ';
        $sql .= '  grc_aga.*   ';
        $sql .= '  from grc_atendimento_gera_agenda grc_aga ';
        $sql .= '  where grc_aga.idt = ' . null($idt_atendimento_gera_agenda);
        $rs = execsql($sql);
        if ($rs->rows == 0) {
            return 2;
        }
        ForEach ($rs->data as $row) {
            $data_inicial = $row['dt_inicial'];
            $data_geracao = $row['dt_geracao'];

            $data_aleatoria = $row['data_aleatoria'];

            $data_inicial = $row['dt_inicial'];
            $data_final = $row['dt_final'];
            $hora_inicio = $row['hora_inicio'];
            $hora_fim = $row['hora_fim'];

            if ($hora_inicio == '') {
                $hora_inicio = '00:00';
            }
            if ($hora_fim == '') {
                $hora_fim = '24:00';
            }
            if ($data_inicial < $datadiaw) {
                $data_inicial = $datadiaw;
            }
            if ($data_final < $datadiaw) {
                return 2;
            }
            // Datas aleatórias
            $vetDatas = Array();
            if ($data_aleatoria != "") {
                $deuerro = 1;
                $vetDatas = Array();
                $ret = GeraVetorData($data_inicial, $data_final, $data_aleatoria, $vetDatas);
                if ($ret == 0) {
                    $deuerro = 0;
                }
            }
            $temdatasaleatorias = count($vetDatas);
            if ($temdatasaleatorias > 0) {
                ForEach ($vetDatas as $Indice => $DataI) {
                    $dataInv = trata_data($DataI);
                    $vetDatasD[$dataInv] = 'S';
                }
            }



            $idt_consultor = $row['idt_consultor'];
            $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
            $sqla = 'select ';
            //$sqla .= '  grc_ag.*   ';
            $sqla .= '  grc_ag.idt, grc_ag.situacao, grc_ag.origem , grc_ag.data , grc_ag.hora    ';
            $sqla .= '  from grc_atendimento_agenda grc_ag ';
            $sqla .= ' where idt_consultor = ' . null($idt_consultor);
            $sqla .= '   and origem        = ' . aspa('Hora Marcada');
            $sqla .= '   and data >= ' . aspa($data_inicial);
            $sqla .= '   and data <= ' . aspa($data_final);
            $sqla .= '   and idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
            $rsa = execsql($sqla);
            if ($rsa->rows == 0) {
                
            } else {
                ForEach ($rsa->data as $rowa) {
                    $data = $rowa['data'];
                    if ($temdatasaleatorias > 0) {
                        if ($vetDatasD[$data] != "S") {
                            // $ff = $vetDatasD[$data];
                            // echo " Dataff = $ff <br />";
                            // só faz as datas solicitadas
                            continue;
                        }
                    }

                    $idt_agenda = $rowa['idt'];
                    $situacao = $rowa['situacao'];
                    $origem = $rowa['origem'];
                    $hora = $rowa['hora'];
                    if (($situacao == 'Bloqueado' or $situacao == 'Cancelada') and ( $origem == 'Hora Marcada')) {
                        if ($hora >= $hora_inicio and $hora <= $hora_fim) {
                            $sql = ' update ';
                            $sql .= ' grc_atendimento_agenda set ';
                            $sql .= ' situacao  = ' . aspa('Agendado');
                            $sql .= ' where idt = ' . null($idt_agenda);
                            $rs = execsql($sql);
                        }
                    }
                }
            }
        }
    }
    $kokw = 1;
    return $kokw;
}

//
// Função para Gerar Painel
//
function geracao_painel($idt_atendimento_gera_painel, &$vetret) {

    $kokw = 0;
    $sql = 'select ';
    $sql .= '  grc_agp.*   ';
    $sql .= '  from grc_atendimento_gera_painel grc_agp ';
    $sql .= '  where grc_agp.idt = ' . null($idt_atendimento_gera_painel);
    $rs = execsql($sql);

    if ($rs->rows == 0) {

//      p('aqui');


        return 2;
    }
    $arquivo = '';
    ForEach ($rs->data as $row) {


        $data_geracao = $row['dt_geracao'];
        $data_base = $row['dt_base'];
        $idt_usuario = $row['idt_usuario'];
        $observacao = $row['observacao'];

//      p('data base -   '.$data_base);


        $sql1 = 'select ';
        $sql1 .= '  grc_aa.*   ';
        $sql1 .= '  from grc_atendimento_agenda grc_aa ';
        $sql1 .= '  where grc_aa.data     = ' . aspa($data_base);
        $sql1 .= '    and grc_aa.situacao = ' . aspa('Marcado');
        $sql1 .= '  order by grc_aa.hora, grc_aa.idt_consultor ';

        $rs_aa = execsql($sql1);


//      p('sql  -   '.$sql1);



        if ($rs_aa->rows == 0) {

//      p('aqui_1');


            return 2;
        }
        $arquivo = '';


        ForEach ($rs_aa->data as $row_aa) {
            $idt_consultor_agenda = null($row_aa['idt_consultor']);
            $idt_cliente_agenda = null($row_aa['idt_cliente']);
            $idt_especialidade_agenda = null($row_aa['idt_especialidade']);
            $data_agenda = aspa($row_aa['data']);
            $hora_agenda = aspa($row_aa['hora']);
            $origem_agenda = aspa($row_aa['origem']);
            $detalhe_agenda = aspa($row_aa['detalhe']);
            $situacao_agenda = aspa($row_aa['situacao']);
            $data_confirmacao_agenda = aspa($row_aa['data_confirmacao']);
            $hora_confirmacao_agenda = aspa($row_aa['hora_confirmacao']);
            $telefone_agenda = aspa($row_aa['telefone']);
            $hora_chegada_agenda = aspa($row_aa['hora_chegada']);
            $hora_atendimento_agenda = aspa($row_aa['hora_atendimento']);
            $idt_ponto_atendimento_agenda = null($row_aa['idt_ponto_atendimento']);
            $dia_semana_agenda = aspa($row_aa['dia_semana']);
            $hora_liberacao_agenda = aspa($row_aa['hora_liberacao']);
            $celular_agenda = aspa($row_aa['celular']);
            $observacao_chegada_agenda = aspa($row_aa['observacao_chegada']);
            $observacao_atendimento_agenda = aspa($row_aa['observacao_atendimento']);
            $cliente_texto_agenda = aspa($row_aa['cliente_texto']);

            $idt_atendimento_agenda = $row_aa['idt'];
            $idt_atendimento_box = 'null';
            $idt_atendimento_painel = idtAtendimentoPainel();
            $status_painel_agenda = aspa('00');

            $protocolo = aspa('');

            $datadiaw = (date('d/m/Y H:i:s'));
            $datadia = aspa(trata_data($datadiaw));

            $kokw = 0;
            $sql2 = 'select ';
            $sql2 .= '  grc_aap.*   ';
            $sql2 .= '  from grc_atendimento_agenda_painel grc_aap ';
            $sql2 .= '  where grc_aap.idt_consultor = ' . null($idt_consultor_agenda);
            $sql2 .= '  and grc_aap.data = ' . $data_agenda;
            $sql2 .= '  and grc_aap.hora = ' . $hora_agenda;

            $rs_aap = execsql($sql2);

            if ($rs_aap->rows == 0) {
                // grava registro

                $sql_i = ' insert into grc_atendimento_agenda_painel ';
                $sql_i .= ' (  ';
                $sql_i .= ' idt_consultor, ';
                $sql_i .= ' idt_cliente, ';
                $sql_i .= ' idt_especialidade, ';
                $sql_i .= ' idt_atendimento_agenda, ';
                $sql_i .= ' idt_atendimento_box, ';
                $sql_i .= ' idt_atendimento_painel, ';
                $sql_i .= ' data, ';
                $sql_i .= ' hora, ';
                $sql_i .= ' origem, ';
                $sql_i .= ' detalhe, ';
                $sql_i .= ' situacao, ';
                $sql_i .= ' data_confirmacao, ';
                $sql_i .= ' hora_confirmacao, ';
                $sql_i .= ' telefone, ';
                $sql_i .= ' hora_chegada, ';
                $sql_i .= ' hora_atendimento, ';
                $sql_i .= ' idt_ponto_atendimento, ';
                $sql_i .= ' dia_semana, ';
                $sql_i .= ' hora_liberacao, ';
                $sql_i .= ' celular, ';
                $sql_i .= ' observacao_chegada, ';
                $sql_i .= ' observacao_atendimento, ';
                $sql_i .= ' cliente_texto, ';
                $sql_i .= ' status_painel, ';
                $sql_i .= ' protocolo,  ';
                $sql_i .= ' data_hora_geracao ';
                $sql_i .= '  ) values ( ';
                $sql_i .= " $idt_consultor_agenda, ";
                $sql_i .= " $idt_cliente_agenda, ";
                $sql_i .= " $idt_especialidade_agenda, ";
                $sql_i .= " $idt_atendimento_agenda, ";
                $sql_i .= " $idt_atendimento_box, ";
                $sql_i .= " $idt_atendimento_painel, ";
                $sql_i .= " $data_agenda, ";
                $sql_i .= " $hora_agenda, ";
                $sql_i .= " $origem_agenda, ";
                $sql_i .= " $detalhe_agenda, ";
                $sql_i .= " $situacao_agenda, ";
                $sql_i .= " $data_confirmacao_agenda, ";
                $sql_i .= " $hora_confirmacao_agenda, ";
                $sql_i .= " $telefone_agenda, ";
                $sql_i .= " $hora_chegada_agenda, ";
                $sql_i .= " $hora_atendimento_agenda, ";
                $sql_i .= " $idt_ponto_atendimento_agenda, ";
                $sql_i .= " $dia_semana_agenda, ";
                $sql_i .= " $hora_liberacao_agenda, ";
                $sql_i .= " $celular_agenda, ";
                $sql_i .= " $observacao_chegada_agenda, ";
                $sql_i .= " $observacao_atendimento_agenda, ";
                $sql_i .= " $cliente_texto_agenda, ";
                $sql_i .= " $status_painel_agenda, ";
                $sql_i .= " $protocolo, ";
                $sql_i .= " $datadia ";
                $sql_i .= ') ';
                $result = execsql($sql_i);
            }
        }
    }
    $kokw = 1;
    return $kokw;
}

//
// Função para Excluir Painel
//
function exclusao_painel($idt_atendimento_gera_painel, $vetret) {

    if ($idt_atendimento_gera_painel > 0) {
        $kokw = 0;
        $sql = ' delete ';
        $sql .= ' grc_atendimento_agenda_painel ';
        $sql .= ' where idt_atendimento_gera_painel = ' . null($idt_atendimento_gera_painel);
        $rs = execsql($sql);
    }
    $kokw = 1;
    return $kokw;
}

// fim do programa
//
// Função para Gerar Agenda
//
function BuscaPessoa($idt_ponto_atendimento, &$vetret) {
    $kokw = 0;
    $vetret['existe_pessoa'] = "";
    $nome = $vetret['nome'];
    $cpf = $vetret['cpf'];
    $telefone = $vetret['telefone'];
    $celular = $vetret['celular'];
    $email = $vetret['email'];
    $protocolo_marcacao = $vetret['protocolo_marcacao'];
    $cnpj = $vetret['cnpj'];
    $nome_empresa = $vetret['nome_empresa'];
    $idt_cliente = $vetret['idt_cliente'];
    $data_nascimento = $vetret['data_nascimento'];
    //
    if ($idt_ponto_atendimento <= 0) {
        return 0;
    }
    if ($protocolo_marcacao != 0) {   // Pegar dados pelo protocolo
    }
    if ($cpf != "") {   // Pegar dados pelo CPF
        BuscaPessoaCPF($cpf, $vetret);
    } else {
        if ($idt_cliente > 0) {   // Pegar dados pelo idt
            BuscaPessoaCPF($cpf, $vetret);
        }
    }

    if ($nome != "") {   // Pegar dados pelo Nome
    }



    $kokw = 1;
    return $kokw;
}

function BuscaPessoaCPF($cpf, &$vetret) {
    $kokw = 0;
    //
    $idt_cliente = $vetret['idt_cliente'];

    $sql = 'select gec_en.*, gec_enp.data_nascimento as gec_enp_data_nascimento  ';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade gec_en ';
    $sql .= ' left join ' . db_pir_gec . 'gec_entidade_pessoa gec_enp on gec_enp.idt_entidade = gec_en.idt ';
    if ($idt_cliente > 0) {
        $sql .= " where gec_en.idt = " . null($idt_cliente);
    } else {
        if ($cpf != "") {
            $sql .= " where gec_en.tipo_entidade = 'P'";
            $sql .= "   and gec_en.codigo        = " . aspa($cpf);
            $sql .= "   and gec_en.reg_situacao  = " . aspa("A");
        } else {
            return 2;
        }
    }

    // p($sql);

    $rs = execsql($sql);
    $qtd_pessoa = $rs->rows;
    if ($rs->rows == 0) {
        $vetret['existe_pessoa'] = "N";
        $vetret['qtd_pessoa'] = $qtd_pessoa;
        $vetret['cpf'] = $cpf;
        $vetret['idt_cliente'] = $idt_cliente;
        return 2;
    }
    ForEach ($rs->data as $row) {
        $idt_entidade = $row['idt'];
        $vetret['existe_pessoa'] = "S";
        $vetret['qtd_pessoa'] = $qtd_pessoa;
        $vetret['idt_entidade'] = $idt_entidade;
        $vetret['cpf'] = $row['codigo'];
        $vetret['idt_cliente'] = $row['idt'];
        $vetret['data_nascimento'] = trata_data($row['gec_enp_data_nascimento']);


        // if  ($vetret['nome']=="")
        // {
        $vetret['nome'] = $row['descricao'];
        // }
        //$vetret['cpf']                = $cpf;
        // buscar comunicação principal da pessoa
        $vetrowend = Array();
        $vetrowemp = Array();
        $vetrowpro = Array();
        $retend = BuscaEnderecos($idt_entidade, $vetrowend);
        $retemp = BuscaEmpresas($idt_entidade, $vetrowemp);
        $retemp = BuscaProtocoloMarcacao($idt_entidade, $vetrowpro);
        // Endereços - associadas
        $vetret['enderecos'] = $vetrowend;
        // p($vetrowend);
        ForEach ($vetrowend as $idx => $Vettrab) {
            $vetendereco = $Vettrab['endereco'];
            $vetrow = $vetendereco['row'];
            //   p($vetrow);
            //   $sql = '  gec_eneet.codigo    as gec_eneet_codigo, ';
            //   $sql = '  gec_eneet.descricao as gec_eneet_descricao ';
            //
            // 00 é o principal e 99 o de atendimento
            //
            //$vetrow['idt_entidade_endereco_tipo'];
            // if ($vetrow['gec_eneet_codigo'] != "00" && $vetrow['gec_eneet_codigo'] != "99") {
            if ($vetrow['gec_eneet_codigo'] != "99") {
                continue;
            }
            $logradouro = $vetrow['logradouro'];
            $logradouro_numero = $vetrow['logradouro_numero'];
            $logradouro_complemento = $vetrow['logradouro_complemento'];
            $logradouro_bairro = $vetrow['logradouro_bairro'];
            $logradouro_municipio = $vetrow['logradouro_municipio'];
            $logradouro_estado = $vetrow['logradouro_estado'];
            $logradouro_pais = $vetrow['logradouro_pais'];
            $logradouro_cep = $vetrow['logradouro_cep'];
            $cep = $vetrow['cep'];
            $vetcomunicacaow = $vetendereco['comunicacao'];
            if (is_array($vetcomunicacaow)) {
                ForEach ($vetcomunicacaow as $idxw => $VetCom) {
                    //p($VetCom);
                    if ($VetCom['comunicacao']['telefone_1'] != '') {
                        $telefone_1 = $VetCom['comunicacao']['telefone_1'];
                    }
                    if ($VetCom['comunicacao']['telefone_2'] != '') {
                        $telefone_2 = $VetCom['comunicacao']['telefone_2'];
                    }
                    if ($VetCom['comunicacao']['email_1'] != '') {
                        $email_1 = $VetCom['comunicacao']['email_1'];
                    }
                    $email_2 = $VetCom['comunicacao']['email_2'];

                    $sms_1 = $VetCom['comunicacao']['sms_1'];
                    $sms_2 = $VetCom['comunicacao']['sms_2'];
                }
            }
        }

        if ($vetret['telefone'] == "") {
            $vetret['telefone'] = $telefone_1;
        }
        if ($vetret['celular'] == "") {
            $vetret['celular'] = $telefone_2;
        }
        if ($vetret['sms_1'] == "") {
            $vetret['sms_1'] = $sms_1;
        }
        if ($vetret['email'] == "") {
            $vetret['email'] = $email_1;
        }

        //p($vetret);
        // Protocolos  - associados
        $vetret['protocolos'] = $vetrowpro;
        // empresas - associadas
        $vetret['empresas'] = $vetrowemp;
        $pe = $vetrowemp['PE'];
        $ep = $vetrowemp['EP'];
        //p($pe);
        ForEach ($pe as $idxw => $VetEmp) {
            //p($VetEmp);
            if ($VetEmp['qtdempresas'] > 0) {
                $Vet = $VetEmp['empresas'];
                $cnpj = $Vet['codigo'];
                $nome_empresa = $Vet['descricao'];
            }
        }
        ForEach ($ep as $idxw => $VetEmp) {
            // p($VetEmp);
            if ($VetEmp['qtdempresas'] > 0) {
                $Vet = $VetEmp['empresas'];
                $cnpj = $Vet['codigo'];
                $nome_empresa = $Vet['descricao'];
            }
        }
        if ($vetret['cnpj'] == "") {
            $vetret['cnpj'] = $cnpj;
        }
        if ($vetret['nome_empresa'] == "") {
            $vetret['nome_empresa'] = $nome_empresa;
        }
    }
    $kokw = 1;
    return $kokw;
}

function BuscaEnderecos($idt_entidade, &$vetrowend) {
    $kokw = 0;
    $sql = 'select gec_enee.*, ';
    $sql .= '  gec_eneet.codigo    as gec_eneet_codigo, ';
    $sql .= '  gec_eneet.descricao as gec_eneet_descricao ';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade_endereco gec_enee ';
    $sql .= ' inner join ' . db_pir_gec . 'gec_endereco_tipo gec_eneet on gec_eneet.idt = gec_enee.idt_entidade_endereco_tipo';
    $sql .= " where gec_enee.idt_entidade = " . null($idt_entidade);
    $rs = execsql($sql);
    $qtd_enderecos = $rs->rows;
    $num = 0;

    if ($rs->rows == 0) {
        $vetrowend[$num]['existe_pessoa_endereco'] = "N";
        $vetrowend[$num]['qtd_enderecos'] = $qtd_enderecos;
        $vetrowend[$num]['idt_entidade'] = $idt_entidade;
        return 2;
    }
    $arquivo = '';
    $vetrowend[$num]['existe_pessoa_endereco'] = "S";
    $vetrowend[$num]['qtd_enderecos'] = $qtd_enderecos;
    $vetrowend[$num]['idt_entidade'] = $idt_entidade;
    ForEach ($rs->data as $row) {
        $num = $num + 1;
        $idt_entidade_endereco = $row['idt'];

        if ($row['logradouro_codpais'] == '') {
            $sql = '';
            $sql .= ' select codpais';
            $sql .= ' from ' . db_pir_siac . 'pais';
            $sql .= ' where descpais = ' . aspa($row['logradouro_pais']);
            $rst = execsql($sql);
            $row['logradouro_codpais'] = $rst->data[0][0];
        }

        if ($row['logradouro_codest'] == '') {
            $sql = '';
            $sql .= ' select codest';
            $sql .= ' from ' . db_pir_siac . 'estado';
            $sql .= ' where abrevest = ' . aspa($row['logradouro_estado']);
            $sql .= ' and codpais = ' . null($row['logradouro_codpais']);
            $rst = execsql($sql);
            $row['logradouro_codest'] = $rst->data[0][0];
        }

        if ($row['logradouro_codcid'] == '') {
            $sql = '';
            $sql .= ' select codcid';
            $sql .= ' from ' . db_pir_siac . 'cidade';
            $sql .= ' where desccid = ' . aspa($row['logradouro_municipio']);
            $sql .= ' and codest = ' . null($row['logradouro_codest']);
            $rst = execsql($sql);
            $row['logradouro_codcid'] = $rst->data[0][0];
        }

        if ($row['logradouro_codbairro'] == '') {
            $sql = '';
            $sql .= ' select codbairro';
            $sql .= ' from ' . db_pir_siac . 'bairro';
            $sql .= ' where descbairro = ' . aspa($row['logradouro_bairro']);
            $sql .= ' and codcid = ' . null($row['logradouro_codcid']);
            $rst = execsql($sql);
            $row['logradouro_codbairro'] = $rst->data[0][0];
        }

        $vetrowend[$num]['idt_entidade_endereco'] = $idt_entidade_endereco;
        $vetrowend[$num]['endereco']['row'] = $row;
        $vetrowendCom = Array();
        $retend = BuscaEnderecoComunicacao($idt_entidade_endereco, $vetrowendCom);
        $vetrowend[$num]['endereco']['comunicacao'] = $vetrowendCom;
    }
    $kokw = 1;
    return $kokw;
}

function BuscaEnderecoComunicacao($idt_entidade_endereco, &$vetrowendCom) {
    $kokw = 0;
    $sql = 'select gec_enec.* ';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade_comunicacao gec_enec ';
    $sql .= " where gec_enec.idt_endereco = " . null($idt_entidade_endereco);
    $rs = execsql($sql);
    $qtd_comunicacoes = $rs->rows;
    $num = 0;
    if ($rs->rows == 0) {
        $vetrowendCom[$num]['existe_pessoa_endereco_comunicacao'] = "N";
        $vetrowendCom[$num]['qtd_comunicacoes'] = $qtd_comunicacoes;
        $vetrowendCom[$num]['idt_entidade_endereco'] = $idt_entidade_endereco;
        return 2;
    }
    $arquivo = '';
    ForEach ($rs->data as $row) {
        $num = $num + 1;
        $idt_entidade_endereco_comunicacao = $row['idt'];
        $vetrowendCom[$num]['existe_pessoa_endereco_comunicacao'] = "S";
        $vetrowendCom[$num]['qtd_comunicacoes'] = $qtd_comunicacoes;
        $vetrowendCom[$num]['idt_entidade_endereco'] = $idt_entidade_endereco;
        $vetrowendCom[$num]['idt_entidade_endereco_comunicacao'] = $idt_entidade_endereco_comunicacao;
        $vetrowendCom[$num]['comunicacao'] = $row;
    }
    $kokw = 1;
    return $kokw;
}

function BuscaEmpresas($idt_entidade, &$vetrowemp) {
    $kokw = 0;
    //
    // Pessoa associada a entidades    PE
    //
    
    $sql = 'select gec_en.*, ';
    $sql .= '       gec_eno.*, ';
    $sql .= ' gec_en.idt as idt_entidade_cadastro,  ';
    $sql .= ' gec_en.funil_idt_cliente_classificacao,  ';
    $sql .= ' gec_en.funil_cliente_nota_avaliacao,  ';
    $sql .= ' gec_en.funil_cliente_data_avaliacao,  ';
    $sql .= ' gec_en.funil_cliente_obs_avaliacao,  ';
    $sql .= ' gec_enen.representa_codcargcli,  ';
    $sql .= ' gec_enen.data_inicio as ee_data_inicio,  ';
    $sql .= ' gec_enen.data_termino as ee_data_termino,  ';
    $sql .= ' gec_enr.codigo as gec_enr_codigo,  ';
    $sql .= ' gec_enr.descricao as gec_enr_descricao  ';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade_entidade gec_enen ';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade gec_en on gec_en.idt = gec_enen.idt_entidade_relacionada';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_relacao gec_enr on gec_enr.idt = gec_enen.idt_entidade_relacao';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_organizacao gec_eno on gec_eno.idt_entidade = gec_en.idt';
    $sql .= " where gec_enen.idt_entidade = " . null($idt_entidade);
    $sql .= "   and gec_en.tipo_entidade = " . aspa('O');
    $sql .= "   and gec_en.reg_situacao  = " . aspa('A');
    $sql .= "   and gec_enen.ativo = 'S'";
    $sql .= ' and gec_enen.idt_entidade_relacao <> 8';
    $rs = execsql($sql);
    $qtdempresas = $rs->rows;
    $num = 0;
    if ($rs->rows == 0) {
        $vetrowemp['PE']['existe_entidade'] = "N";
        $vetrowemp['PE']['idt_entidade'] = $idt_entidade;
        $vetrowemp['PE']['qtdempresas'] = $qtdempresas;
    }
    $qtdempresas = $rs->rows;

    ForEach ($rs->data as $row) {
        $num = $num + 1;
        $idt_entidade_entidade = $row['idt'];
        $vetrowemp['PE'][$num]['existe_entidade'] = "S";
        $vetrowemp['PE'][$num]['idt_entidade'] = $idt_entidade;
        $vetrowemp['PE'][$num]['idt_entidade_entidade'] = $idt_entidade_entidade;
        $vetrowemp['PE'][$num]['qtdempresas'] = $qtdempresas;

        $funil_idt_cliente_classificacao = $row['funil_idt_cliente_classificacao'];
        $funil_cliente_nota_avaliacao = $row['funil_cliente_nota_avaliacao'];

        $vetrowemp['PE'][$num]['funil_idt_cliente_classificacao'] = $funil_idt_cliente_classificacao;

        $vetrowemp['PE'][$num]['empresas'] = $row;

        $sql = '';
        $sql .= ' select idt_tipo_informacao';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade_x_tipo_informacao';
        $sql .= ' where idt = ' . null($row['idt_entidade_cadastro']);
        $rstt = execsql($sql);
        $vetrowemp['PE'][$num]['gec_entidade_x_tipo_informacao'] = $rstt->data;
    }
    // da empresa para a pessoa EP
    $sql = 'select gec_en.*, ';
    $sql .= '       gec_eno.*, ';
    $sql .= ' gec_en.idt as idt_entidade_cadastro,  ';
    $sql .= ' gec_en.funil_idt_cliente_classificacao,  ';
    $sql .= ' gec_en.funil_cliente_nota_avaliacao,  ';
    $sql .= ' gec_en.funil_cliente_data_avaliacao,  ';
    $sql .= ' gec_en.funil_cliente_obs_avaliacao,  ';
    $sql .= ' gec_enen.representa_codcargcli,  ';
    $sql .= ' gec_enen.data_inicio as ee_data_inicio,  ';
    $sql .= ' gec_enen.data_termino as ee_data_termino,  ';
    $sql .= ' gec_enr.codigo as gec_enr_codigo,  ';
    $sql .= ' gec_enr.descricao as gec_enr_descricao  ';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade_entidade gec_enen ';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade gec_en on gec_en.idt = gec_enen.idt_entidade';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_relacao gec_enr on gec_enr.idt = gec_enen.idt_entidade_relacao';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_organizacao gec_eno on gec_eno.idt_entidade = gec_en.idt';
    $sql .= " where gec_enen.idt_entidade_relacionada = " . null($idt_entidade);
    $sql .= "   and gec_en.tipo_entidade = " . aspa('O');
    $sql .= "   and gec_en.reg_situacao  = " . aspa('A');
    $sql .= "   and gec_enen.ativo = 'S'";
    $sql .= ' and gec_enen.idt_entidade_relacao <> 8';
    $rs = execsql($sql);
    $qtdempresas = $rs->rows;
    if ($rs->rows == 0) {
        $vetrowemp['EP'][$num]['existe_entidade'] = "N";
        $vetrowemp['EP'][$num]['idt_entidade'] = $idt_entidade;
        $vetrowemp['EP'][$num]['qtdempresas'] = $qtdempresas;
    }
    ForEach ($rs->data as $row) {
        $num = $num + 1;
        $idt_entidade_entidade = $row['idt'];
        $vetrowemp['EP'][$num]['existe_entidade'] = "S";
        $vetrowemp['EP'][$num]['idt_entidade'] = $idt_entidade;
        $vetrowemp['EP'][$num]['idt_entidade_entidade'] = $idt_entidade_entidade;
        $vetrowemp['EP'][$num]['qtdempresas'] = $qtdempresas;
        $vetrowemp['EP'][$num]['empresas'] = $row;

        $sql = '';
        $sql .= ' select idt_tipo_informacao';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade_x_tipo_informacao';
        $sql .= ' where idt = ' . null($row['idt_entidade_cadastro']);
        $rstt = execsql($sql);
        $vetrowemp['PE'][$num]['gec_entidade_x_tipo_informacao'] = $rstt->data;
    }
    //p($vetrowemp);
    $row = $vetrowemp['EP'][$num]['empresas'];







    $kokw = 1;
    return $kokw;
}

function BuscaProtocoloMarcacao($idt_entidade, &$vetrowpro) {
    $kokw = 0;

    $vetrowpro['protocolo'] = '999999';


    $kokw = 1;
    return $kokw;
}

function IniciaAtendimento($idt_atendimento_agenda, $idt_cliente, &$variavel) {
    if (($_SESSION[CS]['g_idt_projeto'] == '' || $_SESSION[CS]['g_idt_acao'] == '') && $variavel['idt_evento'] == '' && nan != 'S') {
        die('O Projeto e Ação devem estar informado no usuário para poder fazer um atendimento!');
    }

    if ($variavel['origem'] == '' || strlen($variavel['origem']) > 1) {
        $variavel['origem'] = 'P';
    }

    $kokw = 0;
    // le agenda
    //grava primeiro atendimento
    $sql1 = 'select ';
    $sql1 .= '  grc_aa.*   ';
    $sql1 .= '  from ' . db_pir_grc . 'grc_atendimento_agenda grc_aa ';
    $sql1 .= ' where    grc_aa.idt    = ' . null($idt_atendimento_agenda);
//  $sql1 .= '      and grc_aa.situacao = '.aspa('Liberado');
    $rs_aa = execsql($sql1);
    if ($rs_aa->rows == 0) {
        return 2;
    }
    $arquivo = '';
    ForEach ($rs_aa->data as $row_aa) {
        $datadiaw = (date('d/m/Y H:i:s'));
        $datadia = trata_data($datadiaw);

        $data = $datadia;
        $vet = explode(' ', $datadiaw);

        $datay = aspa(trata_data(date('d/m/Y')));

        $hora_inicial = substr($vet[1], 0, 5);
        $hora_final = $hora_inicial;

        $hora_inicio_atendimento = aspa($hora_inicial);
        $hora_termino_atendimento = aspa($hora_final);
        $horas_atendimento = 0;

        $horas_atendimentow = '';

        $tabela = 'grc_atendimento';
        $Campo = 'protocolo';

        $idt_consultor = null($row_aa['idt_consultor']);
        $idt_pessoa = null($row_aa['idt_cliente']);
        $idt_cliente = null($row_aa['idt_empreendimento']);



        $assunto = aspa($row_aa['assunto']);
        $data_inicio_atendimento = aspa($data);
        $data_termino_atendimento = aspa($data);
        $horas_atendimento = null($horas_atendimentow);
        $cpf = aspa($row_aa['cpf']);
        $cnpj = aspa($row_aa['cnpj']);

        $cpf_w = ($row_aa['cpf']);
        $cnpj_w = ($row_aa['cnpj']);



        $nome_pessoa = aspa($row_aa['cliente_texto']);
        // $idt_pessoa                    = null($row_aa['idt_pessoa']);
        $nome_empresa = aspa($row_aa['nome_empresr']);
        // $idt_empresa                   = null($row_aa['idt_empresa']);

        $idt_atendimento_agenda = null($idt_atendimento_agenda);
        $idt_projeto = 'null';
        $idt_projeto_acao = 'null';

        if ($row_aa['idt_instrumento'] == '') {
            $idt_instrumento = null($variavel['instrumento']);
        } else {
            $idt_instrumento = null($row_aa['idt_instrumento']);
        }

        $primeiro = aspa('Sim');
        $situacao = aspa('Esperando Atendimento');


        //  $idt_consultor                 = $_SESSION[CS]['g_id_usuario'];
        $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
        $idt_projeto = null($_SESSION[CS]['g_idt_projeto']);
        $idt_projeto_acao = null($_SESSION[CS]['g_idt_acao']);
        $gestor_sge = aspa($_SESSION[CS]['g_projeto_gestor']);
        $fase_acao_projeto = aspa($_SESSION[CS]['g_projeto_etapa']);


        $idt_competencia = idtCompetencia(date('d/m/Y'));


        $senha_totem = aspa($variavel['senha_totemw']);
        $senha_ordem = aspa($variavel['senha_ordemw']);

        $nan_campo = '';
        $nan_valor = '';
        $where_protocolo = '';
        $idt_consultor_prox_atend = 'null';

        if (nan == 'S') {
            $sql = '';
            $sql .= ' select e.idt_ponto_atendimento as idt_unidade, et.idt_usuario as idt_nan_tutor, e.idt_acao, a.idt_projeto,';
            $sql .= ' ef.ativo, ef.credenciado_nan, ef.nan_ano';
            $sql .= ' from grc_nan_estrutura e';
            $sql .= ' inner join grc_projeto_acao a on a.idt = e.idt_acao';
            $sql .= ' inner join grc_nan_estrutura et on et.idt = e.idt_tutor';
            $sql .= ' inner join plu_usuario uf on uf.id_usuario = e.idt_usuario';
            $sql .= ' inner join ' . db_pir_gec . 'gec_entidade ef on ef.codigo = uf.login';
            $sql .= ' where e.idt_usuario = ' . null($_SESSION[CS]['g_id_usuario']);
            $sql .= ' and e.idt_nan_tipo = 6';
            $sql .= " and e.ativo = 'S'";
            $sql .= " and ef.tipo_entidade = 'P'";
            $sql .= " and ef.reg_situacao = 'A'";
            $rs = execsql($sql);

            if ($rs->rows == 0) {
                die('Você não esta cadastrado no sistema como AOE! Com isso não pode realizar a Primeira Visita.');
            } else if ($rs->rows > 1) {
                die('Você tem mais de um cadastro ativos de AOE no sistema! Só pode ter um cadastro ativo para realizar a Primeira Visita.');
            }

            $row = $rs->data[0];

            if ($row['ativo'] != 'S') {
                die('O seu cadastro no GC não esta ativo! Com isso não pode realizar a Primeira Visita.');
            }

            if ($row['credenciado_nan'] != 'S') {
                die('O seu cadastro no GC não é um credenciado NAN! Com isso não pode realizar a Primeira Visita.');
            }

            if ($row['nan_ano'] != nan_ano) {
                die('O seu cadastro no GC não é um credenciado NAN no ano de ' . nan_ano . '! Com isso não pode realizar a Primeira Visita.');
            }

            $sql = '';
            $sql .= ' select distinct uo.id_usuario';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade_entidade ee';
            $sql .= ' inner join ' . db_pir_gec . 'gec_entidade ef on ef.idt = ee.idt_entidade';
            $sql .= ' inner join ' . db_pir_gec . 'plu_usuario uf on uf.login = ef.codigo';
            $sql .= ' inner join ' . db_pir_gec . 'gec_entidade eo on eo.idt = ee.idt_entidade_relacionada';
            $sql .= ' inner join ' . db_pir_gec . 'plu_usuario uo on uo.login = eo.codigo';
            $sql .= ' where uf.id_usuario = ' . null(IdUsuarioPIR($_SESSION[CS]['g_id_usuario'], db_pir_grc, db_pir_gec));
            $sql .= " and ee.ativo = 'S'";
            $sql .= ' and ee.idt_entidade_relacao = 8';
            $sql .= " and eo.tipo_entidade = 'O'";
            $sql .= " and eo.reg_situacao = 'A'";
            $sql .= " and eo.ativo = 'S'";
            $sql .= " and eo.credenciado_nan = 'S'";
            $rs = execsql($sql);

            if ($rs->rows == 0) {
                die('Você não tem uma empresa credenciada ativa AOE vinculada! Com isso não pode realizar a Primeira Visita.');
            } else if ($rs->rows > 1) {
                die('Você tem mais de um vinculo de empresa credenciada ativa AOE vinculada! Com isso não pode realizar a Primeira Visita.');
            }

            $idt_nan_empresa = IdUsuarioPIR($rs->data[0][0], db_pir_gec, db_pir_grc);

            $tam = 10;
            $codigow = geraAutoNum(db_pir_grc, $tabela . '_' . $Campo . 'NAN', $tam);
            $codigo = 'NAN' . $codigow;

            $sql = "insert into grc_nan_grupo_atendimento (status_1, num_visita_atu) values ('CD', 1)";
            execsql($sql);
            $idt_grupo_atendimento = lastInsertId();

            $nan_campo = 'idt_unidade, idt_nan_empresa, idt_nan_tutor, idt_grupo_atendimento, nan_num_visita, ';
            $nan_valor = null($row['idt_unidade']) . ', ' . null($idt_nan_empresa) . ', ' . null($row['idt_nan_tutor']) . ', ' . null($idt_grupo_atendimento) . ", 1, ";

            $idt_ponto_atendimento = 'null';
            $idt_projeto = null($row['idt_projeto']);
            $idt_projeto_acao = null($row['idt_acao']);
            $gestor_sge = 'null';
            $fase_acao_projeto = 'null';
            $idt_consultor_prox_atend = $idt_consultor;
        } else if ($variavel['idt_evento'] == '') {
            $tam = 11;
            $codigow = geraAutoNum(db_pir_grc, 'grc_atendimento_' . $Campo, $tam);

            if ($variavel['origem'] == 'P') {
                $codigo = 'AT' . $codigow;
            } else {
                $codigo = 'ATD' . $codigow;
            }
        } else {
            if ($idt_ponto_atendimento == '') {
                $sql = "select idt_ponto_atendimento";
                $sql .= ' from ' . db_pir_grc . 'grc_evento';
                $sql .= " where idt = " . null($variavel['idt_evento']);
                $rsVaga = execsql($sql);
                $idt_ponto_atendimento = $rsVaga->data[0][0];
            }

            if (defined('CodigoMatriculaPaiEventoComposto')) {
                $codigo = CodigoMatriculaPaiEventoComposto;
                $where_protocolo = ' and idt_evento = ' . null($variavel['idt_evento']);

                $nan_campo = 'idt_atendimento_pai, ';
                $nan_valor = idtAtendimentoPaiEventoComposto . ', ';
            } else {
                $tam = 7;
                $codigow = geraAutoNum(db_pir_grc, $tabela . '_' . $Campo . 'MAT', $tam);
                $codigo = 'MAT' . $codigow;
            }
        }

        if ($variavel['evento_origem'] == '') {
            $variavel['evento_origem'] = 'PIR';
        }

        if ($variavel['canal_registro'] == '') {
            $variavel['canal_registro'] = $_SESSION[CS]['g_evento_canal_registro'];
        }

        if ($variavel['canal_registro'] == '') {
            if ($variavel['evento_origem'] == 'PIR') {
                $variavel['canal_registro'] = 'CRM';
            }

            if ($variavel['evento_origem'] == 'WEBSERVICE') {
                $variavel['canal_registro'] = 'LOJA';
            }
        }

        $protocolow = $codigo;
        $protocolo = aspa($protocolow);

        $kokw = 0;
        $sql2 = 'select ';
        $sql2 .= '  grc_a.idt   ';
        $sql2 .= '  from ' . db_pir_grc . 'grc_atendimento grc_a ';
        $sql2 .= ' where grc_a.idt_atendimento_agenda    = ' . null($idt_atendimento_agenda);
        $sql2 .= '   and grc_a.primeiro = ' . aspa('Sim');
        $rs_aap = execsql($sql2);
        if ($rs_aap->rows > 0) {
            // ConfirmaAtendimento($idt_atendimento_agenda, $variavel);

            return 2;
        }
        $kokw = 0;
        $sql2 = 'select ';
        $sql2 .= '  grc_a.*   ';
        $sql2 .= '  from ' . db_pir_grc . 'grc_atendimento grc_a ';
        $sql2 .= '  where grc_a.protocolo = ' . $protocolo;
        $sql2 .= $where_protocolo;
        $rs_aap = execsql($sql2);
        if ($rs_aap->rows == 0) {
            // grava registro

            $sql_i = ' insert into ' . db_pir_grc . 'grc_atendimento ';
            $sql_i .= ' (  ';
            $sql_i .= $nan_campo;
            $sql_i .= ' origem,';
            $sql_i .= ' idt_evento,';
            $sql_i .= ' evento_origem,';
            $sql_i .= ' canal_registro,';
            $sql_i .= " idt_atendimento_agenda, ";
            $sql_i .= " protocolo, ";
            $sql_i .= " data, ";
            $sql_i .= " situacao, ";
            $sql_i .= " idt_instrumento, ";
            $sql_i .= " idt_ponto_atendimento, ";
            $sql_i .= " idt_consultor, ";
            $sql_i .= " idt_digitador, ";
            $sql_i .= " idt_consultor_prox_atend, ";
            //     $sql_i .= " idt_pessoa, ";
            //     $sql_i .= " idt_cliente, ";
            $sql_i .= " assunto, ";
            $sql_i .= " data_inicio_atendimento, ";
            $sql_i .= " data_termino_atendimento, ";
            $sql_i .= " horas_atendimento, ";

            $sql_i .= " hora_inicio_atendimento, ";
            $sql_i .= " hora_termino_atendimento, ";

            $sql_i .= " cpf, ";
            $sql_i .= " cnpj, ";
            $sql_i .= " nome_pessoa, ";

            $sql_i .= " nome_empresa, ";

            $sql_i .= " idt_competencia, ";
            $sql_i .= " idt_projeto, ";
            $sql_i .= " idt_projeto_acao, ";
            $sql_i .= " gestor_sge, ";
            $sql_i .= " fase_acao_projeto, ";

            $sql_i .= " senha_totem, ";
            $sql_i .= " senha_ordem, ";

            $sql_i .= " primeiro ";
            $sql_i .= '  ) values ( ';
            $sql_i .= $nan_valor;
            $sql_i .= aspa($variavel['origem']) . ', ';
            $sql_i .= null($variavel['idt_evento']) . ', ';
            $sql_i .= aspa($variavel['evento_origem']) . ', ';
            $sql_i .= aspa($variavel['canal_registro']) . ', ';
            $sql_i .= " $idt_atendimento_agenda, ";
            $sql_i .= " $protocolo, ";
            $sql_i .= " $datay, ";
            $sql_i .= " $situacao, ";
            $sql_i .= " $idt_instrumento, ";
            $sql_i .= " $idt_ponto_atendimento, ";
            $sql_i .= " $idt_consultor, ";
            $sql_i .= " $idt_consultor, ";
            $sql_i .= " $idt_consultor_prox_atend, ";
            //     $sql_i .= " $idt_pessoa, ";
            //     $sql_i .= " $idt_cliente, ";
            $sql_i .= " $assunto, ";
            $sql_i .= " $data_inicio_atendimento, ";
            $sql_i .= " $data_termino_atendimento, ";
            $sql_i .= " $horas_atendimento, ";
            $sql_i .= " $hora_inicio_atendimento, ";
            $sql_i .= " $hora_termino_atendimento, ";
            $sql_i .= " $cpf, ";
            $sql_i .= " $cnpj, ";
            $sql_i .= " $nome_pessoa, ";

            $sql_i .= " $nome_empresa, ";
            $sql_i .= " $idt_competencia, ";

            $sql_i .= " $idt_projeto, ";
            $sql_i .= " $idt_projeto_acao, ";
            $sql_i .= " $gestor_sge, ";
            $sql_i .= " $fase_acao_projeto, ";

            $sql_i .= " $senha_totem, ";
            $sql_i .= " $senha_ordem, ";

            $sql_i .= " $primeiro ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
            $idt_atendimento = lastInsertId();
            $variavel['idt_atendimento'] = $idt_atendimento;

            if (nan == 'S') {
                $sql = 'insert into grc_atendimento_tema (idt_atendimento, idt_tema, idt_sub_tema, tipo_tratamento)';
                $sql .= " select $idt_atendimento as idt_atendimento, t.idt as idt_tema, s.idt as idt_sub_tema, 'T' as tipo_tratamento";
                $sql .= ' from grc_tema_subtema s';
                $sql .= ' inner join grc_tema_subtema t on substring(s.codigo, 1, 2) = t.codigo and t.nivel = 0';
                $sql .= ' where s.nivel = 1';
                $sql .= ' and s.idt in (';
                $sql .= ' select idt_tema_subtema';
                $sql .= ' from grc_formulario_area';
                $sql .= " where ativo = 'S'";
                $sql .= ' )';
                execsql($sql);
            }

            //
            // Gerar Pessoas associadas ao atendimento
            //
             // buscar dados da Pessoa
            //
             
             //
             // Busca dados da Pessoa
            //
            $cpfcnpj_w = $cpf_w;
            $vetEntidade = Array();
            //
            $kretw = BuscaDadosEntidadePIR($cpfcnpj_w, 'P', $vetEntidade);
            //
            $kretw = BuscaDadosEntidadeSIACBA($cpfcnpj_w, 'F', $vetEntidade);
            // Essa base só tem CNPJ
            // $kretw = BuscaDadosEntidadeSIACNA($cpfcnpj_w,$vetEntidade);
            //
             $kretw = BuscaDadosEntidadeMEI($cpfcnpj_w, 'F', $vetEntidade);
            //
            // Essa base só tem CNPJ
            // $kretw = BuscaDadosEntidadeRF($cpfcnpj_w,$vetEntidade);
            //
             //echo " FFFF {$cpfcnpj_w} JJJJJ $cnpj_w <br />";
            //
             // Se tem empresa associada Busca dados
            //
             if ($cnpj_w != "") {
                $cpfcnpj_w = $cnpj_w;
                //
                // $vetEntidade=Array();
                //
                $kretw = BuscaDadosEntidadePIR($cpfcnpj_w, 'O', $vetEntidade);
                //
                $kretw = BuscaDadosEntidadeSIACBA($cpfcnpj_w, 'J', $vetEntidade);
                //
                $kretw = BuscaDadosEntidadeSIACNA($cpfcnpj_w, 'J', $vetEntidade);
                //
                $kretw = BuscaDadosEntidadeMEI($cpfcnpj_w, 'J', $vetEntidade);
                //
                $kretw = BuscaDadosEntidadeRF($cpfcnpj_w, 'J', $vetEntidade);
                //
                $vetpir = $vetEntidade['PIR']['O'];
                $codigo_siacweb_e = "";
                $idt_tipo_empreendimento_e = "";
                $cnpj_e = "";
                $razao_social_e = "";
                $nome_fantasia_e = "";
                $data_abertura_e = "";
                $pessoas_ocupadas_e = "";
                $cep_e = "";
                $logradouro_e = "";
                $logradouro_numero_e = "";
                $logradouro_bairro_e = "";
                $logradouro_complemento_e = "";
                $logradouro_municipio_e = "";
                $logradouro_estado_e = "";
                $logradouro_pais_e = "";
                $idt_pais_e = "";
                $idt_estado_e = "";
                $idt_cidade_e = "";
                $telefone_comercial_e = "";
                $telefone_celular_e = "";
                $sms_e = "";
                $email_e = "";
                $site_url_e = "";
                $receber_informacao_e = "";
                //p($vetpir);
                if ($vetpir['existe_entidade'] == 'S') {
                    $qtd_entidade = $vetpir['qtd_entidade'];
                    $idt_entidade = $vetpir['idt_entidade'];
                    $cpfcnpj = $vetpir['cpfcnpj'];
                    $idt_cliente = $vetpir['idt_cliente'];
                    $nome = $vetpir['nome'];
                    $telefone = $vetpir['telefone'];
                    $celular = $vetpir['celular'];
                    $email = $vetpir['email'];
                    $cnpj = $vetpir['cnpj'];
                    $nome_empresa = $vetpir['nome_empresa'];

                    // funil
                    $funil_idt_cliente_classificacao = $vetpir['funil_idt_cliente_classificacao'];
                    $funil_cliente_nota_avaliacao = $vetpir['funil_cliente_nota_avaliacao'];
                    $funil_cliente_data_avaliacao = $vetpir['funil_cliente_data_avaliacao'];
                    $funil_cliente_obs_avaliacao = $vetpir['funil_cliente_obs_avaliacao'];

                    //
                    $cnpj_e = $cpfcnpj;
                    $razao_social_e = $nome;
                    $nome_fantasia_e = $nome;
                    // complemento dependendo do tipo
                    $vetdadosproprios = $vetpir['dadosproprios'];
                    //p($vetdadosproprios);

                    $idt_e = $vetdadosproprios['row']['idt'];
                    $idt_origem_e = $vetdadosproprios['row']['idt_origem'];
                    $idt_entidade_e = $vetdadosproprios['row']['idt_entidade'];
                    $inscricao_estadual_e = $vetdadosproprios['row']['inscricao_estadual'];
                    $inscricao_municipal_e = $vetdadosproprios['row']['inscricao_municipal'];
                    $registro_junta_e = $vetdadosproprios['row']['registro_junta'];
                    $data_registro_e = $vetdadosproprios['row']['data_registro'];
                    $ativo_e = $vetdadosproprios['row']['ativo'];
                    $idt_porte_e = $vetdadosproprios['row']['idt_porte'];
                    $idt_tipo_e = $vetdadosproprios['row']['idt_tipo'];
                    $idt_natureza_juridica_e = $vetdadosproprios['row']['idt_natureza_juridica'];
                    $idt_faturamento_e = $vetdadosproprios['row']['idt_faturamento'];
                    $faturamento_e = $vetdadosproprios['row']['faturamento'];
                    $qt_funcionarios_e = $vetdadosproprios['row']['qt_funcionarios'];
                    $data_inicio_atividade_e = $vetdadosproprios['row']['data_inicio_atividade'];
                    $dap_e = $vetdadosproprios['row']['dap'];
                    $nirf_e = $vetdadosproprios['row']['nirf'];
                    $rmp_e = $vetdadosproprios['row']['rmp'];
                    $ie_prod_rural_e = $vetdadosproprios['row']['ie_prod_rural'];
                    $sicab_codigo = $vetdadosproprios['row']['sicab_codigo'];
                    $sicab_dt_validade = $vetdadosproprios['row']['sicab_dt_validade'];
                    $data_fim_atividade = $vetdadosproprios['row']['data_fim_atividade'];
                    $siacweb_situacao = $vetpir['siacweb_situacao'];
                    $pa_senha = $vetpir['pa_senha'];
                    $pa_idfacebook = $vetpir['pa_idfacebook'];
                    $startup_e = $vetdadosproprios['row']['startup'];
                    $data_encerramento_e = $vetdadosproprios['row']['data_encerramento'];
                    $simples_nacional_e = $vetdadosproprios['row']['simples_nacional'];
                    $idt_entidade_setor_e = $vetdadosproprios['row']['idt_entidade_setor'];
                    // Parte variável
                    $vetenderecos = $vetpir['enderecos'];
                    $vetprotocolos = $vetpir['protocolos'];
                    $vetempresas = $vetpir['empresas'];
                    $vetempresasPE = $vetempresas['PE'];
                    $vetempresasEP = $vetempresas['EP'];
                    ForEach ($vetenderecos as $idx => $Vettrab) {
                        $vetendereco = $Vettrab['endereco'];
                        $vetrow = $vetendereco['row'];
                        //
                        // 00 é o principal
                        //
                       //$vetrow['idt_entidade_endereco_tipo'];
                        if ($vetrow['gec_eneet_codigo'] != "00" && $vetrow['gec_eneet_codigo'] != "99") {
                            continue;
                        }
                        $logradouro_e = $vetrow['logradouro'];
                        $logradouro_numero_e = $vetrow['logradouro_numero'];
                        $logradouro_complemento_e = $vetrow['logradouro_complemento'];
                        $logradouro_bairro_e = $vetrow['logradouro_bairro'];
                        $logradouro_municipio_e = $vetrow['logradouro_municipio'];
                        $logradouro_estado_e = $vetrow['logradouro_estado'];
                        $logradouro_pais_e = $vetrow['logradouro_pais'];
                        $logradouro_cep_e = $vetrow['logradouro_cep'];
                        $cep_e = $vetrow['cep'];
                        $logradouro_cep_e = $cep_e;

                        $idt_pais_e = $vetrow['idt_pais'];
                        $idt_estado_e = $vetrow['idt_estado'];
                        $idt_cidade_e = $vetrow['idt_cidade'];

                        $vetcomunicacaow = $vetendereco['comunicacao'];
                        if (is_array($vetcomunicacaow)) {
                            ForEach ($vetcomunicacaow as $idxw => $VetCom) {
                                //p($VetCom);
                                $telefone_1_e = $VetCom['comunicacao']['telefone_1'];
                                $telefone_2_e = $VetCom['comunicacao']['telefone_2'];
                                $email_1_e = $VetCom['comunicacao']['email_1'];
                                $email_2_e = $VetCom['comunicacao']['email_2'];
                                $sms_1_e = $VetCom['comunicacao']['sms_1'];
                                $sms_2_e = $VetCom['comunicacao']['sms_2'];

                                $email_e = $VetCom['comunicacao']['email_1'];
                                $sms_e = $VetCom['comunicacao']['sms_1'];
                            }
                        }
                    }
                }
////////////////////////////////////
                //p($vetpir);
                //exit();
            }
            // p($vetEntidade);
            //
             
             

             if ($cpf != "NULL") {   // caso do atendimento direto sem passar pelo totem
                $variavelw = Array();
                $variavelw['cpf'] = $cpf_w;
                $variavelw['$cnpj'] = $cnpj_w;
                BuscaCPF($idt_atendimento, $variavelw);
            }
////////////////////////////////////////////////////////////// aqui busca e grava pessoa para atendimento
            /*

              $vetExistencia=Array();

              // EXISTÊNCIA NO SISTEMA PIR
              // PARA A PESSOA FÍSICA
              //
              $vetpir = $vetEntidade['PIR']['P'];
              //
              //p($vetpir);
              //
              $vetExistencia['PIR']['P']['existe_entidade']=$vetpir['existe_entidade'];
              //
              if ($vetpir['existe_entidade']=='S')
              {
              $qtd_entidade = $vetpir['qtd_entidade'];
              $idt_entidade = $vetpir['idt_entidade'];
              $cpfcnpj      = $vetpir['cpfcnpj'];
              $idt_cliente  = $vetpir['idt_cliente'];
              $nome         = $vetpir['nome'];
              $telefone     = $vetpir['telefone'];
              $celular      = $vetpir['celular'];
              $email        = $vetpir['email'];
              $cnpj         = $vetpir['cnpj'];
              $nome_empresa = $vetpir['nome_empresa'];
              // complemento dependendo do tipo
              $vetdadosproprios = $vetpir['dadosproprios'];
              //p($vetdadosproprios);

              $idt_complemento_pessoa_c = $vetdadosproprios['row']['idt'];
              $idt_origem_c             = $vetdadosproprios['row']['idt_origem'];
              $idt_entidade_c           = $vetdadosproprios['row']['idt_entidade'];
              $ativo_c                  = $vetdadosproprios['row']['ativo'];
              $data_nascimento_c        = $vetdadosproprios['row']['data_nascimento'];
              $nome_pai_c               = $vetdadosproprios['row']['nome_pai'];
              $nome_mae_c               = $vetdadosproprios['row']['nome_mae'];
              $idt_profissao_c          = $vetdadosproprios['row']['idt_profissao'];
              $idt_estado_civil_c       = $vetdadosproprios['row']['idt_estado_civil'];
              $idt_cor_pele_c           = $vetdadosproprios['row']['idt_cor_pele'];
              $idt_religiao_c           = $vetdadosproprios['row']['idt_religiao'];
              $idt_destreza_c           = $vetdadosproprios['row']['idt_destreza'];
              $idt_sexo_c               = $vetdadosproprios['row']['idt_sexo'];
              $necessidade_especial_c   = $vetdadosproprios['row']['necessidade_especial'];
              $idt_escolaridade_c       = $vetdadosproprios['row']['idt_escolaridade'];
              $receber_informacao_c     = $vetdadosproprios['row']['receber_informacao'];
              $nome_tratamento_c        = $vetdadosproprios['row']['nome_tratamento'];
              // Parte variável
              $vetenderecos      =  $vetpir['enderecos'];
              $vetprotocolos     =  $vetpir['protocolos'];
              $vetempresas       =  $vetpir['empresas'];
              $vetempresasPE     =  $vetempresas['PE'];
              $vetempresasEP     =  $vetempresas['EP'];

              ForEach ($vetenderecos as $idx => $Vettrab) {
              $vetendereco = $Vettrab['endereco'];
              $vetrow      = $vetendereco['row'];
              //
              // 00 é o principal
              //
              $vetrow['idt_entidade_endereco_tipo'];
              if ($vetrow['gec_eneet_codigo']!="00")
              {
              continue;
              }
              $logradouro_p             = $vetrow['logradouro'];
              $logradouro_numero_p      = $vetrow['logradouro_numero'];
              $logradouro_complemento_p = $vetrow['logradouro_complemento'];
              $logradouro_bairro_p      = $vetrow['logradouro_bairro'];
              $logradouro_municipio_p   = $vetrow['logradouro_municipio'];
              $logradouro_estado_p      = $vetrow['logradouro_estado'];
              $logradouro_pais_p        = $vetrow['logradouro_pais'];
              $logradouro_cep_p         = $vetrow['logradouro_cep'];
              $cep_p                    = $vetrow['cep'];

              $idt_pais_p               = $vetrow['idt_pais'];
              $idt_estado_p             = $vetrow['idt_estado'];
              $idt_cidade_p             = $vetrow['idt_cidade'];

              $vetcomunicacaow  = $vetendereco['comunicacao'];
              if (is_array($vetcomunicacaow))
              {
              ForEach ($vetcomunicacaow as $idxw => $VetCom) {
              //p($VetCom);
              $telefone_1_p = $VetCom['comunicacao']['telefone_1'];
              $telefone_2_p = $VetCom['comunicacao']['telefone_2'];
              $email_1_p    = $VetCom['comunicacao']['email_1'];
              $email_2_p    = $VetCom['comunicacao']['email_2'];
              $sms_1_p      = $VetCom['comunicacao']['sms_1'];
              $sms_2_p      = $VetCom['comunicacao']['sms_2'];
              }
              }
              }
              }


              $vetEntidade['SIACBA'][$tipo]=$vetret;
              $vetpir = $vetEntidade['SIACBA']['P'];
              //
              //p($vetpir);
              //
              $vetExistencia['SIACBA']['P']['existe_entidade']=$vetpir['existe_entidade'];
              //
              $codigo_siacweb = "";
              if ($vetpir['existe_entidade']=='S')
              {
              $codigo_siacweb = $vetpir['idt_entidade'];

              ////////////// rotina de pegar do siacweb

              }

              $codigo_siacweb = aspa($codigo_siacweb);
              //  Gravar Pessoa
              $nome_mae                 = aspa($nome_mae_c) ;
              $nome_pai                 = aspa($nome_pai_c) ;
              $logradouro_cep           = aspa($cep_p) ;
              $logradouro_endereco      = aspa($logradouro_p) ;
              $logradouro_numero        = aspa($logradouro_numero_p) ;
              $logradouro_bairro        = aspa($logradouro_bairro_p) ;
              $logradouro_complemento   = aspa($logradouro_complemento_p) ;
              $logradouro_cidade        = aspa($logradouro_municipio_p) ;
              $logradouro_estado        = aspa($logradouro_estado_p) ;
              $logradouro_pais          = aspa($logradouro_pais_p) ;
              $idt_pais                 = null(idt_pais_p) ;
              $idt_estado               = null(idt_estado_p) ;
              $idt_cidade               = null(idt_cidade_p) ;
              $telefone_residencial     = aspa($telefone_1_p) ;
              $telefone_celular         = aspa($telefone_2_p) ;
              $email                    = aspa($email_1_p) ;
              $sms                      = aspa($sms_1_p) ;

              $nome_tratamento          = aspa($nome_tratamento_c) ;
              $idt_escolaridade         = null($idt_escolaridade_c) ;
              $idt_sexo                 = aspa($idt_sexo_c) ;
              $data_nascimento          = aspa($data_nascimento_c) ;
              $receber_informacao       = aspa($receber_informacao_c) ;
              $necessidade_especial     = aspa($necessidade_especial_c) ;
              //

              $idt_profissao            = null($idt_profissao_c) ;
              $idt_estado_civil         = null($idt_estado_civil_c) ;
              $idt_cor_pele             = null($idt_cor_pele_c) ;
              $idt_religiao             = null($idt_religiao_c) ;
              $idt_destreza             = null($idt_destreza_c) ;
              //
              $nome         = $nome_pessoa;
              $tipo_relacao = aspa("L");
              $sql_i  = ' insert into grc_atendimento_pessoa ';
              $sql_i .= ' (  ';
              $sql_i .= " idt_atendimento, ";
              $sql_i .= " codigo_siacweb, ";
              $sql_i .= " cpf, ";
              $sql_i .= " nome, ";
              $sql_i .= " tipo_relacao, ";
              $sql_i .= " nome_mae, ";
              $sql_i .= " nome_pai, ";
              $sql_i .= " logradouro_cep, ";
              $sql_i .= " logradouro_endereco, ";
              $sql_i .= " logradouro_numero, ";
              $sql_i .= " logradouro_bairro, ";
              $sql_i .= " logradouro_complemento, ";
              $sql_i .= " logradouro_cidade, ";
              $sql_i .= " logradouro_estado, ";
              $sql_i .= " logradouro_pais, ";
              $sql_i .= " idt_pais, ";
              $sql_i .= " idt_estado, ";
              $sql_i .= " idt_cidade, ";
              $sql_i .= " telefone_residencial, ";
              $sql_i .= " telefone_celular, ";
              $sql_i .= " email, ";
              $sql_i .= " sms, ";
              $sql_i .= " nome_tratamento, ";
              $sql_i .= " idt_escolaridade, ";
              $sql_i .= " idt_sexo, ";
              $sql_i .= " data_nascimento, ";
              $sql_i .= " receber_informacao, ";
              $sql_i .= " necessidade_especial, ";
              $sql_i .= " idt_profissao, ";
              $sql_i .= " idt_estado_civil, ";
              $sql_i .= " idt_cor_pele, ";
              $sql_i .= " idt_religiao, ";
              $sql_i .= " idt_destreza ";
              $sql_i .= '  ) values ( ';
              $sql_i .= " $idt_atendimento, ";
              $sql_i .= " $codigo_siacweb, ";
              $sql_i .= " $cpf, ";
              $sql_i .= " $nome, ";
              $sql_i .= " $tipo_relacao, ";
              $sql_i .= " $nome_mae, ";
              $sql_i .= " $nome_pai, ";
              $sql_i .= " $logradouro_cep, ";
              $sql_i .= " $logradouro_endereco, ";
              $sql_i .= " $logradouro_numero, ";
              $sql_i .= " $logradouro_bairro, ";
              $sql_i .= " $logradouro_complemento, ";
              $sql_i .= " $logradouro_cidade, ";
              $sql_i .= " $logradouro_estado, ";
              $sql_i .= " $logradouro_pais, ";
              $sql_i .= " $idt_pais, ";
              $sql_i .= " $idt_estado, ";
              $sql_i .= " $idt_cidade, ";
              $sql_i .= " $telefone_residencial, ";
              $sql_i .= " $telefone_celular, ";
              $sql_i .= " $email, ";
              $sql_i .= " $sms, ";
              $sql_i .= " $nome_tratamento, ";
              $sql_i .= " $idt_escolaridade, ";
              $sql_i .= " $idt_sexo, ";
              $sql_i .= " $data_nascimento, ";
              $sql_i .= " $receber_informacao, ";
              $sql_i .= " $necessidade_especial, ";

              $sql_i .= " $idt_profissao, ";
              $sql_i .= " $idt_estado_civil, ";
              $sql_i .= " $idt_cor_pele, ";
              $sql_i .= " $idt_religiao, ";
              $sql_i .= " $idt_destreza ";

              $sql_i .= ') ';

              //
              if ($cpf!="NULL")
              {   // caso do atendimento direto sem passar pelo totem
              $result = execsql($sql_i);
              }

              ////////////////////////////////////// fim rotina anterior de buscar pessoa
             */

            //
            ////////////////////// GRAVAR EMPRESA
            //
             
             //echo "  $cnpj_w <br />  ";

            if ($cnpj_w != "") {
                //
                //  TEM EMPRESA ASSOCIADA
                //
                $codigo_siacweb = aspa($codigo_siacweb_e);
                $idt_tipo_empreendimento = null($idt_tipo_empreendimento_e);

                if ($razao_social_e == '') {
                    $cnpj = aspa($cnpj_w);
                    $razao_social = aspa('Novo Empreendimento');
                } else {
                    $cnpj = aspa($cnpj_e);
                    $razao_social = aspa($razao_social_e);
                }

                $nome_fantasia = aspa($nome_fantasia_e);
                $data_abertura = aspa($data_abertura_e);
                $pessoas_ocupadas = null($pessoas_ocupadas_e);
                $logradouro_cep = aspa($cep_e);

                $logradouro_e = substr($logradouro_e, 0, 120);

                $logradouro_endereco = aspa($logradouro_e);
                $logradouro_numero = aspa($logradouro_numero_e);
                $logradouro_bairro = aspa($logradouro_bairro_e);
                $logradouro_complemento = aspa($logradouro_complemento_e);
                $logradouro_cidade = aspa($logradouro_municipio_e);
                $logradouro_estado = aspa($logradouro_estado_e);
                $logradouro_pais = aspa($logradouro_pais_e);
                $idt_pais = null($idt_pais_e);
                $idt_estado = null($idt_estado_e);
                $idt_cidade = null($idt_cidade_e);
                $telefone_comercial = aspa($telefone_comercial_e);
                $telefone_celular = aspa($telefone_celular_e);
                $sms = aspa($sms_e);
                $email = aspa($email_e);
                $site_url = aspa($site_url_e);
                $receber_informacao = aspa($receber_informacao_e);

                // funil
                $funil_idt_cliente_classificacao = null($funil_idt_cliente_classificacao);
                $funil_cliente_nota_avaliacao = null($funil_cliente_nota_avaliacao);
                $funil_cliente_data_avaliacao = aspa($funil_cliente_data_avaliacao);
                $funil_cliente_obs_avaliacao = aspa($funil_cliente_obs_avaliacao);
                //
                // guybete
                $kokw = 0;
                $sql2 = 'select ';
                $sql2 .= '  grc_ao.*   ';
                $sql2 .= '  from grc_atendimento_organizacao grc_ao ';
                $sql2 .= '  where grc_ao.idt_atendimento = ' . null($idt_atendimento);
                $sql2 .= '    and grc_ao.cnpj = ' . $cnpj;
                $rs_aap = execsql($sql2);
                if ($rs_aap->rows == 0) {
                    $sql_i = ' insert into grc_atendimento_organizacao ';
                    $sql_i .= ' (  ';
                    $sql_i .= " idt_atendimento, ";
                    $sql_i .= " cnpj, ";
                    $sql_i .= " razao_social, ";
                    $sql_i .= " nome_fantasia, ";
                    $sql_i .= " codigo_siacweb_e, ";

                    // funil
                    $sql_i .= " funil_idt_cliente_classificacao, ";
                    $sql_i .= " funil_cliente_nota_avaliacao, ";
                    $sql_i .= " funil_cliente_data_avaliacao, ";
                    $sql_i .= " funil_cliente_obs_avaliacao, ";

                    $sql_i .= " idt_tipo_empreendimento, ";
                    $sql_i .= " data_abertura, ";
                    $sql_i .= " pessoas_ocupadas, ";
                    $sql_i .= " logradouro_cep_e, ";
                    $sql_i .= " logradouro_endereco_e, ";
                    $sql_i .= " logradouro_numero_e, ";
                    $sql_i .= " logradouro_bairro_e, ";
                    $sql_i .= " logradouro_complemento_e, ";
                    $sql_i .= " logradouro_cidade_e, ";
                    $sql_i .= " logradouro_estado_e, ";
                    $sql_i .= " logradouro_pais_e, ";
                    $sql_i .= " idt_pais_e, ";
                    $sql_i .= " idt_estado_e, ";
                    $sql_i .= " idt_cidade_e, ";
                    $sql_i .= " telefone_comercial_e, ";
                    $sql_i .= " telefone_celular_e, ";
                    $sql_i .= " email_e, ";
                    $sql_i .= " sms_e, ";
                    $sql_i .= " site_url, ";
                    $sql_i .= " representa, ";
                    $sql_i .= " receber_informacao_e ";
                    $sql_i .= '  ) values ( ';
                    $sql_i .= " $idt_atendimento, ";
                    $sql_i .= " $cnpj, ";
                    $sql_i .= " $razao_social, ";
                    $sql_i .= " $nome_fantasia, ";
                    $sql_i .= " $codigo_siacweb, ";

                    // funil
                    $sql_i .= " $funil_idt_cliente_classificacao, ";
                    $sql_i .= " $funil_cliente_nota_avaliacao, ";
                    $sql_i .= " $funil_cliente_data_avaliacao, ";
                    $sql_i .= " $funil_cliente_obs_avaliacao, ";

                    $sql_i .= " $idt_tipo_empreendimento, ";
                    $sql_i .= " $data_abertura, ";
                    $sql_i .= " $pessoas_ocupadas, ";
                    $sql_i .= " $logradouro_cep, ";
                    $sql_i .= " $logradouro_endereco, ";
                    $sql_i .= " $logradouro_numero, ";
                    $sql_i .= " $logradouro_bairro, ";
                    $sql_i .= " $logradouro_complemento, ";
                    $sql_i .= " $logradouro_cidade, ";
                    $sql_i .= " $logradouro_estado, ";
                    $sql_i .= " $logradouro_pais, ";
                    $sql_i .= " $idt_pais, ";
                    $sql_i .= " $idt_estado, ";
                    $sql_i .= " $idt_cidade, ";
                    $sql_i .= " $telefone_comercial, ";
                    $sql_i .= " $telefone_celular, ";
                    $sql_i .= " $email, ";
                    $sql_i .= " $sms, ";
                    $sql_i .= " $site_url, ";
                    $sql_i .= " 'S', ";
                    $sql_i .= " $receber_informacao ";
                    $sql_i .= ') ';
                    $result = execsql($sql_i);
                } else {
                    $sql_a = " update grc_atendimento_organizacao set ";

                    // funil
                    $sql_a .= "  funil_idt_cliente_classificacao = $funil_idt_cliente_classificacao, ";
                    $sql_a .= "  funil_cliente_nota_avaliacao    = $funil_cliente_nota_avaliacao, ";
                    $sql_a .= "  funil_cliente_data_avaliacao    = $funil_cliente_data_avaliacao, ";
                    $sql_a .= "  funil_cliente_obs_avaliacao     = $funil_cliente_obs_avaliacao, ";

                    $sql_a .= "  representa = 'S' ";
                    $sql_a .= '  where idt_atendimento = ' . null($idt_atendimento);
                    $sql_a .= '    and cnpj            = ' . ($cnpj);
                    $result = execsql($sql_a);
                }
                //p($sql_i);
            }
        }

        //exit();
        ////////////////// atualiza painel
        // ConfirmaAtendimento($idt_atendimento_agenda, $variavel);
    }

    $kokw = 1;
    return $kokw;
}

//
//
//
function GeraEmpreendimentoAtendimento($idt_atendimento) {
    //
    //  Pessoa esta ligada a empreendimentos.
    //
    
    // Gerar registro inicial
    //
    $sql1 = 'select ';
    $sql1 .= '  grc_ao.*   ';
    $sql1 .= '  from grc_atendimento_organizacao grc_ao ';
    $sql1 .= ' where  grc_ao.idt_atendimento    = ' . null($idt_atendimento);
    //p($sql1);
    $rs_aa = execsql($sql1);
    if ($rs_aa->rows == 0) {
        // CRIAR REGISTRO ESPECIAL DO ATENDIMENTO
        //
        $cnpj_e = "###.{$idt_atendimento}";
        $razao_social_e = "### REGISTRO PARA SER INFORMADO ";
        $codigo_siacweb = aspa($codigo_siacweb_e);
        $idt_tipo_empreendimento = null($idt_tipo_empreendimento_e);
        $cnpj = aspa($cnpj_e);

        $razao_social = aspa($razao_social_e);
        $nome_fantasia = aspa($nome_fantasia_e);



        $data_abertura = aspa($data_abertura_e);
        $pessoas_ocupadas = null($pessoas_ocupadas_e);
        $logradouro_cep = aspa($cep_e);

        $logradouro_e = substr($logradouro_e, 0, 120);

        $logradouro_endereco = aspa($logradouro_e);
        $logradouro_numero = aspa($logradouro_numero_e);
        $logradouro_bairro = aspa($logradouro_bairro_e);
        $logradouro_complemento = aspa($logradouro_complemento_e);
        $logradouro_cidade = aspa($logradouro_municipio_e);
        $logradouro_estado = aspa($logradouro_estado_e);
        $logradouro_pais = aspa($logradouro_pais_e);
        $idt_pais = null($idt_pais_e);
        $idt_estado = null($idt_estado_e);
        $idt_cidade = null($idt_cidade_e);
        $telefone_comercial = aspa($telefone_comercial_e);
        $telefone_celular = aspa($telefone_celular_e);
        $sms = aspa($sms_e);
        $email = aspa($email_e);
        $site_url = aspa($site_url_e);
        $receber_informacao = aspa($receber_informacao_e);
        //
        $sql_i = ' insert into grc_atendimento_organizacao ';
        $sql_i .= ' (  ';
        $sql_i .= " idt_atendimento, ";
        $sql_i .= " cnpj, ";
        $sql_i .= " razao_social, ";
        $sql_i .= " nome_fantasia, ";
        $sql_i .= " codigo_siacweb_e, ";
        $sql_i .= " idt_tipo_empreendimento, ";
        $sql_i .= " data_abertura, ";
        $sql_i .= " pessoas_ocupadas, ";
        $sql_i .= " logradouro_cep_e, ";
        $sql_i .= " logradouro_endereco_e, ";
        $sql_i .= " logradouro_numero_e, ";
        $sql_i .= " logradouro_bairro_e, ";
        $sql_i .= " logradouro_complemento_e, ";
        $sql_i .= " logradouro_cidade_e, ";
        $sql_i .= " logradouro_estado_e, ";
        $sql_i .= " logradouro_pais_e, ";
        $sql_i .= " idt_pais_e, ";
        $sql_i .= " idt_estado_e, ";
        $sql_i .= " idt_cidade_e, ";
        $sql_i .= " telefone_comercial_e, ";
        $sql_i .= " telefone_celular_e, ";
        $sql_i .= " email_e, ";
        $sql_i .= " sms_e, ";
        $sql_i .= " site_url, ";
        $sql_i .= " receber_informacao_e ";
        $sql_i .= '  ) values ( ';
        $sql_i .= " $idt_atendimento, ";
        $sql_i .= " $cnpj, ";
        $sql_i .= " $razao_social, ";
        $sql_i .= " $nome_fantasia, ";
        $sql_i .= " $codigo_siacweb, ";
        $sql_i .= " $idt_tipo_empreendimento, ";
        $sql_i .= " $data_abertura, ";
        $sql_i .= " $pessoas_ocupadas, ";
        $sql_i .= " $logradouro_cep, ";
        $sql_i .= " $logradouro_endereco, ";
        $sql_i .= " $logradouro_numero, ";
        $sql_i .= " $logradouro_bairro, ";
        $sql_i .= " $logradouro_complemento, ";
        $sql_i .= " $logradouro_cidade, ";
        $sql_i .= " $logradouro_estado, ";
        $sql_i .= " $logradouro_pais, ";
        $sql_i .= " $idt_pais, ";
        $sql_i .= " $idt_estado, ";
        $sql_i .= " $idt_cidade, ";
        $sql_i .= " $telefone_comercial, ";
        $sql_i .= " $telefone_celular, ";
        $sql_i .= " $email, ";
        $sql_i .= " $sms, ";
        $sql_i .= " $site_url, ";
        $sql_i .= " $receber_informacao ";

        $sql_i .= ') ';
        $result = execsql($sql_i);

        //p($sql_i);
    }
}

function ChamaInstrumentoContabiliza($instrumento) {
    $html = "";

    $vetInstrumento = Array();
    $vetInstrumento[1] = 'INFORMAÇÃO';
    $vetInstrumento[2] = 'ORIENTAÇÃO TÉCNICA';
    $vetInstrumento[3] = 'CONSULTORIA';
    $vetInstrumento[4] = 'CURSO';
    $vetInstrumento[5] = 'FEIRA';
    $vetInstrumento[6] = 'MISSÃO/CARAVANA';
    $vetInstrumento[7] = 'OFICINA';
    $vetInstrumento[8] = 'PALESTRA';
    $vetInstrumento[9] = 'RODADA DE NEGÓCIO';
    $vetInstrumento[10] = 'SEMINÁRIO';


    if ($instrumento == 1) {
        
    }

    $html .= " <style> ";
    $html .= " .instrumento_x { ";
    $html .= "    background:#2F66BB; ";
    $html .= "    color:#FFFFFF; ";
    $html .= "    border:1px solid #FFFFFF; ";
    $html .= "    width:100%; ";
    $html .= "    font-size:24px; ";
    $html .= "    text-align:center; ";
    $html .= "    height:30px; ";
    $html .= " } ";
    $html .= " </style> ";
    $html .= " <div class='instrumento_x'>";
    $html .= "   INSTRUMENTO: " . $vetInstrumento[$instrumento];
    $html .= " </div>";




    return $html;
}

function GRC_DiaSemana($data, $opcao) {
// Recebe a data no formato dd/mm/aaaa
// Opções:
// extenso1 - devolve dia = Segunda Feira
// extenso2 - devolve dia = Segunda <br> Feira
// resumo1  - devolve dia = Seg
// resumo2  - devolve dia = Segunda

    $dia = substr("$data", 0, 2);
    $mes = substr("$data", 3, 2);
    $ano = substr("$data", 6, 4);

    $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));

    IF (is_null($opcao) or $opcao == 'extenso1') {
        switch ($diasemana) {
            case"0": $diasemana = "Domingo";
                break;
            case"1": $diasemana = "Segunda Feira";
                break;
            case"2": $diasemana = "Terça Feira";
                break;
            case"3": $diasemana = "Quarta Feira";
                break;
            case"4": $diasemana = "Quinta Feira";
                break;
            case"5": $diasemana = "Sexta Feira";
                break;
            case"6": $diasemana = "Sábado";
                break;
        }
    }

    IF ($opcao == 'extenso2') {
        switch ($diasemana) {
            case"0": $diasemana = "Domingo";
                break;
            case"1": $diasemana = "Segunda<br>Feira <br>";
                break;
            case"2": $diasemana = "Terça <br> Feira <br>";
                break;
            case"3": $diasemana = "Quarta <br> Feira <br>";
                break;
            case"4": $diasemana = "Quinta <br> Feira <br>";
                break;
            case"5": $diasemana = "Sexta <br> Feira <br>";
                break;
            case"6": $diasemana = "Sábado";
                break;
        }
    }


    IF ($opcao == 'resumo1') {
        switch ($diasemana) {
            case"0": $diasemana = "Dom";
                break;
            case"1": $diasemana = "Seg";
                break;
            case"2": $diasemana = "Ter";
                break;
            case"3": $diasemana = "Qua";
                break;
            case"4": $diasemana = "Qui";
                break;
            case"5": $diasemana = "Sex";
                break;
            case"6": $diasemana = "Sáb";
                break;
        }
    }

    IF ($opcao == 'resumo2') {
        switch ($diasemana) {
            case"0": $diasemana = "Domingo";
                break;
            case"1": $diasemana = "Segunda";
                break;
            case"2": $diasemana = "Terça";
                break;
            case"3": $diasemana = "Quarta";
                break;
            case"4": $diasemana = "Quinta";
                break;
            case"5": $diasemana = "Sexta";
                break;
            case"6": $diasemana = "Sábado";
                break;
        }
    }

    return($diasemana);
}

//
// Presencial sem Agendamento..... Hora Extra
//
function GeraAtendimentoHE($idt_atendimento_agenda, $idt_consultor, $idt_ponto_atendimento, $data_inicial, $hora_inicial, $idt_instrumento, &$idt_atendimentow, $idt_evento = '', $evento_origem = '', $canal_registro = '', $origem = '') {
    //
    // Grava registro da AGENDA
    //
    $detalhe = "";
    $dia_semana = GRC_DiaSemana($data_inicial, 'resumo1');   // formato dd/mm/aaaa
    //
    $idt_consultor_agenda = $idt_consultor;
    $idt_cliente_agenda = 'null';
    $idt_especialidade_agenda = 'null';



    if ($idt_atendimento_agenda == "") {
        $data_agenda = aspa($data_inicial);
        $hora_agenda = aspa($hora_inicial);
        $origem_agenda = aspa('Hora Extra');
        $detalhe_agenda = aspa($detalhe);
        $situacao_agenda = aspa('Agendado');
        $data_confirmacao_agenda = aspa('');
        $hora_confirmacao_agenda = aspa('');
        $telefone_agenda = aspa('');
        $hora_chegada_agenda = aspa('');
        $hora_atendimento_agenda = aspa('');
        $idt_ponto_atendimento_agenda = null($idt_ponto_atendimento);
        $dia_semana_agenda = aspa($dia_semana);
        $hora_liberacao_agenda = aspa('');
        $celular_agenda = aspa('');
        $observacao_chegada_agenda = aspa('');
        $observacao_atendimento_agenda = aspa('');
        $cliente_texto_agenda = aspa('');
        $tipo_pessoa_agenda = aspa('S');

        $sql_i = ' insert into ' . db_pir_grc . 'grc_atendimento_agenda ';
        $sql_i .= ' (  ';
        $sql_i .= ' idt_consultor, ';
        $sql_i .= ' idt_instrumento, ';
        $sql_i .= ' idt_cliente, ';
        $sql_i .= ' idt_especialidade, ';
        $sql_i .= ' data, ';
        $sql_i .= ' hora, ';
        $sql_i .= ' origem, ';
        $sql_i .= ' detalhe, ';
        $sql_i .= ' situacao, ';
        $sql_i .= ' data_confirmacao, ';
        $sql_i .= ' hora_confirmacao, ';
        $sql_i .= ' telefone, ';
        $sql_i .= ' hora_chegada, ';
        $sql_i .= ' hora_atendimento, ';
        $sql_i .= ' idt_ponto_atendimento, ';
        $sql_i .= ' dia_semana, ';
        $sql_i .= ' hora_liberacao, ';
        $sql_i .= ' celular, ';
        $sql_i .= ' observacao_chegada, ';
        $sql_i .= ' observacao_atendimento, ';
        $sql_i .= ' cliente_texto, ';
        $sql_i .= ' tipo_pessoa  ';
        $sql_i .= '  ) values ( ';
        $sql_i .= " $idt_consultor_agenda, ";
        $sql_i .= " $idt_instrumento, ";
        $sql_i .= " $idt_cliente_agenda, ";
        $sql_i .= " $idt_especialidade_agenda, ";
        $sql_i .= " $data_agenda, ";
        $sql_i .= " $hora_agenda, ";
        $sql_i .= " $origem_agenda, ";
        $sql_i .= " $detalhe_agenda, ";
        $sql_i .= " $situacao_agenda, ";
        $sql_i .= " $data_confirmacao_agenda, ";
        $sql_i .= " $hora_confirmacao_agenda, ";
        $sql_i .= " $telefone_agenda, ";
        $sql_i .= " $hora_chegada_agenda, ";
        $sql_i .= " $hora_atendimento_agenda, ";
        $sql_i .= " $idt_ponto_atendimento_agenda, ";
        $sql_i .= " $dia_semana_agenda, ";
        $sql_i .= " $hora_liberacao_agenda, ";
        $sql_i .= " $celular_agenda, ";
        $sql_i .= " $observacao_chegada_agenda, ";
        $sql_i .= " $observacao_atendimento_agenda, ";
        $sql_i .= " $cliente_texto_agenda, ";
        $sql_i .= " $tipo_pessoa_agenda ";
        $sql_i .= ') ';
        $result = execsql($sql_i);
        $idt_atendimento_agenda = lastInsertId();
    } else {
        //
        // Buscar esses ados da agenda
        // guybete2017
        $data_agenda = aspa($data_inicial);
        $hora_agenda = aspa($hora_inicial);
        $origem_agenda = aspa('Hora Extra');
        $detalhe_agenda = aspa($detalhe);
        $situacao_agenda = aspa('Agendado');
        $data_confirmacao_agenda = aspa('');
        $hora_confirmacao_agenda = aspa('');
        $telefone_agenda = aspa('');
        $hora_chegada_agenda = aspa('');
        $hora_atendimento_agenda = aspa('');
        $idt_ponto_atendimento_agenda = null($idt_ponto_atendimento);
        $dia_semana_agenda = aspa($dia_semana);
        $hora_liberacao_agenda = aspa('');
        $celular_agenda = aspa('');
        $observacao_chegada_agenda = aspa('');
        $observacao_atendimento_agenda = aspa('');
        $cliente_texto_agenda = aspa('');
        $tipo_pessoa_agenda = aspa('S');
    }
    $variavel['instrumento'] = $idt_instrumento;

    //  Gera Chegada do cliente
    $variavel = Array();
    GeraChegada($idt_atendimento_agenda, $variavel);
    $protocolo = $variavel['protocolo'];
    // Gera no Painel
    //$variavel = Array();
    $variavel['protocolo'] = $protocolo;
    $variavel['idt_consultor'] = $idt_consultor;
    GeraNovoPainel($idt_atendimento_agenda, $variavel);
    //  Gera o Registro de Atendimento
    $variavel['instrumento'] = $idt_instrumento;
    $variavel['idt_evento'] = $idt_evento;
    $variavel['evento_origem'] = $evento_origem;
    $variavel['canal_registro'] = $canal_registro;
    $variavel['origem'] = $origem;
    IniciaAtendimento($idt_atendimento_agenda, $idt_cliente, $variavel);

    $idt_atendimentow = $variavel['idt_atendimento'];


    $sql_a = ' update ' . db_pir_grc . 'grc_atendimento_agenda set ';
    $sql_a .= " senha_totem  = " . aspa($variavel['senha_totemw']) . ',  ';
    $sql_a .= " senha_ordem  = " . aspa($variavel['senha_ordemw']);
    $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
    $result = execsql($sql_a);


    //p($variavel);
    //exit();
}

function FinalizarAtendimento($idt_atendimento, &$variavel) {
    $kokw = 0;

    $sql = "select  ";
    $sql .= " grc_a.idt_atendimento_agenda  ";
    $sql .= " from grc_atendimento grc_a ";
    $sql .= ' where idt = ' . null($idt_atendimento);
    $rs = execsql($sql);
    $wcodigo = '';
    ForEach ($rs->data as $row) {
        $idt_atendimento_agenda = $row['idt_atendimento_agenda'];
        $sql_a = ' update grc_atendimento_agenda set ';
        $sql_a .= " situacao          = 'Atendido'";
        $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
        $result = execsql($sql_a);
    }

    $sql_a = ' update grc_atendimento set ';
    $sql_a .= " situacao   = 'Finalizado'";
    $sql_a .= ' where idt  = ' . null($idt_atendimento);
    $result = execsql($sql_a);
    $kokw = 1;
    return $kokw;
}

function CancelaAtendimento($idt_atendimento, &$variavel) {
    $kokw = 0;

    $sql = "select  ";
    $sql .= " grc_a.idt_atendimento_agenda  ";
    $sql .= " from grc_atendimento grc_a ";
    $sql .= ' where idt = ' . null($idt_atendimento);
    $rs = execsql($sql);
    $wcodigo = '';
    ForEach ($rs->data as $row) {
        $idt_atendimento_agenda = $row['idt_atendimento_agenda'];
        $sql_a = ' update grc_atendimento_agenda set ';
        $sql_a .= " situacao          = 'Cancelado'";
        $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
        $result = execsql($sql_a);
    }

    $sql_a = ' update grc_atendimento set ';
    $sql_a .= " situacao   = 'Cancelado'";
    $sql_a .= ' where idt  = ' . null($idt_atendimento);
    $result = execsql($sql_a);
    $kokw = 1;
    return $kokw;
}

function GeraNovoPainel($idt_atendimento_agenda, &$variavel) {

    $protocolo = $variavel['protocolo'];
    $idt_consultor = $variavel['idt_consultor'];

    $sql = "select  ";
    $sql .= " grc_a.*  ";
    $sql .= " from " . db_pir_grc . "grc_atendimento_agenda grc_a ";
    $sql .= ' where idt = ' . null($idt_atendimento_agenda);
    $rs = execsql($sql);
    $wcodigo = '';
    ForEach ($rs->data as $row_aa) {
        $idt_consultor_agenda = null($row_aa['idt_consultor']);
        $idt_cliente_agenda = null($row_aa['idt_cliente']);
        $idt_especialidade_agenda = null($row_aa['idt_especialidade']);
        $data_agenda = aspa($row_aa['data']);
        $hora_agenda = aspa($row_aa['hora']);
        $origem_agenda = aspa($row_aa['origem']);
        $detalhe_agenda = aspa($row_aa['detalhe']);
        $situacao_agenda = aspa($row_aa['situacao']);
        $data_confirmacao_agenda = aspa($row_aa['data_confirmacao']);
        $hora_confirmacao_agenda = aspa($row_aa['hora_confirmacao']);
        $telefone_agenda = aspa($row_aa['telefone']);
        $hora_chegada_agenda = aspa($row_aa['hora_chegada']);
        $hora_atendimento_agenda = aspa($row_aa['hora_atendimento']);
        $idt_ponto_atendimento_agenda = null($row_aa['idt_ponto_atendimento']);
        $dia_semana_agenda = aspa($row_aa['dia_semana']);
        $hora_liberacao_agenda = aspa($row_aa['hora_liberacao']);
        $celular_agenda = aspa($row_aa['celular']);
        $observacao_chegada_agenda = aspa($row_aa['observacao_chegada']);
        $observacao_atendimento_agenda = aspa($row_aa['observacao_atendimento']);
        $cliente_texto_agenda = aspa($row_aa['cliente_texto']);

        $idt_atendimento_agenda = $row_aa['idt'];
        $idt_atendimento_box = 'null';

        $idt_ponto_atendimento_tmp = $row_aa['idt_ponto_atendimento'];

        if ($idt_ponto_atendimento_tmp == '') {
            $idt_ponto_atendimento_tmp = 0;
        }

        $idt_atendimento_painel = idtAtendimentoPainel($idt_ponto_atendimento_tmp);
        $status_painel_agenda = aspa('44');
        //$result = execsql($sql_a);
    }

    $datadiaw = (date('d/m/Y H:i:s'));
    $datadia = aspa(trata_data($datadiaw));

    $kokw = 0;
    $sql2 = 'select ';
    $sql2 .= '  grc_aap.*   ';
    $sql2 .= '  from ' . db_pir_grc . 'grc_atendimento_agenda_painel grc_aap ';
    $sql2 .= '  where grc_aap.idt_consultor = ' . null($idt_consultor_agenda);
    $sql2 .= '  and grc_aap.data = ' . aspa($data_agenda);
    $sql2 .= '  and grc_aap.hora = ' . aspa($hora_agenda);

    $rs_aap = execsql($sql2);

    if ($rs_aap->rows == 0) {
        // grava registro

        $sql_i = ' insert into ' . db_pir_grc . 'grc_atendimento_agenda_painel ';
        $sql_i .= ' (  ';
        $sql_i .= ' idt_consultor, ';
        $sql_i .= ' idt_cliente, ';
        $sql_i .= ' idt_especialidade, ';
        $sql_i .= ' idt_atendimento_agenda, ';
        $sql_i .= ' idt_atendimento_box, ';
        $sql_i .= ' idt_atendimento_painel, ';
        $sql_i .= ' data, ';
        $sql_i .= ' hora, ';
        $sql_i .= ' origem, ';
        $sql_i .= ' detalhe, ';
        $sql_i .= ' situacao, ';
        $sql_i .= ' data_confirmacao, ';
        $sql_i .= ' hora_confirmacao, ';
        $sql_i .= ' telefone, ';
        $sql_i .= ' hora_chegada, ';
        $sql_i .= ' hora_atendimento, ';
        $sql_i .= ' idt_ponto_atendimento, ';
        $sql_i .= ' dia_semana, ';
        $sql_i .= ' hora_liberacao, ';
        $sql_i .= ' celular, ';
        $sql_i .= ' observacao_chegada, ';
        $sql_i .= ' observacao_atendimento, ';
        $sql_i .= ' cliente_texto, ';
        $sql_i .= ' status_painel, ';
        $sql_i .= ' protocolo, ';
        $sql_i .= ' data_hora_chamada  ';
        $sql_i .= '  ) values ( ';
        $sql_i .= " $idt_consultor_agenda, ";
        $sql_i .= " $idt_cliente_agenda, ";
        $sql_i .= " $idt_especialidade_agenda, ";
        $sql_i .= " $idt_atendimento_agenda, ";
        $sql_i .= " $idt_atendimento_box, ";
        $sql_i .= " $idt_atendimento_painel, ";
        $sql_i .= " $data_agenda, ";
        $sql_i .= " $hora_agenda, ";
        $sql_i .= " $origem_agenda, ";
        $sql_i .= " $detalhe_agenda, ";
        $sql_i .= " $situacao_agenda, ";
        $sql_i .= " $data_confirmacao_agenda, ";
        $sql_i .= " $hora_confirmacao_agenda, ";
        $sql_i .= " $telefone_agenda, ";
        $sql_i .= " $hora_chegada_agenda, ";
        $sql_i .= " $hora_atendimento_agenda, ";
        $sql_i .= " $idt_ponto_atendimento_agenda, ";
        $sql_i .= " $dia_semana_agenda, ";
        $sql_i .= " $hora_liberacao_agenda, ";
        $sql_i .= " $celular_agenda, ";
        $sql_i .= " $observacao_chegada_agenda, ";
        $sql_i .= " $observacao_atendimento_agenda, ";
        $sql_i .= " $cliente_texto_agenda, ";
        $sql_i .= " $status_painel_agenda, ";
        $sql_i .= " $protocolo, ";
        $sql_i .= " $datadia ";
        $sql_i .= ') ';
        $result = execsql($sql_i);
    }
}

function GeraChegada($idt_atendimento_agenda, &$variavel) {

    $sql = "select  ";
    $sql .= " grc_a.*  ";
    $sql .= " from " . db_pir_grc . "grc_atendimento_agenda grc_a ";
    $sql .= ' where idt = ' . null($idt_atendimento_agenda);
    $rs = execsql($sql);
    $wcodigo = '';
    ForEach ($rs->data as $row_aa) {
        $idt_consultor_agenda = null($row_aa['idt_consultor']);
        $idt_cliente_agenda = null($row_aa['idt_cliente']);
        $idt_especialidade_agenda = null($row_aa['idt_especialidade']);
        $data_agenda = aspa($row_aa['data']);
        $hora_agenda = aspa($row_aa['hora']);
        $origem_agenda = aspa($row_aa['origem']);
        $detalhe_agenda = aspa($row_aa['detalhe']);
        $situacao_agenda = aspa($row_aa['situacao']);
        $data_confirmacao_agenda = aspa($row_aa['data_confirmacao']);
        $hora_confirmacao_agenda = aspa($row_aa['hora_confirmacao']);
        $telefone_agenda = aspa($row_aa['telefone']);
        $hora_chegada_agenda = aspa($row_aa['hora_chegada']);
        $hora_atendimento_agenda = aspa($row_aa['hora_atendimento']);
        $idt_ponto_atendimento_agenda = null($row_aa['idt_ponto_atendimento']);
        $dia_semana_agenda = aspa($row_aa['dia_semana']);
        $hora_liberacao_agenda = aspa($row_aa['hora_liberacao']);
        $celular_agenda = aspa($row_aa['celular']);
        $observacao_chegada_agenda = aspa($row_aa['observacao_chegada']);
        $observacao_atendimento_agenda = aspa($row_aa['observacao_atendimento']);
        $cliente_texto_agenda = aspa($row_aa['cliente_texto']);

        $idt_atendimento_agenda = $row_aa['idt'];
        $idt_atendimento_box = 'null';

        $idt_ponto_atendimento_tmp = $row_aa['idt_ponto_atendimento'];

        if ($idt_ponto_atendimento_tmp == '') {
            $idt_ponto_atendimento_tmp = 0;
        }

        $idt_atendimento_painel = idtAtendimentoPainel($idt_ponto_atendimento_tmp);
        $status_painel_agenda = aspa('00');
        //$result = execsql($sql_a);
    }

//  $datadia = trata_data(date('d/m/Y H:i:s'));

    $tabela = db_pir_grc . 'grc_atendimento_avulso';
    $Campo = 'protocolo';
    $tam = 4;
    $codigow = geraAutoNum(db_pir_grc, 'grc_atendimento_avulso_' . $Campo, $tam);
    $codigo = 'CH' . $codigow;


    $variavel['senha_totemw'] = $codigo;
    $variavel['senha_ordemw'] = $codigow;
    //$variavel['protocolo']    = $codigo;


    $protocolo = aspa($codigo);
    $data_atendimento = ($data_agenda);
    $cpf = aspa('');
    if ($cliente_texto_agenda == "''" or $cliente_texto_agenda == "NULL" or $cliente_texto_agenda == "") {
        $cliente_texto_agenda = $protocolo;
    }
    $nome = ($cliente_texto_agenda);
    $telefone = ($telefone_agenda);
    $celular = ($celular_agenda);
    $email = aspa('');
    $hora_marcada_extra = ($hora_agenda);
    $mensagem = aspa('');
    $cnpj = aspa('');
    $nome_empresa = aspa('');
    $assunto = aspa('');
    $tipo_pessoa = aspa('S');
    $idt_ponto_atendimento = ($idt_ponto_atendimento_agenda);


    $kokw = 0;
    $sql2 = 'select ';
    $sql2 .= '  grc_aa.*   ';
    $sql2 .= '  from ' . db_pir_grc . 'grc_atendimento_avulso grc_aa ';
    $sql2 .= '  where grc_aa.data_atendimento = ' . $data_atendimento;
    $sql2 .= '  and   grc_aa.nome = ' . $nome;

    $rs_aap = execsql($sql2);

    if ($rs_aap->rows == 0) {
        // grava registro


        $sql_i = ' insert into ' . db_pir_grc . 'grc_atendimento_avulso ';
        $sql_i .= ' (  ';
        $sql_i .= ' protocolo, ';
        $sql_i .= ' data_atendimento, ';
        $sql_i .= ' cpf, ';
        $sql_i .= ' nome, ';
        $sql_i .= ' telefone, ';
        $sql_i .= ' celular, ';
        $sql_i .= ' email, ';
        $sql_i .= ' hora_marcada_extra, ';
        $sql_i .= ' mensagem, ';
        $sql_i .= ' cnpj, ';
        $sql_i .= ' nome_empresa, ';
        $sql_i .= ' assunto, ';
        $sql_i .= ' tipo_pessoa, ';
        $sql_i .= ' idt_ponto_atendimento ';
        $sql_i .= '  ) values ( ';
        $sql_i .= " $protocolo, ";
        $sql_i .= " $data_atendimento, ";
        $sql_i .= " $cpf, ";
        $sql_i .= " $nome, ";
        $sql_i .= " $telefone, ";
        $sql_i .= " $celular, ";
        $sql_i .= " $email, ";
        $sql_i .= " $hora_marcada_extra, ";
        $sql_i .= " $mensagem, ";
        $sql_i .= " $cnpj, ";
        $sql_i .= " $nome_empresa, ";
        $sql_i .= " $assunto, ";
        $sql_i .= " $tipo_pessoa, ";
        $sql_i .= " $idt_ponto_atendimento ";
        $sql_i .= ') ';
        $result = execsql($sql_i);
        $variavel['protocolo'] = $protocolo;
    }
}

//
// Função de Refresh na tela do Painel
//
function RefreshPainelClientes($idt_atendimento_painel, &$variavel) {
    $vet_painel = Array();

    $vetMes = Array(
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

    $kokw = 0;
    $html = "";
    //
    // Topo do Painel
    //
    $idt_ponto_atendimento = 0;
    $kokw = 0;
    $sql2 = 'select ';
    $sql2 .= '  grc_ap.idt       as grc_ap_idt,    ';
    $sql2 .= '  grc_ap.idt_ponto_atendimento asgrc_ap_idt_ponto_atendimento, ';
    $sql2 .= '  grc_ap.descricao as grc_ap_descricao    ';
    $sql2 .= '  from grc_atendimento_painel grc_ap ';
    $sql2 .= '   where grc_ap.idt      = ' . null($idt_atendimento_painel);


    $rs_aap = execsql($sql2);
    if ($rs_aap->rows == 0) {
        
    } else {
        ForEach ($rs_aap->data as $row) {
            $idt_ponto_atendimento = $row['asgrc_ap_idt_ponto_atendimento'];
            $grc_ap_descricao = $row['grc_ap_descricao'];
        }
    }
    $kokw = 0;
    $sql2 = 'select ';
    $sql2 .= '  sca_os.idt       as sca_os_idt,    ';
    $sql2 .= '  sca_os.descricao as sca_os_descricao    ';
    $sql2 .= '  from ' . db_pir . 'sca_organizacao_secao sca_os ';
    $sql2 .= '   where sca_os.idt = ' . null($idt_ponto_atendimento);
    $rs_aap = execsql($sql2);
    $sca_os_descricao = 'N/A';
    if ($rs_aap->rows == 0) {
        
    } else {
        ForEach ($rs_aap->data as $row) {
            $sca_os_descricao = $row['sca_os_descricao'];
        }
    }
    $descricao_ponto_atendimento = $sca_os_descricao;
    $descricao_painel = $grc_ap_descricao;
    $municipio = "Salvador";
    $html .= '<div id="topo_painel"> ';
    $html .= '<table border="0" cellpadding="0" width="100%" cellspacing="0" class="">';
    $html .= '    <tr> ';
    $html .= '<td  style="">';
    $pathw = 'imagens/logo_sebrae_painel.jpg';
    $html .= '<img style="" src="' . $pathw . '"   border="0" />';
    $html .= '</td>';
    $html .= "<td class='titulo_painel' style=''>";
    $vetMsg = Array();
    $vetMsg[1] = "FIQUE ATENTO PARA A SUA CHAMADA ATRAVÉS DO PAINEL.<br />EXISTINDO DÚVIDAS, PROCURE UM DOS NOSSOS ATENDENTES.";
    $vetMsg[2] = "outra mensagem.";
    $ordem_msg = $_SESSION[CS]['g_ordem_msg_painel'];
    $ordem_msg = $ordem_msg + 1;
    if ($ordem_msg > 2) {
        $ordem_msg = 1;
    }
    $_SESSION[CS]['g_ordem_msg_painel'] = $ordem_msg;
    $mensagem_topo = $vetMsg[$ordem_msg];
    //$html .= "<div  id='titulo_painel'  style=''>";
    $html .= $mensagem_topo;
    $html .= '</td>';
    $html .= '<td  width="100" style="font-size: 24px; padding:5px;">';
    $html .= '<div id="hora_m">';
    $html .= date('H:i:s');
    $html .= '</div>';
    $html .= '</td>';
    $html .= '    </tr> ';
    $html .= ' </table> ';


    $html .= ' <div id="barra_topo_m"> ';
    $html .= ' <div id="retornar" style="border-right:1px solid #FFFFFF;"> ';
    $html .= '       <a href="javascript:top.close();" title="Clique aqui retornar"><img alt="" src="imagens/sair.png" width="16" height="16" style="padding-right:5px;"></a>';
    $html .= ' </div>  ';
    $html .= "<div id='ele_topo'>$descricao_ponto_atendimento</div> ";
    $html .= "<div id='ele_topo'>$descricao_painel   </div> ";
    $html .= '<div id="resto_m">';
    $html .= "$municipio, " . date("d \d\e ") . $vetMes[date("n")] . date(" \d\e Y");
    $html .= '</div>';
    $html .= '</div>';
    //
    // clientes chamados
    //
    $datadiaw = (date('d/m/Y'));

    $sql2 = 'select ';
    $sql2 .= '  grc_aap.cliente_texto  as grc_aap_cliente_texto,    ';
    $sql2 .= '  grc_aap.protocolo  as grc_aap_protocolo,    ';
    $sql2 .= '  gec_e.descricao  as gec_e_descricao,    ';
    $sql2 .= '  grc_ab.descricao as grc_ab_descricao    ';
    $sql2 .= '  from grc_atendimento_agenda_painel grc_aap ';
    $sql2 .= '  inner join grc_atendimento_painel grc_ap on grc_ap.idt = grc_aap.idt_atendimento_painel ';
    $sql2 .= '  left  join ' . db_pir_gec . 'gec_entidade gec_e on gec_e.idt = grc_aap.idt_cliente ';
    $sql2 .= '  left  join grc_atendimento_box grc_ab on grc_ab.idt = grc_aap.idt_atendimento_box ';
    $sql2 .= '   where grc_ap.idt  = ' . null($idt_atendimento_painel);
    $sql2 .= '     and grc_aap.status_painel    = ' . aspa('20');
    $sql2 .= '     and grc_aap.data = ' . aspa($datadiaw);
    $rs_aap = execsql($sql2);
    $num = 0;
    if ($rs_aap->rows == 0) {
        //$html .=  " sem registros <br />";
    } else {
        ForEach ($rs_aap->data as $row) {
            $num = $num + 1;
            $protocolo = $row['grc_aap_protocolo'];
            $nome_cliente = $row['gec_e_descricao'];
            $cliente_texto = $row['grc_aap_cliente_texto'];
            $nome_box = $row['grc_ab_descricao'];
            $vet_painel[$num]['protocolo'] = $protocolo;
            $vet_painel[$num]['nome'] = $nome_cliente;
            $vet_painel[$num]['cliente_texto'] = $cliente_texto;
            $vet_painel[$num]['nome_box'] = $nome_box;
        }
    }
    $ordem_painel = $_SESSION[CS]['g_ordem_painel'];
    $ordem_painel = $ordem_painel + 1;
    if ($ordem_painel > $num) {
        $ordem_painel = 1;
    }
    $_SESSION[CS]['g_ordem_painel'] = $ordem_painel;
    $Vet = $vet_painel[$ordem_painel];
    $protocolo = $Vet['protocolo'];
    $nome_cliente = $Vet['nome'];
    $cliente_texto = $Vet['cliente_texto'];
    $nome_box = $Vet['nome_box'];
//  if ($nome_cliente=='')
    if ($cliente_texto == '') {
        $nome_cliente = 'SENHA: ' . $protocolo;
    } else {
        $nome_cliente = $cliente_texto;
    }
    $local_atendimento = "DIRIJÁ-SE PARA: " . $nome_box;
    $html .= "<table class='chamado_table' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    $html .= "<tr class='chamado_tr ' style='' >  ";
    $html .= "   <td id='box_atende' class='chamado_box' style='' >$nome_cliente</td> ";
    $html .= "</tr>";
    $html .= "<tr class='chamado_tr ' style='' >  ";
    $html .= "   <td id='esp_atende' class='chamado_esp' style='' >$local_atendimento</td> ";
    $html .= "</tr>";

    $html .= "</table>";
    //
    $html .= "<table class='chamado_table' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    ForEach ($vet_painel as $num => $Vet) {
        $protocolo = $Vet['protocolo'];
        $nome_cliente = $Vet['nome'];
        $cliente_texto = $Vet['cliente_texto'];
        $nome_box = $Vet['nome_box'];
        $ativo = '';
//      if ($nome_cliente=='')
        if ($cliente_texto == '') {
            $nome_cliente = 'SENHA: ' . $protocolo;
        } else {
            $nome_cliente = $cliente_texto;
        }

        if ($num == 1) {
            $ativo .= " border-top:1px solid #000000; ";
        }

        if ($ordem_painel == $num) {
            $ativo .= " background:#0080C0; color:#FFFFFF; ";
        }
        $html .= "<tr class='chamado_l_tr' num='{$num}'  style='' >  ";
        $html .= "   <td id='box_atende_l_{$num}' num='{$num}' class='chamado_box_l_td' style='{$ativo}' >$nome_cliente</td> ";
        //$html .=  " <td id='esp_atende_l_{$num}' num='{$num}' class='chamado_esp_l_td' style='{$ativo}' >$protocolo</td> ";
        $html .= "   <td id='esp_atende_l_{$num}' num='{$num}' class='chamado_esp_l_td' style='{$ativo}' >$nome_box</td> ";
        $html .= "</tr>";
    }
    $html .= "</table>";

    $variavel['html'] = $html;
}

function ConsisteHoras($acao, $idt, $idt_usuario, $dia, $hora_inicial, $hora_final, &$variavel) {
    $kokw = 0;
    $variavel['ret0'] = 1;
    $variavel['ret1'] = 'Erro Geral';


    $sql_aa = ' select * from grc_atendimento_usuario_disponibilidade ';
    $sql_aa .= ' where  idt_usuario = ' . null($idt_usuario);
    $sql_aa .= '   and  dia          = ' . aspa($dia);
    $sql_aa .= '   and  hora_inicial = ' . aspa($hora_inicial);
    if ($acao == 'alt') {
        $sql_aa .= '   and  idt <>  ' . null($idt);
    }
    $sql_aa .= ' order by hora_inicial ';
    $result = execsql($sql_aa);

//  echo($sql_aa);
//  exit;



    if ($result->rows != 0) {

        echo('aqui 1');
        exit;


        $retorno = 0;
        $mensagem = 'Registro já existente';

        $variavel['ret0'] = $retorno;
        $variavel['ret1'] = $mensagem;
        return 2;
    } else {

        echo('aqui 2');
        exit;

        $sql_aa = ' select * from grc_atendimento_usuario_disponibilidade ';
        $sql_aa .= ' where  idt_usuario   = ' . null($idt_usuario);
        $sql_aa .= '   and  dia           = ' . aspa($dia);
        $sql_aa .= '   and  (hora_inicial <= ' . aspa($hora_inicial);
        $sql_aa .= '   and  hora_final   >= ' . aspa($hora_inicial);

        $sql_aa .= ')   or  (hora_inicial <= ' . aspa($hora_final);
        $sql_aa .= '   and  hora_final   >= ' . aspa($hora_final);
        $sql_aa .= ')';

        if ($acao == 'alt') {
            $sql_aa .= '   and  idt <>  ' . null($idt);
        }
        $sql_aa .= ' order by hora_inicial ';
        $result = execsql($sql_aa);

        if ($result->rows != 0) {
            $retorno = 0;
            $mensagem = 'Horário coincidente com existente';

            $variavel['ret0'] = $retorno;
            $variavel['ret1'] = $mensagem;
            return 2;
        }
    }

    echo('aqui 3');
    exit;

    $kokw = 1;
    return $kokw;
}

//
// Função de Refresh na tela do Painel - Modelo sebrae
//
function RefreshPainelClientes_sebrae($idt_atendimento_painel, &$variavel) {
    $vet_painel = Array();

    $vetMes = Array(
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

    $corpainel = "#2F66B8";
    // $corfundopainel="#ECF0F1";
    $corfundopainel = "#FFFFFF";

    $kokw = 0;
    $html = "";
    //
    // Topo do Painel
    //
    $idt_ponto_atendimento = 0;
    $kokw = 0;
    $sql2 = 'select ';
    $sql2 .= '  grc_ap.idt       as grc_ap_idt,    ';
    $sql2 .= '  grc_ap.idt_ponto_atendimento asgrc_ap_idt_ponto_atendimento, ';
    $sql2 .= '  grc_ap.descricao as grc_ap_descricao    ';
    $sql2 .= '  from grc_atendimento_painel grc_ap ';
    $sql2 .= '   where grc_ap.idt = ' . null($idt_atendimento_painel);
    $rs_aap = execsql($sql2);
    if ($rs_aap->rows == 0) {
        
    } else {
        ForEach ($rs_aap->data as $row) {
            $idt_ponto_atendimento = $row['asgrc_ap_idt_ponto_atendimento'];
            $grc_ap_descricao = $row['grc_ap_descricao'];
        }
    }
    $kokw = 0;
    $sql2 = 'select ';
    $sql2 .= '  sca_os.idt       as sca_os_idt,    ';
    $sql2 .= '  sca_os.descricao as sca_os_descricao    ';
    $sql2 .= '  from ' . db_pir . 'sca_organizacao_secao sca_os ';
    $sql2 .= '   where sca_os.idt = ' . null($idt_ponto_atendimento);
    $rs_aap = execsql($sql2);
    $sca_os_descricao = 'N/A';
    if ($rs_aap->rows == 0) {
        
    } else {
        ForEach ($rs_aap->data as $row) {
            $sca_os_descricao = $row['sca_os_descricao'];
        }
    }
    $descricao_ponto_atendimento = $sca_os_descricao;
    $descricao_painel = $grc_ap_descricao;




    $municipio = "Salvador";

//    $corbordas  = "#2F66B8";
    $html .= "<div id='topo_painel_p' style='' > ";


    $html .= '<table border="0" cellpadding="0" width="100%" cellspacing="0" class="">';
    $html .= '    <tr> ';
    $html .= '<td  style="width:10%">';

    $pathw = 'imagens/logo_painel.png';

    $html .= '<img style="" src="' . $pathw . '"   border="0" />';
    $html .= '</td>';

    $html .= "<td class='titulo_painel_p' style=''>";
    $vetMsg = Array();
    $vetMsg[1] = "PAINEL DE CHAMADO";
    $ordem_msg = 1;
    $_SESSION[CS]['g_ordem_msg_painel'] = $ordem_msg;
    $mensagem_topo = $vetMsg[$ordem_msg];
    $html .= $mensagem_topo;
    $html .= '</td>';

    $html .= "<td  style='width:35%' >";

    $html .= "<div id='ele_topo_p'>$descricao_ponto_atendimento</div> ";
    $html .= '<div id="data_m_p">';
    $html .= date('d/m/Y');
    $html .= '</div>';
    $html .= '<div id="hora_m_p">';
    // $html .= date('H:i:s');
    $html .= date('H:i');
    $html .= '</div>';

    $html .= '</td>';


    $html .= '    </tr> ';
    $html .= ' </table> ';

    // quatro últimos chamados
    $vetQuatroultimos = Array();
    $sql2 = 'select ';
    $sql2 .= '  grc_aap.cliente_texto  as grc_aap_cliente_texto,    ';
    $sql2 .= '  grc_aap.protocolo  as grc_aap_protocolo,    ';
    $sql2 .= '  gec_e.descricao  as gec_e_descricao,    ';
    $sql2 .= '  grc_ab.descricao as grc_ab_descricao    ';
    $sql2 .= '  from grc_atendimento_agenda_painel grc_aap ';
    $sql2 .= '  inner join grc_atendimento_painel grc_ap on grc_ap.idt = grc_aap.idt_atendimento_painel ';
    $sql2 .= '  left  join ' . db_pir_gec . 'gec_entidade gec_e on gec_e.idt = grc_aap.idt_cliente ';
    $sql2 .= '  left  join grc_atendimento_box grc_ab on grc_ab.idt = grc_aap.idt_atendimento_box ';
    $sql2 .= '   where grc_ap.idt  = ' . null($idt_atendimento_painel);
    $sql2 .= '     and (grc_aap.status_painel     = ' . aspa('99') . ' or grc_aap.status_painel = ' . aspa('80') . ' ) ';
    $sql2 .= '     and grc_aap.data               = ' . aspa(date('Y-m-d'));
    $sql2 .= '     order by data_hora_atendimento desc  limit 4 ';
    $rs_aap = execsql($sql2);
    $num = 0;
    $vetQuatroultimos[1] = "";
    $vetQuatroultimos[2] = "";
    $vetQuatroultimos[3] = "";
    $vetQuatroultimos[4] = "";
    if ($rs_aap->rows == 0) {
        //$html .=  " sem registros <br />";
    } else {
        ForEach ($rs_aap->data as $row) {
            $protocolo = $row['grc_aap_protocolo'];
            $nome_cliente = $row['gec_e_descricao'];
            $num = $num + 1;
            $vetQuatroultimos[$num] = $protocolo;
        }
    }
    //
    // clientes chamados
    //
    $sql2 = 'select ';
    $sql2 .= '  grc_aap.cliente_texto  as grc_aap_cliente_texto,    ';
    $sql2 .= '  grc_aap.protocolo  as grc_aap_protocolo,    ';
    $sql2 .= '  gec_e.descricao  as gec_e_descricao,    ';
    $sql2 .= '  grc_ab.descricao as grc_ab_descricao    ';
    $sql2 .= '  from grc_atendimento_agenda_painel grc_aap ';
    $sql2 .= '  inner join grc_atendimento_painel grc_ap on grc_ap.idt = grc_aap.idt_atendimento_painel ';
    $sql2 .= '  left  join ' . db_pir_gec . 'gec_entidade gec_e on gec_e.idt = grc_aap.idt_cliente ';
    $sql2 .= '  left  join grc_atendimento_box grc_ab on grc_ab.idt = grc_aap.idt_atendimento_box ';
    $sql2 .= '   where grc_ap.idt  = ' . null($idt_atendimento_painel);
    $sql2 .= '     and grc_aap.data             = ' . aspa(date('Y-m-d'));
    $sql2 .= '     and grc_aap.status_painel    = ' . aspa('20');
    $rs_aap = execsql($sql2);
    $num = 0;
    if ($rs_aap->rows == 0) {
        //$html .=  " sem registros <br />";
    } else {
        ForEach ($rs_aap->data as $row) {
            $num = $num + 1;
            $protocolo = $row['grc_aap_protocolo'];
            $nome_cliente = $row['gec_e_descricao'];
            $cliente_texto = $row['grc_aap_cliente_texto'];
            $nome_box = $row['grc_ab_descricao'];
            $vet_painel[$num]['protocolo'] = $protocolo;
            $vet_painel[$num]['nome'] = $nome_cliente;
            $vet_painel[$num]['cliente_texto'] = $cliente_texto;
            $vet_painel[$num]['nome_box'] = $nome_box;
        }
    }
    $ordem_painel = $_SESSION[CS]['g_ordem_painel'];
    $ordem_painel = $ordem_painel + 1;
    if ($ordem_painel > $num) {
        $ordem_painel = 1;
    }
    $_SESSION[CS]['g_ordem_painel'] = $ordem_painel;
    $Vet = $vet_painel[$ordem_painel];
    $protocolo = $Vet['protocolo'];
    $variavel['senha_atual'] = $protocolo;
    $nome_cliente = $Vet['nome'];
    $cliente_texto = $Vet['cliente_texto'];
    $nome_box = $Vet['nome_box'];
//  if ($nome_cliente=='')
    if ($cliente_texto == '') {
        $nome_cliente = 'SENHA: ' . $protocolo;
    } else {
        $nome_cliente = $cliente_texto;
    }

    $letrasw = substr($protocolo, 0, 2);
    $numerow = substr($protocolo, 2, 5);

    $numerow = TiraZeroEsq($numerow);
    $protocolow = $letrasw . $numerow;

    if ($letrasw == '') {
        $protocolow = '&nbsp;';
    }


    if ($letrasw == 'EP') {
        $protocolow = $protocolow . "<br /><sapan style='font-size:0.5em; color:#FF0000;'>PREFERENCIAL</sapan>";
    }

    $local_atendimento = $nome_box;
    $html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    $html .= "<tr  style='' >  ";
    $html .= "   <td class='atende_sc' colspan='2'  style='' >Senha</td> ";
    $html .= "   <td class='atende_gc' colspan='2'   style='' >Guichê</td> ";
    $html .= "</tr>";
    $html .= "<tr  style='' >  ";
    $html .= "   <td class='atende_sl' colspan='2'  style='border-right:10px solid {$corpainel};' >$protocolow</td> ";
    $html .= "   <td class='atende_gl' colspan='2'  style='' >&nbsp;$local_atendimento</td> ";
    $html .= "</tr>";
    //    $html .=  "</table>";
    //
    // últimos chamados
    //$html .=  "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    $html .= "<tr  style='' >  ";
    $html .= "   <td class='atende_sc' colspan='4'  style='' >Últimos Chamados</td> ";
    $html .= "</tr>";
    $html .= "<tr  style='' >  ";

    $ult1 = $vetQuatroultimos[1];
    $ult2 = $vetQuatroultimos[2];
    $ult3 = $vetQuatroultimos[3];
    $ult4 = $vetQuatroultimos[4];

    $letrasw = substr($ult1, 0, 2);
    $numerow = substr($ult1, 2, 5);
    $numerow = TiraZeroEsq($numerow);
    $ult1 = $letrasw . $numerow;
    if ($letrasw == '') {
        $ult1 = '&nbsp;';
    } else {
        if ($letrasw == 'EP') {
            $ult1 = $ult1 . "<br /><sapan style='font-size:0.4em; color:#FF0000;'>PREFERENCIAL</sapan>";
        } else {
            $ult1 = $ult1 . "<br /><sapan style='font-size:0.4em; color:#FF0000;'>&nbsp;</sapan>";
        }
    }

    $letrasw = substr($ult2, 0, 2);
    $numerow = substr($ult2, 2, 5);
    $numerow = TiraZeroEsq($numerow);
    $ult2 = $letrasw . $numerow;
    if ($letrasw == '') {
        $ult2 = '&nbsp;';
    } else {
        if ($letrasw == 'EP') {
            $ult2 = $ult2 . "<br /><sapan style='font-size:0.4em; color:#FF0000;'>PREFERENCIAL</sapan>";
        } else {
            $ult2 = $ult2 . "<br /><sapan style='font-size:0.4em; color:#FF0000;'>&nbsp;</sapan>";
        }
    }

    $letrasw = substr($ult3, 0, 2);
    $numerow = substr($ult3, 2, 5);
    $numerow = TiraZeroEsq($numerow);
    $ult3 = $letrasw . $numerow;
    if ($letrasw == '') {
        $ult3 = '&nbsp;';
    } else {
        if ($letrasw == 'EP') {
            $ult3 = $ult3 . "<br /><sapan style='font-size:0.4em; color:#FF0000;'>PREFERENCIAL</sapan>";
        } else {
            $ult3 = $ult3 . "<br /><sapan style='font-size:0.4em; color:#FF0000;'>&nbsp;</sapan>";
        }
    }

    $letrasw = substr($ult4, 0, 2);
    $numerow = substr($ult4, 2, 5);
    $numerow = TiraZeroEsq($numerow);
    $ult4 = $letrasw . $numerow;
    if ($letrasw == '') {
        $ult4 = '&nbsp;';
    } else {
        if ($letrasw == 'EP') {
            $ult4 = $ult4 . "<br /><sapan style='font-size:0.4em; color:#FF0000;'>PREFERENCIAL</sapan>";
        } else {
            $ult4 = $ult4 . "<br /><sapan style='font-size:0.4em; color:#FF0000;'>&nbsp;</sapan>";
        }
    }
    $html .= "   <td class='atende_ul'  style='width:25%; border-right:10px solid {$corpainel};' >{$ult1}</td> ";
    $html .= "   <td class='atende_ul'  style='width:25%; border-right:10px solid {$corpainel};' >{$ult2}</td> ";
    $html .= "   <td class='atende_ul'  style='width:25%; border-right:10px solid {$corpainel};' >{$ult3}</td> ";
    $html .= "   <td class='atende_ul'  style='width:24%; ' >{$ult4}</td> ";
    $html .= "</tr>";
    $html .= "</table>";
    /*
      $html .=  "<table class='chamado_table' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
      ForEach ($vet_painel as $num => $Vet) {
      $protocolo    = $Vet['protocolo'];
      $nome_cliente = $Vet['nome'];
      $cliente_texto = $Vet['cliente_texto'];
      $nome_box     = $Vet['nome_box'];
      $ativo = '';
      //      if ($nome_cliente=='')
      if ($cliente_texto == '')
      {
      $nome_cliente='SENHA: '.$protocolo;
      }
      else
      {
      $nome_cliente=$cliente_texto;
      }

      if ($num==1)
      {
      $ativo .= " border-top:1px solid #000000; ";
      }

      if ($ordem_painel==$num)
      {
      $ativo .= " background:#0080C0; color:#FFFFFF; ";
      }
      $html .=  "<tr class='chamado_l_tr' num='{$num}'  style='' >  ";
      $html .=  "   <td id='box_atende_l_{$num}' num='{$num}' class='chamado_box_l_td' style='{$ativo}' >$nome_cliente</td> ";
      //$html .=  " <td id='esp_atende_l_{$num}' num='{$num}' class='chamado_esp_l_td' style='{$ativo}' >$protocolo</td> ";
      $html .=  "   <td id='esp_atende_l_{$num}' num='{$num}' class='chamado_esp_l_td' style='{$ativo}' >$nome_box</td> ";
      $html .=  "</tr>";

      }
      $html .=  "</table>";
     */


    $variavel['html'] = $html;
}

function PainelBordoTela(&$variavel) {

    /*
      $vetEstatistica=Array();
      CriaDimensoes($vetEstatistica);

      $vetPontoAtendimento     = $vetEstatistica[$idt_ponto_atendimento];
      $vetPontoAtendimentoData = $vetPontoAtendimento['data'];
      p($vetPontoAtendimentoData);

      p($vetEstatistica);

      exit();
     */
    $opcao = $variavel['opcao'];
    $html = '';
    $vet_painel = Array();
    $vetMes = Array(
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
    $corpainel = "#2F66B8";
    $corfundopainel = "#FFFFFF";
    $html .= "<style>";
    $html .= "      .painel_bordo_1 { ";
    $html .= "      text-align:left;  ";
    $html .= "      background:#FFFFFF; ";
    $html .= "      color:#000000;  ";
    $html .= "      width:100%;     ";
    $html .= "      font-size:12px; ";
    $html .= "      float:left;    ";
    $html .= "  }  ";

    $html .= "  .q1 { ";
    $html .= "      width:31%;  ";
    $html .= "      background: #FFFFFF; ";
    $html .= "      height:210px; ";
    $html .= "      xborder:1px solid red; ";

    $html .= "      xborder-right:2px solid #F1F1F1; ";
    $html .= "  }  ";
    $html .= "  .q2 { ";
    $html .= "      width:31%; ";
    $html .= "      background: #FFFFFF; ";
    $html .= "      height:210px;  ";
    $html .= "      xborder:1px solid red; ";
    $html .= "      xborder-right:2px solid #F1F1F1; ";
    $html .= "  }    ";
    $html .= "  .q3 {  ";
    $html .= "      width:31%; ";
    $html .= "      background: #FFFFFF; ";
    $html .= "      height:210px; ";
    $html .= "      xborder:1px solid red; ";

    $html .= "  }  ";
    $html .= "  .bordo_tb { ";
    $html .= "          background: #0000ff; ";
    $html .= "      } ";

    $html .= "  .cab_painel1 { ";
    $html .= "      width:31%; ";
    $html .= "      background:#0080C0; ";
    $html .= "      color: #FFFFFF; ";
    $html .= "      font-size:14px; ";
    $html .= "      height:25px;";

    $html .= "      text-align:center; ";
    $html .= "      } ";

    $html .= "  .cabec_1xx { ";
    $html .= "      xbackground: #0080C0; ";
    $html .= "      xcolor: #FFFFFF; ";
    $html .= "      xwidth:100%; ";
    $html .= "      xdisplay:block; ";
    $html .= "      } ";

    $html .= "</style>";

    $data_hoje = trata_data(date('d/m/Y'));
    $data_hojew = aspa($data_hoje);

    $unidade1 = $_SESSION[CS]['gdesc_idt_unidade_regional'];
    $unidade2 = $_SESSION[CS]['gdesc_idt_unidade_regional'];
    $unidade3 = $_SESSION[CS]['gdesc_idt_unidade_regional'];

    $html .= "<div class='painel_bordo_1' >";
    $html .= "<table class='bordo_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    $html .= "<tr  style='' >  ";
    $escolha1 = " onclick = 'return EscolhaPainel(1);' ";
    $escolha2 = " onclick = 'return EscolhaPainel(2);' ";
    $escolha3 = " onclick = 'return EscolhaPainel(3);' ";
    $html .= " <td $escolha1 id='cabec_1'  class='cab_painel1' style='border-right:1px solid #FFFFFF;'>";
    $html .= " {$unidade1} ";
    $html .= " </td>";
    $html .= " <td $escolha2 id='cabec_2'  class='cab_painel1' style='border-right:1px solid #FFFFFF;'>";
    $html .= " {$unidade2} ";
    $html .= " </td>";
    $html .= " <td $escolha3 id='cabec_3'  class='cab_painel1' style=''>";
    $html .= " {$unidade3} ";
    $html .= " </td>";
    /*
      //   $html .=   "&nbsp;";
      $html .=   "</tr>";
      $html .=   "<tr  style='' >  ";
      $html .=   " <td id='cabec_1' colspan='3' class='cab_1' style=''>";
      $html .=   " Ponto de Atendimento Mecês";
      $html .=   " </td>";
      $html .=   "</tr>";
     */
    $html .= "<tr  style='' >  ";
    $html .= " <td id='container1' class='q1' style=''>";
    $html .= " </td>";
    $html .= " <td  id='container2' class='q2' style=''>";
    $html .= " </td>";
    $html .= " <td id='container3' class='q3' style=''>";
    $html .= " </td>";
    $html .= "</tr>";
    $html .= "</table>";
    $html .= "</div>";
    grafico_x($variavel);
    $variavel['html'] = $html;
}

function grafico_x(&$variavel) {
    $script = '';
    $script .= '<script type="text/javascript">';
    $script .= 'var chart;    ';
    //$script .= '$(document).ready(function() { ';
    $script .= 'function grafico1() { ';

    $script .= '    chart = new Highcharts.Chart({ ';
    $script .= '        chart: { ';
    $script .= "            renderTo: 'container1', ";
    $script .= "            defaultSeriesType: 'line',  ";
    $script .= '            marginRight: 130, ';
    $script .= '            marginBottom: 25 ';
    $script .= '        },  ';
    $script .= '        title: { ';
    $script .= "            text: 'Monthly Average Temperature', ";
    $script .= '            x: -20 ';
    $script .= '        },  ';
    $script .= '        subtitle: { ';
    $script .= "            text: 'Source: WorldClimate.com', ";
    $script .= '            x: -20 ';
    $script .= '        }, ';
    $script .= "        xAxis: { ";
    $script .= "            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', ";
    $script .= "                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] ";
    $script .= '        },  ';
    $script .= '        yAxis: { ';
    $script .= '            title: { ';
    $script .= "                text: 'Temperature (°C)'  ";
    $script .= '            },  ';
    $script .= '            plotLines: [{  ';
    $script .= '                    value: 0, ';
    $script .= '                    width: 1, ';
    $script .= "                    color: '#808080' ";
    $script .= '                }] ';
    $script .= '        },   ';
    $script .= '        tooltip: { ';
    $script .= '            formatter: function() {  ';
    $script .= "                return '<b>'+ this.series.name +'</b><br/>'+  ";
    $script .= "                    this.x +': '+ this.y +'°C';  ";
    $script .= '            }    ';
    $script .= '        },     ';
    $script .= '        legend: { ';
    $script .= "            layout: 'vertical', ";
    $script .= "            align: 'right', ";
    $script .= "            verticalAlign: 'top',  ";
    $script .= '            x: -10,  ';
    $script .= '            y: 100,  ';
    $script .= '            borderWidth: 0 ';
    $script .= '        },  ';
    $script .= '        series: [{ ';
    $script .= "                name: 'Tokyo', ";
    $script .= '                data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6] ';
    $script .= '            }, { ';
    $script .= "                name: 'New York', ";
    $script .= '                data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5] ';
    $script .= '            }, { ';
    $script .= "                name: 'Berlin', ";
    $script .= '                data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0] ';
    $script .= '            }, { ';
    $script .= "                name: 'London', ";
    $script .= '                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8] ';
    $script .= '            }] ';
    $script .= '    }); ';

    $script .= '} ';

    //$script .= '}); ';
    $script .= '</script> ';


//    $variavel['script']=$script;
}

function CriaDimensoes(&$vetEstatistica) {
    $kokw = 0;
    $opcao = $vetEstatistica['opcao'];
    $vetEstatistica = Array();
    // porte
    $sql = 'select ';
    $sql .= '  gec_op.idt,  ';
    $sql .= '  gec_op.descricao  ';
    $sql .= '  from  ' . db_pir_gec . 'gec_organizacao_porte gec_op ';
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $vetEstatistica['DIM']['PORTE'][$row['idt']] = $row['descricao'];
    }
    // instrumento
    $sql = 'select ';
    $sql .= '  grc_ai.idt,  ';
    $sql .= '  grc_ai.descricao  ';
    $sql .= '  from  grc_atendimento_instrumento grc_ai ';
    $sql .= ' where grc_ai.nivel = 1';
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $vetEstatistica['DIM']['INSTRUMENTO'][$row['idt']] = $row['descricao'];
    }
    // PJ e PF
    $vetEstatistica['DIM']['PJPF']['PJ'] = 'Empreendimento';
    $vetEstatistica['DIM']['PJPF']['PF'] = 'Pessoa';

    //

    $datadia = date('d/m/Y');
    $datadiafw = trata_data($datadia);
    $datadiaiw = trata_data(Date('d/m/Y', strtotime('-4 day')));
    $sql = 'select ';
    $sql .= '  grc_a.data, grc_a.idt_ponto_atendimento, grc_a.idt_projeto, grc_a.idt_projeto_acao, grc_a.idt_consultor, grc_a.idt_instrumento,';
    $sql .= '  grc_ao.cnpj, grc_ao.idt_porte';
    $sql .= '  from  grc_atendimento grc_a ';
    $sql .= " left outer join grc_atendimento_organizacao grc_ao on grc_ao.idt_atendimento = grc_a.idt and grc_ao.representa = 'S' and grc_ao.desvincular = 'N'";
    $sql .= '  where grc_a.idt_ponto_atendimento = ' . null($_SESSION[CS]['g_idt_unidade_regional']);
    $sql .= '    and grc_a.data >= ' . aspa($datadiaiw) . ' and grc_a.data <= ' . aspa($datadiafw);
    $sql .= '    and grc_a.situacao = ' . aspa('Finalizado');

    if ($opcao == 'P') {
        $sql .= '    and grc_a.origem = ' . aspa('P');
    }

    if ($opcao == 'D') {
        $sql .= '    and grc_a.origem = ' . aspa('D');
    }

    $rs = execsqlNomeCol($sql);

    if ($rs->rows == 0) {
        return 2;
    }
    ForEach ($rs->data as $row) {
        $data = $row['data'];
        //$idt_ponto_atendimento = $row['idt_ponto_atendimento'];
        $idt_ponto_atendimento = 1;
        $idt_projeto = $row['idt_projeto'];
        $idt_projeto_acao = $row['idt_projeto_acao'];
        $idt_consultor = $row['idt_consultor'];
        $idt_instrumento = $row['idt_instrumento'];
        $cnpj = $row['cnpj'];
        $idt_porte = $row['idt_porte'];

        $tipo_atendimento = "PF";
        $porte = "PF";

        if ($cnpj != "") {
            // atendimento pessoa juridica
            $tipo_atendimento = "PJ";

            // Pegar o porte da empresa
            $porte = $idt_porte;
        }

        $vetEstatistica[$idt_ponto_atendimento]['PJPF'][$tipo_atendimento] ++;
        $vetEstatistica[$idt_ponto_atendimento]['porte'][$porte] ++;
        $vetEstatistica[$idt_ponto_atendimento]['tipopessoa'][$tipo_atendimento] ++;
        $vetEstatistica[$idt_ponto_atendimento]['data'][$data] ++;
        $vetEstatistica[$idt_ponto_atendimento]['instrumento'][$idt_instrumento] ++;
        $vetEstatistica[$idt_ponto_atendimento]['consultor'][$idt_consultor] ++;
        $vetEstatistica[$idt_ponto_atendimento]['projeto'][$idt_projeto] ++;
        $vetEstatistica[$idt_ponto_atendimento]['projetoAcao'][$idt_projeto][$idt_projeto_acao] ++;
    }
    $kokw = 1;
    return $kokw;
}

function PesquisarCPFTOTEM($cpf, &$variavel) {
    //
    //  Acessar Agenda da Unidade
    //
    $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
    $datahoje = trata_data(date('d/m/Y'));
    //
    $sql = " select ";
    $sql .= " grc_aa.idt  as grc_aa_idt, ";
    $sql .= " grc_aa.idt_consultor  as grc_aa_idt_consultor, ";
    $sql .= " grc_aa.data as grc_aa_data, ";
    $sql .= " grc_aa.hora as grc_aa_hora, ";
    $sql .= " grc_aa.cnpj         as grc_aa_cnpj, ";
    $sql .= " grc_aa.nome_empresa as grc_aa_nome_empresa, ";
    $sql .= " gec_e.codigo as gec_e_codigo, ";
    $sql .= " gec_e.descricao as gec_e_descricao, ";
    $sql .= " grc_app.letra_painel as grc_app_letra_painel, ";

    $sql .= " grc_ab.codigo    as grc_ab_codigo, ";
    $sql .= " grc_ab.descricao as grc_ab_descricao, ";

    $sql .= " plu_us.nome_completo as plu_us_nome_completo ";
    // Agenda
    $sql .= "   from grc_atendimento_agenda grc_aa ";
    // Cadastro da Pessoa
    $sql .= " inner  join " . db_pir_gec . "gec_entidade gec_e on gec_e.idt = grc_aa.idt_cliente";
	//$sql .= " left  join " . db_pir_gec . "gec_entidade gec_e on gec_e.idt = grc_aa.idt_cliente";
	
	
    // Consultor do PA
    $sql .= " inner  join grc_atendimento_pa_pessoa grc_app on grc_app.idt_usuario = grc_aa.idt_consultor";
    $sql .= "                                              and grc_app.idt_ponto_atendimento = " . null($idt_ponto_atendimento);

    // esta na tela como não obrigatório
    $sql .= " left  join grc_atendimento_box grc_ab on grc_ab.idt = grc_app.idt_box";

    //$sql .= " left  join grc_atendimento_box grc_ab on grc_ab.idt = grc_app.idt_box";


    // Nome do Consultor do PA
    $sql .= " inner  join plu_usuario plu_us on plu_us.id_usuario = grc_aa.idt_consultor";
	// $sql .= " left join plu_usuario plu_us on plu_us.id_usuario = grc_aa.idt_consultor";
    //
    $sql .= " where  grc_aa.idt_ponto_atendimento = " . null($idt_ponto_atendimento);
    $sql .= "   and  gec_e.codigo          = " . aspa($cpf);
    $sql .= "   and  grc_aa.data           = " . aspa($datahoje);
    $sql .= "   and  grc_aa.situacao       = " . aspa('Marcado');
    //$sql .= "   and  grc_aa.idt_atendimento_agenda is null ";  // para agendamento multiplos pega o primeiro
	$sql .= "   and  grc_aa.idt_atendimento_agenda = grc_aa.idt ";  // para agendamento multiplos pega o primeiro
    //
    $rs = execsql($sql);
    //p($sql);
    //die();
    $qtdagendamentos = $rs->rows;
    $idt_atendimento_agenda = 0;
    if ($rs->rows == 0) {
        // $existeagenda = "N".$idt_ponto_atendimento. " - " . $datahoje." - ".$sql;
        $existeagenda = "N";
    } else {
        $existeagenda = "S";


        $vetMarcacoes = Array();
        ForEach ($rs->data as $row) {
            $idt_atendimento_agenda = $row['grc_aa_idt'];
            $data = $row['grc_aa_data'];
            $hora = $row['grc_aa_hora'];
            $nome_pessoa = $row['gec_e_descricao'];
            $idt_consultor = $row['grc_aa_idt_consultor'];
            $grc_app_letra_painel = $row['grc_app_letra_painel'];
            $grc_ab_codigo = $row['grc_ab_codigo'];
            $grc_ab_descricao = $row['grc_ab_descricao'];
            $plu_us_nome_completo = $row['plu_us_nome_completo'];
            $grc_aa_cnpj = $row['grc_aa_cnpj'];
            $grc_aa_nome_empresa = $row['grc_aa_nome_empresa'];
            //
            $vetMarcacoes[$data][$hora] = $row;
        }
    }
    $sql = " select ";
    $sql .= " gec_e.idt              as gec_e_idt, ";
    $sql .= " gec_e.codigo           as gec_e_codigo, ";
    $sql .= " gec_e.descricao        as gec_e_descricao, ";
    $sql .= " gec_ep.data_nascimento as gec_ep_data_nascimento, ";
    $sql .= " gec_ep.necessidade_especial as gec_ep_necessidade_especial ";
    $sql .= "   from " . db_pir_gec . "gec_entidade gec_e ";
    $sql .= "   inner join " . db_pir_gec . "gec_entidade_pessoa gec_ep on  gec_ep.idt_entidade=gec_e.idt ";
    $sql .= " where  ";
    $sql .= "        gec_e.codigo = " . aspa($cpf);
    $sql .= " and gec_e.reg_situacao  = 'A'";
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $existecadastro = "N";
    } else {
        $existecadastro = "S";
        ForEach ($rs->data as $row) {
            $gec_e_idt = $gec_e_idt;
            $gec_ep_data_nascimento = trata_data($row['gec_ep_data_nascimento']);
            $gec_ep_necessidade_especial = $row['gec_ep_necessidade_especial'];
            $nome_pessoa = $row['gec_e_descricao'];
        }
    }
    //
    //  Montar Dados para a Solicitação de Senha
    //
    $variavel['existecadastro'] = $existecadastro;
    $variavel['existeagenda'] = $existeagenda;
    $variavel['idt_atendimento_agenda'] = $idt_atendimento_agenda;

    $variavel['qtdagendamentos'] = $qtdagendamentos;
    //
    $variavel['nome_cliente'] = $nome_pessoa;
    $variavel['data_nascimento'] = $gec_ep_data_nascimento;


    $idadew = calcular_idade($gec_ep_data_nascimento);


    $variavel['idade_cliente'] = $idadew->ano;
    $variavel['portador_deficiencia'] = $gec_ep_necessidade_especial;

    $jatemprioridade = 'N';
    $idade_cliente = $variavel['idade_cliente'];
    if ($portador_deficiencia == 'S') {
        $jatemprioridade = 'S';
    } else {
        if ($idade_cliente >= 60 and $idade_cliente <= 100) {
            $jatemprioridade = 'S';
        }
    }

    $variavel['jatemprioridade'] = $jatemprioridade;



    $datahora = "";
    if ($existeagenda == 'S') {
        $datahora = trata_data($data) . " às " . $hora;
    }
    $variavel['agendamento_data_hora'] = $datahora;
    $variavel['agendamento_consultor_nome'] = $plu_us_nome_completo;
    $variavel['agendamento_consultor_letra'] = $grc_app_letra_painel;

    $variavel['guiche_codigo'] = $grc_ab_codigo;
    $variavel['guiche_descricao'] = $grc_ab_descricao;

    if ($grc_app_letra_painel == '') {
        $grc_app_letra_painel = 'Z';
    }
    //
    $variavel['agendamento_empreendimento_cnpj'] = $grc_aa_cnpj;
    $variavel['agendamento_empreendimento_razao_social'] = $grc_aa_nome_empresa;
    //
    // Verifica a relação dessa pessoa com o SEBRAE
    //
    $vetEmpresasRelacionadas = Array();
    //
    // Pessoa como associadas
    //
    $sql = " select ";
    $sql .= " gec_e.idt       as gec_e_idt, ";
    $sql .= " gec_e.codigo    as gec_e_codigo, ";
    $sql .= " gec_e.descricao as gec_e_descricao, ";
    $sql .= " gec_eer.codigo    as gec_eer_codigo, ";
    $sql .= " gec_eer.descricao as gec_eer_descricao, ";
    $sql .= " gec_eer.tipo_entidade as gec_eer_tipo_entidade ";

    // Cadastro da Pessoa
    $sql .= "   from " . db_pir_gec . "gec_entidade gec_e ";
    // Cadastro da Relação
    $sql .= " inner  join " . db_pir_gec . "gec_entidade_entidade  gec_ee on gec_ee.idt_entidade_relacionada = gec_e.idt ";
    $sql .= " inner  join " . db_pir_gec . "gec_entidade gec_eer on  gec_eer.idt = gec_ee.idt_entidade ";
    //
    $sql .= " where  ";
    $sql .= "       gec_e.codigo          = " . aspa($cpf);
    $sql .= " and gec_e.reg_situacao  = 'A'";
    $sql .= "   and gec_eer.tipo_entidade = " . aspa('O');
    $sql .= ' and gec_ee.idt_entidade_relacao <> 8';
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $existeempresasatendimento = "N";
    } else {
        $existeempresasatendimento = "S";
        ForEach ($rs->data as $row) {
            $gec_eer_codigo = $row['gec_eer_codigo'];
            $gec_eer_descricao = $row['gec_eer_descricao'];
            //
            $vetEmpresasRelacionadas[$gec_eer_codigo]['EA'] = $gec_eer_descricao;
            //
        }
    }

    //
    // Pessoa como mandatória
    //
    $sql = " select ";
    $sql .= " gec_e.idt       as gec_e_idt, ";
    $sql .= " gec_e.codigo    as gec_e_codigo, ";
    $sql .= " gec_e.descricao as gec_e_descricao, ";
    $sql .= " gec_eer.codigo    as gec_eer_codigo, ";
    $sql .= " gec_eer.descricao as gec_eer_descricao, ";
    $sql .= " gec_eer.tipo_entidade as gec_eer_tipo_entidade ";
    // Cadastro da Pessoa
    $sql .= "   from " . db_pir_gec . "gec_entidade gec_e ";
    // Cadastro da Relação
    $sql .= " inner  join " . db_pir_gec . "gec_entidade_entidade gec_ee on gec_ee.idt_entidade = gec_e.idt ";
    $sql .= " inner  join " . db_pir_gec . "gec_entidade gec_eer  on  gec_eer.idt = gec_ee.idt_entidade_relacionada ";
    //
    $sql .= " where  ";
    $sql .= "   gec_e.codigo  = " . aspa($cpf);
    $sql .= " and gec_e.reg_situacao  = 'A'";
    $sql .= ' and gec_ee.idt_entidade_relacao <> 8';
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $existeempresasatendimento = "N";
    } else {
        $existeempresasatendimento = "S";
        ForEach ($rs->data as $row) {
            $gec_eer_codigo = $row['gec_eer_codigo'];
            $gec_eer_descricao = $row['gec_eer_descricao'];
            //
            $vetEmpresasRelacionadas[$gec_eer_codigo]['EM'] = $gec_eer_descricao;
            //
        }
    }
    //
    // Resolver caso de se tem outras empresas atendidas....
    //
    $sql = " select ";
    $sql .= " grc_aa.idt  as grc_aa_idt, ";
    $sql .= " grc_aa.cnpj as grc_aa_cnpj, ";
    $sql .= " grc_aa.nome_empresa as grc_aa_nome_empresa ";
    // Agenda
    $sql .= "   from grc_atendimento_agenda grc_aa ";
    // Cadastro da Pessoa
    $sql .= " inner  join " . db_pir_gec . "gec_entidade gec_e on gec_e.codigo = grc_aa.cnpj ";
    //
    $sql .= " where  ";
    $sql .= "   gec_e.codigo  = " . aspa($cpf);
    $sql .= " and gec_e.reg_situacao = 'A'";
    //
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $existeempresasatendimento = "N";
    } else {
        $existeempresasatendimento = "S";
        ForEach ($rs->data as $row) {
            $grc_aa_cnpj = $row['grc_aa_cnpj'];
            $grc_aa_nome_empresa = $row['grc_aa_nome_empresa'];
            if ($grc_aa_nome_empresa == "") {
                $grc_aa_nome_empresa = $grc_aa_cnpj;
            }

            //
            if ($vetEmpresasRelacionadas[$grc_aa_cnpj]['EA'] != "") {
                $grc_aa_nome_empresa = $vetEmpresasRelacionadas[$grc_aa_cnpj]['EA'];
            } else {
                if ($vetEmpresasRelacionadas[$grc_aa_cnpj]['EM'] != "") {
                    $grc_aa_nome_empresa = $vetEmpresasRelacionadas[$grc_aa_cnpj]['EM'];
                }
            }
            $vetEmpresasRelacionadas[$grc_aa_cnpj]['AG'] = $grc_aa_nome_empresa;
            //
        }
    }
    //
    $vetEmpresasRelacionadasS = Array();
    //
    ForEach ($vetEmpresasRelacionadas as $codigo => $Vettrab) {
        ForEach ($Vettrab as $tipo => $Descricao) {
            $vetEmpresasRelacionadasS[$codigo] = $Descricao;
        }
    }
    //
    //
    //
    $variavel['qtd_empresas'] = count($vetEmpresasRelacionadasS);
    $variavel['existeempresascadastro'] = $existeempresascadastro;
    $variavel['existeempresasatendimento'] = $existeempresasatendimento;
    //
    $variavel['empreendimento_1'] = "";
    $variavel['cnpj_1'] = "";
    $variavel['empreendimento_2'] = "";
    $variavel['cnpj_2'] = "";
    $variavel['empreendimento_3'] = "";
    $variavel['cnpj_3'] = "";
    $variavel['empreendimento_4'] = "";
    $variavel['cnpj_4'] = "";
    $variavel['empreendimento_5'] = "";
    $variavel['cnpj_5'] = "";
    $variavel['empreendimento_6'] = "";
    $variavel['cnpj_6'] = "";
    $variavel['empreendimento_7'] = "";
    $variavel['cnpj_7'] = "";
    //
    $idx = 0;
    // p($vetEmpresasRelacionadasS);
    ForEach ($vetEmpresasRelacionadasS as $codigo => $Descricao) {
        $idx = $idx + 1;
        if ($idx < 8) {
            if ($Descricao == "") {
                $Descricao = $codigo;
            }
            $variavel["empreendimentofan_{$idx}"] = $Descricao;
            $variavel["empreendimento_{$idx}"] = $Descricao;
            $variavel["cnpj_{$idx}"] = $codigo;
        }
    }
}

function GerarSenhaTOTEM(&$variavel) {
    $kokw = 0;
    /*
      $variavel['cpf'] = $_POST['cpf'];
      $variavel['existecadastro']              = $_POST['existecadastro'];
      $variavel['existeagenda']                = $_POST['existeagenda'];
      $variavel['qtdagendamentos']             = $_POST['qtdagendamentos'];
      $variavel['existeempresascadastro']      = $_POST['existeempresascadastro'];
      $variavel['existeempresasatendimento']   = $_POST['existeempresasatendimento'];
      $variavel['nome_cliente']                = $_POST['nome_cliente'];
      $variavel['data_nascimento']             = $_POST['data_nascimento'];
      $variavel['idade_cliente']               = $_POST['idade_cliente'];
      $variavel['portador_deficiencia']        = $_POST['portador_deficiencia'];
      $variavel['agendamento_data_hora']       = $_POST['agendamento_data_hora'];
      $variavel['agendamento_consultor_nome']  = $_POST['agendamento_consultor_nome'];
      $variavel['agendamento_consultor_letra'] = $_POST['agendamento_consultor_letra'];
      $variavel['agendamento_empreendimento_cnpj'] = $_POST['agendamento_empreendimento_cnpj'];
      $variavel['agendamento_empreendimento_razao_social'] = $_POST['agendamento_empreendimento_razao_social'];
      $variavel['empreendimento_1']            = $_POST['empreendimento_1'];
      $variavel['empreendimento_2']            = $_POST['empreendimento_2'];
      $variavel['empreendimento_3']            = $_POST['empreendimento_3'];
      $variavel['empreendimento_4']            = $_POST['empreendimento_4'];
      $variavel['empreendimento_5']            = $_POST['empreendimento_5'];
      $variavel['empreendimento_6']            = $_POST['empreendimento_6'];
      $variavel['empreendimento_7']            = $_POST['empreendimento_7'];
      $variavel['cnpj_1']                      = $_POST['cnpj_1'];
      $variavel['cnpj_2']                      = $_POST['cnpj_2'];
      $variavel['cnpj_3']                      = $_POST['cnpj_3'];
      $variavel['cnpj_4']                      = $_POST['cnpj_4'];
      $variavel['cnpj_5']                      = $_POST['cnpj_5'];
      $variavel['cnpj_6']                      = $_POST['cnpj_6'];
      $variavel['cnpj_7']                      = $_POST['cnpj_7'];
      $variavel['qtd_empresas']                = $_POST['qtd_empresas'];
      $variavel['senha_totem']                 = $_POST['senha_totem'];
      $variavel['empresaavulso']               = $_POST['empresaavulso'];
      $variavel['empresaescolhida']            = $_POST['empresaescolhida'];
     */

    $idade_cliente = $variavel['idade_cliente'];
    $portador_deficiencia = $variavel['portador_deficiencia'];
    $existeagenda = $variavel['existeagenda'];
    $agendamento_consultor_letra = $variavel['agendamento_consultor_letra'];


    $prioridadeavulso = $variavel['prioridadeavulso'];
    $cnpjempresaatendimento = $variavel['cnpjempresaatendimento'];
    $nomeempresaatendimento = $variavel['nomeempresaatendimento'];

    if ($existeagenda == 'S') {   // Hora marcada com consultor
        $letras = "H" . $agendamento_consultor_letra;
    } else {
        $letras = "EX";
        if ($portador_deficiencia == 'S') {
            $letras = "EP";
        } else {
            if ($idade_cliente >= 60 and $idade_cliente <= 100) {
                $letras = "EP";
            } else {
                if ($prioridadeavulso == 1) {   // processo manual
                    $letras = "EP";
                }
            }
        }
    }
    $numero = NumeroSenha($letras);
    $numerow = TiraZeroEsq($numero);
    $senha_totemw = $letras . $numerow;
    $senha_totem = $letras . $numero;
    //
    $variavel['senha_letras'] = $letras; // com 5 zeros
    //
   // Gravar com os 5 digitoe
    // Retornar sem os zeros
    //
   $variavel['senha_totemw'] = $senha_totem; // com 5 zeros
    $variavel['senha_totem'] = $senha_totemw;



    $numero = NumeroSenhaOrdem();
    $numerow = TiraZeroEsq($numero);
    $senha_ordemw = $numerow;
    $senha_ordem = $numero;
    //
    $variavel['senha_ordemw'] = $senha_ordem; // com 5 zeros
    $variavel['senha_ordem'] = $senha_ordemw;


    RegistraChegadaCliente($variavel);
    $kokw = 1;
    return $kokw;
}

function NumeroSenha($letras) {
    $datahoje = trata_data(date('d/m/Y'));
    $tabela = "grc_senha_totem_{$datahoje}_{$letras}";
    $Campo = 'senha_totem';
    // $tam = 7;
    $tam = 5;
    $codigow = geraAutoNum(db_pir_grc, $tabela . '_' . $Campo, $tam);
    return $codigow;
}

function NumeroSenhaOrdem() {
    $datahoje = trata_data(date('d/m/Y'));
    $tabela = "grc_senha_ordem_{$datahoje}";
    $Campo = 'senha_ordem';
    // $tam = 7;
    $tam = 5;
    $codigow = geraAutoNum(db_pir_grc, $tabela . '_' . $Campo, $tam);
    return $codigow;
}

function RegistraChegadaCliente($variavel) {
    //
    // Inserir Registro do TOTEM
    //
    $datahoje = trata_data(date('d/m/Y H:i:s'));
    $data_atendimento = aspa($datahoje);
    $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
    $hora_marcada_extra = aspa($variavel['existeagenda']);

    $idt_atendimento_box_recepcao = null($_SESSION[CS]['g_idt_box_recepcao']);

    $cpf = aspa($variavel['cpf']);

    if ($variavel['nome_cliente'] == "") {
        $nome = aspa($variavel['cpf'] . ' - Sem Nome ');
    } else {
        $nome = aspa($variavel['nome_cliente']);
    }
    $prioridade = aspa('N');
    //
    $prioridadeavulso = $variavel['prioridadeavulso'];
    $cnpjempresaatendimento = $variavel['cnpjempresaatendimento'];
    $nomeempresaatendimento = $variavel['nomeempresaatendimento'];
    //
    $letrasSenha = $variavel['senha_letras'];
    //
    if ($letrasSenha == 'EP') {
        $prioridade = aspa('S');
    }
    $cnpj = aspa($variavel['empresa_escolhida']);
    $nome_empresa = aspa($variavel['empresa_nome_escolhida']);
    //
    $letras = $variavel['senha_letras'];
    $tabela = 'grc_atendimento_avulso';
    $Campo = 'protocolo';
    $tam = 4;
    $codigow = geraAutoNum(db_pir_grc, $tabela . '_' . $Campo, $tam);
    $protocolo = aspa($letras . $codigow);
    //
    $senha_totem = aspa($variavel['senha_totemw']);
    $senha_ordem = aspa($variavel['senha_ordemw']);
    //
    $telefone = aspa("");
    $celular = aspa("");
    $email = aspa("");
    $mensagem = aspa("");
    $assunto = aspa("");
    $tipo_pessoa = aspa("");
    //
    $idt_instrumento = 13; // Orientação Técnica
    //
    $sql_i = ' insert into grc_atendimento_avulso ';
    $sql_i .= ' (  ';
    $sql_i .= ' protocolo, ';
    $sql_i .= ' data_atendimento, ';
    $sql_i .= ' cpf, ';
    $sql_i .= ' nome, ';
    $sql_i .= ' telefone, ';
    $sql_i .= ' celular, ';
    $sql_i .= ' email, ';
    $sql_i .= ' hora_marcada_extra, ';
    $sql_i .= ' mensagem, ';
    $sql_i .= ' cnpj, ';
    $sql_i .= ' nome_empresa, ';
    $sql_i .= ' assunto, ';
    $sql_i .= ' tipo_pessoa, ';
    $sql_i .= ' senha_totem, ';
    $sql_i .= ' senha_ordem, ';
    $sql_i .= ' idt_instrumento, ';
    $sql_i .= ' idt_ponto_atendimento ';
    $sql_i .= '  ) values ( ';
    $sql_i .= " $protocolo, ";
    $sql_i .= " $data_atendimento, ";
    $sql_i .= " $cpf, ";
    $sql_i .= " $nome, ";
    $sql_i .= " $telefone, ";
    $sql_i .= " $celular, ";
    $sql_i .= " $email, ";
    $sql_i .= " $hora_marcada_extra, ";
    $sql_i .= " $mensagem, ";
    $sql_i .= " $cnpj, ";
    $sql_i .= " $nome_empresa, ";
    $sql_i .= " $assunto, ";
    $sql_i .= " $tipo_pessoa, ";
    $sql_i .= " $senha_totem, ";
    $sql_i .= " $senha_ordem, ";
    $sql_i .= " $idt_instrumento, ";
    $sql_i .= " $idt_ponto_atendimento ";
    $sql_i .= ') ';
    $result = execsql($sql_i);
    $idt_atendimento_avulso = lastInsertId();
    $sql = 'select ';
    $sql .= '  grc_av.*   ';
    $sql .= '  from grc_atendimento_avulso grc_av ';
    $sql .= '  where grc_av.idt = ' . null($idt_atendimento_avulso);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        
    } else {
        ForEach ($rs->data as $row) {
            $vetw = explode(' ', $row['data_atendimento']);
            $data_inicial = $vetw[0];
            $hora_inicial = $vetw[1];
            $data_inicial_aux = substr($data_inicial, 8, 2) . '/' . substr($data_inicial, 5, 2) . '/' . substr($data_inicial, 0, 4);
            $dia_semana = GRC_DiaSemana($data_inicial_aux, 'resumo1');   // formato dd/mm/aaaa
            $mensagem = $row['mensagem'];
            $telefone = $row['telefone'];
            $celular = $row['celular'];
            $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
            $idt_instrumento = $row['idt_instrumento'];
            $assunto = $row['assunto'];
            $protocolo = $row['protocolo'];
            $email = $row['email'];
            $cpf = $row['cpf'];
            $cnpj = $row['cnpj'];
            $nome_empresa = $row['nome_empresa'];
            $nome = $row['nome'];
            // acessar cadastro d0 PIR
            $sql = 'select ';
            $sql .= '  gec_e.idt   ';
            $sql .= '  from ' . db_pir_gec . 'gec_entidade gec_e ';
            $sql .= '  where gec_e.codigo = ' . aspa($cpf);
            $sql .= " and gec_e.reg_situacao = 'A'";
            $rs = execsql($sql);
            $idt_cliente = 'null';
            if ($rs->rows == 0) {
                // erro
            } else {
                ForEach ($rs->data as $row) {
                    $idt_cliente = $row['idt'];
                }
            }
            $sql = 'select ';
            $sql .= '  gec_e.idt   ';
            $sql .= '  from ' . db_pir_gec . 'gec_entidade gec_e ';
            $sql .= '  where gec_e.codigo = ' . aspa($cnpj);
            $sql .= " and gec_e.reg_situacao = 'A'";
            $rs = execsql($sql);
            $idt_empreendimento = 'null';
            if ($rs->rows == 0) {
                // erro
            } else {
                ForEach ($rs->data as $row) {
                    $idt_empreendimento = $row['idt'];
                }
            }

            // grava registro na agenda
            $idt_consultor_agenda = 'null';
            $idt_cliente_agenda = $idt_cliente;
            $idt_empreendimento_agenda = $idt_empreendimento;
            $idt_especialidade_agenda = 'null';


            $data_agenda = aspa($data_inicial);
            $hora_agenda = aspa($hora_inicial);
            $origem_agenda = aspa('Hora Extra');
            $detalhe_agenda = aspa($assunto);
            $situacao_agenda = aspa('Marcado');
            $data_confirmacao_agenda = aspa($data_inicial);
            $hora_confirmacao_agenda = aspa($hora_inicial);
            $telefone_agenda = aspa($telefone);
            $hora_chegada_agenda = aspa($hora_inicial);
            $hora_atendimento_agenda = aspa("");
            $idt_ponto_atendimento_agenda = null($idt_ponto_atendimento);
            $dia_semana_agenda = aspa($dia_semana);
            $hora_liberacao_agenda = aspa('');
            $celular_agenda = aspa($celular);
            $observacao_chegada_agenda = aspa('');
            $observacao_atendimento_agenda = aspa('');
            $cliente_texto_agenda = aspa($nome);
            $tipo_pessoa_agenda = aspa('S');
            //$protocolo_agenda              = aspa($protocolo);

            $protocolo_agenda = $senha_totem;
            $senha_totem = $senha_totem;
            $senha_ordem = $senha_ordem;

            $email_agenda = aspa($email);
            $cpf_agenda = aspa($cpf);
            $cnpj_agenda = aspa($cnpj);
            $nome_empresa_agenda = aspa($nome_empresa);
            if ($letrasSenha == 'EX' or $letrasSenha == 'EP') {
                $sql_i = ' insert into grc_atendimento_agenda ';
                $sql_i .= ' (  ';
                $sql_i .= ' idt_consultor, ';
                $sql_i .= ' idt_cliente, ';
                $sql_i .= ' idt_empreendimento, ';
                $sql_i .= ' idt_especialidade, ';
                $sql_i .= ' data, ';
                $sql_i .= ' hora, ';
                $sql_i .= ' origem, ';
                $sql_i .= ' senha_totem, ';
                $sql_i .= ' senha_ordem, ';
                $sql_i .= ' detalhe, ';
                $sql_i .= ' situacao, ';
                $sql_i .= ' data_confirmacao, ';
                $sql_i .= ' hora_confirmacao, ';
                $sql_i .= ' telefone, ';
                $sql_i .= ' hora_chegada, ';
                $sql_i .= ' hora_atendimento, ';
                $sql_i .= ' idt_ponto_atendimento, ';
                $sql_i .= ' idt_instrumento, ';
                $sql_i .= ' dia_semana, ';
                $sql_i .= ' hora_liberacao, ';
                $sql_i .= ' celular, ';
                $sql_i .= ' observacao_chegada, ';
                $sql_i .= ' observacao_atendimento, ';
                $sql_i .= ' cliente_texto, ';
                $sql_i .= ' tipo_pessoa, ';
                $sql_i .= ' protocolo, ';
                $sql_i .= ' email, ';
                $sql_i .= ' cpf, ';
                $sql_i .= ' cnpj, ';
                $sql_i .= ' nome_empresa ';
                $sql_i .= '  ) values ( ';
                $sql_i .= " $idt_consultor_agenda, ";
                $sql_i .= " $idt_cliente_agenda, ";
                $sql_i .= " $idt_empreendimento_agenda, ";
                $sql_i .= " $idt_especialidade_agenda, ";
                $sql_i .= " $data_agenda, ";
                $sql_i .= " $hora_agenda, ";
                $sql_i .= " $origem_agenda, ";
                $sql_i .= " $senha_totem, ";
                $sql_i .= " $senha_ordem, ";
                $sql_i .= " $detalhe_agenda, ";
                $sql_i .= " $situacao_agenda, ";
                $sql_i .= " $data_confirmacao_agenda, ";
                $sql_i .= " $hora_confirmacao_agenda, ";
                $sql_i .= " $telefone_agenda, ";
                $sql_i .= " $hora_chegada_agenda, ";
                $sql_i .= " $hora_atendimento_agenda, ";
                $sql_i .= " $idt_ponto_atendimento_agenda, ";
                $sql_i .= " $idt_instrumento, ";
                $sql_i .= " $dia_semana_agenda, ";
                $sql_i .= " $hora_liberacao_agenda, ";
                $sql_i .= " $celular_agenda, ";
                $sql_i .= " $observacao_chegada_agenda, ";
                $sql_i .= " $observacao_atendimento_agenda, ";
                $sql_i .= " $cliente_texto_agenda, ";
                $sql_i .= " $tipo_pessoa_agenda, ";
                $sql_i .= " $protocolo_agenda, ";
                $sql_i .= " $email_agenda, ";
                $sql_i .= " $cpf_agenda, ";
                $sql_i .= " $cnpj_agenda, ";
                $sql_i .= " $nome_empresa_agenda ";
                $sql_i .= ') ';
                $result = execsql($sql_i);
                $idt_atendimento_agenda = lastInsertId();
                //
                $idt_atendimento_box = $idt_atendimento_box_recepcao;
                $idt_atendimento_painel = idtAtendimentoPainel();
                $status_painel_agenda = aspa('01');
                //
                // Grava registro no painel
                //
                $sql_i = ' insert into grc_atendimento_agenda_painel ';
                $sql_i .= ' (  ';
                $sql_i .= ' idt_consultor, ';
                $sql_i .= ' idt_cliente, ';
                $sql_i .= ' idt_especialidade, ';
                $sql_i .= ' idt_atendimento_agenda, ';
                $sql_i .= ' idt_atendimento_box, ';
                $sql_i .= ' idt_atendimento_painel, ';
                $sql_i .= ' data, ';
                $sql_i .= ' hora, ';
                $sql_i .= ' origem, ';
                $sql_i .= ' detalhe, ';
                $sql_i .= ' situacao, ';
                $sql_i .= ' data_confirmacao, ';
                $sql_i .= ' hora_confirmacao, ';
                $sql_i .= ' telefone, ';
                $sql_i .= ' hora_chegada, ';
                $sql_i .= ' hora_atendimento, ';
                $sql_i .= ' idt_ponto_atendimento, ';
                $sql_i .= ' idt_instrumento, ';
                $sql_i .= ' dia_semana, ';
                $sql_i .= ' hora_liberacao, ';
                $sql_i .= ' celular, ';
                $sql_i .= ' observacao_chegada, ';
                $sql_i .= ' observacao_atendimento, ';
                $sql_i .= ' cliente_texto, ';
                $sql_i .= ' status_painel, ';
                $sql_i .= " senha_totem, ";
                $sql_i .= " senha_ordem, ";
                $sql_i .= ' protocolo  ';
                $sql_i .= '  ) values ( ';
                $sql_i .= " $idt_consultor_agenda, ";
                $sql_i .= " $idt_cliente_agenda, ";
                $sql_i .= " $idt_especialidade_agenda, ";
                $sql_i .= " $idt_atendimento_agenda, ";
                $sql_i .= " $idt_atendimento_box, ";
                $sql_i .= " $idt_atendimento_painel, ";
                $sql_i .= " $data_agenda, ";
                $sql_i .= " $hora_agenda, ";
                $sql_i .= " $origem_agenda, ";
                $sql_i .= " $detalhe_agenda, ";
                $sql_i .= " $situacao_agenda, ";
                $sql_i .= " $data_confirmacao_agenda, ";
                $sql_i .= " $hora_confirmacao_agenda, ";
                $sql_i .= " $telefone_agenda, ";
                $sql_i .= " $hora_chegada_agenda, ";
                $sql_i .= " $hora_atendimento_agenda, ";
                $sql_i .= " $idt_ponto_atendimento_agenda, ";
                $sql_i .= " $idt_instrumento, ";
                $sql_i .= " $dia_semana_agenda, ";
                $sql_i .= " $hora_liberacao_agenda, ";
                $sql_i .= " $celular_agenda, ";
                $sql_i .= " $observacao_chegada_agenda, ";
                $sql_i .= " $observacao_atendimento_agenda, ";
                $sql_i .= " $cliente_texto_agenda, ";
                $sql_i .= " $status_painel_agenda, ";
                $sql_i .= " $senha_totem, ";
                $sql_i .= " $senha_ordem, ";
                $sql_i .= " $protocolo_agenda ";
                $sql_i .= ') ';
                $result = execsql($sql_i);
            } else {
                //
                // Hora marcada consultor
                //
                 // Ver com gilmar a geração dos dados desse
                $idt_atendimento_agenda = $variavel['idt_atendimento_agenda'];
                $datadiaw = (date('d/m/Y H:i:s'));
                $datadia = aspa(trata_data($datadiaw));

                $vetw = explode(' ', $datadiaw);
                $horadiaw = aspa($vetw[1]);

                // isso deu erro 
                // $result = execsql($sql_a);


                $idt_atendimento_box = 'null';
                $idt_atendimento_painel = idtAtendimentoPainel();
                $status_painel_agenda = aspa('01');

                $sql_aa = ' select idt_consultor, data, hora from grc_atendimento_agenda ';
                $sql_aa .= ' where  idt = ' . null($idt_atendimento_agenda);
                $result = execsql($sql_aa);
                if ($result->rows != 1) {
                    // erro estranho tinha que existir
                } else {
                    // atualiza dados da agenda

                    $idt_consultor_agenda = 'null';
                    $data_agenda = '';
                    $hora_agenda = '';
                    ForEach ($result->data as $row) {
                        $idt_consultor_agenda = $row['idt_consultor'];
                        $data_agenda = aspa($row['data']);
                        $hora_agenda = aspa($row['hora']);
                    }
                    $sql_a = " update grc_atendimento_agenda set ";
                    $sql_a .= " senha_totem = " . $senha_totem . ", ";
                    $sql_a .= " hora_chegada = " . $horadiaw;
                    $sql_a .= " where idt  = " . null($idt_atendimento_agenda);
                    $result_a = execsql($sql_a);
                    //
                    // Verifica se grava o Painel dessa agenda
                    //
                    $kokw = 0;
                    $sql2 = 'select ';
                    $sql2 .= '  grc_aap.*   ';
                    $sql2 .= '  from grc_atendimento_agenda_painel grc_aap ';
                    $sql2 .= '  where grc_aap.idt_consultor = ' . null($idt_consultor_agenda);
                    $sql2 .= '  and grc_aap.data = ' . ($data_agenda);
                    $sql2 .= '  and grc_aap.hora = ' . ($hora_agenda);

                    $rs_aap = execsql($sql2);

                    if ($rs_aap->rows == 0) {
                        $sql_i = ' insert into grc_atendimento_agenda_painel ';
                        $sql_i .= ' (  ';
                        $sql_i .= ' idt_consultor, ';
                        $sql_i .= ' idt_cliente, ';
                        $sql_i .= ' idt_especialidade, ';
                        $sql_i .= ' idt_atendimento_agenda, ';
                        $sql_i .= ' idt_atendimento_box, ';
                        $sql_i .= ' idt_atendimento_painel, ';
                        $sql_i .= ' data, ';
                        $sql_i .= ' hora, ';
                        $sql_i .= ' origem, ';
                        $sql_i .= ' detalhe, ';
                        $sql_i .= ' situacao, ';
                        $sql_i .= ' data_confirmacao, ';
                        $sql_i .= ' hora_confirmacao, ';
                        $sql_i .= ' telefone, ';
                        $sql_i .= ' hora_chegada, ';
                        $sql_i .= ' hora_atendimento, ';
                        $sql_i .= ' idt_ponto_atendimento, ';
                        $sql_i .= ' idt_instrumento, ';
                        $sql_i .= ' dia_semana, ';
                        $sql_i .= ' hora_liberacao, ';
                        $sql_i .= ' celular, ';
                        $sql_i .= ' observacao_chegada, ';
                        $sql_i .= ' observacao_atendimento, ';
                        $sql_i .= ' cliente_texto, ';
                        $sql_i .= ' status_painel, ';
                        $sql_i .= ' protocolo  ';
                        $sql_i .= '  ) values ( ';
                        $sql_i .= " $idt_consultor_agenda, ";
                        $sql_i .= " $idt_cliente_agenda, ";
                        $sql_i .= " $idt_especialidade_agenda, ";
                        $sql_i .= " $idt_atendimento_agenda, ";
                        $sql_i .= " $idt_atendimento_box, ";
                        $sql_i .= " $idt_atendimento_painel, ";
                        $sql_i .= " $data_agenda, ";
                        $sql_i .= " $hora_agenda, ";
                        $sql_i .= " $origem_agenda, ";
                        $sql_i .= " $detalhe_agenda, ";
                        $sql_i .= " $situacao_agenda, ";
                        $sql_i .= " $data_confirmacao_agenda, ";
                        $sql_i .= " $hora_confirmacao_agenda, ";
                        $sql_i .= " $telefone_agenda, ";
                        $sql_i .= " $hora_chegada_agenda, ";
                        $sql_i .= " $hora_atendimento_agenda, ";
                        $sql_i .= " $idt_ponto_atendimento_agenda, ";
                        $sql_i .= " $idt_instrumento, ";
                        $sql_i .= " $dia_semana_agenda, ";
                        $sql_i .= " $hora_liberacao_agenda, ";
                        $sql_i .= " $celular_agenda, ";
                        $sql_i .= " $observacao_chegada_agenda, ";
                        $sql_i .= " $observacao_atendimento_agenda, ";
                        $sql_i .= " $cliente_texto_agenda, ";
                        $sql_i .= " $status_painel_agenda, ";
                        $sql_i .= " $protocolo_agenda ";
                        $sql_i .= ') ';
                        $result = execsql($sql_i);
                    } else {
                        $sql_a = " update grc_atendimento_agenda_painel set ";
                        $sql_a .= " status_painel     = '01', ";
                        $sql_a .= " data_hora_chegada = " . $datadia . " , ";
                        $sql_a .= " idt_consultor     = " . $idt_consultor_agenda;
                        $sql_a .= " where idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
                        $result = execsql($sql_a);
                    }
                }
            }
            //
            // Preparar o atendimento para o cliente
            //
            $variavel['instrumento'] = $idt_instrumento;
            IniciaAtendimento($idt_atendimento_agenda, $idt_cliente_agenda, $variavel);
        }
    }
}

function GeraMenuBia(&$qtditens) {
    $html = "";
    if ($_SESSION[CS]['g_menu_bia'] != '') {
        $html = $_SESSION[CS]['g_menu_bia'];
        $qtditens = $_SESSION[CS]['g_menu_bia_qtditens'];
        return $html;
    }
    /*
      $sql  ="select bia_menubia.idt as idt_pai, bia_submenubia.idt as idt_filho, bia_submenubia.CodMenu, bia_submenubia.CodSubMenu, TituloMenu, TituloSubMenu ";
      $sql .=" from db_pir_bia.bia_submenubia ";
      $sql .="  left join  db_pir_bia.bia_menubia on bia_menubia.CodMenu = bia_submenubia.CodMenu ";
      // $sql .="  where  bia_submenubia.CodSEBRAE = 26   ";
      $sql .="  where  bia_menubia.idt_sebrae = 29 ";
      $sql .="  and  bia_menubia.Situacao = 'P' ";
      $sql .="  order by bia_menubia.ordem , bia_submenubia.ordem ";
     */

    $sql = "select bia_agrupamento.codigo as bia_agrupamento_codigo, bia_agrupamento.descricao as bia_agrupamento_descricao, bia_menubia.idt as idt_pai, bia_submenubia.idt as idt_filho, bia_menubia.CodMenu, bia_submenubia.CodSubMenu, TituloMenu, TituloSubMenu ";
    //$sql .=" from db_pir_bia.bia_submenubia ";

    $sql .= " from db_pir_bia.bia_menubia ";

    $sql .= "  left join  db_pir_bia.bia_submenubia on bia_menubia.CodMenu = bia_submenubia.CodMenu ";

    $sql .= "  left join  db_pir_bia.bia_agrupamento on bia_agrupamento.idt = bia_menubia.idt_agrupamento ";


    // $sql .="  where  bia_submenubia.CodSEBRAE = 26   ";
    $sql .= "  where  bia_menubia.idt_sebrae = 29 ";
    $sql .= "  and  bia_menubia.Situacao = 'P' ";
    $sql .= "  order by bia_agrupamento_codigo, bia_menubia.ordem , bia_submenubia.ordem ";

    $rs = execsql($sql);
    if ($rs->rows == 0) {
        //
        // erro Não encontrou menu Bia
    //
    } else {
        $vetMenuGrupoBia = Array();
        $vetMenuGrupo = Array();
        $vetMenuBia = Array();
        $vetSubMenuBia = Array();
        $vetSubMenuBiaIDTPAI = Array();
        $vetSubMenuBiaIDTFILHO = Array();
        ForEach ($rs->data as $row) {
            $idt_pai = $row['idt_pai'];
            $idt_filho = $row['idt_filho'];
            $CodMenu = $row['codmenu'];
            $CodSubMenu = $row['codsubmenu'];
            $TituloMenu = $row['titulomenu'];
            $TituloSubMenu = $row['titulosubmenu'];

            $bia_agrupamento_codigo = $row['bia_agrupamento_codigo'];
            $bia_agrupamento_descricao = $row['bia_agrupamento_descricao'];
            $vetMenuGrupoBia[$bia_agrupamento_codigo] = $bia_agrupamento_descricao;

            $vetMenuGrupo[$CodMenu] = $bia_agrupamento_codigo;
            $vetMenuBia[$CodMenu] = $TituloMenu;
            $vetSubMenuBiaIDTPAI[$CodMenu]['idt_pai'] = $idt_pai;
            $vetSubMenuBia[$CodMenu][$CodSubMenu] = $TituloSubMenu;
            $vetSubMenuBiaIDTFILHO[$CodMenu][$CodSubMenu]['idt_filho'] = $idt_filho;
        }
    }




    $html = "";
    $html .= "<style>";
    $html .= " .b_menu { ";
    $html .= "   float:left; ";
    $html .= "   width:100%; ";
    $html .= "   display:block; ";
    $html .= "   background:#F1F1F1; ";
    $html .= "   border-bottom:1px solid #FFFFFF; ";
    $html .= "   cursor:pointer; ";
    $html .= " } ";


    $html .= " .b_submenu { ";
    $html .= "   float:left; ";
    $html .= "   width:100%; ";
    $html .= "   display:block; ";
    $html .= "   background:#FFFFFF; ";
    $html .= "   border-bottom:1px solid #F1F1F1; ";
    $html .= "   display:none; ";
    $html .= "   cursor:pointer; ";
    $html .= " } ";


    $html .= " .b_submenu_t { ";
    $html .= "    margin-left:26px; ";
    $html .= " } ";



    $html .= "</style>";

    $htmls .= "";
    $htmls .= "<script>";
    $htmls .= " function AbreMenu(codigo) ";
    $htmls .= " { ";
    $htmls .= "   alert('abre '+codigo);";
    $htmls .= " } ";
    $htmls .= "</script>";
    //echo $htmls;
    $qtditens = 0;

    $bia_agrupamento_codigow = "##";
    ForEach ($vetMenuBia as $codigo => $descricao) {

        $bia_agrupamento_codigo = $vetMenuGrupo[$codigo];
        if ($bia_agrupamento_codigo != $bia_agrupamento_codigow) {   // Grupo de elementos do menu
            $onclickw = "onclick='return AbreMenuGrupo(" . '"' . $bia_agrupamento_codigo . '"' . ");'";
            $html .= "<div {$onclickw} class='b_menu tp{$codigo} grupop{$bia_agrupamento_codigo}' style='background:#ABBBBF;  '>";
            $html .= "<div style='float:left; guyheight:30px; padding-top:5px; xwidth:10%; '>";
            $html .= "<img id='img_g{$bia_agrupamento_codigo}' width='21' height='21' style='padding:4px; ' title='Grupo de Menu Bia' src='imagens/mais_t.png' border='0'>";
            $html .= "</div>";
            $html .= "<div style='float:left; padding-top:10px; guyheight:30px; width:85%; xoverflow:hidden; color:#FFFFFF; guytext-align:center; '>";
            $bia_agrupamento_descricao = $vetMenuGrupoBia[$bia_agrupamento_codigo];
            $html .= "{$bia_agrupamento_descricao}";
            $html .= "</div>";
            $html .= "</div>";
            $bia_agrupamento_codigow = $bia_agrupamento_codigo;
        }
        $onclickw = "onclick='return AbreMenu($codigo);'";
        $html .= "<div {$onclickw} cod='{$codigo}' class='b_menu tp{$codigo}  grupotp{$bia_agrupamento_codigo}' '>";

        $html .= "<div style='float:left; guyheight:30px; xwidth:10%; '>";
        $html .= "<img id='img_i{$codigo}' width='21' height='21' style='padding:4px; ' title='Mostra SubMenu BIA' src='imagens/mais_t.png' border='0'>";
        $html .= "</div>";
        $html .= "<div style='float:left; padding-top:5px; guyheight:30px; width:85%; xoverflow:hidden; '>";
        $html .= "$descricao";
        $html .= "</div>";

        $html .= "</div>";



        $qtditens = $qtditens + 1;
        $codigomenu = $codigo;
        $vetSubMenuBiaw = $vetSubMenuBia[$codigomenu];
        $idt_pai = $vetSubMenuBiaIDTPAI[$codigomenu]['idt_pai'];
        ForEach ($vetSubMenuBiaw as $codigo => $descricao) {

            $idt_filho = $vetSubMenuBiaIDTFILHO[$codigomenu][$codigo]['idt_filho'];
            $html .= "<div idt='{$idt_filho}' id='idt{$codigomenu}' class='b_submenu t{$codigomenu} grupo{$bia_agrupamento_codigo}'>";



            $grupo = $vetMenuGrupoBia[$bia_agrupamento_codigo];
            $menu = $vetMenuBia[$codigomenu];
            $submenu = $vetSubMenuBia[$codigomenu][$codigo];


            $onclickw = "onclick='return ExecutaSubMenu($codigo,$idt_pai,$idt_filho," . '"' . $grupo . '", "' . $menu . '" , "' . $submenu . '"' . ")';";
            $html .= "<div {$onclickw} class='b_submenu_t'>";
            $html .= "$descricao";
            $html .= "</div>";
            $html .= "</div>";
            $qtditens = $qtditens + 1;
        }
    }
    $_SESSION[CS]['g_menu_bia_qtditens'] = $qtditens;
    $_SESSION[CS]['g_menu_bia'] = $html;
    return $html;
}

function GeraConteudoBia($codigo, $idt_pai, $idt_filho) {
    $html = "";


    $html .= "<style>";
    $html .= " .b_ConteudoBia { ";
    $html .= "   float:left; ";
    $html .= "   width:98%; ";
    $html .= "   display:block; ";
    $html .= "   background:#ECF0F1; ";
    $html .= "   border-bottom:1px solid #FFFFFF; ";
    $html .= "   cursor:pointer; ";
    $html .= " } ";

    $html .= "</style>";


    $sql = "select bia_c.*, bia_csm.Principal as Principal ";
    $sql .= " from db_pir_bia.bia_conteudobiasubmenu bia_csm ";
    $sql .= " inner join db_pir_bia.bia_conteudobia bia_c on bia_c.idt = bia_csm.idt_conteudobia ";
    $sql .= "  where  bia_csm.idt_submenubia = " . null($idt_filho);
    $sql .= "  order by  bia_csm.Principal desc, bia_csm.Ordem ";
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        //
        // Não tem Conteudo para o submenu
        //
        $html .= "<div class='b_ConteudoBia '>";
        $html .= "<div style='text-align:center; font-size:20px; width:100%; display:block; background:#000000; color:#FFFFFF; float:left; padding-top:5px; height:30px;  '>";
        $html .= "Não tem Conteúdo para Exibir.";
        $html .= "</div>";
    } else {
        $vetConteudoBIA = Array();
        ForEach ($rs->data as $row) {
            $idt_conteudo = $row['idt'];
            $TituloConteudo = $row['tituloconteudo'];
            $SubTituloConteudo = $row['Subtituloconteudo'];
            $ResumoConteudo = $row['resumoconteudo'];
            $CorpoTexto = $row['corpotexto'];

            $Principal = $row['Principal'];
            //$html .="$TituloConteudo <br />";
            $vetConteudoBIA[$idt_conteudo]['TP'] = $Principal;
            $vetConteudoBIA[$idt_conteudo]['TI'] = $TituloConteudo;
            $vetConteudoBIA[$idt_conteudo]['ST'] = $SubTituloConteudo;
            $vetConteudoBIA[$idt_conteudo]['RC'] = $ResumoConteudo;
            $vetConteudoBIA[$idt_conteudo]['CO'] = $CorpoTexto;
        }
    }

    //p($vetConteudoBIA);

    ForEach ($vetConteudoBIA as $idt_conteudo => $vetConteudo) {

        $Principal = $vetConteudo['TP'];
        $TituloConteudo = $vetConteudo['TI'];
        $SubTituloConteudo = $vetConteudo['ST'];
        $ResumoConteudo = $vetConteudo['RC'];
        $CorpoTexto = $vetConteudo['CO'];
        $onclickw = "onclick='return AbreItemMenu($idt_conteudo);'";
        $html .= "<div  class='b_ConteudoBia tpitem{$idt_conteudo}'>";


        /*
          $html .=  "<div style='float:left; height:30px; padding-top:5px; '>";
          $html .=  "<input idt='{$idt_conteudo}' class='esc_bia_pesq' type='checkbox' style='width:21px; height:21px; ' title='Marcar Conteúdo' border='0'>";
          $html .=  "</div>";
         */

        $html .= "<div  style=''>";



        $html .= "<div style='float:left; height:30px; xpadding-right:15px; '>";
        if ($Principal != 'S') {
            $html .= "<img {$onclickw} id='img_cont_{$idt_conteudo}' width='32' height='32' style='padding:1px; ' title='Mostra Conteúdo BIA' src='imagens/mais_t.png' border='0'>";
        } else {
            $html .= "<img {$onclickw} id='img_cont_{$idt_conteudo}' width='32' height='32' style='padding:1px; ' title='Mostra Conteúdo BIA' src='imagens/menos_t.png' border='0'>";
        }
        $html .= "</div>";
        $html .= "<div style='float:left; padding-top:5px; height:30px;  '>";
        $html .= $TituloConteudo;
        $html .= "</div>";

        $html .= "<div style='float:right; height:30px; padding-top:5px; padding-right:15px;'>";
        $html .= "<input idt='{$idt_conteudo}' class='esc_bia_pesq' type='checkbox' style='width:21px; height:21px; ' title='Marcar Conteúdo' border='0'>";
        $html .= "</div>";



        $disp = "";
        if ($Principal != 'S') {
            $disp = "display:none;";
        }
        $html .= "<div idt='{$idt_conteudo}' id='contbia{$idt_conteudo}' class='contbia'   style='{$disp} background:#FFFFFF; float:left; padding-top:5px; '>";
        $html .= $CorpoTexto;
        $html .= "</div>";

        $html .= "</div>";





        $html .= "</div>";
    }

    return $html;
}

function PesquisarBIA($texto_pesq_bia) {
    $html = "";


    $html .= "<style>";
    $html .= " .b_ConteudoBia { ";
    $html .= "   float:left; ";
    $html .= "   width:98%; ";
    $html .= "   display:block; ";
    $html .= "   background:#ECF0F1; ";
    $html .= "   border-bottom:1px solid #FFFFFF; ";
    $html .= "   cursor:pointer; ";
    $html .= " } ";

    $html .= "</style>";






    /*
      $sql  ="select bia_c.* ";
      $sql .=" from db_pir_bia.bia_conteudobia bia_c ";
      $sql .="  where  ";
      $sql .="         bia_c.CorpoTexto like '%{$texto_pesq_bia}%' ";
      $sql .="     or  bia_c.ResumoConteudo like '%{$texto_pesq_bia}%' ";
      $sql .="     or  bia_c.SubTituloConteudo like '%{$texto_pesq_bia}%' ";
      $sql .="     or  bia_c.TituloConteudo like '%{$texto_pesq_bia}%' ";
      //$sql .="  order by  bia_csm.Principal desc, bia_csm.Ordem ";
     */


    $sql = "select bia_c.*, bia_csm.Principal as Principal ";

    $sql .= " from db_pir_bia.bia_menubia bia_m ";
    $sql .= " inner join db_pir_bia.bia_submenubia bia_sm on bia_sm.idt_menubia = bia_m.idt ";
    $sql .= " inner join db_pir_bia.bia_conteudobiasubmenu bia_csm on bia_csm.idt_submenubia = bia_sm.idt ";
    $sql .= " inner join db_pir_bia.bia_conteudobia bia_c on bia_c.idt = bia_csm.idt_conteudobia ";
    $sql .= "  where  ";
    $sql .= "     ( ";
    //$sql .="         bia_m.CodSEBRAE = 26 ";

    $sql .= "    bia_m.idt_sebrae = 29 ";

    $sql .= "     )  and ";
    $sql .= "     ( ";
    $sql .= "         bia_c.CorpoTexto like '%{$texto_pesq_bia}%' ";
    $sql .= "     or  bia_c.ResumoConteudo like '%{$texto_pesq_bia}%' ";
    $sql .= "     or  bia_c.SubTituloConteudo like '%{$texto_pesq_bia}%' ";
    $sql .= "     or  bia_c.TituloConteudo like '%{$texto_pesq_bia}%' ";
    $sql .= "     ) ";
    $sql .= "  order by  bia_csm.Principal desc, bia_csm.Ordem ";







    $rs = execsql($sql);
    $qtdpest = $rs->rows;
    if ($rs->rows == 0) {
        //
        // Não tem Conteudo para o submenu
        //
        $html .= "<div class='b_ConteudoBia '>";
        $html .= "<div style='text-align:center; font-size:20px; width:100%; display:block; background:#000000; color:#FFFFFF; float:left; padding-top:5px; height:30px;  '>";
        $html .= "Não tem Conteúdo para Exibir.";
        $html .= "</div>";
    } else {
        $vetConteudoBIA = Array();
        $qtdpestw = 1;
        ForEach ($rs->data as $row) {
            $idt_conteudo = $row['idt'];
            $TituloConteudo = $row['tituloconteudo'];
            $SubTituloConteudo = $row['subtituloconteudo'];
            $ResumoConteudo = $row['resumoconteudo'];
            $CorpoTexto = $row['corpotexto'];

            $Principal = $row['principal'];
            //$html .="$TituloConteudo <br />";
            $qtdpestw = $qtdpestw + 1;
            $vetConteudoBIA[$idt_conteudo]['TP'] = $Principal;
            $vetConteudoBIA[$idt_conteudo]['TI'] = $TituloConteudo;
            $vetConteudoBIA[$idt_conteudo]['ST'] = $SubTituloConteudo;
            $vetConteudoBIA[$idt_conteudo]['RC'] = $ResumoConteudo;
            $vetConteudoBIA[$idt_conteudo]['CO'] = $CorpoTexto;
            if ($qtdpestw >= 50) {
                break;
            }
        }
    }

    //p($vetConteudoBIA);

    if ($qtdpest > 50) {
        $html .= "<div class='b_ConteudoBia '>";
        $html .= "<div style='text-align:center; font-size:20px; width:100%; display:block; background:#000000; color:#FFFFFF; float:left; padding-top:5px; height:30px;  '>";
        $html .= "Essa pesquisa encontrou " . $qtdpest . " conteúdos. Serão mostrados os 50 primeiros.";
        $html .= "</div>";
    }
    ForEach ($vetConteudoBIA as $idt_conteudo => $vetConteudo) {

        $Principal = $vetConteudo['TP'];
        $TituloConteudo = $vetConteudo['TI'];
        $SubTituloConteudo = $vetConteudo['ST'];
        $ResumoConteudo = $vetConteudo['RC'];
        $CorpoTexto = $vetConteudo['CO'];
        $onclickw = "onclick='return AbreItemMenu($idt_conteudo);'";
        $html .= "<div  class='b_ConteudoBia tpitem{$idt_conteudo}' style='margin-top:1px;'>";

//           $html .=  "<div style='border-bottom:1px solid #FFFFFF; float:left;  display:block; '>";



        $html .= "<div  style=''>";


        $html .= "<div style='float:left; height:30px; '>";
        $html .= "<img {$onclickw} id='img_cont_{$idt_conteudo}' width='32' height='32' style='padding:2px; ' title='Mostra Conteúdo BIA' src='imagens/mais_t.png' border='0'>";
        $html .= "</div>";

        $html .= "<div style='float:left;  padding-top:10px; height:30px;  '>";
        $html .= $TituloConteudo;
        $html .= "</div>";

        $html .= "<div style='float:right; height:30px; padding-top:5px; padding-right:15px; '>";
        $html .= "<input idt='{$idt_conteudo}' class='esc_bia_pesq' type='checkbox' style='width:21px; height:21px; ' title='Marcar Conteúdo' border='0'>";
        $html .= "</div>";



        // $disp = "";
        // if ($Principal!='S')
        // {
        $disp = "display:none;";
        // }
        $html .= "<div idt='{$idt_conteudo}' id='contbia{$idt_conteudo}' class='contbia'   style='{$disp} background:#FFFFFF; float:left; padding-top:5px; '>";
        $html .= $CorpoTexto;
        $html .= "</div>";

        $html .= "</div>";



        $html .= "</div>";
    }

    return $html;
}

function EnviarEmailBia($idt_atendimento, $idt_pessoa, $marcados) {
    $html = "";
    $_SESSION[CS]['g_bia_email_vet'] = Array();
    //
    // Buscar dados do atendimento
    //
   $kokw = 0;
    $sql2 = 'select ';
    $sql2 .= '  grc_a.*   ';
    $sql2 .= '  from grc_atendimento grc_a ';
    $sql2 .= ' where grc_a.idt    = ' . null($idt_atendimento);
    $rs_aap = execsql($sql2);
    if ($rs_aap->rows == 0) {
        // erro;
        // $_SESSION[CS]['g_bia_email_html']=$html;
        $_SESSION[CS]['g_bia_email_vet'] = Array();
        $_SESSION[CS]['g_bia_email_vet']['html'] = "";
        $_SESSION[CS]['g_bia_email_vet']['protocolo'] = "";
        $_SESSION[CS]['g_bia_email_vet']['destinatario'] = "";
        $_SESSION[CS]['g_bia_email_vet']['email_destino'] = "";
        if ($idt_atendimento > 0) {
            return $html;
        }
    }
    $protocolo = "";



    ForEach ($rs_aap->data as $row) {
        $protocolo = $row['protocolo'];
        $idt_atendimentow = $row['idt'];
        //
        $sql2 = 'select ';
        $sql2 .= '  grc_ap.*   ';
        $sql2 .= '  from grc_atendimento_pessoa grc_ap ';
        $sql2 .= ' where grc_ap.idt_atendimento  = ' . null($idt_atendimentow);
        $rs_3 = execsql($sql2);
        if ($rs_3->rows > 0) {
            ForEach ($rs_3->data as $row) {
                if ($row['tipo_relacao'] == 'L') {
                    $_SESSION[CS]['g_bia_email_vet']['destinatario'] = $row['nome'];
                    $_SESSION[CS]['g_bia_email_vet']['email_destino'] = $row['email'];
                }
            }
        }
    }

    $vetConteudos = Array();
    $vetConteudos = explode('###', $marcados);
    $tam = count($vetConteudos);
    //p($vetConteudos);
    if ($tam > 0) {
        //
        // Enviar E-mails
        //
       ForEach ($vetConteudos as $idx => $idt) {
            if ($idt > 0) {
                $sql = "select bia_c.*, bia_csm.Principal as Principal ";
                $sql .= " from db_pir_bia.bia_menubia bia_m ";
                $sql .= " inner join db_pir_bia.bia_submenubia bia_sm on bia_sm.idt_menubia = bia_m.idt ";
                $sql .= " inner join db_pir_bia.bia_conteudobiasubmenu bia_csm on bia_csm.idt_submenubia = bia_sm.idt ";
                $sql .= " inner join db_pir_bia.bia_conteudobia bia_c on bia_c.idt = bia_csm.idt_conteudobia ";
                $sql .= "  where  ";
                $sql .= "     ( ";
                $sql .= "    bia_m.idt_sebrae = 29 ";
                $sql .= "     and bia_c.idt = {$idt} ";
                $sql .= "     ) ";
                $rs = execsql($sql);
                $qtdpest = $rs->rows;
                if ($rs->rows == 0) {
                    //
                    // Não tem Conteudo para o submenu
                    // Erro
                //
                } else {
                    $vetConteudoBIA = Array();
                    $qtdpestw = 1;
                    $quebra = "";
                    ForEach ($rs->data as $row) {
                        $idt_conteudo = $row['idt'];
                        $TituloConteudo = $row['tituloconteudo'];
                        $SubTituloConteudo = $row['subtituloconteudo'];
                        $ResumoConteudo = $row['resumoconteudo'];
                        $CorpoTexto = $row['corpotexto'];
                        $html .= "<br />";
                        $html .= "<div  style='float:left;  font-size:14px; font-weight:bold; width:100%; display:block;'>";
                        $html .= "{$TituloConteudo} - {$SubTituloConteudo} <br /> ";
                        $html .= "</div>";
                        //$_SESSION[CS]['g_bia_email_vet']['titulobia'] = "{$TituloConteudo} - {$SubTituloConteudo}";
                        if ($_SESSION[CS]['g_bia_email_vet']['titulobia'] != '') {
                            $quebra = "<br />";
                        }
                        $_SESSION[CS]['g_bia_email_vet']['titulobia'] .= "{$quebra}{$TituloConteudo}";

                        $html .= "<div  style='padding-bottom:10px; float:left; width:100%; display:block;'>";
                        $html .= "{$CorpoTexto}";
                        $html .= "</div>";
                    }
                }
            }
        }
    }
    //$_SESSION[CS]['g_bia_email_html']=$html;



    $_SESSION[CS]['g_bia_email_vet']['html'] = $html;
    $_SESSION[CS]['g_bia_email_vet']['protocolo'] = $protocolo;

    return $html;
}

function EnviarEmailBia_dest($idt_atendimento, $destinatario, $email, $htmlcomp) {
    global $vetConf;

    //
    //
    //

    $erro = "";
    //$html = $_SESSION[CS]['g_bia_email_html'];



    $protocolo = $_SESSION[CS]['g_bia_email_vet']['protocolo'];
    $protocolow = substr($protocolo, 2);
    $protocolow = TiraZeroEsq($protocolow);
    $protocolow = 'AT-' . $protocolow;

    //p($_SESSION[CS]['g_bia_email_vet']);

    $html = $_SESSION[CS]['g_bia_email_vet']['html'];
    $complemento_acao = $_SESSION[CS]['g_bia_email_vet']['titulobia'];

    $vetReplace = Array(
        '/sebrae_grc/admin/fckupload/',
        '/sebrae_bia/admin/fckupload/',
    );

    foreach ($vetReplace as $value) {
        $html = str_replace($value, url_pai . $value, $html);
    }

    //$origem_nome   = $_SESSION[CS]['g_nome_completo'];
    $origem_nome = "Sebrae Bahia";
    //guy
    $origem_email = $_SESSION[CS]['g_email'];

    $destino_nome = $destinatario;
    $destino_email = $email;

    $destino_mensagem = "Sr(a) $destinatario, <br /><br />";

    $destino_mensagem .= $html . "<br /><br /> ";
    if ($protocolow == 'AT-0') {
        
    } else {
        $destino_mensagem .= "Protocolo de Atendimento: {$protocolow}. <br /><br />";
    }

    //$destino_mensagem .= "Obrigado, <br /><br />";
    //$destino_mensagem .= "Consultor/Atendente: {$origem_nome}<br />";
    //$destino_mensagem .= "email: {$origem_email}<br />";
    //

    // Para rodape do email 
    $destino_mensagem .= $htmlcomp;

    $msg = $destino_mensagem;
    //
    $de_replay = $vetConf['email_site'];
    $de_email = $vetConf['email_envio'];
    $de_nome = $origem_nome; //$vetConf['email_nome'];

    if ($de_email == '') {
        $de_email = $de_replay;
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

    $mail->IsSMTP();
    $mail->Host = $vetConf['host_smtp'];
    $mail->Port = $vetConf['port_smtp'];
    $mail->Username = $vetConf['login_smtp'];
    $mail->Password = $vetConf['senha_smtp'];
    $mail->SMTPAuth = !($vetConf['login_smtp'] == '' && $vetConf['senha_smtp'] == '');
    $mail->SMTPSecure = $vetConf['smtp_secure'];
    $mail->setFrom($de_email, $de_nome);
    $mail->AddReplyTo($de_replay, $de_nome);

    $mail->Subject = "SEBRAE-BA :: ATENDIMENTO BIA ";
    $mail->msgHTML($msg);

    $mail->AddAddress($destino_email, $destino_nome);
    //p($mail);
    try {

        if ($mail->Send()) {
            $erro = "E-mail Enviado com sucesso!";
            //
            // Gravar Resumo do atendimento
            //
			if ($protocolow != 'AT-0') { // Veio de um atendimento
                // Gravar Atendimento Resumo
                $veio = "EMAIL";
                $idt_acao = 1;
                $idt_pendencia = "";
                //
                $protocolo = $protocolow;
                $assunto = "Envio de EMAIL";
                $link_util = "";
                $bia_conteudo = $mail->Body;
                $bia_enviada = $mail->Body;
                $descricao = "";
                $descricao .= $assunto;
                $vetRetorno = Array();
                $vetRetorno['veio'] = "BIA";
                $vetRetorno['idt_acao'] = $idt_acao;
                $vetRetorno['complemento_acao'] = $complemento_acao;

                $vetRetorno['idt_pendencia'] = $idt_pendencia;
                $vetRetorno['idt_atendimento'] = $idt_atendimento;
                $vetRetorno['descricao'] = $descricao;
                $vetRetorno['link_util'] = $link_util;
                $vetRetorno['bia_conteudo'] = $bia_conteudo;
                $vetRetorno['bia_enviada'] = $bia_enviada;

                $vetRetorno['bia_acao'] = "EMAIL";

                // Gera no Resumo a Pendência		
                $ret = AtendimentoResumo($idt_atendimento, $vetRetorno);
                if ($ret == 0) {
                    
                }
            }
        } else {
            $erro = "Erro na transmissão.\nTente outra vez!\n\n" . trata_aspa($mail->ErrorInfo);
        }
    } catch (Exception $e) {
        echo 'O Sistema encontrou problemas para enviar seu e-mail.\n' . $e->getMessage();
    }

    //
    // enviar email
    //
   
   return $erro;
}

function ImprimeBia($idt_pessoa, $marcados) {
    $html = "";
    return $html;
}

function ImprimeSenhaTOTEM($senha_totem) {
    $html = "";
    $datadiaw = "<span style='font-size:20px;'>" . date('d/m/Y H:i:s') . "</span>";
    $senha_totemw = "<span style='font-size:20px;'>Senha: " . $senha_totem . "</span>";
    $html .= $datadiaw . "<br />";
    $html .= $senha_totemw . "<br />";
    return $html;
}

function BuscaDadosEntidadePIR($cpfcnpj, $tipo, &$vetEntidade, $codparceiro = '', $dadosPesq = Array()) {
    $kokw = 0;
    //
    //  Buscar no Cadastro do PIR
    //
    $vetPIR = Array();
    BuscaEntidadePIR($cpfcnpj, $tipo, $vetPIR, $codparceiro, $dadosPesq);
    $vetEntidade['PIR'][$tipo] = $vetPIR;

    //
    //  Buscar no Cadastro do SIAC-BA
    //
   $kokw = 1;
    return $kokw;
}

function BuscaEntidadePIR($cpfcnpj, $tipo, &$vetret, $codparceiro = '', $dadosPesq = Array()) {
    $kokw = 0;
    //




    $sql = 'select gec_en.* ';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade gec_en ';
    $sql .= " where ";
    $sql .= "       gec_en.codigo        = " . aspa($cpfcnpj);
    $sql .= "   and gec_en.tipo_entidade = " . aspa($tipo);
    $sql .= "   and gec_en.reg_situacao  = " . aspa('A');
    $rs = execsql($sql);




    $temRegistro = false;

    if ($rs->rows == 1) {
        $temRegistro = true;
    }
    // marreta de guy para testar agendamento
    else {
        if ($rs->rows > 1) {
            $temRegistro = true;
        }
    }
    $vetret['existe_entidade_qtd'] = $rs->rows;
    // até aqui

    if (!$temRegistro && $tipo == 'O') {
        $sql = '';
        $sql .= ' select gec_en.*';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade gec_en';
        $sql .= ' left outer join ' . db_pir_gec . 'gec_entidade_organizacao gec_o on gec_o.idt_entidade = gec_en.idt';
        $sql .= " where gec_en.tipo_entidade = " . aspa($tipo);
        $sql .= " and gec_en.reg_situacao  = " . aspa('A');

        $vetSQL = Array();

        if ($dadosPesq['ie_prod_rural'] != '') {
            $vetSQL[] = 'gec_o.ie_prod_rural  = ' . aspa($dadosPesq['ie_prod_rural']);
        }

        if ($dadosPesq['sicab_codigo'] != '') {
            $vetSQL[] = 'gec_o.sicab_codigo  = ' . aspa($dadosPesq['sicab_codigo']);
        }

        if ($dadosPesq['dap'] != '') {
            $vetSQL[] = 'gec_o.dap = ' . aspa($dadosPesq['dap']);
        }

        if ($dadosPesq['rmp'] != '') {
            $vetSQL[] = 'gec_o.rmp = ' . aspa($dadosPesq['rmp']);
        }

        if ($dadosPesq['nirf'] != '') {
            $vetSQL[] = 'gec_o.nirf = ' . aspa($dadosPesq['nirf']);
        }

        if (count($vetSQL) == 0) {
            if ($dadosPesq['razao_social'] != '') {

                $vetSQL[] = 'lower(gec_en.descricao) like lower(' . aspa($dadosPesq['razao_social'], '%', '%') . ')';
            }

            if ($dadosPesq['nome_fantasia'] != '') {
                $vetSQL[] = 'lower(gec_en.resumo) like lower(' . aspa($dadosPesq['nome_fantasia'], '%', '%') . ')';
            }
        }

        $sql .= ' and (';

        if (count($vetSQL) == 0) {
            $sql .= ' 1 = 0 ';
        } else {
            $sql .= implode(' or ', $vetSQL);
        }

        $sql .= ' )';

        $rs = execsql($sql);

        if ($rs->rows == 1) {
            $temRegistro = true;
        }
    }

    if (!$temRegistro && $codparceiro != '') {
        $sql = '';
        $sql .= ' select *';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade';
        $sql .= ' where codigo_siacweb = ' . aspa($codparceiro);
        $sql .= " and tipo_entidade = " . aspa($tipo);
        $sql .= " and reg_situacao  = " . aspa('A');
        $rs = execsql($sql);
    }

    $qtd_entidades = $rs->rows;
    $idt_cliente = "";
    if ($rs->rows != 1) {
        $vetret['existe_entidade'] = "N";
        $vetret['qtd_entidade'] = $qtd_entidades;
        $vetret['cpfcnpj'] = $cpfcnpj;
        $vetret['idt_cliente'] = $idt_cliente;
        // marreta de guy para agendamento
        //return 2;
    }

    ForEach ($rs->data as $row) {
        $idt_entidade = $row['idt'];
        $vetret['existe_entidade'] = "S";
        $vetret['qtd_entidade'] = $qtd_entidade;
        $vetret['idt_entidade'] = $idt_entidade;
        $vetret['excluido_ws'] = $row['excluido_ws'];
        $vetret['dt_ult_alteracao'] = $row['dt_ult_alteracao'];
        $vetret['cpfcnpj'] = $row['codigo'];
        $vetret['idt_cliente'] = $row['idt'];
        $vetret['nome'] = $row['descricao'];
        $vetret['resumo'] = $row['resumo'];
        $vetret['codigo_siacweb'] = $row['codigo_siacweb'];
        $vetret['codigo_prod_rural'] = $row['codigo_prod_rural'];
        $vetret['idt_ult_representante_emp'] = $row['idt_ult_representante_emp'];
        $vetret['representa_codcargcli'] = $row['representa_codcargcli'];
        $vetret['siacweb_situacao'] = $row['siacweb_situacao'];
        $vetret['pa_senha'] = $row['pa_senha'];
        $vetret['pa_idfacebook'] = $row['pa_idfacebook'];

        // funil
        $vetret['funil_idt_cliente_classificacao'] = $row['funil_idt_cliente_classificacao'];
        $vetret['funil_cliente_nota_avaliacao'] = $row['funil_cliente_nota_avaliacao'];
        $vetret['funil_cliente_data_avaliacao'] = $row['funil_cliente_data_avaliacao'];
        $vetret['funil_cliente_obs_avaliacao'] = $row['funil_cliente_obs_avaliacao'];

        $vetret['idt_tipo_empreendimento'] = $row['idt_entidade_tipo_emp'];
        $vetret['receber_informacao'] = $row['receber_informacao'];

        $sql = '';
        $sql .= ' select idt_tipo_informacao';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade_x_tipo_informacao';
        $sql .= ' where idt = ' . null($row['idt']);
        $rstt = execsql($sql);
        $vetret['gec_entidade_x_tipo_informacao'] = $rstt->data;

        // buscar comunicação principal da pessoa
        $vetrowass = Array();
        $vetrowdap = Array();
        $vetrowend = Array();
        $vetrowemp = Array();
        $vetrowpro = Array();
        // Dados próprios da entidade - depende do tipo
        $retass = BuscaDadosAssociadosEntidade($idt_entidade, $tipo, $vetrowass);
        $retdpr = BuscaDadosProprios($idt_entidade, $tipo, $vetrowdap);
        $retend = BuscaEnderecos($idt_entidade, $vetrowend);
        //$retemp = BuscaEmpresas($idt_entidade, $vetrowemp);
        $retpro = BuscaProtocoloMarcacao($idt_entidade, $vetrowpro);
        // Dados associados a entidade
        $vetret['dadosassociados'] = $vetrowass;

        //p($vetret);
        // Dados proprios da entidade
        $vetret['dadosproprios'] = $vetrowdap;
        // Endereços - associadas
        $vetret['enderecos'] = $vetrowend;
        //  p($vetrowend);
        ForEach ($vetrowend as $idx => $Vettrab) {
            $vetendereco = $Vettrab['endereco'];
            $vetrow = $vetendereco['row'];
            //
            // 00 é o principal     99 - do atendimento
            //
            //$vetrow['idt_entidade_endereco_tipo'];
            if ($vetrow['gec_eneet_codigo'] != "00" or $vetrow['gec_eneet_codigo'] != "99") {
                continue;
            }
            $logradouro = $vetrow['logradouro'];
            $logradouro_numero = $vetrow['logradouro_numero'];
            $logradouro_complemento = $vetrow['logradouro_complemento'];
            $logradouro_bairro = $vetrow['logradouro_bairro'];
            $logradouro_municipio = $vetrow['logradouro_municipio'];
            $logradouro_estado = $vetrow['logradouro_estado'];
            $logradouro_pais = $vetrow['logradouro_pais'];
            $logradouro_cep = $vetrow['logradouro_cep'];
            $cep = $vetrow['cep'];
            $vetcomunicacaow = $vetendereco['comunicacao'];
            if (is_array($vetcomunicacaow)) {
                ForEach ($vetcomunicacaow as $idxw => $VetCom) {
                    //p($VetCom);
                    $telefone_1 = $VetCom['comunicacao']['telefone_1'];
                    $telefone_2 = $VetCom['comunicacao']['telefone_2'];
                    $email_1 = $VetCom['comunicacao']['email_1'];
                    $email_2 = $VetCom['comunicacao']['email_2'];
                    $sms_1 = $VetCom['comunicacao']['sms_1'];
                    $sms_2 = $VetCom['comunicacao']['sms_2'];
                }
            }
        }

        if ($vetret['telefone'] == "") {
            $vetret['telefone'] = $telefone_1;
        }
        if ($vetret['celular'] == "") {
            $vetret['celular'] = $telefone_2;
        }
        if ($vetret['email'] == "") {
            $vetret['email'] = $email_1;
        }

        //p($vetret);
        // Protocolos  - associados
        $vetret['protocolos'] = $vetrowpro;
        // empresas - associadas
        $vetret['empresas'] = $vetrowemp;
        $pe = $vetrowemp['PE'];
        $ep = $vetrowemp['EP'];
        //p($pe);
        ForEach ($pe as $idxw => $VetEmp) {
            //p($VetEmp);
            if ($VetEmp['qtdempresas'] > 0) {
                $Vet = $VetEmp['empresas'];
                $cnpj = $Vet['codigo'];
                $nome_empresa = $Vet['descricao'];
            }
        }
        ForEach ($ep as $idxw => $VetEmp) {
            // p($VetEmp);
            if ($VetEmp['qtdempresas'] > 0) {
                $Vet = $VetEmp['empresas'];
                $cnpj = $Vet['codigo'];
                $nome_empresa = $Vet['descricao'];
            }
        }
        if ($vetret['cnpj'] == "") {
            $vetret['cnpj'] = $cnpj;
        }
        if ($vetret['nome_empresa'] == "") {
            $vetret['nome_empresa'] = $nome_empresa;
        }

        // marreta para so pegar 1
        break;
    }
    $kokw = 1;
    return $kokw;
}

function BuscaDadosAssociadosEntidade($idt_entidade, $tipo, &$vetret) {
    $kokw = 0;
    //
    $sql = 'select gec_eai.* ';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade_arquivo_interesse gec_eai ';
    $sql .= " where ";
    $sql .= "       gec_eai.idt_entidade = " . null($idt_entidade);
    $rs = execsql($sql);
    $qtd_arquivos = $rs->rows;
    $idt_cliente = "";
    if ($rs->rows == 0) {
        $vetret['arquivo']['existe_entidade_arquivo'] = "N";
        $vetret['arquivo']['$qtd_arquivos'] = $qtd_entidades;
        $vetret['arquivo']['idt_entidade'] = $idt_entidade;
        return 2;
    }
    ForEach ($rs->data as $row) {
        $idt = $row['idt'];
        $vetret['arquivo']['existe_entidade_arquivo'] = "S";
        // esse é do GEC
        $idt_responsavel = $row['idt_responsavel'];
        // pegar o do GRC
        $idt_responsavel = IdUsuarioPIR($idt_responsavel, db_pir_gec, db_pir_grc);
        $row['idt_responsavel'] = $idt_responsavel;
        $vetret['arquivo'][$idt]['row'] = $row;
    }
    $sql = 'select gec_eti.* ';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade_tema_interesse gec_eti ';
    $sql .= " where ";
    $sql .= "       gec_eti.idt_entidade = " . null($idt_entidade);
    $rs = execsql($sql);
    $qtd_temas = $rs->rows;
    $idt_cliente = "";
    if ($rs->rows == 0) {
        $vetret['tema']['existe_entidade_tema'] = "N";
        $vetret['tema']['$qtd_temas'] = $qtd_entidades;
        $vetret['tema']['idt_entidade'] = $idt_entidade;
        return 2;
    }
    ForEach ($rs->data as $row) {
        $idt = $row['idt'];
        $vetret['tema']['existe_entidade_tema'] = "S";
        // esse é do GEC
        $idt_responsavel = $row['idt_responsavel'];
        // pegar o do GRC
        $idt_responsavel = IdUsuarioPIR($idt_responsavel, db_pir_gec, db_pir_grc);
        $row['idt_responsavel'] = $idt_responsavel;
        $vetret['tema'][$idt]['row'] = $row;
    }
    $sql = 'select gec_epi.* ';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade_produto_interesse gec_epi ';
    $sql .= " where ";
    $sql .= "       gec_epi.idt_entidade = " . null($idt_entidade);
    $rs = execsql($sql);
    $qtd_produtos = $rs->rows;
    $idt_cliente = "";
    if ($rs->rows == 0) {
        $vetret['produto']['existe_entidade_tema'] = "N";
        $vetret['produto']['$qtd_produtos'] = $qtd_entidades;
        $vetret['produto']['idt_entidade'] = $idt_entidade;
        return 2;
    }
    ForEach ($rs->data as $row) {
        $idt = $row['idt'];
        $vetret['produto']['existe_entidade_tema'] = "S";
        // esse é do GEC
        $idt_responsavel = $row['idt_responsavel'];
        // pegar o do GRC
        $idt_responsavel = IdUsuarioPIR($idt_responsavel, db_pir_gec, db_pir_grc);
        $row['idt_responsavel'] = $idt_responsavel;
        $vetret['produto'][$idt]['row'] = $row;
    }
    $kokw = 1;
    return $kokw;
}

function BuscaDadosProprios($idt_entidade, $tipo, &$vetret) {
    $kokw = 0;
    //
    if ($tipo == 'P') {
        $sql = 'select gec_enp.* ';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade_pessoa gec_enp ';
        $sql .= " where ";
        $sql .= "       gec_enp.idt_entidade = " . null($idt_entidade);
        $rs = execsql($sql);
        $qtd_entidades = $rs->rows;
        $idt_cliente = "";
        if ($rs->rows == 0) {
            $vetret['existe_entidade_pessoa'] = "N";
            $vetret['qtd_entidade'] = $qtd_entidades;
            $vetret['idt_entidade'] = $idt_entidade;
            return 2;
        }
        ForEach ($rs->data as $row) {
            $sql = '';
            $sql .= ' select idt_tipo_deficiencia';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade_pessoa_tipo_deficiencia';
            $sql .= ' where idt = ' . null($row['idt']);
            $rstt = execsql($sql);
            $row['gec_entidade_pessoa_tipo_deficiencia'] = $rstt->data;

            $idt_entidade_pessoa = $row['idt'];
            $vetret['existe_entidade_pessoa'] = "S";
            $vetret['row'] = $row;
        }
    } else {
        $sql = 'select gec_eno.* ';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade_organizacao gec_eno ';
        $sql .= " where ";
        $sql .= "       gec_eno.idt_entidade = " . null($idt_entidade);
        $rs = execsql($sql);
        $qtd_entidades = $rs->rows;
        $idt_cliente = "";
        if ($rs->rows == 0) {
            $vetret['existe_entidade_pessoa'] = "N";
            $vetret['tipo_entidade'] = $tipo;
            $vetret['qtd_entidade'] = $qtd_entidades;
            $vetret['idt_entidade'] = $idt_entidade;
            return 2;
        }
        ForEach ($rs->data as $row) {
            $idt_entidade_pessoa = $row['idt'];
            $vetret['tipo_entidade'] = $tipo;
            $vetret['existe_entidade_pessoa'] = "S";
            $vetret['row'] = $row;
        }
    }

    $kokw = 1;
    return $kokw;
}

function BuscaDadosEntidadeSIACBA($cpfcnpj, $tipo, &$vetEntidade, $codparceiro = '') {
    $kokw = 0;
    //
    //  Buscar no SIACBA
    //
    $TipoParceiro = $tipo;
    $CgcCpf = str_replace('-', '', $cpfcnpj);
    $CgcCpf = str_replace('.', '', $CgcCpf);
    $CgcCpf = str_replace('/', '', $CgcCpf);
    /*
      SELECT pais.DescPais, estado.DescEst, estado.AbrevEst, cid.DescCid, bai.descbairro , pa.*, ende.* FROM parceiro pa
      inner join endereco ende on ende.CodParceiro = pa.CodParceiro
      left join pais pais on pais.CodPais = ende.CodPais
      left join estado estado on estado.CodPais = ende.CodPais
      and estado.CodEst = ende.CodEst
      left join cidade cid on cid.CodEst = ende.CodEst
      and cid.CodCid = ende.CodCid
      left join bairro bai on bai.CodCid = ende.CodCid
      and bai.CodBairro = ende.CodBairro
      where pa.CodParceiro = 1249


      41587391287, 'BRASIL', 'Amapá', 'AP', 'MACAPÁ', 'RENASCER', 1249, 'F', 'MARÍLIA DA SILVA CORREIA'



     */
    //
    // Le  Parceiros
    //
   $sql = "select * from " . db_pir_siac . "parceiro as siac_p ";
    if ($tipo == 'F') {
        $sql .= " left outer join " . db_pir_siac . "pessoaf siac_pf on siac_pf.CodParceiro = siac_p.CodParceiro ";
    } else {
        $sql .= " left outer join " . db_pir_siac . "pessoaj siac_pj on siac_pj.CodParceiro = siac_p.CodParceiro ";
    }
    $sql .= "   where TipoParceiro = " . aspa($TipoParceiro);

    if ($CgcCpf == '') {
        $sql .= " and siac_p.CodParceiro = " . null($codparceiro);
    } else {
        $sql .= " and CgcCpf = " . aspa($CgcCpf);
    }

    $rs = execsql($sql);
    $qtd_entidade = 0;
    $idt_cliente = "";

    $vetret = Array();
    $tem_dados = true;

    if ($rs->rows == 0) {
        if ($CgcCpf == '') {
            $migraResultado = migraParceiroSiacWeb('codparceiro', $codparceiro, true, true);
        } else {
            $migraResultado = migraParceiroSiacWeb('cpfcnpj', $CgcCpf, true, true);
        }

        if ($migraResultado) {
            $rs = execsql($sql);
        }

        if ($rs->rows == 0) {
            $tem_dados = false;

            $vetret['existe_entidade'] = "N";
            $vetret['tipo_entidade'] = "N";
            $vetret['qtd_entidade'] = $qtd_entidade;
            $vetret['cpfcnpj'] = $cpfcnpj;
            $vetret['idt_cliente'] = $idt_cliente;
        }
    }

    if ($tem_dados) {
        $qtd_pessoa = $rs->rows;
        ForEach ($rs->data as $row) {
            $idt_siacba = $row['codparceiro'];
            $vetret['existe_entidade'] = "S";
            $vetret['tipo_entidade'] = $row['tipoparceiro'];
            $vetret['qtd_entidade'] = $qtd_entidades;
            $vetret['idt_entidade'] = $idt_siacba;
            $vetret['cpf'] = $row['cgccpf'];
            $vetret['idt_cliente'] = $idt_siacba;
            $vetret['dataatu'] = $row['dataatu'];

            $vetret['codigo_siacweb'] = $idt_siacba;

            // if  ($vetret['nome']=="")
            // {
            $vetret['nomerazaosocial'] = $row['nomerazaosocial'];
            $vetret['nomeabrvfantasia'] = $row['nomeabrvfantasia'];
            $vetret['siacweb_situacao'] = $row['situacao'];
            $vetret['pa_senha'] = '';
            $vetret['pa_idfacebook'] = '';


            if ($tipo == 'F') {  // pessoa
                /*
                  Identidade
                  OrgEmis
                  DataNasc
                  NomeMae
                  CodProfis
                  CodGrauEscol
                  Autonomo
                  CodPais
                  EstCivil
                  Sexo
                  EstadoCivil
                  IndAutonomo
                  ClassificacaoPessoa
                  CodAtividadePF
                 */
                $row['nome_mae'] = $row['nomemae'];
                // tira hora minuto seg
                $vetDN = explode(' ', $row['datanasc']);
                $row['data_nascimento'] = $vetDN[0];
                // Sexo
                if ($row['sexo'] == 1) {   // masculino
                    $row['idt_sexo'] = 5;
                    $row['nome_tratamento'] = "Sr.";
                }
                if ($row['sexo'] == 0) {   // feminino
                    $row['idt_sexo'] = 6;
                    $row['nome_tratamento'] = "Sra.";
                }
                // EstadoCivil     idt_estado_civil
                // CodProfis  ---- idt_profissao
                // CodGrauEscol
                $sqle = "select * from " . db_pir_gec . "gec_entidade_grau_formacao as gec_gf ";
                $sqle .= " where codigo  = " . aspa($row['codgrauescol']);
                $rse = execsql($sqle);
                ForEach ($rse->data as $rowe) {
                    $row['idt_escolaridade'] = $rowe['idt'];
                }

                $sqle = "select * from " . db_pir_gec . "gec_entidade_ativeconpf ";
                $sqle .= " where codigo  = " . aspa($row['codatividadepf']);
                $rse = execsql($sqle);
                ForEach ($rse->data as $rowe) {
                    $row['idt_ativeconpf'] = $rowe['idt'];
                }
            } else {  // empreendimento
            }
            $vetret['dadosproprios']['row'] = $row;
            //
            $sqle = "select * from " . db_pir_siac . "endereco as siac_en ";
            $sqle .= " where CodParceiro  = " . null($idt_siacba);
            $sqle .= " and EndCorresp = 'SIM'";
            $rse = execsql($sqle);
            if ($rse->rows == 0) {
                
            } else {
                $qtd_enderecos = $rse->rows;
                $vetret['endereco'] = $qtd_enderecos;
                $principal = 0;

                ForEach ($rse->data as $rowe) {
                    $idt_siacba = $rowe['codparceiro'];
                    $NumSeqEnd = $rowe['numseqend'];


                    $rowe['logradouro'] = $rowe['descendereco'];
                    $rowe['logradouro_numero'] = $rowe['numero'];
                    $rowe['logradouro_complemento'] = $rowe['complemento'];
                    //
                    $CodBairro = $rowe['codbairro'];
                    $CodCid = $rowe['codcid'];
                    $CodEst = $rowe['codest'];
                    $CodPais = $rowe['codpais'];
                    // Pais
                    $sqlt = "select * from " . db_pir_siac . "pais as siac_pa ";
                    $sqlt .= " where CodPais    = " . null($CodPais);
                    $rst = execsql($sqlt);
                    $logradouro_pais = "";
                    ForEach ($rst->data as $rowt) {
                        $logradouro_pais = $rowt['descpais'];
                    }
                    // Estado
                    $sqlt = "select * from " . db_pir_siac . "estado as siac_es ";
                    $sqlt .= " where CodPais   = " . null($CodPais);
                    $sqlt .= "   and CodEst    = " . null($CodEst);
                    $rst = execsql($sqlt);
                    $logradouro_estado = "";
                    $codigo_estado = "";
                    ForEach ($rst->data as $rowt) {
                        $logradouro_estado = $rowt['descest'];
                        $codigo_estado = $rowt['abrevest'];
                    }
                    // Município
                    $sqlt = "select * from " . db_pir_siac . "cidade as siac_ci ";
                    $sqlt .= " where CodEst    = " . null($CodEst);
                    $sqlt .= "   and CodCid    = " . null($CodCid);
                    $rst = execsql($sqlt);
                    $logradouro_municipio = "";
                    ForEach ($rst->data as $rowt) {
                        $logradouro_municipio = $rowt['desccid'];
                    }
                    //
                    $sqlt = "select * from " . db_pir_siac . "bairro as siac_en ";
                    $sqlt .= " where CodCid     = " . null($CodCid);
                    $sqlt .= "   and CodBairro  = " . null($CodBairro);
                    $rst = execsql($sqlt);
                    $logradouro_bairro = "";
                    ForEach ($rst->data as $rowt) {
                        $logradouro_bairro = $rowt['descbairro'];
                    }
                    $rowe['logradouro_bairro'] = $logradouro_bairro;
                    $rowe['logradouro_municipio'] = $logradouro_municipio;
                    $rowe['logradouro_estado'] = $codigo_estado;
                    $rowe['logradouro_pais'] = $logradouro_pais;

                    $rowe['logradouro_codbairro'] = $rowe['codbairro'];
                    $rowe['logradouro_codcid'] = $rowe['codcid'];
                    $rowe['logradouro_codest'] = $rowe['codest'];
                    $rowe['logradouro_codpais'] = $rowe['codpais'];

                    $rowe['logradouro_cep'] = substr($rowe['cep'], 0, 5) . '-' . substr($rowe['cep'], 5, 3);
                    $rowe['cep'] = $rowe['logradouro_cep'];
                    //
                    $rowe['idt_pais'] = "";
                    $rowe['idt_estado'] = "";
                    $rowe['idt_cidade'] = "";

                    $principal = $principal + 1;

                    //if ($principal == 1) {
                    //
                    // Se achar um com correspondencia = sim é ele senão vai assumir o último....
                    //
                    
                    if ($rowe['endcoresp'] == 'SIM') {
                        $rowe['gec_eneet_codigo'] = '00';
                        $vetret['enderecos']['row'] = $rowe;
                        break;
                    } else {
                        $rowe['gec_eneet_codigo'] = '00';
                        $vetret['enderecos']['row'] = $rowe;
                    }
                }
            }
            // comunicação
            $sqle = "select * from " . db_pir_siac . "comunicacao as siac_co ";
            $sqle .= " where CodParceiro  = " . null($idt_siacba);
            $rse = execsql($sqle);
            if ($rse->rows == 0) {
                
            } else {
                $qtd_comunicacao = $rse->rows;
                $vetret['comunicacao']['qtd'] = $qtd_comunicacao;
                $principal = 0;
                $vetSIAC = Array();
                $vetSIAC[1] = 'TELEFONE';
                $vetSIAC[2] = 'FAX';
                $vetSIAC[3] = 'TELEX';
                $vetSIAC[4] = 'URL';
                $vetSIAC[5] = 'TELEFONE CELULAR';
                $vetSIAC[6] = 'TELEFONE COMERCIAL';
                $vetSIAC[11] = 'PÚBLICO';
                $vetSIAC[12] = 'TELEFONE COMUNITÁRIO';
                $vetSIAC[21] = 'TELEFONE RECADO';
                $vetSIAC[22] = 'TELEFONE INTERNACIONAL';
                $vetSIAC[25] = 'E-MAIL';
                $vetSIAC[35] = 'CAIXA POSTAL';
                $vetSIAC[36] = 'BIP';
                $vetSIAC[37] = 'POSTO DE SERVIÇO';
                $vetSIAC[38] = 'Endereço de Correspondência';
                $vetSIAC[39] = 'RAMAL';
                $vetSIAC[40] = 'ANDAR';
                //
                $vetComunicacao = Array();
                //
//             $telefone_residencial     = $vetcomunicacao['telefone_1_p'];
//             $telefone_celular         = $vetcomunicacao['telefone_2_p'];
//             $email                    = $vetcomunicacao['email_1_p'];
//             $sms                      = $vetcomunicacao['sms_1_p'];
                ForEach ($rse->data as $rowe) {
                    $codcomunic = $rowe['codcomunic'];
                    $numero = $rowe['numero'];
                    $IndInternet = $rowe['indinternet'];

                    if ($tipo == 'F') {
                        if ($codcomunic == 1) {  // residencial
                            $numero = AjustaTelefoneSiacWEB($numero);
                            $vetComunicacao['telefone_1_p'] = $numero;
                        }
                    } else {
                        if ($codcomunic == 6) {  // residencial
                            $numero = AjustaTelefoneSiacWEB($numero);
                            $vetComunicacao['telefone_1_p'] = $numero;
                        }
                    }

                    if ($codcomunic == 5) {  // celular
                        $numero = AjustaTelefoneSiacWEB($numero);
                        $vetComunicacao['telefone_2_p'] = $numero;
                    }

                    if ($codcomunic == 21) {   // recado
                        $numero = AjustaTelefoneSiacWEB($numero);
                        $vetComunicacao['telefone_3_p'] = $numero;
                    }

                    if ($codcomunic == 25) {
                        $vetComunicacao['email_1_p'] = $numero;
                    }

                    if ($codcomunic == 4) {
                        $vetComunicacao['www_1_p'] = $numero;
                    }
                }
                $vetret['comunicacao']['row'] = $vetComunicacao;
            }
        }
    }

    $vetEntidade['SIACBA'][$tipo] = $vetret;
    $kokw = 1;
    return $kokw;
}

//
//
//
function BuscaDadosEntidadeSIACNA($CgcCpf, $tipo, &$vetEntidade) {
    $kokw = 0;
    //
    //  Buscar no SIACBA
    //
   // $TipoParceiro  = "F";
    // $CgcCpf        = str_replace('-','',$cpf);
    // $CgcCpf        = str_replace('.','',$CgcCpf);
    // $CgcCpf        = str_replace('.','',$CgcCpf);
    //
   //  Le  Parceiros
    //
   $sql = "select * from db_pir.bc_mei as bc_siac ";
    $sql .= " where ";
    $sql .= "     C       = " . aspa($CgcCpf);
    $rs = execsql($sql);
    $qtd_pessoa = 0;
    $idt_cliente = "";
    $vetret = Array();
    if ($rs->rows == 0) {
        $vetret['existe_entidade'] = "N";
        $vetret['tipo_entidade'] = "J";
        $vetret['qtd_entidade'] = $qtd_entidades;
        $vetret['cpf'] = $CgcCpf;
        $vetret['idt_cliente'] = $idt_cliente;
    } else {
        $qtd_pessoa = $rs->rows;
        ForEach ($rs->data as $row) {
            $idt_siacna = $row['idt'];
            $vetret['tipo_entidade'] = "J";
            $vetret['existe_entidade'] = "S";
            $vetret['qtd_entidade'] = $qtd_entidades;
            $vetret['idt_entidade'] = $idt_siacba;
            $vetret['cpf'] = $$CgcCpf;
            $vetret['idt_cliente'] = $idt_siacna;
            //
            $vetret['E'] = $row['E'];
            $vetret['F'] = $row['F'];
        }
    }
    $vetEntidade['SIACNA'][$tipo] = $vetret;
    $kokw = 1;
    return $kokw;
}

//
//  Buscar no MEI
//

function BuscaDadosEntidadeMEI($cpfcnpj, $tipo, &$vetEntidade) {
    $kokw = 0;
    $CgcCpf = str_replace('-', '', $cpfcnpj);
    $CgcCpf = str_replace('/', '', $CgcCpf);
    $CgcCpf = str_replace('.', '', $CgcCpf);
    //
    //  Le  Base do MEI
    //
   $sql = "select bc_mei.* from db_pir.bc_mei as bc_mei ";
    $sql .= " where ";
    $sql .= "    G  = " . aspa($CgcCpf);
    $rs = execsql($sql);
    $qtd_entidades = 0;
    $idt_cliente = "";
    $vetret = Array();
    if ($rs->rows == 0) {
        $vetret['existe_entidade'] = "N";
        $vetret['tipo_entidade'] = "F";
        $vetret['qtd_entidade'] = $qtd_entidades;
        $vetret['cpfcnpj'] = $cpfcnpj;
        $vetret['idt_cliente'] = $idt_cliente;
    } else {
        $qtd_entidades = $rs->rows;
        ForEach ($rs->data as $row) {
            $idt_mei = $row['idt'];
            $vetret['tipo_entidade'] = "F";
            $vetret['existe_entidade'] = "S";
            $vetret['qtd_entidade'] = $qtd_entidades;
            $vetret['idt_entidade'] = $idt_mei;
            $vetret['cpfcnpj'] = $cpfcnpj;
            $vetret['idt_cliente'] = $idt_mei;

            // if  ($vetret['nome']=="")
            // {
            $vetret['nome'] = $row['i'];
        }
    }
    $vetEntidade['MEI'][$tipo] = $vetret;
    $kokw = 1;
    return $kokw;
}

//
//  Buscar no Receita Federal
//

function BuscaDadosEntidadeRF($CgcCpf, $tipo, &$vetEntidade) {
    $kokw = 0;

    if (validaCNPJ($_POST['cnpj'])) {
        $CgcCpf = FormataCNPJ($_POST['cnpj']);
    } else {
        $CgcCpf = '';
    }

    $sql = "select bc_rf.* from db_pir.bc_rf_2015 as bc_rf ";
    $sql .= " where ";
    $sql .= "    cnpj  = " . aspa($CgcCpf);
    $rs = execsql($sql);
    $qtd_entidades = 0;
    $idt_cliente = "";
    $vetret = Array();
    if ($rs->rows == 0) {
        $vetret['existe_entidade'] = "N";
        $vetret['tipo_entidade'] = "J";
        $vetret['qtd_entidade'] = $qtd_entidades;
        $vetret['cpfcnpj'] = $CgcCpf;
        $vetret['idt_cliente'] = $idt_cliente;
    } else {
        $qtd_entidades = $rs->rows;
        ForEach ($rs->data as $row) {
            $telefone = '';

            if ($telefone == '') {
                $telefone = $row['telefone_siac2015'];
            }

            if ($telefone == '') {
                $telefone = $row['telefone_zipcode'];
            }

            if ($telefone == '') {
                $telefone = $row['telefone_rfb'];
            }

            if ($telefone == '') {
                $telefone = $row['telefone_mei2015'];
            }

            $telefone = formata_telefone($telefone);

            if (!valida_telefone($telefone)) {
                $telefone = '';
            }

            $celular = '';

            if ($celular == '') {
                $celular = $row['telefone_siac2015_celular'];
            }

            if ($celular == '') {
                $celular = $row['telefone_zipcode_celular'];
            }

            $celular = formata_telefone($celular);

            if (!valida_telefone($celular)) {
                $celular = '';
            }

            $email = '';

            if ($email == '') {
                $email = $row['email_siac2015'];
            }

            if ($email == '') {
                $email = $row['email_mei2015'];
            }

            if (!valida_email($email)) {
                $email = '';
            }

            $porteCod = '';

            if ($porteCod == '') {
                $porteCod = $row['porte_siac_2015_cod'];
            }

            if ($porteCod == '') {
                $porteCod = $row['porte_cse_2015_cod'];
            }

            if ($porteCod == '') {
                $porteCod = $row['porte_cse_2014_cod'];
            }

            if ($porteCod == '') {
                $porteCod = $row['porte_cse_2013_cod'];
            }

            if ($porteCod == '') {
                $porteCod = $row['porte_cse_2012_cod'];
            }

            if ($porteCod == '') {
                $porteCod = $row['porte_cse_2011_cod'];
            }

            if ($porteCod == '') {
                $porteCod = $row['porte_cse_2010_cod'];
            }

            $simples_nacional = '';

            if ($simples_nacional == '') {
                $simples_nacional = $row['opcao_pelo_simples_2015'];
            }

            if ($simples_nacional == '') {
                $simples_nacional = $row['opcao_pelo_simples_2014'];
            }

            if ($simples_nacional == '') {
                $simples_nacional = $row['opcao_pelo_simples_2013'];
            }

            if ($simples_nacional == '') {
                $simples_nacional = $row['opcao_pelo_simples_2012'];
            }

            if ($simples_nacional == '') {
                $simples_nacional = $row['opcao_pelo_simples_2011'];
            }

            if ($simples_nacional == '') {
                $simples_nacional = $row['opcao_pelo_simples_2010'];
            }

            $pessoas_ocupadas = '';

            if ($pessoas_ocupadas == '') {
                $pessoas_ocupadas = $row['empregados_2013_rais'];
            }

            if ($pessoas_ocupadas == '') {
                $pessoas_ocupadas = $row['empregados_2012_rais'];
            }

            if ($pessoas_ocupadas == '') {
                $pessoas_ocupadas = $row['empregados_2011_rais'];
            }

            if ($pessoas_ocupadas == '') {
                $pessoas_ocupadas = $row['empregados_2010_rais'];
            }

            $vetret['existe_entidade'] = "S";
            $vetret['qtd_entidade'] = $qtd_entidades;
            $vetret['idt_entidade'] = $row['idt'];
            $vetret['cpfcnpj'] = $CgcCpf;
            $vetret['idt_cliente'] = $row['idt'];

            $vetret['nome'] = $row['razao_social'];
            $vetret['telefone'] = $telefone;
            $vetret['celular'] = $celular;
            $vetret['email'] = $email;
            $vetret['cnpj'] = $row['cnpj'];
            $vetret['nome_empresa'] = $row['nome_fantasia'];
            $vetret['codigo_siacweb_e'] = '';
            $vetret['cnpj_e'] = $row['cnpj'];
            $vetret['razao_social_e'] = $row['razao_social'];
            $vetret['nome_fantasia_e'] = $row['nome_fantasia'];
            $vetret['receber_informacao_e'] = 'N';
            $vetret['inscricao_estadual_e'] = '';
            $vetret['inscricao_municipal_e'] = '';
            $vetret['data_abertura_e'] = substr($row['data_de_abertura'], 0, 4) . '-' . substr($row['data_de_abertura'], 4, 2) . '-' . substr($row['data_de_abertura'], 6, 2);

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade_tipo_emp';
            $sql .= ' where codigo = 99';
            $rstt = execsql($sql);
            $vetret['idt_tipo_empreendimento_e'] = $rstt->data[0][0];

            $vetret['pessoas_ocupadas_e'] = $pessoas_ocupadas;

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir_gec . 'gec_organizacao_porte';
            $sql .= ' where codigo = ' . aspa($porteCod);
            $rstt = execsql($sql);
            $vetret['idt_porte_e'] = $rstt->data[0][0];

            if ($simples_nacional == 'Sim') {
                $vetret['simples_nacional_e'] = 'S';
            } else {
                $vetret['simples_nacional_e'] = 'N';
            }

            $vetret['dap_e'] = '';
            $vetret['nirf_e'] = '';
            $vetret['ie_prod_rural_e'] = '';
            $vetret['sicab_codigo'] = '';
            $vetret['sicab_dt_validade'] = '';
            $vetret['data_fim_atividade'] = '';
            $vetret['siacweb_situacao'] = '';
            $vetret['pa_senha'] = '';
            $vetret['pa_idfacebook'] = '';
            $vetret['tamanho_propriedade_e'] = '';
            $vetret['rmp_e'] = '';

            $vetret['idt_cnae_principal_e'] = $row['cnae_subclasse'];

            $sql = '';
            $sql .= ' select c.idt_entidade_setor';
            $sql .= ' from ' . db_pir_gec . 'cnae c';
            $sql .= ' where c.codclass_siacweb = 1';
            $sql .= ' and c.subclasse = ' . aspa($row['cnae_subclasse']);
            $rstt = execsql($sql);
            $vetret['idt_setor_e'] = $rstt->data[0][0];

            $vetret['telefone_comercial_e'] = $telefone;
            $vetret['telefone_celular_e'] = $celular;
            $vetret['sms_e'] = $celular;
            $vetret['email_e'] = $email;
            $vetret['site_url_e'] = '';

            $cep = $row['endereco_cep'];
            $cep = str_replace('.', '', $cep);
            $cep = str_replace('-', '', $cep);

            $sql = '';
            $sql .= ' select *';
            $sql .= ' from ' . db_pir_gec . 'base_cep';
            $sql .= ' where cep = ' . aspa($cep);
            $sql .= ' and cep_situacao = 1';
            $rstt = execsql($sql);
            $rowtt = $rstt->data[0];

            switch ($rowtt['ceptipo']) {
                case 'LOC':
                    $rowtt['logradouro'] = $row['endereco_logradouro'];
                    break;
            }

            $vetret['logradouro_e'] = $rowtt['logradouro'];
            $vetret['logradouro_numero_e'] = $row['endereco_numero'];
            $vetret['logradouro_complemento_e'] = $row['endereco_complemento'];
            $vetret['logradouro_bairro_e'] = $rowtt['bairro'];
            $vetret['logradouro_municipio_e'] = $rowtt['cidade'];
            $vetret['logradouro_estado_e'] = $rowtt['uf_sigla'];
            $vetret['logradouro_pais_e'] = $rowtt['pais_nome'];
            $vetret['logradouro_codbairro_e'] = $rowtt['codbairro'];
            $vetret['logradouro_codcid_e'] = $rowtt['codcid'];
            $vetret['logradouro_codest_e'] = $rowtt['codest'];
            $vetret['logradouro_codpais_e'] = $rowtt['codpais'];
            $vetret['cep_e'] = FormatCEP($rowtt['cep']);
            $vetret['idt_pais_e'] = '';
            $vetret['idt_estado_e'] = '';
            $vetret['idt_cidade_e'] = '';
        }
    }

    $vetEntidade['RF'][$tipo] = $vetret;
    $kokw = 1;
    return $kokw;
}

function SalvarPendencia($idt_atendimentow, $data_solucaow, $observacaow) {
    $kokw = 0;
    $idt_usuario = $_SESSION[CS]['g_id_usuario'];
    $datadia = date('d/m/Y H:i:s');
    $data = aspa(trata_data($datadia));
    $idt_atendimento = $idt_atendimentow;
    $data_solucao = aspa(trata_data($data_solucaow));
    $observacao = aspa($observacaow);


    //
    $sql_i = ' insert into grc_atendimento_pendencia ';
    $sql_i .= ' (  ';
    $sql_i .= " idt_atendimento, ";
    $sql_i .= " idt_usuario, ";
    $sql_i .= " data, ";
    $sql_i .= " data_solucao, ";
    $sql_i .= " observacao ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $idt_atendimento, ";
    $sql_i .= " $idt_usuario, ";
    $sql_i .= " $data, ";
    $sql_i .= " $data_solucao, ";
    $sql_i .= " $observacao ";
    $sql_i .= ') ';
    $result = execsql($sql_i);
    //$idt_atendimento = lastInsertId();

    $kokw = 1;
    return $kokw;
}

function GeraComplementoPendencia($idt_atendimento_pendencia, $idt_atendimento) {
    $idt_cliente = 0;
    $idt_pessoa = 0;
    $idt_ponto_atendimento = 0;
    $sql = "select grc_a.* from grc_atendimento grc_a ";
    $sql .= " where ";
    $sql .= "    idt  =  " . null($idt_atendimento);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $idt_pessoa = $row['idt_pessoa'];
        $idt_cliente = $row['idt_cliente'];
        $protocolo = $row['protocolo'];
        $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
    }
    $sql = "select grc_ap.* from grc_atendimento_pessoa grc_ap ";
    $sql .= " where ";
    $sql .= "    idt  =  " . null($idt_pessoa);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo_pf = $row['cpf'];
        $nome_pf = $row['nome'];
        $codigo_siacweb_pf = $row['codigo_siacweb'];
    }
    if ($idt_cliente > 0) {
        $sql = "select grc_ao.* from grc_atendimento_organizacao grc_ao ";
        $sql .= " where ";
        $sql .= "    idt  =  " . null($idt_cliente);
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $codigo_pj = $row['cnpj'];
            $nome_pj = $row['razao_social'];
            $codigo_siacweb_pj = $row['codigo_siacweb_e'];
        }
    }

    $cpf = aspa($codigo_pf);
    $nome_cliente = aspa($nome_pf);
    $cod_cliente_siac = aspa($codigo_siacweb_pf);

    $cnpj = aspa($codigo_pj);
    $nome_empreendimento = aspa($nome_pj);
    $cod_empreendimento_siac = aspa($codigo_siacweb_pj);
    $protocolo = aspa($protocolo);

    //
    // agora dar update 
    //
/*
      function email_pendencias($vetEmail) {
      global $vetConf;

      $origem_nome      = $vetEmail['origem_nome'];
      $origem_email     = $vetEmail['origem_email'];
      $destino_nome     = $vetEmail['destino_nome'];
      $destino_email    = $vetEmail['destino_email'];
      $destino_mensagem = $vetEmail['destino_mensagem'];
     */

    $sql_a = " update grc_atendimento_pendencia set ";
    $sql_a .= " idt_ponto_atendimento = $idt_ponto_atendimento, ";
    $sql_a .= " protocolo        = $protocolo, ";
    $sql_a .= " cpf              = $cpf, ";
    $sql_a .= " nome_cliente     = $nome_cliente, ";
    $sql_a .= " cod_cliente_siac = $cod_cliente_siac, ";

    $sql_a .= " cnpj                    = $cnpj, ";
    $sql_a .= " nome_empreendimento     = $nome_empreendimento, ";
    $sql_a .= " cod_empreendimento_siac = $cod_empreendimento_siac ";
    $sql_a .= " where idt = " . null($idt_atendimento_pendencia);
    $result = execsql($sql_a);
}

function SalvarInstrumento($idt_atendimento, $idt_troca_instrumento) {
    $kokw = 0;
    $sql_a = " update grc_atendimento set ";
    $sql_a .= " idt_instrumento = $idt_troca_instrumento ";
    $sql_a .= " where idt = " . null($idt_atendimento);
    $result = execsql($sql_a);
    $kokw = 1;
    return $kokw;
}

function SalvarTemaInteresse($idt_atendimentow, $idt_tema_interessew) {
    $kokw = 0;
    $idt_atendimento = $idt_atendimentow;
    $idt_tema = $idt_tema_interessew;
    $idt_sub_tema = 'null';
    //
    // Busca Tema
    //
   $nome_temaw = "";
    $sql = "select grc_ts.* from grc_tema_subtema grc_ts ";
    $sql .= " where ";
    $sql .= "    idt  =  " . null($idt_tema);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $nome_temaw = $row['descricao'];
    }
    $nome_sub_temaw = "";
    $sql = "select grc_ts.* from grc_tema_subtema grc_ts ";
    $sql .= " where ";
    $sql .= "    idt  =  " . null($idt_sub_tema);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $nome_sub_temaw = $row['descricao'];
    }

    $nome_tema = aspa($nome_temaw);
    $nome_sub_tema = aspa($nome_sub_temaw);
    $tipo_tratamento = aspa('I');


    $sql = "select grc_at.idt from grc_atendimento_tema grc_at ";
    $sql .= " where ";
    $sql .= "       idt_atendimento     =  " . null($idt_atendimento);
    $sql .= "  and  idt_tema         =  " . null($idt_tema);
    $sql .= "  and  idt_sub_tema   is null ";
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $sql_i = ' insert into grc_atendimento_tema ';
        $sql_i .= ' (  ';
        $sql_i .= " idt_atendimento, ";
        $sql_i .= " idt_tema, ";
        $sql_i .= " idt_sub_tema, ";
        $sql_i .= " nome_tema, ";
        $sql_i .= " nome_sub_tema, ";
        $sql_i .= " tipo_tratamento ";
        $sql_i .= '  ) values ( ';
        $sql_i .= " $idt_atendimento, ";
        $sql_i .= " $idt_tema, ";
        $sql_i .= " $idt_sub_tema, ";
        $sql_i .= " $nome_tema, ";
        $sql_i .= " $nome_sub_tema, ";
        $sql_i .= " $tipo_tratamento ";
        $sql_i .= ') ';
        $result = execsql($sql_i);
        //$idt_atendimento = lastInsertId();
    }
    $kokw = 1;
    return $kokw;
}

function SalvarTemaTratado($idt_atendimentow, $idt_tema_tratadow, $idt_subtema_tratadow) {
    $kokw = 0;
    $idt_atendimento = $idt_atendimentow;
    $idt_tema = $idt_tema_tratadow;
    $idt_sub_tema = $idt_subtema_tratadow;
    //
    // Busca Tema
    //
   $nome_temaw = "";
    $sql = "select grc_ts.* from grc_tema_subtema grc_ts ";
    $sql .= " where ";
    $sql .= "    idt  =  " . null($idt_tema);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $nome_temaw = $row['descricao'];
    }
    $nome_sub_temaw = "";
    $sql = "select grc_ts.* from grc_tema_subtema grc_ts ";
    $sql .= " where ";
    $sql .= "    idt  =  " . null($idt_sub_tema);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $nome_sub_temaw = $row['descricao'];
    }
    $nome_tema = aspa($nome_temaw);
    $nome_sub_tema = aspa($nome_sub_temaw);
    $tipo_tratamento = aspa('T');
    //
    $sql = "select grc_at.idt from grc_atendimento_tema grc_at ";
    $sql .= " where ";
    $sql .= "       idt_atendimento  =  " . null($idt_atendimento);
    $sql .= "  and  idt_tema         =  " . null($idt_tema);
    $sql .= "  and  idt_sub_tema     =  " . null($idt_sub_tema);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $sql_i = ' insert into grc_atendimento_tema ';
        $sql_i .= ' (  ';
        $sql_i .= " idt_atendimento, ";
        $sql_i .= " idt_tema, ";
        $sql_i .= " idt_sub_tema, ";
        $sql_i .= " nome_tema, ";
        $sql_i .= " nome_sub_tema, ";
        $sql_i .= " tipo_tratamento ";
        $sql_i .= '  ) values ( ';
        $sql_i .= " $idt_atendimento, ";
        $sql_i .= " $idt_tema, ";
        $sql_i .= " $idt_sub_tema, ";
        $sql_i .= " $nome_tema, ";
        $sql_i .= " $nome_sub_tema, ";
        $sql_i .= " $tipo_tratamento ";
        $sql_i .= ') ';
        $result = execsql($sql_i);
        //$idt_atendimento = lastInsertId();
    }
    $kokw = 1;
    return $kokw;
}

function GerarAgendaDisponibilidade() {
    $kokw = 0;
    //
    $kokw = 1;
    return $kokw;
}

function numParte() {
    global $numParte;

    return ZeroEsq($numParte++, 2);
}

function CancelarChamada($idt_atendimento_agenda, &$variavel) {
    if ($_SESSION[CS]['g_idt_projeto'] == '' || $_SESSION[CS]['g_idt_acao'] == '') {
        die('O Projeto e Ação devem estar informado no usuário para poder fazer um atendimento!');
    }

    $kokw = 0;
    $sql_aa = ' select idt, idt_consultor from grc_atendimento_agenda ';
    $sql_aa .= ' where  idt = ' . null($idt_atendimento_agenda);
    $result = execsql($sql_aa);
    if ($result->rows != 1) {
        return 2;
    } else {

        $idt_consultor = '';
        $idt_atendimento_agenda = '';
        ForEach ($result->data as $row) {
            $idt_atendimento_agenda = $row['idt'];
            $idt_consultor = $row['idt_consultor'];
        }
    }

    beginTransaction();
    set_time_limit(30);


    if ($idt_consultor == '') {
        $idt_consultor = $_SESSION[CS]['g_id_usuario'];
    }
    $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
    $idt_projeto = $_SESSION[CS]['g_idt_projeto'];
    $idt_projeto_acao = $_SESSION[CS]['g_idt_acao'];
    $gestor_sge = aspa($_SESSION[CS]['g_projeto_gestor']);
    $fase_acao_projeto = aspa($_SESSION[CS]['g_projeto_etapa']);


    $sql = '';
    $sql .= ' select data';
    $sql .= ' from grc_atendimento';
    $sql .= " where idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
    $rs = execsql($sql);
    $idt_competencia = idtCompetencia(trata_data($rs->data[0][0]));


    if ($idt_consultor == '') {
        $idt_consultor = $_SESSION[CS]['g_id_usuario'];
    }
    $idt_ponto_atendimento = 'null';
    $idt_projeto = 'null';
    $idt_projeto_acao = 'null';
    $gestor_sge = aspa('');
    $fase_acao_projeto = aspa('');


    $sql_a = " update grc_atendimento set ";
    $sql_a .= " idt_consultor         = $idt_consultor, ";
    //$sql_a .= " idt_ponto_atendimento = $idt_ponto_atendimento, ";

    $sql_a .= " idt_competencia       = $idt_competencia, ";

    $sql_a .= " idt_projeto           = $idt_projeto, ";
    $sql_a .= " idt_projeto_acao      = $idt_projeto_acao, ";
    $sql_a .= " gestor_sge            = $gestor_sge, ";
    $sql_a .= " fase_acao_projeto     = $fase_acao_projeto ";
    $sql_a .= " where idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);


    $datadiaw = (date('d/m/Y H:i:s'));
    $segundo = true;
    $datadia = aspa(trata_data($datadiaw, $segundo));


    $idt_atendimento_box = 'null';
    $vet = explode(' ', $datadiaw);
    $hora = aspa(substr($vet[1], 0, 5));


    $datadia = aspa('');
    /*
      $sql_a  = " update grc_atendimento_agenda set ";
      $sql_a .= " hora_atendimento = ".$hora ;
      $sql_a .= " where idt = ".null($idt_atendimento_agenda);
      $result = execsql($sql_a);
     */

    // 33 é segubda chamada

    $sql_a = " update grc_atendimento_agenda_painel set ";
    $sql_a .= " status_painel = '33', ";
    $sql_a .= " idt_atendimento_box = $idt_atendimento_box, ";
    $sql_a .= " idt_consultor       = $idt_consultor, ";
    $sql_a .= " data_hora_chamada   = " . $datadia;
    $sql_a .= " where idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
    $result = execsql($sql_a);
    commit();
    $kokw = 1;
    return $kokw;
}

function BuscaCPF($idt_atendimento, &$variavel) {
    global $vetSistemaUtiliza, $vetTipoVoucherCodIDT;

    $idt_entidade_pj = '';

    $kokw = 0;
    $cpf = $variavel['cpf'];
    $cnpj = $variavel['cnpj'];
    $idt_instrumento = $variavel['idt_instrumento'];

    $idt_atendimento_agenda = $variavel['idt_atendimento_agenda'];

    $variavel['idt_atendimento'] = $idt_atendimento;

    if ($variavel['id_usuario'] == '') {
        $variavel['id_usuario'] = $_SESSION[CS]['g_id_usuario'];
    }

    $cpf_w = $variavel['cpf'];
    $cnpj_w = $variavel['$cnpj'];

    if ($variavel['bancoTransaction'] != 'N') {
        beginTransaction();
    }

    if ($variavel['idt_instrumento'] == 54) {
        $sql = '';
        $sql .= ' select ec.idt, ec.idt_evento, ec.qtd_vaga, e.codigo, e.descricao';
        $sql .= ' from grc_evento_combo ec';
        $sql .= ' left outer join grc_evento e on e.idt = ec.idt_evento';
        $sql .= " where ec.idt_evento_origem = " . null($variavel['idt_evento']);
        $sql .= " and ec.matricula_obr = 'S'";
        $rs = execsql($sql, false);

        $erro = Array();

        foreach ($rs->data as $rowEC) {
            if ($rowEC['qtd_vaga'] <= 0) {
                $erro[] = $rowEC['codigo'] . ' - ' . $rowEC['descricao'];
            } else {
                if ($idt_atendimento == 0) {
                    $sql = "update grc_evento_combo set qtd_utilizada = qtd_utilizada + 1, qtd_vaga = qtd_vaga - 1";
                    $sql .= " where idt = " . null($rowEC['idt']);
                    execsql($sql, false);

                    $sql = "update grc_evento set qtd_vagas_resevado = qtd_vagas_resevado + 1, qtd_vagas_bloqueadas = qtd_vagas_bloqueadas - 1";
                    $sql .= " where idt = " . null($rowEC['idt_evento']);
                    execsql($sql, false);
                }

                $sql = '';
                $sql .= ' select quantidade_participante + qtd_vagas_adicional + qtd_vagas_extra as qtd, qtd_matriculado_siacweb + qtd_vagas_resevado + qtd_vagas_bloqueadas as tot';
                $sql .= ' from grc_evento';
                $sql .= " where idt = " . null($rowEC['idt_evento']);
                $rsVaga = execsql($sql, false);
                $rowVaga = $rsVaga->data[0];

                if ($rowVaga['tot'] > $rowVaga['qtd']) {
                    $erro[] = $rowEC['codigo'] . ' - ' . $rowEC['descricao'];
                }
            }
        }

        if (count($erro) > 0) {
            $msg = "Não tem mais vaga disponível nos Eventos a baixos:\n\n";
            $msg .= implode("\n", $erro);
            $variavel['idt_atendimento_pessoa'] = $msg;
            $variavel['idt_atendimento_agenda'] = $msg;

            if ($variavel['bancoTransaction'] != 'N') {
                rollBack();
            }

            return $kokw;
        }
    } else {
        if ($variavel['idt_evento'] != '' && $variavel['evento_origem'] != 'SIACWEB' && $variavel['valida_vaga'] != 'N') {
            if ($variavel['filadeespera'] == 'S') {
                $sql = '';
                $sql .= ' select quantidade_participante as qtd, qtd_matriculado_siacweb + qtd_vagas_resevado + qtd_vagas_bloqueadas as tot';
                $sql .= ' from grc_evento';
                $sql .= " where idt = " . null($variavel['idt_evento']);
                $rsVaga = execsql($sql);
                $rowVaga = $rsVaga->data[0];

                if ($rowVaga['qtd'] != '') {
                    if ($rowVaga['tot'] < $rowVaga['qtd']) {
                        $msg = 'Não pode fazer a inscrição na Fila de Espera, pois o Evento ainda tem mais vagas disponíveis!';
                        $variavel['idt_atendimento_pessoa'] = $msg;
                        $variavel['idt_atendimento_agenda'] = $msg;

                        if ($variavel['bancoTransaction'] != 'N') {
                            rollBack();
                        }

                        return $kokw;
                    }
                }
            } else {
                if ($idt_atendimento == 0) {
                    $sql = "update " . db_pir_grc . "grc_evento set qtd_vagas_resevado = qtd_vagas_resevado + 1";
                    $sql .= " where idt = " . null($variavel['idt_evento']);
                    execsql($sql);
                }
            }

            //Verifica se tem Voucher B para o CPF
            if ($variavel['voucher_numero'] == '') {
                $sql = '';
                $sql .= ' select vr.numero';
                $sql .= ' from ' . db_pir_grc . 'grc_evento_publicacao_voucher_registro vr';
                $sql .= " inner join " . db_pir_grc . "grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher";
                $sql .= " inner join " . db_pir_grc . "grc_evento_publicacao ep on ep.idt = vr.idt_evento_publicacao";
                $sql .= ' where ep.idt_evento = ' . null($variavel['idt_evento']);
                $sql .= " and ep.situacao = 'AP'";
                $sql .= ' and v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['B']);
                $sql .= " and vr.ativo = 'S'";
                $sql .= ' and vr.idt_matricula_utilizado is null';
                $sql .= ' and vr.cpf = ' . aspa(FormataCPF12($variavel['cpf']));
                $rs = execsql($sql);
                $variavel['voucher_numero'] = $rs->data[0][0];
            }

            //Utilizza Voucher
            if ($variavel['voucher_numero'] != '') {
                $erro = acaoChecaVoucher($variavel['voucher_numero'], $variavel['idt_evento'], $idt_atendimento, true);

                if ($erro != '') {
                    $variavel['idt_atendimento_pessoa'] = $erro;
                    $variavel['idt_atendimento_agenda'] = $erro;

                    if ($variavel['bancoTransaction'] != 'N') {
                        rollBack();
                    }

                    return $kokw;
                }

                switch (substr($variavel['voucher_numero'], 0, 2)) {
                    case 'VA':
                    case 'VB':
                        $sql = "update " . db_pir_grc . "grc_evento set qtd_vagas_bloqueadas = qtd_vagas_bloqueadas - 1";
                        $sql .= " where idt = " . null($variavel['idt_evento']);
                        execsql($sql);
                        break;

                    case 'VE':
                        $sql = "update " . db_pir_grc . "grc_evento set qtd_vagas_extra = qtd_vagas_extra + 1";
                        $sql .= " where idt = " . null($variavel['idt_evento']);
                        execsql($sql);
                        break;
                }
            }

            //Verifica se tem PÚBLICO FECHADO
            if ($variavel['voucher_numero'] == '') {
                $sql = '';
                $sql .= ' select ep.idt';
                $sql .= ' from ' . db_pir_grc . 'grc_evento ep';
                $sql .= ' where ep.idt = ' . null($variavel['idt_evento']);
                $sql .= " and ep.publico_ab_fe = 'F'";
                $rs = execsql($sql);

                if ($rs->rows > 0) {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= " from " . db_pir_grc . "grc_evento_publico";
                    $sql .= ' where idt_evento = ' . null($rs->data[0][0]);
                    $sql .= ' and cpf = ' . aspa(FormataCPF12($variavel['cpf']));
                    $rs = execsql($sql);

                    if ($rs->rows == 0) {
                        $msg = 'Este evento é de Público Fechado e este CPF não esta na lista de matricula!';
                        $variavel['idt_atendimento_pessoa'] = $msg;
                        $variavel['idt_atendimento_agenda'] = $msg;

                        if ($variavel['bancoTransaction'] != 'N') {
                            rollBack();
                        }

                        return $kokw;
                    }
                }
            }

            if ($variavel['filadeespera'] != 'S') {
                $sql = "select gec_prog.tipo_ordem, grc_e.composto";
                $sql .= ' from ' . db_pir_grc . 'grc_evento grc_e';
                $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = grc_e.idt_programa';
                $sql .= " where grc_e.idt = " . null($variavel['idt_evento']);
                $rsVaga = execsql($sql);
                $rowVaga = $rsVaga->data[0];

                if ($rowVaga['tipo_ordem'] != 'SG' && $rowVaga['composto'] == 'N') {
                    $sql = '';
                    $sql .= ' select quantidade_participante + qtd_vagas_adicional + qtd_vagas_extra as qtd, qtd_matriculado_siacweb + qtd_vagas_resevado + qtd_vagas_bloqueadas as tot';
                    $sql .= ' from ' . db_pir_grc . 'grc_evento';
                    $sql .= " where idt = " . null($variavel['idt_evento']);
                    $rsVaga = execsql($sql);
                    $rowVaga = $rsVaga->data[0];

                    if ($rowVaga['qtd'] != '') {
                        if ($rowVaga['tot'] > $rowVaga['qtd']) {
                            $msg = 'Não tem mais vaga disponível no Evento!';
                            $variavel['idt_atendimento_pessoa'] = $msg;
                            $variavel['idt_atendimento_agenda'] = $msg;

                            if ($variavel['bancoTransaction'] != 'N') {
                                rollBack();
                            }

                            return $kokw;
                        }
                    }
                }
            }
        }
    }

    $cpfcnpj_w = $cpf;
    $vetEntidade = Array();
    $kretw = BuscaDadosEntidadePIR($cpfcnpj_w, 'P', $vetEntidade);
    $kretw = BuscaDadosEntidadeSIACBA($cpfcnpj_w, 'F', $vetEntidade);
    $kretw = BuscaDadosEntidadeMEI($cpfcnpj_w, 'F', $vetEntidade);

    set_time_limit(30);
    $nome_pessoa = "Cliente Novo";
    $vetExistencia = Array();
    $vetpir = $vetEntidade['PIR']['P'];
    $vetExistencia['PIR']['P']['existe_entidade'] = $vetpir['existe_entidade'];
    if ($vetpir['existe_entidade'] == 'S') {
        // echo " aaaaaaaaaaaaaaaaaaaaaaaa PIR ==== {$idt_atendimento};";
        $qtd_entidade = $vetpir['qtd_entidade'];
        $idt_entidade = $vetpir['idt_entidade'];
        $cpfcnpj = $vetpir['cpfcnpj'];
        $idt_cliente = $vetpir['idt_cliente'];
        $nome = $vetpir['nome'];
        $nome_pessoa = $vetpir['nome'];
        $telefone = $vetpir['telefone'];
        $celular = $vetpir['celular'];
        $email = $vetpir['email'];
        $cnpj = $vetpir['cnpj'];
        $nome_empresa = $vetpir['nome_empresa'];

        // Funil
        $funil_idt_cliente_classificacao = $vetpir['funil_idt_cliente_classificacao'];
        $funil_cliente_nota_avaliacao = $vetpir['funil_cliente_nota_avaliacao'];
        $funil_cliente_data_avaliacao = $vetpir['funil_cliente_data_avaliacao'];
        $funil_cliente_obs_avaliacao = $vetpir['funil_cliente_obs_avaliacao'];

        $codigo_siacweb = $vetpir['codigo_siacweb'];
        $receber_informacao_c = $vetpir['receber_informacao'];
        $grc_atendimento_pessoa_tipo_informacao = $vetpir['gec_entidade_x_tipo_informacao'];


        // complemento dependendo do tipo
        $vetdadosproprios = $vetpir['dadosproprios'];
        //p($vetdadosproprios);


        $idt_complemento_pessoa_c = $vetdadosproprios['row']['idt'];
        $idt_origem_c = $vetdadosproprios['row']['idt_origem'];
        $idt_entidade_c = $vetdadosproprios['row']['idt_entidade'];
        $ativo_c = $vetdadosproprios['row']['ativo'];
        $data_nascimento_c = $vetdadosproprios['row']['data_nascimento'];
        $nome_pai_c = $vetdadosproprios['row']['nome_pai'];
        $nome_mae_c = $vetdadosproprios['row']['nome_mae'];
        $idt_ativeconpf = $vetdadosproprios['row']['idt_ativeconpf'];
        $siacweb_situacao = $vetpir['siacweb_situacao'];
        $pa_senha = $vetpir['pa_senha'];
        $pa_idfacebook = $vetpir['pa_idfacebook'];
        $idt_profissao_c = $vetdadosproprios['row']['idt_profissao'];
        $idt_estado_civil_c = $vetdadosproprios['row']['idt_estado_civil'];
        $idt_cor_pele_c = $vetdadosproprios['row']['idt_cor_pele'];
        $idt_religiao_c = $vetdadosproprios['row']['idt_religiao'];
        $idt_destreza_c = $vetdadosproprios['row']['idt_destreza'];
        $idt_sexo_c = $vetdadosproprios['row']['idt_sexo'];
        $necessidade_especial_c = $vetdadosproprios['row']['necessidade_especial'];
        $grc_atendimento_pessoa_tipo_deficiencia = $vetdadosproprios['row']['gec_entidade_pessoa_tipo_deficiencia'];
        $idt_escolaridade_c = $vetdadosproprios['row']['idt_escolaridade'];
        $nome_tratamento_c = $vetdadosproprios['row']['nome_tratamento'];

        // Parte variável
        $vetenderecos = $vetpir['enderecos'];
        $vetprotocolos = $vetpir['protocolos'];
        $vetempresas = $vetpir['empresas'];
        $vetempresasPE = $vetempresas['PE'];
        $vetempresasEP = $vetempresas['EP'];
        ForEach ($vetenderecos as $idx => $Vettrab) {
            $vetendereco = $Vettrab['endereco'];
            $vetrow = $vetendereco['row'];
            //
            // 00 é o principal
            //
           //$vetrow['idt_entidade_endereco_tipo'];
            // 99 é endereco do atendimento
            if ($vetrow['gec_eneet_codigo'] != "00" and $vetrow['gec_eneet_codigo'] != "99") {
                continue;
            }
            $logradouro_p = $vetrow['logradouro'];
            $logradouro_numero_p = $vetrow['logradouro_numero'];
            $logradouro_complemento_p = $vetrow['logradouro_complemento'];
            $logradouro_bairro_p = $vetrow['logradouro_bairro'];
            $logradouro_municipio_p = $vetrow['logradouro_municipio'];
            $logradouro_estado_p = $vetrow['logradouro_estado'];
            $logradouro_pais_p = $vetrow['logradouro_pais'];
            $logradouro_cep_p = $vetrow['logradouro_cep'];

            $logradouro_codbairro_p = $vetrow['logradouro_codbairro'];
            $logradouro_codcid_p = $vetrow['logradouro_codcid'];
            $logradouro_codest_p = $vetrow['logradouro_codest'];
            $logradouro_codpais_p = $vetrow['logradouro_codpais'];

            $cep_p = $vetrow['cep'];

            $idt_pais_p = $vetrow['idt_pais'];
            $idt_estado_p = $vetrow['idt_estado'];
            $idt_cidade_p = $vetrow['idt_cidade'];

            $telefone_1_p = "";
            $telefone_2_p = "";
            $email_1_p = "";
            $email_2_p = "";
            $sms_1_p = "";
            $sms_2_p = "";

            $vetcomunicacaow = $vetendereco['comunicacao'];
            if (is_array($vetcomunicacaow)) {
                ForEach ($vetcomunicacaow as $idxw => $VetCom) {
                    //p($VetCom);
                    if ($VetCom['comunicacao']['origem'] == 'ATENDIMENTO RECADO') {
                        $telefone_3_p = $VetCom['comunicacao']['telefone_1'];
                    }
                    if ($VetCom['comunicacao']['origem'] == 'ATENDIMENTO PRINCIPAL') {
                        $telefone_1_p = $VetCom['comunicacao']['telefone_1'];
                        $telefone_2_p = $VetCom['comunicacao']['telefone_2'];
                        $email_1_p = $VetCom['comunicacao']['email_1'];
                        $email_2_p = $VetCom['comunicacao']['email_2'];
                        $sms_1_p = $VetCom['comunicacao']['sms_1'];
                        $sms_2_p = $VetCom['comunicacao']['sms_2'];
                    }
                    /*
                      if ($telefone_2_p == "") {
                      $telefone_2_p = $VetCom['comunicacao']['telefone_2'];
                      }
                      if ($email_1_p == "") {
                      $email_1_p = $VetCom['comunicacao']['email_1'];
                      }
                      if ($email_2_p == "") {
                      $email_2_p = $VetCom['comunicacao']['email_2'];
                      }

                      if ($sms_1_p == "") {
                      $sms_1_p = $VetCom['comunicacao']['sms_1'];
                      }
                      if ($sms_2_p == "") {
                      $sms_2_p = $VetCom['comunicacao']['sms_2'];
                      }
                     */
                }
            }
        }
    } else {
        // echo " aaaaaaaaaaaaaaaaaaaaaaaa SIACBA ==== {$idt_atendimento};";
        $vetExistencia = Array();
        $vetpir = $vetEntidade['SIACBA']['F'];
        //   echo "teste  2222222 ====== ".$idt_atendimento;
        //p($vetpir);
        $vetExistencia['SIACBA']['F']['existe_entidade'] = $vetpir['existe_entidade'];
        if ($vetpir['existe_entidade'] == 'S') {
            $qtd_entidade = $vetpir['qtd_entidade'];
            $idt_entidade = $vetpir['idt_entidade'];
            $codigo_siacweb = $idt_entidade;
            $cpfcnpj = $vetpir['cpfcnpj'];
            $idt_cliente = $vetpir['idt_cliente'];
            $nome = $vetpir['nomerazaosocial'];
            $nome_pessoa = $vetpir['nomerazaosocial'];
            $telefone = $vetpir['telefone'];
            $celular = $vetpir['celular'];
            $email = $vetpir['email'];
            $cnpj = $vetpir['cnpj'];
            $nome_empresa = $vetpir['nome_empresa'];
            // complemento dependendo do tipo
            $vetdadosproprios = $vetpir['dadosproprios'];
            //p($vetdadosproprios);

            $vetDN = explode(' ', $vetdadosproprios['row']['data_nascimento']);

            $idt_complemento_pessoa_c = $vetdadosproprios['row']['idt'];
            $idt_origem_c = $vetdadosproprios['row']['idt_origem'];
            $idt_entidade_c = $vetdadosproprios['row']['idt_entidade'];
            $ativo_c = $vetdadosproprios['row']['ativo'];
            $data_nascimento_c = $vetDN[0];
            $nome_pai_c = $vetdadosproprios['row']['nome_pai'];
            $nome_mae_c = $vetdadosproprios['row']['nome_mae'];
            $idt_ativeconpf = $vetdadosproprios['row']['idt_ativeconpf'];
            $siacweb_situacao = $vetpir['siacweb_situacao'];
            $pa_senha = $vetpir['pa_senha'];
            $pa_idfacebook = $vetpir['pa_idfacebook'];
            $idt_profissao_c = $vetdadosproprios['row']['idt_profissao'];
            $idt_estado_civil_c = $vetdadosproprios['row']['idt_estado_civil'];
            $idt_cor_pele_c = $vetdadosproprios['row']['idt_cor_pele'];
            $idt_religiao_c = $vetdadosproprios['row']['idt_religiao'];
            $idt_destreza_c = $vetdadosproprios['row']['idt_destreza'];
            $idt_sexo_c = $vetdadosproprios['row']['idt_sexo'];
            $necessidade_especial_c = $vetdadosproprios['row']['necessidade_especial'];
            $idt_escolaridade_c = $vetdadosproprios['row']['idt_escolaridade'];
            $receber_informacao_c = $vetdadosproprios['row']['receber_informacao'];
            $nome_tratamento_c = $vetdadosproprios['row']['nome_tratamento'];

            $vetendereco = $vetpir['enderecos'];

            //p($vetendereco);

            $logradouro_p = $vetendereco['row']['logradouro'];
            $logradouro_numero_p = $vetendereco['row']['logradouro_numero'];
            $logradouro_complemento_p = $vetendereco['row']['logradouro_complemento'];
            $logradouro_bairro_p = $vetendereco['row']['logradouro_bairro'];
            $logradouro_municipio_p = $vetendereco['row']['logradouro_municipio'];
            $logradouro_estado_p = $vetendereco['row']['logradouro_estado'];
            $logradouro_pais_p = $vetendereco['row']['logradouro_pais'];
            $logradouro_cep_p = $vetendereco['row']['logradouro_cep'];

            $logradouro_codbairro_p = $vetendereco['row']['logradouro_codbairro'];
            $logradouro_codcid_p = $vetendereco['row']['logradouro_codcid'];
            $logradouro_codest_p = $vetendereco['row']['logradouro_codest'];
            $logradouro_codpais_p = $vetendereco['row']['logradouro_codpais'];

            $cep_p = $vetendereco['row']['cep'];

            $idt_pais_p = $vetendereco['row']['idt_pais'];
            $idt_estado_p = $vetendereco['row']['idt_estado'];
            $idt_cidade_p = $vetendereco['row']['idt_cidade'];
            //
            // Comunicacao
            //
            $vetcomunicacao = $vetpir['comunicacao']['row'];



            $telefone_1_p = $vetcomunicacao['telefone_1_p'];
            $telefone_2_p = $vetcomunicacao['telefone_2_p'];
            $telefone_3_p = $vetcomunicacao['telefone_3_p'];
            $email_1_p = $vetcomunicacao['email_1_p'];
            $sms_1_p = $vetcomunicacao['sms_1_p'];

            // o SMS = telefone celular
            $sms_1_p = $telefone_2_p;
            // Parte variável
            $vetenderecos = $vetpir['enderecos'];
            $vetprotocolos = $vetpir['protocolos'];
            $vetempresas = $vetpir['empresas'];
            $vetempresasPE = $vetempresas['PE'];
            $vetempresasEP = $vetempresas['EP'];

            ForEach ($vetenderecos as $idx => $Vettrab) {
                $vetendereco = $Vettrab['endereco'];
                $vetrow = $vetendereco['row'];
                //
                // 00 é o principal
                //
               //$vetrow['idt_entidade_endereco_tipo'];
                if ($vetrow['gec_eneet_codigo'] != "00" and $vetrow['gec_eneet_codigo'] != "99") {
                    continue;
                }
                $logradouro_p = $vetrow['logradouro'];
                $logradouro_numero_p = $vetrow['logradouro_numero'];
                $logradouro_complemento_p = $vetrow['logradouro_complemento'];
                $logradouro_bairro_p = $vetrow['logradouro_bairro'];
                $logradouro_municipio_p = $vetrow['logradouro_municipio'];
                $logradouro_estado_p = $vetrow['logradouro_estado'];
                $logradouro_pais_p = $vetrow['logradouro_pais'];

                $logradouro_codbairro_p = $vetrow['logradouro_codbairro'];
                $logradouro_codcid_p = $vetrow['logradouro_codcid'];
                $logradouro_codest_p = $vetrow['logradouro_codest'];
                $logradouro_codpais_p = $vetrow['logradouro_codpais'];

                $logradouro_cep_p = $vetrow['logradouro_cep'];
                $cep_p = $vetrow['cep'];

                $idt_pais_p = $vetrow['idt_pais'];
                $idt_estado_p = $vetrow['idt_estado'];
                $idt_cidade_p = $vetrow['idt_cidade'];

                $vetcomunicacaow = $vetendereco['comunicacao'];
                if (is_array($vetcomunicacaow)) {
                    ForEach ($vetcomunicacaow as $idxw => $VetCom) {
                        //        p($VetCom);
                        $telefone_1_p = $VetCom['comunicacao']['telefone_1'];
                        $telefone_2_p = $VetCom['comunicacao']['telefone_2'];
                        //$telefone_3_p = $VetCom['comunicacao']['telefone_3'];
                        $email_1_p = $VetCom['comunicacao']['email_1'];
                        $email_2_p = $VetCom['comunicacao']['email_2'];
                        $sms_1_p = $VetCom['comunicacao']['sms_1'];
                        $sms_2_p = $VetCom['comunicacao']['sms_2'];
                    }
                }
            }
        }
    }
    //
    //  Gravar Pessoa
    //
    $idt_pessoa = null($idt_entidade);
    $nome_mae = aspa($nome_mae_c);
    $idt_ativeconpf = null($idt_ativeconpf);

    $rowSIAC = situacaoParceiroSiacWeb('F', $variavel['cpf']);
    $siacweb_situacao = $rowSIAC['siacweb_situacao'];

    if ($siacweb_situacao == '') {
        $siacweb_situacao = 1;
    }

    $siacweb_situacao = null($siacweb_situacao);
    $pa_senha = aspa($pa_senha);
    $pa_idfacebook = aspa($pa_idfacebook);
    $nome_pai = aspa($nome_pai_c);
    $logradouro_cep = aspa($cep_p);
    $cep = aspa($cep_p);

    $logradouro_p = substr($logradouro_p, 0, 120);

    $logradouro_endereco = aspa($logradouro_p);
    $logradouro_numero = aspa($logradouro_numero_p);
    $logradouro_bairro = aspa($logradouro_bairro_p);
    $logradouro_complemento = aspa($logradouro_complemento_p);
    $logradouro_cidade = aspa($logradouro_municipio_p);
    $logradouro_estado = aspa($logradouro_estado_p);
    $logradouro_pais = aspa($logradouro_pais_p);

    $logradouro_codbairro_p = null($logradouro_codbairro_p);
    $logradouro_codcid_p = null($logradouro_codcid_p);
    $logradouro_codest_p = null($logradouro_codest_p);
    $logradouro_codpais_p = null($logradouro_codpais_p);

    $idt_pais = null(idt_pais_p);
    $idt_estado = null(idt_estado_p);
    $idt_cidade = null(idt_cidade_p);
    $telefone_residencial = aspa($telefone_1_p);
    $telefone_celular = aspa($telefone_2_p);
    $telefone_recado = aspa($telefone_3_p);

    /*
     * Removido por causa do suporte #606
      if ($telefone_3_p == "") {
      if ($telefone_celular != '') {
      $telefone_recado = $telefone_celular;
      } else {
      $telefone_recado = $telefone_residencial;
      }
      }
     * 
     */

    $email = aspa($email_1_p);
    $sms = aspa($sms_1_p);
    //
    $nome_tratamento = aspa($nome_tratamento_c);
    $idt_escolaridade = null($idt_escolaridade_c);
    $idt_sexo = null($idt_sexo_c);
    $data_nascimento = aspa($data_nascimento_c);
    $receber_informacao = aspa($receber_informacao_c);
    $necessidade_especial = aspa($necessidade_especial_c);
    //
    $idt_profissao = null($idt_profissao_c);
    $idt_estado_civil = null($idt_estado_civil_c);
    $idt_cor_pele = null($idt_cor_pele_c);
    $idt_religiao = null($idt_religiao_c);
    $idt_destreza = null($idt_destreza_c);
    //
    $cpf = aspa($cpf);
    $codigo_siacweb = aspa($codigo_siacweb);
    $nome = aspa($nome_pessoa);
    $tipo_relacao = aspa("L");
    $representa_empresa = aspa('N');
    if ($cnpj_w != "") {
        $representa_empresa = aspa('S');
    }
    //
    //echo " não sei não {$data_nascimento};";
    //
    if ($idt_atendimento == 0) {
        $datadia = date('d/m/Y H:i:s');
        $vet = explode(' ', $datadia);
        $data_inicial = trata_data($vet[0]);
        $hora_inicial = substr($vet[1], 0, 5);
        $idt_atendimentow = 0;
        $idt_consultor = $variavel['id_usuario'];
        $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];

        if ($idt_ponto_atendimento == '' && $variavel['idt_evento'] != '') {
            $sql = "select idt_ponto_atendimento";
            $sql .= ' from ' . db_pir_grc . 'grc_evento';
            $sql .= " where idt = " . null($variavel['idt_evento']);
            $rsVaga = execsql($sql);
            $idt_ponto_atendimento = $rsVaga->data[0][0];
        }

        GeraAtendimentoHE($idt_atendimento_agenda, $idt_consultor, $idt_ponto_atendimento, $data_inicial, $hora_inicial, $idt_instrumento, $idt_atendimentow, $variavel['idt_evento'], $variavel['evento_origem'], $variavel['canal_registro'], $variavel['origem']);
        $idt_atendimento = $idt_atendimentow;
        $variavel['idt_atendimento'] = $idt_atendimento;
    }
    //
    //  Deletar elementos vinculados
    //
    // organização
    $sql_d = ' delete from ';
    $sql_d .= db_pir_grc . 'grc_atendimento_organizacao ';
    $sql_d .= ' where idt_atendimento = ' . null($idt_atendimento);
    $rs_d = execsql($sql_d);
    //
    // Pessoas
    $sql_d = ' delete from ';
    $sql_d .= db_pir_grc . 'grc_atendimento_pessoa ';
    $sql_d .= ' where idt_atendimento = ' . null($idt_atendimento);
    $rs_d = execsql($sql_d);
    //
    //  incluir pessoa
    //
    
    if ($variavel['idt_evento'] == '') {
        $sqlCampo = '';
        $sqlValor = '';
    } else {
        $sqlCampo = ' evento_cortesia, evento_alt_siacweb, evento_inscrito, evento_exc_siacweb, ';
        $sqlValor = " 'N', 'N', 'N', 'N', ";

        if ($variavel['filadeespera'] == 'S') {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_evento_participante';
            $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
            $rs = execsql($sql);

            if ($rs->rows == 0) {
                $sql = 'insert into grc_evento_participante (idt_atendimento, contrato) VALUES (' . null($idt_atendimento) . ", 'FE')";
                execsql($sql);
            }
        }
    }

    $sql_i = ' insert into ' . db_pir_grc . 'grc_atendimento_pessoa ';
    $sql_i .= ' (  ';
    $sql_i .= $sqlCampo;
    $sql_i .= " idt_atendimento, ";
    $sql_i .= " idt_pessoa, ";
    $sql_i .= " codigo_siacweb, ";
    $sql_i .= " cpf, ";
    $sql_i .= " nome, ";
    $sql_i .= " tipo_relacao, ";
    $sql_i .= " nome_mae, ";
    $sql_i .= " idt_ativeconpf, ";
    $sql_i .= " siacweb_situacao, ";
    $sql_i .= " pa_senha, ";
    $sql_i .= " pa_idfacebook, ";
    $sql_i .= " nome_pai, ";
    $sql_i .= " logradouro_cep, ";
    $sql_i .= " logradouro_endereco, ";
    $sql_i .= " logradouro_numero, ";
    $sql_i .= " logradouro_bairro, ";
    $sql_i .= " logradouro_complemento, ";
    $sql_i .= " logradouro_cidade, ";
    $sql_i .= " logradouro_estado, ";
    $sql_i .= " logradouro_pais, ";

    $sql_i .= " logradouro_codbairro, ";
    $sql_i .= " logradouro_codcid, ";
    $sql_i .= " logradouro_codest, ";
    $sql_i .= " logradouro_codpais, ";

    $sql_i .= " idt_pais, ";
    $sql_i .= " idt_estado, ";
    $sql_i .= " idt_cidade, ";
    $sql_i .= " telefone_residencial, ";
    $sql_i .= " telefone_celular, ";
    $sql_i .= " telefone_recado, ";

    $sql_i .= " email, ";
    $sql_i .= " sms, ";
    $sql_i .= " nome_tratamento, ";
    $sql_i .= " idt_escolaridade, ";

    $sql_i .= " idt_sexo, ";
    $sql_i .= " data_nascimento, ";
    $sql_i .= " receber_informacao, ";
    $sql_i .= " representa_empresa, ";
    $sql_i .= " necessidade_especial, ";

    $sql_i .= " idt_profissao, ";
    $sql_i .= " idt_estado_civil, ";
    $sql_i .= " idt_cor_pele, ";
    $sql_i .= " idt_religiao, ";
    $sql_i .= " idt_destreza ";
    $sql_i .= '  ) values ( ';
    $sql_i .= $sqlValor;
    $sql_i .= " $idt_atendimento, ";
    $sql_i .= " $idt_pessoa, ";
    $sql_i .= " $codigo_siacweb, ";
    $sql_i .= " $cpf, ";
    $sql_i .= " $nome, ";
    $sql_i .= " $tipo_relacao, ";
    $sql_i .= " $nome_mae, ";
    $sql_i .= " $idt_ativeconpf, ";
    $sql_i .= " $siacweb_situacao, ";
    $sql_i .= " $pa_senha, ";
    $sql_i .= " $pa_idfacebook, ";
    $sql_i .= " $nome_pai, ";
    $sql_i .= " $logradouro_cep, ";
    $sql_i .= " $logradouro_endereco, ";
    $sql_i .= " $logradouro_numero, ";
    $sql_i .= " $logradouro_bairro, ";
    $sql_i .= " $logradouro_complemento, ";
    $sql_i .= " $logradouro_cidade, ";
    $sql_i .= " $logradouro_estado, ";
    $sql_i .= " $logradouro_pais, ";

    $sql_i .= " $logradouro_codbairro_p, ";
    $sql_i .= " $logradouro_codcid_p, ";
    $sql_i .= " $logradouro_codest_p, ";
    $sql_i .= " $logradouro_codpais_p, ";

    $sql_i .= " $idt_pais, ";
    $sql_i .= " $idt_estado, ";
    $sql_i .= " $idt_cidade, ";
    $sql_i .= " $telefone_residencial, ";
    $sql_i .= " $telefone_celular, ";
    $sql_i .= " $telefone_recado, ";

    $sql_i .= " $email, ";
    $sql_i .= " $sms, ";
    $sql_i .= " $nome_tratamento, ";
    $sql_i .= " $idt_escolaridade, ";

    $sql_i .= " $idt_sexo, ";
    $sql_i .= " $data_nascimento, ";
    $sql_i .= " $receber_informacao, ";
    $sql_i .= " $representa_empresa, ";
    $sql_i .= " $necessidade_especial, ";
    $sql_i .= " $idt_profissao, ";
    $sql_i .= " $idt_estado_civil, ";
    $sql_i .= " $idt_cor_pele, ";
    $sql_i .= " $idt_religiao, ";
    $sql_i .= " $idt_destreza ";
    $sql_i .= ') ';
    $result = execsql($sql_i);
    $idt_atendimento_pessoa = lastInsertId();
    $variavel['idt_atendimento_pessoa'] = $idt_atendimento_pessoa;

    if (is_array($grc_atendimento_pessoa_tipo_informacao)) {
        foreach ($grc_atendimento_pessoa_tipo_informacao as $rowtt) {
            $sqlx = 'insert into ' . db_pir_grc . 'grc_atendimento_pessoa_tipo_informacao (idt, idt_tipo_informacao) values (';
            $sqlx .= null($idt_atendimento_pessoa) . ', ' . null($rowtt['idt_tipo_informacao']) . ')';
            execsql($sqlx);
        }
    }

    if (is_array($grc_atendimento_pessoa_tipo_deficiencia)) {
        foreach ($grc_atendimento_pessoa_tipo_deficiencia as $rowtt) {
            $sqlx = 'insert into ' . db_pir_grc . 'grc_atendimento_pessoa_tipo_deficiencia (idt, idt_tipo_deficiencia) values (';
            $sqlx .= null($idt_atendimento_pessoa) . ', ' . null($rowtt['idt_tipo_deficiencia']) . ')';
            execsql($sqlx);
        }
    }

    $idtentidade_relacionada = $idt_pessoa;
    if ($idtentidade_relacionada > 0) {
        //
        // incluir temas de interesee
        //
        $sql2 = 'select ';
        $sql2 .= '  gec_eti.*   ';
        $sql2 .= '  from ' . db_pir_gec . 'gec_entidade_tema_interesse gec_eti ';
        $sql2 .= ' where  gec_eti.idt_entidade   = ' . null($idtentidade_relacionada);
        $rs = execsql($sql2);
        ForEach ($rs->data as $row2) {
            $idt = $row2['idt'];
            $idt_tema = null($row2['idt_tema']);
            $idt_subtema = null($row2['idt_subtema']);
            $idt_responsavel = IdUsuarioPIR($row2['idt_responsavel'], db_pir_gec, db_pir_grc);
            $idt_responsavel = null($idt_responsavel);
            //
            $observacao = aspa($row2['observacao']);
            //
            // gravar no do atendimento
            //
            $sql_i = ' insert into ' . db_pir_grc . 'grc_atendimento_pessoa_tema_interesse ';
            $sql_i .= ' (  ';
            $sql_i .= " idt_atendimento_pessoa, ";
            $sql_i .= " idt_responsavel, ";
            $sql_i .= " idt_tema, ";
            $sql_i .= " idt_subtema, ";
            $sql_i .= " observacao ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " $idt_atendimento_pessoa, ";
            $sql_i .= " $idt_responsavel, ";
            $sql_i .= " $idt_tema, ";
            $sql_i .= " $idt_subtema, ";
            $sql_i .= " $observacao ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }

        $sql2 = 'select ';
        $sql2 .= '  gec_epi.*   ';
        $sql2 .= '  from ' . db_pir_gec . 'gec_entidade_produto_interesse gec_epi ';
        $sql2 .= ' where  gec_epi.idt_entidade   = ' . null($idtentidade_relacionada);
        $rs = execsql($sql2);
        ForEach ($rs->data as $row2) {
            $idt = $row2['idt'];
            $idt_produto = null($row2['idt_produto']);
            $idt_responsavel = IdUsuarioPIR($row2['idt_responsavel'], db_pir_gec, db_pir_grc);
            $idt_responsavel = null($idt_responsavel);
            //
            $observacao = aspa($row2['observacao']);
            //
            // gravar no do atendimento
            //
            $sql_i = ' insert into ' . db_pir_grc . 'grc_atendimento_pessoa_produto_interesse ';
            $sql_i .= ' (  ';
            $sql_i .= " idt_atendimento_pessoa, ";
            $sql_i .= " idt_responsavel, ";
            $sql_i .= " idt_produto, ";
            $sql_i .= " observacao ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " $idt_atendimento_pessoa, ";
            $sql_i .= " $idt_responsavel, ";
            $sql_i .= " $idt_produto, ";
            $sql_i .= " $observacao ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }

        $sql2 = 'select ';
        $sql2 .= '  gec_eai.*   ';
        $sql2 .= '  from ' . db_pir_gec . 'gec_entidade_arquivo_interesse gec_eai ';
        $sql2 .= ' where  gec_eai.idt_entidade   = ' . null($idtentidade_relacionada);
        $rs = execsql($sql2);
        ForEach ($rs->data as $row2) {
            $vetPrefixoArq = explode('_', $row2['arquivo']);
            $PrefixoArq = '';
            $PrefixoArq .= $vetPrefixoArq[0] . '_';
            $PrefixoArq .= $vetPrefixoArq[1] . '_';
            $PrefixoArq .= $vetPrefixoArq[2] . '_';
            $arq_novo = GerarStr() . '_arquivo_' . substr(time(), -3) . '_' . substr($row2['arquivo'], strlen($PrefixoArq));

            $arqCopia[] = Array(
                'de' => str_replace('/', DIRECTORY_SEPARATOR, $vetSistemaUtiliza['GEC']['path'] . 'admin/obj_file/gec_entidade_arquivo_interesse/' . $row2['arquivo']),
                'para' => str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/obj_file/grc_atendimento_pessoa_arquivo_interesse/' . $arq_novo),
            );

            $idt = $row2['idt'];

            // Pegar o do GRC
            $idt_responsavel = IdUsuarioPIR($row2['idt_responsavel'], db_pir_gec, db_pir_grc);
            $idt_responsavel = null($idt_responsavel);

            $titulo = aspa($row2['titulo']);
            $arquivo = aspa($arq_novo);
            //
            // gravar no do atendimento
            //
            $sql_i = ' insert into ' . db_pir_grc . 'grc_atendimento_pessoa_arquivo_interesse ';
            $sql_i .= ' (  ';
            $sql_i .= " idt_atendimento_pessoa, ";
            $sql_i .= " idt_responsavel, ";
            $sql_i .= " titulo, ";
            $sql_i .= " arquivo ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " $idt_atendimento_pessoa, ";
            $sql_i .= " $idt_responsavel, ";
            $sql_i .= " $titulo, ";
            $sql_i .= " $arquivo ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }
    }
    ////
    /// tem que atualizar AGENDA
    ///
    $sql2 = 'select ';
    $sql2 .= '  idt_atendimento_agenda   ';
    $sql2 .= '  from ' . db_pir_grc . 'grc_atendimento grc_a ';
    $sql2 .= '  where grc_a.idt = ' . null($idt_atendimento);
    $rs_aap = execsql($sql2);
    if ($rs_aap->rows == 0) {
        $variavel['idt_atendimento_agenda'] = 0;
    } else {
        ForEach ($rs_aap->data as $row) {
            $idt_atendimento_agenda = $row['idt_atendimento_agenda'];
        }
        $variavel['idt_atendimento_agenda'] = $idt_atendimento_agenda;
        //
        $datadiaw = (date('d/m/Y H:i:s'));
        $segundo = true;
        $datadia = aspa(trata_data($datadiaw, $segundo));
        //
        //
        $sql_a = " update " . db_pir_grc . "grc_atendimento set ";
        $sql_a .= " idt_pessoa            = $idt_atendimento_pessoa ";
        $sql_a .= " where idt             = " . null($idt_atendimento);
        $result = execsql($sql_a);

        //p($sql_a);
        //
        $sql_a = " update " . db_pir_grc . "grc_atendimento_agenda set ";
        $sql_a .= " cpf                   = $cpf, ";
        $sql_a .= " cliente_texto         = $nome ";
        $sql_a .= " where idt             = " . null($idt_atendimento_agenda);
        $result = execsql($sql_a);
        //
    }
    //
    // Buscar entidades relacionadas
    //
    
    if ($variavel['idt_evento'] == '') {
        if ($idt_pessoa > 0) {   // existe no cadastro de entidades do PIR
            $vetrowemp = Array();
            $sqlp = 'select gec_en.* ';
            $sqlp .= ' from ' . db_pir_gec . 'gec_entidade gec_en ';
            $sqlp .= " where gec_en.codigo = " . aspa($cpf_w);
            $sqlp .= "   and gec_en.tipo_entidade = 'P' ";
            $sqlp .= "   and gec_en.reg_situacao  = " . aspa('A');
            $sqlp .= '   and gec_en.ativo = ' . aspa('S');
            $rsp = execsql($sqlp);
            $qtpessoa = $rsp->rows;
            if ($rsp->rows == 0) {
                
            } else {
                $VetEntidadesRelacionadas = Array();
                ForEach ($rsp->data as $rowp) {
                    $idt_entidade = $rowp['idt'];
                    $vetrowemp = Array();
                    BuscaEmpresas($idt_entidade, $vetrowemp);
                    //p($vetrowemp);
                    // Pessoa X Entidade
                    $pew = $vetrowemp['PE'];
                    ForEach ($pew as $idx => $VetEnt) {
                        if ($VetEnt['existe_entidade'] == 'S') {
                            //p($VetEnt);
                            $idt_entidade_entidade = $VetEnt['idt_entidade_entidade'];

                            $dt_ini_atu = $VetEntidadesRelacionadas[$idt_entidade_entidade]['dadosproprios']['ee_data_inicio'];
                            $dt_fim_atu = $VetEntidadesRelacionadas[$idt_entidade_entidade]['dadosproprios']['ee_data_termino'];
                            $representa_codcargcli_atu = $VetEntidadesRelacionadas[$idt_entidade_entidade]['dadosproprios']['representa_codcargcli'];

                            $dt_ini_emp = $VetEnt['empresas']['ee_data_inicio'];
                            $dt_fim_emp = $VetEnt['empresas']['ee_data_termino'];
                            $representa_codcargcli_emp = $VetEnt['empresas']['representa_codcargcli'];

                            if ($representa_codcargcli_atu == '' && $representa_codcargcli_emp != '') {
                                $atualiza = true;
                            } else if ($dt_ini_atu == '') {
                                $atualiza = true;
                            } else if ($dt_fim_atu != '') {
                                if ($dt_fim_emp == '') {
                                    $atualiza = true;
                                } else {
                                    $diff = diffDate(trata_data($dt_fim_atu), trata_data($dt_fim_emp), 'S');

                                    if ($diff > 0) {
                                        $atualiza = true;
                                    } else {
                                        $atualiza = false;
                                    }
                                }
                            } else {
                                $diff = diffDate(trata_data($dt_ini_atu), trata_data($dt_ini_emp), 'S');

                                if ($diff > 0) {
                                    $atualiza = true;
                                } else {
                                    $atualiza = false;
                                }
                            }

                            if ($atualiza) {
                                $VetEntidadesRelacionadas[$idt_entidade_entidade]['dadosproprios'] = $VetEnt['empresas'];
                                $VetEntidadesRelacionadas[$idt_entidade_entidade]['grc_atendimento_organizacao_tipo_informacao'] = $VetEnt['gec_entidade_x_tipo_informacao'];
                                //
                                $vetrowend = Array();
                                $retend = BuscaEnderecos($VetEnt['empresas']['idt_entidade'], $vetrowend);
                                //
                                //echo $VetEnt['empresas']['idt_entidade'];
                                //p($vetrowend);

                                ForEach ($vetrowend as $idx => $Vettrab) {
                                    $vetendereco = $Vettrab['endereco'];
                                    $vetrow = $vetendereco['row'];
                                    //
                                    // 00 é o principal
                                    //
                           //$vetrow['idt_entidade_endereco_tipo'];
                                    if ($vetrow['gec_eneet_codigo'] != "00" && $vetrow['gec_eneet_codigo'] != "99") {
                                        continue;
                                    }
                                    $VetEntidadesRelacionadas[$idt_entidade_entidade]['endereco'] = $vetrow;
                                    //
                                    $logradouro_p = $vetrow['logradouro'];
                                    $logradouro_numero_p = $vetrow['logradouro_numero'];
                                    $logradouro_complemento_p = $vetrow['logradouro_complemento'];
                                    $logradouro_bairro_p = $vetrow['logradouro_bairro'];
                                    $logradouro_municipio_p = $vetrow['logradouro_municipio'];
                                    $logradouro_estado_p = $vetrow['logradouro_estado'];
                                    $logradouro_pais_p = $vetrow['logradouro_pais'];
                                    $logradouro_cep_p = $vetrow['logradouro_cep'];
                                    $cep_p = $vetrow['cep'];
                                    $idt_pais_p = $vetrow['idt_pais'];
                                    $idt_estado_p = $vetrow['idt_estado'];
                                    $idt_cidade_p = $vetrow['idt_cidade'];

                                    $vetcomunicacaow = $vetendereco['comunicacao'];
                                    if (is_array($vetcomunicacaow)) {
                                        //p($vetcomunicacaow);
                                        ForEach ($vetcomunicacaow as $idxw => $VetCom) {
                                            //                               p($VetCom);
                                            $telefone_1_p = $VetCom['comunicacao']['telefone_1'];
                                            $telefone_2_p = $VetCom['comunicacao']['telefone_2'];
                                            $email_1_p = $VetCom['comunicacao']['email_1'];
                                            $email_2_p = $VetCom['comunicacao']['email_2'];
                                            $sms_1_p = $VetCom['comunicacao']['sms_1'];
                                            $sms_2_p = $VetCom['comunicacao']['sms_2'];
                                            $VetEntidadesRelacionadas[$idt_entidade_entidade]['endereco']['comunicacao'][] = $VetCom['comunicacao'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //
                    // Entidade X Pessoa
                    //
		//p($vetrowemp);
                    /*
                      $epw = $vetrowemp['EP'];
                      ForEach ($epw as $idx => $VetEnt) {
                      if ($VetEnt['existe_entidade'] == 'S') {
                      // p($VetEnt);
                      $idt_entidade_entidade = $VetEnt['idt_entidade_entidade'];
                      $VetEntidadesRelacionadas[$idt_entidade_entidade]['dadosproprios'] = $VetEnt['empresas'];
                      $VetEntidadesRelacionadas[$idt_entidade_entidade]['grc_atendimento_organizacao_tipo_informacao'] = $VetEnt['gec_entidade_x_tipo_informacao'];
                      //
                      $vetrowend = Array();
                      $retend = BuscaEnderecos($idt_entidade, $vetrowend);
                      //
                      //p($vetrowend);

                      ForEach ($vetrowend as $idx => $Vettrab) {
                      $vetendereco = $Vettrab['endereco'];
                      $vetrow = $vetendereco['row'];
                      //
                      // 00 é o principal
                      //
                      //$vetrow['idt_entidade_endereco_tipo'];
                      if ($vetrow['gec_eneet_codigo'] != "00" && $vetrow['gec_eneet_codigo'] != "99") {
                      continue;
                      }
                      $VetEntidadesRelacionadas[$idt_entidade_entidade]['endereco'] = $vetrow;

                      $logradouro_p = $vetrow['logradouro'];
                      $logradouro_numero_p = $vetrow['logradouro_numero'];
                      $logradouro_complemento_p = $vetrow['logradouro_complemento'];
                      $logradouro_bairro_p = $vetrow['logradouro_bairro'];
                      $logradouro_municipio_p = $vetrow['logradouro_municipio'];
                      $logradouro_estado_p = $vetrow['logradouro_estado'];
                      $logradouro_pais_p = $vetrow['logradouro_pais'];
                      $logradouro_cep_p = $vetrow['logradouro_cep'];
                      $cep_p = $vetrow['cep'];

                      $idt_pais_p = $vetrow['idt_pais'];
                      $idt_estado_p = $vetrow['idt_estado'];
                      $idt_cidade_p = $vetrow['idt_cidade'];

                      $vetcomunicacaow = $vetendereco['comunicacao'];
                      if (is_array($vetcomunicacaow)) {
                      //p($vetcomunicacaow);
                      ForEach ($vetcomunicacaow as $idxw => $VetCom) {
                      //                               p($VetCom);
                      $telefone_1_p = $VetCom['comunicacao']['telefone_1'];
                      $telefone_2_p = $VetCom['comunicacao']['telefone_2'];
                      $email_1_p = $VetCom['comunicacao']['email_1'];
                      $email_2_p = $VetCom['comunicacao']['email_2'];
                      $sms_1_p = $VetCom['comunicacao']['sms_1'];
                      $sms_2_p = $VetCom['comunicacao']['sms_2'];

                      $VetEntidadesRelacionadas[$idt_entidade_entidade]['endereco']['comunicacao'][] = $VetCom['comunicacao'];
                      }
                      }
                      }
                      }
                      }
                     */

                    //p($VetEntidadesRelacionadas);



                    ForEach ($VetEntidadesRelacionadas as $idt_entidade_relacionada => $VetEnt) {
                        $dadosproprios = $VetEnt['dadosproprios'];
                        //p($dadosproprios);
                        $endereco = $VetEnt['endereco'];
                        $comunicacao = $VetEnt['endereco']['comunicacao'];

                        // funil
                        $funil_idt_cliente_classificacao = $VetEnt['funil_idt_cliente_classificacao'];
                        $funil_cliente_nota_avaliacao = $VetEnt['funil_cliente_nota_avaliacao'];
                        $funil_cliente_data_avaliacao = $VetEnt['funil_cliente_data_avaliacao'];
                        $funil_cliente_obs_avaliacao = $VetEnt['funil_cliente_obs_avaliacao'];

                        //
                        // Monta dados da empresa
                        //
                        $idt_organizacao = $dadosproprios['idt'];
                        $codigo_siacweb_e = $dadosproprios['codigo_siacweb'];
                        $idt_tipo_empreendimento_e = $dadosproprios['idt_entidade_tipo_emp'];
                        $cnpj = $dadosproprios['codigo'];
                        $tamanho_propriedade = $dadosproprios['tamanho_propriedade'];
                        $dap = $dadosproprios['dap'];
                        $nirf = $dadosproprios['nirf'];
                        $rmp = $dadosproprios['rmp'];
                        $ie_prod_rural = $dadosproprios['ie_prod_rural'];
                        $sicab_codigo = $dadosproprios['sicab_codigo'];
                        $sicab_dt_validade = $dadosproprios['sicab_dt_validade'];
                        $data_fim_atividade = $dadosproprios['data_fim_atividade'];
                        $siacweb_situacao = $dadosproprios['siacweb_situacao'];
                        $pa_senha = $dadosproprios['pa_senha'];
                        $pa_idfacebook = $dadosproprios['pa_idfacebook'];
                        $razao_social = $dadosproprios['descricao'];
                        $nome_fantasia_e = $dadosproprios['resumo'];
                        //
                        $data_abertura_e = $dadosproprios['data_inicio_atividade'];
                        $pessoas_ocupadas_e = $dadosproprios['qt_funcionarios'];
                        $receber_informacao_e = $dadosproprios['receber_informacao'];
                        $grc_atendimento_organizacao_tipo_informacao = $VetEnt['grc_atendimento_organizacao_tipo_informacao'];
                        $representa_codcargcli = $dadosproprios['representa_codcargcli'];

                        // Busca cnae principal
                        $vetcmae = Array();
                        $cnae_principal = BuscaCNAEPrincipal($idt_organizacao, $vetcmae);

                        $idt_cnae_principal = $cnae_principal;
                        $idt_porte = $dadosproprios['idt_porte'];
                        $idt_setor = $dadosproprios['idt_entidade_setor'];
                        $simples_nacional = $dadosproprios['simples_nacional'];
                        $logradouro_cep_e = $endereco['logradouro_cep'];
                        $logradouro_cep_e = $endereco['cep'];
                        $cep_e = $endereco['cep'];
                        $logradouro_e = $endereco['logradouro'];
                        $logradouro_numero_e = $endereco['logradouro_numero'];
                        $logradouro_complemento_e = $endereco['logradouro_complemento'];
                        $logradouro_bairro_e = $endereco['logradouro_bairro'];
                        $logradouro_municipio_e = $endereco['logradouro_municipio'];
                        $logradouro_estado_e = $endereco['logradouro_estado'];
                        $logradouro_pais_e = $endereco['logradouro_pais'];

                        $logradouro_codbairro_e = $endereco['logradouro_codbairro'];
                        $logradouro_codcid_e = $endereco['logradouro_codcid'];
                        $logradouro_codest_e = $endereco['logradouro_codest'];
                        $logradouro_codpais_e = $endereco['logradouro_codpais'];

                        // p($endereco);
                        //
		    //p($comunicacao);

                        $telefone_comercial_e = '';
                        $telefone_celular_e = '';
                        $email_e = '';
                        $email_2_p = '';
                        $site_url_e = '';

                        ForEach ($comunicacao as $idx => $VetCom) {
                            if ($telefone_comercial_e == "") {
                                $telefone_comercial_e = $VetCom['telefone_1'];
                            }
                            if ($telefone_celular_e == "") {
                                $telefone_celular_e = $VetCom['telefone_2'];
                            }
                            if ($email_e == "") {
                                $email_e = $VetCom['email_1'];
                            }
                            if ($email_2_p == "") {
                                $email_2_p = $VetCom['email_2'];
                            }
                            if ($site_url_e == "") {
                                $site_url_e = $VetCom['www_1'];
                            }
                        }
                        ///////////////////////////////
                        //  Gerar registro de empreendimento
                        //
                    $sql1 = 'select ';
                        $sql1 .= '  grc_ao.*   ';
                        $sql1 .= '  from ' . db_pir_grc . 'grc_atendimento_organizacao grc_ao ';
                        $sql1 .= ' where  grc_ao.idt_atendimento    = ' . null($idt_atendimento);
                        $sql1 .= '   and  grc_ao.cnpj               = ' . aspa($cnpj);
                        //p($sql1);
                        $rs_aa = execsql($sql1);
                        if ($rs_aa->rows == 0) {
                            $rowSIAC = situacaoParceiroSiacWeb('J', $cnpj, $nirf, $dap, $rmp, $ie_prod_rural, $sicab_codigo);

                            if ($rowSIAC['siacweb_situacao'] !== '') {
                                $siacweb_situacao = $rowSIAC['siacweb_situacao'];
                                $data_fim_atividade = $rowSIAC['data_fim_atividade'];
                            }

                            //$cnpj_e                  = aspa($cnpj);
                            //$razao_social_e          = aspa($razao_social);
                            $codigo_siacweb = aspa($codigo_siacweb_e);
                            $idt_tipo_empreendimento = null($idt_tipo_empreendimento_e);
                            $cnpj = aspa($cnpj);
                            $razao_social = aspa($razao_social);
                            $nome_fantasia = aspa($nome_fantasia_e);

                            // funil
                            $funil_idt_cliente_classificacao = null($funil_idt_cliente_classificacao);
                            $funil_cliente_nota_avaliacao = null($funil_cliente_nota_avaliacao);
                            $funil_cliente_data_avaliacao = aspa($funil_cliente_data_avaliacao);
                            $funil_cliente_obs_avaliacao = aspa($funil_cliente_obs_avaliacao);

                            $data_abertura = aspa($data_abertura_e);
                            $pessoas_ocupadas = null($pessoas_ocupadas_e);
                            $logradouro_cep = aspa($cep_e);

                            $logradouro_e = substr($logradouro_e, 0, 120);

                            $logradouro_endereco = aspa($logradouro_e);
                            $logradouro_numero = aspa($logradouro_numero_e);
                            $logradouro_bairro = aspa($logradouro_bairro_e);
                            $logradouro_complemento = aspa($logradouro_complemento_e);
                            $logradouro_cidade = aspa($logradouro_municipio_e);
                            $logradouro_estado = aspa($logradouro_estado_e);
                            $logradouro_pais = aspa($logradouro_pais_e);

                            $logradouro_codbairro_e = null($logradouro_codbairro_e);
                            $logradouro_codcid_e = null($logradouro_codcid_e);
                            $logradouro_codest_e = null($logradouro_codest_e);
                            $logradouro_codpais_e = null($logradouro_codpais_e);

                            $idt_pais = null($idt_pais_e);
                            $idt_estado = null($idt_estado_e);
                            $idt_cidade = null($idt_cidade_e);
                            $telefone_comercial = aspa($telefone_comercial_e);
                            $telefone_celular = aspa($telefone_celular_e);
                            $sms = aspa($sms_e);
                            $email_e = aspa($email_e);
                            $site_url = aspa($site_url_e);
                            $receber_informacao = aspa($receber_informacao_e);
                            $representa_codcargcli = null($representa_codcargcli);
                            //
                            $dap = aspa($dap);
                            $nirf = aspa(FormataNirf($nirf));
                            $rmp = aspa($rmp);
                            $ie_prod_rural = aspa($ie_prod_rural);
                            $sicab_codigo = aspa(FormataSICAB($sicab_codigo));
                            $sicab_dt_validade = aspa($sicab_dt_validade);
                            $data_fim_atividade = aspa($data_fim_atividade);

                            if ($siacweb_situacao == '') {
                                $siacweb_situacao = 1;
                            }

                            $siacweb_situacao = null($siacweb_situacao);

                            $pa_senha = aspa($pa_senha);
                            $pa_idfacebook = aspa($pa_idfacebook);

                            $idt_cnae_principal = aspa($idt_cnae_principal);
                            $idt_porte = null($idt_porte);
                            $idt_setor = null($idt_setor);
                            $simples_nacional = null($simples_nacional);
                            $tamanho_propriedade = null($tamanho_propriedade);


                            //
                            $sql_i = ' insert into ' . db_pir_grc . 'grc_atendimento_organizacao ';
                            $sql_i .= ' (  ';
                            $sql_i .= " idt_atendimento, ";
                            $sql_i .= " cnpj, ";
                            $sql_i .= " razao_social, ";
                            $sql_i .= " nome_fantasia, ";

                            // funil
                            $sql_i .= " funil_idt_cliente_classificacao, ";
                            $sql_i .= " funil_cliente_nota_avaliacao, ";
                            $sql_i .= " funil_cliente_data_avaliacao, ";
                            $sql_i .= " funil_cliente_obs_avaliacao, ";

                            $sql_i .= " codigo_siacweb_e, ";
                            $sql_i .= " idt_tipo_empreendimento, ";
                            $sql_i .= " data_abertura, ";
                            $sql_i .= " pessoas_ocupadas, ";
                            $sql_i .= " logradouro_cep_e, ";
                            $sql_i .= " logradouro_endereco_e, ";
                            $sql_i .= " logradouro_numero_e, ";
                            $sql_i .= " logradouro_bairro_e, ";
                            $sql_i .= " logradouro_complemento_e, ";
                            $sql_i .= " logradouro_cidade_e, ";
                            $sql_i .= " logradouro_estado_e, ";
                            $sql_i .= " logradouro_pais_e, ";

                            $sql_i .= " logradouro_codbairro_e, ";
                            $sql_i .= " logradouro_codcid_e, ";
                            $sql_i .= " logradouro_codest_e, ";
                            $sql_i .= " logradouro_codpais_e, ";

                            $sql_i .= " idt_pais_e, ";
                            $sql_i .= " idt_estado_e, ";
                            $sql_i .= " idt_cidade_e, ";
                            $sql_i .= " telefone_comercial_e, ";
                            $sql_i .= " telefone_celular_e, ";
                            $sql_i .= " email_e, ";
                            $sql_i .= " sms_e, ";
                            $sql_i .= " site_url, ";
                            $sql_i .= " receber_informacao_e, ";
                            $sql_i .= " representa_codcargcli, ";

                            $sql_i .= " dap,  ";
                            $sql_i .= " nirf,  ";
                            $sql_i .= " rmp,  ";
                            $sql_i .= " ie_prod_rural,  ";
                            $sql_i .= " sicab_codigo,  ";
                            $sql_i .= " sicab_dt_validade,  ";
                            $sql_i .= " data_fim_atividade,  ";
                            $sql_i .= " siacweb_situacao_e,  ";
                            $sql_i .= " pa_senha_e, ";
                            $sql_i .= " pa_idfacebook_e, ";
                            $sql_i .= " idt_cnae_principal,  ";
                            $sql_i .= " idt_porte,  ";
                            $sql_i .= " idt_setor,  ";
                            $sql_i .= " simples_nacional,  ";
                            $sql_i .= " tamanho_propriedade  ";
                            $sql_i .= '  ) values ( ';
                            $sql_i .= " $idt_atendimento, ";
                            $sql_i .= " $cnpj, ";
                            $sql_i .= " $razao_social, ";
                            $sql_i .= " $nome_fantasia, ";

                            // funil
                            $sql_i .= " $funil_idt_cliente_classificacao, ";
                            $sql_i .= " $funil_cliente_nota_avaliacao, ";
                            $sql_i .= " $funil_cliente_data_avaliacao, ";
                            $sql_i .= " $funil_cliente_obs_avaliacao, ";

                            $sql_i .= " $codigo_siacweb, ";
                            $sql_i .= " $idt_tipo_empreendimento, ";
                            $sql_i .= " $data_abertura, ";
                            $sql_i .= " $pessoas_ocupadas, ";
                            $sql_i .= " $logradouro_cep, ";
                            $sql_i .= " $logradouro_endereco, ";
                            $sql_i .= " $logradouro_numero, ";
                            $sql_i .= " $logradouro_bairro, ";
                            $sql_i .= " $logradouro_complemento, ";
                            $sql_i .= " $logradouro_cidade, ";
                            $sql_i .= " $logradouro_estado, ";
                            $sql_i .= " $logradouro_pais, ";

                            $sql_i .= " $logradouro_codbairro_e, ";
                            $sql_i .= " $logradouro_codcid_e, ";
                            $sql_i .= " $logradouro_codest_e, ";
                            $sql_i .= " $logradouro_codpais_e, ";

                            $sql_i .= " $idt_pais, ";
                            $sql_i .= " $idt_estado, ";
                            $sql_i .= " $idt_cidade, ";
                            $sql_i .= " $telefone_comercial, ";
                            $sql_i .= " $telefone_celular, ";
                            $sql_i .= " $email_e, ";
                            $sql_i .= " $sms, ";
                            $sql_i .= " $site_url, ";
                            $sql_i .= " $receber_informacao, ";
                            $sql_i .= " $representa_codcargcli, ";

                            $sql_i .= " $dap,  ";
                            $sql_i .= " $nirf,  ";
                            $sql_i .= " $rmp,  ";
                            $sql_i .= " $ie_prod_rural,  ";
                            $sql_i .= " $sicab_codigo,  ";
                            $sql_i .= " $sicab_dt_validade,  ";
                            $sql_i .= " $data_fim_atividade,  ";
                            $sql_i .= " $siacweb_situacao,  ";
                            $sql_i .= " $pa_senha, ";
                            $sql_i .= " $pa_idfacebook, ";
                            $sql_i .= " $idt_cnae_principal,  ";
                            $sql_i .= " $idt_porte,  ";
                            $sql_i .= " $idt_setor,  ";
                            $sql_i .= " $simples_nacional,  ";
                            $sql_i .= " $tamanho_propriedade  ";



                            $sql_i .= ') ';
                            $result = execsql($sql_i);

                            $idt_atendimento_organizacao = lastInsertId();


                            ForEach ($vetcmae as $idx => $rowcnae) {
                                $cnae = aspa($rowcnae['cnae']);
                                $principal = aspa($rowcnae['principal']);
                                $sql_i = ' insert into ' . db_pir_grc . 'grc_atendimento_organizacao_cnae ';
                                $sql_i .= ' (  ';
                                $sql_i .= " idt_atendimento_organizacao, ";
                                $sql_i .= " cnae, ";
                                $sql_i .= " principal ";
                                $sql_i .= '  ) values ( ';
                                $sql_i .= " $idt_atendimento_organizacao, ";
                                $sql_i .= " $cnae, ";
                                $sql_i .= " $principal ";
                                $sql_i .= ') ';
                                $result = execsql($sql_i);
                            }

                            if (is_array($grc_atendimento_organizacao_tipo_informacao)) {
                                foreach ($grc_atendimento_organizacao_tipo_informacao as $rowtt) {
                                    $sqlx = 'insert into ' . db_pir_grc . 'grc_atendimento_organizacao_tipo_informacao (idt, idt_tipo_informacao_e) values (';
                                    $sqlx .= null($idt_atendimento_organizacao) . ', ' . null($rowtt['idt_tipo_informacao']) . ')';
                                    execsql($sqlx);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    //Gera o registro da empresa do voucher
    if ($variavel['voucher_numero'] != '' && $variavel['idt_atendimento'] > 0) {
        $sql = 'update ' . db_pir_grc . 'grc_evento_publicacao_voucher_registro set';
        $sql .= ' dt_utilizacao = now(),';
        $sql .= ' idt_matricula_utilizado = ' . null($variavel['idt_atendimento']);
        $sql .= ' where numero = ' . aspa($variavel['voucher_numero']);
        execsql($sql);

        $sql = '';
        $sql .= ' select vr.idt_entidade_pj, v.perc_desconto';
        $sql .= ' from ' . db_pir_grc . 'grc_evento_publicacao_voucher_registro vr';
        $sql .= ' inner join ' . db_pir_grc . 'grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher';
        $sql .= ' where vr.numero = ' . aspa($variavel['voucher_numero']);
        $rs = execsql($sql);
        $rowV = $rs->data[0];
        $idt_entidade_pj = $rowV['idt_entidade_pj'];

        //Registra pagamento
        cadastraMatriculaDesconto($variavel['idt_atendimento'], $variavel['voucher_numero'], $variavel['voucher_numero'], $rowV['perc_desconto']);
        operacaoEventoPagamentoDesconto($variavel['idt_atendimento'], $variavel['vl_evento']);
    }

    if ($idt_entidade_pj != '') {
        $sql = '';
        $sql .= ' select e.codigo as cnpj, o.nirf, o.dap, o.rmp, o.ie_prod_rural, o.sicab_codigo';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade e';
        $sql .= ' left outer join ' . db_pir_gec . 'gec_entidade_organizacao o on o.idt_entidade = e.idt';
        $sql .= ' where e.idt = ' . null($idt_entidade_pj);
        $rs = execsql($sql);
        $row_par = $rs->data[0];

        $parCNPJ = Array();
        $parCNPJ['erro'] = "";

        if (validaCNPJ($row_par['cnpj'])) {
            $parCNPJ['cnpj'] = FormataCNPJ($row_par['cnpj']);
        } else {
            $parCNPJ['cnpj'] = '';
        }

        $parCNPJ['dap'] = $row_par['dap'];
        $parCNPJ['nirf'] = $row_par['nirf'];
        $parCNPJ['rmp'] = $row_par['rmp'];
        $parCNPJ['ie_prod_rural'] = $row_par['ie_prod_rural'];
        $parCNPJ['sicab_codigo'] = $row_par['sicab_codigo'];
        $parCNPJ['bancoTransaction'] = 'N';

        BuscaCNPJ($variavel['idt_atendimento'], $parCNPJ);

        $sql = "update " . db_pir_grc . "grc_atendimento_organizacao set novo_registro = 'N' where idt = " . null($parCNPJ['idt_atendimento_organizacao']);
        execsql($sql);

        $sql = "update " . db_pir_grc . "grc_atendimento_pessoa set representa_empresa = 'S'";
        $sql .= " where idt = " . null($variavel['idt_atendimento_pessoa']);
        execsql($sql);
    }

    if ($variavel['bancoTransaction'] != 'N') {
        commit();
    }

    /*

      //
      // Pegar os dados do cliente e gravar tb buscar empresas associadas
      //
      $variavel['cpf']                    = '061846425-53';
      $variavel['nome']                   = 'guy costa';
      $variavel['nome_tratamento']        = 'nome tratamento';
      $variavel['nome_pai']               =  'guy costa';
      $variavel['nome_mae']               = 'guy costa';
      $variavel['codigo_siacweb']         = '061846425-53';
      $variavel['tipo_relacao']           = '061846425-53';
      $variavel['logradouro_cep']         = '061846425-53';
      $variavel['logradouro_endereco']    = '061846425-53';
      $variavel['logradouro_numero']      = '061846425-53';
      $variavel['logradouro_bairro']      = '061846425-53';
      $variavel['logradouro_complemento'] = '061846425-53';
      $variavel['logradouro_cidade']      = '061846425-53';
      $variavel['logradouro_estado']      = '061846425-53';
      $variavel['logradouro_pais']        = '061846425-53';
      $variavel['idt_pais']               = '061846425-53';
      $variavel['idt_estado']             = '061846425-53';
      $variavel['idt_cidade']             = '061846425-53';
      $variavel['telefone_residencial']   = '061846425-53';
      $variavel['telefone_celular']       = '061846425-53';
      $variavel['telefone_recado']        = '061846425-53';
      $variavel['email']                  = '061846425-53';
      $variavel['sms']                    = '061846425-53';
      $variavel['nome_tratamento']        = '061846425-53';
      $variavel['idt_escolaridade']       = '061846425-53';
      $variavel['idt_sexo']               = '061846425-53';
      $variavel['data_nascimento']        = '061846425-53';
      $variavel['receber_informacao']     = '061846425-53';
      $variavel['necessidade_especial']   = '061846425-53';
      $variavel['idt_escolaridade']       = '061846425-53';
      $variavel['idt_profissao']          = '061846425-53';
      $variavel['idt_estado_civil']       = '061846425-53';
      $variavel['idt_cor_pele']           = '061846425-53';
      $variavel['idt_religiao']           = '061846425-53';
      $variavel['idt_destreza']           = '061846425-53';

      $variavel['idt_segmentacao']        = '061846425-53';
      $variavel['idt_subsegmentacao']     = '061846425-53';
      $variavel['idt_programa_fidelidade']= '061846425-53';


      $variavel['potencial_personagem']   = '061846425-53';


      // carrega dados da tela
      //$variavel['dados_tela']=$vetDados;
     */


    if (is_array($arqCopia)) {
        foreach ($arqCopia as $arq) {
            if (is_file($arq['de'])) {
                copy($arq['de'], $arq['para']);
            }
        }
    }




    $kokw = 1;
    return $kokw;
}

function BuscaCNAEPrincipal($idt_entidade_relacionada, &$vetretorno) {
    $cnae_principal = "";
    $vetcnae = Array();
    $sql1 = 'select ';
    $sql1 .= '  gec_ec.*   ';
    $sql1 .= '  from ' . db_pir_gec . 'gec_entidade_cnae gec_ec ';
    $sql1 .= '  where  gec_ec.idt_entidade_organizacao = ' . null($idt_entidade_relacionada);
    $sql1 .= '  order by principal, cnae ';

    $rs_aa = execsql($sql1);

    //p($sql1);

    if ($rs_aa->rows == 0) {
        
    } else {
        ForEach ($rs_aa->data as $rowp) {
            $cnae = $rowp['cnae'];
            $principal = $rowp['principal'];
            if ($principal == 'S') {
                $cnae_principal = $cnae;
            }
            $vetcnae[] = $rowp;
        }
    }
    $vetretorno = $vetcnae;
    //p($vetretorno);
    return $cnae_principal;
}

function GeraEmpreendimentoAtendimentoCadastro($idt_atendimento) {
    //
    //  Pessoa esta ligada a empreendimentos.
    //

    // Gerar registro inicial
    //
    $sql1 = 'select ';
    $sql1 .= '  grc_ao.*   ';
    $sql1 .= '  from grc_atendimento_organizacao grc_ao ';
    $sql1 .= ' where  grc_ao.idt_atendimento    = ' . null($idt_atendimento);
    //p($sql1);
    $rs_aa = execsql($sql1);
    if ($rs_aa->rows == 0) {
        // CRIAR REGISTRO ESPECIAL DO ATENDIMENTO
        //
        $cnpj_e = "###.{$idt_atendimento}";
        $razao_social_e = "### REGISTRO PARA SER INFORMADO ";
        $codigo_siacweb = aspa($codigo_siacweb_e);
        $idt_tipo_empreendimento = null($idt_tipo_empreendimento_e);
        $cnpj = aspa($cnpj_e);

        $razao_social = aspa($razao_social_e);
        $nome_fantasia = aspa($nome_fantasia_e);



        $data_abertura = aspa($data_abertura_e);
        $pessoas_ocupadas = null($pessoas_ocupadas_e);
        $logradouro_cep = aspa($cep_e);

        $logradouro_e = substr($logradouro_e, 0, 120);

        $logradouro_endereco = aspa($logradouro_e);
        $logradouro_numero = aspa($logradouro_numero_e);
        $logradouro_bairro = aspa($logradouro_bairro_e);
        $logradouro_complemento = aspa($logradouro_complemento_e);
        $logradouro_cidade = aspa($logradouro_municipio_e);
        $logradouro_estado = aspa($logradouro_estado_e);
        $logradouro_pais = aspa($logradouro_pais_e);
        $idt_pais = null($idt_pais_e);
        $idt_estado = null($idt_estado_e);
        $idt_cidade = null($idt_cidade_e);
        $telefone_comercial = aspa($telefone_comercial_e);
        $telefone_celular = aspa($telefone_celular_e);
        $sms = aspa($sms_e);
        $email = aspa($email_e);
        $site_url = aspa($site_url_e);
        $receber_informacao = aspa($receber_informacao_e);
        //
        $sql_i = ' insert into grc_atendimento_organizacao ';
        $sql_i .= ' (  ';
        $sql_i .= " idt_atendimento, ";
        $sql_i .= " cnpj, ";
        $sql_i .= " razao_social, ";
        $sql_i .= " nome_fantasia, ";
        $sql_i .= " codigo_siacweb_e, ";
        $sql_i .= " idt_tipo_empreendimento, ";
        $sql_i .= " data_abertura, ";
        $sql_i .= " pessoas_ocupadas, ";
        $sql_i .= " logradouro_cep_e, ";
        $sql_i .= " logradouro_endereco_e, ";
        $sql_i .= " logradouro_numero_e, ";
        $sql_i .= " logradouro_bairro_e, ";
        $sql_i .= " logradouro_complemento_e, ";
        $sql_i .= " logradouro_cidade_e, ";
        $sql_i .= " logradouro_estado_e, ";
        $sql_i .= " logradouro_pais_e, ";
        $sql_i .= " idt_pais_e, ";
        $sql_i .= " idt_estado_e, ";
        $sql_i .= " idt_cidade_e, ";
        $sql_i .= " telefone_comercial_e, ";
        $sql_i .= " telefone_celular_e, ";
        $sql_i .= " email_e, ";
        $sql_i .= " sms_e, ";
        $sql_i .= " site_url, ";
        $sql_i .= " receber_informacao_e ";
        $sql_i .= '  ) values ( ';
        $sql_i .= " $idt_atendimento, ";
        $sql_i .= " $cnpj, ";
        $sql_i .= " $razao_social, ";
        $sql_i .= " $nome_fantasia, ";
        $sql_i .= " $codigo_siacweb, ";
        $sql_i .= " $idt_tipo_empreendimento, ";
        $sql_i .= " $data_abertura, ";
        $sql_i .= " $pessoas_ocupadas, ";
        $sql_i .= " $logradouro_cep, ";
        $sql_i .= " $logradouro_endereco, ";
        $sql_i .= " $logradouro_numero, ";
        $sql_i .= " $logradouro_bairro, ";
        $sql_i .= " $logradouro_complemento, ";
        $sql_i .= " $logradouro_cidade, ";
        $sql_i .= " $logradouro_estado, ";
        $sql_i .= " $logradouro_pais, ";
        $sql_i .= " $idt_pais, ";
        $sql_i .= " $idt_estado, ";
        $sql_i .= " $idt_cidade, ";
        $sql_i .= " $telefone_comercial, ";
        $sql_i .= " $telefone_celular, ";
        $sql_i .= " $email, ";
        $sql_i .= " $sms, ";
        $sql_i .= " $site_url, ";
        $sql_i .= " $receber_informacao ";

        $sql_i .= ') ';
        $result = execsql($sql_i);

        //p($sql_i);
    }
}

function MontaGET(&$vetpar) {
    $vetpar['PROTOCOLO'] = $_SERVER['SERVER_PROTOCOL'];
    $vetpar['SERVIDOR_HTTP'] = $_SERVER['HTTP_HOST'];
    $vetpar['SERVIDOR'] = $_SERVER['SERVER_NAME'];
    $vetpar['PATH'] = $_SERVER['REQUEST_URI'];
    $vetpar['PROGRAMA_CHAMADO'] = $_SERVER['SCRIPT_NAME'];
    $endereco = $vetpar['PROGRAMA_CHAMADO'];
    $enderecow = str_replace('/', "##", $endereco);
    $enderecow = str_replace("\\", "##", $enderecow);
    $vetendereco = explode("##", $enderecow);
    $tam = count($vetendereco);
    $local = "";
    $programa = "";
    $qtd = 0;
    $separa = "";
    ForEach ($vetendereco as $Idx => $Valor) {
        $qtd = $qtd + 1;
        if ($qtd == $tam) {
            $programa = $Valor;
        } else {
            $local .= $separa . $Valor;
            $separa = "/";
        }
    }

    $vetpar['LOCAL'] = $local;
    $vetpar['PROGRAMA'] = $programa;
    $proto = strtolower(preg_replace('/[^a-zA-Z]/', '', $_SERVER['SERVER_PROTOCOL'])); //pegando só o que for letra
    $location = $proto . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
    $vetpar['ENTRADA'] = $location;

    $vetget = $vetpar['GET'];
    $refresh_l = $vetpar['PROGRAMA'] . '?';
    $separa = "";
    ForEach ($_GET as $Campo => $Valor) {
        $refresh_l .= $separa . $Campo . '=' . $Valor;
        $separa = "&";
    }
    $vetpar['REFRESH'] = $refresh_l;
    return $vetpar['REFRESH'];
}

function AjustaTelefoneSiacWEB($numerow) {
    $numero = $numerow;
    $tam = strlen($numero);
    if ($tam <= 8) {
        $numero = ZeroEsq($numero, 10);
        $numero = '(' . substr($numero, 0, 2) . ')' . substr($numero, 2, 4) . '-' . substr($numero, 6, 4);
    } else {
        if ($tam == 9) {
            $numero = ZeroEsq($numero, 11);
            $numero = '(' . substr($numero, 0, 2) . ')' . substr($numero, 2, 5) . '-' . substr($numero, 7, 4);
        } else {
            if ($tam == 10) {
                $numero = '(' . substr($numero, 0, 2) . ')' . substr($numero, 2, 4) . '-' . substr($numero, 6, 4);
            } else {
                if ($tam == 11) {
                    $numero = '(' . substr($numero, 0, 2) . ')' . substr($numero, 2, 5) . '-' . substr($numero, 7, 4);
                }
            }
        }
    }
    return $numero;
}

function DetalharHistorico($CodCliente, $CPFCliente, $DataHoraInicioRealizacao, $linha, $opcao, $CNPJ, &$html) {
    global $vetMes;
    $html = "";
    $sql = 'select ';
    $sql .= '  siac_his.*,  ';
    $sql .= '  siac_his.codrealizacao as siac_his_codrealizacao,  ';
    $sql .= '  siac_par.*,   ';
    $sql .= '  siac_pare.NomeRazaoSocial as siac_pare_NomeRazaoSocial,  ';


    $sql .= '  projeto.NomePRATIF        as projeto_NomePRATIF,  ';
    $sql .= '  acao.NomeAcao             as acao_NomeAcao,  ';
    $sql .= '  sebrae.descsebrae         as sebrae_descsebrae,  ';
    $sql .= '  sebrae.nomeabrev          as sebrae_nomeabrev,  ';
    $sql .= '  par_resp.NomeRazaoSocial  as par_resp_NomeRazaoSocial,  ';
    $sql .= '  evento.TituloEvento       as evento_TituloEvento,  ';
    $sql .= '  produto.NomeProduto       as produto_NomeProduto,  ';
    $sql .= '  app.aplicacaoDescricao    as app_aplicacaoDescricao  ';


    if ($opcao == 0) {
        $sql .= '  from  ' . db_pir_siac . 'historicorealizacoescliente siac_his';
    } else {
        $sql .= '  from  ' . db_pir_siac . 'historicorealizacoescliente_anosanteriores siac_his';
    }
    $sql .= '  inner join ' . db_pir_siac . 'parceiro siac_par  on siac_par.CodParceiro   = siac_his.CodCliente';
    $sql .= '  left  join ' . db_pir_siac . 'parceiro siac_pare on siac_pare.CodParceiro  = siac_his.CodEmpreedimento';
    $sql .= "  left  join  " . db_pir_siac . "tbpaipratif projeto      on projeto.CodPRATIF    = siac_his.CodProjeto ";
    $sql .= "  left  join  " . db_pir_siac . "tbpaiacao acao           on acao.CodAcao_Seq     = siac_his.CodAcao ";
    $sql .= "  inner join  " . db_pir_siac . "sebrae sebrae            on sebrae.codsebrae     = siac_his.CodSebrae ";
    $sql .= "  left  join  " . db_pir_siac . "parceiro par_resp        on par_resp.CodParceiro = siac_his.CodResponsavel ";
    $sql .= "  left  join  " . db_pir_siac . "evento evento            on evento.CodEvento = siac_his.CodRealizacao ";
    $sql .= "  left  join  " . db_pir_siac . "produtoportfolio produto on produto.CodProdutoPortfolio = evento.codProdutoPortfolio ";
    $sql .= "  left  join  " . db_pir_siac . "aplicacao app on app.aplicacaoCodigo = siac_his.CodAplicacao ";
    //$sql .= "  left  join  ".db_pir_siac."parceiro par_empre       on par_empre.CodParceiro = siac_his.codempreedimento ";
    $CPFClientew = str_replace('.', '', $CPFCliente);
    $CPFClientew = str_replace('-', '', $CPFClientew);
    $CPFClientew = str_replace('/', '', $CPFClientew);
    $CPFClientew = str_replace(' ', '', $CPFClientew);
    $CNPJW = str_replace('.', '', $CNPJ);
    $CNPJW = str_replace('-', '', $CNPJW);
    $CNPJW = str_replace('/', '', $CNPJW);
    $CNPJW = str_replace(' ', '', $CNPJW);
    if ($CNPJ == '') {
        if ($CPFClientew != "") {
            // veja isso pois entendi que não devemos pegar pelo codigo
            $sql .= '  where ( siac_his.CodCliente             = ' . null($CodCliente);
            $sql .= '     or siac_par.CgcCpf                   = ' . aspa($CPFClientew) . ' ) ';
        } else {
            $sql .= '  where siac_his.CodCliente               = ' . null($CodCliente);
        }
    } else {
        $sql .= '     where ( siac_pare.CgcCpf = ' . aspa($CNPJW) . ' ) ';
    }
    $sql .= '    and siac_his.DataHoraInicioRealizacao = ' . aspa($DataHoraInicioRealizacao);
    $rs = execsql($sql);
    //p($sql);
    if ($rs->rows == 0) {
        $html = " Não conseguiu detalhar ";
        // CodEmpreendimento
    } else {
        ForEach ($rs->data as $row) {
            $NomeRazaoSocial = $row['nomerazaosocial'];
            $CodRealizacao = $row['codrealizacao'];

            $siac_his_codrealizacao = $row['siac_his_codrealizacao'];

            $descrealizacao = $row['descrealizacao'];

            $NomeRealizacao = $row['nomerealizacao'];
            $DataHoraInicioRealizacao = trata_data($row['datahorainiciorealizacao']);
            $DataHoraFimRealizacao = trata_data($row['datahorafimrealizacao']);
            $Instrumento = $row['instrumento'];
            $Abordagem = $row['abordagem'];
            $NomeRealizacao = $row['nomerealizacao'];
            $CodResponsavel = $row['codresponsavel'];
            $CodSebrae = $row['codsebrae'];
            $projeto_NomePRATIF = $row['projeto_nomepratif'];
            $acao_NomeAcao = $row['acao_nomeacao'];
            $sebrae_descsebrae = $row['sebrae_descsebrae'];
            $sebrae_nomeabrev = $row['sebrae_nomeabrev'];
            $par_resp_NomeRazaoSocial = $row['par_resp_nomerazaosocial'];
            $evento_TituloEvento = $row['evento_tituloevento'];
            $produto_NomeProduto = $row['produto_nomeproduto'];
            $app_aplicacaoDescricao = $row['app_aplicacaodescricao'];
            $siac_pare_NomeRazaoSocial = $row['siac_pare_nomerazaosocial'];
            $Empreendimento = $siac_pare_NomeRazaoSocial;
            if ($Empreendimento == '') {
                $Empreendimento = "(Não se Aplica)";
            }
            //
            $MesAnoCompetencia = trata_data($row['mesanocompetencia']);
            $AnoCompetencia = substr($MesAnoCompetencia, 6, 4);
            $MesCompetencia = substr($MesAnoCompetencia, 3, 2);
            $Competencia = $vetMes[$MesCompetencia] . '/' . $AnoCompetencia;
            //$Competencia               = $MesAnoCompetencia;
            //
            $CargaHoraria = $row['cargahoraria'];
            $Produto = $row['codaplicacao'];
            $FocoTematico = $row['focotematico'];
            //
            $PontoAtendimento = $row['pontoatendimento'];
            $Atendente = $row['atendente'];
            $UnidadeRegonal = $row['unidaderegonal'];
            $Origem = $row['origem'];
            $DiagnosticoDevolutiva = $row['diagnosticodevolutiva'];
            $Observacao = $row['observacao'];
            //
            $tam = strlen($row['codprojeto']);
            //
            // echo " tamanho = $tam ";
            //
            $CodProjeto = bin2hex($row['codprojeto']);
            $CodAcao = $row['codacao'];
            //
            $CodProjetow = substr($CodProjeto, 0, 8);
            $CodProjetow .= '-' . substr($CodProjeto, 8, 4);
            $CodProjetow .= '-' . substr($CodProjeto, 12, 4);
            $CodProjetow .= '-' . substr($CodProjeto, 16, 4);
            $CodProjetow .= '-' . substr($CodProjeto, 20, 12);
            $CodProjetow = strtoupper($CodProjetow);
            //
            //$DescProjeto               = AcessaProjeto($CodProjetow);
            $Atendente = $par_resp_NomeRazaoSocial;
            $Produto = $produto_NomeProduto;
            $DescProjeto = $projeto_NomePRATIF;
            //
            $CodProjetoww = hexdec($CodProjeto);
            //
            $CodAcaow = decbin($CodAcao);
            $CodAcaow = bin2hex($CodAcaow);
            //
            //
            // echo " Proj  = ".$CodProjetow." Acao = ".$CodAcaow."<br />";
            //
            //
            //$DescAcao                  = AcessaAcao($CodProjetow,$CodAcaow);
            $DescAcao = $acao_NomeAcao;
            $DiagnosticoDevolutiva = $descrealizacao;
            //
            $data = substr(trata_data($DataHoraInicioRealizacao), 0, 10);
            if ($Abordagem == 'G') {
                $Abordagemw = 'Grupal';
            } else {
                $Abordagemw = 'Individual';
            }
            $html .= "<style>";
            $html .= ".atende_gc_cab_d { ";
            $html .= " background:#ECF0F1;";
            $html .= " color:#2A5696; ";
            $html .= " height:25px; ";
            $html .= " } ";
            //
            $html .= ".atende_gc_linha_d { ";
            $html .= " background:#FFFFFF;";
            $html .= " color:#000000; ";
            $html .= " height:30px; ";
            $html .= " } ";
            //
            $html .= "</style>";
            $html .= "<br />";
            $html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";

            $html .= "<tr  style = 'height:30px;' >  ";
            $html .= "   <td colspan='4' class='atende_gc_linha'   style = 'background:#2A5696; color:#FFFFFF; ' >";
            $onclickw = "onclick='return FechaDetalhe({$linha});'";
            $html .= "<div  style=''>";
            $html .= "<div {$onclickw} style='float:left;  padding-top:0px; xwidth:10%; '>";
            $html .= "<img id='img_g{$bia_agrupamento_codigo}' width='21' height='21' style='padding:4px; ' title='Fechar Detalhamento' src='imagens/fechar.png' border='0'>";
            $html .= "</div>";
            $html .= "<div style='float:left; padding-top:8px;  '>";
            $html .= "   Detalhamento ";
            $html .= "</div>";
            $html .= "</div>";
            $html .= "   </td> ";
            $html .= "</tr>";
            $html .= "<tr  style = '' >  ";
            $html .= "   <td colspan='2' class='atende_gc_cab_d'   style = '' >";
            $html .= "   Cliente: ";
            $html .= "   </td> ";
            $html .= "   <td colspan='2' class='atende_gc_cab_d'   style = '' >";
            $html .= "   Empreendimento:";
            $html .= "   </td> ";
            $html .= "</tr>";

            $html .= "<tr  style = 'height:30px;' >  ";
            $html .= "   <td colspan='2' class='atende_gc_linha_d'   style = '' >";
            $html .= "   {$NomeRazaoSocial}";
            $html .= "   </td> ";
            $html .= "   <td colspan='2' class='atende_gc_linha_d'   style = '' >";
            $html .= "   {$Empreendimento}";
            $html .= "   </td> ";
            $html .= "</tr>";

            $html .= "<tr  style = '' >  ";
            $html .= "   <td colspan='4' class='atende_gc_cab_d'   style = '' >";
            $html .= "   Nome da Realização: ";
            $html .= "   </td> ";
            $html .= "</tr>";

            $html .= "<tr  style = '' >  ";
            $html .= "   <td colspan='4' class='atende_gc_linha_d'   style = ' ' >";
            $html .= "   {$NomeRealizacao}";
            $html .= "   </td> ";
            $html .= "</tr>";

            $html .= "<tr  style = '' >  ";
            $html .= "   <td  class='atende_gc_cab_d'   style = '' >";
            $html .= "   Data do Atendimento: ";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_cab_d'   style = '' >";
            $html .= "   Fim do Atendimento:";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_cab_d'   style = '' >";
            $html .= "   Abordagem:";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_cab_d'   style = '' >";
            $html .= "   Mês/Ano Competência:";
            $html .= "   </td> ";
            $html .= "</tr>";

            $html .= "<tr  style = '' >  ";
            $html .= "   <td  class='atende_gc_linha_d'   style = ' ' >";
            $html .= "   {$DataHoraInicioRealizacao}";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_linha_d'   style = ' ' >";
            $html .= "   {$DataHoraFimRealizacao}";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_linha_d'   style = '' >";
            $html .= "   {$Abordagemw}";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_linha_d'   style = '' >";
            $html .= "   {$Competencia}";
            $html .= "   </td> ";
            $html .= "</tr>";

            $html .= "<tr  style = '' >  ";
            $html .= "   <td  class='atende_gc_cab_d'   style = '' >";
            $html .= "   Carga Horária: ";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_cab_d'   style = '' >";
            $html .= "   Instrumento:";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_cab_d'   style = '' >";
            $html .= "   Produto:";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_cab_d'   style = '' >";
            $html .= "   Foco Temático/Tema:";
            $html .= "   </td> ";
            $html .= "</tr>";

            $html .= "<tr  style = '' >  ";
            $html .= "   <td  class='atende_gc_linha_d'   style = ' ' >";
            $html .= "   {$CargaHoraria}";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_linha_d'   style = ' ' >";
            $html .= "   {$Instrumento}";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_linha_d'   style = '' >";
            $html .= "   {$Produto}";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_linha_d'   style = '' >";
            $html .= "   {$FocoTematico}";
            $html .= "   </td> ";
            $html .= "</tr>";

            $html .= "<tr  style = '' >  ";
            $html .= "   <td colspan='2' class='atende_gc_cab_d'   style = '' >";
            $html .= "   Projeto: ";
            $html .= "   </td> ";
            $html .= "   <td colspan='2' class='atende_gc_cab_d'   style = '' >";
            $html .= "   Ação:";
            $html .= "   </td> ";
            $html .= "</tr>";

            $html .= "<tr  style = 'height:30px;' >  ";
            $html .= "   <td colspan='2' class='atende_gc_linha_d'   style = '' >";
            $html .= "   {$DescProjeto}";
            $html .= "   </td> ";
            $html .= "   <td colspan='2' class='atende_gc_linha_d'   style = '' >";
            $html .= "   {$DescAcao}";
            $html .= "   </td> ";
            $html .= "</tr>";

//////////////////////////////////////////////// atendimento

            $html .= "<tr  style = '' >  ";
            $html .= "   <td  class='atende_gc_cab_d'   style = '' >";
            $html .= "   Atendente: ";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_cab_d'   style = '' >";
            $html .= "   Ponto de Atendimento:";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_cab_d'   style = '' >";
            $html .= "   Unidade Regional:";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_cab_d'   style = '' >";
            $html .= "   Sistema de Origem:";
            $html .= "   </td> ";

            $html .= "</tr>";


            $html .= "<tr  style = 'height:30px;' >  ";
            $html .= "   <td  class='atende_gc_linha_d'   style = '' >";
            $html .= "   {$Atendente}";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_linha_d'   style = '' >";
            $html .= "   {$PontoAtendimento}";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_linha_d'   style = '' >";
            $html .= "   {$UnidadeRegonal}";
            $html .= "   </td> ";
            $html .= "   <td  class='atende_gc_linha_d'   style = '' >";
            $html .= "   {$Origem}";
            $html .= "   </td> ";

            $html .= "</tr>";

            $html .= "<tr  style = '' >  ";
            $html .= "   <td colspan='2' class='atende_gc_cab_d'   style = 'width:50%' >";
            $html .= "   Diagnóstico/Devolutiva: ";
            $html .= "   </td> ";
            $html .= "   <td  colspan='2' class='atende_gc_cab_d'   style = 'width:50%' >";
            $html .= "   Observações:";
            $html .= "   </td> ";

            $html .= "</tr>";



            $html .= "<tr  style = 'height:30px;' >  ";
            $html .= "   <td colspan='2' class='atende_gc_linha_d'   style = '' >";
            $html .= "   {$DiagnosticoDevolutiva}";
            $html .= "   </td> ";
            $html .= "   <td colspan='2' class='atende_gc_linha_d'   style = '' >";
            $html .= "   {$Observacao}";
            $html .= "   </td> ";
            $html .= "</tr>";








            $html .= "<tr  style = 'height:10px;' >  ";
            $html .= "   <td colspan='4' class='atende_gc_linha'   style = 'background:#2A5696; color:#FFFFFF; ' >";
            $html .= "   </td> ";
            $html .= "</tr>";


//////////////////////////// colocado aqui por guy
            $hint = "Detalhar Resumo do Atendimento";

            $html .= "<tr  style = 'height:10px;' >  ";
            $html .= "   <td colspan='4' class='atende_gc_linha_d'   style = '' >";
            $html .= "<div style='cursor:normal; xfont-weight: bold; padding-top:5px; padding-bottom:5px; xtext-align:center; width:100%; background:#ECF0F1; color:#2A5696;'>";
            $html .= "Resumo do Atendimento:";
            $html .= "</div>";
            $html .= "<div style='width:100%; xbackground:#F1F1F1; color:#000000;'>";


            $CPFClienteGRCw = FormataCPF12($CPFClientew);
            $DataHoraInicioRealizacaow = trata_data($DataHoraInicioRealizacao);
            $tam = strlen($DataHoraInicioRealizacaow);
            if ($tam == 18) {
                $DataHoraInicioRealizacaow = $DataHoraInicioRealizacao . ":00";
            }
            $sqlt = 'select ';
            $sqlt .= '  grc_ar.*,  ';
            $sqlt .= '  grc_ara.descricao as grc_ara_descricao,   ';
            $sqlt .= '  grc_a.protocolo as grc_a_protocolo   ';
            $sqlt .= '  from  ' . db_pir_grc . 'grc_atendimento_resumo grc_ar';
            $sqlt .= '  inner join ' . db_pir_grc . 'grc_atendimento grc_a  on grc_a.idt = grc_ar.idt_atendimento';
            $sqlt .= '  inner join ' . db_pir_grc . 'grc_atendimento_pessoa grc_ap  on grc_ap.idt_atendimento = grc_a.idt';

            $sqlt .= '  inner join ' . db_pir_grc . 'grc_atendimento_resumo_acao grc_ara on grc_ara.idt = grc_ar.idt_acao ';


            $sqlt .= '    where grc_ap.cpf                     = ' . aspa($CPFClienteGRCw) . '  ';
            $sqlt .= '      and grc_a.data_inicio_atendimento = ' . aspa($DataHoraInicioRealizacaow) . '  ';
            $sqlt .= '  order by  grc_ar.numero ';
            $rst = execsql($sqlt);
            //p($sqlt);
            // guyresumo
            if ($rst->rows == 0) {
                //$html .= "<span style='font-weight: bold; font-size:16px; padding:5px;'> Atendimento Sem Informação do Resumo.</span>";
                $html .= "<span style='height:25px;'>&nbsp;</span>";
            } else {
                $grc_a_protocolow = "##";
                $qtdatendimento = $rst->rows;
                if ($qtdatendimento > 1) {
                    // $html .= "<span style='font-weight: bold; font-size:16px; padding:5px;'> Encontrados ($qtdatendimento) Atendimentos no CRM. Verificar.</span>";		
                }
                $linha = 0;
                ForEach ($rst->data as $rowt) {
                    $idt_acao = $rowt['idt_acao'];
                    $complemento_acao = $rowt['complemento_acao'];
                    $idt_atendimento = $rowt['idt_atendimento'];
                    $idt_atendimento_resumo = $rowt['idt'];
                    $descricao = $rowt['descricao'];
                    $link_util = $rowt['link_util'];
                    $grc_a_protocolo = $rowt['grc_a_protocolo'];
                    $grc_ara_descricao = $rowt['grc_ara_descricao'];
                    $protocolo = $rowt['protocolo'];
                    if ($grc_a_protocolo != $grc_a_protocolow) {
                        $grc_a_protocolow = $grc_a_protocolo;

                        $corb = "#D1D1D1";
                        $monta_descricao = "<div id='idt_resumo_{$grc_a_protocolo}' style = 'background:{$corb}; padding:10px;'>";
                        $monta_descricao .= " Protocolo Atendimento CRM|Sebrae: $grc_a_protocolo";
                        $monta_descricao .= "</div>";
                        $html .= " $monta_descricao ";
                    }


                    if ($linha == 0) {
                        $linha = 1;
                        $corb = "#F1F1F1";
                    } else {
                        $linha = 0;
                        $corb = "#FFFFFF";
                    }
                    $onclick = " title='{$hint}'  onclick='return ChamaAtendimentoResumo({$idt_atendimento},{$idt_atendimento_resumo}); ' ";

                    if ($idt_acao == 1) {
                        // Conteúdo da BIA
                    }
                    if ($idt_acao == 2) {
                        // Acesso a um Link útil
                        $clik = " window.open('" . $link_util . "', '_blank'); ";


                        $onclick = " title='{$hint}' onclick='" . $clik . "' ";

                        $onclick = "";
                    }
                    if ($idt_acao == 3) {
                        // Abertura de Consultoria SEBRAETEC
                    }
                    if ($idt_acao == 4) {
                        // Pendência de Atendimento
                    }
                    if ($idt_acao == 5) {
                        // Agendamento - Marcação
                    }
                    if ($idt_acao == 6) {
                        // Agendamento - Desmarcação
                    }
                    if ($idt_acao == 7) {
                        // Agendamento - Cancelamento
                    }
                    $monta_descricao = "<div  id='idt_resumo_{$idt_atendimento_resumo}' style = 'background:{$corb};padding:5px;'>";
                    $monta_descricao .= "<a href='{$link_util}' target='_blank' {$onclick}>";
                    $monta_descricao .= "<span style='color:#2F66B8'>" . $grc_ara_descricao . ": " . $complemento_acao . ":</span> " . $descricao;
                    $monta_descricao .= "</a>";
                    $monta_descricao .= "</div>";
                    $html .= " $monta_descricao ";
                }
            }
            $html .= "</div>";
            $html .= "   </td> ";
            $html .= "</tr>";



            $html .= "<tr  style = 'height:10px;' >  ";
            $html .= "   <td colspan='4' class='atende_gc_linha'   style = 'background:#2A5696; color:#FFFFFF; ' >";
            $html .= "   </td> ";
            $html .= "</tr>";









////////////////////////////

            $html .= "</table> ";
        }
    }
	
	    
	
    return $html;
}
function FunilHistoricoNotas($identificacao)
{

	// Histórico da nota do funil
	$html  = "";
	
	$sqlt  = 'select ';
	$sqlt .= '  grc_fhnc.*  ';
	$sqlt .= '  from  ' . db_pir_grc . 'grc_funil_historico_nota_classificacao grc_fhnc';
	$sqlt .= '    where grc_fhnc.identificacao = ' . aspa($identificacao) . '  ';
	$sqlt .= '  order by grc_fhnc.ano, grc_fhnc.datahora ';
	$rst = execsql($sqlt);
	//p($sqlt);
	// guyresumo
	if ($rst->rows == 0) {
		//$html .= "<span style='font-weight: bold; font-size:16px; padding:5px;'> Atendimento Sem Informação do Resumo.</span>";
		//$html .= "<span style='height:25px;'>&nbsp;</span>";
		$html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
		$html .= "<tr  style = 'height:30px;' >  ";
		$html .= "   <td colspan='4' class='atende_gc_linha'   style = 'background:#2A5696; color:#FFFFFF; ' >";
		$html .= "Histórico de Avaliação (NPS)";
		$html .= "   </td>";
		$html .= "   </tr>";
		$html .= "   <td colspan='4' class='atende_gc_linha'   style = 'background:#2A5696; color:#FFFFFF; ' >";
		$html .= "CLIENTE SEM HISTÓRICO";
		$html .= "   </td>";
		$html .= "   </tr>";
		
		$html .= "</table> ";				
	
	} else {
		$html .= "<br>";
		$html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
		$html .= "<tr  style = 'height:20px;' >  ";
		$html .= "   <td class=''   style = 'xpadding:10px; font-weight: bold; background:#2A5696; color:#FFFFFF; ' >";
		$onclick = " onclick=' return AbreHistoricoNota();' ";
		$html .= "<div style='float:left;'>";
		$img = " <img id='abrehistoriconota' {$onclick} title='Clique para ver Histórico das notas'  id='abrefecha'  class='' src='imagens/seta_cima.png' border='0' style='padding:5px; cursor:pointer;'>";
		$html .= "{$img}";
		$onclick = " onclick=' return FechaHistoricoNota();' ";
		$img = " <img id='fechahistoriconota' {$onclick} title='Clique para esconder Histórico das notas'  id='abrefecha'  class='' src='imagens/seta_baixo.png' border='0' style='padding:5px; display:none; cursor:pointer;'>";
		$html .= "{$img}";
		$html .= "</div>";
		$html .= "<div  style='float:left; padding-top:10px; '>";
		$html .= "Histórico de Avaliação (NPS)";
		$html .= "</div>";
		$html .= "   </td>";
		$html .= "   </tr>";
		$html .= "</table>";
		
		
		$html .= "<table id='idhistoriconota' style='display:none;' class='historiconota' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
		//$html .= "<tr  style = 'height:30px;' >  ";
		//$html .= "   <td colspan='4' class='historiconota'   style = 'padding:10px; font-weight: bold; background:#2A5696; color:#FFFFFF; ' >";
		
		
		//$html .= "HISTÓRICO DAS NOTAS DE CLASSIFICAÇÃO DO CLIENTE";
		//$html .= "   </td>";
		//$html .= "   </tr>";
		$html .= "<tr  style = 'height:25px;' >  ";
		$html .= "   <td class='historiconota'   style = 'background:#F1F1F1; color:#000000; ' >";
		$html .= "Ano";
		$html .= "   </td>";
		$html .= "   <td class='historiconota'   style = 'background:#F1F1F1; color:#000000; ' >";
		$html .= "Data";
		$html .= "   </td>";
		$html .= "   <td class='historiconota'   style = 'background:#F1F1F1; color:#000000; ' >";
		$html .= "Nota";
		$html .= "   </td>";
		$html .= "   <td class='historiconota'   style = 'background:#F1F1F1; color:#000000; ' >";
		$html .= "Comentário";
		$html .= "   </td>";
		$html .= "   <td class='historiconota'   style = 'background:#F1F1F1; color:#000000; ' >";
		$html .= "Classificacão";
		$html .= "   </td>";
		
		$html .= "   </tr>";
		$lin = 1;
		ForEach ($rst->data as $rowt) {
			$datahora   = trata_data($rowt['datahora']);
			$comentario = $rowt['comentario'];
			$ano        = $rowt['ano'];
			$nota       = $rowt['nota'];
			$notaw      = format_decimal($rowt['nota'],2);
			$idt_classificacao = $rowt['idt_classificacao'];
			
			$vetParametro = Array();
			$vetParametro['funil_idt_cliente_classificacao'] = $idt_cliente;
			$vetParametro['width_fase'] = "9em";
			$vetParametro['height_fase'] = "1.0em";
			$vetParametro['paddi_fase'] = "1.0em";
			$vetParametro['celula'] = "S";
			$vetParametro['font_size'] = "1.0em";
			$vetParametro['simplificado'] = "S";
			FunilExibeClassificacao($vetParametro);
			$classificacao = $vetParametro['html'];
			if ($lin == 1)
			{
			    $bgf="#FFFFFF";
				$lin = 1;
			}
			else
			{
			    $bgf="#F1F1F1";
				$lin = 2;
			}
			$html .= "<tr  style = 'height:30px;' >  ";
			$html .= "   <td class=''   style = 'background:{$bgf}; color:#000000; ' >";
			$html .= $ano;
			$html .= "   </td>";
			$html .= "   <td class='historiconota'   style = 'background:{$bgf}; color:#000000; ' >";
			$html .= $datahora;
			$html .= "   </td>";
			$html .= "   <td class='historiconota'   style = 'background:{$bgf}; color:#000000; ' >";
			$html .= $notaw;
			$html .= "   </td>";
			$html .= "   <td class='historiconota'   style = 'background:{$bgf}; color:#000000; ' >";
			$html .= $comentario;
			$html .= "   </td>";
			$html .= "   <td class='historiconota'   style = 'background:{$bgf}; color:#000000; ' >";
			$html .= $classificacao;
			$html .= "   </td>";
			
			$html .= "   </tr>";
		}
		$html .= "</table> ";	
	}
	$html .="<script>";
	$html .="function AbreHistoricoNota()";
	$html .="{ ";
	//$html .="alert(' teste '); ";
	
	$html .=" var id='#fechahistoriconota'; ";
	$html .=" $(id).show(); ";
	$html .=" var id='#abrehistoriconota'; ";
	$html .=" $(id).hide(); ";
	
	
	
	$html .=" var id='#idhistoriconota'; ";
	$html .=" $(id).show(); ";
	
	$html .="} ";
	
	$html .="function FechaHistoricoNota()";
	$html .="{ ";
	//$html .="alert(' teste '); ";
	$html .=" var id='#abrehistoriconota'; ";
	$html .=" $(id).show(); ";
	$html .=" var id='#fechahistoriconota'; ";
	$html .=" $(id).hide(); ";
	
	$html .=" var id='#idhistoriconota'; ";
	$html .=" $(id).hide(); ";
	$html .="} ";
	$html .="</script>";
	
	return $html;
}
function AcessaProjeto($codigo) {
    $sql = 'select ';
    $sql .= '  grc_p.*  ';
    $sql .= '  from  grc_projeto grc_p';
    $sql .= '  where grc_p.codigo  = ' . aspa($codigo);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $DescProjeto = " Não encontrado " . $codigo;
    } else {
        ForEach ($rs->data as $row) {
            $DescProjeto = $row['descricao'];
        }
    }
    return $DescProjeto;
}

function AcessaAcao($CodProjetow, $CodAcaow) {

    $sql = 'select ';
    $sql .= '  grc_pa.*  ';
    $sql .= '  from  grc_projeto_acao grc_pa';
    $sql .= '  where grc_pa.codigo_proj  = ' . aspa($CodProjetow);
    $sql .= '    and grc_pa.codigo  = ' . aspa($CodAcaow);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $DescAcao = " Não encontrado Projeto = " . $CodProjetow . " Ação= " . $CodAcaow;
    } else {
        ForEach ($rs->data as $row) {
            $DescAcao = $row['descricao'];
        }
    }
    return $DescAcao;
}

/**
 * Retorna o IDT do Painel do Ponto de Atendimento
 * @access public
 * @return int
 * @param int $idt_ponto_atendimento [opcional] <p>
 * IDT do Ponto de Atendimento<br />
 * Se o valor for zero vai ser usado o valor da variavel $_SESSION[CS]['g_idt_unidade_regional']
 * </p>
 * */
function idtAtendimentoPainel($idt_ponto_atendimento = 0) {
    if (nan == 'S') {
        return 'null';
    }

    if ($idt_ponto_atendimento == 0) {
        $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
    }

    if ($idt_ponto_atendimento == '') {
        $msg = 'Usuário não tem Ponto de Atendimento informado! Favor informar para continuar com a operação.';
        die($msg);
    } else {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from ' . db_pir_grc . 'grc_atendimento_painel';
        $sql .= ' where idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
        $sql .= " and ativo = 'S'";
        $sql .= ' order by idt desc limit 1';
        $rs = execsql($sql);

        if ($rs->rows == 0) {
            $sql = 'insert into ' . db_pir_grc . 'grc_atendimento_painel (codigo, descricao, ativo, idt_ponto_atendimento) values (';
            $sql .= "'cod_{$idt_ponto_atendimento}_ativo', 'Painel Ativo', 'S', " . null($idt_ponto_atendimento) . ')';
            execsql($sql);
            return lastInsertId();
        } else {
            return $rs->data[0][0];
        }
    }
}

function carregaCompetencia() {
    $sql1 = 'select ';
    $sql1 .= '  grc_com.*   ';
    $sql1 .= '  from ' . db_pir_grc . 'grc_competencia grc_com ';
    $sql1 .= '  where fechado = ' . aspa('N');
    $sql1 .= ' order by data_inicial limit 1';
    $rs_aa = execsql($sql1);
    if ($rs_aa->rows == 0) {
        unset($_SESSION[CS]['competencia']);
        $_SESSION[CS]['competencia']['erro'] = "Sem Competência Aberta";
    } else {
        $_SESSION[CS]['competencia']['erro'] = "Com Competência Aberta";
        $rowp = $rs_aa->data[0];
        $_SESSION[CS]['competencia']['row'] = $rowp;

        $ano = (int) $rowp['ano'];
        $mes = (int) $rowp['mes'] + 1;

        if ($mes == 13) {
            $mes = 1;
            $ano++;
        }

        if ($mes < 10) {
            $mes = '0' . $mes;
        }

        $sql1 = '';
        $sql1 .= ' select *';
        $sql1 .= ' from ' . db_pir_grc . 'grc_competencia';
        $sql1 .= ' where mes = ' . aspa($mes);
        $sql1 .= ' and ano = ' . aspa($ano);
        $rs_aa1 = execsql($sql1);
        $_SESSION[CS]['competencia']['row_proximo'] = $rs_aa1->data[0];
    }
}

/**
 * Retorna o IDT da Competencia em relação da data de referencia
 * @access public
 * @return int
 * @param string $data_referencia <p>
 * Data de referencia para saber qual a competencia vai ser utilizada<br />
 * <b>Formato:</b> dd/mm/yyyy
 * </p>
 * */
function idtCompetencia($data_referencia) {
    if (!is_array($_SESSION[CS]['competencia']['row']) || !is_array($_SESSION[CS]['competencia']['row_proximo'])) {
        carregaSession();
    }

    if (!is_array($_SESSION[CS]['competencia']['row'])) {
        die('Erro na competencia do mês atual! Favor verificar o registro.');
    }

    if (!is_array($_SESSION[CS]['competencia']['row_proximo'])) {
        die('Erro na competencia do próximo mês! Favor verificar o registro.');
    }

    if ($_SESSION[CS]['competencia']['erro'] == "Sem Competência Aberta") {
        $msg = 'Não tem um registro de competencia aberta! Favor resolver o problema para continuar com a operação.';
        die($msg);
    } else {
        $row = $_SESSION[CS]['competencia']['row'];
        $row_proximo = $_SESSION[CS]['competencia']['row_proximo'];
        $vetDtRef = DatetoArray($data_referencia);

        if ($row_proximo['mes'] == $vetDtRef['mes'] && $row_proximo['ano'] == $vetDtRef['ano']) {
            return $row_proximo['idt'];
        } else {
            return $row['idt'];
        }
    }
}

function ObterEstrutura($nome) {
    $estrutura = new pir_entidades($nome);
    //$vetestrutura = $estrutura -> estrutura($nome);


    $vetestrutura = $estrutura->estrutura_nomes($nome);


    //p($vetestrutura);
}

/////////////////////////////////// CNPJ

function BuscaCNPJ($idt_atendimento, &$variavel) {
    $kokw = 0;
    $cpf = $variavel['cpf'];
    $cnpj = $variavel['cnpj'];
    $variavel['idt_atendimento'] = $idt_atendimento;

    $idt_atendimento_agenda = $variavel['idt_atendimento_agenda'];

    $variavel['idt_atendimento_organizacao'] = 0;
    $variavel['codparceiro_lista'] = '';
    $cpf_w = $variavel['cpf'];
    $cnpj_w = $variavel['cnpj'];
    $codparceiro = $variavel['codparceiro'];
    $cpfcnpj_w = $cnpj_w;

    $temRegistro = false;

    $dadosPesq = Array();
    $dadosPesq['razao_social'] = $variavel['razao_social'];
    $dadosPesq['nome_fantasia'] = $variavel['nome_fantasia'];
    $dadosPesq['ie_prod_rural'] = $variavel['ie_prod_rural'];
    $dadosPesq['sicab_codigo'] = $variavel['sicab_codigo'];
    $dadosPesq['dap'] = $variavel['dap'];
    $dadosPesq['rmp'] = $variavel['rmp'];
    $dadosPesq['nirf'] = $variavel['nirf'];

    //
    // Se tem empresa associada Busca dados
    //
    $vetEntidade = Array();

    if ($variavel['bancoTransaction'] != 'N') {
        beginTransaction();
    }

    set_time_limit(600);

    $cpfcnpj_w = $cnpj_w;
    $kretw = BuscaDadosEntidadePIR($cpfcnpj_w, 'O', $vetEntidade, $codparceiro, $dadosPesq);

    if ($vetEntidade['PIR']['O']['existe_entidade'] != 'S') {
        if ($cnpj_w == "" && $codparceiro == "" && ($variavel['razao_social'] != '' || $variavel['nome_fantasia'] != '' || $variavel['ie_prod_rural'] != '' || $variavel['sicab_codigo'] != '' || $variavel['dap'] != '' || $variavel['rmp'] != '' || $variavel['nirf'] != '')) {
            $sql = '';
            $sql .= ' select j.codparceiro, p.cgccpf';
            $sql .= ' from pessoaj j with(nolock)';
            $sql .= ' inner join parceiro p with(nolock) on p.codparceiro = j.codparceiro';
            $sql .= ' where ';

            $vetSQL = Array();

            if ($variavel['ie_prod_rural'] != '') {
                $vetSQL[] = 'j.codprodutorrural = ' . aspa($variavel['ie_prod_rural']);
            }

            if ($variavel['sicab_codigo'] != '') {
                $vetSQL[] = 'j.codsicab = ' . aspa(preg_replace('/\./i', '', $variavel['sicab_codigo']));
            }

            if ($variavel['dap'] != '') {
                $vetSQL[] = 'j.coddap = ' . aspa($variavel['dap']);
            }

            if ($variavel['rmp'] != '') {
                $vetSQL[] = 'j.codpescador = ' . aspa($variavel['rmp']);
            }

            if ($variavel['nirf'] != '') {
                $vetSQL[] = 'j.nirf = ' . null(preg_replace('/[^0-9]/i', '', $variavel['nirf']));
            }

            if (count($vetSQL) == 0) {
                if ($variavel['razao_social'] != '') {
                    $vetSQL[] = 'lower(p.nomerazaosocial) like lower(' . aspa($variavel['razao_social'], '%', '%') . ')';
                }

                if ($variavel['nome_fantasia'] != '') {
                    $vetSQL[] = 'lower(p.nomeabrevfantasia) like lower(' . aspa($variavel['nome_fantasia'], '%', '%') . ')';
                }
            }

            if (count($vetSQL) == 0) {
                $sql .= ' 1 = 0 ';
            } else {
                $sql .= implode(' or ', $vetSQL);
            }

            $rs = execsql($sql, true, conSIAC());

            switch ($rs->rows) {
                case 0:
                    $idt_tipo_empreendimento_e = 7;
                    $dap_e = $variavel['dap'];
                    $nirf_e = $variavel['nirf'];
                    $rmp_e = $variavel['rmp'];
                    $ie_prod_rural_e = $variavel['ie_prod_rural'];
                    $sicab_codigo = $variavel['sicab_codigo'];
                    $razao_social_e = $variavel['razao_social'];
                    $nome_fantasia_e = $variavel['nome_fantasia'];

                    $variavel['idt_atendimento_organizacao'] = 0;
                    break;

                case 1:
                    /*
                      if ($rs->data[0]['cgccpf'] != '') {
                      $cnpj_w = FormataCNPJ($rs->data[0]['cgccpf']);
                      }
                     * 
                     */

                    $variavel['codparceiro'] = $rs->data[0]['codparceiro'];
                    $codparceiro = $variavel['codparceiro'];
                    break;

                default:
                    $vetTmp = Array();

                    foreach ($rs->data as $row) {
                        $vetTmp[$row['codparceiro']] = $row['codparceiro'];
                    }

                    $variavel['codparceiro_lista'] = implode(', ', $vetTmp);
                    return $kokw;
            }
        }

        $vetEntidade = Array();
        $kretw = BuscaDadosEntidadeSIACBA($cpfcnpj_w, 'J', $vetEntidade, $codparceiro);

        if ($cpfcnpj_w != '') {
            //$kretw = BuscaDadosEntidadeSIACNA($cpfcnpj_w, 'J', $vetEntidade);
            //$kretw = BuscaDadosEntidadeMEI($cpfcnpj_w, 'J', $vetEntidade);
            $kretw = BuscaDadosEntidadeRF($cpfcnpj_w, 'J', $vetEntidade);
        }
    }

    $vetpir = $vetEntidade['PIR']['O'];
    $codigo_siacweb_e = "";
    $idt_tipo_empreendimento_e = "";
    $cnpj_e = "";
    $razao_social_e = "";
    $nome_fantasia_e = "";
    $data_abertura_e = "";
    $pessoas_ocupadas_e = "";
    $cep_e = "";
    $logradouro_e = "";
    $logradouro_numero_e = "";
    $logradouro_bairro_e = "";
    $logradouro_complemento_e = "";
    $logradouro_municipio_e = "";
    $logradouro_estado_e = "";
    $logradouro_pais_e = "";

    $logradouro_codbairro_e = "";
    $logradouro_codcid_e = "";
    $logradouro_codest_e = "";
    $logradouro_codpais_e = "";

    $idt_pais_e = "";
    $idt_estado_e = "";
    $idt_cidade_e = "";
    $telefone_comercial_e = "";
    $telefone_celular_e = "";
    $sms_e = "";
    $email_e = "";
    $site_url_e = "";
    $receber_informacao_e = "";
    //p($vetpir);

    $totReg = $vetret['qtd_entidade'];
    if ($vetpir['existe_entidade'] == 'S') {
        $temRegistro = true;

        $qtd_entidade = $vetpir['qtd_entidade'];
        $idt_entidade = $vetpir['idt_entidade'];
        $cpfcnpj = $vetpir['cpfcnpj'];
        $idt_cliente = $vetpir['idt_cliente'];
        $nome = $vetpir['nome'];
        $telefone = $vetpir['telefone'];
        $celular = $vetpir['celular'];
        $email = $vetpir['email'];
        $cnpj = $vetpir['cnpj'];
        $nome_empresa = $vetpir['nome_empresa'];

        // funil
        $funil_idt_cliente_classificacao = $vetpir['funil_idt_cliente_classificacao'];
        $funil_cliente_nota_avaliacao = $vetpir['funil_cliente_nota_avaliacao'];
        $funil_cliente_data_avaliacao = $vetpir['funil_cliente_data_avaliacao'];
        $funil_cliente_obs_avaliacao = $vetpir['funil_cliente_obs_avaliacao'];

        //
        $cnpj_e = $cpfcnpj;
        $razao_social_e = $nome;
        $nome_fantasia_e = $nome;
        // complemento dependendo do tipo
        $vetdadosproprios = $vetpir['dadosproprios'];
        //p($vetdadosproprios);

        $idt_e = $vetdadosproprios['row']['idt'];
        $idt_origem_e = $vetdadosproprios['row']['idt_origem'];
        $idt_entidade_e = $vetdadosproprios['row']['idt_entidade'];
        $inscricao_estadual_e = $vetdadosproprios['row']['inscricao_estadual'];
        $inscricao_municipal_e = $vetdadosproprios['row']['inscricao_municipal'];
        $registro_junta_e = $vetdadosproprios['row']['registro_junta'];
        $data_registro_e = $vetdadosproprios['row']['data_registro'];
        $ativo_e = $vetdadosproprios['row']['ativo'];
        $idt_porte_e = $vetdadosproprios['row']['idt_porte'];
        $idt_tipo_e = $vetdadosproprios['row']['idt_tipo'];
        $idt_natureza_juridica_e = $vetdadosproprios['row']['idt_natureza_juridica'];
        $idt_faturamento_e = $vetdadosproprios['row']['idt_faturamento'];
        $faturamento_e = $vetdadosproprios['row']['faturamento'];
        $qt_funcionarios_e = $vetdadosproprios['row']['qt_funcionarios'];
        $data_inicio_atividade_e = $vetdadosproprios['row']['data_inicio_atividade'];
        $dap_e = $vetdadosproprios['row']['dap'];
        $nirf_e = $vetdadosproprios['row']['nirf'];
        $rmp_e = $vetdadosproprios['row']['rmp'];
        $ie_prod_rural_e = $vetdadosproprios['row']['ie_prod_rural'];
        $sicab_codigo = $vetdadosproprios['row']['sicab_codigo'];
        $sicab_dt_validade = $vetdadosproprios['row']['sicab_dt_validade'];
        $data_fim_atividade = $vetdadosproprios['row']['data_fim_atividade'];
        $siacweb_situacao = $vetpir['siacweb_situacao'];
        $pa_senha = $vetpir['pa_senha'];
        $pa_idfacebook = $vetpir['pa_idfacebook'];
        $startup_e = $vetdadosproprios['row']['startup'];
        $data_encerramento_e = $vetdadosproprios['row']['data_encerramento'];
        $simples_nacional_e = $vetdadosproprios['row']['simples_nacional'];
        $idt_entidade_setor_e = $vetdadosproprios['row']['idt_entidade_setor'];


        $grc_atendimento_organizacao_tipo_informacao = $vetpir['gec_entidade_x_tipo_informacao'];

        $idt_organizacao_e = $vetdadosproprios['row']['idt'];
        $codigo_siacweb_e = $vetpir['codigo_siacweb'];
        $idt_tipo_empreendimento_e = $vetpir['idt_tipo_empreendimento'];
        $idt_entidade_setor_e = $vetdadosproprios['row']['idt_entidade_setor'];
        $tamanho_propriedade_e = $vetdadosproprios['row']['tamanho_propriedade'];
        //
        $data_abertura_e = $vetdadosproprios['row']['data_inicio_atividade'];
        $pessoas_ocupadas_e = $vetdadosproprios['row']['qt_funcionarios'];
        $receber_informacao_e = $vetpir['receber_informacao'];
        $idt_porte_e = $vetdadosproprios['row']['idt_porte'];
        $idt_setor_e = $vetdadosproprios['row']['idt_entidade_setor'];
        $simples_nacional_e = $vetdadosproprios['row']['simples_nacional'];

        //
        // Busca cnae principal
        $vetcmae = Array();
        $cnae_principal = BuscaCNAEPrincipal($idt_organizacao_e, $vetcmae);

        $idt_cnae_principal_e = $cnae_principal;

        // Parte variável
        $vetenderecos = $vetpir['enderecos'];
        $vetprotocolos = $vetpir['protocolos'];
        $vetempresas = $vetpir['empresas'];
        //p($vetenderecos);

        $vetempresasPE = $vetempresas['PE'];
        $vetempresasEP = $vetempresas['EP'];

        ForEach ($vetenderecos as $idx => $Vettrab) {
            $vetendereco = $Vettrab['endereco'];
            $vetrow = $vetendereco['row'];
            //
            // 00 é o principal
            //
                //$vetrow['idt_entidade_endereco_tipo'];
            if ($vetrow['gec_eneet_codigo'] != "00" and $vetrow['gec_eneet_codigo'] != "99") {
                continue;
            }
            $logradouro_e = $vetrow['logradouro'];
            $logradouro_numero_e = $vetrow['logradouro_numero'];
            $logradouro_complemento_e = $vetrow['logradouro_complemento'];
            $logradouro_bairro_e = $vetrow['logradouro_bairro'];
            $logradouro_municipio_e = $vetrow['logradouro_municipio'];
            $logradouro_estado_e = $vetrow['logradouro_estado'];
            $logradouro_pais_e = $vetrow['logradouro_pais'];

            $logradouro_codbairro_e = $vetrow['logradouro_codbairro'];
            $logradouro_codcid_e = $vetrow['logradouro_codcid'];
            $logradouro_codest_e = $vetrow['logradouro_codest'];
            $logradouro_codpais_e = $vetrow['logradouro_codpais'];

            $logradouro_cep_e = $vetrow['logradouro_cep'];
            $cep_e = $vetrow['cep'];
            $logradouro_cep_e = $cep_e;

            $idt_pais_e = $vetrow['idt_pais'];
            $idt_estado_e = $vetrow['idt_estado'];
            $idt_cidade_e = $vetrow['idt_cidade'];

            $vetcomunicacaow = $vetendereco['comunicacao'];
            if (is_array($vetcomunicacaow)) {
                ForEach ($vetcomunicacaow as $idxw => $VetCom) {
                    if ($VetCom['comunicacao']['origem'] == 'ATENDIMENTO PRINCIPAL') {
                        $telefone_comercial_e = $VetCom['comunicacao']['telefone_1'];
                        $telefone_celular_e = $VetCom['comunicacao']['telefone_2'];
                        $sms_e = $VetCom['comunicacao']['sms_1'];
                        $email_e = $VetCom['comunicacao']['email_1'];
                        $site_url_e = $VetCom['comunicacao']['www_1'];
                    }
                }
            }
        }
    } else {
        $vetpir = $vetEntidade['SIACBA']['J'];

        $totReg += $vetret['qtd_entidade'];
        if ($vetpir['existe_entidade'] == 'S') {
            $temRegistro = true;

            $qtd_entidade = $vetpir['qtd_entidade'];
            $idt_entidade = $vetpir['idt_entidade'];
            $cpfcnpj = $vetpir['cpfcnpj'];
            $idt_cliente = $vetpir['idt_cliente'];
            $nome = $vetpir['nome'];
            $telefone = $vetpir['telefone'];
            $celular = $vetpir['celular'];
            $email = $vetpir['email'];
            $cnpj = $vetpir['cnpj'];
            $nome_empresa = $vetpir['nome_empresa'];

            // funil
            $funil_idt_cliente_classificacao = $vetpir['funil_idt_cliente_classificacao'];
            $funil_cliente_nota_avaliacao = $vetpir['funil_cliente_nota_avaliacao'];
            $funil_cliente_data_avaliacao = $vetpir['funil_cliente_data_avaliacao'];
            $funil_cliente_obs_avaliacao = $vetpir['funil_cliente_obs_avaliacao'];

            //
            $cnpj_e = $cpfcnpj;
            // complemento dependendo do tipo
            $vetdadosproprios = $vetpir['dadosproprios'];

            $codigo_siacweb_e = $vetdadosproprios['row']['codparceiro'];
            $cnpj_e = $vetdadosproprios['row']['cgccpf'];
            $razao_social_e = $vetdadosproprios['row']['nomerazaosocial'];
            $nome_fantasia_e = $vetdadosproprios['row']['nomeabrevfantasia'];
            $receber_informacao_e = $vetdadosproprios['row']['receberinfosebrae'];

            $inscricao_estadual_e = $vetdadosproprios['row']['inscest'];
            $inscricao_municipal_e = $vetdadosproprios['row']['inscmun'];
            $data_abertura_e = $vetdadosproprios['row']['databert'];

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade_tipo_emp';
            $sql .= ' where codigo = ' . aspa($vetdadosproprios['row']['codconst']);
            $rstt = execsql($sql);
            $idt_tipo_empreendimento_e = $rstt->data[0][0];

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade_setor';
            $sql .= ' where codigo = ' . aspa($vetdadosproprios['row']['codsetor']);
            $rstt = execsql($sql);
            $idt_setor_e = $rstt->data[0][0];

            $pessoas_ocupadas_e = $vetdadosproprios['row']['numfunc'];

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir_gec . 'gec_organizacao_porte';
            $sql .= ' where codigo = ' . aspa($vetdadosproprios['row']['faturam']);
            $rstt = execsql($sql);
            $idt_porte_e = $rstt->data[0][0];

            $dap_e = $vetdadosproprios['row']['coddap'];
            $nirf_e = $vetdadosproprios['row']['nirf'];
            $ie_prod_rural_e = $vetdadosproprios['row']['codprodutorrural'];
            $sicab_codigo = $vetdadosproprios['row']['codsicab'];
            $sicab_dt_validade = $vetdadosproprios['row']['datavalidade'];
            $data_fim_atividade = $vetdadosproprios['row']['data_fim_atividade'];
            $siacweb_situacao = $vetpir['siacweb_situacao'];
            $pa_senha = $vetpir['pa_senha'];
            $pa_idfacebook = $vetpir['pa_idfacebook'];

            if ($vetdadosproprios['row']['optantesimplesnacional'] == 0) {
                $simples_nacional_e = 'S';
            } else {
                $simples_nacional_e = 'N';
            }

            $tamanho_propriedade_e = $vetdadosproprios['row']['tamanhopropriedade'];
            $rmp_e = $vetdadosproprios['row']['codpescador'];

            // Busca cnae principal
            $vetcmae = Array();

            $sql = '';
            $sql .= ' select codativecon, codcnaefiscal, indativprincipal';
            $sql .= ' from ' . db_pir_siac . 'ativeconpj';
            $sql .= ' where codparceiro = ' . null($codigo_siacweb_e);
            $rstt = execsql($sql);

            foreach ($rstt->data as $rowtt) {
                $cnae = substr($rowtt['codativecon'], 0, 4) . '-' . substr($rowtt['codativecon'], 4) . '/' . $rowtt['codcnaefiscal'];

                if ($rowtt['indativprincipal'] == 1) {
                    $idt_cnae_principal_e = $cnae;
                } else {
                    $vetcmae[] = Array(
                        'cnae' => $cnae,
                        'principal' => 'N',
                    );
                }
            }

            // Comunicacao
            $vetcomunicacao = $vetpir['comunicacao']['row'];
            $telefone_comercial_e = $vetcomunicacao['telefone_1_p'];
            $telefone_celular_e = $vetcomunicacao['telefone_2_p'];
            $sms_e = $vetcomunicacao['telefone_3_p'];
            $email_e = $vetcomunicacao['email_1_p'];
            $site_url_e = $vetcomunicacao['www_1_p'];

            // Parte variável
            $vetenderecos = $vetpir['enderecos'];

            ForEach ($vetenderecos as $idx => $vetrow) {
                //
                // 00 é o principal
                //
                    if ($vetrow['gec_eneet_codigo'] != "00" and $vetrow['gec_eneet_codigo'] != "99") {
                    continue;
                }

                $logradouro_e = $vetrow['logradouro'];
                $logradouro_numero_e = $vetrow['logradouro_numero'];
                $logradouro_complemento_e = $vetrow['logradouro_complemento'];
                $logradouro_bairro_e = $vetrow['logradouro_bairro'];
                $logradouro_municipio_e = $vetrow['logradouro_municipio'];
                $logradouro_estado_e = $vetrow['logradouro_estado'];
                $logradouro_pais_e = $vetrow['logradouro_pais'];

                $logradouro_codbairro_e = $vetrow['logradouro_codbairro'];
                $logradouro_codcid_e = $vetrow['logradouro_codcid'];
                $logradouro_codest_e = $vetrow['logradouro_codest'];
                $logradouro_codpais_e = $vetrow['logradouro_codpais'];

                $cep_e = $vetrow['logradouro_cep'];

                $idt_pais_e = $vetrow['idt_pais'];
                $idt_estado_e = $vetrow['idt_estado'];
                $idt_cidade_e = $vetrow['idt_cidade'];
            }
        } else {
            $vetpir = $vetEntidade['RF']['J'];

            $totReg += $vetret['qtd_entidade'];
            if ($vetpir['existe_entidade'] == 'S') {
                $qtd_entidade = $vetpir['qtd_entidade'];
                $idt_entidade = $vetpir['idt_entidade'];
                $cpfcnpj = $vetpir['cpfcnpj'];
                $idt_cliente = $vetpir['idt_cliente'];
                $nome = $vetpir['nome'];
                $telefone = $vetpir['telefone'];
                $celular = $vetpir['celular'];
                $email = $vetpir['email'];
                $cnpj = $vetpir['cnpj'];
                $nome_empresa = $vetpir['nome_empresa'];
                $cnpj_e = $cpfcnpj;
                $codigo_siacweb_e = $vetpir['codigo_siacweb_e'];
                $cnpj_e = $vetpir['cgccpf'];
                $razao_social_e = $vetpir['razao_social_e'];
                $nome_fantasia_e = $vetpir['nome_fantasia_e'];
                $receber_informacao_e = $vetpir['receber_informacao_e'];
                $inscricao_estadual_e = $vetpir['inscricao_estadual_e'];
                $inscricao_municipal_e = $vetpir['inscricao_municipal_e'];
                $data_abertura_e = $vetpir['data_abertura_e'];

                $idt_tipo_empreendimento_e = $vetpir['idt_tipo_empreendimento_e'];
                $idt_setor_e = $vetpir['idt_setor_e'];
                $pessoas_ocupadas_e = $vetpir['pessoas_ocupadas_e'];
                $idt_porte_e = $vetpir['idt_porte_e'];

                $dap_e = $vetpir['dap_e'];
                $nirf_e = $vetpir['nirf_e'];
                $ie_prod_rural_e = $vetpir['ie_prod_rural_e'];
                $sicab_codigo = $vetpir['sicab_codigo'];
                $sicab_dt_validade = $vetpir['sicab_dt_validade'];
                $data_fim_atividade = $vetpir['data_fim_atividade'];
                $siacweb_situacao = $vetpir['siacweb_situacao'];
                $pa_senha = $vetpir['pa_senha'];
                $pa_idfacebook = $vetpir['pa_idfacebook'];

                $simples_nacional_e = $vetpir['simples_nacional_e'];

                $tamanho_propriedade_e = $vetpir['tamanho_propriedade_e'];
                $rmp_e = $vetpir['rmp_e'];

                $idt_cnae_principal_e = $vetpir['idt_cnae_principal_e'];

                $telefone_comercial_e = $vetpir['telefone_comercial_e'];
                $telefone_celular_e = $vetpir['telefone_celular_e'];
                $sms_e = $vetpir['sms_e'];
                $email_e = $vetpir['email_e'];
                $site_url_e = $vetpir['site_url_e'];

                $logradouro_e = $vetpir['logradouro_e'];
                $logradouro_numero_e = $vetpir['logradouro_numero_e'];
                $logradouro_complemento_e = $vetpir['logradouro_complemento_e'];
                $logradouro_bairro_e = $vetpir['logradouro_bairro_e'];
                $logradouro_municipio_e = $vetpir['logradouro_municipio_e'];
                $logradouro_estado_e = $vetpir['logradouro_estado_e'];
                $logradouro_pais_e = $vetpir['logradouro_pais_e'];
                $logradouro_codbairro_e = $vetpir['logradouro_codbairro_e'];
                $logradouro_codcid_e = $vetpir['logradouro_codcid_e'];
                $logradouro_codest_e = $vetpir['logradouro_codest_e'];
                $logradouro_codpais_e = $vetpir['logradouro_codpais_e'];
                $cep_e = $vetpir['cep_e'];
                $idt_pais_e = $vetpir['idt_pais_e'];
                $idt_estado_e = $vetpir['idt_estado_e'];
                $idt_cidade_e = $vetpir['idt_cidade_e'];
            }
        }
    }

    //
    //  Gerar registro de empreendimento
    //
    
    if ($temRegistro || $totReg == 0) {
        $sql1 = 'select ';
        $sql1 .= '  grc_ao.*   ';
        $sql1 .= '  from ' . db_pir_grc . 'grc_atendimento_organizacao grc_ao ';
        $sql1 .= ' where  grc_ao.idt_atendimento    = ' . null($idt_atendimento);

        if ($cnpj_w == '') {
            $sql1 .= '   and  grc_ao.codigo_siacweb_e   = ' . aspa($codparceiro);
        } else {
            $sql1 .= '   and  grc_ao.cnpj               = ' . aspa($cnpj_w);
        }

        //p($sql1);
        $rs_aa = execsql($sql1);
        if ($rs_aa->rows == 0) {
            $rowSIAC = situacaoParceiroSiacWeb('J', $cnpj_w, $nirf_e, $dap_e, $rmp_e, $ie_prod_rural_e, $sicab_codigo);

            if ($rowSIAC['siacweb_situacao'] !== '') {
                $siacweb_situacao = $rowSIAC['siacweb_situacao'];
                $data_fim_atividade = $rowSIAC['data_fim_atividade'];
            }

            $sql = '';
            $sql .= ' select c.idt_entidade_setor';
            $sql .= ' from ' . db_pir_gec . 'cnae c';
            $sql .= ' where c.codclass_siacweb = 1';
            $sql .= ' and c.subclasse = ' . aspa($idt_cnae_principal_e);
            $rstt = execsql($sql);

            if ($rstt->data[0][0] != '') {
                $idt_setor_e = $rstt->data[0][0];
            }

            // $cnpj_e              = aspa($cnpj);
            // $razao_social_e      = aspa($razao_social);
            $codigo_siacweb = aspa($codigo_siacweb_e);

            if ($idt_tipo_empreendimento_e == '') {
                $idt_tipo_empreendimento_e = $variavel['idt_tipo_empreendimento'];
            }

            $idt_tipo_empreendimento = null($idt_tipo_empreendimento_e);
            $codigo_prod_rural = 'null';

            if ($cnpj_w == '' || !validaCNPJ($cnpj_w)) {
                $cnpj = $cnpj_e;

                if ($cnpj == '') {
                    $codigo_prod_rural = aspa('PRGRC' . AutoNum('grc_atendimento_organizacao_cnpj_PR', 10, false, false, db_pir_grc));
                    $cnpj = $codigo_prod_rural;
                } else if (validaCNPJ($cnpj)) {
                    $cnpj = aspa(FormataCNPJ($cnpj));
                } else {
                    $cnpj = aspa($cnpj);
                    $codigo_prod_rural = $cnpj;
                }
            } else {
                $cnpj = aspa($cnpj_w);
            }

            if ($razao_social_e == '') {
                $razao_social_e = 'Novo Empreendimento';
            }
            $razao_social = aspa($razao_social_e);
            $nome_fantasia = aspa($nome_fantasia_e);

            // funil
            $funil_idt_cliente_classificacao = null($funil_idt_cliente_classificacao);
            $funil_cliente_nota_avaliacao = null($funil_cliente_nota_avaliacao);
            $funil_cliente_data_avaliacao = aspa($funil_cliente_data_avaliacao);
            $funil_cliente_obs_avaliacao = aspa($funil_cliente_obs_avaliacao);



            $data_abertura = aspa($data_abertura_e);
            $pessoas_ocupadas = null($pessoas_ocupadas_e);
            $logradouro_cep = aspa($cep_e);

            $logradouro_e = substr($logradouro_e, 0, 120);

            $logradouro_endereco = aspa($logradouro_e);
            $logradouro_numero = aspa($logradouro_numero_e);
            $logradouro_bairro = aspa($logradouro_bairro_e);
            $logradouro_complemento = aspa($logradouro_complemento_e);
            $logradouro_cidade = aspa($logradouro_municipio_e);
            $logradouro_estado = aspa($logradouro_estado_e);
            $logradouro_pais = aspa($logradouro_pais_e);

            $logradouro_codbairro_e = null($logradouro_codbairro_e);
            $logradouro_codcid_e = null($logradouro_codcid_e);
            $logradouro_codest_e = null($logradouro_codest_e);
            $logradouro_codpais_e = null($logradouro_codpais_e);

            $idt_pais = null($idt_pais_e);
            $idt_estado = null($idt_estado_e);
            $idt_cidade = null($idt_cidade_e);
            $telefone_comercial = aspa($telefone_comercial_e);
            $telefone_celular = aspa($telefone_celular_e);
            $sms = aspa($sms_e);
            $email = aspa($email_e);
            $site_url = aspa($site_url_e);
            $receber_informacao = aspa($receber_informacao_e);
            //
            $dap = aspa($dap_e);
            $nirf = aspa(FormataNirf($nirf_e));
            $rmp = aspa($rmp_e);
            $ie_prod_rural = aspa($ie_prod_rural_e);
            $sicab_codigo = aspa(FormataSICAB($sicab_codigo));
            $sicab_dt_validade = aspa($sicab_dt_validade);
            $data_fim_atividade = aspa($data_fim_atividade);

            if ($siacweb_situacao == '') {
                $siacweb_situacao = 1;
            }

            $siacweb_situacao = null($siacweb_situacao);
            $pa_senha = aspa($pa_senha);
            $pa_idfacebook = aspa($pa_idfacebook);
            $data_abertura = aspa($data_abertura_e);
            $pessoas_ocupadas = aspa($pessoas_ocupadas_e);
            $idt_cnae_principal = aspa($idt_cnae_principal_e);
            $idt_porte = null($idt_porte_e);
            $idt_setor = null($idt_setor_e);
            $simples_nacional = null($simples_nacional_e);
            $tamanho_propriedade = null($tamanho_propriedade_e);


            //
            //p('---------------- '.$data_abertura_e);
            //
        set_time_limit(30);
            //
            $sql_i = ' insert into ' . db_pir_grc . 'grc_atendimento_organizacao ';
            $sql_i .= ' (  ';
            $sql_i .= ' novo_registro, ';
            $sql_i .= ' modificado, ';
            $sql_i .= " idt_atendimento, ";
            $sql_i .= " cnpj, ";
            $sql_i .= " codigo_prod_rural, ";
            $sql_i .= " razao_social, ";
            $sql_i .= " nome_fantasia, ";

            // Funil
            $sql_i .= " funil_idt_cliente_classificacao, ";
            $sql_i .= " funil_cliente_nota_avaliacao, ";
            $sql_i .= " funil_cliente_data_avaliacao, ";
            $sql_i .= " funil_cliente_obs_avaliacao, ";

            $sql_i .= " codigo_siacweb_e, ";
            $sql_i .= " idt_tipo_empreendimento, ";
            $sql_i .= " data_abertura, ";
            $sql_i .= " pessoas_ocupadas, ";
            $sql_i .= " logradouro_cep_e, ";
            $sql_i .= " logradouro_endereco_e, ";
            $sql_i .= " logradouro_numero_e, ";
            $sql_i .= " logradouro_bairro_e, ";
            $sql_i .= " logradouro_complemento_e, ";
            $sql_i .= " logradouro_cidade_e, ";
            $sql_i .= " logradouro_estado_e, ";
            $sql_i .= " logradouro_pais_e, ";

            $sql_i .= " logradouro_codbairro_e, ";
            $sql_i .= " logradouro_codcid_e, ";
            $sql_i .= " logradouro_codest_e, ";
            $sql_i .= " logradouro_codpais_e, ";

            $sql_i .= " idt_pais_e, ";
            $sql_i .= " idt_estado_e, ";
            $sql_i .= " idt_cidade_e, ";
            $sql_i .= " telefone_comercial_e, ";
            $sql_i .= " telefone_celular_e, ";
            $sql_i .= " email_e, ";
            $sql_i .= " sms_e, ";
            $sql_i .= " site_url, ";
            $sql_i .= " receber_informacao_e, ";
            $sql_i .= " dap,  ";
            $sql_i .= " nirf,  ";
            $sql_i .= " rmp,  ";
            $sql_i .= " ie_prod_rural,  ";
            $sql_i .= " sicab_codigo,  ";
            $sql_i .= " sicab_dt_validade,  ";
            $sql_i .= " data_fim_atividade,  ";
            $sql_i .= " siacweb_situacao_e,  ";
            $sql_i .= " pa_senha_e, ";
            $sql_i .= " pa_idfacebook_e, ";
            $sql_i .= " idt_cnae_principal,  ";
            $sql_i .= " idt_porte,  ";
            $sql_i .= " idt_setor,  ";
            $sql_i .= " simples_nacional,  ";
            $sql_i .= " tamanho_propriedade  ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " 'S', ";
            $sql_i .= " 'N', ";
            $sql_i .= " $idt_atendimento, ";
            $sql_i .= " $cnpj, ";
            $sql_i .= " $codigo_prod_rural, ";
            $sql_i .= " $razao_social, ";
            $sql_i .= " $nome_fantasia, ";

            // Funil
            $sql_i .= " $funil_idt_cliente_classificacao, ";
            $sql_i .= " $funil_cliente_nota_avaliacao, ";
            $sql_i .= " $funil_cliente_data_avaliacao, ";
            $sql_i .= " $funil_cliente_obs_avaliacao, ";


            $sql_i .= " $codigo_siacweb, ";
            $sql_i .= " $idt_tipo_empreendimento, ";
            $sql_i .= " $data_abertura, ";
            $sql_i .= " $pessoas_ocupadas, ";
            $sql_i .= " $logradouro_cep, ";
            $sql_i .= " $logradouro_endereco, ";
            $sql_i .= " $logradouro_numero, ";
            $sql_i .= " $logradouro_bairro, ";
            $sql_i .= " $logradouro_complemento, ";
            $sql_i .= " $logradouro_cidade, ";
            $sql_i .= " $logradouro_estado, ";
            $sql_i .= " $logradouro_pais, ";

            $sql_i .= " $logradouro_codbairro_e, ";
            $sql_i .= " $logradouro_codcid_e, ";
            $sql_i .= " $logradouro_codest_e, ";
            $sql_i .= " $logradouro_codpais_e, ";

            $sql_i .= " $idt_pais, ";
            $sql_i .= " $idt_estado, ";
            $sql_i .= " $idt_cidade, ";
            $sql_i .= " $telefone_comercial, ";
            $sql_i .= " $telefone_celular, ";
            $sql_i .= " $email, ";
            $sql_i .= " $sms, ";
            $sql_i .= " $site_url, ";
            $sql_i .= " $receber_informacao, ";
            $sql_i .= " $dap,  ";
            $sql_i .= " $nirf,  ";
            $sql_i .= " $rmp,  ";
            $sql_i .= " $ie_prod_rural,  ";
            $sql_i .= " $sicab_codigo,  ";
            $sql_i .= " $sicab_dt_validade,  ";
            $sql_i .= " $data_fim_atividade,  ";
            $sql_i .= " $siacweb_situacao,  ";
            $sql_i .= " $pa_senha, ";
            $sql_i .= " $pa_idfacebook, ";
            $sql_i .= " $idt_cnae_principal,  ";
            $sql_i .= " $idt_porte,  ";
            $sql_i .= " $idt_setor,  ";
            $sql_i .= " $simples_nacional,  ";
            $sql_i .= " $tamanho_propriedade  ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
            //p($sql_i);
            //
            $idt_atendimento_organizacao = lastInsertId();
            ForEach ($vetcmae as $idx => $rowcnae) {
                if ($rowcnae['principal'] == 'N') {
                    $cnae = aspa($rowcnae['cnae']);
                    $principal = aspa($rowcnae['principal']);
                    $sql_i = ' insert into ' . db_pir_grc . 'grc_atendimento_organizacao_cnae ';
                    $sql_i .= ' (  ';
                    $sql_i .= " idt_atendimento_organizacao, ";
                    $sql_i .= " cnae, ";
                    $sql_i .= " principal ";
                    $sql_i .= '  ) values ( ';
                    $sql_i .= " $idt_atendimento_organizacao, ";
                    $sql_i .= " $cnae, ";
                    $sql_i .= " $principal ";
                    $sql_i .= ') ';
                    $result = execsql($sql_i);
                }
            }

            if (is_array($grc_atendimento_organizacao_tipo_informacao)) {
                foreach ($grc_atendimento_organizacao_tipo_informacao as $rowtt) {
                    $sqlx = 'insert into ' . db_pir_grc . 'grc_atendimento_organizacao_tipo_informacao (idt, idt_tipo_informacao_e) values (';
                    $sqlx .= null($idt_atendimento_organizacao) . ', ' . null($rowtt['idt_tipo_informacao']) . ')';
                    execsql($sqlx);
                }
            }

            $variavel['idt_atendimento_organizacao'] = $idt_atendimento_organizacao;
        } else {
            $variavel['idt_atendimento_organizacao'] = $rs_aa->data[0]['idt'];

            $sql = '';
            $sql .= ' select c.idt_entidade_setor';
            $sql .= ' from ' . db_pir_gec . 'cnae c';
            $sql .= ' where c.codclass_siacweb = 1';
            $sql .= ' and c.subclasse = ' . aspa($idt_cnae_principal_e);
            $rstt = execsql($sql);

            if ($rstt->data[0][0] == '') {
                $idt_setor_txt = '';
            } else {
                $idt_setor_txt = ', idt_setor = ' . null($rstt->data[0][0]);
            }

            $sql = "update " . db_pir_grc . "grc_atendimento_organizacao set modificado = 'N', desvincular = 'N' {$idt_setor_txt} where idt = " . null($variavel['idt_atendimento_organizacao']);
            execsql($sql);
        }
    } else {
        $variavel['idt_atendimento_organizacao'] = 0;
    }

    if ($cnpj_w == "" && ($variavel['ie_prod_rural'] != '' || $variavel['sicab_codigo'] != '' || $variavel['dap'] != '' || $variavel['rmp'] != '' || $variavel['nirf'] != '')) {
        $vetUP = Array(
            'ie_prod_rural' => 'ie_prod_rural = null',
            'sicab_codigo' => 'sicab_codigo = null',
            'dap' => 'dap = null',
            'rmp' => 'rmp = null',
            'nirf' => 'nirf = null',
        );

        if ($variavel['ie_prod_rural'] != '') {
            unset($vetUP['ie_prod_rural']);
        }

        if ($variavel['sicab_codigo'] != '') {
            unset($vetUP['sicab_codigo']);
        }

        if ($variavel['dap'] != '') {
            unset($vetUP['dap']);
        }

        if ($variavel['rmp'] != '') {
            unset($vetUP['rmp']);
        }

        if ($variavel['nirf'] != '') {
            unset($vetUP['nirf']);
        }

        if (count($vetUP) > 0) {
            $sql = "update " . db_pir_grc . "grc_atendimento_organizacao set " . implode(', ', $vetUP) . " where idt = " . null($variavel['idt_atendimento_organizacao']);
            execsql($sql);
        }
    }

    if ($variavel['bancoTransaction'] != 'N') {
        commit();
    }

    $kokw = 1;
    return $kokw;
}

///////////////////////////////////////////////////

function BuscaCPF_MAIS($idt_atendimento, &$variavel) {
    $kokw = 0;
    $cpf = $variavel['cpf'];
    $cnpj = $variavel['cnpj'];
    $idt_instrumento = $variavel['idt_instrumento'];
    $idt_atendimento_agenda = $variavel['idt_atendimento_agenda'];

    if ($variavel['tipo_relacao'] == '') {
        $variavel['tipo_relacao'] = 'P';
    }

    beginTransaction();

    if ($variavel['idt_evento'] != '') {
        //Verifica se tem PÚBLICO FECHADO
        $sql = '';
        $sql .= ' select ep.idt';
        $sql .= ' from ' . db_pir_grc . 'grc_evento ep';
        $sql .= ' where ep.idt = ' . null($variavel['idt_evento']);
        $sql .= " and ep.publico_ab_fe = 'F'";
        $rs = execsql($sql);

        if ($rs->rows > 0) {
            $sql = '';
            $sql .= ' select idt';
            $sql .= " from " . db_pir_grc . "grc_evento_publico";
            $sql .= ' where idt_evento = ' . null($rs->data[0][0]);
            $sql .= ' and cpf = ' . aspa(FormataCPF12($variavel['cpf']));
            $rs = execsql($sql);

            if ($rs->rows == 0) {
                $msg = 'Este evento é de Público Fechado e este CPF não esta na lista de matricula!';
                $variavel['idt_atendimento_pessoa'] = $msg;
                $variavel['idt_atendimento_agenda'] = $msg;

                if ($variavel['bancoTransaction'] != 'N') {
                    rollBack();
                }

                return $kokw;
            }
        }

        if ($variavel['filadeespera'] != 'S') {

            $sql = "update grc_evento set qtd_vagas_resevado = qtd_vagas_resevado + 1";
            $sql .= " where idt = " . null($variavel['idt_evento']);
            execsql($sql);

            $sql = "select gec_prog.tipo_ordem, grc_e.composto";
            $sql .= ' from grc_evento grc_e';
            $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = grc_e.idt_programa';
            $sql .= " where grc_e.idt = " . null($variavel['idt_evento']);
            $rsVaga = execsql($sql);
            $rowVaga = $rsVaga->data[0];

            if ($rowVaga['tipo_ordem'] != 'SG' && $rowVaga['composto'] == 'N') {
                $sql = '';
                $sql .= ' select quantidade_participante + qtd_vagas_adicional as qtd, qtd_matriculado_siacweb + qtd_vagas_resevado + qtd_vagas_bloqueadas as tot';
                $sql .= ' from grc_evento';
                $sql .= " where idt = " . null($variavel['idt_evento']);
                $rsVaga = execsql($sql);
                $rowVaga = $rsVaga->data[0];

                if ($rowVaga['qtd'] != '') {
                    if ($rowVaga['tot'] > $rowVaga['qtd']) {
                        $msg = 'Não tem mais vaga disponível no Evento!';
                        $variavel['idt_atendimento_pessoa'] = $msg;
                        $variavel['idt_atendimento_agenda'] = $msg;
                        
                        if ($variavel['bancoTransaction'] != 'N') {
                            rollBack();
                        }
                        
                        return $kokw;
                    }
                }
            }
        }
    }

    $variavel['idt_atendimento'] = $idt_atendimento;

    $cpf_w = $variavel['cpf'];
    $cnpj_w = $variavel['$cnpj'];

    $idt_pj = $variavel['idt_pj'];
    $idt_pf = $variavel['idt_pf'];


    $cpfcnpj_w = $cpf;
    $vetEntidade = Array();
    $kretw = BuscaDadosEntidadePIR($cpfcnpj_w, 'P', $vetEntidade);
    $kretw = BuscaDadosEntidadeSIACBA($cpfcnpj_w, 'F', $vetEntidade);
    $kretw = BuscaDadosEntidadeMEI($cpfcnpj_w, 'F', $vetEntidade);


    set_time_limit(30);
    $nome_pessoa = "Cliente Novo";
    $vetExistencia = Array();
    $vetpir = $vetEntidade['PIR']['P'];
    $vetExistencia['PIR']['P']['existe_entidade'] = $vetpir['existe_entidade'];
    if ($vetpir['existe_entidade'] == 'S') {
        // echo " aaaaaaaaaaaaaaaaaaaaaaaa PIR ==== {$idt_atendimento};";
        $qtd_entidade = $vetpir['qtd_entidade'];
        $idt_entidade = $vetpir['idt_entidade'];
        $cpfcnpj = $vetpir['cpfcnpj'];
        $idt_cliente = $vetpir['idt_cliente'];
        $nome = $vetpir['nome'];
        $nome_pessoa = $vetpir['nome'];
        $telefone = $vetpir['telefone'];
        $celular = $vetpir['celular'];
        $email = $vetpir['email'];
        $cnpj = $vetpir['cnpj'];
        $nome_empresa = $vetpir['nome_empresa'];
        // complemento dependendo do tipo
        $vetdadosproprios = $vetpir['dadosproprios'];
        //p($vetdadosproprios);
        $idt_complemento_pessoa_c = $vetdadosproprios['row']['idt'];
        $idt_origem_c = $vetdadosproprios['row']['idt_origem'];
        $idt_entidade_c = $vetdadosproprios['row']['idt_entidade'];
        $ativo_c = $vetdadosproprios['row']['ativo'];
        $data_nascimento_c = $vetdadosproprios['row']['data_nascimento'];
        $nome_pai_c = $vetdadosproprios['row']['nome_pai'];
        $nome_mae_c = $vetdadosproprios['row']['nome_mae'];
        $idt_ativeconpf = $vetdadosproprios['row']['idt_ativeconpf'];
        $siacweb_situacao = $vetpir['siacweb_situacao'];
        $pa_senha = $vetpir['pa_senha'];
        $pa_idfacebook = $vetpir['pa_idfacebook'];
        $idt_profissao_c = $vetdadosproprios['row']['idt_profissao'];
        $idt_estado_civil_c = $vetdadosproprios['row']['idt_estado_civil'];
        $idt_cor_pele_c = $vetdadosproprios['row']['idt_cor_pele'];
        $idt_religiao_c = $vetdadosproprios['row']['idt_religiao'];
        $idt_destreza_c = $vetdadosproprios['row']['idt_destreza'];
        $idt_sexo_c = $vetdadosproprios['row']['idt_sexo'];
        $necessidade_especial_c = $vetdadosproprios['row']['necessidade_especial'];
        $idt_escolaridade_c = $vetdadosproprios['row']['idt_escolaridade'];
        $receber_informacao_c = $vetdadosproprios['row']['receber_informacao'];
        $nome_tratamento_c = $vetdadosproprios['row']['nome_tratamento'];

        // Parte variável
        $vetenderecos = $vetpir['enderecos'];
        $vetprotocolos = $vetpir['protocolos'];
        $vetempresas = $vetpir['empresas'];
        $vetempresasPE = $vetempresas['PE'];
        $vetempresasEP = $vetempresas['EP'];
        ForEach ($vetenderecos as $idx => $Vettrab) {
            $vetendereco = $Vettrab['endereco'];
            $vetrow = $vetendereco['row'];
            //
            // 00 é o principal
            //
           //$vetrow['idt_entidade_endereco_tipo'];
            // 99 é endereco do atendimento
            if ($vetrow['gec_eneet_codigo'] != "00" and $vetrow['gec_eneet_codigo'] != "99") {
                continue;
            }
            $logradouro_p = $vetrow['logradouro'];
            $logradouro_numero_p = $vetrow['logradouro_numero'];
            $logradouro_complemento_p = $vetrow['logradouro_complemento'];
            $logradouro_bairro_p = $vetrow['logradouro_bairro'];
            $logradouro_municipio_p = $vetrow['logradouro_municipio'];
            $logradouro_estado_p = $vetrow['logradouro_estado'];
            $logradouro_pais_p = $vetrow['logradouro_pais'];

            $logradouro_codbairro_p = $vetrow['logradouro_codbairro'];
            $logradouro_codcid_p = $vetrow['logradouro_codcid'];
            $logradouro_codest_p = $vetrow['logradouro_codest'];
            $logradouro_codpais_p = $vetrow['logradouro_codpais'];

            $logradouro_cep_p = $vetrow['logradouro_cep'];
            $cep_p = $vetrow['cep'];

            $idt_pais_p = $vetrow['idt_pais'];
            $idt_estado_p = $vetrow['idt_estado'];
            $idt_cidade_p = $vetrow['idt_cidade'];
            $vetcomunicacaow = $vetendereco['comunicacao'];
            if (is_array($vetcomunicacaow)) {
                ForEach ($vetcomunicacaow as $idxw => $VetCom) {
                    //p($VetCom);
                    if ($telefone_1_p == "") {
                        $telefone_1_p = $VetCom['comunicacao']['telefone_1'];
                    }
                    if ($telefone_2_p == "") {
                        $telefone_2_p = $VetCom['comunicacao']['telefone_2'];
                    }
                    if ($email_1_p == "") {
                        $email_1_p = $VetCom['comunicacao']['email_1'];
                    }
                    if ($email_2_p == "") {
                        $email_2_p = $VetCom['comunicacao']['email_2'];
                    }
                    if ($sms_1_p == "") {
                        $sms_1_p = $VetCom['comunicacao']['sms_1'];
                    }
                    if ($sms_2_p == "") {
                        $sms_2_p = $VetCom['comunicacao']['sms_2'];
                    }
                }
            }
        }
    } else {
        // echo " aaaaaaaaaaaaaaaaaaaaaaaa SIACBA ==== {$idt_atendimento};";
        $vetExistencia = Array();
        $vetpir = $vetEntidade['SIACBA']['F'];
        //   echo "teste  2222222 ====== ".$idt_atendimento;
        //p($vetpir);
        $vetExistencia['SIACBA']['F']['existe_entidade'] = $vetpir['existe_entidade'];
        if ($vetpir['existe_entidade'] == 'S') {
            $qtd_entidade = $vetpir['qtd_entidade'];
            $idt_entidade = $vetpir['idt_entidade'];
            $codigo_siacweb = $idt_entidade;
            $cpfcnpj = $vetpir['cpfcnpj'];
            $idt_cliente = $vetpir['idt_cliente'];
            $nome = $vetpir['nomerazaosocial'];
            $nome_pessoa = $vetpir['nomerazaosocial'];
            $telefone = $vetpir['telefone'];
            $celular = $vetpir['celular'];
            $email = $vetpir['email'];
            $cnpj = $vetpir['cnpj'];
            $nome_empresa = $vetpir['nome_empresa'];
            // complemento dependendo do tipo
            $vetdadosproprios = $vetpir['dadosproprios'];
            //p($vetdadosproprios);

            $vetDN = explode(' ', $vetdadosproprios['row']['data_nascimento']);

            $idt_complemento_pessoa_c = $vetdadosproprios['row']['idt'];
            $idt_origem_c = $vetdadosproprios['row']['idt_origem'];
            $idt_entidade_c = $vetdadosproprios['row']['idt_entidade'];
            $ativo_c = $vetdadosproprios['row']['ativo'];
            $data_nascimento_c = $vetDN[0];
            $nome_pai_c = $vetdadosproprios['row']['nome_pai'];
            $nome_mae_c = $vetdadosproprios['row']['nome_mae'];
            $idt_ativeconpf = $vetdadosproprios['row']['idt_ativeconpf'];
            $siacweb_situacao = $vetpir['siacweb_situacao'];
            $pa_senha = $vetpir['pa_senha'];
            $pa_idfacebook = $vetpir['pa_idfacebook'];
            $idt_profissao_c = $vetdadosproprios['row']['idt_profissao'];
            $idt_estado_civil_c = $vetdadosproprios['row']['idt_estado_civil'];
            $idt_cor_pele_c = $vetdadosproprios['row']['idt_cor_pele'];
            $idt_religiao_c = $vetdadosproprios['row']['idt_religiao'];
            $idt_destreza_c = $vetdadosproprios['row']['idt_destreza'];
            $idt_sexo_c = $vetdadosproprios['row']['idt_sexo'];
            $necessidade_especial_c = $vetdadosproprios['row']['necessidade_especial'];
            $idt_escolaridade_c = $vetdadosproprios['row']['idt_escolaridade'];
            $receber_informacao_c = $vetdadosproprios['row']['receber_informacao'];
            $nome_tratamento_c = $vetdadosproprios['row']['nome_tratamento'];

            $vetendereco = $vetpir['enderecos'];

            //p($vetendereco);

            $logradouro_p = $vetendereco['row']['logradouro'];
            $logradouro_numero_p = $vetendereco['row']['logradouro_numero'];
            $logradouro_complemento_p = $vetendereco['row']['logradouro_complemento'];
            $logradouro_bairro_p = $vetendereco['row']['logradouro_bairro'];
            $logradouro_municipio_p = $vetendereco['row']['logradouro_municipio'];
            $logradouro_estado_p = $vetendereco['row']['logradouro_estado'];
            $logradouro_pais_p = $vetendereco['row']['logradouro_pais'];

            $logradouro_codbairro_p = $vetendereco['row']['logradouro_codbairro'];
            $logradouro_codcid_p = $vetendereco['row']['logradouro_codcid'];
            $logradouro_codest_p = $vetendereco['row']['logradouro_codest'];
            $logradouro_codpais_p = $vetendereco['row']['logradouro_codpais'];

            $logradouro_cep_p = $vetendereco['row']['logradouro_cep'];
            $cep_p = $vetendereco['row']['cep'];

            $idt_pais_p = $vetendereco['row']['idt_pais'];
            $idt_estado_p = $vetendereco['row']['idt_estado'];
            $idt_cidade_p = $vetendereco['row']['idt_cidade'];
            //
            // Comunicacao
            //
            $vetcomunicacao = $vetpir['comunicacao']['row'];
            $telefone_1_p = $vetcomunicacao['telefone_1_p'];
            $telefone_2_p = $vetcomunicacao['telefone_2_p'];
            $telefone_3_p = $vetcomunicacao['telefone_3_p'];
            $email_1_p = $vetcomunicacao['email_1_p'];
            $sms_1_p = $vetcomunicacao['sms_1_p'];
            // o SMS = telefone celular
            $sms_1_p = $telefone_2_p;
            // Parte variável
            $vetenderecos = $vetpir['enderecos'];
            $vetprotocolos = $vetpir['protocolos'];
            $vetempresas = $vetpir['empresas'];
            $vetempresasPE = $vetempresas['PE'];
            $vetempresasEP = $vetempresas['EP'];

            ForEach ($vetenderecos as $idx => $Vettrab) {
                $vetendereco = $Vettrab['endereco'];
                $vetrow = $vetendereco['row'];
                //
                // 00 é o principal
                //
             //  $vetrow['idt_entidade_endereco_tipo'];
                if ($vetrow['gec_eneet_codigo'] != "00" and $vetrow['gec_eneet_codigo'] != "99") {
                    continue;
                }
                $logradouro_p = $vetrow['logradouro'];
                $logradouro_numero_p = $vetrow['logradouro_numero'];
                $logradouro_complemento_p = $vetrow['logradouro_complemento'];
                $logradouro_bairro_p = $vetrow['logradouro_bairro'];
                $logradouro_municipio_p = $vetrow['logradouro_municipio'];
                $logradouro_estado_p = $vetrow['logradouro_estado'];
                $logradouro_pais_p = $vetrow['logradouro_pais'];

                $logradouro_codbairro_p = $vetrow['logradouro_codbairro'];
                $logradouro_codcid_p = $vetrow['logradouro_codcid'];
                $logradouro_codest_p = $vetrow['logradouro_codest'];
                $logradouro_codpais_p = $vetrow['logradouro_codpais'];

                $logradouro_cep_p = $vetrow['logradouro_cep'];
                $cep_p = $vetrow['cep'];

                $idt_pais_p = $vetrow['idt_pais'];
                $idt_estado_p = $vetrow['idt_estado'];
                $idt_cidade_p = $vetrow['idt_cidade'];

                $vetcomunicacaow = $vetendereco['comunicacao'];
                if (is_array($vetcomunicacaow)) {
                    ForEach ($vetcomunicacaow as $idxw => $VetCom) {
                        //p($VetCom);
                        $telefone_1_p = $VetCom['comunicacao']['telefone_1'];
                        $telefone_2_p = $VetCom['comunicacao']['telefone_2'];
                        $email_1_p = $VetCom['comunicacao']['email_1'];
                        $email_2_p = $VetCom['comunicacao']['email_2'];
                        $sms_1_p = $VetCom['comunicacao']['sms_1'];
                        $sms_2_p = $VetCom['comunicacao']['sms_2'];
                    }
                }
            }
        }
    }
    //
    //  Gravar Pessoa
    //
    $idt_pessoa = null($idt_entidade);
    $nome_mae = aspa($nome_mae_c);
    $idt_ativeconpf = null($idt_ativeconpf);

    $rowSIAC = situacaoParceiroSiacWeb('F', $variavel['cpf']);
    $siacweb_situacao = $rowSIAC['siacweb_situacao'];

    if ($siacweb_situacao == '') {
        $siacweb_situacao = 1;
    }

    $siacweb_situacao = null($siacweb_situacao);
    $pa_senha = aspa($pa_senha);
    $pa_idfacebook = aspa($pa_idfacebook);
    $nome_pai = aspa($nome_pai_c);
    $logradouro_cep = aspa($cep_p);
    $cep = aspa($cep_p);

    $logradouro_p = substr($logradouro_p, 0, 120);

    $logradouro_endereco = aspa($logradouro_p);
    $logradouro_numero = aspa($logradouro_numero_p);
    $logradouro_bairro = aspa($logradouro_bairro_p);
    $logradouro_complemento = aspa($logradouro_complemento_p);
    $logradouro_cidade = aspa($logradouro_municipio_p);
    $logradouro_estado = aspa($logradouro_estado_p);
    $logradouro_pais = aspa($logradouro_pais_p);

    $logradouro_codbairro_p = null($logradouro_codbairro_p);
    $logradouro_codcid_p = null($logradouro_codcid_p);
    $logradouro_codest_p = null($logradouro_codest_p);
    $logradouro_codpais_p = null($logradouro_codpais_p);

    $idt_pais = null(idt_pais_p);
    $idt_estado = null(idt_estado_p);
    $idt_cidade = null(idt_cidade_p);
    $telefone_residencial = aspa($telefone_1_p);
    $telefone_celular = aspa($telefone_2_p);
    $telefone_recado = aspa($telefone_3_p);

    /*
     * Removido por causa do suporte #606
      if ($telefone_3_p == "") {
      if ($telefone_celular != '') {
      $telefone_recado = $telefone_celular;
      } else {
      $telefone_recado = $telefone_residencial;
      }
      }
     * 
     */

    $email = aspa($email_1_p);
    $sms = aspa($sms_1_p);
    //
    $nome_tratamento = aspa($nome_tratamento_c);
    $idt_escolaridade = null($idt_escolaridade_c);
    $idt_sexo = null($idt_sexo_c);
    $data_nascimento = aspa($data_nascimento_c);
    $receber_informacao = aspa($receber_informacao_c);
    $necessidade_especial = aspa($necessidade_especial_c);
    //
    $idt_profissao = null($idt_profissao_c);
    $idt_estado_civil = null($idt_estado_civil_c);
    $idt_cor_pele = null($idt_cor_pele_c);
    $idt_religiao = null($idt_religiao_c);
    $idt_destreza = null($idt_destreza_c);
    //
    $cpf = aspa($cpf);
    $codigo_siacweb = aspa($codigo_siacweb);
    $nome = aspa($nome_pessoa);
    $tipo_relacao = aspa($variavel['tipo_relacao']);
    $representa_empresa = aspa('N');
    //
    //  Deletar elementos vinculados
    //
    //
    // Pessoas
    // apenas uma pessoa
    $sql_d = ' delete from ';
    $sql_d .= ' grc_atendimento_pessoa ';
    $sql_d .= ' where idt_atendimento = ' . null($idt_atendimento);
    $sql_d .= '   and cpf             = ' . aspa($cpf_w);
    $sql_d .= "   and tipo_relacao    = " . $tipo_relacao;
    $rs_d = execsql($sql_d);
    //
    //  incluir pessoa
    //
    
    if ($variavel['idt_evento'] == '') {
        $sqlCampo = '';
        $sqlValor = '';
    } else {
        $sqlCampo = ' evento_cortesia, evento_alt_siacweb, evento_inscrito, evento_exc_siacweb, ';
        $sqlValor = " 'N', 'N', 'N', 'N', ";
    }

    $sql_i = ' insert into grc_atendimento_pessoa ';
    $sql_i .= ' (  ';
    $sql_i .= $sqlCampo;
    $sql_i .= " idt_atendimento, ";
    $sql_i .= " idt_pessoa, ";
    $sql_i .= " codigo_siacweb, ";
    $sql_i .= " cpf, ";
    $sql_i .= " nome, ";
    $sql_i .= " tipo_relacao, ";
    $sql_i .= " nome_mae, ";
    $sql_i .= " idt_ativeconpf, ";
    $sql_i .= " siacweb_situacao, ";
    $sql_i .= " pa_senha, ";
    $sql_i .= " pa_idfacebook, ";
    $sql_i .= " nome_pai, ";
    $sql_i .= " logradouro_cep, ";
    $sql_i .= " logradouro_endereco, ";
    $sql_i .= " logradouro_numero, ";
    $sql_i .= " logradouro_bairro, ";
    $sql_i .= " logradouro_complemento, ";
    $sql_i .= " logradouro_cidade, ";
    $sql_i .= " logradouro_estado, ";
    $sql_i .= " logradouro_pais, ";

    $sql_i .= " logradouro_codbairro, ";
    $sql_i .= " logradouro_codcid, ";
    $sql_i .= " logradouro_codest, ";
    $sql_i .= " logradouro_codpais, ";

    $sql_i .= " idt_pais, ";
    $sql_i .= " idt_estado, ";
    $sql_i .= " idt_cidade, ";
    $sql_i .= " telefone_residencial, ";
    $sql_i .= " telefone_celular, ";
    $sql_i .= " telefone_recado, ";

    $sql_i .= " email, ";
    $sql_i .= " sms, ";
    $sql_i .= " nome_tratamento, ";
    $sql_i .= " idt_escolaridade, ";

    $sql_i .= " idt_sexo, ";
    $sql_i .= " data_nascimento, ";
    $sql_i .= " receber_informacao, ";
    $sql_i .= " representa_empresa, ";
    $sql_i .= " necessidade_especial, ";

    $sql_i .= " idt_profissao, ";
    $sql_i .= " idt_estado_civil, ";
    $sql_i .= " idt_cor_pele, ";
    $sql_i .= " idt_religiao, ";
    $sql_i .= " idt_destreza ";
    $sql_i .= '  ) values ( ';
    $sql_i .= $sqlValor;
    $sql_i .= " $idt_atendimento, ";
    $sql_i .= " $idt_pessoa, ";
    $sql_i .= " $codigo_siacweb, ";
    $sql_i .= " $cpf, ";
    $sql_i .= " $nome, ";
    $sql_i .= " $tipo_relacao, ";
    $sql_i .= " $nome_mae, ";
    $sql_i .= " $idt_ativeconpf, ";
    $sql_i .= " $siacweb_situacao, ";
    $sql_i .= " $pa_senha, ";
    $sql_i .= " $pa_idfacebook, ";
    $sql_i .= " $nome_pai, ";
    $sql_i .= " $logradouro_cep, ";
    $sql_i .= " $logradouro_endereco, ";
    $sql_i .= " $logradouro_numero, ";
    $sql_i .= " $logradouro_bairro, ";
    $sql_i .= " $logradouro_complemento, ";
    $sql_i .= " $logradouro_cidade, ";
    $sql_i .= " $logradouro_estado, ";
    $sql_i .= " $logradouro_pais, ";

    $sql_i .= " $logradouro_codbairro_p, ";
    $sql_i .= " $logradouro_codcid_p, ";
    $sql_i .= " $logradouro_codest_p, ";
    $sql_i .= " $logradouro_codpais_p, ";

    $sql_i .= " $idt_pais, ";
    $sql_i .= " $idt_estado, ";
    $sql_i .= " $idt_cidade, ";
    $sql_i .= " $telefone_residencial, ";
    $sql_i .= " $telefone_celular, ";
    $sql_i .= " $telefone_recado, ";

    $sql_i .= " $email, ";
    $sql_i .= " $sms, ";
    $sql_i .= " $nome_tratamento, ";
    $sql_i .= " $idt_escolaridade, ";

    $sql_i .= " $idt_sexo, ";
    $sql_i .= " $data_nascimento, ";
    $sql_i .= " $receber_informacao, ";
    $sql_i .= " $representa_empresa, ";
    $sql_i .= " $necessidade_especial, ";
    $sql_i .= " $idt_profissao, ";
    $sql_i .= " $idt_estado_civil, ";
    $sql_i .= " $idt_cor_pele, ";
    $sql_i .= " $idt_religiao, ";
    $sql_i .= " $idt_destreza ";
    $sql_i .= ') ';
    $result = execsql($sql_i);
    $idt_atendimento_pessoa = lastInsertId();

    $variavel['idt_atendimento_pessoa'] = $idt_atendimento_pessoa;

    $idtentidade_relacionada = $idt_pessoa;
    if ($idtentidade_relacionada > 0) {
        //
        // incluir temas de interesee
        //
        $sql2 = 'select ';
        $sql2 .= '  gec_eti.*   ';
        $sql2 .= '  from ' . db_pir_gec . 'gec_entidade_tema_interesse gec_eti ';
        $sql2 .= ' where  gec_eti.idt_entidade   = ' . null($idtentidade_relacionada);
        $rs = execsql($sql2);
        ForEach ($rs->data as $row2) {
            $idt = $row2['idt'];
            $idt_tema = null($row2['idt_tema']);
            $idt_subtema = null($row2['idt_subtema']);
            $idt_responsavel = null(IdUsuarioPIR($row2['idt_responsavel'], db_pir_gec, db_pir_grc));
            $observacao = aspa($row2['observacao']);
            //
            // gravar no do atendimento
            //
            $sql_i = ' insert into grc_atendimento_pessoa_tema_interesse ';
            $sql_i .= ' (  ';
            $sql_i .= " idt_atendimento_pessoa, ";
            $sql_i .= " idt_responsavel, ";
            $sql_i .= " idt_tema, ";
            $sql_i .= " idt_subtema, ";
            $sql_i .= " observacao ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " $idt_atendimento_pessoa, ";
            $sql_i .= " $idt_responsavel, ";
            $sql_i .= " $idt_tema, ";
            $sql_i .= " $idt_subtema, ";
            $sql_i .= " $observacao ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }

        $sql2 = 'select ';
        $sql2 .= '  gec_epi.*   ';
        $sql2 .= '  from ' . db_pir_gec . 'gec_entidade_produto_interesse gec_epi ';
        $sql2 .= ' where  gec_epi.idt_entidade   = ' . null($idtentidade_relacionada);
        $rs = execsql($sql2);
        ForEach ($rs->data as $row2) {
            $idt = $row2['idt'];
            $idt_produto = null($row2['idt_produto']);
            $idt_responsavel = null(IdUsuarioPIR($row2['idt_responsavel'], db_pir_gec, db_pir_grc));
            $observacao = aspa($row2['observacao']);
            //
            // gravar no do atendimento
            //
            $sql_i = ' insert into grc_atendimento_pessoa_produto_interesse ';
            $sql_i .= ' (  ';
            $sql_i .= " idt_atendimento_pessoa, ";
            $sql_i .= " idt_responsavel, ";
            $sql_i .= " idt_produto, ";
            $sql_i .= " observacao ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " $idt_atendimento_pessoa, ";
            $sql_i .= " $idt_responsavel, ";
            $sql_i .= " $idt_produto, ";
            $sql_i .= " $observacao ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }

        $sql2 = 'select ';
        $sql2 .= '  gec_eai.*   ';
        $sql2 .= '  from ' . db_pir_gec . 'gec_entidade_arquivo_interesse gec_eai ';
        $sql2 .= ' where  gec_eai.idt_entidade   = ' . null($idtentidade_relacionada);
        $rs = execsql($sql2);
        ForEach ($rs->data as $row2) {
            $idt = $row2['idt'];
            $idt_responsavel = null(IdUsuarioPIR($row2['idt_responsavel'], db_pir_gec, db_pir_grc));
            $titulo = aspa($row2['titulo']);
            $arquivo = aspa($row2['arquivo']);
            //
            // gravar no do atendimento
            //
            $sql_i = ' insert into grc_atendimento_pessoa_arquivo_interesse ';
            $sql_i .= ' (  ';
            $sql_i .= " idt_atendimento_pessoa, ";
            $sql_i .= " idt_responsavel, ";
            $sql_i .= " titulo, ";
            $sql_i .= " arquivo ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " $idt_atendimento_pessoa, ";
            $sql_i .= " $idt_responsavel, ";
            $sql_i .= " $titulo, ";
            $sql_i .= " $arquivo ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }
    }


    $sql2 = 'select ';
    $sql2 .= '  idt_atendimento_agenda   ';
    $sql2 .= '  from grc_atendimento grc_a ';
    $sql2 .= '  where grc_a.idt = ' . null($idt_atendimento);
    $rs_aap = execsql($sql2);
    if ($rs_aap->rows == 0) {
        $variavel['idt_atendimento_agenda'] = 0;
    } else {
        ForEach ($rs_aap->data as $row) {
            $idt_atendimento_agenda = $row['idt_atendimento_agenda'];
        }
        $variavel['idt_atendimento_agenda'] = $idt_atendimento_agenda;
    }








    commit();
    $kokw = 1;
    return $kokw;
}

function GravarEvento($idt_instrumento, $idt_responsavel = '') {
    $tabela = 'grc_evento';
    $Campo = 'codigo';
    $tam = 7;

    if ($idt_instrumento == 54) {
        $codigow = geraAutoNum(db_pir_grc, $tabela . '_' . $Campo . '_CB', $tam);
        $codigo = 'CB' . $codigow;
    } else {
        $codigow = geraAutoNum(db_pir_grc, $tabela . '_' . $Campo, $tam);
        $codigo = 'EV' . $codigow;
    }

    $codigo = aspa($codigo);
    $idt_evento_situacao = 1;
    $temporario = aspa('S');

    if ($idt_responsavel == '') {
        $idt_responsavel = $_SESSION[CS]['g_id_usuario'];
    }

    $datadia = trata_data(date('d/m/Y H:i:s'));
    $data_criacao = aspa($datadia);
    //        
    $sql_i = ' insert into ' . db_pir_grc . 'grc_evento ';
    $sql_i .= ' (  ';
    $sql_i .= " codigo, ";
    $sql_i .= " idt_instrumento, ";
    $sql_i .= " idt_evento_situacao, ";
    $sql_i .= " data_criacao, ";
    $sql_i .= " idt_responsavel, ";
    $sql_i .= " temporario ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $codigo, ";
    $sql_i .= " $idt_instrumento, ";
    $sql_i .= " $idt_evento_situacao, ";
    $sql_i .= " $data_criacao, ";
    $sql_i .= " $idt_responsavel, ";
    $sql_i .= " $temporario ";
    $sql_i .= ') ';
    $result = execsql($sql_i);
    $idt = lastInsertId();

    if ($idt_instrumento != 41 && $idt_instrumento != 45) {
        $sql_i = 'insert into ' . db_pir_grc . 'grc_evento_insumo (idt_evento, idt_insumo, codigo, descricao, ativo, detalhe, quantidade, quantidade_evento, custo_unitario_real, idt_insumo_unidade, por_participante,';
        $sql_i .= ' rtotal_minimo, rtotal_maximo, receita_total, idt_area_suporte)';
        $sql_i .= " select {$idt} as idt_evento, idt, 'evento_insc' as codigo, descricao, ativo, detalhe, 1 as quantidade, 1 as quantidade_evento, 0 as custo_unitario_real, idt_insumo_unidade, por_participante,";
        $sql_i .= ' 0 as rtotal_minimo, 0 as rtotal_maximo, 0 as receita_total, idt_area_suporte';
        $sql_i .= ' from ' . db_pir_grc . 'grc_insumo';
        $sql_i .= " where evento_insc_receita = 'S'";
        execsql($sql_i);
    }

    return $idt;
}

function email_pendencias($vetEmail) {
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
    $mail = null;
}

//
/////////////////////// INTEGRAÇÃO COM ORDEM DE CONTRATAÇÃO DO GEC
//
function GEC_contratacao_credenciado_ordem($idt_evento, &$variavel, $automatico, $usa_rodizio, $beginTransaction = true) {
    global $vetSistemaUtiliza, $vetConf;

    $variavel['ordem_codigo'] = Array();

    // Acessar dados do evento

    $t = new PIR_entidades();
    $vt = $t->estrutura_tr(db_pir_grc . 'grc_evento');
    $grc_ev_FD = $t->estrutura_cd('FD');
    $grc_ev_WS = $t->estrutura_cd('WS');
    $grc_ev_TP_CPO = $t->estrutura_cd('TP_CPO');
    $grc_ev_WS_CON_I = Array();
    $grc_ev_WS_CON_N = Array();

    $sql = 'select ';
    $sql .= '  grc_ev.*   ';
    $sql .= '  from grc_evento grc_ev ';
    $sql .= '  where grc_ev.idt = ' . null($idt_evento);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $variavel['erro'] = 'Evento não informado';
        return 0;
    } else {
        ForEach ($rs->data as $row) {
            ForEach ($grc_ev_WS as $idx => $cpo) {
                $$cpo = $row[$grc_ev_FD[$idx]];
                $grc_ev_WS_CON_I[$idx] = $row[$grc_ev_FD[$idx]];
                $grc_ev_WS_CON_N[$grc_ev_FD[$idx]] = $row[$grc_ev_FD[$idx]];
            }
        }
    }
    //p($WS_CON_I);
    //p($WS_CON_N);

    if ($idt_produto_w > 0) {   // tem produto associado
        $sql = 'select ';
        $sql .= '  grc_pro.*   ';
        $sql .= '  from grc_produto grc_pro ';
        $sql .= '  where grc_pro.idt = ' . null($idt_produto_w);
        $rs = execsql($sql);
        $idt_produto_tipo = 'null';
        ForEach ($rs->data as $row) {
            // esse é o Produto do Evento
            $idt_produto_tipo = $row['idt_produto_tipo'];

            // campos do produto
            $objeto = $row['objeto'];

            if ($idt_programa_w == '') {
                $idt_programa_w = $row['idt_programa'];

                $sql_a = " update grc_evento set ";
                $sql_a .= " idt_programa = " . null($idt_programa_w);
                $sql_a .= " where idt = " . null($idt_evento);
                execsql($sql_a);
            }
        }

        $sql = 'select ';
        $sql .= '  grc_pac.*   ';
        $sql .= '  from grc_produto_area_conhecimento grc_pac ';
        $sql .= '  where grc_pac.idt_produto = ' . null($idt_produto_w);
        $rs = execsql($sql);
        $vet_ac = Array();
        ForEach ($rs->data as $row) {
            // esse é o Produto do Evento
            $vet_ac[$row['idt']] = $row;
        }
    } else {
        $variavel['erro'] = 'Evento sem produto associado';
        return 0;
    }

    if ($idt_programa_w == '') {
        $variavel['erro'] = 'O produto associado a este evento não tem o programa.';
        return 0;
    }

    $sql = '';
    $sql .= " select idt_gec_contratacao_requisitos, tipo_ordem";
    $sql .= ' from ' . db_pir_gec . 'gec_programa';
    $sql .= ' where idt = ' . null($idt_programa_w);
    $rs = execsql($sql);
    $row_programa = $rs->data[0];

    $rowLocal = Array();

    if ($idt_local_w == '') {
        $sql = '';
        $sql .= ' select cep, logradouro, complemento, uf_sigla, cidade, bairro';
        $sql .= ' from ' . db_pir_gec . 'base_cep';
        $sql .= ' where cep = ' . aspa(preg_replace('/[^0-9]/i', '', $cep_w));
        $sql .= ' and cep_situacao = 1';
        $rs = execsql($sql);

        $msgErroLocal = 'CEP do evento informado é inválido.';
    } else {
        $sql = '';
        $sql .= ' select cep, logradouro, logradouro_numero, logradouro_complemento, logradouro_codest, logradouro_codcid, logradouro_codbairro';
        $sql .= ' from grc_evento_local_pa l';
        $sql .= '  where idt = ' . null($idt_local_w);
        $rs = execsql($sql);

        $msgErroLocal = 'Evento sem local informado.';
    }

    if ($rs->rows == 0 && $row_programa['tipo_ordem'] != 'SG') {
        $variavel['erro'] = $msgErroLocal;
        return 0;
    }

    $rowLoc = $rs->data[0];

    if ($idt_local_w == '') {
        $rowLocal['execucao_end_cep'] = FormatCEP($rowLoc['cep']);
        $rowLocal['execucao_end_logradouro'] = $rowLoc['logradouro'];
        $rowLocal['execucao_end_numero'] = 'S/N';
        $rowLocal['execucao_end_complemento'] = $rowLoc['complemento'];
        $rowLocal['execucao_end_uf'] = $rowLoc['uf_sigla'];
        $rowLocal['execucao_end_cidade'] = $rowLoc['cidade'];
        $rowLocal['execucao_end_bairro'] = $rowLoc['bairro'];
    } else {
        $rowLocal['execucao_end_cep'] = $rowLoc['cep'];
        $rowLocal['execucao_end_logradouro'] = $rowLoc['logradouro'];
        $rowLocal['execucao_end_numero'] = $rowLoc['logradouro_numero'];
        $rowLocal['execucao_end_complemento'] = $rowLoc['logradouro_complemento'];

        $sql = '';
        $sql .= " select distinct uf_sigla";
        $sql .= ' from ' . db_pir_gec . 'base_cep';
        $sql .= ' where codest = ' . null($rowLoc['logradouro_codest']);
        $sql .= ' and cep_situacao = 1';
        $rs = execsql($sql);
        $rowLocal['execucao_end_uf'] = $rs->data[0][0];

        $sql = '';
        $sql .= " select distinct cidade";
        $sql .= ' from ' . db_pir_gec . 'base_cep';
        $sql .= ' where codcid = ' . null($rowLoc['logradouro_codcid']);
        $sql .= ' and cep_situacao = 1';
        $rs = execsql($sql);
        $rowLocal['execucao_end_cidade'] = $rs->data[0][0];

        $sql = '';
        $sql .= " select distinct bairro";
        $sql .= ' from ' . db_pir_gec . 'base_cep';
        $sql .= ' where codbairro = ' . null($rowLoc['logradouro_codbairro']);
        $sql .= ' and cep_situacao = 1';
        $rs = execsql($sql);
        $rowLocal['execucao_end_bairro'] = $rs->data[0][0];
    }

    $sql = 'select ';
    $sql .= '  grc_evi.*   ';
    $sql .= '  from grc_evento_insumo grc_evi ';
    $sql .= '  where grc_evi.idt_evento = ' . null($idt_evento);
    $sql .= "  and (grc_evi.codigo = '70001' or grc_evi.codigo = '71001')";
    $rs = execsql($sql);
    $idt_ordem_contratacao = 0;

    $vet_ordem_contratacao = Array();
    if ($rs->rows == 0) {
        $variavel['erro'] = 'Sem Insumo para Gerar Ordem';
        return 0;
    } else {
        ForEach ($rs->data as $row) {
            $vet_ordem_contratacao[$row['idt']] = $row;
        }
    }

    $vt = $t->estrutura_tr('' . db_pir_gec . 'gec_contratacao_credenciado_ordem');
    $gec_cco_FD = $t->estrutura_cd('FD');
    $gec_cco_WS = $t->estrutura_cd('WS');
    $gec_cco_TP_CPO = $t->estrutura_cd('TP_CPO');
    $gec_cco_WS_CON_I = Array();
    $gec_cco_WS_CON_N = Array();

    $arqCopia = Array();

    if ($beginTransaction) {
        beginTransaction();
    }

    ForEach ($vet_ordem_contratacao as $idt_evento_insumo => $row) {
        if ($row['idt_ordem_contratacao'] == '' && $row_programa['tipo_ordem'] == 'SG' && $sgtec_modelo_w == 'E') {
            $sql = '';
            $sql .= ' select idt, codigo';
            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem';
            $sql .= ' where idt_evento = ' . null($idt_evento);
            $sql .= " and ativo = 'S'";
            $rs = execsql($sql);

            if ($rs->rows > 0) {
                $rowO = $rs->data[0];

                $row['idt_ordem_contratacao'] = $rowO['idt'];
                $row['cod_ordem_contratacao'] = $rowO['codigo'];

                $sql = 'update grc_evento_insumo set idt_ordem_contratacao = ' . null($row['idt_ordem_contratacao']);
                $sql .= ', cod_ordem_contratacao = ' . aspa($row['cod_ordem_contratacao']);
                $sql .= ' where idt = ' . null($idt_evento_insumo);
                execsql($sql);
            }
        }

        $idt_ordem_contratacao = $row['idt_ordem_contratacao'];

        if ($row['cod_ordem_contratacao'] == '') {
            $codigow = 'BA' . date('mY') . geraAutoNum(db_pir_gec, 'gec_contratacao_credenciado_ordem_codigo_BA' . date('mY'), 4);
        } else {
            $codigow = $row['cod_ordem_contratacao'];
        }

        $variavel['ordem_codigo'][] = $codigow;

        if ($idt_instrumento_w == 40) {
            
        }

        $detalhe_w = $descricao_w . chr(13) . $observacao_w;

        if ($objetivo_w == "") {
            $objetivo_w = $detalhe_w;
        }

        if ($justificativa_w == "") {
            $justificativa_w = $detalhe_w;
        }

        $codigo = aspa($codigow);
        $descricao = aspa($descricao_w);
        $ativo = aspa('S');
        $detalhe = aspa($detalhe_w);
        $idt_responsavel = null(IdUsuarioPIR($idt_gestor_evento_w, db_pir_grc, db_pir_gec));
        $idt_cadastro_responsavel = null(IdUsuarioPIR($_SESSION[CS]['g_id_usuario'], db_pir_grc, db_pir_gec));
        $idt_gec_bases = null(1);

        if ($composto_w == 'S') {
            $idt_gec_natureza_servico = 3;
        } else {
            $idt_gec_natureza_servico = null($idt_produto_tipo);
        }

        $idt_gec_contratacao_requisitos = null($row_programa['idt_gec_contratacao_requisitos']);

        $idt_gec_metodologia = null('');
        $objeto = aspa($objetivo_w);
        $justificativa = aspa($justificativa_w);
        $inf_forma_pagamento = aspa('');
        $inf_previsao_passagem_viagem = aspa('');
        $inf_direito_autoral = aspa('');

        $sql = 'select detalhe from ' . db_pir_gec . 'gec_parametros gec_pa ';
        $sql .= " where codigo = 'credenciado_ordem_inf_outro'";
        $rsvp = execsql($sql);
        $inf_outro = aspa($rsvp->data[0][0]);

        $vl_hora = null($row['custo_unitario_real']);
        $qtd_hora = null($row['quantidade_evento']);
        $idt_gec_contratacao_status = null(1);
        $execucao_end_cep = aspa($rowLocal['execucao_end_cep']);
        $execucao_end_uf = aspa($rowLocal['execucao_end_uf']);
        $execucao_end_cidade = aspa($rowLocal['execucao_end_cidade']);
        $execucao_end_bairro = aspa($rowLocal['execucao_end_bairro']);
        $execucao_end_logradouro = aspa($rowLocal['execucao_end_logradouro']);
        $execucao_end_numero = aspa($rowLocal['execucao_end_numero']);
        $execucao_end_complemento = aspa($rowLocal['execucao_end_complemento']);

        $sql = '';
        $sql .= " select idt_contratar_modelo";
        $sql .= ' from ' . db_pir_gec . 'gec_contratacao_requisitos';
        $sql .= ' where idt = ' . null($row_programa['idt_gec_contratacao_requisitos']);
        $rs = execsql($sql);
        $idt_contratar_modelo = null($rs->data[0][0]);

        $idt_unidade_demandante = null($idt_unidade_w);
        $idt_publico_alvo = null($idt_publico_alvo_w);
        $idt_projeto = null($idt_projeto_w);
        $idt_projeto_acao = null($idt_acao_w);
        $idt_unidade_orcamento = null($idt_unidade_w);
        $gestor_sge = aspa($gestor_sge_w);
        $fase_acao_projeto = aspa($fase_acao_projeto_w);
        $idt_produto = null($idt_produto_w);
        $idt_evento = null($idt_evento);

        $idt_instrumento = null($idt_instrumento_w);
        $idt_programa = null($idt_programa_w);

        $entrega_prazo_max = null($entrega_prazo_max_w);
        $vl_determinado = aspa($vl_determinado_w);
        $sgtec_modelo = aspa($sgtec_modelo_w);

        if ($row_programa['tipo_ordem'] == 'SG' && $sgtec_modelo_w == 'E') {
            if ($vl_determinado_w == 'S') {
                $dt_contratacao_ini = aspa($dt_previsao_inicial_w);
                $dt_contratacao_fim = aspa($dt_previsao_fim_w);
            } else {
                if ($dt_previsao_inicial_w == '') {
                    $dt_contratacao_ini = $data_criacao_w;
                } else {
                    $dt_contratacao_ini = $dt_previsao_inicial_w;
                }

                $dt_contratacao_ini = trata_data($dt_contratacao_ini);

                if ($entrega_prazo_max_w == '') {
                    $dt_contratacao_fim = $dt_contratacao_ini;
                } else {
                    $dt_contratacao_fim = Calendario::Intervalo_Corrido($dt_contratacao_ini, $entrega_prazo_max_w);
                }
            }

            $dt_contratacao_ini = aspa(trata_data($dt_contratacao_ini));
            $dt_contratacao_fim = aspa(trata_data($dt_contratacao_fim));
        } else {
            $dt_contratacao_ini = aspa($dt_previsao_inicial_w);
            $dt_contratacao_fim = aspa($dt_previsao_fim_w);
        }

        $gera_rodizio = true;

        if ($automatico) {
            $automaticoSTR = aspa('S');
        } else {
            $automaticoSTR = aspa('N');
            $gera_rodizio = false;
        }

        if ($usa_rodizio) {
            $usa_rodizioSTR = aspa('S');
        } else {
            $usa_rodizioSTR = aspa('N');
            $gera_rodizio = false;
        }

        $copia_lista = false;

        if ($cred_contratacao_cont_w == 'S') {
            $usa_rodizioSTR = aspa('N');
            $gera_rodizio = false;
            $copia_lista = true;
        }

        if ($sgtec_modelo_w == 'E' && $vl_determinado_w == 'S') {
            $gera_rodizio = false;
        }

        if ($idt_ordem_contratacao > 0) {
            // modificando ordem de contratação
            $sql_i = ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem set';
            $sql_i .= " descricao = {$descricao}, ";
            $sql_i .= " ativo = {$ativo}, ";
            $sql_i .= " detalhe = {$detalhe}, ";
            $sql_i .= " idt_responsavel = {$idt_responsavel}, ";
            $sql_i .= " idt_gec_bases = {$idt_gec_bases}, ";
            $sql_i .= " idt_gec_natureza_servico = {$idt_gec_natureza_servico}, ";
            $sql_i .= " idt_gec_contratacao_requisitos = {$idt_gec_contratacao_requisitos}, ";
            $sql_i .= " idt_gec_metodologia = {$idt_gec_metodologia}, ";
            $sql_i .= " objeto = {$objeto}, ";
            $sql_i .= " justificativa = {$justificativa}, ";
            $sql_i .= " dt_contratacao_ini = {$dt_contratacao_ini}, ";
            $sql_i .= " dt_contratacao_fim = {$dt_contratacao_fim}, ";
            $sql_i .= " inf_forma_pagamento = {$inf_forma_pagamento}, ";
            $sql_i .= " inf_previsao_passagem_viagem = {$inf_previsao_passagem_viagem}, ";
            $sql_i .= " inf_direito_autoral = {$inf_direito_autoral}, ";
            $sql_i .= " inf_outro = {$inf_outro}, ";
            $sql_i .= " vl_hora = {$vl_hora}, ";
            $sql_i .= " qtd_hora = {$qtd_hora}, ";
            $sql_i .= " idt_gec_contratacao_status = {$idt_gec_contratacao_status}, ";
            $sql_i .= " execucao_end_cep = {$execucao_end_cep}, ";
            $sql_i .= " execucao_end_uf = {$execucao_end_uf}, ";
            $sql_i .= " execucao_end_cidade = {$execucao_end_cidade}, ";
            $sql_i .= " execucao_end_bairro = {$execucao_end_bairro}, ";
            $sql_i .= " execucao_end_logradouro = {$execucao_end_logradouro}, ";
            $sql_i .= " execucao_end_numero = {$execucao_end_numero}, ";
            $sql_i .= " execucao_end_complemento = {$execucao_end_complemento}, ";
            $sql_i .= " idt_contratar_modelo = {$idt_contratar_modelo}, ";
            $sql_i .= " idt_unidade_demandante = {$idt_unidade_demandante}, ";
            $sql_i .= " idt_publico_alvo = {$idt_publico_alvo}, ";
            $sql_i .= " idt_projeto = {$idt_projeto}, ";
            $sql_i .= " idt_projeto_acao = {$idt_projeto_acao}, ";
            $sql_i .= " idt_unidade_orcamento = {$idt_unidade_orcamento}, ";
            $sql_i .= " gestor_sge = {$gestor_sge}, ";
            $sql_i .= " fase_acao_projeto = {$fase_acao_projeto}, ";
            $sql_i .= " idt_produto = {$idt_produto}, ";
            $sql_i .= " idt_evento = {$idt_evento}, ";
            $sql_i .= " automatico = {$automaticoSTR}, ";
            $sql_i .= " usa_rodizio = {$usa_rodizioSTR}, ";
            $sql_i .= " idt_instrumento = {$idt_instrumento}, ";
            $sql_i .= " idt_programa = {$idt_programa}, ";
            $sql_i .= " entrega_prazo_max = {$entrega_prazo_max}, ";
            $sql_i .= " vl_determinado = {$vl_determinado}, ";
            $sql_i .= " sgtec_modelo = {$sgtec_modelo}, ";
            $sql_i .= " idt_evento_insumo = {$idt_evento_insumo} ";
            $sql_i .= ' where idt = ' . null($idt_ordem_contratacao);
            execsql($sql_i);

            sincronizaAgendaEventoSG($idt_ordem_contratacao, $idt_produto_w, $idt_evento);

            $sql = ' delete from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_insumo ';
            $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem_contratacao);
            execsql($sql);

            $sql = '';
            $sql .= ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_insumo (idt_gec_contratacao_credenciado_ordem, idt_evento, idt_insumo, codigo,';
            $sql .= ' descricao, qtd_automatico, quantidade, custo_unitario_prev, custo_total_prev, custo_unitario_real, custo_total_real)';
            $sql .= " select {$idt_ordem_contratacao} as idt_gec_contratacao_credenciado_ordem, idt_evento, idt_insumo, codigo,";
            $sql .= ' descricao, qtd_automatico, quantidade_evento, custo_unitario_real, custo_total, custo_unitario_real, custo_total';
            $sql .= ' from grc_evento_insumo';
            $sql .= ' where idt_evento = ' . $idt_evento;
            $sql .= ' and idt_profissional = ' . null($row['idt_profissional']);
            execsql($sql);

            if ($row_programa['tipo_ordem'] == 'SG') {
                //Entregas
                $sql = ' delete from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega ';
                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem_contratacao);
                execsql($sql);

                $sql = '';
                $sql .= ' select ea.idt, ea.idt_atendimento, ea.codigo, ea.descricao, ea.detalhe, ea.percentual, ea.ordem';
                $sql .= ' from grc_evento_entrega ea';
                $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
                $sql .= ' where ea.idt_evento = ' . null($idt_evento);
                $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $sql = '';
                    $sql .= ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega (idt_gec_contratacao_credenciado_ordem, idt_atendimento, codigo, descricao, detalhe, percentual, ordem) values (';
                    $sql .= null($idt_ordem_contratacao) . ', ' . null($row['idt_atendimento']) . ', ' . aspa($row['codigo']) . ', ' . aspa($row['descricao']) . ', ' . aspa($row['detalhe']) . ', ';
                    $sql .= aspa($row['percentual']) . ', ' . aspa($row['ordem']) . ')';
                    execsql($sql);
                    $idt_gec_contratacao_credenciado_ordem_entrega = lastInsertId();

                    $sql = '';
                    $sql .= ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega_documento (idt_gec_contratacao_credenciado_ordem_entrega, idt_documento, codigo)';
                    $sql .= ' select ' . $idt_gec_contratacao_credenciado_ordem_entrega . ' as idt_gec_contratacao_credenciado_ordem_entrega, idt_documento, codigo';
                    $sql .= ' from grc_evento_entrega_documento';
                    $sql .= ' where idt_evento_entrega = ' . null($row['idt']);
                    execsql($sql);
                }
            }

            if ($row_programa['tipo_ordem'] == 'SG' && $sgtec_modelo_w == 'E' && $vl_determinado_w == 'S') {
                $sql = '';
                $sql .= ' select sum(ed.vl_unitario * ed.qtd) as resumo_tot';
                $sql .= ' from grc_evento_dimensionamento ed';
                $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ed.idt_atendimento';
                $sql .= ' where ed.idt_evento = ' . null($idt_evento);
                $sql .= whereEventoParticipante();
                $rs = execsql($sql);
                $cotacaoReal = $rs->data[0][0];

                $sql = 'update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_insumo set custo_unitario_prev = ' . null($cotacaoReal);
                $sql .= ', custo_unitario_real = ' . null($cotacaoReal);
                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem_contratacao);
                $sql .= " and codigo = '71001'";
                execsql($sql);

                $sql = 'update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_insumo set custo_total_prev = custo_unitario_prev * quantidade';
                $sql .= ', custo_total_real = custo_unitario_real * quantidade';
                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem_contratacao);
                $sql .= " and codigo = '71001'";
                execsql($sql);

                $sql = '';
                $sql .= ' select distinct idt_atendimento';
                $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega';
                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem_contratacao);
                $rsED = execsql($sql);

                if ($rsED->rows > 0) {
                    if ($cotacaoReal == '') {
                        $cotacaoReal = 0;
                    }

                    $cotacao = floor($cotacaoReal / $rsED->rows * 100) / 100;
                    $cotacaoTot = 0;

                    foreach ($rsED->data as $idx => $rowED) {
                        if ($idx == $rsED->rows - 1) {
                            $cotacao = $cotacaoReal - $cotacaoTot;
                        }

                        $cotacaoTot += $cotacao;

                        $sql = '';
                        $sql .= ' select idt, percentual';
                        $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega';
                        $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem_contratacao);
                        $sql .= ' and idt_atendimento = ' . null($rowED['idt_atendimento']);
                        $rs = execsql($sql);

                        $totalPrev = 0;

                        foreach ($rs->data as $idx => $row) {
                            if ($idx == $rs->rows - 1) {
                                $valor_prev = $cotacao - $totalPrev;
                            } else {
                                $valor_prev = floor($cotacao * $row['percentual']) / 100;
                            }

                            $totalPrev += $valor_prev;

                            $sql = 'update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega set vl_entrega_prev = ' . null($valor_prev);
                            $sql .= ' where idt = ' . null($row['idt']);
                            execsql($sql);
                        }
                    }
                }

                $vetErro = rmConsolidacaoPrevista($idt_ordem_contratacao, 'valor_prev', true, true);

                if (count($vetErro) > 0) {
                    $variavel['erro'] = implode('<br />', $vetErro);
                    return 0;
                }
            }
        } else { // incluindo ordem de contratação
            // Registrar solicitação de Rodízio
            $sql_i = ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem';
            $sql_i .= ' (  ';
            $sql_i .= " codigo, ";
            $sql_i .= " descricao, ";
            $sql_i .= " ativo, ";
            $sql_i .= " detalhe, ";
            $sql_i .= " idt_responsavel, ";
            $sql_i .= " idt_cadastro_responsavel, ";
            $sql_i .= " idt_gec_bases, ";
            $sql_i .= " idt_gec_natureza_servico, ";
            $sql_i .= " idt_gec_contratacao_requisitos, ";
            $sql_i .= " idt_gec_metodologia, ";
            $sql_i .= " objeto, ";
            $sql_i .= " justificativa, ";
            $sql_i .= " dt_contratacao_ini, ";
            $sql_i .= " dt_contratacao_fim, ";
            $sql_i .= " inf_forma_pagamento, ";
            $sql_i .= " inf_previsao_passagem_viagem, ";
            $sql_i .= " inf_direito_autoral, ";
            $sql_i .= " inf_outro, ";
            $sql_i .= " vl_hora, ";
            $sql_i .= " qtd_hora, ";
            $sql_i .= " idt_gec_contratacao_status, ";
            $sql_i .= " execucao_end_cep, ";
            $sql_i .= " execucao_end_uf, ";
            $sql_i .= " execucao_end_cidade, ";
            $sql_i .= " execucao_end_bairro, ";
            $sql_i .= " execucao_end_logradouro, ";
            $sql_i .= " execucao_end_numero, ";
            $sql_i .= " execucao_end_complemento, ";
            $sql_i .= " idt_contratar_modelo, ";
            $sql_i .= " idt_unidade_demandante, ";
            $sql_i .= " idt_publico_alvo, ";
            $sql_i .= " idt_projeto, ";
            $sql_i .= " idt_projeto_acao, ";
            $sql_i .= " idt_unidade_orcamento, ";
            $sql_i .= " gestor_sge, ";
            $sql_i .= " fase_acao_projeto, ";
            $sql_i .= " idt_produto, ";
            $sql_i .= " idt_evento, ";
            $sql_i .= " origem, ";
            $sql_i .= " automatico, ";
            $sql_i .= " usa_rodizio, ";
            $sql_i .= " idt_instrumento, ";
            $sql_i .= " idt_programa, ";
            $sql_i .= " entrega_prazo_max, ";
            $sql_i .= " vl_determinado, ";
            $sql_i .= " sgtec_modelo, ";
            $sql_i .= " idt_evento_insumo ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao, ";
            $sql_i .= " $ativo, ";
            $sql_i .= " $detalhe, ";
            $sql_i .= " $idt_responsavel, ";
            $sql_i .= " $idt_cadastro_responsavel, ";
            $sql_i .= " $idt_gec_bases, ";
            $sql_i .= " $idt_gec_natureza_servico, ";
            $sql_i .= " $idt_gec_contratacao_requisitos, ";
            $sql_i .= " $idt_gec_metodologia, ";
            $sql_i .= " $objeto, ";
            $sql_i .= " $justificativa, ";
            $sql_i .= " $dt_contratacao_ini, ";
            $sql_i .= " $dt_contratacao_fim, ";
            $sql_i .= " $inf_forma_pagamento, ";
            $sql_i .= " $inf_previsao_passagem_viagem, ";
            $sql_i .= " $inf_direito_autoral, ";
            $sql_i .= " $inf_outro, ";
            $sql_i .= " $vl_hora, ";
            $sql_i .= " $qtd_hora, ";
            $sql_i .= " $idt_gec_contratacao_status, ";
            $sql_i .= " $execucao_end_cep, ";
            $sql_i .= " $execucao_end_uf, ";
            $sql_i .= " $execucao_end_cidade, ";
            $sql_i .= " $execucao_end_bairro, ";
            $sql_i .= " $execucao_end_logradouro, ";
            $sql_i .= " $execucao_end_numero, ";
            $sql_i .= " $execucao_end_complemento, ";
            $sql_i .= " $idt_contratar_modelo, ";
            $sql_i .= " $idt_unidade_demandante, ";
            $sql_i .= " $idt_publico_alvo, ";
            $sql_i .= " $idt_projeto, ";
            $sql_i .= " $idt_projeto_acao, ";
            $sql_i .= " $idt_unidade_orcamento, ";
            $sql_i .= " $gestor_sge, ";
            $sql_i .= " $fase_acao_projeto, ";
            $sql_i .= " $idt_produto, ";
            $sql_i .= " $idt_evento, ";
            $sql_i .= " 'GRC', ";
            $sql_i .= " $automaticoSTR, ";
            $sql_i .= " $usa_rodizioSTR, ";
            $sql_i .= " $idt_instrumento, ";
            $sql_i .= " $idt_programa, ";
            $sql_i .= " $entrega_prazo_max, ";
            $sql_i .= " $vl_determinado, ";
            $sql_i .= " $sgtec_modelo, ";
            $sql_i .= " $idt_evento_insumo ";
            $sql_i .= ') ';
            execsql($sql_i);
            $idt_ordem_contratacao = lastInsertId();

            if ($composto_w == 'S') {
                $sql = ' select e.idt, p.idt_produto_tipo';
                $sql .= ' from grc_evento e';
                $sql .= ' inner join grc_produto p on p.idt = e.idt_produto';
                $sql .= ' where idt_evento_pai = ' . null($idt_evento);
                $rsf = execsql($sql);

                foreach ($rsf->data as $rowf) {
                    switch ($rowf['idt_produto_tipo']) {
                        case 1: //Instrutoria
                            $tipo = 'I';
                            break;

                        case 2: //Consultoria
                            $tipo = 'C';
                            break;

                        default: //Consultoria/Instrutoria
                            $tipo = 'I';
                            break;
                    }

                    $sql = '';
                    $sql .= ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_agenda (idt_gec_contratacao_credenciado_ordem, idt_evento, tipo, dt_ini, dt_fim, tot_hora, obs)';
                    $sql .= " select {$idt_ordem_contratacao} as idt_gec_contratacao_credenciado_ordem, ea.idt_evento, '{$tipo}' as tipo, ea.dt_ini, ea.dt_fim, ea.carga_horaria as tot_hora, ea.observacao as obs";
                    $sql .= ' from grc_evento_agenda ea';
                    $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
                    $sql .= ' where ea.idt_evento = ' . null($rowf['idt']);
                    $sql .= whereEventoParticipante();
                    $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                    execsql($sql);

                    $sql = '';
                    $sql .= ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_insumo (idt_gec_contratacao_credenciado_ordem, idt_evento, idt_insumo, codigo,';
                    $sql .= ' descricao, qtd_automatico, quantidade, custo_unitario_prev, custo_total_prev, custo_unitario_real, custo_total_real)';
                    $sql .= " select {$idt_ordem_contratacao} as idt_gec_contratacao_credenciado_ordem, idt_evento, idt_insumo, codigo,";
                    $sql .= ' descricao, qtd_automatico, quantidade_evento, custo_unitario_real, custo_total, custo_unitario_real, custo_total';
                    $sql .= ' from grc_evento_insumo';
                    $sql .= ' where idt_evento = ' . null($rowf['idt']);
                    $sql .= ' and idt_profissional = ' . null($row['idt_profissional']);
                    execsql($sql);
                }
            } else {
                switch ($idt_gec_natureza_servico) {
                    case 1: //Instrutoria
                        $tipo = 'I';
                        break;

                    case 2: //Consultoria
                        $tipo = 'C';
                        break;

                    default: //Consultoria/Instrutoria
                        $tipo = 'I';
                        break;
                }

                $sql = '';
                $sql .= ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_agenda (idt_gec_contratacao_credenciado_ordem, idt_evento, tipo, dt_ini, dt_fim, tot_hora, obs)';
                $sql .= " select {$idt_ordem_contratacao} as idt_gec_contratacao_credenciado_ordem, idt_evento, '{$tipo}' as tipo, ea.dt_ini, ea.dt_fim, ea.carga_horaria as tot_hora, ea.observacao as obs";
                $sql .= ' from grc_evento_agenda ea';
                $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
                $sql .= ' where ea.idt_evento = ' . null($idt_evento);
                $sql .= whereEventoParticipante();
                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                execsql($sql);

                $sql = '';
                $sql .= ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_insumo (idt_gec_contratacao_credenciado_ordem, idt_evento, idt_insumo, codigo,';
                $sql .= ' descricao, qtd_automatico, quantidade, custo_unitario_prev, custo_total_prev, custo_unitario_real, custo_total_real)';
                $sql .= " select {$idt_ordem_contratacao} as idt_gec_contratacao_credenciado_ordem, idt_evento, idt_insumo, codigo,";
                $sql .= ' descricao, qtd_automatico, quantidade_evento, custo_unitario_real, custo_total, custo_unitario_real, custo_total';
                $sql .= ' from grc_evento_insumo';
                $sql .= ' where idt_evento = ' . $idt_evento;
                $sql .= ' and idt_profissional = ' . null($row['idt_profissional']);
                execsql($sql);
            }

            $sql = '';
            $sql .= ' select min(dt_ini) as dt_ini, max(dt_fim) as dt_fim, sum(tot_hora) as tot_hora, avg(tot_hora) as carga_horaria';
            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_agenda';
            $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem_contratacao);
            $sql .= " and tipo = 'C'";
            $rsa = execsql($sql);
            $rowa = $rsa->data[0];

            $sql = '';
            $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem set';
            $sql .= ' agenda_consultoria_dt_ini = ' . aspa($rowa['dt_ini']) . ',';
            $sql .= ' agenda_consultoria_dt_fim = ' . aspa($rowa['dt_fim']) . ',';
            $sql .= ' agenda_consultoria_carga_horaria = ' . null($rowa['carga_horaria']) . ',';
            $sql .= ' agenda_consultoria_tot_hora = ' . null($rowa['tot_hora']);
            $sql .= ' where idt = ' . null($idt_ordem_contratacao);
            execsql($sql);

            $sql = '';
            $sql .= ' select min(dt_ini) as dt_ini, max(dt_fim) as dt_fim, sum(tot_hora) as tot_hora, avg(tot_hora) as carga_horaria';
            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_agenda';
            $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem_contratacao);
            $sql .= " and tipo = 'I'";
            $rsa = execsql($sql);
            $rowa = $rsa->data[0];

            $sql = '';
            $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem set';
            $sql .= ' agenda_instrutoria_dt_ini = ' . aspa($rowa['dt_ini']) . ',';
            $sql .= ' agenda_instrutoria_dt_fim = ' . aspa($rowa['dt_fim']) . ',';
            $sql .= ' agenda_instrutoria_carga_horaria = ' . null($rowa['carga_horaria']) . ',';
            $sql .= ' agenda_instrutoria_tot_hora = ' . null($rowa['tot_hora']);
            $sql .= ' where idt = ' . null($idt_ordem_contratacao);
            execsql($sql);

            if ($composto_w == 'S') {
                $sql = '';
                $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_insumo set';
                $sql .= " qtd_automatico = 'N'";
                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem_contratacao);
                execsql($sql);
            }

            if ($row_programa['tipo_ordem'] == 'SG') {
                //Entregas
                $sql = '';
                $sql .= ' select ea.idt, ea.idt_atendimento, ea.codigo, ea.descricao, ea.detalhe, ea.percentual, ea.ordem';
                $sql .= ' from grc_evento_entrega ea';
                $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
                $sql .= ' where ea.idt_evento = ' . null($idt_evento);
                $sql .= whereEventoParticipante();
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $sql = '';
                    $sql .= ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega (idt_gec_contratacao_credenciado_ordem, idt_atendimento, codigo, descricao, detalhe, percentual, ordem) values (';
                    $sql .= null($idt_ordem_contratacao) . ', ' . null($row['idt_atendimento']) . ', ' . aspa($row['codigo']) . ', ' . aspa($row['descricao']) . ', ' . aspa($row['detalhe']) . ', ';
                    $sql .= aspa($row['percentual']) . ', ' . aspa($row['ordem']) . ')';
                    execsql($sql);
                    $idt_gec_contratacao_credenciado_ordem_entrega = lastInsertId();

                    $sql = '';
                    $sql .= ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega_documento (idt_gec_contratacao_credenciado_ordem_entrega, idt_documento, codigo)';
                    $sql .= ' select ' . $idt_gec_contratacao_credenciado_ordem_entrega . ' as idt_gec_contratacao_credenciado_ordem_entrega, idt_documento, codigo';
                    $sql .= ' from grc_evento_entrega_documento';
                    $sql .= ' where idt_evento_entrega = ' . null($row['idt']);
                    execsql($sql);
                }

                if ($sgtec_modelo_w == 'E' && $vl_determinado_w == 'S') {
                    $sql = '';
                    $sql .= ' select sum(ed.vl_unitario * ed.qtd) as resumo_tot';
                    $sql .= ' from grc_evento_dimensionamento ed';
                    $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ed.idt_atendimento';
                    $sql .= ' where ed.idt_evento = ' . null($idt_evento);
                    $sql .= whereEventoParticipante();
                    $rs = execsql($sql);
                    $cotacaoReal = $rs->data[0][0];

                    $sql = 'update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_insumo set custo_unitario_prev = ' . null($cotacaoReal);
                    $sql .= ', custo_unitario_real = ' . null($cotacaoReal);
                    $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem_contratacao);
                    $sql .= " and codigo = '71001'";
                    execsql($sql);

                    $sql = 'update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_insumo set custo_total_prev = custo_unitario_prev * quantidade';
                    $sql .= ', custo_total_real = custo_unitario_real * quantidade';
                    $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem_contratacao);
                    $sql .= " and codigo = '71001'";
                    execsql($sql);

                    $sql = 'update grc_evento_insumo set custo_unitario_real = ' . null($cotacaoReal);
                    $sql .= ' where idt_evento = ' . null($idt_evento);
                    $sql .= " and codigo = '71001'";
                    execsql($sql);

                    $sql = 'update grc_evento_insumo set custo_total = custo_unitario_real * quantidade_evento';
                    $sql .= ' where idt_evento = ' . null($idt_evento);
                    $sql .= " and codigo = '71001'";
                    execsql($sql);

                    $sql = '';
                    $sql .= ' update grc_evento set';
                    $sql .= ' custo_tot_consultoria = ' . null($cotacaoReal);
                    $sql .= ' where idt = ' . null($idt_evento);
                    execsql($sql);

                    $sql = '';
                    $sql .= ' select distinct idt_atendimento';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega';
                    $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem_contratacao);
                    $rsED = execsql($sql);

                    if ($rsED->rows > 0) {
                        if ($cotacaoReal == '') {
                            $cotacaoReal = 0;
                        }

                        $cotacao = floor($cotacaoReal / $rsED->rows * 100) / 100;
                        $cotacaoTot = 0;

                        foreach ($rsED->data as $idx => $rowED) {
                            if ($idx == $rsED->rows - 1) {
                                $cotacao = $cotacaoReal - $cotacaoTot;
                            }

                            $cotacaoTot += $cotacao;

                            $sql = '';
                            $sql .= ' select idt, percentual';
                            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega';
                            $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem_contratacao);
                            $sql .= ' and idt_atendimento = ' . null($rowED['idt_atendimento']);
                            $rs = execsql($sql);

                            $totalPrev = 0;

                            foreach ($rs->data as $idx => $row) {
                                if ($idx == $rs->rows - 1) {
                                    $valor_prev = $cotacao - $totalPrev;
                                } else {
                                    $valor_prev = floor($cotacao * $row['percentual']) / 100;
                                }

                                $totalPrev += $valor_prev;

                                $sql = 'update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega set vl_entrega_prev = ' . null($valor_prev);
                                $sql .= ' where idt = ' . null($row['idt']);
                                execsql($sql);
                            }
                        }
                    }

                    $vetErro = rmConsolidacaoPrevista($idt_ordem_contratacao);

                    if (count($vetErro) > 0) {
                        $variavel['erro'] = implode('<br />', $vetErro);
                        return 0;
                    }
                }
            } else {
                $vetErro = rmConsolidacaoPrevista($idt_ordem_contratacao);

                if (count($vetErro) > 0) {
                    $variavel['erro'] = implode('<br />', $vetErro);
                    return 0;
                }
            }

            $path_de = $vetSistemaUtiliza['GEC']['path'] . 'admin/obj_file/gec_contratar_modelo_anexo/';
            $path_para = $vetSistemaUtiliza['GEC']['path'] . 'admin/obj_file/gec_contratacao_credenciado_ordem_anexo/';

            $sql = '';
            $sql .= ' select *';
            $sql .= ' from ' . db_pir_gec . 'gec_contratar_modelo_anexo';
            $sql .= ' where idt_contratar_modelo = ' . null($idt_contratar_modelo);
            $rs = execsql($sql);

            ForEach ($rs->data as $row2) {
                $vetPrefixoArq = explode('_', $row2['arquivo']);
                $PrefixoArq = '';
                $PrefixoArq .= $vetPrefixoArq[0] . '_';
                $PrefixoArq .= $vetPrefixoArq[1] . '_';
                $PrefixoArq .= $vetPrefixoArq[2] . '_';
                $arq_novo = GerarStr() . '_arquivo_' . substr(time(), -3) . '_' . substr($row2['arquivo'], strlen($PrefixoArq));

                $arqCopia[] = Array(
                    'de' => str_replace('/', DIRECTORY_SEPARATOR, $path_de . $row2['arquivo']),
                    'para' => str_replace('/', DIRECTORY_SEPARATOR, $path_para . $arq_novo),
                );

                $idt_responsavel = null($row2['idt_responsavel']);
                $data_registro = aspa($row2['data_registro']);
                $titulo = aspa($row2['titulo']);
                $arquivo = aspa($arq_novo);

                $sql_i = ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_anexo ';
                $sql_i .= ' (  ';
                $sql_i .= " idt_contratacao_credenciado_ordem, ";
                $sql_i .= " idt_responsavel, ";
                $sql_i .= " data_registro, ";
                $sql_i .= " titulo, ";
                $sql_i .= " arquivo ";
                $sql_i .= '  ) values ( ';
                $sql_i .= " $idt_ordem_contratacao, ";
                $sql_i .= " $idt_responsavel, ";
                $sql_i .= " $data_registro, ";
                $sql_i .= " $titulo, ";
                $sql_i .= " $arquivo ";
                $sql_i .= ') ';
                execsql($sql_i);
            }
        }

        $sql_a = " update grc_evento_insumo set ";
        $sql_a .= " idt_ordem_contratacao  = {$idt_ordem_contratacao},";
        $sql_a .= " cod_ordem_contratacao = {$codigo}";
        $sql_a .= " where idt  = " . null($idt_evento_insumo);
        $result = execsql($sql_a);

        // Área de conhecimento
        $sql = ' delete from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_area_conhecimento ';
        $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem_contratacao);
        execsql($sql);

        ForEach ($vet_ac as $idt_pac => $rowt) {
            $idt_area = $rowt['idt_area'];
            $codigo = $rowt['codigo'];
            $descricao = $rowt['descricao'];
            $ativo = $rowt['ativo'];
            $detalhe = $rowt['detalhe'];


            $idt_gec_area_conhecimento = $idt_area;
            // gravar áreas da ordem de Contratação
            $sql_i = ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_area_conhecimento';
            $sql_i .= ' (  ';
            $sql_i .= " idt_gec_contratacao_credenciado_ordem, ";
            $sql_i .= " idt_gec_area_conhecimento ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " $idt_ordem_contratacao, ";
            $sql_i .= " $idt_gec_area_conhecimento ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
            $idt_ordem_contratacao_area_conhecimento = lastInsertId();
        }

        if ($gera_rodizio) {
            $vetRodizio = geraRodizioOrdemContratacao($idt_ordem_contratacao);

            //Grava o Rodizio
            $msgErro = '';
            $idt_ordem_contratacao_lista = gravaRodizioOrdemContratacao($vetRodizio, $codigow, $idt_ordem_contratacao, true, $msgErro);

            if ($msgErro != '') {
                $variavel['erro'] = $msgErro;
                return 0;
            }

            if ($vetRodizio['tem_habilitado'] == 'S') {
                $sql = "select * from " . db_pir_gec . "plu_config where ordem = '04'";
                $rsGEC = execsql($sql);

                $vetConfGEC = Array();

                ForEach ($rsGEC->data as $rowGEC) {
                    $vetConfGEC[$rowGEC['variavel']] = trim($rowGEC['valor'] . ($rowGEC['extra'] == '' ? '' : ' ' . $rowGEC['extra']));
                }

                if ($row_programa['tipo_ordem'] == 'SG' && $sgtec_modelo_w == 'E') {
                    $hora = ' ' . (date('H') - date('I')) . ':' . date('i');

                    $dt_aviso_ini = getdata(false, true);
                    $dt_aviso_fim = Calendario::Intervalo_Util($dt_aviso_ini, $vetConfGEC['grc_rodizio_dia_cotacao']);

                    if ($vl_determinado_w == 'S') {
                        $updateDtContratacao = false;
                    } else {
                        $updateDtContratacao = true;

                        $sql = "select valor from " . db_pir_grc . "plu_config where variavel = 'evento_sg_validade_cotacao'";
                        $rsGEC = execsql($sql);
                        $evento_sg_validade_cotacao = $rsGEC->data[0][0];

                        $dt_contratacao_ini = Calendario::Intervalo_Util($dt_aviso_fim, 1);

                        if ($evento_sg_validade_cotacao != '') {
                            $dt_contratacao_ini = Calendario::Intervalo_Corrido($dt_contratacao_ini, $evento_sg_validade_cotacao);
                        }

                        if ($entrega_prazo_max_w == '') {
                            $dt_contratacao_fim = $dt_contratacao_ini;
                        } else {
                            $dt_contratacao_fim = Calendario::Intervalo_Corrido($dt_contratacao_ini, $entrega_prazo_max_w);
                        }
                    }

                    $dt_aviso_ini = trata_data($dt_aviso_ini . $hora);
                    $dt_aviso_fim = trata_data($dt_aviso_fim . $hora);
                    $dt_contratacao_ini = trata_data($dt_contratacao_ini . $hora);
                    $dt_contratacao_fim = trata_data($dt_contratacao_fim . $hora);

                    $sql = '';
                    $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem set';

                    if ($updateDtContratacao) {
                        $sql .= ' dt_contratacao_ini = ' . aspa($dt_contratacao_ini) . ',';
                        $sql .= ' dt_contratacao_fim = ' . aspa($dt_contratacao_fim) . ',';
                    }

                    $sql .= ' data_inicio_cotacao = ' . aspa($dt_aviso_ini) . ',';
                    $sql .= ' data_final_cotacao = ' . aspa($dt_aviso_fim);
                    $sql .= ' where idt = ' . null($idt_ordem_contratacao);
                    execsql($sql);
                } else {
                    $dt_aviso_ini = trata_data(getdata(true, true, true));
                    $dt_aviso_fim = trata_data(date('d/m/Y H:i:s', strtotime('+' . $vetConfGEC['grc_rodizio_aviso_timeout'] . ' hours')));

                    $sql = '';
                    $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem set';
                    $sql .= ' data_inicio_cotacao = ' . aspa($dt_aviso_ini) . ',';
                    $sql .= ' data_final_cotacao = ' . aspa($dt_aviso_fim);
                    $sql .= ' where idt = ' . null($idt_ordem_contratacao);
                    execsql($sql);
                }

                $sql = '';
                $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista set';
                $sql .= ' envia_aviso = 1,';
                $sql .= ' dt_ini_aviso_1 = ' . aspa($dt_aviso_ini) . ',';
                $sql .= ' dt_fim_aviso_1 = ' . aspa($dt_aviso_fim) . ',';
                $sql .= ' data_inicio_cotacao = ' . aspa($dt_aviso_ini) . ',';
                $sql .= ' data_final_cotacao = ' . aspa($dt_aviso_fim) . ',';
                $sql .= ' dt_utl_aviso = ' . aspa($dt_aviso_ini);
                $sql .= ' where idt = ' . null($idt_ordem_contratacao_lista);
                execsql($sql);

                //Envia Aviso
                $erro = '';
                $erro = enviaEmailOrdemContratacao($idt_ordem_contratacao_lista);

                if ($erro != '') {
                    $variavel['erro'] = $erro;
                    return 0;
                }
            }
        }

        if ($copia_lista) {
            $sql = '';
            $sql .= ' select idt_primeiro, idt_organizacao';
            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem o';
            $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista ol on ol.idt_gec_contratacao_credenciado_ordem = o.idt';
            $sql .= " where ol.ativo = 'S'";
            $sql .= ' and o.idt_evento = ' . null($cred_idt_evento_w);
            $sql .= " and o.ativo = 'S'";
            $rsl = execsql($sql);

            if ($rsl->rows == 1) {
                $rowl = $rsl->data[0];

                $auto_prefixo = $codigow . '.';
                $codigo = $auto_prefixo . geraAutoNum(db_pir_gec, 'gec_contratacao_credenciado_ordem_lista_codigo_' . $auto_prefixo, 4);
                $descricao = 'Lista copiada do evento ' . $cred_cod_evento_w;
                $ativo = 'S';

                $sql = 'insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista (';
                $sql .= 'idt_gec_contratacao_credenciado_ordem, codigo, descricao, ativo, idt_primeiro, idt_organizacao';
                $sql .= ') values (';
                $sql .= null($idt_ordem_contratacao) . ', ' . aspa($codigo) . ', ' . aspa($descricao) . ', ' . aspa($ativo) . ', ' . null($rowl['idt_primeiro']) . ', ' . null($rowl['idt_organizacao']);
                $sql .= ')';
                execsql($sql);
                $idt_ordem_contratacao_lista = lastInsertId();

                $sql = "select * from " . db_pir_gec . "plu_config where ordem = '04'";
                $rsGEC = execsql($sql);

                $vetConfGEC = Array();

                ForEach ($rsGEC->data as $rowGEC) {
                    $vetConfGEC[$rowGEC['variavel']] = trim($rowGEC['valor'] . ($rowGEC['extra'] == '' ? '' : ' ' . $rowGEC['extra']));
                }

                $dt_aviso_ini = trata_data(getdata(true, true, true));
                $dt_aviso_fim = trata_data(date('d/m/Y H:i:s', strtotime('+' . $vetConfGEC['grc_rodizio_aviso_timeout'] . ' hours')));

                $sql = '';
                $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem set';
                $sql .= ' data_inicio_cotacao = ' . aspa($dt_aviso_ini) . ',';
                $sql .= ' data_final_cotacao = ' . aspa($dt_aviso_fim);
                $sql .= ' where idt = ' . null($idt_ordem_contratacao);
                execsql($sql);

                $sql = '';
                $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista set';
                $sql .= ' envia_aviso = 1,';
                $sql .= ' dt_ini_aviso_1 = ' . aspa($dt_aviso_ini) . ',';
                $sql .= ' dt_fim_aviso_1 = ' . aspa($dt_aviso_fim) . ',';
                $sql .= ' data_inicio_cotacao = ' . aspa($dt_aviso_ini) . ',';
                $sql .= ' data_final_cotacao = ' . aspa($dt_aviso_fim) . ',';
                $sql .= ' dt_utl_aviso = ' . aspa($dt_aviso_ini);
                $sql .= ' where idt = ' . null($idt_ordem_contratacao_lista);
                execsql($sql);

                //Envia Aviso
                $erro = '';
                $erro = enviaEmailOrdemContratacao($idt_ordem_contratacao_lista);

                if ($erro != '') {
                    $variavel['erro'] = $erro;
                    return 0;
                }
            }
        }
    }

    if ($beginTransaction) {
        commit();
    }

    foreach ($arqCopia as $arq) {
        if (is_file($arq['de'])) {
            copy($arq['de'], $arq['para']);
        }
    }

    $variavel['erro'] = '';
}

function BuscaCNPJ_GEC($idt_entidade_organizacao, &$variavel) {
    $kokw = 0;
    $variavel['codparceiro_lista'] = '';

    $cnpj = $variavel['cnpj'];
    $cnpj_w = $variavel['cnpj'];
    $codparceiro = $variavel['codparceiro'];
    $cpfcnpj_w = $cnpj_w;

    $temRegistro = false;

    $dadosPesq = Array();
    $dadosPesq['razao_social'] = $variavel['razao_social'];
    $dadosPesq['nome_fantasia'] = $variavel['nome_fantasia'];
    $dadosPesq['ie_prod_rural'] = $variavel['ie_prod_rural'];
    $dadosPesq['sicab_codigo'] = $variavel['sicab_codigo'];
    $dadosPesq['dap'] = $variavel['dap'];
    $dadosPesq['rmp'] = $variavel['rmp'];
    $dadosPesq['nirf'] = $variavel['nirf'];

    //
    // Se tem empresa associada Busca dados
    //
    $vetEntidade = Array();

    if ($variavel['bancoTransaction'] != 'N') {
        beginTransaction();
    }

    set_time_limit(600);

    $cpfcnpj_w = $cnpj_w;
    $kretw = BuscaDadosEntidadePIR($cpfcnpj_w, 'O', $vetEntidade, $codparceiro, $dadosPesq);

    if ($vetEntidade['PIR']['O']['existe_entidade'] != 'S') {
        if ($cnpj_w == "" && $codparceiro == "" && ($variavel['razao_social'] != '' || $variavel['nome_fantasia'] != '' || $variavel['ie_prod_rural'] != '' || $variavel['sicab_codigo'] != '' || $variavel['dap'] != '' || $variavel['rmp'] != '' || $variavel['nirf'] != '')) {
            $sql = '';
            $sql .= ' select j.codparceiro, p.cgccpf';
            $sql .= ' from pessoaj j with(nolock)';
            $sql .= ' inner join parceiro p with(nolock) on p.codparceiro = j.codparceiro';
            $sql .= ' where ';

            $vetSQL = Array();

            if ($variavel['ie_prod_rural'] != '') {
                $vetSQL[] = 'j.codprodutorrural = ' . aspa($variavel['ie_prod_rural']);
            }

            if ($variavel['sicab_codigo'] != '') {
                $vetSQL[] = 'j.codsicab = ' . aspa(preg_replace('/\./i', '', $variavel['sicab_codigo']));
            }

            if ($variavel['dap'] != '') {
                $vetSQL[] = 'j.coddap = ' . aspa($variavel['dap']);
            }

            if ($variavel['rmp'] != '') {
                $vetSQL[] = 'j.codpescador = ' . aspa($variavel['rmp']);
            }

            if ($variavel['nirf'] != '') {
                $vetSQL[] = 'j.nirf = ' . null(preg_replace('/[^0-9]/i', '', $variavel['nirf']));
            }

            if (count($vetSQL) == 0) {
                if ($variavel['razao_social'] != '') {
                    $vetSQL[] = 'lower(p.nomerazaosocial) like lower(' . aspa($variavel['razao_social'], '%', '%') . ')';
                }

                if ($variavel['nome_fantasia'] != '') {
                    $vetSQL[] = 'lower(p.nomeabrevfantasia) like lower(' . aspa($variavel['nome_fantasia'], '%', '%') . ')';
                }
            }

            if (count($vetSQL) == 0) {
                $sql .= ' 1 = 0 ';
            } else {
                $sql .= implode(' or ', $vetSQL);
            }

            $rs = execsql($sql, true, conSIAC());

            switch ($rs->rows) {
                case 0:
                    $idt_tipo_empreendimento_e = 7;
                    $dap_e = $variavel['dap'];
                    $nirf_e = $variavel['nirf'];
                    $rmp_e = $variavel['rmp'];
                    $ie_prod_rural_e = $variavel['ie_prod_rural'];
                    $sicab_codigo = $variavel['sicab_codigo'];
                    $razao_social_e = $variavel['razao_social'];
                    $nome_fantasia_e = $variavel['nome_fantasia'];

                    $variavel['idt_entidade_organizacao'] = 0;
                    break;

                case 1:
                    /*
                      if ($rs->data[0]['cgccpf'] != '') {
                      $cnpj_w = FormataCNPJ($rs->data[0]['cgccpf']);
                      }
                     * 
                     */

                    $variavel['codparceiro'] = $rs->data[0]['codparceiro'];
                    $codparceiro = $variavel['codparceiro'];
                    break;

                default:
                    $vetTmp = Array();

                    foreach ($rs->data as $row) {
                        $vetTmp[$row['codparceiro']] = $row['codparceiro'];
                    }

                    $variavel['codparceiro_lista'] = implode(', ', $vetTmp);
                    return $kokw;
            }
        }

        $vetEntidade = Array();
        $kretw = BuscaDadosEntidadePIR($cpfcnpj_w, 'O', $vetEntidade, $codparceiro, $dadosPesq);
        $kretw = BuscaDadosEntidadeSIACBA($cpfcnpj_w, 'J', $vetEntidade, $codparceiro);
        $kretw = BuscaDadosEntidadeRF($cpfcnpj_w, 'J', $vetEntidade);
    }

    $idt_entidade_gec = '';

    $vetpir = $vetEntidade['PIR']['O'];
    $codigo_siacweb_e = "";
    $codigo_prod_rural = '';
    $representa_codcargcli = "";
    $idt_representa = "";
    $idt_tipo_empreendimento_e = "";
    $cnpj_e = "";
    $razao_social_e = "";
    $nome_fantasia_e = "";
    $data_abertura_e = "";
    $pessoas_ocupadas_e = "";
    $cep_e = "";
    $logradouro_e = "";
    $logradouro_numero_e = "";
    $logradouro_bairro_e = "";
    $logradouro_complemento_e = "";
    $logradouro_municipio_e = "";
    $logradouro_estado_e = "";
    $logradouro_pais_e = "";

    $logradouro_codbairro_e = "";
    $logradouro_codcid_e = "";
    $logradouro_codest_e = "";
    $logradouro_codpais_e = "";

    $idt_pais_e = "";
    $idt_estado_e = "";
    $idt_cidade_e = "";
    $telefone_comercial_e = "";
    $telefone_celular_e = "";
    $sms_e = "";
    $email_e = "";
    $site_url_e = "";
    $receber_informacao_e = "";
    //p($vetpir);

    $totReg = $vetret['qtd_entidade'];
    if ($vetpir['existe_entidade'] == 'S') {
        $temRegistro = true;

        $qtd_entidade = $vetpir['qtd_entidade'];
        $idt_entidade = $vetpir['idt_entidade'];
        $idt_entidade_gec = $vetpir['idt_entidade'];
        $excluido_ws = $vetpir['excluido_ws'];
        $dt_ult_alteracao = $vetpir['dt_ult_alteracao'];
        $cpfcnpj = $vetpir['cpfcnpj'];
        $idt_cliente = $vetpir['idt_cliente'];
        $nome = $vetpir['nome'];
        $resumo = $vetpir['resumo'];
        $telefone = $vetpir['telefone'];
        $celular = $vetpir['celular'];
        $email = $vetpir['email'];
        $cnpj = $vetpir['cnpj'];
        $nome_empresa = $vetpir['nome_empresa'];

        $representa_codcargcli = $vetpir['representa_codcargcli'];
        $idt_representa = $vetpir['idt_ult_representante_emp'];

        $cnpj_e = $cpfcnpj;
        $razao_social_e = $nome;
        $nome_fantasia_e = $resumo;

        // funil
        $funil_idt_cliente_classificacao = $vetpir['funil_idt_cliente_classificacao'];
        $funil_cliente_nota_avaliacao = $vetpir['funil_cliente_nota_avaliacao'];
        $funil_cliente_data_avaliacao = $vetpir['funil_cliente_data_avaliacao'];
        $funil_cliente_obs_avaliacao = $vetpir['funil_cliente_obs_avaliacao'];

        // complemento dependendo do tipo
        $vetdadosproprios = $vetpir['dadosproprios'];
        //p($vetdadosproprios);

        $idt_e = $vetdadosproprios['row']['idt'];
        $idt_origem_e = $vetdadosproprios['row']['idt_origem'];
        $idt_entidade_e = $vetdadosproprios['row']['idt_entidade'];
        $inscricao_estadual_e = $vetdadosproprios['row']['inscricao_estadual'];
        $inscricao_municipal_e = $vetdadosproprios['row']['inscricao_municipal'];
        $registro_junta_e = $vetdadosproprios['row']['registro_junta'];
        $data_registro_e = $vetdadosproprios['row']['data_registro'];
        $ativo_e = $vetdadosproprios['row']['ativo'];
        $idt_porte_e = $vetdadosproprios['row']['idt_porte'];
        $idt_tipo_e = $vetdadosproprios['row']['idt_tipo'];
        $idt_natureza_juridica_e = $vetdadosproprios['row']['idt_natureza_juridica'];
        $idt_faturamento_e = $vetdadosproprios['row']['idt_faturamento'];
        $faturamento_e = $vetdadosproprios['row']['faturamento'];
        $qt_funcionarios_e = $vetdadosproprios['row']['qt_funcionarios'];
        $data_inicio_atividade_e = $vetdadosproprios['row']['data_inicio_atividade'];
        $dap_e = $vetdadosproprios['row']['dap'];
        $nirf_e = $vetdadosproprios['row']['nirf'];
        $rmp_e = $vetdadosproprios['row']['rmp'];
        $ie_prod_rural_e = $vetdadosproprios['row']['ie_prod_rural'];
        $sicab_codigo = $vetdadosproprios['row']['sicab_codigo'];
        $sicab_dt_validade = $vetdadosproprios['row']['sicab_dt_validade'];
        $data_fim_atividade = $vetdadosproprios['row']['data_fim_atividade'];
        $siacweb_situacao = $vetpir['siacweb_situacao'];
        $pa_senha = $vetpir['pa_senha'];
        $pa_idfacebook = $vetpir['pa_idfacebook'];
        $startup_e = $vetdadosproprios['row']['startup'];
        $data_encerramento_e = $vetdadosproprios['row']['data_encerramento'];
        $simples_nacional_e = $vetdadosproprios['row']['simples_nacional'];
        $idt_entidade_setor_e = $vetdadosproprios['row']['idt_entidade_setor'];


        $grc_entidade_organizacao_tipo_informacao = $vetpir['gec_entidade_x_tipo_informacao'];

        $idt_organizacao_e = $vetdadosproprios['row']['idt'];
        $codigo_siacweb_e = $vetpir['codigo_siacweb'];
        $codigo_prod_rural = $vetpir['codigo_prod_rural'];
        $idt_tipo_empreendimento_e = $vetpir['idt_tipo_empreendimento'];
        $idt_entidade_setor_e = $vetdadosproprios['row']['idt_entidade_setor'];
        $tamanho_propriedade_e = $vetdadosproprios['row']['tamanho_propriedade'];
        //
        $data_abertura_e = $vetdadosproprios['row']['data_inicio_atividade'];
        $pessoas_ocupadas_e = $vetdadosproprios['row']['qt_funcionarios'];
        $receber_informacao_e = $vetpir['receber_informacao'];
        $idt_porte_e = $vetdadosproprios['row']['idt_porte'];
        $idt_setor_e = $vetdadosproprios['row']['idt_entidade_setor'];
        $simples_nacional_e = $vetdadosproprios['row']['simples_nacional'];

        //
        // Busca cnae principal
        $vetcmae = Array();
        $cnae_principal = BuscaCNAEPrincipal($idt_organizacao_e, $vetcmae);

        $idt_cnae_principal_e = $cnae_principal;

        // Parte variável
        $vetenderecos = $vetpir['enderecos'];
        $vetprotocolos = $vetpir['protocolos'];
        $vetempresas = $vetpir['empresas'];
        //p($vetenderecos);

        $vetempresasPE = $vetempresas['PE'];
        $vetempresasEP = $vetempresas['EP'];

        ForEach ($vetenderecos as $idx => $Vettrab) {
            $vetendereco = $Vettrab['endereco'];
            $vetrow = $vetendereco['row'];
            //
            // 00 é o principal
            //
                //$vetrow['idt_entidade_endereco_tipo'];
            if ($vetrow['gec_eneet_codigo'] != "00" and $vetrow['gec_eneet_codigo'] != "99") {
                continue;
            }
            $logradouro_e = $vetrow['logradouro'];
            $logradouro_numero_e = $vetrow['logradouro_numero'];
            $logradouro_complemento_e = $vetrow['logradouro_complemento'];
            $logradouro_bairro_e = $vetrow['logradouro_bairro'];
            $logradouro_municipio_e = $vetrow['logradouro_municipio'];
            $logradouro_estado_e = $vetrow['logradouro_estado'];
            $logradouro_pais_e = $vetrow['logradouro_pais'];

            $logradouro_codbairro_e = $vetrow['logradouro_codbairro'];
            $logradouro_codcid_e = $vetrow['logradouro_codcid'];
            $logradouro_codest_e = $vetrow['logradouro_codest'];
            $logradouro_codpais_e = $vetrow['logradouro_codpais'];

            $logradouro_cep_e = $vetrow['logradouro_cep'];
            $cep_e = $vetrow['cep'];
            $logradouro_cep_e = $cep_e;

            $idt_pais_e = $vetrow['idt_pais'];
            $idt_estado_e = $vetrow['idt_estado'];
            $idt_cidade_e = $vetrow['idt_cidade'];

            $vetcomunicacaow = $vetendereco['comunicacao'];
            if (is_array($vetcomunicacaow)) {
                ForEach ($vetcomunicacaow as $idxw => $VetCom) {
                    if ($VetCom['comunicacao']['origem'] == 'ATENDIMENTO PRINCIPAL') {
                        $telefone_comercial_e = $VetCom['comunicacao']['telefone_1'];
                        $telefone_celular_e = $VetCom['comunicacao']['telefone_2'];
                        $sms_e = $VetCom['comunicacao']['sms_1'];
                        $email_e = $VetCom['comunicacao']['email_1'];
                        $site_url_e = $VetCom['comunicacao']['www_1'];
                    }
                }
            }
        }
    } else {
        $vetpir = $vetEntidade['SIACBA']['J'];
        //p($vetpir);
        //exit();
        $totReg += $vetret['qtd_entidade'];
        if ($vetpir['existe_entidade'] == 'S') {
            $temRegistro = true;

            $qtd_entidade = $vetpir['qtd_entidade'];
            $idt_entidade = $vetpir['idt_entidade'];
            $cpfcnpj = $vetpir['cpfcnpj'];
            $idt_cliente = $vetpir['idt_cliente'];
            $nome = $vetpir['nome'];
            $dt_ult_alteracao = $vetpir['dataatu'];
            $telefone = $vetpir['telefone'];
            $celular = $vetpir['celular'];
            $email = $vetpir['email'];
            $cnpj = $vetpir['cnpj'];
            $nome_empresa = $vetpir['nome_empresa'];
            //
            $cnpj_e = $cpfcnpj;
            // complemento dependendo do tipo
            $vetdadosproprios = $vetpir['dadosproprios'];

            $codigo_siacweb_e = $vetdadosproprios['row']['codparceiro'];
            $cnpj_e = $vetdadosproprios['row']['cgccpf'];
            $razao_social_e = $vetdadosproprios['row']['nomerazaosocial'];
            $nome_fantasia_e = $vetdadosproprios['row']['nomeabrevfantasia'];
            $receber_informacao_e = $vetdadosproprios['row']['receberinfosebrae'];

            $inscricao_estadual_e = $vetdadosproprios['row']['inscest'];
            $inscricao_municipal_e = $vetdadosproprios['row']['inscmun'];
            $data_abertura_e = $vetdadosproprios['row']['databert'];

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade_tipo_emp';
            $sql .= ' where codigo = ' . aspa($vetdadosproprios['row']['codconst']);
            $rstt = execsql($sql);
            $idt_tipo_empreendimento_e = $rstt->data[0][0];

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade_setor';
            $sql .= ' where codigo = ' . aspa($vetdadosproprios['row']['codsetor']);
            $rstt = execsql($sql);
            $idt_setor_e = $rstt->data[0][0];

            $pessoas_ocupadas_e = $vetdadosproprios['row']['numfunc'];

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir_gec . 'gec_organizacao_porte';
            $sql .= ' where codigo = ' . aspa($vetdadosproprios['row']['faturam']);
            $rstt = execsql($sql);
            $idt_porte_e = $rstt->data[0][0];

            $dap_e = $vetdadosproprios['row']['coddap'];
            $nirf_e = $vetdadosproprios['row']['nirf'];
            $ie_prod_rural_e = $vetdadosproprios['row']['codprodutorrural'];
            $sicab_codigo = $vetdadosproprios['row']['codsicab'];
            $sicab_dt_validade = $vetdadosproprios['row']['datavalidade'];
            $data_fim_atividade = $vetdadosproprios['row']['datfech'];
            $siacweb_situacao = $vetdadosproprios['row']['situacao'];
            $pa_senha = $vetdadosproprios['row']['pa_senha'];
            $pa_idfacebook = $vetdadosproprios['row']['pa_idfacebook'];

            if ($vetdadosproprios['row']['optantesimplesnacional'] == 0) {
                $simples_nacional_e = 'S';
            } else {
                $simples_nacional_e = 'N';
            }

            $tamanho_propriedade_e = $vetdadosproprios['row']['tamanhopropriedade'];
            $rmp_e = $vetdadosproprios['row']['codpescador'];

            // Busca cnae principal
            $vetcmae = Array();

            $sql = '';
            $sql .= ' select codativecon, codcnaefiscal, indativprincipal';
            $sql .= ' from ' . db_pir_siac . 'ativeconpj';
            $sql .= ' where codparceiro = ' . null($codigo_siacweb_e);
            $rstt = execsql($sql);

            foreach ($rstt->data as $rowtt) {
                $cnae = substr($rowtt['codativecon'], 0, 4) . '-' . substr($rowtt['codativecon'], 4) . '/' . $rowtt['codcnaefiscal'];

                if ($rowtt['indativprincipal'] == 1) {
                    $idt_cnae_principal_e = $cnae;
                } else {
                    $vetcmae[] = Array(
                        'cnae' => $cnae,
                        'principal' => 'N',
                    );
                }
            }

            // Comunicacao
            $vetcomunicacao = $vetpir['comunicacao']['row'];
            $telefone_comercial_e = $vetcomunicacao['telefone_1_p'];
            $telefone_celular_e = $vetcomunicacao['telefone_2_p'];
            $sms_e = $vetcomunicacao['telefone_3_p'];
            $email_e = $vetcomunicacao['email_1_p'];
            $site_url_e = $vetcomunicacao['www_1_p'];

            // Parte variável
            $vetenderecos = $vetpir['enderecos'];

            ForEach ($vetenderecos as $idx => $vetrow) {
                //
                // 00 é o principal
                //
                    if ($vetrow['gec_eneet_codigo'] != "00" and $vetrow['gec_eneet_codigo'] != "99") {
                    continue;
                }

                $logradouro_e = $vetrow['logradouro'];
                $logradouro_numero_e = $vetrow['logradouro_numero'];
                $logradouro_complemento_e = $vetrow['logradouro_complemento'];
                $logradouro_bairro_e = $vetrow['logradouro_bairro'];
                $logradouro_municipio_e = $vetrow['logradouro_municipio'];
                $logradouro_estado_e = $vetrow['logradouro_estado'];
                $logradouro_pais_e = $vetrow['logradouro_pais'];

                $logradouro_codbairro_e = $vetrow['logradouro_codbairro'];
                $logradouro_codcid_e = $vetrow['logradouro_codcid'];
                $logradouro_codest_e = $vetrow['logradouro_codest'];
                $logradouro_codpais_e = $vetrow['logradouro_codpais'];

                $cep_e = $vetrow['logradouro_cep'];

                $idt_pais_e = $vetrow['idt_pais'];
                $idt_estado_e = $vetrow['idt_estado'];
                $idt_cidade_e = $vetrow['idt_cidade'];
            }
        } else {
            $vetpir = $vetEntidade['RF']['J'];

            $totReg += $vetret['qtd_entidade'];
            if ($vetpir['existe_entidade'] == 'S') {
                $qtd_entidade = $vetpir['qtd_entidade'];
                $idt_entidade = $vetpir['idt_entidade'];
                $cpfcnpj = $vetpir['cpfcnpj'];
                $idt_cliente = $vetpir['idt_cliente'];
                $nome = $vetpir['nome'];
                $telefone = $vetpir['telefone'];
                $celular = $vetpir['celular'];
                $email = $vetpir['email'];
                $cnpj = $vetpir['cnpj'];
                $nome_empresa = $vetpir['nome_empresa'];
                $cnpj_e = $cpfcnpj;
                $codigo_siacweb_e = $vetpir['codigo_siacweb_e'];
                $cnpj_e = $vetpir['cgccpf'];
                $razao_social_e = $vetpir['razao_social_e'];
                $nome_fantasia_e = $vetpir['nome_fantasia_e'];
                $receber_informacao_e = $vetpir['receber_informacao_e'];
                $inscricao_estadual_e = $vetpir['inscricao_estadual_e'];
                $inscricao_municipal_e = $vetpir['inscricao_municipal_e'];
                $data_abertura_e = $vetpir['data_abertura_e'];

                $idt_tipo_empreendimento_e = $vetpir['idt_tipo_empreendimento_e'];
                $idt_setor_e = $vetpir['idt_setor_e'];
                $pessoas_ocupadas_e = $vetpir['pessoas_ocupadas_e'];
                $idt_porte_e = $vetpir['idt_porte_e'];

                $dap_e = $vetpir['dap_e'];
                $nirf_e = $vetpir['nirf_e'];
                $ie_prod_rural_e = $vetpir['ie_prod_rural_e'];
                $sicab_codigo = $vetpir['sicab_codigo'];
                $sicab_dt_validade = $vetpir['sicab_dt_validade'];
                $data_fim_atividade = $vetpir['data_fim_atividade'];
                $siacweb_situacao = $vetpir['siacweb_situacao'];
                $pa_senha = $vetpir['pa_senha'];
                $pa_idfacebook = $vetpir['pa_idfacebook'];

                $simples_nacional_e = $vetpir['simples_nacional_e'];

                $tamanho_propriedade_e = $vetpir['tamanho_propriedade_e'];
                $rmp_e = $vetpir['rmp_e'];

                $idt_cnae_principal_e = $vetpir['idt_cnae_principal_e'];

                $telefone_comercial_e = $vetpir['telefone_comercial_e'];
                $telefone_celular_e = $vetpir['telefone_celular_e'];
                $sms_e = $vetpir['sms_e'];
                $email_e = $vetpir['email_e'];
                $site_url_e = $vetpir['site_url_e'];

                $logradouro_e = $vetpir['logradouro_e'];
                $logradouro_numero_e = $vetpir['logradouro_numero_e'];
                $logradouro_complemento_e = $vetpir['logradouro_complemento_e'];
                $logradouro_bairro_e = $vetpir['logradouro_bairro_e'];
                $logradouro_municipio_e = $vetpir['logradouro_municipio_e'];
                $logradouro_estado_e = $vetpir['logradouro_estado_e'];
                $logradouro_pais_e = $vetpir['logradouro_pais_e'];
                $logradouro_codbairro_e = $vetpir['logradouro_codbairro_e'];
                $logradouro_codcid_e = $vetpir['logradouro_codcid_e'];
                $logradouro_codest_e = $vetpir['logradouro_codest_e'];
                $logradouro_codpais_e = $vetpir['logradouro_codpais_e'];
                $cep_e = $vetpir['cep_e'];
                $idt_pais_e = $vetpir['idt_pais_e'];
                $idt_estado_e = $vetpir['idt_estado_e'];
                $idt_cidade_e = $vetpir['idt_cidade_e'];
            }
        }
    }

    if ($temRegistro || $totReg == 0) {
        //  Gerar registro de empreendimento

        $sql1 = 'delete from ' . db_pir_grc . 'grc_entidade_organizacao where idt = ' . null($idt_entidade_organizacao);
        execsql($sql1);

        $sql1 = 'delete from ' . db_pir_grc . 'grc_entidade_organizacao where idt_entidade = ' . null($idt_entidade_gec);
        execsql($sql1);

        $rowSIAC = situacaoParceiroSiacWeb('J', $cnpj_w, $nirf_e, $dap_e, $rmp_e, $ie_prod_rural_e, $sicab_codigo);

        if ($rowSIAC['siacweb_situacao'] !== '') {
            $siacweb_situacao = $rowSIAC['siacweb_situacao'];
            $data_fim_atividade = $rowSIAC['data_fim_atividade'];
        }

        $sql = '';
        $sql .= ' select c.idt_entidade_setor';
        $sql .= ' from ' . db_pir_gec . 'cnae c';
        $sql .= ' where c.codclass_siacweb = 1';
        $sql .= ' and c.subclasse = ' . aspa($idt_cnae_principal_e);
        $rstt = execsql($sql);

        if ($rstt->data[0][0] != '') {
            $idt_setor_e = $rstt->data[0][0];
        }

        $idt_entidade_gec = idtEntidadeGEC('O', $cnpj_w, $nirf_e, $dap_e, $rmp_e, $ie_prod_rural_e, $sicab_codigo);

        $codigo_siacweb = aspa($codigo_siacweb_e);

        if ($idt_tipo_empreendimento_e == '') {
            $idt_tipo_empreendimento_e = $variavel['idt_tipo_empreendimento'];
        }

        $idt_tipo_empreendimento = null($idt_tipo_empreendimento_e);

        if ($codigo_prod_rural == '' && substr($cnpj_e, 0, 2) == 'PR') {
            $codigo_prod_rural = $cnpj_e;
        }

        if ($codigo_prod_rural == '') {
            $codigo_prod_rural = 'PRGRC' . AutoNum('grc_atendimento_organizacao_cnpj_PR', 10, false, false, db_pir_grc);
        }

        if ($cnpj_w == '') {
            $cnpj = aspa($codigo_prod_rural);
        } else {
            $cnpj = aspa($cnpj_w);
        }

        $codigo_prod_rural = aspa($codigo_prod_rural);

        if ($razao_social_e == '') {
            $razao_social_e = 'Novo Empreendimento';
        }

        $razao_social = aspa($razao_social_e);
        $nome_fantasia = aspa($nome_fantasia_e);
        $data_abertura = aspa($data_abertura_e);
        $pessoas_ocupadas = null($pessoas_ocupadas_e);
        $logradouro_cep = aspa($cep_e);

        $logradouro_e = substr($logradouro_e, 0, 120);

        $logradouro_endereco = aspa($logradouro_e);
        $logradouro_numero = aspa($logradouro_numero_e);
        $logradouro_bairro = aspa($logradouro_bairro_e);
        $logradouro_complemento = aspa($logradouro_complemento_e);
        $logradouro_cidade = aspa($logradouro_municipio_e);
        $logradouro_estado = aspa($logradouro_estado_e);
        $logradouro_pais = aspa($logradouro_pais_e);

        $logradouro_codbairro_e = null($logradouro_codbairro_e);
        $logradouro_codcid_e = null($logradouro_codcid_e);
        $logradouro_codest_e = null($logradouro_codest_e);
        $logradouro_codpais_e = null($logradouro_codpais_e);

        $idt_pais = null($idt_pais_e);
        $idt_estado = null($idt_estado_e);
        $idt_cidade = null($idt_cidade_e);
        $telefone_comercial = aspa($telefone_comercial_e);
        $telefone_celular = aspa($telefone_celular_e);
        $sms = aspa($sms_e);
        $email = aspa($email_e);
        $site_url = aspa($site_url_e);
        $receber_informacao = aspa($receber_informacao_e);
        //
        $dap = aspa($dap_e);
        $nirf = aspa(FormataNirf($nirf_e));
        $rmp = aspa($rmp_e);
        $ie_prod_rural = aspa($ie_prod_rural_e);
        $sicab_codigo = aspa(FormataSICAB($sicab_codigo));
        $sicab_dt_validade = aspa($sicab_dt_validade);
        $data_fim_atividade = aspa($data_fim_atividade);

        if ($siacweb_situacao == '') {
            $siacweb_situacao = 1;
        }

        $siacweb_situacao = null($siacweb_situacao);
        $pa_senha = aspa($pa_senha);
        $pa_idfacebook = aspa($pa_idfacebook);
        $data_abertura = aspa($data_abertura_e);
        $pessoas_ocupadas = aspa($pessoas_ocupadas_e);
        $idt_cnae_principal = aspa($idt_cnae_principal_e);
        $idt_porte = null($idt_porte_e);
        $idt_setor = null($idt_setor_e);
        $simples_nacional = null($simples_nacional_e);
        $tamanho_propriedade = null($tamanho_propriedade_e);

        $representa_codcargcli = null($representa_codcargcli);
        $idt_representa = null($idt_representa);

        if ($excluido_ws == '') {
            $excluido_ws = aspa('N');
        } else {
            $excluido_ws = aspa($excluido_ws);
        }

        $dt_ult_alteracao = aspa($dt_ult_alteracao);


        $funil_idt_cliente_classificacao = null($funil_idt_cliente_classificacao);
        $funil_cliente_nota_avaliacao = null($funil_cliente_nota_avaliacao);
        $funil_cliente_data_avaliacao = aspa($funil_cliente_data_avaliacao);
        $funil_cliente_obs_avaliacao = aspa($funil_cliente_obs_avaliacao);


        $sql_i = ' insert into ' . db_pir_grc . 'grc_entidade_organizacao ';
        $sql_i .= ' (  ';
        $sql_i .= ' excluido_ws, ';
        $sql_i .= ' dt_ult_alteracao, ';
        $sql_i .= ' novo_registro, ';
        $sql_i .= ' modificado, ';
        $sql_i .= " idt_entidade, ";
        $sql_i .= " cnpj, ";
        $sql_i .= " codigo_prod_rural, ";
        $sql_i .= " razao_social, ";
        $sql_i .= " nome_fantasia, ";

        // funil
        $sql_i .= " funil_idt_cliente_classificacao, ";
        $sql_i .= " funil_cliente_nota_avaliacao, ";
        $sql_i .= " funil_cliente_data_avaliacao, ";
        $sql_i .= " funil_cliente_obs_avaliacao, ";

        $sql_i .= " codigo_siacweb_e, ";
        $sql_i .= " representa_codcargcli, ";
        $sql_i .= " idt_representa, ";
        $sql_i .= " idt_tipo_empreendimento, ";
        $sql_i .= " data_abertura, ";
        $sql_i .= " pessoas_ocupadas, ";
        $sql_i .= " logradouro_cep_e, ";
        $sql_i .= " logradouro_endereco_e, ";
        $sql_i .= " logradouro_numero_e, ";
        $sql_i .= " logradouro_bairro_e, ";
        $sql_i .= " logradouro_complemento_e, ";
        $sql_i .= " logradouro_cidade_e, ";
        $sql_i .= " logradouro_estado_e, ";
        $sql_i .= " logradouro_pais_e, ";

        $sql_i .= " logradouro_codbairro_e, ";
        $sql_i .= " logradouro_codcid_e, ";
        $sql_i .= " logradouro_codest_e, ";
        $sql_i .= " logradouro_codpais_e, ";

        $sql_i .= " idt_pais_e, ";
        $sql_i .= " idt_estado_e, ";
        $sql_i .= " idt_cidade_e, ";
        $sql_i .= " telefone_comercial_e, ";
        $sql_i .= " telefone_celular_e, ";
        $sql_i .= " email_e, ";
        $sql_i .= " sms_e, ";
        $sql_i .= " site_url, ";
        $sql_i .= " receber_informacao_e, ";
        $sql_i .= " dap,  ";
        $sql_i .= " nirf,  ";
        $sql_i .= " rmp,  ";
        $sql_i .= " ie_prod_rural,  ";
        $sql_i .= " sicab_codigo,  ";
        $sql_i .= " sicab_dt_validade,  ";
        $sql_i .= " data_fim_atividade,  ";
        $sql_i .= " siacweb_situacao_e,  ";
        $sql_i .= " pa_senha_e, ";
        $sql_i .= " pa_idfacebook_e, ";
        $sql_i .= " idt_cnae_principal,  ";
        $sql_i .= " idt_porte,  ";
        $sql_i .= " idt_setor,  ";
        $sql_i .= " simples_nacional,  ";
        $sql_i .= " tamanho_propriedade  ";
        $sql_i .= '  ) values ( ';
        $sql_i .= " $excluido_ws, ";
        $sql_i .= " $dt_ult_alteracao, ";
        $sql_i .= " 'S', ";
        $sql_i .= " 'N', ";
        $sql_i .= null($idt_entidade_gec) . ", ";
        $sql_i .= " $cnpj, ";
        $sql_i .= " $codigo_prod_rural, ";
        $sql_i .= " $razao_social, ";
        $sql_i .= " $nome_fantasia, ";

        // funil
        $sql_i .= " $funil_idt_cliente_classificacao, ";
        $sql_i .= " $funil_cliente_nota_avaliacao, ";
        $sql_i .= " $funil_cliente_data_avaliacao, ";
        $sql_i .= " $funil_cliente_obs_avaliacao, ";

        $sql_i .= " $codigo_siacweb, ";
        $sql_i .= " $representa_codcargcli, ";
        $sql_i .= " $idt_representa, ";
        $sql_i .= " $idt_tipo_empreendimento, ";
        $sql_i .= " $data_abertura, ";
        $sql_i .= " $pessoas_ocupadas, ";
        $sql_i .= " $logradouro_cep, ";
        $sql_i .= " $logradouro_endereco, ";
        $sql_i .= " $logradouro_numero, ";
        $sql_i .= " $logradouro_bairro, ";
        $sql_i .= " $logradouro_complemento, ";
        $sql_i .= " $logradouro_cidade, ";
        $sql_i .= " $logradouro_estado, ";
        $sql_i .= " $logradouro_pais, ";

        $sql_i .= " $logradouro_codbairro_e, ";
        $sql_i .= " $logradouro_codcid_e, ";
        $sql_i .= " $logradouro_codest_e, ";
        $sql_i .= " $logradouro_codpais_e, ";

        $sql_i .= " $idt_pais, ";
        $sql_i .= " $idt_estado, ";
        $sql_i .= " $idt_cidade, ";
        $sql_i .= " $telefone_comercial, ";
        $sql_i .= " $telefone_celular, ";
        $sql_i .= " $email, ";
        $sql_i .= " $sms, ";
        $sql_i .= " $site_url, ";
        $sql_i .= " $receber_informacao, ";
        $sql_i .= " $dap,  ";
        $sql_i .= " $nirf,  ";
        $sql_i .= " $rmp,  ";
        $sql_i .= " $ie_prod_rural,  ";
        $sql_i .= " $sicab_codigo,  ";
        $sql_i .= " $sicab_dt_validade,  ";
        $sql_i .= " $data_fim_atividade,  ";
        $sql_i .= " $siacweb_situacao,  ";
        $sql_i .= " $pa_senha, ";
        $sql_i .= " $pa_idfacebook, ";
        $sql_i .= " $idt_cnae_principal,  ";
        $sql_i .= " $idt_porte,  ";
        $sql_i .= " $idt_setor,  ";
        $sql_i .= " $simples_nacional,  ";
        $sql_i .= " $tamanho_propriedade  ";
        $sql_i .= ') ';
        $result = execsql($sql_i);
        $idt_entidade_organizacao = lastInsertId();

        ForEach ($vetcmae as $idx => $rowcnae) {
            if ($rowcnae['principal'] == 'N') {
                $cnae = aspa($rowcnae['cnae']);
                $principal = aspa($rowcnae['principal']);
                $sql_i = ' insert into ' . db_pir_grc . 'grc_entidade_organizacao_cnae ';
                $sql_i .= ' (  ';
                $sql_i .= " idt_entidade_organizacao, ";
                $sql_i .= " cnae, ";
                $sql_i .= " principal ";
                $sql_i .= '  ) values ( ';
                $sql_i .= " $idt_entidade_organizacao, ";
                $sql_i .= " $cnae, ";
                $sql_i .= " $principal ";
                $sql_i .= ') ';
                $result = execsql($sql_i);
            }
        }

        if (is_array($grc_entidade_organizacao_tipo_informacao)) {
            foreach ($grc_entidade_organizacao_tipo_informacao as $rowtt) {
                $sqlx = 'insert into ' . db_pir_grc . 'grc_entidade_organizacao_tipo_informacao (idt, idt_tipo_informacao_e) values (';
                $sqlx .= null($idt_entidade_organizacao) . ', ' . null($rowtt['idt_tipo_informacao']) . ')';
                execsql($sqlx);
            }
        }

        $variavel['idt_entidade_organizacao'] = $idt_entidade_organizacao;
    } else {
        $variavel['idt_entidade_organizacao'] = 0;
    }

    if ($cnpj_w == "" && ($variavel['ie_prod_rural'] != '' || $variavel['sicab_codigo'] != '' || $variavel['dap'] != '' || $variavel['rmp'] != '' || $variavel['nirf'] != '')) {
        $vetUP = Array(
            'ie_prod_rural' => 'ie_prod_rural = null',
            'sicab_codigo' => 'sicab_codigo = null',
            'dap' => 'dap = null',
            'rmp' => 'rmp = null',
            'nirf' => 'nirf = null',
        );

        if ($variavel['ie_prod_rural'] != '') {
            unset($vetUP['ie_prod_rural']);
        }

        if ($variavel['sicab_codigo'] != '') {
            unset($vetUP['sicab_codigo']);
        }

        if ($variavel['dap'] != '') {
            unset($vetUP['dap']);
        }

        if ($variavel['rmp'] != '') {
            unset($vetUP['rmp']);
        }

        if ($variavel['nirf'] != '') {
            unset($vetUP['nirf']);
        }

        if (count($vetUP) > 0) {
            $sql = "update " . db_pir_grc . "grc_entidade_organizacao set " . implode(', ', $vetUP) . " where idt = " . null($variavel['idt_entidade_organizacao']);
            execsql($sql);
        }
    }

    if ($variavel['bancoTransaction'] != 'N') {
        commit();
    }

    $kokw = 1;
    return $kokw;
}

function BuscaCPF_GEC($idt_entidade_pessoa, &$variavel, $trata_erro = true) {
    global $vetSistemaUtiliza;

    if (path_fisico == 'path_fisico') {
        define('path_fisico', mb_strtolower($_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR . 'sebrae_grc' . DIRECTORY_SEPARATOR . 'admin');
    }

    $kokw = 0;
    $cpf = $variavel['cpf'];
    $cpf_w = $variavel['cpf'];

    if ($variavel['bancoTransaction'] != 'N') {
        beginTransaction();
    }

    $arqCopia = Array();
    $arqDel = Array();

    $cpfcnpj_w = $cpf;
    $vetEntidade = Array();
    $kretw = BuscaDadosEntidadePIR($cpfcnpj_w, 'P', $vetEntidade);


    $kretw = BuscaDadosEntidadeSIACBA($cpfcnpj_w, 'F', $vetEntidade);



    $idt_entidade_gec = '';

    set_time_limit(30);
    $nome_pessoa = "Cliente Novo";
    $vetExistencia = Array();
    $vetpir = $vetEntidade['PIR']['P'];
    $vetExistencia['PIR']['P']['existe_entidade'] = $vetpir['existe_entidade'];
    if ($vetpir['existe_entidade'] == 'S') {
        $qtd_entidade = $vetpir['qtd_entidade'];
        $idt_entidade = $vetpir['idt_entidade'];
        $excluido_ws = $vetpir['excluido_ws'];
        $dt_ult_alteracao = $vetpir['dt_ult_alteracao'];
        $idt_entidade_gec = $vetpir['idt_entidade'];
        $cpfcnpj = $vetpir['cpfcnpj'];
        $idt_cliente = $vetpir['idt_cliente'];
        $nome = $vetpir['nome'];
        $nome_pessoa = $vetpir['nome'];
        $telefone = $vetpir['telefone'];
        $celular = $vetpir['celular'];
        $email = $vetpir['email'];
        $cnpj = $vetpir['cnpj'];
        $nome_empresa = $vetpir['nome_empresa'];
        $codigo_siacweb = $vetpir['codigo_siacweb'];
        $receber_informacao_c = $vetpir['receber_informacao'];
        $grc_entidade_pessoa_tipo_informacao = $vetpir['gec_entidade_x_tipo_informacao'];


        // complemento dependendo do tipo
        $vetdadosproprios = $vetpir['dadosproprios'];
        //p($vetdadosproprios);


        $idt_complemento_pessoa_c = $vetdadosproprios['row']['idt'];
        $idt_origem_c = $vetdadosproprios['row']['idt_origem'];
        $idt_entidade_c = $vetdadosproprios['row']['idt_entidade'];
        $ativo_c = $vetdadosproprios['row']['ativo'];
        $data_nascimento_c = $vetdadosproprios['row']['data_nascimento'];
        $nome_pai_c = $vetdadosproprios['row']['nome_pai'];
        $nome_mae_c = $vetdadosproprios['row']['nome_mae'];
        $idt_ativeconpf = $vetdadosproprios['row']['idt_ativeconpf'];
        $siacweb_situacao = $vetpir['siacweb_situacao'];
        $pa_senha = $vetpir['pa_senha'];
        $pa_idfacebook = $vetpir['pa_idfacebook'];
        $idt_profissao_c = $vetdadosproprios['row']['idt_profissao'];
        $idt_estado_civil_c = $vetdadosproprios['row']['idt_estado_civil'];
        $idt_cor_pele_c = $vetdadosproprios['row']['idt_cor_pele'];
        $idt_religiao_c = $vetdadosproprios['row']['idt_religiao'];
        $idt_destreza_c = $vetdadosproprios['row']['idt_destreza'];
        $idt_sexo_c = $vetdadosproprios['row']['idt_sexo'];
        $necessidade_especial_c = $vetdadosproprios['row']['necessidade_especial'];
        $grc_entidade_pessoa_tipo_deficiencia = $vetdadosproprios['row']['gec_entidade_pessoa_tipo_deficiencia'];
        $idt_escolaridade_c = $vetdadosproprios['row']['idt_escolaridade'];
        $nome_tratamento_c = $vetdadosproprios['row']['nome_tratamento'];

        // Parte variável
        $vetenderecos = $vetpir['enderecos'];
        $vetprotocolos = $vetpir['protocolos'];
        $vetempresas = $vetpir['empresas'];
        $vetempresasPE = $vetempresas['PE'];
        $vetempresasEP = $vetempresas['EP'];
        ForEach ($vetenderecos as $idx => $Vettrab) {
            $vetendereco = $Vettrab['endereco'];
            $vetrow = $vetendereco['row'];
            //
            // 00 é o principal
            //
           //$vetrow['idt_entidade_endereco_tipo'];
            // 99 é endereco 
            if ($vetrow['gec_eneet_codigo'] != "00" and $vetrow['gec_eneet_codigo'] != "99") {
                continue;
            }
            $logradouro_p = $vetrow['logradouro'];
            $logradouro_numero_p = $vetrow['logradouro_numero'];
            $logradouro_complemento_p = $vetrow['logradouro_complemento'];
            $logradouro_bairro_p = $vetrow['logradouro_bairro'];
            $logradouro_municipio_p = $vetrow['logradouro_municipio'];
            $logradouro_estado_p = $vetrow['logradouro_estado'];
            $logradouro_pais_p = $vetrow['logradouro_pais'];
            $logradouro_cep_p = $vetrow['logradouro_cep'];

            $logradouro_codbairro_p = $vetrow['logradouro_codbairro'];
            $logradouro_codcid_p = $vetrow['logradouro_codcid'];
            $logradouro_codest_p = $vetrow['logradouro_codest'];
            $logradouro_codpais_p = $vetrow['logradouro_codpais'];

            $cep_p = $vetrow['cep'];

            $idt_pais_p = $vetrow['idt_pais'];
            $idt_estado_p = $vetrow['idt_estado'];
            $idt_cidade_p = $vetrow['idt_cidade'];

            $telefone_1_p = "";
            $telefone_2_p = "";
            $email_1_p = "";
            $email_2_p = "";
            $sms_1_p = "";
            $sms_2_p = "";

            $vetcomunicacaow = $vetendereco['comunicacao'];
            if (is_array($vetcomunicacaow)) {
                ForEach ($vetcomunicacaow as $idxw => $VetCom) {
                    //p($VetCom);
                    if ($VetCom['comunicacao']['origem'] == 'ATENDIMENTO RECADO') {
                        $telefone_3_p = $VetCom['comunicacao']['telefone_1'];
                    }
                    if ($VetCom['comunicacao']['origem'] == 'ATENDIMENTO PRINCIPAL') {
                        $telefone_1_p = $VetCom['comunicacao']['telefone_1'];
                        $telefone_2_p = $VetCom['comunicacao']['telefone_2'];
                        $email_1_p = $VetCom['comunicacao']['email_1'];
                        $email_2_p = $VetCom['comunicacao']['email_2'];
                        $sms_1_p = $VetCom['comunicacao']['sms_1'];
                        $sms_2_p = $VetCom['comunicacao']['sms_2'];
                    }
                }
            }
        }
    } else {
        $vetExistencia = Array();
        $vetpir = $vetEntidade['SIACBA']['F'];
        $vetExistencia['SIACBA']['F']['existe_entidade'] = $vetpir['existe_entidade'];
        if ($vetpir['existe_entidade'] == 'S') {
            $qtd_entidade = $vetpir['qtd_entidade'];
            $idt_entidade = $vetpir['idt_entidade'];
            $codigo_siacweb = $idt_entidade;
            $cpfcnpj = $vetpir['cpfcnpj'];
            $idt_cliente = $vetpir['idt_cliente'];
            $nome = $vetpir['nomerazaosocial'];
            $nome_pessoa = $vetpir['nomerazaosocial'];
            $dt_ult_alteracao = $vetpir['dataatu'];
            $telefone = $vetpir['telefone'];
            $celular = $vetpir['celular'];
            $email = $vetpir['email'];
            $cnpj = $vetpir['cnpj'];
            $nome_empresa = $vetpir['nome_empresa'];
            // complemento dependendo do tipo
            $vetdadosproprios = $vetpir['dadosproprios'];
            //p($vetdadosproprios);

            $vetDN = explode(' ', $vetdadosproprios['row']['data_nascimento']);

            $idt_complemento_pessoa_c = $vetdadosproprios['row']['idt'];
            $idt_origem_c = $vetdadosproprios['row']['idt_origem'];
            $idt_entidade_c = $vetdadosproprios['row']['idt_entidade'];
            $ativo_c = $vetdadosproprios['row']['ativo'];
            $data_nascimento_c = $vetDN[0];
            $nome_pai_c = $vetdadosproprios['row']['nome_pai'];
            $nome_mae_c = $vetdadosproprios['row']['nome_mae'];
            $idt_ativeconpf = $vetdadosproprios['row']['idt_ativeconpf'];
            $siacweb_situacao = $vetpir['siacweb_situacao'];
            $pa_senha = $vetpir['pa_senha'];
            $pa_idfacebook = $vetpir['pa_idfacebook'];
            $idt_profissao_c = $vetdadosproprios['row']['idt_profissao'];
            $idt_estado_civil_c = $vetdadosproprios['row']['idt_estado_civil'];
            $idt_cor_pele_c = $vetdadosproprios['row']['idt_cor_pele'];
            $idt_religiao_c = $vetdadosproprios['row']['idt_religiao'];
            $idt_destreza_c = $vetdadosproprios['row']['idt_destreza'];
            $idt_sexo_c = $vetdadosproprios['row']['idt_sexo'];
            $necessidade_especial_c = $vetdadosproprios['row']['necessidade_especial'];
            $idt_escolaridade_c = $vetdadosproprios['row']['idt_escolaridade'];
            $receber_informacao_c = $vetdadosproprios['row']['receber_informacao'];
            $nome_tratamento_c = $vetdadosproprios['row']['nome_tratamento'];

            $vetendereco = $vetpir['enderecos'];

            //p($vetendereco);

            $logradouro_p = $vetendereco['row']['logradouro'];
            $logradouro_numero_p = $vetendereco['row']['logradouro_numero'];
            $logradouro_complemento_p = $vetendereco['row']['logradouro_complemento'];
            $logradouro_bairro_p = $vetendereco['row']['logradouro_bairro'];
            $logradouro_municipio_p = $vetendereco['row']['logradouro_municipio'];
            $logradouro_estado_p = $vetendereco['row']['logradouro_estado'];
            $logradouro_pais_p = $vetendereco['row']['logradouro_pais'];
            $logradouro_cep_p = $vetendereco['row']['logradouro_cep'];

            $logradouro_codbairro_p = $vetendereco['row']['logradouro_codbairro'];
            $logradouro_codcid_p = $vetendereco['row']['logradouro_codcid'];
            $logradouro_codest_p = $vetendereco['row']['logradouro_codest'];
            $logradouro_codpais_p = $vetendereco['row']['logradouro_codpais'];

            $cep_p = $vetendereco['row']['cep'];

            $idt_pais_p = $vetendereco['row']['idt_pais'];
            $idt_estado_p = $vetendereco['row']['idt_estado'];
            $idt_cidade_p = $vetendereco['row']['idt_cidade'];
            //
            // Comunicacao
            //
            $vetcomunicacao = $vetpir['comunicacao']['row'];



            $telefone_1_p = $vetcomunicacao['telefone_1_p'];
            $telefone_2_p = $vetcomunicacao['telefone_2_p'];
            $telefone_3_p = $vetcomunicacao['telefone_3_p'];
            $email_1_p = $vetcomunicacao['email_1_p'];
            $sms_1_p = $vetcomunicacao['sms_1_p'];

            // o SMS = telefone celular
            $sms_1_p = $telefone_2_p;
            // Parte variável
            $vetenderecos = $vetpir['enderecos'];
            $vetprotocolos = $vetpir['protocolos'];
            $vetempresas = $vetpir['empresas'];
            $vetempresasPE = $vetempresas['PE'];
            $vetempresasEP = $vetempresas['EP'];

            ForEach ($vetenderecos as $idx => $Vettrab) {
                $vetendereco = $Vettrab['endereco'];
                $vetrow = $vetendereco['row'];
                //
                // 00 é o principal
                //
               //$vetrow['idt_entidade_endereco_tipo'];
                if ($vetrow['gec_eneet_codigo'] != "00" and $vetrow['gec_eneet_codigo'] != "99") {
                    continue;
                }
                $logradouro_p = $vetrow['logradouro'];
                $logradouro_numero_p = $vetrow['logradouro_numero'];
                $logradouro_complemento_p = $vetrow['logradouro_complemento'];
                $logradouro_bairro_p = $vetrow['logradouro_bairro'];
                $logradouro_municipio_p = $vetrow['logradouro_municipio'];
                $logradouro_estado_p = $vetrow['logradouro_estado'];
                $logradouro_pais_p = $vetrow['logradouro_pais'];

                $logradouro_codbairro_p = $vetrow['logradouro_codbairro'];
                $logradouro_codcid_p = $vetrow['logradouro_codcid'];
                $logradouro_codest_p = $vetrow['logradouro_codest'];
                $logradouro_codpais_p = $vetrow['logradouro_codpais'];

                $logradouro_cep_p = $vetrow['logradouro_cep'];
                $cep_p = $vetrow['cep'];

                $idt_pais_p = $vetrow['idt_pais'];
                $idt_estado_p = $vetrow['idt_estado'];
                $idt_cidade_p = $vetrow['idt_cidade'];

                $vetcomunicacaow = $vetendereco['comunicacao'];
                if (is_array($vetcomunicacaow)) {
                    ForEach ($vetcomunicacaow as $idxw => $VetCom) {
                        //        p($VetCom);
                        $telefone_1_p = $VetCom['comunicacao']['telefone_1'];
                        $telefone_2_p = $VetCom['comunicacao']['telefone_2'];
                        //$telefone_3_p = $VetCom['comunicacao']['telefone_3'];
                        $email_1_p = $VetCom['comunicacao']['email_1'];
                        $email_2_p = $VetCom['comunicacao']['email_2'];
                        $sms_1_p = $VetCom['comunicacao']['sms_1'];
                        $sms_2_p = $VetCom['comunicacao']['sms_2'];
                    }
                }
            }
        }
    }
    //
    //  Gravar Pessoa
    //
    $idt_pessoa = null($idt_entidade);
    $nome_mae = aspa($nome_mae_c);
    $idt_ativeconpf = null($idt_ativeconpf);

    $rowSIAC = situacaoParceiroSiacWeb('F', $variavel['cpf']);
    $siacweb_situacao = $rowSIAC['siacweb_situacao'];

    if ($siacweb_situacao == '') {
        $siacweb_situacao = 1;
    }

    $siacweb_situacao = null($siacweb_situacao);
    $pa_senha = aspa($pa_senha);
    $pa_idfacebook = aspa($pa_idfacebook);
    $nome_pai = aspa($nome_pai_c);
    $logradouro_cep = aspa($cep_p);
    $cep = aspa($cep_p);

    $logradouro_p = substr($logradouro_p, 0, 120);

    $logradouro_endereco = aspa($logradouro_p);
    $logradouro_numero = aspa($logradouro_numero_p);
    $logradouro_bairro = aspa($logradouro_bairro_p);
    $logradouro_complemento = aspa($logradouro_complemento_p);
    $logradouro_cidade = aspa($logradouro_municipio_p);
    $logradouro_estado = aspa($logradouro_estado_p);
    $logradouro_pais = aspa($logradouro_pais_p);

    $logradouro_codbairro_p = null($logradouro_codbairro_p);
    $logradouro_codcid_p = null($logradouro_codcid_p);
    $logradouro_codest_p = null($logradouro_codest_p);
    $logradouro_codpais_p = null($logradouro_codpais_p);

    $idt_pais = null(idt_pais_p);
    $idt_estado = null(idt_estado_p);
    $idt_cidade = null(idt_cidade_p);
    $telefone_residencial = aspa($telefone_1_p);
    $telefone_celular = aspa($telefone_2_p);
    $telefone_recado = aspa($telefone_3_p);

    /*
     * Removido por causa do suporte #606
      if ($telefone_3_p == "") {
      if ($telefone_celular != '') {
      $telefone_recado = $telefone_celular;
      } else {
      $telefone_recado = $telefone_residencial;
      }
      }
     * 
     */

    $email = aspa($email_1_p);
    $sms = aspa($sms_1_p);
    //
    $nome_tratamento = aspa($nome_tratamento_c);
    $idt_escolaridade = null($idt_escolaridade_c);
    $idt_sexo = null($idt_sexo_c);
    $data_nascimento = aspa($data_nascimento_c);
    $receber_informacao = aspa($receber_informacao_c);
    $necessidade_especial = aspa($necessidade_especial_c);
    //
    $idt_profissao = null($idt_profissao_c);
    $idt_estado_civil = null($idt_estado_civil_c);
    $idt_cor_pele = null($idt_cor_pele_c);
    $idt_religiao = null($idt_religiao_c);
    $idt_destreza = null($idt_destreza_c);
    //
    $cpf = aspa($cpf);
    $codigo_siacweb = aspa($codigo_siacweb);
    $nome = aspa($nome_pessoa);
    $tipo_relacao = aspa("L");
    $representa_empresa = aspa('N');
    if ($cnpj_w != "") {
        $representa_empresa = aspa('S');
    }

    if ($excluido_ws == '') {
        $excluido_ws = aspa('N');
    } else {
        $excluido_ws = aspa($excluido_ws);
    }

    $dt_ult_alteracao = aspa($dt_ult_alteracao);

    $sql = '';
    $sql .= ' select arquivo';
    $sql .= ' from ' . db_pir_grc . 'grc_entidade_pessoa_arquivo_interesse';
    $sql .= ' where idt_entidade_pessoa = ' . null($idt_entidade_pessoa);
    $rsArq = execsql($sql);

    foreach ($rsArq->data as $rowArq) {
        $arqDel[] = str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/obj_file/grc_entidade_pessoa_arquivo_interesse/' . $rowArq['arquivo']);
    }

    $sql1 = 'delete from ' . db_pir_grc . 'grc_entidade_pessoa where idt = ' . null($idt_entidade_pessoa);
    execsql($sql1);

    $sql1 = 'delete from ' . db_pir_grc . 'grc_entidade_pessoa where idt_entidade = ' . null($idt_entidade_gec);
    execsql($sql1);

    //
    //  incluir pessoa
    //
    
    $sql_i = ' insert into ' . db_pir_grc . 'grc_entidade_pessoa ';
    $sql_i .= ' (  ';
    $sql_i .= " idt_entidade, ";
    $sql_i .= " excluido_ws, ";
    $sql_i .= " dt_ult_alteracao, ";
    $sql_i .= " idt_pessoa, ";
    $sql_i .= " codigo_siacweb, ";
    $sql_i .= " cpf, ";
    $sql_i .= " nome, ";
    $sql_i .= " tipo_relacao, ";
    $sql_i .= " nome_mae, ";
    $sql_i .= " idt_ativeconpf, ";
    $sql_i .= " siacweb_situacao, ";
    $sql_i .= " pa_senha, ";
    $sql_i .= " pa_idfacebook, ";
    $sql_i .= " nome_pai, ";
    $sql_i .= " logradouro_cep, ";
    $sql_i .= " logradouro_endereco, ";
    $sql_i .= " logradouro_numero, ";
    $sql_i .= " logradouro_bairro, ";
    $sql_i .= " logradouro_complemento, ";
    $sql_i .= " logradouro_cidade, ";
    $sql_i .= " logradouro_estado, ";
    $sql_i .= " logradouro_pais, ";

    $sql_i .= " logradouro_codbairro, ";
    $sql_i .= " logradouro_codcid, ";
    $sql_i .= " logradouro_codest, ";
    $sql_i .= " logradouro_codpais, ";

    $sql_i .= " idt_pais, ";
    $sql_i .= " idt_estado, ";
    $sql_i .= " idt_cidade, ";
    $sql_i .= " telefone_residencial, ";
    $sql_i .= " telefone_celular, ";
    $sql_i .= " telefone_recado, ";

    $sql_i .= " email, ";
    $sql_i .= " sms, ";
    $sql_i .= " nome_tratamento, ";
    $sql_i .= " idt_escolaridade, ";

    $sql_i .= " idt_sexo, ";
    $sql_i .= " data_nascimento, ";
    $sql_i .= " receber_informacao, ";
    $sql_i .= " representa_empresa, ";
    $sql_i .= " necessidade_especial, ";

    $sql_i .= " idt_profissao, ";
    $sql_i .= " idt_estado_civil, ";
    $sql_i .= " idt_cor_pele, ";
    $sql_i .= " idt_religiao, ";
    $sql_i .= " idt_destreza ";
    $sql_i .= '  ) values ( ';
    $sql_i .= null($idt_entidade_gec) . ", ";
    $sql_i .= " $excluido_ws, ";
    $sql_i .= " $dt_ult_alteracao, ";
    $sql_i .= " $idt_pessoa, ";
    $sql_i .= " $codigo_siacweb, ";
    $sql_i .= " $cpf, ";
    $sql_i .= " $nome, ";
    $sql_i .= " $tipo_relacao, ";
    $sql_i .= " $nome_mae, ";
    $sql_i .= " $idt_ativeconpf, ";
    $sql_i .= " $siacweb_situacao, ";
    $sql_i .= " $pa_senha, ";
    $sql_i .= " $pa_idfacebook, ";
    $sql_i .= " $nome_pai, ";
    $sql_i .= " $logradouro_cep, ";
    $sql_i .= " $logradouro_endereco, ";
    $sql_i .= " $logradouro_numero, ";
    $sql_i .= " $logradouro_bairro, ";
    $sql_i .= " $logradouro_complemento, ";
    $sql_i .= " $logradouro_cidade, ";
    $sql_i .= " $logradouro_estado, ";
    $sql_i .= " $logradouro_pais, ";

    $sql_i .= " $logradouro_codbairro_p, ";
    $sql_i .= " $logradouro_codcid_p, ";
    $sql_i .= " $logradouro_codest_p, ";
    $sql_i .= " $logradouro_codpais_p, ";

    $sql_i .= " $idt_pais, ";
    $sql_i .= " $idt_estado, ";
    $sql_i .= " $idt_cidade, ";
    $sql_i .= " $telefone_residencial, ";
    $sql_i .= " $telefone_celular, ";
    $sql_i .= " $telefone_recado, ";

    $sql_i .= " $email, ";
    $sql_i .= " $sms, ";
    $sql_i .= " $nome_tratamento, ";
    $sql_i .= " $idt_escolaridade, ";

    $sql_i .= " $idt_sexo, ";
    $sql_i .= " $data_nascimento, ";
    $sql_i .= " $receber_informacao, ";
    $sql_i .= " $representa_empresa, ";
    $sql_i .= " $necessidade_especial, ";
    $sql_i .= " $idt_profissao, ";
    $sql_i .= " $idt_estado_civil, ";
    $sql_i .= " $idt_cor_pele, ";
    $sql_i .= " $idt_religiao, ";
    $sql_i .= " $idt_destreza ";
    $sql_i .= ') ';
    $result = execsql($sql_i);
    $idt_entidade_pessoa = lastInsertId();
    $variavel['idt_entidade_pessoa'] = $idt_entidade_pessoa;

    if (is_array($grc_entidade_pessoa_tipo_informacao)) {
        foreach ($grc_entidade_pessoa_tipo_informacao as $rowtt) {
            $sqlx = 'insert into ' . db_pir_grc . 'grc_entidade_pessoa_tipo_informacao (idt, idt_tipo_informacao) values (';
            $sqlx .= null($idt_entidade_pessoa) . ', ' . null($rowtt['idt_tipo_informacao']) . ')';
            execsql($sqlx);
        }
    }

    if (is_array($grc_entidade_pessoa_tipo_deficiencia)) {
        foreach ($grc_entidade_pessoa_tipo_deficiencia as $rowtt) {
            $sqlx = 'insert into ' . db_pir_grc . 'grc_entidade_pessoa_tipo_deficiencia (idt, idt_tipo_deficiencia) values (';
            $sqlx .= null($idt_entidade_pessoa) . ', ' . null($rowtt['idt_tipo_deficiencia']) . ')';
            execsql($sqlx);
        }
    }

    $idtentidade_relacionada = $idt_pessoa;
    if ($idtentidade_relacionada > 0) {
        //
        // incluir temas de interesee
        //
        $sql2 = 'select ';
        $sql2 .= '  gec_eti.*   ';
        $sql2 .= '  from ' . db_pir_gec . 'gec_entidade_tema_interesse gec_eti ';
        $sql2 .= ' where  gec_eti.idt_entidade   = ' . null($idtentidade_relacionada);
        $rs = execsql($sql2);
        ForEach ($rs->data as $row2) {
            $idt = $row2['idt'];
            $idt_tema = null($row2['idt_tema']);
            $idt_subtema = null($row2['idt_subtema']);
            $idt_responsavel = IdUsuarioPIR($row2['idt_responsavel'], db_pir_gec, db_pir_grc);
            $idt_responsavel = null($idt_responsavel);
            //
            $observacao = aspa($row2['observacao']);

            $sql_i = ' insert into ' . db_pir_grc . 'grc_entidade_pessoa_tema_interesse ';
            $sql_i .= ' (  ';
            $sql_i .= " idt_entidade_pessoa, ";
            $sql_i .= " idt_responsavel, ";
            $sql_i .= " idt_tema, ";
            $sql_i .= " idt_subtema, ";
            $sql_i .= " observacao ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " $idt_entidade_pessoa, ";
            $sql_i .= " $idt_responsavel, ";
            $sql_i .= " $idt_tema, ";
            $sql_i .= " $idt_subtema, ";
            $sql_i .= " $observacao ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }

        $sql2 = 'select ';
        $sql2 .= '  gec_epi.*   ';
        $sql2 .= '  from ' . db_pir_gec . 'gec_entidade_produto_interesse gec_epi ';
        $sql2 .= ' where  gec_epi.idt_entidade   = ' . null($idtentidade_relacionada);
        $rs = execsql($sql2);
        ForEach ($rs->data as $row2) {
            $idt = $row2['idt'];
            $idt_produto = null($row2['idt_produto']);
            $idt_responsavel = IdUsuarioPIR($row2['idt_responsavel'], db_pir_gec, db_pir_grc);
            $idt_responsavel = null($idt_responsavel);
            //
            $observacao = aspa($row2['observacao']);

            $sql_i = ' insert into ' . db_pir_grc . 'grc_entidade_pessoa_produto_interesse ';
            $sql_i .= ' (  ';
            $sql_i .= " idt_entidade_pessoa, ";
            $sql_i .= " idt_responsavel, ";
            $sql_i .= " idt_produto, ";
            $sql_i .= " observacao ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " $idt_entidade_pessoa, ";
            $sql_i .= " $idt_responsavel, ";
            $sql_i .= " $idt_produto, ";
            $sql_i .= " $observacao ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }

        $sql2 = 'select ';
        $sql2 .= '  gec_eai.*   ';
        $sql2 .= '  from ' . db_pir_gec . 'gec_entidade_arquivo_interesse gec_eai ';
        $sql2 .= ' where  gec_eai.idt_entidade   = ' . null($idtentidade_relacionada);
        $rs = execsql($sql2);
        ForEach ($rs->data as $row2) {
            $vetPrefixoArq = explode('_', $row2['arquivo']);
            $PrefixoArq = '';
            $PrefixoArq .= $vetPrefixoArq[0] . '_';
            $PrefixoArq .= $vetPrefixoArq[1] . '_';
            $PrefixoArq .= $vetPrefixoArq[2] . '_';
            $arq_novo = GerarStr() . '_arquivo_' . substr(time(), -3) . '_' . substr($row2['arquivo'], strlen($PrefixoArq));

            $arqCopia[] = Array(
                'de' => str_replace('/', DIRECTORY_SEPARATOR, $vetSistemaUtiliza['GEC']['path'] . 'admin/obj_file/gec_entidade_arquivo_interesse/' . $row2['arquivo']),
                'para' => str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/obj_file/grc_entidade_pessoa_arquivo_interesse/' . $arq_novo),
            );

            $idt = $row2['idt'];

            // Pegar o do GRC
            $idt_responsavel = IdUsuarioPIR($row2['idt_responsavel'], db_pir_gec, db_pir_grc);
            $idt_responsavel = null($idt_responsavel);

            $idt_gec_entidade_pessoa_arquivo_interesse = null($row2['idt']);

            $titulo = aspa($row2['titulo']);
            $arquivo = aspa($arq_novo);

            $sql_i = ' insert into ' . db_pir_grc . 'grc_entidade_pessoa_arquivo_interesse ';
            $sql_i .= ' (  ';
            $sql_i .= " idt_entidade_pessoa, ";
            $sql_i .= " idt_gec_entidade_pessoa_arquivo_interesse, ";
            $sql_i .= " idt_responsavel, ";
            $sql_i .= " titulo, ";
            $sql_i .= " arquivo ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " $idt_entidade_pessoa, ";
            $sql_i .= " $idt_gec_entidade_pessoa_arquivo_interesse, ";
            $sql_i .= " $idt_responsavel, ";
            $sql_i .= " $titulo, ";
            $sql_i .= " $arquivo ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }
    }

    if ($variavel['bancoTransaction'] != 'N') {
        commit();
    }

    if (is_array($arqDel)) {
        foreach ($arqDel as $arq) {
            if (is_file($arq)) {
                unlink($arq);
            }
        }
    }

    if (is_array($arqCopia)) {
        foreach ($arqCopia as $arq) {
            if (is_file($arq['de'])) {
                copy($arq['de'], $arq['para']);
            }
        }
    }

    $kokw = 1;
    return $kokw;
}

////////////////// 
//
// Função de Refresh na tela do Painel - Modelo sebrae
//
function RefreshPainelControle_pir(&$variavel) {
    global $con;
    $con_monitora_trab = $con;
    $vet_painel = Array();

    $vetMes = Array(
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
    $vetLogAcao = Array(
        'L' => 'Login',
        'S' => 'Logout',
        'V' => 'Aviso',
        'A' => 'Alterar',
        'I' => 'Incluir',
        'E' => 'Excluir',
        'R' => 'Rotina',
        'P' => 'Cadastro Personalizado',
    );

    // Bancos do sistema PIR
    $vetBancos = Array();
    $vetBancos['PIR'] = 'db_pir';
    $vetBancos['GEC'] = 'db_pir_gec';
    $vetBancos['GRC'] = 'db_pir_grc';
    $vetBancos['GFI'] = 'db_pir_gfi';
    $vetBancos['PFO'] = 'db_sebrae_pfo';
    $vetBancosDesc = Array();
    $vetBancosDesc['PIR'] = 'Plataforma Integrada de Relacionamento';
    $vetBancosDesc['GEC'] = 'Gestão de Credenciados';
    $vetBancosDesc['GRC'] = 'CRM - Relacionamento com o Cliente';
    $vetBancosDesc['GFI'] = 'Gestão Financeira';
    $vetBancosDesc['PFO'] = 'Portal do Fornecedor';


    $corpainel = "#2F66B8";
    //
    // $corfundopainel="#ECF0F1";
    //
    $corfundopainel = "#FFFFFF";

    $kokw = 0;
    $html = "";
    $descricao_ponto_atendimento = $sca_os_descricao;
    $descricao_painel = $grc_ap_descricao;
    $municipio = "Salvador";
    $html .= "<div id='topo_painel_p' style='width:97%;' > ";

    $html .= '<table border="0" cellpadding="0" width="100%" cellspacing="0" class="">';
    $html .= '    <tr> ';
    $html .= '<td  style="width:10%">';
    $pathw = 'imagens/logo_painel.png';
    $html .= '<img style="" src="' . $pathw . '"   border="0" />';
    $html .= '</td>';
    $html .= "<td class='titulo_painel_p' style=''>";
    $vetMsg = Array();
    $vetMsg[1] = "PAINEL DE CONTROLE - PIR";
    $ordem_msg = 1;
    $_SESSION[CS]['g_ordem_msg_painel'] = $ordem_msg;
    $mensagem_topo = $vetMsg[$ordem_msg];
    $html .= $mensagem_topo;
    $html .= '</td>';
    $html .= "<td  style='width:35%' >";

    $html .= "<div id='ele_topo_p'>$descricao_ponto_atendimento</div> ";
    $html .= '<div id="data_m_p">';
    $html .= date('d/m/Y');
    $html .= '</div>';
    $html .= '<div id="hora_m_p">';
    // $html .= date('H:i:s');
    $html .= date('H:i');
    $html .= '</div>';

    $html .= '</td>';
    $html .= '    </tr> ';
    $html .= ' </table> ';



    $numpainel = $variavel['numpainel'];

//////////////
// p($variavel);

    if ($numpainel == 1) {
        $html .= "<style> ";
        $html .= ".sistema_ativo_cab { ";
        $html .= " background:#F1F1F1;  ";
        $html .= " border-bottom:1px solid #C0C0C0;  ";
        $html .= " font-family : Calibri,  Arial, Helvetica, sans-serif; ";
        $html .= " font-size: 12px; ";
        $html .= " font-style: normal; ";
        $html .= "} ";

        $html .= ".sistema_ativo_lin { ";
        $html .= " background:#FFFFFF;  ";
        $html .= " border-bottom:1px solid #F1F1F1;  ";
        $html .= " font-family : Calibri, Arial, Helvetica, sans-serif; ";
        $html .= " font-size: 12px; ";
        $html .= " font-style: normal; ";


        $html .= "} ";


        $html .= "</style> ";


        $html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        $html .= "<tr  style='' >  ";
        $html .= "<td class='titulo_sistema' >Bancos para Utilização Sistemas do PIR</td>";
        $html .= "</tr>";
        $html .= "</table>";
        ////////////
        $html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        $html .= "<tr  style='' >  ";
        $html .= "<td class='sistema_ativo_cab' style='width:20%; text-align:center;'>Status</td>";
        $html .= "<td class='sistema_ativo_cab' style='width:10%; text-align:center;'>Sigla</td>";
        $html .= "<td class='sistema_ativo_cab' style='width:20%;'>Banco</td>";
        $html .= "<td class='sistema_ativo_cab' style='width:15%;'>Descrição</td>";


        $html .= "</tr>";
        $vetCon = Array();
        ForEach ($vetBancos as $sigla => $Banco) {
            $descricao = $vetBancosDesc[$sigla];

            $hint = "";
            $conexaoativada = "ATIVO";
            $cor = " background:#0000FF; color:#FFFFFF; font-weight: bold;";
            if (!CONEXAO_existe($Banco, $con_sigla)) {
                $conexaoativada = "INATIVO ";
                $cor = " background:#FF0000; color:#FFFFFF; font-weight: bold;";
            }
            $vetCon[$sigla] = $con_sigla;
            $html .= "<tr class=''>";
            $html .= "<td class='sistema_ativo_lin' style=' {$cor} text-align:center;' title='{$hint}' >" . $conexaoativada . "</td>";
            $html .= "<td class='sistema_ativo_lin' style='text-align:center;' >" . $sigla . "</td>";
            $html .= "<td class='sistema_ativo_lin'>" . $Banco . "</td>";
            $html .= "<td class='sistema_ativo_lin'>" . $descricao . "</td>";

            $html .= "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";


        $html .= "<br />";




        $html .= "<style> ";
        $html .= ".sistema_ativo_cab { ";
        $html .= " background:#F1F1F1;  ";
        $html .= " border-bottom:1px solid #C0C0C0;  ";
        $html .= " font-family : Calibri,  Arial, Helvetica, sans-serif; ";
        $html .= " font-size: 12px; ";
        $html .= " font-style: normal; ";
        $html .= "} ";

        $html .= ".sistema_ativo_lin { ";
        $html .= " background:#FFFFFF;  ";
        $html .= " border-bottom:1px solid #F1F1F1;  ";
        $html .= " font-family : Calibri, Arial, Helvetica, sans-serif; ";
        $html .= " font-size: 12px; ";
        $html .= " font-style: normal; ";



        $html .= "} ";


        $html .= "</style> ";



        $html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        $html .= "<tr  style='' >  ";
        $html .= "<td class='titulo_sistema' >LINKs para Sistemas do PIR</td>";
        $html .= "</tr>";
        $html .= "</table>";
        ////////////

        $con = $con_monitora_trab;

        $sql = "select sca_si.*, chama from db_pir.sca_sistema sca_si ";
        $sql .= " left join db_pir.empreendimento emp on emp.idt_sistema = sca_si.idt ";
        $sql .= " where  monitora = " . aspa('S');
        $sql .= "   and  (producao = " . aspa('S') . " or producao is null )";
        $sql .= " order by pri_monitora, sigla ";
        $rs = execsql($sql);
        $html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        $html .= "<tr  style='' >  ";
        $html .= "<td class='sistema_ativo_cab' style='width:20%; text-align:center;'>Status</td>";
        $html .= "<td class='sistema_ativo_cab' style='width:10%; text-align:center;'>Sigla</td>";
        $html .= "<td class='sistema_ativo_cab' style='width:15%;'>Descrição</td>";
        $html .= "<td class='sistema_ativo_cab' style='width:20%;'>Detalhe</td>";

        $html .= "</tr>";
        ForEach ($rs->data as $row) {

            //

            $sigla = $row['sigla'];

            $con = $vetCon[$sigla];

            if ($con == "") {
                continue;
            }

            $data_dia = date('d/m/Y');
            $qtd_interacao = 0;
            $sqlw = "select count(id_log_sistema) as qtd_interacao from plu_log_sistema ";
            $sqlw .= " where  substring(dtc_registro,1,10) = " . aspa(trata_data($data_dia));
            $rsw = execsql($sqlw);
            ForEach ($rsw->data as $roww) {
                $qtd_interacao = $roww['qtd_interacao'];
            }
            $qtd_login = 0;
            $sqlw = "select count(id_log_sistema) as qtd_login from plu_log_sistema ";
            $sqlw .= " where  substring(dtc_registro,1,10) = " . aspa(trata_data($data_dia));
            $sqlw .= "   and sts_acao = " . aspa('L');
            $rsw = execsql($sqlw);
            ForEach ($rsw->data as $roww) {
                $qtd_login = $roww['qtd_login'];
            }
            $HorasDia = date('H');
            $HorasDia = $HorasDia + 1;
            $qtd_interacaoh = ($qtd_interacao / $HorasDia);
            /*
              $html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
              $html .= "<tr  style='' >  ";
              $html .= "<td class='usuario_ativo_cab_e' style=''>Qtd. Login no Dia</td>";
              $html .= "<td class='usuario_ativo_cab_e' style=''>Qtd Interações no Dia</td>";
              $html .= "<td class='usuario_ativo_cab_e' style=''>Qtd Interações no Dia/H</td>";
              $html .= "</tr>";
              $html .= "<tr class=''>";
              $qtd_loginw = format_decimal($qtd_login, 0);
              $qtd_interacaow = format_decimal($qtd_interacao, 0);
              $html .= "<td class='usuario_ativo_lin_e'>{$qtd_loginw}</td>";
              $html .= "<td class='usuario_ativo_lin_e'>{$qtd_interacaow}</td>";
              $HorasDia = date('H');
              $HorasDia = $HorasDia + 1;
              $qtd_interacaoh = ($qtd_interacao / $HorasDia);
              $qtd_interacaohw = format_decimal($qtd_interacaoh, 2);
              $html .= "<td class='usuario_ativo_lin_e'>{$qtd_interacaohw}</td>";

              $html .= "</tr>";
              $html .= "</table>";
             */


            //


            $url = $row['chama'];
            $hint = $url;
            $linksistemadesativado = "ATIVO";
            $cor = " background:#0000FF; color:#FFFFFF; font-weight: bold;";
            if (!URL_existe($url)) {
                $linksistemadesativado = "INATIVO ";
                $cor = " background:#FF0000; color:#FFFFFF; font-weight: bold;";
            }

            $html .= "<tr class=''>";
            $html .= "<td class='sistema_ativo_lin' style=' {$cor} text-align:center;' title='{$hint}' >" . $linksistemadesativado . "</td>";
            $html .= "<td class='sistema_ativo_lin' style='text-align:center;' >RT={$qtd_interacao}" . $row['sigla'] . "</td>";
            $html .= "<td class='sistema_ativo_lin'>RT={$qtd_login}" . $row['descricao'] . "</td>";
            $html .= "<td class='sistema_ativo_lin'>RT={$qtd_interacaoh}" . $row['detalhe'] . "</td>";

            $html .= "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";
    }
    if ($numpainel == 2) {
        $html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        $html .= "<tr  style='' >  ";
        $html .= "<td class='titulo_sistema' >CRM</td>";
        $html .= "</tr>";
        $html .= "</table>";

        //////////// GUYteste




        $data_dia = date('d/m/Y');


        $qtd_interacao = 0;
        $sql = "select count(id_log_sistema) as qtd_interacao from plu_log_sistema ";
        $sql .= " where  substring(dtc_registro,1,10) = " . aspa(trata_data($data_dia));
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $qtd_interacao = $row['qtd_interacao'];
        }
        $qtd_login = 0;
        $sql = "select count(id_log_sistema) as qtd_login from plu_log_sistema ";
        $sql .= " where  substring(dtc_registro,1,10) = " . aspa(trata_data($data_dia));
        $sql .= "   and sts_acao = " . aspa('L');
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $qtd_login = $row['qtd_login'];
        }
        $html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        $html .= "<tr  style='' >  ";
        $html .= "<td class='usuario_ativo_cab_e' style=''>Qtd. Login no Dia</td>";
        $html .= "<td class='usuario_ativo_cab_e' style=''>Qtd Interações no Dia</td>";
        $html .= "<td class='usuario_ativo_cab_e' style=''>Qtd Interações no Dia/H</td>";
        $html .= "</tr>";
        $html .= "<tr class=''>";
        $qtd_loginw = format_decimal($qtd_login, 0);
        $qtd_interacaow = format_decimal($qtd_interacao, 0);
        $html .= "<td class='usuario_ativo_lin_e'>{$qtd_loginw}</td>";
        $html .= "<td class='usuario_ativo_lin_e'>{$qtd_interacaow}</td>";
        $HorasDia = date('H');
        $HorasDia = $HorasDia + 1;
        $qtd_interacaoh = ($qtd_interacao / $HorasDia);
        $qtd_interacaohw = format_decimal($qtd_interacaoh, 2);
        $html .= "<td class='usuario_ativo_lin_e'>{$qtd_interacaohw}</td>";

        $html .= "</tr>";
        $html .= "</table>";




        $sql = "select * from plu_log_sistema ";
        $sql .= " where  substring(dtc_registro,1,10) = " . aspa(trata_data($data_dia));
        $sql .= " order by dtc_registro desc, id_log_sistema desc limit 15 ";
        $rs = execsql($sql);
        $html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        $html .= "<tr  style='' >  ";
        $html .= "<td class='usuario_ativo_cab' style='width:10%;'>Registro<br />Data e Hora</td>";
        $html .= "<td class='usuario_ativo_cab' style='width:15%;'>Login</td>";
        $html .= "<td class='usuario_ativo_cab' style='width:20%;'>Nome do Usuário</td>";
        $html .= "<td class='usuario_ativo_cab' style='width:5%;'>IP</td>";
        $html .= "<td class='usuario_ativo_cab' style='width:15%;'>Formulário</td>";
        $html .= "<td class='usuario_ativo_cab' style='width:5%;'>Ação</td>";
        //$html .= "<td class='usuario_ativo_cab'>Nº PK</td>";
        $html .= "<td class='usuario_ativo_cab' style=''>Descrição</td>";
        $html .= "</tr>";
        ForEach ($rs->data as $row) {
            $html .= "<tr class=''>";
            $html .= "<td class='usuario_ativo_lin'>" . trata_data($row['dtc_registro'], true) . "</td>";
            $html .= "<td class='usuario_ativo_lin'>" . $row['login'] . "</td>";
            $html .= "<td class='usuario_ativo_lin'>" . $row['nom_usuario'] . "</td>";
            $html .= "<td class='usuario_ativo_lin'>" . $row['ip_usuario'] . "</td>";
            $html .= "<td class='usuario_ativo_lin'>" . $row['nom_tela'] . "</td>";
            $html .= "<td class='usuario_ativo_lin'>";
            $html .= $vetLogAcao[$row['sts_acao']];
            $html .= "</td>";
            //$html .= "<td class='usuario_ativo_lin'>".$row['des_pk']."</td>";
            $html .= "<td class='usuario_ativo_lin' title='" . $vetLogSisDes[$row['nom_tabela']] . "'>" . $row['des_registro'] . "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";
    }



    $variavel['html'] = $html;
}

function InserirSuspanesaoNacionais($idt_ponto_atendimento) {
    $difanos = 2;
    $anocw = "2016";
    $sabado = "N";
    $domingo = "N";
    for ($c = 0; $c < $difanos; $c++) {

        $feriados_ano = Array();
        $vet = Feriados($anocw, $sabado, $domingo, $feriados_ano);

        ForEach ($feriados_ano as $anovw => $meses) {
            $anow = $anovw;
            ForEach ($meses as $mes => $dias) {
                $mesw = $mes;
                ForEach ($dias as $dia => $tpdias) {
                    if ($tpdias['tpdi'] == 'F') {
                        $dataw = $dia . '/' . $mesw . '/' . $anow;
                        // $vet_feriado[$dataw]=$dataw;
                        // inserir
                        $dataj = aspa(trata_data($dataw));
                        $idt_parametro = 1;
                        $data = $dataj;
                        $idt_ponto_atendimentow = $idt_ponto_atendimento;
                        $observacao = aspa($tpdias['tpfe'] . ' - ' . $tpdias['desc']);
                        $tipo = aspa('N');
//
                        $sql = 'select ';
                        $sql .= '   grc_aps.idt  ';
                        $sql .= ' from grc_agenda_parametro_suspensao grc_aps ';
                        $sql .= " where idt_parametro = 1 ";
                        $sql .= '   and idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
                        $sql .= '   and data                  = ' . $data;
                        $rst = execsql($sql);
                        if ($rst->rows == 0) {

                            $sql_i = ' insert into grc_agenda_parametro_suspensao ';
                            $sql_i .= ' (  ';
                            $sql_i .= " idt_parametro, ";
                            $sql_i .= " data, ";
                            $sql_i .= " idt_ponto_atendimento, ";
                            $sql_i .= " observacao, ";
                            $sql_i .= " tipo ";
                            $sql_i .= '  ) values ( ';
                            $sql_i .= " $idt_parametro, ";
                            $sql_i .= " $data, ";
                            $sql_i .= " $idt_ponto_atendimentow, ";
                            $sql_i .= " $observacao, ";
                            $sql_i .= " $tipo ";
                            $sql_i .= ') ';
                            $result = execsql($sql_i);
                        }
                    }
                }
            }
        }

        $anocw = $anocw + 1;
    }

    // p($vet_feriado);
}

function GerarTodosPA($idt_grc_agenda_parametro_suspensao, $dataw, $observacaow) {
    $sql = 'select ';
    $sql .= '   idt, descricao  ';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao sac_os ';
    $sql .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
    $sql .= ' order by classificacao ';
    $rs = execsql($sql);
    if ($rs->rows > 0) {
        foreach ($rs->data as $row) {
            $idt_ponto_atendimento = $row['idt'];
            $dataj = aspa(trata_data($dataw));
            $idt_parametro = 1;
            $data = $dataj;
            $idt_ponto_atendimentow = $idt_ponto_atendimento;
            $observacao = aspa($observacaow);
            $tipo = aspa('S');
            //
            $sql = 'select ';
            $sql .= '   grc_aps.idt  ';
            $sql .= ' from grc_agenda_parametro_suspensao grc_aps ';
            $sql .= " where idt_parametro = 1 ";
            $sql .= '   and idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
            $sql .= '   and data                  = ' . $data;
            $rst = execsql($sql);
            if ($rst->rows == 0) {

                $sql_i = ' insert into grc_agenda_parametro_suspensao ';
                $sql_i .= ' (  ';
                $sql_i .= " idt_parametro, ";
                $sql_i .= " data, ";
                $sql_i .= " idt_ponto_atendimento, ";
                $sql_i .= " observacao, ";
                $sql_i .= " tipo ";
                $sql_i .= '  ) values ( ';
                $sql_i .= " $idt_parametro, ";
                $sql_i .= " $data, ";
                $sql_i .= " $idt_ponto_atendimentow, ";
                $sql_i .= " $observacao, ";
                $sql_i .= " $tipo ";
                $sql_i .= ') ';
                $result = execsql($sql_i);
            } else {
                
            }
        }
    }
}

function GerarTodosPAALT($idt_grc_agenda_parametro_suspensao, $dataw, $observacaow) {
    $sql = 'select ';
    $sql .= '   idt, descricao  ';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao sac_os ';
    $sql .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
    $sql .= ' order by classificacao ';
    $rs = execsql($sql);
    if ($rs->rows > 0) {
        foreach ($rs->data as $row) {
            $idt_ponto_atendimento = $row['idt'];
            $dataj = aspa(trata_data($dataw));
            $idt_parametro = 1;
            $data = $dataj;
            $idt_ponto_atendimentow = $idt_ponto_atendimento;
            $observacao = aspa($observacaow);
            $tipo = aspa('S');
            //
            $sql = 'select ';
            $sql .= '   grc_aps.idt  ';
            $sql .= ' from grc_agenda_parametro_suspensao grc_aps ';
            $sql .= " where idt_parametro = 1 ";
            $sql .= '   and idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
            $sql .= '   and data                  = ' . $data;
            $rst = execsql($sql);
            if ($rst->rows > 0) {
                foreach ($rst->data as $rowt) {
                    $idt_suspensao = $rowt['idt'];
                    // alteraguy
                    $sql_a = " update grc_agenda_parametro_suspensao set ";
                    $sql_a .= " observacao = $observacao ";
                    $sql_a .= " where idt = " . null($idt_suspensao);
                    $result = execsql($sql_a);
                }
            }
        }
    }
}

function ExcluirTodosPA($idt_grc_agenda_parametro_suspensao, $dataw, $observacaow) {
    $sql = 'select ';
    $sql .= '   idt, descricao  ';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao sac_os ';
    $sql .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
    $sql .= ' order by classificacao ';
    $rstpa = execsql($sql);
    //p($sql);
    //echo " to aqui <br>";
    if ($rstpa->rows > 0) {
        // echo " to fora <br>";
        foreach ($rstpa->data as $rowpa) {
            $idt_ponto_atendimento = $rowpa['idt'];
            //echo " --- $idt_ponto_atendimento<br /> ";
            $dataj = aspa(trata_data($dataw));
            $idt_parametro = 1;
            $data = $dataj;
            $idt_ponto_atendimentow = $idt_ponto_atendimento;
            $observacao = aspa($observacaow);
            $tipo = aspa('S');
            //
            $sql = 'select ';
            $sql .= '   grc_aps.idt  ';
            $sql .= ' from grc_agenda_parametro_suspensao grc_aps ';
            $sql .= " where idt_parametro = 1 ";
            $sql .= '   and idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
            $sql .= '   and data                  = ' . $data;
            $rst = execsql($sql);

            //echo " --- $idt_ponto_atendimento<br /> ";
            //p($sql);
            if ($rst->rows > 0) {
                foreach ($rst->data as $row) {
                    $idt_agenda_parametro_suspensao = $row['idt'];
                    //echo " VVVV--- $idt_agenda_parametro_suspensao<br /> ";
                    $sql = ' delete from ';
                    $sql .= ' grc_agenda_parametro_suspensao ';
                    $sql .= ' where idt = ' . null($idt_agenda_parametro_suspensao);
                    $rs = execsql($sql);
                }
            }
        }
    }
}

// funções de Monitoramento de Controle
//
// Testa se uma url esta ativa
//
function URL_existe($url) {

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $status = array();
    preg_match('/HTTP\/.* ([0-9]+) .*/', curl_exec($ch), $status);

    return ($status[1] == 200);
}

function CONEXAO_existe($Banco, &$con_sigla) {
    $status = false;
    //Sebrae Homologação
    $tipodb = 'mysql';
    $host = '10.6.14.40';
    $bd_user = 'lupe'; // Login do Banco
    $password = 'my$ql$sebraeH'; // Senha de acesso ao Banco
    $host = $tipodb . ':host=' . $host . ';dbname=' . $Banco . ';port=3306'; // Endereço do Banco de Dados
    //echo "------------ ".$host;
    //Require_Once('definicao_lib.php');


    try {
        $con_monitora = new_pdo($host, $bd_user, $password, $tipodb, false);
        $status = true;
    } catch (Exception $e) {
        $status = false;
    }
    $con_sigla = $con_monitora;


    return $status;
}

function AprovarDevolutivaDistancia(&$vet) {
    $idt_atendimento = $vet['idt_atendimento'];
    $sql = 'select ';
    $sql .= ' grc_a.idt,  grc_a.idt_servico, grc_a.protocolo, plu_usu.nome_completo, grc_ap.nome, grc_ap.email, grc_ap.sms ';
    $sql .= ' from grc_atendimento grc_a ';
    $sql .= ' inner join plu_usuario             plu_usu on plu_usu.id_usuario = grc_a.idt_consultor';
    $sql .= ' left  join grc_atendimento_pessoa  grc_ap  on grc_ap.idt_atendimento    = grc_a.idt';
    //$sql .= "                                              and grc_ap.representa_empresa = 'S' ";
    $sql .= " where grc_a.idt = " . null($idt_atendimento);
    $rs = execsql($sql);
    $status = $sql;
    if ($rs->rows > 0) {
        beginTransaction();
        set_time_limit(60);

        foreach ($rs->data as $row) {
            $protocolo = $row['protocolo'];
        }
        $completou = 0;

        $ret = GeraArquivoDevolutivaDistancia($idt_atendimento, $row, $vet);
        if ($ret == 1) {
            $status = 1;
            $ret = EnviaEmailDevolutivaDistancia($idt_atendimento, $row, $vet);
            if ($ret == 1) {
                $status = 2;
                /*
                  // Update em pendencias para desativar
                  $sql = "update grc_atendimento_pendencia ";
                  $sql .= " set ";
                  $sql .= " ativo  = " . aspa('N') . "  ";
                  $sql .= " where protocolo = " . aspa($protocolo);
                  execsql($sql);
                 */
                $completou = 1;
            }
        }
        if ($completou == 0) {
            $vet['erro'] = rawurlencode("Processo de APROVAÇÃO NÃO pode ser Completado STATUS = {$status} ");
        } else {
            //  Update em pendencias para desativar
            $idt_usuario = $_SESSION[CS]['g_id_usuario'];
            $datadia = date('d/m/Y H:i:s');
            $data = aspa(trata_data($datadia));

            $sql = "update grc_atendimento_pendencia ";
            $sql .= " set ";
            $sql .= " ativo  = " . aspa('N') . "  ";
            $sql .= " where protocolo = " . aspa($protocolo);
            execsql($sql);

            $sql = "update grc_atendimento_pendencia ";
            $sql .= " set ";
            $sql .= " idt_responsavel_acao  = " . null($idt_usuario) . ",  ";
            $sql .= " data_acao  = " . $data . "  ";
            $sql .= " where protocolo               = " . aspa($protocolo);
            $sql .= "   and idt_responsavel_solucao = " . null($idt_usuario);
            execsql($sql);

            commit();
        }
        set_time_limit(30);
    } else {
        $vet['erro'] = rawurlencode("Processo de APROVAÇÃO COM PROTOCOLO {$protocolo} NÃO pode ser Completado STATUS = {$status}");
    }
}

function DesAprovarDevolutivaDistancia(&$vet) {
    $kokw = 0;
    $idt_atendimento = $vet['idt_atendimento'];
    $observacaow = $vet['observacao'];
    // Acessar o atendimento
    $sql = "select  ";
    $sql .= " grc_a.idt_consultor,   ";
    $sql .= " grc_a.protocolo,   ";

    $sql .= " grc_a.assunto   ";
    $sql .= " from grc_atendimento grc_a ";
    $sql .= ' where idt = ' . null($idt_atendimento);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $idt_consultor = $row['idt_consultor'];
        $protocolow = $row['protocolo'];
        $protocolo_ativo = $row['protocolo'];
    }
    $assuntow = "Devolução Devolutiva para Ajustes";
    $idt_atendimentow = $idt_atendimento;
    $idt_responsavel_solucaow = $idt_consultor;
    $idt_gestor_localw = $_SESSION[CS]['g_id_usuario'];
    //
    // gerar pendência para o consultor que atendeu ao cliente
    //
    $idt_usuario = $_SESSION[CS]['g_id_usuario'];
    $datadia = date('d/m/Y H:i:s');
    $data_solucaow = $datadia;
    $data = aspa(trata_data($datadia));
    $idt_atendimento = $idt_atendimentow;
    $data_solucao = aspa(trata_data($data_solucaow));
    $protocolo = aspa($protocolow);
    $observacao = aspa($observacaow);
    $assunto = aspa($assuntow);
    $idt_gestor_local = null($idt_gestor_localw);
    $idt_responsavel_solucao = null($idt_responsavel_solucaow);

    $tipo = aspa('Atendimento Distância');
    $status = aspa('Devolução para Ajustes');
    //

    beginTransaction();
    set_time_limit(60);

    // Update em pendencias para desativar
    $sql = "update grc_atendimento_pendencia ";
    $sql .= " set ";
    $sql .= " ativo  = " . aspa('N') . "  ";
    $sql .= " where protocolo = " . aspa($protocolo_ativo);
    execsql($sql);



    $sql_i = ' insert into grc_atendimento_pendencia ';
    $sql_i .= ' (  ';
    $sql_i .= " idt_atendimento, ";
    $sql_i .= " idt_usuario, ";
    $sql_i .= " idt_gestor_local, ";
    $sql_i .= " idt_responsavel_solucao, ";
    $sql_i .= " protocolo, ";
    $sql_i .= " data, ";
    $sql_i .= " data_solucao, ";
    $sql_i .= " tipo, ";
    $sql_i .= " status, ";
    $sql_i .= " assunto, ";
    $sql_i .= " observacao ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $idt_atendimento, ";
    $sql_i .= " $idt_usuario, ";
    $sql_i .= " $idt_gestor_local, ";
    $sql_i .= " $idt_responsavel_solucao, ";
    $sql_i .= " $protocolo, ";
    $sql_i .= " $data, ";
    $sql_i .= " $data_solucao, ";
    $sql_i .= " $tipo, ";
    $sql_i .= " $status, ";
    $sql_i .= " $assunto, ";
    $sql_i .= " $observacao ";
    $sql_i .= ') ';
    $result = execsql($sql_i);
    //$idt_atendimento = lastInsertId();
    // quem tomou a ação
    $sql = "update grc_atendimento_pendencia ";
    $sql .= " set ";
    $sql .= " idt_responsavel_acao  = " . null($idt_usuario) . ",  ";
    $sql .= " data_acao  = " . $data . "  ";
    $sql .= " where protocolo               = " . aspa($protocolo);
    $sql .= "   and idt_responsavel_solucao = " . null($idt_usuario);
    execsql($sql);


    commit();
    set_time_limit(30);


    return $kokw;
}

function GeraArquivoDevolutivaDistancia($idt_atendimento, $row, $vet) {
    $kokw = 1;
    $protocolo = $row['protocolo'];
    $idt_servico = $row['idt_servico'];
    $idt_atendimento = $row['idt'];
    $_GET['idt_servico'] = $idt_servico;
    $_GET['idt_atendimento'] = $idt_atendimento;


    $_GET['protocolo'] = $protocolo;

//	$idt_atendimento_pendencia = $_GET['idt_atendimento_pendencia'];
    $gravadevolutivapdf = "S";
    Require_Once('incdistancia_devolutiva.php');
    return $kokw;
}

function EnviaEmailDevolutivaDistancia($idt_atendimento, $row, $vet) {

    //p($row);
    $protocolo = $row['protocolo'];
    $consultor = $row['nome_completo'];
    $cliente_nome = $row['nome'];
    $cliente_email = $row['email'];
    $cliente_sms = $row['sms'];
    $padrao_emaildevolutiva = "AT.DI-001";
    $sql = 'select ';
    $sql .= '   grc_ae.*';
    $sql .= ' from grc_agenda_emailsms grc_ae ';
    $sql .= " where grc_ae.codigo = " . aspa($padrao_emaildevolutiva);
    $rst = execsql($sql);
    $status = $sql;
    if ($rst->rows > 0) {
        foreach ($rst->data as $rowt) {
            $titulo_email = str_replace('#protocolo', $protocolo, $rowt['descricao']);
            $corpo_email = str_replace('#protocolo', $protocolo, $rowt['detalhe']);
            $corpo_email = str_replace('#consultor', $consultor, $corpo_email);
            $corpo_email = str_replace('#cliente_nome', $cliente_nome, $corpo_email);
            $corpo_email = str_replace('#cliente_email', $cliente_email, $corpo_email);
            $corpo_email = str_replace('#cliente_sms', $cliente_sms, $corpo_email);
        }
    }
    $kokw = 1;
    $banco_grava = "db_pir_grc.";
    $assunto = $titulo_email;
    $mensagem = $corpo_email;
    $para_email = $cliente_email;
    $para_nome = $cliente_nome;
    $usa_protocolo = false;
    $vetRegProtocolo = Array();

    $de_email = "lupe.tecnologia.sebrae@gmail.com";
    $de_nome = $consultor;
    /*
      echo " de {$de_email} <br /> ";
      echo " de {$de_nome} <br /> ";
      echo " para {$para_email} <br /> ";
      echo " para {$para_nome} <br /> ";
     */
    $trata_erro = true;
    $vetArquivos = Array();
    // A devolutiva
    $dirorigem = "obj_file/at_di_devolutiva/";
    $arquivo = "{$protocolo}_devolutiva.pdf";
    $vetArquivos[0]['dirorigem'] = $dirorigem;
    $vetArquivos[0]['arquivo'] = $arquivo;
    //
    // outros arquivos 
    //
	$TabelaPrinc = "grc_atendimento_anexo";
    $AliasPric = "grc_aa";
    $sqlx = "select {$AliasPric}.*  ";
    $sqlx .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sqlx .= " where {$AliasPric}" . '.idt_atendimento = ' . null($idt_atendimento);
    $sqlx .= "  and {$AliasPric}" . '.devolutiva_distancia = ' . aspa('S');
    //$sql .= " order by {$orderby}";
    $rsx = execsql($sqlx);
    if ($rsx->rows > 0) {
        $path = "obj_file/grc_atendimento_anexo/";
        $indice = 0;
        ForEach ($rsx->data as $rowx) {
            $indice = $indice + 1;
            $descricao = $rowx['descricao'];
            $arquivo = $rowx['arquivo'];
            $vetArquivos[$indice]['dirorigem'] = $path;
            $vetArquivos[$indice]['arquivo'] = $arquivo;
        }
    }
    $vetParametros = Array();
    //
    $enviou_email = enviarEmailComunicacao($banco_grava, $assunto, $mensagem, $para_email, $para_nome, $usa_protocolo, $vetRegProtocolo, $de_email, $de_nome, $trata_erro, $vetArquivos, $vetParametros);
    //
    // Update da data de envio
    if ($enviou_email == 1) {
        $mandou_email_comunicacao = "Email Gerado com Sucesso ...";
    } else {
        $mandou_email_comunicacao = "Email Não Pode ser Gerado ...";
    }
    $vet['status_email'] = $mandou_email_comunicacao;
    // P($vetParametros);
    $vet['parametros'] = $vetParametros;
    // ECHO $mandou_email_comunicacao;
    return $kokw;
}

//////////////////// Para Agendamento
// Para acessar
// $vetParametros['idt_atendimento_agenda'] // idt da agenda
// $vetParametros['processo_emailsms'] // processo
function AgendamentoPrepararEmail(&$vetParametros) {
//
    // Acessa Registro do grc_atendimento Agenda
    //
	$idt_atendimento_agenda = $vetParametros['idt_atendimento_agenda'];
    BuscaDadosAgendamento($vetParametros);
    if ($vetParametros['erro'] != "") {
        $vetParametros['erro_buscadados'] = "Não conseguio Buscar dados da agenda";
        return 0;
    }
    $row_ag = $vetParametros['row_ag'];
    $vetDisponivel = $vetParametros['vetDisponivel'];
    //p($vetDisponivel);
    //die();
//$vetDisponivel['#cliente_pf']='cliente_texto';
    //p($row_ag);
    //exit();
    //
	// Acessar o Email Parametrizado
    //
	$processo_emailsms = $vetParametros['processo_emailsms'];
    $sql = 'select ';
    $sql .= '   grc_aes.*, grc_aesp.quando as grc_aesp_quando, grc_aesp.prazo as grc_aesp_prazo  ';
    $sql .= ' from grc_agenda_emailsms_processo grc_aesp ';
    $sql .= ' inner join grc_agenda_emailsms grc_aes on grc_aes.idt_processo = grc_aesp.idt ';
    $sql .= " where grc_aesp.codigo = " . aspa($processo_emailsms);
    $rst = execsql($sql);
    if ($rst->rows > 0) {
        foreach ($rst->data as $rowt) {
            $descricao = $rowt['descricao'];
            $detalhe = $rowt['detalhe'];
            $tipo = $rowt['tipo'];
            //
            $grc_aesp_quando = $rowt['grc_aesp_quando'];
            $grc_aesp_prazo = $rowt['grc_aesp_prazo'];

            // Gravar LOG de EMAIL - SMS
            $imediato = $rowt['imediato'];
            $processo = $processo_emailsms;
            //
            $vetParametros = Array();
            $vetParametros['titulo'] = $descricao;
            $vetParametros['titulo_trans'] = AgendaTransformaMSG($descricao, $row_ag, $vetDisponivel);

            $vetParametros['descricao'] = $detalhe;
            $vetParametros['descricao_trans'] = AgendaTransformaMSG($detalhe, $row_ag, $vetDisponivel);

            $vetParametros['idt_externo'] = $idt_atendimento_agenda;
            $vetParametros['processo'] = $processo;
            $vetParametros['tipo'] = $tipo;

            $vetParametros['emitente_nome'] = $_SESSION[CS]['g_nome_completo'];
            $vetParametros['emitente_email'] = $_SESSION[CS]['g_email'];
            $vetParametros['emitente_login'] = $_SESSION[CS]['g_login'];
            $vetParametros['emitente_sms'] = $_SESSION[CS]['g_sms'];

            $vetParametros['protocolo_agenda'] = $row_ag['protocolo'];
            $vetParametros['destinatario_nome'] = $row_ag['cliente_texto'];
            $vetParametros['destinatario_email'] = $row_ag['email'];
            $vetParametros['destinatario_sms'] = $row_ag['celular'];

            $vetParametros['consultor_nome'] = $row_ag['consultor'];
            $vetParametros['consultor_email'] = $row_ag['consultor_email'];
            $vetParametros['consultor_sms'] = $row_ag['consultor_sms'];

            $tipo_solicitacao = 'NA';

            if ($tipo == 'E') {   // EMAIL
                $tipo_solicitacao = "EM";
            }
            if ($tipo == 'S') {   // SMS
                $tipo_solicitacao = "SM";
            }
            if ($tipo == 'A') {   // Ambos
                $tipo_solicitacao = "ES";
            }
            $vetParametros['tipo_solicitacao'] = $tipo_solicitacao;

            $vetParametros['quando'] = $grc_aesp_quando;
            $vetParametros['prazo'] = $grc_aesp_prazo;
            $dataAgenda = trata_data($row_ag['data']) . ' ' . $row_ag['hora'];
            $imediato = 0;
            $dataenviar = CalcularDataEnviar($dataAgenda, $grc_aesp_quando, $grc_aesp_prazo, $imediato);
            $vetParametros['data_enviar'] = $dataenviar;


            $vetParametros['data_agenda'] = trata_data($row_ag['data']);
            $vetParametros['hora_agenda'] = $row_ag['hora'];

            $vetParametros['sumario_agenda'] = 'Atendimento Sebrae|Bahia - Ponto Atendimento ' . $row_ag['ponto_atendimento'];
            $vetParametros['descricao_agenda'] = 'Atendimento Sebrae|Bahia - Ponto Atendimento ' . $row_ag['ponto_atendimento'] . ' Hora: ' . trata_data($row_ag['data_hora_marcacao']) . ' ' . $row_ag['dia_co_semana'] . ' Tolerância: ' . $row_ag['tolerancia_atraso'] . ' minutos';
            $vetParametros['local_agenda'] = $row_ag['endereco_pa'];

            //
            $idt_comunicacao = GravaComunicacao($vetParametros);
            $observacao_envio = "";
            //
            if ($tipo_solicitacao == 'EM' or $tipo_solicitacao == 'ES') {   // enviar EMAIL 
                if ($idt_comunicacao > 0 and $imediato == 1) {
                    $enviou_ok = AgendamentoEnviarEmail($idt_comunicacao, $vetParametros);
                    if ($enviou_ok == 1) {
                        // enviou imediatamente
                        $observacao_envio .= "Enviado Email<br />";
                        $datadia = trata_data(date('d/m/Y H:i:s'));
                        $sql = 'update grc_comunicacao set ';
                        $sql .= ' observacao_envio  = ' . aspa($observacao_envio) . ", ";
                        $sql .= ' pendente_envio    = ' . aspa('E') . ", ";
                        $sql .= ' data_envio        = ' . aspa($datadia);
                        $sql .= ' where idt         = ' . null($idt_comunicacao);
                        execsql($sql);
                    } else {
                        // ficou na pendência
                    }
                }
            }
            if ($tipo_solicitacao == 'SM' or $tipo_solicitacao == 'ES') {  // Enviar SMS
                if ($idt_comunicacao > 0 and $imediato == 1) {
                    $observacao_envio .= "Enviado SMS<br />";
                    $enviou_ok = AgendamentoEnviarSMS($idt_comunicacao, $vetParametros);
                    if ($enviou_ok == 1) {
                        // enviou imediatamente

                        $datadia = trata_data(date('d/m/Y H:i:s'));
                        $sql = 'update grc_comunicacao set ';
                        $sql .= ' observacao_envio  = ' . aspa($observacao_envio) . ", ";
                        $sql .= ' pendente_envio    = ' . aspa('E') . ", ";
                        $sql .= ' data_envio        = ' . aspa($datadia);
                        $sql .= ' where idt         = ' . null($idt_comunicacao);
                        execsql($sql);
                    } else {
                        // ficou na pendência
                    }
                }
            }
        }
    } else {
        $vetParametros['erro'] = "Não encontrado {$idt_atendimento_agenda} registro em grc_agenda_emailsms_processo";
        return 0;
    }
}

function DecideProcessos($row, &$vetProcessosAgenda) {
    $vetProcessosAgenda = Array();
    $idt_atendimento_agenda = $row['idt'];
    $protocolo = $row['protocolo'];
    if ($row['situacao'] == 'Marcado') { // Gerar processos associados
    }
    return 1;
}

function CalcularDataEnviar($dataAgenda, $grc_aesp_quando, $grc_aesp_prazo, &$imediato) {
    $imediato = 0;
    $dataenviar = $dataAgenda;
    $datahoje = date('d/m/Y H:i:s');
    $datahojeD = trata_data(date('d/m/Y'));
    $dataAgendat = str_replace('/', '-', $dataAgenda);
    //
    if ($grc_aesp_quando == 'A') {  // antes
        $dias = ($grc_aesp_prazo * -1);
        $meses = 0;
        $ano = 0;
        $dataCalc = somar_data($dataAgenda, $dias, $meses, $ano);
        $dataenviar = $dataCalc;
        if (trata_data($dataenviar) <= $datahojeD) {
            $imediato = 1;
        }
    }
    if ($grc_aesp_quando == 'D') {  // Depois
        $dias = ($grc_aesp_prazo * +1);
        $meses = 0;
        $ano = 0;
        $dataCalc = somar_data($dataAgenda, $dias, $meses, $ano);
        $dataenviar = $dataCalc;
        if (trata_data($dataenviar) <= $datahojeD) {
            $imediato = 1;
        }
    }
    if ($grc_aesp_quando == 'E') {  // Imediato - Executando
        $dataenviar = $datahoje;
        $imediato = 1;
    }
    return $dataenviar;
}

function somar_data($data, $dias, $meses, $ano) {
    $data = explode("/", $data);
    $resData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $ano));
    return $resData;
}

function AgendaTransformaMSG($detalhe, $row_ag, $vetDisponivel) {
    // Transformar conteúdo
    $conteudo = $detalhe;
    foreach ($vetDisponivel as $tag => $campo_p) {



        if ($campo_p != '') {
            $valc = $row_ag[$campo_p];
            if ($valc != '') {
                $conteudo = str_replace($tag, $valc, $conteudo);
            }
        }
    }
    return $conteudo;
}

function AgendamentoEnviarEmail($idt_comunicacao, &$vetParametros) {
    global $vetConf;
    //p($vetConf);
    //
	// Acessa Registro do grc_comunicacao
    //
	$sql = 'select ';
    $sql .= '   grc_c.* ';
    $sql .= ' from grc_comunicacao grc_c ';
    $sql .= " where grc_c.idt = " . null($idt_comunicacao);
    $rst = execsql($sql);
    if ($rst->rows > 0) {
        foreach ($rst->data as $rowt) {
            $protocolo_email = $rowt['protocolo'];
            $titulo_email = $rowt['titulo'];
            $descricao_email = $rowt['descricao'];

            $emitente_nome = $rowt['nome'];
            $emitente_email = $rowt['email'];

            $cliente_nome = $rowt['cliente_nome'];
            $cliente_email = $rowt['cliente_email'];
        }
    } else {
        $vetParametros['erro'] = "Não encontrado {$idt_comunicacao} registro em grc_comunicacao";
        return 0;
    }
    // Enviar o EMAIL

    $emitente_nome = "Sebrae Bahia";

    $erro = "";
    //$html = $_SESSION[CS]['g_bia_email_html'];

    $protocolo = $protocolo_email;
    $siglaw = substr($protocolo, 0, 2);
    $protocolow = substr($protocolo, 2);
    $protocolow = TiraZeroEsq($protocolow);
    $protocolow = $siglaw . $protocolow;

    $html = $descricao_email;
    $vetReplace = Array(
        '/sebrae_grc/admin/fckupload/',
        '/sebrae_bia/admin/fckupload/',
    );
    foreach ($vetReplace as $value) {
        $html = str_replace($value, url_pai . $value, $html);
    }
    $origem_nome = $emitente_nome;
    $origem_email = $emitente_email;
    $destino_nome = $cliente_nome;
    $destino_email = $cliente_email;
    //
    $msg = $html;
    //
    //
	// grava ICS
    //
	$protocolo_agenda = $vetParametros['protocolo_agenda'];
    $data_agenda = trata_data($vetParametros['data_agenda']);
    $hora_agenda = $vetParametros['hora_agenda'];
    $descricao_agenda = $vetParametros['descricao_agenda'];
    $sumario_agenda = $vetParametros['sumario_agenda'];
    $local_agenda = str_replace('<br />', '', $vetParametros['local_agenda']);

    $vetParametroICS['protocolo'] = $protocolo_agenda;
    $vetParametroICS['sumario'] = utf8_encode($sumario_agenda);
    $vetParametroICS['descricao'] = utf8_encode($descricao_agenda);
    $vetParametroICS['local_agenda'] = utf8_encode($local_agenda);
    $vetParametroICS['data_agenda'] = $data_agenda;
    $vetParametroICS['hora_evento'] = $hora_agenda;
    $arquivo_ics = ArquivoICS($vetParametroICS);
    $vetParametroICS['arquivonovo_ics'] = $arquivonovo_ics;

    $de_replay = $vetConf['email_site'];
    $de_email = $vetConf['email_envio'];
    $de_nome = $origem_nome;

    if ($de_email == '') {
        $de_email = $de_replay;
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

    $mail->IsSMTP();
    $mail->Host = $vetConf['host_smtp'];
    $mail->Port = $vetConf['port_smtp'];
    $mail->Username = $vetConf['login_smtp'];
    $mail->Password = $vetConf['senha_smtp'];
    $mail->SMTPAuth = !($vetConf['login_smtp'] == '' && $vetConf['senha_smtp'] == '');
    $mail->SMTPSecure = $vetConf['smtp_secure'];
    $mail->setFrom($de_email, $de_nome);
    $mail->AddReplyTo($de_replay, $de_nome);

    $mail->Subject = $titulo_email;
    $mail->msgHTML($msg);

    $mail->AddAddress($destino_email, $destino_nome);


    $mail->AddAttachment($arquivo_ics, $arquivonovo_ics);



    //p($mail);
    try {
        //p($mail);
        //exit();
        if ($mail->Send()) {
            $vetParametros['msg'] = "E-mail Enviado com sucesso";
            return 1;
        } else {
            $erro = "Erro na transmissão.\nTente outra vez!\n\n" . trata_aspa($mail->ErrorInfo);
            $vetParametros['erro'] = "Erro na transmissão.\nTente outra vez!\n\n" . trata_aspa($mail->ErrorInfo);
            return 0;
        }
    } catch (Exception $e) {
        //$erro = 'O Sistema encontrou problemas para enviar seu e-mail.\n' . $e->getMessage();
        $vetParametros['erro'] = "Erro na transmissão.\nTente outra vez!\n\n" . trata_aspa($mail->ErrorInfo);
        return 0;
    }

    //
    // enviar email
    //
   
    return 1;
}

function AgendamentoEnviarSMS($idt_comunicacao, &$vetParametros) {
    global $vetConf;
    //p($vetConf);
    //
	// Acessa Registro do grc_comunicacao
    //
	$sql = 'select ';
    $sql .= '   grc_c.* ';
    $sql .= ' from grc_comunicacao grc_c ';
    $sql .= " where grc_c.idt = " . null($idt_comunicacao);
    $rst = execsql($sql);
    if ($rst->rows > 0) {
        foreach ($rst->data as $rowt) {
            $msg = $rowt['titulo'];
            $protocolo = $rowt['protocolo'];
            $telefone = $rowt['sms'];
            $telefone_t = $rowt['sms_t'];
            $vetParametros = Array();
            $vetParametros['protocolo'] = $protocolo;
            $vetParametros['telefone'] = $telefone;
            $vetParametros['telefone_t'] = $telefone_t;
            $vetParametros['msg'] = $msg;
            $ret = SMS_Enviar($vetParametros);
        }
    }
    return 1;
}

function SMS_Enviar(&$vetParametros) {
    $protocolo = $vetParametros['protocolo'];
    $telefone = '55' . $vetParametros['telefone'];
    $msg = retiraAcentos($vetParametros['msg']);

    require_once(lib_sms . 'autoload.php');

    try {
        $smsFacade = new SmsFacade(smsLogin, smsSenha, smsServiceUrl);

        $sms = new Sms();
        $sms->setTo($telefone);
        $sms->setMsg($msg);
        $sms->setId($protocolo);

        $date = new DateTime();
        $date->setTimeZone(new DateTimeZone('America/Sao_Paulo'));
        $date->setDate(2014, 7, 28);
        $date->setTime(13, 50, 00);
        $schedule = $date->format("Y-m-d\TH:i:s");

        //Formato da data deve obedecer ao padrão descrito na ISO-8601. Exemplo "2015-12-31T09:00:00"
        $sms->setSchedule($schedule);

        //Envia a mensagem para o webservice e retorna um objeto do tipo SmsResponse com o status da mensagem enviada
        $response = $smsFacade->send($sms, smsAgregateID);

        if ($response->getStatusCode() != "00") {
            //echo "\nMensagem não pôde ser enviada.";
            return 0;
        }
    } catch (Exception $e) {
        grava_erro_log('sms', $e, '', '', $smsFacade);
        return 0;
    }

    return 1;
}

function retiraAcentos($string) {
    $string = preg_replace("/[áàâãä]/", "a", $string);
    $string = preg_replace("/[ÁÀÂÃÄ]/", "A", $string);
    $string = preg_replace("/[éèê]/", "e", $string);
    $string = preg_replace("/[ÉÈÊ]/", "E", $string);
    $string = preg_replace("/[íì]/", "i", $string);
    $string = preg_replace("/[ÍÌ]/", "I", $string);
    $string = preg_replace("/[óòôõö]/", "o", $string);
    $string = preg_replace("/[ÓÒÔÕÖ]/", "O", $string);
    $string = preg_replace("/[úùü]/", "u", $string);
    $string = preg_replace("/[ÚÙÜ]/", "U", $string);
    $string = preg_replace("/ç/", "c", $string);
    $string = preg_replace("/Ç/", "C", $string);
    $string = preg_replace("/[][><}{)(:;,!?*%~^`@]/", "", $string);
    //$string = preg_replace("/ /", "_", $string);
    return $string;
}

function BuscaDadosAgendamento(&$vetParametros) {

    $vetDiaSemana = Array(
        'Dom' => 'Domingo',
        'Seg' => 'Segunda',
        'Ter' => 'Terça',
        'Qua' => 'Quarta',
        'Qui' => 'Quinta',
        'Sex' => 'Sexta',
        'Sáb' => 'Sábado'
    );

    $idt_atendimento_agenda = $vetParametros['idt_atendimento_agenda'];
    $TabelaPrinc = "grc_atendimento_agenda";
    $AliasPric = "grc_aa";
    $campos = "{$AliasPric}.*, ";
    $campos .= "sca_oc.descricao as ponto_atendimento,  ";
    $campos .= "sca_oc.logradouro as logradouro,  ";
    $campos .= "sca_oc.logradouro_numero as numero,  ";
    $campos .= "sca_oc.logradouro_complemento as complemento,  ";
    $campos .= "sca_oc.cep as cep,  ";
    $campos .= "sca_oc.telefone   as telefone,  ";
    $campos .= "sca_oc.horario_funcionamento as horario_funcionamento,  ";
    $campos .= "sca_oc.imagem as imagem,  ";
    $campos .= "sca_oc.logradouro_codbairro as logradouro_codbairro,  ";
    $campos .= "sca_oc.logradouro_codcid as logradouro_codcid,  ";
    $campos .= "sca_oc.logradouro_codest as logradouro_codest,  ";
    $campos .= "sca_oc.logradouro_codpais as logradouro_codpais,  ";
    $campos .= "pu.email as consultor_email,  ";
    $campos .= "pu.nome_completo as consultor,  ";
	$campos .= "gae.detalhe as detalhe,  ";
    $campos .= "gae.descricao as servico  ";
    $sql = "select  ";
    $sql .= " $campos  ";
    $sql .= " from {$TabelaPrinc}  {$AliasPric}";
    $sql .= " left  join grc_atendimento as ga on ga.idt_atendimento_agenda = {$AliasPric}.idt ";
    $sql .= " left  join grc_atendimento_especialidade as gae on gae.idt = {$AliasPric}.idt_especialidade ";
    $sql .= " left  join " . db_pir_gec . "gec_entidade as ge on ge.idt = {$AliasPric}.idt_cliente ";
    $sql .= " left  join plu_usuario as pu on pu.id_usuario = {$AliasPric}.idt_consultor ";
    $sql .= " left  join grc_atendimento_agenda_painel as pn on pn.idt_atendimento_agenda = {$AliasPric}.idt ";
    $sql .= " left  join " . db_pir . "sca_organizacao_secao as sca_oc on sca_oc.idt = {$AliasPric}.idt_ponto_atendimento ";
    $strWhere = " {$AliasPric}.idt = " . null($idt_atendimento_agenda);
    $korderbyw = "";
    if ($strWhere != "") {
        $sql .= " where (";
        $sql .= $strWhere;
        $sql .= " )";
    }
    if ($korderbyw != "") {
        $sql .= " order by ";
        $sql .= $korderbyw;
    }
    $rs = execsql($sql);
    $qtd_sel = $rs->rows;
    if ($qtd_sel == 0) {
        // Nada foi selecionado
        //echo "Erro Registro de Agendamento Não Encontrado";	
        $vetParametros['erro'] = "Erro Registro de Agendamento Não Encontrado";
    } else {
        //p($rs);
        $vetCamposSQL = $rs->info['name'];
        //p($vetCamposSQL);

        $atualizatab = 1;
        if ($atualizatab == 1) {
            foreach ($vetCamposSQL as $indice => $nome_campo) {
                $sqlpe = "";
                $sqlpe .= " select idt ";
                $sqlpe .= ' from grc_atendimento_agenda_email_tag grc_aaet ';
                $sqlpe .= ' where campo_p = ' . aspa($nome_campo);
                $rspe = execsql($sqlpe);
                if ($rspe->rows == 0) {
                    $codigo = aspa('#' . $nome_campo);
                    $descricao = aspa($nome_campo);
                    $ativo = aspa('S');
                    $tabela_p = aspa('grc_atendimento_agenda');
                    $campo_p = aspa($nome_campo);
                    $ordem = aspa('99');
                    $sql_i = ' insert into grc_atendimento_agenda_email_tag ';
                    $sql_i .= ' (  ';
                    $sql_i .= " codigo, ";
                    $sql_i .= " descricao, ";
                    $sql_i .= " ativo, ";
                    $sql_i .= " tabela_p, ";
                    $sql_i .= " campo_p, ";
                    $sql_i .= " ordem ";
                    $sql_i .= '  ) values ( ';
                    $sql_i .= " $codigo, ";
                    $sql_i .= " $descricao, ";
                    $sql_i .= " $ativo, ";
                    $sql_i .= " $tabela_p, ";
                    $sql_i .= " $campo_p, ";
                    $sql_i .= " $ordem ";
                    $sql_i .= ') ';
                    execsql($sql_i, false);
                }
            }
        }
        $sqlp = '';
        $sqlp .= " select grc_aaet.* ";
        $sqlp .= ' from grc_atendimento_agenda_email_tag grc_aaet ';
        $rsp = execsql($sqlp);
        $vetDisponivel = Array();
        ForEach ($rsp->data as $rowp) {
            $tag = $rowp['codigo'];
            $descricao = $rowp['descricao'];
            $campo_p = $rowp['campo_p'];
            $vetDisponivel[$tag] = $campo_p;
        }
        $vetParametros['vetDisponivel'] = $vetDisponivel;
        foreach ($vetDisponivel as $tag => $campo_p) {
            
        }

        $vetParametros['vetCamposSQL'] = vetCamposSQL;
        ForEach ($rs->data as $row) {
            // detalhe dos campos na row
            $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
            $codigo = $row['codigo'];
            $data = trata_data($row['data']);
            $hora = $row['hora'];
            $dia_semana = $row['dia_semana'];



            $cliente_texto = $row['cliente_texto'];
            $email = $row['email'];
            $celular = $row['celular'];
            $protocolo = $row['protocolo'];
            $cpf = $row['cpf'];
            $cnpj = $row['cnpj'];
            $nome_empresa = $row['nome_empresa'];
            $unidade_regional = $row['unidade_regional'];
            $ponto_atendimento = $row['ponto_atendimento'];
            $servico = $row['servico'];
            $consultor = $row['consultor'];


            $logradouro = $row['logradouro'];
            $numero = $row['numero'];
            $complemento = $row['complemento'];
            $cep = $row['cep'];
            $telefone = $row['telefone'];
            $horario_funcionamento = $row['horario_funcionamento'];

            $logradouro_codbairro = $row['logradouro_codbairro'];
            $logradouro_codcid = $row['logradouro_codcid'];
            $logradouro_codest = $row['logradouro_codest'];
            $logradouro_codpais = $row['logradouro_codpais'];
            $imagem = $row['imagem'];
            $sqlp = '';
            $sqlp .= " select distinct codpais as cod, pais_nome";
            $sqlp .= ' from ' . db_pir_gec . 'base_cep';
            $sqlp .= ' where codpais = ' . null($logradouro_codpais);
            $rsp = execsql($sqlp);
            ForEach ($rsp->data as $rowp) {
                $pais_nome = $rowp['pais_nome'];
            }

            $sqlp = '';
            $sqlp .= " select distinct codest as cod, uf_nome";
            $sqlp .= ' from ' . db_pir_gec . 'base_cep';
            $sqlp .= ' where codest = ' . null($logradouro_codest);
            $rsp = execsql($sqlp);
            ForEach ($rsp->data as $rowp) {
                $uf_nome = $rowp['uf_nome'];
            }
            $sqlp = '';
            $sqlp .= " select distinct codcid as cod, cidade";
            $sqlp .= ' from ' . db_pir_gec . 'base_cep';
            $sqlp .= ' where codcid = ' . null($logradouro_codcid);
            $rsp = execsql($sqlp);
            ForEach ($rsp->data as $rowp) {
                $cidade = $rowp['cidade'];
            }

            $sqlp = '';
            $sqlp .= " select distinct codbairro as cod, bairro";
            $sqlp .= ' from ' . db_pir_gec . 'base_cep';
            $sqlp .= ' where codbairro = ' . null($logradouro_codbairro);
            $rsp = execsql($sqlp);
            ForEach ($rsp->data as $rowp) {
                $bairro = $rowp['bairro'];
            }
            $endereco = "";
            $row['pais_nome'] = $pais_nome;
            $row['uf_nome'] = $uf_nome;
            $row['cidade'] = $cidade;
            $row['bairro'] = $bairro;
            $row['cep'] = $cep;
            $row['numero'] = $numero;
            $row['complemento'] = $complemento;

            if ($numero == "" and $complemento == "") {
                $endereco .= "$logradouro, CEP: $cep ";
            }
            if ($numero != "" and $complemento == "") {
                $endereco .= "$logradouro, $numero, CEP: $cep ";
            }
            if ($numero == "" and $complemento != "") {
                $endereco .= "$logradouro, $complemento, CEP: $cep ";
            }
            if ($numero != "" and $complemento != "") {
                $endereco .= "$logradouro, $numero, $complemento, CEP: $cep ";
            }
            $endereco .= "<br />$bairro, $cidade, $uf_nome, $pais_nome    ";
            // dados calculados			
            $row['data_ag'] = $data;
            $row['endereco_pa'] = $endereco;

            $vetParametrosw = Array();
            $vetParametrosw['tipo'] = "UR";
            $vetParametrosw['idt_sca_oc'] = "";
            $vetParametrosw['idt_ponto_atendimento'] = $idt_ponto_atendimento;
            $ret = DadosSCA($vetParametrosw);
            $unidade_regional = $vetParametrosw['descricao_ur'];
            $row['unidade_regional'] = $unidade_regional;

            $vetParametrosw = Array();
            $ret = DadosPARAGENDA($vetParametrosw);
            $tolerancia_atraso = $vetParametrosw['row_ap']['tolerancia_atraso'];
            $row['tolerancia_atraso'] = $tolerancia_atraso;

            //$row['unidade_regional']= 'Unidade Marreta';
            $dia_co_semana = $vetDiaSemana[$dia_semana];
            $row['dia_co_semana'] = $dia_co_semana;
            //$row['dia_co_semana'] = 'Terça marreta '.$dia_semana.' ---> '.$dia_co_semana;
            // editar campos em $row
            $row['data'] = trata_data($row['data']);
            //
            $vetParametros['row_ag'] = $row;
        }
    }
}

function DadosPARAGENDA(&$vetParametrosw) {
    $sqlp = '';
    $sqlp .= " select grc_ap.* ";
    $sqlp .= ' from grc_agenda_parametro grc_ap ';
    $sqlp .= ' where idt = 1 ';
    $rsp = execsql($sqlp);
    ForEach ($rsp->data as $rowp) {
        $vetParametrosw['row_ap'] = $rowp;
    }
    return true;
}

function EnviarEMAILPresenca(&$vet) {
    $kokw = 0;
    $idt_atendimento_agenda = $vet['idt_atendimento_agenda'];
    $idt_especialidade = $vet['idt_especialidade'];
    $sql = '';
    $sql .= ' select gec_ser.tipo_atendimento';
    $sql .= ' from ' . db_pir_grc . 'grc_atendimento_especialidade gec_ser where gec_ser.idt = ' . null($idt_especialidade);
    $rs_a1 = execsql($sql);
    $tipo_atendimento = '';
    ForEach ($rs_a1->data as $row) {
        $tipo_atendimento = $row['tipo_atendimento'];
    }
    if ($tipo_atendimento == 'D') {
        $codigo = '80.02'; // "Enviar Email Solicitando Confirmação - Distancia"
    } else {
        $codigo = '02.02'; // "Enviar Email Solicitando Confirmação - Presencial"
    }

    $vetParametros = Array();
    $vetParametros['idt_atendimento_agenda'] = $idt_atendimento_agenda; // idt da agenda
    $vetParametros['processo_emailsms'] = $codigo; // processo Email/SMS
    $kokw = AgendamentoPrepararEmail($vetParametros);
    if ($kokw == 0) {
        //echo "---> Erro = ".$vetParametros['erro_buscadados'];
        //$vet["erro"]=$vetParametros['erro_buscadados'];
    }
}

function EnviarSMSPresenca(&$vet) {
    $kokw = 0;
    $idt_atendimento_agenda = $vet['idt_atendimento_agenda'];
    $idt_especialidade = $vet['idt_especialidade'];

    $sql = '';
    $sql .= ' select gec_ser.tipo_atendimento';
    $sql .= ' from ' . db_pir_grc . 'grc_atendimento_especialidade gec_ser where gec_ser.idt = ' . null($idt_especialidade);
    $rs_a1 = execsql($sql);
    $tipo_atendimento = '';
    ForEach ($rs_a1->data as $row) {
        $tipo_atendimento = $row['tipo_atendimento'];
    }
    if ($tipo_atendimento == 'D') {
        $codigo = '90.03'; // "Enviar SMS na Véspera - Distância"
    } else {
        $codigo = '90.03'; // "Enviar SMS na Véspera - Presencial"
    }


    $vetParametros = Array();
    $vetParametros['idt_atendimento_agenda'] = $idt_atendimento_agenda; // idt da agenda
    $vetParametros['processo_emailsms'] = $codigo; // processo Email/SMS
    $kokw = AgendamentoPrepararEmail($vetParametros);

    if ($kokw == 0) {
        //echo "---> Erro = ".$vetParametros['erro'];
        //	$vet["erro"]=$vetParametros['erro_buscadados'];
    }
}

function BuscaCNPJMARCACAO(&$variavel) {
    $kokw = 0;
    $cpf = $variavel['cpf'];
    $cnpj = $variavel['cnpj'];
    $variavel['idt_atendimento_organizacao'] = 0;
    $variavel['codparceiro_lista'] = '';
    $cpf_w = $variavel['cpf'];
    $cnpj_w = $variavel['cnpj'];
    $codparceiro = $variavel['codparceiro'];


    //$cpfcnpj_w                     = $cnpj_w;
    $cpfcnpj_w = $cpf_w;

    $temRegistro = false;

    $dadosPesq = Array();
    $dadosPesq['razao_social'] = $variavel['razao_social'];
    $dadosPesq['nome_fantasia'] = $variavel['nome_fantasia'];
    $dadosPesq['ie_prod_rural'] = $variavel['ie_prod_rural'];
    $dadosPesq['sicab_codigo'] = $variavel['sicab_codigo'];
    $dadosPesq['dap'] = $variavel['dap'];
    $dadosPesq['rmp'] = $variavel['rmp'];
    $dadosPesq['nirf'] = $variavel['nirf'];

    //
    // Se tem empresa associada Busca dados
    //
    $vetEntidade = Array();
    set_time_limit(600);
    $cpfcnpj_w = $cnpj_w;
    $kretw = BuscaDadosEntidadePIR($cpfcnpj_w, 'O', $vetEntidade, $codparceiro, $dadosPesq);

    //p($vetEntidade);
    //echo " ------ {$cpfcnpj_w} ";
    //
    if ($vetEntidade['PIR']['O']['existe_entidade'] != 'S') {
        if ($cnpj_w == "" && $codparceiro == "" && ($variavel['razao_social'] != '' || $variavel['nome_fantasia'] != '' || $variavel['ie_prod_rural'] != '' || $variavel['sicab_codigo'] != '' || $variavel['dap'] != '' || $variavel['rmp'] != '' || $variavel['nirf'] != '')) {
            $sql = '';
            $sql .= ' select j.codparceiro, p.cgccpf';
            $sql .= ' from pessoaj j with(nolock)';
            $sql .= ' inner join parceiro p with(nolock) on p.codparceiro = j.codparceiro';
            $sql .= ' where ';

            $vetSQL = Array();

            if ($variavel['ie_prod_rural'] != '') {
                $vetSQL[] = 'j.codprodutorrural = ' . aspa($variavel['ie_prod_rural']);
            }

            if ($variavel['sicab_codigo'] != '') {
                $vetSQL[] = 'j.codsicab = ' . aspa(preg_replace('/\./i', '', $variavel['sicab_codigo']));
            }

            if ($variavel['dap'] != '') {
                $vetSQL[] = 'j.coddap = ' . aspa($variavel['dap']);
            }

            if ($variavel['rmp'] != '') {
                $vetSQL[] = 'j.codpescador = ' . aspa($variavel['rmp']);
            }

            if ($variavel['nirf'] != '') {
                $vetSQL[] = 'j.nirf = ' . null(preg_replace('/[^0-9]/i', '', $variavel['nirf']));
            }

            if (count($vetSQL) == 0) {
                if ($variavel['razao_social'] != '') {
                    $vetSQL[] = 'lower(p.nomerazaosocial) like lower(' . aspa($variavel['razao_social'], '%', '%') . ')';
                }

                if ($variavel['nome_fantasia'] != '') {
                    $vetSQL[] = 'lower(p.nomeabrevfantasia) like lower(' . aspa($variavel['nome_fantasia'], '%', '%') . ')';
                }
            }

            if (count($vetSQL) == 0) {
                $sql .= ' 1 = 0 ';
            } else {
                $sql .= implode(' or ', $vetSQL);
            }

            $rs = execsql($sql, true, conSIAC());

            switch ($rs->rows) {
                case 0:
                    $idt_tipo_empreendimento_e = 7;
                    $dap_e = $variavel['dap'];
                    $nirf_e = $variavel['nirf'];
                    $rmp_e = $variavel['rmp'];
                    $ie_prod_rural_e = $variavel['ie_prod_rural'];
                    $sicab_codigo = $variavel['sicab_codigo'];
                    $razao_social_e = $variavel['razao_social'];
                    $nome_fantasia_e = $variavel['nome_fantasia'];

                    $variavel['idt_atendimento_organizacao'] = 0;
                    break;

                case 1:
                    /*
                      if ($rs->data[0]['cgccpf'] != '') {
                      $cnpj_w = FormataCNPJ($rs->data[0]['cgccpf']);
                      }
                     * 
                     */

                    $variavel['codparceiro'] = $rs->data[0]['codparceiro'];
                    $codparceiro = $variavel['codparceiro'];
                    break;

                default:
                    $vetTmp = Array();

                    foreach ($rs->data as $row) {
                        $vetTmp[$row['codparceiro']] = $row['codparceiro'];
                    }

                    $variavel['codparceiro_lista'] = implode(', ', $vetTmp);
                    return $kokw;
            }
        }

        $vetEntidade = Array();
        $kretw = BuscaDadosEntidadeSIACBA($cpfcnpj_w, 'J', $vetEntidade, $codparceiro);

        if ($cpfcnpj_w != '') {
            $kretw = BuscaDadosEntidadeSIACNA($cpfcnpj_w, 'J', $vetEntidade);
            $kretw = BuscaDadosEntidadeMEI($cpfcnpj_w, 'J', $vetEntidade);
            $kretw = BuscaDadosEntidadeRF($cpfcnpj_w, 'J', $vetEntidade);
        }
    }
    //p($vetEntidade);
    $variavel['nome_empresa'] = $vetEntidade['PIR']['O']['nome'];
}

//
//  Verificar se atendimento esta preso para marcação
//
function VerificaAtendimentoPresoParaMarcacao($idt_atendimento_agenda) {

    $vet = Array(
        'erro' => '',
    );

    $texto = "";

    $sql = "select  ";
    $sql .= " grc_aa.semmarcacao  ";
    $sql .= " from grc_atendimento_agenda grc_aa ";
    $sql .= ' where idt = ' . null($idt_atendimento_agenda);
    $rs = execsql($sql);

    if ($rs->rows > 0) {
        ForEach ($rs->data as $row) {
            $semmarcacao = $row['semmarcacao'];
        }
        if ($semmarcacao != "S") {
            $texto = "Desculpe, Agendamento para esse Horário não pode ser realizado.\nNão esta disponível nesse momento\nTente mais tarde.";
        }
    } else {
        $texto = "Desculpe, Agendamento para esse Horário não pode ser realizado.";
    }
    $vet['erro'] = $texto;

    return $vet;
}

//
// Verifica e guarda agendamento
//
function VefificaConsumoHorarios($idt_atendimento_agenda, $idt_servico) {

    $vet = Array(
        'erro' => '',
    );

    $texto = "";

    $vetRetorno = Array();
    if ($idt_servico > 0) {
        FormarGrupoHorario($idt_atendimento_agenda, $idt_servico, $vetRetorno);
        // p($vetRetorno);
        // die();
        $data = (trata_data($vetRetorno['data']));
        $hora = ($vetRetorno['hora']);
        $hora_final = ($vetRetorno['hora_final']);
        $qtd_agenda_livre = ($vetRetorno['qtd_agenda_livre']);
        $periodoMarcar = $vetRetorno['periodo_marcar'];
        $IntervaloAgenda = $vetRetorno['IntervaloAgenda'];

        $quantidade_marcar = ($vetRetorno['quantidade_marcar']);
        $data_hora_marcacao_inicial = $vetRetorno['data_hora_marcacao_inicial'];
        $qtd_agenda_livre_teste = $qtd_agenda_livre + 1;


        $textdebag = $vetRetorno['textdebag'];
        if ($qtd_agenda_livre_teste != $quantidade_marcar and $quantidade_marcar > 1) {
            if ($periodoMarcar > $IntervaloAgenda) {
                $texto .= "<span style='color:#FF0000;'> {$textdebag}<br /> Tentando Agendar para iniciar em {$data}  às {$hora} e terminar às {$hora_final} com duração de {$periodoMarcar} minutos.</span><br /> ";
            } else {  // aceitar mesmo sem vários periodos
                $quantidade_marcar = 1;
                $vetRetorno['quantidade_marcar'] = $quantidade_marcar;
                $texto .= " {$textdebag}<br /> Agendado para iniciar em {$data}  às {$hora} e terminar às {$hora_final} com duração de {$periodoMarcar} minutos.<br /> ";
            }
        } else {
            $texto .= " {$textdebag}<br />Agendado para iniciar em {$data}  às {$hora} e terminar às {$hora_final} com duração de {$periodoMarcar} minutos.<br /> ";
        }

        // libera Grupo Pai e filhos
        $sql = "";
        $sql .= " UPDATE " . db_pir_grc . "grc_atendimento_agenda ";
        $sql .= " SET ";
        $sql .= " semmarcacao                   = " . aspa('N') . ", ";
        $sql .= " idt_atendimento_agenda        = NULL ";
        $sql .= " WHERE idt_atendimento_agenda  = " . null($idt_atendimento_agenda);
        execsql($sql);

        if ($quantidade_marcar > 1) {

            if ($qtd_agenda_livre_teste != $quantidade_marcar) {

                $vetFilhos = $vetRetorno['agenda_filhos'];
                $outroshorarios = "";
                $virgula = "{$hora}, ";
                ForEach ($vetFilhos as $idt_atendimento_agenda_filho => $hora) {
                    $outroshorarios .= $virgula . $hora;
                    $virgula = ', ';
                }
                $vet['erro'] = "Não tem {$quantidade_marcar} Horários  Consecutivos para Marcar esse serviço";
                $texto .= " Agendas Consecutivas Livres {$qtd_agenda_livre_teste} Necessidade para esse Serviço: {$quantidade_marcar} Horários Disponíveis: {$outroshorarios} <br />";
            } else {

                $vetFilhos = $vetRetorno['agenda_filhos'];
                $outroshorarios = "";
                $virgula = "{$hora}, ";
                $ocupadohorarios = "";
                $virgula2 = '';

                ForEach ($vetFilhos as $idt_atendimento_agenda_filho => $hora) {
                    $outroshorarios .= $virgula . $hora;
                    $virgula = ', ';

                    // Esses são filhos, acessar a Agenda como pai (Raiz)
                    $sql = "SELECT  ";
                    $sql .= " grc_a.*  ";
                    $sql .= " FROM " . db_pir_grc . "grc_atendimento_agenda grc_a ";
                    $sql .= ' WHERE idt = ' . null($idt_atendimento_agenda_filho);
                    $rs = execsql($sql);

                    if ($rs->rows > 0) {
                        ForEach ($rs->data as $row) {
                            $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
                            $idt_consultor = $row['idt_consultor'];
                            $idt_cliente = $row['idt_cliente'];
                            $idt_especialidade = $row['idt_especialidade'];
                            $data = $row['data'];
                            $hora = $row['hora'];
                            $origem = $row['origem'];
                            $situacao = $row['situacao'];
                            $semmarcacao = $row['semmarcacao'];
                            if ($semmarcacao != "N") {
                                $ocupadohorarios .= $virgula2 . $hora;
                                $virgula2 = ', ';
                            }

                            $sql = "UPDATE " . db_pir_grc . "grc_atendimento_agenda ";
                            $sql .= " SET ";
                            $sql .= " semmarcacao                  = " . aspa('S') . ", ";
                            $sql .= " idt_atendimento_agenda       = " . null($idt_atendimento_agenda) . ", ";
                            // $sql .= " marcador                  = ".aspa($marcador).", ";
                            // $sql .= " idt_marcador              = ".null($idt_marcador).", ";
                            $sql .= " data_hora_marcacao_inicial   = " . aspa($data_hora_marcacao_inicial) . " ";
                            $sql .= " WHERE idt = " . null($idt_atendimento_agenda_filho);
                            execsql($sql);
                        }
                    }
                }
                $texto .= " Agendados {$quantidade_marcar} Horários: {$outroshorarios} <br />";
            }
        }
    } else {
        $vet['erro'] = 'Não informou o Serviço para Agendamento';
    }

    $vet['texto'] = $texto;

    return $vet;
}

//
// Busca a Agenda e Serviços associados para Marcação de um ou mais Horários
//
function FormarGrupoHorario($idt_atendimento_agenda, $idt_servico, &$vetRetorno) {
    $vetServicosPer = Array();
    $textdebag = "";

    // Acessar a Agenda como pai (Raiz)
    $sql = "select  ";
    //$sql .= " grc_a.*  ";
    $sql .= " idt_ponto_atendimento, idt_consultor, idt_cliente, idt_especialidade, data, hora, origem, situacao,data_hora_marcacao_inicial ";
    $sql .= " from " . db_pir_grc . "grc_atendimento_agenda grc_a ";
    $sql .= ' where idt = ' . null($idt_atendimento_agenda);
    $rs = execsql($sql);

    if ($rs->rows > 0) {
        ForEach ($rs->data as $row) {
            $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
            $idt_consultor = $row['idt_consultor'];
            $idt_cliente = $row['idt_cliente'];
            $idt_especialidade = $row['idt_especialidade'];
            $data = $row['data'];
            $hora = $row['hora'];
            $origem = $row['origem'];
            $situacao = $row['situacao'];
            $data_hora_marcacao_inicial = $row['data_hora_marcacao_inicial'];
        }
        // pegar a próximo Horário
        $IntervaloAgendaw = 0;
        $horaw = "23:59";

        $sqlt = "select  ";
        $sqlt .= " grc_a.*  ";
        $sqlt .= " from " . db_pir_grc . "grc_atendimento_agenda grc_a ";
        $sqlt .= ' where idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
        $sqlt .= '   and idt_consultor         = ' . null($idt_consultor);
        $sqlt .= '   and data                  = ' . aspa($data);
        $sqlt .= '   and origem                = ' . aspa($origem);
        $sqlt .= '   and situacao              = ' . aspa('Agendado');
        $sqlt .= ' order by hora ';
        $rstt = execsql($sqlt);
        if ($rstt->rows > 0) {
            $chaveverdade = 0;
            ForEach ($rstt->data as $rowt) {
                $idt_atendimento_agendaw = $rowt['idt'];
                if ($idt_atendimento_agenda == $idt_atendimento_agendaw) {
                    $chaveverdade = 1;
                    continue;
                }
                if ($chaveverdade == 0) {
                    continue;
                }
                $idt_ponto_atendimentow = $rowt['idt_ponto_atendimento'];
                $idt_consultorw = $rowt['idt_consultor'];
                $idt_clientew = $rowt['idt_cliente'];
                ///////$idt_especialidade     = $rowt['idt_especialidade'];
                $dataw = $rowt['data'];
                $horaw = $rowt['hora'];
                $origemw = $rowt['origem'];
                $situacaow = $rowt['situacao'];
                $servicos_idtw = $rowt['servicos_idt'];
                $semmarcacaow = $rowt['semmarcacao'];
                break;
            }
        }

        $IntervaloAgendaw = 0;
        $vet = explode(':', $hora);
        $hh = $vet[0];
        $mm = $vet[1];

        $vet = explode(':', $horaw);
        $hhw = $vet[0];
        $mmw = $vet[1];

        $mm1 = ($hh * 60) + $mm;
        $mm2 = ($hhw * 60) + $mmw;
        $IntervaloAgendaw = ( $mm2 - $mm1 );
        $vetRetorno['IntervaloAgenda'] = $IntervaloAgendaw;




        $sql = "select  ";
        $sql .= " grc_paps.*  ";
        $sql .= " from " . db_pir_grc . "grc_atendimento_pa_pessoa grc_app ";
        $sql .= " inner join " . db_pir_grc . "grc_atendimento_pa_pessoa_servico grc_paps on grc_paps.idt_pa_pessoa = grc_app.idt ";
        $sql .= ' where grc_app.idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
        $sql .= '   and idt_usuario  = ' . null($idt_consultor);
        $rs = execsql($sql);
        $menorperiodo = 9999;
        if ($rs->rows > 0) {
            ForEach ($rs->data as $row) {
                $periodow = $row['periodo'];
                $idt_servicow = $row['idt_servico'];
                if ($idt_servicow == $idt_servico) {   // servico para marcação
                    $periodoMarcar = $periodow;
                }
                if ($periodow < $menorperiodo) {
                    $menorperiodo = $periodow;
                }
                $vetServicosPer[$idt_servicow] = $periodow; // Horas necessárias para atendimento
            }
        }


        $textdebag .= " {$hora} - {$horaw} = {$IntervaloAgendaw} ### Menor período = {$menorperiodo}";

        if ($menorperiodo == 9999) {
            $quantidade_marcar = 1;
        } else {
            $quantidade_marcar = ($periodoMarcar / $menorperiodo);
            /*
              ForEach ($vetServicosPer as $idt_servicow => $Periodoy)
              {
              }
             */
        }
        $textdebag .= " periodo marcar = $periodoMarcar Qdt Marcar = {$quantidade_marcar}";

        $vetRetorno['data'] = $data;
        $vetRetorno['hora'] = $hora;
        $vetRetorno['menorperiodo'] = $menorperiodo;
        $vetRetorno['quantidade_marcar'] = $quantidade_marcar;
        $vetRetorno['periodo_marcar'] = $periodoMarcar;
        $vetRetorno['servicos'] = $vetServicosPer;
        $vetRetorno['data_hora_marcacao_inicial'] = $data_hora_marcacao_inicial;

        BuscaGrupoHorario($idt_atendimento_agenda, $idt_servico, $vetRetorno);
        //
    } else {
        // erro-> sem agenda pai.  
    }


    $vetRetorno['textdebag'] = $textdebag;
}

//
// Buscar Agendas Consecutivas
//
function BuscaGrupoHorario($idt_atendimento_agenda, $idt_servico, &$vetRetorno) {
    //
    $menorperiodo = $vetRetorno['menorperiodo'];
    $quantidade_marcar = $vetRetorno['quantidade_marcar'];
    $periodoMarcar = $vetRetorno['periodo_marcar'];
    $vetServicosPer = $vetRetorno['servicos'];
    $data_hora_marcacao_inicial = $vetRetorno['data_hora_marcacao_inicial'];
    //	
    //$vetServicosPer=Array();
    $vetAgenda = Array();
    $vetfilhos = Array();
    $vetOutrasHoras = Array();
    // Acessar a Agenda como pai (Raiz)
    $sql = "select  ";
    $sql .= " grc_a.*  ";
    $sql .= " from " . db_pir_grc . "grc_atendimento_agenda grc_a ";
    $sql .= ' where idt = ' . null($idt_atendimento_agenda);
    $rs = execsql($sql);
    if ($rs->rows > 0) {
        ForEach ($rs->data as $row) {
            $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
            $idt_consultor = $row['idt_consultor'];
            $idt_cliente = $row['idt_cliente'];
            //$idt_especialidade     = $row['idt_especialidade'];
            $data = $row['data'];
            $hora = $row['hora'];
            $origem = $row['origem'];
            $situacao = $row['situacao'];
            //$data_hora_marcacao_inicial = $row['data_hora_marcacao_inicial']; 
        }
        $hora_menor = $hora;
        $hora_aux = $hora;
        $quantidade_marcar_filhos = $quantidade_marcar - 1;
        //$quantidade_marcar_filhos = $quantidade_marcar ;
        $hora_final = $hora;
        $hora_menor_trab = $hora;
        for ($c = 0; $c < $quantidade_marcar_filhos; $c++) {
            // somar o Menor Periodo
            $vet = explode(':', $hora_aux);
            $hh = $vet[0];
            $mm = $vet[1];

            //
            $MM_aux = $mm + $menorperiodo;
            $HH_aux = $hh + 0;

            if ($MM_aux >= 60) {
                $MM_aux = $MM_aux - 60;
                $HH_aux = $HH_aux + 1;
            }

            if ($HH_aux < 10) {
                $HH_aux = '0' . (string) $HH_aux;
            }
            if ($MM_aux < 10) {
                $MM_aux = '0' . (string) $MM_aux;
            }
            $hora_aux = $HH_aux . ":" . $MM_aux;
            $vetOutrasHoras[$hora_aux] = $hora_aux;
            $hora_final = $hora_aux;
        }

        //////////////// Hora final do atendimento
        $vet = explode(':', $hora_final);
        $hh = $vet[0];
        $mm = $vet[1];

        //
        $MM_aux = $mm + ($menorperiodo - 1);
        $HH_aux = $hh + 0;

        if ($MM_aux >= 60) {
            $MM_aux = $MM_aux - 60;
            $HH_aux = $HH_aux + 1;
        }

        if ($HH_aux < 10) {
            $HH_aux = '0' . (string) $HH_aux;
        }
        if ($MM_aux < 10) {
            $MM_aux = '0' . (string) $MM_aux;
        }
        $hora_aux = $HH_aux . ":" . $MM_aux;
        $hora_final = $hora_aux;

        //
        //  Agrupar Agendas 
        //
		$sql = "select  ";
        $sql .= " grc_a.*  ";
        $sql .= " from " . db_pir_grc . "grc_atendimento_agenda grc_a ";
        $sql .= ' where idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
        $sql .= '   and idt_consultor         = ' . null($idt_consultor);
        $sql .= '   and data                  = ' . aspa($data);
        $sql .= '   and origem                = ' . aspa($origem);
        $sql .= '   and situacao              = ' . aspa('Agendado');
        $rst = execsql($sql);
        if ($rst->rows > 0) {
            ForEach ($rst->data as $row) {
                $idt_atendimento_agenda = $row['idt'];
                $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
                $idt_consultor = $row['idt_consultor'];
                $idt_cliente = $row['idt_cliente'];
                ///////$idt_especialidade     = $row['idt_especialidade'];
                $data = $row['data'];
                $hora = $row['hora'];
                $origem = $row['origem'];
                $situacao = $row['situacao'];
                $servicos_idt = $row['servicos_idt'];
                $semmarcacao = $row['semmarcacao'];
                //
                // tem que ser da mesma especialidade
                // Essa condicao fura a Lógica traçada de dar sempre multiplos 
                // Dará certo se para um mesmo pa, atendente e data em todos os horários ele atende os mesmos serviços
                //	
                $vet = explode('#', $servicos_idt);
                $tam = count($vet);
                $vetp = Array();
                for ($c = 0; $c < $tam; $c++) {
                    $vetp[$vet[$c]] = $vet[$c];
                }
//p($vet);
//p($vetp);
//p($idt_servico);
                if ($vetp[$idt_servico] > 0) {

// echo " -------------------------- ";
                    $vetAgenda[$idt_atendimento_agenda] = $hora; // Hora da agenda
                    if ($vetOutrasHoras[$hora] != '') {
                        $vetFilhos[$idt_atendimento_agenda] = $hora; // Hora da agenda
                    }
                }
            }
        }
        //
    } else {
        // erro-> sem agenda pai.  
    }
    $vetRetorno['hora_final'] = $hora_final;
    $vetRetorno['agenda_livre'] = $vetAgenda;
    $vetRetorno['agenda_outras_horas'] = $vetOutrasHoras;
    $vetRetorno['agenda_filhos'] = $vetFilhos;

    $vetRetorno['qtd_agenda_livre'] = count($vetFilhos);
    //	
//	p($vetRetorno);
    ForEach ($vetAgenda as $idt_atendimento_agenda => $hora) {
        
    }
}

function AjustaImgEmail(&$corpoemail) {
    $vetReplace = Array(
        '/sebrae_grc/admin/fckupload/',
        '/sebrae_bia/admin/fckupload/',
    );

    foreach ($vetReplace as $value) {
        $html = str_replace($value, url_pai . $value, $corpoemail);
    }
}

function CarregaParametrosGeraisAgendamento() {
    // Carregar parâmetros Gerais para Agendamento
    $_SESSION[CS]['ParametrosGeraisAgenda'] = Array();
    $sql = "select  ";
    $sql .= " grc_ap.*  ";
    $sql .= " from " . db_pir_grc . "grc_agenda_parametro grc_ap ";
    $sql .= ' where idt = 1 ';
    $rst = execsqlNomeCol($sql);
    if ($rst->rows > 0) {
        ForEach ($rst->data as $row) {
            $idt = $row['idt'];
            $mesmo_dia = $row['mesmo_dia'];
            $abstencao_dias = $row['abstencao_dias'];
            $multiplos_agendamentos = $row['multiplos_agendamentos'];
            $tolerancia_atraso = $row['tolerancia_atraso'];
            $envia_sms_confirmacao = $row['envia_sms_confirmacao'];
            $prazo_sms_confirmacao = $row['prazo_sms_confirmacao'];
            $texto_sms_confirmacao = $row['texto_sms_confirmacao'];
            $envia_sms_cancelamento = $row['envia_sms_cancelamento'];
            $prazo_sms_cancelamento = $row['prazo_sms_cancelamento'];
            $texto_sms_cancelamento = $row['texto_sms_cancelamento'];
            $envia_sms_vespera = $row['envia_sms_vespera'];
            $prazo_sms_vespera = $row['prazo_sms_vespera'];
            $texto_sms_vespera = $row['texto_sms_vespera'];
            $envia_sms_agradecimento = $row['envia_sms_agradecimento'];
            $prazo_sms_agradecimento = $row['prazo_sms_agradecimento'];
            $texto_sms_agradecimento = $row['texto_sms_agradecimento'];
            $envia_sms_cancelamento_sebrae = $row['envia_sms_cancelamento_sebrae'];
            $prazo_sms_cancelamento_sebrae = $row['prazo_sms_cancelamento_sebrae'];
            $texto_sms_cancelamento_sebrae = $row['texto_sms_cancelamento_sebrae'];
            $_SESSION[CS]['ParametrosGeraisAgenda'] = $row;
        }
    } else {
        // Erro - Não pode carregar Parâmetros Gerais da Agendamento
    }
}

function RegistrarAvaliacaoEstrelinha(&$vetRetorno, $trata_erro = true) {
    $kokw = 0;

    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from ' . db_pir_grc . 'grc_formulario';
    $sql .= " where codigo = '700' and grupo = 'MEDE'";
    $rs = execsql($sql, $trata_erro);
    $idt_formulario = $rs->data[0][0];

    $vetResposta = Array();

    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from ' . db_pir_grc . 'grc_formulario_secao';
    $sql .= ' where idt_formulario = ' . null($idt_formulario);
    $rs = execsql($sql, $trata_erro);

    foreach ($rs->data as $row) {
        $idt_secao = $row['idt'];
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from ' . db_pir_grc . 'grc_formulario_pergunta';
        $sql .= ' where idt_secao = ' . null($idt_secao);
        $rs = execsql($sql, $trata_erro);
        foreach ($rs->data as $row) {
            $idt_pergunta = $row['idt'];
            $sql = '';
            $sql .= ' select idt, codigo';
            $sql .= ' from ' . db_pir_grc . 'grc_formulario_resposta';
            $sql .= ' where idt_pergunta = ' . null($idt_pergunta);
            $rs = execsql($sql, $trata_erro);
            foreach ($rs->data as $row) {
                $codigo = $row['codigo'];
                $idt_resposta = $row['idt'];
                $vetResposta[$idt_formulario][$idt_secao][$idt_pergunta][$codigo] = $idt_resposta;
            }
        }
    }

    $idt_produto = $vetRetorno['idt_produto'];
    $idt_evento = $vetRetorno['idt_evento'];
    $cpf = FormataCPF12($vetRetorno['cpf']);
    $email_avaliador = $vetRetorno['email_avaliador'];
    $nome_avaliador = $vetRetorno['nome_avaliador'];
    $telefone_avaliador = $vetRetorno['telefone_avaliador'];
    $avaliacao = $vetRetorno['avaliacao'];
    $data_avaliacao = $vetRetorno['data_avaliacao'];
    $resposta_txt = $vetRetorno['depoimento'];
    $origem = $vetRetorno['origem'];

    if ($data_avaliacao == '') {
        $data_avaliacao = getdata(true, true, true);
    }

    if ($origem == '') {
        $origem = 'CRM';
    }

    if ($idt_produto == '') {
        $sql = '';
        $sql .= ' select idt_produto';
        $sql .= ' from ' . db_pir_grc . 'grc_evento';
        $sql .= ' where idt = ' . null($idt_evento);
        $rs = execsql($sql, $trata_erro);
        $idt_produto = $rs->data[0][0];
    }

    if ($idt_evento == '') {
        if ($cpf == '') {
            $codigo = $email_avaliador . "_" . $idt_formulario . "_" . $idt_produto;
        } else {
            $codigo = $cpf . "_" . $idt_formulario . "_" . $idt_produto;
        }
    } else {
        $codigo = $cpf . "_" . $idt_formulario . "_" . $idt_evento;
    }

    // Criar grc_avaliacao
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade';
    $sql .= ' where codigo = ' . aspa(FormataCPF12($cpf));
    $sql .= " and reg_situacao = 'A'";
    $rs = execsql($sql, $trata_erro);
    $idt_avaliador = $rs->data[0][0];

    $sqlt = ' select grc_a.idt';
    $sqlt .= ' from ' . db_pir_grc . 'grc_avaliacao grc_a';
    $sqlt .= ' where ';
    $sqlt .= '   grc_a.codigo              = ' . aspa($codigo);
    $sqlt .= " and grc_a.grupo = 'CRM-ESTRELINHA'";
    $rst = execsql($sqlt, $trata_erro);

    if ($rst->rows == 0) {
        $sql = 'insert into ' . db_pir_grc . 'grc_avaliacao (';
        $sql .= " origem, ";
        $sql .= " codigo, ";
        $sql .= " descricao, ";
        $sql .= " idt_responsavel_registro, ";
        $sql .= " idt_avaliador, ";
        $sql .= " data_avaliacao, ";
        $sql .= " data_registro, ";
        $sql .= " idt_formulario, ";
        $sql .= " idt_situacao, ";
        $sql .= " idt_pfo_af_processo, ";
        $sql .= " idt_produto, ";
        $sql .= " idt_evento, ";
        $sql .= " cpf, ";
        $sql .= " email_avaliador, ";
        $sql .= " nome_avaliador, ";
        $sql .= " telefone_avaliador, ";
        $sql .= " grupo ";
        $sql .= ') values (';
        $sql .= aspa($origem) . ', ';
        $sql .= aspa($codigo) . ', ';
        $sql .= aspa($row['chaveorigem']) . ', ';
        $sql .= null($_SESSION[CS]['g_id_usuario_sistema']['GRC']) . ', ';
        $sql .= null($idt_avaliador) . ', ';
        $sql .= aspa(trata_data($data_avaliacao, true)) . ', ';
        $sql .= 'now()' . ' , ';
        $sql .= null($idt_formulario) . ', ';
        $sql .= 1 . ', ';
        $sql .= 'null' . ', ';
        $sql .= null($idt_produto) . ', ';
        $sql .= null($idt_evento) . ', ';
        $sql .= aspa($cpf) . ', ';
        $sql .= aspa($email_avaliador) . ', ';
        $sql .= aspa($nome_avaliador) . ', ';
        $sql .= aspa($telefone_avaliador) . ', ';
        $sql .= "'CRM-ESTRELINHA'";

        $sql .= ')';
        execsql($sql, $trata_erro);
        $idt_avaliacao = lastInsertId();
        $vetRetorno['idt_avaliacao'] = $idt_avaliacao;
    } else {
        foreach ($rst->data as $rowt) {
            $idt_avaliacao = $rowt['idt'];
        }
        $vetRetorno['idt_avaliacao'] = $idt_avaliacao;

        $sql_a = ' update ' . db_pir_grc . 'grc_avaliacao set ';
        $sql_a .= " data_avaliacao =  " . aspa(trata_data($data_avaliacao, true));
        $sql_a .= ' where idt  = ' . null($idt_avaliacao) . '  ';
        execsql($sql_a, $trata_erro);
    }

    $qtd_pontos = (($avaliacao - 1) * 25);

    $sqlt = ' select grc_ar.idt';
    $sqlt .= ' from ' . db_pir_grc . 'grc_avaliacao_resposta grc_ar';
    $sqlt .= ' where ';
    $sqlt .= '   grc_ar.idt_avaliacao      = ' . null($idt_avaliacao);
    $sqlt .= '   and grc_ar.idt_secao      = ' . null($idt_secao);
    $sqlt .= '   and grc_ar.idt_pergunta   = ' . null($idt_pergunta);
    $rst = execsql($sqlt, $trata_erro);

    $idt_resposta = $vetResposta[$idt_formulario][$idt_secao][$idt_pergunta][$avaliacao];

    if ($rst->rows == 0) {
        $sql = "insert into " . db_pir_grc . "grc_avaliacao_resposta ( ";
        $sql .= "idt_avaliacao, ";
        $sql .= "idt_formulario,";
        $sql .= "idt_secao, ";
        $sql .= "idt_pergunta, ";
        $sql .= "idt_resposta, ";
        $sql .= "qtd_pontos, ";
        $sql .= "resposta_txt";
        $sql .= ") values (";
        $sql .= null($idt_avaliacao) . ', ';
        $sql .= null($idt_formulario) . ', ';
        $sql .= null($idt_secao) . ', ';
        $sql .= null($idt_pergunta) . ', ';
        $sql .= null($idt_resposta) . ', ';
        $sql .= null($qtd_pontos) . ', ';
        $sql .= aspa($resposta_txt);
        $sql .= ')';
        execsql($sql, $trata_erro);
    } else {
        foreach ($rst->data as $rowt) {
            $idt_avaliacao_resposta = $rowt['idt'];
        }

        $idt_resposta = null($idt_resposta);
        $resposta_txt = aspa($resposta_txt);
        $qtd_pontos = null($qtd_pontos);
        $sql_a = ' update ' . db_pir_grc . 'grc_avaliacao_resposta set ';
        $sql_a .= " idt_resposta       = {$idt_resposta} " . ", ";
        $sql_a .= " qtd_pontos         = {$qtd_pontos} " . ", ";
        $sql_a .= " resposta_txt       = {$resposta_txt} " . "  ";
        $sql_a .= ' where idt  = ' . null($idt_avaliacao_resposta) . '  ';
        $result = execsql($sql_a, $trata_erro);
    }

    $kokw = 1;
    return $kokw;
}

// Média do Evento
function AvaliacaoEstrelinhaMediaEvento($idt_evento) {
    $total_pontos = 0;
    $quantidade = 0;
    $mediaw = 0;
    $media = "";
    $sqlt = " select ";
    $sqlt .= " sum(grc_fr.codigo) as total_pontos, ";
    $sqlt .= " count(grc_a.idt) as  quantidade ";
    $sqlt .= " from grc_avaliacao grc_a";
    $sqlt .= " inner join `db_pir_grc`.`grc_evento`   grc_e on grc_e.idt = grc_a.idt_evento ";
    $sqlt .= " inner join `db_pir_grc`.`grc_produto`  grc_p on grc_p.idt = grc_e.idt_produto ";
    $sqlt .= " inner join `db_pir_grc`.`grc_avaliacao_resposta`  grc_ar on grc_ar.idt_avaliacao = grc_a.idt ";
    $sqlt .= " inner join `db_pir_grc`.`grc_formulario_resposta` grc_fr on grc_fr.idt = grc_ar.idt_resposta ";
    $sqlt .= " inner join `db_pir_grc`.`grc_formulario` grc_f on grc_f.idt = grc_a.idt_formulario ";
    $sqlt .= " where grc_f.codigo = '700' ";
    $sqlt .= "   and grc_a.idt_evento = " . null($idt_evento);
    $rst = execsql($sqlt);
    if ($rst->rows == 0) {
        
    } else {
        foreach ($rst->data as $rowt) {
            $total_pontos = $rowt['total_pontos'];
            $quantidade = $rowt['quantidade'];
            if ($total_pontos > 0 and $quantidade > 0) {
                //$mediaw = (($total_pontos / $quantidade) / 25) + 1;
				
				$resto = $total_pontos%$quantidade;
				$mais=1;
				if ($resto==0)
				{
				    $mais=0; 
				}
                //$mediaw = (($total_pontos / $quantidade) / 25) + $mais;
				$mediaw = ($total_pontos / $quantidade) ;
				
				
            }
            $media = format_decimal($mediaw, 1);
        }
    }
    $img = AvaliacaoFazImagem($mediaw, 1, $idt_evento, '');
    $vet['quantidade'] = $quantidade;
    $vet['total_pontos'] = $total_pontos;
    $vet['media'] = $media;
    $vet['imagem'] = $img;
    return $vet;
}

// Média do Produto
function AvaliacaoEstrelinhaMediaProduto($idt_produto) {
    $total_pontos = 0;
    $quantidade = 0;
    $mediaw = 0;
    $media = "";
    $sqlt = " select ";
    $sqlt .= " sum(grc_fr.codigo) as total_pontos, ";
    $sqlt .= " count(grc_a.idt) as quantidade ";
    $sqlt .= " from grc_avaliacao grc_a";

    $sqlt .= " left join `db_pir_grc`.`grc_evento`   grc_e on grc_e.idt = grc_a.idt_evento ";
    $sqlt .= " left join `db_pir_grc`.`grc_produto`  grc_p on grc_p.idt = grc_e.idt_produto ";

    $sqlt .= " inner join `db_pir_grc`.`grc_avaliacao_resposta`  grc_ar on grc_ar.idt_avaliacao = grc_a.idt ";
    $sqlt .= " inner join `db_pir_grc`.`grc_formulario_resposta` grc_fr on grc_fr.idt = grc_ar.idt_resposta ";

    //$sqlt .= " where grc_a.idt_formulario = 14 ";

    $sqlt .= " inner join `db_pir_grc`.`grc_formulario` grc_f on grc_f.idt = grc_a.idt_formulario ";
    $sqlt .= " where grc_f.codigo = '700' ";


    $sqlt .= "   and grc_a.idt_produto = " . null($idt_produto);
	
	
    $rst = execsql($sqlt);
   // p($sqlt);
    if ($rst->rows == 0) {
        
    } else {
        foreach ($rst->data as $rowt) {
//p($rowt);
            $total_pontos = $rowt['total_pontos'];
            $quantidade   = $rowt['quantidade'];
            // $mediaw = (($total_pontos / $quantidade) / 25) + 1;
            if ($total_pontos > 0 and $quantidade > 0) {
			    $resto = $total_pontos%$quantidade;
				$mais=1;
				if ($resto==0)
				{
				    $mais=0; 
				}
                //$mediaw = (($total_pontos / $quantidade) / 25) + $mais;
				$mediaw = ($total_pontos / $quantidade) ;
            }
            $media = format_decimal($mediaw, 1);
        }
    }
	
	
    $img = AvaliacaoFazImagem($mediaw, 2, $idt_produto, '');
    $vet['quantidade'] = $quantidade;
    $vet['total_pontos'] = $total_pontos;
    $vet['media'] = $media;
    $vet['imagem'] = $img;
//p($vet);
    return $vet;
}

// Média do Cliente
function AvaliacaoEstrelinhaMediaCliente($cpf) {
    $total_pontos = 0;
    $quantidade = 0;
    $mediaw = 0;
    $media = "";
    $sqlt = " select ";
    $sqlt .= " sum(grc_fr.codigo) as total_pontos, ";
    $sqlt .= " count(grc_a.idt) as quantidade ";
    $sqlt .= " from grc_avaliacao grc_a";
    $sqlt .= " inner join `db_pir_grc`.`grc_evento`   grc_e on grc_e.idt = grc_a.idt_evento ";
    $sqlt .= " inner join `db_pir_grc`.`grc_produto`  grc_p on grc_p.idt = grc_e.idt_produto ";
    $sqlt .= " inner join `db_pir_grc`.`grc_avaliacao_resposta`  grc_ar on grc_ar.idt_avaliacao = grc_a.idt ";
    $sqlt .= " inner join `db_pir_grc`.`grc_formulario_resposta` grc_fr on grc_fr.idt = grc_ar.idt_resposta ";
    //$sqlt .= " where grc_a.idt_formulario = 14 ";
    $sqlt .= " inner join `db_pir_grc`.`grc_formulario` grc_f on grc_f.idt = grc_a.idt_formulario ";
    $sqlt .= " where grc_f.codigo = '700' ";

    $sqlt .= "   and grc_a.cpf = " . aspa($cpf);
    $rst = execsql($sqlt);
    if ($rst->rows == 0) {
        
    } else {
        foreach ($rst->data as $rowt) {
            $total_pontos = $rowt['total_pontos'];
            $quantidade = $rowt['quantidade'];
            //$mediaw = (($total_pontos / $quantidade) / 25) + 1;
            if ($total_pontos > 0 and $quantidade > 0) {
                //$mediaw = (($total_pontos / $quantidade) / 25) + 1;
				$resto = $total_pontos%$quantidade;
				$mais=1;
				if ($resto==0)
				{
				    $mais=0; 
				}
                //$mediaw = (($total_pontos / $quantidade) / 25) + $mais;
				$mediaw = ($total_pontos / $quantidade );
				
            }

            $media = format_decimal($mediaw, 1);
        }
    }
    $img = AvaliacaoFazImagem($mediaw, 3, 0, $cpf);
    $vet['quantidade'] = $quantidade;
    $vet['total_pontos'] = $total_pontos;
    $vet['media'] = $media;
    $vet['imagem'] = $img;

    return $vet;
}

function AvaliacaoFazImagem($mediaw, $opcao, $idt, $cpf) {
    //$mediaw=4.3;
    $img = "";
    // define as estrelas
    $est1 = "imagens/estrelinha.png";
    $est2 = "imagens/estrelinha.png";
    $est3 = "imagens/estrelinha.png";
    $est4 = "imagens/estrelinha.png";
    $est5 = "imagens/estrelinha.png";

    if ($mediaw > 0 and $mediaw <= 0.5) {
        $est1 = "imagens/estrelinha_2.png";
    }
    if ($mediaw > 0.5 and $mediaw <= 5) {
        $est1 = "imagens/estrelinha_1.png";
    }



    if ($mediaw > 1 and $mediaw <= 1.5) {
        $est2 = "imagens/estrelinha_2.png";
    }
	
    if ($mediaw > 1.5 and $mediaw <= 5) {
        $est2 = "imagens/estrelinha_1.png";
		
		
		
    }
    if ($mediaw > 2 and $mediaw <= 2.5) {
        $est3 = "imagens/estrelinha_2.png";
    }
    if ($mediaw > 2.5 and $mediaw <= 5) {
        $est3 = "imagens/estrelinha_1.png";
    }

    if ($mediaw > 3 and $mediaw <= 3.5) {
        $est4 = "imagens/estrelinha_2.png";
    }
    if ($mediaw > 3.5 and $mediaw <= 5) {
        $est4 = "imagens/estrelinha_1.png";
    }

    if ($mediaw > 4 and $mediaw <= 4.5) {
        $est5 = "imagens/estrelinha_2.png";
    }
    if ($mediaw > 4.5 and $mediaw <= 5) {
        $est5 = "imagens/estrelinha_1.png";
    }
    $sty = "";
    $onclick = "";
    if ($opcao == 1) {
        //$sty = "cursor:pointer; background:#A1A1A1;";
        $sty = "cursor:pointer; background:#FFFFFF;";
        $onclick = " onclick='return AvaliacoesEvento($idt)' ";
    }
    if ($opcao == 2) {
        $sty = "cursor:pointer; background:#FFFFFF;";
        $onclick = " onclick='return AvaliacoesProduto($idt)' ";
    }

    if ($opcao == 3) {
        $sty = "cursor:pointer; background:#FFFFFF;";
        $onclick = " onclick='return AvaliacoesCliente(" . '"' . $cpf . '"' . ");' ";
    }
    $hint = "Média {$mediaw}";
    $img .= "<style>";
    $img .= ".div1_estrela { ";
    //$img .= "background:#FFFFFF; ";
    //$img .= "color:#000000; ";
    //$img .= "";
    $img .= "} ";
    $img .= ".estrela { ";
    $img .= "width:20px; ";
    $img .= "height:20px; ";
    $img .= "} ";
    $img .= "</style>";
    $img .= " <div {$onclick} title='{$hint}' class='div1_estrela' style=' {$sty} height:23px; float:left; padding-left:10px;  padding-top:5px;  '>";
    $img .= " <div   style='float:left;  padding-right:3px;'>";
    $img .= " <img   id='est1{$idt_evento}'   class='estrela' src='{$est1}' border='0'>";
    $img .= " </div>";
    $img .= " <div style='float:left;  padding-right:3px;'>";
    $img .= " <img  id='est2{$idt_evento}'  class='estrela' src='{$est2}' border='0'>";
    $img .= " </div>";
    $img .= " <div  style='float:left;  padding-right:3px;'>";
    $img .= " <img   id='est3{$idt_evento}'  class='estrela' src='{$est3}' border='0'>";
    $img .= " </div>";
    $img .= " <div  style='float:left;  padding-right:3px;'>";
    $img .= " <img   id='est4{$idt_evento}'   class='estrela' src='{$est4}' border='0'>";
    $img .= " </div>";
    $img .= " <div style='float:left;  padding-right:3px;'>";
    $img .= " <img id='est5{$idt_evento}'  class='estrela' src='{$est5}' border='0'>";
    $img .= " </div>";
    $img .= " </div>";
    $img .= " <script>";
    $img .= " function AvaliacoesEvento(idt) ";
    $img .= " { ";
    //$img .= "   alert(	' idt_evento: '+idt);";
    $img .= "   var parww  = '&idt_evento='+idt+'&opcao=1'; ";
    $img .= "   var href   = 'conteudo_detalha_av.php?prefixo=inc&menu=detalha_av'+parww; ";
    $img .= "   var height = $(window).height() - 50; ";
    $img .= "   var width  = $(window).width()  - 150;";
    $img .= "   var titulo = " . ' "<div style= ' . "'width:700px; display:block; text-align:center; '>Avaliações do Evento</div>; " . '";';
    $img .= "   showPopWin(href, titulo , width, height, close_DetalhaPA); ";
    $img .= "   return false; ";
    $img .= " } ";
    $img .= " function AvaliacoesProduto(idt) ";
    $img .= " { ";
    //$img .= "   alert(	' idt_produto: '+idt);";
    $img .= "   var parww  = '&idt_produto='+idt+'&opcao=2'; ";
    $img .= "   var href   = 'conteudo_detalha_av.php?prefixo=inc&menu=detalha_av'+parww; ";
    $img .= "   var height = $(window).height() - 50; ";
    $img .= "   var width  = $(window).width()  - 150;";
    $img .= "   var titulo = " . ' "<div style= ' . "'width:700px; display:block; text-align:center; '>Avaliações do Produto </div>; " . '";';
    $img .= "   showPopWin(href, titulo , width, height, close_DetalhaPA); ";
    $img .= "   return false; ";
    $img .= " } ";
    $img .= " function AvaliacoesCliente(cpf) ";
    $img .= " { ";
    //$img .= "   alert(	' cpf: '+cpf);";
    $img .= "   var parww  = '&cpf='+cpf+'&opcao=3'; ";
    $img .= "   var href   = 'conteudo_detalha_av.php?prefixo=inc&menu=detalha_av'+parww; ";
    $img .= "   var height = $(window).height() - 50; ";
    $img .= "   var width  = $(window).width() - 150;";
    $img .= "   var titulo = " . ' "<div style= ' . "'width:700px; display:block; text-align:center; '>Avaliações do Cliente </div>; " . '";';
    $img .= "   showPopWin(href, titulo , width, height, close_DetalhaPA); ";
    $img .= "   return false; ";
    $img .= " } ";
    $img .= " function close_DetalhaPA(returnVal) {  ";
    $img .= " } ";
    $img .= " </script>";
    return $img;
}

function PreparaAcaoEvento(&$vet) {
    $idt_instrumento = $_POST['idt_instrumento'];
    $idt_evento = $_POST['idt_evento'];
    $idt_acao = $_POST['idt_acao'];
    $ano_competencia = $_POST['ano_competencia'];
    $participacao_sebrae = $_POST['participacao_sebrae'];

    $whereAIM = 'aim.idt_atendimento_instrumento = pam.idt_instrumento and aim.ano = pam.ano and aim.idt_atendimento_metrica = pam.idt_metrica';

    if ($idt_instrumento == 45 || $idt_instrumento == 41) {
        $whereAIM .= ' and aim.participacao_sebrae = ' . aspa($participacao_sebrae);
    }

    $sql = '';
    $sql .= ' select sum(pam.quantitativo) as qtd';
    $sql .= ' from ' . db_pir_grc . 'grc_projeto_acao_meta pam';
    $sql .= ' inner join ' . db_pir_grc . 'grc_atendimento_instrumento_metrica aim on ' . $whereAIM;
    $sql .= ' where pam.idt_projeto_acao = ' . null($idt_acao);
    $sql .= ' and pam.ano = ' . aspa($ano_competencia);
    $sql .= ' and pam.idt_instrumento in (';
    $sql .= ' select aif.idt';
    $sql .= ' from ' . db_pir_grc . 'grc_atendimento_instrumento aif';
    $sql .= ' inner join ' . db_pir_grc . 'grc_atendimento_instrumento aip on substring(aip.codigo, 1, 2) = substring(aif.codigo, 1, 2)';
    $sql .= ' where aip.idt = ' . null($idt_instrumento);
    $sql .= ' )';
    $rs = execsql($sql, false);
    $qtd_previsto = Troca($rs->data[0][0], '', 0);

    $sql = '';
    $sql .= ' select count(idt) as tot';
    $sql .= ' from ' . db_pir_grc . 'grc_evento';
    $sql .= ' where idt_acao = ' . null($idt_acao);
    $sql .= ' and idt_instrumento = ' . null($idt_instrumento);
    $sql .= ' and ano_competencia = ' . aspa($ano_competencia);
    $sql .= ' and idt_evento_situacao = 20';
    $rs = execsql($sql, false);
    $qtd_realizado = Troca($rs->data[0][0], '', 0);

    if ($qtd_previsto == 0) {
        $qtd_percentual = 0;
    } else {
        $qtd_percentual = $qtd_realizado / $qtd_previsto * 100;
    }

    $qtd_saldo = $qtd_previsto - $qtd_realizado;

    $SoapSebraeRM = new SoapSebraeRMGeral('wsConsultaSQL');

    $sql = '';
    $sql .= ' select codigo_sge, nomegestor, idt_responsavel, idt_unidade, contrapartida_sgtec';
    $sql .= ' from ' . db_pir_grc . 'grc_projeto_acao';
    $sql .= ' where idt = ' . null($idt_acao);
    $rs = execsql($sql);
    $row = $rs->data[0];

    $vet['gestor_sge'] = $row['nomegestor'];
    $vet['idt_gestor_projeto'] = $row['idt_responsavel'];
    $vet['idt_unidade'] = $row['idt_unidade'];
    $vet['contrapartida_sgtec'] = format_decimal($row['contrapartida_sgtec']);

    $parametro = Array(
        'codSentenca' => 'WS_PRI_SGEvRM',
        'codColigada' => '1',
        'codAplicacao' => 'T',
        'parameters' => 'GUIDACAOSGE=' . $row['codigo_sge'],
    );
    $rsRM = $SoapSebraeRM->executa('RealizarConsultaSQLAuth', Array('Resultado'), $parametro, true);
    $rowRM = $rsRM['Resultado']->data[0];
    $CODCCUSTO = $rowRM['cod_projeto_rm'] . '.' . $rowRM['cod_acao_rm'];

    $parametro = Array(
        'codSentenca' => 'WS_PIR_CONSSALDO',
        'codColigada' => '1',
        'codAplicacao' => 'T',
        'parameters' => 'CODCCUSTO=' . $CODCCUSTO . ';ANO=' . $ano_competencia . ';MES=12',
    );
    $rsRM = $SoapSebraeRM->executa('RealizarConsultaSQLAuth', Array('Resultado'), $parametro, true);
    $rowRM = $rsRM['Resultado']->data[0];

    $orc_previsto = Troca($rowRM['previsto_acumulado'], '', 0);
    $orc_realizado = Troca($rowRM['realizado_acumulado'] + $rowRM['comprometido_acumulado'], '', 0);
    $orc_saldo = Troca($rowRM['saldo_acumulado_disponivel'], '', 0);

    if ($orc_previsto == 0) {
        $orc_percentual = 0;
    } else {
        $orc_percentual = $orc_realizado / $orc_previsto * 100;
    }

    $vet['qtd_previsto'] = format_decimal($qtd_previsto, 0);
    $vet['qtd_realizado'] = format_decimal($qtd_realizado, 0);
    $vet['qtd_percentual'] = format_decimal($qtd_percentual, 2);
    $vet['qtd_saldo'] = format_decimal($qtd_saldo, 0);
    $vet['orc_previsto'] = format_decimal($orc_previsto, 2);
    $vet['orc_realizado'] = format_decimal($orc_realizado, 2);
    $vet['orc_percentual'] = format_decimal($orc_percentual, 2);
    $vet['orc_saldo'] = format_decimal($orc_saldo, 2);
    return true;
}

// Monta Politica de Vendas
function MontaWherePoliticaVendas(&$vetParametro) {
    $kokw = 0;

    $vetCondicao = Array();
    $vetCondicao['='] = 'Igual a';
    $vetCondicao['<>'] = 'Diferende de';
    $vetCondicao['>'] = 'Maior do que';
    $vetCondicao['<'] = 'Menor do que';
    $vetCondicao['>='] = 'Maior ou Idual a';
    $vetCondicao['<='] = 'Menor ou Igual a';
    $vetCondicao['like'] = 'Contem';


    $condicaoHtml = "";
    $expressao = "";
    $where = "";
    $idt_politica_vendas = $vetParametro['idt_politica_vendas'];
    $tipo = $vetParametro['tipo'];
    if ($tipo == '') {
        $tipo = 'P';
    }
    $sqlt = " select grc_pvco.*, ";
    $sqlt .= "        grc_ppc.tipo as grc_ppc_tipo ";

    $sqlt .= " from grc_politica_vendas_condicao grc_pvco";
    $sqlt .= " inner join grc_politica_parametro_campos grc_ppc on grc_ppc.codigo = grc_pvco.codigo ";
    $sqlt .= " where grc_pvco.idt_politica_vendas = " . null($idt_politica_vendas);
    $sqlt .= "   and grc_pvco.tipo = " . aspa($tipo);
    $sqlt .= " order by grc_pvco.ordem ";
    $rst = execsql($sqlt);
    if ($rst->rows == 0) {
        
    } else {

        //$condicaoHtml.="<div style='width:50%; float:left; '>";
        $condicaoHtml .= "<div style='width:100%; '>";

        $condicaoHtml .= "<table style='width:100%; '>";
        $condicaoHtml .= "<tr>";
        $condicaoHtml .= "<td colspan='7' style='background:#F1F1F1; width:100%;'>Expressão da Condição</td>";
        $condicaoHtml .= "</tr>";
        foreach ($rst->data as $rowt) {
            $condicaoHtml .= "<tr>";
            $ordem = $rowt['ordem'];
            $grc_ppc_tipo = $rowt['grc_ppc_tipo'];
            $parentese_ant = $rowt['parentese_ant'];
            $parentese_dep = $rowt['parentese_dep'];
            $codigo = $rowt['codigo'];
            $condicao = $rowt['condicao'];
            $valor = $rowt['valor'];
            $operador = $rowt['operador'];
            $condicaow = $vetCondicao[$condicao];

            $expressao .= "{$parentese_ant} {$codigo} {$condicao} {$valor} {$parentese_dep} {$operador}<br />";
            if ($operador == 'and') {
                $operadorw = " and ";
            } else {
                if ($operador == 'or') {
                    $operadorw = " or ";
                } else {
                    $operadorw = "";
                }
            }
            $valorw = $valor;
            if ($condicao == 'like') {
                $valorw = aspa("%" . $valor . "%");
            } else {
                if ($grc_ppc_tipo == 'varchar' or $grc_ppc_tipo == 'char' or $grc_ppc_tipo == 'text' or $grc_ppc_tipo == 'longtext') {
                    $valorw = aspa($valor);
                }
                if ($grc_ppc_tipo == 'data' or $grc_ppc_tipo == 'datatime') {
                    $valorw = aspa(trata_data($valor));
                }
            }
            $where .= "{$parentese_ant} {$codigo} {$condicao} {$valorw} {$parentese_dep} {$operadorw} ";


            $condicaoHtml .= "<td>{$ordem}</td>";
            $condicaoHtml .= "<td>{$parentese_ant}</td>";
            $condicaoHtml .= "<td>{$codigo}</td>";
            $condicaoHtml .= "<td>{$condicaow}</td>";
            $condicaoHtml .= "<td>{$valor}</td>";
            $condicaoHtml .= "<td>{$parentese_dep}</td>";
            $condicaoHtml .= "<td>{$operador}</td>";
            $condicaoHtml .= "</tr>";
        }
        $condicaoHtml .= "</table>";
        $condicaoHtml .= "</div>";
        /* 	
          $condicaoHtml.="<div style='width:50%; float:left; '>";
          $condicaoHtml.="<table style='width:100%; '>";
          $condicaoHtml.="<tr>";
          $condicaoHtml.="<td colspan='7' style='background:#F1F1F1; width:100%;'>$expressao</td>";
          $condicaoHtml.="</tr>";
          $condicaoHtml.="</table>";
          $condicaoHtml.="</div>";
         */

        $condicaoHtml .= "<div style='width:100%; margin-top:10px; '>";
        $condicaoHtml .= "<table style='width:100%; '>";
        $condicaoHtml .= "<tr>";
        $condicaoHtml .= "<td style='background:#F1F1F1; width:100%;'>Expressão SQL</td>";
        $condicaoHtml .= "</tr>";

        $condicaoHtml .= "<tr>";
        $condicaoHtml .= "<td colspan='7' style='background:#F1F1F1; width:100%;'>$where</td>";
        $condicaoHtml .= "</tr>";
        $condicaoHtml .= "</table>";
        $condicaoHtml .= "</div>";
    }
    $kokw = 1;
    $vetParametro['condicaoHtml'] = $condicaoHtml;
    $vetParametro['where'] = $where;

    return $kokw;
}

function GerarPoliticaVendasInc() {
    $datadia = trata_data(date('d/m/Y H:i:s'));
    $data_responsavel = aspa($datadia);
    $idt_responsavel = null($_SESSION[CS]['g_id_usuario']);
    $tabela = 'grc_politica_vendas';
    $Campo = 'codigo';
    $tam = 7;
    $codigow = numerador_arquivo($tabela, $Campo, $tam);
    $codigo = 'PV' . $codigow;
    $codigo = aspa($codigo);
    $descricao = aspa('Em cadastramento');
    $data_inicio = aspa(trata_data(date('d/m/Y')));
    $sql_i = ' insert into ' . db_pir_grc . 'grc_politica_vendas ';
    $sql_i .= ' (  ';
    $sql_i .= " codigo, ";
    $sql_i .= " descricao, ";
    $sql_i .= " idt_responsavel, ";
    $sql_i .= " data_responsavel, ";
    $sql_i .= " data_inicio ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $codigo, ";
    $sql_i .= " $descricao, ";
    $sql_i .= " $idt_responsavel, ";
    $sql_i .= " $data_responsavel, ";
    $sql_i .= " $data_inicio ";
    $sql_i .= ') ';
    $result = execsql($sql_i);
    $idt_politica_vendas = lastInsertId();
    // gravar tabelas associadas
    // Evento
    $vetTabelas = Array();
    $vetTabelas["db_pir_grc.grc_evento"]['alias'] = "evento";
    $vetTabelas["db_pir_grc.grc_evento"]['descr'] = "Tabela de Eventos";
    $vetTabelas["db_pir_grc.grc_produto"]['alias'] = "produto";
    $vetTabelas["db_pir_grc.grc_produto"]['descr'] = "Tabela de Produtos";
    $vetTabelas["db_pir_gec.gec_entidade"]['alias'] = "cliente";
    $vetTabelas["db_pir_gec.gec_entidade"]['descr'] = "Tabela de Clientes";
    foreach ($vetTabelas as $tabela => $vetatr) {
        $codigo = aspa($tabela);
        $descricao = aspa($vetTabelas[$tabela]['descr']);
        $alias = aspa($vetTabelas[$tabela]['alias']);
        $sql_i = ' insert into ' . db_pir_grc . 'grc_politica_vendas_tabelas ';
        $sql_i .= ' (  ';
        $sql_i .= " idt_politica_vendas, ";
        $sql_i .= " codigo, ";
        $sql_i .= " descricao, ";
        $sql_i .= " alias ";
        $sql_i .= '  ) values ( ';
        $sql_i .= " $idt_politica_vendas, ";
        $sql_i .= " $codigo, ";
        $sql_i .= " $descricao, ";
        $sql_i .= " $alias ";
        $sql_i .= ') ';
        $result = execsql($sql_i);
    }
    // Campos
    foreach ($vetTabelas as $tabela => $vetatr) {
        $alias_tabela = $vetTabelas[$tabela]['alias'];
        $sqlt = " select {$alias_tabela}.* ";
        $sqlt .= " from {$tabela} {$alias_tabela} ";
        $sqlt .= " where 1 = 2 ";
        $rst = execsql($sqlt);
        foreach ($rst->info['name'] as $indice => $campo) {
            // pega a descrição
            $sqlt = " select plu_pec.* ";
            $sqlt .= " from db_pir.plu_pl_ead plu_pe ";
            $sqlt .= " inner join db_pir.plu_pl_ead_campos plu_pec on  plu_pec.idt_plu_pl_ead = plu_pe.idt";
            $sqlt .= " where plu_pe.codigo = " . aspa($tabela);
            $sqlt .= "   and plu_pec.codigo = " . aspa($campo);

            $rst = execsql($sqlt);
            $descricao_campo = "";
            if ($rst->rows == 0) {
                
            } else {

                foreach ($rst->data as $rowt) {
                    $descricao_campo = $rowt['descricao'];
                }
            }
            if ($descricao_campo == '') {
                $descricao_campo = "{$alias_tabela}_{$campo} ";
            }
            $campow = "{$alias_tabela}.{$campo} ";
            $aliasw = "{$alias_tabela}_{$campo} ";
            $codigo = aspa($campow);
            $descricao = aspa($descricao_campo);
            $alias = aspa($aliasw);
            $sql_i = ' insert into ' . db_pir_grc . 'grc_politica_vendas_campos ';
            $sql_i .= ' (  ';
            $sql_i .= " idt_politica_vendas, ";
            $sql_i .= " codigo, ";
            $sql_i .= " descricao, ";
            $sql_i .= " alias ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " $idt_politica_vendas, ";
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao, ";
            $sql_i .= " $alias ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
        }
    }



//

    return $idt_politica_vendas;
}

function GerarPoliticaVendasParametroInc() {
    // Tabelas da Política de Vendas
    $vetTabelas = Array();
    $vetTabelas["db_pir_grc.grc_evento"]['alias'] = "evento";
    $vetTabelas["db_pir_grc.grc_evento"]['descr'] = "Tabela de Eventos";

    $vetTabelas["db_pir_grc.grc_produto"]['alias'] = "produto";
    $vetTabelas["db_pir_grc.grc_produto"]['descr'] = "Tabela de Produtos";

    $vetTabelas["db_pir_gec.gec_entidade"]['alias'] = "cliente";
    $vetTabelas["db_pir_gec.gec_entidade"]['descr'] = "Tabela de Clientes";

    foreach ($vetTabelas as $tabela => $vetatr) {
        $codigo = aspa($tabela);
        $descricao = aspa($vetTabelas[$tabela]['descr']);
        $alias = aspa($vetTabelas[$tabela]['alias']);

        $sqlt = " select grc_ppt.* ";
        $sqlt .= " from db_pir_grc.grc_politica_parametro_tabelas grc_ppt ";
        $sqlt .= " where codigo = $codigo ";
        $rst = execsql($sqlt);
        if ($rst->rows == 0) {

            $sql_i = ' insert into ' . db_pir_grc . 'grc_politica_parametro_tabelas ';
            $sql_i .= ' (  ';
            $sql_i .= " codigo, ";
            $sql_i .= " descricao, ";
            $sql_i .= " alias ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " $codigo, ";
            $sql_i .= " $descricao, ";
            $sql_i .= " $alias ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
            $idt_politica_parametro_tabelas = lastInsertId();
            //
            $alias_tabela = $vetTabelas[$tabela]['alias'];
            $sqlt = " select {$alias_tabela}.* ";
            $sqlt .= " from {$tabela} {$alias_tabela} ";
            $sqlt .= " where 1 = 2 ";
            $rst = execsql($sqlt);
            foreach ($rst->info['name'] as $indice => $campo) {
                // pega a descrição
                $sqlt = " select plu_pec.* ";
                $sqlt .= " from db_pir.plu_pl_ead plu_pe ";
                $sqlt .= " inner join db_pir.plu_pl_ead_campos plu_pec on  plu_pec.idt_plu_pl_ead = plu_pe.idt";
                $sqlt .= " where plu_pe.codigo = " . aspa($tabela);
                $sqlt .= "   and plu_pec.codigo = " . aspa($campo);

                $rst = execsql($sqlt);
                $descricao_campo = "";
                if ($rst->rows == 0) {
                    
                } else {

                    foreach ($rst->data as $rowt) {
                        $descricao_campo = $rowt['descricao'];
                        $tipo = $rowt['tipoCampoBase'];
                    }
                }
                if ($descricao_campo == '') {
                    $descricao_campo = "{$alias_tabela}_{$campo} ";
                }
                if ($tipo == '') {
                    $tipo = "varchar";
                }
                $campow = "{$alias_tabela}.{$campo} ";
                $aliasw = "{$alias_tabela}_{$campo} ";
                $codigo = aspa($campow);
                $descricao = aspa($descricao_campo);
                $alias = aspa($aliasw);
                $tipo = aspa($tipo);
                $status = aspa('A');
                $sql_i = ' insert into ' . db_pir_grc . 'grc_politica_parametro_campos ';
                $sql_i .= ' (  ';
                $sql_i .= " idt_politica_parametro_tabelas, ";
                $sql_i .= " codigo, ";
                $sql_i .= " descricao, ";
                $sql_i .= " tipo, ";
                $sql_i .= " status, ";
                $sql_i .= " alias ";
                $sql_i .= '  ) values ( ';
                $sql_i .= " $idt_politica_parametro_tabelas, ";
                $sql_i .= " $codigo, ";
                $sql_i .= " $descricao, ";
                $sql_i .= " $tipo, ";
                $sql_i .= " $status, ";
                $sql_i .= " $alias ";
                $sql_i .= ') ';
                $result = execsql($sql_i);
            }
        } else {   // Se atabela existe
            ForEach ($rst->data as $row) {
                $idt_politica_parametro_tabelas = $row['idt'];

                $sql = 'update grc_politica_parametro_campos set ';
                $sql .= ' status    = ' . aspa('E') . " ";
                $sql .= ' where idt_politica_parametro_tabelas = ' . null($idt_politica_parametro_tabelas);
                execsql($sql);

                $alias_tabela = $vetTabelas[$tabela]['alias'];
                $sqlt1 = " select {$alias_tabela}.* ";
                $sqlt1 .= " from {$tabela} {$alias_tabela} ";
                $sqlt1 .= " where 1 = 2 ";
                $rst1 = execsql($sqlt1);
                foreach ($rst1->info['name'] as $indice => $campo) {
                    // pega a descrição
                    $sqlt2 = " select plu_pec.* ";
                    $sqlt2 .= " from db_pir.plu_pl_ead plu_pe ";
                    $sqlt2 .= " inner join db_pir.plu_pl_ead_campos plu_pec on  plu_pec.idt_plu_pl_ead = plu_pe.idt";
                    $sqlt2 .= " where plu_pe.codigo  = " . aspa($tabela);
                    $sqlt2 .= "   and plu_pec.codigo = " . aspa($campo);

                    $rst2 = execsql($sqlt2);
                    $descricao_campo = "";
                    $tipo = "";
                    if ($rst2->rows == 0) {
                        
                    } else {

                        foreach ($rst2->data as $rowt2) {
                            $descricao_campo = $rowt2['descricao'];
                            $tipo = $rowt2['tipocampobase'];
                        }
                    }
                    if ($descricao_campo == '') {
                        $descricao_campo = "{$alias_tabela}_{$campo} ";
                    }
                    if ($tipo == '') {
                        $tipo = "varchar";
                    }
                    $campow = "{$alias_tabela}.{$campo} ";
                    $aliasw = "{$alias_tabela}_{$campo} ";
                    $codigo = aspa($campow);
                    $descricao = aspa($descricao_campo);
                    $alias = aspa($aliasw);
                    $tipo = aspa($tipo);
                    $sqlt = " select idt ";
                    $sqlt .= " from grc_politica_parametro_campos ";
                    $sqlt .= " where codigo = " . $codigo;
                    $rst = execsql($sqlt);
                    $descricao_campo = "";
                    if ($rst->rows == 0) {
                        $status = aspa('A');
                        $sql_i = ' insert into ' . db_pir_grc . 'grc_politica_parametro_campos ';
                        $sql_i .= ' (  ';
                        $sql_i .= " idt_politica_parametro_tabelas, ";
                        $sql_i .= " codigo, ";
                        $sql_i .= " descricao, ";
                        $sql_i .= " tipo, ";
                        $sql_i .= " status, ";
                        $sql_i .= " alias ";
                        $sql_i .= '  ) values ( ';
                        $sql_i .= " $idt_politica_parametro_tabelas, ";
                        $sql_i .= " $codigo, ";
                        $sql_i .= " $descricao, ";
                        $sql_i .= " tipo, ";
                        $sql_i .= " $status, ";
                        $sql_i .= " $alias ";

                        $sql_i .= ') ';
                        $result = execsql($sql_i);
                    } else {
                        foreach ($rst->data as $rowt) {
                            $idt_campo = $rowt['idt'];
                            $sql = 'update grc_politica_parametro_campos set ';
                            $sql .= ' status    = ' . aspa('A') . ", ";
                            $sql .= ' descricao = ' . $descricao . ", ";
                            $sql .= ' tipo      = ' . $tipo . " ";
                            //   $sql .= ' alias     = ' . $alias;
                            $sql .= ' where idt                 = ' . null($idt_campo);
                            execsql($sql);
                        }
                    }
                }


                $sql_d = 'delete from grc_politica_parametro_campos ';
                $sql_d .= ' where idt_politica_parametro_tabelas = ' . null($idt_politica_parametro_tabelas);
                $sql_d .= '   and status = ' . aspa('E');
                $result = execsql($sql_d);
            }
        }
    }
    return $idt_politica_parametro_tabelas;
}

function VerificaSQL($sql, &$ew) {
    $ret = 0;
    try {
        $rs = execsql($sql, false);
        $ret = 1;
    } catch (PDOException $e) {
        //p($e);
        $ew = $e;
    }
    return $ret;
}

function OpcaoCanalContato($codigo, &$vetRetorno) {
    $kokw = 0;
    $vetCanal = Array();
    $vetCanalAgenda = Array();
    $codigow = aspa($codigo);
    $sqlt = " select gec_e.idt, ";
    $sqlt .= "        gec_e.receber_informacao, ";
    $sqlt .= "        gec_exti.idt_tipo_informacao, ";
    $sqlt .= "        gec_eti.descricao ";

    $sqlt .= " from " . db_pir_gec . "gec_entidade gec_e ";
    $sqlt .= " inner join " . db_pir_gec . "gec_entidade_x_tipo_informacao gec_exti on gec_exti.idt = gec_e.idt  ";
    $sqlt .= " inner join " . db_pir_gec . "gec_entidade_tipo_informacao gec_eti on gec_eti.idt  = gec_exti.idt_tipo_informacao  ";
    $sqlt .= " where gec_e.codigo        = $codigow ";
    $sqlt .= "   and gec_e.reg_situacao = " . aspa('A');
    $rst = execsql($sqlt);
    if ($rst->rows == 0) {
        
    } else {
        $vetCanalAgenda['EMAIL'] = 'N';
        $vetCanalAgenda['SMS']   = 'N';
        foreach ($rst->data as $rowt) {
            $idt_tipo_informacao = $rowt['idt_tipo_informacao'];
            $rowt['tipo'] = "";
            if ($idt_tipo_informacao == 3) {
                $tipo = 'EMAIL';
                $vetCanalAgenda[$tipo] = 'S';
            }
            if ($idt_tipo_informacao == 4) {
                $tipo = 'SMS';
                $vetCanalAgenda[$tipo] = 'S';
            }
            $rowt['tipo'] = $tipo;
            $vetCanal[$idt_tipo_informacao] = $rowt;
        }
        $kokw = 1;
    }
    $vetRetorno['vetCanalAgenda'] = $vetCanalAgenda;
    $vetRetorno['vetCanal'] = $vetCanal;

    return $kokw;
}

function ArquivoICS(&$vetParametro) {
    /*
      BEGIN:VCALENDAR

      VERSION:2.0

      PRODID:< [enter ID information here] >

      (other header information goes here)

      BEGIN:VEVENT

      (event details)

      END:VEVENT

      BEGIN:VEVENT

      (event details)

      END:VEVENT

      END:VCALENDAR
     */

    $timezones = array(
        'AC' => 'America/Rio_branco', 'AL' => 'America/Maceio',
        'AP' => 'America/Belem', 'AM' => 'America/Manaus',
        'BA' => 'America/Bahia', 'CE' => 'America/Fortaleza',
        'DF' => 'America/Sao_Paulo', 'ES' => 'America/Sao_Paulo',
        'GO' => 'America/Sao_Paulo', 'MA' => 'America/Fortaleza',
        'MT' => 'America/Cuiaba', 'MS' => 'America/Campo_Grande',
        'MG' => 'America/Sao_Paulo', 'PR' => 'America/Sao_Paulo',
        'PB' => 'America/Fortaleza', 'PA' => 'America/Belem',
        'PE' => 'America/Recife', 'PI' => 'America/Fortaleza',
        'RJ' => 'America/Sao_Paulo', 'RN' => 'America/Fortaleza',
        'RS' => 'America/Sao_Paulo', 'RO' => 'America/Porto_Velho',
        'RR' => 'America/Boa_Vista', 'SC' => 'America/Sao_Paulo',
        'SE' => 'America/Maceio', 'SP' => 'America/Sao_Paulo',
        'TO' => 'America/Araguaia',
    );



    $protocolo = $vetParametro['protocolo'];
    $sumario = $vetParametro['sumario'];
    $descricao = $vetParametro['descricao'];
    $data_agenda = $vetParametro['data_agenda'];
    $hora_evento = $vetParametro['hora_evento'];
    $local_agenda = $vetParametro['local_agenda'];

    $data_horai = '';
    $data_horai .= $timezones['BA'];
    $data_horai .= ':';
    $datainv = trata_data($data_agenda);
    $dt = str_replace('-', '', $datainv);
    $data_horai .= $dt;
    $data_horai .= 'T';
    $hh = str_replace(':', '', $hora_evento);
    $data_horai .= $hh;
    $data_horai .= '00';

    $data_horaf = '';
    $data_horaf .= $timezones['BA'];
    $data_horaf .= ':';
    $datainv = trata_data($data_agenda);
    $dt = str_replace('-', '', $datainv);
    $data_horaf .= $dt;
    $data_horaf .= 'T';
    $hh = str_replace(':', '', $hora_evento);
    $data_horaf .= $hh;
    $data_horaf .= '00';



    //
    $vetArq = Array();
    // Final do arquivo ICS
    $vetArq[] = "BEGIN:VCALENDAR";
    $vetArq[] = "VERSION:2.0";
    $vetArq[] = "CALSCALE:GREGORIAN";
    // Inicio de um evento
    $vetArq[] = "BEGIN:VEVENT";
    $vetArq[] = "SUMMARY: {$sumario}";
    //$vetArq[]="DTSTART;TZID=America/New_York:20130802T103400";
    //$vetArq[]="DTEND;TZID=America/New_York:20130802T110400";

    $vetArq[] = "DTSTART;TZID={$data_horai}";
    $vetArq[] = "DTEND;TZID={$data_horaf}";


    $vetArq[] = "LOCATION:{$local_agenda}";
    $vetArq[] = "DESCRIPTION: {$descricao}";
    $vetArq[] = "STATUS:CONFIRMED";
    $vetArq[] = "SEQUENCE:3";
    $vetArq[] = "BEGIN:VALARM";
    $vetArq[] = "TRIGGER:-PT10M";
    $vetArq[] = "DESCRIPTION:Pickup Reminder";
    $vetArq[] = "ACTION:DISPLAY";
    $vetArq[] = "END:VALARM";
    $vetArq[] = "END:VEVENT";

    /*
      // Inicio de outro evento
      $vetArq[]="BEGIN:VEVENT";
      $vetArq[]="SUMMARY:Access-A-Ride Pickup";
      $vetArq[]="DTSTART;TZID=America/New_York:20130802T200000";
      $vetArq[]="DTEND;TZID=America/New_York:20130802T203000";
      $vetArq[]="LOCATION:900 Jay St.\, Brooklyn";
      $vetArq[]="DESCRIPTION: Access-A-Ride to 1000 Broadway Ave.\, Brooklyn";
      $vetArq[]="STATUS:CONFIRMED";
      $vetArq[]="SEQUENCE:3";
      $vetArq[]="BEGIN:VALARM";
      $vetArq[]="TRIGGER:-PT10M";
      $vetArq[]="DESCRIPTION:Pickup Reminder";
      $vetArq[]="ACTION:DISPLAY";
      $vetArq[]="END:VALARM";
      $vetArq[]="END:VEVENT";
     */
    // Final do arquivo ICS
    $vetArq[] = "END:VCALENDAR";

    $textoics = implode(chr(13), $vetArq);

    //$textoics = implode(";",$vetArq);
    $arquivo = "obj_file/ics/{$protocolo}.ics";
    $fp = fopen($arquivo, "w");
    // Escreve "exemplo de escrita" no bloco1.txt
    $escreve = fwrite($fp, $textoics);
    // Fecha o arquivo
    fclose($fp); // OK
    $vetParametro['textoics'] = $textoics;
    $vetParametro['arquivonovo_ics'] = "{$protocolo}.ics";
    return $arquivo;
}

function Funil_parametro($idt_parametro, &$vetRetorno) {
    $ano_atual = "";
    $sqlt = " select ";
    $sqlt .= "   * ";
    $sqlt .= " from " . db_pir_grc . "grc_funil_parametro ";
    $sqlt .= " where idt = " . null($idt_parametro);
    $rst = execsql($sqlt);
    if ($rst->rows == 0) {
        
    } else {
        foreach ($rst->data as $rowt) {
            $ano_atual = $rowt['ano_ativo'];
            $vetRetorno[$ano_atual] = $rowt;
        }
    }
    return $ano_atual;
}

function FunilExecutaJOB() {
    // Carrega Base para ficar igual ao BI do Sebrae
    $vetParametro = Array();
    $ret = FunilAtualizaMeta($vetParametro);
	if ($ret == 1) {
        // Término Normal
        // proceder a Classificação de Todos os clientes
        $ret = FunilClassificaCliente($vetParametro);
        if ($ret == 0) {
            // Término anormal
        }
    }
    return $ret;
}

function FunilAtualizaMeta(&$vetParametro) {
    $kokw = 0;
    try {

        $kokw = 0;
        $fimlinha = chr(13);
        $textograva = "";
        $datehora = date('d/m/Y H:i:s');
        $textograva .= "-- Início em {$datehora} do Processo de Atualização base Funil no CRM|Sebrae.{$fimlinha}";
        $datehoraarq = str_replace(' ', '', $datehora);
        $datehoraarq = str_replace('/', '', $datehoraarq);
        $datehoraarq = str_replace(':', '', $datehoraarq);






        $datehoraarqw = substr($datehoraarq, 4, 4) . substr($datehoraarq, 2, 2) . substr($datehoraarq, 0, 2) . substr($datehoraarq, 8, 6);
        $protocolo = "PR" . $datehoraarqw;
        // Controle Geral da execução
        $textogravaG = "";
        $textogravaG .= "-- Início em {$datehora} do Processo de Execução " . $fimlinha;
        $textogravaG .= "-- Protocolo:{$protocolo}" . $fimlinha;
        $textogravaG .= "-- Etapa 01 " . $fimlinha;
        $caminho = path_fisico . "obj_file/funil/job_funil_execucao.log";
        $fp = fopen($caminho, "w");
        $escreve = fwrite($fp, $textogravaG);
        fclose($fp);
        //



        $caminho = path_fisico . "obj_file/funil/job_funil_{$datehoraarqw}.log";
        $fp = fopen($caminho, "w");
        $escreve = fwrite($fp, $textograva);
        fclose($fp);
        //
        $vetRetorno = Array();
        $ano_atual = Funil_parametro(1, $vetRetorno);

        $textograva .= "-- Ano Atual = {$ano_atual}";

        $fp = fopen($caminho, "w");
        $escreve = fwrite($fp, $textograva);
        fclose($fp);
        /*
          INFORMAÇÕES E PROCEDIMENTOS PARA ACESSO A BASE DE METAS
          1. Acesso:
          Servidor: 10.6.14.17
          Banco: SIACNet_DH
          Usuário: pir.producao
          2. Segue script:
          SELECT
         */
        // Conexão
        //$conSAIC = conSIAC();
        //Produção
        define('siacweb_hostp', siacweb_tipodb . ':Server=10.6.14.17;Database=SIACNet_DH');
        define('siacweb_bd_userp', 'pir.producao');
        define('siacweb_passwordp', '01oq@(WO');
        define('siacweb_tipodb', 'sqlsrv');

        $textograva .= "-- Conexão : " . siacweb_hostp . $fimlinha;
        $textograva .= "-- Usuário : " . siacweb_bd_userp . $fimlinha;
        $textograva .= "-- Tipo bd : " . siacweb_tipodb . $fimlinha;
        $fp = fopen($caminho, "w");
        $escreve = fwrite($fp, $textograva);
        fclose($fp);

        $conSAIC = new_pdo(siacweb_hostp, siacweb_bd_userp, siacweb_passwordp, siacweb_tipodb);


        $textograva .= "-- Conectado : " . $fimlinha;
        $fp = fopen($caminho, "w");
        $escreve = fwrite($fp, $textograva);
        fclose($fp);







        /*
          // SELECT DA OCORRÊNCIA ORIGINAL
          $sqlt  = " select ";
          $sqlt .= " DISTINCT ";
          //$sqlt .= " dbo._ParceiroHistorico.[escritorio de atendimento], ";
          $sqlt .= " dbo._ParceiroHistorico.[escritorio de atendimento] as escritorio_de_atendimento, ";
          $sqlt .= " dbo._ParceiroEndereco.DescCid AS cidade, ";
          $sqlt .= " dbo._ParceiroHistorico.Tiporealizacao as tipo_realizacao, ";
          //$sqlt .= " dbo._ParceiroHistorico.DescTipoRealizacao as [tipo realização], ";
          $sqlt .= " dbo._ParceiroHistorico.DescTipoRealizacao as tiporealizacao, ";
          $sqlt .= " dbo._ParceiroHistorico.instrumento, ";
          $sqlt .= " dbo._ParceiroHistorico.CodRealizacao as codrealizacao, ";
          $sqlt .= " dbo._ParceiroHistorico.NomeRealizacao, ";
          $sqlt .= " dbo._ParceiroHistorico.DataHoraInicioRealizacao as datahorainicial, ";
          $sqlt .= " dbo._ParceiroHistorico.DataHoraFimRealizacao as datahorafinal, ";
          //$sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacao (dbo._ParceiroHistorico.rowguid) AS [meta afetada pelo atendimento], ";

          $sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacao (dbo._ParceiroHistorico.rowguid) AS meta_afetada, ";


          //$sqlt .= " CASE WHEN (dbo._ParceiroHistorico.CodEmpreedimento IS NULL) THEN 'Pessoa' ELSE 'Empreendimento' END AS [tipo pessoa], ";


          //$sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacao (dbo._ParceiroHistorico.rowguid) AS meta_afetada_pelo_atendimento, "; sem permissao
          $sqlt .= " CASE WHEN (dbo._ParceiroHistorico.CodEmpreedimento IS NULL) THEN 'Pessoa' ELSE 'Empreendimento' END AS tipo_pessoa, ";



          $sqlt .= " dbo._ParceiroHistorico.CodEmpreedimento, ";
          //$sqlt .= " dbo._ParceiroEmpresa.DescConst AS [tipo de empreendimento], ";
          $sqlt .= " dbo._ParceiroEmpresa.DescConst AS tipo_de_empreendimento, ";
          $sqlt .= " dbo._ParceiroEmpresa.porte, ";
          $sqlt .= " dbo._ParceiroEmpresa.descsetor AS setor, ";
          //$sqlt .= " dbo.Empresa.CgcCpf , ";
          $sqlt .= " dbo.FN_Formata_CNPJ(Empresa.CgcCpf) as cnpj, ";
          //$sqlt .= " Empresa.NomeRazaoSocial AS [empresa razão social], ";
          //$sqlt .= " Empresa.NomeAbrevFantasia AS [empresa nome fantasia], ";
          //$sqlt .= " dbo._ParceiroEmpresa.[Contato Principal], ";

          $sqlt .= " Empresa.NomeRazaoSocial AS nomerazaosocial, ";
          $sqlt .= " Empresa.NomeAbrevFantasia AS nomeabrevfantasia, ";
          $sqlt .= " dbo._ParceiroEmpresa.[Contato Principal] as contato_principal, ";

          $sqlt .= " dbo._ParceiroHistorico.CodCliente, ";
          $sqlt .= " dbo._ParceiroHistorico.Cargo, ";
          $sqlt .= " dbo.FN_Formata_CPF(Pessoa.CgcCpf) as cpf, ";
          //	$sqlt .= " Pessoa.NomeRazaoSocial AS [nome do cliente], ";
          //	$sqlt .= " Pessoa.NomeAbrevFantasia as [nome tratamento], ";
          $sqlt .= " Pessoa.NomeRazaoSocial AS nome_do_cliente, ";
          $sqlt .= " Pessoa.NomeAbrevFantasia as nome_tratamento, ";




          $sqlt .= " dbo._ParceiroPessoa.descsexo AS sexo, ";
          $sqlt .= " dbo._ParceiroPessoa.DescGrauEscol AS escolaridade, ";
          $sqlt .= " dbo._ParceiroComunicacao.email, ";
          $sqlt .= " dbo._ParceiroComunicacao.fonecelular, ";
          $sqlt .= " dbo._ParceiroComunicacao.foneresidencial, ";
          $sqlt .= " dbo._ParceiroComunicacao.fonecomercial, ";
          $sqlt .= " dbo._ParceiroEndereco.Cep, ";
          $sqlt .= " dbo._ParceiroEndereco.AbrevEst AS uf, ";
          $sqlt .= " dbo._ParceiroEndereco.DescCid AS cidade, ";
          $sqlt .= " dbo._ParceiroEndereco.descbairro AS bairro, ";
          $sqlt .= " dbo._ParceiroEndereco.DescEndereco AS endereco, ";
          $sqlt .= " dbo._ParceiroEndereco.Complemento, ";
          //$sqlt .= " dbo._ParceiroEmpresa.DescCnaeFiscal AS [atividade economica] ";
          $sqlt .= " dbo._ParceiroEmpresa.DescCnaeFiscal AS atividade_economica ";


          $sqlt .= " FROM ";
          $sqlt .= " dbo._Parceiro AS Pessoa ";
          $sqlt .= " INNER JOIN ";
          $sqlt .= " dbo._ParceiroHistorico ON Pessoa.CodParceiro = dbo._ParceiroHistorico.CodCliente ";
          $sqlt .= " LEFT OUTER JOIN ";
          $sqlt .= " dbo._Parceiro ON dbo._ParceiroHistorico.CodResponsavel = dbo._Parceiro.CodParceiro ";
          $sqlt .= " LEFT OUTER JOIN ";
          $sqlt .= " dbo._ParceiroPessoa ON Pessoa.CodParceiro = dbo._ParceiroPessoa.CodParceiro ";
          $sqlt .= " LEFT OUTER JOIN ";
          $sqlt .= " dbo._ParceiroEndereco ON dbo._ParceiroHistorico.codparceiroreferencia = dbo._ParceiroEndereco.CodParceiro ";
          $sqlt .= " LEFT OUTER JOIN ";
          $sqlt .= " dbo._ParceiroComunicacao ON dbo._ParceiroHistorico.codparceiroreferencia = dbo._ParceiroComunicacao.CodParceiro ";
          $sqlt .= " LEFT OUTER JOIN ";
          $sqlt .= " dbo._ParceiroEmpresa ";
          $sqlt .= " INNER JOIN ";
          $sqlt .= " dbo._Parceiro AS Empresa ON dbo._ParceiroEmpresa.codparceiro = Empresa.CodParceiro ON dbo._ParceiroHistorico.CodEmpreedimento = Empresa.CodParceiro ";
          // -- FILTRO DE ANO
          $sqlt .= " WHERE (Year(dbo._ParceiroHistorico.MesAnoCompetencia) in ({$ano_atual})) ";
          //$rst   = execsql($sqlt, true, $conSAIC);
         */

        // SELECT REVISADO POR EMANUEL E LUIZ


        /* 	
          SELECT * FROM (

          SELECT DISTINCT
          --dbo.microreg.descmicro,
          --codmicro_regra16_lupe,

          CASE WHEN (dbo.microreg.descmicro IS NULL) THEN 'Não Identificado'
          ELSE dbo.microreg.descmicro END AS [Regional da Jurisdição],


          dbo._ParceiroHistorico.[escritorio de atendimento],
          dbo._ParceiroEndereco.DescCid AS cidade,
          dbo._ParceiroHistorico.TipoRealizacao,
          dbo._ParceiroHistorico.DescTipoRealizacao AS [tipo realização],
          dbo._ParceiroHistorico.Instrumento,
          dbo._ParceiroHistorico.CodRealizacao,
          dbo._ParceiroHistorico.NomeRealizacao,
          dbo._ParceiroHistorico.DataHoraInicioRealizacao,
          dbo._ParceiroHistorico.DataHoraFimRealizacao,

          dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacaoLupe(dbo._ParceiroHistorico.rowguid) AS [meta afetada pelo atendimento],

          --dbo.SEBRAEBA_FN_RecuperaMetaCodEmpreendimento(dbo._ParceiroHistorico.CodEmpreedimento, 2017) AS [metas afetada pelo empreendimento],

          CASE WHEN (dbo._ParceiroHistorico.CodEmpreedimento IS NULL) THEN 'Pessoa' ELSE 'Empreendimento' END AS [tipo pessoa],
          dbo._ParceiroHistorico.CodEmpreedimento,
          dbo._ParceiroEmpresa.DescConst AS [tipo de empreendimento],
          dbo._ParceiroEmpresa.porte,
          dbo._ParceiroEmpresa.descsetor AS setor,
          dbo.FN_Formata_CNPJ(Empresa.CgcCpf) AS cnpj,
          Empresa.NomeRazaoSocial AS [empresa razão social],
          Empresa.NomeAbrevFantasia AS [empresa nome fantasia],
          dbo._ParceiroEmpresa.[Contato Principal],
          dbo._ParceiroHistorico.CodCliente,
          dbo._ParceiroHistorico.Cargo,
          dbo.FN_Formata_CPF(Pessoa.CgcCpf) AS cpf,
          Pessoa.NomeRazaoSocial AS [nome do cliente],
          Pessoa.NomeAbrevFantasia AS [nome tratamento],
          dbo._ParceiroPessoa.descsexo AS sexo,
          dbo._ParceiroPessoa.DescGrauEscol AS escolaridade,
          dbo._ParceiroComunicacao.email,
          dbo._ParceiroComunicacao.fonecelular,
          dbo._ParceiroComunicacao.foneresidencial,
          dbo._ParceiroComunicacao.fonecomercial,
          dbo._ParceiroEndereco.Cep,
          dbo._ParceiroEndereco.AbrevEst AS uf,
          dbo._ParceiroEndereco.DescCid,
          dbo._ParceiroEndereco.descbairro AS bairro,
          dbo._ParceiroEndereco.DescEndereco AS endereco,
          dbo._ParceiroEndereco.Complemento,
          dbo._ParceiroEmpresa.DescCnaeFiscal AS [atividade economica]
          FROM dbo._Parceiro AS Pessoa
          INNER JOIN dbo._ParceiroHistorico ON Pessoa.CodParceiro = dbo._ParceiroHistorico.CodCliente
          LEFT OUTER JOIN dbo.microreg ON dbo._ParceiroHistorico.codmicro_regra16_lupe = dbo.microreg.codmicro
          LEFT OUTER JOIN dbo._Parceiro ON dbo._ParceiroHistorico.CodResponsavel = dbo._Parceiro.CodParceiro
          LEFT OUTER JOIN dbo._ParceiroPessoa ON Pessoa.CodParceiro = dbo._ParceiroPessoa.CodParceiro
          LEFT OUTER JOIN dbo._ParceiroEndereco ON dbo._ParceiroHistorico.codparceiroreferencia = dbo._ParceiroEndereco.CodParceiro
          LEFT OUTER JOIN dbo._ParceiroComunicacao ON dbo._ParceiroHistorico.codparceiroreferencia = dbo._ParceiroComunicacao.CodParceiro
          LEFT OUTER JOIN dbo._ParceiroEmpresa
          INNER JOIN dbo._Parceiro AS Empresa ON dbo._ParceiroEmpresa.codparceiro = Empresa.CodParceiro ON dbo._ParceiroHistorico.CodEmpreedimento = Empresa.CodParceiro

          -- FILTRO DE ANO
          WHERE (Year(dbo._ParceiroHistorico.MesAnoCompetencia) in (2017))

          ) AS X

          WHERE [meta afetada pelo atendimento] is not null

          order by CodEmpreedimento

         */


/* Select antes do caso da meta 7
        // SELECT AJUSTADO  
        $sqlt = "";
        $sqlt .= " select * from (  ";

        $sqlt .= " select ";
        $sqlt .= " DISTINCT ";

        $sqlt .= " codmicro_regra16_lupe as codmicro, ";

        $sqlt .= " CASE WHEN (dbo.microreg.descmicro IS NULL) THEN 'Não Identificado' ";
        $sqlt .= " ELSE dbo.microreg.descmicro END AS regional_da_jurisdicao, ";


        //$sqlt .= " dbo._ParceiroHistorico.[escritorio de atendimento], ";


        $sqlt .= " dbo._ParceiroHistorico.[escritorio de atendimento] as escritorio_de_atendimento, ";
        $sqlt .= " dbo._ParceiroEndereco.DescCid AS cidade, ";
        $sqlt .= " dbo._ParceiroHistorico.Tiporealizacao as tipo_realizacao, ";
        //$sqlt .= " dbo._ParceiroHistorico.DescTipoRealizacao as [tipo realização], ";
        $sqlt .= " dbo._ParceiroHistorico.DescTipoRealizacao as tiporealizacao, ";
        $sqlt .= " dbo._ParceiroHistorico.instrumento, ";
        $sqlt .= " dbo._ParceiroHistorico.CodRealizacao as codrealizacao, ";
        $sqlt .= " dbo._ParceiroHistorico.NomeRealizacao, ";
        $sqlt .= " dbo._ParceiroHistorico.DataHoraInicioRealizacao as datahorainicial, ";
        $sqlt .= " dbo._ParceiroHistorico.DataHoraFimRealizacao as datahorafinal, ";
        //$sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacao (dbo._ParceiroHistorico.rowguid) AS [meta afetada pelo atendimento], ";
        //$sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacao (dbo._ParceiroHistorico.rowguid) AS meta_afetada, ";
        //$sqlt .= " CASE WHEN (dbo._ParceiroHistorico.CodEmpreedimento IS NULL) THEN 'Pessoa' ELSE 'Empreendimento' END AS [tipo pessoa], ";
        //$sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacao (dbo._ParceiroHistorico.rowguid) AS meta_afetada_pelo_atendimento, "; sem permissao
        // novo

        $sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacaoLupe(dbo._ParceiroHistorico.rowguid) AS meta_afetada, ";









        $sqlt .= " CASE WHEN (dbo._ParceiroHistorico.CodEmpreedimento IS NULL) THEN 'Pessoa' ELSE 'Empreendimento' END AS tipo_pessoa, ";



        $sqlt .= " dbo._ParceiroHistorico.CodEmpreedimento as codempreendimento, ";
        //$sqlt .= " dbo._ParceiroEmpresa.DescConst AS [tipo de empreendimento], ";
        $sqlt .= " dbo._ParceiroEmpresa.DescConst AS tipo_de_empreendimento, ";
        $sqlt .= " dbo._ParceiroEmpresa.porte, ";
        $sqlt .= " dbo._ParceiroEmpresa.descsetor AS setor, ";
        //$sqlt .= " dbo.Empresa.CgcCpf , "; 
        $sqlt .= " dbo.FN_Formata_CNPJ(Empresa.CgcCpf) as cnpj, ";
        //$sqlt .= " Empresa.NomeRazaoSocial AS [empresa razão social], ";
        //$sqlt .= " Empresa.NomeAbrevFantasia AS [empresa nome fantasia], ";
        //$sqlt .= " dbo._ParceiroEmpresa.[Contato Principal], ";



        $sqlt .= " dbo._ParceiroEmpresa.CodDap as dap, ";
        $sqlt .= " dbo._ParceiroEmpresa.CodPescador as rmp, ";
        $sqlt .= " dbo._ParceiroEmpresa.CodProdutorRural, ";
        $sqlt .= " dbo._ParceiroEmpresa.NIRF as nirf, ";
        $sqlt .= " dbo._ParceiroEmpresa.CodSICAB as sicab, ";
        $sqlt .= " dbo._ParceiroEmpresa.CodSICABDataValidade, ";

        $sqlt .= " Empresa.NomeRazaoSocial AS nomerazaosocial, ";
        $sqlt .= " Empresa.NomeAbrevFantasia AS nomeabrevfantasia, ";
        $sqlt .= " dbo._ParceiroEmpresa.[Contato Principal] as contato_principal, ";

        $sqlt .= " dbo._ParceiroHistorico.CodCliente, ";
        $sqlt .= " dbo._ParceiroHistorico.Cargo, ";
        $sqlt .= " dbo.FN_Formata_CPF(Pessoa.CgcCpf) as cpf, ";
//	$sqlt .= " Pessoa.NomeRazaoSocial AS [nome do cliente], ";
//	$sqlt .= " Pessoa.NomeAbrevFantasia as [nome tratamento], ";
        $sqlt .= " Pessoa.NomeRazaoSocial AS nome_do_cliente, ";
        $sqlt .= " Pessoa.NomeAbrevFantasia as nome_tratamento, ";




        $sqlt .= " dbo._ParceiroPessoa.descsexo AS sexo, ";
        $sqlt .= " dbo._ParceiroPessoa.DescGrauEscol AS escolaridade, ";
        $sqlt .= " dbo._ParceiroComunicacao.email, ";
        $sqlt .= " dbo._ParceiroComunicacao.fonecelular, ";
        $sqlt .= " dbo._ParceiroComunicacao.foneresidencial, ";
        $sqlt .= " dbo._ParceiroComunicacao.fonecomercial, ";
        $sqlt .= " dbo._ParceiroEndereco.Cep, ";
        $sqlt .= " dbo._ParceiroEndereco.AbrevEst AS uf, ";
        //$sqlt .= " dbo._ParceiroEndereco.DescCid AS cidade, ";
        $sqlt .= " dbo._ParceiroEndereco.descbairro AS bairro, ";
        $sqlt .= " dbo._ParceiroEndereco.DescEndereco AS endereco, ";
        $sqlt .= " dbo._ParceiroEndereco.Complemento, ";
        //$sqlt .= " dbo._ParceiroEmpresa.DescCnaeFiscal AS [atividade economica] ";
        $sqlt .= " dbo._ParceiroEmpresa.DescCnaeFiscal AS atividade_economica ";


        $sqlt .= " FROM ";
        $sqlt .= " dbo._Parceiro AS Pessoa ";
        $sqlt .= " INNER JOIN ";
        $sqlt .= " dbo._ParceiroHistorico ON Pessoa.CodParceiro = dbo._ParceiroHistorico.CodCliente ";

        $sqlt .= " LEFT OUTER JOIN ";
        $sqlt .= " dbo.microreg ON dbo._ParceiroHistorico.codmicro_regra16_lupe = dbo.microreg.codmicro  ";

        $sqlt .= " LEFT OUTER JOIN ";
        $sqlt .= " dbo._Parceiro ON dbo._ParceiroHistorico.CodResponsavel = dbo._Parceiro.CodParceiro ";
        $sqlt .= " LEFT OUTER JOIN ";
        $sqlt .= " dbo._ParceiroPessoa ON Pessoa.CodParceiro = dbo._ParceiroPessoa.CodParceiro ";
        $sqlt .= " LEFT OUTER JOIN ";
        $sqlt .= " dbo._ParceiroEndereco ON dbo._ParceiroHistorico.codparceiroreferencia = dbo._ParceiroEndereco.CodParceiro ";
        $sqlt .= " LEFT OUTER JOIN ";
        $sqlt .= " dbo._ParceiroComunicacao ON dbo._ParceiroHistorico.codparceiroreferencia = dbo._ParceiroComunicacao.CodParceiro ";
        $sqlt .= " LEFT OUTER JOIN ";
        $sqlt .= " dbo._ParceiroEmpresa ";
        $sqlt .= " INNER JOIN ";
        $sqlt .= " dbo._Parceiro AS Empresa ON dbo._ParceiroEmpresa.codparceiro = Empresa.CodParceiro ON dbo._ParceiroHistorico.CodEmpreedimento = Empresa.CodParceiro ";
        // -- FILTRO DE ANO
        $sqlt .= " WHERE (Year(dbo._ParceiroHistorico.MesAnoCompetencia) in ({$ano_atual})) ";

        $sqlt .= " ) AS X ";

        $sqlt .= " WHERE meta_afetada is not null ";



          //        $sqlt .= " order by CodEmpreedimento   ";

         */

/////////////////////// novo script para atender ao caso da Meta 7
        /*
          SELECT *
          FROM (

          SELECT DISTINCT
          dbo.Mobilizadora_multsense.codmicro_regra16 as codmicro_regra16_lupe,
          CASE WHEN (dbo.microreg.descmicro IS NULL) THEN 'Não Identificado' ELSE dbo.microreg.descmicro END AS [Regional da Jurisdição],
          dbo._ParceiroHistorico.[escritorio de atendimento],
          dbo._ParceiroEndereco.DescCid as cidade,
          dbo._ParceiroHistorico.TipoRealizacao,
          dbo._ParceiroHistorico.DescTipoRealizacao AS [tipo realização],
          dbo._ParceiroHistorico.Instrumento,
          dbo._ParceiroHistorico.CodRealizacao,
          dbo._ParceiroHistorico.NomeRealizacao,
          dbo._ParceiroHistorico.DataHoraInicioRealizacao,
          dbo._ParceiroHistorico.DataHoraFimRealizacao,
          dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacaoLupe(dbo._ParceiroHistorico.rowguid, dbo.Mobilizadora_multsense.codmicro_regra16) AS [meta afetada pelo atendimento],
          CASE WHEN (dbo._ParceiroHistorico.CodEmpreedimento IS NULL) THEN 'Pessoa' ELSE 'Empreendimento' END AS [tipo pessoa],
          dbo._ParceiroHistorico.CodEmpreedimento,
          dbo._ParceiroEmpresa.DescConst AS [tipo de empreendimento],
          dbo._ParceiroEmpresa.porte,
          dbo._ParceiroEmpresa.descsetor AS setor,
          dbo.FN_Formata_CNPJ(Empresa.CgcCpf) AS cnpj,
          Empresa.NomeRazaoSocial AS [empresa razão social],
          Empresa.NomeAbrevFantasia AS [empresa nome fantasia],
          dbo._ParceiroEmpresa.[Contato Principal],
          dbo._ParceiroHistorico.CodCliente,
          dbo._ParceiroHistorico.Cargo,
          dbo.FN_Formata_CPF(Pessoa.CgcCpf) AS cpf,
          Pessoa.NomeRazaoSocial AS [nome do cliente],
          Pessoa.NomeAbrevFantasia AS [nome tratamento],
          dbo._ParceiroPessoa.descsexo AS sexo,
          dbo._ParceiroPessoa.DescGrauEscol AS escolaridade,
          dbo._ParceiroComunicacao.email,
          dbo._ParceiroComunicacao.fonecelular,
          dbo._ParceiroComunicacao.foneresidencial,
          dbo._ParceiroComunicacao.fonecomercial,
          dbo._ParceiroEndereco.Cep,
          dbo._ParceiroEndereco.AbrevEst AS uf,
          dbo._ParceiroEndereco.DescCid,
          dbo._ParceiroEndereco.descbairro AS bairro,
          dbo._ParceiroEndereco.DescEndereco AS endereco,
          dbo._ParceiroEndereco.Complemento,
          dbo._ParceiroEmpresa.DescCnaeFiscal AS [atividade economica]


          FROM dbo.microreg RIGHT OUTER JOIN
          dbo.Mobilizadora_multsense ON dbo.microreg.codmicro = dbo.Mobilizadora_multsense.codmicro_regra16 RIGHT OUTER JOIN
          dbo._Parceiro AS Pessoa INNER JOIN
          dbo._ParceiroHistorico ON Pessoa.CodParceiro = dbo._ParceiroHistorico.CodCliente ON
          dbo.Mobilizadora_multsense.rowguid = dbo._ParceiroHistorico.rowguid LEFT OUTER JOIN
          dbo._Parceiro ON dbo._ParceiroHistorico.CodResponsavel = dbo._Parceiro.CodParceiro LEFT OUTER JOIN
          dbo._ParceiroPessoa ON Pessoa.CodParceiro = dbo._ParceiroPessoa.CodParceiro LEFT OUTER JOIN
          dbo._ParceiroEndereco ON dbo._ParceiroHistorico.codparceiroreferencia = dbo._ParceiroEndereco.CodParceiro LEFT OUTER JOIN
          dbo._ParceiroComunicacao ON dbo._ParceiroHistorico.codparceiroreferencia = dbo._ParceiroComunicacao.CodParceiro LEFT OUTER JOIN
          dbo._ParceiroEmpresa INNER JOIN
          dbo._Parceiro AS Empresa ON dbo._ParceiroEmpresa.codparceiro = Empresa.CodParceiro ON
          dbo._ParceiroHistorico.CodEmpreedimento = Empresa.CodParceiro


          WHERE (Year(dbo._ParceiroHistorico.MesAnoCompetencia) in (2017))
          and dbo._ParceiroHistorico.CodSebrae = 26

          ) AS X


          WHERE [meta afetada pelo atendimento] is not null

          ORDER BY CodEmpreedimento, DataHoraInicioRealizacao


         */

        $sqlt = "";
        $sqlt .= " select * from (  ";

        $sqlt .= " select ";
        $sqlt .= " DISTINCT ";
        /*
          $sqlt .= " dbo.Mobilizadora_multsense.codmicro_regra16 as codmicro_regra16_lupe, ";
          $sqlt .= " CASE WHEN (dbo.microreg.descmicro IS NULL) THEN 'Não Identificado' ELSE dbo.microreg.descmicro END AS [Regional da Jurisdição], ";
          $sqlt .= " dbo._ParceiroHistorico.[escritorio de atendimento], ";
          $sqlt .= " dbo._ParceiroEndereco.DescCid as cidade, ";
          $sqlt .= " dbo._ParceiroHistorico.TipoRealizacao, ";
          $sqlt .= " dbo._ParceiroHistorico.DescTipoRealizacao AS [tipo realização], ";
          $sqlt .= " dbo._ParceiroHistorico.Instrumento, ";
          $sqlt .= " dbo._ParceiroHistorico.CodRealizacao, ";
          $sqlt .= " dbo._ParceiroHistorico.NomeRealizacao, ";
          $sqlt .= " dbo._ParceiroHistorico.DataHoraInicioRealizacao,  ";
          $sqlt .= " dbo._ParceiroHistorico.DataHoraFimRealizacao,  ";
          $sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacaoLupe(dbo._ParceiroHistorico.rowguid, dbo.Mobilizadora_multsense.codmicro_regra16) AS [meta afetada pelo atendimento], ";
          $sqlt .= " CASE WHEN (dbo._ParceiroHistorico.CodEmpreedimento IS NULL) THEN 'Pessoa' ELSE 'Empreendimento' END AS [tipo pessoa], ";
          $sqlt .= " dbo._ParceiroHistorico.CodEmpreedimento, ";
          $sqlt .= " dbo._ParceiroEmpresa.DescConst AS [tipo de empreendimento], ";
          $sqlt .= " dbo._ParceiroEmpresa.porte, ";
          $sqlt .= " dbo._ParceiroEmpresa.descsetor AS setor, ";
          $sqlt .= " dbo.FN_Formata_CNPJ(Empresa.CgcCpf) AS cnpj,  ";
          $sqlt .= " Empresa.NomeRazaoSocial AS [empresa razão social], ";
          $sqlt .= " Empresa.NomeAbrevFantasia AS [empresa nome fantasia], ";
          $sqlt .= " dbo._ParceiroEmpresa.[Contato Principal], ";
          $sqlt .= " dbo._ParceiroHistorico.CodCliente, ";
          $sqlt .= " dbo._ParceiroHistorico.Cargo, ";
          $sqlt .= " dbo.FN_Formata_CPF(Pessoa.CgcCpf) AS cpf, ";
          $sqlt .= " Pessoa.NomeRazaoSocial AS [nome do cliente], ";
          $sqlt .= " Pessoa.NomeAbrevFantasia AS [nome tratamento], ";
          $sqlt .= " dbo._ParceiroPessoa.descsexo AS sexo, ";
          $sqlt .= " dbo._ParceiroPessoa.DescGrauEscol AS escolaridade, ";
          $sqlt .= " dbo._ParceiroComunicacao.email, ";
          $sqlt .= " dbo._ParceiroComunicacao.fonecelular, ";
          $sqlt .= " dbo._ParceiroComunicacao.foneresidencial, ";
          $sqlt .= " dbo._ParceiroComunicacao.fonecomercial, ";
          $sqlt .= " dbo._ParceiroEndereco.Cep, ";
          $sqlt .= " dbo._ParceiroEndereco.AbrevEst AS uf, ";
          $sqlt .= " dbo._ParceiroEndereco.DescCid, ";
          $sqlt .= " dbo._ParceiroEndereco.descbairro AS bairro, ";
          $sqlt .= " dbo._ParceiroEndereco.DescEndereco AS endereco, ";
          $sqlt .= " dbo._ParceiroEndereco.Complemento, ";
          $sqlt .= " dbo._ParceiroEmpresa.DescCnaeFiscal AS [atividade economica] ";
         */



//$sqlt .= " codmicro_regra16_lupe as codmicro, ";
//$sqlt .= " dbo.Mobilizadora_multsense.codmicro_regra16 as codmicro_regra16_lupe, ";
        $sqlt .= " dbo.Mobilizadora_multsense.codmicro_regra16 as codmicro, ";


        $sqlt .= " CASE WHEN (dbo.microreg.descmicro IS NULL) THEN 'Não Identificado' ";
        $sqlt .= " ELSE dbo.microreg.descmicro END AS regional_da_jurisdicao, ";


        //$sqlt .= " dbo._ParceiroHistorico.[escritorio de atendimento], ";


        $sqlt .= " dbo._ParceiroHistorico.[escritorio de atendimento] as escritorio_de_atendimento, ";
        $sqlt .= " dbo._ParceiroEndereco.DescCid AS cidade, ";
        $sqlt .= " dbo._ParceiroHistorico.Tiporealizacao as tipo_realizacao, ";
        //$sqlt .= " dbo._ParceiroHistorico.DescTipoRealizacao as [tipo realização], ";
        $sqlt .= " dbo._ParceiroHistorico.DescTipoRealizacao as tiporealizacao, ";
        $sqlt .= " dbo._ParceiroHistorico.instrumento, ";
        $sqlt .= " dbo._ParceiroHistorico.CodRealizacao as codrealizacao, ";
        $sqlt .= " dbo._ParceiroHistorico.NomeRealizacao, ";
        $sqlt .= " dbo._ParceiroHistorico.DataHoraInicioRealizacao as datahorainicial, ";
        $sqlt .= " dbo._ParceiroHistorico.DataHoraFimRealizacao as datahorafinal, ";
        //$sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacao (dbo._ParceiroHistorico.rowguid) AS [meta afetada pelo atendimento], ";
        //$sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacao (dbo._ParceiroHistorico.rowguid) AS meta_afetada, ";
        //$sqlt .= " CASE WHEN (dbo._ParceiroHistorico.CodEmpreedimento IS NULL) THEN 'Pessoa' ELSE 'Empreendimento' END AS [tipo pessoa], ";
        //$sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacao (dbo._ParceiroHistorico.rowguid) AS meta_afetada_pelo_atendimento, "; sem permissao
        // novo
//$sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacaoLupe(dbo._ParceiroHistorico.rowguid) AS meta_afetada, ";
        $sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacaoLupe(dbo._ParceiroHistorico.rowguid, dbo.Mobilizadora_multsense.codmicro_regra16) AS meta_afetada, ";









        $sqlt .= " CASE WHEN (dbo._ParceiroHistorico.CodEmpreedimento IS NULL) THEN 'Pessoa' ELSE 'Empreendimento' END AS tipo_pessoa, ";



        $sqlt .= " dbo._ParceiroHistorico.CodEmpreedimento as codempreendimento, ";
        //$sqlt .= " dbo._ParceiroEmpresa.DescConst AS [tipo de empreendimento], ";
        $sqlt .= " dbo._ParceiroEmpresa.DescConst AS tipo_de_empreendimento, ";
        $sqlt .= " dbo._ParceiroEmpresa.porte, ";
        $sqlt .= " dbo._ParceiroEmpresa.descsetor AS setor, ";
        //$sqlt .= " dbo.Empresa.CgcCpf , "; 
        $sqlt .= " dbo.FN_Formata_CNPJ(Empresa.CgcCpf) as cnpj, ";
        //$sqlt .= " Empresa.NomeRazaoSocial AS [empresa razão social], ";
        //$sqlt .= " Empresa.NomeAbrevFantasia AS [empresa nome fantasia], ";
        //$sqlt .= " dbo._ParceiroEmpresa.[Contato Principal], ";



        $sqlt .= " dbo._ParceiroEmpresa.CodDap as dap, ";
        $sqlt .= " dbo._ParceiroEmpresa.CodPescador as rmp, ";
        $sqlt .= " dbo._ParceiroEmpresa.CodProdutorRural, ";
        $sqlt .= " dbo._ParceiroEmpresa.NIRF as nirf, ";
        $sqlt .= " dbo._ParceiroEmpresa.CodSICAB as sicab, ";
        $sqlt .= " dbo._ParceiroEmpresa.CodSICABDataValidade, ";

        $sqlt .= " Empresa.NomeRazaoSocial AS nomerazaosocial, ";
        $sqlt .= " Empresa.NomeAbrevFantasia AS nomeabrevfantasia, ";
        $sqlt .= " dbo._ParceiroEmpresa.[Contato Principal] as contato_principal, ";

        $sqlt .= " dbo._ParceiroHistorico.CodCliente, ";
        $sqlt .= " dbo._ParceiroHistorico.Cargo, ";
        $sqlt .= " dbo.FN_Formata_CPF(Pessoa.CgcCpf) as cpf, ";
//	$sqlt .= " Pessoa.NomeRazaoSocial AS [nome do cliente], ";
//	$sqlt .= " Pessoa.NomeAbrevFantasia as [nome tratamento], ";
        $sqlt .= " Pessoa.NomeRazaoSocial AS nome_do_cliente, ";
        $sqlt .= " Pessoa.NomeAbrevFantasia as nome_tratamento, ";




        $sqlt .= " dbo._ParceiroPessoa.descsexo AS sexo, ";
        $sqlt .= " dbo._ParceiroPessoa.DescGrauEscol AS escolaridade, ";
        $sqlt .= " dbo._ParceiroComunicacao.email, ";
        $sqlt .= " dbo._ParceiroComunicacao.fonecelular, ";
        $sqlt .= " dbo._ParceiroComunicacao.foneresidencial, ";
        $sqlt .= " dbo._ParceiroComunicacao.fonecomercial, ";
        $sqlt .= " dbo._ParceiroEndereco.Cep, ";
        $sqlt .= " dbo._ParceiroEndereco.AbrevEst AS uf, ";
        //$sqlt .= " dbo._ParceiroEndereco.DescCid AS cidade, ";
        $sqlt .= " dbo._ParceiroEndereco.descbairro AS bairro, ";
        $sqlt .= " dbo._ParceiroEndereco.DescEndereco AS endereco, ";
        $sqlt .= " dbo._ParceiroEndereco.Complemento, ";
        //$sqlt .= " dbo._ParceiroEmpresa.DescCnaeFiscal AS [atividade economica] ";
        $sqlt .= " dbo._ParceiroEmpresa.DescCnaeFiscal AS atividade_economica ";


        $sqlt .= " FROM dbo.microreg ";

        $sqlt .= " RIGHT OUTER JOIN ";
        $sqlt .= " dbo.Mobilizadora_multsense ON dbo.microreg.codmicro = dbo.Mobilizadora_multsense.codmicro_regra16 ";

        $sqlt .= " RIGHT OUTER JOIN ";
        $sqlt .= " dbo._Parceiro AS Pessoa ";

        $sqlt .= " INNER JOIN ";
        $sqlt .= " dbo._ParceiroHistorico ON Pessoa.CodParceiro = dbo._ParceiroHistorico.CodCliente ON ";
        $sqlt .= " dbo.Mobilizadora_multsense.rowguid = dbo._ParceiroHistorico.rowguid ";

        $sqlt .= " LEFT OUTER JOIN ";
        $sqlt .= " dbo._Parceiro ON dbo._ParceiroHistorico.CodResponsavel = dbo._Parceiro.CodParceiro ";

        $sqlt .= " LEFT OUTER JOIN ";
        $sqlt .= " dbo._ParceiroPessoa ON Pessoa.CodParceiro = dbo._ParceiroPessoa.CodParceiro ";

        $sqlt .= " LEFT OUTER JOIN ";
        $sqlt .= " dbo._ParceiroEndereco ON dbo._ParceiroHistorico.codparceiroreferencia = dbo._ParceiroEndereco.CodParceiro ";

        $sqlt .= " LEFT OUTER JOIN ";
        $sqlt .= " dbo._ParceiroComunicacao ON dbo._ParceiroHistorico.codparceiroreferencia = dbo._ParceiroComunicacao.CodParceiro ";

        $sqlt .= " LEFT OUTER JOIN ";
        $sqlt .= " dbo._ParceiroEmpresa ";

        $sqlt .= " INNER JOIN ";
        $sqlt .= " dbo._Parceiro AS Empresa ON dbo._ParceiroEmpresa.codparceiro = Empresa.CodParceiro ON ";
        $sqlt .= " dbo._ParceiroHistorico.CodEmpreedimento = Empresa.CodParceiro ";


        $sqlt .= " WHERE (Year(dbo._ParceiroHistorico.MesAnoCompetencia) in ({$ano_atual})) ";
        $sqlt .= " and dbo._ParceiroHistorico.CodSebrae = 26 ";

        $sqlt .= " ) AS X ";


        $sqlt .= " WHERE meta_afetada is not null ";

        //$sqlt .= " ORDER BY CodEmpreedimento, DataHoraInicioRealizacao ";
//////////////////








//////////////////////// 05-12-2017 - Agora é com orçamento 

/*

SELECT *

FROM ( 

	SELECT  DISTINCT 
		CASE WHEN (dbo.microreg.descmicro IS NULL) THEN 'Não Identificado' ELSE dbo.microreg.descmicro END AS [Regional da Jurisdição],



		dbo._ParceiroHistorico.[escritorio de atendimento], 
		dbo._ParceiroEndereco.DescCid as cidade, 
		dbo._ParceiroHistorico.TipoRealizacao,
		dbo._ParceiroHistorico.DescTipoRealizacao AS [tipo realização], 
		dbo._ParceiroHistorico.Instrumento,
		dbo._ParceiroHistorico.CodRealizacao, 
		dbo._ParceiroHistorico.NomeRealizacao, 
		dbo._ParceiroHistorico.DataHoraInicioRealizacao, 
		dbo._ParceiroHistorico.DataHoraFimRealizacao, 
		dbo.ViewMobilizadora.meta AS [meta afetada pelo atendimento], 
		--dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacaoLupe(dbo._ParceiroHistorico.rowguid, dbo.ViewMobilizadora.codmicro_regra16) AS [meta afetada pelo atendimento] , 
		dbo.ViewMobilizadora.codmicro_regra16 as codmicro_regra16_lupe,
		CASE WHEN (dbo._ParceiroHistorico.CodEmpreedimento IS NULL) THEN 'Pessoa' ELSE 'Empreendimento' END AS [tipo pessoa], 
		dbo._ParceiroHistorico.CodEmpreedimento,
		dbo._ParceiroEmpresa.DescConst AS [tipo de empreendimento], 
		dbo._ParceiroEmpresa.porte, 
		dbo._ParceiroEmpresa.descsetor AS setor, 
		dbo.FN_Formata_CNPJ(Empresa.CgcCpf) AS cnpj, 
		Empresa.NomeRazaoSocial AS [empresa razão social], 
		Empresa.NomeAbrevFantasia AS [empresa nome fantasia], 
		dbo._ParceiroEmpresa.[Contato Principal], 
		dbo._ParceiroHistorico.CodCliente, 
		dbo._ParceiroHistorico.Cargo, 
		dbo.FN_Formata_CPF(Pessoa.CgcCpf) AS cpf, 
		Pessoa.NomeRazaoSocial AS [nome do cliente], 
		Pessoa.NomeAbrevFantasia AS [nome tratamento], 
		dbo._ParceiroPessoa.descsexo AS sexo, 
		dbo._ParceiroPessoa.DescGrauEscol AS escolaridade, 
		dbo._ParceiroComunicacao.email, 
		dbo._ParceiroComunicacao.fonecelular, 
		dbo._ParceiroComunicacao.foneresidencial, 
		dbo._ParceiroComunicacao.fonecomercial, 
		dbo._ParceiroEndereco.Cep, 
		dbo._ParceiroEndereco.AbrevEst AS uf, 
		dbo._ParceiroEndereco.DescCid, 
		dbo._ParceiroEndereco.descbairro AS bairro, 
		dbo._ParceiroEndereco.DescEndereco AS endereco, 
		dbo._ParceiroEndereco.Complemento, 
		dbo._ParceiroEmpresa.DescCnaeFiscal AS [atividade economica]		




	FROM dbo._ParceiroEmpresa 
        INNER JOIN dbo._Parceiro AS Empresa ON dbo._ParceiroEmpresa.codparceiro = Empresa.CodParceiro 
        RIGHT OUTER JOIN dbo.ViewMobilizadora
        INNER JOIN dbo._Parceiro AS Pessoa
        INNER JOIN dbo._ParceiroHistorico ON Pessoa.CodParceiro = dbo._ParceiroHistorico.CodCliente ON 
	dbo.ViewMobilizadora.rowguid = dbo._ParceiroHistorico.rowguid

        LEFT OUTER JOIN	dbo.microreg ON dbo.ViewMobilizadora.codmicro_regra16 = dbo.microreg.codmicro
        LEFT OUTER JOIN dbo._Parceiro ON dbo._ParceiroHistorico.CodResponsavel = dbo._Parceiro.CodParceiro
        LEFT OUTER JOIN	dbo._ParceiroPessoa ON Pessoa.CodParceiro = dbo._ParceiroPessoa.CodParceiro 
        LEFT OUTER JOIN dbo._ParceiroEndereco ON dbo._ParceiroHistorico.codparceiroreferencia = 		dbo._ParceiroEndereco.CodParceiro 

        LEFT OUTER JOIN	dbo._ParceiroComunicacao ON dbo._ParceiroHistorico.codparceiroreferencia = 		dbo._ParceiroComunicacao.CodParceiro ON Empresa.CodParceiro = dbo._ParceiroHistorico.CodEmpreedimento
	               
      
	WHERE (Year(dbo._ParceiroHistorico.MesAnoCompetencia) in (2017))
	and dbo._ParceiroHistorico.CodSebrae = 26
	and dbo.ViewMobilizadora.meta in ('Meta 1', 'Meta 7')

) AS X


*/
    $sqlt  = "";
	$sqlt .= " select * from (  ";
	$sqlt .= " select ";
	$sqlt .= " DISTINCT ";
    //  campos
        $sqlt .= " CASE WHEN (dbo.microreg.descmicro IS NULL) THEN 'Não Identificado' ";
        $sqlt .= " ELSE dbo.microreg.descmicro END AS regional_da_jurisdicao, ";
        //$sqlt .= " dbo._ParceiroHistorico.[escritorio de atendimento], ";
        $sqlt .= " dbo._ParceiroHistorico.[escritorio de atendimento] as escritorio_de_atendimento, ";
        $sqlt .= " dbo._ParceiroEndereco.DescCid AS cidade, ";
        $sqlt .= " dbo._ParceiroHistorico.Tiporealizacao as tipo_realizacao, ";
        //$sqlt .= " dbo._ParceiroHistorico.DescTipoRealizacao as [tipo realização], ";
        $sqlt .= " dbo._ParceiroHistorico.DescTipoRealizacao as tiporealizacao, ";
        $sqlt .= " dbo._ParceiroHistorico.instrumento, ";
        $sqlt .= " dbo._ParceiroHistorico.CodRealizacao as codrealizacao, ";
        $sqlt .= " dbo._ParceiroHistorico.NomeRealizacao, ";
        $sqlt .= " dbo._ParceiroHistorico.DataHoraInicioRealizacao as datahorainicial, ";
        $sqlt .= " dbo._ParceiroHistorico.DataHoraFimRealizacao as datahorafinal, ";
        //$sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacao (dbo._ParceiroHistorico.rowguid) AS [meta afetada pelo atendimento], ";
        //$sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacao (dbo._ParceiroHistorico.rowguid) AS meta_afetada, ";
        //$sqlt .= " CASE WHEN (dbo._ParceiroHistorico.CodEmpreedimento IS NULL) THEN 'Pessoa' ELSE 'Empreendimento' END AS [tipo pessoa], ";
        //$sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacao (dbo._ParceiroHistorico.rowguid) AS meta_afetada_pelo_atendimento, "; sem permissao
        // novo
//$sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacaoLupe(dbo._ParceiroHistorico.rowguid) AS meta_afetada, ";
   //   $sqlt .= " dbo.SEBRAEBA_FN_RecuperaMetaDaRealizacaoLupe(dbo._ParceiroHistorico.rowguid, dbo.Mobilizadora_multsense.codmicro_regra16) AS meta_afetada, ";

//$sqlt .= " codmicro_regra16_lupe as codmicro, ";
    //$sqlt .= " dbo.Mobilizadora_multsense.codmicro_regra16 as codmicro_regra16_lupe, ";
        //$sqlt .= " dbo.Mobilizadora_multsense.codmicro_regra16 as codmicro, ";
	
		//$sqlt .= " codmicro_regra16_lupe as codmicro, ";
		$sqlt .= " dbo.ViewMobilizadora.meta AS meta_afetada, ";
		$sqlt .= " dbo.ViewMobilizadora.codmicro_regra16 as codmicro_regra16_lupe, ";
        $sqlt .= " dbo.ViewMobilizadora.codmicro_regra16 as codmicro, ";
        $sqlt .= " CASE WHEN (dbo._ParceiroHistorico.CodEmpreedimento IS NULL) THEN 'Pessoa' ELSE 'Empreendimento' END AS tipo_pessoa, ";
        $sqlt .= " dbo._ParceiroHistorico.CodEmpreedimento as codempreendimento, ";
        //$sqlt .= " dbo._ParceiroEmpresa.DescConst AS [tipo de empreendimento], ";
        $sqlt .= " dbo._ParceiroEmpresa.DescConst AS tipo_de_empreendimento, ";
        $sqlt .= " dbo._ParceiroEmpresa.porte, ";
        $sqlt .= " dbo._ParceiroEmpresa.descsetor AS setor, ";
        //$sqlt .= " dbo.Empresa.CgcCpf , "; 
        $sqlt .= " dbo.FN_Formata_CNPJ(Empresa.CgcCpf) as cnpj, ";
        //$sqlt .= " Empresa.NomeRazaoSocial AS [empresa razão social], ";
        //$sqlt .= " Empresa.NomeAbrevFantasia AS [empresa nome fantasia], ";
        //$sqlt .= " dbo._ParceiroEmpresa.[Contato Principal], ";



        $sqlt .= " dbo._ParceiroEmpresa.CodDap as dap, ";
        $sqlt .= " dbo._ParceiroEmpresa.CodPescador as rmp, ";
        $sqlt .= " dbo._ParceiroEmpresa.CodProdutorRural, ";
        $sqlt .= " dbo._ParceiroEmpresa.NIRF as nirf, ";
        $sqlt .= " dbo._ParceiroEmpresa.CodSICAB as sicab, ";
        $sqlt .= " dbo._ParceiroEmpresa.CodSICABDataValidade, ";

        $sqlt .= " Empresa.NomeRazaoSocial AS nomerazaosocial, ";
        $sqlt .= " Empresa.NomeAbrevFantasia AS nomeabrevfantasia, ";
        $sqlt .= " dbo._ParceiroEmpresa.[Contato Principal] as contato_principal, ";

        $sqlt .= " dbo._ParceiroHistorico.CodCliente, ";
        $sqlt .= " dbo._ParceiroHistorico.Cargo, ";
        $sqlt .= " dbo.FN_Formata_CPF(Pessoa.CgcCpf) as cpf, ";
//	$sqlt .= " Pessoa.NomeRazaoSocial AS [nome do cliente], ";
//	$sqlt .= " Pessoa.NomeAbrevFantasia as [nome tratamento], ";
        $sqlt .= " Pessoa.NomeRazaoSocial AS nome_do_cliente, ";
        $sqlt .= " Pessoa.NomeAbrevFantasia as nome_tratamento, ";




        $sqlt .= " dbo._ParceiroPessoa.descsexo AS sexo, ";
        $sqlt .= " dbo._ParceiroPessoa.DescGrauEscol AS escolaridade, ";
        $sqlt .= " dbo._ParceiroComunicacao.email, ";
        $sqlt .= " dbo._ParceiroComunicacao.fonecelular, ";
        $sqlt .= " dbo._ParceiroComunicacao.foneresidencial, ";
        $sqlt .= " dbo._ParceiroComunicacao.fonecomercial, ";
        $sqlt .= " dbo._ParceiroEndereco.Cep, ";
        $sqlt .= " dbo._ParceiroEndereco.AbrevEst AS uf, ";
        //$sqlt .= " dbo._ParceiroEndereco.DescCid AS cidade, ";
        $sqlt .= " dbo._ParceiroEndereco.descbairro AS bairro, ";
        $sqlt .= " dbo._ParceiroEndereco.DescEndereco AS endereco, ";
        $sqlt .= " dbo._ParceiroEndereco.Complemento, ";
        //$sqlt .= " dbo._ParceiroEmpresa.DescCnaeFiscal AS [atividade economica] ";
        $sqlt .= " dbo._ParceiroEmpresa.DescCnaeFiscal AS atividade_economica ";

	
	
	

    //  resto
		$sqlt .= " FROM dbo._ParceiroEmpresa ";
		$sqlt .= " 	INNER JOIN dbo._Parceiro AS Empresa ON dbo._ParceiroEmpresa.codparceiro = Empresa.CodParceiro ";
		$sqlt .= " 	RIGHT OUTER JOIN dbo.ViewMobilizadora ";
		$sqlt .= " 	INNER JOIN dbo._Parceiro AS Pessoa ";
		$sqlt .= " 	INNER JOIN dbo._ParceiroHistorico ON Pessoa.CodParceiro = dbo._ParceiroHistorico.CodCliente ON ";
		$sqlt .= " 	dbo.ViewMobilizadora.rowguid = dbo._ParceiroHistorico.rowguid ";
		$sqlt .= " 	LEFT OUTER JOIN	dbo.microreg ON dbo.ViewMobilizadora.codmicro_regra16 = dbo.microreg.codmicro ";
		$sqlt .= " 	LEFT OUTER JOIN dbo._Parceiro ON dbo._ParceiroHistorico.CodResponsavel = dbo._Parceiro.CodParceiro ";
		$sqlt .= " 	LEFT OUTER JOIN	dbo._ParceiroPessoa ON Pessoa.CodParceiro = dbo._ParceiroPessoa.CodParceiro ";
		$sqlt .= " 	LEFT OUTER JOIN dbo._ParceiroEndereco ON dbo._ParceiroHistorico.codparceiroreferencia = 		dbo._ParceiroEndereco.CodParceiro ";
		$sqlt .= " 	LEFT OUTER JOIN	dbo._ParceiroComunicacao ON dbo._ParceiroHistorico.codparceiroreferencia = 		dbo._ParceiroComunicacao.CodParceiro ON Empresa.CodParceiro = dbo._ParceiroHistorico.CodEmpreedimento ";
		$sqlt .= " WHERE (Year(dbo._ParceiroHistorico.MesAnoCompetencia) in (2017)) ";
		$sqlt .= " and dbo._ParceiroHistorico.CodSebrae = 26 ";
		$sqlt .= " and dbo.ViewMobilizadora.meta in ('Meta 1', 'Meta 7') ";
	$sqlt .= " ) AS X ";








        set_time_limit(0);

        $datehora = date('d/m/Y H:i:s');
        $textograva .= "-- {$datehora} Executar Select  : " . $sqlt . $fimlinha;
        $fp = fopen($caminho, "w");
        $escreve = fwrite($fp, $textograva);
        fclose($fp);


        $rst = execsqlNomeCol($sqlt, true, $conSAIC);

       // p(' registros '.$rst->rows);

        $conSAIC = null;

      //  die();


        if ($rst->rows == 0) {
            $textograva .= "-- Encontrado EOF " . $fimlinha;
            $fp = fopen($caminho, "w");
            $escreve = fwrite($fp, $textograva);
            fclose($fp);
        } else {
            $qtdaexecutar = $rst->rows;
            $textogravaG .= "-- Importar {$qtdaexecutar} Registros do SELECT PADRÃO BI " . $fimlinha;
            $textogravaG .= "-- Quantidade: {$qtdaexecutar}" . $fimlinha;
            $caminhog = path_fisico . "obj_file/funil/job_funil_execucao.log";
            $fpg = fopen($caminhog, "w");
            $escreve = fwrite($fpg, $textogravaG);
            fclose($fp);



            $textograva .= "-- Quantidade de Registros a Gravar " . $qtdaexecutar . $fimlinha;
            $datehora = date('d/m/Y H:i:s');
            $textograva .= "-- {$datehora} Truncate Tabela do banco do GRC  grc_funil_{$ano_atual}_gestao_meta   " . $fimlinha;
            $fp = fopen($caminho, "w");
            $escreve = fwrite($fp, $textograva);
            fclose($fp);
            //beginTransaction();
            set_time_limit(0);
            /*
              $flag_atu = aspa('N');
              $sql_a  = " update grc_funil_gestao_meta_{$ano_atual} set ";
              $sql_a .= " flag_atu     = $flag_atu ";
              $sql_a .= " where ano  = ".aspa($ano_atual);
              $result = execsql($sql_a);
             */
            $sql_a = " truncate table grc_funil_{$ano_atual}_gestao_meta ";
            $result = execsql($sql_a);
            $textograva .= "-- Fim do Truncate Tabela do banco do GRC  grc_funil_{$ano_atual}_gestao_meta   " . $fimlinha;
            $fp = fopen($caminho, "w");
            $escreve = fwrite($fp, $textograva);
            fclose($fp);
            set_time_limit(0);
            $datehora = date('d/m/Y H:i:s');
            $textograva .= "-- {$datehora} Iniciar Gravação dos Registros  " . $fimlinha;
            $fp = fopen($caminho, "w");
            $escreve = fwrite($fp, $textograva);
            fclose($fp);
            $quantidadew = 0;
            $intervalo = 5000;
            foreach ($rst->data as $rowt) {
                set_time_limit(60);


                $codmicrow = $rowt['codmicro'];
                $codrealizacaow = $rowt['codrealizacao'];
                $cpfw = $rowt['cpf'];
                $nome_clientew = $rowt['nome_do_cliente'];
                $cnpjw = $rowt['cnpj'];
                $razao_socialw = $rowt['nomerazaosocial'];
                $regional_da_jurisdicaow = $rowt['regional_da_jurisdicao'];
                $cidadew = $rowt['cidade'];
                $escritorio_de_atendimentow = $rowt['escritorio_de_atendimento'];
                $tiporealizacaow = $rowt['tiporealizacao'];
                $instrumentow = $rowt['instrumento'];
                $tipo_pessoaw = $rowt['tipo_pessoa'];
                $datahorainicialw = $rowt['datahorainicial'];
                $datahorafinalw = $rowt['datahorafinal'];
                $tipo_de_empreendimentow = $rowt['tipo_de_empreendimento'];
                $portew = $rowt['porte'];
                $setorw = $rowt['setor'];
                $atividade_economicaw = $rowt['atividade_economica'];
                $meta_afetadaw = $rowt['meta_afetada'];

                $codempreendimento = $rowt['codempreendimento'];


                $dapw = $rowt['dap'];      // do Produtor Rural
                $nirfw = $rowt['nirf'];     // do Produtor Rural
                $rmpw = $rowt['rmp'];      // - Registro Ministério da Pesca do Produtor Rural
                $iew = $rowt['ie'];       //- Inscrição Estadual  do Produtor Rural
                $sicabw = $rowt['sicab']; // do Artesão
                //
				$ano = aspa($ano_atual);
                $cidade = aspa($cidadew);
                $regional_da_jurisdicao = aspa($regional_da_jurisdicaow);
                $escritorio_de_atendimento = aspa($escritorio_de_atendimentow);
                $cpf = aspa($cpfw);
                $nome_cliente = aspa($nome_clientew);
                $tiporealizacao = aspa($tiporealizacaow);
                $instrumento = aspa($instrumentow);
                $tipo_pessoa = aspa($tipo_pessoaw);
                $datahorainicial = aspa($datahorainicialw);
                $datahorafinal = aspa($datahorafinalw);
                $tipo_de_empreendimento = aspa($tipo_de_empreendimentow);
                $porte = aspa($portew);
                $setor = aspa($setorw);
                $atividade_economica = aspa($atividade_economicaw);
                $codrealizacao = aspa($codrealizacaow);
                $meta_afetada = aspa($meta_afetadaw);

                $codmicro = null($codmicrow);

                $dap = aspa($dapw);
                $nirf = aspa($nirfw);
                $rmp = aspa($rmpw);
                $ie = aspa($iew);
                $sicab = aspa($sicabw);


                $cnpj = aspa($cnpjw);
                $razao_social = aspa($razao_socialw);


                $codempreendimentow = null($codempreendimento);


                $meta1w = "N";
                $meta2w = "N";
                $meta3w = "N";
                $meta4w = "N";
                $meta5w = "N";
                $meta6w = "N";
                $meta7w = "N";
                $meta8w = "N";
                $meta9w = "N";
                $meta_afetaday = str_replace(' ', '', $meta_afetadaw);
                $vet = explode('|', $meta_afetaday);
                $tam = count($vet);
                for ($i = 0; $i <= $tam; $i++) {
                    $meta = $vet[$i];
                    if ($meta == "Meta1") {
                        $meta1w = "S";
                    }
                    if ($meta == "Meta2") {
                        $meta2w = "S";
                    }
                    if ($meta == "Meta3") {
                        $meta3w = "S";
                    }
                    if ($meta == "Meta4") {
                        $meta4w = "S";
                    }
                    if ($meta == "Meta5") {
                        $meta5w = "S";
                    }
                    if ($meta == "Meta6") {
                        $meta6w = "S";
                    }
                    if ($meta == "Meta7") {
                        $meta7w = "S";
                    }
                    if ($meta == "Meta8") {
                        $meta8w = "S";
                    }
                    if ($meta == "Meta9") {
                        $meta9w = "S";
                    }
                }
                $meta1 = aspa($meta1w);
                $meta2 = aspa($meta2w);
                $meta3 = aspa($meta3w);
                $meta4 = aspa($meta4w);
                $meta5 = aspa($meta5w);
                $meta6 = aspa($meta6w);
                $meta7 = aspa($meta7w);
                $meta8 = aspa($meta8w);
                $meta9 = aspa($meta9w);
                //	$sqlt  = " select ";
                //	$sqlt .= "   * ";
                //	$sqlt .= " from grc_funil_gestao_meta ";
                //	$sqlt .= " where ano  = ".aspa($ano_atual);
                //	$sqlt .= "   and cnpj = ".aspa($cnpjw);
                //	$sqlt .= "   and razao_social = ".aspa($razao_socialw);
                //	$rst   = execsql($sqlt);
                //	if ($rst->rows==0)
                //	{
                $campo = "gec_e.codigo";
                if ($tipo_de_empreendimentow != 'Empresa (com CNPJ)') {
                    if ($cnpjw == '') {
                        if ($sicabw != '') {
                            $cnpj = $sicab;
                            $campo = "gec_o.sicab_codigo";
                        } else {
                            $fez = 0;
                            if ($dapw != '') {
                                $cnpj = $dap;
                                $campo = "gec_o.dap";
                                $fez = 1;
                            }
                            if ($nirfw != '' and $fez == 0) {
                                $cnpj = $nirf;
                                $campo = "gec_o.nirf";
                                $fez = 1;
                            }
                            if ($iew != '' and $fez == 0) {
                                $cnpj = $ie;
                                $campo = "gec_o.ie_prod_rural";
                                $fez = 1;
                            }
                            if ($fez == 0) {
                                $cnpj = $cpf;
                                $campo = "gec_e.codigo";
                                $fez = 1;
                            }
                        }
                    }
                }
                // incluir
                $campo_semcnpj = aspa($campo);
                $flag_atu = aspa('S');
                $sql_i = " insert into grc_funil_{$ano_atual}_gestao_meta ";
                $sql_i .= " (  ";
                $sql_i .= " codrealizacao, ";
                $sql_i .= " codempreendimento, ";
                $sql_i .= " flag_atu, ";
                $sql_i .= " ano, ";
                $sql_i .= " tiporealizacao, ";
                $sql_i .= " instrumento, ";
                $sql_i .= " cidade, ";
                $sql_i .= " codmicro, ";
                $sql_i .= " regional_da_jurisdicao, ";
                $sql_i .= " escritorio_de_atendimento, ";
                $sql_i .= " tipo_pessoa, ";
                $sql_i .= " datahorainicial, ";
                $sql_i .= " datahorafinal, ";
                $sql_i .= " tipo_de_empreendimento, ";
                $sql_i .= " porte, ";
                $sql_i .= " setor, ";
                $sql_i .= " atividade_economica, ";
                $sql_i .= " cpf, ";
                $sql_i .= " nome_cliente, ";
                $sql_i .= " cnpj, ";
                $sql_i .= " campo_semcnpj, ";

                $sql_i .= " razao_social, ";
                $sql_i .= " dap, ";
                $sql_i .= " nirf, ";
                $sql_i .= " rmp, ";
                $sql_i .= " ie, ";
                $sql_i .= " sicab, ";
                $sql_i .= " meta_afetada, ";
                $sql_i .= " meta1, ";
                $sql_i .= " meta2, ";
                $sql_i .= " meta3, ";
                $sql_i .= " meta4, ";
                $sql_i .= " meta5, ";
                $sql_i .= " meta6, ";
                $sql_i .= " meta7, ";
                $sql_i .= " meta8, ";
                $sql_i .= " meta9  ";
                $sql_i .= "  ) values ( ";
                $sql_i .= " $codrealizacao, ";
                $sql_i .= " $codempreendimentow, ";
                $sql_i .= " $flag_atu, ";
                $sql_i .= " $ano, ";
                $sql_i .= " $tiporealizacao, ";
                $sql_i .= " $instrumento, ";
                $sql_i .= " $cidade, ";
                $sql_i .= " $codmicro, ";
                $sql_i .= " $regional_da_jurisdicao, ";
                $sql_i .= " $escritorio_de_atendimento, ";
                $sql_i .= " $tipo_pessoa, ";
                $sql_i .= " $datahorainicial, ";
                $sql_i .= " $datahorafinal, ";
                $sql_i .= " $tipo_de_empreendimento, ";
                $sql_i .= " $porte, ";
                $sql_i .= " $setor, ";
                $sql_i .= " $atividade_economica, ";
                $sql_i .= " $cpf, ";
                $sql_i .= " $nome_cliente, ";
                $sql_i .= " $cnpj, ";
                $sql_i .= " $campo_semcnpj, ";
                $sql_i .= " $razao_social, ";
                $sql_i .= " $dap, ";
                $sql_i .= " $nirf, ";
                $sql_i .= " $rmp, ";
                $sql_i .= " $ie, ";
                $sql_i .= " $sicab, ";
                $sql_i .= " $meta_afetada, ";
                $sql_i .= " $meta1, ";
                $sql_i .= " $meta2, ";
                $sql_i .= " $meta3, ";
                $sql_i .= " $meta4, ";
                $sql_i .= " $meta5, ";
                $sql_i .= " $meta6, ";
                $sql_i .= " $meta7, ";
                $sql_i .= " $meta8, ";
                $sql_i .= " $meta9  ";
                $sql_i .= ") ";
                $result = execsql($sql_i);

                $quantidadew = $quantidadew + 1;
                // $qtdaexecutar
                $resto = $quantidadew % $intervalo;
                if ($resto == 0) {
                    $datehora = date('d/m/Y H:i:s');
                    $textograva .= "-- {$datehora} " . $fimlinha;
                    $textograva .= "-- {$datehora} Gravados  : " . $quantidadew . $fimlinha;
                    $faltagravar = $qtdaexecutar - $quantidadew;
                    $textograva .= "-- A Gravar  : " . $faltagravar . $fimlinha;
                    $perc = ($quantidadew / $qtdaexecutar) * 100;
                    $textograva .= "-- % Gravados: " . format_decimal($perc, 2) . $fimlinha;
                    $fp = fopen($caminho, "w");
                    $escreve = fwrite($fp, $textograva);
                    fclose($fp);

                    $percg = format_decimal($perc, 2);
                    $textogravaG .= "-- Gravados: {$quantidadew} Percentual: {$percg} %" . $fimlinha;
                    $caminhog = path_fisico . "obj_file/funil/job_funil_execucao.log";
                    $fpg = fopen($caminhog, "w");
                    $escreve = fwrite($fpg, $textogravaG);
                    fclose($fp);
                    // para testar select novo
                    //die();
                }










                //	}
                //	else
                //	{
                //		foreach ($rst->data as $rowt) {
                //			$idt = $rowt['idt'];
                //			// atualizar;
                //			$flag_atu = aspa('S');
                //			$sql_a = " update grc_funil_gestao_meta set ";
                //			$sql_a .= " flag_atu     = $flag_atu, ";
                //			$sql_a .= " escritorio_de_atendimento = $escritorio_de_atendimento, ";
                //			$sql_a .= " tiporealizacao = $tiporealizacao, ";
                //			$sql_a .= " cnpj         = $cnpj, ";
                //			$sql_a .= " razao_social = $razao_social, ";
                //			$sql_a .= " cpf          = $cpf, ";
                //			$sql_a .= " nome_cliente = $nome_cliente, ";
                //			$sql_a .= " meta1        = $meta1, ";
                //			$sql_a .= " meta2        = $meta2, ";
                //			$sql_a .= " meta3        = $meta3, ";
                //			$sql_a .= " meta4        = $meta4, ";
                //			$sql_a .= " meta5        = $meta5, ";
                //			$sql_a .= " meta6        = $meta6, ";
                //			$sql_a .= " meta7        = $meta7, ";
                //			$sql_a .= " meta8        = $meta8 ";
                //			$sql_a .= " where idt = " . null($idt);
                //			$result = execsql($sql_a);
                //							
                //		}	
                //	}
            }
            //$sql = ' delete from ';
            //$sql .= ' grc_funil_gestao_meta ';
            //$sql .= " where ano      = ".aspa($ano_atual);
            //$sql .= "   and flag_atu = ".aspa('N');
            //$rs = execsql($sql);
            // commit();
            set_time_limit(30);


            $resto = $quantidadew % $intervalo;
            if ($resto != 0) {
                $datehora = date('d/m/Y H:i:s');
                $textograva .= "-- {$datehora} " . $fimlinha;
                $textograva .= "-- {$datehora} Gravados  : " . $quantidadew . $fimlinha;
                $faltagravar = $qtdaexecutar - $quantidadew;
                $textograva .= "-- A Gravar  : " . $faltagravar . $fimlinha;
                $perc = ($quantidadew / $qtdaexecutar) * 100;
                $textograva .= "-- % Gravados: " . format_decimal($perc, 2) . $fimlinha;
                $fp = fopen($caminho, "w");
                $escreve = fwrite($fp, $textograva);
                fclose($fp);

                $percg = format_decimal($perc, 2);
                $textogravaG .= "-- Gravados: {$quantidadew} Percentual: {$percg} %" . $fimlinha;
                $caminhog = path_fisico . "obj_file/funil/job_funil_execucao.log";
                $fpg = fopen($caminhog, "w");
                $escreve = fwrite($fpg, $textogravaG);
                fclose($fp);
            }




            $datehora = date('d/m/Y H:i:s');
            $textograva .= "-- {$datehora} Término Gravação dos Registros  " . $fimlinha;
            $fp = fopen($caminho, "w");
            $escreve = fwrite($fp, $textograva);
            fclose($fp);
            $kokw = 1;


            // Controle Geral da execução
            $textogravaG .= "-- Final em {$datehora} " . $fimlinha;
            $textogravaG .= "-- status - 01 OK " . $fimlinha;
            $caminho = path_fisico . "obj_file/funil/job_funil_execucao.log";
            $fp = fopen($caminho, "w");
            $escreve = fwrite($fp, $textogravaG);
            fclose($fp);
            //
        }
    } catch (Exception $e) {
        $erro = 'O Sistema encontrou problemas para Gerar Base para Funil.\n' . $e->getMessage();
        $datehora = date('d/m/Y H:i:s');
        $textograva .= "-- {$datehora} Término ANORMAL DA GERAÇÃO BASE FUNIL " . $erro . $fimlinha;
        $fp = fopen($caminho, "w");
        $escreve = fwrite($fp, $textograva);
        fclose($fp);
        $kokw = 0;

        // Controle Geral da execução
        $textogravaG .= "-- Final em {$datehora}  " . $fimlinha;
        $textogravaG .= "-- status - 01 COM ERRO " . $fimlinha;
        $caminho = path_fisico . "obj_file/funil/job_funil_execucao.log";
        $fp = fopen($caminho, "w");
        $escreve = fwrite($fp, $textogravaG);
        fclose($fp);
    }

    $vetParametro['textogravaG'] = $textogravaG;
    return $kokw;
}

function FunilClassificaCliente(&$vetParametro) {
    $kokw = 0;
    $fimlinha = chr(13);

    $textogravaG = $vetParametro['textogravaG'];


    // Controle Geral da execução
    $datehora = date('d/m/Y H:i:s');
    $textogravaG .= "-- Início em {$datehora} " . $fimlinha;
    $textogravaG .= "-- Etapa 02 - Classificação do Cliente " . $fimlinha;
    $caminho = path_fisico . "obj_file/funil/job_funil_execucao.log";
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textogravaG);
    fclose($fp);




    $textograva = "";
    $datehora = date('d/m/Y H:i:s');
    $textograva .= "-- Início em {$datehora} do Processo de Classificação de Clientes para Funil no CRM|Sebrae.{$fimlinha}";
    $datehoraarq = str_replace(' ', '', $datehora);
    $datehoraarq = str_replace('/', '', $datehoraarq);
    $datehoraarq = str_replace(':', '', $datehoraarq);
    $datehoraarqw = substr($datehoraarq, 4, 4) . substr($datehoraarq, 2, 2) . substr($datehoraarq, 0, 2) . substr($datehoraarq, 8, 6);
    $caminho = path_fisico . "obj_file/funil/job_funil_ClassificaCliente{$datehoraarqw}.log";
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva);
    fclose($fp);
    $vetRetorno = Array();
    $ano_atual = Funil_parametro(1, $vetRetorno);
    $textograva .= "-- Ano Atual = {$ano_atual}";
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva);
    fclose($fp);
    // Leitura dos dados oriundos do select do SiacWeb com Metas afetadas
    // beginTransaction();
    $qtdaexecutar = $rst->rows;
    $textograva .= "-- Quantidade de Registros a Gravar " . $qtdaexecutar . $fimlinha;
    $datehora = date('d/m/Y H:i:s');
    $textograva .= "-- {$datehora} Inicio da Classificação do Cliente no CRM Lendo: grc_funil_{$ano_atual}_gestao_meta   " . $fimlinha;
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva);
    fclose($fp);
    set_time_limit(0);
    $sql_a = " truncate table grc_funil_{$ano_atual}_cliente_classificado ";
    $result = execsql($sql_a);
    $textograva .= "-- Fim do Truncate Tabela do banco do GRC  grc_funil_{$ano_atual}_cliente_classificado   " . $fimlinha;

    $sql_a = " truncate table grc_funil_{$ano_atual}_jurisdicao ";
    $result = execsql($sql_a);
    $textograva .= "-- Fim do Truncate Tabela do banco do GRC  grc_funil_{$ano_atual}_jurisdicao   " . $fimlinha;


    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva);
    fclose($fp);
    set_time_limit(0);
    $datehora = date('d/m/Y H:i:s');
    $textograva .= "-- {$datehora} Iniciar Gravação dos Registros  " . $fimlinha;
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva);
    fclose($fp);
    $quantidadew = 0;
    $sqlt = "";
    $sqlt .= " select distinct ";
    $sqlt .= " tipo_de_empreendimento, ";
    $sqlt .= " cnpj ";
    $sqlt .= " from grc_funil_{$ano_atual}_gestao_meta  ";

    // acho que não tem necessidade desse where
    //$sqlt .= " where meta1 = 'S' or meta7 = 'S' ";

    $rst = execsqlNomeCol($sqlt);
    if ($rst->rows == 0) {
        $textograva .= "-- Encontrado EOF " . $fimlinha;
        $fp = fopen($caminho, "w");
        $escreve = fwrite($fp, $textograva);
        fclose($fp);
    } else {
        $datehora = date('d/m/Y H:i:s');
        $textograva .= "-- {$datehora} Executado o Select  " . $fimlinha;
        $fp = fopen($caminho, "w");
        $escreve = fwrite($fp, $textograva);
        fclose($fp);
        $intervalo = 5000;
        foreach ($rst->data as $rowt) {
            set_time_limit(60);
            $cnpjw = $rowt['cnpj'];
            $tipo_de_empreendimentow = $rowt['tipo_de_empreendimento'];
            $cnpj = aspa($cnpjw);
            $tipo_de_empreendimento = aspa($tipo_de_empreendimentow);
            // Para testar classificação do cliente
            $sqlt = "";
            $sqlt .= " select ";
            $sqlt .= " regional_da_jurisdicao, ";
            $sqlt .= " razao_social,   ";
            $sqlt .= " codmicro, ";
            $sqlt .= " regional_da_jurisdicao,   ";
            $sqlt .= " escritorio_de_atendimento,   ";
            $sqlt .= " cnpj,   ";
            //$sqlt .= " tipo_de_empreendimento,   ";
            $sqlt .= " campo_semcnpj,   ";
            $sqlt .= " dap,   ";
            $sqlt .= " nirf,   ";
            $sqlt .= " rmp,   ";
            $sqlt .= " ie,   ";
            $sqlt .= " sicab   ";
            $sqlt .= " from grc_funil_{$ano_atual}_gestao_meta  ";
            $sqlt .= " where tipo_de_empreendimento = $tipo_de_empreendimento ";
            $sqlt .= "   and cnpj                   = $cnpj ";
            $sqlt .= "   order by datahorainicial desc ";
            $sqlt .= "   limit 1 ";
            $rstw = execsqlNomeCol($sqlt);
            if ($rstw->rows == 0) {
                // Erro grave
            } else {
                foreach ($rstw->data as $rowtw) {
                    $codmicro = $rowtw['codmicro'];
                    $regional_da_jurisdicao = $rowtw['regional_da_jurisdicao'];
                    $escritorio_de_atendimento = $rowtw['escritorio_de_atendimento'];
                    $cnpj = $rowtw['cnpj'];
                    //		$tipo_de_empreendimento = $rowtw['tipo_de_empreendimento'];
                    $campo_semcnpj = $rowtw['campo_semcnpj'];
                    $razao_socialw = $rowtw['razao_social'];
                    $dap = $rowtw['dap'];
                    $nirf = $rowtw['nirf'];
                    $rmp = $rowtw['rmp'];
                    $ie = $rowtw['ie'];
                    $sicab = $rowtw['sicab'];
                }
                if ($codmicro == '') {
                    $codmicro = 9999;
                }
                $idt_ponto_atendimento_regionalw = $codmicro;
                $codmicro = null($codmicro);

                $regional_da_jurisdicao = aspa($regional_da_jurisdicao);
                $sqltx = "";
                $sqltx .= " select idt ";
                $sqltx .= " from grc_funil_{$ano_atual}_jurisdicao  ";
                $sqltx .= " where codigo = " . ($codmicro);
                $rstx = execsqlNomeCol($sqltx);
                if ($rstx->rows == 0) {
                    $sql_i = " insert into grc_funil_{$ano_atual}_jurisdicao ";
                    $sql_i .= " (  ";
                    $sql_i .= " codigo, ";
                    $sql_i .= " descricao ";
                    $sql_i .= "  ) values ( ";
                    $sql_i .= " $codmicro, ";
                    $sql_i .= " $regional_da_jurisdicao ";
                    $sql_i .= ") ";
                    $result = execsql($sql_i);
                }
                $vetParametros['tipo_de_empreendimento'] = $tipo_de_empreendimentow;
                $vetParametros['cnpj'] = $cnpj;
                $vetParametros['campo_semcnpj'] = $campo_semcnpj;

                $vetParametros['dap'] = $dap;
                $vetParametros['nirf'] = $nirf;
                $vetParametros['rmp'] = $rmp;
                $vetParametros['ie'] = $rmp;
                $vetParametros['sicab'] = $sicab;
                //


                FunilClassificarCliente($vetParametros, $vetRetorno);
                $nota = $vetRetorno['funil_nota_cliente_classificacao'];
                $vetFunilNotaMinima = $vetRetorno['funil_faixa_nota_cliente_classificacao'];
                $funil_idt_cliente_classificacao = $vetRetorno['funil_idt_cliente_classificacao'];
                $vetMetas = $vetRetorno['vetMetas'];
                $meta1 = aspa($vetMetas[1]);
                $meta7 = aspa($vetMetas[7]);

                $codigo = aspa($cnpj);
                $razao_social = aspa($razao_socialw);
                $idt_ponto_atendimento = null($idt_ponto_atendimentow);
                $ponto_atendimento = aspa($escritorio_de_atendimento);
                $ponto_atendimento_regional = aspa($regional_da_jurisdicao);
                $idt_ponto_atendimento_regional = null($idt_ponto_atendimento_regionalw);
                $nota = null($nota);
                $nota_promotor = null($vetFunilNotaMinima['NOTA_PROMOTOR']);
                $nota_detrator = null($vetFunilNotaMinima['NOTA_DETRATOR']);
                $idt_cliente_classificacao = null($funil_idt_cliente_classificacao);
                $tipo_cliente = aspa($tipo_de_empreendimentow);

                $campo_semcnpjw = aspa($campo_semcnpj);
                $sql_i = " insert into grc_funil_{$ano_atual}_cliente_classificado ";
                $sql_i .= " (  ";
                $sql_i .= " tipo_cliente, ";
                $sql_i .= " codigo, ";
                $sql_i .= " campo_semcnpj, ";
                $sql_i .= " razao_social, ";
                $sql_i .= " idt_ponto_atendimento, ";
                $sql_i .= " ponto_atendimento, ";
                $sql_i .= " idt_ponto_atendimento_regional, ";
                $sql_i .= " ponto_atendimento_regional, ";
                $sql_i .= " nota_promotor, ";
                $sql_i .= " nota_detrator, ";
                $sql_i .= " nota, ";
                $sql_i .= " meta1, ";
                $sql_i .= " meta7, ";
                $sql_i .= " idt_cliente_classificacao ";
                $sql_i .= "  ) values ( ";
                $sql_i .= " $tipo_cliente, ";
                $sql_i .= " $codigo, ";
                $sql_i .= " $campo_semcnpjw, ";
                $sql_i .= " $razao_social, ";
                $sql_i .= " $idt_ponto_atendimento, ";
                $sql_i .= " $ponto_atendimento, ";
                $sql_i .= " $idt_ponto_atendimento_regional, ";
                $sql_i .= " $ponto_atendimento_regional, ";
                $sql_i .= " $nota_promotor, ";
                $sql_i .= " $nota_detrator, ";
                $sql_i .= " $nota, ";
                $sql_i .= " $meta1, ";
                $sql_i .= " $meta7, ";
                $sql_i .= " $idt_cliente_classificacao ";

                $sql_i .= ") ";
                $result = execsql($sql_i);
                $quantidadew = $quantidadew + 1;
                $resto = $quantidadew % $intervalo;
                if ($resto == 0) {
                    $datehora = date('d/m/Y H:i:s');
                    $textograva .= "-- {$datehora} " . $fimlinha;
                    $textograva .= "-- Classificados: " . format_decimal($quantidadew, 0) . $fimlinha;
                    $fp = fopen($caminho, "w");
                    $escreve = fwrite($fp, $textograva);
                    fclose($fp);

                    $datehora = date('d/m/Y H:i:s');
                    $textogravaG .= "-- Classificados: [$datehora] " . format_decimal($quantidadew, 0) . ".{$fimlinha}";
                    $caminhog = path_fisico . "obj_file/funil/job_funil_execucao.log";
                    $fpg = fopen($caminhog, "w");
                    $escreve = fwrite($fpg, $textogravaG);
                    fclose($fpg);
                }
            }
        }

        $resto = $quantidadew % $intervalo;
        if ($resto == 0) {
            $datehora = date('d/m/Y H:i:s');
            $textograva .= "-- {$datehora} " . $fimlinha;
            $textograva .= "-- Classificados: " . format_decimal($quantidadew, 0) . $fimlinha;
            $fp = fopen($caminho, "w");
            $escreve = fwrite($fp, $textograva);
            fclose($fp);

            $datehora = date('d/m/Y H:i:s');
            $textogravaG .= "-- Classificados: [$datehora] " . format_decimal($quantidadew, 0) . ".{$fimlinha}";
            $caminhog = path_fisico . "obj_file/funil/job_funil_execucao.log";
            $fpg = fopen($caminhog, "w");
            $escreve = fwrite($fpg, $textogravaG);
            fclose($fpg);
        }

        $datehora = date('d/m/Y H:i:s');
        $textograva .= "-- {$datehora} " . $fimlinha;
        $textograva .= "-- {$datehora} Gravados  : " . $quantidadew . $fimlinha;
        $fp = fopen($caminho, "w");
        $escreve = fwrite($fp, $textograva);
        fclose($fp);
        $kokw = 1;
    }
    // commit();
    //
    $datehora = date('d/m/Y H:i:s');
    $textograva .= "-- {$datehora} Término Classificação dos Clientes para o Funil " . $fimlinha;
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva);
    fclose($fp);
    // Controle Geral da execução
    $datehora = date('d/m/Y H:i:s');
    $textogravaG .= "-- Término em {$datehora} " . $fimlinha;
    $textogravaG .= "-- Etapa 02 - Classificação do Cliente " . $fimlinha;
    $textogravaG .= "-- status - OK " . $fimlinha;
    $caminho = path_fisico . "obj_file/funil/job_funil_execucao.log";
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textogravaG);
    fclose($fp);
    //
    //  ATUALIZAR O GEC
    //
	if ($kokw == 1) {
        $datehora = date('d/m/Y H:i:s');
        $textogravaG .= "-- Inicio em {$datehora} Classificação Clientes no CRM  " . $fimlinha;
        $textogravaG .= "-- Etapa 03 - Classificação Cliente CRM " . $fimlinha;
        $caminho = path_fisico . "obj_file/funil/job_funil_execucao.log";
        $fp = fopen($caminho, "w");
        $escreve = fwrite($fp, $textogravaG);
        fclose($fp);
        $vetRetorno['textogravaG'] = $textogravaG;

        FunilClassificaClienteGEC($vetParametros, $vetRetorno);

        $textogravaG = $vetRetorno['textogravaG'];

        $datehora = date('d/m/Y H:i:s');
        $textogravaG .= "-- Término em {$datehora}" . $fimlinha;
        $textogravaG .= "-- Etapa 03 - Classificação Cliente CRM " . $fimlinha;
        $textogravaG .= "-- status - OK " . $fimlinha;
        $caminho = path_fisico . "obj_file/funil/job_funil_execucao.log";
        $fp = fopen($caminho, "w");
        $escreve = fwrite($fp, $textogravaG);
        fclose($fp);
    }

    $datehora = date('d/m/Y H:i:s');
    $textogravaG .= "-- Término do JOB FUNIL em {$datehora}" . $fimlinha;
    $textogravaG .= "-- status = OK " . $fimlinha;
    $caminho = path_fisico . "obj_file/funil/job_funil_execucao.log";
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textogravaG);
    fclose($fp);


    return $kokw;
}

// GRAVAR NO GEC
function FunilClassificaClienteGEC($vetParametros, &$vetRetorno) {
    $kokw = 0;
    $textograva_log = $vetRetorno['textograva_log'];
    $fimlinha = chr(13);



    $textogravaG = $vetRetorno['textogravaG'];
    $datehora = date('d/m/Y H:i:s');
    $textogravaG .= "-- Início Classificação Clientes do CRM {$datehora}" . $fimlinha;
    $caminhog = path_fisico . "obj_file/funil/job_funil_execucao.log";
    $fpg = fopen($caminhog, "w");
    $escreve = fwrite($fpg, $textogravaG);
    fclose($fpg);






    $textograva = "";
    $datehora = date('d/m/Y H:i:s');
    $textograva .= "-- Início em {$datehora} do Processo de Classificação de Clientes para Funil no GEC_ENTIDADE.{$fimlinha}";
    $datehoraarq = str_replace(' ', '', $datehora);
    $datehoraarq = str_replace('/', '', $datehoraarq);
    $datehoraarq = str_replace(':', '', $datehoraarq);
    $datehoraarqw = substr($datehoraarq, 4, 4) . substr($datehoraarq, 2, 2) . substr($datehoraarq, 0, 2) . substr($datehoraarq, 8, 6);
    $caminho = path_fisico . "obj_file/funil/job_funil_ClassificaClienteGEC{$datehoraarqw}.log";
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva);
    fclose($fp);
    $vetRetorno = Array();
    $ano_atual = Funil_parametro(1, $vetRetorno);
    $textograva .= "-- Ano Atual = {$ano_atual}";
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva);
    fclose($fp);
    // Leitura dos dados 

    $textograva_log .= "-- Início em {$datehora} do Processo de Classificação de Clientes para Funil no GEC_ENTIDADE.{$fimlinha}";

    $sqltp = "";
    $sqltp .= " select tipo_cliente, campo_semcnpj, codigo, idt_cliente_classificacao, idt_ponto_atendimento, idt_ponto_atendimento_regional  ";
    $sqltp .= " from grc_funil_{$ano_atual}_cliente_classificado  ";
    $rstp = execsqlNomeCol($sqltp);

    //beginTransaction();
    $qtdaexecutar = $rstp->rows;


    $datehora = date('d/m/Y H:i:s');
    $textogravaG .= "Quantidade a Classificar:{$qtdaexecutar}" . $fimlinha;
    $caminhog = path_fisico . "obj_file/funil/job_funil_execucao.log";
    $fpg = fopen($caminhog, "w");
    $escreve = fwrite($fpg, $textogravaG);
    fclose($fpg);



    $textograva .= "-- Quantidade de Registros a Ler " . $qtdaexecutar . $fimlinha;
    $datehora = date('d/m/Y H:i:s');
    $textograva .= "-- {$datehora} Inicio da Classificação do Cliente no CRM|GEC Lendo: from grc_funil_{$ano_atual}_cliente_classificado   " . $fimlinha;
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva);
    fclose($fp);
    // 
    $qtdcli = $rstp->rows;
    $textograva_log .= "-- Quantidade de Clientes a Classificar {$qtdcli} .{$fimlinha}";
    //

    if ($rstp->rows == 0) {
        $textograva .= "-- Encontrado EOF " . $fimlinha;
        $fp = fopen($caminho, "w");
        $escreve = fwrite($fp, $textograva);
        fclose($fp);
    } else {
        $quantidade = 0;
        $quantidade_gec = 0;
        $intervalo = 5000;
        $vetMatrizFunilRelatorio = Array();
        foreach ($rstp->data as $rowtp) {
            set_time_limit(60);
            $tipo_cliente = $rowtp['tipo_cliente'];
            $cnpjw = $rowtp['codigo'];
            $idt_cliente_classificacao = $rowtp['idt_cliente_classificacao'];
            $idt_ponto_atendimento = $rowtp['idt_ponto_atendimento'];
            $idt_ponto_atendimento_regional = $rowtp['idt_ponto_atendimento_regional'];
            $campo_semcnpj = $rowtp['campo_semcnpj'];

            $idt_classificacao = $rowtp['idt_cliente_classificacao'];
            $qtd = 1;
            if ($idt_classificacao == 1) {
                
            }
            if ($idt_classificacao == 2) {
                // $qtd = 2;
            }
            if ($idt_classificacao == 3) {
                
            }
            if ($idt_classificacao == 4) {
                
            }
            if ($idt_classificacao == 5) {
                
            }
            if ($idt_classificacao == 6) {
                
            }

            // Montar planilha do relatório peço método entendido pela LUPE
            $vetMatrizFunilRelatorio[$idt_ponto_atendimento_regional][$idt_cliente_classificacao] = $vetMatrizFunilRelatorio[$idt_ponto_atendimento_regional][$idt_cliente_classificacao] + $qtd;

            if ($idt_classificacao >= 3 and $idt_classificacao <= 6) {
                //   $vetMatrizFunilRelatorio[$idt_ponto_atendimento_regional][2] = $vetMatrizFunilRelatorio[$idt_ponto_atendimento_regional][2] + $qtd;
            }


            if ($tipo_cliente == 'Empresa (com CNPJ)') {
                $sqlt = "";
                $sqlt .= " select idt ";
                // $sqlt .= " funil_cliente_nota_avaliacao ";
                $sqlt .= " from " . db_pir_gec . "gec_entidade ";
                $sqlt .= " where codigo = " . aspa($cnpjw);
                $sqlt .= "   and reg_situacao = " . aspa('A');
                $rst = execsqlNomeCol($sqlt);
                if ($rst->rows == 0) {
                    // Não esta cadastrado no CRM
                    // Deve ser cliente sem cnpj
                } else {
                    foreach ($rst->data as $rowt) {
                        $idt = $rowt['idt'];
                        $sql_a = " update " . db_pir_gec . "gec_entidade set ";
                        $sql_a .= " funil_idt_cliente_classificacao = " . null($idt_cliente_classificacao) . " ";
                        $sql_a .= " where idt = " . null($idt);
                        $result = execsql($sql_a);
                        $quantidade_gec = $quantidade_gec + 1;
                    }
                }
            } else {
                $campo = $campo_semcnpj;
                if ($campo == '' or $campo == 'cnpj') {
                    $campo = 'gec_e.codigo';
                }

                $sqlt = "";
                $sqlt .= " select gec_e.idt ";
                // $sqlt .= " funil_cliente_nota_avaliacao ";
                $sqlt .= " from " . db_pir_gec . "gec_entidade gec_e";
                $sqlt .= " inner join " . db_pir_gec . "gec_entidade_organizacao gec_o on gec_o.idt_entidade = gec_e.idt ";
                $sqlt .= " where {$campo} = " . aspa($cnpjw);
                $sqlt .= "   and gec_e.reg_situacao = " . aspa('A');
                $rst = execsqlNomeCol($sqlt);
                if ($rst->rows == 0) {
                    // Não esta cadastrado no CRM
                    // Deve ser cliente sem cnpj
                } else {
                    foreach ($rst->data as $rowt) {
                        $idt = $rowt['idt'];
                        $sql_a = " update " . db_pir_gec . "gec_entidade set ";
                        $sql_a .= " funil_idt_cliente_classificacao = " . null($idt_cliente_classificacao) . " ";
                        $sql_a .= " where idt = " . null($idt);
                        $result = execsql($sql_a);
                        $quantidade_gec = $quantidade_gec + 1;
                    }
                }
            }



            $quantidadew = $quantidadew + 1;
            // $qtdaexecutar
            $resto = $quantidadew % $intervalo;
            if ($resto == 0) {
                $datehora = date('d/m/Y H:i:s');
                $textograva .= "-- {$datehora} " . $fimlinha;

                $textograva .= "-- {$datehora} Atualizado GEC  : " . $quantidade_gec . $fimlinha;

                $textograva .= "-- {$datehora} Gravados  : " . $quantidadew . $fimlinha;
                $faltagravar = $qtdaexecutar - $quantidadew;
                $textograva .= "-- A Gravar  : " . $faltagravar . $fimlinha;
                $perc = ($quantidadew / $qtdaexecutar) * 100;
                $textograva .= "-- % Gravados: " . format_decimal($perc, 2) . $fimlinha;
                $fp = fopen($caminho, "w");
                $escreve = fwrite($fp, $textograva);
                fclose($fp);

                $textograva_log .= "-- Classificados {$quantidadew} .{$fimlinha}";

                $datehora = date('d/m/Y H:i:s');
                $percw = format_decimal($perc, 2);
                $textogravaG .= "{$datehora} Atualizado GEC  : {$quantidade_gec} Percentual: {$percw} % " . $fimlinha;
                $caminhog = path_fisico . "obj_file/funil/job_funil_execucao.log";
                $fpg = fopen($caminhog, "w");
                $escreve = fwrite($fpg, $textogravaG);
                fclose($fpg);
            }
        }
    }
//    commit();
    // carregar vetor como solicitado pelo SEBRAE de forma Errada na visão da LUPE
    $vetMatrizFunilRelatorio = Array();
    $vetMatrizFunilRelatorioMeta1 = Array();
    $vetMatrizFunilRelatorioMeta1D = Array();
    $vetMatrizFunilRelatorioMeta7 = Array();
    $vetMatrizFunilRelatorioMeta7D = Array();
    // Buscar a META 1 = LEAD
    $sqltp = "";
    $sqltp .= " select codmicro, regional_da_jurisdicao, count(distinct codempreendimento) as quantidade  ";
    $sqltp .= " from grc_funil_{$ano_atual}_gestao_meta  ";
    $sqltp .= " where meta_afetada like '%1%'  ";
    $sqltp .= " group by  codmicro, regional_da_jurisdicao ";
    $rstp = execsqlNomeCol($sqltp);
    $qtdaexecutar = $rstp->rows;
    $datehora = date('d/m/Y H:i:s');
    $textogravaG .= "Classificar META1 LEAD:{$qtdaexecutar}" . $fimlinha;
    $caminhog = path_fisico . "obj_file/funil/job_funil_execucao.log";
    $fpg = fopen($caminhog, "w");
    $escreve = fwrite($fpg, $textogravaG);
    if ($rstp->rows == 0) {
        $textogravaG .= "-- Encontrado EOF classificação META 1 " . $fimlinha;
        $fpg = fopen($caminhog, "w");
        $escreve = fwrite($fpg, $textogravaG);
        fclose($fpg);
    } else {
        $idt_cliente_classificacao = 2;
        foreach ($rstp->data as $rowtp) {
            $codmicro = $rowtp['codmicro'];
            $regional_da_jurisdicao = $rowtp['regional_da_jurisdicao'];
            $quantidade = $rowtp['quantidade'];
            if ($codmicro == "") {
                $codmicro = 9999;
            }
            $vetMatrizFunilRelatorioMeta1[$codmicro] = $quantidade;
            $vetMatrizFunilRelatorioMeta1D[$codmicro] = $regional_da_jurisdicao;
            // Montar planilha do relatório peLo método entendido pela SEBRAE
            $idt_ponto_atendimento_regional = $codmicro;
            $vetMatrizFunilRelatorio[$idt_ponto_atendimento_regional][$idt_cliente_classificacao] = $quantidade;
        }
    }
    // Buscar a META 7 = CLIENTE
    $sqltp = "";
    $sqltp .= " select codmicro, regional_da_jurisdicao, count(distinct codempreendimento) as quantidade  ";
    $sqltp .= " from grc_funil_{$ano_atual}_gestao_meta  ";
    $sqltp .= " where meta_afetada like '%7%'  ";
    $sqltp .= " group by  codmicro, regional_da_jurisdicao ";
    $rstp = execsqlNomeCol($sqltp);
    $qtdaexecutar = $rstp->rows;
    $datehora = date('d/m/Y H:i:s');
    $textogravaG .= "Classificar META7 CLIENTE:{$qtdaexecutar}" . $fimlinha;
    $caminhog = path_fisico . "obj_file/funil/job_funil_execucao.log";
    $fpg = fopen($caminhog, "w");
    $escreve = fwrite($fpg, $textogravaG);
    if ($rstp->rows == 0) {
        $textogravaG .= "-- Encontrado EOF classificação META 7 " . $fimlinha;
        $fpg = fopen($caminhog, "w");
        $escreve = fwrite($fpg, $textogravaG);
        fclose($fpg);
    } else {
        foreach ($rstp->data as $rowtp) {
            $codmicro = $rowtp['codmicro'];
            $regional_da_jurisdicao = $rowtp['regional_da_jurisdicao'];
            $quantidade = $rowtp['quantidade'];
            if ($codmicro == "") {
                $codmicro = 9999;
            }
            $vetMatrizFunilRelatorioMeta7[$codmicro] = $quantidade;
            $vetMatrizFunilRelatorioMeta7D[$codmicro] = $regional_da_jurisdicao;
            // CLASSIFICAR CLIENTE
            $idt_cliente_classificacao = 3; // SEM CLASSIFICACAO
            $idt_cliente_classificacao = 4; // DETRATOR
            $idt_cliente_classificacao = 5; // NEUTRO
            $idt_cliente_classificacao = 6; // PROMOTOR
            // HOJE NÃO TEM NOTA ENTÃO TODOS SÃO SEM CLASSIFICAR
            // VER COMO CLASSIFICAR POIS EXISTE INCOMPATIBILIDADE DE REGRA
            $idt_cliente_classificacao = 3; // SEM CLASSIFICACAO
            // na verdade esse é o total de CLIENTES mas, nessa etapa como não tem Nota to carregando em sem classificar
            // essa rotina tem que pegar cliente a cliente para classificar
            // a tabela de clientes classificados não atende pois eles fazem a contagem por regional e codigo do empreendimento
            // e não pelo CNPJ chaves do produtor rural dai vai dar diferença...
            // isso tem que ser ajustado quando carregar NOTA do CLIENTE.
            // Montar planilha do relatório peLo método entendido pela SEBRAE
            $idt_ponto_atendimento_regional = $codmicro;
            $vetMatrizFunilRelatorio[$idt_ponto_atendimento_regional][$idt_cliente_classificacao] = $quantidade;
        }
    }
    ////////////////////////// 
    $vetRetorno['vetMatrizFunilRelatorio'] = $vetMatrizFunilRelatorio;
    foreach ($vetMatrizFunilRelatorio as $idt_ponto_atendimento => $vetCPA) {
        foreach ($vetCPA as $idt_classificacao => $quantidadeC) {
            $item = " $idt_ponto_atendimento, $idt_classificacao, $quantidadeC ";
            $textograva .= $item . $fimlinha;
        }
    }

    $vetRetorno['textograva_log'] = $textograva_log;
    FunilExecucaoRegional($vetMatrizFunilRelatorio, $vetRetorno);

    $difqtd = $qtdaexecutar - $quantidade_gec;

    $textograva .= "-- Qtd Clientes sensibilizados:($qtdaexecutar} Qtd Clientes sensibilizados GEC:{$quantidade_gec} Diferença: {$difqtd}" . $fimlinha;
    $datehora = date('d/m/Y H:i:s');
    $textograva .= "-- {$datehora} Término Classificação dos Clientes para o Funil no GEC_ENTIDADE" . $fimlinha;
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva);
    fclose($fp);


    $textograva_log = $vetRetorno['textograva_log'];
    $datehora = date('d/m/Y H:i:s');
    $textograva_log .= $fimlinha . "Fim Normal do JOB do FUNIL = {$datehora}";
    $caminho = path_fisico . "obj_file/funil/job_funil_ControleRelatorio_{$ano_atual}.log";
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva_log);
    fclose($fp);


    $datehora = date('d/m/Y H:i:s');
    $percw = format_decimal($perc, 2);
    $textogravaG .= "{$datehora} Atualizado GEC  : {$quantidade_gec} Percentual: {$percw} % " . $fimlinha;
    $caminhog = path_fisico . "obj_file/funil/job_funil_execucao.log";
    $fpg = fopen($caminhog, "w");
    $escreve = fwrite($fpg, $textogravaG);
    fclose($fpg);
}

function DescobreCampo($tipo_cliente, $cnpjw) {
    $campo = "";




    return $campo;
}

// GRAVAR NO EXECUÇÃO POR UNIDADE REGIONAL
function FunilExecucaoRegional($vetMatrizFunilRelatorio, &$vetRetorno) {
    $kokw = 0;
    $textograva_log = $vetRetorno['textograva_log'];
    $fimlinha = chr(13);
    $textograva = "";
    $datehora = date('d/m/Y H:i:s');
    $textograva .= "-- Início em {$datehora} do Processo de Execução por Regional.{$fimlinha}";
    $datehoraarq = str_replace(' ', '', $datehora);
    $datehoraarq = str_replace('/', '', $datehoraarq);
    $datehoraarq = str_replace(':', '', $datehoraarq);
    $datehoraarqw = substr($datehoraarq, 4, 4) . substr($datehoraarq, 2, 2) . substr($datehoraarq, 0, 2) . substr($datehoraarq, 8, 6);
    $caminho = path_fisico . "obj_file/funil/job_funil_ExecucaoRegional{$datehoraarqw}.log";
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva);
    fclose($fp);
    $vetRetornot = Array();
    $ano_atual = Funil_parametro(1, $vetRetornot);
    $textograva .= "-- Ano Atual = {$ano_atual}";
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva);
    fclose($fp);

    beginTransaction();
    $datehora = date('d/m/Y H:i:s');
    $textograva .= "-- {$datehora} Inicio da Informação da Execução por Regional Lendo: from grc_funil_{$ano_atual}_jurisdicao   " . $fimlinha;
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva);
    fclose($fp);

    ksort($vetMatrizFunilRelatorio);
    $vetRegional = Array();
    foreach ($vetMatrizFunilRelatorio as $idt_ponto_atendimento => $vetCPA) {
        $qtd_prospects = 0;
        $qtd_leads = 0;
        $qtd_sem_avaliacao = 0;
        $qtd_detrators = 0;
        $qtd_neutros = 0;
        $qtd_promotores = 0;
        foreach ($vetCPA as $idt_classificacao => $quantidadeC) {

            $item = " $idt_ponto_atendimento, $idt_classificacao, $quantidadeC ";
            $textograva .= $item . $fimlinha;
            if ($idt_classificacao == 1) {
                $qtd_prospects = $quantidadeC;
            }
            if ($idt_classificacao == 2) {
                $qtd_leads = $quantidadeC;
            }
            if ($idt_classificacao == 3) {
                $qtd_sem_avaliacao = $quantidadeC;
            }
            if ($idt_classificacao == 4) {
                $qtd_detrators = $quantidadeC;
            }
            if ($idt_classificacao == 5) {
                $qtd_neutros = $quantidadeC;
            }
            if ($idt_classificacao == 6) {
                $qtd_promotores = $quantidadeC;
            }
        }
        $sql_a = " update grc_funil_execucao set ";
        $sql_a .= " qtd_leads               = " . null($qtd_leads) . ", ";
        $sql_a .= " qtd_sem_avaliacao       = " . null($qtd_sem_avaliacao) . ", ";
        $sql_a .= " qtd_detrators           = " . null($qtd_detrators) . ", ";
        $sql_a .= " qtd_neutros             = " . null($qtd_neutros) . ", ";
        $sql_a .= " qtd_promotores          = " . null($qtd_promotores) . " ";
        $sql_a .= " where codigo_jurisdicao = " . null($idt_ponto_atendimento);
        $result = execsql($sql_a);
    }

    commit();

    $datehora = date('d/m/Y H:i:s');
    $textograva .= "-- {$datehora} Término Execução por Regional para o Funil" . $fimlinha;
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva);
    fclose($fp);

    $datehora = date('d/m/Y H:i:s');
    $textograva_log .= "DataBase = {$datehora}";
    $caminho = path_fisico . "obj_file/funil/job_funil_ControleRelatorio_{$ano_atual}.log";
    $fp = fopen($caminho, "w");
    $escreve = fwrite($fp, $textograva_log);
    fclose($fp);

    $vetRetorno['textograva_log'] = $textograva_log;
}

// parâmetros da função
// ['vetChaves'] - entrada : 	[cnpj]  cnpj  do Cliente com CNPJ
//                           	[dap]   dap   do Produtor Rural
//								[nirf]  nirf  do Produtor Rural
//								[rmp]   rmp - Registro Ministério da Pesca do Produtor Rural
//								[ie]    ie  - Inscrição Estadual  do Produtor Rural
//								[sicab] sicab do Artesão
// ['vetMetas']  - retorna : Vetor de 1 a 9 com indicação de S - sensibilizada ou N não sensibilizada 
function FunilMetasCliente($vetParametros, &$vetRetorno) {

    $vetMetas = Array();
    $vetMetas[1] = 'N';
    $vetMetas[2] = 'N';
    $vetMetas[3] = 'N';
    $vetMetas[4] = 'N';
    $vetMetas[5] = 'N';
    $vetMetas[6] = 'N';
    $vetMetas[7] = 'N';
    $vetMetas[8] = 'N';
    $vetMetas[9] = 'N';
    $ano_atual = $vetParametros['ano_atual'];
    if ($ano_atual == '') {
        $ano_atual = Funil_parametro(1, $vetRetorno);
    }
    $cnpj = $vetParametros['cnpj'];
    $dap = $vetParametros['dap'];
    $nirf = $vetParametros['nirf'];
    $rmp = $vetParametros['rmp'];
    $ie = $vetParametros['ie'];
    $sicab = $vetParametros['sicab'];
    if ($cnpj != "") {   // Cliente com CNPJ
        $sqlt = "";
        $sqlt .= " select ";
        $sqlt .= " cnpj, ";
        $sqlt .= " razao_social, ";
        $sqlt .= " meta1, ";
        $sqlt .= " meta7 ";
        $sqlt .= " from " . db_pir_grc . "grc_funil_{$ano_atual}_gestao_meta  ";
        $sqlt .= " where cnpj = " . aspa($cnpj);
        $sqlt .= "   and (meta1 = 'S' or meta7 = 'S') ";
        $rst = execsqlNomeCol($sqlt);
        if ($rst->rows == 0) {
            // Nada sensibilizado no Siacweb
        } else {
            foreach ($rst->data as $rowt) {
                if ($rowt['meta1'] == 'S') {
                    $vetMetas[1] = $rowt['meta1'];
                }
                if ($rowt['meta7'] == 'S') {
                    $vetMetas[7] = $rowt['meta7'];
                }
            }
        }
    }
    $vetRetorno['vetMetas'] = $vetMetas;
    return 1;
}

// parâmetros da função
// ['vetChaves'] - entrada : 	[cnpj]  cnpj  do Cliente com CNPJ
//                           	[dap]   dap   do Produtor Rural
//								[nirf]  nirf  do Produtor Rural
//								[rmp]   rmp - Registro Ministério da Pesca do Produtor Rural
//								[ie]    ie  - Inscrição Estadual  do Produtor Rural
//								[sicab] sicab do Artesão
//								[nota]  Nota atribuida ao cliente
// ['vetMetas']  - retorna : Vetor de 1 a 9 com indicação de S - sensibilizada ou N não sensibilizada 
function FunilClassificarCliente($vetParametros, &$vetRetorno) {
    // Obter quais Metas foram sensibilizadas
    $ano_atual = Funil_parametro(1, $vetRetorno);
    $vetParametros['ano_atual'] = $ano_atual;
    $nota = $vetParametros['nota'];
    $tipo_de_empreendimento = $vetParametros['tipo_de_empreendimento'];
    $cnpj = $vetParametros['cnpj'];
    $dap = $vetParametros['dap'];
    $nirf = $vetParametros['nirf'];
    $rmp = $vetParametros['rmp'];
    $ie = $vetParametros['ie'];
    $sicab = $vetParametros['sicab'];
    $campo_semcnpj = $vetParametros['campo_semcnpj'];
    //
    FunilMetasCliente($vetParametros, $vetRetorno);
    //
    $vetMetas = $vetRetorno['vetMetas'];
    $Meta1 = $vetMetas[1];
    $Meta7 = $vetMetas[7];
    //
    if ($_SESSION[CS]['vetFunilNotaMinima'] == '') {
        $vetFunilNotaMinima = Array();
        $sqlt = "";
        $sqlt .= " select * ";
        $sqlt .= " from " . db_pir_grc . "grc_funil_classificacao ";
        $rst = execsqlNomeCol($sqlt);
        if ($rst->rows == 0) {
            // Erro grave
        } else {
            foreach ($rst->data as $rowt) {
                $idt = $rowt['idt'];
                $codigo = $rowt['codigo'];
                $descricao = $rowt['descricao'];
                $nota_minima = $rowt['nota_minima'];
                $vetFunilNotaMinima[$codigo] = $nota_minima;
            }
        }
        $_SESSION[CS]['vetFunilNotaMinima'] = $vetFunilNotaMinima;
    } else {
        $vetFunilNotaMinima = $_SESSION[CS]['vetFunilNotaMinima'];
    }


    if ($_SESSION[CS]['vetFunilFase'] == '') {
        $vetFunilFase = Array();
        $sqlt = "";
        $sqlt .= " select * ";
        $sqlt .= " from " . db_pir_grc . "grc_funil_fase ";
        $rst = execsqlNomeCol($sqlt);
        if ($rst->rows == 0) {
            // Erro grave
        } else {
            foreach ($rst->data as $rowt) {
                $idt = $rowt['idt'];
                $codigo = $rowt['codigo'];
                $descricao = $rowt['descricao'];

                $vetFunilFase[$idt] = $codigo;
            }
        }
        $_SESSION[CS]['vetFunilFase'] = $vetFunilFase;
    } else {
        $vetFunilFase = $_SESSION[CS]['vetFunilFase'];
    }
    $funil_cliente_nota_avaliacao = "";
    if ($nota == '') {
        // Obter Nota atribuida ao cliente

        if ($tipo_de_empreendimento == 'Empresa (com CNPJ)') {   // Cliente com CNPJ
            $sqlt = "";
            $sqlt .= " select ";
            $sqlt .= " funil_cliente_nota_avaliacao ";
            $sqlt .= " from " . db_pir_gec . "gec_entidade ";
            $sqlt .= " where codigo = " . aspa($cnpj);
            $sqlt .= "   and reg_situacao = " . aspa('A');
            $rst = execsqlNomeCol($sqlt);
            if ($rst->rows == 0) {
                // Nada sensibilizado no Siacweb
            } else {
                foreach ($rst->data as $rowt) {
                    $funil_cliente_nota_avaliacao = $rowt['funil_cliente_nota_avaliacao'];
                }
            }
        } else {  // Cliente sem CNPJ
            // ARTESAO
            // PRODUTOR RURAL
            if ($campo == '' or $campo == 'cnpj') {
                $campo_semcnpj = 'gec_e.codigo';
            }
            $sqlt = "";
            $sqlt .= " select ";
            $sqlt .= " gec_e.funil_cliente_nota_avaliacao ";
            $sqlt .= " from " . db_pir_gec . "gec_entidade gec_e ";
            $sqlt .= " inner join " . db_pir_gec . "gec_entidade_organizacao gec_o on gec_o.idt_entidade = gec_e.idt ";
            $sqlt .= " where {$campo_semcnpj} = " . aspa($cnpj);
            $sqlt .= "   and gec_e.reg_situacao = " . aspa('A');
            $rst = execsqlNomeCol($sqlt);
            if ($rst->rows == 0) {
                // Nada sensibilizado no Siacweb
            } else {
                foreach ($rst->data as $rowt) {
                    $funil_cliente_nota_avaliacao = $rowt['funil_cliente_nota_avaliacao'];
                }
            }
        }

        $nota = $funil_cliente_nota_avaliacao;
    }
    if ($nota == '') {
        // Nota ainda não atribuida ao cliente
    } else {   // tem nota atribuida ao cliente
        // 
    }
    // Classificar o cliente
    $funil_idt_cliente_classificacao = '';

    // Regras de avaliação
    //	
    if ($Meta7 == 'S') {   // sensibilizada a Meta 7
        // 
        if ($nota == '') {
            $funil_idt_cliente_classificacao = 3; // sem classificação
        } else {   // testar a Nota Mínima
            $nota_promotor = $vetFunilNotaMinima['NOTA_PROMOTOR'];
            $nota_detrator = $vetFunilNotaMinima['NOTA_DETRATOR'];
            if ($nota <= $nota_detrator) {
                $funil_idt_cliente_classificacao = 4; // detrator
            } else {
                if ($nota > $nota_detrator and $nota < $nota_promotor) {
                    $funil_idt_cliente_classificacao = 5; // neutro
                } else {
                    if ($nota >= $nota_promotor) {
                        $funil_idt_cliente_classificacao = 6; // detrator
                    }
                }
            }
        }
    } else {
        if ($Meta1 == 'S') {   // sensibilizada a Meta 1
            $funil_idt_cliente_classificacao = 2; // LEAD
        } else {
            $funil_idt_cliente_classificacao = 1; // PROSPECT
        }
    }
    if ($funil_idt_cliente_classificacao == '') {
        $vetRetorno['erro'] = "Não conseguiu classificar";
    }


    $vetRetorno['vetMetas'] = $vetMetas;
    $vetRetorno['funil_nota_cliente_classificacao'] = $nota;
    $vetRetorno['funil_faixa_nota_cliente_classificacao'] = $vetFunilNotaMinima;
    $vetRetorno['funil_idt_cliente_classificacao'] = $funil_idt_cliente_classificacao;
    $vetRetorno['funil_cod_cliente_classificacao'] = $vetFunilFase[$funil_idt_cliente_classificacao];






    return 1;
}

// parâmetros da função
// ['funil_idt_cliente_classificacao'] - entrada : idt a mostrar
// ['width_fase']  - entrada : largura do retangulo default = 2em
// ['height_fase'] - entrada : largura do retangulo default = 1.5em
// ['paddi_fase']  - entrada : padding do retangulo default = 1em
// ['html']  - retorna : retorna o html montado
function FunilExibeClassificacao(&$vetParametro) {
    $simplificado = $vetParametro['simplificado'];

    $html = "";
    $html .= "<style>";
    $html .= " .funil_fase { ";
    $html .= "  cursor:pointer; ";
    $html .= " } ";
    $html .= "</style> ";
    $funil_idt_cliente_classificacao = $vetParametro['funil_idt_cliente_classificacao'];

    //p($vetParametro);

    if ($funil_idt_cliente_classificacao == '') {
        //$funil_idt_cliente_classificacao = 9999;
        $funil_idt_cliente_classificacao = 1;
    }
    $width_fase = $vetParametro['width_fase'];
    if ($width_fase == '') {
        $width_fase = '7em;';
    }
    $height_fase = $vetParametro['height_fase'];
    if ($height_fase == '') {
        $height_fase = '1.5em;';
    }
    $paddi_fase = $vetParametro['paddi_fase'];
    if ($paddi_fase == '') {
        $paddi_fase = '1em;';
    }
    $font_sizew = "";
    $font_size = $vetParametro['font_size'];
    if ($font_size != "") {
        $font_sizew = " font-size:{$font_size}; ";
    }
    $funil_bgc_cor = "#FFFFFF";
    $funil_txt_cor = "#000000";
    $descricao = "";
    $sqlt = " select grc_ff.idt, ";
    $sqlt .= "        grc_ff.codigo, ";
    $sqlt .= "        grc_ff.descricao, ";
    $sqlt .= "        grc_ff.nome, ";
    $sqlt .= "        grc_ff.cordafase, ";
    $sqlt .= "        grc_ff.cortextfase, ";
    $sqlt .= "        grc_ff.detalhe ";
    $sqlt .= " from " . db_pir_grc . "grc_funil_fase grc_ff ";
    $sqlt .= " where grc_ff.idt = " . null($funil_idt_cliente_classificacao);
    $rst = execsql($sqlt);
    if ($rst->rows == 0) {
        $funil_bgc_cor = "#FF0000";
        $funil_txt_cor = "#FFFFFF";

        if ($funil_idt_cliente_classificacao == 8888) {  // atendimento sem pessoa associada a empresa
            // echo " ------------------------- ".$funil_idt_cliente_classificacao;
            $funil_bgc_cor = "#FFFFFF";
            $funil_txt_cor = "#FFFFFF";
            $descricao = "";
            $html = "";
            $vetParametro['html'] = $html;
            return 0;
        } else {
            $descricao = "A CLASSIFICAR";
        }
    } else {
        foreach ($rst->data as $rowt) {
            $idt = $rowt['idt'];
            $codigo = $rowt['codigo'];
            $descricao = $rowt['descricao'];
            $nome = $rowt['nome'];
            $cordafase = '#' . $rowt['cordafase'];
            $cortextfase = '#' . $rowt['cortextfase'];
            $detalhe = $rowt['detalhe'];
            $funil_bgc_cor = $cordafase;
            $funil_txt_cor = $cortextfase;
        }
    }



    if ($simplificado != 'S') {
        $hint = "Clique para visualizar a Descrição e a Orientação Técnica";
        $html .= " <div title='{$hint}' class='funil_fase' style='' onclick='return AbreFaseFunil($funil_idt_cliente_classificacao);'>";
        $html .= " <div id='mostraclassificacao' style=' height:{$height_fase}; padding:{$paddi_fase}; text-align:center; font-weight: bold; width:{$width_fase}; background:{$funil_bgc_cor}; color:{$funil_txt_cor}; '>";
        $html .= " <div style='{$font_sizew} padding:{$paddi_fase};'>{$descricao}</div>";
        $html .= " </div>";
        $html .= " </div>";
    } else {

        $hint = "Clique para visualizar a Descrição e a Orientação Técnica";
        $html .= " <span title='{$hint}' class='funil_fase' style='padding-left:0.5em;' onclick='return AbreFaseFunil($funil_idt_cliente_classificacao);'>";
        $html .= " <span id='mostraclassificacao' style='display:inline-block; height:{$height_fase}; padding:{$paddi_fase}; text-align:center; font-weight: bold; width:{$width_fase}; background:{$funil_bgc_cor}; color:{$funil_txt_cor}; '>";
        $html .= " <span style='{$font_sizew} padding:{$paddi_fase};'>{$descricao}</span>";
        $html .= " </span>";
        $html .= " </span>";
    }



    $html .= "<script> ";
    $html .= "	function AbreFaseFunil(funil_idt_cliente_classificacao) ";
    $html .= "	{ ";
    //$html .= "	 alert('Popup de '+funil_idt_cliente_classificacao); ";

    $html .= "	     var tamw = $('div.showPopWin_width').width() - 50; ";
    $html .= "	     var url = 'conteudo_funil_orientacao.php?prefixo=&menu=&funil_idt_cliente_classificacao=' + funil_idt_cliente_classificacao; ";



    //$html .= "	     var titulo = '<div style=".'"'."display:block; width:+tamw+px; text-align:center; ".'"'.">Saiba mais sobre essa fase...</div>'; ";
    //$html .= "	     var titulo = '<div style=".'"'."display:block; width:".'"'."+tamw+".'"'."px; text-align:center; ".'"'.">FUNIL DE ATENDIMENTO - ORIENTAÇÃO TÉCNICA</div>'; ";

    $html .= "	     var titulo = '<div style=" . '"' . "display:block; width:950px; text-align:center; " . '"' . ">Saiba mais sobre essa fase...</div>'; ";

    $html .= "	     showPopWin(url, titulo, $('div.showPopWin_width').width() - 10, $(window).height() - 100, null, true); ";



    $html .= "	 return false; ";
    $html .= "	} ";
    $html .= "</script> ";

    $vetParametro['html'] = $html;
}

// Exits do full do sistema
function ftr_grc_atendimento_organizacao($rs) {
    foreach ($rs->data as $idx => $row) {
        $funil_cliente_nota_avaliacao = $rs->data[$idx]['funil_cliente_nota_avaliacao'];
        $funil_idt_cliente_classificacao = $rs->data[$idx]['funil_idt_cliente_classificacao'];
        $cnpj = $rs->data[$idx]['cnpj'];
        if ($funil_idt_cliente_classificacao == '') {
            $codigo = $cnpj;
            $vetRetorno = Array();
            BuscaClienteFunil($codigo, $vetRetorno);
            $idt_cliente_classificacao = $vetRetorno['idt_cliente_classificacao'];
            $nota = $vetRetorno['nota'];
            if ($idt_cliente_classificacao != '') {
                $funil_cliente_nota_avaliacao = $nota;
                $funil_idt_cliente_classificacao = $idt_cliente_classificacao;
            } else {
                $funil_cliente_nota_avaliacao = 0;
                $funil_idt_cliente_classificacao = 1;
            }
        }
        //
        $vetParametro = Array();
        $vetParametro['funil_idt_cliente_classificacao'] = $funil_idt_cliente_classificacao;
        $vetParametro['width_fase'] = "10em";
        $vetParametro['height_fase'] = "2.0em";
        $vetParametro['paddi_fase'] = "0.5em";
        $vetParametro['celula'] = "S";
        $vetParametro['font_size'] = "0.8em";
        FunilExibeClassificacao($vetParametro);
        $html = $vetParametro['html'];
        $rs->data[$idx]['funil'] = $html;
    }

    return $rs;
}

// Exits do full do sistema
function ftr_grc_entidade_organizacao($rs) {
    foreach ($rs->data as $idx => $row) {
        $funil_cliente_nota_avaliacao = $rs->data[$idx]['funil_cliente_nota_avaliacao'];
        $funil_idt_cliente_classificacao = $rs->data[$idx]['funil_idt_cliente_classificacao'];
        $cnpj = $rs->data[$idx]['cnpj'];
        if ($funil_idt_cliente_classificacao == '') {
            $codigo = $cnpj;
            $vetRetorno = Array();
            BuscaClienteFunil($codigo, $vetRetorno);
            $idt_cliente_classificacao = $vetRetorno['idt_cliente_classificacao'];
            $nota = $vetRetorno['nota'];
            if ($idt_cliente_classificacao != '') {
                $funil_cliente_nota_avaliacao = $nota;
                $funil_idt_cliente_classificacao = $idt_cliente_classificacao;
            } else {
                $funil_cliente_nota_avaliacao = 0;
                $funil_idt_cliente_classificacao = 1;
            }
        }
        //
        $vetParametro = Array();
        $vetParametro['funil_idt_cliente_classificacao'] = $funil_idt_cliente_classificacao;
        $vetParametro['width_fase'] = "10em";
        $vetParametro['height_fase'] = "2.0em";
        $vetParametro['paddi_fase'] = "0.5em";
        $vetParametro['celula'] = "S";
        $vetParametro['font_size'] = "0.8em";
        FunilExibeClassificacao($vetParametro);
        $html = $vetParametro['html'];
        $rs->data[$idx]['fun_cla_descricao'] = $html;
    }

    return $rs;
}

// Exits do full do sistema
function ftr_grc_evento_matricula($rs) {
    foreach ($rs->data as $idx => $row) {
        $funil_cliente_nota_avaliacao = $rs->data[$idx]['funil_cliente_nota_avaliacao'];
        $funil_idt_cliente_classificacao = $rs->data[$idx]['funil_idt_cliente_classificacao'];
        $cnpj = $rs->data[$idx]['cnpj'];
        if ($funil_idt_cliente_classificacao == '') {
            $codigo = $cnpj;
            $vetRetorno = Array();
            BuscaClienteFunil($codigo, $vetRetorno);
            $idt_cliente_classificacao = $vetRetorno['idt_cliente_classificacao'];
            $nota = $vetRetorno['nota'];
            if ($idt_cliente_classificacao != '') {
                $funil_cliente_nota_avaliacao = $nota;
                $funil_idt_cliente_classificacao = $idt_cliente_classificacao;
            } else {
                $funil_cliente_nota_avaliacao = 0;
                $funil_idt_cliente_classificacao = 1;
            }
        }
        //
        $vetParametro = Array();
        $vetParametro['funil_idt_cliente_classificacao'] = $funil_idt_cliente_classificacao;
        $vetParametro['width_fase'] = "9em";
        $vetParametro['height_fase'] = "0.8em";
        $vetParametro['paddi_fase'] = "0.1em";
        $vetParametro['celula'] = "S";
        $vetParametro['font_size'] = "0.8em";
        $vetParametro['simplificado'] = "S";
        FunilExibeClassificacao($vetParametro);
        $html = $vetParametro['html'];
        if ($rs->data[$idx]['empreendimento'] != '') {
            $rs->data[$idx]['empreendimento'] = $rs->data[$idx]['empreendimento'] . $html;
        }
    }

    return $rs;
}

function AtendimentoResumo($idt_atendimento, &$vetRetorno) {
    $kokw = 0;

    $complemento_acao = aspa($vetRetorno['complemento_acao']);

    $veio = $vetRetorno['veio'];
    $idt_atendimento = null($idt_atendimento);
    $idt_pendencia = null($vetRetorno['idt_pendencia']);
    $idt_acao = null($vetRetorno['idt_acao']);

    $idt_atendimento_agenda = null($vetRetorno['idt_atendimento_agenda']);

    $link_util = aspa($vetRetorno['link_util']);
    $bia_conteudo = aspa($vetRetorno['bia_conteudo']);
    $bia_enviada = aspa($vetRetorno['bia_enviada']);
    $bia_acao = aspa($vetRetorno['bia_acao']);

    $tabela = 'grc_atendimento_resumo';
    $Campo = 'numero';
    $tam = 11;
    $codigow = numerador_arquivo($tabela, $Campo, $tam);
    $codigo = 'RE' . $codigow;
    $numerow = $codigo;
    $vetRetorno['numero'] = $numerow;
    $numero = aspa($vetRetorno['numero']);
    $descricao = aspa($vetRetorno['descricao']);
    $datadia = trata_data(date('d/m/Y H:i:s'));
    $vetRetorno['datahora'] = $datadia;
    $datahora = aspa($vetRetorno['datahora']);

    $marcacao = $vetRetorno['marcacao'];


    //p($vetRetorno);
    //die();
    //
    // Para Pendência
    //	
    if ($vetRetorno['idt_pendencia'] != "") {
        $sqlt = 'select ';
        $sqlt .= '  grc_ar.idt ';
        $sqlt .= '  from  ' . db_pir_grc . 'grc_atendimento_resumo grc_ar';
        $sqlt .= '    where grc_ar.idt_pendencia  = ' . $idt_pendencia;
        $rst = execsql($sqlt);
        //   p($sqlt);
        if ($rst->rows == 0) {
            $sql_i = ' insert into grc_atendimento_resumo ';
            $sql_i .= ' (  ';
            $sql_i .= ' idt_atendimento, ';
            $sql_i .= ' idt_pendencia, ';
            $sql_i .= ' idt_acao, ';
            $sql_i .= " complemento_acao, ";
            $sql_i .= ' numero, ';
            $sql_i .= ' descricao, ';
            $sql_i .= ' datahora ';
            $sql_i .= '  ) values ( ';
            $sql_i .= " $idt_atendimento, ";
            $sql_i .= " $idt_pendencia, ";
            $sql_i .= " $idt_acao, ";
            $sql_i .= " $complemento_acao, ";
            $sql_i .= " $numero, ";
            $sql_i .= " $descricao, ";
            $sql_i .= " $datahora ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
            $kokw = 1;
        } else {
            $sql_a = " update grc_atendimento_resumo set ";
            $sql_a .= " idt_acao         = $idt_acao, ";
            $sql_a .= " complemento_acao = $complemento_acao, ";
            $sql_a .= " numero           = $numero, ";
            $sql_a .= " descricao        = $descricao, ";
            $sql_a .= " datahora  = $datahora ";
            $sql_a .= " where idt_pendencia  = " . $idt_pendencia;
            $result = execsql($sql_a);
            $kokw = 1;
        }
    }
    //
    // Para LINK UTIL
    //	
    if ($veio == "LINKU") {
        // A CADA LINK INSERE NO RESUMO
        $sql_i = ' insert into grc_atendimento_resumo ';
        $sql_i .= ' (  ';
        $sql_i .= ' idt_atendimento, ';
        $sql_i .= ' idt_pendencia, ';
        $sql_i .= ' idt_acao, ';
        $sql_i .= ' complemento_acao, ';
        $sql_i .= ' numero, ';
        $sql_i .= ' descricao, ';
        $sql_i .= ' datahora, ';
        $sql_i .= " link_util ";
        $sql_i .= '  ) values ( ';
        $sql_i .= " $idt_atendimento, ";
        $sql_i .= " $idt_pendencia, ";
        $sql_i .= " $idt_acao, ";
        $sql_i .= " $complemento_acao, ";
        $sql_i .= " $numero, ";
        $sql_i .= " $descricao, ";
        $sql_i .= " $datahora, ";
        $sql_i .= " $link_util ";
        $sql_i .= ') ';
        $result = execsql($sql_i);
        $kokw = 1;
    }
    //
    // Para BIA
    //	
    if ($veio == "BIA") {
        // A CADA BIA
        $sql_i = ' insert into grc_atendimento_resumo ';
        $sql_i .= ' (  ';
        $sql_i .= ' idt_atendimento, ';
        $sql_i .= ' idt_pendencia, ';
        $sql_i .= ' idt_acao, ';
        $sql_i .= ' complemento_acao, ';
        $sql_i .= ' numero, ';
        $sql_i .= ' descricao, ';
        $sql_i .= ' datahora, ';
        $sql_i .= " link_util, ";
        $sql_i .= " bia_acao, ";
        $sql_i .= " bia_conteudo, ";
        $sql_i .= " bia_enviada ";
        $sql_i .= '  ) values ( ';
        $sql_i .= " $idt_atendimento, ";
        $sql_i .= " $idt_pendencia, ";
        $sql_i .= " $idt_acao, ";
        $sql_i .= " $complemento_acao, ";
        $sql_i .= " $numero, ";
        $sql_i .= " $descricao, ";
        $sql_i .= " $datahora, ";
        $sql_i .= " $link_util, ";
        $sql_i .= " $bia_acao, ";
        $sql_i .= " $bia_conteudo, ";
        $sql_i .= " $bia_enviada ";
        $sql_i .= ') ';
        $result = execsql($sql_i);
        $kokw = 1;
    }
    //
    // MARCAÇÃO
    //	

    if ($veio == "AGENDAMARCACAO" or $veio == "AGENDADESMARCACAO" or $veio == "AGENDAEXCLUSAO") {
        // A CADA MARCAÇÃO
        if ($marcacao == "") {
            $marcacaow = MontaMarcacao($idt_atendimento_agenda);
        } else {
            $marcacaow = $marcacao;
        }

        $marcacao = aspa($marcacaow);
        $sql_i = ' insert into grc_atendimento_resumo ';
        $sql_i .= ' (  ';
        $sql_i .= ' idt_atendimento, ';
        $sql_i .= ' idt_pendencia, ';
        $sql_i .= ' idt_acao, ';
        $sql_i .= ' complemento_acao, ';
        $sql_i .= ' idt_atendimento_agenda, ';
        $sql_i .= ' numero, ';
        $sql_i .= ' descricao, ';
        $sql_i .= ' datahora, ';
        $sql_i .= " marcacao ";
        $sql_i .= '  ) values ( ';
        $sql_i .= " $idt_atendimento, ";
        $sql_i .= " $idt_pendencia, ";
        $sql_i .= " $idt_acao, ";
        $sql_i .= " $complemento_acao, ";
        $sql_i .= " $idt_atendimento_agenda, ";
        $sql_i .= " $numero, ";
        $sql_i .= " $descricao, ";
        $sql_i .= " $datahora, ";
        $sql_i .= " $marcacao ";
        $sql_i .= ') ';
        $result = execsql($sql_i);
        $kokw = 1;
    }
    return $kokw;
}

function MontaMarcacao($idt_atendimento_agenda) {
    $html = "";
    //
    // Montar marcação
    //
	$sqlt = 'select ';
    $sqlt .= '  grc_aa.idt_cliente, ';
    $sqlt .= '  grc_aa.idt_especialidade, ';
    $sqlt .= '  grc_aa.cliente_texto, ';
    $sqlt .= '  grc_aa.telefone, ';
    $sqlt .= '  grc_aa.celular, ';
    $sqlt .= '  grc_aa.cpf, ';
    $sqlt .= '  grc_aa.cnpj, ';
    $sqlt .= '  grc_aa.nome_empresa, ';
    $sqlt .= '  grc_aa.data, ';
    $sqlt .= '  grc_aa.hora, ';
    $sqlt .= '  grc_aa.data_hora_marcacao, ';
    $sqlt .= '  sos.descricao as ponto_atendimento, ';
    $sqlt .= '  gae.descricao as servico ';
    $sqlt .= '  from  ' . db_pir_grc . 'grc_atendimento_agenda grc_aa';
    $sqlt .= "  left join grc_atendimento_especialidade   as gae on gae.idt = grc_aa.idt_especialidade ";
    $sqlt .= "  left join " . db_pir . "sca_organizacao_secao as sos on sos.idt = grc_aa.idt_ponto_atendimento ";
    $sqlt .= '    where grc_aa.idt  = ' . $idt_atendimento_agenda;
    $rst = execsql($sqlt);
    if ($rst->rows == 0) {
        // erro
    } else {
        ForEach ($rst->data as $rowt) {
            $idt_cliente = $rowt['idt_cliente'];
            $idt_especialidade = $rowt['idt_especialidade'];
            $idt_especialidade = $rowt['idt_especialidade'];
            $cliente_texto = $rowt['cliente_texto'];
            $telefone = $rowt['telefone'];
            $celular = $rowt['celular'];
            $cpf = $rowt['cpf'];
            $cnpj = $rowt['cnpj'];
            $nome_empresa = $rowt['nome_empresa'];
            $data_hora_marcacao = $rowt['data_hora_marcacao'];
            $ponto_atendimento = $rowt['ponto_atendimento'];
            $servico = $rowt['servico'];
            $data = trata_data($rowt['data']);
            $hora = $rowt['hora'];
            //
            $html .= "Agendamento para {$cliente_texto} - CPF: {$cpf} <br />";
            $html .= "Telefones: {$telefone}  {$telefone} <br />";
            $html .= "Data Marcada: {$data}  Hora: {$hora} <br />";
            $html .= "Serviço: {$servico}<br />";
            $html .= "Ponto Atendimento: {$ponto_atendimento} <br />";
        }
    }
    return $html;
}

function HistoricoSiacwebCRM($cpf, $data_inicio_atendimento, $codigorealizacao, &$vetRetorno) {
    $CPFClienteGRCw = FormataCPF12($cpf);
    $DataHoraInicioRealizacaow = trata_data($data_inicio_atendimento);
    $tam = strlen($DataHoraInicioRealizacaow);
    if ($tam == 18) {
        $DataHoraInicioRealizacaow = $DataHoraInicioRealizacao . ":00";
    }
    $sqlt = 'select ';
    $sqlt .= '  grc_a.* ';
    $sqlt .= '  from  ' . db_pir_grc . 'grc_atendimento grc_a';
    $sqlt .= '  inner join ' . db_pir_grc . 'grc_atendimento_pessoa grc_ap  on grc_ap.idt_atendimento = grc_a.idt';
    $sqlt .= '    where grc_ap.cpf                     = ' . aspa($CPFClienteGRCw) . '  ';
    $sqlt .= '      and grc_a.data_inicio_atendimento  = ' . aspa($DataHoraInicioRealizacaow) . '  ';
    $rst = execsql($sqlt);
    //p($sqlt);
    if ($rst->rows == 0) {
        $vetRetorno['EOF'] = "S";
    } else {
        $vetRetorno['qtdRegistros'] = $rst->rows;

        ForEach ($rst->data as $rowt) {
            $idt = $rowt['idt'];
            $vetRetorno[$idt] = $rowt;
        }
    }
}

function PendenciaRedeGerarFilhos(&$vetRetorno) {
    $kokw = 0;
    $acao = $vetRetorno['acao'];
    $idt_pendencia = $vetRetorno['idt_pendencia'];
    $idt_destinatario = $vetRetorno['idt_destinatario'];
    $observacao = $vetRetorno['observacao'];
    $opcao_tramitacao = $vetRetorno['opcao_tramitacao'];
    $idt_status_tramitacao = $vetRetorno['idt_status_tramitacao'];
    //  
    $acao = "alt";
    if ($acao == 'inc') {   // Inclusão
        // Acessar a pendência PAI
    } else {
        if ($acao == 'exc') {  // Exclusão
        } else {   // Alteração
            // Acessar a pendência Atual
            $sqlt = 'select ';
            $sqlt .= '  grc_ap.* ';
            $sqlt .= '  from  ' . db_pir_grc . 'grc_atendimento_pendencia grc_ap';
            $sqlt .= '  inner join ' . db_pir_grc . 'grc_atendimento grc_a  on grc_a.idt = grc_ap.idt_atendimento';
            $sqlt .= '    where grc_ap.idt  = ' . null($idt_pendencia) . '  ';
            $rst = execsql($sqlt);
            if ($rst->rows == 0) {
                $vetRetorno['EOF'] = "S";
            } else {
                $vetRetorno['qtdRegistros'] = $rst->rows;

                ForEach ($rst->data as $rowt) {
                    $idt_pendencia_pai = $rowt['idt'];
                    $idt_atendimento = $rowt['idt_atendimento'];
                    $idt_pendencia_raiz = $rowt['idt_pendencia_raiz'];
                    $opcao_tramitacao = $rowt['opcao_tramitacao'];
                    $idt_status_tramitacao = $rowt['idt_status_tramitacao'];



                    $idt_usuario = $rowt['idt_usuario'];
                    $idt_ponto_atendimento = $rowt['idt_ponto_atendimento'];
                    $data_solucao = $rowt['data_solucao'];
                    $protocolo = $rowt['protocolo'];
                    $assunto = $rowt['assunto'];
                    $recorrencia = $rowt['recorrencia'];
                    $data = $rowt['data'];
                    $data_solucao = $rowt['data_solucao'];
                    $observacao = $rowt['observacao'];
                    $enviar_email = $rowt['enviar_email'];
                    $recorrencia = $rowt['recorrencia'];
                    $cpf = $rowt['cpf'];
                    $cod_cliente_siac = $rowt['cod_cliente_siac'];
                    $nome_cliente = $rowt['nome_cliente'];
                    $cnpj = $rowt['cnpf'];
                    $temporario = $rowt['temporario'];
                    $consideracoes_encaminhamento = $rowt['consideracoes_encaminhamento'];
                    $data_resposta_encaminhamento = $rowt['data_resposta_encaminhamento'];
                    $vetRetorno[$idt_pendencia_pai] = $rowt;
                }
            }
            if ($opcao_tramitacao == 'R') { // resolvido desativa raiz
                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " idt_status_tramitacao = " . null($idt_status_tramitacao) . ", ";

                $sql_a .= " ativo = 'N' ";
                $sql_a .= ' where idt = ' . null($idt_pendencia_raiz);
                execsql($sql_a);
            }
            if ($opcao_tramitacao == 'E') {   // Encaminhado
                $idt_status_tramitacao = 2; // Em tramitação
                // Atualiza a Raiz
                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " idt_status_tramitacao = " . null($idt_status_tramitacao) . " ";

                $sql_a .= ' where idt = ' . null($idt_pendencia_raiz);
                execsql($sql_a);
                // Atualiza o Filho
                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " idt_status_tramitacao = " . null($idt_status_tramitacao) . " ";

                $sql_a .= ' where idt = ' . null($idt_pendencia);
                execsql($sql_a);
            }


            $idt_usuario = $_SESSION[CS]['g_id_usuario'];
            $idt_ponto_atendimento = null($idt_ponto_atendimento);
            $datadias = date('d/m/Y');
            $datadia = date('d/m/Y H:i:s');
            $data = aspa(trata_data($datadia));
            $data_solucao = aspa($data_solucao);
            $protocolo = aspa($protocolo);
            $assunto = aspa($assunto);
            $recorrencia = aspa($recorrencia);
            $observacao = aspa($observacao);
            $enviar_email = aspa($enviar_email);
            $cpf = aspa($cpf);
            $cod_cliente_siac = null($cod_cliente_siac);
            $nome_cliente = aspa($nome_cliente);
            $cnpj = aspa($cnpj);
            $temporario = aspa($temporario);
            $consideracoes_encaminhamento = aspa($consideracoes_encaminhamento);
            $data_resposta_encaminhamento = aspa($data_resposta_encaminhamento);
            $idt_pendencia_raiz = null($idt_pendencia_raiz);
            $sqlt = 'select ';
            $sqlt .= '  grc_apd.* ';
            $sqlt .= '  from  ' . db_pir_grc . 'grc_atendimento_pendencia_destinatario grc_apd';
            $sqlt .= '    where grc_apd.idt_pendencia  = ' . null($idt_pendencia_pai) . '  ';
            $rst = execsql($sqlt);
            if ($rst->rows == 0) {
                $vetRetorno['EOF'] = "S";
            } else {
                ForEach ($rst->data as $rowt) {
                    $idt_pendencia_destinatario = $rowt['idt'];
                    $idt_destinatario = $rowt['idt_destinatario'];
                    $enviar_email_destinatario = $rowt['enviar_email_destinatario'];
                    // Gravar Pendencia associada ao pai
                    $enviar_email = aspa($enviar_email_destinatario);
                    $idt_responsavel_solucao = null($idt_destinatario);


                    $sqlt = 'select ';
                    $sqlt .= '  grc_ap.idt ';
                    $sqlt .= '  from  ' . db_pir_grc . 'grc_atendimento_pendencia grc_ap';
                    $sqlt .= '    where grc_ap.idt_atendimento  = ' . null($idt_atendimento);
                    $sqlt .= '      and grc_ap.idt_pendencia_pai  = ' . null($idt_pendencia_pai);
                    $sqlt .= '      and grc_ap.idt_responsavel_solucao  = ' . ($idt_responsavel_solucao);
                    $rst = execsql($sqlt);
                    //   p($sqlt);
                    if ($rst->rows == 0) {
                        //
                        $sql_i = ' insert into grc_atendimento_pendencia ';
                        $sql_i .= ' (  ';
                        $sql_i .= " idt_atendimento, ";
                        $sql_i .= " idt_pendencia_pai, ";
                        $sql_i .= " idt_responsavel_solucao, ";
                        $sql_i .= " idt_pendencia_raiz, ";
                        $sql_i .= " idt_usuario, ";
                        $sql_i .= " idt_ponto_atendimento, ";
                        $sql_i .= " protocolo, ";
                        $sql_i .= " assunto, ";
                        $sql_i .= " enviar_email, ";
                        $sql_i .= " recorrencia, ";
                        $sql_i .= " cpf, ";
                        $sql_i .= " cod_cliente_siac, ";
                        $sql_i .= " nome_cliente, ";
                        $sql_i .= " cnpj, ";
                        $sql_i .= " temporario, ";
                        $sql_i .= " consideracoes_encaminhamento_pai, ";
                        $sql_i .= " data_resposta_encaminhamento_pai, ";
                        $sql_i .= " data, ";
                        $sql_i .= " data_solucao, ";
                        $sql_i .= " observacao ";
                        $sql_i .= '  ) values ( ';
                        $sql_i .= " $idt_atendimento, ";
                        $sql_i .= " $idt_pendencia_pai, ";
                        $sql_i .= " $idt_responsavel_solucao, ";
                        $sql_i .= " $idt_pendencia_raiz, ";
                        $sql_i .= " $idt_usuario, ";
                        $sql_i .= " $idt_ponto_atendimento, ";
                        $sql_i .= " $protocolo, ";
                        $sql_i .= " $assunto, ";
                        $sql_i .= " $enviar_email, ";
                        $sql_i .= " $recorrencia, ";
                        $sql_i .= " $cpf, ";
                        $sql_i .= " $cod_cliente_siac, ";
                        $sql_i .= " $nome_cliente, ";
                        $sql_i .= " $cnpj, ";
                        $sql_i .= " $temporario, ";
                        $sql_i .= " $consideracoes_encaminhamento, ";
                        $sql_i .= " $data_resposta_encaminhamento, ";
                        $sql_i .= " $data, ";
                        $sql_i .= " $data_solucao, ";
                        $sql_i .= " $observacao ";
                        $sql_i .= ') ';
                        $result = execsql($sql_i);
                        $idt_pendencia_destinatario = lastInsertId();
                        // gravar arquivos em anexo
                        $sqltt = 'select ';
                        $sqltt .= '  grc_apa.* ';
                        $sqltt .= '  from  ' . db_pir_grc . 'grc_atendimento_pendencia_anexo grc_apa';
                        $sqltt .= '    where grc_apa.idt_atendimento_pendencia  = ' . null($idt_pendencia_pai) . '  ';
                        $rstt = execsql($sqltt);
                        if ($rstt->rows == 0) {
                            // não tem anexos;
                        } else {
                            ForEach ($rstt->data as $rowtt) {
                                $idt_pendencia_anexo = $rowtt['idt'];
                                $idt_atendimento_pendencia = null($idt_pendencia_destinatario);
                                $descricao = aspa($rowtt['descricao']);
                                $tipo = aspa($rowtt['tipo']);
                                $arquivo = aspa($rowtt['arquivo']);
                                $data_w = aspa($rowtt['data']);
                                $email = aspa($rowtt['email']);
                                $sql_i = ' insert into grc_atendimento_pendencia_anexo ';
                                $sql_i .= ' (  ';
                                $sql_i .= " idt_atendimento_pendencia, ";
                                $sql_i .= " descricao, ";
                                $sql_i .= " tipo, ";
                                $sql_i .= " arquivo, ";
                                $sql_i .= " data, ";
                                $sql_i .= " email ";
                                $sql_i .= '  ) values ( ';
                                $sql_i .= " $idt_atendimento_pendencia, ";
                                $sql_i .= " $descricao, ";
                                $sql_i .= " $tipo, ";
                                $sql_i .= " $arquivo, ";
                                $sql_i .= " $data_w, ";
                                $sql_i .= " $email ";
                                $sql_i .= ') ';
                                $result = execsql($sql_i);
                            }
                        }
                        // fim gerar anexos
                        if ($enviar_email_destinatario == 'S') {
                            $vetParametros = Array();
                            $vetParametros['processo_emailsms'] = '01'; // aviso de pendência ao demandado
                            $vetParametros['idt_pendencia_destinatario'] = $idt_pendencia_destinatario;
                            $ret = EnviarEmailDestinatarioPendencia($vetParametros);
                        }
                    }
                }
            }
        }
    }

    $kokw = 1;
    return $kokw;
}

function EnviarEmailDestinatarioPendencia(&$vetParametros) {
    $kokw = 0;
    $idt_pendencia_destinatario = $vetParametros['idt_pendencia_destinatario'];
    //p($vetParametros);
    // Enviar email para destinatário
    // Acessar a pendência do destinatário











    $sqlt = 'select ';
    $sqlt .= '  grc_ap.* ';
    $sqlt .= '  from  ' . db_pir_grc . 'grc_atendimento_pendencia grc_ap';
    $sqlt .= '  inner join ' . db_pir_grc . 'grc_atendimento grc_a  on grc_a.idt = grc_ap.idt_atendimento';
    $sqlt .= '    where grc_ap.idt  = ' . null($idt_pendencia_destinatario) . '  ';
    $rst = execsql($sqlt);
    $vetCamposSQL = Array();
    if ($rst->rows == 0) {
        $vetParametros['EOF'] = "S";
    } else {
        $vetCamposSQL = $rst->info['name'];
        $vetParametros['qtdRegistros'] = $rst->rows;

        ForEach ($rst->data as $rowt) {
            $idt_pendencia_pai = $rowt['idt'];
            $idt_atendimento = $rowt['idt_atendimento'];
            $idt_usuario = $rowt['idt_usuario'];
            $idt_ponto_atendimento = $rowt['idt_ponto_atendimento'];
            $data_solucao = $rowt['data_solucao'];
            $protocolo = $rowt['protocolo'];
            $assunto = $rowt['assunto'];
            $recorrencia = $rowt['recorrencia'];
            $data = $rowt['data'];
            $data_solucao = $rowt['data_solucao'];
            $observacao = $rowt['observacao'];
            $enviar_email = $rowt['enviar_email'];
            $recorrencia = $rowt['recorrencia'];
            $cpf = $rowt['cpf'];
            $cod_cliente_siac = $rowt['cod_cliente_siac'];
            $nome_cliente = $rowt['nome_cliente'];
            $cnpj = $rowt['cnpf'];
            $temporario = $rowt['temporario'];
            $consideracoes_encaminhamento = $rowt['consideracoes_encaminhamento'];
            $data_resposta_encaminhamento = $rowt['data_resposta_encaminhamento'];
            $row_pe = $rowt;
        }
    }
    ///////////////////////////////

    $atualizatab = 1;
    if ($atualizatab == 1) {
        foreach ($vetCamposSQL as $indice => $nome_campo) {
            $sqlpe = "";
            $sqlpe .= " select idt ";
            $sqlpe .= ' from grc_comunica_tag grc_ct ';
            $sqlpe .= ' where campo_p = ' . aspa($nome_campo);
            $rspe = execsql($sqlpe);
            if ($rspe->rows == 0) {
                $codigo = aspa('#' . $nome_campo);
                $descricao = aspa($nome_campo);
                $ativo = aspa('S');
                $tabela_p = aspa('grc_atendimento_agenda');
                $campo_p = aspa($nome_campo);
                $ordem = aspa('99');
                $sql_i = ' insert into grc_comunica_tag ';
                $sql_i .= ' (  ';
                $sql_i .= " codigo, ";
                $sql_i .= " descricao, ";
                $sql_i .= " ativo, ";
                $sql_i .= " tabela_p, ";
                $sql_i .= " campo_p, ";
                $sql_i .= " ordem ";
                $sql_i .= '  ) values ( ';
                $sql_i .= " $codigo, ";
                $sql_i .= " $descricao, ";
                $sql_i .= " $ativo, ";
                $sql_i .= " $tabela_p, ";
                $sql_i .= " $campo_p, ";
                $sql_i .= " $ordem ";
                $sql_i .= ') ';
                execsql($sql_i, false);
            }
        }
    }
    $sqlp = '';
    $sqlp .= " select grc_ct.* ";
    $sqlp .= ' from grc_comunica_tag grc_ct ';
    $rsp = execsql($sqlp);
    $vetDisponivel = Array();
    ForEach ($rsp->data as $rowp) {
        $tag = $rowp['codigo'];
        $descricao = $rowp['descricao'];
        $campo_p = $rowp['campo_p'];
        $vetDisponivel[$tag] = $campo_p;
    }
    $vetParametros['vetDisponivel'] = $vetDisponivel;
    // 
    foreach ($vetDisponivel as $tag => $campo_p) {
        
    }
    //p($vetDisponivel);
    // data - data original da pendencia
    // idt  - idt usuario demandante
    // assunto
    // Observacao
    // data_solucao - a esperada
    // nome_cliente
    $email_demandante = "";
    $sqlw = 'select ';
    $sqlw .= '   plu_usu.* ';
    $sqlw .= ' from plu_usuario plu_usu ';
    $sqlw .= " where plu_usu.id_usuario = " . null($row_pe['idt_usuario']);
    $rstw = execsql($sqlw);
    if ($rstw->rows > 0) {
        foreach ($rstw->data as $rowtw) {
            $email_demandante = $rowtw['email'];
            $nome_demandante = $rowtw['nome_completo'];
        }
    } else {
        $vetParametros['erro_demandante_email'] = "Não encontrado {idt_usuario} em Tabela de USuários (Login)";
    }
    $vetParametros['pendencia_data_registro'] = $row_pe['data'];
    $vetParametros['pendencia_nome_demandante'] = $nome_demandante;
    $vetParametros['pendencia_email_demandante'] = $email_demandante;
    $vetParametros['pendencia_assunto'] = $row_pe['assunto'];
    $vetParametros['pendencia_observacao'] = $row_pe['observacao'];
    $vetParametros['pendencia_data_solucao'] = $row_pe['data_solucao'];
    $row_pe['pendencia_nome_demandante'] = $vetParametros['pendencia_nome_demandante'];
    $row_pe['pendencia_email_demandante'] = $vetParametros['pendencia_email_demandante'];

    // Acessar Processo e Email
    $processo_emailsms = $vetParametros['processo_emailsms'];
    $sql = 'select ';
    $sql .= '   grc_c.*, grc_cp.quando as grc_cp_quando, grc_cp.prazo as grc_cp_prazo  ';
    $sql .= ' from grc_comunica_processo grc_cp ';
    $sql .= ' inner join grc_comunica grc_c on grc_c.idt_processo = grc_cp.idt ';
    $sql .= " where grc_cp.codigo = " . aspa($processo_emailsms);
    $rst = execsql($sql);
    if ($rst->rows > 0) {
        foreach ($rst->data as $rowt) {
            $descricao = $rowt['descricao'];
            $detalhe = $rowt['detalhe'];
            $tipo = $rowt['tipo'];
            $grc_aesp_quando = $rowt['grc_aesp_quando'];
            $grc_aesp_prazo = $rowt['grc_aesp_prazo'];
            // Gravar LOG de EMAIL - SMS
            $imediato = $rowt['imediato'];
            $processo = $processo_emailsms;
            //

            $vetParametros['descricao'] = $descricao;
            $vetParametros['descricao_trans'] = PendenciaTransformaMSG($descricao, $row_pe, $vetDisponivel);
            //$vetParametros['titulo']              = $vetParametros['descricao_trans'];
            $vetParametros['titulo_trans'] = $vetParametros['descricao_trans'];
            $vetParametros['detalhe'] = $detalhe;
            $vetParametros['detalhe_trans'] = PendenciaTransformaMSG($detalhe, $row_pe, $vetDisponivel);
            $vetParametros['descricao_trans'] = $vetParametros['detalhe_trans'];

            $vetParametros['idt_externo'] = $idt_atendimento_agenda;
            $vetParametros['processo'] = $processo;
            $vetParametros['tipo'] = $tipo;
            $vetParametros['emitente_nome'] = $_SESSION[CS]['g_nome_completo'];
            $vetParametros['emitente_email'] = $_SESSION[CS]['g_email'];
            $vetParametros['emitente_login'] = $_SESSION[CS]['g_login'];
            $vetParametros['emitente_sms'] = $_SESSION[CS]['g_sms'];

            //p($vetParametros);
            //p($row_pe);
            //die();






            $vetParametros['destinatario_nome'] = $row_pe['cliente_texto'];
            $vetParametros['destinatario_email'] = $row_pe['email'];
            $vetParametros['destinatario_sms'] = $row_pe['celular'];
            $vetParametros['consultor_nome'] = $row_pe['consultor'];
            $vetParametros['consultor_email'] = $row_pe['consultor_email'];
            $vetParametros['consultor_sms'] = $row_pe['consultor_sms'];


            /*
              $vetParametros['destinatario_nome'] = "Luiz Pereira";
              $vetParametros['destinatario_email'] = "luizrehmpereira@gmail.com";
              $vetParametros['destinatario_sms'] = "";
              $vetParametros['consultor_nome'] = "Consultor Luiz Pereira";
              $vetParametros['consultor_email'] = "luizrehmpereira@gmail.com";
              $vetParametros['consultor_sms'] = "";
             */

            $tipo_solicitacao = 'NA';
            if ($tipo == 'E') {   // EMAIL
                $tipo_solicitacao = "EM";
            }
            if ($tipo == 'S') {   // SMS
                $tipo_solicitacao = "SM";
            }
            if ($tipo == 'A') {   // Ambos
                $tipo_solicitacao = "ES";
            }
            $vetParametros['tipo_solicitacao'] = $tipo_solicitacao;
            $vetParametros['quando'] = $grc_aesp_quando;
            $vetParametros['prazo'] = $grc_aesp_prazo;
            $dataAgenda = trata_data($row_pe['data']) . ' ' . $row_pe['hora'];
            $imediato = 0;
            //$dataenviar                        = CalcularDataEnviar($dataAgenda, $grc_aesp_quando, $grc_aesp_prazo, $imediato);

            $dataenviar = $dataAgenda;
            $vetParametros['data_enviar'] = $dataenviar;
            $vetParametros['data_agenda'] = trata_data($row_pe['data']);
            $vetParametros['hora_agenda'] = $row_pe['hora'];
            $vetParametros['sumario_agenda'] = 'Atendimento Sebrae|Bahia - Ponto Atendimento ' . $row_pe['ponto_atendimento'];
            $vetParametros['descricao_agenda'] = 'Atendimento Sebrae|Bahia - Ponto Atendimento ' . $row_pe['ponto_atendimento'] . ' Hora: ' . trata_data($row_pe['data_hora_marcacao']) . ' ' . $row_pe['dia_co_semana'] . ' Tolerância: ' . $row_pe['tolerancia_atraso'] . ' minutos';
            $vetParametros['local_agenda'] = $row_pe['endereco_pa'];
            //
            $idt_comunicacao = GravaComunicacao($vetParametros);
            $observacao_envio = "";
            //
            $imediato = 1; // Para pendência é sempre imediato
            if ($tipo_solicitacao == 'EM' or $tipo_solicitacao == 'ES') {   // enviar EMAIL 
                if ($idt_comunicacao > 0 and $imediato == 1) {
                    $enviou_ok = PendenciaEnviarEmail($idt_comunicacao, $vetParametros);
                    if ($enviou_ok == 1) {
                        // enviou imediatamente
                        $observacao_envio .= "Enviado Email<br />";
                        $datadia = trata_data(date('d/m/Y H:i:s'));
                        $sql = 'update grc_comunicacao set ';
                        $sql .= ' observacao_envio  = ' . aspa($observacao_envio) . ", ";
                        $sql .= ' pendente_envio    = ' . aspa('E') . ", ";
                        $sql .= ' data_envio        = ' . aspa($datadia);
                        $sql .= ' where idt         = ' . null($idt_comunicacao);
                        execsql($sql);
                    } else {
                        // ficou na pendência
                    }
                }
            }
        }
        $kokw = 1;
    } else {
        $vetParametros['SEMPARAMETRODEEMAL'] = "S";
        $kokw = 0;
    }

    return $kokw;
}

function PendenciaEnviarEmail($idt_comunicacao, &$vetParametros) {
    global $vetConf;


    // guytabete return 1;
    //p($vetConf);
    //
	// Acessa Registro do grc_comunicacao
    //
	$sql = 'select ';
    $sql .= '   grc_c.* ';
    $sql .= ' from grc_comunicacao grc_c ';
    $sql .= " where grc_c.idt = " . null($idt_comunicacao);
    $rst = execsql($sql);
    if ($rst->rows > 0) {
        foreach ($rst->data as $rowt) {
            $protocolo_email = $rowt['protocolo'];
            $titulo_email = $rowt['titulo'];
            $descricao_email = $rowt['descricao'];
            $emitente_nome = $rowt['nome'];
            $emitente_email = $rowt['email'];
            $cliente_nome = $rowt['cliente_nome'];
            $cliente_email = $rowt['cliente_email'];
        }
    } else {
        $vetParametros['erro'] = "Não encontrado {$idt_comunicacao} registro em grc_comunicacao";
        return 0;
    }
    // Enviar o EMAIL
    //$emitente_nome = "Sebrae Bahia";
    $erro = "";
    // $html    = $_SESSION[CS]['g_bia_email_html'];
    $protocolo = $protocolo_email;
    $siglaw = substr($protocolo, 0, 2);
    $protocolow = substr($protocolo, 2);
    $protocolow = TiraZeroEsq($protocolow);
    $protocolow = $siglaw . $protocolow;

    $html = $descricao_email;
    $vetReplace = Array(
        '/sebrae_grc/admin/fckupload/',
        '/sebrae_bia/admin/fckupload/',
    );
    foreach ($vetReplace as $value) {
        $html = str_replace($value, url_pai . $value, $html);
    }
    $origem_nome = $emitente_nome;
    $origem_email = $emitente_email;
    $destino_nome = $cliente_nome;
    $destino_email = $cliente_email;
    $msg = $html;
    // Grava ICS
    $protocolo_agenda = $vetParametros['protocolo_agenda'];
    $data_agenda = trata_data($vetParametros['data_agenda']);
    $hora_agenda = $vetParametros['hora_agenda'];
    $descricao_agenda = $vetParametros['descricao_agenda'];
    $sumario_agenda = $vetParametros['sumario_agenda'];
    $local_agenda = str_replace('<br />', '', $vetParametros['local_agenda']);
    //        
    $vetParametroICS['protocolo'] = $protocolo_agenda;
    $vetParametroICS['sumario'] = utf8_encode($sumario_agenda);
    $vetParametroICS['descricao'] = utf8_encode($descricao_agenda);
    $vetParametroICS['local_agenda'] = utf8_encode($local_agenda);
    $vetParametroICS['data_agenda'] = $data_agenda;
    $vetParametroICS['hora_evento'] = $hora_agenda;
    //$arquivo_ics = ArquivoICS($vetParametroICS);
    $arquivo_ics = "";
    $vetParametroICS['arquivonovo_ics'] = $arquivonovo_ics;
    //
    //   echo " teste PHPMailer 1 ";
    //die();  
    //  Require_Once('PHPMailer/class.phpmailer.php');
    // echo " teste PHPMailer 2 ";
//    Require_Once('PHPMailer/class.smtp.php');


    require_once(lib_phpmailer . 'PHPMailerAutoload.php');

    //die();
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = $vetConf['host_smtp'];
    $mail->Port = $vetConf['port_smtp'];
    //$mail->Username   = $vetConf['login_smtp'];
    $mail->Username = $vetConf['email_envio'];
    $mail->Password = $vetConf['senha_smtp'];
    $mail->SMTPAuth = !($vetConf['login_smtp'] == '' && $vetConf['senha_smtp'] == '');
    $mail->SMTPSecure = $vetConf['smtp_secure'];
    $mail->From = $mail->Username;
    $mail->FromName = $origem_nome;
    $mail->Subject = $titulo_email;
    $mail->Body = $msg;
    $mail->AltBody = $msg;
    $mail->IsHTML(true);
    $mail->AddAddress($destino_email, $destino_nome);
    if ($arquivo_ics != "") {
        $mail->AddAttachment($arquivo_ics, $arquivonovo_ics);
    }
    //p($mail);
    try {
        //p($mail);
        //exit();
        if ($mail->Send()) {
            $vetParametros['msg'] = "E-mail Enviado com sucesso";
            $mail = null;
            return 1;
        } else {
            $erro = "Erro na transmissão.\nTente outra vez!\n\n" . trata_aspa($mail->ErrorInfo);
            $vetParametros['erro'] = "Erro na transmissão.\nTente outra vez!\n\n" . trata_aspa($mail->ErrorInfo);
            $mail = null;
            return 0;
        }
    } catch (Exception $e) {
        //$erro = 'O Sistema encontrou problemas para enviar seu e-mail.\n' . $e->getMessage();
        $vetParametros['erro'] = "Erro na transmissão.\nTente outra vez!\n\n" . trata_aspa($mail->ErrorInfo);
        $mail = null;
        return 0;
    }
    //
    // enviar email
    //
	$mail = null;
    return 1;
}

function PendenciaTransformaMSG($detalhe, $row_pe, $vetDisponivel) {
    // Transformar conteúdo
    $conteudo = $detalhe;
    foreach ($vetDisponivel as $tag => $campo_p) {
        if ($campo_p != '') {
            $valc = $row_pe[$campo_p];
            if ($valc != '') {
                $conteudo = str_replace($tag, $valc, $conteudo);
            }
        }
    }
    return $conteudo;
}

function PendenciaHistorico($Parametros, &$Retorno) {
    $kokw = 0;
    $html = "";
    $htmlprincipal = "";
    $htmlpai = "";
    $veiopai = 0;
    $idt_atendimento_pendencia = $Parametros['idt_atendimento_pendencia'];
    $html .= "<style>  ";
    $html .= ".atende_tb { ";
    $html .= " } ";

    $html .= ".cab_ma { ";
    //$html .="   border-top:1px solid #666666; ";
    $html .= "   border-bottom:1px solid #666666; ";
    $html .= "   text-align:left; ";
    $html .= "   font-size:12px; ";
    $html .= "   background:#F6F6F6; ";
    $html .= "   color:#666666;   ";
    $html .= " } ";
    $html .= "</style>  ";


    $html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";

    $html .= "<tr  style='' >  ";
    $html .= "   <td class='cab_ma'   style='text-align:center; font-size:16px; background:#F1F1F1; ' >";
    $html .= "Histórico de Tramitação";
    $html .= "   </td> ";
    $html .= "</tr>";




    $vetHistorico = Array();
    $sqlt = 'select ';
    $sqlt .= '  grc_ap.*, ';
    $sqlt .= '  plu_de.nome_completo as demandente, ';
    $sqlt .= '  plu_rs.nome_completo as demandado ';

    $sqlt .= '  from  ' . db_pir_grc . 'grc_atendimento_pendencia grc_ap';
    $sqlt .= '  inner join ' . db_pir_grc . 'grc_atendimento grc_a  on grc_a.idt = grc_ap.idt_atendimento';
    $sqlt .= '  left  join ' . db_pir_grc . 'plu_usuario plu_de  on plu_de.id_usuario = grc_ap.idt_usuario';
    $sqlt .= '  left  join ' . db_pir_grc . 'plu_usuario plu_rs  on plu_rs.id_usuario = grc_ap.idt_responsavel_solucao';
    $sqlt .= '    where grc_ap.idt  = ' . null($idt_atendimento_pendencia) . '  ';
    $rst = execsql($sqlt);
    $corlabel = "#2F65BB";
    $corbackz0 = "#FFFFFF";
    $corbackz1 = "#F1F1F1";
    $zebr = 0;
    if ($rst->rows == 0) {
        $vetRetorno['EOF'] = "S";
    } else {
        $vetRetorno['qtdRegistros'] = $rst->rows;

        ForEach ($rst->data as $rowt) {
            $idt_pendencia = $rowt['idt'];
            $idt_pendencia_pai = $rowt['idt_pendencia_pai'];
            $idt_pendencia_raiz = $rowt['idt_pendencia_raiz'];
            $idt_atendimento = $rowt['idt_atendimento'];
            $idt_usuario = $rowt['idt_usuario'];
            $idt_ponto_atendimento = $rowt['idt_ponto_atendimento'];
            $data_solucao = $rowt['data_solucao'];
            $protocolo = $rowt['protocolo'];
            $assunto = $rowt['assunto'];
            $detalhe = $rowt['observacao'];
            $tipo = $rowt['tipo'];
            $status = $rowt['status'];
            $recorrencia = $rowt['recorrencia'];
            $data = $rowt['data'];
            $data_solucao = $rowt['data_solucao'];
            $observacao = $rowt['observacao'];
            $enviar_email = $rowt['enviar_email'];
            $recorrencia = $rowt['recorrencia'];
            $cpf = $rowt['cpf'];
            $cod_cliente_siac = $rowt['cod_cliente_siac'];
            $nome_cliente = $rowt['nome_cliente'];
            $cnpj = $rowt['cnpf'];
            $temporario = $rowt['temporario'];
            $consideracoes_encaminhamento_pai = $rowt['consideracoes_encaminhamento_pai'];
            $data_resposta_encaminhamento_pai = $rowt['data_resposta_encaminhamento_pai'];
            $consideracoes_encaminhamento = $rowt['consideracoes_encaminhamento'];
            $data_resposta_encaminhamento = $rowt['data_resposta_encaminhamento'];
            $demandente = $rowt['demandente'];
            $demandado = $rowt['demandado'];
            if ($idt_pendencia_pai == '') {   // Pai
                $dataw = $data . " - " . $idt_pendencia;
                $datad = trata_data($data);
                $encaminhamento = $consideracoes_encaminhamento;
            } else {
                $dataw = $data_resposta_encaminhamento . " - " . $idt_pendencia;
                $datad = trata_data($data_resposta_encaminhamento);
                $encaminhamento = $consideracoes_encaminhamento;
            }
            $vetHistorico[$dataw] = $rowt;
            $htmlprincipal .= "<span style='color:{$corlabel}; '>Tramitação:</span> " . $protocolo . " " . $idt_pendencia . " em " . $datad . " <br />";
            $htmlprincipal .= "<span style='color:{$corlabel}; '>Assunto :</span> " . $assunto . "  " . " <br />";
            $htmlprincipal .= "<span style='color:{$corlabel}; '>Detalhe :</span> " . $detalhe . "  " . " <br />";
            //$htmlprincipal   .= "$tipo - $status     <br />" ;
            $htmlprincipal .= "<span style='color:{$corlabel}; '>Tipo    :</span> " . $tipo . "  " . " <br />";
            $htmlprincipal .= "<span style='color:{$corlabel}; '>Status  :</span> " . $status . "  " . " <br />";
            $htmlprincipal .= "<span style='color:{$corlabel}; '>Encaminhamento:</span> " . $encaminhamento . "  " . " <br />";
        }
        // é pai ou filho

        if ($idt_pendencia_pai == '') {   // Pai
            $htmlpai .= $htmlprincipal;
            $veiopai = 1;
            $idt_pendencia_pai = $idt_pendencia;
            //$idt_pendencia_raiz = $idt_pendencia_pai;
            $datasp = trata_data($data_solucao);
            if ($zebr == 1) {
                $corbackz = $corbackz0;
                $zebr = 0;
            } else {
                $corbackz = $corbackz1;
                $zebr = 1;
            }

            $html .= "<tr  style='' >  ";
            $html .= "   <td class='cab_ma'   style='color:#666666; text-align:left; font-size:16px; background:{$corbackz}; ' >";
            $html .= "<span style='color:{$corlabel}; '>Protocolo  :</span> $protocolo  <br />";
            $html .= "<span style='color:{$corlabel}; '>Demandante :</span> $demandente  <br />";
            $html .= "<span style='color:{$corlabel}; '>Cliente    :</span> $cpf - $nome_cliente  <br />";
            $html .= "<span style='color:{$corlabel}; '>Assunto    :</span> " . $assunto . "  " . " <br />";
            $html .= "<span style='color:{$corlabel}; '>Detalhe    :</span> " . $detalhe . "  " . " <br />";
            //$html .= "<span style='color:{$corlabel}; '>Tipo/Status:</span> $tipo - $status     <br />" ;
            $html .= "<span style='color:{$corlabel}; '>Tipo    :</span> " . $tipo . "  " . " <br />";
            $html .= "<span style='color:{$corlabel}; '>Status  :</span> " . $status . "  " . " <br />";

            $html .= "   </td> ";
            $html .= "</tr>";
            $html .= "<tr  style='' >  ";
            $html .= "   <td class='cab_ma'   style='background:#E0E0E0'; >";
            $html .= "<span style='color:{$corlabel}; '>Criada pendência</span> " . $idt_pendencia . " em " . $datad . "  Solução esperada para:" . $datasp . " <br />";
            //$html .= "Demandado : ".$demandado."  "." <br />" ;
            $html .= "<span style='color:{$corlabel}; '>Encaminhamento:</span> " . $encaminhamento . "  " . " <br />";
            $html .= "   </td> ";
            $html .= "</tr>";
        } else {  // filho acessar o pai
            $sqlt = 'select ';
            $sqlt .= '  grc_ap.*, ';
            $sqlt .= '  plu_de.nome_completo as demandente, ';
            $sqlt .= '  plu_rs.nome_completo as demandado ';

            $sqlt .= '  from  ' . db_pir_grc . 'grc_atendimento_pendencia grc_ap';
            $sqlt .= '  inner join ' . db_pir_grc . 'grc_atendimento grc_a  on grc_a.idt = grc_ap.idt_atendimento';
            $sqlt .= '  left  join ' . db_pir_grc . 'plu_usuario plu_de  on plu_de.id_usuario = grc_ap.idt_usuario';
            $sqlt .= '  left  join ' . db_pir_grc . 'plu_usuario plu_rs  on plu_rs.id_usuario = grc_ap.idt_responsavel_solucao';

            $sqlt .= '    where grc_ap.idt  = ' . null($idt_pendencia_raiz) . '  ';
            $rst = execsql($sqlt);

            //$idt_pendencia_raiz=$idt_pendencia_pai;

            if ($rst->rows == 0) {
                $vetRetorno['EOF'] = "S";
            } else {
                $vetRetorno['qtdRegistros'] = $rst->rows;

                ForEach ($rst->data as $rowt) {
                    $idt_pendencia = $rowt['idt'];
                    $idt_atendimento = $rowt['idt_atendimento'];
                    $idt_usuario = $rowt['idt_usuario'];
                    $idt_ponto_atendimento = $rowt['idt_ponto_atendimento'];
                    $data_solucao = $rowt['data_solucao'];
                    $protocolo = $rowt['protocolo'];
                    $assunto = $rowt['assunto'];
                    $detalhe = $rowt['observacao'];
                    $tipo = $rowt['tipo'];
                    $status = $rowt['status'];
                    $recorrencia = $rowt['recorrencia'];
                    $data = $rowt['data'];
                    $data_inicio_atendimento = $rowt['data_inicio_atendimento'];
                    $data_solucao = $rowt['data_solucao'];
                    $observacao = $rowt['observacao'];
                    $enviar_email = $rowt['enviar_email'];
                    $recorrencia = $rowt['recorrencia'];
                    $cpf = $rowt['cpf'];
                    $cod_cliente_siac = $rowt['cod_cliente_siac'];
                    $nome_cliente = $rowt['nome_cliente'];
                    $cnpj = $rowt['cnpf'];
                    $temporario = $rowt['temporario'];

                    $demandente = $rowt['demandente'];
                    $demandado = $rowt['demandado'];
                    $opcao_tramitacao = $rowt['opcao_tramitacao'];

                    $parecer_encaminhamento = $rowt['parecer_encaminhamento'];
                    $data_solucao_atendimento = $rowt['data_solucao_atendimento'];
                    $consideracoes_encaminhamento = $rowt['consideracoes_encaminhamento'];
                    $data_resposta_encaminhamento = $rowt['data_resposta_encaminhamento'];
                    $encaminhamento = $consideracoes_encaminhamento;
                    $dataw = $data . " - " . $idt_pendencia;
                    $vetHistorico[$dataw] = $rowt;
                    $datad = trata_data($data);


                    $html .= "<tr  style='' >  ";
                    $html .= "   <td class='cab_ma'   style='color:#666666;  text-align:left; font-size:16px; background:#F1F1F1; ' >";
                    $html .= "<span style='color:{$corlabel}; '>Protocolo  :</span> $protocolo  <br />";
                    $html .= "<span style='color:{$corlabel}; '>Demandante :</span> $demandente  <br />";
                    $html .= "<span style='color:{$corlabel}; '>Cliente    :</span> $cpf - $nome_cliente  <br />";
                    $html .= "<span style='color:{$corlabel}; '>Assunto    :</span> " . $assunto . "  " . " <br />";
                    $html .= "<span style='color:{$corlabel}; '>Detalhe    :</span> " . $detalhe . "  " . " <br />";
//					$html .= "<span style='color:{$corlabel}; '>Tipo/Status:</span> $tipo - $status     <br />" ;
                    $html .= "<span style='color:{$corlabel}; '>Tipo    :</span> " . $tipo . "  " . " <br />";
                    $html .= "<span style='color:{$corlabel}; '>Status  :</span> " . $status . "  " . " <br />";

                    $html .= "   </td> ";
                    $html .= "</tr>";

                    $datasp = trata_data($data_solucao);

                    $html .= "   <td class='cab_ma'   style='background:#E0E0E0;' >";
                    //$html .= "Tramitação : ".$idt_pendencia." em ".$datad." <br />" ;
                    $html .= "<span style='color:{$corlabel}; '>Criada pendência</span> " . $idt_pendencia . " em " . $datad . "  Solução esperada para:" . $datasp . " <br />";
                    //$html .= "<span style='color:{$corlabel}; '>Demandado : ".$demandado."  "." <br />" ;
                    $html .= "<span style='color:{$corlabel}; '>Encaminhamento:</span> " . $encaminhamento . "  " . " <br />";
                    $html .= "   </td> ";
                    $html .= "</tr>";
                }
            }
        }
        // Todos 

        $htmlgeral = "";
        $sqlt = 'select ';
        $sqlt .= '  grc_ap.*, ';
        $sqlt .= '  plu_de.nome_completo as demandante, ';
        $sqlt .= '  plu_rs.nome_completo as demandado ';

        $sqlt .= '  from  ' . db_pir_grc . 'grc_atendimento_pendencia grc_ap';
        $sqlt .= '  inner join ' . db_pir_grc . 'grc_atendimento grc_a  on grc_a.idt = grc_ap.idt_atendimento';
        $sqlt .= '  left  join ' . db_pir_grc . 'plu_usuario plu_de  on plu_de.id_usuario = grc_ap.idt_usuario';
        $sqlt .= '  left  join ' . db_pir_grc . 'plu_usuario plu_rs  on plu_rs.id_usuario = grc_ap.idt_responsavel_solucao';
        $sqlt .= '    where grc_ap.idt_atendimento     = ' . null($idt_atendimento) . '  ';
        $sqlt .= '      and grc_ap.idt_pendencia_raiz  = ' . null($idt_pendencia_raiz) . '  ';
        $sqlt .= '  order by  data, idt ';

        $rst = execsql($sqlt);
        if ($rst->rows == 0) {
            $vetRetorno['EOF'] = "S";
        } else {
            $vetRetorno['qtdRegistros'] = $rst->rows;

            ForEach ($rst->data as $rowt) {
                $idt_pendencia = $rowt['idt'];
                $idt_pendencia_pai = $rowt['idt_pendencia_pai'];
                $idt_pendencia_raiz = $rowt['idt_pendencia_raiz'];
                if ($idt_pendencia_raiz == $idt_pendencia) {
                    continue;
                }
                $idt_atendimento = $rowt['idt_atendimento'];
                $idt_usuario = $rowt['idt_usuario'];
                $idt_ponto_atendimento = $rowt['idt_ponto_atendimento'];
                $data_solucao = $rowt['data_solucao'];
                $protocolo = $rowt['protocolo'];
                $assunto = $rowt['assunto'];
                $detalhe = $rowt['observacao'];

                $recorrencia = $rowt['recorrencia'];
                $data = $rowt['data'];
                $data_inicio_atendimento = $rowt['data_inicio_atendimento'];
                $data_solucao = $rowt['data_solucao'];
                $observacao = $rowt['observacao'];
                $enviar_email = $rowt['enviar_email'];
                $recorrencia = $rowt['recorrencia'];
                $cpf = $rowt['cpf'];
                $cod_cliente_siac = $rowt['cod_cliente_siac'];
                $nome_cliente = $rowt['nome_cliente'];
                $cnpj = $rowt['cnpf'];
                $temporario = $rowt['temporario'];

                $demandante = $rowt['demandante'];
                $demandado = $rowt['demandado'];

                $opcao_tramitacao = $rowt['opcao_tramitacao'];
                $idt_status_tramitacao = $rowt['idt_status_tramitacao'];

                $parecer_encaminhamento = $rowt['parecer_encaminhamento'];
                $data_solucao_atendimento = $rowt['data_solucao_atendimento'];
                $consideracoes_encaminhamento_pai = $rowt['consideracoes_encaminhamento_pai'];
                $data_resposta_encaminhamento_pai = $rowt['data_resposta_encaminhamento_pai'];
                $consideracoes_encaminhamento = $rowt['consideracoes_encaminhamento'];
                $data_resposta_encaminhamento = $rowt['data_resposta_encaminhamento'];
                if ($idt_pendencia_pai == '') {   // Pai
                    $dataw = $data . " - " . $idt_pendencia;
                    $datad = trata_data($data);
                    $encaminhamento = $consideracoes_encaminhamento;
                } else {
                    $dataw = $data_resposta_encaminhamento . " - " . $idt_pendencia;
                    $datad = trata_data($data_resposta_encaminhamento_pai);
                    $encaminhamento = $consideracoes_encaminhamento_pai;
                }
                $vetHistorico[$dataw] = $rowt;
                if ($zebr == 1) {
                    $corbackz = $corbackz0;
                    $zebr = 0;
                } else {
                    $corbackz = $corbackz1;
                    $zebr = 1;
                }
                $corlabelC = "#ff0000";
                $datar = trata_data($data);
                $html .= "<tr  style='' >  ";
                $html .= "   <td class='cab_ma'   style='color:#666666;  background:{$corbackz}; ' >";
                if ($opcao_tramitacao == 'R') {
                    if ($idt_status_tramitacao == 3) {
                        $html .= "<span style='color:{$corlabelC}; '>FINALIZADO - ATENDIDO  :</span> " . $idt_pendencia . " em " . $datar . " Previsão para: " . $datad . " <br />";
                    } else {
                        $html .= "<span style='color:{$corlabelC}; '>FINALIZADO - CANCELADO  :</span> " . $idt_pendencia . " em " . $datar . " Previsão para: " . $datad . " <br />";
                    }
                } else {
                    $html .= "<span style='color:{$corlabel}; '>Tramitação :</span> " . $idt_pendencia . " em " . $datar . " Previsão para: " . $datad . " <br />";
                }
                //$html .= "Assunto: ".$assunto."  "." <br />" ;
                $html .= "<span style='color:{$corlabel}; '>Demandante :</span> " . $demandante . "  " . " <br />";
                $html .= "<span style='color:{$corlabel}; '>Demandado  :</span> " . $demandado . "  " . " <br />";
                //$html .= "$tipo - $status     <br />" ;

                if ($opcao_tramitacao == 'R') {
                    $data_solucao_atendimentow = trata_data($data_solucao_atendimento);
                    $html .= "<span style='color:{$corlabelC}; '>Data Solução:</span> " . $data_solucao_atendimentow . "  " . " <br />";
                    $html .= "<span style='color:{$corlabelC}; '>Solução     :</span> " . $parecer_encaminhamento . "  " . " <br />";
                } else {
                    $html .= "<span style='color:{$corlabel}; '>Encaminhamento:</span> " . $encaminhamento . "  " . " <br />";
                }
                $html .= "   </td> ";
                $html .= "</tr>";
            }
        }
    }
    $html .= "</table>";

    ksort($vetHistorico);
    if ($veiopai == 0) {
        //$html .= $htmlpai.$htmlprincipal. $html;
        //$html .= $htmlpai. $htmlgeral;
    } else {
        //$html .= $htmlpai. $htmlgeral;
    }

    $Retorno['html'] = $html;

    $kokw = 1;
    return $kokw;
}

function BuscaClienteFunil($codigo, &$vetRetorno) {
    $vetRetornop = Array();
    $ano_base = Funil_parametro(1, $vetRetornop);
    $rowt = $vetRetornop[$ano_base];
    $msgClientesemClassificacao = $rowt['msgclientesemclassificacao'];

    $msgClientesemClassificacao = str_replace(chr(13), '\n', $msgClientesemClassificacao);
    $msgClientesemClassificacao = str_replace(chr(10), '', $msgClientesemClassificacao);


    $sqlt = 'select ';
    $sqlt .= '  grc_fcc.* ';
    $sqlt .= "  from  grc_funil_{$ano_base}_cliente_classificado grc_fcc ";
    $sqlt .= '    where grc_fcc.codigo = ' . aspa($codigo) . '  ';
    $rst = execsql($sqlt);
    if ($rst->rows == 0) {
        $vetRetorno['EOF'] = "S";
    } else {
        $vetRetorno['EOF'] = "N";
        ForEach ($rst->data as $rowt) {
            $idt_cliente = $rowt['idt'];
            $idt_cliente_classificacao = $rowt['idt_cliente_classificacao'];
            $nota = $rowt['nota'];
        }
    }
    $vetRetorno['idt_cliente'] = $idt_cliente;
    $vetRetorno['idt_cliente_classificacao'] = $idt_cliente_classificacao;
    $vetRetorno['nota'] = $nota;
    $vetRetorno['msgClientesemClassificacao'] = $msgClientesemClassificacao;
}

//
// Fim do programa
//
