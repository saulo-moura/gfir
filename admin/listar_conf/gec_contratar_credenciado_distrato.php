<?php
if ($telaAditivo == '') {
    $telaAditivo = false;
}

if ($_SESSION[CS]['g_abrir_sistema_origem'] == 'PFO') {
    $ordFiltro = false;
    $idCampo = 'idt';
    $idCampoPar = 'av_idt';
    $idCampo = 'idt';
    $Tela = "a Contrato do Credenciado";

    $tipoidentificacao = 'N';
    $tipofiltro = 'S';
    $comfiltro = 'A';
    $comidentificacao = 'F';

    $fixaidentificacao = 1;
    if ($_SESSION[CS]['g_id_usuario'] == '1') {
        $fixaidentificacao = 0;
    }

    $barra_inc_ap = false;
    $barra_alt_ap = true;
    $barra_con_ap = true;
    $barra_exc_ap = false;
    $barra_fec_ap = false;


    $Filtro = Array();
    $Filtro['rs'] = 'Texto';
    $Filtro['id'] = 'cnpj_cpf';
    $Filtro['js'] = "onblur='validaCPFCNPJ(this)' onkeydown='formataCPFCNPJ(this, event);'";

    if ($fixaidentificacao == 1) {
        $Filtro['js'] = "onblur='validaCPFCNPJ(this)' onkeydown='formataCPFCNPJ(this, event);'  readonly='true' style='background:#FFFFD2' ";
        $Filtro['vlPadrao'] = $_SESSION[CS]['g_login'];
    }

    $Filtro['nome'] = 'CNPJ/CPF';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['cnpj_cpf'] = $Filtro;

    $Filtro = Array();
    $Filtro['rs'] = 'Texto';
    $Filtro['id'] = 'av_texto';
    $Filtro['js_tam'] = '0';
    $Filtro['nome'] = 'Texto';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['texto'] = $Filtro;

    $vetCampo['cod_ordem'] = CriaVetTabela('Número do Contrato');
    $vetCampo['cod_evento'] = CriaVetTabela('Número do Evento');
    $vetCampo['gec_cco_descricao'] = CriaVetTabela('Objeto');
    $vetCampo['empresa'] = CriaVetTabela('Razão Social<br />CNPJ');
    $vetCampo['data_cotacao'] = CriaVetTabela('Dt. Últ. Alteração ', 'datahora');

    if ($telaAditivo) {
        $vetCampo['situacao'] = CriaVetTabela('Status do Aditamento', 'descDominio', $vetSituacaoDistratoAditivo);
    } else {
        $vetCampo['situacao'] = CriaVetTabela('Status do Distrato', 'descDominio', $vetSituacaoDistratoAditivo);
    }

    $sql = "select cc.idt, ";
    $sql .= " gec_cco.codigo as cod_ordem,";
    $sql .= " e.codigo as cod_evento,";
    $sql .= " gec_cco.descricao as gec_cco_descricao,";
    $sql .= " concat_ws('<br />', ole.razaosocial_organizacao, ole.cnpj_organizacao) as empresa, ";
    $sql .= ' tab_ad.situacao,';
    $sql .= " ole.data_cotacao";
    $sql .= " from " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista_endidade ole ";
    $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista gec_ccol on gec_ccol.idt = ole.idt_gec_contratacao_credenciado_ordem_lista ";
    $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem gec_cco on gec_cco.idt = gec_ccol.idt_gec_contratacao_credenciado_ordem ";
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado cc on cc.idt_gec_contratacao_credenciado_ordem = gec_cco.idt';

    if ($telaAditivo) {
        $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado_aditivo tab_ad on tab_ad.idt_contratar_credenciado = cc.idt';
    } else {
        $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado_distrato tab_ad on tab_ad.idt_contratar_credenciado = cc.idt';
    }

    $sql .= ' left outer join ' . db_pir_grc . "grc_evento e on e.idt = gec_cco.idt_evento";
    $sql .= " left outer join " . db_pir_gec . "gec_programa gec_pr on gec_pr.idt = e.idt_programa";
    $sql .= " where gec_ccol.idt_organizacao = ole.idt_organizacao ";
    $sql .= ' and ole.cnpj_organizacao = ' . aspa($vetFiltro['cnpj_cpf']['valor']);
    $sql .= " and gec_pr.tipo_ordem = 'SG'";
    $sql .= " and gec_cco.ativo = 'S'";
    $sql .= " and cc.ativo = 'S'";
    $sql .= " and e.idt_evento_situacao in (14, 16, 19)";
    $sql .= " and e.idt_instrumento <> 52";
    $sql .= " and e.idt_evento_pai is null";
    $sql .= " and e.cred_necessita_credenciado = 'S'";
    $sql .= " and e.nao_sincroniza_rm = 'N'";
    $sql .= " and e.sgtec_modelo = 'E'";
    $sql .= " and tab_ad.situacao in ('AP', 'AS')";

    if ($vetFiltro['texto']['valor'] != '') {
        $sql .= ' and ';
        $sql .= ' ( ';
        $sql .= '    lower(ole.razaosocial_organizacao)           like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
        $sql .= ' or lower(ole.cnpj_organizacao)        like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
        $sql .= ' or lower(gec_cco.descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
        $sql .= ' or lower(gec_cco.codigo) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
        $sql .= ' or lower(e.codigo) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
        $sql .= ' ) ';
    }
} else {
    $listar_sql_limit = false;

    $idCampo = 'idt';
    $Tela = "a Solicitação do Aditamento ou Distrato";

    $tipoidentificacao = 'N';
    $tipofiltro = 'S';
    $comfiltro = 'A';
    $comidentificacao = 'F';

    $barra_inc_ap = false;
    $barra_alt_ap = true;
    $barra_con_ap = true;
    $barra_exc_ap = false;

    $sql = '';
    $sql .= ' select idt, descricao';
    $sql .= ' from grc_atendimento_instrumento';
    $sql .= ' where idt in (40, 47, 46, 49, 50, 2, 41, 45, 48)';
    $sql .= ' order by descricao';
    $rs = execsql($sql);
    $Filtro = Array();
    $Filtro['rs'] = $rs;
    $Filtro['id'] = 'idt';
    $Filtro['nome'] = 'Instrumentos';
    $Filtro['LinhaUm'] = ' ';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['instrumento'] = $Filtro;

    $sql = '';
    $sql .= ' select idt, descricao';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
    $sql .= " where posto_atendimento <> 'S' ";
    $sql .= ' order by classificacao';
    $Filtro = Array();
    $Filtro['rs'] = execsql($sql);
    $Filtro['id'] = 'idt';
    $Filtro['nome'] = 'Unidade';
    $Filtro['LinhaUm'] = ' ';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['idt_unidade'] = $Filtro;

    $sql = "select idt,  descricao from " . db_pir . "sca_organizacao_secao ";
//$sql .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S')";
    $sql .= ' where SUBSTRING(classificacao, 1, 5) = ('; //and
    $sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
    $sql .= ' where idt = ' . null($vetFiltro['idt_unidade']['valor']);
    $sql .= ' )';
    $sql .= ' and idt <> ' . null($vetFiltro['idt_unidade']['valor']);
    $sql .= ' order by classificacao ';
    $Filtro = Array();
    $Filtro['rs'] = execsql($sql);
    $Filtro['id'] = 'idt';
    $Filtro['nome'] = 'Ponto de Atendimento';
    $Filtro['LinhaUm'] = ' ';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['idt_ponto_atendimento_tela'] = $Filtro;

    $Filtro = Array();
    $Filtro['rs'] = 'ListarCmb';
    $Filtro['arq'] = 'grc_projeto';
    $Filtro['id'] = 'idt';
    $Filtro['nome'] = 'Projeto';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['idt_projeto'] = $Filtro;

    $Filtro = Array();
    $Filtro['rs'] = 'ListarCmb';
    $Filtro['arq'] = 'grc_projeto_acao';
    $Filtro['id'] = 'idt';
    $Filtro['nome'] = 'Ação';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['idt_acao'] = $Filtro;

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
    $Filtro['id'] = 'id_usuario';
    $Filtro['nome'] = 'Responsável pelo Evento';
    $Filtro['LinhaUm'] = ' ';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['idt_gestor_evento'] = $Filtro;

    $sql = '';
    $sql .= ' select codcid, desccid';
    $sql .= ' from ' . db_pir_siac . 'cidade';
    $sql .= " where codest = 5";
    $sql .= ' order by desccid';
    $Filtro = Array();
    $Filtro['rs'] = execsql($sql);
    $Filtro['id'] = 'codcid';
    $Filtro['nome'] = 'Cidade';
    $Filtro['LinhaUm'] = ' ';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['idt_cidade'] = $Filtro;

    $Filtro = Array();
    $Filtro['rs'] = 'Texto';
    $Filtro['id'] = 'dt_ini';
    $Filtro['nome'] = 'Dt. Inicio';
    $Filtro['js'] = 'data';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['dt_ini'] = $Filtro;

    $Filtro = Array();
    $Filtro['rs'] = 'Texto';
    $Filtro['id'] = 'dt_fim';
    $Filtro['nome'] = 'Dt. Fim';
    $Filtro['js'] = 'data';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['dt_fim'] = $Filtro;

    $sql = '';
    $sql .= ' select idt, descricao';
    $sql .= ' from grc_evento_situacao';
    $sql .= " where ativo = 'S'";
    $sql .= ' and idt in (14, 16, 19)';
    $sql .= ' order by codigo';
    $Filtro = Array();
    $Filtro['rs'] = execsql($sql);
    $Filtro['id'] = 'idt';
    $Filtro['nome'] = 'Status do Evento';
    $Filtro['LinhaUm'] = ' ';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['idt_evento_situacao'] = $Filtro;

    $Filtro = Array();

    $tmp = $vetSituacaoDistratoAditivo;

    if ($telaAditivo) {
        $tmp['null'] = 'Sem Aditamento';
        $Filtro['nome'] = 'Status do Aditamento';
    } else {
        $tmp['null'] = 'Sem Distrato';
        $Filtro['nome'] = 'Status do Distrato';
    }

    $Filtro['rs'] = $tmp;
    $Filtro['id'] = 'situacao';
    $Filtro['LinhaUm'] = ' ';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['situacao'] = $Filtro;

    $Filtro = Array();
    $Filtro['rs'] = 'Texto';
    $Filtro['id'] = 'texto';
    $Filtro['js_tam'] = '0';
    $Filtro['nome'] = 'Texto';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['texto'] = $Filtro;

    $vetCampo['codigo'] = CriaVetTabela('Código');
    $vetCampo['descricao'] = CriaVetTabela('Evento', 'func_trata_dado', ftd_grc_evento);
    $vetCampo['gestor'] = CriaVetTabela('Responsável pelo Evento');
    $vetCampo['cidade'] = CriaVetTabela('Cidade');
    $vetCampo['dt_previsao_inicial'] = CriaVetTabela('Data Início', 'data');
    $vetCampo['hora_inicio'] = CriaVetTabela('Horário');
    $vetCampo['sala'] = CriaVetTabela('Local');
    $vetCampo['grc_ersit_descricao'] = CriaVetTabela('Status do Evento', 'func_trata_dado', ftd_grc_evento);
    $vetCampo['ordem_contratacao'] = CriaVetTabela('Rodizio', 'func_trata_dado', ftd_grc_evento);

    if ($telaAditivo) {
        $vetCampo['situacao'] = CriaVetTabela('Status do Aditamento', 'descDominio', $vetSituacaoDistratoAditivo);
        $vetCampo['responsavel_ad'] = CriaVetTabela('Responsável pelo Aditamento');
    } else {
        $vetCampo['situacao'] = CriaVetTabela('Status do Distrato', 'descDominio', $vetSituacaoDistratoAditivo);
        $vetCampo['responsavel_ad'] = CriaVetTabela('Responsável pelo Distrato');
    }

    $sql = "select ";
    $sql .= ' cc.idt,';
    $sql .= " e.codigo,";
    $sql .= " e.descricao,";
    $sql .= " gp.nome_completo as gestor,";
    $sql .= " resp_ad.nome_completo as responsavel_ad,";
    $sql .= " cid.desccid as cidade,";
    $sql .= " e.dt_previsao_inicial,";
    $sql .= " e.hora_inicio,";
    $sql .= " loc.descricao as sala,";
    $sql .= " grc_ersit.descricao as grc_ersit_descricao,";
    $sql .= " e.idt_evento_situacao,";
    $sql .= ' tab_ad.situacao,';
    $sql .= " e.siac_at_erro_con,";
    $sql .= " grc_ersit_ant.descricao as grc_ersit_ant_descricao,";
    $sql .= " e.temporario,";
    $sql .= " e.cred_necessita_credenciado,";
    $sql .= " e.cred_rodizio_auto,";
    $sql .= " e.cred_credenciado_sgc,";
    $sql .= ' null as ordem_contratacao,';
    $sql .= ' gec_pr.tipo_ordem as grc_pr_tipo_ordem,';
    $sql .= " ord.idt_evento";
    $sql .= " from grc_evento as e ";
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord on ord.idt_evento = e.idt';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado cc on cc.idt_gec_contratacao_credenciado_ordem = ord.idt';
    $sql .= " inner join grc_evento_situacao grc_ersit on grc_ersit.idt = e.idt_evento_situacao ";
    $sql .= " left outer join grc_evento_situacao grc_ersit_ant on grc_ersit_ant.idt = e.idt_evento_situacao_ant ";
    $sql .= " left outer join " . db_pir_siac . "cidade cid on cid.codcid = e.idt_cidade ";
    $sql .= " left outer join grc_evento_local_pa loc on loc.idt = e.idt_local ";
    $sql .= " left outer join " . db_pir_gec . "gec_programa gec_pr on gec_pr.idt = e.idt_programa";
    $sql .= " left outer join plu_usuario gp on gp.id_usuario = e.idt_gestor_evento ";

    if ($telaAditivo) {
        $sql .= ' left outer join ' . db_pir_gec . 'gec_contratar_credenciado_aditivo tab_ad on tab_ad.idt_contratar_credenciado = cc.idt';
    } else {
        $sql .= ' left outer join ' . db_pir_gec . 'gec_contratar_credenciado_distrato tab_ad on tab_ad.idt_contratar_credenciado = cc.idt';
    }
    
    $sql .= ' left outer join ' . db_pir_gec . 'plu_usuario resp_ad on resp_ad.id_usuario = tab_ad.idt_responsavel ';

    $sql .= " where e.idt_evento_situacao in (14, 16, 19)";
    $sql .= " and e.idt_instrumento <> 52";
    $sql .= " and e.idt_evento_pai is null";
    $sql .= " and e.cred_necessita_credenciado = 'S'";
    $sql .= " and e.nao_sincroniza_rm = 'N'";
    $sql .= " and e.sgtec_modelo = 'E'";
    $sql .= " and gec_pr.tipo_ordem = 'SG'";
    $sql .= " and ord.ativo = 'S'";
    $sql .= " and cc.ativo = 'S'";

    if ($_SESSION[CS]['g_id_usuario'] != 1) {
        $sql .= " and (e.idt_gestor_evento = " . null($_SESSION[CS]['g_id_usuario']) . " or e.idt_gestor_projeto = " . null($_SESSION[CS]['g_id_usuario']) . ")";
    }

    if ($vetFiltro['idt_unidade']['valor'] != "" && $vetFiltro['idt_unidade']['valor'] != "0" && $vetFiltro['idt_unidade']['valor'] != "-1") {
        $sql .= ' and e.idt_unidade = ' . null($vetFiltro['idt_unidade']['valor']);
    }

    if ($vetFiltro['idt_ponto_atendimento_tela']['valor'] != "" && $vetFiltro['idt_ponto_atendimento_tela']['valor'] != "0" && $vetFiltro['idt_ponto_atendimento_tela']['valor'] != "-1") {
        $sql .= ' and e.idt_ponto_atendimento_tela = ' . null($vetFiltro['idt_ponto_atendimento_tela']['valor']);
    }

    if ($vetFiltro['idt_projeto']['valor'] != "" && $vetFiltro['idt_projeto']['valor'] != "0" && $vetFiltro['idt_projeto']['valor'] != "-1") {
        $sql .= ' and e.idt_projeto = ' . null($vetFiltro['idt_projeto']['valor']);
    }

    if ($vetFiltro['idt_acao']['valor'] != "" && $vetFiltro['idt_acao']['valor'] != "0" && $vetFiltro['idt_acao']['valor'] != "-1") {
        $sql .= ' and e.idt_acao = ' . null($vetFiltro['idt_acao']['valor']);
    }

    if ($vetFiltro['idt_gestor_evento']['valor'] != "" && $vetFiltro['idt_gestor_evento']['valor'] != "0" && $vetFiltro['idt_gestor_evento']['valor'] != "-1") {
        $sql .= ' and e.idt_gestor_evento = ' . null($vetFiltro['idt_gestor_evento']['valor']);
    }

    if ($vetFiltro['idt_cidade']['valor'] != "" && $vetFiltro['idt_cidade']['valor'] != "0" && $vetFiltro['idt_cidade']['valor'] != "-1") {
        $sql .= ' and e.idt_cidade = ' . null($vetFiltro['idt_cidade']['valor']);
    }

    if ($vetFiltro['dt_ini']['valor'] != "") {
        $sql .= ' and e.dt_previsao_inicial >= ' . aspa(trata_data($vetFiltro['dt_ini']['valor']));
    }

    if ($vetFiltro['dt_fim']['valor'] != "") {
        $sql .= ' and e.dt_previsao_inicial <= ' . aspa(trata_data($vetFiltro['dt_fim']['valor']));
    }

    if ($vetFiltro['idt_evento_situacao']['valor'] != "" && $vetFiltro['idt_evento_situacao']['valor'] != "0" && $vetFiltro['idt_evento_situacao']['valor'] != "-1") {
        $sql .= ' and e.idt_evento_situacao = ' . null($vetFiltro['idt_evento_situacao']['valor']);
    }

    if ($vetFiltro['situacao']['valor'] != "" && $vetFiltro['situacao']['valor'] != "0" && $vetFiltro['situacao']['valor'] != "-1") {
        if ($vetFiltro['situacao']['valor'] == 'null') {
            $sql .= ' and tab_ad.situacao is null';
        } else {
            $sql .= ' and tab_ad.situacao = ' . aspa($vetFiltro['situacao']['valor']);
        }
    }

    if ($vetFiltro['texto']['valor'] != "") {
        $sql .= ' and ';
        $sql .= ' ( ';
        $sql .= '  lower(e.codigo)      like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
        $sql .= ' or lower(e.descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
        $sql .= ' ) ';
    }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#idt2").cascade("#idt1", {
                ajax: {
                    url: ajax_sistema + '?tipo=pa_unidade&cas=' + conteudo_abrir_sistema
                }
            });

            $("#id_usuario5").cascade("#idt1", {
                ajax: {
                    url: ajax_sistema + '?tipo=usuario_pa&cas=' + conteudo_abrir_sistema
                }
            });
        });

        function fncListarCmbMuda_idt3() {
            $('#idt4_bt_limpar').click();
        }

        function parListarCmb_idt4() {
            var par = '';

            if ($('#idt3').val() == '') {
                alert('Favor informar o Projeto!');
                return false;
            } else {
                par += '&idt_projeto=' + $('#idt3').val();
            }

            return par;
        }
    </script>
    <?php
}