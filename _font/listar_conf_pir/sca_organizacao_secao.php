<?php
$idCampo = 'idt';
$Tela = "a Se��o da Organiza��o";
//Monta o vetor de Campo

$goCad[] = vetCad('idt,idt', 'Cargos', 'sca_organizacao_cargo');
$goCad[] = vetCad('idt,idt', 'Pessoas', 'sca_organizacao_pessoa');

$sql  = "select sca_eo.idt, sca_eo.codigo, sca_eo.descricao from sca_estrutura_organizacional sca_eo";
$sql .= " order by sca_eo.descricao";
$Filtro = Array();
$Filtro['rs']       = execsql($sql);
$Filtro['id']       = 'idt';
$Filtro['nome']     = 'Organiza��o';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_organizacao'] = $Filtro;

$tipofiltro='S';
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;


$vetCampo['classificacao']         = CriaVetTabela('C�digo Hi');
$vetCampo['codigo']         = CriaVetTabela('C�digo RH');
$vetCampo['descricao']      = CriaVetTabela('Descri��o');
$vetCampo['sigla']          = CriaVetTabela('Sigla');
$vetCampo['est_descricao']  = CriaVetTabela('Estado');
$vetCampo['localidade']     = CriaVetTabela('Localidade');

$sql   = 'select ';
$sql  .= '   scaos.idt,  ';
$sql  .= '   scaos.*,  ';
$sql  .= '   est.descricao as est_descricao ';
$sql  .= ' from sca_organizacao_secao as scaos ';
$sql  .= ' left join estado est on est.idt = scaos.idt_estado ';

$sql  .= ' where scaos.idt_organizacao = '.null($vetFiltro['idt_organizacao']['valor']);

if ($vetFiltro['texto']['valor']!='')
{
    $sql  .= '   and ( ';
    $sql  .= ' lower(scaos.localidade) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
    $sql  .= ' or lower(scaos.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql  .= ' or lower(scaos.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    
    $sql  .= '  ) ';
}

$sql  .= ' order by scaos.classificacao ';
?>
