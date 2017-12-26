<?php
$idCampo = 'idt';
$Tela = "a Categoria de Atendimento";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.categoriaatendimento";
$AliasPric        = "siac_ca";
$Entidade         = "Categoria de Atendimento";
$Entidade_p       = "Categorias de Atendimento";

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
$vetCampo['CodCategoria']    = CriaVetTabela('Código');
$vetCampo['DescCategoria'  ] = CriaVetTabela('Descrição');
$vetCampo['Situacao']      = CriaVetTabela('Situação', 'descDominio', $vetSimNao );

$sql  = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= '    lower(CodCategoria) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(DescCategoria) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by CodCategoria';
?>
