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

$Filtro = Array();
$Filtro['rs'] = 'ListarCmb';
$Filtro['arq'] = 'grc_produto_insumo_copia_cmb';
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Produto Origem';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_produto_org'] = $Filtro;

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

require_once 'fncCampo.php';

$ListarBtSelecionar = 'Copiar Insumo';
$prefixo = 'listar_cmbmulti_acao';

$Filtro = Array();
$Filtro['rs'] = 'Hidden';
$Filtro['id'] = 'session_cod';
$Filtro['valor'] = trata_id($Filtro);

if ($Filtro['valor'] == '') {
    $Filtro['valor'] = GerarStr();

    $vetRetorno = Array(
        vetRetorno('idt', '', false),
        vetRetorno('familia', '', true),
        vetRetorno('descricao_prd', '', true),
    );

    $_SESSION[CS]['objListarCmbMulti'][$Filtro['valor']] = Array(
        'vet_retorno' => $vetRetorno,
        'sel_final' => Array(),
        'sel_trab' => Array(),
    );
}

$vetFiltro['session_cod'] = $Filtro;
$_GET['session_cod'] = $vetFiltro['session_cod']['valor'];

$vetCampo['familia'] = CriaVetTabela('Código GRC<br />Código SIAC');
$vetCampo['descricao_prd'] = CriaVetTabela('Descrição do Produto');
$vetCampo['instrumento'] = CriaVetTabela('Instrumento<br />Foco Temático');
$vetCampo['grc_pra_descricao'] = CriaVetTabela('Entidade<br />Autora');
$vetCampo['unidade'] = CriaVetTabela('Autora<br />Respo.');
$vetCampo['grc_prsit_descricao'] = CriaVetTabela('Situação');
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
$sql .= "    grc_prf.descricao as grc_prf_descricao  ";
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
$sqlwhere .= " and {$AliasPric}.idt <> ".null($vetFiltro['idt_produto_org']['valor']);

if ($vetFiltro['idt_secao_responsavel']['valor'] != "" and $vetFiltro['idt_secao_responsavel']['valor'] != "-1") {
    $sqlwhere .= ' and ';
    $sqlwhere .= ' idt_secao_responsavel = '.null($vetFiltro['idt_secao_responsavel']['valor']);
}

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

$sql .= $sqlwhere;
?>
<script type="text/javascript">
    function ListarBtSelecionarMultiAcao() {
        if ($('#idt0').val() == '') {
            alert('Favor selecionar o Produto Origem!');
            return false;
        }

        if ($('.ListarCmbMulti > li').length == 0) {
            alert('Favor selecionar um registro!');
            return false;
        }
        
        if (!confirm('Deseja copiar os Insumos do Produto Origem para os produtos selecionados?')) {
            return false;
        }

        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=grc_produto_insumo_copia',
            data: {
                cas: conteudo_abrir_sistema,
                session_cod: '<?php echo $_GET['session_cod']; ?>',
                idt_produto_org: $('#idt0').val()
            },
            success: function (response) {
                if (response.erro == '') {
                    $('#idt0_bt_limpar').click();
                } else {
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        $("#dialog-processando").remove();
    }

    function fncListarCmbMuda_idt0(idt) {
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=produto_dados',
            data: {
                cas: conteudo_abrir_sistema,
                session_cod: '<?php echo $_GET['session_cod']; ?>',
                idt: idt
            },
            success: function (response) {
                $('#idt1').val(url_decode(response.idt_secao_responsavel));

                if (response.erro == '') {
                    document.frm.submit();
                } else {
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });
    }
</script>