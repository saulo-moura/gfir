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
$vetCampo['gec_ns_descricao'] = CriaVetTabela('Natureza do Serviзo');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = 'select gec_me.*, gec_ns.descricao as gec_ns_descricao ';
$sql  .= ' from gec_metodologia gec_me ';
$sql  .= ' inner join gec_natureza_servico gec_ns on gec_ns.idt = gec_me.idt_natureza_servico';
$sql .= ' where ';
$sql .= ' lower(gec_me.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(gec_me.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_ns.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by codigo';
?>