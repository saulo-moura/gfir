<?php
$idCampo = 'idt';
$Tela = "o Projeto";

$TabelaPrinc = "grc_projeto";
$AliasPric = "grc_pro";
$Entidade = "Projeto";
$Entidade_p = "Projetos";
$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";


// Filtro de texto
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

// Vetor com campos da tela
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
$vetCampo['gestor'] = CriaVetTabela('Gestor');
$vetCampo['etapa'] = CriaVetTabela('Fase');


$sql = "select ";
$sql .= "   {$AliasPric}.*, grc_ps.descricao as etapa, ";
$sql .= "    grc_pro.descricao as {$campoDescListarCmb}";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " left join grc_projeto_situacao grc_ps on grc_ps.idt = {$AliasPric}.idt_projeto_situacao ";
$sql .= ' where 1 = 1';

$sql .= ' and ativo_siacweb  = ' . aspa('S');
$sql .= ' and existe_siacweb = ' . aspa('S');

if ($_GET['idt_unidade'] != '') {
    $sql .= " and {$AliasPric}.idt in (";
    $sql .= ' select idt_projeto from grc_projeto_acao';
    $sql .= ' where ativo_siacweb  = ' . aspa('S');
    $sql .= ' and existe_siacweb = ' . aspa('S');
    $sql .= " and idt_unidade = " . null($_GET['idt_unidade']);
    $sql .= ' )';
}

if ($_GET['veio'] == 'SG') {
    $sql .= " and {$AliasPric}.idt in (";
    $sql .= ' select idt_projeto from grc_projeto_acao';
    $sql .= ' where ativo_siacweb  = ' . aspa('S');
    $sql .= ' and existe_siacweb = ' . aspa('S');
    $sql .= " and contrapartida_sgtec IS NOT NULL ";
    $sql .= ' )';
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '    lower(' . $AliasPric . '.codigo)      like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(' . $AliasPric . '.descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' ) ';
}

switch ($_GET['veiocad']) {
    case 'grc_evento':
        /*
          20	Em Ajuste de A��es
          110	Em An�lise a Solicita��o de Encerramento de Projeto Descontinuado
          125	Em An�lise a Solicita��o de Encerramento de Projeto Conclu�do
          126	Em An�lise a Solicita��o de Encerramento de Projeto Descontinuado
          140	Em An�lise da Solicita��o de Reestrutura��o
          225	Pactua��o do Comit� Nacional
          240	Em Repactua��o
          300	Em Classifica��o
          360	Em An�lise o Ajuste e a Reclassifica��o
          420	Em Or�amento
          430	Em Or�amento Complementar
          450	Or�amento em Libera��o por Encerramento
          480	Or�amento Ajustado em An�lise
          530	Or�amento Ajustado em Libera��o pelo Financeiro
          10	Em Ajuste
          60	Em An�lise de Consist�ncia da Reestrutura��o
          100	Em An�lise a Solicita��o de Encerramento de Projeto Conclu�do
          120	Em An�lise a Solicita��o de Encerramento de Projeto n�o Estruturado
          230	Em Reestrutura��o
          260	Em Execu��o
          440	Or�amento em Ajuste
          540	Or�amento Aguardando Aprova��o PPA
         * 
         */
        $sql .= " and grc_ps.codigo in ('20', '110', '125', '126', '140', '225', '240', '300', '360', '420', '430', '450', '480', '530', '10', '60', '100', '120', '230', '260', '440', '540')";
        break;
}

if ($sqlOrderby == '') {
    $sqlOrderby = "descricao asc";
}
