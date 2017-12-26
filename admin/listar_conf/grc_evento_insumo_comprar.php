<?php
$idCampo = 'idt';
$Tela = "a Programação do Evento";

$barra_inc_ap = false;
$barra_alt_ap = true;
$barra_con_ap = true;
$barra_exc_ap = false;

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

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from '.db_pir.'sca_organizacao_secao';
$sql .= " where posto_atendimento <> 'S' ";
$sql .= ' order by classificacao';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Unidade Demandante';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_unidade'] = $Filtro;

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

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'dt_ini';
$Filtro['nome'] = 'Dt. Inicio Evento de';
$Filtro['js'] = 'data';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_ini'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'dt_fim';
$Filtro['nome'] = 'Dt. Inicio Evento ate';
$Filtro['js'] = 'data';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_fim'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'dt_ini_sol';
$Filtro['nome'] = 'Dt. da Solicitação à CAD de';
$Filtro['js'] = 'data';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_ini_sol'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'dt_fim_sol';
$Filtro['nome'] = 'Dt. da Solicitação à CAD  ate';
$Filtro['js'] = 'data';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_fim_sol'] = $Filtro;

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_evento_situacao';
$sql .= " where ativo = 'S'";
$sql .= ' and idt >= 14';
$sql .= ' order by codigo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Status do Evento';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_evento_situacao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = $vetEventoStsEntrega;
$Filtro['id'] = 'envio_sts_entrega';
$Filtro['nome'] = 'Status do Envio';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['envio_sts_entrega'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Código do Evento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['codigo'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = $vetSimNao;
$Filtro['id'] = 'fil_estocavel';
$Filtro['nome'] = 'Estocavel';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['estocavel'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'ListarCmb';
$Filtro['arq'] = 'grc_insumo_cmb';
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'fil_idt_insumo';
$Filtro['nome'] = 'Insumo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_insumo'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['codigo'] = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Evento', 'func_trata_dado', ftd_grc_evento);
$vetCampo['cidade'] = CriaVetTabela('Cidade');
$vetCampo['dt_previsao_inicial'] = CriaVetTabela('Data Início', 'data');
$vetCampo['hora_inicio'] = CriaVetTabela('Horário');
$vetCampo['sala'] = CriaVetTabela('Local');
$vetCampo['grc_ersit_descricao'] = CriaVetTabela('Status', 'func_trata_dado', ftd_grc_evento);
$vetCampo['envio_sts_entrega'] = CriaVetTabela('Status da Entrega', 'descDominio', $vetEventoStsEntrega);

$sql = "select ";
$sql .= "   {$AliasPric}.*,  ";
$sql .= "    cid.desccid as cidade,";
$sql .= "    loc.descricao as sala,";
$sql .= "    und.descricao as unidade,";
$sql .= "    grc_ersit.descricao as grc_ersit_descricao,";
$sql .= "    grc_ersit_ant.descricao as grc_ersit_ant_descricao";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " inner join grc_evento_situacao grc_ersit on grc_ersit.idt = {$AliasPric}.idt_evento_situacao ";
$sql .= " left outer join grc_evento_situacao grc_ersit_ant on grc_ersit_ant.idt = {$AliasPric}.idt_evento_situacao_ant ";
$sql .= " left outer join ".db_pir_siac."cidade cid on cid.codcid = {$AliasPric}.idt_cidade ";
$sql .= " left outer join grc_evento_local_pa loc on loc.idt = {$AliasPric}.idt_local ";
$sql .= " left outer join ".db_pir."sca_organizacao_secao und on und.idt = {$AliasPric}.idt_unidade ";
$sql .= " where {$AliasPric}.temporario <> 'S'";

if ($vetFiltro['idt_unidade']['valor'] != "" && $vetFiltro['idt_unidade']['valor'] != "0" && $vetFiltro['idt_unidade']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_unidade = '.null($vetFiltro['idt_unidade']['valor']);
}

if ($vetFiltro['idt_gestor_evento']['valor'] != "" && $vetFiltro['idt_gestor_evento']['valor'] != "0" && $vetFiltro['idt_gestor_evento']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_gestor_evento = '.null($vetFiltro['idt_gestor_evento']['valor']);
}

if ($vetFiltro['dt_ini']['valor'] != "") {
    $sql .= ' and '.$AliasPric.'.dt_previsao_inicial >= '.aspa(trata_data($vetFiltro['dt_ini']['valor']));
}

if ($vetFiltro['dt_fim']['valor'] != "") {
    $sql .= ' and '.$AliasPric.'.dt_previsao_inicial <= '.aspa(trata_data($vetFiltro['dt_fim']['valor']).' 23:59:59');
}

$sqlSol = '';
$sqlSol .= ' (select ap.dt_update';
$sqlSol .= ' from grc_atendimento_pendencia ap';
$sqlSol .= " where ap.idt_evento = {$AliasPric}.idt";
$sqlSol .= ' and ap.idt_evento_situacao_para = 14';
$sqlSol .= ' order by ap.dt_update desc limit 1)';

if ($vetFiltro['dt_ini_sol']['valor'] != "") {
    $sql .= ' and '.$sqlSol.' >= '.aspa(trata_data($vetFiltro['dt_ini_sol']['valor']));
}

if ($vetFiltro['dt_fim_sol']['valor'] != "") {
    $sql .= ' and '.$sqlSol.' <= '.aspa(trata_data($vetFiltro['dt_fim_sol']['valor']).' 23:59:59');
}

if ($vetFiltro['idt_evento_situacao']['valor'] != "" && $vetFiltro['idt_evento_situacao']['valor'] != "0" && $vetFiltro['idt_evento_situacao']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_evento_situacao = '.null($vetFiltro['idt_evento_situacao']['valor']);
} else {
    $sql .= ' and '.$AliasPric.'.idt_evento_situacao >= 14';
}

if ($vetFiltro['envio_sts_entrega']['valor'] != "" && $vetFiltro['envio_sts_entrega']['valor'] != "0" && $vetFiltro['envio_sts_entrega']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.envio_sts_entrega = '.aspa($vetFiltro['envio_sts_entrega']['valor']);
}

if ($vetFiltro['codigo']['valor'] != "") {
    $sql .= ' and lower('.$AliasPric.'.codigo) like lower('.aspa($vetFiltro['codigo']['valor'], '%', '%').')';
}

if ($vetFiltro['estocavel']['valor'] != "" && $vetFiltro['estocavel']['valor'] != "0" && $vetFiltro['estocavel']['valor'] != "-1") {
    $sql .= ' and exists (';
    $sql .= ' select ei.idt';
    $sql .= ' from grc_evento_insumo ei';
    $sql .= " inner join grc_insumo grc_pp on grc_pp.idt = ei.idt_insumo ";
    $sql .= ' where ei.estocavel = '.aspa($vetFiltro['estocavel']['valor']);
    $sql .= " and ei.idt_evento = {$AliasPric}.idt";
    $sql .= " and grc_pp.sinal = 'S'"; // despesa
    $sql .= ' )';
}

if ($vetFiltro['idt_insumo']['valor'] != "" && $vetFiltro['idt_insumo']['valor'] != "0" && $vetFiltro['idt_insumo']['valor'] != "-1") {
    $sql .= ' and exists (';
    $sql .= ' select ei.idt';
    $sql .= ' from grc_evento_insumo ei';
    $sql .= ' where ei.idt_insumo = '.null($vetFiltro['idt_insumo']['valor']);
    $sql .= " and ei.idt_evento = {$AliasPric}.idt";
    $sql .= ' )';
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and (';
    $sql .= '    lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' )';
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#id_usuario1").cascade("#idt0", {
            ajax: {
                url: ajax_sistema + '?tipo=usuario_pa&cas=' + conteudo_abrir_sistema
            }
        });
    });

    function parListarCmb_fil_idt_insumo8() {
        var par = '';

        par += '&veio=S';

        return par;
    }
</script>