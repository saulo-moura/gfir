<?php
$idCampo = 'idt';
$Tela = "o CNAE";



$TabelaPrinc      = "cnae";
$AliasPric        = "cn";
$Entidade         = "CNAE";
$Entidade_p       = "CNAEs";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetNivelCNAE = Array();
$vetNivelCNAE['todos']      = "Todos";
$vetNivelCNAE['secao']      = "Seзгo";
$vetNivelCNAE['divisao']    = "Divisгo";
$vetNivelCNAE['grupo']      = "Grupo";
$vetNivelCNAE['classe']     = "Classe";
$vetNivelCNAE['subclasse']  = "Subclasse";
$Filtro['rs']       = $vetNivelCNAE;
$Filtro['id']       = 'nivel';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Visгo';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['nivel'] = $Filtro;


$orderby = "{$AliasPric}.codigo";

//$vetCampo['codigo']    = CriaVetTabela('Cуdigo');

$vetCampo['secao']    = CriaVetTabela('Seзгo');
$vetCampo['divisao']    = CriaVetTabela('Divisгo');
$vetCampo['grupo']    = CriaVetTabela('Grupo');
$vetCampo['classe']    = CriaVetTabela('Classe');
$vetCampo['subclasse']    = CriaVetTabela('Subclasse');

$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

if ($vetFiltro['nivel']['valor']!="todos")
{
   $liga = " where ";
   if ($vetFiltro['texto']['valor']!="")
   {
       $liga = " and ";
   }
   $cond = "";
   if ($vetFiltro['nivel']['valor']=='secao')
   {
       $cond = " divisao is null or divisao = '' ";
   }
   if ($vetFiltro['nivel']['valor']=='divisao')
   {
       $cond = " grupo is null or grupo = '' ";
   }
   if ($vetFiltro['nivel']['valor']=='grupo')
   {
       $cond = " classe is null or classe = '' ";
   }
   if ($vetFiltro['nivel']['valor']=='classe')
   {
       $cond = " subclasse is null or subclasse = '' ";
   }
   if ($vetFiltro['nivel']['valor']=='subclasse')
   {
   }
   else
   {
       $sql .= " $liga ( ";
       $sql .= " $cond  ";
       $sql .= ' ) ';
   }
}
$sql  .= " order by {$orderby}";

?>