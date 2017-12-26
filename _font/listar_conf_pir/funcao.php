<?php
$idCampo = 'id_funcao';
$Tela    = "a função";
$tipofiltro='S';

$goCad[] = vetCad('p_cod_classificacao,p_nm_funcao,p_cod_funcao,p_classifica,id_funcao', 'Objetos', 'plu_objetos_funcao');


$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'p_cod_classificacao';
$Filtro['nome'] = 'Classificação';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cod_classificacao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'p_nm_funcao';
$Filtro['nome'] = 'Nome';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['nm_funcao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'p_cod_funcao';
$Filtro['nome'] = 'Transação';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cod_funcao'] = $Filtro;

$vetClassifica=Array();
$vetClassifica['F']='Classificação da Função';
$vetClassifica['P']='Painel';
$Filtro         = Array();
$Filtro['rs']   = $vetClassifica;
$Filtro['id']   = 'p_classifica';
$Filtro['nome'] = 'Classificação';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['classifica'] = $Filtro;










//Monta o vetor de Campo
if ($vetFiltro['classifica']['valor']=='F')
{
    $vetCampo['cod_classificacao'] = CriaVetTabela('Classificação');
}
else
{
    $vetCampo['painel'] = CriaVetTabela('Painel');
}
$vetCampo['nm_funcao'] = CriaVetTabela('Nome');
$vetCampo['cod_funcao'] = CriaVetTabela('Transação');
$vetCampo['sts_menu'] = CriaVetTabela('Mostra Menu', 'descDominio', $vetSimNao);
if ($vetFiltro['classifica']['valor']=='F')
{
    $vetCampo['painel'] = CriaVetTabela('Painel');

}
else
{
    $vetCampo['cod_classificacao'] = CriaVetTabela('Classificação');
    $vetCampo['linha'] = CriaVetTabela('Linha');
    $vetCampo['coluna'] = CriaVetTabela('Coluna');
}
$sql = 'select   funcao.id_funcao as idt, funcao.*  from funcao  ';
$sql .= ' where ';
$sql .= ' ( ';
$sql .= ' lower(cod_classificacao) like lower('.aspa($vetFiltro['cod_classificacao']['valor'], '', '%').')';
$sql .= ' and lower(nm_funcao) like lower('.aspa($vetFiltro['nm_funcao']['valor'], '%', '%').')';   
$sql .= ' and lower(cod_funcao) like lower('.aspa($vetFiltro['cod_funcao']['valor'], '%', '%').')';
$sql .= ' ) ';

if ($vetFiltro['classifica']['valor']=='F')
{
    $sql .= ' order by cod_classificacao';
}
else
{
   // $sql .= " and  (painel <> '' and painel is not null)  ";
    $sql .= ' order by painel, cod_classificacao';
}
?>