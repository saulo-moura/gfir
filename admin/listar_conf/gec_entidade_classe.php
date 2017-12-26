<?php
$idCampo = 'idt';
$Tela = "a Classe da Entidade";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "gec_entidade_classe";
$AliasPric        = "gec_ec";
$Entidade         = "Classe da Entidade";
$Entidade_p       = "Classes da Entidade";
//
$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";
//
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//
// Monta o vetor de Campo
//
$vetCampo['codigo']           = CriaVetTabela('Cуdigo');
$vetCampo['descricao']        = CriaVetTabela('Descriзгo');
$vetCampo['ativo']            = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
// $vetCampo['plu_ec_descricao'] = CriaVetTabela('Closse');
$vetCampo['gec_et_descricao']    = CriaVetTabela('Tipo da Entidade');
//
$sql  = "select {$AliasPric}.*, gec_et.descricao as gec_et_descricao  ";
$sql .= " from {$TabelaPrinc} {$AliasPric} ";
// $sql .= " inner join plu_entidade_classe plu_ec on plu_ec.idt = {$AliasPric}.idt_entidade_classe ";
$sql  .= ' inner join gec_entidade_tipo gec_et on gec_et.codigo = gec_ec.tipo_entidade ';

$sql .= ' where ';
$sql .= ' lower(gec_ec.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(gec_ec.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by gec_ec.codigo';
?>