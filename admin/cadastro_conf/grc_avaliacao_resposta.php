<style>
    fieldset.class_frame_t {
        background:#FFBF40;
        border:1px solid #FFFFFF;
    }
    div.class_titulo_t {
        background: #FFBF40;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        padding-top:10px;
    }
    div.class_titulo_t span {
        padding-left:20px;
        text-align: left;
    }
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
    }

    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        padding-top:10px;
    }

    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }
    fieldset.class_frame_p {
        background:#FFFFFF;
        border:0px solid #FFFFFF;
    }
    div.class_titulo_p {
        background: #2F66B8;
        text-align: left;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        color     : #FFFFFF;
        text-align: left;
        height    : 20px;
        font-size : 12px;
        padding-top:5px;
    }
    div.class_titulo_p span {
        padding:10px;
        text-align: left;
    }
    div.class_titulo_p_barra {
        text-align: left;
        background: #c4c9cd;
        border    : none;
        color     : #FFFFFF;
        font-weight: bold;
        line-height: 12px;
        margin: 0;
        padding: 3px;
        padding-left: 20px;
    }

    fieldset.class_frame {
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }
    div.class_titulo {
        text-align: left;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }
    div.class_titulo span {
        padding-left:10px;
    }
    div.class_titulo_c {
        text-align: center;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo_c span {
        padding-left:10px;
    }
    Select {
        border:0px;
        height:28px;
    }
    .TextoFixo {
        font-size:12px;
        text-align:left;
        border:0px;
        background:#ECF0F1;
        font-weight:normal;
        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;
    }
    td#idt_competencia_obj div {
        color:#FF0000;
    }
    .Tit_Campo {
        font-size:12px;
    }
    td.Titulo {
        color:#666666;
    }
    .formulario .detalhe {
        margin-bottom: 10px;
        padding: 5px;
        background-color: #ffffd7;
        border: 0px solid #508098;
        color: #000000;
        width:100%;
        display:block;
    }
    .formulario .detalhe_secao {
        margin-bottom: 10px;
        padding: 5px;
        background-color: #14ADCC;
        border: 1px solid #FFFFFF;
        color: #000000;
        width:100%;
        display:block;
    }

    .formulario .pergunta_cont {
        border: 0px solid #000000;
        margin-bottom: 10px;
        padding: 3px;
    }
    .formulario .pergunta_cont ul {

        padding-bottom: 5px;
    }

    .formulario .pergunta {
        margin-bottom: 10px;
        padding: 5px;
        background-color: #ecf0f1;
        border: 0px solid #508098;
        color:#000000;
    }

    .formulario ul {
        overflow: hidden;
        list-style-type: none;
        padding: 0px;
        margin: 0px;
    }

    .formulario ul > li {
        padding: 0px;
        margin: 0px;
        color: #00297b;
        color: #000000;
    }

    .formulario ul > li .detalhe {
        margin-bottom: 10px;
    }

    .formulario ul > li > label {
        cursor: pointer;
        display: block;
        margin: 3px 0px;
    }

    .formulario ul > li > label > input {
        cursor: pointer;
        vertical-align: top;
        padding: 0px;
        margin: 0px;
        margin-right: 5px;

    }

    .formulario ul > li > div > textarea {
        background: #F6F6F6;
        color: #000000;
        margin: 0px;
        margin-top: 3px;
        padding: 0px;
        border: 0px solid #508098;
        height: 45px;
        width: 100%;
    }

    .evidencia {
        display:block;
        width: 70%;
        padding-top:10px;
        display: none;
    }
    .frame {
        border: 0px solid #508098;
    }

    td.asa {
        padding-left: 20px;
        width: 50%;
        vertical-align: top;
    }

    .txt_s {
        width:100%;
        height:70px;
    }
</style>
<?php
$controle_fecha = 'F';

