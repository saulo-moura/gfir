<?php
$idCampo = 'idt';
$Tela = "o Produto";

$TabelaPrinc = "grc_produto";
$AliasPric = "grc_pro";
$Entidade = "Produto";
$Entidade_p = "Produtos";
$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

if ($_GET['idt_instrumento_prod_cmb'] == 2 || $_GET['idt_instrumento_prod_cmb'] == 40 || $_GET['idt_instrumento_prod_cmb'] == 50 || $_GET['veiocad'] == 'grc_atendimento_evento') {
    $sql = '';
    $sql .= ' select idt, descricao';
    $sql .= ' from ' . db_pir_gec . 'gec_programa';
    $sql .= " where ativo = 'S'";

    if ($_GET['veiocad'] == 'grc_atendimento_evento') {
        $sql .= " and tipo_ordem = 'SG'";
    }

    $sql .= ' order by descricao';
    $rs = execsql($sql);
    $Filtro = Array();
    $Filtro['rs'] = $rs;
    $Filtro['id'] = 'idt';
    $Filtro['js_tam'] = '0';
    $Filtro['LinhaUm'] = '-- Todos os Programas --';
    $Filtro['nome'] = 'Programas';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['programa'] = $Filtro;
}

if ($_GET['veiocad'] == 'grc_atendimento_evento') {
    $sql = '';
    $sql .= ' select idt, descricao';
    $sql .= ' from grc_atendimento_instrumento';
    $sql .= " where idt in (2, 40, 47, 46, 49, 50, 45, 41)";
    $sql .= ' order by descricao';
    $Filtro = Array();
    $Filtro['rs'] = execsql($sql);
    $Filtro['id'] = 'idt';
    $Filtro['nome'] = 'Instrumento';
    $Filtro['LinhaUm'] = ' ';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['idt_instrumento'] = $Filtro;
}

// Filtro de texto
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

// Vetor com campos da tela
$vetCampo['familia'] = CriaVetTabela('Família<br />Código');
$vetCampo['copia'] = CriaVetTabela('COP.');
$vetCampo['descricao2'] = CriaVetTabela('Descrição do Produto');
$vetCampo['unidade'] = CriaVetTabela('Autora<br />Respo.');
$vetCampo['grc_presp_descricao'] = CriaVetTabela('Tipo do Produto');
$vetCampo['grc_prsit_descricao'] = CriaVetTabela('Situação');
$vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);
$vetCampo['ficha'] = CriaVetTabela('Ficha Técnica', 'func_trata_dado', ftd_grc_produto);

//$vetListarCmbRegValido = Array(
//    'tipo' => Array('A'),
//);

$sql = "select ";
$sql .= "   {$AliasPric}.*, null as ficha,  ";
$sql .= "    grc_prsit.descricao as grc_prsit_descricao, ";
$sql .= "    sca_os.sigla as sca_os_sigla, ";
$sql .= "    sca_osr.sigla as sca_osr_sigla,  ";
$sql .= "    CONCAT_WS('<br />',sca_os.sigla, sca_osr.sigla) as unidade,  ";
$sql .= "    CONCAT_WS('<br />',grc_prf.codigo,grc_pro.codigo) as familia,  ";
$sql .= "    CONCAT_WS('<br />',grc_prf.descricao,grc_pro.descricao) as descricao2,  ";
$sql .= "    grc_prf.codigo as grc_prf_codigo,  ";
$sql .= "    grc_prf.descricao as grc_prf_descricao,  ";
$sql .= "    grc_presp.descricao as grc_presp_descricao,  ";
$sql .= "    grc_pro.descricao as {$campoDescListarCmb}";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " inner join grc_produto_situacao grc_prsit on grc_prsit.idt = {$AliasPric}.idt_produto_situacao ";
$sql .= " inner join grc_produto_especie grc_presp on grc_presp.idt = {$AliasPric}.idt_produto_especie ";
$sql .= " left join grc_produto_familia grc_prf on grc_prf.idt = {$AliasPric}.idt_produto_familia ";
$sql .= " left join grc_atendimento_instrumento grc_ai on grc_ai.idt = {$AliasPric}.idt_instrumento ";
$sql .= " left join " . db_pir . "sca_organizacao_secao sca_os on sca_os.idt = {$AliasPric}.idt_secao_autora ";
$sql .= " left join " . db_pir . "sca_organizacao_secao sca_osr on sca_osr.idt = {$AliasPric}.idt_secao_responsavel ";

