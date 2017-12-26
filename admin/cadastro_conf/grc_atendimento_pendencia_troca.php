<?php
$tabela = 'grc_atendimento_pendencia';
$id = 'idt';

$sql = '';
$sql .= ' select a.idt_projeto_acao';
$sql .= ' from grc_atendimento_pendencia ap';
$sql .= ' inner join grc_atendimento a on a.idt = ap.idt_atendimento';
$sql .= ' where ap.idt = '.null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

$vetCampo['data'] = objTextoFixo('data', 'Data da Pendência', '', true);
$vetCampo['idt_usuario'] = objFixoBanco('idt_usuario', 'Solicitante', 'plu_usuario', 'id_usuario', 'nome_completo');
$vetCampo['idt_ponto_atendimento'] = objFixoBanco('idt_ponto_atendimento', 'Ponto de Atendimento', db_pir.'sca_organizacao_secao', 'idt', 'descricao');
$vetCampo['protocolo'] = objTextoFixo('protocolo', 'Protocolo', '', true);
$vetCampo['assunto'] = objTextoFixo('assunto', 'Assunto', '', true);
$vetCampo['observacao'] = objTextoFixo('observacao', 'Detalhamento da Pendência', '', true);
$vetCampo['idt_gestor_local'] = objFixoBanco('idt_gestor_local', 'Responsável pela Solução Atual', 'plu_usuario', 'id_usuario', 'nome_completo');

$sql = '';
$sql .= ' select u.id_usuario, u.nome_completo';
$sql .= ' from plu_usuario u';
$sql .= " where u.matricula_intranet <> '' ";
$sql .= " and u.ativo = 'S'";
$sql .= ' order by u.nome_completo';
$vetCampo['idt_responsavel_solucao'] = objCmbBanco('idt_responsavel_solucao', 'Novo Responsável pela Solução', true, $sql);

$vetFrm = Array();

MesclarCol($vetCampo['assunto'], 7);
MesclarCol($vetCampo['observacao'], 7);
MesclarCol($vetCampo['idt_responsavel_solucao'], 7);
MesclarCol($vetCampo['idt_gestor_local'], 7);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['data'], '', $vetCampo['idt_usuario'], '', $vetCampo['idt_ponto_atendimento'], '', $vetCampo['protocolo']),
    Array($vetCampo['assunto']),
    Array($vetCampo['observacao']),
    Array($vetCampo['idt_gestor_local']),
    Array($vetCampo['idt_responsavel_solucao']),
        ));

$vetCad[] = $vetFrm;
