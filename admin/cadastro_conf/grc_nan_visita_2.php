<style>
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
    }

    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        padding-top:10px;
    }

    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame_p {
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

    div.class_titulo_p_barra_cinza {
        text-align: left;
        background: #c4c9cd;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        font-weight: bold;
        line-height: 12px;
        margin: 0;
        padding: 3px;
        padding-left: 20px;
    }

    fieldset.class_frame {
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }

    div.class_titulo {
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
        text-align:left;
        border:0px;
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

    #nan_ciclo_obj .TextoFixo {
        background: #2f66b8 none repeat scroll 0 0;
        border: 0 none;
        color: rgb(255, 255, 255);
        font-size: 12px;
        text-align: center;
        height: 13px;
        min-height: 13px;
    }

    #grc_atendimento_anexo_tit_desc {
        padding-top: 10px;
    }

    #idt_nan_empresa_tf,
    #idt_consultor_tf,
    #idt_unidade_tf,
    #idt_projeto_txt,
    #idt_projeto_acao_txt {
        background-color: #ffffd7;
    }

    #linha1_desc {
        height: 12px;
    }

    #linha1_obj {
        border-top: 2px solid #ecf0f1;
        height: 5px;
    }

    #cresce_desc,
    #grc_plano_facil_ferramenta_barra_desc,
    #grc_plano_facil_plano_acao_desc,
    #barra_plano_facil_1_desc,
    #barra_plano_facil_3_desc,
    #barra_plano_facil_5_desc {
        width: 500px;
    }

    #barra_plano_facil_espaco_1_desc,
    #barra_plano_facil_espaco_2_desc,
    #barra_plano_facil_espaco_3_desc,
    #barra_plano_facil_espaco_4_desc,
    #barra_plano_facil_espaco_5_desc,
    #barra_plano_facil_espaco_6_desc {
        width: 20px;
    }
</style>
<?php
if ($_GET['pesquisa'] == 'SC') {
    $_GET['acao'] = 'alt';
    $acao = $_GET['acao'];
    $acao_alt_con = 'S';
}

if ($_SESSION[CS]['tmp'][CSU]['vetParametrosMC']['nan_ap'] == 'S') {
    $nan_ap = $_SESSION[CS]['tmp'][CSU]['vetParametrosMC']['nan_ap'];

    $sql = '';
    $sql .= ' select idt_atendimento_agenda';
    $sql .= ' from grc_atendimento';
    $sql .= ' where idt = '.null($_GET['id']);
    $rs = execsql($sql);

    $_GET['idt_atendimento'] = $_GET['id'];
    $_GET['idt_atendimento_agenda'] = $rs->data[0][0];
}

if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
$tabela = 'grc_atendimento';
$id = 'idt';

$vetPadraoLC = Array(
    'barra_inc_img' => "imagens/incluir_16.png",
    'barra_alt_img' => "imagens/alterar_16.png",
    'barra_con_img' => "imagens/consultar_16.png",
    'barra_exc_img' => "imagens/excluir_16.png",
);


$onSubmitCon = 'grc_atendimento_con()';
$onSubmitDep = 'grc_atendimento_dep()';

$vetConfMsg['alt'] = 'Para voltar a tela anterior necessário gravar as informações.\n\nConfirma?';

$bt_alterar_lbl = 'Voltar';
$bt_alterar_aviso = 'Não esqueça de clicar no botão Enviar para Validação para salvar a sua alteração!';

$sql2 = 'select ';
$sql2 .= '  a.idt_atendimento_agenda, c.fechado';
$sql2 .= '  from grc_atendimento a';
$sql2 .= ' left outer join grc_competencia c on c.idt = a.idt_competencia';
$sql2 .= '  where a.idt = '.null($_GET['id']);
$rs_aap = execsql($sql2);

/*
  if ($rs_aap->data[0]['fechado'] == 'S') {
  $acao = 'con';
  $_GET['acao'] = $acao;
  alert('Esse competência deste atendimento já foi fechada. Só pode Consultar.');
  }
 * 
 */

