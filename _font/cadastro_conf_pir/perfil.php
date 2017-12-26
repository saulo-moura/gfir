<?php
$tabela = 'perfil';
$id = 'id_perfil';
$onSubmitAnt = 'perfil()';

$vetCampo['classificacao'] = objTexto('classificacao', 'Classificação', false, 45);

$vetCampo['nm_perfil'] = objTexto('nm_perfil', 'Nome', True, 40);
$vetCampo['direito'] = objInclude('direito', 'perfil_direito.php');

$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);



$vetFrm = Array();
MesclarCol($vetCampo['nm_perfil'], 3);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['nm_perfil']),
    Array($vetCampo['classificacao'],'',$vetCampo['ativo']),
));
$vetFrm[] = Frame('', Array(
    Array($vetCampo['direito'])
));
$vetCad[] = $vetFrm;
?>