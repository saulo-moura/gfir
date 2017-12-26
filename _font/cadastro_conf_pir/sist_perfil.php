<?php

$basew    = 'db_oas_sap';
$con_trab = $con;
$con      = Conexao_Base();
if ($con != '')
{
    // Erro de conexão
}

$origem_carga = "SCA";


$tabela = 'perfil';
$id = 'id_perfil';
$onSubmitAnt = 'perfil()';

$vetCampo['nm_perfil'] = objTexto('nm_perfil', 'Nome', True, 40);
$vetCampo['direito'] = objInclude('direito', 'perfil_direito.php');

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['nm_perfil']),
    Array($vetCampo['direito'])
));
$vetCad[] = $vetFrm;
?>