if ($_GET['idt_pfo_af_processo'] != '') {
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_avaliacao';
    $sql .= ' where idt_pfo_af_processo = ' . null($_GET['idt_pfo_af_processo']);
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        $sql = '';
        $sql .= ' select idt, chaveorigem, cnpjcpf, sebraebacpf';
        $sql .= ' from ' . db_pir_pfo . 'pfo_af_processo';
        $sql .= ' where idt = ' . null($_GET['idt_pfo_af_processo']);
        $rs = execsql($sql);
        $row = $rs->data[0];

        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade';
        $sql .= ' where codigo = ' . aspa(FormataCPF12($row['sebraebacpf']));
        $sql .= " and reg_situacao = 'A'";
        $rs = execsql($sql);
        $idt_avaliado = $rs->data[0][0];

        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade';
        $sql .= ' where codigo = ' . aspa(FormataCNPJ($row['cnpjcpf']));
        $sql .= " and reg_situacao = 'A'";
        $rs = execsql($sql);
        $idt_organizacao_avaliado = $rs->data[0][0];

        $idt_formulario = 5;

        $sql = 'insert into grc_avaliacao (';
        $sql .= ' codigo, descricao, idt_responsavel_registro, idt_avaliador,';
        $sql .= ' idt_avaliado, idt_organizacao_avaliado, data_avaliacao, data_registro, idt_formulario, idt_situacao, idt_pfo_af_processo, grupo';
        $sql .= ') values (';
        $sql .= aspa($row['idt']) . ', ' . aspa($row['chaveorigem']) . ', ' . null($_SESSION[CS]['g_id_usuario']) . ', ' . null($_SESSION[CS]['g_id_usuario']) . ', ';
        $sql .= null($idt_avaliado) . ', ' . null($idt_organizacao_avaliado) . ', now(), now(), ' . null($idt_formulario) . ', 1, ' . null($row['idt']) . ", 'PFO'";
        $sql .= ')';
        execsql($sql);
        $_GET['id'] = lastInsertId();
    } else {
        $_GET['id'] = $rs->data[0][0];
    }

    $acao = 'alt';
    $controle_fecha = 'A';
}

if (nan === 'S' or $direto == 1) {
    $sql = '';
    $sql .= ' select ef.idt as idt_avaliador, eo.idt as idt_organizacao_avaliador';
    $sql .= ' from grc_atendimento a';
    $sql .= ' inner join plu_usuario uf on uf.id_usuario = a.idt_consultor';
    $sql .= " inner join " . db_pir_gec . "gec_entidade ef on ef.codigo = uf.login and ef.reg_situacao = 'A'";
    $sql .= ' inner join plu_usuario uo on uo.id_usuario = a.idt_nan_empresa';
    $sql .= " inner join " . db_pir_gec . "gec_entidade eo on eo.codigo = uo.login and eo.reg_situacao = 'A'";
    $sql .= ' where a.idt = ' . null($idt_atendimento);
    $rs = execsql($sql);
    $row = $rs->data[0];

    $idt_avaliador = $row['idt_avaliador'];
    $idt_organizacao_avaliador = $row['idt_organizacao_avaliador'];

    $sql = '';
    $sql .= ' select cpf';
    $sql .= ' from grc_atendimento_pessoa';
    $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
    $sql .= " and tipo_relacao = 'L'";
    $rs = execsql($sql);

    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade';
    $sql .= ' where codigo = ' . aspa(FormataCPF12($rs->data[0][0]));
    $sql .= " and reg_situacao = 'A'";
    $rs = execsql($sql);
    $idt_avaliado = $rs->data[0][0];

    $sql = '';
    $sql .= ' select cnpj';
    $sql .= ' from grc_atendimento_organizacao';
    $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
    $sql .= " and representa = 'S'";
    $sql .= " and desvincular = 'N'";
    $rs = execsql($sql);

    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade';
    $sql .= ' where codigo = ' . aspa(FormataCNPJ($rs->data[0][0]));
    $sql .= " and reg_situacao = 'A'";
    $rs = execsql($sql);
    $idt_organizacao_avaliado = $rs->data[0][0];

    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_avaliacao';
    $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        $idt_formulario = 4;

        $sql = 'insert into grc_avaliacao (';
        $sql .= ' codigo, descricao, idt_responsavel_registro, idt_avaliador, idt_organizacao_avaliador,';
        $sql .= ' idt_avaliado, idt_organizacao_avaliado, data_avaliacao, data_registro, idt_formulario, idt_situacao, idt_atendimento, grupo';
        $sql .= ') values (';
        $sql .= aspa($idt_atendimento) . ', ' . aspa($protocolo) . ', ' . null($_SESSION[CS]['g_id_usuario']) . ', ' . null($idt_avaliador) . ', ' . null($idt_organizacao_avaliador) . ', ';
        $sql .= null($idt_avaliado) . ', ' . null($idt_organizacao_avaliado) . ', now(), now(), ' . null($idt_formulario) . ', 1, ' . null($idt_atendimento) . ", 'NAN'";
        $sql .= ')';
        execsql($sql);
        $_GET['id'] = lastInsertId();
    } else {
        $_GET['id'] = $rs->data[0][0];

        $sql = 'update grc_avaliacao set';
        $sql .= ' idt_avaliador = ' . null($idt_avaliador) . ',';
        $sql .= ' idt_organizacao_avaliador = ' . null($idt_organizacao_avaliador) . ',';
        $sql .= ' idt_avaliado = ' . null($idt_avaliado) . ',';
        $sql .= ' idt_organizacao_avaliado = ' . null($idt_organizacao_avaliado);
        $sql .= ' where idt = ' . null($_GET['id']);
        execsql($sql);
    }

    if ($_GET['acao'] == '') {
        $acao = 'alt';
    }

    if ($_GET['pesquisa'][0] == 'S') {
        $acao = 'alt';
        $acao_alt_con = 'S';
    }

    $controle_fecha = 'A';
}

