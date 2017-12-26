<?php
if ($debug || $_SESSION[CS]['g_vetMenuDados'] == '') {
    $sql = 'select * from plu_site_funcao';
    $rs = execsql($sql);

    $vetMenuDados = Array();

    ForEach ($rs->data as $row) {
        $vetMenuDados[$row['cod_funcao']] = $row;

    }

    $_SESSION[CS]['g_vetMenuDados'] = $vetMenuDados;
} else {
    $vetMenuDados = $_SESSION[CS]['g_vetMenuDados'];
}

if ($debug || $_SESSION[CS]['g_vetConf'] == '') {
    $sql = 'select * from plu_config';
    $rs = execsql($sql);

    $vetConf = Array();
    $vetConfJS = Array();

    ForEach ($rs->data as $row) {
        $vetConf[$row['variavel']] = trim($row['valor'].($row['extra'] == '' ? '' : ' '.$row['extra']));
        $vetConf[$row['variavel'].'_valor'] = $row['valor'];
        $vetConf[$row['variavel'].'_extra'] = $row['extra'];

        if ($row['js'] == 'S') {
            $vetConfJS[$row['variavel']] = trim($row['valor'].($row['extra'] == '' ? '' : ' '.$row['extra']));
            $vetConfJS[$row['variavel'].'_valor'] = $row['valor'];
            $vetConfJS[$row['variavel'].'_extra'] = $row['extra'];
        }
    }

    $_SESSION[CS]['g_vetConf'] = $vetConf;
    $_SESSION[CS]['g_vetConfJS'] = $vetConfJS;
} else {
    $vetConf = $_SESSION[CS]['g_vetConf'];
    $vetConfJS = $_SESSION[CS]['g_vetConfJS'];
}

if ($debug || $_SESSION[CS]['g_vetMime'] == '' || $_SESSION[CS]['g_vetMimeJS'] == '') {
    $sql = 'select gr.cod_grupo, ma.des_extensao, mt.des_tipo from
            plu_mime_grupo gr inner join plu_mime_grar mg on gr.idt_migr = mg.idt_migr
            inner join plu_mime_arquivo ma on mg.idt_miar = ma.idt_miar
            inner join plu_mime_tipo mt on ma.idt_miar = mt.idt_miar';
    $rs = execsql($sql);

    $vetMime = Array();
    ForEach ($rs->data as $row) {
        $vetMime[mb_strtolower($row['cod_grupo'])][mb_strtolower($row['des_extensao'])][] = mb_strtolower($row['des_tipo']);
    }

    $vetMimeJS = Array();
    ForEach ($vetMime as $idx => $row) {
        $vetMimeJS[$idx] = implode(",", array_keys($row));
    }

    $_SESSION[CS]['g_vetMime'] = $vetMime;
    $_SESSION[CS]['g_vetMimeJS'] = $vetMimeJS;
} else {
    $vetMime = $_SESSION[CS]['g_vetMime'];
    $vetMimeJS = $_SESSION[CS]['g_vetMimeJS'];
}

