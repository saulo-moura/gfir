<?php
$ordFiltro = false;
$idCampo = 'idt';
$Tela = "a Evento";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

//$bt_print = false;

$barra_inc_ap = false;
$barra_alt_ap = false;
$barra_con_ap = false;
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
$sql .= ' from '.db_pir_gec.'gec_programa';
$sql .= " where ativo = 'S' and idt=4";
$sql .= ' order by descricao';
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'f_idt_programa';
$Filtro['id_select'] = 'idt';
//$Filtro['LinhaUm'] = '-- Todos os Programas --';
$Filtro['nome'] = 'Programas';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_programa'] = $Filtro;

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from '.db_pir.'sca_organizacao_secao';
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

$sql = "select idt,  descricao from ".db_pir."sca_organizacao_secao ";
$sql .= ' where SUBSTRING(classificacao, 1, 5) = (';
$sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
$sql .= ' from '.db_pir.'sca_organizacao_secao';
$sql .= ' where idt = '.null($vetFiltro['idt_unidade']['valor']);
$sql .= ' )';
$sql .= ' and idt <> '.null($vetFiltro['idt_unidade']['valor']);
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
    $sql .= " select idt from ".db_pir."sca_organizacao_secao ";
    $sql .= ' where SUBSTRING(classificacao, 1, 5) = (';
    $sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
    $sql .= ' from '.db_pir.'sca_organizacao_secao';
    $sql .= ' where idt = '.null($vetFiltro['idt_unidade']['valor']);
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
$sql .= ' from '.db_pir_siac.'cidade';
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
$Filtro['vlPadrao'] = Date('d/m/Y', strtotime('-90 day'));
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_dt_ini'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'f_dt_fim';
$Filtro['nome'] = 'Data Início até';
$Filtro['js'] = 'data';
$Filtro['vlPadrao'] = Date('d/m/Y', strtotime('+7 day'));
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_dt_fim'] = $Filtro;

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_evento_situacao';
$sql .= " where ativo = 'S'";
$sql .= ' order by codigo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_evento_situacao';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Status';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_evento_situacao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'f_texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_texto'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = Array(
    'P' => 'Empenhado',
    'R' => 'Realizado',
    'N' => 'Falta Empenhar',
);
$Filtro['id'] = 'f_rm_consolidado';
$Filtro['nome'] = 'RM Consolidação';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_rm_consolidado'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = $vetAFProcessoSit;
$Filtro['id'] = 'f_situacao_reg';
$Filtro['nome'] = 'Situação do Processo';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_situacao_reg'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'f_chave_sgc';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Chave SGC';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_chave_sgc'] = $Filtro;

$vetCampo['codigo'] = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Evento', 'func_trata_dado', ftd_grc_evento_monitoramento);
$vetCampo['instrumento_desc'] = CriaVetTabela('Instrumento');
$vetCampo['dt_previsao_inicial'] = CriaVetTabela('Data Início', 'data');
$vetCampo['dt_previsao_fim'] = CriaVetTabela('Data Final', 'data');
$vetCampo['grc_ersit_descricao'] = CriaVetTabela('Status', 'func_trata_dado', ftd_grc_evento_monitoramento);
$vetCampo['aprovador'] = CriaVetTabela('Aprovador');
$vetCampo['ordem_contratacao'] = CriaVetTabela('Ordem', 'func_trata_dado', ftd_grc_evento_monitoramento);
$vetCampo['rm_consolidado'] = CriaVetTabela('GC - RM', 'func_trata_dado', ftd_grc_evento_monitoramento);
$vetCampo['situacao_reg'] = CriaVetTabela('Portal', 'func_trata_dado', ftd_grc_evento_monitoramento);

$sql = "select e.*,";
$sql .= " i.descricao as instrumento_desc,";
$sql .= " grc_ersit.descricao as grc_ersit_descricao,";
$sql .= " grc_ersit_ant.descricao as grc_ersit_ant_descricao,";
$sql .= ' (';
$sql .= " select concat_ws('<br />', u.nome_completo, date_format(ap.dt_update, '%d/%m/%Y %H:%i:%s')) as aprovador";
$sql .= ' from grc_atendimento_pendencia ap';
$sql .= ' inner join plu_usuario u on u.id_usuario = ap.idt_usuario_update';
$sql .= ' where ap.idt_evento_situacao_para = 14';
$sql .= ' and ap.idt_evento = e.idt';
$sql .= ' order by ap.dt_update desc limit 1';
$sql .= ' ) as aprovador,';
$sql .= " ord.codigo as ordem_contratacao, ord.chave_sgc,";
$sql .= ' afp.situacao_reg, afp.gfi_situacao,';
$sql .= ' rm.mesano, rm.valor_prev, rm.valor_real, rm.rm_idmov,';
$sql .= ' ord.rm_consolidado';
$sql .= " from grc_evento e";
$sql .= " inner join grc_evento_situacao grc_ersit on grc_ersit.idt = e.idt_evento_situacao";
$sql .= ' inner join grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
$sql .= " left outer join ".db_pir_gec."gec_contratacao_credenciado_ordem ord on ord.idt_evento = e.idt and ord.ativo = 'S'";
$sql .= " left outer join ".db_pir_gec."gec_contratacao_credenciado_ordem_rm rm on rm.idt_gec_contratacao_credenciado_ordem = ord.idt";
$sql .= " left outer join grc_evento_situacao grc_ersit_ant on grc_ersit_ant.idt = e.idt_evento_situacao_ant ";
$sql .= " left outer join ".db_pir_pfo."pfo_af_processo afp on afp.idmov = rm.rm_idmov";
$sql .= ' left outer join grc_produto pr on pr.idt = e.idt_produto';
$sql .= " where (";
$sql .= " e.temporario <> 'S'";
$sql .= " or (e.temporario = 'S' and e.idt_responsavel = ".null($_SESSION[CS]['g_id_usuario']).")";
$sql .= " )";

