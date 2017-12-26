<?php
//
// CLASSE PARA DETERMINAR A ESTRUTURA DA ENTIDADE
//
class PIR_entidades {
    private $name = '';
    private $data = '';
	public  $vetor_grupo_tabela = Array();
    private $vetor_estrutura = Array();
	private $VetCampoTipoPIR  = Array();
    public function __construct($nome,$opcao) {
        $this->data = '';
        $this->nome = $nome;
        if ($nome != '') {
            $this->estrutura_tr($nome);
            if ($opcao == 'A') {
                $this->GerarEAD();
            }
        }
		$this->GrupoTabela();
    }
    public function estrutura($nome) {
        $this->nome = $nome;
        $sql_estrutura = " select * from {$nome} where 2 = 1";
        $rs_estrutura = execsql($sql_estrutura);
        //return  $this -> data;
        return $rs_estrutura;
    }
    private function GrupoTabela() {
	    $Banco="db_pir_grc";
		$funcao = 'CD-PESSOA';
	    $this->vetor_grupo_tabela[$funcao]['01']="Cadastrar Pessoa";
		$vetTbelas   = Array();
		$vetTbelas[$Banco.'grc_produto_tema']   = "Cadastro Tema";
		$vetTbelas[$Banco.'grc_produto_tipo']   = "Cadastro de Tipo de Produto";
		$this->vetor_grupo_tabela[$funcao]['01.01']['subgrupo']="Nomenclatura";
		$this->vetor_grupo_tabela[$funcao]['01.01']['tabelas'] =$vetTbelas;
		$vetTbelas   = Array();
		$vetTbelas[$Banco.'grc_entidade_pessoa']   = "Cadastro Tema";
		$this->vetor_grupo_tabela[$funcao]['01.02']['subgrupo']="Cadastro";
		$this->vetor_grupo_tabela[$funcao]['01.02']['tabelas'] =$vetTbelas;
	}

    public function estrutura_tr($nome) {
        $this->nome = $nome;
        $sql_estrutura = " select * from {$nome} where 2 = 1";
        $rs_estrutura = execsql($sql_estrutura);
        //return  $this -> data;
        //$rs_estrutura['type']

        $varEst = Array();
        $varEst['FD'] = $rs_estrutura->info [name];
        $vetWS = Array();
        $qtdcampos = $rs_estrutura->cols;
        for ($c = 0; $c < $qtdcampos; $c++) {
            $nomecampo = $rs_estrutura->info [name] [$c];
            $vetWS[$c] = $nomecampo.'_w';
        }
        $varEst['WS'] = $vetWS;

        $vetFD_PHP = Array();
        $vetWS_PHP = Array();
        for ($c = 0; $c < $qtdcampos; $c++) {
            $nomecampo = $rs_estrutura->info [name] [$c];
            $vetFD_PHP[$c] = "$".$nomecampo;
            $vetWS_PHP[$c] = "$".$nomecampo.'_w';
        }
        $varEst['FD_PHP'] = $vetFD_PHP;
        $varEst['WS_PHP'] = $vetWS_PHP;

        $vetTIPO_CPO = Array();
		$vetTIPO_CPO_PIR = Array();
        for ($c = 0; $c < $qtdcampos; $c++) {
            $tipocpo         = $rs_estrutura->info [type] [$c];
            $vetTIPO_CPO[$c] = $tipocpo;
			$tibobase = 'MySql';
			if ($tibobase=='MySql')
			{
			    $idt_tipo_pir = 1;
				if ($tipocpo=='var_string')
				{
				   $idt_tipo_pir = 1;
				}
				if ($tipocpo=='long')
				{
				   $idt_tipo_pir = 3; 
				}
				if ($tipocpo=='date')
				{
				   $idt_tipo_pir = 5; 
				}
				if ($tipocpo=='datetime')
				{
				   $idt_tipo_pir = 9; 
				}
				if ($varEst['FD'][$c]=='idt')
				{
				    $idt_tipo_pir = 6; 
				}
			    $vetTIPO_CPO_PIR[$tibobase][$tipocpo]=$idt_tipo_pir;
			}	
        }
		$this -> VetCampoTipoPIR       = $vetTIPO_CPO_PIR;
        $varEst['TP_CPO']      = $vetTIPO_CPO;
        $this->vetor_estrutura = $varEst;
        return $this->vetor_estrutura;
    }
	
