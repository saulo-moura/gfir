<style>


    .chama {
        background:#006ca8;
        color:#2F65BB;
        width:100%;
        display:block;
        text-align:center;
        font-size:1.4em;
    }

    .chama_sem {
        background:#2A5696;
        color:#FFFFFF;
        width:100%;
        display:block;
        text-align:center;
        font-size:2.0em;
        border-bottom:1px solid #FFFFFF;
    }
    .chama_sem_cpf {
        background:#2A5696;
        color:#FFFFFF;
        width:100%;
        display:block;
        text-align:center;
        font-size:2.0em;
        height:400px;
    }




    .botao_ag {
        text-align:center;
        width:100%;

        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        float:left;
        margin-top:10px;
        margin-right:10px;
        font-weight:bold;
        font-size:1.4em;
        padding:10px;
    }
    .botao_ag:hover {
        background:#0000FF;
    }


    .botao_ag_a {
        text-align:center;
        width:100%;
        color:#FFFFFF;
        background:#0000FF;
        font-size:14px;
        float:left;
        margin-top:10px;
        margin-right:10px;
        font-weight:bold;
        font-size:1.4em;
        padding:10px;
    }


    .chama_cab {
        background:#F1F1F1;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-style: normal;
        font-weight: normal;
    }

    .titulo_cab1 {

        color:#666666;
        font-size:1.2em;
        text-align:right;
    }
    .titulo_txt1 {
        color:#2F65BB;
        font-size:1.2em;
        text-align:left;
        padding-left:5px;
    }

    .cpf_novo_c {
        height:40px;
        text-align:center;
        font-size:1.2em;
    }

    .aba_ativo {
        border: 1px solid black;
        height: 100px;
    }

    .pointer {
        cursor: pointer;
    }
</style>

<?php
if ($_GET['distancia'] == '') {
    $_GET['distancia'] = 'P';
}

if ($_GET['pesquisa'][0] == 'S' && $_GET['aba'] == '') {
    $sql2 = 'select ';
    $sql2 .= '  a.idt_atendimento_agenda';
    $sql2 .= '  from grc_atendimento a';
    $sql2 .= '  where a.idt = '.null($_GET['id']);
    $rs_aap = execsql($sql2);
    $_GET['id'] = $rs_aap->data[0]['idt_atendimento_agenda'];
    
    if ($_GET['acao'] == 'alt') {
        $_GET['pesquisa'] = 'N';
    }
    
    if ($_GET['acao'] == 'exc') {
        $_GET['pesquisa'] = 'SC';
    }
}

if ($_GET['pesquisa'][0] == 'S') {
    $_GET['acao'] = 'con';
    $acao = $_GET['acao'];
}
        
$qtdrepresentantes = 0;
$idt_atendimento_agenda = $_GET['id'];
$session_volta = 'totem';

//
// p($_GET);
//
$opcao = $_GET['opcao'];
$_GET['opcao'] = "";

// orientação técnica
$idt_instrumento = 13;

if ($_GET['acao'] == '') {
    $acao = 'alt';
}

$sem_registro = false;
$idt_atendimento = 0;

