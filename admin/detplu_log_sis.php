<?php
acesso($menu, "'CON'", true);
onLoadPag();

if ($_GET['log_sistema'] == '') {
    $_GET['log_sistema'] = log_sistema;
}

$sql = 'select nom_tela, dtc_registro from '.$_GET['log_sistema'].' where id_log_sistema = '.null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];
?>
<b class="Tit_Campo_Obr">Dt. Registro:</b>&nbsp;<span class="Texto"><?php echo trata_data($row['dtc_registro']) ?></span><br>
<b class="Tit_Campo_Obr">Formulário:</b>&nbsp;<span class="Texto"><?php echo $row['nom_tela'] ?></span><br><br>
<table width='100%' border='1' cellspacing='0' cellpadding='0' vspace='0' hspace='0' class='Generica'>
    <tr class="Generica">
        <td class="Titulo">Campo</td>
        <td class="Titulo">Valor Anterior</td>
        <td class="Titulo">Valor Novo</td>
        <td class="Titulo">Código Anterior</td>
        <td class="Titulo">Código Novo</td>
    </tr>
    <?php
    $sql = '';
    $sql .= ' select *';
    $sql .= ' from '.$_GET['log_sistema'].'_detalhe';
    $sql .= ' where id_log_sistema = '.null($_GET['id']);
    $sql .= ' order by id_lsd';
    $rs = execsql($sql);
    
    ForEach($rs->data as $row) {
        echo '<tr class="Registro">';
        echo '<td class="Registro">';
        
        if ($row['campo_desc'] == '') {
            echo $row['campo_tabela'];
        } else {
            echo $row['campo_desc'];
        }
        
        echo '</td>';
        echo '<td class="Registro">'.conHTML($row['desc_ant']).'</td>';
        echo '<td class="Registro">'.conHTML($row['desc_atu']).'</td>';
        echo '<td class="Registro">'.conHTML($row['vl_ant']).'</td>';
        echo '<td class="Registro">'.conHTML($row['vl_atu']).'</td>';
        echo '</tr>';
    }
    ?>
</table>
<br>
<div align="center">
    <input type='Button' name='btnAcao' class='Botao' value='Voltar' onClick="self.location = 'conteudo.php?prefixo=inc&back=s<?php echo getParametro('prefixo,back') ?>'">
</div>
