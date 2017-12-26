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
        border:1px solid #000000;
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
        border:1px solid #000000;


    }
    div.class_titulo_p {
        text-align: left;
        background: #2C3E50;
        border    : 1px solid #2C3E50;
        color     : #000000;
    }
    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }

    div.class_titulo_p_barra {
        text-align: left;
        background: #2C3E50;
        border    : 0px solid #2C3E50;
        color     : #000000;
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
        border:1px solid #2C3E50;
    }
    div.class_titulo {
        xbackground: #C4C9CD;
        xborder    : 1px solid #2C3E50;
        xcolor     : #FFFFFF;
        text-align: center;

        background: #FFFFFF;
        color     : #000000;
        border    : 1px solid #2C3E50;


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
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
}

$ano_base = '2017';
$TabelaPrinc = "grc_dw_{$ano_base}_indicadores_qualidade";
$AliasPric = "grc_iq";


$tabela = $TabelaPrinc;
$id = 'idt';


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

$botao_acao = '<script type="text/javascript">self.location = "' . $href . '";</script>';
?>
<script>
    var acao = '<?php echo $acao; ?>';
    var inc_cont = '<?php echo $inc_cont; ?>';</script>
<?php
$acao = 'con';
//$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; width:100%;' ";
//$vetCampo_f['protocolo'] = objHidden('protocolo', '');

$vetCampo['grc_indicador_obs'] = objInclude('grc_indicador_obs', 'cadastro_conf/grc_indicador_obs.php');

$vetParametros = Array(
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_indicador_obs']),
        ), 'grc_indicador_frm', $class_titulo, false, $vetParametros);

$vetParametros = Array(
    'width' => '',
);

$jst = "";
$vetCampo['ponto_atendimento'] = objTexto('ponto_atendimento', 'Ponto Atendimento', false, 45, 120, $jst);
$vetCampo['nome_consultor'] = objTexto('nome_consultor', 'Atendente/Consultor', false, 45, 120, $jst);
$vetCampo['data_atendimento'] = objDataHora('data_atendimento', 'Data Atendimento', false);

MesclarCol($vetCampo['data_atendimento'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['ponto_atendimento'], '', $vetCampo['nome_consultor']),
    Array($vetCampo['data_atendimento']),
        ), $class_frame, $class_titulo, false, $vetParametros);

$vetCampo['cpf'] = objTexto('cpf', 'CPF', false, 45, 45, $jst);
$vetCampo['nome'] = objTexto('nome', 'Nome', false, 45, 120, $jst);

$vetCampo['logradouro_cep'] = objCEP('logradouro_cep', 'CEP', True);
$vetCampo['logradouro_endereco'] = objTexto('logradouro_endereco', 'Logradouro', True, 45, 120, $js2);
$vetCampo['logradouro_numero'] = objTexto('logradouro_numero', 'Número', True, 15, 6, $js3);
$vetCampo['logradouro_complemento'] = objTexto('logradouro_complemento', 'Complemento', false, 30, 70, $js4);
$vetCampo['logradouro_bairro'] = objTexto('logradouro_bairro', 'Bairro', True, 34, 120, $js1);
$vetCampo['logradouro_cidade'] = objTexto('logradouro_cidade', 'Cidade', True, 45, 120, $js2);
$vetCampo['logradouro_estado'] = objTexto('logradouro_estado', 'Estado', True, 2, 2, $js3);
$vetCampo['logradouro_pais'] = objTexto('logradouro_pais', 'País', True, 30, 120, $js4);

$vetCampo['data_nascimento'] = objData('data_nascimento', 'Data Nascimento', true, $js1, '', 'S');

$vetCampo['telefone_residencial'] = objTexto('telefone_residencial', 'Telefone Residencial', false, 45, 120, $jst);
$vetCampo['telefone_celular'] = objTexto('telefone_celular', 'Telefone Celular', false, 45, 120, $jst);
$vetCampo['telefone_recado'] = objTexto('telefone_recado', 'Telefone de Reacado', false, 45, 120, $jst);

$vetCampo['email'] = objEmail('email', 'Endereço de e-mail', false, 30, 120, $js2);

MesclarCol($vetCampo['nome'], 5);
MesclarCol($vetCampo['telefone_telefone_recado'], 3);
MesclarCol($vetCampo['email'], 5);

$vetFrm[] = Frame('Pessoa Física', Array(
    Array($vetCampo['cpf'], '', $vetCampo['nome']),
    Array($vetCampo['logradouro_cep'], '', $vetCampo['logradouro_endereco'], '', $vetCampo['logradouro_numero'], '', $vetCampo['logradouro_complemento']),
    Array($vetCampo['logradouro_bairro'], '', $vetCampo['logradouro_cidade'], '', $vetCampo['logradouro_estado'], '', $vetCampo['logradouro_pais']),
    Array($vetCampo['telefone_residencial'], '', $vetCampo['telefone_celular'], '', $vetCampo['telefone_telefone_recado']),
    Array($vetCampo['data_nascimento'], '', $vetCampo['email']),
        ), $class_frame, $class_titulo, false, $vetParametros);