if ($opcao == 'inc') {
    $sql = '';
    $sql .= ' select e.idt';
    $sql .= ' from grc_nan_estrutura e';
    $sql .= ' where e.idt_usuario = '.null($_SESSION[CS]['g_id_usuario']);
    $sql .= ' and e.idt_nan_tipo = 6';
    $sql .= " and e.ativo = 'S'";
    $rs = execsql($sql);

    $msgErro = '';

    if ($rs->rows == 0) {
        $msgErro = 'Você não esta cadastrado no sistema como AOE! Com isso não pode realizar a Primeira Visita.';
    } else if ($rs->rows > 1) {
        $msgErro = 'Você tem mais de um cadastro ativos de AOE no sistema! Só pode ter um cadastro ativo para realizar a Primeira Visita.';
    }

    if ($msgErro != '') {
        ?>
        <script type="text/javascript">
            alert('<?php echo $msgErro; ?>');
            self.location = "<?php echo $_SESSION[CS]['grc_nan_visita_1_avulso']; ?>";
        </script>
        <?php
        exit();
    }

    $acao = 'con';
    $senha_totem = 'CH';
    $sem_registro = true;

    /*
      // GERAR ESTRUTURA DE ATENDIMENTO
      $datadia               = date('d/m/Y H:i:s');
      $vet                   = explode(' ', $datadia);
      $data_inicial          = trata_data($vet[0]);
      $hora_inicial          = substr($vet[1], 0, 5);
      $idt_atendimentow      = 0;
      $idt_consultor         = $_SESSION[CS]['g_id_usuario'];
      $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
      GeraAtendimentoHE($idt_consultor, $idt_ponto_atendimento, $data_inicial, $hora_inicial, $idt_instrumento, $idt_atendimentow);
      $idt_atendimento = $idt_atendimentow;
      $sql2 = 'select ';
      $sql2 .= '  idt_atendimento_agenda   ';
      $sql2 .= '  from grc_atendimento grc_a ';
      $sql2 .= '  where grc_a.idt = '.null($idt_atendimento);
      $rs_aap = execsql($sql2);
      $idt_atendimento = 0;
      if ($rs_aap->rows == 0) {

      } else {
      ForEach ($rs_aap->data as $row) {
      $idt_atendimento_agenda = $row['idt_atendimento_agenda'];
      $_GET['id']=$idt_atendimento_agenda;
      }
      }
     * 
     */
}


$vetpar = Array();
$vetpar['GET'] = $_GET;
$EnderecoRefresh = MontaGET($vetpar);
//p($vetpar);
//echo " EnderecoRefresh = $EnderecoRefresh <br />";



$aba = $_GET['aba'];
if ($aba == "") {
    $aba = 1;
}

$sql1 = 'select ';
$sql1 .= '  grc_aa.*   ';
$sql1 .= '  from grc_atendimento_agenda grc_aa ';
$sql1 .= ' where    grc_aa.idt    = '.null($idt_atendimento_agenda);
$rs_aa = execsql($sql1);
if ($rs_aa->rows == 0) {
    
}

$idt_consultor = "";
$data = "";
$hora = "";
$temsenha = 0;
ForEach ($rs_aa->data as $row_aa) {
    $protocolo = ($row_aa['protocolo']);
    $cpf = ($row_aa['cpf']);
    $cnpj = ($row_aa['cnpj']);
    $nome_pessoa = ($row_aa['nome_pessoa']);
    $cliente_texto = ($row_aa['cliente_texto']);
    $nome_empresa = ($row_aa['nome_empresa']);
    $idt_pessoa = ($row_aa['idt_pessoa']);
    $idt_consultor = ($row_aa['idt_consultor']);
    $idt_cliente = ($row_aa['idt_cliente']);
    $assunto = ($row_aa['assunto']);
    $data_inicio_atendimento = ($data);
    $data_termino_atendimento = ($data);
    $horas_atendimento = ($horas_atendimentow);
    $idt_empresa = ($row_aa['idt_empresa']);
    $senha_totem = ($row_aa['senha_totem']);
    $data = $row_aa['data'];
    $hora = $row_aa['hora'];
}



$sql2 = 'select ';
$sql2 .= '  grc_a.*   ';
$sql2 .= '  from grc_atendimento grc_a ';
$sql2 .= '  where grc_a.idt_atendimento_agenda = '.null($idt_atendimento_agenda);
$rs_aap = execsql($sql2);
$idt_atendimento = 0;
if ($rs_aap->rows == 0) {
    
} else {
    ForEach ($rs_aap->data as $row) {
        $idt_atendimento = $row['idt'];
        $protocolo = $row['protocolo'];
        $idt_instrumento = $row['idt_instrumento'];
        $_GET['distancia'] = $row['origem'];
    }
}

define('origem_at', $_GET['distancia']);

