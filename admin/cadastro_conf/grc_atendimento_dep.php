<style>
    .atende_tb{

    }
    .atende_gc{
        background:#ECF0F1;
        color:#000000;
        xborder-bottom:1px solid #000000;
    }
    .atende_gc_linha{
        background:#FFFFFF;
        color:#000000;
        xborder-bottom:1px solid #000000;
    }

    div#topo {
        xxwidth:900px;
    }
    div#geral {
        xxwidth:900px;
    }
    table {
        width:100%;
    }
</style>
<?php
$sql = '';
$sql .= ' select cpf, codigo_siacweb';
$sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa';
$sql .= ' where idt_atendimento = ' . null($_GET['idt_atendimento']);
$sql .= " and tipo_relacao = 'L'";
$rsGRC = execsql($sql);
$rowGRC = $rsGRC->data[0];

$duplicado = '';
$codparceiro = codParceiroSiacWeb('F', $duplicado, $rowGRC['cpf']);

if ($duplicado != '') {
    alert('Regsitro duplicados no SiacWeb!' . $duplicado);
}

if ($codparceiro != '') {
    beginTransaction();

    if ($rowGRC['codigo_siacweb'] != $codparceiro) {
        updateCodSiacweb($rowGRC['codigo_siacweb'], $codparceiro, 'F');
    }

    atualizaHistParceiroSiacWeb($codparceiro, true);

    commit();
}

$largura = 64;
$altura = 64;

echo " <div  style='width:100%; color:#000000;background:#2F66B8; float:left; text-align:center; font-size:18px; color:#FFFFFF; bmargin-top:10px;  xborder-top:1px solid #000000; xborder-bottom:1px solid #000000; '>";
echo " HISTÓRICO RECENTE ";
echo " </div> ";
//
// Consultar o Histórico do cliente
//
$html = "";
$html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
$html .= "<tr  style='' >  ";
$html .= "   <td class='atende_gc'   style='' >Data</td> ";
$html .= "   <td class='atende_gc'   style='' >Instrumento</td> ";
$html .= "   <td class='atende_gc'   style='' >Abordagem</td> ";
$html .= "   <td class='atende_gc'   style='' >Detalhamento</td> ";
$html .= "   <td class='atende_gc'   style='' >Consultor/Atendente</td> ";
$html .= "   <td class='atende_gc'   style='' >SEBRAE</td> ";
$html .= "   <td class='atende_gc_linha' rowspan='4'   style='width:2%;' > ";
$html .= " <div onclick='return HistoricoCompleto({$idt_atendimento},{$codparceiro}, \"{$CPFCliente}\" );' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:0px; padding-left:10px; padding-right:5px;'>";
$html .= "  <img width='{$largura}'  height='{$altura}'  title='Pendências' src='imagens/historico_cliente.png' border='0'>";
$html .= "  </div>";
$html .= "   </td> ";
$html .= "</tr>";

$sql = 'select ';
$sql .= '  siac_his.CodRealizacao,  ';
$sql .= '  siac_his.DataHoraInicioRealizacao,  ';
$sql .= '  siac_his.CodCliente,  ';
$sql .= '  siac_his.Instrumento,  ';
$sql .= '  siac_his.Abordagem,  ';
$sql .= '  siac_his.NomeRealizacao,  ';
$sql .= '  siac_his.CodResponsavel,  ';
$sql .= '  siac_his.CodSebrae,  ';
$sql .= '  sebrae.descsebrae         as sebrae_descsebrae,  ';
$sql .= '  sebrae.nomeabrev          as sebrae_nomeabrev,  ';
$sql .= '  siac_par.CgcCpf           as siac_par_cgccpf,  ';
$sql .= '  par_resp.NomeRazaoSocial  as par_resp_NomeRazaoSocial  ';
$sql .= '  from  ' . db_pir_siac . 'parceiro siac_par';
$sql .= '  INNER JOIN ' . db_pir_siac . 'historicorealizacoescliente siac_his ON siac_par.CodParceiro = siac_his.CodCliente';
$sql .= "  inner join  " . db_pir_siac . "sebrae sebrae            on sebrae.codsebrae = siac_his.CodSebrae ";
$sql .= "  left  join  " . db_pir_siac . "parceiro par_resp        on par_resp.CodParceiro = siac_his.CodResponsavel ";
$sql .= '  where  siac_par.CodParceiro = ' . null($codparceiro);
$sql .= '  order by DataHoraInicioRealizacao desc ';
$sql .= '  limit 3 ';
$rs = execsql($sql);

