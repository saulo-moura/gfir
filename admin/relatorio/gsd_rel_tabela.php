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
$Filtro = Array();
if ($tipodb == 'mysql')
{

    if ($pre_table!='')
    {
        $sql = "select TABLE_NAME as id, TABLE_NAME as table_name from information_schema.tables where TABLE_SCHEMA=".aspa(TABLE_SCHEMA)."
                and substring(TABLE_NAME from 1 for 4) = ".aspa($pre_table)."
                order by TABLE_NAME";
    }
    else
    {
        $sql = "select TABLE_NAME as id, TABLE_NAME as table_name from information_schema.tables where TABLE_SCHEMA=".aspa(TABLE_SCHEMA)."
                order by TABLE_NAME";
    }
            
}



if ($tipodb == 'pgsql')
{
 //   $sql = "select TABLE_NAME, TABLE_COMMENT from information_schema.tables where TABLE_SCHEMA=".aspa(TABLE_SCHEMA)." order by TABLE_NAME";
    $sql = " select pg_tables.tablename as table_name, pg_tables.tablename as table_comment from pg_tables
                   inner join pg_class c on tablename=relname
                   left join pg_description  d on d.objoid=c.oid and d.objsubid=0
                   where schemaname='public'  order by  pg_tables.tablename ";
                //   where tablename = 'fo_solicitacao_resposta'  and d.objsubid=0
}
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'table_name';
$Filtro['nome'] = 'Tabela';
$Filtro['LinhaUm'] = 'Seleciona Todas as Tabelas';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['tabela'] = $Filtro;

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