//echo " ttttttttttttttttttttt ==== {$idt_atendimento}<br /> ";
//    if ($idt_cliente>0)
//if ($cpf!=0)
if ($cpf != "" or $opcao == 'inc') {
    // tem pessoa associada
    // Marcada
    // Verifica se tem atendimento com senha
    if ($senha_totem != "") {
        // Cliente com senha
        // acessa registro do atendimento
        $sql2 = 'select ';
        $sql2 .= '  grc_a.*   ';
        $sql2 .= '  from grc_atendimento grc_a ';
        $sql2 .= '  where grc_a.idt_atendimento_agenda = '.null($idt_atendimento_agenda);
        $rs_aap = execsql($sql2);
        $idt_atendimento = 0;
        if ($rs_aap->rows == 0) {
            
        } else {
            ForEach ($rs_aap->data as $row) {
                $idt_atendimento = $row['idt'];
                $protocolo = $row['protocolo'];
            }

            $qtdrepresentantes = 0;
            $sqlx = 'select ';
            $sqlx .= '  grc_a.*   ';
            $sqlx .= '  from grc_atendimento_pessoa grc_a ';
            $sqlx .= '  where grc_a.idt_atendimento = '.null($idt_atendimento);
            $rs_aapx = execsql($sqlx);
            $idt_representante_lider = 0;
            if ($rs_aap->rows == 0) {
                // erro
            } else {
                ForEach ($rs_aap->data as $row) {
                    $qtdrepresentantes = $qtdrepresentantes + 1;
                    $idt_atendimento_pessoa = $row['idt'];
                    $tipo_relacao = $row['tipo_relacao'];
                    if ($tipo_relacao == 'L') {
                        $idt_representante_lider = $tipo_relacao;
                    }
                }
            }


            $qtdempreendimentos = 0;
            $idt_atendimento_organizacao = 0;
            $sqlx = 'select ';
            $sqlx .= '  grc_ao.*   ';
            $sqlx .= '  from grc_atendimento_organizacao grc_ao ';
            $sqlx .= '  where grc_ao.idt_atendimento = '.null($idt_atendimento);
            $rs_aapx = execsql($sqlx);
            if ($rs_aapx->rows == 0) {
                // erro
            } else {
                ForEach ($rs_aapx->data as $rowx) {
                    $qtdempreendimentos = $qtdempreendimentos + 1;
                    $idt_atendimento_organizacao = $rowx['idt'];
                }
            }
        }
        //
        //  Acessa registro do Painel
        //
            $sql2 = 'select ';
        $sql2 .= '  grc_aap.*   ';
        $sql2 .= '  from grc_atendimento_agenda_painel grc_aap ';
        $sql2 .= '  where grc_aap.idt_atendimento_agenda = '.null($idt_atendimento_agenda);
        $rs_aap = execsql($sql2);
        $status_painel = "";
        if ($rs_aap->rows == 0) {
            
        } else {
            $temsenha = 1;
            ForEach ($rs_aap->data as $row) {
                $status_painel = $row['status_painel'];
            }
        }
    } else {
        //
        // Agendado sem senha
        // Cliente esta agendado mas não tem senha
        //
            // Proceder Solicitação de Senha.....
        $temsenha = 2;
    }
} else {
    // sem pessoa associada Horário sem marcação
    // Mensagem de entrada indevida
    $temsenha = 9;
}





$esconde_telas = "";
if (substr($senha_totem, 0, 2) == 'CH') {
    $session_volta = 'avulso';

    if ($aba == 1) {
        echo "<div class='chama_sem'>";
        echo "<div class='' style='color:#FFFFFF; xdisplay:none; '>";
        //echo "ATENDER CLIENTE SEM SENHA - ORDEM DE CHEGADA";

        if ($idt_instrumento == 8) {   // informação
            echo "INFORMAÇÃO";
        }
        if ($idt_instrumento == 13) {   // orientação técnica
            echo "ORIENTAÇÃO TÉCNICA";
        }
        if ($idt_instrumento == 2) {   // consultoria
            echo "CONSULTORIA";
        }

        echo " - PRIMEIRA VISITA</div>";

        echo "</div>";
    }

    if ($cpf == "" and $opcao == 'inc') {
        echo "<div class='chama_sem_cpf' style='display:none; '> ";
        $nofinal = " onblur = 'return Valida_CPF(this);' ";
        $formatar = " onkeyup='return Formata_Cpf(this,event);' ";
        echo "<div style='float:left; padding-top:80px; padding-left:100px; '>";
        echo "FAVOR INFORMAR O CPF DO CLIENTE: <input id='cpf_novo' type='text' $nofinal $formatar name='btcpf' class='cpf_novo_c' value='' /> ";
        echo "</div>";

        $onclick = " onclick='return BuscaCPF({$idt_atendimento});' ";
        echo "<div style='float:left; padding-top:80px;  padding-left:10px; '    >";
        echo " <span {$onclick} style='cursor:pointer; font-size:16px;'><img  width='30' height='30'  src='imagens/pesquisar_cpf.png' border='0' /></span> ";
        echo "</div>";

        echo "</div>";
        //$esconde_telas=" display:none; ";

        $esconde_telas = "";
    }

    $temsenha = 1;
} else {
    echo "<div class='chama'>";
    echo "<div class='' style='color:#FFFFFF;'>";
    echo "ATENDER CLIENTE";
    echo "</div>";
    echo "</div>";
}

