<?php
$tabela = 'grc_evento_natureza_pagamento';
$id = 'idt';

$par = 'rm_idformapagto,grc_evento_natureza_pagamento_instrumento';
$vetDesativa['desconto'][0] = vetDesativa($par, ',S');
$vetAtivadoObr['desconto'][0] = vetAtivadoObr($par, 'N');

$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
$vetCampo['desconto'] = objCmbVetor('desconto', 'Desconto?', True, $vetSimNao);

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['ativo'], '', $vetCampo['desconto']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCampo['rm_idformapagto'] = objInteiro('rm_idformapagto', 'idformapagto do RM', false, 10);
$vetCampo['lojasiac_modalidade'] = objInteiro('lojasiac_modalidade', 'Código da Modalidade no SiacWeb', false, 10);

$vetFrm[] = Frame('<span>Dados de outros sistemas</span>', Array(
    Array($vetCampo['rm_idformapagto'], '', $vetCampo['lojasiac_modalidade']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$maxlength = 1000;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$titulo = 'Instrumento';

$vetCampoLC = Array();
$vetCampoLC['instrumento'] = CriaVetTabela('Instrumento');
$vetCampoLC['qtd_limite'] = CriaVetTabela('Qtd. Limite');

$sql = "select p.*, i.descricao as instrumento ";
$sql .= " from grc_evento_natureza_pagamento_instrumento p";
$sql .= " inner join grc_atendimento_instrumento i on i.idt = p.idt_atendimento_instrumento";
$sql .= ' where p.idt_evento_natureza_pagamento = $vlID';
$sql .= " order by i.descricao";

$vetCampo['grc_evento_natureza_pagamento_instrumento'] = objListarConf('grc_evento_natureza_pagamento_instrumento', 'idt', $vetCampoLC, $sql, $titulo, false);

$vetFrm[] = Frame('<span>Instrumento que utiliza esta natureza de pagamento</span>', Array(
    Array($vetCampo['grc_evento_natureza_pagamento_instrumento']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
