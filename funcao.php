<?php
Require_Once('admin/funcao.php');
Require_Once('admin/funcao_ger.php');

function CriaVetLista($nome, $tipo, $style, $mostra_nome = false, $par = '', $antes = '', $depois = '', $classcab='', $ndecimal='') {
    $vet = Array();
    
    $vet['nome']        = $nome;
    $vet['tipo']        = mb_strtolower($tipo);
    $vet['style']       = mb_strtolower($style);
    $vet['mostra_nome'] = $mostra_nome;
    $vet['antes']       = $antes;
    $vet['depois']      = $depois;
    $vet['link']        = $link;
    $vet['par']         = $par;
    $vet['classcab']    = $classcab;

    $vet['ndecimal']    = $ndecimal;

    return $vet;
}
