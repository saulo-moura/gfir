<style>
</style>

<?php
// $idt_avaliacao=$_GET['idt_avaliacao'];


$sql = "select  ";
$sql .= "   grc_a.*,  ";
$sql .= "   grc_at.protocolo as grc_at_protocolo,  ";
$sql .= "   grc_as.descricao as grc_as_descricao,  ";
$sql .= "   grc_atg.nan_ciclo as grc_atg_nan_ciclo,  ";
$sql .= "   gec_eclio.codigo as gec_eclio_codigo, ";
$sql .= "   gec_eclio.descricao as gec_eclio_descricao, ";
$sql .= "   gec_eclip.descricao as gec_eclip_descricao, ";
$sql .= "   gec_ecreo.descricao as gec_ecreo_descricao, ";
$sql .= "   gec_ecrep.descricao as gec_ecrep_descricao ";
$sql .= " from grc_avaliacao grc_a ";
$sql .= " inner join grc_avaliacao_situacao grc_as on grc_as.idt = grc_a.idt_situacao ";
$sql .= " inner join grc_atendimento        grc_at on grc_at.idt = grc_a.idt_atendimento ";
$sql .= " inner join grc_nan_grupo_atendimento grc_atg on grc_atg.idt = grc_at.idt_grupo_atendimento ";
$sql .= " left join " . db_pir_gec . "gec_entidade gec_eclio on gec_eclio.idt = grc_a.idt_organizacao_avaliado ";
$sql .= " left join " . db_pir_gec . "gec_entidade gec_eclip on gec_eclip.idt = grc_a.idt_avaliado ";
$sql .= " left join " . db_pir_gec . "gec_entidade gec_ecreo on gec_ecreo.idt = grc_a.idt_organizacao_avaliador ";
$sql .= " left join " . db_pir_gec . "gec_entidade gec_ecrep on gec_ecrep.idt = grc_a.idt_avaliador ";
$sql .= " where grc_a.idt = " . null($idt_avaliacao);
$rs = execsql($sql);
foreach ($rs->data as $row) {
    $grc_at_protocolo = $row['grc_at_protocolo'];
    $codigo = $row['codigo'];
    $descricao = $row['descricao'];
    $data_avaliacao = trata_data($row['data_avaliacao']);
    $gec_eclio_descricao = $row['gec_eclio_descricao'];
    $gec_eclip_descricao = $row['gec_eclip_descricao'];
    $gec_ecreo_descricao = $row['gec_ecreo_descricao'];
    $gec_ecrep_descricao = $row['gec_ecrep_descricao'];
    $grc_atg_nan_ciclo = $row['grc_atg_nan_ciclo'];
    $gec_eclio_codigo = $row['gec_eclio_codigo'];
}

$vetResultadoArea = Array();
$vetResultadoAreaNum = Array();

if ($grc_atg_nan_ciclo > 1) {
    $sql = '';
    $sql .= ' select av.idt, g.nan_ciclo';
    $sql .= ' from grc_nan_grupo_atendimento g';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade e on e.idt = g.idt_organizacao';
    $sql .= " inner join grc_atendimento a on a.idt_grupo_atendimento = g.idt ";
    $sql .= " inner join grc_avaliacao av on av.idt_atendimento = a.idt ";
    $sql .= ' where g.nan_ciclo < ' . null($grc_atg_nan_ciclo);
    $sql .= ' and e.codigo = ' . aspa($gec_eclio_codigo);
    $sql .= " and g.status_2 = 'AP'";
    $sql .= ' and a.nan_num_visita = 1';
    $sql .= ' order by g.idt desc, av.idt desc limit 1';
    $rs = execsql($sql);
	$rowx = $rs->data[0];
    
    $vetResultadoArea[1] = dadosCiclo($rowx['idt']);
    $vetResultadoArea[2] = dadosCiclo($idt_avaliacao);
    
	$vetResultadoAreaNum[1] = $rowx['nan_ciclo'];
    $vetResultadoAreaNum[2] = $grc_atg_nan_ciclo;
} else {
    $vetResultadoArea[1] = dadosCiclo($idt_avaliacao);
    $vetResultadoArea[2] = '';
    
	$vetResultadoAreaNum[1] = 1;
    $vetResultadoAreaNum[2] = 2;
}

