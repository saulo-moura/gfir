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
//p($_GET);

if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."', parent.funcaoFechaCTC_grc_produto_area_conhecimento);";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'", parent.funcaoFechaCTC_grc_produto_area_conhecimento);</script>';
}
//p($_GET);
// Dados da tabela Pai (Nivel 1)

$TabelaPai = "grc_produto";
$AliasPai = "grc_pro";
$EntidadePai = "Produto";
$idPai = "idt";

// Dados da tabelha filho nivel 2 (deste programa)

$TabelaPrinc = "grc_produto_area_conhecimento";
$AliasPric = "grc_proac";
$Entidade = "Área de Conhecimento";
$Entidade_p = "Áreas de Conhecimento";
$CampoPricPai = "idt_produto";

$tabela = $TabelaPrinc;
// Fixa o item da tabela anterior (PAI)

$id = 'idt';

// descreve os campos do cadastro
//$sql  = "select idt, codigo, descricao from gec_area_conhecimento ";
//$sql .= " order by codigo";
//$vetCampo['idt_area'] = objCmbBanco('idt_area', 'Área de Conhecimento', true, $sql,' ','width:180px;');


if ($_GET['id'] == 0 || $_GET['id'] == -1 || $_POST['idorg'] == -1) {
    $tabela = '';
    $vetCampo['idorg'] = objHidden('idorg', -1, '', '', false);
    $_GET['id'] = 0;

    $vetRetorno = Array(
        vetRetorno('idt', '', false),
        vetRetorno('descricao_n1', '', true),
        vetRetorno('descricao_n2', '', true),
        vetRetorno('descricao_n3', '', true),
    );
    $vetCampo['idt_area'] = objListarCmbMulti('idt_area', 'gec_area_conhecimento_arvore', 'Área de Conhecimento', true, '', '', '', $vetRetorno);
} else {
    $vetCampo['idt_area'] = objListarCmb('idt_area', 'gec_area_conhecimento_cmb', 'Área de Conhecimento', true);
}

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);



$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('titulo', 'Título', True, 60, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);

//
$maxlength = 2000;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);



// descreve o layput do cadastro

$vetFrm = Array();
$vetFrm[] = Frame('<span>Produto</span>', Array(
    Array($vetCampo[$CampoPricPai]),
        ), $class_frame, $class_titulo, $titulo_na_linha);

//MesclarCol($vetCampo['idt_situacao'], 3);
//$vetFrm[] = Frame('<span>Conteúdo Programático</span>', Array(
//    Array($vetCampo['idt']),
//),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['idt_area']),
    Array($vetCampo['idorg']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);


$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function parListarCmb_idt_area() {
        var par = '';

        par += '&idt_programa_padrao=<?php echo $_GET['idt_programa']; ?>';

        return par;
    }

    function parListarCmbMulti_idt_area() {
        return parListarCmb_idt_area();
    }
</script>