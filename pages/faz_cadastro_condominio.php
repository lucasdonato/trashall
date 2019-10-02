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
            $sql = "INSERT INTO condominio(nome_condominio,data_cadastro,login_usuario) VALUES(:nome,NOW(),:login_usuario)";
            $stmt = $PDO->prepare($sql);
            
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':login_usuario', $email_usuario);

            if($stmt->execute()){
                $id_condominio = $PDO->lastInsertId();
                //gravar nas tabelas endereço e contato
                $sql = "INSERT INTO endereco(logradouro,bairro,cidade,estado,numero,cep,id_condominio)
                    VALUES(:logradouro,:bairro,:cidade,:estado,:numero,:cep,:id_condominio)";
                
                $stmt = $PDO->prepare($sql);
                $stmt->bindParam(':logradouro', $logradouro);
                $stmt->bindParam(':bairro', $bairro);
                $stmt->bindParam(':cidade', $cidade);
                $stmt->bindParam(':estado', $estado);
                $stmt->bindParam(':numero', $numero);  
                $stmt->bindParam(':cep', $cep);
                $stmt->bindParam(':id_condominio', $id_condominio);  

                if($stmt->execute()){
                    echo "executou";
                }else{
                    echo "nao executou";
                }    

                //fazer o insert no contato
                

                echo "1";   
            }
        }else{
            echo "0";
        }     
        
    }

?>