if ($_GET['nan'] === 's') {
    $acao = 'con';
    $controle_fecha = 'A';
    ?>
    <style type="text/css">
        .Barra {
            display: none;
        }
    </style>
    <?php
}
if ($direto == 1) {
    $acao = 'con';
    $controle_fecha = 'F';
    ?>
    <style type="text/css">
        .Barra {
            display: none;
        }
    </style>
    <?php
}

if ($_GET['aba'] == '3') {
    if ($_POST['situacao'] == 'Volta') {
        $href = "conteudo{$cont_arq}.php?prefixo=inc&menu=grc_nan_visita_1&session_volta=" . $_GET['session_volta'] . "&idt_atendimento_agenda=" . $_GET['idt_atendimento_agenda'] . "&idt_atendimento=" . $_GET['idt_atendimento'] . "&id=" . $_GET['idt_atendimento_agenda'] . "&pesquisa=" . $_GET['pesquisa'] . "&aba=1";
    } else {
        $href = "conteudo{$cont_arq}.php?prefixo=inc&menu=grc_nan_visita_1&session_volta=" . $_GET['session_volta'] . "&idt_atendimento_agenda=" . $_GET['idt_atendimento_agenda'] . "&idt_atendimento=" . $_GET['idt_atendimento'] . "&id=" . $_GET['idt_atendimento_agenda'] . "&pesquisa=" . $_GET['pesquisa'] . "&aba=2";
    }

    $bt_alterar_lbl = 'Avançar';
    $botao_volta = "btAcaoVoltar();";
    $botao_acao = '<script type="text/javascript">self.location = "' . $href . '";</script>';
}

$tabela = '';
$onSubmitDep = 'grc_avaliacao_resposta_dep()';
$onSubmitCon = 'grc_avaliacao_resposta_con()';


$class_frame_t = "class_frame_t";
$class_titulo_t = "class_titulo_t";

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$sql = '';
$sql .= ' select idt_resposta, resposta_txt, idt_secao, idt_pergunta';
$sql .= ' from grc_avaliacao_resposta';
$sql .= ' where idt_avaliacao = ' . null($_GET['id']);
$rs = execsql($sql);

