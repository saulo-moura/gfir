<?php

$tabela = db_pir . "bc_rf_2015";
$id = 'idt';

$vetCampo['cnpj'] = objTexto('cnpj', 'CNPJ', False, 18, 18);
$vetCampo['razao_social'] = objTexto('razao_social', 'Razão Social', False, 40, 255);
$vetCampo['nome_fantasia'] = objTexto('nome_fantasia', 'Nome Fantasia', False, 40, 120);
$vetCampo['data_de_abertura'] = objTexto('data_de_abertura', 'Data Abertura', False, 15, 25);
$vetCampo['cnae_subclasse'] = objTexto('cnae_subclasse', 'Data Abertura', False, 15, 25);
$vetCampo['porte_cse_27mar2015_descr'] = objTexto('porte_cse_27mar2015_descr', 'Porte', False, 40, 255);

//$vetCampo['`Razão Social`'] = objTexto('`Razão Social`', 'Razão Social', False, 40, 255);
//$vetCampo['`Nome Fantasia`'] = objTexto('`Nome Fantasia`', 'Nome Fantasia', False, 40, 120);
//$vetCampo['`Porte CSE 27/mar/2015 (descr.)`'] = objTexto('`Porte CSE 27/mar/2015 (descr.)`', 'Porte', False, 10, 10);
//$vetCampo['`Atividade Econômica (cód. subclasse CNAE editado)`'] = objTexto('`Atividade Econômica (cód. subclasse CNAE editado)`', 'CNAE', False, 15, 25);
//$vetCampo['a'] = objTexto('a', 'A - Excluir1', False, 18, 18);
//$vetCampo['b'] = objTexto('b', 'B - CNPJ', False, 18, 18);
//$vetCampo['c'] = objTexto('c', 'C - Matriz', False, 18, 18);
//$vetCampo['d'] = objTexto('d', 'D - Razão Social', False, 40, 255);
//$vetCampo['e'] = objTexto('e', 'E - Nome Fantasia', False, 40, 120);
//$vetCampo['f'] = objTexto('f', 'F - Tipo Logradouro', False, 10, 10);
//$vetCampo['g'] = objTexto('g', 'G - Desc.Tipo Log', False, 25, 25);
//$vetCampo['h'] = objTexto('h', 'H - Logradouro', False, 40, 255);
//$vetCampo['i'] = objTexto('i', 'I - Numero Logradouro', False, 30, 30);
//$vetCampo['j'] = objTexto('j', 'J - Complem.logradouro', False, 40, 255);
//$vetCampo['k'] = objTexto('k', 'K - Bairro', False, 40, 120);
//$vetCampo['l'] = objTexto('l', 'L - CEP', False, 15, 15);
//$vetCampo['m'] = objTexto('m', 'M - Cod.Município', False, 20, 20);
//$vetCampo['n'] = objTexto('n', 'N - Nome Município', False, 40, 255);
//$vetCampo['o'] = objTexto('o', 'O - UF', False, 10, 10);
//$vetCampo['p'] = objTexto('p', 'P - Cod. País', False, 15, 15);
//$vetCampo['q'] = objTexto('q', 'Q - Cod.Nat.Jurídica', False, 15, 15);
//$vetCampo['r'] = objTexto('r', 'R - Desc.Nat.Jurídica', False, 40, 255);
//$vetCampo['s'] = objTexto('s', 'S - Cod.Sit.Cad.', False, 15, 15);
//$vetCampo['t'] = objTexto('t', 'T - Desc.Sit.Cad', False, 40, 255);
//$vetCampo['u'] = objTexto('u', 'U - Data Sit.Cad', False, 15, 15);
//$vetCampo['v'] = objTexto('v', 'V - Mot.Cod.Sit.Cad', False, 20, 20);
//$vetCampo['w'] = objTexto('w', 'W - Mot.Desc.Sit.Cad', False, 40, 255);
//$vetCampo['x'] = objTexto('x', 'X - Cod. CNAE', False, 15, 15);
//$vetCampo['y'] = objTexto('y', 'Y - Desc. CNAE', False, 40, 255);
//$vetCampo['z'] = objTexto('z', 'Z - Cod.CNAE2', False, 15, 25);
//$vetCampo['aa'] = objTexto('aa', 'AA - Cod.CNAE3', False, 15, 25);
//$vetCampo['ab'] = objTexto('ab', 'AB - Cod.CNAE4', False, 15, 25);
//$vetCampo['ac'] = objTexto('ac', 'AC - Cod.CNAE5', False, 15, 25);
//$vetCampo['ad'] = objTexto('ad', 'AD - Cod.CNAE6', False, 15, 25);
//$vetCampo['ae'] = objTexto('ae', 'AE - Cod.CNAE7', False, 15, 25);
//$vetCampo['af'] = objTexto('af', 'AF - Cod.CNAE8', False, 15, 25);
//$vetCampo['ag'] = objTexto('ag', 'AG - Cod.CNAE9', False, 15, 25);
//$vetCampo['ah'] = objTexto('ah', 'AH - Cod.CNAE10', False, 15, 25);
//$vetCampo['ai'] = objTexto('ai', 'AI - Cod.CNAE11', False, 15, 25);
//$vetCampo['aj'] = objTexto('aj', 'AJ - Excluir2', False, 18, 18);
//$vetCampo['ak'] = objTexto('ak', 'AK - Cod.Simples', False, 15, 25);
//$vetCampo['al'] = objTexto('al', 'AL - Desc.Simples', False, 40, 255);
//$vetCampo['am'] = objTexto('am', 'AM - Data Simples', False, 15, 15);
//$vetCampo['an'] = objTexto('an', 'AN - Data Simples Excl', False, 15, 25);
//$vetCampo['ao'] = objTexto('ao', 'AO - Data', False, 15, 25);
//$vetCampo['ap'] = objTexto('ap', 'AP - Cod.Trib', False, 10, 10);
//$vetCampo['aq'] = objTexto('aq', 'AQ - Cod Porte', False, 10, 10);
//$vetCampo['ar'] = objTexto('ar', 'AR - Desc.Porte', False, 40, 255);
//$vetCampo['ass'] = objTexto('ass', 'ASS - Dirpj', False, 10, 10);
//$vetCampo['at'] = objTexto('at', 'AT - Tel', False, 20, 20);
//$vetCampo['au'] = objTexto('au', 'AU - Num Empr', False, 10, 10);
//$vetCampo['av'] = objTexto('av', 'AV - Exclui3', False, 18, 18);

