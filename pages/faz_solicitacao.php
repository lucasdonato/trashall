<?php
        session_start();

        require 'init.php';
        
        if (isset($_POST['txtIdCondominio'])) {
            $id_coletor = $_POST['txtIdCondominio'];
        }      

        /*acontece undefined index somente se não selecionar nenhum material,
        mas, o campo será required no form;*/
        $material = $_POST['checkMaterial'];
        $material_solicitacao =  json_encode($material);   
        $peso_aproximado = $_POST['txtPesoAproximado']; 
        
        $PDO = db_connect();

       /*RECUPERA O ID DO CONDOMINIO PARA REALIZAR A
       SOLICITAÇÃO DA COLETA*/
        $sql_consulta_login_email = "SELECT id_condominio FROM condominio
                                     WHERE login_usuario = :login_usuario";

        $stmt = $PDO->prepare($sql_consulta_login_email);
        $stmt->bindParam(':login_usuario', $_SESSION['email']);
        $stmt->execute();
    
        if($stmt->execute()){ //se encontrou o id, vamos inserir na tabela de solicitações
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $id_condominio =  $users[0]['id_condominio'];

            $sql = "INSERT INTO solicitacoes(materiais_coletados,id_coletor,id_condominio,data_solicitacao,peso) 
                VALUES(:materiais_coletados,:id_coletor,:id_condominio,NOW(),:peso)";
            $stmt = $PDO->prepare($sql);
            
            /*define os parametros que serão enviados*/
            $stmt->bindParam(':materiais_coletados', $material_solicitacao);
            $stmt->bindParam(':id_coletor', $id_coletor);
            $stmt->bindParam(':id_condominio', $id_condominio );
            $stmt->bindParam(':peso', $peso_aproximado );
            if($stmt->execute()){
                /*retorna 1 para que seja tratado o 
                response do ajax*/
                echo "1";
            }else{
                var_dump($stmt->errorInfo());
            }
        }else{
            var_dump($stmt->errorInfo());
        }

?>