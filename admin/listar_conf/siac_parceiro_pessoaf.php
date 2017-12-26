<?php
$idCampo = 'CodParceiro';
$Tela = "a Pessoa Física";
//

$TabelaPai   = "db_pir_siac.parceiro";
$AliasPai    = "siac_p";
$EntidadePai = "Parceiro";
$idPai       = "siac_p.CodParceiro";

$TabelaPrinc      = "db_pir_siac.pessoaf";
$AliasPric        = "siac_pf";
$Entidade         = "Pessoa Física";
$Entidade_p       = "Pessoas Fisicas";
$CampoPricPai     = "siac_pf.CodParceiro";


$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

$orderby = "";

//$sql_orderby=Array();

//
$Filtro = Array();
//$Filtro['campo']  = 'descricao';
//$Filtro['tabela'] = $TabelaPai;
$Filtro['id']     = 'idt';
$Filtro['nome']   = $EntidadePai;
$Filtro['valor']  = trata_id($Filtro);
$vetFiltro[$CampoPricPai] = $Filtro;
//
$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//
$texto="";
$sql = 'select * from '.$TabelaPai.' where idt = '.null($vetFiltro[$CampoPricPai]['valor']);
$rst = execsql($sql);
if ($rst->rows != 0)
{
   ForEach ($rst->data as $rowt)
   {
      $data  = $rowt['TituloConteudo'];
   }
}
$texto=" $data ";
    
//$upCad[] = vetCadUp('idt', $EntidadePai.': ', 'bia_conteudobia', $texto);

//Monta o vetor de Campo
$vetCampo['NomeMae']    = CriaVetTabela('Nome da Mãe');
$vetCampo['EstCivil']   = CriaVetTabela('Estado Civil');
$vetCampo['Identidade'] = CriaVetTabela('Identidade');
$vetCampo['OrgEmis']    = CriaVetTabela('Orgão Emis.');
$vetCampo['DataNasc']   = CriaVetTabela('Data Nascimento',data);


$sql  = "select {$AliasPric}.*";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
//$sql .= " inner join bia_sebrae bia_se on bia_se.idt = {$AliasPric}.idt_sebrae ";

$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= '    lower('.$AliasPric.'.NomeMae) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.Identidade) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
//$sql .= ' or lower(plu_u.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "{$AliasPric}.CodConteudo ";

$sql .= " order by {$orderby}";
?>
