
<style type="text/css">


    .cb_texto_tit {
        background:#0080C0;
        color:#FFFFFF;
        font-size:20px;
        text-align:left;
        padding-left:10px;

    }
    .cb_texto_cab {
        background:#0000FF;
        color:#FFFFFF;
        font-size:18px;
    }

    .cb_texto_cab1 {
        padding-left:10px;
    }
    .cb_texto_int_cab {
        background:#0000FF;
        color:#FFFFFF;
        font-size:14px;
        text-align:right;
        padding-right:20px;

    }

    .cb_texto_linha_par {
        background:#FFFFFF;
        font-size:12px;
    }
    .cb_texto_linha_imp {
        background:#F1F1F1;
        font-size:12px;
    }

    .cb_texto {
        color:#000000; text-align:left;
        padding-left:10px;

    }
    .cb_inteiro {
        color:#000000;
        text-align:right;
        padding-right:20px;
    }

    .cb_perc {
        color:#000000;
        text-align:right;
        padding-right:20px;
    }

    .total_g {
        background:#0080FF;
        color:#FFFFFF;
    }
    .semclassificar {
        background:#FF0000;
        color:#FFFFFF;
    }

	.cab_rel_sist {
      background:#0000FF;
	  color:#FFFFFF;
	  font-size:18px;
	  text-align:center;;
    }
	.cab_rel {
      background:#C0C0C0;
	  color:#FFFFFF;
	  font-size:16px;
    }
    .tabela_rel {
	  xpadding-left:5%;
    }
</style>


