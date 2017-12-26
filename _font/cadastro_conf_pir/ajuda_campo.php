<?php
$tabela = 'help_campo';

if ($cont_arq == '_ajuda_campo') {
    $acao = 'alt';
    $botao_volta = "self.location = 'conteudo_ajuda_campo.php?id=".$row['idt']."'";
    $botao_acao = "<script>self.location = 'conteudo_ajuda_campo.php?id=".$row['idt']."';</script>";
    
    $vetCampo['tabela'] = objHidden('tabela', $row['tabela']);
    $vetCampo['campo']  = objHidden('campo', $row['campo']);
    $vetCampo['resumo'] = objTexto('resumo', 'Resumo', True, 60,120);
    $vetCampo['descricao'] = objTexto('descricao', 'Descrição Campo', false, 60,120);
    $vetCampo['texto']  = objHtml('texto', 'Texto', False, '290');
    
    $vetFrm = Array();
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['tabela']),
        Array($vetCampo['campo']),
        Array($vetCampo['descricao']),
        Array($vetCampo['resumo']),
        Array($vetCampo['texto'])
    ));
    $vetCad[] = $vetFrm;
} else {
    $vetCampo['tabela'] = objHidden('tabela', $row['tabela']);
    $vetCampo['campo'] = objHidden('campo', $row['campo']);

    $vetCampo['descricao'] = objTexto('descricao', 'Descrição Campo', false, 60,120);
    $vetCampo['resumo'] = objTexto('resumo', 'Resumo', True, 60,120);
    $vetCampo['texto']  = objHtml('texto', 'Texto', False);
    
    $vetFrm = Array();
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['tabela']),
        Array($vetCampo['campo']),
        Array($vetCampo['descricao']),
        Array($vetCampo['resumo']),
        Array($vetCampo['texto'])
    ));
    $vetCad[] = $vetFrm;
}
?>