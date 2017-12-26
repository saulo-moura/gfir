<?php
Require_Once('relatorio/lupe_generico.php');
Require_Once('relatorio/style.php');
?>


<style type="text/css">

div#area_imprime {
    background: #FFFFFF;
    text-align:right;
}
div#area_imprime img {
    background: #FFFFFF;
    padding-right:5px;
}
div#conteudo {
    overflow:auto;
}
div#smeio_util {
    overflow:auto;
}
div#smeio {
    overflow:auto;
}
div#sgeral {
    overflow:auto;
}


table.Geral_t_pa {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 18px;
	color: #9B0000;
	text-align: left;
	border: 0px solid #FFFFFF;
	border-collapse: collapse;
}

tr.linha_cab_tabela_t_pa {
 	background: #DDDDDD;
	font-weight: bold;
	text-align: center;
	border: 0px solid #B00000;
	border-collapse: collapse;
	padding: 2px;
}

table.Geral_pa {
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FF3C3C;
	text-align: left;
	border: 1px solid #840000;
	border-collapse: collapse;
}


tr.linha_cab_tabela_pa {
 	background: #DDDDDD;
	font-weight: bold;
	text-align: center;
	border: 1px solid #840000;
	border-collapse: collapse;
	padding: 2px;
	color:#0080C0;
}

td.linha_tabela_pa {
	background: #DDDDDD;
	border: 1px solid Black;
	border-collapse: collapse;
	padding: 4px;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #151515;
	text-align: right;
}

td.linha_tabela_pa_d {
	background: #F2F2F2;
	font-weight: bold;
	border: 1px solid Black;
	border-collapse: collapse;
	padding: 4px;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #A7A7A7;
	text-align: right;
}

td.linha_tabela_pa_l {
	background: #F2F2F2;
	font-weight: bold;
	border: 1px solid Black;
	border-collapse: collapse;
	padding: 4px;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 12px;
    color:#000000;
	text-align: center;
	

	
}


td.linha_tabela_sa {
	background: #F8F8F8;
	border: 1px solid Black;
	border-collapse: collapse;
	padding: 10px;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #151515;
	text-align: right;
}

td.linha_tabela_sa_l {
	background: #F8F8F8;
	border: 1px solid Black;
	border-collapse: collapse;
	padding: 4px;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #151515;
	text-align: left;
}


tr.linha_tabela_pa_t {
	background: #DDDDDD;
	font-weight: bold;
	text-align: right;
	border: 1px solid #840000;
	border-collapse: collapse;
	padding: 4px;
	color:#5E0000;
}

td.linha_tabela_pa_t {
	background: #DDDDDD;
	font-weight: bold;
	text-align: right;
	border: 1px solid #840000;
	border-collapse: collapse;
	padding: 10px;
	color:#5E0000;
}

div.barra_imp {
	background: #DDDDDD;
	width:'100%';
}
div.barra_imp img{
	float:right;
}

div#select_a {
	display:none;
    background:#C0C0C0;
    height:300px;
}

div#aciona_select {
	display:block;
    background:#C0C0C0;
    weight:100%;
    height:21px;
}
div#aciona_select a {
    text-decoration:none;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
div#a_aciona_select {
}
div#a_aciona_select span {
    text-decoration:none;
}
div#aciona_select_img {
}

</style>


