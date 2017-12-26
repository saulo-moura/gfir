
<style type="text/css">


    .cb_texto_tit {
        background:#0080C0;
        color:#FFFFFF;
        font-size:20px;
        text-align:left;
        padding-left:10px;

    }
    .cb_texto_cab {
        background:#0000FF;
        color:#FFFFFF;
        font-size:18px;
    }

    .cb_texto_cab1 {
        padding-left:10px;
    }
    .cb_texto_int_cab {
        background:#0000FF;
        color:#FFFFFF;
        font-size:14px;
        text-align:right;
        padding-right:20px;

    }

    .cb_texto_linha_par {
        background:#FFFFFF;
        font-size:12px;
    }
    .cb_texto_linha_imp {
        background:#F1F1F1;
        font-size:12px;
    }

    .cb_texto {
        color:#000000; text-align:left;
        padding-left:10px;

    }
    .cb_inteiro {
        color:#000000;
        text-align:right;
        padding-right:20px;
    }

    .cb_perc {
        color:#000000;
        text-align:right;
        padding-right:20px;
    }

    .total_g {
        background:#0080FF;
        color:#FFFFFF;
    }
    .semclassificar {
        background:#FF0000;
        color:#FFFFFF;
    }

</style>


<?php

function CriarDimensoesProduto(&$vetDimensao) {
    $kokw = 0;
    $vetPrograma = Array();
    $vetFamilia = Array();
    $vetInstrumento = Array();
    $vetUnidadeResponsavel = Array();
    $vetSituacao = Array();
    $vetDimensao = Array();
    // Programa
    $sqll = 'select ';
    $sqll .= '  gec_p.* ';
    $sqll .= '  from  '.db_pir_gec.'gec_programa gec_p ';
    $sqll .= '  order by codigo ';
    $rsl = execsql($sqll);
    ForEach ($rsl->data as $rowl) {
        $idt = $rowl['idt'];
        $codigo = $rowl['codigo'];
        $descricao = $rowl['descricao'];
        $ativo = $rowl['ativo'];
        $vetPrograma[$idt] = $rowl;
    }
    // Família
    $sqll = 'select ';
    $sqll .= '  grc_pf.* ';
    $sqll .= '  from  grc_produto_familia grc_pf ';
    $sqll .= '  order by codigo ';
    $rsl = execsql($sqll);
    ForEach ($rsl->data as $rowl) {
        $idt = $rowl['idt'];
        $codigo = $rowl['codigo'];
        $descricao = $rowl['descricao'];
        $ativo = $rowl['ativo'];
        $vetFamilia[$idt] = $rowl;
    }
    //Instrumento
    $sqll = 'select ';
    $sqll .= '  grc_i.* ';
    $sqll .= '  from  grc_atendimento_instrumento grc_i ';
    $sqll .= " where nivel = 1";
    $sqll .= '  order by codigo ';
    $rsl = execsql($sqll);
    ForEach ($rsl->data as $rowl) {
        $idt = $rowl['idt'];
        $codigo = $rowl['codigo'];
        $descricao = $rowl['descricao'];
        $ativo = $rowl['ativo'];
        $vetInstrumento[$idt] = $rowl;
    }
    // Unidade Responsável
    $sqll = 'select ';
    $sqll .= '  distinct ';
    $sqll .= '  sca_os.idt, ';
    $sqll .= '  sca_os.descricao as descricao ';
    $sqll .= '  from  grc_produto grc_p ';
    $sqll .= '  inner join '.db_pir.'sca_organizacao_secao sca_os on sca_os.idt = grc_p.idt_secao_responsavel  ';
    $sqll .= '  order by grc_p.codigo ';
    $rsl = execsql($sqll);
    ForEach ($rsl->data as $rowl) {
        $idt = $rowl['idt'];
        $descricao = $rowl['descricao'];
        $vetUnidadeResponsavel[$idt] = $rowl;
    }

    //Situação
    $sqll = 'select ';
    $sqll .= '  grc_ps.* ';
    $sqll .= '  from  grc_produto_situacao grc_ps ';
    $sqll .= '  order by codigo ';
    $rsl = execsql($sqll);
    ForEach ($rsl->data as $rowl) {
        $idt = $rowl['idt'];
        $codigo = $rowl['codigo'];
        $descricao = $rowl['descricao'];
        $ativo = $rowl['ativo'];
        $vetSituacao[$idt] = $rowl;
    }








    $vetDimensao['Programa'] = $vetPrograma;
    $vetDimensao['Familia'] = $vetFamilia;
    $vetDimensao['Instrumento'] = $vetInstrumento;
    $vetDimensao['UnidadeResponsavel'] = $vetUnidadeResponsavel;
    $vetDimensao['Situacao'] = $vetSituacao;


    return $kokw;
}

