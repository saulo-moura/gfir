<style>
    .a_decimal {
        text-align:right;
    }


    td.LinhaFull
    {
        color:#666666;
        font-size:12px;
    }
    .a_data {
        text-align:center;
        background:#FFDFDF;
        border-bottom:1px solid #FFFFFF;
    }
    .d_data {
        text-align:center;
        background:#FFE8E8;
        border-bottom:1px solid #FFFFFF;
    }
    .h_data {
        text-align:center;
        background:#FFC6C6;
        border-bottom:1px solid #FFFFFF;
    }


    .a_centro {
        text-align:center;
    }


    .cab_1_1 {
        text-align:center;
        background: #006ca8;
        color:#FFFFFF;
        border-bottom:1px solid #FFFFFF;
        xheight:20px;
        padding:5px;
        font-size:18px;
    }

    .T_titulo
    {
        text-align:center;
        background: #006ca8;
        color:#FFFFFF;
        border-bottom:1px solid #FFFFFF;
        height:20px;
        padding:5px;
        font-size:18px;
    }
    .L_titulo
    {
        text-align:left;
        background: #006ca8;
        color:#FFFFFF;
        border-bottom:1px solid #FFFFFF;
        height:20px;
        padding:5px;
        font-size:18px;
    }
</style>
<?php
$ordFiltro = false;
$idCampo = 'idt';
$Tela = "a Atendimento";

$TabelaPrinc = "grc_atendimento";
$AliasPric = "grc_aa";
$Entidade = "Atendimento";
$Entidade_p = "Atendimentos";


$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$barra_inc_h = 'Incluir um Novo Atendimento';
$barra_alt_h = 'Alterar o Atendimento';
$barra_con_h = 'Consultar o Atendimento';


$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$delayinicial = '+0 day';

$Filtro = Array();
$Filtro['rs'] = Array(
    'AT' => 'Atendimento de Balcão',
    //'NAN' => 'Atendimento NAN',
);
$Filtro['id'] = 'filtro_atendimento';
$Filtro['nome'] = 'Atendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['atendimento'] = $Filtro;

if ($vetFiltro['atendimento']['valor'] == 'NAN') {
    $comcontrole = 0;
    $barra_inc_ap = false;
    $barra_alt_ap = false;
    $barra_con_ap = false;
    $barra_exc_ap = false;
    $barra_fec_ap = false;
} else {
    $comcontrole = 1;
    $barra_inc_ap = false;
    $barra_alt_ap = true;
    $barra_con_ap = true;
    $barra_exc_ap = false;
    $barra_fec_ap = false;
}

$idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];

$Filtro = Array();
$Filtro['rs'] = Array(
    'IP' => 'Integração Pessoa',
    'IE' => 'Integração Empreendimento',
    'IA' => 'Integração Atendimento',
    'CE' => 'Integração com Erro',
    'SE' => 'Integração sem Erro',
);
$Filtro['id'] = 'filtro_erro';
$Filtro['nome'] = 'Integração com Erro';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['erro'] = $Filtro;

$sql = 'select ';
$sql .= '   idt, descricao  ';
$sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S' ) ";

if ($_SESSION[CS]['g_atendimento_relacao'] == 'G') {
    $sql .= ' and SUBSTRING(classificacao, 1, 5) = ('; //and
    $sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
    $sql .= ' from '.db_pir.'sca_organizacao_secao';
    $sql .= ' where idt = '.null($idt_ponto_atendimento);
    $sql .= ' )';
} else {
    $sql .= "   and idt = ".null($idt_ponto_atendimento);
}

