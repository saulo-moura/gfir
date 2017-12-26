<style>
    fieldset.class_frame {
        background:#ECF0F1;
        border:1px solid #14ADCC;
    }

    div.class_titulo {
        background: #ABBBBF;
        border    : 1px solid #14ADCC;
        color     : #FFFFFF;
        text-align: left;
    }

    div.class_titulo span {
        padding-left:10px;
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
        text-align: left;
        background: #C4C9CD;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
    }

    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }

    div.class_titulo_p_barra {
        text-align: left;
        background: #C4C9CD;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        font-weight: bold;
        line-height: 12px;
        margin: 0;
        padding: 3px;
        padding-left: 10px;
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

    Select {
        border:0px;
        min-height: 25px;
        padding-left: 3px;
        padding-right: 3px;
        padding-top: 5px;
    }

    .TextoFixo {
        font-size:12px;
        text-align:left;
        border:0px;
        background:#ECF0F1;
        font-weight:normal;
        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        color:#5C6D7E;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;
    }

    .Texto {
        font-size:12px;
        text-align:left;
        border:0px;
        background:#ECF0F1;
        font-weight:normal;
        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        color:#5C6D7E;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;
    }

    td.Titulo {
        color:#666666;
    }

    .campo_disabled {
        background-color: #FFFFD7;
    }

    #grc_entidade_pessoa_tema_interesse_desc td[data-campo],
    #grc_entidade_pessoa_produto_interesse_desc td[data-campo],
    #grc_entidade_pessoa_arquivo_interesse_desc td[data-campo] {
        width: 200px;
        height: 28px;
    }

    .fildset div.frm0 {
        margin:0px;
    }

    fieldset.class_frame_p_esp {
        border:none;
        border-top:1px solid #14ADCC;
        padding:0;
        margin:0;
        margin-bottom:5px;
    }

    fieldset.class_frame_p_esp > legend{
        font-weight:normal;
        padding:0;
        padding-right:5px;
        margin:0;
    }

    div.class_titulo_p_esp {
        background: #ABBBBF;
        border    : 1px solid #14ADCC;
        color     : #FFFFFF;
        text-align: left;
        padding:0;
        margin:0;
    }

    div.class_titulo_p_esp span {
        padding-left:10px;
    }

    fieldset.class_frame_r {
        border:none;
        border-top:2px solid #14ADCC;
        padding:0;
        margin:0;
        margin-bottom:5px;
        padding-left: 53.3em;
    }

    fieldset.class_frame_r > legend{
        font-weight:normal;
        padding:0;
        padding-left:5px;
        text-align: right;
        margin:0;
    }

    div.class_titulo_r {
        background: #ABBBBF;
        border    : 1px solid #14ADCC;
        text-align: right;
        padding:0;
        margin:0;
    }

    div.class_titulo_r span {
        padding-left:10px;
    }

    #receber_informacao_desc {
        height: 22px;
        width: 168px;
    }
</style>
<?php
$class_frame_p_esp = 'class_frame_p_esp';
$class_titulo_p_esp = 'class_titulo_p_esp';

$class_frame_r = 'class_frame_r';
$class_titulo_r = 'class_titulo_r';

//p($_GET);
//p($_REQUEST);
$agenda = "";
if ($_GET['deondeveio'] == 'Agenda') {
    $agenda = "S";
    // $_GET['idt0'] = $_GET['idCad'];
    //$botao_volta  = "parent.btFechaCTC('".$_GET['session_cod']."');";
    //$botao_acao   = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
    $botao_volta = "parent.hidePopWin(true);";
    $botao_acao = '<script type="text/javascript">parent.hidePopWin(true);</script>';
}

