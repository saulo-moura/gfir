<style>
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
        text-align: left;
        font-size : 16px;
        padding:10px;
    }

    div.class_titulo_p span {
        padding:10px;
        font-size:18px;
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
        color     : #000000;
        border    : 0px solid #2C3E50;
        margin-top: 20px;
        text-align:center;		
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


    /*
        Select {
            border:0px;
            height:28px;
        }
    */
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
    td {
        padding-top:0px;
    }
    #idt_organizacao_txt {
        width:70%;
    }	

</style>
<?php
$tabela = db_pir_gec.'gec_contratar_credenciado';
$id = 'idt';

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";

$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$sql = '';
$sql .= ' select idt_organizacao';
$sql .= ' from '.db_pir_gec.'gec_contratar_credenciado';
$sql .= ' where idt = '.null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

$vetFrm = Array();

$vetParametros = Array(
    'situacao_padrao' => true,
);
$vetFrm[] = Frame("<span>CONTRATAR CREDENCIADO</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>IDENTIFICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from '.db_pir.'sca_organizacao_secao';
$sql .= " where tipo_estrutura = 'UR'";
$sql .= ' order by classificacao ';
$vetCampo['nan_idt_unidade_regional'] = objCmbBanco('nan_idt_unidade_regional', 'Unidade Regional', true, $sql, ' ', 'width:550px;');

$width = '550px';
$vetCampo['idt_organizacao'] = objListarCmb('idt_organizacao', 'grc_entidade_nan_organizacao', 'Empresa Executora', true, $width);


$vetCampo['codigo'] = objTexto('codigo', 'Número<br />Contrato', true, 12, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Objeto', true, 40, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');

$sql = '';
$sql .= " select ef.idt, ef.codigo, ef.descricao, group_concat(distinct er.descricao separator ', ') as tipo";
$sql .= ' from '.db_pir_gec.'gec_entidade_entidade ee';
$sql .= ' inner join '.db_pir_gec.'gec_entidade ef on ef.idt = ee.idt_entidade_relacionada';
$sql .= ' inner join '.db_pir_gec.'gec_entidade_relacao er on er.idt = ee.idt_entidade_relacao';
$sql .= ' where ee.idt_entidade = '.null($row['idt_organizacao']);
$sql .= " and ee.ativo = 'S'";
$sql .= ' and ee.idt_entidade_relacao = 8';
$sql .= " and ef.tipo_entidade = 'P'";
$sql .= " and ef.reg_situacao = 'A'";
$sql .= " and ef.ativo = 'S'";
$sql .= " and (";

//Credenciado
$sql .= ' (';
$sql .= " ef.credenciado_nan = 'S'";
$sql .= " and ef.credenciado = 'S'";
$sql .= " and ef.nan_ano = ".aspa(nan_ano);
$sql .= ' )';

//Não Credenciado
$sql .= " or ef.credenciado = 'N'";

$sql .= " )";

$sql .= ' group by ef.idt, ef.codigo, ef.descricao';
$sql .= ' order by ef.descricao';
$vetCampo['idt_contratado'] = objCmbBanco('idt_contratado', 'Representante', false, $sql);

$vetCampo['nan_data_contrato'] = objData('nan_data_contrato', 'Data do Contrato', True, '', '', 'S');



$corbloq = "#FFFF80";
$jst = " readonly='true' style='background:".$corbloq."' ";
$vetCampo['nan_meta_atendimentos'] = objInteiro('nan_meta_atendimentos', 'Meta Atendimentos (Quantidade)', false, 20, '', '', $jst);
$vetCampo['nan_meta_atendimentos_aditivo'] = objInteiro('nan_meta_atendimentos_aditivo', 'Aditivo Meta Atendimentos (Quantidade)', false, 20, '', '', $jst);



$vetCampo['nan_meta_atendimentos_v1'] = objInteiro('nan_meta_atendimentos_v1', 'Meta Atendimentos V1 (Quantidade)', true, 20);
$vetCampo['nan_meta_atendimentos_aditivo_v1'] = objInteiro('nan_meta_atendimentos_aditivo_v1', 'Aditivo  V1 Meta Atendimentos (Quantidade)', false, 20);

$vetCampo['nan_meta_atendimentos_v2'] = objInteiro('nan_meta_atendimentos_v2', 'Meta Atendimentos V2 (Quantidade)', true, 20);
$vetCampo['nan_meta_atendimentos_aditivo_v2'] = objInteiro('nan_meta_atendimentos_aditivo_v2', 'Aditivo V2 Meta Atendimentos (Quantidade)', false, 20);

$corbloq = "#FFFF80";
$jst = " readonly='true' style='background:{$corbloq}; ' ";
$vetCampo['valor_contrato'] = objDecimal('valor_contrato', 'Valor das Visitas Contratadas', false, 15, 15, 2, $jst, 0);

$vetCampo['valor_contratual'] = objDecimal('valor_contratual', 'Valor do Contrato', false);


$vetCampo['nan_contrato_ano'] = objHidden('nan_contrato_ano', '', '', '', true);
$vetCampo['nan_contrato_mes'] = objHidden('nan_contrato_mes', '', '', '', true);
$vetCampo['nan_contrato_dia'] = objHidden('nan_contrato_dia', '', '', '', true);
$vetCampo['nan_indicador'] = objHidden('nan_indicador', 'S');


MesclarCol($vetCampo['nan_idt_unidade_regional'], 5);
MesclarCol($vetCampo['idt_organizacao'], 5);
MesclarCol($vetCampo['idt_contratado'], 5);

$vetParametros = Array(
    'codigo_pai' => 'parte01',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['ativo']),
    Array($vetCampo['nan_idt_unidade_regional']),
    Array($vetCampo['idt_organizacao']),
    Array($vetCampo['idt_contratado']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['nan_data_contrato'], '', $vetCampo['nan_meta_atendimentos_v1'], '', $vetCampo['nan_meta_atendimentos_aditivo_v1']),
    Array($vetCampo['nan_indicador'], '', $vetCampo['nan_meta_atendimentos_v2'], '', $vetCampo['nan_meta_atendimentos_aditivo_v2']),
    Array('', '', $vetCampo['nan_meta_atendimentos'], '', $vetCampo['nan_meta_atendimentos_aditivo']),
    Array('', '', $vetCampo['valor_contratual'], '', $vetCampo['valor_contrato']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['nan_contrato_dia'], '', $vetCampo['nan_contrato_mes'], '', $vetCampo['nan_contrato_ano']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'parte02',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span> ANEXOS DO CONTRATO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampoLC = Array();
$vetCampoLC['titulo'] = CriaVetTabela('Título');
$vetCampoLC['arquivo'] = CriaVetTabela('Arquivo', 'func_trata_dado', fnc_grc_nan_gestao_contrato);

$titulo = 'Anexos do Contrato';

$sql = '';
$sql .= ' select *';
$sql .= ' from '.db_pir_gec.'gec_contratar_credenciado_anexo';
$sql .= ' where idt_contratar_credenciado = $vlID';
$sql .= ' order by titulo';


$vetParametros = Array(
    //'codigo_frm' => 'botao_concluir_atendimento_w',
    'controle_fecha' => 'A',
    'barra_inc_ap' => true,
    'barra_alt_ap' => true,
    'barra_con_ap' => true,
    'barra_exc_ap' => true,
);


$vetCampo['gec_contratar_credenciado_anexo'] = objListarConf('gec_contratar_credenciado_anexo', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'parte02',
    'width' => '100%',
);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['gec_contratar_credenciado_anexo']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);



///////////////////////



$vetParametros = Array(
    'codigo_frm' => 'parte03',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>AGENTES</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampoLC = Array();
$vetCampoLC['plu_usuario'] = CriaVetTabela('Agente');
//$vetCampoLC['gec_e_executora']  = CriaVetTabela('Empresa Executora');
$vetCampoLC['plu_usut_usuario'] = CriaVetTabela('Tutor');
$vetCampoLC['grc_p_descricao'] = CriaVetTabela('Projeto');
$vetCampoLC['grc_pa_descricao'] = CriaVetTabela('Ação');
//$vetCampoLC['sca_nan_ur']       = CriaVetTabela('Unidade Regional');
$vetCampoLC['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);


$titulo = 'AOEs';

$TabelaPrinc = "grc_nan_estrutura";
$AliasPric = "grc_ne";
$Entidade = "AOE do NAN";
$Entidade_p = "AOEs do NAN";

$sql = "select ";
$sql .= "   {$AliasPric}.*, ";
$sql .= '   gec_e.descricao as gec_e_executora, ';
$sql .= '   sca_nan.descricao as sca_nan_ur, ';
$sql .= "   grc_p.descricao as grc_p_descricao,  ";
$sql .= "   grc_pa.descricao as grc_pa_descricao,  ";
$sql .= "   grc_nte.descricao as grc_nte_descricao,  ";
$sql .= "   plu_usu.nome_completo as plu_usuario,  ";
$sql .= "   plu_usut.nome_completo as plu_usut_usuario  ";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " inner join grc_nan_estrutura_tipo grc_nte on grc_nte.idt = {$AliasPric}.idt_nan_tipo ";
$sql .= " left  outer join grc_projeto_acao grc_pa on grc_pa.idt = {$AliasPric}.idt_acao ";
$sql .= " left  outer join grc_projeto grc_p on grc_p.idt = grc_pa.idt_projeto ";
$sql .= " left outer join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_usuario ";
$sql .= " left outer join ".db_pir_gec."gec_contratar_credenciado gec_cc on gec_cc.idt = {$AliasPric}.idt_contrato ";
$sql .= " left outer join ".db_pir_gec."gec_entidade gec_e on gec_e.idt = gec_cc.idt_organizacao";
$sql .= " left outer join ".db_pir."sca_organizacao_secao sca_nan on sca_nan.idt = gec_cc.nan_idt_unidade_regional";
$sql .= " left outer join grc_nan_estrutura est_t on est_t.idt =  {$AliasPric}.idt_tutor ";
$sql .= " left outer join plu_usuario plu_usut on plu_usut.id_usuario = est_t.idt_usuario ";
$sql .= " where {$AliasPric}".'.idt_contrato = $vlID';

$sql .= ' order by gec_e.descricao';


$vetCampo['grc_nan_estrutura'] = objListarConf('grc_nan_estrutura', 'idt', $vetCampoLC, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'parte03',
    'width' => '100%',
);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_nan_estrutura']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);






$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#idt_contratado").cascade("#idt_organizacao", {
            ajax: {
                url: ajax_sistema + '?tipo=nan_pf_pj_rep&cas=' + conteudo_abrir_sistema
            }
        });

        grc_nan_estrutura_fecha();
    });

    function fncListarCmbMuda_idt_organizacao() {
        $('#idt_organizacao').change();
    }

    function grc_nan_estrutura_fecha() {
        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=grc_nan_estrutura_fecha',
            data: {
                cas: conteudo_abrir_sistema,
                id: '<?php echo $_GET['id']; ?>'
            },
            success: function (response) {
                if (response.erro == '') {
                    var idt_organizacao = $('#idt_organizacao').parent().find('.bt_acao');

                    if (response.tot == 0) {
                        idt_organizacao.show();
                        $('#nan_idt_unidade_regional').removeProp("disabled").removeClass("campo_disabled");
                    } else {
                        idt_organizacao.hide();
                        $('#nan_idt_unidade_regional').prop("disabled", true).addClass("campo_disabled");
                    }
                } else {
                    $("#dialog-processando").remove();
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#dialog-processando").remove();
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        $("#dialog-processando").remove();
    }
</script>