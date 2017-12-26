<?php
$idCampo = 'idt';
$Tela = "o Tipo da Estrutura";
//Monta o vetor de Campo

$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['imagem']    = CriaVetTabela('Símbolo', 'arquivo', '25', 'sca_natureza_tipo_estrutura');
$vetCampo['descricao'] = CriaVetTabela('Descrição');

$sql   = 'select ';
$sql  .= '   scante.idt,  ';
$sql  .= '   scante.*  ';

$sql  .= ' from sca_natureza_tipo_estrutura as scante ';
$sql  .= ' order by scante.codigo';
?>