	public function estrutura_tbn($nome,$sql_instrucao) {
	    $estrutura     = Array();
		if ($sql_instrucao=="")
		{
            $sql_estrutura = " select * from {$nome} ";
		}
		else
		{
            $sql_estrutura = $sql_instrucao;
		}
        $rs_estrutura  = execsql($sql_estrutura);
		$qtdcampos     = $rs_estrutura->cols;
		$linhas        = Array(); 
		
	    ForEach ($rs_estrutura->data as $row) {
		    $vetCampos=Array();
			for ($c = 0; $c < $qtdcampos; $c++) {
				$nomecampo = $rs_estrutura->info [name] [$c];
				$vetCampos[$nomecampo] = $row[$nomecampo];
			}
			$linhas[$nome][] = $vetCampos;
		}

        //return $rs_estrutura->data;
		return $linhas;
        
    }
	
	
    public function estrutura_cd($tp) {
        return $this->vetor_estrutura[$tp];
    }


    public function GerarEAD() {
	    $nome                = $this->nome;
		$vetEstrutura_FD     = $this-> estrutura_cd('FD');
		$vetEstrutura_TP_CPO = $this-> estrutura_cd('TP_CPO');
        // gravar no pir ead
		$sql = '';
		$sql .= ' select idt ';
		$sql .= ' from '.db_pir.'plu_pl_ead plu_pe ';
		$sql .= ' where codigo = '.aspa($nome);
		$rs = execsql($sql);
		if ($rs->rows == 0 )
		{
		    $codigo         = aspa($nome); 
			$descricao      = aspa($nome); 
			$resumo         = aspa($nome); 
			$alias          = aspa('grc_e'); 
			$classificacao  = aspa('GR.66'); 
			$idt_natureza   = 1;
            
			$alias          = aspa($nome); 
			
			$dataw = date('d/m/Y H:i:s');
			$data = aspa(trata_data($dataw));
			$idt_responsavel = $_SESSION[CS]['g_id_usuario'];
            $idt_responsavel = 1;

 		    $sql_i  = ' insert into '.db_pir.'plu_pl_ead ';
            $sql_i .= ' (  ';
            $sql_i .= " codigo, ";
			$sql_i .= " descricao, ";
            $sql_i .= " resumo, ";
			$sql_i .= " alias, ";
			$sql_i .= " classificacao, ";
			$sql_i .= " idt_responsavel, ";
			$sql_i .= " idt_natureza ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $codigo, ";
			$sql_i .= " $descricao, ";
            $sql_i .= " $resumo, ";
			$sql_i .= " $alias, ";
			$sql_i .= " $classificacao, ";
			$sql_i .= " $idt_responsavel, ";
			$sql_i .= " $idt_natureza ";
            $sql_i .= ') ';
            $result = execsql($sql_i);
			$idt_tabela = lastInsertId();
			ForEach ($vetEstrutura_FD as $Indice => $CampoTabela)
			{
			    $idt_plu_pl_ead = $idt_tabela;
				$codigo         = aspa($CampoTabela); 
				$descricao      = aspa($CampoTabela); 
				$detalhe        = aspa($codigo); 
				
				$idt_tipo        = 1; 
				$tamanho         = 10;
				$idt_natureza    = 1;
				$tipoCampoBase   = $vetEstrutura_TP_CPO[$Indice];
				$tipoBase = 'MySql';
				$idt_tipo        = $this-> CampoTipoPIR($tipoBase,$tipoCampoBase);
				
			    $sql_i  = ' insert into '.db_pir.'plu_pl_ead_campos ';
				$sql_i .= ' (  ';
				$sql_i .= " idt_plu_pl_ead, ";
				$sql_i .= " codigo, ";
				$sql_i .= " descricao, ";
				$sql_i .= " detalhe, ";
				$sql_i .= " tamanho, ";
				$sql_i .= " idt_tipo, ";
				$sql_i .= " idt_natureza ";
				$sql_i .= "  ) values ( ";
				$sql_i .= " $idt_plu_pl_ead, ";
				$sql_i .= " $codigo, ";
				$sql_i .= " $descricao, ";
				$sql_i .= " $detalhe, ";
				$sql_i .= " $tamanho, ";
				$sql_i .= " $idt_tipo, ";
				$sql_i .= " $idt_natureza ";
				$sql_i .= ') ';
				$result = execsql($sql_i);
            }			
		}
		else
		{
		    $row = $rs->data[0];
		}	

    }		

    public function  CampoTipoPIR($tipoBase,$tipoCampoBase)
	{
	    return $this-> VetCampoTipoPIR[$tipoBase][$tipoCampoBase];
	
	}
}

//
//  Ordem de Contratação do GEC
//
class PIR_GEC_OrdemContratacao {

