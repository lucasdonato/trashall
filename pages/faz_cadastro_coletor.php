<?php
    session_start();

    require 'init.php';
    if (isset($_POST['txtEmailColetor'])) {

        /*RECUPERA OS DADOS DO FORM*/
        $nome               = $_POST['txtNomeColetor'];
        $email_usuario      = $_POST['txtEmailColetor'];
        $cep                = $_POST['txtCepColetor'];
        $logradouro         = $_POST['txtLogradouroColetor'];
        $numero             = $_POST['txtNumeroColetor'];
        $bairro             = $_POST['txtBairroColetor'];
        $cidade             = $_POST['txtCidadeColetor'];
        $contato            = $_POST['txtContatoColetor'];
        $senha              = $_POST['txtSenhaColetor'];

        $PDO = db_connect();
    
        $sql = "INSERT INTO login(usuario,senha,tipo_entidade) VALUES(:email,:senha,'COLETOR')";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':email', $email_usuario);
        $stmt->bindParam(':senha', $senha);
       
        if($stmt->execute()){

            //tenta inserir coletor
            $sql = "INSERT INTO coletor_empresa(nome_empresa,data_cadastro,login_usuario) VALUES(:nome,NOW(),:login_usuario)";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':login_usuario', $email_usuario);

            //se conseguiu inserir coletor
            if($stmt->execute()){
                //recupera o último id do coletor
                $id_coletor = $PDO->lastInsertId();
                
                //insere endereço coletor
                if($cep != "" &&  $logradouro != "" && $numero != "" && $bairro != "" && $cidade != ""){
                    inserirEnderecoColetor($cep,$logradouro,$numero,$bairro,$cidade,$id_coletor);
                }

                //insere contato coletor
                if($contato != ""){
                    inserirContatoColetor($contato,$id_coletor);
                }
                echo "1";   
            }
        }else{
            echo "0";
        }           
    }

?>