<style>
 #filtro_classificacao {
     display:block;
 }
</style>

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

$vetOpcao=Array();
$vetOpcao['S']='Simplificado';
$vetOpcao['C']='Completo';
$Filtro = Array();
$Filtro['rs'] = $vetOpcao;
$Filtro['nome'] = 'Opção';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['tpopcao'] = $Filtro;




 //p('ooooooooooooooo'.$vetFiltro['tipo_regiao']['valor']);
 // exit();

/*
$vetOrdenacao = Array(
    'scase.classificacao, us.nome_completo' => 'Área',
   
    'us.nome_completo' => 'Nome',

    'us.login' => 'Usuário',
    'pe.nm_perfil' => 'Perfil',
 //   'en.razao_social,us.nome_completo' => 'Razão Social da Autorizadora'
);
*/

$vetOrdenacao = Array(

    'us.nome_completo' => 'Nome',

    'us.login' => 'Usuário',
    'pe.nm_perfil' => 'Perfil',
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
echo '<br>';
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


if ($vetFiltro['tpopcao']['valor']=='S')
{

/*

$sql = 'select
               us.nome_completo as us_nome_completo,
               us.login as us_login,
               us.ativo as us_ativo,
               us.acesso_obra as us_acesso_obra,
               us.gerenciador as us_gerenciador,
               pe.nm_perfil as pe_nm_perfil,
               us.dt_validade as us_dt_validade,
               us.email as us_email
       //        scase.classificacao as scase_classificacao,
       //        scase.descricao as scase_descricao

        from plu_usuario as us
     // left  join sca_estrutura as scase on scase.idt =  us.idt_setor
        inner join perfil   as pe on us.id_perfil = pe.id_perfil ';
        
*/


        $sql = 'select
		       sca_op.nome       as sca_op_nome,
			   sca_oc.descricao  as sca_oc_descricao,  
			   sca_os.descricao  as sca_os_descricao,  
               gec_e.credenciado as gec_e_credenciado, 
			   gec_e.credenciado_nan as gec_e_credenciado_nan, 
               us.nome_completo as us_nome_completo,
               us.login as us_login,
               us.ativo as us_ativo,
			   us.matricula_intranet as us_matricula_intranet,
               us.acesso_obra as us_acesso_obra,
               us.gerenciador as us_gerenciador,
               pe.nm_perfil as pe_nm_perfil,
               us.dt_validade as us_dt_validade,
               us.email as us_email
        from plu_usuario as us
        inner join plu_perfil   as pe on us.id_perfil = pe.id_perfil 
		left  join '.db_pir_gec.'gec_entidade as gec_e on gec_e.codigo = us.cpf 
		and reg_situacao = '.aspa('A').	              
		'left  join '.db_pir.'sca_organizacao_pessoa as sca_op on sca_op.cod_usuario = us.login 
		 left  join '.db_pir.'sca_organizacao_cargo as sca_oc on sca_oc.idt = sca_op.idt_cargo 
		 left  join '.db_pir.'sca_organizacao_secao as sca_os on sca_os.idt sca_op.idt_secao'; 
	                
		
    $korderbyw = $korderbyw .' order by '.$vetFiltro['indice_ordenacao']['valor'];
    $sql = $sql.$kwherew.$korderbyw; 
    $rs  = execsql($sql);
    
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
        echo "   <td style='background:#C00000; font-size:14px; color:#FFFFFF; '>Natureza</td> ";
        echo "   <td style='background:#C00000; font-size:14px; color:#FFFFFF; ' >Nome</td> ";
        echo "   <td style='background:#C00000; font-size:14px; color:#FFFFFF; '>Usuário</td> ";
        echo "   <td style='background:#C00000; font-size:14px; color:#FFFFFF; '>Perfil</td> ";
        echo "   <td style='background:#C00000; font-size:14px; color:#FFFFFF; '>Ativo?</td>  ";
        echo "   <td style='background:#C00000; font-size:14px; color:#FFFFFF; '>GC?</td> ";
        echo "   <td style='background:#C00000; font-size:14px; color:#FFFFFF; '>Todos<br />CC?</td> ";

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


 $bgcolor='#FFFFFF';
        $color  ='#000000';

        if ($row['se_cor']!='')
        {
            $bgcolor=$row['se_cor'];

        }
       if ($row['se_corl']!='')
        {
            $color  =$row['se_corl'];

        }
		
		$sca_op_nome           = $row['sca_op_nome']; 
        $gec_e_credenciado     = $row['gec_e_credenciado']; 
		$gec_e_credenciado_nan = $row['gec_e_credenciado_nan']; 
		$us_matricula_intranet = $row['us_matricula_intranet']; 

		$sca_oc_descricao           = $row['sca_oc_descricao']; 
		$sca_os_descricao           = $row['sca_os_descricao']; 



		$natureza = "";
		if ($us_matricula_intranet!="")
		{
           $natureza .= " [FU]"; 
		}
        if ($gec_e_credenciado=="S")
		{
           $natureza .= " [GC]"; 
		}
        if ($gec_e_credenciado_nan=="S")
		{
           $natureza .= " [NAN]"; 
		}
echo "<td class='linha_tabela' style='width:20px; background:{$bgcolor}; font-size:12px; color:{$color}; '>".$natureza."&nbsp;</td>";


        echo "<td class='linha_tabela' style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$row['us_nome_completo'].'<br>'.$sca_op_nome."&nbsp;</td>";
$gc = 'Não';
$cc = 'Não';
if ($row['us_gerenciador']=='S')
{
    $gc = 'Sim';
}
        if ($row['us_acesso_obra']==0)
{
$cc = 'Sim';

}
       

        $us_login = str_replace('@oasempreendimentos.com','',$row['us_login']);

        echo "<td class='linha_tabela' style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$us_login."&nbsp;</td>";
        echo "<td class='linha_tabela' style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$row['pe_nm_perfil']."&nbsp;</td>";
        echo "<td class='linha_tabela' style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$row['us_ativo']."&nbsp;</td>";
        
        echo "<td class='linha_tabela'  style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$gc."</td>";
        echo "<td class='linha_tabela' style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$cc."</td>";




      //  echo "<td class='linha_tabela' style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$row['us_email']."&nbsp;</td>";
      //  echo "<td class='linha_tabela' style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$row['us_tecnico_plantao']."&nbsp;</td>";

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
        echo "<td style='background:#808080; font-size:14px; color:#FFFFFF; text-align:center; '><b>Total de Usuários:&nbsp;&nbsp;".$totusuariosw."</b></td>";
        echo "</tr>";
        echo "</table>";
 //   }


}


///////////////////////////// completo
if ($vetFiltro['tpopcao']['valor']=='C')
{


$sql = 'select

               us.id_usuario as us_id_usuario,
               us.nome_completo as us_nome_completo,
               us.login as us_login,
               us.ativo as us_ativo,
               us.acesso_obra as us_acesso_obra,
               us.gerenciador as us_gerenciador,
               pe.nm_perfil as pe_nm_perfil,
               spe.nm_perfil as spe_nm_perfil,
               us.dt_validade as us_dt_validade,
               us.email as us_email,
               scase.classificacao as scase_classificacao,
               scase.descricao as scase_descricao

        from usuario as us


        inner join perfil   as pe on us.id_perfil       = pe.id_perfil
        left  join sca_estrutura  as scase on scase.idt = us.idt_setor

        inner join site_perfil   as spe on spe.id_perfil   = us.id_site_perfil ';
        


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
        
        echo "   <td style='background:#C00000; font-size:14px; color:#FFFFFF; ' >NOME</td> ";
        echo "   <td style='background:#C00000; font-size:14px; color:#FFFFFF; '>USUÁRIO</td> ";
        echo "   <td style='background:#C00000; font-size:14px; color:#FFFFFF; '>PERFIL GC<br />SITE</td> ";
        echo "   <td style='background:#C00000; font-size:14px; color:#FFFFFF; '>ATIVO</td>  ";
        echo "   <td style='background:#C00000; font-size:14px; color:#FFFFFF; '>ACESSA<br /> GC?</td> ";
        echo "   <td style='background:#C00000; font-size:14px; color:#FFFFFF; '>TODOS<br />CC?</td> ";
        echo "   <td style='background:#C00000; font-size:14px; color:#FFFFFF; '>ÁREA</td> ";

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
$gc = 'Não';
$cc = 'Não';
if ($row['us_gerenciador']=='S')
{
    $gc = 'Sim';
}
        if ($row['us_acesso_obra']==0)
{
$cc = 'Sim';

}
         

        $bgcolor='#FFFFFF';
        $color  ='#000000';
        $us_login = str_replace('@oasempreendimentos.com','',$row['us_login']);

        echo "<td class='linha_tabela' style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$us_login."&nbsp;</td>";
        echo "<td class='linha_tabela' style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$row['pe_nm_perfil'].'<br />'.$row['spe_nm_perfil']."&nbsp;</td>";
        echo "<td class='linha_tabela' style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$row['us_ativo']."&nbsp;</td>";
        
        echo "<td class='linha_tabela'  style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$gc."</td>";
        echo "<td class='linha_tabela' style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$cc."</td>";
        echo "<td class='linha_tabela' style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$row['se_descricao']."&nbsp;</td>";


      //  echo "<td class='linha_tabela' style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$row['us_email']."&nbsp;</td>";
      //  echo "<td class='linha_tabela' style='background:{$bgcolor}; font-size:12px; color:{$color}; '>".$row['us_tecnico_plantao']."&nbsp;</td>";

   //     echo "<td class='linha_tabela'>".$row['us_dt_validade']."&nbsp;</td>";


        if  ($kentidadeautorizadoraw==0)
        {
  //          echo "<td class='linha_tabela'>".$row['en_razao_social']."&nbsp;</td>";
        }
      echo "</tr>";
      $id_usuario=$row['us_id_usuario']; 
      echo "<tr class= 'linha_tabela'>";
        echo "<td class='linha_tabela'>&nbsp;</td>";
        echo "<td colspan='6' class='linha_tabela'>";




        echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        echo "<tr class='linha_cab_tabela'>  ";
        echo "   <td style='background:#808080; font-size:14px; color:#FFFFFF; ' >Centro de Custo</td> ";
        echo "   <td style='background:#808080; font-size:14px; color:#FFFFFF; '>Descrição</td> ";
        echo " </tr> ";

        $sqle  = 'select em.idt as idt_empreendimento, substring(em.classificacao,6,2) as departamento, em.classificacao ,em.estado, em.descricao ';
        $sqle .= ' from empreendimento em ';
        $sqle .= ' inner join usuario_empreendimento ue on ue.idt_empreendimento = em.idt ';
        $sqle .= ' where ue.id_usuario = '.null($id_usuario);

        $sqle .= ' order by substring(em.classificacao,6,2), em.classificacao, em.estado, em.descricao';

        $rse = execsql($sqle);
        $qtccc=0;   
        ForEach($rse->data as $rowe) {
           echo "<tr class='linha_tabela'>";
           echo "<td class='linha_tabela'>".$rowe['departamento'].'.'.substr($rowe['classificacao'],0,4).'.'.substr($rowe['classificacao'],8,3)."&nbsp;</td>";
         //  echo "<td class='linha_tabela'>".$rowe['estado']."&nbsp;</td>";
           echo "<td class='linha_tabela'>".$rowe['descricao']."&nbsp;</td>";
           echo "</tr>";
           $qtccc=$qtccc+1;
        }

           echo "<tr class='linha_tabela'>";
           echo "<td colspan='2' class='linha_tabela' style='background:#C0C0C0; color:#000000; ' >Quantidade de CC = ".$qtccc."</td>";
           echo "</tr>";

        echo "</table ";




        echo "</td>";

      echo "</tr>";



      $totusuariosw=$totusuariosw+1;
   }


   echo "</table>";


   
 //  if  ($vetFiltro['entidade_autorizadora']['valor']!=-1)
 //  {
        echo "<table class='Geral_tot' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
        echo "<tr align='left'>";
        echo "<td style='background:#808080; font-size:14px; color:#FFFFFF; text-align:center; '><b>Total de Usuários:&nbsp;&nbsp;".$totusuariosw."</b></td>";
        echo "</tr>";
        echo "</table>";
 //   }


}




 ////////////////////////////
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

