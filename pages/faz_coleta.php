<?php
    session_start();
    require 'init.php';

    $id_solicitacao =  $_POST['id_solicitacao'];

    /*USA O ID DA SOLICITACAO PARA
    CRIAR UMA COLETA EM ANDAMENTO*/
    $PDO = db_connect();
    
    $sql = "SELECT*FROM solicitacoes WHERE id_solicitacao = :id_solicitacao";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id_solicitacao', $id_solicitacao);
    
    if($stmt->execute()){
        $dados_solicitacao = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /*PREPARA OS DADOS PARA INSERIR NA TABELA DE COLETA*/
        $id_coletor          =  $dados_solicitacao[0]['id_coletor'];
        $id_condominio       =  $dados_solicitacao[0]['id_condominio'];
        $id_solicitacao      =  $dados_solicitacao[0]['id_solicitacao'];
        $id_endereco_destino = recupera_id_endereco_condominio($id_condominio);


        /*INSERE REGISTRO NA TABELA COLETA*/
        $sql_coleta = "INSERT INTO coleta_andamento(status,data_coleta, id_endereco_destino, id_coletor,id_condominio,id_solicitacao)
                       VALUES('ABERTO',NOW(),:id_endereco,:id_coletor, :id_condominio, :id_solicitacao)"; 
        
        $stmt = $PDO->prepare($sql_coleta);        
        $stmt->bindParam(':id_endereco', $id_endereco_destino);
        $stmt->bindParam(':id_coletor', $id_coletor);
        $stmt->bindParam(':id_condominio', $id_condominio);
        $stmt->bindParam(':id_solicitacao', $id_solicitacao);
        
        $coleta = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($stmt->execute()){
            /*ALTERA O STATUS DA SOLICITAÇÃO PARA CONFIRMADA*/
            confirma_solicitacao($id_solicitacao);            
        }else{
            var_dump($stmt->errorInfo());
        }

    }
?>