if ($_GET['pesquisa'][0] == 'S') {
    $idt_atendimento = $_GET['id'];
    $idt_atendimento_agenda = $rs_aap->data[0]['idt_atendimento_agenda'];

    if ($_GET['session_volta'] == '') {
        $_GET['session_volta'] = 'listar';
    }

    $sql = "update grc_atendimento set data_atendimento_relogio = 'N' where idt = ".null($idt_atendimento);
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

if ($_GET['cont'] != 's') {
    if ($_GET['balcao'] == 2) {
        $instrumento = $_GET['instrumento2'];
        if ($instrumento == 1) {
            
        }
        $html = ChamaInstrumentoContabiliza($instrumento);
    }
}

$instrumento = $_GET['instrumento2'];

if ($instrumento == 1) {
    
}

$html = ChamaInstrumentoContabiliza($instrumento);

$TabelaPai = "grc_atendimento_agenda";
$AliasPai = "grc_aa";
$EntidadePai = "Agenda";
$idPai = "idt";

$TabelaPrinc = "grc_atendimento";
$AliasPric = "grc_a";
$Entidade = "Atendimento da Agenda";
$Entidade_p = "Atendimentos da Agenda";
$CampoPricPai = "idt_atendimento_agenda";

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'assunto', 0);

$idt_cliente = 0;
$idt_ponto_atendimento = 0;
$idt_pessoa = 0;
$idt_projeto = 0;
$idt_projeto_acao = 0;
$idt_atendimento = $_GET['id'];
$inc_cont = $_GET['cont'];
$idt_ponto_atendimento = $_GET['idt0'];

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
        $idt_instrumento = $row['idt_instrumento'];
        $situacao = $row['situacao'];
        $gestor_sge = $row['gestor'];
        $fase_acao_projeto = $row['etapa'];
        $instrumento = $row['idt_instrumento'];
        $codigo_tema = $row['grc_ts_codigo'];
        $idt_unidade = $row['idt_unidade'];
        $idt_grupo_atendimento = $row['idt_grupo_atendimento'];

        $sqlw = "select  ";
        $sqlw .= " grc_ap.codigo_siacweb as grc_ap_codigo_siacweb, ";
        $sqlw .= " grc_ap.cpf            as grc_ap_cpf ";
        $sqlw .= " from grc_atendimento_pessoa grc_ap ";
        $sqlw .= " where idt_atendimento = {$idt_atendimento} ";
        $sqlw .= "      and tipo_relacao = ".aspa('L');
        $rsw = execsql($sqlw);
        ForEach ($rsw->data as $roww) {
            $CodParceiro = $roww['grc_ap_codigo_siacweb'];
            $CPFCliente = $roww['grc_ap_cpf'];
        }
        if ($CodParceiro == "") {
            $CodParceiro = 0;
        }
    }
    if (($situacao == 'Finalizado' || $situacao == 'Cancelado') && $acao != 'con' && $_GET['pesquisa'][0] != 'S') {
        $acao = 'con';
        $_GET['acao'] = $acao;
        alert('Esse atendimento já foi '.mb_strtoupper($situacao).'. Só pode Consultar.');
    }
} else {

    $idt_consultor = $_SESSION[CS]['g_id_usuario'];
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
        $idt_atendimento = $idt_atendimentow;
    }
}

$href = "conteudo{$cont_arq}.php?prefixo=inc&menu=grc_nan_visita_2&session_volta=".$_GET['session_volta']."&idt_atendimento_agenda=".$idt_atendimento_agenda."&idt_atendimento=".$idt_atendimento."&id=".$idt_atendimento_agenda."&pesquisa=".$_GET['pesquisa']."&aba=2";

