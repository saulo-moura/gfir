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


$TabelaPai    = "db_pir_siac.parceiro";
$AliasPai     = "siac_p";
$EntidadePai  = "Parceiro";
$idPai        = "CodParceiro";

$TabelaPrinc  = "db_pir_siac.pessoaf";
$AliasPric    = "siac_pf";
$Entidade     = "Pessoa Física";
$Entidade_p   = "Pessoas Fisicas";
$CampoPricPai = "CodParceiro";


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



//p($_GET);

//$id = 'idt';
$id = 'CodParceiro';
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


$vetCampo['Identidade']  = objTexto('Identidade', 'Identidade', false, 15, 15);
$vetCampo['OrgEmis']     = objTexto('OrgEmis', 'Orgão Emissor', false, 10, 10);
$vetCampo['DataNasc']    = objDataHora('DataNasc', 'Data Nascimento', false, $js);
$vetCampo['CodProfis']   = objInteiro('CodProfis', 'Profissão', false, 11, 11);
//$vetCampo['CodGrauEscol']= objInteiro('CodGrauEscol', 'Escolaridade', false, 6, 6);
$vetCampo['Autonomo']    = objTexto('Autonomo', 'Autonomo', false, 3, 3);
//$vetCampo['CodPais']     = objInteiro('CodPais', 'Pais', false, 6, 6);
$vetCampo['EstCivil']    = objTexto('EstCivil', 'Estado Civil(EstCivil)', false, 10, 10);
$vetCampo['Sexo']        = objInteiro('Sexo', 'Sexo', false, 4, 4);
$vetCampo['EstadoCivil'] = objInteiro('EstadoCivil', 'Estado Civil(EstadoCivil)', false, 4, 4);
$vetCampo['IndAutonomo'] = objInteiro('IndAutonomo', 'Indice Autonomo', false, 1, 1);
$vetCampo['ClassificacaoPessoa'] = objInteiro('ClassificacaoPessoa', 'Classificação Pessoa', false, 6, 6);
$vetCampo['CodAtividadePF'] = objInteiro('CodAtividadePF', 'Atividade PF', false, 11, 11);
$vetCampo['NomeMae']     = objTexto('NomeMae', 'Nome da Mãe', false, 11, 11);

$sql  = "select CodGrauEscol, DescGrauEscol from db_pir_siac.escolaridade ";
$sql .= " order by DescGrauEscol";
$vetCampo['CodGrauEscol'] = objCmbBanco('CodGrauEscol', 'Escolaridade', true, $sql,' ','width:400px;');

$sql  = "select CodPais, DescPais from db_pir_siac.pais ";
$sql .= " order by DescPais";
$vetCampo['CodPais'] = objCmbBanco('CodPais', 'País', true, $sql,' ','width:400px;');


$vetFrm = Array();
$vetFrm[] = Frame('<span>Conteúdo</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['Identidade'],'',$vetCampo['OrgEmis'],'',$vetCampo['DataNasc']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Nome da Mãe</span>', Array(
    Array($vetCampo['NomeMae']),
),$class_frame,$class_titulo,$titulo_na_linha);


 $vetFrm[] = Frame('<span>Qualificação</span>', Array(
    Array($vetCampo['CodProfis'],'',$vetCampo['CodGrauEscol'],'',$vetCampo['Autonomo']),
    Array($vetCampo['CodPais'],'',$vetCampo['EstCivil'],'',$vetCampo['Sexo']),
    Array($vetCampo['EstadoCivil'],'',$vetCampo['IndAutonomo'],'',$vetCampo['ClassificacaoPessoa']),
),$class_frame,$class_titulo,$titulo_na_linha);

 $vetFrm[] = Frame('<span>Qualificação</span>', Array(
    Array($vetCampo['CodAtividadePF']),
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
