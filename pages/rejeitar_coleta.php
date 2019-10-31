<?php
    session_start();
    require 'init.php';

    $id_solicitacao =  $_POST['id_solicitacao'];
    $PDO = db_connect();
    
    $sql = "UPDATE solicitacoes set situacao = 'REJEITADA'
            WHERE id_solicitacao = :id_solicitacao";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id_solicitacao', $id_solicitacao);
    
    if($stmt->execute()){
       echo "1";
    }else{
        var_dump($stmt->errorInfo());
    }
?>