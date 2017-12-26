<?php
$tabela = 'funcao';
$id     = 'id_funcao';

$vetCampo['nm_funcao'] = objTexto('nm_funcao', 'Nome', True, 92, 100);
$vetCampo['cod_funcao'] = objTexto('cod_funcao', 'Transaзгo', True, 50);
$vetCampo['des_prefixo'] = objTexto('des_prefixo', 'Prefixo Menu', True, 40, 40);
$vetCampo['cod_classificacao'] = objTexto('cod_classificacao', 'Classificaзгo', True, 92, 200);
$vetCampo['sts_menu'] = objCmbVetor('sts_menu', 'Mostra no Menu', True, $vetSimNao);
$vetCampo['sts_linha'] = objCmbVetor('sts_linha', 'Colocar linha separadora', True, $vetSimNao);

$sql_lst_1 = 'select id_direito, nm_direito from direito order by nm_direito';

$sql_lst_2  = 'select d.id_direito, df.id_difu, d.nm_direito from direito d inner join
               direito_funcao df on d.id_direito = df.id_direito
               where df.id_funcao = '.$_GET['id'].' order by d.nm_direito';

$vetCampo['id_direito'] = objLista('id_direito', True, 'Direitos do Sistema', 'sistema', $sql_lst_1, 'direito_funcao', 200, 'Direitos da Funзгo', 'funcao', $sql_lst_2, '', '', 'direito_perfil', 'id_difu');

$vetCampo['imagem'] = objFile('imagem', 'Imagem Menu', false, 40,'todos');

$vetCampo['coluna'] = objInteiro('coluna', 'Coluna', false, 10);
$vetCampo['linha']  = objInteiro('linha', 'Linha', false, 10);

$vetCampo['texto_cab'] = objTexto('texto_cab', 'texto Cab Icone', false, 15, 15);

$vetCampo['detalhe'] = objHTML('detalhe', 'Detalhe', false);

$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['hint'] = objTextArea('hint', 'Hint', false, $maxlength, $style, $js);


$vetCampo['visivel'] = objCmbVetor('visivel', 'Visнvel?', false, $vetSimNao);
$vetCampo['grupo_classe'] = objTexto('grupo_classe', 'Classe do Grupo', false, 15, 45);

$vetCampo['painel'] = objTexto('painel', 'Painel', false, 15, 45);


MesclarCol($vetCampo['nm_funcao'], 3);
MesclarCol($vetCampo['cod_classificacao'], 3);
MesclarCol($vetCampo['id_direito'], 3);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['nm_funcao']),
    Array($vetCampo['cod_funcao'], '', $vetCampo['des_prefixo']),
    Array($vetCampo['cod_classificacao']),
    Array($vetCampo['sts_menu'], '', $vetCampo['sts_linha']),
    Array($vetCampo['id_direito']),
));


//MesclarCol($vetCampo['imagem'], 7);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['painel'],'',$vetCampo['imagem']),
));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['linha'],'',$vetCampo['coluna'],'',$vetCampo['visivel'],'',$vetCampo['grupo_classe']),
));
$vetFrm[] = Frame('', Array(
    Array($vetCampo['texto_cab']),
    Array($vetCampo['hint']),
    Array($vetCampo['detalhe']),
));

$vetCad[] = $vetFrm;
?>