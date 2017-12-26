<?php

function ListarRegistros($rs, $vetCampo, $uppertxtcab = true) {
    $html = '';
    $html .= '<table class="tabela">';
    $html .= '<tr>';

    ForEach ($vetCampo as $Campo => $Valor) {
        $html .= '<td class="cT">';

        if ($uppertxtcab) {
            $html .= mb_strtoupper($Valor['nome'], 'iso-8859-1');
        } else {
            $html .= $Valor['nome'];
        }

        $html .= '</td>';
    }

    $html .= '</tr>';

    foreach ($rs->data as $i => $row) {
        $html .= '<tr>';

        ForEach ($vetCampo as $strCampo => $Valor) {
            $tipo = explode(", ", $Valor['tipo']);
            $strCampo = explode(", ", $strCampo);

            $html .= '<td class="cD">';

            $vlTD = '';
            ForEach ($strCampo as $idx => $Campo) {
                if (count($strCampo) > 1 && $idx > 0) {
                    $vlTD .= ' ';
                }

                switch ($tipo[$idx]) {
                    case 'descDominio':
                        if (count($strCampo) == 1) {
                            if ($Valor['vetDominio'][$row[$Campo]] == '')
                                $vlTD .= $row[$Campo];
                            else
                                $vlTD .= $Valor['vetDominio'][$row[$Campo]];
                        } else {
                            if ($Valor['vetDominio'][$idx][$row[$Campo]] == '')
                                $vlTD .= $row[$Campo];
                            else
                                $vlTD .= $Valor['vetDominio'][$idx][$row[$Campo]];
                        }
                        break;

                    case 'data':
                        $vlTD .= trata_data($row[$Campo]);
                        break;

                    case 'decimal':
                        $vlTD .= format_decimal($row[$Campo], $Valor['ndecimal']);
                        break;

                    case 'inteiro':
                        $vlTD .= format_decimal($row[$Campo], 0);
                        break;

                    case 'arquivo':
                        $vlTD .= '';
                        $path = $dir_file . '/' . $Valor['tabela'] . '/';
                        $vlTD .= ImagemProdListarConf($Valor['vetDominio'], $path, $row[$Campo], $row[$idCampo] . '_' . $Campo . '_', false, true);

                        break;

                    case 'arquivo_link':
                        $vlTD .= '';
                        $path = $dir_file . '/' . $Valor['tabela'] . '/';

                        $vlTD .= ArquivoLink($path, $row[$Campo], $row[$idCampo] . '_' . $Campo . '_', '', '', true);
                        break;

                    case 'link':
                        $stx = "<span style='color:#0080C0; text-decoration:none;'>";
                        $stx .= "<a href='$row[$Campo]' target='_blank' style='font-size:13px; font-weight: bold; cursor:pointer; color:#0080C0; text-decoration:none;'>" . $row[$Campo] . "</a>";
                        $stx .= "</span>";
                        $vlTD .= $stx;
                        break;


                    case 'func_trata_dado':
                        $vlTD .= $Valor['vetDominio']($row[$Campo], $row, $Campo);
                        break;

                    default:
                        $vlTD .= $row[$Campo];
                        break;
                }
            }

            $html .= $vlTD . '</td>';
        }

        $html .= '</tr>';
    }

    $html .= '</table>';

    return $html;
}

