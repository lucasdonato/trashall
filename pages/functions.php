<?php
 
        function db_connect()
        {
            $PDO = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS)or die(mysql_error());
        
            return $PDO;
        }

        function make_hash($str)
        {
            return sha1(md5($str));
        }

        function inserirContatoCondominio($contato,$id_condominio){
                $PDO = db_connect();
                //insere contato
                $sql = "INSERT INTO contato(tipo,descricao,id_condominio) 
                VALUES('EMAIL',:descricao,:id_condominio)";
                $stmt = $PDO->prepare($sql);
                $stmt->bindParam(':descricao', $contato);
                $stmt->bindParam(':id_condominio', $id_condominio); 

                if(!$stmt->execute()){
                    echo($stmt->errorInfo());
                }
        }

        function inserirEnderecoCondominio($cep,$logradouro,$numero,$bairro,$cidade,$id_condominio){
            $PDO = db_connect();
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

            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
        }

        function desativaUsuario($email_usuario){
            $PDO = db_connect();
            $sql = "UPDATE login SET ativo = '0' WHERE usuario = :email_usuario";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':email_usuario', $email_usuario);
            if(!$stmt->execute()){
                echo($stmt->errorInfo());
            }
        }
        
?>