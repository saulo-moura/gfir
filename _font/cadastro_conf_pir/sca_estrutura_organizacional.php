<?php
$tabela = 'sca_estrutura_organizacional';
$id = 'idt';

$vetCampo['codigo']        = objTexto('codigo', 'Código', True, 45, 45);
$vetCampo['classificacao'] = objTexto('classificacao', 'Classificação', True, 45, 45);
$vetCampo['descricao']     = objTexto('descricao', 'Descrição', True, 60, 120);

$vetTipo['MP']='MACROPROCESSO';
$vetTipo['PR']='PROCESSO';
$vetTipo['SP']='SUB PROCESSO';
$vetTipo['AT']='ATIVIDADE';

$sql = 'select idt , codigo, descricao from sca_tipo_estrutura order by codigo';
$vetCampo['idt_sca_tipo_estrutura'] = objCmbBanco('idt_sca_tipo_estrutura', 'Tipo', true, $sql);


$vetNivel=Array();
$vetNivel['E']='Estratégico';
$vetNivel['T']='Tático';
$vetNivel['O']='Operacional';

$vetCampo['nivel']       = objCmbVetor('nivel', 'Nível', True, $vetTipo,'','width:100px;');

$vetCampo['grau']     = objInteiro('grau', 'Grau', True, 5);


$vetCampo['arquivo'] = objFile('arquivo', 'Arquivo SEÇÕES .csv', false, 40,'todos');

$vetCampo['arquivo_processo'] = objFile('arquivo_processo', 'Arquivo PROCESSOS .csv', false, 40,'todos');



$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['classificacao']),
    Array($vetCampo['idt_sca_tipo_estrutura']),
    Array($vetCampo['descricao']),
));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['nivel']),
));


$vetFrm[] = Frame('', Array(
    Array($vetCampo['arquivo']),
    Array($vetCampo['arquivo_processo']),
));


$vetCad[] = $vetFrm;
?>