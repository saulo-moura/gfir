<style type="text/css">
</style>

<?php


// teste de estrutura
   
/*   
   $vetTbelas   = Array();
   //$vetTbelas[] = "grc_entidade_pessoa";
   $vetTbelas[] = "grc_produto_tema";
   //$vetTbelas[] = "grc_produto_tipo";
   $TABELA_PIR = new PIR_TABELA($vetTbelas);
   $vetEstrutura= Array();
   $vetEstrutura= $TABELA_PIR -> estrutura_tbs();
   //p($vetEstrutura);
   
   
   
   //p($vetEstrutura);
   //$xml = $TABELA_PIR -> array_to_xml($vetEstrutura);
   
   //p($xml);
*/ 
/*
   //
   // TABELA DE NOMENCLATURA
   //
   //$tabela      = "grc_produto_tema";
   //$tabela      = "grc_produto_tema";
   $vetTbelas    = Array();
   $TABELA_PIR   = new PIR_TABELA($vetTbelas);
   $vetTabelas   = $TABELA_PIR -> CarregarTabelas();
   //$sql_instrucao = "select * from db_pir.sca_organizacao_secao ";
   
   $sql_instrucao = "";
   if ($sqlinstrucao!="")
   {
       $sql_instrucao = $sqlinstrucao;
   }
   
   $ObjetoXml    = $TABELA_PIR -> estrutura_tbn($tabela,$sql_instrucao);
   $html         = $TABELA_PIR -> xmlTable($ObjetoXml);
   
   echo $html;
   
   unset($TABELA_PIR);
 */  
   
   
   $sql_instrucao = "";
   //p('---------------------'.$sqlinstrucao);
   if ($sqlinstrucao!="")
   {
       $sql_instrucao = $sqlinstrucao;
   }
   $vetTbelas    = Array();
   $TABELA_PIR   = new PIR_TABELA($vetTbelas);
   $TabelaPHP    = $TABELA_PIR->MigraNomenclaturaTabelaPHP($tabela,$sql_instrucao);
   $htmlTable    = $TABELA_PIR->MigraNomenclaturaHTMLTable($tabela,$sql_instrucao);
   $ObjXML       = $TABELA_PIR->TabelaPHP_to_ObjXML($TabelaPHP);
   $XML          = $TABELA_PIR->ObjXML_to_XML($ObjXML);
   
   
   echo $htmlTable;	
   //p($TabelaPHP);
   //p($ObjXML);
   //echo "<pre>".aspa($XML);
   
   //echo "</pre>";

   unset($TABELA_PIR);
   
   
   // p($vetTabelas);
   //
   //$xml = $TABELA_PIR -> array_to_xml($ObjetoXml);
   //echo '<iframe xsrc="teste.xml" width="2000" height="320">';
   //echo '</iframe>';

   /*
   $vetEstrutura= $TABELA_PIR -> estrutura_tb("grc_produto_tema");
   p($vetEstrutura);

   $vetEstrutura= $TABELA_PIR -> estrutura_tbtp("grc_produto_tema","WS");
   p($vetEstrutura);
*/


