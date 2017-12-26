<?php
require_once '../configuracao.php';

beginTransaction();

$idt_sistema = 92;
        
$sql = '';
$sql .= ' select id_usuario';
$sql .= ' from plu_usuario';
$sql .= ' where id_perfil in (14, 15, 16, 17)';
$rs = execsql($sql);

foreach ($rs->data as $row) {
    $usu_sistema = IdUsuarioPIR($row['id_usuario'], db_pir_grc, db_pir);
    
    $sql = '';
    $sql .= ' select idt_usuario_empreendimento';
    $sql .= ' from '.db_pir.'plu_usuario_empreendimento';
    $sql .= ' where id_usuario = '.null($usu_sistema);
    $sql .= ' and idt_empreendimento = '.null($idt_sistema);
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        $sql = 'insert into '.db_pir.'plu_usuario_empreendimento (id_usuario, idt_empreendimento) values (';
        $sql .= null($usu_sistema).', '.null($idt_sistema).')';
        execsql($sql);
    }
}

commit();

echo 'FIM...';
