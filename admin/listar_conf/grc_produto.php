<?php
define('produtocomposto', mb_strtoupper($_GET['produtocomposto']));
$veio_p = $_GET['veio_p'];

$idCampo = 'idt';
$Tela = "o Produto";

$TabelaPrinc = "grc_produto";
$AliasPric = "grc_pro";
$Entidade = "Produto";
$Entidade_p = "Produtos";

$sistema_origem = DecideSistema();

// Barra de inclusão
$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
// Linha de Total
$contlinfim = "Existem #qt {$Entidade_p}.";

// Descida para o nivel 2

$prefixow = 'listar';
$mostrar = false;
$cond_campo = '';
$cond_valor = '';

if ($_SESSION[CS]['g_gestor_produto'] == 'S') {
    $barra_exc_ap = true;
} else {
    $barra_exc_ap = false;
}


$tipoidentificacao = 'N';
$tipofiltro = 'S';

$comfiltro = 'A';
$comidentificacao = 'F';
//
// Filtro de texto
//

$sql = "select idt,  descricao from ".db_pir_gec."gec_programa ";
$sql .= " order by codigo";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm'] = '-- Todos os Programas --';
$Filtro['nome'] = 'Programas';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['programa'] = $Filtro;

$sql = "select distinct sca_os.idt,  sca_os.descricao from ".db_pir."sca_organizacao_secao sca_os ";
$sql .= " inner join grc_produto grc_p on grc_p.idt_secao_responsavel = sca_os.idt ";
$sql .= " order by classificacao";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm'] = '-- Todas as Unidades Responsáveis --';
$Filtro['nome'] = 'Unidade Responsável';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_secao_responsavel'] = $Filtro;



$sql = "select idt, codigo, descricao from grc_atendimento_instrumento ";
$sql .= " where nivel = 1";
$sql .= " order by codigo";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm'] = '-- Todos os Instrumentos --';
$Filtro['nome'] = 'Instrumentos';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['instrumentos'] = $Filtro;





$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$sql = "select idt, descricao from grc_produto_especie ";

if ($veio == "D") {
    if (produtocomposto == 'S') {
        $sql .= " where codigo = '03'";
    } else {
        $sql .= " where codigo <> '03'";
    }
} else {
    if ($veio_p == 10) {
        $sql .= " where codigo in ('01', '03')";
    }
}

$sql .= " order by descricao";
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm'] = '-- Todos os Tipos --';
$Filtro['nome'] = 'Tipo de Produto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['tipo'] = $Filtro;

// Vetor com campos da tela

$vetCampo['familia'] = CriaVetTabela('Código GRC<br />Código SIAC');
$vetCampo['descricao'] = CriaVetTabela('Descrição do Produto', 'func_trata_dado', ftd_grc_produto);
$vetCampo['instrumento'] = CriaVetTabela('Instrumento<br />Foco Temático');
$vetCampo['grc_pra_descricao'] = CriaVetTabela('Entidade<br />Autora');
$vetCampo['unidade'] = CriaVetTabela('Autora<br />Respo.');
$vetCampo['grc_presp_descricao'] = CriaVetTabela('Tipo do Produto');
$vetCampo['grc_prsit_descricao'] = CriaVetTabela('Situação');
$vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);
$vetCampo['ficha'] = CriaVetTabela('Ficha Técnica', 'func_trata_dado', ftd_grc_produto);