if ($_GET['pesquisa'][0] == 'S') {
    //$par = getParametro('menu,prefixo', false);
    //$href = "conteudo.php?prefixo=cadastro&menu=grc_nan_visita_2_cadastro&menu_origem=".$menu.$par;

    if ($acao == 'con') {
        $botao_volta_include = 'self.location = "'.$href.'"';
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
    $barra_bt_top = false;
    $mostra_bt_volta = false;
}

$botao_acao = '<script type="text/javascript">self.location = "'.$href.'";</script>';
?>
<script>
    var acao = '<?php echo $acao; ?>';
    var inc_cont = '<?php echo $inc_cont; ?>';
</script>
<?php
$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; width:100%;' ";
$vetCampo_f['protocolo'] = objHidden('protocolo', '');
$vetCampo['senha_totem'] = objTexto('senha_totem', 'Senha', false, 20, 45, $jst);


$sql = "select idt,  descricao from ".db_pir."sca_organizacao_secao ";
$sql .= " where posto_atendimento = 'S'";
$sql .= ' and SUBSTRING(classificacao, 1, 5) = ('; //and
$sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
$sql .= ' from '.db_pir.'sca_organizacao_secao';
$sql .= ' where idt = '.null($idt_unidade);
$sql .= ' )';
$sql .= ' and idt <> '.null($idt_unidade);
$sql .= ' order by classificacao ';
$js = " ";
$vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto de Atendimento', true, $sql, ' ', ' width:99%; font-size:12px;', $js);

$sql = '';
$sql .= ' select idt, nome';
$sql .= ' from grc_atendimento_pessoa';
$sql .= ' where idt_atendimento = '.null($_GET['id']);
$sql .= " and tipo_relacao = 'L'";
$rst = execsql($sql);
$rowt = $rst->data[0];

$vetCampo['idt_pessoa'] = objHidden('idt_pessoa', $rowt['idt'], 'Cliente', $rowt['nome']);

$sql = '';
$sql .= ' select idt, razao_social';
$sql .= ' from grc_atendimento_organizacao';
$sql .= ' where idt_atendimento = '.null($_GET['id']);
$sql .= " and representa = 'S'";
$sql .= " and desvincular = 'N'";
$rst = execsql($sql);
$rowt = $rst->data[0];

$vetCampo['idt_cliente'] = objHidden('idt_cliente', $rowt['idt'], 'Empreendimento', $rowt['razao_social']);

$vetCampo['idt_consultor'] = objFixoBanco('idt_consultor', 'Consultor/Atendente', 'plu_usuario', 'id_usuario', 'nome_completo', '', true, ' ', true);



$maxlength = 2000;
$style = "width:830px; ";
$js = "";
$vetCampo['assunto'] = objTextArea('assunto', 'Resumo do Assunto', false, $maxlength, $style, $js);

$maxlength = 2000;
$style = "width:99%; ";
$js = "";
$vetCampo['diagnostico'] = objTextArea('diagnostico', 'Diagnóstico', false, $maxlength, $style, $js);

$maxlength = 2000;
$style = "width:99%; ";
$js = "";
$vetCampo['devolutiva'] = objTextArea('devolutiva', 'Devolutiva', true, $maxlength, $style, $js);


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


$sql = "select gec_ge.idt, gec_ge.descricao from ".db_pir_gec."gec_entidade_grau_formacao gec_ge ";
$sql .= " order by gec_ge.codigo";
$js_hm = " disabled style='padding-left:20px; width:800px; background:#0000FF; color:#FFFFFF; text-align:center; font-size:12px;' ";
$js_hm = "";
$vetCampo['idt_escolaridade'] = objCmbBanco('idt_escolaridade', 'Escolaridade', false, $sql, ' ', 'width:200px;', $js_hm);



$sql = "select gec_op.idt, gec_op.descricao from ".db_pir_gec."gec_organizacao_porte gec_op ";
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

$vetCampo['idt_projeto'] = objListarCmb('idt_projeto', 'grc_projeto', 'Projeto', true, '442px', '', true, false);

$vetCampo['idt_projeto_acao'] = objListarCmb('idt_projeto_acao', 'grc_projeto_acao', 'Ação do Projeto', true, '442px', '', true, false);

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
$sql .= "   and substring(grc_ts.codigo,1,3) =  ".aspa($codigo_tema.'.');
$sql .= " and ativo = 'S'";
$sql .= " order by  grc_ts.descricao";
$js_hm = " style='background:{$corbloq}; font-size:12px; width:99%;' ";
$vetCampo['idt_subtema_tratado'] = objCmbBanco('idt_subtema_tratado', 'Subtema Tratado', false, $sql, ' ', '', $js_hm);

$sql = "select grc_ts.idt,  grc_ts.descricao from grc_tema_subtema grc_ts ";
$sql .= " where grc_ts.nivel =  0 ";
$sql .= " and ativo = 'S'";
$sql .= " order by  grc_ts.descricao";
$js_hm = " style='background:{$corbloq}; font-size:12px; width:100%;' ";
$vetCampo['idt_tema_interesse'] = objCmbBanco('idt_tema_interesse', 'Temas de Interesse', false, $sql, ' ', 'width:100%;', $js_hm);

$sql = "select grc_ts.idt,  grc_ts.descricao from grc_tema_subtema grc_ts ";
$sql .= " where grc_ts.nivel  =  1 ";
$sql .= "   and substring(grc_ts.codigo,1,3) =  ".aspa($codigo_tema.'.');
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


$vetCampo_f['botao_concluir_atendimento'] = objInclude('botao_concluir_atendimento', 'cadastro_conf/botao_concluir_nan_visita_1.php');

$vetCampo['botao_inc_temainteresse'] = objInclude('botao_inc_temainteresse', 'cadastro_conf/botao_inc_temainteresse.php');

$vetCampo['botao_inc_tematratado'] = objInclude('botao_inc_tematratado', 'cadastro_conf/botao_inc_tematratado.php');

$sql = '';
$sql .= ' select nan_ciclo';
$sql .= ' from grc_nan_grupo_atendimento';
$sql .= ' where idt = ' . null($idt_grupo_atendimento);
$rs = execsql($sql);
$vetCampo['nan_ciclo'] = objHidden('nan_ciclo', $rs->data[0][0], 'Fase', $vetNanCicloAtendimento[$rs->data[0][0]], false);

$vetCampo['idt_nan_tutor'] = objFixoBanco('idt_nan_tutor', 'Tutor', 'plu_usuario', 'id_usuario', 'nome_completo', '', true, ' ', true);
$vetCampo['idt_nan_empresa'] = objFixoBanco('idt_nan_empresa', 'Empresa Credenciada', 'plu_usuario', 'id_usuario', 'nome_completo', '', true, ' ', true);
$vetCampo['idt_unidade'] = objFixoBanco('idt_unidade', 'Unidade', db_pir.'sca_organizacao_secao', 'idt', 'descricao', '', true, ' ', true);

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


$vetFrm[] = Frame('', Array(
    Array($vetCampo['data_atendimento_aberta']),
    Array($vetCampo['data_atendimento_relogio']),
        ), $class_frame, $class_titulo, false);


$vetCampo['linha1'] = objHidden('linha1', '', '', '', false);

MesclarCol($vetCampo['linha1'], 3);

if ($nan_ap == 'S') {
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_nan_empresa'], '', $vetCampo['idt_consultor']),
        Array($vetCampo['idt_unidade'], '', $vetCampo['idt_ponto_atendimento']),
        Array($vetCampo['idt_projeto'], '', $vetCampo['idt_projeto_acao']),
        Array($vetCampo['linha1']),
        Array($vetCampo['idt_pessoa'], '', $vetCampo['idt_cliente']),
            ), $class_frame, $class_titulo, false, $vetParametros);
} else {
    MesclarCol($vetCampo['idt_instrumento'], 3);
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_instrumento']),
        Array($vetCampo['idt_nan_empresa'], '', $vetCampo['idt_consultor']),
        Array($vetCampo['idt_unidade'], '', $vetCampo['idt_ponto_atendimento']),
        Array($vetCampo['idt_projeto'], '', $vetCampo['idt_projeto_acao']),
        Array($vetCampo['linha1']),
        Array($vetCampo['idt_pessoa'], '', $vetCampo['idt_cliente']),
            ), $class_frame, $class_titulo, false, $vetParametros);
}

