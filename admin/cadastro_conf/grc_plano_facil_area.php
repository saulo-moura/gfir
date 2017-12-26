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

    div.class_titulo_c {
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
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}


// Dados da tabela Pai (Nivel 1)

$TabelaPai   = "grc_plano_facil";
$AliasPai    = "grc_pf";
$EntidadePai = "Plano Fácil";
$idPai       = "idt";


$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;

// Dados da tabelha filho nivel 2 (deste programa)

$TabelaPrinc      = "grc_plano_facil_area";
$AliasPric        = "grc_pfa";
$Entidade         = "Área Plano Fácil"; 
$Entidade_p       = "Área Plano Fácil";
$CampoPricPai     = "idt_plano_facil";


$tabela = $TabelaPrinc;
// Fixa o item da tabela anterior (PAI)

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'protocolo', 0);

$sql  = "select idt, descricao from grc_formulario_area grc_fa ";


$sql .= ' where grc_fa.grupo = '.aspa('NAN');
$sql .= ' order by grc_fa.descricao ';


if ($acao=='inc')
{
    $js_hm   = "";
}
else
{
    $js_hm   = " disabled  ";
}

$style   = " width:100%; background:#FFFFE1;  ";
$vetCampo['idt_area'] = objCmbBanco('idt_area', 'Área', true, $sql,'',$style,$js_hm);
$maxlength  = 2000;
$style      = "width:100%;";
$js         = "";
$vetCampo['decido_planejo'] = objTextArea('decido_planejo', '', false, $maxlength, $style, $js);

//
// 
//
$vetFrm = Array();

//MesclarCol($vetCampo['banco_ideia'], 5);

$vetParametros = Array(
    'width' => '100%',
);


$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['idt_area']),
	//Array($vetCampo['decido_planejo']),
	
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);



//
// ----------------------- Plano de Ação
//
$vetParametros = Array(
    'codigo_frm' => 'ferramenta',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>1 - EU OBSERVO e PRIORIZO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampoFC = Array();
$vetCampoFC['grc_ffg_descricao']  = CriaVetTabela('Ferramenta de Gestão');

$titulo = 'Ferramenta';

$TabelaPrinc  = "grc_plano_facil_ferramenta";
$AliasPric    = "grc_pff";
$Entidade     = "Ferramenta do Plano Fácil";
$Entidade_p   = "Ferramentas do Plano Fácil";
$CampoPricPai = "idt_plano_facil_area";



$orderby = " grc_ffg.descricao ";

$sql  = "select {$AliasPric}.*, ";
$sql .= " grc_ffg.descricao as grc_ffg_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_formulario_ferramenta_gestao grc_ffg on grc_ffg.idt = {$AliasPric}.idt_ferramenta ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".'$vlID';
$sql .= " order by {$orderby}";

$vetParametros = Array(
//    'func_trata_row' => bloqueia_row_formulario,
);
$vetCampo[$TabelaPrinc] = objListarConf($TabelaPrinc, 'idt', $vetCampoFC, $sql, $titulo, true, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'ferramenta',
    'width' => '100%',
);


$vetFrm[] = Frame('', Array(
    Array($vetCampo[$TabelaPrinc]),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);


$vetParametros = Array(
    'codigo_frm' => 'decido_planejo',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>2 - EU DECIDO e PLANEJO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'decido_planejo',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
	Array($vetCampo['decido_planejo']),
	
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

//
// ----------------------- Plano de Ação
//
$vetParametros = Array(
    'codigo_frm' => 'plano_acao',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>3 - EU FAÇO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampoFC = Array();
$vetCampoFC['atividade']  = CriaVetTabela('Atividade');
$vetCampoFC['quem']       = CriaVetTabela('Quem?');
$vetCampoFC['quando']     = CriaVetTabela('Quando?');
$vetCampoFC['observacao'] = CriaVetTabela('Observação');

$titulo = 'Plano de Ação';

$TabelaPrinc  = "grc_plano_facil_plano_acao";
$AliasPric    = "grc_pfpa";
$Entidade     = "Plano Ação do Plano Fácil";
$Entidade_p   = "Plano Ação Plano Fácil";
$CampoPricPai = "idt_plano_facil_area";



$orderby = " grc_pfpa.atividade ";

$sql  = "select {$AliasPric}.* ";
//$sql .= " grc_fa.descricao as grc_fa_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//$sql .= " inner join grc_formulario_area grc_fa on grc_fa.idt = {$AliasPric}.idt_area ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".'$vlID';
$sql .= " order by {$orderby}";

$vetParametros = Array(
//    'func_trata_row' => bloqueia_row_formulario,
);
$vetCampo[$TabelaPrinc] = objListarConf($TabelaPrinc, 'idt', $vetCampoFC, $sql, $titulo, true, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'plano_acao',
    'width' => '100%',
);


$vetFrm[] = Frame('', Array(
    Array($vetCampo[$TabelaPrinc]),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);





//
// ----------------------- Produto
//
$vetParametros = Array(
    'codigo_frm' => 'produto',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>4 - EU APRENDO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampoFC = Array();
$vetCampoFC['grc_p_descricao']  = CriaVetTabela('Produto');

$titulo = 'Produto';

$TabelaPrinc  = "grc_plano_facil_produto";
$AliasPric    = "grc_pff";
$Entidade     = "Produto do Plano Fácil";
$Entidade_p   = "Produto do Plano Fácil";
$CampoPricPai = "idt_plano_facil_area";



$orderby = " grc_p.descricao ";

$sql  = "select {$AliasPric}.*, ";
$sql .= " grc_p.descricao as grc_p_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_produto grc_p on grc_p.idt = {$AliasPric}.idt_produto ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".'$vlID';
$sql .= " order by {$orderby}";

$vetParametros = Array(
//    'func_trata_row' => bloqueia_row_formulario,
);
$vetCampo[$TabelaPrinc] = objListarConf($TabelaPrinc, 'idt', $vetCampoFC, $sql, $titulo, true, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'produto',
    'width' => '100%',
);


$vetFrm[] = Frame('', Array(
    Array($vetCampo[$TabelaPrinc]),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);









$vetCad[] = $vetFrm;
?>