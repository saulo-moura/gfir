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
        background: #FFFFFF;
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

    .Texto {
        border:0;
        background:#ECF0F1;
    }

    Select {
        border:0;
        background:#ECF0F1;
    }

    TextArea {
        border:0;
        background:#ECF0F1;
    }

    .TextArea {
        border:0;
        background:#ECF0F1;
    }

    div#xEditingArea {
        border:0;
        background:#ECF0F1;
    }

    .TextoFixo {
        background:#ECF0F1;
    }


    fieldset.class_frame {
        border:0;
    }

    .campo_disabled {
        background-color: #ffffd7;
    }    

    #parterepasse_tit {
        padding-left:0px;
    }
</style>

<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
}

$numParte = 1;

$tabela = 'grc_produto';
$sql_tabela = 'grc_produto';
$id = 'idt';

$sistema_origem = DecideSistema();

if ($acao == 'inc') {
    $tabela_c = 'grc_produto';
    $Campo_c = 'codigo';
    $tam_c = 11;
    $codigow = numerador_arquivo($tabela_c, $Campo_c, $tam_c);
    $codigo_c = aspa('BA' . $codigow);

    if ($sistema_origem == 'GEC') {
        $repasse = 'R';
    } else {
        $repasse = 'N';
    }

    if (mb_strtoupper($_GET['produtocomposto']) == 'S') {
        $idt_produto_especie = 3;
    } else {
        $idt_produto_especie = 1;
    }

    $sql = 'insert into grc_produto (idt_cadastrador, data_cadastro, codigo, repasse, idt_produto_especie, idt_produto_situacao, temporario) values (';
    $sql .= null($_SESSION[CS]['g_id_usuario']) . ', ' . aspa(trata_data(date('d/m/Y H:i:s'))) . ', ' . $codigo_c . ', ' . aspa($repasse) . ', ' . null($idt_produto_especie) . ", 4, 'S')";
    execsql($sql);
    $idt_produto = lastInsertId();

    echo "<script type='text/javascript'>self.location = '" . $pagina . "?acao=alt&id=" . $idt_produto . getParametro('acao,id') . "';</script>";
    exit();
}

$bt_exportar = true;
$bt_exportar_desc = 'Ficha do Produto';
$bt_exportar_tit = 'Ficha Técnica do Produto';

$onSubmitDep = 'grc_produto_dep()';

$vetMsgErroPersonalizado = Array(
    '23000.d' => 'Este produto não pode ser excluído, pois já foi utilizado em eventos.',
);

$direito_geral = 0;

$idt_produto = 0;

$coloinativo = '#FFFFD7';

$sql = '';
$sql .= ' select idt, codigo';
$sql .= ' from grc_produto_tipo';
$rs = execsql($sql);

$vetIdtNaturezaServico = Array();

foreach ($rs->data as $row) {
    switch ($row['codigo']) {
        case 2:
            $vetIdtNaturezaServico['C_ativa'][$row['idt']] = $row['idt'];
            $vetIdtNaturezaServico['I_deativa'][$row['idt']] = $row['idt'];
            break;

        case 1:
            $vetIdtNaturezaServico['I_ativa'][$row['idt']] = $row['idt'];
            $vetIdtNaturezaServico['C_deativa'][$row['idt']] = $row['idt'];
            break;

        default:
            $vetIdtNaturezaServico['C_ativa'][$row['idt']] = $row['idt'];
            $vetIdtNaturezaServico['I_ativa'][$row['idt']] = $row['idt'];
            break;
    }
}

$sql = '';
$sql .= ' select idt, tipo_ordem';
$sql .= ' from ' . db_pir_gec . 'gec_programa';
$sql .= " where ativo = 'S'";
$rs = execsql($sql);

$vetTipoOrdemPrograma = Array();

foreach ($rs->data as $row) {
    $vetTipoOrdemPrograma[$row['idt']] = $row['tipo_ordem'];
}

$sql = "select grc_p.*, grc_ps.codigo as grc_ps_codigo  from grc_produto grc_p ";
$sql .= " inner join  grc_produto_situacao grc_ps on grc_ps.idt =     grc_p.idt_produto_situacao ";
$sql .= " where grc_p.idt = " . null($_GET['id']);
$rs = execsql($sql);
ForEach ($rs->data as $row) {
    $grc_ps_codigo = $row['grc_ps_codigo'];
    $idt_produto_especie = $row['idt_produto_especie'];
    $idt_programa = $row['idt_programa'];
    $idt_programa_grc = $row['idt_programa_grc'];
}

if ($idt_produto_especie == 3) {
    $_GET['produtocomposto'] = 'S';
}

define('produtocomposto', mb_strtoupper($_GET['produtocomposto']));

if ($acao == "exc") {
    if ($_SESSION[CS]['g_gestor_produto'] == 'S') {
        if (!($grc_ps_codigo == '01' || $grc_ps_codigo == '20')) {
            alert('O Produto não pode ser excluido, pois não esta na situação permitida!');
            $acao = 'con';
        }
    } else {
        alert('Usuário não tem permissão para excluir o Produto!');
        $acao = 'con';
    }
}

if ($acao == "alt" && $_GET['veio_p'] == 10) {
    if (!($_SESSION[CS]['g_tipo_usuario'] == 'A' && $_SESSION[CS]['alt_status_produto'] == 'S')) {
        alert('Usuário não tem permissão para alterar o Produto!');
        $acao = 'con';
    }
}

if ($acao != "inc") {
    $codigo_atual = $grc_ps_codigo;
    $idt_produto = $_GET['id'];

    if ($_SESSION[CS]['alt_status_produto'] != 'S') {
        if ($codigo_atual == "20" and $direito_geral == 0) { // Não aprovado
            $acao = 'con';
        }
    }
} else {
    if (($codigo_atual == "40" or $codigo_atual == "50") and $direito_geral == 0) { // Ativo para o SEBRAE-BA - Descontinuado
        $acao = 'con';
    }

    if ($veio == "D") {
        $codigo_atual = '01';
    } else {
        $codigo_atual = '30';
    }
}

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;
$titulo_cadastro = "PRODUTO";


$vet = AvaliacaoEstrelinhaMediaProduto($_GET['id']);
$quantidade   = $vet['quantidade'];
$total_pontos = $vet['total_pontos'];
$media        = $vet['media'];
$img          = $vet['imagem'];
$avaliacao_img=	$img;
//echo $avaliacao_img;
//p($vet);
$vetCampo_av['avaliacao_estrelinha'] = objInclude('avaliacao_estrelinha', $avaliacao_img);


// Definição dos Campos da tela Cadastro
$vetCampo['generico'] = objCmbVetor('generico', 'Produto Genérico?', false, $vetNaoSim, '');
$vetCampo['premio'] = objCmbVetor('premio', 'Prêmio?', true, $vetNaoSim, '');
$vetCampo['composto'] = objCmbVetor('composto', 'Produto Composto?', false, $vetNaoSim, '');
$vetCampo['vl_determinado'] = objCmbVetor('vl_determinado', 'Valor Determinado?', false, $vetSimNao);

$vetCampo['repasse'] = objCmbVetor('repasse', 'Produto de Repasse?', false, $vetNaoSim, '');
$vetCampo['tem_repasse'] = objCmbVetor('tem_repasse', 'Produto Tem Repasse?', false, $vetNaoSim, '');

$vetCampo['situacao_siac'] = objCmbVetor('situacao_siac', 'Situação (Ativo/Inativo)?', false, $vetSimNao);

// INSTRUMENTO
$sql = '';
$sql .= ' select CodFamiliaProduto, NomeFamiliaProduto';
$sql .= ' from ' . db_pir_siac . 'FamiliaProdutoPortfolio';
$sql .= ' order by NomeFamiliaProduto';
$vetCampo['idt_instrumento_siac'] = objCmbBanco('idt_instrumento_siac', 'Instrumento', false, $sql, ' ', 'width:400px;');

$sql = "select idt,  descricao from grc_foco_tematico ";
$sql .= " where ativo = 'S'";
$sql .= " order by descricao";
$vetCampo['idt_foco_tematico_siac'] = objCmbBanco('idt_foco_tematico_siac', 'Foco Temático', false, $sql, ' ', 'width:400px;');

$sql = "select codsebrae, descsebrae from " . db_pir_siac . "sebrae";
$sql .= " order by descsebrae";
$vetCampo['idt_autor_siac'] = objCmbBanco('idt_autor_siac', 'Sebrae Autor', false, $sql, ' ', 'width:400px;');

$sql = "select codsebrae, descsebrae from " . db_pir_siac . "sebrae";
$sql .= " order by descsebrae";
$vetCampo['idt_responsavel_siac'] = objCmbBanco('idt_responsavel_siac', 'Sebrae Responsável', false, $sql, ' ', 'width:400px;');

$vetCampo['minimo_pagantes_siac'] = objInteiro('minimo_pagantes_siac', 'Mínimo de Pagantes', false, 10);
$vetCampo['maximo_participantes_siac'] = objInteiro('maximo_participantes_siac', 'Máximo de Participantes', false, 10);
$vetCampo['frequencia_siac'] = objInteiro('frequencia_siac', 'Frequencia Minima', false, 10);
$vetCampo['qtdias_reservados_siac'] = objInteiro('qtdias_reservados_siac', 'Qtd. dias reservados', false, 10);

$js = " readonly='true' style='background:$coloinativo; font-size:14px;' ";

$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 15, 45, $js);
$vetCampo['descricao'] = objTexto('descricao', 'Título', True, 38, 255);
$vetCampo['titulo_comercial'] = objTexto('titulo_comercial', 'Título Comercial', True, 38, 255);
$vetCampo['ativo'] = objHidden('ativo', 'S');

$vetCampo['codigo_siac'] = objTexto('codigo_siac', 'Código SIAC', false, 15, 45);
$vetCampo['codigo_classificacao_siac'] = objTexto('codigo_classificacao_siac', 'Código Produto SIAC', false, 15, 45);
$vetCampo['descricao_siac'] = objTexto('descricao_siac', 'Descrição do Produto no SIAC', false, 45, 120);

$vetCampo['copia'] = objInteiro('copia', 'Cópia', True, 5);

$js = " onchange='return proprio_s(); '   ";
$vetCampo['proprio'] = objCmbVetor('proprio', 'Próprio?', True, $vetSimNao, '', $js);

$style = ' style="width:300px;" ';
$vetCampo['idt_entidade_autora'] = objListarCmb('idt_entidade_autora', 'gec_entidadet_cmb', 'Terceiros - Entidade Autora', false);

