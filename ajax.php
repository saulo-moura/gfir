<?php
Require_Once('configuracao.php');

switch ($_GET['tipo']) {
    case 'desvio_orc':
        Require_Once('incdesvio_orcamento.php');
        break;
    case 'desvio_demo':
        Require_Once('incdemonstrativo.php');
        break;
    case 'desvio_demo2':
        Require_Once('incdemonstrativo2.php');
        break;
    case 'desvio_rota':
        Require_Once('incrotatividade.php');
        break;

    case 'desvio_iv':
        Require_Once('incinventario.php');
        break;

    case 'desvio_im':
        Require_Once('incimobilizado.php');
        break;

    case 'pessoal_efetivo':
        Require_Once('incpessoal_efetivo.php');
        break;
    case 'fluxo_financeiro':
        Require_Once('incfluxo_financeiro.php');
        break;
    case 'ge_fluxo_financeiro':
        Require_Once('incge_fluxo_financeiro.php');
        break;

    case 'indice_projeto':
        Require_Once('incindice_projeto.php');
        break;


    case 'hora_extra':
        Require_Once('inchora_extra.php');
        break;

    case 'obra':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $_SESSION[CS]['g_idt_obra'] = $idt_obra;
        $_SESSION[CS]['g_nm_obra'] = $nm_obra;
        $sql = "select 	      ";
        $sql .= "     em.*       ";
        $sql .= " from empreendimento em ";
        $sql .= " where idt = ".$_SESSION[CS]['g_idt_obra'];
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $path = $dir_file.'/empreendimento/';
            $_SESSION[CS]['g_path_logo_obra'] = $path;
            $_SESSION[CS]['g_imagem_logo_obra'] = $row['imagem'];
            $_SESSION[CS]['g_nm_obra'] = $row['descricao'];
            $_SESSION[CS]['g_obra_orc_real'] = $row['orcamento_real'];
            $_SESSION[CS]['g_obra_orc_incc'] = $row['orcamento_incc'];
            $vetper = Array();
            //$vetper[]=' guy 1';

            $_SESSION[CS]['g_indicador_fluxo_financeiro'] = $row['indicador_fluxo_financeiro'];
            $_SESSION[CS]['g_ativo'] = $row['ativo'];


            $_SESSION[CS]['data_incc_obra_dia'] = $row['data_incc_obra_dia'];
            $_SESSION[CS]['data_incc_obra_mes'] = $row['data_incc_obra_mes'];
            $_SESSION[CS]['data_incc_obra_ano'] = $row['data_incc_obra_ano'];


            $_SESSION[CS]['g_periodo_obra'] = '';
           // $vetper = calculaperiodoobra($row, 1);
            $_SESSION[CS]['g_periodo_obra'] = $vetper;
           // $vetper = calculaperiodoobra($row, 2);
            $_SESSION[CS]['g_periodo_obra_fl'] = $vetper;

            menu_obra($_SESSION[CS]['g_idt_obra']);
        }
        break;


    case 'obra_ge':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $_SESSION[CS]['g_idt_obra_ge'] = $idt_obra;
        $_SESSION[CS]['g_nm_obra_ge'] = $nm_obra;
        $sql = "select 	      ";
        $sql .= "     em.*       ";
        $sql .= " from empreendimento em ";
        $sql .= " where idt = ".$_SESSION[CS]['g_idt_obra_ge'];
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $path = $dir_file.'/empreendimento/';
            $_SESSION[CS]['g_path_logo_obra_ge'] = $path;
            $_SESSION[CS]['g_imagem_logo_obra_ge'] = $row['imagem'];
            

            $_SESSION[CS]['g_nm_obra_ge'] = $row['descricao'];
            $_SESSION[CS]['g_obra_orc_real'] = $row['orcamento_real'];
            $_SESSION[CS]['g_obra_orc_incc'] = $row['orcamento_incc'];
            $vetper = Array();
            //$vetper[]=' guy 1';

            $_SESSION[CS]['g_indicador_fluxo_financeiro'] = $row['indicador_fluxo_financeiro'];
            $_SESSION[CS]['g_ativo'] = $row['ativo'];


            $_SESSION[CS]['data_incc_obra_dia'] = $row['data_incc_obra_dia'];
            $_SESSION[CS]['data_incc_obra_mes'] = $row['data_incc_obra_mes'];
            $_SESSION[CS]['data_incc_obra_ano'] = $row['data_incc_obra_ano'];


            $_SESSION[CS]['g_periodo_obra'] = '';
            $vetper = calculaperiodoobra($row, 1);
            $_SESSION[CS]['g_periodo_obra'] = $vetper;
            $vetper = calculaperiodoobra($row, 2);
            $_SESSION[CS]['g_periodo_obra_fl'] = $vetper;

            // menu_obra($_SESSION[CS]['g_idt_obra']);
        }
        break;



    case 'pertx':
        $valorw = $_POST['valorw'];
        $prev_gw = $_POST['prev_gw'];
        $idt_gw = $_POST['idt_gw'];
        $idt_servico_obra_mes = $idt_gw;
        $flag_valor = $prev_gw;
        $valor = $valorw;
        if ($valor != '') {
            $sql_a = ' update servico_obra_mes_valor set ';
            $sql_a .= ' valor = '.$valor.'  ';
            $sql_a .= ' where idt_servico_obra_mes = '.null($idt_gw);
            $sql_a .= '   and flag_valor           = '.aspa($flag_valor);
            $result = execsql($sql_a);
        }
        //echo $sql_a;
        break;


    case 'aditivo':
        $idt_contrato = $_POST['idt_contrato'];
        //echo ' Contrato sem Aditivos '.$idt_contrato;
        $sql = 'select ';
        $sql .= '  coa.*, ';
        $sql .= '  ta.descricao as ta_descricao, ';
        $sql .= '  ta.codigo    as ta_codigo_aditivo ';
        $sql .= 'from contrato_aditivo coa ';
        $sql .= 'inner join tipo_aditivo ta on ta.idt  = coa.idt_tipo_aditivo ';
        $sql .= 'where ';
        $sql .= '      coa.idt_contrato = '.null($idt_contrato);
        $rs = execsql($sql);
        if ($rs->rows == 0) {
            echo ' Contrato sem Aditivos ';
        } else {

            echo "<table id='datatable' class='tabela_lista' width='99%' border='0' cellspacing='4' cellpadding='4' vspace='0' hspace='0'> ";
            echo "<tr class='cabecalho_lista'>  ";
            echo "   <td class='cabecalho_campo'>NÚMERO</td> ";
            echo "   <td class='cabecalho_campo'>DESCRIÇÃO</td> ";
            echo "   <td class='cabecalho_campo'>TIPO</td> ";
            echo "   <td class='cabecalho_campo'>DATA<br>ADITIVO</td> ";
            echo "   <td class='cabecalho_campo'>VALOR EM R$</td> ";
            echo "   <td class='cabecalho_campo'>DATA<br>ADITIVADA</td> ";
            echo " </tr> ";

            ForEach ($rs->data as $row) {
                $numero = $row['numero'];
                $descricao = $row['descricao'];
                $ta_descricao = $row['ta_descricao'];
                $valor = format_decimal($row['valor']);

                $data_aditivo = trata_data($row['data_aditivo']);
                $data_fim = trata_data($row['data_fim']);

                $codigo_aditivo = $row['ta_codigo_aditivo'];
                echo "<tr class='linha_lista'>";
                echo "<td class='linha_campo' >".$numero."&nbsp;</td>";
                echo "<td class='linha_campo' >".$descricao."&nbsp;</td>";
                echo "<td class='linha_campo' >".$ta_descricao."&nbsp;</td>";
                echo "<td class='linha_campo' >".$data_aditivo."&nbsp;</td>";

                if ($codigo_aditivo != '') {
                    echo "<td class='linha_campo' >".$valor."&nbsp;</td>";
                    echo "<td class='linha_campo' >".$data_fim."&nbsp;</td>";
                } else {
                    echo "<td class='linha_campo' >".$valor."&nbsp;</td>";
                    echo "<td class='linha_campo' >".$data_fim."&nbsp;</td>";
                }
                echo "</tr>";
            }
        }
        break;


    case 'chama_edoc_contrato':
        $idt_contrato = $_POST['idt_contrato'];
        //echo ' Contrato sem Aditivos '.$idt_contrato;
        $sql = 'select ';
        $sql .= '  co.* ';
        $sql .= 'from contrato co ';
        $sql .= 'where ';
        $sql .= '      co.idt = '.null($idt_contrato);
        $rs = execsql($sql);
        if ($rs->rows == 0) {
            echo ' Contrato não encontrado ';
        } else {
            ForEach ($rs->data as $row) {
                //echo ' numero contrato = '.$row['numero'];
                $numero_contrato = $row['numero'];
                $idt_empreendimento_posicionar = $row['idt_empreendimento'];
                $path = 'incedoc_contratos.php';
                if (file_exists($path)) {
                    Require_Once($path);
                } else {
                    echo "<br><br><div align='center' class='Msg'>Função em desenvolvimento...</div>";
                }
            }
        }
        break;





    case 'lista_preco':
        $idt_servico = $_POST['idt_servico'];
        //echo ' Contrato sem Aditivos '.$idt_contrato;
        $sql = 'select ';
        $sql .= '  cs.observacao as cs_observacao ';
        $sql .= 'from contrato_servico  cs ';
        $sql .= 'where ';
        $sql .= '      cs.idt = '.null($idt_servico);
        $rs = execsql($sql);
        if ($rs->rows == 0) {
            echo ' Preço sem Especificação ';
        } else {

            echo "<table id='datatable' class='tabela_lista' width='99%' border='0' cellspacing='4' cellpadding='4' vspace='0' hspace='0'> ";
            // echo "<tr class='cabecalho_lista'>  ";
            // echo "   <td class='cabecalho_campo'>ESPECIFICAÇÃO DO PREÇO</td> ";
            // echo " </tr> ";

            ForEach ($rs->data as $row) {
                $cs_observacao = $row['cs_observacao'];
                echo "<tr class='linha_lista'>";
                if ($cs_observacao == '') {
                    $cs_observacao = ' Especificações sobre o preço não informados';
                }
                echo "<td class='linha_campo' >".$cs_observacao."&nbsp;</td>";
                echo "</tr>";
            }
        }
        break;


    case 'assinatura':

        $idt_obra = $_POST['idt_obra'];
        $idt_usuario = $_POST['idt_usuario'];
        $chave = $_POST['chave'];
        $vet_ocorr = Array();
        $ret = assina_tela($idt_obra, $idt_usuario, $chave, $vet_ocorr);
        if ($ret == 0) {
            $erro = $vet_ocorr['erro'];
            echo $erro;
        } else {

            $vetMenuAss_nome = Array();
            $vetMenuAss_data = Array();
            $vetMenuAss_nome2 = Array();
            $vetMenuAss_data2 = Array();

            ForEach ($_SESSION[CS]['g_vetMenuAss'] as $mm_site => $cod_assinatura) {
                if ($cod_assinatura != '') {
                    // última assinatura
                    $sql = 'select ';
                    $sql .= '     at.*, ';

                    $sql .= '     at.assinatura as at_assinatura, ';
                    $sql .= '     us.nome_completo as us_nome ';
                    $sql .= ' from assina_tela at ';
                    $sql .= ' inner join usuario us on us.id_usuario =  at.idt_usuario';
                    $sql .= ' where ';
                    $sql .= '      at.idt_empreendimento = '.null($idt_obra);
                    ;
                    $sql .= "   and at.status='F' ";
                    $sql .= "   and at.assinatura = ".aspa($cod_assinatura);
                    $sql .= ' order by data desc , versao desc ';
                    //   $sql .= ' LIMIT 2  ';
                    //  p($sql);
                    $rs = execsql($sql);
                    $nome_assinante = '';
                    $data_assinante = '';
                    $nome_assinante2 = '';
                    $data_assinante2 = '';
                    $idt_assina_controle = 0;
                    $qt = 0;
                    ForEach ($rs->data as $row) {
                        $qt = $qt + 1;
                        if ($qt > 1) {
                            if ($idt_assina_controle == $row['idt_assina_controle'] and
                                    $row['us_nome'] != $nome_assinante) {
                                $nome_assinante2 = $row['us_nome'];
                                $data_assinante2 = trata_data($row['data']);
                                break;
                            } else {
                                if ($idt_assina_controle != $row['idt_assina_controle']) {
                                    break;
                                }
                            }
                        } else {
                            // $data_assinante    =  substr(trata_data($row['data']),0,10);
                            $data_assinante = trata_data($row['data']);
                            $versao = $row['versao'];
                            $nome_assinante = $row['us_nome'];
                            $idt_assina_controle = $row['idt_assina_controle'];
                            $at_assinatura = $row['at_assinatura'];
                        }
                        /*
                          //  $data_assinante    = substr(trata_data($row['data']),0,10);
                          $data_assinante    = trata_data($row['data']);
                          $versao            = $row['versao'];
                          $nome_assinante    = $row['us_nome'];
                          $at_assinatura     = $row['at_assinatura'];
                          //break;
                         */
                    }
                    if ($at_assinatura == $chave) {
                        $texto_assina = 'Assinado por '.$nome_assinante.' em '.$data_assinante;
                        if ($nome_assinante2 != '') {
                            $texto_assina.=' e '.$nome_assinante2.' em '.$data_assinante2;
                        }
                    }
                    $vetMenuAss_nome[$mm_site] = $nome_assinante;
                    $vetMenuAss_data[$mm_site] = $data_assinante;

                    $vetMenuAss_nome2[$mm_site] = $nome_assinante2;
                    $vetMenuAss_data2[$mm_site] = $data_assinante2;
                }
            }

            $_SESSION[CS]['g_vetMenuAss_nome_ass'] = $vetMenuAss_nome;
            $_SESSION[CS]['g_vetMenuAss_data_ass'] = $vetMenuAss_data;

            $_SESSION[CS]['g_vetMenuAss_nome_ass2'] = $vetMenuAss_nome2;
            $_SESSION[CS]['g_vetMenuAss_data_ass2'] = $vetMenuAss_data2;


            $complementa = '<br/><br/>'.$texto_assina;
            $msg = $vet_ocorr['msg'].$complementa;
            echo $msg;
        }
        break;

    case 'assinatura_tela':

        $idt_obra = $_POST['idt_obra'];
        $idt_usuario = $_POST['idt_usuario'];
        $cod_assinatura = $_POST['chave'];
        // última assinatura
        $sql = 'select ';
        $sql .= '     at.*, ';
        $sql .= '     us.nome_completo as us_nome ';
        $sql .= ' from assina_tela at ';
        $sql .= ' inner join usuario us on us.id_usuario =  at.idt_usuario';
        $sql .= ' where ';
        $sql .= '      at.idt_empreendimento = '.null($idt_obra);
        ;
        $sql .= "   and at.status='F' ";
        $sql .= "   and at.assinatura = ".aspa($cod_assinatura);
        $sql .= ' order by data desc , versao desc ';
        //  p($sql);
        $rs = execsql($sql);
        $nome_assinante = '';
        $data_assinante = '';

        $nome_assinante2 = '';
        $data_assinante2 = '';
        $idt_assina_controle = 0;
        $qt = 0;
        // $vetMenuAss_nome=Array();
        // $vetMenuAss_data=Array();
        // $vetMenuAss_nome2=Array();
        // $vetMenuAss_data2=Array();

        ForEach ($rs->data as $row) {
            //       $data_assinante    = trata_data($row['data']);
            //       $versao            = $row['versao'];
            //       $nome_assinante    = $row['us_nome'];

            $qt = $qt + 1;
            if ($qt > 1) {
                if ($idt_assina_controle == $row['idt_assina_controle'] and
                        $row['us_nome'] != $nome_assinante) {
                    $nome_assinante2 = $row['us_nome'];
                    $data_assinante2 = trata_data($row['data']);
                    break;
                } else {
                    if ($idt_assina_controle != $row['idt_assina_controle']) {
                        break;
                    }
                }
            } else {
                // $data_assinante    =  substr(trata_data($row['data']),0,10);
                $data_assinante = trata_data($row['data']);
                $versao = $row['versao'];
                $nome_assinante = $row['us_nome'];
                $idt_assina_controle = $row['idt_assina_controle'];
                $at_assinatura = $row['at_assinatura'];
            }
//          break;
        }
        //       $texto_assina='Assinado por '.$nome_assinante.' em '.$data_assinante;

        if ($at_assinatura == $chave) {
            $texto_assina = 'Assinado por '.$nome_assinante.' em '.$data_assinante;
            if ($nome_assinante2 != '') {
                $texto_assina.=' e '.$nome_assinante2.' em '.$data_assinante2;
            }
        }
        //           $vetMenuAss_nome[$mm_site]=$nome_assinante;
        //           $vetMenuAss_data[$mm_site]=$data_assinante;
        //           $vetMenuAss_nome2[$mm_site]=$nome_assinante2;
        //           $vetMenuAss_data2[$mm_site]=$data_assinante2;
        //$_SESSION[CS]['g_vetMenuAss_nome_ass'] = $vetMenuAss_nome;
        //$_SESSION[CS]['g_vetMenuAss_data_ass'] = $vetMenuAss_data;
        //$_SESSION[CS]['g_vetMenuAss_nome_ass2'] = $vetMenuAss_nome2;
        //$_SESSION[CS]['g_vetMenuAss_data_ass2'] = $vetMenuAss_data2;

        echo $texto_assina;
        break;

    case 'acidente_pdf':
        //
        $html = $_POST['htmlw'];
        //
        //$vet = explode('/', $_SERVER['SCRIPT_FILENAME']);
        //array_pop($vet);
        //$path_local = implode('/', $vet)."/admin/obj_file/graficos/";
        $path_local = "admin/obj_file/graficos/";
        $obra = $_SESSION[CS]['g_idt_obra'];
        //
        $html = '';
        $html .= ' <style type="text/css"> ';
        $html .= ' .pg_pdf { ';
        $html .= '    width:100%; ';
        $html .= ' } ';
        $html .= ' </style> ';

        $html .= ' <div class="pg_pdf" > ';
        $html .= "<img  src='{$path_local}img_{$obra}1.jpg' border='0' />";
        $html .= '      </div>  ';

        $html .= ' <div class="pg_pdf" > ';
        //  $html .= "<img  src='{$path_local}img_{$obra}2.jpg' border='0' rotate='-90' />";
        $html .= "<img  src='{$path_local}img_{$obra}2.jpg' border='0'  />";
        $html .= '      </div>  ';

        $html .= ' <div class="pg_pdf" > ';
        $html .= "<img  src='{$path_local}img_{$obra}4.jpg' border='0'  />";
        $html .= '      </div>  ';

        $html .= ' <div class="pg_pdf" > ';
        $html .= "<img  src='{$path_local}img_{$obra}31.jpg' border='0'  />";
        $html .= '      </div>  ';

        $html .= ' <div class="pg_pdf" > ';
        $html .= "<img  src='{$path_local}img_{$obra}32.jpg' border='0'  />";
        $html .= '      </div>  ';

        $html .= ' <div class="pg_pdf" > ';
        $html .= "<img  src='{$path_local}img_{$obra}33.jpg' border='0'  />";
        $html .= '      </div>  ';

        // $html .= ' <div class="pg_pdf" > ';
        // $html .= "<img  src='{$path_local}img_{$obra}34.jpg' border='0' />";
        // $html .= '      </div>  ';
        // $_GET['html_ger'] = 1;
        // $_GET['opcao']    = 1;
        // $_GET['parimg']   = '';
        // $html        = '';
        // $path        ='incseguranca_trabalho.php';
        // Require_Once($path);
        // $html        =       utf8_encode($out1);

        $_SESSION[CS]['g_html_acidente'] = $html;

        //$path        ='incacidente_pdf.php';
        //Require_Once($path);
        break;

    case 'executa_gerar_graficos_servidor':

        $par        = $_POST['parw'];
        $output     = Array();
        $return_var = 0;

        $kposw = strpos($_SERVER['SCRIPT_FILENAME'],'/');
