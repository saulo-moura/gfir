<?php
$tabela = 'estado';
$id = 'idt';
$vetCampo['codigo'] = objTexto('codigo', 'Sigla', True, 2,2);
$vetCampo['descricao'] = objTexto('descricao', 'Descriчуo', True, 45,120);
$vetCampo['imagem'] = objFile('imagem', 'Imagem (75px x 75px)', False, 75, 'imagem', 75, 75, 0, false);
$vetCampo['ordem'] = objInteiroZero('ordem', 'Ordem', True, 3,3);

$vetCampo['poligono'] = objTextArea('poligono', 'Poligono Mapa', false, 30000, 'width: 630px; height: 140px;');
$vetCampo['pos_sigla'] = objTexto('pos_sigla', 'Coordenada Sigla', false, 45,45);


$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),
    Array($vetCampo['imagem']),
    Array($vetCampo['ordem']),
    Array($vetCampo['pos_sigla']),
    Array($vetCampo['poligono']),
));
$vetCad[] = $vetFrm;
?>