if ($acao != 'con') {
    if ($rs->rows > 0) {
        //$acao = 'con';
        //echo '<script type="text/javascript">alert("Avaliação já respondida! Agora só pode consultar.")</script>';
        //alert('Avaliação já respondida! Agora só pode consultar.');
        //alert('Avaliação já tem respostas!');
    }
}


$vetResp = Array();
$vetRespRespondida = Array();
foreach ($rs->data as $row) {
    $vetResp[$row['idt_resposta']] = $row['resposta_txt'];

    $vetRespRespondida[$row['idt_secao']] [$row['idt_pergunta']] = $row['idt_resposta'];
}
//p($vetRespRespondida);
// para evidencias da secao
$vetRespS = Array();
$sql = '';
$sql .= ' select evidencia, idt_secao ';
$sql .= ' from grc_avaliacao_secao';
$sql .= ' where idt_avaliacao = ' . null($_GET['id']);
$rs = execsql($sql);
foreach ($rs->data as $row) {
    $vetRespS[$row['idt_secao']] = $row['evidencia'];
}

//p($vetRespS);





if ($_GET['id'] == 0) {
    $row['idt_formulario'] = $idt_formulario;
} else {
    $sql = '';
    $sql .= ' select *';
    $sql .= ' from grc_avaliacao';
    $sql .= ' where idt = ' . null($_GET['id']);
    $rs = execsql($sql);
    $row = $rs->data[0];
}

$_GET['idt_avaliado'] = $row['idt_avaliado'];
$_GET['idt_organizacao_avaliado'] = $row['idt_organizacao_avaliado'];
$_GET['idt_avaliador'] = $row['idt_avaliador'];
$_GET['idt_organizacao_avaliador'] = $row['idt_organizacao_avaliador'];


$sistema_origem = DecideSistema();


$vetParametros = Array(
    'situacao_padrao' => true,
);
//$vetFrm[] = Frame("<span>{$row['descricao']}</span>", '', $class_frame_t, $class_titulo_t, $titulo_na_linha, $vetParametros);

if ($sistema_origem == 'GEC') {
    $vetFrm[] = Frame("<span>AVALIAÇÃO GC</span>", '', $class_frame_t, $class_titulo_t . ' div_btp', $titulo_na_linha, $vetParametros);
} else {
    $vetFrm[] = Frame("<span>DIAGNÓSTICO SITUACIONAL</span>", '', $class_frame_t, $class_titulo_t . ' div_btp', $titulo_na_linha, $vetParametros);
}

/*
  $vetParametros = Array(
  'codigo_frm' => 'parteIDENT',
  'controle_fecha' => 'A',
  );
  $vetFrm[] = Frame('<span>IDENTIFICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

  $vetParametros = Array(
  'codigo_pai' => 'parteIDENT',
  );

  $vetCampo['idt_avaliado'] = objFixoBanco('idt_avaliado', 'Avaliado', 'gec_entidade', 'idt', 'descricao', 'idt_avaliado');
  $vetCampo['idt_organizacao_avaliado'] = objFixoBanco('idt_organizacao_avaliado', 'Organização - Avaliada', 'gec_entidade', 'idt', 'descricao', 'idt_organizacao_avaliado');
  $vetCampo['idt_formulario'] = objHidden('idt_formulario', $row['idt_formulario']);

  MesclarCol($vetCampo['idt_formulario'], 3);

  $vetFrm[] = Frame('<span>Avaliado</span>', Array(
  Array($vetCampo['idt_avaliado'], '', $vetCampo['idt_organizacao_avaliado']),
  Array($vetCampo['idt_formulario']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

  $vetCampo['idt_avaliador'] = objFixoBanco('idt_avaliador', 'Avaliador', 'gec_entidade', 'idt', 'descricao', 'idt_avaliador');
  $vetCampo['idt_organizacao_avaliador'] = objFixoBanco('idt_organizacao_avaliador', 'Organização - Avaliadora', 'gec_entidade', 'idt', 'descricao', 'idt_organizacao_avaliador');

  $vetFrm[] = Frame('<span>Avaliador</span>', Array(
  Array($vetCampo['idt_avaliador'], '', $vetCampo['idt_organizacao_avaliador']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

  $vetCampo['detalhe'] = objTextoFixoVL('detalhe', 'Detalhe', $row['detalhe']);

  $vetFrm[] = Frame('<span>Resumo</span>', Array(
  Array($vetCampo['detalhe']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

  $vetCampo['observacao'] = objTextoFixoVL('observacao', 'Observação', $row['detalhe']);

  $vetFrm[] = Frame('<span>Observacao</span>', Array(
  Array($vetCampo['observacao']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
 */

