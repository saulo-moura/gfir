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

    .mostrarReg div {
        display: inline-block;
        min-width: 50px;
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

//$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; width:100%;' ";
//$vetCampo_f['protocolo'] = objHidden('protocolo', '');

$jst = "";
$vetCampo['ponto_atendimento'] = objTexto('ponto_atendimento', 'Ponto Atendimento', false, 45, 120, $jst);
$vetCampo['nome_consultor'] = objTexto('nome_consultor', 'Atendente/Consultor', false, 45, 120, $jst);
$vetCampo['data_atendimento'] = objData('data_atendimento', 'Data Atendimento', false);

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
MesclarCol($vetCampo['telefone_recado'], 3);
MesclarCol($vetCampo['email'], 5);

$vetFrm[] = Frame('Pessoa Física', Array(
    Array($vetCampo['cpf'], '', $vetCampo['nome']),
    Array($vetCampo['logradouro_cep'], '', $vetCampo['logradouro_endereco'], '', $vetCampo['logradouro_numero'], '', $vetCampo['logradouro_complemento']),
    Array($vetCampo['logradouro_bairro'], '', $vetCampo['logradouro_cidade'], '', $vetCampo['logradouro_estado'], '', $vetCampo['logradouro_pais']),
    Array($vetCampo['telefone_residencial'], '', $vetCampo['telefone_celular'], '', $vetCampo['telefone_recado']),
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

$vetFrm[] = Frame('Pessoa Jurídica', Array(
    Array($vetCampo['cnpj'], '', $vetCampo['razao_social']),
    Array($vetCampo['logradouro_cep_e'], '', $vetCampo['logradouro_endereco_e'], '', $vetCampo['logradouro_numero_e'], '', $vetCampo['logradouro_complemento_e']),
    Array($vetCampo['logradouro_bairro_e'], '', $vetCampo['logradouro_cidade_e'], '', $vetCampo['logradouro_estado_e'], '', $vetCampo['logradouro_pais_e']),
    Array($vetCampo['telefone_comercial_e'], '', $vetCampo['telefone_celular_e']),
    Array($vetCampo['data_abertura'], '', $vetCampo['email_e']),
        ), $class_frame, $class_titulo, false, $vetParametros);

$sql = '';
$sql .= ' select c.*';
$sql .= " from grc_dw_{$ano_base}_matriz_campos_iq_3 iq";
$sql .= " inner join grc_dw_{$ano_base}_matriz_campos c on c.idt = iq.idt_dw_matriz_campos";
$sql .= ' where iq.idt_dw_indicadores_qualidade = ' . null($_GET['id']);
$sql .= " and c.inconsistente = 'S'";
$rs = execsql($sql);

$vetQtd = Array();

foreach ($rs->data as $rowc) {
    $vetQtd[$rowc['campo']] = $rowc;
}

$jsAcao = '';

// PF
$vetLimite = Array();
$vetLimite["endereco_pf"] = 'Endereço';
$vetLimite["data_nascimento"] = 'Data Nascimento';
$vetLimite["telefone_residencial"] = 'Telefone Residencial';
$vetLimite["telefone_celular"] = 'Telefone Celular';
$vetLimite["telefone_recado"] = 'Telefone de Reacado';
$vetLimite["email"] = 'Endereço de e-mail';

$rowTable = Array();

foreach ($vetLimite as $key => $value) {
    $campo = 'qtd_' . $key;
    $vetCampo[$campo] = objTextoFixo($campo, $value, '', false, true, $vetQtd[$key]['quantidade']);
    $rowTable[] = $vetCampo[$campo];
    $rowTable[] = '';

    $jsAcao .= 'bt = \'<img class="aviso_ant" src="imagens/consultar_16.png" onclick="mostrarReg(' . $vetQtd[$key]['idt'] . ')" title="Mostrar registros Inconsistentes" border="0">\';';
    $jsAcao .= "\n$('#{$campo}_obj').addClass('mostrarReg').append($(bt));\n";
}

$vetFrm[] = Frame('Indicadores da Pessoa Física', Array(
    $rowTable,
        ), $class_frame, $class_titulo, false, $vetParametros);

// PJ
$vetLimite = Array();
$vetLimite["endereco_pj"] = 'Endereço';
$vetLimite["data_abertura"] = 'Data Abertura Empresa';
$vetLimite["telefone_comercial_e"] = 'Telefone Comercial';
$vetLimite["telefone_celular_e"] = 'Telefone Celular';
$vetLimite["email_e"] = 'Endereço de e-mail';

$rowTable = Array();

foreach ($vetLimite as $key => $value) {
    $campo = 'qtd_' . $key;
    $vetCampo[$campo] = objTextoFixo($campo, $value, '', false, true, $vetQtd[$key]['quantidade']);
    $rowTable[] = $vetCampo[$campo];
    $rowTable[] = '';

    $jsAcao .= 'bt = \'<img class="aviso_ant" src="imagens/consultar_16.png" onclick="mostrarReg(' . $vetQtd[$key]['idt'] . ')" title="Mostrar registros Inconsistentes" border="0">\';';
    $jsAcao .= "\n$('#{$campo}_obj').addClass('mostrarReg').append($(bt));\n";
}

$vetFrm[] = Frame('Indicadores da Pessoa Jurídica', Array(
    $rowTable,
        ), $class_frame, $class_titulo, false, $vetParametros);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
<?php
foreach ($rs->data as $row) {
    $campo = $row['campo'];

    if ($campo == 'endereco_pf') {
        $campo = 'logradouro_cep';
    }

    if ($campo == 'endereco_pj') {
        $campo = 'logradouro_cep_e';
    }
    ?>
            bt = '<?php echo '<img class="aviso_ant" src="imagens/valor_alterado.png" title="Valor Inconsistente (Quantidade encontrada: ' . $row['quantidade'] . ')" border="0">'; ?>';
            $('#<?php echo $campo; ?>_obj').append($(bt));
    <?php
}

echo $jsAcao;
?>
        /*
         bt = '<img class="aviso_ant" src="imagens/consultar_16.png" onclick="mostrarReg(\'endereco_pf\')" title="Mostrar registros Inconsistentes" border="0">';
         $('#qtd_endereco_pf_obj').addClass('mostrarReg').append($(bt));
         
         bt = '<img class="aviso_ant" src="imagens/consultar_16.png" onclick="mostrarReg(\'data_nascimento\')" title="Mostrar registros Inconsistentes" border="0">';
         $('#qtd_data_nascimento_obj').addClass('mostrarReg').append($(bt));
         
         bt = '<img class="aviso_ant" src="imagens/consultar_16.png" onclick="mostrarReg(\'telefone_residencial\')" title="Mostrar registros Inconsistentes" border="0">';
         $('#qtd_telefone_residencial_obj').addClass('mostrarReg').append($(bt));
         
         bt = '<img class="aviso_ant" src="imagens/consultar_16.png" onclick="mostrarReg(\'telefone_celular\')" title="Mostrar registros Inconsistentes" border="0">';
         $('#qtd_telefone_celular_obj').addClass('mostrarReg').append($(bt));
         
         bt = '<img class="aviso_ant" src="imagens/consultar_16.png" onclick="mostrarReg(\'telefone_recado\')" title="Mostrar registros Inconsistentes" border="0">';
         $('#qtd_telefone_recado_obj').addClass('mostrarReg').append($(bt));
         
         bt = '<img class="aviso_ant" src="imagens/consultar_16.png" onclick="mostrarReg(\'email\')" title="Mostrar registros Inconsistentes" border="0">';
         $('#qtd_email_obj').addClass('mostrarReg').append($(bt));
         
         bt = '<img class="aviso_ant" src="imagens/consultar_16.png" onclick="mostrarReg(\'endereco_pj\')" title="Mostrar registros Inconsistentes" border="0">';
         $('#qtd_endereco_pj_obj').addClass('mostrarReg').append($(bt));
         
         bt = '<img class="aviso_ant" src="imagens/consultar_16.png" onclick="mostrarReg(\'telefone_comercial_e\')" title="Mostrar registros Inconsistentes" border="0">';
         $('#qtd_telefone_comercial_e_obj').addClass('mostrarReg').append($(bt));
         
         bt = '<img class="aviso_ant" src="imagens/consultar_16.png" onclick="mostrarReg(\'data_abertura\')" title="Mostrar registros Inconsistentes" border="0">';
         $('#qtd_data_abertura_obj').addClass('mostrarReg').append($(bt));
         
         bt = '<img class="aviso_ant" src="imagens/consultar_16.png" onclick="mostrarReg(\'telefone_celular_e\')" title="Mostrar registros Inconsistentes" border="0">';
         $('#qtd_telefone_celular_e_obj').addClass('mostrarReg').append($(bt));
         
         bt = '<img class="aviso_ant" src="imagens/consultar_16.png" onclick="mostrarReg(\'email_e\')" title="Mostrar registros Inconsistentes" border="0">';
         $('#qtd_email_e_obj').addClass('mostrarReg').append($(bt));
         */

    });

    function mostrarReg(idt_campo) {
        var par = '';
        par += '?prefixo=listar_cmb';
        par += '&menu=grc_indicador_q3';
        par += '&idt_campo=' + idt_campo;
        par += '&idt=<?php echo $_GET['id']; ?>';
        par += '&cas=' + conteudo_abrir_sistema;
        var url = 'conteudo_cadastro.php' + par;
        showPopWin(url, 'Registros Inconsistentes', $(window).width() - 30, $(window).height() - 100, null, true);
    }
</script>
