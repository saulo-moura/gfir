<?PHP
//
// Criar conex�o com o sistema
//

$basew    = 'db_oas_sap';
$con_trab = $con;
$con      = Conexao_Base($basew);
if ($con != '')
{
    // Erro de conex�o
}

$origem_carga = "SCA";

$tipofiltro='S';
$menu         = 'funcao';
$_GET['menu'] = $menu;
//echo ' chama '.$menu;
require_once('listar_conf/funcao.php');
   // p($vetFiltro);

?>