//
$vetCampo['cnpj'] = objTexto('cnpj', 'CNPJ', false, 45, 45, $jst);
$vetCampo['razao_social'] = objTexto('razao_social', 'Razão Social', false, 45, 120, $jst);

$vetCampo['logradouro_cep_e'] = objCEP('logradouro_cep_e', 'CEP', True);
$vetCampo['logradouro_endereco_e'] = objTexto('logradouro_endereco_e', 'Logradouro', True, 45, 120, $js2);
$vetCampo['logradouro_numero_e'] = objTexto('logradouro_numero_e', 'Número', True, 30, 6, $js3);
$vetCampo['logradouro_complemento_e'] = objTexto('logradouro_complemento_e', 'Complemento', false, 30, 70, $js4);
$vetCampo['logradouro_bairro_e'] = objTexto('logradouro_bairro_e', 'Bairro', True, 30, 120, $js1);
$vetCampo['logradouro_cidade_e'] = objTexto('logradouro_cidade_e', 'Cidade', True, 45, 120, $js2);
$vetCampo['logradouro_estado_e'] = objTexto('logradouro_estado_e', 'Estado', True, 30, 2, $js3);
$vetCampo['logradouro_pais_e'] = objTexto('logradouro_pais_e', 'País', True, 30, 120, $js4);

$vetCampo['telefone_comercial_e'] = objTexto('telefone_comercial_e', 'Telefone Comercial', false, 45, 120, $jst);
$vetCampo['telefone_celular_e'] = objTexto('telefone_celular_e', 'Telefone Celular', false, 45, 120, $jst);

$vetCampo['data_abertura'] = objData('data_abertura', 'Data Abertura', true, $js1, '', 'S');
$vetCampo['email_e'] = objEmail('email_e', 'Endereço de e-mail', false, 30, 120, $js2);

MesclarCol($vetCampo['razao_social'], 5);
MesclarCol($vetCampo['telefone_celular_e'], 5);
MesclarCol($vetCampo['email_e'], 5);

$vetFrm[] = Frame('Pessoa Física', Array(
    Array($vetCampo['cnpj'], '', $vetCampo['razao_social']),
    Array($vetCampo['logradouro_cep_e'], '', $vetCampo['logradouro_endereco_e'], '', $vetCampo['logradouro_numero_e'], '', $vetCampo['logradouro_complemento_e']),
    Array($vetCampo['logradouro_bairro_e'], '', $vetCampo['logradouro_cidade_e'], '', $vetCampo['logradouro_estado_e'], '', $vetCampo['logradouro_pais_e']),
    Array($vetCampo['telefone_comercial_e'], '', $vetCampo['telefone_celular_e']),
    Array($vetCampo['data_abertura'], '', $vetCampo['email_e']),
        ), $class_frame, $class_titulo, false, $vetParametros);

$vetTmp = Array(
    'S' => 'Não',
    'N' => 'Sim',
);

$vetCampo['data_atendimento'] = objDataHora('data_atendimento', 'Data Atendimento', true, $js1, '', 'S');
$vetCampo['data_inicio_atendimento'] = objDataHora('data_inicio_atendimento', 'Data Registro', true, $js1, '', 'S');

$vetCampo['data_atendimento_aberta'] = objCmbVetor('data_atendimento_aberta', 'Registro em Tempo Real', True, $vetTmp);
$vetCampo['horas_atendimento'] = objDecimal('horas_atendimento', 'Duração do Atendimento (minutos)', false, 5, '', 0);
$vetCampo['demanda'] = objTextArea('demanda', 'Observação do Atendimento', true, 100000);

$vetCampo['indicador_5_inconsistente'] = objCmbVetor('indicador_5_inconsistente', 'Inconsistente 5', True, $vetSimNao);
$vetCampo['indicador_5_hora'] = objCmbVetor('indicador_5_hora', 'Inconsistente na Duração', True, $vetSimNao);
$vetCampo['indicador_5_demanda'] = objCmbVetor('indicador_5_demanda', 'Inconsistente na Observação', True, $vetSimNao);

$vetCampo['hora_inicio_atendimento'] = objTexto('hora_inicio_atendimento', 'Hora Inicio Atendimento', True, 45, 120, $js2);
$vetCampo['hora_termino_atendimento'] = objTexto('hora_termino_atendimento', 'Hora Termino Atendimento', True, 45, 120, $js2);

