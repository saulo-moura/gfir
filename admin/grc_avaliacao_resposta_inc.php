<?php

//echo " entrei <br />";

if ($row_s['detalhe'] != '') {
    echo '<div class="detalhe_secao">'.conHTML($row_s['detalhe']).'</div>';
}

$MatrizDigitacao = $vetVariavel['MatrizDigitacao'];

$sql = '';
$sql .= ' select * ';
$sql .= ' from grc_formulario_pergunta';
$sql .= ' where idt_secao = '.null($row_s['idt']);
$sql .= ' order by codigo_quesito,sigla_dimensao, codigo';
$rs_p = execsql($sql);


//echo " meu display sql: <br />";

//p($sql);



foreach ($rs_p->data as $row_p) {
    echo '<div class="pergunta_cont">';

    if ($row_p['detalhe'] != '') {
        echo '<div class="detalhe">'.conHTML($row_p['detalhe']).'</div>';
    }
    $idt_classe = $row_p['idt_classe'];

    $Pergunta = ($row_p['descricao']);
    $Numero = $row_p['codigo'];
    $NumeroP = $row_p['codigo'];
    $codigo_quesito = $row_p['codigo_quesito'];
    $Sigla_dimensao = $row_p['sigla_dimensao'];
    $Asterisco = "";
    $Obrigatorio = $row_p['obrigatoria'];

    if ($Obrigatorio == "S") {
        $Asterisco = "*";
    }

    $titulo = 'PERGUNTA';
    $Sigla_dimensaow = "({$Sigla_dimensao})";
    $indiceD = 0;

    if ($Sigla_dimensao == 'GE') {
        $titulo = 'PERGUNTA';
        $Sigla_dimensaow = "";
        $Numero = "";
        $indiceD = 2;
    }

    if ($Sigla_dimensao == 'E') {
        $titulo = 'PERGUNTA';
        $Sigla_dimensaow = "";
        $indiceD = 2;
    }

    if ($Sigla_dimensao == 'Q') {
        $titulo = 'QUESITO';
        $Numero = "";
        $Sigla_dimensaow = "";
        $indiceD = 1;
    }

    if ($Sigla_dimensao == 'A') {
        $titulo = 'PERCEPÇÃO DO EMPRESARIO';
        $Numero = "";
        $Sigla_dimensaow = "";
        $indiceD = 3;
    }

    echo "<div class='pergunta'>"."<b>{$titulo} {$Numero} {$Sigla_dimensaow} : </b>".$Pergunta.$Asterisco.'</div>';

    echo "<ul class='prgunta_respostas'>";

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from grc_formulario_resposta';
    $sql .= ' where idt_pergunta = '.null($row_p['idt']);
    $sql .= ' order by codigo';
    $rs_r = execsql($sql);

    foreach ($rs_r->data as $row_r) {
        echo "<li class='respostas'>";

        echo '<label for="r'.$row_r['idt'].'">';

        if (array_key_exists($row_r['idt'], $vetResp)) {
            $checked = 'checked';
        } else {
            $checked = '';
        }

        echo '<input class="radio" type="radio" '.$checked.' id="r'.$row_r['idt'].'" name="p'.$row_p['idt'].'" value="'.$row_r['idt'].'" />';

        $Resposta = ($row_r['descricao']);
        echo $Resposta;
        $NumeroR = $row_r['codigo'];

        $MatrizDigitacao[$idt_classe][$codigo_quesito][$NumeroP][$NumeroR] = $checked;


        echo '</label>';

        if ($row_r['detalhe'] != '') {
            echo '<div class="detalhe">'.conHTML($row_r['detalhe']).'</div>';
        }

        if ($row_r['campo_txt'] == 'S') {
            echo '<div class="evidencia">';
            echo 'Evidências: <span class="xasterisco">*</span><br />';
            echo '<textarea class="Tit_Campo_Obr" name="txt'.$row_r['idt'].'">'.$vetResp[$row_r['idt']].'</textarea>';
            echo '</div>';
        }

        echo '</li>';
    }

    echo '</ul>';

    echo '</div>';
}



if ($row_s['evidencia'] == 'S') {
    $area = $row_s['descricao'];

    $evidencia = $vetRespS[$row_s['idt']];

    $titulo = "Evidências/Comentários da área {$area}: <span class='xasterisco'>*</span><br />";
    echo "<div class='pergunta'>"."<b>{$titulo}</div>";
    echo '<div class="evidencia_s">';

    echo '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
    echo '<tr>';
    echo '<td>';
    
    echo '<textarea class="Tit_Campo_Obr txt_s" name="evidencia'.$row_s['idt'].'">'.$evidencia.'</textarea>';
    
    echo '</td>';
    echo '<td class="asa" id="grc_avaliacao_secao_anexo_'.$row_s['idt'].'_desc">';
    
    $titulo = 'Arquivo em Anexo';
    $vetCampoLC = Array();
    $vetCampoLC['descricao'] = CriaVetTabela('Título do Anexo');
    $vetCampoLC['arquivo'] = CriaVetTabela('Arquivo anexado', 'arquivo_sem_nome', '', 'grc_avaliacao_secao_anexo');

    $sql = "select *";
    $sql .= " from grc_avaliacao_secao_anexo";
    $sql .= ' where idt_secao = $vlID';
    $sql .= ' and idt_avaliacao = '.null($_GET['id']);
    $sql .= " order by descricao";

    $vetPadraoLC = Array(
        'menu_acesso' => 'grc_avaliacao_secao_anexo',
    );

    $ColunaLC = objListarConf('grc_avaliacao_secao_anexo_'.$row_s['idt'], 'idt', $vetCampoLC, $sql, $titulo, false, $vetPadraoLC, 'grc_avaliacao_secao_anexo');
    $ColunaLC['tabela'] = 'grc_formulario_secao';

    $vetIDLC = Array(
        'grc_avaliacao' => $_GET['id'],
        'grc_formulario_secao' => $row_s['idt'],
    );

    echo '<div>';
    codigoListarConf($ColunaLC, $vetIDLC);
    echo '</div>';
    
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

$vetVariavel['MatrizDigitacao'] = $MatrizDigitacao;
