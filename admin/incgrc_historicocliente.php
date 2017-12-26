<style>
    .atende_tb{

    }
    .atende_gc{
        background:#ECF0F1;
        color:#000000;
        xborder-bottom:1px solid #000000;
        padding:5px;
    }
    .atende_gc_linha{
        background:#FFFFFF;
        color:#000000;
        xborder-bottom:1px solid #000000;
        padding:5px;
    }


    .atende_gc_s{

        background:#FFFFFF;
        color:#000000;
        border-bottom:1px solid #000000;
        padding:5px;
        text-align:center;
    }
    .atende_gc_linha_s1{
        background:#ECF0F1;
        color:#000000;
        padding:5px;
        text-align:center;
    }

    .atende_gc_linha_s{
        background:#FFFFFF;
        color:#000000;
        padding:5px;
        text-align:center;
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
$duplicado = '';
$codparceiro = codParceiroSiacWeb($_GET['tipo_parceiro'], $duplicado, $_GET['cpfcnpj'], $_GET['nirf'], $_GET['dap'], $_GET['rmp'], $_GET['ie_prod_rural'], $_GET['sicab_codigo']);

if ($duplicado != '') {
    alert('Regsitro duplicados no SiacWeb!' . $duplicado);
}

if ($codparceiro != '') {
    beginTransaction();

    if ($_GET['codparceiro_atual'] != $codparceiro) {
        updateCodSiacweb($_GET['codparceiro_atual'], $codparceiro, $_GET['tipo_parceiro']);
    }

    atualizaHistParceiroSiacWeb($codparceiro, true);

    commit();
}

if ($_GET['tipo_parceiro'] == 'J') {
    $campoWhere = 'par_empre';
} else {
    $campoWhere = 'siac_par';
}

$vetInstrumento = Array();
$vetInstrumento[1] = 'Informa��o';
$vetInstrumento[2] = 'Orienta��o T�cnica';
$vetInstrumento[3] = 'Consultoria';
$vetInstrumento[4] = 'Cursos';
$vetInstrumento[5] = 'Palestra';
$vetInstrumento[6] = 'Oficina';
$vetInstrumento[7] = 'Semin�rio';
$vetInstrumento[8] = 'Miss�o/Caravana';
$vetInstrumento[9] = 'Feira';
$vetInstrumento[10] = 'Rodada de Neg�cio';

$vetInstrumento_abord = Array();
$vetInstrumento_abord[1] = 'Individual';
$vetInstrumento_abord[2] = 'Individual';
$vetInstrumento_abord[3] = 'Individual';
$vetInstrumento_abord[4] = 'Grupal';
$vetInstrumento_abord[5] = 'Grupal';
$vetInstrumento_abord[6] = 'Grupal';
$vetInstrumento_abord[7] = 'Grupal';
$vetInstrumento_abord[8] = 'Grupal';
$vetInstrumento_abord[9] = 'Grupal';
$vetInstrumento_abord[10] = 'Grupal';

$vetInstrumento_atend = Array();
$vetInstrumento_atend[1] = "";
$vetInstrumento_atend[2] = "";
$vetInstrumento_atend[3] = "";
$vetInstrumento_atend[4] = "";
$vetInstrumento_atend[5] = "";
$vetInstrumento_atend[6] = "";
$vetInstrumento_atend[7] = "";
$vetInstrumento_atend[8] = "";
$vetInstrumento_atend[9] = "";
$vetInstrumento_atend[10] = "";
$programa_fidelidade_pa = 0;
$programa_fidelidade_re = 0;
$programa_fidelidade_cl = "";


$vetInstrumentoDePara = Array();
$vetInstrumentoDePara['Informa��o'] = 1;
$vetInstrumentoDePara['Orienta��o T�cnica'] = 2;
$vetInstrumentoDePara['Consultoria'] = 3;
$vetInstrumentoDePara['Cursos'] = 4;
$vetInstrumentoDePara['Palestra'] = 5;
$vetInstrumentoDePara['Oficina'] = 6;
$vetInstrumentoDePara['Semin�rio'] = 7;
$vetInstrumentoDePara['Miss�o/Caravana'] = 8;
$vetInstrumentoDePara['Feira'] = 9;
$vetInstrumentoDePara['Rodada de Neg�cio'] = 10;


$vetInstrumentoAnalitico = Array();


$html = "";
$html .= " <div  style='width:100%; color:#000000;background:#2F66B8; xfloat:left; text-align:left; font-size:18px; color:#FFFFFF; bmargin-top:10px;  xborder-top:1px solid #000000; xborder-bottom:1px solid #000000; '>";
$html .= " ANAL�TICO ";
$html .= " </div> ";
//
// Consultar o Hist�rico do cliente
//
$html .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
$html .= "<tr  style='' >  ";
$html .= "   <td class='atende_gc'   style='' >Data</td> ";
$html .= "   <td class='atende_gc'   style='' >Instrumento</td> ";
$html .= "   <td class='atende_gc'   style='' >Abordagem</td> ";
$html .= "   <td class='atende_gc'   style='' >Detalhamento</td> ";
$html .= "   <td class='atende_gc'   style='' >Consultor/Atendente</td> ";
$html .= "   <td class='atende_gc'   style='' >SEBRAE</td> ";
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
$sql .= '  siac_his.CargaHoraria,  ';
$sql .= '  sebrae.descsebrae         as sebrae_descsebrae,  ';
$sql .= '  sebrae.nomeabrev          as sebrae_nomeabrev,  ';
$sql .= '  siac_par.CgcCpf           as siac_par_cgccpf,  ';
$sql .= '  par_resp.NomeRazaoSocial  as par_resp_NomeRazaoSocial,  ';
$sql .= '  par_empre.CgcCpf           as par_empre_CgcCpf,  ';
$sql .= '  par_empre.NomeRazaoSocial  as par_empre_NomeRazaoSocial  ';
$sql .= '  from  ' . db_pir_siac . 'parceiro siac_par';
$sql .= '  INNER JOIN ' . db_pir_siac . 'historicorealizacoescliente siac_his ON siac_par.CodParceiro = siac_his.CodCliente';
$sql .= "  inner join  " . db_pir_siac . "sebrae sebrae            on sebrae.codsebrae      = siac_his.CodSebrae ";
$sql .= "  left  join  " . db_pir_siac . "parceiro par_resp        on par_resp.CodParceiro  = siac_his.CodResponsavel ";
$sql .= "  left  join  " . db_pir_siac . "parceiro par_empre       on par_empre.CodParceiro = siac_his.codempreedimento ";
$sql .= '  where  ' . $campoWhere . '.CodParceiro = ' . null($codparceiro);
$sql .= '  order by DataHoraInicioRealizacao desc ';
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
    $CargaHoraria = $row['cargahoraria'];
    //
    $sebrae_descsebrae = $row['sebrae_descsebrae'];
    $sebrae_nomeabrev = $row['sebrae_nomeabrev'];
    $par_resp_NomeRazaoSocial = $row['par_resp_nomerazaosocial'];
    //
    $par_empre_CgcCpf = $row['par_empre_cgccpf'];
    $par_empre_NomeRazaoSocial = $row['par_empre_nomerazaosocial'];

    $CPFCliente = $row['siac_par_cgccpf'];

    //
    $data = substr(trata_data($DataHoraInicioRealizacao), 0, 10);
    if ($Abordagem == 'G') {
        $Abordagemw = 'Grupal';
    } else {
        $Abordagemw = 'Individual';
    }
    $vetInstrumentoAnalitico[$Instrumento]['des'] = $Instrumento;
    $vetInstrumentoAnalitico[$Instrumento]['qtd'] = $vetInstrumentoAnalitico[$Instrumento]['qtd'] + 1;
    $vetInstrumentoAnalitico[$Instrumento]['cah'] = $vetInstrumentoAnalitico[$Instrumento]['cah'] + $CargaHoraria;
    $html .= "<tr  style='' >  ";
//            $onclick = "onclick = 'return DetalhaAtendimento($CodRealizacao);'";
    $linha = $linha + 1;
    $onclick = "onclick = 'return DetalhaAtendimento($codparceiro, \"$CPFCliente\", \"{$DataHoraInicioRealizacao}\", $linha,0,\"{$CNPJW}\");'";
    $html .= "   <td $onclick class='atende_gc_linha' title='Detalha o Atendimento'   style='color:#2A5696; cursor:pointer' >{$data}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$Instrumento}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$Abordagemw}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$NomeRealizacao}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$par_resp_NomeRazaoSocial}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$sebrae_nomeabrev}</td> ";
    $html .= "</tr>";
    //
    $idtd = "detalhehistd_{$linha}";
    $idtr = "detalhehistr_{$linha}";
    //
    $html .= "<tr  id='{$idtr}' style='display:none;' >  ";
    $html .= "   <td id='{$idtd}' colspan='7' class='atende_gc_linha' title='Detalha o Atendimento'   style='color:#2A5696; cursor:pointer' ></td> ";
    $html .= "</tr>";
    //
}


