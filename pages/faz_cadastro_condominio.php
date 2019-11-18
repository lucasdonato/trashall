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
        $estado             = $_POST['estado'];

        $PDO = db_connect();
    
        $sql = "INSERT INTO login(usuario,senha,tipo_entidade) VALUES(:email,:senha,'CONDOMINIO')";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':email', $email_usuario);
        $stmt->bindParam(':senha', $senha);
       
        if($stmt->execute()){

            //tenta inserir condominio
            $sql = "INSERT INTO condominio(nome_condominio,data_cadastro,login_usuario) VALUES(:nome,NOW(),:login_usuario)";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':login_usuario', $email_usuario);

            //se conseguiu inserir condominio
            if($stmt->execute()){
                //recupera o último id do condominio
                $id_condominio = $PDO->lastInsertId();
                
                //insere endereço condominio
                if($cep != "" &&  $logradouro != "" && $numero != "" && $bairro != "" && $cidade != ""){
                    inserirEnderecoCondominio($cep,$logradouro,$numero,$bairro,$cidade,$estado,$id_condominio);
                }

                //insere contato condominio
                if($contato != ""){
                    inserirContatoCondominio($contato,$id_condominio);
                }
                echo "1";   
            }
        }else{
            echo "0";
        }           
    }

?>