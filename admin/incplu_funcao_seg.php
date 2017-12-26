<style>
#funcao_seguranca {
   background:#F1F1F1;
   width:100%;
   display:block;
   xheight:1000px;
}
.talela_funcao {
   background:#FFFFFF;
   color:#000000;
   
}
.talela_funcao_td {
   padding-left  :10px;
   padding-top   :5px;
   padding-bottom:5px;
   border-bottom: 1px solid #C0C0C0; 
}



.talela_funcao_tdca {
   background:#E0E0E0;
   color:#666666;
   padding-left  :10px;

   padding-top   :5px;
   padding-bottom:5px;
   border-bottom: 1px solid #C0C0C0; 
   text-align:center;
   
}
.talela_funcao_tdlidi {
   background:#F1F1F1;
   color:#666666;
   padding-top   :5px;
   padding-bottom:5px;
   border-bottom: 1px solid #C0C0C0; 
   
}

.talela_funcao_tdc {
   background:#F1F1F1;
   color:#000000;
   padding-top   :5px;
   padding-bottom:5px;
   border-bottom: 1px solid #C0C0C0; 
}
.talela_funcao_tdf {
   background:#FFFFFF;
   color:#000000;
   padding-left  :15px;
   padding-top   :5px;
   padding-bottom:5px;
   border-bottom: 1px solid #C0C0C0; 
}

.talela_funcao_tdfu {
   background:#E9E9E9;
   color:#000000;
   padding-left  :10px;
   padding-top   :5px;
   padding-bottom:5px;
   border-bottom: 1px solid #C0C0C0; 
   
}
.linperfil {
   display:none;
}
</style>
<?php
acesso($menu, "'CON'", true);
onLoadPag('login');

if ($_POST['log_sistema'] == '') {
    $_POST['log_sistema'] = log_sistema;
}

if ($_GET['origem_tela'] == '') {
    $_GET['origem_tela'] = "menu";
}

$origem_tela=$_GET['origem_tela'];

//
function BuscaPerfil($funcao,&$vetRetorno)
{
    $vetDifu = Array();
	$vetDipe = Array();
	
	$vetPerfil   = Array();
	$vetDireito  = Array();
	$vetFuncao   = Array();
	$vetFuncaod  = Array();
	$vetFuncaoc  = Array();
	$sql  = "";
	$sql .= "select * from plu_perfil ";
	$trp  = execsql($sql);
	
	ForEach ($trp->data as $row) {
		$id_perfil        = $row['id_perfil'];
		$perfil_descricao = $row['nm_perfil'];
		$vetPerfil[$id_perfil]=$perfil_descricao;
		// Direitos do Perfil
		$sql = 'select id_difu from plu_direito_perfil where id_perfil = '.$id_perfil;
		$trs = execsql($sql);
		ForEach ($trs->data as $lin) {
		    $id_difu = $lin['id_difu'];
			$vetDipe[$id_perfil][$id_difu] = 'ok';
		}
		$sql = 'select id_direito, nm_direito from plu_direito order by desc_funcao, nm_direito';
		$rs_direito = execsql($sql);
		$tot_direito = $rs_direito->rows;
		ForEach ($rs_direito->data as $lin) {
		    $id_direito = $lin['id_direito'];
			$nm_direito = $lin['nm_direito'];
			$vetDireito[$id_direito]=$nm_direito;
		}
		$sql  = 'select id_funcao, nm_funcao, cod_classificacao, cod_funcao from plu_funcao';
		$sql .= ' where cod_funcao = '.aspa($funcao);
		$sql .= ' order by cod_classificacao';
		$trs  = execsql($sql);
		$tot_funcao = $trs->rows;
		ForEach ($trs->data as $func) {
		    $id_funcao         = $func['id_funcao'];
			$cod_classificacao = $func['cod_classificacao'];
			$cod_funcao        = $func['cod_funcao'];
			$nm_funcao         = $func['nm_funcao'];
			$vetFuncao[$id_funcao]   = $cod_funcao;
			$vetFuncaod[$cod_funcao] = $nm_funcao;
			$vetFuncaoc[$cod_funcao] = $id_funcao;
		}
		$sql  = 'select id_funcao, id_direito, id_difu, descricao from plu_direito_funcao';
		$sql .= ' where id_funcao = '.null($id_funcao);
		$trs = execsql($sql);
		ForEach ($trs->data as $lin) {
			$id_funcao    = $lin['id_funcao'];
			$id_direito   = $lin['id_direito'];
			$vetDifu[$id_funcao][$id_direito] = $lin;
		}
		
		
    }   
	$vetRetorno['vetPerfil']  = $vetPerfil;
	$vetRetorno['vetDireito'] = $vetDireito;
	$vetRetorno['vetFuncao']  = $vetFuncao;
	$vetRetorno['vetFuncaod'] = $vetFuncaod;
	$vetRetorno['vetFuncaoc'] = $vetFuncaoc;
	$vetRetorno['vetDifu']    = $vetDifu;
	$vetRetorno['vetDipe']    = $vetDipe;
	
	return $verRetorno;
}


