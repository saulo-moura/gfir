<?php
$tabela = 'grc_competencia';
$id = 'idt';



if ($acao=='alt' or $acao=='exc')
{
    $sql1  = 'select ';
    $sql1 .= '  grc_com.*   ';
    $sql1 .= '  from grc_competencia grc_com ';
    $sql1 .= '  where idt = '.null($_GET['id']);
    $rs_aa = execsql($sql1);
    if ($rs_aa->rows == 0)
    {
        // Tudo será informado
    }
    else
    {
        ForEach ($rs_aa->data as $rowp) {
            $data_inicial = $rowp['data_inicial'];
            $data_final   = $rowp['data_final'];
            $ano          = $rowp['ano'];
            $mes          = $rowp['mes'];
            $texto        = $rowp['texto'];
            $fechado      = $rowp['fechado'];
        }
    }
    if ($fechado=='S')
    {
        $acao='con';
        echo "<div style='background:#0000FF; color:#FFFFFF; font-size:20px; height:30px; text-align:center; ' >";
        echo "COMPETÊNCIA FECHADA SÓ PODE SER CONSULTADA";
        echo "</div>";
    }
}
else
{
    if ($acao=='inc')
    {
        $sql1  = 'select ';
        $sql1 .= '  grc_com.*   ';
        $sql1 .= '  from grc_competencia grc_com ';
        $sql1 .= '  where fechado = '.aspa('N');
        $rs_aa = execsql($sql1);
        if ($rs_aa->rows == 0)
        {
            // Incluir
        }
        else
        {
            ForEach ($rs_aa->data as $rowp) {
                $idt          = $rowp['idt'];
                $data_inicial = $rowp['data_inicial'];
                $data_final   = $rowp['data_final'];
                $ano          = $rowp['ano'];
                $mes          = $rowp['mes'];
                $texto        = $rowp['texto'];
                $fechado      = $rowp['fechado'];
            }
            //
            $_GET['id']=$idt;
            //
            $acao='con';
            echo "<div style='background:#0000FF; color:#FFFFFF; font-size:20px; height:30px; text-align:center; ' >";
            echo "COMPETÊNCIA JÁ ESTA ABERTA SÓ PODE SER CONSULTADA";
            echo "</div>";
        }
    }
}







$vetCampo['data_inicial']    = objData('data_inicial', 'Data Inicial', True,'','','S');
$vetCampo['data_final']      = objData('data_final', 'Data Final', True,'','','S');
$vetCampo['ano']             = objTexto('ano', 'Ano', True, 4, 4);
$vetCampo['mes']             = objTexto('mes', 'Mês', True, 2, 2);
$vetCampo['fechado']         = objCmbVetor('fechado', 'Fechado?', True, $vetSimNao);
//
$vetCampo['texto']           = objTexto('texto', 'Descrição', True, 45, 45);

$vetFrm = Array();
$vetFrm[] = Frame('<span>Intervalo de Datas</span>', Array(
    Array($vetCampo['data_inicial'],'',$vetCampo['data_final'],'',$vetCampo['fechado']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Competência</span>', Array(
    Array($vetCampo['ano'],'',$vetCampo['mes'],'',$vetCampo['texto']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>