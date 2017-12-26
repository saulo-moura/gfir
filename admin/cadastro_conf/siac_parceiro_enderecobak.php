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


$TabelaPai   = "db_pir_siac.parceiro";
$AliasPai    = "siac_p";
$EntidadePai = "Parceiro";
$idPai       = "CodParceiro";


$TabelaPrinc      = "db_pir_siac.endereco";
$AliasPric        = "siac_pe";
$Entidade         = "Endereço";
$Entidade_p       = "Endereços";
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

$vetCampo['NumSeqEnd']         = objInteiro('NumSeqEnd', 'Nº Seq', false, 11, 11);
$vetCampo['EndCorresp']        = objTexto('EndCorresp', 'End. Correspondencia', false, 3, 3);


/*
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
*/

//$sql  = "select idt, descsebrae from bia_sebrae ";
//$sql .= " order by descsebrae";
//$vetCampo['idt_sebrae'] = objCmbBanco('idt_sebrae', 'Sebrae Responsável', true, $sql,' ','width:200px;');


$vetFrm = Array();
$vetFrm[] = Frame('<span>Conteúdo</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['NumSeqEnd'],'',$vetCampo['EndCorresp']),
),$class_frame,$class_titulo,$titulo_na_linha);

 /*

 $vetFrm[] = Frame('<span>Endewreço</span>', Array(
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

*/



$vetCad[] = $vetFrm;
?>