echo "<div id='funcao_seguranca' >";


$ondeestou        = $_GET['ondeestou'];
if ($ondeestou=='homeobra')
{
    $ondeestou="_painel_home";
}
$funcao_descricao = $_SESSION[CS]['g_vetMenu'][$ondeestou];
$Migalha          = $_SESSION[CS]['g_vetMigalha'][$ondeestou];
if ($origem_tela=="painel")
{

}

//echo "Função: {$ondeestou} - {$funcao_descricao} <br />";
$vetFuncoesPrg=Array();
echo "<table width='100%' class='talela_funcao'>";

echo "<tr class='talela_funcao_td' >";

echo "<td colspan='2' style='text-align:center; ' >";
echo "<input type='button' name='btnAcao' class='Botao' value=' Voltar ' onClick='history.go(-1)'>";
echo "</td>";

echo "</tr>";


echo "<tr class='talela_funcao_td' >";
echo "<td class='talela_funcao_tdca' style='width:30%;' >";
echo "Tipo = ".$origem_tela;
echo "</td>";
echo "<td class='talela_funcao_tdca'>";
echo $Migalha.'::'.$funcao_descricao;
echo "</td>";
echo "</tr>";
echo "</table>";

$vetFuncoesPrg[$ondeestou]=$funcao_descricao;


if ($origem_tela=="menu")
{
    $nivel=0;
    $vetobjListarConf = $_SESSION[CS]['objListarConf'];
    ForEach ($vetobjListarConf as $Chave => $Vetor) {
		if ($Vetor['tabela']==$ondeestou) 
		{    
            $nivel = $nivel + 1;
			$nivelw = ZeroEsq($nivel,2);
            $funcao_descricaof = $_SESSION[CS]['g_vetMenu'][$Vetor['campo']];             			
			$vetFuncoesPrg[$Vetor['campo']]=$funcao_descricaof;
		}
	}
}

function BuscaCodigoPainel($ondeestou)
{
	$codigoPainel = $ondeestou;
    // Carregar php$arquivo = fopen ('arquivo-texto.txt', 'r');
	// Lê o conteúdo do arquivo 

	$arquivo="inc".$codigoPainel.".php";
	if (file_exists($arquivo)) {


		$lines = file ($arquivo);

		// Percorre o array, mostrando o fonte HTML com numeração de linhas.
		foreach ($lines as $line_num => $line) {
			$linew = trim($line);
			$linew = str_replace(" ","",$linew);
			$vet   = explode('=',$linew);
			if ($vet[0]=='$codigo_painel')
			{
				 $funw = str_replace("'","",$vet[1]);
				 $funw = str_replace('"',"",$funw);
				 $funw = str_replace(';',"",$funw);
				 $codigoPainel = $funw;
				// echo "Código == $codigoPainel<br>";
			}
			//echo "Linha #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br>\n";
		}
	} 
	else
	{
		echo " Não encontrado: ".$arquivo.'<br />';

	}
    return $codigoPainel;  
}

