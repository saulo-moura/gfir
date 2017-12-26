<?php
$id = 'idt';
$tabela = 'grc_evento_declaracao';

$vetTmp = Array(
    'S' => 'Não',
    'N' => 'Sim',
);
$vetCampo['ativo'] = objFixoVetor('ativo', 'Cancelado?', True, $vetTmp);

$vetCampo['arquivo'] = objFileFixo('arquivo', 'Arquivo em PDF');
$vetCampo['md5'] = objTextoFixo('md5', 'Hash da Aprovação', '', true);
$vetCampo['ip'] = objTextoFixo('ip', 'IP da Máquina', '', true);
$vetCampo['login_aprovacao'] = objTextoFixo('login_aprovacao', 'Login;', '', true);
$vetCampo['codigo_evento'] = objTextoFixo('codigo_evento', 'Código do Evento', '', true);
$vetCampo['codigo_produto'] = objTextoFixo('codigo_produto', 'Código do Produto', '', true);
$vetCampo['vl_despesa'] = objTextoFixo('vl_despesa', 'Valor da Despesa do Evento', '', true);
$vetCampo['vl_receita'] = objTextoFixo('vl_receita', 'Valor da Receita do Evento', '', true);
$vetCampo['codigo_os'] = objTextoFixo('codigo_os', 'Código da O.S', '', true);
$vetCampo['vl_os'] = objTextoFixo('vl_os', 'Valor da O.S', '', true);
$vetCampo['dt_aprovacao'] = objTextoFixo('dt_aprovacao', 'Data/hora da Aprovação', '', true);
$vetCampo['idt_usuario_aprovacao'] = objFixoBanco('idt_usuario_aprovacao', 'Responsavel pela Aprovação', 'plu_usuario', 'id_usuario', 'nome_completo');
$vetCampo['dt_cancelamento'] = objTextoFixo('dt_cancelamento', 'Data/hora do Cancelamento', '', true);
$vetCampo['idt_usuario_cancelamento'] = objFixoBanco('idt_usuario_cancelamento', 'Responsavel pelo Cancelamento', 'plu_usuario', 'id_usuario', 'nome_completo');

MesclarCol($vetCampo['idt_usuario_aprovacao'], 5);
MesclarCol($vetCampo['idt_usuario_cancelamento'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['md5'], '', $vetCampo['arquivo'], '', $vetCampo['ativo'], '', $vetCampo['ip']),
    Array($vetCampo['login_aprovacao'], '', $vetCampo['codigo_evento'], '', $vetCampo['codigo_produto'], '', $vetCampo['vl_despesa']),
    Array($vetCampo['vl_receita'], '', $vetCampo['codigo_os'], '', $vetCampo['vl_os'], '', $vetCampo['ativo']),
    Array($vetCampo['dt_aprovacao'], '', $vetCampo['idt_usuario_aprovacao']),
    Array($vetCampo['dt_cancelamento'], '', $vetCampo['idt_usuario_cancelamento']),
        ));
$vetCad[] = $vetFrm;