<?php
$estado = $_GET['codigo1'];
$idt    = $_GET['idt0'];
if ($_GET['print'] != 's') {
    echo "<div class='barra_ferramentas'>";
    echo "<table cellspacing='1' cellpadding='1' width='100%' border='1'>";
    echo "<tr>";
    echo "<td width='20'>";
    echo "<a HREF='conteudo.php?prefixo=inc&menu=administrar_menu&class=0'><img class='bartar' align=middle src='relatorio/voltar_ie.jpg'></a>";
    echo "</td>";

    
    echo "<td width='20'>";
    echo "<a HREF='#' onclick=\"return imprimir_loginobra('$menu','$idt','$estado');\"><img class='bartar' align=middle src='relatorio/visualiza_imprime.jpg'></a>";
    echo "</td>";
    echo "<td width='20'>";
    echo "<a HREF='#' onclick=\"return imprimir_excel_loginobra('$menu','$idt','$estado');\"><img class='bartar' align=middle src='relatorio/excel.gif'></a>";
    echo "</td>";
    echo "<td>&nbsp;</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}
else
{
    echo "<div class='barra_imp'>";
    echo "<a HREF='#' onclick=\"return ch_imp();\"><img class='bartar' align=middle src='imagens/impressora.gif'></a>";
    echo "</div>";
}

/*
$sql   = 'select em.idt ,  em.descricao from empreendimento em ';
$sql  .= ' order by em.estado, em.descricao';
$Filtro          = Array();
    $_GET['pri']='S';
$Filtro['LinhaUm']  = '-- Todos --';
$Filtro['rs']    = execsql($sql);
$Filtro['id']    = 'idt';
$Filtro['nome']  = 'Empreendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['empreendimento'] = $Filtro;
*/
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto_geral';
//$Filtro['js'] = "marca_obra_s('obras_escolha');";
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;





echo '<form name="frm" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';

/*
$imagemf = '<img id="aciona_select_img" src="imagens/abrir_div.gif" title="Clique aqui para Selecionar Obras" alt="Clique aqui para Selecionar Obras"/>';
echo ' <div id="aciona_select" > ';
echo '       <a id="a_aciona_select" href="#" onclick="return seleciona_obras();" title="Clique aqui para Selecionar Obras" >'.$imagemf.'<span class="oas">&nbsp;&nbsp;Selecionar Obras</span></a>';
echo '      </div>  ';



echo '<div id="select_a">';
echo '<select name="obras_escolha" multiple="multiple" onclick="return marca_obra(this);" style="width:100%; height:300px;">';
$sql   = 'select idt, estado, descricao from empreendimento';
$sql  .= ' order by estado, descricao';
$rs = execsql($sql);
if  ($rs->rows==0)
{

}
else
{
     $estado_ant='#';
     ForEach($rs->data as $row) {
        $idt       = $row['idt'];
        $estado    = $row['estado'];
        $descricao = $row['descricao'];
        if ($estado_ant!=$estado)
        {
            $lblinha = ''.$estado;
            $idlinha = 'opcao_id'.$estado;
            echo "<optgroup id='{$idlinha}' label='{$lblinha}'>";
            $estado_ant=$estado;
        }
        $linha   = $estado.' - '.$descricao;
        $lblinha = 'opcao_'.$idt;
        $idlinha = 'opcao_id'.$idt;
        echo "<option id='{$idlinha}' label='{$lblinha}' value='{$idt}'>{$linha}</option>";
     }
}

echo '</select>';
echo '</div>';
*/

if ($_GET['print'] != 's') {
    $Focus = '';
    codigo_filtro(false);
    onLoadPag($Focus);
} else {
 //   codigo_filtro_fixo();
    onLoadPag();
}

$Vopcao_obras=Array();

$obras_escolhidas=$vetFiltro['texto']['valor'];
if  ($obras_escolhidas=='')
{
     $opcao_obras='T';
}
else
{
     $opcao_obras='E';
     $Vopcao_obras=explode('#',$obras_escolhidas);
}
//p($Vopcao_obras);
$Vopcao_obras_idt=Array();
ForEach ($Vopcao_obras as $idxo => $idt)
{
   $Vopcao_obras_idt[$idt]=$idt;
}


$where='';

$sql  = 'select ';
$sql .= ' ls.* ';
$sql .= ' from  log_sistema ls ';
$sql .= ' where ';
$sql .= '    ( ls.sts_acao = '.aspa('L');
$sql .= ' or  ls.sts_acao = '.aspa('S'). ' )  ';
if  ($vetFiltro['texto']['valor']!='')
{
    $sql .= ' and ( ';
    $sql .= ' lower(login) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(dtc_registro) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(nom_usuario) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(nom_tela) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql .= ' order by ls.dtc_registro desc';
$rs = execsql($sql);
$titulo_rel=' Lista de Login ';
echo "<br /><br />";

echo "<table class='Geral_t_pa' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class='linha_cab_tabela_t_pa'>  ";
echo "   <td style='text-align:center;'  colspan='6' >&nbsp;$titulo_rel</td> ";
echo "</tr>";
echo "<tr class='linha_cab_tabela_t_pa'>  ";
echo "   <td style='text-align:center;'  colspan='6' >&nbsp;$subtitulo_rel</td> ";
echo "</tr>";
echo "</table>";

if  ($rs->rows==0)
{
     $msg= "<br><b>Não tem Resultados para Assinaturas.</b><br><br>";
     echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
     echo "<tr class='linha_cab_tabela'>  ";
     echo "   <td style='text-align:center;' >&nbsp;$msg</td> ";
     echo "</tr>";
     echo "</table>";
}
else
{

     echo "<table class='Geral_pa' width='100%' border='1' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
     echo "<tr class='linha_cab_tabela_pa'>  ";
     echo "   <td style='width:15%;' >Data<br />Login</td> ";
     echo "   <td style='width:10%;' >Login</td> ";
     echo "   <td style='width:10%;' >Usuário</td> ";
     echo "   <td style='width:10%;' >tela</td> ";
     echo "</tr>";
     ForEach($rs->data as $row) {
        $login                   = $row['login'];
        $nom_usuario               = $row['nom_usuario'];
        $nom_tela                = $row['nom_tela'];
        $dtc_registro                  = trata_data($row['dtc_registro']);
        echo "<tr class= 'linha_tabela_pa' >";
        echo "<td class='linha_tabela_pa_l' >".$dtc_registro."</td>";
        echo "<td class='linha_tabela_pa_l' >".$login."</td>";
        echo "<td class='linha_tabela_pa_l' >".$nom_usuario."</td>";
        echo "<td class='linha_tabela_pa_l' >".$nom_tela."</td>";
        echo "</tr>";
    }
    echo "</table>";
}





// rodapé
if ($_GET['print'] == 's')
{
   /*
   echo " <table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
   echo " <tr class='linha_cab_tabela'>";
   echo "   <td align='center'><img src='imagens/rodape_rel.jpg'/></td>";
   echo " </tr>";
   echo " </table>";
   */
}
?>
</form>

