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
        background: #ECF0F1;
        background: #C4C9CD;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
    }

    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
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

    #idt_cnae_principal_obj {
        white-space: nowrap;
    }

    Td.Titulo_radio {
        width: 64px;
    }

    fieldset.class_frame_p_esp {
        border: none;
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

    #receber_informacao_e_desc {
        height: 22px;
        width: 168px;
    }

    #frm10 {
        width: 100%;
    }
</style>
<?php
$class_frame_p_esp = 'class_frame_p_esp';
$class_titulo_p_esp = 'class_titulo_p_esp';

$bt_salvar_lbl = 'Salvar Novo';
$bt_alterar_lbl = 'Salvar';

$onSubmitDep = 'grc_entidade_organizacao_dep()';
$botao_volta = "btAcaoVoltar();";

$barra_bt_top = false;

$TabelaPrinc = "grc_entidade_organizacao";
$AliasPric = "grc_ao";
$Entidade = "Organização";
$Entidade_p = "Organizações";

$tabela = $TabelaPrinc;
$id = 'idt';

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";

$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$id_org = $_GET['id'];

if ($acao != 'inc') {
    if ($_REQUEST['reload'] != 's') {
        $sql = '';
        $sql .= ' select idt as idt_entidade_organizacao, cnpj, codigo_siacweb_e as codigo_siacweb, dap, nirf, rmp, ie_prod_rural, sicab_codigo, funil_idt_cliente_classificacao';
        $sql .= ' from grc_entidade_organizacao';
        $sql .= ' where idt_entidade = ' . null($_GET['id']);
        $rs = execsql($sql);

        if ($rs->rows == 0) {
            $sql = '';
            $sql .= ' select 0 as idt_entidade_organizacao, e.codigo as cnpj, e.codigo_siacweb, o.dap, o.nirf, o.rmp, o.ie_prod_rural, o.sicab_codigo, funil_idt_cliente_classificacao';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade e';
            $sql .= ' left outer join ' . db_pir_gec . 'gec_entidade_organizacao o on o.idt_entidade = e.idt';
            $sql .= ' where e.idt = ' . null($_GET['id']);
            $rs = execsql($sql);
        }

        $row = $rs->data[0];

        $rowSIAC = situacaoParceiroSiacWeb('J', $row['cnpj'], $row['nirf'], $row['dap'], $row['rmp'], $row['ie_prod_rural'], $row['sicab_codigo']);

        if ($rowSIAC['siacweb_situacao'] !== '') {
            $sql = 'update ' . db_pir_gec . 'gec_entidade set siacweb_situacao = ' . null($rowSIAC['siacweb_situacao']) . ' where idt = ' . null($_GET['id']);
            execsql($sql);

            $sql = 'update ' . db_pir_gec . 'gec_entidade_organizacao set data_fim_atividade = ' . aspa($rowSIAC['data_fim_atividade']) . ' where idt_entidade = ' . null($_GET['id']);
            execsql($sql);
        }

        $variavel = Array();
        $variavel['erro'] = "";

        if (validaCNPJ($row['cnpj'])) {
            $variavel['cnpj'] = FormataCNPJ($row['cnpj']);
        } else {
            $variavel['cnpj'] = '';
        }
        $identificacao=$variavel['cnpj'];

        $funil_idt_cliente_classificacao = $row['funil_idt_cliente_classificacao'];

        // p("1111-------------- ".$funil_idt_cliente_classificacao);
		
		
		
		
		

        $variavel['codparceiro'] = $row['codigo_siacweb'];
        $variavel['idt_tipo_empreendimento'] = $row['idt_tipo_empreendimento'];
        $variavel['dap'] = $row['dap'];
        $variavel['nirf'] = $row['nirf'];
        $variavel['rmp'] = $row['rmp'];
        $variavel['ie_prod_rural'] = $row['ie_prod_rural'];
        $variavel['sicab_codigo'] = $row['sicab_codigo'];
		if ($variavel['dap']!="")
		{
		    $identificacao=$variavel['dap'];
		}	
        if ($variavel['nirf']!="")
		{
		    $identificacao=$variavel['nirf'];
		}
		if ($variavel['rmp']!="")
		{
		    $identificacao=$variavel['rmp'];
		}
		if ($variavel['ie_prod_rural']!="")
		{
		    $identificacao=$variavel['ie_prod_rural'];
		}
        BuscaCNPJ_GEC($row['idt_entidade_organizacao'], $variavel);

        $_GET['id'] = $variavel['idt_entidade_organizacao'];
    }

    $sql = "select  ";
    $sql .= " grc_ap.*  ";
    $sql .= " from grc_entidade_organizacao grc_ap ";
    $sql .= " where idt = " . null($_GET['id']);
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
	    $cnpj = $row['cnpj'];
        $idt_cnae_principal = $row['idt_cnae_principal'];
        $funil_idt_cliente_classificacao = $row['funil_idt_cliente_classificacao'];
    }
	
	if ($funil_idt_cliente_classificacao=="")
	{
		// se tem empresa relacionada
		$funil_idt_cliente_classificacao=8888;
		$codigo = $cnpj;
		$vetRetorno=Array();
		BuscaClienteFunil($codigo,$vetRetorno);
		$idt_cliente_classificacao = $vetRetorno['idt_cliente_classificacao'];
		$nota                      = $vetRetorno['nota'];
		if ($idt_cliente_classificacao!='')
		{
			$funil_cliente_nota_avaliacao    = $nota;
			$funil_idt_cliente_classificacao = $idt_cliente_classificacao;
		}
		else
		{
			$funil_cliente_nota_avaliacao    = 0;
			$funil_idt_cliente_classificacao = 1;
		}
	}
	
}

