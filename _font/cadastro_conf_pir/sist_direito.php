<?php
$basew    = 'db_oas_sap';
$con_trab = $con;
$con      = Conexao_Base();
if ($con != '')
{
    // Erro de conex�o
}

$origem_carga = "SCA";

$tabela = 'direito';
$id = 'id_direito';

$vetCampo['nm_direito'] = objTexto('nm_direito', 'Nome', True, 25);
$vetCampo['cod_direito'] = objTexto('cod_direito', 'C�digo', True, 5);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['nm_direito']),
    Array($vetCampo['cod_direito'])
));
$vetCad[] = $vetFrm;
?>