// inicio
$vetCad[] = $vetFrm;
$vetFrm = Array();

$vetFrm[] = Frame('', Array(
    Array($vetCampo['nan_ciclo'], '', $vetCampo['data'], '', $vetCampo['hora_inicio_atendimento'], '', $vetCampo['hora_termino_atendimento'], '', $vetCampo['horas_atendimento'], '', $vetCampo['idt_nan_tutor'], '', $vetCampo['idt_competencia']),
        ), $class_frame, $class_titulo, false, $vetParametros);

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

$vetCampo_full = Array();
//Monta o vetor de Campo

$vetCampo_full['grc_tema'] = CriaVetTabela('Tema');
$vetCampo_full['grc_sub_tema'] = CriaVetTabela('Subtema');

$vetTratamento = Array();
$vetTratamento['T'] = 'Tratado';
$vetTratamento['I'] = 'Interesse';

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

$sql .= " where {$AliasPric}".'.idt_atendimento = $vlID';
$sql .= " and tipo_tratamento = 'T' ";
$sql .= " order by {$orderby}";
// Carrega campos que serão editados na tela full
$vetCampox['grc_atendimento_tema_tratado'] = objListarConf('grc_atendimento_tema_tratado', 'idt', $vetCampo_full, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));
$vetCampox['grc_atendimento_tema_tratado_tit'] = objBarraTitulo('grc_atendimento_tema_tratado_tit', 'QUALIFICAÇÃO DA DEMANDA (TEMAS TRATADOS)', 'class_titulo_p_barra');