$sql = "select ";
$sql .= "   {$AliasPric}.*, null as ficha, ";
$sql .= "    grc_prsit.codigo as grc_prsit_codigo, ";
$sql .= "    grc_prsit.descricao as grc_prsit_descricao, ";
$sql .= "    grc_pri.descricao as grc_pri_descricao, ";
$sql .= "    grc_prft.descricao as grc_prft_descricao, ";
$sql .= "    CONCAT_WS('<br />',grc_pri.descricao,grc_prft.descricao) as instrumento,  ";
$sql .= "    grc_pra.descricao as grc_pra_descricao, ";
$sql .= "    sca_os.sigla as sca_os_sigla, ";
$sql .= "    sca_osr.sigla as sca_osr_sigla,  ";
$sql .= "    CONCAT_WS('<br />',sca_os.sigla, sca_osr.sigla) as unidade,  ";
$sql .= "    concat_ws('<br />',CONCAT_WS('/',grc_pro.codigo,grc_pro.copia),grc_pro.codigo_classificacao_siac) as familia,  ";
$sql .= "    CONCAT_WS('<br />',grc_prg.descricao,grc_pro.descricao) as descricao,  ";
$sql .= "    grc_presp.descricao as grc_presp_descricao,  ";
$sql .= "    grc_prg.descricao as grc_prg_descricao,  ";
$sql .= "    grc_prf.codigo as grc_prf_codigo,  ";
$sql .= "    grc_prf.descricao as grc_prf_descricao  ";

$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " inner join grc_produto_situacao grc_prsit on grc_prsit.idt = {$AliasPric}.idt_produto_situacao ";
$sql .= " inner join grc_produto_especie grc_presp on grc_presp.idt = {$AliasPric}.idt_produto_especie ";
$sql .= " left join grc_produto_familia grc_prf on grc_prf.idt = {$AliasPric}.idt_produto_familia ";
$sql .= " left join grc_produto_grupo grc_prg on grc_prg.idt = {$AliasPric}.idt_grupo ";
$sql .= " left join grc_atendimento_instrumento grc_pri on grc_pri.idt = {$AliasPric}.idt_instrumento ";
$sql .= " left join grc_foco_tematico grc_prft on grc_prft.idt = {$AliasPric}.idt_foco_tematico ";
$sql .= " left join grc_produto_abrangencia grc_pra on grc_pra.idt = {$AliasPric}.idt_produto_abrangencia ";
$sql .= " left join ".db_pir."sca_organizacao_secao sca_os on sca_os.idt = {$AliasPric}.idt_secao_autora ";
$sql .= " left join ".db_pir."sca_organizacao_secao sca_osr on sca_osr.idt = {$AliasPric}.idt_secao_responsavel ";

if ($veio == "D") {
    $sqlwhere = ' where idt_produto_evento is null ';

    if (produtocomposto == 'S') {
        $sqlwhere .= " and grc_presp.codigo = '03'";
    } else {
        $sqlwhere .= " and grc_presp.codigo <> '03'";
    }
} else {
    // depois criar entrada para os de eventos
//    $sqlwhere = ' where (idt_produto_evento is null or idt_produto_evento is not null) ';

    $sqlwhere = ' where (idt_produto_evento is null) ';
}

if ($vetFiltro['programa']['valor'] != "" and $vetFiltro['programa']['valor'] != "-1") {
    $sqlwhere .= ' and ';
    $sqlwhere .= ' idt_programa = '.null($vetFiltro['programa']['valor']);
}

if ($vetFiltro['idt_secao_responsavel']['valor'] != "" and $vetFiltro['idt_secao_responsavel']['valor'] != "-1") {
    $sqlwhere .= ' and ';
    $sqlwhere .= ' idt_secao_responsavel = '.null($vetFiltro['idt_secao_responsavel']['valor']);
}

if ($vetFiltro['tipo']['valor'] != "" and $vetFiltro['tipo']['valor'] != "-1") {
    $sqlwhere .= ' and ';
    $sqlwhere .= " {$AliasPric}.idt_produto_especie = ".null($vetFiltro['tipo']['valor']);
}



if ($vetFiltro['instrumentos']['valor'] != "" and $vetFiltro['instrumentos']['valor'] != "-1") {
    $sqlwhere .= ' and ';
    $sqlwhere .= ' idt_instrumento = '.null($vetFiltro['instrumentos']['valor']);
}


