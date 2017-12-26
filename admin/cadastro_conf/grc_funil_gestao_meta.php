<?php






$vetRetorno=Array();
$ano_atual=Funil_parametro(1,$vetRetorno);
$tabela = "grc_funil_{$ano_atual}_gestao_meta";
$id = 'idt';
$js1 = " readonly='true' style='xwidth:10em; background:#E0E0E0;'";
$vetCampo['ano'] = objTexto('ano', 'Ano', false, 4, 4, $js1);
$vetCampo['cnpj'] = objTexto('cnpj', 'CNPJ', false, 45, 45, $js1);
$vetCampo['razao_social'] = objTexto('razao_social', 'Razão Social', false, 40, 120, $js1);
$vetCampo['cpf'] = objTexto('cpf', 'CPF', false, 45, 45, $js1);
$vetCampo['nome_cliente'] = objTexto('nome_cliente', 'Nome Cliente', false, 40, 120, $js1);
$vetCampo['cidade'] = objTexto('cidade', 'Cidade', false, 40, 120, $js1);
$vetCampo['regional_da_jurisdicao'] = objTexto('regional_da_jurisdicao', 'Regional da Jurisdição', false, 40, 120, $js1);
$vetCampo['escritorio_de_atendimento'] = objTexto('escritorio_de_atendimento', 'Ponto de Atendimento', false, 40, 120, $js1);
$vetCampo['tiporealizacao'] = objTexto('tiporealizacao', 'Tipo de Realização', false, 40, 120, $js1);
$vetCampo['instrumento'] = objTexto('instrumento', 'Instrumento', false, 40, 120, $js1);
$vetCampo['tipo_pessoa'] = objTexto('tipo_pessoa', 'Tipo de Pessoa', false, 40, 120, $js1);
$vetCampo['datahorainicial'] = objTexto('datahorainicial', 'Data Hora Inicial', false, 40, 120, $js1);
$vetCampo['datahorafinal'] = objTexto('datahorafinal', 'Data Hora Final', false, 40, 120, $js1);



$vetCampo['tipo_de_empreendimento'] = objTexto('tipo_de_empreendimento', 'Tipo de Empreendimento', false, 40, 120, $js1);
$vetCampo['porte'] = objTexto('porte', 'Porte', false, 40, 120, $js1);
$vetCampo['setor'] = objTexto('setor', 'Setor', false, 40, 120, $js1);
$vetCampo['atividade_economica'] = objTexto('atividade_economica', 'Atividade Econômico', false, 40, 120, $js1);

$vetCampo['meta_afetada'] = objTexto('meta_afetada', 'Metas Sensibilizadas', false, 115, 255, $js1);


$js2 = " disabled style='width:10em; background:#E0E0E0;'";
$vetCampo['meta1'] = objCmbVetor('meta1', 'Sensibilizada Meta 1?', false, $vetSimNao, ' ',$js2);
$vetCampo['meta2'] = objCmbVetor('meta2', 'Sensibilizada Meta 2?', false, $vetSimNao, ' ',$js2);
$vetCampo['meta3'] = objCmbVetor('meta3', 'Sensibilizada Meta 3?', false, $vetSimNao, ' ',$js2);
$vetCampo['meta4'] = objCmbVetor('meta4', 'Sensibilizada Meta 4?', false, $vetSimNao, ' ',$js2);
$vetCampo['meta5'] = objCmbVetor('meta5', 'Sensibilizada Meta 5?', false, $vetSimNao, ' ',$js2);
$vetCampo['meta6'] = objCmbVetor('meta6', 'Sensibilizada Meta 6?', false, $vetSimNao, ' ',$js2);
$vetCampo['meta7'] = objCmbVetor('meta7', 'Sensibilizada Meta 7?', false, $vetSimNao, ' ',$js2);
$vetCampo['meta8'] = objCmbVetor('meta8', 'Sensibilizada Meta 8?', false, $vetSimNao, ' ',$js2);
$vetCampo['meta9'] = objCmbVetor('meta9', 'Sensibilizada Meta 9?', false, $vetSimNao, ' ',$js2);
$vetFrm = Array();
MesclarCol($vetCampo['ano'], 3);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['ano']),
	Array($vetCampo['escritorio_de_atendimento'],'',$vetCampo['tipo_pessoa']),
	Array($vetCampo['regional_da_jurisdicao'],'',$vetCampo['cidade']),
    Array($vetCampo['cnpj'],'',$vetCampo['razao_social']),
	Array($vetCampo['cpf'],'',$vetCampo['nome_cliente']),
	Array($vetCampo['tiporealizacao'],'',$vetCampo['instrumento']),
	Array($vetCampo['datahorainicial'],'',$vetCampo['datahorafinal']),
	
	Array($vetCampo['tipo_de_empreendimento'],'',$vetCampo['porte']),
	Array($vetCampo['setor'],'',$vetCampo['atividade_economica']),
		
),$class_frame,$class_titulo,$titulo_na_linha);
MesclarCol($vetCampo['meta_afetada'], 11);
MesclarCol($vetCampo['meta9'], 7);

