<?php
$idCampo = 'idt';
$Tela = "o Projeto";
//Monta o vetor de Campo

//$goCad[] = vetCad('idt', 'Módulos do Projeto', 'plu_pl_projeto_modulo');
$projetos=Array();
$projetos['TT']='Todos';
$sql   = 'select ';
$sql  .= '   plu_pl_p.*  ';
$sql  .= ' from plu_pl_projeto as plu_pl_p ';
$sql  .= ' where substring(codigo,3,1) = "" or substring(codigo,3,1) is null  ';
$sql  .= ' order by plu_pl_p.codigo';
$rs = execsql($sql);
if ($rs->rows != 0) {
    ForEach ($rs->data as $row) {
        $codigo    = $row['codigo'];
        $descricao = $row['descricao'];
        $projetos[$codigo]=$descricao;
    }
}



$Filtro = Array();
$Filtro['rs']       = $projetos;
$Filtro['id']       = 'projetos';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Projeto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['projetos'] = $Filtro;



$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;



$goCad[] = vetCad('idt', 'Requisitos do Projeto', 'plu_pl_requisitos');

$vetCampo['classificacao']        = CriaVetTabela('Classificão');
$vetCampo['codigo']               = CriaVetTabela('Código');
$vetCampo['descricao']            = CriaVetTabela('Descrição');
$vetCampo['plu_pl_pn_descricao']  = CriaVetTabela('Natureza');
$vetCampo['plu_pl_re_descricao']  = CriaVetTabela('Responsavel');
//
$sql   = 'select ';
$sql  .= '   plu_pl_p.idt,  ';
$sql  .= '   plu_pl_p.*,  ';
$sql  .= '   plu_pl_re.codigo as plu_pl_re_codigo,  ';
$sql  .= '   plu_pl_re.descricao as plu_pl_re_descricao,  ';
$sql  .= '   plu_pl_pn.descricao as plu_pl_pn_descricao  ';
$sql  .= ' from plu_pl_projeto as plu_pl_p ';
$sql  .= ' inner join plu_pl_responsavel as plu_pl_re on plu_pl_re.idt = plu_pl_p.idt_responsavel ';
$sql  .= ' inner join plu_pl_projeto_natureza as plu_pl_pn on plu_pl_pn.idt = plu_pl_p.idt_natureza ';

if ($vetFiltro['projetos']['valor']!='TT')
{
    $sql  .= ' where  ( substring(plu_pl_p,1,2) = '.aspa($vetFiltro['projetos']['valor']). ' ) ' ;
}
if ($vetFiltro['texto']['valor']!='')
{
   if ($vetFiltro['projetos']['valor']!='TT')
   {
       $sql .= ' and ( ';
   }
   else
   {
       $sql .= ' where ( ';
   }
   $sql .= ' lower(plu_pl_p.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
   $sql .= ' or lower(plu_pl_p.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
   $sql .= ' ) ';

}
$sql  .= ' order by plu_pl_p.classificacao';
?>
