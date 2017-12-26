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
        xheight    : 20px;
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

</style>



<?php

//p($_REQUEST);
$sql = "select *";
$sql .= ' from grc_projeto_acao';
$sql .= " where idt  = ".null($_GET['id']);
$rs = execsql($sql);
$rowp = $rs->data[0];
$_GET['idCad'] = $rowp['idt_projeto'];
if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);



$corbloq = "#FFFF80";

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;


$TabelaPai   = "grc_projeto";
$AliasPai    = "grc_ppr";
$EntidadePai = "Projeto";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_projeto_acao";
$AliasPric        = "grc_proaca";
$Entidade         = "Ação do Projeto";
$Entidade_p       = "Ações do Projeto";
$CampoPricPai     = "idt_projeto";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$corbloq = "#FFFF80";
$jst     = " readonly='true' style='background:{$corbloq};' ";
$js      = " disabled  style='background:{$corbloq}; width:380px;' ";

$vetCampo['codigo']       = objTexto('codigo', 'Código', True, 60, 120,$jst);
$vetCampo['codigo_sge']   = objTexto('codigo_sge', 'Códido Ação do SGE', false, 60, 120,$jst);
$vetCampo['id_origem']    = objTexto('id_origem', 'ID Origem', false, 15, 45,$jst);
$vetCampo['descricao']    = objTexto('descricao', 'Título da Açãoxxx', True, 60, 120,$jst);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,' ',$js);
//
$maxlength  = 700;
$style      = "width:700px;";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $jst);

$vetCampo['data_criacao']   = objDatahora('data_criacao', 'Data da Criaçãor (dd/mm/aaaa hh:mm)', False);
$vetCampo['data_modificacao']   = objDatahora('data_modificacao', 'Data da Modificação (dd/mm/aaaa hh:mm)', False);




/*
$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_usuario_criador'] = objCmbBanco('idt_usuario_criador', 'Criado por', true, $sql,' ','width:500px;');

$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_usuario_modificador'] = objCmbBanco('idt_usuario_modificador', 'Modificado por', false, $sql,' ','width:500px;');
*/

$vetCampo['data_inicio']   = objDatahora('data_inicio', 'Data de Inicio (dd/mm/aaaa hh:mm)', False);
$vetCampo['data_termino']   = objDatahora('data_termino', 'Data de Termino (dd/mm/aaaa hh:mm)', False);

$sql = "select idt, codigo, descricao from grc_projeto_acao_n order by descricao";
$vetCampo['idt_projeto_acao_n'] = objCmbBanco('idt_projeto_acao_n', 'Ação', true, $sql,'','width:180px;');


$vetCampo['existe_siacweb']    = objCmbVetor('existe_siacweb', 'Existe Siacweb?', True, $vetNaoSim);
$vetCampo['ativo_siacweb']     = objCmbVetor('ativo_siacweb', 'Ativo Siacweb?', True, $vetNaoSim);


$vetCampo['codigo_siacweb']     = objInteiro('codigo_siacweb', 'Código Siacweb', false);

// responsável pela acao projeto

$vetCampo['cpf_responsavel']     = objCPF('cpf_responsavel', 'CPF do Responsável', false);
$vetCampo['codparceiro_siacweb'] = objHidden('codparceiro_siacweb', '', 'Código SiacWeb', true);


$js  = " disabled style='background:{$corbloq};' ";
$vetCampo['nan']       = objCmbVetor('nan', 'Atende ao NAN?', True, $vetNaoSim,'',$js);
$vetCampo['ativo_nan'] = objCmbVetor('ativo_nan', 'Ativo NAN?', True, $vetNaoSim,'',$js);

$vetCampo['adicional']     = objCmbVetor('adicional', 'Visitas Adicionais?', false, $vetSimNao);
$vetCampo['data_validade'] = objData('data_validade', 'Validade', False,'','','S');
$vetCampo['numero_max_visita'] = objInteiro('numero_max_visita', 'Número máximo<br /> de Visitas<br />por Dia', False);
$vetCampo['numero_adicinal_visita'] = objInteiro('numero_adicinal_visita', 'Número adicional<br />de Visitas<br />por Dia', False);
$vetCampo['prazo_max_1_2'] = objInteiro('prazo_max_1_2', 'Prazo Máximo<br /> entre Visitas 1 e 2<br />(dias corridos)', False);
$vetCampo['prazo_max_2_3'] = objInteiro('prazo_max_2_3', 'Prazo Máximo<br /> entre Visitas 2 e 3<br />(dias corridos)', False);
$vetCampo['prazo_tutor']   = objInteiro('prazo_tutor', 'Prazo Máximo<br /> de Apuração do Tutor<br />(dias corridos)', False);

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from '.db_pir.'sca_organizacao_secao';   
$sql .= " where tipo_estrutura = 'UR'";
$sql .= ' order by classificacao ';
$js  = " disabled style='width:400px; background:{$corbloq};' ";
$vetCampo['nan_idt_unidade_regional'] = objCmbBanco('nan_idt_unidade_regional', 'Unidade Regional', true, $sql, '', '', $js);


$sql_lst_1 = 'select idt as idt_publico_alvo, descricao from grc_publico_alvo  order by codigo';

$sql_lst_2 = 'select ds.idt as idt_publico_alvo,  ds.descricao from grc_publico_alvo ds inner join
			   grc_projeto_acao_nan_publico_alvo dr on ds.idt = dr.idt_publico_alvo
			   where dr.idt = '.null($_GET['id']).' order by ds.codigo';

