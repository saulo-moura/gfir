<style type="text/css">
    fieldset.class_frame_p {
        background:#FFFFFF;
        border:0px solid #FFFFFF;
    }

    div.class_titulo_p {
        background: #2F66B8;
        text-align: left;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        color     : #FFFFFF;
        text-align: left;
        height    : 20px;
        font-size : 12px;
        padding-top:5px;
    }

    div.class_titulo_p span {
        padding:10px;
        text-align: left;
    }

    fieldset.class_frame {
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }

    div.class_titulo {
        text-align: left;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo span {
        padding-left:10px;
    }

    div.class_titulo_p_barra {
        text-align: left;
        background: #c4c9cd;
        border    : none;
        color     : #FFFFFF;
        font-weight: bold;
        line-height: 12px;
        margin: 0;
        padding: 3px;
        padding-left: 20px;
    }

    #idt_produto_obj,
    #idt_projeto_obj,
    #idt_acao_obj {
        white-space: nowrap;
    }

    #tab_resumo_desc {
        vertical-align: middle;
    }

    #lbl_painel_desc {
        text-align: center;
        color: black;
        font-weight: bold;
        font-size: 16px;
        vertical-align: middle;
    }

    #lbl_painel_desc div {
        padding-bottom: 5px;
        border-bottom: 1px solid #2f66b8;
    } 

    div.Barra {
        display: none;
    }
</style>
<?php
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$titulo_na_linha_p = false;

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$barra_bt_top = false;

$botao_acao = '<script type="text/javascript">parent.hidePopWin(false);</script>';

$onSubmitDep = 'grc_atendimento_evento_dep()';

unset($_SESSION[CS]['tmp']['abre_contrato_sg'][$_GET['idt_atendimento']]);

$sql = '';
$sql .= ' select *';
$sql .= ' from grc_atendimento_evento';
$sql .= ' where idt_atendimento = ' . null($_GET['idt_atendimento']);
$sqlRow = $sql;
$rs = execsql($sqlRow);
$rowDados = $rs->data[0];

if ($rs->rows == 0) {
    $sql = '';
    $sql .= ' select a.idt_ponto_atendimento, un.idt as idt_unidade';
    $sql .= ' from grc_atendimento a';
    $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao pa on pa.idt = a.idt_ponto_atendimento';
    $sql .= " inner join " . db_pir . "sca_organizacao_secao un on un.classificacao = concat(substring(pa.classificacao, 1, 5), '.00.000')";
    $sql .= ' where a.idt = ' . null($_GET['idt_atendimento']);
    $rs = execsql($sql);
    $row = $rs->data[0];

    $vetDados = Array(
        'idt_atendimento' => null($_GET['idt_atendimento']),
        'ano_competencia' => aspa(date('Y')),
        'idt_unidade' => aspa($row['idt_unidade']),
        'idt_ponto_atendimento' => aspa($row['idt_ponto_atendimento']),
        'idt_ponto_atendimento_tela' => aspa($row['idt_ponto_atendimento']),
    );

    $sql = 'insert into grc_atendimento_evento (' . implode(', ', array_keys($vetDados)) . ') values (' . implode(', ', $vetDados) . ')';
    execsql($sql);

    $rs = execsql($sqlRow);
    $rowDados = $rs->data[0];
}

if ($rowDados['idt_evento'] == '') {
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_evento';
    $sql .= ' where idt_atendimento_evento = ' . null($rowDados['idt']);
    $rs = execsql($sql);
    $rowDados['idt_evento'] = $rs->data[0][0];

    $sql = 'update grc_atendimento_evento set idt_evento = ' . null($rowDados['idt_evento']);
    $sql .= ' where idt = ' . null($rowDados['idt']);
    execsql($sql);
}

$sql = '';
$sql .= ' select vl_teto';
$sql .= ' from grc_produto';
$sql .= ' where idt = ' . null($rowDados['idt_produto']);
$rs = execsql($sql);
$rowDados['vl_teto'] = $rs->data[0][0];