//        $sepdir = $_SERVER['DIRECTORY_SEPARATOR'].
        if   ($kposw>0)
        {                //  DIRECTORY_SEPARATOR
            $vet = explode('/', $_SERVER['SCRIPT_FILENAME']);
            array_pop($vet);
            $path_local = implode('/', $vet)."/admin/obj_file/graficos/";
        }
        else
        {  // barra esta invertida
           $vet = explode('\\', $_SERVER['SCRIPT_FILENAME']);
           array_pop($vet);
           $path_local = implode('\\', $vet)."\\admin\\obj_file\\graficos\\";
        }

        //$path_php   = url;
        
        $path_php = 'http://'.$_SERVER['SERVER_NAME'].'/'.array_pop($vet).'/';
        
        $obra       = $_SESSION[CS]['g_idt_obra'];

        $pg1 = "#path_localCutyCapt --url=#path_phpconteudo_rsqsms1.php?parimg=#obra,1,0  --out=#path_localimg_#obra1.jpg --print-backgrounds=on"."###";
        $pg1 .= "#path_localCutyCapt --url=#path_phpconteudo_rsqsms1.php?parimg=#obra,2,0  --out=#path_localimg_#obra2.jpg --print-backgrounds=on"."###";
        $pg1 .= "#path_localCutyCapt --url=#path_phpconteudo_rsqsms1.php?parimg=#obra,3,1  --out=#path_localimg_#obra31.jpg --print-backgrounds=on"."###";
        $pg1 .= "#path_localCutyCapt --url=#path_phpconteudo_rsqsms1.php?parimg=#obra,3,2  --out=#path_localimg_#obra32.jpg --print-backgrounds=on"."###";
        $pg1 .= "#path_localCutyCapt --url=#path_phpconteudo_rsqsms1.php?parimg=#obra,3,3  --out=#path_localimg_#obra33.jpg --print-backgrounds=on"."###";
        $pg1 .= "#path_localCutyCapt --url=#path_phpconteudo_rsqsms1.php?parimg=#obra,4,0  --out=#path_localimg_#obra4.jpg --print-backgrounds=on"."###";


        $pg1w = str_replace('#path_local', $path_local, $pg1);
        $pg1w = str_replace('#path_php', $path_php, $pg1w);
        $pg1w = str_replace('#obra', $obra, $pg1w);

        $vet_bat = Array();

        $vet_bat = explode('###', $pg1w);

        //  p($vet_bat);

        $file_name = $path_local.'print_screen.bat';
        $abrearqbat=0;
        try
        {
            $fd = fopen($file_name, 'w+'); // Abre o arquivo para Gravação, e se ele não existir será criado
            if (!$fd)
            {
                echo 'Geração dos Gráficos para PDF não obteve sucesso.<br />';
                echo 'Arquivo de Bat não pode ser gravado.<br />';
                echo 'Path : '.$file_name.'<br />';
            }
            else
            {
                $abrearqbat=1;
            }
        }
        catch (PDOException $e)
        {
            echo "Arquivo de bat não pode ser criado ".$file_name;
        }
        if  ($abrearqbat==1)
        {
            $content = $vet_bat[0]."\n";
            fwrite($fd, $content); // Abre o Arquivo para leitura
            $content = $vet_bat[1]."\n";
            fwrite($fd, $content); // Abre o Arquivo para leitura
            $content = $vet_bat[2]."\n";
            fwrite($fd, $content); // Abre o Arquivo para leitura
            $content = $vet_bat[3]."\n";
            fwrite($fd, $content); // Abre o Arquivo para leitura
            $content = $vet_bat[4]."\n";
            fwrite($fd, $content); // Abre o Arquivo para leitura
            $content = $vet_bat[5]."\n";
            fwrite($fd, $content); // Abre o Arquivo para leitura
            fclose($fd); // Fecha a variável
            //chmod($file_name, 0644); //Dá permissão ao dono fazer escrita no arquivo
            //  $command    = $path.'CutyCapt --url=http://localhost/oas_pco/conteudo_rsqsms1.php?parimg=18,1,0  --out=c:\wamp\www\oas_pco\admin\obj_file\graficos\guy1.png --print-backgrounds=on';
        }
        if (file_exists($file_name))
        {
            /* assim é com a bat
            $command = $path_local.'print_screen.bat';
            set_time_limit(160);
            $ret = exec($command, $output, $return_var);
            if ($return_var != 0) {
                echo 'Geração dos Gráficos para PDF não obteve sucesso.<br />';
                echo 'variável SCRIPT_FILENAME '.$_SERVER['SCRIPT_FILENAME'].'<br />';
                echo 'variável path_local      '.$path_local.'<br /><br /><br />';

            
                echo 'Retorno: '.$return_var.'<br />';
                echo 'Executando: '.$command.'<br />';
                echo '.Bat: <br />';
                p($vet_bat);
                echo 'Resultado da Bat: <br />';
                p($output);
            } else {
                // deu certo
            }
            */
            
            // comando a comando
            set_time_limit(160);
            $command = $vet_bat[0];
            $ret = exec($command, $output, $return_var);
            if ($return_var != 0) {
                echo 'Geração dos Gráficos para PDF não obteve sucesso.<br />';
                echo 'variável SCRIPT_FILENAME '.$_SERVER['SCRIPT_FILENAME'].'<br />';
                echo 'variável path_local      '.$path_local.'<br /><br /><br />';
                echo 'Retorno: '.$return_var.'<br />';
                echo 'Executando: '.$command.'<br />';
                echo '.Bat: <br />';
                p($vet_bat);
                echo 'Resultado da Bat: <br />';
                p($output);
            } else {
                // deu certo
                
            $command = $vet_bat[1];
            $ret = exec($command, $output, $return_var);
            if ($return_var != 0) {
                echo 'Geração dos Gráficos para PDF não obteve sucesso.<br />';
                echo 'variável SCRIPT_FILENAME '.$_SERVER['SCRIPT_FILENAME'].'<br />';
                echo 'variável path_local      '.$path_local.'<br /><br /><br />';


                echo 'Retorno: '.$return_var.'<br />';
                echo 'Executando: '.$command.'<br />';
                echo '.Bat: <br />';
                p($vet_bat);
                echo 'Resultado da Bat: <br />';
                p($output);
            } else {
                // deu certo
            }

            $command = $vet_bat[2];
            $ret = exec($command, $output, $return_var);
            if ($return_var != 0) {
                echo 'Geração dos Gráficos para PDF não obteve sucesso.<br />';
                echo 'variável SCRIPT_FILENAME '.$_SERVER['SCRIPT_FILENAME'].'<br />';
                echo 'variável path_local      '.$path_local.'<br /><br /><br />';


                echo 'Retorno: '.$return_var.'<br />';
                echo 'Executando: '.$command.'<br />';
                echo '.Bat: <br />';
                p($vet_bat);
                echo 'Resultado da Bat: <br />';
                p($output);
            } else {
                // deu certo
            }
            
            $command = $vet_bat[3];
            $ret = exec($command, $output, $return_var);
            if ($return_var != 0) {
                echo 'Geração dos Gráficos para PDF não obteve sucesso.<br />';
                echo 'variável SCRIPT_FILENAME '.$_SERVER['SCRIPT_FILENAME'].'<br />';
                echo 'variável path_local      '.$path_local.'<br /><br /><br />';


                echo 'Retorno: '.$return_var.'<br />';
                echo 'Executando: '.$command.'<br />';
                echo '.Bat: <br />';
                p($vet_bat);
                echo 'Resultado da Bat: <br />';
                p($output);
            } else {
                // deu certo
            }
            
            $command = $vet_bat[4];
            $ret = exec($command, $output, $return_var);
            if ($return_var != 0) {
                echo 'Geração dos Gráficos para PDF não obteve sucesso.<br />';
                echo 'variável SCRIPT_FILENAME '.$_SERVER['SCRIPT_FILENAME'].'<br />';
                echo 'variável path_local      '.$path_local.'<br /><br /><br />';


                echo 'Retorno: '.$return_var.'<br />';
                echo 'Executando: '.$command.'<br />';
                echo '.Bat: <br />';
                p($vet_bat);
                echo 'Resultado da Bat: <br />';
                p($output);
            } else {
                // deu certo
            }

            $command = $vet_bat[5];
            $ret = exec($command, $output, $return_var);
            if ($return_var != 0) {
                echo 'Geração dos Gráficos para PDF não obteve sucesso.<br />';
                echo 'variável SCRIPT_FILENAME '.$_SERVER['SCRIPT_FILENAME'].'<br />';
                echo 'variável path_local      '.$path_local.'<br /><br /><br />';


                echo 'Retorno: '.$return_var.'<br />';
                echo 'Executando: '.$command.'<br />';
                echo '.Bat: <br />';
                p($vet_bat);
                echo 'Resultado da Bat: <br />';
                p($output);
            } else {
                // deu certo
            }


                
            }

            
            
            
        }
        else
        { // bat não gravada
                echo 'Geração dos Gráficos para PDF não obteve sucesso.<br />';
                echo 'Arquivo de Bat não pode ser gravado.<br />';
                echo 'variável SCRIPT_FILENAME '.$_SERVER['SCRIPT_FILENAME'].'<br />';
                echo 'variável path_local      '.$path_local.'<br /><br /><br />';
                echo '.Bat: <br />';
                p($vet_bat);
        }

        break;
        
        
    case 'mostrar_area_vivencia':
          $idt_obra          = $_POST['idt_obraw'];
          $idt_tipo_acidente = $_POST['idt_tipo_acidentew'];
          $pointx            = $_POST['pointxw'];
          $pointy            = $_POST['pointyw'];
          $legenda_mm        = '"'.$_POST['legenda_mmw'].'"';
          $percentual_mm     = '"'.$_POST['percentual_mmw'].'"';
          //
          $htmlw='';
          $kokw = mostrar_area_vivencia($idt_obra,$idt_tipo_acidente,$pointx,$pointy,$legenda_mm, $percentual_mm, $htmlw);
          if ($kokw!=1)
          {
              echo 'NÃO CONSEGUIU GERAR O HTML PARA APRESENTAR.';
          }
          else
          {
              echo $htmlw;
          }
   break;

    case 'mostrar_passivo_multa':
          $idt_obra          = $_POST['idt_obraw'];
          $idt_tipo_acidente = $_POST['idt_tipo_acidentew'];
          $pointx            = $_POST['pointxw'];
          $pointy            = $_POST['pointyw'];
          $legenda_mm        = '"'.$_POST['legenda_mmw'].'"';
          //
          $htmlw         = '';
          $vetDescricao  = Array();
          $vetUFIR       = Array();
          $vetPercentual = Array();
          $totalufirw    = 0;
          $anomes        = '';
          $kokw = mostrar_passivo_multa($idt_obra,$idt_tipo_acidente,$pointx,$pointy,$legenda_mm,$htmlw,$vetDescricao,$vetUFIR,$vetPercentual,$totalufirw,$anomes);
          if ($kokw!=1)
          {
              echo 'NÃO CONSEGUIU GERAR O HTML PARA APRESENTAR.';
          }
          else
          {
           //   p($vetDescricao);
           //   p($vetUFIR);
           //   p($vetPercentual);
              
              $virgula = '';
              $descw   = '';
              ForEach ($vetDescricao as $idx => $Valor) {
                 $descw  .= $virgula.$Valor;
                 $virgula = '@';
              }
              //
              $virgula = '';
              $ufirw   = '';
              ForEach ($vetUFIR as $idx => $Valor) {
                 $Valorw        = format_decimal($Valor,0);
                 $Valorw        = desformat_decimal($Valorw);
                 $ufirw  .= $virgula.$Valorw;
                 $virgula = '@';
              }
              $virgula         = '';
              $Percentualw     = '';
              ForEach ($vetPercentual as $idx => $Valor) {
                 $Valorw        = format_decimal($Valor);
                 $Valorw        = desformat_decimal($Valorw);
                 $Percentualw .= $virgula.$Valorw;
                 $virgula = '@';
              }
              
              $parametro  = "";
              $parametro .= "<div id='parametro_gg' style='display:none;'>";
              $parametro .= $descw."#";
              $parametro .= $ufirw."#";
              $parametro .= $Percentualw."#";
              $parametro .= $totalufirw."#";
              $parametro .= $anomes."#";

              $parametro .= "</div>";
              echo $htmlw.$parametro;

              
          }
   break;
   
   


    case 'mostra_grafico_avd':
          $idt         = $_POST['idtw'];
          //
          $htmlw         = '';
          $vetDescricao  = Array();
          $vetPercsesmt  = Array();
          $vetPercobra   = Array();
          $vetDescGeral  = Array();
          $vetPercGeral  = Array();
          $kokw = mostra_grafico_avd($idt,$htmlw,$vetDescricao,$vetPercsesmt,$vetPercobra,$vetDescGeral,$vetPercGeral);
          if ($kokw!=1)
          {
              echo 'NÃO CONSEGUIU GERAR O HTML PARA APRESENTAR.';
          }
          else
          {

              $virgula = '';
              $descw   = '';
              ForEach ($vetDescricao as $idx => $Valor) {
                 $descw  .= $virgula.$Valor;
                 $virgula = '@';
              }
              //
              $virgula = '';
              $sesmtw   = '';
              ForEach ($vetPercsesmt as $idx => $Valor) {
                 $Valorw        = format_decimal($Valor);
                 $Valorw        = desformat_decimal($Valorw);
                 $sesmtw  .= $virgula.$Valorw;
                 $virgula = '@';
              }
              $virgula         = '';
              $Percobraw     = '';
              ForEach ($vetPercobra as $idx => $Valor) {
                 $Valorw        = format_decimal($Valor);
                 $Valorw        = desformat_decimal($Valorw);
                 $Percobraw .= $virgula.$Valorw;
                 $virgula = '@';
              }
              


              $virgula = '';
              $DescGeral     = '';
              ForEach ($vetDescGeral as $idx => $Valor) {
                 $DescGeral  .= $virgula.$Valor;
                 $virgula = '@';
              }
              $virgula         = '';
              $PercGeral     = '';
              ForEach ($vetPercGeral as $idx => $Valor) {
                 $Valorw        = format_decimal($Valor);
                 $Valorw        = desformat_decimal($Valorw);
                 $PercGeral .= $virgula.$Valorw;
                 $virgula = '@';
              }



              $parametro  = "";
              $parametro .= "<div id='parametro_gg' style='display:none;'>";
              $parametro .= $descw."#";
              $parametro .= $sesmtw."#";
              $parametro .= $Percobraw."#";
              $parametro .= $DescGeral."#";
              $parametro .= $PercGeral."#";

              
              $parametro .= "</div>";
              echo $htmlw.$parametro;

          }
   break;


    case 'mostra_grafico_avd_am':
          $idt         = $_POST['idtw'];
          //
          $htmlw         = '';
          $vetDescricao  = Array();
          $vetPercsesmt  = Array();
          $vetPercobra   = Array();
          $vetDescGeral  = Array();
          $vetPercGeral  = Array();
          $kokw = mostra_grafico_avd_am($idt,$htmlw,$vetDescricao,$vetPercsesmt,$vetPercobra,$vetDescGeral,$vetPercGeral);
          if ($kokw!=1)
          {
              echo 'NÃO CONSEGUIU GERAR O HTML PARA APRESENTAR.';
          }
          else
          {

              $virgula = '';
              $descw   = '';
              ForEach ($vetDescricao as $idx => $Valor) {
                 $descw  .= $virgula.$Valor;
                 $virgula = '@';
              }
              //
              $virgula = '';
              $sesmtw   = '';
              ForEach ($vetPercsesmt as $idx => $Valor) {
                 $Valorw        = format_decimal($Valor);
                 $Valorw        = desformat_decimal($Valorw);
                 $sesmtw  .= $virgula.$Valorw;
                 $virgula = '@';
              }
              $virgula         = '';
              $Percobraw     = '';
              ForEach ($vetPercobra as $idx => $Valor) {
                 $Valorw        = format_decimal($Valor);
                 $Valorw        = desformat_decimal($Valorw);
                 $Percobraw .= $virgula.$Valorw;
                 $virgula = '@';
              }



              $virgula = '';
              $DescGeral     = '';
              ForEach ($vetDescGeral as $idx => $Valor) {
                 $DescGeral  .= $virgula.$Valor;
                 $virgula = '@';
              }
              $virgula         = '';
              $PercGeral     = '';
              ForEach ($vetPercGeral as $idx => $Valor) {
                 $Valorw        = format_decimal($Valor);
                 $Valorw        = desformat_decimal($Valorw);
                 $PercGeral .= $virgula.$Valorw;
                 $virgula = '@';
              }



              $parametro  = "";
              $parametro .= "<div id='parametro_gg' style='display:none;'>";
              $parametro .= $descw."#";
              $parametro .= $sesmtw."#";
              $parametro .= $Percobraw."#";
              $parametro .= $DescGeral."#";
              $parametro .= $PercGeral."#";


              $parametro .= "</div>";
              echo $htmlw.$parametro;

          }
   break;


  
  case 'mostrar_tg':
      $idt_obra          = $_POST['idt_obraw'];
      $idt_tipo_acidente = $_POST['idt_tipo_acidentew'];
      $pointx            = $_POST['pointxw'];
      $pointy            = $_POST['pointyw'];
      $legenda_mm        = '"'.$_POST['legenda_mmw'].'"';
      //
      $htmlw         = '';
      $vetDescricao  = Array();
      $vetUFIR       = Array();
      $vetPercentual = Array();
      $totalufirw    = 0;
      $anomes        = '';
      $kokw = mostrar_tg($idt_obra,$idt_tipo_acidente,$pointx,$pointy,$legenda_mm,$htmlw);
      if ($kokw!=1)
      {
          echo 'NÃO CONSEGUIU GERAR O HTML PARA APRESENTAR.';
      }
      else
      {
          //$htmlw = 'resrando retorna de html';
          echo  $htmlw;
      }
   break;
  case 'mostrar_tf':
      $idt_obra          = $_POST['idt_obraw'];
      $idt_tipo_acidente = $_POST['idt_tipo_acidentew'];
      $pointx            = $_POST['pointxw'];
      $pointy            = $_POST['pointyw'];
      $legenda_mm        = '"'.$_POST['legenda_mmw'].'"';
      //
      $htmlw         = '';
      $vetDescricao  = Array();
      $vetUFIR       = Array();
      $vetPercentual = Array();
      $totalufirw    = 0;
      $anomes        = '';
      $kokw = mostrar_tf($idt_obra,$idt_tipo_acidente,$pointx,$pointy,$legenda_mm,$htmlw);
      if ($kokw!=1)
      {
          echo 'NÃO CONSEGUIU GERAR O HTML PARA APRESENTAR.';
      }
      else
      {
          //$htmlw = 'resrando retorna de html';
          echo  $htmlw;
      }
   break;

    case 'qua_filtro_relatorio':
      $p1          = $_POST['p1w'];
      $p2          = $_POST['p2w'];
      $p3          = $_POST['p3w'];
      if ($p1=='idtorre')
      {
          $_SESSION[CS]['qua_idt_torre']=$p2;
      }
      if ($p1=='iddata')
      {
          $_SESSION[CS]['qua_data']=$p2;
      }
      if ($p1=='idtipo')
      {
          $_SESSION[CS]['qua_idt_tipo']=$p2;
      }

   break;

  
  case 'gera_versao_1':
      $idt_empreendimento = $_POST['idt_empreendimentow'];
      $kokw = Gera_Versao_1($idt_empreendimento);
      if ($kokw!=1)
      {
          echo 'NÃO CONSEGUIU GERAR 1a Versão da Especificação.';
      }
   break;

  case 'Gerar_Nova_Versao':
      $idt_empreendimento = $_POST['idt_empreendimentow'];
      $kokw = Gerar_Nova_Versao($idt_empreendimento);
      if ($kokw!=1)
      {
          echo 'NÃO CONSEGUIU GERAR uma Nova Versão da Especificação.';
      }
   break;

  case 'chama_exclui_especificacao':
      $idt_empreendimento = $_POST['idt_empreendimentow'];
      $idt_versao         = $_POST['idt_versaow'];
      $kokw = chama_exclui_especificacao($idt_empreendimento,$idt_versao);
      if ($kokw!=1)
      {
          echo 'NÃO CONSEGUIU EXCLUIR a Versão da Especificação.';
      }
   break;


}
?>