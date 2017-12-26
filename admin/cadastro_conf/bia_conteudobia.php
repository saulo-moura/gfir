<?php
$tabela = 'bia_conteudobia';
$id = 'idt';
$vetCampo['CodConteudo']         = objTexto('CodConteudo', 'C�digo', True, 10, 45);
$vetCampo['TituloConteudo']      = objTexto('TituloConteudo', 'T�tulo', True, 60, 60);
$vetCampo['SubTituloConteudo']   = objTexto('SubTituloConteudo', 'Sub T�tulo', false, 60, 155,'width:400px;');

//$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['ResumoConteudo']  = objTextArea('ResumoConteudo', 'Resumo', false, $maxlength, $style, $js);
$vetCampo['CorpoTexto']      = objHtml('CorpoTexto', 'Corpo Texto', false,'360px','','',True);

$vetCampo['Fonte']           = objTexto('Fonte', 'Fonte', false, 45, 80);
$vetCampo['TipoAutor']       = objTexto('TipoAutor', 'Tipo Autor', false, 1, 1);
$vetCampo['Autor']           = objTexto('Autor', 'Autor', false, 45, 80);

$vetCampo['TipoConteudo']    = objCmbVetor('TipoConteudo', 'Tipo Conteudo', false, $vetConteudoBIATipoConteudo);

$vetCampo['StatusPublicacao']= objCmbVetor('StatusPublicacao', 'Status Publica��o', false, $vetConteudoBIAStatus);
$vetCampo['Situacao']        = objCmbVetor('Situacao', 'Situa��o', false, $vetConteudoBIASituacao);


$vetCampo['DataCadastro']      = objDataHora('DataCadastro', 'Data Cadastro', false, $js);
$vetCampo['DataAtualizacao']   = objDataHora('DataAtualizacao', 'Data Atualiza��o', false, $js);
$vetCampo['DataExpiracao']     = objDataHora('DataExpiracao', 'Data Expira��o', false, $js);
$vetCampo['DataExclusao']      = objDataHora('DataExclusao', 'Data Exclus�o', false, $js);

$jst    = " readonly='true' style='background:{$corbloq}; font-size:12px; color:#ECF0F1' ";

$vetCampo['SEBRAEResp']              = objInteiro('SEBRAEResp', 'SEBRAE Responsavel', false, 11, 11);
//$vetCampo['CodResponsavel']          = objInteiro('CodResponsavel', 'Cod.Responsavel', false, 11, 11);
$vetCampo['CodResponsavel']          = objTexto('CodResponsavel', 'Cod.Responsavel', false, 11, 11, $jst);
$vetCampo['DescResponsavel']         = objTexto('DescResponsavel', 'Respons�vel', false, 70, 120, $jst);
//$vetCampo['CodUsuarioResponsavel']   = objInteiro('CodUsuarioResponsavel', 'Cod.Usuario Responsavel', false, 11, 11);
$vetCampo['CodUsuarioResponsavel']   = objTexto('CodUsuarioResponsavel', 'Cod.Usuario Responsavel', false, 11, 11, $jst);
$vetCampo['DescUsuarioResponsavel']  = objTexto('DescUsuarioResponsavel', 'Usu�rio Respons�vel', false, 70, 120, $jst);

$vetCampo['DireitosAutorais']  = objTexto('DireitosAutorais', 'Direitos Autorais', false, 55, 255);
$vetCampo['Contribuidor']      = objTexto('Contribuidor', 'Contribuidor', false, 55, 255);

$vetCampo['DataPublicacao']    = objDataHora('DataPublicacao', 'Data Publica��o', false, $js);

$vetCampo['SituacaoVersao']    = objTexto('SituacaoVersao', 'Situa��o da Vers�o', false, 1, 1);

$vetCampo['CodConteudoOriginal']= objInteiro('CodConteudoOriginal', 'Cod.Conte�do Original', false, 11, 11);

$vetCampo['SugestaoIlustracao']= objTextArea('SugestaoIlustracao', 'Sugest�o Ilustra��o', false, $maxlength, $style, $js);

$sql  = "select idt, descsebrae from bia_sebrae ";
$sql .= " order by descsebrae";
$vetCampo['idt_sebrae']       = objCmbBanco('idt_sebrae', 'Sebrae Respons�vel', true, $sql,' ','width:200px;');


