<?php
$listar_sql_limit = false;
$reg_pagina_esp = 100;
$ListarBtSelecionar = 'Enviar Publica��o para Aprova��o';
$prefixo = 'listar_cmbmulti_acao';
$btListarBtVoltarMulti = false;

$_SESSION[CS]['g_nom_tela'] = 'Publicar Evento';

$idCampo = 'idt_reg';
$idCampoPar = 'idt_reg';

$Tela = "a Programa��o do Evento";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$TabelaPrinc = "grc_evento";
$AliasPric = "grc_prop";
$Entidade = "Programa��o do Evento";
$Entidade_p = "Programa��es do Evento";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";
// Descida para o nivel 2

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_atendimento_instrumento';
$sql .= ' where idt in (40, 47, 46, 49, 50, 2, 41, 45, 48, 52)';
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
$Filtro['nome'] = 'A��o';
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
$Filtro['nome'] = 'Respons�vel pelo Evento';
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

$sql = "select idt,  descricao from grc_foco_tematico ";
$sql .= " where ativo = 'S'";
$sql .= " order by codigo";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm'] = ' ';
$Filtro['nome'] = 'Tema';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_foco_tematico'] = $Filtro;

$sql = "select idt,  descricao from grc_publico_alvo ";
$sql .= " where ativo = 'S'";
$sql .= " order by descricao";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm'] = ' ';
$Filtro['nome'] = 'P�blico Alvo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_publico_alvo'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = $vetSimNao;
$Filtro['id'] = 'gratuito';
$Filtro['nome'] = 'Gratuito';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['gratuito'] = $Filtro;

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
$sql .= ' and idt in (14, 16, 15)';
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
    'N' => 'N�o SGTEC',
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

require_once 'fncCampo.php';

$Filtro = Array();
$Filtro['rs'] = 'Hidden';
$Filtro['id'] = 'session_cod';
$Filtro['valor'] = trata_id($Filtro);

if ($Filtro['valor'] == '') {
    $Filtro['valor'] = GerarStr();

    $vetRetorno = Array(
        vetRetorno('idt', '', false),
        vetRetorno('idt_unidade', '', false),
        vetRetorno('unidade', '', false),
        vetRetorno('publica_internet', '', false),
        vetRetorno('pubilcar_situacao', '', false),
        vetRetorno('codigo', '', true),
        vetRetorno('descricao', '', true),
    );

    $_SESSION[CS]['objListarCmbMulti'][$Filtro['valor']] = Array(
        'vet_retorno' => $vetRetorno,
        'sel_final' => Array(),
        'sel_trab' => Array(),
    );
}

$vetFiltro['session_cod'] = $Filtro;
$_GET['session_cod'] = $vetFiltro['session_cod']['valor'];

$vetCampo['codigo'] = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('T�tulo Comercial', 'func_trata_dado', ftd_grc_evento);
$vetCampo['dt_previsao_inicial'] = CriaVetTabela('Data In�cio', 'data');
$vetCampo['dt_previsao_fim'] = CriaVetTabela('Data T�rmino', 'data');
$vetCampo['cidade'] = CriaVetTabela('Cidade');
$vetCampo['valor_inscricao'] = CriaVetTabela('Valor', 'decimal');
$vetCampo['pubilcar_situacao'] = CriaVetTabela('Status de Publica��o', 'func_trata_dado', ftd_grc_evento);

/*
  $vetCampo['gestor'] = CriaVetTabela('Respons�vel pelo Evento');
  $vetCampo['hora_inicio'] = CriaVetTabela('Hor�rio');
  $vetCampo['sala'] = CriaVetTabela('Local');
  $vetCampo['grc_ersit_descricao'] = CriaVetTabela('Status', 'func_trata_dado', ftd_grc_evento);
  $vetCampo['composto'] = CriaVetTabela('Tipo', 'func_trata_dado', ftd_grc_evento);
  $vetCampo['ordem_contratacao'] = CriaVetTabela('Rodizio', 'func_trata_dado', ftd_grc_evento);
 */