if ($_GET['id'] == 0) {
    $acao = 'con';
    $_GET['acao'] = $acao;
}

$jst = "";

$vetCampo['reload'] = objHidden('reload', 's', '', '', false);
$vetCampo['novo_registro'] = objHidden('novo_registro', 'N');


$js1 = " readonly='true' style='width:10em; background:#FFFFD7;'";
$vetCampo['codigo_siacweb_e'] = objTexto('codigo_siacweb_e', 'Código Empreendimento', false, 20, 120, $js1);

$js1 = " style='width:20em;'";
$vetCampo['razao_social'] = objTexto('razao_social', 'Razão Social', true, 35, 120, $js1);

$js1 = " style='width:12em;'";
$vetCampo['nome_fantasia'] = objTexto('nome_fantasia', 'Nome Fantasia', true, 30, 80, $js1);

$vetCampo['data_abertura'] = objData('data_abertura', 'Data Abertura', true, '', '', 'S');


$vetCampo['pessoas_ocupadas'] = objInteiro('pessoas_ocupadas', 'Pessoas Ocupadas', true, 10);

$sql = '';
$sql .= ' select idt, descricao, desc_vl_cmb';
$sql .= ' from ' . db_pir_gec . 'gec_organizacao_porte';
$sql .= " where codigo in ('2', '3', '99')";
$sql .= ' order by descricao, desc_vl_cmb';
$rs = execsql($sql);

$js1 = " style='width:14em;'";
$vetCampo['idt_porte'] = objCmbBanco('idt_porte', 'Porte / Faixa Faturamento', true, $sql, ' ', '', $js1);

$vetCampo['simples_nacional'] = objCheckbox('simples_nacional', '', 'S', 'N', 'Optante do Simples Nacional?', true, 'S');

$vetCampo['tamanho_propriedade'] = objDecimal('tamanho_propriedade', 'Tamanho Propriedade', false, 13);

$vetCampo['idt_cnae_principal'] = objListarCmb('idt_cnae_principal', 'gec_cnae', 'Atividade Econômica Principal', true, '680px');

$vetCampo['idt_setor'] = objFixoBanco('idt_setor', 'Setor', db_pir_gec . 'gec_entidade_setor', 'idt', 'descricao');

$vetCampo['receber_informacao_e'] = objCmbVetor('receber_informacao_e', 'Receber informações do Sebrae?', true, $vetNaoSim, '');

$sql_lst_1 = 'select idt as idt_tipo_informacao_e, descricao from ' . db_pir_gec . 'gec_entidade_tipo_informacao order by descricao';

$sql_lst_2 = 'select ds.idt as idt_tipo_informacao_e, ds.descricao from ' . db_pir_gec . 'gec_entidade_tipo_informacao ds inner join
               grc_entidade_organizacao_tipo_informacao dr on ds.idt = dr.idt_tipo_informacao_e
               where dr.idt = ' . null($_GET['id']) . ' order by ds.descricao';

$vetCampo['idt_tipo_informacao_e'] = objLista('idt_tipo_informacao_e', false, 'Receber Informações do Sistema', 'idt_tipo_informacao_e1', $sql_lst_1, 'grc_entidade_organizacao_tipo_informacao', 200, 'Receber Informações Selecionadas', 'idt_tipo_informacao_e2', $sql_lst_2, '', '', '', '', 'idt');

$par = 'idt_tipo_informacao_e';
$vetDesativa['receber_informacao_e'][0] = vetDesativa($par);
$vetAtivadoObr['receber_informacao_e'][0] = vetAtivadoObr($par, 'S', true, '_lst_2');

$vetParametros = Array(
    'consulta_cep' => true,
    'campo_codpais' => 'logradouro_codpais_e',
    'campo_pais' => 'logradouro_pais_e',
    'campo_codest' => 'logradouro_codest_e',
    'campo_uf' => 'logradouro_estado_e',
    'campo_codcid' => 'logradouro_codcid_e',
    'campo_cidade' => 'logradouro_cidade_e',
    'campo_codbairro' => 'logradouro_codbairro_e',
    'campo_bairro' => 'logradouro_bairro_e',
    'campo_logradouro' => 'logradouro_endereco_e',
);
$vetCampo['logradouro_cep_e'] = objCEP('logradouro_cep_e', 'CEP', True, $vetParametros);


$js1 = " style='width:15em;'";
$js2 = " style='width:30em;'";
$js3 = " style='width:15em;'";
$js4 = " style='width:15em;'";