$maxlength = 2000;
$style = "width:700px;";
$js = "";
$vetCampo['conceito_interno'] = objTextArea('conceito_interno', 'Conceito Interno', false, $maxlength, $style, $js);
$vetCampo['recomendacao_interna'] = objTextArea('recomendacao_interna', 'Recomendações Interno', false, $maxlength, $style, $js);
$vetCampo['carga_horaria'] = objTextArea('carga_horaria', 'Carga Horária Instrutoria descrição', false, $maxlength, $style, $js);
$vetCampo['carga_horaria_2'] = objTextArea('carga_horaria_2', 'Carga Horária Consultoria descrição', false, $maxlength, $style, $js);
$vetCampo['carga_horaria_ini'] = objDecimal('carga_horaria_ini', 'Carga Horária Instrutoria Mínima', false, 14);
$vetCampo['carga_horaria_2_ini'] = objDecimal('carga_horaria_2_ini', 'Carga Horária Consultoria Mínima', false, 14);
$vetCampo['carga_horaria_fim'] = objDecimal('carga_horaria_fim', 'Carga Horária Instrutoria Máxima', false, 14);
$vetCampo['carga_horaria_2_fim'] = objDecimal('carga_horaria_2_fim', 'Carga Horária Consultoria Máxima', false, 14);
$vetCampo['objetivo'] = objHTML('objetivo', 'Objetivo', false);
$vetCampo['detalhe'] = objHTML('detalhe', 'Descrição dos Serviços', false);
$vetCampo['beneficio'] = objHTML('beneficio', 'Benefícios', false);
$vetCampo['complemento'] = objHTML('complemento', 'Informações Complementares', false);
$vetCampo['descricao_comercial'] = objHTML('descricao_comercial', 'Descrição Comercial', false);
$vetCampo['conteudo_programatico'] = objHTML('conteudo_programatico', 'Conteúdo programático', false);
$vetCampo['encontro_quantidade'] = objInteiro('encontro_quantidade', 'Quantidade de Encontros', false, 10);
$vetCampo['encontro_texto'] = objTexto('encontro_texto', 'Observação Quantidade de Encontros', false, 45, 120);
$vetCampo['participante_minimo'] = objInteiro('participante_minimo', 'Participantes - Mínimo', false, 10);
$vetCampo['participante_maximo'] = objInteiro('participante_maximo', 'Participantes - Máximo', false, 10);
$completapar = " readonly='true' style='background:$coloinativo;' ";
$vetCampo_w['ctotal_minimo'] = objDecimal('ctotal_minimo', 'Custo Total Mínimo', false, 10, '', 2, $completapar);
$vetCampo_w['ctotal_maximo'] = objDecimal('ctotal_maximo', 'Custo Total Máximo', false, 10, '', 2, $completapar);
$vetCampo_w['rtotal_minimo'] = objDecimal('rtotal_minimo', 'Receita Total Mínima', false, 10, '', 2, $completapar);
$vetCampo_w['rtotal_maximo'] = objDecimal('rtotal_maximo', 'Receita Total Máxima', false, 10, '', 2, $completapar);
$vetCampo_w['rmedia'] = objDecimal('rmedia', 'Receita Total Média', false, 10, '', 2, $completapar);
$vetCampo_w['cmedio'] = objDecimal('cmedio', 'Custo Total Médio', false, 10, '', 2, $completapar);
$vetCampo_w['dif_minimo'] = objDecimal('dif_minimo', 'Despesas - Receita Mínimo', false, 10, '', 2, $completapar);
$vetCampo_w['dif_maximo'] = objDecimal('dif_maximo', 'Despesas - Receita Máximo', false, 10, '', 2, $completapar);
$vetCampo_w['dif_medio'] = objDecimal('dif_medio', 'Despesas - Receita Médio', false, 10, '', 2, $completapar);

$vetCampo['palavra_chave'] = objTextArea('palavra_chave', 'Palavras Chaves', false, $maxlength, $style, $js);

// Natureza do Serviço 
$sql = "select idt,  descricao from grc_produto_tipo ";
$sql .= " where ativo = " . aspa('S');

if (produtocomposto != 'S') {
    $sql .= " and codigo <> '3'";
}

$sql .= " order by codigo";
$vetCampo['idt_produto_tipo'] = objCmbBanco('idt_produto_tipo', 'Natureza Serviço', false, $sql, ' ', 'width:400px;');

// Grupo de Produto
$sql = "select idt,  descricao from grc_produto_grupo ";
$sql .= " order by codigo";
$vetCampo['idt_grupo'] = objCmbBanco('idt_grupo', 'Grupo', false, $sql, ' ', 'width:400px;');

// TIPOLOGIA
$sql = "select idt, codigo,  descricao from grc_produto_familia ";
$sql .= " order by codigo";
$vetCampo['idt_produto_familia'] = objCmbBanco('idt_produto_familia', 'Família', false, $sql, ' ', 'width:400px;');

$sql = "select idt,  descricao from grc_foco_tematico ";
$sql .= " where ativo = 'S'";
$sql .= " order by descricao";
$vetCampo['idt_foco_tematico'] = objCmbBanco('idt_foco_tematico', 'Foco Temático', false, $sql, ' ', 'width:400px;');

$sql = "select idt,  descricao from grc_produto_canal_midia ";
$sql .= " order by codigo";
$vetCampo['idt_produto_canal_midia'] = objCmbBanco('idt_produto_canal_midia', 'Canal/Midia', true, $sql, ' ', 'width:400px;');

// TAXONOMIA -----------------------
$sql = "select idt,  descricao from grc_produto_dimensao_complexidade ";
$sql .= " order by codigo";
$vetCampo['idt_produto_dimensao_complexidade'] = objCmbBanco('idt_produto_dimensao_complexidade', 'Dimensão de Complexidade', true, $sql, ' ', 'width:400px;');

$par = 'idt_produto_dimensao_complexidade';
$vetDesativa['idt_instrumento'][0] = vetDesativa($par, '39,40,50', false);
$vetAtivadoObr['idt_instrumento'][0] = vetAtivadoObr($par, '39,40,50');

$sql = "select idt,  descricao from grc_produto_area_competencia ";
$sql .= " order by codigo";
$vetCampo['idt_produto_area_competencia'] = objCmbBanco('idt_produto_area_competencia', 'Area de Competencia', true, $sql, ' ', 'width:260px;');

$sql = "select idt,  descricao from grc_area_conhecimento ";
$sql .= " order by codigo";
$vetCampo['idt_produto_area_conhecimento'] = objCmbBanco('idt_produto_area_conhecimento', 'Area de Conhecimento', true, $sql, ' ', 'width:260px;');

$sql = "select idt,  descricao from grc_tema_subtema ";
$sql .= " order by codigo";
$vetCampo['idt_tema_subtema'] = objCmbBanco('idt_tema_subtema', 'Tema/Subtemas', true, $sql, ' ', 'width:260px;');

$sql = "select idt,  descricao from grc_produto_tag_pesquisa ";
$sql .= " order by codigo";
$vetCampo['idt_produto_tag_pesquisa'] = objCmbBanco('idt_produto_tag_pesquisa', 'TAGs', true, $sql, ' ', 'width:260px;');

// DADOS COMPLEMENTARES
$sql = "select idt,  descricao from grc_produto_modelo_certificado ";
$sql .= " order by codigo";
$vetCampo['idt_produto_modelo_certificado'] = objCmbBanco('idt_produto_modelo_certificado', 'Modelo do Certificado', false, $sql, ' ', 'width:400px;');

$sql = "select idt,  descricao from grc_produto_maturidade ";
$sql .= " where ativo = 'S'";
$sql .= " order by codigo";
$vetCampo['idt_produto_maturidade'] = objCmbBanco('idt_produto_maturidade', 'Maturidade', true, $sql, ' ', 'width:400px;');

if (produtocomposto == 'S') {
    $_GET['idt99'] = 3;
    $vetCampo['idt_produto_especie'] = objFixoBanco('idt_produto_especie', 'Tipo de Produto', 'grc_produto_especie', 'idt', 'descricao', 99);
} else {
    $sql = "select idt,  descricao from grc_produto_especie ";
    $sql .= " where ativo = " . aspa('S');
    $sql .= " and codigo <> " . aspa('03');
    $sql .= " order by codigo";
    $vetCampo['idt_produto_especie'] = objCmbBanco('idt_produto_especie', 'Tipo de Produto', true, $sql);
}

$sql = "select idt,  descricao from " . db_pir_gec . "gec_programa ";
$sql .= " where ativo = 'S'";

if ($idt_programa_grc != '') {
    $sql .= ' and idt in (';
    $sql .= ' select idt';
    $sql .= ' from ' . db_pir_gec . 'gec_programa_grc_programa';
    $sql .= ' where idt_grc_programa = ' . null($idt_programa_grc);
    $sql .= ' )';
}

$sql .= " order by codigo";
$vetCampo['idt_programa'] = objCmbBanco('idt_programa', 'Programa Credenciado', true, $sql, ' ', 'width:400px;');

$sql = "select idt,  descricao from grc_programa ";

if ($idt_programa != '') {
    $sql .= ' where idt in (';
    $sql .= ' select idt_grc_programa';
    $sql .= ' from ' . db_pir_gec . 'gec_programa_grc_programa';
    $sql .= ' where idt = ' . null($idt_programa);
    $sql .= ' )';
}

$sql .= " order by codigo";
$vetCampo['idt_programa_grc'] = objCmbBanco('idt_programa_grc', 'Programa', false, $sql, ' ', 'width:400px;');

if ($_SESSION[CS]['alt_status_produto'] == 'S') {
    $sql = "select idt,  descricao from grc_produto_situacao ";

    if ($grc_ps_codigo != 40) {
        $sql .= " where codigo <> 40 ";
    }

    $sql .= " order by codigo";

    $js = '';
    $style = '';
} else {
    if ($veio == 'D') {
        $sql = "select idt,  descricao from grc_produto_situacao ";
        $sql .= " where situacao_etapa='D' ";
        $sql .= " order by codigo";
    } else {
        $sql = "select idt,  descricao from grc_produto_situacao ";
        $sql .= " where situacao_etapa='E' ";
        $sql .= " order by codigo";
    }

    $js = " disabled='true' ";
    $style = "background:{$coloinativo}; width:200px;";
}

$vetCampo['idt_produto_situacao'] = objCmbBanco('idt_produto_situacao', 'Situação Atual', true, $sql, '', $style, $js);

$vetCampo['etapas_desenvolvimento'] = objInclude('etapas_desenvolvimento', 'cadastro_conf/produto_etapa_desenvolvimento.php');

$vetCampo['produto_copiar'] = objInclude('produto_copiar', 'cadastro_conf/produto_copiar.php');

$sql = "select idt,  descricao from grc_produto_tipo_autor ";
$sql .= " order by codigo";
$vetCampo['idt_produto_tipo_autor'] = objCmbBanco('idt_produto_tipo_autor', 'Direitos Autorais', true, $sql, '', 'width:400px;');

$sql = '';
$sql .= ' select d.idt, d.descricao';
$sql .= ' from grc_publico_alvo d';
$sql .= ' inner join grc_produto_publico_alvo df on d.idt = df.idt_publico_alvo_outro';
$sql .= ' where df.idt = ' . null($_GET['id']);
$sql .= ' order by d.codigo';
$vetCampo['idt_publico_alvo'] = objCmbBanco('idt_publico_alvo', 'Público Alvo Prioritário', true, $sql, ' ', 'width:400px;');

$sql_lst_1 = 'select idt as idt_publico_alvo_outro, descricao from grc_publico_alvo order by codigo';

$sql_lst_2 = 'select d.idt as idt_publico_alvo_outro, d.descricao from grc_publico_alvo d inner join
               grc_produto_publico_alvo df on d.idt = df.idt_publico_alvo_outro
               where df.idt = ' . null($_GET['id']) . ' order by d.codigo';

$vetCampo['idt_publico_alvo_outro'] = objLista('idt_publico_alvo_outro', false, 'Públicos Alvos do Sistema', 'sistema', $sql_lst_1, 'grc_produto_publico_alvo', 400, 'Público Alvo do Produto', 'funcao', $sql_lst_2);

$js = "";
$style = ' width:730px;';

$vetCampo['publico_alvo_texto'] = objTextArea('publico_alvo_texto', 'Complemento Publico Alvo', false, $maxlength, $style, $js);

$vetCampo['gratuito'] = objCmbVetor('gratuito', 'Gratuito?', false, $vetSimNao);

$par = 'idt_secao_autora';

$vetDesativa['idt_produto_abrangencia'][0] = vetDesativa($par, '2', false);

$vetAtivadoObr['idt_produto_abrangencia'][0] = vetAtivadoObr($par, '2');

$par = 'idt_entidade_autora';

$vetDesativa['idt_produto_abrangencia'][1] = vetDesativa($par, '12', false);

//
// $vetAtivadoObr['idt_produto_abrangencia'][1] = vetAtivadoObr($par, '12');
//

$js = " onchange='return autora_propria(); '   ";

