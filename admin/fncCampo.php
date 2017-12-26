<?php

function objBarraTitulo($campo, $nome, $class = '') {
    global $tabela;

    $vet = Array();

    if ($class != '') {
        $class = 'class="' . $class . '"';
    }

    $vet['tipo'] = 'BarraTitulo';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 2;
    $vet['focus'] = false;
    $vet['campo_tabela'] = false;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = false;

    $vet['class'] = $class;

    return $vet;
}

function objTextArea($campo, $nome, $valida, $maxlength, $style = '', $js = '', $campo_tabela = true, $vl_padrao = '') {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'TextArea';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = true;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;

    $vet['maxlength'] = $maxlength;
    $vet['style'] = $style;
    $vet['js'] = $js;
    $vet['vl_padrao'] = $vl_padrao;

    return $vet;
}

function objTexto($campo, $nome, $valida, $size, $maxlength = '', $js = '', $valor = '', $campo_tabela = true) {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'Geral';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = true;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;

    $vet['size'] = $size;
    $vet['maxlength'] = ($maxlength == '' ? $size : $maxlength);
    $vet['js'] = $js;
    $vet['valor'] = $valor;

    return $vet;
}

function objTextoFixo($campo, $nome, $size = '', $campo_tabela = false, $valida = false, $vl_padrao = '') {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'TextoFixo';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = false;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;

    $vet['size'] = $size;
    $vet['vl_padrao'] = $vl_padrao;

    return $vet;
}

function objTextoFixoVL($campo, $nome, $valor, $size = '', $campo_tabela = true, $color = '') {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'TextoFixoVL';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = false;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = false;

    $vet['color'] = $color;

    $vet['size'] = $size;
    $vet['valor'] = $valor;

    return $vet;
}

function objInteiro($campo, $nome, $valida, $size, $maxlength = '', $valor = '', $jst = '', $jst2 = '') {
    if ($jst2 != "") {
        $js = " {$jst2} ";
    } else {
        $js = " onBlur = 'enumero(this)'  {$jst} ";
    }
    return objTexto($campo, $nome, $valida, $size, $maxlength, $js, $valor);
}

function objInteiroZero($campo, $nome, $valida, $size, $maxlength = '') {
    $js = "onFocus = 'tira_zero(this)' onBlur = 'enumero_zero(this, " . ($maxlength == '' ? $size : $maxlength) . ")'";
    return objTexto($campo, $nome, $valida, $size, $maxlength, $js);
}

function objHora($campo, $nome, $valida, $js_cust = '', $js_subs = '') {
    $size = 5;
    $maxlength = 5;
    $js = 'onblur="return Valida_Hora(this)" onkeyup="return Formata_Hora(this,event)"  ';
    $js .= $js_cust;
    if ($js_subs != '') {
        $js = $js_subs;
    }
    return objTexto($campo, $nome, $valida, $size, $maxlength, $js);
}

function objDecimal($campo, $nome, $valida, $size, $maxlength = '', $num_decimais = 2, $completapar = '', $vl_padrao = '', $campo_name = '', $campo_tabela = true) {
    global $tabela;

    if (!is_numeric($num_decimais)) {
        $num_decimais = 2;
    }

    if ($campo_name == '') {
        $campo_name = $campo;
    }

    $vet = Array();

    $vet['tipo'] = 'Decimal';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = true;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo'] = $campo;
    $vet['campo_name'] = $campo_name;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;

    $vet['num_decimais'] = $num_decimais;

    $vet['size'] = $size;
    $vet['maxlength'] = ($maxlength == '' ? $size : $maxlength);
    if ($num_decimais == 2) {
        $vet['js'] = "onBlur = 'money(this)'";
    } else {
        $vet['js'] = "onBlur = 'money_ndec(this," . $num_decimais . ")'";
    }
    if ($completapar != '') {
        $vet['js'] = $vet['js'] . '  ' . $completapar;
    }

    $vet['vl_padrao'] = $vl_padrao;


    return $vet;
}