/////////////////////////// anteriores

$sql = 'select ';
$sql .= '  siac_his.CodRealizacao,  ';
$sql .= '  siac_his.DataHoraInicioRealizacao,  ';
$sql .= '  siac_his.CodCliente,  ';
$sql .= '  siac_his.Instrumento,  ';
$sql .= '  siac_his.Abordagem,  ';
$sql .= '  siac_his.NomeRealizacao,  ';
$sql .= '  siac_his.CodResponsavel,  ';
$sql .= '  siac_his.CodSebrae,  ';
$sql .= '  siac_his.CargaHoraria,  ';

$sql .= '  sebrae.descsebrae         as sebrae_descsebrae,  ';
$sql .= '  sebrae.nomeabrev          as sebrae_nomeabrev,  ';
$sql .= '  siac_par.CgcCpf           as siac_par_cgccpf,  ';
$sql .= '  par_resp.NomeRazaoSocial  as par_resp_NomeRazaoSocial,  ';
$sql .= '  par_empre.CgcCpf           as par_empre_CgcCpf,  ';
$sql .= '  par_empre.NomeRazaoSocial  as par_empre_NomeRazaoSocial  ';

$sql .= '  from  ' . db_pir_siac . 'parceiro siac_par';

$sql .= '  INNER JOIN ' . db_pir_siac . 'historicorealizacoescliente_anosanteriores siac_his ON siac_par.CodParceiro = siac_his.CodCliente';
$sql .= "  inner join  " . db_pir_siac . "sebrae sebrae            on sebrae.codsebrae      = siac_his.CodSebrae ";
$sql .= "  left  join  " . db_pir_siac . "parceiro par_resp        on par_resp.CodParceiro  = siac_his.CodResponsavel ";
$sql .= "  left  join  " . db_pir_siac . "parceiro par_empre       on par_empre.CodParceiro = siac_his.codempreedimento ";
$sql .= '  where  ' . $campoWhere . '.CodParceiro = ' . null($codparceiro);
$sql .= '  order by DataHoraInicioRealizacao desc ';
$rs = execsql($sql);

