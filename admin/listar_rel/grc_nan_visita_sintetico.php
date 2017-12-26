<style>
    #idt_unidade_regional {
        width:350px;

    }
    #idt_ponto_atendimento {
        width:350px;

    }
    #idt_projeto {
        width:350px;

    }
    #idt_acao {
        width:350px;

    }
    #idt_agente {
        width:350px;

    }
    #idt_tutor {
        width:350px;

    }

    #idt_empresa_executora {
        width:350px;

    }

    #idt_porte {
        width:350px;

    }
    #idt_motivo_desistencia {
        width:350px;

    }
    #idt_ferramenta {
        width:350px;

    }
    #idt_status {
        width:350px;

    }
    #classificacao {
        width:50%;

    }

    .LinhaFull {
        border-right:1px solid #C0C0C0;
        text-align:right;
        padding-right:5px;

    }
    .LinhaFull:first-child {
        text-align:left;
        padding-left:5px;

    }
    .CabFull {
        border-right:1px solid #C0C0C0;
        text-align:center;

    }


    .CabFull:last-child {
        border-right:1px solid #C0C0C0;
        text-align:center;
        background:#C4C9CD;
        color:#000000;

    }

    .LinhaFull:last-child {
        background:#C4C9CD;
        color:#000000;
        border-right:1px solid #C0C0C0;
        border-bottom:1px solid #C0C0C0;
        text-align:right;
        padding-right:5px;
    }


    /*
    tr.Registro:last-child td {
    background:#C4C9CD;
            color:#000000;
}
    tr.Registro:last-child td.LinhaFull:last-child {
    background:red;
            color:#FFFFFF;
            font-weight: bold;
            font-size:14px;
}
    */


    tr.Registro1:last-child td,
    tr.Registro:last-child td {
        background:#C4C9CD;
        color:#000000;
    }



    tr.Registro:last-child td.LinhaFull:last-child,
    tr.Registro1:last-child td.LinhaFull:last-child {
        background:red;
        color:#FFFFFF;
        font-weight: bold;
        font-size:14px;
    }



</style>
<?php
$ordFiltro = false;
$idCampo = 'idt';
$Tela = "o Atendimento NAN";
//
$listar_sql_limit = false;
//
$TabelaPrinc = "grc_atendimento";
$AliasPric = "grc_atd";
$Entidade = "Atendimento NAN";
$Entidade_p = "Atendimentos NAN";
//
$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";
$extra_pagina = false;
$_SESSION[CS]['grc_atendimento_listar'] = $_SERVER['REQUEST_URI'];
//
$barra_inc_ap = false;
$barra_alt_ap = false;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;
//
$vetBtBarraListarRel['fechar'] = false;

//
// p($_POST);


function func_trata_row_grc_atendimento(&$row) {
    $testar = chr(254).chr(254).chr(254).'TOTAL';
    if ($row['dimensao'] == $testar) {
        $row['dimensao'] = ' TOTAL';
    }
}

$func_trata_row = func_trata_row_grc_atendimento;

$barra_inc_img = "imagens/incluir_novo_atendimento.png";
//$barra_alt_img = "imagens/agenda_alterar.png";
//$barra_con_img = "imagens/agenda_consultar.png";

$barra_inc_h = 'Clique aqui para Incluir um Novo Atendimento NAN';
$barra_alt_h = 'Alterar o Atendimento NAN';
$barra_con_h = 'Consultar o Atendimento NAN';

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';


$prefixow = 'inc';
$mostrar = true;
$cond_campo = '';
$cond_valor = '';
//$veio = "D";
$direito_geral = 1;

/*
  $veiodoatendimento = 'S';
  $_GET['veiodoatendimento']=$veiodoatendimento;
  $_SESSION[CS]['veiodoatendimento'] = $veiodoatendimento;
  $imagem  = 'imagens/cadastro_clientes.png';
  $goCad[] = vetCad('idt', 'Cadastro de Clientes', 'grc_chama_cadastro_cliente', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);
 */

/*
  $tipoidentificacao = 'N';
  $tipofiltro        = 'N';
  $comfiltro         = 'F';
  $comidentificacao  = 'F';
 */



//$bt_print = false;
//$_GET['instrumento']=1;

echo "<div class='cab_1' >";
$recepcao = $_GET['recepcao'];

//$recepcao = '';
//echo "ATENDIMENTO DE NAN";

$_SESSION[CS]['fu_recepcao'] = $recepcao;
if ($recepcao == 1) {
    echo "  ATENDIMENTO DE RECEPÇÃO";
}

$balcao = $_GET['balcao'];
if ($_SESSION[CS]['fu_balcao'] == "") {
    $_SESSION[CS]['fu_balcao'] = $balcao;
} else {
    $balcao = $_SESSION[CS]['fu_balcao'];
}
if ($balcao == 1) {
    echo "  ATENDIMENTO DE BALCAO";
}
$callcenter = $_GET['callcenter'];
$_SESSION[CS]['fu_callcenter'] = $callcenter;
if ($callcenter == 1) {
    echo "  ATENDIMENTO EM CALL CENTER";
}
echo "</div>";


// p($_POST);
//
// Descida para o nivel 2
//
$prefixow = 'listar';
$mostrar = false;
$cond_campo = '';
$cond_valor = '';

/*
  $imagem  = 'imagens/empresa_16.png';
  $goCad[] = vetCad('idt', 'Diagnóstico', 'grc_atendimento_diagnostico', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

  $imagem  = 'imagens/empresa_16.png';
  $goCad[] = vetCad('idt', 'Produtos', 'grc_atendimento_produto', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);
 */

$idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
$idt_usuario = $_SESSION[CS]['g_id_usuario'];

$Filtro = Array();
$Filtro['rs'] = 'Hidden';
$Filtro['id'] = 'idt_pesquisa_sel';
$Filtro['valor'] = '';
$vetFiltro['idt_pesquisa_sel'] = $Filtro;
//p($_GET);
//p($_POST);
//p($vetFiltro['idt_pesquisa_sel']['valor']);

