<!-- <lupe> <objeto> Inicio do Objeto -->
<?php
/* <lupe> <objeto>
  Documenta��o
</lupe> */ 
?>
<!-- <lupe> <estilo>  Defini��o dos estilos para HTML -->
<style>
</style>
<!-- <lupe> <raiz>  Defini��o Processos Servidor e Gera��o HTML -->
<?php
/* <lupe> <raiz>
  Documenta��o
</lupe> */ 
$tabela = 'grc_evento_status';
$id     = 'idt';
$vetFrm = Array();
// Se��o 1
$vetCampo['codigo']    = objTexto('codigo', 'C�digo', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descri��o', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
$vetFrm[] = Frame('<span>Identifica��o</span>', Array(
   Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);
// Se��o 2
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);
// Carrega tabela Tela
$vetCad[] = $vetFrm;
?>
<!-- <lupe> <script>  Defini��o processos Cliente -->
<script>
/* <lupe> <cliente> 
  Documenta��o
</lupe> */ 
</script>
