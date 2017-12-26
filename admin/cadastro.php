<?php
$vet_cadastro_bloco=Array();
$vet_cadastro_bloco['fluxo_financeiro_b']='S';
$vet_cadastro_bloco['financiamento_b']='S';
$vet_cadastro_bloco['servico_obra_b']='S';
$vet_cadastro_bloco['empreendimento_torre_andar_unidade_exclusive_b']='S';
//if ($menu=='fluxo_financeiro_b' or $menu=='financiamento_b')


$vet_cadastro_bloco['demonstrativo_b']='S';

$vet_cadastro_bloco['pessoal_efetivo_b']='S';

//echo " ----- ".$vet_cadastro_bloco[$menu]." <br /> ";


if ($vet_cadastro_bloco[$menu]=='S')
{
    $path = 'cadastro_bloco.php';
    if (file_exists($path)) {
        Require_Once($path);
       // exit();
    } else {
        echo "<br><br><div align='center' class='Msg'>Função em desenvolvimento...</div>";
        onLoadPag();
        FimTela();
        exit();
    }
}
else
{
    $path = 'cadastro_p.php';
    if (file_exists($path)) {
        Require_Once($path);
       // exit();
    } else {
        echo "<br><br><div align='center' class='Msg'>Função em desenvolvimento...</div>";
        onLoadPag();
        FimTela();
        exit();
    }
}
?>
