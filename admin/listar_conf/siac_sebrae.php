<?php
$idCampo = 'idt';
$Tela = "Sebrae";

$TabelaPrinc      = "db_pir_siac.sebrae";
$AliasPric        = "siac_s";
$Entidade         = "Sebrae";
$Entidade_p       = "Sebrae";

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

$orderby = "{$AliasPric}.CodEst";

$vetCampo['codsebrae']  = CriaVetTabela('Código');
$vetCampo['descsebrae'] = CriaVetTabela('Descrição');
$vetCampo['nomeabrev'] = CriaVetTabela('Nome Abreviado');
$vetCampo['fone'] = CriaVetTabela('Telefone');
//$vetCampo['cgc'] = CriaVetTabela('CGC');
//$vetCampo['codlogr'] = CriaVetTabela('Cod.Logradouro');
//$vetCampo['descendereco'] = CriaVetTabela('Endereço');
//$vetCampo['numero'] = CriaVetTabela('Número');
//$vetCampo['complemento'] = CriaVetTabela('Complemento');
//$vetCampo['codbairro'] = CriaVetTabela('Bairro');
//$vetCampo['codcid'] = CriaVetTabela('Cidade');
//$vetCampo['codest'] = CriaVetTabela('Estado');
//$vetCampo['codpais'] = CriaVetTabela('País');
//$vetCampo['cep'] = CriaVetTabela('CEP');
//$vetCampo['SeqUF'] = CriaVetTabela('SeqUF');
$vetCampo['Situacao'] = CriaVetTabela('Situação', 'descDominio', $vetSimNao );
//$vetCampo['NIRF'] = CriaVetTabela('NIRF');

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '    lower('.$AliasPric.'.codsebrae)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descsebrae)     like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
//$sql  .= " order by {$orderby}";

if ($sqlOrderby == '') {
        $sqlOrderby = "descsebrae asc";
}

?>
