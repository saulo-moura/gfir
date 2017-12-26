<?php
require_once '../configuracao.php';

$host_ip = '10.6.14.15';
$bd_user = 'lupe'; // Login do Banco
$password = 'my$ql$sebrae'; // Senha de acesso ao Banco

$host = $tipodb.':host='.$host_ip.';dbname=db_pir_grc_v2;port=3306';
$conO = new_pdo($host, $bd_user, $password, $tipodb);

$host = $tipodb.':host='.$host_ip.';dbname=db_pir_grc;port=3306';
$conD = new_pdo($host, $bd_user, $password, $tipodb);

$vetDeleta = Array(
    'grc_atendimento_anexo',
    'grc_atendimento_gera_agenda',
    'grc_atendimento_avulso',
    'grc_atendimento_agenda_painel',
    'grc_atendimento_agenda',
    'grc_atendimento_abertura',
    'grc_sincroniza_siac',
    'grc_atendimento_tema',
    'grc_atendimento_pessoa',
    'grc_atendimento_pendencia',
    'grc_atendimento_organizacao',
    'grc_evento_produto',
    'grc_evento_local',
    'grc_evento_responsavel',
    'grc_evento_periodo',
    'grc_evento_participante',
    'grc_evento_ocorrencia',
    'grc_evento',
    'grc_atendimento_pessoa_produto_interesse',
    'grc_atendimento_produto',
    'grc_atendimento',
);

$vetMigra = Array(
    'grc_produto_area_conhecimento',
    'grc_produto_arquivo_associado',
    'grc_produto_conteudo_programatico',
    'grc_produto_insumo',
    'grc_produto_metodologia',
    'grc_produto_ocorrencia',
    'grc_produto_produto',
    'grc_produto_programar',
    'grc_produto_realizador',
    'grc_produto_unidade_regional',
    'grc_produto_versao',
    'grc_produto',
    'grc_produto_abrangencia',
    'grc_produto_area_competencia',
    'grc_produto_canal_midia',
    'grc_produto_conteudo_programatico_n',
    'grc_produto_dimensao_complexidade',
    'grc_produto_familia',
    'grc_produto_foco',
    'grc_produto_grupo',
    'grc_produto_maturidade',
    'grc_produto_metodologia_n',
    'grc_produto_modalidade',
    'grc_produto_modelo_certificado',
    'grc_produto_realizador_relacao',
    'grc_produto_situacao',
    'grc_produto_tag_pesquisa',
    'grc_produto_tema',
    'grc_produto_tipo',
    'grc_produto_tipo_autor',
    'grc_publico_alvo',
);

beginTransaction($conD);

foreach ($vetDeleta as $tabela) {
    set_time_limit(30);
    
    $sql = 'delete from '.$tabela;
    execsql($sql, true, $conD);
    
    $sql = 'alter table '.$tabela.' auto_increment = 1';
    execsql($sql, true, $conD);
}

foreach ($vetMigra as $tabela) {
    set_time_limit(30);
    
    $sql = 'delete from '.$tabela;
    execsql($sql, true, $conD);
}

$vetMigra = array_reverse($vetMigra);

foreach ($vetMigra as $tabela) {
    set_time_limit(30);
    
    $sql = '';
    $sql .= ' select *';
    $sql .= ' from '.$tabela;
    $rs = execsql($sql, true, $conO);

    if ($rs->rows > 0) {
        $campos = $rs->info['name'];

        foreach ($rs->data as $row) {
            $vetVL = Array();

            foreach ($campos as $col) {
                $vetVL[$col] = aspa($row[$col]);
            }

            $sql = 'insert into '.$tabela.' ('.implode(', ', $campos).') values ('.implode(', ', $vetVL).')';
            execsql($sql, true, $conD);
        }
    }

    $sql = 'alter table '.$tabela.' auto_increment = 1';
    execsql($sql, true, $conD);
}

commit($conD);

echo 'FIM...';
