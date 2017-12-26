
<style type="text/css">


   div#botao_importar {
       sdisplay:none;
       background:#FFFFFF;
       cursor: pointer;
       font-family: Calibri, Arial, Helvetica, sans-serif;
       font-size: 16px;
       color: #900000;
       font-weight: bold;
       swidth:50px;

   }

</style>





<?php
    //  $kveiow
    //  $acao
    //  $idt_sa
    //  $idt_tecnico
    //  $idt_solicitado
echo "<div id='botao_importar'> ";

    $paw="kveiow=E1___acao=inc___idt_sa={$idt_sa}___idt_tecnico={$idt_tecnico}___idt_solicitado={$idt_solicitado}___idt_asa={$idt_asa}";
    $url = 'conteudo_popup.php?prefixo=inc&menu=cat&acao=inc&id='.$idt_sa.'&arqrcat='.$arqrcatw.'&parcad='.$paw;
    // $titulo_tela=$vetMenu['anexo_sa'];
    $titulo_tela="Importar CAT do INSS para QSMSRS da oas empreendimentos";
   // echo '<a><img src="imagens/inss_cat.jpg" alt="Importar CAT do INSS para QSMSRS da oas empreendimentos" title="Importar CAT do INSS para QSMSRS da oas empreendimentos"  border="0"  onClick='."\"showPopWin('$url', '".$titulo_tela."', 750, 500, null);\"".' style="cursor: pointer;"><br>Importar CAT</a>';
 
    echo '<a><img src="imagens/inss_cat.jpg" alt="Importar CAT do INSS para QSMSRS da oas empreendimentos" title="Importar CAT do INSS para QSMSRS da oas empreendimentos"  border="0"  onClick="mostra_arquivo_cat();" style="cursor: pointer;">&nbsp;&nbsp;&nbsp;&nbsp;Importar CAT</a>';
    
echo "</div> ";

    
?>

<script type="text/javascript">
function  mostra_arquivo_cat()
{
   // alert('vivo');

    var acaow      = '<?php echo $acao ?>';
    var idt_catw   = <?php echo $idt_catw ?>;
    var arqrcatw   = '<?php echo $arqrcatw ?>';
    var $cat_htmlw = '<?php echo $cat_htmlw ?>';
    var vaziow = '<?php echo $vaziow ?>';
    var idt_empreendimentow   = <?php echo $idt_empreendimento ?>;

  //  alert('vivo 1');
    var  left   = 150;
    var  top    = 0;
    var  height = $(window).height()+100;
  //  var  width  = $(window).width();
    
    var  width  = 750;
    
    //  self.location = 'conteudo.php?prefixo=listar&menu=st_acidente&class=0&acao=alt&idt0='+idt_empreendimentow+'&id='+idt_catw;


    var link_cat='conteudo_print_cat.php?prefixo=inc&menu=cat&acao='+acaow+'&idt_empreendimento='+idt_empreendimentow+'&id='+idt_catw+'&arqrcat='+arqrcatw+'&vazio='+vaziow+'&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S';
    catw =  window.open(link_cat,"cat","left="+left+",top="+top+",width="+width+",height="+height+",resizable=yes,menubar=no,scrollbars=yes,toolbar=no");
    catw.focus();


    // var link_cat='conteudo.php?prefixo=inc&menu=cat&acao='+acaow+'&idt_empreendimento='+idt_empreendimentow+'&id='+idt_catw+'&arqrcat='+arqrcatw+'&vazio='+vaziow+'&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S';
    // self.location = link_cat;

    return false;
}
</script>