$sql = '';
$sql .= " select pr.*, t1.descricao as situacao_atual, t2.descricao as entidade_autora, t3.descricao as unidade_autora, t4.descricao as unidade_responsavel,";
$sql .= " t5.descricao as programa, t6.descricao as instrumento, t7.descricao as familia, t8.descricao as grupo, t9.descricao as modalidade,";
$sql .= " t10.descricao as foco_tematico, t11.descricao as natureza_servico, t12.descricao as direitos_autorais, t13.descricao as modelo_certificado, t14.descricao as maturidade,";
$sql .= " t15.descricao as grau_escolaridade, t16.descricao as publico_alvo,";
$sql .= " t5.tipo_ordem";
$sql .= ' from grc_produto pr';
$sql .= ' left outer join grc_produto_situacao t1 on t1.idt = pr.idt_produto_situacao';
$sql .= ' left outer join grc_produto_abrangencia t2 on t2.idt = pr.idt_produto_abrangencia';
$sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao t3 on t3.idt = pr.idt_secao_autora';
$sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao t4 on t4.idt = pr.idt_secao_responsavel';
$sql .= ' left outer join ' . db_pir_gec . 'gec_programa t5 on t5.idt = pr.idt_programa';
$sql .= ' left outer join grc_atendimento_instrumento t6 on t6.idt = pr.idt_instrumento';
$sql .= ' left outer join grc_produto_familia t7 on t7.idt = pr.idt_produto_familia';
$sql .= ' left outer join grc_produto_grupo t8 on t8.idt = pr.idt_grupo';
$sql .= ' left outer join grc_produto_modalidade t9 on t9.idt = pr.idt_modalidade';
$sql .= ' left outer join grc_foco_tematico t10 on t10.idt = pr.idt_foco_tematico';
$sql .= ' left outer join grc_produto_tipo t11 on t11.idt = pr.idt_produto_tipo';
$sql .= ' left outer join grc_produto_tipo_autor t12 on t12.idt = pr.idt_foco_tematico';
$sql .= ' left outer join grc_produto_modelo_certificado t13 on t13.idt = pr.idt_produto_modelo_certificado';
$sql .= ' left outer join grc_produto_maturidade t14 on t14.idt = pr.idt_produto_maturidade';
$sql .= ' left outer join ' . db_pir_gec . 'gec_entidade_grau_formacao t15 on t15.idt = pr.idt_grau_escolaridade';
$sql .= ' left outer join grc_publico_alvo t16 on t16.idt = pr.idt_publico_alvo';

$sql .= ' where pr.idt = ' . null($_GET['id']);
$rs = execsql($sql);