if ($_POST['idt_pesquisa_sel'] != "") {

    $sql = '';
    $sql .= ' select plu_p.*';
    $sql .= ' from plu_pesquisa plu_p';
    $sql .= ' where idt = '.null($_POST['idt_pesquisa_sel']);
    $rs = execsql($sql);
    $codigo = "";
    foreach ($rs->data as $row) {
        $codigo = $row['codigo'];
        $descricao = $row['descricao'];
        $post_slv = $row['post_slv'];
        $get_slv = $row['get_slv'];
    }
    if ($codigo != "") {
        //$post_slv   = str_replace('#','"',$post_slv);
        $_POST = unserialize(base64_decode($post_slv));
        //$get_slv    = str_replace('#','"',$get_slv);
        $_GET = unserialize(base64_decode($get_slv));
        $_REQUEST = array_merge($_POST, $_GET);
    }
}











$Filtro = Array();
$Filtro['rs'] = $vetSimNao;
$Filtro['id'] = 'filtro_erro';
$Filtro['nome'] = 'Integração com Erro';
$Filtro['valor'] = trata_id($Filtro);
// $vetFiltro['erro'] = $Filtro;
// echo " -------------    $idt_ponto_atendimento ";
// Unidade Regional
$sql = 'select ';
$sql .= '   idt, descricao  ';
$sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql .= " where posto_atendimento <> 'S'  ";
$sql .= ' order by classificacao ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'idt_unidade_regional';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm'] = '-- Selecione Unidade Regional --';
$Filtro['nome'] = 'Unidade Regional:';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_unidade_regional'] = $Filtro;

// Ponto de Atendimento

$fixaunidade = 0;
if ($fixaunidade == 0) {   // Todos
    $sql = 'select ';
    $sql .= '   idt, descricao  ';
    $sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql .= " where posto_atendimento = 'S' ";
    $sql .= ' order by classificacao ';
} else {
    $sql = 'select ';
    $sql .= '   idt, descricao  ';
    $sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S' ) ";
    if ($_SESSION[CS]['g_atendimento_relacao'] == 'G') {
        $sql .= ' and SUBSTRING(classificacao, 1, 5) = ('; //and
        $sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
        $sql .= ' from '.db_pir.'sca_organizacao_secao';
        $sql .= ' where idt = '.null($idt_ponto_atendimento);
        $sql .= ' )';
    } else {
        $sql .= "   and idt = ".null($idt_ponto_atendimento);
    }
    $sql .= ' order by classificacao ';
}
$rs = execsql($sql);



$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'idt_ponto_atendimento';
$Filtro['id_select'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm'] = '-- Selecione o PA --';
$Filtro['nome'] = 'Ponto de Atendimento:';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_ponto_atendimento'] = $Filtro;
//
// Projeto
//
$Filtro = Array();
$Filtro['rs'] = 'ListarCmb';
$Filtro['arq'] = 'grc_projeto';
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'idt_projeto';
$Filtro['nome'] = 'Projeto:';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_projeto'] = $Filtro;
//
// Ação
//
$Filtro = Array();
$Filtro['rs'] = 'ListarCmb';
$Filtro['arq'] = 'grc_projeto_acao';
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'idt_acao';
$Filtro['nome'] = 'Acao:';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_projeto_acao'] = $Filtro;
//
// Empresas Executoras
//
$sql = "select distinct plu_usu.id_usuario as idt, ";
$sql .= " gec_e.descricao as gec_e_executora ";
$sql .= " from ".db_pir_gec."gec_contratar_credenciado gec_cc ";
$sql .= " left join ".db_pir_gec."gec_entidade gec_e on gec_e.idt = gec_cc.idt_organizacao";
$sql .= ' inner join plu_usuario plu_usu on plu_usu.login = gec_e.codigo ';
$sql .= " where gec_cc.nan_indicador = ".aspa('S');
$sql .= " order by gec_e.descricao";
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'idt_empresa_executora';
$Filtro['nome'] = 'Empresa Executora:';
$Filtro['LinhaUm'] = '-- Selecione Empresa Executora -- ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_empresa_executora'] = $Filtro;

// Tutor - Gestor

$sql = "select distinct plu_usu.id_usuario,  ";
$sql .= " plu_usu.nome_completo as plu_usu_nome_completo  ";
$sql .= " from grc_nan_estrutura grc_ne ";
$sql .= " inner join grc_nan_estrutura_tipo grc_net on grc_net.idt  = grc_ne.idt_nan_tipo ";
$sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario      = grc_ne.idt_usuario ";
$sql .= " where grc_net.codigo = ".aspa('05');
$sql .= " order by plu_usu.nome_completo";
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'id_usuario';
$Filtro['id'] = 'idt_tutor';
$Filtro['nome'] = 'Tutor/Gestor:';
$Filtro['LinhaUm'] = ' -- Selecione Tutor/Gestor --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_tutor'] = $Filtro;

// Agente

$sql = "select distinct plu_usu.id_usuario,  ";
$sql .= " plu_usu.nome_completo as plu_usu_nome_completo  ";
$sql .= " from grc_nan_estrutura grc_ne ";
$sql .= " inner join grc_nan_estrutura_tipo grc_net on grc_net.idt  = grc_ne.idt_nan_tipo ";
$sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario      = grc_ne.idt_usuario ";
$sql .= " where grc_net.codigo = ".aspa('06');
$sql .= " order by plu_usu.nome_completo";
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'id_usuario';
$Filtro['id'] = 'idt_agente';
$Filtro['nome'] = 'Agente:';
$Filtro['LinhaUm'] = '-- Selecione Agente -- ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_agente'] = $Filtro;

//
// Número da Visita
//
$vetVisitas = Array();
$vetVisitas[1] = 'Visita 1';
$vetVisitas[2] = 'Visita 2';
$Filtro = Array();
$Filtro['rs'] = $vetVisitas;
$Filtro['id'] = 'numero_visitas';
$Filtro['nome'] = 'Número da Visita:';
$Filtro['LinhaUm'] = '-- Selecione Visita --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['numero_visitas'] = $Filtro;
//
// Porte da empresa
//
$sql = '';
$sql .= ' select idt, descricao, desc_vl_cmb';
$sql .= ' from '.db_pir_gec.'gec_organizacao_porte';
$sql .= " where codigo in ('2', '3', '99')";
$sql .= ' order by descricao, desc_vl_cmb';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'idt';

$Filtro['id'] = 'idt_porte';
$Filtro['nome'] = 'Porte/Faixa de Faturamento:';
$Filtro['LinhaUm'] = ' Selecione Porte da Empresa --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_porte'] = $Filtro;

// Motivo da Desistência

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_nan_motivo_desistencia';
//$sql .= " where ativo = 'S'";
$sql .= ' order by codigo';

