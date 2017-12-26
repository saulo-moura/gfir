<?php
$ordFiltro = false;
$idCampo = 'idt';
$Tela = "a Evento";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$listar_sql_limit = false;

$barra_inc_ap = false;
$barra_alt_ap = true;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;

$colocaOrderBy = true;

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
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_instrumento'] = $Filtro;

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from ' . db_pir_gec . 'gec_programa';
$sql .= " where ativo = 'S'";
$sql .= " and tipo_ordem = 'SG'";
$sql .= ' order by descricao';
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'f_idt_programa';
$Filtro['id_select'] = 'idt';
$Filtro['LinhaUm'] = '-- Todos os Programas --';
$Filtro['nome'] = 'Programas';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_programa'] = $Filtro;

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from ' . db_pir . 'sca_organizacao_secao';
$sql .= " where posto_atendimento <> 'S' ";
$sql .= ' order by classificacao';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_unidade';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Unidade';
$Filtro['LinhaUm'] = ' ';
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
$Filtro['LinhaUm'] = ' ';
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
$Filtro['id'] = 'f_idt_gestor_evento';
$Filtro['id_select'] = 'id_usuario';
$Filtro['nome'] = 'Gestor do Evento';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_gestor_evento'] = $Filtro;

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
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_cidade'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'f_dt_ini';
$Filtro['nome'] = 'Data Início de';
$Filtro['js'] = 'data';
$Filtro['vlPadrao'] = Date('d/m/Y', strtotime('-180 day'));
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_dt_ini'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'f_dt_fim';
$Filtro['nome'] = 'Data Início até';
$Filtro['js'] = 'data';
$Filtro['vlPadrao'] = Date('d/m/Y', strtotime('+30 day'));
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_dt_fim'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = Array(
    'S' => 'Sim',
    'N' => 'Não',
    'T' => 'Todos',
);
$Filtro['id'] = 'f_erro';
$Filtro['nome'] = 'Tem Erro';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_erro'] = $Filtro;

$sql = '';
$sql .= ' select md5(cod) as cod, ws_sg_erro';
$sql .= ' from (';
$sql .= ' select distinct ws_sg_erro as cod, ws_sg_erro';
$sql .= ' from grc_evento';
$sql .= " where ws_sg_erro is not null";
$sql .= ' union';
$sql .= ' select distinct ws_sg_erro as cod, ws_sg_erro';
$sql .= ' from grc_atendimento_pessoa';
$sql .= " where ws_sg_erro is not null";
$sql .= ' ) as t';
$sql .= ' order by ws_sg_erro';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_ws_sg_erro';
$Filtro['id_select'] = 'cod';
$Filtro['nome'] = 'Mensagem de Erro';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_ws_sg_erro'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'f_texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_texto'] = $Filtro;

$vetCampo['codigo'] = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Evento');
$vetCampo['instrumento_desc'] = CriaVetTabela('Instrumento');
$vetCampo['produto'] = CriaVetTabela('Produto');
$vetCampo['dt_previsao_inicial'] = CriaVetTabela('Data Início', 'data');
$vetCampo['dt_previsao_fim'] = CriaVetTabela('Data Final', 'data');
$vetCampo['protocolo'] = CriaVetTabela('Protocolo');
$vetCampo['pessoa'] = CriaVetTabela('Nome do Cliente / CPF');
$vetCampo['ws_sg_dt_cadastro'] = CriaVetTabela('Data Sincronização', 'data');
$vetCampo['ws_sg_idprestadora'] = CriaVetTabela('ID da Prestadora');
$vetCampo['ws_sg_iddemanda'] = CriaVetTabela('ID da Demanda');
$vetCampo['ws_sg_erro'] = CriaVetTabela('Mensagem', 'func_trata_dado', ftd_grc_sincroniza_ws_sg);

