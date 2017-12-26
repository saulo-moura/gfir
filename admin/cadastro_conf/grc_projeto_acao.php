<style>
    #nm_funcao_desc label{
    }
    #nm_funcao_obj {
    }
    .Tit_Campo {
    }
    .Tit_Campo_Obr {
    }
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
        height:30px;
    }
    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        height:30px;
        padding-top:10px;
    }
    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame_p {
        background:#ABBBBF;
        border:1px solid #FFFFFF;
    }
    div.class_titulo_p {
        background: #ABBBBF;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }



    fieldset.class_frame {
        background:#ECF0F1;
        border:1px solid #2C3E50;
    }
    div.class_titulo {
        background: #C4C9CD;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    div.class_titulo span {
        padding-left:10px;
    }
</style>



<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);


$nan = $_GET['nan'];



$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;


$TabelaPai = "grc_projeto";
$AliasPai = "grc_ppr";
$EntidadePai = "Projeto";
$idPai = "idt";

//
$TabelaPrinc = "grc_projeto_acao";
$AliasPric = "grc_proaca";
$Entidade = "Ação do Projeto";
$Entidade_p = "Ações do Projeto";
$CampoPricPai = "idt_projeto";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$corbloq = "#FFFF80";
$jst = "";
$js = "";
if ($nan == 'S') {
    $jst = " readonly='true' style='background:{$corbloq};' ";
    $js = " disabled  style='background:{$corbloq};' ";
}



$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 60, 120, $jst);
$vetCampo['codigo_sge'] = objTexto('codigo_sge', 'Códido Ação do SGE', false, 60, 120, $jst);
$vetCampo['id_origem'] = objTexto('id_origem', 'ID Origem', false, 15, 45, $jst);
$vetCampo['descricao'] = objTexto('descricao', 'Título da Ação', True, 60, 120, $jst);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '', $js);
//
$maxlength = 700;
$style = "width:700px;";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $jst);

$vetCampo['data_criacao'] = objDatahora('data_criacao', 'Data da Criaçãor (dd/mm/aaaa hh:mm)', False);
$vetCampo['data_modificacao'] = objDatahora('data_modificacao', 'Data da Modificação (dd/mm/aaaa hh:mm)', False);


/*
  $sql  = "select id_usuario, nome_completo from plu_usuario ";
  $sql .= " order by nome_completo";
  $vetCampo['idt_usuario_criador'] = objCmbBanco('idt_usuario_criador', 'Criado por', true, $sql,' ','width:500px;');

  $sql  = "select id_usuario, nome_completo from plu_usuario ";
  $sql .= " order by nome_completo";
  $vetCampo['idt_usuario_modificador'] = objCmbBanco('idt_usuario_modificador', 'Modificado por', false, $sql,' ','width:500px;');
 */

$vetCampo['data_inicio'] = objDatahora('data_inicio', 'Data de Inicio (dd/mm/aaaa hh:mm)', False);
$vetCampo['data_termino'] = objDatahora('data_termino', 'Data de Termino (dd/mm/aaaa hh:mm)', False);

$sql = "select idt, codigo, descricao from grc_projeto_acao_n order by descricao";
$vetCampo['idt_projeto_acao_n'] = objCmbBanco('idt_projeto_acao_n', 'Ação', true, $sql, '', 'width:180px;');


$vetCampo['existe_siacweb'] = objCmbVetor('existe_siacweb', 'Existe Siacweb?', True, $vetNaoSim);
$vetCampo['ativo_siacweb'] = objCmbVetor('ativo_siacweb', 'Ativo Siacweb?', True, $vetNaoSim);


$vetCampo['codigo_siacweb'] = objInteiro('codigo_siacweb', 'Código Siacweb', false);

// responsável pela acao projeto

$vetCampo['cpf_responsavel'] = objCPF('cpf_responsavel', 'CPF do Responsável', false);
$vetCampo['codparceiro_siacweb'] = objHidden('codparceiro_siacweb', '', 'Código SiacWeb', true);


$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from '.db_pir.'sca_organizacao_secao';
$sql .= " where tipo_estrutura = 'UR'";
$sql .= ' order by classificacao ';
$vetCampo['nan_idt_unidade_regional'] = objCmbBanco('nan_idt_unidade_regional', 'Unidade Regional', true, $sql, ' ', 'width:400px;');

$vetCampo['nan'] = objCmbVetor('nan', 'Atende ao NAN?', True, $vetNaoSim);
$vetCampo['ativo_nan'] = objCmbVetor('ativo_nan', 'Ativo NAN?', True, $vetNaoSim);

