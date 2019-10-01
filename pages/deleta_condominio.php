<?php
    session_start();

    require 'init.php';
    if (isset($_POST['txtEmailCondominio'])) {
        $email_usuario = $_POST['txtEmailCondominio'];

        $PDO = db_connect();
    
        $sql = "DELETE FROM condominio WHERE login_usuario = :email";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':email', $email_usuario);

        if($stmt->execute()){
            $count = $stmt->rowCount();
            if($count > 0){
                echo "1";
            }else{
                echo "0";
            }

        }else{
            echo($stmt->errorInfo());
        }
    }
?>