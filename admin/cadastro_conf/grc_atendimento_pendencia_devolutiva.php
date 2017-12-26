<style>
    body {
        padding: 5px;
    }

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

    .display_none {
        display: none;
    }


</style>

<?php
//p($_GET);

$vetPadraoLC = Array(
    'barra_inc_img' => "imagens/incluir_16.png",
    'barra_alt_img' => "imagens/alterar_16.png",
    'barra_con_img' => "imagens/consultar_16.png",
    'barra_exc_img' => "imagens/excluir_16.png",
);

unset($vetConfMsg['inc']);
$barra_bt_top = false;

if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."', null, parent.grc_atendimento_pendencia_fecha_ant);";
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
$idt_atendimento = $_GET['idt0'];
if ($idt_atendimento == "") {
    $idt_atendimento = 0;
}


// p($_GET);

$idt_evento = 0;
$ativo = '';

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
        $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
        $ativo = $row['ativo'];
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
    $idt_pessoa = $_GET['idt_pessoa'];
    $idt_cliente = $_GET['idt_cliente'];

    $sql = "select  ";
    $sql .= " grc_a.*  ";
    $sql .= " from grc_atendimento grc_a ";
    $sql .= " where idt = ".null($idt_atendimento);
    $rs = execsql($sql);
    $wcodigo = '';
    ForEach ($rs->data as $row) {
        $protocolo = $row['protocolo'];
        $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
    }
    $sql = "select grc_ap.* from grc_atendimento_pessoa grc_ap ";
    $sql .= " where ";
    $sql .= "    idt  =  ".null($idt_pessoa);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $codigo_pf = $row['cpf'];
        $nome_pf = $row['nome'];
        $codigo_siacweb_pf = $row['codigo_siacweb'];
    }
    if ($idt_cliente > 0) {
        $sql = "select grc_ao.* from grc_atendimento_organizacao grc_ao ";
        $sql .= " where ";
        $sql .= "    idt  =  ".null($idt_cliente);
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $codigo_pj = $row['cnpj'];
            $nome_pj = $row['razao_social'];
            $codigo_siacweb_pj = $row['codigo_siacweb_e'];
        }
    }
}

//alert('to na área');

if ($ativo == 'N') {
    $acao = 'con';
    $_GET['acao'] = $acao;
    alert('Pendência já foi fechada. Só pode Consultar.');
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
    $solucao = 'Parecer do Gestor';
}


if ($acao == 'inc') {
    $vetCampo['temporario'] = objHidden('temporario', 'S');
} else {
    $vetCampo['temporario'] = objHidden('temporario', 'N');
}

$id = 'idt';
$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);

$corbloq = "#FFFF80";
$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
$vetCampo['protocolo'] = objTexto('protocolo', $protocolo_titulo, false, 15, 45, $jst);

$corbloq = "#FFFF80";
$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
$vetCampo['status'] = objTexto('status', 'Status', false, 15, 45, $jst);

$vetCampo['ativo'] = objHidden('ativo', 'S');



$vetCampo['idt_ponto_atendimento'] = objFixoBanco('idt_ponto_atendimento', 'Ponto de Atendimento', ''.db_pir.'sca_organizacao_secao', idt, 'descricao');



if ($_GET['grc_atendimento'] == 'S') {
    $vetCampo['idt_responsavel_solucao'] = objHidden('idt_responsavel_solucao', '');
} else {
//$sql  = " select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";

    $sql = "select id_usuario, nome_completo  descricao from plu_usuario ";
    $sql .= " where matricula_intranet <> '' ";
    $sql .= " order by nome_completo";

    $js_hm = "";
    $style = "";
    $vetCampo['idt_responsavel_solucao'] = objCmbBanco('idt_responsavel_solucao', 'Responsável pela Solução', false, $sql, ' ', $style, $js_hm);
}

//
// pegar gestor local da unidade de atendimento
//
//$sql  = " select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
//$sql .= " where plu_usu.id_usuario = ".null($_SESSION[CS]['g_idt_gestor_local']);