function CarregaPainel($ondeestou,&$vetFuncoesPrg,&$vetPainel,&$vetPainelF,&$vetPainelG)
{
	$nivel = $nivel + 1;
	$nivelw = ZeroEsq($nivel,2);
	//$funcao_descricaof = $_SESSION[CS]['g_vetMenu'][$Vetor['campo']];             			
	//$vetFuncoesPrg[$Vetor['campo']]=$funcao_descricaof;
	
	$codigoPainel = BuscaCodigoPainel($ondeestou);
	$sql  = "";
	$sql .= "select * from plu_painel ";
	$sql .= " where codigo = ".aspa($codigoPainel);
	$trp  = execsql($sql);
	//p($sql);
	ForEach ($trp->data as $row) {
	
	    $idt_painel       = $row['idt'];
		$codigo           = $row['codigo'];
		$classificacao    = $row['classificacao'];
		$descricao        = $row['descricao'];
		$vetPainel[$idt_painel]['P'][$codigo]=$descricao;
		// Grupos do Painel
		$sqlpg  = "";
		$sqlpg .= "select * from plu_painel_grupo ";
		$sqlpg .= " where idt_painel = ".null($idt_painel);
		$sqlpg .= " order by ordem ";
		$trppg  = execsql($sqlpg);
		ForEach ($trppg->data as $rowpg) {
			$idt_painel_grupo = $rowpg['idt'];
			$codigo           = $rowpg['codigo'];
			$ordem            = $rowpg['ordem'];
			$descricao        = $rowpg['descricao'];
			
			$vetPainelG[$idt_painel_grupo]=$descricao;
			
			$vetPainel[$idt_painel]['G'][$idt_painel_grupo][]=$codigo;
			$vetPainel[$idt_painel]['G'][$idt_painel_grupo][]=$descricao;
			
			$sqlpf  = "";
			$sqlpf .= "select plu_pf.*, plu_f.cod_funcao as plu_f_cod_funcao , plu_f.nm_funcao as plu_f_nm_funcao   from plu_painel_funcao plu_pf ";
			$sqlpf .= " left join plu_funcao plu_f on plu_f.id_funcao = plu_pf.id_funcao  ";
			$sqlpf .= " where idt_painel_grupo = ".null($idt_painel_grupo);
			$sqlpf .= "   and plu_pf.visivel = ".aspa('S');
			$trppf  = execsql($sqlpf);
			ForEach ($trppf->data as $rowpf) {
				$idt_painel_funcao = $rowpf['idt'];
				$id_funcao         = $rowpf['id_funcao'];
				$plu_f_cod_funcao  = $rowpf['plu_f_cod_funcao'];
				$ordem             = $rowpf['ordem'];
				$plu_f_nm_funcao   = $rowpf['plu_f_nm_funcao'];
				$vetPainel[$idt_painel]['G'][$idt_painel_grupo]['F'][$id_funcao][]=$plu_f_cod_funcao;
				$vetPainel[$idt_painel]['G'][$idt_painel_grupo]['F'][$id_funcao][]=$plu_f_nm_funcao;
				
				$vetPainelF[$plu_f_cod_funcao]=$idt_painel_grupo;
				
				$vetFuncoesPrg[$plu_f_cod_funcao]=$plu_f_nm_funcao;
			}	
		}	
		
	}
}
if ($origem_tela!="menu")
{
    $nivel=0;
	$vetPainelF = Array();
	$vetPainelG = Array();
	CarregaPainel($ondeestou,$vetFuncoesPrg,$vetPainelFuncao,$vetPainelF,$vetPainelG);
	//p($vetPainelF);
	//p($vetPainelG);
	//p($vetPainelFuncao);
}


