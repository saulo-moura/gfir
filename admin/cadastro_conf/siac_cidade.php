<?php
$tabela = 'db_pir_siac.cidade';
$id = 'idt';

$vetCampo['CodCid']       = objInteiro('CodCid', 'Código', True, 11, 11);
$vetCampo['DescCid']      = objTexto('DescCid', 'Descrição', True, 80, 150);
$vetCampo['SITUACAO']     = objTexto('SITUACAO', 'Situação', false, 1,1);
//$vetCampo['SITUACAO']  = objCmbVetor('SITUACAO', 'Situação', True, $vetSimNao);
//
$sql  = "select CodEst, DescEst from db_pir_siac.estado ";
$sql .= " order by DescEst";
$vetCampo['CodEst']        = objCmbBanco('CodEst', 'Estado', false, $sql,' ','width:400px;');

$sql  = "select codmicro, descmicro from db_pir_siac.microreg ";
$sql .= " order by descmicro";
$vetCampo['CodMicro']      = objCmbBanco('CodMicro', 'Microregião', false, $sql,' ','width:400px;');

$sql  = "select codmeso, descmeso from db_pir_siac.mesoreg ";
$sql .= " order by descmeso";
$vetCampo['CodMeso']       = objCmbBanco('CodMeso', 'Mesoregião', false, $sql,' ','width:400px;');

$vetCampo['TIPOLOCALIDADE']= objTexto('TIPOLOCALIDADE', 'Tipo de Localidade', false, 1, 1);
$vetCampo['CODMUN']        = objInteiro('CODMUN', 'MUNICIPIO', false, 11, 11);

$vetCampo['PopCid']        = objInteiro('PopCid', 'Pop. Cidade', false, 11, 11);
$vetCampo['PopUrb']        = objInteiro('PopUrb', 'Pop. Urbana', false, 11, 11);
$vetCampo['PopRur']        = objInteiro('PopRur', 'Pop. Rural', false, 11, 11);
$vetCampo['AnoRefPop']     = objInteiro('AnoRefPop', 'Ano Ref. População', false, 6, 6);

$vetCampo['NumEmp']        = objInteiro('NumEmp', 'Na Cidade', false, 11, 11);
$vetCampo['NumIndust']     = objInteiro('NumIndust', 'Na Industria', false, 11, 11);
$vetCampo['NumEmpCom']     = objInteiro('NumEmpCom', 'No Comercio', false, 11, 11);
$vetCampo['NumEmpSer']     = objInteiro('NumEmpSer', 'Em Serviços', false, 11, 11);
$vetCampo['AnoRefTot']     = objInteiro('AnoRefTot', 'Ano Ref. da Informação', false, 6,6);

$vetCampo['NumFaculd']     = objInteiro('NumFaculd', 'Num. Faculdades', false, 6, 6);
$vetCampo['NumEscolas']     = objInteiro('NumEscolas', 'Num. Escolas', false, 11,11);

$vetCampo['Capital']       = objTexto('Capital', 'Capital', false, 3, 3);
$vetCampo['IndCapital']    = objInteiro('IndCapital', 'Ind.Capital', false, 1, 1);

$vetCampo['Fonte']         = objTexto('Fonte', 'Fonte', false, 50, 50);
$vetCampo['IndAtuCid']     = objTexto('IndAtuCid', 'Ind.Atu.Cidade', false, 3, 3);

$vetCampo['IndAtualizacao']    = objInteiro('IndAtualizacao', 'Ind.Atualizacao', false, 1, 1);
$vetCampo['Status']        = objInteiro('Status', 'Status', false, 4, 4);


$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['CodCid'],'',$vetCampo['DescCid'],'',$vetCampo['SITUACAO']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Local</span>', Array(
    Array($vetCampo['TIPOLOCALIDADE'],'',''),
    Array($vetCampo['CodEst'],'',$vetCampo['CODMUN']),
    Array($vetCampo['CodMeso'],'',$vetCampo['CodMicro']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>População</span>', Array(
    Array($vetCampo['AnoRefPop'],'',$vetCampo['PopCid'],'',$vetCampo['PopUrb'],'',$vetCampo['PopRur']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Empregados</span>', Array(
    Array($vetCampo['AnoRefTot'],'',$vetCampo['NumEmp'],'',$vetCampo['NumIndust'],'',$vetCampo['NumEmpCom'],'',$vetCampo['NumEmpSer']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Outros</span>', Array(
    Array($vetCampo['NumFaculd'],'',$vetCampo['NumEscolas'],'',$vetCampo['IndCapital'],'',$vetCampo['Capital']),
    Array($vetCampo['IndAtualizacao'],'',$vetCampo['Status'],'',$vetCampo['IndAtuCid'],'',$vetCampo['Fonte']),
),$class_frame,$class_titulo,$titulo_na_linha);



$vetCad[] = $vetFrm;
?>
