<style>
    .proprio {
        width:100%;
        background: #2F66B8;
        color     : #FFFFFF;
        text-align: center;
        font-size:18px;
        height:20px;
        padding:10px;

    }
</style>
<?php
$idCampo = 'idt';
$Tela = "os Locais do PA";

$TabelaPrinc = "grc_evento_local_pa";
$AliasPric = "grc_app";
$Entidade = "PA do Local";
$Entidade_p = "PA´s do Local";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$externo = $_GET['externo'];

echo "<div class='proprio'>";

if ($externo != 'S') {
    echo "LOCAIS PRÓPRIOS";
} else {
    echo "LOCAIS EXTERNOS";
}
echo "</div>";

if ($externo != 'S') {
    $sql = 'select ';
    $sql .= '   idt, descricao  ';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao sac_os ';
    $sql .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
    $sql .= ' order by classificacao ';
    $rs = execsql($sql);

    $Filtro = Array();
    $Filtro['rs'] = $rs;
    $Filtro['id'] = 'idt';
    $Filtro['js_tam'] = '0';
    $Filtro['nome'] = 'Pontos de Atendimento';
    $Filtro['LinhaUm'] = ' ';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['ponto_atendimento'] = $Filtro;
}

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['codigo'] = CriaVetTabela('Código');
$vetCampo['codigo_siacweb'] = CriaVetTabela('Código SiacWeb');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['qtd_pessoas_maximo'] = CriaVetTabela('Qtd. Pessoas');
$vetCampo['proprio'] = CriaVetTabela('Próprio', 'descDominio', $vetSimNao);
$vetCampo['siac_ba_desccid'] = CriaVetTabela('Cidade');

$sql = "select ";
$sql .= "   {$AliasPric}.*, ";
$sql .= "   siac_ba.desccid as siac_ba_desccid ";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " left outer join " . db_pir_siac . "cidade siac_ba on siac_ba.codcid = {$AliasPric}.logradouro_codcid";
$sql .= ' where 1 = 1';

if ($externo != 'S') {
    if ($vetFiltro['ponto_atendimento']['valor'] != "" && $vetFiltro['ponto_atendimento']['valor'] != "0" && $vetFiltro['ponto_atendimento']['valor'] != "-1") {
        $sql .= ' and idt_ponto_atendimento = ' . null($vetFiltro['ponto_atendimento']['valor']);
    }
} else {
    $sql .= ' and idt_ponto_atendimento is null ';
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '     lower(descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= '  or lower(codigo) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= '  or lower(detalhe) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' ) ';
}