if ($acao != 'inc') {
    if ($_REQUEST['reload'] != 's') {
        $sql = '';
        $sql .= ' select idt, cpf';
        $sql .= ' from grc_entidade_pessoa';
        $sql .= ' where idt_entidade = ' . null($_GET['id']);
        $rs = execsql($sql);

        if ($rs->rows == 0) {
            $sql = '';
            $sql .= ' select codigo';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade';
            $sql .= ' where idt = ' . null($_GET['id']);
            $rs = execsql($sql);
            $cpf = $rs->data[0]['codigo'];
            $idt_entidade_pessoa = 0;
        } else {
            $idt_entidade_pessoa = $rs->data[0]['idt'];
            $cpf = $rs->data[0]['cpf'];
        }

        if ($_GET['deondeveio'] == 'Agenda') {
            $cpfa = $_GET['cpf'];
            if ($cpf == '') {
                $cpf = $cpfa;
            }
        }

        $rowSIAC = situacaoParceiroSiacWeb('F', $cpf);

        if ($rowSIAC['siacweb_situacao'] !== '') {
            $sql = 'update ' . db_pir_gec . 'gec_entidade set siacweb_situacao = ' . null($rowSIAC['siacweb_situacao']) . ' where idt = ' . null($_GET['id']);
            execsql($sql);
        }

        $variavel = Array();
        $variavel['erro'] = "";
        $variavel['cpf'] = FormataCPF12($cpf);
        BuscaCPF_GEC($idt_entidade_pessoa, $variavel);

        $_GET['id'] = $variavel['idt_entidade_pessoa'];
		
		
		// Novo estrelinha
		$cpf = $variavel['cpf'];
		$vet = AvaliacaoEstrelinhaMediaCliente($cpf);
		$quantidade   = $vet['quantidade'];
		$total_pontos = $vet['total_pontos'];
		$media        = $vet['media'];
		$img          = $vet['imagem'];
		$avaliacao_img=	$img;
		//echo $avaliacao_img;
		$vetCampo_av['avaliacao_estrelinha'] = objInclude('avaliacao_estrelinha', $avaliacao_img);
		
		
		
		
    }
}

if ($_GET['id'] == 0) {
    $acao = 'con';
    $_GET['acao'] = $acao;
}

$onSubmitDep = 'grc_entidade_pessoa_dep()';

$TabelaPrinc = "grc_entidade_pessoa";
$AliasPric = "grc_ap";
$Entidade = "Pessoa";
$Entidade_p = "Pessoas";
$CampoPricPai = "idt_entidade";

$tabela = $TabelaPrinc;


$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";

$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";


$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$id = 'idt';

$vetCampo['reload'] = objHidden('reload', 's', '', '', false);
$vetCampo['cpf'] = objCPF('cpf', 'CPF do Cliente', true);

$js1 = " style='width:30em;'";

$vetCampo['nome'] = objTexto('nome', 'Nome Completo', true, 45, 120, $js1);

$vetCampo['nome_pai'] = objTexto('nome_pai', 'Nome do Pai', false, 30, 120);
$vetCampo['nome_mae'] = objTexto('nome_mae', 'Nome da Mãe', false, 70, 120);


$sql = "select idt, descricao from " . db_pir_gec . "gec_entidade_estado_civil order by codigo";
$vetCampo['idt_estado_civil'] = objCmbBanco('idt_estado_civil', 'Estado Civil', false, $sql, ' ', 'width:180px;');
//
$sql = "select idt,  descricao from " . db_pir_gec . "gec_entidade_sexo order by codigo";
$rst = execsql($sql);

$vetTmp = Array();
$vlPadrao = '';

foreach ($rst->data as $idx => $rowt) {
    $vetTmp[$rowt['idt']] = strtoupper($rowt['descricao']);
}


$js1 = "";

$vetCampo['data_nascimento'] = objData('data_nascimento', 'Data Nascimento', true, $js1, '', 'S');

$js1 = " style='width:8em;'";
$js1 = "";

$vetCampo['idt_sexo'] = objRadio('idt_sexo', 'Sexo', true, $vetTmp, '', $js1, 'N', '');

$sql = "select idt, codigo, descricao from " . db_pir_gec . "gec_entidade_profissao order by codigo";
$vetCampo['idt_profissao'] = objCmbBanco('idt_profissao', 'Profissão', false, $sql, ' ', 'width:180px;');

$js1 = " style='width:15em;'";
$js2 = " style='width:20em;'";
$sql = "select idt, descricao from " . db_pir_gec . "gec_entidade_grau_formacao order by codigo";
$vetCampo['idt_escolaridade'] = objCmbBanco('idt_escolaridade', 'Escolaridade', false, $sql, ' ', '', $js1);
$vetCampo['potencial_personagem'] = objCmbVetor('potencial_personagem', 'Potencial Personagem?', false, $vetNaoSim, '', $js2);
$vetCampo['receber_informacao'] = objCmbVetor('receber_informacao', 'Receber informações do Sebrae?', true, $vetNaoSim, '', $js2);

$sql_lst_1 = 'select idt as idt_tipo_informacao, descricao from ' . db_pir_gec . 'gec_entidade_tipo_informacao order by descricao';

