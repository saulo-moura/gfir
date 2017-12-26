<?php
$tabela = 'db_pir_siac.parceiro';
$id = 'CodParceiro';
//$id = 'idt';

$vetCampo['CodParceiro']       = objInteiro('CodParceiro', 'Cod.Parceiro', false, 11, 11);
$vetCampo['TipoParceiro']      = objTexto('TipoParceiro', 'Tipo', false, 1, 1);
$vetCampo['CgcCpf']            = objTexto('CgcCpf', 'CNPJ/CPF', false, 15, 45);
$vetCampo['NomeAbrevFantasia'] = objTexto('NomeAbrevFantasia', 'Nome Fantasia / Abreviado', False, 50, 120,'width:800px;');
$vetCampo['NomeRazaoSocial']   = objTexto('NomeRazaoSocial', 'Nome ou Razão Social', false, 50, 80,'width:800px;');
$vetCampo['IndAtu']            = objInteiro('IndAtu', 'Ind.Atualização', false, 11, 11);
$vetCampo['DataInc']           = objDataHora('DataInc', 'Data Inclusão', false, $js);
$vetCampo['DataAtu']           = objDataHora('DataAtu', 'Data Atualização', false, $js);
$vetCampo['CodUnidOperInc']    = objInteiro('CodUnidOperInc', 'Cod.Unidade Operacional (Inclusão)', false, 11, 11);
$vetCampo['CodUnidOperAtu']    = objInteiro('CodUnidOperAtu', 'Cod.Unidade Operacional (Atualização)', false, 11, 11);
$vetCampo['Tipo']              = objInteiro('Tipo', 'Tipo', false, 11, 11);
$vetCampo['IndAtualizacao']    = objInteiro('IndAtualizacao', 'Ind.Atualização (outro)', false, 11, 11);

$sql  = "select codsebrae, descsebrae from db_pir_siac.sebrae ";
$sql .= " order by descsebrae";
$vetCampo['codsebrae']         = objCmbBanco('codsebrae', 'Sebrae Responsável', false, $sql,' ','width:200px;');

$vetCampo['CodResponsavel']    = objInteiro('CodResponsavel', 'Responsavel', false, 11, 11);
$vetCampo['ReceberInfoSEBRAE'] = objTexto('ReceberInfoSEBRAE', 'Receber Informação SEBRAE', false, 1, 1);
$vetCampo['Situacao']          = objInteiro('Situacao', 'Situacao', false, 11, 11);
$vetCampo['CodCRM']            = objTexto('CodCRM', 'Cod.CRM', false, 16, 16);
$vetCampo['ControleRede']      = objInteiro('ControleRede', 'Controle de Rede', false, 11, 11);


//$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
//$vetCampo['ResumoConteudo']  = objTextArea('ResumoConteudo', 'Resumo', false, $maxlength, $style, $js);
//$vetCampo['CorpoTexto']      = objHtml('CorpoTexto', 'Corpo Texto', false,'360px','','',True);
//$vetCampo['TipoConteudo']    = objCmbVetor('TipoConteudo', 'Tipo Conteudo', false, $vetConteudoBIATipoConteudo);



