<?php
$idCampo = 'idt';
$Tela = "as Organizações do Atendimento";
//

$TabelaPai   = "grc_atendimento";
$AliasPai    = "grc_a";
$EntidadePai = "Atendimento";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_atendimento_organizacao";
$AliasPric        = "grc_ao";
$Entidade         = "Organização do Atendimento";
$Entidade_p       = "Organizações do Atendimento";
$CampoPricPai     = "idt_atendimento";


$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

$orderby = "";

//$sql_orderby=Array();



$veio = $_GET['veio'];

if ($veio!=255)
{

    //
    $Filtro = Array();
    $Filtro['id']     = 'idt';
    $Filtro['nome']   = $EntidadePai;
    $Filtro['valor']  = trata_id($Filtro);
    $vetFiltro[$CampoPricPai] = $Filtro;
    //
    $Filtro = Array();
    $Filtro['rs']       = 'Texto';
    $Filtro['id']       = 'texto';
    $Filtro['js_tam']   = '0';
    $Filtro['nome']     = 'Texto';
    $Filtro['valor']    = trata_id($Filtro);
    $vetFiltro['texto'] = $Filtro;
    //
        $texto="";
        $sql = 'select * from '.$TabelaPai.' where idt = '.null($vetFiltro[$CampoPricPai]['valor']);
        $rst = execsql($sql);
        if ($rst->rows != 0) {
            ForEach ($rst->data as $rowt) {
                $data    = $rowt['data'];
            }
        }
        $texto=" $data ";
        $upCad[] = vetCadUp('idt', $EntidadePai.': ', 'grc_atendimento', $texto);
}
else
{
    $tipoidentificacao = 'N';
    $tipofiltro        = 'N';
    $comfiltro         = 'F';
    $comidentificacao  = 'F';
    $bt_print          = false;
    $barra_inc_ap = true;
    $barra_alt_ap = true;
    $barra_con_ap = true;
    $barra_exc_ap = false;
    $barra_fec_ap = false;

}

//Monta o vetor de Campo
$vetCampo['cnpj']      = CriaVetTabela('CNPJ');
$vetCampo['razao_social']     = CriaVetTabela('Razão Social');
$vetCampo['nome_fantasia']     = CriaVetTabela('Nome Fantasia');


$sql  = "select {$AliasPric}.*  ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";


if ($veio!=255)
{
    $sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
}
else
{
    $sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($_GET['idt_atendimento']);
}






$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.cnpj) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.razao_social) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.nome_fantasia) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "{$AliasPric}.cnpj ";

$sql .= " order by {$orderby}";
?>
