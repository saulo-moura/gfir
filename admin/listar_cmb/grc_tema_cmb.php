<?php
$idCampo = 'idt';
$Tela = "o Tema/Subtema";

$TabelaPrinc = "grc_tema_subtema";
$AliasPric = "grc_tsb";
$Entidade = "Tema/Subtema";
$Entidade_p = "Tema/Subtemas";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$listar_sql_limit = false;
$reg_pagina_esp = 'tudo';
$barra_con_ap = false;
$func_trata_row = func_grc_tema_subtema;

$vetListarCmbRegValido = Array(
    'nivel' => Array('1'),
);

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['codigo'] = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');

$sql = "select ";
$sql .= "   {$AliasPric}.*, n0.idt as idt_tema,";
$sql .= " concat_ws(' - ', n0.descricao, {$AliasPric}.descricao) as {$campoDescListarCmb}";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " inner join grc_tema_subtema n0 on n0.codigo = substring({$AliasPric}.codigo,1,2)";
$sql .= " where {$AliasPric}.ativo = 'S'";

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

if ($sqlOrderby == '') {
    $sqlOrderby = "{$AliasPric}.codigo asc";
}

$vetOrderby = Array(
    "{$AliasPric}.codigo" => 'Código',
    "{$AliasPric}.descricao" => 'Descrição',
);

?>
<script type="text/javascript">
    $(document).ready(function () {
        $('tr[data-nivel="0"], tr[data-nivel="1"]').click(function () {
            var tr = 'tr[data-cod0="' + $(this).data('cod0') + '"]';

            if ($(this).data('nivel') == 1) {
                tr += '[data-cod1="' + $(this).data('cod1') + '"]';
            }

            if ($(this).data('aberto') == 'S') {
                $(tr).hide();
                $(this).data('aberto', 'N');
                $(this).show();
            } else {
                $(tr).show();
                $(this).data('aberto', 'S');
            }
            
            TelaHeight();
        });

        $('tr[data-nivel="1"], tr[data-nivel="2"]').each(function () {
            var tr = 'tr[data-cod0="' + $(this).data('cod0') + '"]';

            if ($(this).data('nivel') == 1) {
                tr += '[data-cod1="' + $(this).data('cod1') + '"]';
            }

            if ($(tr).length > 1) {
                $(this).css('cursor', 'pointer');
            }
        });
    });
</script>