function objCNPJ($campo, $nome, $valida, $mascara = true, $size_p = '', $consiste = '', $jstusu = "", $jst = "") {
    if ($mascara) {
        $size = 21;
        if ($size != '') {
            $size = $size_p;
        }


        if ($consiste != "") {
            $js = $jst . " onblur=' var ret = 0; ret = {$consiste};  if (ret=false) {return false;}else{return Valida_CNPJ(this);} '  onkeyup='return Formata_Cnpj(this,event)' ";
        } else {
            if ($jstusu == '') {
                $js = $jst . ' onblur="return Valida_CNPJ(this)" onkeyup="return Formata_Cnpj(this,event)"';
            } else {
                $js = $jst . ' onblur="return' . $jstusu . '" onkeyup="return Formata_Cnpj(this,event)"';
            }
        }

        $maxlength = 18;
    } else {
        $size = 17;
        $maxlength = 14;
        if ($consiste != "") {
            $js = $jst . " onblur=' var ret = 0; ret = {$consiste};  if (ret=false) {return false;}else{return Valida_CNPJ(this);} ' ";
        } else {
            $js = $jst . ' onblur="return Valida_CNPJ(this)"';
        }
    }

    return objTexto($campo, $nome, $valida, $size, $maxlength, $js);
}

function objCPF($campo, $nome, $valida, $mascara = true, $consiste = "", $jstusu = "", $jst = "") {
    if ($mascara) {
        $size = 15;
        $maxlength = 12;
        if ($consiste != "") {
            $js = $jst . " onblur=' var ret = 0; ret = {$consiste};  if (ret=false) {return false;}else{return Valida_CPF(this);} ' onkeyup='return Formata_Cpf(this,event)'";
        } else {
            if ($jstusu == '') {
                $js = $jst . ' onblur="return   Valida_CPF(this);" onkeyup="return Formata_Cpf(this,event)"';
            } else {
                $js = $jst . ' onblur="return ' . $jstusu . '; " onkeyup="return Formata_Cpf(this,event)"';
            }
        }
    } else {
        $size = 14;
        $maxlength = 11;
        if ($consiste != "") {
            $js = $jst . " onblur=' var ret = 0; ret = {$consiste};  if (ret=false) {return false;}else{return Valida_CPF(this);} ' ";
        } else {
            $js = $jst . " onblur='return Valida_CPF(this);' ";
        }
    }

    return objTexto($campo, $nome, $valida, $size, $maxlength, $js);
}

function objCEP($campo, $nome, $valida, $vetParametros = Array()) {
    global $tabela;

    $vet = Array();

    /*
     * O tipo pode ser os sequintes valores:
     * texto: campo texto
     * cmb_val: combo e utiliza o value para comparação
     * cmb_txt: combo e utiliza o text para comparação
     * cmb_fixo: combo fixo
     * 
     * O retorno_??? pode ser os sequintes valores:
     * S: Campo de Sigla
     * Outro valor: Campo de Nome
     */

    $vetPadrao = Array(
        'consulta_cep' => false,
        'campo_codpais' => '',
        'campo_pais' => '',
        'campo_codest' => '',
        'campo_uf' => '',
        'campo_codcid' => '',
        'campo_cidade' => '',
        'campo_codbairro' => '',
        'campo_bairro' => '',
        'campo_logradouro' => '',
        'tipo_codpais' => 'texto',
        'tipo_pais' => 'texto',
        'tipo_codest' => 'texto',
        'tipo_uf' => 'texto',
        'tipo_codcid' => 'texto',
        'tipo_cidade' => 'texto',
        'tipo_codbairro' => 'texto',
        'tipo_bairro' => 'texto',
        'tipo_logradouro' => 'texto',
        'travado_codpais' => 'S',
        'travado_pais' => 'S',
        'travado_codest' => 'S',
        'travado_uf' => 'S',
        'travado_codcid' => 'S',
        'travado_cidade' => 'S',
        'travado_codbairro' => 'S',
        'travado_bairro' => 'S',
        'travado_logradouro' => 'S',
        'retorno_pais' => 'N',
        'retorno_uf' => 'S',
        'bt_img' => 'imagens/bt_pesquisa.png',
        'bt_title' => 'Pesquisar Endereço',
    );

    if (is_array($vetParametros)) {
        foreach ($vetParametros as $key => $value) {
            $vetPadrao[$key] = $value;
        }
    }

    $vet['tipo'] = 'CEP';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = true;
    $vet['campo_tabela'] = true;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;
    $vet['vetParametros'] = $vetPadrao;

    return $vet;
}

function objTelefone($campo, $nome, $valida, $js = '') {
    $size = 14;
    $maxlength = 14;
    $js = $js . ' onblur="return Valida_Telefone(this)" onkeyup="return Formata_Telefone(this,event)"';

    return objTexto($campo, $nome, $valida, $size, $maxlength, $js);
}