$sql = "select e.idt, e.codigo, e.descricao, i.descricao as instrumento_desc, e.dt_previsao_inicial, e.dt_previsao_fim,";
$sql .= " coalesce(ap.ws_sg_dt_cadastro, e.ws_sg_dt_cadastro) as ws_sg_dt_cadastro, e.ws_sg_idprestadora, ap.ws_sg_iddemanda,";
$sql .= " coalesce(ap.ws_sg_erro, e.ws_sg_erro) as ws_sg_erro, concat_ws('<br />', ap.nome, ap.cpf) as pessoa, a.protocolo,";
$sql .= " coalesce(ap.ws_sg_idt_erro_log, e.ws_sg_idt_erro_log) as ws_sg_idt_erro_log, ap.idt as idt_atendimento_pessoa,";
$sql .= " concat_ws('<br />', prd.codigo, prd.descricao) as produto";
$sql .= " from grc_evento e";
$sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem o on o.idt_evento = e.idt';
$sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_insumo oi on oi.idt_gec_contratacao_credenciado_ordem = o.idt and oi.codigo = '71001'";
$sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista ol on ol.idt_gec_contratacao_credenciado_ordem = o.idt';
$sql .= ' inner join grc_produto prd on prd.idt = e.idt_produto';
$sql .= ' inner join grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
$sql .= ' inner join ' . db_pir_gec . 'gec_programa p on p.idt = e.idt_programa';
$sql .= ' left outer join grc_atendimento a on a.idt_evento = e.idt';
$sql .= ' left outer join grc_atendimento_pessoa ap on ap.idt_atendimento = a.idt';
$sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
$sql .= " where (";
$sql .= " e.temporario <> 'S'";
$sql .= " or (e.temporario = 'S' and e.idt_responsavel = " . null($_SESSION[CS]['g_id_usuario']) . ")";
$sql .= " )";

$sql .= " and p.ativo = 'S'";
$sql .= " and p.tipo_ordem = 'SG'";
$sql .= " and (ep.contrato is null or ep.contrato in ('C', 'S', 'G'))";
$sql .= " and (ep.ativo is null or ep.ativo = 'S')";

$sql .= ' and (';
$sql .= ' e.idt_evento_situacao = 20';
$sql .= ' or e.ws_sg_dt_cadastro is not null';
$sql .= ' or ap.ws_sg_dt_cadastro is not null';
$sql .= ' )';

switch ($vetFiltro['f_erro']['valor']) {
    case 'S':
        $sql .= ' and (e.ws_sg_idt_erro_log is not null or ap.ws_sg_idt_erro_log is not null)';
        break;

    case 'N':
        $sql .= ' and (e.ws_sg_idt_erro_log is null and ap.ws_sg_idt_erro_log is null)';
        break;
}

if ($vetFiltro['f_idt_instrumento']['valor'] != "" && $vetFiltro['f_idt_instrumento']['valor'] != "0" && $vetFiltro['f_idt_instrumento']['valor'] != "-1") {
    $sql .= ' and e.idt_instrumento = ' . null($vetFiltro['f_idt_instrumento']['valor']);
}

if ($vetFiltro['f_idt_unidade']['valor'] != "" && $vetFiltro['f_idt_unidade']['valor'] != "0" && $vetFiltro['f_idt_unidade']['valor'] != "-1") {
    $sql .= ' and e.idt_unidade = ' . null($vetFiltro['f_idt_unidade']['valor']);
}

if ($vetFiltro['f_idt_ponto_atendimento_tela']['valor'] != "" && $vetFiltro['f_idt_ponto_atendimento_tela']['valor'] != "0" && $vetFiltro['f_idt_ponto_atendimento_tela']['valor'] != "-1") {
    $sql .= ' and e.idt_ponto_atendimento_tela = ' . null($vetFiltro['f_idt_ponto_atendimento_tela']['valor']);
}

if ($vetFiltro['f_idt_projeto']['valor'] != "" && $vetFiltro['f_idt_projeto']['valor'] != "0" && $vetFiltro['f_idt_projeto']['valor'] != "-1") {
    $sql .= ' and e.idt_projeto = ' . null($vetFiltro['f_idt_projeto']['valor']);
}

if ($vetFiltro['f_idt_acao']['valor'] != "" && $vetFiltro['f_idt_acao']['valor'] != "0" && $vetFiltro['f_idt_acao']['valor'] != "-1") {
    $sql .= ' and e.idt_acao = ' . null($vetFiltro['f_idt_acao']['valor']);
}

