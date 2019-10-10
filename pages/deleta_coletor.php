<?php
    session_start();

    require 'init.php';
    if (isset($_POST['txtEmailColetorExlusao'])) {
        $email_usuario = $_POST['txtEmailColetorExlusao'];

        $PDO = db_connect();
    
        $sql = "DELETE FROM coletor_empresa WHERE login_usuario = :email";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':email', $email_usuario);

        if($stmt->execute()){
            $count = $stmt->rowCount();
            if($count > 0){
                desativaUsuario($email_usuario);
                echo "1";
            }else{
                echo "0";
            }
        }else{
            echo($stmt->errorInfo());
        }
    }
?>