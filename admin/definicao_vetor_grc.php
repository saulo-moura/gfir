<?php
$vetTramitacao = Array();
$vetTramitacao['R'] = "Resolvida";
$vetTramitacao['E'] = "Encaminhada";

$vetEventoPecaPadrao = Array(
    'S' => 'Padr�o da UAIN',
    'N' => 'Outras da UAIN',
    'G' => 'Propria do Gestor',
);

$vetEventoPublicaInternet = Array(
    'N' => 'N�o Publicado',
    'S' => 'Publicado',
);

$vetEventoPubilcar = Array(
    'AA' => 'Aguardando Aprova��o',
    'FI' => 'Finalizado',
    'FR' => 'Finalizado com Reprova��o',
    'CA' => 'Cancelado',
);

$vetEventoPubilcarRegistro = Array(
    'AA' => 'Aguardando Aprova��o',
    'AP' => 'Aprovado',
    'RE' => 'Reprovado',
    'CA' => 'Cancelado',
);

$vetPapelOrientacao = Array(
    'P' => 'Retrato',
    'L' => 'Paisagem',
);

$vetTipoEvento = Array(
    'M' => 'Miss�o',
    'C' => 'Caravana',
);

$vetParametroEventoCertificado = Array(
    '#sebrae_nome#' => 'Nome do SEBRAE',
    '#sebrae_cidade#' => 'Cidade do SEBRAE',
    '#sebrae_estado#' => 'Estado do SEBRAE',
    '#sebrae_bairro#' => 'Bairro do SEBRAE',
    '#sebrae_cnpj#' => 'CNPJ do SEBRAE',
    '#evento_nome#' => 'Codigo e Descri��o do Evento',
    '#evento_freq#' => 'Frequ�ncia m�nima',
    '#representante_nome#' => 'Nome da Pessoa F�sica',
    '#representante_cidade#' => 'Cidade da Pessoa F�sica',
    '#representante_estado#' => 'Estado da Pessoa F�sica',
    '#representante_bairro#' => 'Bairro da Pessoa F�sica',
    '#representante_cep#' => 'CEP da Pessoa Jur�dica',
    '#representante_telefone#' => 'Telefone Celular, Recado ou Residencial',
    '#representante_cpf#' => 'CPF da Pessoa F�sica',
    '#empresa_nome#' => 'Raz�o Social da Pessoa Jur�dica',
    '#empresa_cidade#' => 'Cidade da Pessoa Jur�dica',
    '#empresa_estado#' => 'Estado da Pessoa Jur�dica',
    '#empresa_bairro#' => 'Bairro da Pessoa Jur�dica',
    '#empresa_cep#' => 'CEP da Pessoa Jur�dica',
    '#empresa_telefone#' => 'Telefone ou Celular da Pessoa Jur�dica',
    '#empresa_cnpj#' => 'CNPJ da Pessoa Jur�dica',
);

$vetParticipacaoEvento = Array(
    'PRMC' => 'Promotor (Participantes de Miss�es/Caravanas do Sebrae)',
    'ACMC' => 'Acesso (Participantes de Miss�es/Caravanas de Terceiros - apoiadoss pelo Sebrae)',
    'PRFE' => 'Promotor (Expositores em feira do Sebrae)',
    'ACFE' => 'Acesso (Expositores em feira de Terceiros - apoiadoss pelo Sebrae)',
);

$vetNanOrdemPagSituacao = Array(
    'GE' => 'Gerada',
    'V3' => 'Validando pelo Gestor Local',
    'V10' => 'Validando pelo Gerente Regional',
    'V4' => 'Validando pelo Tutor S�nior',
    'V2' => 'Validando pelo Gestor Estadual',
    'V9' => 'Validando pelo Gerente Estadual',
    'V8' => 'Validando pelo Diretor',
    'AP' => 'Aprovado',
);

$vetRecorrencia = Array(
    1 => 'Um',
    3 => 'Tr�s',
    5 => 'Cinco',
    7 => 'Sete',
);

$vetEventoContrato = Array(
    'R' => 'Rascunho',
    'A' => 'Em Assinatura',
    'C' => 'Concluido',
    'G' => 'Gratuito',
    'S' => 'SiacWeb',
    'IC' => 'Inscri��o Cancelada',
    'FE' => 'Fila de Espera',
);

$vetEventoMatFE = Array(
    'AM' => 'Aguardando Matr�cula',
    'MA' => 'Matr�culado',
    'QP' => 'Queda por expira��o do Prazo',
);

$vetEventoEnvioOpcao = Array(
    'SE' => 'SEDEX',
    'MA' => 'MALOTE',
    'RL' => 'RETIRADO IN LOCO',
);

$vetEventoStsEntrega = Array(
    'PE' => 'PENDENTE',
    'EA' => 'EM ATENDIMENTO',
    'PP' => 'PRONTO PARA ENVIO',
    'EN' => 'ENVIADO',
    'RE' => 'RECEBIDO',
);

$vetEventoStsInsumo = Array(
    'PENDENTE' => 'PENDENTE',
    'ATENDIDO' => 'ATENDIDO',
    'N�O ATENDIDO' => 'N�O ATENDIDO',
);

$vetNanCicloAtendimento = Array(
    1 => 'PRIMEIRO CICLO',
    2 => 'SEGUNDO CICLO',
    3 => 'TERCEIRO CICLO',
    4 => 'QUARTO CICLO',
    5 => 'QUINTO CICLO',
    6 => 'SEXTO CICLO',
    7 => 'S�TIMO CICLO',
    8 => 'OITAVO CICLO',
    9 => 'NONO CICLO',
    10 => 'D�CIMO CICLO',
);