function objEmail($campo, $nome, $valida, $size, $maxlength = '', $mostraemail = '', $jst = '') {
    $js = "onBlur = 'Valida_Email(this)'";
    if ($mostraemail != '') {
        if ($jst == '') {
            $js .= $mostraemail;
        } else {
            $js .= $mostraemail . '  ' . $jst;
        }
    }
    // p($js);
    return objTexto($campo, $nome, $valida, $size, $maxlength, $js);
}

function objURL($campo, $nome, $valida, $size, $maxlength = '', $removeHTTP = true) {
    if ($removeHTTP) {
        $js = "onBlur = 'Valida_Url(this)'";
    } else {
        $js = '';
    }

    return objTexto($campo, $nome, $valida, $size, $maxlength, $js);
}

function objData($campo, $nome, $valida, $js = '', $vl_padrao = '', $datepicker = '', $vetpicker = Array()) {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'Data';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = true;
    $vet['campo_tabela'] = true;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;

    $vet['js'] = $js;
    $vet['vl_padrao'] = $vl_padrao;
    $vet['datepicker'] = $datepicker;
    $vet['vetpicker'] = $vetpicker;

    return $vet;
}

function objDataHora($campo, $nome, $valida, $js = '', $vl_padrao = '', $datepicker = '', $vetpicker = Array()) {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'DataHora';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = true;
    $vet['campo_tabela'] = true;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;

    $vet['js'] = $js;
    $vet['vl_padrao'] = $vl_padrao;
    $vet['datepicker'] = $datepicker;
    $vet['vetpicker'] = $vetpicker;

    return $vet;
}

function objSenha($campo, $nome, $valida, $size, $maxlength = '', $js = '', $campo_tabela = true) {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'Senha';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = true;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;

    $vet['size'] = $size;
    $vet['maxlength'] = ($maxlength == '' ? $size : $maxlength);
    $vet['js'] = $js;

    return $vet;
}

function objRadio($campo, $nome, $valida, $vetor, $vl_padrao = '', $js = '', $fixo = 'N', $separacao = '&nbsp;&nbsp;&nbsp;&nbsp;') {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'Radio';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = false;
    $vet['campo_tabela'] = true;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;

    $vet['vetor'] = $vetor;
    $vet['vl_padrao'] = $vl_padrao;
    $vet['js'] = $js;
    $vet['fixo'] = $fixo;
    $vet['separacao'] = $separacao;

    return $vet;
}

function objCmbVetor($campo, $nome, $valida, $vetor, $linhafixa = ' ', $js = '', $style = '', $campo_tabela = true, $vl_padrao = '') {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'cmbVetor';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = true;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;

    $vet['vetor'] = $vetor;
    $vet['linhafixa'] = $linhafixa;
    $vet['js'] = $js;
    $vet['style'] = $style;
    $vet['vl_padrao'] = $vl_padrao;

    return $vet;
}

function objFixoVetor($campo, $nome, $valida, $vetor, $linhafixa = ' ', $num_id = '', $style = '', $js = '', $vl_padrao = '') {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'FixoVetor';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = false;
    $vet['campo_tabela'] = true;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;

    $vet['vetor'] = $vetor;
    $vet['linhafixa'] = $linhafixa;
    $vet['num_id'] = $num_id;
    $vet['js'] = $js;
    $vet['style'] = $style;
    $vet['vl_padrao'] = $vl_padrao;


    return $vet;
}

function objCmbBanco($campo, $nome, $valida, $sql, $linhafixa = ' ', $style = '', $js = '', $campo_tabela = true, $vl_padrao = '', $optgroup = false, $msg_sem_registro = 'Não existe informação no sistema', $vetParametros = Array()) {
    global $tabela;

    $vet = Array();

    $vetPadrao = Array(
        'input_data' => Array(), //Informação para ser colocado no input no attr data
    );

    if (is_array($vetParametros)) {
        foreach ($vetParametros as $key => $value) {
            $vetPadrao[$key] = $value;
        }
    }

    $vet['tipo'] = 'cmbBanco';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = true;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;

    $vet['sql'] = $sql;
    $vet['linhafixa'] = $linhafixa;
    $vet['js'] = $js;
    $vet['style'] = $style;
    $vet['vl_padrao'] = $vl_padrao;
    $vet['optgroup'] = $optgroup;
    $vet['msg_sem_registro'] = $msg_sem_registro;
    $vet['vetParametros'] = $vetPadrao;

    return $vet;
}

