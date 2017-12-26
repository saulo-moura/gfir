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

$TabelaPrinc = "db_pir_siac.pessoaj";
$AliasPric   = "siac_pj";
$Entidade    = "Pessoa Jurídica";
$Entidade_p  = "Pessoas Jurídicas";
$CampoPricPai= "CodParceiro";


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

//$vetCampo['codparceiro'] = objInteiro('codparceiro', 'Cod.Parceiro', false, 11, 11);
$vetCampo['inscest']     = objTexto('inscest', 'Inscrição Estadual', false, 20, 20);
$vetCampo['inscmun']     = objTexto('inscmun', 'Inscrição Municipal', false, 20, 20);

$vetCampo['databert']    = objDataHora('databert', 'Data Abertura', false, $js);
$vetCampo['datfech']     = objDataHora('datfech', 'Data Fechamento', false, $js);

$vetCampo['codsetor']    = objInteiro('codsetor', 'Setor', false, 6, 6);
$vetCampo['codconst']    = objInteiro('codconst', 'Cod.Const', false, 6, 6);
$vetCampo['codgrupemp']  = objInteiro('codgrupemp', 'Cod.Grupo Empresa', false, 6, 6);
$vetCampo['numfunc']     = objInteiro('numfunc', 'Nº Funcionarios', false, 6, 6);
$vetCampo['capsocial']   = objDecimal('capsocial', 'Capital Social', false, 6, 6);

$vetCampo['faturam']     = objInteiro('faturam', 'Faturamento', false, 6, 6);
$vetCampo['porte']       = objInteiro('porte', 'Porte', false, 6, 6);

$vetCampo['codareaatu']   = objInteiro('codareaatu', 'Area de atuação', false, 11, 11);
$vetCampo['indLegalizado']= objInteiro('indLegalizado', 'ind.Legalizado', false, 6, 6);

$vetCampo['CodProdutorRural'] = objTexto('CodProdutorRural', 'Cod Produtor Rural', false, 20, 20);
$vetCampo['CodDap']           = objTexto('CodDap', 'Cod. DAP', false, 40, 40);
$vetCampo['CodPescador']      = objTexto('CodPescador', 'Cod.Pescador', false, 40, 40);

$vetCampo['NIRF']            = objDecimal('NIRF', 'NIRF', false, 8, 8);

$vetCampo['tamanhoPropriedade'] = objInteiro('tamanhoPropriedade', 'Tamanho Propriedade', false, 11, 11);
$vetCampo['OptanteSimplesNacional'] = objInteiro('OptanteSimplesNacional', 'Op. Simples', false, 11, 11);


//$sql  = "select idt, descsebrae from bia_sebrae ";
//$sql .= " order by descsebrae";
//$vetCampo['idt_sebrae'] = objCmbBanco('idt_sebrae', 'Sebrae Responsável', true, $sql,' ','width:200px;');


$vetFrm = Array();
$vetFrm[] = Frame('<span>Conteúdo</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['inscest'],'',$vetCampo['inscmun'],'',$vetCampo['databert'],'',$vetCampo['datfech']),
),$class_frame,$class_titulo,$titulo_na_linha);

 $vetFrm[] = Frame('<span>Empresa</span>', Array(
    Array($vetCampo['codsetor'],'',$vetCampo['codconst'],'',$vetCampo['codgrupemp']),
    Array($vetCampo['numfunc'],'',$vetCampo['capsocial'],'',$vetCampo['faturam']),
    Array($vetCampo['porte'],'',$vetCampo['codareaatu'],'',$vetCampo['indLegalizado']),
),$class_frame,$class_titulo,$titulo_na_linha);

  $vetFrm[] = Frame('<span>Informações Complementares</span>', Array(
    Array($vetCampo['CodProdutorRural'],'',$vetCampo['CodDap'],'',$vetCampo['CodPescador']),
    Array($vetCampo['NIRF'],'',$vetCampo['tamanhoPropriedade'],'',$vetCampo['OptanteSimplesNacional']),
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



 */

$vetCad[] = $vetFrm;
?>