ForEach ($rs->data as $row) {
    $CodRealizacao = $row['codrealizacao'];
    $DataHoraInicioRealizacao = $row['datahorainiciorealizacao'];
    $Instrumento = $row['instrumento'];
    $Abordagem = $row['abordagem'];
    $NomeRealizacao = $row['nomerealizacao'];
    $CodResponsavel = $row['codresponsavel'];
    $CodSebrae = $row['codsebrae'];
    $CargaHoraria = $row['cargahoraria'];

    $sebrae_descsebrae = $row['sebrae_descsebrae'];
    $sebrae_nomeabrev = $row['sebrae_nomeabrev'];
    $par_resp_NomeRazaoSocial = $row['par_resp_nomerazaosocial'];

    $CPFCliente = $row['siac_par_cgccpf'];


    $data = substr(trata_data($DataHoraInicioRealizacao), 0, 10);
    if ($Abordagem == 'G') {
        $Abordagemw = 'Grupal';
    } else {
        $Abordagemw = 'Individual';
    }
    $vetInstrumentoAnalitico[$Instrumento]['des'] = $Instrumento;
    $vetInstrumentoAnalitico[$Instrumento]['qtd'] = $vetInstrumentoAnalitico[$Instrumento]['qtd'] + 1;
    $vetInstrumentoAnalitico[$Instrumento]['cah'] = $vetInstrumentoAnalitico[$Instrumento]['cah'] + $CargaHoraria;
    $html .= "<tr  style='' >  ";
//            $onclick = "onclick = 'return DetalhaAtendimento($CodRealizacao);'";
    $linha = $linha + 1;
    $onclick = "onclick = 'return DetalhaAtendimento($codparceiro, \"$CPFCliente\", \"{$DataHoraInicioRealizacao}\", $linha,1,\"{$CNPJW}\");'";
    $html .= "   <td $onclick class='atende_gc_linha' title='Detalha o Atendimento'   style='color:#2A5696; cursor:pointer' >{$data}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$Instrumento}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$Abordagemw}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$NomeRealizacao}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$par_resp_NomeRazaoSocial}</td> ";
    $html .= "   <td class='atende_gc_linha'   style='' >{$sebrae_nomeabrev}</td> ";
    $html .= "</tr>";
    //
    $idtd = "detalhehistd_{$linha}";
    $idtr = "detalhehistr_{$linha}";
    //
    $html .= "<tr  id='{$idtr}' style='display:none;' >  ";
    $html .= "   <td id='{$idtd}' colspan='7' class='atende_gc_linha' title='Detalha o Atendimento'   style='color:#2A5696; cursor:pointer' ></td> ";
    $html .= "</tr>";
    //
}