$sql = "select ";
$sql .= "   {$AliasPric}.*,  ";
$sql .= " coalesce({$AliasPric}.idt_evento_pai, {$AliasPric}.idt) as idt_reg,";
$sql .= "    cid.desccid as cidade,";
$sql .= "    loc.descricao as sala,";
$sql .= "    und.descricao as unidade,";
$sql .= "    gp.nome_completo as gestor,";
$sql .= "    grc_ersit.descricao as grc_ersit_descricao,";
$sql .= "    grc_ersit_ant.descricao as grc_ersit_ant_descricao,";
$sql .= '    epe.situacao as pubilcar_situacao,';
$sql .= '    null as ordem_contratacao, gec_pr.tipo_ordem as grc_pr_tipo_ordem';
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " inner join grc_evento_situacao grc_ersit on grc_ersit.idt = {$AliasPric}.idt_evento_situacao ";
$sql .= " left outer join grc_evento_situacao grc_ersit_ant on grc_ersit_ant.idt = {$AliasPric}.idt_evento_situacao_ant ";
$sql .= " left outer join " . db_pir_siac . "cidade cid on cid.codcid = {$AliasPric}.idt_cidade ";
$sql .= " left outer join grc_evento_local_pa loc on loc.idt = {$AliasPric}.idt_local ";
$sql .= " left outer join " . db_pir . "sca_organizacao_secao und on und.idt = {$AliasPric}.idt_unidade ";
$sql .= " left outer join " . db_pir_gec . "gec_programa gec_pr on gec_pr.idt = {$AliasPric}.idt_programa";
$sql .= " left outer join plu_usuario gp on gp.id_usuario = {$AliasPric}.idt_gestor_evento ";
$sql .= " left outer join grc_evento_publicar_evento epe on epe.idt_evento = {$AliasPric}.idt ";
$sql .= " where {$AliasPric}.idt_evento_situacao in (14, 15, 16)";
$sql .= " and {$AliasPric}.idt_evento_pai is null";

if ($vetFiltro['instrumento']['valor'] != "" && $vetFiltro['instrumento']['valor'] != "0" && $vetFiltro['instrumento']['valor'] != "-1") {
    $sql .= ' and ' . $AliasPric . '.idt_instrumento = ' . null($vetFiltro['instrumento']['valor']);
}

if ($vetFiltro['idt_unidade']['valor'] != "" && $vetFiltro['idt_unidade']['valor'] != "0" && $vetFiltro['idt_unidade']['valor'] != "-1") {
    $sql .= ' and ' . $AliasPric . '.idt_unidade = ' . null($vetFiltro['idt_unidade']['valor']);
}

if ($vetFiltro['idt_ponto_atendimento_tela']['valor'] != "" && $vetFiltro['idt_ponto_atendimento_tela']['valor'] != "0" && $vetFiltro['idt_ponto_atendimento_tela']['valor'] != "-1") {
    $sql .= ' and ' . $AliasPric . '.idt_ponto_atendimento_tela = ' . null($vetFiltro['idt_ponto_atendimento_tela']['valor']);
}

if ($vetFiltro['idt_projeto']['valor'] != "" && $vetFiltro['idt_projeto']['valor'] != "0" && $vetFiltro['idt_projeto']['valor'] != "-1") {
    $sql .= ' and ' . $AliasPric . '.idt_projeto = ' . null($vetFiltro['idt_projeto']['valor']);
}

if ($vetFiltro['idt_acao']['valor'] != "" && $vetFiltro['idt_acao']['valor'] != "0" && $vetFiltro['idt_acao']['valor'] != "-1") {
    $sql .= ' and ' . $AliasPric . '.idt_acao = ' . null($vetFiltro['idt_acao']['valor']);
}