verificaInfAvaliacaoNAN($idt_avaliacao, $gec_ecreo_descricao, $gec_ecrep_descricao, $gec_eclio_descricao, $gec_eclip_descricao);

//$background = '#2C3E50;';
$background = '#ECF0F1';
$color = '#000000';

//echo "<pagebreak />";

echo "<table border='0' cellspacing='0' cellpadding='0' width='100%' style='' >";
$titulo = "PLANO FÁCIL SEBRAE - BA";
$stylo = "border:1px solid #c4c9cd;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:14pt; color:$color; background:$background;";
echo "<tr >";

$header = '<img style="padding:5px;" src="imagens/logo_sebrae.png" alt="" border="0" />';
echo "<td  style='{$stylo}' >";
echo $header;
echo "</td>";


echo "<td colspan='3' style='{$stylo}' >";
echo "<span style='' ><b>{$titulo}</b></span>";
echo "</td>";



$header = '<img style="padding:5px;" src="imagens/negocioanegocio.jpg" alt="" border="0" />';
echo "<td  style='{$stylo}' >";
echo $header;
echo "</td>";


echo "</tr>";

echo "</table>";


echo "<table border='0' cellspacing='0' cellpadding='0' width='100%' style='' >";


$background = '#FFFFFF';
$color = '#000000';


$stylo = "border:1px solid #C0C0C0;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:9pt; color:$color; background:$background;";
echo "<tr >";
echo "<td colspan='2' style='{$stylo}' >";
echo "<span style='' >Empresa: <b> {$gec_eclio_descricao}</b></span>";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td  style='{$stylo}' >";
echo "Data do Diagnóstico: <b>{$data_avaliacao}</b>";
echo "</td>";
echo "<td  style='{$stylo}' >";
echo "Cliente: <b>{$gec_eclip_descricao}</b>";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td   style='{$stylo}' >";
echo "Agente de Orientação Empresarial: <b>{$gec_ecrep_descricao}</b>";
echo "</td>";
echo "<td  style='{$stylo}' >";
echo "Protocolo da 1a Visita: <b>{$grc_at_protocolo}</b>";
echo "</td>";

echo "</tr>";

echo "</table>";
echo "<table border='0' cellspacing='0' cellpadding='0' width='100%' style='' >";

$background = '#2F66BB';
$color = '#FFFFFF';

$stylo = "border:1px solid #C0C0C0;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:9pt; color:$color; background:$background;";
echo "<tr>";
echo "<td rowspan='2' style='{$stylo} width:300px; xborder-right:1px solid #000000; ' >";
echo "<b>1 - EU OBSERVO e PRIORIZO</b>";
echo "</td>";
echo "<td rowspan='2' style='{$stylo} width:250px;' >";
echo "<b>2 - EU DECIDO e PLANEJO</b>";
echo "</td>";
$stylo = "border:1px solid #C0C0C0;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:9pt; color:$color; background:$background;";
echo "<td colspan='2' style='{$stylo}' >";
echo "<b>3 - EU FAÇO</b>";
echo "</td>";
$stylo = "border:1px solid #C0C0C0;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:9pt; color:$color; background:$background;";
echo "<td rowspan='2' style='{$stylo} width:200px;' >";
echo "<b>4 - EU APRENDO</b>";
echo "</td>";
echo "</tr>";

$stylo = "border:1px solid #C0C0C0;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:9pt; color:$color; background:$background;";
echo "<tr>";
echo "<td style='{$stylo} width:200px;' >";
echo "<b>QUEM</b>";
echo "</td>";
echo "<td style='{$stylo} width:150px;' >";
echo "<b>QUANDO</b>";
echo "</td>";
echo "</tr>";