if ($vetFiltro['texto']['valor'] != "") {
    $sqlwhere .= ' and ';
    $sqlwhere .= ' ( ';
    $sqlwhere .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sqlwhere .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';


    $sqlwhere .= ' or lower('.$AliasPric.'.origem) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sqlwhere .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sqlwhere .= ' or lower('.$AliasPric.'.objetivo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sqlwhere .= ' or lower('.$AliasPric.'.complemento) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sqlwhere .= ' or lower('.$AliasPric.'.palavra_chave) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sqlwhere .= ' or lower('.$AliasPric.'.publico_alvo_texto) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sqlwhere .= ' or lower('.$AliasPric.'.descricao_comercial) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sqlwhere .= ' or lower('.$AliasPric.'.descricao_siac) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sqlwhere .= ' or lower('.$AliasPric.'.codigo_siac) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sqlwhere .= ' or lower('.$AliasPric.'.conteudo_programatico) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sqlwhere .= ' or lower('.$AliasPric.'.codigo_classificacao_siac) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';



    $sqlwhere .= ' ) ';
}

if ($veio == "D") {
    if ($sqlwhere <> '') {
        $sqlwhere .= ' and grc_prsit'.".situacao_etapa = 'D'";
    } else {
        $sqlwhere .= ' Where grc_prsit'.".situacao_etapa = 'D'";
    }
} else {
    $repasse = $_GET['repasse'];
    // o get esta dando problema
    //p($sistema_origem);
//	if ($sistema_origem=='GEC')
//	{
//	    $repasse = 'R';
//	}
    If ($repasse != 'R') {
        IF ($sqlwhere <> '') {
            $sqlwhere .= ' and grc_prsit'.".situacao_etapa <> 'D'";
        } else {
            $sqlwhere .= ' Where grc_prsit'.".situacao_etapa <> 'D'";
        }
    }
    if ($veio_p == 10) {
        if ($sqlwhere <> '') {
            $sqlwhere .= " and grc_prsit.codigo in ('40') "; //, '50'
        } else {
            $sqlwhere .= " Where grc_prsit.codigo in ('40') "; //, '50'
        }

        $sqlwhere .= " and grc_presp.codigo in ('01', '03')";

        $barra_inc_ap = false;
        $barra_con_ap = true;
        $barra_exc_ap = false;
        $barra_fec_ap = false;

        if ($_SESSION[CS]['g_tipo_usuario'] == 'A' && $_SESSION[CS]['alt_status_produto'] == 'S') {
            $barra_alt_ap = true;
        } else {
            $barra_alt_ap = false;
        }

        $veio_atendimento = $_GET['veio_atendimento'];
        if ($veio_atendimento == 1) {
            $barra_alt_ap = false;
        }
    } else {
        $barra_inc_ap = false;
        $barra_alt_ap = true;
        $barra_con_ap = true;
        $barra_exc_ap = false;
        $barra_fec_ap = false;
        $veio_atendimento = $_GET['veio_atendimento'];
        if ($veio_atendimento == 1) {
            $barra_alt_ap = false;
        }
    }
}
if ($repasse == 'R') {
    $barra_inc_ap = true;
    $barra_alt_ap = true;
    $barra_con_ap = true;
    $barra_exc_ap = true;
    $barra_fec_ap = false;
    $sqlwhere .= " and repasse = ".aspa('S');
} else {
    $sqlwhere .= " and repasse <> ".aspa('S');
}
//p($_GET);
//p($sqlwhere);
//$orderby = "descricao, codigo";
//$orderby = "grc_prg.descricao, {$AliasPric}.codigo";


/*
  if ($sqlOrderby == '') {
  $sqlOrderby = "grc_prg.descricao asc, {$AliasPric}.codigo asc";
  }


  $vetOrderby = Array(
  "{$AliasPric}.codigo" => 'CÓDIGO',
  "{$AliasPric}.codigo_siac" => 'CÓDIGO SIAC',
  "{$AliasPric}.codigo_classificacao_siac" => 'CÓDIGO CLASSIFICAÇÃO SIAC',
  "{$AliasPric}.descricao" => 'TÍTULO DO PRODUTO',
  "grc_prg.descricao" => 'PROGRAMA',
  );
 * 
 */

//$sql .= $sqlwhere." order by {$orderby}";


$sql .= $sqlwhere;

//echo "'".$sql."'<br />";
