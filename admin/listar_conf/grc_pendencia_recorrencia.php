<?php
$idCampo = 'idt';
$Tela = "a Recorrência da Pendência";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc = "grc_pendencia_recorrencia";
$AliasPric = "grc_pr";
$Entidade = "Recorrência da Pendência";
$Entidade_p = "Recorrências da Pendência";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";


$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//Monta o vetor de Campo
$vetCampo['codigo'] = CriaVetTabela('Código');
$vetCampo['ordem'] = CriaVetTabela('Recorrência');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetPeriodicidade = Array();
$vetPeriodicidade[0] = 'Diária';
$vetPeriodicidade[1] = 'Mensal - mesmo dia';
$vetPeriodicidade[2] = 'Mensal - No último Dia';
$vetCampo['periodicidade'] = CriaVetTabela('Periodicidade', 'descDominio', $vetSimNao);
$vetCampo['periodo'] = CriaVetTabela('Período');
$vetCampo['observacao'] = CriaVetTabela('Observação');

$sql = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= ' lower(codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(observacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by codigo, ordem';

/*
  $t  = new  PIR_entidades();
  $vt = $t -> estrutura_tr(''.db_pir_grc.'grc_evento');
  // p($vt);
  $WS = $t -> estrutura_cd('WS');
  p($WS);

  $FD = $t -> estrutura_cd('FD');
  p($FD);

  $FD_PHP = $t -> estrutura_cd('FD_PHP');
  p($FD_PHP);
  $WS_PHP = $t -> estrutura_cd('WS_PHP');
  p($WS_PHP);

  $TP_CPO = $t -> estrutura_cd('TP_CPO');
  p($TP_CPO);


$idt_evento = 104;
$variavel = array();
$ret = GEC_contratacao_credenciado_ordem($idt_evento, $variavel, true, false);

if ($variavel['erro'] != '') {
    $variavel['erro'] = 'Erro na geração da Ordem de Contratação.<br />'.$variavel['erro'];
    msg_erro($variavel['erro']);
}
 */
