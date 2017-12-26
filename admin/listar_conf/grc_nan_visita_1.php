<?php
if ($num_visita == '') {
    $num_visita = 1;
}

set_time_limit(600);

$ordFiltro = false;
$idCampo = 'idt';
$Tela = "o Atendimento";

$listar_sql_limit = false;

$TabelaPrinc = "grc_atendimento";
$AliasPric = "grc_atd";
$Entidade = "Atendimento";
$Entidade_p = "Atendimentos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$_SESSION[CS]['grc_atendimento_listar'] = $_SERVER['REQUEST_URI'];

$tudo = acesso($menu, "'PER'", false);

$barra_inc_ap = false;
$barra_alt_ap = false;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;

$novoprefixo = 'inc';

unset($_GET['aba']);

function func_trata_row_grc_atendimento($row) {
    global $barra_alt_ap, $barra_exc_ap, $num_visita;

    $barra_alt_ap = false;
    $barra_exc_ap = false;

    if ($row['status_'.$num_visita] == 'CD' || $row['status_'.$num_visita] == 'DI' || $row['status_'.$num_visita] == 'AT' || $row['status_'.$num_visita] == 'DE') {
        $barra_alt_ap = true;
        $barra_exc_ap = true;
    }
}

if (!$tudo) {
    $barra_icone = 34;
    $func_trata_row = func_trata_row_grc_atendimento;
}

$barra_inc_img = "imagens/incluir_novo_atendimento.png";

$barra_inc_h = 'Clique aqui para Incluir um Novo Atendimento';
$barra_alt_h = 'Alterar o Atendimento';
$barra_con_h = 'Consultar o Atendimento';

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$Filtro = Array();
$sql = 'select idt, descricao  ';
$sql .= ' from '.db_pir.'sca_organizacao_secao ';
$sql .= " where tipo_estrutura = 'UR' ";
$sql .= ' order by descricao ';
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'filtro_unidade';
$Filtro['id_select'] = 'idt';
$Filtro['LinhaUm'] = ' ';
$Filtro['nome'] = 'Unidade';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_unidade'] = $Filtro;

$sql = '';
$sql .= ' select distinct u.id_usuario as idt, u.nome_completo';
$sql .= ' from '.db_pir_gec.'gec_entidade gec_e ';
$sql .= ' inner join plu_usuario u on u.login = gec_e.codigo';
$sql .= " where credenciado_nan = 'S'";
$sql .= " and credenciado = 'S'";
$sql .= " and nan_ano = ".aspa(nan_ano);
$sql .= " and reg_situacao = 'A'";
$sql .= " and tipo_entidade = 'O'";
$sql .= ' order by u.nome_completo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'filtro_empresa';
$Filtro['nome'] = 'Empresa Credenciada';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_empresa'] = $Filtro;

$sql = '';
$sql .= ' select distinct u.id_usuario, u.nome_completo';
$sql .= ' from grc_nan_estrutura e';
$sql .= ' inner join plu_usuario u on u.id_usuario = e.idt_usuario';
$sql .= ' where e.idt_nan_tipo = 5';

if ($vetFiltro['filtro_unidade']['valor'] != "" && $vetFiltro['filtro_unidade']['valor'] != "0" && $vetFiltro['filtro_unidade']['valor'] != "-1") {
    $sql .= ' and e.idt_ponto_atendimento = '.null($vetFiltro['filtro_unidade']['valor']);
}

$sql .= ' order by u.nome_completo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'id_usuario';
$Filtro['id'] = 'filtro_tutor';
$Filtro['nome'] = 'Tutor';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_tutor'] = $Filtro;

$sql = '';
$sql .= ' select distinct u.id_usuario, u.nome_completo';
$sql .= ' from grc_nan_estrutura e';
$sql .= ' inner join plu_usuario u on u.id_usuario = e.idt_usuario';
$sql .= ' where e.idt_nan_tipo = 6';

