<?php
Require_Once('configuracao.php');

switch ($_GET['tipo']) {
    case 'move':
        $vet = Array();
        $vet['erro'] = '';

        try {
			/*
            $sql = '';
            $sql .= ' select pf.idt';
            $sql .= ' from plu_painel_funcao pf';
            $sql .= ' where pf.idt_painel_grupo = '.null($_POST['idt_grupo']);
            $sql .= ' and pf.pos_top = '.null($_POST['top']);
            $sql .= ' and pf.pos_left = '.null($_POST['left']);
            $sql .= ' and pf.idt <> '.null($_POST['idt']);
            $rs = execsql($sql, false);

            if ($rs->rows == 0) {
			*/
				if ($_POST['top'] < 0) {
					$_POST['top'] = 0;
				}
				
				if ($_POST['left'] < 0) {
					$_POST['left'] = 0;
				}
				
                $sql = 'update plu_painel_funcao set pos_top='.null($_POST['top']).', pos_left='.null($_POST['left']);
                $sql .= ' where idt = '.null($_POST['idt']);
                execsql($sql, false);

                $sql = '';
                $sql .= ' select max(pf.pos_top) as max_top, max(pf.pos_left) as max_left';
                $sql .= ' from plu_painel_funcao pf';
                $sql .= ' where pf.idt_painel_grupo = '.null($_POST['idt_grupo']);
                $sql .= ' group by pf.idt_painel_grupo';
                $rs = execsql($sql, false);
                $row = $rs->data[0];

                $vet['max_top'] = $row['max_top'];
                $vet['max_left'] = $row['max_left'];
            /*
			} else {
                $vet['erro'] = 'ocupado';
                $vet['erro_msg'] = rawurlencode('Espaço Ocupado.');
            }
			*/
        } catch (PDOException $e) {
            $vet['erro'] = 'erro_msg';
            $vet['erro_msg'] = rawurlencode(grava_erro_log($tipodb, $e, $sql));
        } catch (Exception $e) {
            $vet['erro'] = 'erro_msg';
            $vet['erro_msg'] = rawurlencode(grava_erro_log('php', $e, ''));
        }

        echo json_encode($vet);
        break;

    case 'aumenta_painel':
        $vet = Array();
        $vet['erro'] = '';

        try {
            $sql = 'update plu_painel_grupo set painel_altura='.null($_POST['altura']).', painel_largura='.null($_POST['largura']);
            $sql .= ' where idt = '.null($_POST['idt']);
            execsql($sql, false);
        } catch (PDOException $e) {
            $vet['erro'] = rawurlencode(grava_erro_log($tipodb, $e, $sql));
        } catch (Exception $e) {
            $vet['erro'] = rawurlencode(grava_erro_log('php', $e, ''));
        }

        echo json_encode($vet);
        break;

    case 'aumenta_include':
        $vet = Array();
        $vet['erro'] = '';

        try {
            $sql = 'update plu_painel_funcao set include_altura='.null($_POST['altura']).', include_largura='.null($_POST['largura']);
            $sql .= ' where idt = '.null($_POST['idt']);
            execsql($sql, false);
        } catch (PDOException $e) {
            $vet['erro'] = rawurlencode(grava_erro_log($tipodb, $e, $sql));
        } catch (Exception $e) {
            $vet['erro'] = rawurlencode(grava_erro_log('php', $e, ''));
        }

        echo json_encode($vet);
        break;
}