$_GET['id'] = $rowDados['idt'];

if ($rowDados['idt_evento'] == '') {
    $_GET['acao'] = 'alt';
    $acao = $_GET['acao'];
} else if ($rowDados['bt_acao_cadastro'] == 'bt_aprovacao') {
    $acao_alt_con = 'S';
} else {
    $_GET['acao'] = 'con';
    $acao = $_GET['acao'];
    alert('Não pode alterar, pois o evento já foi criado!');
}

$tabela = 'grc_atendimento_evento';
$id = 'idt';

$vetFrm = Array();

$vetCampo['lbl_painel'] = objBarraTitulo('lbl_painel', 'Painel Anual');

$vetCampo['qtd_previsto'] = objTextoFixo('qtd_previsto', 'Métrica:<br />Previsão (Fonte: SGE)', 17, true);
$vetCampo['qtd_realizado'] = objTextoFixo('qtd_realizado', '<br />Execução (Fonte: CRM)', 15, true);
$vetCampo['qtd_percentual'] = objTextoFixo('qtd_percentual', '<br />(%)', 10, true);
$vetCampo['qtd_saldo'] = objTextoFixo('qtd_saldo', '<br />Saldo (Fonte: SGE - CRM)', 15, true);

$vetCampo['orc_previsto'] = objTextoFixo('orc_previsto', 'Orçamento:<br />Previsão (Fonte: RM)', 17, true);
$vetCampo['orc_realizado'] = objTextoFixo('orc_realizado', '<br />Execução (Fonte: RM)', 15, true);
$vetCampo['orc_percentual'] = objTextoFixo('orc_percentual', '<br />(%)', 10, true);
$vetCampo['orc_saldo'] = objTextoFixo('orc_saldo', '<br />Saldo (Fonte: RM)', 15, true);

MesclarCol($vetCampo['lbl_painel'], 7);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['lbl_painel']),
    Array($vetCampo['qtd_previsto'], '', $vetCampo['qtd_realizado'], '', $vetCampo['qtd_percentual'], '', $vetCampo['qtd_saldo']),
    Array($vetCampo['orc_previsto'], '', $vetCampo['orc_realizado'], '', $vetCampo['orc_percentual'], '', $vetCampo['orc_saldo']),
        ), $class_frame . ' display_none', $class_titulo, $titulo_na_linha);

$vetCampo['bt_acao_cadastro'] = objHidden('bt_acao_cadastro');
$vetCampo['idt_gestor_projeto'] = objHidden('idt_gestor_projeto', '');
$vetCampo['gestor_sge'] = objHidden('gestor_sge', '');
$vetCampo['fase_acao_projeto'] = objHidden('fase_acao_projeto', '');
$vetCampo['idt_instrumento'] = objHidden('idt_instrumento', '');
$vetCampo['contrapartida_sgtec'] = objHidden('contrapartida_sgtec', '');

MesclarCol($vetCampo['idt_instrumento'], 3);
MesclarCol($vetCampo['contrapartida_sgtec'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['bt_acao_cadastro'], '', $vetCampo['gestor_sge'], '', $vetCampo['fase_acao_projeto'], '', $vetCampo['idt_gestor_projeto']),
    Array($vetCampo['idt_instrumento'], '', $vetCampo['contrapartida_sgtec']),
        ), $class_frame . ' display_none', $class_titulo, $titulo_na_linha);

