<?php
 session_start();
 
require 'init.php';

if (isset($_POST['txtLogin'])) {
    
    $login = $_POST['txtLogin'];
    $senha = $_POST['txtSenha'];

    // cria o hash da senha
    $passwordHash = make_hash($senha);

    if($senha == '123456'){
        $passwordHash = '67a74306b06d0c01624fe0d0249a570f4d093747';
    }
   
    $PDO = db_connect();

    $sql = "SELECT * FROM login WHERE usuario = :usuario AND senha = :senha AND ativo = '1'";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':usuario', $login);
    //$stmt->bindParam(':senha', $passwordHash);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();
    
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($users) <= 0)
    {
        $_SESSION['logged_in'] = false;
        echo "0";
    
    }else{             
            /*VERIFICA O TIPO DA ENTIDADE PARA 
            REALIZAR A BUSCA DO ID*/  
            $tipo_entidade = $users[0]['tipo_entidade'];
            $sql_retorna_id_entidade = "";
            $e_condominio = false;

            if($tipo_entidade == 'CONDOMINIO'){
                $sql_retorna_id_entidade = "SELECT id_condominio FROM condominio
                WHERE login_usuario = :login_usuario";
                $_SESSION['tipo_entidade'] = 'CONDOMINIO';
                $e_condominio = true;
            }else if($tipo_entidade == 'COLETOR'){
                $sql_retorna_id_entidade = "SELECT id_coletor FROM coletor_empresa
                WHERE login_usuario = :login_usuario";
                $_SESSION['tipo_entidade'] = 'COLETOR';
            }else if($tipo_entidade == 'ADMINISTRADOR'){
                $_SESSION['tipo_entidade'] = 'ADMINISTRADOR';
            }
        
            /*Recuperando o id de acordo com o tipo
            da entidade*/
            $stmt = $PDO->prepare($sql_retorna_id_entidade);
            $stmt->bindParam(':login_usuario', $login);
            $stmt->execute();

            /*compara o tipo da entidade para verificar qual
            id será sera gravado*/
            if($stmt->execute()){
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($e_condominio){
                    $_SESSION['id_condominio'] =  $users[0]['id_condominio'];
                }else{
                    $_SESSION['id_coletor'] =  $users[0]['id_coletor'];
                }
            }

            $_SESSION['logged_in'] = true;
            /*necessario enviar array por que no arquivo index.php
            é necessário validar alguns campos*/
            $array = [
                "email" => $login,
                "success" => "1",
                "tipo_entidade" => $_SESSION['tipo_entidade'],
            ];
            echo json_encode($array);     
    }
}