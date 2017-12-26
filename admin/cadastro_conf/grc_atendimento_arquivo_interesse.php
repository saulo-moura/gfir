<style>
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
        height:30px;
    }
    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        height:30px;
        padding-top:10px;
    }
    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }
    fieldset.class_frame_p {
        background:#ABBBBF;
        border:1px solid #FFFFFF;
    }
    div.class_titulo_p {
        background: #ABBBBF;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }
    fieldset.class_frame {
        background:#ECF0F1;
        border:1px solid #2C3E50;
    }
    div.class_titulo {
        background: #C4C9CD;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo span {
        padding-left:10px;
    }
</style>
<?php
if ($_GET['idCad'] != '') {
    $_GET['entidade_idt'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
} else {
    if ($_GET['entidade_idt'] > 0) {
        $rascunho = cria_rascunho_entidade($_GET['entidade_idt'], DecideSistema());
        
        if (is_numeric($rascunho)) {
            $_GET['entidade_idt'] = $rascunho;
            $_REQUEST['entidade_idt'] = $rascunho;
        } else {
            die($rascunho);
        }
    }
}
$TabelaPai   = "grc_atendimento";
$AliasPai    = "grc_at";
$EntidadePai = "Atendimento";
$idPai       = "idt";
//
$TabelaPrinc  = "gec_atendimento_arquivo_interesse";
$AliasPric    = "gec_aai";
$Entidade     = "Arquivo de Interesse da entidade";
$Entidade_p   = "Arquivos de Interesse da entidade";
$CampoPricPai = "idt_atendimento";

$tabela = $TabelaPrinc;

$id     = 'idt';
$vetCampo[$CampoPricPai]    = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', '0');


$js    = " readonly='true' style='background:#FFFFE1;' ";
$vetCampo['data_registro']  = objData('data_registro', 'Data Registro', false, $js );

if ($_GET['id'] == 0) {
    $_GET['id_usuario99'] = $_SESSION[CS]['g_id_usuario'];
}

$vetCampo['idt_responsavel'] = objFixoBanco('idt_responsavel', 'Responsavel', 'plu_usuario', 'id_usuario', 'nome_completo', 99);

$vetCampo['arquivo'] = objFile('arquivo', 'Arquivo Associado', False, 120, 'todos');

$maxlength = 255;
$style     = "width:700px; height:60px;";
$js = "";
$vetCampo['titulo'] = objTextArea('titulo', 'Título', true, $maxlength, $style, $js);

//
$vetFrm = Array();

$class_frame_f   = "class_frame_f";
$class_titulo_f  = "class_titulo_f";

$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";

$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;

$titulo_cadastro = 'TEMAS DE INTERESSE';

$vetParametros = Array(
    'situacao_padrao' => true,
);
$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'relato01a',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>1 - IDENTIFICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'relato01a',
);

MesclarCol($vetCampo['observacao'], 3);
$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['titulo']),
    Array($vetCampo['arquivo']),
    Array($vetCampo['idt_responsavel'],'',$vetCampo['data_registro']),
    Array(),
        ), $class_frame, $class_titulo, $titulo_na_linha);
$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
</script>