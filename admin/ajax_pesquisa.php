<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
if ($_REQUEST['cas'] == '') {
    $_REQUEST['cas'] = 'conteudo_abrir_sistema';
}
define('conteudo_abrir_sistema', $_REQUEST['cas']);

Require_Once('configuracao.php');

if ($_SESSION[CS]['g_id_usuario'] == '') {
    die('O acesso ao sistema expirou! Favor entrar no sistema outra vez.');
}

if (file_exists('funcao_atendimento.php')) {
    Require_Once('funcao_atendimento.php');
}

switch ($_GET['tipo']) {

    case 'PESQ_GF':
	    $post          = $_POST['post_pesquisa'];
		$get           = $_POST['get_pesquisa'];
		$codigo        = $_POST['codigo_pesquisa'];
		$descricao     = utf8_decode($_POST['descricao_pesquisa']);
		$menu          = $_POST['menu_pesquisa'];
		//$gravapostw = json_decode($gravapost);
        $vet = Array(
            'erro' => '',
            
        );

        try {
	        $idt_proprietario = $_SESSION[CS]['g_id_usuario'];
			$post             = $post;
			$get              = $get;
			if ($codigo=="")
			{
				$Campo  = 'codigo';
				$tam = 7;
				$codigow = numerador_arquivo($tabela, $Campo, $tam);
				$codigo  = 'PE'.$codigow;
			}
			
			$codigo           = aspa($codigo);
			$descricao        = aspa($descricao);
			$post             = aspa($post);
			$get              = aspa($get);
			$dt = getdata(true, false, true);
			$data_criacao     = aspa(trata_data($dt));
			$funcao           = aspa($menu);
			
			$sql_i = ' insert into plu_pesquisa ';
			$sql_i .= ' (  ';
			$sql_i .= " codigo, ";
			$sql_i .= " descricao, ";
			$sql_i .= " idt_proprietario, ";
			$sql_i .= " post_slv, ";
			$sql_i .= " get_slv,  ";
			$sql_i .= " data_criacao,  ";
			$sql_i .= " funcao  ";
			$sql_i .= '  ) values ( ';
			$sql_i .= " $codigo,";
			$sql_i .= " $descricao, ";
			$sql_i .= " $idt_proprietario, ";
			$sql_i .= " $post, ";
			$sql_i .= " $get, ";
			$sql_i .= " $data_criacao,  ";
			$sql_i .= " $funcao  ";
			$sql_i .= ') ';
			execsql($sql_i, false);

        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

     case 'PESQ_EF':
	    $idt_pesquisa=$_POST['idt_pesquisa'];
        $vet = Array(
            'erro' => '',
        );
        try {
            $sql = 'delete from plu_pesquisa ';
            $sql .= ' where idt = '.null($idt_pesquisa);
            execsql($sql, false);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }
        echo json_encode($vet);
        break;


    case 'PESQ_SF':
	    $idt_pesquisa=$_POST['idt_pesquisa'];
        $vet = Array(
            'erro' => '',
			'idt'  => '',
			'codigo'  => '',
			'descricao'  => '',
			'texto'  => '',
        );
        try {
            $sql  = '';
			$sql .= ' select *';
			$sql .= ' from plu_pesquisa plu_p';
			$sql .= ' where idt = '.null($idt_pesquisa);
			$rs   = execsql($sql);
			foreach ($rs->data as $row) {
				$idt       = $row['idt'];
				$codigo    = $row['codigo'];
				$descricao = $row['descricao'];
				$texto     = $row['texto'];
			}
			$vet['idt']       = $idt;
			$vet['codigo']    = $codigo;
			$vet['descricao'] = $descricao;
			$vet['texto']     = $texto;
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }
        echo json_encode($vet);
        break;


}