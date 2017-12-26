<style>
#nm_funcao_desc label{
}
#nm_funcao_obj {
}
.Tit_Campo {
}
.Tit_Campo_Obr {
}
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
</style>



<?php

//p($_GET);

if ($_GET['idCad'] != '') {
   $_GET['id'] = $_GET['idCad'];
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);


$TabelaPai   = "db_pir_siac.parceiro";
$AliasPai    = "siac_p";
$EntidadePai = "Parceiro";
$idPai       = "CodParceiro";

$TabelaPrinc      = "db_pir_siac.historicorealizacoescliente";
$AliasPric        = "siac_phrc";
$Entidade         = "Histórico Realizações Cliente";
$Entidade_p       = "Históricos Realizações Cliente";
$CampoPricPai     = "CodCliente";



$tabela = $TabelaPrinc;
/*
$idt_conteudo_termo = $_GET['id'];
if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " bia_ct.*  ";
     $sql .= " from bia_conteudotermovcs bia_ct ";
     $sql .= " where idt = {$idt_conteudo_termo} ";
     $rs = execsql($sql);
     $wcodigo = '';
     ForEach($rs->data as $row)
     {
         $idt_usuario = $row['CodTermo'];
     }
}
else
{

}
*/

$id = 'CodCliente';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'CodParceiro', 'NomeRazaoSocial', 0);

/*
$sql  = " select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
if ($acao!='inc')
{
  $sql .= " where plu_usu.id_usuario = ".null($idt_usuario);
}
else
{

}
$js_hm   = " disabled  ";
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Consultor/Atendente', false, $sql,'',$style,$js_hm);
*/


$sql  = "select codsebrae, descsebrae from db_pir_siac.sebrae ";
$sql .= " order by descsebrae";
$vetCampo['codsebrae'] = objCmbBanco('codsebrae', 'Sebrae Responsável', true, $sql,' ','width:200px;');

//$vetCampo['CodCliente'] = objInteiro('CodCliente', 'Cliente', false, 11, 11);
$vetCampo['DataHoraInicioRealizacao']    = objDataHora('DataHoraInicioRealizacao', 'Inicio Realização', false, $js);
$vetCampo['DataHoraFimRealizacao']    = objDataHora('DataHoraFimRealizacao', 'Fim Realização', false, $js);
$vetCampo['CodEmpreendimento'] = objInteiro('CodEmpreendimento', 'Empreendimento', false, 11, 11);

$maxlength  = 255;
$style      = "width:700px;";
$js         = "";
$vetCampo['NomeRealizacao']  = objTextArea('NomeRealizacao', 'Nome da Realização', false, $maxlength, $style, $js);
$maxlength  = '';
$vetCampo['DescRealizacao']  = objTextArea('DescRealizacao', 'Descrição da Realização', false, $maxlength, $style, $js);

$vetCampo['CodResponsavel'] = objInteiro('CodResponsavel', 'Responsavel', false, 11, 11);


$sql  = "select aplicacaoCodigo, aplicacaoDescricao from db_pir_siac.aplicacao ";
$sql .= " order by aplicacaoDescricao";
$vetCampo['CodAplicacao'] = objCmbBanco('CodAplicacao', 'Aplicação', true, $sql,' ','width:400px;');


// $vetCampo['CodAplicacao'] = objInteiro('CodAplicacao', 'Aplicação', false, 11, 11);

$vetCampo['CodRealizacao'] = objInteiro('CodRealizacao', 'Cod.Realização', false, 11, 11);


$sql  = "select CodTipoRealizacao, DescTipoRealizacao from db_pir_siac.tiporealizacao ";
$sql .= " order by DescTipoRealizacao";
$vetCampo['TipoRealizacao'] = objCmbBanco('TipoRealizacao', 'Tipo de Realização', true, $sql,' ','width:400px;');

//$vetCampo['TipoRealizacao']  = objTexto('TipoRealizacao', 'Tipo de Realização', false, 3, 3);
$vetCampo['Instrumento']  = objTexto('Instrumento', 'Instrumento', false, 50, 50);
$vetCampo['Abordagem']  = objTexto('Abordagem', 'Abordagem', false, 1, 1);

$vetCampo['CodRealizacaoComp'] = objInteiro('CodRealizacaoComp', 'CodRealizacaoComp', false, 11, 11);

$vetCampo['Ano'] = objInteiro('CodRealizacaoComp', 'CodRealizacaoComp', false, 11, 11);
$vetCampo['CodProjeto']  = objTexto('CodProjeto', 'Cod. Projeto', false, 16, 16);
$vetCampo['CodAcao'] = objInteiro('CodAcao', 'Ação', false, 11, 11);
$vetCampo['TipoPessoa']  = objTexto('TipoPessoa', 'Tipo Pessoa', false, 1, 1);

$vetCampo['CodMomentoVida']        = objInteiro('CodMomentoVida', 'Momento Vida', false, 4, 4);

$vetCampo['MesAnoCompetencia']    = objDataHora('MesAnoCompetencia', 'Mes/Ano Competencia', false, $js);

$vetCampo['CargaHoraria']        = objDecimal('CargaHoraria', 'Carga Horaria', false, 4, 4);