$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['cnpj'], '', $vetCampo['razao_social']),
    Array($vetCampo['nome_fantasia'], '', $vetCampo['data_de_abertura']),
    Array($vetCampo['cnae_subclasse'], '', $vetCampo['porte_cse_27mar2015_descr']),
//    Array($vetCampo['CNPJ'], '', $vetCampo['`Razão Social`']),
//    Array($vetCampo['`Nome Fantasia`'], '', $vetCampo['`Porte CSE 27/mar/2015 (descr.)`']),
//    Array($vetCampo['`Atividade Econômica (cód. subclasse CNAE editado)`']),
//    Array($vetCampo['a'],'',$vetCampo['b']),
//    Array($vetCampo['c'],'',$vetCampo['d']),
//
//    Array($vetCampo['e'],'',$vetCampo['f']),
//    Array($vetCampo['g'],'',$vetCampo['h']),
//
//    Array($vetCampo['i'],'',$vetCampo['j']),
//    Array($vetCampo['k'],'',$vetCampo['l']),
//
//    Array($vetCampo['m'],'',$vetCampo['n']),
//    Array($vetCampo['o'],'',$vetCampo['p']),
//
//    Array($vetCampo['q'],'',$vetCampo['r']),
//    Array($vetCampo['s'],'',$vetCampo['t']),
//
//    Array($vetCampo['u'],'',$vetCampo['v']),
//    Array($vetCampo['w'],'',$vetCampo['x']),
//
//    Array($vetCampo['y'],'',$vetCampo['z']),
//    Array($vetCampo['aa'],'',$vetCampo['ab']),
//
//    Array($vetCampo['ac'],'',$vetCampo['ad']),
//    Array($vetCampo['ae'],'',$vetCampo['af']),
//
//    Array($vetCampo['ag'],'',$vetCampo['ah']),
//    Array($vetCampo['ai'],'',$vetCampo['aj']),
//
//    Array($vetCampo['ak'],'',$vetCampo['al']),
//    Array($vetCampo['am'],'',$vetCampo['an']),
//
//    Array($vetCampo['ao'],'',$vetCampo['ap']),
//    Array($vetCampo['aq'],'',$vetCampo['ar']),
//
//    Array($vetCampo['ass'],'',$vetCampo['at']),
//    Array($vetCampo['au'],'',$vetCampo['av']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;