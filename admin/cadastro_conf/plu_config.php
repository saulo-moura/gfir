<?php
$tabela = 'plu_config';
$id = 'id_config';
$onSubmitCon = 'config_con()';

$vetTemp = Array();
$vetTemp[0] = '';
$vetTemp[1] = '';

$vetCampo['descricao'] = objTextoFixo('descricao', 'Configuração', '', True);
$vetCampo['classificacao'] = objTextoFixo('classificacao', 'Classificação', '', true);

if ($_GET['id'] != 0) {
    $sql = 'select variavel from plu_config where id_config = '.$_GET['id'];
    $rs = execsql($sql);
    $variavel = $rs->data[0][0];
}

switch ($variavel) {
    case 'email_site':
    case 'email_envio':
        $vetCampo['valor'] = objEmail('valor', 'Valor', True, 80, 100);
        break;

    case 'email_logerro':
        $vetCampo['valor'] = objTexto('valor', 'Valor', false, 150, 2000);
        break;

    case 'port_smtp':
    case 'reg_pagina':
    case 'num_pagina':
    case 'timeout':
    case 'max_upload_size':
    case 'evento_ano_competencia_max';
    case 'evento_cons_hora_mes';
    case 'produto_limite_teto';
    case 'distrato_dias_sem_assinar_pst';
    case 'evento_sg_vl_hora';
    case 'evento_sg_qtd_inicio';
    case 'evento_sg_validade_cotacao';
    case 'evento_fe_prazo_habilitado';
        $vetCampo['valor'] = objInteiro('valor', 'Valor', True, 10);
        break;

    case 'evento_publicacao_limite_voucher_e':
    case 'aditivo_limite_valor':
        $vetCampo['valor'] = objDecimal('valor', 'Valor', True, 10);
        break;

    case 'login_smtp':
    case 'senha_smtp':
    case 'smtp_secure':
        $vetCampo['valor'] = objTexto('valor', 'Valor', False, 80, 100);
        break;

    case 'ico_texto':
        $vetCampo['valor'] = objCmbVetor('extra', 'Valor', True, $vetIcoGrid);
        break;

    case 'evento_sem_metrica_sge':
    case 'evento_upload_os':
        $tmp = Array(
            'Sim' => 'Sim',
            'Não' => 'Não',
        );
        
        $vetCampo['valor'] = objCmbVetor('valor', 'Valor', True, $tmp, '');
        break;

    case 'evento_publicacao_cupom_can':
        $tmp = Array(
            'Sim' => 'Sim',
            'Não' => 'Não',
            'Escolha na Política de Desconto' => 'Escolha na Política de Desconto',
        );
        
        $vetCampo['valor'] = objCmbVetor('valor', 'Valor', True, $tmp, '');
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

$vetTemp[0] = Array($vetCampo['classificacao']);
$vetTemp[1] = Array($vetCampo['descricao']);
$vetTemp[2] = Array($vetCampo['valor']);

$vetCampo['variavel'] = objHidden('variavel', $variavel);
$vetTemp[] = Array($vetCampo['variavel'], False);

$vetFrm = Array();
$vetFrm[] = Frame('', $vetTemp);
$vetCad[] = $vetFrm;
?>