if ($debug || $_SESSION[CS]['g_vetMenu'] == '') {

    /*
      $vetMenu = Array(
      'dados_empreendimento' => 'Dados do Empreendimento',
      'resumo_gerencial' => 'Resumo Gerencial',
      'informacao_gerencial' => 'Informações Gerenciais',

      //  'habite' => 'Habite-se',
      'indice_empreendimento' => 'Índices',

      // 'indice_projeto' => 'Índices Projeto',

      // 'indice_projeto' => 'Indicadores de Projetos',
      'aditivo_orcamento' => 'Aditivo',

      // 'greve' => 'Paralizações',
      'documentos' => 'Documentos',

      //        'contrato_construcao' => 'Contrato de Construção',
      //        'alvaras' => 'Alvarás, Licenças e TAC’s',
      //        'ordem_servico' => 'Ordem de Serviço',
      //        'concessionaria' => 'Concessionárias',

      //        'viabilidade_economica' => 'Viabilidade Econômica',
      //        'fechamento' => 'Fechamento',
      //        'notificacao' => 'Notificações',
      //        'aditivos_doc' => 'Aditivos',
      //        'termo_conclusao' => 'Termo de conclusão',



      'administrativo' => 'Administrativo',
      //        'inventario' => 'Inventário',
      'titulo_protestado' => 'Títulos Protestados',
      //  'pagamento_juro' => 'Pagamento de Juros',

      'juro_pago' => 'Pagamento de Juros',

      'imobilizado' => 'Imobilizado',
      'financeiro' => 'Financeiro',
      'fluxo_financeiro' => 'Fluxo Financeiro',
      'financiamento' => 'Financiamento',
      //        'titulo_protestado' => 'Títulos Protestados',
      //        'pagamento_juro' => 'Pagamento de Juros',

      'medicao' => 'Medições',
      'mov_ep' => 'MOV',
      'honorario_ce' => 'Honorários',
      'et_ce' => 'Equipe Técnica',


      'oas_exclusive' => 'Oas Exclusive',
      'demonstrativo_m' => 'Relatório Econômico',
      'demonstrativo'   => 'Mensal',
      'demonstrativo2'   => 'Comparativo',

      'orcamento' => 'Orçamento',
      //   'desvio_orcamento' => 'Desvio de Orçamento',
      'orcamento_sintetico' => 'Orçamento Sintético',
      'despesa_direta' => 'Despesas Diretas',
      'despesa_indireta' => 'Despesas Indiretas/Taxas',
      'abc_servico' => 'ABC Serviço',
      'abc_insumo' => 'ABC Insumo',
      //        'cronograma' => 'Cronogramas',
      //  'fisico_financeiro_s' => 'Físico/Financeiro - Curva S',
      //        'fisico_financeiro_g' => 'Físico/Financeiro - Gantt',
      //  'linha_balanco' => 'Linhas de Balanço',
      //       'contratacao' => 'Contratação',
      //       'desvio_prazo' => 'Desvio de Prazo',

      //   'mapeamento_fisico' => 'Mapeamento Físico',
      'mapeamento_fisico' => 'Físico/Cronograma',
      'avanco_fisico' => 'Avanço Físico',
      'fisico_financeiro_ga' => 'Cronograma',
      'desvio_prazo' => 'Desvio de Prazo',

      //  'servico_pavimento' => 'Serviços',

      //     'servico_pavimento' => 'Mapeamento Físico',

      //     'macro_fluxo' => 'Macrofluxo',


      //    'entrega_apartamento' => 'Entrega de Apartamentos',
      'departamento_pessoal' => 'Recursos Humanos',
      'organograma' => 'Organograma',
      'dado_estatistico' => 'Faltas/Atestados',
      'quadro_funcionario' => 'Quadro de Funcionários',
      'pessoal_efetivo' => 'Efetivo Atual',
      'hora_extra' => 'Hora extra',
      //     'rotatividade' => 'Rotatividade',

      ///        'contrato_ger' => 'Contratos',

      //     'contrato_fornecedor_inc' => 'Por Fornecedor',
      //     'contrato_servico_inc' => 'Por Serviço',
      //     'contrato_gerencial_cont' => 'Posição das Obras',
      'fornecedor' => 'Suprimentos',
      'contrato_ger' => 'Contratos',
      //   'contrato_lista_precos' => 'Lista / Preços Praticados',
      'contrato_lista_precos' => 'Preços Praticados',
      'contrato_qualificacao' => 'Avaliação Fornecedor',
      //   'comparativo_preco' => 'Comparativo de Preços',
      //    'contrato_gerencial_forn' => 'Posição das Obras',
      'qsmsrs' => 'QSMSRS',
      //  'qsmsrs_qualidade' => 'Qualidade',
      //  'qsmsrs_seguranca' => 'Segurança',
      //  'qsmsrs_meio_ambiente' => 'Meio Ambiente',
      //  'qsmsrs_saude' => 'Saúde',
      //  'qsmsrs_responsabilidade_social' => 'Responsabilidade Social',

      'consultoria_externa' => 'Consultoria Externa',
      'juridico' => 'Jurídico',
      'acao_empreiteiro' => 'Ações Trabalhistas Empreiteiros',
      'acao_funcionario' => 'Ações Trabalhistas Funcionários',
      'diario_obra' => 'Diário da Obra',
      'galeria_fotos' => 'Galeria de Fotos',
      );

      //'oas_exclusive' => 'financeiro',

      $vetMenuSub = Array(

      //  'habite' => 'informacao_gerencial',
      'indice_empreendimento' => 'informacao_gerencial',
      //  'greve' => 'informacao_gerencial',
      'documentos' => 'informacao_gerencial',
      //   'indice_projeto' => 'informacao_gerencial',
      'aditivo_orcamento' => 'informacao_gerencial',


      //    'contrato_construcao' => 'informacao_gerencial',
      //    'alvaras' => 'informacao_gerencial',
      //    'ordem_servico' => 'informacao_gerencial',
      //     'concessionaria' => 'informacao_gerencial',

      //     'viabilidade_economica' => 'informacao_gerencial',
      //     'fechamento' => 'informacao_gerencial',
      //     'notificacao' => 'informacao_gerencial',
      //     'aditivos_doc' => 'informacao_gerencial',
      //     'termo_conclusao' => 'informacao_gerencial',


      //      'inventario' => 'administrativo',
      'titulo_protestado' => 'administrativo',
      //      'pagamento_juro' => 'administrativo',

      'juro_pago' => 'administrativo',
      'imobilizado' => 'administrativo',
      'fluxo_financeiro' => 'financeiro',
      'financiamento' => 'financeiro',
      //        'titulo_protestado' => 'financeiro',
      //        'pagamento_juro' => 'financeiro',

      'mov_ep' => 'medicao',
      'honorario_ce' => 'medicao',
      'et_ce' => 'medicao',

      'demonstrativo'   => 'demonstrativo_m',
      'demonstrativo2'   => 'demonstrativo_m',

      //   'desvio_orcamento' => 'orcamento',
      'orcamento_sintetico' => 'orcamento',
      'despesa_direta' => 'orcamento',
      'despesa_indireta' => 'orcamento',
      'abc_servico' => 'orcamento',
      'abc_insumo' => 'orcamento',
      //    'fisico_financeiro_s' => 'cronograma',
      //    'fisico_financeiro_g' => 'cronograma',
      //    'linha_balanco' => 'cronograma',
      //    'contratacao' => 'cronograma',
      //    'desvio_prazo' => 'cronograma',


      'avanco_fisico' => 'mapeamento_fisico',
      'fisico_financeiro_ga' => 'mapeamento_fisico',
      'desvio_prazo' => 'mapeamento_fisico',
      //   'macro_fluxo' => 'mapeamento_fisico',


      //   'servico_pavimento' => 'mapeamento_fisico',
      // 'entrega_apartamento' => 'mapeamento_fisico',
      'organograma' => 'departamento_pessoal',
      'dado_estatistico' => 'departamento_pessoal',
      'quadro_funcionario' => 'departamento_pessoal',
      'pessoal_efetivo' => 'departamento_pessoal',
      'hora_extra' => 'departamento_pessoal',
      //    'rotatividade' => 'departamento_pessoal',
      //    'contrato_fornecedor_inc' => 'contrato',
      //    'contrato_servico_inc' => 'contrato',
      //    'contrato_gerencial_cont' => 'contrato',

      'contrato_ger' => 'fornecedor',
      'contrato_lista_precos' => 'fornecedor',
      'contrato_qualificacao' => 'fornecedor',
      //    'comparativo_preco' => 'fornecedor',
      //    'contrato_gerencial_forn' => 'fornecedor',

      //    'qsmsrs_qualidade' => 'qsmsrs',
      //    'qsmsrs_seguranca' => 'qsmsrs',
      //    'qsmsrs_meio_ambiente' => 'qsmsrs',
      //    'qsmsrs_saude' => 'qsmsrs',
      //    'qsmsrs_responsabilidade_social' => 'qsmsrs',


      'acao_empreiteiro' => 'juridico',
      'acao_funcionario' => 'juridico',




      );

     */

//    $vetMenu    = Array();
//    $vetMenuSub = Array();

    /*
      $vetMenu    = Array();
      $vetMenuSub = Array();


      $vetMenu1    = Array();
      $vetMenuSub1 = Array();

      $sql  = 'select ';
      $sql .= '     * ';
      $sql .= ' from site_funcao ';
      $sql .= ' order by cod_classificacao ';
      $rs   = execsql($sql);
      $cod_funcaow='';
      ForEach ($rs->data as $row)
      {
      $cod_classificacao  = $row['cod_classificacao'];
      $nm_funcao          = $row['nm_funcao'];
      $cod_funcao         = $row['cod_funcao'];
      $nivel = strlen($cod_classificacao);
      if  ($nivel==2)
      {
      $vetMenu1[$cod_funcao]=$nm_funcao;
      $cod_funcaow=$cod_funcao;
      }
      else
      {
      $vetMenu1[$cod_funcao]=$nm_funcao;
      $vetMenuSub1[$cod_funcao]=$cod_funcaow;
      }
      }



      //  echo ' vvvvv '.$_SESSION[CS]['g_id_usuario'];
      //  echo ' vvvvv '.$_SESSION[CS]['g_id_site_perfil'];

      //  p($vetMenu);
      //  p($vetMenuSub);

      //  p($vetMenu1);
      //  p($vetMenuSub1);

      //  exit();

      $g_id_site_perfil = $_SESSION[CS]['g_id_site_perfil'];
      //
      // Acessar perfil do site
      //
      $todos = 'N';
      $sql  = 'select ';
      $sql .= '     * ';
      $sql .= ' from site_perfil ';
      $sql .= ' where id_perfil = '.null($g_id_site_perfil);
      //  echo 'nnnnn '.$sql;
      $rs   = execsql($sql);
      $en=0;
      ForEach ($rs->data as $row)
      {
      $en=1;
      $todos = $row['todos'];
      $idt_empreendimento = $row['idt_empreendimento'];
      }

      if ($en==1)
      {
      if ($idt_empreendimento>0)
      {
      // ajustar a Obra
      $sql  = 'select ';
      $sql .= '     sp.*, ';
      $sql .= '     sf.*, ';
      $sql .= '     sf.cod_funcao as sf_cod_funcao, ';
      $sql .= '     sf.nm_funcao as sf_nm_funcao ';
      $sql .= ' from site_perfil sp ';

      $sql .= ' inner join site_direito_perfil sdp on sdp.id_perfil =  sp.id_perfil';
      $sql .= ' inner join site_direito_funcao sdf on sdf.id_difu   =  sdp.id_difu';
      $sql .= ' inner join site_funcao          sf on sf.id_funcao  =  sdf.id_funcao';
      $sql .= ' where sp.idt_empreendimento = '.null($idt_empreendimento);
      $sql .= ' order by cod_classificacao ';
      //            echo 'nnnnn '.$sql;

      $rs   = execsql($sql);

      $en=0;
      $vetMenu1    = Array();
      $vetMenuSub1 = Array();
      $duasw='';
      ForEach ($rs->data as $row)
      {
      $cod_classificacao  = $row['cod_classificacao'];

      $nm_funcao          = $row['nm_funcao'];
      $cod_funcao         = $row['cod_funcao'];
      $nivel = strlen($cod_classificacao);
      if  ($nivel==2)
      {
      $vetMenu1[$cod_funcao]=$nm_funcao;
      $cod_funcaow=$cod_funcao;
      $duasw  = substr($cod_classificacao,0,2);
      }
      else
      {
      $duas  = substr($cod_classificacao,0,2);
      if  ($duas==$duasw)
      {
      $vetMenu1[$cod_funcao]=$nm_funcao;
      $vetMenuSub1[$cod_funcao]=$cod_funcaow;
      }
      }
      }
      //          p($vetMenu1);
      //          exit();

      }
      if ($todos=='N')
      {
      //
      // ajustar vetos
      //
      }


      }
      else
      {
      //echo ' cod '.sf_cod_funcao.' nn '.sf_nm_funcao;

      }
      $vetMenu    = $vetMenu1;
      $vetMenuSub = $vetMenuSub1;

     */
//    $_SESSION['g_vetMenu']    = $vetMenu;
//    $_SESSION['g_vetMenuSub'] = $vetMenuSub;
//    $vetMenu    = Array();
//    $vetMenuSub = Array();
} else {
//    $vetMenu    = $_SESSION['g_vetMenu'];
//    $vetMenuSub = $_SESSION['g_vetMenuSub'];
}
$vetMenu    = $_SESSION[CS]['g_vetMenu'];
$vetMenuSub = $_SESSION[CS]['g_vetMenuSub'];
$vetMenuAss = $_SESSION[CS]['g_vetMenuAss'];