//////////////////////////////////////
$html .= "</table>";
//////////////////////////////////////////////////////////
ForEach ($vetInstrumentoAnalitico as $Instrumento => $VetIns) {

    $InstrumentoSIAC = $VetIns['des'];
    $Quantidade = $VetIns['qtd'];
    $CargaHoraria = $VetIns['cah'];
    //
    //
        //
        $indice = $vetInstrumentoDePara[$Instrumento];
    if ($indice != "") {
        $vetInstrumento_atend[$indice] = $vetInstrumento_atend[$indice] + $Quantidade;
    } else {

        /*
          $vetInstrumento[1]  = 'Informa��o';
          $vetInstrumento[2]  = 'Orienta��o T�cnica';
          $vetInstrumento[3]  = 'Consultoria';
          $vetInstrumento[4]  = 'Cursos';
          $vetInstrumento[5]  = 'Palestra';
          $vetInstrumento[6]  = 'Oficina';
          $vetInstrumento[7]  = 'Semin�rio';
          $vetInstrumento[8]  = 'Miss�o/Caravana';
          $vetInstrumento[9]  = 'Feira';
          $vetInstrumento[10] = 'Rodada de Neg�cio';
         */
        $const = 'Informa��o';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 1;
        }

        $const = 'Orienta��o T�cnica';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 2;
        }

        $const = 'CONSULTORIA';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 3;
        }
        $const = 'Consultoria';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 3;
        }


        $const = 'CURSOS';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 4;
        }
        $const = 'Cursos';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 4;
        }

        $const = 'PALESTRA';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 5;
        }
        $const = 'Palestras';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 5;
        }


        $const = 'OFICINA';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 6;
        }
        $const = 'Oficina';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 6;
        }

        $const = 'SEMIN�RIO';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 7;
        }
        $const = 'Semin�rio';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 7;
        }


        $const = 'MISS�O';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 8;
        }
        $const = 'Miss�o';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 8;
        }
        $const = 'CARAVANA';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 8;
        }
        $const = 'Caravana';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 8;
        }

        $const = 'FEIRA';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 9;
        }
        $const = 'Feira';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 9;
        }
        $const = 'Acesso a Eventos';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 9;
        }


        $const = 'NEG�CIO';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 10;
        }
        $const = 'Neg�cio';
        $tam = strlen($const);
        if (substr($Instrumento, 0, $tam) == $const) {
            $indice = 10;
        }
        $vetInstrumento_atend[$indice] = $vetInstrumento_atend[$indice] + $Quantidade;
    }
}
//p($vetInstrumentoAnalitico);
//
// Gravar quantitativos
//








