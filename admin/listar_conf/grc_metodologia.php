<?php
$idCampo = 'idt';
$Tela = "a Metodologia";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$vetBtBarra[] = vetBtBarra('Sincronizar com SGC', 'imagens/calendar.gif', 'Sincronizar_Metodologia_sgc()');


$TabelaPrinc      = "gec_gec_metodologia";
$AliasPric        = "gec_me";
$Entidade         = "Metodologia";
$Entidade_p       = "Metodologias";

$barra_inc_h      = "Incluir um Novo Registro de Metodologia";
$contlinfim       = "Existem #qt Metodologias.";



$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['grc_ns_descricao'] = CriaVetTabela('Natureza do Serviзo');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = 'select grc_me.*, grc_ns.descricao as grc_ns_descricao ';
$sql  .= ' from grc_metodologia grc_me ';
$sql  .= ' inner join grc_natureza_servico grc_ns on grc_ns.idt = grc_me.idt_natureza_servico';
$sql .= ' where ';
$sql .= ' lower(grc_me.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(grc_me.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(grc_ns.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by codigo';
?>