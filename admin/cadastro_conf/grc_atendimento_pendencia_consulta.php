<?php
if (is_numeric($_GET['id'])) {
    $pendencia_sistema = 'GRC';
} else {
    $pendencia_sistema = substr($_GET['id'], 0, 3);
    $_GET['id'] = substr($_GET['id'], 3);
}



if ($pendencia_sistema == 'GRC') {
    $sql = "select  ";
    $sql .= " *  ";
    $sql .= " from grc_atendimento_pendencia grc_ap ";
    $sql .= " where idt = ".null($_GET['id']);
    $rs = execsql($sql);
    $row = $rs->data[0];

    switch ($row['tipo']) {
        case 'NAN - Visita 1':
            if ($row['status'] == 'Aprovação') {
                $url = 'conteudo.php?acao=alt&prefixo=cadastro&voltar=pendencia_listar&menu=grc_nan_visita_1_ap&id='.$row['idt_atendimento'].'&idt_pendencia='.$row['idt'];
            } else {
                $sql = '';
                $sql .= ' select idt_atendimento_agenda';
                $sql .= ' from grc_atendimento';
                $sql .= ' where idt = '.null($row['idt_atendimento']);
                $rs = execsql($sql);
                $idt_atendimento_agenda = $rs->data[0][0];

                $url = 'conteudo.php?prefixo=inc&menu=grc_nan_visita_1&voltar=pendencia_home&pendencia_listar=avulso&idt_atendimento_agenda='.$idt_atendimento_agenda.'&idt_atendimento='.$row['idt_atendimento'].'&id='.$idt_atendimento_agenda."&pesquisa=".$_GET['pesquisa'].'&aba=2&idt_pendencia='.$row['idt'];
            }

            echo '<script type="text/javascript">self.location = "'.$url.'";</script>';
            exit();
            break;

        case 'NAN - Visita 2':
            if ($row['status'] == 'Aprovação') {
                $url = 'conteudo.php?acao=alt&prefixo=cadastro&voltar=pendencia_listar&menu=grc_nan_visita_2_ap&id='.$row['idt_atendimento'].'&idt_pendencia='.$row['idt'];
            } else {
                $sql = '';
                $sql .= ' select idt_atendimento_agenda';
                $sql .= ' from grc_atendimento';
                $sql .= ' where idt = '.null($row['idt_atendimento']);
                $rs = execsql($sql);
                $idt_atendimento_agenda = $rs->data[0][0];

                $url = 'conteudo.php?prefixo=inc&menu=grc_nan_visita_2&voltar=pendencia_home&pendencia_listar=avulso&idt_atendimento_agenda='.$idt_atendimento_agenda.'&idt_atendimento='.$row['idt_atendimento'].'&id='.$idt_atendimento_agenda."&pesquisa=".$_GET['pesquisa'].'&aba=2&idt_pendencia='.$row['idt'];
            }

            echo '<script type="text/javascript">self.location = "'.$url.'";</script>';
            exit();
            break;

        case 'NAN - Ordem de Pagamento':
            $url = 'conteudo.php?acao=alt&prefixo=cadastro&voltar=pendencia_home&menu=grc_nan_ordem_pagamento&id='.$row['idt_nan_ordem_pagamento'].'&idt_pendencia='.$row['idt'];
            echo '<script type="text/javascript">self.location = "'.$url.'";</script>';
            exit();
            break;

        case 'Atendimento Distância':
			$sql = '';
			$sql .= ' select idt_atendimento_agenda';
			$sql .= ' from grc_atendimento';
			$sql .= ' where idt = '.null($row['idt_atendimento']);
			$rs = execsql($sql);
			$idt_atendimento_agenda = $rs->data[0][0];
			
			if ($row['status'] == 'Devolução para Ajustes') {
				$pesquisa = 'S';
			} else {
				$pesquisa = 'N';
			}
            $par = "&RETNI=S" ;    
            //$par  = getParametro('menu,prefixo', false);			
//			$_POST=$_SESSION[CS]['grc_atendimento_pendencia_consulta'];

			$url = 'conteudo.php?prefixo=inc&menu=grc_atender_cliente&session_volta=avulso&idt_atendimento_agenda='.$idt_atendimento_agenda.'&idt_atendimento='.$row['idt_atendimento'].'&id='.$idt_atendimento_agenda."&pesquisa=".$pesquisa.'&aba=2&idt_atendimento_pendencia='.$row['idt'].'&grc_atendimento_pendencia_consulta=grc_atendimento_pendencia_consulta'.$par;
			
            echo '<script type="text/javascript">self.location = "'.$url.'";</script>';
            exit();
            break;

    case 'Transferência de Responsabilidades':
        $url = 'conteudo.php?acao=alt&prefixo=cadastro&voltar=pendencia_home&menu=grc_transferencia_responsabilidade&id='.$row['idt_transferencia_responsabilidade'].'&idt_pendencia='.$row['idt'];
        echo '<script type="text/javascript">self.location = "'.$url.'";</script>';
        exit();
        break;

        default:
            if ($row['idt_nan_ordem_pagamento'] != '') {
                $url = 'conteudo.php?acao=alt&prefixo=cadastro&voltar=pendencia_home&menu=grc_nan_ordem_pagamento&id='.$row['idt_nan_ordem_pagamento'].'&idt_pendencia='.$row['idt'];
                echo '<script type="text/javascript">self.location = "'.$url.'";</script>';
                exit();
            }
            break;
    }
} else {
    $sql = "select  ";
    $sql .= " *  ";
    $sql .= " from ".db_pir_gec."gec_pendencia grc_ap ";
    $sql .= " where idt = ".null($_GET['id']);
    $rs = execsql($sql);
    $row = $rs->data[0];

    switch ($row['tipo']) {
        case 'Ordem de Contratação':
        case 'Pagamento a Credenciado':
            $url = 'conteudo.php?acao=alt&prefixo=cadastro&menu=gec_contratacao_credenciado_ordem&id='.$row['idt_contratacao_credenciado_ordem'].'&idt_pendencia='.$row['idt'];
            echo '<script type="text/javascript">self.location = "'.$url.'";</script>';
            exit();
            break;
    }
}

