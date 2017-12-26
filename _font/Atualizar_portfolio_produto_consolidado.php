<?php
Require_Once('../configuracao.php');

beginTransaction();

$vetSituacao = Array();

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_produto_situacao';
$rs = execsql($sql);

foreach ($rs->data as $row) {
    $vetSituacao[$row['descricao']] = $row['idt'];
}

$arquivo = file("Atualizar_portfolio_produto_consolidado_v2.csv");

foreach ($arquivo as $lin => $texto) {
    if ($lin > 0) {
        $lin++;
        $cpos = Array();
        $cpos = str_getcsv($texto, ';');

        if ($cpos[0] != '') {
            $codigo_prod = $cpos[0];
            $descricao = $cpos[1];
            $situacao = $cpos[2];
            $idt_programa_grc = $cpos[5];
            $idt_programa = $cpos[6];
            $idt_produto_dimensao_complexidade = $cpos[7];
            $participante_minimo = $cpos[8];
            $participante_maximo = $cpos[9];
            $carga_horaria_ini = $cpos[10];
            $carga_horaria_fim = $cpos[11];
            $carga_horaria_2_ini = $cpos[12];
            $carga_horaria_2_fim = $cpos[13];

            if ($idt_programa_grc == 0) {
                $idt_programa_grc = '';
            }

            if ($idt_programa == 0) {
                $idt_programa = '';
            }

            if ($idt_produto_dimensao_complexidade == 0) {
                $idt_produto_dimensao_complexidade = '';
            }

            $sql = '';
            $sql .= ' select idt, idt_produto_tipo';
            $sql .= ' from grc_produto';
            $sql .= ' where codigo = '.aspa($codigo_prod);
            $rs = execsql($sql);

            if ($rs->rows > 1) {
                $sql .= ' and descricao = '.aspa($descricao);
                $rs = execsql($sql);
            }

            if ($rs->rows > 1) {
                $sql .= ' and idt_produto_situacao = '.null($vetSituacao[$situacao]);
                $rs = execsql($sql);
            }

            if ($rs->rows > 1) {
                echo $lin.': Tem '.$rs->rows.' registros para produto '.$codigo_prod.' :: '.$descricao.' :: '.$situacao.'<br />';
            } else {
                $idt_produto = $rs->data[0]['idt'];
                $idt_produto_tipo = $rs->data[0]['idt_produto_tipo'];

                if ($idt_produto == '') {
                    echo $lin.': O produto '.$codigo_prod.' :: '.$descricao.' :: '.$situacao.' não foi encontrado!<br />';
                } else {
                    switch ($idt_produto_tipo) {
                        case 1:
                            $carga_horaria_2_ini = '';
                            $carga_horaria_2_fim = '';
                            break;

                        case 2:
                            $carga_horaria_ini = '';
                            $carga_horaria_fim = '';
                            break;
                    }

                    $sql = 'update grc_produto set';
                    $sql .= ' idt_programa_grc = '.null($idt_programa_grc).',';
                    $sql .= ' idt_programa = '.null($idt_programa).',';
                    $sql .= ' idt_produto_dimensao_complexidade = '.null($idt_produto_dimensao_complexidade).',';
                    $sql .= ' participante_minimo = '.null($participante_minimo).',';
                    $sql .= ' participante_maximo = '.null($participante_maximo).',';
                    $sql .= ' carga_horaria_ini = '.null($carga_horaria_ini).',';
                    $sql .= ' carga_horaria_fim = '.null($carga_horaria_fim).',';
                    $sql .= ' carga_horaria_2_ini = '.null($carga_horaria_2_ini).',';
                    $sql .= ' carga_horaria_2_fim = '.null($carga_horaria_2_fim);
                    $sql .= ' where idt = '.null($idt_produto);
                    execsql($sql);

                    $sql = 'update grc_evento set idt_programa = '.null($idt_programa);
                    $sql .= ' where idt_produto = '.null($idt_produto);
                    execsql($sql);

                    $sql = 'update '.db_pir_gec.'gec_contratacao_credenciado_ordem set idt_programa = '.null($idt_programa);
                    $sql .= ' where idt_produto = '.null($idt_produto);
                    execsql($sql);

                    $sql = '';
                    $sql .= ' select idt as idt_produto_profissional, idt_produto, idt_profissional';
                    $sql .= ' from grc_produto_profissional';
                    $sql .= ' where idt_produto = '.null($idt_produto);
                    $rsPrd = execsql($sql);

                    foreach ($rsPrd->data as $rowPrd) {
                        SincronizaProfissional($rowPrd['idt_produto_profissional'], $rowPrd['idt_produto'], $rowPrd['idt_profissional']);
                        CalcularInsumoProduto($rowPrd['idt_produto']);
                    }
                }
            }
        }
    }
}

commit();

echo 'FIM...';
