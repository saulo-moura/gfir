<?php
$idCampo = 'id_direito';
$Tela = "o direito";

$TabelaPrinc      = "plu_direito";
$AliasPric        = "plu_dir";
$Entidade         = "Direito";
$Entidade_p       = "Direitos";

$barra_inc_h      = "Incluir um Novo Registro de Direito";
$contlinfim       = "Existem #qt Direitos.";


//Monta o vetor de Campo
$vetCampo['nm_direito'] = CriaVetTabela('Nome');
$vetCampo['cod_direito'] = CriaVetTabela('Código');

$sql = 'select * from plu_direito order by nm_direito';
?>