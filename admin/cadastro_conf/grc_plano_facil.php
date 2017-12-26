<style type="text/css">
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
        background: #2F66B8;
        text-align: left;
        border    : 0px solid #2C3E50;
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
        background: #c4c9cd;
        border    : none;
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

    div.class_titulo_cold {
        text-align: center;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo_c {
   
        background: #2F66B8;
        text-align: left;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        text-align: center;
        height    : 20px;
        font-size : 12px;
        padding-top:5px;
    }


    div.class_titulo_c span {
        padding-left:10px;
    }

    Select {
        border:0px;
        height:28px;
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

</style>



<?php

//p($_GET);
/*
if ($_GET['idCad'] != '') {
    $_GET['idt1'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
*/
//p($_GET);

// Dados da tabela Pai (Nivel 1)

$TabelaPai   = "grc_atendimento";
$AliasPai    = "grc_at";
$EntidadePai = "Atendimento";
$idPai       = "idt";


$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_titulo_c  = "class_titulo_c";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;

// Dados da tabelha filho nivel 2 (deste programa)

$TabelaPrinc      = "grc_plano_facil";
$AliasPric        = "grc_pf";
$Entidade         = "Plano Fácil"; 
$Entidade_p       = "Plano Fácil";
$CampoPricPai     = "idt_atendimento";


$tabela = $TabelaPrinc;
// Fixa o item da tabela anterior (PAI)

$id = 'idt';
// $vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'protocolo', 0);

$corbloq = "#FFFFE1";
$jst =" readonly='true' style='background:".$corbloq."' ";
$vetCampo['protocolo'] = objTexto('protocolo', 'Protocolo', true, 12, 45,$jst);
$maxlength  = 2000;
$style      = "width:95%;";
$js         = "";
$vetCampo['banco_ideia'] = objTextArea('banco_ideia', 'Banco de Idéias', false, $maxlength, $style, $js);
$maxlength  = 2000;
$style      = "width:95%;";
$js         = "";
$vetCampo['quemquandoprocurar'] = objTextArea('quemquandoprocurar', '<span>6 - RELACIONAMENTO COM O SEBRAE</span>', false, $maxlength, $style, $js);
$js      = " readonly='true' style='background:#FFFFE1;' ";
$vetCampo['data_responsavel']  = objDataHora('data_responsavel', 'Data Registro', false, $js );
$sql     = "select id_usuario, nome_completo from plu_usuario order by nome_completo";
$js_hm   = " disabled  ";
$style   = " width:380px; background:#FFFFE1;  ";
$vetCampo['idt_responsavel'] = objCmbBanco('idt_responsavel', 'Responsavel', false, $sql,'',$style,$js_hm);

//
// 
//
$vetFrm = Array();


$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => false,
);

$vetFrm[] = Frame('<span>PLANO FÁCIL</span>', '', $class_frame_p, $class_titulo_c, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'parte01',
);


MesclarCol($vetCampo['banco_ideia'], 5);
MesclarCol($vetCampo['quemquandoprocurar'], 5);

$vetParametros = Array(
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
   // Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['protocolo'],'',$vetCampo['idt_responsavel'],'',$vetCampo['data_responsavel']),
	//Array($vetCampo['banco_ideia']),
	//Array($vetCampo['quemquandoprocurar']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


//
// ----------------------- Áreas
//
$vetParametros = Array(
    'codigo_frm' => 'area',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>Áreas</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampoFC = Array();
$vetCampoFC['grc_fa_descricao']  = CriaVetTabela('Descrição');

$titulo = 'Áreas do Plano Fácil';

$TabelaPrinc  = "grc_plano_facil_area";
$AliasPric    = "grc_pfa";
$Entidade     = "Áreas do Plano Fácil";
$Entidade_p   = "Áreas do Plano Fácil";
$CampoPricPai = "idt_plano_facil";



$orderby = " grc_fa.descricao ";

$sql  = "select {$AliasPric}.*, ";
$sql .= " grc_fa.descricao as grc_fa_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_formulario_area grc_fa on grc_fa.idt = {$AliasPric}.idt_area ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".'$vlID';
$sql .= " order by {$orderby}";

$vetParametros = Array(
//    'func_trata_row' => bloqueia_row_formulario,
);
$vetCampo[$TabelaPrinc] = objListarConf($TabelaPrinc, 'idt', $vetCampoFC, $sql, $titulo, true, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'area',
    'width' => '100%',
);


$vetFrm[] = Frame('', Array(
    Array($vetCampo[$TabelaPrinc]),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);



$vetParametros = Array(
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
	Array($vetCampo['banco_ideia'],'',$vetCampo['quemquandoprocurar']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);






$vetCad[] = $vetFrm;
?>