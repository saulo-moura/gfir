<?php
$ordFiltro = false;
$idCampo = 'idt';
$Tela = "o Atendimento";

$listar_sql_limit = false;

$TabelaPrinc = "grc_atendimento";
$AliasPric = "grc_atd";
$Entidade = "Atendimento";
$Entidade_p = "Atendimentos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$_SESSION[CS]['grc_atendimento_listar'] = $_SERVER['REQUEST_URI'];

$barra_inc_ap = false;
$barra_alt_ap = false;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;

function func_trata_row_grc_atendimento($row) {
    global $barra_alt_ap;

    if ($row['situacao'] == 'Finalizado') {
        $barra_alt_ap = false;
    } else {
        $barra_alt_ap = true;
    }
}

$func_trata_row = func_trata_row_grc_atendimento;

$barra_inc_img = "imagens/incluir_novo_atendimento.png";
//$barra_alt_img = "imagens/agenda_alterar.png";
//$barra_con_img = "imagens/agenda_consultar.png";

$barra_inc_h = 'Clique aqui para Incluir um Novo Atendimento';
$barra_alt_h = 'Alterar o Atendimento';
$barra_con_h = 'Consultar o Atendimento';

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

$distancia = $_GET['distancia'];

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
//p($_GET);
//$_GET['instrumento']=1;

echo "<div class='cab_1' >";
$recepcao = $_GET['recepcao'];
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




// Descida para o nivel 2

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
$Filtro['rs'] = Array(
    'PIR' => 'PIR',
    'WEBSERVICE' => 'WEBSERVICE',
);
$Filtro['id'] = 'filtro_evento_origem';
$Filtro['nome'] = 'Origem do Registro';
$Filtro['LinhaUm'] = '-- Todos --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['evento_origem'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = $vetSimNao;
$Filtro['id'] = 'filtro_erro';
$Filtro['nome'] = 'Integração com Erro';
$Filtro['valor'] = trata_id($Filtro);
//$vetFiltro['erro'] = $Filtro;
//echo " -------------    $idt_ponto_atendimento ";

if ($idt_usuario == 1) {
    $fixaunidade = 0;
} else {
    $fixaunidade = 1;
}

if ($fixaunidade == 0) {   // Todos
    $sql = 'select ';
    $sql .= '   idt, descricao  ';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao sac_os ';
    $sql .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
    $sql .= ' order by classificacao ';
} else {
    $sql = 'select ';
    $sql .= '   idt, descricao  ';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao sac_os ';


    $sql .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S' ) ";

    if ($_SESSION[CS]['g_atendimento_relacao'] == 'G') {
        $sql .= ' and SUBSTRING(classificacao, 1, 5) = ('; //and
        $sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
        $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
        $sql .= ' where idt = ' . null($idt_ponto_atendimento);
        $sql .= ' )';
    } else {
        $sql .= "   and idt = " . null($idt_ponto_atendimento);
    }


    $sql .= ' order by classificacao ';
}
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'filtro_ponto_atendimento';
$Filtro['id_select'] = 'idt';
$Filtro['js_tam'] = '0';

if ($fixaunidade == 0) {
    $Filtro['LinhaUm'] = '-- Selecione o PA --';
}

$Filtro['nome'] = 'Pontos de Atendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;

$sql = "select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
$sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt_usuario = plu_usu.id_usuario ";
$sql .= " where grc_pap.idt_ponto_atendimento = " . null($vetFiltro['ponto_atendimento']['valor']);
$sql .= " order by plu_usu.nome_completo";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'filtro_id_usuario';
$Filtro['id_select'] = 'id_usuario';
$Filtro['js_tam'] = '0';

if ($fixaunidade == 0) {
    $Filtro['LinhaUm'] = '-- Selecione o Consultor --';
}

$Filtro['nome'] = 'Consultores';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_consultor'] = $Filtro;




// p($_GET);
$instrumento = $_GET['instrumento'];
//  p($_GET);


$idt_instrumento = "";

$vetInstrumento = Array();
if ($instrumento == 1) {
    $vetInstrumento[8] = 'INFORMAÇÃO';
    $idt_instrumento = 8;
}
if ($instrumento == 2) {
    $vetInstrumento[13] = 'ORIENTAÇÃO TÉCNICA';
    $idt_instrumento = 13;
}
if ($instrumento == 3) {
    $vetInstrumento[2] = 'CONSULTORIA';
    $idt_instrumento = 2;
}

if ($idt_instrumento == "") {
    
}