if ($row['idt_evento'] == '') {
    require_once 'grc_atendimento_pendencia.php';
} else {

    
    ?>
    <style>
        #nm_funcao_desc label{
        }
        #nm_funcao_obj {
        }
        .Tit_Campo {
        }
        .Tit_Campo_Obr {
        }
        fieldset.class_frame {
            background:#ECF0F1;
            border:1px solid #14ADCC;
        }
        div.class_titulo {
            background: #ABBBBF;
            border    : 1px solid #14ADCC;
            color     : #FFFFFF;
            text-align: left;
        }
        div.class_titulo span {
            padding-left:10px;
        }

        #nm_funcao_desc label{
        }
        #nm_funcao_obj {
        }
        .Tit_Campo {
        }
        .Tit_Campo_Obr {
        }
        fieldset.class_frame_f {
            background:#2F66B8;
            border:1px solid #FFFFFF;
            guyheight:30px;
        }
        div.class_titulo_f {
            background: #2F66B8;
            border    : 1px solid #2C3E50;
            color     : #FFFFFF;
            text-align: left;
            guyheight:30px;
            padding-top:10px;
        }
        div.class_titulo_f span {
            padding-left:20px;
            text-align: left;
        }

        fieldset.class_frame_p {
            xbackground:#ABBBBF;

            xborder:1px solid #FFFFFF;

            background:#FFFFFF;
            border:0px solid #FFFFFF;



        }
        div.class_titulo_p {
            background: #2F66B8;

            text-align: left;
            border    : 0px solid #2C3E50;
            color     : #FFFFFF;
            color     : #FFFFFF;
            text-align: left;
            height    : 20px;
            font-size : 12px;
            padding-top:5px;



        }
        div.class_titulo_p span {
            padding:10px;

            text-align: left;
        }

        div.class_titulo_p_barra {
            text-align: left;
            background: #2C3E50;
            border    : 0px solid #2C3E50;
            color     : #FFFFFF;
            font-weight: bold;
            line-height: 12px;
            margin: 0;
            padding: 3px;
            padding-left: 20px;
        }


        fieldset.class_frame {
            xbackground:#ECF0F1;
            xborder:1px solid #2C3E50;
            background:#FFFFFF;
            border:0px solid #2C3E50;
        }
        div.class_titulo {
            xbackground: #C4C9CD;
            xborder    : 1px solid #2C3E50;
            xcolor     : #FFFFFF;
            text-align: left;

            background: #FFFFFF;
            color     : #FFFFFF;
            border    : 0px solid #2C3E50;


        }
        div.class_titulo span {
            padding-left:10px;
        }
        div.class_titulo_c {
            xbackground: #C4C9CD;
            xborder    : 1px solid #2C3E50;
            xcolor     : #FFFFFF;
            text-align: center;

            background: #FFFFFF;
            color     : #FFFFFF;
            border    : 0px solid #2C3E50;


        }
        div.class_titulo_c span {
            padding-left:10px;
        }











        Select {
            border:0px;
            xopacity: 0;
            xfilter:alpha(opacity=0);
            height:20px;
        }

        .TextoFixo {

            font-size:12px;
            guyheight:25px;
            text-align:left;
            border:0px;
            xbackground:#F1F1F1;
            background:#ECF0F1;


            font-weight:normal;

            font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
            font-style: normal;
            word-spacing: 0px;
            padding-top:5px;



        }

        td#idt_competencia_obj div {
            color:#FF0000;
        }

        .Tit_Campo {
            font-size:12px;
        }


        div#topo {
            wwxwidth:900px;
        }
        div#geral {
            wwxwidth:900px;
        }

        div#grd0 {
            wwxwidth:700px;
            wwxmargin-left:200px;

        }

        div#meio_util {
            wwxwidth:700px;
            wwxmargin-left:70px;
        }
        td.Titulo {
            color:#666666;
        }




        #idt_instrumento_obj {
            width:100%;
        }

        #idt_instrumento_tf {
            text-align:center;
            font-size:2em;
            background:#2C3E50;
            color:#FFFFFF;
            font-weight:bold;

            font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;

        }


        .Texto {

            border:0;
        }

        #gestor_sge_fix {
            background:#ECF0F1;
        }
        #fase_acao_projeto_fix {
            background:#ECF0F1;
        }

        div.Barra {
            display: none;
        }

        #grc_atendimento_pendencia_anexo_desc td#Titulo_radio {
            width: 64px;
        }

    </style>

    <?php
