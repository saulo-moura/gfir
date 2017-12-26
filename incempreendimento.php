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
        margin-top:10px;
        margin-left:10px;
        width :100%;
        display:none;
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
        sdisplay:none;
        xheight:300px;
        text-align:center;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 14px;
        font-style: normal;
        xfont-weight: bold;

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
        cursor:pointer;
        color:#C00000;
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

<!--[if lt IE 8]>
<style type="text/css">
.box span {
    display: inline-block;
    height: 100%;
}
</style>
<![endif]-->


<?php
/*
echo '<div id="empreendimento_t">';
echo 'Você esta no Gerenciador de Conteúdo do <b>Site sebrae.PIR</b>.<br />Para ter acesso as funcionalidades do Gerenciador de Conteúdo é necessário efetuar outro Login.<br />';
echo 'Clique no botão no menu indicado por uma seta logo depois do "Sair"<br />';
echo 'e informe o Usuário e a Senha.<br />';
echo '</div">';
*/

$Require_Once = "incnoticia_sistema.php";
Require_Once($Require_Once);


/*

//echo '<img id="estado" src="imagens/estado/'.$_GET['estado'].'.jpg" alt="'.$vetEstado[$_GET['estado']].'"/>';
$_SESSION[CS]['g_imagem_logo_obra'] = '';
$nmusu = $_SESSION[CS]['g_nome_completo'];
// lista de todos os sistemas disponíveis


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
//$sql .= ' where uem.id_usuario = '.null($_SESSION[CS]['g_id_usuario']);
$sql .= ' where ';
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




$scasi_descricao_ant = "##";
foreach ($rs->data as $row) {
    if ($Vet_obra[$row['em_idt']] == '') {
    //    continue;
    }
    if ($pri == 0) {
        $pri = 1;
        echo '<div id="empreendimento_t">';


        echo "<table class='tab1' width='95%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
        echo "<tr align='center'>";
        echo "<td colspan='4' class='cabtab1'> SISTEMAS DA OAS EMPREENDIMENTOS</td>";
        echo "</tr>";
        echo "<tr align='left'>";
        echo "<td class='cab1' >&nbsp;&nbsp;</td>";
        echo "<td class='cab1' >&nbsp;&nbsp;SIGLA</td>";
        echo "<td class='cab1' >&nbsp;&nbsp;SISTEMA</td>";
        echo "<td class='cab1' >&nbsp;&nbsp;AMBIENTE</td>";
        echo "</tr>";
    }
    echo '<div class="empreendimento_li">';
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

    $hint = $sigla_sistema." - ".$descricao_sistema."\n"."Ambiente: ".$descricao_ambiente."\n".$detalhe_sistema;

    $hint2 = $detalhe_sistema;
    $hint3 = $detalhe_ambiente;
    //ImagemMostrar(100, 100, $path, $imagem_ambiente, $hint, false, 'idt="'.$idt_ambiente.'"');

    //  ImagemMostrar(100, 100, $path, $imagem_ambiente, $hint, false, 'chama="'.$chama_ambiente.'"');


    if ($scasi_descricao_ant!=$descricao_sistema)
    {
        echo "<tr align='left'>";
        if ($scasi_descricao_ant!='##')
        {
            echo "<td colspan='4' class='sep1'>&nbsp;</td>";
            echo "</tr>";
            echo "<tr align='left'>";
        }
        //
        echo "<td class='det1' title='{$hint2}' style='width:50px;' >&nbsp;&nbsp;";
        $arquivo = $path_si.$imagem_sistema;
        //
        if (!file_exists($arquivo) or $imagem_sistema=='' )
        {
            $path_si        = 'imagens/';
            $imagem_sistema = 'sistema_padrao.png';
        }
        //
        ImagemMostrar(25, 25, $path_si, $imagem_sistema, $hint2, false, 'idt="'.$idt_ambiente.'"');
        //
        echo "</td>";
        echo "<td class='det1' title='{$hint2}' style='width:50px;' >&nbsp;&nbsp;$sigla_sistema</td>";
        echo "<td class='det1' title='{$hint2}' style='width:300px;' >&nbsp;&nbsp;$descricao_sistema</td>";
        $scasi_descricao_ant = $descricao_sistema;
        $qtdsist = $qtdsist+1;
    }
    else
    {
        echo "<td colspan='3' class='det1'>&nbsp;</td>";
    }
    $qtdambientes = $qtdambientes+1;
    echo "<td id='linkambiente_{$idt_ambiente}' title='{$hint3}' class='det1 autoriza' autoriza='{$idt_ambiente}' >&nbsp;&nbsp;$descricao_ambiente</td>";
    echo "</tr>";
    echo '</div>';
}

if ($pri == 0) {
    echo '<div id="sem_empreendimento">';
    echo "<br /><br /><br />";
    echo "Sr(a).{$nmusu},"."<br /><br />";
    echo "Para ter acesso a Sistemas é necessário prévia autorização dos Responsáveis."."<br /><br />";
    echo "<a href='#' style='cursor:pointer; font-size:18px; font-weight: bold; color:#C0C0C0; text-decoration:none; ' >";
    echo "Clique aqui se deseja obter direito de acesso a Sistemas da oas empreendimentos."."<br /><br />";
    echo "</a>";
    echo "<br /><br />";
}
else
{
    echo "<tr align='left'>";
    echo "<td colspan='4' class='tot1' style='background:#FF0000;'  >Total de {$qtdsist} sistema(s) e {$qtdambientes} ambientes</td>";
    echo "</tr>";

    echo "</table>";
}
echo '</div>';



//////////////////////////////////////////// LISTA DOS SISTEMAS DO USUÁRIO
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
$sql .= ' where uem.id_usuario = '.null($_SESSION[CS]['g_id_usuario']);
$sql .= '   and em.ativo = '.aspa('S');
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

$scasi_descricao_ant = "##";
foreach ($rs->data as $row) {
    if ($Vet_obra[$row['em_idt']] == '') {
        continue;
    }
    if ($pri == 0) {
        $pri = 1;
        echo '<div id="empreendimento">';
        $click_t=" onclick='return ativa_todos();' ";
        echo '<div id="inf_empreendimento">';
        echo "<br />";
        echo "Sr(a).{$nmusu},"."<br />";
        echo "Abaixo estão listados os Sistemas e Ambientes que atualmente voce tem autorização para acesso."."<br />";
        echo "<a href='#' {$click_t} style='cursor:pointer; font-size:18px; font-weight: bold; color:#666666; text-decoration:none; ' >";
        echo "Clique aqui se desejar obter direito de acesso a outros Sistemas da oas empreendimentos."."<br />";
        echo "</a>";
        echo "<br />";
        echo '</div>';


        echo "<table class='tab1' width='95%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";

        echo "<tr align='center'>";
        echo "<td colspan='4' class='cabtab1'> SISTEMAS QUE O USUÁRIO TEM ACESSO </td>";
        echo "</tr>";


        echo "<tr align='left'>";
        echo "<td class='cab1' >&nbsp;&nbsp;</td>";
        echo "<td class='cab1' >&nbsp;&nbsp;SIGLA</td>";
        echo "<td class='cab1' >&nbsp;&nbsp;SISTEMA</td>";
        echo "<td class='cab1' >&nbsp;&nbsp;AMBIENTE</td>";
        echo "</tr>";
    }
    echo '<div class="empreendimento_li">';
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

    $hint = $sigla_sistema." - ".$descricao_sistema."\n"."Ambiente: ".$descricao_ambiente."\n".$detalhe_sistema;

    $hint2 = $detalhe_sistema;
    $hint3 = $detalhe_ambiente;
    //ImagemMostrar(100, 100, $path, $imagem_ambiente, $hint, false, 'idt="'.$idt_ambiente.'"');

    //  ImagemMostrar(100, 100, $path, $imagem_ambiente, $hint, false, 'chama="'.$chama_ambiente.'"');


    if ($scasi_descricao_ant!=$descricao_sistema)
    {
        echo "<tr align='left'>";
        if ($scasi_descricao_ant!='##')
        {
            echo "<td colspan='4' class='sep1'>&nbsp;</td>";
            echo "</tr>";
            echo "<tr align='left'>";
        }
        //
        echo "<td class='det1' title='{$hint2}' style='width:50px;' >&nbsp;&nbsp;";
        $arquivo = $path_si.$imagem_sistema;
        //
        if (!file_exists($arquivo) or $imagem_sistema=='' )
        {
            $path_si        = 'imagens/';
            $imagem_sistema = 'sistema_padrao.png';
        }
        //
        ImagemMostrar(25, 25, $path_si, $imagem_sistema, $hint2, false, 'idt="'.$idt_ambiente.'"');
        //
        echo "</td>";
        echo "<td class='det1' title='{$hint2}' style='width:50px;' >&nbsp;&nbsp;$sigla_sistema</td>";
        echo "<td class='det1' title='{$hint2}' style='width:300px;' >&nbsp;&nbsp;$descricao_sistema</td>";
        $scasi_descricao_ant = $descricao_sistema;
        $qtdsist = $qtdsist+1;
    }
    else
    {
        echo "<td colspan='3' class='det1'>&nbsp;</td>";
    }
    $qtdambientes = $qtdambientes+1;
    echo "<td id='linkambiente_{$idt_ambiente}' title='{$hint3}' class='det1 chama' chama='{$chama_ambiente}' >&nbsp;&nbsp;$descricao_ambiente</td>";
    echo "</tr>";
    echo '</div>';
}

if ($pri == 0) {
    echo '<div id="sem_empreendimento">';
    echo "<br /><br /><br />";
    echo "Sr(a).{$nmusu},"."<br /><br />";
    echo "Para ter acesso a Sistemas é necessário prévia autorização dos Responsáveis."."<br /><br />";
    echo "<a href='#' style='cursor:pointer; font-size:18px; font-weight: bold; color:#C0C0C0; text-decoration:none; ' >";
    echo "Clique aqui se deseja obter direito de acesso a Sistemas da oas empreendimentos."."<br /><br />";
    echo "</a>";
    echo "<br /><br />";
}
else
{
    echo "<tr align='left'>";
    echo "<td colspan='4' class='tot1' >Direito de acesso a {$qtdsist} sistema(s) e {$qtdambientes} ambientes</td>";
    echo "</tr>";

    echo "</table>";
}
echo '</div>';
*/
?>