$sql = "select idt,  descricao from grc_produto_abrangencia ";
$sql .= " order by codigo";
$vetCampo['idt_produto_abrangencia'] = objCmbBanco('idt_produto_abrangencia', 'Entidade Autora', true, $sql, ' ', 'width:300px;', $js);
//
// SECAO AUTORA
//
$sql = "select idt,  descricao from " . db_pir . "sca_organizacao_secao ";
$sql .= " order by classificacao";
$vetCampo['idt_secao_autora'] = objCmbBanco('idt_secao_autora', 'Unidade Autora', false, $sql, ' ', 'width:300px;');
//
// SGTEC - tipo de serviço
//
$sql = "select idt,  descricao from grc_sgtec_tipo_servico ";
$sql .= " order by codigo";
$vetCampo_sgtec['idt_sgtec_tipo_servico'] = objCmbBanco('idt_sgtec_tipo_servico', 'SGTEC - Tipo Serviço', false, $sql, ' ', 'width:400px;');
// SECAO RESPONSÁVEL
$sql = "select idt,  descricao from " . db_pir . "sca_organizacao_secao ";
$sql .= " order by classificacao";
$vetCampo['idt_secao_responsavel'] = objCmbBanco('idt_secao_responsavel', 'Unidade Responsável', false, $sql, ' ', 'width:400px;');
// INSTRUMENTO
$sql = "select idt, descricao from grc_atendimento_instrumento ";
$sql .= " where nivel = 1";
$sql .= " order by descricao";
$vetCampo['idt_instrumento'] = objCmbBanco('idt_instrumento', 'Instrumento', true, $sql, ' ', 'width:400px;');
// modalidade
$sql = "select idt, codigo, descricao from grc_produto_modalidade ";
$sql .= " order by codigo";
$vetCampo['idt_modalidade'] = objCmbBanco('idt_modalidade', 'Modalidade', true, $sql, ' ', 'width:400px;');
// modalidade
$sql = "select idt, descricao from " . db_pir_gec . "gec_entidade_grau_formacao ";
$sql .= " order by codigo";
$vetCampo['idt_grau_escolaridade'] = objCmbBanco('idt_grau_escolaridade', 'Grau de Escolaridade', false, $sql, ' ', 'width:300px;');
//
$par = 'carga_horaria_2_ini,carga_horaria_2_fim,carga_horaria_2';
//
if (is_array($vetIdtNaturezaServico['C_deativa'])) {
    $valor = implode(',', $vetIdtNaturezaServico['C_deativa']);
} else {
    $valor = '';
}
$vetDesativa['idt_produto_tipo'][0] = vetDesativa($par, ',' . $valor);

$par = 'carga_horaria_ini,carga_horaria_fim,carga_horaria';

if (is_array($vetIdtNaturezaServico['I_deativa'])) {
    $valor = implode(',', $vetIdtNaturezaServico['I_deativa']);
} else {
    $valor = '';
}
$vetDesativa['idt_produto_tipo'][1] = vetDesativa($par, ',' . $valor);

$vetCampo['insumo_horas_comp'] = objCmbVetor('insumo_horas_comp', 'Produto possui Horas Complementares?', True, $vetSimNao);

$vetCampo['tipo_calculo'] = objCmbVetor('tipo_calculo', 'Tipo de Cálculo', false, $vetProdTipoCalculo);
$vetCampo['forcar_carga_horarria'] = objCmbVetor('forcar_carga_horarria', 'Forçar Carga Horária', false, $vetSimNao);
$vetCampo['tempo_medio'] = objDecimal('tempo_medio', 'Tempo Médio da Consultoria', false, 9);
$vetCampo['vl_teto'] = objDecimal('vl_teto', 'Valor Teto do Produto', false, 10);

//
// Definição do layout da Tela
//
$vetFrm = Array();
//
// Definição de um frame ou seja de um quadro da tela para agrupar campos

$vetParametros = Array(
    'situacao_padrao' => true,
);
$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>' . numParte() . ' - IDENTIFICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


$vetParametros = Array(
    'codigo_pai' => 'parte01',
);

