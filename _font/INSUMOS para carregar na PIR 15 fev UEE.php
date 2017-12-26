<?php
Require_Once('../configuracao.php');

beginTransaction();

$vetProduto = Array();
$vetInsumo = Array();

$arquivo = file("INSUMOS para carregar na PIR 15 fev UEE.csv");

$sql = '';
$sql .= ' select idt';
$sql .= ' from grc_insumo_unidade';
$sql .= " where codigo = 'UN'";
$rs = execsql($sql);
$idt_insumo_unidade = $rs->data[0][0];

foreach ($arquivo as $lin => $texto) {
    if ($lin > 2) {
        $lin++;
        $cpos = Array();
        $cpos = str_getcsv($texto, ';');

        if ($cpos[1] != '') {
            $tmp = explode('/', $cpos[1]);
            $codigo_prod = $tmp[0];
            $copia_prod = $tmp[1][0];

            if ($cpos[3] == 'NP') {
                $por_participante = 'S';
                $quantidade = 1;
            } else {
                $por_participante = 'N';
                $quantidade = $cpos[3];
            }

            $tmp = explode('/', $cpos[4]);

            if ($tmp[0] == 'Check Item') {
                unset($tmp[0]);
                $CheckItem = 'S';
                $descricao = implode('/', $tmp);
            } else {
                $CheckItem = 'N';
                $descricao = '';
            }

            $detalhe = $cpos[5];
            $classificacao_insumo = $cpos[6];

            if (strlen($classificacao_insumo) > 10) {
                $classificacao_insumo = substr($classificacao_insumo, 0, 10);
            }

            if ($vetProduto[$codigo_prod.$copia_prod] == '') {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_produto';
                $sql .= ' where codigo = '.aspa($codigo_prod);
                $rs = execsql($sql);

                if ($rs->rows > 1) {
                    $sql .= ' and copia = '.aspa($copia_prod);
                    $rs = execsql($sql);
                }

                if ($rs->rows > 1) {
                    echo $lin.': Tem '.$rs->rows.' registros para produto/copia '.$codigo_prod.'/'.$copia_prod.'!<br />';
                } else {
                    $idt_produto = $rs->data[0][0];

                    if ($idt_produto == '') {
                        echo $lin.': O produto '.$codigo_prod.' não foi encontrado!<br />';
                    } else {
                        $vetProduto[$codigo_prod.$copia_prod] = $idt_produto;
                    }
                }
            }

            if ($vetProduto[$codigo_prod.$copia_prod] != '') {
                $idt_produto = $vetProduto[$codigo_prod.$copia_prod];

                if ($CheckItem == 'S') {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_produto_item';
                    $sql .= ' where idt_produto = '.null($idt_produto);
                    $sql .= ' and descricao = '.aspa($descricao);
                    $rst = execsql($sql);

                    if ($rst->rows == 0) {
                        $sql = 'insert into grc_produto_item (idt_produto, descricao, idt_insumo_unidade, quantidade';
                        $sql .= ') values (';
                        $sql .= null($idt_produto).', '.aspa($descricao).', '.null($idt_insumo_unidade).', '.null($quantidade).')';
                        execsql($sql);
                    } else {
                        $sql = 'update grc_produto_item set';
                        $sql .= ' quantidade = '.null($quantidade);
                        $sql .= ' where idt = '.null($rst->data[0][0]);
                        execsql($sql);
                    }
                } else if ($classificacao_insumo != '') {
                    if ($vetInsumo[$classificacao_insumo] == '') {
                        $sql = '';
                        $sql .= ' select *';
                        $sql .= ' from grc_insumo';
                        $sql .= ' where classificacao = '.aspa($classificacao_insumo);
                        $rs = execsql($sql);

                        if ($rs->rows == 0) {
                            echo $lin.': O insumo '.$classificacao_insumo.' não foi encontrado!<br />';
                        } else {
                            $vetInsumo[$classificacao_insumo] = $rs->data[0];
                        }
                    }

                    if (is_array($vetInsumo[$classificacao_insumo])) {
                        $rowInsumo = $vetInsumo[$classificacao_insumo];

                        $sql = '';
                        $sql .= ' select idt';
                        $sql .= ' from grc_produto_insumo';
                        $sql .= ' where idt_produto = '.null($idt_produto);
                        $sql .= ' and idt_insumo = '.null($rowInsumo['idt']);

                        if ($detalhe != '') {
                            $sql .= ' and detalhe = '.aspa($detalhe);
                        }
                        
                        $rst = execsql($sql);

                        if ($rst->rows == 0) {
                            $sql = 'insert into grc_produto_insumo (idt_produto, idt_insumo, detalhe, descricao, ativo,';
                            $sql .= ' idt_area_suporte,';
                            $sql .= ' custo_unitario_real, idt_insumo_unidade, por_participante, quantidade';
                            $sql .= ') values (';
                            $sql .= null($idt_produto).', '.null($rowInsumo['idt']).', '.aspa($detalhe).', '.aspa($detalhe).', '.aspa($rowInsumo['ativo']).', ';
                            $sql .= null($rowInsumo['idt_area_suporte']).', ';
                            $sql .= null($rowInsumo['custo_unitario_real']).', '.null($rowInsumo['idt_insumo_unidade']).', '.aspa($por_participante).', '.null($quantidade).')';
                            execsql($sql);
                        } else {
                            $sql = 'update grc_produto_insumo set';
                            $sql .= ' detalhe = '.aspa($detalhe).',';
                            $sql .= ' descricao = '.aspa($detalhe).',';
                            $sql .= ' por_participante = '.aspa($por_participante).',';
                            $sql .= ' quantidade = '.null($quantidade);
                            $sql .= ' where idt = '.null($rst->data[0][0]);
                            execsql($sql);
                        }
                    }
                }
            }
        }
    }
}

foreach ($vetProduto as $idt_produto) {
    CalcularInsumoProduto($idt_produto);
}

commit();

echo 'FIM...';
