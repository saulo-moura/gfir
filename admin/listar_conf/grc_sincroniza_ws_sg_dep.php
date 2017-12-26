<?php
$vetIdt = Array();
$vetIdtPess = Array();

foreach ($rs_tab_lst->data as $row) {
    $vetIdt[$row['idt']] = $row['idt'];
    $vetIdtPess[$row['idt_atendimento_pessoa']] = $row['idt_atendimento_pessoa'];
}
?>
<div style="text-align: center;">
    <br />
    <input onclick="btReprocessar('<?php echo implode(',', $vetIdt); ?>', '<?php echo implode(',', $vetIdtPess); ?>', true)" value="Reprocessar todos os eventos com Problema" class="BtPesquisa" type="Button">
</div>