if ($vetFiltro['filtro_unidade']['valor'] != "" && $vetFiltro['filtro_unidade']['valor'] != "0" && $vetFiltro['filtro_unidade']['valor'] != "-1") {
    $sql .= ' and e.idt_ponto_atendimento = '.null($vetFiltro['filtro_unidade']['valor']);
}

$sql .= ' order by u.nome_completo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'id_usuario';
$Filtro['id'] = 'filtro_aoe';
$Filtro['nome'] = 'AOE';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_aoe'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'ListarCmb';
$Filtro['arq'] = 'grc_projeto';
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'filtro_projeto';
$Filtro['nome'] = 'Projeto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_projeto'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'ListarCmb';
$Filtro['arq'] = 'grc_projeto_acao';
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'filtro_acao';
$Filtro['nome'] = 'Ação';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_acao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_lancamento_ini';
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Dt. Lançamento de';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_dt_lancamento_ini'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_lancamento_fim';
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Dt. Lançamento até';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_dt_lancamento_fim'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_aprovacao_ini';
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Dt. Aprovação de';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_dt_aprovacao_ini'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_aprovacao_fim';
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Dt. Aprovação até';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_dt_aprovacao_fim'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_texto'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Hidden';
$Filtro['id'] = 'pesquisa';
$Filtro['valor'] = 'S';
$vetFiltro['pesquisa'] = $Filtro;

if ($tudo) {
    $vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Consultor');
}

$vetCampo['protocolo'] = CriaVetTabela('Protocolo');
$vetCampo['ap_cpf'] = CriaVetTabela('CPF / Cliente');
$vetCampo['cnpj_porte'] = CriaVetTabela('CNPJ / Empreendimento');
$vetCampo['data'] = CriaVetTabela('Data', 'data');
$vetCampo['hora_inicio_atendimento'] = CriaVetTabela('Hora Inicial');
$vetCampo['hora_termino_atendimento'] = CriaVetTabela('Hora Final');
$vetCampo['status_'.$num_visita] = CriaVetTabela('Situação', 'descDominio', $vetNanGrupo);

$sql = "select {$AliasPric}.*, ";
$sql .= ' ga.status_'.$num_visita.', xpen.dt_update,';
$sql .= " plu_usu.nome_completo as plu_usu_nome_completo, ";
$sql .= " concat_ws('<br />', ap.cpf, ap.nome) as ap_cpf,";
$sql .= " concat_ws('<br />', ao.cnpj, ao.razao_social) as cnpj_porte";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " inner join grc_nan_grupo_atendimento ga on ga.idt = {$AliasPric}.idt_grupo_atendimento ";
$sql .= " left outer join grc_atendimento_pessoa ap on ap.idt_atendimento = {$AliasPric}.idt and ap.tipo_relacao = 'L'";
$sql .= " left outer join grc_atendimento_organizacao ao on ao.idt_atendimento = {$AliasPric}.idt and ao.representa = 'S' and ao.desvincular = 'N'";
$sql .= " left outer join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_consultor ";
$sql .= ' left outer join (';
$sql .= ' select pen.idt_atendimento, max(pen.dt_update) as dt_update';
$sql .= ' from grc_atendimento_pendencia pen';
$sql .= " where pen.status = 'Aprovação'";
$sql .= " and pen.tipo = 'NAN - Visita {$num_visita}'";
$sql .= ' group by pen.idt_atendimento';
$sql .= " ) xpen on xpen.idt_atendimento = {$AliasPric}.idt ";
$sql .= ' where '.$AliasPric.'.nan_num_visita = '.null($num_visita);

if ($vetFiltro['filtro_unidade']['valor'] != "" && $vetFiltro['filtro_unidade']['valor'] != "0" && $vetFiltro['filtro_unidade']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_unidade = '.null($vetFiltro['filtro_unidade']['valor']);
}

if ($vetFiltro['filtro_empresa']['valor'] != "" && $vetFiltro['filtro_empresa']['valor'] != "0" && $vetFiltro['filtro_empresa']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_nan_empresa = '.null($vetFiltro['filtro_empresa']['valor']);
}

