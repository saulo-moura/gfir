<?php
$idCampo = 'idt';
$Tela = "a Publicação de Eventos";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$TabelaPrinc = "grc_evento_publicar";
$AliasPric = "grc_prop";
$Entidade = "Publicação de Eventos";
$Entidade_p = "Publicação de Eventos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs'] = $vetEventoPubilcar;
$Filtro['id'] = 'fil_situacao';
$Filtro['nome'] = 'Situação';
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
$vetCampo['unidade'] = CriaVetTabela('Unidade/Escritório');
$vetCampo['dt_registro'] = CriaVetTabela('Data do Registro', 'datahora');
$vetCampo['situacao'] = CriaVetTabela('Situação', 'descDominio', $vetEventoPubilcar);

$sql = "select ";
$sql .= "   {$AliasPric}.*,  und.descricao as unidade";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " left outer join " . db_pir . "sca_organizacao_secao und on und.idt = {$AliasPric}.idt_unidade ";
$sql .= " where 1 = 1";

if (acesso($menu, "'PER'", false)) {
    $sql .= " and {$AliasPric}.idt_responsalvel = " . null($_SESSION[CS]['g_id_usuario']);
}

if ($vetFiltro['situacao']['valor'] != "0") {
    $sql .= " and {$AliasPric}.situacao = " . aspa($vetFiltro['situacao']['valor']);
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower(' . $AliasPric . '.codigo) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(und.descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' ) ';
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#contListar a[data-acao="inc"]').removeAttr('onclick').click(function () {
            var par = '';
            par += '?prefixo=listar_cmb';
            par += '&menu=grc_evento_publicar_acao';
            par += '&cas=' + conteudo_abrir_sistema;
            var url = 'conteudo_cadastro.php' + par;
            showPopWin(url, 'Publicar Eventos', $('div.showPopWin_width').width() - 30, $(window).height() - 100, null, true);
        });
    });
</script>