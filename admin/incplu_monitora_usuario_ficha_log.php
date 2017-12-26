<style type="text/css">
	.cab_rel_sist1 {
      background:#0000FF;
	  color:#FFFFFF;
	  font-size:18px;
	  text-align:center;
    }
	.cab_rel_sist {
      background:#0000FF;
	  color:#FFFFFF;
	  font-size:18px;
	  text-align:left;
    }
	.cab_rel {
      background:#C0C0C0;
	  color:#FFFFFF;
	  font-size:16px;
	  text-align:center;
    }
    .tabela_rel {
	  padding-left:5%;
    }
	.lin_rel {
	  border-bottom:1px solid #C0C0C0;
    }
	
</style>
<?php
	$base  = $_GET['base'];
	$login = $_GET['login'];
    //
	// Acessar Usuário
	//
	$vetsistemas         = Array();
    $vetsistemas['grc']  = 'CRM|Sebrae'; 
	$vetsistemas['pfo']  = 'Portal Fornecedor'; 
	$vetsistemasB= Array();
    $vetsistemasB['grc'] = 'db_pir_grc'; 
	$vetsistemasB['pfo'] = 'db_sebrae_pfo'; 
		
	$baseB = $vetsistemasB[$sistema];
	$sql  = "select ";
	$sql .= " plu_usu.*, plu_p.nm_perfil";
	$sql .= " from {$baseB}.plu_usuario plu_usu ";
	$sql .= " inner join {$baseB}.plu_perfil plu_p on plu_p.id_perfil = plu_usu.id_perfil ";
	$sql .= " where login = ".aspa($login) ;
	$rs   = execsql($sql);
	ForEach ($rs->data as $row) {
		$id_usuario         = $row['id_usuario'];
		$nome_completo      = $row['nome_completo'];
		$login              = $row['login'];
		$nm_perfil          = $row['nm_perfil'];
		$matricula_intranet = $row['matricula_intranet'];
	}
	
	$funcionario="";
    if ($matricula_intranet!="")
    {
	    $funcionario="Sim";
	}
	
    echo "<table class='tabela_rel' width='90%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
	echo "<tr >  ";
	echo "<td class='cab_rel_sist1'>  ";
	echo "Sistema";
	echo "</td>  ";
	echo "<td class='cab_rel_sist1' >  ";
	echo "Usuário";
	echo "</td>  ";
	echo "<td class='cab_rel_sist1' >  ";
	echo "Login";
	echo "</td>  ";
	echo "<td class='cab_rel_sist1' >  ";
	echo "Perfil";
	echo "</td>  ";
	echo "<td class='cab_rel_sist1' >  ";
	echo "Funcionário?";
	echo "</td>  ";
	echo "</tr>  ";
	
	echo "<tr >  ";
	echo "<td class='cab_rel'>  ";
	echo $sistema;
	echo "</td>  ";
	echo "<td class='cab_rel'>  ";
	echo $nome_completo;
	echo "</td>  ";
	echo "<td class='cab_rel'>  ";
	echo $login;
	echo "</td>  ";
	echo "<td class='cab_rel'>  ";
	echo $nm_perfil;
	echo "</td>  ";
	
    echo "<td class='cab_rel'>  ";
	echo $funcionario;
	echo "</td>  ";
		
	
	echo "</tr>  ";
	echo "</table>";	
	echo "<br />";	
	//
	// Monitoramento de Login - Auditoria
	//
	echo "<table class='tabela_rel' width='90%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
	echo "<tr >  ";
	echo "<td class='cab_rel_sist'>  ";
	echo "Data";
	echo "</td>  ";
	echo "<td class='cab_rel_sist' >  ";
	echo "IP";
	echo "</td>  ";
	echo "<td class='cab_rel_sist' >  ";
	echo "Tela";
	echo "</td>  ";
	echo "<td class='cab_rel_sist' >  ";
	echo "Logout";
	echo "</td>  ";
	echo "</tr>  ";
	$sql  = "select ";
	$sql .= " plu_ls.* ";
	$sql .= " from {$baseB}.plu_log_sistema plu_ls ";
	$sql .= " where login = ".aspa($login) ;
	//$sql .= " and (sts_acao  = ".aspa('L') ;
	//$sql .= "    or sts_acao = ".aspa('S'). " ) "  ;
	$sql .= " order by dtc_registro asc, sts_acao asc  " ;
	$rs   = execsql($sql);
	$qtdacoes = 0;
	$dtc_registrotrabw= "###";
	ForEach ($rs->data as $row) {
	
	    $ip_usuario    = $row['ip_usuario'];
		$sts_acao      = $row['sts_acao'];
		
		$dtc_registro  = trata_data($row['dtc_registro']);
		
		$dtc_registrotrab  = substr($dtc_registro,1,10);
		
		$nom_tela      = $row['nom_tela'];
		$sts_acao      = $row['sts_acao'];
		
		$vetAcao     = Array();
		$vetAcao['L']='Login';
		$vetAcao['S']='Logout';
		$vetAcao['I']='Inclusão';
		$vetAcao['A']='Alteração';
		$vetAcao['C']='Consulta';
		$vetAcao['E']='Exclusão';
		$sts_acaow   =$vetAcao[$sts_acao];
		$qtdacoes = $qtdacoes +1;
		$colortrab="";
		if ($dtc_registrotrabw!=$dtc_registrotrab)
		{
		    $dtc_registrotrabw=$dtc_registrotrab;
		    $colortrab=" background:#C0C0C0; "; 
		}
		echo "<tr >  ";
		echo "<td class='lin_rel' style='{$colortrab}'>  ";
		echo $dtc_registro;
		echo "</td>  ";
		echo "<td class='lin_rel' style='{$colortrab}'>  ";
		echo $ip_usuario;
		echo "</td>  ";
		echo "<td class='lin_rel' style='{$colortrab}'>  ";
		echo $nom_tela;
		echo "</td>  ";
		echo "<td class='lin_rel' style='{$colortrab}'>  ";
		echo $sts_acaow;
		echo "</td>  ";
		
		echo "</tr>  ";
	}
	
	echo "<tr >  ";
	echo "<td colspan='4' class='cab_rel'>  ";
	$qtdacoesw = format_decimal($qtdacoes,0);
	echo "Quantidade de Ações: {$qtdacoesw} ";
	echo "</td>  ";
	echo "</tr>  ";
	
	echo "</table>";	
	
?>

<script type="text/javascript" >

function xDetalhaLogin(base, login)
{
    alert(' teste detalha '+base+"  "+login);
    return false;
}


    function DetalhaLogin(base, login)
    {
        alert(' teste detalha '+base+"  "+login);
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