if ($vetFiltro['filtro_tutor']['valor'] != "" && $vetFiltro['filtro_tutor']['valor'] != "0" && $vetFiltro['filtro_tutor']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_nan_tutor = '.null($vetFiltro['filtro_tutor']['valor']);
}

if ($vetFiltro['filtro_aoe']['valor'] != "" && $vetFiltro['filtro_aoe']['valor'] != "0" && $vetFiltro['filtro_aoe']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_consultor = '.null($vetFiltro['filtro_aoe']['valor']);
}

if ($vetFiltro['idt_projeto']['valor'] != "" && $vetFiltro['idt_projeto']['valor'] != "0" && $vetFiltro['idt_projeto']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_projeto = '.null($vetFiltro['idt_projeto']['valor']);
}

if ($vetFiltro['idt_acao']['valor'] != "" && $vetFiltro['idt_acao']['valor'] != "0" && $vetFiltro['idt_acao']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_acao = '.null($vetFiltro['idt_acao']['valor']);
}

if ($vetFiltro['filtro_dt_lancamento_ini']['valor'] != "") {
    $sql .= ' and '.$AliasPric.'.data >= '.aspa(trata_data($vetFiltro['filtro_dt_lancamento_ini']['valor']));
}

if ($vetFiltro['filtro_dt_lancamento_fim']['valor'] != "") {
    $sql .= ' and '.$AliasPric.'.data <= '.aspa(trata_data($vetFiltro['filtro_dt_lancamento_fim']['valor']));
}

if ($vetFiltro['filtro_dt_aprovacao_ini']['valor'] != "") {
    $sql .= ' and xpen.dt_update >= '.aspa(trata_data($vetFiltro['filtro_dt_aprovacao_ini']['valor']));
}

if ($vetFiltro['filtro_dt_aprovacao_fim']['valor'] != "") {
    $sql .= ' and xpen.dt_update <= '.aspa(trata_data($vetFiltro['filtro_dt_aprovacao_fim']['valor']).' 23:59:59');
}

if ($vetFiltro['filtro_texto']['valor'] != "") {
    $sql .= ' and ( ';
    $sql .= '    lower('.$AliasPric.'.protocolo) like lower('.aspa($vetFiltro['filtro_texto']['valor'], '%', '%').')';
    $sql .= ' or lower(ap.cpf) like lower('.aspa($vetFiltro['filtro_texto']['valor'], '%', '%').')';
    $sql .= ' or lower(ap.nome) like lower('.aspa($vetFiltro['filtro_texto']['valor'], '%', '%').')';
    $sql .= ' or lower(ao.cnpj) like lower('.aspa($vetFiltro['filtro_texto']['valor'], '%', '%').')';
    $sql .= ' or lower(ao.razao_social) like lower('.aspa($vetFiltro['filtro_texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

if (!$tudo) {
    $sql .= " and {$AliasPric}.idt_consultor = ".null($_SESSION[CS]['g_id_usuario']);
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#filtro_tutor").cascade("#filtro_unidade", {
            ajax: {
                url: ajax_sistema + '?tipo=nan_registro_pa&nan_tipo=5&cas=' + conteudo_abrir_sistema
            }
        });

        $("#filtro_aoe").cascade("#filtro_unidade", {
            ajax: {
                url: ajax_sistema + '?tipo=nan_registro_pa&nan_tipo=6&cas=' + conteudo_abrir_sistema
            }
        });
    });

    function fncListarCmbMuda_filtro_projeto() {
        $('#filtro_acao_bt_limpar').click();
    }

    function parListarCmb_filtro_acao() {
        var par = '';

        if ($('#filtro_projeto').val() == '') {
            alert('Favor informar o Projeto!');
            return false;
        } else {
            par += '&idt_projeto=' + $('#filtro_projeto').val();
        }

        return par;
    }
</script>