// Fotmata lay_out de saida da tela full
// INÍCIO
// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________


if ($acao == 'con' || $acao == 'exc' || $nan_ap == 'S') {
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
        'barra_con_ap' => false,
        'barra_exc_ap' => true,
        'contlinfim' => '',
        'func_trata_row' => grc_atendimento_pessoa_representante,
    );
}

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
$sql .= " where {$AliasPric}".'.idt_atendimento = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full



$vetCampox['grc_atendimento_pessoa'] = objListarConf('grc_atendimento_pessoa', 'idt', $vetCampo, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));
$vetCampox['grc_atendimento_pessoa_tit'] = objBarraTitulo('grc_atendimento_pessoa_tit', 'VINCULAR PESSOAS AO ATENDIMENTO', 'class_titulo_p_barra');

if ($acao == 'con' || $acao == 'exc' || $nan_ap == 'S') {
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
        'barra_con_ap' => false,
        'barra_exc_ap' => true,
        'contlinfim' => '',
    );
}

$vetCampo = Array();
//Monta o vetor de Campo
$vetCampo['descricao'] = CriaVetTabela('Título do Anexo');
$vetCampo['arquivo'] = CriaVetTabela('Arquivo anexado', 'arquivo_sem_nome', '', 'grc_atendimento_anexo');
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
$sql .= " where {$AliasPric}".'.idt_atendimento = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full



$vetCampox['grc_atendimento_anexo'] = objListarConf('grc_atendimento_anexo', 'idt', $vetCampo, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametros));
$vetCampox['grc_atendimento_anexo_tit'] = objBarraTitulo('grc_atendimento_anexo_tit', 'VINCULAR ANEXOS AO ATENDIMENTO', 'class_titulo_p_barra');

//tema_tratado
$vetParametros = Array(
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampox['grc_atendimento_pessoa_tit'], 'tde1', $vetCampox['grc_atendimento_tema_tratado_tit']),
    Array($vetCampox['grc_atendimento_pessoa'], 'tde2', $vetCampox['grc_atendimento_tema_tratado']),
    Array($vetCampox['grc_atendimento_anexo_tit'], 'tde3', 'tdr1'),
    Array($vetCampox['grc_atendimento_anexo'], 'tde4', 'tdr2'),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCampo['barra_plano_facil'] = objBarraTitulo('barra_plano_facil', 'PLANO FÁCIL', 'class_titulo_p_barra');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['barra_plano_facil']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCampo['barra_plano_facil_1'] = objBarraTitulo('barra_plano_facil_1', '1 - EU OBSERVO E PRIORIZO', 'class_titulo_p_barra_cinza');
