<?php
$idCampo = 'idt';
$Tela = "a estrutura";


$sql  = "select sca_eo.idt, sca_eo.codigo, sca_eo.descricao from sca_estrutura_organizacional sca_eo";
$sql .= " order by sca_eo.descricao";
$Filtro = Array();
$Filtro['rs']       = execsql($sql);
$Filtro['id']       = 'idt';
$Filtro['nome']     = 'Organização';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_organizacao'] = $Filtro;

$tipofiltro='S';
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'classificacao';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Classificação';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cod_classificacao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'descricao';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Nome';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['nm_funcao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'codigo';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Código';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cod_funcao'] = $Filtro;


//Monta o vetor de Campo
$vetCampo['codigo']         = CriaVetTabela('Código');
$vetCampo['classificacao']  = CriaVetTabela('Classificação');
$vetCampo['descricao']      = CriaVetTabela('Descrição');
//$vetTipo=Array();
//$vetTipo['E']='Estratégico';
//$vetTipo['T']='Tático';
//$vetTipo['O']='Operacional';
//$vetCampo['tipo']           = CriaVetTabela('Tipo','descDominio',$vetTipo);
$vetCampo['scate_descricao']  = CriaVetTabela('Tipo');


$vetCampo['scasi_descricao']      = CriaVetTabela('Sistema');
//$vetCampo['sistema_executa']      = CriaVetTabela('Executa Sistema');



//$vetCampo['classificacao_sistema']      = CriaVetTabela('Classificação');
$vetCampo['transacao']      = CriaVetTabela('Transação');


$sql   = 'select ';
$sql  .= '   scaes.*,  ';
$sql  .= '   scate.descricao as scate_descricao,  ';
$sql  .= '   scasi.descricao as scasi_descricao  ';

$sql  .= ' from sca_estrutura as scaes ';
$sql  .= ' inner join  sca_tipo_estrutura scate on scate.idt = scaes.idt_sca_tipo_estrutura ';
$sql  .= ' left  join  sca_sistema scasi on scasi.idt = scaes.idt_sistema ';

$sql  .= ' where scaes.idt_organizacao = '.null($vetFiltro['idt_organizacao']['valor']);



if ($vetFiltro['texto']['valor']!='')
{
    $sql  .= '  and ( ';
    $sql  .= ' lower(scaes.classificacao) like lower('.aspa($vetFiltro['cod_classificacao']['valor'], '', '%').')';
    $sql  .= ' and lower(scaes.descricao) like lower('.aspa($vetFiltro['nm_funcao']['valor'], '%', '%').')';
    $sql  .= ' and lower(scaes.codigo) like lower('.aspa($vetFiltro['cod_funcao']['valor'], '%', '%').')';
    $sql  .= '  ) ';
}

$sql  .= ' order by scaes.classificacao';

// converte_processos();

?>

