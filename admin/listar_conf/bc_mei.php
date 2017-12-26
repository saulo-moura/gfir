<?php
$idCampo = 'idt';
$Tela = "os lan�amentos";

$TabelaPrinc      = "db_pir.bc_mei";
$AliasPric        = "bc_m";
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

$orderby = "{$AliasPric}.I";

$vetCampo['E'] = CriaVetTabela('E - NR_NIRE');
$vetCampo['F'] = CriaVetTabela('F - NR_CNPJ');
$vetCampo['G'] = CriaVetTabela('G - NR_CPF');
$vetCampo['H'] = CriaVetTabela('H - Nome Pessoa Jur�dica');
$vetCampo['I'] = CriaVetTabela('I - Nome Pessoa F�sica');

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.I)   like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.G) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

//$sql  .= " order by {$orderby}";

if ($sqlOrderby == '') {
        $sqlOrderby = "I asc";
}




?>