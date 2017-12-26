<?php
$tabela = 'db_pir_siac.pais';
$id = 'idt';

$vetCampo['CodPais']        = objTexto('CodPais', 'Código', True, 6, 6);
$vetCampo['DescPais']       = objTexto('DescPais', 'Descrição', True, 30, 30);
//$vetCampo['Situacao']       = objCmbVetor('Situacao', 'Situacao', True, $vetSimNao);
$vetCampo['SITUACAO'] = objInteiro('SITUACAO', 'Situação', false,1,1);

$vetCampo['Area']           = objInteiro('Area', 'Area', false, 11, 11);
$vetCampo['Percapita']       = objInteiro('Percapita', 'Prod. Per Capta', false, 11, 11);
$vetCampo['Pib']            = objInteiro('Pib', 'Prod. Interno Bruto', false, 11, 11);
$vetCampo['Populacao']      = objInteiro('Populacao', 'População', false, 11, 11);

$vetCampo['AbrevPais']      = objTexto('AbrevPais', 'Abrev.Pais', false, 3, 3);
$vetCampo['IndAtuPais']     = objTexto('IndAtuPais', 'Ind.Atu.Pais', false, 3, 3);
$vetCampo['IndNacional']    = objTexto('IndNacional', 'Ind.Nacional', false, 3, 3);
$vetCampo['Nacionalidade']  =objTexto('Nacionalidade', 'Nacionalidade', false, 20, 20);

$vetCampo['DataAtualiz']    = objDataHora('DataAtualiz', 'Data Atualização', false, $js);

$vetCampo['IndAtualizacao'] = objTexto('IndAtualizacao', 'Ind.Atualização', false,1,1);
$vetCampo['IndNacaoPadrao'] = objInteiro('IndNacaoPadrao', 'Ind. Nação Padrão', false, 1, 1);

$vetCampo['Fonte']          = objTexto('Fonte', 'Fonte', True, 20, 20);
//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
//$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['CodPais'],'',$vetCampo['DescPais'],'',$vetCampo['SITUACAO']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Dados Econômicos</span>', Array(
    Array($vetCampo['Area'],'',$vetCampo['Populacao']),
    Array($vetCampo['Pib'],'',$vetCampo['Percapita']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Indices/span>', Array(
    Array($vetCampo['IndAtuPais'],'',$vetCampo['IndNacional']),
    Array($vetCampo['IndAtualizacao'],'',$vetCampo['IndNacaoPadrao']),
),$class_frame,$class_titulo,$titulo_na_linha);


 $vetFrm[] = Frame('<span>Outros</span>', Array(
    Array($vetCampo['AbrevPais'],'',$vetCampo['Nacionalidade'],'',$vetCampo['DataAtualiz']),
),$class_frame,$class_titulo,$titulo_na_linha);


//$vetFrm[] = Frame('<span>Resumo</span>', Array(
//    Array($vetCampo['detalhe']),
//),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