$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt_motivo_desistencia';
$Filtro['id_select'] = 'idt';

$Filtro['nome'] = 'Motivo da Desistência:';
$Filtro['LinhaUm'] = '-- Selecione Motivo da Desistência --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_motivo_desistencia'] = $Filtro;


//
// Ferramentas
//
$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_formulario_ferramenta_gestao';
//$sql .= " where ativo = 'S'";
$sql .= ' order by codigo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'idt';

$Filtro['id'] = 'idt_ferramenta';
$Filtro['nome'] = 'Ferramentas:';
$Filtro['LinhaUm'] = '-- Selecione a Ferramenta -- ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_ferramenta'] = $Filtro;
//
// Perspectiva Empresarial
//
$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_formulario_resposta';
$sql .= ' where idt_pergunta = 1289';
$sql .= ' order by codigo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'filtro_idt_perspectiva_empresarial';
$Filtro['nome'] = 'Perspectiva Empresarial:';
$Filtro['LinhaUm'] = ' -- Selecione Perspectiva Empresarial --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_perspectiva_empresarial'] = $Filtro;


$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_ini';
$Filtro['vlPadrao'] = Date('d/m/Y', strtotime('-45 day'));

//$Filtro['vlPadrao'] = Date('d/m/Y');
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data Inicial:';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_ini'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_fim';
//$Filtro['vlPadrao']  = Date('d/m/Y', strtotime('+45 day'));
$Filtro['vlPadrao'] = Date('d/m/Y');
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data Final:';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_fim'] = $Filtro;
//
// status
//



$Filtro = Array();
$Filtro['rs'] = $vetNanGrupo;
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'status';
$Filtro['nome'] = 'Status:';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['status'] = $Filtro;

//
// Texto Livre
//
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Hidden';
$Filtro['id'] = 'pesquisa';
$Filtro['valor'] = 'S';
$vetFiltro['pesquisa'] = $Filtro;


$TabelaPrinc = "grc_atendimento";
$AliasPric = "grc_atd";
$Entidade = "Atendimento";
$Entidade_p = "Atendimentos";
//
$idt_instrumento = 13;
//
// Campos variáveis da lista
//
$vetTabelas = Array();
$vetTabelas = NAN_MontaListas($menu);
//
if (count($vetTabelas) == 0) {
    $padrao = 1;
} else {
    $padrao = 0;
}
//
$vetCampo = Array();
$qtdcamposescolhidos = 0;
//p($_POST);
$vetCpoP = $vetTabelas['CTP'];
$ordem = 0;

//p($vetCpoP);

$vetCampoOrdem = Array();
ForEach ($vetCpoP as $GrupoP => $vetQualificadoresG) {
    ForEach ($vetQualificadoresG as $CampoPesq => $vetQualificadores) {
        $campo_caption = $vetQualificadores['dsc'];
        $campo_tipo = $vetQualificadores['tip'];
        $campo_tam = $vetQualificadores['tam'];
        $campo_vet = $vetQualificadores['vet'];
        $tabela_dimensao = $vetQualificadores['tab_d'];
        $tabela_dimensao_id = $vetQualificadores['tab_did'];
        $sql_cpo_dimensao = $vetQualificadores['tab_dcp'];
        $tabela_princ_id = $vetQualificadores['tab_pid'];
        $especial = $vetQualificadores['esp'];

        $colativa = "{$GrupoP}";

        if ($_POST[$colativa] == $campo_caption) {
            $ordem = $ordem + 1;
            $colativaordem = "{$GrupoP}_{$CampoPesq}_t";
            $ordpost = $_POST[$colativaordem];
            if ($ordpost == '') {
                $ordpost = 99999;
            }

            $a = '1'.ZeroEsq($ordpost, 5);
            $colativaordem = $a.ZeroEsq($ordem, 5).$CampoPesq;
            $vetCampoOrdem[$colativaordem][$CampoPesq]['dsc'] = $campo_caption;
            $vetCampoOrdem[$colativaordem][$CampoPesq]['tip'] = $campo_tipo;
            $vetCampoOrdem[$colativaordem][$CampoPesq]['tam'] = $campo_tam;
            $vetCampoOrdem[$colativaordem][$CampoPesq]['vet'] = $campo_vet;
            $vetCampoOrdem[$colativaordem][$CampoPesq]['esp'] = $especial;

            $vetCampoOrdem[$colativaordem][$CampoPesq]['tab_d'] = $tabela_dimensao;
            $vetCampoOrdem[$colativaordem][$CampoPesq]['tab_did'] = $tabela_dimensao_id;
            $vetCampoOrdem[$colativaordem][$CampoPesq]['tab_dcp'] = $sql_cpo_dimensao;
            $vetCampoOrdem[$colativaordem][$CampoPesq]['tab_pid'] = $tabela_princ_id;

            //$vetCampo[$CampoPesq] = CriaVetTabela($campo_caption,$campo_tipo); 
            //$qtdcamposescolhidos = $qtdcamposescolhidos + 1;
        }
    }
}
ksort($vetCampoOrdem);
//p($vetCampoOrdem);

$largura = 0;


if ($qtdcamposescolhidos > 0) {
    // $vetOrderby=Array();
}

