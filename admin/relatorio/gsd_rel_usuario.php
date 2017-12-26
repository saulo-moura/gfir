<?
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
/*
$vetTpessoa=Array();
$vetTpessoa['Z']='Ausente';
$vetTpessoa['A']='Técnico TI - oas';
$vetTpessoa['P']='Técnico TI - Terceiros';
$vetTpessoa['F']='Solicitantes - Pessoa Física';
$vetTpessoa['T']='Técnico TI - oas e Terceiros';
$Filtro = Array();
$Filtro['rs'] = $vetTpessoa;
$Filtro['nome'] = 'Tipo Usuário';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['tptecnico'] = $Filtro;
*/



 //p('ooooooooooooooo'.$vetFiltro['tipo_regiao']['valor']);
 // exit();


$vetOrdenacao = Array(
    'us.nome_completo' => 'Nome do Usuário',
    'us.login' => 'Login do Usuário',
 //   'en.razao_social,us.nome_completo' => 'Razão Social da Autorizadora'
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

/*
if  ($vetFiltro['tptecnico']['valor']!='Z')
{
    if  ($vetFiltro['tptecnico']['valor']=='T')
    {
         $kwherew=$kwherew.' where us.fornecedor = '.aspa('A').' or us.fornecedor = '.aspa('P');
    }
    else
    {
        $kwherew=$kwherew.' where us.fornecedor = '.aspa($vetFiltro['tptecnico']['valor']);
    }
    $tptecnico=1;
}
else
{    
    $tptecnico=0;
}
*/

$sql = 'select

               us.nome_completo as us_nome_completo,
               us.login as us_login,
               us.ativo as us_ativo,
               us.fornecedor as us_fornecedor,


               pe.nm_perfil as pe_nm_perfil,
               us.dt_validade as us_dt_validade,
               us.email as us_email

        from usuario as us


        inner join perfil   as pe on us.id_perfil   = pe.id_perfil ';
        


   $korderbyw =$korderbyw .' order by '.$vetFiltro['indice_ordenacao']['valor'];

   $sql = $sql.$kwherew.$korderbyw;
   


    $rs = execsql($sql);
    
    $kpriw=1;
    $totusuariosw=0;
    $autoantw=0;
    ForEach($rs->data as $row) {
    if ($kpriw==1)
    {
        if  ($kentidadeautorizadoraw==1)
        {
            echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
            echo "<tr class='linha_cab_tabela'>  ";
            // echo "   <td>&nbsp;Autorizadora: ".$row['en_razao_social']."</td> ";
            echo " </tr> ";
            echo "</table> ";
        }
        $kpriw=0;
        $autoantw=$row['us_idt_entidade'];
        echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        echo "<tr class='linha_cab_tabela'>  ";
        echo "   <td>&nbsp;Nome</td> ";
        echo "   <td>&nbsp;Login</td> ";
        echo "   <td>&nbsp;Perfil</td> ";
        echo "   <td>&nbsp;Ativo</td>  ";
      //  echo "   <td>&nbsp;Tipo</td> ";
       // echo "   <td>&nbsp;Empresa<br>Área</td> ";
        // echo "   <td>&nbsp;E_mail</td>  ";
        // echo "   <td>&nbsp;Validade</td> ";
        //echo "   <td>&nbsp;Plantão</td> ";
        if  ($kentidadeautorizadoraw==0)
        {
        // echo "   <td>&nbsp;Autorizadora</td>";
        }
        echo " </tr> ";
     }
     if  ($kentidadeautorizadoraw==1)
     {
         if ($autoantw!=$row['us_idt_entidade'])
         {
            echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
            echo "<tr class='linha_cab_tabela'>  ";
            echo "   <td>&nbsp;Autorizadora:".$row['en_razao_social']."</td> ";
            echo " </tr> ";
            echo "</table>";
         }
         $autoantw=$row['us_idt_entidade'];
     }
     echo "<tr class= 'linha_tabela'>";
        echo "<td class='linha_tabela'>".$row['us_nome_completo']."&nbsp;</td>";
        echo "<td class='linha_tabela'>".$row['us_login']."&nbsp;</td>";
        echo "<td class='linha_tabela'>".$row['pe_nm_perfil']."&nbsp;</td>";
        echo "<td class='linha_tabela'>".$row['us_ativo']."&nbsp;</td>";
        
     //   echo "<td class='linha_tabela'>".$row['us_fornecedor']."&nbsp;</td>";
     //   echo "<td class='linha_tabela'>".$row['us_empresa_solicitante']."<br>".$row['us_departamento_solicitante']."&nbsp;</td>";
      //  echo "<td class='linha_tabela'>".$row['us_email']."&nbsp;</td>";
      //  echo "<td class='linha_tabela'>".$row['us_tecnico_plantao']."&nbsp;</td>";

   //     echo "<td class='linha_tabela'>".$row['us_dt_validade']."&nbsp;</td>";


        if  ($kentidadeautorizadoraw==0)
        {
  //          echo "<td class='linha_tabela'>".$row['en_razao_social']."&nbsp;</td>";
        }
      echo "</tr>";
      $totusuariosw=$totusuariosw+1;
   }


   echo "</table>";


   
 //  if  ($vetFiltro['entidade_autorizadora']['valor']!=-1)
 //  {
        echo "<table class='Geral_tot' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
        echo "<tr align='left'>";
        echo "<td><b>Total de Usuários:&nbsp;&nbsp;".$totusuariosw."</b></td>";
        echo "</tr>";
        echo "</table>";
 //   }
 
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

