<?php
$htmlvw="";
if ($identificacao!="")
{
	$htmlvw=FunilHistoricoNotas($identificacao);
}
else
{
	$htmlvw="";
}
echo $htmlvw;
?>
<script>
    $(document).ready(function () {
        
    });
</script>