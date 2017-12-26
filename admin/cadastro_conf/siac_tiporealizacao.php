<?php
$tabela = 'db_pir_siac.tiporealizacao';
$id = 'idt';

$vetCampo['CodTipoRealizacao']  = objTexto('CodTipoRealizacao', 'Código', True, 3, 3);
$vetCampo['DescTipoRealizacao'] = objTexto('DescTipoRealizacao', 'Descrição', True, 50, 50);
$vetCampo['Situacao']           = objCmbVetor('Situacao', 'Situacao', True, $vetSimNao);

$vetCampo['CodCategoria']       = objInteiro('CodCategoria', 'Categoria', false, 11, 11);
$vetCampo['Ano']                = objInteiro('Ano', 'Ano', false, 11, 11);
$vetCampo['CodProjeto']         = objInteiro('CodProjeto', 'Projeto', false, 11, 11);
$vetCampo['CodAcao']            = objInteiro('CodAcao', 'Ação', false, 1, 1);

$vetCampo['TipoSIAC']           = objInteiro('TipoSIAC', 'Tipo SIAC', false, 11, 11);
$vetCampo['CodAplicacao']       = objInteiro('CodAplicacao', 'Aplicação', false, 11, 11);
$vetCampo['CodEntidadeParceira']= objInteiro('CodEntidadeParceira', 'Entidade Parceira', false, 11, 11);


//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['CodTipoRealizacao'],'',$vetCampo['DescTipoRealizacao'],'',$vetCampo['Situacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Complemento</span>', Array(
    Array($vetCampo['CodAplicacao'],'',$vetCampo['CodEntidadeParceira']),
    Array($vetCampo['codrealizacao'],'',$vetCampo['CodProjeto']),
),$class_frame,$class_titulo,$titulo_na_linha);

 $vetFrm[] = Frame('<span>Outros</span>', Array(
    Array($vetCampo['Ano'],'',$vetCampo['CodAcao'],'',$vetCampo['TipoSIAC']),
),$class_frame,$class_titulo,$titulo_na_linha);



//$vetFrm[] = Frame('<span>Resumo</span>', Array(
//    Array($vetCampo['detalhe']),
//),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