if  ($vetFiltro['tabela']['valor'] !== -1)
{
    if ($tipodb == 'mysql')
    {
        $kwherew=$kwherew.' and TABLE_NAME = '.aspa($vetFiltro['tabela']['valor']);
    }
    if ($tipodb == 'pgsql')
    {
       $kwherew=$kwherew." where schemaname='public' and tablename = ".aspa(null($vetFiltro['tabela']['valor']));
    }

}
if ($tipodb == 'mysql')
{
    if ($pre_table!='')
    {
        $sql =  "select TABLE_NAME as table_name, TABLE_COMMENT as table_comment from information_schema.tables
                where TABLE_SCHEMA=".aspa(TABLE_SCHEMA)."
                and substring(TABLE_NAME from 1 for 4) = ".aspa($pre_table);
    }
    else
    {
        $sql =  "select TABLE_NAME as table_name, TABLE_COMMENT as table_comment from information_schema.tables
                where TABLE_SCHEMA=".aspa(TABLE_SCHEMA);

    }
}
if ($tipodb == 'pgsql')
{
        $sql = " select ta.tablename as table_name, d.description as table_comment from pg_tables as ta
                       inner join pg_class c on tablename=relname
                       left join pg_description  d on d.objoid=c.oid and d.objsubid=0
                       where schemaname='public'  and substring(tablename from 1 for 4) = ".aspa($pre_table).
                      ' order by  ta.tablename ';
}
   $sql=$sql. $kwherew.$korderbyw ;
   $rs = execsql($sql);
   $tottabelasw=0;
   $totgeralcampos=0;


   ForEach($rs->data as $row) {
        echo "<table class='Geral' width='100%' border='1' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        echo "<tr class='linha_cab_tabela'>  ";
        echo "<td class='linha_tabela'><b>Tabela:&nbsp;&nbsp;".$row['table_name']." - ".$row['table_comment']."&nbsp;</b></td>";
        echo "</tr>";
        echo "</table>";
     //
     // CAMPOS DA TABELA
     //
        if ($tipodb == 'mysql')
        {
            $sql =  " select * FROM information_schema.COLUMNS where TABLE_SCHEMA=".aspa(TABLE_SCHEMA)." and table_name=".aspa($row['table_name']);
             $korderbyw = ' order by ORDINAL_POSITION';
        }
        if ($tipodb == 'pgsql')
        {
         $sql =  'select pg_tables.*, c.*, a.*, t.*, d.*, pg_catalog.format_type(atttypid, atttypmod) as "Type" from pg_tables
                   inner join pg_class c on tablename=relname
                   inner join pg_attribute a on c.oid = a.attrelid
                   inner join pg_type t on t.oid = a.atttypid
                   left join pg_description  d on d.objoid=a.attrelid and d.objsubid= a.attnum
                   where tablename = '.aspa($row['table_name']).' and attstattarget<>0 ';
          $korderbyw = ' order by attnum';
        }

        
        

        $sql = $sql.$korderbyw;
        $rsc = execsql($sql);
        echo "<table class='Geral' width='100%' border='1' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        echo "<tr class='linha_cab_tabela'>  ";
        echo "   <td style='width:90px;' >&nbsp;Campo</td> ";
        echo "   <td style='width:400px;' >&nbsp;Descrição</td> ";
    //    echo "   <td>&nbsp;Tipo de Dado</td> ";
        echo "   <td style='width:90px;'>&nbsp;Tipo</td> ";
        echo "   <td style='width:30px;'>&nbsp;Nulo?</td> ";
        echo "<tr class= 'linha_tabela'>";
        $qtdcpow=0;
        ForEach($rsc->data as $rowc) {
            echo "<tr class= 'linha_tabela' >";
            if ($tipodb == 'mysql')
            {
                 echo "<td class='linha_tabela' >".$rowc['COLUMN_NAME']."&nbsp;</td>";
                 echo "<td class='linha_tabela' style='width:500px;'>".$rowc['COLUMN_COMMENT']."&nbsp;</td>";
                 // echo "<td class='linha_tabela'>".$rowc['COLUMN_DATA_TYPE']."&nbsp;</td>";
                 echo "<td class='linha_tabela' >".$rowc['COLUMN_TYPE']."&nbsp;</td>";
                 if  ($rowc['IS_NULLABLE']=='NO')
                 {
                     echo "<td class='linha_tabela' >Não&nbsp;</td>";
                 }
                 else
                 {
                      echo "<td class='linha_tabela' >Sim&nbsp;</td>";
                 }
            }
            if ($tipodb == 'pgsql')
            {
                 echo "<td class='linha_tabela' style='width:90px;'>".$rowc['attname']."&nbsp;</td>";
                 echo "<td class='linha_tabela' style='width:400px;'>".$rowc['description']."&nbsp;</td>";
                 echo "<td class='linha_tabela' style='width:120px;'>".$rowc['Type']."&nbsp;</td>";
                 if  ($rowc['attnotnull'])
                 {
                     echo "<td class='linha_tabela' style='width:30px;'>Não&nbsp;</td>";
                 }
                 else
                 {
                      echo "<td class='linha_tabela' style='width:30px;'>Sim&nbsp;</td>";
                 }
            }

            echo "</tr>";
            $qtdcpow=$qtdcpow+1;
            $totgeralcampos=$totgeralcampos+1;
        }
        echo "</table>";
        echo "<table class='Geral_tot' width='100%' border='1' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
        echo "<tr align='left'>";
        echo "<td><b>Total de Campos:&nbsp;&nbsp;".$qtdcpow."</b></td>";
        echo "</tr>";
        echo "</table>";
        echo "<table class='Geral_tot' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
        echo "<tr align='left'>";
        echo "<td>&nbsp;</td>";
        echo "</tr>";
        echo "<tr align='left'>";
        echo "<td>&nbsp;</td>";
        echo "</tr>";
        echo "</table>";
     $tottabelasw=$tottabelasw+1;
   }
   echo "<table class='Geral_tot' width='100%' border='1' cellspacing='1' cellpadding='0' vspace='0' hspace='0'>";
   echo "<tr align='left'>";
   echo "<td><b>Total Geral de Campos:&nbsp;&nbsp;".$totgeralcampos."</b></td>";
   echo "</tr>";
   echo "<tr align='left'>";
   echo "<td>&nbsp;</td>";
   echo "</tr>";
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

