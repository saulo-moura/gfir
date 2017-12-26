<?php
if ($acao=='inc')
{
    $sql1  = 'select ';
    $sql1 .= '  grc_com.*   ';
    $sql1 .= '  from grc_competencia grc_com ';
    $sql1 .= '  where fechado = '.aspa('S');
    $sql1 .= '  order by ano desc, mes desc ';
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
        }
        //$datadia = trata_data(date('d/m/Y H:i:s'));
        

        $data_inicialw = date('d/m/Y', strtotime('+1 days', strtotime($data_final)));
        $data_finalw   = date('d/m/Y', strtotime('+30 days', strtotime($data_inicialw)));

        $vetRow['grc_competencia']['data_inicial'] = $data_inicialw;
        $vetRow['grc_competencia']['data_final']   = $data_finalw;

        $ano          = substr($data_inicialw,6,4);
        $mes          = substr($data_inicialw,3,2);
        $texto        = $vetMes[$mes].'/'.$ano;
        $vetRow['grc_competencia']['ano']   = $ano;
        $vetRow['grc_competencia']['ano']   = $mes;
        $vetRow['grc_competencia']['ano']   = $texto;
        //
        $vetRow['grc_competencia']['fechado']   = 'N';
    }
}
?>