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

    if ($_SESSION[CS]['g_abrir_sistema'] == '') {
        $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
        $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
    } else {
        $botao_volta = "parent.parent.btFechaCTC('" . $_GET['session_cod'] . "');";
        $botao_acao = '<script type="text/javascript">parent.parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
    }
}

$TabelaPai = "gec_contratar_credenciado_distrato";
$AliasPai = "gec_ccd";
$EntidadePai = "";
$idPai = "idt";
//
$TabelaPrinc = "gec_contratar_credenciado_distrato_parecer";
$AliasPric = "gec_ccaa";
$Entidade = "Arquivodem Anexo";
$Entidade_p = "Arquivos em Anexo";
$CampoPricPai = "idt_distrato";

$tabela = $TabelaPrinc;
$tabela_banco = db_pir_gec;

$pathObjFile = $vetSistemaUtiliza['GEC']['path_file'];

$id = 'idt';
$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['entidade_idt']);

$vetCampo['data_registro'] = objTextoFixo('data_registro', 'Data Registro', 20, true);

$sql = "select id_usuario, nome_completo from " . db_pir_gec . "plu_usuario order by nome_completo";
$js_hm = " disabled  ";
$style = " width:380px; background:#FFFFE1;  ";
$vetCampo['idt_responsavel'] = objCmbBanco('idt_responsavel', 'Responsavel pelo Parecer', true, $sql, '', $style, $js_hm);

//$vetCampo['arquivo'] = objFile('arquivo', 'Arquivo Associado - Anexo do Parecer', false, 120, 'todos');

$maxlength = 255;
$style = "width:700px; height:60px;";
$js = "";
$vetCampo['descricao'] = objTextArea('descricao', 'Título', true, $maxlength, $style, $js);


$maxlength = 10000;
$style = "width:700px; height:230px;";
$js = "";
//$vetCampo['detalhe'] = objTextArea('detalhe', 'Parecer', false, $maxlength, $style, $js);
$vetCampo['detalhe'] = objHTML('detalhe', 'Parecer', false, 200);



$vetFrm = Array();

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";

$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

MesclarCol($vetCampo[$CampoPricPai], 3);
MesclarCol($vetCampo['detalhe'], 3);
//MesclarCol($vetCampo['arquivo'], 3);
MesclarCol($vetCampo['codigo'], 3);
MesclarCol($vetCampo['descricao'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['idt_responsavel'], '', $vetCampo['data_registro']),
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),
    Array($vetCampo['detalhe']),
        //Array($vetCampo['arquivo']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

//Anexos do Distrato
$vetParametros = Array(
    'width' => '100%',
);

$vetCampoLC = Array();
$vetCampoLC['data_registro'] = CriaVetTabela('Data Registro', 'data');
$vetCampoLC['titulo'] = CriaVetTabela('Título do Anexo');
$vetCampoLC['arquivo'] = CriaVetTabela('Arquivo', 'func_trata_dado', fnc_gec_contratar_credenciado_distrato_parecer_anexos);
$vetCampoLC['responsavel'] = CriaVetTabela('Responsável');

$titulo = 'Anexos do Parecer';

$sql = '';
$sql .= ' select gec_ccda.*,';
$sql .= ' plu_usu.nome_completo as responsavel ';
$sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato_parecer_anexos gec_ccda ';
$sql .= ' inner join ' . db_pir_gec . 'plu_usuario plu_usu on plu_usu.id_usuario = gec_ccda.idt_responsavel ';
$sql .= ' where idt_gec_contratar_credenciado_distrato_parecer = $vlID';
$sql .= ' order by data_registro';

$vetCampo['gec_contratar_credenciado_distrato_parecer_anexos'] = objListarConf('gec_contratar_credenciado_distrato_parecer_anexos', 'idt', $vetCampoLC, $sql, $titulo, false);

$vetFrm[] = Frame('<span>' . $titulo . '</span>', Array(
    Array($vetCampo['gec_contratar_credenciado_distrato_parecer_anexos']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
