<!-- <lupe> <objeto> Inicio do Objeto -->
<?php
/* <lupe> <objeto>
  Documenta��o
  </lupe> */
?>
<!-- <lupe> <estilo>  Defini��o dos estilos para HTML -->
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
        border: 1px solid #508098;
        xbackground:#F1F1F1;
        background:#FFFFD7;
        min-height: auto;

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
  Documenta��o
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
    var inc_cont = '<?php echo $inc_cont; ?>';
</script>
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

$vetCampo['cpf'] = objTexto('cpf', 'CPF', false, 45, 45, $jst);
$vetCampo['nome'] = objTexto('nome', 'Nome', false, 45, 120, $jst);

//
$vetCampo['cnpj'] = objTexto('cnpj', 'CNPJ', false, 45, 45, $jst);
$vetCampo['razao_social'] = objTexto('razao_social', 'Raz�o Social', false, 45, 120, $jst);

$vetCampo['indicador_2'] = objTexto('indicador_2', 'Resultado do Indicador', false, 45, 120, $jst);
$vetCampo['amostra_2'] = objCmbVetor('amostra_2', 'Tirar da amostra?', True, $vetSimNao);

// Dados compara��o receita federal

$vetCampo['cnpj_crm'] = objTexto('cnpj_crm', 'CNPJ CRM', false, 45, 120, $jst);
$vetCampo['cnpj_rf'] = objTexto('cnpj_rf', 'CNPJ RF', false, 45, 120, $jst);

//$vetCampo['razao_social_crm'] = objTexto('razao_social_crm', 'Rraz�o Social CRM', false, 45, 120, $jst);
//$vetCampo['razao_social_rf'] = objTexto('razao_social_rf', 'Rraz�o Social RF', false, 45, 120, $jst);

$vetCampo['porte_crm'] = objTexto('porte_crm', 'Porte CRM', false, 45, 120, $jst);
$vetCampo['porte_rf'] = objTexto('porte_rf', 'Porte RF', false, 45, 120, $jst);

$vetCampo['data_abertura_crm'] = objTexto('data_abertura_crm', 'Data Abertura Empresa CRM', false, 45, 120, $jst);
$vetCampo['data_abertura_rf'] = objTexto('data_abertura_rf', 'Data Abertura Empresa RF', false, 45, 120, $jst);

$vetCampo['cnae_crm'] = objTexto('cnae_crm', 'CNAE CRM', false, 45, 120, $jst);
$vetCampo['cnae_rf'] = objTexto('cnae_rf', 'CNAE RF', false, 45, 120, $jst);

$sql = '';
$sql .= ' select indicador_2';
$sql .= ' from ' . $tabela;
$sql .= ' where idt = ' . null($_GET['id']);
$rs = execsql($sql);
$qtd_valida = $rs->data[0][0] / 25;

$vetCampo['qtd_valida'] = objTextoFixo('qtd_valida', 'Qtde de Campos Validados', '', false, false, $qtd_valida);

MesclarCol($vetCampo['data_atendimento'], 3);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['ponto_atendimento'], '', $vetCampo['nome_consultor']),
    Array($vetCampo['data_atendimento']),
        ), $class_frame, $class_titulo, false, $vetParametros);


$vetFrm[] = Frame('Pessoa F�sica', Array(
    Array($vetCampo['cpf'], '', $vetCampo['nome']),
        ), $class_frame, $class_titulo, false, $vetParametros);

MesclarCol($vetCampo['amostra_2'], 3);

$vetFrm[] = Frame('Pessoa Jur�dica', Array(
    Array($vetCampo['cnpj'], '', $vetCampo['razao_social']),
    Array($vetCampo['amostra_2']),
        ), $class_frame, $class_titulo, false, $vetParametros);

$vetFrm[] = Frame('Pessoa Jur�dica CRM X Pessoa Jur�dica RF', Array(
    Array($vetCampo['cnpj_crm'], '', $vetCampo['cnpj_rf']),
//    Array($vetCampo['razao_social_crm'], '', $vetCampo['razao_social_rf']),
    Array($vetCampo['porte_crm'], '', $vetCampo['porte_rf']),
    Array($vetCampo['data_abertura_crm'], '', $vetCampo['data_abertura_rf']),
    Array($vetCampo['cnae_crm'], '', $vetCampo['cnae_rf']),
        ), $class_frame, $class_titulo, false, $vetParametros);

$vetFrm[] = Frame('Indicadores', Array(
    Array($vetCampo['qtd_valida'], '', $vetCampo['indicador_2']),
        ), $class_frame, $class_titulo, false, $vetParametros);
$vetCad[] = $vetFrm;
?>
<script>
</script>