$vetCampo['barra_plano_facil_2'] = objBarraTitulo('barra_plano_facil_2', '2 - EU DECIDO E PLANEJO', 'class_titulo_p_barra_cinza');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['barra_plano_facil_1'], 'barra_plano_facil_espaco_1', $vetCampo['barra_plano_facil_2']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$sql = '';
$sql .= ' select *';
$sql .= ' from grc_plano_facil';
$sql .= ' where idt_atendimento = '.null($_GET['id']);
$rsPF = execsql($sql);
$rowPF = $rsPF->data[0];
define('idtPF', $rowPF['idt']);

$titulo = 'Ferramentas Indicadas';

$vetCampoLC = Array();
$vetCampoLC['ferramenta'] = CriaVetTabela('Ferramenta');
$vetCampoLC['area'] = CriaVetTabela('Área de Conhecimento');

$sql = '';
$sql .= ' select pff.*, fg.descricao as ferramenta, fa.descricao as area';
$sql .= ' from grc_plano_facil_ferramenta pff';
$sql .= ' inner join grc_formulario_ferramenta_gestao fg on fg.idt = pff.idt_ferramenta';
$sql .= ' inner join grc_plano_facil_area pfa on pfa.idt = pff.idt_plano_facil_area';
$sql .= ' inner join grc_formulario_area fa on fa.idt = pfa.idt_area';
$sql .= ' where pfa.idt_plano_facil = '.null($rowPF['idt']);
$sql .= " and pff.ativo = 'S'";
$sql .= ' order by pff.idt';

$vetParametrosPF = Array(
    'menu_acesso' => 'grc_plano_facil_ferramenta',
    'barra_inc_ap' => false,
    'barra_alt_ap' => false,
    'barra_con_ap' => false,
    'barra_exc_ap' => false,
    'contlinfim' => '',
    'comcontrole' => 0,
);

$vetCampo['grc_plano_facil_ferramenta'] = objListarConf('grc_plano_facil_ferramenta', 'idt', $vetCampoLC, $sql, $titulo, true, array_merge($vetPadraoLC, $vetParametrosPF), 'grc_plano_facil_ferramenta');
$vetCampo['grc_plano_facil_ferramenta_barra'] = objBarraTitulo('grc_plano_facil_ferramenta_barra', 'FERRAMENTAS INDICADAS', 'class_titulo_p_barra');

$titulo = 'Ferramentas priorizadas pelo cliente';

$vetCampoLC = Array();
$vetCampoLC['ferramenta'] = CriaVetTabela('Ferramenta');
$vetCampoLC['area'] = CriaVetTabela('Área de Conhecimento');

$sql = '';
$sql .= ' select pffp.*, fg.descricao as ferramenta, fa.descricao as area';
$sql .= ' from grc_plano_facil_ferramenta_pri pffp';
$sql .= ' inner join grc_plano_facil_ferramenta pff on pff.idt = pffp.idt_grc_plano_facil_ferramenta';
$sql .= ' inner join grc_formulario_ferramenta_gestao fg on fg.idt = pff.idt_ferramenta';
$sql .= ' inner join grc_plano_facil_area pfa on pfa.idt = pff.idt_plano_facil_area';
$sql .= ' inner join grc_formulario_area fa on fa.idt = pfa.idt_area';
$sql .= ' where pffp.idt_atendimento = '.null($_GET['id']);
$sql .= ' order by pff.idt';

$vetParametrosPF = Array(
    'menu_acesso' => 'grc_plano_facil_ferramenta',
    'barra_inc_ap' => true,
    'barra_alt_ap' => false,
    'barra_con_ap' => false,
    'barra_exc_ap' => true,
    'contlinfim' => '',
);

