<?php
require_once '../configuracao.php';

$vetDeleta = Array(
    'grc_evento_participante',
    'grc_sincroniza_siac',
    'grc_atendimento_diagnostico',
    'grc_atendimento_anexo',
    'grc_atendimento_gera_agenda',
    'grc_atendimento_avulso',
    'grc_atendimento_abertura',
    'grc_atendimento_tema',
    'grc_atendimento_pessoa_arquivo_interesse',
    'grc_atendimento_pessoa_produto_interesse',
    'grc_atendimento_pessoa_tema_interesse',
    'grc_atendimento_pessoa',
    'grc_atendimento_pendencia',
    'grc_atendimento_organizacao_cnae',
    'grc_atendimento_organizacao',
    'grc_atendimento_produto',
    'grc_atendimento',
    'grc_atendimento_agenda_ocorrencia',
    'grc_atendimento_agenda_painel',
    'grc_atendimento_agenda',
    'grc_atendimento_pa_pessoa',
    
    'grc_pergunta_resposta',
    'grc_pergunta',
    
    //Evento
    'grc_evento_tema',
    'grc_evento_stand',
    'grc_evento_responsavel',
    'grc_evento_programacao',
    'grc_evento_produto',
    'grc_evento_periodo',
    'grc_evento_ocorrencia',
    'grc_evento_agenda',
    'grc_evento_local_pa_agenda',
    'grc_evento_local_pa',
    'grc_evento_local',
    'grc_evento_insumo',
    'grc_evento_etapa',
    'grc_evento_cnae',
    'grc_evento_autorizador',
    'grc_evento',
);

beginTransaction();

foreach ($vetDeleta as $tabela) {
    set_time_limit(30);
    
    $sql = 'delete from '.$tabela;
    execsql($sql);
    
    $sql = 'alter table '.$tabela.' auto_increment = 1';
    execsql($sql);
}

commit();

echo 'FIM...';
