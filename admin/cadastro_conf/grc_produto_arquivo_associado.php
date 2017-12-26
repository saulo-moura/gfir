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
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);

// Dados da tabela Pai (Nivel 1)

$TabelaPai   = "grc_produto";
$AliasPai    = "grc_pro";
$EntidadePai = "Produto";
$idPai       = "idt";

// Dados da tabelha filho nivel 2 (deste programa)

$TabelaPrinc      = "grc_produto_arquivo_associado";
$AliasPric        = "grc_proaa";
$Entidade         = "Arquivo Associado ao Produto";
$Entidade_p       = "Arquivos Associado ao Produto";
$CampoPricPai     = "idt_produto";

$tabela = $TabelaPrinc;
// Fixa o item da tabela anterior (PAI)

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

// descreve os campos do cadastro

$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['titulo'] = objTexto('titulo', 'Título', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
$vetCampo['versao'] = objTexto('versao', 'Versão', False, 15, 120);
$vetCampo['arquivo'] = objFile('arquivo', 'Arquivo Associado', False, 120, 'todos');

//
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);


$sql  = "select idt, codigo, descricao from grc_produto_arquivo_associado ";
$sql .= " order by codigo";
$vetCampo['idt'] = objCmbBanco('idt', 'Arquivo Associado', true, $sql,' ','width:180px;');

// descreve o layput do cadastro

$vetFrm = Array();
$vetFrm[] = Frame('<span>Produto</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

//MesclarCol($vetCampo['idt_situacao'], 3);
//$vetFrm[] = Frame('<span>Conteúdo Programático</span>', Array(
//    Array($vetCampo['idt']),
//),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['titulo'],'',$vetCampo['versao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Arquivo Associado</span>', Array(
    Array($vetCampo['arquivo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>