$sql .= ' order by classificacao ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'filtro_ponto_atendimento';
$Filtro['id_select'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Pontos de Atendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;

$sql = "select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
$sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt_usuario = plu_usu.id_usuario ";
$sql .= " where grc_pap.idt_ponto_atendimento = ".null($vetFiltro['ponto_atendimento']['valor']);
$sql .= " order by plu_usu.nome_completo";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'filtro_id_usuario';
$Filtro['id_select'] = 'id_usuario';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Consultores';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_consultor'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_ini';
$Filtro['vlPadrao'] = Date('d/m/Y');
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data Inicial';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_ini'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_fim';
$Filtro['vlPadrao'] = Date('d/m/Y', strtotime($delayinicial));
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data Final';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_fim'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Hidden';
$Filtro['id'] = 'pesquisa';
$Filtro['valor'] = 'S';
$vetFiltro['pesquisa'] = $Filtro;

if ($vetFiltro['ponto_atendimento']['valor'] == -1) {
    $vetCampo['pa_desc'] = CriaVetTabela('Ponto de Atendimento');
}

$vetCampo['protocolocon'] = CriaVetTabela('Protocolo / Consultor');
$vetCampo['situacaoret'] = CriaVetTabela('Situação / Retroativo?');
$vetCampo["datahr"] = CriaVetTabela('Data Inicio até Fim');
$vetCampo['pessoa'] = CriaVetTabela('Cliente / CPF');
$vetCampo['empreendimento'] = CriaVetTabela('Empreendimento / CNPJ');
$vetCampo['siacerro'] = CriaVetTabela('Integrações');

$dt_iniw = trata_data($vetFiltro['dt_ini']['valor']);
$dt_fimw = trata_data($vetFiltro['dt_fim']['valor']);

$sqlTmp = "";
$sqlTmp .= " if({$AliasPric}.data_atendimento_aberta='S', 'Sim',";
$sqlTmp .= " if({$AliasPric}.data_atendimento_aberta='N', 'Não',";
$sqlTmp .= " {$AliasPric}.data_atendimento_aberta))";

$sql = '';
$sql .= " select {$AliasPric}.idt,";
$sql .= " concat_ws('<br />', {$AliasPric}.protocolo, pu.nome_completo) as protocolocon,";
$sql .= " concat_ws('<br />', {$AliasPric}.situacao, {$sqlTmp}) as situacaoret,";
$sql .= " concat_ws('<br />', date_format({$AliasPric}.data, '%d/%m/%Y'), concat_ws(' até ', {$AliasPric}.hora_inicio_atendimento, {$AliasPric}.hora_termino_atendimento)) as datahr,";
$sql .= " concat_ws('<br />', concat_ws('', 'PESSOA: ', date_format(siacf.dt_sincroniza, '%d/%m/%Y %H:%i:%s')), siacf.erro, concat_ws('', 'EMPREENDIMENTO: ', date_format(siacj.dt_sincroniza, '%d/%m/%Y %H:%i:%s')), siacj.erro, concat_ws('', 'ATENDIMENTO: ', date_format(siach.dt_sincroniza, '%d/%m/%Y %H:%i:%s')), siach.erro) as siacerro,";
$sql .= " concat_ws('<br />', ap.nome, ap.cpf) as pessoa,";
$sql .= " concat_ws('<br />', ao.razao_social, ao.cnpj) as empreendimento,";
$sql .= " pa.descricao as pa_desc";
$sql .= " from grc_atendimento {$AliasPric}";
$sql .= " left outer join ".db_pir."sca_organizacao_secao pa on pa.idt = {$AliasPric}.idt_ponto_atendimento";
$sql .= " left outer join plu_usuario as pu on pu.id_usuario = {$AliasPric}.idt_consultor ";
$sql .= " left outer join grc_atendimento_pessoa ap on ap.idt_atendimento = {$AliasPric}.idt and ap.tipo_relacao = 'L'";
$sql .= " left outer join grc_atendimento_organizacao ao on ao.idt_atendimento = {$AliasPric}.idt and ao.representa = 'S' and ao.desvincular = 'N'";
$sql .= " left outer join grc_sincroniza_siac siacf on siacf.idt_atendimento = {$AliasPric}.idt and siacf.tipo_entidade = 'F' and siacf.representa = 'S'";
$sql .= " left outer join grc_sincroniza_siac siacj on siacj.idt_atendimento = {$AliasPric}.idt and siacj.tipo_entidade = 'J' and siacj.representa = 'S'";
$sql .= " left outer join grc_sincroniza_siac siach on siach.idt_atendimento = {$AliasPric}.idt and siach.tipo = 'H'";
$sql .= " where {$AliasPric}.data >= ".aspa($dt_iniw)." and {$AliasPric}.data <=  ".aspa($dt_fimw)." ";
$sql .= " and {$AliasPric}.idt_evento is null";

if ($vetFiltro['atendimento']['valor'] == 'NAN') {
    $sql .= " and {$AliasPric}.idt_grupo_atendimento is not null";
} else {
    $sql .= " and {$AliasPric}.idt_grupo_atendimento is null";
    $sql .= " and exists(select idt from grc_sincroniza_siac s where s.idt_atendimento = {$AliasPric}.idt)";
}

if ($vetFiltro['ponto_atendimento']['valor'] > 0) {
    $sql .= " and {$AliasPric}.idt_ponto_atendimento= ".null($vetFiltro['ponto_atendimento']['valor']);
}

if ($vetFiltro['idt_consultor']['valor'] != '' AND $vetFiltro['idt_consultor']['valor'] != '-1') {
    $sql .= " and {$AliasPric}.idt_consultor= ".null($vetFiltro['idt_consultor']['valor']);
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '    lower('.$AliasPric.'.protocolo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(ap.nome) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(ap.cpf) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(ao.razao_social) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(ao.cnpj) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

switch ($vetFiltro['erro']['valor']) {
    case 'IP':
        $sql .= ' and siacf.erro is not null';
        break;

    case 'IE':
        $sql .= ' and siacj.erro is not null';
        break;

    case 'IA':
        $sql .= ' and siach.erro is not null';
        break;

    case 'CE':
        $sql .= " and (";
        $sql .= ' siacf.erro is not null';
        $sql .= ' or siacj.erro is not null';
        $sql .= ' or siach.erro is not null';
        $sql .= ' )';
        break;

    default:
        $sql .= ' and siacf.erro is null';
        $sql .= ' and siacj.erro is null';
        $sql .= ' and siach.erro is null';
        break;
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#filtro_id_usuario").cascade("#filtro_ponto_atendimento", {ajax: {
                url: ajax_sistema + '?tipo=pa_consultor&cas=' + conteudo_abrir_sistema
            }});

        $('#filtro_dt_ini, #filtro_dt_fim').change(function () {
            valida_dt();
        });
    });

    function valida_dt() {
        if (validaDataMaior(false, $('#dt_fim'), 'Dt. Fim', $('#filtro_dt_ini'), 'Dt. Inicio') === false) {
            $('#dt_fim').val('');
            $('#dt_fim').focus();
            return false;
        }

        var diasint = 400;

        if (newDataHoraStr(false, $('#filtro_dt_fim').val()) - newDataHoraStr(false, $('#filtro_dt_ini').val()) >= (diasint * 24 * 60 * 60 * 1000)) {
            alert('O intervalo entre as datas não pode ser superior a ' + diasint + ' dias!');
            $('#dt_fim').val('');
            $('#dt_fim').focus();
            return false;
        }

    }
</script>
