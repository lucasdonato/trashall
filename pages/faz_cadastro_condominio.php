<?php
    session_start();

    require 'init.php';
    if (isset($_POST['txtNomeCondominio'])) {

        /*RECUPERA OS DADOS DO FORM*/
        $nome = $_POST['txtNomeCondominio'];
        $email_usuario = $_POST['txtEmailCondominio'];
        $cep = $_POST['txtCepCondominio'];
        $logradouro = $_POST['txtLogradouroCondominio'];
        $numero = $_POST['txtNumeroCondominio'];
        $bairro = $_POST['txtBairroCondominio'];
        $cidade = $_POST['txtCidadeCondominio'];
        $contato =  $_POST['txtEmailCondominio'];
       
        $PDO = db_connect();
    
        $sql = "INSERT INTO coletor_empresa(nome_empresa,data_cadastro) VALUES(:nome,NOW())";
        $stmt = $PDO->prepare($sql);
        
        $stmt->bindParam(':nome', $nome);

        if($stmt->execute()){
            $condominio = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo $sql;
            
        }else{
            
            print_r($stmt->errorInfo());
        }        
        
        /*if (count($condominio) <= 0)
        {
            echo "0";
        
        }else{
      
            echo "1";
        }*/
    }

?>