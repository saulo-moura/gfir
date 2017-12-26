<?php
$tabela = 'empreendimento';
$id = 'idt';


$vetCampo['idt_sistema'] = objFixoBanco('idt_sistema', 'Sistema', 'sca_sistema', 'idt', 'descricao', 0);
$vetCampo['descricao']   = objTexto('descricao', 'Ambiente', True, 25, 120);
$vetCampo['chama']       = objTexto('chama', 'Link para acesso', false, 70, 255);
$vetCampo['pathfisico']  = objTexto('pathfisico', 'Path Fнsico da Aplicaзгo', false, 70, 255);

$vetCampo['servidor']    = objTexto('servidor', 'Servidor', false, 70, 120);
$vetCampo['base_dados']  = objTexto('base_dados', 'Base de Dados', false, 70, 120);
$vetCampo['tipo_base']  = objTexto('tipo_base', 'Tipo de Base', false, 70, 120);
$vetCampo['porta']  = objTexto('porta', 'Porta', false, 45, 45);

$vetCampo['usuario']  = objTexto('usuario', 'Usuбrio', false, 70, 120);
$vetCampo['senha']    = objTexto('senha', 'Senha', false, 70, 120);


$vetCampo['imagem']      = objFile('imagem', 'Logomarca 25 x 25 px', false, 80, 'imagem', 25, 25);
$vetCampo['ativo']       = objCmbVetor('ativo', 'Sistema Ativo?', True, $vetSimNao,'','');
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe']     = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
$sql = "select codigo as estado, codigo, descricao from estado order by codigo";
$vetCampo['estado'] = objCmbBanco('estado', 'Unidade Federaзгo', true, $sql,'','width:180px;');

$vetCampo['perfil_padrao']    = objTexto('perfil_padrao', 'Perfil Adm. Padrгo', false, 70, 120);
$vetCampo['perfil_site_padrao']    = objTexto('perfil_site_padrao', 'Perfil Site Padrгo', false, 70, 120);
$vetCampo['setor']    = objTexto('setor', 'Setor Padrгo', false, 70, 120);


$vetCampo['producao']       = objCmbVetor('producao', 'Produзгo?', false, $vetSimNao,'','');
$vetCampo['msg_producao']   = objTextArea('msg_producao', 'Mensagem', false, $maxlength, $style, $js);



$vetFrm = Array();
$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['idt_sistema'] ),
));
$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['descricao'] ),
    Array($vetCampo['ativo'] ),
    Array($vetCampo['estado'] ),
));


$vetFrm[] = Frame(' Como Chamar o Sistema ', Array(
    Array($vetCampo['chama'] ),
//    Array($vetCampo['pathfisico'] ),

));

$vetFrm[] = Frame(' Conexгo ', Array(
    Array($vetCampo['servidor'] ),
    Array($vetCampo['base_dados'] ),
    Array($vetCampo['tipo_base'] ),
    Array($vetCampo['porta'] ),
));

$vetFrm[] = Frame(' Login ', Array(
    Array($vetCampo['usuario'] ),
    Array($vetCampo['senha'] ),
));

$vetFrm[] = Frame(' Parвmetros para Login ', Array(
    Array($vetCampo['perfil_padrao'] ),
    Array($vetCampo['perfil_site_padrao'] ),
    Array($vetCampo['setor'] ),
));

$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['detalhe']),
));
$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['imagem']),
));


$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['producao']),
    Array($vetCampo['msg_producao']),
));







$vetCad[] = $vetFrm;


?>