$vetCampo['adicional'] = objCmbVetor('adicional', 'Visitas Adicionais?', false, $vetSimNao);
$vetCampo['data_validade'] = objData('data_validade', 'Validade', False, '', '', 'S');
$vetCampo['numero_max_visita'] = objInteiro('numero_max_visita', 'Número máximo de Visitas por Dia', False);
$vetCampo['numero_adicinal_visita'] = objInteiro('numero_adicinal_visita', 'Número adicional de Visitas por Dia', False);
$vetCampo['prazo_max_1_2'] = objInteiro('prazo_max_1_2', 'Prazo Máximo entre Visitas 1 e 2', False);
$vetCampo['prazo_max_2_3'] = objInteiro('prazo_max_2_3', 'Prazo Máximo entre Visitas 2 e 3', False);
$vetCampo['prazo_tutor'] = objInteiro('prazo_tutor', 'Prazo Máximo de Apuração do Tutor em Dias corridos', False);


if ($nan == 'S') {
    $titulo_cadastro = "AÇÃO DO NAN";
} else {
    $titulo_cadastro = "AÇÃO";
}
// Definição do layout da Tela
$vetFrm = Array();

$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

// Definição de um frame ou seja de um quadro da tela para agrupar campos

$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>01 - SGE - AÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'parte01',
);

/*
  $vetFrm[] = Frame('<span>Projeto</span>', Array(
  Array($vetCampo[$CampoPricPai]),
  ),$class_frame,$class_titulo,$titulo_na_linha);
 */