$qtdfunc = 0;
$idt_grupo_painelw = "0";
ForEach ($vetFuncoesPrg as $Funcao => $Descricao) {
	$funcao     = $Funcao;
	$vetRetorno = Array();
	BuscaPerfil($funcao,$vetRetorno);
	$vetPerfil   = $vetRetorno['vetPerfil'];
	$vetDireito  = $vetRetorno['vetDireito'];
	$vetFuncao   = $vetRetorno['vetFuncao'];
	$vetFuncaod  = $vetRetorno['vetFuncaod'];
	$vetFuncaoc  = $vetRetorno['vetFuncaoc'];
	$vetDifu     = $vetRetorno['vetDifu'];
	$vetDipe     = $vetRetorno['vetDipe'];
	//
	$qtdfunc   = $qtdfunc + 1;
    $id_funcao = $vetFuncaoc[$Funcao];
	$qtdcol= count($vetDireito) + 1;
	$principal = "";
	if ($qtdfunc==1)
	{
	    $principal = " background:#E9E9E9; color:#0000ff;  ";
	}
	echo "<table width='100%' class='talela_funcao'>";
	
	$idt_grupo_painel = $vetPainelF[$funcao];
	if ($idt_grupo_painel != $idt_grupo_painelw)
	{
	    $descricao_grupo = $vetPainelG[$idt_grupo_painel];
		echo "<tr {$onclick} class='' title='Clique na linha para detalhar Perfis e direitos da Função' >";
		echo "<td {$onclick} colspan='{$qtdcol}' class='talela_funcao_tdfu' style='background:#0000FF; cursor:pointer; {$principal}'  >";
		echo " {$descricao_grupo} ";
		echo "</td>";
		echo "</tr>";
		$idt_grupo_painelw = $idt_grupo_painel;
		
	
	}
	
	$onclick = " onclick='return FechaAbreFuncao({$id_funcao});'";
	echo "<tr {$onclick} class='' title='Clique na linha para detalhar Perfis e direitos da Função' >";
	echo "<td  class='talela_funcao_tdfu' style='cursor:pointer; width:30%; {$principal}'  >";
	echo " {$Funcao} ";
	echo "</td>";
	$qtdcolw = $qtdcol - 1;
	echo "<td {$onclick} colspan='{$qtdcolw}' class='talela_funcao_tdfu' style='cursor:pointer; {$principal}'  >";
	echo " {$Descricao} ";
	echo "</td>";
	
	echo "</tr>";
	$linpefil = "lin_{$id_funcao}";
	echo "<tr class='talela_funcao_td {$linpefil} linperfil' >";
	echo "<td class='talela_funcao_tdca' style='width:20%;' >";
	echo "PERFIL";
	echo "</td>";
	//
	ForEach ($vetDireito as $id_direito => $Descricao) {
		echo "<td class='talela_funcao_tdca' style='width:10%;' >";
		echo $Descricao;
		echo "</td>";
	}
	echo "</tr>";
	$vetdireitofuncao    = $vetDifu[$id_funcao];
	
	//p($vetdireitofuncao);
	$vetPerfilFuncaoDireito = Array();
	ForEach ($vetPerfil as $id_perfil => $Descricao) {
		ForEach ($vetDireito as $id_direito => $Descricao) {
			$vetPerfilFuncaoDireito[$id_perfil][$id_direito]='N';
		}
		ForEach ($vetdireitofuncao as $id_direitof => $vetDir) {
		    
			$vetPerfilFuncaoDireito[$id_perfil][$id_direitof]='S';
			$temdireito = $vetDipe[$id_perfil][$vetDir['id_difu']];
			if ($temdireito=='ok')
			{
			    $vetPerfilFuncaoDireito[$id_perfil][$id_direitof]='ok';
			}
		}
	}


	// Linha dos Perfis
	ForEach ($vetPerfil as $id_perfil => $Descricao) {
		echo "<tr class='talela_funcao_td {$linpefil} linperfil' >";
		
		echo "<td class='talela_funcao_tdlidi' style='width:20%;' >";
		echo $Descricao;
		echo "</td>";
		//
		
		
		$vetDireitop = $vetPerfilFuncaoDireito[$id_perfil];
		ForEach ($vetDireitop as $id_direito => $Valor) {
		    $imag = "";
			$tamimg = '16';
		    if ($Valor=='S')
			{
			    $hint  = "Existe o Direito para a Função.";
			    $Valor = 'Existe';
			    $sty   = " background:#FFFFFF; color:#000000; ";
				$imag  = "<img width='{$tamimg}' height='{$tamimg}' src='imagens/bola_vermelha.png' border='0' />";
			}
			else
			{
				if ($Valor=='N')
				{
				    $hint  = "Não Existe o Direito para a Função.";
					$Valor ='Não Existe';
					$sty   = "";
					$imag  = "<img width='{$tamimg}' height='{$tamimg}' src='imagens/bola_amarela.png' border='0' />";
				}
				else
				{
				    $hint  = "Existe o Direito para a Função e esse Perfil tem acesso.";
					$Valor='OK';
					$sty = "";
					$sty = " background:#FFFFFF; color:#000000; ";
					$imag = "<img width='{$tamimg}' height='{$tamimg}' src='imagens/bola_verde.png' border='0' />";
				}
			}
			echo "<td title='{$hint}' class='talela_funcao_tdlidi' style='width:10%; text-align:center; {$sty}' >";
			echo $imag;
			echo "</td>";
		}
		echo "</tr>";
	}
	
	echo "</table>";
}



echo "<table width='100%' class='talela_funcao'>";

echo "<tr class='talela_funcao_td' >";

echo "<td style='text-align:center; ' >";
echo "<input type='button' name='btnAcao' class='Botao' value=' Voltar ' onClick='history.go(-1)'>";
echo "</td>";

echo "</tr>";


echo "</table>";

echo "</div>";

// 
//p($_GET);
//p($_SESSION[CS]);

?>
<script type="text/javascript">
    $(document).ready(function () {
	    var classew = "linperfil";
		$('.'+classew).each(function () {
//			$(this).toggle();  
		});
	});
	function FechaAbreFuncao(id_funcao)
	{
		var classew = "lin_"+id_funcao;
		$('.'+classew).each(function () {
			$(this).toggle();  
		});
        TelaHeight();
	}
</script>	
