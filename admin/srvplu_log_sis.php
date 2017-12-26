<?php
Require_Once('configuracao.php');

$menu = $_REQUEST['menu'];
$prefixo = $_REQUEST['prefixo'];

acesso($menu, "'CON'", true, 'parent.hidePopWin(true);');

if ($_GET['log_sistema'] == '') {
    $_GET['log_sistema'] = log_sistema;
}

$sql = '';
$sql .= ' select vget, vpost, vfiles, vsession, vserver';
$sql .= ' from ' . $_GET['log_sistema'];
$sql .= ' where id_log_sistema = ' . null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];
?>
<?php
echo '$_GET<br>';
echo p(unserialize(base64_decode($row['vget'])));
echo '$_POST<br>';
echo p(unserialize(base64_decode($row['vpost'])));
echo '$_FILES<br>';
echo p(unserialize(base64_decode($row['vfiles'])));
echo '$_SESSION[CS]<br>';
echo p(unserialize(base64_decode($row['vsession'])));
echo '$_SERVER<br>';
echo p(unserialize(base64_decode($row['vserver'])));
?>
