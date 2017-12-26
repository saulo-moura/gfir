<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if (wsPathGRC == 'wsPathGRC') {
    if ($_REQUEST['cas'] == '') {
        $_REQUEST['cas'] = 'conteudo_abrir_sistema';
    }
    define('conteudo_abrir_sistema', $_REQUEST['cas']);

    Require_Once('configuracao.php');

    if ($_SESSION[CS]['g_id_usuario'] == '') {
        if ($_GET['tipo'] != 'DetalharHistorico' && $_GET['tipo'] != 'GerarDW' && $_GET['tipo'] != 'GeraDWIQ') {
            die('O acesso ao sistema expirou! Favor entrar no sistema outra vez.');
        }
    }

    if (file_exists('funcao_atendimento.php')) {
        Require_Once('funcao_atendimento.php');
    }
}

switch ($_GET['tipo']) {


    case 'ChamaAtendimento':

        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $idt_cliente = $_POST['idt_cliente'];
        $variavel = Array();
        ChamaAtendimento($idt_atendimento_agenda, $idt_cliente, $variavel);
        //echo "teste de guy $idt_atendimento_agenda ==== $idt_cliente";
        break;

    case 'ConfirmaAgendamento':

        $datadia = date('d/m/Y H:i');
        $data = explode(' ', $datadia);
        $dt = $data[0];
        $hora = $data[1];

        $data_confirmacao = trata_data($dt);

        $idt_atendimento_agenda = null($_POST['idt_atendimento_agenda']);
        $sql = "update grc_atendimento_agenda ";
        $sql .= " set ";
        $sql .= " data_confirmacao           = " . aspa($data_confirmacao) . ", ";
        $sql .= " hora_confirmacao           = " . aspa($hora) . " ";
        $sql .= " where idt = " . null($idt_atendimento_agenda);
        execsql($sql);

        echo $dt . '###' . $hora . '###';

        break;

    case 'DesfazConfirmaAgendamento':

        //$datadia = date('d/m/Y H:i');
        //$data = explode(' ', $datadia);
        $dt = "";
        $hora = "";
        $data_confirmacao = trata_data($dt);


        $idt_atendimento_agenda = null($_POST['idt_atendimento_agenda']);
        $sql = "update grc_atendimento_agenda ";
        $sql .= " set ";
        $sql .= " data_confirmacao           = " . aspa($data_confirmacao) . ", ";
        $sql .= " hora_confirmacao           = " . aspa($hora) . " ";
        $sql .= " where idt = " . null($idt_atendimento_agenda);
        execsql($sql);

        echo $dt . '###' . $hora . '###';


        break;

    case 'BloqueiaHorario':

        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel = Array();
        $ret = BloqueiaHorario($idt_atendimento_agenda, $variavel);
        echo $ret . '###';
        break;

    case 'DesbloqueiaHorario':

        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel = Array();
        $ret = DesbloqueiaHorario($idt_atendimento_agenda, $variavel);
        echo $ret . '###';
        break;

    case 'CancelaHorario':
        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel = Array();
        $ret = CancelaHorario($idt_atendimento_agenda, $variavel);
        echo $ret . '###';
        break;

    case 'DescancelaHorario':

        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel = Array();
        $ret = DescancelaHorario($idt_atendimento_agenda, $variavel);
        echo $ret . '###';
        break;

    case 'CancelaAgendamento':
        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel = Array();
        CancelaAgendamento($idt_atendimento_agenda, $variavel);
        break;

    case 'ConfirmaChegada':

        $datadia = date('d/m/Y H:i');
        $data = explode(' ', $datadia);
        $dt = $data[0];
        $hora = $data[1];
        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel = Array();
        ConfirmaChegada($idt_atendimento_agenda, $variavel);
        echo $dt . '###' . $hora . '###';
        break;

    case 'ConfirmaAusencia':

        $datadia = date('d/m/Y H:i');
        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel = Array();
        $variavel['data'] = $datadia;
        ConfirmaAusencia($idt_atendimento_agenda, $variavel);
        echo $datadia . '###';
        break;

    case 'DesfazConfirmaAusencia':
        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel = Array();
        $variavel['data'] = "";
        ConfirmaAusencia($idt_atendimento_agenda, $variavel);
        echo "" . '###';
        break;

    case 'ConfirmaLiberacao':

        $datadia = date('d/m/Y H:i');
        $data = explode(' ', $datadia);
        $dt = $data[0];
        $hora = $data[1];
        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel = Array();
        ConfirmaLiberacao($idt_atendimento_agenda, $variavel);
        echo $dt . '###' . $hora . '###';
        break;

    case 'ConfirmaAtendimento':

        // iniciar o atendimento
        $datadia = date('d/m/Y H:i');
        $data = explode(' ', $datadia);
        $dt = $data[0];
        $hora = $data[1];
        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel = Array();
        ConfirmaAtendimento($idt_atendimento_agenda, $variavel);
        //echo $dt.'###'.$hora.'###';
        break;

    case 'TerminarAtendimento':
        // terminar o atendimento
        $datadia = date('d/m/Y H:i');
        $data = explode(' ', $datadia);
        $dt = $data[0];
        $hora = $data[1];
        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel = Array();
        TerminarAtendimento($idt_atendimento_agenda, $variavel);
        //echo $dt.'###'.$hora.'###';
        break;

    case 'ConfirmaGeracaoAgenda':

        $idt_atendimento_gera_agenda = $_POST['idt_atendimento_gera_agenda'];

        $ret = 0;
        $vetret = array();
        $ret = geracao_agenda($idt_atendimento_gera_agenda, $vetret);

        if ($ret == 0 or $ret == 2) {
            echo "\n\nErro Geração da Agenda\n\n" . $ret;
        }

        break;

    case 'ConfirmaGeracaoPainel':

        $idt_atendimento_gera_painel = $_POST['idt_atendimento_gera_painel'];

        $ret = 0;
        $vetret = array();
        $ret = geracao_painel($idt_atendimento_gera_painel, $vetret);

        if ($ret == 0 or $ret == 2) {
            echo "\n\nErro Geração do Painel\n\n";
        }

        break;

    case 'BuscaPessoa':
        $idt_ponto_atendimento = $_POST['idt_ponto_atendimento'];
        $protocolo_marcacao = $_POST['protocolo_marcacao'];
        $cpf = $_POST['cpf'];
        $nome = utf8_decode($_POST['nome']);
        $cnpj = $_POST['cnpj'];
        $nome_empresa = utf8_decode($_POST['nome_empresa']);
        $telefone = $_POST['telefone'];
        $celular = $_POST['celular'];
        $email = $_POST['email'];
        $idt_cliente = $_POST['idt_cliente'];

        $nome = str_replace('undefined', "", $nome);
        $cpf = str_replace('undefined', "", $cpf);
        $cnpj = str_replace('undefined', "", $cnpj);
        $nome_empresa = str_replace('undefined', "", $nome_empresa);
        $telefone = str_replace('undefined', "", $telefone);
        $celular = str_replace('undefined', "", $celular);
        $email = str_replace('undefined', "", $email);
        $protocolo_marcacao = str_replace('undefined', "", $protocolo_marcacao);
        $idt_cliente = str_replace('undefined', "", $idt_cliente);
        //
        $ret = 0;
        $vetret = array();
        $vetret['existe_pessoa'] = "";
        $vetret['nome'] = $nome;
        $vetret['cpf'] = $cpf;
        $vetret['telefone'] = $telefone;
        $vetret['celular'] = $celular;
        $vetret['email'] = $email;
        $vetret['protocolo_marcacao'] = $protocolo_marcacao;
        $vetret['cnpj'] = $cnpj;
        $vetret['nome_empresa'] = $nome_empresa;
        $vetret['idt_cliente'] = $idt_cliente;

        $vetret['data_nascimento'] = "";
        // echo " -------------------------------------------- $idt_cliente <br /> ";
        $ret = BuscaPessoa($idt_ponto_atendimento, $vetret);
        //
        if ($ret == 0) {
            echo "\n\nErro Busca CPF\n\n";
        } else {
            $existe = 'N';
            if ($ret == 1) {
                $existe = 'S';
            }




            //p($vetret);
            /*
              $vetret['nome']="Luiz Augusto Rehm Pereira";
              $vetret['cpf']="061846425-53";
              $vetret['telefone']="7132450190";
              $vetret['celular']="7188489436";
              $vetret['email']="luizrehmpereira@gmail.com";
              $vetret['protocolo_marcacao']="MA9999999";

              $vetret['cnpj']    = "04.848.154/0001-99";
              $vetret['nome_empresa'] = "LUPE Engenharia da Informação";
             */
            $nome = $vetret['nome'];
            $cpf = $vetret['cpf'];
            $telefone = $vetret['telefone'];
            $celular = $vetret['celular'];
            $sms_1 = $vetret['sms_1'];
            $email = $vetret['email'];
            $protocolo_marcacao = $vetret['protocolo_marcacao'];
            $idt_entidade = $vetret['idt_entidade'];
            $cnpj = $vetret['cnpj'];
            $nome_empresa = $vetret['nome_empresa'];
            $data_nascimento = $vetret['data_nascimento'];

            $parametro = "";
            $parametro .= "{$existe}###";
            $parametro .= "{$nome}###";
            $parametro .= "{$cpf}###";
            $parametro .= "{$telefone}###";
            $parametro .= "{$celular}###";
            $parametro .= "{$email}###";
            $parametro .= "{$protocolo_marcacao}###";
            $parametro .= "{$cnpj}###";
            $parametro .= "{$nome_empresa}###";
            $parametro .= "{$idt_entidade}###";
            $parametro .= "{$data_nascimento}###";
            $parametro .= "{$sms_1}###";

            echo $parametro;
        }

        break;

    case 'usuario_especialidade':
        $sql = "select distinct plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
        $sql .= " inner join grc_atendimento_usuario_especialidade grc_aue on grc_aue.idt_usuario = plu_usu.id_usuario ";
        if ($_GET['val'] > 0) {
            $sql .= " where grc_aue.idt_atendimento_especialidade = " . null($_GET['val']);
        }
        $sql .= " order by plu_usu.nome_completo";
        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'IniciaAtendimento':

        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $idt_cliente = $_POST['idt_cliente'];
        $variavel = Array();
        $variavel['instrumento'] = 2;  // inicia com Orientação técnica

        IniciaAtendimento($idt_atendimento_agenda, $idt_cliente, $variavel);
        //echo "teste de guy $idt_atendimento_agenda ==== $idt_cliente";
        break;

    case 'FinalizarAtendimento':
        $idt_atendimento = $_POST['idt_atendimento'];
        $variavel = Array();
        FinalizarAtendimento($idt_atendimento, $variavel);
        break;

    case 'CancelaAtendimento':
        $idt_atendimento = $_POST['idt_atendimento'];
        $variavel = Array();
        CancelaAtendimento($idt_atendimento, $variavel);
        break;

    case 'RefreshPainelClientes':
        $vet = Array(
            'erro' => '',
            'html' => '',
            'senha_atual' => '',
        );

        try {
            ob_start();
            $idt_atendimento_painel = $_POST['idt_atendimento_painel'];
            $variavel = Array();
            RefreshPainelClientes_sebrae($idt_atendimento_painel, $variavel);
            $vet['erro'] = rawurlencode(ob_get_clean());
            ob_end_clean();

            $vet['html'] = rawurlencode($variavel['html']);
            $vet['senha_atual'] = rawurlencode($variavel['senha_atual']);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'ConsisteHoras':
        $acao = $_POST['acao'];
        $idt = $_POST['idt'];
        $idt_usuario = $_POST['idt_usuario'];
        $dia = $_POST['dia'];
        $hora_inicial = $_POST['hora_inicial'];
        $hora_final = $_POST['hora_final'];
        $variavel = Array();
        ConsisteHoras($acao, $idt, $idt_usuario, $dia, $hora_inicial, $hora_final, $variavel);

        $retorno = $variavel['ret0'];
        $mensagem = $variavel['ret1'];

        echo $retorno . '###' . $mensagem . '###';
//      exit();

        break;

    case 'RefreshPainelBordo':
        $variavel = Array();
        $opcao = $_POST['opcao'];
        $variavel['opcao'] = $opcao;
        PainelBordoTela($variavel);
        //echo $variavel['html'].$variavel['script'];
        echo $variavel['html'];
        break;


    case 'GraficoPainelBordo':
        $vetEstatistica = Array();
        $vetEstatistica['opcao'] = $_GET['opcao'];
        CriaDimensoes($vetEstatistica);

        $quantidadetotal = 4;
        $dim = $_GET['dim'];
        if ($dim == 'data') {
            $idt_ponto_atendimento = 1;
            $vetPontoAtendimento = $vetEstatistica[$idt_ponto_atendimento];
            $vetPontoAtendimentoData = $vetPontoAtendimento['data'];
            //p($vetPontoAtendimentoData);
            //break;
            $Vetcategorias = Array();
            $Vetquantidade = Array();
            $quantidadetotal = 0;
            ForEach ($vetPontoAtendimentoData as $Data => $Quantidade) {
                $dia = substr($Data, 8, 2);
                //$dia = aspa($Data);
                $Vetcategorias[] = $dia;
                $Vetquantidade[] = $Quantidade;
                $quantidadetotal = $quantidadetotal + $Quantidade;
            }
            $graph_data = array('Vetcategorias' => $Vetcategorias, 'Vetquantidade' => $Vetquantidade, 'clicks' => $click);
            echo json_encode($graph_data);
        }
        if ($dim == 'porte') {
            $idt_ponto_atendimento = 1;
            $vetPontoAtendimento = $vetEstatistica[$idt_ponto_atendimento];
            $vetPontoAtendimentoPorte = $vetPontoAtendimento['porte'];
            //p($vetPontoAtendimentoData);
            //break;
            $Vetcategorias = Array();
            $Vetquantidade = Array();
            ForEach ($vetPontoAtendimentoPorte as $idt => $Quantidade) {
                $Vetcategorias[] = $vetEstatistica['DIM']['PORTE'][$idt];
                $nmponto = $vetEstatistica['DIM']['PORTE'][$idt];
                if ($nmponto == '') {
                    $nmponto = 'N/A' . $idt;
                }
                $vetPonto = Array();
                $vetPonto[] = $nmponto;
                $vetPonto[] = $Quantidade;
                $Vetquantidade[] = $vetPonto;
            }
            $graph_data = array('Vetcategorias' => $Vetcategorias, 'Vetquantidade' => $Vetquantidade, 'clicks' => $click);
            echo json_encode($graph_data);
        }
        if ($dim == 'PJPF') {
            $idt_ponto_atendimento = 1;
            $vetPontoAtendimento = $vetEstatistica[$idt_ponto_atendimento];
            $vetPontoAtendimentoPJPF = $vetPontoAtendimento['PJPF'];
            //p($vetPontoAtendimentoData);
            //break;
            $Vetcategorias = Array();
            $Vetquantidade = Array();
            ForEach ($vetPontoAtendimentoPJPF as $tipo => $Quantidade) {

                $Vetcategorias[] = $vetEstatistica['DIM']['PJPF'][$tipo];
                $nmponto = $vetEstatistica['DIM']['PJPF'][$tipo];
                $vetPonto = Array();
                //  $vetPonto[]        = $nmponto;
                //  $vetPonto[]        = $Quantidade;
                //                   " name: '$nmponto', y: $Quantidade  ";
                //  {name: "Microsoft Internet Explorer", y: 56.33},

                $vetPonto[] = $nmponto;
                $vetPonto[] = $Quantidade;


                $Vetquantidade[] = $vetPonto;
            }
            $graph_data = array('Vetcategorias' => $Vetcategorias, 'Vetquantidade' => $Vetquantidade, 'clicks' => $click);
            echo json_encode($graph_data);
        }

        /*
          // titulos no eixo dos x
          //$categories = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
          // serie 1
          //$impression = array(12, 25, 100, 58, 63, 30, 5, 40, 91, 10, 50, 36);
          // serie 2
          $click      = array(6, 12, 40, 28, 31, 15, 2, 20, 45, 5, 25, 18);
          $categories = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
          $impression = array(12, 25, 100, 58, 63, 30, 5, 40, 91, 10, 50, 36);
          $click      = array(6, 12, 40, 28, 31, 15, 2, 20, 45, 5, 25, 18);
          $graph_data = array('Vetcategorias'=>$Vetcategorias, 'Vetquantidade'=>$Vetquantidade, 'clicks'=>$click);
          echo json_encode($graph_data);
         */


        break;

    case 'PesquisarCPFTOTEM':
        $cpf = $_POST['cpf'];
        $variavel = Array();
        PesquisarCPFTOTEM($cpf, $variavel);
        $existecadastro = $variavel['existecadastro'];
        $existeagenda = $variavel['existeagenda'];
        $idt_atendimento_agenda = $variavel['idt_atendimento_agenda'];
        $qtdagendamentos = $variavel['qtdagendamentos'];

        $existeempresascadastro = $variavel['existeempresascadastro'];
        $existeempresasatendimento = $variavel['existeempresasatendimento'];
        $nome_cliente = $variavel['nome_cliente'];
        $data_nascimento = $variavel['data_nascimento'];
        $idade_cliente = $variavel['idade_cliente'];
        $portador_deficiencia = $variavel['portador_deficiencia'];
        $agendamento_data_hora = $variavel['agendamento_data_hora'];
        $agendamento_consultor_nome = $variavel['agendamento_consultor_nome'];
        $agendamento_consultor_letra = $variavel['agendamento_consultor_letra'];

        $agendamento_empreendimento_cnpj = $variavel['agendamento_empreendimento_cnpj'];
        $agendamento_empreendimento_razao_social = $variavel['agendamento_empreendimento_razao_social'];
        //
        $empreendimento_1 = $variavel['empreendimento_1'];
        $empreendimento_2 = $variavel['empreendimento_2'];
        $empreendimento_3 = $variavel['empreendimento_3'];
        $empreendimento_4 = $variavel['empreendimento_4'];
        $empreendimento_5 = $variavel['empreendimento_5'];
        $empreendimento_6 = $variavel['empreendimento_6'];
        $empreendimento_7 = $variavel['empreendimento_7'];


        $empreendimentofan_1 = $variavel['empreendimentofan_1'];
        $empreendimentofan_2 = $variavel['empreendimentofan_2'];
        $empreendimentofan_3 = $variavel['empreendimentofan_3'];
        $empreendimentofan_4 = $variavel['empreendimentofan_4'];
        $empreendimentofan_5 = $variavel['empreendimentofan_5'];
        $empreendimentofan_6 = $variavel['empreendimentofan_6'];
        $empreendimentofan_7 = $variavel['empreendimentofan_7'];

        $qtd_empresas = $variavel['qtd_empresas'];

        $cnpj_1 = $variavel['cnpj_1'];
        $cnpj_2 = $variavel['cnpj_2'];
        $cnpj_3 = $variavel['cnpj_3'];
        $cnpj_4 = $variavel['cnpj_4'];
        $cnpj_5 = $variavel['cnpj_5'];
        $cnpj_6 = $variavel['cnpj_6'];
        $cnpj_7 = $variavel['cnpj_7'];

        $jatemprioridade = $variavel['jatemprioridade'];

        //
        //       $existeagenda='N';
        //       $qtd_empresas=5;

        $retorno = "";
        $retorno .= $cpf . "###";
        $retorno .= $existecadastro . "###";
        $retorno .= $existeagenda . "###";
        $retorno .= $existeempresascadastro . "###";
        $retorno .= $existeempresasatendimento . "###";

        $retorno .= $nome_cliente . "###";
        $retorno .= $idade_cliente . "###";
        $retorno .= $portador_deficiencia . "###";
        $retorno .= $agendamento_data_hora . "###";
        $retorno .= $agendamento_consultor_nome . "###";
        $retorno .= $agendamento_consultor_letra . "###";

        $retorno .= $agendamento_empreendimento_cnpj . "###";
        $retorno .= $agendamento_empreendimento_razao_social . "###";

        if ($empreendimento_1 != "") {
            $empreendimento_1 = "Atendimento para a empresa " . $empreendimento_1;
        }
        if ($empreendimento_2 != "") {
            $empreendimento_2 = "Atendimento para a empresa " . $empreendimento_2;
        }
        if ($empreendimento_3 != "") {
            $empreendimento_3 = "Atendimento para a empresa " . $empreendimento_3;
        }
        if ($empreendimento_4 != "") {
            $empreendimento_4 = "Atendimento para a empresa " . $empreendimento_4;
        }
        if ($empreendimento_5 != "") {
            $empreendimento_5 = "Atendimento para a empresa " . $empreendimento_5;
        }
        if ($empreendimento_6 != "") {
            $empreendimento_6 = "Atendimento para a empresa " . $empreendimento_6;
        }
        if ($empreendimento_7 != "") {
            $empreendimento_7 = "Atendimento para a empresa " . $empreendimento_7;
        }
        $retorno .= $empreendimento_1 . "###";
        $retorno .= $empreendimento_2 . "###";
        $retorno .= $empreendimento_3 . "###";
        $retorno .= $empreendimento_4 . "###";
        $retorno .= $empreendimento_5 . "###";
        $retorno .= $empreendimento_6 . "###";
        $retorno .= $empreendimento_7 . "###";
        $retorno .= $qtd_empresas . "###";
        $retorno .= $qtdagendamentos . "###";
        //
        $retorno .= $data_nascimento . "###";
        //
        $retorno .= $cnpj_1 . "###";
        $retorno .= $cnpj_2 . "###";
        $retorno .= $cnpj_3 . "###";
        $retorno .= $cnpj_4 . "###";
        $retorno .= $cnpj_5 . "###";
        $retorno .= $cnpj_6 . "###";
        $retorno .= $cnpj_7 . "###";

        $retorno .= $idt_atendimento_agenda . "###";
        $retorno .= $jatemprioridade . "###";

        $retorno .= $empreendimentofan_1 . "###";
        $retorno .= $empreendimentofan_2 . "###";
        $retorno .= $empreendimentofan_3 . "###";
        $retorno .= $empreendimentofan_4 . "###";
        $retorno .= $empreendimentofan_5 . "###";
        $retorno .= $empreendimentofan_6 . "###";
        $retorno .= $empreendimentofan_7 . "###";

        //
        echo $retorno;
        break;


//case 'GerarSenhaTOTEM2':
    //$senha_totem = '99999';
    //      $retorno = "";
    //    $retorno .= $senha_totem."###";
    //  echo $retorno;
    //break;

    case 'GerarSenhaTOTEM':
        $variavel = Array();
        $variavel['cpf'] = $_POST['cpf'];
        $variavel['existecadastro'] = $_POST['existecadastro'];
        $variavel['existeagenda'] = $_POST['existeagenda'];
        $variavel['qtdagendamentos'] = $_POST['qtdagendamentos'];
        $variavel['existeempresascadastro'] = $_POST['existeempresascadastro'];
        $variavel['existeempresasatendimento'] = $_POST['existeempresasatendimento'];
        $variavel['nome_cliente'] = utf8_decode($_POST['nome_cliente']);
        $variavel['data_nascimento'] = $_POST['data_nascimento'];
        $variavel['idade_cliente'] = $_POST['idade_cliente'];
        $variavel['portador_deficiencia'] = $_POST['portador_deficiencia'];
        $variavel['agendamento_data_hora'] = $_POST['agendamento_data_hora'];
        $variavel['agendamento_consultor_nome'] = utf8_decode($_POST['agendamento_consultor_nome']);
        $variavel['agendamento_consultor_letra'] = $_POST['agendamento_consultor_letra'];
        $variavel['agendamento_empreendimento_cnpj'] = $_POST['agendamento_empreendimento_cnpj'];
        $variavel['agendamento_empreendimento_razao_social'] = utf8_decode($_POST['agendamento_empreendimento_razao_social']);
        $variavel['empreendimento_1'] = utf8_decode($_POST['empreendimento_1']);
        $variavel['empreendimento_2'] = utf8_decode($_POST['empreendimento_2']);
        $variavel['empreendimento_3'] = utf8_decode($_POST['empreendimento_3']);
        $variavel['empreendimento_4'] = utf8_decode($_POST['empreendimento_4']);
        $variavel['empreendimento_5'] = utf8_decode($_POST['empreendimento_5']);
        $variavel['empreendimento_6'] = utf8_decode($_POST['empreendimento_6']);
        $variavel['empreendimento_7'] = utf8_decode($_POST['empreendimento_7']);
        $variavel['empreendimentofan_1'] = utf8_decode($_POST['empreendimentofan_1']);
        $variavel['empreendimentofan_2'] = utf8_decode($_POST['empreendimentofan_2']);
        $variavel['empreendimentofan_3'] = utf8_decode($_POST['empreendimentofan_3']);
        $variavel['empreendimentofan_4'] = utf8_decode($_POST['empreendimentofan_4']);
        $variavel['empreendimentofan_5'] = utf8_decode($_POST['empreendimentofan_5']);
        $variavel['empreendimentofan_6'] = utf8_decode($_POST['empreendimentofan_6']);
        $variavel['empreendimentofan_7'] = utf8_decode($_POST['empreendimentofan_7']);
        $variavel['cnpj_1'] = $_POST['cnpj_1'];
        $variavel['cnpj_2'] = $_POST['cnpj_2'];
        $variavel['cnpj_3'] = $_POST['cnpj_3'];
        $variavel['cnpj_4'] = $_POST['cnpj_4'];
        $variavel['cnpj_5'] = $_POST['cnpj_5'];
        $variavel['cnpj_6'] = $_POST['cnpj_6'];
        $variavel['cnpj_7'] = $_POST['cnpj_7'];
        $variavel['qtd_empresas'] = $_POST['qtd_empresas'];
        $variavel['senha_totem'] = $_POST['senha_totem'];
        $variavel['idt_atendimento_agenda'] = $_POST['idt_atendimento_agenda'];
        $variavel['empresaavulso'] = $_POST['empresaavulso'];
        $variavel['empresaescolhida'] = $_POST['empresaescolhida'];
        $variavel['prioridadeavulso'] = $_POST['prioridadeavulso'];
        $variavel['cnpjempresaatendimento'] = $_POST['cnpjempresaatendimento'];
        $variavel['nomeempresaatendimento'] = utf8_decode($_POST['nomeempresaatendimento']);
        $variavel['empresa_escolhida'] = $_POST['empresa_escolhida'];
        $variavel['empresa_nome_escolhida'] = utf8_decode($_POST['empresa_nome_escolhida']);
        //
        GerarSenhaTOTEM($variavel);
        $senha_totem = $variavel['senha_totem'];
        //$senha_totem = '99999';
        $retorno = "";
        $retorno .= $senha_totem . "###";
        echo $retorno;

        break;

    case 'MenuBia':
        $html = GeraMenuBia();
        echo $html;
        break;

    case 'ConteudoBia':
        $idt_pai = $_POST['idt_pai'];
        $idt_filho = $_POST['idt_filho'];
        $codigo = $_POST['codigo'];
        $html = GeraConteudoBia($codigo, $idt_pai, $idt_filho);
        echo $html;
        break;


    case 'PesquisarBIA':
        $idt_atendimento = $_POST['idt_atendimento'];
        $texto_pesq_bia = utf8_decode($_POST['texto_pesq_bia']);
        $html = PesquisarBIA($texto_pesq_bia);
        echo $html;
        break;

    /*
      case 'EnviarEmailBia':
      $marcados    = $_POST['marcados'];
      $idt_pessoa  = $_POST['idt_pessoa'];
      $html        = EnviarEmailBia($idt_pessoa,$marcados);
      echo $html;
      break;
     */

    case 'EnviarEmailBia':

        $idt_atendimento = $_POST['idt_atendimento'];
        $destinatario = utf8_decode($_POST['destinatario']);
        $email = $_POST['email'];
        $html = $_POST['html'];
        $errow = EnviarEmailBia_dest($idt_atendimento, $destinatario, $email, $html);
        echo $errow;
        break;

    case 'ImprimeBia':
        $marcados = $_POST['marcados'];
        $idt_pessoa = $_POST['idt_pessoa'];
        $html = ImprimeBia($idt_pessoa, $marcados);
        echo $html;
        break;


    case 'ImprimeSenhaTOTEM':
        $senha_totem = $_POST['senha_totem'];
        $html = ImprimeSenhaTOTEM($senha_totem);
        echo $html;
        break;
    case 'SalvarPendencia':
        $idt_atendimento = $_POST['idt_atendimento'];
        $data_solucao = $_POST['data_solucao'];
        $observacao = utf8_decode($_POST['observacao']);
        $ret = SalvarPendencia($idt_atendimento, $data_solucao, $observacao);
        break;
    case 'SalvarInstrumento':
        $idt_atendimento = $_POST['idt_atendimento'];
        $idt_troca_instrumento = $_POST['idt_troca_instrumento'];
        $ret = SalvarInstrumento($idt_atendimento, $idt_troca_instrumento);
        $_SESSION[CS]['tmp']['abre_contrato_sg'][$idt_atendimento] = $_POST['contratoSG'];
        break;
    case 'SalvarTemaInteresse':
        $idt_atendimento = $_POST['idt_atendimento'];
        $idt_tema_interesse = $_POST['idt_tema_interesse'];
        $ret = SalvarTemaInteresse($idt_atendimento, $idt_tema_interesse);
        break;
    case 'SalvarTemaTratado':
        $idt_atendimento = $_POST['idt_atendimento'];
        $idt_tema_tratado = $_POST['idt_tema_tratado'];
        $idt_subtema_tratado = $_POST['idt_subtema_tratado'];
        $ret = SalvarTemaTratado($idt_atendimento, $idt_tema_tratado, $idt_subtema_tratado);
        break;


    case 'GeraEmpreendimentoAtendimento':
        $idt_atendimento = $_POST['idt_atendimento'];
        $ret = GeraEmpreendimentoAtendimento($idt_atendimento);

        //echo "vivo ";
        break;


    case 'CancelarChamada':
        $datadia = date('d/m/Y H:i');
        $data = explode(' ', $datadia);
        $dt = $data[0];
        $hora = $data[1];
        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel = Array();
        CancelarChamada($idt_atendimento_agenda, $variavel);
        break;


    case 'BuscaCPF':
        $idt_atendimento = $_POST['idt_atendimento'];
        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $cpf = FormataCPF12($_POST['cpf']);
        $idt_pf = $_POST['idt_pf'];
        $MesclarCadastro = $_POST['MesclarCadastro'];
        $variavel = Array();
        $variavel['erro'] = "";
        $variavel['cpf'] = $cpf;
        $variavel['idt_instrumento'] = $_POST['idt_instrumento'];
        $variavel['idt_atendimento_agenda'] = $_POST['idt_atendimento_agenda'];
        $variavel['idt_pf'] = $idt_pf;
        $variavel['idt_evento'] = $_POST['idt_evento'];
        $variavel['origem'] = $_POST['origem'];
        $variavel['filadeespera'] = $_POST['filadeespera'];
        $variavel['voucher_numero'] = $_POST['voucher_numero'];
        $variavel['vl_evento'] = $_POST['vl_evento'];

        if (wsPathGRC != 'wsPathGRC') {
            $variavel['bancoTransaction'] = 'N';
            $variavel['id_usuario'] = $_SESSION[CS]['g_id_usuario_sistema']['GRC'];
            $variavel['evento_origem'] = 'WEBSERVICE';
        }

        define('nan', $_POST['nan']);

        $ok = true;

        if ($_POST['idt_evento'] != '') {
            $sql = '';
            $sql .= ' select p.nome';
            $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa p';
            $sql .= ' inner join ' . db_pir_grc . 'grc_atendimento a on a.idt = p.idt_atendimento';
            $sql .= ' left outer join ' . db_pir_grc . 'grc_evento_participante ep on ep.idt_atendimento = p.idt_atendimento';
            $sql .= ' where a.idt_evento = ' . null($variavel['idt_evento']);
            $sql .= ' and p.cpf = ' . aspa($cpf);
            $sql .= ' and p.idt <> ' . null($idt_pf);
            $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
            $rs = execsql($sql);

            if ($rs->rows > 0) {
                $ok = false;
                echo 'A pessoa ' . $cpf . ' - ' . $rs->data[0][0] . ' já esta cadastrado neste evento.';
            }
        }

        if ($ok) {
            if ($_POST['troca_lider'] == 'S' && nan == 'S') {
                $sql = '';
                $sql .= ' select nome';
                $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa';
                $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
                $sql .= ' and cpf = ' . aspa($cpf);
                $rs = execsql($sql);

                if ($rs->rows == 0) {
                    $variavel['tipo_relacao'] = 'L';
                    BuscaCPF_MAIS($idt_atendimento, $variavel);

                    $sql_d = ' delete from ';
                    $sql_d .= db_pir_grc . 'grc_atendimento_pessoa ';
                    $sql_d .= ' where idt_atendimento = ' . null($idt_atendimento);
                    $sql_d .= '   and idt             <> ' . null($variavel['idt_atendimento_pessoa']);
                    $sql_d .= "   and tipo_relacao    = 'L'";
                    execsql($sql_d);

                    if ($MesclarCadastro == 'SE') {
                        echo $variavel['idt_atendimento_pessoa'];
                    } else {
                        echo $variavel['idt_atendimento_agenda'];
                    }
                } else {
                    echo 'A pessoa ' . $cpf . ' - ' . $rs->data[0][0] . ' já esta cadastrado neste registro.';
                }
            } else {
                if ($MesclarCadastro == 'S' || $MesclarCadastro == 'SE') {
                    BuscaCPF($idt_atendimento, $variavel);

                    if ($MesclarCadastro == 'SE') {
                        echo $variavel['idt_atendimento_pessoa'];
                    } else {
                        echo $variavel['idt_atendimento_agenda'];
                    }
                } else {
                    $sql = '';
                    $sql .= ' select nome';
                    $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa';
                    $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
                    $sql .= ' and cpf = ' . aspa($cpf);
                    $rs = execsql($sql);

                    if ($rs->rows == 0) {
                        BuscaCPF_MAIS($idt_atendimento, $variavel);
                        echo $variavel['idt_atendimento_pessoa'];
                    } else {
                        echo 'A pessoa ' . $cpf . ' - ' . $rs->data[0][0] . ' já esta cadastrado neste registro.';
                    }
                }
            }
        }

        if ($variavel['bancoTransaction'] == 'N') {
            $usaTransaction = false;
        } else {
            $usaTransaction = true;
        }

        if ($_POST['idt_evento'] != '' && $variavel['idt_atendimento'] != '') {
            MatriculaEventoCompostoSincroniza($_POST['idt_evento'], $variavel['idt_atendimento'], $usaTransaction);
        }
        break;

    case 'BuscaCNPJ':
        $idt_atendimento = $_POST['idt_atendimento'];
        $MesclarCadastro = $_POST['MesclarCadastro'];
        $cnpj = FormataCNPJ($_POST['cnpj']);
        $variavel = Array();
        $variavel['erro'] = "";
        $variavel['idt_tipo_empreendimento'] = $_POST['idt_tipo_empreendimento'];
        $variavel['cnpj'] = $cnpj;
        $variavel['codparceiro'] = $_POST['codparceiro'];
        $variavel['dap'] = $_POST['dap'];
        $variavel['nirf'] = $_POST['nirf'];
        $variavel['rmp'] = $_POST['rmp'];
        $variavel['ie_prod_rural'] = $_POST['ie_prod_rural'];
        $variavel['sicab_codigo'] = $_POST['sicab_codigo'];
        $variavel['razao_social'] = $_POST['razao_social'];
        $variavel['nome_fantasia'] = $_POST['nome_fantasia'];

        if (wsPathGRC != 'wsPathGRC') {
            $variavel['bancoTransaction'] = 'N';
        }

        if ($idt_atendimento == 0) {
            echo 'Sistema indisponível no momento. Saia do sistema e entre novamente, para realizar esta operação!';
        } else {
            if ($MesclarCadastro == 'SE') {
                $sql = 'delete from ' . db_pir_grc . 'grc_atendimento_organizacao';
                $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
                execsql($sql);

                BuscaCNPJ($idt_atendimento, $variavel);
                $idt_atendimento_organizacao = $variavel['idt_atendimento_organizacao'];
            } else {
                BuscaCNPJ($idt_atendimento, $variavel);

                if ($variavel['idt_atendimento_organizacao'] != 0 && $variavel['idt_atendimento_organizacao'] != $_POST['idt_atual']) {
                    $sql = 'delete from grc_atendimento_organizacao where idt = ' . null($_POST['idt_atual']);
                    execsql($sql);
                }

                $idt_atendimento_organizacao = $variavel['idt_atendimento_organizacao'];
            }

            $sql = '';
            $sql .= ' select c.idt_entidade_setor';
            $sql .= ' from ' . db_pir_gec . 'cnae c';
            $sql .= ' inner join ' . db_pir_grc . 'grc_atendimento_organizacao ao on ao.idt_cnae_principal = c.subclasse and c.codclass_siacweb = 1';
            $sql .= ' where ao.idt = ' . null($idt_atendimento_organizacao);
            $rstt = execsql($sql);

            if ($rstt->data[0][0] != '') {
                $sql = "update " . db_pir_grc . "grc_atendimento_organizacao set idt_setor = " . null($rstt->data[0][0]) . " where idt = " . null($idt_atendimento_organizacao);
                execsql($sql);
            }

            if ($variavel['codparceiro_lista'] == '') {
                echo $idt_atendimento_organizacao;
            } else {
                $cod = GerarStr();
                $_SESSION[CS]['tmp'][$cod] = $variavel['codparceiro_lista'];
                echo 'codparceiro_lista=' . $cod;
            }
        }
        break;


    case 'empreendimento_escolhido':
        $vet = Array(
            'erro' => '',
        );

        $vet['cnpj'] = '';
        $vet['razao_social'] = '';
        $vet['nome_fantasia'] = '';
        $vet['logradouro_cep_e'] = '';
        $vet['logradouro_endereco_e'] = '';
        $vet['logradouro_numero_e'] = '';
        $vet['logradouro_bairro_e'] = '';
        $vet['logradouro_complemento_e'] = '';
        $vet['logradouro_cidade_e'] = '';
        $vet['logradouro_estado_e'] = '';
        $vet['logradouro_referencia_e'] = '';
        $vet['logradouro_pais_e'] = '';
        $vet['idt_pais_e'] = '';
        $vet['idt_estado_e'] = '';
        $vet['idt_cidade_e'] = '';
        $vet['telefone_comercial_e'] = '';
        $vet['telefone_celular_e'] = '';
        $vet['email_e'] = '';
        $vet['sms_e'] = '';
        $vet['receber_informacao_e'] = '';
        $vet['codigo_siacweb_e'] = '';
        $vet['idt_organizacao'] = '';
        $vet['site_url'] = '';
        $vet['idt_porte'] = '';
        $vet['idt_tipo_empreendimento'] = '';
        $vet['data_abertura'] = '';
        $vet['pessoas_ocupadas'] = '';
        $vet['idt_setor'] = '';
        $vet['idt_cnae_principal'] = '';
        $vet['simples_nacional'] = '';
        $vet['tamanho_propriedade'] = '';
        $vet['dap'] = '';
        $vet['nirf'] = '';
        $vet['rmp'] = '';
        $vet['ie_prod_rural'] = '';

        if ($_POST['cnpj'] != 'novo') {
            try {
                beginTransaction();

                $sql = '';
                $sql .= ' select *';
                $sql .= ' from grc_atendimento_organizacao';
                $sql .= ' where cnpj = ' . aspa($_POST['cnpj']);
                $sql .= ' order by idt desc limit 1';
                $rs = execsql($sql, false);

                if ($rs->rows == 0) {
                    $vet['erro'] = rawurlencode('CNPJ não localizado!');
                } else {
                    $row = $rs->data[0];

                    $vet['cnpj'] = rawurlencode($row['cnpj']);
                    $vet['razao_social'] = rawurlencode($row['razao_social']);
                    $vet['nome_fantasia'] = rawurlencode($row['nome_fantasia']);
                    $vet['logradouro_cep_e'] = rawurlencode($row['logradouro_cep_e']);
                    $vet['logradouro_endereco_e'] = rawurlencode($row['logradouro_endereco_e']);
                    $vet['logradouro_numero_e'] = rawurlencode($row['logradouro_numero_e']);
                    $vet['logradouro_bairro_e'] = rawurlencode($row['logradouro_bairro_e']);
                    $vet['logradouro_complemento_e'] = rawurlencode($row['logradouro_complemento_e']);
                    $vet['logradouro_cidade_e'] = rawurlencode($row['logradouro_cidade_e']);
                    $vet['logradouro_estado_e'] = rawurlencode($row['logradouro_estado_e']);
                    $vet['logradouro_referencia_e'] = rawurlencode($row['logradouro_referencia_e']);
                    $vet['logradouro_pais_e'] = rawurlencode($row['logradouro_pais_e']);
                    $vet['idt_pais_e'] = rawurlencode($row['idt_pais_e']);
                    $vet['idt_estado_e'] = rawurlencode($row['idt_estado_e']);
                    $vet['idt_cidade_e'] = rawurlencode($row['idt_cidade_e']);
                    $vet['telefone_comercial_e'] = rawurlencode($row['telefone_comercial_e']);
                    $vet['telefone_celular_e'] = rawurlencode($row['telefone_celular_e']);
                    $vet['email_e'] = rawurlencode($row['email_e']);
                    $vet['sms_e'] = rawurlencode($row['sms_e']);
                    $vet['receber_informacao_e'] = rawurlencode($row['receber_informacao_e']);
                    $vet['codigo_siacweb_e'] = rawurlencode($row['codigo_siacweb_e']);
                    $vet['idt_organizacao'] = rawurlencode($row['idt_organizacao']);
                    $vet['site_url'] = rawurlencode($row['site_url']);
                    $vet['idt_porte'] = rawurlencode($row['idt_porte']);
                    $vet['idt_tipo_empreendimento'] = rawurlencode($row['idt_tipo_empreendimento']);
                    $vet['data_abertura'] = rawurlencode($row['data_abertura']);
                    $vet['pessoas_ocupadas'] = rawurlencode($row['pessoas_ocupadas']);
                    $vet['idt_setor'] = rawurlencode($row['idt_setor']);
                    $vet['idt_cnae_principal'] = rawurlencode($row['idt_cnae_principal']);
                    $vet['simples_nacional'] = rawurlencode($row['simples_nacional']);
                    $vet['tamanho_propriedade'] = rawurlencode($row['tamanho_propriedade']);
                    $vet['dap'] = rawurlencode($row['dap']);
                    $vet['nirf'] = rawurlencode($row['nirf']);
                    $vet['rmp'] = rawurlencode($row['rmp']);
                    $vet['ie_prod_rural'] = rawurlencode($row['ie_prod_rural']);

                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_atendimento_organizacao';
                    $sql .= ' where idt_atendimento = ' . null($_POST['idt']);
                    $rs = execsql($sql, false);
                    $idt_atendimento_organizacao = $rs->data[0][0];

                    $sql = 'delete from grc_atendimento_organizacao_cnae where idt_atendimento_organizacao = ' . null($idt_atendimento_organizacao);
                    execsql($sql, false);

                    foreach ($vetCNAE as $cnae) {
                        $sql = 'insert into grc_atendimento_organizacao_cnae (idt_atendimento_organizacao, cnae) values (';
                        $sql .= null($idt_atendimento_organizacao) . ', ' . aspa($cnae) . ')';
                        execsql($sql, false);
                    }

                    commit();
                }
            } catch (Exception $e) {
                rollBack();

                $msg = $e->getMessage();
                $vet['erro'] = rawurlencode($msg);
            }
        }

        echo json_encode($vet);
        break;

    case 'subtema_tratado':
        $sql = '';
        $sql .= ' select codigo';
        $sql .= ' from grc_tema_subtema';
        $sql .= ' where idt = ' . null($_GET['val']);
        $rs = execsql($sql);
        $codigo_tema = $rs->data[0][0];

        $sql = "select grc_ts.idt,  grc_ts.descricao from grc_tema_subtema grc_ts ";
        $sql .= " where grc_ts.nivel  =  1 ";
        $sql .= "   and substring(grc_ts.codigo,1,3) =  " . aspa($codigo_tema . '.');
        $sql .= "   and ativo = 'S'";
        $sql .= " order by  grc_ts.descricao";

        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'GravaProdutoInteresseMulti':
        $vet = Array(
            'erro' => '',
        );

        try {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_final'];

            beginTransaction();

            foreach ($vetSel as $idx => $dados) {
                if ($dados['idt'] != '') {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_atendimento_produto';
                    $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
                    $sql .= ' and idt_produto = ' . null($dados['idt']);
                    $rs = execsql($sql, false);

                    if ($rs->rows == 0) {
                        $sql = 'insert into grc_atendimento_produto (idt_atendimento, idt_produto) values (';
                        $sql .= null($_POST['idt_atendimento']) . ', ' . null($dados['idt']) . ')';
                        execsql($sql, false);
                    }
                }
            }

            commit();

            $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_final'] = Array();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;


    case 'DetalharHistorico':
        $CodCliente = $_POST['CodCliente'];
        $CPFCliente = $_POST['CPFCliente'];
        $CNPJ = $_POST['CNPJ'];
        $DataHoraInicioRealizacao = $_POST['DataHoraInicioRealizacao'];
        $linha = $_POST['linha'];
        $opcao = $_POST['opcao'];
        //
        $html = "";
        $ret = DetalharHistorico($CodCliente, $CPFCliente, $DataHoraInicioRealizacao, $linha, $opcao, $CNPJ, $html);
        echo $html;
        break;


    case 'btClickExcDireta':
        $vet = Array(
            'erro' => '',
        );

        try {
            beginTransaction();

            $sql = 'delete from ' . $_POST['tabela'] . ' where ' . $_POST['idt_campo'] . ' = ' . null($_POST['idt_valor']);
            execsql($sql, false);

            commit();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'btClickPendenciaAtivo':
        $vet = Array(
            'erro' => '',
        );

        try {
            beginTransaction();

            $sql = '';
            $sql .= ' select ativo';
            $sql .= ' from ' . $_POST['tabela'];
            $sql .= ' where ' . $_POST['idt_campo'] . ' = ' . null($_POST['idt_valor']);
            $rs = execsql($sql, false);

            if ($rs->data[0][0] == 'S') {
                $ativo = 'N';
            } else {
                $ativo = 'S';
            }

            $sql = 'update ' . $_POST['tabela'] . ' set ativo = ' . aspa($ativo) . ' where ' . $_POST['idt_campo'] . ' = ' . null($_POST['idt_valor']);
            execsql($sql, false);

            commit();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_atendimento_cadastro_dep':
        $vet = Array(
            'erro' => '',
            'idt_atendimento_organizacao' => '',
        );

        try {
            if ($_POST['representa_empresa'] == 'S') {
                $sql = '';
                $sql .= ' select *';
                $sql .= ' from grc_atendimento_organizacao';
                $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
                $sql .= " and representa = 'S'";
                $sql .= " and desvincular = 'N'";
                $rs = execsql($sql, false);

                if ($rs->rows == 0) {
                    $vet['erro'] = rawurlencode('Favor informar um Empreendimento vinculado a este atendimento!');
                }
            }

            if ($vet['erro'] == '') {
                $vetCadOrg = conVetCad('cadastro_conf/grc_atendimento_organizacao.php');

                $sql = '';
                $sql .= ' select *';
                $sql .= ' from grc_atendimento_organizacao';
                $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
                $sql .= " and (";
                $sql .= " representa = 'S'";
                $sql .= " or modificado = 'S'";
                $sql .= ' )';
                $rs = execsql($sql, false);

                $msgErro = 'Favor informar os dados obrigatorios do Empreendimento!';
                $ok = true;

                foreach ($rs->data as $row) {
                    if ($ok) {
                        ForEach ($vetCadOrg as $idxGrd => $vetGrd) {
                            ForEach ($vetGrd as $idxFrm => $vetFrm) {
                                if (is_array($vetFrm['dados'])) {
                                    ForEach ($vetFrm['dados'] as $nLinha => $Linha) {
                                        ForEach ($Linha as $Coluna) {
                                            if (is_array($Coluna)) {
                                                if ($Coluna['valida']) {
                                                    if ($row[$Coluna['campo']] == '') {
                                                        $ok = false;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if ($ok) {
                            $erro = Array();

                            //Data de Abertura
                            $diff = diffDate(trata_data($row['data_abertura']), getdata(false, true));
                            $vetDT = DatetoArray(trata_data($row['data_abertura']));

                            if ($diff < 0 || $vetDT['ano'] > Date('Y')) {
                                $erro[] = "A Data Abertura tem que ser menor ou igual a hoje!";
                            }

                            //Valida CEP
                            $sql = '';
                            $sql .= ' select *';
                            $sql .= ' from ' . db_pir_gec . 'base_cep';
                            $sql .= ' where cep = ' . null(preg_replace('/[^0-9]/i', '', $row['logradouro_cep_e']));
                            $sql .= ' and cep_situacao = 1';
                            $rst = execsql($sql, false);

                            if ($rst->rows == 0) {
                                $erro[] = 'O CEP ' . $row['logradouro_cep_e'] . ' não foi localizado no SiacWeb ou esta inativo!';
                            } else {
                                $row_cep = $rst->data[0];

                                if ($row['logradouro_codbairro_e'] != $row_cep['codbairro']) {
                                    $erro[] = "O bairro informado não corresponde com o do SiacWeb informado neste CEP!";
                                }

                                if ($row['logradouro_codcid_e'] != $row_cep['codcid']) {
                                    $erro[] = "A cidade informado não corresponde com o do SiacWeb informado neste CEP!";
                                }

                                if ($row['logradouro_codest_e'] != $row_cep['codest']) {
                                    $erro[] = "O estado informado não corresponde com o do SiacWeb informado neste CEP!";
                                }

                                if ($row['logradouro_codpais_e'] != $row_cep['codpais']) {
                                    $erro[] = "O país informado não corresponde com o do SiacWeb informado neste CEP!";
                                }
                            }

                            //Verifica se o Porte / Faixa Faturamento é compativel com o Tipo de Empreendimento
                            $sql = '';
                            $sql .= ' select codigo';
                            $sql .= ' from ' . db_pir_gec . 'gec_organizacao_porte';
                            $sql .= ' where idt = ' . null($row['idt_porte']);
                            $rst = execsql($sql, false);
                            $CodPorte = $rst->data[0][0];

                            $sql = '';
                            $sql .= ' select codigo';
                            $sql .= ' from ' . db_pir_gec . 'gec_entidade_tipo_emp';
                            $sql .= ' where idt = ' . null($row['idt_tipo_empreendimento']);
                            $rst = execsql($sql, false);
                            $CodConst = $rst->data[0][0];

                            $sql = '';
                            $sql .= ' select codrel';
                            $sql .= ' from ' . db_pir_siac . 'relporteconstjur';
                            $sql .= ' where codconst = ' . null($CodConst);
                            $sql .= ' and codporte = ' . null($CodPorte);
                            $sql .= " and situacao = 'A'";
                            $rst = execsql($sql, false);

                            if ($rst->rows == 0) {
                                $erro[] = 'O Porte / Faixa Faturamento é incompatível com o Tipo de Empreendimento informado!';
                            }

                            if ($row['idt_tipo_empreendimento'] == 6) {
                                $erro[] = 'Não é possível realizar atendimento a esse Tipo de Empreendimento';
                            }

                            if (count($erro) > 0) {
                                $ok = false;
                                $msgErro = implode("\n", $erro);
                            }
                        }

                        if (!$ok) {
                            $vet['idt_atendimento_organizacao'] = $row['idt'];
                            $vet['erro'] = rawurlencode($msgErro);
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_atendimento_organizacao_td_click':
        $vet = Array(
            'erro' => '',
            'representa' => 'N',
            'desvincular' => 'N',
        );

        try {
            beginTransaction();

            $sql = '';
            $sql .= ' select representa, desvincular, idt_atendimento';
            $sql .= ' from grc_atendimento_organizacao';
            $sql .= ' where idt = ' . null($_POST['idt']);
            $rs = execsql($sql, false);
            $representa = $rs->data[0]['representa'];
            $desvincular = $rs->data[0]['desvincular'];
            $idt_atendimento = $rs->data[0]['idt_atendimento'];

            if ($_POST['campo'] == 'desvincular') {
                if ($desvincular == 'S') {
                    $sql = "update grc_atendimento_organizacao set desvincular = 'N' where idt = " . null($_POST['idt']);
                    execsql($sql, false);
                } else {
                    /*
                      if ($representa == 'S') {
                      $sql = '';
                      $sql .= ' select idt';
                      $sql .= ' from grc_atendimento_organizacao';
                      $sql .= ' where idt_atendimento = '.null($idt_atendimento);
                      $sql .= ' and idt <> '.null($_POST['idt']);
                      $sql .= " and desvincular = 'N'";
                      $rs = execsql($sql, false);

                      if ($rs->rows == 0) {
                      $vet['erro'] = rawurlencode('Não pode desvincular este empreendimento, pois só tem ele registrado!');
                      }
                      }

                      if ($vet['erro'] == '') {
                     * 
                     */
                    $vet['desvincular'] = 'S';

                    $sql = "update grc_atendimento_organizacao set representa = 'N', desvincular = 'S' where idt = " . null($_POST['idt']);
                    execsql($sql, false);

                    if ($representa == 'S') {
                        $sql = '';
                        $sql .= ' select idt';
                        $sql .= ' from grc_atendimento_organizacao';
                        $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
                        $sql .= " and desvincular = 'N'";
                        $sql .= ' order by cnpj';
                        $sql .= ' limit 1';
                        $rs = execsql($sql, false);

                        $sql = "update grc_atendimento_organizacao set representa = 'S' where idt = " . null($rs->data[0][0]);
                        execsql($sql, false);
                    }
                    //}
                }
            } else {
                if ($representa == 'S') {
                    //Não faz nada...
                } else if ($desvincular == 'S') {
                    $vet['erro'] = rawurlencode('Não pode colocar este empreendimento como representante, pois ela esta desvinculada!');
                } else {
                    $vet['representa'] = 'S';

                    $sql = "update grc_atendimento_organizacao set representa = 'N' where idt_atendimento = " . null($idt_atendimento);
                    execsql($sql, false);

                    $sql = "update grc_atendimento_organizacao set representa = 'S' where idt = " . null($_POST['idt']);
                    execsql($sql, false);
                }
            }

            commit();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_atendimento_cadastro_representa_empresa_n':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = "update grc_atendimento_organizacao set representa = 'N', modificado = 'N' where idt_atendimento = " . null($_POST['idt_atendimento']);
            execsql($sql, false);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_atendimento_cadastro_representa_empresa_s':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento_organizacao';
            $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
            $sql .= " and representa = 'S'";
            $sql .= " and desvincular = 'N'";
            $rs = execsql($sql, false);

            if ($rs->rows == 0) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_atendimento_organizacao';
                $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
                $sql .= " and desvincular = 'N'";
                $sql .= ' order by cnpj';
                $sql .= ' limit 1';
                $rs = execsql($sql, false);

                $sql = "update grc_atendimento_organizacao set representa = 'S' where idt = " . null($rs->data[0][0]);
                execsql($sql, false);
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'inicializaRelogio':
        $vet = Array(
            'erro' => '',
            'data' => '',
            'hora_inicio_atendimento' => '',
            'hora_termino_atendimento' => '',
        );

        try {
            $sql = '';
            $sql .= " select data, hora_inicio_atendimento";
            $sql .= ' from grc_atendimento';
            $sql .= ' where idt = ' . null($_POST['idt_atendimento']);
            $rs = execsql($sql, false);
            $row = $rs->data[0];

            $vet['data'] = trata_data($row['data']);
            $vet['hora_inicio_atendimento'] = $row['hora_inicio_atendimento'];
            $vet['hora_termino_atendimento'] = date('H:i');

            $sql = "update grc_atendimento set hora_termino_atendimento = " . aspa($vet['hora_termino_atendimento']) . " where idt = " . null($_POST['idt_atendimento']);
            execsql($sql, false);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_atendimento_organizacao_fecha_ant':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = "delete from grc_atendimento_organizacao where idt_atendimento = " . null($_SESSION[CS]['objListarConf_vetID'][$_POST['session_cod']]['grc_atendimento']);
            $sql .= " and novo_registro = 'S'";
            execsql($sql, false);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'validacaoDadosPessoa':
        $erro = Array();
        $vet = Array(
            'erro' => '',
            'erro_cep' => 'N',
            'siacweb_situacao' => '',
        );

        try {
            $row = array();
            parse_str($_POST['form'], $row);
            $row = array_map('utf8_decode', $row);
            $row = array_map('trim', $row);

            $rowSIAC = situacaoParceiroSiacWeb('F', $row['cpf']);

            if ($rowSIAC['siacweb_situacao'] !== '') {
                $vet['siacweb_situacao'] = $rowSIAC['siacweb_situacao'];
            }

            //Complemento
            if (strlen($row['logradouro_complemento']) > 70) {
                $erro[] = "O Complemento do Endereço excedeu o limite de tamanho de 70 caracteres!";
            }

            if (!valida_telefone($row['telefone_residencial'])) {
                $erro[] = 'O Telefone Residencial está inválido. Formato: (12)34567-8901 ou DDD errado!';
            }

            if (!valida_telefone($row['telefone_celular'])) {
                $erro[] = 'O Celular está inválido. Formato: (12)34567-8901 ou DDD errado!';
            }

            if (!valida_telefone($row['telefone_recado'])) {
                $erro[] = 'O Telefone Recado está inválido. Formato: (12)34567-8901 ou DDD errado!';
            }

            //Valida CEP
            $sql = '';
            $sql .= ' select *';
            $sql .= ' from ' . db_pir_gec . 'base_cep';
            $sql .= ' where cep = ' . null(preg_replace('/[^0-9]/i', '', $row['logradouro_cep']));
            $sql .= ' and cep_situacao = 1';
            $rs = execsql($sql, false);

            if ($rs->rows == 0) {
                $vet['erro'] = rawurlencode('O CEP ' . $row['logradouro_cep'] . ' não foi localizado no SiacWeb ou esta inativo!');
                $vet['erro_cep'] = 'S';
            } else {
                $row_cep = $rs->data[0];

                if ($row['logradouro_codbairro'] != $row_cep['codbairro']) {
                    $erro[] = "O bairro informado não corresponde com o do SiacWeb informado neste CEP!";
                }

                if ($row['logradouro_codcid'] != $row_cep['codcid']) {
                    $erro[] = "A cidade informado não corresponde com o do SiacWeb informado neste CEP!";
                }

                if ($row['logradouro_codest'] != $row_cep['codest']) {
                    $erro[] = "O estado informado não corresponde com o do SiacWeb informado neste CEP!";
                }

                if ($row['logradouro_codpais'] != $row_cep['codpais']) {
                    $erro[] = "O país informado não corresponde com o do SiacWeb informado neste CEP!";
                }

                if (count($erro) > 0) {
                    $vet['erro'] = rawurlencode(implode("\n", $erro));
                    $vet['erro_cep'] = 'S';
                }
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'validacaoDadosOrganizacao':
        $erro = Array();
        $vet = Array(
            'erro' => '',
            'erro_cep' => 'N',
            'siacweb_situacao' => '',
            'data_fim_atividade' => '',
        );

        try {
            $row = array();
            parse_str($_POST['form'], $row);
            $row = array_map('utf8_decode', $row);
            $row = array_map('trim', $row);

            $rowSIAC = situacaoParceiroSiacWeb('J', $row['cnpj'], $row['nirf'], $row['dap'], $row['rmp'], $row['ie_prod_rural'], $row['sicab_codigo']);

            if ($rowSIAC['siacweb_situacao'] !== '') {
                $vet['siacweb_situacao'] = $rowSIAC['siacweb_situacao'];
                $vet['data_fim_atividade'] = trata_data($rowSIAC['data_fim_atividade']);
            }

            //Nome Fantasia
            if (strlen($row['nome_fantasia']) > 80) {
                $erro[] = "O Nome Fantasia excedeu o limite de tamanho de 80 caracteres!";
            }

            //Complemento
            if (strlen($row['logradouro_complemento_e']) > 70) {
                $erro[] = "O Complemento do Endereço excedeu o limite de tamanho de 70 caracteres!";
            }

            //Data de Abertura
            $diff = diffDate(trata_data($row['data_abertura']), getdata(false, true));
            $vetDT = DatetoArray(trata_data($row['data_abertura']));

            if ($diff < 0 || $vetDT['ano'] > Date('Y')) {
                $erro[] = "A Data Abertura tem que ser menor ou igual a hoje!";
            }

            if (!valida_telefone($row['telefone_comercial_e'])) {
                $erro[] = 'O Telefone Comercial está inválido. Formato: (12)34567-8901 ou DDD errado!';
            }

            if (!valida_telefone($row['telefone_celular_e'])) {
                $erro[] = 'O Telefone Celular (PJ) está inválido. Formato: (12)34567-8901 ou DDD errado!';
            }

            //Valida CEP
            $sql = '';
            $sql .= ' select *';
            $sql .= ' from ' . db_pir_gec . 'base_cep';
            $sql .= ' where cep = ' . null(preg_replace('/[^0-9]/i', '', $row['logradouro_cep_e']));
            $sql .= ' and cep_situacao = 1';
            $rs = execsql($sql, false);

            if ($rs->rows == 0) {
                $erro[] = 'O CEP ' . $row['logradouro_cep_e'] . ' não foi localizado no SiacWeb ou esta inativo!';
                $vet['erro_cep'] = 'S';
            } else {
                $row_cep = $rs->data[0];

                if ($row['logradouro_codbairro_e'] != $row_cep['codbairro']) {
                    $erro[] = "O bairro informado não corresponde com o do SiacWeb informado neste CEP!";
                    $vet['erro_cep'] = 'S';
                }

                if ($row['logradouro_codcid_e'] != $row_cep['codcid']) {
                    $erro[] = "A cidade informado não corresponde com o do SiacWeb informado neste CEP!";
                    $vet['erro_cep'] = 'S';
                }

                if ($row['logradouro_codest_e'] != $row_cep['codest']) {
                    $erro[] = "O estado informado não corresponde com o do SiacWeb informado neste CEP!";
                    $vet['erro_cep'] = 'S';
                }

                if ($row['logradouro_codpais_e'] != $row_cep['codpais']) {
                    $erro[] = "O país informado não corresponde com o do SiacWeb informado neste CEP!";
                    $vet['erro_cep'] = 'S';
                }
            }

            //Verifica se o Porte / Faixa Faturamento é compativel com o Tipo de Empreendimento
            $sql = '';
            $sql .= ' select codigo';
            $sql .= ' from ' . db_pir_gec . 'gec_organizacao_porte';
            $sql .= ' where idt = ' . null($row['idt_porte']);
            $rs = execsql($sql, false);
            $CodPorte = $rs->data[0][0];

            $sql = '';
            $sql .= ' select codigo';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade_tipo_emp';
            $sql .= ' where idt = ' . null($row['idt_tipo_empreendimento']);
            $rs = execsql($sql, false);
            $CodConst = $rs->data[0][0];

            $sql = '';
            $sql .= ' select codrel';
            $sql .= ' from ' . db_pir_siac . 'relporteconstjur';
            $sql .= ' where codconst = ' . null($CodConst);
            $sql .= ' and codporte = ' . null($CodPorte);
            $sql .= " and situacao = 'A'";
            $rs = execsql($sql, false);

            if ($rs->rows == 0) {
                $erro[] = 'O Porte / Faixa Faturamento é incompatível com o Tipo de Empreendimento informado!';
            }

            if ($CodPorte == 99) {
                $sql = '';
                $sql .= ' select numminfunc, nummaxfunc';
                $sql .= ' from ' . db_pir_siac . 'porte';
                $sql .= ' where codporte = ' . null($CodPorte);
                $rs = execsql($sql, false);
                $rowt = $rs->data[0];

                if (!($row['pessoas_ocupadas'] >= $rowt['numminfunc'] && $row['pessoas_ocupadas'] <= $rowt['nummaxfunc'])) {
                    $erro[] = 'Para o porte MEI o número de pessoas ocupadas deverá estar entre ' . $rowt['numminfunc'] . ' e ' . $rowt['nummaxfunc'] . '!';
                }
            }

            //OUTRAS ORGANIZAÇÕES PRIVADAS SEM FINS LUCRATIVOS
            if ($row['idt_tipo_empreendimento'] == 6) {
                $erro[] = 'Não é possível realizar atendimento a esse Tipo de Empreendimento!';
            }

            //Produtor Rural
            if ($row['idt_tipo_empreendimento'] == 7) {
                $tmp = substr($row['idt_cnae_principal'], 0, 2);

                if ($tmp != '01' && $tmp != '02' && $tmp != '03') {
                    $erro[] = 'Atividade econômica inválida para o tipo de empreendimento "Produtor Rural".';
                }

                if ($row['idt_porte'] == 5) {
                    $erro[] = 'O Porte / Faixa Faturamento selecionado não é possível para Produtor Rural!';
                }
            }

            if (!ValidaNirf($row['nirf'])) {
                $erro[] = 'O Nirf informado é inválido!';
            }

            if ($row['dap'] != '') {
                try {
                    $conSIAC = new_pdo(siacweb_host, siacweb_bd_user, siacweb_password, siacweb_tipodb, false);

                    $sql = 'select description from [dbo].[FN_ValidaDAP] (' . aspa(mb_strtoupper($row['dap'])) . ')';
                    $rs = execsql($sql, false, $conSIAC);
                    $msgDAP = $rs->data[0][0];

                    if ($msgDAP != '') {
                        $erro[] = $msgDAP;
                    }
                } catch (PDOException $e) {
                    grava_erro_log(siacweb_tipodb, $e, $sql);
                } catch (Exception $e) {
                    grava_erro_log('php', $e, '');
                }
            }

            if (!ValidaSICAB($row['sicab_codigo'])) {
                $erro[] = 'O SICAB informado é inválido!';
            }

            if (count($erro) > 0) {
                $vet['erro'] = rawurlencode(implode("\n", $erro));
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;




    case 'SolicitarAprovarEvento_old':
        $erro = Array();
        $vet = Array(
            'erro' => '',
        );

        try {
            $vet['idt_instrumento'] = $_POST['idt_instrumento'];
            $vet['idt_evento'] = $_POST['idt_evento'];
            //$vet['idt_produto']     = $_POST['idt_produto'];
            SolicitarAprovarEvento($vet);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }
        echo json_encode($vet);
        break;







    case 'acao_dados':
        $vet = Array(
            'erro' => '',
            'qtd_previsto' => '',
            'qtd_realizado' => '',
            'qtd_percentual' => '',
            'qtd_saldo' => '',
            'orc_previsto' => '',
            'orc_realizado' => '',
            'orc_percentual' => '',
            'orc_saldo' => '',
            'gestor_sge' => '',
            'idt_gestor_projeto' => '',
            'idt_unidade' => '',
            'contrapartida_sgtec' => '',
        );

        try {
            PreparaAcaoEvento($vet);
            $vet = array_map('rawurlencode', $vet);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }
        echo json_encode($vet);
        break;

    case 'produto_dados':
        $vet = Array(
            'erro' => '',
            'idt_foco_tematico' => '',
            'idt_foco_tematico_tf' => '',
            'maturidade' => '',
            'descricao' => '',
            'bloquear_descricao' => 'N',
            'carga_horaria_total' => '',
            'carga_horaria_total_ini' => '',
            'carga_horaria_total_fim' => '',
            'carga_horaria_total_lbl' => 'Carga Horária: <span class="asterisco">*</span>',
            'quantidade_participante' => '',
            'quantidade_participante_lbl' => 'Qtde. Participantes: <span class="asterisco">*</span>',
            'frequencia_min' => '',
            'qtd_minima_pagantes' => '',
            'qtd_dias_reservados' => '',
            'idt_publico_alvo' => '',
            'valor_hora' => '0,00',
            'cred_necessita_credenciado' => 'N',
            'idt_programa' => '',
            'entrega_prazo_max' => '',
            'vl_determinado' => '',
            'vl_determinado_tf' => '',
            'conteudo_programatico' => '',
            'descricao_comercial' => '',
        );


        try {
            beginTransaction();

            $sql = '';
            $sql .= ' select e.idt_produto, grc_p.idt_produto_especie';
            $sql .= ' from grc_evento e';
            $sql .= ' left outer join grc_produto grc_p on grc_p.idt = e.idt_produto';
            $sql .= ' where e.idt = ' . null($_POST['idt_evento']);
            $rs = execsql($sql, false);
            $rowPrdAnt = $rs->data[0];

            PreparaProdutoEvento($vet);

            $sql = '';
            $sql .= ' select e.idt_produto, grc_p.idt_produto_especie';
            $sql .= ' from grc_evento e';
            $sql .= ' left outer join grc_produto grc_p on grc_p.idt = e.idt_produto';
            $sql .= ' where e.idt = ' . null($_POST['idt_evento']);
            $rs = execsql($sql, false);
            $rowPrdAtu = $rs->data[0];

            if ($rowPrdAnt['idt_produto_especie'] == 3 && $rowPrdAnt['idt_produto'] != $rowPrdAtu['idt_produto']) {
                EventoCompostoDeleta($_POST['idt_evento'], false);
            }

            if ($rowPrdAtu['idt_produto_especie'] == 3 && $rowPrdAnt['idt_produto'] != $rowPrdAtu['idt_produto']) {
                EventoCompostoCria($_POST['idt_evento'], false);
            }

            //Copia a Galeria do Produto
            $arqCopia = Array();
            $arqDel = Array();
            $path_de = 'obj_file/grc_produto_galeria/';
            $path_para = 'obj_file/grc_evento_galeria/';

            $sql = '';
            $sql .= ' select arquivo';
            $sql .= ' from grc_evento_galeria';
            $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);
            $sql .= ' and arquivo is not null';
            $sql .= " and reg_produto = 'S'";
            $rs = execsql($sql, false);

            ForEach ($rs->data as $row) {
                $arqDel[] = str_replace('/', DIRECTORY_SEPARATOR, $path_para . $row['arquivo']);
            }

            $sql = '';
            $sql .= ' delete';
            $sql .= ' from grc_evento_galeria';
            $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);
            $sql .= " and reg_produto = 'S'";
            execsql($sql, false);

            $sql = '';
            $sql .= ' select *';
            $sql .= ' from grc_produto_galeria';
            $sql .= ' where idt_produto = ' . null($rowPrdAtu['idt_produto']);
            $rs = execsql($sql, false);

            ForEach ($rs->data as $row) {
                if ($row['arquivo'] == '') {
                    $arq_novo = '';
                } else {
                    $vetPrefixoArq = explode('_', $row['arquivo']);
                    $PrefixoArq = '';
                    $PrefixoArq .= $vetPrefixoArq[0] . '_';
                    $PrefixoArq .= $vetPrefixoArq[1] . '_';
                    $PrefixoArq .= $vetPrefixoArq[2] . '_';

                    $arq_novo = GerarStr() . '_arquivo_' . substr(time(), -3) . '_' . substr($row['arquivo'], strlen($PrefixoArq));

                    $arqCopia[] = Array(
                        'de' => str_replace('/', DIRECTORY_SEPARATOR, $path_de . $row['arquivo']),
                        'para' => str_replace('/', DIRECTORY_SEPARATOR, $path_para . $arq_novo),
                    );
                }

                $sql = ' insert into grc_evento_galeria (';
                $sql .= ' idt_evento, idt_tipo_galeria, descricao, detalhe, link, arquivo, reg_produto';
                $sql .= ') values (';
                $sql .= null($_POST['idt_evento']) . ', ' . null($row['idt_tipo_galeria']) . ', ' . aspa($row['descricao']) . ', ';
                $sql .= aspa($row['detalhe']) . ', ' . aspa($row['link']) . ', ' . aspa($arq_novo) . ", 'S'";
                $sql .= ')';
                execsql($sql, false);
            }

            commit();

            foreach ($arqDel as $arq) {
                if (is_file($arq)) {
                    unlink($arq);
                }
            }

            foreach ($arqCopia as $arq) {
                if (is_file($arq['de'])) {
                    copy($arq['de'], $arq['para']);
                }
            }

            $vet = array_map('rawurlencode', $vet);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'SituacaoEvento':
        $vet = Array(
            'erro' => '',
            'msg' => rawurlencode('Confirma a solicitação do envio deste evento para APROVAÇÃO?'),
        );

        try {
            $situacao = $_POST['situacao'];
            $idt_evento = $_POST['idt_evento'];

            if ($_POST['idt_programa'] == '') {
                $sql = '';
                $sql .= ' select idt_programa';
                $sql .= ' from grc_produto p';
                $sql .= ' where idt = ' . null($_POST['idt_produto']);
                $rs = execsql($sql);
                $_POST['idt_programa'] = $rs->data[0][0];
            }

            $sql = '';
            $sql .= ' select tipo_ordem';
            $sql .= ' from ' . db_pir_gec . 'gec_programa';
            $sql .= ' where idt = ' . null($_POST['idt_programa']);
            $rs = execsql($sql, false);
            $tipo_ordem = $rs->data[0][0];

            if ($situacao == 6 || $situacao == 24) {
                //Valida Aprovador do Evento
                if ($vet['erro'] == '') {
                    $erro = Array();

                    if ($_POST['idt_ponto_atendimento_tela'] == '') {
                        $idt_ponto_atendimento = $_POST['idt_unidade'];
                    } else {
                        $idt_ponto_atendimento = $_POST['idt_ponto_atendimento_tela'];
                    }

                    $sql = "select s.classificacao";
                    $sql .= ' from ' . db_pir . 'sca_organizacao_secao s';
                    $sql .= " where s.idt  = " . null($_POST['idt_unidade']);
                    $rs = execsql($sql, false);
                    $classificacao_unidade = $rs->data[0][0];

                    $situacao_dest = decideAprovadorInicialEvento($_POST['idt_instrumento'], $_POST['idt_programa'], trata_data($_POST['dt_previsao_inicial']), $_POST['idt_gestor_projeto'], $_POST['idt_responsavel'], $_POST['idt_unidade'], $idt_ponto_atendimento, $classificacao_unidade, $_POST['previsao_despesa'], $rs_pendencia, $temCG, $temDI, false);

                    if ($situacao_dest == 14) {
                        $vet['msg'] = rawurlencode("Este Evento não precisa mais de aprovação!\n\nDeseja APROVAR O EVENTO agora?");
                    }

                    if ($_POST['idt_gestor_projeto'] == '') {
                        $erro[] = 'Não tem o aprovador  com o perfil Gestor do Projeto (SGE)!';
                    }

                    if (!$temCG) {
                        $erro[] = 'Não tem o aprovador com o perfil Coordenador / Gerente!';
                    }

                    if (!$temDI) {
                        $erro[] = 'Não tem o aprovador  com o perfil Diretor!';
                    }

                    if (count($erro) > 0) {
                        $vet['erro'] = rawurlencode("Inconsistência para aprovação do evento.\n\n" . implode("\n", $erro));
                    }
                }

                if ($idt_evento > 0) {
                    $sql = '';
                    $sql .= ' select nao_sincroniza_rm, sgtec_modelo, vl_determinado, contrapartida_sgtec, idt_produto';
                    $sql .= ' from grc_evento';
                    $sql .= ' where idt = ' . null($idt_evento);
                    $rs = execsql($sql, false);
                    $rowe = $rs->data[0];

                    //Verifica se a cotação foi finalizada
                    if ($vet['erro'] == '') {
                        if ($tipo_ordem == 'SG' && $rowe['sgtec_modelo'] == 'E' && $rowe['vl_determinado'] == 'N' && $situacao == 6) {
                            $sql = '';
                            $sql .= ' select gec_ord.idt_gec_contratacao_status, gec_ol.idt_organizacao';
                            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem gec_ord';
                            $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista gec_ol on gec_ord.idt = gec_ol.idt_gec_contratacao_credenciado_ordem";
                            $sql .= " left outer join " . db_pir_gec . "gec_entidade gec_o on gec_ol.idt_organizacao = gec_o.idt";
                            $sql .= ' where gec_ord.idt_evento = ' . null($idt_evento);
                            $sql .= " and gec_ord.ativo = 'S'";
                            $sql .= " and gec_ol.ativo = 'S'";
                            $rsi = execsql($sql, false);
                            $rowi = $rsi->data[0];

                            if ($rsi->rows == 0) {
                                $vet['erro'] = rawurlencode('Não tem o registro do indicado na ordem de contratação (Credenciado)!');
                            } else if ($rsi->rows > 1) {
                                $vet['erro'] = rawurlencode('O evento tem mais de uma ordem ativa! Só pode ter uma.');
                            } else if ($rowi['idt_gec_contratacao_status'] != 9) {
                                $vet['erro'] = rawurlencode('A cotação da ordem de contratação (Credenciado) não foi concluida!');
                            } else if ($rowi['idt_organizacao'] == '') {
                                $vet['erro'] = rawurlencode('Tem que informar a Organização do Indicado na ordem de contratação (Credenciado)!');
                            }
                        }
                    }

                    //Valida se o cadastro esta completo das matriculas
                    if ($vet['erro'] == '') {
                        $sql = '';
                        $sql .= ' select a.idt, a.protocolo, ep.idt_midia, ep.contrato, ao.representa_codcargcli, ao.idt as idt_atendimento_organizacao';
                        $sql .= ' from grc_atendimento a';
                        $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
                        $sql .= ' left outer join grc_atendimento_organizacao ao on ao.idt_atendimento = a.idt';
                        $sql .= ' where a.idt_evento = ' . null($idt_evento);
                        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                        $sql .= whereEventoParticipante();
                        $rsa = execsql($sql, false);

                        $erro = Array();

                        foreach ($rsa->data as $rowa) {
                            if ($rowa['idt_midia'] == '' || ($rowa['representa_codcargcli'] == '' && $rowa['idt_atendimento_organizacao'] != '')) {
                                $erro[$rowa['protocolo']] = 'Favor complementar os dados do protocolo ' . $rowa['protocolo'] . '!';
                            }
                        }

                        if ($_POST['idt_instrumento'] == 2 && $rsa->rows == 0) {
                            $erro[] = 'Favor informar inserir Participantes!';
                        }

                        if (count($erro) > 0) {
                            $vet['erro'] = rawurlencode(implode("\n", $erro));
                        }
                    }

                    //Validações do SGTEC
                    if ($vet['erro'] == '') {
                        if ($tipo_ordem == 'SG') {
                            if ($rowe['sgtec_modelo'] == 'H') {
                                $sql = '';
                                $sql .= ' select gec_ord.idt_gec_contratacao_status, gec_ol.idt_organizacao';
                                $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem gec_ord';
                                $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista gec_ol on gec_ord.idt = gec_ol.idt_gec_contratacao_credenciado_ordem";
                                $sql .= " left outer join " . db_pir_gec . "gec_entidade gec_o on gec_ol.idt_organizacao = gec_o.idt";
                                $sql .= ' where gec_ord.idt_evento = ' . null($idt_evento);
                                $sql .= " and gec_ord.ativo = 'S'";
                                $sql .= " and gec_ol.ativo = 'S'";
                                $rsi = execsql($sql, false);
                                $rowi = $rsi->data[0];

                                if ($rsi->rows == 0) {
                                    $vet['erro'] = rawurlencode('Não tem o registro do indicado na ordem de contratação (Credenciado)!');
                                } else if ($rsi->rows > 1) {
                                    $vet['erro'] = rawurlencode('O evento tem mais de uma ordem ativa! Só pode ter uma.');
                                } else if ($rowi['idt_gec_contratacao_status'] != 9) {
                                    $vet['erro'] = rawurlencode('A ordem de contratação (Credenciado) não foi concluida!');
                                } else if ($rowi['idt_organizacao'] == '') {
                                    $vet['erro'] = rawurlencode('Tem que informar a Organização do Indicado na ordem de contratação (Credenciado)!');
                                }
                            }


                            if ($vet['erro'] == '') {
                                atualizaPagEventoSG($idt_evento, false);

                                $sql = '';
                                $sql .= ' select a.idt, a.protocolo, ep.vl_tot_pagamento';
                                $sql .= ' from grc_atendimento a';
                                $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
                                $sql .= ' where a.idt_evento = ' . null($idt_evento);
                                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                                $sql .= whereEventoParticipante();
                                $rsa = execsql($sql, false);

                                if ($rsa->rows == 0) {
                                    $vet['erro'] = rawurlencode('Favor informar os Clientes Atendidos!');
                                } else {
                                    $erro = Array();

                                    $sql = '';
                                    $sql .= ' select vl_teto';
                                    $sql .= ' from grc_produto';
                                    $sql .= ' where idt = ' . null($rowe['idt_produto']);
                                    $rs = execsql($sql, false);
                                    $rowp = $rs->data[0];

                                    if ($rowp['vl_teto'] == '') {
                                        $rowp['vl_teto'] = 0;
                                    }

                                    foreach ($rsa->data as $rowa) {
                                        $sql = '';
                                        $sql .= ' select idt';
                                        $sql .= ' from grc_atendimento_organizacao';
                                        $sql .= ' where idt_atendimento = ' . null($rowa['idt']);
                                        $rs = execsql($sql, false);

                                        if ($rs->rows == 0) {
                                            $erro[] = 'Favor informar o Empreendimento do cliente ' . $rowa['protocolo'] . '!';
                                        }

                                        if ($rowe['sgtec_modelo'] == 'E') {
                                            $sql = '';
                                            $sql .= ' select sum(ea.percentual) as tot';
                                            $sql .= ' from grc_evento_entrega ea';
                                            $sql .= ' where ea.idt_atendimento = ' . null($rowa['idt']);
                                            $rs = execsql($sql, false);

                                            if ($rs->data[0][0] != 100) {
                                                $erro[] = 'O Percentual da distribuição das Entregas não é 100% para o cliente ' . $rowa['protocolo'] . '!';
                                            }

                                            if ($rowe['vl_determinado'] == 'S') {
                                                $sql = '';
                                                $sql .= ' select ea.idt';
                                                $sql .= ' from grc_evento_dimensionamento ea';
                                                $sql .= ' where ea.idt_atendimento = ' . null($rowa['idt']);
                                                $rs = execsql($sql, false);

                                                if ($rs->rows == 0) {
                                                    $erro[] = 'Favor informar o Dimensionamento da Demanda do cliente ' . $rowa['protocolo'] . '!';
                                                } else {
                                                    $sql = '';
                                                    $sql .= ' select sum(ea.vl_total) as tot';
                                                    $sql .= ' from grc_evento_dimensionamento ea';
                                                    $sql .= ' where ea.idt_atendimento = ' . null($rowa['idt']);
                                                    $rs = execsql($sql, false);

                                                    if ($rs->data[0][0] <= 0) {
                                                        $erro[] = 'O valor do Dimensionamento da Demanda não pode ser zero do cliente ' . $rowa['protocolo'] . '!';
                                                    } else if ($rs->data[0][0] > $rowp['vl_teto']) {
                                                        $erro[] = 'O valor do Dimensionamento da Demanda não pode ser maior que o Valor Teto da Solução do cliente ' . $rowa['protocolo'] . '!';
                                                    }
                                                }
                                            }
                                        }

                                        if (($situacao == 6 || ($situacao == 24 && $rowe['sgtec_modelo'] == 'E' && $rowe['vl_determinado'] == 'S')) && $rowe['nao_sincroniza_rm'] == 'N') {
                                            if ($rowe['sgtec_modelo'] == 'H' || ($rowe['sgtec_modelo'] == 'E' && $rowe['contrapartida_sgtec'] != '')) {
                                                $sql = '';
                                                $sql .= ' select sum(valor_pagamento) as tot';
                                                $sql .= ' from grc_evento_participante_pagamento';
                                                $sql .= ' where idt_atendimento = ' . null($rowa['idt']);
                                                $sql .= " and estornado <> 'S'";
                                                $sql .= " and operacao = 'C'";
                                                $sql .= ' and idt_aditivo_participante is null';
                                                $rs = execsql($sql, false);
                                                $tot = $rs->data[0][0];

                                                if ($tot == '') {
                                                    $erro[] = 'Favor informar o Resumo do Pagamento do cliente ' . $rowa['protocolo'] . '!';
                                                } else if ($tot != $rowa['vl_tot_pagamento']) {
                                                    $erro[] = 'Está faltando informar valores no Resumo do Pagamento do cliente ' . $rowa['protocolo'] . '!';
                                                }
                                            }
                                        }

                                        if ($rowe['sgtec_modelo'] == 'H' && $_POST['idt_instrumento'] == 2) {
                                            $sql = '';
                                            $sql .= ' select ea.idt';
                                            $sql .= ' from grc_evento_agenda ea';
                                            $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
                                            $sql .= ' where ea.idt_atendimento = ' . null($rowa['idt']);
                                            $sql .= whereEventoParticipante();
                                            $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                                            $rs = execsql($sql, false);

                                            if ($rs->rows == 0) {
                                                $erro[] = 'Favor informar a Agenda do cliente ' . $rowa['protocolo'] . '!';
                                            }
                                        }
                                    }

                                    if (count($erro) > 0) {
                                        $vet['erro'] = rawurlencode(implode("\n", $erro));
                                    }
                                }
                            }
                        }
                    }

                    //Valida dados da agenda
                    if ($vet['erro'] == '') {
                        if ($_POST['idt_instrumento'] == 2 && (($tipo_ordem == 'SG' && $rowe['sgtec_modelo'] == 'H') || $tipo_ordem != 'SG')) {
                            $sql = '';
                            $sql .= ' select ea.idt_tema, ea.idt_subtema';
                            $sql .= ' from grc_evento_agenda ea';
                            $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
                            $sql .= ' where ea.idt_evento = ' . null($idt_evento);
                            $sql .= whereEventoParticipante();
                            $sql .= ' and (ea.idt_tema is null or ea.idt_subtema is null)';
                            $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                            $rs = execsql($sql, false);

                            if ($rs->rows > 0) {
                                $vet['erro'] = rawurlencode('Favor informar o Tema e Subtema para todos os registros de Cronograma / Atividades!');
                            }
                        }
                    }

                    //Verifica se tem matriculas em situação Rascunho ou Em Assinatura
                    if ($vet['erro'] == '') {
                        if ($_POST['idt_instrumento'] == 2 && ($tipo_ordem != 'SG' || ($tipo_ordem == 'SG' && $rowe['sgtec_modelo'] == 'E' && $situacao == 6))) {
                            $sql = '';
                            $sql .= ' select ep.idt';
                            $sql .= ' from grc_atendimento a';
                            $sql .= ' inner join grc_evento_participante ep on ep.idt_atendimento = a.idt';
                            $sql .= ' where a.idt_evento = ' . null($idt_evento);
                            $sql .= " and (ep.contrato is null or ep.contrato in ('R', 'A'))";
                            $sql .= " and ep.ativo = 'S'";
                            $rs = execsql($sql, false);

                            if ($rs->rows > 0) {
                                $vet['erro'] = rawurlencode('Não pode dar continuidade no processo, pois tem inscrições de participantes em situação de Rascunho, Em Assinatura ou Aguardando Matrícula!');
                            }
                        }
                    }

                    //Composto
                    if ($vet['erro'] == '') {
                        if ($_POST['idt_instrumento'] == 52) {
                            $sql = '';
                            $sql .= ' select ep.idt';
                            $sql .= ' from grc_atendimento a';
                            $sql .= ' inner join grc_evento_participante ep on ep.idt_atendimento = a.idt';
                            $sql .= ' where a.idt_evento in (';
                            $sql .= ' select idt';
                            $sql .= ' from ' . db_pir_grc . 'grc_evento';
                            $sql .= ' where idt_evento_pai = ' . null($idt_evento);
                            $sql .= ' and idt_instrumento = 2';
                            $sql .= ' )';
                            $sql .= " and (ep.contrato is null or ep.contrato in ('R', 'A'))";
                            $sql .= " and ep.ativo = 'S'";
                            $rs = execsql($sql, false);

                            if ($rs->rows > 0) {
                                $vet['erro'] = rawurlencode('Não pode dar continuidade no processo, pois tem inscrições de participantes em situação de Rascunho, Em Assinatura ou Aguardando Matrícula nos subeventos de consultoria!');
                            } else {
                                $sql = '';
                                $sql .= ' select idt';
                                $sql .= ' from ' . db_pir_grc . 'grc_evento';
                                $sql .= ' where idt_evento_pai = ' . null($idt_evento);
                                $sql .= ' and idt_instrumento = 2';
                                $sql .= " and inc_cliente_prev = 'S'";
                                $rs = execsql($sql, false);

                                if ($rs->rows > 0) {
                                    $sql = '';
                                    $sql .= ' select ep.idt';
                                    $sql .= ' from grc_atendimento a';
                                    $sql .= ' inner join grc_evento_participante ep on ep.idt_atendimento = a.idt';
                                    $sql .= ' where a.idt_evento in (';
                                    $sql .= ' select idt';
                                    $sql .= ' from ' . db_pir_grc . 'grc_evento';
                                    $sql .= ' where idt_evento_pai = ' . null($idt_evento);
                                    $sql .= ' and idt_instrumento = 2';
                                    $sql .= ' )';
                                    $sql .= " and ep.contrato in ('C', 'S', 'G')";
                                    $sql .= " and ep.ativo = 'S'";
                                    $rs = execsql($sql, false);

                                    if ($rs->rows == 0) {
                                        $vet['erro'] = rawurlencode('Não pode dar continuidade no processo, pois não tem inscrições de participantes nos subeventos de consultoria!');
                                    }
                                }
                            }

                            $sql = '';
                            $sql .= ' select codigo, descricao';
                            $sql .= ' from grc_evento e';
                            $sql .= ' where e.idt_evento_pai = ' . null($idt_evento);
                            $sql .= ' and e.idt_instrumento = 2';
                            $sql .= ' and e.tot_hora_consultoria > e.carga_horaria_total';
                            $rsEV = execsql($sql, false);

                            $vetErroMsg = Array();

                            foreach ($rsEV->data as $rowEV) {
                                $vetErroMsg[] = 'A soma das horas das atividades nas Inscrições ultrapassa a Carga Horária informado no subevento ' . $rowEV['codigo'] . ' :: ' . $rowEV['descricao'] . '!';
                            }

                            if (count($vetErroMsg) > 0) {
                                $vet['erro'] = rawurlencode(implode("\n", $vetErroMsg));
                            }
                        }
                    }
                }
            }

            if ($situacao == 'Credenciado') {
                if ($vet['erro'] == '') {
                    if ($tipo_ordem != 'SG') {
                        $vet['erro'] = rawurlencode('O programa do evento não aceita a utilização da ordem de contratação (Credenciado)!');
                    }
                }
            }

            if ($situacao == 'CanPreAprovarEvento') {
                if ($vet['erro'] == '') {
                    $sql = '';
                    $sql .= ' select pp.idt';
                    $sql .= ' from ' . db_pir_grc . 'grc_atendimento a';
                    $sql .= ' inner join ' . db_pir_grc . 'grc_evento_participante_pagamento pp on pp.idt_atendimento = a.idt';
                    $sql .= ' where a.idt_evento = ' . null($idt_evento);
                    $sql .= " and pp.estornado <> 'S'";
                    $sql .= " and pp.operacao = 'C'";
                    $sql .= ' and pp.idt_aditivo_participante is null';
                    $rs = execsql($sql, false);

                    if ($rs->rows > 0) {
                        $vet['erro'] = rawurlencode('Não pode cancelar a Pré-Aprovação, pois já tem pagamentos registrados!');
                    }
                }
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'ExcluiEventoTemporario':
        $erro = Array();
        $vet = Array(
            'erro' => '',
        );
        $idt_evento = $_POST['idt_evento'];
        ExcluiEventoTemporario($idt_evento);
        echo json_encode($vet);
        break;

    case 'grc_atendimento_pendencia_fecha_ant':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = "delete from grc_atendimento_pendencia where idt_atendimento = " . null($_SESSION[CS]['objListarConf_vetID'][$_POST['session_cod']]['grc_atendimento']);
            $sql .= " and temporario = 'S'";
            execsql($sql, false);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_entidade_organizacao_volta':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = "delete from grc_entidade_organizacao where idt = " . null($_POST['idt']);
            $sql .= " and novo_registro = 'S'";
            execsql($sql, false);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'BuscaCNPJ_GEC':
        $variavel = Array();
        $variavel['erro'] = "";
        $variavel['idt_tipo_empreendimento'] = $_POST['idt_tipo_empreendimento'];

        if (validaCNPJ($_POST['cnpj'])) {
            $variavel['cnpj'] = FormataCNPJ($_POST['cnpj']);
        } else {
            $variavel['cnpj'] = '';
        }

        $variavel['codparceiro'] = $_POST['codparceiro'];
        $variavel['dap'] = $_POST['dap'];
        $variavel['nirf'] = $_POST['nirf'];
        $variavel['rmp'] = $_POST['rmp'];
        $variavel['ie_prod_rural'] = $_POST['ie_prod_rural'];
        $variavel['sicab_codigo'] = $_POST['sicab_codigo'];
        $variavel['razao_social'] = $_POST['razao_social'];
        $variavel['nome_fantasia'] = $_POST['nome_fantasia'];

        BuscaCNPJ_GEC($_POST['idt'], $variavel);

        if ($variavel['codparceiro_lista'] == '') {
            echo $variavel['idt_entidade_organizacao'];
        } else {
            $cod = GerarStr();
            $_SESSION[CS]['tmp'][$cod] = $variavel['codparceiro_lista'];
            echo 'codparceiro_lista=' . $cod;
        }
        break;

    case 'BuscaCPF_GEC':
        $variavel = Array();
        $variavel['erro'] = "";
        $variavel['cpf'] = FormataCPF12($_POST['cpf']);

        BuscaCPF_GEC($_POST['idt'], $variavel);
        echo $variavel['idt_entidade_pessoa'];
        break;

    case 'nanValidarPF':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = "update grc_atendimento set nan_ap_sit_pf = 'S', nan_ap_dt_pf = now() where idt = " . null($_POST['idt']);
            execsql($sql, false);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'nanValidarPJ':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = "update grc_atendimento set nan_ap_sit_pj = 'S', nan_ap_dt_pj = now() where idt = " . null($_POST['idt']);
            execsql($sql, false);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'nanValidarAtendimento':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = "update grc_atendimento set nan_ap_sit_at = 'S', nan_ap_dt_at = now() where idt = " . null($_POST['idt']);
            execsql($sql, false);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'nan_visita_1_valida':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select cnpj';
            $sql .= ' from grc_atendimento_organizacao';
            $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
            $sql .= " and representa = 'S'";
            $sql .= " and desvincular = 'N'";
            $rst = execsql($sql, false);

            $sql = '';
            $sql .= ' select idt, codigo, descricao';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade';
            $sql .= ' where codigo = ' . aspa($rst->data[0][0]);
            $sql .= " and reg_situacao = 'A'";
            $rst = execsql($sql, false);
            $row = $rst->data[0];

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_nan_grupo_atendimento';
            $sql .= ' where idt_organizacao = ' . null($row['idt']);
            $sql .= ' and year(dt_registro_1) = year(now())';
            $sql .= " and status_1 not in ('CD', 'DE', 'CA')";
            $rs = execsql($sql, false);

            if ($rs->rows > 1) {
                $erro = 'Não pode realizar esta visita, pois o Empreendimento (' . $row['codigo'] . ' - ' . $row['descricao'] . ') já esta com um registro de visita para o ano corrente!';
                grava_log_sis('nan_visita_1_valida', 'R', $_POST['idt_atendimento'], $erro, 'Validação da 1º Visita do NAN');
                $vet['erro'] = rawurlencode($erro);
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'nan_visita_2_valida':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select ao.cnpj, a.idt_grupo_atendimento';
            $sql .= ' from grc_atendimento_organizacao ao';
            $sql .= ' inner join grc_atendimento a on a.idt = ao.idt_atendimento';
            $sql .= ' where ao.idt_atendimento = ' . null($_POST['idt_atendimento']);
            $sql .= " and ao.representa = 'S'";
            $sql .= " and ao.desvincular = 'N'";
            $rst = execsql($sql, false);
            $rowa = $rst->data[0];

            $sql = '';
            $sql .= ' select idt, codigo, descricao';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade';
            $sql .= ' where codigo = ' . aspa($rowa['cnpj']);
            $sql .= " and reg_situacao = 'A'";
            $rst = execsql($sql, false);
            $rowo = $rst->data[0];

            $sql = '';
            $sql .= ' select idt_organizacao';
            $sql .= ' from grc_nan_grupo_atendimento';
            $sql .= ' where idt = ' . null($rowa['idt_grupo_atendimento']);
            $rs = execsql($sql, false);

            if ($rs->data[0][0] != $rowo['idt']) {
                $erro = 'Não pode realizar esta visita, pois o Empreendimento (' . $rowo['codigo'] . ' - ' . $rowo['descricao'] . ') esta diferente ao Empreendimento da Primeira Visita!';
                $vet['erro'] = rawurlencode($erro);
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_nan_ordem_pagamento_at_per':
        $vet = Array(
            'erro' => '',
            'qtd_total_visitas' => '',
            'qtd_visitas1' => '',
            'qtd_visitas2' => '',
            'valor_total' => '',
        );

        try {
            beginTransaction();

            $sql = 'update grc_atendimento set idt_nan_ordem_pagamento = null where idt = ' . null($_POST['idt']);
            execsql($sql, false);

            $vetResultado = Array();
            NAN_CalcularOP($_POST['idt_pag'], $vetResultado);

            $vet['qtd_total_visitas'] = $vetResultado['QTTO'];
            $vet['qtd_visitas1'] = $vetResultado['QTDV1'];
            $vet['qtd_visitas2'] = $vetResultado['QTDV2'];
            $vet['valor_total'] = format_decimal($vetResultado['VLTO']);

            commit();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'RefreshPainelControle':
        $vet = Array(
            'erro' => '',
            'html' => '',
            'senha_atual' => '',
        );

        try {
            ob_start();
            $numpainel = $_POST['numpainel'];
            $variavel = Array();
            $variavel['numpainel'] = $numpainel;
            //p($variavel);
            RefreshPainelControle_pir($variavel);

            $vet['erro'] = rawurlencode(ob_get_clean());
            ob_end_clean();

            $vet['html'] = rawurlencode($variavel['html']);
            $vet['senha_atual'] = rawurlencode($variavel['senha_atual']);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'GerarDadosEstatisticos':
        $vet = Array(
            'erro' => '',
        );

        GerarDadosEstatisticos($vet);

        echo json_encode($vet);
        break;

    case 'GerarDW':
        $vet = Array(
            'erro' => '',
        );

        GerarDW($vet);

        echo json_encode($vet);
        break;


    case 'GeraDWIQ':
        $vet = Array(
            'erro' => '',
        );

        GeraDWIQ($vet);

        echo json_encode($vet);
        break;

    case 'desisteMarcacao':
        $vet = Array(
            'erro' => '',
        );
        $idt_atendimento_agenda = null($_POST['idt_atendimento_agenda']);

        $vetPar = Array();
        $vetPar['tipo'] = 'DESISTE ATENDIMENTO';
        $vetPar['idt_atendimento_agenda'] = $idt_atendimento_agenda;
        RegistrarLogAgendamento($vetPar);

        // Para o caso de desisteir sem marcar nada
        $sql = "update grc_atendimento_agenda ";
        $sql .= " set ";
        $sql .= " idt_atendimento_agenda = " . 'null' . ", ";
        $sql .= " protocolo                  = " . aspa('') . ", ";
        $sql .= " semmarcacao                = " . aspa('N') . ", ";
        $sql .= " marcador                   = " . aspa('') . ", ";
        $sql .= " idt_marcador               = " . 'null' . ", ";
        $sql .= " data_hora_marcacao_inicial = " . aspa('') . " ";
        $sql .= " where idt = " . null($idt_atendimento_agenda);
        $sql .= "   and semmarcacao = " . aspa('S');
        execsql($sql);

        // se tem filhos desmarcar
        // 
        $sql = "update grc_atendimento_agenda ";
        $sql .= " set ";
        $sql .= " situacao           = " . aspa('Agendado') . ", ";
        $sql .= " idt_especialidade  = " . 'null' . ", ";
        $sql .= " idt_atendimento_agenda = " . 'null' . ", ";
        $sql .= " idt_cliente        = " . 'null' . ", ";
        $sql .= " cliente_texto      = " . aspa('') . ", ";
        $sql .= " cpf                = " . aspa('') . ", ";
        $sql .= " cnpj               = " . aspa('') . ", ";
        $sql .= " nome_empresa       = " . aspa('') . ", ";
        $sql .= " telefone           = " . aspa('') . ", ";
        $sql .= " celular            = " . aspa('') . ", ";
        $sql .= " email              = " . aspa('') . ", ";
        $sql .= " protocolo          = " . aspa('') . ", ";
        $sql .= " assunto            = " . aspa('') . ", ";
        $sql .= " necessidade_especial = " . aspa('N') . ", ";
        $sql .= " data_hora_marcacao = " . aspa('') . ", ";
        $sql .= " observacao_desmarcacao     = " . aspa('') . ", ";
        $sql .= " semmarcacao                = " . aspa('N') . ", ";
        $sql .= " marcador                   = " . aspa('') . ", ";
        $sql .= " idt_marcador               = " . 'null' . ", ";
        $sql .= " data_hora_ausencia = " . aspa('') . ", ";
        $sql .= " observacao_desmarcacao = " . aspa('') . ", ";
        $sql .= " data_hora_marcacao_inicial = " . aspa('') . " ";
        $sql .= " where idt_atendimento_agenda = " . null($idt_atendimento_agenda);
        execsql($sql);

        echo json_encode($vet);
        break;

    case 'desisteDesMarcacao':
        $vet = Array(
            'erro' => '',
        );
        $idt_atendimento_agenda = null($_POST['idt_atendimento_agenda']);

        $vetPar = Array();
        $vetPar['tipo'] = 'DESISTE DESMARCAÇÃO';
        $vetPar['idt_atendimento_agenda'] = $idt_atendimento_agenda;
        RegistrarLogAgendamento($vetPar);

        // Para o caso de desisteir sem marcar nada
        $sql = "update grc_atendimento_agenda ";
        $sql .= " set ";
        $sql .= " semmarcacao                = " . aspa('N') . " ";
        $sql .= " where idt = " . null($idt_atendimento_agenda);
        $sql .= "   and semmarcacao = " . aspa('S');
        execsql($sql);
        echo json_encode($vet);
        break;

    case 'desisteExcluir':
        $vet = Array(
            'erro' => '',
        );
        $idt_atendimento_agenda = null($_POST['idt_atendimento_agenda']);

        $vetPar = Array();
        $vetPar['tipo'] = 'DESISTE EXCLUIR';
        $vetPar['idt_atendimento_agenda'] = $idt_atendimento_agenda;
        RegistrarLogAgendamento($vetPar);

        // Para o caso de desisteir sem marcar nada
        $sql = "update grc_atendimento_agenda ";
        $sql .= " set ";
        $sql .= " semmarcacao                = " . aspa('N') . " ";
        $sql .= " where idt = " . null($idt_atendimento_agenda);
        $sql .= "   and semmarcacao = " . aspa('S');
        execsql($sql);

        echo json_encode($vet);
        break;

    case 'AprovarDevolutivaDistancia':
        $vet = Array(
            'erro' => '',
        );
        $vet['idt_atendimento'] = $_POST['idt_atendimento'];
        AprovarDevolutivaDistancia($vet);
        echo json_encode($vet);
        break;

    case 'DesAprovarDevolutivaDistancia':
        $vetw = Array(
            'erro' => '',
        );
        $vetw['idt_atendimento'] = $_POST['idt_atendimento'];
        $vetw['solucao'] = utf8_decode($_POST['solucao']);
        $vetw['observacao'] = utf8_decode($_POST['solucao']);
        DesAprovarDevolutivaDistancia($vetw);
        $vet['erro'] = rawurlencode($vetw['erro']);
        echo json_encode($vet);
        break;

    case 'EnviarSMSPresenca':
        $vet = Array(
            'erro' => '',
        );
        $vet['idt_atendimento_agenda'] = $_POST['idt_atendimento_agenda'];
        $vet['idt_especialidade'] = $_POST['idt_especialidade'];
        EnviarSMSPresenca($vet);
        echo json_encode($vet);
        break;

    case 'EnviarEMAILPresenca':
        $vet = Array(
            'erro' => '',
        );
        $vet['idt_atendimento_agenda'] = $_POST['idt_atendimento_agenda'];
        $vet['idt_especialidade'] = $_POST['idt_especialidade'];
        EnviarEMAILPresenca($vet);
        echo json_encode($vet);
        break;

    case 'BuscaPessoaJuridica':
        $cpf = FormataCPF12($_POST['cpf']);
        $cnpj = FormataCNPJ($_POST['cnpj']);
        $variavel = Array();
        $variavel['erro'] = "";
        $variavel['cpf'] = $cpf;
        $variavel['cnpj'] = $cnpj;
        $idt_atendimento = "";
        BuscaCNPJMARCACAO($variavel);
        //p($variavel);
        //exit();

        $existe = 1;
        $cnpj = $cnpj;
        $nome_empresa = $variavel['nome_empresa'];
        $retorno = "";
        $retorno .= $existe . '###';
        $retorno .= $cnpj . '###';
        $retorno .= $nome_empresa . '###';
        echo $retorno;

        break;

    case 'VefificaConsumoHorarios':

        $vet = Array(
            'erro' => '',
        );

        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $idt_servico = $_POST['idt_servico'];

        $vet = VefificaConsumoHorarios($idt_atendimento_agenda, $idt_servico);
        $vet = array_map('rawurlencode', $vet);

        echo json_encode($vet);
        break;

    case 'DuracaoConsultor':

        $idt_ponto_atendimento = $_POST['idt_ponto_atendimento'];
        $duracao_informada = $_POST['duracao_informada'];
        $idt_servico = $_POST['idt_servico'];
        $vet = Array(
            'erro' => '',
        );
        $texto = "";
        //  Acessar 
        $periodo = "";
        $sql = "select  ";
        $sql .= " grc_aps.periodo  ";
        $sql .= " from grc_agenda_parametro_servico grc_aps ";
        $sql .= ' where idt_parametro = ' . null(1);
        $sql .= '   and idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
        $sql .= '   and idt_servico           = ' . null($idt_servico);
        $rs = execsql($sql);
        if ($rs->rows > 0) {
            ForEach ($rs->data as $row) {
                $periodo = $row['periodo'];
            }
        } else {
            
        }
        if ($periodo == '') {
            $texto .= rawurlencode('Não encontrado valor Máximo de duração para o PA Serviço');
        } else {
            if ($duracao_informada > $periodo) {
                // Duração informada não pode ser maior que a parametrizada para o Pa e para esse serviço  
                $texto .= rawurlencode("Duração informada [{$duracao_informada}] não pode ser maior que a parametrizada [{$periodo}] para o Pa e para esse serviço.  ");
            }
        }
        $vet['erro'] = $texto;
        echo json_encode($vet);
        break;

    case 'RegistrarAvaliacaoEstrelinha':

        $idt_evento = $_POST['idt_evento'];
        $cpf = $_POST['cpf'];
        $avaliacao = $_POST['avaliacao'];
        $vet = Array(
            'erro' => '',
        );
        $texto = "";
        $vetRetorno = Array();
        $vetRetorno['idt_evento'] = $idt_evento;
        $vetRetorno['cpf'] = $cpf;
        $vetRetorno['avaliacao'] = $avaliacao;
        $ret = RegistrarAvaliacaoEstrelinha($vetRetorno);
        $texto = $vetRetorno['erro'];
        $vet['erro'] = rawurlencode($texto);
        echo json_encode($vet);
        break;

    case 'VerificaSePresoParaMarcacao':

        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];

        $vet = Array(
            'erro' => '',
        );

        $vet = VerificaAtendimentoPresoParaMarcacao($idt_atendimento_agenda);
        $vet = array_map('rawurlencode', $vet);

        echo json_encode($vet);
        break;

    case 'grc_eve':
        $vet = Array(
            'erro' => '',
        );

        try {
            $idt_politica_venda = $_POST['idt_politica_venda'];
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_final'];

            beginTransaction();

            foreach ($vetSel as $idx => $dados) {
                if ($dados['idt'] != '') {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_politica_vendas_eventos';
                    $sql .= ' where idt_politica_vendas = ' . null($idt_politica_venda);
                    $sql .= ' and idt_evento        = ' . null($dados['idt']);
                    $rs = execsql($sql, false);
                    if ($rs->rows == 0) {
                        $sql = 'insert into grc_politica_vendas_eventos (idt_politica_vendas, idt_evento) values (';
                        $sql .= null($idt_politica_venda) . ', ' . null($dados['idt']) . ')';
                        execsql($sql, false);
                    }
                }
            }

            commit();

            $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_final'] = Array();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_eveexc':
        $vet = Array(
            'erro' => '',
        );

        try {
            $idt_politica_venda = $_POST['idt_politica_venda'];
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_final'];

            beginTransaction();

            foreach ($vetSel as $idx => $dados) {
                if ($dados['idt'] != '') {
                    $sql = ' delete from ';
                    $sql .= ' grc_politica_vendas_eventos ';
                    $sql .= ' where ';
                    $sql .= '     idt_politica_vendas = ' . null($idt_politica_venda);
                    $sql .= ' and idt_evento = ' . null($dados['idt']);
                    $rs = execsql($sql);
                }
            }

            commit();

            $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_final'] = Array();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'VerificaDestinatarios':
        $vet = Array(
            'erro' => '',
        );
        $idt_atendimento_pendencia = $_POST['idt_atendimento_pendencia'];
        $sql = ' select idt from ';
        $sql .= ' grc_atendimento_pendencia_destinatario ';
        $sql .= ' where ';
        $sql .= '     idt_pendencia = ' . null($idt_atendimento_pendencia);
        $rs = execsql($sql);
        if ($rs->rows == 0) {
            $msg = "Sem Destinatários informados ";
            $vet['erro'] = rawurlencode($msg);
        }
        echo json_encode($vet);
        break;
}