<?php
    // 
    // 
	//
    $vetsistemas= Array();
    $vetsistemas['grc']='CRM|Sebrae'; 
	$vetsistemas['pfo']='Portal Fornecedor'; 
	$vetsistemasB= Array();
    $vetsistemasB['grc']='db_pir_grc'; 
	$vetsistemasB['pfo']='db_sebrae_pfo'; 
	//
    $vetParametros['sistemas'] = $vetsistemas;
	$vetParametros['bases']    = $vetsistemasB;
	//
    $vetEstatisticaUtilizacao=Array();
	$vetEstatisticaUtilizacaoGeral=Array();
    PLU_EstatisticaUtilizacao($vetParametros,$vetEstatisticaUtilizacao,$vetEstatisticaUtilizacaoGeral);
	//
    // p($vetEstatisticaUtilizacao);
	//
    echo "<table class='tabela_rel' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
	$colw=4;
    ForEach ($vetEstatisticaUtilizacao as $sistema => $vetSistema)
    {
      if ($sistema == 'geral')
	  {
	      //$QTDTGeral = $vetEstatisticaUtilizacao[$sistema]['QTDT'];
		  continue;
	  }
	  else
	  {
	      //
	      // Por sistema
		  //
		  
		  echo "<tr class='cab_rel_sist  '>  ";
		  echo "<td colspan='{$colw}'  >  ";
		  echo "Sistema : {$sistema}";
		  echo "</td>  ";
		  echo "</tr>  ";
		  echo "<tr class='cab_rel' {$sistema}>  ";
		  echo "<td  style='padding-left:15px;'>  ";
		  echo "Login";
		  echo "</td>  ";
		  echo "<td>  ";
		  echo "Nome Completo";
		  echo "</td>  ";
		  echo "<td>  ";
		  echo "Perfil";
		  echo "</td>  ";
		  echo "<td>  ";
		  echo "Funcionário?";
		  echo "</td>  ";
		  echo "</tr>  ";
		  $qtd_funcionarios=0;
		  $qtd_externos    =0;

		  ForEach ($vetSistema as $login => $row)
		  {
		      $login         =  $row['login'];
			  $nom_usuario   =  $row['nom_usuario'];
			  $id_usuario    =  $row['id_usuario'];
			  
			  $baseB = $vetsistemasB[$sistema];
			  
			  $vetTipoUsuario=Array();
		      PLU_VerificaUsuario($id_usuario,$baseB,$vetTipoUsuario);
			  
              $rowu = $vetTipoUsuario['rowu'];
              $nm_perfil = $rowu['nm_perfil'];
			  $matricula_intranet = $rowu['matricula_intranet'];
			  $funcionario = "";
			  if ($matricula_intranet!="")
			  {
			      $funcionario      = "Sim";
  			  	  $qtd_funcionarios = $qtd_funcionarios+1;

			  }
			  else
			  {
	              $qtd_externos     = $qtd_externos+1 ;
			  }
			  echo "<tr class='{$sistema}'>  ";
              echo "<td   style='padding-left:15px; border-bottom:1px solid #C0C0C0; ' >  ";
			  echo "<div style='border-bottom:1px solid #C0C0C0; cursor:pointer; color:#0000FF;'   onclick='return FichaUsuario({$id_usuario}, ".'"'.$nom_usuario.'","'.$sistema.'"'." );' >";
			  echo $login;
			  echo "</div>";
			  echo "</td>  ";
			  
			  echo "<td style='border-bottom:1px solid #C0C0C0; ' >  ";
			  echo $nom_usuario;
			  echo "</td>  ";
			  echo "<td   style='border-bottom:1px solid #C0C0C0; ' >  ";
			  echo $nm_perfil;
			  echo "</td>  ";			  
			  echo "<td   style='border-bottom:1px solid #C0C0C0; ' >  ";
			  echo $funcionario;
			  echo "</td>  ";			  
			  echo "</tr>  ";
		  } 
		  $vetQtfunc[$sistema]=$qtd_funcionarios;
      } 
	} 
	//
    // 	
	//
    ForEach ($vetEstatisticaUtilizacao as $sistema => $vetSistema)
    {
		if ($sistema != 'geral')
		{
		    continue;
		}
		//
		echo "<tr class='cab_rel_sist'>  ";
		echo "<td colspan='{$colw}' >  ";
		echo "Quantidade de Usuários por Sistema";
		echo "</td>  ";
		echo "</tr>  ";
		echo "<tr class='cab_rel'>  ";
		echo "<td>  ";
		echo "Sistema";
		echo "</td>  ";
		echo "<td>  ";
		echo "Quantidade usuários";
		echo "</td>  ";
	    echo "<td>  ";
		echo "Qtd Funcionários";
		echo "</td>  ";
		echo "<td>  ";
		echo "Externos";
		echo "</td>  ";
		echo "</tr>  ";
		//
		ForEach ($vetSistema as $sistemaw => $VetQtd)
		{
		  $sistemawt = $sistemaw; 
		  $style   = " style = 'border-bottom:1px solid #C0C0C0; ' ";
		  if ($sistemaw=='geral')
		  {
		      $sistemawt='Total Geral';
			  $style   = " style = 'background:#FF0000; color:#FFFFFF; border-bottom:1px solid #C0C0C0; ' ";
		  }
		  //
		  $qtd_usuarios   =  $VetQtd['qtd_usuarios'];
		  $funcionario    =  $vetQtfunc[$sistemaw];
		  if ($funcionario=="")
		  {
		      $funcionario=0; 
		  }
		  $externos     = $qtd_usuarios - $funcionario;
		  $funcionariow = format_decimal($funcionario,0);
		  $externosw    = format_decimal($externos,0);
		  //
		  echo "<tr class=''>  ";
		  echo "<td {$style} >  ";
		  echo $sistemawt;
		  echo "</td>  ";
		  echo "<td {$style}>  ";
		  $qtd_usuariosw = format_decimal($qtd_usuarios,0);
		  echo $qtd_usuariosw;
		  echo "</td>  ";
          //		  
		  if ($sistemaw!='geral')
		  {
			  echo "<td  {$style}>  ";
			  echo $funcionariow;
			  echo "</td>  ";
			  echo "<td  {$style}>  ";
			  echo $externosw;
			  echo "</td>  ";
		  }
		  else
		  {
			  echo "<td  {$style}>  ";
			  echo "";
			  echo "</td>  ";
			  echo "<td  {$style}>  ";
			  echo "";
			  echo "</td>  ";
		  
		  }
		  echo "</tr>  ";
		} 
	} 	
    echo "</table>";	
	
	
	//
	//  Visão Geral
	//
    echo "<table class='tabela_relx' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
	$colw=4;
	echo "<tr class='cab_rel_sist'>  ";
	echo "<td colspan='{$colw}' >  ";
	echo "Usuários da Solução PIR";
	echo "</td>  ";
	echo "</tr>  ";
	echo "<tr class='cab_rel {$sistema}'>  ";
	echo "<td>  ";
	echo "Login";
	echo "</td>  ";
	echo "<td>  ";
	echo "Nome Completo";
	echo "</td>  ";
	echo "<td>  ";
	echo "Sistema";
	echo "</td>  ";
	echo "<td>  ";
	echo "Perfil";
	echo "</td>  ";
	echo "</tr>  ";
	$loginw = "##";
	$qtdlogint=0;
	ksort($vetEstatisticaUtilizacaoGeral);
    ForEach ($vetEstatisticaUtilizacaoGeral as $login => $Vetsistema)
    {
		ForEach ($Vetsistema as $sistema => $idt_usuario)
		{
			$baseB = $vetsistemasB[$sistema];
			$sql  = "select ";
			$sql .= " plu_usu.*, plu_p.nm_perfil";
			$sql .= " from {$baseB}.plu_usuario plu_usu ";
			$sql .= " inner join {$baseB}.plu_perfil plu_p on plu_p.id_perfil = plu_usu.id_perfil ";
			$sql .= " where id_usuario = ".null($idt_usuario) ;
			$rs   = execsql($sql);
			ForEach ($rs->data as $row) {
				$id_usuario         = $row['id_usuario'];
				$nome_completo      = $row['nome_completo'];
				//$login              = $row['login'];
				$nm_perfil          = $row['nm_perfil'];
				$matricula_intranet = $row['matricula_intranet'];
			}
			$style   = " style = 'border-bottom:1px solid #C0C0C0; ' ";
			
			if ($loginw != $login)
			{
				$loginw = $login;
				$style  = " style = 'background:#F5F5F5; border-bottom:1px solid #C0C0C0; ' "; 
				$qtdlogint=$qtdlogint+1;
			}
			echo "<tr class='' {$sistema}>  ";
			echo "<td {$style} >  ";
			echo $login;
			echo "</td>  ";
			echo "<td {$style} >  ";
			echo $nome_completo;
			echo "</td>  ";
			echo "<td {$style}>  ";
			echo $sistema;
			echo "</td>  ";
			echo "<td {$style}>  ";
			echo $nm_perfil;
			echo "</td>  ";
			echo "</tr>  ";
		}
	} 	
	$style  = " style = 'background:#FF0000; color:#FFFFFF;' "; 
	echo "<tr class=''>  ";
	echo "<td {$style} >  ";
	echo "Total de Usuários do PIR: ";
	echo "</td>  ";
	echo "<td {$style}>  ";
	$qtdlogintw = format_decimal($qtdlogint,0);
	echo $qtdlogintw;
	echo "</td>  ";
	echo "<td {$style} >  ";
	echo "";
	echo "</td>  ";
	echo "<td {$style} >  ";
	echo "";
	echo "</td>  ";
	
	echo "</tr>  ";
	
    echo "</table>";
	
	
	
	
	
	
	