$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['CodParceiro'],'',$vetCampo['CgcCpf'],'',$vetCampo['TipoParceiro'],'',$vetCampo['Situacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Nome ou Razão Social</span>', Array(
    Array($vetCampo['NomeRazaoSocial']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Nome de fantasia ou Resumo</span>', Array(
    Array($vetCampo['NomeAbrevFantasia']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>SEBRAE</span>', Array(
    Array($vetCampo['codsebrae'],'',$vetCampo['CodResponsavel'],'',$vetCampo['ReceberInfoSEBRAE']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Atualização</span>', Array(
    Array($vetCampo['IndAtu'],'',$vetCampo['DataInc'],'',$vetCampo['DataAtu']),
    Array($vetCampo['IndAtualizacao'],'',$vetCampo['CodUnidOperInc'],'',$vetCampo['CodUnidOperAtu']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Outros</span>', Array(
    Array($vetCampo['Tipo'],'',$vetCampo['CodCRM'],'',$vetCampo['ControleRede']),
),$class_frame,$class_titulo,$titulo_na_linha);



// INÍCIO

// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE PARCEIROS
// PESSOA FÍSICA
//____________________________________________________________________________


$vetParametros = Array(
    'codigo_frm' => 'siac_parceiro_pessoafw',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>01 - Pessoa Física</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();
//Monta o vetor de Campo
//Monta o vetor de Campo
$vetCampo['NomeMae']    = CriaVetTabela('Nome da Mãe');
$vetCampo['EstCivil']   = CriaVetTabela('Estado Civil');
$vetCampo['Identidade'] = CriaVetTabela('Identidade');
$vetCampo['OrgEmis']    = CriaVetTabela('Orgão Emis.');
$vetCampo['DataNasc']   = CriaVetTabela('Data Nascimento',data);

// Parametros da tela full conforme padrão

$titulo = 'Pessoa Física';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "db_pir_siac.pessoaf";
$AliasPric        = "siac_pf";
$Entidade         = "Pessoa Física";
$Entidade_p       = "Pessoas Fisicas";


// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.NomeMae ";

$sql  = "select {$AliasPric}.* ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//
$sql .= " where {$AliasPric}".'.CodParceiro = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full  siac_parceiro_pessoaf ( programa full screen)

$vetCampo['siac_parceiro_pessoaf'] = objListarConf('siac_parceiro_pessoaf', 'siac_pf.CodParceiro', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'siac_parceiro_pessoafw',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['siac_parceiro_pessoaf']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________


// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE PARCEIROS
// PESSOA Juridica
//____________________________________________________________________________


$vetParametros = Array(
    'codigo_frm' => 'siac_parceiro_pessoajw',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>02 - Pessoa Jurídica</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();
//Monta o vetor de Campo
//Monta o vetor de Campo
$vetCampo['incest']                 = CriaVetTabela('Inscrição Estadual');
$vetCampo['inscmun']                = CriaVetTabela('Inscrição Municipal');
$vetCampo['databert']               = CriaVetTabela('Abertura',data);
$vetCampo['datafech']               = CriaVetTabela('Fechamento',data);
$vetCampo['OptanteSimplesNacional'] = CriaVetTabela('Op. Simples?');

// Parametros da tela full conforme padrão

$titulo = 'Pessoa Jurídica';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "db_pir_siac.pessoaj";
$AliasPric        = "siac_pj";
$Entidade         = "Pessoa Jurídica";
$Entidade_p       = "Pessoas Jurídica";


// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.databert ";

$sql  = "select {$AliasPric}.* ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//
$sql .= " where {$AliasPric}".'.CodParceiro = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full  siac_parceiro_pessoaf ( programa full screen)

$vetCampo['siac_parceiro_pessoaj'] = objListarConf('siac_parceiro_pessoaj', 'siac_pj.CodParceiro', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'siac_parceiro_pessoajw',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['siac_parceiro_pessoaj']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________


// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE PARCEIROS
// ENDEREÇOS
//____________________________________________________________________________


$vetParametros = Array(
    'codigo_frm' => 'siac_parceiro_enderecow',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>03 - Endereços</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();
//Monta o vetor de Campo
$vetCampo['NumSeqEnd']    = CriaVetTabela('Seq.');
$vetCampo['CodLogr']      = CriaVetTabela('Cod');
$vetCampo['DescEndereco'] = CriaVetTabela('Endereço');
$vetCampo['Numero']       = CriaVetTabela('Nº');
$vetCampo['Complemento']  = CriaVetTabela('Complemento.');
$vetCampo['CodBairro']    = CriaVetTabela('Bairro');
$vetCampo['CodCid']       = CriaVetTabela('Cidade');
$vetCampo['CodEst']       = CriaVetTabela('Estado');
$vetCampo['CodPais']      = CriaVetTabela('Pais');
$vetCampo['CEP']          = CriaVetTabela('CEP');


// Parametros da tela full conforme padrão

$titulo = 'Endereços';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "db_pir_siac.endereco";
$AliasPric        = "siac_pe";
$Entidade         = "Endereço";
$Entidade_p       = "Endereços";


// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.NumSeqEnd ";

$sql  = "select {$AliasPric}.* ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//
$sql .= " where {$AliasPric}".'.CodParceiro = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full  siac_parceiro_pessoaf ( programa full screen)

$vetCampo['siac_parceiro_endereco'] = objListarConf('siac_parceiro_endereco', 'siac_pe.CodParceiro', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'siac_parceiro_enderecow',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['siac_parceiro_endereco']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________


// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE PARCEIROS
// COMUNICAÇÃO
//____________________________________________________________________________


$vetParametros = Array(
    'codigo_frm' => 'siac_parceiro_comunicacaow',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>04 - Comunicações</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();

//Monta o vetor de Campo
$vetCampo['numseqcom']    = CriaVetTabela('Nº');
$vetCampo['desc_comunic']   = CriaVetTabela('Tipo Comunicação');
$vetCampo['numero'] = CriaVetTabela('Número');
$vetCampo['IndInternet']    = CriaVetTabela('Ind.Internet');


// Parametros da tela full conforme padrão

$titulo = 'Comunicação';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "db_pir_siac.comunicacao";
$AliasPric        = "siac_pc";
$Entidade         = "Comunicacao";
$Entidade_p       = "Comunicações";


// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.numseqcom ";
$sql  = "select {$AliasPric}.* , desccomunic as desc_comunic";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " left  join db_pir_siac.tipocomunic tp on tp.codcomunic = {$AliasPric}.codcomunic ";

$sql .= " where {$AliasPric}".'.CodParceiro = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full  siac_parceiro_pessoaf ( programa full screen)

$vetCampo['siac_parceiro_comunicacao'] = objListarConf('siac_parceiro_comunicacao', 'siac_pc.CodParceiro', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'siac_parceiro_comunicacaow',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['siac_parceiro_comunicacao']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________



// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE PARCEIROS
// ATIVIDADE ECONOMICA
//____________________________________________________________________________


$vetParametros = Array(
    'codigo_frm' => 'siac_parceiro_ativeconpjw',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>05 - Atividades Econômicas</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();

//Monta o vetor de Campo
$vetCampo['CodClass']            = CriaVetTabela('Classe');
$vetCampo['cnae_DescCnaeFiscal'] = CriaVetTabela('Atividade Economica');
$vetCampo['AtivPrinc']           = CriaVetTabela('Atividade Principal');
$vetCampo['IndAtivPrincipal']    = CriaVetTabela('Ind.Ativ.Principal');
$vetCampo['CodCnaeFiscal']       = CriaVetTabela('CNAE');


// Parametros da tela full conforme padrão

$titulo = 'Atividade Econômica';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "db_pir_siac.ativeconpj";
$AliasPric        = "siac_pae";
$Entidade         = "Atividade Economica";
$Entidade_p       = "Atividades Economicas";
$CampoPricPai     = "CodParceiro";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "cnae.DescCnaeFiscal ";

$sql   = "select ";
$sql  .= "   {$AliasPric}.*, ";
$sql  .= "    cnae.DescCnaeFiscal as cnae_DescCnaeFiscal ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " left join db_pir_siac.cnaefiscal cnae on cnae.CodAtivEcon = {$AliasPric}.CodAtivEcon ";

//
$sql .= " where {$AliasPric}".'.CodParceiro = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full  siac_parceiro_pessoaf ( programa full screen)

$vetCampo['siac_parceiro_ativeconpj'] = objListarConf('siac_parceiro_ativeconpj', 'siac_phrc.CodParceiro', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'siac_parceiro_ativeconpjw',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['siac_parceiro_ativeconpj']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________





// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE PARCEIROS
// HISRORICO DE REALIZAÇÕES DO CLIENTE
//____________________________________________________________________________


$vetParametros = Array(
    'codigo_frm' => 'siac_parceiro_historicorealizacoesclientew',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>06 - Histórico de Realizações do Cliente</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();

//Monta o vetor de Campo
$vetCampo['siac_s_descsebrae'] = CriaVetTabela('SEBRAE');
$vetCampo['DataHoraInicioRealizacao']   = CriaVetTabela('Inicio Realização',data);
$vetCampo['DataHoraFimRealizacao']   = CriaVetTabela('Fim Realização',data);
$vetCampo['NomeRealizacao']    = CriaVetTabela('Nome da Realização');


// Parametros da tela full conforme padrão

$titulo = 'Histórico';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "db_pir_siac.historicorealizacoescliente";
$AliasPric        = "siac_phrc";
$Entidade         = "Histórico Realizações Cliente";
$Entidade_p       = "Históricos Realizações Cliente";


// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.DataHoraInicioRealizacao ";

$sql   = "select ";
$sql  .= "   {$AliasPric}.* ,";
$sql  .= "    siac_s.descsebrae as siac_s_descsebrae ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " left join db_pir_siac.sebrae siac_s on siac_s.codsebrae = {$AliasPric}.CodSebrae ";

//
$sql .= " where {$AliasPric}".'.CodCliente = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full  siac_parceiro_pessoaf ( programa full screen)

$vetCampo['siac_parceiro_historicorealizacoescliente'] = objListarConf('siac_parceiro_historicorealizacoescliente', 'siac_phrc.CodParceiro', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'siac_parceiro_historicorealizacoesclientew',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['siac_parceiro_historicorealizacoescliente']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________






















/*


// INÍCIO

// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________


$vetParametros = Array(
    'codigo_frm' => 'bia_conteudobiasubmenuw',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>07 - Sub Menu</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();
//Monta o vetor de Campo
$vetCampo['bia_s_descsebrae'] = CriaVetTabela('Sebrae');
//$vetCampo['bia_sm_Ordem'] = CriaVetTabela('Ordem');
$vetCampo['bia_sm_TituloSubMenu'] = CriaVetTabela('Título Sub Menu');


// Parametros da tela full conforme padrão

$titulo = 'Sub Menus';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "bia_conteudobiasubmenu";
$AliasPric        = "bia_cbsm";
$Entidade         = "Sub Menu do Conteúdo";
$Entidade_p       = "Sub Menus do Conteúdo";

$AliasSebrae      = "bia_sm";


// Select para obter campos da tabela que serão utilizados no full

$orderby = "bia_s.descsebrae, bia_sm.Ordem, bia_sm.TituloSubMenu ";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "       bia_sm.TituloSubMenu as bia_sm_TituloSubMenu, ";
$sql  .= "       bia_sm.Ordem         as bia_sm_Ordem, ";
$sql  .= "       bia_s.descsebrae     as bia_s_descsebrae  ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join bia_submenubia bia_sm on bia_sm.idt = {$AliasPric}.idt_submenubia ";
$sql .= " inner join bia_sebrae     bia_s  on bia_s.idt  = {$AliasSebrae}.idt_sebrae ";

$sql .= " where {$AliasPric}".'.idt_conteudobia = $vlID';
$sql .= "   and  bia_s.idt = 17 ";


$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full

$vetCampo['bia_conteudobiasubmenu'] = objListarConf('bia_conteudobiasubmenu', 'idt', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'bia_conteudobiasubmenuw',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['bia_conteudobiasubmenu']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________


 */

$vetCad[] = $vetFrm;
?>