$sql = "select id_usuario, nome_completo  descricao from plu_usuario ";
$sql .= " where matricula_intranet <> '' ";
$sql .= " order by nome_completo";

//
$js_hm = "";
$style = " width:400px; ";
$vetCampo['idt_gestor_local'] = objCmbBanco('idt_gestor_local', 'Responsável Gestor', true, $sql, ' ', $style, $js_hm);


$sql = " select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
if ($acao != 'inc') {
    $sql .= " where plu_usu.id_usuario = ".null($idt_usuario);
} else {
    
}
//    $js_hm   = " disabled  ";
$js_hm = " disabled style='background:{$corbloq}; font-size:12px; width:280px;' ";

$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Consultor', false, $sql, '', $style, $js_hm);

$js = "";
$vetCampo['data_dasolucao'] = objData('data_dasolucao', 'Data da Solução', False, $js, '', 'S');

$js = "";
$vetCampo['data_solucao'] = objData('data_solucao', 'Prazo de Resposta', False, $js, '', 'S');


$js = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['data'] = objDatahora('data', $data_titulo, False, $js, 'S');

$maxlength = 2000;
$style = "border: none;";
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
$js = "";
$vetCampo['enviar_email'] = objCmbVetor('enviar_email', 'Enviar E-mail?', false, $vetSimNao, ' ', $js);

$maxlength = 255;
$style = "border: none; height:30px;";
$js = "";

$vetCampo['assunto'] = objTextArea('assunto', $assunto_titulo, true, $maxlength, $style, $js);

$js = "";
$vetCampo['recorrencia'] = objCmbVetor('recorrencia', 'Recorrência?', false, $vetRecorrencia, ' ', $js);


$vetCampo['botao_concluir_pendencia_distancia'] = objInclude('botao_concluir_pendencia_distancia', 'cadastro_conf/botao_concluir_pendencia_distancia.php');

$vetCampo['relatorio_devolutiva_distancia'] = objInclude('relatorio_devolutiva_distancia', 'incdistancia_devolutiva.php');


$vetCampo['relatorio_devolutiva_distancia_anexos'] = objInclude('relatorio_devolutiva_distancia_anexos', 'cadastro_conf/botao_concluir_pendencia_distancia_anexos.php');


$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";

$class_titulo_c = "class_titulo_c";

$titulo_na_linha = false;

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
Array($vetCampo['relatorio_devolutiva_distancia']),
		), $class_frame, $class_titulo, $titulo_na_linha);
		
$vetFrm[] = Frame('', Array(
Array($vetCampo['relatorio_devolutiva_distancia_anexos']),
		), $class_frame, $class_titulo, $titulo_na_linha);
		
$vetFrm[] = Frame('', Array(
		Array($vetCampo['solucao']),
			), $class_frame, $class_titulo, $titulo_na_linha);
$vetFrm[] = Frame('', Array(
	Array($vetCampo['botao_concluir_pendencia_distancia']),
	
		), $class_frame, $class_titulo, $titulo_na_linha);
$vetCad[] = $vetFrm;

?>
<script type="text/javascript">
//
    var idt_evento = '<?php echo $idt_evento; ?>';
    var idt_instrumento = '<?php echo $idt_instrumento; ?>';
//
    $(document).ready(function () {
        if (acao == 'inc') {
            valida_cust = 'N';
            $(':submit:first').click();
        }

        objd = document.getElementById('idt_ponto_atendimento_tf');
        if (objd != null)
        {
            $(objd).css('background', '#FFFF80');
            $(objd).attr('disabled', 'disabled');
        }

        objd = document.getElementById('assunto');
        if (objd != null)
        {
            // $(objd).css('background','#FFFF80');
            // $(objd).attr('disabled','disabled');
        }

        objd = document.getElementById('observacao');
        if (objd != null)
        {
            // $(objd).css('background','#FFFF80');
            // $(objd).attr('disabled','disabled');
        }



    });

    function parListarConf_grc_atendimento_pendencia_anexo() {
        var par = '';
        par += '&tipo=C';
        return par;
    }
</script>
