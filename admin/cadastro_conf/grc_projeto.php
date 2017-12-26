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
$tabela = 'grc_projeto';
$id = 'idt';
$veionan = $_GET['nan0'];

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';
$corbloq = "#FFFF80";
$jst = "";
$js = "";
if ($veionan == 'S') {
    $jst = " readonly='true' style='background:{$corbloq};' ";
    $js = " disabled  style='background:{$corbloq};' ";
}
$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 45, 120, $jst);
$vetCampo['codigo_sge'] = objTexto('codigo_sge', 'Código do SGE', false, 60, 120, $jst);
$vetCampo['descricao'] = objTexto('descricao', 'Título do Projeto', True, 60, 120, $jst);
$vetCampo['gestor'] = objTexto('gestor', 'Gestor', false, 60, 120, $jst);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '', $js);
// responsável pela projeto

$vetCampo['cpf_responsavel'] = objCPF('cpf_responsavel', 'CPF do Responsável', false);

$sql = "select idt,  descricao";
$sql .= " from " . db_pir_grc . "grc_sebraetec_setor";
$sql .= " order by descricao ";
$vetCampo['idt_setor'] = objCmbBanco('idt_setor', 'Setor', false, $sql, ' ', 'width:150px;');

$vetCampo['codparceiro_siacweb'] = objHidden('codparceiro_siacweb', '', 'Código SiacWeb', true);

//
$maxlength = 700;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$vetCampo['data_criacao'] = objDatahora('data_criacao', 'Data da Criaçãor (dd/mm/aaaa hh:mm)', False);
$vetCampo['data_modificacao'] = objDatahora('data_modificacao', 'Data da Modificação (dd/mm/aaaa hh:mm)', False);

$vetCampo['existe_siacweb'] = objCmbVetor('existe_siacweb', 'Existe Siacweb?', True, $vetNaoSim);
$vetCampo['ativo_siacweb'] = objCmbVetor('ativo_siacweb', 'Ativo Siacweb?', True, $vetNaoSim);

$vetCampo['nan'] = objCmbVetor('nan', 'Atende ao NAN?', True, $vetNaoSim);
$vetCampo['ativo_nan'] = objCmbVetor('ativo_nan', 'Ativo NAN?', True, $vetNaoSim);

/*
  $sql  = "select id_usuario, nome_completo from plu_usuario ";
  $sql .= " order by nome_completo";
  $vetCampo['idt_usuario_criador'] = objCmbBanco('idt_usuario_criador', 'Criado por', false, $sql,' ','width:500px;');

  $sql  = "select id_usuario, nome_completo from plu_usuario ";
  $sql .= " order by nome_completo";
  $vetCampo['idt_usuario_modificador'] = objCmbBanco('idt_usuario_modificador', 'Modificado por', false, $sql,' ','width:500px;');
 */

$vetCampo['data_inicio'] = objDatahora('data_inicio', 'Data de Inicio (dd/mm/aaaa hh:mm)', False);
$vetCampo['data_termino'] = objDatahora('data_termino', 'Data de Termino (dd/mm/aaaa hh:mm)', False);

$sql = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_usuario_gestor'] = objCmbBanco('idt_usuario_gestor', 'Gestor', false, $sql, ' ', 'width:400px;');

$sql = "select idt, descricao from grc_projeto_tipo ";
$sql .= " order by descricao";
$vetCampo['idt_projeto_tipo'] = objCmbBanco('idt_projeto_tipo', 'Tipo do projeto', false, $sql, ' ', 'width:250px;');

$sql = "select idt, descricao from grc_projeto_situacao ";
$sql .= " order by descricao";
if ($veionan == 'S') {
    $jst = " readonly='true' style='background:{$corbloq};' ";
    $js = " disabled  style='background:{$corbloq}; width:380px;' ";
}

$vetCampo['idt_projeto_situacao'] = objCmbBanco('idt_projeto_situacao', 'Etapa do Projeto', false, $sql, ' ', '', $js);

$sql = "select idt, descricao from grc_projeto_classificacao ";
$sql .= " order by descricao";
$vetCampo['idt_projeto_classificacao'] = objCmbBanco('idt_projeto_classificacao', 'Classificacao do projeto', false, $sql, ' ', 'width:250px;');

$vetCampow = $vetCampo;

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;


if ($veionan == 'S') {
    $titulo_cadastro = "PROJETO DO NAN";
} else {
    $titulo_cadastro = "PROJETO";
}

// Definição do layout da Tela
$vetFrm = Array();

$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

// Definição de um frame ou seja de um quadro da tela para agrupar campos

$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>01 - PROJETO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'parte01',
);