// p($_POST['sql_orderby']);
$vetOrdenacaoColunas = $_POST['sql_orderby'];
if (is_array($vetOrdenacaoColunas)) {
    $vetO = Array();
    $ord = 0;
    ForEach ($vetOrdenacaoColunas as $num => $cpo) {
        $ord = $ord + 1;
        $vetO[$cpo] = $ord;
    }
    //  p($vetO);

    $vetCampoOrdemw = Array();
    ForEach ($vetCampoOrdem as $colativaordem => $vetCamposemOrdem) {
        ForEach ($vetCamposemOrdem as $CampoPesq => $vetQualificadores) {
            $ord = $vetO[$CampoPesq];
            $vetCampoOrdemw[$ord] = $vetCamposemOrdem;
        }
    }
//	ksort($vetCampoOrdemw);

    $vetCampoOrdemw = $vetCampoOrdem;

//	p($vetCampoOrdemw);
} else {
    $vetCampoOrdemw = $vetCampoOrdem;
}
//
//  
//
$especial = "N";
ForEach ($vetCampoOrdemw as $colativaordem => $vetCamposemOrdem) {
    ForEach ($vetCamposemOrdem as $CampoPesq => $vetQualificadores) {
        $campo_caption = $vetQualificadores['dsc'];
        $caption_dimensao = $vetQualificadores['dsc'];
        $tabela_dimensao = $vetQualificadores['tab_d'];
        $tabela_dimensao_id = $vetQualificadores['tab_did'];
        $sql_cpo_dimensao = $vetQualificadores['tab_dcp'];
        $tabela_princ_id = $vetQualificadores['tab_pid'];

        $campo_tipo = $vetQualificadores['tip'];
        $campo_vet = $vetQualificadores['vet'];

        $especial = $vetQualificadores['esp'];
        if ($especial == "") {
            $especial = "N";
        }

        if ($campo_vet == '') {
            //  $vetCampo[$CampoPesq] = CriaVetTabela($campo_caption, $campo_tipo);
        } else {
            //  $vetCampo[$CampoPesq] = CriaVetTabela($campo_caption, $campo_tipo, $$campo_vet);
        }
        $campo_tam = $vetQualificadores['tam'];

        //$vetOrderby[$CampoPesq] = $campo_caption;

        if ($campo_tam == "") {
            $campo_tam = 250;
        }
        $largura = $largura + $campo_tam;
    }
}


if ($qtdcamposescolhidos > 0) {
    // criar style
    if ($largura > 1000) {
        echo '<style>';
        echo 'div#geral { ';
        echo "   width:{$largura}px; ";
        echo '} ';
        echo '</style> ';
    }
}

//////////////
//if ($padrao == 1 or $qtdcamposescolhidos == 0) {
$caption_dimensaow = $caption_dimensao;
if ($caption_dimensao == "") {
    $caption_dimensaow = "Empresas Executoras";
}


$vetCampo = Array();

//$campo_tipo    = $vetQualificadores['tip'];
//$campo_vet     = $vetQualificadores['vet'];
if ($campo_vet == '') {
    $vetCampo['dimensao'] = CriaVetTabela($caption_dimensaow);
} else {
    $vetCampo['dimensao'] = CriaVetTabela($caption_dimensaow, $campo_tipo, $$campo_vet);
    //  $vetCampo[$CampoPesq] = CriaVetTabela($campo_caption, $campo_tipo, $$campo_vet);
}




$vetCampo['quantidade1'] = CriaVetTabela('JAN');
$vetCampo['quantidade2'] = CriaVetTabela('FEV');
$vetCampo['quantidade3'] = CriaVetTabela('MAR');
$vetCampo['quantidade4'] = CriaVetTabela('ABR');
$vetCampo['quantidade5'] = CriaVetTabela('MAI');
$vetCampo['quantidade6'] = CriaVetTabela('JUN');
$vetCampo['quantidade7'] = CriaVetTabela('JUL');
$vetCampo['quantidade8'] = CriaVetTabela('AGO');
$vetCampo['quantidade9'] = CriaVetTabela('SET');
$vetCampo['quantidade10'] = CriaVetTabela('OUT');
$vetCampo['quantidade11'] = CriaVetTabela('NOV');
$vetCampo['quantidade12'] = CriaVetTabela('DEZ');
$vetCampo['quantidade'] = CriaVetTabela('TOT');

//}

function ftd_siac($valor, $row, $Campo) {
    $html = '';
    $style = 'style="cursor: help;"';
    if ($valor != '') {
        if ($row[$Campo.'_erro'] == '') {
            $html .= '<img src="imagens/icone_ok.gif" title="'.$valor.'" '.$style.' />';
        } else {
            $html .= '<img src="imagens/valor_alterado.png" title="'.$valor.' - '.$row[$Campo.'_erro'].'" '.$style.' />';
        }
    }
    return $html;
}

// p($vetCampo);
$dt_iniw = trata_data($vetFiltro['dt_ini']['valor']);
$dt_fimw = trata_data($vetFiltro['dt_fim']['valor']);
/*
  $tabela_dimensao    = "plu_usuario";
  $tabela_dimensao_id = "id_usuario";
  $sql_cpo_dimensao   = "nome_completo";
  $tabela_princ_id    = "idt_nan_empresa";
 */
// em vetcampo
// 'func_trata_dado', func()
//
//  func($valor,$row,$nome_campo)
//  {
//      $html="";
//      return $html;
//  } 
//
//  funcao em javascript listar_td_acao_click       - para linha
//  funcao em javascript listar_td_cab_acao_click   - para cabecalho 
//
//  function javascript lista_td_cab_acao_click($campo,$obj_jquery)
//  function javascript lista_td_acao_click($idt_linha,$campo,$obj_jquery)
//
//  // listar_conf
//  $menu."_ant.php"
//  $menu."_dep.php"
//
// Criar Botão na barra
// $vetBtBarra_extra[] = vetBtBarra($menu, '', 'imagens/bt_fechar_32.png', 'listar_rel_voltar()', '', 'Voltar', $bt_print_class);


$sql = "select ";
if ($caption_dimensao == "") {
    $sql .= "   td.nome_completo   as dimensao,  ";
} else {
    $sql .= "   td.{$sql_cpo_dimensao}   as dimensao,  ";
}

$sql .= "   MONTH({$AliasPric}.data) as mes,  ";
$sql .= "   count({$AliasPric}.idt) as quantidade,  ";
$sql .= "   sum({$AliasPric}.horas_atendimento) as duracao  ";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " inner  join grc_nan_grupo_atendimento  grc_nga on grc_nga.idt  = {$AliasPric}.idt_grupo_atendimento";
$sql .= " left outer join grc_atendimento_pessoa ap on ap.idt_atendimento = {$AliasPric}.idt and ap.tipo_relacao = 'L'";
$sql .= " left outer join grc_atendimento_organizacao ao on ao.idt_atendimento = {$AliasPric}.idt and ao.representa = 'S' and ao.desvincular = 'N'";


if ($especial != "N") {
    $sql .= " left  join grc_avaliacao grc_av on grc_av.idt_atendimento = {$AliasPric}.idt ";
    $sql .= " left  join grc_avaliacao_resposta grc_avr on grc_avr.idt_avaliacao = grc_av.idt ";
    $sql .= " left  join grc_formulario_pergunta grc_fp on grc_fp.idt = grc_avr.idt_pergunta ";

    $sql .= " left  join grc_formulario_secao grc_fs on grc_fs.idt = grc_fp.idt_secao ";
    $sql .= " left  join grc_formulario grc_f on grc_f.idt = grc_fs.idt_formulario ";
}
//$sql .= " left outer join grc_formulario_resposta grc_fr on grc_fr.idt   = grc_avr.idt_resposta ";


