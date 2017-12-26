<?php
$idCampo = 'idt';
$Tela = "o Glossário";


//echo " entra pelo pir de forma geral pelo gec ";

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Texto a pesquisar';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//   Monta o vetor de Campo
$vetCampo['termo']            = CriaVetTabela('Têrmo');
$vetCampo['plu_gn_descricao'] = CriaVetTabela('Natureza');
$vetCampo['resumo']           = CriaVetTabela('Resumo');
//
$sql   = 'select ';
$sql  .= '   plu_g.*,  ';
$sql  .= '   plu_gn.descricao as plu_gn_descricao ';
$sql  .= ' from '.db_pir.'plu_pl_glossario as plu_g ';
$sql  .= ' inner join '.db_pir.'plu_pl_glossario_natureza plu_gn on plu_gn.idt = plu_g.idt_natureza';

$sql .= ' where ';
$sql .= ' ( ';
$sql .= ' lower(termo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' and lower(texto) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' and lower(plu_gn.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';
//$sql .= ' order by plu_g.termo';
?>
