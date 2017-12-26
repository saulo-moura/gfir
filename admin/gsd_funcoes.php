<?php
define('HOST_PADRAO', 'localhost');

function downloadFile( $fullPath ){

  // Must be fresh start
  if( headers_sent() )
    die('Headers Sent');

  // Required for some browsers
  if(ini_get('zlib.output_compression'))
    ini_set('zlib.output_compression', 'Off');

  // File Exists?
  if( file_exists($fullPath) ){

    // Parse Info / Get Extension
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = mb_strtolower($path_parts["extension"]);

    // Determine Content Type
    switch ($ext) {
      case "pdf": $ctype="application/pdf"; break;
      case "exe": $ctype="application/octet-stream"; break;
      case "zip": $ctype="application/zip"; break;
      case "doc": $ctype="application/msword"; break;
      case "xls": $ctype="application/vnd.ms-excel"; break;
      case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
      case "gif": $ctype="image/gif"; break;
      case "png": $ctype="image/png"; break;
      case "jpeg":
      case "jpg": $ctype="image/jpg"; break;
      default: $ctype="application/force-download";
    }

    header("Pragma: public"); // required
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false); // required for certain browsers
    header("Content-Type: $ctype");
    header("Content-Disposition: attachment; filename=\"".basename($fullPath)."\";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".$fsize);
    ob_clean();
    flush();
    readfile( $fullPath );

  } else
    die('File Not Found');

}




function propriedades_arquivo( $fullPath )
{

  $vet_p=Array();
  // File Exists?
  $fullPathw=($fullPath);
  if( file_exists($fullPathw) )
 // if( file_get_contents($fullPathw)!== NULL )
  {
    // Parse Info / Get Extension
    $fsize      = filesize($fullPathw);
    $path_parts = pathinfo($fullPathw);
    $ext        = mb_strtolower($path_parts["extension"]);
    $vet_p['tam']=$fsize;
    $vet_p['ext']=$ext;
    $vet_p['dir']=$path_parts['dirname'];
    $vet_p['arq']=$path_parts['basename'];
    $vet_p['fil']=$path_parts['filename'];
    // Determine Content Type
    switch ($ext) {
      case "pdf":
       $ctype="application/pdf";
       $app="Adobe Reader";
       break;
      case "exe":
       $ctype="application/octet-stream";
       $app="Código executável";
       break;
      case "zip":
       $ctype="application/zip";
       $app="WinZip";
       break;
      case "docx":
      case "doc":
       $ctype="application/msword";
       $app="Microsoft Word";
       break;
      case "xlsx":
      case "xls":
       $ctype="application/vnd.ms-excel";
       $app="Microsoft Excel";
       break;
      case "ppt":
       $ctype="application/vnd.ms-powerpoint";
       $app="Microsoft Power Pointe";
       break;
      case "gif":
       $ctype="image/gif";
       $app="Imagem tipo GIF";
       break;
      case "png":
       $ctype="image/png";
       $app="Imagem tipo PNG";
       break;
      case "jpeg":
      case "jpg":
       $ctype="image/jpg";
       $app="Imagem tipo JPG";
       break;
      default:
       $ctype="application/force-download";
       $app="Aplicação Desconhecida";
    }
    $vet_p['tip']=$ctype;
    $vet_p['app']=$app;
  }
  else
  {
    //die('File Not Found');
    $vet_p['err']='Arquivo não encontrado '.$fullPath;
    $vet_p['tam']=0;
  }
  return  $vet_p;
}

function zip_arq($fullPath,&$vet_zip)
{
    $kokw=0;
    $vet_zipw = Array();
    $vet_p    = propriedades_arquivo( $fullPath );
    $zip      = new ZipArchive();
    
    $filename = $vet_p['dir'].'/'.$vet_p['fil'].".zip";
 //   p($filename);
    if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE)
    {
        //exit("cannot open <$filename>\n");
        return $kokw;
    }

   // $zip->addFromString("testfilephp.txt" . time(), "#1 This is a test string added as testfilephp.txt.\n");
   // $zip->addFromString("testfilephp2.txt" . time(), "#2 This is a test string added as testfilephp2.txt.\n");
    $zip->addFile($fullPath);
    $vet_zipw['numfiles'] = $zip->numFiles;
    $vet_zipw['status']   = $zip->status;
    $zip->close();
    $vet_zip = $vet_zipw;
    $kokw=1;
    return $kokw;
}

function ftp_conexao($host,$porta,$usuario,$senha)
{

    $conn_id = ftp_connect($host,$porta);

    // Open a session to an external ftp site
    $login_result = ftp_login ($conn_id,$usuario,$senha);

    // Check open
    if ((!$conn_id) || (!$login_result))
    {
        // echo "Ftp-connect failed!";
         return null;
    }
    else
    {
       // echo "Connected.";
    }
    // turn on passive mode transfers
    ftp_pasv ($conn_id, true) ;

    return $conn_id;
}

class TGSD_FTP
{
    private $host         ='';
    private $porta        = '';
    private $usuario      = '';
    private $senha        = '';
    private $conn_id      = null;
    private $login_result = null;
    private $diretorio    = null;

    public function __construct($host,$porta,$usuario,$senha)
    {
        $this -> host         = $host;
        $this -> porta        = $porta;
        $this -> usuario      = $usuario;
        $this -> senha        = $senha;

           $this -> conn_id = ftp_connect($host,$porta);

           // Open a session to an external ftp site
           $this -> login_result = ftp_login ($this -> conn_id,$usuario,$senha);

           // Check open
           if ((!$this -> conn_id) || (!$this -> login_result))
           {
            //  echo "Ftp-connect failed!";
              //return null;
              $this -> conn_id = null;
           }
           else
           {
          //    echo "Connected.";
              // turn on passive mode transfers
              ftp_pasv ($this -> conn_id, true) ;
           }
    }
    public function __destruct()
    {
        ftp_close($this -> conn_id);
    }
    public function conexao()
    {
        return $this -> conn_id;
    }

    public function dir()
    {
            // get contents of the current directory
        $this -> diretorio = ftp_nlist($this -> conn_id, ".");

        return $this -> diretorio ;
    }

}