<script type="text/javascript" >
    var nametel = 0;
    $(document).ready(function () {

        var timer_obra=null;
      //  $('div#empreendimento img').click(function() {

        $('.chama').click(function() {
            //alert('conteudo.php?prefixo=inc&menu=homeobra&idt=' + $(this).attr('idt'))


            // FuncObra_painel2($(this).attr('idt'));



            //   var idt =  $(this).attr('idt');

            //   alert('teste posiciona obra '+idt) ;

            // esperar loop para delay....
            var delay=1; // 500 milissegundos;
            sleep(delay);

            // self.location = 'conteudo.php?prefixo=inc&menu=homeobra&obra_escolhida=S&idt=' + $(this).attr('idt');

            var lnk = $(this).attr('chama');

            var  left   = 0;
            var  top    = 0;
            //var  height = $(window).height();
            //var  width  = $(window).width();

            //var  height = window.outerHeight;
            //var  width  = window.outerWidth;

            var  width  = screen.availWidth;
            var  height = screen.availHeight;
//
//window.
            //excluir_pg_bloco =  window.open(lnk,"PgPo","left="+left+",top="+top+",width="+width+",height="+height+",resizable=yes,menubar=no,scrollbars=yes,toolbar=no");
            nametel = nametel + 1;
            var nmjan = 'sist'+nametel;
            janelasist =  window.open(lnk,nmjan,"left="+left+",top="+top+",width="+width+",height="+height+",resizable=yes,menubar=no,scrollbars=yes,toolbar=no");
            janelasist.focus();

          //  excluir_pg_bloco =  window.open(lnk,"PgPo","left="+left+",top="+top+",width="+width+",height="+height+",resizable=yes,menubar=no,scrollbars=yes,toolbar=no");
          //  excluir_pg_bloco.focus();
            //excluir_pg_bloco.moveTo(0,0);
            //excluir_pg_bloco.top.window.resizeTo(screen.availWidth, screen.availHeight);

            //   var delay=500; // 500 milissegundos;

            //   alert('teste posiciona obra 1...2 '+idt) ;

            //   clearTimeout(timer_obra);

            //   alert('teste posiciona obra 2 '+idt) ;

            //   setTimeout("menu_sistema_nada(1,'"+elemento+"')",ktimeoutw);
            //   setTimeout("chama_conteudo('"+idt+"')" ,delay);

            //   alert('teste posiciona obra 3 '+idt) ;

            return false;
        });







        $('.autoriza').click(function() {
            var delay=1; // 500 milissegundos;
            sleep(delay);
            var idt = $(this).attr('autoriza');
            var  left   = (screen.availWidth/2)-350;
            var  top    = (screen.availHeight/2)-200;
          //  var  width  = screen.availWidth;
          //  var  height = screen.availHeight;

            var  width  = 700;
            var  height = 400;


            nametel = nametel + 1;
            var nmjan = 'sist'+nametel;
            var lnk = "conteudo_email.php?idt="+idt;
            janelasist =  window.open(lnk,nmjan,"left="+left+",top="+top+",width="+width+",height="+height+",resizable=yes,menubar=no,scrollbars=yes,toolbar=no");
            janelasist.focus();
            return false;
        });






















    });


    function ativa_todos()
    {
       var id='empreendimento';
       $('#'+id).toggle();
       var id='empreendimento_t';
       $('#'+id).toggle();
       return false;
    }

    function chama_conteudo(idt)
    {
        alert('teste posiciona obra  4 '+idt) ;
        self.location = 'conteudo.php?prefixo=inc&menu=homeobra&obra_escolhida=S&idt=' + idt ;
    }

    function FuncObra_painel2(idt)
    {

        var nome=' guy sem efeito ';
        var idt_empreendimento=idt;
        var nm_empreendimento=nome;
        //  alert('teste xxx '+idt+ '    '+idt_empreendimento) ;

        var str='';

        $.post('ajax.php?tipo=obra',{
            async    : false,
            idt_obra : idt_empreendimento,
            nm_obra  : nm_empreendimento
        }
        , function(str) {
            if (str == '') {

                //alert('Obra Posicionada em '+nm_empreendimento);

                self.location = 'conteudo.php';

            } else {
                alert(url_decode(str).replace(/<br>/gi, "\n"));
            }
        });
    }




</script>