$vetCampo['logradouro_endereco_e'] = objTexto('logradouro_endereco_e', 'Logradouro', True, 45, 120, $js2);
$vetCampo['logradouro_numero_e'] = objTexto('logradouro_numero_e', 'Número', True, 30, 6, $js3);
$vetCampo['logradouro_complemento_e'] = objTexto('logradouro_complemento_e', 'Complemento', false, 30, 70, $js4);
$vetCampo['logradouro_bairro_e'] = objTexto('logradouro_bairro_e', 'Bairro', True, 30, 120, $js1);
$vetCampo['logradouro_cidade_e'] = objTexto('logradouro_cidade_e', 'Cidade', True, 45, 120, $js2);
$vetCampo['logradouro_estado_e'] = objTexto('logradouro_estado_e', 'Estado', True, 30, 2, $js3);
$vetCampo['logradouro_pais_e'] = objTexto('logradouro_pais_e', 'País', True, 30, 120, $js4);

$vetCampo['logradouro_codpais_e'] = objHidden('logradouro_codpais_e', '');
$vetCampo['logradouro_codest_e'] = objHidden('logradouro_codest_e', '');
$vetCampo['logradouro_codcid_e'] = objHidden('logradouro_codcid_e', '');
$vetCampo['logradouro_codbairro_e'] = objHidden('logradouro_codbairro_e', '');



$js1 = " style='width:17em;'";
$js2 = " style='width:25em;'";

$vetCampo['telefone_comercial_e'] = objTelefone('telefone_comercial_e', 'Telefone Comercial', false, $js1);
$vetCampo['telefone_celular_e'] = objTelefone('telefone_celular_e', 'Telefone Celular', false, $js1);
$vetCampo['telefone_recado_e'] = objTelefone('telefone_recado_e', 'Telefone Recado', false, $js1);
$vetCampo['email_e'] = objEmail('email_e', 'Endereço de e-mail', false, 30, 120, $js2);
$vetCampo['site_url'] = objURL('site_url', 'Site Url', false, 30, 120, $js2);
$vetCampo['sms_e'] = objTelefone('sms_e', 'Telefone SMS', false);

$vetCampo['telefone_comercial_e']['size'] = 30;
$vetCampo['telefone_celular_e']['size'] = 45;


$js1 = " style='width:12em;'";
$js2 = " style='width:14em;'";
$js3 = " style='width:12em;'";
$js4 = " style='width:14em;'";

$vetCampo['cnpj'] = objCNPJ('cnpj', 'CNPJ', false);

$par = 'tamanho_propriedade';
$vetDesativa['idt_tipo_empreendimento'][0] = vetDesativa($par, 7, false);

if ($_GET['id'] == 0) {
    $sql = '';
    $sql .= ' select idt, descricao';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade_tipo_emp';
    $sql .= " where ativo = 'S'";
    $sql .= ' order by descricao';

    $js1 = " style='width:20em;'";
    $vetCampo['idt_tipo_empreendimento'] = objCmbBanco('idt_tipo_empreendimento', 'Tipo de Empreendimento', true, $sql, ' ', '', $js1);

    $vetCampo['dap'] = objTexto('dap', 'DAP', false, 20, 45, $js1);
    $vetCampo['nirf'] = objTexto('nirf', 'NIRF', false, 11, 11, $js2 . ' onblur="return Valida_Nirf(this);" onkeyup="return Formata_Nirf(this);"');
    $vetCampo['rmp'] = objTexto('rmp', 'Registro Ministério da Pesca', false, 20, 45, $js3);
    $vetCampo['ie_prod_rural'] = objTexto('ie_prod_rural', 'Inscrição Estadual', false, 25, 45, $js4);
    $vetCampo['sicab_codigo'] = objTexto('sicab_codigo', 'SICAB', false, 18, 18, ' onblur="return ValidaSICAB(this);" onkeyup="return FormataSICAB(this);"');
} else {
    $vetCampo['idt_tipo_empreendimento'] = objFixoBanco('idt_tipo_empreendimento', 'Tipo de Empreendimento', db_pir_gec . 'gec_entidade_tipo_emp', 'idt', 'descricao');

    if ($_SESSION[CS]['g_id_usuario'] == 1 || $_SESSION[CS]['g_id_usuario'] == 90 || $_SESSION[CS]['g_id_usuario'] == 111) {
        $vetCampo['dap'] = objTexto('dap', 'DAP', false, 20, 45, $js1);
        $vetCampo['nirf'] = objTexto('nirf', 'NIRF', false, 11, 11, $js2 . ' onblur="return Valida_Nirf(this);" onkeyup="return Formata_Nirf(this);"');
        $vetCampo['rmp'] = objTexto('rmp', 'Registro Ministério da Pesca', false, 20, 45, $js3);
        $vetCampo['ie_prod_rural'] = objTexto('ie_prod_rural', 'Inscrição Estadual', false, 25, 45, $js4);
        $vetCampo['sicab_codigo'] = objTexto('sicab_codigo', 'SICAB', false, 18, 18, ' onblur="return ValidaSICAB(this);" onkeyup="return FormataSICAB(this);"');
    } else {
        $vetCampo['dap'] = objTextoFixo('dap', 'DAP', '', true);
        $vetCampo['nirf'] = objTextoFixo('nirf', 'NIRF', '', true);
        $vetCampo['rmp'] = objTextoFixo('rmp', 'Registro Ministério da Pesca', '', true);
        $vetCampo['ie_prod_rural'] = objTextoFixo('ie_prod_rural', 'Inscrição Estadual', '', true);
        $vetCampo['sicab_codigo'] = objTextoFixo('sicab_codigo', 'SICAB', '', true);
    }
}

