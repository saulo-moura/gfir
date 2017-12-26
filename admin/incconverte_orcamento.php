
<style type="text/css">


div#despesa_direta {
    overflow:auto;
    xheight: 380px;
    width : 690px;
    float:left;
    font-family : Arial, Helvetica, sans-serif;
    font-style: normal;
    font-size: 12px;
    font-weight: bold;
    color:#FF5959;
    background: #FFFFFF;
    margin-top:0px;
}


div#despesa_direta_1 {
    overflow:auto;
    sheight: 360px;
    width : 690px;
    float:left;
    font-family : Arial, Helvetica, sans-serif;
    font-style: normal;
    font-size: 12px;
    font-weight: bold;
    color:#FF5959;
    padding:0px;
    background: #FFFFFF;
    sborder:1px solid #910000;
    sborder-top:1px solid #910000;
}


table.despesa_direta_table{
    font-family : Arial, Helvetica, sans-serif;
    font-style: normal;
    font-size: 12px;
    font-weight: normal;
    color:#000000;
    background: #EFEFEF;
}

tr.despesa_direta_table_tr {


}
td.despesa_direta_titulo_td {
    font-weight : bold;
    color       : #004080;
    text-align  :center;
    padding-top :5px;
    padding-left:5px;
    border-bottom:1px solid #9D0000;
}
tr.despesa_direta_cab_tr {

}
td.despesa_direta_cab_td {
    font-weight :bold;
    color       :#004080;
    text-align  :left;
    padding-top :5px;
    padding-left:5px;
    border-bottom:1px solid #9D0000;
}
tr.despesa_direta_linha_tr {

}
td.despesa_direta_linha_td_t {
    font-weight   : normal;
    color         : #640000;
    background    : #EAEAEA;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}

td.despesa_direta_linha_td_t1 {
    font-weight   : normal;
    color         : #640000;
    background    : #EEEEEE;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}

td.despesa_direta_linha_td_t2 {
    font-weight   : normal;
    color         : #640000;
    background    : #F0F0F0;
    padding-top   : 5px;
    padding-left  : 5px;
    border-bottom : 1px solid #C0C0C0;
}

td.despesa_direta_linha_td_a {
    font-weight :normal;
    color       :#575757;
    background  :#FFFFFF;
    padding-top :5px;
    padding-left:5px;
    border-bottom : 1px solid #C0C0C0;
}

div#despesa_direta_c {
    background:#FFCCCC;
    width : 690px;
    height:10px;
    margin:0px;
}

div#despesa_direta_r {
    background:#FFCCCC;
    width : 690px;
    height:10px;
    margin:0px;
    float:left;
}


div#mostra_aditivo {
    position:absolute;


    left:240px;
    top:350px;

    width :700px;
    height:400px;

    background-color: white;
    border:2px solid #808040;
    display:none;

    z-index:2000000;
    font-family : Arial, Helvetica, sans-serif;
    font-size: 14px;
    font-style: normal;
    font-weight: bold;
    color: #004080;
    text-align:center;
    background: #EBEBEB;
    overflow:auto;
}

div#mostra_aditivo img{
    float:right;
    padding-top:5px;
    padding-right:5px;
    padding-bottom:5px;
}

div#mostra_aditivo_cab {
    width :685px;
    height:30px;
    border:2px solid #C0C0C0;
    color:white;
    background: #004080 ;
}

div#mostra_aditivo_det {
    padding-top:5px;
    padding-left:3px;
    font-family : Arial, Helvetica, sans-serif;
    font-size: 14px;
    font-style: normal;
    font-weight: normal;
    color: #A6A6A6;
    text-align:left;

}

div#mostra_aditivo_det img {
    float:left;
    padding-top:0px;
    padding-left:10px;

}


</style>


<?php

