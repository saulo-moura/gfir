<?php

Require_Once('configuracao.php');

?>



<style type="text/css" >
    div#conteudo {
        padding:0px;
        margin:0px;
        margin-left:0px;
        width:1000px;
    }
    img#estado {
        float: left;
        margin-right: 10px;
    }

    div#empreendimento {
        float: left;
        margin-top:0px;
        margin-left:0px;
        width :100%;
    }
    div#empreendimento img {
        margin-right: 10px;
        margin-bottom: 10px;
        vertical-align: middle;
        cursor: pointer;
    }




   div#empreendimento_t {
        float: left;
        margin-top:10px;
        margin-left:10px;
        width :100%;
        display:none;
    }
    div#empreendimento_t img {
        margin-right: 10px;
        margin-bottom: 10px;
        vertical-align: middle;
        cursor: pointer;
    }






    div#empreendimento_li {
        float :left;
        sheight:110px;
        swidth :122px;
        swidth :120px;
        width :95%;
        border:0px;
        padding:0px;
        sborder:1px solid #E2E2E2;
        margin-left:3px;
        margin-bottom:3px;
        vertical-align: middle;
        display:table;
    }
    div.empreendimento_l {
        float :left;
        height:110px;
        swidth :122px;
        width :120px;
        border:0px;
        padding:0px;
        border:3px solid #C0C0C0;
        sbackground:#E2E2E2;
        margin-left:15px;
        smargin-bottom:3px;
        margin-bottom:15px;
        vertical-align: middle;
        display:table-cell;
        sdisplay:table;
        text-align:center;
    }

    div.sempreendimento_l .empreendimento_l_d {

        height:110px;
        width :120px;
        top: 50%;
        left: 50%;
        margin-top: -55px;
        margin-left: -60px;
        position: absolute;
        border: 1px solid black;
    }
    div.empreendimento_l * {
        vertical-align: middle;
    }
    div#sem_empreendimento {
        float :left;
        height:300px;
        width :100%;
        border:3px solid #E5E5E5;
        padding:0px;
        margin:0px;
        display:block;
        background:#C00000;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 18px;
        font-style: normal;
        font-weight: bold;

        color:#FFFFFF;
        text-align:center;
    }

    div#inf_empreendimento {
        float :left;
        height:100px;
        width :100%;
        border:3px solid #E5E5E5;
        padding:0px;
        margin:0px;
        display:block;
        background:#FFFFFF;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 18px;
        font-style: normal;
        font-weight: bold;

        color:#C0C0C0;
        text-align:center;
        margin-bottom:5px;
    }

    div#inf_empreendimento_t {
        float :left;
        height:100px;
        width :100%;
        border:3px solid #E5E5E5;
        padding:0px;
        margin:0px;
        display:block;
        background:#808080;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 18px;
        font-style: normal;
        font-weight: bold;

        color:#C0C0C0;
        text-align:center;
        margin-bottom:5px;
    }

    .cab1 {
        border:1px solid #E5E5E5;
        background:#808080;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 14px;
        font-style: normal;
        font-weight: bold;
        color:#FFFFFF;
        text-align:left;
        height:25px;
    }

    .det1 {
        border:0px solid #E5E5E5;
        background:#FFFFFF;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-style: normal;
        font-weight: normal;
        color:#000000;
        text-align:left;
    }
    .chama {
        cursor:pointer;
        color:#0080C0;
        font-weight: bold;
        font-size: 14px;
    }
    .autoriza {
        //cursor:pointer;
        //color:#C00000;
        font-weight: bold;
        font-size: 14px;
    }

    .tot1 {
        border:1px solid #E5E5E5;
        background:#C00000;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 18px;
        font-style: normal;
        font-weight: bold;
        color:#FFFFFF;
        text-align:center;
        height:25px;
    }


    .sep1 {
        border:1px solid #E5E5E5;
        background:#808080;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 18px;
        font-style: normal;
        font-weight: bold;
        color:#FFFFFF;
        text-align:center;
        height:25px;
    }

    .cabtab1 {
        border:1px solid #E5E5E5;
        background:#A0A0A0;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 18px;
        font-style: normal;
        font-weight: bold;
        color:#FFFFFF;
        text-align:center;
        height:25px;
    }

    .tab1 {

    }


</style>





<?php

//Require_Once('configuracao.php');

if ($_REQUEST['menu'] == '')
 	$menu = 'vazio';
else
	$menu = $_REQUEST['menu'];

if ($_REQUEST['prefixo'] == '')
	$prefixo = 'inc';
else
	$prefixo = $_REQUEST['prefixo'];


if ($_REQUEST['titulo_rel'] == '')
    $nome_titulo='';
else
	$nome_titulo = $_REQUEST['titulo_rel'];

if ($_REQUEST['origem'] == '')
    $origem='';
else
	$origem = $_REQUEST['origem'];

if ($_REQUEST['ampliar'] == '')
    $ampliar='';
else
	$ampliar = $_REQUEST['ampliar'];
	
if ($_REQUEST['idt'] == '')
    $idt=0;
else
	$idt = $_REQUEST['idt'];
 //    echo 'Aguarde...';
 //    $path='inc_email.php';