$vetCampo['grc_plano_facil_ferramenta_pri'] = objListarConf('grc_plano_facil_ferramenta_pri', 'idt', $vetCampoLC, $sql, $titulo, true, array_merge($vetPadraoLC, $vetParametrosPF));
$vetCampo['grc_plano_facil_ferramenta_pri_barra'] = objBarraTitulo('grc_plano_facil_ferramenta_pri_barra', 'FERRAMENTAS PRIORIZADAS PELO CLIENTE', 'class_titulo_p_barra');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_plano_facil_ferramenta_barra'], 'barra_plano_facil_espaco_6', $vetCampo['grc_plano_facil_ferramenta_pri_barra']),
    Array($vetCampo['grc_plano_facil_ferramenta'], '', $vetCampo['grc_plano_facil_ferramenta_pri']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCampo['barra_plano_facil_3'] = objBarraTitulo('barra_plano_facil_3', '3 - EU FAÇO', 'class_titulo_p_barra_cinza');
$vetCampo['barra_plano_facil_4'] = objBarraTitulo('barra_plano_facil_4', '4 - EU APRENDO', 'class_titulo_p_barra_cinza');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['barra_plano_facil_3'], 'barra_plano_facil_espaco_2', $vetCampo['barra_plano_facil_4']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$titulo = 'Plano de Ação';

$vetCampoLC = Array();
$vetCampoLC['quem'] = CriaVetTabela('Quem');
$vetCampoLC['quando'] = CriaVetTabela('Quando', 'data');

$sql = '';
$sql .= ' select pfpa.*';
$sql .= ' from grc_plano_facil_plano_acao pfpa';
$sql .= ' where pfpa.idt_atendimento = '.null($_GET['id']);
$sql .= ' order by pfpa.idt';

$vetParametrosPF = Array(
    'contlinfim' => '',
);

$vetCampo['grc_plano_facil_plano_acao'] = objListarConf('grc_plano_facil_plano_acao', 'idt', $vetCampoLC, $sql, $titulo, true, array_merge($vetPadraoLC, $vetParametrosPF));

$titulo = 'Eu Aprendo';

$vetCampoLC = Array();
$vetCampoLC['produto'] = CriaVetTabela('Produto');

$sql = '';
$sql .= ' select pfp.*, p.descricao as produto';
$sql .= ' from grc_plano_facil_produto pfp';
$sql .= ' inner join grc_produto p on p.idt = pfp.idt_produto';
$sql .= ' where pfp.idt_atendimento = '.null($_GET['id']);
$sql .= ' order by p.descricao';

$vetParametrosPF = Array(
    'contlinfim' => '',
);

$vetCampo['grc_plano_facil_produto'] = objListarConf('grc_plano_facil_produto', 'idt', $vetCampoLC, $sql, $titulo, false, array_merge($vetPadraoLC, $vetParametrosPF));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_plano_facil_plano_acao'], 'barra_plano_facil_espaco_4', $vetCampo['grc_plano_facil_produto']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCampo['barra_plano_facil_5'] = objBarraTitulo('barra_plano_facil_5', '5 - VEJO MINHA EMPRESA CRESCER', 'class_titulo_p_barra_cinza');
$vetCampo['barra_plano_facil_6'] = objBarraTitulo('barra_plano_facil_6', '6 - BANCO DE IDÉIAS', 'class_titulo_p_barra_cinza');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['barra_plano_facil_5'], 'barra_plano_facil_espaco_3', $vetCampo['barra_plano_facil_6']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCampo['cresce'] = objInclude('cresce', 'cadastro_conf/grc_nan_visita_2_cresce.php');
$vetCampo['cresce']['linha'] = 4;

$vetCampo['banco_ideia'] = objTextArea('banco_ideia', 'Banco de Idéias', true, 2000, '', '', false, $rowPF['banco_ideia']);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['cresce'], 'barra_plano_facil_espaco_5', $vetCampo['banco_ideia']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$maxlength = 2000;
$style = "";
$js = "";
$vetCampo['demanda'] = objTextArea('demanda', 'Demandas, Necessidades e Comentários', true, $maxlength, $style, $js);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['demanda']),
        ), $class_frame, $class_titulo, false, $vetParametros);