function QuantitativosDimensao($idt_dimensao, $condicao, &$vetDimensao) {
    $condicao = " ativo='S'   ";
    $vetDimensao = Array();
    $sql = "select ";
    $sql .= "   count(idt) as quantidade, $idt_dimensao ";
    $sql .= " from grc_produto ";
    if ($condicao != "") {
        $sql .= "  where $condicao ";
    }
    $sql .= "  group by $idt_dimensao   ";

    $rsl = execsql($sql);
    $total = 0;
    ForEach ($rsl->data as $rowl) {
        $idt = $rowl[$idt_dimensao];
        $quantidade = $rowl['quantidade'];
        $vetDimensao[$idt] = $quantidade;
        $total = $total + $quantidade;
    }
    $vetDimensao['Total'] = $total;
}

$cargo = $_GET['cargo'];
$idt_organizacao = $_GET['idt_organizacao'];
$descricao_cargo = "";
$vetPrograma = Array();
$vetFamilia = Array();
$vetInstrumento = Array();
$vetUnidadeResponsavel = Array();
$vetDimensao = Array();
$ret = CriarDimensoesProduto($vetDimensao);
$vetPrograma = $vetDimensao['Programa'];
$vetFamilia = $vetDimensao['Familia'];
$vetInstrumento = $vetDimensao['Instrumento'];
$vetUnidadeResponsavel = $vetDimensao['UnidadeResponsavel'];
$vetSituacao = $vetDimensao['Situacao'];
/*
  p($vetPrograma);
  p($vetFamilia);
  p($vetInstrumento);
  p($vetUnidadeResponsavel);
 */
//
// PROGRAMA
//
$vetProgramaQtd = Array();
$idt_dimensao = 'idt_instrumento';
$vetDimensao = Array();
$condicao = ""; // todos os produtos
QuantitativosDimensao($idt_dimensao, $condicao, $vetDimensao);
$vetProgramaQtd = $vetDimensao;
echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td colspan='4' class='cb_texto_tit' style='' >PROGRAMA</td> ";
echo "</tr>";
echo "<tr class=''>  ";
echo "   <td class='cb_texto_cab cb_texto_cab1' style='width:20%'>Instrumento</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:5%'>Quantidade</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:5%'>Percenual %</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:70%'>&nbsp;</span></td> ";
echo "</tr>";
$totalgeral = $vetProgramaQtd['Total'];
$i = 0;
ForEach ($vetPrograma as $idt => $row) {
    $i = $i + 1;
    $classw = ($i % 2) == 0 ? 'cb_texto_linha_imp' : 'cb_texto_linha_par';
    echo "<tr class=''>  ";
    $quantidade = format_decimal($vetProgramaQtd[$idt], 0);
    echo "   <td class='cb_texto {$classw}' style='' >{$row['descricao']}</td> ";
    echo "   <td class='cb_inteiro {$classw}' style='' >$quantidade</td> ";
    $perc = ($vetProgramaQtd[$idt] / $totalgeral) * 100;
    $percw = format_decimal($perc, 2).' %';
    echo "   <td class='cb_perc {$classw}' style='' >$percw</td> ";
    echo "   <td class='cb_texto {$classw}' style='' >&nbsp;</td> ";

    echo "</tr>";
}
echo "<tr class=''>  ";
$quantidade = format_decimal($vetProgramaQtd[''], 0);
echo "   <td class='cb_texto semclassificar' style='' >SEM INFORMAÇÃO</td> ";
echo "   <td class='cb_inteiro semclassificar' style='' >$quantidade</td> ";
$perc = ($vetProgramaQtd[''] / $totalgeral) * 100;
$percw = format_decimal($perc, 2).' %';
echo "   <td class='cb_perc semclassificar' style='' >&nbsp;$percw</td> ";
echo "   <td class='cb_texto' ' style='' >&nbsp;</td> ";
echo "</tr>";
echo "<tr class=''>  ";
$quantidade = format_decimal($vetProgramaQtd['Total'], 0);
echo "   <td class='cb_texto total_g' style='' >TOTAL</td> ";
echo "   <td class='cb_inteiro total_g' style='' >$quantidade</td> ";
$perc = ($totalgeral / $totalgeral) * 100;
$percw = format_decimal($perc, 2).' %';
echo "   <td class='cb_perc total_g' style='' >$percw</td> ";
echo "   <td class='cb_texto' ' style='' >&nbsp;</td> ";
echo "</tr>";
echo "</table>";