/*
  $vetInstrumento[4]  = 'CURSO';
  $vetInstrumento[5]  = 'FEIRA';
  $vetInstrumento[6]  = 'MISSÃO/CARAVANA';
  $vetInstrumento[7]  = 'OFICINA';
  $vetInstrumento[8]  = 'PALESTRA';
  $vetInstrumento[9]  = 'RODADA DE NEGÓCIO';
  $vetInstrumento[10] = 'SEMINÁRIO';
 */


$Filtro = Array();
$sql = "select idt, descricao from grc_atendimento_instrumento";
if ($instrumento != 500) {
    $sql .= " where idt = " . null($idt_instrumento);
} else {
    $sql .= " where idt = 2 or idt = 8 or idt = 13 ";
}
$sql .= " order by codigo";
$rs = execsql($sql);

$Filtro['rs'] = $rs;
$Filtro['id'] = 'filtro_idt_instrumento';
$Filtro['id_select'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Instrumentos';
if ($instrumento != 500) {
    $Filtro['vlPadrao'] = $idt_instrumento;
} else {
    $Filtro['LinhaUm'] = '-- Selecione o Instrumento --';
}
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_instrumento'] = $Filtro;
if ($instrumento == '') {
//        $idt_instrumento    = $vetFiltro['idt_instrumento']['valor'];
}




$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_ini';
$Filtro['vlPadrao'] = Date('d/m/Y');
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data Inicial';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_ini'] = $Filtro;
//p($Filtro);

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_fim';
//$Filtro['vlPadrao']  = Date('d/m/Y', strtotime('+45 day'));
$Filtro['vlPadrao'] = Date('d/m/Y');
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data Final';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_fim'] = $Filtro;




if ($instrumento == 500) {
    $Filtro = Array();
    $Filtro['rs'] = 'Texto';
    $Filtro['id'] = 'filtro_protocolo';
    $Filtro['js_tam'] = '0';
    $Filtro['nome'] = 'Protocolo';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['protocolo'] = $Filtro;
}

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

if ($vetFiltro['idt_consultor']['valor'] != '' AND $vetFiltro['idt_consultor']['valor'] != '-1') {
    // o consultor esta fixado.
} else {
    $vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Consultor');
}

$vetCampo['protocolo'] = CriaVetTabela('Protocolo');
$vetCampo['ap_cpf'] = CriaVetTabela('CPF / Cliente');
$vetCampo['cnpj_porte'] = CriaVetTabela('CNPJ / Porte');
$vetCampo['data'] = CriaVetTabela('Data', 'data');
$vetCampo['hora_inicio_atendimento'] = CriaVetTabela('Hora Inicial');
$vetCampo['hora_termino_atendimento'] = CriaVetTabela('Hora Final');
$vetCampo['situacao'] = CriaVetTabela('Situação');
$vetCampo['grc_ai_descricao'] = CriaVetTabela('Instrumento');
$vetCampo['evento_origem'] = CriaVetTabela('Origem');

function ftd_siac($valor, $row, $Campo) {
    $html = '';
    $style = 'style="cursor: help;"';

    if ($valor != '') {
        if ($row[$Campo . '_erro'] == '') {
            $html .= '<img src="imagens/icone_ok.gif" title="' . $valor . '" ' . $style . ' />';
        } else {
            $html .= '<img src="imagens/valor_alterado.png" title="' . $valor . ' - ' . $row[$Campo . '_erro'] . '" ' . $style . ' />';
        }
    }

    return $html;
}

//$vetCampo['siacf'] = CriaVetTabela('PF', 'func_trata_dado', ftd_siac);
//$vetCampo['siacj'] = CriaVetTabela('PJ', 'func_trata_dado', ftd_siac);
//$vetCampo['siach'] = CriaVetTabela('AT', 'func_trata_dado', ftd_siac);

$sql = "select ";
$sql .= "   {$AliasPric}.*,  ";
$sql .= " concat_ws('<br />', ap.cpf, ap.nome) as ap_cpf,";
$sql .= " concat_ws('<br />', ao.cnpj, concat_ws(' - ', op.descricao, op.desc_vl_cmb)) as cnpj_porte,";
$sql .= "    plu_usu.nome_completo as plu_usu_nome_completo, ";
$sql .= " date_format(siacf.dt_sincroniza, '%d/%m/%Y %H:%i:%s') as siacf,";
$sql .= " date_format(siacj.dt_sincroniza, '%d/%m/%Y %H:%i:%s') as siacj,";
$sql .= " date_format(siach.dt_sincroniza, '%d/%m/%Y %H:%i:%s') as siach,";
$sql .= ' siacf.erro as siacf_erro,';
$sql .= ' siacj.erro as siacj_erro,';
$sql .= ' siach.erro as siach_erro,';
$sql .= "    ao.razao_social as grc_ent_descricao,  ";
$sql .= "    grc_ai.descricao as grc_ai_descricao  ";
$sql .= " from {$TabelaPrinc
        }

 as {$AliasPric} ";