$vetParametros = Array(
    'codigo_frm' => 'frm_grc_atendimento_evento',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>Consultoria SEBRAETEC</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo['idt_projeto'] = objListarCmb('idt_projeto', 'grc_projeto', 'Projeto', true, '260px');
$vetCampo['idt_acao'] = objListarCmb('idt_acao', 'grc_projeto_acao', 'Ação do Projeto', true, '260px');
$vetCampo['idt_produto'] = objListarCmb('idt_produto', 'grc_produto_evento_cmb', 'Produto', true, '260px');

$sql = "select idt,codigo,descricao from " . db_pir_gec . "gec_meio_informacao ";
$sql .= " order by codigo";
$vetCampo['idt_midia'] = objCmbBanco('idt_midia', 'Mídia', true, $sql, ' ', 'width:315px;');

$sql = '';
$sql .= ' select id_usuario, nome_completo';
$sql .= ' from plu_usuario';
$sql .= ' where (idt_unidade_lotacao in (';
$sql .= " select idt from " . db_pir . "sca_organizacao_secao ";
$sql .= ' where SUBSTRING(classificacao, 1, 5) = (';
$sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
$sql .= ' from ' . db_pir . 'sca_organizacao_secao';
$sql .= ' where idt = ' . null($rowDados['idt_unidade']);
$sql .= ' )';
$sql .= ' )';
$sql .= " and ativo = 'S')";
$sql .= ' or id_usuario = ' . null($rowDados['idt_gestor_evento']);
$sql .= ' order by nome_completo';
$vetCampo['idt_gestor_evento'] = objCmbBanco('idt_gestor_evento', 'Responsável pelo Evento', true, $sql, ' ', 'width:315px;');

$vetCampo['tab_resumo'] = objInclude('tab_resumo', 'cadastro_conf/grc_atendimento_evento_tab_resumo.php');
$vetCampo['tab_resumo']['linha'] = 6;

MesclarCol($vetCampo['idt_midia'], 3);

$vetParametros = Array(
    'codigo_pai' => 'frm_grc_atendimento_evento',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_projeto'], '', $vetCampo['idt_produto'], '', $vetCampo['tab_resumo']),
    Array($vetCampo['idt_acao'], '', $vetCampo['idt_gestor_evento']),
    Array($vetCampo['idt_midia']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$maxlength = 1000;
$style = "";
$vetCampo['objetivo'] = objTextArea('objetivo', 'Objetivo da Consultoria(Limitado a 1000 caracteres)', true, $maxlength, $style);
$vetCampo['resultado_esperado'] = objTextArea('resultado_esperado', 'Resultados Esperados (Limitado a 1000 caracteres)', true, $maxlength, $style);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['objetivo'], '', $vetCampo['resultado_esperado']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$titulo = 'Arquivo em Anexo';

$vetCampoLC = Array();
$vetCampoLC['descricao'] = CriaVetTabela('Título do Anexo');
$vetCampoLC['arquivo'] = CriaVetTabela('Arquivo anexado', 'arquivo_sem_nome', '', 'grc_atendimento_evento_anexo');

$sql = "select *";
$sql .= " from grc_atendimento_evento_anexo";
$sql .= ' where idt_atendimento_evento = $vlID';
$sql .= " order by descricao";

$vetCampo['grc_atendimento_evento_anexo'] = objListarConf('grc_atendimento_evento_anexo', 'idt', $vetCampoLC, $sql, $titulo, false);
$vetCampo['grc_atendimento_evento_anexo_tit'] = objBarraTitulo('grc_atendimento_evento_anexo_tit', mb_strtoupper($titulo), 'class_titulo_p_barra');

$vetCampo['bt_ficha'] = objInclude('bt_ficha', 'cadastro_conf/grc_evento_bt_ficha.php');

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_atendimento_evento_anexo_tit'], ''),
    Array($vetCampo['grc_atendimento_evento_anexo'], '', $vetCampo['bt_ficha']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'frm_grc_atendimento_evento_entrega',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>Entregas</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$titulo = 'Entregas';

$vetCampoLC = Array();
$vetCampoLC['ordem'] = CriaVetTabela('Ordem');
$vetCampoLC['codigo'] = CriaVetTabela('Código');
$vetCampoLC['descricao'] = CriaVetTabela('Nome');
$vetCampoLC['detalhe'] = CriaVetTabela('Descrição');
$vetCampoLC['percentual'] = CriaVetTabela('Percentual', 'decimal', '', '', '', '2', '', true);

$sql = "select *";
$sql .= " from grc_atendimento_evento_entrega";
$sql .= ' where idt_atendimento_evento = $vlID';
$sql .= " order by descricao";

$vetCampo['grc_atendimento_evento_entrega'] = objListarConf('grc_atendimento_evento_entrega', 'idt', $vetCampoLC, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'frm_grc_atendimento_evento_entrega',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_atendimento_evento_entrega']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'frm_grc_atendimento_evento_dimensionamento',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>Dimensionamento da Demanda</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$titulo = 'Dimensionamento da Demanda';

$vetCampoLC = Array();
$vetCampoLC['codigo'] = CriaVetTabela('Código');
$vetCampoLC['descricao'] = CriaVetTabela('Descrição');
$vetCampoLC['grc_iu_descricao'] = CriaVetTabela('Unidade');

if ($rowDados['vl_determinado'] == 'S') {
    $vetCampoLC['vl_unitario'] = CriaVetTabela('Custo Unitário', 'decimal');
    $vetCampoLC['qtd'] = CriaVetTabela('QTDE', 'decimal');
    $vetCampoLC['vl_total'] = CriaVetTabela('Preço', 'decimal', '', '', '', '2', '', true);
} else {
    $vetCampoLC['qtd'] = CriaVetTabela('QTDE', 'decimal');
}

$sql = "select ed.*, grc_iu.descricao as grc_iu_descricao";
$sql .= " from grc_atendimento_evento_dimensionamento ed";
$sql .= " inner join grc_insumo_unidade grc_iu on grc_iu.idt = ed.idt_insumo_unidade ";
$sql .= ' where ed.idt_atendimento_evento = $vlID';
$sql .= " order by ed.descricao";

$vetCampo['grc_atendimento_evento_dimensionamento'] = objListarConf('grc_atendimento_evento_dimensionamento', 'idt', $vetCampoLC, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'frm_grc_atendimento_evento_dimensionamento',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_atendimento_evento_dimensionamento']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

if ($rowDados['vl_determinado'] == 'S') {
    $vetParametros = Array(
        'codigo_frm' => 'frm_grc_atendimento_evento_pagamento',
        'controle_fecha' => 'A',
    );

    $vetFrm[] = Frame('<span>Loja Presencial</span>', '', $class_frame_p . ' fset_pag_conta', $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $titulo = 'Loja Presencial';

    $vetCampoLC = Array();
    $vetCampoLC['np_descricao'] = CriaVetTabela('Forma de Pagamento');
    $vetCampoLC['cb_descricao'] = CriaVetTabela('Bandeira');
    $vetCampoLC['fp_descricao'] = CriaVetTabela('Parcelas');
    $vetCampoLC['codigo_nsu'] = CriaVetTabela('Código NSU');
    $vetCampoLC['data_pagamento'] = CriaVetTabela('Data do Pagamento', 'data');
    $vetCampoLC['valor_pagamento'] = CriaVetTabela('Valor do Pagamento', 'decimal');

    $sql = "select pp.*, np.descricao as np_descricao, cb.descricao as cb_descricao, fp.codigo as fp_descricao";
    $sql .= " from grc_atendimento_evento_pagamento pp";
    $sql .= ' left outer join grc_evento_natureza_pagamento np on np.idt = pp.idt_evento_natureza_pagamento';
    $sql .= ' left outer join grc_evento_cartao_bandeira cb on cb.idt = pp.idt_evento_cartao_bandeira';
    $sql .= ' left outer join grc_evento_forma_parcelamento fp on fp.idt = pp.idt_evento_forma_parcelamento';
    $sql .= ' where pp.idt_atendimento_evento = $vlID';
    $sql .= " and pp.estornado <> 'S'";
    $sql .= " order by pp.idt";

    $vetCampo['grc_atendimento_evento_pagamento'] = objListarConf('grc_atendimento_evento_pagamento', 'idt', $vetCampoLC, $sql, $titulo, false);

    $vetParametros = Array(
        'codigo_pai' => 'frm_grc_atendimento_evento_pagamento',
        'width' => '100%',
    );

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_atendimento_evento_pagamento']),
            ), $class_frame . ' fset_pag_conta', $class_titulo, $titulo_na_linha, $vetParametros);

    $vetParametros = Array(
        'codigo_frm' => 'participante_contadevolucao',
        'controle_fecha' => 'A',
    );

    $vetFrm[] = Frame('<span>Dados para Devolução</span>', '', $class_frame_p . ' fset_pag_conta', $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetCampoLC = Array();
    $vetCampoLC['descricao'] = CriaVetTabela('Pagametos feitos por');
    $vetCampoLC['favorecido'] = CriaVetTabela('Favorecido');
    $vetCampoLC['banco_nome'] = CriaVetTabela('Banco');
    $vetCampoLC['agencia'] = CriaVetTabela('Agência');
    $vetCampoLC['cc'] = CriaVetTabela('Conta Corrente');
    $vetCampoLC['vl_pago'] = CriaVetTabela('Vl. Pago', 'decimal', '', '', '', '2', '', true);

    $titulo = 'Dados para Devolução';

    $sql = '';
    $sql .= " select cd.*, concat_ws('-', cd.agencia_numero, cd.agencia_digito) as agencia, concat_ws('-', cd.cc_numero, cd.cc_digito) as cc,";
    $sql .= " concat_ws(' - ', cd.cpfcnpj, cd.razao_social) as favorecido";
    $sql .= ' from grc_atendimento_evento_contadevolucao cd';
    $sql .= ' where cd.idt_atendimento_evento = $vlID';

    $vetParametrosLC = Array(
        'contlinfim' => '',
    );

    $vetCampo['grc_atendimento_evento_contadevolucao'] = objListarConf('grc_atendimento_evento_contadevolucao', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);

    $vetParametros = Array(
        'codigo_pai' => 'participante_contadevolucao',
        'width' => '100%',
    );

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_atendimento_evento_contadevolucao']),
            ), $class_frame_p . ' fset_pag_conta', $class_titulo_p, $titulo_na_linha_p, $vetParametros);
}

if ($rowDados['bt_acao_cadastro'] == 'bt_aprovacao') {
    $vetCampo['contrato_ass_pdf'] = objFile('contrato_ass_pdf', 'Termo de Adesão Assinado', true, 120, 'pdf');
    $vetCampo['contrato_ass_pdf']['campo_tabela'] = false;
    $vetCampo['contrato_ass_pdf']['tabela'] = '';

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['contrato_ass_pdf']),
            ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
}

$vetCampo['grc_atendimento_evento_botao'] = objInclude('grc_atendimento_evento_botao', 'cadastro_conf/grc_atendimento_evento_botao.php');

$vetParametros = Array(
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_atendimento_evento_botao']),
        ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    var ano_competencia = '<?php echo $rowDados['ano_competencia']; ?>';
    var idt_unidade = '<?php echo $rowDados['idt_unidade']; ?>';
    var idt = '<?php echo $rowDados['idt']; ?>';
    var vl_teto = '<?php echo $rowDados['vl_teto']; ?>';

    $(document).ready(function () {
        if ('<?php echo $rowDados['vl_determinado']; ?>' == 'N') {
            $('#bt_aprovacao, .fset_pag_conta').hide();
        } else {
            $('#bt_backoffice_cotacao').hide();
        }

        if ('<?php echo $rowDados['bt_acao_cadastro']; ?>' == 'bt_aprovacao') {
            setTimeout(function () {
                $('#contrato_ass_pdf').removeProp("disabled").removeClass("campo_disabled");
            }, 500);

            setTimeout(function () {
                $('#contrato_ass_pdf').removeProp("disabled").removeClass("campo_disabled");
            }, 2000);
        }

    });

    function parListarCmb_idt_projeto() {
        var par = '';

        par += '&veiocad=grc_evento';
        par += '&idt_unidade=' + idt_unidade;

        return par;
    }

    function fncListarCmbMuda_idt_projeto(idt_projeto) {
        processando();

        $('#idt_acao_bt_limpar').click();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=projeto_dados',
            data: {
                cas: conteudo_abrir_sistema,
                idt_projeto: idt_projeto
            },
            success: function (response) {
                $('#fase_acao_projeto').val(url_decode(response.etapa));

                if (response.erro != '') {
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        $('#dialog-processando').remove();

        TelaHeight();
    }

    function parListarCmb_idt_acao() {
        var par = '';

        if ($('#idt_produto').val() == '') {
            alert('Favor informar o Produto!');
            return false;
        }

        if ($('#idt_projeto').val() == '') {
            alert('Favor informar o Projeto!');
            return false;
        } else {
            par += '&idt_projeto=' + $('#idt_projeto').val();
            par += '&idt_unidade=' + idt_unidade;
        }

        return par;
    }

    function fncListarCmbMuda_idt_acao(idt_acao) {
        var campo = $('#gestor_sge, #idt_gestor_projeto, #idt_unidade, #qtd_previsto, #qtd_realizado, #qtd_percentual, #qtd_saldo, #orc_previsto, #orc_realizado, #orc_percentual, #orc_saldo, #contrapartida_sgtec');

        if (idt_acao != '') {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'ajax_atendimento.php?tipo=acao_dados',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_instrumento: $('#idt_instrumento').val(),
                    ano_competencia: ano_competencia,
                    idt_acao: idt_acao
                },
                success: function (response) {
                    campo.each(function () {
                        var id = $(this).attr('id');

                        $(this).val(url_decode(response[id]));
                        $('#' + id + '_fix').html(url_decode(response[id]));
                    });

                    if (response.erro == '') {
                        valida_cust = 'N';
                        onSubmitMsgTxt = false;
                        $('#bt_acao_cadastro').val('muda_acao');
                        $(':submit:first').click();
                    } else {
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $('#dialog-processando').remove();
        } else {
            campo.each(function () {
                var id = $(this).attr('id');

                $(this).val('');
                $('#' + id + '_fix').html('');
            });
        }

        TelaHeight();
    }

    function parListarCmb_idt_produto() {
        if ($('#idt_produto').val() != '') {
            if (!confirm("Deseja trocar o Produto?\n\nVai ser excluido as Entregas, Dimensionamento da Demanda, Loja Presencial e Dados para Devolução!")) {
                return false;
            }
        }

        var par = '';

        par += '&veiocad=grc_atendimento_evento';

        return par;
    }

    function parListarCmbLimpa_idt_produto() {
        return parListarCmb_idt_produto();
    }

    function fncListarCmbMuda_idt_produto(idt_produto, descAtu, valorAnt, descAnt) {
        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=grc_atendimento_evento_produto',
            data: {
                cas: conteudo_abrir_sistema,
                idt_produto: idt_produto,
                idt_atendimento_evento: idt
            },
            success: function (response) {
                btFechaCTC($('#grc_atendimento_evento_dimensionamento').data('session_cod'));
                btFechaCTC($('#grc_atendimento_evento_entrega').data('session_cod'));
                btFechaCTC($('#grc_atendimento_evento_pagamento').data('session_cod'));
                btFechaCTC($('#grc_atendimento_evento_contadevolucao').data('session_cod'));

                $('#idt_instrumento').val(url_decode(response.idt_instrumento));
                $('#resumo_tot').html('0,00');
                $('#resumo_sub').html('0,00');
                $('#resumo_pag').html('0,00');
                $('#vl_determinado').html(url_decode(response.vl_determinado_txt));

                vl_teto = url_decode(response.vl_teto);
                $('#vl_teto').html(vl_teto);
                vl_teto = str2float(vl_teto);

                if (isNaN(vl_teto)) {
                    vl_teto = '';
                }

                if (url_decode(response.vl_determinado) == 'S') {
                    $('#bt_aprovacao, .fset_pag_conta').show();
                    $('#bt_backoffice_cotacao').hide();
                } else {
                    $('#bt_aprovacao, .fset_pag_conta').hide();
                    $('#bt_backoffice_cotacao').show();
                }

                if (response.erro != '') {
                    $('#dialog-processando').remove();
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#dialog-processando').remove();
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        TelaHeight();

        $('#dialog-processando').remove();
    }

    function funcaoFechaCTC_grc_atendimento_evento_dimensionamento(returnVal) {
        btFechaCTC($('#grc_atendimento_evento_contadevolucao').data('session_cod'));

        $('#resumo_tot').html(url_decode(returnVal.resumo_tot));
        $('#resumo_sub').html(url_decode(returnVal.resumo_sub));
        $('#resumo_pag').html(url_decode(returnVal.resumo_pag));
    }

    function parListarConf_grc_atendimento_evento_pagamento() {
        if (vl_teto != '') {
            var resumo_tot = str2float($('#resumo_tot').html());

            if (isNaN(resumo_tot)) {
                resumo_tot = 0;
            }

            if (resumo_tot > vl_teto) {
                alert('O Total do evento não pode ser maior que o Valor Teto da Solução!');
                return false;
            }
        }

        return '';
    }

    function grc_atendimento_evento_dep() {
        if ($('#idt_gestor_projeto').val() == '') {
            var txt = '';
            txt += 'Favor informar uma Ação do Projeto que tenha um gestor cadastrado no CRM!\n\n';
            txt += 'O gestor ' + $('#gestor_sge').val() + ' não tem cadastro.';
            alert(txt);
            return false;
        }

        if ($('#bt_acao_cadastro').val() != '' && '<?php echo $vetConf['evento_sem_metrica_sge'] ?>' == 'Não') {
            var qtd_previsto = str2float($('#qtd_previsto').val());

            if (isNaN(qtd_previsto)) {
                qtd_previsto = 0;
            }

            if (qtd_previsto == 0) {
                alert('A Ação do Projeto não tem Métrica Previsão no SGE!\n\nCom isso não pode continuar com esta solicitação!');
                return false;
            }
        }

        var ok = true;

        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=grc_atendimento_evento_dep',
            data: {
                cas: conteudo_abrir_sistema,
                idt_produto: $('#idt_produto').val(),
                idt: '<?php echo $_GET['id']; ?>'
            },
            success: function (response) {
                if (response.erro != '') {
                    ok = false;
                    $("#dialog-processando").remove();
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                ok = false;
                $("#dialog-processando").remove();
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        if ($('#bt_acao_cadastro').val() == 'bt_aprovacao') {
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_atendimento_evento_dep_ap',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt: '<?php echo $_GET['id']; ?>'
                },
                success: function (response) {
                    if (response.erro != '') {
                        ok = false;
                        $("#dialog-processando").remove();
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    ok = false;
                    $("#dialog-processando").remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

        } else {
            $("#dialog-processando").remove();

            if (vl_teto != '') {
                var resumo_tot = str2float($('#resumo_tot').html());

                if (isNaN(resumo_tot)) {
                    resumo_tot = 0;
                }

                if (resumo_tot > vl_teto) {
                    alert('O Total do evento não pode ser maior que o Valor Teto da Solução!');
                    return false;
                }
            }
        }

        $("#dialog-processando").remove();

        return ok;
    }
</script>