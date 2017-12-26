<?php
$idCampo = 'idt';
$Tela = "os Momentos Vida";

$TabelaPrinc      = "db_pir_siac.momentovida";
$AliasPric        = "siac_mv";
$Entidade         = "Momento Vida";
$Entidade_p       = "Momentos Vida";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//$orderby = "{$AliasPric}.CodMomentoVida";

$vetCampo['CodMomentoVida']  = CriaVetTabela('Código');
$vetCampo['DescMomentoVida'] = CriaVetTabela('Descrição');
$vetCampo['Situacao'] = CriaVetTabela('Situação', 'descDominio', $vetSimNao );
$vetCampo['TipoPessoa'] = CriaVetTabela('Tipo <br> de Pessoa </br>', 'descDominio', $vetFisicaJuridica );
$vetCampo['ClassificacaoPessoa'] = CriaVetTabela('Classificação <br> Pessoa</br>');
$vetCampo['OperadorAnosAbertura'] = CriaVetTabela('Operador <br> Anos de Abertura</br>');
$vetCampo['QtdAnosAbertura'] = CriaVetTabela('Quantidade <br> Anos de Abertura</br>');

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.CodMomentoVida)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.DescMomentoVida) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
//$sql  .= " order by {$orderby}";
if ($sqlOrderby == '') {
    $sqlOrderby = "CodMomentoVida asc";
}
?>
