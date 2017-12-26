<?php
$tabela = 'sca_sistema';
$id = 'idt';

$vetCampo['codigo'] = objTexto('codigo', 'Cуdigo', True, 2, 2);
$vetCampo['sigla'] = objTexto('sigla', 'Sigla', True, 15, 15);
$vetCampo['descricao'] = objTexto('descricao', 'Descriзгo', True, 60, 120);

$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', True, $maxlength, $style, $js);
$vetCampo['imagem']      = objFile('imagem', 'Logomarca 25 x 25 px', false, 80, 'imagem');
$sql = 'select idt , codigo, descricao from sca_status_sistema order by codigo';
$vetCampo['idt_status'] = objCmbBanco('idt_status', 'Status', false, $sql);
$sql = 'select idt , codigo, descricao from sca_porte_sistema order by codigo';
$vetCampo['idt_porte'] = objCmbBanco('idt_porte', 'Porte', false, $sql);
//
// Campos para o PDCA
//
$vetCampo['pdca'] = objCmbVetor('pdca', 'Pertence a Soluзгo?', false, $vetSimNao);
//
$vetPDCA=Array();
$vetPDCA['P']='Planejar';
$vetPDCA['D']='Executar';
$vetPDCA['C']='Verificar';
$vetPDCA['A']='Agir';
$vetCampo['quadrante'] = objCmbVetor('quadrante', 'Quadrante', false, $vetPDCA);

$vetCampo['linha'] = objInteiro('linha', 'Linha do Quadrante', false, 10);
$vetCampo['coluna'] = objInteiro('coluna', 'Coluna do Quadrante', false, 10);




$vetFrm = Array();
$vetFrm[] = Frame(' Identificaзгo ', Array(
    Array($vetCampo['codigo'],'',$vetCampo['sigla'],'',$vetCampo['descricao']),
));

$vetFrm[] = Frame(' Classificaзгo ', Array(
    Array($vetCampo['idt_status']),
    Array($vetCampo['idt_porte']),
));
$vetFrm[] = Frame(' PDCA ', Array(
    Array($vetCampo['pdca'], '', $vetCampo['quadrante'], '', $vetCampo['linha'], '', $vetCampo['coluna']),
));

$vetFrm[] = Frame(' Imagem e Detalhe ', Array(
    Array($vetCampo['imagem']),
    Array($vetCampo['detalhe']),
));
$vetCad[] = $vetFrm;
?>