$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['descricao']),
    Array($vetCampo['detalhe']),
    // Array($vetCampo['codigo_sge']),
    Array($vetCampo['ativo']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

if ($nan == 'S') {
    MesclarCol($vetCampo['nan_idt_unidade_regional'], 5);
    $vetFrm[] = Frame('<span>Negócio a Negócio</span>', Array(
        Array($vetCampo['nan_idt_unidade_regional']),
        Array($vetCampo['nan'], '', $vetCampo['ativo_nan'], '', $vetCampo['adicinal']),
        Array($vetCampo['numero_max_visita'], '', $vetCampo['numero_adicinal_visita'], '', $vetCampo['data_validade']),
        Array($vetCampo['prazo_max_1_2'], '', $vetCampo['prazo_max_2_3'], '', $vetCampo['prazo_tutor']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
} else {
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['cpf_responsavel'], '', $vetCampo['codparceiro_siacweb']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
    $vetFrm[] = Frame('<span>SiacWeb</span>', Array(
        Array($vetCampo['existe_siacweb'], '', $vetCampo['ativo_siacweb'], '', $vetCampo['codigo_siacweb']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}


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
////////////////// estrutura NAN
if ($nan == 'S') {

    $vetParametros = Array(
        'codigo_frm' => 'grc_nan_estruturaw',
        'controle_fecha' => 'A',
    );
    $vetFrm[] = Frame('<span>ESTRUTURA NAN</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    // Definição de campos formato full que serão editados na tela full

    $vetCampo = Array();
    //Monta o vetor de Campo


    $vetCampo['grc_nte_descricao'] = CriaVetTabela('Tipo');
    $vetCampo['plu_usuario'] = CriaVetTabela('Gestor/Tutor');
    $vetCampo['plu_usut_usuario'] = CriaVetTabela('Gestor');
    $vetCampo['vl_aprova_ordem'] = CriaVetTabela('Valor da Alçada', 'decimal');
    $vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

    // Parametros da tela full conforme padrão

    $titulo = 'Estrutura Operacional do NAN';

    $TabelaPrinc = "grc_nan_estrutura";
    $AliasPric = "grc_ne";
    $Entidade = "Ator do NAN";
    $Entidade_p = "Atores do NAN";

    $CampoPricPai = "idt_acao";

    // Select para obter campos da tabela que serão utilizados no full

    $orderby = ' grc_nte.ordem ';

    $sql = "select ";
    $sql .= "   {$AliasPric}.*, ";
    $sql .= "   grc_nte.descricao as grc_nte_descricao,  ";
    $sql .= "   plu_usu.nome_completo as plu_usuario,  ";
    $sql .= "   plu_usut.nome_completo as plu_usut_usuario  ";
    $sql .= " from {$TabelaPrinc} as {$AliasPric} ";
    $sql .= " inner join grc_nan_estrutura_tipo grc_nte on grc_nte.idt = {$AliasPric}.idt_nan_tipo ";
    $sql .= " left  join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_usuario ";
    $sql .= " left  join grc_nan_estrutura est_u on est_u.idt =  {$AliasPric}.idt_tutor ";
    $sql .= " left  join plu_usuario plu_usut on plu_usut.id_usuario =  est_u.idt_usuario ";
    $sql .= " where {$AliasPric}".'.idt_acao = $vlID';
    $sql .= " and   grc_nte.idt in (5, 3, 10)";
    $sql .= " order by {$orderby}";

    // Carrega campos que serão editados na tela full

    $vetCampo['grc_nan_estrutura_arvore'] = objListarConf('grc_nan_estrutura_arvore', 'idt', $vetCampo, $sql, $titulo, false);

    // Fotmata lay_out de saida da tela full

    $vetParametros = Array(
        'codigo_pai' => 'grc_nan_estruturaw',
        'width' => '100%',
    );

    $vetFrm[] = Frame('<span></span>', Array(
        Array($vetCampo['grc_nan_estrutura_arvore']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
} else {



    $vetParametros = Array(
        'codigo_frm' => 'grc_projeto_acao_metaw',
        'controle_fecha' => 'A',
    );
    $vetFrm[] = Frame('<span>02 - METAS DAS AÇÔES</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

    $vetCampo = Array();
//Monta o vetor de Campo


    $vetCampo['ano'] = CriaVetTabela('Ano', 'descDominio', $vetAno);
    $vetCampo['mes'] = CriaVetTabela('Mês', 'descDominio', $vetMes);
    $vetCampo['grc_ai_descricao'] = CriaVetTabela('Instrumento');
    $vetCampo['quantitativo'] = CriaVetTabela('Quantitativo');
    $vetCampo['grc_am_descricao'] = CriaVetTabela('Métrica');

// Parametros da tela full conforme padrão

    $titulo = 'Metas das Ações do Projeto';

    $TabelaPrinc = "grc_projeto_acao_meta";
    $AliasPric = "grc_pam";
    $Entidade = "Meta da Ação de Projetos";
    $Entidade_p = "Metas das Ações de Projetos";

    $CampoPricPai = "idt_projeto_acao";

// Select para obter campos da tabela que serão utilizados no full

    $orderby = "{$AliasPric}.ano, {$AliasPric}.mes";

    $sql = "select {$AliasPric}.*, ";
    $sql .= "       grc_ai.descricao as grc_ai_descricao, ";
    $sql .= "       grc_am.descricao as grc_am_descricao ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join grc_atendimento_metrica grc_am on grc_am.idt = {$AliasPric}.idt_metrica ";
    $sql .= " inner join grc_atendimento_instrumento grc_ai on grc_ai.idt = {$AliasPric}.idt_instrumento ";

    $sql .= " where {$AliasPric}".'.idt_projeto_acao = $vlID';
    $sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full

    $vetCampo['grc_projeto_acao_meta'] = objListarConf('grc_projeto_acao_meta', 'idt', $vetCampo, $sql, $titulo, false);

// Fotmata lay_out de saida da tela full

    $vetParametros = Array(
        'codigo_pai' => 'grc_projeto_acao_metaw',
        'width' => '100%',
    );

    $vetFrm[] = Frame('<span></span>', Array(
        Array($vetCampo['grc_projeto_acao_meta']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);



//////////////// SGTEC


    $vetParametros = Array(
        'codigo_frm' => 'grc_projeto_acao_produtow',
        'controle_fecha' => 'A',
    );
    $vetFrm[] = Frame('<span>03 - SGTEC - Produtos Associados</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

    $vetCampo = Array();
//Monta o vetor de Campo

    $vetCampo['grc_p_descricao'] = CriaVetTabela('Produto');
    $vetCampo['observacao'] = CriaVetTabela('Observação');
    $vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNão);

// Parametros da tela full conforme padrão

    $titulo = 'Produtos associados as Ações do Projeto';

    $TabelaPrinc = "grc_projeto_acao_produto";
    $AliasPric = "grc_pap";
    $Entidade = "Produto da Ação de Projetos";
    $Entidade_p = "produtos das Ações de Projetos";

    $CampoPricPai = "idt_projeto_acao";

    $orderby = "grc_p.descricao";

    $sql = "select {$AliasPric}.*, ";
    $sql .= "       grc_p.descricao as grc_p_descricao ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join grc_produto grc_p on grc_p.idt = {$AliasPric}.idt_produto ";
    $sql .= " where {$AliasPric}".'.idt_projeto_acao = $vlID';
    $sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full

    $vetCampo['grc_projeto_acao_produto'] = objListarConf('grc_projeto_acao_produto', 'idt', $vetCampo, $sql, $titulo, false);

// Fotmata lay_out de saida da tela full

    $vetParametros = Array(
        'codigo_pai' => 'grc_projeto_acao_produtow',
        'width' => '100%',
    );

    $vetFrm[] = Frame('<span></span>', Array(
        Array($vetCampo['grc_projeto_acao_produto']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}



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

        grc_nan_estrutura_arvore_fecha();
    });

    function parListarConf_grc_nan_estrutura_arvore() {
        var par = '';

        if ($('#nan_idt_unidade_regional').val() == '') {
            alert('Favor informar a Unidade Regional!');
            $('#nan_idt_unidade_regional').focus();
            return false;
        }

        par += '&nan_idt_unidade_regional=' + $('#nan_idt_unidade_regional').val();

        return par;
    }

    function grc_nan_estrutura_arvore_fecha() {
        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=grc_nan_estrutura_arvore_fecha',
            data: {
                cas: conteudo_abrir_sistema,
                id: '<?php echo $_GET['id']; ?>'
            },
            success: function (response) {
                if (response.erro == '') {
                    if (response.tot == 0) {
                        $('#nan_idt_unidade_regional').removeProp("disabled").removeClass("campo_disabled");
                    } else {
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