$vetNanGrupo = Array(
    'CD' => 'Registro de Cadastro (AOE)',
    'DI' => 'Registro de Diagnostico (AOE)',
    'AT' => 'Registro de Atendimento (AOE)',
    'EV' => 'Aguardando Valida��o (Tutor)',
    'AP' => 'Validado (Tutor)',
    'CA' => 'Atendimento Cancelado (AOE)',
    'DE' => 'Devolvido para Ajustes (AOE)',
);

$vetSituacaoCredNacional = Array(
    0 => 'Credenciado ativo em avalia��o',
    1 => 'Credenciado ativo liberado',
    2 => 'Descredenciado',
    3 => 'Credenciado com restri��o',
    4 => 'Situa��o 4 na base Nacional',
    5 => 'Situa��o 5 na base Nacional',
);

$vetProdTipoCalculo = Array(
    'P' => 'Por participante',
    'E' => 'Por evento',
);

$vetTipoTransResp = Array(
    'T' => 'Transfer�ncia',
    'I' => 'Interinidade',
);

$vetTipoProdutoSebratec = Array(
    'S' => 'Pr�',
    'N' => 'P�s'
);
$vetEventoPubTipo = Array(
    'P' => 'Publica��o',
    'D' => 'Despublica��o',
);

$vetEventoPubSituacao = Array(
    'CD' => 'Cadastrado',
    'GP' => 'Aguardando aprova��o do Gestor do Projeto',
    'CG' => 'Aguardando aprova��o do Coordenador/Gerente',
    'DI' => 'Aguardando aprova��o do Diretor',
    'AP' => 'Aprovado',
    'CA' => 'Cancelado',
);

$vetEventoPubPublico = Array(
    'A' => 'Aberto',
    'F' => 'Fechado',
);

/**
 * Array dos tipo de Situa��o que pode ter o Evento associado ao um Combo
 * @access public
 * */
$vetSitEventoComboAss = Array(
    'CD' => 'Cadastrado',
    'GE' => 'Aguardando aprova��o do Gestor do Evento',
    'AP' => 'Aprovado',
    'RP' => 'Reprovado',
);

if ($debug || $_SESSION[CS]['g_vetEventoSituacao'] == '') {
    $sql = "select idt, descricao from " . db_pir_grc . "grc_evento_situacao where ativo = 'S'";
    $rs = execsql($sql);

    $vetEventoSituacao = Array();

    ForEach ($rs->data as $row) {
        $vetEventoSituacao[$row['idt']] = $row['descricao'];
    }

    $_SESSION[CS]['g_vetEventoSituacao'] = $vetEventoSituacao;
} else {
    $vetEventoSituacao = $_SESSION[CS]['g_vetEventoSituacao'];
}

if ($debug || $_SESSION[CS]['g_vetTipoVoucherCodIDT'] == '') {
    $sql = "select idt, codigo from " . db_pir_grc . "grc_evento_tipo_voucher";
    $rs = execsql($sql);

    $vetTipoVoucherCodIDT = Array();

    ForEach ($rs->data as $row) {
        $vetTipoVoucherCodIDT[$row['codigo']] = $row['idt'];
    }

    $_SESSION[CS]['g_vetTipoVoucherCodIDT'] = $vetTipoVoucherCodIDT;
} else {
    $vetTipoVoucherCodIDT = $_SESSION[CS]['g_vetTipoVoucherCodIDT'];
}

if ($debug || $_SESSION[CS]['tmp']['vetWizardTabela'] == '') {
    $sql = '';
    $sql .= ' select idt, descricao';
    $sql .= ' from ' . db_pir_grc . 'grc_politica_parametro_tabelas';
    $sql .= " where ativo = 'S'";
    $sql .= ' order by descricao';
    $rs_wizard_tabela = execsql($sql);

    $vetWizardTabela = Array();
    $vetRsWizardCampo = Array();

    foreach ($rs_wizard_tabela->data as $row) {
        $vetWizardTabela[$row['idt']] = $row['descricao'];
        
        $sql = '';
        $sql .= ' select codigo, tipo, descricao';
        $sql .= ' from ' . db_pir_grc . 'grc_politica_parametro_campos';
        $sql .= " where ativo = 'S'";
        $sql .= ' and idt_politica_parametro_tabelas = ' . null($row['idt']);
        $sql .= ' order by codigo';
        $vetRsWizardCampo[$row['idt']] = execsql($sql);
    }

    $sql = '';
    $sql .= ' select idt_politica_parametro_tabelas, codigo';
    $sql .= ' from ' . db_pir_grc . 'grc_politica_parametro_campos';
    $sql .= " where ativo = 'S'";
    $rs = execsqlNomeCol($sql);

    $vetIdtWizardParametro = Array();

    foreach ($rs->data as $row) {
        $vetIdtWizardParametro[$row['codigo']] = $row['idt_politica_parametro_tabelas'];
    }
    
    $_SESSION[CS]['tmp']['vetWizardTabela'] = $vetWizardTabela;
    $_SESSION[CS]['tmp']['vetRsWizardCampo'] = $vetRsWizardCampo;
    $_SESSION[CS]['tmp']['vetIdtWizardParametro'] = $vetIdtWizardParametro;
} else {
    $vetWizardTabela = $_SESSION[CS]['tmp']['vetWizardTabela'];
    $vetRsWizardCampo = $_SESSION[CS]['tmp']['vetRsWizardCampo'];
    $vetIdtWizardParametro = $_SESSION[CS]['tmp']['vetIdtWizardParametro'];
}