$html1 = "";


$html1 .= " <div  style='width:100%; color:#000000;background:#2F66B8; xfloat:left; text-align:left; font-size:18px; color:#FFFFFF; bmargin-top:10px;  xborder-top:1px solid #000000; xborder-bottom:1px solid #000000; '>";
$html1 .= " SINT�TICO ";
$html1 .= " </div> ";

$html1 .= "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";

$html1 .= "<tr  style='' >  ";
$html1 .= "   <td class='atende_gc_s'   style='' >Instrumentos</td> ";
$html1 .= "   <td class='atende_gc_s'   style='' >Abordagem</td> ";
$html1 .= "   <td class='atende_gc_s'   style='' >Atendimentos</td> ";
$html1 .= "   <td class='atende_gc_s'   style='' >Instrumentos</td> ";
$html1 .= "   <td class='atende_gc_s'   style='' >Abordagem</td> ";
$html1 .= "   <td class='atende_gc_s'   style='' >Atendimentos</td> ";
$html1 .= "   <td class='atende_gc_s'   style='' >Programa de Fidelidade</td> ";
$html1 .= "</tr>";
//
$html1 .= "<tr  style='' >  ";
// linha 1
$linha = 1;
//
$Instrumento = $vetInstrumento[$linha];
$Abordagem = $vetInstrumento_abord[$linha];
$atendimentos = $vetInstrumento_atend[$linha];
//
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$Instrumento}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$Abordagem}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$atendimentos}</td> ";
//
$Instrumento = $vetInstrumento[$linha + 5];
$Abordagem = $vetInstrumento_abord[$linha + 5];
$atendimentos = $vetInstrumento_atend[$linha + 5];
//
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$Instrumento}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$Abordagem}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$atendimentos}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >Pontua��o Acumulada</td> ";
$html1 .= "</tr>";


$html1 .= "<tr  style='' >  ";
// linha 1
$linha = 2;
//
$Instrumento = $vetInstrumento[$linha];
$Abordagem = $vetInstrumento_abord[$linha];
$atendimentos = $vetInstrumento_atend[$linha];
//
$html1 .= "   <td class='atende_gc_linha_s'   style='' >{$Instrumento}</td> ";
$html1 .= "   <td class='atende_gc_linha_s'   style='' >{$Abordagem}</td> ";
$html1 .= "   <td class='atende_gc_linha_s'   style='' >{$atendimentos}</td> ";
//
$Instrumento = $vetInstrumento[$linha + 5];
$Abordagem = $vetInstrumento_abord[$linha + 5];
$atendimentos = $vetInstrumento_atend[$linha + 5];
//
$html1 .= "   <td class='atende_gc_linha_s'   style='' >{$Instrumento}</td> ";
$html1 .= "   <td class='atende_gc_linha_s'   style='' >{$Abordagem}</td> ";
$html1 .= "   <td class='atende_gc_linha_s'   style='' >{$atendimentos}</td> ";
$html1 .= "   <td class='atende_gc_linha_s'   style='' >{$programa_fidelidade_pa}</td> ";
$html1 .= "</tr>";

$html1 .= "<tr  style='' >  ";
// linha 1
$linha = 3;
//
$Instrumento = $vetInstrumento[$linha];
$Abordagem = $vetInstrumento_abord[$linha];
$atendimentos = $vetInstrumento_atend[$linha];
//
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$Instrumento}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$Abordagem}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$atendimentos}</td> ";
//
$Instrumento = $vetInstrumento[$linha + 5];
$Abordagem = $vetInstrumento_abord[$linha + 5];
$atendimentos = $vetInstrumento_atend[$linha + 5];
//
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$Instrumento}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$Abordagem}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$atendimentos}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$programa_fidelidade_re} Resgat�vel</td> ";
$html1 .= "</tr>";

