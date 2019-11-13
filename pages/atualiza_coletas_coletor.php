<?php
    session_start();
    require 'init.php';

    $situacao =  $_GET['situacao'];
    $PDO = db_connect();
    
    $sql = "SELECT*FROM coleta_andamento WHERE id_coletor = :id_coletor 
    AND status = :status";

    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id_coletor', $_SESSION['id_coletor']);
    $stmt->bindParam(':status', $_SESSION['situacao']);

    if($stmt->execute()){
        
    }else{
        echo "0";
    }
?>