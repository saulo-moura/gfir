<?php
Require_Once('configuracao.php');

$menu = $_REQUEST['menu'];
$prefixo = $_REQUEST['prefixo'];

acesso($menu, "'CON'", true, 'parent.hidePopWin(true);');

if ($_GET['log_sistema'] == '') {
    $_GET['log_sistema'] = log_sistema;
}

$sql = '';
$sql .= ' select obj_extra';
$sql .= ' from ' . $_GET['log_sistema'];
$sql .= ' where id_log_sistema = ' . null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

echo 'Informações do Regsitro<br>';
echo p(unserialize($row['obj_extra']));