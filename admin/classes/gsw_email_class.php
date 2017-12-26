<?php
// <INICIO DO ARQUIVO>                            //
////////////////////////////////////////////////////
//  GSW - V.1.0 - Julho 2016                      //
//  Classe de Métodos - EMAIL                     //
//  Classe deve ser Instanciada apenas uma vez para o Sistema    //
////////////////////////////////////////////////////
// <INICIO CLASSE TGSW - Trata Email>
class TGSW_EMAIL
{
	private $host     = ""; 
	private $usuario  = "";
    private $senha    = "";
	private $mbox     = "";
	private $imap     = "";
	private $box      = "";
	private $opcao    = "";
	private $vetEmail = Array();
	
	private $encoding = "";
    // 	
    public function __construct($vetEmail)
    {
		$this->host     = $vetEmail['host'];
		$this->porta    = $vetEmail['porta'];
		$this->usuario  = $vetEmail['usuario'];
		$this->senha    = $vetEmail['senha'];
		$this->opcao    = $vetEmail['opcao'];
		$this->box      = $vetEmail['box'];
		// $this->mbox     = imap_open("{".$host.":143/novalidate-cert}INBOX", $usuario, $senha)or die("can't connect: " . imap_last_error());
		
		$host    = $this->host;
		$porta   = $this->porta;
		$box     = $this->box;
		$opcao   = $this->opcao;
		$usuario = $this->usuario;
		$senha   = $this->senha;
		//$str_conexao = "{{$host}:{$porta}/imap/ssl}{$box}";
		$str_conexao = "{{$host}:{$porta}{$opcao}}{$box}";
		$this->mbox  = imap_open($str_conexao, $usuario, $senha,OP_READONLY,3);
		$this->mbox  = imap_open($str_conexao, $usuario, $senha,NULL,1);
		
		
		//$this->mbox = imap_open("{".$this->host.":{$porta}/novalidate-cert}{$box}", $usuario, $senha , NULL, 1, array('DISABLE_AUTHENTICATOR' => 'GSSAPI'))
		if (!$this->mbox)
        {		
			die("Erro de Conexão: " . imap_last_error(). $str_conexao );
		}	 
       	$this->imap=$this->mbox;	
    }
    public function __destruct()
    {
		imap_close($this->mbox);
    }
	public function LeEmail()
    {
	    if (!$this->mbox)
        {		
			// die("Erro de Conexão: " . imap_last_error(). $str_conexao );
			return $this->vetEmail;
		}
		$nummsg=imap_num_msg($this->mbox);
		for($m = 1; $m <=$nummsg ; $m++){
			// ele vai repetir esse laço enquanto houver mensagens
			$header  = imap_headerinfo($this->mbox, $m);
			$body    = imap_fetchbody ($this->mbox, $m,1.2);
			//
			$corpo   = quoted_printable_decode($body);
			$corpo   = utf8_decode(imap_utf8($corpo));
			
			$titulow = $header->subject; 
			$titulow = utf8_decode(imap_utf8($titulow));

			$titulo = quoted_printable_decode($titulow);
			
			$data   = date('d-m-Y H:i:s', strtotime($header->date));
			$numero = $header->Msgno; 
			$from   = quoted_printable_decode($header->from); 
			$this->vetEmail[]['numero'] = $numero;
			$this->vetEmail[]['from']   = $from;
			$this->vetEmail[]['titulo'] = $titulo;
			$this->vetEmail[]['data']   = $data;
			$this->vetEmail[]['corpo']  = $corpo;
			if ($m>10)
			{
			    break;
			}
		}
		return $this->vetEmail;
	}
	public function GravaEmail()
    {
	    $vetErro=Array();
	    if (!$this->mbox)
        {		
		    $vetErro[0]='Sem Conexão';
			return $vetErro;
		}
		$email = $this->usuario;
		$idt_email = "";
		$sql  = "select  ";
		$sql .= " plu_e.idt  ";
		$sql .= " from plu_email plu_e ";
		$sql .= " where plu_e.email = ".aspa($email);
		$rs = execsql($sql);
		if ($rs->rows==0)
		{
            $vetErro[1]='Sem registro de Parâmetro para email '.$email;
			return $vetErro;		
		}
		else
		{
			ForEach ($rs->data as $row) {
				$idt_email = $row['idt'];
			}	
        }
		
		
		
		$nummsg=imap_num_msg($this->mbox);
		$vetErro[500]='Quantidade de Emails: '.$nummsg;
		set_time_limit(0);
		for($mx = 1; $mx <=$nummsg ; $mx++){
		    $m = $nummsg - ($mx - 1);
		    //
			// ele vai repetir esse laço enquanto houver mensagens
			//
			$header = imap_headerinfo($this->mbox, $m);
			$body   = imap_fetchbody ($this->mbox, $m,1.2);
			//
			$corpo  = quoted_printable_decode($body);
			$corpo   = utf8_decode(imap_utf8($corpo));
			
			$titulow = $header->subject; 
			//$titulow = quoted_printable_decode($titulow);
			
			
			//$titulo  = utf8_decode(imap_utf8($titulow));
			
			
			//$titulo  = (imap_utf8($titulow));
			
			
			
			
			$data   = date('Y-m-d H:i:s', strtotime($header->date));
			$numero = $header->Msgno; 
			// $numero = $m; 
			
			
			$from   = quoted_printable_decode($header->from); 
			$this->vetEmail[]['numero'] = $numero;
			$this->vetEmail[]['from']   = $from;
			$this->vetEmail[]['titulo'] = $titulo;
			$this->vetEmail[]['data']   = $data;
			$this->vetEmail[]['corpo']  = $corpo;
			
			$withbody=true;
			$id=$numero;
			$vetBody = $this->formatMessage($id, $withbody);
			$titulo    = $vetBody['subject'];
			//$titulo    = quoted_printable_decode($titulo);
			//$titulo  = (imap_utf8($titulo));
			//$titulo    = utf8_decode(imap_utf8($titulow));
			$titulo  = (utf8_decode($titulo));
			
			$subjectww = $vetBody['subjectww'];
			$corpo     = $vetBody['body'];
			$from      = $vetBody['from'];
			
            $anexos    = $vetBody['attachments'];


			$titulot   = aspa($titulo);
			$corpot    = aspa($corpo);
			$origem    = aspa($from);
			$datahorat = aspa(($data));
			$subjectww = aspa($subjectww);
			
			// $numero    = $m; 
		
			$sql  = "select  ";
			$sql .= " plu_ec.idt  ";
			$sql .= " from plu_email_conteudo plu_ec ";
			$sql .= " where plu_ec.idt_email = ".null($idt_email);
			$sql .= "   and plu_ec.numero = ".null($numero);
			$rs   = execsql($sql);
			if  ($rs->rows==0)
			{		
			    $vetAnaliseTitulo = $this->AnalisaTitulo($titulot);
				//
			    $nossonumero      = aspa($vetAnaliseTitulo['nossonumero']);
				$seunumero        = aspa($vetAnaliseTitulo['seunumero']);
				$situacao         = aspa($vetAnaliseTitulo['situacao']);
				//
				$sql_i = ' insert into plu_email_conteudo ';
				$sql_i .= ' (  ';
				$sql_i .= " idt_email, ";
				$sql_i .= " numero, ";
				$sql_i .= " titulo, ";
				$sql_i .= " corpo, ";
				$sql_i .= " origem, ";
				$sql_i .= " nossonumero, ";
				$sql_i .= " seunumero, ";
				$sql_i .= " subjectww, ";
				$sql_i .= " situacao, ";
				$sql_i .= " datahora ";
				$sql_i .= '  ) values ( ';
				$sql_i .= " $idt_email, ";
				$sql_i .= " $numero, ";
				$sql_i .= " $titulot, ";
				$sql_i .= " $corpot, ";
				$sql_i .= " $origem, ";
				$sql_i .= " $nossonumero, ";
				$sql_i .= " $seunumero, ";
				$sql_i .= " $subjectww, ";
				$sql_i .= " $situacao, ";
				$sql_i .= " $datahorat ";
				$sql_i .= ') ';
				execsql($sql_i);
				$idt_plu_email_conteudo = lastInsertId();
			
				//
				// tratar arquivos em anexo 
				// ver quando tem vários anexos
				//
				
				ForEach ($anexos as $ia => $Valor) {
					$dados = $Valor['binary'];
					$nomeAnexo = $Valor['name'];
					$extensao  = mb_strtolower(pathinfo($nomeAnexo, PATHINFO_EXTENSION));
					$microtime = ZeroEsq($ia, 3);
					
					// quando pega o Arquivo e conteudo
					$nomeAnexoPath = mb_strtolower($idt_plu_email_conteudo.'_nomeanexo_'.$microtime.'_'.troca_caracter($nomeAnexo));
					$caminho   = "obj_file/plu_email_conteudo_anexo/".$nomeAnexoPath;
					$arq       = fopen($caminho,"w+");
					fwrite($arq, $dados);
					fclose($arq);
					
					// Gravar anexo
					$titulo     = $nomeAnexo;
					$detalhe    = "";
					$nomeAnexow = aspa($nomeAnexoPath);
					$extensaow  = aspa($extensao);
					$caminhow   = aspa($caminho);
					$titulow    = aspa($titulo);
					$detalhew   = aspa($detalhe);
					
					$sql_i = ' insert into plu_email_conteudo_anexo ';
					$sql_i .= ' (  ';
					$sql_i .= " idt_plu_email_conteudo, ";
					$sql_i .= " nomeAnexo, ";
					$sql_i .= " extensao, ";
					$sql_i .= " caminho, ";
					$sql_i .= " titulo, ";
					$sql_i .= " detalhe ";
					$sql_i .= '  ) values ( ';
					$sql_i .= " $idt_plu_email_conteudo, ";
					$sql_i .= " $nomeAnexow, ";
					$sql_i .= " $extensaow, ";
					$sql_i .= " $caminhow, ";
					$sql_i .= " $titulow, ";
					$sql_i .= " $detalhew ";
					$sql_i .= ') ';
					execsql($sql_i);
				}
			}
			
			if ($mx>100)
			{
		        //   break;
			}
		}
		set_time_limit(30);
		return $vetErro;
	}
	
