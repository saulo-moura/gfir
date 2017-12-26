<!-- <lupe> <objeto> Inicio do Objeto -->
<?php
/* <lupe> <objeto>
  Documentação
  </lupe> */
?>
<!-- <lupe> <estilo>  Definição dos estilos para HTML -->
<style>
    div#grd1 {
        float: left;
        width: 25%;
        xheight:500px;
        xbackground-color: fuchsia;
        xborder-right:2px solid red;
        background-color: #ECF0F1;
        xoverflow:scroll;
        overflow-y: scroll;
    }

    div#grd2 {
        float: left;
        width: 75%;
        xbackground-color: lime;
    }

    div#grd3 {
        xfloat: left;
        xmargin-top:20px;
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
        text-align: left;
        background: #2C3E50;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
    }
    div.class_titulo_p span {
        padding-left:20px;
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


    Select {
        border: 0 none;
        min-height: 25px;
        padding-left: 3px;
        padding-right: 3px;
        padding-top: 5px;
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

    div.Barra td {
        height: 30px;
    }

    #idt_produto_interesse_desc img:last-child {
        display: none;
    }

    #idt_produto_interesse_obj ul {
        display: none;
    }

    #divProtocolo {
        color: #FFFFFF;
        font-weight: bold;
        float: right;
        padding-right: 10px;
        position: relative;
        font-size:12px;
        top: -19px;
    }    

    #bt_relogio {
        margin-left: 25px;
        cursor: pointer;
        vertical-align: middle;
    }

    Td.Titulo_radio {
        width: 64px;
    }

    #botao_concluir_atendimento_desc {
        text-align: center;
    }
</style>

<?php
/* <lupe> <raiz>
  Documentação
  </lupe> */


//p($_GET);
$grc_atendimento_pendencia_consulta = $_GET['grc_atendimento_pendencia_consulta'];

if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
}
$tabela = 'grc_atendimento';
$id = 'idt';

$vetPadraoLC = Array(
    'barra_inc_img' => "imagens/incluir_16.png",
    'barra_alt_img' => "imagens/alterar_16.png",
    'barra_con_img' => "imagens/consultar_16.png",
    'barra_exc_img' => "imagens/excluir_16.png",
);

//p($_GET);

$onSubmitCon = 'grc_atendimento_con()';
$onSubmitDep = 'grc_atendimento_dep()';

$vetConfMsg['alt'] = 'Para voltar a tela anterior necessário gravar as informações.\n\nConfirma?';

$bt_alterar_lbl = 'Voltar';
$bt_alterar_aviso = 'Não esqueça de clicar no botão FINALIZAR para salvar a sua alteração!';

$sql2 = 'select ';
$sql2 .= '  a.idt_atendimento_agenda, c.fechado, a.origem';
$sql2 .= '  from grc_atendimento a';
$sql2 .= ' left outer join grc_competencia c on c.idt = a.idt_competencia';
$sql2 .= '  where a.idt = ' . null($_GET['id']);
$rs_aap = execsql($sql2);
$row_aap = $rs_aap->data[0];


$origem = $row_aap['origem'];
$fechado = $row_aap['fechado'];

/*
  if ($row_aap['fechado'] == 'S' && monitor != 'S') {
  $acao = 'con';
  $_GET['acao'] = $acao;
  alert('Esse competência deste atendimento já foi fechada. Só pode Consultar.');
  }
 * 
 */

if ($_GET['pesquisa'] == 'S') {
    $idt_atendimento = $_GET['id'];
    $idt_atendimento_agenda = $row_aap['idt_atendimento_agenda'];

    if ($_GET['session_volta'] == '') {
        $_GET['session_volta'] = 'listar';
    }

    $sql = "update grc_atendimento set data_atendimento_relogio = 'N' where idt = " . null($idt_atendimento);
    execsql($sql);
}

if ($idt_atendimento_agenda == '') {
    $idt_atendimento_agenda = $_GET['idt_atendimento_agenda'];
}

if ($idt_atendimento == '') {
    $idt_atendimento = $_GET['idt_atendimento'];
}

$_GET['idt_atendimento'] = $idt_atendimento;
$_GET['idt_atendimento_agenda'] = $idt_atendimento_agenda;

$corbloq = "#FFFFD2";

$corbloq = "#F1F1F1";

$corbloq = "#ECF0F1";




$pendcon = 'N';
$status_pe = "";
$idt_atendimento_pendencia = $_GET['idt_atendimento_pendencia'];
if ($idt_atendimento_pendencia != "") {
    $sqlw = "select  ";
    $sqlw .= " grc_ap.status as grc_ap_status ";
    $sqlw .= " from grc_atendimento_pendencia grc_ap ";
	$sqlw .= " where idt = ".null($idt_atendimento_pendencia);
    $rsw = execsql($sqlw);
    ForEach ($rsw->data as $roww) {
        $status_pe = $roww['grc_ap_status'];
        //if (status_pe) == "Devolução para Ajustes"
    }
    $grc_atendimento_pendencia_consulta = $_GET['grc_atendimento_pendencia_consulta'];
    if ($grc_atendimento_pendencia_consulta != "") {
        // $par  = getParametro('menu,prefixo', false);
        //$par  = $_GET['parpencon'];
        // echo " par = $par "; 
        $par = "&RETNI=S";

        $vvpe = "conteudo.php?prefixo=listar&menu=grc_atendimento_pendencia_consulta" . $par;
        $botao_volta = " self.location='$vvpe'; ";
        $botao_volta_include = ' self.location="' . $vvpe . '" ';
        $botao_acao = '<script type="text/javascript">self.location=' . $vvpe . ';</script>';
        $acao = 'con';
        $pendcon = 'S';
    } else {
        $vvpe = "conteudo.php?prefixo=listar&menu=grc_atendimento_pendencia_m";
        $botao_volta = " self.location='$vvpe'; ";
        $botao_acao = '<script type="text/javascript">self.location=' . $vvpe . ';</script>';
    }
}
/*
  echo "----------------------------------------->> $status_pe ";
  p($_GET);
  exit();
 */


//p($_GET);


if ($_GET['veio'] == 255) {
    $instrumento = $_GET['instrumento2'];
}





if ($_GET['cont'] != 's') {
    if ($_GET['balcao'] == 2) {
        $instrumento = $_GET['instrumento2'];
        if ($instrumento == 1) {
            //    $acao='inc';
            //    $_GET['id']=0;
        }
        $html = ChamaInstrumentoContabiliza($instrumento);
        //echo $html;
    }
}
//p($_GET);
// if ($_GET['balcao']==2)
// {

$instrumento = $_GET['instrumento2'];

if ($instrumento == 1) {
    //      $acao='inc';
    //      $_GET['id']=0;
}
$html = ChamaInstrumentoContabiliza($instrumento);
//echo $html;
// }


$TabelaPai = "grc_atendimento_agenda";
$AliasPai = "grc_aa";
$EntidadePai = "Agenda";
$idPai = "idt";
//
$TabelaPrinc = "grc_atendimento";
$AliasPric = "grc_a";
$Entidade = "Atendimento da Agenda";
$Entidade_p = "Atendimentos da Agenda";
$CampoPricPai = "idt_atendimento_agenda";
//
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'assunto', 0);
//p($_GET);
$idt_cliente = 0;
$idt_ponto_atendimento = 0;
$idt_pessoa = 0;
$idt_projeto = 0;
$idt_projeto_acao = 0;
$idt_atendimento = $_GET['id'];
$inc_cont = $_GET['cont'];
$idt_ponto_atendimento = $_GET['idt0'];
// p($_GET);
// exit();
$codigo_tema = "";
$idt_tema_produto_interesse = "";


$CodParceiro = 0;

if ($acao != 'inc') {
    $sql = "select  ";
    $sql .= " grc_a.*, grc_a.cpf as grc_a_cpf, ";
    $sql .= " gestor, grc_ps.descricao as etapa, grc_ts.codigo as grc_ts_codigo  ";
    $sql .= " from grc_atendimento grc_a ";
    $sql .= " left join grc_projeto grc_p on grc_p.idt = grc_a.idt_projeto ";
    $sql .= " left join grc_projeto_situacao grc_ps on grc_ps.idt = grc_p.idt_projeto_situacao ";
    $sql .= " left join grc_tema_subtema grc_ts on grc_ts.idt = grc_a.idt_tema_tratado ";
    $sql .= " where grc_a.idt = {$idt_atendimento} ";
    $rs = execsql($sql);
    $wcodigo = '';
    ForEach ($rs->data as $row) {
        $idt_cliente = $row['idt_cliente'];
        $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
        $idt_pessoa = $row['idt_pessoa'];
        $idt_projeto = $row['idt_projeto'];
        $idt_projeto_acao = $row['idt_projeto_acao'];
        $idt_consultor = $row['idt_consultor'];
        if ($row['idt_instrumento'] != "") { // isso porque vindo do totem vem sem isso???
            $idt_instrumento = $row['idt_instrumento'];
        }
        $situacao = $row['situacao'];
        $gestor_sge = $row['gestor'];
        $fase_acao_projeto = $row['etapa'];
        $instrumento = $row['idt_instrumento'];
        $codigo_tema = $row['grc_ts_codigo'];
		
		//p($row);

        //
		$representa_empresa='N';
        $sqlw = "select  ";
		$sqlw .= " grc_ap.representa_empresa, ";
        $sqlw .= " grc_ap.codigo_siacweb as grc_ap_codigo_siacweb, ";
        $sqlw .= " grc_ap.cpf            as grc_ap_cpf ";
        $sqlw .= " from grc_atendimento_pessoa grc_ap ";
        $sqlw .= " where idt_atendimento = {$idt_atendimento} ";
        $sqlw .= "      and tipo_relacao = " . aspa('L');
        $rsw = execsql($sqlw);
        ForEach ($rsw->data as $roww) {
            $CodParceiro = $roww['grc_ap_codigo_siacweb'];
            $CPFCliente = $roww['grc_ap_cpf'];
			$representa_empresa = $roww['representa_empresa'];
            //$CPFCliente  = "";
        }
        if ($CodParceiro == "") {
            $CodParceiro = 0;
        }
		// se tem empresa relacionada
		$funil_idt_cliente_classificacao=8888;
		//echo "----------------------------------------------- ".$representa_empresa;
		$cliente_sem_classificacao  = 0;
        $msgClienteSemClassificacao = 'Cliente sem Classificação.\nEnviar Avaliação para o Cliente.';

		if ($representa_empresa=='S')
		{
			//
			$sqlw = "select  ";
			$sqlw .= " cnpj, ";
			$sqlw .= " funil_cliente_nota_avaliacao, ";
			$sqlw .= " funil_idt_cliente_classificacao ";
			$sqlw .= " from grc_atendimento_organizacao grc_ao ";
			$sqlw .= " where idt_atendimento = {$idt_atendimento} ";
			$sqlw .= "      and representa = " . aspa('S');
			$rsw = execsql($sqlw);
			ForEach ($rsw->data as $roww) {
				$funil_cliente_nota_avaliacao    = $roww['funil_cliente_nota_avaliacao'];
				$funil_idt_cliente_classificacao = $roww['funil_idt_cliente_classificacao'];
				$cnpj = $roww['cnpj']; 
			}
			//p($sqlw);
			$codigo = $cnpj;
			$vetRetorno=Array();
			BuscaClienteFunil($codigo,$vetRetorno);
			$idt_cliente_classificacao = $vetRetorno['idt_cliente_classificacao'];
	        $nota                      = $vetRetorno['nota'];
			$msgClienteSemClassificacao = $vetRetorno['msgClientesemClassificacao'];
			
			if ($idt_cliente_classificacao!='')
			{
				$funil_cliente_nota_avaliacao    = $nota;
				$funil_idt_cliente_classificacao = $idt_cliente_classificacao;
			}
			else
			{
				$funil_cliente_nota_avaliacao    = 0;
				$funil_idt_cliente_classificacao = 1;
			}
		}
		$cliente_sem_classificacao  = $funil_idt_cliente_classificacao;
		
		$cliente_sem_classificacao  = 3;
		$funil_idt_cliente_classificacao = 3;

        // para histórico
//        echo "  CodParceiro = $CodParceiro ----- CPFCliente = $CPFCliente";
        //      $CodParceiro=0;
    }



    if (($situacao == 'Finalizado') && $acao != 'con' && monitor != 'S') {

        if ($status_pe == "Devolução para Ajustes") {
            alert('Esse atendimento já foi ' . mb_strtoupper($situacao) . '. Foi Devolvido para Ajustes.');
        } else {
            $acao = 'con';
            $_GET['acao'] = $acao;
            alert('Esse atendimento já foi ' . mb_strtoupper($situacao) . '. Só pode Consultar.');
        }
    }

    if (($situacao == 'Finalizado' || $situacao == 'Cancelado') && $acao != 'con' && $_GET['pesquisa'] != 'S') {
        $acao = 'con';
        $_GET['acao'] = $acao;
        alert('Esse atendimento já foi ' . mb_strtoupper($situacao) . '. Só pode Consultar.');
    }
} else {

    $idt_consultor = $_SESSION[CS]['g_id_usuario'];
    //  $idt_ponto_atendimento     = $_SESSION[CS]['g_idt_unidade_regional'];
    $idt_projeto = $_SESSION[CS]['g_idt_projeto'];
    $idt_projeto_acao = $_SESSION[CS]['g_idt_acao'];
    $idt_instrumento = $instrumento;
    $gestor_sge = $_SESSION[CS]['g_projeto_gestor'];
    $fase_acao_projeto = $_SESSION[CS]['g_projeto_etapa'];

    if ($inc_cont != 's') {
        $datadia = date('d/m/Y H:i:s');
        $vet = explode(' ', $datadia);
        $data_inicial = trata_data($vet[0]);
        $hora_inicial = substr($vet[1], 0, 5);
        $idt_atendimentow = 0;
        //echo " t^entramdo <br />";
        // GeraAtendimentoHE($idt_consultor,$idt_ponto_atendimento,$data_inicial,$hora_inicial,$idt_instrumento,$idt_atendimentow);
        $idt_atendimento = $idt_atendimentow;
        // $_GET['id']      = $idt_atendimento;
        // $acao            = "alt";
        // $_GET['acao']    = $acao;
    }
}


