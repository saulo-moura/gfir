<?php
$tabela = 'cbo_importacao';
$id = 'idt';

$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 20, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);



$vetCampo['grande_grupo']        = objFile('grande_grupo', 'Grande Grupo', false, 60, 'todos');
$vetCampo['familia']             = objFile('familia', 'Família', false, 60, 'todos');
$vetCampo['sub_grupo_principal'] = objFile('sub_grupo_principal', 'Sub Grupo Principal', false, 60, 'todos');
$vetCampo['sub_grupo']           = objFile('sub_grupo', 'Sub Grupo', false, 60, 'todos');
$vetCampo['ocupacao']            = objFile('ocupacao', 'Ocupação', false, 60, 'todos');
$vetCampo['sinonimo']            = objFile('sinonimo', 'Sinônimo', false, 60, 'todos');


$vetExecuta=Array();
$vetExecuta['E']='Exclui';
$vetExecuta['S']='Executa';
$vetCampo['executa'] = objCmbVetor('executa', 'Executa Importação do CBO?', false, $vetExecuta);


$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Arquivos para Importação</span>', Array(
    Array($vetCampo['grande_grupo']),
    Array($vetCampo['familia']),
    Array($vetCampo['sub_grupo_principal']),
    Array($vetCampo['sub_grupo']),
    Array($vetCampo['ocupacao']),
    Array($vetCampo['sinonimo']),
    
    Array($vetCampo['executa']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>