$sql = '';
$sql .= ' select *';
$sql .= ' from grc_formulario_secao';
$sql .= ' where idt_formulario = ' . null($row['idt_formulario']);
$sql .= ' order by codigo';
$rs_s = execsql($sql);
$MatrizDigitacao = Array();
foreach ($rs_s->data as $row_s) {
    $idt_secao = $row_s['idt'];
    $codigo = $row_s['codigo'];
    /*
      $vetParametros = Array(
      'codigo_pai' => 'parte'.$row_s['idt'],
      'width' => '100%',
      );

      $include = 'include_hs'.$row_s['idt'];

      $vetVariavel = Array(
      'row_s' => $row_s,

      );
      $vetCampo[$include] = objInclude($include, 'grc_avaliacao_resposta_int.php', $vetVariavel);

      $vetFrm[] = Frame('', Array(
      Array($vetCampo[$include]),
      ), 'formulario', '', true, $vetParametros);
     */
    if ($sistema_origem == 'GEC') {
        $vetParametros = Array(
            'codigo_frm' => 'parte' . $row_s['idt'],
            'controle_fecha' => "A",
        );
    } else {
        $vetParametros = Array(
            'codigo_frm' => 'parte' . $row_s['idt'],
            'controle_fecha' => $controle_fecha,
        );
    }

    //$vetFrm[] = Frame('<span>'.$row_s['codigo'].' - '.$row_s['descricao'].'</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    $area = mb_strtoupper($row_s['descricao']);

    $area = ($row_s['descricao']);
    if ($codigo == "SE0000000") {
        $vetFrm[] = Frame('<span>' . "" . $area . '</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    } else {
        $vetFrm[] = Frame('<span>' . "Área : " . $area . '</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    }
    $vetParametros = Array(
        'codigo_pai' => 'parte' . $row_s['idt'],
        'width' => '100%',
    );

    $include = 'include_s' . $row_s['idt'];

    $vetVariavel = Array(
        'row_s' => $row_s,
        'vetResp' => $vetResp,
        'MatrizDigitacao' => $MatrizDigitacao,
        'vetRespS' => $vetRespS,
    );

    $vetCampo[$include] = objInclude($include, 'grc_avaliacao_resposta_inc.php', $vetVariavel);


    //p('----------------- '.$include );


    $MatrizDigitacao = $vetVariavel['MatrizDigitacao'];
    $vetFrm[] = Frame('', Array(
        Array($vetCampo[$include]),
            ), 'formulario', '', true, $vetParametros);
}

$vetCampo['situacao'] = objHidden('situacao', '', '', '', false);
$vetCampo['nan'] = objHidden('nan', nan, '', '', false);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['situacao']),
    Array($vetCampo['nan']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;


//p($MatrizDigitacao);
?>
<script type="text/javascript">
    var situacao_submit = '';

    $(document).ready(function () {
        if ($('div.div_btp').length == 1) {
            var bt_t = $('<img id="btp_t" title="Mostrar todas as perguntas" src="imagens/bt_todos.png">');

            //Todas as perguntas
            bt_t.click(function () {
                $('.formulario .pergunta_cont').show();
                $('fieldset.class_frame_p').show();
                $('img.situacao_padrao').click();
            });

            bt_t.css('margin-left', '25px');

            $('div.div_btp').append(bt_t);

            //Perguntas sem resposta
            var bt_sr = $('<img id="btp_sr" title="Mostrar as perguntas sem resposta" src="imagens/bt_desmarcado.png">');

            bt_sr.click(function () {
                $('.formulario .pergunta_cont').each(function () {
                    if ($(this).find('input:checked').length == 0) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                $('img.bt_controle_fecha').each(function () {
                    var img = $(this);
                    var filho = 'fieldset.' + this.id;
                    var tot_perg = $(filho).find('.pergunta_cont').length;
                    var tot_resp = $(filho).find('input:checked').length;
                    var diff = tot_perg - tot_resp;

                    if (diff == 0) {
                        if (img.attr('src') == 'imagens/seta_baixo.png') {
                            img.attr('src', 'imagens/seta_cima.png');
                            $(filho).toggle();
                        }

                        img.parent().parent().hide();
                    } else {
                        if (img.attr('src') == 'imagens/seta_cima.png') {
                            img.attr('src', 'imagens/seta_baixo.png');
                            $(filho).toggle();
                        }

                        img.parent().parent().show();
                    }
                });

                TelaHeight();
            });

            $('div.div_btp').append(bt_sr);

            //Perguntas com resposta
            var bt_cr = $('<img id="btp_cr" title="Mostrar as perguntas com resposta" src="imagens/bt_marcado.png">');

            bt_cr.click(function () {
                $('.formulario .pergunta_cont').each(function () {
                    if ($(this).find('input:checked').length > 0) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                $('img.bt_controle_fecha').each(function () {
                    var img = $(this);
                    var filho = 'fieldset.' + this.id;
                    var tot_resp = $(filho).find('input:checked').length;

                    if (tot_resp == 0) {
                        if (img.attr('src') == 'imagens/seta_baixo.png') {
                            img.attr('src', 'imagens/seta_cima.png');
                            $(filho).toggle();
                        }

                        img.parent().parent().hide();
                    } else {
                        if (img.attr('src') == 'imagens/seta_cima.png') {
                            img.attr('src', 'imagens/seta_baixo.png');
                            $(filho).toggle();
                        }

                        img.parent().parent().show();
                    }
                });

                TelaHeight();
            });

            $('div.div_btp').append(bt_cr);
        }

        $("input:radio").click(function () {
            // $(this).parent().parent().parent().find('textarea').hide();
            // $(this).parent().parent().find('textarea').show().focus();
            $(this).parent().parent().parent().find('div').hide();
            $(this).parent().parent().find('div').show().focus();
        });

        //$('input:checked').parent().parent().find('textarea').show();
        $('input:checked').parent().parent().find('div').show();

        onSubmitCancelado = function () {
            valida_cust = '';
            onSubmitMsgTxt = '';
            situacao_submit = '';
        };
    });

    function grc_avaliacao_resposta_con() {
        if (situacao_submit != '') {
            $('#situacao').val(situacao_submit);
        }

        return true;
    }

    function grc_avaliacao_resposta_dep() {
        if (situacao_submit == 'Volta' || acao == 'con') {
            return true;
        }

        var tot_perg = $('.formulario .pergunta_cont').length;
        var tot_resp = $('.formulario .pergunta_cont input:checked').length;

        if ($('.formulario .pergunta_cont input').length == 0) {
            alert('Formulário não esta finalizado para avaliação!');
            return false;
        }

        if (tot_perg != tot_resp) {
            alert('Favor responder a todas as perguntas!');
            $('#btp_sr').click();
            return false;
        }

        var txt = '';

        $('.formulario textarea:visible').each(function () {
            if ($(this).val().length == 0) {
                txt = $(this);
                return false;
            }
        });

        $('#btp_t').click();

        if (txt != '') {
            alert('Favor informar o complemento da resposta!');
            txt.focus();
            return false;
        }

        return true;
    }

    function btAcaoVoltar() {
        situacao_submit = 'Volta';
        $(':submit:first').click();
    }
</script>
