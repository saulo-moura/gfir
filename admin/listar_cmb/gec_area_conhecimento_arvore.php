<?php
$idCampo = 'idt';
$Tela = "a Área de Conhecimento";

$TabelaPrinc = "gec_area_conhecimento";
$AliasPric = "gec_ac";
$Entidade = "Área de Conhecimento";
$Entidade_p = "Áreas de Conhecimento";
$contlinfim = "Existem #qt Áreas - Subáreas - Especialidades";
$tipoidentificacao = 'N';

$corimp = '#FFFFFF';
$corpar = '#FFFFFF';
$clique_hint_linha = ""; // HINT para linha do FULL

$whereAreaEmpresa = '';

if ($_GET['entidade_idt'] != '') {
    $sql = '';
    $sql .= ' select a.idt_area_conhecimento';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade e';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_area_conhecimento a on e.idt = a.idt_entidade';
    $sql .= ' where e.idt_candidato_indicado is null';
    $sql .= ' and e.idt_etapa_candidato = (';
    $sql .= ' select idt_etapa_candidato';
    $sql .= ' from gec_entidade';
    $sql .= ' where idt = ' . null($_GET['entidade_idt']);
    $sql .= ' )';
    $rst = execsql($sql);

    $vetIdtArea = Array();
    $vetIdtArea[0] = 0;

    foreach ($rst->data as $rowt) {
        $vetIdtArea[$rowt['idt_area_conhecimento']] = $rowt['idt_area_conhecimento'];
    }

    $whereAreaEmpresa = implode(', ', $vetIdtArea);
}

$sql = 'select idt, descricao from ' . db_pir_gec . 'gec_programa ';
$sql .= ' order by codigo ';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Programa';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_programa'] = $Filtro;

$idt_programa = $vetFiltro['idt_programa']['valor'];

if ($vetFiltro['idt_programa']['valor'] == -1) { // TODOS OS PROGRAMAS
    $n1 = "Nível 1";
    $n2 = "Nível 2";
    $n3 = "Nível 3";
    $t1 = "Todos os Níveis";
}

if ($vetFiltro['idt_programa']['valor'] == 1) { // SGC
    $n1 = "Área";
    $n2 = "Subarea";
    $n3 = "Especialidade";
    $t1 = "Todas as Áreas";
    $contlinfim = "Existem #qt Áreas - Subáreas - Especialidades.";
}

if ($vetFiltro['idt_programa']['valor'] == 4) { // SEBRAETEC
    $n1 = "Tema";
    $n2 = "Subtema";
    $n3 = "Serviço";
    $t1 = "Todos os Temas";
    $contlinfim = "Existem #qt Temas - Subtemas - Serviços.";
}

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

if ($whereAreaEmpresa == '' && $vetFiltro['texto']['valor'] == '') {
    $listar_sql_limit = false;
    $reg_pagina_esp = 'tudo';
    $barra_con_ap = false;
    $func_trata_row = func_gec_area_conhecimento;
}

$vetListarCmbRegValido = Array(
    'tipo' => Array('A'),
);

if ($vetFiltro['idt_programa']['valor'] == '' or $vetFiltro['idt_programa']['valor'] == -1) {
    $vetCampo['gec_p_descricao'] = CriaVetTabela('Programa');
}

$vetCampo['descricao'] = CriaVetTabela($n1 . "<br />" . $n2 . "<br />" . $n3 . "<br />");
$vetCampo['detalhe'] = CriaVetTabela("Descrição detalhada");