//p($_GET);

    $voltar = $_GET['voltar'];

    $barra_bt_top = false;

    if ($voltar == 'pendencia_home') {
        $botao_acao = '<script type="text/javascript">self.location = "conteudo.php";</script>';
        $botao_volta = "self.location = 'conteudo.php';";
    }

    $vetPadraoLC = Array(
        'barra_inc_img' => "imagens/incluir_16.png",
        'barra_alt_img' => "imagens/alterar_16.png",
        'barra_con_img' => "imagens/consultar_16.png",
        'barra_exc_img' => "imagens/excluir_16.png",
    );



    if ($_GET['idCad'] != '') {
        $_GET['idt0'] = $_GET['idCad'];
        $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
        $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
    }
//p($_GET);
    $TabelaPai = "grc_atendimento";
    $AliasPai = "grc_a";
    $EntidadePai = "Protocolo";
    $idPai = "idt";
//
    $TabelaPrinc = "grc_atendimento_pendencia";
    $AliasPric = "grc_ap";
    $Entidade = "Pendência do Atendimento";
    $Entidade_p = "Pendências do Atendimento";
    $CampoPricPai = "idt_atendimento";

    $tabela = $TabelaPrinc;


    $idt_atendimento_pendencia = $_GET['id'];
    $idt_atendimento = 0;
    $idt_evento = 0;





    if ($acao != 'inc') {
        $sql = "select  ";
        $sql .= " grc_ap.*  ";
        $sql .= " from grc_atendimento_pendencia grc_ap ";
        $sql .= " where idt = ".null($idt_atendimento_pendencia);
        $rs = execsql($sql);
        $wcodigo = '';
        ForEach ($rs->data as $row) {
            $idt_usuario = $row['idt_usuario'];
            $idt_atendimento = $row['idt_atendimento'];
            $idt_evento = $row['idt_evento'];
            $tipo = $row['tipo'];
        }
        if ($tipo == 'Evento') {
            $sql = "select  ";
            $sql .= " grc_e.*  ";
            $sql .= " from grc_evento grc_e ";
            $sql .= " where idt = ".null($idt_evento);
            $rs = execsql($sql);
            $wcodigo = '';
            ForEach ($rs->data as $row) {
                $protocolo = $row['codigo'];
            }
        } else {
            if ($tipo == 'Atendimento Presencial') {
                $sql = "select  ";
                $sql .= " grc_a.*  ";
                $sql .= " from grc_atendimento grc_a ";
                $sql .= " where idt = ".null($idt_atendimento);
                $rs = execsql($sql);
                $wcodigo = '';
                ForEach ($rs->data as $row) {
                    $protocolo = $row['protocolo'];
                }
            } else {
                $sql = "select  ";
                $sql .= " grc_a.*  ";
                $sql .= " from grc_atendimento grc_a ";
                $sql .= " where idt = ".null($idt_atendimento);
                $rs = execsql($sql);
                $wcodigo = '';
                ForEach ($rs->data as $row) {
                    $protocolo = $row['protocolo'];
                }
            }
        }

        // echo " Protocolo: ".$protocolo;
    } else {
        
    }

    if ($idt_evento > 0) {
	

	
	
        $url = 'conteudo.php?acao=con&prefixo=cadastro&voltar=pendencia_listar&menu=grc_evento&id='.$idt_evento.'&idt_pendencia='.$idt_atendimento_pendencia."&pencon=S";
		
		
		//	echo " evento..... ".$pendencia_sistema.' '.$row['tipo'].''.$acao." -- ".$url ;
	//exit();

		
		
        echo '<script type="text/javascript">self.location = "'.$url.'";</script>';
        exit();
    }

    if ($tipo == 'Evento') {
        $protocolo_titulo = 'Código do Evento';
        $data_titulo = 'Data do Solicitação Aprovação';
        $assunto_titulo = 'Título do Evento';
        $observacao_titulo = 'Detalhamento do Evento';
        $solucao = 'Parecer';
    } else {
        $protocolo_titulo = 'Protocolo de Atendimento';
        $data_titulo = 'Data do Atendimento';
        $assunto_titulo = 'Assunto';
        $observacao_titulo = 'Detalhamento da Pendência';
        $solucao = 'Resposta';
    }



    $id = 'idt';
    $vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'protocolo', 0);

    $corbloq = "#FFFF80";
    $jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
    $vetCampo['protocolo'] = objTexto('protocolo', $protocolo_titulo, false, 15, 45, $jst);

    $corbloq = "#FFFF80";
    $jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
    $vetCampo['status'] = objTexto('status', 'Status', false, 15, 45, $jst);




    $sql = 'select ';
    $sql .= '   idt, descricao  ';
    $sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S' ) ";
    $sql .= "   and idt = ".null($idt_ponto_atendimento);
    $sql .= ' order by classificacao ';
