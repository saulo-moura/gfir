<?php
$idCampo = 'idt';
$Tela = "o Documento do Tipo do Serviço";
//
$TabelaPai   = "gec_tipo_servico";
$AliasPai    = "gec_ts";
$EntidadePai = "Tipo  de Serviço";
$CampoPricPai= "idt_tipo_servico";

//
$upCad   = vetCad('', $EntidadePai, $TabelaPai);
//
$TabelaPrinc      = "gec_tipo_servico_documento";
$AliasPric        = "gec_tsd";
$Entidade         = "Documento do Tipo do Serviço";
$Entidade_p       = "Documentos do Tipo do Serviço";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

//
$Filtro = Array();
$Filtro['campo']  = 'descricao';
$Filtro['tabela'] = 'gec_tipo_servico';
$Filtro['id']     = 'idt';
$Filtro['nome']   = 'Tipo de Serviço';
$Filtro['valor']  = trata_id($Filtro);
$vetFiltro['idt_tipo_servico'] = $Filtro;
//
$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//
$orderby = "{$AliasPai}.codigo";
//Monta o vetor de Campo
$vetCampo["gec_do_descricao"] = CriaVetTabela('Documento');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

//
$sql  = "select {$AliasPric}.*, ";
$sql .= "        gec_do.descricao as gec_do_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
$sql .= " inner join gec_documento gec_do on  gec_do.idt = {$AliasPric}.idt_documento";
$sql .= " where {$AliasPric}.idt_tipo_servico = ".null($vetFiltro['idt_tipo_servico']['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPai.'.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower('.$AliasPai.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';
$sql .= " order by {$orderby}";
?>