if ($grc_atendimento_pendencia_consulta != "") {
    
} else {
    if ($_GET['pesquisa'] == 'S') {
        $par = getParametro('menu,prefixo', false);
        $href = "conteudo.php?prefixo=cadastro&menu=grc_atendimento_cadastro&menu_origem=" . $menu . $par;

        if ($acao == 'con') {
            $botao_volta_include = 'self.location = "' . $href . '"';
        } else {
            ?>
            <style type="text/css">
                input[type="submit"] {
                    display: none;
                }
            </style>
            <?php
        }

        $barra_bt_top = true;
        $mostra_bt_volta = true;
    } else {
        $href = "conteudo.php?prefixo=inc&menu=grc_atender_cliente&session_volta=" . $_GET['session_volta'] . "&idt_atendimento_agenda=" . $idt_atendimento_agenda . "&idt_atendimento=" . $idt_atendimento . "&id=" . $idt_atendimento_agenda . "&aba=1";
        $barra_bt_top = false;
        $mostra_bt_volta = false;
    }

    if ($botao_volta_include == '') {
        $botao_volta_include = 'self.location = "conteudo.php"';
    }

    $botao_acao = '<script type="text/javascript">self.location = "' . $href . '";</script>';
}
?>
<script>
    var acao = '<?php echo $acao; ?>';
    var inc_cont = '<?php echo $inc_cont; ?>';
</script>
<?php
//echo "  idt_instrumento = $idt_instrumento ---- instrumento = $idt_instrumento ";

$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; width:100%;' ";
$vetCampo_f['protocolo'] = objHidden('protocolo', '');
$vetCampo['senha_totem'] = objTexto('senha_totem', 'Senha', false, 20, 45, $jst);


$fixaunidade = 1;
if ($fixaunidade == 0) {   // Todos
    $sql = 'select ';
    $sql .= '   idt, descricao  ';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao sac_os ';
    $sql .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
    $sql .= ' order by classificacao ';
    $js = " ";
    $vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto de Atendimento', true, $sql, ' ', ' width:99%; font-size:12px;', $js);
} else {
    $sql = 'select ';
    $sql .= '   idt, descricao  ';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao sac_os ';
    $sql .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S' ) ";
    $sql .= "   and idt = " . null($idt_ponto_atendimento);
    $sql .= ' order by classificacao ';
    $js = " disabled ";
//    $vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto Atendimento', true, $sql,'','background:{$corbloq}; width:400px;  font-size:12px;',$js);
    $vetCampo['idt_ponto_atendimento'] = objFixoBanco('idt_ponto_atendimento', 'Ponto de Atendimento', '' . db_pir . 'sca_organizacao_secao', idt, 'descricao');
}

$sql = '';
$sql .= ' select idt, nome';
$sql .= ' from grc_atendimento_pessoa';
$sql .= ' where idt_atendimento = ' . null($_GET['id']);
$sql .= " and tipo_relacao = 'L'";
$rst = execsql($sql);
$rowt = $rst->data[0];

$vetCampo['idt_pessoa'] = objHidden('idt_pessoa', $rowt['idt'], 'Cliente', $rowt['nome']);

$sql = '';
$sql .= ' select idt, razao_social, data_fim_atividade';
$sql .= ' from grc_atendimento_organizacao';
$sql .= ' where idt_atendimento = ' . null($_GET['id']);
$sql .= " and representa = 'S'";
$sql .= " and desvincular = 'N'";
$rst = execsql($sql);
$rowt = $rst->data[0];
$data_fim_atividade = trata_data($rowt['data_fim_atividade']);

$vetCampo['idt_cliente'] = objHidden('idt_cliente', $rowt['idt'], 'Empreendimento', $rowt['razao_social']);

$fixaunidade = 0;

if ($_SESSION[CS]['g_atendimento_digitador'] == 'S' && $idt_instrumento != 2) {
    $sql = "select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
    $sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt_usuario = plu_usu.id_usuario ";
    $sql .= " where grc_pap.idt_ponto_atendimento = " . null($idt_ponto_atendimento);
    $sql .= " order by plu_usu.nome_completo";
    $vetCampo['idt_consultor'] = objCmbBanco('idt_consultor', 'Consultor/Atendente', true, $sql, ' ', 'width: 360px;');
} else {
    $vetCampo['idt_consultor'] = objFixoBanco('idt_consultor', 'Consultor/Atendente', 'plu_usuario', 'id_usuario', 'nome_completo');
}



$maxlength = 2000;
$style = "width:830px; ";
$js = "";
$vetCampo['assunto'] = objTextArea('assunto', 'Resumo do Assunto', false, $maxlength, $style, $js);


$maxlength = 2000;
$style = "width:99%; ";
$js = "";
if ($instrumento == 8 or $instrumento == 13) {
    $vetCampo['demanda'] = objTextArea('demanda', 'Demandas, Necessidades e Comentários', true, $maxlength, $style, $js);
} else {
    $vetCampo['demanda'] = objTextArea('demanda', 'Demandas, Necessidades e Comentários', false, $maxlength, $style, $js);
}

$maxlength = 2000;
$style = "width:99%; ";
$js = "";
if ($instrumento == 2) {
    if ($origem != "D") {
        $vetCampo['diagnostico'] = objTextArea('diagnostico', 'Diagnóstico', true, $maxlength, $style, $js);
    } else {
        $campo = 'diagnostico';
        $nome = 'Demanda do Cliente';
        $valida = 'true';
        $altura = '180';
        $largura = '350';
        $js = '';
        $barra_aberto = false;
        $barra_simples = true;
        $campo_fixo = false;
        $vl_padrao = '';
        $campo_tabela = true;
        $vetCampo[$campo] = objHtml($campo, $nome, $valida, $altura, $largura, $js, $barra_aberto, $barra_simples, $campo_fixoe, $vl_padrao, $campo_tabela);
    }
} else {
    $vetCampo['diagnostico'] = objTextArea('diagnostico', 'Diagnóstico', false, $maxlength, $style, $js);
}





$maxlength = 2000;
$style = "width:99%; ";
$js = "";
if ($origem != "D") {
    $vetCampo['devolutiva'] = objTextArea('devolutiva', 'Devolutiva', true, $maxlength, $style, $js);
} else {
    $campo = 'devolutiva';
    $nome = 'Diagnóstico Realizado pelo Consultor';
    $valida = 'true';
    $altura = '180';
    $largura = '350';
    $js = '';
    $barra_aberto = false;
    $barra_simples = true;
    $campo_fixo = false;
    $vl_padrao = '';
    $campo_tabela = true;
    $vetCampo[$campo] = objHtml($campo, $nome, $valida, $altura, $largura, $js, $barra_aberto, $barra_simples, $campo_fixoe, $vl_padrao, $campo_tabela);
}

// Campos novos

if ($origem == "D" and $instrumento == 2) {
    $sql = "select grc_aam.idt, grc_aam.descricao from grc_atendimento_modalidade grc_aam ";
    $sql .= " order by grc_aam.codigo";
    $js_hm = " style='background:{$corbloq}; font-size:12px; width:99%;' ";
    $vetCampo['idt_modalidade'] = objCmbBanco('idt_modalidade', 'Modalidade de Atendimento', false, $sql, '', '', $js_hm);


    $sql = "select grc_ae.idt, grc_ae.descricao from grc_atendimento_especialidade grc_ae ";
    $sql .= " where tipo_atendimento = 'D'";
    $sql .= " order by grc_ae.codigo";
    $js_hm = " style='background:{$corbloq}; font-size:12px; width:99%;' ";
    $vetCampo['idt_servico'] = objCmbBanco('idt_servico', 'Serviço', true, $sql, ' ', '', $js_hm);

    $campo = 'recomendacao';
    $nome = 'Recomendações/Orientações feitas pelo Consultor';
    $valida = 'true';
    $altura = '180';
    $largura = '350';
    $js = '';
    $barra_aberto = false;
    $barra_simples = true;
    $campo_fixo = false;
    $vl_padrao = '';
    $campo_tabela = true;
    $vetCampo[$campo] = objHtml($campo, $nome, $valida, $altura, $largura, $js, $barra_aberto, $barra_simples, $campo_fixoe, $vl_padrao, $campo_tabela);

    $campo = 'solucao_sebrae';
    $nome = 'Solução Sebrae indicada';
    $valida = 'true';
    $altura = '180';
    $largura = '350';
    $js = '';
    $barra_aberto = false;
    $barra_simples = true;
    $campo_fixo = false;
    $vl_padrao = '';
    $campo_tabela = true;
    $vetCampo[$campo] = objHtml($campo, $nome, $valida, $altura, $largura, $js, $barra_aberto, $barra_simples, $campo_fixoe, $vl_padrao, $campo_tabela);
}

//$jst = " readonly='true' style='background:{$corbloq}; font-size:12px;' ";
//$vetCampo_f['situacao'] = objTexto('situacao', 'Situação', false, 20, 45, $jst);
$vetCampo_f['situacao'] = objHidden('situacao', '');

// dados cadastro da pessoa

if ($idt_pessoa > 0) {
    $jst = " readonly='true' style='background:{$corbloq}; font-size:12px;' ";
} else {
    $jst = "  ChamaCPFEspecial(this)  ";
}
$vetCampo['cpf'] = objCPF('cpf', 'CPF', false, true, '', $jst);
$vetCampo['nome_pessoa'] = objTexto('nome_pessoa', 'Nome Completo', true, 60, 120);


$vetParametros = Array(
    'consulta_cep' => true,
    'campo_pais' => 'pessoa_pais',
    'campo_uf' => 'pessoa_estado',
    'campo_cidade' => 'pessoa_cidade',
    'campo_bairro' => 'pessoa_bairro',
    'campo_logradouro' => 'pessoa_rua',
);
$vetCampo['pessoa_cep'] = objCEP('pessoa_cep', 'CEP', True, $vetParametros);
$vetCampo['pessoa_rua'] = objTexto('pessoa_rua', 'Rua', true, 35, 120);
$vetCampo['pessoa_numero'] = objTexto('pessoa_numero', 'Número', true, 10, 45);
$vetCampo['pessoa_complemento'] = objTexto('pessoa_complemento', 'Complemento', true, 15, 120);
$vetCampo['pessoa_bairro'] = objTexto('pessoa_bairro', 'Bairro', true, 15, 120);
$vetCampo['pessoa_cidade'] = objTexto('pessoa_cidade', 'Cidade', true, 15, 120);
$vetCampo['pessoa_estado'] = objTexto('pessoa_estado', 'Estado', true, 2, 2);
$vetCampo['pessoa_pais'] = objTexto('pessoa_pais', 'País', true, 10, 120);


$vetCampo['pessoa_data_nascimento'] = objData('pessoa_data_nascimento', 'Data Nascimento', true);
$vetSexo = Array();
$vetSexo['M'] = 'Masculino';
$vetSexo['F'] = 'Feminino';
$vetCampo['pessoa_sexo'] = objCmbVetor('pessoa_sexo', 'Sexo', True, $vetSexo, ' ');

$vetCampo['pessoa_telefone_residencial'] = objTelefone('pessoa_telefone_residencial', 'Telefone residencial', true, 45);
$vetCampo['pessoa_telefone_celular'] = objTelefone('pessoa_telefone_celular', 'Telefone celular', true, 45);
$vetCampo['pessoa_telefone_recado'] = objTelefone('pessoa_telefone_recado', 'Telefone recado', true, 45);

$vetCampo['pessoa_email'] = objEmail('pessoa_email', 'EMAIL', true, 50, 120, 'S');
$vetCampo['receber_informacoes'] = objCmbVetor('receber_informacoes', 'Receber Informações?', True, $vetSimNao, ' ');


