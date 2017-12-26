<?php
$tabela = 'db_pir_siac.estado';
$id = 'idt';

$vetCampo['CodEst']        = objTexto('CodEst', 'Código', True, 6, 6);
$vetCampo['DescEst']       = objTexto('DescEst', 'Descrição', True, 30, 30);
//$vetCampo['Situacao']       = objCmbVetor('Situacao', 'Situacao', True, $vetSimNao);
$vetCampo['SITUACAO']      = objInteiro('SITUACAO', 'Situação', false,1,1);

$vetCampo['AbrevEst']      = objTexto('AbrevEst', 'Abrev.Estado', false, 3, 3);

$sql  = "select CodPais, DescPais from db_pir_siac.pais ";
$sql .= " order by DescPais";
$vetCampo['CodPais']       = objCmbBanco('CodPais', 'País', true, $sql,' ','width:400px;');

$vetCampo['AreaOcup']      = objInteiro('AreaOcup', 'Area Ocupada', false, 11, 11);
$vetCampo['Populacao']     = objInteiro('Populacao', 'população', false, 11, 11);

$vetCampo['IndAtuEst']     = objTexto('IndAtuEst', 'Ind.Atu.Estado', false, 3, 3);
$vetCampo['DataAtualiz']   = objDataHora('DataAtualiz', 'Data Atualização', false, $js);

$vetCampo['Fonte']         = objTexto('Fonte', 'Fonte', True, 50, 50);
$vetCampo['IndAtualizacao']= objTexto('IndAtualizacao', 'Ind.Atualização', false,1,1);
$vetCampo['CodRegiao']     = objInteiro('CodRegiao', 'Região', false, 11, 11);

//

//$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['CodEst'],'',$vetCampo['AbrevEst'],'',$vetCampo['DescEst'],'',$vetCampo['CodPais'],'',$vetCampo['SITUACAO']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Dados Econômicos/Fonte</span>', Array(
    Array($vetCampo['AreaOcup'],'',$vetCampo['Populacao']),
    Array($vetCampo['Fonte'],'',$vetCampo['CodRegiao']),
),$class_frame,$class_titulo,$titulo_na_linha);

 $vetFrm[] = Frame('<span>Outros</span>', Array(
    Array($vetCampo['IndAtualizacao'],'',$vetCampo['IndAtuEst'],'',$vetCampo['DataAtualiz']),
),$class_frame,$class_titulo,$titulo_na_linha);


//$vetFrm[] = Frame('<span>Resumo</span>', Array(
//    Array($vetCampo['detalhe']),
//),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