/*

  $sql = "select  ";
  $sql .= "   grc_fa.descricao  as grc_fa_descricao,  ";
  $sql .= "   grc_ffg.descricao as grc_ffg_descricao  ";
  $sql .= " from grc_avaliacao grc_a ";
  $sql .= " inner join grc_avaliacao_devolutiva            grc_ad  on grc_ad.idt_avaliacao             = grc_a.idt ";
  $sql .= " inner join grc_avaliacao_devolutiva_ferramenta grc_adf on grc_adf.idt_avaliacao_devolutiva = grc_ad.idt ";
  $sql .= " inner join grc_formulario_ferramenta_gestao    grc_ffg on grc_ffg.idt                      = grc_adf.idt_ferramenta ";
  $sql .= " inner join grc_formulario_area                 grc_fa  on grc_fa.idt                       = grc_ffg.idt_area ";
  $sql .= " where grc_a.idt = ".null($idt_avaliacao);
  $sql .= " order by grc_adf.ordem ";
  $rs = execsql($sql);

  $vetProd = Array();

  foreach ($rs->data as $row) {
  $vetProd[$row['grc_fa_descricao']][] = $row['grc_ffg_descricao'];
  }
 */



$sql = "select  ";
$sql .= "   grc_fa.descricao  as grc_fa_descricao,  ";
$sql .= "   grc_ffg.descricao as grc_ffg_descricao  ";
$sql .= " from grc_avaliacao grc_a ";
$sql .= " inner join grc_avaliacao_devolutiva            grc_ad  on grc_ad.idt_avaliacao             = grc_a.idt ";
$sql .= " inner join grc_avaliacao_devolutiva_ferramenta grc_adf on grc_adf.idt_avaliacao_devolutiva = grc_ad.idt ";
$sql .= " inner join grc_formulario_ferramenta_gestao    grc_ffg on grc_ffg.idt                      = grc_adf.idt_ferramenta ";
$sql .= " inner join grc_formulario_area                 grc_fa  on grc_fa.idt                       = grc_ffg.idt_area ";
$sql .= " where grc_a.idt = " . null($idt_avaliacao);
$sql .= " order by grc_adf.ordem ";
$rs = execsql($sql);

$vetProd = Array();

foreach ($rs->data as $row) {
    $vetProd[$row['grc_fa_descricao']][] = $row['grc_ffg_descricao'];
}

foreach ($vetProd as $grc_fa_descricao => $grc_ffg_descricao) {
// Para Cada Ferramenta

    $observo = '';
    $observo .= "<b>$grc_fa_descricao</b><br /><br />";
    $observo .= implode('<br />', $grc_ffg_descricao);
    $observo .= "<br /><br /><br />";

    $decido = "&nbsp;";
    $quem = "&nbsp;";
    $quando = "&nbsp;";
    $aprendo = "&nbsp;";
    $background = '#FFFFFF';
    $color = '#000000';
    $stylo = "border:1px solid #C0C0C0;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:9pt; color:$color; background:$background;";
    echo "<tr>";
    echo "<td style='{$stylo} text-align:center; xborder-right:1px solid #000000; ' >";
    echo "$observo";
    echo "</td>";
    echo "<td style='{$stylo} ' >";
    echo "$decido";
    echo "</td>";
    echo "<td style='{$stylo} ' >";
    echo "$quem";
    echo "</td>";
    echo "<td style='{$stylo} ' >";
    echo "$quando";
    echo "</td>";
    echo "<td style='{$stylo} ;' >";
    echo "$aprendo";
    echo "</td>";
    echo "</tr>";
}

echo "</table>";
echo '<pagebreak />';
echo "<table border='0' cellspacing='0' cellpadding='0' width='100%' style='' >";

