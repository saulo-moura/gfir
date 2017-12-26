<style>
</style>

<?php
// grava ferramentas e produdos em arquivo
//
// Produtos
//
echo "<table border='1' cellspacing='0' cellpadding='0' width='100%' style='' >";
echo "<tr>";
$stylo = "font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:12pt; color:$color; background:$background;";
echo "<tr>";
echo "<td  style='{$stylo} ' >";
echo 'Produto';
echo "</td>";
echo "<td  style='{$stylo}' >";
echo 'Carga Horária';
echo "</td>";

echo "<td  style='{$stylo}' >";
echo 'Objetivo';
echo "</td>";
echo "</tr>";

$idt_avaliacao_devolutiva = "";
$sqlt = 'select ';
$sqlt .= '  grc_ad.*   ';
$sqlt .= '  from grc_avaliacao_devolutiva grc_ad ';
$sqlt .= '  where grc_ad.idt_avaliacao  = '.null($idt_avaliacao);
$rst = execsql($sqlt);

if ($rst->rows == 0) {
    
} else {
    $rowde = $rst->data[0];
    $idt_avaliacao_devolutiva = $rowde['idt'];
}

if (geraPDF === true || $_GET['pdf'] == 'S') {
    ForEach ($vetFerr as $idt_ferramenta => $descricao) {
        $sql = '';
        $sql .= ' select grc_p.* ';
        $sql .= ' from grc_formulario_ferramenta_gestao grc_ffg ';
        $sql .= ' inner join grc_nan_ferramenta_x_produto grc_nfp on grc_nfp.idt_ferramenta = grc_ffg.idt  ';
        $sql .= ' inner join grc_produto grc_p on grc_p.idt = grc_nfp.idt_produto  ';
        $sql .= ' inner join grc_avaliacao_devolutiva_produto adp on adp.idt_produto = grc_nfp.idt_produto';
        $sql .= ' where grc_ffg.idt = '.null($idt_ferramenta);
        $sql .= ' and adp.idt_avaliacao_devolutiva  = '.null($idt_avaliacao_devolutiva);
        $sql .= " and adp.ativo = 'S'";
        $sql .= " and adp.status = 'DE'";
        $rs = execsql($sql);

        if ($rs->rows > 0) {
            $stylo = "padding-left:10px; background:#ECF0F1; color:#000000; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:11pt;";
            echo "<tr>";
            echo "<td  colspan='3' style='{$stylo}' >";
            echo "{$descricao} ";
            echo "</td>";
            echo "</tr>";
        }

        $background = '#FF8000;';
        $color = '#004080;';
        $width = '100%';
        $width = $width.'%';
        $height = '25px';
        $height = $height.'px';

        foreach ($rs->data as $row) {
            $idt_produto = $row['idt'];
            $codigo = $row['codigo'];
            $descricao = $row['descricao'];
            $objetivo = $row['objetivo'];
            $carga_horaria = $row['carga_horaria'];
            $idt_foco_tematico = $row['idt_foco_tematico'];
            $kvetProdutoFocoP[$idt_produto] = $idt_foco_tematico;
            $kvetFocoP[$idt_foco_tematico] = 'S';

            $stylo = "font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:11pt;";
            echo "<tr>";
            echo "<td  style='{$stylo}' >";
            echo $descricao;
            echo "</td>";
            echo "<td  style='{$stylo}' >";
            echo $carga_horaria;
            echo "</td>";
            echo "<td  style='{$stylo}' >";
            echo $objetivo."";
            echo "</td>";
            echo "</tr>";
        }
    }

    // Lista produtos indicados pelo TUTOR
    $sqlt = 'select ';
    $sqlt .= '  grc_adp.*, grc_p.*   ';
    $sqlt .= '  from grc_avaliacao_devolutiva_produto grc_adp ';
    $sqlt .= ' inner join grc_produto grc_p on grc_p.idt = grc_adp.idt_produto  ';
    $sqlt .= '  where grc_adp.idt_avaliacao_devolutiva  = '.null($idt_avaliacao_devolutiva);
    $sqlt .= '    and grc_adp.status   = '.aspa('MA');
    $sqlt .= '    and grc_adp.ativo    = '.aspa('S');
    $rst = execsql($sqlt);

    if ($rst->rows > 0) {
        $descricao = "RECOMENDADOS PELO TUTOR";
        $stylo = "padding-left:10px; background:#ECF0F1; color:#000000; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:11pt;";
        echo "<tr>";
        echo "<td  colspan='3' style='{$stylo}' >";
        echo "{$descricao} ";
        echo "</td>";
        echo "</tr>";

        foreach ($rst->data as $rowt) {
            $idt_produto = $rowt['idt'];
            $codigo = $rowt['codigo'];
            $descricao = $rowt['descricao'];
            $objetivo = $rowt['objetivo'];
            $carga_horaria = $rowt['carga_horaria'];
            $idt_foco_tematico = $rowt['idt_foco_tematico'];
            $stylo = "font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:11pt;";
            echo "<tr>";
            echo "<td  style='{$stylo}' >";
            echo $descricao;
            echo "</td>";
            echo "<td  style='{$stylo}' >";
            echo $carga_horaria;
            echo "</td>";
            echo "<td  style='{$stylo}' >";
            echo $objetivo."";
            echo "</td>";
            echo "</tr>";
        }
    }

    echo "</table>";
} else {
    $sql_a = "update grc_avaliacao_devolutiva_produto set sistema = 'N'";
    $sql_a .= ' where idt_avaliacao_devolutiva = '.null($idt_avaliacao_devolutiva);
    execsql($sql_a);
    ForEach ($vetFerr as $idt_ferramenta => $descricao) {
        $stylo = "padding-left:10px; background:#ECF0F1; color:#000000; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:11pt;";
        echo "<tr>";
        echo "<td  colspan='3' style='{$stylo}' >";
        echo "{$descricao} ";
        echo "</td>";
        echo "</tr>";
        $sql = '';
        $sql .= ' select grc_p.* ';
        $sql .= ' from grc_formulario_ferramenta_gestao grc_ffg ';
        $sql .= ' inner join grc_nan_ferramenta_x_produto grc_nfp on grc_nfp.idt_ferramenta = grc_ffg.idt  ';
        $sql .= ' inner join grc_produto grc_p on grc_p.idt = grc_nfp.idt_produto  ';
        $sql .= ' where grc_ffg.idt = '.null($idt_ferramenta);
        $rs = execsql($sql);

        $background = '#FF8000;';
        $color = '#004080;';
        $width = '100%';
        $width = $width.'%';
        $height = '25px';
        $height = $height.'px';



        foreach ($rs->data as $row) {
            $idt_produto = $row['idt'];
            $codigo = $row['codigo'];
            $descricao = $row['descricao'];
            $objetivo = $row['objetivo'];
            $carga_horaria = $row['carga_horaria'];
            $idt_foco_tematico = $row['idt_foco_tematico'];
            $kvetProdutoFocoP[$idt_produto] = $idt_foco_tematico;
            $kvetFocoP[$idt_foco_tematico] = 'S';
            //
            // Testar em arquivo
            //
		$sqlt = 'select ';
            $sqlt .= '  gec_adp.*   ';
            $sqlt .= '  from grc_avaliacao_devolutiva_produto gec_adp ';
            $sqlt .= '  where gec_adp.idt_avaliacao_devolutiva  = '.null($idt_avaliacao_devolutiva);
            $sqlt .= '    and gec_adp.idt_produto               = '.null($idt_produto);
            $rst = execsql($sqlt);
            $serve = 0;
            if ($rst->rows == 0) {
                $serve = 1;
            } else {
                $rowde = $rst->data[0];
                $idt_avaliacao_devolutiva_produto = $rowde['idt'];
                if ($rowde['ativo'] == 'S') {
                    $serve = 1;
                }
                $sql_a = "update grc_avaliacao_devolutiva_produto set sistema = 'A'";
                $sql_a .= ' where idt = '.null($idt_avaliacao_devolutiva_produto);
                execsql($sql_a);
            }
            $stylo = "font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:11pt;";
            echo "<tr>";
            echo "<td  style='{$stylo}' >";
            echo $descricao;
            echo "</td>";
            echo "<td  style='{$stylo}' >";
            echo $carga_horaria;
            echo "</td>";
            echo "<td  style='{$stylo}' >";
            echo $objetivo."";
            echo "</td>";
            echo "</tr>";
        }
    }
//
// Lista produtos indicados pelo TUTOR
//
    $sqlt = 'select ';
    $sqlt .= '  grc_adp.*, grc_p.*   ';
    $sqlt .= '  from grc_avaliacao_devolutiva_produto grc_adp ';
    $sqlt .= ' inner join grc_produto grc_p on grc_p.idt = grc_adp.idt_produto  ';

    $sqlt .= '  where grc_adp.idt_avaliacao_devolutiva  = '.null($idt_avaliacao_devolutiva);
    $sqlt .= '    and grc_adp.sistema  = '.aspa('N');
    $sqlt .= '    and grc_adp.ativo    = '.aspa('S');
    $rst = execsql($sqlt);
    $serve = 0;
    if ($rst->rows == 0) {
        
    } else {
        $rst = execsql($sqlt);
        $descricao = "RECOMENDADOS PELO TUTOR";
        $stylo = "padding-left:10px; background:#ECF0F1; color:#000000; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:11pt;";
        echo "<tr>";
        echo "<td  colspan='3' style='{$stylo}' >";
        echo "{$descricao} ";
        echo "</td>";
        echo "</tr>";
        foreach ($rst->data as $rowt) {
            $idt_produto = $rowt['idt'];
            $codigo = $rowt['codigo'];
            $descricao = $rowt['descricao'];
            $objetivo = $rowt['objetivo'];
            $carga_horaria = $rowt['carga_horaria'];
            $idt_foco_tematico = $rowt['idt_foco_tematico'];
            $stylo = "font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:11pt;";
            echo "<tr>";
            echo "<td  style='{$stylo}' >";
            echo $descricao;
            echo "</td>";
            echo "<td  style='{$stylo}' >";
            echo $carga_horaria;
            echo "</td>";
            echo "<td  style='{$stylo}' >";
            echo $objetivo."";
            echo "</td>";
            echo "</tr>";
        }
    }



    echo "</table>";




    $idt_devolutiva = 0;
    $sql = 'select ';
    $sql .= '  grc_ad.idt    ';
    $sql .= '  from grc_avaliacao_devolutiva grc_ad ';
    $sql .= '  where grc_ad.idt_avaliacao  = '.null($idt_avaliacao);
    $sql .= '    and atual  = '.aspa('S');
    $rst = execsql($sql);
    if ($rst->rows == 0) {
        $datadia = (date('d/m/Y H:i:s'));
        $idt_cadastrante = $_SESSION[CS]['g_id_usuario'];
        $data_cadastrante = aspa(trata_data($datadia));

        $versao = 1;
        $data_versao = aspa(trata_data($datadia));

        $status = aspa('CA');
        $grupo = aspa('NAN');

        $atual = aspa('S');

        $tabela = 'grc_avaliacao_devolutiva';
        $Campo = 'codigo';
        $tam = 7;
        $codigow = numerador_arquivo($tabela, $Campo, $tam);
        $codigo = 'DV'.$codigow;
        $codigo = aspa($codigo);
        $sql_i = " insert into grc_avaliacao_devolutiva ";
        $sql_i .= " (  ";
        $sql_i .= " idt_avaliacao, ";
        $sql_i .= " codigo, ";
        $sql_i .= " idt_cadastrante, ";
        $sql_i .= " data_cadastrante, ";
        $sql_i .= " versao, ";
        $sql_i .= " data_versao, ";
        $sql_i .= " status, ";
        $sql_i .= " grupo, ";
        $sql_i .= " atual ";
        $sql_i .= "  ) values ( ";
        $sql_i .= " $idt_avaliacao, ";
        $sql_i .= " $codigo, ";
        $sql_i .= " $idt_cadastrante, ";
        $sql_i .= " $data_cadastrante, ";
        $sql_i .= " $versao, ";
        $sql_i .= " $data_versao, ";
        $sql_i .= " $status, ";
        $sql_i .= " $grupo, ";
        $sql_i .= " $atual ";
        $sql_i .= ") ";
        $result = execsql($sql_i);
        $idt_avaliacao_devolutiva = lastInsertId();
    } else {
        foreach ($rst->data as $rowt) {
            $idt_avaliacao_devolutiva = $rowt['idt'];
        }
    }

    $sql_d = 'delete from grc_avaliacao_devolutiva_ferramenta ';
    $sql_d .= ' where idt_avaliacao_devolutiva = '.null($idt_avaliacao_devolutiva);
    $result = execsql($sql_d);

    $ordem = 0;
    ForEach ($vetFerr as $idt_ferramenta => $descricao) {
        $sql = 'select ';
        $sql .= '  gec_adf.*   ';
        $sql .= '  from grc_avaliacao_devolutiva_ferramenta gec_adf ';
        $sql .= '  where gec_adf.idt_avaliacao_devolutiva  = '.null($idt_avaliacao_devolutiva);
        $sql .= '    and gec_adf.idt_ferramenta = '.null($idt_ferramenta);
        $rs = execsql($sql);
        $ordem = $ordem + 1;
        if ($rs->rows == 0) {
            $sql_i = " insert into grc_avaliacao_devolutiva_ferramenta ";
            $sql_i .= " (  ";
            $sql_i .= " idt_avaliacao_devolutiva, ";
            $sql_i .= " idt_ferramenta, ";
            $sql_i .= " ordem ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $idt_avaliacao_devolutiva, ";
            $sql_i .= " $idt_ferramenta, ";
            $sql_i .= " $ordem ";
            $sql_i .= ") ";
            $result = execsql($sql_i);
        } else {
            ForEach ($rs->data as $row) {
                $idt_devolutiva_ferramenta = $row['idt'];
            }
            $sql = 'update grc_avaliacao_devolutiva_ferramenta set ';
            $sql .= " ordem = {$ordem} ";
            $sql .= ' where idt = '.null($idt_devolutiva_ferramenta);
            execsql($sql);
        }
    }
    $sql_d = "update grc_avaliacao_devolutiva_produto set ativo = 'T'";
    $sql_d .= ' where idt_avaliacao_devolutiva = '.null($idt_avaliacao_devolutiva);
    $sql_d .= " and status = 'DE'";
    $sql_d .= " and ativo  = 'S'";
    execsql($sql_d);
    ForEach ($kvetProdutoFocoP as $idt_produto => $idt_Foco_tematico) {
        $sql = 'select ';
        $sql .= '  gec_adp.*   ';
        $sql .= '  from grc_avaliacao_devolutiva_produto gec_adp ';
        $sql .= '  where gec_adp.idt_avaliacao_devolutiva  = '.null($idt_avaliacao_devolutiva);
        $sql .= '    and gec_adp.idt_produto    = '.null($idt_produto);
        $rs = execsql($sql);
        if ($rs->rows == 0) {
            $sql_i = " insert into grc_avaliacao_devolutiva_produto ";
            $sql_i .= " (  ";
            $sql_i .= " idt_avaliacao_devolutiva, ";
            $sql_i .= " idt_produto ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $idt_avaliacao_devolutiva, ";
            $sql_i .= " $idt_produto ";
            $sql_i .= ") ";
            $result = execsql($sql_i);
        } else {
            $rowde = $rs->data[0];
            if ($rowde['ativo'] == 'T') {
                $sql = 'update grc_avaliacao_devolutiva_produto set ';
                $sql .= " status = 'DE',";
                $sql .= " ativo = 'S'";
                $sql .= ' where idt = '.null($rowde['idt']);
                execsql($sql);
            }
        }
    }

    $sql_d = "update grc_avaliacao_devolutiva_produto set ativo = 'N'";
    $sql_d .= ' where idt_avaliacao_devolutiva = '.null($idt_avaliacao_devolutiva);
    $sql_d .= " and status = 'DE'";
    $sql_d .= " and ativo  = 'T'";
    execsql($sql_d);


//echo "<pre>";
//p($vetAvaliacaoA[$area]);
//echo "</pre>";
//echo "<table border='1' cellspacing='0' cellpadding='0' width='100%' style='' >";


    $idt_area = "NULL";
    $vetAreaIdt = Array();
    $vetAreaCod = Array();
    $sql = 'select ';
    $sql .= '  grc_fa.*   ';
    $sql .= '  from grc_formulario_area grc_fa ';
		
	$sql .= ' where grupo = '.aspa('NAN');
	$sql .= ' order by grc_fa.codigo ';

    $rs = execsql($sql);
    if ($rs->rows == 0) {
        
    } else {
        ForEach ($rs->data as $row) {
            $idt_area = $row['idt'];
            $descricao = strtoupper($row['descricao']);
            $codigo = $row['codigo'];
            $vetAreaIdt[$codigo] = $idt_area;
            $vetAreaCod[$codigo] = $row['descricao'];
        }
    }




    $sql_d = 'delete from grc_avaliacao_devolutiva_resultado_area ';
    $sql_d .= ' where idt_avaliacao_devolutiva = '.null($idt_avaliacao_devolutiva);
    $result = execsql($sql_d);

    ForEach ($vetAvaliacaoA as $area => $$vetAvaliacaoAA) {
        //  echo "<tr>";
        ForEach ($vetAvaliacaoAA as $pergunta => $resposta) {
            $percentual = 0;
            if ($resposta == 3) {
                $percentual = 33.33;
            }
            if ($resposta == 2) {
                $percentual = 63.70;
            }
            if ($resposta == 1) {
                $percentual = 100.00;
            }
            $area_descricao = aspa($vetAreaCod[$area]);

            //$idt_area = $vetAreaIdt[strtoupper($area)];
            $idt_area = $vetAreaIdt[$area];
            
            $percentual = $vetGRC_Avaliacao_DRA[$idt_area];
            
            //p($area);
            //p($vetAreaIdt);
            $sql_i = " insert into grc_avaliacao_devolutiva_resultado_area ";
            $sql_i .= " (  ";
            $sql_i .= " idt_avaliacao_devolutiva, ";
            $sql_i .= " idt_area, ";
            $sql_i .= " area_descricao, ";
            $sql_i .= " percentual ";

            $sql_i .= "  ) values ( ";
            $sql_i .= " $idt_avaliacao_devolutiva, ";
            $sql_i .= " $idt_area, ";
            $sql_i .= " $area_descricao, ";
            $sql_i .= " $percentual ";
            $sql_i .= ") ";
            $result = execsql($sql_i);
            //echo "'".$sql_i."'<br />";
            //   echo "<td>";
            // echo " A = $area P = $pergunta R = $resposta <br />  ";
            // echo "<td>";
        }
        //echo "</tr>";
    }
//echo "</table>";   

    /*
      // gravar ferramentas e Produtos
      ForEach ($vetFerr as $idt_ferramenta => $descricao)
      {
      $sql = 'select ';
      $sql .= '  gec_adf.*   ';
      $sql .= '  from grc_avaliacao_devolutiva_ferramenta gec_adf ';
      $sql .= '  where gec_ac.idt_subarea  = '.null($idt_ele);
      $sql .= '    and gec_ac.idt_area     = '.null($idt_area);
      $sql .= '    and nivel               = 2 ';
      $rs = execsql($sql);

      $numCodSubArea = $numCodSubArea + 1;
      $codigow = ZeroEsq($numCodSubArea, 3);
      $codigow = $codigo_ant.$codigow;

      $codigo = aspa($codigow);

      if ($rs->rows == 0) {   // Nova Área - Incluir
      //

      $descricao = aspa($nome);
      $ativaw = 'N';
      if ($ativa == 1) {
      $ativaw = 'S';
      }
      $ativo = aspa($ativaw);
      $idt_area = null($idt_area);
      $idt_subarea = null($idt_subarea);
      $idt_ele = null($idt_ele);
      $publica = aspa("S");
      $nivel = 2;
      $tipo = aspa("S");

      //
      $sql_i = " insert into gec_area_conhecimento ";
      $sql_i .= " (  ";
      $sql_i .= " codigo, ";
      $sql_i .= " descricao, ";
      $sql_i .= " ativo, ";
      $sql_i .= " idt_area, ";
      $sql_i .= " idt_subarea, ";
      $sql_i .= " idt_ele, ";
      $sql_i .= " nivel, ";
      $sql_i .= " tipo, ";
      $sql_i .= " publica ";
      $sql_i .= "  ) values ( ";
      $sql_i .= " $codigo, ";
      $sql_i .= " $descricao, ";
      $sql_i .= " $ativo, ";
      $sql_i .= " $idt_area, ";
      $sql_i .= " $idt_subarea, ";
      $sql_i .= " $idt_ele, ";
      $sql_i .= " $nivel, ";
      $sql_i .= " $tipo, ";
      $sql_i .= " $publica ";
      $sql_i .= ") ";
      $result = execsql($sql_i);
      $vetIDTSubArea[$idt_area][$idt_subarea] = lastInsertId();
      $vetCodigoSubArea[$idt_area][$idt_subarea] = $codigow;
      }




      }
      `grc_avaliacao_devolutiva_ferramenta` (
      `idt_avaliacao_devolutiva` INTEGER UNSIGNED NOT NULL,
      `idt_ferramenta` INTEGER UNSIGNED NOT NULL,
      `ativo` CHAR(1) NOT NULL DEFAULT 'S',
      `status` CHAR(2) NOT NULL DEFAULT 'DE',


      grc_avaliacao_devolutiva_produto` (
      `idt_avaliacao_devolutiva` INTEGER UNSIGNED NOT NULL,
      `idt_produto` INTEGER UNSIGNED NOT NULL,
      `ativo` CHAR(1) NOT NULL DEFAULT 'S',
      `status` CHAR(2) NOT NULL DEFAULT 'DE',

      ForEach ($kvetProdutoFocoP as $idt_produto => $idt_Foco_tematico)
      {

      }

      $kvetProdutoFocoP[$idt_produto]

     */
}