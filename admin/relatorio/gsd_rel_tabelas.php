<?php
Require_Once('relatorio/lupe_generico.php');
Require_Once('relatorio/style.php');

$vetFiltro = Array();

// Área de botões de controle --- Barra de Ferramentas
if ($_GET['print'] != 's') {
    echo "<div class='barra_ferramentas'>";
    echo "<table cellspacing='1' cellpadding='1' width='100%' border='1'>";
    echo "<tr>";
    echo "<td width='20'>";
    echo "<a HREF='conteudo.php'><img class='bartar' align=middle src='relatorio/voltar_ie.jpg'></a>";
    echo "</td>";
    echo "<td width='20'>";
    echo "<a HREF='#' onclick=\"return imprimir('$menu');\"><img class='bartar' align=middle src='relatorio/visualiza_imprime.jpg'></a>";
    echo "</td>";
    echo "<td>&nbsp;</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}

//Monta o vetor de filtro
//$Filtro = Array();
//$sql = "select idt, razao_social from entidade where pessoa_juridica_grupo = ".aspa('PJ')." order by razao_social";
//$Filtro['rs'] = execsql($sql);
//$Filtro['id'] = 'idt';
//$Filtro['nome'] = 'Autorizadora';
//$Filtro['LinhaUm'] = 'Seleciona Todos Usuários';
//$Filtro['valor'] = trata_id($Filtro);
//$vetFiltro['entidade_autorizadora'] = $Filtro;


 //p('ooooooooooooooo'.$vetFiltro['tipo_regiao']['valor']);
 // exit();



 if ($tipodb == 'mysql')
{
    $vetOrdenacao = Array(
        'TABLE_NAME' => 'Nome da Tabela',
        'TABLE_COMMENT' => 'Descrição da Tabela'
     );
}
if ($tipodb == 'pgsql')
{
    $vetOrdenacao = Array(
        'ta.tablename' => 'Nome da Tabela',
        'd.description' => 'Descrição da Tabela'
     );
}


$Filtro = Array();
$Filtro['rs'] = $vetOrdenacao;
$Filtro['id'] = 'indice_ordenacao';

if ($_GET['print'] != 's')
{
    $Filtro['nome'] = 'Classificar por';
}
else
{
     $Filtro['nome'] = 'Classificado por';
}
// $Filtro['LinhaUm'] = 'Selecione um registro';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['indice_ordenacao'] = $Filtro;

// Área de Filtro do relatório
$idx = -1;
ForEach($vetFiltro as $Filtro) {
    $idx++;
    $strPara .= $Filtro['id'].$idx.',';
}

echo '<form name="frm" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';

if ($_GET['print'] != 's') {
    $Focus = '';
    codigo_filtro(false);
    onLoadPag($Focus);
} else {
    codigo_filtro_fixo();
    onLoadPag();
}

// Área de Mostrar Tabela do relatório
//    $sql = 'select * from municipio where idt_uf = '.null($vetFiltro['uf']['valor']).'
//            order by descricao ';

$kwherew   ='';
$korderbyw ='';



//if  (null($vetFiltro['entidade_autorizadora']['valor'])!=-1)
//{

//    $kwherew=$kwherew.' where us.idt_entidade = '.null($vetFiltro['entidade_autorizadora']['valor']);
//    $kentidadeautorizadoraw=1;
//}
//else
//{
//    $kentidadeautorizadoraw=0;
//}





if ($tipodb == 'mysql')
{
    if ($pre_table!='')
    {

        $sql =  "select TABLE_NAME, TABLE_COMMENT from information_schema.tables where TABLE_SCHEMA=".aspa(TABLE_SCHEMA)."
                 and substring(TABLE_NAME from 1 for 4) = ".aspa($pre_table);

    }
    else
    {
        $sql =  "select TABLE_NAME, TABLE_COMMENT from information_schema.tables where TABLE_SCHEMA=".aspa(TABLE_SCHEMA);

    }


}
if ($tipodb == 'pgsql')
{
     $sql = " select ta.tablename as table_name, d.description as table_comment from pg_tables as ta
                   inner join pg_class c on tablename=relname
                   left join pg_description  d on d.objoid=c.oid and d.objsubid=0
                   where schemaname='public'  substring(tablename from 1 for 4) = ".aspa($pre_table);
                   
                   // where tablename = 'fo_solicitacao_resposta'  and d.objsubid=0


}


//   if  ($kentidadeautorizadoraw==1)
//   {
//       $korderbyw =' order by us.idt_entidade'.','.$vetFiltro['indice_ordenacao']['valor'];
//   }
//   else
//   {
//       $korderbyw =$korderbyw .' order by '.$vetFiltro['indice_ordenacao']['valor'];
//   }
   $korderbyw = $korderbyw .' order by '.$vetFiltro['indice_ordenacao']['valor'];
   $sql = $sql.$kwherew.$korderbyw;
   
//  p($sql);
//  exit();

            
    $rs = execsql($sql);
    
    $kpriw=1;
    $tottabelasw=0;
    ForEach($rs->data as $row) {
    if ($kpriw==1)
    {
        $kpriw=0;
        echo "<table class='Geral' width='100%' border='1' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        echo "<tr class='linha_cab_tabela'>  ";
        echo "   <td>&nbsp;Nome da Tabela</td> ";
        echo "   <td>&nbsp;Descrição</td> ";
     }
     echo "<tr class= 'linha_tabela'>";
     if ($tipodb == 'mysql')
     {
        echo "<td class='linha_tabela'>".$row['TABLE_NAME']."&nbsp;</td>";
        echo "<td class='linha_tabela'>".$row['TABLE_COMMENT']."&nbsp;</td>";
     }
     if ($tipodb == 'pgsql')
     {
        echo "<td class='linha_tabela'>".$row['table_name']."&nbsp;</td>";
        echo "<td class='linha_tabela'>".$row['table_comment']."&nbsp;</td>";
     }
     echo "</tr>";
     $tottabelasw=$tottabelasw+1;
   }


   echo "</table>";
   echo "<table class='Geral_tot' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
   echo "<tr align='left'>";
   echo "<td><b>Total de Tabelas:&nbsp;&nbsp;".$tottabelasw."</b></td>";
   echo "</tr>";
   echo "</table>";

 // rodapé
  if ($_GET['print'] == 's')
   {
   echo " <table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
   echo " <tr class='linha_cab_tabela'>";
   echo "   <td align='center'><img src='imagens/rodape_rel.jpg'/></td>";
   echo " </tr>";
   echo " </table>";
   }
 
 
 
?>
</form>

