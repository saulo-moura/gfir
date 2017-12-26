<?php
$idCampo = 'idt';
$Tela = "o Bairro";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.bairro";
$AliasPric        = "siac_ba";
$Entidade         = "Bairro";
$Entidade_p       = "Bairros";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";


$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//Monta o vetor de Campo

$vetCampo['codbairro']     = CriaVetTabela('Código');
$vetCampo['descbairro']    = CriaVetTabela('Descrição');
$vetCampo['abrevbairro']   = CriaVetTabela('Abrev.Bairro');
$vetCampo['indtipo']       = CriaVetTabela('Tipo');
$vetCampo['indcadcorreio'] = CriaVetTabela('Ind.Cad.Correio');
$vetCampo['desc_cidade']   = CriaVetTabela('Cidade');
$vetCampo['SITUACAO']      = CriaVetTabela('Situação');

$sql  = "select {$TabelaPrinc}.*,DescCid as desc_cidade  from {$TabelaPrinc} ";
$sql .= " left join  db_pir_siac.cidade as cid on cid.CodCid = db_pir_siac.bairro.codcid";
$sql .= " where ";
$sql .= '    lower(codbairro)    like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(descbairro)   like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(abrevbairro)  like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(DescCid)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by codbairro';
?>