// $js = " disabled ";

    $js = " disabled style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";

    $vetCampo['idt_ponto_atendimento'] = objFixoBanco('idt_ponto_atendimento', 'Ponto de Atendimento', ''.db_pir.'sca_organizacao_secao', idt, 'descricao');




//$sql  = " select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";

    $sql = "select id_usuario, nome_completo  descricao from plu_usuario ";
    $sql .= " where matricula_intranet <> '' ";
    $sql .= " order by nome_completo";

    $js_hm = "";
    $style = "";
    $vetCampo['idt_responsavel_solucao'] = objCmbBanco('idt_responsavel_solucao', 'Responsável pela solução', false, $sql, ' ', $style, $js_hm);

//
// pegar gestor local da unidade de atendimento
//
//$sql  = " select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
//$sql .= " where plu_usu.id_usuario = ".null($_SESSION[CS]['g_idt_gestor_local']);

    $sql = '';
    $sql .= ' select u.id_usuario, u.nome_completo ';
    $sql .= ' from plu_usuario u';
    $sql .= ' inner join grc_evento_autorizador ea on ea.idt_autorizador = u.id_usuario and ea.idt_ponto_atendimento = '.null($idt_ponto_atendimento);
    $sql .= " where u.matricula_intranet <> ''";
    $sql .= ' order by u.nome_completo';