if ($caption_dimensao == "") {
    $sql .= " left  join plu_usuario td on td.id_usuario = {$AliasPric}.idt_nan_empresa";
} else {
    $vet = explode(".", $tabela_princ_id);
    if (count($vet) > 1) {
        $sql .= " left  join {$tabela_dimensao} td on td.{$tabela_dimensao_id} = {$tabela_princ_id}";
    } else {
        $sql .= " left  join {$tabela_dimensao} td on td.{$tabela_dimensao_id} = {$AliasPric}.{$tabela_princ_id}";
    }
}


$sql .= ' where ';
$sql .= " {$AliasPric}.data >= ".aspa($dt_iniw)." and {$AliasPric}.data <=  ".aspa($dt_fimw)." ";
$sql .= " and {$AliasPric}.idt_evento is null";
$sql .= " and {$AliasPric}.idt_grupo_atendimento is not null";

if ($especial != "N") {
    // $sql .= " and ((grc_fp.sigla_dimensao = 'GE' or grc_av.idt is null) or (grc_fp.sigla_dimensao is null and grc_av.idt is not null) or (grc_f.codigo='50')  or (grc_f.codigo is null and grc_av.idt is not null )) ";

    $sql .= " and ( ( (grc_fp.sigla_dimensao = 'GE' and grc_f.codigo='50') or grc_av.idt is null) or (grc_fp.sigla_dimensao is null and grc_av.idt is not null) ) ";


    //$sql .= " and ( (grc_f.codigo='50')  or (grc_f.codigo is null and grc_av.idt is not null )) ";
}



if ($vetFiltro['status']['valor'] != "" and $vetFiltro['status']['valor'] != "0") {
    $sql .= ' and (';
    $sql .= '    ('.$AliasPric.'.nan_num_visita = 1 and grc_nga.status_1 = '.aspa($vetFiltro['status']['valor']).')';
    $sql .= ' or ('.$AliasPric.'.nan_num_visita = 2 and grc_nga.status_2 = '.aspa($vetFiltro['status']['valor']).')';
    $sql .= ' )';
}


if ($vetFiltro['idt_unidade_regional']['valor'] != '' AND $vetFiltro['idt_unidade_regional']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " ({$AliasPric}.idt_unidade = ".null($vetFiltro['idt_unidade_regional']['valor'])." ) ";
}

if ($vetFiltro['idt_ponto_atendimento']['valor'] != '' AND $vetFiltro['idt_ponto_atendimento']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " {$AliasPric}.idt_ponto_atendimento= ".null($vetFiltro['idt_ponto_atendimento']['valor']);
}

if ($vetFiltro['idt_projeto']['valor'] != '' AND $vetFiltro['idt_projeto']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " ({$AliasPric}.idt_projeto = ".null($vetFiltro['idt_projeto']['valor'])." ) ";
}
if ($vetFiltro['idt_projeto_acao']['valor'] != '' AND $vetFiltro['idt_projeto_acao']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " ({$AliasPric}.idt_projeto_acao = ".null($vetFiltro['idt_projeto_acao']['valor'])." ) ";
}

if ($vetFiltro['idt_tutor']['valor'] != '' AND $vetFiltro['idt_tutor']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " {$AliasPric}.idt_nan_tutor = ".null($vetFiltro['idt_tutor']['valor']);
}
if ($vetFiltro['idt_agente']['valor'] != '' AND $vetFiltro['idt_agente']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " {$AliasPric}.idt_consultor= ".null($vetFiltro['idt_agente']['valor']);
}
if ($vetFiltro['idt_empresa_executora']['valor'] != '' AND $vetFiltro['idt_empresa_executora']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " {$AliasPric}.idt_nan_empresa = ".null($vetFiltro['idt_empresa_executora']['valor']);
}

if ($vetFiltro['idt_porte']['valor'] != '' AND $vetFiltro['idt_porte']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " (ao.idt_porte = ".null($vetFiltro['idt_porte']['valor'])." ) ";
}

if ($vetFiltro['idt_motivo_desistencia']['valor'] != '' AND $vetFiltro['idt_motivo_desistencia']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " ({$AliasPric}.idt_motivo_desistencia = ".null($vetFiltro['idt_motivo_desistencia']['valor'])." ) ";
}


if ($vetFiltro['numero_visitas']['valor'] != '' AND $vetFiltro['numero_visitas']['valor'] != '0') {
    $sql .= ' and ';
    $sql .= " ({$AliasPric}.nan_num_visita = ".aspa($vetFiltro['numero_visitas']['valor'])." ) ";
}


if ($instrumento == 500) {
    if ($vetFiltro['protocolo']['valor'] != "") {
        $sql .= ' and ';
        $sql .= ' ( ';
        $sql .= '  lower('.$AliasPric.'.protocolo)      like lower('.aspa($vetFiltro['protocolo']['valor'], '%', '%').')';
        $sql .= ' ) ';
    }
}
if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.senha_totem)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.protocolo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

if ($vetFiltro['idt_ferramenta']['valor'] != '' && $vetFiltro['idt_ferramenta']['valor'] != '-1') {
    $sql .= " and (EXISTS (";
    $sql .= " select adf.idt";
    $sql .= " from grc_avaliacao_devolutiva_ferramenta adf";
    $sql .= " inner join grc_avaliacao_devolutiva ad on ad.idt = adf.idt_avaliacao_devolutiva";
    $sql .= " inner join grc_avaliacao av on av.idt = ad.idt_avaliacao";
    $sql .= ' where av.idt_atendimento = '.$AliasPric.'.idt';
    $sql .= ' and adf.idt_ferramenta = '.null($vetFiltro['idt_ferramenta']['valor']);
    $sql .= " and adf.ativo = 'S'";
    $sql .= ' ) or EXISTS (';
    $sql .= ' select pffp.idt';
    $sql .= ' from grc_plano_facil_ferramenta_pri pffp';
    $sql .= ' inner join grc_plano_facil_ferramenta pff on pff.idt = pffp.idt_grc_plano_facil_ferramenta';
    $sql .= ' where pffp.idt_atendimento = '.$AliasPric.'.idt';
    $sql .= ' and pff.idt_ferramenta = '.null($vetFiltro['idt_ferramenta']['valor']);
    $sql .= ' )';
    $sql .= ' )';
}

