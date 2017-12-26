<?php
//  <INICIO DO ARQUIVO>                                       //
//////////////////////////////////////////////////            //
//  GSW - V.1.0 - Julho 2016                                  //
//  Classe de Métodos - EMAIL                                 //
//  Classe deve ser Instanciada apenas uma vez para o Sistema //
//////////////////////////////////////////////////            //
// <INICIO CLASSE TGSW - Trata Email>
class TGSW_EMAILHELPDESK
{
	private $idt_email = ""; 
	private $usuario   = "";
    private $senha     = "";
	private $opcao     = "";
	private $vetEmailhelpdesk = Array();
	
    // 	
    public function __construct($vetEmailhelpdesk)
    {
		$this->usuario  = $vetEmail['usuario'];
		$this->senha    = $vetEmail['senha'];
		$this->opcao    = $vetEmail['opcao'];
		//
		$usuario = $this->usuario;
		$senha   = $this->senha;
		$opcao   = $this->opcao;
		//
		// 
		//
		$vetErro=Array();
        $idt_email = "";
		$sql  = "select  ";
		$sql .= " plu_e.idt  ";
		$sql .= " from plu_email plu_e ";
		$sql .= " where plu_e.email = ".aspa($usuario);
		$rs = execsql($sql);
		if ($rs->rows==0)
		{
            $vetErro[1]='Sem registro de Parâmetro para email '.$email;
			//return $vetErro;		
		}
		else
		{
			ForEach ($rs->data as $row) {
				$idt_email = $row['idt'];
			}	
        }
		$this->idt_email = $idt_email;
    }
    public function __destruct()
    {
    }
	public function GravaEmailHelpdesk()
    {
	    $vetErro=Array();
		set_time_limit(0);
		//
		$sql  = "select  ";
		$sql .= " plu_ec.*  ";
		$sql .= " from  plu_email_conteudo plu_ec ";
		$sql .= " where plu_ec.nao_lida = ".aspa('N') ;
		$sql .= "   and plu_ec.seunumero is not null ";
		$rs   = execsql($sql);
		if  ($rs->rows==0)
		{		
		}
		else
		{
			ForEach ($rs->data as $row) {
				$idt_email_conteudo = $row['idt'];
				$nossonumero = $row['nossonumero'];
				$protocolo   = $nossonumero;
				$seunumero   = $row['seunumero'];
				//
				$idt_email   = $row['idt_email'];
				$numero      = $row['numero'];
				$titulo      = $row['titulo'];
				$corpo       = $row['corpo'];
				$origem      = $row['origem'];
				$datahora    = $row['datahora'];
				$situacao    = $row['situacao'];
				//
				$tipo        = substr($nossonumero,0,2);
				//
				$idt_helpdesk           = "";
				$idt_helpdesk_interacao = "";
				$grava=0;
				beginTransaction();
				if 	($tipo=='HD')
				{
					//  Interação para SA
					$sql  = "select  ";
					$sql .= " plu_h.*  ";
					$sql .= " from plu_helpdesk plu_h ";
					$sql .= " where plu_h.protocolo = ".aspa($protocolo) ;
					$rs   = execsql($sql);
					if  ($rs->rows==0)
					{		
					}
					else
					{
						ForEach ($rs->data as $row) {
						   $idt_helpdesk = $row['idt'];
						   $grava=1;   
						}
					}								
				}
				else
				{
					//  Interação para SA
					$sql  = "select  ";
					$sql .= " plu_h.idt  as plu_h_idt,   ";
					$sql .= " plu_hi.idt as plu_hi_idt   ";
					$sql .= " from plu_helpdesk plu_h ";
					$sql .= " inner join plu_helpdesk_interacao plu_hi ";
					$sql .= " where plu_hi.protocolo = ".aspa($protocolo) ;
					$rs   = execsql($sql);
					if  ($rs->rows==0)
					{		
					}
					else
					{
						ForEach ($rs->data as $row) {
						   $idt_helpdesk           = $row['plu_h_idt'];
						   $idt_helpdesk_interacao = $row['plu_hi_idt'];
						   $grava=1;
						}
					}								
				}
				
				if ($grava==1)
				{
				
				    $numero_id_helpdesk_usuario = aspa($seunumero);
					$sql_a = " update plu_helpdesk set ";
					$sql_a .= " numero_id_helpdesk_usuario    = $numero_id_helpdesk_usuario ";
					$sql_a .= " where idt = ".null($idt_helpdesk);
					$result = execsql($sql_a);

				
				
				
				   // inserir interação
					$tabela = 'plu_helpdesk_interacao';
					$Campo = 'protocolo';
					$tam = 7;
					$codigow = numerador_arquivo($tabela, $Campo, $tam);
					$protocolow = 'HI'.$codigow;
					$protocolo                  = aspa($protocolow);
					
					$datadia = trata_data(date('d/m/Y H:i:s'));
					$datahora                   = aspa($datadia);
					$status                     = aspa('A');
					$ip                         = aspa('99.00');
					$login                      = aspa('suporte.helpdesk');
					$nome                       = aspa('Suporte Helpdesk');
					$email                      = aspa('');
					$titulo                     = aspa($titulo);
					$tipo_solicitacao           = aspa('ES');
					$numero_id_helpdesk_usuario = aspa($seunumero);
					$descricao                  = aspa($corpo);
					$flag_logico                = aspa('A');
					$idt_helpdesk_interacao_ref = null($idt_helpdesk_interacao);
					$status_helpdesk_usuario    = aspa($situacao);
					
					
					$sql_i = ' insert into plu_helpdesk_interacao ';
					$sql_i .= ' (  ';
					$sql_i .= " idt_helpdesk, ";
					$sql_i .= " idt_email_conteudo, ";
					
					$sql_i .= " protocolo, ";
					$sql_i .= " datahora, ";
					$sql_i .= " status, ";
					$sql_i .= " ip, ";
					$sql_i .= " login, ";
					$sql_i .= " nome, ";
					$sql_i .= " email, ";
					$sql_i .= " titulo, ";
					$sql_i .= " tipo_solicitacao, ";
					$sql_i .= " numero_id_helpdesk_usuario, ";
					$sql_i .= " flag_logico, ";
					$sql_i .= " idt_helpdesk_interacao_ref, ";
					$sql_i .= " status_helpdesk_usuario, ";
					
					$sql_i .= " descricao ";
					$sql_i .= '  ) values ( ';
					$sql_i .= " $idt_helpdesk, ";
					$sql_i .= " $idt_email_conteudo, ";
					$sql_i .= " $protocolo, ";
					$sql_i .= " $datahora, ";
					$sql_i .= " $status, ";
					$sql_i .= " $ip, ";
					$sql_i .= " $login, ";
					$sql_i .= " $nome, ";
					$sql_i .= " $email, ";
					$sql_i .= " $titulo, ";
					$sql_i .= " $tipo_solicitacao, ";
					$sql_i .= " $numero_id_helpdesk_usuario, ";
					$sql_i .= " $flag_logico, ";
					$sql_i .= " $idt_helpdesk_interacao_ref, ";
					$sql_i .= " $status_helpdesk_usuario, ";
					
					$sql_i .= " $descricao ";
					$sql_i .= ') ';
					execsql($sql_i);
					if ($situacao!="")
					{
						//
						$sql  = 'update plu_helpdesk ';
						$sql .= ' set status_helpdesk_usuario = '.$status_helpdesk_usuario;
						$sql .= ' where idt = '.null($idt_helpdesk);
						execsql($sql);
					}
				
				}
				//
				$sql  = 'update plu_email_conteudo ';
				$sql .= ' set nao_lida = '.aspa('S');
				$sql .= ' where idt = '.null($idt_email_conteudo);
				execsql($sql);
				
				commit();
				//
			}
		}


		set_time_limit(30);
		return $vetErro;
	}
	
	
	
	
}
////////////////////////////////////////////////////
// <FIM DO ARQUIVO>                               //
////////////////////////////////////////////////////
?>