if ($vetFiltro['f_idt_gestor_evento']['valor'] != "" && $vetFiltro['f_idt_gestor_evento']['valor'] != "0" && $vetFiltro['f_idt_gestor_evento']['valor'] != "-1") {
    $sql .= ' and e.idt_gestor_evento = ' . null($vetFiltro['f_idt_gestor_evento']['valor']);
}

if ($vetFiltro['f_idt_cidade']['valor'] != "" && $vetFiltro['f_idt_cidade']['valor'] != "0" && $vetFiltro['f_idt_cidade']['valor'] != "-1") {
    $sql .= ' and e.idt_cidade = ' . null($vetFiltro['f_idt_cidade']['valor']);
}

if ($vetFiltro['f_dt_ini']['valor'] != "") {
    $sql .= ' and e.dt_previsao_inicial >= ' . aspa(trata_data($vetFiltro['f_dt_ini']['valor']));
}

if ($vetFiltro['f_dt_fim']['valor'] != "") {
    $sql .= ' and e.dt_previsao_inicial <= ' . aspa(trata_data($vetFiltro['f_dt_fim']['valor']));
}

if ($vetFiltro['f_idt_programa']['valor'] != "" && $vetFiltro['f_idt_programa']['valor'] != "0" && $vetFiltro['f_idt_programa']['valor'] != "-1") {
    $sql .= ' and e.idt_programa = ' . null($vetFiltro['f_idt_programa']['valor']);
}

if ($vetFiltro['f_ws_sg_erro']['valor'] != "" && $vetFiltro['f_ws_sg_erro']['valor'] != "0" && $vetFiltro['f_ws_sg_erro']['valor'] != "-1") {
    $sql .= ' and (md5(e.ws_sg_erro) = ' . aspa($vetFiltro['f_ws_sg_erro']['valor']) . ' or md5(ap.ws_sg_erro) = ' . aspa($vetFiltro['f_ws_sg_erro']['valor']) . ')';
}

if ($vetFiltro['f_texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '    lower(e.codigo)    like lower(' . aspa($vetFiltro['f_texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(e.descricao) like lower(' . aspa($vetFiltro['f_texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(e.ws_sg_erro) like lower(' . aspa($vetFiltro['f_texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(ap.ws_sg_erro) like lower(' . aspa($vetFiltro['f_texto']['valor'], '%', '%') . ')';
    $sql .= ' ) ';
}
?>
<style type="text/css">
    #f_ws_sg_erro {
        width: 500px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $("#f_idt_ponto_atendimento_tela").cascade("#f_idt_unidade", {
            ajax: {
                url: ajax_sistema + '?tipo=pa_unidade&cas=' + conteudo_abrir_sistema
            }
        });

        $("#f_idt_gestor_evento").cascade("#f_idt_unidade", {
            ajax: {
                url: ajax_sistema + '?tipo=usuario_pa&cas=' + conteudo_abrir_sistema
            }
        });
    });

    function fncListarCmbMuda_f_idt_projeto() {
        $('#f_idt_acao_bt_limpar').click();
    }

    function parListarCmb_f_idt_acao() {
        var par = '';

        if ($('#f_idt_projeto').val() == '') {
            alert('Favor informar o Projeto!');
            return false;
        } else {
            par += '&idt_projeto=' + $('#f_idt_projeto').val();
        }

        return par;
    }

    function btReprocessar(idt, idt_atendimento_pessoa, reload) {
        var msg = 'Deseja reprocessar este registro?';

        if (reload) {
            msg = 'Deseja reprocessar estes registros?';
        }

        if (confirm(msg)) {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_sincroniza_ws_sg_btReprocessar',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt: idt,
                    idt_atendimento_pessoa: idt_atendimento_pessoa
                },
                success: function (response) {
                    if (response.erro == '') {
                        if (reload) {
                            document.frm.submit();
                        } else {
                            $('td[data-campo="ws_sg_erro"][data-id="' + idt + '"]').html('');
                        }
                    } else {
                        $("#dialog-processando").remove();
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#dialog-processando").remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $("#dialog-processando").remove();
        }
    }
</script>