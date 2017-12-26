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
$vetCampo['descricao'] = CriaVetTabela('Descriчуo');
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
          20	Em Ajuste de Aчѕes
          110	Em Anсlise a Solicitaчуo de Encerramento de Projeto Descontinuado
          125	Em Anсlise a Solicitaчуo de Encerramento de Projeto Concluэdo
          126	Em Anсlise a Solicitaчуo de Encerramento de Projeto Descontinuado
          140	Em Anсlise da Solicitaчуo de Reestruturaчуo
          225	Pactuaчуo do Comitъ Nacional
          240	Em Repactuaчуo
          300	Em Classificaчуo
          360	Em Anсlise o Ajuste e a Reclassificaчуo
          420	Em Orчamento
          430	Em Orчamento Complementar
          450	Orчamento em Liberaчуo por Encerramento
          480	Orчamento Ajustado em Anсlise
          530	Orчamento Ajustado em Liberaчуo pelo Financeiro
          10	Em Ajuste
          60	Em Anсlise de Consistъncia da Reestruturaчуo
          100	Em Anсlise a Solicitaчуo de Encerramento de Projeto Concluэdo
          120	Em Anсlise a Solicitaчуo de Encerramento de Projeto nуo Estruturado
          230	Em Reestruturaчуo
          260	Em Execuчуo
          440	Orчamento em Ajuste
          540	Orчamento Aguardando Aprovaчуo PPA
         * 
         */
        $sql .= " and grc_ps.codigo in ('20', '110', '125', '126', '140', '225', '240', '300', '360', '420', '430', '450', '480', '530', '10', '60', '100', '120', '230', '260', '440', '540')";
        break;
}

if ($sqlOrderby == '') {
    $sqlOrderby = "descricao asc";
}
