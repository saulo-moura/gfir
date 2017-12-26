<style type="text/css">
    #tab_resumo_desc {
        text-align: right;
    }

    #tab_resumo_desc table {
        border: 1px solid #2F66B8;
        display: inline-block;
    }

    #tab_resumo_desc table td {
        padding: 2px 5px;
        color: #2F66B8;
        font-weight: bold;
        text-align: left;
    }

    #tab_resumo_desc table td.tit {
        text-align: center;
    }

    #tab_resumo_desc table td span {
        padding: 2px;
        color: black;
        background-color: #ffff80;
        min-width: 70px;
        display: block;
    }

    #lbl_preco {
        margin-top: 3px;
        text-align: center;
        font-weight: bold;
    }

    #lbl_preco span {
        color: black;
    }
    
    span#contrapartida_msg {
        color: red;
    }
</style>
<table>
    <tr>
        <td colspan="3" class="tit">RESUMO FINANCEIRO</td>
    </tr>
    <tr>
        <td>Total:</td>
        <td>Subsidio:</td>
        <td>Valor a Pagar:</td>
    </tr>
    <tr>
        <td><span id="resumo_tot"><?php echo format_decimal($rowDados['resumo_tot']); ?></span></td>
        <td><span id="resumo_sub"><?php echo format_decimal($rowDados['resumo_sub']); ?></span></td>
        <td><span id="resumo_pag"><?php echo format_decimal($rowDados['resumo_pag']); ?></span></td>
    </tr>
</table>
<div id="lbl_preco" class="Tit_Campo_Obr">
    Valor Teto da Solução: R$ <span id="vl_teto"><?php echo format_decimal($rowDados['vl_teto']); ?></span>
    <br />
    Produto de Venda Imediata?: <span id="vl_determinado"><?php echo $vetSimNao[$rowDados['vl_determinado']]; ?></span>
    <?php
    if ($rowDados['contrapartida_sgtec'] == '') {
        echo '<span id="contrapartida_msg"><br />Contrapartida não definida na ação!</span>';
    }
    ?>
</div>