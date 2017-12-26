<?php
$tabela = 'plu_estado';
$id = 'idt';
$vetCampo['idt_pais'] = objFixoBanco('idt_pais', 'País', 'plu_pais', 'idt', 'descricao', 0);
$vetCampo['codigo'] = objTexto('codigo', 'Sigla', True, 2,2);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 45,120);
$vetCampo['imagem'] = objFile('imagem', 'Imagem (75px x 75px)', False, 75, 'imagem', 75, 75, 0, false);
$vetCampo['ordem'] = objInteiroZero('ordem', 'Ordem', True, 3,3);
$vetCampo['poligono'] = objTextArea('poligono', 'Poligono Mapa', false, 30000, 'width: 630px; height: 140px;');
$vetCampo['pos_sigla'] = objTexto('pos_sigla', 'Coordenada Sigla', false, 45,45);
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação do País</span>', Array(
    Array($vetCampo['idt_pais']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('<span>Identificação do Estado</span>', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),
    Array($vetCampo['imagem']),
    Array($vetCampo['ordem']),
    Array($vetCampo['pos_sigla']),
    Array($vetCampo['poligono']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>