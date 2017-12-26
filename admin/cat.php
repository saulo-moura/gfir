<div align="center">
<?
    //  $kveiow
    //  $acao
    //  $idt_sa
    //  $idt_tecnico
    //  $idt_solicitado
    $paw="kveiow=E1___acao=inc___idt_sa={$idt_sa}___idt_tecnico={$idt_tecnico}___idt_solicitado={$idt_solicitado}___idt_asa={$idt_asa}";
    $url = 'conteudo_popup.php?prefixo=inc&menu=anexar1_sa&acao=inc&id='.$idt_sa.'&parcad='.$paw;
    // $titulo_tela=$vetMenu['anexo_sa'];
    $titulo_tela="Anexar Documentos ao Acompanhamento da Solicitação - Solicitante";
    echo '<a><img src="icones/anexar_documento.jpg" alt="Anexar Documentos ao Solicitante" title="Anexar Documentos ao Solicitante" width="25" height="25" border="0"  onClick='."\"showPopWin('$url', '".$titulo_tela."', 705, 400, null);\"".' style="cursor: pointer;"><br>Anexar</a>';
?>
</div>