<?php
$tabela = 'mime_grupo';
$id = 'idt_migr';

$vetCampo['des_gurpo'] = objTextoFixo('des_gurpo', 'Grupo', 60, True);

$sql_lst_1 = 'select idt_miar, des_extensao from mime_arquivo order by des_extensao';

$sql_lst_2  = 'select ma.idt_miar, ma.des_extensao from mime_arquivo ma inner join
               mime_grar mg on ma.idt_miar = mg.idt_miar
               where mg.idt_migr = '.$_GET['id'].' order by ma.des_extensao';

$vetCampo['idt_miar'] = objLista('idt_miar', True, 'Arquivos do Sistema', 'sistema', $sql_lst_1, 'mime_grar', 300, 'Arquivos do Grupo', 'funcao', $sql_lst_2);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['des_gurpo']),
    Array($vetCampo['idt_miar']),
));
$vetCad[] = $vetFrm;
?>