function objFixoBanco($campo, $nome, $tabela_obj, $id, $desc, $num_id = '', $campo_tabela = true, $linhafixa = '', $valida = false) {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'FixoBanco';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = false;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;

    $vet['tabela_obj'] = $tabela_obj;
    $vet['id'] = $id;
    $vet['num_id'] = $num_id;
    $vet['desc'] = $desc;
    $vet['linhafixa'] = $linhafixa;

    return $vet;
}

function objLista($campo, $valida, $des_lst_1, $nm_lst_1, $sql_lst_1, $tabela_relacionamento, $larg_lst_1, $des_lst_2, $nm_lst_2, $sql_lst_2, $larg_lst_2 = '', $num_linhas = '', $exc_tabela = '', $exc_campo = '', $idt_cadastro = '') {
    /*
      informar os campos abaixos se quiser que na hora de excluir seja verificado se o registro
      esta cadastrado em outra tabela
      $exc_tabela = informar o nome da tabela
      $exc_campo = nome do campo
     */
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'Lista';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 2;
    $vet['focus'] = false;
    $vet['campo_tabela'] = false;
    $vet['campo'] = $campo;
    $vet['nome'] = $des_lst_2;
    $vet['valida'] = $valida;

    $vet['des_lst_1'] = $des_lst_1;
    $vet['nm_lst_1'] = $nm_lst_1;
    $vet['sql_lst_1'] = $sql_lst_1;
    $vet['tabela_relacionamento'] = $tabela_relacionamento;
    $vet['larg_lst_1'] = $larg_lst_1;
    $vet['des_lst_2'] = $des_lst_2;
    $vet['nm_lst_2'] = $nm_lst_2;
    $vet['sql_lst_2'] = $sql_lst_2;
    $vet['larg_lst_2'] = ($larg_lst_2 == '' ? $larg_lst_1 : $larg_lst_2);
    $vet['num_linhas'] = $num_linhas;
    $vet['exc_tabela'] = $exc_tabela;
    $vet['exc_campo'] = $exc_campo;
    $vet['idt_cadastro'] = $idt_cadastro;

    return $vet;
}

function objInclude($campo, $arquivo_html, $vetVariavel = Array()) {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'Include';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 2;
    $vet['focus'] = false;
    $vet['campo_tabela'] = false;
    $vet['campo'] = $campo;
    $vet['arquivo_html'] = $arquivo_html;
    $vet['vetVariavel'] = $vetVariavel;

    return $vet;
}

function objHidden($campo, $vl_padrao, $nome = '', $desc = '', $campo_tabela = true, $mudar_vl_padrao = false) {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'Hidden';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = false;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo'] = $campo;
    $vet['vl_padrao'] = $vl_padrao;
    $vet['valida'] = false;
    $vet['nome'] = $nome;
    $vet['desc'] = $desc;
    $vet['mudar_vl_padrao'] = $mudar_vl_padrao;

    return $vet;
}

function objHiddenSql($campo, $tabela_obj, $id, $desc, $num_id = '', $campo_tabela = true) {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'HiddenSql';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = false;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo'] = $campo;
    $vet['valida'] = false;

    $vet['tabela_obj'] = $tabela_obj;
    $vet['id'] = $id;
    $vet['num_id'] = $num_id;
    $vet['desc'] = $desc;

    return $vet;
}

function objCheckbox($campo, $nome, $valor_marcado, $valor_desmarcado, $descricao, $campo_tabela = true, $valor_registro = '', $complemento_tag = '', $focus = true) {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'Checkbox';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = $focus;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = false;

    $vet['valor_marcado'] = $valor_marcado;
    $vet['valor_desmarcado'] = $valor_desmarcado;
    $vet['valor_registro'] = $valor_registro;
    $vet['descricao'] = $descricao;
    $vet['complemento_tag'] = $complemento_tag;

    return $vet;
}