$sql = "select grc_as.idt, grc_as.descricao from grc_atendimento_segmentacao grc_as ";
$sql .= " order by grc_as.codigo";
$js_hm = " disabled style='padding-left:20px; width:800px; background:#0000FF; color:#FFFFFF; text-align:center; font-size:12px;' ";
$js_hm = "";
$vetCampo['idt_segmentacao'] = objCmbBanco('idt_segmentacao', 'Segmentação', false, $sql, ' ', 'width:200px;', $js_hm);
$sql = "select grc_as.idt, grc_as.descricao from grc_atendimento_subsegmentacao grc_as ";
$sql .= " order by grc_as.codigo";
$js_hm = " disabled style='padding-left:20px; width:800px; background:#0000FF; color:#FFFFFF; text-align:center; font-size:12px;' ";
$js_hm = "";
$vetCampo['idt_subsegmentacao'] = objCmbBanco('idt_subsegmentacao', 'Subsegmentação', false, $sql, ' ', 'width:200px;', $js_hm);
$sql = "select grc_pf.idt, grc_pf.descricao from grc_atendimento_programa_fidelidade grc_pf ";
$sql .= " order by grc_pf.codigo";
$js_hm = " disabled style='padding-left:20px; width:800px; background:#0000FF; color:#FFFFFF; text-align:center; font-size:12px;' ";
$js_hm = "";
$vetCampo['idt_programa_fidelidade'] = objCmbBanco('idt_programa_fidelidade', 'Programa Fidelidade', false, $sql, ' ', 'width:200px;', $js_hm);
$vetCampo['pessoa_representante'] = objCmbVetor('pessoa_representante', 'Representante de Empresa?', True, $vetSimNao, ' ');


$vetCampo['potencial_personagem'] = objCmbVetor('potencial_personagem', 'Potencial Personagem?', True, $vetSimNao, ' ');


$vetCampo['interesse_tema'] = objTexto('interesse_tema', 'Interesse Temas', true, 1, 1);
$vetCampo['interesse_produto'] = objTexto('interesse_produto', 'Interesse Produtos', true, 1, 1);


$sql = "select gec_ge.idt, gec_ge.descricao from " . db_pir_gec . "gec_entidade_grau_formacao gec_ge ";
$sql .= " order by gec_ge.codigo";
$js_hm = " disabled style='padding-left:20px; width:800px; background:#0000FF; color:#FFFFFF; text-align:center; font-size:12px;' ";
$js_hm = "";
$vetCampo['idt_escolaridade'] = objCmbBanco('idt_escolaridade', 'Escolaridade', false, $sql, ' ', 'width:200px;', $js_hm);



$sql = "select gec_op.idt, gec_op.descricao from " . db_pir_gec . "gec_organizacao_porte gec_op ";
$sql .= " order by gec_op.codigo";
$js_hm = " disabled style='padding-left:20px; width:800px; background:#0000FF; color:#FFFFFF; text-align:center; font-size:12px;' ";
$js_hm = "";
$vetCampo['idt_porte'] = objCmbBanco('idt_porte', 'Porte', false, $sql, ' ', 'width:200px;', $js_hm);

if ($idt_cliente > 0) {
    $jst = " readonly='true' style='background:{$corbloq}; font-size:12px;' ";
} else {
    $jst = "  ChamaCNPJEspecial(this)  ";
}

// dados cadastro da empreendimento


$vetCampo['cnpj'] = objCNPJ('cnpj', 'CNPJ do Empreendimento', false, true, 15);
$vetCampo['nome_empresa'] = objTexto('nome_empresa', 'Nome completo da empresa', false, 45, 120);

$vetParametros = Array(
    'consulta_cep' => true,
    'campo_pais' => 'organizacao_pais',
    'campo_uf' => 'organizacao_estado',
    'campo_cidade' => 'organizacao_cidade',
    'campo_bairro' => 'organizacao_bairro',
    'campo_logradouro' => 'organizacao_rua',
);
$vetCampo['organizacao_cep'] = objCEP('organizacao_cep', 'CEP', false, $vetParametros);
$vetCampo['organizacao_rua'] = objTexto('organizacao_rua', 'Rua', false, 35, 120);
$vetCampo['organizacao_numero'] = objTexto('organizacao_numero', 'Número', false, 10, 45);
$vetCampo['organizacao_complemento'] = objTexto('organizacao_complemento', 'Complemento', false, 15, 120);
$vetCampo['organizacao_bairro'] = objTexto('organizacao_bairro', 'Bairro', false, 15, 120);
$vetCampo['organizacao_cidade'] = objTexto('organizacao_cidade', 'Cidade', false, 15, 120);
$vetCampo['organizacao_estado'] = objTexto('organizacao_estado', 'Estado', false, 2, 120);
$vetCampo['organizacao_pais'] = objTexto('organizacao_pais', 'País', false, 10, 120);
$sql = "select grc_aet.idt, grc_aet.descricao from grc_atendimento_empreendimento_tipo grc_aet ";
$sql .= " order by grc_aet.codigo";
$js_hm = " disabled style='padding-left:20px; width:800px; background:#0000FF; color:#FFFFFF; text-align:center; font-size:12px;' ";
$js_hm = "";
$vetCampo['idt_tipo_empreendimento'] = objCmbBanco('idt_tipo_empreendimento', 'Tipo de Empreendimento', false, $sql, '', 'width:150px;', $js_hm);
$sql = "select grc_aes.idt, grc_aes.descricao from grc_atendimento_empreendimento_setor grc_aes ";
$sql .= " order by grc_aes.codigo";
$js_hm = " disabled style='padding-left:20px; width:800px; background:#0000FF; color:#FFFFFF; text-align:center; font-size:12px;' ";
$js_hm = "";
$vetCampo['idt_setor'] = objCmbBanco('idt_setor', 'Setor do Empreendimento', false, $sql, '', 'width:150px;', $js_hm);
$vetCampo['optante_simples'] = objCmbVetor('optante_simples', 'Optante do Simples?', True, $vetSimNao, ' ');
$vetCampo['organizacao_dap'] = objTexto('organizacao_dap', 'DAP', false, 15, 45);
$vetCampo['organizacao_rmp'] = objTexto('organizacao_rmp', 'RMP', false, 15, 45);
$vetCampo['organizacao_nirf'] = objTexto('organizacao_nirf', 'NIRF', false, 15, 45);
$vetCampo['organizacao_telefone_comercial'] = objTelefone('organizacao_telefone_comercial', 'Telefone comercial', false, 15);
$vetCampo['organizacao_email_comercial'] = objEmail('organizacao_email_comercial', 'EMAIL', false, 25, 120, 'S');
$vetCampo['organizacao_site_url'] = objUrl('organizacao_site_url', 'Site/URL', false, 25, 120, 'S');
$vetCampo['organizacao_nome_fantasia'] = objTexto('organizacao_nome_fantasia', 'Nome Fantasia', false, 45, 120);




$vetCampo['organizacao_data_abertura'] = objData('organizacao_data_abertura', 'Data Abertura', false);
$vetCampo['optante_simples'] = objCmbVetor('optante_simples', 'Optante do Simples?', false, $vetSimNao, ' ');

$vetCampo['organizacao_pessoas_ocupadas'] = objInteiro('organizacao_pessoas_ocupadas', 'Pessoas Ocupadas', false, 10);


// projeto

$vetCampo['idt_projeto'] = objListarCmb('idt_projeto', 'grc_projeto', 'Projeto', true, '442px');

$vetCampo['idt_projeto_acao'] = objListarCmb('idt_projeto_acao', 'grc_projeto_acao', 'Ação do Projeto', true, '442px');

$vetCampo['gestor_sge'] = objTextoFixo('gestor_sge', 'Gestor SGE', 60, true);
$vetCampo['fase_acao_projeto'] = objTextoFixo('fase_acao_projeto', 'Fase', 60, true);

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

$vetCampo['idt_instrumento'] = objFixoBanco('idt_instrumento', '', 'grc_atendimento_instrumento', 'idt', 'descricao');




//$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);

/*
  idt_canal
  idt_categoria
  mome_realizacao
  inicio_realizacao
  termino_realizacao
  numero_pessoas_informadas
  idt_tipo_realizacao
 */


$vetCampo['idt_competencia'] = objFixoBanco('idt_competencia', 'Competência', 'grc_competencia', 'idt', 'texto');


//
// Tema Tratado
//
$sql = "select grc_ts.idt,  grc_ts.descricao from grc_tema_subtema grc_ts ";
$sql .= " where grc_ts.nivel =  0 ";
$sql .= " and ativo = 'S'";
$sql .= " order by  grc_ts.descricao";
$js_hm = " style='background:{$corbloq}; font-size:12px; width:99%;' ";
$vetCampo['idt_tema_tratado'] = objCmbBanco('idt_tema_tratado', 'Tema Tratado', false, $sql, ' ', '', $js_hm);
//
// SubTema Tratado
//
$sql = "select grc_ts.idt,  grc_ts.descricao from grc_tema_subtema grc_ts ";
$sql .= " where grc_ts.nivel  =  1 ";
$sql .= "   and substring(grc_ts.codigo,1,3) =  " . aspa($codigo_tema . '.');
$sql .= " and ativo = 'S'";
$sql .= " order by  grc_ts.descricao";
$js_hm = " style='background:{$corbloq}; font-size:12px; width:99%;' ";
$vetCampo['idt_subtema_tratado'] = objCmbBanco('idt_subtema_tratado', 'Subtema Tratado', false, $sql, ' ', '', $js_hm);
//
//
//
$sql = "select grc_ts.idt,  grc_ts.descricao from grc_tema_subtema grc_ts ";
$sql .= " where grc_ts.nivel =  0 ";
$sql .= " and ativo = 'S'";
$sql .= " order by  grc_ts.descricao";
$js_hm = " style='background:{$corbloq}; font-size:12px; width:100%;' ";
$vetCampo['idt_tema_interesse'] = objCmbBanco('idt_tema_interesse', 'Temas de Interesse', false, $sql, ' ', 'width:100%;', $js_hm);

$sql = "select grc_ts.idt,  grc_ts.descricao from grc_tema_subtema grc_ts ";
$sql .= " where grc_ts.nivel  =  1 ";
$sql .= "   and substring(grc_ts.codigo,1,3) =  " . aspa($codigo_tema . '.');
$sql .= " and ativo = 'S'";
$sql .= " order by  grc_ts.descricao";
$js_hm = " style='background:{$corbloq}; font-size:12px; width:400px;' ";
$vetCampo['idt_subtema_interesse'] = objCmbBanco('idt_subtema_interesse', 'Subtema Interesse', false, $sql, ' ', 'width:100%;', $js_hm);


$codigo_tema_produto = '';

$sql = "select grc_ts.idt,  grc_ts.descricao from grc_tema_subtema grc_ts ";
$sql .= " where grc_ts.nivel =  0 ";
$sql .= " and ativo = 'S'";
$sql .= " order by  grc_ts.descricao";
$js_hm = " style='background:{$corbloq}; font-size:12px; width:400px;' ";
$vetCampo['idt_tema_produto_interesse'] = objCmbBanco('idt_tema_produto_interesse', 'Tema Produto Interesse', false, $sql, ' ', 'width:100%;', $js_hm);

$sql = "select grc_p.idt,  grc_p.descricao from grc_produto grc_p ";
$sql .= " order by  grc_p.descricao";
$js_hm = " style='background:{$corbloq}; font-size:12px; width:100%;' ";
//$vetCampo_t['idt_produto_interesse'] = objCmbBanco('idt_produto_interesse', 'Produto Interesse', false, $sql,' ','width:100%;',$js_hm);

$vetRetorno = Array(
    vetRetorno('idt', '', false),
    vetRetorno('descricao2', '', true),
);

$vetCampo['idt_produto_interesse'] = objListarCmbMulti('idt_produto_interesse', 'grc_produto_cmb', 'Produtos de Interesse', false, '', '', '', $vetRetorno);




/*
  idt_canal
  idt_categoria
  mome_realizacao
  inicio_realizacao
  termino_realizacao
  numero_pessoas_informadas
  idt_tipo_realizacao
 */

$sql = "select grc_pcm.idt,  grc_pcm.descricao from grc_produto_canal_midia grc_pcm ";
$sql .= " order by  grc_pcm.descricao";
$js_hm = " width:100%;' ";
$vetCampo['idt_canal'] = objCmbBanco('idt_canal', 'Canal de Informação', true, $sql, ' ', 'width:100%;', $js_hm);

$sql = "select grc_ac.idt,  grc_ac.descricao from grc_atendimento_categoria grc_ac ";
$sql .= " order by  grc_ac.descricao";
$js_hm = " width:100%;' ";
$vetCampo['idt_categoria'] = objCmbBanco('idt_categoria', 'Categoria', true, $sql, ' ', 'width:100%;', $js_hm);

$vetCampo['mome_realizacao'] = objTexto('mome_realizacao', 'Nome Realização', true, 90, 120);