$vetFrm = Array();
$vetFrm[] = Frame('<span>Identifica��o</span>', Array(
    Array($vetCampo['CodConteudo'],'',$vetCampo['TituloConteudo']),
    Array('','',$vetCampo['SubTituloConteudo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo Conteudo</span>', Array(
    Array($vetCampo['ResumoConteudo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Corpo do Texto</span>', Array(
    Array($vetCampo['CorpoTexto']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Fonte/Autor</span>', Array(
    Array($vetCampo['Fonte'],'',$vetCampo['TipoAutor'],'',$vetCampo['Autor']),
    Array($vetCampo['TipoConteudo'],'',$vetCampo['StatusPublicacao'],'',$vetCampo['Situacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

 $vetFrm[] = Frame('<span>Datas</span>', Array(
    Array($vetCampo['DataCadastro'],'',$vetCampo['DataAtualizacao'],'',$vetCampo['DataExpiracao'],'',$vetCampo['DataExclusao']),
),$class_frame,$class_titulo,$titulo_na_linha);

 $vetFrm[] = Frame('<span>Responsaveis</span>', Array(
    Array($vetCampo['idt_sebrae'],'',$vetCampo['SEBRAEResp']),
    Array($vetCampo['CodResponsavel'],'',$vetCampo['DescResponsavel']),
    Array($vetCampo['CodUsuarioResponsavel'],'',$vetCampo['DescUsuarioResponsavel']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Direitos Autorais/Contribuidor</span>', Array(
    Array($vetCampo['DireitosAutorais'],'',$vetCampo['Contribuidor']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('<span>Informa��es Complementares</span>', Array(
    Array($vetCampo['DataPublicacao'],'',$vetCampo['SituacaoVersao'],'',$vetCampo['CodConteudoOriginal']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Sugest�o Ilustra��o</span>', Array(
    Array($vetCampo['SugestaoIlustracao']),
),$class_frame,$class_titulo,$titulo_na_linha);


// IN�CIO

// DEFINI��O DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________


$vetParametros = Array(
    'codigo_frm' => 'bia_conteudotermovcsw',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>01 - Termos</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Defini��o de campos formato full que ser�o editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();
//Monta o vetor de Campo
$vetCampo['CodTermo']    = CriaVetTabela('C�digo do Termo');
$vetCampo['DescTermo'] = CriaVetTabela('Descri��o do Termo');

// Parametros da tela full conforme padr�o

$titulo = 'Termos';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "bia_conteudotermovcs";
$AliasPric        = "bia_ct";
$Entidade         = "Termo do Conte�do";
$Entidade_p       = "Termos do Conte�do";

// Select para obter campos da tabela que ser�o utilizados no full

$orderby = "{$AliasPric}.DescTermo ";

$sql  = "select {$AliasPric}.* ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//
$sql .= " where {$AliasPric}".'.idt_conteudo = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que ser�o editados na tela full

$vetCampo['bia_conteudotermovcs'] = objListarConf('bia_conteudotermovcs', 'idt', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'bia_conteudotermovcsw',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['bia_conteudotermovcs']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________



// IN�CIO

// DEFINI��O DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________

$vetParametros = Array(
    'codigo_frm' => 'bia_conteudobiaestadow',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>02 - Estados</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Defini��o de campos formato full que ser�o editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();
//Monta o vetor de Campo
//$vetCampo['CodTermo']    = CriaVetTabela('C�digo do Termo');
//$vetCampo['DescTermo'] = CriaVetTabela('Descri��o do Termo');

$vetCampo['bia_e_DescEst'] = CriaVetTabela('Descri��o');


// Parametros da tela full conforme padr�o

$titulo = 'Estados';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "bia_conteudobiaestado";
$AliasPric        = "bia_cbe";
$Entidade         = "Estado do Conte�do";
$Entidade_p       = "Estados do Conte�do";

// Select para obter campos da tabela que ser�o utilizados no full

$orderby = " bia_e.DescEst ";


$sql  = "select {$AliasPric}.*, ";
$sql  .= "       bia_e.DescEst as bia_e_DescEst ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join bia_estado bia_e on bia_e.idt = {$AliasPric}.idt_estado ";

$sql .= " where {$AliasPric}".'.idt_conteudobia = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que ser�o editados na tela full

$vetCampo['bia_conteudobiaestado'] = objListarConf('bia_conteudobiaestado', 'idt', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'bia_conteudobiaestadow',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['bia_conteudobiaestado']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________




// IN�CIO

// DEFINI��O DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________




$vetParametros = Array(
    'codigo_frm' => 'bia_conteudobiaanexosw',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>03 - Anexos</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Defini��o de campos formato full que ser�o editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


//Monta o vetor de Campo
$vetCampo = Array();
$vetCampo['NomeArquivo']  = CriaVetTabela('Nome do Arquivo');
$vetCampo['CodIdioma']    = CriaVetTabela('C�digo Idioma');
$vetCampo['Descricao']    = CriaVetTabela('Descri��o');

// Parametros da tela full conforme padr�o

$titulo = 'Anexos';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "bia_conteudobiaanexos";
$AliasPric        = "bia_cba";
$Entidade         = "Anexo do Conte�do";
$Entidade_p       = "Anexos do Conte�do";

// Select para obter campos da tabela que ser�o utilizados no full

$orderby = "{$AliasPric}.Descricao ";

$sql  = "select {$AliasPric}.* ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";

$sql .= " where {$AliasPric}".'.idt_conteudobia = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que ser�o editados na tela full

$vetCampo['bia_conteudobiaanexos'] = objListarConf('bia_conteudobiaanexos', 'idt', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'bia_conteudobiaanexosw',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['bia_conteudobiaanexos']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________



// IN�CIO

// DEFINI��O DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________




$vetParametros = Array(
    'codigo_frm' => 'bia_conteudobiaagentesw',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>04 - Agentes</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Defini��o de campos formato full que ser�o editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


//Monta o vetor de Campo
$vetCampo = Array();
$vetCampo['descricao_sebrae']    = CriaVetTabela('SEBRAE');
$vetCampo['SituacaoVersao'] = CriaVetTabela('Situa��o/Vers�o');
$vetCampo['StatusPublicacao'] = CriaVetTabela('Status Publica��o');
$vetCampo['DataCadastro'] = CriaVetTabela('Data Cadastro',data);
$vetCampo['DataAtualizacao'] = CriaVetTabela('Data Atualiza��o',data);

// Parametros da tela full conforme padr�o

$titulo = 'Agentes';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "bia_conteudobiaagentes";
$AliasPric        = "bia_ca";
$Entidade         = "Agente do Conte�do";
$Entidade_p       = "Agente do Conte�do";

// Select para obter campos da tabela que ser�o utilizados no full

$orderby = "{$AliasPric}.CodConteudo ";

$sql  = "select {$AliasPric}.*, descsebrae as descricao_sebrae";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join bia_sebrae bia_se on bia_se.idt = {$AliasPric}.idt_sebrae ";

$sql .= " where {$AliasPric}".'.idt_conteudobia = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que ser�o editados na tela full

$vetCampo['bia_conteudobiaagentes'] = objListarConf('bia_conteudobiaagentes', 'idt', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'bia_conteudobiaagentesw',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['bia_conteudobiaagentes']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________




// DEFINI��O DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________

$vetParametros = Array(
    'codigo_frm' => 'bia_conteudobiacompsetorialw',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>05 - CompSetorial</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Defini��o de campos formato full que ser�o editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


//Monta o vetor de Campo
$vetCampo = Array();
$vetCampo['descricao_setor_prioritario'] = CriaVetTabela('Setor Priorit�rio');
$vetCampo['SituacaoVersao'] = CriaVetTabela('Situa��o/Vers�o');
$vetCampo['StatusPublicacao'] = CriaVetTabela('Status Publica��o');
$vetCampo['DataCadastro'] = CriaVetTabela('Data Cadastro',data);
$vetCampo['DataAtualizacao'] = CriaVetTabela('Data Atualiza��o',data);

// Parametros da tela full conforme padr�o

$titulo = 'Comp Setorial';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "bia_conteudobiacompsetorial";
$AliasPric        = "bia_cbcs";
$Entidade         = "Comp Setorial do Conte�do";
$Entidade_p       = "Comp Setorial do Conte�do";

// Select para obter campos da tabela que ser�o utilizados no full

$orderby = "{$AliasPric}.CodConteudo ";

$sql  = "select {$AliasPric}.*, DescSetorPrioritario as descricao_setor_prioritario";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join bia_setorprioritario bia_sp on bia_sp.idt = {$AliasPric}.idt_setorprioritario ";

$sql .= " where {$AliasPric}".'.idt_conteudobia = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que ser�o editados na tela full

$vetCampo['bia_conteudobiacompsetorial'] = objListarConf('bia_conteudobiacompsetorial', 'idt', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'bia_conteudobiacompsetorialw',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['bia_conteudobiacompsetorial']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________



// IN�CIO

// DEFINI��O DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________




$vetParametros = Array(
    'codigo_frm' => 'bia_conteudobiamomentovidaw',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>06 - Momento Vida</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Defini��o de campos formato full que ser�o editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();
//Monta o vetor de Campo
$vetCampo['bia_mv_DescMomentoVida'] = CriaVetTabela('Descri��o');


// Parametros da tela full conforme padr�o

$titulo = 'Momentos Vida';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "bia_conteudobiamomentovida";
$AliasPric        = "bia_cbmv";
$Entidade         = "Momento Vida do Conte�do";
$Entidade_p       = "Momentos Vida do Conte�do";

// Select para obter campos da tabela que ser�o utilizados no full

$orderby = "bia_mv.DescMomentoVida ";


$sql  = "select {$AliasPric}.*, ";
$sql  .= "       bia_mv.DescMomentoVida as bia_mv_DescMomentoVida ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join bia_momentovida bia_mv on bia_mv.idt = {$AliasPric}.idt_momentovida ";

$sql .= " where {$AliasPric}".'.idt_conteudobia = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que ser�o editados na tela full

$vetCampo['bia_conteudobiamomentovida'] = objListarConf('bia_conteudobiamomentovida', 'idt', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'bia_conteudobiamomentovidaw',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['bia_conteudobiamomentovida']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________


// IN�CIO

// DEFINI��O DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________


$vetParametros = Array(
    'codigo_frm' => 'bia_conteudobiasubmenuw',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>07 - Sub Menu</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Defini��o de campos formato full que ser�o editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();
//Monta o vetor de Campo
$vetCampo['bia_s_descsebrae'] = CriaVetTabela('Sebrae');
//$vetCampo['bia_sm_Ordem'] = CriaVetTabela('Ordem');

$vetCampo['bia_m_TituloMenu'] = CriaVetTabela('T�tulo Menu');

$vetCampo['bia_sm_TituloSubMenu'] = CriaVetTabela('T�tulo Sub Menu');


// Parametros da tela full conforme padr�o

$titulo = 'Sub Menus';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "bia_conteudobiasubmenu";
$AliasPric        = "bia_cbsm";
$Entidade         = "Sub Menu do Conte�do";
$Entidade_p       = "Sub Menus do Conte�do";

$AliasSebrae      = "bia_sm";


// Select para obter campos da tabela que ser�o utilizados no full

$orderby = "bia_s.descsebrae, bia_sm.Ordem, bia_sm.TituloSubMenu ";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "       bia_sm.TituloSubMenu as bia_sm_TituloSubMenu, ";
$sql  .= "       bia_sm.Ordem         as bia_sm_Ordem, ";

//$sql  .= "       bia_sm.idt_submenubia as bia_sm_idt_submenubia, ";
$sql  .= "       bia_m.TituloMenu      as bia_m_TituloMenu, ";

$sql  .= "       bia_s.descsebrae     as bia_s_descsebrae  ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join bia_submenubia bia_sm on bia_sm.idt = {$AliasPric}.idt_submenubia ";
$sql .= " inner join bia_sebrae     bia_s  on bia_s.idt  = {$AliasSebrae}.idt_sebrae ";

$sql .= " inner join bia_menubia bia_m on bia_m.idt = bia_sm.idt_menubia ";


$sql .= " where {$AliasPric}".'.idt_conteudobia = $vlID';
$sql .= "   and  bia_s.idt = 17 ";
$sql .= "    or  bia_s.idt = 29 ";


$sql .= " order by {$orderby}";

// Carrega campos que ser�o editados na tela full

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


// IN�CIO

// DEFINI��O DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________


$vetParametros = Array(
    'codigo_frm' => 'bia_conteudobiarelacionadow',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>08 - Conte�do Relacionado</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Defini��o de campos formato full que ser�o editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();
//Monta o vetor de Campo
$vetCampo['bia_cb_TituloConteudo'] = CriaVetTabela('T�tulo Conte�do Relacionado');


// Parametros da tela full conforme padr�o

$titulo = 'Conte�dos Relacionados';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "bia_conteudobiarelacionado";
$AliasPric        = "bia_cbr";
$Entidade         = "Conte�do Relacionado";
$Entidade_p       = "Conte�dos Relacionados";

// Select para obter campos da tabela que ser�o utilizados no full

$orderby = "bia_cb.TituloConteudo ";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "       bia_cb.TituloConteudo as bia_cb_TituloConteudo ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join bia_conteudobia bia_cb on bia_cb.idt = {$AliasPric}.idt_conteudobiarelacionado ";

$sql .= " where {$AliasPric}".'.idt_conteudobia = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que ser�o editados na tela full

$vetCampo['bia_conteudobiarelacionado'] = objListarConf('bia_conteudobiarelacionado', 'idt', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'bia_conteudobiarelacionadow',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['bia_conteudobiarelacionado']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________


// IN�CIO

// DEFINI��O DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________

$vetParametros = Array(
    'codigo_frm' => 'bia_conteudobiaareatematicaw',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>09 - �reas Tem�ticas</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Defini��o de campos formato full que ser�o editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();
//Monta o vetor de Campo

$vetCampo['bia_at_DescAreaTematica'] = CriaVetTabela('Descri��o');

// Parametros da tela full conforme padr�o

$titulo = '�reas Tem�ticas';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO
$TabelaPrinc      = "bia_conteudobiaareatematica";
$AliasPric        = "bia_cbat";
$Entidade         = "�rea Tem�tica do Conte�do";
$Entidade_p       = "�reas Tem�ticas do Conte�do";

// Select para obter campos da tabela que ser�o utilizados no full

$orderby = "bia_at.DescAreaTematica ";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "       bia_at.DescAreaTematica as bia_at_DescAreaTematica ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join bia_areatematica bia_at on bia_at.idt = {$AliasPric}.idt_areatematica ";

$sql .= " where {$AliasPric}".'.idt_conteudobia = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que ser�o editados na tela full

$vetCampo['bia_conteudobiaareatematica'] = objListarConf('bia_conteudobiaareatematica', 'idt', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'bia_conteudobiaareatematicaw',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['bia_conteudobiaareatematica']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________


// IN�CIO

// DEFINI��O DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________

$vetParametros = Array(
    'codigo_frm' => 'bia_conteudobiaidiomasw',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>10 - Idiomas</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Defini��o de campos formato full que ser�o editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();
//Monta o vetor de Campo

$vetCampo['CodIdioma']         = CriaVetTabela('Idioma', 'descDominio', $vetIdioma );
$vetCampo['TituloConteudo']    = CriaVetTabela('T�tulo do Conte�do');
$vetCampo['SubTituloConteudo'] = CriaVetTabela('Sub T�tulo do Conte�do');

// Parametros da tela full conforme padr�o

$titulo = 'Idiomas';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO
$TabelaPrinc      = "bia_conteudobiaidiomas";
$AliasPric        = "bia_cbi";
$Entidade         = "Idioma do Conte�do";
$Entidade_p       = "Idiomas do Conte�do";

// Select para obter campos da tabela que ser�o utilizados no full

$orderby = "{$AliasPric}.TituloConteudo ";

$sql  = "select {$AliasPric}.* ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";

$sql .= " where {$AliasPric}".'.idt_conteudobia = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que ser�o editados na tela full

$vetCampo['bia_conteudobiaidiomas'] = objListarConf('bia_conteudobiaidiomas', 'idt', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'bia_conteudobiaidiomasw',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['bia_conteudobiaidiomas']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________


// IN�CIO

// DEFINI��O DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________

$vetParametros = Array(
    'codigo_frm' => 'bia_conteudobiasetorprioritariow',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>11 - Setores Priorit�rios</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Defini��o de campos formato full que ser�o editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


$vetCampo = Array();
//Monta o vetor de Campo
//$vetCampo['CodTermo']    = CriaVetTabela('C�digo do Termo');
//$vetCampo['DescTermo'] = CriaVetTabela('Descri��o do Termo');

$vetCampo['bia_sp_DescSetorPrioritario'] = CriaVetTabela('Descri��o');

// Parametros da tela full conforme padr�o

$titulo = 'Setores Priorit�rios';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "bia_conteudobiasetorprioritario";
$AliasPric        = "bia_cbsp";
$Entidade         = "Setor Priorit�rio do Conte�do";
$Entidade_p       = "Setores Priorit�rios do Conte�do";

// Select para obter campos da tabela que ser�o utilizados no full

$orderby = " bia_sp.DescSetorPrioritario ";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "       bia_sp.DescSetorPrioritario as bia_sp_DescSetorPrioritario ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join bia_setorprioritario bia_sp on bia_sp.idt = {$AliasPric}.idt_setorprioritario ";

$sql .= " where {$AliasPric}".'.idt_conteudobia = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que ser�o editados na tela full

$vetCampo['bia_conteudobiasetorprioritario'] = objListarConf('bia_conteudobiasetorprioritario', 'idt', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'bia_conteudobiasetorprioritariow',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['bia_conteudobiasetorprioritario']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________




$vetCad[] = $vetFrm;
?>