$background = '#FFB740';
$color = '#FFFFFF';
$stylo = "border:1px solid #C0C0C0;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:9pt; color:$color; background:$background;";
echo "<tr>";
echo "<td rowspan='2' width='550px' style='{$stylo} text-align:center; ' >";
echo "<b>BANCO DE IDEIAS</b>";
echo "</td>";
$background = '#2F66BB';
$color = '#FFFFFF';
$stylo = "border:1px solid #C0C0C0;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:9pt; color:$color; background:$background;";
echo "<td colspan='2' style='{$stylo} ' >";
echo "<b>5 - EU VEJO MINHA EMPRESA CRESCER</b>";
echo "</td>";
echo "<td rowspan='2' width='200px' style='{$stylo} ' >";
echo "<b>6 - RELACIONAMENTO SEBRAE</b>";
echo "</td>";
echo "</tr>";
echo "<tr>";
$stylo = "border:1px solid #C0C0C0;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:9pt; color:$color; background:$background;";
echo "<td style='{$stylo} ' width='200px' >";
echo "<b>CICLO ".$vetResultadoAreaNum[1]."</b>";
echo "</td>";
echo "<td style='{$stylo} ' width='150px'>";
echo "<b>CICLO ".$vetResultadoAreaNum[2]."</b>";
echo "</td>";
echo "</tr>";
$background = '#FFFFFF';
$color = '#000000';
$stylo = "border:1px solid #C0C0C0;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:9pt; color:$color; background:$background;";
echo "<tr>";
echo "<td  style='{$stylo} ' >";
echo "<br /><br /><br /><br />";
echo "</td>";


echo "<td  style='{$stylo} ' >";
echo $vetResultadoArea[1];
echo "<td  style='{$stylo} ' >";
echo $vetResultadoArea[2];
echo "</td>";
echo "<td   style='{$stylo} ' >";
echo "<br /><br /><br /><br />";
echo "</td>";
echo "</tr>";
////////////// rodapé
$stylow = "border:1px solid #C0C0C0;  padding:0px; margin:0px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:9pt; color:$color; background:$background;";
echo "<tr>";
$header = '<img src="imagens/rodape_plano_facil.png" alt="" border="0" />';
echo "<td  colspan='4' style='{$stylow}' >";
echo $header;
echo "</td>";
echo "</tr>";
echo "</table>";

function dadosCiclo($idt_avaliacao) {
    $sql = "select  ";
    $sql .= "   grc_fa.descricao  as grc_fa_descricao,  ";
    $sql .= "   grc_adra.percentual as grc_adra_percentual  ";
    $sql .= " from grc_avaliacao grc_a ";
    $sql .= " inner join grc_avaliacao_devolutiva            grc_ad  on grc_ad.idt_avaliacao             = grc_a.idt ";
    $sql .= " inner join grc_avaliacao_devolutiva_resultado_area grc_adra on grc_adra.idt_avaliacao_devolutiva = grc_ad.idt ";
    $sql .= " inner join grc_formulario_area                 grc_fa  on grc_fa.idt                       = grc_adra.idt_area ";
    $sql .= " where grc_a.idt = " . null($idt_avaliacao);
    $sql .= " order by grc_fa.codigo ";
    $rs = execsql($sql);
	
    $resultadoarea = "<table border='0' cellspacing='0' cellpadding='0' width='100%' style='' >";

    $resultadoarea .= "<tr>";
    $resultadoarea .= "<td style='text-align:center; background:#ABBBBF; border-right:1px solid #C0C0C0; border-bottom:1px solid #C0C0C0;' >";
    $resultadoarea .= "CRITÉRIO";
    $resultadoarea .= "<td style='text-align:center; background:#ABBBBF; border-bottom:1px solid #C0C0C0;'>";
    $resultadoarea .= "% OBTIDA";
    $resultadoarea .= "</td>";
    $resultadoarea .= "</tr>";

    foreach ($rs->data as $row) {
        $resultadoarea .= "<tr>";
        $resultadoarea .= "<td style='text-align:center; padding:3px; border-right:1px solid #C0C0C0; border-bottom:1px solid #C0C0C0;'>";
        $resultadoarea .= $row['grc_fa_descricao'];
        $resultadoarea .= "<td style='text-align:center; padding:3px; border-bottom:1px solid #C0C0C0;'>";
        $resultadoarea .= format_decimal($row['grc_adra_percentual']);
        $resultadoarea .= "</td>";
        $resultadoarea .= "</tr>";
    }
    
    $resultadoarea .= "</table>";
    
    return $resultadoarea;
}
