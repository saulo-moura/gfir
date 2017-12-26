<?php
//Require_Once('relatorio/lupe_generico.php');
Require_Once('style.php');

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
$sql = "select idt, descricao from RAV.grupo order by descricao";
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Filtrar Tipo Grupo';
$Filtro['LinhaUm'] = 'Selecione um registro';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['grupo'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'dtc_ini';
$Filtro['nome'] = 'Data Inicio';
$Filtro['js'] = 'data';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dtc_ini'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'dtc_fim';
$Filtro['nome'] = 'Data Fim';
$Filtro['js'] = 'data';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dtc_fim'] = $Filtro;

$Filtro = Array();
$sql='select idt_cliente, nom_cliente from cliente order by nom_cliente';
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt_cliente';
$Filtro['nome'] = 'Cliente';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_cliente'] = $Filtro;

$Filtro = Array();
$sql='select idt_tecnico,nom_tecnico from tecnico order by nom_tecnico';
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt_tecnico';
$Filtro['nome'] = 'Tecnico';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_tecnico'] = $Filtro;


$Filtro = Array();
//$sql = "select idt, descricao from regiao where idt_tipo_regiao=".$vetFiltro['tipo_regiao']['valor']." order by descricao";

$sql = "select idt, descricao from RAV.sub_grupo order by descricao";

$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Filtrar Sub-Grupo';
$Filtro['LinhaUm'] = 'Selecione um registro';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['sub_grupo'] = $Filtro;

$vetOrdenacao = Array(
    're.descricao' => 'Descrição do Grupo',
    're.cod_grupo' => 'Código da Grupo'
);

$Filtro = Array();
$Filtro['rs'] = $vetOrdenacao;
$Filtro['id'] = 'indice_ordenacao';
$Filtro['nome'] = 'Classificar por';
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

$kgrupow ='##';

$kwherew=$kwherew.' where gru.idt = '.null($vetFiltro['grupo']['valor']);

if  (null($vetFiltro['sub_grupo']['valor'])!=-1)
{
    $kwherew=$kwherew.' and sgr.idt = '.null($vetFiltro['sub_grupo']['valor']);
}


$korderbyw =$korderbyw .' order by '.$vetFiltro['indice_ordenacao']['valor'];



$sql = 'select gru.descricao as gru_descricao,
               sgr.descricao as sgr_descricao,
               ite.descricao as ite_descricao

        from RAV.grupo as gru
        
        inner join RAV.sub_grupo as sgr on gru.idt_grupo = gru.idt
        inner join RAV.item as ite on ite.idt_sub_grupo = sgr.idt' ;

            
   $sql = $sql.$kwherew.$korderbyw;
   
   
//  p($sql);
//  exit();

            
    $rs = execsql($sql);
    
    $kpriw=1;
    
    $totsub_grupow=0;
    $totitemw=0;
    
    ForEach($rs->data as $row) {
    
    
     if ($kpriw==1)
     {
       ?>
         <table class="Geral" width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>
        <?php
        echo "<tr>";
        echo "<td class='linha_tabela'>"."Grupo: ".$row['gru_descricao']."&nbsp;</td>";
        echo "</tr>";
        echo "</table>";        
        $kpriw=0;
        
       ?>
         <table class="Geral" width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>
         <tr class='linha_cab_tabela'>
             <td width='300' align='left'>&nbsp;Descrição da Região</td>
             <td  align='left'>&nbsp;Município</td>
         </tr>
        <?php
        $totsub_grupow=0;
        $totitem=0;
      }
        echo "<tr>";
        if  ($kgrupow==$row['gru_descricao'])
        {
            echo "<td class='linha_tabela'>&nbsp;&nbsp;</td>";        
        }
        else
        {
        
            If  ($ksub_grupow=='##')
            {
            }
            else
            {
                 echo "<table class='Geral_tot' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
                 echo "<tr align='left'>";
                       echo "<td><b>Total de Itens:&nbsp;&nbsp;".$totitensw."</b></td>";
                 echo "</tr>";
                 echo "</table>";
                ?>
                   <table class="Geral" width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>
                   <tr class='linha_cab_tabela'>
                       <td width='300' align='left'>&nbsp</td>
                       <td  align='left'>&nbsp</td>
                   </tr>
                <?php
            }    
            echo "<td class='linha_tabela'>".$row['re_descricao']."&nbsp;</td>";
            $ksub_grupow =$row['sgr_descricao'];
            $totsub_grupow=$totsub_grupow+1;
            
            $totmunicipiow=0;
            
        }
        echo "<td class='linha_tabela'>".$row['ite_descricao']."&nbsp;</td>";
        

        $totitensw=$totitensw+1;
    
        
        echo "</tr>";
    }
    
    
//echo "</table>";

// Área de Mostrar Totais do relatório 

//        p(null($vetFiltro['periodo']['valor']));
//        exit();



   if  (null($vetFiltro['grupo']['valor'])!=-1)
   {
        
        echo "<table class='Geral_tot' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
        echo "<tr align='left'>";
             echo "<td><b>Total de Itens:&nbsp;&nbsp;".$totitensw."</b></td>";
        echo "</tr>";
        echo "</table>";
        
        ?>
           <table class="Geral" width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>
           <tr class='linha_cab_tabela'>
               <td width='300' align='left'>&nbsp</td>
               <td  align='left'>&nbsp</td>
           </tr>
        <?php
        echo "<table class='Geral_tot' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
        echo "<tr align='left'>";
             echo "<td><b>Total de Regiões:&nbsp;&nbsp;".$totsub_grupow."</b></td>";
        echo "</tr>";
        echo "</table>";

        
    }


?>
</form>