$linha = 0;
ForEach ($rs->data as $row) {
    $CodRealizacao = $row['codrealizacao'];
    $DataHoraInicioRealizacao = $row['datahorainiciorealizacao'];
    $Instrumento = $row['instrumento'];
    $Abordagem = $row['abordagem'];
    $NomeRealizacao = $row['nomerealizacao'];
    $CodResponsavel = $row['codresponsavel'];
    $CodSebrae = $row['codsebrae'];
    $CPFCliente = $row['siac_par_cgccpf'];
    //
    $sebrae_descsebrae = $row['sebrae_descsebrae'];
    $sebrae_nomeabrev = $row['sebrae_nomeabrev'];

    $par_resp_NomeRazaoSocial = $row['par_resp_nomerazaosocial'];
    //
    $data = substr(trata_data($DataHoraInicioRealizacao), 0, 10);
    if ($Abordagem == 'G') {
        $Abordagemw = 'Grupal';
    } else {
        $Abordagemw = 'Individual';
    }
    $linha = $linha + 1;
    $html .= "<tr  style='' >  ";
    $onclick = "onclick = 'return DetalhaAtendimento($codparceiro, \"$CPFCliente\" , \"{$DataHoraInicioRealizacao}\",$linha,0);'";
    $html .= "   <td $onclick class='atende_gc_linha' title='Detalha o Atendimento'   style='color:#2A5696; cursor:pointer' >{$data}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$Instrumento}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$Abordagemw}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$NomeRealizacao}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$par_resp_NomeRazaoSocial}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$sebrae_nomeabrev}</td> ";
    $html .= "</tr>";
}

if ($rs->rows != 3) {
    $limitarem = (3 - $rs->rows);
    $sql = 'select ';
    $sql .= '  siac_his.CodRealizacao,  ';
    $sql .= '  siac_his.DataHoraInicioRealizacao,  ';
    $sql .= '  siac_his.CodCliente,  ';
    $sql .= '  siac_his.Instrumento,  ';
    $sql .= '  siac_his.Abordagem,  ';
    $sql .= '  siac_his.NomeRealizacao,  ';
    $sql .= '  siac_his.CodResponsavel,  ';
    $sql .= '  siac_his.CodSebrae,  ';
    $sql .= '  sebrae.descsebrae         as sebrae_descsebrae,  ';
    $sql .= '  sebrae.nomeabrev          as sebrae_nomeabrev,  ';
    $sql .= '  siac_par.CgcCpf           as siac_par_cgccpf,  ';
    $sql .= '  par_resp.NomeRazaoSocial  as par_resp_NomeRazaoSocial  ';
    $sql .= '  from  ' . db_pir_siac . 'parceiro siac_par';
    $sql .= '  INNER JOIN ' . db_pir_siac . 'historicorealizacoescliente_anosanteriores siac_his ON siac_par.CodParceiro = siac_his.CodCliente';
    $sql .= "  inner join  " . db_pir_siac . "sebrae sebrae            on sebrae.codsebrae = siac_his.CodSebrae ";
    $sql .= "  left  join  " . db_pir_siac . "parceiro par_resp        on par_resp.CodParceiro = siac_his.CodResponsavel ";
    $sql .= '  where  siac_par.CodParceiro = ' . null($codparceiro);
    $sql .= '  order by DataHoraInicioRealizacao desc ';
    $sql .= "  limit {$limitarem} ";
    $rs = execsql($sql);

    $linha = 0;
    ForEach ($rs->data as $row) {
        $CodRealizacao = $row['codrealizacao'];
        $DataHoraInicioRealizacao = $row['datahorainiciorealizacao'];
        $Instrumento = $row['instrumento'];
        $Abordagem = $row['abordagem'];
        $NomeRealizacao = $row['nomerealizacao'];
        $CodResponsavel = $row['codresponsavel'];
        $CodSebrae = $row['codsebrae'];
        $CPFCliente = $row['siac_par_cgccpf'];

        $sebrae_descsebrae = $row['sebrae_descsebrae'];
        $sebrae_nomeabrev = $row['sebrae_nomeabrev'];
        $par_resp_NomeRazaoSocial = $row['par_resp_nomerazaosocial'];


        $data = substr(trata_data($DataHoraInicioRealizacao), 0, 10);
        if ($Abordagem == 'G') {
            $Abordagemw = 'Grupal';
        } else {
            $Abordagemw = 'Individual';
        }
        $linha = $linha + 1;
        $html .= "<tr  style='' >  ";
        $onclick = "onclick = 'return DetalhaAtendimento($codparceiro, \"$CPFCliente\", \"{$DataHoraInicioRealizacao}\",$linha,1);'";
        $html .= "   <td $onclick class='atende_gc_linha' title='Detalha o Atendimento'   style='color:#2A5696; cursor:pointer' >{$data}</td> ";
        $html .= "   <td class='atende_gc_linha'   style='' >{$Instrumento}</td> ";
        $html .= "   <td class='atende_gc_linha'   style='' >{$Abordagemw}</td> ";
        $html .= "   <td class='atende_gc_linha'   style='' >{$NomeRealizacao}</td> ";
        $html .= "   <td class='atende_gc_linha'   style='' >{$par_resp_NomeRazaoSocial}</td> ";
        $html .= "   <td class='atende_gc_linha'   style='' >{$sebrae_nomeabrev}</td> ";
        $html .= "</tr>";
    }
}
$idtd = 'detalhehistd';
$idtr = 'detalhehistr';
//
$html .= "<tr  id='{$idtr}' style='display:none;' >  ";
$html .= "   <td id='{$idtd}' colspan='7' class='atende_gc_linha' title='Detalha o Atendimento'   style='color:#2A5696; cursor:pointer' ></td> ";
$html .= "</tr>";

