<?php
Require_Once('relatorio/lupe_generico.php');
Require_Once('style.php');

set_time_limit(0);

$primeiro_carregamento = count($_POST);
$titulo_relatorio = "Relatório 3";
$largura_relatorio = "100%";
$pesquisa = '';
$vetOrdemAgrupamento = Array();
$tot_valor_evento = 0;
$qtd_evento = Array();

$resultadoNivel = Array(
    'tot' => 0,
    'qtd' => 0,
);

$resultadoTotal = Array(
    'tot' => 0,
    'qtd' => 0,
);

//
// Valor Default Agrupamento
//
if ($primeiro_carregamento == 0) {
    $_POST['sql_groupby'] = Array('ponto_atendimento', 'gestor_evento');
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

if (!in_array("setor", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[2]['campo'] = "setor";
    $vetd[2]['descricao'] = "Setor/Território do Projeto";
    $vetd[2]['cor'] = "";
    $vetd[2]['tamanho'] = "";
    $vet[] = $vetd;
}

if (!in_array("unidade_regional", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[1]['campo'] = "unidade_regional";
    $vetd[1]['descricao'] = "UR";
    $vetd[1]['cor'] = "";
    $vetd[1]['tamanho'] = "";
    $vet[] = $vetd;
}

if (!in_array("produto", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[1]['campo'] = "produto";
    $vetd[1]['descricao'] = "Produto";
    $vetd[1]['cor'] = "";
    $vetd[1]['tamanho'] = "";
    $vet[] = $vetd;
}

if (!in_array("servico_contratado", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[2]['campo'] = "servico_contratado";
    $vetd[2]['descricao'] = "Serviço (Evento) Contratado";
    $vetd[2]['cor'] = "";
    $vetd[2]['tamanho'] = "";
    $vet[] = $vetd;
}

if (!in_array("evento", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[1]['campo'] = "evento";
    $vetd[1]['descricao'] = "Código Evento";
    $vetd[1]['cor'] = "";
    $vetd[1]['tamanho'] = "";
    $vet[] = $vetd;
}

if (!in_array("status_operacional", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[2]['campo'] = "grc_ersit_descricao";
    $vetd[2]['descricao'] = "Status Evento";
    $vetd[2]['cor'] = "";
    $vetd[2]['tamanho'] = "";
    $vet[] = $vetd;
}

if (!in_array("status_financeiro", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[2]['campo'] = "status_financeiro";
    $vetd[2]['descricao'] = "Status Financeiro";
    $vetd[2]['cor'] = "";
    $vetd[2]['tamanho'] = "";
    $vet[] = $vetd;
}

if (!in_array("mes_ano", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[2]['campo'] = "mes_ano";
    $vetd[2]['descricao'] = "Data Entrega";
    $vetd[2]['cor'] = "";
    $vetd[2]['tamanho'] = "";
    $vetd[2]['styleC'] = " text-align:center ";
    $vet[] = $vetd;
}

if (!in_array("valor_servico", $_POST['sql_groupby'])) {
    $vetd = Array();
    $vetd[1]['campo'] = "valor_servico";
    $vetd[1]['descricao'] = "Valor da Entrega (R$)";
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
    $nome_relatorio = 'RELATÓRIO DE EVENTOS (STATUS EVENTOS/STATUS FINANCEIRO)';
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
$sql .= ' select idt, descricao';
$sql .= ' from grc_evento_situacao';
$sql .= " where ativo = 'S'";
$sql .= " and idt in (14, 16, 19, 20)";
$sql .= ' order by codigo';
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
$Filtro['id_select'] = 'codigo';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['nome'] = 'PST';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_pst'] = $Filtro;

$Filtro = Array();
$vetAFProcessoSit['null'] = 'O credenciado não consultou este processo';
$Filtro['rs'] = $vetAFProcessoSit;
$Filtro['id'] = 'f_idt_status_financeiro';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['nome'] = 'Status Financeiro';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_status_financeiro'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = $vetSimNao;
$Filtro['id'] = 'f_idt_liquidado_financeiro';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['nome'] = 'Liquidado Financeiro';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_liquidado_financeiro'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Intervalo';
$Filtro['id'] = 'entrega';
$Filtro['nome'] = 'Data Entrega';
$Filtro['js'] = 'data';
$Filtro['valor_dt_ini'] = trata_id($Filtro, '_ini');
$Filtro['valor_dt_fim'] = trata_id($Filtro, '_fim');
$vetFiltro['entrega'] = $Filtro;

$idx = -1;
ForEach ($vetFiltro as $Filtro) {
    $idx++;
    $strPara .= $Filtro['id'] . $idx . ',';
}

// Vetor Agrupamento
$vetGroupby = Array();
$vetGroupby['evento'] = 'Evento';
$vetGroupby['setor'] = 'Setor/Território do Projeto';
$vetGroupby['unidade_regional'] = 'Unidade Regional';
$vetGroupby['ponto_atendimento'] = 'Ponto de Atendimento';
$vetGroupby['projeto'] = 'Projeto';
$vetGroupby['acao'] = 'Ação';
$vetGroupby['gestor_projeto'] = 'Gestor do Projeto';
$vetGroupby['gestor_evento'] = 'Responsável pelo Evento';
$vetGroupby['cidade_descricao'] = 'Cidade';
$vetGroupby['status_operacional'] = 'Status do Evento';
$vetGroupby['a7'] = 'Tipo de Evento';
$vetGroupby['instrumento'] = 'Instrumento';
$vetGroupby['descricao_modalidade'] = 'Modalidade';
$vetGroupby['a10'] = 'Área Tematica';
$vetGroupby['a11'] = 'SubÁrea';
$vetGroupby['produto'] = 'Produto';
$vetGroupby['nome_pst'] = 'PST';

// Vetor Ordenação
$vetOrderby = Array();
$vetOrderby['setor'] = 'Setor/Território do Projeto';
$vetOrderby['unidade_regional'] = 'Unidade Regional';
$vetOrderby['produto'] = 'Produto';
$vetOrderby['servico_contratado'] = 'Serviço Contratado';
$vetOrderby['evento'] = 'Evento';
$vetOrderby['status_operacional'] = 'Status Operacional';
$vetOrderby['status_financeiro'] = 'Status Financeiro';
$vetOrderby['gestor_evento'] = 'Responsável pelo Evento';
$vetOrderby['valor_servico'] = 'Valor Serviço';
$vetOrderby['diamesano'] = 'Data de Entrega';

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
    //codigo_filtro_fixo();
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
    $campos .= " {$AliasPric}.codigo as codigo_evento,";
    $campos .= " i.descricao as instrumento,";
    $campos .= " i.descricao as servico_contratado,";
    $campos .= " grc_ersit.descricao as grc_ersit_descricao,";
    $campos .= " grc_ersit_ant.descricao as grc_ersit_ant_descricao,";
    $campos .= " ent_setor.descricao as setor,";

    $campos .= "    (";
    $campos .= "    select concat_ws('<br />', u.nome_completo, date_format(ap.dt_update, '%d/%m/%Y %H:%i:%s')) as aprovador";
    $campos .= "    from grc_atendimento_pendencia ap";
    $campos .= "    inner join plu_usuario u on u.id_usuario = ap.idt_usuario_update";
    $campos .= "    where ap.idt_evento_situacao_para = 14";
    $campos .= "    and ap.idt_evento = {$AliasPric}.idt";
    $campos .= "    order by ap.dt_update desc limit 1";
    $campos .= "    ) as aprovador,";

    $campos .= " rm.valor_real as valor_servico,";
    $campos .= " rm.mesano as mes_ano,";
    $campos .= " concat(SUBSTR(mesano, 4, 7), '-', SUBSTR(mesano,1, 2), '-01') as diamesano,";
    $campos .= " pr.descricao as produto,";
    $campos .= " {$AliasPric}.codigo as evento,";
    $campos .= " grc_ersit.descricao as status_operacional,";
    $campos .= " afp.situacao_reg as status_financeiro,";
    $campos .= " proj.descricao as projeto,";
    $campos .= " projac.descricao as acao,";
    $campos .= " sca_ur.descricao as unidade_regional,";
    $campos .= " sca_ur.classificacao AS unidade_regional_classificacao,";
    $campos .= " sca_pa.descricao as ponto_atendimento,";
    $campos .= " plu_usuges.nome_completo as gestor_evento,";
    $campos .= " plu_usugespro.nome_completo as gestor_projeto,";
    $campos .= " gec_cid.desccid as cidade_descricao,";
    $campos .= " afp.gfi_situacao,";
    $campos .= " ord.codigo as ordem_contratacao,";
    $campos .= " ord.chave_sgc,";
    $campos .= " rm.mesano, rm.valor_prev, rm.valor_real, rm.rm_idmov,";
    $campos .= " eo.descricao as nome_pst,";
    $campos .= " pr_mod.descricao as descricao_modalidade,";
    $campos .= " ord.rm_consolidado";

    // Where
    $strWhere = "";
    $strWhere .= " {$AliasPric}.temporario <> 'S'";
    $strWhere .= " and pr.idt_programa = 4";
    $strWhere .= " and {$AliasPric}.idt_evento_situacao in (14, 16, 19, 20)";
    $strWhere .= " and rm.rm_cancelado = 'N'";
    $strWhere .= " and ord.rm_consolidado = 'R'";

    // Setor
    if ($vetFiltro['f_idt_setor']['valor'] != "" && $vetFiltro['f_idt_setor']['valor'] != "0" && $vetFiltro['f_idt_setor']['valor'] != "-1") {
        $sql_filtro = "";
        $sql_filtro .= " select descricao";
        $sql_filtro .= " from grc_sebraetec_setor";
        $sql_filtro .= " where idt = " . null($vetFiltro['f_idt_setor']['valor']);
        $sql_filtro .= " order by descricao ";
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Setor/Território do Projeto</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= " and proj.idt_setor = " . null($vetFiltro['f_idt_setor']['valor']);
    }

    // Unidade Regional
    if ($vetFiltro['f_idt_unidade']['valor'] != "" && $vetFiltro['f_idt_unidade']['valor'] != "0" && $vetFiltro['f_idt_unidade']['valor'] != "-1") {
        $sql_filtro = "";
        $sql_filtro .= " select descricao";
        $sql_filtro .= " from " . db_pir . "sca_organizacao_secao";
        $sql_filtro .= " where posto_atendimento <> 'S' and idt = " . null($vetFiltro['f_idt_unidade']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Unidade Regional</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= " and " . $AliasPric . ".idt_unidade = " . null($vetFiltro['f_idt_unidade']['valor']);
    }

    // Ponto de Atendimento
    if ($vetFiltro['f_idt_ponto_atendimento_tela']['valor'] != "" && $vetFiltro['f_idt_ponto_atendimento_tela']['valor'] != "0" && $vetFiltro['f_idt_ponto_atendimento_tela']['valor'] != "-1") {
        $sql_filtro = "";
        $sql_filtro .= "select descricao ";
        $sql_filtro .= " from " . db_pir . "sca_organizacao_secao ";
        $sql_filtro .= " where SUBSTRING(classificacao, 1, 5) = (";
        $sql_filtro .= " select SUBSTRING(classificacao, 1, 5) as cod";
        $sql_filtro .= " from " . db_pir . 'sca_organizacao_secao';
        $sql_filtro .= " where idt = " . null($vetFiltro['idt_unidade']['valor']);
        $sql_filtro .= " )";
        $sql_filtro .= " and idt = " . null($vetFiltro['f_idt_ponto_atendimento_tela']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Ponto de Atendimento</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_ponto_atendimento_tela = ' . null($vetFiltro['f_idt_ponto_atendimento_tela']['valor']);
    }

    // Projeto
    if ($vetFiltro['f_idt_projeto']['valor'] != "" && $vetFiltro['f_idt_projeto']['valor'] != "0" && $vetFiltro['f_idt_projeto']['valor'] != "-1") {
        $sql_filtro = "";
        $sql_filtro .= " Select grc_pro.descricao";
        $sql_filtro .= " from grc_projeto as grc_pro ";
        $sql_filtro .= " left join grc_projeto_situacao grc_ps on grc_ps.idt = grc_pro.idt_projeto_situacao ";
        $sql_filtro .= " where ativo_siacweb  = " . aspa('S');
        $sql_filtro .= " and existe_siacweb = " . aspa('S');
        $sql_filtro .= " and grc_pro.idt = " . null($vetFiltro['f_idt_projeto']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Projeto</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_projeto = ' . null($vetFiltro['f_idt_projeto']['valor']);
    }

    // Ação
    if ($vetFiltro['f_idt_acao']['valor'] != "" && $vetFiltro['f_idt_acao']['valor'] != "0" && $vetFiltro['f_idt_acao']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= " Select grc_pro.descricao";
        $sql_filtro .= " from grc_projeto_acao as grc_pro ";
        $sql_filtro .= " where ativo_siacweb = 'S' ";
        $sql_filtro .= " and existe_siacweb = 'S' ";
        $sql_filtro .= ' and grc_pro.idt = ' . null($vetFiltro['f_idt_acao']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Ação</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_acao = ' . null($vetFiltro['f_idt_acao']['valor']);
    }

    // Gestor Projeto
    if ($vetFiltro['f_idt_gestor_projeto']['valor'] != "" && $vetFiltro['f_idt_gestor_projeto']['valor'] != "0" && $vetFiltro['f_idt_gestor_projeto']['valor'] != "-1") {
        $sql_filtro = "";
        $sql_filtro .= " select nome_completo";
        $sql_filtro .= " from plu_usuario";
        $sql_filtro .= " where ativo = 'S'";
        $sql_filtro .= " and id_usuario = " . null($vetFiltro['f_idt_gestor_projeto']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Gestor Projeto</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_gestor_projeto = ' . null($vetFiltro['f_idt_gestor_projeto']['valor']);
    }

    // Responsável pelo Evento
    if ($vetFiltro['f_idt_responsavel_evento']['valor'] != "" && $vetFiltro['f_idt_responsavel_evento']['valor'] != "0" && $vetFiltro['f_idt_responsavel_evento']['valor'] != "-1") {
        $sql_filtro = '';
        $sql_filtro .= " select nome_completo";
        $sql_filtro .= " from plu_usuario";
        $sql_filtro .= " where ativo = 'S'";
        $sql_filtro .= " and id_usuario = " . null($vetFiltro['f_idt_responsavel_evento']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Responsável pelo Evento</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= ' and ' . $AliasPric . '.idt_gestor_evento = ' . null($vetFiltro['f_idt_responsavel_evento']['valor']);
    }

    // Cidade
    if ($vetFiltro['f_idt_cidade']['valor'] != "" && $vetFiltro['f_idt_cidade']['valor'] != "0" && $vetFiltro['f_idt_cidade']['valor'] != "-1") {
        $sql_filtro = "";
        $sql_filtro .= " select desccid";
        $sql_filtro .= " from " . db_pir_siac . 'cidade';
        $sql_filtro .= " where codest = 5";
        $sql_filtro .= " and codcid = " . null($vetFiltro['f_idt_cidade']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Cidade</strong></td><td style="width:80%; text-align: left">' . $rs_filtro->data[0][0] . '</td></tr>';
        $strWhere .= " and " . $AliasPric . '.idt_cidade = ' . null($vetFiltro['f_idt_cidade']['valor']);
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
        $strWhere .= " and " . $AliasPric . '.idt_evento_situacao = ' . null($vetFiltro['f_idt_evento_situacao']['valor']);
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
        $sql_filtro .= " and idt = " . null($vetFiltro['f_idt_area_tematica']['valor']);
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
        $sql_filtro .= " and idt_area = " . null($vetFiltro['f_idt_sub_area']['valor']);
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
        $sql_filtro .= " and codigo = " . aspa($vetFiltro['f_idt_pst']['valor']);
        $rs_filtro = execsql($sql_filtro);

        $pesquisa .= '<tr><td style = "width:20%; text-align: left"><strong>Prestadora de Serviço Tecnológico (PST)</strong></td><td style = "width:80%; text-align: left">' . $rs_filtro->data[0][0] . ' < / td></tr>';

        $strWhere .= ' and eo.codigo = ' . aspa($vetFiltro['f_idt_pst']['valor']);
    }

    // Status Financeiro
    if ($vetFiltro['f_idt_status_financeiro']['valor'] != "" && $vetFiltro['f_idt_status_financeiro']['valor'] != "0" && $vetFiltro['f_idt_status_financeiro']['valor'] != "-1") {
        $pesquisa .= '<tr><td style = "width:20%; text-align: left"><strong>Status Financeiro</strong></td><td style = "width:80%; text-align: left">' . $vetAFProcessoSit[$vetFiltro['f_idt_status_financeiro']['valor']] . ' </td></tr>';

        if ($vetFiltro['f_idt_status_financeiro']['valor'] == 'null') {
            $strWhere .= ' and afp.situacao_reg is null';
        } else {
            $strWhere .= ' and afp.situacao_reg = ' . aspa($vetFiltro['f_idt_status_financeiro']['valor']);
        }
    }

    // Liquidado Financeiro
    if ($vetFiltro['f_idt_liquidado_financeiro']['valor'] != "" && $vetFiltro['f_idt_liquidado_financeiro']['valor'] != "0" && $vetFiltro['f_idt_liquidado_financeiro']['valor'] != "-1") {
        $pesquisa .= '<tr><td style = "width:20%; text-align: left"><strong>Liquidado Financeiro</strong></td><td style = "width:80%; text-align: left">' . $vetSimNao[$vetFiltro['f_idt_liquidado_financeiro']['valor']] . ' </td></tr>';
        $strWhere .= ' and afp.liquidado = ' . aspa($vetFiltro['f_idt_liquidado_financeiro']['valor']);
    }

    // Data Entrega
    if ($vetFiltro['entrega']['valor_dt_ini'] != '' && $vetFiltro['entrega']['valor_dt_fim'] != '') {
        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Período Data de Entrega</strong></td><td style="width:80%; text-align: left">' . $vetFiltro['entrega']['valor_dt_ini'] . ' até ' . $vetFiltro['entrega']['valor_dt_fim'] . ' </td></tr>';
        $strWhere .= " and DATE_FORMAT(STR_TO_DATE(concat('01/', rm.mesano), '%d/%m/%Y'), '%Y-%m-%d') between " . aspa(trata_data($vetFiltro['entrega']['valor_dt_ini'])) . " and " . aspa(trata_data($vetFiltro['entrega']['valor_dt_fim']));
    } else if ($vetFiltro['entrega']['valor_dt_ini'] != '' && $vetFiltro['entrega']['valor_dt_fim'] == '') {
        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Período Data de Entrega (Inicio)</strong></td><td style="width:80%; text-align: left"> ' . $vetFiltro['entrega']['valor_dt_ini'] . ' </td></tr>';
        $strWhere .= " and DATE_FORMAT(STR_TO_DATE(concat('01/', rm.mesano), '%d/%m/%Y'), '%Y-%m-%d') >= " . aspa(trata_data($vetFiltro['entrega']['valor_dt_ini']));
    } else if ($vetFiltro['entrega']['valor_dt_ini'] == '' && $vetFiltro['entrega']['valor_dt_fim'] != '') {
        $pesquisa .= '<tr><td style="width:20%; text-align: left"><strong>Período Data de Entrega (Final)</strong></td><td style="width:80%; text-align: left"> ' . $vetFiltro['entrega']['valor_dt_fim'] . ' </td></tr>';
        $strWhere .= " and DATE_FORMAT(STR_TO_DATE(concat('01/', rm.mesano), '%d/%m/%Y'), '%Y-%m-%d') <= " . aspa(trata_data($vetFiltro['entrega']['valor_dt_fim']));
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
        $sqlOrderby = implode(', ', $sqlOrderby);

        // Torca valores dos campos da unidade regional para fazer ordenamento correto
        $sqlOrderby = str_replace('unidade_regional', 'unidade_regional_classificacao', $sqlOrderby);
    }

    $sql = "select {$AliasPric}.*, ";
    $sql .= $campos;
    $sql .= " from {$TabelaPrinc} {$AliasPric}";
    $sql .= " inner join grc_evento_situacao grc_ersit on grc_ersit.idt = {$AliasPric}.idt_evento_situacao";
    $sql .= " inner join grc_atendimento_instrumento i on i.idt = {$AliasPric}.idt_instrumento";
    $sql .= " left outer join " . db_pir_gec . "gec_contratacao_credenciado_ordem ord on ord.idt_evento = {$AliasPric}.idt and ord.ativo = 'S'";
    $sql .= " left outer join " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista ol on ol.idt_gec_contratacao_credenciado_ordem = ord.idt and ol.ativo = 'S'";
    $sql .= " left outer join " . db_pir_gec . "gec_entidade eo on eo.idt = ol.idt_organizacao";
    $sql .= " left outer join " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm rm on rm.idt_gec_contratacao_credenciado_ordem = ord.idt";
    $sql .= " left outer join grc_evento_situacao grc_ersit_ant on grc_ersit_ant.idt = {$AliasPric}.idt_evento_situacao_ant ";
    $sql .= " left outer join " . db_pir_pfo . "pfo_af_processo afp on afp.idmov = rm.rm_idmov";
    $sql .= " left outer join grc_produto pr on pr.idt = {$AliasPric}.idt_produto";
    $sql .= " left outer join grc_produto_modalidade pr_mod on pr.idt_modalidade = pr_mod.idt";
    $sql .= " left outer join grc_projeto proj on proj.idt = {$AliasPric}.idt_projeto";
    $sql .= " left outer join grc_projeto_acao projac on projac.idt = {$AliasPric}.idt_acao";
    $sql .= " left outer join grc_sebraetec_setor ent_setor on ent_setor.idt = proj.idt_setor";
    $sql .= " left outer join " . db_pir . "sca_organizacao_secao sca_ur on sca_ur.idt = {$AliasPric}.idt_unidade";
    $sql .= " left outer join " . db_pir . "sca_organizacao_secao sca_pa on sca_pa.idt = {$AliasPric}.idt_ponto_atendimento_tela";
    $sql .= " left outer join plu_usuario plu_usuges on plu_usuges.id_usuario = {$AliasPric}.idt_gestor_evento";
    $sql .= " left outer join plu_usuario plu_usugespro on plu_usugespro.id_usuario = {$AliasPric}.idt_gestor_projeto";
    $sql .= " left outer join " . db_pir_gec . "gec_programa gec_pr on gec_pr.idt = {$AliasPric}.idt_programa";
    $sql .= " left outer join " . db_pir_siac . "cidade gec_cid on gec_cid.codcid = {$AliasPric}.idt_cidade";

    if ($strWhere != "") {
        $sql .= " where (";
        $sql .= $strWhere;
        $sql .= " )";
    }

    if ($sqlOrderby != "") {
        $sql .= " order by ";
        $sql .= $sqlOrderby;
    } else {
        $sql .= " order by ";
        $sql .= " {$AliasPric}.codigo ";
    }

    if ($primeiro_carregamento > 0) {
		set_time_limit(0);
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

            ForEach ($rs->data as $row) {
                codTab($row, false);
            }

            if ($eventow != "##") {

                if ($tot_valor_evento > 0) {
                    $cct = $col_selecionada_tot;
                    $cc = $cct - 1;

                    // Sem Agrupamento
                    echo "<tr class='linha_tabela' style=''>";
                    echo "<td colspan='{$cc}' style='text-align:right; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black'><b> Valor Total (R$)</b></td>";
                    echo "<td  style='text-align:right; padding-right:10px; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black'>" . format_decimal($total_evento, 2) . "</td>";
                    echo "</tr>";

                    $total_evento = 0;
                }

                $cct = $col_selecionada_tot;

                echo "<tr class='linha_tabela' style=''>  ";
                echo "<td colspan='{$cct}'>";

                echo '<table style="width:100%; font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; border-bottom: 1px solid black; border-left: 1px solid black;  border-right: 1px solid black;text-align:left; background-color: #2a5696; color: white; font-weight: bold; padding-bottom:2px ">';
                echo '<tr>';
                echo '<td style="width:50%; text-align:center; "> VALOR TOTAL(R$): ' . format_decimal($tot_valor_evento, 2) . '</td>';
                echo '<td style="width:50%; text-align:center; "> QTD. DE EVENTO TOTAL: ' . count($qtd_evento) . '</td>';
                echo '</tr>';
                echo '</table>';

                echo '</td>';
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
                echo '<td style="width:35%; text-align:center; "> QTD. DE EVENTO: ' . $resultadoNivel['qtd'] . '</td>';
                echo '</tr>';
                echo '</table> ';
            }

            echo '<table style="width:100%; font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; border-bottom: 1px solid black; border-left: 1px solid black;  border-right: 1px solid black;text-align:left; background-color: #2a5696; color: white; font-weight: bold; padding-bottom:2px ">';
            echo '<tr>';
            echo '<td style="width:50%; text-align:center; "> VALOR TOTAL(R$): ' . format_decimal($resultadoTotal['tot'], 2) . '</td>';
            echo '<td style="width:50%; text-align:center; "> QTD. DE EVENTO TOTAL: ' . $resultadoTotal['qtd'] . '</td>';
            echo '</tr>';
            echo '</table> ';
        }

        echo "</div>";
    }
}

function mostrareg($nivel, $nivel_vl, $vetDadosGrupo, &$vetOrdemAgrupamento, $txtNum) {
    global $vetControleGrupo, $vetControleGrupoTot, $vetRelatorio;

    if ($nivel > 0) {
        $vetOrdemAgrupamento['num'] ++;
        $vetOrdemAgrupamento['txtNum'] = $txtNum . '.' . $vetOrdemAgrupamento['num'];
        $txtNum = $vetOrdemAgrupamento['txtNum'];
    }

    echo '<div style=" font-family: Arial, Helvetica, sans-serif; font-size: 14px; border-left: 1px solid black; border-right: 1px solid black; text-align:left; background-color: white; color: black; font-weight: bold; padding-bottom:2px ">';
    echo '<b>' . str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $nivel) . $txtNum . '.' . $vetControleGrupo[$nivel] ['nome'] . '</b>: ' . $nivel_vl;
    echo '</div> ';

    if ($vetControleGrupoTot == $nivel) {

        $resultado = Array(
            'tot' => 0,
            'tot_entrega' => 0,
            'qtd' => Array(),
        );

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
            $resultado['qtd'][$row['idt']] ++;
            $resultado['tot_entrega'] ++;
            codTab($row, true);
        }

        $resultado['qtd'] = count($resultado['qtd']);

        $col_span = $col_tot - 1;
        echo "<tr><td colspan='{$col_span}' style='text-align:right; border-left: 1px solid black; border-bottom: 0px; border-top: 1px solid black'><b>Valor Total (R$)</b></td><td style='text-align:right; padding-right:10px; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black'>" . format_decimal($resultado['tot'], 2) . "</td></tr>";
        echo "<tr><td colspan='{$col_span}' style='text-align:right; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 0px'><b>Qtd de Entrega</b></td><td style='text-align:right; padding-right:10px; border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;'>" . $resultado['tot_entrega'] . "</td></tr>";

        echo "</table> ";
    } else {

        $resultado = Array(
            'tot' => 0,
            'qtd' => 0,
        );

        $nivelnovo = $nivel + 1;
        ForEach ($vetDadosGrupo as $nivel_vl_novo => $row_novo) {
            $resul = mostrareg($nivelnovo, $nivel_vl_novo, $row_novo, $vetOrdemAgrupamento[$nivel_vl], $txtNum);

            $resultado['tot'] += $resul['tot'];
            $resultado['qtd'] += $resul['qtd'];
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
    global $qtd_reg, $vetRelatorio, $col_selecionada, $eventow, $col_selecionada_tot, $total_evento, $tot_valor_evento, $qtd_evento, $vetAFProcessoSit, $vetAFProcessoFI;

    $codigo_evento = $row['codigo_evento'];
    $setor = $row['setor'];
    $unidade_regional = $row['unidade_regional'];
    $produto = $row['produto'];
    $servico_contratado = $row['servico_contratado'];
    $evento = $row['evento'];
    $grc_ersit_descricao = $row['grc_ersit_descricao'];

    //  Status Financeiro
    if ($row['status_financeiro'] == '') {
        $status_financeiro = 'O credenciado não consultou este processo';
    } else {
        $status_financeiro = $vetAFProcessoSit[$row['status_financeiro']];

        if ($row['status_financeiro'] == 'FI') {
            $status_financeiro .= '<br />' . $vetAFProcessoFI[$row['gfi_situacao']];
        }
    }

    // Respnsavel pelo evento
    $gestor_evento = $row['gestor_evento'];

    // Valor Serviço
    if ($row['valor_servico'] == '') {
        $valor_servico = '0,00';
    } else {
        $valor_servico = format_decimal($row['valor_servico'], 2);
    }

    // Data Entrega
    $mes_ano = $row['mes_ano'];

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
                    echo " <td class='linha_cab_tabela' style='background-color: #2a5696; color: white; font-weight: bold;'>";
                    echo $campoCel;
                    echo " </td> ";
                }
            }
            echo "</tr>";
        }

        if ($eventow != $evento) {
            if ($eventow != "##") {
                $cct = $col_selecionada_tot;
                $cc = $cct - 1;

                // Sem Agrupamento
                echo "<tr class='linha_tabela' style=''>";
                echo "<td colspan='{$cc}' style='text-align:right; border-left: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black'><b> Valor Total (R$)</b></td>";
                echo "<td  style='text-align:right; padding-right:10px; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black'>" . format_decimal($total_evento, 2) . "</td>";
                echo "</tr>";

                $total_evento = 0;
            }

            $eventow = $evento;
        }
    }

    echo "<tr class='linha_tabela' style=''>  ";

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
                    if ($conteudo != "" && $conteudo > 0) {
                        $total_evento = $total_evento + desformat_decimal($conteudo);
                        $tot_valor_evento = $tot_valor_evento + desformat_decimal($conteudo);
                        $qtd_evento[$codigo_evento] ++;
                    }
                }

//                if ($style != '') {
//                    $conteudo = "<span style='{$style}'>{$conteudo}</span>";
//                }
//
//                if ($styleC != '') {
//                    $conteudo = "<div style='{$styleC}'>{$conteudo}</div>";
//                }

                $campoCel .= $br . $conteudo;
                $br = "<br />";
            }
        }

        if ($insert_td) {
            echo " <td class='linha_tabela' style='border-right:1px solid black; Border-left:1px solid black; {$styleC} {$style}'>";
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
                var arquivo = 'grc_sebraetec_r03';
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
        xpadding:0;
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
