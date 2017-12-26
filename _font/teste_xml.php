<html>

<body>


<?php
function p($valor) {
    echo '<pre>';
    print_r($valor);
    echo '</pre>';
}


//<span datasrc="#xmldso" datafld="cpf"></span>
echo '<span datasrc="#xmldso" datafld="cpf" ></span>';



$xml=simplexml_load_file("teste.xml");
$html  = "";
$html .= "<div>";
$primeiro=1;
ForEach ($xml as $tabela => $ObjetoTabela) {
		$html .= "<table class='' width='100%' border='1' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
		if ($primeiro==1)
		{
		    $primeiro=0;
			ForEach ($ObjetoTabela as $linha => $ObjetoLinha) {
				$html .= "<tr>";
				ForEach ($ObjetoLinha as $campo => $Valor) {
					$html .= "<td style='background:#0000FF; color:#FFFFFF; ' >";
					$html .= "$campo";
					$html .= "</td>";
				}
				$html .= "</tr>";
				break;
			}
        }
	   
	   ForEach ($ObjetoTabela as $linha => $ObjetoLinha) {
		  $html .= "<tr>";
		  ForEach ($ObjetoLinha as $campo => $Valor) {
		     $html .= "<td>";
			 $html .= "$Valor";
			 $html .= "</td>";
          }
		  $html .= "</tr>";
       }
	   $html .= "</table>";

}
$html .= "</div>";        
echo $html;

?>

<iframe src="teste.xml" width="370" height="320"></iframe></td><td>&nbsp;</td><td><iframe src="teste_xml.php" width="370" height="320"></iframe>

</body>
</html>