echo "<div style='{$esconde_telas}'>";  // tudo



echo "<div class='chama_cab' style='display:none;' >";

echo "<table border='0' cellpadding='0' width='100%' cellspacing='0' class=''>";

// linha 1
echo "<tr>";

echo "<td  class='titulo_cab1' style=''>";
echo "CPF: ";
echo "</td>";
echo "<td  class='titulo_txt1' style=''>";
echo $cpf;
echo "</td>";




echo "<td  class='titulo_cab1' style=''>";
echo "CLIENTE:";
echo "</td>";

echo "<td  class='titulo_txt1' style=''>";
echo $cliente_texto;
echo "</td>";

echo "<td  class='titulo_cab1' style=''>";
echo "SENHA:";
echo "</td>";
echo "<td  class='titulo_txt1' style=''>";
echo "$senha_totem";
echo "</td>";
//
echo "</tr>";
// linha 2
echo "<tr>";

echo "<td  class='titulo_cab1' style=''>";
echo "CNPJ:";
echo "</td>";
echo "<td  class='titulo_txt1' style=''>";
echo $cnpj;
echo "</td>";

echo "<td  class='titulo_cab1' style=''>";
echo "EMPREENDIMENTO:";
echo "</td>";

echo "<td  class='titulo_txt1' style=''>";
echo $nome_empresa;
echo "</td>";

echo "<td  class='titulo_cab1' style=''>";
echo "PROTOCOLO:";
echo "</td>";

echo "<td  class='titulo_txt1' style=''>";
echo $protocolo;
echo "</td>";


echo "</tr>";

echo "</table>";


echo "</div>";

$_GET['session_volta'] = $session_volta;

$class_aba1 = 'class="pointer"';
$class_aba2 = 'class="pointer"';

$click_aba1 = "";
$click_aba2 = "";

echo " <div  id='atendimento_s' style='width:100%; display:none; xdisplay:block; color:#000000; float:left; border-top:1px solid #ABBBBF; border-bottom:1px solid #ABBBBF;'>";


if ($aba == 1) {
    $class_aba1 = 'class="aba_ativo"';
    $click_aba2 = "onclick=\"$(':submit:first').click();\"";
} else {
    $class_aba2 = 'class="aba_ativo"';
    $click_aba1 = "onclick=\"$(':submit:first').click();\"";
}



$tamdiv = 80;
$largura = 64;
$altura = 64;


$fsize = '10px';
$tampadimg = $tamdiv - $largura;
$tamlabel = $tamdiv + $tampadimg;
$tamdiv = ($tamdiv + 16).'px';
$label = $tamlabel.'px';
$pad = $tampadimg.'px';
$padimg = $tampadimg.'px';
$tit_1 = "Acessar Atendimento";





echo " <div  {$class_aba1} {$click_aba1} id='atendimento_s2' style='width:$tamdiv; color:#000000; float:left; xborder-top:1px solid #ABBBBF; xborder-bottom:1px solid #ABBBBF; '>";

echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px; '   >";
echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_1}' src='imagens/dados_clientes.png' border='0'>";
echo "</div>";
echo "<div title='{$tit_1}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
echo " Cadastro Clientes e Empreendimento";
echo "</div>";

echo " </div>";




//echo " <div  {$onclick1} id='atendimento_s1' style='cursor:pointer; float:left; padding-left:10px;'>";
echo " <div  {$class_aba2} {$click_aba2} id='atendimento_s1' style='width:$tamdiv; color:#000000; float:left; xborder-top:1px solid #ABBBBF; xborder-bottom:1px solid #ABBBBF; '>";

//echo " esconde cadastro ";

echo "<div style='float:left; padding:{$pad}; padding-top:5px; padding-bottom:5px; '   >";
echo " <img width='{$largura}'  height='{$altura}'  title='{$tit_1}' src='imagens/atender_cliente_2.png' border='0'>";
echo "</div>";
echo "<div title='{$tit_1}' style='width:{$label};  overflow:auto; display:block; float:left; text-align:center; font-size:{$fsize};  '>";
echo " Atender Cliente";
echo "</div>";
echo " </div>";




echo " </div>";



if ($aba == 1) {
    $esconde1 = '';
    $esconde2 = ' display:none;';
} else {

    $esconde1 = ' display:none;';
    $esconde2 = '';
}

echo " <div id='cadastro_cliente' style=' {$esconde1}'>";

if ($temsenha == 9) {   // sem pessoa associada
    echo " <div class='botao_ag'  >";
    echo " <div style='margin:15px; '>AGENDA ABERTA. SEM CLIENTE ASSOCIADO.</div>";
    echo " </div>";
} else {
    if ($temsenha == 1) {   // tem senha associada - chamar cadastro
        $veio = 255;
        $menu = 'grc_nan_visita_1_cadastro';
        $prefixo = 'cadastro';



        $_GET['idt_atendimento_organizacao'] = $idt_atendimento_organizacao;
        $_GET['representantes'] = $qtdrepresentantes;
        $_GET['cnpj'] = $cnpj;
        //$_GET['idt0']            = $idt_atendimento_agenda;
        $_GET['idt0'] = $idt_atendimento;
        $_GET['idt_atendimento'] = $idt_atendimento;
        $_GET['id'] = $idt_atendimento;
        $_GET['veio'] = $veio;
        $_GET['menu'] = $menu;
        $_GET['acao'] = $acao;
        $_GET['prefixo'] = $prefixo;

        if ($aba == 1) {
            Require_once('cadastro.php');
        }
    } else {
        if ($temsenha == 2) {   // Proceder solicitação da senha
            echo " <div class='botao_ag'  >";
            echo " <div style='margin:15px; '>Cliente sem SENHA Solicitar SENHA AGORA?</div>";
            echo " </div>";
        } else {
            // nada selecionado
            // sair erro
            echo " <div class='botao_ag'  >";
            echo " <div style='margin:15px; '>Erro. NADA SOLICITADO.</div>";
            echo " </div>";
        }
    }
}


//     Voltar
echo " <div id='termina_atd' style='display:none; '  class='botao_ag' onclick='return VoltarAtendimento();' >";
echo " <div style='margin:15px; '>Voltar</div>";
echo " </div>";

echo " </div>";




echo " <div id='atendimento_cliente' style=' {$esconde2}'>";

//self.location = 'conteudo.php?prefixo=cadastro&menu=grc_atendimento&instrumento=2&instrumento2=2&acao=alt&idt_atendimento_agenda='+idt_atendimento_agenda+'&id='+idt_atendimento;


if ($aba == 2) {
    $veio = 255;
    $menu = 'grc_nan_visita_1';
    $prefixo = 'cadastro';

//
    $_GET['instrumento'] = 2;
    $_GET['instrumento2'] = 2;
    $_GET['idt_atendimento_agenda'] = $idt_atendimento_agenda;
    $_GET['idt0'] = $idt_atendimento;
    $_GET['idt_atendimento'] = $idt_atendimento;
    $_GET['id'] = $idt_atendimento;
    $_GET['veio'] = $veio;
    $_GET['menu'] = $menu;
    $_GET['acao'] = $acao;
    $_GET['prefixo'] = $prefixo;
    Require_once('cadastro.php');
}


