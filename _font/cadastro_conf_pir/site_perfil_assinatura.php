<?php
$tabela = 'site_perfil_assinatura';
$id = 'id_perfil';
$onSubmitAnt = 'site_perfil_assinatura()';


$sql = "select idt, estado, descricao from empreendimento order by estado, descricao";
$vetCampo['idt_empreendimento'] = objCmbBanco('idt_empreendimento', 'Empreendimento', false, $sql);

$vetCampo['nm_perfil'] = objTexto('nm_perfil', 'Nome', True, 40);
$vetCampo['direito'] = objInclude('direito', 'site_perfil_direito_assinatura.php');
$vetCampo['todos'] = objCmbVetor('todos', 'Visualiza Todos os Itens do Site', True, $vetSimNao);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_empreendimento']),
    Array($vetCampo['nm_perfil']),
    Array($vetCampo['todos'])
));
$vetFrm[] = Frame('', Array(
    Array($vetCampo['direito']),
));

$vetCad[] = $vetFrm;
?>