$vetParametros = Array(
    'width' => '700px',
);

$vetFrm[] = Frame('Critérios', Array(
    Array($vetCampo['indicador_5_inconsistente'], '', $vetCampo['data_atendimento_aberta']),
    Array($vetCampo['data_atendimento'], '', $vetCampo['data_inicio_atendimento']),
    Array($vetCampo['hora_inicio_atendimento'], '', $vetCampo['hora_termino_atendimento']),
    Array($vetCampo['horas_atendimento'], '', $vetCampo['indicador_5_hora']),
    Array($vetCampo['demanda'], '', $vetCampo['indicador_5_demanda']),
        ), $class_frame, $class_titulo, false, $vetParametros);

$sql = '';
$sql .= ' select idt, idt_ponto_atendimento, horas_atendimento, demanda_md5';
$sql .= ' from ' . $tabela;
$sql .= ' where idt = ' . null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

//horas_atendimento
$vetCampoLC = Array();
$vetCampoLC['protocolo'] = CriaVetTabela('Protocolo');
$vetCampoLC['nome_consultor'] = CriaVetTabela('Atendente');
$vetCampoLC['cpf'] = CriaVetTabela('CPF');
$vetCampoLC['nome'] = CriaVetTabela('Nome');
$vetCampoLC['cnpj'] = CriaVetTabela('CNPJ');
$vetCampoLC['razao_social'] = CriaVetTabela('Razão Social');
$vetCampoLC['data_atendimento'] = CriaVetTabela('Data Atend. ', 'data');

$vetTmp = Array(
    'S' => 'Inconsistente',
    'N' => 'Consistente',
);
$vetCampoLC['indicador_5_inconsistente'] = CriaVetTabela('Resultado do Indicador', 'descDominio', $vetTmp);

$titulo = 'Regsitro';

$sql = '';
$sql .= ' select idt, protocolo, nome_consultor, cpf, nome, cnpj,razao_social, data_atendimento, indicador_5_inconsistente';
$sql .= " from grc_dw_{$ano_base}_indicadores_qualidade";
$sql .= ' where horas_atendimento = ' . null($row['horas_atendimento']);
$sql .= ' and idt_ponto_atendimento = ' . null($row['idt_ponto_atendimento']);
$sql .= ' and idt <> ' . null($row['idt']);
$sql .= " order by protocolo";

$vetParametrosLC = Array(
    'comcontrole' => 0,
);

$vetCampo['lst_horas_atendimento'] = objListarConf('lst_horas_atendimento', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

$vetParametros = Array(
    'width' => '100%',
);

$vetFrm[] = Frame('Atendimentos com a mesma Duração', Array(
    Array($vetCampo['lst_horas_atendimento']),
        ), $class_frame, $class_titulo, false, $vetParametros);


//demanda_md5
$vetCampoLC = Array();
$vetCampoLC['protocolo'] = CriaVetTabela('Protocolo');
$vetCampoLC['nome_consultor'] = CriaVetTabela('Atendente');
$vetCampoLC['cpf'] = CriaVetTabela('CPF');
$vetCampoLC['nome'] = CriaVetTabela('Nome');
$vetCampoLC['cnpj'] = CriaVetTabela('CNPJ');
$vetCampoLC['razao_social'] = CriaVetTabela('Razão Social');
$vetCampoLC['data_atendimento'] = CriaVetTabela('Data Atend. ', 'data');

$vetTmp = Array(
    'S' => 'Inconsistente',
    'N' => 'Consistente',
);
$vetCampoLC['indicador_5_inconsistente'] = CriaVetTabela('Resultado do Indicador', 'descDominio', $vetTmp);

$titulo = 'Regsitro';

$sql = '';
$sql .= ' select idt, protocolo, nome_consultor, cpf, nome, cnpj,razao_social, data_atendimento, indicador_5_inconsistente';
$sql .= " from grc_dw_{$ano_base}_indicadores_qualidade";
$sql .= ' where demanda_md5 = ' . aspa($row['demanda_md5']);
$sql .= ' and idt_ponto_atendimento = ' . null($row['idt_ponto_atendimento']);
$sql .= ' and idt <> ' . null($row['idt']);
$sql .= " order by protocolo";

$vetParametrosLC = Array(
    'comcontrole' => 0,
);

$vetCampo['lst_demanda'] = objListarConf('lst_demanda', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

$vetParametros = Array(
    'width' => '100%',
);

$vetFrm[] = Frame('Atendimentos com a mesma Observação', Array(
    Array($vetCampo['lst_demanda']),
        ), $class_frame, $class_titulo, false, $vetParametros);


$vetCad[] = $vetFrm;
