<?php
$idCampo = 'id_direito';
$Tela = "o direito";

$TabelaPrinc      = "plu_site_direito";
$AliasPric        = "plu_sd";
$Entidade         = "Direito do Site";
$Entidade_p       = "Direitos do Site";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";


//Monta o vetor de Campo
$vetCampo['nm_direito'] = CriaVetTabela('Nome');
$vetCampo['cod_direito'] = CriaVetTabela('Código');

$sql = 'select * from plu_site_direito order by nm_direito';
?>