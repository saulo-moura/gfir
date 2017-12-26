<?php
$tabela = 'db_pir_siac.sebrae';
$id = 'idt';

$vetCampo['codsebrae']       = objInteiro('codsebrae', 'C�digo', True, 11, 11);
$vetCampo['descsebrae']      = objTexto('descsebrae', 'Descri��o', True, 40, 40);
$vetCampo['nomeabrev']       = objTexto('nomeabrev', 'Nome Abreviado', False, 10, 10);
$vetCampo['fone']            = objTexto('fone', 'Abrevia��o', False, 30, 30);
$js="";
$vetCampo['cgc']             = objDecimal('cgc','CGC',true,15,'','',$js);
$vetCampo['codlogr']         = objInteiro('codlogr', 'Logradouro', False, 11, 11);
$vetCampo['descendereco']    = objTexto('descendereco', 'Endere�o', False, 40, 60);
$vetCampo['numero']          = objTexto('numero', 'N�mero', False, 6, 6);
$vetCampo['complemento']     = objTexto('complemento', 'Complemento', False, 30, 30);
$vetCampo['codbairro']       = objInteiro('codbairro', 'Bairro', False, 11, 11);
$vetCampo['codcid']          = objInteiro('codcid', 'Cidade', False, 11, 11);

$sql = "select idt, DescEst from db_pir_siac.estado order by DescEst";
$vetCampo['codest'] = objCmbBanco('codest', 'Estado', False, $sql,'','width:180px;');

$vetCampo['codpais']         = objInteiro('codpais', 'Pa�s', False, 6, 6);
$vetCampo['cep']             = objInteiro('cep', 'CEP', False, 11, 11);
$vetCampo['SeqUF']           = objInteiro('SeqUF', 'SeqUF', False, 11, 11);
$vetCampo['Situacao']        = objCmbVetor('Situacao', 'Situa��o', False, $vetSimNao);
$vetCampo['NIRF']            = objInteiro('NIRF', 'NIRF', False, 1, 1);

$vetFrm = Array();
$vetFrm[] = Frame('<span>Identifica��o</span>', Array(
    Array($vetCampo['codsebrae'],'',$vetCampo['descsebrae'],'',$vetCampo['nomeabrev']),
    Array($vetCampo['fone'],'',$vetCampo['cgc'],'',$vetCampo['codlogr']),
    Array($vetCampo['descendereco'],'',$vetCampo['numero']),
    Array($vetCampo['complemento'],'',$vetCampo['codbairro'],'',$vetCampo['codcid']),
    Array($vetCampo['codest'],'',$vetCampo['codpais'],'',$vetCampo['cep']),
    Array($vetCampo['SeqUF'],'',$vetCampo['Situacao'],'',$vetCampo['NIRF']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