if ($veionan == 'S') {
    MesclarCol($vetCampo['descricao'], 5);
    MesclarCol($vetCampo['idt_projeto_situacao'], 5);
    MesclarCol($vetCampo['gestor'], 5);
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['descricao']),
        Array($vetCampo['idt_projeto_situacao']),
        Array($vetCampo['gestor']),
        Array($vetCampo['ativo'], '', $vetCampo['nan'], '', $vetCampo['ativo_nan']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
} else {
    $vetFrm[] = Frame('<span>SGE</span>', Array(
        Array($vetCampo['descricao']),
        Array($vetCampo['idt_projeto_situacao']),
        Array($vetCampo['gestor']),
        // Array($vetCampo['codigo_sge']),
        Array($vetCampo['ativo']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_setor'], '', $vetCampo['cpf_responsavel'], '', $vetCampo['codparceiro_siacweb']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

    $vetFrm[] = Frame('<span>SiacWeb</span>', Array(
        Array($vetCampo['existe_siacweb'], '', $vetCampo['ativo_siacweb']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

    $vetFrm[] = Frame('<span>Negócio a Negócio</span>', Array(
        Array($vetCampo['nan'], '', $vetCampo['ativo_nan']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}





/*
  $vetFrm[] = Frame('<span>Identificação</span>', Array(
  Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['codigo_sge'],'',$vetCampo['ativo']),
  ),$class_frame,$class_titulo,$titulo_na_linha);
 */
/*
  $vetFrm[] = Frame('<span>Resumo</span>', Array(
  Array($vetCampo['detalhe']),
  ),$class_frame,$class_titulo,$titulo_na_linha);

  $vetFrm[] = Frame('<span>Responsavel</span>', Array(
  Array($vetCampo['idt_usuario_gestor'],'',$vetCampo['data_inicio'],'',$vetCampo['data_termino']),
  ),$class_frame,$class_titulo,$titulo_na_linha);

  $vetFrm[] = Frame('<span>Tipologia</span>', Array(
  Array($vetCampo['idt_projeto_tipo'],'',$vetCampo['idt_projeto_classificacao'],'',$vetCampo['idt_projeto_situacao']),
  ),$class_frame,$class_titulo,$titulo_na_linha);
 */

/*
  $vetFrm[] = Frame('<span>Criador/Modificador</span>', Array(
  Array($vetCampo['idt_usuario_criador'],'',$vetCampo['data_criacao']),
  Array($vetCampo['idt_usuario_modificador'],'',$vetCampo['data_modificacao']),
  ),$class_frame,$class_titulo,$titulo_na_linha);
 */


// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE PRODUTO
// AÇÕES DE PROJETOS
//____________________________________________________________________________
// Definição do frame PRODUTO ASSOCIADO
// NOME DO FRAME = produto_associado
// controle_fecha = A(o full entra aberto) F(O full entra fechado)

$vetParametros = Array(
    'codigo_frm' => 'acao_produto',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>02 - AÇÔES</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

$vetCampo = Array();
//Monta o vetor de Campo
/*
  $vetCampo['codigo']    = CriaVetTabela('Código');
  $vetCampo['grc_ps_descricao'] = CriaVetTabela('Ação');
  $vetCampo['descricao'] = CriaVetTabela('Complemento');
  $vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
  $vetCampo['data_inicio']  = CriaVetTabela('Data Inicio','data');
  $vetCampo['data_termino']  = CriaVetTabela('Data Termino','data');
  $vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Criado por:');
  $vetCampo['codigo_sge'] = CriaVetTabela('Cod.SGE');
 */
$vetCampo['descricao'] = CriaVetTabela('Título');
$vetCampo['detalhe'] = CriaVetTabela('Descrição');
$vetCampo['existe_siacweb'] = CriaVetTabela('Existe SIACWEB?', 'descDominio', $vetSimNao);
$vetCampo['ativo_siacweb'] = CriaVetTabela('Ativo SIACWEB?', 'descDominio', $vetSimNao);
$vetCampo['codigo_siacweb'] = CriaVetTabela('Código SIACWEB?');

// Parametros da tela full conforme padrão

$titulo = 'Ações do Projeto';

$TabelaPrinc = "grc_projeto_acao";
$AliasPric = "grc_ppp";
$Entidade = "Ação de Projetos";
$Entidade_p = "Ações de Projetos";

$CampoPricPai = "idt_projeto";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.codigo";

$sql = "select {$AliasPric}.*, ";
$sql .= "  grc_ps.descricao as grc_ps_descricao, ";




$sql .= "  plu_usu.nome_completo as plu_usu_nome_completo ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";

$sql .= " left join grc_projeto_acao_n grc_ps on grc_ps.idt = {$AliasPric}.idt_projeto_acao_n ";
$sql .= " left join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_usuario_criador ";
//
$sql .= " where {$AliasPric}" . '.idt_projeto = $vlID';
//p($_GET);

if ($veionan == 'S') {
    $sql .= " and {$AliasPric}" . '.nan = ' . aspa('S');
}

$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full
$vetParametros = Array(
    'barra_inc_ap' => false,
    'barra_alt_ap' => true,
    'barra_con_ap' => true,
    'barra_exc_ap' => false,
    'barra_fec_ap' => false,
);
$vetCampo['grc_projeto_acao'] = objListarConf('grc_projeto_acao', 'idt', $vetCampo, $sql, $titulo, false, $vetParametros);

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'acao_produto',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['grc_projeto_acao']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);


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

    function parListarConf_grc_projeto_acao() {
        var par = '';

        par += '&nan=' + $('#nan').val();

        return par;
    }
</script>	