	private function AnalisaTitulo($titulot)
	{
	    $vetAnaliseTitulo = Array();
		$nossonumero      = "";
		$seunumero        = "";
		
		$situacao         = "";
		
		/*
		$vet = explode(']',$titulot);
        $tam = count($vet);
        if ($tam>=2)
		{
            $nossonumero = $vet[0];
			$seunumero   = $vet[1];
			
			$vet = explode('[',$nossonumero);
			$tam = count($vet);
			if ($tam>=2)
			{
			    $nossonumero = $vet[1];
			}
			$vet = explode('[',$seunumero);
			$tam = count($vet);
			if ($tam>=2)
			{
			    $seunumero = $vet[1];
			}
		}
		*/
		
		$vet = explode('-',$titulot);
		$titulocontrole=$vet[0];
		$vet = explode(']',$titulocontrole);
        $tam = count($vet);
        if ($tam>=2)
		{
		    $seunumero   = $vet[0];
			$situacao    = $vet[1];
			$nossonumero = $vet[2];
			if ($tam==3)
			{
			    $nossonumero = $vet[1];
				$situacao    = "";
			}
			else
			{
				$vet = explode('[',$situacao);
				$tam = count($vet);
				if ($tam>=2)
				{
					$situacao = $vet[1];
				}
			}
			//
			$vet = explode('[',$nossonumero);
			$tam = count($vet);
			if ($tam>=2)
			{
			    $nossonumero = $vet[1];
			}
			
			$vet = explode('[',$seunumero);
			$tam = count($vet);
			if ($tam>=2)
			{
			    $seunumero = $vet[1];
			}
		}
		// a questão é que ele esta mandando ao contrario
		//$vetAnaliseTitulo['nossonumero'] = $nossonumero;
		//$vetAnaliseTitulo['seunumero']   = $seunumero;
		
		$vetAnaliseTitulo['nossonumero'] = $nossonumero;
		$vetAnaliseTitulo['seunumero']   = $seunumero;
		$vetAnaliseTitulo['situacao']    = $situacao;
		
		
	    return $vetAnaliseTitulo;
	}
	
	
   /**
     * @param $id
     * @param bool $withbody
     * @return array
     */
    public function formatMessage($id, $withbody=true){
        $header = imap_headerinfo($this->imap, $id);

        // fetch unique uid
        $uid = imap_uid($this->imap, $id);
	
        // get email data
        $subject = '';
        if ( isset($header->subject) && strlen($header->subject) > 0 ) {
            foreach(imap_mime_header_decode($header->subject) as $obj){
                
				//$titulo = decode_imap_text($obj->text);
			    
				$subject .= $obj->text;
				
            }
        }
        //$subject = $this->convertToUtf8($subject);
		
		$subjectww=$subject;
		
		$subject = quoted_printable_decode($subject);
		$subject = $this->decode_imap_text($subject);
		
		$pos = strpos($subject,'-8859-1');
		if ($pos === false)
		{
		   // $subject =  utf8_decode($subject);
		}
		//$subject = utf8_decode($subject);
		
        $email = array(
            'to'       => isset($header->to) ? $this->arrayToAddress($header->to) : '',
            'from'     => $this->toAddress($header->from[0]),
            'date'     => $header->date,
            'subject'  => $subject,
			'subjectww'  => $subjectww,
            'uid'      => $uid,
            'unread'   => strlen(trim($header->Unseen))>0,
            'answered' => strlen(trim($header->Answered))>0,
            'deleted'  => strlen(trim($header->Deleted))>0
        );
        if(isset($header->cc))
            $email['cc'] = $this->arrayToAddress($header->cc);

        // get email body
        if($withbody===true) {
            $body = $this->getBody($uid);
            $email['body'] = $body['body'];
			
			
			
            $email['html'] = $body['html'];
        }

        // get attachments
        $mailStruct  = imap_fetchstructure($this->imap, $id);
        $attachments = $this->attachments2name($this->getAttachments($this->imap, $id, $mailStruct, ""));
        if(count($attachments)>0) {
			foreach ($attachments as $val) {
				$arr = Array();
				
				foreach ($val as $k => $t) {
					if ($k == 'name') {
						$decodedName = imap_mime_header_decode($t);
						$t = $this->convertToUtf8($decodedName[0]->text);
					}
				    $arr[$k] = $t;
				}
				
			    $email['attachments'][] = $arr;
			}
		}
        return $email;
    }

	
	 /**
     * returns body of the email. First search for html version of the email, then the plain part.
     *
     * @return string email body
     * @param $uid message id
     */
    protected function getBody($uid) {
        $body = $this->get_part($this->imap, $uid, "TEXT/HTML");
		//$body = $this->convertToUtf8($body);
        $html = true;
        // if HTML body is empty, try getting text body
        if ($body == "") {
            $body = $this->get_part($this->imap, $uid, "TEXT/PLAIN");
            $html = false;
		//	$body =  quoted_printable_decode($body);
        }
        //$body = $this->convertToUtf8($body);
		//$a='---------------------'.$this->encoding.'---------------------<br />';
		
		$a='';
		
		
		$ff = "";
		if ($html == false)
		{
		    $ff   = "S";
			$ff   = "";
		    $body =  $ff."<br />".$a.quoted_printable_decode($body);
		}
		else
		{
		   //$body = $this->decode_imap_text($body);
		   $ff   = "Q";
		   $ff   = "";
		   $body =  $ff."<br />".$a.quoted_printable_decode($body);
		}
		//$body =  html_entity_decode($body,ENT_QUOTES,'ISO-8859-1');
		$pos = strpos($body,'-8859-1');
		if ($pos === false)
		{
		   $body =  utf8_decode($body);
		}   
		
		
		
        return array( 'body' => $body, 'html' => $html);
    }
   
	
	
	
    /**
     * convert to utf8 if necessary.
     *
     * @return true or false
     * @param $string utf8 encoded string
     */
    function convertToUtf8($str) { 
        if(mb_detect_encoding($str, "UTF-8, ISO-8859-1, GBK")!="UTF-8")
            $str = utf8_encode($str);
        $str = iconv('UTF-8', 'UTF-8//IGNORE', $str);
        return $str; 
    } 
/**
     * convert imap given address in string
     *
     * @return string in format "Name <email@bla.de>"
     * @param $headerinfos the infos given by imap
     */
    protected function toAddress($headerinfos) {
        $email = "";
        $name = "";
        if(isset($headerinfos->mailbox) && isset($headerinfos->host)) {
            $email = $headerinfos->mailbox . "@" . $headerinfos->host;
        }

        if(!empty($headerinfos->personal)) {
            $name = imap_mime_header_decode($headerinfos->personal);
            $name = $name[0]->text;
        } else {
            $name = $email;
        }
        
        $name = $this->convertToUtf8($name);
        
        return $name . " <" . $email . ">";
    }

    
    /**
     * converts imap given array of addresses in strings
     *
     * @return array with strings (e.g. ["Name <email@bla.de>", "Name2 <email2@bla.de>"]
     * @param $addresses imap given addresses as array
     */
    protected function arrayToAddress($addresses) {
        $addressesAsString = array();
        foreach($addresses as $address) {
            $addressesAsString[] = $this->toAddress($address);
        }
        return $addressesAsString;
    }



protected function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false) {
        if (!$structure) {
               $structure = imap_fetchstructure($imap, $uid, FT_UID);
        }
        if ($structure) {
            if ($mimetype == $this->get_mime_type($structure)) {
                if (!$partNumber) {
                    $partNumber = 1;
                }
				$text = '';
				
                $text .= imap_fetchbody($imap, $uid, $partNumber, FT_UID | FT_PEEK);
				
				$this->encoding = $structure->encoding;
				
				
									for($i=0;$i<256;$i++)
    { 
    $c1=dechex($i);
    if(strlen($c1)==1){$c1="0".$c1;} 
    $c1="=".$c1;
    $myqprinta[]=$c1;
    $myqprintb[]=chr($i);
    }

				
                switch ($structure->encoding) {
                    case 3: return (imap_base64($text));
                    case 4: return (imap_qprint($text));
					
					//case 4: return quoted_printable_decode($text);
					//case 4: return imap_qprint(str_replace($myqprinta,$myqprintb,($data)));}
					//
					
					case 0: return (imap_utf7_decode($text));
					case 1: return (imap_utf8($text));
					case 2: return (($text));
					

					//case 0: return $structure->encoding.'---------------------------------'.quoted_printable_decode(imap_7bit($text));
					//case 1: return $structure->encoding.'---------------------------------'.quoted_printable_decode(imap_8bit($text));
					//case 2: return $structure->encoding.'---------------------------------'.quoted_printable_decode(imap_binary($text));
					
					
                    //default: return quoted_printable_decode($text);
					
					
					/*
					
					for($i=0;$i<256;$i++)
    { 
    $c1=dechex($i);
    if(strlen($c1)==1){$c1="0".$c1;} 
    $c1="=".$c1;
    $myqprinta[]=$c1;
    $myqprintb[]=chr($i);
    }
					
					if(!$code){return imap_utf7_decode($data);}
					
if($code==0){return imap_utf7_decode($data);}
if($code==1){return imap_utf8($data);}
if($code==2){return ($data);}
if($code==3){return imap_base64($data);}
if($code==4){return imap_qprint(str_replace($myqprinta,$myqprintb,($data)));}
if($code==5){return ($data);}
					*/
					
					
					default: return ($text);
					
					
               }
			}   
	/*		   
			   if ($coding == 0) 
{ 
    $message = imap_7bit($message); 
} 
elseif ($coding == 1) 
{ 
    $wiadomsoc = imap_8bit($message); 
} 
elseif ($coding == 2) 
{ 
    $message = imap_binary($message); 
} 
elseif ($coding == 3) 
{ 
    $message = imap_base64($message); 
} 
elseif ($coding == 4) 
{ 
    $message = quoted_printable($message); 
} 
elseif ($coding == 5) 
{ 
    $message = $message; 
} 

			   
			   
           
    */ 
            // multipart 
            if ($structure->type == 1) {
                foreach ($structure->parts as $index => $subStruct) {
                    $prefix = "";
                    if ($partNumber) {
                        $prefix = $partNumber . ".";
                    }
                    $data = $this->get_part($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
                    if ($data) {
                        return $data;
                    }
                }
            }
        }
        return false;
    }
    
    
    /**
     * extract mimetype
     * taken from http://www.sitepoint.com/exploring-phps-imap-library-2/
     *
     * @return string mimetype
     * @param $structure
     */
    protected function get_mime_type($structure) {
        $primaryMimetype = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");
     
        if ($structure->subtype) {
           return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
        }
        return "TEXT/PLAIN";
    }
    /**
     * get attachments of given email
     * taken from http://www.sitepoint.com/exploring-phps-imap-library-2/
     *
     * @return array of attachments
     * @param $imap stream
     * @param $mailNum email
     * @param $part
     * @param $partNum
     */
    protected function getAttachments($imap, $mailNum, $part, $partNum) {
        $attachments = array();
     
        if (isset($part->parts)) {
            foreach ($part->parts as $key => $subpart) {
                if($partNum != "") {
                    $newPartNum = $partNum . "." . ($key + 1);
                } else {
                    $newPartNum = ($key+1);
                }
                $result = $this->getAttachments($imap, $mailNum, $subpart,
                    $newPartNum);
                if (count($result) != 0) {
                    array_push($attachments, $result);
                }
            }
        } else if (isset($part->disposition)) {
            if (strtolower($part->disposition) == "attachment") {
                $attachmentBINARY = imap_fetchbody($imap, $mailNum, $partNum);
				
                $attachmentDetails = array(
                    "name"    => $part->dparameters[0]->value,
                    "partNum" => $partNum,
                    "enc"     => $part->encoding,
                    "size"    => $part->bytes
                );
				
				switch ($part->encoding) {
					case 0: // 7BIT
					case 1: // 8BIT
					case 2: // BINARY
						$attachmentDetails['binary'] = $attachmentBINARY;
						break;

					case 3: // BASE-64
						$attachmentDetails['binary'] = base64_decode($attachmentBINARY);
						break;

					case 4: // QUOTED-PRINTABLE
						$attachmentDetails['binary'] = imap_qprint($attachmentBINARY);
						break;
						
					default:
						throw new Exception(sprintf('Encoding failed: Unknown encoding %s (5: OTHER).', $part->encoding));				
						break;
				}
				
				return $attachmentDetails;
			}
		}
     
        return $attachments;
    }
    protected function attachments2name($attachments) {
        $names = array();
        foreach($attachments as $attachment) {
            $names[] = array(
                'name' => $attachment['name'],
                'size' => $attachment['size'],
                'binary' => $attachment['binary']
            );
        }
        return $names;
    }
	
	
#
# Decode UTF-8 and iso-8859-1 encoded text
#
private function decode_imap_text($var){
if(ereg("=\?.{0,}\?[Bb]\?",$var)) {
$var = split("=\?.{0,}\?[Bb]\?",$var);
 
while(list($key,$value)=each($var)){
if(ereg("\?=",$value)){
$arrTemp=split("\?=",$value);
$arrTemp[0]=base64_decode($arrTemp[0]);
$var[$key]=join("",$arrTemp);
}
}
$var=join("",$var);
}
 
if(ereg("=\?.{0,}\?Q\?",$var)) {
$var = quoted_printable_decode($var);
$var = ereg_replace("=\?.{0,}\?[Qq]\?","",$var);
$var = ereg_replace("\?=","",$var);
}
return trim($var);
}

private function DecodeBody($mbox,$id)
{
$struckture = imap_fetchstructure($mbox, $id); 
$message = imap_fetchbody($mbox,$id,$part);    
$name = $struckture->parts[$part]->dparameters[0]->value; 
$type = $struckture->parts[$part]->typee; 
############## type 
if ($type == 0) 
{ 
    $type = "text/"; 
} 
elseif ($type == 1) 
{ 
    $type = "multipart/"; 
} 
elseif ($type == 2) 
{ 
    $type = "message/"; 
} 
elseif ($type == 3) 
{ 
    $type = "application/"; 
} 
elseif ($type == 4) 
{ 
    $type = "audio/"; 
} 
elseif ($type == 5) 
{ 
    $type = "image/"; 
} 
elseif ($type == 6) 
{ 
    $type = "video"; 
} 
elseif($type == 7) 
{ 
    $type = "other/"; 
} 
$type .= $struckture->parts[$part]->subtypee; 
######## Type end 

header("Content-typee: ".$type); 
header("Content-Disposition: attachment; filename=".$name); 

######## coding 
$coding = $struckture->parts[$part]->encoding; 
if ($coding == 0) 
{ 
    $message = imap_7bit($message); 
} 
elseif ($coding == 1) 
{ 
    $wiadomsoc = imap_8bit($message); 
} 
elseif ($coding == 2) 
{ 
    $message = imap_binary($message); 
} 
elseif ($coding == 3) 
{ 
    $message = imap_base64($message); 
} 
elseif ($coding == 4) 
{ 
    $message = quoted_printable($message); 
} 
elseif ($coding == 5) 
{ 
    $message = $message; 
} 
//echo $message;
  return $message;
}
	
	
	
}
////////////////////////////////////////////////////
// <FIM DO ARQUIVO>                               //
////////////////////////////////////////////////////
?>