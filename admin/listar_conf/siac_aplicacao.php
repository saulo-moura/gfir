<?php
$idCampo = 'idt';
$Tela = "a Aplica��o";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.aplicacao";
$AliasPric        = "siac_a";
$Entidade         = "Aplica��o";
$Entidade_p       = "Aplica��es";

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
$vetCampo['aplicacaoCodigo']      = CriaVetTabela('C�digo');
$vetCampo['aplicacaoDescricao'  ] = CriaVetTabela('Descri��o');
$vetCampo['tipo']                 = CriaVetTabela('Tipo');
$vetCampo['ExibirAplicacao']      = CriaVetTabela('Exibir a Aplicacao��o', 'descDominio', $vetSimNao );
$vetCampo['TipoSIAC']             = CriaVetTabela('Tipo SIAC');

$sql  = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= '    lower(aplicacaoCodigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(aplicacaoDescricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by aplicacaoCodigo';
?>