$sql .= " left join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_consultor ";
$sql .= " left join grc_atendimento_instrumento grc_ai on grc_ai.idt = {$AliasPric}.idt_instrumento ";
$sql .= " left outer join grc_atendimento_pessoa ap on ap.idt_atendimento = {$AliasPric}.idt and ap.tipo_relacao = 'L'";
$sql .= " left outer join grc_atendimento_organizacao ao on ao.idt_atendimento = {$AliasPric}.idt and ao.representa = 'S' and ao.desvincular = 'N'";
$sql .= " left outer join " . db_pir_gec . "gec_organizacao_porte op on op.idt = ao.idt_porte";
$sql .= " left outer join grc_sincroniza_siac siacf on siacf.idt_atendimento = {$AliasPric}.idt and siacf.tipo_entidade = 'F' and siacf.representa = 'S'";
$sql .= " left outer join grc_sincroniza_siac siacj on siacj.idt_atendimento = {$AliasPric}.idt and siacj.tipo_entidade = 'J' and siacj.representa = 'S'";
$sql .= " left outer join grc_sincroniza_siac siach on siach.idt_atendimento = {$AliasPric}.idt and siach.tipo = 'H'";

$dt_iniw = trata_data($vetFiltro['dt_ini']['valor']);
$dt_fimw = trata_data($vetFiltro['dt_fim']['valor']);

//if ($vetFiltro['consgetadatas']['valor']=="S")
//{
$sql .= ' where ';
$sql .= " {$AliasPric}.data >= " . aspa($dt_iniw) . " and {$AliasPric}.data <=  " . aspa($dt_fimw) . " ";

$sql .= " and {$AliasPric}.idt_evento is null";
$sql .= " and {$AliasPric}.idt_grupo_atendimento is null";


if ($distancia == 'D') {
    $sql .= " and {$AliasPric}.origem = " . aspa('D');
} else {
    $sql .= " and {$AliasPric}.origem = " . aspa('P');
}



//$sql .= " and exists(select idt from grc_sincroniza_siac s where s.idt_atendimento = {$AliasPric}.idt)";

/*
  if ($vetFiltro['erro']['valor'] == 'S') {
  $sql .= " and (";
  $sql .= ' siacf.erro is not null';
  $sql .= ' or siacj.erro is not null';
  $sql .= ' or siach.erro is not null';
  $sql .= ' )';
  } else {
  $sql .= ' and siacf.erro is null';
  $sql .= ' and siacj.erro is null';
  $sql .= ' and siach.erro is null';
  }
 */
$fezwere = 1;
//}


if ($vetFiltro['idt_instrumento']['valor'] != '' AND $vetFiltro['idt_instrumento']['valor'] != '-1') {
    if ($fezwere == 0) {
        $sql .= ' where ';
        $fezwere = 1;
    } else {
        $sql .= ' and ';
    }
    $sql .= " {$AliasPric}.idt_instrumento= " . null($vetFiltro['idt_instrumento']['valor']);
}



if ($vetFiltro['ponto_atendimento']['valor'] != '' AND $vetFiltro['ponto_atendimento']['valor'] != '-1') {
    if ($fezwere == 0) {
        $sql .= ' where ';
        $fezwere = 1;
    } else {
        $sql .= ' and ';
    }
    $sql .= " {$AliasPric}.idt_ponto_atendimento= " . null($vetFiltro['ponto_atendimento']['valor']);
}
if ($vetFiltro['idt_consultor']['valor'] != '' AND $vetFiltro['idt_consultor']['valor'] != '-1') {
    if ($fezwere == 0) {
        $sql .= ' where ';
        $fezwere = 1;
    } else {
        $sql .= ' and ';
    }
    $sql .= " ({$AliasPric}.idt_consultor= " . null($vetFiltro['idt_consultor']['valor']) . " or {$AliasPric}.idt_consultor is null or {$AliasPric}.idt_consultor = 0)";
}


if ($instrumento == 500) {
    if ($vetFiltro['protocolo']['valor'] != "") {
        $sql .= ' and ';
        $sql .= ' ( ';
        $sql .= '  lower(' . $AliasPric . '.protocolo)      like lower(' . aspa($vetFiltro['protocolo']['valor'], '%', '%') . ')';
        $sql .= ' ) ';
    }
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower(' . $AliasPric . '.senha_totem)      like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(' . $AliasPric . '.assunto) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(' . $AliasPric . '.protocolo) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' ) ';
}

if ($vetFiltro['evento_origem']['valor'] != "0") {
    $sql .= ' and ' . $AliasPric . '.evento_origem = ' . aspa($vetFiltro['evento_origem']['valor']);
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



</script>