function objHtml($campo, $nome, $valida, $altura = '320', $largura = '', $js = '', $barra_aberto = false, $barra_simples = false, $campo_fixo = false, $vl_padrao = '', $campo_tabela = true) {
    global $tabela;

    //$campo_fixo
    //false -> Como é Mostrado com o padrao da ação
    //true -> Vai ser mostrado desabilitado
    //Aberto -> Vai ser mostrado aberto para edição
    
    $vet = Array();

    $vet['tipo'] = 'Html';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = false;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;
    $vet['altura'] = $altura;
    $vet['largura'] = $largura;
    $vet['js'] = $js;
    $vet['barra_aberto'] = $barra_aberto;
    $vet['barra_simples'] = $barra_simples;
    $vet['campo_fixo'] = $campo_fixo;
    $vet['vl_padrao'] = $vl_padrao;

    return $vet;
}

function objAutoNum($campo, $nome, $size, $mostra = true, $zeroesq = '', $prefixo = '') {
    global $tabela;

    $vet = Array();

    if ($zeroesq == '') {
        $zeroesq = $size;
    }

    $vet['tipo'] = 'AutoNum';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = false;
    $vet['campo_tabela'] = true;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = false;

    $vet['size'] = $size;
    $vet['mostra'] = $mostra;
    $vet['zeroesq'] = $zeroesq;
    $vet['prefixo'] = $prefixo;

    return $vet;
}

function objFile($campo, $nome, $valida, $size, $grupo, $largura = '', $altura = '', $max_tamanho = 0, $js = '', $descricao = '', $class_descricao = '', $validaMime = false) {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'File';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = true;
    $vet['campo_tabela'] = true;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;
    $vet['remove'] = $valida;

    $vet['size'] = $size;
    $vet['grupo'] = strtolower($grupo);
    $vet['largura'] = $largura;
    $vet['altura'] = $altura;
    $vet['max_tamanho'] = $max_tamanho;
    $vet['js'] = $js;
    $vet['descricao'] = $descricao;
    $vet['class_descricao'] = $class_descricao;
    $vet['validaMime'] = $validaMime;

    return $vet;
}

function objFileFixo($campo, $nome) {
    global $tabela;

    $vet = Array();

    $vet['tipo'] = 'FileFixo';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = true;
    $vet['campo_tabela'] = true;
    $vet['campo'] = $campo;
    $vet['nome'] = $nome;
    $vet['valida'] = false;

    return $vet;
}

function objListarConf($campo, $idCampo, $vetCampo, $sql, $titulo, $valida, $vetParametros = Array(), $menu = '') {
    global $tabela;

    $vet = Array();

    $vetPadrao = Array(
        'num_col_tab' => '1',
        'corimp' => '#FFFFFF',
        'corpar' => '#F2F2F2',
        'corcur' => '#808080',
        'corover' => '#FF8080',
        'barra_inc' => 'Incluir',
        'barra_alt' => 'Alterar',
        'barra_con' => 'Consultar',
        'barra_exc' => 'Excluir',
        'barra_inc_h' => 'Incluir um Novo Registro',
        'barra_alt_h' => 'Alterar o Registro',
        'barra_con_h' => 'Consultar o Registro',
        'barra_exc_h' => 'Excluir o Registro',
        'barra_inc_ap' => true,
        'barra_alt_ap' => true,
        'barra_con_ap' => true,
        'barra_exc_ap' => true,
        'barra_inc_img' => 'imagens/incluir_16.png',
        'barra_alt_img' => 'imagens/alterar_16.png',
        'barra_con_img' => 'imagens/consultar_16.png',
        'barra_exc_img' => 'imagens/excluir_16.png',
        'ctlinha' => 'background:#DFDFFF;',
        'comcontrole' => 1,
        'uppertxtcab' => 0,
        'cliquenalinha' => 0,
        'clique_hint_linha' => '',
        'contlinfim' => 'Linhas: #qt',
        'extra_pagina' => true,
        'vetBtOrdem' => Array(),
        'lista_td_acao_click' => 'lista_td_acao_click',
        'lista_td_cab_acao_click' => 'lista_td_cab_acao_click',
        'campo_hidden_row' => '',
        'campo_hidden_form' => Array(),
        'campo_linha_cor' => '',
        'barra_inc_ap_muda_vl' => true,
        'barra_alt_ap_muda_vl' => true,
        'barra_exc_ap_muda_vl' => true,
        'bt_inc_menu' => '',
        'menu_acesso' => $campo,
        'func_trata_rs' => '',
        'func_trata_row' => '',
        'iframe' => false,
        'func_botao_per' => '', //função para a criação do bt personalizado
        'barra_icone' => false, //Quando informado a largura completa a barra de icone com o espaço vazio se não tiver o direito
        'idCadPer' => '', //ID do Pai personalizado
        'input_data' => Array(), //Informação para ser colocado no input hidden no attr data
        'global' => Array(), //Informação global para as funções
        'mostra_tabela' => false, //Força mostrar a tabela no incluir do registro
    );

    if (is_array($vetParametros)) {
        foreach ($vetParametros as $key => $value) {
            $vetPadrao[$key] = $value;
        }
    }

    if ($vetPadrao['barra_icone'] === true) {
        $vetPadrao['barra_icone'] = 20;
    }

    if ($menu == '') {
        $menu = $campo;
    }

    $vet['tipo'] = 'ListarConf';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 2;
    $vet['focus'] = false;
    $vet['campo_tabela'] = false;
    $vet['campo'] = $campo;
    $vet['valida'] = $valida;
    $vet['idCampo'] = $idCampo;
    $vet['vetCampo'] = $vetCampo;
    $vet['sql'] = $sql;
    $vet['titulo'] = $titulo;
    $vet['vetParametros'] = $vetPadrao;
    $vet['menu'] = $menu;

    return $vet;
}