$vetFrm[] = Frame('', Array(
	Array($vetCampo['meta_afetada']),
    Array($vetCampo['meta1'],'',$vetCampo['meta2'],'',$vetCampo['meta3'],'',$vetCampo['meta4'],'',$vetCampo['meta5'],'',$vetCampo['meta6']),
	Array($vetCampo['meta7'],'',$vetCampo['meta8'],'',$vetCampo['meta9']),

),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;

/* 
// Para testar função de retorna para o cliente quais as metas sensibilizadas
$sqlt  = "";
$sqlt .= " select ";
$sqlt .= " cnpj   ";
$sqlt .= " from {$tabela}  ";
$sqlt .= " where idt = ".null($_GET['id']);
$rst   = execsqlNomeCol($sqlt);
if ($rst->rows==0)
{
	// Erro grave
}
else
{
	foreach ($rst->data as $rowt) {
		$cnpj  = $rowt['cnpj']; 
		$dap   = $rowt['dap']; 
		$nirf  = $rowt['nirf']; 
		$rmp   = $rowt['rmp']; 
		$sicab = $rowt['sicab'];
	}				
}

$vetParametros['cnpj'] = $cnpj; 
$vetParametros['dap']  = $dap;
$vetParametros['nirf'] = $nirf;
$vetParametros['rmp']  = $rmp;
$vetParametros['sicab']= $sicab;
//
FunilMetasCliente($vetParametros,$vetRetorno);
//
$vetMetas=$vetRetorno['vetMetas'];
$Meta1=$vetMetas[1];    
$Meta7=$vetMetas[7];    
echo " Meta1 = $Meta1  Meta7 = $Meta7 ";

*/

/* 
// Para testar classificação do cliente
$sqlt  = "";
$sqlt .= " select ";
$sqlt .= " cnpj   ";
$sqlt .= " from {$tabela}  ";
$sqlt .= " where idt = ".null($_GET['id']);
$rst   = execsqlNomeCol($sqlt);
if ($rst->rows==0)
{
	// Erro grave
}
else
{
	foreach ($rst->data as $rowt) {
		$cnpj  = $rowt['cnpj']; 
		$dap   = $rowt['dap']; 
		$nirf  = $rowt['nirf']; 
		$rmp   = $rowt['rmp']; 
		$sicab = $rowt['sicab'];
	}				
}

$vetParametros['cnpj'] = $cnpj; 
$vetParametros['dap']  = $dap;
$vetParametros['nirf'] = $nirf;
$vetParametros['rmp']  = $rmp;
$vetParametros['sicab']= $sicab;
//
FunilClassificarCliente($vetParametros,$vetRetorno);
//
p($vetRetorno);
*/
/*
// classificação para gerar em arquivo
$vetParametro=Array();
FunilClassificaCliente($vetParametro);
echo " ---------------------- FIM ";
*/

/*
// classificação para gerar em arquivo
$vetParametros=Array();
$vetRetorno=Array();
FunilClassificaClienteGEC($vetParametros,$vetRetorno);
p($vetRetorno);
echo " ---------------------- FIM ";
*/
/*
$vetParametros=Array();
$vetRetorno=Array();
$Parametros['idt_atendimento_pendencia']=1516;
PendenciaHistorico($Parametros,$Retorno);
p($Retorno);
*/
?>