    private $tabela = 'gec_contratacao_credenciado_ordem';
    private $tabela_estrutura = ''; // objeto
    private $tabela_nome = '';
    private $vetor_estrutura = Array();

    public function __construct($banco) {
        $this->tabela_estrutura = new pir_entidades;
        $this->tabela_nome      = $banco.$this->tabela;
        $this->vetor_estrutura = $this->tabela_estrutura->estrutura_tr($this->tabela_nome);
    }

    


    public function estrutura_oc() {
        return $this->vetor_estrutura;
    }

    public function estrutura_cd($tp) {
        return $this->vetor_estrutura[$tp];
    }

}

//
//  Tabela genérica
//
class PIR_TABELA {
    private $tabela = 'gec_contratacao_credenciado_ordem';
    private $tabela_estrutura = ''; // objeto
    private $tabela_nome = '';
    private $vetor_estrutura = Array();

    public function __construct($vetTabelas) {
        $this->tabela_estrutura = new pir_entidades;
		ForEach ($vetTabelas as $Ordem => $Tabela) 
        {
           $this->tabela_nome = $Tabela;
           $this->vetor_estrutura[$Tabela] = $this->tabela_estrutura->estrutura_tr($Tabela);
		}
    }

    public function estrutura_tbs() {
        return $this->vetor_estrutura;
    }
    public function estrutura_tb($Tabela) {
        return $this->vetor_estrutura[$Tabela];
    }
    public function estrutura_tbtp($Tabela,$tp) {
        return $this->vetor_estrutura[$Tabela][$tp];
    }

    public function estrutura_tbn($nome,$sql_instrucao) {
        return $this->tabela_estrutura -> estrutura_tbn($nome,$sql_instrucao);
    }
    public function CarregarTabelas() {
        return $this->tabela_estrutura -> vetor_grupo_tabela;
    }
    



   private function array_to_xml_r( $TabelaPHP, $ObjXML) {
 		foreach( $TabelaPHP as $key => $value ) {
			if( is_numeric($key) ){
				$key = 'item'.$key; //dealing with <0/>..<n/> issues
			}
			if( is_array($value) ) {
				$subnode = $ObjXML->addChild($key);
				$this->array_to_xml_r($value, $subnode);
			} else {
				$ObjXML->addChild("$key",htmlspecialchars("$value"));
			}
		}
		//saving generated xml file; 
        //$result = $xml_data->asXML('/file/path/name.xml');

		return $ObjXML;
    }
    public function TabelaPHP_to_ObjXML($TabelaPHP) {
        $ObjXML = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
		$this->array_to_xml_r($TabelaPHP, $ObjXML);
		//return $ObjXML->asXML();
		return $ObjXML;
    }
	public function ObjXML_to_XML($ObjXML) {
        return $ObjXML->asXML();
    }


    public function xmlTable($xml) {
		$html  = "";
		$html .= "<div>";
		$primeiro=1;
		ForEach ($xml as $tabela => $ObjetoTabela) {
				$html .= "<table class='' width='2000px' border='1' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
				$html .= "<caption style='background:#FF0000; text-align:left;' >$tabela</caption>";
				if ($primeiro==1)
				{
					$primeiro=0;
					ForEach ($ObjetoTabela as $linha => $ObjetoLinha) {
						$html .= "<tr>";
						$html .= "<th style='background:#0000FF; color:#FFFFFF; ' >";
						$html .= "Linha";
						$html .= "</th>";
						ForEach ($ObjetoLinha as $campo => $Valor) {
							$html .= "<th style='background:#0000FF; color:#FFFFFF; ' >";
							$html .= "$campo";
							$html .= "</th>";
						}
						$html .= "</tr>";
						break;
					}
				}
			   
			   ForEach ($ObjetoTabela as $linha => $ObjetoLinha) {
			      $linhaw = $linha + 1;
				  $html .= "<tr>";
				  $html .= "<td>";
				  $html .= "$linhaw";
				  $html .= "</td>";
			
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
		return $html;
    }


    function MigraNomenclaturaTabelaPHP($tabela,$sql_instrucao)
	{
       $ObjetoTabelaPHP  = $this -> estrutura_tbn($tabela,$sql_instrucao);
	   return $ObjetoTabelaPHP;
	}
    function MigraNomenclaturaHTMLTable($tabela,$sql_instrucao)
	{
       $ObjetoTabelaHTML = $this -> MigraNomenclaturaTabelaPHP($tabela,$sql_instrucao);
	   $htmlTable        = $this -> xmlTable($ObjetoTabelaHTML);
	   return $htmlTable;
	}	
   

}




// FIM DA FUNÇÃO