$vetMenuAss_nome = $_SESSION[CS]['g_vetMenuAss_nome_ass'];
$vetMenuAss_data = $_SESSION[CS]['g_vetMenuAss_data_ass'];




/*
if ($debug || $_SESSION[CS]['g_vetBarraMenu'] == '') {
    $vetBarraMenu = $vetMenu;

    if (is_array($vetMenuSub)) {
        ForEach ($vetMenuSub as $idx => $col) {
            $vetBarraMenu[$idx] = $vetMenu[$col].' :: '.$vetBarraMenu[$idx];
        }
    }

    ForEach ($vetEstado as $idx => $col) {
        $vetBarraMenu['empreendimento_'.$idx] = 'Empreendimento :: '.$col;
    }
} else {
    $vetBarraMenu = $_SESSION[CS]['g_vetBarraMenu'];
}
 *
 */
 
    $vetBarraMenu = $_SESSION[CS]['g_vetBarraMenu'];


// coordenadas dos estados no Mapa

/*
if ($_SESSION[CS]['g_poligono_estado'] == '') {
    $_SESSION[CS]['g_poligono_estado'] = Array();
    $sql = 'select ';
    $sql .= ' distinct ';
    $sql .= '    uf.codigo, ';
    $sql .= '    uf.descricao, ';
    $sql .= '    uf.pos_sigla, ';
    $sql .= '    uf.poligono ';
    $sql .= ' from estado uf  ';
    $sql .= ' inner join  empreendimento em on em.estado = uf.codigo';
    $sql .= ' order by uf.codigo  ';
    $rs = execsql($sql);
    ForEach ($rs->data as $row) {
        $_SESSION[CS]['g_poligono_estado'][$row['codigo']][0] = $row['descricao'];
        $_SESSION[CS]['g_poligono_estado'][$row['codigo']][1] = $row['poligono'];
        $_SESSION[CS]['g_poligono_estado'][$row['codigo']][2] = $row['pos_sigla'];
    }
}
*/
?>