//
// FAMILIA
//
$vetFamiliaQtd = Array();
$idt_dimensao = 'idt_produto_familia';
$vetDimensao = Array();
$condicao = ""; // todos os produtos
QuantitativosDimensao($idt_dimensao, $condicao, $vetDimensao);
$vetFamiliaQtd = $vetDimensao;
echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td colspan='4' class='cb_texto_tit' style='' >FAMILIA DE PRODUTOS</td> ";
echo "</tr>";
echo "<tr class=''>  ";
echo "   <td class='cb_texto_cab cb_texto_cab1' style='width:20%'>Família</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:5%'>Quantidade</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:5%'>Percenual %</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:70%'>&nbsp;</span></td> ";
echo "</tr>";
$totalgeral = $vetFamiliaQtd['Total'];
$i = 0;
ForEach ($vetFamilia as $idt => $row) {
    $i = $i + 1;
    $classw = ($i % 2) == 0 ? 'cb_texto_linha_imp' : 'cb_texto_linha_par';
    echo "<tr class=''>  ";
    $quantidade = format_decimal($vetFamiliaQtd[$idt], 0);
    echo "   <td class='cb_texto {$classw}' style='' >{$row['descricao']}</td> ";
    echo "   <td class='cb_inteiro {$classw}' style='' >$quantidade</td> ";
    $perc = ($vetFamiliaQtd[$idt] / $totalgeral) * 100;
    $percw = format_decimal($perc, 2).' %';
    echo "   <td class='cb_perc {$classw}' style='' >$percw</td> ";
    echo "   <td class='cb_texto {$classw}' style='' >&nbsp;</td> ";

    echo "</tr>";
}
echo "<tr class=''>  ";
$quantidade = format_decimal($vetFamiliaQtd[''], 0);
echo "   <td class='cb_texto semclassificar' style='' >SEM INFORMAÇÃO</td> ";
echo "   <td class='cb_inteiro semclassificar' style='' >$quantidade</td> ";
$perc = ($vetFamiliaQtd[''] / $totalgeral) * 100;
$percw = format_decimal($perc, 2).' %';
echo "   <td class='cb_perc semclassificar' style='' >&nbsp;$percw</td> ";
echo "   <td class='cb_texto' ' style='' >&nbsp;</td> ";
echo "</tr>";
echo "<tr class=''>  ";
$quantidade = format_decimal($vetFamiliaQtd['Total'], 0);
echo "   <td class='cb_texto total_g' style='' >TOTAL</td> ";
echo "   <td class='cb_inteiro total_g' style='' >$quantidade</td> ";
$perc = ($totalgeral / $totalgeral) * 100;
$percw = format_decimal($perc, 2).' %';
echo "   <td class='cb_perc total_g' style='' >$percw</td> ";
echo "   <td class='cb_texto' ' style='' >&nbsp;</td> ";
echo "</tr>";
echo "</table>";
//
// INSTRUMENTO
//
$vetInstrumentoQtd = Array();
$idt_dimensao = 'idt_instrumento';
$vetDimensao = Array();
$condicao = ""; // todos os produtos
QuantitativosDimensao($idt_dimensao, $condicao, $vetDimensao);
$vetInstrumentoQtd = $vetDimensao;
echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td colspan='4' class='cb_texto_tit' style='' >INSTRUMENTO</td> ";
echo "</tr>";
echo "<tr class=''>  ";
echo "   <td class='cb_texto_cab cb_texto_cab1' style='width:20%'>Instrumento</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:5%'>Quantidade</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:5%'>Percenual %</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:70%'>&nbsp;</span></td> ";
echo "</tr>";
$totalgeral = $vetInstrumentoQtd['Total'];
$i = 0;
ForEach ($vetInstrumento as $idt => $row) {
    $i = $i + 1;
    $classw = ($i % 2) == 0 ? 'cb_texto_linha_imp' : 'cb_texto_linha_par';
    echo "<tr class=''>  ";
    $quantidade = format_decimal($vetInstrumentoQtd[$idt], 0);
    echo "   <td class='cb_texto {$classw}' style='' >{$row['descricao']}</td> ";
    echo "   <td class='cb_inteiro {$classw}' style='' >$quantidade</td> ";
    $perc = ($vetInstrumentoQtd[$idt] / $totalgeral) * 100;
    $percw = format_decimal($perc, 2).' %';
    echo "   <td class='cb_perc {$classw}' style='' >$percw</td> ";
    echo "   <td class='cb_texto {$classw}' style='' >&nbsp;</td> ";

    echo "</tr>";
}
echo "<tr class=''>  ";
$quantidade = format_decimal($vetInstrumentoQtd[''], 0);
echo "   <td class='cb_texto semclassificar' style='' >SEM INFORMAÇÃO</td> ";
echo "   <td class='cb_inteiro semclassificar' style='' >$quantidade</td> ";
$perc = ($vetInstrumentoQtd[''] / $totalgeral) * 100;
$percw = format_decimal($perc, 2).' %';
echo "   <td class='cb_perc semclassificar' style='' >&nbsp;$percw</td> ";
echo "   <td class='cb_texto' ' style='' >&nbsp;</td> ";
echo "</tr>";
echo "<tr class=''>  ";
$quantidade = format_decimal($vetInstrumentoQtd['Total'], 0);
echo "   <td class='cb_texto total_g' style='' >TOTAL</td> ";
echo "   <td class='cb_inteiro total_g' style='' >$quantidade</td> ";
$perc = ($totalgeral / $totalgeral) * 100;
$percw = format_decimal($perc, 2).' %';
echo "   <td class='cb_perc total_g' style='' >$percw</td> ";
echo "   <td class='cb_texto' ' style='' >&nbsp;</td> ";
echo "</tr>";
echo "</table>";


