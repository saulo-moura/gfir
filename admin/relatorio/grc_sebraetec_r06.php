<?php
Require_Once('relatorio/lupe_generico.php');
Require_Once('style.php');

$primeiro_carregamento = count($_POST);
$titulo_relatorio = "Perfil Produto"; // Relatório 6
$largura_relatorio = "100%";
$pesquisa = '';
$vetOrdemAgrupamento = Array();

$resultadoNivel = Array(
    'tot' => 0,
    'tot_media' => 0,
    'qtd' => 0,
);

$resultadoTotal = Array(
    'tot' => 0,
    'tot_media' => 0,
    'qtd' => 0,
);

//
// Valor Default Agrupamento
//
if ($primeiro_carregamento == 0) {
    $_POST['sql_groupby'] = Array('ponto_atendimento');
}

//
//Colunas Especificação Grid
//
$vetRelatorio = Array();
$vet = Array();
$vet['TabelaPrinc'] = "grc_evento";
$vet['AliasPric'] = "grc_e";
$vet['Entidade'] = "Evento";
$vet['Entidade_p'] = "Eventos";
$vetRelatorio['ARPR'] = $vet; // armazena o Arquivo Principal
$vet = Array();

// Novas colunas
if (!in_array("produto", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[1]['campo'] = "produto";
    $vetd[1]['descricao'] = "Produto";
    $vetd[1]['cor'] = "";
    $vetd[1]['tamanho'] = "";
    $vet[] = $vetd;
}

if (!in_array("quantidade", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[1]['campo'] = "quantidade";
    $vetd[1]['descricao'] = "Quantidade de Eventos";
    $vetd[1]['cor'] = "";
    $vetd[1]['tamanho'] = "";
    $vetd[1]['styleC'] = " text-align:right; padding-right:10px; ";
    $vet[] = $vetd;
}

if (!in_array("valor_servico", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[1]['campo'] = "valor_servico";
    $vetd[1]['descricao'] = "Custo Total dos Eventos Previsto (R$)";
    $vetd[1]['cor'] = "";
    $vetd[1]['tamanho'] = "";
    $vetd[1]['styleC'] = " text-align:right; padding-right:10px; ";
    $vet[] = $vetd;
}

if (!in_array("media", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[1]['campo'] = "media";
    $vetd[1]['descricao'] = "Custo Médio do Evento Previsto (R$)";
    $vetd[1]['cor'] = "";
    $vetd[1]['tamanho'] = "";
    $vetd[1]['styleC'] = " text-align:right; padding-right:10px; ";
    $vet[] = $vetd;
}

//if (!in_array("qtd_previsto", $_POST['sql_groupby'])) {
//    $vetd = Array();
//    $vetd[1]['campo'] = "qtd_previsto";
//    $vetd[1]['descricao'] = "Previsão<br/> Quantidade";
//    $vetd[1]['cor'] = "";
//    $vetd[1]['tamanho'] = "";
//    $vet[] = $vetd;
//}

if (!in_array("prazo_medio_previsto", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[1]['campo'] = "prazo_medio_previsto";
    $vetd[1]['descricao'] = "Prazo Médio <br/> Previsto (dias)";
    $vetd[1]['cor'] = "";
    $vetd[1]['tamanho'] = "";
    $vetd[1]['styleC'] = " text-align:right; padding-right:10px; ";
    $vet[] = $vetd;
}

if (!in_array("qtd_evt_real", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[1]['campo'] = "qtd_evt_real";
    $vetd[1]['descricao'] = "Quantidade de Eventos <br/> Realizados";
    $vetd[1]['cor'] = "";
    $vetd[1]['tamanho'] = "";
    $vetd[1]['styleC'] = " text-align:right; padding-right:10px; ";
    $vet[] = $vetd;
}

if (!in_array("prazo_medio_real", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[1]['campo'] = "prazo_medio_real";
    $vetd[1]['descricao'] = "Prazo Médio <br/> Realizado (dias)";
    $vetd[1]['cor'] = "";
    $vetd[1]['tamanho'] = "";
    $vetd[1]['styleC'] = " text-align:right; padding-right:10px; ";
    $vet[] = $vetd;
}

if (!in_array("qtd_aditamento", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[1]['campo'] = "qtd_aditamento";
    $vetd[1]['descricao'] = "Quantidade de Eventos Aditados";
    $vetd[1]['cor'] = "";
    $vetd[1]['tamanho'] = "";
    $vetd[1]['styleC'] = " text-align:right; padding-right:10px; ";
    $vet[] = $vetd;
}

if (!in_array("prazo_medio_aditamento", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[1]['campo'] = "prazo_medio_aditamento";
    $vetd[1]['descricao'] = "Prazo Médio de Aditamento (dias)";
    $vetd[1]['cor'] = "";
    $vetd[1]['tamanho'] = "";
    $vetd[1]['styleC'] = " text-align:right; padding-right:10px; ";
    $vet[] = $vetd;
}

$vetRelatorio['CABE'] = $vet; // armazena o Arquivo Principal
$qtd_col = count($vetRelatorio['CABE']);

//
// Dados do relatório
//
$vet = Array();
$vet['titulo'] = $titulo_relatorio;
$vet['largura'] = $largura_relatorio;
$vetRelatorio['RELA'] = $vet; // armazena o Arquivo Principal
//
// Barra de tarefas 
//
if ($_GET['print'] != 's') {
    echo "<div class='barra_ferramentas'>";
    echo "<table border='0' cellspacing='0' cellpadding='0' width='100%' >";
    echo "<tr>";

    echo "<td width='20' style='border:0; padding-left:5px;'>";
    $voltar = 'conteudo.php?prefixo=inc&menu=grc_sebraetec_relatorios&origem_tela=painel&cod_volta=plu_seguranca';
    echo "<a HREF='{$voltar}'><img class='bartar' border='0' align=middle src='imagens/bt_voltar.png'></a>";
    echo "</td>";

    echo "<td width='20' style='border:0; padding-left:5px;'>";
    $str = $menu . "&titulo_rel=" . $titulo_relatorio;
    $nome_relatorio = 'RELATÓRIO PRODUTOS MAIS VENDIDOS';
    echo "<a HREF='#' onclick=\"return imprimir_sebraetec_pdf('$str', '$nome_relatorio');\"><img border='0' class='bartar' width='32' height='32' align=middle src='relatorio/bt_pdf_32.png'></a>";
    echo "</td>";

    echo "<td width='20' style='border:0; padding-left:5px;'>";
    echo "<a id='relatorio_excel' HREF='#' ><img border='0' class='bartar' width='32' height='32' align=middle src='relatorio/bt_xls_32.png'></a>";
    echo "</td>";

    echo "<td>&nbsp;</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}

//
// Monta o vetor de filtro tela
//
$sql = "select idt,  descricao";
$sql .= " from grc_sebraetec_setor";
$sql .= " order by descricao ";
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_setor';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Setor/Território do Projeto';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_setor'] = $Filtro;

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from ' . db_pir . 'sca_organizacao_secao';
$sql .= " where posto_atendimento <> 'S' ";
$sql .= ' order by classificacao';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_unidade';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Unidade Regional';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_unidade'] = $Filtro;

$sql = "select idt,  descricao from " . db_pir . "sca_organizacao_secao ";
$sql .= ' where SUBSTRING(classificacao, 1, 5) = (';
$sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
$sql .= ' from ' . db_pir . 'sca_organizacao_secao';
$sql .= ' where idt = ' . null($vetFiltro['idt_unidade']['valor']);
$sql .= ' )';
$sql .= ' and idt <> ' . null($vetFiltro['idt_unidade']['valor']);
$sql .= ' order by classificacao ';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_ponto_atendimento_tela';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Ponto de Atendimento';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_ponto_atendimento_tela'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'ListarCmb';
$Filtro['arq'] = 'grc_projeto';
$Filtro['id'] = 'f_idt_projeto';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Projeto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_projeto'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'ListarCmb';
$Filtro['arq'] = 'grc_projeto_acao';
$Filtro['id'] = 'f_idt_acao';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Ação';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_acao'] = $Filtro;

$sql = '';
$sql .= ' select distinct id_usuario, nome_completo';
$sql .= ' from plu_usuario';
$sql .= " where ativo = 'S'";
if ($vetFiltro['idt_unidade']['valor'] != "" && $vetFiltro['idt_unidade']['valor'] != "0" && $vetFiltro['idt_unidade']['valor'] != "-1") {
    $sql .= ' and idt_unidade_lotacao in (';
    $sql .= " select idt from " . db_pir . "sca_organizacao_secao ";
    $sql .= ' where SUBSTRING(classificacao, 1, 5) = (';
    $sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
    $sql .= ' where idt = ' . null($vetFiltro['idt_unidade']['valor']);
    $sql .= ' )';
    $sql .= ' )';
} else {
    $sql .= ' and idt_unidade_lotacao is not null';
}
$sql .= ' order by nome_completo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_gestor_projeto';
$Filtro['id_select'] = 'id_usuario';
$Filtro['nome'] = 'Gestor do Projeto';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_gestor_projeto'] = $Filtro;

$sql = '';
$sql .= ' select distinct id_usuario, nome_completo';
$sql .= ' from plu_usuario';
$sql .= " where ativo = 'S'";
if ($vetFiltro['idt_unidade']['valor'] != "" && $vetFiltro['idt_unidade']['valor'] != "0" && $vetFiltro['idt_unidade']['valor'] != "-1") {
    $sql .= ' and idt_unidade_lotacao in (';
    $sql .= " select idt from " . db_pir . "sca_organizacao_secao ";
    $sql .= ' where SUBSTRING(classificacao, 1, 5) = (';
    $sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
    $sql .= ' where idt = ' . null($vetFiltro['idt_unidade']['valor']);
    $sql .= ' )';
    $sql .= ' )';
} else {
    $sql .= ' and idt_unidade_lotacao is not null';
}

$sql .= ' order by nome_completo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_responsavel_evento';
$Filtro['id_select'] = 'id_usuario';
$Filtro['nome'] = 'Responsável Pelo Evento';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_responsavel_evento'] = $Filtro;

$sql = '';
$sql .= ' select codcid, desccid';
$sql .= ' from ' . db_pir_siac . 'cidade';
$sql .= " where codest = 5";
$sql .= ' order by desccid';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_cidade';
$Filtro['id_select'] = 'codcid';
$Filtro['nome'] = 'Cidade';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_cidade'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Intervalo';
$Filtro['id'] = 'ordem';
$Filtro['nome'] = 'Período do Início do Evento';
$Filtro['js'] = 'data';
$Filtro['vlPadrao_ini'] = Date('d/m/Y');
$Filtro['vlPadrao_fim'] = Date('d/m/Y');
$Filtro['valor_ini'] = trata_id($Filtro, '_ini');
$Filtro['valor_fim'] = trata_id($Filtro, '_fim');
$vetFiltro['ordem'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'f_chave_sgc';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Chave SGC';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_chave_sgc'] = $Filtro;

$sql = '';
$sql .= " select idt, descricao";
$sql .= " from grc_evento_situacao";
$sql .= " where ativo = 'S'";
$sql .= " and idt in (14, 16, 19, 20)";
$sql .= " order by codigo";
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_evento_situacao';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Status do Evento';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_evento_situacao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = Array(
    'T' => '-- Todos --',
    'N' => 'Não SGTEC',
    'S' => 'SGTEC',
);
$Filtro['id'] = 'programa_sgtec';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Tipo do Evento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['programa_sgtec'] = $Filtro;

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_atendimento_instrumento';
$sql .= " where idt in (2, 40, 47, 46, 49, 50, 45, 41)";
$sql .= ' order by descricao';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_instrumento';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Instrumento';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_instrumento'] = $Filtro;

$sql = "";
$sql .= " SELECT idt, descricao";
$sql .= " FROM grc_produto_modalidade ";
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_modalidade';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Modalidade';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_modalidade'] = $Filtro;

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from ' . db_pir_gec . 'gec_area_conhecimento ';
$sql .= " where idt_programa = 4 ";
$sql .= " and idt_subarea IS NULL";
$sql .= ' order by descricao';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_area_tematica';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Área Temática';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_area_tematica'] = $Filtro;

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from ' . db_pir_gec . 'gec_area_conhecimento ';
$sql .= " where idt_programa = 4 ";
$sql .= " and idt_area  = " . null($vetFiltro['idt_area_tematica']['valor']);
$sql .= " and idt_subarea IS NOT NULL";
$sql .= ' order by descricao';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_sub_area';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Sub-Área';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_sub_area'] = $Filtro;

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_produto';
$sql .= " where ativo = 'S' ";
$sql .= " and idt_programa = 4 ";
$sql .= ' order by descricao';
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'f_idt_produto';
$Filtro['id_select'] = 'idt';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['nome'] = 'Produto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_produto'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'f_texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto Aberto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_texto'] = $Filtro;

$sql = '';
$sql .= ' select codigo, descricao';
$sql .= ' from ' . db_pir_gec . 'gec_entidade';
$sql .= " where tipo_entidade = 'O'";
$sql .= " and reg_situacao = 'A'";
$sql .= " and credenciado = 'S'";
$sql .= " and credenciado_sgtec = 'S'";
$sql .= ' order by descricao';
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'f_idt_pst';
$Filtro['id_select'] = 'idt';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['nome'] = 'PST';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_pst'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = $vetTipoProdutoSebratec;
$Filtro['id'] = 'f_idt_tipo_produto';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['nome'] = 'Tipo Produto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_tipo_produto'] = $Filtro;

$idx = -1;
ForEach ($vetFiltro as $Filtro) {
    $idx++;
    $strPara .= $Filtro['id'] . $idx . ',';
}

// Vetor Agrupamento
$vetGroupby = Array();
//$vetGroupby['setor'] = 'Setor';
$vetGroupby['unidade_regional'] = 'Unidade Regional';
$vetGroupby['ponto_atendimento'] = 'Ponto de Atendimento';
//$vetGroupby['projeto'] = 'Projeto';
//$vetGroupby['acao'] = 'Ação';
//$vetGroupby['gestor_projeto'] = 'Gestor do Projeto';
//$vetGroupby['gestor_evento'] = 'Responsável pelo Evento';
//$vetGroupby['cidade_descricao'] = 'Cidade';
//$vetGroupby['status_operacional'] = 'Status do Evento';
//$vetGroupby['a7'] = 'Tipo de Evento';
$vetGroupby['instrumento'] = 'Instrumento';
$vetGroupby['descricao_modalidade'] = 'Modalidade';
$vetGroupby['a10'] = 'Área Tematica';
$vetGroupby['a11'] = 'SubÁrea';
//$vetGroupby['produto'] = 'Produto';
//$vetGroupby['nome_pst'] = 'PST';
$vetGroupby['media'] = 'Valor Médio do Serviço';
$vetGroupby['quantidade'] = 'Quantidade de eventos';
$vetGroupby['status_operacional'] = 'Status do Evento';

// Vetor Ordenação
$vetOrderby = Array();
$vetOrderby['produto'] = 'Produto';
$vetOrderby['quantidade'] = 'Quantidade';
$vetOrderby['valor_servico'] = 'Valor Serviço';
$vetOrderby['media'] = 'Média';
$vetOrderby['prazo_medio_previsto'] = 'Prazo Médio Previsto';
$vetOrderby['prazo_medio_real'] = 'Prazo Médio Real';
$vetOrderby['qtd_evt_real'] = 'Quantidade Real';
$vetOrderby['qtd_aditamento'] = 'Quantidade Aditamento';
$vetOrderby['prazo_medio_aditamento'] = 'Prazo Médio Aditamento';

$strPara .= 'sql_orderby,sql_orderby_extra,sql_groupby,origem_tela';

$vetTabelas = Array();
$sel_coluna = md5($prefixo . $menu);

$vetCampo = Array();
$chk_coluna = Array();
$ordenar_coluna = Array();
foreach ($vetRelatorio['CABE'] as $value) {
    foreach ($value as $valueCampo) {
        $vetCampo[$valueCampo['campo']] = CriaVetTabela($valueCampo['descricao']);
        $chk_coluna[] = $valueCampo['campo'];
        $ordenar_coluna[$valueCampo['campo']] = $valueCampo['descricao'];
    }
}

define('tmp_sel_coluna', $sel_coluna);
$_SESSION[CS]['tmp']['sel_coluna'][$sel_coluna] = $vetCampo;
$_SESSION[CS]['tmp']['ordenar_coluna'][$sel_coluna] = $ordenar_coluna;

if (count($_SESSION[CS]['tmp']['chk_coluna'][$sel_coluna]) == 0) {
    $_SESSION[CS]['tmp']['chk_coluna'][$sel_coluna] = $chk_coluna;
}

// Fim do Filtro
echo '<form name="frm" target="_self" action="conteudo.php?' . substr(getParametro($strPara), 1) . '" method="post">';

if ($_GET['print'] != 's') {
    $Focus = '';
    echo "<div id='filtro' style='width:100%; background:#FF0000;'>";
    codigo_filtro(false, true, '', '', false, true);
    echo "</div> ";

    onLoadPag($Focus);
} else {
//    codigo_filtro_fixo();
    onLoadPag();
}

echo "</form>";

if ($primeiro_carregamento == 0) {
    alert('Por favor, Selecione Uma Opção e clique em Pesquisar');
} else {
    //
    // Obter campos para relatório
    //
    
    // Tabela Principal
    $TabelaPrinc = "grc_evento";
    $AliasPric = "grc_e";
    $Entidade = "Evento";
    $Entidade_p = "Eventos";

    // Relacionadas (tratar os associados)
    $campos = "";

    //$campos .= "distinct {$AliasPric}.codigo as codigo_evento,";
    $campos .= " grc_ersit.descricao as status_operacional,";
    $campos .= " i.descricao as instrumento,";
    $campos .= " sca_ur.descricao AS unidade_regional, ";
    $campos .= " sca_ur.classificacao AS unidade_regional_classificacao, ";
    $campos .= " sca_pa.descricao AS ponto_atendimento, ";
    $campos .= " grc_e.codigo as codigo_evento, ";
    $campos .= " pr.descricao AS produto, ";
//    $campos .= " COUNT( grc_e.codigo) AS quantidade, "; // DISTINCT 
    $campos .= " SUM( coi.custo_total_real) AS valor_servico, "; // DISTINCT
//    $campos .= " ( ";
//    $campos .= "    SUM(coi.custo_total_real) / COUNT(grc_e.codigo) ";
//    $campos .= " ) AS media, ";
//    $campos .= " '' as qtd_previsto, ";
    $campos .= " SUM(agenda_prevista.dias) AS qtd_previsto, ";
//    $campos .= " AVG(agenda_prevista.dias) as prazo_medio_previsto, ";
//    $campos .= " AVG(agenda_real.dias) as prazo_medio_real, ";
    $campos .= " COUNT(agenda_real.dias) as qtd_evt_real, ";
    $campos .= " SUM(agenda_real.dias) as qtd_real, ";
    $campos .= " 0 as qtd_aditamento, ";
    $campos .= " 0 as prazo_medio_aditamento ";
//    $campos .= " proj.descricao as projeto, ";
//    $campos .= " ent_setor.descricao as setor ";
//    $campos .= " projac.descricao as acao ";
//    $campos .= "{$AliasPric}.codigo as codigo_evento, ";
//    $campos .= "sca_ur.descricao as unidade_regional, ";
//    $campos .= "sca_pa.descricao as ponto_atendimento, ";
//    $campos .= "pr.descricao as produto, ";
//    $campos .= "i.descricao as servico_contratado, ";
//    $campos .= "coi.custo_total_real as valor_servico, ";
//
//    $campos .= '    (';
//    $campos .= "    select avg(ole.pontuacao)";
//    $campos .= '    from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem cco';
//    $campos .= '    inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista ol on ol.idt_gec_contratacao_credenciado_ordem = cco.idt';
//    $campos .= '    inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista_endidade ole on ole.idt_gec_contratacao_credenciado_ordem_lista = ol.idt';
//    $campos .= "    where ol.ativo = 'S' and ole.habilitado = 'S' ";
//    $campos .= "    and cco.idt_evento = {$AliasPric}.idt";
//    $campos .= '    ) as media,';
//    $campos .= "rm.valor_real as media, ";
//    $campos .= "plu_usuges.nome_completo as gestor_evento ";
//    $campos = "";
//    $campos .= " {$AliasPric}.*,";
//    $campos .= " i.descricao as servico_contratado,";
//    $campos .= " grc_ersit.descricao as grc_ersit_descricao,";
//    $campos .= " grc_ersit_ant.descricao as grc_ersit_ant_descricao,";
//    $campos .= '    (';
//    $campos .= "    select concat_ws('<br />', u.nome_completo, date_format(ap.dt_update, '%d/%m/%Y %H:%i:%s')) as aprovador";
//    $campos .= '    from grc_atendimento_pendencia ap';
//    $campos .= '    inner join plu_usuario u on u.id_usuario = ap.idt_usuario_update';
//    $campos .= '    where ap.idt_evento_situacao_para = 14';
//    $campos .= "    and ap.idt_evento = {$AliasPric}.idt";
//    $campos .= '    order by ap.dt_update desc limit 1';
//    $campos .= '    ) as aprovador,';
//    $campos .= " pr.descricao as produto,";
//    $campos .= " {$AliasPric}.codigo as evento,";
//    $campos .= " grc_ersit.descricao as status_operacional,";
//    $campos .= " afp.situacao_reg as status_financeiro,";
//    $campos .= " proj.descricao as projeto,";
//    $campos .= " sca_ur.descricao as unidade_regional,";
//    $campos .= " sca_pa.descricao as ponto_atendimento,";
//    $campos .= " plu_usuges.nome_completo as gestor_evento,";
//    $campos .= " plu_usugespro.nome_completo as gestor_projeto,";
//    $campos .= " gec_cid.desccid as cidade_descricao,";
//    $campos .= " rm.mesano     as mes_ano,";
//    $campos .= " rm.valor_real as valor_servico,";
//    $campos .= " rm.valor_real as media,";
//    $campos .= " ord.codigo as ordem_contratacao, ";
//    $campos .= " ord.chave_sgc,";
//    $campos .= ' afp.situacao_reg, ';
//    $campos .= ' afp.gfi_situacao,';
//    $campos .= ' rm.mesano, ';
//    $campos .= ' rm.valor_prev, ';
//    $campos .= ' rm.valor_real, ';
//    $campos .= ' rm.rm_idmov,';
//    $campos .= ' afp.nomefantasia as nome_pst,';
//    $campos .= ' afp.cnpjcpf as cnpjcpf,';
//    $campos .= ' pr_mod.descricao as descricao_modalidade,';
//    $campos .= ' ord.rm_consolidado';
//    Where

    $strWhere = "";
    $strWhere .= "  {$AliasPric}.temporario <> 'S'";
    $strWhere .= " and pr.idt_programa = 4";
    $strWhere .= " and {$AliasPric}.idt_evento_situacao in (14, 16, 19, 20)";
    $strWhere .= " and coi.codigo = '71001'";
    $strWhere .= " and ord.rm_consolidado = 'R'";

    // Setor
    if ($vetFiltro['f_idt_setor']['valor'] != "" && $vetFiltro['f_idt_setor']['valor'] != "0" && $vetFiltro['f_idt_setor']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= " select idt, descricao";
        $sql_filtro .= " from grc_sebraetec_setor";
        $sql_filtro .= " where idt = " . null($vetFiltro['f_idt_setor']['valor']);
        $sql_filtro .= " order by descricao ";
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Setor/Território do Projeto</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and proj.idt_setor = ' . null($vetFiltro['f_idt_setor']['valor']);
    }

    // Unidade Regional
    if ($vetFiltro['f_idt_unidade']['valor'] != "" && $vetFiltro['f_idt_unidade']['valor'] != "0" && $vetFiltro['f_idt_unidade']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= ' select descricao';
        $sql_filtro .= ' from ' . db_pir . 'sca_organizacao_secao';
        $sql_filtro .= " where posto_atendimento <> 'S' and idt = " . null($vetFiltro['f_idt_unidade']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Unidade Regional</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_unidade = ' . null($vetFiltro['f_idt_unidade']['valor']);
    }

    // Ponto de Atendimento
    if ($vetFiltro['f_idt_ponto_atendimento_tela']['valor'] != "" && $vetFiltro['f_idt_ponto_atendimento_tela']['valor'] != "0" && $vetFiltro['f_idt_ponto_atendimento_tela']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= "select descricao ";
        $sql_filtro .= " from " . db_pir . "sca_organizacao_secao ";
        $sql_filtro .= ' where SUBSTRING(classificacao, 1, 5) = (';
        $sql_filtro .= ' select SUBSTRING(classificacao, 1, 5) as cod';
        $sql_filtro .= ' from ' . db_pir . 'sca_organizacao_secao';
        $sql_filtro .= ' where idt = ' . null($vetFiltro['idt_unidade']['valor']);
        $sql_filtro .= ' )';
        $sql_filtro .= ' and idt = ' . null($vetFiltro['f_idt_ponto_atendimento_tela']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Ponto de Atendimento</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_ponto_atendimento_tela = ' . null($vetFiltro['f_idt_ponto_atendimento_tela']['valor']);
    }

    // Projeto
    if ($vetFiltro['f_idt_projeto']['valor'] != "" && $vetFiltro['f_idt_projeto']['valor'] != "0" && $vetFiltro['f_idt_projeto']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= " Select grc_pro.descricao";
        $sql_filtro .= " from grc_projeto as grc_pro ";
        $sql_filtro .= " left join grc_projeto_situacao grc_ps on grc_ps.idt = grc_pro.idt_projeto_situacao ";
        $sql_filtro .= ' where ativo_siacweb  = ' . aspa('S');
        $sql_filtro .= ' and existe_siacweb = ' . aspa('S');
        $sql_filtro .= ' and grc_pro.idt = ' . null($vetFiltro['f_idt_projeto']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Projeto</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_projeto = ' . null($vetFiltro['f_idt_projeto']['valor']);
    }

    // Ação
    if ($vetFiltro['f_idt_acao']['valor'] != "" && $vetFiltro['f_idt_acao']['valor'] != "0" && $vetFiltro['f_idt_acao']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= " Select grc_pro.descricao";
        $sql_filtro .= " from grc_projeto_acao as grc_pro ";
        $sql_filtro .= " where ativo_siacweb  = 'S' ";
        $sql_filtro .= " and existe_siacweb = 'S' ";
        $sql_filtro .= ' and grc_pro.idt = ' . null($vetFiltro['f_idt_acao']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Ação</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_acao = ' . null($vetFiltro['f_idt_acao']['valor']);
    }

    // Gestor Projeto
    if ($vetFiltro['f_idt_gestor_projeto']['valor'] != "" && $vetFiltro['f_idt_gestor_projeto']['valor'] != "0" && $vetFiltro['f_idt_gestor_projeto']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= ' select nome_completo';
        $sql_filtro .= ' from plu_usuario';
        $sql_filtro .= " where ativo = 'S'";
        $sql_filtro .= ' and id_usuario  = ' . null($vetFiltro['f_idt_gestor_projeto']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Gestor Projeto</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_gestor_projeto = ' . null($vetFiltro['f_idt_gestor_projeto']['valor']);
    }

    // Responsável pelo Evento
    if ($vetFiltro['f_idt_responsavel_evento']['valor'] != "" && $vetFiltro['f_idt_responsavel_evento']['valor'] != "0" && $vetFiltro['f_idt_responsavel_evento']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= ' select nome_completo';
        $sql_filtro .= ' from plu_usuario';
        $sql_filtro .= " where ativo = 'S'";
        $sql_filtro .= ' and id_usuario = ' . null($vetFiltro['f_idt_responsavel_evento']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Responsável pelo Evento</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_gestor_evento = ' . null($vetFiltro['f_idt_responsavel_evento']['valor']);
    }

    // Cidade
    if ($vetFiltro['f_idt_cidade']['valor'] != "" && $vetFiltro['f_idt_cidade']['valor'] != "0" && $vetFiltro['f_idt_cidade']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= ' select desccid';
        $sql_filtro .= ' from ' . db_pir_siac . 'cidade';
        $sql_filtro .= " where codest = 5";
        $sql_filtro .= ' and codcid = ' . null($vetFiltro['f_idt_cidade']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Cidade</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_cidade = ' . null($vetFiltro['f_idt_cidade']['valor']);
    }

    // Intervalo
    if ($vetFiltro['ordem']['valor_ini'] != '' && $vetFiltro['ordem']['valor_fim'] != '') {
        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Período do Início do Evento</strong></td><td style="width:80%; text-align: left">' . $vetFiltro['ordem']['valor_ini'] . ' até ' . $vetFiltro['ordem']['valor_fim'] . ' </td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.dt_previsao_inicial between ' . aspa(trata_data($vetFiltro['ordem']['valor_ini'])) . ' and ' . aspa(trata_data($vetFiltro['ordem']['valor_fim']) . ' 23:59:59');
    } else if ($vetFiltro['ordem']['valor_fim'] == '') {
        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Período do Início do Evento (Inicio)</strong></td><td style="width:80%; text-align: left"> ' . $vetFiltro['ordem']['valor_ini'] . ' </td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.dt_previsao_inicial >= ' . aspa(trata_data($vetFiltro['ordem']['valor_ini']));
    } else if ($vetFiltro['ordem']['valor_ini'] == '') {
        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Período do Início do Evento (Final)</strong></td><td style="width:80%; text-align: left"> ' . $vetFiltro['ordem']['valor_fim'] . ' </td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.dt_previsao_inicial <= ' . aspa(trata_data($vetFiltro['ordem']['valor_fim']) . ' 23:59:59');
    }

    // Chave SGC
    if ($vetFiltro['f_chave_sgc']['valor'] != "") {
        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Chave SGC </strong></td><td style="width:80%; text-align: left">' . $vetFiltro['f_chave_sgc']['valor'] . ' </td></tr>';
        $strWhere .= ' and lower(ord.chave_sgc) like lower(' . aspa($vetFiltro['f_chave_sgc']['valor'], '%', '%') . ')';
    }

    // Status do Evento
    if ($vetFiltro['f_idt_evento_situacao']['valor'] != "" && $vetFiltro['f_idt_evento_situacao']['valor'] != "0" && $vetFiltro['f_idt_evento_situacao']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= ' select descricao';
        $sql_filtro .= ' from grc_evento_situacao';
        $sql_filtro .= " where ativo = 'S'";
        $sql_filtro .= ' and idt = ' . null($vetFiltro['f_idt_evento_situacao']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Status do Evento</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_evento_situacao = ' . null($vetFiltro['f_idt_evento_situacao']['valor']);
    }

    // Tipo do Evento
    if ($vetFiltro['programa_sgtec']['valor'] == "N") {
        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Tipo do Evento</strong></td><td style="width:80%; text-align: left"> Não SGTEC </td></tr>';
        $sql .= " and (gec_pr.tipo_ordem is null or gec_pr.tipo_ordem <> 'SG')";
    } else if ($vetFiltro['programa_sgtec']['valor'] == "S") {
        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Tipo do Evento</strong></td><td style="width:80%; text-align: left"> SGTEC </td></tr>';
        $sql .= " and gec_pr.tipo_ordem = 'SG'";
    }

    // Instrumento  
    if ($vetFiltro['f_idt_instrumento']['valor'] != "" && $vetFiltro['f_idt_instrumento']['valor'] != "0" && $vetFiltro['f_idt_instrumento']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= ' select descricao';
        $sql_filtro .= ' from grc_atendimento_instrumento';
        $sql_filtro .= " where idt in (2, 40, 47, 46, 49, 50, 45, 41)";
        $sql_filtro .= ' and idt = ' . null($vetFiltro['f_idt_instrumento']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Instrumento</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_instrumento = ' . null($vetFiltro['f_idt_instrumento']['valor']);
    }

    // Modalidade
    if ($vetFiltro['f_idt_modalidade']['valor'] != "" && $vetFiltro['f_idt_modalidade']['valor'] != "0" && $vetFiltro['f_idt_modalidade']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= " SELECT descricao";
        $sql_filtro .= " FROM grc_produto_modalidade ";
        $sql_filtro .= " where idt = " . null($vetFiltro['f_idt_modalidade']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Modalidade</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and pr.idt_modalidade = ' . null($vetFiltro['f_idt_modalidade']['valor']);
    }

    // Área Temática
    if ($vetFiltro['f_idt_area_tematica']['valor'] != "" && $vetFiltro['f_idt_area_tematica']['valor'] != "0" && $vetFiltro['f_idt_area_tematica']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= ' select descricao';
        $sql_filtro .= ' from ' . db_pir_gec . 'gec_area_conhecimento ';
        $sql_filtro .= " where idt_programa = 4 ";
        $sql_filtro .= " and idt_subarea IS NULL";
        $sql_filtro .= "  and idt = " . null($vetFiltro['f_idt_area_tematica']['valor']);
        $sql_filtro .= " order by descricao";
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Área Temática</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';

        $strWhere .= ' and exists( ';
        $strWhere .= ' select pac.idt';
        $strWhere .= ' from grc_produto_area_conhecimento pac';
        $strWhere .= ' inner join db_pir_gec.gec_area_conhecimento ac on ac.idt = pac.idt_area';
        $strWhere .= ' where pac.idt_produto = pr.idt';
        $strWhere .= ' and ac.idt_area = ' . null($vetFiltro['f_idt_area_tematica']['valor']);
        $strWhere .= ') ';
    }

    // Sub-Área
    if ($vetFiltro['f_idt_sub_area']['valor'] != "" && $vetFiltro['f_idt_sub_area']['valor'] != "0" && $vetFiltro['f_idt_sub_area']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= ' select descricao';
        $sql_filtro .= ' from ' . db_pir_gec . 'gec_area_conhecimento ';
        $sql_filtro .= " where idt_programa = 4 ";
        $sql_filtro .= " and idt_area  = " . null($vetFiltro['f_idt_sub_area']['valor']);
        $sql_filtro .= " and idt_subarea IS NOT NULL";
        $sql_filtro .= ' order by descricao';

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Sub-Área</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';

        $strWhere .= ' and exists( ';
        $strWhere .= ' select pac.idt';
        $strWhere .= ' from grc_produto_area_conhecimento pac';
        $strWhere .= ' inner join db_pir_gec.gec_area_conhecimento ac on ac.idt = pac.idt_area';
        $strWhere .= ' where pac.idt_produto = pr.idt';
        $strWhere .= ' and ac.idt_subarea = ' . null($vetFiltro['f_idt_sub_area']['valor']);
        $strWhere .= ') ';
    }

    // Produto
    if ($vetFiltro['f_idt_produto']['valor'] != "" && $vetFiltro['f_idt_produto']['valor'] != "0" && $vetFiltro['f_idt_produto']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= ' select descricao';
        $sql_filtro .= ' from grc_produto';
        $sql_filtro .= ' where idt = ' . null($vetFiltro['f_idt_produto']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Produto</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_produto= ' . null($vetFiltro['f_idt_produto']['valor']);
    }

    // Texto Aberto
    if ($vetFiltro['f_texto']['valor'] != "") {
        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Texto Aberto </strong></td><td style="width:80%; text-align: left">' . $vetFiltro['f_texto']['valor'] . ' </td></tr>';

        $strWhere .= ' and ';
        $strWhere .= ' ( ';
        // Evento
        $strWhere .= '    lower(' . $AliasPric . '.codigo)    like lower(' . aspa($vetFiltro['f_texto']['valor'], '%', '%') . ')';
        $strWhere .= ' or lower(' . $AliasPric . '.descricao) like lower(' . aspa($vetFiltro['f_texto']['valor'], '%', '%') . ')';
        // Pronto Atendimento
        $strWhere .= ' or lower(sca_pa.descricao) like lower(' . aspa($vetFiltro['f_texto']['valor'], '%', '%') . ')';
        // Unidade Regional
        $strWhere .= ' or lower(sca_ur.descricao) like lower(' . aspa($vetFiltro['f_texto']['valor'], '%', '%') . ')';
        // Produto
        $strWhere .= ' or lower(pr.descricao) like lower(' . aspa($vetFiltro['f_texto']['valor'], '%', '%') . ')';
        // Serviço
        $strWhere .= ' or lower(i.descricao) like lower(' . aspa($vetFiltro['f_texto']['valor'], '%', '%') . ')';
        // Responsavel Evento
        $strWhere .= ' or lower(plu_usuges.nome_completo) like lower(' . aspa($vetFiltro['f_texto']['valor'], '%', '%') . ')';
        $strWhere .= ' ) ';
    }

    // Prestadora de Serviço Tecnológico (PST)
    if ($vetFiltro['f_idt_pst']['valor'] != "" && $vetFiltro['f_idt_pst']['valor'] != "0" && $vetFiltro['f_idt_pst']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= ' select descricao';
        $sql_filtro .= ' from ' . db_pir_gec . 'gec_entidade';
        $sql_filtro .= " where tipo_entidade = 'O'";
        $sql_filtro .= " and reg_situacao = 'A'";
        $sql_filtro .= " and credenciado = 'S'";
        $sql_filtro .= " and credenciado_sgtec = 'S'";
        $sql_filtro .= " and codigo = " . null($vetFiltro['f_idt_pst']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style = "width:20%; text-align: left"><strong>Prestadora de Serviço Tecnológico (PST)</strong></td><td style = "width:80%; text-align: left">' . $rs_filtro->data[0][0] . ' < / td></tr>';

        $strWhere .= ' AND ord.idt in (';
        $strWhere .= ' SELECT rm.idt_gec_contratacao_credenciado_ordem';
        $strWhere .= " FROM " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm rm ";
        $strWhere .= " LEFT OUTER JOIN " . db_pir_pfo . "pfo_af_processo afp on afp.idmov = rm.rm_idmov ";
        $strWhere .= " WHERE rm.rm_cancelado = 'N'";
        $strWhere .= ' AMD afp.cnpjcpf = ' . null($vetFiltro['f_idt_pst']['valor']);
        $strWhere .= ' )';
    }

    // Tipo Produto
    if ($vetFiltro['f_idt_tipo_produto']['valor'] != "" && $vetFiltro['f_idt_tipo_produto']['valor'] != "0" && $vetFiltro['f_idt_tipo_produto']['valor'] != "-1") {
        $pesquisa .= '<tr><td style = "width:20%; text-align: left"><strong>Tipo Produto</strong></td><td style = "width:80%; text-align: left">' . $vetTipoProdutoSebratec[$vetFiltro['f_idt_tipo_produto']['valor']] . ' </td></tr>';
        $strWhere .= ' and pr.vl_determinado = ' . aspa($vetFiltro['f_idt_tipo_produto']['valor']);
    }

    $vetControleGrupo = Array();
    $sqlGroupby = Array();
    $sqlOrderby = Array();

    // Ordernação (Agrupamento + Classificação)
    if (is_array($_POST['sql_groupby']) || is_array($_POST['sql_orderby'])) {
        if (count($_POST['sql_groupby']) > 0) {

            foreach ($_POST['sql_groupby'] as $value) {
                if ($value != '' && !in_array($value, $sqlGroupby)) {
                    $sqlGroupby[] = $value;

                    $vetControleGrupo[] = Array(
                        'campo' => $value,
                        'nome' => $vetGroupby[$value],
                        'tot' => 0,
                        'valor_ant' => null,
                    );
                }
            }
        }

        if (count($_POST['sql_orderby']) > 0) {
            foreach ($_POST['sql_orderby'] as $idx => $value) {
                if ($value != '') {
                    $campo_orderby = trim($value . ' ' . $_POST['sql_orderby_extra'][$idx]);

                    if ($campo_orderby != '' && !in_array($campo_orderby, $sqlGroupby)) {
                        $sqlOrderby[] = $campo_orderby;
                    }
                }
            }
        }

        $sqlOrderby = array_merge($sqlGroupby, $sqlOrderby);
        $sqlOrderby[] = 'produto';
        $sqlOrderby = implode(', ', $sqlOrderby);

        // Torca valores dos campos da unidade regional para fazer ordenamento correto
        $sqlOrderby = str_replace('unidade_regional', 'unidade_regional_classificacao', $sqlOrderby);
    }

//    p($vetControleGrupo);

    $sql = " SELECT ";
    $sql .= $campos;

    $sql .= " FROM ";
    $sql .= " 	grc_produto pr ";
    $sql .= " INNER JOIN grc_evento grc_e ON grc_e.idt_produto = pr.idt ";
    $sql .= " INNER JOIN grc_evento_situacao grc_ersit ON grc_ersit.idt = grc_e.idt_evento_situacao ";
    $sql .= " INNER JOIN grc_atendimento_instrumento i ON i.idt = pr.idt_instrumento ";
    $sql .= " LEFT OUTER JOIN " . db_pir . "sca_organizacao_secao sca_pa ON sca_pa.idt = grc_e.idt_ponto_atendimento_tela ";
    $sql .= " LEFT OUTER JOIN " . db_pir_gec . "gec_contratacao_credenciado_ordem ord ON ord.idt_evento = grc_e.idt and ord.ativo = 'S' ";
    $sql .= " LEFT OUTER JOIN " . db_pir_gec . "gec_contratacao_credenciado_ordem_insumo coi ON coi.idt_gec_contratacao_credenciado_ordem = ord.idt ";
    $sql .= " LEFT OUTER JOIN " . db_pir . "sca_organizacao_secao sca_ur ON sca_ur.idt = grc_e.idt_unidade ";
//    $sql .= " LEFT OUTER JOIN grc_evento_situacao grc_ersit_ant ON grc_ersit_ant.idt = grc_e.idt_evento_situacao_ant ";
    $sql .= " LEFT OUTER JOIN grc_produto_modalidade pr_mod ON pr.idt_modalidade = pr_mod.idt ";
    $sql .= " LEFT OUTER JOIN grc_projeto proj ON proj.idt = grc_e.idt_projeto ";
//    $sql .= " LEFT OUTER JOIN grc_projeto_acao projac ON projac.idt = grc_e.idt_acao ";
    $sql .= " LEFT OUTER JOIN grc_sebraetec_setor ent_setor ON ent_setor.idt = proj.idt_setor ";
//    $sql .= " LEFT OUTER JOIN plu_usuario plu_usugespro ON plu_usugespro.id_usuario = grc_e.idt_gestor_projeto ";
    $sql .= " LEFT OUTER JOIN " . db_pir_gec . "gec_programa gec_pr ON gec_pr.idt = grc_e.idt_programa ";
    $sql .= " LEFT OUTER JOIN ( ";
    $sql .= " 	SELECT ";
    $sql .= " 		idt_evento, ";
    $sql .= " 		DATEDIFF( ";
    $sql .= " 			MAX(data_final), ";
    $sql .= " 			MIN(data_inicial) ";
    $sql .= " 		) + 1 AS dias ";
    $sql .= " 	FROM ";
    $sql .= " 		grc_evento_agenda ";
    $sql .= " 	GROUP BY ";
    $sql .= " 		idt_evento ";
    $sql .= " ) as agenda_prevista on agenda_prevista.idt_evento = grc_e.idt ";
    $sql .= " LEFT OUTER JOIN ( ";
    $sql .= " 	SELECT ";
    $sql .= " 		grc_evento_agenda.idt_evento, ";
    $sql .= " 		DATEDIFF( ";
    $sql .= " 			MAX(grc_evento_agenda.data_final_real), ";
    $sql .= " 			MIN(grc_evento_agenda.data_inicial_real) ";
    $sql .= " 		) + 1 AS dias ";
    $sql .= " 	FROM ";
    $sql .= " 		grc_evento_agenda ";
    $sql .= " 	INNER JOIN grc_evento_atividade grc_a_atv ON grc_a_atv.idt = grc_evento_agenda.idt_evento_atividade ";
    $sql .= " 	INNER JOIN grc_evento grc_e_ativ ON grc_e_ativ.idt = grc_evento_agenda.idt_evento ";
    $sql .= " 	WHERE grc_e_ativ.idt_evento_situacao = 20 ";
    $sql .= " 	GROUP BY ";
    $sql .= " 		grc_evento_agenda.idt_evento ";
    $sql .= " ) as agenda_real on agenda_real.idt_evento = grc_e.idt ";

//    $sql .= " LEFT OUTER JOIN " . db_pir_gec . "gec_contratacao_credenciado_ordem ord on ord.idt_evento = {$AliasPric}.idt ";

    $sql .= " LEFT OUTER JOIN plu_usuario plu_usuges on plu_usuges.id_usuario = {$AliasPric}.idt_gestor_evento";

//    $sql .= " from {$TabelaPrinc} {$AliasPric}";
//    $sql .= " inner join grc_evento_situacao grc_ersit on grc_ersit.idt = {$AliasPric}.idt_evento_situacao";
//    $sql .= " inner join grc_atendimento_instrumento i on i.idt = {$AliasPric}.idt_instrumento";
//    //$sql .= " inner join grc_atendimento a on a.idt_evento = {$AliasPric}.idt";
//    //$sql .= " inner join grc_atendimento_organizacao ao on ao.idt_atendimento = a.idt";
//    //$sql .= " inner join grc_evento_participante ep on ep.idt_atendimento = a.idt";
//    $sql .= " left outer join " . db_pir_gec . "gec_contratacao_credenciado_ordem ord on ord.idt_evento = {$AliasPric}.idt";
//    //$sql .= " left outer join " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm rm on rm.idt_gec_contratacao_credenciado_ordem = ord.idt";
//    $sql .= " left outer join " . db_pir_gec . "gec_contratacao_credenciado_ordem_insumo coi on coi.idt_gec_contratacao_credenciado_ordem = ord.idt";
//    $sql .= " left outer join grc_evento_situacao grc_ersit_ant on grc_ersit_ant.idt = {$AliasPric}.idt_evento_situacao_ant ";
//    $sql .= " left outer join grc_produto pr on pr.idt = {$AliasPric}.idt_produto";
//    $sql .= " left outer join grc_produto_modalidade pr_mod on pr.idt_modalidade = pr_mod.idt";
//    $sql .= " left outer join grc_projeto proj     on proj.idt = {$AliasPric}.idt_projeto";
//    $sql .= " left outer join grc_projeto_acao projac on projac.idt = {$AliasPric}.idt_acao";
//    $sql .= " left outer join " . db_pir_gec . "gec_entidade_setor ent_setor on ent_setor.idt = proj.idt_setor";
//    $sql .= " left outer join " . db_pir . "sca_organizacao_secao sca_ur on sca_ur.idt = {$AliasPric}.idt_unidade";
//    $sql .= " left outer join " . db_pir . "sca_organizacao_secao sca_pa on sca_pa.idt = {$AliasPric}.idt_ponto_atendimento_tela";
//    $sql .= " left outer join plu_usuario plu_usugespro on plu_usugespro.id_usuario = {$AliasPric}.idt_gestor_projeto";
//    $sql .= " left outer join " . db_pir_gec . "gec_programa gec_pr on gec_pr.idt = {$AliasPric}.idt_programa";
//    //$sql .= " left outer join " . db_pir_siac . "cidade gec_cid on gec_cid.codcid = {$AliasPric}.idt_cidade";
//    //$sql .= " left outer join ' . db_pir_gec . 'gec_entidade_setor s on s.idt = ao.idt_setor";
//    //$sql .= " left outer join " . db_pir_gec . "gec_programa gec_pr on gec_pr.idt = {$AliasPric}.idt_programa";
//    //$sql .= " left outer join " . db_pir_siac . "cidade gec_cid on gec_cid.codcid = {$AliasPric}.idt_cidade";
//    //$strWhere .= " and " . $AliasPric.'.idt_unidade = '.null($vetFiltro['f_idt_unidade']['valor']);
//    //$_POST['sql_orderby']

    if ($strWhere != "") {
        $sql .= " where (";
        $sql .= $strWhere;
        $sql .= " )";
    }

//    $sql .= " GROUP BY grc_e.idt_produto ";
    $sql .= " GROUP BY grc_e.idt ";

    if ($sqlOrderby != "") {
        $sql .= " order by ";
        $sql .= $sqlOrderby;
    } else {
        $sql .= " order by ";
        $sql .= " {$AliasPric}.codigo ";
    }

//    echo $sql;

    if ($primeiro_carregamento > 0) {
        $rs = execsqlNomeCol($sql);
        $qtd_sel = $rs->rows;
        $qtd_reg = 0;
    }

    echo "<br/>";
    if ($qtd_sel == 0) {
        echo "Nada selecionado";
    } else {

        // Imprimir linhas do relatório
        $vet = Array();
        $vet = $vetRelatorio['RELA']; // armazena o Arquivo Principal
        $titulo_rel = $vet['titulo'];
        $largura = $vet['largura'];

        $styleR = "";
        if ($largura != "") {
            $styleR = " width:{$largura}; ";
            echo "<style>";
            echo "body { {$styleR} }";
            echo "div#geral { {$styleR} }";
            echo "</style>";
        }

        if (!empty($pesquisa)) {

            echo "<table class=\"Geral bordasimples\" style=\"width:100%; border:1px solid black\">";
            echo "<tr>";
            echo "<td colspan=\"2\" style=\"background-color: #2a5696; color: white; font-weight: bold;\">";
            echo "Filtros:";
            echo "</td>";
            echo "</tr>";
            echo $pesquisa;
            echo "</table>";
            echo "<br/>";
        }

        echo "<div id='Relatorio_dsw' style='{$styleR}'>";
        $eventow = "##";
        $col_selecionada = $_SESSION[CS]['tmp']['chk_coluna'][$sel_coluna];
        $col_selecionada_tot = count($col_selecionada);

        if ($col_selecionada_tot == 0) {
            $col_selecionada_tot = count($vetCab);
        }

        if (count($vetControleGrupo) == 0) {
            $vetControleGrupoTot = 0;

            $rowUnico = $rs->data;
            $nivel_vl = 'unico';
            agrupaProduto(0, $nivel_vl, $rowUnico);
            $vetDadosGrupo[$nivel_vl] = $rowUnico;

            ForEach ($vetDadosGrupo['unico'] as $nivel_vl => $row) {
                codTab($row, false);
            }

            if ($eventow != "##") {
                echo "<tr class='linha_tabela' style=''>  ";

                $cct = $col_selecionada_tot;
                $cc = $cct - 2;

                echo "<td colspan='{$cc}' style='text-align:right; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black'><b>";
                echo "Total (R$)";
                echo "</b></td>  ";

                echo "<td  style='text-align:right; padding-right:10px; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black'>";
                $total_eventow = format_decimal($total_evento, 2);
                echo $total_eventow;
                echo "</td>  ";

                echo "<td  style='text-align:right; padding-right:10px; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black'>";
                $total_eventow = format_decimal($total_evento, 2);
                echo $total_eventow;
                echo "</td>  ";

                echo "</tr>  ";
                $total_evento = 0;
                $eventow = $evento;
            }

            echo "</table> ";
        } else {
            $vetDadosGrupo = Array();
            $vetControleGrupoTot = count($vetControleGrupo) - 1;

            ForEach ($rs->data as $row) {
                agrupa($vetDadosGrupo, $row, 0);
            }

            ForEach ($vetDadosGrupo as $nivel_vl => $row) {
                agrupaProduto(0, $nivel_vl, $row);
                $vetDadosGrupo[$nivel_vl] = $row;
            }

            $vetAlinhamentoAgrupamento = Array();

            echo '<div style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; width:100%; border: 1px solid black; text-align:left; background-color: #2a5696; color: white; font-weight: bold; padding-bottom:2px ">';
            echo 'Agrupamento:';
            echo '</div> ';

            ForEach ($vetDadosGrupo as $nivel_vl => $row) {

                $vetOrdemAgrupamento['num'] ++;
                $vetOrdemAgrupamento['txtNum'] = $vetOrdemAgrupamento['num'];

                $resultadoNivel = mostrareg(0, $nivel_vl, $row, $vetOrdemAgrupamento['sub'], $vetOrdemAgrupamento['txtNum']);

                $resultadoTotal['tot'] += $resultadoNivel['tot'];
                $resultadoTotal['qtd'] += $resultadoNivel['qtd'];

                echo '<table style="width:100%; font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; border-bottom: 1px solid black; border-left: 1px solid black;  border-right: 1px solid black;text-align:left; background-color: white; color: black; font-weight: bold; padding-bottom:2px ">';
                echo '<tr>';
                echo '<td style="width:40%; text-align:center; ">' . $nivel_vl . '</td>';
                echo '<td style="width:35%; text-align:center; "> VALOR TOTAL(R$): ' . format_decimal($resultadoNivel['tot'], 2) . '</td>';
                echo '<td style="width:35%; text-align:center; "> QTD. DE EVENTOS: ' . $resultadoNivel['qtd'] . '</td>';
                echo '</tr>';
                echo '</table> ';
            }

            echo '<table style="width:100%; font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; border-bottom: 1px solid black; border-left: 1px solid black;  border-right: 1px solid black;text-align:left; background-color: #2a5696; color: white; font-weight: bold; padding-bottom:2px ">';
            echo '<tr>';
            echo '<td style="width:50%; text-align:center; "> VALOR TOTAL(R$): ' . format_decimal($resultadoTotal['tot'], 2) . '</td>';
            echo '<td style="width:50%; text-align:center; "> QTD. TOTAL DE EVENTOS: ' . $resultadoTotal['qtd'] . '</td>';
            echo '</tr>';
            echo '</table> ';
        }

        echo "</div>";
    }
}

function agrupaProduto($nivel, $nivel_vl, &$vetDadosGrupo) {
    global $vetControleGrupoTot;

    if ($vetControleGrupoTot == $nivel) {
        $rowFinal = Array();
        $vetFinal = Array();
        $vetProd = Array();

        ForEach ($vetDadosGrupo as $row) {
            $vetProd[$row['produto']][] = $row;
        }

//        p($vetProd);

        ForEach ($vetProd as $idxProd => $rowProd) {
            $totServico = 0;
            $qtd_previsto = 0;
            $qtd_evt_real = 0;
            $qtd_real = 0;

            ForEach ($rowProd as $row) {
                // Produto
                $rowFinal['produto'] = $row['produto'];

                // Custo Total dos Eventos Previsto (R$)
                $totServico += $row['valor_servico'];

                // Prazo Médio Previsto (dias)
                $qtd_previsto += $row['qtd_previsto'];

                // Quantidade de Eventos Realizados (Dias) 
                $qtd_real += $row['qtd_real'];

                $qtd_evt_real += $row['qtd_evt_real'];

                // Quantidade de Eventos Aditados 
                $rowFinal['qtd_aditamento'] = $row['qtd_aditamento'];

                // Prazo Médio de Aditamento (dias) 
                $rowFinal['prazo_medio_aditamento'] = $row['prazo_medio_aditamento'];
            }

            // Quantidade de Evento
            $rowFinal['quantidade'] = count($rowProd);
            $rowFinal['valor_servico'] = $totServico;
            $rowFinal['media'] = $totServico / $rowFinal['quantidade'];
//            $rowFinal['prazo_medio_previsto'] = $qtd_previsto / $rowFinal['quantidade'];
            $rowFinal['prazo_medio_previsto'] = format_decimal($qtd_previsto / $rowFinal['quantidade'], 0);
            $rowFinal['prazo_medio_real'] = $qtd_real / $rowFinal['quantidade'];
            $rowFinal['qtd_evt_real'] = $qtd_evt_real;

            $vetFinal[$idxProd] = $rowFinal;
        }

        $vetDadosGrupo = Array();
        $vetDadosGrupo = $vetFinal;
    } else {
        $nivelnovo = $nivel + 1;
        ForEach ($vetDadosGrupo as $nivel_vl_novo => $row_novo) {
            agrupaProduto($nivelnovo, $nivel_vl_novo, $row_novo);
            $vetDadosGrupo[$nivel_vl_novo] = $row_novo;
        }
    }

    return $resultado;
}

function mostrareg($nivel, $nivel_vl, $vetDadosGrupo, &$vetOrdemAgrupamento, $txtNum) {
    global $vetControleGrupo, $vetControleGrupoTot, $vetRelatorio;

    $resultado = Array(
        'tot' => 0,
        'qtd' => 0,
    );

    if ($nivel > 0) {
        $vetOrdemAgrupamento['num'] ++;
        $vetOrdemAgrupamento['txtNum'] = $txtNum . '.' . $vetOrdemAgrupamento['num'];
        $txtNum = $vetOrdemAgrupamento['txtNum'];
    }

    echo '<div style=" font-family: Arial, Helvetica, sans-serif; font-size: 14px; border-left: 1px solid black; border-right: 1px solid black; text-align:left; background-color: white; color: black; font-weight: bold; padding-bottom:2px ">';
    echo '<b>' . str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $nivel) . $txtNum . '.' . $vetControleGrupo[$nivel] ['nome'] . '</b>: ' . $nivel_vl;
    echo '</div> ';

    if ($vetControleGrupoTot == $nivel) {

        // Cabeçalho
        echo "<table class='Geral' width='100%' border='1px' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        echo "<tr class='linha_cab_tabela' style='border:0;'>  ";
        $vetCab = $vetRelatorio['CABE'];

        ForEach ($vetCab as $numcel => $vetCelula) {
            $campoCel = "";
            $br = "";
            $styleC = "";
            $insert_td = false;
            ForEach ($vetCelula as $numcpo => $vetCpo) {

                if (in_array($vetCpo['campo'], $col_selecionada) || count($col_selecionada) == 0) {
                    $insert_td = true;
                    $style = $vetCpo['styleCab'];
                    $styleC = 'background-color: #2a5696; color: white; font-weight: bold;'; //$vetCpo['styleC'];
                    $conteudo = $vetCpo['descricao'];
                    if ($style != '') {
                        $conteudo = "<span style='{$style}'>{$conteudo}</span>";
                    }
                    $campoCel .= $br . $conteudo;

                    $br = "<br />";
                }
            }

            if ($insert_td) {
                $col_tot++;
                echo " <td class='linha_cab_tabela' style='{$styleC}'>";
                echo $campoCel;
                echo " </td> ";
            }
        }

        echo "</tr>";

        ForEach ($vetDadosGrupo as $row) {
            $resultado['tot'] += $row['valor_servico'];
            $resultado['tot_media'] += $row['media'];
            $resultado['qtd'] += $row['quantidade'];

            $media_total_servico = $resultado['tot'] / $resultado['qtd'];

            codTab($row, true);
        }

        $col_span = $col_tot - 8;
        $col_span_total_complete = 9 - $col_span_total;

        echo "<tr>";
        echo "  <td colspan='{$col_span_total}' style='text-align:right; border-left: 1px solid black; border-bottom: 0px; border-top: 1px solid black'><b>Total(R$)</b></td>";
        echo "  <td style='text-align:right; padding-right:10px; border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black;'>" . $resultado['qtd'] . "</td>";
        echo "  <td style='text-align:right; padding-right:10px; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black'>" . format_decimal($resultado['tot']) . "</td>";
        echo "  <td style='text-align:right; padding-right:10px; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black'>" . format_decimal($media_total_servico) . "</td>";
        echo "  <td colspan='{$col_span_total_complete}' style='border-left: 1px solid black; border-bottom: 0px; border-top: 1px solid black; border-right: 1px solid black;'></td>";
        echo "</tr>";

        echo "</table> ";
    } else {
        $nivelnovo = $nivel + 1;
        ForEach ($vetDadosGrupo as $nivel_vl_novo => $row_novo) {
            $resul = mostrareg($nivelnovo, $nivel_vl_novo, $row_novo, $vetOrdemAgrupamento[$nivel_vl], $txtNum);

            $resultado['tot'] += $resul['tot'];
            $resultado['tot_media'] += $resul['tot_media'];
            $resultado['qtd'] += $resul['qtd'];

            if ($resultado['tot_media'] / $resultado['qtd'] > 0) {
                $media_total_servico = $resultado['tot_media'] / $resultado['qtd'];
            } else {
                $media_total_servico = 0;
            }
        }
    }

    return $resultado;
}

function agrupa(&$vetDadosGrupo, $row, $key) {
    global $vetControleGrupo, $vetControleGrupoTot;

    $value = $vetControleGrupo[$key];

    if ($vetControleGrupoTot == $key) {
        $vetDadosGrupo[$row[$value['campo']]][] = $row;
    } else {
        agrupa($vetDadosGrupo[$row[$value['campo']]], $row, $key + 1);
    }
}

function codTab($row, $soreg) {
    global $qtd_reg, $vetRelatorio, $col_selecionada, $eventow, $col_selecionada_tot, $total_evento, $vetAFProcessoSit, $vetAFProcessoFI;

    $unidade_regional = $row['unidade_regional'];
    $ponto_atendimento = $row['ponto_atendimento'];
    $codigo_evento = $row['codigo_evento'];
    $produto = $row['produto'];
    $quantidade = $row['quantidade'];

    if ($row['valor_servico'] == '') {
        $valor_servico = '0,00';
    } else {
        $valor_servico = format_decimal($row['valor_servico'], 2);
    }

    $media = format_decimal($row['media'], 2);
//    $qtd_previsto = $row['qtd_previsto'];
    $prazo_medio_previsto = $row['prazo_medio_previsto'];
//    $prazo_medio_previsto = format_decimal($row['prazo_medio_previsto'], 2);
    $prazo_medio_real = format_decimal($row['prazo_medio_real'], 2);

    if ($row['qtd_evt_real'] == '') {
        $qtd_evt_real = '0';
    } else {
        $qtd_evt_real = $row['qtd_evt_real'];
    }

    $qtd_aditamento = $row['qtd_aditamento'];
    $prazo_medio_aditamento = $row['prazo_medio_aditamento'];

//    $servico_contratado = $row['servico_contratado'];
//    $setor = $row['setor'];

    $qtd_reg = $qtd_reg + 1;

    if ($soreg === false) {
        if ($qtd_reg == 1) {

            // Cabeçalho
            echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
            echo "<tr class='linha_cab_tabela' style='border:0;'>  ";
            $vetCab = $vetRelatorio['CABE'];

            ForEach ($vetCab as $numcel => $vetCelula) {
                $campoCel = "";
                $br = "";
                $styleC = "";
                $insert_td = false;
                ForEach ($vetCelula as $numcpo => $vetCpo) {
                    if (in_array($vetCpo['campo'], $col_selecionada) || count($col_selecionada) == 0) {
                        $insert_td = true;
                        $style = $vetCpo['styleCab'];
                        $styleC = $vetCpo['styleC'];
                        $styleC = 'background-color: #2a5696; color: white; font-weight: bold;'; //$vetCpo['styleC'];
                        $conteudo = $vetCpo['descricao'];
                        if ($style != '') {
                            $conteudo = "<span style='{$style}'>{$conteudo}</span>";
                        }
                        $campoCel .= $br . $conteudo;

                        $br = "<br />";
                    }
                }

                if ($insert_td) {
                    $col_tot++;
                    echo " <td class='linha_cab_tabela' style='{$styleC}'>";
                    echo $campoCel;
                    echo " </td> ";
                }
            }
            echo "</tr>";
        }

        if ($eventow != $evento) {
            if ($eventow != "##") {

                echo "<tr class='linha_tabela' style=''>";

                $cct = $col_selecionada_tot;
                $cc = $cct - 1;

                echo "  <td colspan='{$cc}' style='background:#F1F1F1; color:000000; text-align:right;'>  ";
                echo "      TOTAL DO EVENTO: ";
                echo "  </td>  ";

                echo "  <td  style='background:#F1F1F1; color:000000; text-align:right; padding-right:10px;'>  ";
                $total_eventow = format_decimal($total_evento, 2);
                echo $total_eventow;
                echo "  </td>  ";

                echo "</tr>  ";
                $total_evento = 0;
            }
            $eventow = $evento;
        }
    }

    echo "<tr class='linha_tabela' style=''>";

    $vetCab = $vetRelatorio['CABE'];
    ForEach ($vetCab as $numcel => $vetCelula) {
        $bgcolor = "#FFFFFF";
        $color = "#000000";
        $campoCel = "";
        $br = "";
        $styleC = "";
        $insert_td = false;
        ForEach ($vetCelula as $numcpo => $vetCpo) {


            if (in_array($vetCpo['campo'], $col_selecionada) || count($col_selecionada) == 0) {
                $insert_td = true;
                $nmc = $vetCpo['campo'];
                $style = $vetCpo['style'];
                $styleC = $vetCpo['styleC'];
                $conteudo = $$nmc;

                if ($nmc == 'valor_servico') {
                    if ($conteudo != "" and $conteudo > 0) {
                        $total_evento = $total_evento + desformat_decimal($conteudo);
                    }
                }

                $campoCel .= $br . $conteudo;
                $br = "<br />";
            }
        }

        if ($insert_td) {
            echo " <td class='linha_tabela' style='border-right:1px solid black; border-left:1px solid black;{$styleC} {$style}'>";
            echo $campoCel;
            echo "</td> ";
        }
    }

    echo "</tr>";
}

if ($_GET['print'] != 's') {
    ?>

    <script type="text/javascript">
        $(document).ready(function () {

            $("#f_idt_ponto_atendimento_tela").cascade("#f_idt_unidade", {
                ajax: {
                    url: ajax_sistema + '?tipo=pa_unidade&cas=' + conteudo_abrir_sistema
                }
            });

            $("#f_idt_sub_area").cascade("#f_idt_area_tematica", {
                ajax: {
                    url: ajax_sistema + '?tipo=area_tematica&cas=' + conteudo_abrir_sistema
                }
            });

            $("#f_idt_gestor_evento").cascade("#f_idt_unidade", {
                ajax: {
                    url: ajax_sistema + '?tipo=usuario_pa&cas=' + conteudo_abrir_sistema
                }
            });

            $('#relatorio_excel').on('click', function () {
                var prefixo = 'relatorio';
                var arquivo = 'grc_sebraetec_r06';
                var bt_print_tit_rel = '';

                relatorio_exportar_xls(prefixo, arquivo, bt_print_tit_rel);

            });
        });

        function fncListarCmbMuda_f_idt_projeto() {
            $('#f_idt_acao_bt_limpar').click();
        }

        function parListarCmb_f_idt_projeto() {
            var par = '';

            par += '&veio=SG';
            return par;
        }

        function parListarCmb_f_idt_acao() {
            var par = '';
            par += '&veio=SG';

            if ($('#f_idt_projeto').val() == '') {
                alert('Favor informar o Projeto!');
                return false;
            } else {
                par += '&idt_projeto=' + $('#f_idt_projeto').val();
            }
            return par;
        }
    </script>
<?php } ?>

<style>
    #filtro_classificacao {
        display:block;
    }

    #barra_menu {
        display:none;
    }

    #filtro {
        width:50%;
    }

    Select {
        width:80%;
    }

    td img {
        margin-left:5px;
    }

    Table#Tabela_Filtro vvvtd input {
        padding:0;
        width:76.5%;
    }

    #f_texto {
        padding:0;
        width:76.5%;
    }

    #f_chave_sgc {
        padding:0;
        width:76.5%;
    }

    #f_dt_ini {
        padding:0;
        width:76.5%;
    }

    #f_dt_fim {
        padding:0;
        width:76.5%;
    }

    div.listar_cmb_div {
        width:76.5%;
    }

    #argumento Input {

    }

    div.titGrupo {
        font-size: 15px;
        font-weight: bold;
    }

    td.linha_tabela {
        border: none;
    }        

    table.bordasimples {
        border-collapse: collapse;
    }

    table.bordasimples tr td {
        border:1px solid black;
    }
</style>