if ($vetFiltro['f_idt_instrumento']['valor'] != "" && $vetFiltro['f_idt_instrumento']['valor'] != "0" && $vetFiltro['f_idt_instrumento']['valor'] != "-1") {
    $sql .= ' and e.idt_instrumento = '.null($vetFiltro['f_idt_instrumento']['valor']);
}

if ($vetFiltro['f_idt_unidade']['valor'] != "" && $vetFiltro['f_idt_unidade']['valor'] != "0" && $vetFiltro['f_idt_unidade']['valor'] != "-1") {
    $sql .= ' and e.idt_unidade = '.null($vetFiltro['f_idt_unidade']['valor']);
}

if ($vetFiltro['f_idt_ponto_atendimento_tela']['valor'] != "" && $vetFiltro['f_idt_ponto_atendimento_tela']['valor'] != "0" && $vetFiltro['f_idt_ponto_atendimento_tela']['valor'] != "-1") {
    $sql .= ' and e.idt_ponto_atendimento_tela = '.null($vetFiltro['f_idt_ponto_atendimento_tela']['valor']);
}

if ($vetFiltro['f_idt_projeto']['valor'] != "" && $vetFiltro['f_idt_projeto']['valor'] != "0" && $vetFiltro['f_idt_projeto']['valor'] != "-1") {
    $sql .= ' and e.idt_projeto = '.null($vetFiltro['f_idt_projeto']['valor']);
}

if ($vetFiltro['f_idt_acao']['valor'] != "" && $vetFiltro['f_idt_acao']['valor'] != "0" && $vetFiltro['f_idt_acao']['valor'] != "-1") {
    $sql .= ' and e.idt_acao = '.null($vetFiltro['f_idt_acao']['valor']);
}

if ($vetFiltro['f_idt_gestor_evento']['valor'] != "" && $vetFiltro['f_idt_gestor_evento']['valor'] != "0" && $vetFiltro['f_idt_gestor_evento']['valor'] != "-1") {
    $sql .= ' and e.idt_gestor_evento = '.null($vetFiltro['f_idt_gestor_evento']['valor']);
}

if ($vetFiltro['f_idt_cidade']['valor'] != "" && $vetFiltro['f_idt_cidade']['valor'] != "0" && $vetFiltro['f_idt_cidade']['valor'] != "-1") {
    $sql .= ' and e.idt_cidade = '.null($vetFiltro['f_idt_cidade']['valor']);
}

if ($vetFiltro['f_dt_ini']['valor'] != "") {
    $sql .= ' and e.dt_previsao_inicial >= '.aspa(trata_data($vetFiltro['f_dt_ini']['valor']));
}

if ($vetFiltro['f_dt_fim']['valor'] != "") {
    $sql .= ' and e.dt_previsao_inicial <= '.aspa(trata_data($vetFiltro['f_dt_fim']['valor']));
}

if ($vetFiltro['f_idt_evento_situacao']['valor'] != "" && $vetFiltro['f_idt_evento_situacao']['valor'] != "0" && $vetFiltro['f_idt_evento_situacao']['valor'] != "-1") {
    $sql .= ' and e.idt_evento_situacao = '.null($vetFiltro['f_idt_evento_situacao']['valor']);
}

if ($vetFiltro['f_rm_consolidado']['valor'] != "" && $vetFiltro['f_rm_consolidado']['valor'] != "0" && $vetFiltro['f_rm_consolidado']['valor'] != "-1") {
    $sql .= ' and ord.rm_consolidado = '.aspa($vetFiltro['f_rm_consolidado']['valor']);
}

if ($vetFiltro['f_situacao_reg']['valor'] != "" && $vetFiltro['f_situacao_reg']['valor'] != "0" && $vetFiltro['f_situacao_reg']['valor'] != "-1") {
    $sql .= ' and afp.situacao_reg = '.aspa($vetFiltro['f_situacao_reg']['valor']);
}

if ($vetFiltro['f_idt_programa']['valor'] != "" && $vetFiltro['f_idt_programa']['valor'] != "0" && $vetFiltro['f_idt_programa']['valor'] != "-1") {
    $sql .= ' and pr.idt_programa = '.null($vetFiltro['f_idt_programa']['valor']);
}

if ($vetFiltro['f_texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '    lower(e.codigo)    like lower('.aspa($vetFiltro['f_texto']['valor'], '%', '%').')';
    $sql .= ' or lower(e.descricao) like lower('.aspa($vetFiltro['f_texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

if ($vetFiltro['f_chave_sgc']['valor'] != "") {
    $sql .= ' and lower(ord.chave_sgc) like lower('.aspa($vetFiltro['f_chave_sgc']['valor'], '%', '%').')';
}
?>
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
</script>