function colocar_separador($texto)
{
    $textog=$texto;
    $textow='';
    $textow.=substr($textog,0,17).';';
    $textow.=substr($textog,18,13).';';
    $textow.=substr($textog,31,8).';';
    $textow.=substr($textog,39,103).';';
    $textow.=substr($textog,142,7).';';
    $textow.=substr($textog,149,15).';';
    $textow.=substr($textog,164,42).';';
    $textow.=substr($textog,206,18).';';
    $textow.=substr($textog,224,15).';';
    $textow.=substr($textog,239,11).';';
    return $textow;
}

$sql     = 'select  idt, estado, descricao from empreendimento ';
$sql    .= '    where idt='.null($_SESSION[CS]['g_idt_obra']);
$sql    .= '    order by estado, descricao ';
$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['vlPadrao'] = $_SESSION[CS]['g_idt_obra'];
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Empreendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['empreendimento'] = $Filtro;

$sql     = 'select  idt, identificador from orcamentos_empreendimento ';
$sql    .= '    where idt_empreendimento='.null($_SESSION[CS]['g_idt_obra']);

if ($_GET['idt1']!='')
{
    $sql    .= '    and   idt               ='.null($_GET['idt1']);
}

$sql    .= '      and tipo = '.aspa('1');
$sql    .= '    order by identificador ';

$Filtro  = Array();
$Filtro['rs'] = execsql($sql);
//$Filtro['vlPadrao'] = 0;
if ($_GET['idt1']=='')
{
    $Filtro['LinhaUm'] = ' Selecione um Orçamento ';
}
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Orçamentos';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['orcamentos'] = $Filtro;

$Vetn = Array();
$Vetn['N'] = 'Não';
$Vetn['S'] = 'Sim';


$Filtro  = Array();
$Filtro['rs']    = $Vetn;
$Filtro['id']    = 'idt';
$Filtro['nome']  = 'Informe "S" para Confirmar Execução';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['executar'] = $Filtro;

echo "<div id='mostra_aditivo'>";
echo "    <div id='mostra_aditivo_cab'>";
echo "         <img onclick='desativa_conversao();' src='imagens/fechar_a.gif' border='0'>";
echo "          Conversão do Orçamento";
echo "    </div>";
echo "    <div id='mostra_aditivo_det'>";
echo "    <a><img src='imagens/carregando_1.gif' />Aguarde... Convertendo.</a>";
echo "    </div>";
echo "</div>";


echo '<form name="frm" target="_self" action="conteudo.php?'.substr(getParametro($strPara),1).'" method="post">';

$botao       = 'imagens/botao_executar.jpg';
$botao_texto = 'Executa a Importação dos dados do arquivo TXT para base do PCO';

$Focus = '';
codigo_filtro(false,true,$botao,$botao_texto);
onLoadPag($Focus);

if ($vetFiltro['orcamentos']['valor']==-1)
{
    exit();
}

if ($vetFiltro['executar']['valor']!='S')
{
    exit();
}

$e=$vetFiltro['empreendimento']['valor'];
$o=$vetFiltro['orcamentos']['valor'];

echo '</form>';
echo '<script type="text/javascript" > ';
//echo ' converte(); ';

//echo "   alert(' guy ');   ";
echo "   var msg = '';     ";
echo "   objd=document.getElementById('mostra_aditivo_det'); ";
echo "   objd.innerHTML=objd.innerHTML+msg; ";
echo "   obj=document.getElementById('mostra_aditivo'); ";
echo "   obj.style.display='block';  ";
echo "   $.post('converte_orcamento_ajax.php', {  ";
echo "     empreendimento: {$e}, ";
echo "     orcamentos: {$o} ";
echo "     } , function(str) { ";
echo "         if (str == '') { ";
echo "         } else {         ";
echo "             jQuery('#mostra_aditivo_det').html(str);  ";
echo "         } ";
echo "   });   ";
echo ' </script>';

?>


<script type="text/javascript" >
     function desativa_conversao() {
        document.getElementById('mostra_aditivo').style.display='none';
        //self.location = 'conteudo.php';
        self.location = 'conteudo.php?prefixo=listar&menu=orcamentos_empreendimento&class=0';
     }
</script>



