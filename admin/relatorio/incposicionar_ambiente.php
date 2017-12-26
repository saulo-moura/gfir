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
    /*
    echo "<td width='20'>";
    echo "<a HREF='#' onclick=\"return imprimir('$menu');\"><img class='bartar' align=middle src='relatorio/visualiza_imprime.jpg'></a>";
    echo "</td>";
    */
    echo "<td>&nbsp;</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}

//Monta o vetor de filtro
$Filtro = Array();
$sql  = "select ";
$sql .= "     em.idt, ";
$sql .= "     sist.descricao, ";
$sql .= "     em.descricao ";
$sql .= "  from empreendimento em ";
$sql .= "  inner join sca_sistema sist on sist.idt = em.idt_sistema ";
$sql .= "  order by sist.descricao, em.descricao";
$Filtro['rs']      = execsql($sql);
$Filtro['id']      = 'idt';
$Filtro['nome']    = 'Sistema Ambiente';
$Filtro['LinhaUm'] = ' Selecione um ambiente de Sistema ';
$Filtro['valor']   = trata_id($Filtro);
$vetFiltro['idt_ambiente'] = $Filtro;


echo '<form name="frm" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';

if ($_GET['print'] != 's') {
    $Focus = '';
    codigo_filtro(false);
    onLoadPag($Focus);
} else {
    codigo_filtro_fixo();
    onLoadPag();
}


echo " <div style='float:left;'>";

$kwherew   ='';
$korderbyw ='';
$idt_ambiente = $vetFiltro['idt_ambiente']['valor'];
if ($idt_ambiente==-1)
{
   echo " Escolha um ambiente.... ";
   echo " </div>";
   onLoadPag();
   FimTela();
   exit();

}

echo ' Parâmetros de conexão ';
$vetConexaoLogin=ObterConexaoLogin($idt_ambiente);
p($vetConexaoLogin);


//converte_cargos();
//converte_cargos_sca()

    $basew='db_oas_sap';
// echo ' Montar Base do SAP ';
//
// Montar_Base($basew);

// echo ' Gerar Tabelas do SAP ';
// Montar_Tabelas_Base($basew);
//
echo ' Aguarde Gerando Macroprocessos do sistema SAP ';
converte_perfil_sap($idt_ambiente);
echo " </div>";




 
 
?>
</form>

