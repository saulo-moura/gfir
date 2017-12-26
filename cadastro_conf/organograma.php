<?
$idCampo = 'idt';

$vetCampo['titulo'] = CriaVetLista('Título', 'texto', 'titulo', True);

$vetCampo['l_des'] = CriaVetLista('Linguagem', 'texto', 'novidade', True);
$vetCampo['t_des'] = CriaVetLista('Tema', 'texto', 'novidade', True);
$vetCampo['a_des'] = CriaVetLista('Acervo', 'texto', 'novidade', True);
$vetCampo['e_des'] = CriaVetLista('Escolaridade', 'texto', 'novidade', True);
$vetCampo['pa_des'] = CriaVetLista('Publico Alvo', 'texto', 'novidade', True);

$vetCampo['descricao_resumida'] = CriaVetLista('Descrição Resumida', 'texto', 'novidade', True);
//$vetCampo['descricao_resumo'] = CriaVetLista('Resumo','texto','novidade',True);
$vetCampo['palavra_chave'] = CriaVetLista('Palavras-Chave', 'texto', 'novidade', True);
$vetCampo['autor1'] = CriaVetLista('Autor 1', 'texto', 'novidade', True);
$vetCampo['autor2'] = CriaVetLista('Autor 2', 'texto', 'novidade', True);
$vetCampo['autor3'] = CriaVetLista('Autor 3', 'texto', 'novidade', True);
$vetCampo['autor4'] = CriaVetLista('Autor 4', 'texto', 'novidade', True);
//$vetCampo['autor5'] = CriaVetLista('Autor 5','texto','novidade',True);
$vetCampo['editora1'] = CriaVetLista('Editora 1', 'texto', 'novidade', True);
$vetCampo['editora2'] = CriaVetLista('Editora 2', 'texto', 'novidade', True);
$vetCampo['isbn'] = CriaVetLista('ISBN', 'texto', 'novidade', True);
$vetCampo['data_publicacao'] = CriaVetLista('Data', 'data', 'novidade', True);
$vetCampo['ano_publicacao'] = CriaVetLista('Ano da Publicaçao', 'texto', 'novidade', True);

$vetCampo['qtd_paginas'] = CriaVetLista('Quantificar conteúdo, páginas e anexos Arquivo 1', 'texto', 'novidade', True);
$vetCampo['qtd_paginas2'] = CriaVetLista('Quantificar conteúdo, páginas e anexos Arquivo 2', 'texto', 'novidade', True);

$vetCampo['responsavel_publicacao'] = CriaVetLista('Responsável', 'texto', 'novidade', True);
$vetCampo['data_publicacao'] = CriaVetLista('Data da Publicação no Site', 'data', 'novidade', True);
$vetCampo['data_cadastro'] = CriaVetLista('Data Cadastro no Site', 'data', 'novidade', True);
//$vetCampo['situacao'] = CriaVetLista('Ativo?','texto', 'novidade',True);
$vetCampo['descricao_detalhada'] = CriaVetLista('Descrição Detalhada', 'texto', 'novidade', True);

$sql = 'select p.*, t.descricao as t_des, l.descricao as l_des, a.descricao as a_des,
        e.descricao as e_des, pa.descricao as pa_des
        from publicacao p 
        inner join tema t on p.idt_tema = t.idt 
        inner join linguagem l on p.idt_linguagem = l.idt
        inner join acervo a on p.idt_acervo = a.idt
        inner join escolaridade e on p.idt_escolaridade = e.idt
        inner join publico_alvo pa on p.idt_publico = pa.idt
        where p.idt = '.null($_GET['id']);
?>
