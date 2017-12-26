<?php
$tabela = 'site_perfil';
$id = 'id_perfil';
$onSubmitAnt = 'site_perfil()';


$sql = "select idt, estado, descricao from empreendimento order by estado, descricao";
$vetCampo['idt_empreendimento'] = objCmbBanco('idt_empreendimento', 'Empreendimento', false, $sql);

$vetCampo['nm_perfil'] = objTexto('nm_perfil', 'Nome', True, 40);
$vetCampo['direito'] = objInclude('direito', 'site_perfil_direito.php');


$vetCampo['todos'] = objCmbVetor('todos', 'Visualiza Todos os Itens do Site', True, $vetSimNao);

$vetFrm = Array();

if ($veio_assinatura=='S')
{
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_empreendimento']),
        Array($vetCampo['nm_perfil']),
        Array($vetCampo['todos'])
    ));
}
else
{
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_empreendimento']),
        Array($vetCampo['nm_perfil']),
        Array($vetCampo['todos'])
    ));
}
$vetFrm[] = Frame('', Array(
    Array($vetCampo['direito']),
));

$vetCad[] = $vetFrm;
?>