if ($vetFiltro['idt_perspectiva_empresarial']['valor'] != '' && $vetFiltro['idt_perspectiva_empresarial']['valor'] != '-1') {
    $sql .= " and EXISTS (";
    $sql .= " select av.idt";
    $sql .= " from grc_avaliacao av";
    $sql .= ' inner join grc_avaliacao_resposta ar on ar.idt_avaliacao = av.idt';
    $sql .= ' where av.idt_atendimento = '.$AliasPric.'.idt';
    $sql .= ' and ar.idt_resposta = '.null($vetFiltro['idt_perspectiva_empresarial']['valor']);
    $sql .= ' )';
}

if ($caption_dimensao == "") {
    $sql .= " group by td.nome_completo, mes";
} else {
    $sql .= " group by td.{$sql_cpo_dimensao}, mes";
}
$rs = execsql($sql);
//echo "'".$sql."'<br />";
//////////////////////
//
// Define temporária
//
$tabela_dimensao = 'nan'.md5('gec_nan_visita_'.$_SESSION[CS]['g_id_usuario'].'_'.GerarStr());
set_time_limit(0);

$sql = 'DROP TEMPORARY TABLE IF EXISTS '.$tabela_dimensao;
execsql($sql);

$sql = "
	CREATE TEMPORARY TABLE {$tabela_dimensao} (
	  idt          int(10)     unsigned NOT NULL AUTO_INCREMENT,
	  dimensao     varchar(2000) NULL,
	  quantidade   int(10)     unsigned DEFAULT NULL,
	  duracao      int(10)     unsigned DEFAULT NULL,
	  quantidade1  int(10)     unsigned DEFAULT NULL,
	  duracao1     int(10)     unsigned DEFAULT NULL,
      quantidade2  int(10)     unsigned DEFAULT NULL,
	  duracao2     int(10)     unsigned DEFAULT NULL,
      quantidade3  int(10)     unsigned DEFAULT NULL,
	  duracao3     int(10)     unsigned DEFAULT NULL,
      quantidade4  int(10)     unsigned DEFAULT NULL,
	  duracao4     int(10)     unsigned DEFAULT NULL,
      quantidade5  int(10)     unsigned DEFAULT NULL,
	  duracao5     int(10)     unsigned DEFAULT NULL,	  
      quantidade6  int(10)     unsigned DEFAULT NULL,
	  duracao6     int(10)     unsigned DEFAULT NULL,	  
      quantidade7  int(10)     unsigned DEFAULT NULL,
	  duracao7     int(10)     unsigned DEFAULT NULL,	  
      quantidade8  int(10)     unsigned DEFAULT NULL,
	  duracao8     int(10)     unsigned DEFAULT NULL,	  
      quantidade9  int(10)     unsigned DEFAULT NULL,
	  duracao9     int(10)     unsigned DEFAULT NULL,	  
      quantidade10 int(10)     unsigned DEFAULT NULL,
	  duracao10    int(10)     unsigned DEFAULT NULL,	  
	  quantidade11 int(10)     unsigned DEFAULT NULL,
	  duracao11    int(10)     unsigned DEFAULT NULL,	  
	  quantidade12 int(10)     unsigned DEFAULT NULL,
	  duracao12    int(10)     unsigned DEFAULT NULL,	  
	  
	  PRIMARY KEY (`idt`)
	) ENGINE=MEMORY DEFAULT CHARSET=latin1;
