<?php
$idCampo = 'idt';
$Tela = "a Aplicação";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.aplicacao";
$AliasPric        = "siac_a";
$Entidade         = "Aplicação";
$Entidade_p       = "Aplicações";

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
$vetCampo['aplicacaoCodigo']      = CriaVetTabela('Código');
$vetCampo['aplicacaoDescricao'  ] = CriaVetTabela('Descrição');
$vetCampo['tipo']                 = CriaVetTabela('Tipo');
$vetCampo['ExibirAplicacao']      = CriaVetTabela('Exibir a Aplicacaoção', 'descDominio', $vetSimNao );
$vetCampo['TipoSIAC']             = CriaVetTabela('Tipo SIAC');

$sql  = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= '    lower(aplicacaoCodigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(aplicacaoDescricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by aplicacaoCodigo';
?>
