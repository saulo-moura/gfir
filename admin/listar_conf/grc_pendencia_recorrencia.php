<?php
$idCampo = 'idt';
$Tela = "a Recorr�ncia da Pend�ncia";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc = "grc_pendencia_recorrencia";
$AliasPric = "grc_pr";
$Entidade = "Recorr�ncia da Pend�ncia";
$Entidade_p = "Recorr�ncias da Pend�ncia";

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
$vetCampo['codigo'] = CriaVetTabela('C�digo');
$vetCampo['ordem'] = CriaVetTabela('Recorr�ncia');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
$vetPeriodicidade = Array();
$vetPeriodicidade[0] = 'Di�ria';
$vetPeriodicidade[1] = 'Mensal - mesmo dia';
$vetPeriodicidade[2] = 'Mensal - No �ltimo Dia';
$vetCampo['periodicidade'] = CriaVetTabela('Periodicidade', 'descDominio', $vetSimNao);
$vetCampo['periodo'] = CriaVetTabela('Per�odo');
$vetCampo['observacao'] = CriaVetTabela('Observa��o');

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
    $variavel['erro'] = 'Erro na gera��o da Ordem de Contrata��o.<br />'.$variavel['erro'];
    msg_erro($variavel['erro']);
}
 */
