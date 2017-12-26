<?php
$idCampo = 'idt';
$Tela = "os lan�amentos";

$TabelaPrinc      = "db_pir.bc_siac";
$AliasPric        = "bc_s";
$Entidade         = "Lan�amento";
$Entidade_p       = "Lan�amentos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$tipoidentificacao = 'N';
$tipofiltro = 'S';

$comfiltro        = 'A';
$comidentificacao = 'F';

    $barra_inc_ap = false;
    $barra_alt_ap = false;
    $barra_con_ap = true;
    $barra_exc_ap = false;
    $barra_fec_ap = false;




$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.E";

$vetCampo['C'] = CriaVetTabela('C - CNPJ');
$vetCampo['D'] = CriaVetTabela('D - C�digo');
$vetCampo['E'] = CriaVetTabela('E - Raz�o Social');
$vetCampo['F'] = CriaVetTabela('F - Nome Fantasia');
$vetCampo['G'] = CriaVetTabela('G - Matriz/Filial');

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.C)   like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.E) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}


//$sql  .= " order by {$orderby}";

if ($sqlOrderby == '') {
        $sqlOrderby = "E asc";
}

/*
$vetOrderby = Array(
   "{$AliasPric}.codigo" => 'C�DIGO',
   "{$AliasPric}.codigo_siac" => 'C�DIGO SIAC',
   "{$AliasPric}.codigo_classificacao_siac" => 'C�DIGO CLASSIFICA��O SIAC',
   "{$AliasPric}.descricao"   => 'T�TULO DO PRODUTO',
   "grc_prg.descricao"   => 'PROGRAMA',
);
*/





?>