<?php
$tabela = 'db_pir.bc_siac';
$id = 'idt';
$vetCampo['A'] = objTexto('A', 'A - CNPJ', False, 18, 18);
$vetCampo['B'] = objTexto('B', 'B - CNPJ (12)', False, 18, 18);
$vetCampo['C'] = objTexto('C', 'C - CNPJ edit', False, 18, 18);
$vetCampo['D'] = objTexto('D', 'D - Código', False, 25, 25);
$vetCampo['E'] = objTexto('E', 'E - Razão Social', False, 40, 120);
$vetCampo['F'] = objTexto('F', 'F - Nome Fantasia', False, 40, 120);
$vetCampo['G'] = objTexto('G', 'G - Matriz/Filial', False, 15, 15);
$vetCampo['H'] = objTexto('H', 'H - Codigo NJ', False, 15, 15);
$vetCampo['I'] = objTexto('I', 'I - Descrição NJ', False, 40, 120);
$vetCampo['J'] = objTexto('J', 'J - Data Abertura', False, 12, 12);
$vetCampo['K'] = objTexto('K', 'K - Cod CNAE', False, 15, 15);
$vetCampo['L'] = objTexto('L', 'L - CNAE edit', False, 15, 15);
$vetCampo['M'] = objTexto('M', 'M - Descrição CNAE', False, 40, 120);
$vetCampo['N'] = objTexto('N', 'N - Setor IBGE', False, 25, 25);
$vetCampo['O'] = objTexto('O', 'O - UF', False, 15, 15);
$vetCampo['P'] = objTexto('P', 'P - Escritório Regional', False, 45, 45);
$vetCampo['Q'] = objTexto('Q', 'Q - Cod.Muniípio', False, 15, 15);
$vetCampo['R'] = objTexto('R', 'R - Município', False, 40, 60);
$vetCampo['S'] = objTexto('S', 'S - Tipo Endereço', False, 15, 15);
$vetCampo['T'] = objTexto('T', 'T - Logradouro', False, 40, 255);
$vetCampo['U'] = objTexto('U', 'U - Número Logradouro', False, 15, 15);
$vetCampo['V'] = objTexto('V', 'V - Complemento Logradouro', False, 40, 255);
$vetCampo['W'] = objTexto('W', 'W - Bairro', False, 40, 255);
$vetCampo['X'] = objTexto('X', 'X - CEP', False, 15, 15);
$vetCampo['Y'] = objTexto('Y', 'Y - Telefone (CEE2010)', False, 15, 25);
$vetCampo['Z'] = objTexto('Z', 'Z - Telefone (MEI2012)', False, 15, 25);
$vetCampo['AA'] = objTexto('AA', 'AA - Telefone (RFB2009)', False, 15, 25);
$vetCampo['AB'] = objTexto('AB', 'AB - Telefone (RFB2012)', False, 15, 25);
$vetCampo['AC'] = objTexto('AC', 'AC - Telefone (SIAC2012)', False, 15, 25);
$vetCampo['AD'] = objTexto('AD', 'AD - Telefone Celular (SIAC(2012)', False, 15, 25);
$vetCampo['AE'] = objTexto('AE', 'AE - Email (MEI2012)', False, 40, 255);
$vetCampo['AF'] = objTexto('AF', 'AF - Email (SIAC2012)', False, 40, 255);
$vetCampo['AG'] = objTexto('AG', 'AG - Cod.Porte (CSE2010)', False, 15, 25);
$vetCampo['AH'] = objTexto('AH', 'AH - Desc.Porte (CSE2010)', False, 25, 25);
$vetCampo['AI'] = objTexto('AI', 'AI - Cod.Porte (CSE2011)', False, 15, 25);
$vetCampo['AJ'] = objTexto('AJ', 'AJ - Desc.Porte (CSE2011)', False, 25, 25);
$vetCampo['AK'] = objTexto('AK', 'AK - Cod.Porte (CSE2012)', False, 15, 25);
$vetCampo['AL'] = objTexto('AL', 'AL - Desc.Porte (CSE2012)', False, 25, 25);
$vetCampo['AM'] = objTexto('AM', 'AM - Cod.porte siac jul2013', False, 15, 25);
$vetCampo['AN'] = objTexto('AN', 'AN - Desc.porte siac jul2013', False, 25, 25);
$vetCampo['AO'] = objTexto('AO', 'AO - Opção Simples 31/12/2010', False, 10, 10);
$vetCampo['AP'] = objTexto('AP', 'AP - Opção Simples 31/12/2011', False, 10, 10);
$vetCampo['AQ'] = objTexto('AQ', 'AQ - Opção Simples 31/12/2012', False, 10, 10);
$vetCampo['AR'] = objTexto('AR', 'AR - Opção Simei 31/12/2010', False, 10, 10);
$vetCampo['ASS'] = objTexto('ASS', 'AS - Opção Simei 31/12/2011', False, 10, 10);
$vetCampo['AT'] = objTexto('AT', 'AT - Opção Simei 31/12/2012', False, 10, 10);
$vetCampo['AU'] = objTexto('AU', 'AU - Prod.SIAC 2008', False, 10, 10);
$vetCampo['AV'] = objTexto('AV', 'AV - Prod.SIAC 2009', False, 40, 255);
$vetCampo['AW'] = objTexto('AW', 'AW - Prod.SIAC 2010', False, 40, 255);
$vetCampo['AX'] = objTexto('AX', 'AX - Prod.SIAC 2011', False, 40, 255);
$vetCampo['AY'] = objTexto('AY', 'AY - Prod.SIAC 2012', False, 40, 255);
$vetCampo['AZ'] = objTexto('AZ', 'AZ - RAIS 31/12/2010', False, 10, 10);
$vetCampo['BA'] = objTexto('BA', 'BA - RAIS 31/12/2011', False, 10, 10);
$vetCampo['BB'] = objTexto('BB', 'BB - Atividade 2010', False, 10, 10);
$vetCampo['BC'] = objTexto('BC', 'BC - Atividade 2011', False, 10, 10);
$vetCampo['BD'] = objTexto('BD', 'BD - Atividade 2012', False, 40, 255);
$vetCampo['BE'] = objTexto('BE', 'BE - Indicador CSE 2010', False, 10, 10);
$vetCampo['BF'] = objTexto('BF', 'BF - Fonte Registro', False, 15, 15);

