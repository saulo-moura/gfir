<style>
</style>

<?php
if ($idt_avaliacao != '') {
    $_GET['idt_avaliacao'] = $idt_avaliacao;
}

$sql = '';
$sql .= ' select grc_ndi.*, grc_nd.detalhe as grc_nd_detalhe';
$sql .= ' from grc_nan_devolutiva grc_nd ';
$sql .= ' inner join grc_nan_devolutiva_item grc_ndi ';
$sql .= ' where grc_nd.codigo = ' . aspa('01');
$sql .= ' order by grc_ndi.codigo ';
$rs = execsql($sql);
$vetHtml = Array();
$vetAtributosG = Array();
foreach ($rs->data as $row) {
    $codigo = $row['codigo'];
    $titulo = $row['descricao'];
    $tipo = $row['tipo'];
    $detalhe = $row['detalhe'];
    $grc_nd_detalhe = $row['grc_nd_detalhe'];

    $include = $row['include'];
    $background = $row['background'];
    $color = $row['color'];
    $width = $row['width'];
    $height = $row['height'];
    //	
    $vetAtributos = Array();
    $vetAtributos['TIT'] = $titulo;
    $vetAtributos['BAC'] = $background;
    $vetAtributos['COL'] = $color;

    $vetAtributos['WID'] = $width;
    $vetAtributos['HEI'] = $height;
    $vetAtributos['TIP'] = $tipo;
    $vetAtributos['DET'] = $detalhe;
    $vetAtributos['INC'] = $include;

    // Atributos da Devolutiva - Gerais
    $vetAtributosG['CAB'] = $grc_nd_detalhe;

    $vetcodigo_item = explode('.', $codigo);
    $Tam = count($vetcodigo_item);
    if ($Tam == 1) {
        //
        $codigo_item = $vetcodigo_item[0];
        $codigo_subitem = '00';
    } else {
        $codigo_item = $vetcodigo_item[0];
        $codigo_subitem = $vetcodigo_item[1];
    }

    $vetHtml[$codigo_item][$codigo_subitem] = $vetAtributos;
}
$codigo_ant = "##";
$codigo_subant = "##";

$grc_nd_detalhe = $vetAtributosG['CAB'];

$sql = "select  ";
$sql .= "   year(grc_at.data) as grc_at_ano, grc_gat.nan_ciclo";
$sql .= " from grc_avaliacao grc_a ";
$sql .= " inner join grc_atendimento grc_at on grc_at.idt = grc_a.idt_atendimento ";
$sql .= " left outer join grc_nan_grupo_atendimento grc_gat on grc_gat.idt = grc_at.idt_grupo_atendimento ";
$sql .= " where grc_a.idt = " . null($idt_avaliacao);
$rs = execsql($sql);
$grc_at_ano = $rs->data[0]['grc_at_ano'];
$nan_ciclo = $rs->data[0]['nan_ciclo'];

if ($grc_at_ano != '') {
    $grc_nd_detalhe = str_replace('2016', $grc_at_ano, $grc_nd_detalhe);
    $vetAtributosG['CAB'] = $grc_nd_detalhe;
}

if ($nan_ciclo == '') {
    $nan_ciclo = 1;
}

