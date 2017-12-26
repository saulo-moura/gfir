<?php
$tabela = 'db_pir.bc_mei';
$id = 'idt';
$vetCampo['A'] = objTexto('A', 'A - Situação PJ', False, 18, 18);
$vetCampo['B'] = objTexto('B', 'B - Codigo Evento Simei', False, 18, 18);
$vetCampo['C'] = objTexto('C', 'C - Nome Evento Simei', False, 40, 255);
$vetCampo['D'] = objTexto('D', 'D - Data Efeito Exclusão', False, 25, 25);
$vetCampo['E'] = objTexto('E', 'E - NR NIRE', False, 20, 20);
$vetCampo['F'] = objTexto('F', 'F - NR CNPJ', False, 20, 20);
$vetCampo['G'] = objTexto('G', 'G - NR CPF', False, 15, 15);
$vetCampo['H'] = objTexto('H', 'H - Nome Pessoa Jurídica', False, 40, 255);
$vetCampo['I'] = objTexto('I', 'I - Nome Pessoa Física', False, 40, 255);
$vetCampo['J'] = objTexto('J', 'J - Data Nasc', False, 20, 20);
$vetCampo['K'] = objTexto('K', 'K - Nome Mãe', False, 40, 255);
$vetCampo['L'] = objTexto('L', 'L - Sexo', False, 10, 10);
$vetCampo['M'] = objTexto('M', 'M - Nacionalidade', False, 30, 30);
$vetCampo['N'] = objTexto('N', 'N - NR Identidade', False, 25, 25);
$vetCampo['O'] = objTexto('O', 'O - Órgão Emissor', False, 25, 25);
$vetCampo['P'] = objTexto('P', 'P - UF Emissor', False, 10, 10);
$vetCampo['Q'] = objTexto('Q', 'Q - DDD Telefone', False, 10, 10);
$vetCampo['R'] = objTexto('R', 'R - Nr Telefone', False, 20, 20);
$vetCampo['S'] = objTexto('S', 'S - Email', False, 40, 120);
$vetCampo['T'] = objTexto('T', 'T - Tipo Log.Comercial', False, 15, 15);
$vetCampo['U'] = objTexto('U', 'U - Logradouro Comercial', False, 40, 255);
$vetCampo['V'] = objTexto('V', 'V - Núm Log Comercial', False, 15, 15);
$vetCampo['W'] = objTexto('W', 'W - Complemento Comercial', False, 40, 255);
$vetCampo['X'] = objTexto('X', 'X - Bairro Comercial', False, 40, 255);
$vetCampo['Y'] = objTexto('Y', 'Y - CEP Comercial', False, 15, 15);
$vetCampo['Z'] = objTexto('Z', 'Z - Município Comercial', False, 40, 255);
$vetCampo['AA'] = objTexto('AA', 'AA - UF Comercial', False, 10, 10);
$vetCampo['AB'] = objTexto('AB', 'AB - Tipo Log.Residencial', False, 15, 25);
$vetCampo['AC'] = objTexto('AC', 'AC - Logradouro Residencial', False, 40, 255);
$vetCampo['AD'] = objTexto('AD', 'AD - Núm Log Residencial', False, 15, 15);
$vetCampo['AE'] = objTexto('AE', 'AE - Complemento Residencial', False, 40, 255);
$vetCampo['AF'] = objTexto('AF', 'AF - Bairro Residencial', False, 40, 255);
$vetCampo['AG'] = objTexto('AG', 'AG - CEP Residencial', False, 15, 15);
$vetCampo['AH'] = objTexto('AH', 'AH - Município Residencial', False, 40, 255);
$vetCampo['AI'] = objTexto('AI', 'AI - UF Residencial', False, 10, 10);
$vetCampo['AJ'] = objTexto('AJ', 'AJ - Capital Social', False, 25, 25);
$vetCampo['AK'] = objTexto('AK', 'AK - Data Iníc.Atividades', False, 15, 15);
$vetCampo['AL'] = objTexto('AL', 'AL - Cod.CNAE Principal', False, 15, 15);
$vetCampo['AM'] = objTexto('AM', 'AM - Desc.CNAE Principal', False, 40, 255);
$vetCampo['AN'] = objTexto('AN', 'AN - CNAE´s Secundários', False, 40, 255);

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

),$class_frame,$class_titulo,$titulo_na_linha);



$vetCad[] = $vetFrm;
?>