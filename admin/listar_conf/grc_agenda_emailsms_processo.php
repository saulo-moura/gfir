<?php
$idCampo = 'idt';
$Tela = "os Tipos de Box";

$TabelaPrinc      = "grc_agenda_emailsms_processo";
$AliasPric        = "grc_aep";
$Entidade         = "Processo do Email-SMS";
$Entidade_p       = "Processos do Email-SMS";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";


$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//$orderby = "{$AliasPric}.codigo";

$vetCampo['codigo']    = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['prazo'] = CriaVetTabela('Prazo');
$vetCampo['quando']     = CriaVetTabela('Quando', 'descDominio', $vetAgendaQ );
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$veio=$_GET['veio'];
if ($veio=='pa')
{
    $sql .= ' where ';
    $sql .= " origem = 'P' ";
}
else
{
    $sql .= ' where ';
    $sql .= " origem = 'A' ";
}
if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
//$sql  .= " order by {$orderby}";

?>