if ($aba == 3) {
    define('nan', 'S');
    $menu = 'grc_avaliacao_resposta';
    $prefixo = 'cadastro';
    $_GET['menu'] = $menu;
    $_GET['prefixo'] = $prefixo;
    Require_once('cadastro.php');
}

echo " </div>";



echo " </div>";    // tudo
//$_GET['opcao'] = '';
?>

<script type="text/javascript">
    var sem_registro = '<?php echo ($sem_registro ? 'S' : 'N'); ?>';
    var EnderecoRefresh = '<?php echo $EnderecoRefresh; ?>';
    var aba = '<?php echo $aba; ?>';
    var idt_atendimento = '<?php echo $idt_atendimento; ?>';
    var idt_atendimento_agenda = '<?php echo $idt_atendimento_agenda; ?>';
    var trava_cpf = '<?php echo (substr($senha_totem, 0, 2) == 'CH' ? 'N' : 'S'); ?>';

    $(document).ready(function () {
        if ($('#cpf').val() == '') {
            var campo = $("#cpf,#nome,#idt_segmentacao,#idt_subsegmentacao,#idt_programa_fidelidade");
            var obr = $("#cpf_desc,#nome_desc");

            func_AtivaDesativa('S', "S".split(","), campo, obr, "".split(","), "N", "N");

            campo = $("#idt_segmentacao, #idt_subsegmentacao,#idt_programa_fidelidade");
            var opt = campo.find('option');
            opt.prop("disabled", true);
            opt.addClass("campo_disabled");
        }

        if ($('#cpf').length == 1) {
            if (trava_cpf == 'S') {
                $('#cpf').prop("disabled", true).addClass("campo_disabled");
                btAcaoCPF.remove();
                $('#nome').focus();
            } else {
                $('#cpf').focus();
            }
        }
    });

    function VoltarAtendimento()
    {
        self.location = "<?php echo $_SESSION[CS]['grc_nan_visita_1_'.$session_volta]; ?>";
        return false;
    }

    function EscondeCadastro()
    {
        var id = 'cadastro_cliente';
        objd = document.getElementById(id);
        if (objd != null)
        {
            // $(objd).toggle();
        }

        var href = "conteudo.php?prefixo=inc&menu=grc_nan_visita_1&idt_atendimento_agenda=" + idt_atendimento_agenda + "&idt_atendimento=" + idt_atendimento + "&id=" + idt_atendimento_agenda + "&aba=2";
        self.location = href;


        return false;

    }

    function EscondeAtendimento()
    {
        var id = 'atendimento_cliente';
        objd = document.getElementById(id);
        if (objd != null)
        {
            // $(objd).toggle();
        }
        var href = "conteudo.php?prefixo=inc&menu=grc_nan_visita_1&idt_atendimento_agenda=" + idt_atendimento_agenda + "&idt_atendimento=" + idt_atendimento + "&id=" + idt_atendimento_agenda + "&aba=1";
        self.location = href;
        return false;

    }

    function BuscaCPF(idt_atendimento)
    {
        var cpf = "";
        var id = 'cpf_novo';
        objd = document.getElementById(id);
        if (objd != null)
        {
            cpf = objd.value;
        }
        if (cpf == '')
        {
            alert('Por favor, informar o CPF do Cliente.');
            return false;
        }

        $.ajax({
            type: 'POST',
            url: 'ajax_atendimento.php?tipo=BuscaCPF',
            data: {
                idt_atendimento: idt_atendimento,
                cpf: cpf
            },
            beforeSend: function () {
                processando();
            },
            complete: function () {
                $("#dialog-processando").remove();
            },
            success: function (response) {
                if (response != '') {
                    $("#dialog-processando").remove();
                    alert(url_decode(response));
                } else
                {   // Refresh na tela
                    // alert('Cliente com CPF '+cpf+' Encontrado.'+"\n"+'');
                    //location.reload();
                    self.location = EnderecoRefresh;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#dialog-processando").remove();
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });




//alert('teste...');


    }

</script>