$vetCampo['sicab_dt_validade'] = objData('sicab_dt_validade', 'Data de Validade', False, '', '', 'S');
$vetCampo['siacweb_situacao_e'] = objRadio('siacweb_situacao_e', 'Situação do Cadastro (SiacWeb)', True, $vetParceiroSituacao, 1, '', 'S');
$vetCampo['data_fim_atividade'] = objTextoFixo('data_fim_atividade', 'Data de Inatividade', 10, true);

$vetCampo['idt_organizacao'] = objListarCmb('idt_organizacao', 'gec_entidade_agenda_o_cmb', 'Pesquisa Empreendimento', false, '70%');
$complemento=" readonly='true' style='background:#FFFFD7;' ";
$vetCampo['funil_cliente_nota_avaliacao'] = objDecimal('funil_cliente_nota_avaliacao', 'Nota da Avaliação (NPS)', false, 10,'',2, $complemento);

$js = " readonly='true' style='background:#FFFFD7;' ";
$vetCampo['funil_cliente_data_avaliacao'] = objDataHora('funil_cliente_data_avaliacao', 'Data da Última Avaliação', false,$js);
$maxlength = 255;
$style = "width:650px; height:40px; background:#FFFFD7;";
$js = " readonly='true'  ";
$vetCampo['funil_cliente_obs_avaliacao'] = objTextArea('funil_cliente_obs_avaliacao', 'Comentário do Cliente', false, $maxlength, $style, $js);


if ($funil_idt_cliente_classificacao == '') {
    $funil_idt_cliente_classificacao = 3;
}

//p("2222-------------- ".$funil_idt_cliente_classificacao);
//$funil_idt_cliente_classificacao=3;
//$_GET['funil_idt_cliente_classificacao']=$funil_idt_cliente_classificacao;
$_GET['width_fase'] = '';


//$vetCampo['funil_fase'] = objInclude('funil_fase', 'cadastro_conf/obj_html_funil_fase.php');
$vetCampo['funil_fases'] = objInclude('funil_fases', 'cadastro_conf/obj_html_funil_fases.php');

$vetCampo['historico_nota'] = objInclude('historico_nota', 'cadastro_conf/obj_html_historico_nota.php');



$vetCampoLC = Array();
$vetCampoLC['cnae_txt'] = CriaVetTabela('Atividade Econômica Secundária');

$TabelaPrinc = "grc_entidade_organizacao_cnae";
$AliasPric = "grc_apc";
$Entidade = "Atividade Econômica Secundária";
$Entidade_p = "Atividades Econômicas Secundárias";
$titulo = $Entidade_p;
$orderby = "grc_pt.descricao ";

$sql = "select {$AliasPric}.*, ";
$sql .= " concat_ws(' - ', cnae.subclasse, cnae.descricao) as cnae_txt";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left outer join " . db_pir_gec . "cnae on  cnae.subclasse = {$AliasPric}.cnae";
$sql .= " where {$AliasPric}" . '.idt_entidade_organizacao = $vlID';
$sql .= " and principal = 'N'";
$sql .= " order by cnae_txt";

$vetParametrosLC = Array(
    'barra_inc_img' => "imagens/incluir_16.png",
    'barra_alt_img' => "imagens/alterar_16.png",
    'barra_con_img' => "imagens/consultar_16.png",
    'barra_exc_img' => "imagens/excluir_16.png",
    'contlinfim' => "",
);

$vetCampo['grc_entidade_organizacao_cnae'] = objListarConf('grc_entidade_organizacao_cnae', 'idt', $vetCampoLC, $sql, $titulo, false, $vetParametrosLC);
$vetCampo['codigo_prod_rural'] = objHidden('codigo_prod_rural', '');

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo_prod_rural'], '', $vetCampo['novo_registro'], '', $vetCampo['reload']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCampo['botao_barra_tarefa_atendimento_organizacao'] = objInclude('botao_barra_tarefa_atendimento_organizacao', 'cadastro_conf/botao_barra_tarefa_atendimento_organizacao.php');

$sql = '';
$sql .= ' select codcargcli, desccargcli';
$sql .= ' from ' . db_pir_siac . 'cargcli';
$sql .= " where situacao = 'S'";
$sql .= ' order by desccargcli';

$js1 = " style='width:20em;'";
$vetCampo['representa_codcargcli'] = objCmbBanco('representa_codcargcli', 'Cargo do Representante', true, $sql, ' ', '', $js1);
$vetCampo['idt_representa'] = objListarCmb('idt_representa', 'gec_entidade_grc_atendimento_pessoa_nome', 'Representante', true, '680px');

$vetParametros = Array(
    'width' => '100%',
);

