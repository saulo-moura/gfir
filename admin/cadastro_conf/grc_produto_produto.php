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
define('produtocomposto', mb_strtoupper($_GET['produtocomposto']));

if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$TabelaPai = "grc_produto";
$AliasPai = "grc_atd";
$EntidadePai = "Produto";
$idPai = "idt";

$TabelaPrinc = "grc_produto_produto";
$AliasPric = "grc_atdp";
$Entidade = "Produto Associado do Produto";
$Entidade_p = "Produtos Associado do Produto";
$CampoPricPai = "idt_produto";

$tabela = $TabelaPrinc;

$id = 'idt';

$vetTpRel = Array();
$vetTpRel['C'] = 'Combo';
$vetTpRel['P'] = 'Predecessora';

if (produtocomposto == 'S') {
    if ($_GET['id'] == 0 || $_GET['id'] == -1 || $_POST['idorg'] == -1) {
        $tabela = '';
        $vetCampo['idorg'] = objHidden('idorg', -1, '', '', false);
        $_GET['id'] = 0;

        $vetRetorno = Array(
            vetRetorno('idt', '', false),
            vetRetorno('grc_pri_descricao', '', true),
            vetRetorno('descricao', '', true),
        );
        $vetCampo['idt_produto_associado'] = objListarCmbMulti('idt_produto_associado', 'grc_subproduto', 'Produto Associado', true, '', '', '', $vetRetorno);
    } else {
        $vetCampo['idt_produto_associado'] = objListarCmb('idt_produto_associado', 'grc_subproduto', 'Produto Associado', true);
    }
    
    $vetCampo['tipo_relacao'] = objHidden('tipo_relacao', 'C');
    $vetCampo['obrigatorio'] = objHidden('obrigatorio', 'S');
    $vetCampo['ativo'] = objHidden('ativo', 'S');
} else {
    $vetCampo['tipo_relacao'] = objCmbVetor('tipo_relacao', 'Tipo Relação?', True, $vetTpRel, '');
    $vetCampo['obrigatorio'] = objCmbVetor('obrigatorio', 'Obrigatório?', True, $vetSimNao, '');
    $vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');

    $vetCampo['idt_produto_associado'] = objListarCmb('idt_produto_associado', 'grc_produto_cmb', 'Produto Associado', true);
}

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);

$maxlength = 2000;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$vetFrm = Array();

MesclarCol($vetCampo['idt_produto_associado'], 5);
MesclarCol($vetCampo['idorg'], 5);

$vetFrm[] = Frame('<span>Produto Associado</span>', Array(
    Array($vetCampo['tipo_relacao'], '', $vetCampo['obrigatorio'], '', $vetCampo['ativo']),
    Array($vetCampo['idt_produto_associado']),
    Array($vetCampo['idorg']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
    Array($vetCampo[$CampoPricPai]),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;

$idt_instrumento = '0';

if ($_GET['pc_consultoria'] == 'S') {
    $idt_instrumento .= ',39';
}

if ($_GET['pc_curso'] == 'S') {
    $idt_instrumento .= ',40';
}

if ($_GET['pc_oficina'] == 'S') {
    $idt_instrumento .= ',46';
}

if ($_GET['pc_palestra'] == 'S') {
    $idt_instrumento .= ',47';
}

if ($_GET['pc_seminario'] == 'S') {
    $idt_instrumento .= ',49';
}
?>
<script type="text/javascript">
    function parListarCmb_idt_produto_associado() {
        var par = '';

        par += '&idt_programa_grc=<?php echo $_GET['idt_programa_grc']; ?>';
        par += '&idt_programa=<?php echo $_GET['idt_programa']; ?>';
        par += '&idt_instrumento=<?php echo $idt_instrumento; ?>';

        return par;
    }

    function parListarCmbMulti_idt_produto_associado() {
        return parListarCmb_idt_produto_associado();
    }
</script>