$sql  = '';
$sql .= ' select ';
$sql .= ' em.idt          as em_idt,';
$sql .= ' em.imagem       as em_imagem,';
$sql .= ' em.descricao    as em_descricao,';
$sql .= ' em.chama        as em_chama,';
$sql .= ' em.detalhe      as em_detalhe,';
$sql .= ' scasi.idt       as scasi_idt,';
$sql .= ' scasi.codigo    as scasi_codigo,';
$sql .= ' scasi.sigla     as scasi_sigla,';
$sql .= ' scasi.descricao as scasi_descricao,';
$sql .= ' scasi.detalhe   as scasi_detalhe,';
$sql .= ' scasi.imagem    as scasi_imagem';
$sql .= ' from  empreendimento em';
$sql .= ' inner join sca_sistema scasi on scasi.idt = em.idt_sistema';
$sql .= ' left join usuario_empreendimento uem on uem.idt_empreendimento = em.idt';
$sql .= ' where em.idt = '.null($idt);
$sql .= '   and ';
$sql .= '    em.ativo = '.aspa('S');
$sql .= ' order by scasi.descricao , em.descricao';
$rs = execsql($sql);
$path     = $dir_file.'/empreendimento/';
$path_uf  = $dir_file.'/estado/';



$path_si  = $dir_file.'/sca_sistema/';
$Vet_obra = Array();
$Vet_obra = $_SESSION[CS]['g_vet_obras'];
$pri = 0;

$qtdsist      = 0;
$qtdambientes = 0;

$pri = 0;

echo '<div id="empreendimento">';
//p($sql);
$scasi_descricao_ant = "##";
foreach ($rs->data as $row) {

    $idt_ambiente       = $row['em_idt'];
    $imagem_ambiente    = $row['em_imagem'];
    $descricao_ambiente = $row['em_descricao'];
    $chama_ambiente     = $row['em_chama'];
    $detalhe_ambiente   = $row['em_detalhe'];
    $idt_sistema        = $row['scasi_idt'];
    $codigo_sistema     = $row['scasi_codigo'];
    $sigla_sistema      = $row['scasi_sigla'];
    $descricao_sistema  = $row['scasi_descricao'];
    $detalhe_sistema    = $row['scasi_detalhe'];
    $imagem_sistema     = $row['scasi_imagem'];


    echo '<div id="inf_empreendimento_t">';
    echo "<br />";
    $click_t = " onclick='return ativa_todos();' ";
    echo "Sr(a).{$nmusu},"."<br />";
    echo "Abaixo estão os dados do Sistema e Ambiente escolhido para solicitar Autorização."."<br />";
    echo "<a href='#' {$click_t} style='cursor:pointer; font-size:18px; font-weight: bold; color:#FFFFFF; text-decoration:none; ' >";
    echo "Verifique os dados e clique em enviar para Solicitar a autorização de Acesso."."<br />";
    echo "</a>";
    echo "<br />";
    echo '</div>';
    
    echo "<table class='tab1' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
    echo "<tr align='center'>";
    echo "<td colspan='4' class='cabtab1'> SISTEMAS SOLICITADO PARA ACESSO</td>";
    echo "</tr>";
    echo "<tr align='left'>";
    echo "<td class='cab1' >&nbsp;&nbsp;</td>";
    echo "<td class='cab1' >&nbsp;&nbsp;SIGLA</td>";
    echo "<td class='cab1' >&nbsp;&nbsp;SISTEMA</td>";
    echo "<td class='cab1' >&nbsp;&nbsp;AMBIENETE</td>";
    echo "</tr>";

    echo "<tr align='left'>";
    echo "<td class='det1' title='{$hint2}' style='width:50px;' >&nbsp;&nbsp;";
    $path_si = $dir_file.'sca_sistema/';
    $arquivo = $path_si.$imagem_sistema;
    //
    $tamimg = 64;
    if (!file_exists($arquivo) or $imagem_sistema=='' )
    {
        $path_si        = 'imagens/';
        $imagem_sistema = 'sistema_padrao.png';
    }
    //
//    ImagemMostrar(25, 25, $path_si, $imagem_sistema, $hint2, false, 'idt="'.$idt_ambiente.'"');
    
      $imgw=$arquivo;
    $imagem = "<img  class='' style='padding-top:14px;' id='{$idt_ambiente}'  width='$tamimg' height='$tamimg' src='$imgw' title='$hint2' />";
    echo  $imagem;

    //
    echo "</td>";
    echo "<td class='det1' title='{$hint2}' style='width:50px;' >$sigla_sistema</td>";
    echo "<td class='det1' title='{$hint2}' style='width:300px;' >$descricao_sistema<br />$detalhe_sistema</td>";
    echo "<td id='linkambiente_{$idt_ambiente}' title='{$hint3}' class='det1 autoriza' autoriza='{$idt_ambiente}' >$descricao_ambiente<br />$detalhe_ambiente</td>";
    echo "</tr>";
    
    $click_t = " onclick =' return enviar_email({$idt});' ";
    echo "<tr align='left'>";
    echo "<td colspan='4' {$click_t} class='tot1' style='background:#FF0000; cursor:pointer;'  >Clique aqui para enviar solicitação da acesso a esse sistema.</td>";
    echo "</tr>";
    
    echo "</table>";

}

echo '</div>';



?>

<script type="text/javascript" >
    $(document).ready(function () {

    });
    function enviar_email(idt)
    {
       alert(' enviar email '+idt);
       return false;
    }
</script>