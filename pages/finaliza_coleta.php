<?php
    session_start();
    require 'init.php';

    $id_coleta =  $_POST['id_coleta'];
    $PDO = db_connect();
    
    $sql = "UPDATE coleta_andamento SET status = 'FINALIZADA' 
            WHERE id_coleta = :id_coleta";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id_coleta', $id_coleta);

    if($stmt->execute()){
        echo "1";
    }else{
        echo "0";
    }

?>