function objListarCmb($campo, $arq_cmb, $nome, $valida, $width = '300px', $titulo_tela = '', $campo_tabela = true, $mostra_bt = true, $prefixo_where = '') {
    global $tabela;

    $vet = Array();

    if ($titulo_tela == '') {
        $titulo_tela = $nome;
    }

    $vet['tipo'] = 'ListarCmb';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = true;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo'] = $campo;
    $vet['arq_cmb'] = $arq_cmb;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;

    $vet['width'] = $width;
    $vet['titulo_tela'] = $titulo_tela;
    $vet['mostra_bt'] = $mostra_bt;
    $vet['prefixo_where'] = $prefixo_where;

    return $vet;
}

function objListarCmbMulti($campo, $arq_cmb, $nome, $valida, $tabela_relacionamento, $idt_tabela_relacionamento, $idt_relacionamento, $vetRetorno, $vetParametros = Array(), $titulo_tela = '') {
    global $tabela;

    $vet = Array();

    $vetPadrao = Array(
        'qtd_seleciona' => 0,
        'where' => '',
    );

    if (is_array($vetParametros)) {
        foreach ($vetParametros as $key => $value) {
            $vetPadrao[$key] = $value;
        }
    }

    if ($titulo_tela == '') {
        $titulo_tela = $nome;
    }

    $vet['tipo'] = 'ListarCmbMulti';
    $vet['tabela'] = $tabela;
    $vet['coluna'] = 1;
    $vet['linha'] = 1;
    $vet['focus'] = false;
    $vet['campo_tabela'] = false;
    $vet['campo'] = $campo;
    $vet['arq_cmb'] = $arq_cmb;
    $vet['nome'] = $nome;
    $vet['valida'] = $valida;

    $vet['tabela_relacionamento'] = $tabela_relacionamento;
    $vet['idt_tabela_relacionamento'] = $idt_tabela_relacionamento;
    $vet['idt_relacionamento'] = $idt_relacionamento;
    $vet['vet_retorno'] = $vetRetorno;
    $vet['vetParametros'] = $vetPadrao;
    $vet['titulo_tela'] = $titulo_tela;
    $vet['session_cod'] = GerarStr();

    $_SESSION[CS]['objListarCmbMulti'][$vet['session_cod']] = Array(
        'vet_retorno' => $vetRetorno,
        'sel_final' => Array(),
        'sel_trab' => Array(),
    );

    return $vet;
}

