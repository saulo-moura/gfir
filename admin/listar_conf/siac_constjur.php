<?php
$idCampo = 'idt';
$Tela = "a Constituição Jurídica";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.constjur";
$AliasPric        = "siac_cj";
$Entidade         = "Constituição Jurídica";
$Entidade_p       = "Constituições Jurídica";

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
$vetCampo['CodConst']       = CriaVetTabela('Código');
$vetCampo['DescConst']      = CriaVetTabela('Descrição');
$vetCampo['DescAbrevConst'] = CriaVetTabela('Descrição');
$vetCampo['Situacao']       = CriaVetTabela('Situação', 'descDominio', $vetSimNao );
$vetCampo['Atende']         = CriaVetTabela('Atende', 'descDominio', $vetSimNao );
$vetCampo['Cadastro']       = CriaVetTabela('cadastro', 'descDominio', $vetSimNao );
$vetCampo['Parceiro']       = CriaVetTabela('Parceiro', 'descDominio', $vetSimNao );



$sql  = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= '    lower(CodConst)       like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(DescConst)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(DescAbrevConst) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by CodConst';
?>
