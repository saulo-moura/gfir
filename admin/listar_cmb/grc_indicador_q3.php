<?php
$ordFiltro = false;
$idCampo = 'idt';
$Tela = "o Atendimento";

$listar_sql_limit = false;
$ano_base = '2017';
$TabelaPrinc = "grc_dw_{$ano_base}_indicadores_qualidade";
$AliasPric = "grc_atd";
$Entidade = "Atendimento";
$Entidade_p = "Atendimentos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$barra_inc_ap = false;
$barra_alt_ap = false;
$barra_con_ap = false;
$barra_exc_ap = false;
$barra_fec_ap = false;

$barra_inc_img = "imagens/incluir_novo_atendimento.png";

$barra_inc_h = 'Clique aqui para Incluir um Novo Atendimento';
$barra_alt_h = 'Alterar o Atendimento';
$barra_con_h = 'Consultar o Atendimento';

$tipoidentificacao = 'N';
$tipofiltro = 'N';
$comListarCmb_SoVoltar = true;

$comcontrole = 0;

$vetCampo['protocolo'] = CriaVetTabela('Protocolo');
$vetCampo['nome_consultor'] = CriaVetTabela('Atendente');
$vetCampo['cpf'] = CriaVetTabela('CPF');
$vetCampo['nome'] = CriaVetTabela('Nome');
$vetCampo['cnpj'] = CriaVetTabela('CNPJ');
$vetCampo['razao_social'] = CriaVetTabela('Razão Social');
$vetCampo['data_atendimento'] = CriaVetTabela('Data Atend. ', 'data');

$vetTmp = Array(
    'S' => 'Inconsistente',
    'N' => 'Consistente',
);
$vetCampo['indicador_3_inconsistente'] = CriaVetTabela('Resultado do Indicador', 'descDominio', $vetTmp);

$sql = '';
$sql .= ' select d.protocolo, d.nome_consultor, d.cpf, d.nome, d.cnpj, d.razao_social, d.data_atendimento, d.indicador_3_inconsistente';
$sql .= " from grc_dw_{$ano_base}_matriz_campos_iq_3 iq";
$sql .= " inner join grc_dw_{$ano_base}_matriz_campos c on c.idt = iq.idt_dw_matriz_campos";
$sql .= " inner join grc_dw_{$ano_base}_indicadores_qualidade d on d.idt = iq.idt_dw_indicadores_qualidade";
$sql .= ' where c.idt = ' . null($_GET['idt_campo']);
$sql .= ' and iq.idt_dw_indicadores_qualidade <> ' . null($_GET['idt']);
$sql .= " and c.inconsistente = 'S'";