$jst = "";
$vetCampo['inicio_realizacao'] = objData('inicio_realizacao', 'Data Inicio', true, $jst);

$jst = "";
$vetCampo['termino_realizacao'] = objData('termino_realizacao', 'Data Término', true, $jst);

$vetCampo['numero_pessoas_informadas'] = objInteiro('numero_pessoas_informadas', 'Número de Pessoas Informadas', true, 10);

$sql = "select grc_atr.idt,  grc_atr.descricao from grc_atendimento_tipo_realizacao grc_atr ";
$sql .= " order by  grc_atr.descricao";
$js_hm = " width:100%;' ";
$vetCampo['idt_tipo_realizacao'] = objCmbBanco('idt_tipo_realizacao', 'Tipo de Realização', false, $sql, ' ', 'width:100%;', $js_hm);


$vetCampo['data_atendimento_aberta'] = objHidden('data_atendimento_aberta', '');
$vetCampo['data_atendimento_relogio'] = objHidden('data_atendimento_relogio', '');

//$jst    = " xreadonly='true' style='background:{$corbloq}; font-size:12px;' ";

$jst = "";
$vetCampo['data'] = objData('data', 'Data do Atendimento', False, $jst);

$vetCampo['data_inicio_atendimento'] = objDatahora('data_inicio_atendimento', 'Data Inicio Atendimento', False);
$vetCampo['data_termino_atendimento'] = objDatahora('data_termino_atendimento', 'Data Termino Atendimento', False);


$vetCampo['primeiro'] = objTexto('primeiro', 'Primeiro?', false, 3, 3);





$js_hm = " xreadonly='true' style='background:{$corbloq}; font-size:12px;' ";
$vetCampo['hora_inicio_atendimento'] = objHora('hora_inicio_atendimento', 'Hora Inicial', false, $js_hm);
$js_hm = " xreadonly='true' style='background:{$corbloq}; font-size:12px;' ";
$vetCampo['hora_termino_atendimento'] = objHora('hora_termino_atendimento', 'Hora Final', false, $js_hm);
$js = " disabled='true' readonly='true' style='background:{$corbloq}; font-size:12px;' ";
$vetCampo['horas_atendimento'] = objDecimal('horas_atendimento', 'Duração (m.)', false, 5, '', 0, $js);




$vetCampo['bia'] = objInclude('bia', 'cadastro_conf/bia_atendimento.php');

$vetCampo_f['botao_concluir_atendimento'] = objInclude('botao_concluir_atendimento', 'cadastro_conf/botao_concluir_atendimento.php');

$vetCampo['botao_barra_tarefa_atendimento'] = objInclude('botao_barra_tarefa_atendimento', 'cadastro_conf/botao_barra_tarefa_atendimento.php');

$vetCampo['botao_inc_temainteresse'] = objInclude('botao_inc_temainteresse', 'cadastro_conf/botao_inc_temainteresse.php');

$vetCampo['botao_inc_tematratado'] = objInclude('botao_inc_tematratado', 'cadastro_conf/botao_inc_tematratado.php');


$vetCampow = $vetCampo;

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$titulo_cadastro = "REGISTRO DO ATENDIMENTO";

$vetFrm = Array();


/*
  $vetParametros = Array(
  'situacao_padrao' => true,
  );
  $vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

  // Definição de um frame ou seja de um quadro da tela para agrupar campos

  $vetParametros = Array(
  'codigo_frm' => 'parte01',
  'controle_fecha' => 'A',
  );


  $vetFrm[] = Frame('<span>01 - IDENTIFICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

  $vetParametros = Array(
  'codigo_pai' => 'parte01',
  );
 */

$vetFrm[] = Frame('', Array(
    Array($vetCampo['data_atendimento_aberta']),
    Array($vetCampo['data_atendimento_relogio']),
        ), $class_frame, $class_titulo, false);

//p($_GET);
//echo " instrumento = $instrumento ";
// INFORMAÇÃO
//if ($instrumento==1)    // 09/10/2015
if ($instrumento == 8) {
    MesclarCol($vetCampo['botao_barra_tarefa_atendimento'], 3);
    MesclarCol($vetCampo['idt_instrumento'], 3);
    MesclarCol($vetCampo['demanda'], 3);
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_instrumento']),
        Array($vetCampo['idt_projeto'], '', $vetCampo['gestor_sge']),
        Array($vetCampo['idt_projeto_acao'], '', $vetCampo['fase_acao_projeto']),
        Array($vetCampo['idt_pessoa'], '', $vetCampo['idt_cliente']),
            ), $class_frame, $class_titulo, false, $vetParametros);


    // inicio
    $vetCad[] = $vetFrm;
    $vetFrm = Array();

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['bia']),
            ), $class_frame, $class_titulo, false, $vetParametros);

    $vetCad[] = $vetFrm;
    $vetFrm = Array();

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['botao_barra_tarefa_atendimento']),
            ), $class_frame, $class_titulo, false, $vetParametros);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_ponto_atendimento'], '', $vetCampo['idt_consultor']),
            ), $class_frame, $class_titulo, false, $vetParametros);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['data'], '', $vetCampo['hora_inicio_atendimento'], '', $vetCampo['hora_termino_atendimento'], '', $vetCampo['horas_atendimento'], '', $vetCampo['idt_competencia']),
            ), $class_frame, $class_titulo, false, $vetParametros);

    //$vetFrm[] = Frame('', Array(
    //    Array($vetCampo['idt_tema_tratado'],'',$vetCampo['idt_subtema_tratado']),
    //),$class_frame,$class_titulo,false,$vetParametros);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['demanda']),
            ), $class_frame, $class_titulo, false, $vetParametros);

    //$vetCad[] = $vetFrm;
    //$vetFrm = Array();
}






// ORIENTAÇÃO TÉCNICA
//if ($instrumento==2)
if ($instrumento == 13) {
    MesclarCol($vetCampo['botao_barra_tarefa_atendimento'], 3);
    MesclarCol($vetCampo['idt_instrumento'], 3);
    MesclarCol($vetCampo['demanda'], 3);
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_instrumento']),
        Array($vetCampo['idt_projeto'], '', $vetCampo['gestor_sge']),
        Array($vetCampo['idt_projeto_acao'], '', $vetCampo['fase_acao_projeto']),
        Array($vetCampo['idt_pessoa'], '', $vetCampo['idt_cliente']),
            ), $class_frame, $class_titulo, false, $vetParametros);


    // inicio
    $vetCad[] = $vetFrm;
    $vetFrm = Array();

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['bia']),
            ), $class_frame, $class_titulo, false, $vetParametros);

    $vetCad[] = $vetFrm;
    $vetFrm = Array();

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['botao_barra_tarefa_atendimento']),
            ), $class_frame, $class_titulo, false, $vetParametros);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_ponto_atendimento'], '', $vetCampo['idt_consultor']),
            ), $class_frame, $class_titulo, false, $vetParametros);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['data'], '', $vetCampo['hora_inicio_atendimento'], '', $vetCampo['hora_termino_atendimento'], '', $vetCampo['horas_atendimento'], '', $vetCampo['idt_competencia']),
            ), $class_frame, $class_titulo, false, $vetParametros);

    //$vetFrm[] = Frame('', Array(
    //    Array($vetCampo['idt_tema_tratado'],'',$vetCampo['idt_subtema_tratado']),
    //),$class_frame,$class_titulo,false,$vetParametros);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['demanda']),
            ), $class_frame, $class_titulo, false, $vetParametros);


    //$vetCad[] = $vetFrm;
    //$vetFrm = Array();
}

// CONSULTORIA bALCÃO
//if ($instrumento==3)
if ($instrumento == 2) {
    MesclarCol($vetCampo['botao_barra_tarefa_atendimento'], 3);
    MesclarCol($vetCampo['idt_instrumento'], 3);
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_instrumento']),
        Array($vetCampo['idt_projeto'], '', $vetCampo['gestor_sge']),
        Array($vetCampo['idt_projeto_acao'], '', $vetCampo['fase_acao_projeto']),
        Array($vetCampo['idt_pessoa'], '', $vetCampo['idt_cliente']),
            ), $class_frame, $class_titulo, false, $vetParametros);


    // inicio
    $vetCad[] = $vetFrm;
    $vetFrm = Array();

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['bia']),
            ), $class_frame, $class_titulo, false, $vetParametros);

    $vetCad[] = $vetFrm;
    $vetFrm = Array();

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['botao_barra_tarefa_atendimento']),
            ), $class_frame, $class_titulo, false, $vetParametros);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_ponto_atendimento'], '', $vetCampo['idt_consultor']),
            ), $class_frame, $class_titulo, false, $vetParametros);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['data'], '', $vetCampo['hora_inicio_atendimento'], '', $vetCampo['hora_termino_atendimento'], '', $vetCampo['horas_atendimento'], '', $vetCampo['idt_competencia']),
            ), $class_frame, $class_titulo, false, $vetParametros);

    if ($origem == "D") {
        $vetFrm[] = Frame('', Array(
            Array($vetCampo['idt_tema_tratado'], '', $vetCampo['idt_subtema_tratado'], '', $vetCampo['idt_modalidade'], '', $vetCampo['idt_servico']),
                ), $class_frame, $class_titulo, false, $vetParametros);
        $vetFrm[] = Frame('', Array(
            Array($vetCampo['diagnostico'], '', $vetCampo['devolutiva']),
            Array($vetCampo['recomendacao'], '', $vetCampo['solucao_sebrae']),
                ), $class_frame, $class_titulo, false, $vetParametros);
    } else {
        $vetFrm[] = Frame('', Array(
            Array($vetCampo['idt_tema_tratado'], '', $vetCampo['idt_subtema_tratado']),
                ), $class_frame, $class_titulo, false, $vetParametros);
        $vetFrm[] = Frame('', Array(
            Array($vetCampo['diagnostico'], '', $vetCampo['devolutiva']),
                ), $class_frame, $class_titulo, false, $vetParametros);
    }

    //$vetCad[] = $vetFrm;
    //$vetFrm = Array();
}


/*
  $comcadastro=0; // Não mostrar cadastros
  if ($comcadastro==1)
  {
  $vetParametros = Array(
  'codigo_frm' => 'parte02',
  'controle_fecha' => 'A',
  );
  $vetFrm[] = Frame('<span>01.01 - CADASTRO DE PESSOA</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
  $vetParametros = Array(
  'codigo_pai' => 'parte02',
  );
  //MesclarCol($vetCampo['assunto'], 3);
  MesclarCol($vetCampo['idt_pessoa'], 5);
  MesclarCol($vetCampo['nome_pessoa'], 5);
  $vetFrm[] = Frame('<span>Identificação</span>', Array(
  Array($vetCampo['cpf'],'',$vetCampo['idt_pessoa']),
  Array('','',$vetCampo['nome_pessoa']),
  Array('','',$vetCampo['pessoa_data_nascimento'],'',$vetCampo['pessoa_sexo'],'',$vetCampo['idt_escolaridade']),
  ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
  $vetFrm[] = Frame('<span>Endereço</span>', Array(
  Array($vetCampo['pessoa_cep'],'',$vetCampo['pessoa_rua'],'',$vetCampo['pessoa_numero'],'',$vetCampo['pessoa_complemento']),
  Array($vetCampo['pessoa_bairro'],'',$vetCampo['pessoa_cidade'],'',$vetCampo['pessoa_estado'],'',$vetCampo['pessoa_pais']),
  ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
  //MesclarCol($vetCampo['pessoa_email'], 5);
  $vetFrm[] = Frame('<span>Comunicação</span>', Array(
  Array($vetCampo['pessoa_telefone_residencial'],'',$vetCampo['pessoa_telefone_celular'],'',$vetCampo['pessoa_telefone_recado'],'',$vetCampo['pessoa_email']),
  ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
  MesclarCol($vetCampo['assunto'], 5);
  $vetFrm[] = Frame('<span>Classificação</span>', Array(
  Array($vetCampo['assunto']),
  Array($vetCampo['idt_segmentacao'],'',$vetCampo['idt_subsegmentacao'],'',$vetCampo['idt_programa_fidelidade']),
  Array('','',$vetCampo['potencial_personagem'],'',$vetCampo['receber_informacoes']),
  Array($vetCampo['interesse_tema'],'',$vetCampo['interesse_produto'],'',$vetCampo['pessoa_representante']),
  ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
  $vetParametros = Array(
  'codigo_frm' => 'parte03',
  'controle_fecha' => 'A',
  );
  $vetFrm[] = Frame('<span>01.02 - CADASTRO DE EMPREENDIMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
  $vetParametros = Array(
  'codigo_pai' => 'parte03',
  );
  MesclarCol($vetCampo['organizacao_nome_fantasia'], 3);
  $vetFrm[] = Frame('<span>Identificação</span>', Array(
  Array($vetCampo['idt_tipo_empreendimento'],'',$vetCampo['cnpj'],'',$vetCampo['idt_cliente']),
  Array($vetCampo['organizacao_dap'],'',$vetCampo['organizacao_rmp'],'',$vetCampo['organizacao_nirf']),
  Array($vetCampo['nome_empresa'],'',$vetCampo['organizacao_nome_fantasia']),
  Array($vetCampo['organizacao_data_abertura'],'',$vetCampo['organizacao_pessoas_ocupadas'],'',$vetCampo['optante_simples']),
  Array($vetCampo['idt_porte']),
  ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
  $vetFrm[] = Frame('<span>Endereço</span>', Array(
  Array($vetCampo['organizacao_cep'],'',$vetCampo['organizacao_rua'],'',$vetCampo['organizacao_numero'],'',$vetCampo['organizacao_complemento']),
  Array($vetCampo['organizacao_bairro'],'',$vetCampo['organizacao_cidade'],'',$vetCampo['organizacao_estado'],'',$vetCampo['organizacao_pais']),
  ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
  //MesclarCol($vetCampo['pessoa_email'], 5);
  $vetFrm[] = Frame('<span>Comunicação</span>', Array(
  Array($vetCampo['organizacao_telefone_comercial'],'',$vetCampo['organizacao_email_comercial'],'',$vetCampo['organizacao_site_url']),
  ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
  }
 */


