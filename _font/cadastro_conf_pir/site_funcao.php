<?php
$tabela = 'site_funcao';
$id = 'id_funcao';

$vetCampo['nm_funcao'] = objTexto('nm_funcao', 'Nome', True, 80, 100);
$vetCampo['cod_funcao'] = objTexto('cod_funcao', 'Cуdigo', True, 45);
$vetCampo['des_prefixo'] = objTexto('des_prefixo', 'Prefixo Menu', True, 40, 40);
$vetCampo['cod_classificacao'] = objTexto('cod_classificacao', 'Classificaзгo', True, 40, 200);
$vetCampo['sts_menu'] = objCmbVetor('sts_menu', 'Mostra no Menu', True, $vetSimNao);
$vetCampo['sts_linha'] = objCmbVetor('sts_linha', 'Colocar linha separadora', True, $vetSimNao);

$vetCampo['gestao'] = objCmbVetor('gestao', 'Gestгo Obras?', false, $vetSimNao);
$vetCampo['procedimento'] = objCmbVetor('procedimento', 'Procedimento?', false, $vetSimNao);

$sql_lst_1 = 'select id_direito, nm_direito from site_direito order by nm_direito';

$sql_lst_2  = 'select d.id_direito, df.id_difu, d.nm_direito from site_direito d inner join
               site_direito_funcao df on d.id_direito = df.id_direito
               where df.id_funcao = '.$_GET['id'].' order by d.nm_direito';

$vetCampo['id_direito'] = objLista('id_direito', True, 'Direitos do Sistema', 'sistema', $sql_lst_1, 'site_direito_funcao', 200, 'Direitos da Funзгo', 'site_funcao', $sql_lst_2, '', '', 'site_direito_perfil', 'id_difu');

$vetCampo['cod_assinatura'] = objTexto('cod_assinatura', 'Cуdigo Assinatura', false, 40, 45);

$sql = 'select idt, descricao from setor order by codigo';
$vetCampo['idt_setor'] = objCmbBanco('idt_setor', 'Setor Responsбvel', False, $sql);


MesclarCol($vetCampo['nm_funcao'], 7);
//MesclarCol($vetCampo['cod_classificacao'], 3);
MesclarCol($vetCampo['id_direito'], 7);
MesclarCol($vetCampo['des_prefixo'], 5);
MesclarCol($vetCampo['cod_assinatura'], 5);

MesclarCol($vetCampo['idt_setor'], 7);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['nm_funcao']),
    Array($vetCampo['cod_funcao'], '', $vetCampo['des_prefixo']),
    Array($vetCampo['cod_classificacao'], ' ', $vetCampo['cod_assinatura']),
    Array($vetCampo['sts_menu'], '', $vetCampo['sts_linha'], '', $vetCampo['gestao'], '', $vetCampo['procedimento']),
    Array($vetCampo['idt_setor']),
    Array($vetCampo['id_direito']),
));
$vetCad[] = $vetFrm;
?>