//
// UNIDADE RESPONSÁVEL
//
$vetUnidadeResponsavelQtd = Array();
$idt_dimensao = 'idt_secao_responsavel';
$vetDimensao = Array();
$condicao = ""; // todos os produtos
QuantitativosDimensao($idt_dimensao, $condicao, $vetDimensao);
$vetUnidadeResponsavelQtd = $vetDimensao;
echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td colspan='4' class='cb_texto_tit' style='' >UNIDADE RESPONSÁVEL</td> ";
echo "</tr>";
echo "<tr class=''>  ";
echo "   <td class='cb_texto_cab cb_texto_cab1' style='width:40%'>Unidade Responsável</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:5%'>Quantidade</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:5%'>Percenual %</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:50%'>&nbsp;</span></td> ";
echo "</tr>";
$totalgeral = $vetUnidadeResponsavelQtd['Total'];
$i = 0;
ForEach ($vetUnidadeResponsavel as $idt => $row) {
    $i = $i + 1;
    $classw = ($i % 2) == 0 ? 'cb_texto_linha_imp' : 'cb_texto_linha_par';
    echo "<tr class=''>  ";
    $quantidade = format_decimal($vetUnidadeResponsavelQtd[$idt], 0);
    echo "   <td class='cb_texto {$classw}' style='' >{$row['descricao']}</td> ";
    echo "   <td class='cb_inteiro {$classw}' style='' >$quantidade</td> ";
    $perc = ($vetUnidadeResponsavelQtd[$idt] / $totalgeral) * 100;
    $percw = format_decimal($perc, 2).' %';
    echo "   <td class='cb_perc {$classw}' style='' >$percw</td> ";
    echo "   <td class='cb_texto {$classw}' style='' >&nbsp;</td> ";

    echo "</tr>";
}
echo "<tr class=''>  ";
$quantidade = format_decimal($vetUnidadeResponsavelQtd[''], 0);
echo "   <td class='cb_texto semclassificar' style='' >SEM INFORMAÇÃO</td> ";
echo "   <td class='cb_inteiro semclassificar' style='' >$quantidade</td> ";
$perc = ($vetUnidadeResponsavelQtd[''] / $totalgeral) * 100;
$percw = format_decimal($perc, 2).' %';
echo "   <td class='cb_perc semclassificar' style='' >&nbsp;$percw</td> ";
echo "   <td class='cb_texto' ' style='' >&nbsp;</td> ";
echo "</tr>";
echo "<tr class=''>  ";
$quantidade = format_decimal($vetUnidadeResponsavelQtd['Total'], 0);
echo "   <td class='cb_texto total_g' style='' >TOTAL</td> ";
echo "   <td class='cb_inteiro total_g' style='' >$quantidade</td> ";
$perc = ($totalgeral / $totalgeral) * 100;
$percw = format_decimal($perc, 2).' %';
echo "   <td class='cb_perc total_g' style='' >$percw</td> ";
echo "   <td class='cb_texto' ' style='' >&nbsp;</td> ";
echo "</tr>";
echo "</table>";