/*
  $vetParametros = Array(
  'codigo_frm' => 'parte04',
  'controle_fecha' => 'A',
  );

  $vetFrm[] = Frame('<span>01.03 - FINALIZAR</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

  $vetParametros = Array(
  'codigo_pai' => 'parte04',
  );

  $vetFrm[] = Frame('<span></span>', Array(
  Array($vetCampo['botao_concluir_atendimento']),
  ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

 */

// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// DIAGNOSTICOS DE ATENDIMENTO
//____________________________________________________________________________
// INÍCIO
// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________
// ORIENTAÇÃO TÉCNICA
//if ($instrumento==1 or $instrumento==2)
if ($instrumento == 8 or $instrumento == 13) {

    if ($acao == 'con' || $acao == 'exc') {
        $vetParametros = Array(
            'codigo_frm' => 'grc_atendimento_tema_tratado_w',
            'controle_fecha' => 'A',
            'comcontrole' => 0,
            'barra_inc_ap' => false,
            'barra_alt_ap' => false,
            'barra_con_ap' => false,
            'barra_exc_ap' => false,
            //'func_botao_per' => grc_atendimento_tema_tratado,
            'contlinfim' => '',
        );
    } else {
        $vetParametros = Array(
            'codigo_frm' => 'grc_atendimento_tema_tratado_w',
            'controle_fecha' => 'A',
            'barra_inc_ap' => true,
            'barra_alt_ap' => false,
            'barra_con_ap' => false,
            'barra_exc_ap' => false,
            'func_botao_per' => grc_atendimento_tema_tratado,
            'contlinfim' => '',
        );
    }

    // Definição de campos formato full que serão editados na tela full
    //  $vetFrm[] = Frame('<span> TEMAS TRATADOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);




    $vetCampo_full = Array();
    //Monta o vetor de Campo

    $vetCampo_full['grc_tema'] = CriaVetTabela('Tema');
    $vetCampo_full['grc_sub_tema'] = CriaVetTabela('Subtema');

    $vetTratamento = Array();
    $vetTratamento['T'] = 'Tratado';
    $vetTratamento['I'] = 'Interesse';
    //$vetCampo_full['tipo_tratamento']    = CriaVetTabela('Tratamento','descDominio',$vetTratamento);
    //Parametros da tela full conforme padrão

    $titulo = 'Temas';

    $TabelaPrinc = "grc_atendimento_tema";
    $AliasPric = "grc_at";
    $Entidade = "Tema do Atendimento";
    $Entidade_p = "Temas do Atendimento";

    // Select para obter campos da tabela que serão utilizados no full

    $orderby = "grc_t.descricao, grc_ts.descricao";

    $sql = "select {$AliasPric}.*, ";
    $sql .= "       grc_t.descricao as grc_tema, ";
    $sql .= "       grc_ts.descricao as grc_sub_tema ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join grc_tema_subtema grc_t on grc_t.idt = {$AliasPric}.idt_tema ";
    $sql .= " inner join grc_tema_subtema grc_ts on grc_ts.idt = {$AliasPric}.idt_sub_tema ";
    //
    $sql .= " where {$AliasPric}" . '.idt_atendimento = $vlID';
    $sql .= " and tipo_tratamento = 'T' ";
    $sql .= " order by {$orderby}";
    // Carrega campos que serão editados na tela full
    $vetCampo['grc_atendimento_tema_tratado'] = objListarConf('grc_atendimento_tema_tratado', 'idt', $vetCampo_full, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));
    $vetCampo['grc_atendimento_tema_tratado_tit'] = objBarraTitulo('grc_atendimento_tema_tratado_tit', 'QUALIFICAÇÃO DA DEMANDA (TEMAS TRATADOS)', 'class_titulo_p_barra');

    // Fotmata lay_out de saida da tela full

    $vetParametros = Array(
        'codigo_pai' => 'grc_atendimento_tema_tratado_w',
        'width' => '100%',
    );

    $vetFrm[] = Frame('', Array(
        //    Array($vetCampo['idt_tema_tratado'], '', $vetCampo['idt_subtema_tratado'], $vetCampo['botao_inc_tematratado']),
        //  Array('', '', $vetCampo['grc_atendimento_tema_tratado']),
        Array($vetCampo['grc_atendimento_tema_tratado_tit']),
        Array($vetCampo['grc_atendimento_tema_tratado']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}

if ($acao == 'con' || $acao == 'exc') {
    $vetParametros = Array(
        'codigo_frm' => 'grc_atendimento_tema_w',
        'controle_fecha' => 'A',
        'comcontrole' => 0,
        'barra_inc_ap' => false,
        'barra_alt_ap' => false,
        'barra_con_ap' => false,
        'barra_exc_ap' => false,
        //'func_botao_per' => grc_atendimento_tema,
        'contlinfim' => '',
    );
} else {
    $vetParametros = Array(
        'codigo_frm' => 'grc_atendimento_tema_w',
        'controle_fecha' => 'A',
        'barra_inc_ap' => true,
        'barra_alt_ap' => false,
        'barra_con_ap' => false,
        'barra_exc_ap' => false,
        'func_botao_per' => grc_atendimento_tema,
        'contlinfim' => '',
    );
}

//p($vetParametros);
//exit();
//$vetFrm[] = Frame('<span> TEMAS DE INTERESSE</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
// Definição de campos formato full que serão editados na tela full

$vetCampo_full = Array();
//Monta o vetor de Campo

$vetCampo_full['grc_tema'] = CriaVetTabela('Tema');
//$vetCampo_full['grc_sub_tema']    = CriaVetTabela('Subtema');

$vetTratamento = Array();
$vetTratamento['T'] = 'Tratado';
$vetTratamento['I'] = 'Interesse';
//$vetCampo_full['tipo_tratamento']    = CriaVetTabela('Tratamento','descDominio',$vetTratamento);
// Parametros da tela full conforme padrão

$titulo = 'Temas';

$TabelaPrinc = "grc_atendimento_tema";
$AliasPric = "grc_at";
$Entidade = "Tema do Atendimento";
$Entidade_p = "Temas do Atendimento";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "grc_t.descricao, grc_ts.descricao";

$sql = "select {$AliasPric}.*, ";
$sql .= "       grc_t.descricao as grc_tema, ";
$sql .= "       grc_ts.descricao as grc_sub_tema ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_tema_subtema grc_t on grc_t.idt = {$AliasPric}.idt_tema ";
$sql .= " left  join grc_tema_subtema grc_ts on grc_ts.idt = {$AliasPric}.idt_sub_tema ";
//
$sql .= " where {$AliasPric}" . '.idt_atendimento = $vlID';
$sql .= " and tipo_tratamento = 'I' ";


$sql .= " order by {$orderby}";
// Carrega campos que serão editados na tela full
$vetCampo['grc_atendimento_tema'] = objListarConf('grc_atendimento_tema', 'idt', $vetCampo_full, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'grc_atendimento_tema_w',
    'width' => '100%',
);

/*
  $vetFrm[] = Frame('<span></span>', Array(
  Array($vetCampo['grc_atendimento_tema']),
  ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
 */
// FIM ____________________________________________________________________________
// Definição do frame DIAGNOSTICO ASSOCIADO
// NOME DO FRAME = diagnostico_associado
// controle_fecha = A(o full entra aberto) F(O full entra fechado)
/*

  /*
  $vetParametros = Array(
  'codigo_frm' => 'atendimento_diagnostico',
  'controle_fecha' => 'F',
  );
  $vetFrm[] = Frame('<span>04 - DIAGNÓSTICOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

  // Definição de campos formato full que serão editados na tela full

  $vetCampo = Array();
  //Monta o vetor de Campo
  $vetCampo['codigo']           = CriaVetTabela('Código');
  $vetCampo['grc_ps_descricao'] = CriaVetTabela('Diagnostico Associado');
  $vetCampo['descricao']        = CriaVetTabela('Descrição');
  $vetCampo['ativo']            = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

  // Parametros da tela full conforme padrão

  $titulo = 'Diagnósticos do Atendimento';

  $TabelaPrinc      = "grc_atendimento_diagnostico";
  $AliasPric        = "grc_atd";
  $Entidade         = "Diagnóstico de Atendimento";
  $Entidade_p       = "Diagnósticos de Atendimento";

  $CampoPricPai     = "idt_diagnostico";

  // Select para obter campos da tabela que serão utilizados no full

  $orderby = "{$AliasPric}.codigo";

  $sql  = "select {$AliasPric}.*, ";
  $sql  .= "  grc_ps.descricao as grc_ps_descricao ";
  $sql .= " from {$TabelaPrinc} {$AliasPric}  ";

  $sql .= " inner join grc_diagnostico grc_ps on grc_ps.idt = {$AliasPric}.idt_diagnostico ";
  //
  $sql .= " where {$AliasPric}".'.idt_atendimento = $vlID';
  $sql .= " order by {$orderby}";

  // Carrega campos que serão editados na tela full

  $vetCampo['grc_atendimento_diagnostico'] = objListarConf('grc_atendimento_diagnostico', 'idt', $vetCampo, $sql, $titulo, false);

  // Fotmata lay_out de saida da tela full

  $vetParametros = Array(
  'codigo_pai' => 'atendimento_diagnostico',
  'width' => '100%',
  );

  $vetFrm[] = Frame('<span></span>', Array(
  Array($vetCampo['grc_atendimento_diagnostico']),
  ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

  // DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
  // PRODUTOS DE ATENDIMENTO
  //____________________________________________________________________________

 */

if ($acao == 'con' || $acao == 'exc') {
    $vetParametros = Array(
        'codigo_frm' => 'atendimento_produto',
        'controle_fecha' => 'A',
        'comcontrole' => 0,
        'barra_inc_ap' => false,
        'barra_alt_ap' => false,
        'barra_con_ap' => false,
        'barra_exc_ap' => false,
        'outramsgvazio' => false,
        'contlinfim' => '',
            //'func_botao_per' => grc_atendimento_produto_per,
    );
} else {
    $vetParametros = Array(
        'codigo_frm' => 'atendimento_produto',
        'controle_fecha' => 'A',
        'barra_inc_ap' => true,
        'barra_alt_ap' => true,
        'barra_con_ap' => false,
        'barra_exc_ap' => false,
        'outramsgvazio' => false,
        'contlinfim' => '',
        'func_botao_per' => grc_atendimento_produto_per,
    );
}

//$vetFrm[] = Frame('<span> TEMAS E PRODUTOS DE INTERESSE</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
// Definição de campos formato full que serão editados na tela full

$vetCampo_full = Array();
//Monta o vetor de Campo
//$vetCampo_full['codigo']    = CriaVetTabela('Código');
$vetCampo_full['grc_pp_descricao'] = CriaVetTabela('Produto');
$vetTratamento = Array();
$vetTratamento['T'] = 'Tratado';
$vetTratamento['I'] = 'Interesse';
//$vetCampo_full['tipo_tratamento']    = CriaVetTabela('Tratamento','descDominio',$vetTratamento);
// Parametros da tela full conforme padrão
$titulo = 'Produtos';
$TabelaPrinc = "grc_atendimento_produto";
$AliasPric = "grc_apr";
$Entidade = "Produto";
$Entidade_p = "Produtos";

$CampoPricPai = "idt_produto";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.codigo";

$sql = "select {$AliasPric}.*, ";
$sql .= "  grc_pp.descricao as grc_pp_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";

$sql .= " inner join grc_produto grc_pp on grc_pp.idt = {$AliasPric}.idt_produto ";
//
$sql .= " where {$AliasPric}" . '.idt_atendimento = $vlID';



$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full

$vetCampo['grc_atendimento_produto'] = objListarConf('grc_atendimento_produto', 'idt', $vetCampo_full, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'atendimento_produto',
    'width' => '100%',
);


/*
  $vetFrm[] = Frame('<span></span>', Array(
  Array($vetCampo['grc_atendimento_produto']),
  ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
 */

$vetCampo['barra_interesse'] = objBarraTitulo('barra_interesse', 'INTERESSES', 'class_titulo_p_barra');

MesclarCol($vetCampo['barra_interesse'], 3);

////////////////////// lado a lado full
//if ($instrumento==1)
if ($instrumento == 8) {

    $vetFrm[] = Frame('', Array(
        // Array($vetCampo['idt_tema_interesse'], $vetCampo['botao_inc_temainteresse'], $vetCampo['idt_produto_interesse']),
        Array($vetCampo['barra_interesse']),
        Array($vetCampo['grc_atendimento_tema'], '', $vetCampo['grc_atendimento_produto']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);



    /*
      $vetParametros = Array(
      'codigo_frm' => 'grc_atendimento_pessoa_informada_w',
      'controle_fecha' => 'A',
      'barra_inc_ap' => false,
      'barra_alt_ap' => false,
      'barra_con_ap' => false,
      'barra_exc_ap' => true,
      );
      $vetFrm[] = Frame('<span> PESSOAS INFORMADAS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

      $vetParametros = Array(
      'codigo_pai' => 'grc_atendimento_pessoa_informada_w',
      'width' => '100%',
      );

      MesclarCol($vetCampo['mome_realizacao'], 3);
      $vetFrm[] = Frame('', Array(
      Array($vetCampo['mome_realizacao']),
      Array($vetCampo['inicio_realizacao'], '', $vetCampo['termino_realizacao']),
      Array($vetCampo['idt_canal'], '', $vetCampo['idt_tipo_realizacao']),
      Array($vetCampo['idt_categoria'], '', $vetCampo['numero_pessoas_informadas']),
      ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
     * 
     */
}


//if ($instrumento==2)
if ($instrumento == 13) {


    //MesclarCol($vetCampo['botao_inc_temainteresse'], 2);
    //MesclarCol($vetCampo['grc_atendimento_tema'], 2);
    $vetFrm[] = Frame('', Array(
        //Array($vetCampo['idt_tema_interesse'], $vetCampo['botao_inc_temainteresse'], $vetCampo['idt_produto_interesse']),
        Array($vetCampo['barra_interesse']),
        Array($vetCampo['grc_atendimento_tema'], '', $vetCampo['grc_atendimento_produto']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}
//if ($instrumento==3)
if ($instrumento == 2) {

    $vetFrm[] = Frame('', Array(
        // Array($vetCampo['idt_tema_interesse'], $vetCampo['botao_inc_temainteresse'], $vetCampo['idt_produto_interesse']),
        Array($vetCampo['barra_interesse']),
        Array($vetCampo['grc_atendimento_tema'], '', $vetCampo['grc_atendimento_produto']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}


// INÍCIO
// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________


if ($acao == 'con' || $acao == 'exc') {
    $vetParametros = Array(
        'codigo_frm' => 'grc_atendimento_pessoa_w',
        'controle_fecha' => 'A',
        //'comcontrole' => 0,
        'barra_inc_ap' => false,
        'barra_alt_ap' => false,
        'barra_con_ap' => true,
        'barra_exc_ap' => false,
        'contlinfim' => '',
            //'func_trata_row' => grc_atendimento_pessoa_representante,
    );
} else {
    $vetParametros = Array(
        'codigo_frm' => 'grc_atendimento_pessoa_w',
        'controle_fecha' => 'A',
        'barra_inc_ap' => true,
        'barra_alt_ap' => true,
        'barra_con_ap' => true,
        'barra_exc_ap' => true,
        'contlinfim' => '',
        'func_trata_row' => grc_atendimento_pessoa_representante,
    );
}

$vetFrm[] = Frame('<span>VINCULAR PESSOAS AO ATENDIMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p);
// Definição de campos formato full que serão editados na tela full

$vetCampo = Array();
//Monta o vetor de Campo


$vetCampo['cpf'] = CriaVetTabela('CPF do Cliente');
$vetCampo['nome'] = CriaVetTabela('Nome do Cliente');

$vetRelacao = Array();
$vetRelacao['L'] = 'Representante';
$vetRelacao['P'] = 'Participante';
$vetCampo['tipo_relacao'] = CriaVetTabela('Tipo Relação', 'descDominio', $vetRelacao);

// Parametros da tela full conforme padrão

$titulo = 'Pessoas';

$TabelaPrinc = "grc_atendimento_pessoa";
$AliasPric = "grc_ap";
$Entidade = "Pessoa do Atendimento";
$Entidade_p = "Pessoas do Atendimento";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.tipo_relacao, {$AliasPric}.cpf ";

$sql = "select {$AliasPric}.*  ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//
$sql .= " where {$AliasPric}" . '.idt_atendimento = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full



$vetCampo['grc_atendimento_pessoa'] = objListarConf('grc_atendimento_pessoa', 'idt', $vetCampo, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'grc_atendimento_pessoa_w',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_atendimento_pessoa']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);








// FIM ____________________________________________________________________________
// INÍCIO
// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________


$vetParametros = Array(
    'codigo_frm' => 'grc_atendimento_organizacao_w',
    'controle_fecha' => 'A',
    'barra_inc_ap' => true,
    'barra_alt_ap' => true,
    'barra_con_ap' => false,
    'barra_exc_ap' => true,
    'contlinfim' => '',
);

/*
  $vetFrm[] = Frame('<span>VINCULAR EMPREENDIMENTOS AO ATENDIMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p);
  // Definição de campos formato full que serão editados na tela full

  $vetCampo = Array();
  //Monta o vetor de Campo


  $vetCampo['cnpj'] = CriaVetTabela('cnpj do empreendimento');
  $vetCampo['razao_social'] = CriaVetTabela('Razão Social');
  $vetCampo['nome_fantasia'] = CriaVetTabela('Nome Fantasia');
  $vetCampo['representa'] = CriaVetTabela('Representa nesse<br /> Atendimento?', 'descDominio', $vetSimNao);
  $vetCampo['desvincular'] = CriaVetTabela('Desvincula?', 'descDominio', $vetSimNao);

  // Parametros da tela full conforme padrão

  $titulo = 'Organização';

  $TabelaPrinc = "grc_atendimento_organizacao";
  $AliasPric = "grc_ao";
  $Entidade = "Organização do Atendimento";
  $Entidade_p = "Organizações do Atendimento";

  // Select para obter campos da tabela que serão utilizados no full

  $orderby = "{$AliasPric}.cnpj ";

  $sql = "select {$AliasPric}.*  ";
  $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
  //
  $sql .= " where {$AliasPric}".'.idt_atendimento = $vlID';
  $sql .= " order by {$orderby}";

  // Carrega campos que serão editados na tela full



  $vetCampo['grc_atendimento_organizacao'] = objListarConf('grc_atendimento_organizacao', 'idt', $vetCampo, $sql, $titulo, false, $vetParametros);

  // Fotmata lay_out de saida da tela full

  $vetParametros = Array(
  'codigo_pai' => 'grc_atendimento_organizacao_w',
  'width' => '100%',
  );

  $vetFrm[] = Frame('', Array(
  Array($vetCampo['grc_atendimento_organizacao']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
 */







// FIM ____________________________________________________________________________
// INÍCIO
// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________


if ($acao == 'con' || $acao == 'exc') {
    $vetParametros = Array(
        'codigo_frm' => 'grc_atendimento_anexo_w',
        'controle_fecha' => 'A',
        //'comcontrole' => 0,
        'barra_inc_ap' => false,
        'barra_alt_ap' => false,
        'barra_con_ap' => true,
        'barra_exc_ap' => false,
        'contlinfim' => '',
    );
} else {
    $vetParametros = Array(
        'codigo_frm' => 'grc_atendimento_anexo_w',
        'controle_fecha' => 'A',
        'barra_inc_ap' => true,
        'barra_alt_ap' => true,
        'barra_con_ap' => true,
        'barra_exc_ap' => true,
        'contlinfim' => '',
    );
}

$vetFrm[] = Frame('<span>VINCULAR ANEXOS AO ATENDIMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p);
// Definição de campos formato full que serão editados na tela full

$vetCampo = Array();
//Monta o vetor de Campo
$vetCampo['descricao'] = CriaVetTabela('Título do Anexo');
$vetCampo['arquivo'] = CriaVetTabela('Arquivo anexado', 'arquivo_sem_nome', '', 'grc_atendimento_anexo');
$vetCampo['devolutiva_distancia'] = CriaVetTabela('Devolutiva<br />Distância', 'descDominio', $vetSimNao);

// Parametros da tela full conforme padrão
$titulo = 'Anexos';

$TabelaPrinc = "grc_atendimento_anexo";
$AliasPric = "grc_aa";
$Entidade = "Anexo do Atendimento";
$Entidade_p = "Anexos do Atendimento";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.descricao ";

$sql = "select {$AliasPric}.*  ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//
$sql .= " where {$AliasPric}" . '.idt_atendimento = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full



$vetCampo['grc_atendimento_anexo'] = objListarConf('grc_atendimento_anexo', 'idt', $vetCampo, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'grc_atendimento_anexo_w',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_atendimento_anexo']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);


// FIM ____________________________________________________________________________
// INÍCIO
// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________


if ($acao == 'con' || $acao == 'exc') {
    $vetParametros = Array(
        'codigo_frm' => 'grc_atendimento_pendencia_w',
        'controle_fecha' => 'A',
        //'comcontrole' => 0,
        'barra_inc_ap' => false,
        'barra_alt_ap' => false,
        'barra_con_ap' => true,
        'barra_exc_ap' => false,
        'contlinfim' => '',
    );
} else {
    $vetParametros = Array(
        'codigo_frm' => 'grc_atendimento_pendencia_w',
        'controle_fecha' => 'A',
        'barra_inc_ap' => true,
        'barra_alt_ap' => true,
        'barra_con_ap' => true,
        'barra_exc_ap' => false,
        'func_botao_per' => grc_atendimento_pendencia_per,
        'vetBtOrdem' => Array('per', 'exc', 'con', 'alt'),
        'contlinfim' => '',
    );
}

$vetFrm[] = Frame('<span>VINCULAR PENDÊNCIAS AO ATENDIMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p);

// Definição de campos formato full que serão editados na tela full
$vetCampo = Array();
//Monta o vetor de Campo
$vetCampo['data'] = CriaVetTabela('Data da Abertura', 'data');
$vetCampo['plu_u_nome_completo'] = CriaVetTabela('Responsável');
$vetCampo['assunto'] = CriaVetTabela('Assunto');
$vetCampo['status'] = CriaVetTabela('Status');
$vetCampo['data_solucao'] = CriaVetTabela('Data Prevista Solução', 'data');

//$vetCampo['observacao'] = CriaVetTabela('Detalhamento');
//$vetCampo['ativo'] = CriaVetTabela('Ativo', 'descDominio', $vetSimNao);
// Parametros da tela full conforme padrão
$titulo = 'Pendências';
$TabelaPrinc = "grc_atendimento_pendencia";
$AliasPric = "grc_ap";
$Entidade = "Pendência do Atendimento";
$Entidade_p = "Pendências do Atendimento";
//
// Select para obter campos da tabela que serão utilizados no full
//
$orderby = "{$AliasPric}.data desc";

$sql = "select {$AliasPric}.*, ";
$sql .= "       plu_u.nome_completo as plu_u_nome_completo ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left outer join plu_usuario plu_u on plu_u.id_usuario = {$AliasPric}.idt_responsavel_solucao ";
//
$sql .= " where {$AliasPric}" . '.idt_atendimento = $vlID';
//$sql .= " and {$AliasPric}.ativo = 'S'";
$sql .= " and {$AliasPric}.idt_atendimento_pendencia_trans is null";
$sql .= " and {$AliasPric}.idt_pendencia_pai is null"; // para rede de pendências de atendimento
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full



$vetCampo['grc_atendimento_pendencia'] = objListarConf('grc_atendimento_pendencia', 'idt', $vetCampo, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'grc_atendimento_pendencia_w',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_atendimento_pendencia']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

/* 		
  //////////////////// resumo incluido por luiz

  if ($acao == 'con' || $acao == 'exc') {
  $vetParametros = Array(
  'codigo_frm' => 'grc_atendimento_resumo_w',
  'controle_fecha' => 'A',
  'comcontrole' => 0,
  'barra_inc_ap' => false,
  'barra_alt_ap' => false,
  'barra_con_ap' => true,
  'barra_exc_ap' => false,
  'contlinfim' => '',
  );
  } else {
  $vetParametros = Array(
  'codigo_frm' => 'grc_atendimento_resumo_w',
  'controle_fecha' => 'A',
  'barra_inc_ap' => false,
  'barra_alt_ap' => false,
  'barra_con_ap' => true,
  'barra_exc_ap' => false,
  //func_botao_per' => grc_atendimento_pendencia_per,
  //vetBtOrdem' => Array('per', 'exc', 'con', 'alt'),
  'contlinfim' => '',
  );
  }

  $vetFrm[] = Frame('<span>RESUMO DO ATENDIMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p);

  // Definição de campos formato full que serão editados na tela full





  $vetCampo = Array();
  //Monta o vetor de Campo
  $vetCampo['descricao'] = CriaVetTabela('Descricão');
  // Parametros da tela full conforme padrão
  $titulo = 'Pendências';
  $TabelaPrinc = "grc_atendimento_resumo";
  $AliasPric = "grc_ar";
  $Entidade = "Resumo do Atendimento";
  $Entidade_p = "Resumos do Atendimento";
  //
  // Select para obter campos da tabela que serão utilizados no full
  //
  $orderby = "grc_ara.codigo ";

  $sql  = "select {$AliasPric}.*, ";
  $sql .= " grc_ara.descricao as descricao_acao ";
  $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
  $sql .= " inner join grc_atendimento_resumo_acao grc_ara on grc_ara.idt = {$AliasPric}.idt_acao ";

  $sql .= " where {$AliasPric}".'.idt_atendimento = $vlID';
  $sql .= " order by {$orderby}";

  // Carrega campos que serão editados na tela full



  $vetCampo['grc_atendimento_resumo'] = objListarConf('grc_atendimento_resumo', 'idt', $vetCampo, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));

  // Fotmata lay_out de saida da tela full

  $vetParametros = Array(
  'codigo_pai' => 'grc_atendimento_resumo_w',
  'width' => '100%',
  );

  $vetFrm[] = Frame('', Array(
  Array($vetCampo['grc_atendimento_resumo']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);



  //////////////////// fim resumo incluido por luiz

  $vetParametros = Array(
  'codigo_frm' => 'botao_concluir_atendimento_w',
  'controle_fecha' => 'A',
  'barra_inc_ap' => false,
  'barra_alt_ap' => false,
  'barra_con_ap' => false,
  'barra_exc_ap' => true,
  );
  //$vetFrm[] = Frame('<span> CONCLUIR ATENDIMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


  $vetParametros = Array(
  'codigo_pai' => 'botao_concluir_atendimento_w',
  'width' => '100%',
  );

  MesclarCol($vetCampo_f['botao_concluir_atendimento'], 3);

  $vetFrm[] = Frame('', Array(
  Array($vetCampo_f['botao_concluir_atendimento']),
  Array($vetCampo_f['situacao'], '', $vetCampo_f['protocolo']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

 */


//
// FIM ____________________________________________________________________________
//
// Fim da recuperação
//


$vetCad[] = $vetFrm;



////////////////////// teste guy  do frm3
$vetFrm = Array();

//////////////////// resumo incluido por luiz

if ($acao == 'con' || $acao == 'exc') {
    $vetParametros = Array(
        'codigo_frm' => 'grc_atendimento_resumo_w',
        'controle_fecha' => 'A',
        //'comcontrole' => 0,
        'barra_inc_ap' => false,
        'barra_alt_ap' => false,
        'barra_con_ap' => true,
        'barra_exc_ap' => false,
        'contlinfim' => '',
    );
} else {
    $vetParametros = Array(
        'codigo_frm' => 'grc_atendimento_resumo_w',
        'controle_fecha' => 'A',
        'barra_inc_ap' => false,
        'barra_alt_ap' => false,
        'barra_con_ap' => true,
        'barra_exc_ap' => true,
        //func_botao_per' => grc_atendimento_pendencia_per,
        //vetBtOrdem' => Array('per', 'exc', 'con', 'alt'),
        'contlinfim' => '',
    );
}

$vetFrm[] = Frame('<span>RESUMO DO ATENDIMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p);

// Definição de campos formato full que serão editados na tela full





$vetCampo = Array();
//Monta o vetor de Campo

$vetCampo['descricao_acao'] = CriaVetTabela('Ação');
$vetCampo['complemento_acao'] = CriaVetTabela('Título');
$vetCampo['descricao'] = CriaVetTabela('Descricão');


// Parametros da tela full conforme padrão
$titulo = 'Pendências';
$TabelaPrinc = "grc_atendimento_resumo";
$AliasPric = "grc_ar";
$Entidade = "Resumo do Atendimento";
$Entidade_p = "Resumos do Atendimento";
//
// Select para obter campos da tabela que serão utilizados no full
//
$orderby = "{$AliasPric}.numero ";

$sql = "select {$AliasPric}.*, ";
$sql .= " grc_ara.descricao as descricao_acao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_atendimento_resumo_acao grc_ara on grc_ara.idt = {$AliasPric}.idt_acao ";

$sql .= " where {$AliasPric}" . '.idt_atendimento = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full



$vetCampo['grc_atendimento_resumo'] = objListarConf('grc_atendimento_resumo', 'idt', $vetCampo, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'grc_atendimento_resumo_w',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_atendimento_resumo']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);



//////////////////// fim resumo incluido por luiz

$vetParametros = Array(
    'codigo_frm' => 'botao_concluir_atendimento_w',
    'controle_fecha' => 'A',
    'barra_inc_ap' => false,
    'barra_alt_ap' => false,
    'barra_con_ap' => false,
    'barra_exc_ap' => true,
);
//$vetFrm[] = Frame('<span> CONCLUIR ATENDIMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


$vetParametros = Array(
    'codigo_pai' => 'botao_concluir_atendimento_w',
    'width' => '100%',
);

MesclarCol($vetCampo_f['botao_concluir_atendimento'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo_f['botao_concluir_atendimento']),
    Array($vetCampo_f['situacao'], '', $vetCampo_f['protocolo']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);


$vetCad[] = $vetFrm;
?>
<!-- <lupe> <script>  Definição processos Cliente -->
<script>
    /* <lupe> <cliente> 
     Documentação
     </lupe> */
//var acao     = '<?php echo $acao; ?>';
//var inc_cont = '<?php echo $$inc_cont; ?>';

    var cliente_sem_classificacao  = '<?php echo $cliente_sem_classificacao; ?>';;
    var msgClienteSemClassificacao = '<?php echo $msgClienteSemClassificacao; ?>';;

    var pendcon = '<?php echo $pendcon; ?>';


    var timerId = 0;
    var delay = 60000;

    var timerIdresumo = 0;
    var delayresumo = 60000;


    var bt = $('<img id="bt_relogio" border="0" src="imagens/bt_relogio_open.png" title="Trancar Relógio">');
    var horas = null;
    var horas_desc = null;

    var situacao_submit = '';

    function grc_atendimento_con() {
        if (situacao_submit != '') {
            $('#situacao').val(situacao_submit);
        }

        return true;
    }

    function grc_atendimento_dep() {
        if (validaDataMenor(false, $('#data'), 'Data do Atendimento', $('#dtBancoObj'), 'Hoje') === false) {
            $('#data').focus();
            return false;
        }

        calculaMinuto();

        if ($('#horas_atendimento').val() <= 0) {
            alert('A Duração (m.) não pode ser menor que um minuto!');
            return false;
        }
		
		if (cliente_sem_classificacao == 3) {
		//    alert('tô vivo'); 
            alert(msgClienteSemClassificacao);
        }

        return true;
    }

    $(document).ready(function () {

        timerIdresumo = setInterval('RefreshResumo()', delayresumo);

        horas = $('#data, #hora_inicio_atendimento, #hora_termino_atendimento');
        horas_desc = $('#data_desc, #hora_inicio_atendimento_desc, #hora_termino_atendimento_desc');

        var divProtocolo = $('<div id="divProtocolo">Protocolo de Atendimento: ' + $('#protocolo').val() + '</div>');
        $('#idt_instrumento_obj').append(divProtocolo);

        if ('<?php echo $row_aap['origem']; ?>' == 'D') {
            $('#idt_instrumento_tf').html($('#idt_instrumento_tf').text() + ' - A Distância');
        }

        $('#hora_inicio_atendimento, #hora_termino_atendimento').change(function () {
            calculaMinuto();
        });

        $('#data').change(function () {
            if (validaDataMenor(false, $(this), 'Data do Atendimento', $('#dtBancoObj'), 'Hoje') === false) {
                $(this).focus();
                return false;
            }

            if ($(this).val() != '') {
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: ajax_sistema + '?tipo=competencia_dados',
                    data: {
                        cas: conteudo_abrir_sistema,
                        data: $(this).val()
                    },
                    success: function (response) {
                        if (response.erro == '') {
                            $('#idt_competencia').val(response.idt);
                            $('#idt_competencia_tf').html(url_decode(response.texto));
                        } else {
                            alert(url_decode(response.erro));
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                    },
                    async: true
                });
            }
        });

        $('#hora_inicio_atendimento').change(function () {
            var ini = $(this).val();

            if (ini != '' && $('#data').val() == $('#dtBancoObj').val()) {
                var dt_ini = newDataHoraStr(true, $('#dtBancoObj').val() + ' ' + ini);
                var dt_fim = new Date();

                if (dt_fim - dt_ini < 0) {
                    alert('A Hora Inicial não pode ser maior que a hora atual!');
                    $(this).val('');
                    $(this).focus();
                    return false;
                }
            }
        });

        $('#hora_termino_atendimento').change(function () {
            var ini = $(this).val();

            if (ini == '') {
                return true;
            }

            if ($('#data').val() == $('#dtBancoObj').val()) {
                var dt_ini = newDataHoraStr(true, $('#dtBancoObj').val() + ' ' + ini);
                var dt_fim = new Date();

                if (dt_fim - dt_ini < 0) {
                    alert('A Hora Final não pode ser maior que a hora atual!');
                    $(this).val('');
                    $(this).focus();
                    return false;
                }
            }

            if ($('#hora_inicio_atendimento').val() == '') {
                alert('Favor informar a Hora Inicial!');
                $('#hora_inicio_atendimento').focus();
                return false;
            }

            dt_fim = newDataHoraStr(true, $('#dtBancoObj').val() + ' ' + $('#hora_inicio_atendimento').val());

            if (dt_fim - dt_ini > 0) {
                alert('A Hora Final não pode ser menor que a Hora Inicial!');
                $(this).val('');
                $(this).focus();
                return false;
            }
        });

        if (acao == 'inc' || acao == 'alt') {
            if ($('#data_atendimento_aberta').val() == 'N') {
                bt.attr('src', 'imagens/bt_relogio_lock.png');
                bt.attr('title', 'Abrir Relógio');
                horas.prop("disabled", true);

                if (acao == 'inc' || acao == 'alt' || inc_cont == 's') {
                    inicializaRelogio();
                    timerId = setInterval('inicializaRelogio()', delay);

                    bt.click(function () {
                        if ($('#data_atendimento_aberta').val() == 'N') {
                            $('#data_atendimento_aberta').val('S');
                            $(this).attr('src', 'imagens/bt_relogio_open.png');
                            $(this).attr('title', 'Trancar Relógio');
                            horas.removeProp("disabled");

                            horas_desc.addClass("Tit_Campo_Obr");
                            horas_desc.removeClass("Tit_Campo");

                            clearInterval(timerId);
                        } else {
                            $('#data_atendimento_aberta').val('N');
                            $(this).attr('src', 'imagens/bt_relogio_lock.png');
                            $(this).attr('title', 'Abrir Relógio');
                            horas.prop("disabled", true);

                            horas_desc.addClass("Tit_Campo");
                            horas_desc.removeClass("Tit_Campo_Obr");

                            inicializaRelogio();
                            timerId = setInterval('inicializaRelogio()', delay);
                        }
                    });
                }
            } else {
                horas_desc.addClass("Tit_Campo_Obr");
                horas_desc.removeClass("Tit_Campo");

                bt.click(function () {
                    alert('Não pode trancar o relógio, pois já foi alterado manualmente!');
                });
            }

            $('#hora_termino_atendimento_obj').attr('nowrap', 'nowrap').append(bt);

            $('div#barra_bt_top').hide();
        }

        $("#idt_subtema_tratado").cascade("#idt_tema_tratado", {ajax: {
                url: 'ajax_atendimento.php?tipo=subtema_tratado&cas=' + conteudo_abrir_sistema
            }});

        $('div#barra_bt_bottom').hide();

        $tamanholateral = 500;
        objd = document.getElementById('grd2');
        if (objd != null)
        {
            $tamanholateral = $(objd).css('height');
        }
        objd = document.getElementById('grd1');
        if (objd != null)
        {
            $tamanholateralw = $tamanholateral + 'px';

            $(objd).css('height', $tamanholateral);

        }


        objd = document.getElementById('geral');
        if (objd != null)
        {
            //$(objd).css('marginLeft','40px');
            // $(objd).css('width','700px');
            // $(objd).css('marginLeft','200px');
        }

        objd = document.getElementById('frm');
        if (objd != null)
        {
            //$(objd).css('marginLeft','40px');
            // $(objd).css('width','700px');
            // $(objd).css('marginLeft','200px');
        }

        /*
         var bia_x = 0;
         var bia_y = 0;
         var width_bia  = 0;
         var height_bia = 0;
         
         var id='grd0';
         objpbia = document.getElementById(id);
         if (objpbia != null) {
         var coordenada = $(objpbia).position();
         bia_x  = coordenada.left;
         bia_y  = coordenada.top;
         width_bia  = $(objpbia).css('width');
         height_bia = $(objpbia).css('height');
         }
         var id='bia_menu';
         objbia = document.getElementById(id);
         if (objbia != null) {
         objbia.style.left = bia_x + "px";
         objbia.style.top  = bia_y + "px";
         //$(objbia).css('width',width_bia);
         //$(objbia).css('height',height_bia);
         $(objbia).show();
         }
         
         */
        objd = document.getElementById('idt_instrumento_tf');
        if (objd != null)
        {
            $(objd).css('fontSize', '20px');
            $(objd).css('height', '25');
            $(objd).css('fontWeight', 'bold');
            $(objd).css('textAlign', 'center');
            $(objd).css('background', '#2C3E50');
            $(objd).css('color', '#FFFFFF');
            $(objd).css('paddingTop', '15px');
        }

        objd = document.getElementById('idt_competencia_obj');
        if (objd != null)
        {
            $(objd).css('width', '30%');
        }
        objd = document.getElementById('idt_competencia');
        if (objd != null)
        {
            $(objd).css('width', '100%');
        }


        objd = document.getElementById('idt_ponto_atendimento_obj');
        if (objd != null)
        {
            $(objd).css('width', '49%');
        }
        objd = document.getElementById('idt_ponto_atendimento_tf');
        if (objd != null)
        {
            $(objd).css('width', '99%');
        }

        objd = document.getElementById('idt_consultor_obj');
        if (objd != null)
        {
            $(objd).css('width', '49%');
        }
        objd = document.getElementById('idt_tema_tratado_obj');
        if (objd != null)
        {
            if ('<?php echo $row_aap['origem']; ?>' == 'D')
            {
                $(objd).css('width', '25%');
            } else
            {
                $(objd).css('width', '49%');
            }
        }
        objd = document.getElementById('idt_subtema_tratado_obj');
        if (objd != null)
        {
            if ('<?php echo $row_aap['origem']; ?>' == 'D')
            {
                $(objd).css('width', '25%');
            } else
            {
                $(objd).css('width', '49%');
            }

        }
        if ('<?php echo $row_aap['origem']; ?>' == 'D')
        {
            objd = document.getElementById('idt_modalidade_obj');
            if (objd != null)
            {
                $(objd).css('width', '25%');
            }
            objd = document.getElementById('idt_servico_obj');
            if (objd != null)
            {
                $(objd).css('width', '25%');
            }

        }

        objd = document.getElementById('idt_produto_interesse_obj');
        if (objd != null)
        {
            //$(objd).css('padding','10px');
        }


        objd = document.getElementById('protocolo');
        if (objd != null)
        {
            $(objd).css('fontSize', '18px');
            $(objd).css('guyheight', '25');
            $(objd).css('textAlign', 'center');
        }
        objd = document.getElementById('situacao');
        if (objd != null)
        {
            $(objd).css('fontSize', '18px');
            $(objd).css('guyheight', '25');
            $(objd).css('textAlign', 'center');
            $(objd).css('border', '0');
        }
        objd = document.getElementById('senha_totem');
        if (objd != null)
        {
            $(objd).css('fontSize', '18px');
            $(objd).css('guyheight', '25');
            $(objd).css('textAlign', 'center');
            $(objd).css('border', '0');
        }

        objd = document.getElementById('gestor_sge');
        if (objd != null)
        {
            $(objd).css('fontSize', '12px');
            $(objd).css('guyheight', '25');
            $(objd).css('guytextAlign', 'center');
            $(objd).css('border', '0');
        }
        objd = document.getElementById('fase_acao_projeto');
        if (objd != null)
        {
            $(objd).css('fontSize', '12px');
            $(objd).css('guyheight', '25');
            $(objd).css('guytextAlign', 'center');
            $(objd).css('border', '0');
        }


        objd = document.getElementById('cpf');
        if (objd != null)
        {
            $(objd).css('fontSize', '18px');
            $(objd).css('guyheight', '25');
            $(objd).css('textAlign', 'center');
            $(objd).css('border', '0');
        }


        objd = document.getElementById('cnpj');
        if (objd != null)
        {
            $(objd).css('fontSize', '18px');
            $(objd).css('guyheight', '30');
            $(objd).css('textAlign', 'center');
            $(objd).css('border', '0');
        }




        objd = document.getElementById('idt_projeto');
        if (objd != null)
        {
            $(objd).css('fontSize', '18px');
            $(objd).css('guyheight', '25');
            $(objd).css('textAlign', 'center');
            $(objd).css('border', '0');
        }
        objd = document.getElementById('idt_projeto_acao');
        if (objd != null)
        {
            $(objd).css('fontSize', '18px');
            $(objd).css('guyheight', '25');
            $(objd).css('textAlign', 'center');
            $(objd).css('border', '0');
        }

        objd = document.getElementById('idt_competencia_obj');
        if (objd != null)
        {
            // $(objd).css('color','#FF0000');
            $(objd).css('background', '#2F66B8');
            $(objd).css('color', '#FFFFFF');

        }

        objd = document.getElementById('data');
        if (objd != null)
        {
            $(objd).css('fontSize', '12px');
            $(objd).css('guyheight', '30');
            $(objd).css('textAlign', 'center');
            $(objd).css('border', '0');
            $(objd).css('background', '#2F66B8');
            $(objd).css('color', '#FFFFFF');
        }

        objd = document.getElementById('hora_inicio_atendimento');
        if (objd != null)
        {
            $(objd).css('fontSize', '12px');
            $(objd).css('guyheight', '30');
            $(objd).css('textAlign', 'center');
            $(objd).css('border', '0');
            $(objd).css('background', '#2F66B8');
            $(objd).css('color', '#FFFFFF');
        }

        objd = document.getElementById('hora_termino_atendimento');
        if (objd != null)
        {
            $(objd).css('fontSize', '12px');
            $(objd).css('guyheight', '30');
            $(objd).css('textAlign', 'center');
            $(objd).css('border', '0');
            $(objd).css('background', '#2F66B8');
            $(objd).css('color', '#FFFFFF');
        }

        objd = document.getElementById('horas_atendimento');
        if (objd != null)
        {
            $(objd).css('fontSize', '12px');
            $(objd).css('guyheight', '30');
            $(objd).css('textAlign', 'center');
            $(objd).css('border', '0');
            $(objd).css('background', '#2F66B8');
            $(objd).css('color', '#FFFFFF');
        }
        // colocado por luiz para resolver problema fila de espera chamado ao atendimento
        TelaHeight();
    });

    function ChamaCPFEspecial(thisw)
    {
        var ret = Valida_CPF(thisw);
        //alert('xxx acessar pessoa '+thisw.value+ ' == '+ ret );
        //var cpf = thisw.value;
        if (ret && thisw.value != '')
        {
//        ChamaPessoa();
        }
        return ret;
    }
    function ChamaCNPJespecial(thisw)
    {
        var ret = Valida_CNPJ(thisw);
        //alert('xxx acessar pessoa '+thisw.value+ ' == '+ ret );
        //var cpf = thisw.value;
        if (ret && thisw.value != '')
        {
//        ChamaPessoa();
        }
        return ret;
    }


    function DuasHorasDif(horaInicial, horaFinal)
    {
        horaIni = horaInicial.split(':');
        horaFim = horaFinal.split(':');

        hIni = parseInt(horaIni[0], 10);
        hFim = parseInt(horaFim[0], 10);
        //
        mIni = parseInt(horaIni[1], 10);
        mFim = parseInt(horaFim[1], 10);

        horaIniM = hIni * 60 + mIni;
        horaFimM = hFim * 60 + mFim;

        if (horaFimM < horaIniM)
        {
            alert('Hora Final é menor que Hora Inicial');
            return -1;
        }

        DifM = horaFimM - horaIniM;



        var id = 'horas_atendimento';
        objtp = document.getElementById(id);
        if (objtp != null) {
            objtp.value = DifM;
        }
    }
    function DuasHorasCompara(horaInicial, horaFinal)
    {
        horaIni = horaInicial.split(':');
        horaFim = horaFinal.split(':');

        hIni = parseInt(horaIni[0], 10);
        hFim = parseInt(horaFim[0], 10);
        //
        mIni = parseInt(horaIni[1], 10);
        mFim = parseInt(horaFim[1], 10);

        horaIniM = hIni * 60 + mIni;
        horaFimM = hFim * 60 + mFim;

        if (horaFimM < horaIniM)
        {
            alert('Hora Final é menor que Hora Inicial');
            return -1;
        }
        return 1;
    }

    function fncListarCmbMultiMuda_idt_produto_interesse(session_cod) {
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php?tipo=GravaProdutoInteresseMulti',
            data: {
                cas: conteudo_abrir_sistema,
                session_cod: session_cod,
                idt_atendimento: $('#id').val()
            },
            success: function (response) {
                btFechaCTC($('#grc_atendimento_produto').data('session_cod'));

                if (response.erro != '') {
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });
    }

    function btClickExcDireta(tabela, idt_campo, idt_valor, mensagem, session_cod) {
        if (confirm(mensagem)) {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'ajax_atendimento.php?tipo=btClickExcDireta',
                data: {
                    cas: conteudo_abrir_sistema,
                    tabela: tabela,
                    idt_campo: idt_campo,
                    idt_valor: idt_valor
                },
                success: function (response) {
                    btFechaCTC(session_cod);

                    if (response.erro != '') {
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });
        }

        return false;
    }

    function btClickPendenciaAtivo(tabela, idt_campo, idt_valor, mensagem, session_cod) {
        if (confirm(mensagem)) {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'ajax_atendimento.php?tipo=btClickPendenciaAtivo',
                data: {
                    cas: conteudo_abrir_sistema,
                    tabela: tabela,
                    idt_campo: idt_campo,
                    idt_valor: idt_valor
                },
                success: function (response) {
                    btFechaCTC(session_cod);

                    if (response.erro != '') {
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });
        }

        return false;
    }

    function inicializaRelogio() {
        if ($('#data_atendimento_relogio').val() == 'S') {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'ajax_atendimento.php?tipo=inicializaRelogio',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_atendimento: $('#id').val()
                },
                success: function (response) {
                    if (response.erro == '') {
                        $('#data').val(response.data);
                        $('#hora_inicio_atendimento').val(response.hora_inicio_atendimento);
                        $('#hora_termino_atendimento').val(response.hora_termino_atendimento);
                        calculaMinuto();
                    } else {
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });
        }
    }

    function calculaMinuto() {
        var ini = $('#hora_inicio_atendimento').val();
        var fim = $('#hora_termino_atendimento').val();
        var qtd = 0;

        if (ini != '' && fim != '') {
            var dt_ini = newDataHoraStr(true, '01/01/2015 ' + ini);
            var dt_fim = newDataHoraStr(true, '01/01/2015 ' + fim);
            qtd = dt_fim - dt_ini;
            qtd = qtd / 1000 / 60;
        }

        $('#horas_atendimento').val(qtd);
    }

    function fncListarCmbMuda_idt_projeto(idt_projeto) {
        $('#idt_projeto_acao_bt_limpar').click();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=projeto_dados',
            data: {
                cas: conteudo_abrir_sistema,
                idt_projeto: idt_projeto
            },
            success: function (response) {
                $('#gestor_sge').val(url_decode(response.gestor));
                $('#fase_acao_projeto').val(url_decode(response.etapa));

                $('#gestor_sge_fix').html(url_decode(response.gestor));
                $('#fase_acao_projeto_fix').html(url_decode(response.etapa));

                if (response.erro != '') {
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });
    }

    function parListarCmb_idt_projeto_acao() {
        var par = '';

        if ($('#idt_projeto').val() == '') {
            alert('Favor informar o Projeto!');
            return false;
        } else {
            par += '&idt_projeto=' + $('#idt_projeto').val();
        }

        return par;
    }

    function parListarConf_grc_atendimento_pendencia() {
        var par = '';

        par += '&grc_atendimento=S';
        par += '&idt_pessoa=' + $('#idt_pessoa').val();
        par += '&idt_cliente=' + $('#idt_cliente').val();

        return par;
    }

    function grc_atendimento_pendencia_fecha_ant() {
        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php?tipo=grc_atendimento_pendencia_fecha_ant',
            data: {
                cas: conteudo_abrir_sistema,
                session_cod: $('#grc_atendimento_pendencia').data('session_cod')
            },
            success: function (response) {
                if (response.erro == '') {
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

    function grc_atendimento_pendencia_fecha() {
        processando();
        btFechaCTC($('#grc_atendimento_resumo').data('session_cod'));
        $("#dialog-processando").remove();
    }
    function RefreshResumo()
    {
        refreshCTC($('#grc_atendimento_resumo').data('session_cod'));
    }

</script>
