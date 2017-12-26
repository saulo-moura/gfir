<?php
if ($acao == 'alt') {
    if ($veio == "D") {
        if ($codigo_atual != "20" or $direito_geral == 1) { // Não aprovado
            $retorno = 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_produto_desenvolver&produtocomposto='.produtocomposto.'&id='.$idt_produto;
            $retornofull = 'conteudo.php?prefixo=listar&texto0=&menu=grc_produto_desenvolver&painel_btvoltar_rod=N&produtocomposto='.produtocomposto;

            echo " <div style=' text-align:center; font-size:16px; background:#0000FF; color:#FFFFFF; border:1px solid #FFFFFF; height:25px; '>";
            echo " <div style='float:left; width:100%;'>";
            echo " Próximas Etapas ";
            echo " </div>";
            $sql = "select * from grc_produto_situacao ";
            $sql .= " where situacao_etapa='D' ";
            $sql .= " order by codigo";
            $rs = execsql($sql);
            ForEach ($rs->data as $row) {
                $idt = $row['idt'];
                $codigo = $row['codigo'];
                $descricao = $row['descricao'];
                if ($codigo > $codigo_atual or $direito_geral == 1) {
                    echo " <div onclick='return AtivaSituacao({$idt});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
                    echo " <img  title='Ativa situação: {$descricao}.' src='imagens/alterar.png' border='0'>  $descricao";
                    echo " </div>";
                }
            }
            //
            if ($codigo_atual == "02" or $direito_geral == 1) { // Projeto
                //
                // para disponibilizar o produto
                //
                $sql = "select * from grc_produto_situacao ";
                $sql .= " where situacao_etapa='E' ";
                $sql .= " order by codigo";
                $rs = execsql($sql);
                ForEach ($rs->data as $row) {
                    $idt = $row['idt'];
                    $codigo = $row['codigo'];
                    $descricao = $row['descricao'];
                    echo " <div onclick='return AtivaSituacaoExecucao({$idt});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
                    echo " <img  title='Ativa situação: {$descricao}.' src='imagens/alterar.png' border='0'>  $descricao";
                    echo " </div>";
                    break;
                }
            }
            echo " </div>";
        } else {
            echo " <div style=' text-align:center; font-size:16px; background:#0000FF; color:#FFFFFF; border:1px solid #FFFFFF; height:25px; '>";
            echo " <div style='float:left; width:100%;'>";
            echo " PRODUTO NÃO APROVADO PARA UTILIZAÇÃO ";
            echo " </div>";
            echo " </div>";
        }
    } else {
        // echo "Execução ";

        $retorno = 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_produto&id='.$idt_produto;
        $retornofull = 'conteudo.php?prefixo=listar&texto0=&menu=grc_produto&painel_btvoltar_rod=N';




        $sql = "select * from grc_produto_situacao ";
        $sql .= " where situacao_etapa='E' ";
        $sql .= " order by codigo";
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $idt = $row['idt'];
            $codigo = $row['codigo'];
            $descricao = $row['descricao'];
            if ($codigo > $codigo_atual or $direito_geral == 1) {
                echo " <div onclick='return AtivaSituacao({$idt});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
                echo " <img  title='Ativa situação: {$descricao}.' src='imagens/alterar.png' border='0'>  $descricao";
                echo " </div>";
            }
        }
    }
}
if ($acao == 'con') {
    if ($veio == "D") {
        if ($codigo_atual == "20") { // Não aprovado
            echo " <div style=' width:100%; margin-top:10px; text-align:center; font-size:16px; background:#FF0000; color:#FFFFFF; border:1px solid #FFFFFF; height:25px; '>";
            echo " <div style='float:left; width:100%;'>";
            echo " PRODUTO NÃO APROVADO PARA UTILIZAÇÃO ";
            echo " </div>";
            echo " </div>";
        }
    } else {
        if ($codigo_atual == "40") { // Ativo para o SEBRAE-BA -
            if ($_SESSION[CS]['alt_status_produto'] == 'S') {
                $sql = "select * from grc_produto_situacao ";
                $sql .= " where codigo='50' ";
                $sql .= " order by codigo";
                $rs = execsql($sql);
                ForEach ($rs->data as $row) {
                    $idt = $row['idt'];
                    $codigo = $row['codigo'];
                    $descricao = $row['descricao'];

                    echo " <div onclick='return AtivaSituacao({$idt});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
                    echo " <img  title='Ativa situação: {$descricao}.' src='imagens/alterar.png' border='0'>  $descricao";
                    echo " </div>";
                }
            } else {
                echo " <div style=' width:100%; margin-top:10px; text-align:center; font-size:16px; background:#0000FF; color:#FFFFFF; border:1px solid #FFFFFF; height:25px; '>";
                echo " <div style='float:left; width:100%;'>";
                echo " PRODUTO DISPONIBILIZADO PARA EVENTOS ";
                echo " </div>";
                echo " </div>";
            }
        }

        if ($codigo_atual == "50") { // Descontinuado
            if ($_SESSION[CS]['alt_status_produto'] == 'S') {
                $sql = "select * from grc_produto_situacao ";
                $sql .= " where codigo='40' ";
                $sql .= " order by codigo";
                $rs = execsql($sql);
                ForEach ($rs->data as $row) {
                    $idt = $row['idt'];
                    $codigo = $row['codigo'];
                    $descricao = $row['descricao'];

                    echo " <div onclick='return AtivaSituacao({$idt});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
                    echo " <img  title='Ativa situação: {$descricao}.' src='imagens/alterar.png' border='0'>  $descricao";
                    echo " </div>";
                }
            } else {
                echo " <div style=' width:100%; margin-top:10px; text-align:center; font-size:16px; background:#FF0000; color:#FFFFFF; border:1px solid #FFFFFF; height:25px; '>";
                echo " <div style='float:left; width:100%;'>";
                echo " PRODUTO DESCONTINUADO PARA EVENTOS ";
                echo " </div>";
                echo " </div>";
            }
        }
    }
}
?>
<script type="text/javascript">

    var retorno = ' <?php echo $retorno; ?> ';
    var retornofull = ' <?php echo $retornofull; ?> ';
    var idt_produto = <?php echo $idt_produto; ?>;

    function AtivaSituacao(idt_situacao)
    {
        // alert(' --- '+idt_produto+' ---- sit '+idt_situacao);

        if (!confirm('Deseja alterar a situação do Produto!' + '\n\n' + 'Confirma?'))
        {
            return false;
        }

        var str = '';
        $.post('ajax2.php?tipo=AtivaSituacaoProduto', {
            async: false,
            idt_produto: idt_produto,
            idt_situacao: idt_situacao
        }
        , function (str) {
            if (str == '') {
                //alert(' retornei ');
                self.location = retorno;
            } else {
                str = "ERRO " + str;
                alert(url_decode(str).replace(/<br>/gi, "\n"));
            }
        });
        return false;
    }


    function AtivaSituacaoExecucao(idt_situacao)
    {
        // alert(' --- '+idt_produto+' ---- sit '+idt_situacao);

        if (!confirm('A APROVAÇÃO fará com que o produto seja colocado em disponibilidade para Utilização ' + '\n\n' + 'Confirma?'))
        {
            return false;
        }

        var str = '';
        $.post('ajax2.php?tipo=AtivaSituacaoProduto', {
            async: false,
            idt_produto: idt_produto,
            idt_situacao: idt_situacao
        }
        , function (str) {
            if (str == '') {
                alert('PRODUTO APROVADO COM SUCESSO...');
                self.location = retornofull;
            } else {
                str = "ERRO " + str;
                alert(url_decode(str).replace(/<br>/gi, "\n"));
            }
        });
        return false;
    }
</script>