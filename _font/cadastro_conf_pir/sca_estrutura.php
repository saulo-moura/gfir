<?php
$tabela = 'sca_estrutura';
$id = 'idt';

$vetCampo['idt_organizacao'] = objFixoBanco('idt_organizacao', 'Organizacao', 'sca_estrutura_organizacional', 'idt', 'descricao', 0);


$vetCampo['codigo']        = objTexto('codigo', 'Cуdigo', True, 45, 45);
$vetCampo['classificacao'] = objTexto('classificacao', 'Classificaзгo', True, 45, 45);
$vetCampo['descricao']     = objTexto('descricao', 'Descriзгo', True, 60, 120);

$vetTipo['MP']='MACROPROCESSO';
$vetTipo['PR']='PROCESSO';
$vetTipo['SP']='SUB PROCESSO';
$vetTipo['AT']='ATIVIDADE';

$sql = 'select idt , classificacao, codigo, descricao from sca_tipo_estrutura order by classificacao';
$vetCampo['idt_sca_tipo_estrutura'] = objCmbBanco('idt_sca_tipo_estrutura', 'Tipo', true, $sql);

$sql = 'select idt , codigo, descricao from sca_sistema order by codigo';
$vetCampo['idt_sistema'] = objCmbBanco('idt_sistema', 'Sistema', false, $sql);

$vetNivel=Array();
$vetNivel['E']='Estratйgico';
$vetNivel['T']='Tбtico';
$vetNivel['O']='Operacional';
$vetCampo['nivel']       = objCmbVetor('nivel', 'Nнvel', True, $vetTipo,'','width:100px;');

$vetCampo['grau']     = objInteiro('grau', 'Grau', True, 5);


$vetCampo['sistema_executa']     = objTexto('sistema_executa', 'Onde Executa', false, 60, 120);
$vetCampo['classificacao_sistema']     = objTexto('classificacao_sistema', 'Classificaзгo no Sistema', false, 60, 120);



$vetCampo['arquivo'] = objFile('arquivo', 'Araquivo .csv', false, 40,'todos');

$vetCampo['descricao_detalhada'] = objHTML('descricao_detalhada', 'Descriзгo Detalhada', false);

$vetFrm = Array();


$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_organizacao']),
));


$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['classificacao']),
    Array($vetCampo['idt_sca_tipo_estrutura']),
    Array($vetCampo['descricao']),
));


$vetFrm[] = Frame('', Array(
    Array($vetCampo['nivel']),
));
$vetFrm[] = Frame(' Executar em ', Array(
    Array($vetCampo['sistema_executa'], ' ', $vetCampo['classificacao_sistema']),
));

$vetFrm[] = Frame(' Associado ao Sistema ', Array(
    Array($vetCampo['idt_sistema']),
));


$vetFrm[] = Frame('', Array(
    Array($vetCampo['descricao_detalhada']),
));

//$vetFrm[] = Frame(' Aarquivo .csv ', Array(
//    Array($vetCampo['arquivo']),
//));



$vetCad[] = $vetFrm;
?>