function MesclarCadastro($cadastro_conf, $idtVinculo, &$vetCadGeral, $vetParametrosMC = Array(), $idxMesclarCadastro = '', $soConsulta = false, $includeCssPadrao = true) {
    global $tabela, $vetMesclarCadastro, $vetDesativa, $vetAtivadoObr, $acao, $prefixo, $menu, $debug;

    if ($idxMesclarCadastro == '') {
        $idxMesclarCadastro = $cadastro_conf;
    }

    $MesclarCadastro = true;
    $CRIAvetMesclarCadastro = true;

    $tabela_org = $tabela;
    $getOrg = $_GET;
    $requestOrg = $_REQUEST;

    $path = 'cadastro_conf/' . $cadastro_conf . '.php';

    if (file_exists($path)) {
        $vetMesclarCadastro[$idxMesclarCadastro] = Array(
            'soConsulta' => $soConsulta,
            'idtVinculo' => $idtVinculo,
        );

        require('definicao_vetor.php');
        require('definicao_vetor_grc.php');

        if (file_exists(lib_path . 'funcao/definicao_vetor_lib.php')) {
            require(lib_path . 'funcao/definicao_vetor_lib.php');
        }

        if ($includeCssPadrao) {
            if (file_exists('incpadrao_ficha_sebrae.php')) {
                require('incpadrao_ficha_sebrae.php');
            }
        }

        $_SESSION[CS]['tmp'][CSU]['vetParametrosMC'] = $vetParametrosMC;
        require($path);
        unset($_SESSION[CS]['tmp'][CSU]['vetParametrosMC']);

        if ($CRIAvetMesclarCadastro) {
            $vetMesclarCadastro[$idxMesclarCadastro] = Array(
                'soConsulta' => $soConsulta,
                'idtVinculo' => $idtVinculo,
                'tabela' => $tabela,
                'id' => $id,
            );
        }

        $vetCadGeral = array_merge($vetCadGeral, $vetCad);
    }

    $tabela = $tabela_org;
    $_GET = $getOrg;
    $_REQUEST = $requestOrg;

    return $vetCad;
}

function MesclarCol(&$vet, $coluna) {
    $vet['coluna'] = $coluna;
}

function Frame($nome, $dados, $class_frame = '', $class_titulo = '', $titulo_na_linha = true, $vetParametros = Array()) {
    $vet = Array();

    $vetPadrao = Array(
        'codigo_frm' => '',
        'codigo_pai' => '',
        'width' => '',
        'align' => 'center',
        'espaco_img_size' => 15,
        'controle_fecha' => false, //false: sem controle | A: Aberto | F: Fechado
        'bt_img_abre' => 'imagens/seta_baixo.png',
        'bt_img_fecha' => 'imagens/seta_cima.png',
        'bt_titulo' => '',
        'situacao_padrao' => false, //false: não mostra | true: mostra
        'situacao_padrao_img' => 'imagens/bt_reload.png',
        'situacao_padrao_titulo' => '',
        'situacao_padrao_abre' => '', //false: não mostra | true: mostra
        'situacao_padrao_abre_img' => 'imagens/bt_mais.png',
        'situacao_padrao_abre_titulo' => '',
        'situacao_padrao_fecha' => '', //false: não mostra | true: mostra
        'situacao_padrao_fecha_img' => 'imagens/bt_menos.png',
        'situacao_padrao_fecha_titulo' => '',
    );

    if (is_array($vetParametros)) {
        foreach ($vetParametros as $key => $value) {
            $vetPadrao[$key] = $value;
        }
    }

    $vetParametrosMC = $_SESSION[CS]['tmp'][CSU]['vetParametrosMC'];

    if (is_array($vetParametrosMC)) {
        foreach ($vetParametrosMC as $key => $value) {
            $vetPadrao[$key] = $value;
        }
    }

    if ($vetPadrao['situacao_padrao_abre'] === '') {
        $vetPadrao['situacao_padrao_abre'] = $vetPadrao['situacao_padrao'];
    }

    if ($vetPadrao['situacao_padrao_fecha'] === '') {
        $vetPadrao['situacao_padrao_fecha'] = $vetPadrao['situacao_padrao'];
    }

    $vet['nome'] = $nome;
    $vet['dados'] = $dados;
    $vet['class_frame'] = $class_frame;
    $vet['class_titulo'] = $class_titulo;
    $vet['titulo_na_linha'] = $titulo_na_linha;
    $vet['vetParametros'] = $vetPadrao;

    return $vet;
}

function lstExtra($origem, $destino = '') {
    $vet = Array();

    $vet['origem'] = $origem;
    $vet['destino'] = $destino == '' ? $origem : $destino;

    return $vet;
}

function vetRetorno($campo, $sql_campo = '', $mostra = true, $campo_tabela = true, $campo_pk = false) {
    $vet = Array();

    if ($sql_campo == '') {
        $sql_campo = $campo;
    }

    $vet['campo'] = $campo;
    $vet['sql_campo'] = $sql_campo;
    $vet['mostra'] = $mostra;
    $vet['campo_tabela'] = $campo_tabela;
    $vet['campo_pk'] = $campo_pk;

    return $vet;
}
