<?php
$idCampo = 'idt';
$Tela = "o Fornecedor";
//   Monta o vetor de Campo
$vetCampo['identificacao']    = CriaVetTabela('CNPJ/CPF');
$vetCampo['razao_nome'] = CriaVetTabela('Razão Social/Nome');
$vetCampo['contatos'] = CriaVetTabela('Contatos');
$vetCampo['telefones'] = CriaVetTabela('telefones');
$vetCampo['telefones'] = CriaVetTabela('telefones');
$vetCampo['scasf_descricao'] = CriaVetTabela('Status');

//
$sql   = 'select ';
$sql  .= '   scaf.idt,  ';
$sql  .= '   scaf.*,  ';
$sql  .= '   scasf.descricao as scasf_descricao ';
$sql  .= ' from sca_fornecedor as scaf ';
$sql  .= ' inner join sca_status_fornecedor scasf on scasf.idt = scaf.idt_status ';
$sql  .= ' order by scaf.razao_nome';
?>
