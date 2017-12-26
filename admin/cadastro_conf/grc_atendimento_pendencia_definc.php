<?php
if ($acao == 'inc') {
    $datadia = trata_data(date('d/m/Y H:i:s'));
    $vetRow['grc_atendimento_pendencia']['data'] = $datadia;
    $vetRow['grc_atendimento_pendencia']['data_solucao'] = $datadia;

    $vetRow['grc_atendimento_pendencia']['idt_usuario'] = $_SESSION[CS]['g_id_usuario'];
    $vetRow['grc_atendimento_pendencia']['idt_responsavel_solucao'] = $_SESSION[CS]['g_id_usuario'];

    $vetRow['grc_atendimento_pendencia']['recorrencia'] = '';

    $vetRow['grc_atendimento_pendencia']['status'] = 'Aberto';
    $vetRow['grc_atendimento_pendencia']['tipo'] = 'Atendimento Presencial';

    $vetRow['grc_atendimento_pendencia']['idt_ponto_atendimento'] = $idt_ponto_atendimento;
    $vetRow['grc_atendimento_pendencia']['protocolo'] = $protocolo;


    $vetRow['grc_atendimento_pendencia']['nome_cliente'] = $nome_pf;
    $vetRow['grc_atendimento_pendencia']['cod_cliente_siac'] = $codigo_siacweb_pf;
    $vetRow['grc_atendimento_pendencia']['cpf'] = $codigo_pf;

    $vetRow['grc_atendimento_pendencia']['nome_empreendimento'] = $nome_pj;
    $vetRow['grc_atendimento_pendencia']['cod_empreendimento_siac'] = $codigo_siacweb_pj;
    $vetRow['grc_atendimento_pendencia']['cnpj'] = $codigo_pj;
}