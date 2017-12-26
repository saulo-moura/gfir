<style>
.empresas_pessoa {
    background:#F1F1F1;
	color:#000000;
    border-top:1px solid #FF0000;	
	border-bottom:1px solid #FF0000;
    display:none;	
}
.empresas_pessoa_titulo {
    background:#0000FF;
	color:#FFFFFF;
    border-top:1px solid #0000FF;	
	border-bottom:1px solid #0000FF;
    text-align:center;
    font-size:18px;	
	cursor:pointer;
}
.empresas_pessoa_det {
    background:#FFFFFF;
	color:#000000;
	border-bottom:1px solid #0000FF;
    font-size:18px;	
	display:none;	
}
</style> 
<?php
$onclick = " onclick='return EscondeEmp();'";
$html .= "";
$html .= "<div id='empresas_pessoa' class='empresas_pessoa'>";

$hint  =" Clique para esconder essa seção do formulário";
$html .= "<div title='{$hint}' {$onclick} class='empresas_pessoa_titulo'>";
$html .= " EMPRESAS ASSOCIADAS AO CLIENTE </div>";
$html .= "</div>";

$html .= "<div id='empresas_pessoa_det' class='empresas_pessoa_det'>";
$html .= " detalhe das empresas associadas";
$html .= "</div>";

$html .= "</div>";
//
echo $html;
?>
<script>

//var idt_atendimento_agenda  =  '<?php echo  $idt_atendimento_agenda; ?>' ;

$(document).ready(function () {

});
function EscondeEmp()
{
    var id='empresas_pessoa';
	obj = document.getElementById(id);
    if (obj != null) {
         $(obj).hide();
    }
	var id='empresas_pessoa_det';
	obj = document.getElementById(id);
    if (obj != null) {
         $(obj).hide();
    }
}	
</script>