";
execsql($sql);
////// gera
$vetTabelaDimensao = Array();
foreach ($rs->data as $row) {
    //echo " {$campo_vet} <br />".$row['dimensao'];
    if ($campo_vet == '') {
        $dimensao = $row['dimensao'];
    } else {
        $dimensao = $row['dimensao'];
        $a = $row['dimensao'];
        //echo " {$a} <br />";
        $dimensao = $vetNanGrupo[$a];
        //$vetCampo['dimensao']        = CriaVetTabela($caption_dimensaow, $campo_tipo, $$campo_vet);
        //  $vetCampo[$CampoPesq] = CriaVetTabela($campo_caption, $campo_tipo, $$campo_vet);
    }
    //p($$campo_vet);
    //echo $$campo_vet['CA'];

    $quantidade = $row['quantidade'];
    $duracao = $row['duracao'];
    $mes = $row['mes'];
    if ($duracao == "") {
        $duracao = 0;
    }
    $vetTabelaDimensao[$dimensao][$mes]['qtd'] = $quantidade;
    $vetTabelaDimensao[$dimensao][$mes]['dur'] = $duracao;
}
//p($vetTabelaDimensao);
// montar inserts
////////////////// total por mes
//	
$dimensaot = aspa(chr(254).chr(254).chr(254)."TOTAL");
$quantidadet = 0;
$duracaot = 0;
$quantidadet1 = 0;
$duracaot1 = 0;
$quantidadet2 = 0;
$duracaot2 = 0;
$quantidadet3 = 0;
$duracaot3 = 0;
$quantidadet4 = 0;
$duracaot4 = 0;
$quantidadet5 = 0;
$duracaot5 = 0;
$quantidadet6 = 0;
$duracaot6 = 0;
$quantidadet7 = 0;
$duracaot7 = 0;
$quantidadet8 = 0;
$duracaot8 = 0;
$quantidadet9 = 0;
$duracaot9 = 0;
$quantidadet10 = 0;
$duracaot10 = 0;
$quantidadet11 = 0;
$duracaot11 = 0;
$quantidadet12 = 0;
$duracaot12 = 0;
//
foreach ($vetTabelaDimensao as $dimensao => $vetmes) {

    $dimensao = aspa($dimensao);
    $quantidade = 0;
    $duracao = 0;
    $quantidade1 = 0;
    $duracao1 = 0;
    $quantidade2 = 0;
    $duracao2 = 0;
    $quantidade3 = 0;
    $duracao3 = 0;
    $quantidade4 = 0;
    $duracao4 = 0;
    $quantidade5 = 0;
    $duracao5 = 0;
    $quantidade6 = 0;
    $duracao6 = 0;
    $quantidade7 = 0;
    $duracao7 = 0;
    $quantidade8 = 0;
    $duracao8 = 0;
    $quantidade9 = 0;
    $duracao9 = 0;
    $quantidade10 = 0;
    $duracao10 = 0;
    $quantidade11 = 0;
    $duracao11 = 0;
    $quantidade12 = 0;
    $duracao12 = 0;
    //
    foreach ($vetmes as $mes => $valores) {
        $q = 'quantidade'.$mes;
        $d = 'duracao'.$mes;

        $qt = 'quantidadet'.$mes;
        $dt = 'duracaot'.$mes;

        $$q = $valores['qtd'];
        $$d = $valores['dur'];

        $$qt = $$qt + $valores['qtd'];
        $$dt = $$dt + $valores['dur'];

        $quantidade = $quantidade + $valores['qtd'];
        $duracao = $duracao + $valores['dur'];

        $quantidadet = $quantidadet + $valores['qtd'];
        $duracaot = $duracaot + $valores['dur'];
    }
    //
    $sql_i = " insert into {$tabela_dimensao} ";
    $sql_i .= ' (  ';
    $sql_i .= " dimensao,  ";
    $sql_i .= " quantidade, ";
    $sql_i .= " duracao, ";
    $sql_i .= " quantidade1, ";
    $sql_i .= " duracao1, ";
    $sql_i .= " quantidade2, ";
    $sql_i .= " duracao2, ";
    $sql_i .= " quantidade3, ";
    $sql_i .= " duracao3, ";
    $sql_i .= " quantidade4, ";
    $sql_i .= " duracao4, ";
    $sql_i .= " quantidade5, ";
    $sql_i .= " duracao5, ";
    $sql_i .= " quantidade6, ";
    $sql_i .= " duracao6, ";
    $sql_i .= " quantidade7, ";
    $sql_i .= " duracao7, ";
    $sql_i .= " quantidade8, ";
    $sql_i .= " duracao8, ";
    $sql_i .= " quantidade9, ";
    $sql_i .= " duracao9, ";
    $sql_i .= " quantidade10, ";
    $sql_i .= " duracao10, ";
    $sql_i .= " quantidade11, ";
    $sql_i .= " duracao11, ";
    $sql_i .= " quantidade12, ";
    $sql_i .= " duracao12 ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $dimensao,  ";
    $sql_i .= " $quantidade, ";
    $sql_i .= " $duracao, ";
    $sql_i .= " $quantidade1, ";
    $sql_i .= " $duracao1, ";
    $sql_i .= " $quantidade2, ";
    $sql_i .= " $duracao2, ";
    $sql_i .= " $quantidade3, ";
    $sql_i .= " $duracao3, ";
    $sql_i .= " $quantidade4, ";
    $sql_i .= " $duracao4, ";
    $sql_i .= " $quantidade5, ";
    $sql_i .= " $duracao5, ";
    $sql_i .= " $quantidade6, ";
    $sql_i .= " $duracao6, ";
    $sql_i .= " $quantidade7, ";
    $sql_i .= " $duracao7, ";
    $sql_i .= " $quantidade8, ";
    $sql_i .= " $duracao8, ";
    $sql_i .= " $quantidade9, ";
    $sql_i .= " $duracao9, ";
    $sql_i .= " $quantidade10, ";
    $sql_i .= " $duracao10, ";
    $sql_i .= " $quantidade11, ";
    $sql_i .= " $duracao11, ";
    $sql_i .= " $quantidade12, ";
    $sql_i .= " $duracao12 ";
    $sql_i .= ') ';

//	p($sql_i);

    execsql($sql_i, false);
}



$sql_i = " insert into {$tabela_dimensao} ";
$sql_i .= ' (  ';
$sql_i .= " dimensao,  ";
$sql_i .= " quantidade, ";
$sql_i .= " duracao, ";
$sql_i .= " quantidade1, ";
$sql_i .= " duracao1, ";
$sql_i .= " quantidade2, ";
$sql_i .= " duracao2, ";
$sql_i .= " quantidade3, ";
$sql_i .= " duracao3, ";
$sql_i .= " quantidade4, ";
$sql_i .= " duracao4, ";
$sql_i .= " quantidade5, ";
$sql_i .= " duracao5, ";
$sql_i .= " quantidade6, ";
$sql_i .= " duracao6, ";
$sql_i .= " quantidade7, ";
$sql_i .= " duracao7, ";
$sql_i .= " quantidade8, ";
$sql_i .= " duracao8, ";
$sql_i .= " quantidade9, ";
$sql_i .= " duracao9, ";
$sql_i .= " quantidade10, ";
$sql_i .= " duracao10, ";
$sql_i .= " quantidade11, ";
$sql_i .= " duracao11, ";
$sql_i .= " quantidade12, ";
$sql_i .= " duracao12 ";
$sql_i .= '  ) values ( ';
$sql_i .= " $dimensaot,  ";
$sql_i .= " $quantidadet, ";
$sql_i .= " $duracaot, ";
$sql_i .= " $quantidadet1, ";
$sql_i .= " $duracaot1, ";
$sql_i .= " $quantidadet2, ";
$sql_i .= " $duracaot2, ";
$sql_i .= " $quantidadet3, ";
$sql_i .= " $duracaot3, ";
$sql_i .= " $quantidadet4, ";
$sql_i .= " $duracaot4, ";
$sql_i .= " $quantidadet5, ";
$sql_i .= " $duracaot5, ";
$sql_i .= " $quantidadet6, ";
$sql_i .= " $duracaot6, ";
$sql_i .= " $quantidadet7, ";
$sql_i .= " $duracaot7, ";
$sql_i .= " $quantidadet8, ";
$sql_i .= " $duracaot8, ";
$sql_i .= " $quantidadet9, ";
$sql_i .= " $duracaot9, ";
$sql_i .= " $quantidadet10, ";
$sql_i .= " $duracaot10, ";
$sql_i .= " $quantidadet11, ";
$sql_i .= " $duracaot11, ";
$sql_i .= " $quantidadet12, ";
$sql_i .= " $duracaot12 ";
$sql_i .= ') ';

//	p($sql_i);

execsql($sql_i, false);


//
// Para o FULL
//
$sql = "select ";
$sql .= " * ";
$sql .= " from ";
$sql .= $tabela_dimensao;
//
set_time_limit(30);
//
//
if ($_POST['md5_vetcampo'] != md5(serialize($vetCampo))) {
    $_REQUEST['sqlOrderby'] = "";
    $_GET['sqlOrderby'] = "";
    $_POST['sqlOrderby'] = "";
    $_POST['sql_orderby'] = "";
}



