
<style type='text/css'>
    td.CabFull {
        background:#2A5696;
        font-size: 12px;
        color:#FFFFFF;
    }
    td.LinhaFull {
        font-size: 11px;
        color:#000000;
    }
    tr.NavegaPagina {
        background:#C4C9CD;
        font-size: 12px;
        color:#FFFFFF;
    }
    tr.ExtraPagina {
        background:#C4C9CD;
        font-size: 12px;
        color:#FFFFFF;
    }
    tr.tit {
        color:#FFFFFF;
    }

    div.bt_volta_painel {
        background:#ECF0F1;
        color:#000000;
        text-align:left;
    }

</style>


<?php
//
// Par�metros para formatar o full
//
$classet = 'CabFull';     // Classe para cabe�alho do Full
$classer = 'LinhaFull';   // Classe para Linhas do Full
// estilo para �rea de Bot�es da Linha
//$ctlinha      = " background:#2F66B8; border-bottom:1px solid #C4C9CD; border-right:1px solid #C4C9CD; text-align:center; ";
$ctlinha = " background:#FFFFFF; border-bottom:1px solid #C4C9CD; border-right:1px solid #C4C9CD;";
// Bot�o de Fechar
$barra_fec_ap = false;
$barra_fec = '';
$barra_fec_h = 'Fechar a lista de Campos';
// Bot�o Incluir
$barra_inc = '';

$inc_chamada_barra = false; // posicionar no cabe�alho
// Cores Zebradas
$corimp = '#FFFFFF';
$corpar = '#ECF0F1';
$corover = '#2C3E50';


$barra_inc_img = "imagens/incluir_32.png";
$barra_alt_img = "imagens/alterar_32.png";
$barra_con_img = "imagens/consultar_32.png";
$barra_exc_img = "imagens/excluir_32.png";
$barra_fec_img = "imagens/fechar_32.png";

// tem clique na linha = 1;
$cliquenalinha = 0;
$clique_hint_linha = "Clique aqui para ter acesso a detalhes dessa linha."; // HINT para linha do FULL

$comfiltro = 'F';
$comidentificacao = 'A';
?>
<script type="text/javascript">
    /*
    function lista_td_acao_click(id, campo, obj_td) {
        alert(id + ' - ' + campo + ' - ' + obj_td.text());
    }
    */
</script>