$sql_lst_2 = 'select ds.idt as idt_tipo_informacao, ds.descricao from ' . db_pir_gec . 'gec_entidade_tipo_informacao ds inner join
               grc_entidade_pessoa_tipo_informacao dr on ds.idt = dr.idt_tipo_informacao
               where dr.idt = $vlID order by ds.descricao';

$vetCampo['idt_tipo_informacao'] = objLista('idt_tipo_informacao', false, 'Receber Informações do Sistema', 'idt_tipo_informacao1', $sql_lst_1, 'grc_entidade_pessoa_tipo_informacao', 200, 'Receber Informações Selecionadas', 'idt_tipo_informacao2', $sql_lst_2);

$par = 'idt_tipo_informacao';
$vetDesativa['receber_informacao'][0] = vetDesativa($par);
$vetAtivadoObr['receber_informacao'][0] = vetAtivadoObr($par, 'S', true, '_lst_2');

$vetCampo['necessidade_especial'] = objCmbVetor('necessidade_especial', 'Portador de Necessidades Especiais?', false, $vetNaoSim, '', $js2);

$sql_lst_1 = 'select idt as idt_tipo_deficiencia, descricao from ' . db_pir_gec . 'gec_entidade_tipo_deficiencia order by descricao';

$sql_lst_2 = 'select ds.idt as idt_tipo_deficiencia, ds.descricao from ' . db_pir_gec . 'gec_entidade_tipo_deficiencia ds inner join
               grc_entidade_pessoa_tipo_deficiencia dr on ds.idt = dr.idt_tipo_deficiencia
               where dr.idt = $vlID order by ds.descricao';

$vetCampo['idt_tipo_deficiencia'] = objLista('idt_tipo_deficiencia', false, 'Deficiência do Sistema', 'idt_tipo_deficiencia1', $sql_lst_1, 'grc_entidade_pessoa_tipo_deficiencia', 200, 'Deficiência Selecionadas', 'idt_tipo_deficiencia2', $sql_lst_2);

$par = 'idt_tipo_deficiencia';
$vetDesativa['necessidade_especial'][0] = vetDesativa($par);
$vetAtivadoObr['necessidade_especial'][0] = vetAtivadoObr($par, 'S', true, '_lst_2');

$vetParametros = Array(
    'consulta_cep' => true,
    'campo_codpais' => 'logradouro_codpais',
    'campo_pais' => 'logradouro_pais',
    'campo_codest' => 'logradouro_codest',
    'campo_uf' => 'logradouro_estado',
    'campo_codcid' => 'logradouro_codcid',
    'campo_cidade' => 'logradouro_cidade',
    'campo_codbairro' => 'logradouro_codbairro',
    'campo_bairro' => 'logradouro_bairro',
    'campo_logradouro' => 'logradouro_endereco',
);
$vetCampo['logradouro_cep'] = objCEP('logradouro_cep', 'CEP', True, $vetParametros);

$js1 = " style='width:15em;'";
$js2 = " style='width:30em;'";
$js3 = " style='width:15em;'";
$js4 = " style='width:15em;'";

$vetCampo['logradouro_endereco'] = objTexto('logradouro_endereco', 'Logradouro', True, 45, 120, $js2);
$vetCampo['logradouro_numero'] = objTexto('logradouro_numero', 'Número', True, 15, 6, $js3);
$vetCampo['logradouro_complemento'] = objTexto('logradouro_complemento', 'Complemento', false, 30, 70, $js4);
$vetCampo['logradouro_bairro'] = objTexto('logradouro_bairro', 'Bairro', True, 34, 120, $js1);
$vetCampo['logradouro_cidade'] = objTexto('logradouro_cidade', 'Cidade', True, 45, 120, $js2);
$vetCampo['logradouro_estado'] = objTexto('logradouro_estado', 'Estado', True, 2, 2, $js3);
$vetCampo['logradouro_pais'] = objTexto('logradouro_pais', 'País', True, 30, 120, $js4);

$vetCampo['logradouro_codpais'] = objHidden('logradouro_codpais', '');
$vetCampo['logradouro_codest'] = objHidden('logradouro_codest', '');
$vetCampo['logradouro_codcid'] = objHidden('logradouro_codcid', '');
$vetCampo['logradouro_codbairro'] = objHidden('logradouro_codbairro', '');