echo "<table  border='0' cellspacing='0' cellpadding='0' width='100%' >";
echo "<tr>";
$stylo = "font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:12pt;";
echo "<td colspan='2' style='{$stylo}' >";
echo $grc_nd_detalhe;
echo "</td>";
echo "</tr>";
$lado = 0;
ForEach ($vetHtml as $codigo_item => $vetItem) {
    $usaRegistro = true;

    if ($codigo_item == 27 && $nan_ciclo == 1) {
        $usaRegistro = false;
    }

    if ($usaRegistro) {
        ForEach ($vetItem as $codigo_subitem => $vetAtributos) {
            $titulo = $vetAtributos['TIT'];
            $background = $vetAtributos['BAC'];
            $color = $vetAtributos['COL'];
            $width = $vetAtributos['WID'];
            $height = $vetAtributos['HEI'];
            $tipo = $vetAtributos['TIP'];
            $detalhe = $vetAtributos['DET'];
            $include = $vetAtributos['INC'];
            if ($background == '') {
                $background = '#FF8000;';
            }
            if ($color == '') {
                $color = '#004080;';
            }
            if ($width == '') {
                $width = '100%';
            } else {
                $width = $width . '%';
            }
            if ($height == '') {
                $height = '25px';
            } else {
                $height = $height . 'px';
            }
            if ($codigo_ant != '##') {
                if ($codigo_ant != $codigo_item) {
                    echo "</tr>";
                    echo "<tr>";
                    $codigo_ant = $codigo_item;
                }
            } else {
                echo "<tr>";
                $codigo_ant = $codigo_item;
            }
            //
            // monta stylo
            //
		if ($codigo_subitem == '00') {
                $stylo = "padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; font-size:11pt; border:0.3px solid #000000; text-align:center; width:{$width}; background:{$background}; color:{$color}; ";
                echo "<td colspan='2' style='{$stylo}' >";
                //echo " $codigo_item - $codigo_subitem - $titulo "; 
                echo " $titulo ";
                echo "</td>";

                if ($tipo == 1 or $tipo == 3) {
                    echo "</tr>";
                    echo "<tr>";
                    $stylod = "padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; font-size:10pt; border-left:0.3px solid #000000; border-right:0.3px solid #000000; text-align:center;";
                    echo "<td colspan='2' style='{$stylod}' >";
                    echo $detalhe;
                    echo "</td>";
                }
                if ($tipo == 2 or $tipo == 3) {
                    echo "</tr>";
                    echo "</table>";

                    //echo "<tr>";


                    $stylod = "xpadding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; font-size:10pt; border-left:0.3px solid #000000; border-right:0.3px solid #000000; text-align:center;";
                    //echo "<td colspan='2' style='{$stylod}' >";
                    $path = 'cadastro_conf/' . $include . '.php';
                    if (file_exists($path)) {
                        Require_Once($path);
                    } else {
                        echo "Item não implementado.";
                    }
                    //echo "</td>";
                    echo "<table  border='0' cellspacing='0' cellpadding='0' width='100%' >";
                }
            } else {
                $stylo = "padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; font-size:11pt; border:0.3px solid #000000; text-align:center; width:{$width}; background:{$background}; color:{$color}; ";
                echo "<td style='{$stylo}' >";
                //echo " $codigo_item - $codigo_subitem - $titulo "; 
                echo " $titulo ";
                echo "</td>";
                $lado = $lado + 1;
                if (($tipo == 2 or $tipo == 3) and $lado == 2) {
                    $lado = 0;
                    echo "</tr>";
                    echo "</table>";

                    //echo "<tr>";
                    $stylod = "padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; font-size:10pt; border-left:0.3px solid #000000; border-right:0.3px solid #000000; text-align:center;";
                    //echo "<td colspan='2' style='{$stylod}' >";
                    $path = 'cadastro_conf/' . $include . '.php';
                    if (file_exists($path)) {
                        Require_Once($path);
                    } else {
                        echo "Item não implementado.";
                    }
                    //echo "</td>";
                    echo "<table  border='0' cellspacing='0' cellpadding='0' width='100%' >";
                }
            }
        }
    }
}
echo "</table>";

/* 
if ($veio=='DE')
{
	echo "<table border='0' cellspacing='0' cellpadding='0' width='100%' style='' >";
	echo "<tr>";
	$stylo="font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:12pt;";
	echo "<td colspan='2' style='{$stylo}' >";
	$Require_Once="cadastro_conf/botao_devolutiva.php";
	if (file_exists($Require_Once)) {
		Require_Once($Require_Once);
	} else {
		echo "PROBLEMA NA dos botões da devolutiva. CONTACTAR ADMINISTRADOR DO SISTEMA";
	}
	echo "</td>";
	echo "</tr>";
	echo "</table>";
 
} 
 */
 
 