<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if ($_GET['o'] == 's') {
    Require_Once('../configuracao.php');
} else {
    if ($_REQUEST['cas'] == '') {
        $_REQUEST['cas'] = 'conteudo_abrir_sistema';
    }
    define('conteudo_abrir_sistema', $_REQUEST['cas']);
    Require_Once('configuracao.php');
}
if (file_exists('funcao_gsw.php')) {
    Require_Once('funcao_gsw.php');
}
switch ($_GET['tipo']) {
        case 'gerarelementos':
			$TabelaTexto = $_POST['TabelaTexto'];
			$status      = '';
			$erros       = '';
			$sql_t       = '';
			$menu_t      = '';
            TransformarTabelaTexto($TabelaTexto,$sql_t,$menu_t,$status,$erros); 
			$vet = Array();
			$vet['status']  = $status;
			$vet['erro']    = $erros;
			$vet['sql_t']   = $sql_t;
			$vet['menu_t']  = $menu_t;
			echo json_encode($vet);
        break;
		
}