<?php
$idCampo = 'idt';
$Tela = "o Produto";

$TabelaPrinc = "grc_produto";
$AliasPric = "grc_pro";
$Entidade = "Produto";
$Entidade_p = "Produtos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$prefixow = 'listar';
$mostrar = false;
$cond_campo = '';
$cond_valor = '';

$barra_inc_ap = false;
$barra_alt_ap = true;
$barra_con_ap = false;
$barra_exc_ap = false;
$barra_fec_ap = false;

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$sql = "select distinct sca_os.idt,  sca_os.descricao from ".db_pir."sca_organizacao_secao sca_os ";
$sql .= " inner join grc_produto grc_p on grc_p.idt_secao_responsavel = sca_os.idt ";
$sql .= " order by classificacao";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm'] = '-- Todas as Unidades Respons�veis --';
$Filtro['nome'] = 'Unidade Respons�vel';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_secao_responsavel'] = $Filtro;

$vetCampo['familia'] = CriaVetTabela('C�digo GRC<br />C�digo SIAC');
$vetCampo['descricao_prd'] = CriaVetTabela('Descri��o do Produto');
$vetCampo['instrumento'] = CriaVetTabela('Instrumento<br />Foco Tem�tico');
$vetCampo['grc_pra_descricao'] = CriaVetTabela('Entidade<br />Autora');
$vetCampo['unidade'] = CriaVetTabela('Autora<br />Respo.');
$vetCampo['grc_prsit_descricao'] = CriaVetTabela('Situa��o');
$vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

$sql = "select ";
$sql .= "   {$AliasPric}.*,  ";
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
$sql .= "    CONCAT_WS('<br />',grc_prg.descricao,grc_pro.descricao) as descricao_prd,  ";
$sql .= "    grc_prg.descricao as grc_prg_descricao,  ";
$sql .= "    grc_prf.codigo as grc_prf_codigo,  ";
$sql .= "    grc_prf.descricao as grc_prf_descricao,  ";
$sql .= "    concat_ws(' - ', concat_ws('<br />',CONCAT_WS('/',grc_pro.codigo,grc_pro.copia),grc_pro.codigo_classificacao_siac), CONCAT_WS('<br />',grc_prg.descricao,grc_pro.descricao)) as {$campoDescListarCmb}";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " inner join grc_produto_situacao grc_prsit on grc_prsit.idt = {$AliasPric}.idt_produto_situacao ";
$sql .= " left join grc_produto_familia grc_prf on grc_prf.idt = {$AliasPric}.idt_produto_familia ";
$sql .= " left join grc_produto_grupo grc_prg on grc_prg.idt = {$AliasPric}.idt_grupo ";
$sql .= " left join grc_atendimento_instrumento grc_pri on grc_pri.idt = {$AliasPric}.idt_instrumento ";
$sql .= " left join grc_foco_tematico grc_prft on grc_prft.idt = {$AliasPric}.idt_foco_tematico ";
$sql .= " left join grc_produto_abrangencia grc_pra on grc_pra.idt = {$AliasPric}.idt_produto_abrangencia ";
$sql .= " left join ".db_pir."sca_organizacao_secao sca_os on sca_os.idt = {$AliasPric}.idt_secao_autora ";
$sql .= " left join ".db_pir."sca_organizacao_secao sca_osr on sca_osr.idt = {$AliasPric}.idt_secao_responsavel ";

$sqlwhere = ' where idt_produto_evento is null ';
$sqlwhere .= ' and grc_prsit'.".situacao_etapa = 'D'";

if ($vetFiltro['idt_secao_responsavel']['valor'] != "" and $vetFiltro['idt_secao_responsavel']['valor'] != "-1") {
    $sqlwhere .= ' and ';
    $sqlwhere .= ' idt_secao_responsavel = '.null($vetFiltro['idt_secao_responsavel']['valor']);
}

if ($sqlOrderby == '') {
    $sqlOrderby = "grc_prg.descricao asc, {$AliasPric}.codigo asc";
}

$vetOrderby = Array(
    "{$AliasPric}.codigo" => 'C�DIGO',
    "{$AliasPric}.codigo_siac" => 'C�DIGO SIAC',
    "{$AliasPric}.codigo_classificacao_siac" => 'C�DIGO CLASSIFICA��O SIAC',
    "{$AliasPric}.descricao" => 'T�TULO DO PRODUTO',
    "grc_prg.descricao" => 'PROGRAMA',
);

$sql .= $sqlwhere;