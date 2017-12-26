<style>
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
</style>
<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
}
$TabelaPai = "grc_produto";
$AliasPai = "grc_pro";
$EntidadePai = "Produto";
$idPai = "idt";

$TabelaPrinc = "grc_produto_galeria";
$AliasPric = "grc_proaa";
$Entidade = "Galeria do Produto";
$Entidade_p = "Galeria do Produto";
$CampoPricPai = "idt_produto";

$tabela = $TabelaPrinc;
$id = 'idt';

$sql = "select idt, tem_link, tem_arquivo from grc_tipo_galeria";
$rs = execsql($sql);

$vetTipoGaleria = Array();

foreach ($rs->data as $row) {
    if ($row['tem_link'] == 'S') {
        $vetTipoGaleria['link'][] = $row['idt'];
    }
    
    if ($row['tem_arquivo'] == 'S') {
        $vetTipoGaleria['arquivo'][] = $row['idt'];
    }
}

$par = 'link';

if (is_array($vetTipoGaleria['link'])) {
    $valor = implode(',', $vetTipoGaleria['link']);
} else {
    $valor = 'X';
}

$vetDesativa['idt_tipo_galeria'][0] = vetDesativa($par, $valor, false);
$vetAtivadoObr['idt_tipo_galeria'][0] = vetAtivadoObr($par, $valor);

$par = 'arquivo';

if (is_array($vetTipoGaleria['arquivo'])) {
    $valor = implode(',', $vetTipoGaleria['arquivo']);
} else {
    $valor = 'X';
}

$vetDesativa['idt_tipo_galeria'][1] = vetDesativa($par, $valor, false);
$vetAtivadoObr['idt_tipo_galeria'][1] = vetAtivadoObr($par, $valor);

$vetFrm = Array();

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$vetFrm[] = Frame('<span>Produto</span>', Array(
    Array($vetCampo[$CampoPricPai]),
        ), $class_frame, $class_titulo, $titulo_na_linha);


$sql = "select idt, descricao from grc_tipo_galeria order by descricao";
$vetCampo['idt_tipo_galeria'] = objCmbBanco('idt_tipo_galeria', 'Tipo da Galeria', true, $sql);

$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 120);

$maxlength = 2000;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$vetCampo['link'] = objURL('link', 'Link', False, 120, 254);
$vetCampo['arquivo'] = objFile('arquivo', 'Arquivo', False, 120, 'todos');

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['idt_tipo_galeria']),
    Array($vetCampo['descricao']),
    Array($vetCampo['link']),
    Array($vetCampo['arquivo']),
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