$js1 = " style='width:17em;'";
$js2 = " style='width:25em;'";


$vetCampo['telefone_residencial'] = objTelefone('telefone_residencial', 'Telefone Residencial', false, $js1);
$vetCampo['telefone_celular'] = objTelefone('telefone_celular', 'Celular', false, $js1);
$vetCampo['telefone_recado'] = objTelefone('telefone_recado', 'Telefone Recado', false, $js1);


$vetCampo['email'] = objEmail('email', 'Endereço de e-mail', false, 30, 120, $js2);

$sql = "select grc_as.idt, grc_as.descricao from grc_atendimento_segmentacao grc_as ";
$sql .= " order by grc_as.codigo";
$rst = execsql($sql);
$vlPadrao = $rst->data[1]['idt'];


$js1 = " style='width:20em;'";
$vetCampo['idt_segmentacao'] = objCmbBanco('idt_segmentacao', 'Segmentação', false, $sql, '', '', $js1, true, $vlPadrao);

$sql = "select grc_as.idt, grc_as.descricao from grc_atendimento_subsegmentacao grc_as ";
$sql .= " order by grc_as.codigo";
$rst = execsql($sql);
$vlPadrao = $rst->data[$rst->rows - 1]['idt'];

$js1 = " style='width:20em;'";
$vetCampo['idt_subsegmentacao'] = objCmbBanco('idt_subsegmentacao', 'Subsegmentação', false, $sql, '', '', $js1, true, $vlPadrao);

$sql = "select grc_pf.idt, grc_pf.descricao from grc_atendimento_programa_fidelidade grc_pf ";
$sql .= " order by grc_pf.codigo";
$rst = execsql($sql);
$vlPadrao = $rst->data[$rst->rows - 1]['idt'];

$js1 = " style='width:20em;'";
$vetCampo['idt_programa_fidelidade'] = objCmbBanco('idt_programa_fidelidade', 'Programa Fidelidade', false, $sql, '', '', $js1, true, $vlPadrao);


$js1 = " readonly='true' style='width:14em; background:#FFFFD7;'";
$vetCampo['codigo_siacweb'] = objTexto('codigo_siacweb', 'Código Cliente', false, 25, 120, $js1);

$vetRelacao = Array();
$vetRelacao['P'] = 'Participante';
$vetRelacao['L'] = 'Representante';
//$vetCampo['tipo_relacao'] = objCmbVetor('tipo_relacao', 'Líder ou Participante', true, $vetRelacao, '');

$vetCampo['idt_pessoa'] = objHidden('idt_pessoa', '');
$vetCampo['botao_barra_tarefa_entidade_pessoa'] = objInclude('botao_barra_tarefa_entidade_pessoa', 'cadastro_conf/botao_barra_tarefa_atendimento_pessoa.php');

$vetCampo['siacweb_situacao'] = objRadio('siacweb_situacao', 'Situação do Cadastro (SiacWeb)', True, $vetParceiroSituacao, 1, '', 'S');

