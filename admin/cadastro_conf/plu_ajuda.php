<?php
$tabela = 'plu_ajuda';

if ($cont_arq == '_ajuda') {
    $acao = 'alt';
    $botao_volta = "self.location = 'conteudo_ajuda.php?id=".$row['idt']."'";
    $botao_acao = "<script type='text/javascript'>self.location = 'conteudo_ajuda.php?id=".$row['idt']."';</script>";
    
    $vetCampo['descricao'] = objHidden('descricao', $row['descricao']);
    $vetCampo['codigo'] = objHidden('codigo', $row['codigo']);
    $vetCampo['texto'] = objHtml('texto', 'Texto', False, '390');
    
    $vetFrm = Array();
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['descricao']),
        Array($vetCampo['codigo']),
        Array($vetCampo['texto'])
    ));
    $vetCad[] = $vetFrm;
} else {
    $vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 85, 200);
    $vetCampo['codigo'] = objTexto('codigo', 'Código', True, 60);
    $vetCampo['texto'] = objHtml('texto', 'Texto', False);
    
    $vetFrm = Array();
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['descricao']),
        Array($vetCampo['codigo']),
        Array($vetCampo['texto'])
    ));
    $vetCad[] = $vetFrm;
}
?>