MesclarCol($vetCampo['data_fim_atividade'], 8);
MesclarCol($vetCampo['ie_prod_rural'], 2);
MesclarCol($vetCampo['sicab_dt_validade'], 8);
MesclarCol($vetCampo['simples_nacional'], 2);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['siacweb_situacao_e'], '', $vetCampo['data_fim_atividade']),
    Array($vetCampo['idt_tipo_empreendimento'], '', $vetCampo['cnpj'], '', $vetCampo['idt_porte'], '', $vetCampo['idt_setor'], '', $vetCampo['codigo_siacweb_e'], $vetCampo['botao_barra_tarefa_atendimento_organizacao']),
    Array($vetCampo['tamanho_propriedade'], '', $vetCampo['dap'], '', $vetCampo['nirf'], '', $vetCampo['rmp'], '', $vetCampo['ie_prod_rural']),
    Array($vetCampo['sicab_codigo'], '', $vetCampo['sicab_dt_validade']),
    Array($vetCampo['razao_social'], '', $vetCampo['nome_fantasia'], '', $vetCampo['data_abertura'], '', $vetCampo['pessoas_ocupadas'], '', $vetCampo['simples_nacional']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

MesclarCol($vetCampo['idt_cnae_principal'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_cnae_principal']),
    Array($vetCampo['idt_representa'], '', $vetCampo['representa_codcargcli']),
        ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetFrm[] = Frame('<span>ATIVIDADES ECONÔMICAS SECUNDÁRIAS</span>', Array(
    Array($vetCampo['grc_entidade_organizacao_cnae']),
        ), $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


// linha de separação
$vetFrm[] = Frame('Endereço', Array(
        ), $class_frame_p_esp, $class_titulo_p_esp, true, $vetParametros);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['logradouro_cep_e'], '', $vetCampo['logradouro_endereco_e'], '', $vetCampo['logradouro_numero_e'], '', $vetCampo['logradouro_complemento_e']),
    Array($vetCampo['logradouro_bairro_e'], '', $vetCampo['logradouro_cidade_e'], '', $vetCampo['logradouro_estado_e'], '', $vetCampo['logradouro_pais_e']),
    Array($vetCampo['logradouro_codbairro_e'], '', $vetCampo['logradouro_codcid_e'], '', $vetCampo['logradouro_codest_e'], '', $vetCampo['logradouro_codpais_e']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

// linha de separação
$vetFrm[] = Frame('Contato*(Obrigatório informar, no mínimo, uma forma de contato)', Array(
        ), $class_frame_p_esp, $class_titulo_p_esp, true, $vetParametros);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['telefone_comercial_e'], '', $vetCampo['telefone_celular_e'], '', $vetCampo['email_e'], '', $vetCampo['site_url']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
// linha de separação
$vetFrm[] = Frame('Informações Adicionais', Array(
        ), $class_frame_p_esp, $class_titulo_p_esp, true, $vetParametros);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['receber_informacao_e'], '', $vetCampo['idt_tipo_informacao_e']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

//$vetFrm[] = Frame('', Array(
//    Array($vetCampo['funil_fases'],'',$vetCampo['funil_cliente_nota_avaliacao']),
  //  Array($vetCampo['funil_fases']),
    //    ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

MesclarCol($vetCampo['funil_fases'], 5);
MesclarCol($vetCampo['historico_nota'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['funil_fases']),
    Array($vetCampo['funil_cliente_nota_avaliacao'],'',$vetCampo['funil_cliente_data_avaliacao'],'',$vetCampo['funil_cliente_obs_avaliacao']),
	Array($vetCampo['historico_nota']),
	
	
	
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);



$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    var btAcaoCNPJ = null;

    $(document).ready(function () {
        if (CalculaCNPJ($('#cnpj').val()) == false) {
            $('#cnpj').val('');
        }

        if ($('#razao_social').val() == 'Novo Empreendimento') {
            $('#razao_social').val('');
        }

        if ('<?php echo $_GET['trava_tudo']; ?>' != 'S') {
            $('#cnpj').change(function () {
                if ($(this).val() != '') {
                    $('#btBuscaCNPJ').click();
                }
            });

            var acaoBuscaCNPJ = function () {
                var libera_bt = true;
                $(this).hide();

                if ($('#cnpj').val() != '' || $("#idt_tipo_empreendimento").val() == 7 || $("#idt_tipo_empreendimento").val() == 13) {
                    if (CalculaCNPJ($('#cnpj').val()) === true || $("#idt_tipo_empreendimento").val() == 7 || $("#idt_tipo_empreendimento").val() == 13) {
                        if ($("#idt_tipo_empreendimento").val() == 7) {
                            if ($('#razao_social').val() == '' && $('#nome_fantasia').val() == '' && $('#cnpj').val() == '' && $('#dap').val() == '' && $('#nirf').val() == '' && $('#rmp').val() == '' && $('#ie_prod_rural').val() == '') {
                                alert('Por favor, informar um dos campos DAP, NIRF, Registro Ministério da Pesca, Inscrição Estadual, Razão Social ou Nome Fantasia para poder realzar a pesquisa!');
                                $(this).show();
                                return false;
                            }
                        }

                        if ($("#idt_tipo_empreendimento").val() == 13) {
                            if ($('#sicab_codigo').val() == '') {
                                alert('Por favor, informar um dos campos SICAB, Razão Social ou Nome Fantasia para poder realzar a pesquisa!');
                                $(this).show();
                                return false;
                            }
                        }

                        processando();

                        $.ajax({
                            type: 'POST', url: 'ajax_atendimento.php?tipo=BuscaCNPJ_GEC',
                            data: {
                                cas: conteudo_abrir_sistema,
                                idt_tipo_empreendimento: $('#idt_tipo_empreendimento').val(),
                                cnpj: $('#cnpj').val(),
                                dap: $('#dap').val(),
                                nirf: $('#nirf').val(),
                                rmp: $('#rmp').val(),
                                ie_prod_rural: $('#ie_prod_rural').val(),
                                sicab_codigo: $('#sicab_codigo').val(),
                                razao_social: $('#razao_social').val(),
                                nome_fantasia: $('#nome_fantasia').val(),
                                idt: '<?php echo $_GET['id']; ?>'
                            },
                            success: function (response) {
                                var idt = parseInt(response);

                                if (isNaN(idt)) {
                                    if (response.substr(0, 18) == 'codparceiro_lista=') {
                                        var par = '';
                                        par += '?prefixo=listar_cmb';
                                        par += '&menu=siacweb_parceiro';
                                        par += '&cas=' + conteudo_abrir_sistema;
                                        par += '&codparceiro_lista=' + response.substr(18);
                                        var url = 'conteudo_cadastro.php' + par;
                                        showPopWin(url, 'Busca Entidade', $('div.showPopWin_width').width() - 30, $(window).height() - 100, BuscaCodparceiro_listaClose, false);
                                    } else {
                                        $("#dialog-processando").remove();
                                        alert(response);
                                    }
                                } else if (idt == 0) {
                                    if ($('#cnpj').prop("disabled")) {
                                        $("#dialog-processando").remove();
                                        alert('Registro não localizado nas bases de pesquisas!');
                                    } else {
                                        var par = '';
                                        par += '?prefixo=listar_cmb';
                                        par += '&menu=gec_entidade_grc_atendimento_organizacao';
                                        par += '&cas=' + conteudo_abrir_sistema;
                                        par += '&entidade_texto_cnpj=' + url_encode($('#cnpj').val());
                                        par += '&entidade_dap=' + url_encode($('#dap').val());
                                        par += '&entidade_nirf=' + url_encode($('#nirf').val());
                                        par += '&entidade_rmp=' + url_encode($('#rmp').val());
                                        par += '&entidade_ie_prod_rural=' + url_encode($('#ie_prod_rural').val());
                                        par += '&entidade_sicab_codigo=' + url_encode($('#sicab_codigo').val());
                                        par += '&entidade_texto_nome=' + url_encode($('#razao_social').val());
                                        par += '&entidade_texto_fantasia=' + url_encode($('#nome_fantasia').val());
                                        var url = 'conteudo_cadastro.php' + par;
                                        showPopWin(url, 'Busca Entidade', $('div.showPopWin_width').width() - 30, $(window).height() - 100, BuscaCNPJClose, false);
                                    }
                                } else {
                                    libera_bt = false;

                                    var url = self.location.href;
                                    url = url.replace('&id=<?php echo $id_org; ?>', '&id=' + idt);
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
                    }
                } else {
                    var par = '';
                    par += '?prefixo=listar_cmb';
                    par += '&menu=gec_entidade_grc_atendimento_organizacao';
                    par += '&cas=' + conteudo_abrir_sistema;
                    par += '&entidade_texto_cnpj=' + url_encode($('#cnpj').val());
                    par += '&entidade_dap=' + url_encode($('#dap').val());
                    par += '&entidade_nirf=' + url_encode($('#nirf').val());
                    par += '&entidade_rmp=' + url_encode($('#rmp').val());
                    par += '&entidade_ie_prod_rural=' + url_encode($('#ie_prod_rural').val());
                    par += '&entidade_sicab_codigo=' + url_encode($('#sicab_codigo').val());
                    par += '&entidade_texto_nome=' + url_encode($('#razao_social').val());
                    par += '&entidade_texto_fantasia=' + url_encode($('#nome_fantasia').val());
                    var url = 'conteudo_cadastro.php' + par;
                    showPopWin(url, 'Busca Entidade', $('div.showPopWin_width').width() - 30, $(window).height() - 100, BuscaCNPJClose, false);
                }

                if (libera_bt) {
                    $(this).show();
                }
            };

            var lupa = false;

            if ($("#idt_tipo_empreendimento").val() == 7) {
                if ($('#cnpj').val() == '' && $('#dap').val() == '' && $('#nirf').val() == '' && $('#rmp').val() == '' && $('#ie_prod_rural').val() == '') {
                    lupa = true;
                } else {
                    lupa = false;
                }
            } else if ($("#idt_tipo_empreendimento").val() == 13) {
                if ($('#cnpj').val() == '' && $('#sicab_codigo').val() == '') {
                    lupa = true;
                } else {
                    lupa = false;
                }
            } else {
                lupa = $('#cnpj').val() == '';
            }

            if (lupa) {
                if ('<?php echo $_GET['id']; ?>' == '0') {
                    setTimeout(function () {
                        $("#idt_tipo_empreendimento").removeProp("disabled").removeClass("campo_disabled").val(4);
                    }, 100);

                    $('#idt_tipo_empreendimento').change(function () {
                        if ($(this).val() == 7 || $(this).val() == 13) {
                            $('#razao_social, #nome_fantasia').removeProp("disabled").removeClass("campo_disabled");
                        } else {
                            $('#razao_social, #nome_fantasia').prop("disabled", true).addClass("campo_disabled").val('');
                        }
                    });
                }

                setTimeout('$("#cnpj").removeProp("disabled").removeClass("campo_disabled");', 100);
                btAcaoCNPJ = $('<img border="0" id="btBuscaCNPJ" style="margin-left: 3px; cursor: pointer; vertical-align: middle;" src="imagens/bt_pesquisa.png" title="Pesquisar">');
                btAcaoCNPJ.click(acaoBuscaCNPJ);
            } else {
                setTimeout(function () {
                    $('#bt_voltar').focus();
                    $("#cnpj").prop("disabled", true).addClass("campo_disabled");
                }, 100);


                btAcaoCNPJ = '';
            }

            $('#cnpj_obj').attr('nowrap', 'nowrap').append(btAcaoCNPJ);
        }

        $('#data_abertura').change(function () {
            if (validaDataMenor(false, $(this), 'Data Abertura', $('#dtBancoObj'), 'Hoje') === false) {
                $(this).focus();
                return false;
            }
        });

        objd = document.getElementById('idt_organizacao_txt');
        if (objd != null)
        {
            $(objd).css('fontSize', '12px');
            $(objd).css('background', '#FFFFCA');
        }

        $('#idt_tipo_empreendimento').change(function () {
            $('#tamanho_propriedade_desc, #tamanho_propriedade_obj').parent().hide();
            $('#sicab_codigo_desc, #sicab_codigo_obj').parent().hide();

            $("#cnpj_desc").addClass("Tit_Campo_Obr").removeClass("Tit_Campo");
            $("#cnpj").removeProp("disabled").removeClass("campo_disabled");

            $("#sicab_codigo_desc,#sicab_dt_validade_desc").addClass("Tit_Campo").removeClass("Tit_Campo_Obr");
            $("#dap,#nirf,#rmp,#ie_prod_rural,#sicab_codigo,#sicab_dt_validade").prop("disabled", true).addClass("campo_disabled");

            switch ($(this).val()) {
                case '7': // Produtor Rural
                    $("#cnpj_desc").addClass("Tit_Campo").removeClass("Tit_Campo_Obr");
                    $("#cnpj").prop("disabled", true).addClass("campo_disabled").val('');

                    $("#dap,#nirf,#rmp,#ie_prod_rural").removeProp("disabled").removeClass("campo_disabled");
                    $('#tamanho_propriedade_desc, #tamanho_propriedade_obj').parent().show();

                    $("#sicab_codigo,#sicab_dt_validade").val('');

                    setTimeout(function () {
                        $('#cnpj').prop("disabled", true).addClass("campo_disabled").val('');
                    }, 100);
                    break;

                case '13': // Artesão
                    $("#cnpj_desc").addClass("Tit_Campo").removeClass("Tit_Campo_Obr");
                    $("#cnpj").prop("disabled", true).addClass("campo_disabled").val('');

                    $('#sicab_codigo_desc, #sicab_codigo_obj').parent().show();
                    $("#sicab_codigo_desc,#sicab_dt_validade_desc").addClass("Tit_Campo_Obr").removeClass("Tit_Campo");
                    $("#sicab_codigo,#sicab_dt_validade").removeProp("disabled").removeClass("campo_disabled");

                    $("#dap,#nirf,#rmp,#ie_prod_rural").val('');

                    setTimeout(function () {
                        $('#cnpj').prop("disabled", true).addClass("campo_disabled").val('');
                    }, 100);
                    break;

                default:
                    if ('<?php echo $_GET['id']; ?>' == '0') {
                        setTimeout(function () {
                            $('#cnpj').removeProp("disabled").removeClass("campo_disabled");
                        }, 100);
                    }
                    break;
            }
        });

        $('#receber_informacao_e').change(function () {
            if ($(this).val() == 'S') {
                $('#idt_tipo_informacao_e_desc > table').show();
            } else {
                $('#idt_tipo_informacao_e_desc > table').hide();
            }
        });

        setTimeout(function () {
            $('#idt_entidade_tipo_emp').change();
        }, 100);

        fncListarCmbMuda_idt_cnae_principal('<?php echo $idt_cnae_principal; ?>');
    });

    function BuscaCNPJClose(returnVal) {
        $('#cnpj').val(returnVal.desc);
        btAcaoCNPJ.click();
    }

    function BuscaCodparceiro_listaClose(returnVal) {
        processando();

        $.ajax({
            type: 'POST', url: 'ajax_atendimento.php?tipo=BuscaCNPJ_GEC',
            data: {
                cas: conteudo_abrir_sistema,
                codparceiro: returnVal.valor,
                idt: '<?php echo $_GET['id']; ?>'
            },
            success: function (response) {
                var idt = parseInt(response);

                if (isNaN(idt)) {
                    $("#dialog-processando").remove();
                    alert(response);
                } else if (idt == 0) {
                    $("#dialog-processando").remove();
                    alert('Registro não localizado nas bases de pesquisas!');
                } else {
                    libera_bt = false;

                    var url = self.location.href;
                    url = url.replace('&id=<?php echo $id_org; ?>', '&id=' + idt);
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
    }

    function grc_entidade_organizacao_dep() {
        var ok = true;

        if (valida == 'S') {
            if ($('#pessoas_ocupadas').val() != '' && $('#pessoas_ocupadas').val() > 32767) {
                alert('O valor de Pessoas Ocupadas não pode ser superior a 32767!');
                $('#pessoas_ocupadas').val('');
                $('#pessoas_ocupadas').focus();
                return false;
            }

            if ($('#idt_tipo_empreendimento').val() == 6) {
                alert('Não é possível realizar atendimento a esse Tipo de Empreendimento');
                return false;
            }

            if ($('#idt_tipo_empreendimento').val() == 7) {
                if ($('#dap').val() == '' && $('#nirf').val() == '' && $('#rmp').val() == '' && $('#ie_prod_rural').val() == '') {
                    alert('Para Produtor Rural necessário informar pelo menos um dos campos - DAP, NIRF, Registro Ministério da Pesca ou IE');
                    return false;
                } else {
                    var tot = 0;

                    if ($('#dap').val() != '') {
                        tot++;
                    }

                    if ($('#nirf').val() != '') {
                        tot++;
                    }

                    if ($('#rmp').val() != '') {
                        tot++;
                    }

                    if ($('#ie_prod_rural').val() != '') {
                        tot++;
                    }

                    if (tot > 1) {
                        alert('Para Produtor Rural só pode ser informar um dos campos - DAP, NIRF, Registro Ministério da Pesca ou IE');
                        return false;
                    }
                }

                if ($('#idt_porte').val() == 5) {
                    alert('O Porte / Faixa Faturamento selecionado não é possível para Produtor Rural!');
                    $('#idt_porte').val('');
                    $('#idt_porte').focus();
                    return false;
                }
            }

            if (validaDataMenor(false, $('#data_abertura'), 'Data Abertura', $('#dtBancoObj'), 'Hoje') === false) {
                $('#data_abertura').focus();
                return false;
            }

            if ($('#telefone_comercial_e').val() == '' && $('#telefone_celular_e').val() == '' && $('#email_e').val() == '') {
                alert('Por favor, preencher um dos campos de Contato');
                return false;
            }

            if ($('#telefone_comercial_e').val() == '' && $('#telefone_celular_e').val() == '') {
                alert('Por favor, preencher um dos campos de Telefone');
                return false;
            }

            if ($('#pessoas_ocupadas').val() == 0) {
                alert('Quantidade de Pessoas Ocupadas deve ser informado com valor maior que Zero (0)');
                return false;
            }

            if ($('#idt_setor').val() == '') {
                alert('Favor selecionar uma Atividade Econômica Principal com setor associado!');
                return false;
            }

            if ($('#logradouro_codbairro_e').val() == '' || $('#logradouro_codcid_e').val() == '' || $('#logradouro_codest_e').val() == '' || $('#logradouro_codpais_e').val() == '') {
                alert('Por favor, informar um CEP válido no SiacWeb!');
                return false;
            }

            $('#idt_tipo_informacao_e_lista > option').each(function () {
                if (ok) {
                    var idt = $(this).val().substr(1);

                    switch (idt) {
                        case '1': //Deseja receber ligações
                            if ($('#telefone_comercial_e').val() == '') {
                                alert('Por favor, preencher um dos campo de Telefone Comercial');
                                ok = false;
                            }
                            break;

                        case '2': //Deseja receber mala direta
                            if ($('#logradouro_cep_e').val() == '') {
                                alert('Por favor, preencher o campo de Endereço');
                                $('#logradouro_cep_e').focus();
                                ok = false;
                            }
                            break;

                        case '3': //Deseja receber emails
                            if ($('#email_e').val() == '') {
                                alert('Por favor, preencher o campo de Endereço de e-mail');
                                $('#email_e').focus();
                                ok = false;
                            }
                            break;

                        case '4': //Deseja receber SMS
                            if ($('#telefone_celular_e').val() == '') {
                                alert('Por favor, preencher um dos campo de Telefone Celular');
                                ok = false;
                            }
                            break;

                        case '5': //Pelo Telefone de Recados
                            if ($('#telefone_comercial_e').val() == '' && $('#telefone_celular_e').val() == '') {
                                alert('Por favor, preencher um dos campo de Telefone Comercial ou Telefone Celular');
                                ok = false;
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
                    url: 'ajax_atendimento.php?tipo=validacaoDadosOrganizacao',
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

    function fncListarCmbMuda_idt_cnae_principal(idt_cnae_principal) {
        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=cnae_setor',
            data: {
                cas: conteudo_abrir_sistema,
                idt_cnae_principal: idt_cnae_principal
            },
            success: function (response) {
                $('#idt_setor').val(url_decode(response.idt));
                $('#idt_setor_tf').text(url_decode(response.txt));

                $("#dialog-processando").remove();

                if (response.erro != '') {
                    alert(url_decode(response.erro));
                } else if ($('#idt_setor').val() == '' && idt_cnae_principal != '') {
                    alert('Atividade Econômica Principal sem setor associado no SiacWeb!');
                    $('#idt_cnae_principal_bt_limpar').click();
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

    function btAcaoVoltar() {
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php?tipo=grc_entidade_organizacao_volta',
            data: {
                cas: conteudo_abrir_sistema,
                idt: '<?php echo $_GET['id']; ?>'
            },
            success: function (response) {
                if (response.erro == '') {
                    self.location = $('#bt_volta_href').val();
                } else {
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });
    }
</script>