//////////////////////////////////////
$html .= "</table>";
echo $html;

//p($sql);
?>
<script>
    function HistoricoCompleto(idt_atendimento, CodCliente, CPFCliente)
    {
        var left = 0;
        var top = 0;
        var height = $(window).height();
        var width = $(window).width();

        var par = '';
        par += '&codparceiro_atual=<?php echo $codparceiro; ?>';
        par += '&tipo_parceiro=F';
        par += '&cpfcnpj=<?php echo $rowGRC['cpf']; ?>';

        var link = 'conteudo_historico.php?prefixo=inc&menu=grc_historicocliente' + par;
        historico = window.open(link, "HistoricoCliente", "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
        historico.focus();
        return false;
    }

    function DetalhaAtendimento(CodCliente, CPFCliente, DataHoraInicioRealizacao, linha, opcao)
    {
        //alert(' Detalha o atendimento '+CodCliente+" Hora "+DataHoraInicioRealizacao);
        //
        // CHAMAR O DETALHAMENTO DO ATENDIMENTO
        //
        var str = "";
        var titulo = "Detalhar Histórico de Atendimento. Aguarde...";
        processando_grc(titulo, '#2F66B8');


//   alert('opcao == '+opcao);
        $.post('ajax_atendimento.php?tipo=DetalharHistorico', {
            async: false,
            CodCliente: CodCliente,
            CPFCliente: CPFCliente,
            DataHoraInicioRealizacao: DataHoraInicioRealizacao,
            linha: linha,
            opcao: opcao
        }
        , function (str) {
            if (str == '') {
                alert('Erro detalhar historico ' + str);
                processando_acabou_grc();
            } else {
                processando_acabou_grc();
                var id = 'detalhehistr';
                objtp = document.getElementById(id);
                if (objtp != null) {
                    $(objtp).show();
                }
                var id = 'detalhehistd';
                objtp = document.getElementById(id);
                if (objtp != null) {
                    objtp.innerHTML = str;
                }
                //alert ('desfazer ..... ');

            }
        });



        return false;
    }

    function  FechaDetalhe(linha)
    {
        var id = 'detalhehistr';
        objtp = document.getElementById(id);
        if (objtp != null) {
            $(objtp).hide();
        }
    }

</script>
