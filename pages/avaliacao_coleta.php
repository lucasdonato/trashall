<?php
    session_start();
    require 'init.php';

    $id_coleta_ratings =  $_POST['id_coleta_ratings'];
    $avaliacao = $_POST['avaliacao'];

    echo $avaliacao;

    /*SALVAR NA TABELA FEEDBACK*/
    $PDO = db_connect();
    
    $sql = "INSERT INTO feedback (id_coleta,avaliacao)
            VALUES(:id_coleta,:avaliacao)";
    $stmt = $PDO->prepare($sql);

    $stmt->bindParam(':id_coleta', $id_coleta_ratings);
    $stmt->bindParam(':avaliacao', $avaliacao);

    if($stmt->execute()){
        echo "1";
    }else{
        echo "0";
    }

  
?>