if ($vetFiltro['idt_gestor_evento']['valor'] != "" && $vetFiltro['idt_gestor_evento']['valor'] != "0" && $vetFiltro['idt_gestor_evento']['valor'] != "-1") {
    $sql .= ' and ' . $AliasPric . '.idt_gestor_evento = ' . null($vetFiltro['idt_gestor_evento']['valor']);
}

if ($vetFiltro['idt_cidade']['valor'] != "" && $vetFiltro['idt_cidade']['valor'] != "0" && $vetFiltro['idt_cidade']['valor'] != "-1") {
    $sql .= ' and ' . $AliasPric . '.idt_cidade = ' . null($vetFiltro['idt_cidade']['valor']);
}

if ($vetFiltro['idt_foco_tematico']['valor'] != "" && $vetFiltro['idt_foco_tematico']['valor'] != "0" && $vetFiltro['idt_foco_tematico']['valor'] != "-1") {
    $sql .= " and {$AliasPric}.idt_foco_tematico = " . null($vetFiltro['idt_foco_tematico']['valor']);
}

if ($vetFiltro['idt_publico_alvo']['valor'] != "" && $vetFiltro['idt_publico_alvo']['valor'] != "0" && $vetFiltro['idt_publico_alvo']['valor'] != "-1") {
    $sql .= ' and exists (';
    $sql .= ' select idt';
    $sql .= ' from grc_evento_publico_alvo';
    $sql .= " where idt = {$AliasPric}.idt";
    $sql .= " and ativo = 'S'";
    $sql .= ' and idt_publico_alvo_outro = ' . null($vetFiltro['idt_publico_alvo']['valor']);
    $sql .= ' )';
}

if ($vetFiltro['gratuito']['valor'] == "N") {
    $sql .= " and ({$AliasPric}.gratuito is null or {$AliasPric}.gratuito <> 'S')";
} else if ($vetFiltro['gratuito']['valor'] == "S") {
    $sql .= " and {$AliasPric}.gratuito = 'S'";
}
if ($vetFiltro['dt_ini']['valor'] != "") {
    $sql .= ' and ' . $AliasPric . '.dt_previsao_inicial >= ' . aspa(trata_data($vetFiltro['dt_ini']['valor']));
}

if ($vetFiltro['dt_fim']['valor'] != "") {
    $sql .= ' and ' . $AliasPric . '.dt_previsao_inicial <= ' . aspa(trata_data($vetFiltro['dt_fim']['valor']));
}

if ($vetFiltro['idt_evento_situacao']['valor'] != "" && $vetFiltro['idt_evento_situacao']['valor'] != "0" && $vetFiltro['idt_evento_situacao']['valor'] != "-1") {
    $sql .= ' and ' . $AliasPric . '.idt_evento_situacao = ' . null($vetFiltro['idt_evento_situacao']['valor']);
}

if ($vetFiltro['programa_sgtec']['valor'] == "N") {
    $sql .= " and (gec_pr.tipo_ordem is null or gec_pr.tipo_ordem <> 'SG')";
} else if ($vetFiltro['programa_sgtec']['valor'] == "S") {
    $sql .= " and gec_pr.tipo_ordem = 'SG'";
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower(' . $AliasPric . '.codigo)      like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(' . $AliasPric . '.descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
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

    function ListarBtSelecionarMultiAcao() {
        if ($('.ListarCmbMulti > li').length == 0) {
            alert('Favor selecionar um registro!');
            return false;
        }

        if (!confirm('Deseja enviar para aprova��o da publica��o dos Eventos selecionados?')) {
            return false;
        }

        var par = '';
        par += '?prefixo=cadastro';
        par += '&menu=grc_evento_publicar';
        par += '&session_cod=<?php echo $_GET['session_cod']; ?>';
        par += '&cas=' + conteudo_abrir_sistema;
        var url = 'conteudo_cadastro.php' + par;
        showPopWin(url, 'Publicar / Despublicar Eventos', $('div.showPopWin_width').width() - 30, $(window).height() - 100, null, true);
    }
</script>