$sql = "select idt, descricao from " . db_pir_gec . "gec_entidade_ativeconpf order by codigo";
$vetCampo['idt_ativeconpf'] = objCmbBanco('idt_ativeconpf', 'Atividade Econômica', true, $sql, ' ', 'width:400px;');

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_pessoa'], '', $vetCampo['tipo_relacao'], '', $vetCampo['nome_tratamento'], '', $vetCampo['sms'], '', $vetCampo['reload']),
    Array($vetCampo['idt_segmentacao'], '', $vetCampo['idt_subsegmentacao'], '', $vetCampo['idt_programa_fidelidade'], '', $vetCampo['codigo_siacweb'], $vetCampo['botao_barra_tarefa_entidade_pessoa']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

// linha de separação
$vetFrm[] = Frame('Identificação', Array(
        ), $class_frame_p_esp, $class_titulo_p_esp, true, $vetParametros);


$vetParametros100 = Array(
    'width' => '100%',
);

MesclarCol($vetCampo['nome_mae'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['cpf'], '', $vetCampo['nome'], '', $vetCampo['data_nascimento'], '', $vetCampo['idt_sexo'],'',$vetCampo_av['avaliacao_estrelinha']),
    Array($vetCampo['siacweb_situacao'],'',$vetCampo['idt_ativeconpf'], '', $vetCampo['nome_mae']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros100);


// linha de separação
$vetFrm[] = Frame('Endereço', Array(
        ), $class_frame_p_esp, $class_titulo_p_esp, true, $vetParametros);


$vetFrm[] = Frame('', Array(
    Array($vetCampo['logradouro_cep'], '', $vetCampo['logradouro_endereco'], '', $vetCampo['logradouro_numero'], '', $vetCampo['logradouro_complemento']),
    Array($vetCampo['logradouro_bairro'], '', $vetCampo['logradouro_cidade'], '', $vetCampo['logradouro_estado'], '', $vetCampo['logradouro_pais']),
    Array($vetCampo['logradouro_codbairro'], '', $vetCampo['logradouro_codcid'], '', $vetCampo['logradouro_codest'], '', $vetCampo['logradouro_codpais']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

// linha de separação
$vetFrm[] = Frame('Contato*(Obrigatório informar, no mínimo, uma forma de contato)', Array(
        ), $class_frame_p_esp, $class_titulo_p_esp, true, $vetParametros);


$vetFrm[] = Frame('', Array(
    Array($vetCampo['telefone_residencial'], '', $vetCampo['telefone_celular'], '', $vetCampo['telefone_recado'], '', $vetCampo['email']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

// linha de separação
$vetFrm[] = Frame('Informações Adicionais', Array(
        ), $class_frame_p_esp, $class_titulo_p_esp, true, $vetParametros);

MesclarCol($vetCampo['idt_tipo_informacao'], 3);
MesclarCol($vetCampo['idt_tipo_deficiencia'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_escolaridade'], '', $vetCampo['potencial_personagem'], '', $vetCampo['receber_informacao'], '', $vetCampo['necessidade_especial']),
    Array($vetCampo['idt_tipo_informacao'], '', $vetCampo['idt_tipo_deficiencia']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetParametrosLC = Array(
    'barra_inc_ap' => true,
    'barra_alt_ap' => true,
    'barra_con_ap' => false,
    'barra_exc_ap' => true,
    'barra_inc_img' => "imagens/incluir_16.png",
    'barra_alt_img' => "imagens/alterar_16.png",
    'barra_con_img' => "imagens/consultar_16.png",
    'barra_exc_img' => "imagens/excluir_16.png",
    'contlinfim' => "",
);

//////////////////////////////////// colocar arquivos relacionados
// TEMAS DE INTERESSE
$vetParametros = Array(
    'codigo_frm' => 'parte20',
    'controle_fecha' => 'F',
);

$vetCampo_t = Array();
$vetCampo_t['grc_pt_descricao'] = CriaVetTabela('Itens', 'limite_txt', 35);
$vetCampo_t['observacao'] = CriaVetTabela('Observação', 'limite_txt', 35);

$TabelaPrinc = "grc_entidade_pessoa_tema_interesse";
$AliasPric = "grc_apti";
$Entidade = "Tema de Interesse";
$Entidade_p = "Temas de Interesse";
$CampoPricPai = "idt_entidade_pessoa";

$titulo = $Entidade_p;

$orderby = "grc_pt.descricao ";

$sql = "select {$AliasPric}.*, ";
$sql .= "        plu_usu.nome_completo as plu_usu_nome_completo, ";
$sql .= "        grc_pt.descricao      as grc_pt_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left  join plu_usuario plu_usu on  plu_usu.id_usuario = {$AliasPric}.idt_responsavel";
$sql .= " left  join grc_tema_subtema grc_pt  on  grc_pt.idt = {$AliasPric}.idt_tema";


$sql .= " where {$AliasPric}" . '.idt_entidade_pessoa = $vlID';
$sql .= " order by {$orderby}";


$vetCampo_t['grc_entidade_pessoa_tema_interesse'] = objListarConf('grc_entidade_pessoa_tema_interesse', 'idt', $vetCampo_t, $sql, $titulo, false, $vetParametrosLC);


$vetParametros = Array(
    'codigo_pai' => 'parte20',
    'width' => '100%',
);


//  PRODUTOS DE INTERESSE

$vetParametros = Array(
    'codigo_frm' => 'parte21',
    'controle_fecha' => 'F',
);

$vetCampo_p = Array();


$vetCampo_p = Array();
$vetCampo_p['grc_ep_descricao'] = CriaVetTabela('Produto', 'limite_txt', 35);
$vetCampo_p['observacao'] = CriaVetTabela('Observação', 'limite_txt', 35);

$TabelaPrinc = "grc_entidade_pessoa_produto_interesse";
$AliasPric = "grc_appi";
$Entidade = "Produto de Interesse da Pessoa";
$Entidade_p = "Produtos de Interesse da Pessoa";
$CampoPricPai = "idt_entidade_pessoa";

$titulo = $Entidade_p;

$orderby = "grc_ep.descricao ";

$sql = "select {$AliasPric}.*, ";
$sql .= "        plu_usu.nome_completo as plu_usu_nome_completo, ";
$sql .= "        grc_ep.descricao      as grc_ep_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left  join plu_usuario plu_usu on  plu_usu.id_usuario = {$AliasPric}.idt_responsavel";
$sql .= " left  join " . db_pir_grc . "grc_produto grc_ep  on  grc_ep.idt = {$AliasPric}.idt_produto";


$sql .= " where {$AliasPric}" . '.idt_entidade_pessoa = $vlID';
$sql .= " order by {$orderby}";


$vetCampo_p['grc_entidade_pessoa_produto_interesse'] = objListarConf('grc_entidade_pessoa_produto_interesse', 'idt', $vetCampo_p, $sql, $titulo, false, $vetParametrosLC);


$vetParametros = Array(
    'codigo_pai' => 'parte21',
    'width' => '100%',
);

/////////// ARQUIVOS DE INTERESSE
$vetCampo_a = Array();
$vetCampo_a['titulo'] = CriaVetTabela('Título', 'limite_txt', 35);
$vetCampo_a['arquivo'] = CriaVetTabela('Arquivo', 'arquivo_sem_nome', '', 'grc_entidade_pessoa_arquivo_interesse');

$TabelaPrinc = "grc_entidade_pessoa_arquivo_interesse";
$AliasPric = "gec_apai";
$Entidade = "Arquivo de Interesse da pessoa";
$Entidade_p = "Arquivos de Interesse da pessoa";
$CampoPricPai = "idt_entidade_pessoa";
$titulo = $Entidade_p;

$orderby = "{$AliasPric}.titulo ";

$sql = "select {$AliasPric}.*, ";
$sql .= "        plu_usu.nome_completo as plu_usu_nome_completo ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left  join plu_usuario plu_usu on  plu_usu.id_usuario = {$AliasPric}.idt_responsavel";
$sql .= " where {$AliasPric}" . '.idt_entidade_pessoa = $vlID';
$sql .= " order by {$orderby}";

$vetCampo_a['grc_entidade_pessoa_arquivo_interesse'] = objListarConf('grc_entidade_pessoa_arquivo_interesse', 'idt', $vetCampo_a, $sql, $titulo, false, $vetParametrosLC);

$vetParametros = Array(
    'width' => '100%',
);

$vetCampo_t['grc_entidade_pessoa_tema_interesse_tit'] = objBarraTitulo('grc_entidade_pessoa_tema_interesse_tit', 'TEMA DE INTERESSE', 'class_titulo_p_barra');
$vetCampo_p['grc_entidade_pessoa_produto_interesse_tit'] = objBarraTitulo('grc_entidade_pessoa_produto_interesse_tit', 'PRODUTO DE INTERESSE', 'class_titulo_p_barra');
$vetCampo_a['grc_entidade_pessoa_arquivo_interesse_tit'] = objBarraTitulo('grc_entidade_pessoa_arquivo_interesse_tit', 'ANEXO', 'class_titulo_p_barra');


if (!$_SESSION[CS]['tmp'][CSU]['vetParametrosMC']['sem_registro']) {
    $vetFrm[] = Frame('', Array(
        Array($vetCampo_t['grc_entidade_pessoa_tema_interesse_tit'], '', $vetCampo_p['grc_entidade_pessoa_produto_interesse_tit'], '', $vetCampo_a['grc_entidade_pessoa_arquivo_interesse_tit']),
        Array($vetCampo_t['grc_entidade_pessoa_tema_interesse'], '', $vetCampo_p['grc_entidade_pessoa_produto_interesse'], '', $vetCampo_a['grc_entidade_pessoa_arquivo_interesse']),
            ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);
}

$vetCad[] = $vetFrm;
?>
<script>
    var btAcaoCPF = null;

    var MesclarCadastro = '<?php echo ($MesclarCadastro ? 'S' : 'N'); ?>';

    $(document).ready(function () {
        if ($('#nome').val() == 'Cliente Novo') {
            $('#nome').val('');
        }

        if ('<?php echo $_SESSION[CS]['tmp'][CSU]['vetParametrosMC']['trava_tudo']; ?>' != 'S') {
            $('#cpf').focus();

            $('#cpf').change(function () {
                if ($(this).val() != '') {
                    $('#btBuscaCPF').click();
                }
            });

            var campo = $("#idt_segmentacao, #idt_subsegmentacao,#idt_programa_fidelidade");
            var opt = campo.find('option');
            opt.prop("disabled", true);
            opt.addClass("campo_disabled");

            var acaoBuscaCPF = function () {
                var libera_bt = true;
                $(this).hide();

                if (checaCPF($('#cpf').val()) == false) {
                    $('#cpf').val('');
                }

                if ($('#cpf').val() != '') {
                    processando();

                    $.ajax({
                        type: 'POST',
                        url: 'ajax_atendimento.php?tipo=BuscaCPF_GEC',
                        data: {
                            cas: conteudo_abrir_sistema,
                            cpf: $('#cpf').val(),
                            idt: '<?php echo $_GET['id']; ?>'
                        },
                        success: function (response) {
                            var idt = parseInt(response);

                            if (isNaN(idt)) {
                                $("#dialog-processando").remove();
                                alert(response);
                            } else if (idt == 0) {
                                if ($('#cpf').prop("disabled")) {
                                    $("#dialog-processando").remove();
                                    alert('CPF não localizado nas bases de pesquisas!');
                                } else {
                                    var par = '';
                                    par += '?prefixo=listar_cmb';
                                    par += '&menu=gec_entidade_grc_atendimento_pessoa';
                                    par += '&cas=' + conteudo_abrir_sistema;
                                    par += '&texto2=' + $('#nome').val();
                                    par += '&cpf3=' + $('#cpf').val();
                                    var url = 'conteudo_cadastro.php' + par;
                                    showPopWin(url, 'Busca Pesssoa', $('div.showPopWin_width').width() - 30, $(window).height() - 100, BuscaPesssoaClose, false);
                                }
                            } else {
                                libera_bt = false;

                                var url = self.location.href;
                                url = url.replace('&id=<?php echo $_GET['id']; ?>', '&id=' + idt);
                                url = url.replace('?acao=inc&', '?acao=alt&');
                                url += '&reload=s';
                                self.location = url;
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $("#dialog-processando").remove();
                            alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                        },
                        async: false
                    });

                    $("#dialog-processando").remove();
                } else {
                    var par = '';
                    par += '?prefixo=listar_cmb';
                    par += '&menu=gec_entidade_grc_atendimento_pessoa';
                    par += '&cas=' + conteudo_abrir_sistema;
                    par += '&texto2=' + $('#nome').val();
                    par += '&cpf3=' + $('#cpf').val();
                    var url = 'conteudo_cadastro.php' + par;
                    showPopWin(url, 'Busca Pesssoa', $('div.showPopWin_width').width() - 30, $(window).height() - 100, BuscaPesssoaClose, false);
                }

                if (libera_bt) {
                    $(this).show();
                }
            };

            if ($('#cpf').val() == '') {
                setTimeout('func_AtivaDesativa("S", "S".split(","), $("#cpf,#nome,#idt_segmentacao,#idt_subsegmentacao,#idt_programa_fidelidade"), $("#cpf_desc,#nome_desc"), "".split(","), "N", "N")', 100);

                btAcaoCPF = $('<img border="0" id="btBuscaCPF" style="margin-left: 3px; cursor: pointer; vertical-align: middle;" src="imagens/bt_pesquisa.png" title="Pesquisar">');
                btAcaoCPF.click(acaoBuscaCPF);
            } else {
                $('#cpf').prop("disabled", true).addClass("campo_disabled");

                btAcaoCPF = $('<img border="0" style="margin-left: 3px; cursor: pointer; vertical-align: middle;" src="imagens/bt_limpar.png" title="Abrir campo de CPF">');
                btAcaoCPF.click(function () {
                    if (confirm('Deseja abrir campo de CPF?\nSe realizar uma nova pesquisa todos dados de Pessoa e Empreendimentos vão ser atualizados na pesquisa!')) {
                        $('#cpf').removeProp("disabled").removeClass("campo_disabled");

                        btAcaoCPF.remove();
                        btAcaoCPF = $('<img border="0" id="btBuscaCPF" style="margin-left: 3px; cursor: pointer; vertical-align: middle;" src="imagens/bt_pesquisa.png" title="Pesquisar">');
                        btAcaoCPF.click(acaoBuscaCPF);
                        $('#nome_obj').append(btAcaoCPF);
                    }
                });
            }

            $('#nome_obj').attr('nowrap', 'nowrap').append(btAcaoCPF);
        }

        $('#data_nascimento').change(function () {
            if ($('#data_nascimento').val().substr(6) >= $('#dtBancoObj').val().substr(6)) {
                alert('Ano de Nascimento deve ser menor que o ano corrente.!');
                $('#data_nascimento').val('');
                $('#data_nascimento').focus();
                return false;
            }
        });

        objd = document.getElementById('idt_pessoa_txt');
        if (objd != null)
        {
            $(objd).css('fontSize', '12px');
            $(objd).css('background', '#FFFFCA');
        }

        $('#receber_informacao').change(function () {
            if ($(this).val() == 'S') {
                $('#idt_tipo_informacao_desc > table').show();
            } else {
                $('#idt_tipo_informacao_desc > table').hide();
            }
        });

        $('#necessidade_especial').change(function () {
            if ($(this).val() == 'S') {
                $('#idt_tipo_deficiencia_desc > table').show();
            } else {
                $('#idt_tipo_deficiencia_desc > table').hide();
            }
        });
    });

    function BuscaPesssoaClose(returnVal) {
        $('#cpf').val(returnVal.desc);
        btAcaoCPF.click();
    }

    function grc_entidade_pessoa_dep()
    {
        var ok = true;

        if (valida == 'S') {
            if ($('#data_nascimento').val().substr(6) >= $('#dtBancoObj').val().substr(6)) {
                alert('Ano de Nascimento deve ser menor que o ano corrente.!');
                $('#data_nascimento').val('');
                $('#data_nascimento').focus();
                return false;
            }

            if ($('#telefone_residencial').val() == '' && $('#telefone_celular').val() == '' && $('#telefone_recado').val() == '' && $('#email').val() == '') {
                alert('Por favor, preencher um dos campos de Contato');
                return false;
            }

            if ($('#logradouro_codbairro').val() == '' || $('#logradouro_codcid').val() == '' || $('#logradouro_codest').val() == '' || $('#logradouro_codpais').val() == '') {
                alert('Por favor, informar um CEP válido no SiacWeb!');
                return false;
            }

            $('#idt_tipo_informacao_lista > option').each(function () {
                if (ok) {
                    var idt = $(this).val().substr(1);

                    switch (idt) {
                        case '1': //Deseja receber ligações
                            if ($('#telefone_residencial').val() == '') {
                                alert('Por favor, preencher um dos campo de Telefone Residencial');
                                ok = false;
                                return;
                            }
                            break;

                        case '2': //Deseja receber mala direta
                            if ($('#logradouro_cep').val() == '') {
                                alert('Por favor, preencher o campo de Endereço');
                                $('#logradouro_cep').focus();
                                ok = false;
                            }
                            break;
                            
                        case '3': //Deseja receber emails
                            if ($('#email').val() == '') {
                                alert('Por favor, preencher o campo de Endereço de e-mail');
                                $('#email').focus();
                                ok = false;
                            }
                            break;

                        case '4': //Deseja receber SMS
                            if ($('#telefone_celular').val() == '') {
                                alert('Por favor, preencher o campo de Celular');
                                $('#telefone_celular').focus();
                                ok = false;
                            }
                            break;
                            
                        case '5': //Pelo Telefone de Recados
                            if ($('#telefone_recado').val() == '') {
                                alert('Por favor, preencher um dos campo de Telefone Recado');
                                ok = false;
                                return;
                            }
                            break;
                    }
                }
            });

            if (ok) {
                processando();

                var objDisabled = $(":disabled");
                objDisabled.removeProp("disabled");

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'ajax_atendimento.php?tipo=validacaoDadosPessoa',
                    data: {
                        cas: conteudo_abrir_sistema,
                        form: $('#frm').serialize()
                    },
                    success: function (response) {
                        if (response.erro != '') {
                            $("#dialog-processando").remove();
                            alert(url_decode(response.erro));
                            ok = false;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $("#dialog-processando").remove();
                        alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                        ok = false;

                    },
                    async: false
                });

                objDisabled.prop("disabled", true);

                $("#dialog-processando").remove();
            }
        }

        return ok;
    }
</script>