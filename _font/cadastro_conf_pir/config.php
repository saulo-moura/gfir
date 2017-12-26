<?php
$tabela = 'config';
$id = 'id_config';
$onSubmitCon = 'config_con()';

$vetTemp = Array();
$vetTemp[0] = '';
$vetTemp[1] = '';

$vetCampo['descricao'] = objTextoFixo('descricao', 'Configuração', '', True);

if ($_GET['id'] != 0) {
    $sql = 'select variavel from config where id_config = '.$_GET['id'];
    $rs = execsql($sql);
    $variavel = $rs->data[0][0];
}

switch ($variavel) {
    case 'email_site':
        $vetCampo['valor'] = objEmail('valor', 'Valor', True, 80, 100);
        break;
    
    case 'port_smtp':
    case 'reg_pagina':
    case 'num_pagina':
    case 'timeout':
        $vetCampo['valor'] = objInteiro('valor', 'Valor', True, 10);
        break;
    
    case 'login_smtp':
    case 'senha_smtp':
        $vetCampo['valor'] = objTexto('valor', 'Valor', False, 80, 100);
        break;
    
    case 'ico_texto':
        $vetCampo['valor'] = objCmbVetor('extra', 'Valor', True, $vetIcoGrid);
        break;
    
    case 'trabalhe_conosco':
        $vetCampo['valor'] = objTextArea('valor', 'Valor', True, 2000, 'width: 600px; height: 300px;');
        break;

    case 'fale_conosco':
        $vetCampo['valor'] = objTextArea('valor', 'Valor', True, 2000, 'width: 600px; height: 300px;');
        break;

    default:
        $vetCampo['valor'] = objTexto('valor', 'Valor', True, 80, 100);
        break;
}

$vetTemp[0] = Array($vetCampo['descricao']);
$vetTemp[1] = Array($vetCampo['valor']);

$vetCampo['variavel'] = objHidden('variavel', $variavel);
$vetTemp[] = Array($vetCampo['variavel'], False);

$vetFrm = Array();
$vetFrm[] = Frame('', $vetTemp);
$vetCad[] = $vetFrm;
?>