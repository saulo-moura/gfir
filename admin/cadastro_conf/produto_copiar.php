<?php
if ($veio=='D')
{
                $retornofull = 'conteudo.php?prefixo=listar&texto0=&menu=grc_produto_desenvolver&painel_btvoltar_rod=N&produtocomposto='.produtocomposto;

    echo " <div onclick='return AtivaCopiaProduto(0);' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
    echo " <img  title='Ativa Cópia do Produto' src='imagens/copy_32.png' border='0'>  Copiar Produto";
    echo " </div>";
}
else
{
            $retornofull = 'conteudo.php?prefixo=listar&texto0=&menu=grc_produto&painel_btvoltar_rod=N';

    echo " <div onclick='return AtivaCopiaProduto(1);' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
    echo " <img  title='Ativa Cópia do Produto' src='imagens/copy_32.png' border='0'>  Copiar Produto";
    echo " </div>";
}
?>
<script type="text/javascript">

var retornofull = ' <?php echo $retornofull; ?> ';

var idt_produto =  <?php echo $idt_produto; ?> ;

function AtivaCopiaProduto(opc)
{
   // alert(' --- '+idt_produto);
   
   if (opc==1)
   {
       if (!confirm('ATENÇÃO...' + '\n\n' +'ESSE PRODUTO SERÁ COPIADO E COLOCADO EM DESENVOLVIMENTO.' + '\n\n' + 'Confirma?'))
       {
           return false;
       }
   }
   else
   {
       if (!confirm('ATENÇÃO...' + '\n\n' +'ESSE PRODUTO SERÁ COPIADO.' + '\n\n' + 'Confirma?'))
       {
           return false;
       }
   }
    //
    var str = '';
    $.post('ajax2.php?tipo=AtivaCopiaProduto', {
        async: false,
        idt_produto : idt_produto
    }
    , function (str) {
        if (str == '') {
            alert(' Produto Copiado com SUCESSO...');
            self.location = retornofull;

        } else {
            str = "ERRO "+str;
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });
   return false;
}

</script>