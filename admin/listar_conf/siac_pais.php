<?php
$idCampo = 'idt';
$Tela = "o Pais";

//$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$TabelaPrinc      = "db_pir_siac.pais";
$AliasPric        = "siac_pa";
$Entidade         = "Pa�s";
$Entidade_p       = "Pa�ses";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";


$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//Monta o vetor de Campo
$vetCampo['CodPais']   = CriaVetTabela('C�digo');
$vetCampo['DescPais']  = CriaVetTabela('Descri��o');
$vetCampo['SITUACAO']  = CriaVetTabela('Situa��o');
//$vetCampo['Situacao']  = CriaVetTabela('Situa��o', 'descDominio', $vetSimNao );

$sql  = "select * from {$TabelaPrinc} ";
$sql .= " where ";
$sql .= '    lower(CodPais) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' or lower(DescPais) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by CodPais';
?>
