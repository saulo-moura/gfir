<?php
$idCampo = 'idt';
$Tela = "a Convers�o dos textos";

$TabelaPrinc      = "plu_converte_texto";
$AliasPric        = "plu_ct";
$Entidade         = "Converte Texto";
$Entidade_p       = "Converte Texto";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

//Monta o vetor de Campo
$vetCampo['codigo'] = CriaVetTabela('C�digo');

$sql = 'select * from plu_converte_texto ';
?>