//
// SITUACAO
//
$vetSituacaoQtd = Array();
$idt_dimensao = 'idt_produto_situacao';
$vetDimensao = Array();
$condicao = ""; // todos os produtos
QuantitativosDimensao($idt_dimensao, $condicao, $vetDimensao);
$vetSituacaoQtd = $vetDimensao;
echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td colspan='4' class='cb_texto_tit' style='' >SITUAÇÃO DO PRODUTO</td> ";
echo "</tr>";
echo "<tr class=''>  ";
echo "   <td class='cb_texto_cab cb_texto_cab1' style='width:20%'>Situação</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:5%'>Quantidade</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:5%'>Percenual %</span></td> ";
echo "   <td class='cb_texto_int_cab' style='width:70%'>&nbsp;</span></td> ";
echo "</tr>";
$totalgeral = $vetSituacaoQtd['Total'];
$i = 0;
ForEach ($vetSituacao as $idt => $row) {
    $i = $i + 1;
    $classw = ($i % 2) == 0 ? 'cb_texto_linha_imp' : 'cb_texto_linha_par';
    echo "<tr class=''>  ";
    $quantidade = format_decimal($vetSituacaoQtd[$idt], 0);
    echo "   <td class='cb_texto {$classw}' style='' >{$row['descricao']}</td> ";
    echo "   <td class='cb_inteiro {$classw}' style='' >$quantidade</td> ";
    $perc = ($vetSituacaoQtd[$idt] / $totalgeral) * 100;
    $percw = format_decimal($perc, 2).' %';
    echo "   <td class='cb_perc {$classw}' style='' >$percw</td> ";
    echo "   <td class='cb_texto {$classw}' style='' >&nbsp;</td> ";

    echo "</tr>";
}
echo "<tr class=''>  ";
$quantidade = format_decimal($vetSituacaoQtd[''], 0);
echo "   <td class='cb_texto semclassificar' style='' >SEM INFORMAÇÃO</td> ";
echo "   <td class='cb_inteiro semclassificar' style='' >$quantidade</td> ";
$perc = ($vetSituacaoQtd[''] / $totalgeral) * 100;
$percw = format_decimal($perc, 2).' %';
echo "   <td class='cb_perc semclassificar' style='' >&nbsp;$percw</td> ";
echo "   <td class='cb_texto' ' style='' >&nbsp;</td> ";
echo "</tr>";
echo "<tr class=''>  ";
$quantidade = format_decimal($vetSituacaoQtd['Total'], 0);
echo "   <td class='cb_texto total_g' style='' >TOTAL</td> ";
echo "   <td class='cb_inteiro total_g' style='' >$quantidade</td> ";
$perc = ($totalgeral / $totalgeral) * 100;
$percw = format_decimal($perc, 2).' %';
echo "   <td class='cb_perc total_g' style='' >$percw</td> ";
echo "   <td class='cb_texto' ' style='' >&nbsp;</td> ";
echo "</tr>";
echo "</table>";
?>



<script type="text/javascript" >

    var idt_organizacao = <?php echo $idt_organizacao; ?>;


    function ChamaDepto(codigo_secao)
    {
        alert(codigo_secao);
        //alert(' gggg '+em_idt);
        var opcao = "A";
        var parww = '&codigo_secao=' + idt_organizacao + '&codigo_secao=' + idt_organizacao;
        var href = 'conteudo_matriz_pessoas.php?prefixo=inc&menu=matriz_lista_pessoas&print=n&titulo_rel=Pessoas Associadas a seção ' + codigo_secao;
        var left = 0;
        var top = 0;
        var height = $(window).height();
        var width = $(window).width();
        top = 100;
        left = 150;
        width = width - 200;
        height = height - 350;
        var titulo = "<div style='width:700px; display:block; text-align:center; '>Pessoas Associadas a seção " + codigo_secao + "</div>";
        showPopWin(href, titulo, width, height, close_ChamaDepto, true, top, left);
        //***

        return false;
    }

//Esmeraldo
    function close_ChamaDepto(returnVal) {
        //alert(returnVal);
        //var href = "conteudo_tipologia.php?prefixo=inc&menu=tipologia_medicao&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S&idt_empreendimento="+idt_empreendimento;
        //self.location =  href;

    }
    function ChamaDeptoCargo(codigo_secao, cargo)
    {
        alert(codigo_secao + ' ====  ' + cargo);

        return false;
    }
</script>
