<?php

if ($acao=='alt')
{
if ($veio=="D")
{

    $retorno = 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_produto_desenvolver&produtocomposto='.produtocomposto.'&id='.$idt_produto;

    echo " <div style=' text-align:center; font-size:16px; background:#0000FF; color:#FFFFFF; border:1px solid #FFFFFF; height:25px; '>";
    echo " <div style='float:left; width:100%;'>";
    echo " Próximas Etapas ";
    echo " </div>";
    $sql  = "select * from grc_produto_situacao ";
    $sql .= " where situacao_etapa='D' ";
    $sql .= " order by codigo";
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $idt               = $row['idt'];
        $codigo            = $row['codigo'];
        $descricao         = $row['descricao'];
        if ($codigo>$codigo_atual)
        {
            echo " <div onclick='return AtivaSituacao({$idt});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
            echo " <img  title='Ativa situação: {$descricao}.' src='imagens/alterar.png' border='0'>  $descricao";
            echo " </div>";
        }
    }
    
    
    //
    // para disponibilizar o produto
    //
    $sql  = "select * from grc_produto_situacao ";
    $sql .= " where situacao_etapa='E' ";
    $sql .= " order by codigo";
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $idt               = $row['idt'];
        $codigo            = $row['codigo'];
        $descricao         = $row['descricao'];
        echo " <div onclick='return AtivaSituacao({$idt});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
        echo " <img  title='Ativa situação: {$descricao}.' src='imagens/alterar.png' border='0'>  $descricao";
        echo " </div>";
        break;
    }
    echo " </div>";

}
else
{
   // echo "Execução ";
    $sql  = "select * from grc_produto_situacao ";
    $sql .= " where situacao_etapa='E' ";
    $sql .= " order by codigo";
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $idt               = $row['idt'];
        $codigo            = $row['codigo'];
        $descricao         = $row['descricao'];
        if ($codigo>$codigo_atual)
        {
            echo " <div onclick='return AtivaSituacao({$idt});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
            echo " <img  title='Ativa situação: {$descricao}.' src='imagens/alterar.png' border='0'>  $descricao";
            echo " </div>";
        }
    }

}

}


?>
<script type="text/javascript">

var retorno     = ' <?php echo $retorno; ?> ';
var idt_produto = ' <?php echo $idt_produto; ?> ';

function AtivaSituacao(idt_situacao)
{
//   alert(' --- '+idt_situacao);
   
   
   var str = '';
    $.post('ajax2.php?tipo=AtivaSituacaoProduto', {
        async: false,
        idt_produto : idt_produto,
        idt_situacao: idt_situacao
    }
    , function (str) {
        if (str == '') {
            alert(' retornei ');
            self.location = retorno;
        } else {
            str = "ERRO "+str;
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });
   return false;
}
</script>