?>

<script type="text/javascript" >
    //  var idt_organizacao = <?php echo $idt_organizacao; ?>;
    function FichaUsuario(id_usuario,nome_usuario,sistema)
    {
        //alert('Usuario= '+id_usuario+' - '+nome_usuario+' - '+sistema);
        var opcao  = "A";
        var parww  = '&idt_usuario=' + id_usuario + '&nome_usuario=' + nome_usuario + '&sistema=' + sistema ;
		//alert(' parww= '+parww);
        var href   = 'conteudo_monitora_usuario_ficha.php?prefixo=inc&menu=plu_monitora_usuario_ficha&print=n&titulo_rel=Ficha de Monitoramento do usuário'+parww;
		//alert(' href= '+href);
        var left   = 0;
        var top    = 0;
        var height = $(window).height();
        var width  = $(window).width();
        top        = 10;
        left       = 10;
        width      = width  - 20;
        height     = height - 20;
        var titulo = "<div style='width:700px; display:block; text-align:center; '>Usuário: " + nome_usuario + "</div>";
        showPopWin(href, titulo, width, height, close_FichaUsuario, true, top, left);
        return false;
    }
    function close_FichaUsuario(returnVal) {
        //alert(returnVal);
        //var href = "conteudo_tipologia.php?prefixo=inc&menu=tipologia_medicao&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S&idt_empreendimento="+idt_empreendimento;
        //self.location =  href;
    }
</script>
