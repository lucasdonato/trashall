<?php
    session_start();

    require 'init.php';
    if (isset($_POST['txtPesoAproximado'])) {

        $peso_aproximado = $_POST['txtPesoAproximado'];



        $PDO = db_connect();
    
        $sql = "INSERT INTO solicitacoes(feita_por,id_coletor,id_empresa,data_solicitacao,peso) 
                VALUES()";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam();
        $stmt->bindParam();
        
        if($stmt->execute()){
            

        }
    }


?>