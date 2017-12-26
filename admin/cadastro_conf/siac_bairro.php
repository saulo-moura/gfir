<?php
$tabela = 'db_pir_siac.bairro';
$id = 'idt';

$vetCampo['codbairro']     = objInteiro('codbairro', 'Código', True, 5, 11);
$vetCampo['descbairro']    = objTexto('descbairro', 'Descrição', True, 70, 150);
$vetCampo['abrevbairro']   = objTexto('abrevbairro', 'Abrev.Bairro', True, 20, 72);
 $vetCampo['SITUACAO']      = objTexto('SITUACAO', 'Situação', false, 1,1);

$vetCampo['indtipo']       = objTexto('indtipo', 'Tipo', false, 1,1);
$vetCampo['indcadcorreio'] = objInteiro('indcadcorreio', 'Ind.Correio', True, 11, 11);
//
$sql  = "select CodCid, DescCid from db_pir_siac.cidade ";
$sql .= " order by DescCid";
$vetCampo['codcid']        = objCmbBanco('codcid', 'Cidade', false, $sql,' ','width:400px;');


$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codbairro'],'',$vetCampo['descbairro'],'',$vetCampo['abrevbairro'],'',$vetCampo['SITUACAO']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Complemento</span>', Array(
    Array($vetCampo['codcid'],'',$vetCampo['indtipo'],'',$vetCampo['indcadcorreio']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>