$vetCampo['Faturam']        = objInteiro('Faturam', 'Faturamento', false, 6, 6);
$vetCampo['CodAtendimentoCRM']  = objTexto('CodAtendimentoCRM', 'Cod.Atendimento CRM', false, 16, 16);
$vetCampo['CodEntidadeParceira']        = objInteiro('CodEntidadeParceira', 'Entidade Parceira', false, 11, 11);
$vetCampo['CodConst']        = objInteiro('CodConst', 'CodConst', false, 6, 6);
$vetCampo['CategoriaPessoa']        = objInteiro('CategoriaPessoa', 'Categoria Pessoa', false, 6, 6);

$vetCampo['DataEntrada ']    = objDataHora('DataEntrada', 'Data Entrada', false, $js);
$vetCampo['DataETL']    = objDataHora('DataETL', 'Data ETL', false, $js);

$vetCampo['codcategoria'] = objInteiro('codcategoria', 'Categoria', false, 11, 11);
$vetCampo['CodSistemaOrigem'] = objInteiro('CodSistemaOrigem', 'Sistema de Origem', false, 11, 11);



$vetFrm = Array();
$vetFrm[] = Frame('<span>Conteúdo</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codsebrae'],'',$vetCampo['DataHoraInicioRealizacao'],'',$vetCampo['DataHoraFimRealizacao']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Realização</span>', Array(
    Array($vetCampo['NomeRealizacao']),
    Array($vetCampo['DescRealizacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Complemento Realização</span>', Array(
    Array($vetCampo['TipoRealizacao'],'',$vetCampo['CodRealizacao'],'',$vetCampo['CodRealizacaoComp']),
    Array($vetCampo['CodResponsavel'],'',$vetCampo['CodAplicacao'],'',$vetCampo['Abordagem']),
    Array($vetCampo['Instrumento'],'',$vetCampo['CodProjeto'],'',$vetCampo['CodMomentoVida']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Outros</span>', Array(
    Array($vetCampo['Ano'],'',$vetCampo['TipoPessoa'],'',$vetCampo['CodAcao']),
    Array($vetCampo['MesAnoCompetencia'],'',$vetCampo['CargaHoraria'],'',$vetCampo['Faturam']),
    Array($vetCampo['CodAtendimentoCRM'],'',$vetCampo['CodEntidadeParceira'],'',$vetCampo['CodConst']),
    Array($vetCampo['CategoriaPessoa'],'',$vetCampo['DataEntrada'],'',$vetCampo['DataETL']),
    Array($vetCampo['codcategoria'],'',$vetCampo['CodSistemaOrigem'],'',''),
),$class_frame,$class_titulo,$titulo_na_linha);




 /*
// INÍCIO

// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________

$vetParametros = Array(
    'codigo_frm' => 'bia_conteudobiaagentesidiomasw',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>01 - Textos do Agente</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


//Monta o vetor de Campo
$vetCampo = Array();
$vetCampo['CodIdioma']     = CriaVetTabela('Idioma', 'descDominio', $vetIdioma );
$vetCampo['CorpoTexto']    = CriaVetTabela('Texto');

// Parametros da tela full conforme padrão

$titulo = 'Textos dos Agentes';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "bia_conteudobiaagentesidiomas";
$AliasPric        = "bia_cbai";
$Entidade         = "Idioma do Conteúdo do Agente";
$Entidade_p       = "Idiomas do Conteúdo do Agente";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.CodIdioma ";

$sql  = "select {$AliasPric}.* ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";

$sql .= " where {$AliasPric}".'.idt_conteudobiaagentes = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full

$vetCampo['bia_conteudobiaagentesidiomas'] = objListarConf('bia_conteudobiaagentesidiomas', 'idt', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'bia_conteudobiaagentesidiomasw',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['bia_conteudobiaagentesidiomas']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________


// INÍCIO

// DEFINIÇÃO DE TELA FORMATO FULL SCREEN DENTRO DA FICHA DE ATENDIMENTO
// PRODUTOS DE ATENDIMENTO
//____________________________________________________________________________

$vetParametros = Array(
    'codigo_frm' => 'bia_conteudobiaagentesanexosw',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>02 - Anexos do Agente</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

// Definição de campos formato full que serão editados na tela full

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO


//Monta o vetor de Campo
$vetCampo = Array();
$vetCampo['NomeArquivo']  = CriaVetTabela('Nome do Arquivo');
$vetCampo['CodIdioma']    = CriaVetTabela('Idioma', 'descDominio', $vetIdioma );
$vetCampo['Descricao']    = CriaVetTabela('Descrição');

// Parametros da tela full conforme padrão

$titulo = 'Anexos dos Agentes';

// COPIAR DO LISTAR_CONF DA TABELA DE BAIXO

$TabelaPrinc      = "bia_conteudobiaagentesanexos";
$AliasPric        = "bia_cbaa";
$Entidade         = "Anexo do Conteúdo do Agente";
$Entidade_p       = "Anexos do Conteúdo do Agente";

// Select para obter campos da tabela que serão utilizados no full

$orderby = "{$AliasPric}.CodIdioma ";

$sql  = "select {$AliasPric}.* ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";

$sql .= " where {$AliasPric}".'.idt_conteudobiaagentes = $vlID';
$sql .= " order by {$orderby}";

// Carrega campos que serão editados na tela full

$vetCampo['bia_conteudobiaagentesanexos'] = objListarConf('bia_conteudobiaagentesanexos', 'idt', $vetCampo, $sql, $titulo, false);

// Formata lay_out de saida da tela full

$vetParametros = Array(
    'codigo_pai' => 'bia_conteudobiaagentesanexosw',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['bia_conteudobiaagentesanexos']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// FIM ____________________________________________________________________________

 */

$vetCad[] = $vetFrm;
?>