$html1 .= "<tr  style='' >  ";
// linha 1
$linha = 4;
//
$Instrumento = $vetInstrumento[$linha];
$Abordagem = $vetInstrumento_abord[$linha];
$atendimentos = $vetInstrumento_atend[$linha];
//
$html1 .= "   <td class='atende_gc_linha_s'   style='' >{$Instrumento}</td> ";
$html1 .= "   <td class='atende_gc_linha_s'   style='' >{$Abordagem}</td> ";
$html1 .= "   <td class='atende_gc_linha_s'   style='' >{$atendimentos}</td> ";
//
$Instrumento = $vetInstrumento[$linha + 5];
$Abordagem = $vetInstrumento_abord[$linha + 5];
$atendimentos = $vetInstrumento_atend[$linha + 5];
//
$html1 .= "   <td class='atende_gc_linha_s'   style='' >{$Instrumento}</td> ";
$html1 .= "   <td class='atende_gc_linha_s'   style='' >{$Abordagem}</td> ";
$html1 .= "   <td class='atende_gc_linha_s'   style='' >{$atendimentos}</td> ";
$html1 .= "   <td class='atende_gc_linha_s'   style='' >Classe</td> ";
$html1 .= "</tr>";



$html1 .= "<tr  style='' >  ";
// linha 1
$linha = 5;
//
$Instrumento = $vetInstrumento[$linha];
$Abordagem = $vetInstrumento_abord[$linha];
$atendimentos = $vetInstrumento_atend[$linha];
//
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$Instrumento}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$Abordagem}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$atendimentos}</td> ";
//
$Instrumento = $vetInstrumento[$linha + 5];
$Abordagem = $vetInstrumento_abord[$linha + 5];
$atendimentos = $vetInstrumento_atend[$linha + 5];
//
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$Instrumento}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$Abordagem}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$atendimentos}</td> ";
$html1 .= "   <td class='atende_gc_linha_s1'   style='' >{$programa_fidelidade_cl}</td> ";
$html1 .= "</tr>";



$html1 .= "</table> ";










echo $html1 . $html;
?>
<script>
    $(document).ready(function () {
        /*
         objd=document.getElementById('tipo_pessoa_desc');
         if (objd != null)
         {
         $(objd).css('visibility','hidden');
         }
         objd=document.getElementById('tipo_pessoa');
         if (objd != null)
         {
         objd.value = "";
         $(objd).css('visibility','hidden');
         }
         */
    });
    function DetalhaAtendimento(CodCliente, CPFCliente, DataHoraInicioRealizacao, linha, opcao, CNPJ)
    {
        // alert(' Detalha o atendimento '+CodCliente+" Hora "+DataHoraInicioRealizacao+" CNPJ "+CNPJ);
        //
        // CHAMAR O DETALHAMENTO DO ATENDIMENTO
        //
        var str = "";
        var titulo = "Detalhar Hist�rico de Atendimento. Aguarde...";
        processando_grc(titulo, '#2F66B8');

        $.post('ajax_atendimento.php?tipo=DetalharHistorico', {
            async: false,
            CodCliente: CodCliente,
            CPFCliente: CPFCliente,
            CNPJ: CNPJ,
            DataHoraInicioRealizacao: DataHoraInicioRealizacao,
            linha: linha,
            opcao: opcao
        }
        , function (str) {
            if (str == '') {
                alert('Erro detalhar historico ' + str);
                processando_acabou_grc();
            } else {
                var id = 'detalhehistr_' + linha;
                objtp = document.getElementById(id);
                if (objtp != null) {
                    $(objtp).show();
                }
                var id = 'detalhehistd_' + linha;
                objtp = document.getElementById(id);
                if (objtp != null) {
                    objtp.innerHTML = str;
                }
                processando_acabou_grc();
            }
        });



        return false;
    }

    function  FechaDetalhe(linha)
    {
        var id = 'detalhehistr_' + linha;
        objtp = document.getElementById(id);
        if (objtp != null) {
            $(objtp).hide();
        }
    }







</script>
