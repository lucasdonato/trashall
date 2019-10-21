<?php
    session_start();

    require 'init.php';
    if (isset($_POST['txtPesoAproximado'])) {

        $peso_aproximado = $_POST['txtPesoAproximado'];
        $PDO = db_connect();

       /*RECUPERA O ID DO CONDOMINIO PARA REALIZAR A
       SOLICITAÇÃO DA COLETA*/
        $sql_consulta_login_email = "SELECT id_condominio FROM condominio
                                     WHERE login_usuario = :login_usuario";

        $stmt = $PDO->prepare($sql_consulta_login_email);
        $stmt->bindParam(':login_usuario', $_SESSION['email']);
        $stmt->execute();
    
        if($stmt->execute()){ //se encontrou o id, vamos inserir na tabela de solicitações
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo $users[0]['id_condominio'];

            $sql = "INSERT INTO solicitacoes(feita_por,id_coletor,id_empresa,data_solicitacao,peso) 
                VALUES()";
            $stmt = $PDO->prepare($sql);
        }


       /* 
        
        //$stmt->bindParam();
        //$stmt->bindParam();
        
        if($stmt->execute()){

            echo "execou essa merda";
        }*/
    }


?>