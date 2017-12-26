<?php
Require_Once('configuracao.php');

$qtdErro = 0;

//Importação dos dados SGE
try {
    beginTransaction();

    $conSGE = conSGE();
    set_time_limit(0);
	
	if (PHP_SAPI == 'cli') {
		$path_csv = $argv[1].'/sebrae_grc/admin/obj_file/plu_converte_texto/';
	} else {
		$path_csv = path_fisico.'/obj_file/plu_converte_texto/';
	}

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from plu_converte_texto';
    $sql .= ' where codigo = 9999';
    $rs = execsql($sql, false);

    if ($rs->rows == 0) {
        $sqli = 'insert into plu_converte_texto (codigo) values (9999)';
        execsql($sqli, false);
        $rs = execsql($sql, false);
    }

    $row = $rs->data[0];

    //arquivo_projeto
    $arq_csv = $row['idt'].'_arquivo_projeto_999_tb_projeto_gestor.csv';
    $fp = fopen($path_csv.$arq_csv, 'w+');

    $rowSGE = Array(
        'CodProjeto',
        'NomeProjeto',
        'Gestor',
        'Login',
    );
    fputcsv($fp, $rowSGE, ';');

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from tb_projeto_gestor';
    $rsSGE = execsql($sql, false, $conSGE, array(), PDO::FETCH_ASSOC);

    foreach ($rsSGE->data as $rowSGE) {
        $rowSGE = array_map('conHTML10', $rowSGE);
        fputcsv($fp, $rowSGE, ';');
    }

    fclose($fp);

    $sql = 'update plu_converte_texto set arquivo_projeto = '.aspa($arq_csv);
    $sql .= ' where idt = '.null($row['idt']);
    execsql($sql, false);

    //arquivo_projeto_acao
    $arq_csv = $row['idt'].'_arquivo_projeto_acao_999_tb_acao.csv';
    $fp = fopen($path_csv.$arq_csv, 'w+');

    $rowSGE = Array(
        'CodProjeto',
        'codacao',
        'nomeacao',
        'dscacao',
        'codGestor',
        'nomeGestor',
        'Usuario',
        'codUnidade',
        'nomeUnidade',
    );
    fputcsv($fp, $rowSGE, ';');

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from tb_acao';
    $rsSGE = execsql($sql, false, $conSGE, array(), PDO::FETCH_ASSOC);

    foreach ($rsSGE->data as $rowSGE) {
        $rowSGE = array_map('conHTML10', $rowSGE);
        fputcsv($fp, $rowSGE, ';');
    }

    fclose($fp);

    $sql = 'update plu_converte_texto set arquivo_projeto_acao = '.aspa($arq_csv);
    $sql .= ' where idt = '.null($row['idt']);
    execsql($sql, false);

    //arquivo_projeto_etapa
    $arq_csv = $row['idt'].'_arquivo_projeto_etapa_999_tb_projeto_etapa.csv';
    $fp = fopen($path_csv.$arq_csv, 'w+');

    $rowSGE = Array(
        'CodProjeto',
        'CodEtapa',
        'Etapa',
    );
    fputcsv($fp, $rowSGE, ';');

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from tb_projeto_etapa';
    $rsSGE = execsql($sql, false, $conSGE, array(), PDO::FETCH_ASSOC);

    foreach ($rsSGE->data as $rowSGE) {
        $rowSGE = array_map('conHTML10', $rowSGE);
        fputcsv($fp, $rowSGE, ';');
    }

    fclose($fp);

    $sql = 'update plu_converte_texto set arquivo_projeto_etapa = '.aspa($arq_csv);
    $sql .= ' where idt = '.null($row['idt']);
    execsql($sql, false);

    //arquivo_projeto_acao_metrica_fisica_ano
    $arq_csv = $row['idt'].'_arquivo_projeto_acao_metrica_fisica_ano_999_tb_metricas_fisicas.csv';
    $fp = fopen($path_csv.$arq_csv, 'w+');

    $rowSGE = Array(
        'codpratif',
        'codacao',
        'codinstrumento',
        'instrumento',
        'codmetrica',
        'metrica',
        'Ano de Previsão',
        'Quantidade',
    );
    fputcsv($fp, $rowSGE, ';');

    $sql = '';
    $sql .= ' select codpratif, codacao, codinstrumento, nominstrumento, codmetrica, nommetrica, anoprevisao, qtmetricaatendimento';
    $sql .= ' from tb_metricas_fisicas';
    $rsSGE = execsql($sql, false, $conSGE, array(), PDO::FETCH_ASSOC);

    foreach ($rsSGE->data as $rowSGE) {
        $rowSGE = array_map('conHTML10', $rowSGE);
        fputcsv($fp, $rowSGE, ';');
    }

    fclose($fp);

    $sql = 'update plu_converte_texto set arquivo_projeto_acao_metrica_fisica_ano = '.aspa($arq_csv);
    $sql .= ' where idt = '.null($row['idt']);
    execsql($sql, false);

    //arquivo_projeto_acao_metrica_orcamento_ano
    /*
      $arq_csv = $row['idt'].'_arquivo_projeto_acao_metrica_orcamento_ano_999_tb_metricas_orcamentaria.csv';
      $fp = fopen($path_csv.$arq_csv, 'w+');

      $rowSGE = Array(
      'codpratif',
      'codacao',
      'AnoPrevisao',
      'DtOperacao_ultima',
      'CodEntidade_Fin',
      'entidade financeira',
      'CodEtapaPRATIF',
      'Operacao',
      'CodTipoPrevisao',
      'descPrevisao',
      'Ativo',
      'VlPrevisto',
      'codprocesso',
      'CodFase',
      'descfase',
      'CodEntidade_Inicio',
      'CodEntidade_Fim',
      );
      fputcsv($fp, $rowSGE, ';');

      $sql = '';
      $sql .= ' select *';
      $sql .= ' from tb_metricas_orcamentaria';
      $rsSGE = execsql($sql, false, $conSGE, array(), PDO::FETCH_ASSOC);

      foreach ($rsSGE->data as $rowSGE) {
      $rowSGE = array_map('conHTML10', $rowSGE);
      fputcsv($fp, $rowSGE, ';');
      }

      fclose($fp);

      $sql = 'update plu_converte_texto set arquivo_projeto_acao_metrica_orcamento_ano = '.aspa($arq_csv);
      $sql .= ' where idt = '.null($row['idt']);
      execsql($sql, false);
     * 
     */

    $sql = '';
    $sql .= ' select codacao, pctoutros';
    $sql .= ' from tb_acao_distribuicao_receita';
    $sql .= " where titprograma = 'SEBRAETEC'";
    $rsSGE = execsql($sql, false, $conSGE, array(), PDO::FETCH_ASSOC);

    $vetContrapartidaSgtec = Array();
    
    foreach ($rsSGE->data as $rowSGE) {
        $vetContrapartidaSgtec[$rowSGE['codacao']] = $rowSGE['pctoutros'];
    }
    
    $kokw = ExecutaImportacao_Projeto($row['idt'], $path_csv);
    $kokw = ExecutaImportacao_Projeto_acao($row['idt'], $vetContrapartidaSgtec, $path_csv);
    $kokw = ExecutaImportacao_Projeto_etapa($row['idt'], $path_csv);
    $kokw = ExecutaImportacao_Projeto_acao_metrica_fisica_ano($row['idt'], $path_csv);
    //$kokw = ExecutaImportacao_Projeto_acao_metrica_orcamento_ano($row['idt'], $path_csv);
    ExecutaAjuste_projetos_SiacWeb($row['idt']);

	commit();
    $grava_log = true;
} catch (Exception $e) {
    rollBack();
    $qtdErro++;
    
    if ($fim != 'N') {
        p($e);
    }

    grava_erro_log('executa_job', $e, '');
}