//p($_POST['sql_orderby']);
$Filtro = Array();
$Filtro['rs'] = 'Hidden';
$Filtro['id'] = 'md5_vetcampo';
$Filtro['valor'] = md5(serialize($vetCampo));
$vetFiltro['md5_vetcampo'] = $Filtro;

//
// Monta Vetores Gráfico
//
$sqlt = "select ";
$sqlt .= " * ";
$sqlt .= " from ";
$sqlt .= $tabela_dimensao;
$sqlt .= " order by quantidade desc ";
$rst = execsql($sqlt);
$vetDimensaoQtd = Array();
$vetDimensaoPer = Array();
$dimensaot = (chr(254).chr(254).chr(254)."TOTAL");
foreach ($rst->data as $rowt) {

    $dimensao = $rowt['dimensao'];
    if ($dimensao == $dimensaot) {
        continue;
    }
    $quantidade = $rowt['quantidade'];

    $quantidade1 = $rowt['quantidade1'];
    $quantidade2 = $rowt['quantidade2'];
    $quantidade3 = $rowt['quantidade3'];
    $quantidade4 = $rowt['quantidade4'];
    $quantidade5 = $rowt['quantidade5'];
    $quantidade6 = $rowt['quantidade6'];
    $quantidade7 = $rowt['quantidade7'];
    $quantidade8 = $rowt['quantidade8'];
    $quantidade9 = $rowt['quantidade9'];
    $quantidade10 = $rowt['quantidade10'];
    $quantidade11 = $rowt['quantidade11'];
    $quantidade12 = $rowt['quantidade12'];
    //	
    $vetQtd = Array();
    $vetQtd[] = $quantidade1;
    $vetQtd[] = $quantidade2;
    $vetQtd[] = $quantidade3;
    $vetQtd[] = $quantidade4;
    $vetQtd[] = $quantidade5;
    $vetQtd[] = $quantidade6;
    $vetQtd[] = $quantidade7;
    $vetQtd[] = $quantidade8;
    $vetQtd[] = $quantidade9;
    $vetQtd[] = $quantidade10;
    $vetQtd[] = $quantidade11;
    $vetQtd[] = $quantidade12;
    $vetPer = Array();
    if ($quantidade == 0) {
        $quantidade = 1;
    }
    $vetPer[] = desformat_decimal(format_decimal(($quantidade1 / $quantidade) * 100, 2));
    $vetPer[] = desformat_decimal(format_decimal(($quantidade2 / $quantidade) * 100, 2));
    $vetPer[] = desformat_decimal(format_decimal(($quantidade3 / $quantidade) * 100, 2));
    $vetPer[] = desformat_decimal(format_decimal(($quantidade4 / $quantidade) * 100, 2));
    $vetPer[] = desformat_decimal(format_decimal(($quantidade5 / $quantidade) * 100, 2));
    $vetPer[] = desformat_decimal(format_decimal(($quantidade6 / $quantidade) * 100, 2));
    $vetPer[] = desformat_decimal(format_decimal(($quantidade7 / $quantidade) * 100, 2));
    $vetPer[] = desformat_decimal(format_decimal(($quantidade8 / $quantidade) * 100, 2));
    $vetPer[] = desformat_decimal(format_decimal(($quantidade9 / $quantidade) * 100, 2));
    $vetPer[] = desformat_decimal(format_decimal(($quantidade10 / $quantidade) * 100, 2));
    $vetPer[] = desformat_decimal(format_decimal(($quantidade11 / $quantidade) * 100, 2));
    $vetPer[] = desformat_decimal(format_decimal(($quantidade12 / $quantidade) * 100, 2));

    $vetDimensao[$dimensao]['qtd'] = $vetQtd;
    $vetDimensao[$dimensao]['per'] = $vetPer;
}
?>
<script type="text/javascript">




    var diasint = 15;

    $(document).ready(function () {
        $("#filtro_id_usuario").cascade("#filtro_ponto_atendimento", {ajax: {
                url: ajax_sistema + '?tipo=pa_consultor&cas=' + conteudo_abrir_sistema
            }});

        $('#filtro_dt_ini, #filtro_dt_fim').change(function () {
            valida_dt();
        });
        // Instrumento
        var id = 'instrumento2';
        objtp = document.getElementById(id);
        if (objtp != null) {
            objtp.value = instrumento;
        }

        /*
         var id='div_'+instrumento+'_img';
         objtp = document.getElementById(id);
         if (objtp != null) {
         $(objtp).css('borderColor','#0000FF');
         }
         */
        //document.frm.submit();



    });

    function valida_dt() {
        if (validaDataMaior(false, $('#filtro_dt_fim'), 'Dt. Fim', $('#filtro_dt_ini'), 'Dt. Inicio') === false) {
            $('#filtro_dt_fim').val('');
            $('#filtro_dt_fim').focus();
            return false;
        }

        /*
         if (newDataHoraStr(false, $('#filtro_dt_fim').val()) - newDataHoraStr(false, $('#filtro_dt_ini').val()) >= (diasint * 24 * 60 * 60 * 1000)) {
         alert('O intervalo entre as datas não pode ser superior a ' + diasint + ' dias!');
         $('#filtro_dt_fim').val('');
         $('#filtro_dt_fim').focus();
         return false;
         }
         */
    }

    function fncListarCmbMuda_idt_projeto() {
        $('#idt_acao_bt_limpar').click();
    }

    function parListarCmb_idt_acao() {
        var par = '';

        if ($('#idt_projeto').val() == '') {
            alert('Favor informar o Projeto!');
            return false;
        } else {
            par += '&idt_projeto=' + $('#idt_projeto').val();
        }

        return par;
    }

// Clicado no Cabeçalho	
    function lista_td_cab_acao_click(nome_campo, obj_jquery)
    {
        // alert('Clicado no cabeçalho '+nome_campo);
    }
// Clicado na Linha	
    function lista_td_acao_click(idt_linha, nome_campo, obj_jquery)
    {
        // alert('Clicado na linha campo = '+nome_campo+' idt = '+idt_linha);
        // alert('Clicado na linha campo VAL = '+obj_jquery.text(88));
        // alert('Clicado na linha campo HTML = '+obj_jquery.html());

    }
</script>


