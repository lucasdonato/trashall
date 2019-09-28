<?php
    session_start();

    require 'init.php';
    if (isset($_POST['txtEmailCondominio'])) {

        /*RECUPERA OS DADOS DO FORM*/
        $nome               = $_POST['txtNomeCondominio'];
        $email_usuario      = $_POST['txtEmailCondominio'];
        $cep                = $_POST['txtCepCondominio'];
        $logradouro         = $_POST['txtLogradouroCondominio'];
        $numero             = $_POST['txtNumeroCondominio'];
        $bairro             = $_POST['txtBairroCondominio'];
        $cidade             = $_POST['txtCidadeCondominio'];
        $contato            = $_POST['txtContatoCondominio'];
        $senha              = $_POST['txtSenhaCondominio'];

        $PDO = db_connect();
    
        $sql = "INSERT INTO login(usuario,senha,tipo_entidade) VALUES(:email,:senha,'CC')";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':email', $email_usuario);
        $stmt->bindParam(':senha', $senha);
       
        if($stmt->execute()){
            echo "executou";
            echo $email_usuario;
            echo $senha;
        }else{
            
            print_r($stmt->errorInfo());
        }

        
       // $sql = "INSERT INTO coletor_empresa(nome_empresa,data_cadastro) VALUES(:nome,NOW())";
        //$stmt = $PDO->prepare($sql);
        
       // $stmt->bindParam(':nome', $nome);

       /* if($stmt->execute()){
            $condominio = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo $sql;
            
        }else{
            
            print_r($stmt->errorInfo());
        }   */     
        
        /*if (count($condominio) <= 0)
        {
            echo "0";
        
        }else{
      
            echo "1";
        }*/
    }

?>