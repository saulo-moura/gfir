<?php
$_SESSION[CS]['grc_evento_nf_listar'] = $_SERVER['REQUEST_URI'];

$listar_sql_limit = false;

$idCampo = 'idt';
$Tela = "a Programação do Evento";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$TabelaPrinc = "grc_evento";
$AliasPric = "grc_prop";
$Entidade = "Programação do Evento";
$Entidade_p = "Programações do Evento";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";
// Descida para o nivel 2

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
$sql .= ' from '.db_pir.'sca_organizacao_secao';
$sql .= " where posto_atendimento <> 'S' ";
$sql .= ' order by classificacao';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Unidade';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_unidade'] = $Filtro;

$sql = "select idt,  descricao from ".db_pir."sca_organizacao_secao ";
//$sql .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S')";
$sql .= ' where SUBSTRING(classificacao, 1, 5) = ('; //and
$sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
$sql .= ' from '.db_pir.'sca_organizacao_secao';
$sql .= ' where idt = '.null($vetFiltro['idt_unidade']['valor']);
$sql .= ' )';
$sql .= ' and idt <> '.null($vetFiltro['idt_unidade']['valor']);
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
$Filtro['id'] = 'id_usuario';
$Filtro['nome'] = 'Responsável pelo Evento';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_gestor_evento'] = $Filtro;

$sql = '';
$sql .= ' select codcid, desccid';
$sql .= ' from '.db_pir_siac.'cidade';
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
$sql .= ' and idt in (14, 16, 19, 20)';
$sql .= ' order by codigo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Status';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_evento_situacao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = Array(
    'T' => 'Todos',
    'N' => 'Não SGTEC',
    'S' => 'SGTEC',
);
$Filtro['id'] = 'programa_sgtec';
$Filtro['nome'] = 'Tipo do Evento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['programa_sgtec'] = $Filtro;

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
$vetCampo['grc_ersit_descricao'] = CriaVetTabela('Status', 'func_trata_dado', ftd_grc_evento);
$vetCampo['composto'] = CriaVetTabela('Tipo', 'func_trata_dado', ftd_grc_evento);
$vetCampo['ordem_contratacao'] = CriaVetTabela('Rodizio', 'func_trata_dado', ftd_grc_evento);

$sql = "select ";
$sql .= "   {$AliasPric}.*,  ";
$sql .= " coalesce({$AliasPric}.idt_evento_pai, {$AliasPric}.idt) as idt,";
$sql .= "    cid.desccid as cidade,";
$sql .= "    loc.descricao as sala,";
$sql .= "    und.descricao as unidade,";
$sql .= "    gp.nome_completo as gestor,";
$sql .= "    grc_ersit.descricao as grc_ersit_descricao,";
$sql .= "    grc_ersit_ant.descricao as grc_ersit_ant_descricao,";
$sql .= '    null as ordem_contratacao, gec_pr.tipo_ordem as grc_pr_tipo_ordem';
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " inner join grc_evento_situacao grc_ersit on grc_ersit.idt = {$AliasPric}.idt_evento_situacao ";
$sql .= " left outer join grc_evento_situacao grc_ersit_ant on grc_ersit_ant.idt = {$AliasPric}.idt_evento_situacao_ant ";
$sql .= " left outer join ".db_pir_siac."cidade cid on cid.codcid = {$AliasPric}.idt_cidade ";
$sql .= " left outer join grc_evento_local_pa loc on loc.idt = {$AliasPric}.idt_local ";
$sql .= " left outer join ".db_pir."sca_organizacao_secao und on und.idt = {$AliasPric}.idt_unidade ";
$sql .= " left outer join ".db_pir_gec."gec_programa gec_pr on gec_pr.idt = {$AliasPric}.idt_programa";
$sql .= " left outer join plu_usuario gp on gp.id_usuario = {$AliasPric}.idt_gestor_evento ";
$sql .= ' where (';
$sql .= " {$AliasPric}.temporario <> 'S'";
$sql .= " or ({$AliasPric}.temporario = 'S' and {$AliasPric}.idt_responsavel = ".null($_SESSION[CS]['g_id_usuario']).")";
$sql .= " )";
$sql .= " and {$AliasPric}.idt_evento_situacao in (14, 16, 19, 20)";
$sql .= " and {$AliasPric}.idt_instrumento not in (52, 54)";
$sql .= " and {$AliasPric}.cred_necessita_credenciado = 'S'";
$sql .= " and {$AliasPric}.nao_sincroniza_rm = 'N'";

if (!acesso($menu, "'PER'", false)) {
    $sql .= " and {$AliasPric}.idt_gestor_evento = ".null($_SESSION[CS]['g_id_usuario']);
}

if ($vetFiltro['instrumento']['valor'] != "" && $vetFiltro['instrumento']['valor'] != "0" && $vetFiltro['instrumento']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_instrumento = '.null($vetFiltro['instrumento']['valor']);
}

if ($vetFiltro['idt_unidade']['valor'] != "" && $vetFiltro['idt_unidade']['valor'] != "0" && $vetFiltro['idt_unidade']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_unidade = '.null($vetFiltro['idt_unidade']['valor']);
}

if ($vetFiltro['idt_ponto_atendimento_tela']['valor'] != "" && $vetFiltro['idt_ponto_atendimento_tela']['valor'] != "0" && $vetFiltro['idt_ponto_atendimento_tela']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_ponto_atendimento_tela = '.null($vetFiltro['idt_ponto_atendimento_tela']['valor']);
}

if ($vetFiltro['idt_projeto']['valor'] != "" && $vetFiltro['idt_projeto']['valor'] != "0" && $vetFiltro['idt_projeto']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_projeto = '.null($vetFiltro['idt_projeto']['valor']);
}

if ($vetFiltro['idt_acao']['valor'] != "" && $vetFiltro['idt_acao']['valor'] != "0" && $vetFiltro['idt_acao']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_acao = '.null($vetFiltro['idt_acao']['valor']);
}

if ($vetFiltro['idt_gestor_evento']['valor'] != "" && $vetFiltro['idt_gestor_evento']['valor'] != "0" && $vetFiltro['idt_gestor_evento']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_gestor_evento = '.null($vetFiltro['idt_gestor_evento']['valor']);
}

if ($vetFiltro['idt_cidade']['valor'] != "" && $vetFiltro['idt_cidade']['valor'] != "0" && $vetFiltro['idt_cidade']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_cidade = '.null($vetFiltro['idt_cidade']['valor']);
}

if ($vetFiltro['dt_ini']['valor'] != "") {
    $sql .= ' and '.$AliasPric.'.dt_previsao_inicial >= '.aspa(trata_data($vetFiltro['dt_ini']['valor']));
}

if ($vetFiltro['dt_fim']['valor'] != "") {
    $sql .= ' and '.$AliasPric.'.dt_previsao_inicial <= '.aspa(trata_data($vetFiltro['dt_fim']['valor']));
}

if ($vetFiltro['idt_evento_situacao']['valor'] != "" && $vetFiltro['idt_evento_situacao']['valor'] != "0" && $vetFiltro['idt_evento_situacao']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_evento_situacao = '.null($vetFiltro['idt_evento_situacao']['valor']);
}

if ($vetFiltro['programa_sgtec']['valor'] == "N") {
    $sql .= " and (gec_pr.tipo_ordem is null or gec_pr.tipo_ordem <> 'SG')";
} else if ($vetFiltro['programa_sgtec']['valor'] == "S") {
    $sql .= " and gec_pr.tipo_ordem = 'SG'";
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
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