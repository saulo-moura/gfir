<?
Require_Once('configuracao.php');
$vetFiltro = Array();
// Área de botões de controle --- Barra de Ferramentas
if ($_GET['print'] != 's') {
    echo "<div class='barra_ferramentas'>";
    echo "<table cellspacing='1' cellpadding='1' width='100%' border='1'>";
    echo "<tr>";
    echo "<td width='20'>";
    echo "<a HREF='conteudo.php'><img class='bartar' align=middle src='relatorio/voltar_ie.jpg'></a>";
    echo "</td>";
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
echo " <div style='float:left; width:100%;'>";
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
$_SESSION[CS]['sist_idt_ambiente']       =$idt_ambiente;
$_SESSION[CS]['sist_idt_sistema']        = "";
$_SESSION[CS]['sist_sistema_descricao']  = "";
$_SESSION[CS]['sist_ambiente_descricao'] = "";
$sql  = "select ";
$sql .= "     em.idt, ";
$sql .= "     sist.idt as sist_idt, ";
$sql .= "     sist.descricao as sist_descricao, ";
$sql .= "     em.descricao as em_descricao";
$sql .= "  from empreendimento em ";
$sql .= "  inner join sca_sistema sist on sist.idt = em.idt_sistema ";
$sql .= "  where em.idt = ".null($idt_ambiente);
$rs = execsql($sql);
if ($rs->rows > 0)
{
    ForEach ($rs->data as $row)
    {
        $_SESSION[CS]['sist_idt_sistema']        = $row['sist_idt'];
        $_SESSION[CS]['sist_sistema_descricao']  = $row['sist_descricao'];
        $_SESSION[CS]['sist_ambiente_descricao'] = $row['em_descricao'];
    }
}

$vetConexaoLogin=ObterConexaoLogin($idt_ambiente);


echo " <div style='float:left; width:100%; display:block;'>";
    echo "<table cellspacing='1' cellpadding='1' width='100%' border='1'>";
    echo "<tr>";
    echo "<td colspan='12' style='text-align:center; background:#C00000; color:#FFFFFF;'>";
    echo " POSICIONAMENTO PARA O AMBIENTE DO SISTEMA ";
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td style='width:10%; text-align:right; background:#808080; color:#FFFFFF;'>";
    echo " SISTEMA:   ";
    echo "</td>";
    echo "<td>";
    echo $_SESSION[CS]['sist_sistema_descricao'];
    echo "</td>";
    echo "</tr>";
    
    
    echo "<tr>";
    echo "<td style='text-align:right; background:#808080; color:#FFFFFF;'>";
    echo " AMBIENTE:   ";
    echo "</td>";
    echo "<td>";
    echo $_SESSION[CS]['sist_ambiente_descricao'];
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td style='text-align:right; background:#808080; color:#FFFFFF;'>";
    echo " SERVIDOR:   ";
    echo "</td>";
    echo "<td>";
    echo $vetConexaoLogin['servidor'];
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td style='text-align:right; background:#808080; color:#FFFFFF;'>";
    echo " BASE DE DADOS:   ";
    echo "</td>";
    echo "<td>";
    echo $vetConexaoLogin['base_dados'];
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td style='text-align:right; background:#808080; color:#FFFFFF;'>";
    echo " TIPO DE BASE:   ";
    echo "</td>";
    echo "<td>";
    echo $vetConexaoLogin['tipo_base'];
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td style='text-align:right; background:#808080; color:#FFFFFF;'>";
    echo " PORTA:   ";
    echo "</td>";
    echo "<td>";
    echo $vetConexaoLogin['porta'];
    echo "</td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td style='text-align:right; background:#808080; color:#FFFFFF;'>";
    echo " USUÁRIO:   ";
    echo "</td>";
    echo "<td>";
    echo $vetConexaoLogin['usuario'];
    echo "</td>";
    echo "</tr>";
    echo "</table>";
echo " </div>";
echo " </div>";
?>
</form>