if ($rs->rows == 1) {
    $row = $rs->data[0];

    $vetParametro = Array();

    $vetParametro['#nome_titulo#'] = $nome_titulo;
    $vetParametro['#data_hora_atual#'] = date('d/m/Y') . ' ' . (date('H') - date('I')) . ':' . date('i');
    $vetParametro['#nome_usuario#'] = $_SESSION[CS]['g_nome_completo'];

    $vetParametro['#descricao#'] = $row['descricao'];
    $vetParametro['#codigo#'] = $row['codigo'];
    $vetParametro['#copia#'] = $row['copia'];
    $vetParametro['#ativo#'] = $vetSimNao[$row['ativo']];
    $vetParametro['#codigo_classificacao_siac#'] = $row['codigo_classificacao_siac'];
    $vetParametro['#descricao_siac#'] = $row['descricao_siac'];
    $vetParametro['#situacao_atual#'] = $row['situacao_atual'];
    $vetParametro['#entidade_autora#'] = $row['entidade_autora'];
    $vetParametro['#unidade_autora#'] = $row['unidade_autora'];
    $vetParametro['#unidade_responsavel#'] = $row['unidade_responsavel'];
    $vetParametro['#programa#'] = $row['programa'];
    $vetParametro['#instrumento#'] = $row['instrumento'];
    $vetParametro['#familia#'] = $row['familia'];
    $vetParametro['#grupo#'] = $row['grupo'];
    $vetParametro['#modalidade#'] = $row['modalidade'];
    $vetParametro['#foco_tematico#'] = $row['foco_tematico'];
    $vetParametro['#natureza_servico#'] = $row['natureza_servico'];
    $vetParametro['#direitos_autorais#'] = $row['direitos_autorais'];
    $vetParametro['#modelo_certificado#'] = $row['modelo_certificado'];
    $vetParametro['#maturidade#'] = $row['maturidade'];
    $vetParametro['#gratuito#'] = $vetSimNao[$row['gratuito']];
    $vetParametro['#grau_escolaridade#'] = $row['grau_escolaridade'];
    $vetParametro['#participante_minimo#'] = $row['participante_minimo'];
    $vetParametro['#participante_maximo#'] = $row['participante_maximo'];
    $vetParametro['#encontro_quantidade#'] = $row['encontro_quantidade'];
    $vetParametro['#encontro_texto#'] = $row['encontro_texto'];
    $vetParametro['#publico_alvo#'] = $row['publico_alvo'];
    $vetParametro['#publico_alvo_texto#'] = conHTML($row['publico_alvo_texto']);
    $vetParametro['#palavra_chave#'] = conHTML($row['palavra_chave']);
    $vetParametro['#carga_horaria#'] = conHTML($row['carga_horaria']);
    $vetParametro['#carga_horaria_2#'] = conHTML($row['carga_horaria_2']);
    $vetParametro['#objetivo#'] = $row['objetivo'];
    $vetParametro['#detalhe#'] = $row['detalhe'];
    $vetParametro['#conteudo_programatico#'] = $row['conteudo_programatico'];
    $vetParametro['#beneficio#'] = $row['beneficio'];
    $vetParametro['#complemento#'] = $row['complemento'];
    $vetParametro['#descricao_comercial#'] = $row['descricao_comercial'];
    $vetParametro['#todas_unidade_regional#'] = $vetSimNao[$row['todas_unidade_regional']];
    $vetParametro['#rtotal_minimo#'] = format_decimal($row['rtotal_minimo']);
    $vetParametro['#ctotal_minimo#'] = format_decimal($row['ctotal_minimo']);
    $vetParametro['#dif_minimo#'] = format_decimal($row['dif_minimo']);
    $vetParametro['#rtotal_maximo#'] = format_decimal($row['rtotal_maximo']);
    $vetParametro['#ctotal_maximo#'] = format_decimal($row['ctotal_maximo']);
    $vetParametro['#dif_maximo#'] = format_decimal($row['dif_maximo']);
    $vetParametro['#rmedia#'] = format_decimal($row['rmedia']);
    $vetParametro['#cmedio#'] = format_decimal($row['cmedio']);
    $vetParametro['#dif_medio#'] = format_decimal($row['dif_medio']);

    $vetTpRel = Array();
    $vetTpRel['C'] = 'Combo';
    $vetTpRel['P'] = 'Predecessora';

    $vetCampo = Array();
    $vetCampo['grc_pp_descricao'] = CriaVetTabela('Produto');
    $vetCampo['detalhe'] = CriaVetTabela('Detalhe');
    $vetCampo['tipo_relacao'] = CriaVetTabela('Tipo de Relação?', 'descDominio', $vetTpRel);
    $vetCampo['obrigatorio'] = CriaVetTabela('Obrigatório?', 'descDominio', $vetSimNao);
    $vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

    $TabelaPrinc = "grc_produto_produto";
    $AliasPric = "grc_atdp";
    $orderby = "{$AliasPric}.codigo";

    $sql = "select {$AliasPric}.*, grc_pp.descricao as grc_pp_descricao";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join grc_produto grc_pp on grc_pp.idt = {$AliasPric}.idt_produto_associado ";
    $sql .= " where {$AliasPric}" . '.idt_produto = ' . null($_GET['id']);
    $sql .= " order by {$orderby}";

    $vetParametro['#produtos_associados#'] = ListarRegistros(execsql($sql), $vetCampo);

    $vetCampo = Array();
    $vetCampo['gec_ac_descricao'] = CriaVetTabela('Área de Conhecimento');
    $vetCampo['detalhe'] = CriaVetTabela('Detalhe');

    $TabelaPrinc = "grc_produto_area_conhecimento";
    $AliasPric = "grc_procp";
    $orderby = "gec_ac.codigo";

    $sql = "select {$AliasPric}.*, ";
    $sql .= "       gec_ac.descricao as gec_ac_descricao ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join " . db_pir_gec . "gec_area_conhecimento gec_ac on gec_ac.idt = {$AliasPric}.idt_area ";
    $sql .= " where {$AliasPric}" . '.idt_produto = ' . null($_GET['id']);
    $sql .= " order by {$orderby}";

    $vetParametro['#areas_de_conhecimentos#'] = ListarRegistros(execsql($sql), $vetCampo);

    $vetCampo = Array();
    $vetCampo['codigo'] = CriaVetTabela('Código');
    $vetCampo['versao'] = CriaVetTabela('Versão');
    $vetCampo['titulo'] = CriaVetTabela('Título');
    $vetCampo['detalhe'] = CriaVetTabela('Detalhe');
    $vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

    $TabelaPrinc = "grc_produto_arquivo_associado";
    $AliasPric = "grc_proaa";
    $orderby = "{$AliasPric}.codigo";

    $sql = "select {$AliasPric}.* ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " where {$AliasPric}" . '.idt_produto = ' . null($_GET['id']);
    $sql .= " order by {$orderby}";

    $vetParametro['#arquivos_associados#'] = ListarRegistros(execsql($sql), $vetCampo);

    $vetCampo = Array();
    $vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Responsável');
    $vetCampo['grc_pp_descricao'] = CriaVetTabela('Relação');
    $vetCampo['detalhe'] = CriaVetTabela('Detalhe');

    $TabelaPrinc = "grc_produto_realizador";
    $AliasPric = "grc_prore";
    $orderby = "{$AliasPric}.codigo";

    $sql = "select {$AliasPric}.*, ";
    $sql .= "       plu_usu.nome_completo as plu_usu_nome_completo, ";
    $sql .= "       grc_pp.descricao as grc_pp_descricao ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join grc_produto_realizador_relacao grc_pp on grc_pp.idt = {$AliasPric}.idt_relacao ";
    $sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_usuario ";
    $sql .= " where {$AliasPric}" . '.idt_produto = ' . null($_GET['id']);
    $sql .= " order by {$orderby}";

    $vetParametro['#gestores_do_produto#'] = ListarRegistros(execsql($sql), $vetCampo);

    $vetCampo = Array();
    $vetCampo['sca_os_descricao'] = CriaVetTabela('Unidade Regional');
    $vetCampo['detalhe'] = CriaVetTabela('Detalhe');

    $TabelaPrinc = "grc_produto_unidade_regional";
    $AliasPric = "grc_procp";
    $orderby = "sca_os.codigo";

    $sql = "select {$AliasPric}.*, ";
    $sql .= "       sca_os.descricao as sca_os_descricao ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join " . db_pir . "sca_organizacao_secao sca_os on sca_os.idt = {$AliasPric}.idt_unidade_regional ";
    $sql .= " where {$AliasPric}" . '.idt_produto = ' . null($_GET['id']);
    $sql .= " order by {$orderby}";

    $vetParametro['#unidade_regional#'] = ListarRegistros(execsql($sql), $vetCampo);

    $vetCampo = Array();
    $vetCampo['grc_iec_descricao'] = CriaVetTabela('Tipo de Receita');
    $vetCampo['grc_pp_descricao'] = CriaVetTabela('Insumo');
    $vetCampo['descricao'] = CriaVetTabela('Complemento Descrição');
    $vetCampo['grc_iu_descricao'] = CriaVetTabela('Unid.');
    $vetCampo['quantidade'] = CriaVetTabela('Quant.', 'decimal');
    $vetCampo['custo_unitario_real'] = CriaVetTabela('Receita (R$)<br />Unitária', 'decimal');
    $vetCampo['receita_total'] = CriaVetTabela('Receita (R$)<br />Total', 'decimal');
    $vetCampo['por_participante'] = CriaVetTabela('Por <br />parti.?', 'descDominio', $vetSimNao);
    $vetCampo['rtotal_minimo'] = CriaVetTabela('Receita (R$)<br />Mínima', 'decimal');
    $vetCampo['rtotal_maximo'] = CriaVetTabela('Receita (R$)<br />Máxima', 'decimal');
    $vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

    $TabelaPrinc = "grc_produto_insumo";
    $AliasPric = "grc_proins";
    $orderby = "grc_iec.descricao, grc_pp.classificacao";

    $sql = "select {$AliasPric}.*, ";
    $sql .= "       grc_pp.classificacao as grc_pp_classificacao, ";
    $sql .= "       grc_pp.descricao as grc_pp_descricao, ";
    $sql .= "       grc_iec.descricao as grc_iec_descricao, ";
    $sql .= "       grc_pp.sinal as grc_pp_sinal, ";
    $sql .= "       grc_iu.descricao as grc_iu_descricao ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join grc_insumo grc_pp on grc_pp.idt = {$AliasPric}.idt_insumo ";
    $sql .= " left join grc_insumo_elemento_custo grc_iec on grc_iec.idt = grc_pp.idt_insumo_elemento_custo ";
    $sql .= " inner join grc_insumo_unidade grc_iu on grc_iu.idt = {$AliasPric}.idt_insumo_unidade ";
    $sql .= " where {$AliasPric}" . '.idt_produto = ' . null($_GET['id']);
    $sql .= " and grc_pp.sinal = " . aspa('N'); // despesa
    $sql .= " order by {$orderby}";

    $vetParametro['#planilha_de_receitas#'] = ListarRegistros(execsql($sql), $vetCampo);

    $vetCampo = Array();
    $vetCampo['grc_iec_descricao'] = CriaVetTabela('Tipo Custo');
    $vetCampo['grc_pp_descricao'] = CriaVetTabela('Insumo');
    $vetCampo['descricao'] = CriaVetTabela('Complemento Descrição');
    $vetCampo['grc_iu_descricao'] = CriaVetTabela('Unid.');
    $vetCampo['quantidade'] = CriaVetTabela('Quant.', 'decimal');
    $vetCampo['custo_unitario_real'] = CriaVetTabela('Custo (R$)<br />Unitário', 'decimal');
    $vetCampo['custo_total'] = CriaVetTabela('Custo (R$)<br />Total', 'decimal');
    $vetCampo['por_participante'] = CriaVetTabela('Por <br />parti.?', 'descDominio', $vetSimNao);
    $vetCampo['ctotal_minimo'] = CriaVetTabela('Custo (R$)<br />Mínimo', 'decimal');
    $vetCampo['ctotal_maximo'] = CriaVetTabela('Custo (R$)<br />Máximo', 'decimal');
    $vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

    $TabelaPrinc = "grc_produto_insumo";
    $AliasPric = "grc_proins";
    $orderby = "grc_iec.descricao, grc_pp.classificacao";

    $sql = "select {$AliasPric}.*, ";
    $sql .= "       grc_pp.classificacao as grc_pp_classificacao, ";
    $sql .= "       grc_pp.descricao as grc_pp_descricao, ";
    $sql .= "       grc_iec.descricao as grc_iec_descricao, ";
    $sql .= "       grc_pp.sinal as grc_pp_sinal, ";
    $sql .= "       grc_iu.descricao as grc_iu_descricao ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join grc_insumo grc_pp on grc_pp.idt = {$AliasPric}.idt_insumo ";
    $sql .= " left join grc_insumo_elemento_custo grc_iec on grc_iec.idt = grc_pp.idt_insumo_elemento_custo ";
    $sql .= " inner join grc_insumo_unidade grc_iu on grc_iu.idt = {$AliasPric}.idt_insumo_unidade ";
    $sql .= " where {$AliasPric}" . '.idt_produto = ' . null($_GET['id']);
    $sql .= " and grc_pp.sinal = " . aspa('S'); // despesa
    $sql .= " order by {$orderby}";

    $vetParametro['#planilha_de_despesas#'] = ListarRegistros(execsql($sql), $vetCampo);

    $vetCampo = Array();
    $vetCampo['codigo'] = CriaVetTabela('Versão');
    $vetCampo['descricao'] = CriaVetTabela('Descrição');
    $vetCampo['ativo'] = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao);

    $TabelaPrinc = "grc_produto_versao";
    $AliasPric = "grc_prooc";
    $orderby = "{$AliasPric}.codigo";

    $sql = "select {$AliasPric}.*, ";
    $sql .= "       grc_pp.descricao as grc_pp_descricao ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join grc_produto grc_pp on grc_pp.idt = {$AliasPric}.idt_produto ";
    $sql .= " where {$AliasPric}" . '.idt_produto = ' . null($_GET['id']);
    $sql .= " order by {$orderby}";

    $vetParametro['#versoes#'] = ListarRegistros(execsql($sql), $vetCampo);

    $vetCampo = Array();
    $vetCampo['data'] = CriaVetTabela('Data', 'data');
    $vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Responsável');
    $vetCampo['descricao'] = CriaVetTabela('Descrição');
    $vetCampo['detalhe'] = CriaVetTabela('Detalhe');

    $TabelaPrinc = "grc_produto_ocorrencia";
    $AliasPric = "grc_prooc";
    $orderby = "{$AliasPric}.codigo";

    $sql = "select {$AliasPric}.*, ";
    $sql .= "       plu_usu.nome_completo as plu_usu_nome_completo ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " inner join grc_produto grc_pp on grc_pp.idt = {$AliasPric}.idt_produto ";
    $sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_responsavel ";
    $sql .= " where {$AliasPric}" . '.idt_produto = ' . null($_GET['id']);
    $sql .= " order by {$orderby}";

    $vetParametro['#ocorrencias#'] = ListarRegistros(execsql($sql), $vetCampo);

    $vetCampo = Array();
    $vetCampo['descricao'] = CriaVetTabela('ENTREGAS');
    $vetCampo['evidencia'] = CriaVetTabela('DOCUMENTO(S) - EVIDÊNCIA(S)');
    $vetCampo['percentual'] = CriaVetTabela('Percentual', 'decimal');

    $sql = '';
    $sql .= " select pe.descricao, pe.percentual,";
    $sql .= " group_concat(distinct d.descricao order by d.descricao separator '<br />') as evidencia";
    $sql .= " from grc_produto_entrega pe";
    $sql .= " left outer join grc_produto_entrega_documento ped on ped.idt_produto_entrega = pe.idt";
    $sql .= " left outer join " . db_pir_gec . "gec_documento d on d.idt = ped.idt_documento";
    $sql .= ' where pe.idt_produto = ' . null($row['idt']);
    $sql .= ' group by pe.descricao, pe.percentual';
    $sql .= " order by pe.descricao";

    $vetParametro['#entregas_do_produto#'] = ListarRegistros(execsql($sql), $vetCampo, false);

    $vetCampo = Array();
    $vetCampo['codigo'] = CriaVetTabela('Código');
    $vetCampo['descricao'] = CriaVetTabela('Dimensionamento (Respondido pelo Cliente)');
    $vetCampo['unidade'] = CriaVetTabela('Unidade');

    $sql = '';
    $sql .= " select pd.codigo, pd.descricao, u.descricao as unidade";
    $sql .= " from grc_produto_dimensionamento pd";
    $sql .= " left outer join grc_insumo_unidade u on u.idt = pd.idt_insumo_unidade";
    $sql .= ' where pd.idt_produto = ' . null($row['idt']);
    $sql .= " order by pd.codigo, pd.descricao";

    $vetParametro['#dimensionamento_da_demanda#'] = ListarRegistros(execsql($sql), $vetCampo, false);

    if ($row['tipo_ordem'] == 'SG') {
        $ficha = 'produto_ficha_sg_';
    } else {
        $ficha = 'produto_ficha_';
    }

    $sql = '';
    $sql .= ' select detalhe';
    $sql .= ' from grc_parametros';
    $sql .= " where codigo = '{$ficha}cab'";
    $rs = execsql($sql);
    $header = $rs->data[0][0];

    $sql = '';
    $sql .= ' select detalhe';
    $sql .= ' from grc_parametros';
    $sql .= " where codigo = '{$ficha}rod'";
    $rs = execsql($sql);
    $footer = $rs->data[0][0];

    $sql = '';
    $sql .= ' select detalhe';
    $sql .= ' from grc_parametros';
    $sql .= " where codigo = '{$ficha}cont'";
    $rs = execsql($sql);
    $htmlPDF = $rs->data[0][0];

    foreach ($vetParametro as $key => $value) {
        $header = str_replace($key, $value, $header);
        $footer = str_replace($key, $value, $footer);
        $htmlPDF = str_replace($key, $value, $htmlPDF);
    }

    $ME = 5;
    $MD = 5;
    $MS = 30;
    $MB = 7;
    $MHEADER = 3;
    $MFOOTER = 5;

    $mpdf = new mPDF('win-1252', 'A4', '10', '', $ME, $MD, $MS, $MB, $MHEADER, $MFOOTER, 'P');

    $header = utf8_encode($header);
    $mpdf->SetHTMLHeader($header);
    $mpdf->SetHTMLHeader($header, 'E');

    $footer = utf8_encode($footer);
    $mpdf->SetHTMLFooter($footer);
    $mpdf->SetHTMLFooter($footer, 'E');

    $return = $vetParametro;
    echo $htmlPDF;
}