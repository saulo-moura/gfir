<?php
$tabela = 'plu_pais';
$id = 'idt';
$vetCampo['codigo']    = objTexto('codigo', 'Sigla', True, 2,2);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 45,120);
$vetCampo['imagem']    = objFile('imagem', 'Imagem (75px x 75px)', False, 75, 'imagem', 75, 75, 0, false);
$vetCampo['ordem']     = objInteiroZero('ordem', 'Ordem', True, 3,3);



$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),
    Array($vetCampo['imagem']),
    Array($vetCampo['ordem']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>