if ($includeListarCmb === true) {
    $sql .= ' where ' . $AliasPric . '.idt = ' . null($includeListarCmbWhere);
} else {
    $sql .= ' where ( grc_prsit.codigo = ' . aspa('40') . " ) and ( {$AliasPric}.ativo = 'S') ";  // ativo para sebrae-ba
    $sql .= ' and ( idt_produto_evento is null ) ';

    if ($_GET['veiocad'] == 'grc_atendimento_evento') {
        $sql .= ' and ' . $AliasPric . '.idt_programa in (';
        $sql .= ' select idt';
        $sql .= ' from ' . db_pir_gec . 'gec_programa';
        $sql .= " where ativo = 'S'";
        $sql .= " and tipo_ordem = 'SG'";
        $sql .= ' )';

        $sql .= " and {$AliasPric}.idt_produto_especie = 1";
    } else {
        $sql .= ' and (';

        //Simples
        $sql .= ' (';
        $sql .= " {$AliasPric}.idt_produto_especie = 1";

        if ($_GET['idt_instrumento_prod_cmb'] != '') {
            $sql .= ' and SUBSTRING(grc_ai.codigo, 1, 2) = (';
            $sql .= ' select SUBSTRING(codigo, 1, 2) as cod';
            $sql .= ' from grc_atendimento_instrumento';
            $sql .= ' where idt = ' . null($_GET['idt_instrumento_prod_cmb']);
            $sql .= ' )';
        }

        $sql .= ' )';

        //Composto
		/*
          $sql .= ' or (';
          $sql .= " {$AliasPric}.idt_produto_especie = 3";

          if ($_GET['idt_instrumento_prod_cmb'] != '') {
          $sql .= " and {$AliasPric}.idt in (";
          $sql .= ' select pp.idt_produto';
          $sql .= ' from grc_produto_produto pp';
          $sql .= " inner join grc_produto p on p.idt = pp.idt_produto_associado ";
          $sql .= " left join grc_atendimento_instrumento grc_aif on grc_aif.idt = p.idt_instrumento ";
          $sql .= ' where SUBSTRING(grc_aif.codigo, 1, 2) = (';
          $sql .= ' select SUBSTRING(codigo, 1, 2) as cod';
          $sql .= ' from grc_atendimento_instrumento';
          $sql .= ' where idt = ' . null($_GET['idt_instrumento_prod_cmb']);
          $sql .= ' )';
          $sql .= ' )';
          }

          $sql .= ' )';
		*/

        $sql .= ' )';

        if ($vetFiltro['programa']['valor'] != "" and $vetFiltro['programa']['valor'] != "-1") {
            $sql .= ' and ' . $AliasPric . '.idt_programa = ' . null($vetFiltro['programa']['valor']);
        }
    }

    if ($vetFiltro['texto']['valor'] != "") {
        $sql .= ' and ';
        $sql .= ' ( ';
        $sql .= '  lower(' . $AliasPric . '.codigo)      like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
        $sql .= ' or lower(' . $AliasPric . '.descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
        $sql .= ' ) ';
    }

    if ($vetFiltro['idt_instrumento']['valor'] > 0) {
        $sql .= ' and SUBSTRING(grc_ai.codigo, 1, 2) = (';
        $sql .= ' select SUBSTRING(codigo, 1, 2) as cod';
        $sql .= ' from grc_atendimento_instrumento';
        $sql .= ' where idt = ' . null($vetFiltro['idt_instrumento']['valor']);
        $sql .= ' )';
    }

    //Só pode Consultoria de Longa Duração para o SebraeTec
    $sql .= ' and ((' . $AliasPric . '.idt_programa = 4';
    $sql .= ' and SUBSTRING(grc_ai.codigo, 1, 2) = (';
    $sql .= ' select SUBSTRING(codigo, 1, 2) as cod';
    $sql .= ' from grc_atendimento_instrumento';
    $sql .= ' where idt = 2';
    $sql .= ' )) or (' . $AliasPric . '.idt_programa <> 4))';
}