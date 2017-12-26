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
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."', parent.funcaoFechaCTC_grc_produto_profissional);";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'", parent.funcaoFechaCTC_grc_produto_profissional);</script>';
}

$TabelaPai = "grc_produto";
$AliasPai = "grc_atd";
$EntidadePai = "Produto";
$idPai = "idt";

$TabelaPrinc = "grc_produto_entrega";
$AliasPric = "grc_pe";
$Entidade = "Entrega do Produto";
$Entidade_p = "Entregas do Produto";
$CampoPricPai = "idt_produto";
$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$colorinativo = '#FFFFD7';
$js = " readonly='true' style='background:{$colorinativo};' ";
$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 15, 45, $js);

$vetCampo['ordem'] = objInteiro('ordem', 'Ordem', True, 15);
$vetCampo['descricao'] = objTexto('descricao', 'Nome', True, 60, 120);
$vetCampo['percentual'] = objDecimal('percentual', 'Percentual (%)', true, 10);

$maxlength = 2000;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Descrição', false, $maxlength, $style, $js);

$vetFrm = Array();
$vetFrm[] = Frame('<span>Produto</span>', Array(
    Array($vetCampo[$CampoPricPai]),
        ), $class_frame, $class_titulo, $titulo_na_linha);

MesclarCol($vetCampo['detalhe'], 7);

$vetFrm[] = Frame('<span>Profissional</span>', Array(
    Array($vetCampo['codigo'], '', $vetCampo['ordem'], '', $vetCampo['descricao'], '', $vetCampo['percentual']),
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);


$vetCampo = Array();
$vetCampo['codigo'] = CriaVetTabela('Código');
$vetCampo['documento'] = CriaVetTabela('Documento');

$titulo = 'Evidências da Entrega';

$sql = '';
$sql .= ' select ped.*, d.descricao as documento';
$sql .= ' from grc_produto_entrega_documento ped';
$sql .= ' inner join '.db_pir_gec.'gec_documento d on d.idt = ped.idt_documento';
$sql .= ' where ped.idt_produto_entrega = $vlID';
$sql .= ' order by ped.codigo, d.descricao';

$vetCampo['grc_produto_entrega_documento'] = objListarConf('grc_produto_entrega_documento', 'idt', $vetCampo, $sql, $titulo, true);

$vetParametros = Array(
    'width' => '100%',
);

$vetFrm[] = Frame('<span>Evidências da Entrega</span>', Array(
    Array($vetCampo['grc_produto_entrega_documento']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;