if ($nan_ap == 'S') {
    $vetCampo['grc_nan_visita_1_ap_bt2'] = objInclude('grc_nan_visita_1_ap_bt2', 'cadastro_conf/grc_nan_visita_2_ap_bt2.php');

    MesclarCol($vetCampo['grc_nan_visita_1_ap_bt2'], 3);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_nan_visita_1_ap_bt2']),
        Array($vetCampo_f['situacao'], '', $vetCampo_f['protocolo']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
} else {
    $sql = '';
    $sql .= ' select observacao';
    $sql .= ' from grc_atendimento_pendencia';
    $sql .= ' where idt_atendimento  = '.null($idt_atendimento);
    $sql .= " and ativo  =  'S'";
    $sql .= " and tipo   =  'NAN - Visita 2'";
    $sql .= " and status =  'Devolver para Ajustes'";
    $rs = execsql($sql);

    $vetCampo['pen_observacao'] = objTextoFixo('pen_observacao', 'Comentários do Tutor', '', false, false, $rs->data[0][0]);

    $vetParametros = Array(
        'width' => '100%',
    );
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['pen_observacao']),
            ), $class_frame, $class_titulo, false, $vetParametros);

    MesclarCol($vetCampo_f['botao_concluir_atendimento'], 3);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo_f['botao_concluir_atendimento']),
        Array($vetCampo_f['situacao'], '', $vetCampo_f['protocolo']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}

//
// FIM ____________________________________________________________________________
//
// Fim da recuperação
//


$vetCad[] = $vetFrm;
?>
<script>
    var timerId = 0;
    var delay = 60000;

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
        if (valida_cust == 'N') {
            return true;
        }

        if (validaDataMenor(false, $('#data'), 'Data do Atendimento', $('#dtBancoObj'), 'Hoje') === false) {
            $('#data').focus();
            return false;
        }

        if ($('#data').val().substr(6) != '<?php echo date('Y'); ?>') {
            alert('A Data Início tem que estar no Ano de Competência!');
            return false;
        }

        calculaMinuto();

        if ($('#horas_atendimento').val() <= 0) {
            alert('A Duração (m.) não pode ser menor que um minuto!');
            return false;
        }

        return true;
    }

    function ajustaHeightTD() {
        $('#grc_atendimento_pessoa_desc').height($('#grc_atendimento_pessoa_desc > div').height());
        $('#grc_atendimento_anexo_tit_desc').height($('#grc_atendimento_anexo_tit_desc > div').height());
    }

    $(document).ready(function () {
        horas = $('#data, #hora_inicio_atendimento, #hora_termino_atendimento');
        horas_desc = $('#data_desc, #hora_inicio_atendimento_desc, #hora_termino_atendimento_desc');

        var txt = $('#idt_instrumento_tf').text();
        txt += ' - SEGUNDA VISITA';
        $('#idt_instrumento_tf').text(txt);

        var divProtocolo = $('<div id="divProtocolo">Protocolo de Atendimento: ' + $('#protocolo').val() + '</div>');
        $('#idt_instrumento_obj').append(divProtocolo);

        $('#grc_atendimento_tema_tratado_desc').attr('rowspan', 3);
        $('#tdr1_desc, #tdr1_obj, #tdr2_desc, #tdr2_obj').remove();

        $('#tde1_desc').attr('rowspan', 4);

        $('#grc_atendimento_pessoa_tit_desc, #grc_atendimento_tema_tratado_tit_desc, #grc_atendimento_pessoa_desc, #grc_atendimento_anexo_tit_desc, #grc_atendimento_anexo_desc').attr('rowspan', 1);
        $('#tde2_desc, #tde3_desc, #tde4_desc').remove();
        $('#tde1_obj, #tde2_obj, #tde3_obj, #tde4_obj').parent().remove();

        ajustaHeightTD();

        $('#hora_inicio_atendimento, #hora_termino_atendimento').change(function () {
            calculaMinuto();
        });

        $('#data').change(function () {
            if (validaDataMenor(false, $(this), 'Data do Atendimento', $('#dtBancoObj'), 'Hoje') === false) {
                $(this).focus();
                return false;
            }

            if ($(this).val() != '') {
                $('#hora_inicio_atendimento').change();
                $('#hora_termino_atendimento').change();

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

        objd = document.getElementById('idt_tema_tratado_obj');
        if (objd != null)
        {
            $(objd).css('width', '49%');
        }
        objd = document.getElementById('idt_subtema_tratado_obj');
        if (objd != null)
        {
            $(objd).css('width', '49%');
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
    });

    function ChamaCPFEspecial(thisw)
    {
        var ret = Valida_CPF(thisw);
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
</script>