$vetCampo['idt_publico_alvo'] = objLista('idt_publico_alvo', true, 'Público Alvo', 'idt_publico_alvo1', $sql_lst_1, 'grc_projeto_acao_nan_publico_alvo', 250, 'Publico Alvo Selecionados', 'idt_publico_alvo2', $sql_lst_2);



$titulo_cadastro="AÇÃO";

// Definição do layout da Tela
$vetFrm = Array();

//$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

// Definição de um frame ou seja de um quadro da tela para agrupar campos

$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>AÇÃO DO NAN</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'parte01',
	'width' => '80%',
);

/*
$vetFrm[] = Frame('<span>Projeto</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);
*/
MesclarCol($vetCampo[$CampoPricPai], 5);
MesclarCol($vetCampo['detalhe'], 5);
MesclarCol($vetCampo['ativo'], 5);
//MesclarCol($vetCampo['nan_idt_unidade_regional'], 5);
MesclarCol($vetCampo['adicional'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['descricao'],'',$vetCampo['ativo']),
    Array($vetCampo['detalhe']),
	Array($vetCampo['nan_idt_unidade_regional'],'',$vetCampo['nan'],'',$vetCampo['ativo_nan']),
	
    Array($vetCampo['adicional']),
	Array($vetCampo['numero_max_visita'],'',$vetCampo['numero_adicinal_visita'],'',$vetCampo['data_validade']),
	Array($vetCampo['prazo_max_1_2'],'',$vetCampo['prazo_max_2_3'],'',$vetCampo['prazo_tutor']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


$vetFrm[] = Frame('<span>Restrição de Atendimento por Público Alvo:</span>', Array(
	Array($vetCampo['idt_publico_alvo']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


/*
$vetFrm[] = Frame('', Array(
    Array($vetCampo['cpf_responsavel'], '', $vetCampo['codparceiro_siacweb']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
$vetFrm[] = Frame('<span>SiacWeb</span>', Array(
    Array($vetCampo['existe_siacweb'],'',$vetCampo['ativo_siacweb'],'',$vetCampo['codigo_siacweb']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);
*/



/*
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['idt_projeto_acao_n'],'',$vetCampo['codigo_sge'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Coplemento da Ação</span>', Array(
    Array($vetCampo['descricao']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/

/*
$vetFrm[] = Frame('<span>Criador/Modificador</span>', Array(
    Array($vetCampo['idt_usuario_criador'],'',$vetCampo['data_criacao']),
    Array($vetCampo['idt_usuario_modificador'],'',$vetCampo['data_modificacao']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Origem e Período</span>', Array(
    Array($vetCampo['id_origem'],'',$vetCampo['data_inicio'],'',$vetCampo['data_termino']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/

// INÍCIO

// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE PRODUTO
// AÇÕES DE PROJETOS
//____________________________________________________________________________

// Definição do frame PRODUTO ASSOCIADO
// NOME DO FRAME = produto_associado
// controle_fecha = A(o full entra aberto) F(O full entra fechado)

$vetParametros = Array(
    'codigo_frm' => 'grc_projeto_acao_metaw',
    'controle_fecha' => 'F',
	'barra_inc_ap' => false,
	'barra_alt_ap' => false,
	'barra_con_ap' => true,
	'barra_exc_ap' => false,
);
$vetFrm[] = Frame('<span>METAS DA AÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

$vetCampo = Array();
//Monta o vetor de Campo


$vetCampo['ano']              = CriaVetTabela('Ano', 'descDominio', $vetAno );
$vetCampo['mes']              = CriaVetTabela('Mês', 'descDominio', $vetMes );
$vetCampo['grc_ai_descricao'] = CriaVetTabela('Instrumento');
$vetCampo['quantitativo']     = CriaVetTabela('Quantitativo');
$vetCampo['grc_am_descricao'] = CriaVetTabela('Métrica');






// Parametros da tela full conforme padrão

$titulo = 'Metas das Ações do Projeto';

$TabelaPrinc      = "grc_projeto_acao_meta";
$AliasPric        = "grc_pam";
$Entidade         = "Meta da Ação de Projetos";
$Entidade_p       = "Metas das Ações de Projetos";

$CampoPricPai     = "idt_projeto_acao";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.ano, {$AliasPric}.mes";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "       grc_ai.descricao as grc_ai_descricao, ";
$sql  .= "       grc_am.descricao as grc_am_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_atendimento_metrica grc_am on grc_am.idt = {$AliasPric}.idt_metrica ";
$sql .= " inner join grc_atendimento_instrumento grc_ai on grc_ai.idt = {$AliasPric}.idt_instrumento ";

$sql .= " where {$AliasPric}".'.idt_projeto_acao = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full

$vetCampo['grc_projeto_acao_meta'] = objListarConf('grc_projeto_acao_meta', 'idt', $vetCampo, $sql, $titulo, false,$vetParametros);

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'grc_projeto_acao_metaw',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_projeto_acao_meta']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// fim


$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#cpf_responsavel').change(function () {
            if ($(this).val() != '') {
                processando();

                $('#codparceiro_siacweb').val('');
                $('#codparceiro_siacweb_fix').text('');

                $.ajax({
                    type: 'POST',
                    url: ajax_sistema + '?tipo=cpf_codparceiro_siacweb',
                    data: {
                        cas: conteudo_abrir_sistema,
                        cpf: $(this).val()
                    },
                    success: function (response) {
                        var cod = parseInt(response);

                        if (isNaN(cod)) {
                            $("#dialog-processando").remove();
                            alert(response);
                        } else {
                            $('#codparceiro_siacweb').val(cod);
                            $('#codparceiro_siacweb_fix').text(cod);
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
        });
    });
</script>	