$sql = "select ";
$sql .= " gec_a.*, ";
$sql .= " gec_p.descricao as gec_p_descricao, ";
$sql .= " concat_ws(' - ',  gec_a.descricao_n1, gec_a.descricao_n2, gec_a.descricao_n3) as {$campoDescListarCmb}";
$sql .= " from " . db_pir_gec . "gec_area_conhecimento gec_a ";
$sql .= " inner join " . db_pir_gec . "gec_programa gec_p on gec_p.idt = gec_a.idt_programa ";
$sql .= " left join " . db_pir_gec . "gec_area_conhecimento gec_ac_a  on gec_ac_a.codigo  = substring(gec_a.codigo,1,2)   and gec_ac_a.nivel  = 1 and gec_ac_a.idt_programa  = gec_p.idt";
$sql .= " left join " . db_pir_gec . "gec_area_conhecimento gec_ac_as on gec_ac_as.codigo = substring(gec_a.codigo,1,6)   and gec_ac_as.nivel = 2 and gec_ac_as.idt_programa = gec_p.idt";
$sql .= " left join " . db_pir_gec . "gec_area_conhecimento gec_ac_ae on gec_ac_ae.codigo = substring(gec_a.codigo,1,10)  and gec_ac_ae.nivel = 3 and gec_ac_ae.idt_programa = gec_p.idt";

$sql .= ' where gec_a.idt_programa = ' . null($vetFiltro['idt_programa']['valor']);

if ($vetFiltro['texto']['valor'] != '') {
    $sql .= " and ( ";
    $sql .= ' lower(gec_a.codigo) like lower(' . aspa($vetFiltro['texto']['valor'], '', '%') . ')';
    $sql .= ' or lower(gec_a.descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' ) ';
}

if ($whereAreaEmpresa != '') {
    $sql .= ' and gec_a.idt in (' . $whereAreaEmpresa . ')';
}


if ($sqlOrderby == '') {
    $sqlOrderby = 'gec_a.codigo asc';
}

//p($sql);

$vetOrderby = Array(
    'gec_a.codigo' => 'Código',
    'gec_ac_a.descricao' => 'Área',
    'gec_ac_as.descricao' => 'Subárea',
    'gec_ac_ae.descricao' => 'Especialidade',
);
?>
<style type="text/css">
    div.contListar table.Generica {
        border-spacing: 1px;
        border-collapse: separate;	
    }

    div.contListar tr:hover td {
        color: #FFFFFF;
    }

    div.contListar tr.underline:hover td {
        text-decoration: underline;
    }

    tr.N1 td {
        /*color: #004080;*/
        color: #000000;
        text-transform: uppercase;
        background-color: #F2F2F2;
    }

    tr.N1:hover td {
        color: #004080;
    }

    tr.N2 td {
        color: #0080C0;
        background-color: #FAFAFA;
    }

    tr.N2:hover td {
        color: #004080;
    }

    tr.N3 td {
        color: #0000FF;
        background-color: #F2F2F2;
    }

    tr.N3:hover td {
        /*color: #004080;*/
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('tr[data-nivel="1"], tr[data-nivel="2"]').click(function () {
            var tr = 'tr[data-cod1="' + $(this).data('cod1') + '"]';

            if ($(this).data('nivel') == 2) {
                tr += '[data-cod2="' + $(this).data('cod2') + '"]';
            }

            if ($(this).data('aberto') == 'S') {
                $(tr).hide();
                $(this).data('aberto', 'N');
                $(this).show();
            } else {
                $(tr).show();
                $(this).data('aberto', 'S');

                if ($(this).data('nivel') == 1) {
                    $(tr).filter('[data-nivel="3"]').hide();
                }
            }
        });

        $('tr[data-nivel="1"], tr[data-nivel="2"]').each(function () {
            var tr = 'tr[data-cod1="' + $(this).data('cod1') + '"]';

            if ($(this).data('nivel') == 2) {
                tr += '[data-cod2="' + $(this).data('cod2') + '"]';
            }

            if ($(tr).length > 1) {
                $(this).css('cursor', 'pointer');
                $(this).addClass('underline');

                if ($(this).data('nivel') == 2) {
                    $(this).attr('title', 'Clique aqui para ter acesso a especialidades.');
                    $(this).css('text-transform', 'uppercase');
                    $(this).find('td').css('color', '#000000');
                } else {
                    $(this).attr('title', 'Clique aqui para ter acesso a subareas.');
                }
            }
        });
    });
</script>