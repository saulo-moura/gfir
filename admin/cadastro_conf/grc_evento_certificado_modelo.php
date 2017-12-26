<?php
$tabela = 'grc_evento_certificado_modelo';
$id = 'idt';

$bt_exportar = true;
$bt_exportar_desc = 'Preview do Certificado';

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_atendimento_instrumento';
$sql .= " where idt in (2, 40, 41, 45, 46, 47, 48, 49, 50)";
$sql .= ' order by descricao';
$vetCampo['idt_instrumento'] = objCmbBanco('idt_instrumento', 'Instrumento', false, $sql, '<< Todos >>');

$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 100);
$vetCampo['html_corpo'] = objHTML('html_corpo', 'Corpo do PDF', true, 320, 950);
$vetCampo['html_header'] = objHTML('html_header', 'Cabeçalho do PDF', false, 320, 950);
$vetCampo['html_footer'] = objHTML('html_footer', 'Rodapé do PDF', false, 320, 950);

$vetCampo['mpdf_me'] = objInteiro('mpdf_me', 'Margem Esquerda', True, 4, 4, 5);
$vetCampo['mpdf_md'] = objInteiro('mpdf_md', 'Margem Direita', True, 4, 4, 5);
$vetCampo['mpdf_ms'] = objInteiro('mpdf_ms', 'Margem Superior', True, 4, 4, 30);
$vetCampo['mpdf_mb'] = objInteiro('mpdf_mb', 'Margem Inferior', True, 4, 4, 7);
$vetCampo['mpdf_mh'] = objInteiro('mpdf_mh', 'Margem Cabeçalho', True, 4, 4, 3);
$vetCampo['mpdf_mf'] = objInteiro('mpdf_mf', 'Margem Rodapé', True, 4, 4, 5);
$vetCampo['mpdf_papel_orientacao'] = objCmbVetor('mpdf_papel_orientacao', 'Orientação do Papel', True, $vetPapelOrientacao, '');

$vetCampo['grc_evento_certificado_modelo_parametro'] = objInclude('grc_evento_certificado_modelo_parametro', 'cadastro_conf/grc_evento_certificado_modelo_parametro.php');

MesclarCol($vetCampo['idt_instrumento'], 13);
MesclarCol($vetCampo['descricao'], 13);
MesclarCol($vetCampo['grc_evento_certificado_modelo_parametro'], 13);
MesclarCol($vetCampo['html_corpo'], 13);
MesclarCol($vetCampo['html_header'], 13);
MesclarCol($vetCampo['html_footer'], 13);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_instrumento']),
    Array($vetCampo['descricao']),
    Array($vetCampo['mpdf_papel_orientacao'], '', $vetCampo['mpdf_me'], '', $vetCampo['mpdf_md'], '', $vetCampo['mpdf_ms'], '', $vetCampo['mpdf_mb'], '', $vetCampo['mpdf_mh'], '', $vetCampo['mpdf_mf']),
    Array($vetCampo['grc_evento_certificado_modelo_parametro']),
    Array($vetCampo['html_corpo']),
    Array($vetCampo['html_header']),
    Array($vetCampo['html_footer']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