if (produtocomposto != 'S') {
//
// Definição de layout de campos da tela (codigo, descrição e ativo
// que aparecerão dentro do "frame" IDENTIFICAÇÃO
//
    MesclarCol($vetCampo['idt_foco_tematico_siac'], 3);
    MesclarCol($vetCampo['idt_responsavel_siac'], 3);
    MesclarCol($vetCampo['qtdias_reservados_siac'], 3);
    MesclarCol($vetCampo['maximo_participantes_siac'], 3);

    $vetFrm[] = Frame('<span>Relação com o SIAC</span>', Array(
        // Array($vetCampo['codigo_siac'], '', $vetCampo['codigo_classificacao_siac'], '', $vetCampo['descricao_siac']),

        Array($vetCampo['codigo_siac'], '', $vetCampo['descricao_siac'], '', $vetCampo['situacao_siac']),
        //
        Array($vetCampo['idt_instrumento_siac'], '', $vetCampo['idt_foco_tematico_siac']),
        Array($vetCampo['idt_autor_siac'], '', $vetCampo['idt_responsavel_siac']),
        //
        Array($vetCampo['frequencia_siac'], '', $vetCampo['qtdias_reservados_siac']),
        Array($vetCampo['minimo_pagantes_siac'], '', $vetCampo['maximo_participantes_siac']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}

/*
  Código           codigo_siac
  Nome do Produto no SIAC     descricao_siac
  Instrumento        instrumento_siac
  Foco Temático      foco_tematico_siac
  Sebrae Autor       autor_siac
  Sebrae Responsável  responsavel_siac
  Situação no SIAC (Ativo/Inativo)    ativo_siac
  Frequencia                        frequencia_siac
  Quantidade de dias reservados     qtdias_reservados_siac
  Máximo de Participantes           maximo_participantes_siac
  Mínimo de pagantes                minimo_pagantes_siac
 */

//MesclarCol($vetCampo['descricao'], 5);
//MesclarCol($vetCampo['titulo_comercial'], 5);
$vetFrm[] = Frame('<span>Identificação PIR</span>', Array(
    Array($vetCampo['codigo'], '', $vetCampo['copia'], '', $vetCampo['descricao'], '', $vetCampo['titulo_comercial'], '', $vetCampo['ativo'],'',$vetCampo_av['avaliacao_estrelinha']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('<span>Etapas do Desenvolvimento</span>', Array(
    Array($vetCampo['produto_copiar'], '', $vetCampo['idt_produto_situacao'], '', $vetCampo['etapas_desenvolvimento']),), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

/*
  $vetFrm[] = Frame('<span>Conceito Interno</span>', Array(
  Array($vetCampo['conceito_interno']),
  ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

  $vetFrm[] = Frame('<span>Recomendação Externa</span>', Array(
  Array($vetCampo['recomendacao_interna']),
  ),$class_frame,$class_titulo,$titulo_na_linha, $vetParametros);

 */

//MesclarCol($vetCampo['proprio'], 3);
//MesclarCol($vetCampo['idt_secao_responsavel'], 7);

$vetFrm[] = Frame('<span>Unidades Responsáveis</span>', Array(
//      Array($vetCampo['idt_produto_abrangencia'],'',$vetCampo['proprio'],'',$vetCampo['idt_secao_autora'],'',$vetCampo['idt_entidade_autora']),

    Array($vetCampo['idt_produto_abrangencia'], '', $vetCampo['idt_entidade_autora']),
    Array($vetCampo['idt_secao_autora'], '', $vetCampo['idt_secao_responsavel']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);



//Array($vetCampo['idt_produto_area_conhecimento'],'',$vetCampo['idt_publico_alvo']),

if (produtocomposto == 'S') {
    $vetCampo['pc_consultoria'] = objCheckbox('pc_consultoria', 'Instrumento(s)', 'S', 'N', 'Consultoria', true, 'N');
    $vetCampo['pc_curso'] = objCheckbox('pc_curso', '', 'S', 'N', 'Curso', true, 'N');
    $vetCampo['pc_oficina'] = objCheckbox('pc_oficina', '', 'S', 'N', 'Oficina', true, 'N');
    $vetCampo['pc_palestra'] = objCheckbox('pc_palestra', '', 'S', 'N', 'Palestra', true, 'N');
    $vetCampo['pc_seminario'] = objCheckbox('pc_seminario', '', 'S', 'N', 'Seminário', true, 'N');

    MesclarCol($vetCampo['idt_programa_grc'], 9);

    $vetFrm[] = Frame('<span>Tipo do Produto</span>', Array(
        Array($vetCampo['idt_programa_grc'], '', $vetCampo['idt_programa']),
        Array($vetCampo['pc_consultoria'], '', $vetCampo['pc_curso'], '', $vetCampo['pc_oficina'], '', $vetCampo['pc_palestra'], '', $vetCampo['pc_seminario'], '', $vetCampo['idt_produto_especie']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
} else {
    $vetParametros = Array(
        'codigo_frm' => 'parte01_01',
        'controle_fecha' => 'A',
    );
    $vetFrm[] = Frame('<span>' . numParte() . ' - CLASSIFICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


    $vetParametros = Array(
        'codigo_pai' => 'parte01_01',
    );

//MesclarCol($vetCampo['tem_repasse'], 3);

    if ($sistema_origem == 'GEC') {
        // 
        // produto é de repasse
        //
        $vetFrm[] = Frame('', Array(
            //Array($vetCampo['generico'], '', $vetCampo['composto']),
            Array($vetCampo['generico'], '', $vetCampo['idt_produto_especie']),
            Array($vetCampo['repasse'], '', $vetCampo['premio']),
            Array($vetCampo['idt_programa_grc'], '', $vetCampo['idt_programa']),
            Array($vetCampo['idt_instrumento'], '', $vetCampo['idt_produto_familia']),
            Array($vetCampo['idt_produto_dimensao_complexidade'], '', $vetCampo['idt_grupo']),
            Array($vetCampo['idt_modalidade'], '', $vetCampo['idt_foco_tematico']),
            Array($vetCampo['idt_produto_tipo'], '', $vetCampo['idt_produto_tipo_autor']),
            Array($vetCampo['idt_produto_modelo_certificado'], '', $vetCampo['idt_produto_maturidade']),
                ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
    } else {
        // Indica s eo protudo tem repasse....

        MesclarCol($vetCampo['idt_programa_grc'], 3);
        MesclarCol($vetCampo['tem_repasse'], 3);
        MesclarCol($vetCampo['idt_instrumento'], 3);
        MesclarCol($vetCampo['idt_produto_dimensao_complexidade'], 3);
        MesclarCol($vetCampo['idt_modalidade'], 3);
        MesclarCol($vetCampo['idt_produto_tipo'], 3);
        MesclarCol($vetCampo['idt_produto_modelo_certificado'], 3);
        
        MesclarCol($vetCampo['idt_programa'], 5);
        MesclarCol($vetCampo['insumo_horas_comp'], 3);
        MesclarCol($vetCampo['idt_produto_familia'], 5);
        MesclarCol($vetCampo['idt_grupo'], 5);
        MesclarCol($vetCampo['idt_foco_tematico'], 5);
        MesclarCol($vetCampo['idt_produto_tipo_autor'], 5);
        MesclarCol($vetCampo['idt_produto_maturidade'], 5);

        $vetFrm[] = Frame('', Array(
            Array($vetCampo['idt_programa_grc'], '', $vetCampo['idt_programa']),
            Array($vetCampo['generico'], '', $vetCampo['premio'], '', $vetCampo['idt_produto_especie'], '', $vetCampo['vl_determinado'], '', $vetCampo['vl_teto']),
            Array($vetCampo['tem_repasse'], '', $vetCampo['insumo_horas_comp'], '', $vetCampo['tempo_medio']),
            Array($vetCampo['idt_instrumento'], '', $vetCampo['idt_produto_familia']),
            Array($vetCampo['idt_produto_dimensao_complexidade'], '', $vetCampo['idt_grupo']),
            Array($vetCampo['idt_modalidade'], '', $vetCampo['idt_foco_tematico']),
            Array($vetCampo['idt_produto_tipo'], '', $vetCampo['idt_produto_tipo_autor']),
            Array($vetCampo['idt_produto_modelo_certificado'], '', $vetCampo['idt_produto_maturidade']),
                ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
    }

//
// ÁREA DE CONHECIMENTO
//____________________________________________________________________________

    $vetParametros = Array(
        'codigo_frm' => 'area_conhecimento',
        'controle_fecha' => 'F',
    );
    $vetFrm[] = Frame('<span>' . numParte() . ' - ÁREAS DE CONHECIMENTOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

    $vetCampoLC = Array();
    $vetCampoLC['gec_ac_descricao'] = CriaVetTabela('Área de Conhecimento');
    $vetCampoLC['detalhe'] = CriaVetTabela('Detalhe');

    $titulo = 'ÁREA DE CONHECIMENTO';
    $TabelaPrinc = "grc_produto_area_conhecimento";
    $AliasPric = "grc_procp";
    $Entidade = "Área de Conhecimento";
    $Entidade_p = "Área de Conhecimento";
    $CampoPricPai = "idt_produto";

    $orderby = "gec_ac.codigo";

    $sql = "select {$AliasPric}.*, ";
    $sql .= "       gec_ac.descricao as gec_ac_descricao ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join " . db_pir_gec . "gec_area_conhecimento gec_ac on gec_ac.idt = {$AliasPric}.idt_area ";

    $sql .= " where {$AliasPric}" . '.idt_produto = $vlID';
    $sql .= " order by {$orderby}";

    $vetCampo['grc_produto_area_conhecimento'] = objListarConf('grc_produto_area_conhecimento', 'idt', $vetCampoLC, $sql, $titulo, false);

    $vetParametros = Array(
        'codigo_pai' => 'area_conhecimento',
        'width' => '100%',
    );

    $vetFrm[] = Frame('', Array(
        Array($vetCampo_sgtec['idt_sgtec_tipo_servico']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_produto_area_conhecimento']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}

// Definição do frame PRODUTO ASSOCIADO
// NOME DO FRAME = produto_associado
// controle_fecha = A(o full entra aberto) F(O full entra fechado)
// aqui tb compoe o produto composto

$vetParametros = Array(
    'codigo_frm' => 'produto_associado',
    'controle_fecha' => 'F',
);
$vetFrm[] = Frame('<span>' . numParte() . ' - PRODUTOS ASSOCIADOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetTpRel = Array();
$vetTpRel['C'] = 'Combo';
$vetTpRel['P'] = 'Predecessora';

$vetCampoLC = Array();
$vetCampoLC['instrumento'] = CriaVetTabela('Instrumento');
$vetCampoLC['grc_pp_descricao'] = CriaVetTabela('Família<br />Produto');
$vetCampoLC['detalhe'] = CriaVetTabela('Detalhe');

if (produtocomposto != 'S') {
    $vetCampoLC['tipo_relacao'] = CriaVetTabela('Tipo de Relação?', 'descDominio', $vetTpRel);
    $vetCampoLC['obrigatorio'] = CriaVetTabela('Obrigatório?', 'descDominio', $vetSimNao);
    $vetCampoLC['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);
}

$titulo = 'Produto Associado';

$sql = "select grc_atdp.*, inst.descricao as instrumento,";
$sql .= "    CONCAT_WS('<br />',grc_prf.descricao,grc_pp.descricao) as grc_pp_descricao  ";
$sql .= " from grc_produto_produto grc_atdp  ";
$sql .= " inner join grc_produto grc_pp on grc_pp.idt = grc_atdp.idt_produto_associado ";
$sql .= " inner join grc_atendimento_instrumento inst on inst.idt = grc_pp.idt_instrumento ";
$sql .= " left outer join grc_produto_familia grc_prf on grc_prf.idt = grc_pp.idt_produto_familia ";
$sql .= " where grc_atdp" . '.idt_produto = $vlID';
$sql .= " order by grc_atdp.codigo";

$vetCampo['grc_produto_produto'] = objListarConf('grc_produto_produto', 'idt', $vetCampoLC, $sql, $titulo, produtocomposto == 'S');

$vetParametros = Array(
    'codigo_pai' => 'produto_associado',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_produto_produto']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

/*
  if ($sistema_origem == 'GEC') {
  $vetFrm[] = Frame('<span>Repasse</span>', Array(
  Array($vetCampo['repasse']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
  } else {
  $vetFrm[] = Frame('<span>Repasse</span>', Array(
  Array($vetCampo['tem_repasse']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
  }
 */

$vetParametros = Array(
    'codigo_frm' => 'parte01_02',
    'controle_fecha' => 'F',
);
$vetFrm[] = Frame('<span>' . numParte() . ' - APLICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


$vetParametros = Array(
    'codigo_pai' => 'parte01_02',
);

//MesclarCol($vetCampo['publico_alvo_texto'], 3);
//MesclarCol($vetCampo['gratuito'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['gratuito'], '', $vetCampo['idt_grau_escolaridade']),
    Array($vetCampo['participante_minimo'], '', $vetCampo['participante_maximo']),
    Array($vetCampo['encontro_quantidade'], '', $vetCampo['encontro_texto']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_publico_alvo_outro']),
    Array($vetCampo['idt_publico_alvo']),
    Array($vetCampo['publico_alvo_texto']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame("<span>TAG's</span>", Array(
    Array($vetCampo['palavra_chave']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

if (produtocomposto != 'S') {
    MesclarCol($vetCampo['carga_horaria'], 3);
    MesclarCol($vetCampo['carga_horaria_2'], 3);

    $vetFrm[] = Frame('<span>Carga Horária</span>', Array(
        Array($vetCampo['carga_horaria_ini'], '', $vetCampo['carga_horaria_fim']),
        Array($vetCampo['carga_horaria']),
        Array($vetCampo['tipo_calculo'], '', $vetCampo['forcar_carga_horarria']),
        Array($vetCampo['carga_horaria_2_ini'], '', $vetCampo['carga_horaria_2_fim']),
        Array($vetCampo['carga_horaria_2']),
            ), $class_frame . ' frm_carga_horaria', $class_titulo, $titulo_na_linha, $vetParametros);
}

$vetFrm[] = Frame('<span>Objetivo</span>', Array(
    Array($vetCampo['objetivo']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('<span>Descrição dos Serviços</span>', Array(
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('<span>Conteúdo Programático</span>', Array(
    Array($vetCampo['conteudo_programatico']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('<span>Benefícios</span>', Array(
    Array($vetCampo['beneficio']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('<span>Complemento</span>', Array(
    Array($vetCampo['complemento']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('<span>Descrição Comercial</span>', Array(
    Array($vetCampo['descricao_comercial']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

/*
  $vetFrm[] = Frame('<span>Tipologia</span>', Array(
  Array($vetCampo['idt_produto_familia'],'',$vetCampo['idt_produto_abrangencia']),
  Array($vetCampo['idt_produto_canal_midia'],'',$vetCampo['idt_foco_tematico']),
  ),$class_frame,$class_titulo,$titulo_na_linha);
 */

/*
  $vetFrm[] = Frame('<span>Taxonomia</span>', Array(
  Array($vetCampo['idt_produto_dimensao_complexidade'],'',$vetCampo['idt_tema_subtema'],'',$vetCampo['idt_produto_tag_pesquisa']),
  Array($vetCampo['idt_produto_area_competencia'],'',$vetCampo['idt_produto_area_conhecimento'],'',$vetCampo['idt_publico_alvo']),
  ),$class_frame,$class_titulo,$titulo_na_linha);

 */

/*
  $vetFrm[] = Frame('<span>Complemento</span>', Array(
  Array($vetCampo['idt_produto_modelo_certificado'],'',$vetCampo['idt_produto_maturidade']),
  Array($vetCampo['idt_produto_tipo'],'',$vetCampo['idt_produto_tipo_autor']),
  ),$class_frame,$class_titulo,$titulo_na_linha);
 */
// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE PRODUTO
// PROFISSIONAIS PRODUTOS 

if (produtocomposto != 'S') {
    $vetParametros = Array(
        'codigo_frm' => 'produto_profissional',
        'controle_fecha' => 'F',
    );
    $vetFrm[] = Frame('<span>' . numParte() . ' - PROFISSIONAIS</span>', '', $class_frame_p . ' f_produto_profissional', $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

    $vetCampo = Array();
    $vetCampo['gec_p_descricao'] = CriaVetTabela('Tipo de Profissional');
    $vetCampo['observacao'] = CriaVetTabela('Observação');

// Parametros da tela full conforme padrão

    $titulo = 'Profissionais Associados';

    $TabelaPrinc = "grc_produto_profissional";
    $AliasPric = "grc_atdp";
    $Entidade = "Profissional do Produto";
    $Entidade_p = "Profissionais do Produto";

    $CampoPricPai = "idt_produto";

// Select para obter campos da tabela que serão utilizados no full

    $orderby = "gec_p.codigo";

    $sql = "select {$AliasPric}.*, ";
    $sql .= "  gec_p.descricao as  gec_p_descricao  ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join " . db_pir_gec . "gec_profissional gec_p on gec_p.idt = grc_atdp.idt_profissional ";
    $sql .= " where {$AliasPric}" . '.idt_produto = $vlID';
    $sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full

    $vetCampo['grc_produto_profissional'] = objListarConf('grc_produto_profissional', 'idt', $vetCampo, $sql, $titulo, false);

// Fotmata lay_out de saida da tela full

    $vetParametros = Array(
        'codigo_pai' => 'produto_profissional',
        'width' => '100%',
    );
    $vetCampo_C['necessita_credenciado'] = objCmbVetor('necessita_credenciado', 'Necessita Credenciado?', false, $vetSimNao, '');

    $vetFrm[] = Frame('', Array(
        Array($vetCampo_C['necessita_credenciado']),
        Array($vetCampo['grc_produto_profissional']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

    /*

      // CONTEÚDO PROGRAMÁTICO
      //____________________________________________________________________________


      $vetParametros = Array(
      'codigo_frm' => 'conteudo_programatico',
      'controle_fecha' => 'F',
      );
      $vetFrm[] = Frame('<span>'.numParte().' - CONTEÚDO PROGRAMÁTICO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

      $vetCampo = Array();
      //$vetCampo['grc_pp_descricao'] = CriaVetTabela('Conteudo Programático');
      $vetCampo['codigo']    = CriaVetTabela('Código');
      $vetCampo['descricao'] = CriaVetTabela('Descrição');
      $vetCampo['detalhe'] = CriaVetTabela('Detalhe');
      $vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );


      $titulo = 'Conteudo Programatico';

      $TabelaPrinc      = "grc_produto_conteudo_programatico";
      $AliasPric        = "grc_procp";
      $Entidade         = "Conteúdo Programático do Produto";
      $Entidade_p       = "Conteúdos Programático do Produto";

      $CampoPricPai     = "idt_produto";

      $orderby = "{$AliasPric}.codigo";

      $sql  = "select {$AliasPric}.* ";
      //$sql  .= "       grc_pp.descricao as grc_pp_descricao ";
      $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
      //$sql .= " inner join grc_produto_conteudo_programatico_n grc_pp on grc_pp.idt = {$AliasPric}.idt_produto_conteudo_programatico ";
      //
      $sql .= " where {$AliasPric}".'.idt_produto = $vlID';
      $sql .= " order by {$orderby}";

      $vetCampo['grc_produto_conteudo_programatico'] = objListarConf('grc_produto_conteudo_programatico', 'idt', $vetCampo, $sql, $titulo, false);

      $vetParametros = Array(
      'codigo_pai' => 'conteudo_programatico',
      'width' => '100%',
      );

      $vetFrm[] = Frame('', Array(
      Array($vetCampo['grc_produto_conteudo_programatico']),
      ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


     */
}

// ARQUIVOS ASSOCIADOS
//____________________________________________________________________________

$vetParametros = Array(
    'codigo_frm' => 'arquivo_associado',
    'controle_fecha' => 'F',
);


$vetFrm[] = Frame('<span>' . numParte() . ' - ARQUIVOS ASSOCIADOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['codigo'] = CriaVetTabela('Código');
//$vetCampo['arquivo'] = CriaVetTabela('Arquivo');
$vetCampo['versao'] = CriaVetTabela('Versão');
$vetCampo['titulo'] = CriaVetTabela('Título');
$vetCampo['detalhe'] = CriaVetTabela('Detalhe');
$vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

//$vetCampo['gec_pp_descricao'] = CriaVetTabela('Produto Associado');

$titulo = 'Arquivo Associado';

$TabelaPrinc = "grc_produto_arquivo_associado";
$AliasPric = "grc_proaa";
$Entidade = "Arquivo Associado do Produto";
$Entidade_p = "Arquivos Associado do Produto";

$CampoPricPai = "idt_produto";

$orderby = "{$AliasPric}.codigo";

$sql = "select {$AliasPric}.* ";
//$sql  .= "       grc_pp.descricao as grc_pp_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
// $sql .= " inner join grc_produto grc_pp on grc_pp.idt = {$AliasPric}.idt_produto ";
//
$sql .= " where {$AliasPric}" . '.idt_produto = $vlID';
$sql .= " order by {$orderby}";

$vetCampo['grc_produto_arquivo_associado'] = objListarConf('grc_produto_arquivo_associado', 'idt', $vetCampo, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'arquivo_associado',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_produto_arquivo_associado']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

/*

  // METODOLOGIA
  //____________________________________________________________________________

  $vetParametros = Array(
  'codigo_frm' => 'metodologia',
  'controle_fecha' => 'F',
  );
  $vetFrm[] = Frame('<span>'.numParte().' - METODOLOGIAS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

  $vetCampo = Array();
  $vetCampo['grc_pp_descricao'] = CriaVetTabela('Metodologia');
  $vetCampo['codigo']    = CriaVetTabela('Código');
  $vetCampo['descricao'] = CriaVetTabela('Descrição');
  $vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

  $titulo = 'Metodologia';

  $TabelaPrinc      = "grc_produto_metodologia";
  $AliasPric        = "grc_prome";
  $Entidade         = "Metodologia do Produto";
  $Entidade_p       = "Metodologias do Produto";

  $CampoPricPai     = "idt_produto";

  $orderby = "{$AliasPric}.codigo";

  $sql  = "select {$AliasPric}.*, ";
  $sql  .= "       grc_pp.descricao as grc_pp_descricao ";
  $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
  $sql .= " inner join grc_produto_metodologia_n grc_pp on grc_pp.idt = {$AliasPric}.idt_produto_metodologia ";
  //
  $sql .= " where {$AliasPric}".'.idt_produto = $vlID';
  $sql .= " order by {$orderby}";

  $vetCampo['grc_produto_metodologia'] = objListarConf('grc_produto_metodologia', 'idt', $vetCampo, $sql, $titulo, false);

  $vetParametros = Array(
  'codigo_pai' => 'metodologia',
  'width' => '100%',
  );

  $vetFrm[] = Frame('', Array(
  Array($vetCampo['grc_produto_metodologia']),
  ),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

 */

if (produtocomposto != 'S') {
    // ENTREGAS DO PRODUTO
    $vetParametros = Array(
        'codigo_frm' => 'parteentrega',
        'controle_fecha' => 'F',
    );
    $vetFrm[] = Frame('<span>' . numParte() . ' - ENTREGA DO PRODUTO</span>', '', $class_frame_p . ' f_entrega', $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    $vetCampo = Array();

    $vetCampo = Array();
    $vetCampo['ordem'] = CriaVetTabela('Ordem');
    $vetCampo['codigo'] = CriaVetTabela('Código');
    $vetCampo['descricao'] = CriaVetTabela('Nome');
    $vetCampo['detalhe'] = CriaVetTabela('Descrição');
    $vetCampo['percentual'] = CriaVetTabela('Percentual', 'decimal');

    $TabelaPrinc = "grc_produto_entrega";
    $AliasPric = "grc_pe";
    $Entidade = "Entrega do Produto";
    $Entidade_p = "Entregas do Produto";
    $CampoPricPai = "idt_produto";

    $titulo = $Entidade_p;
    $orderby = "grc_pe.ordem ";
    $sql = "select {$AliasPric}.* ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " where {$AliasPric}" . '.idt_produto = $vlID';
    $sql .= " order by {$orderby}";
    $vetCampo['grc_produto_entrega'] = objListarConf('grc_produto_entrega', 'idt', $vetCampo, $sql, $titulo, false);

    $vetCampo['entrega_prazo_max'] = objInteiro('entrega_prazo_max', 'Prazo Máximo para execução do Serviço (dias)', false, 10);

    $vetParametros = Array(
        'codigo_pai' => 'parteentrega',
        'width' => '100%',
    );
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['entrega_prazo_max']),
        Array($vetCampo['grc_produto_entrega']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

    // Dimensionamento DO PRODUTO
    $vetParametros = Array(
        'codigo_frm' => 'partedimen',
        'controle_fecha' => 'F',
    );
    $vetFrm[] = Frame('<span>' . numParte() . ' - DIMENSIONAMENTO DO PRODUTO</span>', '', $class_frame_p . ' f_dimen', $class_titulo_p, $titulo_na_linha_p, $vetParametros);
    $vetCampo = Array();

    $vetCampo = Array();
    $vetCampo['codigo'] = CriaVetTabela('Código');
    $vetCampo['descricao'] = CriaVetTabela('Descrição');
    $vetCampo['grc_iu_descricao'] = CriaVetTabela('Unidade');
    $vetCampo['vl_unitario'] = CriaVetTabela('Custo Unitário', 'decimal');

    $TabelaPrinc = "grc_produto_dimensionamento";
    $AliasPric = "grc_pe";
    $Entidade = "Dimensionamento do Produto";
    $Entidade_p = "Dimensionamentos do Produto";
    $CampoPricPai = "idt_produto";

    $titulo = $Entidade_p;
    $sql = "select {$AliasPric}.*, grc_iu.descricao as grc_iu_descricao";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " left join grc_insumo_unidade grc_iu on grc_iu.idt = {$AliasPric}.idt_insumo_unidade ";
    $sql .= " where {$AliasPric}" . '.idt_produto = $vlID';
    $sql .= " order by codigo";
    $vetCampo['grc_produto_dimensionamento'] = objListarConf('grc_produto_dimensionamento', 'idt', $vetCampo, $sql, $titulo, false);

    $vetParametros = Array(
        'codigo_pai' => 'partedimen',
        'width' => '100%',
    );
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_produto_dimensionamento']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}

// PRODUTOS COM REPASSE
$vetParametros = Array(
    'codigo_frm' => 'parterepasse',
    'controle_fecha' => 'F',
);

//    $vetFrm[] = Frame('<span>'.numParte().' - PRODUTOS COM REPASSE</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
$vetFrm[] = Frame('<span>' . numParte() . ' - <span id="parterepasse_tit">CREDENCIADOS COM REPASSE</span></span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
$vetCampo = Array();

$vetCampo = Array();
$vetCampo['gec_e_descricao'] = CriaVetTabela('Credenciado');
$vetCampo['observacao'] = CriaVetTabela('Observação');

$TabelaPrinc = db_pir_gec . "gec_entidade_produto";
$AliasPric = "gec_epi";
$Entidade = "Produto com Repasse da Entidade";
$Entidade_p = "Produtos com Repasse da Entidade";
$CampoPricPai = "idt_entidade";

$titulo = $Entidade_p;

$orderby = "gec_e.descricao ";
$sql = "select {$AliasPric}.*, ";
$sql .= "        plu_usu.nome_completo as plu_usu_nome_completo, ";
$sql .= "        gec_e.descricao      as gec_e_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left  join " . db_pir_gec . "plu_usuario plu_usu on  plu_usu.id_usuario = {$AliasPric}.idt_responsavel";
$sql .= " left  join " . db_pir_gec . "gec_entidade gec_e  on  gec_e.idt = {$AliasPric}.idt_entidade";
$sql .= " where {$AliasPric}" . '.idt_produto = $vlID';
$sql .= " and   {$AliasPric}.repasse = " . aspa('S');
$sql .= " order by {$orderby}";
$vetCampo['gec_entidade_produto'] = objListarConf('gec_entidade_produto', 'idt', $vetCampo, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'parterepasse',
    'width' => '100%',
);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['gec_entidade_produto']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

// REALIZADORES
//____________________________________________________________________________

$vetParametros = Array(
    'codigo_frm' => 'realizador',
    'controle_fecha' => 'F',
);
$vetFrm[] = Frame('<span>' . numParte() . ' - GESTORES DO PRODUTO </span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Responsável');
$vetCampo['grc_pp_descricao'] = CriaVetTabela('Relação');
//$vetCampo['codigo']    = CriaVetTabela('Código');
//$vetCampo['descricao'] = CriaVetTabela('Descrição');
//$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
$vetCampo['detalhe'] = CriaVetTabela('Detalhe');

$titulo = 'GESTORES DO PRODUTO';

$TabelaPrinc = "grc_produto_realizador";
$AliasPric = "grc_prore";
$Entidade = "Realizador do Produto";
$Entidade_p = "Realizadores do Produto";

$CampoPricPai = "idt_produto";

$orderby = "{$AliasPric}.codigo";

$sql = "select {$AliasPric}.*, ";
$sql .= "       plu_usu.nome_completo as plu_usu_nome_completo, ";
$sql .= "       grc_pp.descricao as grc_pp_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_produto_realizador_relacao grc_pp on grc_pp.idt = {$AliasPric}.idt_relacao ";

$sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_usuario ";

$sql .= " where {$AliasPric}" . '.idt_produto = $vlID';
$sql .= " order by {$orderby}";

$vetCampo['grc_produto_realizador'] = objListarConf('grc_produto_realizador', 'idt', $vetCampo, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'realizador',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_produto_realizador']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

//////////////////////// Unidades Regionais
//
// DISPONIBILIZAÇÃO PARA AS UNIDADES REGIONAIS
//____________________________________________________________________________

$vetParametros = Array(
    'codigo_frm' => 'unidade_regional',
    'controle_fecha' => 'F',
);
$vetFrm[] = Frame('<span>' . numParte() . ' - DISPONIBILIZAÇÃO - UNIDADE REGIONAL</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['sca_os_descricao'] = CriaVetTabela('Unidade Regional');
$vetCampo['detalhe'] = CriaVetTabela('Detalhe');

$titulo = 'Unidade Regional';

$TabelaPrinc = "grc_produto_unidade_regional";
$AliasPric = "grc_procp";
$Entidade = "Unidade Regional";
$Entidade_p = "Unidades Regionais";
$CampoPricPai = "idt_produto";

$orderby = "sca_os.codigo";

$sql = "select {$AliasPric}.*, ";
$sql .= "       sca_os.descricao as sca_os_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join " . db_pir . "sca_organizacao_secao sca_os on sca_os.idt = {$AliasPric}.idt_unidade_regional ";

$sql .= " where {$AliasPric}" . '.idt_produto = $vlID';
$sql .= " order by {$orderby}";

$vetCampo['grc_produto_unidade_regional'] = objListarConf('grc_produto_unidade_regional', 'idt', $vetCampo, $sql, $titulo, false);
$vetCampo['todas_unidade_regional'] = objCmbVetor('todas_unidade_regional', 'Todas as Unidades Regionais', true, $vetSimNao);

$vetParametros = Array(
    'codigo_pai' => 'unidade_regional',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['todas_unidade_regional']),
    Array($vetCampo['grc_produto_unidade_regional']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

////////////////// PREVISÃO DE RECEITAS E DESPESAS
$vetParametros = Array(
    'codigo_frm' => 'Participantes',
    'controle_fecha' => 'F',
);

$vetFrm[] = Frame('<span>' . numParte() . ' - PREVISÃO - RESUMO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'Participantes',
    'width' => '100%',
);

$vetFrm[] = Frame('<span>Participantes - Previsão</span>', Array(
    Array($vetCampo_w['rtotal_minimo'], '', $vetCampo_w['ctotal_minimo'], '', $vetCampo_w['dif_minimo']),
    Array($vetCampo_w['rtotal_maximo'], '', $vetCampo_w['ctotal_maximo'], '', $vetCampo_w['dif_maximo']),
    Array($vetCampo_w['rmedia'], '', $vetCampo_w['cmedio'], '', $vetCampo_w['dif_medio']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'receitas',
    'controle_fecha' => 'F',
);

$vetFrm[] = Frame('<span>' . numParte() . ' - PREVISÃO - PLANILHA DE RECEITAS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

//
// RECEITAS
//____________________________________________________________________________
// Definição de campos formato full que serão editados na tela full

$vetCampo = Array();
//$vetCampo['grc_pp_classificacao'] = CriaVetTabela('Classificação');


$vetCampo['grc_iec_descricao'] = CriaVetTabela('Tipo de Receita');

$vetCampo['grc_pp_descricao'] = CriaVetTabela('Insumo');
//$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Complemento Descrição');

//$vetCampo['grc_pp_sinal']     = CriaVetTabela('Despesa?', 'descDominio', $vetSimNao );

$vetCampo['grc_iu_descricao'] = CriaVetTabela('Unid.');

$vetCampo['quantidade'] = CriaVetTabela('Quant.', 'decimal');
$vetCampo['custo_unitario_real'] = CriaVetTabela('Receita (R$)<br />Unitária', 'decimal');
$vetCampo['receita_total'] = CriaVetTabela('Receita (R$)<br />Total', 'decimal');
$vetCampo['por_participante'] = CriaVetTabela('Por <br />parti.?', 'descDominio', $vetSimNao);
$vetCampo['rtotal_minimo'] = CriaVetTabela('Receita (R$)<br />Mínima', 'decimal');
$vetCampo['rtotal_maximo'] = CriaVetTabela('Receita (R$)<br />Máxima', 'decimal');
$vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

// Parametros da tela full conforme padrão

$titulo = 'Receita Associada';

$TabelaPrinc = "grc_produto_insumo";
$AliasPric = "grc_proins";
$Entidade = "Insumo Associado ao Produto";
$Entidade_p = "Insumos Associado ao Produto";

$CampoPricPai = "idt_produto";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "grc_iec.descricao, grc_pp.classificacao";

$sql = "select {$AliasPric}.*, ";
$sql .= "       grc_pp.classificacao as grc_pp_classificacao, ";
$sql .= "       grc_pp.descricao as grc_pp_descricao, ";
$sql .= "       grc_iec.descricao as grc_iec_descricao, ";
$sql .= "       grc_pp.sinal as grc_pp_sinal, ";
$sql .= "       grc_iu.descricao as grc_iu_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_insumo grc_pp on grc_pp.idt = {$AliasPric}.idt_insumo ";
$sql .= " left join grc_insumo_elemento_custo grc_iec on grc_iec.idt = grc_pp.idt_insumo_elemento_custo ";
$sql .= " inner join grc_insumo_unidade grc_iu on grc_iu.idt = {$AliasPric}.idt_insumo_unidade ";
$sql .= " where {$AliasPric}" . '.idt_produto = $vlID';
$sql .= " and grc_pp.sinal = " . aspa('N'); // despesa
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full
$vetCampo['grc_produto_receita'] = objListarConf('grc_produto_receita', 'idt', $vetCampo, $sql, $titulo, false);

// Fotmata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'receitas',
    'width' => '100%',
);

//$vetFrm[] = Frame('<span>Receita - Previsão</span>', Array(
//      Array($vetCampo_y['gratuito']),
//
//),$class_frame,$class_titulo,$titulo_na_linha, $vetParametros);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_produto_receita']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

// INSUMOS
//____________________________________________________________________________

if (produtocomposto != 'S') {

    $vetParametros = Array(
        'codigo_frm' => 'insumo',
        'controle_fecha' => 'F',
    );

    $vetFrm[] = Frame('<span>' . numParte() . ' - PREVISÃO - PLANILHA DE DESPESAS (INSUMOS)</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

    $vetCampo = Array();
    $vetCampo['grc_pp_classificacao'] = CriaVetTabela('Código');
//$vetCampo['grc_iec_descricao'] = CriaVetTabela('Tipo Custo');
    $vetCampo['sca_os_descricao'] = CriaVetTabela('Unidade de Suporte');
    $vetCampo['grc_pp_descricao'] = CriaVetTabela('Insumo');
//$vetCampo['codigo']    = CriaVetTabela('Código');
    $vetCampo['descricao'] = CriaVetTabela('Complemento Descrição');
//$vetCampo['grc_pp_sinal']     = CriaVetTabela('Despesa?', 'descDominio', $vetSimNao );
    $vetCampo['grc_iu_descricao'] = CriaVetTabela('Unid.');
    $vetCampo['quantidade'] = CriaVetTabela('Quant.', 'decimal');
    $vetCampo['custo_unitario_real'] = CriaVetTabela('Custo (R$)<br />Unitário', 'decimal');
    $vetCampo['custo_total'] = CriaVetTabela('Custo (R$)<br />Total', 'decimal');
    $vetCampo['por_participante'] = CriaVetTabela('Por <br />parti.?', 'descDominio', $vetSimNao);
    $vetCampo['ctotal_minimo'] = CriaVetTabela('Custo (R$)<br />Mínimo', 'decimal');
    $vetCampo['ctotal_maximo'] = CriaVetTabela('Custo (R$)<br />Máximo', 'decimal');
    $vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

// Parametros da tela full conforme padrão

    $titulo = 'Insumo Associado';

    $TabelaPrinc = "grc_produto_insumo";
    $AliasPric = "grc_proins";
    $Entidade = "Insumo Associado ao Produto";
    $Entidade_p = "Insumos Associado ao Produto";

    $CampoPricPai = "idt_produto";

// Select para obter campos da tabela que serão utilizados no full

    $orderby = "grc_iec.descricao, grc_pp.classificacao";

    $sql = "select {$AliasPric}.*, ";
    $sql .= "       sca_os.descricao as sca_os_descricao, ";
    $sql .= "       grc_pp.classificacao as grc_pp_classificacao, ";
    $sql .= "       grc_pp.descricao as grc_pp_descricao, ";
    $sql .= "       grc_iec.descricao as grc_iec_descricao, ";
    $sql .= "       grc_pp.sinal as grc_pp_sinal, ";
    $sql .= "       grc_iu.descricao as grc_iu_descricao ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join grc_insumo grc_pp on grc_pp.idt = {$AliasPric}.idt_insumo ";
    $sql .= " left join grc_insumo_elemento_custo grc_iec on grc_iec.idt = grc_pp.idt_insumo_elemento_custo ";
    $sql .= " left join " . db_pir . "sca_organizacao_secao sca_os on sca_os.idt = grc_proins.idt_area_suporte ";
    $sql .= " inner join grc_insumo_unidade grc_iu on grc_iu.idt = {$AliasPric}.idt_insumo_unidade ";
    $sql .= " where {$AliasPric}" . '.idt_produto = $vlID';
    $sql .= " and grc_pp.sinal = " . aspa('S'); // despesa
    $sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full

    $vetParametrosLC = Array(
        'func_trata_row' => bloqueia_row_grc_produto_insumo,
        'barra_ap_row' => true,
    );
    $vetCampo['grc_produto_insumo'] = objListarConf('grc_produto_insumo', 'idt', $vetCampo, $sql, $titulo, false, $vetParametrosLC);

// Fotmata lay_out de saida da tela full

    $vetParametros = Array(
        'codigo_pai' => 'insumo',
        'width' => '100%',
    );

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_produto_insumo']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
}

/*
  $vetParametros = Array(
  'codigo_frm' => 'credenciado',
  'controle_fecha' => 'F',
  );
  $vetFrm[] = Frame('<span>'.numParte().' - CREDENCIADO </span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

  $vetParametros = Array(
  'codigo_pai' => 'credenciado',
  'width' => '100%',
  );

  $vetCampo['necessita_credenciado'] = objCmbVetor('necessita_credenciado', 'Necessita Credenciado?', false, $vetSimNao, '');

  $vetFrm[] = Frame('', Array(
  Array($vetCampo['necessita_credenciado']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

 */


// VERSÃO
//____________________________________________________________________________

$vetParametros = Array(
    'codigo_frm' => 'versao',
    'controle_fecha' => 'F',
);
$vetFrm[] = Frame('<span>' . numParte() . ' - VERSÕES </span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['codigo'] = CriaVetTabela('Versão');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);
//$vetCampo['gec_pp_descricao'] = CriaVetTabela('Produto Associado');

$titulo = 'Versão';

$TabelaPrinc = "grc_produto_versao";
$AliasPric = "grc_prooc";
$Entidade = "Versão do Produto";
$Entidade_p = "Versões do Produto";

$CampoPricPai = "idt_produto";

$orderby = "{$AliasPric}.codigo";

$sql = "select {$AliasPric}.*, ";
$sql .= "       grc_pp.descricao as grc_pp_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_produto grc_pp on grc_pp.idt = {$AliasPric}.idt_produto ";
//
$sql .= " where {$AliasPric}" . '.idt_produto = $vlID';
$sql .= " order by {$orderby}";

$vetCampo['grc_produto_versao'] = objListarConf('grc_produto_versao', 'idt', $vetCampo, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'versao',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_produto_versao']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

// OCORRENCIAS
//____________________________________________________________________________

$vetParametros = Array(
    'codigo_frm' => 'ocorrencia',
    'controle_fecha' => 'F',
);
$vetFrm[] = Frame('<span>' . numParte() . ' - OCORRENCIAS </span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
//$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['data'] = CriaVetTabela('Data', 'data');
$vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Responsável');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
//$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
$vetCampo['detalhe'] = CriaVetTabela('Detalhe');

$titulo = 'Ocorrencia';

$TabelaPrinc = "grc_produto_ocorrencia";
$AliasPric = "grc_prooc";
$Entidade = "Ocorrencia do Produto";
$Entidade_p = "Ocorrencias do Produto";

$CampoPricPai = "idt_produto";

$orderby = "{$AliasPric}.codigo";

$sql = "select {$AliasPric}.*, ";
$sql .= "       plu_usu.nome_completo as plu_usu_nome_completo ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_produto grc_pp on grc_pp.idt = {$AliasPric}.idt_produto ";
$sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_responsavel ";
$sql .= " where {$AliasPric}" . '.idt_produto = $vlID';
$sql .= " order by {$orderby}";

$vetCampo['grc_produto_ocorrencia'] = objListarConf('grc_produto_ocorrencia', 'idt', $vetCampo, $sql, $titulo, false);

$vetParametros = Array(
    'codigo_pai' => 'ocorrencia',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_produto_ocorrencia']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

//Galeria
$vetParametros = Array(
    'codigo_frm' => 'galeria',
    'controle_fecha' => 'F',
);
$vetFrm[] = Frame('<span>' . numParte() . ' - GALERIA </span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'galeria',
    'width' => '100%',
);

$vetCampoLC = Array();
$vetCampoLC['tipo'] = CriaVetTabela('Tipo');
$vetCampoLC['descricao'] = CriaVetTabela('Descrição');
$vetCampoLC['conteudo'] = CriaVetTabela('Conteudo', 'func_trata_dado', ftd_grc_produto_galeria);

$titulo = 'Galeria';

$sql = '';
$sql .= ' select pg.*, tg.descricao as tipo';
$sql .= ' from grc_produto_galeria pg';
$sql .= ' inner join grc_tipo_galeria tg on tg.idt = pg.idt_tipo_galeria';
$sql .= ' where pg.idt_produto = $vlID';
$sql .= ' order by tg.descricao, pg.descricao';

$vetCampo['grc_produto_galeria'] = objListarConf('grc_produto_galeria', 'idt', $vetCampoLC, $sql, $titulo, false);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_produto_galeria']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
?>

<script>

    var coloinativo = '#FFFFD7';
    var produtocomposto = '<?php echo produtocomposto; ?>';

    function TipoOrdemProgramaClass() {
<?php
ForEach ($vetTipoOrdemPrograma as $idx => $valor) {
    echo "this.idt_{$idx} = '" . str_replace("'", "\'", $valor) . "';\n";
}
?>
    }

    var vetTipoOrdemPrograma = new TipoOrdemProgramaClass();
    var carregaProgramaExecuta = true;

    $(document).ready(function () {
<?php
ForEach ($vetTipoOrdemPrograma as $idx => $valor) {
    echo "$('#idt_programa option[value={$idx}]').addClass('option" . str_replace("'", "\'", $valor) . "');\n";
}
?>

        $("#idt_programa").change(function () {
            if (carregaProgramaExecuta) {
                carregaPrograma('idt_programa', 'idt_programa_grc', true);
            }
        });

        $("#idt_programa_grc").change(function () {
            if (carregaProgramaExecuta) {
                carregaPrograma('idt_programa_grc', 'idt_programa', true);
            }
        });

        $('#insumo_horas_comp').change(function () {
            processando();

            $.ajax({
                type: 'POST',
                url: ajax_sistema + '?tipo=SincronizaProfissional',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt: '<?php echo $_GET['id']; ?>',
                    valor: $(this).val()
                },
                success: function (response) {
                    btFechaCTC($('#grc_produto_insumo').data('session_cod'));

                    if (response != '') {
                        $('#dialog-processando').remove();
                        alert(url_decode(response));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#dialog-processando').remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $('#dialog-processando').remove();
        });

        $('#carga_horaria_ini').blur(function () {
            var objIni = $('#carga_horaria_ini');
            var objFim = $('#carga_horaria_fim');

            if (objFim.val() == '') {
                objFim.val(objIni.val());
            }
            return validaCargaHoraria(objIni, objFim);
        });

        $('#carga_horaria_2_ini').blur(function () {
            var objIni = $('#carga_horaria_2_ini');
            var objFim = $('#carga_horaria_2_fim');

            if (objFim.val() == '') {
                objFim.val(objIni.val());
            }
            return validaCargaHoraria(objIni, objFim);
        });

        $('#carga_horaria_fim').blur(function () {
            var objIni = $('#carga_horaria_ini');
            var objFim = $('#carga_horaria_fim');
            return validaCargaHoraria(objIni, objFim);
        });

        $('#carga_horaria_2_fim').blur(function () {
            var objIni = $('#carga_horaria_2_ini');
            var objFim = $('#carga_horaria_2_fim');
            return validaCargaHoraria(objIni, objFim);
        });

        $('#idt_instrumento, #idt_programa').change(function () {
            var campo = $('#tipo_calculo, #forcar_carga_horarria');
            var obr = $('#tipo_calculo_desc, #forcar_carga_horarria_desc');

            if ($('#idt_instrumento').val() == '39' && vetTipoOrdemPrograma['idt_' + $('#idt_programa').val()] == 'GC') {
                func_AtivaDesativa('s', ",n".split(","), campo, obr, "s".split(","), "S", "S");
            } else {
                func_AtivaDesativa('n', ",n".split(","), campo, obr, "s".split(","), "S", "S");
            }

            var campo = $('#tempo_medio');
            var obr = $('#_desc');

            if ($('#idt_instrumento').val() == '39' && vetTipoOrdemPrograma['idt_' + $('#idt_programa').val()] == 'SG') {
                func_AtivaDesativa('s', ",n".split(","), campo, obr, "s".split(","), "S", "S");
            } else {
                func_AtivaDesativa('n', ",n".split(","), campo, obr, "s".split(","), "S", "S");
            }

            campo = $('#vl_determinado, #vl_teto, #idt_sgtec_tipo_servico');
            obr = $('#vl_determinado_desc, #vl_teto_desc, #idt_sgtec_tipo_servico_desc');

            if (vetTipoOrdemPrograma['idt_' + $('#idt_programa').val()] == 'SG') {
                DescPer('idt_programa', 'Edital de Credenciamento');
                DescPer('idt_programa_grc', 'Produto Nacional');

                $("#idt_grupo_desc label").hide();
                $("#idt_grupo").val('').hide();
                $('.frm_carga_horaria').data('bt_controle_fecha_estado', 'F');
                $("#parterepasse_tit").html('PROFISSIONAIS');

                func_AtivaDesativa('s', ",n".split(","), campo, obr, "s".split(","), "S", "S");
                $("#entrega_prazo_max_desc").addClass("Tit_Campo_Obr").removeClass("Tit_Campo");

                $('fieldset.f_entrega, fieldset.f_dimen').show();

                $('fieldset.f_produto_profissional').hide();

                if ($('fieldset.produto_profissional').is(":visible")) {
                    $('#produto_profissional').click();
                }
            } else {
                DescPer('idt_programa', 'Programa Credenciado');
                DescPer('idt_programa_grc', 'Programa');

                $("#idt_grupo_desc label").show();
                $("#idt_grupo").show();
                $('.frm_carga_horaria').data('bt_controle_fecha_estado', 'A');
                $("#parterepasse_tit").html('CREDENCIADOS COM REPASSE');

                func_AtivaDesativa('n', ",n".split(","), campo, obr, "s".split(","), "S", "S");
                $("#entrega_prazo_max_desc").addClass("Tit_Campo").removeClass("Tit_Campo_Obr");

                $('fieldset.f_entrega, fieldset.f_dimen').hide();

                if ($('fieldset.parteentrega').is(":visible")) {
                    $('#parteentrega').click();
                }

                if ($('fieldset.partedimen').is(":visible")) {
                    $('#partedimen').click();
                }

                $('fieldset.f_produto_profissional').show();
            }

            if ($('#idt_instrumento').val() == '41' || $('#idt_instrumento').val() == '45') {
                $("#idt_produto_tipo, #idt_produto_tipo_desc label").hide();
            } else {
                $("#idt_produto_tipo, #idt_produto_tipo_desc label").show();
            }

            bt_controle_fecha_estado();

            TelaHeight();
        });

        $('#idt_secao_autora').change(function () {
            if ($(this).val() == '64') { //UNIDADE DE ACESSO A INVOVAÇÃO E TECNOLOGIA (UAIT)
                $('#idt_programa option.optionSG').show();
            } else {
                $('#idt_programa option.optionSG').hide();

                var opt = $('#idt_programa option:selected');

                if (!opt.is(':visible')) {
                    opt.removeAttr('selected');
                }
            }

            $('#idt_programa').change();
        });

        //   proprio_s();
        autora_propria();
        //funcaoFechaCTC_grc_produto_area_conhecimento();
        //funcaoFechaCTC_grc_produto_unidade_regional();
        //funcaoFechaCTC_grc_produto_insumo();

        //Consulta Codigo SIAC
        if (!(acao == 'con' || acao == 'exc' || acao_alt_con == 'S')) {
            var bt = $('<img border="0" style="margin-left: 3px; cursor: pointer; vertical-align: middle;" src="imagens/bt_pesquisa.png" title="Consultar código SIAC">');

            bt.click(function () {
                if ($('#codigo_siac').val() == '') {
                    alert('Favor informar o Código do SIAC!');
                    $('#codigo_siac').focus();
                    return false;
                }

                processando();

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: ajax_sistema + '?tipo=conWSProdutoSIAC',
                    data: {
                        cas: conteudo_abrir_sistema,
                        cod: $('#codigo_siac').val()
                    },
                    success: function (response) {
                        var obj = $('#situacao_siac, #descricao_siac, #codigo_classificacao_siac, #idt_instrumento, #idt_instrumento_siac, #idt_foco_tematico_siac, #idt_autor_siac, #idt_responsavel_siac, #minimo_pagantes_siac, #maximo_participantes_siac, #frequencia_siac, #qtdias_reservados_siac, #idt_produto_tipo');

                        obj.each(function () {
                            $(this).val(url_decode(response[$(this).attr('id')]));
                        });

                        if (response.erro != '') {
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

                $('#idt_foco_tematico').val($('#idt_foco_tematico_siac').val());
                $('#ativo').val($('#situacao_siac').val());
                $('#idt_instrumento').change();

                $("#dialog-processando").remove();
            });

            $('#codigo_siac_obj').append(bt);
        }
        //
        // campos do SIAC
        //
        //var colo = '#FFFF80';


        //$('#codigo_siac').css('background', coloinativo);
        //$('#codigo_siac').attr('readonly', 'true');
        $('#repasse').css('background', coloinativo);
        $('#repasse').attr('disabled', 'disabled');
        $('#descricao_siac').css('background', coloinativo);
        $('#descricao_siac').attr('readonly', 'true');
        $('#idt_instrumento_siac').css('background', coloinativo);
        $('#idt_instrumento_siac').attr('disabled', 'disabled');
        $('#idt_foco_tematico_siac').css('background', coloinativo);
        $('#idt_foco_tematico_siac').attr('disabled', 'disabled');
        $('#idt_autor_siac').css('background', coloinativo);
        $('#idt_autor_siac').attr('disabled', 'disabled');
        $('#idt_responsavel_siac').css('background', coloinativo);
        $('#idt_responsavel_siac').attr('disabled', 'disabled');
        $('#frequencia_siac').css('background', coloinativo);
        $('#frequencia_siac').attr('readonly', 'true');
        $('#qtdias_reservados_siac').css('background', coloinativo);
        $('#qtdias_reservados_siac').attr('readonly', 'true');
        $('#maximo_participantes_siac').css('background', coloinativo);
        $('#maximo_participantes_siac').attr('readonly', 'true');
        $('#minimo_pagantes_siac').css('background', coloinativo);
        $('#minimo_pagantes_siac').attr('readonly', 'true');
        $('#situacao_siac').css('background', coloinativo);
        $('#situacao_siac').attr('disabled', 'disabled');
        $('#idt_produto_familia').css('background', coloinativo).prop('disabled', true);
        $('#idt_foco_tematico').css('background', coloinativo).prop('disabled', true);
        $('#ativo').css('background', coloinativo).prop('disabled', true);
        $('#idt_instrumento').css('background', coloinativo).prop('disabled', true);
    });

    function carregaPrograma(campo_origem, campo_destino, roda_vazio) {
        var origem = $('#' + campo_origem);
        var destino = $('#' + campo_destino);
        var vazio = origem.val() == '' && destino.val() == '';

        if (origem.val() != '' || vazio) {
            var idt_programa = $("#idt_programa").val();
            var idt_programa_grc = $("#idt_programa_grc").val();

            destino.empty();

            var position = {'z-index': '6000', 'position': 'absolute', 'width': '16px'};
            $.extend(position, destino.offset());
            position.top = position.top + 3;
            position.left = position.left + 3;

            $("<div class='cascade-loading'>&nbsp;</div>").appendTo("body").css(position);
            destino.disabled = true;

            $.ajax({
                type: 'POST',
                url: ajax_sistema + '?tipo=cmb_' + campo_destino,
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_programa: idt_programa,
                    idt_programa_grc: idt_programa_grc
                },
                success: function (str) {
                    destino.html(url_decode(str));

                    if (campo_destino == 'idt_programa') {
                        destino.val(idt_programa);
                    } else {
                        destino.val(idt_programa_grc);
                    }

                    carregaProgramaExecuta = false;
                    destino.change();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $(".cascade-loading").remove();
            carregaProgramaExecuta = true;
        }

        if (roda_vazio && vazio) {
            carregaPrograma(campo_destino, campo_origem, false);
        }
    }

    function validaCargaHoraria(objIni, objFim) {
        if (objFim.val() == '') {
            objFim.val(objIni.val());
        }

        if (objFim.val() == '') {
            return true;
        }

        if (objIni.val() == '') {
            alert('Favor informar o valor mínimo!');
            objIni.focus();
            return false;
        }

        var ini = str2float(objIni.val());
        var fim = str2float(objFim.val());

        if (isNaN(ini)) {
            alert('Favor informar um valor válido para o mínimo!');
            objIni.focus();
            return false;
        }

        if (isNaN(fim)) {
            alert('Favor informar um valor válido para o máximo!');
            objFim.focus();
            return false;
        }

        if (fim < ini) {
            alert('O valor máximo não pode ser menor que o valor mínimo!');
            objFim.val('');
            objFim.focus();
            return false;
        }

        return true;
    }

    function grc_produto_dep() {
        var ok = true;

        /*
         if ($('#idt_produto_especie').val() == 2) {
         var idt_instrumento = $('#idt_instrumento').val();
         
         if (!(idt_instrumento == 39 || idt_instrumento == 40 || idt_instrumento == 46 || idt_instrumento == 47 || idt_instrumento == 49)) {
         alert('O instrumento selecionado não é permitido para Tipo de Produto: Subproduto!');
         return false;
         }
         }
         */

        if ($('#vl_teto').length > 0) {
            var produto_limite_teto = str2float('<?php echo $vetConf['produto_limite_teto']; ?>');

            if (isNaN(produto_limite_teto)) {
                produto_limite_teto = 0;
            }

            if ($('#vl_teto').val() != '' && produto_limite_teto > 0) {
                if (str2float($('#vl_teto').val()) > produto_limite_teto) {
                    alert('O Valor Teto do Produto não pode ser maior que o limite do sistema que é ' + float2str(produto_limite_teto) + '!');
                    $('#vl_teto').val('');
                    $('#vl_teto').focus();
                    return false;
                }
            }
        }

        //Validas os Dados do SG
        if (vetTipoOrdemPrograma['idt_' + $('#idt_programa').val()] == 'SG') {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_produto_dep_sg',
                data: {
                    cas: conteudo_abrir_sistema,
                    vl_determinado: $('#vl_determinado').val(),
                    idt: '<?php echo $_GET['id']; ?>'
                },
                success: function (response) {
                    if (response.erro != '') {
                        ok = false;
                        $("#dialog-processando").remove();
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    ok = false;
                    $("#dialog-processando").remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $("#dialog-processando").remove();

            if (ok === false) {
                return false;
            }
        }

        if (produtocomposto == 'S') {
            var pc_consultoria = 'N';
            var pc_curso = 'N';
            var pc_oficina = 'N';
            var pc_palestra = 'N';
            var pc_seminario = 'N';

            if ($('#pc_consultoria').prop('checked')) {
                pc_consultoria = 'S';
            }

            if ($('#pc_curso').prop('checked')) {
                pc_curso = 'S';
            }

            if ($('#pc_oficina').prop('checked')) {
                pc_oficina = 'S';
            }

            if ($('#pc_palestra').prop('checked')) {
                pc_palestra = 'S';
            }

            if ($('#pc_seminario').prop('checked')) {
                pc_seminario = 'S';
            }

            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_produto_dep_composto',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt: '<?php echo $_GET['id']; ?>',
                    idt_programa_grc: $('#idt_programa_grc').val(),
                    idt_programa: $('#idt_programa').val(),
                    pc_consultoria: pc_consultoria,
                    pc_curso: pc_curso,
                    pc_oficina: pc_oficina,
                    pc_palestra: pc_palestra,
                    pc_seminario: pc_seminario
                },
                success: function (response) {
                    if (response.erro != '') {
                        ok = false;
                        $("#dialog-processando").remove();
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    ok = false;
                    $("#dialog-processando").remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $("#dialog-processando").remove();

            return ok;
        } else {
            var objIni = $('#carga_horaria_ini');
            var objFim = $('#carga_horaria_fim');
            return validaCargaHoraria(objIni, objFim);
        }
    }

    function parListarConf_grc_produto_area_conhecimento() {
        var par = '';

        par += '&idt_programa=' + $('#idt_programa').val();

        return par;
    }

    function funcaoFechaCTC_grc_produto_area_conhecimento() {
        /*
         var title = 'Multiplo cadastramento de Registro';
         
         var bt = $('td#grc_produto_area_conhecimento_desc td#Titulo_radio > a:first').clone();
         
         if (bt.length > 0) {
         var onclick = bt.attr('onclick').replace(new RegExp(', "inc", 0, ', "g"), ', "inc", -1, ');
         
         bt.attr('onclick', onclick);
         bt.attr('alt', title);
         bt.attr('title', title);
         bt.find('img').attr('src', 'imagens/bt_facil.png').attr('title', title);
         
         $('#grc_produto_area_conhecimento_desc td#Titulo_radio').append(bt);
         }
         */
    }

    function funcaoFechaCTC_grc_produto_unidade_regional() {
        /*
         var title = 'Multiplo cadastramento de Registro';
         
         var bt = $('td#grc_produto_unidade_regional_desc td#Titulo_radio > a:first').clone();
         
         if (bt.length > 0) {
         var onclick = bt.attr('onclick').replace(new RegExp(', "inc", 0, ', "g"), ', "inc", -1, ');
         
         bt.attr('onclick', onclick);
         bt.attr('alt', title);
         bt.attr('title', title);
         bt.find('img').attr('src', 'imagens/bt_facil.png').attr('title', title);
         
         $('#grc_produto_unidade_regional_desc td#Titulo_radio').append(bt);
         }
         */
    }

    function parListarConf_grc_produto_insumo() {
        var par = '';

        par += '&participante_minimo=' + $('#participante_minimo').val();
        par += '&participante_maximo=' + $('#participante_maximo').val();

        return par;
    }

    function funcaoFechaCTC_grc_produto_insumo() {
        /*
         var title = 'Multiplo cadastramento de Registro';
         
         var bt = $('td#grc_produto_insumo_desc td#Titulo_radio > a:first').clone();
         
         if (bt.length > 0) {
         var onclick = bt.attr('onclick').replace(new RegExp(', "inc", 0, ', "g"), ', "inc", -1, ');
         
         bt.attr('onclick', onclick);
         bt.attr('alt', title);
         bt.attr('title', title);
         bt.find('img').attr('src', 'imagens/bt_facil.png').attr('title', title);
         
         $('#grc_produto_insumo_desc td#Titulo_radio').append(bt);
         }
         */
    }

    function autora_propria() {

        var idt_produto_abrangencia = 0;
        var id = 'idt_produto_abrangencia';
        obj = document.getElementById(id);

        if (obj != null) {
            idt_produto_abrangencia = obj.value;
        }

        if (idt_produto_abrangencia <= 0) {
            return false;
        }

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax2.php?tipo=PegaAutora',
            data: {
                cas: conteudo_abrir_sistema,
                idt_produto_abrangencia: idt_produto_abrangencia
            },
            success: function (str) {
                if (str.erro != '') {
                    alert(url_decode(str.erro));
                } else {
                    var proprio = url_decode(str.proprio);

                    if (proprio == 'T') {
                        $('#idt_entidade_autora_desc').css('visibility', 'visible');
                        $('#idt_entidade_autora_obj').css('visibility', 'visible');
                    } else {
                        $('#idt_entidade_autora_desc').css('visibility', 'hidden');
                        $('#idt_entidade_autora_obj').css('visibility', 'hidden');
                        ListarCmbLimpa('idt_entidade_autora');
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });
    }

    function proprio_s()
    {
        var proprio = "";
        objd = document.getElementById('proprio');
        if (objd != null)
        {
            proprio = objd.value;
            //     alert(' proprio = '+proprio);
            if (proprio != 'S')
            {
                objd = document.getElementById('idt_secao_autora');
                if (objd != null)
                {
                    $(objd).css('background', coloinativo);
                    $(objd).attr('disabled', 'disabled');
                    objd.value = "";
                }
                // ativa entidade

                objd = document.getElementById('idt_entidade_autora');
                if (objd != null)
                {
                    var ele = ".ListarCmb";
                    $(ele).css('background', '#FFFFFF');
                    $('.bt_acao').css('visibility', 'visible');
                }


            } else
            {

                objd = document.getElementById('idt_secao_autora');
                if (objd != null)
                {
                    $(objd).css('background', '#FFFFFF');
                    $(objd).removeAttr("disabled");
                }



                objd = document.getElementById('idt_entidade_autora');
                if (objd != null)
                {
                    objd.value = "";
                    var ele = ".ListarCmb";
                    $(ele).css('background', coloinativo);
                    ListarCmbLimpa('idt_entidade_autora');
                    $('.bt_acao').css('visibility', 'hidden');
                }

            }
        }

        return false;
    }

    function funcaoFechaCTC_grc_produto_profissional() {
        btFechaCTC($('#grc_produto_insumo').data('session_cod'));
    }

    function parListarConf_grc_produto_produto() {
        var par = '';

        par += '&produtocomposto=' + produtocomposto;

        if (produtocomposto != 'S') {
            return par;
        }

        var ok = false;

        if ($('#idt_programa_grc').val() == '') {
            alert('Favor informar o Programa!');
            $('#idt_programa_grc').focus();
            return false;
        }

        if ($('#idt_programa').val() == '') {
            alert('Favor informar o Programa Credenciado!');
            $('#idt_programa').focus();
            return false;
        }

        par += '&idt_programa_grc=' + $('#idt_programa_grc').val();
        par += '&idt_programa=' + $('#idt_programa').val();

        if ($('#pc_consultoria').prop('checked')) {
            ok = true;
            par += '&pc_consultoria=S';
        } else {
            par += '&pc_consultoria=N';
        }

        if ($('#pc_curso').prop('checked')) {
            ok = true;
            par += '&pc_curso=S';
        } else {
            par += '&pc_curso=N';
        }

        if ($('#pc_oficina').prop('checked')) {
            ok = true;
            par += '&pc_oficina=S';
        } else {
            par += '&pc_oficina=N';
        }

        if ($('#pc_palestra').prop('checked')) {
            ok = true;
            par += '&pc_palestra=S';
        } else {
            par += '&pc_palestra=N';
        }

        if ($('#pc_seminario').prop('checked')) {
            ok = true;
            par += '&pc_seminario=S';
        } else {
            par += '&pc_seminario=N';
        }

        if (ok) {
            return par;
        } else {
            alert('Favor informar o Instrumento(s) no Tipo do Produto!');
            return false;
        }
    }

    function bt_controle_fecha_estado() {
        if ($('.frm_carga_horaria').data('bt_controle_fecha_estado') == 'F') {
            $('.frm_carga_horaria').hide();
        } else if ($('.frm_carga_horaria').data('bt_controle_fecha_estado') == 'A') {
            if ($('fieldset.parte01_02:first').is(":visible")) {
                $(".frm_carga_horaria").show();
            }
        }
    }

    function objLista_idt_publico_alvo_outro_dep(funcao, lst1, lst2) {
        var cmb = document.frm.idt_publico_alvo;
        var vl = '';
        var opt = null;

        for (i = cmb.length - 1; i >= 0; i--) {
            if (cmb.options[i].selected && vl == '') {
                vl = cmb.options[i].value;
            }

            cmb.options[i] = null;
        }

        cmb.options[cmb.length] = new Option('', '');

        for (i = 0; i < lst2.length; i++) {
            opt = new Option(lst2.options[i].text, lst2.options[i].value.substr(1));
            
            if (opt.value == vl) {
                opt.selected = true;
            }
            
            cmb.options[cmb.length] = opt;
        }
    }
</script>