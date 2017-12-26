<?php
$idCampo = 'idt';
$Tela = "o Tipo da Estrutura";
//Monta o vetor de Campo

$vetCampo['classificacao']    = CriaVetTabela('Classificação');
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['imagem']    = CriaVetTabela('Símbolo', 'arquivo', '25', 'sca_tipo_estrutura');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['scante_descricao'] = CriaVetTabela('Natureza');

$sql   = 'select ';
$sql  .= '   scate.idt,  ';
$sql  .= '   scate.*,  ';
$sql  .= '   scante.descricao as scante_descricao ';

$sql  .= ' from sca_tipo_estrutura as scate ';

$sql  .= ' inner join sca_natureza_tipo_estrutura scante on scante.idt = scate.idt_sca_natureza_tipo_estrutura';
$sql  .= ' order by scate.classificacao';
?>
