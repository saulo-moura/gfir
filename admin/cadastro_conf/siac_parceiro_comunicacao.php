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


$TabelaPrinc      = "db_pir_siac.comunicacao";
$AliasPric        = "siac_pc";
$Entidade         = "Comunicacao";
$Entidade_p       = "Comunicações";
$CampoPricPai     = "CodParceiro";


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

$vetCampo['numseqcom']   = objInteiro('numseqcom', 'Nº Comunicação', false, 6, 6);
//$vetCampo['codcomunic']  = objInteiro('codcomunic', 'Cod.Comunicação', false, 6, 6);
$vetCampo['numero']      = objTexto('numero', 'Número', false, 55, 60);
$vetCampo['IndInternet'] = objInteiro('IndInternet', 'Ind. Internet', false, 4, 4);


$sql  = "select codcomunic, desccomunic from db_pir_siac.tipocomunic ";
$sql .= " order by desccomunic";
$vetCampo['codcomunic'] = objCmbBanco('codcomunic', 'Cod.Comunicação', true, $sql,' ','width:400px;');


$vetFrm = Array();
$vetFrm[] = Frame('<span>Conteúdo</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Complemento</span>', Array(
    Array($vetCampo['numseqcom']),
    Array($vetCampo['codcomunic']),
    Array($vetCampo['numero']),
    Array($vetCampo['IndInternet']),
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
