<?php 
$title='GUY';

      
    //XML Blurb
    $data = "<?xml version='1.0'?>
    <?mso-application progid='Excel.Sheet'?>
    <Workbook xmlns='urn:schemas-microsoft-com:office:spreadsheet' xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:x='urn:schemas-microsoft-com:office:excel' xmlns:ss='urn:schemas-microsoft-com:office:spreadsheet' xmlns:html='http://www.w3.org/TR/REC-html40'>
    <Worksheet ss:Name='".$title."'>
    <Table>
    <Row>";
     
    //Field Name Data
$count=1;
    for ($i = 1; $i <= $count; $i++)
        {
            $data .= "<Cell><Data ss:Type='String'>".'GUY'."</Data></Cell>";
        }
    $data .= "</Row>";
     
    //Row Data
//    while(odbc_fetch_row($result))
//        {
            $data .= "<Row>";
            for ($j = 1; $j <= $count; $j++)
                {
                    $data .= "<Cell><Data ss:Type='String'>".'CONTEUDO BETE'."</Data></Cell>";
                }
            $data .= "</Row>";
  //      }
     
    //Final XML Blurb
    

    $data .= "</Table></Worksheet>";

    $title = 'ALICE' ;

    $data .= "<Worksheet ss:Name='".$title."'>";
    $data .= "<Table>";
    $data .= "<Row>";

    //Field Name Data
$count=1;
    for ($i = 1; $i <= $count; $i++)
        {
            $data .= "<Cell><Data ss:Type='String'>".'mariana'."</Data></Cell>";
        }
    $data .= "</Row>";
     
    //Row Data
//    while(odbc_fetch_row($result))
//        {
            $data .= "<Row>";
            for ($j = 1; $j <= $count; $j++)
                {
                    $data .= "<Cell><Data ss:Type='String'>".'CONTEUDO TOMAS'."</Data></Cell>";
                }
            $data .= "</Row>";
  //      }
     
    //Final XML Blurb
   // $data .= "</Row>";
   $data .= "</Table></Worksheet>";

   $data .= "</Workbook>";

       

  header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$title.xls;");
    header("Content-Type: application/ms-excel");
    header("Pragma: no-cache");
    header("Expires: 0");
     
    echo $data;
     
  //odbc_close($conn);
     
?>     