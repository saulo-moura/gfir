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

$TabelaPrinc  = "db_pir_siac.endereco";
$AliasPric    = "siac_ed";
$Entidade     = "Endereço";
$Entidade_p   = "Endereços";
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


$vetCampo['NumSeqEnd']      = objTexto('NumSeqEnd', 'Nº Seq. Endereço', false, 11, 11);
$vetCampo['EndCorresp']     = objTexto('EndCorresp','Endereço', false, 100, 150);
$vetCampo['CodLogr']           = objInteiro('CodLogr', 'Cód.', false, 6, 6);
$vetCampo['DescEndereco']      = objTexto('DescEndereco', 'Endereço', false, 100, 150);
$vetCampo['Numero']            = objTexto('Numero', 'Numero', false, 6, 6);
$vetCampo['Complemento']       = objTexto('Complemento', 'Endereço', false, 70, 70);
$vetCampo['CodBairro']         = objInteiro('CodBairro', 'Bairro', false, 11, 11);
$vetCampo['CodCid']            = objInteiro('CodCid', 'Cidade', false, 11, 11);
$vetCampo['CodEst']            = objInteiro('CodEst', 'Estado', false, 6, 6);
$vetCampo['CodPais']           = objInteiro('CodPais', 'País', false, 6, 6);
$vetCampo['Cep']               = objInteiro('Cep', 'Cep', false, 11, 11);
$vetCampo['EndInternacional']  = objTexto('EndInternacional', 'Endereço Internacional', false, 100, 250);
$vetCampo['IndCorrespond']     = objInteiro('IndCorrespond', 'Op. Simples', false, 11, 11);
//$sql  = "select idt, descsebrae from bia_sebrae ";
//$sql .= " order by descsebrae";
//$vetCampo['idt_sebrae'] = objCmbBanco('idt_sebrae', 'Sebrae Responsável', true, $sql,' ','width:200px;');


$vetFrm = Array();
$vetFrm[] = Frame('<span>Conteúdo</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['NumSeqEnd'],'',$vetCampo['EndCorresp'],'',$vetCampo['DataNasc']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Endereço</span>', Array(
    Array($vetCampo['CodLogr']),
    Array($vetCampo['DescEndereco']),
    Array($vetCampo['Numero']),
    Array($vetCampo['Complemento']),
    Array($vetCampo['CodBairro']),
    Array($vetCampo['CodCid']),
    Array($vetCampo['CodEst']),
    Array($vetCampo['CodPais']),
    Array($vetCampo['Cep']),
    Array($vetCampo['EndInternacional']),
    Array($vetCampo['IndCorrespond']),
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