//
    $js_hm = " disabled ";
    $style = " width:400px; background:{$corbloq};";
    $vetCampo['idt_gestor_local'] = objCmbBanco('idt_gestor_local', 'Responsável Gestor', false, $sql, '', $style, $js_hm);


    $sql = " select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
    if ($acao != 'inc') {
        $sql .= " where plu_usu.id_usuario = ".null($idt_usuario);
    } else {
        
    }
//    $js_hm   = " disabled  ";
    $js_hm = " disabled style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";

    $vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Consultor', false, $sql, '', $style, $js_hm);

    $js = "";
    $vetCampo['data_dasolucao'] = objData('data_dasolucao', 'Data da Solução', False, $js, '', 'S');

    $js = " disabled style='background:{$corbloq};' ";
    $vetCampo['data_solucao'] = objData('data_solucao', 'Prazo de Resposta', False, $js, '', '');


    $js = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
    $vetCampo['data'] = objDatahora('data', $data_titulo, False, $js, 'S');

    $maxlength = 2000;
    $style = "width:100%;";
    $js = "";

    $vetCampo['observacao'] = objTextArea('observacao', $observacao_titulo, false, $maxlength, $style, $js);




    $jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
    $vetCampo['cod_cliente_siac'] = objTexto('cod_cliente_siac', 'Código Cliente', false, 15, 45, $jst);
    $jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
    $vetCampo['nome_cliente'] = objTexto('nome_cliente', 'Nome Cliente', false, 40, 120, $jst);

    $jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
    $vetCampo['cod_empreendimento_siac'] = objTexto('cod_empreendimento_siac', 'Código Empreendimento', false, 15, 45, $jst);
    $jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
    $vetCampo['nome_empreendimento'] = objTexto('nome_empreendimento', 'Nome Empreendimento', false, 50, 120, $jst);




    $maxlength = 5000;
    $style = "width:750px;";
    $js = "";
    $vetCampo['solucao'] = objTextArea('solucao', $solucao, false, $maxlength, $style, $js);
    $js = " disabled style='background:{$corbloq};' ";
    $vetCampo['enviar_email'] = objCmbVetor('enviar_email', 'Enviar E-mail?', false, $vetSimNao, ' ', $js);

    $maxlength = 255;
    $style = "width:100%; height:30px; ";
    $js = "";

    $vetCampo['assunto'] = objTextArea('assunto', $assunto_titulo, true, $maxlength, $style, $js);

    $js = " disabled style='background:{$corbloq};' ";
    $vetRecorrencia = Array();
    $vetRecorrencia[1] = "Um";
    $vetRecorrencia[3] = "Três";
    $vetRecorrencia[5] = "Cinco";
    $vetRecorrencia[7] = "Sete";
    $vetCampo['recorrencia'] = objCmbVetor('recorrencia', 'Recorrência?', false, $vetRecorrencia, ' ', $js);


    $vetCampo['botao_concluir_pendencia'] = objInclude('botao_concluir_pendencia', 'cadastro_conf/botao_concluir_pendencia.php');


    $class_frame_f = "class_frame_f";
    $class_titulo_f = "class_titulo_f";
    $class_frame_p = "class_frame_p";
    $class_titulo_p = "class_titulo_p";
    $class_frame = "class_frame";
    $class_titulo = "class_titulo";

    $class_titulo_c = "class_titulo_c";

    $titulo_na_linha = false;

    $vetFrm = Array();

    if ($tipo == 'Evento') {
        $vetParametros = Array(
            'codigo_frm' => 'informacoes',
            'controle_fecha' => false,
        );
        $vetFrm[] = Frame('<span>Informações', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
        $vetParametros = Array(
            'codigo_pai' => 'informacoes',
            'width' => '100%',
        );
        MesclarCol($vetCampo['assunto'], 9);
        MesclarCol($vetCampo['observacao'], 9);
        MesclarCol($vetCampo['nome_empreendimento'], 3);
        $vetFrm[] = Frame('<span>Assunto</span>', Array(
            Array($vetCampo['data'], '', $vetCampo['idt_usuario'], '', $vetCampo['idt_ponto_atendimento'], '', $vetCampo['protocolo'], '', $vetCampo['status']),
            Array($vetCampo['assunto']),
            Array($vetCampo['observacao']),
                ), $class_frame, $class_titulo, $titulo_na_linha);
        $vetParametros = Array(
            'codigo_frm' => 'opcao_tramitacao',
            'controle_fecha' => false,
        );
        $vetFrm[] = Frame('<span>OPÇÕES DE TRAMITAÇÃO', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
        $vetParametros = Array(
            'codigo_pai' => 'opcao_tramitacao',
            'width' => '100%',
        );
        MesclarCol($vetCampo['idt_gestor_local'], 5);
        $vetFrm[] = Frame('<span>Opções da Tramitação</span>', Array(
            Array($vetCampo['idt_gestor_local'], '', $vetCampo['enviar_email'], '', $vetCampo['recorrencia'], '', $vetCampo['data_solucao']),
                ), $class_frame, $class_titulo, $titulo_na_linha);
        MesclarCol($vetCampo['solucao'], 3);
        $vetFrm[] = Frame('<span>Resolução da pendência</span>', Array(
            Array($vetCampo['solucao']),
                ), $class_frame, $class_titulo, $titulo_na_linha);
        $vetFrm[] = Frame('', Array(
            Array($vetCampo['botao_concluir_pendencia']),
                ), $class_frame, $class_titulo, $titulo_na_linha);
    } else {
        $vetParametros = Array(
            'codigo_frm' => 'informacoes',
            'controle_fecha' => false,
        );
        $vetFrm[] = Frame('<span>Informações', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
        $vetParametros = Array(
            'codigo_pai' => 'informacoes',
            'width' => '100%',
        );
        MesclarCol($vetCampo['assunto'], 9);
        MesclarCol($vetCampo['observacao'], 9);
        MesclarCol($vetCampo['nome_empreendimento'], 3);

        $vetFrm[] = Frame('<span>Assunto</span>', Array(
            // Array($vetCampo[$CampoPricPai]),
            Array($vetCampo['data'], '', $vetCampo['idt_usuario'], '', $vetCampo['idt_ponto_atendimento'], '', $vetCampo['protocolo'], '', $vetCampo['status']),
            Array($vetCampo['cod_cliente_siac'], '', $vetCampo['nome_cliente'], '', $vetCampo['cod_empreendimento_siac'], '', $vetCampo['nome_empreendimento']),
            Array($vetCampo['assunto']),
            Array($vetCampo['observacao']),
                ), $class_frame, $class_titulo, $titulo_na_linha);

        $titulo = 'Anexos';
        $TabelaPrinc = "grc_atendimento_pendencia_anexo";
        $AliasPric = "grc_aa";
        $Entidade = "Anexo";
        $Entidade_p = "Anexos";

        $vetCampoLC = Array();
        $vetCampoLC['descricao'] = CriaVetTabela('Descrição');
        $vetCampoLC['arquivo'] = CriaVetTabela('Arquivo', 'arquivo', '', 'grc_atendimento_pendencia_anexo');

        $sql = "select {$AliasPric}.*  ";
        $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
        $sql .= " where {$AliasPric}".'.idt_atendimento_pendencia = $vlID';
        $sql .= " and {$AliasPric}.tipo = 'C'";
        $sql .= " order by {$AliasPric}.descricao";

        $vetParametros = Array(
            'menu_acesso' => 'grc_atendimento_pendencia_anexo',
            'contlinfim' => '',
            'barra_inc_ap' => false,
            'barra_alt_ap' => false,
            'barra_exc_ap' => false,
        );

        $vetCampo['grc_atendimento_pendencia_anexo_c'] = objListarConf('grc_atendimento_pendencia_anexo_c', 'idt', $vetCampoLC, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));

        $vetParametros = Array(
            'width' => '100%',
        );

        $vetFrm[] = Frame('', Array(
            Array($vetCampo['grc_atendimento_pendencia_anexo_c']),
                ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

        $vetParametros = Array(
            'codigo_frm' => 'opcao_tramitacao',
            'controle_fecha' => false,
        );
        $vetFrm[] = Frame('<span>OPÇÕES DE TRAMITAÇÃO', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
        $vetParametros = Array(
            'codigo_pai' => 'opcao_tramitacao',
            'width' => '100%',
        );


        MesclarCol($vetCampo['idt_gestor_local'], 5);
        $vetFrm[] = Frame('<span>Opções da Tramitação</span>', Array(
            Array($vetCampo['idt_gestor_local'], '', $vetCampo['enviar_email'], '', $vetCampo['recorrencia'], '', $vetCampo['data_solucao']),
                ), $class_frame, $class_titulo, $titulo_na_linha);


        $vetParametros = Array(
            'codigo_frm' => 'opcao_tramitacao',
            'controle_fecha' => false,
        );
        $vetFrm[] = Frame('<span>RESOLUÇÃO', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

        MesclarCol($vetCampo['solucao'], 3);
        $vetFrm[] = Frame('<span>Resolução da pendência</span>', Array(
            Array($vetCampo['data_dasolucao'], '', $vetCampo['idt_responsavel_solucao']),
            Array($vetCampo['solucao']),
                ), $class_frame, $class_titulo, $titulo_na_linha);

        $titulo = 'Anexos';
        $TabelaPrinc = "grc_atendimento_pendencia_anexo";
        $AliasPric = "grc_aa";
        $Entidade = "Anexo";
        $Entidade_p = "Anexos";

        $vetCampoLC = Array();
        $vetCampoLC['descricao'] = CriaVetTabela('Descrição');
        $vetCampoLC['arquivo'] = CriaVetTabela('Arquivo', 'arquivo', '', 'grc_atendimento_pendencia_anexo');
        $vetCampoLC['data'] = CriaVetTabela('Data do Envio', 'data');
        $vetCampoLC['email'] = CriaVetTabela('E-mail destinatário');
        //
        $sql = "select {$AliasPric}.*  ";
        $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
        $sql .= " where {$AliasPric}".'.idt_atendimento_pendencia = $vlID';
        $sql .= " and {$AliasPric}.tipo = 'R'";
        $sql .= " order by {$AliasPric}.descricao";

        $vetParametros = Array(
            'contlinfim' => '',
        );

        $vetCampo['grc_atendimento_pendencia_anexo'] = objListarConf('grc_atendimento_pendencia_anexo', 'idt', $vetCampoLC, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));

        $vetParametros = Array(
            'width' => '100%',
        );

        $vetFrm[] = Frame('', Array(
            Array($vetCampo['grc_atendimento_pendencia_anexo']),
                ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

        $vetFrm[] = Frame('', Array(
            Array($vetCampo['botao_concluir_pendencia']),
                ), $class_frame, $class_titulo, $titulo_na_linha);
    }



    $vetCad[] = $vetFrm;
    ?>
    <script type="text/javascript">
        //
        var idt_evento = '<?php echo $idt_evento; ?>';
        var idt_instrumento = '<?php echo $idt_instrumento; ?>';
        //
        $(document).ready(function () {
            objd = document.getElementById('idt_ponto_atendimento_tf');
            if (objd != null)
            {
                $(objd).css('background', '#FFFF80');
                $(objd).attr('disabled', 'disabled');
            }

            objd = document.getElementById('assunto');
            if (objd != null)
            {
                $(objd).css('background', '#FFFF80');
                $(objd).attr('disabled', 'disabled');
            }

            objd = document.getElementById('observacao');
            if (objd != null)
            {
                $(objd).css('background', '#FFFF80');
                $(objd).attr('disabled', 'disabled');
            }



        });

        function parListarConf_grc_atendimento_pendencia_anexo() {
            var par = '';
            par += '&tipo=R';
            return par;
        }
    </script>
    <?php
}    