$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['A'],'',$vetCampo['B']),
    Array($vetCampo['C'],'',$vetCampo['D']),

    Array($vetCampo['E'],'',$vetCampo['F']),
    Array($vetCampo['G'],'',$vetCampo['H']),

    Array($vetCampo['I'],'',$vetCampo['J']),
    Array($vetCampo['K'],'',$vetCampo['L']),

    Array($vetCampo['M'],'',$vetCampo['N']),
    Array($vetCampo['O'],'',$vetCampo['P']),

    Array($vetCampo['Q'],'',$vetCampo['R']),
    Array($vetCampo['S'],'',$vetCampo['T']),

    Array($vetCampo['U'],'',$vetCampo['V']),
    Array($vetCampo['W'],'',$vetCampo['X']),

    Array($vetCampo['Y'],'',$vetCampo['Z']),
    Array($vetCampo['AA'],'',$vetCampo['AB']),

    Array($vetCampo['AC'],'',$vetCampo['AD']),
    Array($vetCampo['AE'],'',$vetCampo['AF']),

    Array($vetCampo['AG'],'',$vetCampo['AH']),
    Array($vetCampo['AI'],'',$vetCampo['AJ']),

    Array($vetCampo['AK'],'',$vetCampo['AL']),
    Array($vetCampo['AM'],'',$vetCampo['AN']),

    Array($vetCampo['AO'],'',$vetCampo['AP']),
    Array($vetCampo['AQ'],'',$vetCampo['AR']),

    Array($vetCampo['ASS'],'',$vetCampo['AT']),
    Array($vetCampo['AU'],'',$vetCampo['AV']),

    Array($vetCampo['AW'],'',$vetCampo['AX']),
    Array($vetCampo['AY'],'',$vetCampo['AZ']),

    Array($vetCampo['BA'],'',$vetCampo['BB']),
    Array($vetCampo['BC'],'',$vetCampo['BD']),

    Array($vetCampo['BE'],'',$vetCampo['BF']),

),$class_frame,$class_titulo,$titulo_na_linha);



$vetCad[] = $vetFrm;
?>